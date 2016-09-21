<?php
/*
/controlpanel/controlpanel.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}
	
	$gForm = new gForm();

    $gForm->setNameForm('formID');
    $gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm($viewpage.'/remote.php');
	$gForm->setStatus('New');	
	$gForm->setLegend($STR['Knowledge']);
			
    $gForm->setButton(array(ID=>'btnSubmit', LABEL=>$STR['Save'],POSX=>'right', TYPE=>'SUBMIT'));

	$gForm->setField('TEXTFIELD','KnowledgeName',$STR['KnowledgeName'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req_max150']));
	$gForm->setField('COMBOBOX','Domain',$STR['Domain'], $STR['DomainList'], array('MCLASS'=>$GLOBAL['vld_nm_req']));	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['Description'], array(), array());
	$gForm->setField('TEXTAREA','Description','', array(), array('MCLASS'=>$GLOBAL['vld_tx_req_max600']));
	
?>