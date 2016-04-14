<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class page404 extends CI_Controller {

   public function index() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('security');
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        $this->template_admin->load('admin/template', 'admin/page404');
    }

}

?>
