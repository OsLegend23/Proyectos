<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>        
<div class="cleaner h10"></div>
        
<div id="templatemo_main">  	
   	<div id="preview" style="display:none;">
		<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnGotoedit" style='display: inline-block; cursor: pointer; width:190px; height:45px; text-align:center; float:right;'><?php echo $STR['ReturnToEdit'];?></button>
		<div class="cleaner h10"></div>
		<?php include($COMMON->getRoot().'vacancy/vacancy/vacancy.template.php');?>
		<div class="cleaner h10"></div>
		<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnGotoedit" style='display: inline-block; cursor: pointer; width:190px; height:45px; text-align:center; float:right;'><?php echo $STR['ReturnToEdit'];?></button>
    </div>

   	<div id="edit">    	
    	<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnGotopreview" style='display: inline-block; cursor: pointer; width:190px; height:45px; text-align:center; float:right;'><?php echo $STR['Preview'];?></button>
		<div class="cleaner h10"></div>
    	<?php $gForm->show();?>
	</div>
    
</div> <!-- end of main -->
<div class="cleaner h40"></div>
<div style="display:none;"><textarea id="about_vf"><?php echo $rData['tx_about'];?></textarea></div>