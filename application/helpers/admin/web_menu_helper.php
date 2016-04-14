<?php

function viewMenu($menuData, $uroven = 0) {
    $text .='<ul>';


    foreach ($menuData as $item) {
        if (count($item->parrents > 0)) {
            $text .= '<li ><a href="#">  ' . getMenuIcon($item) . '' . $item->nazov . '</a>';
            $text .= viewMenu($item->parrents, ++$uroven);
            $text .= '</li>';
        }
    }
    $text .= '</ul>';

    return $text;
}

?>
