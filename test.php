<?php 

    //Set the Content Type
    header('Content-type: image/png');

    // Create Image From Existing File
    $jpg_image = imagecreatefrompng('uploads/300.png');

    // Allocate A Color For The Text
    $white = imagecolorallocate($jpg_image, 0, 0, 0);

    // Set Path to Font File
    $font_path = 'uploads/fonts/AmalteaTwo.ttf';

    // Set Text to Be Printed On Image
    $text = "іі ІІ АБВ ГДЄ Мой МОЗГ";

    // Print Text On Image
    imagettftext($jpg_image, 20, 0, 10, 100, $white, $font_path, $text);

    // Send Image to Browser
    imagepng($jpg_image);

    // Clear Memory
    imagedestroy($jpg_image);