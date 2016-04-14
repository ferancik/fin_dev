<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->library('admin/modules/stranky/stranky_lib');
    }

    public function index($stranka) {
        if ($stranka) {
            $data = $this->stranky_lib->getStrankaURL($stranka);
            if (!$data) {
                redirect('/');
            }
            $this->template->load(TEMPLATE . 'template', TEMPLATE . 'page/static', array('data' => $data));
//            $this->template->load('web/pages/page', array('data' => $data, 'title' => $data->nazov, 'meta_desc' => $data->seo_popis, 'meta_tags' => $data->seo_tagy));
        } else {
            redirect('/');
        }
    }

    public function kontakt() {

        $this->template->load(TEMPLATE . 'template', TEMPLATE . 'page/contact');
    }

    public function page404() {
        $data = $this->stranky_lib->getStrankaKOD('page404');
        if (!$data) {
            redirect('/');
        }

        $this->template->load('web/pages/page', array('data' => $data, 'title' => $data->nazov, 'meta_desc' => $data->seo_popis, 'meta_tags' => $data->seo_tagy));
    }

}
