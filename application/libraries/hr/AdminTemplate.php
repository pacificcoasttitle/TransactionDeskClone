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
        $this->addJS( base_url('assets/backend/js/jquery-ui.min.js') );
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