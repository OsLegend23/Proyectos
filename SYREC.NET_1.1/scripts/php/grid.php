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
$sord = $_GET['sord'];
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
$result = $db->sql_query("SELECT COUNT(*) AS count FROM usuarios");
$row = $db->sql_fetch_array($result);
$count = $row['count'];
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
    
$fecha = date("Y-m-d");
// Se obtiene los datos personales
$SQL = "SELECT
detalleusuarios.NombreComercial,
detalleusuarios.FechaRegistro,
usuarios.saldo_inicial,
usuarios.`Status`,
usuarios.idUsuario
FROM
usuarios ,
detalleusuarios ,
relaciones
WHERE
usuarios.idUsuario =  detalleusuarios.idUsuario AND
usuarios.idUsuario =  relaciones.idUsuarioHijo AND
relaciones.idUsuarioPadre =  $idUsr
ORDER BY
usuarios.idUsuario ASC";
//Se obtienen todas la compras
$queryC = "SELECT
Sum(compras.monto) AS totalCompras
FROM
compras ,
relaciones
WHERE
compras.idUsuario =  relaciones.idUsuarioHijo AND
relaciones.idUsuarioPadre =  $idUsr
GROUP BY
compras.idUsuario
ORDER BY
compras.idUsuario ASC";
/*Ventas totales*/
$queryV = "SELECT
Sum(ventas.monto) AS totalVentas,
Sum(ventas.comision) AS totalComision
FROM
ventas ,
relaciones
WHERE
ventas.idUsuario =  relaciones.idUsuarioHijo AND
relaciones.idUsuarioPadre =  $idUsr
GROUP BY
ventas.idUsuario
ORDER BY
ventas.idUsuario ASC";
/*Todos los cargos del fulano*/
$queryCar = "SELECT
Sum(cargos.monot) AS totalCargos
FROM
cargos ,
relaciones
WHERE
cargos.idUsuario =  relaciones.idUsuarioHijo AND
relaciones.idUsuarioPadre =  $idUsr
GROUP BY
cargos.idUsuario
ORDER BY
cargos.idUsuario ASC";

/*Habilitar o Deshabilitar toda la red*/
if($oper == 'edit'){
	$db->sql_query("UPDATE usuarios SET Status = $estatus WHERE idUsuario = $id");
	$db->sql_query("UPDATE usuarios, relaciones SET usuarios.Status = $estatus WHERE usuarios.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $id");
	return false;
}

$result = $db->sql_query($SQL);
$compras = $db->sql_query($queryC);
$ventas = $db->sql_query($queryV);
$cargos = $db->sql_query($queryCar);

$resultadoCompras = $db->sql_num_rows($compras);
$resultadoVentas = $db->sql_num_rows($ventas);
$resultadoCargos = $db->sql_num_rows($cargos);

