<?php

if (!isset($sprava)) {
    $sprava = $this->session->flashdata('sprava');
}
if (isset($sprava) && $sprava) {
    $roz = explode("|", $sprava);
    switch ($roz[0]) {
        case "error":
            echo '<div class="alert alert-error">' .
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' .
            ' <h4>Chyba</h4>' .
            $roz[1] .
            '</div>';
            break;
        case "info":

            echo '<div class="alert alert-info">' .
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' .
            ' <h4>Informácia</h4>' .
            $roz[1] .
            '</div>';
            break;
        case "ok":
            echo '<div class="alert alert-success">' .
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' .
            ' <h4>OK</h4>' .
            $roz[1] .
            '</div>';
            break;
        case "save":
            echo '<div class="alert alert-success">' .
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' .
            ' <h4>Uložené</h4>' .
            $roz[1] .
            '</div>';
            break;
        case "warning":
            echo '<div class="alert alert-block">' .
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' .
            ' <h4>Upozornenie</h4>' .
            $roz[1] .
            '</div>';
            break;
    }
}

echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><h4>Chyba</h4>', '</div>');
?>