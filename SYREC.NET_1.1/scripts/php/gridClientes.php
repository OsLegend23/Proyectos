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
    $limit = $totalrows;
}
//Campo de búsqueda
$searchField = $_REQUEST['searchField'];
//Cadena a buscar
$searchString = utf8_decode($_REQUEST['searchString']);
//Arreglo para los valores de búsqueda
$operadores = array('cn' => "LIKE '%$searchString%'", 'bw' => "LIKE '$searchString%'", 'ew' => "LIKE '%$searchString'", 'lt' => "< '$searchString'", 'le' => "<= '$searchString'", 'gt' => "> '$searchString'", 'ge' => ">= '$searchString'");
//Operador de búsqueda
$searchOper = $operadores[$_REQUEST['searchOper']];
//Datos a editar
$oper = $_POST['oper'];
$id = $_REQUEST['id'];
$idUsr = $_REQUEST['idUsr'];
$NombreComercial = $_REQUEST['NombreComercial'];
$email = $_REQUEST['email'];
$celular = $_REQUEST['celular'];
$ciudad = $_REQUEST['ciudad'];
$Responsable = $_REQUEST['Responsable'];
$estado = $_REQUEST['estado'];
$telefono = $_REQUEST['telefono'];
$estatus = $_POST['estatus'];
// if we not pass at first time index use the first column for the index or what you want
if (!$sidx)
    $sidx = 1;
// connect to the MySQL database server
$db = new Conexion;
$db->sql_connect();
// calculate the number of rows for the query. We need this for paging the result
$result = $db->sql_query("SELECT COUNT(*) AS count FROM usuarios,relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND usuarios.Status = 1");
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
$SQL = "SELECT
detalleusuarios.idUsuario,
detalleusuarios.NombreComercial,
DATE_FORMAT(detalleusuarios.FechaRegistro, '%d-%m-%Y %H:%i:%s') AS FechaRegistro,
detalleusuarios.Responsable,
detalleusuarios.Ciudad,
detalleusuarios.Estado,
detalleusuarios.TelFijo,
detalleusuarios.TelMobil,
detalleusuarios.rfc,
usuarios.`Status`,
usuarios.Usuario
FROM
detalleusuarios ,
relaciones ,
usuarios
WHERE
detalleusuarios.idUsuario =  relaciones.idUsuarioHijo AND
usuarios.idUsuario =  detalleusuarios.idUsuario AND
usuarios.Status = 1 AND
relaciones.idUsuarioPadre =  $idUsr
ORDER BY
detalleusuarios.$sidx $sord LIMIT $start, $limit";

/* Habilitar o Deshabilitar toda la red */
if ($oper == 'edit') {
    $db->sql_query("UPDATE detalleusuarios 
	SET NombreComercial = '$NombreComercial', Responsable = '$Responsable', Ciudad = '$ciudad',Estado='$estado', TelFijo='$telefono',TelMobil='$celular'
	WHERE idUsuario=$id");
    $db->sql_query("UPDATE usuarios SET Status = $estatus, Usuario = '$email', intentos = 0 WHERE idUsuario = $id");
    $db->sql_query("UPDATE usuarios, relaciones SET usuarios.Status = $estatus WHERE usuarios.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $id");
    return false;
}
$totalRed = $db->sql_result($db->sql_query("SELECT SUM(saldoActual) FROM saldos, relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr"), 0);
$totalComercios = $db->sql_result($db->sql_query("SELECT SUM( saldoActual ) FROM `saldos` WHERE idUsuario NOT IN (SELECT idUsuario FROM saldos, relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre =$idUsr) AND idUsuario != $idUsr"), 0);
$datosPersonales = $db->sql_query($SQL);
// we should set the appropriate header information. Do not forget this.
header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
$s .= "<userdata name='FechaRegistro'>SALDO FRANQUICIA</userdata>";
$s .= "<userdata name='email'>$ " . number_format($totalRed, 2) . "</userdata>";
$s .= "<userdata name='estado'>SALDO COMERCIO</userdata>";
$s .= "<userdata name='telefono'>$ " . number_format($totalComercios, 2) . "</userdata>";
$s .= "<page>" . $page . "</page>";
$s .= "<total>" . $total_pages . "</total>";
$s .= "<records>" . $count . "</records>";
// be sure to put text data in CDATA
while ($row = $db->sql_fetch_array($datosPersonales)) {
    $s .= "<row id='" . $row[idUsuario] . "'>";
    $s .= "<cell>" . trim($row[idUsuario]) . "</cell>";
    $s .= "<cell><![CDATA[" . trim($row[NombreComercial]) . "]]></cell>";
    $s .= "<cell><![CDATA[" . trim($row[Responsable]) . "]]></cell>";
    $s .= "<cell><![CDATA[" . trim($row[FechaRegistro]) . "]]></cell>";
    $s .= "<cell><![CDATA[" . trim($row[Usuario]) . "]]></cell>";
    $s .= "<cell><![CDATA[" . trim($row[Ciudad]) . "]]></cell>";
    $s .= "<cell><![CDATA[" . trim($row[Estado]) . "]]></cell>";
    $s .= "<cell>" . trim($row[TelFijo]) . "</cell>";
    $s .= "<cell>" . trim($row[TelMobil]) . "</cell>";
    $s .= "<cell><![CDATA[" . trim($row[rfc]) . "]]></cell>";
    if ($row[Status] == 1) {
        $s .= "<cell><![CDATA[<img src='images/Enable-User.png' alt='Habilitado' style='float:none;' />]]></cell>";
    } else {
        $s .= "<cell><![CDATA[<img src='images/Disable-User.png' alt='Habilitado' style='float:none;' />]]></cell>";
    }
    $s .= "</row>";
}
$s .= "</rows>";
echo $s;
?>
