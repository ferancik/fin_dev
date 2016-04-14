<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Opravneniaskupiny extends CI_Controller {

    public function __construct() {
         
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('admin/opravneniaskupiny_m', '', TRUE);
       
        }

    public function index() {
        
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $data = $this->opravneniaskupiny_m->getOpravnenia();

            $this->template_admin->load('admin/template', 'admin/opravneniaskupiny/index', array('data' => $data));
        }
    }

    public function zmazat($idOpravnenia) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin() && $idOpravnenia) {
            redirect('admin/auth/login/');
        } else {

            $data = $this->opravneniaskupiny_m->getOneOpravnenie($idOpravnenia);
            if (!$data || $data->id == 1) {
                $this->session->set_flashdata('sprava', "error|Vybrane opravnenie neexistuje");
                redirect('admin/opravneniaskupiny/');
            } else {
                $this->opravneniaskupiny_m->delOpravnenie($data->id);
                $this->session->set_flashdata('sprava', "info|Vybrana skupina bola odstranena");
                redirect('admin/opravneniaskupiny/');
            }
        }
    }

    function toSelect($arr, $depth = 1, $pole = array()) {
        $html = $pole;

        foreach ($arr as $v) {

            if ($idMenu != $v->id) {
                $html[$v->id] = "|".str_repeat('--', $depth) . ' ' . $v->nazov;
            }
            if (count($v->parrents) > 0) {
                $html = $this->toSelect($v->parrents, $depth + 1, $html);
            }
        }

        return $html;
    }

    public function uprava($id) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            if ($id != 1) {


                $texty = array();
                $data = $this->opravneniaskupiny_m->getOneOpravnenie($id);
                if (!$data) {
                    $texty['nazov'] = 'Pridat novu skupinu';
                } else {
                    $texty['nazov'] = 'Upravit skupinu';
                }
                $this->form_validation->set_rules('nazov', 'Nazov', 'trim|required|max_length[200]|xss_clean');
                $this->form_validation->set_rules('popis', 'popis', 'xss_clean');
                $this->form_validation->set_rules('menu_povolene', 'Opravnenia', 'xss_clean');

                if ($this->form_validation->run()) {

                    $temp = new stdClass();
                    $temp->id = "NULL";
                    $temp->nazov = $this->form_validation->set_value('nazov');
                    $temp->popis = $this->form_validation->set_value('popis');
                    $temp->time = time();

                    if (!$data) {
                        $ok = $this->opravneniaskupiny_m->insertOpravnenie($temp);
                        $idTemp = $ok;
                    } else {
                        $temp->id = $data->id;
                        $ok = $this->opravneniaskupiny_m->editOpravnenie($temp);
                        $idTemp = $data->id;
                    }

                    $menu_povolene = $_POST['menu_povolene'];
                    // del all permission
                    $this->opravneniaskupiny_m->delOpravnenieMenu($idTemp);

                    foreach ($menu_povolene as $value) {
                        $menu_povolene_data = new stdClass();
                        $menu_povolene_data->admin_permission = $idTemp;
                        $menu_povolene_data->admin_menu = $value;
                        $this->opravneniaskupiny_m->insertOpravnenieMenu($menu_povolene_data);
                    }

                    if (!$data) {
                        $this->session->set_flashdata('sprava', "save|Skupina bola pridana");
                    } else {

                        $this->session->set_flashdata('sprava', "save|Skupina bola aktualizovana");
                    }
                    redirect('admin/opravneniaskupiny');
                }

                $menu_data = $this->admin_menu->getRootMenu(true);
                $menu_data_temp = array();
                
               $menu_data_temp =  $this->toSelect($menu_data);
 




//                foreach ($menu_data as $value) {
//                    if (count($value->parrents) > 0) {
//                        foreach ($value->parrents as $root_menu_parrents) {
//
//                            if (count($root_menu_parrents->parrents) > 1) {
//                                for ($i = 0; $i < count($root_menu_parrents->parrents); $i++) {
//                                    $menu_data_temp[$root_menu_parrents->parrents[$i]->id] = $value->nazov . " -> " . $root_menu_parrents->nazov . " -> " . $root_menu_parrents->parrents[$i]->nazov;
//                                }
//                            } else {
//                                $menu_data_temp[$root_menu_parrents->id] = $value->nazov . " -> " . $root_menu_parrents->nazov;
//                            }
//                        }
//                    } else {
//
//                        $menu_data_temp[$value->id] = $value->nazov . " -> " . $value->nazov;
//                    }
//                }


                //  preVarDump($menu_data_temp);

                $opravneniaMenu = $this->opravneniaskupiny_m->getOpravneniaMenu($id);
                $opravneniaMenuTemp = array();
                foreach ($opravneniaMenu as $value) {
                    $opravneniaMenuTemp[$value->admin_menu] = $value->admin_menu;
                }

                $this->template_admin->load('admin/template', 'admin/opravneniaskupiny/uprava', array('data' => $data, 'text' => $texty, 'menu_data' => $menu_data_temp, 'oznacene_menu' => $opravneniaMenuTemp));
            } else {
                $this->session->set_flashdata('sprava', "info|Tato kategoria sa nemoze editovat");
                redirect('admin/opravneniaskupiny');
            }
        }
    }

}
