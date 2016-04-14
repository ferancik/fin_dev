<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fotogaleria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/modules/fotogaleria/fotogaleria_lib', '', 'fotogaleria');
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function novy($id) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $texty = array();
            $data = $this->fotogaleria->getOneGaleria($id);
            $data = $data[0];
            if (!$data) {
                $texty['nazov'] = 'Pridať novú galériu';
            } else {
                $texty['nazov'] = 'Upravit galériu';
            }

            $this->form_validation->set_rules('small_nazov', 'Strucny nazov', 'trim|required|max_length[200]|xss_clean');
            $this->form_validation->set_rules('small_popis', 'Strucny popis', 'trim|required|max_length[200]|xss_clean');
            $this->form_validation->set_rules('nazov', 'Nazov', 'trim|required|max_length[200]|xss_clean');
            $this->form_validation->set_rules('popis', 'popis', 'required'); //htmlspecialchars
            $this->form_validation->set_rules('meta_desc', 'SEO popis', 'trim|max_length[200]|xss_clean');
            $this->form_validation->set_rules('meta_tags', 'SEO tags', 'trim|max_length[200]|xss_clean');
            $this->form_validation->set_rules('url_adresa', 'SEO url', 'trim|max_length[200]|xss_clean');

            if ($this->form_validation->run()) {
                $temp = new FotogaleriaData();
                $temp->small_nazov = $this->form_validation->set_value('small_nazov');
                $temp->small_popis = $this->form_validation->set_value('small_popis');
                $temp->nazov = $this->form_validation->set_value('nazov');
                $temp->popis = $this->form_validation->set_value('popis');
                $temp->meta_desc = $this->form_validation->set_value('meta_desc');
                $temp->meta_tags = $this->form_validation->set_value('meta_tags');
                $temp->url_adresa = $this->form_validation->set_value('url_adresa');

                if (!$data) {
                    $ok = $this->fotogaleria->vlozFotogaleriu($temp);
                } else {
                    $temp->id = $data->id;
                    $ok = $this->fotogaleria->upravFotogaleriu($temp);
                }

                if (!$data) {

                    $this->session->set_flashdata('sprava', "save|Nová galéria bola pridané");
                } else {

                    $this->session->set_flashdata('sprava', "save|Galéria bola uložená");
                }
                redirect('admin/fotogaleria/');
            }
            $this->template_admin->load('admin/template', 'admin/modules/fotogaleria/uprava', array('data' => $data, 'text' => $texty));
        }
    }

    public function pridajobrazky($id) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $texty = array();
            $data = $this->fotogaleria->getOneGaleria($id);
            $data = $data[0];
            if (!$data) {
                $this->session->set_flashdata('sprava', "error|Vybraná fotogaléria neexistuje");
                redirect('admin/fotogaleria/');
            } else {
                $texty['nazov'] = $data->small_nazov;
                $obrazky = $this->fotogaleria->getObrazky($data->id);
                $this->template_admin->load('admin/template', 'admin/modules/fotogaleria/pridajobrazky', array('data' => $data, 'text' => $texty, 'obr' => $obrazky));
            }
        }
    }

    public function index() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->fotogaleria->getGalerie();

            $this->template_admin->load('admin/template', 'admin/modules/fotogaleria/index', array('data' => $data));
        }
    }

    public function ajaxUpload($idGalerie) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin() && $idGalerie) {
            redirect('admin/auth/login/');
        } else {
            $this->fotogaleria->nahrajObrazok($idGalerie);
        }
    }

    public function ajaxPoradie($idGalerie) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin() && $idGalerie) {
            redirect('admin/auth/login/');
        } else {
            $foto = $this->input->post(null, TRUE);
            $this->fotogaleria->upravPoradieObrazkov($idGalerie, $foto['fotky']);
        }
    }

    public function zmazat($idGalerie) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin() && $idGalerie) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->fotogaleria->getOneGaleria($idGalerie);
            $data = $data[0];
            if (!$data) {
                $this->session->set_flashdata('sprava', "error|Vybraná fotogaléria neexistuje");
                redirect('admin/fotogaleria/');
            } else {
                $this->fotogaleria->zmazatFotogaleriu($data);
                 $this->session->set_flashdata('sprava', "info|Vybraná fotogaléria bola odstránená");
                redirect('admin/fotogaleria/');
            }
        }
    }

    public function ajaxZmazFotku($idGalerie) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin() && $idGalerie) {
            redirect('admin/auth/login/');
        } else {
            $foto = $this->input->post(null, TRUE);
            $id_foto = explode("_", $foto['foto']);

            $this->fotogaleria->zmazObrazok($idGalerie, $id_foto[1]);
        }
    }

    public function editFoto($idFoto) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $foto = $this->fotogaleria->getObrazok($idFoto);
            // preVarDump($foto);
            $foto = $foto[0];
            $this->load->view('admin/modules/fotogaleria/obrazokedit', array('foto' => $foto), FALSE);
        }
    }

    public function ulozitObrazok($idObrazka) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $foto = $this->fotogaleria->getObrazok($idObrazka);
            if ($foto !== FALSE) {

                $this->form_validation->set_rules('popis', 'Popis', 'trim|max_length[200]|xss_clean');
                $this->form_validation->set_rules('nazov', 'Nazov', 'trim|max_length[200]|xss_clean');
                if ($this->form_validation->run()) {
                    $obr = new ObrazokData();
                    $obr->id = $foto[0]->id;
                    $obr->nazov = $this->form_validation->set_value('nazov');
                    $obr->popis = $this->form_validation->set_value('popis');

                    $this->fotogaleria->upravObrazok($obr);
                    $this->session->set_flashdata('sprava', "save|Obrázok bol upravený");
                    redirect('admin/fotogaleria/pridajobrazky/' . $foto[0]->id_admin_mod_fotogaleria_data);
                } else {
                    redirect('admin/fotogaleria/pridajobrazky/' . $foto[0]->id_admin_mod_fotogaleria_data);
                }
            } else {
                $this->session->set_flashdata('sprava', "error|Vybraný obrázok neexistuje");
                redirect('admin/fotogaleria/');
            }
        }
    }

}
