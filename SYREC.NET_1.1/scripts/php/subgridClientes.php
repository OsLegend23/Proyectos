<?php 
include 'conexion.php';
$db = new Conexion;
$db->sql_connect();

//query number
$id = $_REQUEST['id'];
// connect to the database
$fecha = date('Y-m-d');
//Consulta para obtener el perfil de usuario
$tipo = $db->sql_result($db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = $id"), 0);

$saldoInicial = $db->sql_result($db->sql_query("SELECT saldo_inicial FROM usuarios WHERE idUsuario = $id"), 0);
$compras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras WHERE idUsuario = $id AND DATE(fecha)='$fecha'"), 0);
if($tipo == 2){
//Consulta de ventas para la Franquicia.
	$ventas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras,relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $id AND DATE(fecha)='$fecha'"), 0);
}
if($tipo == 3){
	$ventas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE idUsuario = $id AND DATE(fecha)='$fecha'"), 0);
}
$comisiones = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE idUsuario = $id AND DATE(fecha)='$fecha'"), 0);
$cargos = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM cargos WHERE idUsuario = $id AND DATE(fecha)='$fecha'"), 0);

header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
    $s .= "<row>";
    $s .= "<cell>$ ".number_format($saldoInicial,2,'.',',')."</cell>";
    $s .= "<cell>$ ".number_format($compras,2,'.',',')."</cell>";
    $s .= "<cell>$ ".number_format($ventas,2,'.',',')."</cell>";
    $s .= "<cell>$ ".number_format($comisiones,2,'.',',')."</cell>";
    $s .= "<cell>$ ".number_format($cargos,2,'.',',')."</cell>";
    $s .= "<cell>$ ".number_format(($saldoInicial+$compras+$comisiones)-($ventas+$cargos),2,'.',',')."</cell>";
    $s .= "</row>";
$s .= "</rows>";
echo $s;
?>