// we should set the appropriate header information. Do not forget this.
header("Content-type: text/xml;charset=iso-8859-1");
$s = "<?xml version='1.0' encoding='iso-8859-1'?>";
$s .= "<rows>";
$s .= "<page>".$page."</page>";
$s .= "<total>".$total_pages."</total>";
$s .= "<records>".$count."</records>";
// be sure to put text data in CDATA
if (($resultadoCompras==0)AND($resultadoVentas==0)AND($resultadoCargos==0)) {
    while ($row = $db->sql_fetch_array($result)) {
        $s .= "<row id='".$row[idUsuario]."'>";
        $s .= "<cell><![CDATA[".$row[NombreComercial]."]]></cell>";
        $s .= "<cell><![CDATA[".$row[FechaRegistro]."]]></cell>";
        $s .= "<cell>".$row[saldo_inicial]."</cell>";
		$s .= "<cell>0</cell>";
    	$s .= "<cell>0</cell>";
    	$s .= "<cell>0</cell>";
    	$s .= "<cell>0</cell>";
    	$s .= "<cell>".$row[saldo_inicial]."</cell>";
		if($row[Status]==1){
			$s .= "<cell><![CDATA[<img src='images/Enable-User.png' alt='Habilitado' style='float:none;' />]]></cell>";	
		}else{
			$s .= "<cell><![CDATA[<img src='images/Disable-User.png' alt='Habilitado' style='float:none;' />]]></cell>";
		}
    	$s .= "</row>";
    }
}elseif(($resultadoVentas==0)AND($resultadoCargos==0)){
	while (($row = $db->sql_fetch_array($result)) AND ($row1 = $db->sql_fetch_array($compras))) {
        $s .= "<row id='".$row[idUsuario]."'>";
        $s .= "<cell><![CDATA[".$row[NombreComercial]."]]></cell>";
        $s .= "<cell><![CDATA[".$row[FechaRegistro]."]]></cell>";
        $s .= "<cell>".$row[saldo_inicial]."</cell>";
		$s .= "<cell>".$row1[totalCompras]."</cell>";
    	$s .= "<cell>0</cell>";
    	$s .= "<cell>0</cell>";
    	$s .= "<cell>0</cell>";
    	$s .= "<cell>".($row[saldo_inicial]+$row1[totalCompras])."</cell>";
    	if($row[Status]==1){
			$s .= "<cell><![CDATA[<img src='images/Enable-User.png' alt='Habilitado' style='float:none;' />]]></cell>";	
		}else{
			$s .= "<cell><![CDATA[<img src='images/Disable-User.png' alt='Habilitado' style='float:none;' />]]></cell>";
		}
    	$s .= "</row>";
    }
}elseif($resultadoCargos==0){
	while (($row = $db->sql_fetch_array($result)) AND ($row1 = $db->sql_fetch_array($compras)) AND ($row2 = $db->sql_fetch_array($ventas))) {
        $s .= "<row id='".$row[idUsuario]."'>";
        $s .= "<cell><![CDATA[".$row[NombreComercial]."]]></cell>";
        $s .= "<cell><![CDATA[".$row[FechaRegistro]."]]></cell>";
        $s .= "<cell>".$row[saldo_inicial]."</cell>";
		$s .= "<cell>".$row1[totalCompras]."</cell>";
    	$s .= "<cell>".$row2[totalVentas]."</cell>";
    	$s .= "<cell>".$row2[totalComsion]."</cell>";
    	$s .= "<cell>0</cell>";
    	$s .= "<cell>".(($row[saldo_inicial]+$row1[totalCompras]+$row2[totalComsion])-$row2[totalVentas])."</cell>";
		if($row[Status]==1){
			$s .= "<cell><![CDATA[<img src='images/Enable-User.png' alt='Habilitado' style='float:none;' />]]></cell>";	
		}else{
			$s .= "<cell><![CDATA[<img src='images/Disable-User.png' alt='Habilitado' style='float:none;' />]]></cell>";
		}
    	$s .= "</row>";
    }
}else{
	while (($row = $db->sql_fetch_array($result)) AND ($row1 = $db->sql_fetch_array($compras)) AND ($row2 = $db->sql_fetch_array($ventas)) AND ($row3 = $db->sql_fetch_array($cargos))) {
	    $s .= "<row id='".$row[idUsuario]."'>";
	    $s .= "<cell><![CDATA[".$row[NombreComercial]."]]></cell>";
	    $s .= "<cell><![CDATA[".$row[FechaRegistro]."]]></cell>";
	    $s .= "<cell>".$row[saldo_inicial]."</cell>";
	    $s .= "<cell>".$row1[totalCompras]."</cell>";
	    $s .= "<cell>".$row2[totalVentas]."</cell>";
	    $s .= "<cell>".$row2[totalComision]."</cell>";
	    $s .= "<cell>".$row3[totalCargos]."</cell>";
	    $s .= "<cell>".(($row[saldo_inicial]+$row1[totalCompras]+$row2[totalComsion])-($row2[totalVentas]+$row3[totalCargos]))."</cell>";
	    if($row[Status]==1){
			$s .= "<cell><![CDATA[<img src='images/Enable-User.png' alt='Habilitado' style='float:none;' />]]></cell>";	
		}else{
			$s .= "<cell><![CDATA[<img src='images/Disable-User.png' alt='Habilitado' style='float:none;' />]]></cell>";
		}
	    $s .= "</row>";
	}	
}
$s .= "</rows>";
echo $s;
?>
