<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}
	
	$photo = $COMMON->findPhoto($_SESSION['enlaceemp_image'].'_50p',$GLOBAL['linkPhotoPostulant'].$accountId);
	
	if(!$photo)
		$photo = $COMMON->findPhoto('default_50p',$GLOBAL['postulantDefaultImage']);

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');	
	$gForm->setStatus('New');	
	$gForm->setActionForm($viewpage.'/remote.php');
	$gForm->setEnctype('multipart/form-data');
	$gForm->setLegend($STR['Upload'].' '.$STR['Photo']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnUploadPhoto', 'ICON'=>'', 'LABEL'=>$STR['Upload'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));

	$gForm->setField('IMAGE','displayImage','', array($photo), array());
		
	$gForm->setField('FILE','image',$STR['SelectFile'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req']));


	$gFormCVFiles = new gForm();
	$gFormCVFiles->setNameForm('formCVFilesID');
	$gFormCVFiles->setRoot($COMMON->getRoot());
	$gFormCVFiles->setMethodForm('post');	
	$gFormCVFiles->setStatus('New');	
	$gFormCVFiles->setActionForm($viewpage.'/remote.php');
	$gFormCVFiles->setEnctype('multipart/form-data');
	$gFormCVFiles->setLegend($STR['UploadCVFile']);
	$gFormCVFiles->setAlignForm('left');

	$gFormCVFiles->setButton(array('ID'=>'btnUploadCVFile', 'ICON'=>'', 'LABEL'=>$STR['Upload'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));

	$gFormCVFiles->setField('TABLE','tblCVFiles','', array(), array(), array());
		
	$gFormCVFiles->setField('FILE','CVFile',$STR['SelectFile'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req']));	

?>

