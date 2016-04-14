<?php 

class Adminwebmenuall_m extends CI_Model {
     public function getAllMenu() {
        $query = $this->db->select('*')
                ->from('admin_web_menu_all')
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp;
        }

        return FALSE;
    }
     public function getOneTypMEnu($id) {

        $query = $this->db->select('*')
               ->from('admin_web_menu_all')
              
                ->where('id', $id)
                ->get();

        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp[0];
        }

        return FALSE;
    }
    
     public function delMenu($id) {
        $this->db->where('id', $id);
        $this->db->delete('admin_web_menu_all');
        return $this->db->affected_rows() > 0;
    }
    
     public function ediMenu($data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_web_menu_all', $data);
        return $this->db->affected_rows() > 0;
    }

    public function insertMenu($data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_web_menu_all', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

}
?>
