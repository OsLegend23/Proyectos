<?php	
/*
/suport/suport.lib.php
*/
	if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}
	
	$COMMON->addCommons();

	//$COMMON->getJs($GLOBAL['jquery-ui'].'/jquery.ui.accordion.min');
	
	$COMMON->getTool('js', 'tinymce/jscripts/tiny_mce/jquery.tinymce.js');

	$COMMON->getJs('jquery.form');
?>