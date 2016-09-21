<?php 
if (isset($_SESSION['User']) and $_SESSION["Por"] == "movil") {
} else {
    
?>
<form action="actions/verifica.php" id="loginForm" name="loginForm" method="post">
    Clave de acceso:&nbsp;<input type="password" id="contrasena" name="contrasena" size="7" maxlength="7" />
    <br/>
    <input type="submit" id="enviar" name="enviar" value="Entrar" />
</form>
<?php } ?>