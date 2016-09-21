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
$accountName 	= $_SESSION['enlaceemp_accountname'];

$rGetCVFile = $QUERY->getPostulant_CVFile("WHERE a.id_postulant = '".$accountId."'");

$rData = $rGetCVFile->fetch();

if($rGetCVFile->size() > 0)
{

	$binaryFileName = $rData['tx_binaryname'];

	$file = $COMMON->findFile($binaryFileName, "media/cvfile/".$accountId);

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
