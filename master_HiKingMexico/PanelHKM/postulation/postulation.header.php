<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$companyId = $COMMON->getEscapeString($_REQUEST['companyId']);
	
	if(!is_numeric($companyId))
	{
		echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
	}

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');	
	$gForm->setStatus('New');	
	$gForm->setActionForm($viewpage.'/remote.php');
	$gForm->setEnctype('multipart/form-data');
	$gForm->setLegend($STR['Search']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnFindValue', 'ICON'=>'', 'LABEL'=>$STR['Search'],'POSX'=>'right', 'TYPE'=>'SUBMIT', 'REVERT'=>'REVERT'));	
	$gForm->setField('TEXTFIELD','search',$STR['Search'], array(), array());	


	$vacancyId = isset($_REQUEST['vcn'])?  $_REQUEST['vcn']: '0';

	$rGetPostulation = $QUERY->getPostulation("WHERE a.id_vacancy = '".$vacancyId."' AND a.id_company = '".$companyId."'");

	$rGetVacancy = $QUERY->getVacancy("WHERE a.id = '".$vacancyId."' AND a.id_company = '".$companyId."'");
	$rData = $rGetVacancy->fetch();
?>

