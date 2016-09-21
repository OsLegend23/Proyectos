<?php
/*
  /main/index.php
 */
if (!isset($COMMON)) {
    echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";
    die();
}
?>

<div class="section no-pad-bot" id="index-banner">

    <div class="container">

        <br><br>

        <div class="row">
            <div id="searchJob" class="col s12 m12 l12 white">

                <div class="input-field col s12 m12 l6" style="margin-top: 25px">
                    <input type="text" class="searchinput" id='key'>
                    <label for=""><?php echo $STR['SearchJob']; ?></label>
                </div>

                <div class="col s12 m12 l4" style="margin-top: 15px">
                    <select id="location">
                        <option value="0" disabled selected>Seleccione Ciudad</option>
                        <?php
                        while ($row = $rLocationList->fetch()) {
                            echo "<option value=" . $row['id'] . ">" . $row['tx_city'] . ', ' . $row['tx_state'] . "</option>";
                        }
                        echo "<option value='11'>" . $STR['AllLocation'] . "</option>";
                        ?>
                    </select>
                </div>

                <div class="col s12 m12 l2" style="margin-top: 20px">
                    <button id="btnSearch" class="btn-large waves-effect waves-light deep-purple darken-4"
                            role="button">
                        <i class="mdi-action-pageview prefix"></i>
                        <span><?php echo $STR['Search']; ?></span>
                    </button>
                </div>

            </div>
        </div>

    </div>

</div>

