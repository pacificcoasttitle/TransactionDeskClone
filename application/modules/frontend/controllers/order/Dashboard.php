<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

	function __construct() {
        parent::__construct();
		$this->load->helper(
            array('file', 'url','form')
        );
        $this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('order/orderRecording');
		$this->load->library('order/order');
		$this->order->is_user();
    }

    function selectFiles()
    {
    	/*echo "<pre>"; print_r("here"); exit;
    	$this->is_user();*/
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/select-files');
    }

    function getFiles()
    {
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/dashboard');
    }

    function recordings()
    {
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/recordings');
	}
	
	function get_recordings()
    {
		$this->db->select('*');
        $this->db->from('pct_order_recordings_monthly_sync');	
        $this->db->where('month', date('Ym'));
		$this->db->where('is_sync',  1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
			$this->get_recordings_from_api(date("Y-m-d"));
		} else {
			$begin = new DateTime(date('Y-m-01'));
			$end = new DateTime(date('Y-m-d', strtotime(date('y-m-d') . ' +1 day')));
		
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);

			foreach ($period as $dt) {
				$this->get_recordings_from_api($dt->format("Y-m-d"));
			}
			$this->db->insert('pct_order_recordings_monthly_sync', array('is_sync' => 1, 'month' => date('Ym'), 'created' => date('Y-m-d H:i:s')));
		}
	
		$params = array();  $data = array();
        if (isset($_POST['draw']) && !empty($_POST['draw'])) {
            $params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
            $params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
            $params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
            $params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
            $params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
            $params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
            $pageno = ($params['start'] / $params['length'])+1;
			$recording_lists = $this->orderRecording->get_recordings($params);
            $json_data['draw'] = intval( $params['draw'] );
        } else {
            $params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
            $recording_lists = $this->orderRecording->get_recordings($params);
        }
        

        if (isset($recording_lists['data']) && !empty($recording_lists['data'])) {
            foreach ($recording_lists['data'] as $key => $value)  {
				$nestedData=array();
				
				$date = strtotime($value['recording_date']);
				$recording_date = date('m/d/Y H:i:s', $date);
				$nestedData[] = $recording_date;
                $nestedData[] = $value['instrument_number'];
                $nestedData[] = 'file_number';
                $data[] = $nestedData;      
            }
        }

        $json_data['recordsTotal'] = intval( $recording_lists['recordsTotal'] );
        $json_data['recordsFiltered'] = intval( $recording_lists['recordsFiltered'] );
        $json_data['data'] = $data;
        echo json_encode($json_data);
		
	}
	
	public function get_recordings_from_api($date)
	{
		$this->load->model('order/apiLogs');
		$userdata = $this->session->userdata('user');
		$url = GET_RECORDING_URL.'date='.$date.'&api_token='.RECORDING_API_TOKEN;
		$logId = $this->apiLogs->syncLogs($userdata['id'], 'recording', 'get_recordings', $url);
		$ch = curl_init($url);                                    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                        
		curl_setopt($ch, CURLOPT_POSTFIELDS, array());                   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                
			"cache-control: no-cache",
            "Content-Type: application/json"                             
		));
		$error_msg = curl_error($ch);
		$result = curl_exec($ch);
		$this->apiLogs->syncLogs($userdata['id'], 'recording', 'get_recordings', $url, array(), $result, 0, $logId);

		if (isset($result) && !empty($result)) {
			$response = json_decode($result,true);
			$records = array();
			if (isset($response) && !empty($response)) {
				foreach ($response as $key => $value) {
					if (isset($value['documents']) && !empty($value['documents'])) {
						foreach ($value['documents'] as $k => $v)  {
							$date = strtotime($v['recordingTime']);
							$recording_date = date('m/d/Y H:i:s', $date);
							$records = array(
								'instrument_number' => $v['instrumentNumber'], 
								'state' => $v['state'], 
								'county' => $v['county'],
								'recording_date' => $v['recordingTime'],
								'created' => date('Y-m-d H:i:s'),
								'updated' => date('Y-m-d H:i:s')
							);
							$this->db->replace('pct_order_recordings', $records);
						}
					}
				}
			}
		}  
	}
	
	function attach_files()
    {
    	//$this->is_user();
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/attach_files');
	}

	function get_orders()
    {
		$params = array();  $data = array();
		if (isset($_POST['draw']) && !empty($_POST['draw'])) {
			$params['draw'] = isset($_POST['draw']) && !empty($_POST['draw']) ? $_POST['draw'] : 10;
			$params['length'] = isset($_POST['length']) && !empty($_POST['length']) ? $_POST['length'] : 2;
			$params['start'] = isset($_POST['start']) && !empty($_POST['start']) ? $_POST['start'] : 0;
			$params['orderColumn'] = isset($_POST['order'][0]['column']) && !empty($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
			$params['orderDir'] = isset($_POST['order'][0]['dir']) && !empty($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 0;
			$params['searchvalue'] = isset($_POST['search']['value']) && !empty($_POST['search']['value']) ? $_POST['search']['value'] : '';
			$pageno = ($params['start'] / $params['length'])+1;
			$order_lists = $this->order->get_orders($params);
			$json_data['draw'] = intval( $params['draw'] );
		} else {
			$params['searchvalue'] = isset($_POST['keyword']) && !empty($_POST['keyword']) ? $_POST['keyword'] : '';
			$order_lists = $this->order->get_orders($params);
		}

		if (isset($order_lists['data']) && !empty($order_lists['data'])) {
			$i = $params['start'] + 1;
			foreach ($order_lists['data'] as $order)  {
				$nestedData = array();
				$nestedData[] = $i;
				$nestedData[] = $order['file_number'];
				$nestedData[] = $order['full_address'];
				$nestedData[] = '<a href="'.base_url().'upload-documents/'.$order['file_id'].'"><button class="btn btn-grad-2a" type="button">Attach Files</button></a>';
				$data[] = $nestedData; 
				$i++; 
			}
		}

		$json_data['recordsTotal'] = intval( $order_lists['recordsTotal'] );
		$json_data['recordsFiltered'] = intval( $order_lists['recordsFiltered'] );
		$json_data['data'] = $data;
		echo json_encode($json_data);
	}

	public function upload_documents()
	{
		$data['errors'] = array();
		$data['success'] = array();
		if ($this->session->userdata('errors')) {
			$data['errors'] = $this->session->userdata('errors');
			$this->session->unset_userdata('errors');
		}
		if ($this->session->userdata('success')) {
			$data['success'] = $this->session->userdata('success');
			$this->session->unset_userdata('success');
		}
		$data['title'] = 'Smart Dashboard | Pacific Coast Title Company';
		$fileId = $this->uri->segment(2);     
		$data['documentTypes'] = $this->order->get_document_types();
		$data['orderDetails'] = $this->order->get_order_details($fileId);

		$this->load->view('layout/head_dashboard',$data);
		$this->load->view('order/upload_documents');
	}

	public function files_upload() 
	{
		$this->load->model('order/document');
		$this->load->model('order/apiLogs');
		$this->load->library('order/resware');
		$errors = array();
		$success = array();
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'doc|docx|gif|msg|pdf|tif|tiff|xls|xlsx|xml';   
		$config['max_size'] = 12000;
		$userdata = $this->session->userdata('user');
		$this->load->library('upload', $config);
		$fileId = $this->input->post('file_id');
		$orderId = $this->input->post('order_id');

		for ($i = 1; $i <=6 ; $i++) {
			if (!empty($_FILES['document_'.$i]['name'])) {
				if (! $this->upload->do_upload('document_'.$i)) {
					$errors[$i] = "Document #".$i.": ".$this->upload->display_errors();
				} else { 
					$data = $this->upload->data();
					$contents = file_get_contents($data['full_path']);
					$binaryData   = base64_encode($contents); 
					
					$documentData = array(
						'document_name' => $data['file_name'],
						'document_type_id' => $this->input->post('document_type_'.$i),
						'document_size' => ($data['file_size'] * 1000),
						'user_id' => $userdata['id'],
						'order_id' => $orderId
					);
					
					$documentId = $this->document->insert($documentData);
					
					$endPoint = 'files/'.$fileId.'/documents';
					
					$documentApiData = array(			
						'DocumentName' => $data['file_name'],
						'DocumentType' => array(
							'DocumentTypeID' => $this->input->post('document_type_'.$i),
						),
						'Description' => $this->input->post('description_'.$i),
						'InternalOnly' => false,
						'DocumentBody' => $binaryData
					);
					$document_api_data = json_encode($documentApiData, JSON_UNESCAPED_SLASHES);
					
					$logid = $this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', RESWARE_ORDER_API.$endPoint, $documentApiData, array(), $orderId, 0);
					$result = $this->resware->make_request('POST', $endPoint, $document_api_data);
					$this->apiLogs->syncLogs($userdata['id'], 'resware', 'create_document', RESWARE_ORDER_API.$endPoint, $documentApiData, $result, $orderId, $logid);
					$res = json_decode($result);
					$this->document->update(array('api_document_id' => $res->Document->DocumentID), array('id' => $documentId));
					$success[$i] = "Document #".$i.": uploaded successfully";
				} 
			}
		}
		$data['errors'] = $errors;
		$data['success'] = $success;
		$data = array(
			"errors" =>  $errors,
			"success" => $success
		);
		$this->session->set_userdata($data);
		redirect(base_url().'upload-documents/'.$fileId);
	}
}