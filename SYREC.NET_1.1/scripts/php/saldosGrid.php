<?php

require 'conexion.php';
date_default_timezone_set('America/Mexico_City');
$page = $_REQUEST['page'];
$limit = $_REQUEST['rows'];
$sidx = $_REQUEST['sidx'];
$sord = $_REQUEST['sord'];
$searchField = $_REQUEST['searchField'];
$searchString = utf8_decode($_REQUEST['searchString']);
$operadores = array('cn' => "LIKE '%$searchString%'", 'bw' => "LIKE '$searchString%'", 'ew' => "LIKE '%$searchString'", 'lt' => "< '$searchString'", 'le' => "<= '$searchString'", 'gt' => "> '$searchString'", 'ge' => ">= '$searchString'");
$searchOper = $operadores[$_REQUEST['searchOper']];
/* Datos a editar */
$oper = $_POST['oper'];
$id = $_REQUEST['id'];

if (!$sidx)
    $sidx = 1;

$db = new Conexion;
$db->sql_connect();

$result = $db->sql_query("SELECT COUNT(*) AS count FROM usuarios");
$row = $db->sql_fetch_array($result);
$count = $row['count'];

if ($count > 0 && $limit > 0) {
    $total_pages = ceil($count / $limit);
} else {
    $total_pages = 0;
}

if ($page > $total_pages)
    $page = $total_pages;

$start = $limit * $page - $limit;

if ($start < 0)
    $start = 0;

/* Obtener el Perfil del Usuario */
$query = $db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = $id");
$perfil = $db->sql_fetch_array($query);

