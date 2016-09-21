<?php
@session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("button", ".demo").button();
        $('button').each(function(i){
            var titulo = $(this).attr('id');
            if (titulo == "buttonCuenta" || titulo == "buttonTraspasos" || titulo == "buttonCompras" || titulo == "buttonVentas" || titulo == "buttonAgentes" || titulo == "button0Compras" || titulo == "buttonComision") {
                $(this).click(function(){
                    $("#load").html('<img alt="carga" src="images/loading.gif" style="text-align:center; float:none; padding:30px;"/>');
                    $("#load").load("scripts/php/eCuenta.php?r=" + i);
                });
            }
        });
        
    })
</script>
<div class="demo" align="center" style="padding:5px;">
    <button type="button" id="buttonCuenta">
        <label>
            Estado de Cuenta
        </label>
    </button>
    <button type="button" id="buttonTraspasos">
        <label>
            Traspasos
        </label>
    </button>
    <button type="button" id="buttonCompras">
        <label>
            Compras
        </label>
    </button>
    <button type="button" id="buttonVentas">
        <label>
            Ventas
        </label>
    </button>
    <button type="button" id="button0Compras">
        <label>
            Cero Compras
        </label>
    </button>
    <button type="button" id="buttonAgentes">
        <label>
            Agentes
        </label>
    </button>
    <button type="button" id="buttonComision">
        <label>
            Comisiones Directas
        </label>
    </button>
    <br/>
    <div align="center" id="load">
    </div>
</div>
