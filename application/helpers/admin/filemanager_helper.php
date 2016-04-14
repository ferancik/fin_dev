<?php

function getFiles($path) {
    $handle = opendir($path) or die("Unable to open $path");
    $file_array = array();
    while ($file = readdir($handle)) {
        if ($file != '.' && $file != '..') {
            $fileT = new stdClass();
            $fileT->name = rawurlencode($file);
            $fileT->size = filesize($path . $file);
            $fileT->date = filemtime($path . $file);
            $fileT->dir = is_dir($path . $file);
            if ($fileT->dir) {
                $fileT->coutFiles = 0;
                $handle2 = opendir($path . $file);
                while ($file2 = readdir($handle2)) {
                    $fileT->coutFiles++;
                }
                closedir($handle2);
               
                 $fileT->coutFiles = $fileT->coutFiles-2;
            } else {
                $fileT->coutFiles = 0;
            }
            $fileT->image = getimagesize($path . $file);
            $file_array[] = $fileT;
        }
    }
    closedir($handle);
    return $file_array;
}

function delTree($dir) {
    $files = glob($dir . '*', GLOB_MARK);


    foreach ($files as $file) {
        if (substr($file, -1) == '/')
            delTree($file);
        else
            unlink($file);
    }
    return rmdir($dir);
}

function createLink($path,$data){
    
    return site_url('admin/filemanager/zobraz').'/'.$path.'?'.http_build_query($data, '', "&");
}



?>
