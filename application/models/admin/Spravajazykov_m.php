<?php 

class Spravajazykov_m extends CI_Model {
     public function getJazyky() {
        $query = $this->db->select('*')
                ->from('admin_pages_language')
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp;
        }

        return FALSE;
    }
     public function getOneJazyk($id) {

        $query = $this->db->select('*')
               ->from('admin_pages_language')
              
                ->where('id', $id)
                ->get();

        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp[0];
        }

        return FALSE;
    }
    
     public function delJazyk($id) {
        $this->db->where('id', $id);
        $this->db->delete('admin_pages_language');
        return $this->db->affected_rows() > 0;
    }
    
     public function editJazyk($data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_pages_language', $data);
        return $this->db->affected_rows() > 0;
    }

    public function insertJazyk($data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_pages_language', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

}

?>
