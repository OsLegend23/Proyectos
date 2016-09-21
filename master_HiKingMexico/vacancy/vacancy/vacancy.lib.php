<?php	
/*
/main/main.lib.php
*/
	if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}
	
	$COMMON->addCommons();
	$COMMON->getJs('jquery.form');
	$COMMON->getJs('ArrayCollection');
	
?>
