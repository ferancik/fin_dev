<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paypal {

    var $last_error = '';
    var $ipn_log;
    var $ipn_response = '';
    var $ipn_data = array();
    var $fields = array();
    var $paypal_url = '';
    var $paypal_cmd = '_xclick';
    var $CI;
    var $config = "";
    private $orderFields = array('notify_version', 'verify_sign', 'test_ipn', 'protection_eligibility', 'charset', 'btn_id', 'address_city', 'address_country', 'address_country_code', 'address_name', 'address_state', 'address_status', 'address_street', 'address_zip', 'first_name', 'last_name', 'payer_business_name', 'payer_email', 'payer_id', 'payer_status', 'contact_phone', 'residence_country', 'business', 'receiver_email', 'receiver_id', 'custom', 'invoice', 'memo', 'option_name_1', 'option_name_2', 'option_selection1', 'option_selection2', 'tax decimal', 'auth_id', 'auth_exp', 'auth_amount', 'auth_status', 'num_cart_items', 'parent_txn_id', 'payment_date', 'payment_status', 'payment_type', 'pending_reason', 'reason_code', 'remaining_settle', 'shipping_method', 'shipping', 'transaction_entity', 'txn_id', 'txn_type', 'exchange_rate', 'mc_currency', 'mc_fee', 'mc_gross', 'mc_handling', 'mc_shipping', 'payment_fee', 'payment_gross', 'settle_amount', 'settle_currency', 'auction_buyer_id', 'auction_closing_date', 'auction_multi_item', 'for_auction', 'subscr_date', 'subscr_effective', 'period1', 'period2', 'period3', 'amount1', 'amount2', 'amount3', 'mc_amount1', 'mc_amount2', 'mc_amount3', 'recurring', 'reattempt', 'retry_at', 'recur_times', 'username', 'password', 'subscr_id', 'case_id', 'case_type', 'case_creation_date', 'order_status', 'discount', 'shipping_discount', 'ipn_track_id', 'transaction_subject');

    public function __construct() {
        $this->CI = & get_instance();

        $this->CI->load->helper('url');
        $this->CI->load->helper('form');
        $this->CI->load->model('admin/platobnemoduly/paypal_m');

        $this->config = $this->CI->paypal_m->getNastavenia();

        $this->ipn_log = $this->config->ipn_log;
        $this->paypal_url = ( $this->config->paypal_live) ? 'https://www.paypal.com/cgi-bin/webscr' : 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $this->add_field('business', $this->config->paypal_email);
        $this->add_field('currency_code', $this->config->paypal_currency_code);
        $this->add_field('image_url', $this->config->logo_url);
        
    }

    function getNastavenia() {
        return $this->config;
    }

    function setPlatbaIdentifikator($identifikator) {
        $data = $this->CI->paypal_m->getPlatbaIdentifikator($identifikator);

        if ($data !== false && is_object($data)) {
//            $this->fields = (array) $data;

            $this->add_field('return', site_url($data->return));
            $this->add_field('cancel_return', site_url($data->cancel_return));
            $this->add_field('notify_url', site_url($data->notify_url));

            $this->add_field('item_name', $data->item_name);
            $this->add_field('amount', $data->amount);
            $this->add_field('quantity', $data->quantity);
            if (isset($data->mena) && $data->mena!=''){
                $this->fields['currency_code'] = $data->mena;
            }
        }
    }

    function add_field($field, $value) {
        $this->fields[$field] = $value;
    }

    public function clear() {
        $this->fields = array();
    }

    public function initialize($options = array()) {
        if (is_array($options)) {
            foreach ($options as $key => $value) {
                $this->$key = $value;
            }
        }

        $this->add_field('rm', '2');
        $this->add_field('cmd', $this->paypal_cmd);
        return;
    }

    function zobrazitKlasikFormular() {
        $output = '';
        $output .= '<html>' . "\n";
        $output .= '<head><title>' . $this->config->form_title . '</title></head>' . "\n";
        $output .= '<body onLoad="document.forms[\'paypal_auto_form\'].submit();">' . "\n";
        $output .= '<p>' . $this->config->form_text . '</p>' . "\n";
        $output .= '<form method="post" action="' . $this->paypal_url . '" name="paypal_auto_form"/>' . "\n";
        foreach ($this->fields as $name => $value) {
            $output .= form_hidden($name, $value) . "\n";
        }
        $output .= '<p>' . form_submit('pp_submit', $this->config->form_submit) . '</p>';
        $output .= form_close() . "\n";
        $output .= '</body></html>';
        return $output;
    }

    function zobrazitLenFormular($nazov_tlacidla = false, $extra_tlacidla = '') {
        $output = '<form method="post" action="' . $this->paypal_url . '" name="paypal_auto_form"/>' . "\n";
        foreach ($this->fields as $name => $value) {
            $output .= form_hidden($name, $value) . "\n";
        }
        if (!$nazov_tlacidla) {
            $tTlacidlo = $this->config->form_submit;
        } else {
            $tTlacidlo = $nazov_tlacidla;
        }
        $output .= '<p>' . form_submit('pp_submit', $tTlacidlo, $extra_tlacidla) . '</p>';
        $output .= form_close() . "\n";
        $output .='<script type="text/javascript"> ';
        $output .='document.forms[\'paypal_auto_form\'].submit(); ';
        $output .='</script>';
        return $output;
    }

    function validate_ipn() {
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        $req = 'cmd=_notify-validate';
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

        $ch = curl_init($this->paypal_url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        if (!($res = curl_exec($ch))) {
            curl_close($ch);
            exit;
        }
        curl_close($ch);

        $this->ipn_data = $_POST;

        if (strcmp($res, "VERIFIED") == 0) {
            return $this->log_ipn_results(true);
        } else if (strcmp($res, "INVALID") == 0) {
            $this->last_error = 'IPN Validation Failed.';
            $this->log_ipn_results(false);
            return false;
        }
    }

    function log_ipn_results($success) {
        if (!$this->ipn_log)
            return;  // is logging turned off?

        $text = '[' . date('m/d/Y g:i A') . '] - ';

        if ($success)
            $text .= "SUCCESS!\n";
        else
            $text .= 'FAIL: ' . $this->last_error . "\n";

        $text .= "IPN POST Vars from Paypal:\n";
        foreach ($this->ipn_data as $key => $value)
            $text .= "$key=$value\n ";

        $data['text'] = $text;

        $log_data = array(
            'log_data' => serialize($data),
            'log_created' => date('Y-m-d H:i:s')
        );

        $this->CI->db->insert('admin_platobnemoduly_paypal_log', $log_data);
        return $this->CI->db->insert_id();
    }
}

