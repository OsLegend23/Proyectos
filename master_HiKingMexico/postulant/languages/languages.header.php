<?php
/*
/controlpanel/controlpanel.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$rGetLanguage 	= $QUERY->getLanguage("WHERE a.id != '9999' ORDER BY a.id");
	while ($row = $rGetLanguage->fetch()) $aLanguage[$row['id']] = $row['language_tx_description'];
	

	$rGetPostulant 	= $QUERY->getPostulant("WHERE a.id_user = '$accountId' ");
	$rDataPostulant = $rGetPostulant->fetch();
	$gForm = new gForm();

    $gForm->setNameForm('formID');
    $gForm->setRoot($COMMON->getRoot());
	$gForm->setMethodForm('post');
	$gForm->setActionForm($viewpage.'/remote.php');
	$gForm->setStatus('New');	
	$gForm->setLegend($STR['Knowledge']);
			
    $gForm->setButton(array(ID=>'btnSubmit', LABEL=>$STR['Save'],POSX=>'right', TYPE=>'SUBMIT'));

	$gForm->setField('COMBOBOX','Language',$STR['Language'], $aLanguage, array('MCLASS'=>$GLOBAL['vld_nm_req']));	
	$gForm->setField('COMBOBOX','SpeakDomain',$STR['SpeakDomain'], $STR['LanguageScoreList'], array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('COMBOBOX','ReadDomain',$STR['ReadDomain'], $STR['LanguageScoreList'], array('MCLASS'=>$GLOBAL['vld_nm_req']));
	$gForm->setField('COMBOBOX','WriteDomain',$STR['WriteDomain'], $STR['LanguageScoreList'], array('MCLASS'=>$GLOBAL['vld_nm_req']));
	
	$gForm->setField('SEPARATOR','','', array(), array());
	$gForm->setField('COMMENT','',$STR['TOEFLLabel'], array(), array());
	$gForm->setField('TEXTFIELD','TOEFLScore',$STR['TOEFLScore'],array($rDataPostulant['nm_toeflscore']), array('MCLASS'=>$GLOBAL['vld_nm_opt_max4_on']));	
	
	
?>