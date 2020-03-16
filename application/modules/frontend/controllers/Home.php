<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Home extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('file', 'url'));
        $this->load->library('session');
    }

    function index() {
    	$data['title'] = 'Open Order | Pacific Coast Title Company';
        $this->load->view('layout/header',$data);
       	$this->load->view('home');
        /* $this->load->view('layout/footer');*/
    }

}