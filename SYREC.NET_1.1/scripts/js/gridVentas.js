/**
 * @author FYA
 */
jQuery("#bigset").jqGrid({
    url: 'scripts/php/estadoVentas.php',
    datatype: "xml",
    height: '100%',
	width:650,
    colNames: ['COMERCIO', 'CARRIER', 'TOTAL VENTAS', 'MONTO TOTAL', 'COMISION TOTAL'],
    colModel: [
		{name: 'NombreComercial', index: 'NombreComercial', width: '100%', sortable:true, align:'center',}, 
		{name: 'carrier', index: 'carrier', width: '100%', sortable:true, align:'center'}, 
		{name: 'total_ventas', index: 'total_ventas', width: '100%', sortable:false, align:'center'},
		{name: 'total_monto', index: 'total_monto', width: '100%',align:'center', sortable:false, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
		{name: 'total_comision', index: 'total_comision', width: '100%',align:'center', sortable:false, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}}
	], 
    mtype: "POST",
	rowNum: 50,
    pager: jQuery('#pagerb'),
    sortname: 'NombreComercial',
    viewrecords: true,
	footerrow : true,
    userDataOnFooter : true,
	caption:'<h3>Ventas</h3>',
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
	var final = jQuery("#final").val();
	var usuario = jQuery("#usuario").val();
    jQuery("#bigset").jqGrid('setGridParam', {
        url: "scripts/php/estadoVentas.php?inicio=" + inicio + "&final=" + final + "&usuario=" + usuario + "&idUsr=" +id, 
        page: 1
    }).trigger("reloadGrid");
}

function enableAutosubmit(state){
    flAuto = state;
    jQuery("#submitButton").attr("disabled", state);
}