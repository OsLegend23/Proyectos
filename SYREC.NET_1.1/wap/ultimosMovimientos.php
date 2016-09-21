<?php
session_start();
include 'scripts/php/conexion.php';
$db = new Conexion;
$db->sql_connect();
if (!empty($_SESSION['idUsr']) and $_SESSION["movil"] == "movil") {
    $usrID = $_SESSION["idUsr"];
    $ultimosMovimientos = $db->sql_query("SELECT CONCAT_WS( '-', DATE_FORMAT( fecha, '%c/%d' ) , SUBSTR( carrier, 1, 1 ) , destino, ROUND( monto ) , autorizacion ) AS ULTIMAS_VENTAS
FROM `ventas`
WHERE idUsuario = $usrID
ORDER BY fecha DESC
LIMIT 10 ");
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
                <strong>:: Ultimas Ventas ::</strong>
                <div align="center" style="padding:2px;">
                    <table width="100%">
                        <tbody>
                        <?php
                            if ($db->sql_num_fields($ultimosMovimientos) > 0) {
                                while ($row = $db->sql_fetch_array($ultimosMovimientos)) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $row[ULTIMAS_VENTAS]; ?>
                            </td>
                        </tr>
                        <?php
                                }
                            } else {
                        ?>
                        <tr>
                            <td>
                                <strong>No hay Transacciones</strong>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div align="center" style="padding:2px;">
                <a href="Carriers.php">REGRESAR</a>
            </div>
            <hr/>
            <div align="center">
                <strong>SYREC &copy;<?php echo date('Y') ?></strong>
            </div>
        </div>
    </body>
</html>
<?php
                    } else {
                        header("LOCATION:index.php");
                    }
?>
