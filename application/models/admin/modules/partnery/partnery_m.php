<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of partnery_m
 *
 * @author frantisekferancik
 */
class Partnery_m extends CI_Model {

    public function getAllPartners() {
        $query = $this->db->select('*')
                ->from('admin_mod_partnery')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function getPartner($id) {
        $query = $this->db->select("*")
                ->from('admin_mod_partnery')
                ->where('id', $id)
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return FALSE;
    }
    
    public function insertNew($data){
        if($this->db->insert('admin_mod_partnery', $data)){
            return TRUE;
        }
        
        return FALSE;
    }
    
    public function update($id_partner, $data){
        $this->db->where('id', $id_partner);
        if($this->db->update('admin_mod_partnery', $data)){
            return TRUE;
        }
        return FALSE;
    }
    
    public function getLogo($id){
        $query = $this->db->select("logo")
                          ->from('admin_mod_partnery')
                          ->where('id', $id)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            $temp = $query->row_array();
            return $temp['logo'];
        }
        
        return FALSE;
    }
    
    public function deletPartner($id){
        if($this->db->delete('admin_mod_partnery', array('id' => $id))){
            return TRUE;
        }
        return FALSE;
    }
    
    

}

?>
