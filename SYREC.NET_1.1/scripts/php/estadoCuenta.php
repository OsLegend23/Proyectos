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
/*Asignamos la fecha de inicio de la consulta*/
if (isset($_GET["inicio"]))
    $inicio = $_GET['inicio'];
else
    $inicio = "";
/*Asignamos la fecha de final de la consulta*/
if (isset($_GET["final"]))
    $final = $_GET["final"];
else
    $final = "";
/*Asignamos al usuario de la consulta*/
if (isset($_GET["usuario"]))
    $usuario = $_GET['usuario'];
else
    $usuario = "";
    
//construct where clause
/*$where = "WHERE 1=1";
 if ($fecha != '')
 $where .= " AND item LIKE '$fecha%'";
 if ($cd_mask != '')
 $where .= " AND item_cd LIKE '$cd_mask%'";
 */

$result = $db->sql_query("SELECT COUNT(*) AS count FROM usuarios, relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr");

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
    
/*Se obtiene el perfil del usuario*/
$perfil = $db->sql_result($db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = $idUsr"), 0);

if ($perfil == 1) {//Si es Administrador
    if ($usuario != 0) {//Si se selecciona una franquicia particular
        $comprasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras WHERE compras.idUsuario = $usuario AND DATE(fecha)<'$inicio'"), 0);
        $ventasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras,relaciones WHERE compras.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND DATE(compras.fecha)<'$inicio'"), 0);
        $comisionesA = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $usuario AND DATE(fecha)<'$inicio'"), 0);
        $saldo_inicial = ($comprasA + $comisionesA) - $ventasA;
        
        $operacionesCompras = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM compras WHERE compras.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoTotalCompras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras WHERE compras.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalVentas = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalVentasHechas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND carrier!='CACHITO' AND carrier !='MELATE' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalTraspasos = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM compras,relaciones WHERE compras.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $totalTraspasosHechos = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras,relaciones WHERE compras.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $totalVentasComisiones = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $ventasTelcel = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE (ventas.carrier='TELCEL' OR ventas.carrier = 'TELCEL-PAGATAE') AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $montoVentasTelcel = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE (ventas.carrier='TELCEL' OR ventas.carrier = 'TELCEL-PAGATAE') AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        if ($totalVentasHechas == 0)
            $totalVentasHechas = 1;
        else
            $totalVentasHechas = $totalVentasHechas;
            
        $porcentajeVentasTelcel = ($montoVentasTelcel / $totalVentasHechas) * 100;
        
        if ($totalVentasComisiones == 0)
            $totalVentasComisiones = 1;
        else
            $totalVentasComisiones = $totalVentasComisiones;
            
        $comisionVentasTelcel = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'AJUSTE COMISION T' AND ventas.idUsuario = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $porcentajeComisionTelcel = ($comisionVentasTelcel / $totalVentasComisiones) * 100;
        
        $ventasMovistar = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE carrier = 'MOVISTAR' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $montoVentasMovistar = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE carrier = 'MOVISTAR' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $porcentajeVentasMovistar = ($montoVentasMovistar / $totalVentasHechas) * 100;
        $comisionVentasMovistar = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'AJUSTE COMISION M' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionMovistar = ($comisionVentasMovistar / $totalVentasComisiones) * 100;
        
        $ventasIusacell = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE carrier = 'IUSACELL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $montoVentasIusacell = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE carrier = 'IUSACELL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $porcentajeVentasIusacell = ($montoVentasIusacell / $totalVentasHechas) * 100;
        $comisionVentasIusacell = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'AJUSTE COMISION I' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionIusacell = ($comisionVentasIusacell / $totalVentasComisiones) * 100;
        
        $ventasUnefon = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE carrier = 'UNEFON' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $montoVentasUnefon = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE carrier = 'UNEFON' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $porcentajeVentasUnefon = ($montoVentasUnefon / $totalVentasHechas) * 100;
        $comisionVentasUnefon = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'AJUSTE COMISION U' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionUnefon = ($comisionVentasUnefon / $totalVentasComisiones) * 100;

        $ventasNextel = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE carrier = 'NEXTEL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $montoVentasNextel = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE carrier = 'NEXTEL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $usuario AND (DATE(fecha) >='$inicio' AND DATE(fecha) <='$final')"), 0);
        $porcentajeVentasNextel = ($montoVentasNextel / $totalVentasHechas) * 100;
        $comisionVentasNextel = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'AJUSTE COMISION N' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionNextel = ($comisionVentasNextel / $totalVentasComisiones) * 100;
        
        header("Content-type: text/xml;charset=iso-8859-1");
        $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $s .= "<rows>";
        $s .= "<page>".$page."</page>";
        $s .= "<total>".$total_pages."</total>";
        $s .= "<records>".$count."</records>";
        // be sure to put text data in CDATA
        $s .= "<row>";
        $s .= "<cell><![CDATA[<strong>Saldo Inicial</strogn>]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell><![CDATA[<strong>$ ".number_format($saldo_inicial, 2)."</strogn>]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[<strong>Total Compras</strong>]]></cell>";
        $s .= "<cell><![CDATA[<strong>".$operacionesCompras."</strong>]]></cell>";
        $s .= "<cell><![CDATA[<strong>$ ".number_format($montoTotalCompras, 2)."</strong>]]></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Telcel]]></cell>";
        $s .= "<cell>".$ventasTelcel."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasTelcel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasTelcel, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasTelcel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionTelcel, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Movistar]]></cell>";
        $s .= "<cell>".$ventasMovistar."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasMovistar, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasMovistar, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasMovistar, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionMovistar, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Iusacell]]></cell>";
        $s .= "<cell>".$ventasIusacell."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasIusacell, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasIusacell, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasIusacell, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionIusacell, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Unefon]]></cell>";
        $s .= "<cell>".$ventasUnefon."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasUnefon, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasUnefon, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasUnefon, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionUnefon, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Nextel]]></cell>";
        $s .= "<cell>".$ventasNextel."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasNextel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasNextel, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasNextel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionNextel, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Total Ventas]]></cell>";
        $s .= "<cell>".$totalVentas."</cell>";
        $s .= "<cell>$ ".number_format($totalVentasHechas, 2)."</cell>";
        $s .= "<cell>".number_format(($porcentajeVentasTelcel + $porcentajeVentasMovistar + $porcentajeVentasIusacell + $porcentajeVentasUnefon + $porcentajeVentasNextel), 2)." %</cell>";
        $s .= "<cell><![CDATA[<strong>$ ".number_format($totalVentasComisiones, 2)."</strong>]]></cell>";
        $s .= "<cell>".number_format(($porcentajeComisionTelcel + $porcentajeComisionMovistar + $porcentajeComisionIusacell + $porcentajeComisionUnefon + $porcentajeComisionNextel), 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[<strong>Total Traspasos</strong>]]></cell>";
        $s .= "<cell><![CDATA[<strong>".$totalTraspasos."</strong>]]></cell>";
        $s .= "<cell><![CDATA[<strong>$ ".number_format($totalTraspasosHechos, 2)."</strong>]]></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Saldo Final]]></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell>$ ".number_format((($saldo_inicial + $montoTotalCompras + $totalVentasComisiones) - $totalTraspasosHechos), 2)."</cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "</rows>";
        echo $s;

        
    } else {//Si es Global
    
        $saldoTelcel = $db->sql_result($db->sql_query("SELECT SUM(saldo_Telcel) as InicialT FROM saldos_carrier WHERE saldos_carrier.idUsuario = $idUsr AND DATE(fechaSolicitud) < '$inicio'"), 0);
        $ventasAyerT = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'TELCEL' AND DATE(fecha) < '$inicio'"), 0);
        $saldoInicialT = $saldoTelcel - $ventasAyerT;//Saldo Inicial para TELCEL

        $saldoPagatae = $db->sql_result($db->sql_query("SELECT SUM(saldo_Telcel) as InicialT FROM saldos_carrier WHERE saldos_carrier.idUsuario = $idUsr AND DATE(fechaSolicitud) < '$inicio'"), 0);
        $ventasAyerP = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'TELCEL-PAGATAE' AND DATE(fecha) < '$inicio'"), 0);
        $saldoInicialP = $saldoPagatae - $ventasAyerP;//Saldo Inicial para TELCEL

        $saldoMovi = $db->sql_result($db->sql_query("SELECT SUM(saldo_Movistar) AS InicialM FROM saldos_carrier WHERE saldos_carrier.idUsuario = $idUsr AND DATE(fechaSolicitud) < '$inicio'"), 0);
        $ventasAyerM = $db->sql_result($db->sql_query("SELECT SUM(ROUND(monto, 0)) FROM ventas WHERE carrier = 'MOVISTAR' AND DATE(fecha) < '$inicio'"), 0);
        $saldoInicialM = $saldoMovi - $ventasAyerM;//Saldo Inicial para MOVISTAR

        $saldoIusa = $db->sql_result($db->sql_query("SELECT SUM(saldo_Iusacell) AS InicialI FROM saldos_carrier WHERE saldos_carrier.idUsuario = $idUsr AND DATE(fechaSolicitud) < '$inicio'"), 0);
        $ventasAyerI = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE (carrier = 'IUSACELL' OR carrier = 'UNEFON') AND DATE(fecha) < '$inicio'"), 0);
        $saldoInicialI = $saldoIusa - $ventasAyerI;//Saldo Inicial para IUSACELL/UNEFON
	
        $saldo_inicial = $saldoInicialT+$saldoInicialP+$saldoInicialM+$saldoInicialI;
        
        //$saldo_inicial = $db->sql_result($db->sql_query("SELECT saldo_inicial FROM usuarios WHERE usuarios.idUsuario = $idUsr"), 0);
        $operacionesCompras = $db->sql_result($db->sql_query("SELECT COUNT(idUsuario) FROM compras WHERE compras.idUsuario = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoTotalCompras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras WHERE compras.idUsuario = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalVentas = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier NOT LIKE 'AJUSTE COMISION%' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalVentasHechas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier NOT LIKE 'AJUSTE COMISION%' AND carrier!='CACHITO' AND carrier !='MELATE' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalVentasComisiones = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas,relaciones WHERE ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $ventasTelcel = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE (carrier='TELCEL' OR carrier = 'TELCEL-PAGATAE') AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasTelcel = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE (carrier='TELCEL' OR carrier = 'TELCEL-PAGATAE') AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalTraspasos = $db->sql_result($db->sql_query("SELECT COUNT(idUsuario) FROM compras,relaciones WHERE compras.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalTraspasosHechos = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM compras,relaciones WHERE compras.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        if ($totalVentasHechas == 0)
            $totalVentasHechas = 1;
        else
            $totalVentasHechas = $totalVentasHechas;
            
        $porcentajeVentasTelcel = ($montoVentasTelcel / $totalVentasHechas) * 100;
        
        if ($totalVentasComisiones == 0)
            $totalVentasComisiones = 1;
        else
            $totalVentasComisiones = $totalVentasComisiones;
            
        $comisionVentasTelcel = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas,relaciones WHERE (carrier='TELCEL' OR carrier = 'TELCEL-PAGATAE') AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionTelcel = ($comisionVentasTelcel / $totalVentasComisiones) * 100;
        
        $ventasMovistar = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier = 'MOVISTAR' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasMovistar = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'MOVISTAR' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasMovistar = ($montoVentasMovistar / $totalVentasHechas) * 100;
        $comisionVentasMovistar = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas,relaciones WHERE carrier = 'MOVISTAR' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionMovistar = ($comisionVentasMovistar / $totalVentasComisiones) * 100;
        
        $ventasIusacell = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier = 'IUSACELL' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasIusacell = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'IUSACELL' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasIusacell = ($montoVentasIusacell / $totalVentasHechas) * 100;
        $comisionVentasIusacell = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas,relaciones WHERE carrier = 'IUSACELL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionIusacell = ($comisionVentasIusacell / $totalVentasComisiones) * 100;
        
        $ventasUnefon = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier = 'UNEFON' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasUnefon = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'UNEFON' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasUnefon = ($montoVentasUnefon / $totalVentasHechas) * 100;
        $comisionVentasUnefon = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas,relaciones WHERE carrier = 'UNEFON' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionUnefon = ($comisionVentasUnefon / $totalVentasComisiones) * 100;

        $ventasNextel = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier = 'NEXTEL' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasNextel = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'NEXTEL' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasNextel = ($montoVentasNextel / $totalVentasHechas) * 100;
        $comisionVentasNextel = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas,relaciones WHERE carrier = 'NEXTEL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionNextel = ($comisionVentasNextel / $totalVentasComisiones) * 100;
        
        header("Content-type: text/xml;charset=iso-8859-1");
        $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $s .= "<rows>";
        $s .= "<page>".$page."</page>";
        $s .= "<total>".$total_pages."</total>";
        $s .= "<records>".$count."</records>";
        // be sure to put text data in CDATA
        $s .= "<row>";
        $s .= "<cell><![CDATA[<strong>Saldo Inicial</strogn>]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell><![CDATA[<strong>$ ".number_format($saldo_inicial, 2)."</strogn>]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[<strong>Total Compras</strong>]]></cell>";
        $s .= "<cell><![CDATA[<strong>".$operacionesCompras."</strong>]]></cell>";
        $s .= "<cell><![CDATA[<strong>$ ".number_format($montoTotalCompras, 2)."</strong>]]></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Telcel]]></cell>";
        $s .= "<cell>".$ventasTelcel."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasTelcel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasTelcel, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasTelcel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionTelcel, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Movistar]]></cell>";
        $s .= "<cell>".$ventasMovistar."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasMovistar, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasMovistar, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasMovistar, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionMovistar, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Iusacell]]></cell>";
        $s .= "<cell>".$ventasIusacell."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasIusacell, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasIusacell, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasIusacell, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionIusacell, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Unefon]]></cell>";
        $s .= "<cell>".$ventasUnefon."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasUnefon, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasUnefon, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasUnefon, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionUnefon, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Nextel]]></cell>";
        $s .= "<cell>".$ventasNextel."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasNextel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasNextel, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasNextel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionNextel, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[<strong>Total Ventas</strong>]]></cell>";
        $s .= "<cell><![CDATA[<strong>".$totalVentas."</strong>]]></cell>";
        $s .= "<cell><![CDATA[<strong>$ ".number_format($totalVentasHechas, 2)."</strong>]]></cell>";
        $s .= "<cell>".number_format(($porcentajeVentasTelcel + $porcentajeVentasMovistar + $porcentajeVentasIusacell + $porcentajeVentasUnefon + $porcentajeVentasNextel), 2)." %</cell>";
        $s .= "<cell>$ ".number_format(0, 2)."</cell>";
        $s .= "<cell>".number_format(($porcentajeComisionTelcel + $porcentajeComisionMovistar + $porcentajeComisionIusacell + $porcentajeComisionUnefon + $porcentajeComisionNextel), 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Total Traspasos]]></cell>";
        $s .= "<cell>".$totalTraspasos."</cell>";
        $s .= "<cell>$ ".number_format($totalTraspasosHechos, 2)."</cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Saldo Final]]></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell>$ ".number_format((($saldo_inicial + $montoTotalCompras) - $totalVentasHechas), 2)."</cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "</rows>";
        echo $s;
    }
}
if ($perfil == 2) {//Si es Franquicia
    if ($usuario != 0) {//Si es un comercio en particular
        $comprasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE idUsuario = $usuario AND estatus = 1 AND DATE(fechaAut)<'$inicio'"), 0);
        $ventasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE ventas.idUsuario = $usuario AND DATE(fecha)<'$inicio'"), 0);
        $comisionesA = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $usuario AND DATE(fecha)<='2011-01-25'"), 0);
        $saldo_inicial = ($comprasA + $comisionesA) - $ventasA;
        
        $operacionesCompras = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM depositos WHERE idUsuario = $usuario AND estatus = 1 AND DATE(fechaAut) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoTotalCompras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE idUsuario = $usuario AND estatus = 1 AND DATE(fechaAut) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalVentas = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalVentasHechas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalVentasComisiones = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $ventasTelcel = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier = 'TELCEL' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasTelcel = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'TELCEL' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        if ($totalVentasHechas == 0)
            $totalVentasHechas = 1;
        else
            $totalVentasHechas = $totalVentasHechas;
            
        $porcentajeVentasTelcel = ($montoVentasTelcel / $totalVentasHechas) * 100;
        
        if ($totalVentasComisiones == 0)
            $totalVentasComisiones = 1;
        else
            $totalVentasComisiones = $totalVentasComisiones;
            
        $comisionVentasTelcel = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'TELCEL' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionTelcel = ($comisionVentasTelcel / $totalVentasComisiones) * 100;

        $ventasPagatae = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier = 'TELCEL-PAGATAE' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasPagatae = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'TELCEL-PAGATAE' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasPagatae = ($montoVentasPagatae / $totalVentasHechas) * 100;
        $comisionVentasPagatae = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'TELCEL-PAGATAE' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionPagatae = ($comisionVentasPagatae / $totalVentasComisiones) * 100;

        $ventasMovistar = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier = 'MOVISTAR' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasMovistar = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'MOVISTAR' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasMovistar = ($montoVentasMovistar / $totalVentasHechas) * 100;
        $comisionVentasMovistar = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'MOVISTAR' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionMovistar = ($comisionVentasMovistar / $totalVentasComisiones) * 100;
        
        $ventasIusacell = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier = 'IUSACELL' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasIusacell = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'IUSACELL' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasIusacell = ($montoVentasIusacell / $totalVentasHechas) * 100;
        $comisionVentasIusacell = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'IUSACELL' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionIusacell = ($comisionVentasIusacell / $totalVentasComisiones) * 100;
        
        $ventasUnefon = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier = 'UNEFON' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasUnefon = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'UNEFON' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasUnefon = ($montoVentasUnefon / $totalVentasHechas) * 100;
        $comisionVentasUnefon = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'UNEFON' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionUnefon = ($comisionVentasUnefon / $totalVentasComisiones) * 100;

        $ventasNextel = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier = 'NEXTEL' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasNextel = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas WHERE carrier = 'NEXTEL' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasNextel = ($montoVentasNextel / $totalVentasHechas) * 100;
        $comisionVentasNextel = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'NEXTEL' AND ventas.idUsuario = $usuario AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionNextel = ($comisionVentasNextel / $totalVentasComisiones) * 100;
        
        header("Content-type: text/xml;charset=iso-8859-1");
        $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $s .= "<rows>";
        $s .= "<page>".$page."</page>";
        $s .= "<total>".$total_pages."</total>";
        $s .= "<records>".$count."</records>";
        // be sure to put text data in CDATA
        $s .= "<row>";
        $s .= "<cell><![CDATA[Saldo Inicial]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell>$ ".number_format($saldo_inicial, 2)."</cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Total Compras]]></cell>";
        $s .= "<cell>".$operacionesCompras."</cell>";
        $s .= "<cell>$ ".number_format($montoTotalCompras, 2)."</cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Tarjetas]]></cell>";
        $s .= "<cell>".$ventasTelcel."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasTelcel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasTelcel, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasTelcel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionTelcel, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Pagatae]]></cell>";
        $s .= "<cell>".$ventasPagatae."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasPagatae, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasPagatae, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasPagatae, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionPagatae, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Movistar]]></cell>";
        $s .= "<cell>".$ventasMovistar."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasMovistar, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasMovistar, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasMovistar, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionMovistar, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Iusacell]]></cell>";
        $s .= "<cell>".$ventasIusacell."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasIusacell, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasIusacell, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasIusacell, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionIusacell, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Unefon]]></cell>";
        $s .= "<cell>".$ventasUnefon."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasUnefon, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasUnefon, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasUnefon, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionUnefon, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Nextel]]></cell>";
        $s .= "<cell>".$ventasNextel."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasNextel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasNextel, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasNextel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionNextel, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Total Ventas]]></cell>";
        $s .= "<cell>".$totalVentas."</cell>";
        $s .= "<cell>$ ".number_format($totalVentasHechas, 2)."</cell>";
        $s .= "<cell>".number_format(($porcentajeVentasTelcel + $porcentajeVentasPagatae + $porcentajeVentasMovistar + $porcentajeVentasIusacell + $porcentajeVentasUnefon + $porcentajeVentasNextel), 2)." %</cell>";
        $s .= "<cell>$ ".number_format($totalVentasComisiones, 2)."</cell>";
        $s .= "<cell>".number_format(($porcentajeComisionTelcel + $porcentajeComisionPagatae + $porcentajeComisionMovistar + $porcentajeComisionIusacell + $porcentajeComisionUnefon + $porcentajeComisionNextel), 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Saldo Final]]></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell>$ ".number_format((($saldo_inicial + $montoTotalCompras + $totalVentasComisiones) - $totalVentasHechas), 2)."</cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "</rows>";
        echo $s;
        
    } else {//Si es global
        $comprasA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE idUsuario = $idUsr AND estatus = 1 AND DATE(fecha)<'$inicio'"), 0);
        $traspasosA = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos,relaciones WHERE depositos.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND depositos.estatus = 1 AND DATE(fechaAut) <'$inicio'"), 0);
        $comisionesA = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $idUsr AND DATE(fecha)<'$inicio'"), 0);
        $saldo_inicial = ($comprasA + $comisionesA) - $traspasosA;
        
        $operacionesCompras = $db->sql_result($db->sql_query("SELECT COUNT(idUsuario) FROM depositos WHERE idUsuario = $idUsr AND estatus = 1 AND DATE(fechaAut) >='$inicio' AND DATE(fechaAut) <='$final'"), 0);
        $montoTotalCompras = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos WHERE idUsuario = $idUsr AND estatus = 1 AND DATE(fechaAut) >='$inicio' AND DATE(fechaAut) <='$final'"), 0);
        $totalVentas = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalVentasHechas = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND carrier!='CACHITO' AND carrier !='MELATE' AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalVentasComisiones = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE ventas.idUsuario = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $totalTraspasos = $db->sql_result($db->sql_query("SELECT COUNT(idUsuario) FROM depositos,relaciones WHERE depositos.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND depositos.estatus = 1 AND DATE(fechaAut) >='$inicio' AND DATE(fechaAut) <='$final'"), 0);
        $totalTraspasosHechos = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM depositos,relaciones WHERE depositos.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND depositos.estatus = 1 AND DATE(fechaAut) >='$inicio' AND DATE(fechaAut) <='$final'"), 0);
        $ventasTelcel = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE carrier='TELCEL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasTelcel = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE carrier='TELCEL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        if ($totalVentasHechas == 0)
            $totalVentasHechas = 1;
        else
            $totalVentasHechas = $totalVentasHechas;
            
        $porcentajeVentasTelcel = ($montoVentasTelcel / $totalVentasHechas) * 100;
        
        if ($totalVentasComisiones == 0)
            $totalVentasComisiones = 1;
        else
            $totalVentasComisiones = $totalVentasComisiones;
            
        $comisionVentasTelcel = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'AJUSTE COMISION T' AND ventas.idUsuario = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionTelcel = ($comisionVentasTelcel / $totalVentasComisiones) * 100;
        
        $ventasMovistar = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE carrier = 'MOVISTAR' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasMovistar = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE carrier = 'MOVISTAR' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasMovistar = ($montoVentasMovistar / $totalVentasHechas) * 100;
        $comisionVentasMovistar = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'AJUSTE COMISION M' AND ventas.idUsuario = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionMovistar = ($comisionVentasMovistar / $totalVentasComisiones) * 100;
        
        $ventasIusacell = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE carrier = 'IUSACELL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasIusacell = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE carrier = 'IUSACELL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasIusacell = ($montoVentasIusacell / $totalVentasHechas) * 100;
        $comisionVentasIusacell = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'AJUSTE COMISION I' AND ventas.idUsuario = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionIusacell = ($comisionVentasIusacell / $totalVentasComisiones) * 100;
        
        $ventasUnefon = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE carrier = 'UNEFON' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasUnefon = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE carrier = 'UNEFON' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasUnefon = ($montoVentasUnefon / $totalVentasHechas) * 100;
        $comisionVentasUnefon = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'AJUSTE COMISION U' AND ventas.idUsuario = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionUnefon = ($comisionVentasUnefon / $totalVentasComisiones) * 100;

        $ventasNextel = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM ventas,relaciones WHERE carrier = 'NEXTEL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $montoVentasNextel = $db->sql_result($db->sql_query("SELECT SUM(monto) FROM ventas,relaciones WHERE carrier = 'NEXTEL' AND ventas.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeVentasNextel = ($montoVentasNextel / $totalVentasHechas) * 100;
        $comisionVentasNextel = $db->sql_result($db->sql_query("SELECT SUM(comision) FROM ventas WHERE carrier = 'AJUSTE COMISION N' AND ventas.idUsuario = $idUsr AND DATE(fecha) >='$inicio' AND DATE(fecha) <='$final'"), 0);
        $porcentajeComisionNextel = ($comisionVentasNextel / $totalVentasComisiones) * 100;
        
        header("Content-type: text/xml;charset=iso-8859-1");
        $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
        $s .= "<rows>";
        $s .= "<page>".$page."</page>";
        $s .= "<total>".$total_pages."</total>";
        $s .= "<records>".$count."</records>";
        // be sure to put text data in CDATA
        $s .= "<row>";
        $s .= "<cell><![CDATA[Saldo Inicial]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell>$ ".number_format($saldo_inicial, 2)."</cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "<cell><![CDATA[]]></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Total Compras]]></cell>";
        $s .= "<cell>".$operacionesCompras."</cell>";
        $s .= "<cell>$ ".number_format($montoTotalCompras, 2)."</cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Telcel]]></cell>";
        $s .= "<cell>".$ventasTelcel."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasTelcel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasTelcel, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasTelcel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionTelcel, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Movistar]]></cell>";
        $s .= "<cell>".$ventasMovistar."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasMovistar, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasMovistar, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasMovistar, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionMovistar, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Iusacell]]></cell>";
        $s .= "<cell>".$ventasIusacell."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasIusacell, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasIusacell, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasIusacell, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionIusacell, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Unefon]]></cell>";
        $s .= "<cell>".$ventasUnefon."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasUnefon, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasUnefon, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasUnefon, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionUnefon, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Ventas Nextel]]></cell>";
        $s .= "<cell>".$ventasNextel."</cell>";
        $s .= "<cell>$ ".number_format($montoVentasNextel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeVentasNextel, 2)." %</cell>";
        $s .= "<cell>$ ".number_format($comisionVentasNextel, 2)."</cell>";
        $s .= "<cell>".number_format($porcentajeComisionNextel, 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Total Traspasos]]></cell>";
        $s .= "<cell>".$totalTraspasos."</cell>";
        $s .= "<cell>$ ".number_format($totalTraspasosHechos, 2)."</cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Total Ventas]]></cell>";
        $s .= "<cell>".$totalVentas."</cell>";
        $s .= "<cell>$ ".number_format($totalVentasHechas, 2)."</cell>";
        $s .= "<cell>".number_format(($porcentajeVentasTelcel + $porcentajeVentasMovistar + $porcentajeVentasIusacell + $porcentajeVentasUnefon + $porcentajeVentasNextel), 2)." %</cell>";
        $s .= "<cell>$ ".number_format($totalVentasComisiones, 2)."</cell>";
        $s .= "<cell>".number_format(($porcentajeComisionTelcel + $porcentajeComisionMovistar + $porcentajeComisionIusacell + $porcentajeComisionUnefon + $porcentajeComisionNextel), 2)." %</cell>";
        $s .= "</row>";
        $s .= "<row>";
        $s .= "<cell><![CDATA[Saldo Final]]></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell>$ ".number_format((($saldo_inicial + $montoTotalCompras + $totalVentasComisiones) - $totalTraspasosHechos), 2)."</cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "<cell></cell>";
        $s .= "</row>";
        $s .= "</rows>";
        echo $s;

        
    }
}
?>
