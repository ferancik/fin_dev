<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ucel
 *
 * @author frantisekferancik
 */
class Ucel extends CI_Controller{
    
    
    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->library('tank_auth_web');
        $this->load->library('form_validation');
        $this->load->library('fin/ucel_lib');
    }
    
    public function addAjax(){
        if (!$this->tank_auth_web->is_logged_in()) {
            redirect(site_url('auth/login'));
        } else {
            $this->form_validation->set_rules('nazov', 'Nazov projektu', 'required');
            
            
            if ($this->form_validation->run()) {
                $post_data = $this->input->post(null, TRUE);
                $ucel_id = $this->ucel_lib->insert($post_data);
                
                if ($ucel_id) {
                    echo json_encode(array(
                        'option' => '<option value="' . $ucel_id . '" selected>' . $post_data['nazov'] . '</option>',
                        'return_id' => $ucel_id
                    ));
                } else {
                    echo json_encode(array('ucet' => FALSE));
                }
            }else{
                $this->load->view(TEMPLATE . 'ucel/ajax_form', array());
            }
             
        }
    }
    
}
