<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Event
 *
 * @author frantisekferancik
 */
class Event extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('template');
        $this->load->model('anonco/event_m');
        $this->load->model('anonco/form_m');
        
        
        $this->load->library('anonco/Submission_lib');
    }
    
    public function index(){
        
        echo " som ut";
    }

        public function detail($url){
        $event = $this->event_m->getEventDetailUrl($url);
        
        $this->template->load(TEMPLATE.'template', TEMPLATE.'event/detail', array('event'=>$event));
    }
    
    
    public function registration($url){
        $this->load->library('form_validation');
        
        $event = $this->event_m->getEventDetailUrl($url);
        
        $form = $this->event_m->getActiveFormEvent($event->event_id);
        
        $form_fields = $this->form_m->getFormFields($form->form_id);
        
       
        foreach ($form_fields as $key => $field) {
            $this->form_validation->set_rules($field->field_name, $field->field_label, createRuleValidation($field));
        }
        
        if($this->form_validation->run()){//ked prejde validacia
            $insert_data = array();
            foreach ($form_fields as $key => $field) {
                $insert_data[$field->col_name] = $this->input->post($field->field_name,TRUE);
            }
            $this->submission_lib->createSubmission($event, $form, $insert_data);
            
            redirect(site_url(createUrlEventDetail($event->url).'/registracia_uspesna'));
        }else{ //neprejde validacia
            
        }
        
        $this->template->load(TEMPLATE.'template', TEMPLATE.'event/registration', 
                array(
                    'event'=>$event,
                    'form' => $form,
                    'fields' => $form_fields,
                    'event_url' => createUrlEventDetail($event->url.'/')
                ));
    }
    
    
    public function newSubmission(){
        $event = $this->event_m->getEventDetailId($url);
        
        $form = $this->event_m->getActiveFormEvent($event->event_id);
        
        $form_fields = $this->form_m->getFormFields($form->form_id);
        $submission_count = $this->input->post('submision_count', TRUE)+1;
        
        preVarDump($this->input->post('submision_count', TRUE));
        
        $new_submission = $this->load->view(TEMPLATE.'event/add_new_submission', 
                array(
                    'event'=>$event,
                    'form' => $form,
                    'fields' => $form_fields,
                    'submission_count' => $submission_count,
                ),TRUE);
        
        echo json_encode(array("new_submission" => $new_submission));
        
    }


    
    public function registracia_uspesna(){
        $this->template->load(TEMPLATE.'template', TEMPLATE.'event/thank_you_page');
    }
    
    
    
    
    
    
    
}
    