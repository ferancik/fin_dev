<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminwebmenuall extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('admin/adminwebmenuall_m', '', TRUE);
         $this->load->model('admin/admin_web_menu_m');
    }

    public function index() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->adminwebmenuall_m->getAllMenu();
            $this->template_admin->load('admin/template', 'admin/adminwebmenuall/index', array('data' => $data));
        }
    }

    public function zmazat($idJazyk) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->adminwebmenuall_m->getOneTypMEnu($idJazyk);
            if (!$data) {
                $this->session->set_flashdata('sprava', "error|Vybrany typ menu neexistuje");
                redirect('admin/adminwebmenuall/');
            } else {
                $this->adminwebmenuall_m->delMenu($data->id);
                $this->admin_web_menu_m->delMenuIDTypMenu($data->id);
                
                $this->session->set_flashdata('sprava', "info|Typ menu bol odstraneny");
                redirect('admin/adminwebmenuall/');
            }
        }
    }

    public function uprava($idJazyk) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $texty = array();
            $data = $this->adminwebmenuall_m->getOneTypMEnu($idJazyk);
            if (!$data) {
                $texty['nazov'] = 'Pridat novy Typ menu';
            } else {
                $texty['nazov'] = 'Upravit typ menu';
            }
            $this->form_validation->set_rules('identifikator', 'Identifikator', 'trim|required|max_length[200]|xss_clean');
            $this->form_validation->set_rules('popis', 'Popis', 'required|xss_clean');


            if ($this->form_validation->run()) {
                $temp = new stdClass();
                $temp->id = "NULL";
                $temp->identifikator = $this->form_validation->set_value('identifikator');
                $temp->popis = $this->form_validation->set_value('popis');
   

                if (!$data) {
                    $ok = $this->adminwebmenuall_m->insertMenu($temp);
                } else {
                    $temp->id = $data->id;
                    $ok = $this->adminwebmenuall_m->ediMenu($temp);
                }
                if (!$data) {
                    $this->session->set_flashdata('sprava', "save|Jazyk bol pridany");
                } else {

                    $this->session->set_flashdata('sprava', "save|Jazyk bol aktualizovany");
                }
                redirect('admin/adminwebmenuall/');
            }

            $this->template_admin->load('admin/template', 'admin/adminwebmenuall/uprava', array('data' => $data, 'text' => $texty));
        }
    }

}
