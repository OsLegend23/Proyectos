<?php
session_start();
date_default_timezone_set('America/Mexico_City');
include 'scripts/php/conexion.php';
$db = new Conexion;
$db->sql_connect();
$id = $_SESSION['idUsr'];
if (!empty($_SESSION['idUsr']) and $_SESSION['movil'] == "movil") {
    $ayer = date('Y-m-d', strtotime('-1 days')); //Fecha del día anterior
    $hoy = date('Y-m-d');
    /* OBTENER LOS SALDOS DEL DÍA ANTERIOR */
    $comprasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE idUsuario = $id AND estatus = 1 AND DATE(fechaAut)<='$ayer'"), 0);
    $ventasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)<='$ayer'"), 0);
    $comisionesA = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)<='2011-01-25'"), 0);
    $comisionesI = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha) > '2011-02-28' AND DATE(fecha)<='$ayer'"), 0);
    $sInicial = ($comprasA + $comisionesA + $comisionesI) - $ventasA;
    //SE ACTUALIZA EL SALDO INICIAL
    $db->sql_query("UPDATE usuarios SET saldo_Inicial=$sInicial WHERE idUsuario = $id");
    $saldoInicial = $db->sql_result($db->sql_query("SELECT saldo_Inicial FROM usuarios WHERE idUsuario = $id"), 0);
    $compras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE idUsuario = $id AND estatus = 1 AND DATE(fechaAut)='$hoy'"), 0);
    $ventas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)='$hoy'"), 0);
    $comisiones = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)='$hoy'"), 0);
    $saldoActual = ($saldoInicial + $compras + $comisiones) - $ventas;
    //SE ACTUALIZA EL SALDO ACTUAL
    $db->sql_query("UPDATE saldos SET saldoActual = $saldoActual, fecha = NOW() WHERE idUsuario = $id");
?>
<?php header('Content-type: application/vnd.wap.xhtml+xml; charset=utf-8'); ?>
<?php echo '<?xml version="1.0" encoding="utf-8" ?>'; ?>
    <!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">    
        <head>
            <title>WAP-SYREC</title>
            <style type="text/css">
                body {
                    margin: 0px;
                    padding: 6px 0px 0px 0px;
                    font-family: Verdana, Arial, Helvetica, sans-serif;
                    font-size:60%;
                    background-color: #c0c0c0;;
                    text-align: center;
                }

                strong {
                    text-align: center;
                }
                hr{
                    color: #FF5200;
                }
            </style>
        </head>
        <body>
            <div align="center">
                <strong>SYREC :: Portal WAP</strong>
                <hr />
                <div align="center">
                    Tu saldo actual es: <strong>$<?php echo number_format($saldoActual, 2, '.', ','); ?></strong>
                </div>
                <a href="ReloadForm.php?carri=TELCEL">Telcel</a>
                <br/>
                <a href="ReloadForm.php?carri=MOVISTAR">Movistar</a>
                <br/>
                <a href="ReloadForm.php?carri=IUSACELL">Iusacell</a>
                <br/>
                <a href="ReloadForm.php?carri=UNEFON">Unefon</a>
                <br/>
                <a href="ReloadForm.php?carri=NEXTEL">Nextel</a>
                <br/>
                <a href="ReloadForm.php?carri=CACHITO">Cachito</a>
                <br/>
                <a href="ReloadForm.php?carri=MELATE">Melate</a>
                <br/>
                <a href="reportarpago.php">Reportar Depósito</a>
                <br/>
                <a href="ultimosMovimientos.php">Últimos Movimientos</a>
                <br/>
                <a href="scripts/php/logout.php">SALIR</a>
                <hr/>
                <div align="center">
                    <strong>SYREC &copy;<?php echo date('Y') ?></strong>
                </div>
            </div>
        </body>
    </html>
<?php
} else {
    header("LOCATION:index.php");
}
?>