if ($perfil[idPerfil] == 1) {
    $ayer = date('Y-m-d', strtotime('-1 days')); //Fecha del día anterior
    $hoy = date('Y-m-d');
    /* Operaciones para Tarjetas del Noreste */
    $saldoTelcel = $db->sql_result($db->sql_query("SELECT SUM(saldo_Telcel) as InicialT FROM saldos_carrier WHERE saldos_carrier.idUsuario = $id AND DATE(fechaSolicitud) <= '$ayer'"), 0);
    $ventasAyerT = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'TELCEL' AND DATE(fecha) <= '$ayer'"), 0);
    $saldoInicialT = $saldoTelcel - $ventasAyerT; //Saldo Inicial para TELCEL
    $compraT = $db->sql_result($db->sql_query("SELECT SUM(saldo_Telcel) FROM saldos_carrier WHERE saldos_carrier.idUsuario = $id AND fechaSolicitud LIKE '$hoy%'"), 0);
    $ventaT = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'TELCEL' AND DATE(fecha) = '$hoy'"), 0);

    /* Operaciones para Pagatae */
    $saldoPagatae = $db->sql_result($db->sql_query("SELECT SUM(saldo_Pagatae) as InicialP FROM saldos_carrier WHERE saldos_carrier.idUsuario = $id AND DATE(fechaSolicitud) <= '$ayer'"), 0);
    $ventasAyerP = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'TELCEL-PAGATAE' AND DATE(fecha) <= '$ayer'"), 0);
    $saldoInicialP = $saldoPagatae - $ventasAyerP; //Saldo Inicial para TELCEL
    $compraP = $db->sql_result($db->sql_query("SELECT SUM(saldo_Pagatae) FROM saldos_carrier WHERE saldos_carrier.idUsuario = $id AND fechaSolicitud LIKE '$hoy%'"), 0);
    $ventaP = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'TELCEL-PAGATAE' AND DATE(fecha) = '$hoy'"), 0);

    $saldoMovi = $db->sql_result($db->sql_query("SELECT SUM(saldo_Movistar) AS InicialM FROM saldos_carrier WHERE saldos_carrier.idUsuario = $id AND DATE(fechaSolicitud) <= '$ayer'"), 0);
    $ventasAyerM = $db->sql_result($db->sql_query("SELECT SUM(ROUND(monto, 0)) FROM ventas WHERE carrier = 'MOVISTAR' AND DATE(fecha) <= '$ayer'"), 0);
    $saldoInicialM = $saldoMovi - $ventasAyerM; //Saldo Inicial para MOVISTAR
    $compraM = $db->sql_result($db->sql_query("SELECT SUM(saldo_Movistar) FROM saldos_carrier WHERE saldos_carrier.idUsuario = $id AND DATE(fechaSolicitud) = '$hoy'"), 0);
    $ventaM = $db->sql_result($db->sql_query("SELECT SUM(ROUND(monto, 0)) FROM ventas WHERE carrier = 'MOVISTAR' AND DATE(fecha) = '$hoy'"), 0);

    $saldoIusa = $db->sql_result($db->sql_query("SELECT SUM(saldo_Iusacell) AS InicialI FROM saldos_carrier WHERE saldos_carrier.idUsuario = $id AND DATE(fechaSolicitud) <= '$ayer'"), 0);
    $ventasAyerI = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE (carrier = 'IUSACELL' OR carrier = 'UNEFON') AND DATE(fecha) <= '$ayer'"), 0);
    $saldoInicialI = $saldoIusa - $ventasAyerI; //Saldo Inicial para IUSACELL/UNEFON
    $compraI = $db->sql_result($db->sql_query("SELECT SUM(saldo_Iusacell) FROM saldos_carrier WHERE saldos_carrier.idUsuario = $id AND fechaSolicitud LIKE '$hoy%'"), 0);
    $ventaI = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE (carrier = 'IUSACELL' OR carrier = 'UNEFON') AND DATE(fecha) = '$hoy'"), 0);

    $saldoNextel = $db->sql_result($db->sql_query("SELECT SUM(saldo_Nextel) as InicialP FROM saldos_carrier WHERE saldos_carrier.idUsuario = $id AND DATE(fechaSolicitud) <= '$ayer'"), 0);
    $ventasAyerN = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'NEXTEL' AND DATE(fecha) <= '$ayer'"), 0);
    $saldoInicialN = $saldoNextel - $ventasAyerN; //Saldo Inicial para TELCEL
    $compraN = $db->sql_result($db->sql_query("SELECT SUM(saldo_Nextel) FROM saldos_carrier WHERE saldos_carrier.idUsuario = $id AND fechaSolicitud LIKE '$hoy%'"), 0);
    $ventaN = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'NEXTEL' AND DATE(fecha) = '$hoy'"), 0);

    $ventasAyerC = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'CACHITO' AND DATE(fecha) <= '$ayer'"), 0);
    $saldoInicialC = 0 - $ventasAyerC; //Saldo Inicial para CACHITO
    $ventaC = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'CACHITO' AND DATE(fecha) = '$hoy'"), 0);

    $ventasAyerMe = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'MELATE' AND DATE(fecha) <= '$ayer'"), 0);
    $saldoInicialMe = 0 - $ventasAyerMe; //Saldo Inicial para MOVISTAR
    $ventaMel = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'MELATE' AND DATE(fecha) = '$hoy'"), 0);

    //Actualizar el Saldo del Administrador
    $saldo_Inicial = $saldoInicialT + $saldoInicialM + $saldoInicialI;
    $db->sql_query("UPDATE usuarios SET saldo_inicial = $saldo_Inicial WHERE idUsuario = $id");
    $actualT = ($saldoInicialT + $compraT) - $ventaT;
    $actualM = ($saldoInicialM + $compraM) - $ventaM;
    $actualI = ($saldoInicialI + $compraI) - $ventaI;
    $actualP = ($saldoInicialP + $compraP) - $ventaP;
    $actualN = ($saldoInicialN + $compraN) - $ventaN;
    $actualC = $saldoInicialC - $ventaC;
    $actualMe = $saldoInicialMe - $ventaMel;
    $saldoActual = ($actualT + $actualM + $actualI + $actualP);
    $db->sql_query("UPDATE saldos SET saldoActual =$saldoActual, fecha = NOW() WHERE idUsuario = $id");

    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    //$s .= "<page>".$page."</page>";
    //$s .= "<total>".$total_pages."</total>";
    //$s .= "<records>".$count."</records>";
    $s .= "<userdata name='saldo_inicial'>" . ($saldoInicialT + $saldoInicialM + $saldoInicialI + $saldoInicialP + $saldoInicialN) . "</userdata>";
    $s .= "<userdata name='compras'>" . ($compraT + $compraM + $compraI + $compraP + $compraN) . "</userdata>";
    $s .= "<userdata name='ventas'>" . ($ventaT + $ventaM + $ventaI + $ventaC + $ventaMel + $ventaP + $ventaN) . "</userdata>";
    $s .= "<userdata name='saldo_actual'>" . ($actualT + $actualM + $actualI + $actualP + $actualN) . "</userdata>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='https://www.recargandomicel.com/' target='_blank'>TARJETAS DEL NORESTE</a>]]></cell>";
    $s .= "<cell>" . $saldoInicialT . "</cell>";
    $s .= "<cell>" . $compraT . "</cell>";
    $s .= "<cell>" . $ventaT . "</cell>";
    $s .= "<cell>" . $actualT . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='http://pagataeem.com/' target='_blank'>PAGATAE</a>]]></cell>";
    $s .= "<cell>" . $saldoInicialP . "</cell>";
    $s .= "<cell>" . $compraP . "</cell>";
    $s .= "<cell>" . $ventaP . "</cell>";
    $s .= "<cell>" . $actualP . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='http://sre.movistar.com.mx/sre/view/html/login.html' target='_blank'>MOVISTAR</a>]]></cell>";
    $s .= "<cell>" . $saldoInicialM . "</cell>";
    $s .= "<cell>" . $compraM . "</cell>";
    $s .= "<cell>" . $ventaM . "</cell>";
    $s .= "<cell>" . $actualM . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='https://ventamovil.iusacell.com.mx/TAEDST' target='_blank'>IUSACELL/UNEFON</a>]]></cell>";
    $s .= "<cell>" . $saldoInicialI . "</cell>";
    $s .= "<cell>" . $compraI . "</cell>";
    $s .= "<cell>" . $ventaI . "</cell>";
    $s .= "<cell>" . $actualI . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='https://ventas.recargaqui.com.mx/recargas/' target='_blank'>NEXTEL</a>]]></cell>";
    $s .= "<cell>" . $saldoInicialN . "</cell>";
    $s .= "<cell>" . $compraN . "</cell>";
    $s .= "<cell>" . $ventaN . "</cell>";
    $s .= "<cell>" . $actualN . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[CACHITO]]></cell>";
    $s .= "<cell>" . $saldoInicialC . "</cell>";
    $s .= "<cell>0</cell>";
    $s .= "<cell>" . $ventaC . "</cell>";
    $s .= "<cell>" . $actualC . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[MELATE]]></cell>";
    $s .= "<cell>" . $saldoInicialMe . "</cell>";
    $s .= "<cell>0</cell>";
    $s .= "<cell>" . $ventaMel . "</cell>";
    $s .= "<cell>" . $actualMe . "</cell>";
    $s .= "</row>";
    $s .= "</rows>";
    echo $s;
}
if ($perfil[idPerfil] == 2) {
    $ayer = date('Y-m-d', strtotime('-1 days')); //Fecha del día anterior
    $hoy = date('Y-m-d');
    /* OBTENER LOS SALDOS DEL DÍA ANTERIOR */
    $comprasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras WHERE compras.idUsuario = $id AND DATE(fecha)<='$ayer'"), 0);
    $ventasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras,relaciones WHERE compras.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $id AND DATE(fecha)<='$ayer'"), 0);
    $comisionesA = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)<='$ayer'"), 0);
    $sInicial = ($comprasA + $comisionesA) - $ventasA;
    //SE ACTUALIZA EL SALDO INICIAL
    $db->sql_query("UPDATE usuarios SET saldo_Inicial=$sInicial WHERE idUsuario = $id");
    $saldoInicial = $db->sql_result($db->sql_query("SELECT saldo_Inicial FROM usuarios WHERE idUsuario = $id"), 0);
    $compras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras WHERE compras.idUsuario = $id AND DATE(fecha)='$hoy'"), 0);
    $ventas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras,relaciones WHERE relaciones.idUsuarioHijo = compras.idUsuario AND relaciones.idUsuarioPadre = $id AND DATE(fecha)='$hoy'"), 0);
    $comisiones = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)='$hoy'"), 0);
    $saldoActual = ($saldoInicial + $compras + $comisiones) - $ventas;
    //SE ACTUALIZA EL SALDO ACTUAL
    $db->sql_query("UPDATE saldos SET saldoActual = $saldoActual, fecha = NOW() WHERE idUsuario = $id");

    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    //$s .= "<records>".$count."</records>";
    $s .= "<userdata name='saldo_telcel'>123456</userdata>";
    $s .= "<userdata name='saldo_movistar'>123456</userdata>";
    $s .= "<userdata name='saldo_iusacell'>123456</userdata>";
    $s .= "<row>";
    $s .= "<cell>" . $saldoInicial . "</cell>";
    $s .= "<cell>" . $compras . "</cell>";
    $s .= "<cell>" . $ventas . "</cell>";
    $s .= "<cell>" . $comisiones . "</cell>";
    $s .= "<cell>" . $cargos . "</cell>";
    $s .= "<cell>" . $saldoActual . "</cell>";
    $s .= "</row>";
    $s .= "</rows>";
    echo $s;
}
if ($perfil[idPerfil] == 3) {
    $hoy = date('Y-m-d');
    $saldoInicial = $db->sql_result($db->sql_query("SELECT saldo_Inicial FROM usuarios WHERE idUsuario = $id"), 0);
    $compras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE idUsuario = $id AND estatus = 1 AND DATE(fechaAut)='$hoy'"), 0);
    $ventas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)='$hoy'"), 0);
    $comisiones = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $id AND DATE(fecha)='$hoy'"), 0);
    $saldoActual = ($saldoInicial + $compras + $comisiones) - $ventas;
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    $s .= "<total>" . $total_pages . "</total>";
    //$s .= "<records>".$count."</records>";
    $s .= "<row>";
    $s .= "<cell>" . $saldoInicial . "</cell>";
    $s .= "<cell>" . $compras . "</cell>";
    $s .= "<cell>" . $ventas . "</cell>";
    $s .= "<cell>" . $comisiones . "</cell>";
    $s .= "<cell>" . $saldoActual . "</cell>";
    $s .= "</row>";
    $s .= "</rows>";
    echo $s;
}
?>