<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include ("conexion.php");

$con = new Conexion;
$con->sql_connect();
$id = $_SESSION['l_usr'];
#Borramos la sesión de la tabla de sesiones
$con->sql_query("DELETE FROM sesiones WHERE idUsuario = $id");

#Se recogen todas las variables de sesion
$_SESSION = array();
#obtenermos el nombre de la sesion
$session_name = session_name();
#destruimos la variable de sesion
unset($_SESSION["l_usuario"]);
unset($_SESSION['l_usr']);
unset($_SESSION['l_nombre']);
unset($_SESSION['captcha']);
unset($_SESSION['monto']);
unset($_SESSION['celular']);
unset($_SESSION['carrier']);
unset($_SESSION["tmptxt"]);
session_unset();
#Se destruye la sesion
session_destroy();

// Para borrar las cookies asociadas a la sesión
// Es necesario hacer una petición http para que el navegador las elimine
if (isset($_COOKIE[$session_name]) AND isset($_COOKIE["SYREC"])) {
//if (isset($_COOKIE[$session_name])) {
    if (setcookie(session_name(), '', time() - 3600, '/') AND setcookie("SYREC", '', time() - 21600, '/', 'syrec.net')) {
        header("Location: http://www.syrec.net");
        exit();
    }
    
}


?>
