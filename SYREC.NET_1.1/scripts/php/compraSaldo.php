<?php
session_start();
//ini_set('session.save_path', '/home/syrec/tmp_session/');
include 'conexion.php';
$db = new Conexion;
$db->sql_connect();
$id = $_SESSION['l_usr'];
$query = $db->sql_query("SELECT idPerfil FROM usuarios WHERE idUsuario = \"" . mysql_real_escape_string($id) . "\"");
$Perfil = $db->sql_fetch_array($query);
if ($Perfil['idPerfil'] == 1) {
?>
    <div style='display:none'>
        <div class='contact-top'>
        </div>
        <div class='contact-content'>
            <h1 class='contact-title'>COMPRAR SALDO</h1>
            <div class='contact-loading' style='display:none'>    
            </div>
            <div class='contact-message' style='display:none'>
            </div>
            <form action='#' style='display:none'>
                <label for='contact-name'>
                    IMPORTE:
                </label>
                <input type='text' id='importe' class='contact-input' name='importe' value="0.00" tabindex='1001' />
                <label for='contact-email'>
                    COMPAÑIA:
                </label>
                <select class='contact-input' name="carrier">
                    <option value="NO" selected="selected">Selecciona</option>
                    <option value="TARJETASNOR">TARJETASN</option>
                    <option value="PAGATAE">PAGATAE</option>
                    <option value="MOVISTAR">MOVISTAR</option>
                    <option value="IUSACELL">IUSACELL</option>
                    <option value="NEXTEL">NEXTEL</option>
                </select>
                <label for='contact-email'>
                    BANCO:
                </label>
                <select class='contact-input' name="banco">
                    <option value="NO" selected="selected">Selecciona</option>
                    <option value="HSBC 4050215722">HSBC 4050215722</option>
                    <option value="BBVA 0178547882">BBVA 0178547882</option>
                    <option value="BANAMEX 5031344">BANAMEX 5031344</option>
                </select>
                <label for='contact-email'>
                    TIPO:
                </label>
                <select name="tipo" id="tipo" class='contact-input'>
                    <option value="0" selected="selected">Selecciona</option>
                    <option value="EF">Deposito en Efectivo</option>
                    <option value="TR">Transferencia</option>
                    <option value="INTER">Interbancario</option>
                </select>
                <label>
                    AUTORIZACIÓN
                </label>
                <input class='contact-input' type="text" name="referencia" id="referencia" size="6" maxlength="6" />
                <button type='submit' class='contact-send contact-button' tabindex='1006'>
                    Registrar Compra
                </button>
                <br/>
                <input type='hidden' name='token' value='registrar'/>
            </form>
        </div>
        <div class='contact-bottom'>
        </div>
    </div>
<?php
}
if ($Perfil['idPerfil'] == 2) {
    $nombre = $db->sql_fetch_array($db->sql_query("SELECT NombreComercial FROM detalleusuarios WHERE idUsuario = $id"));
?>
    <div style='display:none'>
        <div class='contact-top'>
        </div>
        <div class='contact-content'>
            <h1 class='contact-title'>REPORTAR DEPÓSITO PARA COMPRAR SALDO</h1>
            <div class='contact-loading' style='display:none'>
            </div>
            <div class='contact-message' style='display:none'>
            </div>
            <form action='#' style='display:none'>
                <label for='contact-name'>
                    NOMBRE DEL DISTRIBUIDOR:
                </label>
                <input type='text' id='distribuidor' class='contact-input' name='distribuidor' value="<?php echo $nombre[NombreComercial]; ?>" readonly="readonly" tabindex='1001' />
                <label for='contact-name'>
                    IMPORTE:
                </label>
                <input type='text' id='importe' class='contact-input' name='importe' value="0.00" tabindex='1002' />
                <label for='contact-email'>
                    BANCO:
                </label>
                <select class='contact-input' name="banco">
                    <option value="NO" selected="selected">Selecciona</option>
                    <option value="HSBC 4050215722">HSBC 4050215722</option>
                    <option value="BBVA 0178547882">BBVA 0178547882</option>
                    <option value="BANAMEX 5031344">BANAMEX 5031344</option>
                </select>
                <label for='contact-email'>
                    TIPO:
                </label>
                <select name="tipo" id="tipo" class='contact-input'>
                    <option value="0" selected="selected">Selecciona</option>
                    <option value="EF">Deposito en Efectivo</option>
                    <option value="TR">Transferencia</option>
                    <option value="INTER">Interbancario</option>
                </select>
                <label>
                    AUTORIZACIÓN
                </label>
                <input class='contact-input' type="text" name="referencia" id="referencia" size="6" maxlength="6" />
                <button type='submit' class='contact-send contact-button' tabindex='1006'>
                    Enviar
                </button>
                <br/>
                <input type='hidden' name='token' value='registrar'/>
            </form>
        </div>
        <div class='contact-bottom'>
        </div>
    </div>
<?php
}
if ($Perfil['idPerfil'] == 3) {
    $nombre = $db->sql_fetch_array($db->sql_query("SELECT NombreComercial FROM detalleusuarios WHERE idUsuario = $id"));
?>
    <div style='display:none'>
        <div class='contact-top'>
        </div>
        <div class='contact-content'>
            <h1 class='contact-title'>REPORTAR DEPÓSITO PARA COMPRAR SALDO</h1>
            <div class='contact-loading' style='display:none'>
            </div>
            <div class='contact-message' style='display:none'>
            </div>
            <form action='#' style='display:none'>
                <label for='contact-name'>
                    NOMBRE DEL DISTRIBUIDOR:
                </label>
                <input type='text' id='distribuidor' class='contact-input' name='distribuidor' value="<?php echo $nombre[NombreComercial]; ?>" readonly="readonly" tabindex='1001' />
                <label for='contact-name'>
                    IMPORTE:
                </label>
                <input type='text' id='importe' class='contact-input' name='importe' value="0.00" tabindex='1002' />
                <label for='contact-email'>
                    BANCO:
                </label>
                <select class='contact-input' name="banco">
                    <option value="NO" selected="selected">Selecciona</option>
                    <option value="HSBC 4050215722">HSBC 4050215722</option>
                    <option value="BBVA 0178547882">BBVA 0178547882</option>
                    <option value="BANAMEX 5031344">BANAMEX 5031344</option>
                    <option value="ComisionesDirectas">Comisiones Directas</option>
                    <option value="ComisionesRed">Comisiones por Red</option>
                </select>
                <label for='contact-email'>
                    TIPO:
                </label>
                <select name="tipo" id="tipo" class='contact-input'>
                    <option value="0" selected="selected">Selecciona</option>
                    <option value="EF">Deposito en Efectivo</option>
                    <option value="TR">Transferencia</option>
                    <option value="INTER">Interbancario</option>
                </select>
                <label>
                    AUTORIZACIÓN:
                </label>
                <input class='contact-input' type="text" name="referencia" id="referencia" size="6" maxlength="6" />
                <button type='submit' class='contact-send contact-button' tabindex='1006'>
                    Enviar
                </button>
                <br/>
                <input type='hidden' name='token' value='registrar'/>
            </form>
        </div>
        <div class='contact-bottom'>
        </div>
    </div>
<?php
}
?>