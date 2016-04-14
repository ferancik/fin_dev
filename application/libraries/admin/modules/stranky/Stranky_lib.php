<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('StrankyData.php');

class Stranky_lib {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('admin/modules/stranky/stranky_m', '', TRUE);
    }

    public function getStranky() {

        return $this->CI->stranky_m->nacitajStranky();
    }

    public function getOneStranka($idStranky) {
        return $this->CI->stranky_m->nacitajStrankuID($idStranky);
    }
    
    public function vlozStranku($data) {
      return  $this->CI->stranky_m->vlozitStranku($data);
    }
    
    public function upravStranku($data) {
         return  $this->CI->stranky_m->upravitStranku($data);
    }
    
    public function odstranitStranku($data) {
        $this->CI->stranky_m->odstranitStranku($data);
        
    }
    
    public function getStrankaKOD($kod_pre_zavolanie) {
       return $this->CI->stranky_m->getStrankaKODPrelozene($kod_pre_zavolanie);
        
    }

    public function getStrankaURL($urlStranky){
        return $this->CI->stranky_m->getStrankaURLPrelozene($urlStranky);
    }
           
}

