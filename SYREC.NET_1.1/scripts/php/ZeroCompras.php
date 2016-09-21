<?php
date_default_timezone_set('America/Mexico_City');
include 'conexion.php';

// Get the requested page. By default grid sets this to 1.
$page = $_REQUEST['page'];
// get how many rows we want to have into the grid - rowNum parameter in the grid
//$limit = $_REQUEST['rows'];
// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel
$sidx = $_REQUEST['sidx'];
// sorting order - at first time sortorder
$sord = $_REQUEST['sord'];
$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
if ($totalrows) {
    $limit = $totalrows;//431
}
if (!$sidx)
    $sidx = 1;
$db = new Conexion;
$db->sql_connect();

$result = $db->sql_query("SELECT COUNT(*) AS count FROM detalleusuarios WHERE idUsuario != 1 AND idUsuario != 2");
$data = $db->sql_fetch_array($result);
$count = $data['count'];
// calculate the total pages for the query
if ($count > 0 && $limit > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}
// if for some reasons the requested page is greater than the total
// set the requested page to total page
if ($page > $total_pages)
    $page = $total_pages;
// calculate the starting position of the rows
$start = $limit * $page - $limit;
// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page
if ($start < 0)
    $start = 0;

// Se obtiene los datos personales DATE_FORMAT( FechaRegistro -  INTERVAL 1 HOUR , '%d-%m-%Y %H:%i:%s' )

//Borrado de datos
$treintadias= date('Y-m-d', strtotime('-30 days'));
$borrado = "DELETE usuarios FROM usuarios, detalleusuarios WHERE usuarios.idUsuario = detalleusuarios.idUsuario AND `FechaRegistro` = '2011-03-17 00:47:31'";

$SQL = "SELECT  detalleusuarios.idUsuario, `NombreComercial`, Usuario, TelFijo, MAX(fechaAut) as Fecha, FechaRegistro
FROM `detalleusuarios`
LEFT JOIN depositos ON detalleusuarios.idUsuario = depositos.idUsuario
LEFT JOIN usuarios ON usuarios.idUsuario = detalleusuarios.idUsuario
GROUP BY detalleusuarios.idUsuario
ORDER BY
$sidx $sord LIMIT $start, $limit";

/* Habilitar o Deshabilitar toda la red */
$datosPersonales = $db->sql_query($SQL);
// we should set the appropriate header information. Do not forget this.
header("Content-type: text/xml;charset=utf-8");
$s = "<?xml version='1.0' encoding='utf-8'?>";
$s .= "<rows>";
$s .= "<page>" . $page . "</page>";
$s .= "<total>" . $total_pages . "</total>";
$s .= "<records>" . $count . "</records>";
// be sure to put text data in CDATA
while ($row = $db->sql_fetch_array($datosPersonales)) {
    $s .= "<row id='" . $row[idUsuario] . "'>";
    $s .= "<cell>" . trim($row[idUsuario]) . "</cell>";
    $s .= "<cell><![CDATA[" . trim($row[NombreComercial]) . "]]></cell>";
    $s .= "<cell><![CDATA[" . trim($row[Usuario]) . "]]></cell>";
    $s .= "<cell><![CDATA[" . trim($row[TelFijo]) . "]]></cell>";
    $s .= "<cell><![CDATA[" . trim($row[FechaRegistro]) . "]]></cell>";
    $s .= "<cell><![CDATA[" . trim($row[Fecha]) . "]]></cell>";
    $s .= "</row>";
}
$s .= "</rows>";
echo $s;
$db->sql_close();
?>