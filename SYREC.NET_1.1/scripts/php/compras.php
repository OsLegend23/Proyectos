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
$carrier = $_REQUEST['carrier']; //Carrier

if (!$sidx)
    $sidx = 1;
/* Asignamos la fecha de inicio de la consulta */
if (isset($_GET["inicio"]))
    $inicio = $_GET['inicio'];
else
    $inicio = date('Y-m-d');;
/* Asignamos la fecha de final de la consulta */
if (isset($_GET["final"]))
    $final = $_GET["final"];
else
    $final = date('Y-m-d');;
/* Asignamos al usuario de la consulta */
if (isset($_GET["usuario"]))
    $usuario = $_GET['usuario'];
else
    $usuario = "";

$result = $db->sql_query("SELECT COUNT(*) AS count FROM depositos WHERE idUsuario = $idUsr AND estatus = 1 AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ");

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


$query = $db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = \"" . mysql_real_escape_string($idUsr) . "\"");
$Perfil = $db->sql_fetch_array($query);

if ($Perfil['idPerfil'] == 1) {
    $compras = $db->sql_query("SELECT fecha,banco,SUBSTRING_INDEX(referencia,'-',-2) AS referencia,monto, SUBSTRING_INDEX(referencia,'-',1) AS carrier FROM depositos WHERE idUsuario = 1 AND estatus = 1 AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' AND referencia LIKE '%$carrier%' LIMIT $start,$limit");
    $suma = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE idUsuario = 1 AND estatus = 1 AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' AND referencia LIKE '%$carrier%' LIMIT $start,$limit"),0);
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    $s .= "<records>" . $count . "</records>";
    $s .= "<userdata name='monto'>" . $suma . "</userdata>";
    while ($row = $db->sql_fetch_array($compras)) {
        $s .= "<row>";
        $s .= "<cell><![CDATA[" . $row[fecha] . "]]></cell>";
        $s .= "<cell><![CDATA[" . $row[carrier] . "]]></cell>";
        $s .= "<cell><![CDATA[" . $row[banco] . "]]></cell>";
        $s .= "<cell><![CDATA[" . $row[referencia] . "]]></cell>";
        $s .= "<cell>" . $row[monto] . "</cell>";
        $s .= "</row>";
    }
    $s .= "</rows>";
    echo $s;
}
if ($Perfil['idPerfil'] == 2) {
    $compras = $db->sql_query("SELECT * FROM depositos WHERE idUsuario = $idUsr AND concepto = 'COMPRA' AND estatus = 1 AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' LIMIT $start,$limit");
    $suma = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE idUsuario = $idUsr AND concepto = 'COMPRA' AND estatus = 1 AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' LIMIT $start,$limit"),0);
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    $s .= "<records>" . $count . "</records>";
    $s .= "<userdata name='monto'>" . $suma . "</userdata>";
    while ($row = $db->sql_fetch_array($compras)) {
        $s .= "<row>";
        $s .= "<cell><![CDATA[" . $row[fecha] . "]]></cell>";
        $s .= "<cell><![CDATA[TODOS]]></cell>";
        $s .= "<cell><![CDATA[" . $row[banco] . "]]></cell>";
        $s .= "<cell><![CDATA[" . $row[referencia] . "]]></cell>";
        $s .= "<cell>" . $row[monto] . "</cell>";
        $s .= "</row>";
    }
    $s .= "</rows>";
    echo $s;
}
?>