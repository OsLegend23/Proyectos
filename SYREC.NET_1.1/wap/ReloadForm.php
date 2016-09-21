<?php
session_start();
if (!empty($_SESSION['idUsr']) and $_SESSION['movil'] == "movil") {
?>
<?php header('Content-type: application/vnd.wap.xhtml+xml; charset=utf-8'); ?>
<?php echo '<?xml version="1.0" encoding="utf-8" ?>'; ?>
    <!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title>WAP-SYREC</title>
            <style type="text/css">
                body {
                    margin: 0px;
                    padding: 6px 0px 0px 0px;
                    font-family: Verdana, Arial, Helvetica, sans-serif;
                    font-size:60%;
                    background-color: #c0c0c0;
                    ;
                    text-align: center;
                }
                strong {
                    text-align: center;
                }
                hr {
                    color: #FF5200;
                }
            </style>
        </head>
        <body>
            <div align="center">
                <strong>SYREC :: Portal WAP</strong><hr/>
            <?php
            if ($_REQUEST["carri"] == "TELCEL") {
            ?>
                    <div style="background:#FFF; border:#00F solid; border-width:1px; color:#00F;"><strong>TELCEL</strong></div>
                    <form action="scripts/php/procesoRecarga.php" method="post">
                        <div align="center">
                            <input type="radio" name="monto" value="20" /><strong>$ 20.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="30" /><strong>$ 30.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="50" /><strong>$ 50.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="100" /><strong>$ 100.00</strong><br/>
                            <input type="radio" name="monto" value="150" /><strong>$ 150.00</strong><br/>
                            <input type="radio" name="monto" value="200" /><strong>$ 200.00</strong><br/>
                            <input type="radio" name="monto" value="300" /><strong>$ 300.00</strong><br/>
                            <input type="radio" name="monto" value="500" /><strong>$ 500.00</strong><br/>
                            <br/>
                            <strong>Celular: </strong><br/>
                            <input type="text" name="celular" maxlength="10" style='-wap-input-format: "10N"'/>
                            <input type="hidden" name="carrier" value="TELCEL"/>
                            <br/><br/>
                            <input type="submit" value="Enviar"/>
                        </div>
                    </form>
            <?php
                }
                if ($_REQUEST["carri"] == "MOVISTAR") {
            ?>
                    <div style="background:#FFF; border:#0F0 solid; border-width:1px; color:#0F0;"><strong>MOVISTAR</strong></div>
                    <form action="scripts/php/procesoRecarga.php" method="post">
                        <div align="center">
                            <input type="radio" name="monto" value="10" /><strong>$ 10.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="20" /><strong>$ 20.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="30" /><strong>$ 30.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="60" /><strong>$ 60.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="120" /><strong>$ 120.00</strong><br/>
                            <input type="radio" name="monto" value="200" /><strong>$ 200.00</strong><br/>
                            <input type="radio" name="monto" value="300" /><strong>$ 300.00</strong><br/>
                            <input type="radio" name="monto" value="500" /><strong>$ 500.00</strong><br/>
                            <br/>
                            <strong>Celular: </strong><br/>
                            <input type="text" name="celular" maxlength="10" style='-wap-input-format: "10N"'/>
                            <input type="hidden" name="carrier" value="MOVISTAR"/>
                            <br/><br/>
                            <input type="submit" value="Enviar"/>
                        </div>
                    </form>
                <?php
                }
                if ($_REQUEST["carri"] == "IUSACELL") {
                ?>
                    <div style="background:#FFF; border:#F00 solid; border-width:1px; color:#F00;"><strong>IUSACELL</strong></div>
                    <form action="scripts/php/procesoRecarga.php" method="post">
                        <div align="center">
                            <input type="radio" name="monto" value="50" /><strong>$ 50.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="100" /><strong>$ 100.00</strong><br/>
                            <input type="radio" name="monto" value="150" /><strong>$ 150.00</strong><br/>
                            <input type="radio" name="monto" value="200" /><strong>$ 200.00</strong><br/>
                            <input type="radio" name="monto" value="300" /><strong>$ 300.00</strong><br/>
                            <br/>
                            <strong>Celular: </strong><br/>
                            <input type="text" name="celular" maxlength="10" style='-wap-input-format: "10N"'/>
                            <input type="hidden" name="carrier" value="IUSACELL"/>
                            <br/><br/>
                            <input type="submit" value="Enviar"/>
                        </div>
                    </form>
                <?php
                }
                if ($_REQUEST["carri"] == "UNEFON") {
                ?>
                    <div style="background:#FFF; border:#FF0 solid; border-width:1px; color:#FF0;"><strong>UNEFON</strong></div>
                    <form action="scripts/php/procesoRecarga.php" method="post">
                        <div align="center">
                            <input type="radio" name="monto" value="50" /><strong>$ 50.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="100" /><strong>$ 100.00</strong><br/>
                            <input type="radio" name="monto" value="150" /><strong>$ 150.00</strong><br/>
                            <input type="radio" name="monto" value="200" /><strong>$ 200.00</strong><br/>
                            <input type="radio" name="monto" value="300" /><strong>$ 300.00</strong><br/>
                            <br/>
                            <strong>Celular: </strong><br/>
                            <input type="text" name="celular" maxlength="10" style='-wap-input-format: "10N"'/>
                            <input type="hidden" name="carrier" value="UNEFON"/>
                            <br/><br/>
                            <input type="submit" value="Enviar"/>
                        </div>
                    </form>
                <?php
                }
                if ($_REQUEST["carri"] == "NEXTEL") {
                ?>
                    <div style="background:#FFF; border:#F00 solid; border-width:1px; color:#F00;"><strong>NEXTEL</strong></div>
                    <form action="scripts/php/procesoRecarga.php" method="post">
                        <div align="center">
                            <input type="radio" name="monto" value="30" /><strong>$ 30.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="50" /><strong>$ 50.00</strong><br/>
                            <input type="radio" name="monto" value="100" /><strong>$ 100.00</strong><br/>
                            <input type="radio" name="monto" value="200" /><strong>$ 200.00</strong><br/>
                            <input type="radio" name="monto" value="500" /><strong>$ 500.00</strong><br/>
                            <br/>
                            <strong>Celular: </strong><br/>
                            <input type="text" name="celular" maxlength="10" style='-wap-input-format: "10N"'/>
                            <input type="hidden" name="carrier" value="NEXTEL"/>
                            <br/><br/>
                            <input type="submit" value="Enviar"/>
                        </div>
                    </form>
                <?php
                }
                if ($_REQUEST["carri"] == "CACHITO") {
                ?>
                    <div style="background:#FFF; border:#F00 solid; border-width:1px; color:#F00;"><strong>CACHITO MOVIL</strong></div>
                    <form action="scripts/php/recargaLoteNal.php" method="post">
                        <div align="center">
                            <input type="radio" name="monto" value="20" /><strong>$ 20.00&nbsp;&nbsp;</strong><br/>
                            <input type="radio" name="monto" value="100" /><strong>$ 100.00</strong><br/>
                            <br/>
                            <strong>Celular: </strong><br/>
                            <input type="text" name="celular" maxlength="10" style='-wap-input-format: "10N"'/>
                            <input type="hidden" name="carrier" value="CACHITO"/>
                            <br/><br/>
                            <input type="submit" value="Enviar"/>
                        </div>
                    </form>
                <?php
                }
                if ($_REQUEST["carri"] == "MELATE") {
                ?>
                    <div style="background:#FFF; border:#F00 solid; border-width:1px; color:#F00;"><strong>MELATE MOVIL</strong></div>
                    <form action="scripts/php/recargaLoteNal.php" method="post">
                        <div align="center">
                            <input type="radio" name="monto" value="25" /><strong>$ 25.00</strong><br/>
                            <br/>
                            <strong>Celular: </strong><br/>
                            <input type="text" name="celular" maxlength="10" style='-wap-input-format: "10N"'/>
                            <input type="hidden" name="carrier" value="MELATE"/>
                            <br/><br/>
                            <input type="submit" value="Enviar"/>
                        </div>
                    </form>
                <?php
                }
                ?>
            <hr/>
            <div align="center"><strong>SYREC &copy;<?php echo date('Y') ?></strong></div>
        </div>
    </body>
</html>
<?php
}
else {
    header("LOCATION:index.php");
}
?>
