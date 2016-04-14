<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Disponent_m
 *
 * @author frantisekferancik
 */
class Disponent_m extends CI_Model{
    
    
    private $table = "";
    
    public function __construct() {
        parent::__construct();
        $this->table = DB_PREFIX.'disponent';
    }
    
    public function insert($data) {
        if ($this->db->insert($this->table, $data)) {
            $return_id = $this->db->insert_id();
            //vlozit prepojenie s firmou
            if ($return_id) {
                return $return_id;
                
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function update($id, $data){
        $this->db->where("disponent_id", $id );
        if($this->db->update($this->table, $data)){
            return TRUE;
        }
        return FALSE;
    }
    
}
