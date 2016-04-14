<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ucty
 *
 * @author frantisekferancik
 */
class Ucty extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->library('tank_auth_web');
        $this->load->library('form_validation');
        $this->load->library('fin/ucty_lib');
    }

    public function addAjax($firma_id) {
        if (!$this->tank_auth_web->is_logged_in()) {
            redirect(site_url('auth/login'));
        } else {

            $this->form_validation->set_rules('name', 'Nazov uctu', 'required');

            if ($this->form_validation->run()) {
                $post_data = $this->input->post(null, TRUE);
                $post_data['firma_id'] = $firma_id;
                $ucet_id = $this->ucty_lib->insert($post_data);

                if ($ucet_id) {
                    echo json_encode(array(
                        'ucet' => '<option value="' . $ucet_id . '" selected>' . $post_data['name'] . '</option>',
                        'ucet_id' => $ucet_id
                    ));
                } else {
                    echo json_encode(array('ucet' => FALSE));
                }
            } else {
                $this->load->view(TEMPLATE . 'ucty/ajax_form', array('firma_id' => $firma_id));
            }
        }
    }

}
