<?php
/*
  /main/index.php
 */
if (!isset($COMMON)) {
    echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";
    die();
}
?>
<br/>
<br/>

<div id="templatemo_main">
    <div id="templatemo_main" class="container section no-pad-bot" style="margin-top: -25px;">
        <div class="row">
            <div class="card col l12 s12 white">
                <?php //$gForm->show(); ?>
                <form action="#" enctype="application/x-www-form-urlencoded" method="post" class="" name="formID"
                      id="frmLogin">
                    <fieldset>
                        <legend id="legend_formID"><h5>Inicia sesión</h5></legend>

                        <div id="formrow_Email" class="row">
                            <div class="input-field col s12">
                                <label class="" id="lbl_Email" for="Email">
                                    Correo electrónico
                                </label>
                                <input type="email" data-prompt-position="topRight:-100" class="Email text-input"
                                       name="Email" id="Email" required>
                            </div>
                        </div>

                        <div id="formrow_Pass" class="row">
                            <div class="input-field col s12">
                                <label class="lbl-Pass" id="lbl_Pass" for="Pass">Contraseña</label>
                                <input type="password" data-prompt-position="topRight:-100" name="Pass" id="Pass" required>
                            </div>
                        </div>

                        <div class="row element-captcha">
                            <div class="input-field col s12 m6 l6">
                                <label for="Chars">
                                    Caracteres de validación
                                    <img style="cursor: pointer; " id="helpbtn_Chars" class="tooltipped" data-position="right" data-delay="50" data-tooltip="<?php echo $STR['TypeCharsComment']; ?>" src="../media/icon/help.png">
                                </label>
                                <input id="Chars" name="Chars" type="text" maxlength="3" title="">
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <?php
                                $input = array('ID'=>'Chars');
                                $gForm->getCaptcha($input);
                                ?>
                            </div>
                        </div>
                        <div class="row element-forgget" id="formrow_">
                            <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>
                            <div id="formrow_"><label class="commentLbl ui-widget ui-corner-all " id="lbl_"><a
                                        href="../forgotpassword/">¿Has olvidado tu contraseña?</a></label></div>
                        </div>
                    </fieldset>

                    <fieldset class="formActionButtons">
                        <div style="display:inline-block" class="formButtons row">
                            <button id="btnAutenticate"
                                    class="btn-large waves-effect waves-light deep-purple darken-4 formButton">Iniciar
                                sesión
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>


</div> <!-- end of main -->

<div id="validation_dialog" style="display: none;">
    <div id="validation_answer" style="height:180px;" class="ui-widget-content  ui-corner-all"></div>
    <div class="ui-corner-all" style="text-align:right; padding: 5px;">
        <button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnCloseDialog"
                style='display: inline-block; cursor: pointer; width:180px; height:45px; text-align:center;'><?php echo $STR['closeWindow']; ?></button>
    </div>
</div>