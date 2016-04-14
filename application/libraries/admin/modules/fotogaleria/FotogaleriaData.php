<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class FotogaleriaData{
        public $id;
	public $nazov = "";
	public $popis = "";
	public $small_nazov = "";
	public $small_popis = "";
	public $meta_desc = " ";
	public $meta_tags = " ";
	public $url_adresa = "";
	public $poradie = 0;
        
        public $obrazky = array();
        
     public function __construct() {
         
     }
     
     public function addObrazky($data){
     $this->obrazky = $data;
     }
}

