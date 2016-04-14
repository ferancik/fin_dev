<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nastavenia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        $this->load->library('admin/nastavenia_lib');

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->config('admin/time_zones');
        $this->load->model('admin/admin_web_language_m');
    }

    public function index() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->nastavenia_lib->getNastavenia();
            foreach ($this->admin_web_language_m->getActiveLanguage() as $value) {
                $activeLanguage[$value->id] = $value->name;
            }
            $defaultLanguage = $this->admin_web_language_m->getDefaultLanguage()->id;

            $this->template_admin->load('admin/template', 'admin/nastavenia/index', array('data' => $data, 'activeLanguage'=>$activeLanguage, 'defaultLanguage' =>$defaultLanguage, 'time_zones' => array_flip($this->config->item('time_zones_array'))));
        }
    }

    public function upravitObecne() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->nastavenia_lib->getNastavenia();
            $this->form_validation->set_rules('nazov_webu', 'Nazov', 'trim|required|max_length[200]|xss_clean');
            $this->form_validation->set_rules('meta_desc', 'SEO desc', 'required');
            $this->form_validation->set_rules('meta_tags', 'SEO tags', 'trim|required|max_length[200]|xss_clean');
            $this->form_validation->set_rules('zahlavie_webu', 'Záhlavie webu', 'trim');
            $this->form_validation->set_rules('footer_webu', 'Footer webu', 'trim');

            $this->form_validation->set_rules('default_language', 'Default language', 'trim|required');
            $this->form_validation->set_rules('date_format', 'Format casu', 'trim|required');
            $this->form_validation->set_rules('time_zone', 'Casove pasmo', 'trim|required');
            $this->form_validation->set_rules('google_gode', 'Google Tracking code', 'trim');
            
            
            if ($this->form_validation->run()) {
                $temp = $data;
                $temp->nazov_webu = $this->form_validation->set_value('nazov_webu');
                $temp->meta_desc = $this->form_validation->set_value('meta_desc');
                $temp->date_format = $this->form_validation->set_value('date_format');
                $temp->time_zone = $this->form_validation->set_value('time_zone');
                $temp->meta_tags = $this->form_validation->set_value('meta_tags');
                $temp->zahlavie_webu = $this->form_validation->set_value('zahlavie_webu');
                $temp->google_gode = $this->form_validation->set_value('google_gode');
                $temp->footer_webu = $this->form_validation->set_value('footer_webu');

                $this->admin_web_language_m->setDefaultLanguage($this->form_validation->set_value('default_language'));
                
                $this->nastavenia_lib->upravitNastavenia($temp);

                $this->session->set_flashdata('sprava', "save|Nastavenia boli uložené");
            }
            redirect('admin/nastavenia');
        }
    }

    public function upravitKontakt() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->nastavenia_lib->getNastavenia();
            $this->form_validation->set_rules('email_pre_kontakt', 'Email', 'trim|required');

            if ($this->form_validation->run()) {
                $temp = $data;

                $temp->email_pre_kontakt = $this->form_validation->set_value('email_pre_kontakt');

                $this->nastavenia_lib->upravitNastavenia($temp);

                $this->session->set_flashdata('sprava', "save|Nastavenia boli uložené");
            }
            redirect('admin/nastavenia');
        }
    }

    public function upravitga() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->nastavenia_lib->getNastavenia();
            $this->form_validation->set_rules('ga_user', 'Google Analytic email', 'trim');
            $this->form_validation->set_rules('ga_profil', 'Google Analytic profil', 'trim');
            $this->form_validation->set_rules('ga_pass', 'Google Analytic heslo', 'trim');

            if ($this->form_validation->run()) {
                $temp = $data;

                $temp->ga_user = $this->form_validation->set_value('ga_user');
                $temp->ga_profil = $this->form_validation->set_value('ga_profil');
                $temp->ga_pass = $this->form_validation->set_value('ga_pass');

                $this->nastavenia_lib->upravitNastavenia($temp);

                $this->session->set_flashdata('sprava', "save|Nastavenia Google Analytic boli uložené");
            }
            redirect('admin/nastavenia');
        }
    }

}

