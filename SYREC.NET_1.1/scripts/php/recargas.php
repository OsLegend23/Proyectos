<?php

//ini_set('session.save_path', '/home/syrec/tmp_session/');
//session_start();
//if (empty($_SESSION['l_usr'])) {
//    echo "<div align='center' style='color:#00F;'>NO HA INICIADO SESION</div>";
//} else {
?>
<script type="text/javascript">
    $(document).ready(function(){
        var carrier = new Array();
        carrier[0]="TELCEL";
        carrier[1]="MOVISTAR";
        carrier[2]="IUSACELL";
        carrier[3]="UNEFON";
        carrier[4]="NEXTEL";
        carrier[5]="CACHITO";
        carrier[6]="MELATE";
        $('.carrier').each(function(i){
            $(this).click(function(){
                $('#contenedor').html('<iframe src="scripts/php/carriers.php?carrier='+ carrier[i] +'" width="100%" height="800" frameborder="0" scrolling="auto" > </iframe>');
            });
        });
        $("#otrasMarcas").click(function(evento){
            if ($("#otrasMarcas").attr("checked")){
                $(".oculto").css("display", "block");
                $(".ocultoD").css("display", "none");
            }else{
                $(".oculto").css("display", "none");
                $(".ocultoD").css("display", "block");
            }
        });
    });
</script>
<h3>Seleccione la compañía:</h3>
<br/>
<input type="checkbox" name="otrasMarcas" value="1" id="otrasMarcas"> Otras Marcas
<br>
<table width="100%" border="0">
    <tr>
        <td align="center" class="ocultoD">
            <img src="images/TELCEL_mini.jpg" alt="TELCEL" style="cursor:pointer; float:none;" class="carrier"/>
        </td>
        <td>&nbsp;</td>
        <td align="center" class="oculto" style="display: none;">
            <img src="images/MOVISTAR_mini.jpg" alt="MOVISTAR" style="cursor:pointer; float:none;" class="carrier"/>
        </td>
        <td align="center" class="oculto" style="display: none;">
            <img src="images/IUSACELL_mini.jpg" alt="IUSACELL" style="cursor:pointer; float:none;" class="carrier"/>
        </td>
        <td>&nbsp;</td>
        <td align="center" class="oculto" style="display: none;">
            <img src="images/UNEFON_mini.jpg" alt="UNEFON" style="cursor:pointer; float:none;" class="carrier"/>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2" class="oculto" style="display: none;">
            <img src="images/Nextel.jpg" alt="NEXTEL" style="cursor:pointer; float:none;" class="carrier"/>
        </td>
        <td align="center" colspan="2" class="ocultoD">
            <img src="images/cachitoMovil.jpg" alt="CACHITO MOVIL" style="cursor:pointer; float:none;" class="carrier" />
        </td>
        <td align="center" colspan="2" class="ocultoD">
            <img src="images/melateMovil.jpg" alt="MELATE MOVIL" style="cursor:pointer; float:none;" class="carrier" />
        </td>
    </tr>
</table>
<?php

//
//}
?>