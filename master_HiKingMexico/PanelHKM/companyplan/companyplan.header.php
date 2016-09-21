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

	$rGetCompany 		= $QUERY->getCompany(" WHERE a.id_user = '".$companyId."' ");
	$rDataCompany		= $rGetCompany->fetch();

	$tradeName			= $rDataCompany['tx_tradename'];
	$userName			= $rDataCompany['tx_name'].' '.$rDataCompany['tx_surname'];
	$email				= $rDataCompany['tx_email'];
	$location			= $rDataCompany['tx_city'];
	$phone				= $rDataCompany['tx_phone'];
	$mobil				= $rDataCompany['tx_mobil'];

	$photoCompany = $COMMON->findPhoto($rDataCompany['tx_image'].'_50p',$GLOBAL['linkPhotoCompany'].$rDataCompany['id_user'].'/');

    if(!$photoCompany)
        $photoCompany = $COMMON->findPhoto("default",$GLOBAL['companyDefaultImage']);

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');	
	$gForm->setStatus('New');	
	$gForm->setActionForm($viewpage.'/remote.php');	
	$gForm->setLegend($STR['AnnualPlans']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnSubmit', 'ICON'=>'', 'LABEL'=>$STR['Save'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	
	
	$gForm->setField('COMBOBOX','status',$STR['Status'], array($GLOBAL['plan_enable']['value']=>$GLOBAL['plan_enable']['label'],$GLOBAL['plan_outrange']['value']=>$GLOBAL['plan_outrange']['label']), array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('SEPARATOR',	'','', array(), array());
	$gForm->setField('COMBOBOX','plan',$STR['SelectPlan'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('TEXTFIELD','annualPosts',$STR['AnnualPosts'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('TEXTFIELD','postsCost',$STR['PostsCost'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));	
	$gForm->setField('TEXTFIELD','DateIn',$STR['DateIn'], array(), array('MCLASS'=>$GLOBAL['vld_dt_req'].' datepicker'));	
	$gForm->setField('TEXTFIELD','DateOut',$STR['DateOut'], array(), array('MCLASS'=>$GLOBAL['vld_dt_req'].' datepicker'));		
	$gForm->setField('TEXTAREA', 'Comment',$STR['AdminComment'], array(), array('MCLASS'=>$GLOBAL['vld_tx_opt_max600']));

?>

