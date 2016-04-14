<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dokumenty_m
 *
 * @author frantisekferancik
 */
class Dokumenty_m extends CI_Model{
    
    
    public function getDokumenty(){
        $query = $this->db->select("*")
                          ->from('admin_mod_dokumenty')
                          ->order_by('poradie', 'ASC')
                          ->get();
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return FALSE;
    }
    
    public function getDokument($id){
        $query = $this->db->select("*")
                          ->from("admin_mod_dokumenty")
                          ->where('id', $id)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            return $query->row_array();
        }
        return FALSE;
    }
    
    public function insertDokument($data){
        if($this->db->insert('admin_mod_dokumenty', $data)){
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateDokument($id, $data){
        $this->db->where('id',$id);
        if($this->db->update('admin_mod_dokumenty', $data)){
            return TRUE;
        }
        return FALSE;
    }
    
    public function odstranDokument($id){
        if($this->db->delete('admin_mod_dokumenty', array('id' => $id))){
            return TRUE;
        }
        return FALSE;
    }
}

?>
