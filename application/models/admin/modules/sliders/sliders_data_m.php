<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sliders_data_m
 *
 * @author frantisekferancik
 */
class Sliders_data_m extends CI_Model{
    
    
    public function insertNew($data){
        if($this->db->insert('admin_mod_sliders_data', $data)){
            return TRUE;
        }
        return FALSE;
    }
    
    public function updateFoto($id_foto, $data){
        $this->db->where('id', $id_foto);
        if($this->db->update('admin_mod_sliders_data', $data)){
            return TRUE;
        }
        return FALSE;
    }
    
    public function getFotoSlider($id_slider){
        $query = $this->db->select("*")
                          ->from("admin_mod_sliders_data")
                          ->where('id_mod_sliders', $id_slider)
                          ->order_by('poradie', 'ASC')
                          ->get();
        if($query->num_rows()>0){
            return $query->result_array();
        }
        return FALSE;
    }
    
    public function getFotoData($id_foto){
        $query = $this->db->select("*")
                          ->from('admin_mod_sliders_data')
                          ->where('id', $id_foto)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            return $query->row_array();
        }
        
        return FALSE;
    }
    
    public function odstranFoto($id){
        if($this->db->delete('admin_mod_sliders_data', array('id' => $id))){
            echo "true";
            return TRUE;
        }
        echo 'false';
        return FALSE;
    }
}

?>
