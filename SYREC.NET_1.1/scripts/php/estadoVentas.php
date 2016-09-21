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
/*$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
if ($totalrows) {
    $limit = $totalrows;
}*/

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

$result = $db->sql_query("SELECT COUNT(*) AS count FROM ventas WHERE carrier != 'AJUSTE COMISION' AND idUsuario = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");

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

//COMERCIO
if ($perfil == 3) {
    $cajeros = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM cajero, relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr"),0);
    if ($cajeros > 0) {
        $ventas = $db->sql_query("SELECT *,SUBSTRING_INDEX(carrier,'-',1) as compania FROM ventas,cajero WHERE ventas.idUsuario = $idUsr AND ventas.idCajero = cajero.idCajero AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY $sidx $sord LIMIT $start, $limit");
        header("Content-type: text/xml;charset=iso-8859-1");
        $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $s .= "<rows>";
        $s .= "<page>" . $page . "</page>";
        $s .= "<total>" . $total_pages . "</total>";
        //$s .= "<records>".$count."</records>";
        // be sure to put text data in CDATA
        while ($row = $db->sql_fetch_array($ventas)) {
            $s .= "<row>";
            $s .= "<cell><![CDATA[" . $row[fecha] . "]]></cell>";
            $s .= "<cell><![CDATA[" . $row[compania] . "]]></cell>";
            $s .= "<cell>" . $row[destino] . "</cell>";
            $s .= "<cell>" . $row[monto] . "</cell>";
            $s .= "<cell>" . $row[comision] . "</cell>";
            $s .= "<cell>" . trim($row[autorizacion]) . "</cell>";
            $s .= "<cell>" . trim($row[nombreCajero]) . "</cell>";
            $s .= "</row>";
        }
        $s .= "</rows>";
        echo $s;
    } else {
        $ventas = $db->sql_query("SELECT *,SUBSTRING_INDEX(carrier,'-',1) as compania FROM ventas WHERE idUsuario = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY $sidx $sord LIMIT $start, $limit");
        header("Content-type: text/xml;charset=iso-8859-1");
        $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $s .= "<rows>";
        $s .= "<page>" . $page . "</page>";
        $s .= "<total>" . $total_pages . "</total>";
        //$s .= "<records>".$count."</records>";
        // be sure to put text data in CDATA
        while ($row = $db->sql_fetch_array($ventas)) {
            $s .= "<row>";
            $s .= "<cell><![CDATA[" . $row[fecha] . "]]></cell>";
            $s .= "<cell><![CDATA[" . $row[compania] . "]]></cell>";
            $s .= "<cell>" . $row[destino] . "</cell>";
            $s .= "<cell>" . $row[monto] . "</cell>";
            $s .= "<cell>" . $row[comision] . "</cell>";
            $s .= "<cell>" . trim($row[autorizacion]) . "</cell>";
            $s .= "</row>";
        }
        $s .= "</rows>";
        echo $s;
    }
}

//ADMINISTRADOR
if ($perfil == 1) {
    if ($usuario != 0) {
        $ventas = $db->sql_query("SELECT * FROM ventas, relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $usuario AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY $sidx $sord LIMIT $start, $limit");
        header("Content-type: text/xml;charset=iso-8859-1");
        $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $s .= "<rows>";
        $s .= "<page>" . $page . "</page>";
        $s .= "<total>" . $total_pages . "</total>";
        //$s .= "<records>".$count."</records>";
        // be sure to put text data in CDATA
        while ($row = $db->sql_fetch_array($ventas)) {
            $s .= "<row>";
            $s .= "<cell><![CDATA[" . $row[fecha] . "]]></cell>";
            $s .= "<cell><![CDATA[" . $row[carrier] . "]]></cell>";
            $s .= "<cell>" . $row[destino] . "</cell>";
            $s .= "<cell>" . $row[monto] . "</cell>";
            $s .= "<cell>" . $row[comision] . "</cell>";
            $s .= "<cell>" . trim($row[autorizacion]) . "</cell>";
            $s .= "</row>";
        }
        $s .= "</rows>";
        echo $s;
    } else {
        $ventas = $db->sql_query("SELECT * FROM ventas WHERE carrier NOT LIKE 'AJUSTE COMISION%' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY $sidx $sord LIMIT $start, $limit");
        header("Content-type: text/xml;charset=iso-8859-1");
        $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $s .= "<rows>";
        $s .= "<page>" . $page . "</page>";
        $s .= "<total>" . $total_pages . "</total>";
        //$s .= "<records>".$count."</records>";
        // be sure to put text data in CDATA
        while ($row = $db->sql_fetch_array($ventas)) {
            $s .= "<row>";
            $s .= "<cell><![CDATA[" . $row[fecha] . "]]></cell>";
            $s .= "<cell><![CDATA[" . $row[carrier] . "]]></cell>";
            $s .= "<cell>" . $row[destino] . "</cell>";
            $s .= "<cell>" . $row[monto] . "</cell>";
            $s .= "<cell>" . $row[comision] . "</cell>";
            $s .= "<cell>" . trim($row[autorizacion]) . "</cell>";
            $s .= "</row>";
        }
        $s .= "</rows>";
        echo $s;
    }
}

