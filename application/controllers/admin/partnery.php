<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Partnery extends CI_Controller {

    private $image_path_partner;

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        $this->load->library('admin/modules/partnery/Partner');

        $this->image_path_partner = $this->config->item('PATH_PARTNER_FOLDER');
    }

    public function index() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $partnery = $this->partner->getAllPartners();
            $this->template_admin->load('admin/template', 'admin/modules/partnery/index', array('partnery' => $partnery));
        }
    }

    public function pridatpartnera($id) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $partner = $this->partner->getPartner($id);
            $this->template_admin->load('admin/template', 'admin/modules/partnery/form', array('partner' => $partner));
        }
    }

    public function ulozit() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {

            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('id_partner', 'id_partner', 'trim|xss_clean');
            $this->form_validation->set_rules('nazov', 'nazov', 'trim|required|max_length[50]|xss_clean');
            $this->form_validation->set_rules('url', 'url', 'trim|valid_url|xss_clean');
            $this->form_validation->set_rules('popis', 'popis', 'trim|max_length[100]|xss_clean');
            $this->form_validation->set_rules('logo', 'popis', 'trim|xss_clean');

            if ($this->form_validation->run()) {

                $config['upload_path'] = $this->image_path_partner;
                $config['allowed_types'] = 'jpg|jepg|png|gif|tif|tiff|bmp';
                $config['max_size'] = '10000';
                $config['remove_spaces'] = FALSE;

                $this->load->library('upload', $config);
                if (isset($_FILES['logo'])) {
                    if (!$this->upload->do_upload('logo')) {
                        $this->upload->display_errors();
                    } else {
                        $data_image = $this->upload->data();
                        $this->partner->setLogo($data_image['file_name']);
                    }
                }
                $this->partner->setNazov($this->form_validation->set_value('nazov'));
                $this->partner->setUrl(($this->form_validation->set_value('url')=="")?"#":$this->form_validation->set_value('url'));
                $this->partner->setPopis($this->form_validation->set_value('popis'));
                $this->partner->setId($this->form_validation->set_value('id_partner'));

                $this->partner->ulozit();
                $this->session->set_flashdata('sprava', "save|Nový partner úspešne pridaný");
                redirect("admin/partnery");
            } else {
                
            }
        }
    }
    
    
    public function deletpartner($id){
        
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            if($this->partner->deletPartner($id)){
                $this->session->set_flashdata('sprava', "ok|Partner bol úspešne odstránený.");
            }else{
                $this->session->set_flashdata('sprava', "error|Partner nebol odstránený!");
            }
            redirect("admin/partnery");
        }
    }
    
    
    

}

