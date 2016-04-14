<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Spravajazykovadmin extends CI_Controller {

    public $relativeLanduageDir = '../../language/admin/';

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->model('admin/admin_language_m', '', TRUE);
    }

    public function index() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $files = array();
            $dir = $this->relativeLanduageDir;
            $file = dirname(__FILE__);
            $dir = $file . '/' . $dir;


            $dir_handle = @opendir($dir);
            if ($dir_handle) {
                while ($filename = readdir($dir_handle)) {
                    if (is_dir($dir . $filename) && $filename != '.' && $filename != '..') {
                        $files[] = $filename;
                    }
//                    if (!is_dir($dir . $filename) && preg_match('/^(.*)\.php$/', $filename)){
//                        $files[] = $dir . $filename;
//                    }
                }
                closedir($dir_handle);
            }
            //preVarDump($files);
            // nahram jednotlive subory
            $subory = array();
            $dirold = $dir;
            foreach ($files as $value) {

                $subory[$value] = array();
                $dir = $dirold . '' . $value . '';
                $dir_handle = @opendir($dir);
                if ($dir_handle) {
                    while ($filename = readdir($dir_handle)) {

                        if (!is_dir($dir . $filename) && preg_match('/^(.*)\.php$/', $filename)) {
                            $subory[$value][] = $filename;
                        }
                    }
                    closedir($dir_handle);
                }
            }
