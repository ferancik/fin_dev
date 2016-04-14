<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dokumenty extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        $this->load->library('admin/modules/dokumenty/Dokument');
        
        $this->lang->load('dokumenty');
    }

    public function index() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $dokumenty = $this->dokument->getDokumenty();
            $this->template_admin->load('admin/template', 'admin/modules/dokumenty/index', array('dokumenty' => $dokumenty));
        }
    }

    public function pridatdokument($id) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $dokument = $this->dokument->getOneDokument($id);
            $this->template_admin->load('admin/template', 'admin/modules/dokumenty/form', array('dokument' => $dokument));
        }
    }

    public function ulozit() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('nazov', 'nazov', 'trim|required|max_length[50]|xss_clean');
            $this->form_validation->set_rules('popis', 'popis', 'trim|max_length[250]|xss_clean');
            $this->form_validation->set_rules('id_dokument', 'id_dokument', 'trim|xss_clean');
            
            if ($this->form_validation->run() ) {
                
                $this->dokument->setId($this->form_validation->set_value('id_dokument'));
                $this->dokument->setNazov($this->form_validation->set_value('nazov'));
                $this->dokument->setPopis($this->form_validation->set_value('popis'));


                $config['upload_path'] = $this->config->item('PATH_DOKUMENTY_FOLDER');
                $config['allowed_types'] = 'jpg|jepg|png|gif|tif|tiff|bmp|tiff|doc|docx|xls|xlsx|ppt|pptx|pdf|txt|';
                $config['max_size'] = '100000';
                $config['remove_spaces'] = FALSE;
                
                if (isset($_POST['id_dokument']) && $_POST['id_dokument'] == 'novy') {
//                    if (isset($_FILES['dokument']['name']) && strlen($_FILES['dokument']['name'])>0) {
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('dokument')) {
                            $this->upload->display_errors();
                            $this->session->set_flashdata('sprava', "error|" . $this->upload->display_errors() . "!");
                            redirect("admin/dokumenty/pridatdokument/novy");
                        } else {
                            $data_image = $this->upload->data();
                            $this->dokument->setDokument($data_image['file_name']);
                        }
//                    }else{
//                        $this->session->set_flashdata('sprava', "error|Nemáte vybraný žiadny súbor!");
//                        redirect("admin/dokumenty/pridatdokument/novy");
//                    }
                }else{
                    if (isset($_FILES['dokument']['name']) && strlen($_FILES['dokument']['name'])>0) {
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('dokument')) {
                            $this->upload->display_errors();
                            $this->session->set_flashdata('sprava', "error|" . $this->upload->display_errors() . "!");
                        } else {
                            $data_image = $this->upload->data();
                            $this->dokument->setDokument($data_image['file_name']);
                        }
                    }
                }
                $sprava = $this->dokument->ulozit();
                if ($sprava == 'novy') {
                    $this->session->set_flashdata('sprava', "save|".lang('document_save_ok'));
                } elseif ($sprava == "chyba") {
                    $this->session->set_flashdata('sprava', "error|".lang('when_save_document_fail'));
                } elseif ($sprava == 'update') {
                    $this->session->set_flashdata('sprava', "save|".lang('document_ok_update'));
                }
               redirect('admin/dokumenty');
            } else {
                $this->session->set_flashdata('sprava', "error|".lang('not_selected_document')."Nebol vybraný dokument.");
                redirect('admin/dokumenty/pridatdokument/novy');
            }
        }
    }

    public function odstranit($id) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            if ($this->dokument->odstranitDokument($id)) {
                $this->session->set_flashdata('sprava', "ok|".lang('document_deleted')."Dokument bol úspešne odstránený.");
            } else {
                $this->session->set_flashdata('sprava', "ok|".lang('document_could_properly_removed')."Dokument nebolo možné korektne odstrániť.");
            }
            redirect("admin/dokumenty");
        }
    }

}
