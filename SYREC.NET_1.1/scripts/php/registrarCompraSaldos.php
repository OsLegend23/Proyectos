<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
date_default_timezone_set('America/Mexico_City');
include('conexion.php');
$db = new Conexion;
$db->sql_connect();

$id = $_SESSION['l_usr'];
$carrier = $_REQUEST['carrier'];

$distribuidor = $_REQUEST['distribuidor'];
$importe = ereg_replace("[^ 0-9.]", "", $_REQUEST['importe']);
$banco = $_REQUEST['banco'];
$tipo = $_REQUEST['tipo'];
$referencia = $_REQUEST['referencia'];
$concepto = "COMPRA";
$ref = $tipo . "-" . $referencia;
$fecha = date('Y-m-d H:i:s');
if ($_REQUEST['token'] == "registrar") {
    //Obteniendo el perfil
    $p = $db->sql_result($db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = $id"), 0);
    if ($p == 2 || $p == 3) {
        $ingresaSaldo = $db->sql_query("INSERT INTO depositos(idUsuario,cliente, monto,banco,referencia, concepto, fecha) VALUES(\"" . mysql_real_escape_string($id) . "\",\"" . mysql_real_escape_string($distribuidor) . "\",\"" . mysql_real_escape_string($importe) . "\",\"" . mysql_real_escape_string($banco) . "\",\"" . mysql_real_escape_string($ref) . "\",\"" . mysql_real_escape_string($concepto) . "\",\"" . mysql_real_escape_string($fecha) . "\")");
        $usuario = $db->sql_result($db->sql_query("SELECT Responsable FROM detalleusuarios WHERE idUsuario =\"" . mysql_real_escape_string($id) . "\""), 0);
        /* Enviando correo para avisar al administrador del sitio que hay una nueva petición de recarga */
        //require('avisoRecarga.php');
        if ($ingresaSaldo) {
            echo 'si';
        } else {
            echo "no";
        }
    }
    if ($p == 1) {
        $YREC = "SYREC";
        if ($carrier == 'TARJETASNOR') {
            $telcel = $importe;
            $movistar = 0;
            $iusa = 0;
            $pagatae = 0;
        }
        if ($carrier == 'MOVISTAR') {
            $telcel = 0;
            $movistar = $importe;
            $iusa = 0;
            $pagatae = 0;
        }
        if ($carrier == 'IUSACELL') {
            $telcel = 0;
            $movistar = 0;
            $iusa = $importe;
            $pagatae = 0;
        }
        if($carrier == "PAGATAE"){
            $telcel = 0;
            $movistar = 0;
            $iusa = 0;
            $pagatae = $importe;
        }
        if($carrier == "NEXTEL"){
            $telcel = 0;
            $movistar = 0;
            $iusa = 0;
            $pagatae = 0;
            $nextel = $importe;
        }

        $referencia = $carrier . "-" . $tipo . "-" . $referencia;
        $ingresaSaldo = $db->sql_query("INSERT INTO saldos_carrier(idUsuario, saldo_Telcel,saldo_Movistar,saldo_Iusacell, saldo_Pagatae, saldo_Nextel, estatus, fechaSolicitud) VALUES(\"" . mysql_real_escape_string($id) . "\",\"" . mysql_real_escape_string($telcel) . "\",\"" . mysql_real_escape_string($movistar) . "\",\"" . mysql_real_escape_string($iusa) . "\",\"" . mysql_real_escape_string($pagatae) . "\",\"" . mysql_real_escape_string($nextel) . "\",'ACEPTADO',\"" . mysql_real_escape_string($fecha) . "\")");
        $db->sql_query("INSERT INTO depositos(idUsuario,cliente, monto,banco,referencia, fecha,estatus) VALUES(\"" . mysql_real_escape_string($id) . "\",\"" . mysql_real_escape_string($YREC) . "\",\"" . mysql_real_escape_string($importe) . "\",\"" . mysql_real_escape_string($banco) . "\",\"" . mysql_real_escape_string($referencia) . "\",\"" . mysql_real_escape_string($fecha) . "\",1)");
        $db->sql_query("INSERT INTO compras (idUsuario, monto, fecha)
            VALUES ($id,$importe,'$fecha')");
        echo "si";
    }
} else {
    echo 'no';
}
?>
