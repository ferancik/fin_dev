<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AdminMenuData {
    public $id;
    public $nazov;
    public $kontroler;
    public $id_parrent;
    public $icon;
    public $type;
    public $options;
    public $poradie;
    public $url;
     public $zobrazit;
    public $typ_menu;
    public $parrents = array();
}
  
class Admin_menu {
    
    private $CI;

    function __construct() {
        $this->CI = & get_instance();
       $this->CI->load->model('admin/admin_menu_m','',TRUE);
    }
    
    public function getRootMenu($all = false) {
        return $this->CI->admin_menu_m->getRootMenu($all);
    }
    
    public function getOneMenuKontroler($kontroler) {
        return $this->CI->admin_menu_m->getOneMenuKontroler($kontroler);
    }
    
    public function getOneMenuKontrolerLike($kontroler){
         return $this->CI->admin_menu_m->getOneMenuKontrolerLike($kontroler);
    }
    
     public function getOneMenuURLLike($url){
         return $this->CI->admin_menu_m->getOneMenuURLLike($url);
    }
}
