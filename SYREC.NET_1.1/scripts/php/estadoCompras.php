<?php

date_default_timezone_set('America/Mexico_City');
include 'conexion.php';
$db = new Conexion;
$db->sql_connect();
//ini_set('max_execution_time', 600);
$examp = $_REQUEST["q"]; //query number
$page = $_REQUEST['page']; // get the requested page
$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
$sord = $_REQUEST['sord']; // get the direction
$idUsr = $_REQUEST['idUsr']; //get id User
$buscar = $_REQUEST['_search'];


if (!$sidx)
    $sidx = 1;
/* Asignamos la fecha de inicio de la consulta */
if (isset($_GET["inicio"]))
    $inicio = $_GET['inicio'];
else
    $inicio = date('Y-m-d');
/* Asignamos la fecha de final de la consulta */
if (isset($_GET["final"]))
    $final = $_GET["final"];
else
    $final = date('Y-m-d');
/* Asignamos al usuario de la consulta */
if (isset($_GET["usuario"]))
    $usuario = $_GET['usuario'];
else
    $usuario = "";

$result = $db->sql_query("SELECT COUNT(*) AS count FROM depositos, relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND estatus = 1 AND DATE(fechaAut) >= '$inicio' AND DATE(fechaAut) <= '$final'");

$row = $db->sql_fetch_array($result);
$count = $row['count'];
if ($count > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}
if ($page > $total_pages)
    $page = $total_pages;
if ($limit < 0)
    $limit = 0;
$start = $limit * $page - $limit; // do not put $limit*($page - 1)
if ($start < 0)
    $start = 0;


if ($buscar == "true") {
    $compras = $db->sql_query("SELECT depositos.* FROM depositos WHERE cliente LIKE '%$_REQUEST[solicito]%' AND concepto = 'COMPRA' AND estatus = 1 AND DATE(fechaAut) >= '$inicio' AND DATE(fechaAut) <= '$final' LIMIT $start,$limit");
    $totalCompras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE cliente LIKE '%$_REQUEST[solicito]%' AND concepto = 'COMPRA' AND estatus = 1 AND DATE(fechaAut) >= '$inicio' AND DATE(fechaAut) <= '$final'"), 0);
} else {
    if ($usuario != 0) {
        $compras = $db->sql_query("SELECT depositos.*, detalleusuarios.NombreComercial FROM depositos,detalleusuarios WHERE depositos.idUsuario = detalleusuarios.idUsuario AND depositos.idUsuario = $usuario AND concepto = 'COMPRA' AND estatus = 1 AND DATE(fechaAut) >= '$inicio' AND DATE(fechaAut) <= '$final' LIMIT $start,$limit");
        $totalCompras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE depositos.idUsuario = $usuario AND concepto = 'COMPRA' AND estatus = 1 AND DATE(fechaAut) >= '$inicio' AND DATE(fechaAut) <= '$final'"), 0);
    } else {
        $compras = $db->sql_query("SELECT depositos.*, detalleusuarios.NombreComercial FROM depositos,detalleusuarios, relaciones WHERE depositos.idUsuario = detalleusuarios.idUsuario AND depositos.idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND concepto = 'COMPRA' AND estatus = 1 AND DATE(fechaAut) >= '$inicio' AND DATE(fechaAut) <= '$final' LIMIT $start,$limit");
        $totalCompras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos, relaciones WHERE depositos.idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND concepto = 'COMPRA' AND estatus = 1 AND DATE(fechaAut) >= '$inicio' AND DATE(fechaAut) <= '$final'"), 0);
    }
}


@header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
$s .= "<page>" . $page . "</page>";
$s .= "<total>" . $total_pages . "</total>";
$s .= "<records>" . $count . "</records>";
$s .= "<userdata name='fecha'><![CDATA[TOTAL]]></userdata>";
$s .= "<userdata name='monto'>" . $totalCompras . "</userdata>";
// be sure to put text data in CDATA
while ($row = $db->sql_fetch_array($compras)) {
    $s .= "<row>";
    $s .= "<cell><![CDATA[" . date('d-m-Y H:i:s', strtotime($row[fechaAut])) . "]]></cell>";
    $s .= "<cell>" . $row[idUsuario] . "</cell>";
    $s .= "<cell><![CDATA[" . $row[cliente] . "]]></cell>";
    $s .= "<cell><![CDATA[" . $row[banco] . "]]></cell>";
    $s .= "<cell><![CDATA[" . $row[referencia] . "]]></cell>";
    $s .= "<cell>" . $row[monto] . "</cell>";
    $s .= "</row>";
}
$s .= "</rows>";
echo $s;
?>