<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transaction
 *
 * @author frantisekferancik
 */
class Transaction_lib {
    
    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('fin/transaction_m');
        $this->CI->load->model('fin/projekty_m');
        $this->CI->load->library('tank_auth_web');
        
    }

    public function insertTransaction($data){
        $priebezny_stav = $this->CI->transaction_m->getPriebeznyStav($data['ucet']);
        
        $suma = 0;
        
        if($data['prijem']>0){
            $typ = 'prijem';
            $suma = $data['prijem'];
            $priebezny_stav += $suma;
        }elseif ($data['vydaj']>0) {
            $typ = 'vydaj';
            $suma = $data['vydaj'];
            $priebezny_stav -= $suma;
        }
        
        $insert_data = array(
            'projekt_id' => ($data['projekt']=='')?0:$data['projekt'],
            'kategoria_id' => $data['ucel'],
            'firma_id' => $data['firma'],
            'user_id' => $this->CI->tank_auth_web->get_user_id(),
            'ucet_id' => $data['ucet'],
            'disponent_id' => $data['disponent'],
            'typ' => $typ,
            'datum' => date('Y-m-d H:i:s'),
            'datum_user' => date("Y-m-d", strtotime($data['datum_user'])),
            'nazov' => $data['nazov'],
            'suma' => $suma,
            'firma_objekt_id' => 0,
            'vytvoril' => $this->CI->users->get_user_by_id($this->CI->tank_auth_web->get_user_id(),1)->email,
            'priebezny_stav' => $priebezny_stav,
        );
        $insert_id = $this->CI->transaction_m->insertTransaction($insert_data);
        if($insert_id){
            return $this->CI->transaction_m->getTransactionAsId($insert_id);
        }else{
            return FALSE;
        }
        
    }
    
    
    public function getData($data, $ucet_id) {
        //preVarDump($data);
//        preVarDump($data['search']['value']);
        $transactions = $this->CI->transaction_m->getTransactionDataTable($ucet_id, $data['start'], $data['length']);
//        preVarDump($transactions);
        
        $orders_array = array();
        foreach ($transactions as $key => $row) {
            $prijem = 0;
            $vydaj = 0;
            if($row->typ == 'prijem'){
                $prijem = $row->suma;
            }elseif($row->typ == 'vydaj'){
                $vydaj = $row->suma;
            }
            $orders_array[] = array(
                $row->tranzakcia_id,
                date("d.m.Y", strtotime($row->datum_user)),
                $row->nazov,
                $row->projekt_nazov,
                $row->ucel_nazov,
                $prijem,
                $vydaj
            );
        }
        
        $record_total = $this->CI->transaction_m->getTransactionsCount($ucet_id);


        return array(
            'draw' => $data['draw'],
            'recordsTotal' => $record_total,
            'recordsFiltered' => 0,
            'data' => $orders_array,
        );
        
    }
}
