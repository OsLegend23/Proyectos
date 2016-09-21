<?php
include 'collect_info.php';
include 'mail.php';

$modelo = $_REQUEST['modelo'];
$marca = explode('@', $_REQUEST['marca']);
$marca2 = str_replace(" ", '%20', $marca[1]);
$serie = explode('@', $_REQUEST['serie']);
$serie2 = str_replace(" ", '%20', $serie[1]);
$version = explode('@', $_REQUEST['version']);
$version2 = str_replace(" ", '%20', $version[1]);
$estado = explode('@', $_REQUEST['sel_estado']);
$estado2 = str_replace(" ", '%20', $estado[1]);
$mpo = $_REQUEST['Mpo'];

$price = array();
$price = $collect_info->get_data_table($modelo, $marca[0], $serie[0], $version[0], $estado[0], $mpo, $marca2, $serie2, $estado2);

//Solicitud GNP
//$GNPCar = $collect_info->getIdCarGNP($marca[1], $modelo, $serie[1]);
$GNPCar = $_REQUEST['serieGNP'];
$GNPRC = $collect_info->getGNP($estado[0], $GNPCar, $marca[1], $modelo, 'RC');
$GNPLIM = $collect_info->getGNP($estado[0], $GNPCar, $marca[1], $modelo, 'LIMITADA');
$name = $_REQUEST['nombre'] . ' ' . $_REQUEST['apPaterno'] . ' ' . $_REQUEST['apMaterno'];
$mail = $_REQUEST['eMail'];
$cel = $_REQUEST['Cel'];
?>
<div class="span2"></div>
<div class="span8">
    <table id="cotizacion" class="table table-striped">
        <thead>
            <tr>
                <td colspan="6" style="font-weight: bold; text-align: center;">
                    Datos del Asegurado
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold;">
                    Nombre:
                </td>
                <td colspan="5">
                    <?php
                    echo $_REQUEST['nombre'] . ' ' . $_REQUEST['apPaterno'] . ' ' . $_REQUEST['apMaterno'];
                    ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">
                    Mail:
                </td>
                <td>
                    <?php
                    echo $_REQUEST['eMail'];
                    ?>
                </td>
                <td style="font-weight: bold;">
                    Celular:
                </td>
                <td>
                    <?php
                    echo $_REQUEST['Cel'];
                    ?>
                </td>
                <td style="font-weight: bold;">
                    Estado:
                </td>
                <td>
                    <?php
                    echo $estado[1];
                    ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">
                    Autom&oacute;vil:
                </td>
                <td colspan="5">
                    <?php
                    echo $version[1];
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="span2"></div>

