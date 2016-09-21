<?php 
session_start();
#Se recogen todas las variables de sesion
$_SESSION = array();
#obtenermos el nombre de la sesion
$session_name = session_name();
#destruimos la variable de sesion
 unset($_SESSION["movil"]);
 unset($_SESSION["idUsr"]);
session_unset();
#Se destruye la sesion
session_destroy();

// Para borrar las cookies asociadas a la sesión
// Es necesario hacer una petición http para que el navegador las elimine
if (isset($_COOKIE[$session_name])) {
    if (setcookie(session_name(), '', time() - 3600, '/')) {
        header("Location: ../../wap-login.php");
        exit();
    }
    
}


?>
