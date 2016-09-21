<?php
/*
/main/main.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$rStudyLevel 		= $QUERY->getStudyLevel("WHERE id <= '3' ORDER BY id");
	while ($row = $rStudyLevel->fetch()) $aStudyLevel[$row['id']] = $row['tx_description'];	


	$gForm = new gForm();
	$gForm->setNameForm('formID');
	$gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');	
	$gForm->setStatus('New');	
	$gForm->setActionForm($viewpage.'/remote.php');
	$gForm->setEnctype('multipart/form-data');
	$gForm->setLegend($STR['SearchCandidate']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnFindValue', 'ICON'=>'', 'LABEL'=>$STR['SearchCandidate'],'POSX'=>'right', 'TYPE'=>'SUBMIT', 'REVERT'=>'REVERT'));	
	$gForm->setField('FLANGES',		'consult',$STR['Consult'], array("simplequery"=>$STR['SimpleQuery'],"experience"=>$STR['LaborExperienceQuery'],"educative"=>$STR['EducativeLevelQuery'] ), array());
	$gForm->setField('TEXTFIELD',	'keyword',$STR['Search'], array(), array());			
	$gForm->setField('COMBOBOX',	'workArea',$STR['WorkArea'], array(), array());
	$gForm->setField('COMBOBOX',	'studyLevel',$STR['StudyLevel'], $aStudyLevel, array());
	$gForm->setField('COMBOBOX',	'studyArea',$STR['StudyArea'], array(), array());	


	$gFormLinkToVacancy = new gForm();
	$gFormLinkToVacancy->setNameForm('formIDLinkToVacancy');
	$gFormLinkToVacancy->setRoot($COMMON->getRoot());
	$gFormLinkToVacancy->setMethodForm('post');	
	$gFormLinkToVacancy->setStatus('New');	
	$gFormLinkToVacancy->setActionForm($viewpage.'/remote.php');
	$gFormLinkToVacancy->setLegend($STR['LinkToVacancy']);
	$gFormLinkToVacancy->setAlignForm('left');

	$gFormLinkToVacancy->setButton(array('ID'=>'btnLinkPostulantToVacancy', 'ICON'=>'', 'LABEL'=>$STR['LinkPostulantToVacancy'],'POSX'=>'right', 'TYPE'=>'SUBMIT'));	
	$gFormLinkToVacancy->setField('COMBOBOX',	'vacancy',$STR['SelectVacancy'], array(), array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gFormLinkToVacancy->setField('TEXTFIELD',	'tradename',$STR['TradeName'], array(), array('DISABLED'=>'DISABLED'));	
?>

