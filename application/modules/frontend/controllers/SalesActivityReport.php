<?php
(defined('BASEPATH')) or exit('No direct script access allowed');
class SalesActivityReport extends MX_Controller
{

    private $user;
    private $js_version = '01';
    public $monthArr = [
        1 => "January",
        2 => "February",
        3 => "March",
        4 => "April",
        5 => "May",
        6 => "June",
        7 => "July",
        8 => "August",
        9 => "September",
        10 => "October",
        11 => "November",
        12 => "December",
    ];
    public function __construct()
    {
        parent::__construct();
        $userdata = $this->session->userdata('user');
        if (empty($userdata) || !isset($userdata['is_master']) || $userdata['is_master'] != 1) {
            redirect('dashboard');
        }
        $this->user = $userdata;
        $this->load->library('order/template');
        $this->load->library('order/salesDashboardTemplate');
        $this->load->model('order/home_model');
        $this->load->model('salesReport_model');
        $this->load->library('order/order');
        $this->load->helper('common');
    }

    public function index()
    {
        $data['title'] = 'Sales Reports | Pacific Coast Title Company';
        $condition = array(
            'is_sales_rep' => 1,
            'status' => 1,
        );
        $data['salesReps'] = $this->salesReport_model->getSalesRepData($condition, $this->user['id']);
        $data['report_total'] = array_sum(array_column($data['salesReps'], 'report_count'));
        $report_condition = array(
            'added_by' => $this->user['id'],
        );
        $data['monthNameList'] = $this->monthArr;
        $data['reports_data'] = $this->salesReport_model->getData($report_condition);
        // echo "<pre>";
        // print_r($data);die;
        $this->salesdashboardtemplate->addJS(base_url('assets/frontend/js/report.js?v=sales_activity_' . $this->js_version));
        $this->salesdashboardtemplate->show("salesReport", "list", $data);
    }

