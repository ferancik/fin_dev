<?php

function preVarDump($co) {
    echo "<pre>";
    var_dump($co);
    echo "</pre>";
}

function formatCasu($cas) {
    $CI = & get_instance();
    $format = $CI->config->itemDB('date_format');

    $timestamp = 0;
    if (is_numeric($cas)) {
        $timestamp = $cas;
    } else {
        $timestamp = strtotime($cas);
    }
    $datetime = new DateTime();
    $la_time = new DateTimeZone($CI->config->itemDB('time_zone'));
    $datetime->setTimezone($la_time);
    $datetime->setTimestamp($timestamp);

    return $datetime->format($format);
}

function adminLoadClass($nazov, $cesta) {
    return load_class($nazov, $cesta, '');
}

function vytvorNazovFotkyRozlisenie($sirka, $vyska, $nazov) {
    return $sirka . 'x' . $vyska . '-' . $nazov;
}

if (!function_exists('in_arrayi')) {

    function in_arrayi($needle, $haystack) {
        return in_array(lowercase($needle), array_map('lowercase', $haystack));
    }

}

function getMenuIcon($menu, $white = false) {
    if ($menu->icon != "") {
        $icon = '<i class="' . $menu->icon . ' ' . (($white) ? 'icon-white' : '') . '"></i> ';
    } else {
        $icon = '';
    }
    return $icon;
}

function getActiveWebMenu() {
    $CI = & get_instance();
    $CI->load->library('admin/web_menu');
    
    $segs = $CI->uri->segment_array();
    $urlTepl = "";
    $i = 0;
    foreach ($segs as $segment) {
        if ($i != 0) {
            $urlTepl .= $segment . "/";
        }
        $i++;
    }
    $menuKdeSom = $CI->web_menu->getOneMenuKontroler(substr($urlTepl, 0, -1));

    return $menuKdeSom;
}

?>
