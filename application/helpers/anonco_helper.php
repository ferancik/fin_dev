<?php

function createUrlEventDetail($event_url) {
    return site_url("event/detail/" . $event_url);
}

function createEventForm($event_url) {
    return site_url("event/registracia/" . $event_url);
}

function createRuleValidation($field) {
    $output = "";

    if ($field->validation->required == 1) {
        $output .= "required|";
    }

    if ($field->validation->min_length > 0) {
        $output .= "min_length[" . $field->validation->min_length . "]|";
    }

    if ($field->field_size > 0) {
        $output .= "max_length[" . $field->field_size . "]|";
    }

    if ($field->is_email == 1) {
        $output .= "valid_email|";
    }

    return substr($output, 0, -1);
}

function createteHash($string) {
    return md5($string . microtime());
}

function createOption($projects) {
    
    foreach ($projects as $key => $root) {

        $output .= '<option value="' . $root['projekt_id'] . '">' . $root['cislo']. ' '. $root['name'] . '</option>';
        if (count($root['children']) > 0) {
            foreach ($root['children'] as $key => $root2) {
                $output .= '<option value="' . $root2['projekt_id'] . '">--' . $root2['cislo']. ' '. $root2['name'] . '</option>';
            }
        }
    }
    return $output;
}
