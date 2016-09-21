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
$db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
$QUERY = new Query($db, $GLOBAL);

$rStudyLevel = $QUERY->getStudyLevel("WHERE id <= '3' ORDER BY id");
while ($row = $rStudyLevel->fetch()) $aStudyLevel[$row['id']] = $row['tx_description'];

$aYear = $COMMON->getArrayYears($GLOBAL['date_range']);

$gForm = new gForm();
$gForm->setNameForm('formID');
$gForm->setRoot($COMMON->getRoot());
$gForm->setMethodForm('post');
$gForm->setActionForm('#');
$gForm->setStatus('New');
$gForm->setLegend($STR['RegistryNow']);
$gForm->setAlignForm('left');

$gForm->setButton(array('ID' => 'btnPostulate', 'ICON' => '', 'LABEL' => $STR['RegistryMe'], 'POSX' => 'right', 'TYPE' => 'SUBMIT'));

$gForm->setField('COMMENT', '', $STR['accountData'], array(), array());
$gForm->setField('TEXTFIELD', 'Email', $STR['Email'], array(), array('MCLASS' => $GLOBAL['vld_tx_email']));
$gForm->setField('TEXTFIELD', 'Confemail', $STR['Confemail'], array(), array('MCLASS' => $GLOBAL['vld_confirm_tx_email']));
$gForm->setField('PASSWORD', 'Pass', $STR['Pass'], array(), array('MCLASS' => $GLOBAL['vld_tx_password']));
$gForm->setField('PASSWORD', 'ConfPass', $STR['ConfPass'], array(), array('MCLASS' => $GLOBAL['vld_confirm_tx_password']));
$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', $STR['PersonalInfo'], array(), array());
$gForm->setField('TEXTFIELD', 'Name', $STR['Name(s)'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max50']));
$gForm->setField('TEXTFIELD', 'Surname', $STR['Surname(s)'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max150']));
$gForm->setField('TEXTFIELD', 'RFC', $STR['RFC'], array(), array('MCLASS' => $GLOBAL['vld_tx_opt_max16']));
$gForm->setField('RADIOBUTTON', 'Gender', $STR['Gender'], array("F" => $STR['GenderFemale'], "M" => $STR['GenderMale']), array('MSTYLE' => "", 'CHECKED' => "", 'MCLASS' => $GLOBAL['vld_ch_req_radio']));
$gForm->setField('TEXTFIELD', 'BornDate', $STR['BornDate'], array(), array('MCLASS' => $GLOBAL['vld_dt_req'] . ' datepicker'));
$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', $STR['Location'], array(), array());
$gForm->setField('COMBOBOX', 'State', $STR['State'], $aStates, array('SELECTED' => "", 'MCLASS' => $GLOBAL['vld_nm_req']));
$gForm->setField('TEXTFIELD', 'City', $STR['City'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max25']));
$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', $STR['Studies'] . ' ' . $STR['Academic'], array(), array());
$gForm->setField('COMBOBOX', 'StudyLevel', $STR['StudyLevel'], $aStudyLevel, array('MCLASS' => $GLOBAL['vld_nm_req'], 'SELECTED' => '3'));
$gForm->setField('COMBOBOX', 'StudyArea', $STR['StudyArea'], array(), array('MCLASS' => $GLOBAL['vld_nm_req']));
/*$gForm->setField('TEXTFIELD',	'OtherStudyArea',$STR['OtherStudyArea'], array(), array('MCLASS'=>$GLOBAL['vld_tx_opt_max100']));*/
$gForm->setField('TEXTFIELD', 'InstituteName', $STR['InstituteName'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max100']));

$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', $STR['Laborexperience'], array(), array());

$gForm->setField('RADIOBUTTON', 'FirstJob', $STR['FirstJob'], $STR['QuestionYesNo'], array('MSTYLE' => "", 'CHECKED' => "N", 'MCLASS' => $GLOBAL['vld_ch_req_radio']));

$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', $STR['LastJobInfo'], array(), array());

$gForm->setField('COMBOBOX', 'WorkArea', $STR['WorkArea'], array(), array('MCLASS' => $GLOBAL['vld_nm_req']));
$gForm->setField('TEXTFIELD', 'JobTitle', $STR['JobTitle'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max100']));
$gForm->setField('COMBOBOX', 'DateInstrYear', $STR['DateIn'] . '(' . $STR['Year'] . ')', $aYear, array('MCLASS' => $GLOBAL['vld_nm_req']));
$gForm->setField('COMBOBOX', 'DateOutstrYear', $STR['DateOut'] . '(' . $STR['Year'] . ')', $aYear, array('MCLASS' => $GLOBAL['vld_nm_req']));

$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('CAPTCHA', 'Chars', $STR['ValidateChars'], array(), array('MCLASS' => $GLOBAL['vld_ch_req_max3'], 'HELP' => $STR['TypeCharsComment'], 'MSTYLE' => "width:170px;"));
$gForm->setField('SEPARATOR', '', '', array(), array());

$gForm->setField('CHECKBOX', 'AceptPolitics', $STR['AceptPolitics'], array("" => '<a href="#" id="termsAndConditions" class="shortcut">' . $STR['ReadPolitics'] . '</a>'), array('MCLASS' => $GLOBAL['vld_ch_req_checkbox_min1']));


?>

