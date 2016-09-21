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
    <div align="center">
        <p>En esta sección puedes ver tu saldo inicial de hoy por carrier y los movimientos realizados en este día, para conocer tu saldo actual. Si realizas una compra de saldo a cualquier carrier, no olvides registrarla en "Registrar Compra TAE!"</p>
    </div>
    <br />
    <script type="text/javascript" language="JavaScript">
        jQuery(document).ready(function(){
            $("button").button();
            jQuery("#saldos").jqGrid({
                url:'scripts/php/saldosGrid.php?id=<?php echo $id; ?>',
                dataType: 'xml',
                mtype: 'POST',
                colNames:['COMPAÑÍA', 'SALDO INICIAL', 'COMPRAS','VENTAS', 'SALDO ACTUAL'],
                colModel:[
                    {name:'compañía', index:'compañía', width:"100%", align:'center', sortable:false, editoptions:{readonly:true}},
                    {name:'saldo_inicial', index:'saldo_inicial', width:"100%", align:'center', sortable:false, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                    {name:'compras', index:'compras', width:"100%", align:'left', align:'center', sortable:false, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                    {name:'ventas', index:'ventas', width:"100%", align:'left', align:'center', sortable:false, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                    {name:'saldo_actual', index:'saldo_actual', width:"100%", align:'center', sortable:false, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}}
                ],
                pager:jQuery('#pager'),
                pgtext: false,
                pginput: false,
                pgbuttons: false,
                rowNum:7,
                height:"100%",
                width:800,
                viewrecords:true,
                hiddengrid: false,
                footerrow : true,
                userDataOnFooter : true,
                altRows : true,
                editurl:'scripts/php/grid.php',
                caption:'<h3>SALDOS</h3>'
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
        <button type="button" class='contact'>Registrar Compra TAE</button>
    </div>
    <script type='text/javascript' src='scripts/js/jquery.simplemodal.js'></script>
    <script type='text/javascript' src='scripts/js/compraSaldo.js'></script>
    <link type="text/css" rel="stylesheet" href="css/contact.css" />
<?php
}
if ($Perfil['idPerfil'] == 2) {
?>
    <div align="center">
    	En esta sección puedes ver tu saldo inicial de hoy y los movimientos realizados en este día
    </div>
    <br />
    <script type="text/javascript" language="JavaScript">
        jQuery(document).ready(function(){
            $("button").button();
            jQuery("#saldos").jqGrid({
                url:'scripts/php/saldosGrid.php?id=<?php echo $id; ?>',
            dataType: 'xml',
            mtype: 'POST',
            colNames:['SALDO INICIAL', 'COMPRAS','TRASPASOS','COMISIONES','CARGOS', 'SALDO ACTUAL'],
            colModel:[
                {name:'saldo_inicial', index:'saldo_inicial', width:"100%", align:'center', sortable:false, editoptions:{size:35},formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                {name:'compras', index:'compras', width:"100%", align:'center', sortable:false, editoptions:{size:35}, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                {name:'ventas', index:'ventas', width:"100%", align:'center', editoptions:{size:35},formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                {name:'comisiones', index:'comisiones', width:"100%", align:'center', editoptions:{size:35},formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                {name:'cargos', index:'cargos', width:"100%", align:'center', editoptions:{size:35},formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                {name:'saldo_actual', index:'saldo_actual', width:"100%", align:'center', editable:false, editoptions:{readonly:true,size:35},formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}}
            ],
            pager:'#pager',
            rowNum:1,
            pgtext: false,
            pginput: false,
            pgbuttons: false,
            height:"100%",
            width:800,
            sortname:'idUsuario',
            sortorder:'asc',
            viewrecords:true,
            hiddengrid: false,
            editurl:'scripts/php/grid.php',
            caption:'<h3>SALDOS</h3>'
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
<?php
}if ($Perfil['idPerfil'] == 3) {
?>
    <div align="center">
    	En esta sección puedes ver tu saldo inicial de hoy y los movimientos realizados en este día.
    </div>
    <br />
    <script type="text/javascript" language="JavaScript">
        jQuery(document).ready(function(){
            $("button").button();
            jQuery("#saldos").jqGrid({
                url:'scripts/php/saldosGrid.php?id=<?php echo $id; ?>',
            dataType: 'xml',
            mtype: 'POST',
            colNames:['SALDO INICIAL', 'COMPRAS','VENTAS','COMISIONES','SALDO ACTUAL'],
            colModel:[
                {name:'saldo_inicial', index:'saldo_inicial', width:"100%", align:'center', sortable:false, editoptions:{size:35},formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                {name:'compras', index:'compras', width:"100%", align:'center', sortable:false, editoptions:{size:35}, formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                {name:'ventas', index:'ventas', width:"100%", align:'center', editoptions:{size:35},formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                {name:'comisiones', index:'comisiones', width:"100%", align:'center', editoptions:{size:35},formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},
                {name:'saldo_actual', index:'saldo_actual', width:"100%", align:'center', editable:false, editoptions:{readonly:true,size:35},formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}}
            ],
            pager:'#pager',
            rowNum:1,
            height:"100%",
            width:800,
            pgtext: false,
            pginput: false,
            pgbuttons: false,
            sortname:'idUsuario',
            sortorder:'asc',
            viewrecords:true,
            hiddengrid: false,
            editurl:'scripts/php/grid.php',
            caption:'<h3>SALDOS</h3>'
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
<?php
}
?>