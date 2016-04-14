<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Platobnemoduly extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        $this->load->model('admin/platobnemoduly/paypal_m');
        $this->load->model('admin/platobnemoduly/skrill_m');

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function show_transactions() {
         $this->load->library('admin/platobnemoduly/transactions');
         $data = $this->transactions->getAllTransactions();
         $this->template_admin->load('admin/template', 'admin/platobnemoduly/transactions', array('data' => $data));
 
    }
    
    public function paypal_nastavenia() {

        $data = $this->paypal_m->getNastavenia();

        $this->form_validation->set_rules('paypal_email', 'PayPal Nastavenia', 'trim|required|max_length[200]|xss_clean');
        $this->form_validation->set_rules('paypal_currency_code', 'Kod meny', 'required|xss_clean');
        $this->form_validation->set_rules('paypal_live', 'PayPal Live', 'required|xss_clean');
        $this->form_validation->set_rules('ipn_log', 'Povolit logovanie', 'required|xss_clean');
        $this->form_validation->set_rules('logo_url', 'URL Loga prostredia', 'xss_clean');
$this->form_validation->set_rules('language', 'Jazyk prostredia', 'xss_clean');



        $this->form_validation->set_rules('form_title', 'Formular title', 'required|xss_clean');
        $this->form_validation->set_rules('form_submit', 'Tlacidlo pre manualne odoslanie', 'required|xss_clean');
        $this->form_validation->set_rules('form_text', 'Text pri presmerovanie ', 'required|xss_clean');

        if ($this->form_validation->run()) {
            $temp = new stdClass();
            $temp->id = "1";
            $temp->paypal_email = $this->form_validation->set_value('paypal_email');
            $temp->paypal_currency_code = $this->form_validation->set_value('paypal_currency_code');
            $temp->paypal_live = $this->form_validation->set_value('paypal_live');
            $temp->ipn_log = $this->form_validation->set_value('ipn_log');
            $temp->logo_url = $this->form_validation->set_value('logo_url');
            $temp->form_title = $this->form_validation->set_value('form_title');
            $temp->form_submit = $this->form_validation->set_value('form_submit');
            $temp->form_text = $this->form_validation->set_value('form_text');
             $temp->language = $this->form_validation->set_value('language');


            $this->paypal_m->upravitNastavenia($temp);
            $this->session->set_flashdata('sprava', "save|Nastavenia PayPal boli aktualizovane");
            redirect('admin/platobnemoduly/paypal_nastavenia');
        }

        $this->template_admin->load('admin/template', 'admin/platobnemoduly/paypal/nastavenia', array('data' => $data));
    }

      public function paypal_logy() {
        $data = $this->paypal_m->getLogy();
        $this->template_admin->load('admin/template', 'admin/platobnemoduly/paypal/logy', array('data' => $data));
    }
    
    public function paypal_pevne_platby() {
        $data = $this->paypal_m->getPevnePlatby();
        $this->template_admin->load('admin/template', 'admin/platobnemoduly/paypal/pevne_platby_index', array('data' => $data));
    }

    public function paypal_pevne_platby_uprava($idPlatby) {
        $texty = array();
        $data = $this->paypal_m->getOnePevnaPlatba($idPlatby);
        if (!$data) {
            $texty['nazov'] = 'Pridat novu pevnu platbu pre PayPal';
        } else {
            $texty['nazov'] = 'Upravit platbu pre PayPal, idenfifikator';
        }

        $this->form_validation->set_rules('identifikator', 'Identifikator', 'trim|required|max_length[200]|xss_clean');
        $this->form_validation->set_rules('popis', 'Popis', 'required|xss_clean');
        $this->form_validation->set_rules('item_name', 'Nazov polozky', 'required|xss_clean');
        $this->form_validation->set_rules('amount', 'Cena', 'required|xss_clean');
        $this->form_validation->set_rules('mena', 'Kod meny', 'xss_clean');
        $this->form_validation->set_rules('quantity', 'Pocet jednotiek', 'required|xss_clean');
        $this->form_validation->set_rules('return', 'Url ak je platba OK', 'required|xss_clean');
        $this->form_validation->set_rules('cancel_return', 'Url ak je platba Zrusena', 'required|xss_clean');
        $this->form_validation->set_rules('notify_url', 'Url pre validaciu platby', 'required|xss_clean');

        if ($this->form_validation->run()) {
            $temp = new stdClass();
            $temp->id = "NULL";
            $temp->mena = '';
            $temp->identifikator = $this->form_validation->set_value('identifikator');
            $temp->popis = $this->form_validation->set_value('popis');
            $temp->item_name = $this->form_validation->set_value('item_name');
            $temp->amount = $this->form_validation->set_value('amount');
            if ($this->form_validation->set_value('mena') != '') {
                $temp->mena = $this->form_validation->set_value('mena');
            }
            $temp->quantity = $this->form_validation->set_value('quantity');
            $temp->return = $this->form_validation->set_value('return');
            $temp->cancel_return = $this->form_validation->set_value('cancel_return');
            $temp->notify_url = $this->form_validation->set_value('notify_url');

            if (!$data) {
                $ok = $this->paypal_m->insertPevnaPlatba($temp);
            } else {
                $temp->id = $data->id;
                $ok = $this->paypal_m->editPevnaPlatba($temp);
            }
            if (!$data) {
                $this->session->set_flashdata('sprava', "save|Pevna platba bola uspesne pridana");
            } else {

                $this->session->set_flashdata('sprava', "save|Pevna platba bola aktualizovana");
            }
            redirect('admin/platobnemoduly/paypal_pevne_platby');
        }



        $this->template_admin->load('admin/template', 'admin/platobnemoduly/paypal/pevne_platby_uprava', array('data' => $data, 'text' => $texty));
    }

    public function paypal_pevne_platby_zmazat($idPlatby) {
        $data = $this->paypal_m->getOnePevnaPlatba($idPlatby);
        if (!$data) {
            $this->session->set_flashdata('sprava', "error|Vybrana platba neexistuje");
            redirect('admin/platobnemoduly/paypal_pevne_platby');
        } else {
            $this->paypal_m->delPevnaPlatba($data->id);
            $this->session->set_flashdata('sprava', "info|Pevna platba bola odstranena");
            redirect('admin/platobnemoduly/paypal_pevne_platby');
        }
    }

    // skrill
    public function skrill_pevne_platby() {
        $data = $this->skrill_m->getPevnePlatby();
        $this->template_admin->load('admin/template', 'admin/platobnemoduly/skrill/pevne_platby_index', array('data' => $data));
    }

    public function skrill_logy() {
        $data = $this->skrill_m->getLogy();
        $this->template_admin->load('admin/template', 'admin/platobnemoduly/skrill/logy', array('data' => $data));
    }
    
    public function skrill_nastavenia() {
        $data = $this->skrill_m->getNastavenia();

        $this->form_validation->set_rules('pay_to_email', 'Skrill ucet', 'trim|required|max_length[200]|xss_clean');
        $this->form_validation->set_rules('recipient_description', 'Popis prijemcu', 'xss_clean');
        $this->form_validation->set_rules('currency', 'Kod meny', 'required|xss_clean');
        $this->form_validation->set_rules('language', 'Jazyk prostredia', 'required|xss_clean');
        $this->form_validation->set_rules('logo_url', 'URL Loga prostredia', 'xss_clean');
        $this->form_validation->set_rules('logovanie', 'Povolit logovanie', 'required|xss_clean');
        $this->form_validation->set_rules('hashovacieSlovo', 'Hashovacie Slovo', 'required|xss_clean');


        $this->form_validation->set_rules('form_title', 'Formular title', 'required|xss_clean');
        $this->form_validation->set_rules('form_submit', 'Tlacidlo pre manualne odoslanie', 'required|xss_clean');
        $this->form_validation->set_rules('form_text', 'Text pri presmerovanie ', 'required|xss_clean');

        if ($this->form_validation->run()) {
            $temp = new stdClass();
            $temp->id = "1";
            $temp->pay_to_email = $this->form_validation->set_value('pay_to_email');
            $temp->recipient_description = $this->form_validation->set_value('recipient_description');
            $temp->currency = $this->form_validation->set_value('currency');
            $temp->language = $this->form_validation->set_value('language');
            $temp->logo_url = $this->form_validation->set_value('logo_url');
            $temp->logovanie = $this->form_validation->set_value('logovanie');
            $temp->hashovacieSlovo = $this->form_validation->set_value('hashovacieSlovo');


            $temp->form_title = $this->form_validation->set_value('form_title');
            $temp->form_submit = $this->form_validation->set_value('form_submit');
            $temp->form_text = $this->form_validation->set_value('form_text');


            $this->skrill_m->upravitNastavenia($temp);
            $this->session->set_flashdata('sprava', "save|Nastavenia Skrill-u boli aktualizovane");
            redirect('admin/platobnemoduly/skrill_nastavenia');
        }

        $this->template_admin->load('admin/template', 'admin/platobnemoduly/skrill/nastavenia', array('data' => $data));
    }

    public function skrill_pevne_platby_uprava($idPlatby) {
        $texty = array();
        $data = $this->skrill_m->getOnePevnaPlatba($idPlatby);
        if (!$data) {
            $texty['nazov'] = 'Pridat novu pevnu platbu pre Skrill';
        } else {
            $texty['nazov'] = 'Upravit platbu pre Skrill, idenfifikator';
        }

        $this->form_validation->set_rules('identifikator', 'Identifikator', 'trim|required|max_length[200]|xss_clean');
        $this->form_validation->set_rules('popis', 'Popis', 'required|xss_clean');

        $this->form_validation->set_rules('detail1_description', 'Nazov polozky', 'required|xss_clean');
        $this->form_validation->set_rules('detail1_text', 'Popis polozky', 'required|xss_clean');
        $this->form_validation->set_rules('amount', 'Cena', 'required|xss_clean');
        $this->form_validation->set_rules('currency', 'Kod meny', 'xss_clean');

        $this->form_validation->set_rules('confirmation_note', 'Poznamka pre potvrdenie', 'xss_clean');
        $this->form_validation->set_rules('return_url', 'Url ak je platba OK', 'required|xss_clean');
        $this->form_validation->set_rules('cancel_url', 'Url ak je platba Zrusena', 'required|xss_clean');
        $this->form_validation->set_rules('status_url', 'Url pre validaciu platby', 'required|xss_clean');

        if ($this->form_validation->run()) {
            $temp = new stdClass();
            $temp->id = "NULL";
            $temp->currency = '';
            $temp->identifikator = $this->form_validation->set_value('identifikator');
            $temp->popis = $this->form_validation->set_value('popis');
            $temp->detail1_description = $this->form_validation->set_value('detail1_description');
            $temp->detail1_text = $this->form_validation->set_value('detail1_text');
            $temp->amount = $this->form_validation->set_value('amount');

            $temp->confirmation_note = $this->form_validation->set_value('confirmation_note');
            $temp->return_url = $this->form_validation->set_value('return_url');
            $temp->cancel_url = $this->form_validation->set_value('cancel_url');
            $temp->status_url = $this->form_validation->set_value('status_url');



            $temp->amount = $this->form_validation->set_value('amount');
            if ($this->form_validation->set_value('currency') != '') {
                $temp->currency = $this->form_validation->set_value('currency');
            }


            if (!$data) {
                $ok = $this->skrill_m->insertPevnaPlatba($temp);
            } else {
                $temp->id = $data->id;
                $ok = $this->skrill_m->editPevnaPlatba($temp);
            }
            if (!$data) {
                $this->session->set_flashdata('sprava', "save|Pevna platba bola uspesne pridana");
            } else {

                $this->session->set_flashdata('sprava', "save|Pevna platba bola aktualizovana");
            }
            redirect('admin/platobnemoduly/skrill_pevne_platby');
        }
        $this->template_admin->load('admin/template', 'admin/platobnemoduly/skrill/pevne_platby_uprava', array('data' => $data, 'text' => $texty));
    }

    public function skrill_pevne_platby_zmazat($idPlatby) {
        $data = $this->skrill_m->getOnePevnaPlatba($idPlatby);
        if (!$data) {
            $this->session->set_flashdata('sprava', "error|Vybrana platba neexistuje");
            redirect('admin/platobnemoduly/skrill_pevne_platby');
        } else {
            $this->skrill_m->delPevnaPlatba($data->id);
            $this->session->set_flashdata('sprava', "info|Pevna platba bola odstranena");
            redirect('admin/platobnemoduly/skrill_pevne_platby');
        }
    }

}

