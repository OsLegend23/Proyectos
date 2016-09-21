<?php
session_start();
?>
<div align="center">
    <p>En esta sección se muestran tus datos personales y también podrás cambiar tú contraseña.</p>
</div>
<br />
<script type="text/javascript" language="JavaScript">
    jQuery(document).ready(function(){
        $("button").button();
        jQuery("#perfil").jqGrid({
            url:'scripts/php/perfilGrid.php?id=<?php echo $_SESSION["l_usr"]; ?>',
            dataType: 'xml',
            mtype: 'POST',
            colNames:['', ''],
            colModel:[
                {name:'', index:'', width:"100%", align:'right', sortable:false, editoptions:{readonly:true}},
                {name:'', index:'', width:"100%", align:'left', sortable:false},
            ],
            pager:jQuery('#pager'),
            pgtext: false,
            pginput: false,
            pgbuttons: false,
            rowNum:8,
            height:"100%",
            width:450,
            viewrecords:true,
            hiddengrid: false,
            altRows : true,
            caption:'<div style="text-align:center; float:none;"><img src="images/user_info.png" width="50" style="float:none;" /><h3>PERFIL</h3></div>'
        }).navGrid('#pager',{add:false,edit:false,del:false,search:false,refresh:true,refreshtext:'Recargar Datos'},
        {},//Opciones para editar
        {},//Opciones para agregar
        {},//Borrado
        {},//Buscar
        {}//parámetros de vista
    );
    });
</script>
<div align="center" id="changePassword">
    <a href="#" class="cambiaPassword">Cambiar mi contraseña</a>
</div>
<table class="perfil" id="perfil"></table>
<div id="pager"></div>
<script type='text/javascript' src='scripts/js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='scripts/js/chagePassword.js'></script>
