<?php
/*
/main/index.php
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
<div class="cleaner h10"></div>
        
<div id="templatemo_main">
            
<div id="box_vacancy_center_left" class="ui-corner-all vacancy_tracking_info boxshadow">
	<div style="display: inline-block; width: 50%; margin-top:0px; float:left;">
		<div class="v-header"> <?php echo $STR['ReferenceCode'];?></div>
		<div class="v-field" id="v_strReferenceCode"> <?php echo $rData['id'];?></div>		
		<div class="v-header"> <?php echo $STR['VacancyName'];?></div>
		<div class="v-field" id="v_strReferenceCode"> <?php echo $rData['tx_name'];?></div>		
		<div class="v-header"> <?php echo $STR['Location'];?></div>
		<div class="v-field" id="v_strLocation"> <?php echo $rData['tx_city'].' '.$rData['tx_state'];?></div>		
	</div>

	<div style="display: inline-block; width: 40%; margin:0px;">
		<div class="v-header"> <?php echo $STR['Status'];?></div>
		<div class="v-field" id="v_strVacancyType"> <?php echo $rData['vacanty_status_tx_description'];?></div>
		<div class="v-header"> <?php echo $STR['PublicationDate'];?></div>
		<div class="v-field" id="v_strReferenceCode"> <?php echo $COMMON->getDateFormat($rData['dt_registry']);?></div>
		<div class="v-header"> <?php echo $STR['VacancyType'];?></div>
		<div class="v-field" id="v_strVacancyType"> <?php echo $rData['vacancy_type_tx_description'];?></div>				
	</div>
</div>
<div class="cleaner h20"></div>	
<?php $gForm->show();?>
<div class="cleaner h20"></div>
<table id="tblRecorded"></table>

</div> <!-- end of main -->
<div class="cleaner h40"></div>