<?php
date_default_timezone_set('America/Mexico_City');
include 'scripts/php/PHPMailer_v5.1/class.phpmailer.php';

//get the posted values
$usr = htmlspecialchars($_REQUEST['nombre'], ENT_QUOTES);
$phone = $_REQUEST['telefono'];
$email = $_REQUEST['email'];
$coment = htmlspecialchars($_REQUEST['comentario'], ENT_QUOTES);
$ip = $_SERVER["REMOTE_ADDR"];
$fechaHora = date('Y-m-d H:i:s');

if($usr!="" AND $phone != "" AND $email != "" AND $coment != ""){
	
	echo "yes";
	$mail = new PHPMailer();
	$mail->Host = "syrec.com.mx";
	$mail->From = $email;
	$mail->FromName = "CONTACTO SYREC";
	$mail->Subject = $usr;
	$mail->AddAddress("ventas@syrec.com.mx");
	
	$body = "<div align='center'><img src='http://www.syrec.net/images/logo_syrec.png' alt='SYREC.NET' /></div>";
	$body .= "<p><h3>CONSULTA ENVIADA POR:</h3></p>";
	$body .= "<p>".$usr." DESDE LA IP ".$ip."</p>";
	$body .= "<p><h3>CONTENIDO</h3></p>";
	$body .= "<p>".$coment."</p>";
	$body .= "<p>Tel&eacute;fono: ".$phone."</p>";
	$body .= "<p>Email: ".$email."</p>";
	$body .= "<p>D�a y Hora de Envio: ".$fechaHora."</p>";
	
	$mail->Body = $body;
	$mail->IsHTML(true);
	$mail->Send();
}else{
    echo "no"; //No ser registr� 
}

?>
