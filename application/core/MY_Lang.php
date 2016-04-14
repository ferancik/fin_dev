<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

// Originaly CodeIgniter i18n library by Jérôme Jaglale
// http://maestric.com/en/doc/php/codeigniter_i18n
// modification by Yeb Reitsma

/*
  in case you use it with the HMVC modular extension
  uncomment this and remove the other lines
  load the MX_Loader class */

//require APPPATH."third_party/MX/Lang.php";
//class MY_Lang extends MX_Lang {

class MY_Lang extends CI_Lang {
    /*     * ************************************************
      configuration
     * ************************************************* */

    // languages
    private $languages = array(
//        'cs' => 'web/czech',
//        'da' => 'web/danish',
//        'nl' => 'web/dutch',
        'en' => 'web/english',
//        'fi' => 'web/finnish',
//        'fr' => 'web/french',
//        'de' => 'web/german',
//        'el' => 'web/greek',
//        'hu' => 'web/hungarian',
//        'zh' => 'web/chinese_simplified',
//        'id' => 'web/indonesian',
//        'it' => 'web/italian',
//        'pl' => 'web/polish',
//        'pt' => 'web/portuguese',
//        'ru' => 'web/russian',
        'sk' => 'web/slovak',
//        'sl' => 'web/slovenian',
//        'es' => 'web/spanish',
//        'sv' => 'web/swedish',
//        'czech' => 'admin/czech',
//        'danish' => 'admin/danish',
//        'dutch' => 'admin/dutch',
        'english' => 'admin/english',
//        'finnish' => 'admin/finnish',
//        'french' => 'admin/french',
//        'german' => 'admin/german',
//        'greek' => 'admin/greek',
//        'hungarian' => 'admin/hungarian',
//        'chinese_simplified' => 'admin/chinese_simplified',
//        'indonesian' => 'admin/indonesian',
//        'italian' => 'admin/italian',
//        'polish' => 'admin/polish',
//        'portuguese' => 'admin/portuguese',
//        'russian' => 'admin/russian',
        'slovak' => 'admin/slovak',
//        'slovenian' => 'admin/slovenian',
//        'spanish' => 'admin/spanish',
//        'swedish' => 'admin/swedish',
    );
    private $prekladanieJazykaPreAdmin = array(
//        'cs' => 'czech',
//        'da' => 'danish',
//        'nl' => 'dutch',
        'en' => 'english',
//        'fi' => 'finnish',
//        'fr' => 'french',
//        'de' => 'german',
//        'el' => 'greek',
//        'hu' => 'hungarian',
//        'zh' => 'chinese_simplified',
//        'id' => 'indonesian',
//        'it' => 'italian',
//        'pl' => 'polish',
//        'pt' => 'portuguese',
//        'ru' => 'russian',
        'sk' => 'slovak',
//        'sl' => 'slovenian',
//        'es' => 'spanish',
//        'sv' => 'swedish',
    );
    // special URIs (not localized)
    private $special = array(
        ""
    );
    // where to redirect if no language in URI
    private $uri;
    private $default_uri;
    private $lang_code;
    private $isAdmin;

    /*     * *********************************************** */

    public function __construct() {

        parent::__construct();

        global $CFG;
        global $URI;
        global $RTR;

        $this->uri = $URI->uri_string();



        $urlT = explode('/', $this->uri);
        $this->isAdmin = false;
        foreach ($urlT as $urlRow) {
            if ($urlRow == 'admin') {
                $this->isAdmin = true;
            }
        }



        $this->default_uri = $RTR->default_controller;

        $uri_segment = $this->get_uri_lang($this->uri);
        $this->lang_code = $uri_segment['lang'];

        $url_ok = false;
        if ((!empty($this->lang_code)) && (array_key_exists($this->lang_code, $this->languages))) {
            $language = $this->languages[$this->lang_code];
            $CFG->set_item('language', $language);
            $url_ok = true;
        }

        if ((!$url_ok) && (!$this->is_special($uri_segment['parts'][0]))) { // special URI -> no redirect
            // set default language
            $CFG->set_item('language', $this->languages[$this->default_lang()]);

            $uri = (!empty($this->uri)) ? $this->uri : $this->default_uri;
            $uri = ($uri[0] != '/') ? '/' . $uri : $uri;
            $new_url = $CFG->config['base_url'] . $this->default_lang() . $uri;
            
            header("Location: " . $new_url, TRUE, 302);
            exit;
        }
    }

    // get current language
    // ex: return 'en' if language in CI config is 'english' 
    function lang() {
        global $CFG;
        $language = $CFG->item('language');

        $lang = array_search($language, $this->languages);
        if ($lang) {
            return $lang;
        }

        return NULL;    // this should not happen
    }

    function is_special($lang_code) {
        if ((!empty($lang_code)) && (in_array($lang_code, $this->special)))
            return TRUE;
        else
            return FALSE;
    }

    function switch_uri($lang) {
        if ((!empty($this->uri)) && (array_key_exists($lang, $this->languages))) {

            if ($uri_segment = $this->get_uri_lang($this->uri)) {
                $uri_segment['parts'][0] = $lang;
                $uri = implode('/', $uri_segment['parts']);
            } else {
                $uri = $lang . '/' . $this->uri;
            }
        }

        return $uri;
    }

    //check if the language exists
    //when true returns an array with lang abbreviation + rest
    function get_uri_lang($uri = '') {
        if (!empty($uri)) {
            $uri = ($uri[0] == '/') ? substr($uri, 1) : $uri;

            $uri_expl = explode('/', $uri, 2);
            $uri_segment['lang'] = NULL;
            $uri_segment['parts'] = $uri_expl;

            if (array_key_exists($uri_expl[0], $this->languages)) {
                $uri_segment['lang'] = $uri_expl[0];
            }
            return $uri_segment;
        } else
            return FALSE;
    }

    // default language: first element of $this->languages
    function default_lang() {
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
        $browser_lang = substr($browser_lang, 0, 2);


        $jazyk_tem = (array_key_exists($browser_lang, $this->prekladanieJazykaPreAdmin)) ? $this->prekladanieJazykaPreAdmin[$browser_lang] : 'english';

        if (!$this->isAdmin) {
            $jazyk_tem = (array_key_exists($browser_lang, $this->languages)) ? $browser_lang : 'en';
        }

        return $jazyk_tem;
    }

    // add language segment to $uri (if appropriate)
    function localized($uri) {
        if (!empty($uri)) {
            $uri_segment = $this->get_uri_lang($uri);
            if (!$uri_segment['lang']) {

                if ((!$this->is_special($uri_segment['parts'][0])) && (!preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri))) {
                    $uri = $this->lang() . '/' . $uri;
                }
            }
        }
        return $uri;
    }

    function line($line = '') {
        $value = ($line == '' OR ! isset($this->language[$line])) ? FALSE : $this->language[$line];

        // Because killer robots like unicorns!
        if ($value === FALSE) {
            log_message('error', 'Could not find the language line "' . $line . '"');
            $value = $line;
        }

        return $value;
    }

}

// END MY_Lang Class

/* End of file MY_Lang.php */
/* Location: ./application/core/MY_Lang.php */