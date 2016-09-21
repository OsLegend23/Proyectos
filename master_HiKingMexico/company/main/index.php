<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>        
<div class="cleaner h10"></div>        
<div id="templatemo_main">
<div class="float_l cbox_large530">
	<?php $gForm->show();?>
</div>

<div class="cbox_small400 float_r">
	
	<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnCompanyActualPlan" style='display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['AnnualPlans'];?></button>
	<div class="cleaner"></div>
	<div class="ui-widget-content ui-corner-all">
		<?php echo $COMMON->str_replace($STR['CompanyActualPlan'], $companyPlanParams);?>
	</div>
	<div class="cleaner h10"></div>	
	<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnAddVacancy" style='display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['AddVacancy'];?></button>	
	<div class="ui-widget-content ui-corner-all" style="padding:10px;">
		<?php echo $COMMON->str_replace($STR['TotalPostedVacancies'], array('{totalPostedVacancies}'=>isset($rDataCountTotalVacancies['total'])? $rDataCountTotalVacancies['total']:0) );?>		
	</div>
	<div class="cleaner h10"></div>
	<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnPublicatedVacancies" style='display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['InterviewTracking'];?></button>
	<div class="cleaner"></div>	
	<div class="ui-widget-content ui-corner-all" style="padding:10px;">
		<?php echo $COMMON->str_replace($STR['PostulationWithOutEvaluation'], array('{totalPostulations}'=>$rGetPostulation->size() ) );?>
	</div>

</div>

<div class="cleaner h40"></div>
<table id="tblRecorded"></table>	

</div> <!-- end of main -->
<div class="cleaner h40"></div>