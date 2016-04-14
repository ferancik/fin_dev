<?php

class Admin_web_menu_m extends CI_Model {

    private $language;
    private $id_lang;
    private $akeUdajeVytiahnem = 'admin_web_menu.id,
                                    admin_web_menu.kontroler,
                                    admin_web_menu.id_parrent,
                                    admin_web_menu.icon,
                                    admin_web_menu.type,
                                    admin_web_menu.options,
                                    admin_web_menu.poradie,
                                    admin_web_menu.typ_menu,
                                    admin_web_menu_langs.nazov';
    
    public function __construct() {
        parent::__construct();
        global $CFG;


        $this->language = str_replace("web/", "", $CFG->item('language'));
        $this->language = str_replace("admin/", "", $this->language);
        //$this->language = $CFG->item('language');
        $this->id_lang = $this->getIdLanguage();
    }

    public function getRootMenuIdentifikator($identifikator) {
        $id = $this->getIdTypMenu($identifikator);
        return $this->getRootMenu($id->id);
    }

    private function buildTreeMenu($ar, $pid = null) {
        $op = array();
        foreach ($ar as $item) {
            if ($item->id_parrent == $pid) {
                $op[$item->id] = $item;

                // recursion
                $children = $this->buildTreeMenu($ar, $item->id);
                if ($children) {
                    $op[$item->id]->parrents = $children;
                }
            }
        }
        return $op;
    }

    public function getRootMenu($idTypMenu) {
        $query = $this->db->select($this->akeUdajeVytiahnem)
                ->from('admin_web_menu')
                //->where('admin_web_menu.id_parrent', '0')
                ->join('admin_web_menu_langs', 'admin_web_menu_langs.id_admin_menu = admin_web_menu.id', 'inner')
                ->where('admin_web_menu_langs.id_admin_language', $this->id_lang)
                ->where('admin_web_menu.typ_menu', $idTypMenu)
                ->order_by('admin_web_menu.poradie', 'ASC')
                ->get();

        if ($query->num_rows() > 0) {
            $temp = $query->result('AdminMenuData');

           $temp = $this->buildTreeMenu($temp,0);
//            for ($i = 0; $i < count($temp); $i++) {
//                $temp[$i]->parrents = $this->getParrent($temp[$i]->id, $idTypMenu);
//                if (count($temp[$i]->parrents) > 0) {
//                    foreach ($temp[$i]->parrents as $value) {
//                        $value->parrents = $this->getParrent($value->id, $idTypMenu);
//                        
//                         //edit 20.5
//                        if (count($value->parrents ) > 0){
//                            foreach ($value->parrents as $value2) {
//                                $value2->parrents = $this->getParrent($value2->id,$idTypMenu);
//                            }
//                        }
//                    }
//                }
//            }
            return $temp;
        }

        return FALSE;
    }

    public function getParrent($id_parrent, $idTypMenu) {

        $query = $this->db->select($this->akeUdajeVytiahnem)
                ->from('admin_web_menu')
                ->where('admin_web_menu.id_parrent', $id_parrent)
                ->join('admin_web_menu_langs', 'admin_web_menu_langs.id_admin_menu = admin_web_menu.id', 'inner')
                ->where('admin_web_menu_langs.id_admin_language', $this->id_lang)
                ->where('admin_web_menu.typ_menu', $idTypMenu)
                ->order_by('admin_web_menu.kontroler', 'ASC')
                ->order_by('admin_web_menu.poradie', 'ASC')
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result('AdminMenuData');
            return $temp;
        }

        return array();
    }

    private function getIdTypMenu($identifikator) {
        $query = $this->db->select('*')
                ->from('admin_web_menu_all')
                ->where('identifikator', $identifikator)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->row();
            return $temp;
        }
        return false;
    }

    public function getOneMenuKontroler($kontroler) {
        $query = $this->db->select($this->akeUdajeVytiahnem)
                ->from('admin_web_menu')
                ->where('admin_web_menu.kontroler', $kontroler)
                ->join('admin_web_menu_langs', 'admin_web_menu_langs.id_admin_menu = admin_web_menu.id', 'inner')
                ->where('admin_web_menu_langs.id_admin_language', $this->id_lang)
                ->order_by('admin_web_menu.poradie', 'ASC')
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result('AdminMenuData');
            return $temp[0];
        }

        return array();
    }

    public function getMenuLanguage($idMenu, $idJazyk) {
        $query = $this->db->select('')
                ->from('admin_web_menu_langs')
                ->where('id_admin_language', $idJazyk)
                ->where('id_admin_menu', $idMenu)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->row();
            return $temp;
        }
        return false;
    }

    public function getDefaultLanguage() {
        $query = $this->db->select('*')
                ->from('admin_web_language')
                ->where('default', '1')
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->row();
            return $temp;
        }
    }

    private function getIdLanguage() {
        $query = $this->db->select('id')
                ->from('admin_web_language')
                ->where('dir', $this->language)
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->row();
            return $temp->id;
        } else {
            $query = $this->db->select('id')
                    ->from('admin_web_language')
                    ->where('default', 1)
                    ->limit(1)
                    ->get();
            if ($query->num_rows() > 0) {
                $temp = $query->row();
                return $temp->id;
            }
        }
        return FALSE;
    }

    public function editMenuParrent($idParrent, $idMenu) {
        $this->db->where('id', $idMenu);
        $this->db->update('admin_web_menu', array('id_parrent' => $idParrent));
        return $this->db->affected_rows() > 0;
    }

    public function editMenuLanguage($idMenu, $idJazyk, $text) {
        if ($this->getMenuLanguage($idMenu, $idJazyk)) { // ak je tak uprav
            $this->db->where('id_admin_menu', $idMenu);
            $this->db->where('id_admin_language', $idJazyk);
            $this->db->update('admin_web_menu_langs', array('nazov' => $text));
        } else { // inak vloz
            $this->db->insert('admin_web_menu_langs', array('id_admin_language' => $idJazyk, 'id_admin_menu' => $idMenu, 'nazov' => $text));
        }
    }

    public function delMenu($id) {

        $this->db->where('id', $id);
        $this->db->delete('admin_web_menu');

        $this->db->where('id_admin_menu', $id);
        $this->db->delete('admin_web_menu_langs');

        return $this->db->affected_rows() > 0;
    }

    public function delMenuIDTypMenu($id) {
        //zmazem jazyky 

        $query = $this->db->select('*')
                ->from('admin_web_menu')
                ->where('typ_menu', $id)
                ->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $value) {
                $this->db->where('id_admin_menu', $value->id);
                $this->db->delete('admin_web_menu_langs');
            }
        }


        $this->db->where('typ_menu', $id);
        $this->db->delete('admin_web_menu');

        return $this->db->affected_rows() > 0;
    }

    public function editMenu($data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_web_menu', $data);
        return $this->db->affected_rows() > 0;
    }

    public function editMenuTypID($data, $idTypMenu) {
        $this->db->where('id', $data->id);
        $this->db->where('typ_menu', $idTypMenu);
        $this->db->update('admin_web_menu', $data);
        return $this->db->affected_rows() > 0;
    }

    public function insertMenu($data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_web_menu', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function getOneMenu($idMenu) {

        $query = $this->db->select('*')
                ->from('admin_web_menu')
                ->where('id', $idMenu)
                ->get();

        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp[0];
        }

        return FALSE;
    }

}

?>
