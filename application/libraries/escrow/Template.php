<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template
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
            $data['notifications'] = $this->getNotifications(5);
            $data['unreadNotificationCount'] = $this->getUnreadNotificationCount(5);
            
            $this->data['header'] = $this->CI->load->view('escrow/layout/header.php', $data, true);
            $this->data['sidebar'] = $this->CI->load->view('escrow/layout/sidebar.php', $data, true);
            $this->data['content'] = $this->CI->load->view($folder.'/'.$page.'.php', $data, true);
            $this->data['footer'] = $this->CI->load->view('escrow/layout/footer.php', $data, true);
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

    public function getNotifications($limit) 
    {
        $userdata = $this->CI->session->userdata('escrow_admin');
        $this->CI->db->select('*');
        if ($userdata['is_escrow_manager'] == 1) {
            $this->CI->db->where('is_admin_read', 0);
            $this->CI->db->where('is_admin', 1);
        } else {
            $this->CI->db->where('is_read', 0);
            $this->CI->db->where('sent_user_id', $userdata['id']);
        }
        $query = $this->CI->db->get('pct_escrow_notifications');
        $this->CI->db->order_by('pct_escrow_notifications.id', 'desc');  
        if ($query->num_rows() > 0)  {
            return $query->result_array();
        } else {
            return array();
        }
    }

    public function getUnreadNotificationCount() 
    {
        $userdata = $this->CI->session->userdata('escrow_admin');
        $this->CI->db->select('count(*) as total_unread_count');
        if ($userdata['is_escrow_manager'] == 1) {
            $this->CI->db->where('is_admin_read', 0);
            $this->CI->db->where('is_admin', 1);
        } else {
            $this->CI->db->where('is_read', 0);
            $this->CI->db->where('sent_user_id', $userdata['id']);
        }
        $query = $this->CI->db->get('pct_escrow_notifications');
        if ($query->num_rows() > 0)  {
            return $query->row_array();
        } else {
            return array();
        }
    }
}