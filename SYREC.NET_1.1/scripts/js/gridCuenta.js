/**
 * @author FYA
 */
jQuery("#bigset").jqGrid({
    url: 'scripts/php/estadoCuenta.php',
    datatype: "xml",
    height: '100%',
	width:'100%',
    colNames: ['CONCEPTO', 'NUM OPER', 'IMPORTE', '% COMPRA-VENTA', 'COMISIONES', '% COMISIONES'],
    colModel: [
		{name: 'concepto', index: 'concepto', width: '100%'}, 
		{name: 'numOper', index: 'numOper', width: '100%',align:'center'}, 
		{name: 'importe', index: 'importe', width: '100%',align:'center'},
		{name: 'porcentaje', index: 'porcentaje', width: '100%',align:'center'},
		{name: 'comisiones', index: 'comisiones', width: '100%',align:'center'},
		{name: 'pComisiones', index: 'pComisiones', width: '100%',align:'center'}
		],
    //rowNum: 9,
    // rowList:[10,20,30], 
    mtype: "POST",
    pager: jQuery('#pagerb'),
    pgbuttons: false,
    pgtext: false,
    pginput: false,
    sortname: 'idUsuario',
    viewrecords: true,
	caption:'<h3>Estado de Cuenta</h3>',
    sortorder: "asc"
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
	var fin = jQuery("#final").val();
	var usuario = jQuery("#usuario").val();
    jQuery("#bigset").jqGrid('setGridParam', {
        url: "scripts/php/estadoCuenta.php?inicio=" + inicio + "&final=" + fin + "&usuario=" + usuario + "&idUsr=" +id, 
        page: 1
    }).trigger("reloadGrid");
}

function enableAutosubmit(state){
    flAuto = state;
    jQuery("#submitButton").attr("disabled", state);
}