//FRANQUICIA
if ($perfil == 2) {
    $ventas = $db->sql_query("SELECT NombreComercial, carrier, SUM( monto ) AS TOTAL_MONTO, SUM( comision ) AS TOTAL_COMISION, count( idVenta ) AS TOTAL_VENTAS
							  FROM `ventas` , detalleusuarios, relaciones
							  WHERE ventas.idUsuario = detalleusuarios.idUsuario
							  AND ventas.idUsuario = relaciones.idUsuarioHijo
							  AND idUsuarioPadre = $idUsr
							  AND (DATE( fecha ) >= '$inicio' AND DATE( fecha ) <= '$final')
							  GROUP BY NombreComercial, carrier
							  ORDER BY $sidx $sord LIMIT $start,$limit");

    $total_ventas = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM `ventas`,relaciones WHERE ventas.idUsuario = relaciones.idUsuarioHijo AND idUsuarioPadre = $idUsr AND (DATE( fecha ) >= '$inicio' AND DATE( fecha ) <= '$final')"), 0);
    $total_monto = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM `ventas`,relaciones WHERE ventas.idUsuario = relaciones.idUsuarioHijo AND idUsuarioPadre = $idUsr AND (DATE( fecha ) >= '$inicio' AND DATE( fecha ) <= '$final')"), 0);
    $total_comision = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM `ventas`,relaciones WHERE ventas.idUsuario = relaciones.idUsuarioHijo AND idUsuarioPadre = $idUsr AND (DATE( fecha ) >= '$inicio' AND DATE( fecha ) <= '$final')"), 0);

    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    //$s .= "<records>".$count."</records>";
    // be sure to put text data in CDATA
    $s .= "<userdata name='carrier'>TOTALES</userdata>";
    $s .= "<userdata name='total_ventas'>" . $total_ventas . "</userdata>";
    $s .= "<userdata name='total_monto'>" . $total_monto . "</userdata>";
    $s .= "<userdata name='total_comision'>" . $total_comision . "</userdata>";
    while ($row = $db->sql_fetch_array($ventas)) {
        $s .= "<row>";
        $s .= "<cell><![CDATA[" . $row[NombreComercial] . "]]></cell>";
        $s .= "<cell><![CDATA[" . $row[carrier] . "]]></cell>";
        $s .= "<cell>" . $row[TOTAL_VENTAS] . "</cell>";
        $s .= "<cell>" . $row[TOTAL_MONTO] . "</cell>";
        $s .= "<cell>" . $row[TOTAL_COMISION] . "</cell>";
        $s .= "</row>";
    }
    $s .= "</rows>";
    echo $s;
}

//CAJERO
if ($perfil == 4) {
    $idCajero = $db->sql_result($db->sql_query("SELECT idCajero FROM cajero WHERE idUsuario = $idUsr"), 0);
    $ventas = $db->sql_query("SELECT *,SUBSTRING_INDEX(carrier,'-',1) as compania FROM ventas WHERE idCajero = $idCajero AND carrier NOT LIKE 'AJUSTE%' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY $sidx $sord LIMIT $start, $limit");
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    //$s .= "<records>".$count."</records>";
    // be sure to put text data in CDATA
    while ($row = $db->sql_fetch_array($ventas)) {
        $s .= "<row>";
        $s .= "<cell><![CDATA[" . $row[fecha] . "]]></cell>";
        $s .= "<cell><![CDATA[" . $row[compania] . "]]></cell>";
        $s .= "<cell>" . $row[destino] . "</cell>";
        $s .= "<cell>" . $row[monto] . "</cell>";
        $s .= "<cell>" . $row[comision] . "</cell>";
        $s .= "<cell>" . trim($row[autorizacion]) . "</cell>";
        $s .= "</row>";
    }
    $s .= "</rows>";
    echo $s;
}
?>
