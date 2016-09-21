<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include 'conexion.php';
$antPass = hash('sha256', md5($_REQUEST['passAnterior']));
$newPass = hash('sha256', md5($_REQUEST['newPass']));
$id = $_SESSION['l_usr'];

$db = new Conexion;
$db->sql_connect();

$pass = $db->sql_fetch_array($db->sql_query("SELECT usuarios.Usuario, usuarios.Contrasena, detalleusuarios.NombreComercial FROM usuarios, detalleusuarios WHERE usuarios.idUsuario = detalleusuarios.idUsuario AND usuarios.idUsuario = $id"));

if ($pass[Contrasena] != $antPass) {
    echo "La contraseña anterior no coincide con su contraseña actual.";
} else {
    $db->sql_query("UPDATE usuarios SET Contrasena = '$newPass' WHERE idUsuario = $id");
    include 'PHPMailer_v5.1/class.phpmailer.php';
    
    $mail = new PHPMailer();
    $mail->Host = "syrec.net";
    $mail->From = "soporte@syrec.com.mx";
    $mail->FromName = "SYREC Recargas";
    $mail->Subject = "Cambio de Contraseña Syrec";
    $mail->AddAddress($pass[Usuario]);
    
    $body = "<div align='center'><img src='http://www.syrec.net/images/logo_syrec.png' alt='SYREC.NET' /></div>";
    $body .= "<p><h3>$pass[NombreComercial]</h3></p>";
    $body .= "<p>Gracias por hacer de SYREC tu portal de recargas.</p>"; 
    $body .= "<p>Haz solicitado un cambio de contrase&ntilde;a a nuestro portal, por lo que tus nueva clave es: </p>";
    $body .= "<ul>";
    $body .= "<li><strong>Contrase&ntilde;a:</strong> ".$_REQUEST['newPass']."</li>";
    $body .= "</ul>";
    $body .= "<p>Es importante NO dar a conocer a nadie esos datos, porque son el medio de acceso a tu saldo.</p>";
    $body .= "<div align='center'><strong>&iexcl;Gracias nuevamente por permitirnos ser tus socios en recargas electr&oacute;nicas!</strong></div>";
    
    $mail->Body = $body;
    $mail->IsHTML(true);
    $mail->Send();
	
	echo "si";
}
$db->sql_close();
?>
