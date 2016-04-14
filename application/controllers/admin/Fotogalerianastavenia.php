<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fotogalerianastavenia extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin/modules/fotogaleria/fotogaleria_m');
        $this->load->library('form_validation');
    }

    public function index() {
        $data = $this->fotogaleria_m->nacitajRozlisenia();
        $this->template_admin->load('admin/template', 'admin/modules/fotogaleria/rozlisenia/index', array('data' => $data));
    }

    public function rozlisenie($id) {
        $texty = array();
        $data = $this->fotogaleria_m->nacitajRozlisenieID($id);

        if (!$data) {
            $texty['nazov'] = 'Pridať nové rozlíšenie';
        } else {
            $texty['nazov'] = 'Upraviť rozlíšenie';
        }
        $this->form_validation->set_rules('nazov', 'Nazov', 'trim|required|max_length[200]|xss_clean');
        $this->form_validation->set_rules('sirka', 'Sirka', 'trim|required|max_length[15]|xss_clean');
        $this->form_validation->set_rules('vyska', 'Vyska', 'trim|required|max_length[15]|xss_clean');


        if ($this->form_validation->run()) {
            $temp = new stdClass();
            $temp->nazov = $this->form_validation->set_value('nazov');
            $temp->sirka = $this->form_validation->set_value('sirka');
            $temp->vyska = $this->form_validation->set_value('vyska');

            if (!$data) {
                $ok = $this->fotogaleria_m->insertRozlisenie($temp);
            } else {
                $temp->id = $data->id;
                $ok = $this->fotogaleria_m->editRozlisenie($temp);
            }

            if (!$data) {
                $this->session->set_flashdata('sprava', "save|Nové rozlíšenie bolo pridané");
            } else {

                $this->session->set_flashdata('sprava', "save|Rozlíšenie bolo uložené");
            }
            redirect('admin/fotogalerianastavenia');
        }

        $this->template_admin->load('admin/template', 'admin/modules/fotogaleria/rozlisenia/uprava', array('data' => $data, 'text' => $texty));
    }

    public function zmazat($id) {
        $data = $this->fotogaleria_m->nacitajRozlisenieID($id);
        if (!$data) {
            $this->session->set_flashdata('sprava', "error|Vybrané rozlíšenie neexistuje");
            redirect('admin/fotogalerianastavenia/');
        } else {
            $this->fotogaleria_m->delRozlisenie($data->id);
            $this->session->set_flashdata('sprava', "info|Rozlíšenie bolo odstránené");
            redirect('admin/fotogalerianastavenia/');
        }
    }

}

?>
