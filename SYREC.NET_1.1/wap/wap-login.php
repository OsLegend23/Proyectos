<?php
include ("scripts/php/browser_class_inc.php");
$browser = new Browser;
$browser->browser();

if (($browser->isFirefox()) OR ($browser->isMSIE()) OR ($browser->isFirebird()) OR ($browser->isOmniWeb())
        OR ($browser->isNetscape()) OR ($browser->isOpera()) OR ($browser->isMozStable()) OR ($browser->isNetPositive())
        OR ($browser->isAOL()) OR ($browser->isPhoenix()) OR ($browser->isMSPIE()) OR ($browser->isIcab())
        OR ($browser->isMozAlphaBeta()) OR ($browser->isSafari()) OR ($browser->isLynx()) OR ($browser->isKonqueror())
        OR ($browser->isIEv1()) OR ($browser->isGaleon()) OR ($browser->isWebTV())) {
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
            <link rel="shortcut icon" href="http://www.syrec.net/images/favicon.ico" />
            <title>SYREC.NET</title>
        </head>
        <body>
            <div align="center">
                <img src="http://www.syrec.net/images/logo_syrec.png" alt="www.syrec.com.mx"/>
                <p style="font-family:Verdana, Geneva, Arial, Helvetica, sans-serif; font-size:14px; font-style:oblique; font-weight:bold;">Este Portal Wap solo se puede visualizar desde un dispositivo móvil. </p>
            </div>
        </body>
    </html>
<?php
} else {
?>
<?php header('Content-type: application/vnd.wap.xhtml+xml; charset=utf-8'); ?>
<?php echo '<?xml version="1.0" encoding="utf-8" ?>'; ?>
    <!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title>WAP-SYREC</title>
            <style type="text/css">
                body{
                    margin: 0px;
                    padding:6px 0px 0px 0px;
                    font-family:Verdana, Arial, Helvetica, sans-serif;
                    font-size:60%;
                    background-color: #c0c0c0;;
                    text-align:center;
                }
                strong{
                    text-align:center;
                }
            </style>
        </head>
        <body>
            <div align="center">
                <div align="center">
                    <strong>SYREC :: Portal WAP</strong>
                </div>
                <hr/>
                <form action="scripts/php/verifica.php" method="post">
                    <table width="100%" summary="Clave de Usuario">
                        <tbody>
                            <tr align="center">
                                <td>
                                    <label>Usuario:</label>
                                </td>
                            </tr>
                            <tr align="center">
                                <td>
                                    <input type="text" name="usr" maxlength="10" />
                                </td>
                            </tr>
                            <tr align="center">
                                <td>
                                    <label>Clave de Usuario:</label>
                                </td>
                            </tr>
                            <tr align="center">
                                <td>
                                    <input type="password" name="password" maxlength="10" />
                                </td>
                            </tr>
                            <tr align="center">
                                <td>
                                    <input type="submit" name="enviar" value="Enviar" />
                                    <input name="action" type="hidden" value="checkdata" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <hr/>
                <div align="center">
                    <strong>SYREC &copy;<?php echo date('Y') ?></strong>
                </div>
            </div>
        </body>
    </html>
<?php
}
?>