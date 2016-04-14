<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sliders extends CI_Controller {
    private $path_image;

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/modules/slider/Slider');
        $this->load->library('admin/modules/slider/Slider_foto');
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        
        $this->path_image = $this->config->item('PATH_SLIDER_FOLDER');
    }

    public function index() {

        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $sliders = $this->slider->getAllSliders();
            $this->template_admin->load('admin/template', 'admin/modules/slider/index', array('slider' => $sliders));
        }
    }

    public function novy_slider($id) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $slider = $this->slider->getSliderById($id);
            $this->template_admin->load('admin/template', 'admin/modules/slider/form', array('slider' => $slider));
        }
    }

    public function ulozit() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('nazov', 'Nazov', 'trim|required|max_length[50]|xss_clean');
            $this->form_validation->set_rules('umiestnenie', 'umiestnenie', 'trim|required|max_length[50]|xss_clean');
            $this->form_validation->set_rules('popis', 'popis', 'trim|xss_clean');
            $this->form_validation->set_rules('id_slider', 'id_slider', 'trim|xss_clean');
            if ($this->form_validation->run()) {
                $this->slider->setId($this->form_validation->set_value('id_slider'));
                $this->slider->setNazov($this->form_validation->set_value('nazov'));
                $this->slider->setUmiestnenie($this->form_validation->set_value('umiestnenie'));
                $this->slider->setPopis($this->form_validation->set_value('popis'));

                $this->slider->ulozitSlider();
                redirect('admin/sliders');
            } else {
                
            }
        }
    }

    public function ulozitfoto() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('napdis', 'napdis', 'trim|required|max_length[30]|xss_clean');
            $this->form_validation->set_rules('kratky_popis', 'kratky_popis', 'trim|required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('url', 'url', 'trim|prep_url|valid_url|xss_clean');
            $this->form_validation->set_rules('id_foto', 'id_foto', 'trim|xss_clean');
            $this->form_validation->set_rules('id_slider', 'id_slider', 'trim|xss_clean');
            if ($this->form_validation->run()) {

                
                $config['upload_path'] = $this->path_image;
                $config['allowed_types'] = 'jpg|jepg|png|gif|tif|tiff|bmp';
                $config['max_size'] = '10000';
                $config['remove_spaces'] = FALSE;

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image')) {
                    $this->upload->display_errors();
                } else {
                    $data_image = $this->upload->data();
                    $this->load->library('admin/create_thumb');
                    $this->create_thumb->prerobObr($this->path_image.$data_image['file_name'], $this->path_image.'thumb/'.$data_image['file_name']);
                    $this->slider_foto->setImage($data_image['file_name']);
                }

                $this->slider_foto->setName($this->form_validation->set_value('napdis'));
                $this->slider_foto->setPopis($this->form_validation->set_value('kratky_popis'));
                $this->slider_foto->setId($this->form_validation->set_value('id_foto'));
                $this->slider_foto->setId_mod_sliders($this->form_validation->set_value('id_slider'));
                
                $this->slider_foto->ulozitFoto();
                redirect("admin/sliders/pridajfotoslider/".$this->form_validation->set_value('id_slider'));
            } else {
                
            }
        }
    }

    public function pridajfotoslider($id_slider) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $slider = $this->slider->getSliderById($id_slider);

            $foto = $this->sliders_data_m->getFotoSlider($id_slider);

            $this->template_admin->load('admin/template', 'admin/modules/slider/slider_pridaj_foto', array('slider' => $slider, 'foto'=>$foto));
        }
    }
    
    
    public function editfotoslider($id_foto){
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {

            $foto = $this->sliders_data_m->getFotoData($id_foto);

            $this->load->view('admin/modules/slider/slider_foto_edit', array('foto'=>$foto), FALSE);
        }
    }
    
    public function ajaxPoradie(){
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
             $data = $this->input->post('fotky', TRUE);
             $data = explode(",", $data);
             $this->slider_foto->upravPoradieFoto($data);
        }
    }
    
    public function odstranfoto($id_slider, $id_foto){
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $this->slider_foto->odstranFoto($id_foto);
            redirect("admin/sliders/pridajfotoslider/".$id_slider);
        }
    }

}

