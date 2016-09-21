<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
$carrier = $_REQUEST['carrier'];
if ($_SESSION['l_usr']) {
    if ($carrier == 'TELCEL') {
?>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <style type="text/css">
                    body{
                        font-family:Arial, Helvetica, sans-serif;
                        color:#808080;;
                    }
                    td{
                        background:url(../../images/style1_bg.gif) #FFF top repeat-x;
                        border:1px solid #00F;
                        color:#00F;
                        float:left;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size:15px;
                        font-weight:bold;
                        height:25px;
                        margin:auto 1.5px;
                        padding-top:5px;
                        text-align:center;
                        width:88px;
                    }
                    .cell {
                        border:1px solid #00F;
                        color:#00F;
                        font-family:"Courier New",Courier,monospace;
                        font-size:30px;
                        font-weight:bold;
                        text-align:center;
                    }
                    h3 {
                        color: red;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size: 18px;
                    }
                    .buttonSend{
                        padding:5px;
                        margin-top:5px;
                        width:100px;
                    }
                    label{
                        padding:5px;
                        color:#00F;
                        font-family:Arial, Helvetica, sans-serif;
                        font-size:14px;
                    }
                    .LV_validation_message{
                        font-weight:bold;
                        margin:0 0 0 5px;
                    }

                    .LV_valid {
                        color:#00CC00;
                    }

                    .LV_invalid {
                        color:#CC0000;
                    }

                    .LV_valid_field,
                    input.LV_valid_field:hover,
                    input.LV_valid_field:active,
                    textarea.LV_valid_field:hover,
                    textarea.LV_valid_field:active {
                        border: 1px solid #00CC00;
                    }

                    .LV_invalid_field,
                    input.LV_invalid_field:hover,
                    input.LV_invalid_field:active,
                    textarea.LV_invalid_field:hover,
                    textarea.LV_invalid_field:active {
                        border: 1px solid #CC0000;
                    }
                </style>
                <script type="text/javascript" src="../js/livevalidation_standalone.js"></script>
                <script type="text/javascript" language="JavaScript">
                    function checkSubmit(){
                        document.getElementById("request").value = "Enviando....";
                        document.getElementById("request").disabled = true;
                        return true;
                    }
                </script>
            </head>
            <body>
                <div align="center">
                <!--<img src="../../images/Mantenimiento.png" alt="Mantenimiento" class="carrier" >-->
                    <h3>Compañía Seleccionada</h3>
                    <img src="../../images/TELCEL_mini.jpg" alt="TELCEL" class="carrier">
                    <table width="200">
                        <thead>
                            <tr>
                                <th colspan="2">PROMOCIONES:</th>
                            </tr>
                            <tr>
                                <td>Recarga</td>
                                <td>Y recibes</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label>$ 150</label>
                                </td>
                                <td>
                                    <label>$ 170</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 200</label>
                                </td>
                                <td>
                                    <label>$ 260</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 300</label>
                                </td>
                                <td>
                                    <label>$ 450</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 500</label>
                                </td>
                                <td>
                                    <label>$ 900</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p><strong>El TA Promocional solo aplica para llamadas y SMS a otros Telcel</strong></p>
                    <p>Seleccione el Monto a Recargar:</p>
                    <form method="post" action="reload.php" accept-charset="utf-8" onsubmit="return checkSubmit();">
                        <table width="80%" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="20" /><label>$ 20</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="30" /><label>$ 30</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="50" /><label>$ 50</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="100" /><label>$ 100</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="150" /><label>$ 150</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="200" /><label>$ 200</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="300" /><label>$ 300</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="500" /><label>$ 500</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <label>Número de Celular:</label><br />
                        <input type="text" name="celular" id="celular" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celular');
                            conCel.add(Validate.Numericality );
                            conCel.add(Validate.Length,{is: 10 });
                        </script>
                        <label>Confirme Número de Celular:</label><br/>
                        <input type="text" name="celularConfirm" id="celularConfirm" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celularConfirm');
                            conCel.add(Validate.Confirmation, { match: 'celular'} );
                        </script>
                        <input type="hidden" name="carrier" value="<?php echo $carrier; ?>" />
                        <input type="submit" id="request" class="buttonSend" value="Enviar" />
                    </form>
                </div>
            </body>
        </html>
<?php
    }
    if ($carrier == 'MOVISTAR') {
?>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <style type="text/css">
                    body{
                        font-family:Arial, Helvetica, sans-serif;
                        color:#808080;;
                    }
                    td{
                        background:url(../../images/style1_bg.gif) #FFF top repeat-x;
                        border:1px solid #008000;
                        color:#008000;
                        float:left;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size:15px;
                        font-weight:bold;
                        height:25px;
                        margin:auto 1.5px;
                        padding-top:5px;
                        text-align:center;
                        width:70px;
                    }
                    .cell {
                        border:1px solid #008000;
                        color:#008000;
                        font-family:"Courier New",Courier,monospace;
                        font-size:30px;
                        font-weight:bold;
                        text-align:center;
                    }
                    h3 {
                        color: red;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size: 18px;
                    }
                    .buttonSend{
                        padding:5px;
                        margin-top:5px;
                        width:100px;
                    }
                    label{
                        padding:5px;
                        color:#00F;
                        font-family:Arial, Helvetica, sans-serif;
                        font-size:14px;
                    }
                    .LV_validation_message{
                        font-weight:bold;
                        margin:0 0 0 5px;
                    }

                    .LV_valid {
                        color:#00CC00;
                    }

                    .LV_invalid {
                        color:#CC0000;
                    }

                    .LV_valid_field,
                    input.LV_valid_field:hover,
                    input.LV_valid_field:active,
                    textarea.LV_valid_field:hover,
                    textarea.LV_valid_field:active {
                        border: 1px solid #00CC00;
                    }

                    .LV_invalid_field,
                    input.LV_invalid_field:hover,
                    input.LV_invalid_field:active,
                    textarea.LV_invalid_field:hover,
                    textarea.LV_invalid_field:active {
                        border: 1px solid #CC0000;
                    }
                </style>
                <script type="text/javascript" src="../js/livevalidation_standalone.js"></script>
                <script type="text/javascript" language="JavaScript">
                    function checkSubmit(){
                        document.getElementById("request").value = "Enviando....";
                        document.getElementById("request").disabled = true;
                        return true;
                    }
                </script>
            </head>
            <body>
                <div align="center">
                    <!--<img src="../../images/Mantenimiento.png" alt="Mantenimiento" class="carrier" >-->
                    <h3>Compañía Seleccionada</h3>
                    <img src="../../images/MOVISTAR_mini.jpg" alt="MOVISTAR" class="carrier">
                    <table width="160">
                        <thead>
                            <tr>
                                <th colspan="2">PROMOCIONES:</th>
                            </tr>
                            <tr>
                                <td>Recarga</td>
                                <td>Recibes</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label>$ 200</label>
                                </td>
                                <td>
                                    <label>$ 300</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 300</label>
                                </td>
                                <td>
                                    <label>$ 500</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 500</label>
                                </td>
                                <td>
                                    <label>$ 1000</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p>Seleccione el Monto a Recargar:</p>
                    <form method="post" action="reload.php" accept-charset="utf-8" onsubmit="return checkSubmit();">
                        <table width="75%" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="10" /><label>$ 10</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="20" /><label>$ 20</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="30" /><label>$ 30</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="60" /><label>$ 60</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="100" /><label>$ 100</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="120" /><label>$ 120</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="200" /><label>$ 200</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="300" /><label>$ 300</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="500" /><label>$ 500</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <label>Número de Celular:</label><br />
                        <input type="text" name="celular" id="celular" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celular');
                            conCel.add(Validate.Numericality );
                            conCel.add(Validate.Length,{is: 10 });
                        </script>
                        <label>Confirme Número de Celular:</label><br/>
                        <input type="text" name="celularConfirm" id="celularConfirm" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celularConfirm');
                            conCel.add(Validate.Confirmation, { match: 'celular'} );
                        </script>
                        <input type="hidden" name="carrier" value="<?php echo $carrier; ?>" />
                        <input type="submit" id="request" class="buttonSend" value="Enviar" />
                    </form>
                </div>
            </body>
        </html>
<?php
    }
    if ($carrier == 'IUSACELL') {
?>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <style type="text/css">
                    body{
                        font-family:Arial, Helvetica, sans-serif;
                        color:#808080;;
                    }
                    td{
                        background:url(../../images/style1_bg.gif) #FFF top repeat-x;
                        border:1px solid #F00;
                        color:#F00;
                        float:left;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size:15px;
                        font-weight:bold;
                        height:25px;
                        margin:auto 1.5px;
                        padding-top:5px;
                        text-align:center;
                        width:100px;
                    }
                    .cell {
                        border:1px solid #F00;
                        color:#F00;
                        font-family:"Courier New",Courier,monospace;
                        font-size:30px;
                        font-weight:bold;
                        text-align:center;
                    }
                    h3 {
                        color: red;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size: 18px;
                    }
                    .buttonSend{
                        padding:5px;
                        margin-top:5px;
                        width:100px;
                    }
                    label{
                        padding:5px;
                        color:#00F;
                        font-family:Arial, Helvetica, sans-serif;
                        font-size:14px;
                    }
                    .LV_validation_message{
                        font-weight:bold;
                        margin:0 0 0 5px;
                    }

                    .LV_valid {
                        color:#00CC00;
                    }

                    .LV_invalid {
                        color:#CC0000;
                    }

                    .LV_valid_field,
                    input.LV_valid_field:hover,
                    input.LV_valid_field:active,
                    textarea.LV_valid_field:hover,
                    textarea.LV_valid_field:active {
                        border: 1px solid #00CC00;
                    }

                    .LV_invalid_field,
                    input.LV_invalid_field:hover,
                    input.LV_invalid_field:active,
                    textarea.LV_invalid_field:hover,
                    textarea.LV_invalid_field:active {
                        border: 1px solid #CC0000;
                    }
                </style>
                <script type="text/javascript" src="../js/livevalidation_standalone.js"></script>
                <script type="text/javascript" language="JavaScript">
                    function checkSubmit(){
                        document.getElementById("request").value = "Enviando....";
                        document.getElementById("request").disabled = true;
                        return true;
                    }
                </script>
            </head>
            <body>
                <div align="center">
                        <!--<img src="../../images/Mantenimiento.png" alt="Mantenimiento" class="carrier" >-->
                    <h3>Compañía Seleccionada</h3>
                    <img src="../../images/IUSACELL_mini.jpg" alt="IUSACELL" class="carrier">
                    <table width="315">
                        <thead>
                            <tr>
                                <th colspan="2">PROMOCIONES:</th>
                            </tr>
                            <tr>
                                <td>Recarga</td>
                                <td style="width:190px;">Y recibes</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label>$ 200</label>
                                </td>
                                <td style="width:190px;">
                                    <label>200 min Adicionales CN*</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 300</label>
                                </td>
                                <td style="width:190px;">
                                    <label>300 min Adicionales CN*</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 500</label>
                                </td>
                                <td style="width:190px;">
                                    <label>500 min Adicionales CN*</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 1000</label>
                                </td>
                                <td style="width:190px;">
                                    <label>1000 min Adicionales CN*</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p><strong>*CN=Comunidad Nacional IUSACELL-UNEFON</strong></p>
                    <p>Seleccione el Monto a Recargar:</p>
                    <form method="post" action="reload.php" accept-charset="utf-8" onsubmit="return checkSubmit();">
                        <table width="80%" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="50" /><label>$ 50</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="100" /><label>$ 100</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="150" /><label>$ 150</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="200" /><label>$ 200</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="300" /><label>$ 300</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="500" /><label>$ 500</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="1000" /><label>$ 1000</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <label>Número de Celular:</label><br />
                        <input type="text" name="celular" id="celular" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celular');
                            conCel.add(Validate.Numericality );
                            conCel.add(Validate.Length,{is: 10 });
                        </script>
                        <label>Confirme Número de Celular:</label><br/>
                        <input type="text" name="celularConfirm" id="celularConfirm" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celularConfirm');
                            conCel.add(Validate.Confirmation, { match: 'celular'} );
                        </script>
                        <input type="hidden" name="carrier" value="<?php echo $carrier; ?>" />
                        <input type="submit" id="request" class="buttonSend" value="Enviar" />
                    </form>
                </div>
            </body>
        </html>
<?php
    }
    if ($carrier == 'UNEFON') {
?>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <style type="text/css">
                    body{
                        font-family:Arial, Helvetica, sans-serif;
                        color:#808080;;
                    }
                    td{
                        background:url(../../images/style1_bg.gif) #FFF top repeat-x;
                        border:1px solid #f8d91f;
                        color:#2d1a00;
                        float:left;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size:15px;
                        font-weight:bold;
                        height:25px;
                        margin:auto 1.5px;
                        padding-top:5px;
                        text-align:center;
                        width:100px;
                    }
                    .cell {
                        border:1px solid #f8d91f;
                        color:#f8d91f;
                        font-family:"Courier New",Courier,monospace;
                        font-size:30px;
                        font-weight:bold;
                        text-align:center;
                    }
                    h3 {
                        color: red;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size: 18px;
                    }
                    .buttonSend{
                        padding:5px;
                        margin-top:5px;
                        width:100px;
                    }
                    label{
                        padding:5px;
                        color:#00F;
                        font-family:Arial, Helvetica, sans-serif;
                        font-size:14px;
                    }
                    .LV_validation_message{
                        font-weight:bold;
                        margin:0 0 0 5px;
                    }

                    .LV_valid {
                        color:#00CC00;
                    }

                    .LV_invalid {
                        color:#CC0000;
                    }

                    .LV_valid_field,
                    input.LV_valid_field:hover,
                    input.LV_valid_field:active,
                    textarea.LV_valid_field:hover,
                    textarea.LV_valid_field:active {
                        border: 1px solid #00CC00;
                    }

                    .LV_invalid_field,
                    input.LV_invalid_field:hover,
                    input.LV_invalid_field:active,
                    textarea.LV_invalid_field:hover,
                    textarea.LV_invalid_field:active {
                        border: 1px solid #CC0000;
                    }
                </style>
                <script type="text/javascript" src="../js/livevalidation_standalone.js"></script>
                <script type="text/javascript" language="JavaScript">
                    function checkSubmit(){
                        document.getElementById("request").value = "Enviando....";
                        document.getElementById("request").disabled = true;
                        return true;
                    }
                </script>
            </head>
            <body>
                <div align="center">
                        <!--<img src="../../images/Mantenimiento.png" alt="Mantenimiento">-->
                    <h3>Compañía Seleccionada</h3>
                    <img src="../../images/UNEFON_mini.jpg" alt="UNEFON" class="carrier">
                    <table width="315">
                        <thead>
                            <tr>
                                <th colspan="2">PROMOCIONES:</th>
                            </tr>
                            <tr>
                                <td>Recarga</td>
                                <td style="width:190px;">Y recibes</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <label>$ 200</label>
                                </td>
                                <td style="width:190px;">
                                    <label>200 min Adicionales CN*</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 300</label>
                                </td>
                                <td style="width:190px;">
                                    <label>300 min Adicionales CN*</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 500</label>
                                </td>
                                <td style="width:190px;">
                                    <label>500 min Adicionales CN*</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>$ 1000</label>
                                </td>
                                <td style="width:190px;">
                                    <label>1000 min Adicionales CN*</label>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p><strong>*CN=Comunidad Nacional IUSACELL-UNEFON</strong></p>
                    <p>Seleccione el Monto a Recargar:</p>
                    <form method="post" action="reload.php" accept-charset="utf-8" onsubmit="return checkSubmit();">
                        <table width="80%" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="50" /><label>$ 50</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="100" /><label>$ 100</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="150" /><label>$ 150</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="200" /><label>$ 200</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="300" /><label>$ 300</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="500" /><label>$ 500</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="1000" /><label>$ 1000</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <label>Número de Celular:</label><br />
                        <input type="text" name="celular" id="celular" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celular');
                            conCel.add(Validate.Numericality );
                            conCel.add(Validate.Length,{is: 10 });
                        </script>
                        <label>Confirme Número de Celular:</label><br/>
                        <input type="text" name="celularConfirm" id="celularConfirm" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celularConfirm');
                            conCel.add(Validate.Confirmation, { match: 'celular'} );
                        </script>
                        <input type="hidden" name="carrier" value="<?php echo $carrier; ?>" />
                        <input type="submit" id="request" class="buttonSend" value="Enviar" />
                    </form>
                </div>
            </body>
        </html>
<?php
    }
    if ($carrier == 'CACHITO') {
?>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <style type="text/css">
                    body{
                        font-family:Arial, Helvetica, sans-serif;
                        color:#000;
                    }
                    td{
                        background:url(../../images/style1_bg.gif) #FFF top repeat-x;
                        border:1px solid #930500;
                        color:#2d1a00;
                        float:left;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size:15px;
                        font-weight:bold;
                        height:25px;
                        margin:auto 1.5px;
                        padding-top:5px;
                        text-align:center;
                        width:100px;
                    }

                    .cell {
                        border:1px solid #930500;
                        color:#930500;
                        font-family:"Courier New",Courier,monospace;
                        font-size:30px;
                        font-weight:bold;
                        text-align:center;
                    }
                    h3 {
                        color: #ff6c00;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size: 18px;
                    }
                    .buttonSend{
                        padding:5px;
                        margin-top:5px;
                        width:100px;
                    }
                    label{
                        /*padding:5px;*/
                        color:#00F;
                        font-family:Arial, Helvetica, sans-serif;
                        font-size:14px;
                    }
                    .LV_validation_message{
                        font-weight:bold;
                        margin:0 0 0 5px;
                    }

                    .LV_valid {
                        color:#00CC00;
                    }

                    .LV_invalid {
                        color:#CC0000;
                    }

                    .LV_valid_field,
                    input.LV_valid_field:hover,
                    input.LV_valid_field:active,
                    textarea.LV_valid_field:hover,
                    textarea.LV_valid_field:active {
                        border: 1px solid #00CC00;
                    }

                    .LV_invalid_field,
                    input.LV_invalid_field:hover,
                    input.LV_invalid_field:active,
                    textarea.LV_invalid_field:hover,
                    textarea.LV_invalid_field:active {
                        border: 1px solid #CC0000;
                    }
                </style>
                <script type="text/javascript" src="../js/livevalidation_standalone.js"></script>
                <script type="text/javascript" language="JavaScript">
                    function checkSubmit(){
                        document.getElementById("request").value = "Enviando....";
                        document.getElementById("request").disabled = true;
                        return true;
                    }
                </script>
            </head>
            <body>
                <div align="center">
                        <!--<img src="../../images/Mantenimiento.png" alt="Mantenimiento">-->
                    <h3>Compañía Seleccionada</h3>
                    <img src="../../images/cachitoMovil.jpg" alt="CACHITO MOVIL" class="carrier">
                    <div align="justify">
                        <p style="font-weight:bold;">Cachito Móvil es un juego de la Lotería Nacional instantánea en el que puedes ganar hasta 1 millón pesos enviando un número del 0 al 9 al <strong style="color:#ff6c00;">22626</strong></p>
                        <p style="font-weight:bold;"><strong style="color:#ff6c00;">PROMOCION SYREC:</strong> Cada cliente que se dé de alta, mandando <strong style="color:#ff6c00;">LOTENAL</strong> al <strong style="color:#ff6c00;">22626</strong> recibe $20 gratis para jugar</p>
                    </div>
                    <br/>
                    <form method="post" action="recargaLoteNal.php" accept-charset="utf-8" onsubmit="return checkSubmit();">
                        <table width="23%" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="20" /><label>$ 20</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="100" /><label>$ 100</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <label>Número de Celular:</label><br />
                        <input type="text" name="celular" id="celular" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celular');
                            conCel.add(Validate.Numericality );
                            conCel.add(Validate.Length,{is: 10 });
                        </script>
                        <label>Confirme Número de Celular:</label><br/>
                        <input type="text" name="celularConfirm" id="celularConfirm" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celularConfirm');
                            conCel.add(Validate.Confirmation, { match: 'celular'} );
                        </script>
                        <input type="hidden" name="carrier" value="<?php echo $carrier; ?>" />
                        <input type="submit" id="request" class="buttonSend" value="Enviar" />
                    </form>
                    <div align="justify">
                        <h3>PARA PODER JUGAR:</h3>
                        <ul>
                            <li>
                			Al recibir el saldo en su Telcel, el cliente manda la palabra <strong style="color:#ff6c00;">CACHITO</strong> deja un espacio y escoge un número del 0 al 9 al <strong style="color:#ff6c00;">22626</strong>. Ejemplo: CACHITO 4
                            </li>
                            <li>
                                Al instante el cliente sabrá el resultado de su participación. En premios menores puede abonar su premio a su saldo para seguir jugando enviando la palabra <strong style="color:#ff6c00;">SI</strong> al <strong style="color:#ff6c00;">22626</strong>.
                            </li>
                            <li>
                                Cada participación cuesta $20. Puede comprar $100 y participar posteriormente hasta 5 veces. El saldo no caduca. El mensaje, es su boleto para poder cobrar premios directamente en la Lotería Nacional.
                            </li>
                        </ul>
                    </div>
                </div>
            </body>
        </html>
<?php
    }
    if ($carrier == 'MELATE') {
?>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <style type="text/css">
                    body{
                        font-family:Arial, Helvetica, sans-serif;
                        color:black;
                    }
                    td{
                        background:url(../../images/style1_bg.gif) #FFF top repeat-x;
                        border:1px solid #ee283f;
                        color:#ee283f;
                        float:left;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size:15px;
                        font-weight:bold;
                        height:25px;
                        margin:auto 1.5px;
                        padding-top:5px;
                        text-align:center;
                        width:80px;
                    }

                    .instrucciones{
                        background:url(../../images/style1_bg.gif) #FFF top repeat-x;
                        border:1px solid #ee283f;
                        color:#ee283f;
                        float:left;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size:15px;
                        font-weight:bold;
                        height:100%;
                        margin:auto 1.5px;
                        padding-top:5px;
                        text-align:justify;
                        width:500px;
                    }

                    .cell {
                        border:1px solid #ee283f;
                        color:#ee283f;
                        font-family:"Courier New",Courier,monospace;
                        font-size:30px;
                        font-weight:bold;
                        text-align:center;
                    }
                    h3 {
                        color: red;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size: 18px;
                    }
                    .buttonSend{
                        padding:5px;
                        margin-top:5px;
                        width:100px;
                    }
                    label{
                        /*padding:5px;*/
                        color:#00F;
                        font-family:Arial, Helvetica, sans-serif;
                        font-size:14px;
                    }
                    .LV_validation_message{
                        font-weight:bold;
                        margin:0 0 0 5px;
                    }

                    .LV_valid {
                        color:#00CC00;
                    }

                    .LV_invalid {
                        color:#CC0000;
                    }

                    .LV_valid_field,
                    input.LV_valid_field:hover,
                    input.LV_valid_field:active,
                    textarea.LV_valid_field:hover,
                    textarea.LV_valid_field:active {
                        border: 1px solid #00CC00;
                    }

                    .LV_invalid_field,
                    input.LV_invalid_field:hover,
                    input.LV_invalid_field:active,
                    textarea.LV_invalid_field:hover,
                    textarea.LV_invalid_field:active {
                        border: 1px solid #CC0000;
                    }
                </style>
                <script type="text/javascript" src="../js/livevalidation_standalone.js"></script>
                <script type="text/javascript" language="JavaScript">
                    function checkSubmit(){
                        document.getElementById("request").value = "Enviando....";
                        document.getElementById("request").disabled = true;
                        return true;
                    }
                </script>
            </head>
            <body>
                <div align="center">
                        <!--<img src="../../images/Mantenimiento.png" alt="Mantenimiento">-->
                    <h3>Compañía Seleccionada</h3>
                    <img src="../../images/melateMovil.jpg" alt="MELATE MOVIL" class="carrier">
                    <div align="justify">
                        <p><strong>Melate Móvil te permite participar en el sorteo Melate de Pronósticos Deportivos los miércoles y domingos con premios multimillonarios.</strong></p>
                        <p><strong style="color:#ff8000;">PROMOCION SYREC:</strong>&nbsp;<strong>Por cada compra de Melate el cliente recibirá  $25 más para un juego adicional</strong></p>
                        <p>Para participar el cliente debe enviar previamente la palabra <b style="color:#F00;">MELATE</b> al <b style="color:#F00;">63030</b> desde su Telcel por única vez.</p>
                    </div>
                    <br/>
                    <form method="post" action="recargaLoteNal.php" accept-charset="utf-8" onsubmit="return checkSubmit();">
                        <table width="10%" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="25" /><label>$ 25</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <label>Número de Celular:</label><br />
                        <input type="text" name="celular" id="celular" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celular');
                            conCel.add(Validate.Numericality );
                            conCel.add(Validate.Length,{is: 10 });
                        </script>
                        <label>Confirme Número de Celular:</label><br/>
                        <input type="text" name="celularConfirm" id="celularConfirm" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celularConfirm');
                            conCel.add(Validate.Confirmation, { match: 'celular'} );
                        </script>
                        <input type="hidden" name="carrier" value="<?php echo $carrier; ?>" />
                        <input type="submit" id="request" class="buttonSend" value="Enviar" />
                    </form>
                    <div align="justify">
                        <p>Al recibir el saldo en su <label style="text-decoration: underline;">Telcel</label>, el cliente podrá participar en 2 modalidades:</p>
                        <ul>
                            <li>
                                <strong style="text-decoration:underline;">MELATE CON REVANCHA:</strong>  El cliente manda la palabra <b style="color:#F00;">MELATE</b> seguido de 6 números separados por un espacio al <b style="color:#F00;">63030</b>. Ejemplo: <b style="color:#F00;">MELATE 1 4 19 30 52 56</b>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <strong style="text-decoration:underline;">MELATICO:</strong> El cliente manda la palabra <b style="color:#F00;">MELATICO</b> al <b style="color:#F00;">63030</b> y el sistema de Melate le asigna 6 números al azar.
                            </li>
                        </ul>
                        El cliente recibirá un boleto electrónico con los números participantes en su Telcel. <br/>
                        En caso de ganar, recibe un mensaje escrito con las instrucciones para cobrar su premio. <br/>
                        El saldo para participar no caduca La vigencia para cobro de premios es de 60 días, solo para mayores de 18 años.
                    </div>
                </div>
            </body>
        </html>
<?php
    }
    if ($carrier == 'NEXTEL') {
?>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                <style type="text/css">
                    body{
                        font-family:Arial, Helvetica, sans-serif;
                        color:black;
                    }
                    td{
                        background:url(../../images/style1_bg.gif) #FFF top repeat-x;
                        border:1px solid #ee283f;
                        color:#ee283f;
                        float:left;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size:15px;
                        font-weight:bold;
                        height:25px;
                        margin:auto 1.5px;
                        padding-top:5px;
                        text-align:center;
                        width:80px;
                    }

                    .instrucciones{
                        background:url(../../images/style1_bg.gif) #FFF top repeat-x;
                        border:1px solid #ee283f;
                        color:#ee283f;
                        float:left;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size:15px;
                        font-weight:bold;
                        height:100%;
                        margin:auto 1.5px;
                        padding-top:5px;
                        text-align:justify;
                        width:500px;
                    }

                    .cell {
                        border:1px solid #ee283f;
                        color:#ee283f;
                        font-family:"Courier New",Courier,monospace;
                        font-size:30px;
                        font-weight:bold;
                        text-align:center;
                    }
                    h3 {
                        color: red;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size: 18px;
                    }
                    .buttonSend{
                        padding:5px;
                        margin-top:5px;
                        width:100px;
                    }
                    label{
                        /*padding:5px;*/
                        color:#00F;
                        font-family:Arial, Helvetica, sans-serif;
                        font-size:14px;
                    }
                    .LV_validation_message{
                        font-weight:bold;
                        margin:0 0 0 5px;
                    }

                    .LV_valid {
                        color:#00CC00;
                    }

                    .LV_invalid {
                        color:#CC0000;
                    }

                    .LV_valid_field,
                    input.LV_valid_field:hover,
                    input.LV_valid_field:active,
                    textarea.LV_valid_field:hover,
                    textarea.LV_valid_field:active {
                        border: 1px solid #00CC00;
                    }

                    .LV_invalid_field,
                    input.LV_invalid_field:hover,
                    input.LV_invalid_field:active,
                    textarea.LV_invalid_field:hover,
                    textarea.LV_invalid_field:active {
                        border: 1px solid #CC0000;
                    }
                </style>
                <script type="text/javascript" src="../js/livevalidation_standalone.js"></script>
                <script type="text/javascript" language="JavaScript">
                    function checkSubmit(){
                        document.getElementById("request").value = "Enviando....";
                        document.getElementById("request").disabled = true;
                        return true;
                    }
                </script>
            </head>
            <body>
                <div align="center">
                        <!--<img src="../../images/Mantenimiento.png" alt="Mantenimiento">-->
                    <h3>Compañía Seleccionada</h3>
                    <img src="../../images/Nextel.jpg" alt="NEXTEL" class="carrier">
                    <br/>
                    <p>Seleccione el Monto a Recargar:</p>
                    <form method="post" action="reload.php" accept-charset="utf-8" onsubmit="return checkSubmit();">
                        <table width="46%" border="0">
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="30" /><label>$ 30</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="50" /><label>$ 50</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="100" /><label>$ 100</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="200" /><label>$ 200</label>
                                    </td>
                                    <td>
                                        <input type="radio" name="monto" class="monto" value="500" /><label>$ 500</label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br />
                        <label>Número de Celular:</label><br />
                        <input type="text" name="celular" id="celular" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celular');
                            conCel.add(Validate.Numericality );
                            conCel.add(Validate.Length,{is: 10 });
                        </script>
                        <label>Confirme Número de Celular:</label><br/>
                        <input type="text" name="celularConfirm" id="celularConfirm" maxlength="10" size="10" class="cell"><br />
                        <script type="text/javascript">
                            var conCel = new LiveValidation('celularConfirm');
                            conCel.add(Validate.Confirmation, { match: 'celular'} );
                        </script>
                        <input type="hidden" name="carrier" value="<?php echo $carrier; ?>" />
                        <input type="submit" id="request" class="buttonSend" value="Enviar" />
                    </form>
                </div>
            </body>
        </html>
<?php
    }
} else {
    echo "<div align='center' style='color:RED;'>SU SESION HA EXPIRADO O NO HA INICIADO UNA</div>";
}
?>