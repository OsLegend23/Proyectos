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

$result = $db->sql_query("SELECT COUNT(*) AS count FROM ventas WHERE carrier NOT LIKE 'AJUSTE COMISION%' AND idUsuario = $idUsr");

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
if ($perfil == 3) {
    $conT   = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE (carrier='TELCEL' OR carrier = 'TELCEL-PAGATAE') AND idUsuario = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $telcel = $db->sql_fetch_array($conT);
    $db->sql_free_result($conT);

    $conM     = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='MOVISTAR' AND idUsuario = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $movistar = $db->sql_fetch_array($conM);
    $db->sql_free_result($conM);

    $conI     = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='IUSACELL' AND idUsuario = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $iusacell = $db->sql_fetch_array($conI);
    $db->sql_free_result($conI);

    $conU   = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='UNEFON' AND idUsuario = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $unefon = $db->sql_fetch_array($conU);
    $db->sql_free_result($conU);

    $conNex = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='NEXTEL' AND idUsuario = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $nextel = $db->sql_fetch_array($conNex);
    $db->sql_free_result($conNex);

    $conC    = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='CACHITO' AND idUsuario = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $cachito = $db->sql_fetch_array($conC);
    $db->sql_free_result($conC);

    $conMel = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='MELATE' AND idUsuario = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $melate = $db->sql_fetch_array($conMel);
    $db->sql_free_result($conMel);
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    //$s .= "<total>".$total_pages."</total>";
    //$s .= "<records>".$count."</records>";
    // be sure to put text data in CDATA
    $s .= "<userdata name='ventas'>" . ($telcel['Ventas'] + $movistar['Ventas'] + $iusacell['Ventas'] + $unefon['Ventas'] + $nextel['Ventas'] + $cachito['Ventas'] + $melate['Ventas']) . "</userdata>";
    $s .= "<userdata name='monto'>" . ($telcel['Monto'] + $movistar['Monto'] + $iusacell['Monto'] + $unefon['Monto'] + $nextel['Monto'] + $cachito['Monto'] + $melate['Monto']) . "</userdata>";
    $s .= "<userdata name='comision'>" . ($telcel['Comision'] + $movistar['Comision'] + $iusacell['Comision'] + $unefon['Comision'] + $nextel['Comision'] + $cachito['Comision'] + $melate['Comision']) . "</userdata>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[TELCEL]]></cell>";
    $s .= "<cell>" . $telcel['Ventas'] . "</cell>";
    $s .= "<cell>" . $telcel['Monto'] . "</cell>";
    $s .= "<cell>" . $telcel['Comision'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[MOVISTAR]]></cell>";
    $s .= "<cell>" . $movistar['Ventas'] . "</cell>";
    $s .= "<cell>" . $movistar['Monto'] . "</cell>";
    $s .= "<cell>" . $movistar['Comision'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[IUSACELL]]></cell>";
    $s .= "<cell>" . $iusacell['Ventas'] . "</cell>";
    $s .= "<cell>" . $iusacell['Monto'] . "</cell>";
    $s .= "<cell>" . $iusacell['Comision'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[UNEFON]]></cell>";
    $s .= "<cell>" . $unefon['Ventas'] . "</cell>";
    $s .= "<cell>" . $unefon['Monto'] . "</cell>";
    $s .= "<cell>" . $unefon['Comision'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[NEXTEL]]></cell>";
    $s .= "<cell>" . $nextel['Ventas'] . "</cell>";
    $s .= "<cell>" . $nextel['Monto'] . "</cell>";
    $s .= "<cell>" . $nextel['Comision'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[CACHITO]]></cell>";
    $s .= "<cell>" . $cachito['Ventas'] . "</cell>";
    $s .= "<cell>" . $cachito['Monto'] . "</cell>";
    $s .= "<cell>" . $cachito['Comision'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[MELATE]]></cell>";
    $s .= "<cell>" . $melate['Ventas'] . "</cell>";
    $s .= "<cell>" . $melate['Monto'] . "</cell>";
    $s .= "<cell>" . $melate['Comision'] . "</cell>";
    $s .= "</row>";
    $s .= "</rows>";
    echo $s;
    $db->sql_close();
}
if ($perfil == 1) {
    $conT   = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='TELCEL' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $telcel = $db->sql_fetch_array($conT);
    $db->sql_free_result($conT);
    
    $conP    = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier = 'TELCEL-PAGATAE' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $pagatae = $db->sql_fetch_array($conP);
    $db->sql_free_result($conP);
    
    $conM     = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='MOVISTAR' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $movistar = $db->sql_fetch_array($conM);
    $db->sql_free_result($conM);
    
    $conI     = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='IUSACELL' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $iusacell = $db->sql_fetch_array($conI);
    $db->sql_free_result($conI);

    $conU   = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='UNEFON' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $unefon = $db->sql_fetch_array($conU);
    $db->sql_free_result($conU);
    
    $conC    = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='CACHITO' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $cachito = $db->sql_fetch_array($conC);
    $db->sql_free_result($conC);
    
    $conMel = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas WHERE carrier='MELATE' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $melate = $db->sql_fetch_array($conMel);
    $db->sql_free_result($conMel);
    
    $conN   = $db->sql_query("SELECT COUNT(*) FROM ventas WHERE carrier='NEXTEL' AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $nextel = $db->sql_fetch_array($conN);
    $db->sql_free_result($conN);
    

    $totalesVentas = $telcel['Monto'] + $pagatae['Monto'] + $movistar['Monto'] + $iusacell['Monto'] + $unefon['Monto'] + $nextel['Monto'] + $cachito['Monto'] + $melate['Monto'];

    $porcentajeTelcel = ($telcel['Monto'] / $totalesVentas) * 100;
    $porcentajePagatae = ($pagatae['Monto'] / $totalesVentas) * 100;
    $porcentajeMovi = ($movistar['Monto'] / $totalesVentas) * 100;
    $porcentajeIusa = ($iusacell['Monto'] / $totalesVentas) * 100;
    $porcentajeUne = ($unefon['Monto'] / $totalesVentas) * 100;
    $porcentajeNex = ($nextel['Monto'] / $totalesVentas) * 100;
    $porcentajeCachito = ($cachito['Monto'] / $totalesVentas) * 100;
    $porcentajeMelate = ($melate['Monto'] / $totalesVentas) * 100;
    //$dif = 100-($porcentajeTelcel + $porcentajeMovi + $porcentajeIusa + $$porcentajeUne + $porcentajeCachito + $porcentajeMelate);
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    //$s .= "<total>".$total_pages."</total>";
    //$s .= "<records>".$count."</records>";
    // be sure to put text data in CDATA
    $s .= "<userdata name='carrier'><![CDATA[<a href='scripts/php/php-excel/mysql.php?carrier=ALL&inicio=$inicio&final=$final'>TOTALES</a>]]></userdata>";
    $s .= "<userdata name='ventas'>" . ($telcel['Ventas'] + $pagatae['Ventas'] + $movistar['Ventas'] + $iusacell['Ventas'] + $unefon['Ventas'] + $nextel['Ventas'] + $cachito['Ventas'] + $melate['Ventas']) . "</userdata>";
    $s .= "<userdata name='monto'>" . $totalesVentas . "</userdata>";
    $s .= "<userdata name='comision'>" . ($telcel['Comision'] + $pagatae['Comision'] + $movistar['Comision'] + $iusacell['Comision'] + $unefon['Comision'] + $nextel['Comision'] + $cachito['Comision'] + $melate['Comision']) . "</userdata>";
    $s .= "<userdata name='porcentaje'>100</userdata>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='scripts/php/php-excel/mysql.php?carrier=T&inicio=$inicio&final=$final'>TARJETAS</a>]]></cell>";
    $s .= "<cell>" . $telcel['Ventas'] . "</cell>";
    $s .= "<cell>" . $telcel['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeTelcel . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='scripts/php/php-excel/mysql.php?carrier=P&inicio=$inicio&final=$final'>PAGATAE</a>]]></cell>";
    $s .= "<cell>" . $pagatae['Ventas'] . "</cell>";
    $s .= "<cell>" . $pagatae['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajePagatae . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='scripts/php/php-excel/mysql.php?carrier=M&inicio=$inicio&final=$final'>MOVISTAR</a>]]></cell>";
    $s .= "<cell>" . $movistar['Ventas'] . "</cell>";
    $s .= "<cell>" . $movistar['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeMovi . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='scripts/php/php-excel/mysql.php?carrier=I&inicio=$inicio&final=$final'>IUSACELL</a>]]></cell>";
    $s .= "<cell>" . $iusacell['Ventas'] . "</cell>";
    $s .= "<cell>" . $iusacell['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeIusa . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='scripts/php/php-excel/mysql.php?carrier=U&inicio=$inicio&final=$final'>UNEFON</a>]]></cell>";
    $s .= "<cell>" . $unefon['Ventas'] . "</cell>";
    $s .= "<cell>" . $unefon['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeUne . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='scripts/php/php-excel/mysql.php?carrier=N&inicio=$inicio&final=$final'>NEXTEL</a>]]></cell>";
    $s .= "<cell>" . $nextel['Ventas'] . "</cell>";
    $s .= "<cell>" . $nextel['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeNex . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='scripts/php/php-excel/mysql.php?carrier=C&inicio=$inicio&final=$final'>CACHITO</a>]]></cell>";
    $s .= "<cell>" . $cachito['Ventas'] . "</cell>";
    $s .= "<cell>" . $cachito['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeCachito . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[<a href='scripts/php/php-excel/mysql.php?carrier=ME&inicio=$inicio&final=$final'>MELATE</a>]]></cell>";
    $s .= "<cell>" . $melate['Ventas'] . "</cell>";
    $s .= "<cell>" . $melate['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeMelate . "</cell>";
    $s .= "</row>";
    $s .= "</rows>";
    echo $s;
    $db->sql_close();
}
if ($perfil == 2) {
    $conT   = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas, relaciones WHERE (carrier='TELCEL' OR carrier = 'TELCEL-PAGATAE') AND idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $telcel = $db->sql_fetch_array($conT);
    $db->sql_free_result($conT);

    $conM     = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas, relaciones WHERE carrier='MOVISTAR' AND idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $movistar = $db->sql_fetch_array($conM);
    $db->sql_free_result($conM);

    $conI     = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas, relaciones WHERE carrier='IUSACELL' AND idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $iusacell = $db->sql_fetch_array($conI);
    $db->sql_free_result($conI);

    $conU   = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas, relaciones WHERE carrier='UNEFON' AND idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $unefon = $db->sql_fetch_array($conU);
    $db->sql_free_result($conU);

    $conC    = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas, relaciones WHERE carrier='CACHITO' AND idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $cachito = $db->sql_fetch_array($conC);
    $db->sql_free_result($conC);

    $conMel = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto, SUM(comision) AS Comision FROM ventas, relaciones WHERE carrier='MELATE' AND idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $melate = $db->sql_fetch_array($conMel);
    $db->sql_free_result($conMel);

    $conN   = $db->sql_query("SELECT COUNT(*) FROM ventas, relaciones WHERE carrier='NEXTEL' AND idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUsr AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $nextel = $db->sql_fetch_array($conN);
    $db->sql_free_result($conN);


    $totalesVentas = $telcel['Monto'] + $movistar['Monto'] + $iusacell['Monto'] + $unefon['Monto'] + $nextel['Monto'] + $cachito['Monto'] + $melate['Monto'];

    $porcentajeTelcel = ($telcel['Monto'] / $totalesVentas) * 100;
    $porcentajeMovi = ($movistar['Monto'] / $totalesVentas) * 100;
    $porcentajeIusa = ($iusacell['Monto'] / $totalesVentas) * 100;
    $porcentajeUne = ($unefon['Monto'] / $totalesVentas) * 100;
    $porcentajeNex = ($nextel['Monto'] / $totalesVentas) * 100;
    $porcentajeCachito = ($cachito['Monto'] / $totalesVentas) * 100;
    $porcentajeMelate = ($melate['Monto'] / $totalesVentas) * 100;

    $dif = 100 - ($porcentajeTelcel + $porcentajeMovi + $porcentajeIusa + $$porcentajeUne + $porcentajeCachito + $porcentajeMelate);
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    //$s .= "<total>".$total_pages."</total>";
    //$s .= "<records>".$count."</records>";
    // be sure to put text data in CDATA
    $s .= "<userdata name='ventas'>" . ($telcel['Ventas'] + $movistar['Ventas'] + $iusacell['Ventas'] + $unefon['Ventas'] + $nextel['Ventas'] + $cachito['Ventas'] + $melate['Ventas']) . "</userdata>";
    $s .= "<userdata name='monto'>" . $totalesVentas . "</userdata>";
    $s .= "<userdata name='comision'>" . ($telcel['Comision'] + $movistar['Comision'] + $iusacell['Comision'] + $unefon['Comision'] + $nextel['Comision'] + $cachito['Comision'] + $melate['Comision']) . "</userdata>";
    $s .= "<userdata name='porcentaje'>" . ($porcentajeTelcel + $porcentajeMovi + $porcentajeIusa + $$porcentajeUne + $porcentajeCachito + $porcentajeMelate + $dif) . "</userdata>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[TELCEL]]></cell>";
    $s .= "<cell>" . $telcel['Ventas'] . "</cell>";
    $s .= "<cell>" . $telcel['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeTelcel . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[MOVISTAR]]></cell>";
    $s .= "<cell>" . $movistar['Ventas'] . "</cell>";
    $s .= "<cell>" . $movistar['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeMovi . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[IUSACELL]]></cell>";
    $s .= "<cell>" . $iusacell['Ventas'] . "</cell>";
    $s .= "<cell>" . $iusacell['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeIusa . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[UNEFON]]></cell>";
    $s .= "<cell>" . $unefon['Ventas'] . "</cell>";
    $s .= "<cell>" . $unefon['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeUne . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[NEXTEL]]></cell>";
    $s .= "<cell>" . $nextel['Ventas'] . "</cell>";
    $s .= "<cell>" . $nextel['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeNex . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[CACHITO]]></cell>";
    $s .= "<cell>" . $cachito['Ventas'] . "</cell>";
    $s .= "<cell>" . $cachito['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeCachito . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[MELATE]]></cell>";
    $s .= "<cell>" . $melate['Ventas'] . "</cell>";
    $s .= "<cell>" . $melate['Monto'] . "</cell>";
    $s .= "<cell>" . $porcentajeMelate . "</cell>";
    $s .= "</row>";
    $s .= "</rows>";
    echo $s;
    $db->sql_close();
}
if ($perfil == 4) {
    $idCajero = $db->sql_result($db->sql_query("SELECT idCajero FROM cajero WHERE idUsuario = $idUsr"), 0);
    $conT   = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto FROM ventas WHERE (carrier='TELCEL' OR carrier = 'TELCEL-PAGATAE') AND idCajero = $idCajero AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $telcel = $db->sql_fetch_array($conT);
    $db->sql_free_result($conT);

    $conM     = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto FROM ventas WHERE carrier='MOVISTAR' AND idCajero = $idCajero AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $movistar = $db->sql_fetch_array($conM);
    $db->sql_free_result($conM);

    $conI     = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto FROM ventas WHERE carrier='IUSACELL' AND idCajero = $idCajero AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $iusacell = $db->sql_fetch_array($conI);
    $db->sql_free_result($conI);

    $conU   = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto FROM ventas WHERE carrier='UNEFON' AND idCajero = $idCajero AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $unefon = $db->sql_fetch_array($conU);
    $db->sql_free_result($conU);

    $conNex = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto FROM ventas WHERE carrier='NEXTEL' AND idCajero = $idCajero AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $nextel = $db->sql_fetch_array($conNex);
    $db->sql_free_result($conNex);

    $conC    = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto FROM ventas WHERE carrier='CACHITO' AND idCajero = $idCajero AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $cachito = $db->sql_fetch_array($conC);
    $db->sql_free_result($conC);

    $conMel = $db->sql_query("SELECT COUNT(*) AS Ventas, SUM(monto) AS Monto FROM ventas WHERE carrier='MELATE' AND idCajero = $idCajero AND DATE(fecha) >= '$inicio' AND DATE(fecha) <= '$final'");
    $melate = $db->sql_fetch_array($conMel);
    $db->sql_free_result($conMel);
    
    header("Content-type: text/xml;charset=iso-8859-1");
    $s = "<?xml version='1.0' encoding='iso-8859-1'?>";
    $s .= "<rows>";
    $s .= "<page>" . $page . "</page>";
    //$s .= "<total>".$total_pages."</total>";
    //$s .= "<records>".$count."</records>";
    // be sure to put text data in CDATA
    $s .= "<userdata name='ventas'>" . ($telcel['Ventas'] + $movistar['Ventas'] + $iusacell['Ventas'] + $unefon['Ventas'] + $nextel['Ventas'] + $cachito['Ventas'] + $melate['Ventas']) . "</userdata>";
    $s .= "<userdata name='monto'>" . ($telcel['Monto'] + $movistar['Monto'] + $iusacell['Monto'] + $unefon['Monto'] + $nextel['Monto'] + $cachito['Monto'] + $melate['Monto']) . "</userdata>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[TELCEL]]></cell>";
    $s .= "<cell>" . $telcel['Ventas'] . "</cell>";
    $s .= "<cell>" . $telcel['Monto'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[MOVISTAR]]></cell>";
    $s .= "<cell>" . $movistar['Ventas'] . "</cell>";
    $s .= "<cell>" . $movistar['Monto'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[IUSACELL]]></cell>";
    $s .= "<cell>" . $iusacell['Ventas'] . "</cell>";
    $s .= "<cell>" . $iusacell['Monto'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[UNEFON]]></cell>";
    $s .= "<cell>" . $unefon['Ventas'] . "</cell>";
    $s .= "<cell>" . $unefon['Monto'] . "</cell>";
    $s .= "</row>";
    $s .= "</rows>";
    $s .= "<cell><![CDATA[NEXTEL]]></cell>";
    $s .= "<cell>" . $nextel['Ventas'] . "</cell>";
    $s .= "<cell>" . $nextel['Monto'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[CACHITO]]></cell>";
    $s .= "<cell>" . $cachito['Ventas'] . "</cell>";
    $s .= "<cell>" . $cachito['Monto'] . "</cell>";
    $s .= "</row>";
    $s .= "<row>";
    $s .= "<cell><![CDATA[MELATE]]></cell>";
    $s .= "<cell>" . $melate['Ventas'] . "</cell>";
    $s .= "<cell>" . $melate['Monto'] . "</cell>";
    $s .= "</row>";
    $s .= "</rows>";
    echo $s;
    $db->sql_close();
}
?>