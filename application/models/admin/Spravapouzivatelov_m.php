<?php

class Spravapouzivatelov_m extends CI_Model {

    public function getUzivatelia() {
        $query = $this->db->select('admin_users.* , admin_permission.nazov as admin_permission_nazov, admin_permission.id as admin_permission_id
                 ')
                ->from('admin_users')
                ->join('admin_permission', 'admin_users.admin_permission = admin_permission.id', 'inner')
                ->order_by('admin_users.username', 'ASC')
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp;
        }

        return FALSE;
    }

    public function getOneUser($id) {

        $query = $this->db->select('admin_users.* , admin_permission.nazov as admin_permission_nazov, admin_permission.id as admin_permission_id
                 ')
                ->from('admin_users')
                ->join('admin_permission', 'admin_users.admin_permission = admin_permission.id', 'inner')
                ->where('admin_users.id', $id)
                ->get();

        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp[0];
        }

        return FALSE;
    }

    public function editUser($data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_users', $data);
        return $this->db->affected_rows() > 0;
    }

    public function insertUser($data) {
        $data->id = "null";
        $data->created = date('Y-m-d H:m:s',time());
        $temp = $this->db->insert('admin_users', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function delUser($id) {
        $this->db->where('id', $id);
        $this->db->delete('admin_users');
        return $this->db->affected_rows() > 0;
    }

}

?>
