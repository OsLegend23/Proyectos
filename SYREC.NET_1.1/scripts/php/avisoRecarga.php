<?php 
include 'PHPMailer_v5.1/class.phpmailer.php';

$mail = new PHPMailer();
$mail->Host = "syrec.net";
$mail->From = "administracion@syrec.com.mx";
$mail->FromName = "SYREC Recargas";
$mail->Subject = "SOLICITUD DE SALDO";
$mail->AddAddress("depositos@syrec.com.mx");

$body = "<div align='center'><img src='http://www.syrec.net/images/logo_syrec.png' alt='SYREC.NET' /></div>";
$body .= "<div><p>El usuario ".$usuario." ha solicitado saldo para su red por la cantidad de:</p>";
$body .= "<p>$".$importe."</p></div>";

$mail->Body = $body;
$mail->IsHTML(true);
$mail->Send();
?>
