<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dokument {
    
    private $CI;
    private $id;
    private $nazov;
    private $dokument;
    private $popis;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('admin/modules/dokumenty/dokumenty_m', '', TRUE);
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNazov() {
        return $this->nazov;
    }

    public function getDokument() {
        return $this->dokument;
    }

    public function getPopis() {
        return $this->popis;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNazov($nazov) {
        $this->nazov = $nazov;
    }

    public function setDokument($dokument) {
        $this->dokument = $dokument;
    }

    public function setPopis($popis) {
        $this->popis = $popis;
    }

    public function getDokumenty(){
        return $this->CI->dokumenty_m->getDokumenty();
    }
    
    public function getOneDokument($id){
        return $this->CI->dokumenty_m->getDokument($id);
    }
    
    public function ulozit(){
        if($this->id == "novy"){
            $data = array(
                'nazov' => $this->nazov,
                'dokument' => $this->dokument,
                'popis' => $this->popis,
            );
            if($this->CI->dokumenty_m->insertDokument($data)){
                return "novy";
            }else{
                return "chyba";
            }
        }elseif($this->dokument != ""){
            $data = array(
                'nazov' => $this->nazov,
                'dokument' => $this->dokument,
                'popis' => $this->popis,
            );
            if($this->CI->dokumenty_m->updateDokument($this->id, $data)){
                return "update";
            }else{
                return "chyba";
            }
        }else{
            $data = array(
                'nazov' => $this->nazov,
                'popis' => $this->popis,
            );
            if($this->CI->dokumenty_m->updateDokument($this->id, $data)){
                return "update";
            }else{
                return "chyba";
            }
        }
    }
    
    
    public function odstranitDokument($id){
        if($this->CI->dokumenty_m->odstranDokument($id)){
            $this->odstranNepouzivaneImg();
            return TRUE;
        }
        return FALSE;
    }
    
    
    
    private function odstranNepouzivaneImg(){
        $partnery = $this->getDokumenty();
        $img = array();
        
        foreach ($partnery as $row) {
            $img[] = $row['dokument'];
        }
        
        $this->CI->load->helper('file');
        $file = get_filenames($this->CI->config->item('PATH_DOKUMENTY_FOLDER'));
        foreach ($file as $value) {
            if(!in_array($value, $img)){
                unlink($this->path_image.$value);
            }
        }
        
    }
}

