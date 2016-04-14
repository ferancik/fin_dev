<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Filemanager extends CI_Controller {

    private $idemelent;
    private $dirRoute = ''; //../../../uploads/cmsUploads/
    private $kdezobrazit = 'core';
    private $allowed_upload_file_ext = array();

    public function __construct() {
        parent::__construct();
        $this->load->library('admin/tank_auth_groups', '', 'tank_auth');
        $this->lang->load('tank_auth');
        $this->load->helper('admin/filemanager');
        $this->load->helper('number');

        $this->load->config('admin/filemanager');
        $this->dirRoute = $this->config->item('upload_dir_absolute_path');

        $this->allowed_upload_file_ext = array();
        foreach ($this->config->item('allowed_upload_file_ext') as $type) {
            $this->allowed_upload_file_ext = array_merge($this->allowed_upload_file_ext, $type);
        }
       
    }

    public function index() {

        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {


            if (isset($_GET['elem'])) {
                $this->idemelent = $_GET['elem'];
            }

            if (isset($_GET['type'])) {
                $this->kdezobrazit = $_GET['type'];
            }

            $dir = $this->dirRoute;
            $file = dirname(__FILE__);
            $dir = $file . '/' . $dir;

            $subory = getFiles($dir);

            if ($this->kdezobrazit != 'index') {
                $this->template_admin->load('admin/template', 'admin/filemanager/core', array('subory' => $subory, 'idelem' => $this->idemelent, 'kdezobrazit' => $this->kdezobrazit));
            } else {
                $this->load->view('admin/filemanager/index', array('subory' => $subory, 'idelem' => $this->idemelent, 'kdezobrazit' => $this->kdezobrazit));
            }
        }
    }

    public function del() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {

            if (isset($_POST['elem'])) {
                $this->idemelent = $_POST['elem'];
            }
            if (isset($_POST['type'])) {
                $this->kdezobrazit = $_POST['type'];
            }

            $pathMessage = '';

            if ($_POST['del'] != "") {

                $dir = $this->dirRoute . rawurldecode($_POST['del']);
                $file = dirname(__FILE__);
                $dir = $file . '/' . $dir;
                if (file_exists($dir)) {
                    if (is_dir($dir)) {
                        if (delTree($dir)) {
                            $this->success($pathMessage, 'Priecinok bol odstraneny');
                        } else {
                            $this->success($pathMessage, 'Priecinok bol odstraneny');
                        }
                    } else {

                        $dirTemp = explode('/', rawurldecode($_POST['del']));
                        unset($dirTemp[count($dirTemp) - 1]);
                        $pathMessage = implode('/', $dirTemp);

                        if (unlink($dir)) {

                            $this->success($pathMessage, 'Subor bol odstraneny');
                        } else {
                            $this->error($pathMessage, 'Subor sa nepodarilo odstranit');
                        }
                    }
                } else {
                    $this->error('', 'Target path is not writable');
                }
            }
        }
    }

    public function manage() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            if (isset($_POST['elem'])) {
                $this->idemelent = $_POST['elem'];
            }
            if (isset($_POST['type'])) {
                $this->kdezobrazit = $_POST['type'];
            }

            $dir = $this->dirRoute;
            $file = dirname(__FILE__);
            $dir = $file . '/' . $dir . rawurldecode($_POST['path']);
            $pathMessage = rawurldecode($_POST['path']);
            $path = $dir;

            // ak su neni subory
            if (!isset($_FILES['files']['name'][0])) {
                $this->error($pathMessage, 'No files uploaded');
            }

            // restructure
            $files = array();
            foreach ($_FILES['files']['name'] as $n => $v) {
                $files[$n] = array(
                    'name' => $_FILES['files']['name'][$n],
                    'type' => $_FILES['files']['type'][$n],
                    'tmp_name' => $_FILES['files']['tmp_name'][$n],
                    'error' => $_FILES['files']['error'][$n],
                    'size' => $_FILES['files']['size'][$n]
                );
            }

            // check upload state
            foreach ($files as $f) {
                if ($f['error'] > 0) {
                    $this->error($pathMessage, $f['name'] . ' was not uploaded successfully');
                }
                $pripona = explode('.',$f['name']);
                $pripona = $pripona[count($pripona)-1];
                //echo $pripona;
                if (!in_array($pripona, $this->allowed_upload_file_ext)){
                    $this->error($pathMessage, $f['name'] . ' was not uploaded successfully, EXT not allowed ! ');
                }
                
            }

            // replace spaces in filename
            foreach ($files as $n => $f) {
                $files[$n]['name'] = str_replace(' ', '-', $f['name']);
            }
 
            // check if files already exists
            foreach ($files as $f) {

                if (file_exists($path . $f['name'])) {
                    $this->error($pathMessage, 'File ' . $f['name'] . ' already exists');
                }
            }

            if (!is_writable($path)) {
                $this->error($pathMessage, 'Target path is not writable');
            }

            foreach ($files as $f) {
                if (!move_uploaded_file($f['tmp_name'], $path . $f['name'])) {
                    $this->error($pathMessage, 'file ' . $f['name'] . ' was not moved from tmp to destination');
                }
            }

            // success
            $this->success($pathMessage, count($files) . ' files have been uploaded');
        }
    }

    public function createnewfolder() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {
            if (isset($_POST['elem'])) {
                $this->idemelent = $_POST['elem'];
            }
            if (isset($_POST['type'])) {
                $this->kdezobrazit = $_POST['type'];
            }

            if (isset($_POST['type'])) {
                $this->kdezobrazit = $_POST['type'];
            }

            $dir = $this->dirRoute;
            $file = dirname(__FILE__);
            $dir = $file . '/' . $dir . rawurldecode($_POST['path']);
            $pathMessage = rawurldecode($_POST['path']);

            $path = $dir;

            $target = $path . $_POST['new_priecinok'];

            if (file_exists($target))
                $this->error($pathMessage, 'Target already exists');


            if (!is_writable(pathinfo($target, PATHINFO_DIRNAME)))
                $this->error($pathMessage, 'Target directory not writeable');



            if (mkdir($target)) {
                $this->success($pathMessage, 'Directory created');
            } else {
                $this->error($pathMessage, 'mkdir failed');
            }
        }
    }

    private function success($path, $msg) {
        echo json_encode(array('status' => 'ok', 'msg' => $msg . "<br /> <a href=\"" . createLink($path, array('elem' => $this->idemelent, 'type' => $this->kdezobrazit)) . "\" ><i class=\" icon-refresh \"></i> Refresh file list</a> "));
    }

    private function error($path, $msg, $exit = true) {
        echo json_encode(array('status' => 'fail', 'msg' => $msg . "<br /> <a href=\"" . createLink($path, array('elem' => $this->idemelent, 'type' => $this->kde)) . "\" ><i class=\" icon-refresh \"></i> Refresh file list</a> "));

        if ($exit)
            exit();
    }

    public function zobraz() {
        if (!$this->tank_auth->is_logged_in() && !$this->tank_auth->is_admin()) {
            redirect('admin/auth/login/');
        } else {

            if (isset($_GET['elem'])) {
                $this->idemelent = $_GET['elem'];
            }

            if (isset($_GET['type'])) {
                $this->kdezobrazit = $_GET['type'];
            }


            $priecinky = array();
            $pripojDir = "";
            foreach ($this->uri->segment_array() as $key => $value) {
                if ($key > 4) {
                    $priecinky[] = $value;
                    $pripojDir .= $value . '/';
                }
            }
            // preVarDump($priecinky);
            $dir = $this->dirRoute . rawurldecode($pripojDir);
            $file = dirname(__FILE__);
            $dir = $file . '/' . $dir;

            $subory = getFiles($dir);

            if ($this->kdezobrazit != 'index') {
                $this->template_admin->load('admin/template', 'admin/filemanager/core', array('subory' => $subory, 'priecinky' => $priecinky, 'idelem' => $this->idemelent, 'kdezobrazit' => $this->kdezobrazit));
            } else {
                $this->load->view('admin/filemanager/index', array('subory' => $subory, 'priecinky' => $priecinky, 'idelem' => $this->idemelent, 'kdezobrazit' => $this->kdezobrazit));
            }
        }
    }

}

