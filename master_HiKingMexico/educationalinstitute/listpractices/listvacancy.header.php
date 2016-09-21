<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	include($COMMON->getMySQL());	
	$db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
	include($COMMON->getQuery());
	include($COMMON->getGenForm());

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');	
	$gForm->setStatus('New');	
	$gForm->setActionForm($viewpage.'/remote.php');
	$gForm->setEnctype('multipart/form-data');
	$gForm->setLegend($STR['Search']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnSubmit', 'ICON'=>'', 'LABEL'=>$STR['Search'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	
	$gForm->setField('TEXTFIELD','search',$STR['Search'], array(), array());	

?>

