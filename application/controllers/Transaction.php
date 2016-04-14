<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

/**
 * Description of Transaction
 *
 * @author frantisekferancik
 */
class Transaction extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->library('tank_auth_web');
        $this->load->library('form_validation');
        $this->load->library('fin/transaction_lib');

        $this->load->model("fin/firma_m");
        $this->load->model('fin/transaction_m');
        $this->load->model('fin/projekty_m');
    }

    public function index($firma_id) {
        if (!$this->tank_auth_web->is_logged_in()) {
            redirect(site_url('auth/login'));
        } else {
            
            $firma = $this->firma_m->getFirmaAsId($firma_id);

            $ucty = $this->firma_m->getFirmaUcty($firma_id);
            
            $projects = $this->projekty_m->getTree(0, $firma_id);
            
            $disponents = $this->firma_m->getDisponets();
            
            $ucely = $this->firma_m->getUcely();
            
            $prijem = array();
            $vydaj = array();
            $priebezny_stav = array();
            foreach ($ucty as $key => $ucet) {
                $transactions[$ucet->ucet_id] = $this->transaction_m->getTransactions(array('ucet_id' => $ucet->ucet_id));
                $prijem[$ucet->ucet_id] = $this->transaction_m->getTrasactionSumTyp(array('ucet_id' => $ucet->ucet_id, 'typ'=>'prijem'));
                $vydaj[$ucet->ucet_id] = $this->transaction_m->getTrasactionSumTyp(array('ucet_id' => $ucet->ucet_id, 'typ'=>'vydaj'));
                $priebezny_stav[$ucet->ucet_id] = $transactions[$ucet->ucet_id][0]->priebezny_stav;
            }
            
            $this->template->load(TEMPLATE . 'template', TEMPLATE . 'transaction/form', array(
                'firma' => $firma,
                'ucely' => $ucely,
                'disponents' => $disponents,
                'ucty' => $ucty,
                'projekty' => $projects,
                'transactions' => $transactions,
                'prijem' => $prijem,
                'vydaj' => $vydaj,
                'priebezny_stav' => $priebezny_stav,
                    )
            );
        }
    }
    
    public function getAllDataTable(){
        if (!$this->tank_auth_web->is_logged_in()) {
            redirect(site_url('auth/login'));
        } else {
            $ucty = $this->firma_m->getFirmaUcty($this->input->post("firma_id", TRUE));
            
            $html = $this->load->view(TEMPLATE.'transaction/data_table', array('ucty' => $ucty), TRUE);
            
            echo json_encode(array('html'=> $html));
        }
    }

    



    public function updateTable(){
        if (!$this->tank_auth_web->is_logged_in()) {
            redirect(site_url('auth/login'));
        } else {
            $data = $this->input->post(null, TRUE);
            
            
        }
    }

    public function insertTransaction() {
        $data_transaction = $this->input->post(null, TRUE);
        $return_data = $this->transaction_lib->insertTransaction($data_transaction);
        if($return_data){
            $prijem = 0;
            $vydaj = 0;
            if($return_data->typ == 'prijem'){
                $prijem = $return_data->suma;
            }elseif($return_data->typ == 'vydaj'){
                $vydaj = $return_data->suma;
            }
            $return = array(
                'tranzakcia_id' => $return_data->tranzakcia_id,
                'datum' => date("d.m. Y H:i", strtotime($return_data->datum_user)),
                'nazov' => $return_data->nazov,
                'projekt_nazov' => $return_data->projekt_nazov,
                'ucel_nazov' => $return_data->ucel_nazov,
                'typ' => $return_data->typ,
                'suma' => $return_data->suma,
                'stav' => TRUE,
                'prijem' => $prijem,
                'vydaj' => $vydaj,                
            );
            echo json_encode($return);
        }else{
            echo json_encode(array('stav'=>FALSE));
        }
    }
    
    public function getTransaction(){
        if (!$this->tank_auth_web->is_logged_in()) {
            redirect(site_url('auth/login'));
        } else {
            $post_data = $this->input->post(null, TRUE);
            
            preVarDump($post_data);
        }
    }
    
    
    public function getTransactions($ucet_id){
        if (!$this->tank_auth_web->is_logged_in()) {
            redirect(site_url('auth/login'));
        } else {
            $data = $this->input->post(null, TRUE);
            
            echo json_encode($this->transaction_lib->getData($data, $ucet_id));            
        }
    }

    public function getData() {
        $firma_id = $this->input->post("firma_id", TRUE);

        $ucty = $this->firma_m->getFirmaUcty($firma_id);
        $projekty = $this->firma_m->getFirmaProjekty($firma_id);

        echo json_encode(array('field' => $this->load->view(TEMPLATE . 'transaction/ucty_field', array(
                'ucty' => $ucty,
                'projekty' => $projekty,
                    ), TRUE)));
    }

    public function getPriebeznyStav() {
        $ucet_id = $this->input->post("ucet_id", TRUE);

        $pribezny_stav = $this->transaction_m->getPriebeznyStav($ucet_id);
        echo json_encode(array('stav' => $pribezny_stav));
    }

}
