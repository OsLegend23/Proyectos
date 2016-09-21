<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include("conexion.php");
$db=new Conexion;
$db->sql_connect();
$id=$_SESSION['l_usr'];
$query=$db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = \"".mysql_real_escape_string($id)."\"");
$Perfil=$db->sql_fetch_array($query);
if($Perfil['idPerfil'] == 1){
?>
<script type="text/javascript" language="JavaScript">
	jQuery(document).ready(function(){
		$("button").button();
		jQuery("#saldos").jqGrid({
			url:'scripts/php/saldosClientesGrid.php?idUsr=<?php echo $id;?>',
			dataType: 'xml',
			mtype: 'POST',
			colNames:['NOMBRE','SALDO INICIAL','COMPRAS','VENTAS','COMISIONES','SALDO ACTUAL'],
			colModel:[
			{name:'NombreComercial', index:'NombreComercial', width:"100%", align:'left', sortable:true, editable:true},
			{name:'saldoIncial', index:'saldo_inicial', editable:true, width:"100%", align:'left', sortable:false},
			{name:'compras', index:'compras', editable:false, width:"100%", align:'center', editoptions:{size:35}},
			{name:'ventas', index:'ventas', editable:true, width:"100%", align:'center', sortable:false},
			{name:'comisiones', index:'comisiones', editable:true, width:"100%", align:'left', align:'center', sortable:false}, 
			{name:'saldo_actual', index:'saldo_actual', editable:true, width:"100%", align:'center'}, 
			],
			pager:'#pager',
			rowNum:20,
			height:"100%",
			width:980,
			sortname:'NombreComercial',
			sortorder:'asc',
			viewrecords:true, 
			rownumbers: true,
			footerrow : false,
            userDataOnFooter : false,
            altRows : true,
            editurl:'scripts/php/saldosClientesGrid.php',
			caption:'<h3>Franquicias</h3>' 
		}).navGrid('#pager',{add:false,edit:true,edittext:'Editar Registro',del:false,search:false,refresh:true,refreshtext:'Recargar Datos'},
			{height: "100%", width: 350, reloadAfterSubmit: true, closeAfterEdit:true},//Opciones para editar
			{},//Opciones para agregar
			{},//Borrado
			{sopt:['cn']},//Buscar
			{}//parámetros de vista
		)
	});
</script>
<div id='contact-form' align="center">
	En esta sección se muestran los saldos de los Comercios que ha dado de alta.<br/>
</div>
<table class="saldos" id="saldos"></table>
<div id="pager"></div>
<?php
}
if($Perfil['idPerfil'] == 2){
?>
<script type="text/javascript" language="JavaScript">
	jQuery(document).ready(function(){
		$("button").button();
		jQuery("#saldos").jqGrid({
			url:'scripts/php/saldosClientesGrid.php?idUsr=<?php echo $id;?>',
			dataType: 'xml',
			mtype: 'POST',
			colNames:['NOMBRE','SALDO INICIAL','SALDO ACTUAL'],
			colModel:[
			{name:'NombreComercial', index:'NombreComercial', width:"100%", align:'left', sortable:true, editable:true},
			{name:'saldoIncial', index:'saldo_inicial', editable:true, width:"100%", align:'center', sortable:false},
			{name:'saldo_actual', index:'saldo_actual', editable:true, width:"100%", align:'center'}, 
			],
			pager:'#pager',
			rowNum:50,
			height:"100%",
			width:600,
			sortname:'NombreComercial',
			sortorder:'asc',
			viewrecords:true, 
			rownumbers: true,
			footerrow : true,
            userDataOnFooter : true,
            altRows : true,
            editurl:'scripts/php/saldosClientesGrid.php',
			caption:'<h3>Saldos de los Comercios</h3>' 
		}).navGrid('#pager',{add:false,edit:false,edittext:'Editar Registro',del:false,search:false,refresh:true,refreshtext:'Recargar Datos'},
			{height: "100%", width: 350, reloadAfterSubmit: true, closeAfterEdit:true},//Opciones para editar
			{},//Opciones para agregar
			{},//Borrado
			{sopt:['cn']},//Buscar
			{}//parámetros de vista
		)
	});
</script>
<div id='contact-form' align="center">
	En esta sección se muestran los Saldos de los Comercios que ha dado de alta<br/>
</div>
<table class="saldos" id="saldos"></table>
<div id="pager"></div>
<?php
}
?>			