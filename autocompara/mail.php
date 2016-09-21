<?php

include "lib/PHPMailer/class.phpmailer.php";

function sendMail($name, $email, $cel, $state, $version, array $price, array $GNPLIM, array $GNPRC, 
                  $primerPagoAA, $primerPagoAA2, $primerPagoAA3, 
                  $primerPagoA, $primerPagoA2, $primerPagoA3, 
                  $primerPagoL, $primerPagoL2, $primerPagoL3, 
                  $primerPagoRC, $primerPagoRC2, $primerPagoRC3) 
{
    $mail = new PHPMailer();
    $mail->Host = "haztuseguro.com";
    $mail->From = "cotizaciones@haztuseguro.com";
    $mail->FromName = "HazTuSeguro.com";
    $mail->Subject = utf8_decode("Cotización");

    $body = "<div class='container'>
            <div class='span2'></div>
            <div class='span8' style='margin-left: 10px;'>
                <table class='table table-striped table-bordered' border='1' style='border-collapse: collapse;'>
                    <tr>
                        <th colspan='6' style='text-align:center;' scope='col'>
                            <img src='http://cotizador.haztuseguro.com/img/haztusegurologo.png' alt='Cotiza Tu Seguro' />
                        </th>
                    </tr>
                    <tr>
                        <td colspan='6' style='text-align:center;'> Datos del Asegurado </td>
                    </tr>
                    <tr>
                        <td>NOMBRE:</td>
                        <td colspan='5'>$name</td>
                    </tr>
                    <tr>
                        <td>Mail:</td>
                        <td>$email</td>
                        <td>Celular:</td>
                        <td>$cel</td>
                        <td>Estado:</td>
                        <td>$state</td>
                    </tr>
                    <tr>
                        <td>Automovil:</td>
                        <td colspan='5'>$version</td>
                    </tr>
                </table>
            </div>
            <div class='span2'></div>
            <div class='span12' style='margin-left: 0;'>
                <table class='table table-striped table-bordered' border='1' style='border-collapse: collapse;'>
                    <tr>
                        <th style='text-align:center;' scope='col'>PAQUETES</th>
                        <th colspan='3' scope='col' style='text-align:center;'><img src='http://cotizador.haztuseguro.com/img/paq1.png' /></th>
                        <th colspan='3' scope='col' style='text-align:center;'><img src='http://cotizador.haztuseguro.com/img/paq2.png' /></th>
                        <th colspan='3' scope='col' style='text-align:center;'><img src='http://cotizador.haztuseguro.com/img/paq3.png' /></th>
                        <th colspan='3' scope='col' style='text-align:center;'><img src='http://cotizador.haztuseguro.com/img/paq4.png' /></th>
                    </tr>
                    <tr>
                        <th scope='row'>&nbsp;</th>
                        <td style='text-align:center;'>Precio</td>
                        <td style='text-align:center;'>Primer Pago</td>
                        <td style='text-align:center;'>Subsecuente (3)</td>
                        <td style='text-align:center;'>Precio</td>
                        <td style='text-align:center;'>Primer Pago</td>
                        <td style='text-align:center;'>Subsecuente (3)</td>
                        <td style='text-align:center;'>Precio</td>
                        <td style='text-align:center;'>Primer Pago</td>
                        <td style='text-align:center;'>Subsecuente (3)</td>
                        <td style='text-align:center;'>Precio</td>
                        <td style='text-align:center;'>Primer Pago</td>
                        <td style='text-align:center;'>Subsecuente (3)</td>
                    </tr>
                    <tr>
                        <th scope='row' style='text-align:center;'><img src='http://www.anaseguros.com.mx/images/logo-ana-80x.png' alt='Ana Seguros' width='320' height='80' /></th>
                        <td>".$price[0][3]."</td>
                        <td>".$price[2][0]."</td>
                        <td>".$price[3][1]."</td>
                        <td>".$price[1][0]."</td>
                        <td>".$price[2][1]."</td>
                        <td>".$price[3][2]."</td>
                        <td>".$price[1][1]."</td>
                        <td>".$price[2][2]."</td>
                        <td>".$price[3][3]."</td>
                        <td>".$price[1][2]."</td>
                        <td>".$price[2][3]."</td>
                        <td>".$price[4][0]."</td>
                    </tr>
                    <tr>
                        <th scope='row' style='text-align:center;'><img src='http://www.segurosatlas.com.mx/assets/images/logoSA.png' alt='Seguro Atlas' width='249' height='94' /></th>
                        <td>$$primerPagoAA</td>
                        <td>$$primerPagoAA2</td>
                        <td>$$primerPagoAA3</td>
                        <td>$$primerPagoA</td>
                        <td>$$primerPagoA2</td>
                        <td>$$primerPagoA3</td>
                        <td>$$primerPagoL</td>
                        <td>$$primerPagoL2</td>
                        <td>$$primerPagoL3</td>
                        <td>$$primerPagoRC</td>
                        <td>$$primerPagoRC2</td>
                        <td>$$primerPagoRC3</td>
                    </tr>
                    <tr>
                        <th scope='row' style='text-align:center;'><img src='http://cotizador.haztuseguro.com/img/gnp10.jpg' alt='GNP Seguros' width='50%' /></th>
                        <td colspan='6' style='text-align:center;'> CONSULTE DIRECTAMENTE CON LA ASEGURADORA  </td>
                        <td>".$GNPLIM['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['TotalPagar']."</td>
                        <td>".$GNPLIM['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['PrimerPago']."</td>
                        <td>".$GNPLIM['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['PagosSubsecuentes']."</td>
                        <td>".$GNPRC['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['TotalPagar']."</td>
                        <td>".$GNPRC['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['PrimerPago']."</td>
                        <td>".$GNPRC['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['PagosSubsecuentes']."</td>
                    </tr>
                </table>
            </div>
        </div>";
    
    $mail->AddAddress($email);
    $mail->AddBCC("gustavo@aisseguros.com");
    //$mail->MsgHTML($body);
    $mail->Body = $body;
    $mail->IsHTML(true);
    $mail->Send();
//    if ($mail->Send()) {
////Sacamos un mensaje de que todo ha ido correctamente.
//        echo "Mensaje enviado correctamente.";
//    } else {
////Sacamos un mensaje con el error.
//        echo "Ocurrió un error al enviar el correo electrónico.";
//        echo "<br/><strong>Información:</strong><br/>" . $mail->ErrorInfo;
//    }
}

?>
