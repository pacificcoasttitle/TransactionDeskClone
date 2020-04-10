<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_pdf {
 
    public $param;
    public $pdf;
 
    public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
    {
    	require_once(APPPATH."third_party/mpdf/mpdf.php");
        $this->param =$param;
        $this->pdf = new mPDF('','A4','','',20,20,20,20);
    }
}