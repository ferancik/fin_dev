<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Nastavenia_lib {

    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('admin/nastavenia_m', '', TRUE);
    
    }
    
    public function getNastavenia(){
       return $this->CI->nastavenia_m->getNastavenia();
    }
    
     public function upravitNastavenia($data){
       return $this->CI->nastavenia_m->upravitNastavenia($data);
    }
    
    
   
}
