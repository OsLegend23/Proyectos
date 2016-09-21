<?php 
require 'CaptchasDotNet.php';
$captchas = new CaptchasDotNet('SYREC', 'H7tG84ZGymYo0TCXOMbT4qW6Oxiu6boIr372Ae9g');
?>
<html>
    <head>
        <title>Sample PHP CAPTCHA Query</title>
    </head>
    <h1>Sample PHP CAPTCHA Query</h1>
    <form method="get" action="check.php">
        <table>
            <tr>
                <td>
                    <input type="hidden" name="random" value="<?= $captchas->random () ?>" />Your message:
                </td>
                <td>
                    <input name="message" size="60" />
                </td>
            </tr>
            <tr>
                <td>
                    The CAPTCHA password:
                </td>
                <td>
                    <input name="password" size="6" />
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <?= $captchas->image()?>
                    <br>
                    <a href="<?= $captchas->audio_url () ?>" target="_blank">Phonetic spelling (mp3)</a>
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td>
                    <input type="submit" value="Submit" />
                </td>
            </tr>
        </table>
    </form>
</html>