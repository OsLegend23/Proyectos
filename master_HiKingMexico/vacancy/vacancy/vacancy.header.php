<?php
/*
/main/main.header.php
*/
if (!isset($COMMON)) {
    echo '<body onLoad=window.setTimeout(top.location.href="../index.php",0)></body>';
    die();
}

include($COMMON->getMySQL());
include($COMMON->getQuery());
include($COMMON->getGenForm());
$db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
$QUERY = new Query($db, $GLOBAL);


$gForm = new gForm();
$gForm->setNameForm('formID');
$gForm->setRoot($COMMON->getRoot());
$gForm->setMethodForm('post');
$gForm->setActionForm('#');
$gForm->setStatus('New');
$gForm->setLegend($STR['SignIn']);

$gForm->setButton(array('ID' => 'btnApply', 'ICON' => '', 'LABEL' => $STR['Apply'], 'POSX' => 'right', 'TYPE' => 'SUBMIT'));

$gForm->setField('TEXTFIELD', 'email', $STR['Email'], array(), array('MCLASS' => $GLOBAL['vld_tx_email'], 'MSTYLE' => "width:290px;"));
$gForm->setField('PASSWORD', 'pass', $STR['Pass'], array(), array('MCLASS' => $GLOBAL['vld_tx_password'], 'MSTYLE' => "width:290px;"));
$gForm->setField('CAPTCHA', 'applychars', $STR['ValidateChars'], array(), array('MCLASS' => $GLOBAL['vld_ch_req_max3'], 'HELP' => $STR['TypeCharsComment'], 'MSTYLE' => "width:100px;"));
$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', '<a href="' . $COMMON->getRoot() . 'forgotpassword/">' . $STR['Forgotyourpassword'] . '</a>', array(), array());


$gFormShare = new gForm();
$gFormShare->setNameForm('formShareID');
$gFormShare->setRoot($COMMON->getRoot());
$gFormShare->setMethodForm('post');
$gFormShare->setActionForm('#');
$gFormShare->setStatus('New');
$gFormShare->setLegend($STR['Share']);

$gFormShare->setButton(array(ID => 'btnShare', LABEL => $STR['Send'], POSX => 'right', TYPE => 'SUBMIT'));
$gFormShare->setField('TEXTFIELD', 'sharefrom', $STR['YourName'], array(), array());
$gFormShare->setField('TEXTFIELD', 'sendto', $STR['ShareTo'], array(), array());
$gFormShare->setField('CAPTCHA', 'sharechars', $STR['ValidateChars'], array(), array('MCLASS' => $GLOBAL['vld_ch_req_max3'], 'HELP' => $STR['TypeCharsComment'], 'MSTYLE' => "width:170px;"));


$vacancyId = $_REQUEST['vcn'];

$rGetVacancy = $QUERY->getVacancy("WHERE  a.id  = '$vacancyId'");
$rData = $rGetVacancy->fetch();

$companyId = $rData['id_company'];

$bVacancyFound = $rGetVacancy->size() > 0 ? true : false;

$workarea = $rData['workarea_tx_description'];
$vacancytype = $rData['vacancy_type_tx_description'];

$astrLanguages = $STR['LanguageList'];

$location = $rData['tx_city'] . ' ' . $rData['tx_state'] . ', ' . $rData['tx_country'];

$tx_about = str_replace(array("\r\n", "\r", "\n"), "", $rData['tx_about']);
$tx_reqstudy = str_replace(array("\r\n", "\r", "\n"), "", $rData['tx_reqstudy']);
$tx_reqwork = str_replace(array("\r\n", "\r", "\n"), "", $rData['tx_requirements']);
$tx_workdetail = str_replace(array("\r\n", "\r", "\n"), "", $rData['tx_activitydetail']);

$timeExperience = $STR['ExperienceTimeList'][$rData['ch_timeexperience']];
