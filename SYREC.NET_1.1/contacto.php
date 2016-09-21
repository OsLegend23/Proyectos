<?php
include 'scripts/php/conexion.php';
include 'scripts/php/PHPMailer_v5.1/class.phpmailer.php';

$db = new Conexion;
$db->sql_connect();

//get the posted values
$usr = htmlspecialchars($_REQUEST['nombre'], ENT_QUOTES);
$phone = $_REQUEST['telefono'];
$email = $_REQUEST['email'];
$coment = htmlspecialchars($_REQUEST['comentario'], ENT_QUOTES);

//ingresando los datos a la base de datos
$insert = $db->sql_query("INSERT INTO contacto(nombre,telefono,email,comentario) VALUES('$usr','$phone','$email','$coment')");


if($insert){
	echo "yes";
	$mail = new PHPMailer();
	$mail->Host = "syrec.com.mx";
	$mail->From = $email;
	$mail->FromName = "CONTACTO";
	$mail->Subject = "QUIERO SER SOCIO";
	$mail->AddAddress("kainraziellok@gmail.com");
	
	$body = "<div align='center'><img src='http://www.syrec.net/images/logo_syrec.png' alt='SYREC.NET' /></div>";
	$body .= "<p><h3>CONSULTA ENVIADA POR:</h3></p>";
	$body .= "<p>".$name."</p>";
	$body .= "<p><h3>CONTENIDO</h3></p>";
	$body .= "<p>".$coment."</p>";
	$body .= "<p>Tel&eacute;fono: ".$phone."</p>";
	$body .= "<p>Email: ".$email."</p>";
	
	$mail->Body = $body;
	$mail->IsHTML(true);
	$mail->Send();
}else{
    echo "no"; //No ser registró 
}

?>
