<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminTemplate
{
    private $data;
    private $js_file;
    private $css_file;
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        // default CSS and JS that they must be load in any pages
        $this->addJS( base_url('assets/js/core/jquery.3.2.1.min.js') );
        $this->addJS( base_url('assets/backend/js/jquery-ui.min.js') );
        $this->addJS( base_url('assets/js/core/popper.min.js') );
        $this->addJS( base_url('assets/js/core/bootstrap.min.js') );       
        $this->addJS( base_url('assets/backend/hr/js/plugins/bootstrap-switch.js') );
        $this->addJS( base_url('assets/backend/hr/js/plugins/chartist.min.js') );
        $this->addJS( base_url('assets/backend/hr/js/plugins/bootstrap-notify.js') );
        $this->addJS( base_url('assets/backend/hr/js/light-bootstrap-dashboard.js?v=2.0.0') );
        $this->addJS( base_url('assets/vendor/datatables/jquery.dataTables.js') );
        $this->addJS( base_url('assets/vendor/datatables/dataTables.bootstrap4.js') );
        $this->addJS( base_url('assets/vendor/datatables/dataTables.buttons.min.js') );
        $this->addJS( base_url('assets/backend/hr/js/custom.js') );
        $this->addCSS( base_url('assets/vendor/datatables/dataTables.bootstrap4.css') );
        $this->addCSS( base_url('assets/backend/hr/css/bootstrap.min.css') );
        $this->addCSS( base_url('assets/backend/hr/css/light-bootstrap-dashboard.css') );
        $this->addCSS( base_url('assets/backend/css/jquery-ui.css') );
    }

    public function show($folder, $page, $data=null)
    {
        if ( ! file_exists('application/modules/admin/views/'.$folder.'/'.$page.'.php' ) ) {
            show_404();
        } else {
            $this->load_JS_and_css();
            $this->data['header'] = $this->CI->load->view('hr/layout/header.php', $data, true);
            $this->data['sidebar'] = $this->CI->load->view('hr/layout/sidebar.php', $data, true);
            $this->data['content'] = $this->CI->load->view($folder.'/'.$page.'.php', $data, true);
            $this->data['footer'] = $this->CI->load->view('hr/layout/footer.php', $data, true);
            $this->CI->load->view('template.php', $this->data);
        }
    }

    public function addJS( $name )
    {
        $js = new stdClass();
        $js->file = $name;
        $this->js_file[] = $js;
    }

    public function addCSS( $name )
    {
        $css = new stdClass();
        $css->file = $name;
        $this->css_file[] = $css;
    }

    private function load_JS_and_css()
    {
        $this->data['css_files'] = '';
        $this->data['js_files'] = '';

        if ( $this->css_file ) {
            foreach( $this->css_file as $css ) {
                $this->data['css_files'] .= "<link rel='stylesheet' type='text/css' href=".$css->file.">". "\n";
            }
        }

        if ( $this->js_file ) {
            foreach( $this->js_file as $js ) {
                $this->data['js_files'] .= "<script type='text/javascript' src=".$js->file."></script>". "\n";
            }
        }
    }
}