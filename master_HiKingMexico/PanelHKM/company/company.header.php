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

	$requestPlanId		= $rDataCompanyPlan['id_plan'];

	$rGetCompany 		= $QUERY->getCompany(" WHERE a.id_user = '".$companyId."' ");
	$rDataCompany		= $rGetCompany->fetch();

	$tradeName			= $rDataCompany['tx_tradename'];
	$userName			= $rDataCompany['tx_name'].' '.$rDataCompany['tx_surname'];
	$email				= $rDataCompany['tx_email'];
	$location			= $rDataCompany['tx_city'];
	$phone				= $rDataCompany['tx_phone'];
	$mobil				= $rDataCompany['tx_mobil'];

	$autenticated		= $rDataCompany['dt_registry'] 	!= $rDataCompany['dt_sign']? 1:0;
	$verified			= $rDataCompany['ch_verified'] 	== 'S'? 1: 0;
	$statusAccount				= $rDataCompany['nm_status'] 	== $GLOBAL['user_enable']['value']? 1:0;

	$photoCompany = $COMMON->findPhoto($rDataCompany['tx_image'].'_50p',$GLOBAL['linkPhotoCompany'].$rDataCompany['id_user'].'/');

    if(!$photoCompany)
        $photoCompany = $COMMON->findPhoto("default",$GLOBAL['companyDefaultImage']);


	$rGetAnnualPlan = $QUERY->getCompany_Plan(" WHERE a.id_company = '".$companyId."' ");
	$rDataPlan = $rGetAnnualPlan->fetch();
	
	$creationdate		= $COMMON->getDateFormat($rDataPlan['dt_registry']);
	$planname			= $rDataPlan['tx_planname'];
	$posts				= $rDataPlan['nm_posts'] == 9999? $STR['UnLimited']:$rDataPlan['nm_posts'];
	$initialperiod      = $COMMON->getDateFormat($rDataPlan['dt_initialperiod']);
	$periodended		= $COMMON->getDateFormat($rDataPlan['dt_periodended']);
	$status				= $GLOBAL['plan_status'][$rDataPlan['ch_status']]['label'];
	$postcost			= $rDataPlan['tx_cost'];
	$description 		= $rDataPlan['tx_description'];

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

	

?>

