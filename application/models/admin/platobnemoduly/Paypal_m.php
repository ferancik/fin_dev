<?php

class Paypal_m extends CI_Model {

    public function vlozitNastavenia($data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_platobnemoduly_paypal', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function upravitNastavenia($data) {
        $this->db->where('id', '1');
        $this->db->update('admin_platobnemoduly_paypal', $data);
        return $this->db->affected_rows() > 0;
    }

    public function getPlatbaIdentifikator($identifikator) {
        $query = $this->db->select('*')
                ->from('admin_platobnemoduly_paypal_pevne_platby')
                ->where('identifikator', $identifikator)
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->row();
            return $temp;
        }

        return FALSE;
    }

    public function getPevnePlatby() {
        $query = $this->db->select('*')
                ->from('admin_platobnemoduly_paypal_pevne_platby')
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp;
        }

        return FALSE;
    }

    public function insertPevnaPlatba($data) {
           $data->id = "null";
        $temp = $this->db->insert('admin_platobnemoduly_paypal_pevne_platby', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
      public function getLogy() {
        $query = $this->db->select('*')
                ->from('admin_platobnemoduly_paypal_log')
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp;
        }

        return FALSE;
    }

    public function editPevnaPlatba($data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_platobnemoduly_paypal_pevne_platby', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delPevnaPlatba($id) {
        $this->db->where('id', $id);
        $this->db->delete('admin_platobnemoduly_paypal_pevne_platby');
        return $this->db->affected_rows() > 0;
    }

    public function getOnePevnaPlatba($idPlatby) {
        $query = $this->db->select('*')
                ->from('admin_platobnemoduly_paypal_pevne_platby')
                ->where('id', $idPlatby)
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->row();
            return $temp;
        }

        return FALSE;
    }

    public function getNastavenia() {
        $query = $this->db->select('*')
                ->from('admin_platobnemoduly_paypal')
                ->where('id', '1')
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp[0];
        }

        return FALSE;
    }

}
