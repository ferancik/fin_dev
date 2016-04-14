<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class NavBlok {
    
    private $id;
    private $nadpis;
    private $odkaz_na_stranku;
    private $icon;
    private $text;
   
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('admin/modules/navbloky/navbloky_m');
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNadpis() {
        return $this->nadpis;
    }

    public function getOdkaz_na_stranku() {
        return $this->odkaz_na_stranku;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function getText() {
        return $this->text;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNadpis($nadpis) {
        $this->nadpis = $nadpis;
    }

    public function setOdkaz_na_stranku($odkaz_na_stranku) {
        $this->odkaz_na_stranku = $odkaz_na_stranku;
    }

    public function setIcon($icon) {
        $this->icon = $icon;
    }

    public function setText($text) {
        $this->text = $text;
    }
    
    public function getNavBlok($id){
        return $this->CI->navbloky_m->getNavBlok($id);
    }
    
    public function getNavBloky(){
        return $this->CI->navbloky_m->getNavBloky();
    }
    
    public function ulozit() {
        if ($this->id == "novy") {
            $data = array(
                'nadpis' => $this->nadpis,
                'odkaz_na_stranku' => $this->odkaz_na_stranku,
                'icon' => $this->icon,
                'text' => $this->text,
            );

            $this->CI->navbloky_m->insertNew($data);
            $this->odstranNepouzivaneImg();
            return 'novy';
        } elseif ($this->id != 'novy' && $this->icon == "") {
            $data = array(
                'nadpis' => $this->nadpis,
                'odkaz_na_stranku' => $this->odkaz_na_stranku,
                'text' => $this->text,
            );
            $this->CI->navbloky_m->updateNavBlok($this->id, $data);
            $this->odstranNepouzivaneImg();
            return 'update';
        } else {
            $data = array(
                'nadpis' => $this->nadpis,
                'odkaz_na_stranku' => $this->odkaz_na_stranku,
                'icon' => $this->icon,
                'text' => $this->text,
            );
            $this->CI->navbloky_m->updateNavBlok($this->id, $data);
            $this->odstranNepouzivaneImg();
            return 'update';
        }
    }

    public function upravPoradie($data) {
        foreach ($data as $key => $value) {
            $temp = explode("_", $value);
            $this->CI->navbloky_m->updateNavblok($temp[1], array('poradie' => $key));
        }
    }

    public function odstranNavBlok($id) {
        $navBlok = $this->getNavBlok($id);
        if ($this->CI->navbloky_m->odstranNavBlok($id)) {
            $this->odstranNepouzivaneImg();
            return TRUE;
        }
        return FALSE;
    }

    private function odstranNepouzivaneImg() {
        $navbloky = $this->getNavBloky();
        $img = array();

        foreach ($navbloky as $row) {
            $img[] = $row['icon'];
        }

        $this->CI->load->helper('file');
        $file = get_filenames($this->CI->config->item('PATH_NAVBLKY_FOLDER'));
        foreach ($file as $value) {
            if (!in_array($value, $img)) {
                unlink($this->CI->config->item('PATH_NAVBLKY_FOLDER') . $value);
            }
        }
    }
}

