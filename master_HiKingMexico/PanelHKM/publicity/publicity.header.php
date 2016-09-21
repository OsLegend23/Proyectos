<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	
	$publicityid = $COMMON->getEscapeString($_REQUEST['publicityid']);
	
	$action = 'update';

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setEnctype('multipart/form-data');	
	$gForm->setStatus('New');	
	$gForm->setActionForm($viewpage.'/remote.php');	
	$gForm->setLegend($STR['EditPublicity']);
	$gForm->setAlignForm('left');


	if(!is_numeric($publicityid))
	{
		$action = 'insert';
		$gForm->setLegend($STR['AddPublicity']);

		$status		= $GLOBAL['status_enable']['value'];
		$name		= '';
		$DateIn		= '';
		$DateOut	= '';
		$urlWeb		= '';
		$Comment	= '';
	}
	else
	{
		$rGetPublicity = $QUERY->getPublicity("WHERE a.id ='".$publicityid."'");
		$rDataPublicity = $rGetPublicity->fetch();

		$photo = $COMMON->findPhoto($rDataPublicity['tx_image'].'_50p',$GLOBAL['linkslideshow']);
	
		if(!$photo)
			$photo = $COMMON->findPhoto('default_50p',$GLOBAL['postulantDefaultImage']);

		$status		= $rDataPublicity['ch_status'];
		$name		= $rDataPublicity['tx_name'];
		$DateIn		= $rDataPublicity['dt_initpublication'];
		$DateOut	= $rDataPublicity['dt_finishpublication'];
		$urlWeb		= $rDataPublicity['tx_url'];
		$Comment	= $rDataPublicity['tx_description'];

	}


	$gForm->setButton(array('ID'=>'btnUploadPublicity', 'ICON'=>'', 'LABEL'=>$STR['Save'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	
	
	$gForm->setField('IMAGE','displayImage','', array($photo), array());	
	$gForm->setField('FILE','image',$STR['SelectImage'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req'], 'HELP'=>$STR['ImagePublicityDimensions']));	
	$gForm->setField('SEPARATOR',	'','', array(), array());
	
	$gForm->setField('COMBOBOX','status',$STR['Status'], array($GLOBAL['status_enable']['value']=>$GLOBAL['status_enable']['label'],$GLOBAL['status_finished']['value']=>$GLOBAL['status_finished']['label']), array('SELECTED'=>$status, 'MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('SEPARATOR',	'','', array(), array());
	$gForm->setField('TEXTFIELD','name',$STR['Name'], array($name), array('MCLASS'=>$GLOBAL['vld_nm_req']));
	
	$gForm->setField('TEXTFIELD','DateIn',$STR['DateIn'], array($DateIn), array('MCLASS'=>$GLOBAL['vld_dt_req'].' datepicker'));	
	$gForm->setField('TEXTFIELD','DateOut',$STR['DateOut'], array($DateOut), array('MCLASS'=>$GLOBAL['vld_dt_req'].' datepicker'));		

	$gForm->setField('TEXTFIELD','urlWeb',$STR['URLWeb'], array($urlWeb), array('MCLASS'=>$GLOBAL['vld_nm_req']));

	$gForm->setField('TEXTAREA', 'Comment',$STR['Description'], array($Comment), array('MCLASS'=>$GLOBAL['vld_tx_opt_max600']));
	
?>

