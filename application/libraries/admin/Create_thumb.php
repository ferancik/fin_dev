<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
set_time_limit(0);

class create_thumb {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    function prerobObr($file, $nazov, $crop_height = false, $crop_width = false, $crop = false) {
        $file_name = $file;
        if (!$crop_height && !$crop_width) {
            $crop_height = 140;
            $crop_width = 140;
        }

        if ($crop){
            $this->cropImage($file, $nazov, $crop_height, $crop_width);
        }else{

        $original_image_size = getimagesize($file_name);
        $original_width = $original_image_size[0];
        $original_height = $original_image_size[1];

        $file_type = $original_image_size[2];

        if ($file_type == IMAGETYPE_JPEG) {
            $original_image_gd = imagecreatefromjpeg($file_name);
        }

        if ($file_type == IMAGETYPE_GIF) {
            $original_image_gd = imagecreatefromgif($file_name);
        }

        if ($file_type == IMAGETYPE_PNG) {
            $original_image_gd = imagecreatefrompng($file_name);
        }

        $cropped_image_gd = imagecreatetruecolor($crop_width, $crop_height);
        $wm = $original_width / $crop_width;
        $hm = $original_height / $crop_height;
        $h_height = $crop_height / 2;
        $w_height = $crop_width / 2;

        if ($original_width > $original_height) {
            $adjusted_width = $original_width / $hm;
            $half_width = $adjusted_width / 2;
            $int_width = $half_width - $w_height;

            imagecopyresampled($cropped_image_gd, $original_image_gd, -$int_width, 0, 0, 0, $adjusted_width, $crop_height, $original_width, $original_height);
            unset($original_image_gd);
        } elseif (($original_width < $original_height ) || ($original_width == $original_height )) {
            $adjusted_height = $original_height / $wm;
            $half_height = $adjusted_height / 2;
            $int_height = $half_height - $h_height;

            imagecopyresampled($cropped_image_gd, $original_image_gd, 0, -$int_height, 0, 0, $crop_width, $adjusted_height, $original_width, $original_height);
            unset($original_image_gd);
        } else {

            imagecopyresampled($cropped_image_gd, $original_image_gd, 0, 0, 0, 0, $crop_width, $crop_height, $original_width, $original_height);
            unset($original_image_gd);
        }
        imagejpeg($cropped_image_gd, $nazov, 98);
        }
    }

    public function vypocitajVysku($image) {
        $original_image_size = getimagesize($image);
        $original_width = $original_image_size[0];
        $original_height = $original_image_size[1];

        $percent = round(IMAGE_WIDTH / $original_width * 100);
        return round($original_height * $percent / 100);
    }

    private function cropImage($file, $nazov, $crop_height, $crop_width) {

        $original_image_size = getimagesize($file);


        $file_type = $original_image_size[2];

        if ($file_type == IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($file);
        }

        if ($file_type == IMAGETYPE_GIF) {
            $image = imagecreatefromgif($file);
        }

        if ($file_type == IMAGETYPE_PNG) {
            $image = imagecreatefrompng($file);
        }

        $thumb_width = $crop_width;
        $thumb_height = $crop_height;

        $width = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ($original_aspect >= $thumb_aspect) {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        } else {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);

// Resize and crop
        imagecopyresampled($thumb, $image, 0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                0, 0, $new_width, $new_height, $width, $height);
        imagejpeg($thumb, $nazov, 95);
    }

}

