<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');

include 'registrarCajero.class.php';
include 'PHPMailer_v5.1/class.phpmailer.php';

$id = $_SESSION['l_usr'];
$cajero = $_REQUEST['nombre'];
$email = $_REQUEST['email'];
$telefono = $_REQUEST['phone'];
$celular = $_REQUEST['celular'];
//$entrada = $_REQUEST['entrada'];
//$salida = $_REQUEST['salida'];
$entrada = '00:00';
$salida = '00:00';
$semana = $_REQUEST['semana'];
$domingo = 0;
$lunes = 0;
$martes = 0;
$miercoles = 0;
$jueves = 0;
$viernes = 0;
$sabado = 0;

if($semana['do'] != NULL){
	$domingo = $semana['do'];
}
if($semana['lu'] != NULL){
	$lunes = $semana['lu'];
}
if($semana['ma'] != NULL){
	$martes = $semana['ma'];
}
if($semana['mi'] != NULL){
	$miercoles = $semana['mi'];
}
if($semana['ju'] != NULL){
	$jueves = $semana['ju'];
}
if($semana['vi'] != NULL){
	$viernes = $semana['vi'];
}
if($semana['sa'] != NULL){
	$sabado = $semana['sa'];
}

//echo $domingo." ".$lunes." ".$martes." ".$miercoles." ".$jueves." ".$viernes." ".$sabado;

$psw = rand_string();

$registrar = new RegistrarCajero($id, $cajero, $email, $psw, $telefono, $celular, $entrada, $salida, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo);
$ingreso = $registrar->registrar();

if ($ingreso == "no") {
    echo $ingreso;
} else {
	echo $ingreso;
    $mail = new PHPMailer();
    $mail->Host = "syrec.net";
    $mail->From = "ventas@syrec.com.mx";
    $mail->FromName = "SYREC Recargas";
    $mail->Subject = "Bienvenid@ a Syrec";
    $mail->AddAddress($email);
    
    $body = "<div align='center'><img src='http://www.syrec.net/images/logo_syrec.png' alt='SYREC.NET' /></div>";
    $body .= "<p><h3>Bienvenid@</h3></p>";
    $body .= "<p>Has sido habilitado para realizar recargas y ver las ventas que realices desde el portal de tu comercio.</p>";
    $body .= "<p>Entra desde una pc a <a href='http://www.syrec.net'>www.syrec.net</a> con las siguientes claves: </p>";
    $body .= "<ul>";
    $body .= "<li><strong>Usuario:</strong> ".$email."</li>";
    $body .= "<li><strong>Contrase&ntilde;a:</strong> ".$psw."</li>";
    $body .= "</ul>";
    $body .= "<div align='center'><strong>Es necesario respetar may&uacute;sculas, min&uacute;sculas, s&iacute;mbolos y n&uacute;meros para poder acceder. Al cuarto intento no exitoso, el sistema entender&aacute; que alguien no autorizado est&aacute; intentando ingresar a tu cuenta y bloquear&aacute; tu usuario.</strong></div>";
	$body .= "<p>Para habilitarlo nuevamente deber&aacute; contactarnos el responsable del comercio en horas h&aacute;biles de 9 a 6 pm de lunes a viernes y s&aacute;bados de 9 a 2 al tel. 01 442 223 5620</p>";
    $body .= "<p><strong>Es importante NO dar a conocer a nadie tus claves, porque todas las recargas que se realicen con ellas quedar&aacute;n registradas bajo tu usuario.</strong></p>";
    $body .= "<p>Aunque el portal te lleva de la mano para hacer recargas y ver reportes, puedes consultar el manual para m&aacute;s detalles al ingresar al portal. Te recomendamos imprimir y/o  guardar los manuales en tu PC para futuras consultas o en caso de que no puedas ingresar y requieras contactarnos</p>";
    $body .= "<p>Tambi&eacute;n contamos con chat en l&iacute;nea desde el portal (bot&oacute;n verde) para apoyarte en cualquier duda.</p>";
    $body .= "<p>Despu&eacute;s de aproximadamente 30 mins sin hacer ninguna operaci&oacute;n o consulta en el portal, necesitas actualizar la sesi&oacute;n con F5 o saliendo y entrando nuevamente.</p>";
    $body .= "<div align='center'><strong>&iexcl;Gracias nuevamente por permitirnos ser tus socios en recargas electr&oacute;nicas!</strong></div>";
    
    $mail->Body = $body;
    $mail->IsHTML(true);
    $mail->Send();
}

function rand_string() {
    $chars = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for ($i = 0; $i < 5; $i++) {
        $pos = rand(0, strlen($chars) - 1);
        $string .= $chars {$pos} ;
    }
    return $string;
}
?>
