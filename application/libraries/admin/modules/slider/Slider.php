<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Slider {
    
    private $CI;
    private $id;
    private $nazov;
    private $umiestnenie = "";
    private $popis = "";
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('admin/modules/sliders/sliders_data_m');
        $this->CI->load->model('admin/modules/sliders/sliders_m','', TRUE);
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNazov() {
        return $this->nazov;
    }

    public function getUmiestnenie() {
        return $this->umiestnenie;
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

    public function setUmiestnenie($umiestnenie) {
        $this->umiestnenie = $umiestnenie;
    }

    public function setPopis($popis) {
        $this->popis = $popis;
    }

    
    public function ulozitSlider(){
        if($this->id == 'novy'){
            $data['nazov'] = $this->nazov;
            $data['umiestnenie'] = $this->umiestnenie;
            $data['popis'] = $this->popis;
            echo 'novy slider<br />';
            return $this->CI->sliders_m->insertNewSlider($data);
        }else{
            $data['nazov'] = $this->nazov;
            $data['umiestnenie'] = $this->umiestnenie;
            $data['popis'] = $this->popis;
            echo 'update slider<br />';
            return $this->CI->sliders_m->updateSlider($this->id, $data);
        }
        
    }
    
    public function getAllSliders(){
        return $this->CI->sliders_m->getAllSliders();
    }
    
    public function getSliderById($id){
        return $this->CI->sliders_m->getSliderData($id);
    }
    
    public function getSliderData($name_slider){
        $data = $this->CI->sliders_m->getSliderDataName($name_slider);
        if($data){
            return $data;
        }
        return FALSE;
    }
}

