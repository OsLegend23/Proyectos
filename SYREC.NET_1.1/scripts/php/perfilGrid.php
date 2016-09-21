<?php 
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
$id = $_REQUEST['id'];
// if we not pass at first time index use the first column for the index or what you want
if (!$sidx)
    $sidx = 1;
// connect to the MySQL database server
$db = new Conexion;
$db->sql_connect();
// calculate the number of rows for the query. We need this for paging the result
$result = $db->sql_query("SELECT COUNT(*) AS count FROM usuarios WHERE idUsuario = $id");
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
$SQL = "SELECT *,DATE_FORMAT( DATE( FechaRegistro ) , '%d/%m/%Y' ) AS Fecha
FROM
detalleusuarios
WHERE
detalleusuarios.idUsuario =  $id";

/*Habilitar o Deshabilitar toda la red*/
if ($oper == 'edit') {
    $db->sql_query("UPDATE detalleusuarios 
	SET NombreComercial = '$NombreComercial', Responsable = '$Responsable', Ciudad = '$ciudad',Estado='$estado', TelFijo='$telefono',TelMobil='$celular'
	WHERE idUsuario=$id");
    $db->sql_query("UPDATE usuarios SET Status = $estatus, Usuario = '$email', intentos = 0 WHERE idUsuario = $id");
    $db->sql_query("UPDATE usuarios, relaciones SET usuarios.Status = $estatus WHERE usuarios.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $id");
    return false;
}
$datosPersonales = $db->sql_fetch_array($db->sql_query($SQL));
// we should set the appropriate header information. Do not forget this.
@header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
	$s .= "<page>".$page."</page>";
	$s .= "<total>".$total_pages."</total>";
	//$s .= "<records>".$count."</records>";
	// be sure to put text data in CDATA
	$s .= "<row>";
		$s .= "<cell><![CDATA[<strong>NOMBRE:</strong>]]></cell>";
		$s .= "<cell><![CDATA[".trim($datosPersonales[Responsable])."]]></cell>";
	$s .= "</row>";
	$s .= "<row>";
		$s .= "<cell><![CDATA[<strong>NOMBRE COMERCIAL:</strong>]]></cell>";
		$s .= "<cell><![CDATA[".trim($datosPersonales[NombreComercial])."]]></cell>";
	$s .= "</row>";
	$s .= "<row>";
		$s .= "<cell><![CDATA[<strong>DIRECCION:</strong>]]></cell>";
		$s .= "<cell><![CDATA[".trim($datosPersonales[Domicilio])." ".trim($datosPersonales[colonia])."]]></cell>";
	$s .= "</row>";
	$s .= "<row>";
		$s .= "<cell><![CDATA[<strong>CIUDAD:</strong>]]></cell>";
		$s .= "<cell><![CDATA[".trim($datosPersonales[Ciudad])."]]></cell>";
	$s .= "</row>";
	$s .= "<row>";
		$s .= "<cell><![CDATA[<strong>ESTADO:</strong>]]></cell>";
		$s .= "<cell><![CDATA[".trim($datosPersonales[Estado])."]]></cell>";
	$s .= "</row>";
	$s .= "<row>";
		$s .= "<cell><![CDATA[<strong>TELEFONO:</strong>]]></cell>";
		$s .= "<cell>".trim($datosPersonales[TelFijo])."</cell>";
	$s .= "</row>";
	$s .= "<row>";
		$s .= "<cell><![CDATA[<strong>CELULAR:</strong>]]></cell>";
		$s .= "<cell>".trim($datosPersonales[TelMobil])."</cell>";
	$s .= "</row>";
	$s .= "<row>";
		$s .= "<cell><![CDATA[<strong>MIEMBRO DESDE:</strong>]]></cell>";
		$s .= "<cell>".trim($datosPersonales[Fecha])."</cell>";
	$s .= "</row>";
$s .= "</rows>";

echo $s;
?>
