<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('FotogaleriaData.php');
require_once('ObrazokData.php');

class Fotogaleria_lib {

    private $CI;

    //private $cestaKuKlasam = 'libraries/admin/modules/fotogaleria/';

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('admin/modules/fotogaleria/fotogaleria_m','',TRUE);
    }

    public function getNastavenia() {
        return $this->CI->fotogaleria_m->nacitajNastavenia();
    }
    public function getGalerie() {
        return $this->CI->fotogaleria_m->nacitajGalerie();
    }

    public function getOneGaleria($id) {
        return $this->CI->fotogaleria_m->nacitajGaleriuID($id);
    }

    public function vlozFotogaleriu($data) {
        return $this->CI->fotogaleria_m->vlozitGaleriu($data);
    }

    public function upravFotogaleriu($data) {
        return $this->CI->fotogaleria_m->upravitGaleriu($data);
    }

    public function getObrazky($idGalerie) {
         $obr = $this->CI->fotogaleria_m->nacitajObrazokIDGalerie($idGalerie);
         if ($obr){
             return $obr;
         }else{
              return 0; 
         }
      
    }

    public function getObrazok($idObrazka) {
        return $this->CI->fotogaleria_m->nacitajObrazokID($idObrazka);
    }
    public function zmazObrazok($idGalerie, $idFoto) {
        $obrData = new ObrazokData();
        $obrData->id = $idFoto;
        $this->CI->fotogaleria_m->odstranitObrazokID($obrData);
    }

    public function zmazatFotogaleriu(FotogaleriaData $data){
        $this->CI->fotogaleria_m->odstranitGaleriu($data);
    }

    public function upravObrazok(ObrazokData $obrazok){
        $this->CI->fotogaleria_m->upravObrazokNazovPopis($obrazok);
    }
    public function getRozlisenie($nazov){
       return $this->CI->fotogaleria_m->nacitajRozlisenie($nazov);
    }
    
    public function upravPoradieObrazkov($idGalerie, $fotot) {

        $fotox = explode(",", $fotot);
        $i = 0;
        foreach ($fotox as $nazov) {
            $id_foto = explode("_", $nazov);
            echo $id_foto[1] . ' - p ' . $i . '<br />';
            $obrData = new ObrazokData();
            $obrData->id = $id_foto[1];
            $obrData->poradie = $i;


            $this->CI->fotogaleria_m->upravitObrazokPoradie($obrData);
            $i++;
        }
    }

    public function nahrajObrazok($idGalerie) {
        $this->CI->load->library('admin/create_thumb');
        //echo $idLady;
        // Settings
          $nastavenia = $this->CI->fotogaleria_m->nacitajNastavenia();
         
        $targetDir = $nastavenia->cesta_k_obrazkom;
        $targetDirTubms = $nastavenia->cesta_k_obrazkom_tumbs;
       
        //$targetDir = 'uploads';

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
        // 5 minutes execution time
        @set_time_limit(5 * 60);

        // Uncomment this one to fake upload time
// usleep(5000);
// Get parameters
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

// Clean the fileName for security reasons
        $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

// Make sure the fileName is unique but only if chunking is disabled
        if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);

            $count = 1;
            while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
                $count++;

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Create target dir
        if (!file_exists($targetDir))
            @mkdir($targetDir);

// Remove old temp files	
        if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
                    @unlink($tmpfilePath);
                }
            }

            closedir($dir);
        }
        else
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Nemôžem otvoriť temp adresár."}, "id" : "id"}');


// Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];

// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                // Open temp file
                $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = fopen($_FILES['file']['tmp_name'], "rb");

                    if ($in) {
                        while ($buff = fread($in, 4096))
                            fwrite($out, $buff);
                    }
                    else
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                    fclose($in);
                    fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                }
                else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }
            else
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        } else {
            // Open temp file
            $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = fopen("php://input", "rb");

                if ($in) {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                }
                else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

                fclose($in);
                fclose($out);
            }
            else
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

// Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off 
            rename("{$filePath}.part", $filePath);

            // zakladny tumbs
            $this->CI->create_thumb->prerobObr($filePath, $targetDirTubms . DIRECTORY_SEPARATOR . $fileName);

            // ostatne rozlisenia
             $rozlisenia = $this->CI->fotogaleria_m->nacitajRozlisenia();
            if ( isset($rozlisenia)){
             foreach ($rozlisenia as $rozlisenie){
                $this->CI->create_thumb->prerobObr($filePath, $targetDirTubms . DIRECTORY_SEPARATOR . vytvorNazovFotkyRozlisenie($rozlisenie->sirka, $rozlisenie->vyska, $fileName),$rozlisenie->vyska,$rozlisenie->sirka,true); 
             }
            }
            $obrData = new ObrazokData();
            $obrData->adresa = $fileName;
            $obrData->id_admin_mod_fotogaleria_data = $idGalerie;
            $obrData->nazov = "";
            $obrData->popis = "";

            $this->CI->fotogaleria_m->pridatObrazok($obrData);
              
        }

        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

}

