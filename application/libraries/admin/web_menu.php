<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class web_menu {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();

        $this->CI->load->model('admin/admin_web_menu_m', '', TRUE);
        $this->CI->load->model('admin/admin_web_language_m', '', TRUE);
    }
    
    public function getWebMenu($identifikator){
        return $this->CI->admin_web_menu_m->getRootMenuIdentifikator($identifikator);
    }
    
     public function getOneMenuKontroler($kontroler) {
        return $this->CI->admin_web_menu_m->getOneMenuKontroler($kontroler);
    }
  
}

