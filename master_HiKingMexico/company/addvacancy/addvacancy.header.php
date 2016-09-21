<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$vacancyStatus = array();

	foreach ($GLOBAL['vacancy_status'] as $key => $value) {
		$vacancyStatus[$key] = $value['label'];		
	}
	
	$rGetCompany 	= $QUERY->getCompany("WHERE  a.id_user  = '$accountId'");
	$rData = $rGetCompany->fetch();

	$label = array("-1"=> $STR['SelectAge'], "0"=>$STR['NoRequired']);	    
	$InitAge = $COMMON->getYearsAgoRange($GLOBAL['min_years_ago'], $GLOBAL['max_years_ago'],$label);

	$label = array("-1"=> $STR['SelectAge'], "66"=>$STR['Onwards']);	    
	$FinishAge = $COMMON->getYearsAgoRange($GLOBAL['min_years_ago'], $GLOBAL['max_years_ago'],$label);


	$aStudyLevel[-1] 	= $STR['SelectStudyLevel'];
	$rStudyLevel 		= $QUERY->getStudyLevel("ORDER BY id DESC");
	while ($row = $rStudyLevel->fetch()) $aStudyLevel[$row['id']] = $row['tx_description'];
	
	$aLanguage[-1] = $STR['SelectLanguage'];
	$rGetLanguage 	= $QUERY->getLanguage("ORDER BY a.id DESC");
	while ($row = $rGetLanguage->fetch()) $aLanguage[$row['id']] = $row['language_tx_description'];
	
	$aVacancyType[-1] = $STR['SelectVacancyType'];
	$rGetVacancyType 	= $QUERY->getVacancyType("ORDER BY a.id DESC");
	while ($row = $rGetVacancyType->fetch()) $aVacancyType[$row['id']] = $row['vacancy_type_tx_description'];
	
	$aLocation[-1] = $STR['SelectLocation'];
	$rGetLocation 		= $QUERY->getLocation("ORDER BY a.tx_city DESC");
	while ($row = $rGetLocation->fetch()) $aLocation[$row['id']] = $row['tx_city'].', '.$row['tx_state'];

	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm('#');
	$gForm->setStatus('New');
	$gForm->setLegend($STR['AddVacancy']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnGotopreview', 'ICON'=>'', 'LABEL'=>$STR['Preview'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	
	$gForm->setButton(array('ID'=>'btnSubmit', 'ICON'=>'', 'LABEL'=>$STR['Publicate'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	

	$gForm->setField('COMMENT','',$STR['VacancyModeType'], array(), array());
	$gForm->setField('RADIOBUTTON','ConfidentialMode',$STR['ConfidentialMode'], $STR['QuestionYesNo'], array('CHECKED'=>'N'));
	$gForm->setField('SEPARATOR','','', array(), array());

	$gForm->setField('COMMENT','',$STR['Vacancystatus'], array(), array());
	$gForm->setField('RADIOBUTTON','StatusVacancy',$STR['Status'], $vacancyStatus , array('CHECKED'=>'1', 'MCLASS'=>$GLOBAL['vld_ch_req_radio']));
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['VacancySpecs'], array(), array());		

	$gForm->setField('TEXTFIELD','VacancyName',$STR['VacancyName'], array(), array('MCLASS'=>$GLOBAL['vld_tx_req_max150']));
	$gForm->setField('COMBOBOX','VacancyType',$STR['VacancyType'], $aVacancyType, array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('TEXTFIELD','JobsOffered',$STR['JobsOffered'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req_on']));
	$gForm->setField('COMBOBOX','Location',$STR['Location'], $aLocation, array('SELECTED'=>'1', 'MCLASS'=>$GLOBAL['vld_nm_req']));

	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['VacancySectorActivityArea'], array(), array());

	$gForm->setField('COMBOBOX','WorkArea',$STR['WorkArea'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));

	$gForm->setField('SEPARATOR','','', array(), array());
	
	$gForm->setField('TEXTFIELD','SalaryOffered',$STR['SalaryOffered'].' ('.$STR['Moneda'].')', array(), array('MCLASS'=>$GLOBAL['vld_tx_opt_max10']));
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['Postulant'], array(), array());
	
	$gForm->setField('COMBOBOX','InitAge',$STR['InitAge'], $InitAge, array('SELECTED'=>'-1', 'MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('COMBOBOX','FinishAge',$STR['FinishAge'], $FinishAge, array('SELECTED'=>'-1', 'MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('RADIOBUTTON',	'Gender',$STR['Gender'], array("X"=>$STR['NoRequired'], "F"=>$STR['GenderFemale'],"M"=>$STR['GenderMale']), array('MSTYLE'=>"", 'CHECKED'=>'X', 'MCLASS'=>$GLOBAL['vld_ch_req_radio']));
	$gForm->setField('RADIOBUTTON',	'MaritalStatus',$STR['MaritalStatus'], array("X"=>$STR['NoRequired'], "S"=>$STR['MaritalStatusSingle'],"C"=>$STR['MaritalStatusMarried'],"D"=>$STR['MaritalStatusDivorced'], "V"=>$STR['MaritalStatusWidowed']), array('MSTYLE'=>"", 'CHECKED'=>'X',  'MCLASS'=>$GLOBAL['vld_ch_req_radio']));	
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['StudySpecs'], array(), array());	

	$gForm->setField('RADIOBUTTON','ActualStatus',$STR['ActualStatus'], array_merge(array("X"=>$STR['NoRequired']),$STR['StatusStudies']), array('CHECKED'=>'X', 'MCLASS'=>$GLOBAL['vld_ch_req_radio']));

	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['CanAddFiveStudySpecs'], array(), array());	

	$gForm->setField('COMBOBOX','StudyLevel',$STR['StudyLevel'], $aStudyLevel, array());
	$gForm->setField('COMBOBOX','StudyArea',$STR['StudyArea'], array(), array());		
	$gForm->setField('TEXTFIELD','StudyAreaDME',$STR['StudyArea'], array(), array());
	
	$gForm->setField('RADIOBUTTON','Relatedstudylevel',$STR['Relatedstudylevel'],$STR['QuestionYesNo'], array('CHECKED'=>'N', 'MCLASS'=>$GLOBAL['vld_ch_req_radio']));		
	
	$gForm->setField('ICONBUTTON','AddStudyLevel','', array(), array('ICON'=>"_down_min.png", 'TITLE'=>$STR['AddToList'], 'WIDTH'=>'360px;'));	
	$gForm->setField('TABLE','tblStudies','', array(), array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['OtherStudyRequires'], array(), array());	
	$gForm->setField('TEXTAREA','OtherStudyRequires',"", array(), array());


	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['CanAddFiveLanguages'], array(), array());

	$gForm->setField('COMBOBOX','Language',$STR['Language'], $aLanguage, array());
	$gForm->setField('COMBOBOX','Domain',$STR['Domain'], $STR['LanguageScoreList'], array());	
	$gForm->setField('ICONBUTTON','AddLanguage','', array(), array('ICON'=>"_down_min.png", 'TITLE'=>$STR['AddToList'], 'WIDTH'=>'360px;'));
	$gForm->setField('TABLE','tblLanguages','', array(), array(), array());
	
	
	$gForm->setField('SEPARATOR','','', array(), array());

	$gForm->setField('COMBOBOX','ExperienceTime',$STR['ExperienceTime'], $STR['ExperienceTimeList'], array('MCLASS'=>$GLOBAL['vld_nm_req']));
	
	$gForm->setField('COMMENT','',$STR['WorkRequires'], array(), array());	
	$gForm->setField('TEXTAREA','Requirements','', array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['WorkDetail'], array(), array());
	$gForm->setField('TEXTAREA','ActivityDetail','', array(), array());
?>

