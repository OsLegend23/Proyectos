<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
date_default_timezone_set('America/Mexico_City');
if (isset($_SESSION["l_usr"])) { // and md5($_POST['code']) = $_SESSION['key']
    $monto = $_REQUEST['monto'];
    $telefono = $_REQUEST['celular'];
    $carrier = $_REQUEST['carrier'];
    $idUsr = $_SESSION['l_usr'];
    
    switch ($carrier) {
        case 'CACHITO':
            require 'cachito.class.php';
            $cachito = new CachitoMovil($telefono, $monto);
            $ultimaRec = $cachito->ultimaRecarga($idUsr, $telefono, $carrier);
            if (strtotime($ultimaRec) >= strtotime(date('Y-m-d H:i:s'))) {
                echo "<script type='text/javascript'>
					alert('Ya realizó una petición a este número');
					history.go(-3);
				</script>";
            } else {
                $saldoXYZ = $cachito->saldoActual($idUsr);
                if ($saldoXYZ > 0 && $saldoXYZ >= $monto) {
                
                    $jugar = $cachito->jugarCachito($idUsr);
                    if ($jugar["result"] == "SUCCESS") {
                        $cerrar = $cachito->cerrarCachito($jugar["authCode"], $idUsr);//Cerramos la transacción con Cachito
                        $nombrecomercial = $cachito->NombreComercio($idUsr);
                        $monto = number_format($monto, 2);
                        $fecha = date('d/m/Y');
                        $hora = date('H:i:s');
                        $notrans = $cachito->noTicket();
                        $mensaje = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><title>Ticket de Compra</title>";
                        $mensaje .= "<style type='text/css'>@media print {body {font-family: Arial, Helvetica, sans-serif;font-size: 12px;}table{width:250px;}th{font-weight: normal;}#aclaracion {font-size:8px;}.direccion {font-size: 11px;font-style: italic;}button {visibility: hidden;}}";
                        $mensaje .= "@media screen {body {font-family: Arial, Helvetica, sans-serif;}th {font-weight: normal;}#aclaracion {font-size:10px;}.direccion {font-size: 12px;font-style: italic;}}</style>";
                        $mensaje .= "<script type='text/javascript' language='JavaScript'>function imprimirTicket(){if (window.print) {window.print();}else {alert('Tu navegador no puede imprimir el ticket, reliza la impresion desde el menu archivo.');}}</script></head>";
                        $mensaje .= "<body><div align='center'><table width='300' border='0' id='ticket'><thead><tr><th colspan='4'>";
                        $mensaje .= "<div align='center'><strong>Servicios y Recargas Electrónicas<br/>S. de R.L.</strong>";
                        $mensaje .= "<div class='direccion'>Luis Vega y Monroy 703-5, Plazas del Sol<br/>Querétaro, Qro<br/>TEL (442)-22-35-620</div></div></th></tr>";
                        $mensaje .= "<tr><th colspan='4'><div align='center'>.::COMERCIO::.</div></th></tr><tr><th colspan='4'>";
                        $mensaje .= "<div align='center'><strong>$nombrecomercial</strong></div></th></tr></thead>";
                        $mensaje .= "<tfoot><tr><td colspan='4'><hr/></td></tr><tr><td colspan='4'>";
                        $mensaje .= "<div align='center' id='aclaracion'>
	                               Gracias por su compra
	                           </div></td></tr></tfoot>";
                        $mensaje .= "<tbody><tr><td colspan='4'><hr/></td></tr><tr><td></td><td></td>";
                        $mensaje .= "<td>No. Ticket:</td><td>$notrans</td></tr><tr><td>";
                        $mensaje .= "<div align='right'>Fecha:</div></td><td><div align='left'>$fecha</div></td>";
                        $mensaje .= "<td><div align='right'>Hora:</div></td><td><div align='left'>$hora</div></td></tr>";
                        $mensaje .= "<tr><td colspan='4'><hr/></td></tr><tr><td></td><td>";
                        $mensaje .= "<div align='right'>Celular:</div></td><td><div align='left'>$telefono</div></td>";
                        $mensaje .= "<td>&nbsp;</td></tr><tr><td></td><td>";
                        $mensaje .= "<div align='right'>Número de Autorización:</div></td><td><div align='left'>$cerrar[authCode]</div></td>";
                        $mensaje .= "<td>&nbsp;</td></tr><tr><td></td><td><div align='right'>Saldo Inicial Cachito:</div></td>";
                        $mensaje .= "<td><div align='left'>$ $cerrar[startBalance]</div></td><td>&nbsp;</td></tr><tr><td></td><td>";
                        $mensaje .= "<div align='right'>Saldo Final Cachito:</div></td><td><div align='left'>$ $cerrar[endBalance]</div></td><td>&nbsp;</td></tr>";
                        $mensaje .= "<tr><td></td><td><div align='right'>Monto de la Recarga</div></td><td><div align='left'>$ $monto</div></td><td>&nbsp;</td></tr></tbody></table>";
                        $mensaje .= "<button type='button' value='Imprimir Ticket' onclick='imprimirTicket();'>Imprimir Ticket</button></div></body></html>";
                        echo $mensaje;
                        $cachito->regitrarVenta($idUsr, $monto, $carrier, $telefono, $cerrar["authCode"]);
                        $ticket = "$nombrecomercial+$notrans+$fecha+$hora+$telefono+$cerrar[authCode]+$cerrar[startBalance]+$cerrar[endBalance]+$monto+CACHITO";
                        $cachito->registrarTicket($ticket);
                    } else {
                        echo "<div style='text-align:center; font-family:Arial,sans-serif;'>No se pudo completar el proceso de juego: <br />($jugar[errorCode]) $jugar[reason]<br />";
                        $cachito->cerrarCachito($jugar["authCode"], $idUsr);
                    }
                    
                } else
                    echo "<div style='text-align:center; font-family:Arial,sans-serif;' >Por el momento no puede hacer recargas por falta de saldo. Por favor, contacte a su proveedor.</div>";
            }
            break;
            
        case "MELATE":
            require 'melate.class.php';
            $melate = new MelateMovil($telefono, $monto);
            $ultimaRec = $melate->ultimaRecarga($idUsr, $telefono, $carrier);
            if (strtotime($ultimaRec) >= strtotime(date('Y-m-d H:i:s'))) {
                echo "<script type='text/javascript'>
					alert('Ya realizó una petición a este número');
					history.go(-4);
				</script>";
            } else {
                $saldoXYZ = $melate->saldoActual($idUsr);
                if ($saldoXYZ > 0 && $saldoXYZ >= $monto) {
                    $jugar = $melate->jugarMelate($idUsr);
                    if ($jugar["result"] == "SUCCESS") {
                        $cerrar = $melate->cerrarMelate($jugar["authCode"], $idUsr);
                        $nombrecomercial = $melate->NombreComercio($idUsr);
                        $monto = number_format($monto, 2);
                        $fecha = date('d/m/Y');
                        $hora = date('H:i:s');
                        $notrans = $melate->noTicket();
                        $mensaje = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'><html xmlns='http://www.w3.org/1999/xhtml'><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><title>Ticket de Compra</title>";
                        $mensaje .= "<style type='text/css'>@media print {body {font-family: Arial, Helvetica, sans-serif;font-size: 12px;}table{width:250px;}th{font-weight: normal;}#aclaracion {font-size:8px;}.direccion {font-size: 11px;font-style: italic;}button {visibility: hidden;}}";
                        $mensaje .= "@media screen {body {font-family: Arial, Helvetica, sans-serif;}th {font-weight: normal;}#aclaracion {font-size:10px;}.direccion {font-size: 12px;font-style: italic;}}</style>";
                        $mensaje .= "<script type='text/javascript' language='JavaScript'>function imprimirTicket(){if (window.print) {window.print();}else {alert('Tu navegador no puede imprimir el ticket, reliza la impresion desde el menu archivo.');}}</script></head>";
                        $mensaje .= "<body><div align='center'><table width='300' border='0' id='ticket'><thead><tr><th colspan='4'>";
                        $mensaje .= "<div align='center'><strong>Servicios y Recargas Electrónicas<br/>S. de R.L.</strong>";
                        $mensaje .= "<div class='direccion'>Luis Vega y Monroy 703-5, Plazas del Sol<br/>Querétaro, Qro<br/>TEL (442)-22-35-620</div></div></th></tr>";
                        $mensaje .= "<tr><th colspan='4'><div align='center'>.::COMERCIO::.</div></th></tr><tr><th colspan='4'>";
                        $mensaje .= "<div align='center'><strong>$nombrecomercial</strong></div></th></tr></thead>";
                        $mensaje .= "<tfoot><tr><td colspan='4'><hr/></td></tr><tr><td colspan='4'>";
                        $mensaje .= "<div align='center' id='aclaracion'>
	                               Gracias por su compra
	                           </div></td></tr></tfoot>";
                        $mensaje .= "<tbody><tr><td colspan='4'><hr/></td></tr><tr><td></td><td></td>";
                        $mensaje .= "<td>No. Ticket:</td><td>$notrans</td></tr><tr><td>";
                        $mensaje .= "<div align='right'>Fecha:</div></td><td><div align='left'>$fecha</div></td>";
                        $mensaje .= "<td><div align='right'>Hora:</div></td><td><div align='left'>$hora</div></td></tr>";
                        $mensaje .= "<tr><td colspan='4'><hr/></td></tr><tr><td></td><td>";
                        $mensaje .= "<div align='right'>Celular:</div></td><td><div align='left'>$telefono</div></td>";
                        $mensaje .= "<td>&nbsp;</td></tr><tr><td></td><td>";
                        $mensaje .= "<div align='right'>Número de Autorización:</div></td><td><div align='left'>$cerrar[authCode]</div></td>";
                        $mensaje .= "<td>&nbsp;</td></tr><tr><td></td><td><div align='right'>Saldo Inicial Melate:</div></td>";
                        $mensaje .= "<td><div align='left'>$ $cerrar[startBalance]</div></td><td>&nbsp;</td></tr><tr><td></td><td>";
                        $mensaje .= "<div align='right'>Saldo Final Melate:</div></td><td><div align='left'>$ $cerrar[endBalance]</div></td><td>&nbsp;</td></tr>";
                        $mensaje .= "<tr><td></td><td><div align='right'>Monto de la Recarga</div></td><td><div align='left'>$ $monto</div></td><td>&nbsp;</td></tr></tbody></table>";
                        $mensaje .= "<button type='button' value='Imprimir Ticket' onclick='imprimirTicket();'>Imprimir Ticket</button></div></body></html>";
                        echo $mensaje;
                        $melate->regitrarVenta($idUsr, $monto, $carrier, $telefono, $cerrar["authCode"]);
                        $ticket = "$nombrecomercial+$notrans+$fecha+$hora+$telefono+$cerrar[authCode]+$cerrar[startBalance]+$cerrar[endBalance]+$monto+MELATE";
                        $melate->registrarTicket($ticket);
                    } else {
                        echo "<div style='text-align:center; font-family:Arial,sans-serif;'>No se pudo completar el proceso de juego: <br />($jugar[errorCode]) $jugar[reason]<br />";
                        $melate->cerrarMelate($jugar["authCode"], $idUsr);
                    }
                    
                } else
                    echo "<div style='text-align:center; font-family:Arial,sans-serif;' >Por el momento no puede hacer recargas por falta de saldo. Por favor, contacte a su proveedor.</div>";
            }
            
            break;
    }
}

?>
