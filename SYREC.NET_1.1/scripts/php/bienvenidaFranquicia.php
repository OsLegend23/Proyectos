<?php
include 'PHPMailer_v5.1/class.phpmailer.php';
date_default_timezone_set('America/Mexico_City');
$mail = new PHPMailer();
$mail->Host = "syrec.net";
$mail->From = "ventas@syrec.com.mx";
$mail->FromName = "SYREC Recargas";
$mail->Subject = "Bienvenid@ a Syrec";
$mail->AddAddress($_POST['Email']);

$body = "<div align='center'><img src='http://www.syrec.net/images/logo_syrec.png' alt='SYREC.NET' /></div>";
$body .= "<p><h3>Bienvenid@</h3></p>";
$body .= "<p>Gracias por hacer de SYREC tu portal de recargas. Ahora podr&aacute;s vender  recargas de Telcel, Movistar, Iusacell y Unefon desde cualquier ciudad a cualquier destino y monto, desde una PC con internet o desde un celular Telcel.</p>";
$body .= "<p>Para poder empezar entra desde una pc a <a href='http://www.syrec.net'>www.syrec.net</a> con tu usuario y contrase&ntilde;a : </p>";
$body .= "<ul>";
$body .= "<li><strong>Usuario:</strong> ".$_REQUEST['Email']."</li>";
$body .= "<li><strong>Contrase&ntilde;a:</strong> ".$pass."</li>";
$body .= "</ul>";
$body .= "<p>Es importante NO dar a conocer a nadie esos datos, porque son el medio de acceso a tu saldo.</p>";
$body .= "<p>Aunque el portal te lleva de la mano para hacer recargas y ver reportes, puedes consultar el manual para m&aacute;s detalles al ingresar al portal.</p>";
$body .= "<p>Es importante hacer al menos una compra en los siguientes 10 d&iacute;as para evitar que te demos de baja en el portal.</p>";
$body .= "<div align='center'><strong>&iexcl;Gracias nuevamente por permitirnos ser tus socios en recargas electr&oacute;nicas!</strong></div>";

$mail->Body = $body;
$mail->IsHTML(true);
$mail->Send();
?>