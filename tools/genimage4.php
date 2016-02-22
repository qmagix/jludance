<?php
	session_start();	
    header("Content-type: image/jpeg");
    $im     = imagecreatefromjpeg("../images/blues.jpg");
	$orange = imagecolorclosest($im, 220, 210, 60);
    $px     = (imagesx($im) - 7.5 * strlen($_SESSION["secret_post_code"])) / 2;
    ImageString($im, 5, $px-1, 5, $_SESSION["secret_post_code"], $orange);
    ImageJpeg($im);
    imagedestroy($im);
?> 
