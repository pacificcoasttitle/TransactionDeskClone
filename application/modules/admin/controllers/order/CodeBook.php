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
    	
    }

    public function add_code_book()
    {
        
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
                       
                        $codebookData['code'] = $value['B'];
                        $codebookData['type'] = $value['A'];
                        $codebookData['language'] = $value['C'];
                        
                        $con = array(
                            'where' => array(
                                'code' => $value['B'],
                                'status' => 1
                            ),
                            'returnType' => 'count'
                        );

                        $prevCount = $this->codeBook_model->get_rows($con);
                        if($prevCount > 0)
                        {
                            $condition = array('code' => $value['B'],'status' => 1);
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
}