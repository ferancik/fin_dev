<?php 
class Admin_web_menu_langs_m extends CI_Model {
    
    
     public function getStrankyLanguage($idStranka, $idJazyk) {
        $query = $this->db->select('*')
                ->from('admin_mod_pages_langs')
                ->where('id_admin_web_language', $idJazyk)
                ->where('id_admin_mod_pages', $idStranka)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->row();
            return $temp;
        }
        return false;
    }
    
      public function editStrankyLanguage($idStranka, $idJazyk, $obsah, $seo_popis,$seo_tagy) {
          if ($obsah==NULL){
              $obsah = '';
          }
        if ($this->getStrankyLanguage($idStranka, $idJazyk)) { // ak je tak uprav
            $this->db->where('id_admin_mod_pages', $idStranka);
            $this->db->where('id_admin_web_language', $idJazyk);
            $this->db->update('admin_mod_pages_langs', array('obsah' => $obsah,'seo_popis'=>(($seo_popis == null)? '' : $seo_popis),'seo_tagy'=>(($seo_tagy == null)? '' : $seo_tagy)));
        } else { // inak vloz
            $this->db->insert('admin_mod_pages_langs', array('id_admin_web_language' => $idJazyk, 'id_admin_mod_pages' => $idStranka, 'obsah' => $obsah,'seo_popis'=>(($seo_popis == null)? '' : $seo_popis),'seo_tagy'=>(($seo_tagy == null)? '' : $seo_tagy)));
        }
    }
}


?>
