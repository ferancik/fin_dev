<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_language
 *
 * @author frantisekferancik
 */
class admin_language_m extends CI_Model{
    private $table = 'admin_language';
    public function getActiveLanguage(){
        $query = $this->db->select('*')
                          ->from($this->table)
                          ->where('active',1)
                ->order_by('poradie', 'DESC')
                          ->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return FALSE;
    }
    
    public function getAllLanguage(){
        $query = $this->db->select('*')
                          ->from($this->table)
                          ->order_by('active', 'DESC')
                          ->get();
        if($query->num_rows()>0){
            return $query->result();
        }
        return FALSE;
    }
    
    public function getOneLanguage($id){
        $query = $this->db->select('*')
                          ->from($this->table)
                          ->where('id', $id)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return FALSE;
    }
    
     public function getOneLanguageDir($dir){
        $query = $this->db->select('*')
                          ->from($this->table)
                          ->where('dir', $dir)
                          ->limit(1)
                          ->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return FALSE;
    }
    
    public function updateLanguage($id,$data){
        $this->db->where('id',$id);
        if($this->db->update($this->table, $data)){
            return TRUE;
        }
        return FALSE;
    }
    
    
    
}

?>
