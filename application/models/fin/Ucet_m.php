<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ucet_m
 *
 * @author frantisekferancik
 */
class Ucet_m extends CI_Model {

    private $table = "";

    public function __construct() {
        parent::__construct();
        $this->table = DB_PREFIX . 'ucty';
    }

    public function insert($firma_id, $data) {
        if($this->db->insert($this->table, $data)){
            $ucet_id = $this->db->insert_id();
            //vlozit prepojenie s firmou
            if($this->db->insert(DB_PREFIX.'firma_ucty', array('firma_id'=>$firma_id, 'ucet_id'=>$ucet_id))){
                return $ucet_id;
            }  else {
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }
    
    public function update($ucet_id, $data){
        $this->db->where("ucet_id", $ucet_id);
        if($this->db->update($this->table, $data)){
            return TRUE;
        }
        return FALSE;
    }

}
