<?php 
date_default_timezone_set('America/Mexico_City');
require_once ("conexion.php");
$db = new Conexion;
$db->sql_connect();

$filename = 'R_4DE'.date('dmY', mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));


$ext = "txt"; // file extension
$mime_type = (PMA_USR_BROWSER_AGENT == 'IE' || PMA_USR_BROWSER_AGENT == 'OPERA') ? 'application/octetstream' : 'application/octet-stream';
header('Content-Type: '.$mime_type);
if (PMA_USR_BROWSER_AGENT == 'IE') {
    header('Content-Disposition: inline; filename="'.$filename.'.'.$ext.'"');
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    
    //cabecera -------------------------------------------------------------------
    $yesterday = date('Ymd', mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));
    print "HDR$yesterday"."\r\n";
    //detalle --------------------------------------------------------------------
    $contador = 0;
    $strqry = "SELECT @m := @m +1 AS RowNum, DATE_FORMAT( fecha, '%Y%m%d' ) AS Fecha, DATE_FORMAT( fecha, '%H%i%s' ) AS Hora, autorizacion AS NumAuto, destino AS Telefono, monto AS Monto, idUsuario AS TerminalID
				   FROM (SELECT @m :=0)r, ventas u
				   WHERE carrier = 'TELCEL'
				   AND fecha < curdate( ) - INTERVAL 1 DAY
				   AND fecha > DATE_ADD( CURDATE( ) , INTERVAL -2 DAY )
                   ORDER BY fecha ASC";
    $myquery = $db->sql_query($strqry);
    while ($data = $db->sql_fetch_array($myquery)) {
        print "REG".substr('000000'.$data["RowNum"], -6).$data["Fecha"].$data["Hora"].substr('000000'.$data["NumAuto"], -6).$data["Telefono"]."TELC".substr('000000'.$data["Monto"], -4).'0002'.'0000000000000000'."\r\n";//TELC000000300
    }
    
    //pie ------------------------------------------------------------------------
    $strqry = "SELECT Count( idUsuario ) AS NumReg, SUM( monto ) AS TotalSalles
				   FROM ventas
				   WHERE carrier = 'TELCEL' AND fecha < curdate( ) AND fecha > DATE_ADD( CURDATE( ) , INTERVAL -2 DAY ) ";
    $myquery = $db->sql_query($strqry) or die(mysql_error());
    $row = $db->sql_fetch_array($myquery);
    print 'TRL'.substr('000000'.$row["NumReg"], -6).substr('000000000000'.$row["TotalSalles"], -12);
    
} else {
    header('Content-Disposition: attachment; filename="'.$filename.'.'.$ext.'"');
    header("Content-Transfer-Encoding: binary");
    header('Expires: 0');
    header('Pragma: no-cache');
    //cabecera
    $yesterday = date('Ymd', mktime(0, 0, 0, date("m"), date("d") - 2, date("Y")));
    print "HDR$yesterday"."\r\n";
    
    //detalle
    $contador = 0;
    $strqry = "SELECT @m := @m +1 AS RowNum, DATE_FORMAT( fecha, '%Y%m%d' ) AS Fecha, DATE_FORMAT( fecha, '%H%i%s' ) AS Hora, autorizacion AS NumAuto, destino AS Telefono, monto AS Monto, idUsuario AS TerminalID
				   FROM (SELECT @m :=0)r, ventas u
				   WHERE carrier = 'TELCEL'
				   AND fecha < curdate( ) - INTERVAL 1 DAY
				   AND fecha > DATE_ADD( CURDATE( ) , INTERVAL -2 DAY )
                   ORDER BY fecha ASC";
    $myquery = $db->sql_query($strqry) or die(mysql_error());
    while ($data = $db->sql_fetch_array($myquery)) {
        print "REG".substr('000000'.$data["RowNum"], -6).$data["Fecha"].$data["Hora"].substr('000000'.$data["NumAuto"], -6).$data["Telefono"]."TELC".substr('000000'.$data["Monto"], -4).'0002'.'0000000000000000'."\r\n";
    }
    
    //pie
    $strqry = "SELECT Count( idUsuario ) AS NumReg, SUM( monto ) AS TotalSalles
				   FROM ventas
				   WHERE carrier = 'TELCEL' AND fecha < curdate( ) AND fecha > DATE_ADD( CURDATE( ) , INTERVAL -2 DAY ) ";
    $myquery = $db->sql_query($strqry) or die(mysql_error());
    $row = $db->sql_fetch_array($myquery);
    print 'TRL'.substr('000000'.$row["NumReg"], -6).substr('000000000000'.$row["TotalSalles"], -12);
    
}

/*} else
 echo "Inicie sesión";*/
?>
