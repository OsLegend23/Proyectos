<?php
/*
/controlpanel/controlpanel.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}


	$aYear = $COMMON->getArrayYears($GLOBAL['date_range'], $STR['SelectYear']);

	$gForm = new gForm();

    $gForm->setNameForm('formID');
    $gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm($viewpage.'/remote.php');
	$gForm->setStatus('New');	
	$gForm->setLegend($STR['Laborexperience']);
			
    $gForm->setButton(array(ID=>'btnSubmit', LABEL=>$STR['Save'],POSX=>'right', TYPE=>'SUBMIT'));

	$gForm->setField('TEXTFIELD','TradeName',$STR['TradeName'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req_max150']));	
	
	$gForm->setField('COMBOBOX','WorkArea',$STR['WorkArea'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));		
	$gForm->setField('TEXTFIELD','JobTitle',$STR['JobTitle'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));

	$gForm->setField('TEXTFIELD','Salary',$STR['Salary'].' ('.$STR['Moneda'].')', array(),  array('MCLASS'=>$GLOBAL['vld_tx_req_max10']));	
	
	$gForm->setField('COMBOBOX','HierarchyLevel',$STR['HierarchyLevel'], $STR['HierarchyLevelList'], array('MCLASS'=>$GLOBAL['vld_nm_req']));
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['PeriodoLaborado'], array(), array());

    $gForm->setField('RADIOBUTTON','ActualWork',$STR['IsActualWork'], $STR['QuestionYesNo'], array('MCLASS'=>$GLOBAL['vld_ch_req_radio']));	
	
	$gForm->setField('COMBOBOX','DateInstrMonth',$STR['DateIn'].'('.$STR['Month'].')', $monthFull, array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('COMBOBOX','DateInstrYear',$STR['DateIn'].'('.$STR['Year'].')', $aYear, array('MCLASS'=>$GLOBAL['vld_nm_req']));	
	$gForm->setField('COMBOBOX','DateOutstrMonth',$STR['DateOut'].'('.$STR['Month'].')', $monthFull, array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('COMBOBOX','DateOutstrYear',$STR['DateOut'].'('.$STR['Year'].')', $aYear, array('MCLASS'=>$GLOBAL['vld_nm_req']));
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['ActivityDescription'], array(), array());
	$gForm->setField('TEXTAREA','ActivityDetail','', array(), array('MCLASS'=>$GLOBAL['vld_tx_area_opt_max600']));

	
?>