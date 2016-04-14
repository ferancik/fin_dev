<?php 
class Transactions_m extends CI_Model {
    
     public function getAllTransactions() {
        $query = $this->db->select('*')
                ->from('admin_platobnemoduly_transactions')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return FALSE;
    }
    
      public function insertTransactions($data) {
        $temp = $this->db->insert('admin_platobnemoduly_transactions', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
     public function delTransactions($id) {
        $this->db->where('id', $id);
        $this->db->delete('admin_platobnemoduly_transactions');
        return $this->db->affected_rows() > 0;
    }

    
}
