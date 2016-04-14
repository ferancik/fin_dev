<?php

class Stranky_m extends CI_Model {

    private $language;
    private $id_lang;

    public function __construct() {
        parent::__construct();
        global $CFG;
        $this->language = str_replace("web/", "", $CFG->item('language'));

        $this->id_lang = $this->getIdLanguage();



        //echo $this->id_lang;
    }

    public function vlozitStranku($data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_mod_pages', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function upravitStranku(StrankyData $data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_mod_pages', $data);
        return $this->db->affected_rows() > 0;
    }

    public function odstranitStranku(StrankyData $data) {
        $this->db->where('id', $data->id);
        $this->db->delete('admin_mod_pages');


        $this->db->where('id_admin_mod_pages', $data->id);
        $this->db->delete('admin_mod_pages_langs');


        return $this->db->affected_rows() > 0;
    }

    public function nacitajStranky() {
        $query = $this->db->select('*')
                ->from('admin_mod_pages')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result('StrankyData');
        }

        return FALSE;
    }

    public function nacitajStrankuID($idStranka) {
        $query = $this->db->select('*')
                ->from('admin_mod_pages')
                ->where('id', $idStranka)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result('StrankyData');
        }

        return FALSE;
    }

    public function nacitajStrankuSeoURL($seo_url) {
        $query = $this->db->select('*')
                ->from('admin_mod_pages')
                ->where('seo_url', $seo_url)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result('StrankyData');
        }

        return FALSE;
    }

    public function getStrankaKOD($kodPreZavolanie) {
        $query = $this->db->select('*')
                ->from('admin_mod_pages')
                ->where('kod_pre_zavolanie', $kodPreZavolanie)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result('StrankyData');
            return $temp[0];
        }

        return FALSE;
    }

      public function getStrankaKODPrelozene($kodPreZavolanie) {
       
        
         $query = $this->db->select('admin_mod_pages.id ,
            admin_mod_pages.id_parent ,
            admin_mod_pages.nazov ,
            admin_mod_pages.seo_url ,
            admin_mod_pages.kod_pre_zavolanie ,
            admin_mod_pages.modifikacia ,
            admin_mod_pages.pevna ,
            admin_mod_pages_langs.obsah as obsah ,
            admin_mod_pages_langs.seo_popis as seo_popis ,
            admin_mod_pages_langs.seo_tagy as seo_tagy')
                ->from('admin_mod_pages')
                ->join('admin_mod_pages_langs', 'admin_mod_pages_langs.id_admin_mod_pages = admin_mod_pages.id', 'inner')
                ->where('admin_mod_pages_langs.id_admin_web_language', $this->id_lang)
                ->where('admin_mod_pages.kod_pre_zavolanie', $kodPreZavolanie)
                ->get();
         
        if ($query->num_rows() > 0) {
            $temp = $query->result('StrankyData');
            return $temp[0];
        }

        return FALSE;
    }
    
    public function getStrankaURLPrelozene($urlnazov) {
        $urlnazov = url_title($urlnazov);
        $query = $this->db->select('admin_mod_pages.id ,
            admin_mod_pages.id_parent ,
            admin_mod_pages.nazov ,
            admin_mod_pages.seo_url ,
            admin_mod_pages.kod_pre_zavolanie ,
            admin_mod_pages.modifikacia ,
            admin_mod_pages.pevna ,
            admin_mod_pages_langs.obsah as obsah ,
            admin_mod_pages_langs.seo_popis as seo_popis ,
            admin_mod_pages_langs.seo_tagy as seo_tagy')
                ->from('admin_mod_pages')
                ->join('admin_mod_pages_langs', 'admin_mod_pages_langs.id_admin_mod_pages = admin_mod_pages.id', 'inner')
                ->where('admin_mod_pages_langs.id_admin_web_language', $this->id_lang)
                ->where('admin_mod_pages.seo_url', $urlnazov)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result('StrankyData');
            return $temp[0];
        }

        return FALSE;
    }

    public function getStrankaURL($urlnazov) {
        $urlnazov = url_title($urlnazov);
        $query = $this->db->select('*')
                ->from('admin_mod_pages')
                ->where('seo_url', $urlnazov)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result('StrankyData');
            return $temp[0];
        }

        return FALSE;
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

}

?>
