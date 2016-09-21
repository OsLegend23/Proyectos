<?php 
date_default_timezone_set('America/Mexico_City');
include 'conexion.php';

// Get the requested page. By default grid sets this to 1.
$page = $_REQUEST['page'];
// get how many rows we want to have into the grid - rowNum parameter in the grid
$limit = $_REQUEST['rows'];
// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel
$sidx = $_REQUEST['sidx'];
// sorting order - at first time sortorder
$sord = $_REQUEST['sord'];
//Campo de búsqueda
$searchField = $_REQUEST['searchField'];
//Cadena a buscar
$searchString = utf8_decode($_REQUEST['searchString']);
//Arreglo para los valores de búsqueda
$operadores = array('cn'=>"LIKE '%$searchString%'", 'bw'=>"LIKE '$searchString%'", 'ew'=>"LIKE '%$searchString'", 'lt'=>"< '$searchString'", 'le'=>"<= '$searchString'", 'gt'=>"> '$searchString'", 'ge'=>">= '$searchString'");
//Operador de búsqueda
$searchOper = $operadores[$_REQUEST['searchOper']];
//Datos a editar
$oper = $_POST['oper'];
$id = $_REQUEST['id'];
$idUsr = $_REQUEST['idUsr'];
$estatus = $_POST['estatus'];
// if we not pass at first time index use the first column for the index or what you want
if (!$sidx)
    $sidx = 1;
// connect to the MySQL database server
$db = new Conexion;
$db->sql_connect();
// calculate the number of rows for the query. We need this for paging the result
$result = $db->sql_query("SELECT COUNT(*) AS count FROM cajero,relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr");
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
$SQL = "SELECT * FROM usuarios, cajero, relaciones WHERE
usuarios.idUsuario = cajero.idUsuario AND usuarios.idUsuario =  relaciones.idUsuarioHijo AND
relaciones.idUsuarioPadre =  $idUsr
ORDER BY
cajero.$sidx $sord LIMIT $start, $limit";

if ($oper == 'edit') {
	$idUsrCajero = $db->sql_result($db->sql_query("SELECT idUsuario FROM cajero WHERE idCajero = $id"), 0);
    $db->sql_query("UPDATE usuarios SET Status = $estatus, intentos = 0 WHERE idUsuario = $idUsrCajero");
    return false;
}


$datosPersonales = $db->sql_query($SQL);
// we should set the appropriate header information. Do not forget this.
header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
// be sure to put text data in CDATA
while ($row = $db->sql_fetch_array($datosPersonales)) {
    $s .= "<row id='".$row[idCajero]."'>";
    $s .= "<cell><![CDATA[".trim($row[nombreCajero])."]]></cell>";
    $s .= "<cell><![CDATA[".trim($row[celular])."]]></cell>";
    $s .= "<cell><![CDATA[".trim($row[telefono])."]]></cell>";
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
