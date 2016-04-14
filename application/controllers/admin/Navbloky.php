<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Navbloky extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        
        $this->load->library('admin/modules/navbloky/Navblok');
    }

    public function index() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $navBloky = $this->navblok->getNavBloky();
            $this->template_admin->load('admin/template', 'admin/modules/nav_bloky/index', array('navbloky'=>$navBloky));
        }
    }
    
    public function pridajnavblok($id){
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $navBlok = $this->navblok->getNavBlok($id);
            $this->template_admin->load('admin/template', 'admin/modules/nav_bloky/form', array('navBlok'=>$navBlok));
        }
    }
    
    public function ulozit(){
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('id_navblok', 'id_navblok', 'trim|xss_clean');
            $this->form_validation->set_rules('nadpis', 'nadpis', 'trim|required|max_length[45]|xss_clean');
            $this->form_validation->set_rules('url', 'url', 'trim|xss_clean');
            $this->form_validation->set_rules('icon', 'icon', 'trim|xss_clean');
            $this->form_validation->set_rules('text', 'text', 'trim|required|xss_clean');
            
            if ($this->form_validation->run()) {

                $config['upload_path'] = $this->config->item('PATH_NAVBLKY_FOLDER');
                $config['allowed_types'] = 'jpg|jepg|png|gif|tif|tiff|bmp';
                $config['max_size'] = '10000';
                $config['remove_spaces'] = FALSE;

                $this->load->library('upload', $config);
                if (isset($_FILES['icon'])) {
                    if (!$this->upload->do_upload('icon')) {
                        $this->upload->display_errors();
                        $this->session->set_flashdata('sprava', "error|Chyba pri prenose súboru!");
                        //redirect("admin/navbloky/pridajnavblok/novy");
                    } else {
                        $data_image = $this->upload->data();
                        $this->navblok->setIcon($data_image['file_name']);
                    }
                }
                $this->navblok->setId($this->form_validation->set_value('id_navblok'));
                $this->navblok->setNadpis($this->form_validation->set_value('nadpis'));
                $this->navblok->setOdkaz_na_stranku(($this->form_validation->set_value('url')=="")?"#":$this->form_validation->set_value('url'));
                $this->navblok->setText($this->form_validation->set_value('text'));

                $sprava = $this->navblok->ulozit();
                if($sprava == "novy"){
                    $this->session->set_flashdata('sprava', "save|Nový navigačný blok úspešne pridaný.");
                }else{
                    $this->session->set_flashdata('sprava', "save|Navigačný blok bol úspešne aktualizovaný.");
                }
                
                redirect("admin/navbloky");
            } else {
                
            }
            
            
            echo "preslo";
        }
    }
    
    public function odstranit($id){
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            if($this->navblok->odstranNavBlok($id)){
                $this->session->set_flashdata('sprava', "ok|Navigačný blok bol úspešne odstránený.");
            }  else {
                $this->session->set_flashdata('sprava', "error|Navigačný blok sa nepodarilo odstrániť.");
            }
            
            redirect("admin/navbloky");
        }
    }
    
    public function ajaxporadie(){
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->input->post("navbloky", NULL);
            $data = explode(",", $data);
            preVarDump($data);
            $this->navblok->upravPoradie($data);
            
//            $navBlok = $this->navblok->getNavBlok($id);
//            $this->template_admin->load('admin/template', 'admin/modules/nav_bloky/form');
        }
    }

}

