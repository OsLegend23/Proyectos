<?php
$numimg = 3;
$random = rand(1,$numimg);
$img = array();
$txt = array();

$img[1] = "img/gnp.gif";
$txt[1] = "GNP SEGUROS";

$img[2] = "img/aba.jpg";
$txt[2] = "ABA SEGUROS";

$img[3] = "img/inbursa.jpg";
$txt[3] = "SEGUROS INBURSA";

echo "<img src='$img[$random]' alt='$txt[random]' border='0'>";
?>


<div style="alignment-adjust: central;">
    <table width="900" cellspacing="0" style="font-size:12px; font-family:verdana; color:#202020;">
        <tr>
        <tr>
            <th>
                Datos del Asegurado
            </th>
        </tr>
        <tr>
            <td>
                Asegurado:
            </td>
            <td>
                <?php
                echo $_POST["nombre"] . " " . $_POST["apPaterno"] . " " . $_POST["apMaterno"];
                ?>
            </td>
            <td>
                Celular:
            </td>
            <td>
                <?php
                echo $_POST["Cel"];
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Estado:
            </td>
            <td>
                <?php
                echo $_POST["ComboEstados"];
                ?>
            </td>
            <td>
                E-Mail:
            </td>
            <td>
                <?php
                echo $_POST["eMail"];
                ?>
            </td>
        </tr>
        <tr>
            <th>
                Datos del Veh&iacute;culo
            </th>
        </tr>
        <tr>
            <td>
                Tipo:
            </td>
            <td>
                <?php
                echo $_POST["tipo"];
                ?>
            </td>
            <td>
                Modelo:
            </td>
            <td>
                <?php
                echo $_POST["modelo"];
                ?>
            </td>
        </tr>
        <tr>
            <td>
                Descripci&oacute;n:
            </td>
            <td>
                <?php
                echo $_POST["vehiculo"];
                ?>
            </td>
        </tr>
    </table>
