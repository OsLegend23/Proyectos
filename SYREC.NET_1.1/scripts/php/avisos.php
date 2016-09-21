<?php 
session_start();
include 'conexion.php';
$db = new Conexion;
$db->sql_connect();
$id = $_SESSION['l_usr'];
$sql = $db->sql_query("SELECT idUsuario, Responsable FROM detalleusuarios, relaciones 
WHERE detalleusuarios.idUsuario = relaciones.idUsuarioHijo AND relaciones.idUsuarioPadre = $id");
$query=$db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = \"".mysql_real_escape_string($id)."\"");
$Perfil=$db->sql_fetch_array($query);
if($Perfil['idPerfil'] == 1){
?>
<div>
    <script type="text/javascript">
        avisos = new nicEditor({
            fullPanel: true
        }).panelInstance('aviso', {
            hasPanel: true
        });
    </script>
    <script type="text/javascript">
        $('#individual').click(function(){
            $("#franquiciatarios").show('slow'); //Le damos efecto
        });
        $('#franquicia').click(function(){
            $("#franquiciatarios").hide('slow');
        });
        $('#red').click(function(){
            $("#franquiciatarios").hide('slow');
        });
    </script>
    <script type="text/javascript">
        $(function(){
			$("#radio").buttonset();
        });
    </script>
    <h2>Avisos</h2>
    <div id="radio">
        <form action="scripts/php/registrarAviso.php" method="post" accept-charset="utf-8">
            <span>
                Destinatario:
            </span>
            <br/>
            <div align="center" style="margin:20px;">
                <input type="radio" name="destinatario" class="radio" id="individual" value="INDIVIDUAL">
                <label for="individual">
                    Individual
                </label>
                <input type="radio" name="destinatario" class="radio" id="franquicia" value="FRANQUICIAS">
                <label for="franquicia">
                    Todas las Franquicias
                </label>
                <input type="radio" name="destinatario" class="radio" id="red" value="RED">
                <label for="red">
                    Toda la Red
                </label>
            </div>
            <div id="franquiciatarios" style="display:none; margin-bottom:20px;">
                <?php
				while($row=$db->sql_fetch_array($sql)){
				?>
				<input type="checkbox" name="individual[]" id="a<?php echo $row[idUsuario]; ?>" value="<?php echo $row[idUsuario]; ?>" />
				<label for="a<?php echo $row[idUsuario]; ?>"><?php echo $row[Responsable]; ?></label>
				<?php	
				}
				?>
            </div>
            <textarea name="aviso" id="aviso" style="width: 800px; height:200px;">
            Ingrese el Aviso Aquí
            </textarea>
            <div align="center" style="margin-top:15px;">
                <input type='hidden' name='rAviso' value='registrar'/><input type="submit" value="Enviar" />
            </div>
        </form>
    </div>
</div>
<?php
}
if($Perfil['idPerfil'] == 2){
?>
<div>
    <script type="text/javascript">
        avisos = new nicEditor({
            fullPanel: true
        }).panelInstance('aviso', {
            hasPanel: true
        });
    </script>
    <script type="text/javascript">
        $('#individual').click(function(){
            $("#franquiciatarios").show('slow'); //Le damos efecto
        });
        $('#red').click(function(){
            $("#franquiciatarios").hide('slow');
        });
    </script>
    <script type="text/javascript">
        $(function(){
			$("#radio").buttonset();
        });
    </script>
    <h2>Avisos</h2>
    <div id="radio">
        <form action="scripts/php/registrarAviso.php" method="post" accept-charset="utf-8">
            <span>
                Destinatario:
            </span>
            <br/>
            <div align="center" style="margin:20px;">
                <input type="radio" name="destinatario" class="radio" id="individual" value="INDIVIDUAL">
                <label for="individual">
                    Individual
                </label>
                <input type="radio" name="destinatario" class="radio" id="red" value="RED">
                <label for="red">
                    Toda la Red
                </label>
            </div>
            <div id="franquiciatarios" style="display:none; margin-bottom:20px;">
                <?php
				while($row=$db->sql_fetch_array($sql)){
				?>
				<input type="checkbox" name="individual[]" id="a<?php echo $row[idUsuario]; ?>" value="<?php echo $row[idUsuario]; ?>" />
				<label for="a<?php echo $row[idUsuario]; ?>"><?php echo $row[Responsable]; ?></label>
				<?php	
				}
				?>
            </div>
            <textarea name="aviso" id="aviso" style="width: 800px; height:200px;">
            Ingrese el Aviso Aquí
            </textarea>
            <div align="center" style="margin-top:15px;">
                <input type='hidden' name='rAviso' value='registrar'/><input type="submit" value="Enviar" />
            </div>
        </form>
    </div>
</div>
<?php
}
?>