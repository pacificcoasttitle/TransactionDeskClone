<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodeBook extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('form_validation');
        $this->load->model('order/codeBook_model');
    }

    public function index()
    {
        $this->is_admin();
        $data = array();
        $data['title'] = 'PCT Order: Code Book';
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/code_book', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function is_admin()
    {
        $userdata = $this->session->userdata('admin');
        if (!empty($userdata['id']) && $userdata['is_admin'] == 1) {

        } else {
            redirect(base_url().'order/admin');
        }
    }

    public function get_code_book()
    {
        $params = array();

        if(isset($_POST['draw']) && !empty($_POST['draw']))
        {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 10;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;

            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            

            $pageno = ($params['start'] / $params['length'])+1;

            $code_book_list = $this->codeBook_model->getCodeBooks($params);

            $json_data['draw'] = intval( $params['draw'] );
        }
        else
        {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $code_book_list = $this->codeBook_model->getCodeBooks($params);          
        }

        $data = array();

        if(isset($code_book_list['data']) && !empty($code_book_list['data']))
        {
            $count = $params['start'] + 1;
            foreach ($code_book_list['data'] as $key => $value) 
            {
                $nestedData=array();
                
                $nestedData[] = $count;

                $nestedData[] = $value['code'];

                $type = '';
                if (!empty($value['type'])) {
                    $type = $value['type'];
                }

                $type_dropdown = '<select onchange="updateType('.$value['id'].', this.value);" id="type" name="type"><option value="">Select</option><option value="Easement">Easement</option><option value="Lien">Lien</option><option value="Requirement">Requirement</option><option value="Restriction">Restriction</option><option value="Tax">Tax</option></select>';

                $type_dropdown = str_replace('value="' .  $type . '"','value="' .  $type . '" selected', $type_dropdown);

                $nestedData[] = $type_dropdown;
                $nestedData[] = $value['language'];
               
                
                $data[] = $nestedData;
                $count++;
                
            }
        }
        $json_data['recordsTotal'] = intval( $code_book_list['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $code_book_list['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
    }

    public function add_code_book()
    {
        $this->is_admin();
        $data = array();

        $data['title'] = 'PCT Order: Add Code Book';

        $feesData = array();

        // If import request is submitted
        if($this->input->post())
        {
            $this->form_validation->set_rules('fee_type', 'Fee Type', 'required',array('required'=> 'Please enter fee type'));

            if($this->form_validation->run() == true)
            {
                $id = $this->input->post('fee_id');
                // Prepare data for DB insertion
                $feesData = array(
                    'name' =>  $_POST['fee_type'],
                    'status' => 1
                );

                if($id)
                {
                    $condition = array('id' => $id);

                    $update = $this->feesTypes_model->update($feesData, $condition);

                    if($update)
                    {
                        $successMsg = 'Fee Type updated successfully.';
                        $this->session->set_userdata('success_msg', $successMsg);
                    }
                }
                else
                {                  
                    // Insert member data
                    $insert = $this->feesTypes_model->insert($feesData);
                    
                    if($insert){
                        $data['success_msg'] = 'Fees type added successfully.';
                    }
                    else
                    {
                        $data['error_msg'] = 'Fee type not added.';
                    } 
                }
                
            }
            else
            {
                $data['name_error_msg'] = form_error('fee_type');
            }                                       
        }
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/add_code_book', $data);
        $this->load->view('order/layout/footer', $data);
    }

    public function import_code_book()
    {
        $this->is_admin();  
        $data = array();
        $data['title'] = 'PCT Order: Import';
        if($this->input->post())
        {
            ini_set('max_execution_time', 0); 
            ini_set('memory_limit','2048M');

           // $this->form_validation->set_rules('file', 'Excel file', 'callback_file_checks');

            $this->load->library('excel');
           
            if(is_uploaded_file($_FILES['file']['tmp_name']))
            {
                $inputFileName = $_FILES["file"]["tmp_name"];
                $insertCount = $updateCount = $rowCount = $notAddCount = 0;
                try 
                {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

                    $flag = true;
                    $i=0;

                    foreach ($allDataInSheet as $value) 
                    {
                        $rowCount++;
                        if($flag){
                            $flag =false;
                            continue;
                        }
                        $type = isset($value['A']) && !empty($value['A']) ? $value['A'] : '';
                        $code = isset($value['B']) && !empty($value['B']) ? $value['B'] : '';
                        $language = isset($value['C']) && !empty($value['C']) ? $value['C'] : '';
                        $language = str_replace(array("_x000B_"), "", $language);
                        $type_id = isset($value['D']) && !empty($value['D']) ? $value['D'] : '';
                        
                        $codebookData['code'] = $code;
                        $codebookData['type'] = $type;
                        $codebookData['type_id'] = $type_id;
                        $codebookData['language'] = $language;
                        
                        $con = array(
                            'where' => array(
                                'code' => $code,
                                'type_id' => $type_id,
                                'status' => 1
                            ),
                            'returnType' => 'count'
                        );

                        $prevCount = $this->codeBook_model->get_rows($con);
                        if($prevCount > 0)
                        {
                            $condition = array('code' => $code,'type_id' => $type_id,'status' => 1);
                            // unset($codebookData['language']);
                            $update = $this->codeBook_model->update($codebookData, $condition);
                            
                            if($update){
                                $updateCount++;
                            }
                        }
                        else
                        {
                            // Insert member data
                            $insert = $this->codeBook_model->insert($codebookData);
                            
                            if($insert){
                                $insertCount++;
                            }
                        }
                    }

                    $notAddCount = ($rowCount - ($insertCount + $updateCount));
                    $successMsg = 'Code Book imported successfully. Total Rows ('.$rowCount.') | Inserted ('.$insertCount.') | Updated ('.$updateCount.') | Not Inserted ('.$notAddCount.')';
                    
                    $data['success_msg'] = $successMsg;

                } 
                catch (Exception $e) 
                {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' .$e->getMessage());
                }
            }
            else
            {
                $data['error_msg'] = 'Error on file upload, please try again.';
            }
            
        }
       
        $this->load->view('order/layout/header', $data);
        $this->load->view('order/home/import_code_book', $data);
        $this->load->view('order/layout/footer', $data);
    }

    /*public function file_check($str)
    {
        $allowed_mime_types = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
        {
            $mime = get_mime_by_extension($_FILES['file']['name']);
            $fileAr = explode('.', $_FILES['file']['name']);
            $ext = end($fileAr);
            if(($ext == 'csv') && in_array($mime, $allowed_mime_types)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only CSV file to upload.');
                return false;
            }
        }
        else
        {
            $this->form_validation->set_message('file_check', 'Please select a CSV file to upload.');
            return false;
        }
    }*/

    public function updateType()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $condition = array('id' => $id);
        $this->codeBook_model->update(array('type' => $type), $condition);
        $data = array('status'=>'success', 'msg'=> 'Type updated successfully.');
        echo json_encode($data);
    }
}