<?php

date_default_timezone_set('America/Mexico_City');
include 'conexion.php';
$db = new Conexion;
$db->sql_connect();
//ini_set('max_execution_time', 600);
$page = $_REQUEST['page']; // get the requested page
$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
$sord = $_REQUEST['sord']; // get the direction
//$idUsr = $_REQUEST['idUsr']; //get id User

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

$result = $db->sql_query("SELECT COUNT(*) AS count FROM detalleusuarios JOIN ventas ON detalleusuarios.idUsuario = ventas.idUsuario WHERE detalleusuarios.idUsuario != 1 AND detalleusuarios.idUsuario != 2 AND DATE(fecha) <= '$final' AND DATE(fecha) >= '$inicio' GROUP BY detalleusuarios.idUsuario");

$row = $db->sql_num_rows($result);
$count = $row;
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

$comisiones = $db->sql_query("SELECT detalleusuarios.idUsuario, NombreComercial, SUM(comision) as COMISION FROM detalleusuarios JOIN ventas ON detalleusuarios.idUsuario = ventas.idUsuario WHERE detalleusuarios.idUsuario != 1 AND detalleusuarios.idUsuario != 2 AND DATE(fecha) <= '$final' AND DATE(fecha) >= '$inicio' GROUP BY detalleusuarios.idUsuario ORDER BY $sidx $sord LIMIT $start, $limit");
$sumaComision = $db->sql_result($db->sql_query("SELECT SUM(comision) as COMISION FROM detalleusuarios JOIN ventas ON detalleusuarios.idUsuario = ventas.idUsuario WHERE detalleusuarios.idUsuario != 1 AND detalleusuarios.idUsuario != 2 AND DATE(fecha) <= '$final' AND DATE(fecha) >= '$inicio'"),0);
header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
$s .= "<userdata name='NombreComercial'>SALDO COMERCIO</userdata>";
$s .= "<userdata name='comision_generada'>" . $sumaComision . "</userdata>";
$s .= "<page>" . $page . "</page>";
$s .= "<total>" . $total_pages . "</total>";
$s .= "<records>" . $count . "</records>";
// be sure to put text data in CDATA
while ($row = $db->sql_fetch_array($comisiones)) {
    $s .= "<row id='" . $row[idUsuario] . "'>";
    $s .= "<cell><![CDATA[" . trim($row[NombreComercial]) . "]]></cell>";
    $s .= "<cell>". trim($row[COMISION]) ."</cell>";
    $s .= "</row>";
}
$s .= "</rows>";
echo $s;
?>
