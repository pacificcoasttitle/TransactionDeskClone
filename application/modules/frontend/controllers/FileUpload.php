<?php
(defined('BASEPATH')) or exit('No direct script access allowed');
class FileUpload extends MX_Controller
{
    private $user;
    private $sorting_fields;
    private $version = '01';

    public function __construct()
    {
        parent::__construct();
        $userdata = $this->session->userdata('user');
        // print_r($userdata);die;
        if (empty($userdata) || !isset($userdata['is_title_production']) || $userdata['is_title_production'] != 1) {
            redirect('file-upload');
        }
        $this->user = $userdata;

        $this->load->library('order/salesDashboardTemplate');
        $this->load->model('order/fileDocument_model');
        $this->load->library('order/order');
    }

    public function index()
    {
        $data['title'] = 'Reports | Pacific Coast Title Company';

        $condition = array(
            'added_by' => $this->user['id'],
        );
        // $data['reports_data'] = $this->report_model->getData($condition);
        // $data['sorting_fields'] = $this->sorting_fields;

        if (isset($_POST) && !empty($_POST)) {
            $config['upload_path'] = './uploads/desk-file-upload/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 12000;
            $this->load->library('upload', $config);
            if (!is_dir('/uploads/desk-file-upload')) {
                mkdir('./uploads/desk-file-upload', 0777, true);
            }
            if (!empty($_FILES['file-input']['name'])) {
                if (!$this->upload->do_upload('file-input')) {
                    $errorMsg = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $errorMsg);
                    $file_upload_error_msg = 1;
                } else {
                    $data = $this->upload->data();
                    $orderNumber = $this->input->post('order_number');
                    $documentName = $this->input->post('document_name');
                    $fileName = $orderNumber . '_' . time() . '.pdf';

                    $saveData = array(
                        'name' => $documentName,
                        'order_number' => $orderNumber,
                        'file_path' => $fileName,
                        'added_by' => $this->user['id'],
                        'is_desk_file' => 1,
                    );
                    $id = $this->fileDocument_model->insert($saveData);
                    rename(FCPATH . "/uploads/desk-file-upload/" . $data['file_name'], FCPATH . "/uploads/desk-file-upload/" . $fileName);
                    $this->order->uploadDocumentOnAwsS3($fileName, 'desk-file-upload');

                    /** Save user Activity */
                    $activity = 'New document uploaded for order : ' . $orderNumber . ' Name :' . $documentName;
                    $this->order->logAdminActivity($activity);
                    /** End Save user activity */
                    $successMsg = 'Document info saved successfully.';
                    $this->session->set_flashdata('success', $successMsg);
                }
            } else {
                $errMsg = 'Please upload file.';
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
                $documentUrl = env('AWS_PATH') . "desk-file-upload/" . $order['file_path'];
                $nestedData[] = "<a href='" . $documentUrl . "' target='_blank'>
									<button type='submit' class='btn btn-info btn-icon-split'>
										<span class='icon text-white-50'>
											<i class='fas fa-file'></i>
										</span>
										<span class='text'>Attach Files</span>
									</button>
								</a>";
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
