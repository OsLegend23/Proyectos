<?php
/*
/controlpanel/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

if($rGetPostulation->size() == 0 )
{
?>
	<div class="cleaner h10"></div>
	<div style="text-align:center;" class="ui-widget-content ui-corner-all">
	<p>
		<?php echo $STR['InfoNotFound'];?>
	</p>
	<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnReturn" style='display: inline-block; cursor: pointer; width:150px; height:45px; text-align:center;'><?php echo $STR['Return'];?></button>
	</div>

<?php 
	die();
}
?>

<?php 
if(!isset($_REQUEST['print']))
{
?>
<div id="formButtons" style="text-align: right; margin-top: 25px; margin-right: 10px;">
	<button id="btnPrint" class="btn-large waves-effect waves-light deep-purple darken-4" style='display: inline-block; cursor: pointer; width:150px; height:45px; text-align:center;'><?php echo $STR['Print'];?></button>
</div>
<?php 
}
?>


	<?php include('cvitae.template.php'); ?>		
<?php 
if(!isset($_REQUEST['print']))
{
?>
<div id="formButtons" style="text-align: right; margin-bottom: 25px; margin-right: 10px;">
	<button id="btnPrint" class="btn-large waves-effect waves-light deep-purple darken-4" style='display: inline-block; cursor: pointer; width:150px; height:45px; text-align:center;'><?php echo $STR['Print'];?></button>
</div>
<?php 
}
?>	