<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Projects
 *
 * @author frantisekferancik
 */
class Projects extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->library('tank_auth_web');
        $this->load->library('form_validation');
        $this->load->model('fin/projekty_m');
        $this->load->library('fin/projects_lib');
    }

    public function addAjax($firma_id) {
        if (!$this->tank_auth_web->is_logged_in()) {
            redirect(site_url('auth/login'));
        } else {
            $this->form_validation->set_rules('nazov', 'Nazov projektu', 'required');
            $projects = $this->projekty_m->getTree(0, 1);

            if ($this->form_validation->run()) {
                $post_data = $this->input->post(null, TRUE);
                $post_data['firma_id'] = $post_data['firma_id'];
                $project_id = $this->projects_lib->insert($post_data);
                
                if ($project_id) {
                    echo json_encode(array(
                        'option' => '<option value="' . $project_id . '" selected>' . $post_data['nazov'] . '</option>',
                        'project_id' => $project_id
                    ));
                } else {
                    echo json_encode(array('ucet' => FALSE));
                }
            } else {
                $this->load->view(TEMPLATE . 'projects/ajax_form', array(
                    'options' => createOption($projects),
                    'firma_id' => $firma_id,
                ));
            }
        }
    }

    function odsadenie($level) {
        if ($level > 0) {
            for ($i = 0; $i <= $level; $i++) {
                $return .= '-';
            }
        }
        return $return;
    }

}
