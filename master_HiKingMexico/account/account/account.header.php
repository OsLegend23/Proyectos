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

$gForm = new gForm();
$gForm->setNameForm('formID');
$gForm->setRoot($COMMON->getRoot());
$gForm->setMethodForm('post');
$gForm->setActionForm('#');
$gForm->setStatus('New');
$gForm->setLegend($STR['SignIn']);

$gForm->setButton(array('ID' => 'btnAutenticate', 'ICON' => '', 'LABEL' => $STR['Validate'], 'POSX' => 'right', 'TYPE' => 'SUBMIT'));

$gForm->setField('TEXTFIELD', 'Email', $STR['Email'], array(), array('MCLASS' => $GLOBAL['vld_tx_email']));
$gForm->setField('PASSWORD', 'Pass', $STR['Pass'], array(), array('MCLASS' => $GLOBAL['vld_tx_password']));
$gForm->setField('CAPTCHA', 'Chars', $STR['ValidateChars'], array(), array('MCLASS' => $GLOBAL['vld_ch_req_max3'], 'HELP' => $STR['TypeCharsComment'], 'MSTYLE' => "width:170px;"));
$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', '<a href="' . $COMMON->getRoot() . 'forgotpassword/">' . $STR['Forgotyourpassword'] . '</a>', array(), array());


if (isset($_REQUEST['validation'])) {
    $tx_sign = $COMMON->getEscapeString($_REQUEST['validation']);

    $rGetUser = $QUERY->getUser("WHERE tx_sign = '" . $tx_sign . "' AND nm_status = '" . $GLOBAL['user_enable']['value'] . "' LIMIT 0,1");
    $rData = $rGetUser->fetch();

    if ($rGetUser->size() > 0) {

        $hoy = $STR['CurrentDate'];
        $QUERY->updateUser(array('dt_sign' => date("Y-m-d", strtotime("$hoy + 1 day"))), "WHERE id = '" . $rData['id'] . "'");

        if (isset($_SESSION['enlaceemp_signed']))
            $_SESSION['enlaceemp_signed'] = 1;

        $answer = $COMMON->str_replace($STR['EmailValidationSuccess'], array('{userName}' => $rData['tx_name'] . ' ' . $rData['tx_surname'], '{email}' => $rData['tx_email']));
    } else
        $answer = $STR['EmailValidationFail'];
}
?>

