<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Spravajazykov extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');

       
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('admin/spravajazykov_m', '', TRUE);
     
    }

    
    public function index() {
       
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->spravajazykov_m->getJazyky();
            $this->template_admin->load('admin/template', 'admin/spravajazykov/index', array('data' => $data));
        }
    }

    public function zmazat($idJazyk) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin() && $idUser) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->spravajazykov_m->getOneJazyk($idJazyk);
            if (!$data) {
                $this->session->set_flashdata('sprava', "error|Vybrany jazyk neexistuje");
                redirect('admin/spravajazykov/');
            } else {
                $this->spravajazykov_m->delJazyk($data->id);
                $this->session->set_flashdata('sprava', "info|Jazyk bol odstraneny");
                redirect('admin/spravajazykov/');
            }
        }
    }

    public function uprava($idJazyk) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $texty = array();
            $data = $this->spravajazykov_m->getOneJazyk($idJazyk);
            if (!$data) {
                $texty['nazov'] = 'Pridat novy jazyk';
            } else {
                $texty['nazov'] = 'Upravit jazyk';
            }
            $this->form_validation->set_rules('name', 'Nazov', 'trim|required|max_length[200]|xss_clean');
            $this->form_validation->set_rules('active', 'Active', 'required|xss_clean');
            $this->form_validation->set_rules('iso_code', 'Iso code', 'required|xss_clean');
            $this->form_validation->set_rules('icon', 'icon', 'required|xss_clean');


            if ($this->form_validation->run()) {
                $temp = new stdClass();
                $temp->id = "NULL";
                $temp->name = $this->form_validation->set_value('name');
                $temp->active = $this->form_validation->set_value('active');
                $temp->iso_code = $this->form_validation->set_value('iso_code');
                $temp->icon = $this->form_validation->set_value('icon');




                if (!$data) {
                    $ok = $this->spravajazykov_m->insertJazyk($temp);
                   
                } else {
                    $temp->id = $data->id;
                    $ok = $this->spravajazykov_m->editJazyk($temp);
                  
                }
                if (!$data) {
                    $this->session->set_flashdata('sprava', "save|Jazyk bol pridany");
                } else {

                    $this->session->set_flashdata('sprava', "save|Jazyk bol aktualizovany");
                }
                redirect('admin/spravajazykov/');
            }

            $this->template_admin->load('admin/template', 'admin/spravajazykov/uprava', array('data' => $data, 'text' => $texty));
        }
    }

}

