<?php
session_start();
include 'scripts/php/conexion.php';

$db = new Conexion;
$db->sql_connect();
$id = $_SESSION["idUsr"];
$_POST["action"];
if ($_POST["action"] == "checkdata") {
    $importe = $_REQUEST["monto"];
    $banco = $_REQUEST["banco"];
    $ref = $_REQUEST["referencia"];
    $tipo = $_REQUEST["tipo"];
    $referencia = $tipo . "-" . $ref;
    $comercio = $db->sql_result($db->sql_query("SELECT NombreComercial FROM detalleusuarios WHERE idUsuario = $id"), 0);
    $insert = $db->sql_query("INSERT INTO depositos(idUsuario,cliente, monto,banco,referencia, concepto, fecha) VALUES(\"" . mysql_real_escape_string($id) . "\",\"" . mysql_real_escape_string($comercio) . "\",\"" . mysql_real_escape_string($importe) . "\",\"" . mysql_real_escape_string($banco) . "\",\"" . mysql_real_escape_string($referencia) . "\",'COMPRA',NOW())");
    if ($insert) {
        $mensaje="
		<div align='center' style='border:solid; border-width:1px; background:#FFF; border-color:#000; padding:2px;'>
			<strong>Solicitud registrada con &eacute;xito</strong>
		</div>";
    } else {
        $mensaje="
		<div align='center' style='color:#F00; border:solid; border-width:1px; background:#FFF; border-color:#F00; padding:2px;'>
			<strong>Error con el Registro, intente m&aacute;s tarde.</strong>
		</div>";
    }
}
?>
<?php header('Content-type: application/vnd.wap.xhtml+xml; charset=utf-8'); ?>
<?php echo '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>WAP-SYREC</title>
        <style type="text/css">
            body {
                margin: 0px;
                padding: 6px 0px 0px 0px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size:60%;
                background-color: #c0c0c0;;
                text-align: center;
            }

            strong {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div align="center">
            <strong>SYREC :: Portal WAP</strong>
            <hr/>
            <?php echo $mensaje; ?>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" accept-charset="utf-8">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <label>
                                    Banco:
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select class='contact-input' name="banco">
                                    <option value="NO" selected="selected">Selecciona</option>
                                    <option value="HSBC 4050215722">HSBC 4050215722</option>
                                    <option value="BBVA 0178547882">BBVA 0178547882</option>
                                    <option value="BANAMEX 5031344">BANAMEX 5031344</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    Tipo:
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <select name="tipo" class='contact-input'>
                                    <option value="0" selected="selected">Selecciona</option>
                                    <option value="EF">Deposito en Efectivo</option>
                                    <option value="TR">Transferencia</option>
                                    <option value="INTER">Interbancario</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    Monto:
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="monto" maxlength="6"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    Referencia:
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="referencia" maxlength="6"/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="enviar" value="Enviar" />
                                <input name="action" type="hidden" value="checkdata" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <div align="center">
                <a href="Carriers.php">REGRESAR</a><hr/>
                <strong>SYREC &copy;<?php echo date('Y') ?></strong>
            </div>
        </div>
    </body>
</html>
