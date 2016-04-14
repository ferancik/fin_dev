<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Emailnastavenia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('admin/emailnastavenia_m');
    }

    public function index() {
        $data = $this->emailnastavenia_m->getNastavenia();
        $this->template_admin->load('admin/template', 'admin/emailnastavenia/index', array('data' => $data));
    }

    public function upravit() {
        $this->form_validation->set_rules('protocol', '', 'trim|required');
        $this->form_validation->set_rules('email_odosielania', '', 'trim|required');
        $this->form_validation->set_rules('email_pre_odpoved', '', 'trim|required');
        $this->form_validation->set_rules('email_odosielania_meno', '', 'trim|required');
        if ($_POST['protocol'] == 'smtp') {
            $this->form_validation->set_rules('smtp_server', '', 'trim|required');
            $this->form_validation->set_rules('smtp_port', '', 'trim|required');
            $this->form_validation->set_rules('smtp_pass', '', 'trim|required');
            $this->form_validation->set_rules('smtp_user', '', 'trim|required');
            $this->form_validation->set_rules('smtp_secure', '', 'trim');
        }
        $this->form_validation->set_rules('mailtype', '', 'trim|required');
        $this->form_validation->set_rules('charset', '', 'trim|required');
        $this->form_validation->set_rules('priority', '', 'trim|required');

        if ($this->form_validation->run()) {
            $data = $this->emailnastavenia_m->getNastavenia();
            $temp = $data;

            $temp->email_odosielania = $this->form_validation->set_value('email_odosielania');
            $temp->email_pre_odpoved = $this->form_validation->set_value('email_pre_odpoved');
            $temp->protocol = $this->form_validation->set_value('protocol');
            $temp->email_odosielania_meno = $this->form_validation->set_value('email_odosielania_meno');
            if ($_POST['protocol'] == 'smtp') {
                $temp->smtp_server = $this->form_validation->set_value('smtp_server');
                $temp->smtp_port = $this->form_validation->set_value('smtp_port');
                $temp->smtp_user = $this->form_validation->set_value('smtp_user');
                $temp->smtp_pass = $this->form_validation->set_value('smtp_pass');
                $temp->smtp_secure = $this->form_validation->set_value('smtp_secure');
            }
            $temp->mailtype = $this->form_validation->set_value('mailtype');
            $temp->charset = $this->form_validation->set_value('charset');
            $temp->priority = $this->form_validation->set_value('priority');


            $this->emailnastavenia_m->upravitNastavenia($temp);
            
            $this->session->set_flashdata('sprava', "save|Nastavenia boli uložené");
        }
        redirect('admin/emailnastavenia');
    }

}

