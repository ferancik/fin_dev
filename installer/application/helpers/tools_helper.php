<?php

function GD_ok() {

    if (function_exists('gd_info')) {
        $gd_info = gd_info();
        $gd_version = preg_replace('/[^0-9\.]/', '', $gd_info['GD Version']);


        return ($gd_version >= 1);
    }


    return false;
}