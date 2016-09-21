<?php
/*
/controlpanel/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>	
	<div class="cleaner h30"></div>
	<fieldset class="ui-widget-content ui-corner-all">
	<div class="topcomment">
		<img src="<?php echo $COMMON->getMedia('icon', 'comments.png')?>">
		<?php echo $STR['ExpectativesComment'].'<div class="cleaner h10"></div> '.$STR['FieldsNeededComment'];?>		
	</div>
	</fieldset>

	<div class="cleaner h10"></div>
	<?php 
	$gForm->show();
	echo '<div class="cleaner h10"></div>';
	$gFormExpectatives->show();
	?>
	
	