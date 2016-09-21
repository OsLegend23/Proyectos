/**
 * @author FYA
 */
jQuery("#bigset").jqGrid({
    url: 'scripts/php/compras.php',
    datatype: "xml",
    height: '100%',
    width:'100%',
    colNames: ['FECHA', 'CARRIER', 'BANCO', 'REFERENCIA', 'MONTO'],
    colModel: [
		{name: 'fecha', index: 'fecha', width: '100%', align:'center'}, 
		{name: 'carrier', index: 'carrier', width: '100%', align:'center'}, 
		{name: 'banco', index: 'banco', width: '100%', align:'center'},
		{name: 'referencia', index: 'referencia', width: '100%', align:'center'},
		{name: 'monto', index: 'monto', width: '100%',align:'center',formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}}
		],
    rowNum: 50,
    mtype: "POST",
    pager: jQuery('#pagerb'),
    sortname: 'fecha',
    viewrecords: true,
    footerrow : true,
    userDataOnFooter : true,
    caption:'<h3>Compras</h3>',
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
	//var usuario = jQuery("#usuario").val();
        var carrier = jQuery('#carrier').val();
        jQuery("#bigset").jqGrid('setGridParam', {
            url: "scripts/php/compras.php?inicio=" + inicio + "&final=" + fin + "&carrier=" + carrier + "&idUsr=" +id,
            page: 1
        }).trigger("reloadGrid");
}

function enableAutosubmit(state){
    flAuto = state;
    jQuery("#submitButton").attr("disabled", state);
}