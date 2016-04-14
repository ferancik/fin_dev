<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Firma_m
 *
 * @author frantisekferancik
 */
class Firma_m extends CI_Model{
    
    
    public function getFirmy(){
        $query = $this->db->select("*")
                          ->from(DB_PREFIX.'firma')
                          ->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return FALSE;
    }
    
    
    public function getFirmaAsId($firma_id){
        $query = $this->db->select()
                          ->from(DB_PREFIX.'firma')
                          ->where('firma_id', $firma_id)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return FALSE;
    }


    public function getFirmaUcty($firma_id){
        $query = $this->db->select(DB_PREFIX."ucty.*")
                          ->from(DB_PREFIX.'ucty')
                          ->join(DB_PREFIX."firma_ucty", DB_PREFIX."firma_ucty.ucet_id = ". DB_PREFIX."ucty.ucet_id", 'inner')
                          ->where(DB_PREFIX.'firma_ucty.firma_id', $firma_id)
                          ->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return FALSE;
    }
    
    public function getFirmaProjekty($firma_id){
        $query = $this->db->select()
                          ->from(DB_PREFIX."projekty")
                          ->join(DB_PREFIX."firma_projekt", DB_PREFIX."firma_projekt.firma_id = ".DB_PREFIX.'projekty.projekt_id', 'inner')
                          ->where(DB_PREFIX.'firma_projekt.firma_id', $firma_id)
                          ->order_by(DB_PREFIX.'projekty.nazov', 'asc')
                          ->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return FALSE;
    }
    
    
    public function getUcely(){
        $query = $this->db->select("")
                          ->from(DB_PREFIX.'ucel')
                          ->order_by('nazov', 'asc')
                          ->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return FALSE;
    }
    
    
    public function getDisponets(){
        $query = $this->db->select("*")
                          ->from(DB_PREFIX.'disponent')
                          ->order_by('name', 'asc')
                          ->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return FALSE;
    }
    
    
}
