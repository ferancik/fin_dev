<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Transaction_m
 *
 * @author frantisekferancik
 */
class Transaction_m extends CI_Model {

    public function getPriebeznyStav($ucet_id) {
        $query = $this->db->select("priebezny_stav")
                ->from(DB_PREFIX . 'transactions')
                ->where("ucet_id", $ucet_id)
                ->order_by("datum", 'desc')
                ->limit(1)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row()->priebezny_stav;
        }

        return 0;
    }

    public function getTransactionDataTable($ucet_id) {
        $query = $this->db->select(DB_PREFIX . 'transactions.*,' . DB_PREFIX . 'projekty.nazov as projekt_nazov,' . DB_PREFIX . 'ucel.nazov as ucel_nazov')
                ->from(DB_PREFIX . 'transactions')
                ->where(DB_PREFIX . 'transactions.ucet_id', $ucet_id)
                ->join(DB_PREFIX . 'projekty', DB_PREFIX . 'projekty.projekt_id = ' . DB_PREFIX . 'transactions.projekt_id', 'left')
                ->join(DB_PREFIX . 'ucel', DB_PREFIX . 'ucel.kategoria_id = ' . DB_PREFIX . 'transactions.kategoria_id', 'inner')
                ->order_by(DB_PREFIX . 'transactions.datum', 'desc')
                ->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getTransactionsCount($ucet_id) {
        $query = $this->db->select("count(tranzakcia_id) as pocet")
                ->from(DB_PREFIX . 'transactions')
                ->where(DB_PREFIX . 'transactions.ucet_id', $ucet_id)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row()->pocet;
        }
        return 0;
    }
    
    /*
     * vrati kumulativny prijem na danom ucte
     */

    public function getTrasactionSumTyp($filter) {
        $query = $this->db->select("sum(".DB_PREFIX."transactions.suma) as suma")
                ->from(DB_PREFIX . 'transactions')
                ->where(DB_PREFIX . 'transactions.ucet_id', $filter['ucet_id'])
                ->where(DB_PREFIX. 'transactions.typ', $filter['typ'])
                ->join(DB_PREFIX . 'projekty', DB_PREFIX . 'projekty.projekt_id = ' . DB_PREFIX . 'transactions.projekt_id', 'left')
                ->join(DB_PREFIX . 'ucel', DB_PREFIX . 'ucel.kategoria_id = ' . DB_PREFIX . 'transactions.kategoria_id', 'inner')
                ->order_by(DB_PREFIX . 'transactions.datum', 'desc')
                ->get();

        if ($query->num_rows() > 0) {
            return $query->row()->suma;
        }
        return 0;
    }

    public function getTransactions($filter) {

        $query = $this->db->select(DB_PREFIX . 'transactions.*,' . DB_PREFIX . 'projekty.nazov as projekt_nazov,' . DB_PREFIX . 'ucel.nazov as ucel_nazov')
                ->from(DB_PREFIX . 'transactions')
                ->where(DB_PREFIX . 'transactions.ucet_id', $filter['ucet_id'])
                ->join(DB_PREFIX . 'projekty', DB_PREFIX . 'projekty.projekt_id = ' . DB_PREFIX . 'transactions.projekt_id', 'left')
                ->join(DB_PREFIX . 'ucel', DB_PREFIX . 'ucel.kategoria_id = ' . DB_PREFIX . 'transactions.kategoria_id', 'inner')
                ->order_by(DB_PREFIX . 'transactions.datum', 'desc')
                ->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return FALSE;
    }

    public function getTransactionAsId($transaction_id) {
        $query = $this->db->select(DB_PREFIX . 'transactions.*,' . DB_PREFIX . 'projekty.nazov as projekt_nazov,' . DB_PREFIX . 'ucel.nazov as ucel_nazov')
                ->from(DB_PREFIX . 'transactions')
                ->where(DB_PREFIX . 'transactions.tranzakcia_id', $transaction_id)
                ->join(DB_PREFIX . 'projekty', DB_PREFIX . 'projekty.projekt_id = ' . DB_PREFIX . 'transactions.projekt_id', 'left')
                ->join(DB_PREFIX . 'ucel', DB_PREFIX . 'ucel.kategoria_id = ' . DB_PREFIX . 'transactions.kategoria_id', 'inner')
                ->order_by(DB_PREFIX . 'transactions.datum', 'desc')
                ->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return FALSE;
    }

    public function insertTransaction($data) {
        if ($this->db->insert(DB_PREFIX . 'transactions', $data)) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

}
