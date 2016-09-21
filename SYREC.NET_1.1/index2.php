<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Rafael Alejandro Aguilar Medina" />
        <link rel="shortcut icon" href="images/favicon.ico" />
        <title>.::SYREC-ADMIN::.</title>
        <script src="scripts/js/form.js?v2.0.1205" type="text/javascript"></script>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div align="center" style="width:100%;">
            <table width="600" cellpadding="2" cellspacing="0" class="tbmain">
                <tr>
                    <td class="topleft" width="10" height="10">&nbsp;</td>
                    <td class="topmid"  align="center"><img src="images/logo_syrec.png" /></td>
                    <td class="topright" width="10" height="10">&nbsp;</td>
                </tr>
                <tr>
                    <td class="midleft" width="10">&nbsp;&nbsp;&nbsp;</td>
                    <td class="midmid" valign="top">
                        <form accept-charset="utf-8" action="https://www.syrec.net/scripts/php/verifica.php" method="post" name="q_form_10960813426">
                            <input type="hidden" name="formID" value="10960813426" />
                            <div id="main">
                                <div class="pagebreak">
                                    <table width="300" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td width="150" class="left">
                                                <label>
                                                    Usuario: <span class="required">*</span>
                                                </label>
                                            </td>
                                            <td class="right">
                                                <input type="text" size="30" name="usuario" class="text" value="" id="q6" onblur="validate(this,'Email')" autocomplete="off" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="150" class="left">
                                                <label>
                                                    Contraseña: <span class="required">*</span>
                                                </label>
                                            </td>
                                            <td class="right">
                                                <input type="password" size="30" name="password" class="text" value="" id="q8" onblur="validate(this,'Required')" autocomplete="off" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="150" class="left">
                                                <label>Ingresar el texto mostrado en la imagen: *</label>
                                            </td>
											<td class="right">
                                                <input type="text" size="30" name="captcha" class="text" value="" id="q9" onblur="validate(this,'Required')" autocomplete="off" />
                                            </td>
                                        </tr>
                                        <tr >
                                            <td valign="top" align="center" colspan = "2">
												<div align="center" style="margin-left:50px;">
													<img id="captcha" src="scripts/php/captcha/captcha/captcha.php" /><br/>
												</div>
												<div align="center">
													<a href="#" onclick="document.getElementById('captcha').src='scripts/php/captcha/captcha/captcha.php?'+Math.random();" id="change-image">Recargar Captcha.</a>
												</div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="right" colspan="2">
                                                <input type="submit" class="btn" value="Ingresar" />
                                                <input name="action" type="hidden" value="checkdata" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </td>
                    <td class="midright" width="10">&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td class="bottomleft" width="10" height="10"></td>
                    <td class="bottommid" style="text-align:center;font-family:Arial, Helvetica, sans-serif;">
						<div style="font-size:10px;"><strong style="color:#F00;">Por seguridad, el sistema bloquea la cuenta de acceso al sobrepasar 3 intentos.</strong></div><br />
						Visita nuetra p&aacute;gina Comercial <a href="http://www.syrec.com.mx">syrec.com.mx</a><br />
						<strong>.::SYREC &copy;<?php echo date('Y');?>::.</strong>
					</td>
                    <td class="bottomright" width="10" height="10">&nbsp;</td>
                </tr>
            </table>
            <script type="text/javascript">
                validate("q_form_10960813426");
            </script>
        </div>
    </body>
</html>
