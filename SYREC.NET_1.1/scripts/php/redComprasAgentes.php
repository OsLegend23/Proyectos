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
/*Asignamos la fecha de inicio de la consulta*/
if (isset($_GET["inicio"]))
    $inicio = $_GET['inicio'];
else
    $inicio = date('Y-m-d');
/*Asignamos la fecha de final de la consulta*/
if (isset($_GET["final"]))
    $final = $_GET["final"];
else
    $final = date('Y-m-d');
/*Asignamos al usuario de la consulta*/
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
    
$redAgentes = $db->sql_query("SELECT agente, SUM( compras.monto ) AS Total_Compras FROM detalleusuarios LEFT JOIN compras ON detalleusuarios.idUsuario = compras.idUsuario AND DATE( compras.fecha ) >= '$inicio' AND DATE( compras.fecha ) <= '$final' GROUP BY detalleusuarios.agente LIMIT $start,$limit");
$comprasTotales = $db->sql_result($db->sql_query("SELECT SUM(monto) as Total_Compras FROM `compras`, detalleusuarios WHERE compras.idUsuario = detalleusuarios.idUsuario AND DATE(fecha)>='$inicio' AND DATE(fecha)<='$final'"),0);

header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
// be sure to put text data in CDATA
$s .= "<userdata name='compras_red'>".$comprasTotales."</userdata>";
while ($row = $db->sql_fetch_array($redAgentes)) {
    $s .= "<row>";
    $s .= "<cell><![CDATA[".$row[agente]."]]></cell>";
    $s .= "<cell>".$row[Total_Compras]."</cell>";
    $s .= "</row>";
}
$s .= "</rows>";
echo $s;
?>
