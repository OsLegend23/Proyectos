<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}
	
	$photo = $COMMON->findPhoto($_SESSION['enlaceemp_image'],$GLOBAL['linkPhotoCompany'].$accountId);
	
	if(!$photo)
		$photo = $COMMON->findPhoto('default',$GLOBAL['companyDefaultImage']);
		
	$rGetTotalVacancies 			= $QUERY->getCountVacancies("WHERE a.id_company = '".$accountId."' AND a.dt_registry BETWEEN '".$rDataCompanyPlan['dt_initialperiod']."' AND '".$rDataCompanyPlan['dt_periodended']."' ");
	$rDataCountTotalVacancies		= $rGetTotalVacancies->fetch();

	$rGetPostulation				= $QUERY->getPostulation("WHERE a.id_company = '".$accountId."' AND a.nm_status = '1'");

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');	
	$gForm->setStatus('New');	
	$gForm->setActionForm($viewpage.'/remote.php');
	$gForm->setEnctype('multipart/form-data');
	$gForm->setLegend($STR['UploadCompanyLogo']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnUploadPhoto', 'ICON'=>'', 'LABEL'=>$STR['Save'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));

	$gForm->setField('IMAGE','displayImage','', array($photo), array());
		
	$gForm->setField('FILE','image',$STR['Select'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req']));	

?>