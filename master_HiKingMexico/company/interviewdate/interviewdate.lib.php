<?php	
/*
/main/main.lib.php
*/
	if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}
	
	$COMMON->addCommons();

	$COMMON->getTool('css', 'flexigrid/css/flexigrid.pack.css');	
	$COMMON->getTool('js', 'flexigrid/js/flexigrid.pack.js');
	
	$COMMON->getJs($GLOBAL['jquery-ui'].'/jquery.ui.datepicker.min');
	$COMMON->getJs($GLOBAL['jquery-ui'].'/jquery.ui.datepicker-'.$COMMON->getLang());
	
	$COMMON->getJs('ArrayCollection');
	$COMMON->getJs('jquery.form');
?>
