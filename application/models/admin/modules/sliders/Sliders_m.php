<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sliders_m
 *
 * @author frantisekferancik
 */
class Sliders_m extends CI_Model{
    
    public function insertNewSlider($data){
        if($this->db->insert('admin_mod_sliders', $data)){
            return $this->db->insert_id();
        }
        return FALSE;
    }
    
    public function updateSlider($id_slider, $data){
        $this->db->where('id', $id_slider);
        if($this->db->update('admin_mod_sliders', $data)){
            return TRUE;
        }
        return FALSE;
    }
    
    public function getAllSliders(){
        $query = $this->db->select('*')
                          ->from('admin_mod_sliders')
                          ->get();
        if($query->num_rows()>0){
            return $query->result_array();
        }
        
        return FALSE;
    }
    
    public function getSliderData($id_slider){
        $query = $this->db->select('*')
                          ->from('admin_mod_sliders')
                          ->where('id', $id_slider)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            return $query->row_array();
        }
        return FALSE;
    }
    
    public function getSliderDataName($name){
        //admin_mod_sliders_data.name, admin_mod_sliders_data.image, admin_mod_sliders_data.popis, admin_mod_sliders_data.poradie
        $query = $this->db->select('*')
                          ->from('admin_mod_sliders')
                          ->where('admin_mod_sliders.umiestnenie', $name)
                          ->join('admin_mod_sliders_data', 'admin_mod_sliders_data.id_mod_sliders =  admin_mod_sliders.id', 'inner')
                          ->order_by('admin_mod_sliders_data.poradie', 'ASC')
                          ->get();
        
        if($query->num_rows()>0){
            return $query->result_array();
        }
        
        return FALSE;
    }
    
}

?>
