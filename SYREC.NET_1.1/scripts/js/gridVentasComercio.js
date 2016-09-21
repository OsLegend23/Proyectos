/**
 * @author FYA
 */
jQuery("#bigset").jqGrid({
    url: 'scripts/php/estadoVentas.php',
    datatype: "xml",
    height: '100%',
	width: 650,
    colNames: ['FECHA', 'CARRIER', 'CELULAR', 'MONTO', 'AUTORIZACION'],
    colModel: [
		{name: 'fecha', index: 'fecha', width: '100%', sortable:true, align:'center'}, 
		{name: 'carrier', index: 'carrier', width: '100%', sortable:true, align:'center'}, 
		{name: 'celular', index: 'celular', width: '100%', sortable:false, align:'center'},
		{name: 'monto', index: 'monto', width: '100%', sortable:false, align:'center',formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
		{name: 'autorizacion', index: 'autorizacion', sortable:false, width: '100%',align:'center'}
		],
    mtype: "POST",
	rowNum: 50,
    pager: jQuery('#pagerb'),
    viewrecords: true,
	sortname: 'fecha',
    viewrecords: true,
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