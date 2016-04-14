<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Projects_lib
 *
 * @author frantisekferancik
 */
class Projects_lib{
    
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model("fin/projekty_m");
    }
    
    
    public function insert($data){
        $date_from = NULL;
        if($data['date_from'] != ''){
            $date_from = date("Y-m-d", strtotime(str_replace("/", "-", $data['date_from'])));
        }
        $date_to = NULL;
        if($data['date_to'] != ''){
            $date_to = date("Y-m-d", strtotime(str_replace("/", "-",$data['date_to'])));
        }
        $insert_data = array(
            'parent_id' => $data['parent'],
            'nazov' => $data['nazov'],
            'cislo' => $data['cislo'],
            'popis' => $data['popis'],
            'date_from' => date("Y-m-d", strtotime(str_replace("/", "-", $data['date_from']))),
            'date_to' => date("Y-m-d", strtotime(str_replace("/", "-",$data['date_to']))),
        );
        
        if($data['project_id'] == 0){//insert new ucet
            return $this->CI->projekty_m->insert($data['firma_id'], $insert_data);
        }else{//update ucet
            return $this->CI->projekty_m->update($data['firma_id'], $insert_data);
        }
    }
    
    
    
}
