<?php	
/*
/main/main.lib.php
*/
	if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}
	
	$COMMON->addCommons();

	$COMMON->getJs($GLOBAL['jquery-ui'].'/jquery.ui.datepicker.min');
	$COMMON->getJs($GLOBAL['jquery-ui'].'/jquery.ui.datepicker-'.$COMMON->getLang());

	$COMMON->getTool('css', 'flexigrid/css/flexigrid.pack.css');
	$COMMON->getTool('js', 'flexigrid/js/flexigrid.pack.js');

	$COMMON->getTool('js', 'tinymce/jscripts/tiny_mce/jquery.tinymce.js');

	$COMMON->getJs('jquery.form');
	$COMMON->getJs('ArrayCollection');
	
?>
