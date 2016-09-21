<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include("conexion.php");
$db = new Conexion;
$db->sql_connect();
$id = $_SESSION['l_usr'];
$query = $db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = \"" . mysql_real_escape_string($id) . "\"");
$Perfil = $db->sql_fetch_array($query);
if ($Perfil['idPerfil'] == 1) {
?>
    <div align="center" style="padding-bottom:15px;">
        En esta sección puedes ver, y autorizar o rechazar una vez que hayas verificado en bancos, los depósitos que reportan las diferentes franquicias.
    </div>
    <script type="text/javascript" language="JavaScript">    
        jQuery(document).ready(function(){
            jQuery("#saldos").jqGrid({
                url:'scripts/php/gridDepositos.php?idUsr=<?php echo $id; ?>',
                dataType: 'xml',
                mtype: 'POST',
                colNames:['FECHA','IDENTIFICADOR','SOLICITANTE','MONTO','BANCO', 'REFERENCIA','ESTATUS','OBSERVACIONES'],
                colModel:[
                    {name:'fecha', index:'fecha', width:"100%", align:'center', editable:true, editoptions:{readonly:true}},
                    {name:'idUsuario', index:'idUsuario', width:"100%", align:'center'},
                    {name:'solicitante', index:'solicitante', width:"100%", align:'center', editable:false, editoptions:{readonly:true}},
                    {name:'monto', index:'monto', width:"100%", align:'center', editable:true, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}, editoptions:{size:35}},
                    {name:'banco', index:'banco', width:"100%", align:'center', sortable:false, editable:false, editoptions:{size:35}},
                    {name:'referencia', index:'referencia', width:"100%", align:'center', sortable:false, editable:false, editoptions:{size:35}},
                    {name:'estatus', index:'estatus', width:"100%", align:'center', editable:true, edittype:"select", editoptions:{value:"0:RECHAZADO;1:ACEPTADO"}},
                    {name:'note',index:'note', width:"100%", sortable:false, editable:true, edittype:"textarea", editoptions:{rows:"5",cols:"25"}}
                ],
                pager:'#pager',
                rowNum:50,
                height:"100%",
                width:900,
                sortname:'fecha',
                sortorder:'desc',
                viewrecords:true,
                rownumbers: true,
                editurl: 'scripts/php/gridDepositos.php?idUsr=<?php echo $id; ?>',
                caption:'<h3>DEPÓSITOS POR VALIDAR</h3>'
            }).navGrid('#pager',{add:false,edit:true,edittext:'Editar Datos',del:false,search:false,refresh:true,refreshtext:'Recargar Datos'},
            {height: "100%", width: 350, reloadAfterSubmit: true, closeAfterEdit:true},//Opciones para editar
            {},//Opciones para agregar
            {width:350, reloadAfterSubmit:true},//Borrado
            {},//Buscar
            {}//parámetros de vista
        );
        });
    </script>
    <table class="saldos" id="saldos"></table>
    <div id="pager"></div>
    <script type='text/javascript' src='scripts/js/jquery.simplemodal.js'></script>
    <script type='text/javascript' src='scripts/js/contact.js'></script>
