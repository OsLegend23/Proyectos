<?php
/*  /companyregister/form.header.php */

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
$gForm->setLegend($STR['CompanyRegistry']);
$gForm->setAlignForm('left');

$gForm->setButton(array(
    'ID' => 'btnRegistry',
    'ICON' => '',
    'LABEL' => $STR['RegistryMe'],
    'POSX' => 'right',
    'TYPE' => 'SUBMIT'));

$gForm->setField('COMMENT', '', $STR['accountData'], array(), array());
$gForm->setField('TEXTFIELD', 'Name', $STR['UserName'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max50']));
$gForm->setField('TEXTFIELD', 'Surname', $STR['Surname(s)'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max50']));
$gForm->setField('TEXTFIELD', 'Email', $STR['Email'], array(), array('MCLASS' => $GLOBAL['vld_tx_email']));
$gForm->setField('TEXTFIELD', 'Confemail', $STR['Confemail'], array(), array('MCLASS' => $GLOBAL['vld_confirm_tx_email']));
$gForm->setField('PASSWORD', 'Pass', $STR['Pass'], array(), array('MCLASS' => $GLOBAL['vld_tx_password']));
$gForm->setField('PASSWORD', 'ConfPass', $STR['ConfPass'], array(), array('MCLASS' => $GLOBAL['vld_confirm_tx_password']));

$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', $STR['CommentCompanyInfo'], array(), array());
$gForm->setField('TEXTFIELD', 'TradeName', $STR['TradeName'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max100']));
$gForm->setField('TEXTFIELD', 'TradeMark', $STR['TradeMark'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max100']));
$gForm->setField('TEXTFIELD', 'RFC', $STR['RFC'], array($rDataCompany['tx_rfc']), array('MCLASS' => $GLOBAL['vld_tx_req_max16']));
$gForm->setField('COMBOBOX', 'Sector', $STR['Sector'], array(), array('MCLASS' => $GLOBAL['vld_nm_req']));
$gForm->setField('TEXTFIELD', 'Activity', $STR['Activity'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max150']));
$gForm->setField('TEXTFIELD', 'Employees', $STR['Employees'], array(), array('MCLASS' => $GLOBAL['vld_nm_req_on']));

$gForm->setField('COMMENT', '', '<h6 style="color:red;">' . $STR['EmailForReceiptOfCurriculum'] . '</h6><img id="helpbtn_Chars" style="cursor: pointer; " src="../media/icon/help.png">', array(), array('HELP' => $STR['TypeCharsComment']));

$gForm->setField('TEXTFIELD', 'CompanyMail', $STR['CompanyMail'], array($rDataCompany['tx_companyemail']), array('MCLASS' => $GLOBAL['vld_tx_email']));
$gForm->setField('TEXTFIELD', 'ConfidentialMail', $STR['ConfidentialMail'], array($rDataCompany['tx_confidentialemail']), array('MCLASS' => $GLOBAL['vld_tx_email']));

$gForm->setField('TEXTAREA', 'CompanyAbout', $STR['CompanyAbout'], array(), array('MCLASS' => $GLOBAL['vld_tx_req_max600']));

$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', $STR['Location'], array(), array());
$gForm->setField('COMBOBOX', 'State', $STR['State'], array(), array('SELECTED' => "", 'MCLASS' => $GLOBAL['vld_nm_req']));
$gForm->setField('TEXTFIELD', 'City', $STR['City'], array($rDataPostulant['tx_city']), array('MCLASS' => $GLOBAL['vld_tx_req_max25']));
$gForm->setField('TEXTFIELD', 'Colony', $STR['Colony'], array($rDataPostulant['tx_colony']), array('MCLASS' => $GLOBAL['vld_tx_req_max50']));
$gForm->setField('TEXTFIELD', 'Street', $STR['Street'], array($rDataPostulant['tx_street']), array('MCLASS' => $GLOBAL['vld_tx_req_max50']));
$gForm->setField('TEXTFIELD', 'Number', $STR['Number'], array($rDataPostulant['tx_number']), array('MCLASS' => $GLOBAL['vld_tx_req_max10']));
$gForm->setField('TEXTFIELD', 'Phone', $STR['Phone'], array($rDataPostulant['tx_phone']), array('MCLASS' => $GLOBAL['vld_tx_req_max15']));
$gForm->setField('TEXTFIELD', 'Ext', $STR['Ext'], array($rDataPostulant['tx_ext']), array('MCLASS' => $GLOBAL['vld_tx_req_max3']));
$gForm->setField('TEXTFIELD', 'URLWeb', $STR['URLWeb'], array($rDataCompany['tx_web']), array('MCLASS' => $GLOBAL['vld_tx_opt_max150']));
$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', $STR['BenefitsAndEntitlements'], array(), array());
$gForm->setField('BNFCHECKBOX', 'Benefits', $STR['Sector'], $STR['BenefitsList'], array('MCLASS' => $GLOBAL['vld_ch_req_checkbox_min1']));

$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('CAPTCHA', 'Chars', $STR['ValidateChars'], array(), array('MCLASS' => $GLOBAL['vld_ch_req_max3'], 'HELP' => $STR['TypeCharsComment'], 'MSTYLE' => "width:170px;"));

$gForm->setField('SEPARATOR', '', '', array(), array());
$gForm->setField('COMMENT', '', $STR['AceptPolitics'], array(), array());
$gForm->setField('CHECKBOX', 'AceptPolitics', '', array("" => '<a href="#" id="termsAndConditions" class="shortcut">' . $STR['ReadPolitics'] . '</a>'), array('MCLASS' => $GLOBAL['vld_ch_req_checkbox_min1']));
?>
