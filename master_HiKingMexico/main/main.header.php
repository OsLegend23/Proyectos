<?php

/*
  /main/main.header.php
 */
if (!isset($COMMON)) {
    echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";
    die();
}

include($COMMON->getMySQL());
include($COMMON->getQuery());
include($COMMON->getGenForm());


$lastYear = Date('Y') - 1;
$lastDate = $lastYear . '-12-31';

$db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
$QUERY = new Query($db, $GLOBAL);

$rGetVacancy = $QUERY->searchVacancy("WHERE a.ch_status = '" . $GLOBAL['vacancy_enable']['value'] . "' AND k.nm_status = '" . $GLOBAL['user_enable']['value'] . "' AND a.dt_update > '" . $lastDate . "' GROUP BY a.id ORDER BY a.dt_update DESC, a.tx_hour DESC limit 0,10");

$rVacancyByArea = $QUERY->getVacancyByArea("WHERE a.ch_status = '" . $GLOBAL['vacancy_enable']['value'] . "' AND c.nm_status = '" . $GLOBAL['user_enable']['value'] . "' AND a.dt_update > '" . $lastDate . "' ");

$rCompanyEnabled = $QUERY->getCompany("WHERE b.nm_status = '" . $GLOBAL['user_enable']['value'] . "'");

$rLocationList = $QUERY->getLocation("ORDER BY a.tx_city ASC");

$rGetPublicity = $QUERY->getPublicity("WHERE a.ch_status = '" . $GLOBAL['status_enable']['value'] . "' ORDER BY a.nm_order ASC");

$gForm = new gForm();
$gForm->setNameForm('formID');
$gForm->setRoot($COMMON->getRoot());
$gForm->setMethodForm('post');
$gForm->setActionForm('#');
$gForm->setStatus('New');
$gForm->setLegend($STR['OportunityToMail']);

$gForm->setButton(array(ID => 'btnMailingList', LABEL => $STR['Send'], POSX => 'right', TYPE => 'SUBMIT'));
$gForm->setField('TEXTFIELD', 'name', $STR['YourName'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max50']));
$gForm->setField('TEXTFIELD', 'email', $STR['User'], array(), array('MCLASS' => $GLOBAL['vld_tx_email']));
$gForm->setField('CAPTCHA', 'Chars', $STR['ValidateChars'], array(), array('MCLASS' => $GLOBAL['vld_ch_req_max3'], 'HELP' => $STR['TypeCharsComment'], 'MSTYLE' => "width:170px;"));
?>