<?php
}
if ($Perfil['idPerfil'] == 2) {
?>
    <div align="center" style="padding-bottom:15px;">
        En esta sección puedes ver, y autorizar o rechazar una vez que hayas verificado en bancos, los depósitos que te reportan los diferentes comercios.
    </div>
    <script type="text/javascript" language="JavaScript">
        jQuery(document).ready(function(){
            $("button").button();
            jQuery("#saldos").jqGrid({
                url:'scripts/php/gridDepositos.php?idUsr=<?php echo $id; ?>',
                dataType: 'xml',
                mtype: 'POST',
                colNames:['FECHA','IDENTIFICADOR','SOLICITANTE','MONTO','BANCO', 'REFERENCIA','ESTATUS','OBSERVACIONES'],
                colModel:[
                    {name:'fecha', index:'fecha', width:"100%", align:'center', editable:true, editoptions:{readonly:true}},
                    {name:'idUsuario', index:'idUsuario', width:"100%", align:'center'},
                    {name:'solicitante', index:'solicitante', width:"100%", align:'center', editable:false, editoptions:{readonly:true}},
                    {name:'monto', index:'monto', width:"100%", align:'center', editable:true, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}, editoptions:{size:35}},
                    {name:'banco', index:'banco', width:"100%", align:'center', sortable:false, editable:false, editoptions:{size:35}},
                    {name:'referencia', index:'referencia', width:"100%", align:'center', sortable:false, editable:false, editoptions:{size:35}},
                    {name:'estatus', index:'estatus', width:"100%", align:'center', editable:true, edittype:"select", editoptions:{value:"0:RECHAZADO;1:ACEPTADO"}},
                    {name:'note',index:'note', width:"100%", sortable:false, editable:true, edittype:"textarea", editoptions:{rows:"5",cols:"25"}}
                ],
                pager:'#pager',
                rowNum:50,
                height:"100%",
                width:900,
                sortname:'fecha',
                sortorder:'desc',
                viewrecords:true,
                rownumbers: true,
                editurl: 'scripts/php/gridDepositos.php?idUsr=<?php echo $id; ?>',
                caption:'<h3>DEPÓSITOS POR VALIDAR</h3>'
            }).navGrid('#pager',{add:false,edit:true,edittext:'Editar Datos',del:false,search:false,refresh:true,refreshtext:'Recargar Datos'},
            {height: "100%", width: 350, reloadAfterSubmit: true, closeAfterEdit:true/*,
                                    afterSubmit:function(response,postdata){
                                            var data = response.responseXML.documentElement;
                                            alert(data);
                                            if(data != null){
                                                    return [true,"",""];
                                            }
                                            return [false,"No tienes suficiente saldo para traspasar",""];
                                    }*/
            },//Opciones para editar
            {},//Opciones para agregar
            {width:350, reloadAfterSubmit:false},//Borrado
            {},//Buscar
            {}//parámetros de vista
        );
        });
    </script>
    <table class="saldos" id="saldos"></table>
    <div id="pager"></div>
    <div id='contact-form' align="center" style="padding-top:15px;">
        <button type="button" class='contact'>Reportar Depósito</button>
    </div>
    <script type='text/javascript' src='scripts/js/jquery.simplemodal.js'></script>
    <script type='text/javascript' src='scripts/js/compraSaldo.js'></script>
<?php
}
if ($Perfil['idPerfil'] == 3) {
?>
    <div align="center" style="padding-bottom:15px;">
        En esta sección podrás reportar tus compras de saldo (depósitos bancarios) y conocer el status de las últimas 100 (20 por hoja).
    </div>
    <script type="text/javascript" language="JavaScript">
        jQuery(document).ready(function(){
            $("button").button();
            jQuery("#saldos").jqGrid({
                url:'scripts/php/gridDepositos.php?idUsr=<?php echo $id; ?>',
                dataType: 'xml',
                mtype: 'POST',
                colNames:['FECHA','AUTORIZACIÓN','MONTO','BANCO', 'REFERENCIA','ESTATUS','OBSERVACIONES'],
                colModel:[
                    {name:'fecha', index:'fecha', width:"100%", align:'center', sortable:true, editable:false, editoptions:{size:35}},
                    {name:'fechaAut', index:'fechaAut', width:"100%", align:'center', editable:false, editoptions:{readonly:true}},
                    {name:'monto', index:'monto', width:"100%", align:'center', editable:false, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}, editoptions:{size:35}},
                    {name:'banco', index:'banco', width:"100%", align:'center', sortable:false, editable:false, editoptions:{size:35}},
                    {name:'referencia', index:'referencia', width:"100%", align:'center', sortable:false, editable:false, editoptions:{size:35}},
                    {name:'estatus', index:'estatus', width:"100%", align:'center', edittype:"select", editoptions:{value:"0:RECHAZADO;1:ACEPTADO"}},
                    {name:'note',index:'note', width:"100%", sortable:false, edittype:"textarea", editoptions:{rows:"5",cols:"25"}}
                ],
                pager:'#pager',
                rowNum:50,
                height:"100%",
                width:900,
                sortname:'fecha',
                sortorder:'desc',
                viewrecords:false,
                rownumbers: true,
                grouping: true,
                groupingView : {
                    groupField : ['estatus'],
                    groupText : ['<b>{0} - {1} Dato(s)</b>']
                },
                caption:'<h3>COMPRAS</h3>'
            }).navGrid('#pager',{add:false,edit:false,del:false,search:false,refresh:true,refreshtext:'Recargar Datos'},
            {},//Opciones para editar
            {},//Opciones para agregar
            {},//Borrado
            {},//Buscar
            {}//parámetros de vista
        );
        });
    </script>
    <table class="saldos" id="saldos"></table>
    <div id="pager"></div>
    <div id='contact-form' align="center" style="padding-top:15px;">
        <button type="button" class='contact'>Reportar Depósito</button>
    </div>
    <script type='text/javascript' src='scripts/js/jquery.simplemodal.js'></script>
    <script type='text/javascript' src='scripts/js/compraSaldo.js'></script>
<?php
}
?>