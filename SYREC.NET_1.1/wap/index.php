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
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
    header("LOCATION:wap-login.php");
}
?>
