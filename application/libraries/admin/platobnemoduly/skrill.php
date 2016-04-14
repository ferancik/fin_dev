<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Skrill {

    var $CI;
    var $config = "";
    var $skrill_url = '';
    var $logovanie = false;
    var $getData = false;
    var $hashovacieSlovo = '';
    var $ipn_log = true;
    var $ipnmessage = '';

    public function __construct() {
        $this->CI = & get_instance();

        $this->CI->load->helper('url');
        $this->CI->load->helper('form');
        $this->CI->load->model('admin/platobnemoduly/skrill_m');

        $this->config = $this->CI->skrill_m->getNastavenia();

        $this->logovanie = $this->config->logovanie;
        $this->skrill_url = 'https://www.moneybookers.com/app/payment.pl';


        $this->add_field('pay_to_email', $this->config->pay_to_email);
        $this->add_field('language', $this->config->language);
        $this->add_field('currency', $this->config->currency);
        $this->add_field('recipient_description', $this->config->recipient_description); // max 30 char
        $this->add_field('logo_url', $this->config->logo_url);

        $this->hashovacieSlovo = $this->config->hashovacieSlovo;
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
        return;
    }

    function setPlatbaIdentifikator($identifikator) {
        $data = $this->CI->skrill_m->getPlatbaIdentifikator($identifikator);

        if ($data !== false && is_object($data)) {
//            $this->fields = (array) $data;
            $this->add_field('detail1_description', $data->detail1_description);
            $this->add_field('detail1_text', $data->detail1_text);
            $this->add_field('amount', $data->amount);

            $this->add_field('return_url', site_url($data->return_url));
            $this->add_field('cancel_url', site_url($data->cancel_url));
            $this->add_field('status_url', site_url($data->status_url));

            if (isset($data->confirmation_note) && $data->confirmation_note != '') {
                $this->add_field('confirmation_note', $data->confirmation_note);
            }
            if (isset($data->currency) && $data->currency != '') {
                $this->fields['currency'] = $data->currency;
            }
        }
    }

    function zobrazitKlasikFormular() {
        $output = '';
        $output .= '<html>' . "\n";
        $output .= '<head><title>' . $this->config->form_title . '</title></head>' . "\n";
        $output .= '<body onLoad="document.forms[\'skrill_auto_form\'].submit();">' . "\n";
        $output .= '<p>' . $this->config->form_text . '</p>' . "\n";
        $output .= '<form method="post" action="' . $this->skrill_url . '" name="skrill_auto_form"/>' . "\n";
        foreach ($this->fields as $name => $value) {
            $output .= form_hidden($name, $value) . "\n";
        }
        $output .= '<p>' . form_submit('sf_submit', $this->config->form_submit) . '</p>';
        $output .= form_close() . "\n";
        $output .= '</body></html>';
        return $output;
    }

    function zobrazitLenFormular($nazov_tlacidla = false, $extra_tlacidla = '') {
        $output = '<form method="post" action="' . $this->skrill_url . '" name="skrill_auto_form"/>' . "\n";
        foreach ($this->fields as $name => $value) {
            $output .= form_hidden($name, $value) . "\n";
        }
        if (!$nazov_tlacidla) {
            $tTlacidlo = $this->config->form_submit;
        } else {
            $tTlacidlo = $nazov_tlacidla;
        }
        $output .= '<p>' . form_submit('sf_submit', $tTlacidlo, $extra_tlacidla) . '</p>';
        $output .= form_close() . "\n";
        $output .='<script type="text/javascript"> ';
        $output .='document.forms[\'skrill_auto_form\'].submit(); ';
        $output .='</script>';
        return $output;
    }

    function validate() {

        $this->getData = $_POST;
        $requiredFields = array('status', 'md5sig', 'merchant_id', 'pay_to_email', 'mb_amount',
            'mb_transaction_id', 'currency', 'amount', 'transaction_id', 'pay_from_email', 'mb_currency');

        foreach ($requiredFields AS $field) {
            if (!isset($_POST[$field])) {
                $errors[] = 'Chyba polozka ' . $field;
            }
        }

        $md5 = strtoupper(md5($_POST['merchant_id'] . $_POST['transaction_id'] . strtoupper(md5($this->hashovacieSlovo)) . $_POST['mb_amount'] . $_POST['mb_currency'] . $_POST['status']));
        if ($md5 != $_POST['md5sig']) {
            $errors[] = 'Skontrolujte vas Skrill ucet. Neplatny overovaci otlacok (Ma / JE) [' . $md5 . '] [' . $_POST['md5sig'] . ']';
        }

        $message = '';
        foreach ($_POST AS $key => $value) {
            $message .= $key . ': ' . $value . "\n";
        }
        if (sizeof($errors)) {
            $message .= sizeof($errors) . ' error(s):' . "\n";
            $_POST['status'] = 1;
        }

        foreach ($errors AS $error) {
            $message .= $error . "\n";
        }

        $message = nl2br(strip_tags($message));

        $status = (int) ($_POST['status']);
        switch ($status) {
            /* caka na prijatie, platenie pomocou bankoveho prevodu */
            case 0:
                $this->ipnmessage = $message;
                $this->log_ipn_results(false);

                return array('status' => 0, 'sprava' => $message);

                break;

            /* pladba bola uspesna */
            case 2:
                if ($_POST['pay_to_email'] == $this->config->pay_to_email) {
                    $zaplatenaSuma = (float) ($_POST['amount']);
                    $this->ipnmessage = $message;
                    $this->log_ipn_results(true);
                    return array('status' => 2, 'sprava' => $message);
                }
                break;

            /* neznama chyba platba nepresla */
            default:
                $this->ipnmessage = $message;
                $this->log_ipn_results(false);
                return array('status' => -1, 'sprava' => $message);
                break;
        }
    }

    function log_ipn_results($success) {
        if (!$this->ipn_log)
            return;  // is logging turned off?

        $text = '[' . date('m/d/Y g:i A') . '] - ';

        if ($success)
            $text .= "SUCCESS!\n" . $this->ipnmessage . '\n';
        else
            $text .= 'FAIL: ' . $this->ipnmessage . "\n";

        $text .= "IPN POST Vars from Skrill:\n";
        foreach ($this->getData as $key => $value)
            $text .= "$key=$value\n ";

        $data['text'] = $text;

        $log_data = array(
            'log_data' => serialize($data),
            'log_created' => date('Y-m-d H:i:s')
        );

        $this->CI->db->insert('admin_platobnemoduly_skrill_log', $log_data);
        return $this->CI->db->insert_id();
    }

}

