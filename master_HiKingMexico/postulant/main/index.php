<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>        
<div class="cleaner h10"></div>        
<div id="templatemo_main">
<?php $gFormCVFiles->show();?>	
<div class="cleaner h30"></div>
<div class="cbox_small400 float_l">
	<?php $gForm->show();?>
</div>

<div class="cbox_large530 float_r">
<div id="" class="ui-corner-all"><?php echo $STR['PostulantInformationStatusComment'];?></div>
	<ul id="" style="list-style:none; margin:0px 10px 0px -30px">
		<li class="ui-widget-content  ui-corner-all"  style="width:100%;"><div style="display: inline-block;"><button id="btnAccountData" class="btn-large waves-effect waves-light deep-purple darken-4" style='display: inline-block; cursor: pointer; width:100px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['Edit'];?></button><a href="<?php echo $php_self.'?page=personal'; ?>"><?php echo $STR['AccountData'];?></a></div><div id="status_AccountData" class="float_r"><img src="<?php echo $COMMON->getMedia('icon', 'wait.gif');?>"></div></li>
		<div class="cleaner h10"></div>
		<li class="ui-widget-content  ui-corner-all"  style="width:100%;"><div style="display: inline-block;"><button id="btnAcademic" class="btn-large waves-effect waves-light deep-purple darken-4" style='display: inline-block; cursor: pointer; width:100px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['Edit'];?></button><a href="<?php echo $php_self.'?page=academicstudies'; ?>" ><?php echo $STR['Academic'];?></a></div><div id="status_Academic" class="float_r"><img src="<?php echo $COMMON->getMedia('icon', 'wait.gif');?>"></div></li>
		<div class="cleaner h10"></div>
		<li class="ui-widget-content  ui-corner-all"  style="width:100%;"><div style="display: inline-block;"><button id="btnInformatic" class="btn-large waves-effect waves-light deep-purple darken-4" style='display: inline-block; cursor: pointer; width:100px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['Edit'];?></button><a href="<?php echo $php_self.'?page=informatic'; ?>" ><?php echo $STR['Informatic'];?></a></div><div id="status_Informatic" class="float_r"><img src="<?php echo $COMMON->getMedia('icon', 'wait.gif');?>"></div></li>			
		<div class="cleaner h10"></div>
		<li class="ui-widget-content  ui-corner-all"  style="width:100%;"><div style="display: inline-block;"><button id="btnKnowledge" class="btn-large waves-effect waves-light deep-purple darken-4" style='display: inline-block; cursor: pointer; width:100px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['Edit'];?></button><a href="<?php echo $php_self.'?page=knowledge'; ?>" ><?php echo $STR['Knowledge'];?></a></div><div id="status_Knowledge" class="float_r"><img src="<?php echo $COMMON->getMedia('icon', 'wait.gif');?>"></div></li>
		<div class="cleaner h10"></div>
		<li class="ui-widget-content  ui-corner-all"  style="width:100%;"><div style="display: inline-block;"><button id="btnLanguages" class="btn-large waves-effect waves-light deep-purple darken-4" style='display: inline-block; cursor: pointer; width:100px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['Edit'];?></button><a href="<?php echo $php_self.'?page=languages'; ?>" ><?php echo $STR['Languages'];?></a></div><div id="status_Languages" class="float_r"><img src="<?php echo $COMMON->getMedia('icon', 'wait.gif');?>"></div></li>					
		<div class="cleaner h10"></div>
		<li class="ui-widget-content  ui-corner-all"  style="width:100%;"><div style="display: inline-block;"><button id="btnJobExperience" class="btn-large waves-effect waves-light deep-purple darken-4" style='display: inline-block; cursor: pointer; width:100px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['Edit'];?></button><a href="<?php echo $php_self.'?page=laborexperience'; ?>" ><?php echo $STR['JobExperience'];?></a></div><div id="status_JobExperience" class="float_r"><img src="<?php echo $COMMON->getMedia('icon', 'wait.gif');?>"></div></li>
		<div class="cleaner h10"></div>
		<li class="ui-widget-content  ui-corner-all"  style="width:100%;"><div style="display: inline-block;"><button id="btnExpectatives" class="btn-large waves-effect waves-light deep-purple darken-4" style='display: inline-block; cursor: pointer; width:100px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['Edit'];?></button><a href="<?php echo $php_self.'?page=expectatives'; ?>" ><?php echo $STR['Expectatives'];?></a></div><div id="status_Expectatives" class="float_r"><img src="<?php echo $COMMON->getMedia('icon', 'wait.gif');?>"></div></li>
	</ul>
</div>
<div class="cleaner h40"></div>
<h6><?php echo $STR['JobsFiltered']; ?></h6>
<div class="cleaner h10"></div>
<table id="tblRecorded"></table>	

</div> <!-- end of main -->
<div class="cleaner h40"></div>