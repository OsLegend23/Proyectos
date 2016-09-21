<?php
session_start();
include('../../inc/common.inc.php');
include($COMMON->getBossSecurity());
include($COMMON->getMySQL());
include($COMMON->getQuery());
include($COMMON->getGenForm());
$db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
$QUERY = new Query($db, $GLOBAL);

$accountId 		= $_SESSION['enlaceemp_accountid'];

$ptl = $COMMON->getEscapeString($_REQUEST['ptl']);

if(!is_numeric($ptl))
{
	echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
}

$rGetCompanyPlan  = $QUERY->getCompany_Plan("WHERE  a.id_company = '".$accountId."' AND a.ch_status = '".$GLOBAL['plan_enable']['value']."'");
$rDataCompanyPlan	= $rGetCompanyPlan->fetch();

if($rGetCompanyPlan->size() <= 0)
{
	echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
}

/*$Params = array(
	'{planName}' 			=> $rDataCompanyPlan['tx_planname']
	,'{initialPeriod}' 		=> $rDataCompanyPlan['dt_initialperiod']
	,'{periodEnded}' 		=> $rDataCompanyPlan['dt_periodended']
	,'{associatedMail}' 	=> $GLOBAL['email_associated']
);*/

if(!$COMMON->betweenDates($rDataCompanyPlan['dt_initialperiod'],$rDataCompanyPlan['dt_periodended']))
{	
	echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
}

$rGetPostulation = $QUERY->getPostulation("WHERE a.id = '".$ptl."' AND a.id_company = '".$accountId."' ");
$rPostulationData = $rGetPostulation->fetch();

$rGetCVFile = $QUERY->getPostulant_CVFile("WHERE a.id_postulant = '".$rPostulationData['id_postulant']."'");
$rData = $rGetCVFile->fetch();

if($rGetCVFile->size() > 0)
{

	$binaryFileName = $rData['tx_binaryname'];

	$file = $COMMON->findFile($binaryFileName, "media/cvfile/".$rData['id_postulant']);

	if( $file != false)
	{
		$newFileName = str_replace(' ','_',$rData['tx_filename']);

		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header('Content-type: application/pdf');
		header("Content-Disposition: attachment;filename=".$newFileName);
		
		readfile($file);
	}
	else
	{
		echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
	}
}
else
{
	echo "<body onLoad=window.setTimeout(top.location.href='../',0)></body>";die();
}
?>        
