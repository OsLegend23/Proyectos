<?php
/* /main/index.php */
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
            <form id='formCompany' name='formCompany'
                  enctype='application/x-www-form-urlencoded'
                  action='#'
                  method="post">
                <fieldset style="margin-bottom: 30px;">
                    <legend id='legend_" . $this->getNameForm() . "'><h5>Registro de empresa</h5></legend>

                    <div class="row element-name">
                        <div class="input-field col s12 m6 l6">
                            <input id="nombre" type="text" size="15" name="first" required />
                            <label class="subtitle" for="nombre">Nombre(s)*</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <input id="last" type="text" size="15" name="last" required />
                            <label class="subtitle" for="last">Apellido(s)*</label>
                        </div>
                    </div>

                    <div class="row element-email">
                        <div class="input-field col s12 m6 l6">
                            <label class="title" for="email">Correo Electrónico:<span class="required">*</span></label>
                            <input id="email" class="large validate" type="email" name="email" value="" required />
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <label class="title" for="cemail">Confirmar Correo Electrónico:<span class="required">*</span></label>
                            <input id="cemail" class="large validate" type="email" name="cemail" value="" required equalTo="#email" />
                        </div>
                    </div>

                    <div class="row element-password">
                        <div class="input-field col s12 m6 l6">
                            <label class="title" for="password">Contraseña:<span class="required">*</span></label>
                            <input id="password" class="large" type="password" name="password" value="" required/>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <label class="title" for="password1">Confirmar Contraseña:<span class="required">*</span></label>
                            <input id="password1" class="large" type="password" name="cpassword" value="" equalTo="#password" required />
                        </div>
                    </div>

                    <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>
                    <h5 class="section-break-title">Información de la Empresa</h5>

                    <div class="row element-name">
                        <div class="input-field col s12 m6 l6">
                            <label class="title" for="razonSocial">Razón Social:<span class="required">*</span></label>
                            <input id="razonSocial" class="large" type="text" name="razonSocial" required />
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <label class="title" for="nombreComercial">Nombre Comercial/Marca:<span class="required">*</span></label>
                            <input id="nombreComercial" class="large" type="text" name="marca" required />
                        </div>
                        <div class="row input-field col s12 m6 l6">
                            <label class="title" for="rfc">R.F.C.:<span class="required">*</span></label>
                            <input id="rfc" class="large" type="text" name="RFC" required />
                        </div>
                    </div>

                    <div class="row element-name">
                        <div class="input-field col s12 m6 l6">
                            <select id="Sector" class="browser-default" name="Sector" ></select>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <label class="title" for="giro">Giro o Actividad Principal:<span class="required">*</span></label>
                            <input id="giro" class="large" type="text" name="giro" required />
                        </div>
                        <div class="row input-field col s12 m6 l6">
                            <label class="title" for="rfc">Número de Empleados:<span class="required">*</span></label>
                            <input id="rfc" class="large" type="number" name="Employees" min="1" required />
                        </div>
                        <div class="row input-field col s12 m6 l6">
                            <label class="title" for="rfc">Sitio Web:<span class="required">*</span></label>
                            <input id="rfc" class="large" type="url" name="URLWeb" />
                        </div>
                    </div>

                    <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>
                    <h5 class="section-break-title">Correo Electronico para la Recepción de Currículos</h5>

                    <div class="row input-field col s12">
                        <label class="title" for="emailCV">Correo Electrónico de la Empresa:<span class="required">*</span></label>
                        <input id="emailCV" class="large" type="email" name="emailCV" value="" required />
                    </div>

                    <div class="row input-field col s12">
                        <label class="title" for="emailConf">Correo Electrónico Confidencial:
                            <img style="cursor: pointer; " id="help_mail" class="tooltipped" data-position="right" data-delay="50" data-tooltip="<?php echo $STR['MailTooltip']; ?>" src="../media/icon/help.png">
                        </label>
                        <input id="emailConf" class="large" type="email" name="emailConf" />
                    </div>

                    <div class="row element-textarea col s12"
                         title="Una breve descripción sobre el giro y actividades de la empresa.">
                        <label class="title" for="trumbowyg">Acerca de la Empresa:<span class="required">*</span></label>
                        <textarea id="trumbowyg" class="small" name="CompanyAbout" required ></textarea>
                    </div>

                    <label class="title">Dirección:<span class="required">*</span></label>

                    <div class="row element-address">
                        <div class="input-field col s12 m6 l6">
                            <input id="calle" type="text" name="calle" required />
                            <label for="calle" class="subtitle">Calle</label>
                        </div>

                        <div class="input-field col s12 m6 l6">
                            <input id="numero" type="text" name="numero" required />
                            <label for="numero" class="subtitle">Número</label>
                        </div>

                        <div class="input-field col s12 m6 l6">
                            <input id="colonia" type="text" name="colonia" required />
                            <label for="colonia" class="subtitle">Colonia</label>
                        </div>

                        <div class="row input-field col s12 m6 l6">
                            <select id="State" class="browser-default" name="State">
                                <option value="" disabled selected>Seleccione un Estado:</option>
                            </select>
                        </div>

                        <div class="input-field col s12 m6 l6">
                            <input id="ciudad" type="text" name="ciudad" required />
                            <label for="ciudad" class="subtitle">Ciudad</label>
                        </div>

                        <div class="input-field col s12 m6 l6">
                            <input id="codigoPostal" type="text" maxlength="5" name="codigoPostal" required />
                            <label for="codigoPostal" class="subtitle">Código Postal</label>
                        </div>

                    </div>

                    <div class="row element-phone" title="(LADA)-###-####">
                        <div class="input-field col s12 m6 l6">
                            <label class="title" for="telefono">Teléfono Fijo:<span class="required">*</span></label>
                            <input id="telefono" class="large" type="tel" pattern="\d{3}\d{3}\d{4}" maxlength="10" name="phone"
                                    required />
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <label class="title" for="ext">Ext.</label>
                            <input id="ext" class="small" type="number" min="1" maxlength="5" name="phoneExt"/>
                        </div>
                    </div>

                    <span class="title">Beneficios y Prestaciones:<span class="required">*</span></span>
                    <div class="row element-checkbox">
                        <div class="column column4 col s3 m3 l3">
                            <?php
                            foreach($STR['BenefitsList'] as $id => $beneficio){
                                if($id < 5){
                            ?>
                                <input id="<?php echo 'Benefits_'.$id; ?>" type="checkbox" name="<?php echo 'Benefits_'.$id; ?>" value="<?php echo $id;?>" />
                                <label for="<?php echo 'Benefits_'.$id; ?>"><?php echo $beneficio;?></label>
                            <?php
                                }
                            }
                            ?>
                        </div>

                        <div class="column column4 col s3 m3 l3">
                            <?php
                            foreach($STR['BenefitsList'] as $id => $beneficio){
                                if($id >= 5 && $id < 10){
                                    ?>
                                    <input id="<?php echo 'Benefits_'.$id; ?>" type="checkbox" name="<?php echo 'Benefits_'.$id; ?>" value="<?php echo $id;?>" />
                                    <label for="<?php echo 'Benefits_'.$id; ?>"><?php echo $beneficio;?></label>
                                <?php
                                }
                            }
                            ?>
                        </div>

                        <div class="column column4 col s3 m3 l3">
                            <?php
                            foreach($STR['BenefitsList'] as $id => $beneficio){
                                if($id >= 10 && $id < 15){
                                    ?>
                                    <input id="<?php echo 'Benefits_'.$id; ?>" type="checkbox" name="<?php echo 'Benefits_'.$id; ?>" value="<?php echo $id;?>"/>
                                    <label for="<?php echo 'Benefits_'.$id; ?>"><?php echo $beneficio;?></label>
                                <?php
                                }
                            }
                            ?>
                        </div>

                        <div class="column column4 col s3 m3 l3">
                            <?php
                            foreach($STR['BenefitsList'] as $id => $beneficio){
                                if($id >= 15 && $id < 20){
                                    ?>
                                    <input id="<?php echo 'Benefits_'.$id; ?>" type="checkbox" name="<?php echo 'Benefits_'.$id; ?>" value="<?php echo $id;?>" />
                                    <label for="<?php echo 'Benefits_'.$id; ?>"><?php echo $beneficio;?></label>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div style="border-bottom: 1px dashed #ccc; color: #2f5e9e; margin: 5px 0px 5px 0px;"></div>
                    <div class="row element-file">
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

                    <div class="row element-checkbox col s12">
                        <label class="title">Términos y Condiciones.<span class="required">*</span></label>
                        <div id="termsAndConditions" class="terms-and-conditions">
                            <input id="AceptPolitics" type="checkbox" name="AceptPolitics"
                                   value="He leído y acepto los términos y condiciones." />
                            <label for="AceptPolitics">He leído y acepto los términos y condiciones.</label>
                        </div>
                    </div>

                    <div class="submit">
                        <button id="btnRegistry" class="btn-large waves-effect waves-light deep-purple darken-4" role="button" value="Registrarme">
                            <span>Registrarme</span>
                        </button>
                    </div>
                </fieldset>
            </form>

        </div>
    </div>

</div> <!-- end of main -->

<div id="successModal" class="modal" style="display: none;">
    <div class="modal-content">
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Hecho</a>
    </div>
</div>