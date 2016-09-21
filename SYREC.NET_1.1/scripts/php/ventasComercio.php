<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include 'conexion.php';
if ($_SESSION['l_usr']) {
    $db = new Conexion;
    $db->sql_connect();
    $id = $_SESSION['l_usr'];
    $cajeros = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM cajero, relaciones WHERE idUsuario = idUsuarioHijo AND idUsuarioPadre = $id"), 0);
    if ($cajeros > 0) {
?>
        <div align="center">
            <script type="text/javascript">
                $(function(){
                    $("button").button();
                    var dates = $('#inicio, #final').datepicker({
                        dateFormat: 'yy-mm-dd',
                        minDate: '-60D',
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
                		En esta sección puedes ver las recargas realizadas en el período deseado, hasta 60 días para atrás<br/>
            <table width="400">
                <tbody>
                    <tr>
                        <td>
                            <input id="inicio" name="inicio" type="text" size="25" onkeydown="doSearch(arguments[0]||event);" readonly>
                        </td>
                        <td>
                            <input id="final" name="final" type="text" size="25" onkeydown="doSearch(arguments[0]||event);" readonly>
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
                            <button type="button" onclick="gridReload(<?php echo $_SESSION['l_usr']; ?>); gridResumen(<?php echo $_SESSION['l_usr']; ?>)">
                        <label>
                            Buscar
                        </label>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    <table id="resumen"></table>
    <div id="pagerR"></div>
    <br/>
    <table id="bigset"></table>
    <div id="pagerb"></div>
    <script type="text/javascript">
        jQuery("#bigset").jqGrid({
            url: 'scripts/php/estadoVentas.php?idUsr=<?php echo $_SESSION["l_usr"]; ?>',
            datatype: "xml",
            height: '100%',
            width: 800,
            colNames: ['FECHA', 'CARRIER', 'CELULAR', 'MONTO', 'COMISION', 'AUTORIZACION','CAJERO'],
            colModel: [
                { name: 'fecha', index: 'fecha', width: '100%', sortable:true, align: 'center' },
                { name: 'carrier', index: 'carrier', width: '100%', align: 'center' },
                { name: 'celular', index: 'celular', width: '100%', align: 'center' },
                { name: 'monto', index: 'monto', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }},
                { name: 'comision', index: 'comision', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }},
                { name: 'autorizacion', index: 'autorizacion', width: '100%', align: 'center' },
                { name: 'cajero', index: 'cajero', width: '100%', align: 'right' }
            ],
            rowNum: 50,
            mtype: "POST",
            pager: jQuery('#pagerb'),
            sortname: 'fecha',
            sortorder:'desc',
            viewrecords: true,
            grouping: true,
            groupingView : { 
                groupField : ['carrier'],
                groupText : ['<b>{0} - {1} Dato(s)</b>'],
                groupCollapse : true
            },
            caption: '<h3>Detalle de Ventas</h3>'
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
	        
        function gridReload(id){
            var inicio = jQuery("#inicio").val();
            var end = jQuery("#final").val();
            jQuery("#bigset").jqGrid('setGridParam', {url: "scripts/php/estadoVentas.php?inicio=" + inicio + "&final=" + end + "&idUsr=" + id, page: 1 }).trigger("reloadGrid");
        }
	        
        function enableAutosubmit(state){
            flAuto = state;
            jQuery("#submitButton").attr("disabled", state);
        }
    </script>
    <script type="text/javascript">
        jQuery("#resumen").jqGrid({
            url: 'scripts/php/resumenVentas.php?idUsr=<?php echo $_SESSION["l_usr"]; ?>',
            datatype: "xml",
            height: '100%',
            width: 400,
            colNames: ['CARRIER', 'CANTIDAD DE VENTAS', 'MONTO', 'COMISION'],
            colModel: [
                { name: 'carrier', index: 'carrier', width: '100%', align: 'center' },
                { name: 'ventas', index: 'ventas', width: '100%', align: 'center' },
                { name: 'monto', index: 'monto', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }},
                { name: 'comision', index: 'comision', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }}
            ],
            rowNum: 20,
            mtype: "POST",
            pager: jQuery('#pagerR'),
            pgbuttons: false,
            pgtext: false,
            pginput: false,
            footerrow : true,
            userDataOnFooter : true,
            sortname: 'fecha',
            sortorder:'desc',
            viewrecords: true,
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
            jQuery("#resumen").jqGrid('setGridParam', { url: "scripts/php/resumenVentas.php?inicio=" + inicio + "&final=" + end + "&idUsr=" + id, page: 1 }).trigger("reloadGrid");
        }
	        
        function enableAutosubmit(state){
            flAuto = state;
            jQuery("#submitButton").attr("disabled", state);
        }
    </script>
</div>
<?php
    } else {
?>
        <div align="center">
            <script type="text/javascript">
                $(function(){
                    $("button").button();
                    var dates = $('#inicio, #final').datepicker({
                        dateFormat: 'yy-mm-dd',
                        minDate: '-90D',
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
                		En esta sección puedes ver las recargas realizadas en el período deseado, hasta 60 días para atrás<br/>
            <table width="400">
                <tbody>
                    <tr>
                        <td>
                            <input id="inicio" name="inicio" type="text" size="25" onkeydown="doSearch(arguments[0]||event);" readonly>
                        </td>
                        <td>
                            <input id="final" name="final" type="text" size="25" onkeydown="doSearch(arguments[0]||event);" readonly>
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
                            <button type="button" onclick="gridReload(<?php echo $_SESSION['l_usr']; ?>); gridResumen(<?php echo $_SESSION['l_usr']; ?>)">
                        <label>
	                            Buscar
                        </label>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
    <table id="resumen"></table>
    <div id="pagerR"></div>
    <br/>
    <table id="bigset"></table>
    <div id="pagerb"></div>
    <script type="text/javascript">
        jQuery("#bigset").jqGrid({
            url: 'scripts/php/estadoVentas.php?idUsr=<?php echo $_SESSION["l_usr"]; ?>',
            datatype: "xml",
            height: '100%',
            width: 700,
            colNames: ['FECHA', 'CARRIER', 'CELULAR', 'MONTO', 'COMISION','AUTORIZACION'],
            colModel: [
                { name: 'fecha', index: 'fecha', width: '100%', sortable:true, align: 'center' },
                { name: 'carrier', index: 'carrier', width: '100%', align: 'center' },
                { name: 'celular', index: 'celular', width: '100%', align: 'center' },
                { name: 'monto', index: 'monto', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }},
                { name: 'comision', index: 'comision', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }},
                { name: 'autorizacion', index: 'autorizacion', width: '100%', align: 'center'
                }],
            rowNum: 20,
            mtype: "POST",
            pager: jQuery('#pagerb'),
            sortname: 'fecha',
            sortorder:'desc',
            viewrecords: true,
            caption: '<h3>Detalle de Ventas</h3>'
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
	        
        function gridReload(id){
            var inicio = jQuery("#inicio").val();
            var end = jQuery("#final").val();
            jQuery("#bigset").jqGrid('setGridParam', { url: "scripts/php/estadoVentas.php?inicio=" + inicio + "&final=" + end + "&idUsr=" + id, page: 1 }).trigger("reloadGrid");
        }
	        
        function enableAutosubmit(state){
            flAuto = state;
            jQuery("#submitButton").attr("disabled", state);
        }
    </script>
    <script type="text/javascript">
        jQuery("#resumen").jqGrid({
            url: 'scripts/php/resumenVentas.php?idUsr=<?php echo $_SESSION["l_usr"]; ?>',
            datatype: "xml",
            height: '100%',
            width: 400,
            colNames: ['CARRIER', 'CANTIDAD DE VENTAS', 'MONTO', 'COMISION'],
            colModel: [
                { name: 'carrier', index: 'carrier', width: '100%', align: 'center' },
                { name: 'ventas', index: 'ventas', width: '100%', align: 'center' },
                { name: 'monto', index: 'monto', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }},
                { name: 'comision', index: 'comision', width: '100%', align: 'center', formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }}
            ],
            rowNum: 20,
            // rowList:[10,20,30],
            mtype: "POST",
            pager: jQuery('#pagerR'),
            pgbuttons: false,
            pgtext: false,
            pginput: false,
            footerrow : true,
            userDataOnFooter : true,
            sortname: 'fecha',
            sortorder:'desc',
            viewrecords: true,
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
            jQuery("#resumen").jqGrid('setGridParam', { url: "scripts/php/resumenVentas.php?inicio=" + inicio + "&final=" + end + "&idUsr=" + id, page: 1 }).trigger("reloadGrid");
        }
	        
        function enableAutosubmit(state){
            flAuto = state;
            jQuery("#submitButton").attr("disabled", state);
        }
    </script>
</div>
<?php
    }
} else {
    echo "<div align='center' style='color:RED;'>SU SESION HA EXPIRADO O NO HA INICIADO UNA</div>";
}
?>