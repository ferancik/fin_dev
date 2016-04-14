<?php

class Opravneniaskupiny_m extends CI_Model {

    public function getOpravnenia() {
        $query = $this->db->select('*')
                ->from('admin_permission')
                 ->order_by('id', 'ASC')
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp;
        }

        return FALSE;
    }

    public function getOneOpravnenie($id) {
        $query = $this->db->select('*')
                ->from('admin_permission')
                ->where('id', $id)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp[0];
        }

        return FALSE;
    }

    public function editOpravnenie($data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_permission', $data);
        return $this->db->affected_rows() > 0;
    }
    
     public function insertOpravnenie($data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_permission', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
     public function insertOpravnenieMenu($data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_permission_menu', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
     public function delOpravnenieMenu($id) {
        $this->db->where('admin_permission', $id);
        $this->db->delete('admin_permission_menu');
        return $this->db->affected_rows() > 0;
    }
    
     public function getOpravneniaMenu($id) {
        $query = $this->db->select('*')
                ->from('admin_permission_menu')
                ->where('admin_permission', $id)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp;
        }

        return FALSE;
    }
    
    
    public function delOpravnenie($id) {
        $this->db->where('id', $id);
        $this->db->delete('admin_permission');
        return $this->db->affected_rows() > 0;
    }

}

?>
