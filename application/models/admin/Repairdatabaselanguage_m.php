<?php

class Repairdatabaselanguage_m extends CI_Model {

    private $idLanguage;
    private $defaultLanguage;

    function __construct() {
        parent::__construct();
        $this->load->model('admin/admin_web_language_m');
        $this->defaultLanguage = $this->admin_web_language_m->getDefaultLanguage();
    }

    public function setIdlanguage($idLanguage) {
        $this->idLanguage = $idLanguage;
    }

    public function check_language($tableName, $languageColomName) {
        
        if (!$this->checkLanguageExist($tableName, $languageColomName)) {
            $data = $this->getDefaultLanguageData($tableName, $languageColomName);
            $this->addDefaulLanguageData($data,$tableName ,$languageColomName);
        }
    }

    private function addDefaulLanguageData($data, $tableName,$languageColomName) {
        foreach ($data as $value) {
            $value->id = "null";
            $value->$languageColomName = $this->idLanguage;
            $this->db->insert($tableName, $value);
           // preVarDump($value);
        }
    }

    private function getDefaultLanguageData($tableName, $languageColomName) {
        echo $this->defaultLanguage->id;
        $query = $this->db->select('*')
                ->from($tableName)
                ->where($languageColomName, $this->defaultLanguage->id)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    private function checkLanguageExist($tableName, $languageColomName) {
        $query = $this->db->select('*')
                ->from($tableName)
                ->where($languageColomName, $this->idLanguage)
                ->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

}

?>
