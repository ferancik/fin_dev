<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class send_mail_lib {

    private $settings;
    private $config_email;

    function __construct() {
        $this->ci = & get_instance();
    }

    // pri uspesnej platbe
    function sendEmail($template, $email, $data, $subject, $from = null, $files = false) {
        

        $this->ci->load->library('email');
        $this->ci->lang->load('tank_auth');
        if ($from!=null){
        $this->ci->email->from($from['email'], $from['meno']);
        }
        $this->ci->email->to($email);
        $this->ci->email->subject($subject);
        
        $this->ci->email->message($this->ci->load->view($template, $data, TRUE));
        if ($files) {
            foreach ($files as $value) {
                $this->ci->email->attach($value);
            }
        }
        $this->ci->email->send();
    }
    
    public function sendEmailSys($template, $subject, $email, $data, $files = FALSE){
        $this->sendEmail($template, $email, $data, $subject, null, $files = false);
    }

}