    public function importData()
    {
        $this->load->library('CSVReader');
        $valid = true;
        if (empty($this->input->post('sales_rep'))) {
            $valid = false;
            $this->session->set_flashdata('error', 'Please select Sales Representative');
        } else if (empty($this->input->post('month'))) {
            $valid = false;
            $this->session->set_flashdata('error', 'Please Select Motth');
        } else if (empty($_FILES['csvFile']['tmp_name'])) {
            $valid = false;
            $this->session->set_flashdata('error', 'Please select csv file');
        }

        if (!$valid) {
            $this->session->set_flashdata('_previous_data', $this->input->post());
            redirect('sales-activity-report');
        }

        $csv_records = $this->csvreader->parse_csv($_FILES['csvFile']['tmp_name']); //path to csv file
        $valid_keys = ['Site City', 'Purchase Price', 'Property Type'];

        if (is_array($csv_records) && isset($csv_records[1])) {
            $first_reocrd = $csv_records[1];
            $keys_not_found = array();

            foreach ($valid_keys as $valid_key) {
                if (!isset($first_reocrd[$valid_key])) {
                    $keys_not_found[] = $valid_key;
                }
            }

            if (count($keys_not_found)) {
                $this->session->set_flashdata('error', 'Column not found : ' . implode(', ', $keys_not_found));
                $this->session->set_flashdata('_previous_data', $this->input->post());
                redirect('sales-activity-report');
            }

            $main_record = array();
            $main_record['sales_rep'] = $this->input->post('sales_rep');
            $main_record['month'] = $this->input->post('month');
            $main_record['added_by'] = $this->user['id'];
            $last_id = $this->salesReport_model->insert($main_record);
            // $last_id = 4; //$this->salesReport_model->insert($main_record);

            $records = array();
            $i = 0;
            $report_data = array();
            if ($last_id) {
                foreach ($csv_records as $csv_record) {
                    $records[$csv_record['Site City']][strtolower(trim($csv_record['Property Type']))][] = [
                        'property_type' => $csv_record['Property Type'],
                        'purchase_price' => $csv_record['Purchase Price'],
                    ];
                }

                foreach ($records as $key => $val) {
                    $avgRconValue = $rconCount = $avgSfrValue = $sfrCount = 0;
                    if (array_key_exists('rsfr', $val)) {
                        $allValues = array_column($val['rsfr'], 'purchase_price');
                        $avgSfrValue = array_sum($allValues) / count($allValues);
                        $sfrCount = count($allValues);
                    }

                    if (array_key_exists('rcon', $val)) {
                        $allValues = array_column($val['rcon'], 'purchase_price');
                        $rconCount = count($allValues);
                        $avgRconValue = array_sum($allValues) / count($allValues);
                    }

                    $records[$key]['SFR'] = ['avgSalePrice' => round($avgSfrValue, 2), 'key' => 'SFR', 'count' => $sfrCount];
                    $records[$key]['Condos'] = ['avgSalePrice' => round($avgRconValue, 2), 'key' => 'Condor', 'count' => $rconCount];
                    unset($records[$key]['rcon']);
                    unset($records[$key]['rsfr']);
                }
                $report_data['records'] = array_chunk($records, 27, true);
                $monthNumber = $this->input->post('month');
                $report_data['monthNumber'] = $monthNumber;
                $report_data['monthName'] = $this->monthArr[$monthNumber];
                $condition = array(
                    'is_sales_rep' => 1,
                    'status' => 1,
                    'id' => $this->input->post('sales_rep'),
                );

                $report_data['salesRep'] = $this->home_model->getSalesRepDetails($condition);
                // echo "<pre>";
                // print_r($report_data);die;

                $html = $this->load->view('salesReport/sales_activity_report', $report_data, true);

                // print_r($html);die;
                $this->load->library('snappy_pdf');

                $document_name = $report_data['salesRep']['first_name'] . '_' . $this->monthArr[$monthNumber] . '_' . date('Y') . '_' . $last_id . '.pdf';
                if (!is_dir(FCPATH . 'uploads/sales-activity')) {
                    mkdir(FCPATH . 'uploads/sales-activity', 0777, true);
                }

                chmod(FCPATH . 'uploads/sales-activity', 0777);

                $dir_name = FCPATH . 'uploads/sales-activity/';
                $dir_name = str_replace('\\', '/', $dir_name);

                $this->snappy_pdf->pdf->setOption('page-size', 'Letter');
                $this->snappy_pdf->pdf->setOption('zoom', '1.24');
                $this->snappy_pdf->pdf->generateFromHtml($html, $dir_name . $document_name);
                $response = $this->order->uploadDocumentOnAwsS3($document_name, 'sales-activity');
                if ($response) {
                    if (is_file($dir_name . $document_name)) {
                        unlink($dir_name . $document_name);
                    }
                    $update_data = array(
                        'report_url' => $document_name,
                    );
                    $condition = array(
                        'id' => $last_id,
                    );
                    $this->salesReport_model->update($update_data, $condition);
                }
                $this->session->set_flashdata('success', 'Sales Activity Recorded.');
            } else {
                $this->session->set_flashdata('error', 'Please try again!');
                $this->session->set_flashdata('_previous_data', $this->input->post());
            }
        }
        redirect('sales-activity-report');
    }

