<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partner {

    private $CI;
    private $id;
    private $nazov;
    private $logo = "";
    private $url = "";
    private $popis = "";
    private $path_image;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('admin/modules/partnery/partnery_m');
        $this->path_image = $this->CI->config->item('PATH_PARTNER_FOLDER');
    }

    public function getId() {
        return $this->id;
    }

    public function getNazov() {
        return $this->nazov;
    }

    public function getLogo($id) {
        return $this->CI->partnery_m->getLogo($id);
    }

    public function getUrl() {
        return $this->url;
    }

    public function getPopis() {
        return $this->popis;
    }

    public function setNazov($nazov) {
        $this->nazov = $nazov;
    }

    public function setLogo($logo) {
        $this->logo = $logo;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setPopis($popis) {
        $this->popis = $popis;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAllPartners() {
        return $this->CI->partnery_m->getAllPartners();
    }

    public function getPartner($id) {
        return $this->CI->partnery_m->getPartner($id);
    }
    
    
    public function ulozit(){
        if($this->id == 'novy'){
            $data = array(
                'nazov' => $this->nazov,
                'logo' => $this->logo,
                'url' => $this->url,
                'popis' => $this->popis,
            );
            
            $this->CI->partnery_m->insertNew($data);
        }elseif($this->id != 'novy' && $this->logo == ""){
            $data = array(
                'nazov' => $this->nazov,
                'url' => $this->url,
                'popis' => $this->popis,
            );
            $this->CI->partnery_m->update($this->id, $data);
        }else{
            $data = array(
                'nazov' => $this->nazov,
                'logo' => $this->logo,
                'url' => $this->url,
                'popis' => $this->popis,
            );
            $this->CI->partnery_m->update($this->id, $data);
        }
        $this->odstranNepouzivaneImg();
    }
    
    public function deletPartner($id){
        $logo = $this->getLogo($id);
        if($this->CI->partnery_m->deletPartner($id)){
            unlink($this->path_image.$logo);
            return TRUE;
        }
        
        return FALSE;
    }
    
    private function odstranNepouzivaneImg(){
        $partnery = $this->getAllPartners();
        $img = array();
        
        foreach ($partnery as $row) {
            $img[] = $row['logo'];
        }
        
        $this->CI->load->helper('file');
        $file = get_filenames($this->path_image);
        foreach ($file as $value) {
            if(!in_array($value, $img)){
                unlink($this->path_image.$value);
            }
        }
        
    }

}


