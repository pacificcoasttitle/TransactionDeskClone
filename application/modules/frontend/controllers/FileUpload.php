<?php
(defined('BASEPATH')) or exit('No direct script access allowed');
class FileUpload extends MX_Controller
{
    private $user;
    private $sorting_fields;
    private $js_version = '02.01';
    private $max_file_size = 102000; // 100MB in KB
    private $allowed_file_types = ['pdf'];
    private $upload_path = './uploads/lender-parsing-docs/';

    public function __construct()
    {
        parent::__construct();
        $userdata = $this->session->userdata('user');
        // print_r($userdata);die;
        
        $this->user = $userdata;

        $this->load->library('order/salesDashboardTemplate');
        $this->load->model('order/fileDocument_model');
        $this->load->library('order/order');
        $this->load->library('order/softPro');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $userdata = $this->session->userdata('user');
        $this->load->library('order/common_lib');
        $this->common_lib->checkFileUploadAccess();
        if (empty($userdata) || !isset($userdata['is_title_production']) || $userdata['is_title_production'] != 1) {
            redirect('/dashboard');
        }
        $data['title'] = 'Reports | Pacific Coast Title Company';
        
        if (isset($_POST) && !empty($_POST)) {
            $this->form_validation->set_rules('order_number', 'Order Number', 'required', array('required' => 'Enter your order number'));
            $this->form_validation->set_rules('document_name', 'Last Document Name', 'required', array('required' => 'Enter your document name'));
            if ($this->form_validation->run($this) == true) {
                $this->load->model('order/apiLogs');
                $config['upload_path'] = './uploads/desk-file-upload/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 12000;
                $this->load->library('upload', $config);
                $file_path = FCPATH . 'uploads/desk-file-upload/';
                if (!is_dir($file_path)) {
                    mkdir($file_path, 0777, true);
                }
                $orderNumber = $this->sanitizeFilename($this->input->post('order_number'));
                $documentName = $this->sanitizeFilename($this->input->post('document_name'));
                if (!empty($_FILES['multiFiles']['name'])) {
                    $files = $_FILES['multiFiles'];
                    $cpt = count($files['name']);
                    $fileList = [];
                    for ($i = 0; $i < $cpt; $i++) {
                        $name = time() . $files['name'][$i];
                        $_FILES['multiFiles_single']['name'] = $name;
                        $_FILES['multiFiles_single']['type'] = $files['type'][$i];
                        $_FILES['multiFiles_single']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['multiFiles_single']['error'] = $files['error'][$i];
                        $_FILES['multiFiles_single']['size'] = $files['size'][$i];
                        $this->upload->initialize($config);
                        if (!($this->upload->do_upload('multiFiles_single'))) {
                            $errorMsg = $this->upload->display_errors();
                            $this->session->set_flashdata('error', $errorMsg);
                            $file_upload_error_msg = 1;
                        } else {
                            $data = $this->upload->data();
                            $fileName = $documentName . '_' . time() . '.pdf';

                            $saveData = array(
                                'name' => $documentName,
                                'order_number' => $orderNumber,
                                'file_path' => $fileName,
                                'added_by' => $this->user['id'],
                                'is_desk_file' => 1,
                                'created_at' => date('Y-m-d H:i:s'),
                            );
                            $id = $this->fileDocument_model->insert($saveData);
                            rename($config['upload_path'] . $data['file_name'], $config['upload_path'] . $fileName);
                            $this->order->uploadDocumentOnAwsS3($fileName, 'desk-file-upload');
                            $fileList[] = [
                                "FolderName" => 'desk-file-upload',
                                "FileURL" => env('AWS_PATH') . "desk-file-upload/" . $fileName,
                            ];
                        }
                        $logData = [
                            'order_number' => $orderNumber,
                            'document_name' => $documentName,
                            'file_list' => json_encode($fileList)
                        ];
                        
                        $fileUploadLogId = $this->order->save_sp_file_upload_log($logData);

                        $fileData = [
                            "Id" => $fileUploadLogId,
                            "OrderNumber" => $orderNumber,
                            "DocumentName" => $documentName,
                            "FileList" => $fileList,
                        ];
                        $fileUploadReq[] = $fileData;
                        $reqData = json_encode($fileUploadReq);
                        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'upload_document', 'upload_document', $reqData, [], 0, 0);
                        $result = $this->softpro->make_request('POST', 'upload_document', $reqData);
                        $response = json_decode($result, true);
                        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'upload_document', 'upload_document', $reqData, json_encode($response), 0, $logid);

                        if (isset($response) && !empty($response)) {
                            foreach ($response as $key => $res) {
                                if ($res['Status'] == 200) {
                                    $updateData[] = [
                                        'is_synced' => 1,
                                        'id' => $res['Id']
                                    ];
                                    $this->session->set_flashdata('success', 'Document info saved successfully.');
                                } else {
                                    if ((strpos(strtolower($res['Message']), "locked for editing by user") !== false)) {
                                        $is_synced = 0;
                                        $this->session->set_flashdata('success', 'Document info saved successfully.');
                                    } else {
                                        $is_synced = 1;
                                        $this->session->set_flashdata('error', $res['Message']);
                                    }
                                    $updateData[] = [
                                        'is_synced' =>  $is_synced,
                                        'id' => $res['Id'],
                                        'reason' => $res['Message']
                                    ];
                                }
                            }
                        }

                        foreach ($updateData as $key => $update_row) {
                            $this->db->where('id', $update_row['id']);
                            $this->db->update('sp_file_upload_logs', $update_row);
                        }
                        /* Start add softpro api logs */
                        $reswareData = array(
                            'request_type' => 'upload_file_in_softpro',
                            'request_url' => 'upload_file',
                            'request' => $reqData,
                            'response' => $result,
                            'status' => '',
                            'file_number' => $orderNumber,
                            'created_at' => date("Y-m-d H:i:s"),
                        );
                        $this->db->insert('pct_resware_log', $reswareData);
                        // $successMsg = 'Document info saved successfully.';
                        // $this->session->set_flashdata('success', $successMsg);
                        // echo "<pre>";
                        // print_r($response);die;
                        /* End add softpro api logs */
                    }

                    // if (!empty($_FILES['file-input']['name'])) {
                    // if (!$this->upload->do_upload('file-input')) {
                    //     $errorMsg = $this->upload->display_errors();
                    //     $this->session->set_flashdata('error', $errorMsg);
                    //     $file_upload_error_msg = 1;
                    // } else {
                    //     $data = $this->upload->data();
                    //     $orderNumber = $this->input->post('order_number');
                    //     $documentName = $this->input->post('document_name');
                    //     $fileName = $orderNumber . '_' . time() . '.pdf';

                    //     $saveData = array(
                    //         'name' => $documentName,
                    //         'order_number' => $orderNumber,
                    //         'file_path' => $fileName,
                    //         'added_by' => $this->user['id'],
                    //         'is_desk_file' => 1,
                    //     );
                    // $id = $this->fileDocument_model->insert($saveData);
                    // rename(FCPATH . "/uploads/desk-file-upload/" . $data['file_name'], FCPATH . "/uploads/desk-file-upload/" . $fileName);
                    // $this->order->uploadDocumentOnAwsS3($fileName, 'desk-file-upload');

                    // /** Save user Activity */
                    // $activity = 'New document uploaded for order : ' . $orderNumber . ' Name :' . $documentName;
                    // $this->order->logAdminActivity($activity);
                    // /** End Save user activity */

                    // }
                } else {
                    $errMsg = 'Please upload file.';
                    $this->session->set_flashdata('error', $errMsg);
                }

            } else {
                $errMsg = validation_errors();
                $this->session->set_flashdata('error', $errMsg);
            }

        }
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/order/upload_doc_orders.js?v=pma_' . $this->js_version));
        $this->salesdashboardtemplate->show("file-upload", "index", $data);
    }

    public function getUploadedDeskDoc()
    {
        if (empty($this->session->userdata('user'))) {
            redirect(base_url() . 'order');
        }
        $params = array();
        $data = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length']) + 1;
            $file_lists = $this->fileDocument_model->get_uploaded_documents_list($params);
            $json_data['draw'] = intval($params['draw']);
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $file_lists = $this->fileDocument_model->get_uploaded_documents_list($params);
        }

        if (isset($file_lists['data']) && !empty($file_lists['data'])) {
            $i = $params['start'] + 1;
            foreach ($file_lists['data'] as $order) {
                $nestedData = array();
                $nestedData[] = $i;
                $nestedData[] = $order['name'];
                $nestedData[] = $order['order_number'];
                $nestedData[] = convertTimezone($order['created_at']);
                $documentUrl = env('AWS_PATH') . "desk-file-upload/" . $order['file_path'];
                $nestedData[] = "<div class='table-action'>
                                <a href='" . $documentUrl . "' target='_blank'>
									<button type='submit' class='btn btn-success btn-icon-split'>
										<span class='icon text-white-50'>
											<i class='fas fa-file'></i>
										</span>
										<span class='text'>View Document</span>
									</button>
								</a>
                                <button type='submit' onclick='copyLink(" . '"' . $documentUrl . '"' . ", this)' class='btn btn-success btn-icon-split'>
                                    <span class='icon text-white-50'>
                                        <i class='fas fa-copy'></i>
                                    </span>
                                    <span class='text'>Copy Link</span>
                                </button>
                                </div>";
                $data[] = $nestedData;
                $i++;
            }
        }
        $json_data['recordsTotal'] = intval($file_lists['recordsTotal']);
        $json_data['recordsFiltered'] = intval($file_lists['recordsFiltered']);
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    function sanitizeFilename($filename) {
        // Remove or replace common illegal characters
        $filename = preg_replace('/[\/:*?"<>|\\\]/', '', $filename); // Windows illegal characters
        $filename = str_replace(["\t", "\n", "\r"], '', $filename); // Remove tab, newlines, and carriage returns
    
        return trim($filename);
    }

    function getPageRangeByDocType(array $chunks, string $docType): ?array
    {
        foreach ($chunks as $chunk) {
            if ($chunk['doc_type'] === $docType) {
                return [
                    'start_page' => $chunk['start_page'],
                    'end_page'   => $chunk['end_page'],
                ];
            }
        }
        return null; // not found
    }
    public function lenderPursing()
    {
        $this->validateAccessAndSetEnvironment();
        $data['title'] = 'Lender Document Processing | Pacific Coast Title Company';

        if ($this->input->post()) {
            try {
                $this->processLenderDocumentSubmission();
            } catch (Exception $e) {
                $this->handleError($e->getMessage());
            }
        }

        $this->loadView($data);
    }

    private function validateAccessAndSetEnvironment()
    {
        $this->load->library('order/common_lib');
        $this->common_lib->checkLenderParseAccess();
        
        // Set PHP configurations for large file handling
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '100M');
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '256M');

        $this->load->library('order/chatGPT');
        $this->load->library('order/ocrService');
        $this->load->library('order/pdfSplitter');
        $this->load->model('order/apiLogs');
    }

    private function processLenderDocumentSubmission()
    {
        $this->validateFormInput();
        $documentData = $this->processUploadedFile();
        
        if ($documentData) {
            $this->processDocumentContent($documentData);
            $this->session->set_flashdata('success', 'Lender document processed successfully.');
        }
    }

    private function validateFormInput()
    {
        $this->form_validation->set_rules('order_number', 'Order Number', 'required|trim');
        $this->form_validation->set_rules('document_name', 'Document Name', 'required|trim');

        if ($this->form_validation->run() === false) {
            throw new Exception(validation_errors());
        }
    }

    private function processUploadedFile()
    {
        $this->validateFileUpload();
        
        $orderNumber = $this->sanitizeFilename($this->input->post('order_number'));
        $documentName = $this->sanitizeFilename($this->input->post('document_name'));

        $this->ensureUploadDirectoryExists();
        
        return $this->handleFileUpload($orderNumber, $documentName);
    }

    private function validateFileUpload()
    {
        if (empty($_FILES['multiFiles']['name'])) {
            throw new Exception('Please upload a file.');
        }

        $fileInfo = pathinfo($_FILES['multiFiles']['name']);
        if (!in_array(strtolower($fileInfo['extension']), $this->allowed_file_types)) {
            throw new Exception('Invalid file type. Only PDF files are allowed.');
        }

        if ($_FILES['multiFiles']['size'] > $this->max_file_size * 1024) {
            throw new Exception('File size exceeds maximum limit of 100MB.');
        }
    }

    private function handleFileUpload($orderNumber, $documentName)
    {
        $config = [
            'upload_path' => $this->upload_path,
            'allowed_types' => implode('|', $this->allowed_file_types),
            'max_size' => $this->max_file_size,
            'file_name' => $documentName . '_' . time() . '.pdf'
        ];

        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('multiFiles')) {
            throw new Exception($this->upload->display_errors());
        }

        $uploadData = $this->upload->data();
        $this->saveDocumentRecord($orderNumber, $documentName, $config['file_name']);
        $this->documentFilePath = $config['upload_path'] . $config['file_name'];
        $fileData =  [
            'orderNumber' => $orderNumber,
            'documentName' => $documentName,
            'fileName' => $config['file_name'],
            'filePath' => $config['upload_path'] . $config['file_name']
        ];
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'lender_parse_file_uploaded', 'lender_parse_file_uploaded', json_encode($fileData), [], 0, 0);
        return $fileData;
    }

    private function saveDocumentRecord($orderNumber, $documentName, $fileName)
    {
        $saveData = [
            'name' => $documentName,
            'order_number' => $orderNumber,
            'file_path' => $fileName,
            'added_by' => $this->user['id'],
            'is_parsed_file' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('pct_lender_parsing_document', $saveData);
        return $this->db->insert_id();
    }

    private function ensureUploadDirectoryExists()
    {
        $file_path = FCPATH . $this->upload_path;
        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, true);
        }
    }

    private $documentFilePath;
    private function processDocumentContent($documentData)
    {
        try {
            // Process OCR
            $ocrResults = $this->processDocumentOCR($documentData['filePath']);
            $ocrResults = $ocrResults['pageTexts'];
            // echo "<pre>";
            // echo '-------------OCR Results------------------';
            // print_r($ocrResults);
            // echo '-------------Analysis Results------------------';
            // Analyze document content
            $analysisResults = $this->analyzeDocumentContent($ocrResults);
            // print_r($analysisResults);
            // Update order information
            $this->updateOrderInformation($ocrResults, $analysisResults, $documentData['orderNumber']);
            
            // Split and upload documents
            $fileList = $this->processDocumentSplitting($documentData, $analysisResults);
            
            // Sync with SoftPro
            $this->syncWithSoftPro($documentData, $fileList);
            
            // Clean up temporary files
            $this->cleanupTemporaryFiles($documentData['filePath']);
            
        } catch (Exception $e) {
            $this->cleanupTemporaryFiles($this->documentFilePath);
            throw new Exception('Error processing document: ' . $e->getMessage());
        }
    }

    private function processDocumentOCR($filePath)
    {
        $pdfPath = FCPATH . $filePath;
        $pageTexts = $this->ocrservice->process_pdf($pdfPath);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'lender_parse_ocr_process', 'lender_parse_ocr_process', $pdfPath, [], 0, 0);
        // $firstPageText = $this->ocrservice->first_page_text($pdfPath);

        return [
            'pageTexts' => $pageTexts
            // 'firstPageText' => $firstPageText
        ];
    }

    private function analyzeDocumentContent($ocrResults)
    {
        // Analyze first page
        // $firstPageAnalysis = $this->chatgpt->classify($ocrResults['firstPageText']);
        // $firstPageContent = json_decode($firstPageAnalysis['choices'][0]['message']['content'], true);

        // Analyze all pages
        $documentPageRange = $this->chatgpt->classifyAllPage(json_encode($ocrResults));
        // echo '-------------Document Page Range------------------';
        // print_r($documentPageRange);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'lender_parse_open_ai', 'lender_parse_open_ai', 'all_page_analyze', json_encode($documentPageRange), 0, 0);
        $documentPageRange = preg_replace('/```json|```/', '', $documentPageRange['choices'][0]['message']['content']);
        $pageRange = json_decode($documentPageRange, true);

        return [
            // 'firstPageContent' => $firstPageContent,
            'pageRange' => $pageRange
        ];
    }

    private function updateOrderInformation($ocrResults, $analysisResults, $orderNumber)
    {
        $lenderDocRange = $this->getPageRangeByDocType($analysisResults['pageRange'], 'lender_instructions');
        // echo '-------------Lender Doc Range------------------';
        // print_r($lenderDocRange);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'lender_parse_lender_page_range', 'lender_parse_lender_page_range', json_encode($analysisResults['pageRange']), json_encode($lenderDocRange), 0, 0);
        if (!$lenderDocRange) {
            $this->cleanupTemporaryFiles($this->documentFilePath);
            throw new Exception('Failed to extract lender document.');
        }
        // print_r($ocrResults);
        // echo "<br>";

        // print_r($lenderDocRange['start_page']);
        // echo "<br>";
        // print_r($lenderDocRange['end_page']);
        // echo "<br>";
        $lenderPages = array_slice($ocrResults, $lenderDocRange['start_page'], $lenderDocRange['end_page']);
        // echo '-------------Lender Pages------------------';
        // print_r($lenderPages);

        $logId = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'lender_parse_openai_lender_details', 'lender_parse_openai_lender_details', 'lender_document_pages', null, 0, 0);
        $lenderDetails = $this->chatgpt->getLenderDetails(json_encode($lenderPages));
        $lenderDetails = json_decode($lenderDetails['choices'][0]['message']['content'], true);
        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'lender_parse_openai_lender_details', 'lender_parse_openai_lender_details', 'lender_document_pages', json_encode($lenderDetails), 0, $logId);
        // $lenderDetails = json_decode($lenderDetails, true);
        // echo '-------------Lender Details------------------';
        // print_r($lenderDetails);
        // echo '-------------Lender Details Decoded------------------';
        // print_r($lenderDetails);
        if (!isset($lenderDetails['lender_package'])) {
            $this->cleanupTemporaryFiles($this->documentFilePath);
            throw new Exception('Failed to extract lender details.');
        }

        $orderUpdate = $this->prepareOrderUpdateData($lenderDetails['lender_package'], $orderNumber);
        $this->syncOrderUpdate($orderUpdate);
    }

    private function prepareOrderUpdateData($lenderPackage, $orderNumber)
    {
        $orderUpdate = ['orderNumber' => $orderNumber];

        // Process lender information
        if (isset($lenderPackage['lender_name'])) {
            $lenderName = $lenderPackage['lender_name'];
            $lendersData = array_map('trim', explode(',', $lenderName));
            $lenderNameArray = $this->order->splitFullName($lendersData[0]);
            // $lenderNameArray = $this->order->splitFullName($lenderPackage['lender_name']);
            $orderUpdate['userModel'] = [
                'FullName' => $lenderName,
                'FirstName' => $lenderNameArray['first_name'],
                'MiddleName' => $lenderNameArray['middle_name'],
                'LastName' => $lenderNameArray['last_name']
            ];
        }

        // Process borrower information
        if (isset($lenderPackage['borrowers'][0])) {
            $borrowersData = array_map('trim', explode(',', $lenderPackage['borrowers'][0]));
            $this->processBorrowerInformation($orderUpdate, $borrowersData);
        }

        // Process loan details
        $this->processLoanDetails($orderUpdate, $lenderPackage);

        // Process endorsements
        if (isset($lenderPackage['endorsements'])) {
            $orderUpdate['endorsements'] = $lenderPackage['endorsements'];
        }

        return $orderUpdate;
    }

    private function processLoanDetails(&$orderUpdate, $lenderPackage)
    {
        $loanDetails = [];
        
        if (isset($lenderPackage['loan_number'])) {
            $loanDetails['loanNumber'] = $lenderPackage['loan_number'];
        }
        if (isset($lenderPackage['loan_amount'])) {
            $loanDetails['loanAmount'] = $lenderPackage['loan_amount'];
        }
        if (isset($lenderPackage['coverage_amount'])) {
            $loanDetails['coverageAmount'] = $lenderPackage['coverage_amount'];
        }

        if (!empty($loanDetails)) {
            $orderUpdate['loanDetails'] = $loanDetails;
        }
    }

    private function processBorrowerInformation(&$orderUpdate, $borrowersData)
    {
        $primaryBorrowerArray = $this->order->splitFullName($borrowersData[0]);
        $orderUpdate['PrimaryBorrowerFirstName'] = $primaryBorrowerArray['first_name'];
        $orderUpdate['PrimaryBorrowerMiddleName'] = $primaryBorrowerArray['middle_name'];
        $orderUpdate['PrimaryBorrowerLastName'] = $primaryBorrowerArray['last_name'];

        if (count($borrowersData) > 1) {
            $secondaryBorrowerArray = $this->order->splitFullName($borrowersData[1]);
            $orderUpdate['SecondaryBorrowerFirstName'] = $secondaryBorrowerArray['first_name'];
            $orderUpdate['SecondaryBorrowerMiddleName'] = $secondaryBorrowerArray['middle_name'];
            $orderUpdate['SecondaryBorrowerLastName'] = $secondaryBorrowerArray['last_name'];
        }
    }

    private function syncOrderUpdate($orderUpdate)
    {
        $orderData = json_encode($orderUpdate);
        $logid = $this->apiLogs->syncLogs($this->user['id'], 'softpro', 'update_order', 'update_order', $orderData, [], 0, 0);
        $response = $this->softpro->make_request('POST', 'update_order', $orderData, $this->user);
        
        $this->apiLogs->syncLogs($this->user['id'],'softpro','update_order','update_order',$orderData,json_encode($response),0,$logid);

        if (!isset($response['status']) || $response['status'] !== 'success') {
            $this->cleanupTemporaryFiles($this->documentFilePath);
            throw new Exception('Failed to update order information');
        }
    }

    private function processDocumentSplitting($documentData, $analysisResults)
    {
        $fileList = [];
        $pdfPath = FCPATH . $documentData['filePath'];

        foreach ($analysisResults['pageRange'] as $doc) {
            if ($this->shouldProcessDocument($doc)) {
                $docName = $this->generateDocumentName($documentData['orderNumber'], $doc['doc_type']);
                $outputPath = FCPATH . $this->upload_path . $docName;

                $this->pdfsplitter->splitByRange($pdfPath, $doc['start_page'], $doc['end_page'], $outputPath);
                $this->order->uploadDocumentOnAwsS3($docName, 'lender-parsing-docs');

                $fileList[] = [
                    "FolderName" => 'lender-parsing-docs',
                    "FileURL" => env('AWS_PATH') . "lender-parsing-docs/" . $docName
                ];

                $this->saveDocumentRecord($documentData['orderNumber'], $doc['doc_type'], $docName);
            }
        }

        return $fileList;
    }

    private function shouldProcessDocument($doc)
    {
        return $doc['doc_type'] !== 'other' 
            && $doc['doc_type'] !== 'unknown' 
            && isset($doc['start_page']) 
            && isset($doc['end_page'])
            && $doc['start_page'] > 0 
            && $doc['end_page'] > 0;
    }

    private function generateDocumentName($orderNumber, $docType)
    {
        return $orderNumber . '_' . time() . '_' . $docType . '.pdf';
    }

    private function syncWithSoftPro($documentData, $fileList)
    {
        // Upload original document to S3
        $this->order->uploadDocumentOnAwsS3($documentData['fileName'], 'lender-parsing-docs');

        // Create log entry
        $logData = [
            'order_number' => $documentData['orderNumber'],
            'document_name' => $documentData['documentName'],
            'file_list' => json_encode($fileList)
        ];

        $fileUploadLogId = $this->order->save_sp_file_upload_log($logData);

        // Prepare data for SoftPro
        $fileData = [
            "Id" => $fileUploadLogId,
            "OrderNumber" => $documentData['orderNumber'],
            "DocumentName" => $documentData['documentName'],
            "FileList" => $fileList,
        ];

        // Sync with SoftPro
        $this->uploadToSoftPro($fileData);
    }

    private function uploadToSoftPro($fileData)
    {
        $reqData = json_encode([$fileData]);
        $logid = $this->apiLogs->syncLogs($this->user['id'],'softpro','upload_document','upload_document',$reqData,[],0,0);

        $result = $this->softpro->make_request('POST', 'upload_document', $reqData);
        $response = json_decode($result, true);

        $this->apiLogs->syncLogs($this->user['id'],'softpro','upload_document','upload_document',$reqData,json_encode($response),0,$logid);

        $this->processSoftProResponse($response);
    }

    private function processSoftProResponse($response)
    {
        if (!empty($response)) {
            foreach ($response as $res) {
                $updateData = [
                    'id' => $res['Id'],
                    'is_synced' => $res['Status'] == 200 ? 1 : 0,
                    'reason' => $res['Status'] != 200 ? $res['Message'] : null
                ];

                $this->db->where('id', $updateData['id']);
                $this->db->update('sp_file_upload_logs', $updateData);
            }
        }
    }

    private function handleError($message)
    {
        $this->session->set_flashdata('error', $message);
    }

    private function loadView($data)
    {
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/order/upload_doc_orders.js?v=' . $this->js_version));
        $this->salesdashboardtemplate->show("lender-parse", "index", $data);
    }

    // private function sanitizeFilename($filename)
    // {
    //     return preg_replace('/[\/:*?"<>|\\\]/', '', trim($filename));
    // }

    private function cleanupTemporaryFiles($filePath)
    {
        if (file_exists(FCPATH . $filePath)) {
            unlink(FCPATH . $filePath);
        }
    }


    public function lenderPursings()
    {
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '100M');
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '256M');
        // print_r(PHP_OS_FAMILY);die;
        $this->load->library('order/common_lib');
        $this->common_lib->checkLenderParseAccess();
        $this->load->library('order/chatGPT');
        $userdata = $this->session->userdata('user');
        $data['title'] = 'Reports | Pacific Coast Title Company';
        $orderReq = [];
        // echo "<pre>";
        // print_r($_FILES);die;
        if (isset($_POST) && !empty($_POST)) {
            $this->form_validation->set_rules('order_number', 'Order Number', 'required', array('required' => 'Enter your order number'));
            $this->form_validation->set_rules('document_name', 'Last Document Name', 'required', array('required' => 'Enter your document name'));
            if ($this->form_validation->run($this) == true) {
                $this->load->model('order/apiLogs');
                $config['upload_path'] = './uploads/lender-parsing-docs/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 102000;
                $this->load->library('upload', $config);
                $file_path = FCPATH . 'uploads/lender-parsing-docs/';
                if (!is_dir($file_path)) {
                    mkdir($file_path, 0777, true);
                }
                $orderNumber = $this->sanitizeFilename($this->input->post('order_number'));
                $documentName = $this->sanitizeFilename($this->input->post('document_name'));
                if (!empty($_FILES['multiFiles']['name'])) {
                    $this->load->library('order/ocrService');
                    $files = $_FILES['multiFiles'];
                    // $cpt = count($files['name']);
                    $fileList = [];
                    // for ($i = 0; $i < $cpt; $i++) {
                    $name = time() . $files['name'];
                    $_FILES['multiFiles_single']['name'] = $name;
                    $_FILES['multiFiles_single']['type'] = $files['type'];
                    $_FILES['multiFiles_single']['tmp_name'] = $files['tmp_name'];
                    $_FILES['multiFiles_single']['error'] = $files['error'];
                    $_FILES['multiFiles_single']['size'] = $files['size'];
                    $this->upload->initialize($config);
                    if (!($this->upload->do_upload('multiFiles_single'))) {
                    // if (false) {
                        $errorMsg = $this->upload->display_errors();
                        $this->session->set_flashdata('error', $errorMsg);
                        $file_upload_error_msg = 1;
                    } else {
                        $data = $this->upload->data();
                        $fileName = $documentName . '_' . time() . '.pdf';
                        // $fileName = 'File Upload_1765446957.pdf';
                        $saveData = array(
                            'name' => $documentName,
                            'order_number' => $orderNumber,
                            'file_path' => $fileName,
                            'added_by' => $this->user['id'],
                            'is_parsed_file' => 0,
                            'created_at' => date('Y-m-d H:i:s'),
                        );
                    // $id = $this->fileDocument_model->insert($saveData);
                        $this->db->insert('pct_lender_parsing_document', $saveData);
                        // $id = $this->db->insert_id();
                        
                        rename($config['upload_path'] . $data['file_name'], $config['upload_path'] . $fileName);
                        
                        $pdfPath = FCPATH . $config['upload_path'] . $fileName;
                                                
                        $pageTexts = $this->ocrservice->process_pdf($pdfPath);
                        
                        // echo "<pre>";
                        // print_r('Total Pages OCRed: ' . count($pageTexts));
                        // echo '<pre>------------------Full Text------------------';
                        // print_r($pageTexts);
                        $firstPageText = $this->ocrservice->first_page_text($pdfPath);
                        
                        // print_r('First Page Text: ' . $firstPageText);
                        

                        // echo "<br><br><br><br><br>";
                        // $classifyFirstPage = $this->chatgpt->classify($firstPageText);
                        // echo '<pre>------------------First Page TOC and Page range using open ai------------------';
                        $classifyFirstPage = $this->chatgpt->classify($firstPageText);
                        // print_r($classifyFirstPage);
                        $firstPageContent = $classifyFirstPage['choices'][0]['message']['content'] ?? null;
                        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'lender_parse_open_ai', 'lender_parse_open_ai', 'pdf_first_page', $firstPageContent, 0, 0);
                        $firstPageContent = json_decode($firstPageContent, true);
                        // print_r($firstPageContent);
                        // echo "<br><br><br><br><br>";
                        
                        
                        // echo 'result :';
                        $documentPageRange = $this->chatgpt->classifyAllPage(json_encode($pageTexts));
                        // print_r($documentPageRange); 
                        $documentPageRange = $documentPageRange['choices'][0]['message']['content'] ?? null;
                        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'lender_parse_open_ai', 'lender_parse_open_ai', 'pdf_all_page', $documentPageRange, 0, 0);
                        // echo "<br><br><br><br><br>";
                        $documentPageRange = preg_replace('/```json|```/', '', $documentPageRange);
                        // echo "<br><br><br><br><br>";
                        $pageRange = json_decode($documentPageRange, true);
                        // echo '<pre>------------------Document Page Range using open ai------------------';
                        // print_r($pageRange); 
                        $lenderDocRange = $this->getPageRangeByDocType($pageRange, 'lender_instructions');
                        if (!empty($lenderDocRange) && !empty($lenderDocRange['start_page']) && !empty($lenderDocRange['end_page'])) {
                            $startPage = $lenderDocRange['start_page'];
                            $endPage = $lenderDocRange['end_page'];
                            $lenderPages = array_slice($pageTexts, $startPage, $endPage);
                            $lenderInstructionExtraction = $this->chatgpt->getLenderDetails(json_encode($lenderPages));
                            // echo '<pre>------------------Lender Instruction Extraction------------------';
                            $lenderInstructionExtraction = $lenderInstructionExtraction['choices'][0]['message']['content'] ?? null;
                            $lenderInstructionExtraction = json_decode($lenderInstructionExtraction, true);
                            // print_r($lenderInstructionExtraction);
                        }

                        if (isset($lenderInstructionExtraction['lender_package'])) {
                            $orderReq['orderNumber'] = $orderNumber;
                            $lenderPackage = $lenderInstructionExtraction['lender_package'];
                            if (isset($lenderPackage['lender_name'])) {
                                $lenderName = $lenderPackage['lender_name'];
                                $lendersData = array_map('trim', explode(',', $lenderName));
                                $lenderNameArray = $this->order->splitFullName($lendersData[0]);
                                $orderReq['userModel']['FullName'] = $lenderName;
                                $orderReq['userModel']['FirstName'] = $lenderNameArray['first_name'];
                                $orderReq['userModel']['MiddleName'] = $lenderNameArray['middle_name'];
                                $orderReq['userModel']['LastName'] = $lenderNameArray['last_name'];
                            }
                            if (isset($lenderPackage['borrowers']) && !empty($lenderPackage['borrowers'])) {
                                $borrowers = $lenderPackage['borrowers'][0];
                                $borrowersData = array_map('trim', explode(',', $borrowers));
                                $primaryBorrowerArray = $this->order->splitFullName($borrowersData[0]);
                                $orderReq['PrimaryBorrowerFirstName'] = $primaryBorrowerArray['first_name'];
                                $orderReq['PrimaryBorrowerMiddleName'] = $primaryBorrowerArray['middle_name'];
                                $orderReq['PrimaryBorrowerLastName'] = $primaryBorrowerArray['last_name'];
                                if (count($borrowersData) > 1) {
                                    $secondaryBorrowerArray = $this->order->splitFullName($borrowersData[1]);
                                    $orderReq['SecondaryBorrowerFirstName'] = $secondaryBorrowerArray['first_name'];
                                    $orderReq['SecondaryBorrowerMiddleName'] = $secondaryBorrowerArray['middle_name'];
                                    $orderReq['SecondaryBorrowerLastName'] = $secondaryBorrowerArray['last_name'];
                                }
                                // $orderReq['userModel']['borrowers'] = $lenderPackage['borrowers'][0];
                            }
                            if (isset($lenderPackage['loan_number'])) {
                                $orderReq['loanDetails']['loanNumber'] = $lenderPackage['loan_number'];
                            }
                            if (isset($lenderPackage['loan_amount'])) {
                                $orderReq['loanDetails']['loanAmount'] = $lenderPackage['loan_amount'];
                            }
                            if (isset($lenderPackage['coverage_amount'])) {
                                $orderReq['loanDetails']['coverageAmount'] = $lenderPackage['coverage_amount'];
                            }
                            if (isset($lenderPackage['endorsements']) && !empty($lenderPackage['endorsements'])) {
                                $orderReq['endorsements'] = $lenderPackage['endorsements'];
                            }
                        }
                    
                        $order_data = json_encode($orderReq);
                        // echo '<pre>------------------Update Order------------------';
                        // print_r($order_data);
                        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'update_order', 'update_order', $order_data, [], 0, 0);
                        $response = $this->softpro->make_request('POST', 'update_order', $order_data, $userdata);
                        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'update_order', 'update_order', $order_data, json_encode($response), 0, $logid);
                        // echo '<pre>------------------Update Order Response------------------';
                        
                        // print_r($response);

                        // if ($response['status'] == 'success' && !empty($response['data'])) {
                        $this->load->library('order/pdfSplitter');

                        // $pdfPath  = FCPATH . 'uploads/File Upload_1765446957.pdf';
                        // foreach ($pageRange as $doc) {
                        //     echo '<pre>------------------Split pdf '.$doc['doc_type'].'------------------' . $doc['start_page'] . ' --- ' . $doc['end_page'];
                        //     $output = FCPATH . 'uploads/'.$doc['doc_type'].'.pdf';
                        //     $this->pdfsplitter->splitByRange($pdfPath, $doc['start_page'], $doc['end_page'], $output);
                        // }

                        $file_path = FCPATH . 'uploads/lender-parsing-docs/';
                        if (!is_dir($file_path)) {
                            mkdir($file_path, 0777, true);
                        }
                        foreach ($pageRange as $doc) {
                            if ($doc['doc_type'] != 'other' && $doc['doc_type'] != 'unknown' && $doc['start_page'] > 0 && $doc['end_page'] > 0) {
                                // echo '<pre>------------------Split pdf '.$doc['doc_type'].'------------------' . $doc['start_page'] . ' --- ' . $doc['end_page'];
                                $docName = $orderNumber.'_'.time().'_'.$doc['doc_type'].'.pdf';
                                $output = FCPATH . 'uploads/lender-parsing-docs/'.$docName;
                                // print_r($output);
                                // echo "<br>";
                                $this->pdfsplitter->splitByRange($pdfPath, $doc['start_page'], $doc['end_page'], $output);
                                $this->order->uploadDocumentOnAwsS3($docName, 'lender-parsing-docs');
                                $fileList[] = [
                                    "FolderName" => 'lender-parsing-docs',
                                    "FileURL" => env('AWS_PATH') . "lender-parsing-docs/" . $docName
                                ];
                                $saveData['name'] = $doc['doc_type'];
                                $saveData['is_parsed_file'] = 1;
                                $saveData['file_path'] = $docName;
                                $this->db->insert('pct_lender_parsing_document', $saveData);
                            }
                        }

                        /** Upload document to AWS S3 and delete from local storage after processed */
                        $this->order->uploadDocumentOnAwsS3($fileName, 'lender-parsing-docs');

                        $logData = [
                            'order_number' => $orderNumber,
                            'document_name' => $documentName,
                            'file_list' => json_encode($fileList)
                        ];
                        
                        $fileUploadLogId = $this->order->save_sp_file_upload_log($logData);

                        $fileData = [
                            "Id" => $fileUploadLogId,
                            "OrderNumber" => $orderNumber,
                            "DocumentName" => $documentName,
                            "FileList" => $fileList,
                        ];
                        // echo '<pre>------------------File Data to be uploaded to softpro------------------';
                        // print_r($fileData);
                        $fileUploadReq[] = $fileData;
                        $reqData = json_encode($fileUploadReq);
                        $logid = $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'upload_document', 'upload_document', $reqData, [], 0, 0);
                        $result = $this->softpro->make_request('POST', 'upload_document', $reqData);
                        $response = json_decode($result, true);
                        $this->apiLogs->syncLogs($userdata['id'], 'softpro', 'upload_document', 'upload_document', $reqData, json_encode($response), 0, $logid);
                        // echo '<pre>------------------Upload Document Response------------------';
                        // print_r($response);
                        if (isset($response) && !empty($response)) {
                            foreach ($response as $key => $res) {
                                if ($res['Status'] == 200) {
                                    $updateData[] = [
                                        'is_synced' => 1,
                                        'id' => $res['Id']
                                    ];
                                    $this->session->set_flashdata('success', 'Lender instruction parsed successfully.');
                                } else {
                                    if ((strpos(strtolower($res['Message']), "locked for editing by user") !== false)) {
                                        $is_synced = 0;
                                        $this->session->set_flashdata('success', 'Lender instruction parsed successfully.');
                                    } else {
                                        $is_synced = 1;
                                        $this->session->set_flashdata('error', $res['Message']);
                                    }
                                    $updateData[] = [
                                        'is_synced' =>  $is_synced,
                                        'id' => $res['Id'],
                                        'reason' => $res['Message']
                                    ];
                                }
                            }
                        }

                        foreach ($updateData as $key => $update_row) {
                            $this->db->where('id', $update_row['id']);
                            $this->db->update('sp_file_upload_logs', $update_row);
                        }
                        /* Start add softpro api logs */
                        $reswareData = array(
                            'request_type' => 'upload_file_in_softpro',
                            'request_url' => 'upload_file',
                            'request' => $reqData,
                            'response' => $result,
                            'status' => '',
                            'file_number' => $orderNumber,
                            'created_at' => date("Y-m-d H:i:s"),
                        );
                        $this->db->insert('pct_resware_log', $reswareData);
                            
                        // unlink($config['upload_path'] . $fileName);
                        // }
                        // $firstPageContent = $classifyFirstPage['choices'][0]['message']['content'] ?? null;
                        // $firstPageText = $this->ocrservice->first_page_text($pdf);
                        // die;
                        // $fileList[] = [
                        //     "FolderName" => 'desk-file-upload',
                        //     "FileURL" => env('AWS_PATH') . "desk-file-upload/" . $fileName,
                        // ];
                        // $logData = [
                        //     'order_number' => $orderNumber,
                        //     'document_name' => $documentName,
                        //     'file_list' => json_encode($fileList)
                        // ];
                        
                        // $fileUploadLogId = $this->order->save_sp_file_upload_log($logData);
                    }
                    // $successMsg = 'Document info saved successfully.';
                    // $this->session->set_flashdata('success', $successMsg);
                    // echo "<pre>";
                    // print_r($response);die;
                    /* End add softpro api logs */
                    // }

                    // if (!empty($_FILES['file-input']['name'])) {
                    // if (!$this->upload->do_upload('file-input')) {
                    //     $errorMsg = $this->upload->display_errors();
                    //     $this->session->set_flashdata('error', $errorMsg);
                    //     $file_upload_error_msg = 1;
                    // } else {
                    //     $data = $this->upload->data();
                    //     $orderNumber = $this->input->post('order_number');
                    //     $documentName = $this->input->post('document_name');
                    //     $fileName = $orderNumber . '_' . time() . '.pdf';

                    //     $saveData = array(
                    //         'name' => $documentName,
                    //         'order_number' => $orderNumber,
                    //         'file_path' => $fileName,
                    //         'added_by' => $this->user['id'],
                    //         'is_desk_file' => 1,
                    //     );
                    // $id = $this->fileDocument_model->insert($saveData);
                    // rename(FCPATH . "/uploads/desk-file-upload/" . $data['file_name'], FCPATH . "/uploads/desk-file-upload/" . $fileName);
                    // $this->order->uploadDocumentOnAwsS3($fileName, 'desk-file-upload');

                    // /** Save user Activity */
                    // $activity = 'New document uploaded for order : ' . $orderNumber . ' Name :' . $documentName;
                    // $this->order->logAdminActivity($activity);
                    // /** End Save user activity */

                    // }
                } else {
                    $errMsg = 'Please upload file.';
                    $this->session->set_flashdata('error', $errMsg);
                }

            } else {
                $errMsg = validation_errors();
                $this->session->set_flashdata('error', $errMsg);
            }

        }
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/order/upload_doc_orders.js?v=' . $this->js_version));
        $this->salesdashboardtemplate->show("lender-parse", "index", $data);
    }

    public function getLenderPursedDoc()
    {
        $this->load->library('order/common_lib');
        $this->common_lib->checkLenderParseAccess();
        
        $params = array();
        $data = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length']) + 1;
            $file_lists = $this->fileDocument_model->get_lender_parsed_doc($params);
            $json_data['draw'] = intval($params['draw']);
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $file_lists = $this->fileDocument_model->get_lender_parsed_doc($params);
        }

        if (isset($file_lists['data']) && !empty($file_lists['data'])) {
            $i = $params['start'] + 1;
            foreach ($file_lists['data'] as $order) {
                $nestedData = array();
                $nestedData[] = $i;
                $nestedData[] = $order['name'];
                $nestedData[] = $order['order_number'];
                $nestedData[] = ($order['is_parsed_file']) ? 'Parsed File' : 'Original File';
                $nestedData[] = convertTimezone($order['created_at']);
                $documentUrl = env('AWS_PATH') . "lender-parsing-docs/" . $order['file_path'];
                $nestedData[] = "<div class='table-action'>
                                <a href='" . $documentUrl . "' target='_blank'>
									<button type='submit' class='btn btn-success btn-icon-split'>
										<span class='icon text-white-50'>
											<i class='fas fa-file'></i>
										</span>
										<span class='text'>View Document</span>
									</button>
								</a>
                                <button type='submit' onclick='copyLink(" . '"' . $documentUrl . '"' . ", this)' class='btn btn-success btn-icon-split'>
                                    <span class='icon text-white-50'>
                                        <i class='fas fa-copy'></i>
                                    </span>
                                    <span class='text'>Copy Link</span>
                                </button>
                                </div>";
                $data[] = $nestedData;
                $i++;
            }
        }
        $json_data['recordsTotal'] = intval($file_lists['recordsTotal']);
        $json_data['recordsFiltered'] = intval($file_lists['recordsFiltered']);
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }
}
