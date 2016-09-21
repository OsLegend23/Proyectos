<?php 
session_start();
function randomText($length, $type = 0) {
    switch ($type) {
        case 0:
            $pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            break;
        case 1:
            $pattern = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            break;
        case 2:
            $pattern = "1234567890";
            break;
    }
    $max = strlen($pattern) - 1;
    for ($i = 0; $i < $length; $i++)
        $key .= $pattern {mt_rand(0, $max)} ;
    return $key;
}

$_SESSION['tmptxt'] = randomText(8);
$captcha = imagecreatefromgif("bgcaptcha.gif");
$colText = imagecolorallocate($captcha, 0, 0, 0);
imagestring($captcha, 5, 16, 7, $_SESSION['tmptxt'], $colText);

header("Content-type: image/gif");
imagegif($captcha);
?>
