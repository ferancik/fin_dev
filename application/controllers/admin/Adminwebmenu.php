<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adminwebmenu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        $this->load->model('admin/admin_web_menu_m');
        $this->load->model('admin/admin_web_language_m');
        $this->load->model('admin/modules/stranky/stranky_m');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('admin/modules/stranky/stranky_lib');
    }

    public function zobraz($idTypMenu) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect(('admin/auth/login/'));
        } else {
            $data = $this->admin_web_menu_m->getRootMenu($idTypMenu);
            $this->template_admin->load('admin/template', 'admin/adminwebmenu/index', array('data' => $data, 'idTypMenu' => $idTypMenu));
        }
    }

    private function saveMenu($data, $kolko, $rootK) {
        foreach ($data as $root) {
            if (is_array($root)) {
                //preVarDump($root);

                $this->saveMenu($root, ++$kolko, $root[0]);
            } else {
                $ciarka = '';
                for ($i = 0; $i < $kolko; $i++) {
                    $ciarka .='.';
                }
                echo $rootK . ' - ' . $ciarka . $root . '<br />';
            }
        }
    }

    public function savePoradie($idTypMenu) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect(site_url('admin/auth/login/'));
        } else {
            $udaje = $this->input->post(null, TRUE);
            $udaje = $udaje['polozky'];
            $polozky = explode(",", $udaje);

            $i = 0;
            foreach ($polozky as $nazov) {
                
                $temp = new stdClass();
                $temp->id = $nazov;
                $temp->poradie = $i;

                $this->admin_web_menu_m->editMenuTypID($temp,$idTypMenu);
                $i++;
            }
        }
    }

    public function saveForm($idTypMenu, $idMenu) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
       
            $data = $this->admin_web_menu_m->getOneMenu($idMenu);

            $this->form_validation->set_rules('kontroler', 'Kontroler', 'trim|xss_clean');
            $this->form_validation->set_rules('stranky', 'Stranky', 'xss_clean');
            $this->form_validation->set_rules('icon', 'Icon', 'xss_clean');
            $this->form_validation->set_rules('options', 'Options', 'xss_clean');
            $this->form_validation->set_rules('parrent', 'Parrent', 'xss_clean');
     
                
            $alljazyky = $this->admin_web_language_m->getActiveLanguage();
            foreach ($alljazyky as $value) {
                $this->form_validation->set_rules('jazyk_' . $value->id . '', 'Jazyk ' . ucfirst($value->name), 'xss_clean');
            }

            if ($this->form_validation->run()) {
                $temp = new stdClass();
                $temp->id = "NULL";
                $temp->type = 0;
                       
      
                $temp->id_parrent = $this->form_validation->set_value('parrent');
                
                $temp->typ_menu = $idTypMenu;
                $optT = $this->form_validation->set_value('options');
                $temp->options = (($optT != "") ? $this->form_validation->set_value('options') : "");
                $iconT = $this->form_validation->set_value('icon');
                $temp->icon = (( $iconT != "" ) ? $iconT : "");
                $kontrolerB = false;
                $kontrolerS = false;
                $kontroler = $this->form_validation->set_value('kontroler');
                if ($kontroler != "" && strlen($kontroler) > 0) {
                    $kontrolerB = true;
                }
                $stranky = $this->form_validation->set_value('stranky');
                if ($stranky != '' && strlen($stranky) > 0) {

                    $kontrolerS = true;
                }

                if (!$kontrolerS && !$kontrolerB) {
                    $this->session->set_flashdata('sprava', "error|Musi byt zadany kontroler, alebo vybrana stranka");
                    redirect('admin/adminwebmenu/zobraz/' . $idTypMenu);
                }

                if ($kontrolerB) {
                    $temp->kontroler = $kontroler;
                } else if ($kontrolerS) {
                    $dataStranky = $this->stranky_m->nacitajStrankuSeoURL(str_replace($this->config->item('CONTROLER_PRE_OBSLUHU_UZIVATELSKYCH_STRANOK'), '', $stranky));
                    $temp->type = 1;
                    //preVarDump($dataStranky);
                    if (!$dataStranky) {
                        $this->session->set_flashdata('sprava', "error|Vybrana stranka neexistuje");
                        redirect('admin/adminwebmenu/zobraz/' . $idTypMenu);
                    } else {
                        $temp->kontroler = $this->config->item('CONTROLER_PRE_OBSLUHU_UZIVATELSKYCH_STRANOK').$dataStranky[0]->seo_url;
                    }
                }

                if (!$data) {
                    $ok = $this->admin_web_menu_m->insertMenu($temp);
                    $temp->id = $ok;
                } else {
                    $temp->id = $data->id;
                    $ok = $this->admin_web_menu_m->editMenu($temp);
                }

                //edit jazyk
                $alljazyky = $this->admin_web_language_m->getActiveLanguage();
                foreach ($alljazyky as $value) {
                    $jazykNew = $this->form_validation->set_value('jazyk_' . $value->id . '');
                    if (isset($jazykNew)) {
                        $this->admin_web_menu_m->editMenuLanguage($temp->id, $value->id, $jazykNew);
                    }
                }

                if (!$data) {
                    $this->session->set_flashdata('sprava', "save|Nove menu bolo vytvorene");
                } else {

                    $this->session->set_flashdata('sprava', "save|Menu bolo aktualizovane");
                }
                redirect('admin/adminwebmenu/zobraz/' . $idTypMenu);
            }
        }
    }

    
    
    function toSelect($arr, $depth = 1, $pole = array(),$idMenu) {
        $html = $pole;

        foreach ($arr as $v) {

            if ($idMenu != $v->id){
            $html[$v->id] = str_repeat('-', $depth) . '' . $v->nazov;
            }

            if (count($v->parrents) > 0) {
                $html = $this->toSelect($v->parrents, $depth + 1, $html,$idMenu);
            }
        }

        return $html;
    }
    
    public function delMenu($idMenu) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect(site_url('admin/auth/login/'));
        } else {
            $data = $this->admin_web_menu_m->getOneMenu($idMenu);
            if (!$data) {
                $this->session->set_flashdata('sprava', "error|Menu ktore chcete odstranit neexistuje");
                redirect('admin/adminwebmenuall/');
            } else {
                $this->admin_web_menu_m->delMenu($idMenu);
                $this->session->set_flashdata('sprava', "ok|Menu bolo odstranene");
                redirect('admin/adminwebmenu/zobraz/' . $data->typ_menu);
            }
        }
    }

    public function editMenu($idTypMenu, $idMenu) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $this->load->library('admin/modules/stranky/stranky_lib');


            $texty = array();
            $data = $this->admin_web_menu_m->getOneMenu($idMenu);

            if (!$data) {
                $texty['nazov'] = 'Pridaj nove menu';
            } else {
                $texty['nazov'] = 'Uprava menu';
            }

           $parrents = $this->admin_web_menu_m->getRootMenu($idTypMenu);
           
            $parrentsSelect = $this->toSelect($parrents,1,array(),$idMenu);
            $parrentsSelect[0] = "Root Kategoria";

            $stranky = $this->stranky_lib->getStranky();
            $strankyT = array();
            $strankyT[""] = "- Alebo vyberte stranku -";
            foreach ($stranky as $value) {
                $strankyT[$this->config->item('CONTROLER_PRE_OBSLUHU_UZIVATELSKYCH_STRANOK').$value->seo_url] = $value->nazov;
            }

            $alljazyky = $this->admin_web_language_m->getActiveLanguage();

            $this->load->view('admin/adminwebmenu/editmenu', array('parrentsSelect' => $parrentsSelect, 'alljazyky' => $alljazyky, 'data' => $data, 'texty' => $texty['nazov'], 'stranky' => $strankyT, 'idTypMenu' => $idTypMenu), FALSE);
        }
    }

    public function save() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect(site_url('admin/auth/login/'));
        } else {
            $pole = json_decode($_POST['menu']);
            $pole = $pole[0][1];
//            preVarDump($pole);


            foreach ($pole as $root) {
                if (is_array($root)) {
                    foreach ($root as $value) {
                        if (is_array($value)) {
                            foreach ($value as $value2) {
                                if (is_array($value2)) {
                                    foreach ($value2 as $value3) {
                                        if (is_array($value3)) {
                                            foreach ($value3 as $value4) {
                                                if (is_array($value4)) {
                                                    $this->admin_web_menu_m->editMenuParrent($value[0], $value4[0]);
                                                    echo $value[0] . ' - .....' . $value4[0] . '<br />';
                                                } else {
                                                    $this->admin_web_menu_m->editMenuParrent($value2[0], $value4);
                                                    echo $value2[0] . ' - .....' . $value4 . '<br />';
                                                }
                                            }
                                        } else {
                                            $this->admin_web_menu_m->editMenuParrent($root[0], $value3);
                                            echo $root[0] . ' - ....' . $value3 . '<br />';
                                        }
                                    }
                                } else {
                                    $this->admin_web_menu_m->editMenuParrent($root[0], $value2);
                                    echo $root[0] . ' - ...' . $value2 . '<br />';
                                }
                            }
                        } else {
                            $this->admin_web_menu_m->editMenuParrent(0, $value);
                            echo '0 - ..' . $value . '<br />';
                        }
                    }
                } else {
                    $this->admin_web_menu_m->editMenuParrent('0', $root);
                    echo '0 - ' . $root . '<br />';
                }
            }
        }
    }

}