//            $files
            $files = null;
            $files = $this->admin_language_m->getActiveLanguage();
            //preVarDump($subory);
            $dblanguage = $this->admin_language_m->getAllLanguage();
            $this->template_admin->load('admin/template', 'admin/spravajazykovadmin/index', array('alljazyky' => $files, 'dblanguage' => $dblanguage, 'subory' => $subory));
        }
    }

    public function deactive($idJazyk) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $jazyk = $this->admin_language_m->getOneLanguage($idJazyk);
            if ($jazyk->dir != 'english') {
                $jazyk->active = 0;
                $this->admin_language_m->updateLanguage($jazyk->id, $jazyk);
                $this->session->set_flashdata('sprava', "info|Jazyk bol deaktivavany");
                redirect('admin/spravajazykovadmin');
            } else {
                $this->session->set_flashdata('sprava', "error|Tento jazyk nemozno deaktivovat");
                redirect('admin/spravajazykovadmin');
            }
        }
    }

    public function active($idJazyk) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $jazyk = $this->admin_language_m->getOneLanguage($idJazyk);
            if ($jazyk->dir != 'english') {
                $jazyk->active = 1;
                $this->admin_language_m->updateLanguage($jazyk->id, $jazyk);
                $this->repairDatabaseLanguage($idJazyk);
                $this->session->set_flashdata('sprava', "info|Jazyk bol aktivavany");
                redirect('admin/spravajazykovadmin');
            } else {
                $this->session->set_flashdata('sprava', "error|Tento jazyk nemozno aktivovat");
                redirect('admin/spravajazykovadmin');
            }
        }
    }

    private function repairDatabaseLanguage($idLanguage) {
        // checkt admin_mod_pages_langs 
        $this->load->model('admin/repairdatabaselanguage_m');
        $this->load->config('admin/checklanguage');
        $this->repairdatabaselanguage_m->setIdlanguage($idLanguage);
        $this->repairdatabaselanguage_m->check_language('admin_menu_langs', 'id_admin_language');
        
    }

    public function recreate($idJazyk, $root = false) {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            $jazyk = $this->admin_language_m->getOneLanguage($idJazyk);
            if ($jazyk->dir != 'english') {

                $dir_o = $this->relativeLanduageDir;
                $file = dirname(__FILE__);
                $dir = $file . '/' . $dir_o . $jazyk->dir;
                $enDir = $file . '/' . $dir_o . 'english/';

                $dir_handle = @opendir($dir);
                if ($dir_handle) { // ak mam priecinok tak uz len aktualizujem
                    //nahlam subory ktore chybaju ak chybaju tak skontrolujem
                    $dir_handle_en = opendir($enDir);
                    if ($dir_handle_en) {
                        while ($filename = readdir($dir_handle_en)) {
                            if (!is_dir($enDir . $filename) && preg_match('/^(.*)\.php$/', $filename)) {
                                if (!file_exists($dir . '/' . $filename)) {
                                    copy($enDir . $filename, $dir . '/' . $filename);
                                }
                            }
                        }
                        closedir($dir_handle_en);
                    }

                    //skontorlujem na urovny jazyku ze ci nahodov nechyba nejaky preklad, ak chyba tak dopnim
                    $dir_handle_en = opendir($enDir);
                    if ($dir_handle_en) {
                        while ($filename = readdir($dir_handle_en)) {
                            if (!is_dir($enDir . $filename) && preg_match('/^(.*)\.php$/', $filename)) {
                                $lang = array();
                                // english
                                include $enDir . $filename;
                                $lang_en = $lang;

                                //upravovany
                                $lang = array();
                                include $dir . '/' . $filename;
                                $lang_new = $lang;
                                //preVarDump($lang_new);
                                $lang = null;

                                $totoPridam = array();
                                foreach ($lang_en as $key => $value) {
                                    if (!key_exists($key, $lang_new)) {
                                        // echo $key. ' -> '.$value . '<br />';
                                        $totoPridam[$key] = $value;
                                    }
                                }
                                //preVarDump($totoPridam);
                                $totoPridamT = array_merge($totoPridam, $lang_new);

                                $this->saveLanguage($totoPridamT, $jazyk->dir, substr($filename, 0, -4));
                            }
                        }
                        closedir($dir_handle_en);
                    }

                    if (!$root) {
                        $this->session->set_flashdata('sprava', "info|Jazyk bol aktualizovany, chybajuce casti boli dopnene z Englis jazyka.");
                        redirect('admin/spravajazykovadmin');
                    }
                } else { // ak nemam vsetko vytvorim na novo
                    mkdir($dir);
                    $dir_handle_en = opendir($enDir);
                    if ($dir_handle_en) {

                        while ($filename = readdir($dir_handle_en)) {

                            if (!is_dir($enDir . $filename) && preg_match('/^(.*)\.php$/', $filename)) {
                                copy($enDir . $filename, $dir . '/' . $filename);
                            }
                        }
                        closedir($dir_handle_en);
                    }
                    if (!$root) {
                        $this->session->set_flashdata('sprava', "info|Jazyk bol vytvoreny nanovo.");
                        redirect('admin/spravajazykovadmin');
                    }
                }

                // $this->session->set_flashdata('sprava', "info|Jazyk bol znova vytvoreny a boli pridane chybajuce casti");
                //redirect('admin/spravajazykovadmin');
            } else {
                if (!$root) {
                    $this->session->set_flashdata('sprava', "error|Tento jazyk nemozno revytvorit");
                    redirect('admin/spravajazykovadmin');
                }
            }
        }
    }

    public function uprava() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {

            $tempGet = explode('/', $_GET['jazyk']);
            $jazyk = $tempGet[0];
            $subor = $tempGet[1];

            // ak nic neni teak refresnem jazyk
            if (!$_POST) {
                if ($jazyk != 'english') {
                    $tempData = $this->admin_language_m->getOneLanguageDir($jazyk);
                    $this->recreate($tempData->id, true);
                }
            }


            $dir = $this->relativeLanduageDir;
            $file = dirname(__FILE__);
            $dir = $file . '/' . $dir;

            // ak je novy hodnota tak ju vlozim do anglickeho 

            if ($_POST['jazyk'] != '' && $_POST['nova_polozka'] != '' && $_POST['subor'] != '' && $_POST['nova_polozka_text'] != '') {

                $subor = substr($_POST['subor'], 0, -4);
                $lang = array();
                include($dir . 'english' . '/' . $subor . '.php');
                $langen = $lang;

                $langen[$_POST['nova_polozka']] = $_POST['nova_polozka_text'];
                if ($this->saveLanguage($langen, 'english', $subor)) {

                    $this->session->set_flashdata('sprava', "ok|Nova hodnota bola pridana");
                } else {
                    $this->session->set_flashdata('sprava', "error|Nova hodnota nebola pridana");
                }

                redirect(site_url('admin/spravajazykovadmin/uprava/') . '/?jazyk=' . $jazyk . '/' . $subor);
            }

            $lang = array();
            include($dir . $jazyk . '/' . $subor . '.php');
            $lang_edit = $lang;

            $lang = array();
            include($dir . 'english' . '/' . $subor . '.php');
            $langen = $lang;


            if (isset($_POST['ulozit']) && $_POST['ulozit'] == 'true') {


                foreach ($lang_edit as $key => $text) {
                    if (isset($_POST['text_' . $key]) && $_POST['text_' . $key])
                        $targettexts[$key] = $_POST['text_' . $key];
                }

                if ($this->saveLanguage($targettexts, $jazyk, $subor)) {
                    $this->session->set_flashdata('sprava', "info|Preklad Bol ulozeny");
                    redirect('admin/spravajazykovadmin');
                } else {
                    $this->session->set_flashdata('sprava', "error|Nastala chyba pri ukladani");
                    redirect(site_url('admin/spravajazykovadmin/uprava/') . '/?jazyk=' . $jazyk . '/' . $subor);
                }
            }


            //preVarDump($lang);

            $this->template_admin->load('admin/template', 'admin/spravajazykovadmin/uprava', array('jazyk' => $jazyk, 'subor' => $subor . '.php', 'lang' => $lang_edit, 'langen' => $langen));
        }
    }

    public function pridaj() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {

            //$this->template_admin->load('admin/template', 'admin/spravajazykovadmin/pridaj', array());
        }
    }

    private function saveLanguage($texts, $jazyk, $subor) {
        $dir = $this->relativeLanduageDir;
        $file = dirname(__FILE__);
        $dir = $file . '/' . $dir;

        $file = $dir . $jazyk . '/' . $subor . '.php';
        if (file_exists($file)) {
            if (!copy($file, $file . '.bak')) {
                return false;
            }
        }

        $f = fopen($file, "w");

        if (!$f) {
            return false;
        }

        if (!fputs($f, "<?php\n//last edit: " . date("d.m.Y, H:m", time()) . "\n\n")) {
            return false;
        }


        $mq = get_magic_quotes_gpc() || get_magic_quotes_runtime();
        foreach ($texts as $key => $text) {
            $k = str_replace("'", "\'", $mq ? stripslashes($key) : $key);
            // $t = str_replace('"', '\"', $mq ? stripslashes($text) : $text);
            $t = str_replace("'", "\'", $mq ? stripslashes($text) : $text);
            fputs($f, "    \$lang['" . $k . "'] = '$t';\n");
        }
        fputs($f, "\n");
        fclose($f);
        return true;
    }

}
