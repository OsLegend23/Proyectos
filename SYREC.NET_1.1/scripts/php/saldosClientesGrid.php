<?php
include 'conexion.php';
date_default_timezone_set('America/Mexico_City');
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
$operadores = array('cn' => "LIKE '%$searchString%'", 'bw' => "LIKE '$searchString%'", 'ew' => "LIKE '%$searchString'", 'lt' => "< '$searchString'", 'le' => "<= '$searchString'", 'gt' => "> '$searchString'", 'ge' => ">= '$searchString'");
//Operador de búsqueda
$searchOper = $operadores[$_REQUEST['searchOper']];
// if we not pass at first time index use the first column for the index or what you want
if (!$sidx)
    $sidx = 1;
// connect to the MySQL database server
$db = new Conexion;
$db->sql_connect();
$id = $_REQUEST['idUsr'];
$fecha = date('Y-m-d');
//Consulta para obtener el perfil de usuario
$tipo = $db->sql_result($db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = $id"), 0);
$db->sql_free_result($tipo);
if ($tipo == 2) {
    // calculate the number of rows for the query. We need this for paging the result
    $result = $db->sql_query("SELECT NombreComercial, saldo_inicial, saldoActual FROM detalleusuarios LEFT JOIN usuarios ON detalleusuarios.idUsuario = usuarios.idUsuario JOIN saldos ON detalleusuarios.idUsuario = saldos.idUsuario WHERE detalleusuarios.idUsuario != 1 AND detalleusuarios.idUsuario != 2 ORDER BY detalleusuarios.idUsuario");
    $data = $db->sql_num_rows($result);
    $count = $data;
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

    $saldos = $db->sql_query("SELECT NombreComercial, saldo_inicial, saldoActual FROM detalleusuarios LEFT JOIN usuarios ON detalleusuarios.idUsuario = usuarios.idUsuario JOIN saldos ON detalleusuarios.idUsuario = saldos.idUsuario WHERE detalleusuarios.idUsuario != 1 AND detalleusuarios.idUsuario != 2 ORDER BY $sidx $sord LIMIT $start,$limit");
    $totalSaldos = $db->sql_fetch_array($db->sql_query("SELECT SUM(saldo_inicial) AS TotalInicial, SUM(saldoActual) AS TotalActual FROM detalleusuarios LEFT JOIN usuarios ON detalleusuarios.idUsuario = usuarios.idUsuario JOIN saldos ON detalleusuarios.idUsuario = saldos.idUsuario WHERE detalleusuarios.idUsuario != 1 AND detalleusuarios.idUsuario != 2"));
    $db->sql_free_result($totalSaldos);
    //Consulta de ventas para la Franquicia.
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<userdata name='NombreComercial'>SALDO FRANQUICIA</userdata>";
    $s .= "<userdata name='saldoIncial'>$ " . number_format($totalSaldos[TotalInicial], 2) . "</userdata>";
    $s .= "<userdata name='saldo_actual'>$ " . number_format($totalSaldos[TotalActual], 2) . "</userdata>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    $s .= "<records>" . $count . "</records>";
    while ($row = $db->sql_fetch_array($saldos)) {
        $s .= "<row>";
        $s .= "<cell><![CDATA[" . $row[NombreComercial] . "]]></cell>";
        $s .= "<cell>$ " . number_format($row[saldo_inicial], 2, '.', ',') . "</cell>";
        $s .= "<cell>$ " . number_format($row[saldoActual], 2, '.', ',') . "</cell>";
        $s .= "</row>";
    }
    $s .= "</rows>";
    echo $s;
    $db->sql_close();
}
if ($tipo == 3) {
    $ventas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE idUsuario = $id AND DATE(fecha)='$fecha'"), 0);
}
/* CREATE VIEW detalleCompras AS
  (SELECT detalleusuarios.idUsuario, SUM(compras.monto) AS COMPRAS FROM detalleusuarios,compras WHERE detalleusuarios.idUsuario = compras.idUsuario AND DATE(compras.fecha) <= DATE_ADD( CURDATE( ) , INTERVAL -1 DAY ) GROUP BY detalleusuarios.idUsuario)

  SELECT detalleVentasAnt.idUsuario,detalleVentasAnt.NombreComercial, COMPRAS_ANT+COMISION_ANT-VENTAS_ANT AS SALDO_INICIAL, COMPRAS, VENTAS_HOY, COMISION_HOY
  FROM detalleVentasAnt JOIN detalleVentasHoy ON detalleVentasAnt.idUsuario = detalleVentasHoy.idUsuario JOIN detalleComprasAnt ON detalleVentasAnt.idUsuario = detalleComprasAnt.idUsuario JOIN detalleComprasHoy ON detalleVentasAnt.idUsuario = detalleComprasHoy.idUsuario


  CREATE VIEW detalleVentasAnt AS
  (SELECT detalleusuarios.idUsuario, detalleusuarios.NombreComercial, SUM(ventas.monto) AS VENTAS_ANT, SUM(ventas.comision) AS COMISION_ANT FROM detalleusuarios,ventas WHERE detalleusuarios.idUsuario = ventas.idUsuario AND DATE(ventas.fecha) <= DATE_ADD( CURDATE( ) , INTERVAL -1 DAY ) GROUP BY detalleusuarios.idUsuario)
  CREATE VIEW saldosComercios AS (
  SELECT
  NombreComercial, comprasAyer.comprasAyer+comisionesAyer.comisionAyer-ventasAyer.ventasAyer AS SALDO_INICIAL,
  (SELECT SUM(monto) FROM compras WHERE DATE(fecha) = CURDATE() AND compras.idUsuario = comprasAyer.idUsuario) AS COMPRAS,
  (SELECT SUM(monto) FROM ventas WHERE DATE(fecha) = CURDATE() AND ventas.idUsuario = comprasAyer.idUsuario) AS VENTAS,
  (SELECT SUM(comision) FROM ventas WHERE DATE(fecha) = CURDATE() AND ventas.idUsuario = comprasAyer.idUsuario) AS COMISION
  FROM
  comisionesAyer,comprasAyer, ventasAyer, detalleusuarios
  WHERE
  comisionesAyer.idUsuario = comprasAyer.idUsuario
  AND comisionesAyer.idUsuario = ventasAyer.idUsuario
  AND comisionesAyer.idUsuario = detalleusuarios.idUsuario
  ORDER BY `detalleusuarios`.`NombreComercial` ASC)
 */
?>
