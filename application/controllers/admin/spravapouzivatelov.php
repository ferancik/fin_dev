<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Spravapouzivatelov extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('admin/spravapouzivatelov_m', '', TRUE);
        $this->load->model('admin/opravneniaskupiny_m', '', TRUE);
    }

    public function index() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->spravapouzivatelov_m->getUzivatelia();
            $user_login = $this->spravapouzivatelov_m->getOneUser($this->tank_auth->get_user_id());
            $this->template_admin->load('admin/template', 'admin/spravapouzivatelov/index', array('data' => $data, 'prihlaseny_user' => $user_login));
        }
    }

    public function zmazat($idUser) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin() && $idUser) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->spravapouzivatelov_m->getOneUser($idUser);
            if (!$data) {
                $this->session->set_flashdata('sprava', "error|Vybrany pouzivatel neexistuje");
                redirect('admin/spravapouzivatelov/');
            } else {
                $this->spravapouzivatelov_m->delUser($data->id);
                $this->session->set_flashdata('sprava', "info|Uzivatel bol odstraneny");
                redirect('admin/spravapouzivatelov/');
            }
        }
    }

    public function uprava($id) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $texty = array();
            $data = $this->spravapouzivatelov_m->getOneUser($id);
            if (!$data) {
                $texty['nazov'] = 'Pridat noveho pouzivatela';
            } else {
                $texty['nazov'] = 'Upravit pouzivatela';
            }
            $this->form_validation->set_rules('username', 'username', 'trim|required|max_length[200]|xss_clean');
            $this->form_validation->set_rules('email', 'email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('opravnenia', 'opravnenia', 'trim|required|xss_clean');

            $this->form_validation->set_rules('password', 'password', '');

            if ($this->form_validation->run()) {

                $temp = new stdClass();
                $temp->id = "NULL";
                $temp->username = $this->form_validation->set_value('username');
                $temp->email = $this->form_validation->set_value('email');
                $temp->admin_permission = $this->form_validation->set_value('opravnenia');



                if (!$data) {
                    $hasher = new PasswordHash(
                            $this->config->item('phpass_hash_strength', 'admin/tank_auth'), $this->config->item('phpass_hash_portable', 'admin/tank_auth'));
                    // Hash new password using phpass
                    $hashed_password = $hasher->HashPassword($this->form_validation->set_value('password'));
                    $temp->password = $hashed_password;

                    $ok = $this->spravapouzivatelov_m->insertUser($temp);
                } else {
                    $temp->id = $data->id;

                    if ($this->form_validation->set_value('password') != '') {

                        $hasher = new PasswordHash(
                                $this->config->item('phpass_hash_strength', 'admin/tank_auth'), $this->config->item('phpass_hash_portable', 'admin/tank_auth'));
                        // Hash new password using phpass
                        $hashed_password = $hasher->HashPassword($this->form_validation->set_value('password'));

                        $temp->password = $hashed_password;
                    }

                    $ok = $this->spravapouzivatelov_m->editUser($temp);
                }

                if (!$data) {
                    $this->session->set_flashdata('sprava', "save|Pouzivatel bol pridany");
                } else {

                    $this->session->set_flashdata('sprava', "save|Pouzivatel bol upraveny");
                }
                redirect('admin/spravapouzivatelov/');
            }
            $data_opravnenia = $this->opravneniaskupiny_m->getOpravnenia();
            $data_opravnenia_temp = array();
            $data_opravnenia_temp[""] = "- Vyber moznost -";

            $user_login = $this->spravapouzivatelov_m->getOneUser($this->tank_auth->get_user_id());


            foreach ($data_opravnenia as $value) {
                if ($user_login->admin_permission == 1) {
                    $data_opravnenia_temp[$value->id] = $value->nazov;
                }
                if ($value->id != 1) {
                    $data_opravnenia_temp[$value->id] = $value->nazov;
                }
            }
            $this->template_admin->load('admin/template', 'admin/spravapouzivatelov/uprava', array('data' => $data, 'text' => $texty, 'data_opravnenia' => $data_opravnenia_temp, 'prihlaseny_user' => $user_login));
        }
    }

}

