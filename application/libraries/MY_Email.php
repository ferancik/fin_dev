<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Email extends CI_Email {

    public function __construct($config = array()) {
        parent::__construct($config);

        $CI = get_instance();
        $CI->load->model('admin/emailnastavenia_m');

        $setting = $CI->emailnastavenia_m->getNastavenia();
        $config['useragent'] = 'KF CMS system';
        $config['protocol'] = $setting->protocol;
        $config['mailtype'] = $setting->mailtype;
        $config['charset'] = $setting->charset;
        $config['priority'] = $setting->priority;

        if ($setting->protocol == 'smtp') {
            $config['smtp_host'] = $setting->smtp_server ;
            $config['smtp_user'] = $setting->smtp_user;
            $config['smtp_pass'] = $setting->smtp_pass;
            $config['smtp_port'] = $setting->smtp_port;
            $config['smtp_secure'] = $setting->smtp_secure;
        }

        $this->initialize($config);
        $this->from($setting->email_odosielania,$setting->email_odosielania_meno);
        $this->reply_to($setting->email_pre_odpoved,$setting->email_pre_odpoved);
    }

}

