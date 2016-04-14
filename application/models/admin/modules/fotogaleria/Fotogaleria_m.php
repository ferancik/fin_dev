<?php

class Fotogaleria_m extends CI_Model {

    public function vlozitGaleriu(FotogaleriaData $data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_mod_fotogaleria_data', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function pridajObrazkyKuGaleri(FotogaleriaData $data) {


        return $data;
    }

    public function odstranitGaleriu(FotogaleriaData $data) {

        // odstranim vsetky obrazky
        $obr = new ObrazokData();
        $obr->id_admin_mod_fotogaleria_data = $data->id;
        $this->odstranitObrazokID($obr,true);

        $this->db->where('id', $data->id);
        $this->db->delete('admin_mod_fotogaleria_data');
        return $this->db->affected_rows() > 0;
    }

    public function pridatObrazok(ObrazokData $data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_mod_fotogaleria_obrazky', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function nacitajGalerie() {
        $query = $this->db->select('*')
                ->from('admin_mod_fotogaleria_data')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result('FotogaleriaData');
        }

        return FALSE;
    }

    public function nacitajGaleriuID($idGalerie) {
        $query = $this->db->select('*')
                ->from('admin_mod_fotogaleria_data')
                ->where('id', $idGalerie)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result('FotogaleriaData');
        }

        return FALSE;
    }

    public function nacitajObrazokIDGalerie($idGalerie) {
        $query = $this->db->select('*')
                ->from('admin_mod_fotogaleria_obrazky')
                ->where('id_admin_mod_fotogaleria_data', $idGalerie)
                ->order_by('poradie', 'ASC')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return FALSE;
    }

    public function upravObrazokNazovPopis(ObrazokData $obrazok) {
        $this->db->where('id', $obrazok->id);
        $this->db->update('admin_mod_fotogaleria_obrazky', array('nazov' => $obrazok->nazov, 'popis' => $obrazok->popis));
        return $this->db->affected_rows() > 0;
    }

    public function nacitajObrazokID($idObrazka) {
        $query = $this->db->select('*')
                ->from('admin_mod_fotogaleria_obrazky')
                ->where('id', $idObrazka)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return FALSE;
    }

    public function odstranitObrazokID(ObrazokData $data, $odstranitVsekePodlaGalerie = false) {
        $nastavenia = $this->nacitajNastavenia();
        // nacitam fotku ktrou chcem zmazat
        $this->db->select('*')
                ->from('admin_mod_fotogaleria_obrazky');
        if (!$odstranitVsekePodlaGalerie) {
            $this->db->where('id', $data->id);
        } else {
            $this->db->where('id_admin_mod_fotogaleria_data', $data->id_admin_mod_fotogaleria_data);
        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {

                $rozlisenia = $this->nacitajRozlisenia();
                if (isset($rozlisenia)) {
                    foreach ($rozlisenia as $rozlisenie) {
                        if (file_exists($nastavenia->cesta_k_obrazkom_tumbs . DIRECTORY_SEPARATOR . vytvorNazovFotkyRozlisenie($rozlisenie->sirka, $rozlisenie->vyska, $row['adresa']))) {
                            unlink($nastavenia->cesta_k_obrazkom_tumbs . DIRECTORY_SEPARATOR . vytvorNazovFotkyRozlisenie($rozlisenie->sirka, $rozlisenie->vyska, $row['adresa']));
                        }
                    }
                }
                if (file_exists($nastavenia->cesta_k_obrazkom . DIRECTORY_SEPARATOR . $row['adresa'])) {
                    unlink($nastavenia->cesta_k_obrazkom . DIRECTORY_SEPARATOR . $row['adresa']);
                }
                if (file_exists($nastavenia->cesta_k_obrazkom_tumbs . DIRECTORY_SEPARATOR . $row['adresa'])) {
                    unlink($nastavenia->cesta_k_obrazkom_tumbs . DIRECTORY_SEPARATOR . $row['adresa']);
                }
            }
        }
        $this->db->where('id', $data->id);
        $this->db->delete('admin_mod_fotogaleria_obrazky');
        return $this->db->affected_rows() > 0;
    }

    public function nacitajRozlisenia() {
        $query = $this->db->select('*')
                ->from('admin_mod_fotogaleria_rozlisenia')
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

      public function delRozlisenie($id) {
        $this->db->where('id', $id);
        $this->db->delete('admin_mod_fotogaleria_rozlisenia');
        return $this->db->affected_rows() > 0;
    }
    
     public function editRozlisenie($data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_mod_fotogaleria_rozlisenia', $data);
        return $this->db->affected_rows() > 0;
    }

    public function insertRozlisenie($data) {
        $data->id = "null";
        $temp = $this->db->insert('admin_mod_fotogaleria_rozlisenia', $data);
        if ($temp) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    
    public function nacitajRozlisenie($nazov) {
        $query = $this->db->select('*')
                ->from('admin_mod_fotogaleria_rozlisenia')
                ->where('nazov', $nazov)
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp[0];
        }
        return false;
    }

      public function nacitajRozlisenieID($id) {
        $query = $this->db->select('*')
                ->from('admin_mod_fotogaleria_rozlisenia')
                ->where('id', $id)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    
    public function nacitajNastavenia() {
        $query = $this->db->select('*')
                ->from('admin_mod_fotogaleria_nastavenia')
                ->where('id', "1")
                ->get();
        if ($query->num_rows() > 0) {
            $temp = $query->result();
            return $temp[0];
        }
        return false;
    }

    public function odstranitObrazokIDGalerie(FotogaleriaData $data) {
        
        
        $this->db->where('id_admin_mod_fotogaleria_data', $data->id);
        $this->db->delete('admin_mod_fotogaleria_obrazky');
        return $this->db->affected_rows() > 0;
    }

    public function upravitObrazok(ObrazokData $data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_mod_fotogaleria_obrazky', $data);
        return $this->db->affected_rows() > 0;
    }

    public function upravitObrazokPoradie(ObrazokData $data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_mod_fotogaleria_obrazky', array('poradie' => $data->poradie));
        return $this->db->affected_rows() > 0;
    }

    public function upravitGaleriu(FotogaleriaData $data) {
        $this->db->where('id', $data->id);
        $this->db->update('admin_mod_fotogaleria_data', $data);
        return $this->db->affected_rows() > 0;
    }

}

?>
