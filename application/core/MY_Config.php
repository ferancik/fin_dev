<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Config extends CI_Config {

    public function __construct() {
        parent::__construct();
    }

    // uchovava koncove cislo strany
    public $koncoveCislo = null;

    function itemDB($item) {
        //        // nacitam z db
        $CI = & get_instance();
        $CI->load->model('admin/nastavenia_m', '', TRUE);
        $setting = $CI->nastavenia_m->getNastavenia();


        foreach ($setting as $key => $value) {
            if ($key == $item) {
                return $value;
            }
        }
        return null;
    }

    function site_url($uri = '') {
        if (is_array($uri)) {
            $uri = implode('/', $uri);
        }
        $urlOld = $uri;

        if (is_string($uri)) {
            // ak je to admin
            $urlT = explode('/', $uri);
            if ($urlT[0] == 'admin') { // ak je admin
                $CI = & get_instance();

                //$uri = 'admin/pages/view';

                if ($uri[strlen($uri) - 1] == '/') {
                    $uri = substr($uri, 0, -1);
                }

                $kontroler = $this->_replace_controler($uri);
                $CI->load->model('admin/admin_menu_m', '', TRUE);

                $cesta = $CI->admin_menu_m->vytvorCestu($kontroler);
//                preVarDump($kontroler);  
//                exit(); 
                // $data = $CI->admin_menu_m->getOneMenuKontroler($kontroler);
                if ($cesta != '') {
                    $uri = 'admin/' . $cesta . ((is_array($this->koncoveCislo) ? '/' . implode('/', $this->koncoveCislo) : ''));
                    $this->koncoveCislo = null;
                } else {
                    // aby dalo normalnu cestu ak nenaslo v db
                    $uri = $urlOld;
                }
            }
        }


        if (function_exists('get_instance')) {
            $CI = & get_instance();
            $uri = $CI->lang->localized($uri);
        }


        return parent::site_url($uri);
    }

    public function _replace_controler($uri) {
        $urlNew = '#';
        $urlT = explode('/', $uri);
        if ($urlT[0] == 'admin') {
            if ($urlT[1] != '#') { // ak prvy neni kontroler
                if (count($urlT) > 1) {
                    $urlNew = '';
                    for ($i = 1; $i < count($urlT); $i++) {
                        if (!is_numeric($urlT[$i])) {
                            $urlNew .=$urlT[$i] . '/';
                        } else {
                            $this->koncoveCislo[] = $urlT[$i];
                        }
                    }
                    $urlNew = substr($urlNew, 0, -1);
                }
            }
        }
        return $urlNew;
    }

}

// END MY_Config Class

/* End of file MY_Config.php */
/* Location: ./application/core/MY_Config.php */