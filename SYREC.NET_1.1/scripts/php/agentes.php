<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
$id = $_SESSION['l_usr'];
?>
<script type="text/javascript" language="JavaScript">
    jQuery(document).ready(function(){
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
        jQuery("#agentes").jqGrid({
            url: 'scripts/php/gridAgentes.php?idUsr=<?php echo $id; ?>',
            dataType: 'xml',
            mtype: 'POST',
            colNames: ['NOMBRE', 'COMPRAS','VENTAS', 'COMISION','COMISION GANADA'],
            colModel: [
                {name: 'NombreComercial', index: 'NombreComercial', width: "100%", align: 'center', sortable: true, editable: true},
                {name: 'totalCompras', index: 'totalCompras', editable: true, width: "100%", align: 'center', sortable: false, formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }},
                {name: 'totalVentas', index: 'totalVentas', editable: true, width: "100%", align: 'center', sortable: false, formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }},
                {name: 'comision', index: 'comision', editable: true, width: "100%", align: 'center', sortable: false, formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }},
                {name: 'comisionGanada', index: 'comisionGanada', editable: true, width: "100%", align: 'center', sortable: false, formatter: 'currency', formatoptions: { decimalSeparator: ".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ " }}
            ],
            pager: '#pager',
            rowNum: 20,
            height: "100%",
            width: 980,
            sortname: 'NombreComercial',
            sortorder: 'asc',
            viewrecords: true,
            rownumbers: true,
            footerrow: true,
            userDataOnFooter: true,
            altRows: true,
            editurl: 'scripts/php/gridAgentes.php',
            caption: '<h3>AGENTES</h3>'
        }).navGrid('#pager', 
        {
            add: false,
            edit: false,
            del: false,
            search: false,
            refresh: true,
            refreshtext: 'Recargar Datos'
        }, {},//Opciones para editar
        {},//Opciones para agregar
        {},//Borrado
        {},//Buscar
        {}//parámetros de vista
    )
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
        jQuery("#agentes").jqGrid('setGridParam',
        { url: "scripts/php/gridAgentes.php?inicio=" + inicio + "&final=" + end + "&idUsr=" + id, page: 1 }).trigger("reloadGrid");
    }
        
    function enableAutosubmit(state){
        flAuto = state;
        jQuery("#submitButton").attr("disabled", state);
    }
</script>
<div id='contact-form' align="center">
    <p style="text-align: justify; color:black;">Aquí podrás ver un resumen de todas las ventas de los comercios que has recomendado, y la comisión que te han generado en el período que necesites ver, hasta 60 días para atrás.</p>
    <p style="text-align: justify; color:black;">Las comisiones generadas se abonan mensualmente a tu portal de la siguiente forma: A mes terminado, reporta en la pestaña Compras el importe de tu comisión como si fuera un depósito, pero en Banco selecciona la opción comisiones y en Autorización escribe el mes al que corresponden tus comisiones. Para conocer el importe, selecciona del día 1 al día último del mes en cuestión.</p>
    <p style="text-align: justify; color:black;">Si prefieres que se te deposite en efectivo a una cuenta bancaria, solo envíanos tu factura con IVA desglosado a nuestro domicilio y los datos de la cuenta bancaria (nombre, cta, clabe y banco). Los únicos requisitos para el cobro de comisiones son: Estar activo, es decir  haber realizado al menos una compra de $500 en el mes en cuestión, tener al menos un agente activo, y cobrar vía factura o portal máximo en siguiente mes del período en cuestión.</p>
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
                    <button type="button" onclick="gridResumen(<?php echo $_SESSION['l_usr']; ?>)">
                        <label>
                            Buscar
                        </label>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <br/>
</div>
<table class="agentes" id="agentes">
</table>
<div id="pager">
</div>