<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include 'conexion.php';
$db = new Conexion;
$db->sql_connect();
$idUSr = $_SESSION['l_usr'];
$sql = $db->sql_query("SELECT idUsuario, NombreComercial FROM detalleusuarios, relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $idUSr ORDER BY NombreComercial ASC");
$r = $_REQUEST['r'];
if ($r == 0) {
?>
    <div style="border:1px #808080 dotted; width:650px; padding:20px; margin-top:25px;">
        <script type="text/javascript">
            $(function(){
                $("button").button();
                var dates = $('#inicio, #final').datepicker({
                    dateFormat: 'yy-mm-dd',
                    //minDate: '-1Y',
                    maxDate: '+0D',
                    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function(selectedDate){
                        var option = this.id == "inicio" ? "minDate" : "maxDate";
                        var instance = $(this).data("datepicker");
                        var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                        dates.not(this).datepicker("option", option, date);
                    }
                });
            });
        </script>
        <table width="400">
            <tbody>
                <tr>
                    <td>
                        <input id="inicio" name="inicio" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                    </td>
                    <td>
                        <input id="final" name="final" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                    </td>
                    <td>
                        <select id="usuario" name="usuario" style="width:200px;" onkeydown="doSearch(arguments[0]||event);">
                            <option value="0">TODA LA RED</option>
                        <?php
                        while ($usr = $db->sql_fetch_array($sql)) {
                        ?>
                            <option value="<?php echo $usr[idUsuario]; ?>"><?php echo $usr[NombreComercial]; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <label>
                        Desde
                    </label>
                </td>
                <td align="center">
                    <label>
                        Hasta
                    </label>
                </td>
                <td align="center">
                    <label>
                        Consultar Para:
                    </label>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <button type="button" onclick="gridReload(<?php echo $_SESSION['l_usr']; ?>)">
                        <label>
                            Buscar
                        </label>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    <table id="bigset">
    </table>
    <div id="pagerb">
    </div>
    <script type="text/javascript" language="JavaScript" src="scripts/js/gridCuenta.js">
    </script>
</div>
<?php
                    }
                    if ($r == 1) {
?>
                        <div style="border:1px #808080 dotted; width:650px; padding:20px; margin-top:25px;">
                            <script type="text/javascript">
                                $(function(){
                                    $("button").button();
                                    var dates = $('#inicio, #final').datepicker({
                                        dateFormat: 'yy-mm-dd',
                                        //minDate: '-90D',
                                        maxDate: '+0D',
                                        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                        changeMonth: true,
                                        changeYear: true,
                                        onSelect: function(selectedDate){
                                            var option = this.id == "inicio" ? "minDate" : "maxDate";
                                            var instance = $(this).data("datepicker");
                                            var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                                            dates.not(this).datepicker("option", option, date);
                                        }
                                    });
                                });
                            </script>
                            <form action="scripts/php/php-excel/mysql.php?carrier=Compras" method="post">
                                <table width="400">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input id="inicio" name="inicio" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                                            </td>
                                            <td>
                                                <input id="final" name="final" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                                            </td>
                                            <td>
                                                <select id="usuario" name="usuario" style="width:200px;" onkeydown="doSearch(arguments[0]||event);">
                                                    <option value=0>TODA LA RED</option>
                            <?php
                            while ($usr = $db->sql_fetch_array($sql)) {
                            ?>
                                <option value="<?php echo $usr[idUsuario]; ?>"><?php echo $usr[NombreComercial]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <label>
                            Desde
                        </label>
                    </td>
                    <td align="center">
                        <label>
                            Hasta
                        </label>
                    </td>
                    <td align="center">
                        <label>
                            Consultar Para:
                        </label>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <button type="button" onclick="gridReload(<?php echo $_SESSION['l_usr']; ?>)">
                            <label>
                                Buscar
                            </label>
                        </button>
                    </td>
                    <td>&nbsp;</td>
                    <td>
                        <button type="submit" value="ResumenCompras"><label>Resumen Compras</label></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <br/>
    <table id="bigset">
    </table>
    <div id="pagerb">
    </div>
    <script type="text/javascript" language="JavaScript" src="scripts/js/gridTraspasos.js">
    </script>
</div>
<?php
                        }
                        if ($r == 2) {
?>
                            <div style="border:1px #808080 dotted; width:650px; padding:20px; margin-top:25px;">
                                <script type="text/javascript">
                                    $(function(){
                                        $("button").button();
                                        var dates = $('#inicio, #final').datepicker({
                                            dateFormat: 'yy-mm-dd',
                                            //minDate: '-90D',
                                            maxDate: '+0D',
                                            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                            changeMonth: true,
                                            changeYear: true,
                                            onSelect: function(selectedDate){
                                                var option = this.id == "inicio" ? "minDate" : "maxDate";
                                                var instance = $(this).data("datepicker");
                                                var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                                                dates.not(this).datepicker("option", option, date);
                                            }
                                        });
                                    });
                                </script>
                                <table width="400">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input id="inicio" name="inicio" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                                            </td>
                                            <td>
                                                <input id="final" name="final" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                                            </td>
                                            <td>
                                                <select id="carrier" name="carrier" style="width:200px;" onkeydown="doSearch(arguments[0]||event);">
                                                    <option value="-">TODOS LOS CARRIERS</option>
                                                    <option value="TARJETASNOR">TARJETAS DEL NORESTE</option>
                                                    <option value="PAGATAE">PAGATAE</option>
                                                    <option value="MOVISTAR">MOVISTAR</option>
                                                    <option value="IUSACELL">IUSACELL</option>
                                                    <option value="NEXTEL">NEXTEL</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <label>
                                                    Desde
                                                </label>
                                            </td>
                                            <td align="center">
                                                <label>
                                                    Hasta
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" align="center">
                                                <button type="button" onclick="gridReload(<?php echo $_SESSION['l_usr']; ?>)">
                                                    <label>
                                                        Buscar
                                                    </label>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br/>
                                <table id="bigset">
                                </table>
                                <div id="pagerb">
                                </div>
                                <script type="text/javascript" language="JavaScript" src="scripts/js/gridCompras.js">
                                </script>
                            </div>
<?php
                        }
                        if ($r == 3) {
?>
                            <div align="center">
                                <script type="text/javascript">
                                    $(function(){
                                        $("button").button();
                                        var dates = $('#inicio, #final').datepicker({
                                            dateFormat: 'yy-mm-dd',
                                            //minDate: '-90D',
                                            maxDate: '+0D',
                                            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                            changeMonth: true,
                                            changeYear: true,
                                            onSelect: function(selectedDate){
                                                var option = this.id == "inicio" ? "minDate" : "maxDate";
                                                var instance = $(this).data("datepicker");
                                                var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                                                dates.not(this).datepicker("option", option, date);
                                            }
                                        });
                                    });
                                </script>
                                <br/>
                                En esta sección puedes ver las recargas realizadas en el período deseado, hasta 90 días para atrás
                                <br/>
                                <table width="400">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input id="inicio" name="inicio" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                                            </td>
                                            <td>
                                                <input id="final" name="final" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <label>
                                                    Desde
                                                </label>
                                            </td>
                                            <td align="center">
                                                <label>
                                                    Hasta
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center">
                                                <button type="button" onclick="gridResumen(<?php echo $_SESSION['l_usr']; ?>); ventasXcomercio(<?php echo $_SESSION['l_usr']; ?>)">
                                                    <label>
                                                        Buscar
                                                    </label>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br/>
                                <table id="resumen">
                                </table>
                                <div id="pagerR">
                                </div>
                                <br/>
                                <table id="ventasXcomercios">
                                </table>
                                <div id="pagerRC">
                                </div>
                                <script type="text/javascript">
                                    jQuery("#resumen").jqGrid({
                                        url: 'scripts/php/resumenVentas.php?idUsr=<?php echo $_SESSION["l_usr"]; ?>',
                                        datatype: "xml",
                                        height: '100%',
                                        width: 400,
                                        colNames: ['CARRIER', 'CANTIDAD', 'MONTO', '% VENTAS'],
                                        colModel: [
                                            { name: 'carrier', index: 'carrier', width: '100%', align: 'center' },
                                            { name: 'ventas', index: 'ventas', width: '100%', align: 'center'},
                                            { name: 'monto', index: 'monto', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " } },
                                            { name: 'porcentaje', index: 'porcentaje', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, suffix: " %" } }
                                        ],
                                        rowNum: 50,
                                        // rowList:[10,20,30],
                                        mtype: "POST",
                                        pager: jQuery('#pagerR'),
                                        pgbuttons: false,
                                        pgtext: false,
                                        pginput: false,
                                        footerrow: true,
                                        userDataOnFooter: true,
                                        sortname: 'fecha',
                                        sortorder: 'desc',
                                        viewrecords: false,
                                        caption: '<h3>Resumen de Ventas</h3>'
                                    });
                                    var timeoutHnd;
                                    var flAuto = false;
                                    function doSearch(ev){
                                        if (!flAuto)
                                            return;
                                        // var elem = ev.target||ev.srcElement;
                                        if (timeoutHnd)
                                            clearTimeout(timeoutHnd)
                                        timeoutHnd = setTimeout(gridReload, 500)
                                    }

                                    function gridResumen(id){
                                        var inicio = jQuery("#inicio").val();
                                        var end = jQuery("#final").val();
                                        jQuery("#resumen").jqGrid('setGridParam',
                                        { url: "scripts/php/resumenVentas.php?inicio=" + inicio + "&final=" + end + "&idUsr=" + id, page: 1 }).trigger("reloadGrid");
                                    }

                                    function enableAutosubmit(state){
                                        flAuto = state;
                                        jQuery("#submitButton").attr("disabled", state);
                                    }
                                </script>
                                <script type="text/javascript">
                                    jQuery("#ventasXcomercios").jqGrid({
                                        url: 'scripts/php/ventasXcomercio.php?idUsr=<?php echo $_SESSION["l_usr"]; ?>',
                                        datatype: "xml",
                                        height: '100%',
                                        width: 700,
                                        colNames: ['COMERCIO', 'TOTAL VENTAS', 'TOTAL COMISION', '% VENTAS'],
                                        colModel: [
                                            { name: 'comercio', index: 'comercio', width: '100%', align: 'center' },
                                            { name: 'ventas', index: 'ventas', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " } },
                                            { name: 'monto', index: 'monto', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " } },
                                            { name: 'porcentaje', index: 'porcentaje', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, suffix: " %" } }
                                        ],
                                        rowNum: 50,
                                        // rowList:[10,20,30],
                                        mtype: "POST",
                                        pager: jQuery('#pagerRC'),
                                        footerrow: true,
                                        userDataOnFooter: true,
                                        sortname: 'fecha',
                                        sortorder: 'desc',
                                        viewrecords: false,
                                        caption: '<h3>Ventas por Comercios</h3>'
                                    });
                                    var timeoutHnd;
                                    var flAuto = false;
                                    function doSearch(ev){
                                        if (!flAuto)
                                            return;
                                        // var elem = ev.target||ev.srcElement;
                                        if (timeoutHnd)
                                            clearTimeout(timeoutHnd)
                                        timeoutHnd = setTimeout(gridReload, 500)
                                    }

                                    function ventasXcomercio(id){
                                        var inicio = jQuery("#inicio").val();
                                        var end = jQuery("#final").val();
                                        jQuery("#ventasXcomercios").jqGrid('setGridParam',
                                        { url: "scripts/php/ventasXcomercio.php?inicio=" + inicio + "&final=" + end + "&idUsr=" + id, page: 1 }).trigger("reloadGrid");
                                    }

                                    function enableAutosubmit(state){
                                        flAuto = state;
                                        jQuery("#submitButton").attr("disabled", state);
                                    }
                                </script>
                            </div>
<?php
                        }
                        if ($r == 4) {
                            $totalRegistros = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM detalleusuarios WHERE idUsuario != 1 AND idUsuario != 2"), 0);
?>
                            <div align="center">
                                <br/>
                                En esta sección puedes ver las últimas compras realizadas por los comercios dados de alta en el sistema
                                <br/><br/>
                                <table id="0Ventas">
                                </table>
                                <div id="pagerRC">
                                </div>
                                <script type="text/javascript">
                                    jQuery("#0Ventas").jqGrid({
                                        url: 'scripts/php/ZeroCompras.php',
                                        datatype: "xml",
                                        height: '100%',
                                        width: 700,
                                        colNames: ['ID', 'COMERCIO', 'EMAIL', 'TELEFONO', 'AFILIACION', 'ÚLTIMA COMPRA'],
                                        colModel: [
                                            { name: 'idUsuario', index: 'idUsuario', width: 20, align: 'center' },
                                            { name: 'NombreComercio', index: 'NombreComercio', width: '100%', align: 'center'},
                                            { name: 'Usuario', index: 'Usuario', width: '100%', align: 'center'},
                                            { name: 'TelFijo', index: 'TelFijo', width: '100%', align: 'center'},
                                            { name: 'FechaRegistro', index: 'FechaRegistro', width: '100%', align: 'center'},
                                            { name: 'Fecha', index: 'Fecha', width: '100%', align: 'center' }
                                        ],
                                        pager: jQuery('#pagerRC'),
                                        rowNum: 50,
                                        rowTotal:<?php echo $totalRegistros; ?>,
                                        loadonce: true,
                                        viewrecords:true,
                                        rownumbers: true,
                                        altRows : true,
                                        mtype: "POST",
                                        sortname: 'Fecha',
                                        sortorder: 'desc',
                                        viewrecords: false,
                                        caption: '<h3>Compras Comercios</h3>'
                                    });
                                    var timeoutHnd;
                                    var flAuto = false;
                                    function doSearch(ev){
                                        if (!flAuto)
                                            return;
                                        // var elem = ev.target||ev.srcElement;
                                        if (timeoutHnd)
                                            clearTimeout(timeoutHnd)
                                        timeoutHnd = setTimeout(gridReload, 500)
                                    }
                                </script>
                            </div>
<?php
                        }
                        if ($r == 5) {
?>
                            <div align="center">
                                <script type="text/javascript">
                                    $(function(){
                                        $("button").button();
                                        var dates = $('#inicio, #final').datepicker({
                                            dateFormat: 'yy-mm-dd',
                                            //minDate: '-90D',
                                            maxDate: '+0D',
                                            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                            changeMonth: true,
                                            changeYear: true,
                                            onSelect: function(selectedDate){
                                                var option = this.id == "inicio" ? "minDate" : "maxDate";
                                                var instance = $(this).data("datepicker");
                                                var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                                                dates.not(this).datepicker("option", option, date);
                                            }
                                        });
                                    });
                                </script>
                                <br/>
                                En esta sección puedes ver la comision generada por las redes de recomendados
                                <br/>
                                <table width="400">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input id="inicio" name="inicio" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                                            </td>
                                            <td>
                                                <input id="final" name="final" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                                            </td>
                                            <td>
                                                <select id="usuario" name="usuario" style="width:200px;" onkeydown="doSearch(arguments[0]||event);">
                                                    <option value="0">SELECCIONE UN COMERCIO</option>
                                                <?php
                                                    while ($usr = $db->sql_fetch_array($sql)) {
                                                ?>
                                                        <option value="<?php echo $usr[NombreComercial]; ?>"><?php echo $usr[NombreComercial]; ?></option>
                                                <?php
                                                    }
                                                ?>
                                                </select>
                                            </td>
                </tr>
                <tr>
                    <td align="center">
                        <label>
                            Desde
                        </label>
                    </td>
                    <td align="center">
                        <label>
                            Hasta
                        </label>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <button type="button" onclick="gridResumen(<?php echo $_SESSION['l_usr']; ?>); gridCompras(<?php echo $_SESSION['l_usr']; ?>);">
                            <label>
                                Buscar
                            </label>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <br/>
        <table id="redAgentes">
        </table>
        <div id="pagerR">
        </div>
        <br/>
        <table id="redComprasAgentes">
        </table>
        <div id="pagerRC">
        </div>
        <script type="text/javascript">
            jQuery("#redAgentes").jqGrid({
                url: 'scripts/php/redAgentes.php?idUsr=<?php echo $_SESSION["l_usr"]; ?>',
                datatype: "xml",
                height:   '100%',
                width:    700,
                colNames: ['VENTAS RED', 'COMISION RED', 'COMISION GENERADA'],
                colModel: [
                    { name: 'ventas_red',        index: 'ventas_red',        width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " } },
                    { name: 'comision_red',      index: 'comision_red',      width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " } },
                    { name: 'comision_generada', index: 'comision_generada', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " } }
                ],
                rowNum: 50,
                // rowList:[10,20,30],
                mtype: "POST",
                pager: jQuery('#pagerR'),
                footerrow: true,
                userDataOnFooter: true,
                sortname: 'agente',
                sortorder: 'asc',
                viewrecords: false,
                caption: '<h3>Ventas Red de Agentes</h3>'
            });
            var timeoutHnd;
            var flAuto = false;
            function doSearch(ev){
                if (!flAuto)
                    return;
                // var elem = ev.target||ev.srcElement;
                if (timeoutHnd)
                    clearTimeout(timeoutHnd)
                timeoutHnd = setTimeout(gridReload, 500)
            }

            function gridResumen(id){
                var inicio = jQuery("#inicio").val();
                var end = jQuery("#final").val();
                var usuario = jQuery('#usuario').val();
                jQuery("#redAgentes").jqGrid('setGridParam',
                { url: "scripts/php/redAgentes.php?inicio=" + inicio + "&final=" + end + "&idUsr=" + id + "&usuario=" + usuario, page: 1 }).trigger("reloadGrid");
            }

            function enableAutosubmit(state){
                flAuto = state;
                jQuery("#submitButton").attr("disabled", state);
            }
        </script>
        <script type="text/javascript">
            jQuery("#redComprasAgentes").jqGrid({
                url: 'scripts/php/redComprasAgentes.php?idUsr=<?php echo $_SESSION["l_usr"]; ?>',
                datatype: "xml",
                height: '100%',
                width: 600,
                colNames: ['AGENTE', 'COMPRAS RED'],
                colModel: [
                    { name: 'agente', index: 'agente', width: '100%', align: 'center' },
                    { name: 'compras_red', index: 'compras_red', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " } },
                ],
                rowNum: 50,
                // rowList:[10,20,30],
                mtype: "POST",
                pager: jQuery('#pagerRC'),
                footerrow: true,
                userDataOnFooter: true,
                sortname: 'agente',
                sortorder: 'asc',
                viewrecords: false,
                caption: '<h3>Compras Red de Agentes</h3>'
            });
            var timeoutHnd;
            var flAuto = false;
            function doSearch(ev){
                if (!flAuto)
                    return;
                // var elem = ev.target||ev.srcElement;
                if (timeoutHnd)
                    clearTimeout(timeoutHnd)
                timeoutHnd = setTimeout(gridReload, 500)
            }

            function gridCompras(id){
                var inicio = jQuery("#inicio").val();
                var end = jQuery("#final").val();
                jQuery("#redComprasAgentes").jqGrid('setGridParam',
                { url: "scripts/php/redComprasAgentes.php?inicio=" + inicio + "&final=" + end + "&idUsr=" + id, page: 1 }).trigger("reloadGrid");
            }

            function enableAutosubmit(state){
                flAuto = state;
                jQuery("#submitButton").attr("disabled", state);
            }
        </script>
    </div>
<?php
                        }
                        if ($r == 6) {
?>
                            <div align="center">
                                <script type="text/javascript">
                                    $(function(){
                                        $("button").button();
                                        var dates = $('#inicio, #final').datepicker({
                                            dateFormat: 'yy-mm-dd',
                                            //minDate: '-30D',
                                            maxDate: '+0D',
                                            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                                            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                                            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                                            changeMonth: true,
                                            changeYear: true,
                                            onSelect: function(selectedDate){
                                                var option = this.id == "inicio" ? "minDate" : "maxDate";
                                                var instance = $(this).data("datepicker");
                                                var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                                                dates.not(this).datepicker("option", option, date);
                                            }
                                        });
                                    });
                                </script>
                                <br/>
                                En esta sección puedes ver la comision generada por la venta de los comercios
                                <br/>
                                <table width="400">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input id="inicio" name="inicio" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                                            </td>
                                            <td>
                                                <input id="final" name="final" type="text" size="25" onkeydown="doSearch(arguments[0]||event);">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <label>
                                                    Desde
                                                </label>
                                            </td>
                                            <td align="center">
                                                <label>
                                                    Hasta
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center">
                                                <button type="button" onclick="gridComision(<?php echo $_SESSION['l_usr']; ?>);">
                                                    <label>
                                                        Buscar
                                                    </label>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br/>
                                <table id="Comisiones">
                                </table>
                                <div id="pagerC">
                                </div>
                                <script type="text/javascript">
                                    jQuery("#Comisiones").jqGrid({
                                        url: 'scripts/php/comisionComercio.php',
                                        datatype: "xml",
                                        height: '100%',
                                        width: 600,
                                        colNames: ['COMERCIO', 'COMISION GENERADA'],
                                        colModel: [
                                            { name: 'NombreComercial', index: 'agente', width: '100%', align: 'center' },
                                            { name: 'comision_generada', index: 'comision_generada', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " } }
                                        ],
                                        rowNum: 50,
                                        mtype: "POST",
                                        pager: jQuery('#pagerC'),
                                        footerrow: true,
                                        userDataOnFooter: true,
                                        sortname: 'NombreComercial',
                                        sortorder: 'asc',
                                        viewrecords: true,
                                        rownumbers: true,
                                        caption: '<h3>Comisiones de los Comercios</h3>'
                                    });
                                    var timeoutHnd;
                                    var flAuto = false;
                                    function doSearch(ev){
                                        if (!flAuto)
                                            return;
                                        // var elem = ev.target||ev.srcElement;
                                        if (timeoutHnd)
                                            clearTimeout(timeoutHnd)
                                        timeoutHnd = setTimeout(gridReload, 500)
                                    }

                                    function gridComision(id){
                                        var inicio = jQuery("#inicio").val();
                                        var end = jQuery("#final").val();
                                        jQuery("#Comisiones").jqGrid('setGridParam',
                                        { url: "scripts/php/comisionComercio.php?inicio=" + inicio + "&final=" + end + "&idUsr=" + id, page: 1 }).trigger("reloadGrid");
                                    }

                                    function enableAutosubmit(state){
                                        flAuto = state;
                                        jQuery("#submitButton").attr("disabled", state);
                                    }
                                </script>
                            </div>
<?php
                        }
?>
