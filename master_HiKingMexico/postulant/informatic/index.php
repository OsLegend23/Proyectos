<?php
/*
/controlpanel/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>
	<div class="cleaner h10"></div>	
	<fieldset class="ui-widget-content ui-corner-all">
	<div class="topcomment">
		<img src="<?php echo $COMMON->getMedia('icon', 'comments.png')?>">
		<?php echo $STR['InformaticComment'].'<div class="cleaner h10"></div> '.$STR['FieldsNeededComment'];?>		
	</div>
	</fieldset>
	<div class="cleaner h10"></div>
	<button id="addNew" class="btn-large waves-effect waves-light deep-purple darken-4" style='float: right; display: inline-block; cursor: pointer;width:35%; height:45px; text-align:center;'><?php echo $STR['AddNewInformaticStudy'];?></button>
	<div class="cleaner h10"></div>
	<table id="tblRecorded"></table>
	<div class="cleaner h10"></div>
	
	<?php $gForm->show();?>
	
	