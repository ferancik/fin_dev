<?php

class Nastavenia_m extends CI_Model {

    public function vlozitNastavenia($data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_nastavenia', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function upravitNastavenia($data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_nastavenia', $data);
        return $this->db->affected_rows() > 0;
    }

    public function getNastavenia() {
        $query = $this->db->select('*')
                ->from('admin_nastavenia')
                ->where('id', '1')
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp[0];
        }

        return FALSE;
    }

}

?>
