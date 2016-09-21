<?php

require_once("excel.php");
require_once("excel-ext.php");
require_once("../conexion.php");


$carrier = $_GET['carrier'];
$inicio = $_REQUEST['inicio'];
$final = $_REQUEST['final'];
$db = new Conexion;
$db->sql_connect();


if ($carrier == 'T') {
    $queEmp = "SELECT carrier AS CARRIER, destino AS CELULAR, monto AS MONTO, autorizacion as NO_AUTORIZACION, fecha AS FECHA_RECARGA, NombreComercial AS COMERCIO FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier='TELCEL' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY fecha ASC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);

    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("ventasTarjetas.xls", $data);
    exit;
}

if ($carrier == 'P') {
    $queEmp = "SELECT carrier AS CARRIER, destino AS CELULAR, monto AS MONTO, autorizacion as NO_AUTORIZACION, fecha AS FECHA_RECARGA, NombreComercial AS COMERCIO FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier = 'TELCEL-PAGATAE' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY fecha ASC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);
    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("ventasPagatae.xls", $data);
    exit;
}

if ($carrier == 'M') {
    $queEmp = "SELECT carrier AS CARRIER, destino AS CELULAR, monto AS MONTO, autorizacion as NO_AUTORIZACION, fecha AS FECHA_RECARGA, NombreComercial AS COMERCIO FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier = 'MOVISTAR' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY fecha ASC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);

    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("ventasMovistar.xls", $data);
    exit;
}
if ($carrier == 'I') {
    $queEmp = "SELECT carrier AS CARRIER, destino AS CELULAR, monto AS MONTO, autorizacion as NO_AUTORIZACION, fecha AS FECHA_RECARGA, NombreComercial AS COMERCIO FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier = 'IUSACELL' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY fecha ASC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);

    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("ventasIusacell.xls", $data);
    exit;
}
if ($carrier == 'U') {
    $queEmp = "SELECT carrier AS CARRIER, destino AS CELULAR, monto AS MONTO, autorizacion as NO_AUTORIZACION, fecha AS FECHA_RECARGA, NombreComercial AS COMERCIO FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier = 'UNEFON' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY fecha ASC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);

    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("ventasUnefon.xls", $data);
    exit;
}
if ($carrier == 'C') {
    $queEmp = "SELECT carrier AS CARRIER, destino AS CELULAR, monto AS MONTO, autorizacion as NO_AUTORIZACION, fecha AS FECHA_RECARGA, NombreComercial AS COMERCIO FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier = 'CACHITO' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY fecha ASC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);

    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("ventasCachito.xls", $data);
    exit;
}
if ($carrier == 'ME') {
    $queEmp = "SELECT carrier AS CARRIER, destino AS CELULAR, monto AS MONTO, autorizacion as NO_AUTORIZACION, fecha AS FECHA_RECARGA, NombreComercial AS COMERCIO FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier = 'MELATE' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY fecha ASC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);

    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("ventasMelate.xls", $data);
    exit;
}
if ($carrier == 'N') {
    $queEmp = "SELECT carrier AS CARRIER, destino AS CELULAR, monto AS MONTO, autorizacion as NO_AUTORIZACION, fecha AS FECHA_RECARGA, NombreComercial AS COMERCIO FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier = 'NEXTEL' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY fecha ASC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);

    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("ventasNextel.xls", $data);
    exit;
}
if ($carrier == 'ALL') {
    $queEmp = "SELECT carrier AS CARRIER, destino AS CELULAR, monto AS MONTO, autorizacion as NO_AUTORIZACION, fecha AS FECHA_RECARGA, NombreComercial AS COMERCIO FROM `ventas`, detalleusuarios WHERE ventas.idUsuario = detalleusuarios.idUsuario AND carrier NOT LIKE 'AJUSTE COMISION%' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final' ORDER BY fecha ASC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);

    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("ventasTotales.xls", $data);
    exit;
}
if ($carrier == 'usuarios') {
    $queEmp = "SELECT detalleusuarios . * , usuarios.Usuario as Email FROM `detalleusuarios` , usuarios WHERE detalleusuarios.idUsuario = usuarios.idUsuario ORDER BY detalleusuarios.idUsuario ASC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);

    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("detalleUsuarios.xls", $data);
    exit;
}

if ($carrier == 'Compras') {
    $queEmp = "SELECT detalleusuarios.NombreComercial,SUM(monto) AS TOTAL_COMPRAS FROM depositos,detalleusuarios, relaciones WHERE depositos.idUsuario = detalleusuarios.idUsuario AND depositos.idUsuario = idUsuarioHijo AND idUsuarioPadre = 2 AND estatus = 1 AND DATE(fechaAut) >= '$inicio' AND DATE(fechaAut) <= '$final' GROUP BY NombreComercial ORDER BY TOTAL_COMPRAS DESC";
    $resEmp = $db->sql_query($queEmp);
    $totEmp = $db->sql_num_rows($resEmp);

    while ($datatmp = $db->sql_fetch_assoc($resEmp)) {
        $data[] = $datatmp;
    }
    createExcel("Compras(".$inicio."a".$final.").xls", $data);
    exit;
}
?>