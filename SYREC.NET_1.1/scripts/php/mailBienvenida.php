<?php
include 'PHPMailer_v5.1/class.phpmailer.php';

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
$body .= "<p>O desde tu celular con internet a wap.syrec.net </p>";
$body .= "<ul>";
$body .= "<li><strong>Usuario Movil:</strong> ".$userMovil."</li>";
$body .= "<li><strong>Contrase&ntilde;a Movil:</strong> ".$passmovil."</li>";
$body .= "</ul>";
$body .= "<div align='center'><strong>Es necesario respetar may&uacute;sculas, min&uacute;sculas, s&iacute;mbolos y n&uacute;meros para poder acceder. Al cuarto intento no exitoso, el sistema entender&aacute; que alguien no autorizado est&aacute; intentando ingresar a tu cuenta y bloquear&aacute; tu usuario.</strong></div>";
$body .= "<p>Para desbloquear tu usuario necesitas comunicarte de lunes a viernes de 9 a 6 y s&aacute;bados de 9 a 1, v&iacute;a telef&oacute;nica al 01 442 223 5620 o v&iacute;a mail a depositos@syrec.com.mx para identificarte y solicitar el desbloqueo. Fuera de ese horario, env&iacute;a un mail a guardia@syrec.com.mx Por favor SIEMPRE indica tu nombre comercial para poder ayudarte.</p>";
$body .= "<p><strong>Es importante NO dar a conocer a nadie esos datos, porque son el medio de acceso a tu saldo.</strong></p>";
$body .= "<p>Aunque el portal te lleva de la mano para hacer recargas y ver reportes, puedes consultar el manual para m&aacute;s detalles al ingresar al portal. Te recomendamos imprimir y/o  guardar los manuales en tu PC para futuras consultas o en caso de que no puedas ingresar y requieras contactarnos</p>";
$body .= "<p>Tambi&eacute;n contamos con chat en l&iacute;nea desde el portal (bot&oacute;n verde) para apoyarte en cualquier duda.</p>";
$body .= "<p>Despu&eacute;s de aproximadamente 30 mins sin hacer ninguna operaci&oacute;n o consulta en el portal, necesitas actualizar la sesi&oacute;n con F5 o saliendo y entrando nuevamente.</p>";
$body .= "<p>Entendemos que nos enviaste tu solicitud y documentos para vender recargas, por lo que es necesario realizar al menos una compra en los siguientes 8 d&iacute;as, para evitar que te demos de baja.</p>";
$body .= "<div align='center'><strong>&iexcl;Gracias nuevamente por permitirnos ser tus socios en recargas electr&oacute;nicas!</strong></div>";

$mail->Body = $body;
$mail->IsHTML(true);
$mail->Send();
?>