<div class="span12">
    <table id="cotizacion" class="table table-striped table-bordered">
        <tr>
            <th scope="col">
                <b style="font-size:18px; color:red;">PAQUETES</b>
            </th>
            <th scope="col" colspan="3" style="text-align:center;">
                <a title="Más infomación" data-toggle="modal" href="#paquete1">
                    <img src="img/paq1.png" alt="pestañas cobertura sup" width="25%">
                </a>
            </th>
            <th scope="col" colspan="3" style="text-align:center;">
                <a title="Más infomación" data-toggle="modal" href="#paquete2">
                    <img src="img/paq2.png" alt="pestañas cobertura sup" width="25%">
                </a>
            </th>
            <th scope="col" colspan="3" style="text-align:center;">
                <a title="Más infomación" data-toggle="modal" href="#paquete3">
                    <img src="img/paq3.png" alt="pestañas cobertura sup" width="25%">
                </a>
            </th>
            <th scope="col" colspan="3" style="text-align:center;">
                <a title="Más infomación" data-toggle="modal" href="#paquete4">
                    <img src="img/paq4.png" alt="pestañas cobertura sup" width="25%">
                </a>
            </th>
        </tr>
        <tr>
            <th scope="col">
            </th>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[0][2]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[1][3]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[3][0]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[0][2]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[1][3]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[3][0]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[0][2]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[1][3]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[3][0]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[0][2]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[1][3]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[3][0]); ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="text-align:center;">
                <img src="http://www.anaseguros.com.mx/images/logo-ana-80x.png" alt="Anaseguros">
            </th>
            <!--AnaSeguros Cotizacion-->
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[0][3]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[2][0]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[3][1]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[1][0]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[2][1]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[3][2]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[1][1]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[2][2]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[3][3]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[1][2]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[2][3]); ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php print_r($price[4][0]); ?>
            </td>
        </tr>

        <tr>
            <th scope="row" style="text-align:center;">
                <img src="http://www.segurosatlas.com.mx/assets/images/logoSA.png" alt="Seguros Atlas">
            </th>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoAA = explode("$", $price[0][3]);
                $precioTemp = explode(',', $primerPagoAA[1]);
                $primerPagoAA = $precioTemp[0] . $precioTemp[1];
                $primerPagoAA = $primerPagoAA + rand(50, 200);
                echo "$" . number_format($primerPagoAA, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoAA2 = explode("$", $price[2][0]);
                $precioTemp2 = explode(',', $primerPagoAA2[1]);
                $primerPagoAA2 = $precioTemp2[0] . $precioTemp2[1];
                $primerPagoAA2 = $primerPagoAA2 + rand(50, 200);
                echo "$" . number_format($primerPagoAA2, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoAA3 = explode("$", $price[3][1]);
                $precioTemp3 = explode(',', $primerPagoAA3[1]);
                $primerPagoAA3 = $precioTemp3[0] . $precioTemp3[1];
                $primerPagoAA3 = $primerPagoAA3 + rand(50, 200);
                echo "$" . number_format($primerPagoAA3, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoA = explode("$", $price[1][0]);
                $precioTemp = explode(',', $primerPagoA[1]);
                $primerPagoA = $precioTemp[0] . $precioTemp[1];
                $primerPagoA = $primerPagoA + rand(50, 200);
                echo "$" . number_format($primerPagoA, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoA2 = explode("$", $price[2][1]);
                $precioTemp2 = explode(',', $primerPagoA2[1]);
                $primerPagoA2 = $precioTemp2[0] . $precioTemp2[1];
                $primerPagoA2 = $primerPagoA2 + rand(50, 200);
                echo "$" . number_format($primerPagoA2, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoA3 = explode("$", $price[3][2]);
                $precioTemp3 = explode(',', $primerPagoA3[1]);
                $primerPagoA3 = $precioTemp3[0] . $precioTemp3[1];
                $primerPagoA3 = $primerPagoA3 + rand(50, 200);
                echo "$" . number_format($primerPagoA3, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoL = explode("$", $price[1][1]);
                $precioTemp = explode(',', $primerPagoL[1]);
                $primerPagoL = $precioTemp[0] . $precioTemp[1];
                $primerPagoL = $primerPagoL + rand(50, 200);
                echo "$" . number_format($primerPagoL, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoL2 = explode("$", $price[2][2]);
                $precioTemp2 = explode(',', $primerPagoL2[1]);
                $primerPagoL2 = $precioTemp2[0] . $precioTemp2[1];
                $primerPagoL2 = $primerPagoL2 + rand(50, 200);
                echo "$" . number_format($primerPagoL2, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoL3 = explode("$", $price[3][3]);
                $precioTemp3 = explode(',', $primerPagoL3[1]);
                $primerPagoL3 = $precioTemp3[0] . $precioTemp3[1];
                $primerPagoL3 = $primerPagoL3 + rand(50, 200);
                echo "$" . number_format($primerPagoL3, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoRC = explode("$", $price[1][2]);
                $precioTemp = explode(',', $primerPagoRC[1]);
                $primerPagoRC = $precioTemp[0] . $precioTemp[1];
                $primerPagoRC = $primerPagoRC + rand(50, 200);
                echo "$" . number_format($primerPagoRC, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoRC2 = explode("$", $price[2][3]);
                $precioTemp2 = explode(',', $primerPagoRC2[1]);
                $primerPagoRC2 = $precioTemp2[0] . $precioTemp2[1];
                $primerPagoRC2 = $primerPagoRC2 + rand(50, 200);
                echo "$" . number_format($primerPagoRC2, 2);
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                $primerPagoRC3 = explode("$", $price[4][0]);
                $precioTemp3 = explode(',', $primerPagoRC3[1]);
                $primerPagoRC3 = $precioTemp3[0] . $precioTemp3[1];
                $primerPagoRC3 = $primerPagoRC3 + rand(50, 200);
                echo "$" . number_format($primerPagoRC3, 2);
                ?>
            </td>
        </tr>
        <tr>
            <th scope="row" style="text-align:center;">
                <img src="img/gnp10.jpg" alt="GNP Seguros" width="80%">
            </th>
            <td colspan="6" style="font-weight:bold; text-align:center;">
                <span>CONSULTE DIRECTAMENTE CON LA ASEGURADORA</span>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                echo $GNPLIM['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['TotalPagar'];
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                echo $GNPLIM['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['PrimerPago'];
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                echo $GNPLIM['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['PagosSubsecuentes'] . '<br>';
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                echo $GNPRC['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['TotalPagar'];
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                echo $GNPRC['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['PrimerPago'];
                ?>
            </td>
            <td style="font-weight:bold; text-align:center;">
                <?php
                echo $GNPRC['CotizarResult']['Emision']['Paquetes']['TotalesPaquetes']['Totales']['PagosSubsecuentes'] . '<br>';
                ?>
            </td>
        </tr>
    </table>
    <?php
    sendMail($name, $mail, $cel, $estado[1], $version[1], $price, $GNPLIM, $GNPRC,
            number_format($primerPagoAA, 2), number_format($primerPagoAA2, 2), number_format($primerPagoAA3, 2),
            number_format($primerPagoA, 2), number_format($primerPagoA2, 2), number_format($primerPagoA3, 2),
            number_format($primerPagoL3, 2), number_format($primerPagoL3, 2), number_format($primerPagoL3, 2),
            number_format($primerPagoRC, 2), number_format($primerPagoRC2, 2), number_format($primerPagoRC3, 2));                
        ?>
    <!-- Modal Dialog -->
    <div class="modal" id="paquete1" style="display: none;">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Cotización del Seguro</h3>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align:center;">
                            <img src="img/cob1.png" alt="pestañas cobertura sup" style="position: relative; bottom: -4px;">
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="13">
                            <div>
                                <img src="img/boton-conoce-con.png" alt="pestañas" style="position: relative; right: -5px;">
                            </div>
                        </td>
                        <td>
                            <b>
                                Daños Materiales
                            </b>
                            <a title="Ampara los daños materiales que sufra el vehículo asegurado hasta el Límite Máximo de Responsabilidad establecidos en la carátula de la póliza. " href="javascript:void(0)">
                                <img alt="" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            V. COMERCIAL + 10%
                            <br>
                            Deducible:5%
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> 
                                NPDPTDM*
                            </b>
                            <a title="Ampara los daños materiales que sufra el vehículo asegurado hasta el Límite Máximo de Responsabilidad establecidos en la carátula de la póliza." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Robo Total
                            </b>
                            <a title="Robo Total" rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            V. COMERCIAL + 10%
                            <br>
                            Deducible:10%
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil (Daños a terceros)
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en bienes y personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            1,000,000 LUC 
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> 
                                Responsabilidad Civil Bienes
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en bienes y personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            500,000 POR EVENTO
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil Personas 
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            500,000 POR EVENTO
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Extensión de Responsabilidad Civil
                            </b>
                            <a title="Ampara al conductor habitual mientras se encuentre conduciendo otro auto de uso particular diferente al asegurado contra los mismos riesgos y condiciones."  rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil del hijo menor
                            </b>
                            <a title="Ampara los daños a terceros en sus bienes y personas, causados por el hijo menor de edad del asegurado aunque conduzca sin permiso o licencia. " rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil remolques y caravanas
                            </b>
                            <a title="Ampara los daños a terceros producidos por remolques y caravanas y por los objetos transportados en el vehículo asegurado." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                RC CATASTROFICA POR MUERTE
                            </b>
                        </td>
                        <td style="text-align:center;">
                            2,000,000 POR EVENTO
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Gastos Médicos Ocupantes 
                            </b>
                            <a title="Ampara los gastos médicos que sufra el asegurado o los ocupantes del vehículo, incluyendo limpieza y acondicionamiento del vehículo por traslado de heridos. " rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            200,000
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Defensa Jurídica y Asistencia Legal 
                            </b>
                            <a title="Incluye honorarios de servicios de carácter jurídico por conducto de abogados, gastos de proceso civil, fianzas y cauciones, así como el pago de multas. Ampara asesoría legal para trámites por robo de vehículo, en adición para hechos no relacionados con un siniestro como son: elaboración de testamento, asesoría y tramitación para la obtención de pensiones, entre otros." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Auto Sustituto
                            </b>
                            <a title="Indemnización adicional que se otorga en pérdida total por daños materiales  hasta $10,000 para rentar un vehículo o sufragar los gastos de transportación." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            15,000
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
    </div>

    <div class="modal" id="paquete2" style="display: none;">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Cotización del Seguro</h3>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align:center;">
                            <img src="img/cob2.png" alt="pestañas cobertura sup" style="position: relative; bottom: -4px;">
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="12">
                            <div>
                                <img src="img/boton-conoce-con.png" alt="pestañas" style="position: relative; right: -5px;">
                            </div>
                        </td>
                        <td>
                            <b>
                                Daños Materiales
                            </b>
                            <a title="Ampara los daños materiales que sufra el vehículo asegurado hasta el Límite Máximo de Responsabilidad establecidos en la carátula de la póliza. " href="javascript:void(0)">
                                <img alt="" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            V. COMERCIAL
                            <br>
                            Deducible:5%
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> 
                                NPDPTDM*
                            </b>
                            <a title="Ampara los daños materiales que sufra el vehículo asegurado hasta el Límite Máximo de Responsabilidad establecidos en la carátula de la póliza." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Robo Total
                            </b>
                            <a title="Robo Total" rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            V. COMERCIAL + 10%
                            <br>
                            Deducible:10%
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil (Daños a terceros)
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en bienes y personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            1,000,000 LUC 
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> 
                                Responsabilidad Civil Bienes
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en bienes y personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            500,000 POR EVENTO
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil Personas 
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            500,000 POR EVENTO
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Extensión de Responsabilidad Civil
                            </b>
                            <a title="Ampara al conductor habitual mientras se encuentre conduciendo otro auto de uso particular diferente al asegurado contra los mismos riesgos y condiciones."  rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil del hijo menor
                            </b>
                            <a title="Ampara los daños a terceros en sus bienes y personas, causados por el hijo menor de edad del asegurado aunque conduzca sin permiso o licencia. " rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil remolques y caravanas
                            </b>
                            <a title="Ampara los daños a terceros producidos por remolques y caravanas y por los objetos transportados en el vehículo asegurado." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                RC CATASTROFICA POR MUERTE
                            </b>
                        </td>
                        <td style="text-align:center;">
                            2,000,000 POR EVENTO
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Gastos Médicos Ocupantes 
                            </b>
                            <a title="Ampara los gastos médicos que sufra el asegurado o los ocupantes del vehículo, incluyendo limpieza y acondicionamiento del vehículo por traslado de heridos. " rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            200,000
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Defensa Jurídica y Asistencia Legal 
                            </b>
                            <a title="Incluye honorarios de servicios de carácter jurídico por conducto de abogados, gastos de proceso civil, fianzas y cauciones, así como el pago de multas. Ampara asesoría legal para trámites por robo de vehículo, en adición para hechos no relacionados con un siniestro como son: elaboración de testamento, asesoría y tramitación para la obtención de pensiones, entre otros." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
    </div>

    <div class="modal" id="paquete3" style="display: none;">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Cotización del Seguro</h3>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align:center; font-weight: bold;">
                            ANASEGUROS / SEGUROS ATLAS
                        </td>
                        <td style="text-align: center; font-weight: bold;">GNP</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="11">
                            <div>
                                <img src="img/boton-conoce-con.png" alt="pestañas" style="position: relative; right: -5px;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Robo Total
                            </b>
                            <a title="Robo Total" rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            V. COMERCIAL + 10%
                            <br>
                            Deducible:10%
                            <br>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            echo $GNPLIM['CotizarResult']['Emision']['Paquetes']['Coberturas']['Cobertura']['0']['Suma_Asegurada']."<br>";
                            echo "Deducible: ". $GNPLIM['CotizarResult']['Emision']['Paquetes']['Coberturas']['Cobertura']['0']['Deducible']; 
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil (Daños a terceros)
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en bienes y personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            1,000,000 LUC 
                            <br>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            echo "Suma Asegurada: ".$GNPLIM['CotizarResult']['Emision']['Paquetes']['Coberturas']['Cobertura']['1']['Suma_Asegurada']."<br>";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> 
                                Responsabilidad Civil Bienes
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en bienes y personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            500,000 POR EVENTO
                            <br>
                        </td>
                        <td style="text-align: center;"></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil Personas 
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            500,000 POR EVENTO
                            <br>
                        </td>
                        <td style="text-align: center;"></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Extensión de Responsabilidad Civil
                            </b>
                            <a title="Ampara al conductor habitual mientras se encuentre conduciendo otro auto de uso particular diferente al asegurado contra los mismos riesgos y condiciones."  rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                        <td style="text-align: center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil del hijo menor
                            </b>
                            <a title="Ampara los daños a terceros en sus bienes y personas, causados por el hijo menor de edad del asegurado aunque conduzca sin permiso o licencia. " rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                        <td style="text-align: center;"></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil remolques y caravanas
                            </b>
                            <a title="Ampara los daños a terceros producidos por remolques y caravanas y por los objetos transportados en el vehículo asegurado." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                RC CATASTROFICA POR MUERTE
                            </b>
                        </td>
                        <td style="text-align:center;">
                            2,000,000 POR EVENTO
                            <br>
                        </td>
                        <td style="text-align: center;"></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Gastos Médicos Ocupantes 
                            </b>
                            <a title="Ampara los gastos médicos que sufra el asegurado o los ocupantes del vehículo, incluyendo limpieza y acondicionamiento del vehículo por traslado de heridos. " rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            200,000
                            <br>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            echo $GNPLIM['CotizarResult']['Emision']['Paquetes']['Coberturas']['Cobertura']['4']['Suma_Asegurada'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Defensa Jurídica y Asistencia Legal 
                            </b>
                            <a title="Incluye honorarios de servicios de carácter jurídico por conducto de abogados, gastos de proceso civil, fianzas y cauciones, así como el pago de multas. Ampara asesoría legal para trámites por robo de vehículo, en adición para hechos no relacionados con un siniestro como son: elaboración de testamento, asesoría y tramitación para la obtención de pensiones, entre otros." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                        <td style="text-align: center;">
                            <?php
                            echo $GNPLIM['CotizarResult']['Emision']['Paquetes']['Coberturas']['Cobertura']['3']['Suma_Asegurada'];
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
    </div>

    <div class="modal" id="paquete4" style="display: none;">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>Cotización del Seguro</h3>
        </div>
        <div class="modal-body">
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="text-align:center; font-weight: bold;">
                            ANASEGUROS / SEGUROS ATLAS
                        </td>
                        <td style="text-align: center; font-weight: bold;">GNP</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="10">
                            <div>
                                <img src="img/boton-conoce-con.png" alt="pestañas" style="position: relative; right: -5px;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil (Daños a terceros)
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en bienes y personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            1,000,000 LUC 
                            <br>
                        </td>
                        <td style="text-align:center;">
                            <?php
                            echo $GNPRC['CotizarResult']['Emision']['Paquetes']['Coberturas']['Cobertura']['0']['Suma_Asegurada']."<br>";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b> 
                                Responsabilidad Civil Bienes
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en bienes y personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            500,000 POR EVENTO
                            <br>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil Personas 
                            </b>
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en personas." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            500,000 POR EVENTO
                            <br>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Extensión de Responsabilidad Civil
                            </b>
                            <a title="Ampara al conductor habitual mientras se encuentre conduciendo otro auto de uso particular diferente al asegurado contra los mismos riesgos y condiciones."  rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                        <td style="text-align: center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil del hijo menor
                            </b>
                            <a title="Ampara los daños a terceros en sus bienes y personas, causados por el hijo menor de edad del asegurado aunque conduzca sin permiso o licencia. " rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align: center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Responsabilidad Civil remolques y caravanas
                            </b>
                            <a title="Ampara los daños a terceros producidos por remolques y caravanas y por los objetos transportados en el vehículo asegurado." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                RC CATASTROFICA POR MUERTE
                            </b>
                        </td>
                        <td style="text-align:center;">
                            2,000,000 POR EVENTO
                            <br>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Gastos Médicos Ocupantes 
                            </b>
                            <a title="Ampara los gastos médicos que sufra el asegurado o los ocupantes del vehículo, incluyendo limpieza y acondicionamiento del vehículo por traslado de heridos. " rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            200,000
                            <br>
                        </td>
                        <td style="text-align:center;">
                            <?php
                            echo $GNPRC['CotizarResult']['Emision']['Paquetes']['Coberturas']['Cobertura']['3']['Suma_Asegurada']."<br>";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>
                                Defensa Jurídica y Asistencia Legal 
                            </b>
                            <a title="Incluye honorarios de servicios de carácter jurídico por conducto de abogados, gastos de proceso civil, fianzas y cauciones, así como el pago de multas. Ampara asesoría legal para trámites por robo de vehículo, en adición para hechos no relacionados con un siniestro como son: elaboración de testamento, asesoría y tramitación para la obtención de pensiones, entre otros." rel="tooltip" data-original-title="Acerca de" href="#">
                                <img class="img_help_tooltip" src="img/onebit_37.png" width="5%">
                            </a>
                        </td>
                        <td style="text-align:center;">
                            <img src="img/palomita.png" alt="palomita">
                        </td>
                        <td style="text-align:center;">
                            <?php
                            echo $GNPRC['CotizarResult']['Emision']['Paquetes']['Coberturas']['Cobertura']['2']['Suma_Asegurada']."<br>";
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
    </div>
    <div style="text-align: center;">
        <a href="#" id="btnBack" class="btn btn-primary" onclick="location.reload();">Cotizar otro Automovil</a>
    </div>
</div>
