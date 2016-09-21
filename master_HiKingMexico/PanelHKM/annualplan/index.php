<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>        
<div class="cleaner h10"></div>
        
<div id="templatemo_main">
    <button id="addNew" class="btn-large waves-effect waves-light deep-purple darken-4" style='float: right; display: inline-block; cursor: pointer;width:35%; height:45px; text-align:center;'><?php echo $STR['AddNewAnnualPlan'];?></button>
    <div class="cleaner h10"></div>	
	<table id="tblRecorded"></table>

	<div class="cleaner h40"></div>
		<?php $gForm->show();?>
	
</div> <!-- end of main -->
<div class="cleaner h40"></div>