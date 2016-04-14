<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of navbloky_m
 *
 * @author frantisekferancik
 */
class Navbloky_m extends CI_Model{
    
    /**
     * vrati jeden navigacny blok podla id
     * @param type $id
     * @return boolean
     */
    public function getNavBlok($id){
        $query = $this->db->select("*")
                          ->from("admin_mod_navbloky")
                          ->where('id',$id)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            return $query->row_array();
        }
        return FALSE;
    }
    
    /**
     * vrati vsetky navigacne bloky s databazy
     * @return boolean
     */
    public function getNavBloky(){
        $query = $this->db->select("*")
                          ->from('admin_mod_navbloky')
                          ->order_by('poradie',"ASC")
                          ->get();
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return FALSE;
    }
    
    public function insertNew($data){
        if($this->db->insert('admin_mod_navbloky', $data)){
            return TRUE;
        }
        return FALSE;
    }
    
    
    public function updateNavBlok($id, $data){
        $this->db->where('id', $id);
        if($this->db->update('admin_mod_navbloky', $data)){
            return TRUE;
        }
        return FALSE;
    }
    
    
    public function odstranNavBlok($id){
        if($this->db->delete('admin_mod_navbloky', array('id' => $id))){
            return TRUE;
        }
        return FALSE;
    }
    
}

?>
