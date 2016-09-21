<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

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
	$gForm->setLegend($STR['Forgotyourpassword']);	

	$gForm->setButton(array('ID'=>'btnSubmit', 'ICON'=>'', 'LABEL'=>$STR['Recover'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));
	$gForm->setField('COMMENT',	'',$STR['ForgotyourpasswordLbl'], array(), array());
	$gForm->setField('TEXTFIELD',	'Email',$STR['Email'], array(), array('MCLASS'=>$GLOBAL['vld_tx_email']));
	$gForm->setField('CAPTCHA',		'Chars',$STR['ValidateChars'], array(), array('MCLASS'=>$GLOBAL['vld_ch_req_max3'], 'HELP'=>$STR['TypeCharsComment'], 'MSTYLE'=>"width:170px;"));
	
?>

