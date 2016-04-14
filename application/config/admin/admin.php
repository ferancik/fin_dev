<?php

// install on 11.06.2013, 17:19
// http://www.site.com/ = 0,  http://www.site.com/site = 1, http://www.site.com/dir/site = 2
$config['PATH_STEP'] = 0;
$config['PROFILER_ENABLE'] = false;  
$config['encryption_key'] = 'YoBxpDPrHBTKdFRePrn4cwVYnGGtba6JfHE';

$config['PATH_SLIDER_FOLDER'] = 'D:/www_server/kfcms/uploads/images/slider/img/';
$config['PATH_PARTNER_FOLDER'] = 'D:/www_server/kfcms/uploads/images/partner/';
$config['PATH_NAVBLKY_FOLDER'] = 'D:/www_server/kfcms/uploads/images/navbloky/';
$config['PATH_DOKUMENTY_FOLDER'] = 'D:/www_server/kfcms/uploads/dokumenty/';


$config['CONTROLER_PRE_OBSLUHU_UZIVATELSKYCH_STRANOK'] = 'page/index/';

$config['ADMIN_FOOTER'] = '<hr>
    <footer>
        <p>KF CMS System 2013. | Verzia 1.0 |
        Page rendered in <strong>{elapsed_time}</strong> seconds </p>	
    </footer>';


$config['STRANKY_NA_KTORYCH_NEZOBRAZIT_BREADCRUMB'] = array('pages/browser-filemanager','auth/change_password', 'dashboard','auth/change_email','notauthorized','filemanager');
$config['STRANKY_VYRADENE_Z_OPRAVNENI'] = array('auth/logout','auth/login','auth','', 'auth/change_password', 'dashboard', 'auth/change_email', 'notauthorized');

$config['admin_language_array'] = array(
        'cs' => 'czech',
        'da' => 'danish',
        'nl' => 'dutch',
        'en' => 'english',
        'fi' => 'finnish',
        'fr' => 'french',
        'de' => 'german',
        'el' => 'greek',
        'hu' => 'hungarian',
        'zh' => 'chinese_simplified',
        'id' => 'indonesian',
        'it' => 'italian',
        'pl' => 'polish',
        'pt' => 'portuguese',
        'ru' => 'russian',
        'sk' => 'slovak',
        'sl' => 'slovenian',
        'es' => 'spanish',
        'sv' => 'swedish',
    );

