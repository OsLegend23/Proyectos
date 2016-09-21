<?php
@session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include("conexion.php");
$db = new Conexion;
$db->sql_connect();
$id = $_SESSION['l_usr'];
$totalRegistros = $db->sql_result($db->sql_query("SELECT COUNT(*) FROM detalleusuarios, relaciones WHERE idUsuarioPadre = $id AND idUsuarioHijo = idUsuario"), 0);
$query = $db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = \"" . mysql_real_escape_string($id) . "\"");
$Perfil = $db->sql_fetch_array($query);
if ($Perfil['idPerfil'] == 1) {
?>
<script type="text/javascript" language="JavaScript">
    jQuery(document).ready(function(){
        $("button").button();
        jQuery("#saldos").jqGrid({
            url:'scripts/php/gridClientes.php?idUsr=<?php echo $id; ?>',
            dataType: 'xml',
            mtype: 'POST',
            colNames:['ID','NOMBRE','RESPONSABLE','MIEMBRO DESDE','EMAIL','CIUDAD','ESTADO','TELEFONO','CELULAR','RFC','ESTATUS'],
            colModel:[
                {name:'idUsuario', index:'idUsuario', width:20, align:'left', sortable:true, editable:true, editoptions:{readonly:true}},
                {name:'NombreComercial', index:'NombreComercial', width:"100%", align:'left', sortable:true, editable:true},
                {name:'Responsable', index:'Responsable', editable:true, width:"100%", align:'left', sortable:false},
                {name:'FechaRegistro', index:'FechaRegistro', editable:false, width:"100%", align:'center', editoptions:{size:35}},
                {name:'email', index:'email', editable:true, width:"100%", align:'center', sortable:false},
                {name:'ciudad', index:'ciudad', editable:true, width:"100%", align:'left', align:'center', sortable:false},
                {name:'estado', index:'estado', editable:true, width:"100%", align:'center'},
                {name:'telefono', index:'telefono', editable:true, width:"100%", align:'center', sortable:false},
                {name:'celular', index:'celular', editable:true, width:"100%", align:'center'},
                {name:'rfc', index:'rfc', editable:true, width:"100%", align:'center'},
                {name:'estatus', index:'estatus', width:60, align:'center', editable:true, edittype:"select", editoptions:{value:"1:HABILITAR;0:DESHABILITAR"}}
            ],
            pager:'#pager',
            rowNum:50,
            height:"100%",
            width:980,
            rowTotal:<?php echo $totalRegistros; ?>,
            loadonce: true,
            sortname:'NombreComercial',
            sortorder:'asc',
            viewrecords:true,
            rownumbers: true,
            footerrow : false,
            userDataOnFooter : false,
            altRows : true,
            editurl:'scripts/php/gridClientes.php',
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
	En esta secci&oacute;n se muestran los Comercios que ha dado de alta, puede editar el estatus de la misma deshabilitando o habilitando toda la red de la franquicia.<br/>
    <div style="padding-bottom:40px;padding-top:15px;width:220px;">
        <button type="button" class='contact' style="float:left;"><label>Dar de Alta</label></button>
        <form method="post" action="scripts/php/php-excel/mysql.php?carrier=usuarios">
            <button type="submit" style="float:right;"><label>Generar Excel</label></button>
        </form>
    </div>

</div>
<table class="saldos" id="saldos"></table>
<div id="pager"></div>
<script type='text/javascript' src='scripts/js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='scripts/js/contact.js'></script>
<link type="text/css" rel="stylesheet" href="css/contact2.css" />
<?php
}
if ($Perfil['idPerfil'] == 2) {
?>
    <script type="text/javascript" language="JavaScript">
        jQuery(document).ready(function(){
            $("button").button();
            jQuery("#saldos").jqGrid({
                url:'scripts/php/gridClientes.php?idUsr=<?php echo $id; ?>',
                dataType: 'xml',
                mtype: 'POST',
                colNames:['ID','NOMBRE','RESPONSABLE','MIEMBRO DESDE','EMAIL','CIUDAD','ESTADO','TELEFONO','CELULAR','RFC','ESTATUS'],
                colModel:[
                    {name:'idUsuario', index:'idUsuario', width:20, align:'left', sortable:true, editable:true, sortable:true,editoptions:{readonly:true}},
                    {name:'NombreComercial', index:'NombreComercial', width:"100%", align:'left', sortable:true, editable:true},
                    {name:'Responsable', index:'Responsable', editable:true, width:"100%", align:'left', sortable:false},
                    {name:'FechaRegistro', index:'FechaRegistro', editable:false, width:"100%", align:'center', editoptions:{size:35}},
                    {name:'email', index:'email', editable:true, width:"100%", align:'center', sortable:false},
                    {name:'ciudad', index:'ciudad', editable:true, width:"100%", align:'left', align:'center', sortable:false},
                    {name:'estado', index:'estado', editable:true, width:"100%", align:'center'},
                    {name:'telefono', index:'telefono', editable:true, width:"100%", align:'center', sortable:false},
                    {name:'celular', index:'celular', editable:true, width:"100%", align:'center'},
                    {name:'rfc', index:'rfc', editable:true, width:"100%", align:'center'},
                    {name:'estatus', index:'estatus', width:60, align:'center', editable:true, edittype:"select", editoptions:{value:"1:HABILITAR;0:DESHABILITAR"}}
                ],
                pager:'#pager',
                rowNum:50,
                rowTotal:<?php echo $totalRegistros; ?>,
                loadonce: true,
                height:"100%",
                width:980,
                autowidth:true,
                sortname:'NombreComercial',
                sortorder:'asc',
                viewrecords:true,
                rownumbers: true,
                viewrecords:true,
                rownumbers: true,
                footerrow : false,
                userDataOnFooter : false,
                altRows : true,
                editurl:'scripts/php/gridClientes.php',
                caption:'<h3>Comercios</h3>'
            }).navGrid('#pager',{add:false,edit:true,edittext:'Editar Registro',del:false,search:false,refresh:true,refreshtext:'Recargar Datos'},
            {height: "100%", width: 350, reloadAfterSubmit: true, closeAfterEdit:true},//Opciones para editar
            {},//Opciones para agregar
            {},//Borrado
            {sopt:['cn']},//Buscar
            {}//parámetros de vista
        ).filterToolbar('#saldos',{autosearch:true,stringResult: true,searchOnEnter : false})
        });
    </script>
    <div id='contact-form' align="center">
        	En esta secci&oacute;n se muestran los Comercios que ha dado de alta, puede editar el estatus de la misma deshabilitando o habilitando toda la red de la franquicia.<br/>
        <div style="padding-bottom:40px;padding-top:15px;width:220px;">
            <button type="button" class='contact' style="float:left;"><label>Dar de Alta</label></button>
            <form method="post" action="scripts/php/php-excel/mysql.php?carrier=usuarios">
                <button type="submit" style="float:right;"><label>Generar Excel</label></button>
            </form>
        </div>
    </div>
    <table class="saldos" id="saldos"></table>
    <div id="pager"></div>
    <script type='text/javascript' src='scripts/js/jquery.simplemodal.js'></script>
    <script type='text/javascript' src='scripts/js/contact.js'></script>
    <link type="text/css" rel="stylesheet" href="css/contact2.css" />
<?php
}
?>