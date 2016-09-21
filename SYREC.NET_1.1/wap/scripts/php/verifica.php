<?php
session_start();
include ("conexion.php");
$db = new Conexion;
$db->sql_connect();

if ($_REQUEST['action'] == "checkdata") {
    if ($_REQUEST['password'] != "" AND $_REQUEST['usr'] != "") {
        //Reviso que el usuario exista
        $sql = $db->sql_query("SELECT * FROM user_movil WHERE Clave = \"" . mysql_real_escape_string(hash('sha256', md5($_REQUEST[password]))) . "\" AND userMovil = \"" . mysql_real_escape_string($_REQUEST[usr]) . "\"");
        //$sql = $db->sql_query("SELECT * FROM user_movil WHERE Clave = '".(hash('sha256', md5($_REQUEST[password]))) . "' AND userMovil = '" . $_REQUEST[usr] . "'");
        $resultado = $db->sql_fetch_array($sql);
        if ($db->sql_num_rows($sql) > 0) {
            //Ahora verifico si está habilitado
            if ($resultado['estado'] == 1) {
                $_SESSION['movil'] = "movil";
                $_SESSION['idUsr'] = $resultado['IdUsuario'];
                header("LOCATION: ../../Carriers.php");
            } else {
                header("LOCATION: ../../wapError.php?msj=" . urlencode('El usuario está deshabilitado por superar el máximo de intentos permitidos') . "");
            }
        } else {
            //Se actualizan los intentos
            $db->sql_query("UPDATE intentos = intentos+1 FROM user_movil WHERE userMovil = \"" . mysql_real_escape_string($_REQUEST[usr]) . "\"");
            //Obtener los intentos
            $i = $db->sql_result($db->sql_query("SELECT intentos FROM user_movil WHERE userMovil = '$_REQUEST[usr]'"), 0);
            if ($i >= 3) {
                $db->sql_query("UPDATE user_movil SET estado = 0 WHERE userMovil = '$_REQUEST[usr]'");
                header("LOCATION: ../../wapError.php?msj=" . urlencode('El usuario está deshabilitado por superar el máximo de intentos permitidos') . "");
            } else {
                header("LOCATION: ../../wapError.php?msj=" . urlencode('Usuario / Contraseña incorrectos, intente de nuevo') . "");
                //header("LOCATION: ../../wapError.php?msj=" . urlencode("SELECT * FROM user_movil WHERE Clave = '".(hash('sha256', md5($_REQUEST[password]))) . "' AND userMovil = '" . $_REQUEST[usr] . "'"));
            }
        }
    } else {
        header("LOCATION: ../../wapError.php?msj=" . urlencode('Los campos no pueden estar vacíos') . "");
    }
}
?>
