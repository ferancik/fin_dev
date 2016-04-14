<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Disponent_lib
 *
 * @author frantisekferancik
 */
class Disponent_lib {
    
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('fin/disponent_m');
    }
    
    public function insert($data){
        $insert_data = array(
            'name' => $data['nazov'],
            'organizacia' => $data['organizacia'],
            'popis' => $data['popis'],
        );
        
        if($data['disponent_id'] == 0){//insert new ucet
            return $this->CI->disponent_m->insert($insert_data);
        }else{//update ucet
            return $this->CI->disponent_m->update($insert_data);
        }
    }
}
