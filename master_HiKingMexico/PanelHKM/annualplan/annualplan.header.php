<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$rGetCompanyPlan 	= $QUERY->getCompany_Plan("WHERE a.id_company = '".$accountId."' ");
	$rDataCompanyPlan	= $rGetCompanyPlan->fetch();

	$rGetAnnualPlan 	= $QUERY->getAnnualPlan("WHERE a.id != '6' ");

	$companyPlanParams = array(
			'{planName}' 			=> $rDataCompanyPlan['tx_planname']
			,'{statusPlan}' 		=> $GLOBAL['plan_status'][$rDataCompanyPlan['ch_status']]['label']
			,'{initialPeriod}' 		=> $COMMON->getDateFormat($rDataCompanyPlan['dt_initialperiod'])
			,'{periodEnded}' 		=> $COMMON->getDateFormat($rDataCompanyPlan['dt_periodended'])
	);


	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');	
	$gForm->setStatus('New');	
	$gForm->setActionForm($viewpage.'/remote.php');	
	$gForm->setLegend($STR['AnnualPlans']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnSubmit', 'ICON'=>'', 'LABEL'=>$STR['SendRequest'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	
	
	$gForm->setField('COMBOBOX','plan',$STR['SelectPlan'], $aVacancyType, array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('TEXTFIELD','annualPosts',$STR['AnnualPosts'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('TEXTFIELD','postsCost',$STR['PostsCost'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('TEXTFIELD','AnnualPlanTotalDays',$STR['AnnualPlanTotalDays'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));	
	$gForm->setField('TEXTAREA','Description',$STR['Description'], array(), array());


?>

