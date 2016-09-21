<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>$(document.body).ready(function(){	
	$("#btnPrint").live("click", function(e)	{	    	        top.location.href="?page=cvitae&print=yes";	        return false;	});
});<?php   ?>
