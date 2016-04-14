<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Disponent
 *
 * @author frantisekferancik
 */
class Disponent extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->library('tank_auth_web');
        $this->load->library('form_validation');
        $this->load->library('fin/disponent_lib');
    }
    
    public function addAjax(){
        if (!$this->tank_auth_web->is_logged_in()) {
            redirect(site_url('auth/login'));
        } else {
            
            $this->form_validation->set_rules('nazov', 'Nazov projektu', 'required');
            
            if ($this->form_validation->run()) {
                $post_data = $this->input->post(null, TRUE);
                $disponent_id = $this->disponent_lib->insert($post_data);
                
                if ($disponent_id) {
                    echo json_encode(array(
                        'option' => '<option value="' . $disponent_id . '" selected>' . $post_data['nazov'] . '</option>',
                        'project_id' => $disponent_id
                    ));
                } else {
                    echo json_encode(array('disponent' => FALSE));
                }
            }else{
                $this->load->view(TEMPLATE . 'disponent/ajax_form', array());
            }
             
        }
    }
}
