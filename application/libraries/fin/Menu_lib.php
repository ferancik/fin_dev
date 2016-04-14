<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu_lib
 *
 * @author frantisekferancik
 */
class Menu_lib {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();

        $this->CI->load->model("fin/firma_m");
    }

    public function createMenu() {
        $firmy = $firmy = $this->CI->firma_m->getFirmy();
        foreach ($firmy as $key => $firma) {
            $menu[] = array(
                'title' => $firma->nazov,
                'url' => site_url('transaction/index/' . $firma->firma_id),
                'controler' => site_url('detail/all/' . $obj['web_group_id']),
            );
        }
        
        return $menu;
    }

}
