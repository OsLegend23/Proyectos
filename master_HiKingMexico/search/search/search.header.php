<?php
/*  /search/search.header.php */
if (!isset($COMMON)) {
    echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";
    die();
}

include($COMMON->getMySQL());
include($COMMON->getQuery());
include($COMMON->getGenForm());
$db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
$QUERY = new Query($db, $GLOBAL);

$rLocationList = $QUERY->getLocation("ORDER BY a.tx_city ASC");
$rStudyLevel = $QUERY->getStudyLevel("WHERE id <= '3' ORDER BY id");
$rCompanyEnabled = $QUERY->getCompany("WHERE b.nm_status = '" . $GLOBAL['user_enable']['value'] . "'");

$aLocation['-1'] = $STR['AllLocation'];
while ($row = $rLocationList->fetch())
    $aLocation[$row['id']] = $row['tx_city'] . ', ' . $row['tx_state'];
while ($row = $rStudyLevel->fetch())
    $aStudyLevel[$row['id']] = $row['tx_description'];



$gForm = new gForm();
$gForm->setNameForm('formID');
$gForm->setRoot($COMMON->getRoot());
$gForm->setMethodForm('post');
$gForm->setActionForm($viewpage . '/remote.php');
$gForm->setStatus('New');
$gForm->setLegend($STR['SearchJob']);

$gForm->setButton(array('ID' => 'btnSubmit', 'ICON' => '', 'LABEL' => $STR['Search'], 'POSX' => 'right', 'TYPE' => 'SUBMIT'));
$gForm->setField('FLANGES', 'consult', $STR['Consult'], array("simplequery" => $STR['SimpleQuery'], "advancedquery" => $STR['AdvancedQuery'], "practices" => $STR['PracticesQuery']), array());
$gForm->setField('TEXTFIELD', 'keyword', $STR['Keyword'], array(), array());
$gForm->setField('COMBOBOX', 'workArea', $STR['WorkArea'], array(), array());
$gForm->setField('COMBOBOX', 'studyLevel', $STR['StudyLevel'], $aStudyLevel, array('SELECTED' => 3));
$gForm->setField('COMBOBOX', 'studyArea', $STR['StudyArea'], array(), array());
$gForm->setField('COMBOBOX', 'location', $STR['Location'], $aLocation, array('SELECTED' => -1, 'MCLASS' => $GLOBAL['vld_nm_nationality']));
?>

