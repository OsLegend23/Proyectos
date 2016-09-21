<?php

session_start();

$string = '';

for ($i = 0; $i < 3; $i++) {
    $string .= chr(rand(97, 122));
}

$_SESSION['captchahikingmexico'] = $string;

$dir   = 'fonts/';
$image = imagecreatetruecolor(175, 45);
$num   = rand(1, 2);// random number 1 or 2
$font  = "WalkwayBlackRevOblique.ttf"; // font style
$color = imagecolorallocate($image, 51, 51, 51); // color
$white = imagecolorallocate($image, 166, 174, 166); // background color white

imagefilledrectangle($image, 0, 0, 399, 99, $white);
imagettftext($image, 25, 0, 35, 30, $color, $dir . $font, $_SESSION['captchahikingmexico']);

header("Content-type: image/png");
imagepng($image);
?>