</div>
<div style=" text-align: center; width:100%;" id="Cotizacion_echa">
    <script type="text/javascript" src="http://www.likno.com/likno-scripts/likno-tooltips-content.js"></script>
    <table width="900" cellspacing="0" style="font-size:12px; font-family:verdana; color:#202020;">
        <tbody>
            <tr>
                <td></td>
                <th style="text-align:center;">
                    <b style="font-size:18px; color:red;">PAQUETES:</b>
                </th>
                <th style="text-align:center;">
                    AMPLIA PLUS
                </th>
                <th style="text-align:center;">
                    AMPLIA
                </th>
                <th style="text-align:center;">
                    LIMITADA
                </th>
                <th style="text-align:center;">
                    RESPONSABILIDAD CIVIL
                </th>
            </tr>
            <tr>
                <td></td>
                <td style="font-weight:bold; text-align:center;">Precio</td>
                <td style="font-weight:bold; text-align:center;">$10,014.34</td>
                <td style="font-weight:bold; text-align:center;">$9,700.16</td>
                <td style="font-weight:bold; text-align:center;">$2,753.18</td>
                <td style="font-weight:bold; text-align:center;">$1,912.04</td>
            </tr>
            <tr>
                <td></td>
                <td bgcolor="#E6E6E6" style="font-weight:bold; text-align:center;">Primer pago</td>
                <td bgcolor="#E6E6E6" style="font-weight:bold; text-align:center;">$6,246.93</td>
                <td bgcolor="#E6E6E6" style="font-weight:bold; text-align:center;">$5,589.83</td>
                <td bgcolor="#E6E6E6" style="font-weight:bold; text-align:center;">$1,202.93</td>
                <td bgcolor="#E6E6E6" style="font-weight:bold; text-align:center;">$982.35</td>
            </tr>
            <tr>
                <td></td>
                <td bgcolor="#FFFFFF" style="font-weight:bold; text-align:center;">Subsecuente (1)</td>
                <td bgcolor="#FFFFFF" style="font-weight:bold; text-align:center;">$5,767.41</td>
                <td bgcolor="#FFFFFF" style="font-weight:bold; text-align:center;">$4,110.33</td>
                <td bgcolor="#FFFFFF" style="font-weight:bold; text-align:center;">$950.25</td>
                <td bgcolor="#FFFFFF" style="font-weight:bold; text-align:center;">$729.69</td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td></td>
                <td></td>
                <th style="text-align:center;">
                    Cobertura
                </th>
                <th style="text-align:center;">
                    Cobertura
                </th>
                <th style="text-align:center;">
                    Cobertura
                </th>
                <th style="text-align:center;">
                    Cobertura
                </th>
            </tr>
            <tr>
                <td rowspan="13">
                    <div>
                    </div>
                </td>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black;  border-top:solid 1px #595858; ">
                    <b>
                        <span id="title">
                            <a title="Ampara los daños materiales que sufra el vehículo asegurado hasta el Límite Máximo de Responsabilidad establecidos en la carátula de la póliza. " class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span> 
                        Daños Materiales
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style="border-bottom:dotted 1px #595858; border-right:solid 1px black; border-top:solid 1px #595858; ">
                    V. COMERCIAL + 10%
                    <br/>
                    Deducible:5%
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style="border-bottom:dotted 1px #595858; border-right:solid 1px black; border-top:solid 1px #595858; ">
                    V. COMERCIAL
                    <br/>
                    Deducible:5%
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style="border-bottom:dotted 1px #595858; border-right:solid 1px black; border-top:solid 1px #595858; ">
                    &nbsp;&#8203;
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style="border-bottom:dotted 1px #595858; border-right:solid 1px black; border-top:solid 1px #595858; ">
                    &nbsp;&#8203;
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>  
                        <span id="title">
                            <a title="Ampara los daños materiales que sufra el vehículo asegurado hasta el Límite Máximo de Responsabilidad establecidos en la carátula de la póliza. " class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span> 
                        NPDPTDM* 
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    &nbsp;&#8203;
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    &nbsp;&#8203;
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>
                        <span id="title">
                            <a title="Robo_Total" class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span> 
                        Robo Total 
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    V. COMERCIAL + 10%
                    <br/>
                    Deducible:10%
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    V. COMERCIAL
                    <br/>
                    Deducible:10%
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    V. COMERCIAL
                    <br/>
                    Deducible:10%
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    &nbsp;&#8203;
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>
                        <span id="title">
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en bienes y personas." class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span> 
                        Responsabilidad Civil (Daños a terceros) 
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    1,000,000 LUC 
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    1,000,000 LUC 
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    1,000,000 LUC 
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    1,000,000 LUC 
                    <br/>
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>  
                        <span id="title"><a title="Ampara los daños a terceros ocasionados por el asegurado en bienes y personas." class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span> 
                        Responsabilidad Civil Bienes 
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    500,000 POR EVENTO
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    500,000 POR EVENTO
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    500,000 POR EVENTO
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    500,000 POR EVENTO
                    <br/>
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>  
                        <span id="title">
                            <a title="Ampara los daños a terceros ocasionados por el asegurado en personas." class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span> 
                        Responsabilidad Civil Personas 
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    500,000 POR EVENTO
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    500,000 POR EVENTO
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    500,000 POR EVENTO
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    500,000 POR EVENTO
                    <br/>
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>  
                        <span id="title">
                            <a title="Ampara al conductor habitual mientras se encuentre conduciendo otro auto de uso particular diferente al asegurado contra los mismos riesgos y condiciones." class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span>
                        Extensión de Responsabilidad Civil
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>  
                        <span id="title">
                            <a title="Ampara los daños a terceros en sus bienes y personas, causados por el hijo menor de edad del asegurado aunque conduzca sin permiso o licencia. " class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span>
                        Responsabilidad Civil del hijo menor 
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>
                        <span id="title">
                            <a title="Ampara los daños a terceros producidos por remolques y caravanas y por los objetos transportados en el vehículo asegurado." class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span>
                        Responsabilidad Civil remolques y caravanas 
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>
                        RC CATASTROFICA POR MUERTE
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    2,000,000 POR EVENTO
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    2,000,000 POR EVENTO
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    2,000,000 POR EVENTO
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    2,000,000 POR EVENTO
                    <br/>
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>
                        <span id="title">
                            <a title="Ampara los gastos médicos que sufra el asegurado o los ocupantes del vehículo, incluyendo limpieza y acondicionamiento del vehículo por traslado de heridos. " class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span>
                        Gastos Médicos Ocupantes 
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    200,000
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    200,000
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    200,000
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style="border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    200,000
                    <br/>
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black; ">
                    <b>
                        <span id="title">
                            <a title="Incluye honorarios de servicios de carácter jurídico por conducto de abogados, gastos de proceso civil, fianzas y cauciones, así como el pago de multas. Ampara asesoría legal para trámites por robo de vehículo, en adición para hechos no relacionados con un siniestro como son: elaboración de testamento, asesoría y tramitación para la obtención de pensiones, entre otros." class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span>
                        Defensa Jurídica y Asistencia Legal
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style=" text-align:center; border-bottom:dotted 1px #595858; border-right:solid 1px black;">
                    <img src="img/palomita.png" alt="palomita"/>
                </td>
            </tr>
            <tr>
                <td bgcolor="#F2F2F2" class="Celda0" style="border-bottom:dotted 1px #595858; border-left:solid 1px black; text-align:left; border-right:solid 1px black;  border-bottom:solid 1px #595858; ">
                    <b>
                        <span id="title">
                            <a title="Indemnización adicional que se otorga en pérdida total por daños materiales  hasta $10,000 para rentar un vehículo o sufragar los gastos de transportación." class="tooltip" href="javascript:void(0)">
                                <img class="img_help_tooltip" width="5%" src="img/onebit_37.png"/>
                            </a>
                        </span>
                        Auto Sustituto
                    </b>
                </td>
                <td bgcolor="#F2F2F2" class="Celda1" style="border-bottom:dotted 1px #595858; border-right:solid 1px black; border-bottom:solid 1px #595858; ">
                    15,000
                    <br/>
                </td>
                <td bgcolor="#F2F2F2" class="Celda2" style="border-bottom:dotted 1px #595858; border-right:solid 1px black; border-bottom:solid 1px #595858; ">
                    &nbsp;&#8203;
                </td>
                <td bgcolor="#F2F2F2" class="Celda3" style="border-bottom:dotted 1px #595858; border-right:solid 1px black; border-bottom:solid 1px #595858; ">
                    &nbsp;&#8203;
                </td>
                <td bgcolor="#F2F2F2" class="Celda4" style="border-bottom:dotted 1px #595858; border-right:solid 1px black; border-bottom:solid 1px #595858; ">
                    &nbsp;&#8203;
                </td>
            </tr>
            <tr>
                <td></td>
                <td bgcolor="#FFFFFF" style="font-weight:bold; font-size:9px; text-align:left;">
                    *NPDPTDM: No Pago de Deducible por Pérdida Total en Daños Materiales L.U.C. Límite Único y Combinado 
                    <br/> 
                    *Aplican condiciones.
                </td>
            </tr>
        </tbody>
    </table>
    <input type="hidden" name="txt_cober1" id="txt_cober1" value="wciRbAMHdgBHS2XQp118Qw%3d%3d"/>
    <input type="hidden" name="txt_cober2" id="txt_cober2" value="F4ZlngvT%2bN6VQ12eRQjs9w%3d%3d"/>
    <input type="hidden" name="txt_cober3" id="txt_cober3" value="Q7HfIUDifs0bqpMLub0gIQ%3d%3d"/>
    <input type="hidden" name="txt_cober4" id="txt_cober4" value="TpOEV5q%2bBodIbR8%2bqi%2bshw%3d%3d"/>
    <input type="hidden" name="txt_pp1" id="txt_pp1" value="KCK0QRypT4yBN5l7tQGHXQ%3d%3d"/>
    <input type="hidden" name="txt_pp2" id="txt_pp2" value="TTT00R8xIYRzD3ezeI7UCA%3d%3d"/>
    <input type="hidden" name="txt_pp3" id="txt_pp3" value="x18qyZQoo7OsPeDFHSo67g%3d%3d"/>
    <input type="hidden" name="txt_pp4" id="txt_pp4" value="zbw%2b3fmiVWABSGxPtAGVww%3d%3d"/>
</div>