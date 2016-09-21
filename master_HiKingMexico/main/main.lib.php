<?php	
/*
/main/main.lib.php
*/
	if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}
	
	$COMMON->addCommons();
	$COMMON->getJs('jquery.carouFredSel-6.2.0-packed');
	$COMMON->getTool('css', 'nivo.slider/default/default.css');
	$COMMON->getTool('css', 'nivo.slider/nivo-slider.css');
	$COMMON->getTool('js', 'nivo.slider/jquery.nivo.slider.js');
	

	$COMMON->getJs('jquery.form');
?>
