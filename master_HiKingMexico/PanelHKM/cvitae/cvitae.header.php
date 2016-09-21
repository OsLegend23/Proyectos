<?php
/*
/cvitae/cvitae.header.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

	$ptl = $COMMON->getEscapeString($_REQUEST['ptl']);
	
	if(!is_numeric($ptl))
	{
		echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
	}

	$postulantId = $ptl;

	$rGetPostulant 	= $QUERY->getPostulant("WHERE a.id_user = '".$postulantId."' ");
	$rDataPostulant = $rGetPostulant->fetch();

	$rGetPostulant_Experience 		= $QUERY->getPostulant_experience("WHERE a.id_postulant = '".$postulantId."'");
	$rGetPostulant_studies 			= $QUERY->getPostulant_studies("WHERE a.id_postulant = '".$postulantId."'");
	$rGetPostulant_informatic 		= $QUERY->getPostulant_informatic("WHERE a.id_postulant = '".$postulantId."'");
	$rGetPostulant_knowledge 		= $QUERY->getPostulant_knowledge("WHERE a.id_postulant = '".$postulantId."'");
	$rGetPostulant_language 		= $QUERY->getPostulant_language("WHERE a.id_postulant = '".$postulantId."'");
	
	$rGetPostulant_expectative 		= $QUERY->getPostulant_expectative("WHERE a.id_postulant = '".$postulantId."'");
	$rDataExpectative 				= $rGetPostulant_expectative->fetch();

	$Name							= $COMMON->getUcwords($rDataPostulant['tx_name'].' '.$rDataPostulant['tx_surname']);
	$BornDate						= $COMMON->getBirthDayFormat($rDataPostulant['dt_borndate']);
	$Gender							= $STR['GenderList'][$rDataPostulant['ch_gender']];
	$RFC							= mb_strtoupper($rDataPostulant['tx_rfc'], 'UTF-8');
	
	$rGetState						= $QUERY->getState("WHERE id = '".$rDataPostulant['nm_state']."' ");
	$rDataState						= $rGetState->fetch();

	$ActualAddress					= $rDataPostulant['tx_city'].' '.$rDataState['tx_state'];
	
	$Phone							= $rDataPostulant['tx_phone'];
	$Mobil							= $rDataPostulant['tx_mobil'];
	$Email							= $rDataPostulant['tx_email'];

	$TOEFLScore						= $rDataPostulant['nm_toeflscore'];


	$HierarchyLevel					= $rDataExpectative['nm_hierarchyLevel'] != -1 ? $STR['HierarchyLevelList'][$rDataExpectative['nm_hierarchyLevel']]: $STR['NotSpecificated'];

	$HomeChange						= $STR['QuestionYesNo'][$rDataExpectative['ch_changeresidence']];
	$WorkCompleteTime				= $STR['QuestionYesNo'][$rDataExpectative['ch_fulltimework']];
	$WorkMiddleTime					= $STR['QuestionYesNo'][$rDataExpectative['ch_parttimework']];
	$Workfees						= $STR['QuestionYesNo'][$rDataExpectative['ch_workfees']];
	$WorkTemp						= $STR['QuestionYesNo'][$rDataExpectative['ch_worktemporarily']];
	$WantMoney						= $rDataExpectative['nm_monthlysalary'];
	$ExpectativesComment			= $rDataExpectative['tx_comment'];


	$postulantPhoto = $COMMON->findPhoto($rDataPostulant['tx_image'].'_50p',$GLOBAL['linkPhotoPostulant'].$postulantId);
	if(!$postulantPhoto)
   		$postulantPhoto = $COMMON->findPhoto('default_50p',$GLOBAL['postulantDefaultImage']);

?>



