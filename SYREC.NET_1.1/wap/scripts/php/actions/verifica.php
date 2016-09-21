<?php 
session_start();
include ("conexion.php");
$db= new Conexion;
$db->sql_connect();
function MySupperior($idh)
{
    $db= new Conexion;
    $db->sql_connect();
    return $db->sql_result($db->sql_query("SELECT idUsuarioPadre FROM realaciones WHERE idUsuarioHijo=$idh"),0);
}
if($_REQUEST['action'] == "checkdata")
{
    if($_REQUEST['password'] != "")
    {
        //Obtener los intentos
        $i=$db->sql_query("SELECT intentos FROM user_movil WHERE userMovil = '$_REQUEST[usr]'");
        $intentos=$db->sql_fetch_array($i);
        if($intentos['intentos'] >= 3)
        {
            $db->sql_query("UPDATE user_movil SET estado = 0 WHERE userMovil = '$_REQUEST[usr]'");
            header("LOCATION: ../../../wapError.php?msj=".urlencode('El usuario está deshabilitado por superar el máximo de intentos permitidos')."");
        }
        else
        {
            $sql=$db->sql_query("SELECT A.idUsuario,Perfil,Usuario,A.Clave as Contrasena,A.estado 
				FROM user_movil A inner join usuarios B on (A.idUsuario=B.idUsuario) inner join perfiles C on (B.idPerfil=C.idPerfiles)
                WHERE A.Clave = \"".mysql_real_escape_string(hash('sha256', md5($_REQUEST['password'])))."\" AND A.userMovil = \"".mysql_real_escape_string($_REQUEST['usr'])."\" and estado='1'");
            $data=$db->sql_fetch_array($sql);
            if($data['Contrasena'] != hash('sha256', md5($_REQUEST['password'])))
            {
                $db->sql_query("UPDATE user_movil SET intentos=intentos+1 WHERE userMovil = '$_REQUEST[usr]'");
                //Aquí va la actualización para deshabilitar al usuario si ha ingresado una clave mal 3 veces
				header("LOCATION: ../../../wapError.php?msj=".urlencode('Código Incorrecto')."");
            }
            else
            {
                $_SESSION["Por"]="movil";
                $_SESSION["User"]=$data['Usuario'];
                $_SESSION["Role"]=$data['Perfil'];
                $_SESSION["UserID"]=$data['idUsuario'];
                header("Location:../../../TabNavigator.php");
            }
        }
    }
    else
    {
        header("LOCATION: ../../../wapError.php?msj=".urlencode('El campo no puede estar vacío')."");
    }
}
?>
