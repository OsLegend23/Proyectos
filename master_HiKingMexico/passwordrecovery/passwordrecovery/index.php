<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>        
<div class="cleaner h40"></div>
        
<div id="templatemo_main">
<?php 
if($rGetUser->size() == 0 )
{
?>
	<div class="cleaner h10"></div>
	<div style="text-align:center;" class="ui-widget-content ui-corner-all">
	<p>
		<?php echo $STR['PassRecoverNotFound'];?>
	</p>
	<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnReturn" style='display: inline-block; cursor: pointer; width:190px; height:45px; text-align:center;'><?php echo $STR['PassRecoverLbl'];?></button>
	</div>

<?php 
}
else
{
?>            
        <div id="" class="ui-widget-content ui-corner-all">
             <?php $gForm->show();?>
        </div> <!-- end of templatemo_middle -->
<?php
}
?>
</div> <!-- end of main -->
<div class="cleaner h40"></div>