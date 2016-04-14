<?php

class Admin_menu_m extends CI_Model {

    private $language;
    private $id_lang;
    private $akeUdajeVytiahnem = 'admin_menu.id,
                                    admin_menu.kontroler,
                                    admin_menu.id_parrent,
                                    admin_menu.icon,
                                    admin_menu.type,
                                    admin_menu.options,
                                    admin_menu.poradie,
                                     admin_menu.url,
                                     admin_menu.zobrazit,
                                    admin_menu_langs.nazov';

    public function __construct() {
        parent::__construct();
        global $CFG;
        $this->language = str_replace("admin/", "", $CFG->item('language'));
        $this->id_lang = $this->getIdLanguage();
       
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
    
    public function getRootMenu($all = false) {
        $this->db->select($this->akeUdajeVytiahnem);
       
        $this->db->from('admin_menu');
        //$this->db->where('admin_menu.id_parrent', '0');
        $this->db->join('admin_menu_langs', 'admin_menu_langs.id_admin_menu = admin_menu.id', 'inner');
        $this->db->where('admin_menu_langs.id_admin_language', $this->id_lang);
        if (!$all) {
            $this->db->where('admin_menu.zobrazit', '1');
        }

        $this->db->order_by('admin_menu.poradie', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $temp = $query->result('AdminMenuData');
//            for ($i = 0; $i < count($temp); $i++) {
//                $temp[$i]->parrents = $this->getParrent($temp[$i]->id, $all);
//                if (count($temp[$i]->parrents) > 0) {
//
//                    foreach ($temp[$i]->parrents as $value) {
//
//                        $value->parrents = $this->getParrent($value->id, $all);
//
//                        //edit 20.5
//                        if (count($value->parrents) > 0) {
//                            foreach ($value->parrents as $value2) {
//                                $value2->parrents = $this->getParrent($value2->id, $all);
//                            }
//                        }
//                    }
//                }
//            }
            
            $temp = $this->buildTreeMenu($temp,0);
            return $temp;
        }

        return FALSE;
    }

    public function getOneMenuKontrolerLike($kontroler) {
        
        $query = $this->db->select($this->akeUdajeVytiahnem)
                ->from('admin_menu')
                ->like('admin_menu.kontroler', $kontroler)
                ->join('admin_menu_langs', 'admin_menu_langs.id_admin_menu = admin_menu.id', 'inner')
                ->where('admin_menu_langs.id_admin_language', $this->id_lang)
                ->order_by('admin_menu.poradie', 'ASC')
                ->limit(1)
                ->get();

        if ($query->num_rows() > 0) {
            $temp = $query->result('AdminMenuData');
            return $temp[0];
        }

        return array();
    }

    public function getOneMenuURLLike($url) {
        $query = $this->db->select($this->akeUdajeVytiahnem)
                ->from('admin_menu')
                ->like('admin_menu.url', $url)
                ->join('admin_menu_langs', 'admin_menu_langs.id_admin_menu = admin_menu.id', 'inner')
                ->where('admin_menu_langs.id_admin_language', $this->id_lang)
                ->order_by('admin_menu.poradie', 'ASC')
                ->limit(1)
                ->get();

        if ($query->num_rows() > 0) {
            $temp = $query->result('AdminMenuData');
            return $temp[0];
        }

        return array();
    }

    private function _zistiParrent($idParrent) {
        $query = $this->db->select('url,id_parrent,kontroler')
                ->from('admin_menu')
                ->where('id', $idParrent)
                ->limit(1)
                ->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return False;
    }

    public function vytvorCestu($kontroler) {
        if ($kontroler != '#') {
            $cesta = '';
            $this->db->select('url,id_parrent,kontroler')
                    ->from('admin_menu');
            $this->db->where('kontroler', $kontroler);
            $this->db->limit(1);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                $menu = $query->row();
                if ($menu->id_parrent != 0) {
                    $parrent = true;
                    $cesta = $menu->url;
                    $parrentId = $menu->id_parrent;
                    do {
                        $mamParent = $this->_zistiParrent($parrentId);
                        if ($mamParent === false) {
                            $parrent = false;
                        } else {
                            $parrentId = $mamParent->id_parrent;
                            $cesta = $mamParent->url . '/' . $cesta;
                        }
                    } while ($parrent);
                } else if ($menu->id_parrent == 0) {
                    return $menu->url;
                }
            }

            return $cesta;
        } else {
            return '#';
        }
    }

    public function getOneMenuKontroler($kontroler) {
        $query = $this->db->select($this->akeUdajeVytiahnem)
                ->from('admin_menu')
                ->where('admin_menu.kontroler', $kontroler)
                ->join('admin_menu_langs', 'admin_menu_langs.id_admin_menu = admin_menu.id', 'inner')
                ->where('admin_menu_langs.id_admin_language', $this->id_lang)
                ->order_by('admin_menu.poradie', 'ASC')
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result('AdminMenuData');
            return $temp[0];
        }

        return array();
    }

    public function getParrent($id_parrent, $all = false) {

        
        $this->db->select($this->akeUdajeVytiahnem);
        $this->db->from('admin_menu');
        $this->db->where('id_parrent', $id_parrent);
        $this->db->join('admin_menu_langs', 'admin_menu_langs.id_admin_menu = admin_menu.id', 'inner');
        $this->db->where('admin_menu_langs.id_admin_language', $this->id_lang);
        if (!$all) {
            $this->db->where('admin_menu.zobrazit', '1');
        }
        $this->db->order_by('admin_menu.kontroler', 'ASC');
        $this->db->order_by('admin_menu.poradie', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $temp = $query->result('AdminMenuData');
            return $temp;
        }

        return array();
    }

    public function getMenuLanguage($idMenu, $idJazyk) {
        $query = $this->db->select('')
                ->from('admin_menu_langs')
                ->where('id_admin_language', $idJazyk)
                ->where('id_admin_menu', $idMenu)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->row();
            return $temp;
        }
        return false;
    }

    
    
    
    private function LanguageQuery() {

        
        $query = $this->db->select('')
                ->from('admin_language')
                ->where('dir', $this->language)
                ->limit(1)
                ->get();
        return $query;
    }

    private function getIdLanguage() {
        $query = $this->LanguageQuery();

        if ($query->num_rows() > 0) {
            $temp = $query->row();
            return $temp->id;
        } else {
            $query = $this->db->select('id')
                    ->from('admin_language')
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
        $this->db->update('admin_menu', array('id_parrent' => $idParrent));
        return $this->db->affected_rows() > 0;
    }

    public function editMenuLanguage($idMenu, $idJazyk, $text) {
        if ($this->getMenuLanguage($idMenu, $idJazyk)) { // ak je tak uprav
            $this->db->where('id_admin_menu', $idMenu);
            $this->db->where('id_admin_language', $idJazyk);
            $this->db->update('admin_menu_langs', array('nazov' => $text));
        } else { // inak vloz
            $this->db->insert('admin_menu_langs', array('id_admin_language' => $idJazyk, 'id_admin_menu' => $idMenu, 'nazov' => $text));
        }
    }

    public function delMenu($id) {

        $this->db->where('id', $id);
        $this->db->delete('admin_menu');

        $this->db->where('id_admin_menu', $id);
        $this->db->delete('admin_menu_langs');

        return $this->db->affected_rows() > 0;
    }

    public function editMenu($data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_menu', $data);
        return $this->db->affected_rows() > 0;
    }

    public function insertMenu($data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_menu', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function getOneMenu($idMenu) {

        $query = $this->db->select('*')
                ->from('admin_menu')
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
