/**
 * @author FYA
 */
jQuery("#bigset").jqGrid({
    url: 'scripts/php/estadoCompras.php',
    datatype: "xml",
    height: '100%',
    width:600,
    colNames: ['FECHA', 'ID USUARIO','SOLICITÓ', 'BANCO', 'REFERENCIA', 'MONTO'],
    colModel: [
		{name: 'fecha', index: 'fecha', width: '100%', align:'center'},
		{name: 'idUsuario', index: 'idUsuario', width: '100%', align:'center'},  
		{name: 'solicito', index: 'solicito', width: '100%', align:'center'}, 
		{name: 'banco', index: 'banco', width: '100%', align:'center'},
		{name: 'referencia', index: 'referencia', width: '100%', align:'center'},
		{name: 'monto', index: 'monto', width: '100%',align:'center',formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}}
		],
    rowNum: 50,
    mtype: "POST",
    pager: '#pagerb',
    sortname: 'fecha',
    viewrecords: true,
    footerrow : true,
    userDataOnFooter : true,
    grouping: true,
    groupingView : {
        groupField : ['banco'],
        groupText : ['<b>{0} - {1} Dato(s)</b>']
    },
    caption:'<h3>Traspasos</h3>',
    sortorder: "asc"
}).filterToolbar('#bigset',{autosearch:true,stringResult: true,searchOnEnter : false});

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
	var usuario = jQuery("#usuario").val();
    jQuery("#bigset").jqGrid('setGridParam', {
        url: "scripts/php/estadoCompras.php?inicio=" + inicio + "&final=" + end + "&usuario=" + usuario + "&idUsr=" +id,
        page: 1
    }).trigger("reloadGrid");
}

function enableAutosubmit(state){
    flAuto = state;
    jQuery("#submitButton").attr("disabled", state);
}