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

<div id="templatemo_main" class="container section no-pad-bot">
    <div class="row">
        <div class="card col l12 s12 white">
            <?php //$gForm->show(); ?>
            <form action="#" enctype="application/x-www-form-urlencoded" method="post" class="registroPostulante"
                  name="formID" id="registroPostulante">
                <fieldset style="margin-bottom: 30px;">
                    <legend id="legend_formID">
                        <h5>Registro de postulante</h5>
                    </legend>
                    <div id="ingresoCuenta">
                        <dl>
                            <label class="commentLbl">
                                Información para ingresar a tu cuenta
                            </label>
                        </dl>
                        <dd></dd>
                    </div>

                    <div class="row element-name">
                        <div class="input-field col s12 m6 l6">
                            <input id="Email" type="email" name="Email" required/>
                            <label id="lbl_Email" class="lbl_Email" for="Email">Correo Electrónico*</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input id="Confemail" type="email" name="Confemail" required/>
                            <label class="lbl_Confemail" for="Confemail">Confirmación Correo Electrónico*</label>
                        </div>
                    </div>

                    <div class="row element-password">
                        <div class="input-field col s12 m6 l6">
                            <label id="lbl_Pass" class="lbl_Pass" for="Pass">Contraseña:<span class="required">*</span></label>
                            <input id="Pass" class="Pass" maxlength="15" type="password" name="Pass" required/>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <label id="lbl_ConfPass" class="lbl_ConfPass" for="ConfPass">Confirmar Contraseña:<span
                                    class="required">*</span></label>
                            <input id="ConfPass" class="ConfPass" type="password" name="ConfPass" equalTo="#Pass"
                                   maxlength="15" required/>
                        </div>
                    </div>

                    <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>
                    <div id="informacionPersonal">
                        <dl><label class="commentLbl">Información personal</label></dl>
                        <dd></dd>
                    </div>

                    <div class="row element-name">
                        <div class="input-field col s12 m6 l6">
                            <input id="Name" class="Name" type="text" name="Name" required/>
                            <label class="lbl_Name" for="Name">Nombre(s)*</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input id="Surname" class="Surname" type="text" name="Surname" required/>
                            <label class="lbl_Surname" for="Surname">Apellido(s)*</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input id="RFC" class="RFC" type="text" value="" name="RFC" required>
                            <label id="lbl_RFC" for="RFC">R.F.C</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input type="date" name="BornDate" id="BornDate" required>
                            <label class="" id="lbl_BornDate" for="BornDate">Fecha Nacimiento</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <dl><label class="" id="lbl_Gender" for="Gender">Género</label></dl>
                            <br/>

                            <input type="radio" value="F" name="Gender" id="GenderF">
                            <label for="GenderF" class="radiolabel">Femenino</label>

                            <input type="radio" value="M" name="Gender" id="GenderM">
                            <label for="GenderM" class="radiolabel">Masculino</label>
                        </div>
                    </div>

                    <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>
                    <div id="Ubicacion">
                        <dl><label class="commentLbl" id="commentLbl">Ubicación</label></dl>
                    </div>

                    <div class="row element-address">
                        <div class="input-field col s12 m6 l6">
                            <input id="calle" type="text" name="calle" required/>
                            <label for="calle" class="subtitle">Calle</label>
                        </div>

                        <div class="input-field col s12 m6 l6">
                            <input id="numero" type="text" name="numero" required/>
                            <label for="numero" class="subtitle">Número</label>
                        </div>

                        <div class="input-field col s12 m6 l6">
                            <input id="colonia" type="text" name="colonia" required/>
                            <label for="colonia" class="subtitle">Colonia</label>
                        </div>

                        <div class="row input-field col s12 m6 l6">
                            <select id="State" class="browser-default" name="State">
                                <option value="" disabled selected>Seleccione un Estado:</option>
                            </select>
                        </div>

                        <div class="input-field col s12 m6 l6">
                            <input id="ciudad" type="text" name="ciudad" required/>
                            <label for="ciudad" class="subtitle">Ciudad</label>
                        </div>

                        <div class="input-field col s12 m6 l6">
                            <input id="codigoPostal" type="text" maxlength="5" name="codigoPostal" required/>
                            <label for="codigoPostal" class="subtitle">Código Postal</label>
                        </div>
                    </div>

                    <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>
                    <div id="estudiosAcademicos">
                        <dl><label class="commentLbl" id="commentLbl">Estudios Académicos</label>
                        </dl>
                        <dd></dd>
                    </div>

                    <div class="row element-academy">
                        <div class="col s12 m6 l6">
                            <select class="StudyLevel browser-default" name="StudyLevel" id="StudyLevel">
                                <option value="1" selected>Formación para el trabajo</option>
                                <option value="2">Bachillerato</option>
                                <option value="3">Universidad</option>
                            </select>
                            <label class="" id="lbl_StudyLevel" for="StudyLevel">Nivel de estudio</label>
                        </div>
                        <div class="col s12 m6 l6">
                            <select class="StudyLevel browser-default" name="StudyArea" id="StudyArea">
                                <option value="1" selected>Formación para el trabajo</option>
                                <option value="2">Bachillerato</option>
                                <option value="3">Universidad</option>
                            </select>
                            <label class="" id="lbl_StudyArea" for="StudyArea">Área de Estudio</label>
                        </div>

                        <div class="input-field col s12 m6 l6">
                            <input type="text" class="InstituteName" value="" name="InstituteName" id="InstituteName">
                            <label class="" id="lbl_InstituteName" for="InstituteName">
                                Nombre de Institución
                            </label>
                        </div>
                    </div>

                    <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>
                    <div id="ExpLab">
                        <dl><label class="commentLbl" id="commentLbl">Experiencia laboral</label></dl>
                    </div>

                    <div class="row element-primerTrabajo">
                        <div id="formrow_FirstJob" class="col s12 m12 l12">
                            <span class="" id="lbl_FirstJob" for="FirstJob">¿Estas buscando tu primer empleo?</span>

                            <input type="radio" class="radio" value="S" name="FirstJob" id="FirstJobS">
                            <label for="FirstJobS" class="radiolabel">Si</label>

                            <input type="radio" checked="true" class="radio" value="N" name="FirstJob"
                                   id="FirstJobN">
                            <label for="FirstJobN" class="radiolabel">No</label>
                        </div>
                    </div>

                    <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>

                    <div class="row element-expLaboral">
                        <div id="infoEmpleo">
                            <dl><label class="commentLbl" id="commentLbl">Ingresa la información de tu empleo mas
                                    actual</label></dl>
                        </div>

                        <div id="formrow_WorkArea" class="col s12 m6 l6">
                            <select id="WorkArea" class="browser-default" name="WorkArea">
                            </select>
                            <label class="lbl_WorkArea" id="lbl_WorkArea" for="WorkArea">Área o departamento</label>
                        </div>

                        <div id="formrow_JobTitle" class="row input-field col s12 m6 l6">
                            <input type="text" class="text-input" name="JobTitle" id="JobTitle" required>
                            <label class="lbl_JobTitle" id="lbl_JobTitle" for="JobTitle">Nombre del puesto</label>
                        </div>

                        <div id="formrow_DateInstrYear" class="col s12 m6 l6">
                            <select id="DateInstrYear" name="DateInstrYear" class="browser-default">
                                <?php
                                foreach ($aYear as $Year => $Y) {
                                    ?>
                                    <option value="<?php echo $Year; ?>"><?php echo $Y; ?></option>
                                <?php } ?>
                            </select>
                            <label class="lbl_DateInstrYear" id="lbl_DateInstrYear" for="DateInstrYear">
                                Año de inicio
                            </label>
                        </div>

                        <div id="formrow_DateOutstrYear" class="col s12 m6 l6">
                            <select class="browser-default" name="DateOutstrYear" id="DateOutstrYear">
                                <?php
                                foreach ($aYear as $Year => $Y) {
                                    ?>
                                    <option value="<?php echo $Year; ?>"><?php echo $Y; ?></option>
                                <?php } ?>
                            </select>
                            <label class="" id="lbl_DateOutstrYear" for="DateOutstrYear">Año de término</label>
                        </div>
                    </div>

                    <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>

                    <div class="row element-file">
                        <div class="input-field col s12 m6 l6">
                            <label for="Chars">
                                Caracteres de validación
                                <img style="cursor: pointer; " id="helpbtn_Chars" class="tooltipped"
                                     data-position="right" data-delay="50"
                                     data-tooltip="<?php echo $STR['TypeCharsComment']; ?>"
                                     src="../media/icon/help.png">
                            </label>
                            <input id="Chars" name="Chars" type="text" maxlength="3" title="">
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <?php
                            $input = array('ID' => 'Chars');
                            $gForm->getCaptcha($input);
                            ?>
                        </div>
                    </div>

                    <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>

                    <div id="formrow_AceptPolitics" class="row element-checkbox col s12">
                        <dl><label class="title">Términos y Condiciones.<span class="required">*</span></label></dl>
                        <div id="termsAndConditions" class="terms-and-conditions">
                            <input id="AceptPolitics" type="checkbox" name="AceptPolitics"
                                   value="He leído y acepto los términos y condiciones."/>
                            <label id="lbl_AceptPolitics" for="AceptPolitics" style="color: black;" >He leído y acepto los términos y condiciones.</label>
                        </div>
                    </div>

                    <div class="submit">
                        <button id="btnPostulate" class="btn-large waves-effect waves-light deep-purple darken-4" role="button" value="Registrarme">
                            <span>Regístrarme</span>
                        </button>
                    </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>

<div id="registrySuccess_dialog" style="display: none; width:710px;" class="">
    <div class="main_iframe ui-widget-content  ui-corner-all">

    </div>

</div>

<div id="successModal" class="modal" style="display: none;">
    <div class="modal-content">
        <button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnGoToAdmin"
                style='display: inline-block; cursor: pointer; width:250px; height:45px; text-align:center;'>
            <?php echo $STR['GoToAdmin']; ?>
        </button>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Hecho</a>
    </div>
</div>