    public function sales_rep($id = 0)
    {
        $data['title'] = 'Sales Rep | Pacific Coast Title Company';
        if ($id) {
            if ($this->input->server('REQUEST_METHOD') === 'POST') {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('first_name', 'Sales Rep. First Name', 'required', array('required' => 'Please Enter Sales Rep. First Name'));
                $this->form_validation->set_rules('last_name', 'Sales Rep. Last Name', 'required', array('required' => 'Please Enter Sales Rep. Last Name'));
                $this->form_validation->set_rules('email_address', 'Email', 'trim|required|valid_email', array('required' => 'Please Enter Email', 'valid_email' => 'Please enter valid Email'));
                $this->form_validation->set_rules('telephone_no', 'Phone Number', 'required', array('required' => 'Please Enter Phone Number'));

                $config['upload_path'] = 'uploads/sales-rep/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 12000;

                if ($this->form_validation->run() == true) {
                    $fileuri = '';
                    $status = "success";

                    $update_data = array();
                    $update_data['first_name'] = $this->input->post('first_name');
                    $update_data['last_name'] = $this->input->post('last_name');
                    $update_data['title'] = $this->input->post('title');
                    $update_data['email_address'] = $this->input->post('email_address');
                    $update_data['telephone_no'] = $this->input->post('telephone_no');
                    if (is_uploaded_file($_FILES['sales_rep_report_image']['tmp_name'])) {
                        if (!is_dir('uploads/sales-rep')) {
                            mkdir('./uploads/sales-rep', 0777, true);
                        }

                        $new_name = 'sales_rep_report_' . time() . rand(10, 1000);
                        $config['file_name'] = $new_name;
                        $this->load->library('upload', $config);

                        if (!$this->upload->do_upload('sales_rep_report_image')) {
                            $status = 'error';
                            $msg = $this->upload->display_errors();
                            // echo $msg;die;
                        } else {
                            $data = $this->upload->data();
                            // var_dump($data);die;
                            $status = "success";
                            $msg = "Borr
                            ower File successfully uploaded";
                            $document_name = 'sales_rep_report_' . time() . rand(10, 1000) . '.' . $data['image_type'];
                            rename('./uploads/sales-rep/' . $data['file_name'], './uploads/sales-rep/' . $document_name);
                            // die;
                            $this->order->uploadDocumentOnAwsS3($document_name, 'sales-rep');
                            // die("Done");
                            $fileuri = 'sales-rep/' . $document_name;
                            $update_data['sales_rep_report_image'] = $fileuri;

                        }
                    }

                    $condition = array('id' => $id);

                    $this->home_model->update($update_data, $condition);

                    $this->session->set_flashdata('success', 'Record updated');

                    redirect('reports/sales_rep/' . $id);
                }

            }
            $condition = array(
                'is_sales_rep' => 1,
                'status' => 1,
                'id' => $id,
            );
            $data['salesRep'] = $this->home_model->getSalesRepDetails($condition);

            $this->salesdashboardtemplate->show("report", "sales_rep_edit", $data);
            // $this->template->show("report", "sales_rep_edit", $data);
        } else {

            $condition = array(
                'is_sales_rep' => 1,
                'status' => 1,
            );
            $data['salesReps'] = $this->report_model->getSalesRepData($condition);
            $this->salesdashboardtemplate->show("report", "sales_rep", $data);
            // $this->template->show("report", "sales_rep", $data);
        }
    }

    public function sendEmailToSalesRep()
    {
        $to = $this->input->post('email');
        $url = $this->input->post('url');
        if (empty($to) || empty($url)) {
            echo json_encode(['status' => 'error', 'message' => 'Details missing']);exit;
        }
        $file[] = $url;
        $from_name = 'Pacific Coast Title Company';
        $from_mail = env('FROM_EMAIL');
        $message = 'Please check attachment for Snap Shot document.';
        $subject = 'Sales Snapshot Ready!';

        // $file[] = 'https://pct-doc.s3-us-west-2.amazonaws.com/sales-snap-shot/1710971265_42.pdf'; // $this->input->post('url');
        // $to = 'piyush.j@crestinfosystems.net';
        $this->load->helper('sendemail');
        $data = array(
            'link' => $url,
        );
        $cc[] = 'piyush-crest@yopmail.com';
        $message = $this->load->view('salesSnapShot/snapshot_email_template.php', $data, true);
        $mail_result = send_email($from_mail, $from_name, $to, $subject, $message, $file, $cc, []);
        if ($mail_result) {
            echo json_encode(['status' => 'success', 'message' => 'Email sent!']);exit;
        }
        echo json_encode(['status' => 'error', 'message' => 'Email not sent, Try again later']);exit;
    }
}