<div id="templatemo_main" class="container" style="width: 100%">
    <div class="section">
        <div class="row">
            <div id="l-column" class="col s12 m12 l3">

                <div id="vacancyByArea" class="card">
                    <div class="card-content">
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th data-field="vacante" colspan="2">
                                        <i class="mdi-action-wallet-travel prefix"></i>
                                        <?php echo $STR['VacancyByArea']; ?>
                                    </th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="2"><a href="<?php echo $COMMON->getRoot() . 'search/'; ?>"
                                                       class="more float_r"><?php echo $STR['ConsultAllVacancies'] ?></a>
                                    </th>
                                </tr>
                            </tfoot>

                            <tbody>
                                <?php
                                while ($row = $rVacancyByArea->fetch()) {
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo $COMMON->getRoot() . 'search/?consult=advancedquery&area=' . $row['id']; ?>"
                                               class="more float_l"><?php echo $row['workarea_tx_description']; ?></a>
                                        </td>
                                        <td><?php echo $row['total']; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="practiceProfessional" class="card small">
                    <div class="card-image slider">
                        <ul class="responsive-img">
                            <li>
                                <img src="media/image/practices/3.jpg">
                            </li>
                        </ul>
                    </div>
                    <div class="card-content">
                        <p><?php echo $STR['SearchProfessionalPractices']; ?></p>
                    </div>
                    <div class="card-action">
                        <a href="<?php echo $COMMON->getRoot() . 'search/?consult=practices'; ?>"
                           class="more float_r"><?php echo $STR['ConsultAllPreactices'] ?></a>
                    </div>
                </div>

            </div>
            <div id="c-column" class="col s12 m12 l6">
                <h5><?php echo $STR['RecentVacancy']; ?></h5>

                <?php
                while ($row = $rGetVacancy->fetch()) {
                    $idVacancy = $row['id'];
                    $tx_name = $row['tx_name'];
                    $dt_update = $row['dt_update'];
                    $worksector_tx_description = $row['worksector_tx_description'];
                    $workactivity_tx_description = $row['workactivity_tx_description'];
                    $tx_workdetail = $row['tx_workdetail'];
                    $worksubarea_tx_description = $row['worksubarea_tx_description'];
                    $vacancy_type_tx_description = $row['vacancy_type_tx_description'];
                    $tx_city = $row['tx_city'];
                    $id_company = $row['id_company'];
                    $tx_image = $row['tx_image'];

                    $tx_tradename = $row['ch_confidential'] == $GLOBAL['confidential_YES'] ? $row['tx_confidential_trademark'] : $row['tx_trademark'];

                    $tx_state = $row['tx_state'];
                    $tx_country = $row['tx_country'];
                    $localitacion = $tx_city;

                    $dt_update = date("j-n-Y", strtotime($dt_update));
                    $dt_update = explode('-', $dt_update);

                    $dt_update_day = $dt_update[0];
                    $dt_update_month = $month[$dt_update[1]];
                    $dt_update_year = $dt_update[2];

                    if ($row['ch_confidential'] == $GLOBAL['confidential_YES']) {
                        $fileImage = $COMMON->findPhoto("confidential_30p", $GLOBAL['linkPhotoCompany'] . "confidential" . '/');
                    } else {
                        $fileImage = $COMMON->findPhoto($tx_image . '_30p', $GLOBAL['linkPhotoCompany'] . $id_company . '/');

                        if (!$fileImage)
                            $fileImage = $COMMON->findPhoto('default_30p', $GLOBAL['companyDefaultImage']);
                    }
                    ?>
                    <a href="<?php echo $COMMON->getRoot() . "vacancy/?vcn=$idVacancy"; ?>">
                        <div class="card-panel">
                            <div class="infoPanel row valign-wrapper">
                                <figure class="logo col s3">
                                    <img src="<?php echo $fileImage; ?>" alt="<?php echo $tx_tradename; ?>"
                                         class="responsive-img">
                                </figure>
                                <div class="info col s10">
                                    <h4 class="titleJob"><?php echo $tx_name; ?></h4>

                                    <p class="company">
                                        <span class="companyName"><?php echo $tx_tradename; ?></span>
                                        <span class="location mdi-communication-location-on">
                                            <span
                                                style="font-family: 'Roboto',sans-serif;"><?php echo $localitacion; ?></span>
                                        </span>
                                    </p>

                                    <p class="vacancyType">
                                        <span><b>Tipo de Vacante:</b> <?php echo $vacancy_type_tx_description; ?></span>
                                        <span class="location"><b>Publicación:</b> <?php echo $dt_update_day; ?>
                                            /<?php echo $dt_update_month; ?>/<?php echo $dt_update_year; ?> </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                }
                ?>

            </div>
            <div id='r-column' class="col s12 m12 l3">

                <div id="postulante" class="card">
                    <div class="card-content">
                        <h4>
                            <a href="<?php echo $COMMON->getRoot() . 'postulantregister' ?>"><?php echo $STR['RegisterAsCandidate']; ?></a>
                        </h4>

                        <p style="text-align:justify;"><?php echo $STR['ClickToCreateCompany']; ?></p>
                    </div>
                    <div class="card-action">
                        <a href="<?php echo $COMMON->getRoot() . 'postulantregister' ?>"><?php echo $STR['ClickHere']; ?></a>
                    </div>
                </div>

                <div id="card_company" class="card">
                    <div class="card-content">
                        <h4>
                            <a href="<?php echo $COMMON->getRoot() . 'companyregister'; ?>"><?php echo $STR['RegisterAsCompany']; ?></a>
                        </h4>

                        <p style="text-align:justify;"><?php echo $STR['ClickToCreateCompany']; ?></p>
                    </div>
                    <div class="card-action">
                        <a class="more float_r"
                           href="<?php echo $COMMON->getRoot() . 'companyregister'; ?>"><?php echo $STR['ClickHere']; ?></a>
                    </div>
                </div>

                <div id="link_mail" class="card">
                    <div class="card-content">
                        <h4><a id="receiveVacancyMail" href="#dialog_mailinglist"
                               class="modal-trigger"><?php echo $STR['ReceiveVacancyMail']; ?></a></h4>

                        <p style="text-align:justify;"><?php echo $STR['ReceiveVacancyMail_lbl']; ?></p>
                    </div>
                    <div class="card-action">
                        <a href="#dialog_mailinglist" id="receiveVacancyMail"
                           class="modal-trigger"><?php echo $STR['ClickHere']; ?></a>
                    </div>
                </div>

                <div id="sponsor" class="card">
                    <div class="card-image">
                        <ul class="responsive-img">
                            <li>
                                <img src="media/image/slideshow/c6febd3a94d74505608bd95ab77679c5.jpg">
                            </li>
                        </ul>
                    </div>
                </div>

                <div id="sponsor1" class="card">
                    <div class="card-image">
                        <ul class="responsive-img">
                            <li>
                                <img src="media/image/sponsor/logo_coca_cola_seo.png">
                            </li>
                        </ul>
                    </div>
                </div>

                <div id="sponsor2" class="card">
                    <div class="card-image">
                        <ul class="responsive-img">
                            <li>
                                <img src="media/image/sponsor/nike.jpg">
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div> <!-- end of main -->

<div id="dialog_mailinglist" class="modal modal-fixed-footer" style="max-height: 100%;">
    <div class="modal-footer">
        <i class="modal-action modal-close small mdi-navigation-cancel" style="cursor: pointer;"></i>
    </div>
    <div class="modal-content">
        <div class="card" id="modalOverlay">
            <?php
            $gForm->show();
            ?>
        </div>
    </div>
</div>