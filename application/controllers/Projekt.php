<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Projekt
 *
 * @author frantisekferancik
 */
class Projekt extends CI_Controller{
    
    
    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
    }
    
    public function index(){
        $crud = new grocery_CRUD();

        $crud->set_theme('datatables');
        $crud->set_table(DB_PREFIX.'projekty');
        $crud->set_subject('Projekt');
        
        $crud->set_relation("parent_id", DB_PREFIX.'projekty', "Nazov");
        $crud->set_relation_n_n("firma", DB_PREFIX.'firma_projekt', DB_PREFIX.'firma', "projekt_id", "firma_id", "nazov");

        $output = $crud->render();

        $this->template->load(TEMPLATE . 'template', TEMPLATE . 'grocery/grocery_view', $output);
    }
}
