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

$agente = $db->sql_result($db->sql_query("SELECT NombreComercial FROM detalleusuarios WHERE idUsuario = $idUsr"), 0);
$result = $db->sql_query("SELECT COUNT( * ) AS count FROM detalleusuarios WHERE agente LIKE '$agente'");

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

$redAgentes = $db->sql_query("SELECT NombreComercial, SUM(monto) as Total_Ventas,SUM(comision) as Total_Comision, SUM(comision)*.1 AS Total_ComisionGenerada FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier NOT LIKE 'AJUSTE COMISION%' AND agente = '$agente' AND DATE(fecha)>='$inicio' AND DATE(fecha)<='$final' GROUP BY detalleusuarios.NombreComercial LIMIT $start,$limit");
/* $redAgentes = $db->sql_query("SELECT
  NombreComercial,
  SUM(compras.monto)/COUNT(idCompras) AS Total_Compras,
  SUM(ventas.monto) AS Total_Ventas,
  SUM(comision) AS Total_Comision,
  SUM(comision)*.1 AS Total_ComisionGenerada
  FROM
  detalleusuarios
  LEFT JOIN
  ventas
  ON
  detalleusuarios.idUsuario = ventas.idUsuario
  AND
  (DATE(ventas.fecha)>='$inicio'
  AND DATE(ventas.fecha)<='$final')
  LEFT JOIN
  compras
  ON
  detalleusuarios.idUsuario = compras.idUsuario
  AND
  (DATE(compras.fecha)>='$inicio'
  AND DATE(compras.fecha)<='$final')
  WHERE
  detalleusuarios.agente LIKE '$agente'
  GROUP BY detalleusuarios.NombreComercial"); */
$ventasTotales = $db->sql_result($db->sql_query("SELECT SUM(monto) as Total_Ventas FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND agente = '$agente' AND carrier NOT LIKE 'AJUSTE COMISION%' AND DATE(fecha)>='$inicio' AND DATE(fecha)<='$final'"), 0);
$comisionTotal = $db->sql_result($db->sql_query("SELECT SUM(comision) as Total_Comision FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND agente = '$agente' AND carrier NOT LIKE 'AJUSTE COMISION%' AND DATE(fecha)>='$inicio' AND DATE(fecha)<='$final'"), 0);
$ganaciaTotal = $db->sql_result($db->sql_query("SELECT  SUM(comision)*.1 AS Total_ComisionGenerada FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND agente = '$agente' AND carrier NOT LIKE 'AJUSTE COMISION%' AND DATE(fecha)>='$inicio' AND DATE(fecha)<='$final'"), 0);
@header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
$s .= "<page>" . $page . "</page>";
$s .= "<total>" . $total_pages . "</total>";
$s .= "<records>" . $count . "</records>";
// be sure to put text data in CDATA
$s .= "<userdata name='totalVentas'>" . $ventasTotales . "</userdata>";
$s .= "<userdata name='comision'>" . $comisionTotal . "</userdata>";
$s .= "<userdata name='comisionGanada'>" . $ganaciaTotal . "</userdata>";
while ($row = $db->sql_fetch_array($redAgentes)) {
    $s .= "<row>";
    $s .= "<cell><![CDATA[" . $row[NombreComercial] . "]]></cell>";
    $s .= "<cell>" . $row[Total_Compras] . "</cell>";
    $s .= "<cell>" . $row[Total_Ventas] . "</cell>";
    $s .= "<cell>" . $row[Total_Comision] . "</cell>";
    $s .= "<cell>" . $row[Total_ComisionGenerada] . "</cell>";
    $s .= "</row>";
}
$s .= "</rows>";
echo $s;
?>
