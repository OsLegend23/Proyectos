<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
if (empty($_SESSION['l_usr'])) {
    echo "<div align='center' style='color:#F00;'>NO HA INICIADO SESION</div>";
} else {
    $id = $_SESSION['l_usr'];
?>
    <script type="text/javascript" language="JavaScript">
        jQuery(document).ready(function(){
            $("button").button();
            jQuery("#cajeros").jqGrid({
                url: 'scripts/php/gridCajeros.php?idUsr=<?php echo $id; ?>',
                dataType: 'xml',
                mtype: 'POST',
                colNames: ['NOMBRE', 'CELULAR', 'TELEFONO','ESTATUS'],
                colModel: [
                    { name: 'nombreCajero', index: 'nombre_cajero', width: "100%", align: 'left', sortable: true, editable:true, editoptions:{readonly:true} },
                    { name: 'celular', index: 'celular', editable: false, width: "100%", align: 'center', sortable: false },
                    { name: 'telefono', index: 'telefono', editable: false, width: "100%", align: 'center', sortable: false },
                    { name: 'estatus', index:'estatus', width:60, align:'center', editable:true, edittype:"select", editoptions:{value:"1:HABILITAR;0:DESHABILITAR"} }
                ],
                pager: '#pCajeros',
                rowNum: 20,
                height: "100%",
                width: 700,
                sortname: 'nombreCajero',
                sortorder: 'asc',
                viewrecords: true,
                rownumbers: true,
                altRows: true,
                editurl: 'scripts/php/gridCajeros.php',
                caption: '<h3>CAJEROS</h3>'
            }).navGrid('#pCajeros', { add: false, edit:true,edittext:'Editar Registro', del: false, search: false, refresh: true, refreshtext: 'Recargar Datos' },
            {height: "100%", width: 350, reloadAfterSubmit: true, closeAfterEdit:true},//Opciones para editar
            {},//Opciones para agregar
            {},//Borrado
            {},//Buscar
            {}//parámetros de vista
        )
        });
    </script>
    <div id='contact-form' align="center">
    		En esta secci&oacute;n se muestra una lista de los cajeros que has dado de alta, aqu&iacute; podr&aacute;s dar de alta, habilitar o deshabilitar y modificar a tus cajeros.<br/>
        <div style="padding:15px;"><button type="button" class='contact'><label>Dar de Alta</label></button></div>
    </div>
    <table id="cajeros"></table>
    <div id="pCajeros"></div>
    <script type='text/javascript' src='scripts/js/jquery.simplemodal.js'></script>
    <script type='text/javascript' src='scripts/js/cajero.js'></script>
    <link type="text/css" rel="stylesheet" href="css/cajero.css" />
<?php
}
?>