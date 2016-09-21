<?php 
require 'CaptchasDotNet.php';

// See query.php for documentation

$captchas = new CaptchasDotNet('SYREC', 'H7tG84ZGymYo0TCXOMbT4qW6Oxiu6boIr372Ae9g');

// Read the form values
$message = $_REQUEST['message'];
$password = $_REQUEST['password'];
$random_string = $_REQUEST['random'];
?>
<html>
    <head>
        <title>Sample PHP CAPTCHA Query</title>
    </head>
    <h1>Sample PHP CAPTCHA Query</h1>
    <?php 
    // Check the random string to be valid and return an error message
    // otherwise.
    if (!$captchas->validate($random_string)) {
        echo 'El CAPTCHA solo puede ser usado una sola vez. Intenta de nuevo.';
    }
    // Check, that the right CAPTCHA password has been entered and
    // return an error message otherwise.
    elseif (!$captchas->verify($password)) {
        echo 'El CAPTCHA es incorrecto. Aren\'t you human? Please use back button and reload.';
    }
    // Return a success message
    else {
        echo 'Correcto "'.$message.'"';
    }
    ?>
</html>
