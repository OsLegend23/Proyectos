<?php
/*
/controlpanel/controlpanel.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$aYear = $COMMON->getArrayYears($GLOBAL['date_range'], $STR['SelectYear']);

	$rStudyLevel 		= $QUERY->getStudyLevel("WHERE id != '9999' ORDER BY id");
	while ($row = $rStudyLevel->fetch()) $aStudyLevel[$row['id']] = $row['tx_description'];

	$gForm = new gForm();

    $gForm->setNameForm('formID');
    $gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm($viewpage.'/remote.php');
	$gForm->setStatus('New');	
	$gForm->setLegend($STR['Academic']);
			
    $gForm->setButton(array('ID'=>'btnSubmit', 'LABEL'=>$STR['Save'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));
		
	$gForm->setField('COMBOBOX','StudyLevel',$STR['StudyLevel'], $aStudyLevel, array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('COMBOBOX','StudyArea',$STR['StudyArea'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));	
	$gForm->setField('TEXTFIELD','Graduate',$STR['StudyArea'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req_max150']));

	$gForm->setField('RADIOBUTTON','ActualStatus',$STR['ActualStatus'], $STR['StatusStudies'], array('MCLASS'=>$GLOBAL['vld_ch_req_radio']));
	$gForm->setField('TEXTFIELD','InstituteName',$STR['InstituteName'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req_max100']));
	
	$gForm->setField('SEPARATOR','','', array(), array());	
	$gForm->setField('COMMENT','',$STR['StudyPeriod'], array(), array());
	
	$gForm->setField('COMBOBOX','DateInstrMonth',$STR['DateIn'].'('.$STR['Month'].')',$monthFull, array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('COMBOBOX','DateInstrYear',$STR['DateIn'].'('.$STR['Year'].')', $aYear, array('MCLASS'=>$GLOBAL['vld_nm_req']));	
	$gForm->setField('COMBOBOX','DateOutstrMonth',$STR['DateOut'].'('.$STR['Month'].')',$monthFull, array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('COMBOBOX','DateOutstrYear',$STR['DateOut'].'('.$STR['Year'].')', $aYear, array('MCLASS'=>$GLOBAL['vld_nm_req']));		
	$gForm->setField('TEXTFIELD','ClasificationAVG',$STR['ClasificationAVG'], array(), array());	

	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['Comment'], array(), array());
	$gForm->setField('TEXTAREA','Comment','', array(), array());
		
?>