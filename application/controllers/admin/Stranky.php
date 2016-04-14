<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stranky extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        $this->load->library('admin/modules/stranky/stranky_lib');

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('admin/spravapouzivatelov_m', '', TRUE);

        $this->load->model('admin/admin_web_language_m');
        $this->load->model('admin/admin_web_menu_langs_m');
    }

    public function index() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->stranky_lib->getStranky();
            $user_login = $this->spravapouzivatelov_m->getOneUser($this->tank_auth->get_user_id());
            $this->template_admin->load('admin/template', 'admin/stranky/index', array('data' => $data, 'prihlaseny_user' => $user_login));
        }
    }

    public function uprava($idStranky) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {


            $user_login = $this->spravapouzivatelov_m->getOneUser($this->tank_auth->get_user_id());
            $alljazyky = $this->admin_web_language_m->getActiveLanguage();
            $data = $this->stranky_lib->getOneStranka($idStranky);
            $data = $data[0];
            $texty = array();
            if (!$data) {
                $texty['nazov'] = 'Pridať novú stránku';
            } else {
                $texty['nazov'] = 'Upravit stránku';
            }

            $this->form_validation->set_rules('nazov', 'Nazov', 'trim|required|max_length[200]');

            if ($user_login->admin_permission == 1) {
                $this->form_validation->set_rules('typ_Stranky', 'Typ stranky', 'required');
            }

            foreach ($alljazyky as $value) {
                $this->form_validation->set_rules('obsah_' . $value->id . '', 'Obsah ' . ucfirst($value->name), (($value->default == 1) ? 'required' : ''));
                $this->form_validation->set_rules('seo_popis_' . $value->id . '', 'SEO popis ' . ucfirst($value->name), 'trim|max_length[200]');
                $this->form_validation->set_rules('seo_tagy_' . $value->id . '', 'SEO tags ' . ucfirst($value->name), 'trim|max_length[200]');
            }


            $this->form_validation->set_rules('seo_url', 'SEO url', 'trim|max_length[200]');



            if ($this->form_validation->run()) {
                $temp = $data;

                $temp->nazov = $this->form_validation->set_value('nazov');
                $temp->obsah = $this->form_validation->set_value('obsah');
                $temp->seo_popis = $this->form_validation->set_value('seo_popis');
                $temp->seo_tagy = $this->form_validation->set_value('seo_tagy');

                if ($user_login->admin_permission == 1) {
                    $temp->pevna = $this->form_validation->set_value('typ_Stranky');
                    if ($temp->pevna == 1) {
                        $temp->kod_pre_zavolanie = $this->form_validation->set_value('seo_url');
                    }
                }

                $temp->seo_url = url_title($this->form_validation->set_value('seo_url'));
                if ($user_login->admin_permission == 1) {
                    if ($temp->pevna == 1) {
                        $temp->seo_url = "";
                    } else {
                        $temp->kod_pre_zavolanie = "";
                    }
                }

                $temp->modifikacia = time();

                if (!$data) {
                    $ok = $this->stranky_lib->vlozStranku($temp);
                    $temp->id = $ok;
                } else {
                    $temp->id = $data->id;
                    $ok = $this->stranky_lib->upravStranku($temp);
                }

                foreach ($alljazyky as $value) {


                    $this->admin_web_menu_langs_m->editStrankyLanguage($temp->id, $value->id, $this->form_validation->set_value('obsah_' . $value->id . ''), $this->form_validation->set_value('seo_popis_' . $value->id . ''), $this->form_validation->set_value('seo_tagy_' . $value->id . '')
                    );
                }

                if (!$data) {

                    $this->session->set_flashdata('sprava', "save|Nová stránka bola pridaná");
                } else {

                    $this->session->set_flashdata('sprava', "save|Stránka bola uložená");
                }
                redirect(site_url('admin/stranky/'));  
            }

            //$this->admin_web_language_m->getStrankyLanguage('1','0');
            //preVarDump();

            $this->template_admin->load('admin/template', 'admin/stranky/uprava', array('alljazyky' => $alljazyky, 'data' => $data, 'texty' => $texty, 'prihlaseny_user' => $user_login));
        }
    }

    public function zmazat($idStranky) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->stranky_lib->getOneStranka($idStranky);
            $user_login = $this->spravapouzivatelov_m->getOneUser($this->tank_auth->get_user_id());
            $data = $data[0];
            if (!$data) {
                $this->session->set_flashdata('sprava', "error|Stránka ktorú chcete odstrániť neexistuje");
                redirect('admin/stranky/');
            } else if ($data->pevna == 1 && $user_login->admin_permission != 1) {
                $this->session->set_flashdata('sprava', "error|Stránka ktorú chcete odstrániť je systémová");
                redirect('admin/stranky/');
            } else {

                $this->stranky_lib->odstranitStranku($data);

                $this->session->set_flashdata('sprava', "ok|Stránka bola odstránená");
                redirect('admin/stranky/');
            }
        }
    }

}

