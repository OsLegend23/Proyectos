<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	include($COMMON->getMySQL());	
	$db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
	include($COMMON->getQuery());
	include($COMMON->getGenForm());


	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm('#');
	$gForm->setStatus('New');
	$gForm->setLegend($STR['AddVacancy']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnGotopreview', 'ICON'=>'', 'LABEL'=>$STR['Preview'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	
	$gForm->setButton(array('ID'=>'btnSubmit', 'ICON'=>'', 'LABEL'=>$STR['Save'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	

	$gForm->setField('COMMENT','',$STR['VacancyModeType'], array(), array());
	$gForm->setField('COMBOBOX','PublicationMode',$STR['VacancyModeType'], array() , array());
	$gForm->setField('SEPARATOR','','', array(), array());

	$gForm->setField('COMMENT','',$STR['VacancySpecs'], array(), array());		

	$gForm->setField('TEXTFIELD','VacancyName',$STR['VacancyName'], array(), array());
	$gForm->setField('COMBOBOX','VacancyType',$STR['VacancyType'], array(), array());
	
	$gForm->setField('COMBOBOX','Localization',$STR['Localization'], array(), array());
	
	$gForm->setField('COMBOBOX','Sector',$STR['Sector'], array(), array());	
	$gForm->setField('COMBOBOX','Activity',$STR['Activity'], array(), array());
	$gForm->setField('COMBOBOX','WorkArea',$STR['WorkArea'], array(), array());
	$gForm->setField('TEXTFIELD','SalaryOffered',$STR['SalaryOffered'].' ('.$STR['Moneda'].')', array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['Postulant'], array(), array());
	
	$gForm->setField('COMBOBOX','InitAge',$STR['InitAge'], array(), array());
	$gForm->setField('COMBOBOX','FinishAge',$STR['FinishAge'], array(), array());
	$gForm->setField('RADIOBUTTON','Sex',$STR['Gender'], array(), array());
	$gForm->setField('RADIOBUTTON','MaritalStatus',$STR['MaritalStatus'], array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['StudySpecs'], array(), array());
	
	$gForm->setField('COMBOBOX','StudyLevel',$STR['StudyLevel'], array(), array());
	$gForm->setField('COMBOBOX','StudyArea',$STR['StudyArea'], array(), array());		
	$gForm->setField('TEXTFIELD','StudyAreaDME',$STR['StudyArea'], array(), array());
	
	$gForm->setField('RADIOBUTTON','Relatedstudylevel',$STR['Relatedstudylevel'], array(), array());	
	
	$gForm->setField('ICONBUTTON','AddStudyLevel','', array(), array('ICON'=>"_down_min.png", 'TITLE'=>$STR['AddToList'], 'WIDTH'=>'360px;'));
	$gForm->setField('TABLE','TableLikeStudies','', array(), array(), array());
	
	$gForm->setField('COMMENT','','', array(), array());
	$gForm->setField('RADIOBUTTON','ActualStatus',$STR['ActualStatus'], array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['Language'], array(), array());

	$gForm->setField('COMBOBOX','Language',$STR['Language'], array(), array());
	$gForm->setField('COMBOBOX','Domain',$STR['Domain'], array(), array());	
	$gForm->setField('ICONBUTTON','AddLanguageLevel','', array(), array('ICON'=>"_down_min.png", 'TITLE'=>$STR['AddToList'], 'WIDTH'=>'360px;'));
	$gForm->setField('TABLE','TableLikeLanguages','', array(), array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['OtherStudyRequires'], array(), array());	
	$gForm->setField('TEXTAREA','OtherStudyRequires',"", array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['JobExperience'], array(), array());
	
	$gForm->setField('COMBOBOX','ExperienceTime',$STR['ExperienceTime'], array(), array());
	
	$gForm->setField('COMBOBOX','SectorExp',$STR['Sector'], array(), array());	
	$gForm->setField('COMBOBOX','ActivityExp',$STR['Activity'], array(), array());
	$gForm->setField('COMBOBOX','WorkAreaExp',$STR['WorkArea'], array(), array());
	$gForm->setField('RADIOBUTTON','Relatedworkexperience',$STR['Relatedworkexperience'], array(), array());
	$gForm->setField('ICONBUTTON','AddWorkExperience','', array(), array('ICON'=>"_down_min.png", 'TITLE'=>$STR['AddToList'], 'WIDTH'=>'360px;'));		
	$gForm->setField('TABLE','TableLikeWorkExperience','', array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['OtherWorkRequires'], array(), array());	
	$gForm->setField('TEXTAREA','OtherWorkRequires',$STR['OtherWorkRequires'], array(), array());
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['WorkDetail'], array(), array());
	$gForm->setField('TEXTAREA','WorkDetail',$STR['WorkDetail'], array(), array());
?>

