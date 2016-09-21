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
$id = $_REQUEST['idUsr']; //get id User
$agente = $_REQUEST['usuario'];

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

$result = $db->sql_query("SELECT COUNT( * ) AS count FROM detalleusuarios");

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

$redAgentes = $db->sql_query("SELECT SUM(monto) as Total_Ventas,SUM(comision) as Total_Comision, SUM(comision)*.1 AS Total_ComisionGenerada FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier NOT LIKE 'AJUSTE COMISION%' AND agente = '$agente' AND DATE(fecha)>='$inicio' AND DATE(fecha)<='$final'");
$row = $db->sql_fetch_array($redAgentes);
header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
$s .= "<page>" . $page . "</page>";
$s .= "<total>" . $total_pages . "</total>";
$s .= "<records>" . $count . "</records>";
// be sure to put text data in CDATA
$s .= "<row>";
$s .= "<cell>" . $row[Total_Ventas] . "</cell>";
$s .= "<cell>" . $row[Total_Comision] . "</cell>";
$s .= "<cell>" . $row[Total_ComisionGenerada] . "</cell>";
$s .= "</row>";
$s .= "</rows>";
echo $s;
?>
