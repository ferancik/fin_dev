<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Projekty_m
 *
 * @author frantisekferancik
 */
class Projekty_m extends CI_Model {

    public function getProjekt($projekt_id) {
        $query = $this->db->select()
                ->from(DB_PREFIX . 'projekty')
                ->where('projekt_id', $projekt_id)
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function insert($firma_id, $data) {
        if ($this->db->insert(DB_PREFIX . 'projekty', $data)) {
            $projekt_id = $this->db->insert_id();
            //vlozit prepojenie s firmou
            if ($this->db->insert(DB_PREFIX . 'firma_projekt', array('firma_id' => $firma_id, 'projekt_id' => $projekt_id))) {
                return $projekt_id;
                
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function update($id, $data){
        $this->db->where("projekt_id", $id );
        if($this->db->update(DB_PREFIX . 'projekty', $data)){
            return TRUE;
        }
        return FALSE;
    }
    
    

    function getTree($rootid, $firma_id) {
        $arr = array();
        $result = $this->db->select(DB_PREFIX . 'projekty.*')
                ->from(DB_PREFIX . 'projekty')
                ->join(DB_PREFIX . 'firma_projekt', DB_PREFIX . 'firma_projekt.projekt_id = ' . DB_PREFIX . 'projekty.projekt_id', 'inner')
                ->where(DB_PREFIX . 'projekty.parent_id', $rootid)
                ->where(DB_PREFIX . 'firma_projekt.firma_id', $firma_id)
                ->get();

        foreach ($result->result_array() as $key => $row) {

            $arr[] = array(
                "name" => $row['nazov'],
                'projekt_id' => $row['projekt_id'],
                'cislo' => $row['cislo'],
                "children" => $this->getTree($row["projekt_id"], $firma_id)
            );
        }

        return $arr;
    }

}
