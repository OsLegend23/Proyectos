<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include ("conexion.php");
date_default_timezone_set('America/Mexico_City');
$usr = $_REQUEST["usuario"];
$psw = hash('sha256', md5($_REQUEST["password"]));
$password = $_REQUEST['captcha'];
$hora = date('Y-m-d H:i:s');
$date = date('Y-m-d');
$cook = $_COOKIE["SYREC"];
$con = new Conexion;
$con->sql_connect();
$sql = $con->sql_query("SELECT * FROM usuarios WHERE Contrasena = \"" . mysql_real_escape_string($psw) . "\" AND Usuario = \"" . mysql_real_escape_string($usr) . "\"");
$resultado = $con->sql_fetch_array($sql);
$sql2 = $con->sql_query("SELECT * FROM detalleusuarios WHERE idUsuario =\"" . mysql_real_escape_string($resultado[idUsuario]) . "\"");
$nombre = $con->sql_fetch_array($sql2);
$sesion = $con->sql_query("SELECT * FROM sesiones WHERE idUsuario = \"" . mysql_real_escape_string($resultado[idUsuario]) . "\" AND DATE(fecha) = \"" . mysql_real_escape_string($date) . "\" ORDER BY fecha DESC LIMIT 0,1");

if ($_POST['action'] == "checkdata") {
    $re_ip = $_SERVER["REMOTE_ADDR"];
    $fecha = date('Y-m-d H:i:s');
    if ($con->sql_num_rows($sql) > 0) {//Si los datos son correctos
        if (trim(strtolower($password)) == $_SESSION['captcha']) {//Si el captcha es correcto
            if ($resultado['Status'] == 0) {//Si está bloqueado
                if ($resultado['idPerfil'] != 4) {
                    $horab = $con->sql_result($con->sql_query("SELECT horaBloqueo + INTERVAL 15 MINUTE FROM usuarios WHERE idUsuario =\"" . mysql_real_escape_string($resultado[idUsuario]) . "\""), 0);
                    if (strtotime($horab) >= strtotime($hora)) {
                        $con->sql_close();//Cerramos la conexión si se bloqua el usuario.
                        echo "<script type = 'text/javascript'>
                                    alert('Por seguridad su usuario ha sido bloqueado por intentar ingresar reiteradamente con datos err\u00F3neos. Para desbloquearlo cont\u00E1ctese en horario de oficina al 01 442 223 5620 o al mail depositos@syrec.com.mx, o puede esperar 15 min hasta que el sistema lo vuelva a habilitar.');
                                    history.back();
                             </script>";
                    } else {
                        $habilitar = $con->sql_query("UPDATE usuarios SET Status = 1,intentos = 0 WHERE Usuario = '$usr'");
                        if ($habilitar) {
                            if ($resultado['idPerfil'] == 1) {
                                $_SESSION['l_usr'] = $resultado['idUsuario'];
                                $_SESSION['l_nombre'] = $nombre['Responsable'];
                                $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                                $con->sql_close();
                                header("Location: ../../administracion.php");
                            }
                            if ($resultado['idPerfil'] == 2) {
                                $_SESSION['l_usr'] = $resultado['idUsuario'];
                                $_SESSION['l_nombre'] = $nombre['Responsable'];
                                $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                                $con->sql_close();
                                header("Location: ../../franquiciatario.php");
                            }
                            if ($resultado['idPerfil'] == 3) {
                                $_SESSION['l_usr'] = $resultado['idUsuario'];
                                $_SESSION['l_nombre'] = $nombre['Responsable'];
                                $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                                $con->sql_close();
                                header("Location: ../../comercio.php");
                            }
                        }
                    }
                } else {
                    echo "<script type = 'text/javascript'>
                                alert('Por seguridad su cajero ha sido bloqueado por intentar ingresar reiteradamente con datos err\u00F3neos o por decisi\u00F3n de su Comercio. Para desbloquearlo cont\u00F3ctese, en su horario de trabajo, con el Administrador del Comercio que lo dio de Alta');
                                history.back();
                         </script>";
                }
            } else {
                if ($con->sql_num_rows($sesion) > 0) {//Si ya hay una sesión activa
                    $existe = $con->sql_fetch_array($sesion);
                    if ($existe['SessionId'] == $cook) {//Si la cookie del cliente es igual a la sesión en BD lo dejo entrar
                        if ($resultado['idPerfil'] == 1) {
                            $_SESSION['l_usr'] = $resultado['idUsuario'];
                            $_SESSION['l_nombre'] = $nombre['Responsable'];
                            $sesionId = session_id();
                            setcookie("SYREC", $sesionId, time() + 21600, "/", "syrec.net");
                            $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                            //$con->sql_query("INSERT INTO sesiones (idUsuario,SessionId, fecha) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($sesionId) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                            $con->sql_close();
                            header("Location: ../../administracion.php");
                        }
                        if ($resultado['idPerfil'] == 2) {
                            $_SESSION['l_usr'] = $resultado['idUsuario'];
                            $_SESSION['l_nombre'] = $nombre['Responsable'];
                            $sesionId = session_id();
                            setcookie("SYREC", $sesionId, time() + 21600, "/", "syrec.net");
                            //$con->sql_query("INSERT INTO sesiones (idUsuario,SessionId, fecha) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($sesionId) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                            $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                            $con->sql_close();
                            header("Location: ../../franquiciatario.php");
                        }
                        if ($resultado['idPerfil'] == 3) {
                            $_SESSION['l_usr'] = $resultado['idUsuario'];
                            $_SESSION['l_nombre'] = $nombre['Responsable'];
                            $sesionId = session_id();
                            setcookie("SYREC", $sesionId, time() + 21600, "/", "syrec.net");
                            //$con->sql_query("INSERT INTO sesiones (idUsuario,SessionId, fecha) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($sesionId) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                            $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                            $con->sql_close();
                            header("Location: ../../comercio.php");
                        }
                        if ($resultado['idPerfil'] == 4) {
                            $_SESSION['l_usr'] = $resultado['idUsuario'];
                            $_SESSION['l_nombre'] = $nombre['Responsable'];
                            $sesionId = session_id();
                            setcookie("SYREC", $sesionId, time() + 21600, "/", "syrec.net");
                            //$con->sql_query("INSERT INTO sesiones (idUsuario,SessionId, fecha) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($sesionId) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                            $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                            $con->sql_close();
                            header("Location: ../../cajero.php");
                        }
                    } else {
                        echo "<script type = 'text/javascript'>
                                alert('Este usuario ya ha iniciado sesi\u00F3n en otra computadora o en otro navegador, o bien no termin\u00F3 correctamente la sesi\u00F3n; por favor termine la sesi\u00F3n en esa computadora correctamente y vuelva a intentarlo. Si no comuniquese en horario de oficina al 01 442 223 5620 o al mail soporte@syrec.com.mx.');
                                history.back();
                         </script>";
                    }
                } else {//En dado caso que no lo encuentre
                    if ($resultado['idPerfil'] == 1) {
                        $_SESSION['l_usr'] = $resultado['idUsuario'];
                        $_SESSION['l_nombre'] = $nombre['Responsable'];
                        $sesionId = session_id();
                        setcookie("SYREC", $sesionId, time() + 21600, "/", "syrec.net");
                        $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                        //$con->sql_query("INSERT INTO sesiones (idUsuario,SessionId, fecha) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($sesionId) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                        $con->sql_close();
                        header("Location: ../../administracion.php");
                    }
                    if ($resultado['idPerfil'] == 2) {
                        $_SESSION['l_usr'] = $resultado['idUsuario'];
                        $_SESSION['l_nombre'] = $nombre['Responsable'];
                        $sesionId = session_id();
                        setcookie("SYREC", $sesionId, time() + 21600, "/", "syrec.net");
                        //$con->sql_query("INSERT INTO sesiones (idUsuario,SessionId, fecha) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($sesionId) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                        $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                        $con->sql_close();
                        header("Location: ../../franquiciatario.php");
                    }
                    if ($resultado['idPerfil'] == 3) {
                        $_SESSION['l_usr'] = $resultado['idUsuario'];
                        $_SESSION['l_nombre'] = $nombre['Responsable'];
                        $sesionId = session_id();
                        setcookie("SYREC", $sesionId, time() + 21600, "/", "syrec.net");
                        //$con->sql_query("INSERT INTO sesiones (idUsuario,SessionId, fecha) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($sesionId) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                        $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                        $con->sql_close();
                        header("Location: ../../comercio.php");
                    }
                    if ($resultado['idPerfil'] == 4) {
                        $_SESSION['l_usr'] = $resultado['idUsuario'];
                        $_SESSION['l_nombre'] = $nombre['Responsable'];
                        $sesionId = session_id();
                        setcookie("SYREC", $sesionId, time() + 21600, "/", "syrec.net");
                        //$con->sql_query("INSERT INTO sesiones (idUsuario,SessionId, fecha) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($sesionId) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                        $con->sql_query("INSERT INTO entradas (IdUsuario,IpClient,FechaHora) VALUES (\"" . mysql_real_escape_string($resultado[idUsuario]) . "\",\"" . mysql_real_escape_string($re_ip) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
                        $con->sql_close();
                        header("Location: ../../cajero.php");
                    }
                }
            }
        } else {
            $error = $re_valid->error;
            echo "<script type = 'text/javascript'>
			alert('El c\u00F3digo es incorrecto');
			history.back();
		 </script>";
        }
    } else {
        $con->sql_query("UPDATE usuarios SET intentos = intentos+1 WHERE Usuario = '$usr'");
        //Obtener intentos
        $i = $con->sql_result($con->sql_query("SELECT intentos FROM usuarios WHERE Usuario = '$usr'"), 0);
        if ($i >= 3) {
            $con->sql_query("UPDATE usuarios SET Status = 0, horaBloqueo = '$hora' WHERE Usuario = '$usr'");
            $id = $con->sql_result($con->sql_query("SELECT idUsuario FROM usuarios WHERE Usuario = '$usr'"), 0);
            $con->sql_query("UPDATE usuarios, relaciones SET usuarios.Status = 0, usuarios.horaBloqueo = '$hora' WHERE usuarios.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $id )");
            $con->sql_close();
            echo "<script type = 'text/javascript'>
                        alert('El usuario ha sido deshabilitado por superar el m\u00E1ximo de intentos permitidos, para desbloquearlo cont\u00E1ctese en horario de oficina al 01 442 223 5620 o al mail depositos@syrec.com.mx, o puede esperar 15 min hasta que el sistema lo vuelva a habilitar');
                        history.back();
                 </script>";
        } else {
            echo "<script type = 'text/javascript'>
			alert('¡El usuario/contrase\u00F1a incorrectos!');
			history.back();
		 </script>";
        }
    }
}
?>
