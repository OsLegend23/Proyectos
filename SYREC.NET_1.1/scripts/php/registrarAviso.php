<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
date_default_timezone_set('America/Mexico_City');
include 'conexion.php';
$db = new Conexion;
$db->sql_connect();
$id = $_SESSION['l_usr'];
$fecha = date('Y-m-d H:i:s');
if($_REQUEST['rAviso']=="registrar"){
	$aviso = trim($_REQUEST['aviso']);
	$registrar = $db->sql_query("INSERT INTO avisos(idUsuario,aviso,fechaPublicacion,destinatario) VALUES ($id,'$aviso','$fecha','TODOS')");
	if($registrar){
		echo "<script type = 'text/javascript'>
			alert('El aviso ha sido registrado con Éxito');
			history.back();
		 </script>";
	}
}
?>