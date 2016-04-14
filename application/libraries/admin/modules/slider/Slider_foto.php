<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Slider_foto {

    private $CI;
    private $id = "0";
    private $id_mod_sliders;
    private $name;
    private $image = "";
    private $popis;
    private $PATH_IMAGE_FOLDER = "";

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('admin/modules/sliders/sliders_data_m', '', TRUE);
    }

    public function getId() {
        return $this->id;
    }

    public function getId_mod_sliders() {
        return $this->id_mod_sliders;
    }

    public function getName() {
        return $this->name;
    }

    public function getImage() {
        return $this->image;
    }

    public function getPopis() {
        return $this->popis;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setId_mod_sliders($id_mod_sliders) {
        $this->id_mod_sliders = $id_mod_sliders;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setPopis($popis) {
        $this->popis = $popis;
    }
    
    public function getFoto($id){
        $data = $this->CI->sliders_data_m->getFotoData($id);
        if($data){
            return $data;
        }
        return FALSE;
    }

    public function ulozitFoto() {
        if ($this->id == 'novy') {
            $data['id_mod_sliders'] = $this->id_mod_sliders;
            $data['name'] = $this->name;
            $data['image'] = $this->image;
            $data['popis'] = $this->popis;
            $this->CI->sliders_data_m->insertNew($data);
        } elseif ($this->id != 'novy' && $this->image != "") {
            $data['id_mod_sliders'] = $this->id_mod_sliders;
            $data['name'] = $this->name;
            $data['image'] = $this->image;
            $data['popis'] = $this->popis;
            $this->CI->sliders_data_m->updateFoto($this->id, $data);
        } else {
            $data['id_mod_sliders'] = $this->id_mod_sliders;
            $data['name'] = $this->name;
            $data['popis'] = $this->popis;
            $this->CI->sliders_data_m->updateFoto($this->id, $data);
        }
    }

    public function upravPoradieFoto($data) {
        if ($data) {
            foreach ($data as $key => $value) {
                $temp = explode("_", $value);
                $this->CI->sliders_data_m->updateFoto($temp[1], array('poradie'=>$key));
            }
        }
    }
    
    public function odstranFoto($id){
        $foto = $this->getFoto($id);
        if($this->CI->sliders_data_m->odstranFoto($id)){
            unlink($this->CI->config->item('PATH_SLIDER_FOLDER').$foto['image']);
        }
    }

}

