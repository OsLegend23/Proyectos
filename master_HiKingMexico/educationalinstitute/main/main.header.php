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
	$gForm->setLegend($STR['Upload'].' '.$STR['Logo']);
	$gForm->setAlignForm('left');

	$gForm->setField('IMAGE','publicationImage','', array(ONE=>$fileImage), array());
	$gForm->setField('COMMENT','','', array(), array());
	$gForm->setField('SEPARATOR','','', array(), array());	
	$gForm->setField('FILE','image',$STR['SelectLogo'], array(TWO=>$STR['PermittedTypeFile']." ".$permittedFormat), array(REQUIRED=>"", VALIDATE=>$CLASS_VALIDATE['SelectFile'], MSTYLE=>""));	

?>

