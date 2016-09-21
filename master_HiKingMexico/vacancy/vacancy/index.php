<?php
/*
/main/index.php
*/
if (!isset($COMMON)) {
    echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";
    die();
}

?>
<br/><br>

<section class="container section no-pad-bot" id="main-inner-container">
    <article id="panel-work" class="post page card-panel z-depth-1 article-container">
        <fieldset style="margin-top: 25px;">
            <header id="logoEmpresa">
                <div class="row">
                    <?php
                    if ($rData['ch_confidential'] == $GLOBAL['confidential_YES']) {
                        $fileImage = $COMMON->findPhoto("confidential", $GLOBAL['linkPhotoCompany'] . "confidential" . '/');
                    } else {
                        $fileImage = $COMMON->findPhoto($rData['tx_image'], $GLOBAL['linkPhotoCompany'] . $rData['id_company'] . '/');

                        if (!$fileImage)
                            $fileImage = $COMMON->findPhoto("default", $GLOBAL['companyDefaultImage']);
                    }

                    if (isset($fileImage))
                        echo '<img src="' . $fileImage . '" width="40%">';
                    ?>
                    <h4 class="v-field" id="vf_Company"><?php echo $STR['Company']; ?></h4>

                    <div class="v-header boxshadowLow" id="vf_About_lbl"
                         style="width:99%"><?php echo $STR['CompanyAbout']; ?></div>
                    <ul class="vacancy_about_iframe">
                        <div class="v-field" id="vf_About" style="text-align: justify;">
                        </div>
                    </ul>

                    <span class="medium mdi-communication-location-on"></span>
                    <span class="v-field" id="vf_Location"> <?php echo $STR['Location']; ?></span><br/>
                    <span class="v-header" style="font-weight: bolder;"><?php echo $STR['ReferenceCode']; ?>:</span>
                    <span class="v-field" id="vf_ReferenceCode"> <?php echo $STR['ReferenceCode']; ?></span>
                </div>
            </header>
        </fieldset>
        <section class="post-content">
            <fieldset style="margin-top: 15px;">
                <?php
                if (!isset($_REQUEST['print']))
                    include('vacancy.template.php');
                else
                    include('vacancy.print.template.php');

                ?>
            </fieldset>
        </section>
        <footer>
            <section style="text-align: center;">
                <fieldset style="margin-top: 15px; margin-bottom: 25px;">
                    <?php
                    //print
                    if (!isset($_REQUEST['print'])) {
                        ?>
                        <div class="row" id="box-vacancy">
                            <ul style="display: inline-flex; margin: -10px 0 -70px 0;">
                                <li class="actions-vacancy">
                                    <a id="apply" href="#dialog_apply" class="modal-trigger shortcut_vcn">
                                        <img src="<?php echo $COMMON->getMedia('icon', '_next.png'); ?>">

                                        <div class="row">
                                            <span><?php echo $STR['Apply']; ?></span>
                                        </div>
                                    </a>
                                </li>
                                <li class="actions-vacancy">
                                    <a id="share" href="#dialog_share" class="modal-trigger shortcut_vcn">
                                        <img src="<?php echo $COMMON->getMedia('icon', '_sendMail.png'); ?>">

                                        <div class="row">
                                            <span><?php echo $STR['Share']; ?></span>
                                        </div>
                                    </a>
                                </li>
                                <li class="actions-vacancy">
                                    <a id="print" href="#" class="shortcut_vcn">
                                        <img src="<?php echo $COMMON->getMedia('icon', '_print.png'); ?>">

                                        <div class="row">
                                            <span><?php echo $STR['Print']; ?></span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                </fieldset>
            </section>
        </footer>
    </article>
</section>

<div id="templatemo_main" class="container section no-pad-bot">
    <div class="row">
    </div>
</div> <!-- end of main -->


<div id="dialog_apply" class="modal modal-fixed-footer" style="width:75%;">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 m12 l6 card">
                <h5><?php echo $STR['toApply']; ?></h5>
                <?php
                $gForm->show();
                ?>
            </div>
            <div class="col s12 m12 l6">
                <h3 style="font-size: 1.92rem;"><?php echo $STR['wanttocreateaccount']; ?></h3>
                <button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnCreateAccount"><?php echo $STR['CreateAccount']; ?></button>
                <div style="display: inline-block; font-size: 12px;">
                    <h5>Beneficios al registrarte como postulante</h5>
                    <ul>
                        <li>Administrar tu cuenta, agregando y actualizando tus datos personales, estudios academicos,
                            experiencia laboral, conocimiento en informática, otros conocimientos, idiomas, expectativas
                            laborales
                        </li>
                        <li>Podrás publicar tu currículum en formato PDF.</li>
                        <li>Podrás postularte en las vacantes disponibles.</li>
                        <li>Tu información será valorada continuamente por hikingmexico.com para identificar
                            oportunidades de trabajo afines a tu perfil.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog_applyAnswer" style="display: none;" width="900" height="490">
    <div class="ui-widget-content  ui-corner-all" style="height:150px;">
        <div style="width:17%;" class="float_l">
            <img src="<?php echo $COMMON->getMedia('image', 'bee.png'); ?>">
        </div>
        <div class="float_r" id="applyAnswer" style="width:78%; margin-left:5px; font-size: 11px;">

        </div>
    </div>
    <div class="ui-corner-all" style="text-align:right; padding: 5px;">
        <fieldset class='formActionButtons ui-widget ui-corner-all'>
            <div id='msessage_share' style='width:50%; float:left; display:inline-block;'></div>
            <button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnCloseDialog"
                    style='display: inline-block; cursor: pointer; width:150px; height:45px; text-align:center;'><?php echo $STR['closeWindow']; ?></button>
        </fieldset>
    </div>
</div>

<div id="dialog_share" class="modal modal-fixed-footer" style="display: none;">
    <div class="modal-content">
        <?php
        $gFormShare->show();
        ?>
    </div>
</div>

<div style="display:none;"><textarea id="about_vf"><?php echo $rData['tx_about']; ?></textarea></div>