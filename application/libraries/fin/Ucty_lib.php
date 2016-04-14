<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ucty_lib
 *
 * @author frantisekferancik
 */
class Ucty_lib {
    
    private $CI; 
    
    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->model("fin/ucet_m");
    }
    
    
    public function insert($data){
        $insert_data = array(
            'name' => $data['name'],
            'banka' => $data['banka'],
            'pobocka' => $data['banka_pobocka'],
            'cislo_uctu' => $data['cislo_uctu'],
            'swift' => $data['swift'],
            'iban' => $data['iban'],
        );
        
        if($data['ucet_id'] == 0){//insert new ucet
            return $this->CI->ucet_m->insert($data['firma_id'], $insert_data);
        }else{//update ucet
            return $this->CI->ucet_m->update($data['firma_id'], $insert_data);
        }
    }
}
