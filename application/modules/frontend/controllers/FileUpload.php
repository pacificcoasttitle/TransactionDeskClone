<?php
(defined('BASEPATH')) or exit('No direct script access allowed');
class FileUpload extends MX_Controller
{
    private $user;
    private $sorting_fields;
    private $version = '02';

    public function __construct()
    {
        parent::__construct();
        $userdata = $this->session->userdata('user');
        // print_r($userdata);die;
        if (empty($userdata) || !isset($userdata['is_title_production']) || $userdata['is_title_production'] != 1) {
            redirect('/dashboard');
        }
        $this->user = $userdata;

        $this->load->library('order/salesDashboardTemplate');
        $this->load->model('order/fileDocument_model');
        $this->load->library('order/order');
        $this->load->library('order/softPro');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Reports | Pacific Coast Title Company';

        $condition = array(
            'added_by' => $this->user['id'],
        );

        if (isset($_POST) && !empty($_POST)) {
            $this->form_validation->set_rules('order_number', 'Order Number', 'required', array('required' => 'Enter your order number'));
            $this->form_validation->set_rules('document_name', 'Last Document Name', 'required', array('required' => 'Enter your document name'));
            if ($this->form_validation->run($this) == true) {
                $this->load->model('order/apiLogs');
                $config['upload_path'] = './uploads/desk-file-upload/';
                $config['allowed_types'] = 'pdf';
                $config['max_size'] = 12000;
                $this->load->library('upload', $config);
                $file_path = './uploads/desk-file-upload/';
                if (!is_dir('/uploads/desk-file-upload')) {
                    mkdir('./uploads/desk-file-upload', 0777, true);
                }
                $orderNumber = $this->input->post('order_number');
                $documentName = $this->input->post('document_name');
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
                            $logData = [
                                'order_number' => $orderNumber,
                                'document_name' => $documentName,
                                'file_list' => json_encode($fileList)
                            ];
                            
                            $fileUploadLogId = $this->order->save_sp_file_upload_log($logData);
                        }

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
                                } else {
                                    $updateData[] = [
                                        'is_synced' =>  (strpos(strtolower($res['Message']), "locked for editing by user") !== false) ? 0 : 1,
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
                        $successMsg = 'Document info saved successfully.';
                        $this->session->set_flashdata('success', $successMsg);
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
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/order/upload_doc_orders.js?v=pma_' . $this->version));
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

}
