<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
date_default_timezone_set('America/Mexico_City');
require_once ('conexion.php');
$db = new Conexion;
$db->sql_connect();
/*Función para el psw del movil*/
function pswMovil() {
    $chars = '1234567890';
    $string = '';
    for ($i = 0; $i < 3; $i++) {
        $pos = rand(0, strlen($chars) - 1);
        $string .= $chars {$pos} ;
    }
    return $string;
}

function idMovil() {
    $chars = 'abcdefghijklmnopqrstuvwxyz';
    $string = '';
    for ($i = 0; $i < 1; $i++) {
        $pos = rand(0, strlen($chars) - 1);
        $string .= $chars {$pos} ;
    }
    return $string;
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
/*ID_MERCHANT*/
function MerchantSupperior($idUser) {
    $db = new Conexion;
    $db->sql_connect();
    $merchant = $db->sql_result($db->sql_query("select ID_MERCHANT from usuarios where idUsuario=".$idUser), 0);
    if ($merchant == NULL)
        $merchant = 0;
    return $merchant;
}

$id = $_SESSION['l_usr'];
$NombreComercial = $_REQUEST['NombreComercial'];
$NombredelResponsable = $_REQUEST['NombredelResponsable'];
$Email = $_REQUEST['Email'];
$Direccion = $_REQUEST['Direccion'];
$Colonia = $_REQUEST['Colonia'];
$Ciudad = $_REQUEST['Ciudad'];
$Estado = $_REQUEST['Estado'];
$CdigoPostal = $_REQUEST['CdigoPostal'];
$TelefonoFijo = $_REQUEST['TelefonoFijo'];
$TelefonoCelular = $_REQUEST['TelefonoCelular'];
$rfc = $_REQUEST['rfc'];
$giro = $_REQUEST['giro'];
$agente = $_REQUEST['agente'];
$Fecha = date('Y-m-d H:i:s');
$pass = rand_string();
$passmovil = pswMovil();
$userMovil = pswMovil().idMovil();
$sql = $db->sql_query("SELECT * FROM usuarios WHERE Usuario = \"".mysql_real_escape_string($Email)."\"");
$existe = $db->sql_num_rows($sql);
$query = $db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = \"".mysql_real_escape_string($id)."\"");
$Perfil = $db->sql_fetch_array($query);
if ($existe > 0) {
    echo "no";
} else {
    if ($Perfil['idPerfil'] == 1) {
        echo "si";
        $sql = $db->sql_query("INSERT INTO usuarios (Usuario, Contrasena,idPerfil,ID_MERCHANT,Status,intentos) VALUES (\"".mysql_real_escape_string($Email)."\",\"".mysql_real_escape_string(hash('sha256', md5($pass)))."\",2,\"".MerchantSupperior($id)."\",1,0)");
        //Obtener nuevo usuario
        $query = $db->sql_query("SELECT u.idUsuario AS idUsuarioNuevo FROM usuarios u  WHERE u.Usuario =\"".mysql_real_escape_string($Email)."\"");
        $data = $db->sql_fetch_array($query);
        $idUsuario = $data['idUsuarioNuevo'];
        $db->sql_query("INSERT INTO detalleusuarios (idUsuario, NombreComercial, Responsable, Domicilio, Colonia, TelFijo, TelMobil, Ciudad, Estado, CodigoPostal, rfc, giro, FechaRegistro, agente)
			    VALUES (\"".mysql_real_escape_string($idUsuario)."\",\"".mysql_real_escape_string($NombreComercial)."\",\"".mysql_real_escape_string($NombredelResponsable)."\",\"".mysql_real_escape_string($Direccion)."\",\"".mysql_real_escape_string($Colonia)."\",\"".mysql_real_escape_string($TelefonoFijo)."\",\"".mysql_real_escape_string($TelefonoCelular)."\",\"".mysql_real_escape_string($Ciudad)."\",\"".mysql_real_escape_string($Estado)."\",\"".mysql_real_escape_string($CdigoPostal)."\",\"".mysql_real_escape_string($rfc)."\",\"".mysql_real_escape_string($giro)."\",\"".mysql_real_escape_string($Fecha)."\",\"".mysql_real_escape_string($agente)."\")");
        $db->sql_query("INSERT INTO relaciones (idUsuarioPadre,idUsuarioHijo) 
			    VALUES ($id,$idUsuario)");
        $db->sql_query("INSERT INTO saldos(IdUsuario,saldoActual,fecha) VALUES(\"".mysql_real_escape_string($idUsuario)."\",0,NOW() - INTERVAL 1 HOUR)");
        $db->sql_query("INSERT INTO temporal_psw (IdUsuario,psw_site,psw_movil) VALUES (\"".mysql_real_escape_string($idUsuario)."\",\"".mysql_real_escape_string($pass)."\",\"".mysql_real_escape_string($passmovil)."\")");
        include "bienvenidaFranquicia.php";
    }
    if ($Perfil['idPerfil'] == 2) {
        echo "si";
        $sql = $db->sql_query("INSERT INTO usuarios (Usuario, Contrasena,idPerfil,ID_MERCHANT,Status,intentos) VALUES (\"".mysql_real_escape_string($Email)."\",\"".mysql_real_escape_string(hash('sha256', md5($pass)))."\",3,\"".MerchantSupperior($id)."\",1,0)");
        //Obtener nuevo usuario
        $query = $db->sql_query("SELECT u.idUsuario AS idUsuarioNuevo FROM usuarios u  WHERE u.Usuario =\"".mysql_real_escape_string($Email)."\"");
        $data = $db->sql_fetch_array($query);
        $idUsuario = $data['idUsuarioNuevo'];
        $db->sql_query("INSERT INTO detalleusuarios (idUsuario, NombreComercial, Responsable, Domicilio, Colonia, TelFijo, TelMobil, Ciudad, Estado, CodigoPostal, rfc, giro, FechaRegistro, agente)
			    VALUES (\"".mysql_real_escape_string($idUsuario)."\",\"".mysql_real_escape_string($NombreComercial)."\",\"".mysql_real_escape_string($NombredelResponsable)."\",\"".mysql_real_escape_string($Direccion)."\",\"".mysql_real_escape_string($Colonia)."\",\"".mysql_real_escape_string($TelefonoFijo)."\",\"".mysql_real_escape_string($TelefonoCelular)."\",\"".mysql_real_escape_string($Ciudad)."\",\"".mysql_real_escape_string($Estado)."\",\"".mysql_real_escape_string($CdigoPostal)."\",\"".mysql_real_escape_string($rfc)."\",\"".mysql_real_escape_string($giro)."\",\"".mysql_real_escape_string($Fecha)."\",\"".mysql_real_escape_string($agente)."\")");
		$db->sql_query("INSERT INTO relaciones (idUsuarioPadre,idUsuarioHijo) 
			    VALUES ($id,$idUsuario)");
        $db->sql_query("INSERT INTO user_movil(IdUsuario,userMovil,Clave,estado) VALUES(\"".mysql_real_escape_string($idUsuario)."\",\"".mysql_real_escape_string($userMovil)."\",\"".mysql_real_escape_string(hash('sha256', md5($passmovil)))."\",1)");
        $db->sql_query("INSERT INTO saldos(IdUsuario,saldoActual,fecha) VALUES(\"".mysql_real_escape_string($idUsuario)."\",0,NOW() - INTERVAL 1 HOUR)");
        $db->sql_query("INSERT INTO temporal_psw (IdUsuario,psw_site,psw_movil) VALUES (\"".mysql_real_escape_string($idUsuario)."\",\"".mysql_real_escape_string($pass)."\",\"".mysql_real_escape_string($passmovil)."\")");
        include "mailBienvenida.php";
    }
}
?>
