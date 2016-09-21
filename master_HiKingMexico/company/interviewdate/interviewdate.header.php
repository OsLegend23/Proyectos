<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$interview_status = array();

	foreach ($GLOBAL['interview_status'] as $key => $value) {
		$interview_status[$key] = $value['label'];
	}

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');	
	$gForm->setStatus('New');
	$gForm->setActionForm($viewpage.'/remote.php');	
	$gForm->setLegend($STR['Search']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnFindValue', 'ICON'=>'', 'LABEL'=>$STR['Search'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	
	$gForm->setField('TEXTFIELD','search',$STR['Search'], array(), array());


	$gFormInterview = new gForm();
	$gFormInterview->setNameForm('formIDInterviewDate');
	$gFormInterview->setRoot($COMMON->getRoot());
	$gFormInterview->setMethodForm('post');	
	$gFormInterview->setStatus('New');
	$gFormInterview->setActionForm($viewpage.'/remote.php');	
	$gFormInterview->setLegend($STR['AddInterviewDate']);
	$gFormInterview->setAlignForm('left');

	$gFormInterview->setButton(array('ID'=>'btnSubmit', 'ICON'=>'', 'LABEL'=>$STR['CreateInterviewDate'],'POSX'=>'right', 'TYPE'=>'SUBMIT', 'REVERT'=>'REVERT'));		
	$gFormInterview->setField('COMMENT',	'',$STR['SelectVacancyForInterviewDate'], array(), array());
	$gFormInterview->setField('COMBOBOX',	'Vacancy',$STR['SelectVacancy'], array(), array('SELECTED'=>'-1'));
	$gFormInterview->setField('SEPARATOR',	'','', array(), array());
	$gFormInterview->setField('TEXTFIELD',	'VacancyName',$STR['VacancyName'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req_max150']));
	$gFormInterview->setField('TEXTFIELD',	'DateIn',$STR['DateIn'], array(), array('MCLASS'=>$GLOBAL['vld_dt_req'].' datepicker'));
	$gFormInterview->setField('TEXTFIELD',	'DateOut',$STR['DateOut'], array(), array('MCLASS'=>$GLOBAL['vld_dt_req'].' datepicker'));
	$gFormInterview->setField('COMBOBOX',	'Status',$STR['Status'], $interview_status, array());
?>

