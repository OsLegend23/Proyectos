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

	$validation = $COMMON->getEscapeString($_REQUEST['validation']);
	
	if(!isset($validation))
	{
		echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
	}

	$rGetUser 			= $QUERY->getUser("WHERE tx_sign = '".$validation."' AND nm_status = '".$GLOBAL['user_enable']['value']."' LIMIT 0,1"); 			
	$rData 				= $rGetUser->fetch();

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm('#');
	$gForm->setStatus('New');
	$gForm->setLegend($STR['PassRecoverLbl']);	

	$gForm->setButton(array('ID'=>'btnSubmit', 'ICON'=>'', 'LABEL'=>$STR['PasswordChange'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));
	$gForm->setField('COMMENT',	'',$COMMON->str_replace($STR['RecoverYourPasswordLbl'],array('{userName}'=>$rData['tx_name'].' '.$rData['tx_surname'])), array(), array());
	$gForm->setField('PASSWORD',	'Pass',$STR['Pass'], array(), array('MCLASS'=>$GLOBAL['vld_tx_password']));
	$gForm->setField('PASSWORD',	'ConfPass',$STR['ConfPass'], array(), array('MCLASS'=>$GLOBAL['vld_confirm_tx_password']));
	$gForm->setField('CAPTCHA',		'Chars',$STR['ValidateChars'], array(), array('MCLASS'=>$GLOBAL['vld_ch_req_max3'], 'HELP'=>$STR['TypeCharsComment'], 'MSTYLE'=>"width:170px;"));
	
?>

