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

$result = $db->sql_query("SELECT COUNT(*) AS count FROM ventas");

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

$perfil = $db->sql_result($db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = $idUsr"), 0);
if ($perfil == 3) {
    $ventas = $db->sql_query("SELECT * FROM ventas WHERE idUsuario = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY $sidx $sord");
} else {
    if ($usuario != 0) {
        $ventas = $db->sql_query("SELECT * FROM ventas WHERE idUsuario = $usuario AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY $sidx $sord");
    } else {
        $ventas = $db->sql_query("SELECT * FROM ventas, relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY $sidx $sord");
    }
}
header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
$s .= "<page>" . $page . "</page>";
$s .= "<total>" . $total_pages . "</total>";
$s .= "<records>" . $count . "</records>";
// be sure to put text data in CDATA
while ($row = $db->sql_fetch_array($ventas)) {
    $s .= "<row>";
    $s .= "<cell><![CDATA[" . $row[fecha] . "]]></cell>";
    $s .= "<cell><![CDATA[" . $row[carrier] . "]]></cell>";
    $s .= "<cell>" . $row[destino] . "</cell>";
    $s .= "<cell>" . $row[comision] . "</cell>";
    $s .= "<cell>" . trim($row[autorizacion]) . "</cell>";
    $s .= "</row>";
}
$s .= "</rows>";
echo $s;
?>
