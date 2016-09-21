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
	$gForm->setLegend($STR['PostulantScrap']);
	$gForm->setAlignForm('left');

	$gForm->setButton(array('ID'=>'btnFindValue', 'ICON'=>'', 'LABEL'=>$STR['Search'],'POSX'=>'right', 'TYPE'=>'SUBMIT', 'REVERT'=>'REVERT'));	
	$gForm->setField('FLANGES',		'consult',$STR['Consult'], array("poorInfo"=>$STR['PoorInfo'], "pendingToDelete"=>$STR['PendingToDelete'] ), array());
	$gForm->setField('TEXTFIELD',	'keyword',$STR['Search'], array(), array());			
	
	$vacancyId = isset($_REQUEST['vcn'])?  $_REQUEST['vcn']: '0';

	$rGetPostulation = $QUERY->getPostulation("WHERE a.id_vacancy = '".$vacancyId."' AND a.id_company = '".$accountId."'");

	$rGetVacancy = $QUERY->getVacancy("WHERE a.id = '".$vacancyId."' AND a.id_company = '".$accountId."'");
	$rData = $rGetVacancy->fetch();
?>

