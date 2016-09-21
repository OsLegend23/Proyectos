<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>        
<div class="cleaner h10"></div>
        
<div id="templatemo_main">

	<div class="cleaner h10"></div>
	<button id="btnAddNew" class="btn-large waves-effect waves-light deep-purple darken-4" style='float: right; display: inline-block; cursor: pointer;width:35%; height:45px; text-align:center;'><?php echo $STR['AddInterviewDate'];?></button>
	<div class="cleaner h10"></div>

	<?php $gForm->show();?>
	<div class="cleaner h20"></div>
	<table id="tblRecorded"></table>
</div> <!-- end of main -->
<div class="cleaner h40"></div>

<div id="dialog_addNew_selecttype" style="display: none;"  width="900" height="490">
        <div class="ui-widget-content  ui-corner-all" style="padding-top:10px; height:100px; text-align:center;">
              
        </div>
        <div class="ui-corner-all" style="text-align:right; padding: 5px;">
            <fieldset class='formActionButtons ui-widget ui-corner-all'>
                <div id='msessage_share' style='width:50%; float:left; display:inline-block;'></div>
                <button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnConfirmation_Yes" style='display: inline-block; cursor: pointer; width:150px; height:45px; text-align:center;'><?php echo $STR['Yes'];?></button>
		<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnConfirmation_No" style='display: inline-block; cursor: pointer; width:150px; height:45px; text-align:center;'><?php echo $STR['No'];?></button>
            </filedset>                
        </div>
</div>

<div id="dialog_addNew_interviewdate" style="display: none;"  width="900" height="490">
        <?php 
			$gFormInterview->show();
        ?>
</div>