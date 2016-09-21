<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$ptl = $COMMON->getEscapeString($_REQUEST['ptl']);
	
	if(!is_numeric($ptl))
	{
		echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
	}


	$rGetCompanyPlan  = $QUERY->getCompany_Plan("WHERE  a.id_company = '".$accountId."' AND a.ch_status = '".$GLOBAL['plan_enable']['value']."'");
	$rDataCompanyPlan	= $rGetCompanyPlan->fetch();

	if($rGetCompanyPlan->size() <= 0)
	{
		echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
	}

	if(!$COMMON->betweenDates($rDataCompanyPlan['dt_initialperiod'],$rDataCompanyPlan['dt_periodended']))
	{	
		echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
	}

	$rGetPostulation = $QUERY->getPostulation("WHERE a.id = '".$ptl."' AND a.id_company = '".$accountId."' ");
	$rPostulationData = $rGetPostulation->fetch();


	$vacancyId = $rPostulationData['id_vacancy'];

	$rGetVacancy = $QUERY->getVacancy("WHERE a.id = '".$vacancyId."' AND a.id_company = '".$accountId."'");
	$rData = $rGetVacancy->fetch();


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

