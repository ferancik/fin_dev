<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Template_admin {

    var $template_data = array();

    function set($name, $value) {
        $this->template_data[$name] = $value;
    }

    function load($template = '', $view = '', $view_data = array(), $return = FALSE) {
        // nacitam nastavenia routra, a vyberiem menu
        global $RTR;

        $this->CI = & get_instance();
        $this->CI->lang->load('more_pages');

        if (!isset($this->CI->tank_auth)) {
            $this->CI->load->library('admin/tank_auth_groups', '', 'tank_auth');
            $this->CI->lang->load('tank_auth');
        }

        if (!isset($this->CI->spravapouzivatelov_m)) {
            $this->CI->load->model('admin/spravapouzivatelov_m', '', TRUE);
        }
        if (!isset($this->CI->opravneniaskupiny_m)) {
            $this->CI->load->model('admin/opravneniaskupiny_m', '', TRUE);
        }
        if (!isset($this->CI->admin_menu)) {
            $this->CI->load->library('admin/admin_menu');
        }

        $user_login = $this->CI->spravapouzivatelov_m->getOneUser($this->CI->tank_auth->get_user_id());

        $dmin_permission_id = $user_login->admin_permission_id;
        $opravneniaMenu = $this->CI->opravneniaskupiny_m->getOpravneniaMenu($dmin_permission_id);
        $root_admin_menu = $this->CI->admin_menu->getRootMenu();
//preVarDump($root_admin_menu);
//exit;  
        // generate menu
        $root_admin_menuTemp = $RTR->generateAdminMenu($root_admin_menu, $dmin_permission_id, $opravneniaMenu);
        $this->set('root_admin_menu', $root_admin_menuTemp);
//        preVarDump($root_admin_menuTemp);
//        exit;
    ///   

        // generate breadcrumb
        $segs = $this->CI->uri->segment_array();

        $poskladanaUrl = '';
        for ($i = 3; $i <= count($segs); $i++) {
            $poskladanaUrl .=$segs[$i] . '/';
        }
        $poskladanaUrl = substr($poskladanaUrl, 0, -1);


        $result = array_filter($this->CI->config->item('STRANKY_NA_KTORYCH_NEZOBRAZIT_BREADCRUMB'), 
                function ($item) use ($poskladanaUrl) {
                    preg_match("/^".$item."/", $poskladanaUrl, $matches, PREG_OFFSET_CAPTURE);
                    //preVarDump($matches);
                      if($matches!== NULL && count($matches)!=0){
                          return TRUE;
                      }
//                    if (strpos($item, $poskladanaUrl) !==false) {
//                        return true;
//                    }
                    return false;
                });


//        preVarDump($result);
//        exit;
        // kontrola
        if (count($result) == 0) {
            $cestaBreadcrumb = '';
            $cestaBreadcrumb .= '<ul class="breadcrumb">';
            $cestaBreadcrumb .= '<li class="active"><a href="' . site_url('admin/dashboard') . '">Dashboard</a>' . (($segs[3] != 'dashboard') ? '<span class="divider">/</span>' : '') . '</li>';

            $nenacitavatTieto = array('dashboard');

            for ($i = 3; $i <= count($segs); $i++) {
                $menuT = $this->CI->admin_menu->getOneMenuURLLike($segs[$i]);
                if ($menuT->kontroler != '' && !in_array($menuT->kontroler, $nenacitavatTieto)) {

                    $budeCiarka = (($i != count($segs)) ? '<span class="divider">/</span>' : '');
                    if ($menuT->kontroler == '#') { // ak je kontrolne mneu
                        $cestaBreadcrumb .= '<li class="active">' . $menuT->nazov . '' . $budeCiarka . '</li>';
                    } else {
                        $cestaBreadcrumb .= '<li class="active"><a href="' . site_url('admin/' . $menuT->kontroler) . '">' . $menuT->nazov . '</a>' . $budeCiarka . '</li>';
                    }
                }
            }
            $cestaBreadcrumb .= '</ul>';
            $this->set('breadcrumb', $cestaBreadcrumb);
        } else {
            $this->set('breadcrumb', '');
        }

        $menuKdeSom = $this->CI->admin_menu->getOneMenuKontroler($RTR->getActiveMenu());
        $this->set('menu_Kde_Som', $menuKdeSom);


        $this->CI->load->model('admin/admin_language_m');
        $langs = $this->CI->admin_language_m->getActiveLanguage();
        $this->set('langs', $langs);


        $temp_username = $this->CI->tank_auth->get_username();
        $this->set('root_username', $temp_username);


        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));

        return $this->CI->load->view($template, $this->template_data, $return);
    }

}

/* End of file Template.php */
/* Location: ./system/application/libraries/Template.php */