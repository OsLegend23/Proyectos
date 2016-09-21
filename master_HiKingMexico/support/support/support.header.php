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
	$gForm->setLegend($STR['Comments']);		        
    
	$gForm->setButton(array(ID=>'btnSendComment', LABEL=>$STR['Send'],POSX=>'right', TYPE=>'SUBMIT'));	
	$gForm->setField('TEXTFIELD',	'email',$STR['User'], array(), array('MCLASS'=>$GLOBAL['vld_tx_email']));
	$gForm->setField('TEXTFIELD',	'name',$STR['YourName'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req_max50']));
	$gForm->setField('TEXTFIELD',	'subject',$STR['Subject'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req_max50']));		
	$gForm->setField('TEXTAREA',	'comment',$STR['Comment'], array(), array('MCLASS'=>$GLOBAL['vld_tx_opt_max600']));
	$gForm->setField('CAPTCHA',		'Chars',$STR['ValidateChars'], array(), array('MCLASS'=>$GLOBAL['vld_ch_req_max3'], 'HELP'=>$STR['TypeCharsComment'], 'MSTYLE'=>"width:170px;"));

?>

