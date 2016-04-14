<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template {

    var $template_data = array();
    private $CI;
    private $user_profile;
    private $left_menu;
    

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('tank_auth/users');
        
        $this->CI->load->library('tank_auth_web');
        $this->CI->load->library('fin/menu_lib');
        
        $this->user_profile = $this->CI->users->get_user_by_id($this->CI->tank_auth_web->get_user_id(),1);     
        
        $this->left_menu = $this->CI->menu_lib->createMenu();
    }

    function set($name, $value) {
        $this->template_data[$name] = $value;
    }

    function load($template = '', $view = '', $view_data = array(), $return = FALSE) {
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        $this->set('user_profile', $this->user_profile);
        $this->set('left_menu', $this->left_menu);
//        preVarDump($this->template_data);
        $this->CI->load->view($template, $this->template_data, $return);
    }

}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */