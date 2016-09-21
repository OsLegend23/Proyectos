<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>        
<div class="cleaner h40"></div>
        
<div id="templatemo_main">
            
<div id="box_vacancy_center_left" class="ui-corner-all vacancy_box_center_left_print boxshadow">
	<div style="display: inline-block; width: 50%; margin-top:0px; float:left;">
		<div class="v-header"> <?php echo $STR['Company'];?></div>
		<div class="v-field" id="v_strCompany"><?php echo $STR['Company'];?></div>				
		<div class="v-header"> <?php echo $STR['Location'];?></div>
		<div class="v-field" id="v_strLocation"> <?php echo $STR['Location'];?></div>				
		<div class="v-header" id="v_strSector"> <?php echo $STR['SameAsCompany'];?></div>
		<div class="v-field" id="v_strActivity"> <?php echo $STR['SameAsCompany'];?></div>
	</div>

	<div style="display: inline-block; width: 40%; margin:0px;">
		<div class="v-header"> <?php echo $STR['VacancyType'];?></div>
		<div class="v-field" id="v_strVacancyType"> <?php echo $STR['VacancyType'];?></div>
		<div class="v-header"> <?php echo $STR['JobExperiencealone'];?></div>
		<div class="v-field" id="v_strJobExperiencealone"> <?php echo $STR['JobExperiencealone'];?></div>
		<div class="v-header"> <?php echo $STR['StudySpecs'];?></div>
		<div class="v-field" id="v_strStudySpecs"> <?php echo $STR['StudySpecs'];?></div>
		<div class="v-header"> <?php echo $STR['ReferenceCode'];?></div>
		<div class="v-field" id="v_strReferenceCode"> <?php echo $STR['ReferenceCode'];?></div>
	</div>

	<div id="formButtons" style='float: right; margin-right: 35px;'>		
		<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnAllInfo" style='display: inline-block; cursor: pointer; width:210px; height:45px; text-align:center;'><?php echo $STR['ViewAllInfo'];?></button>
	</div>

</div>

<div class="cleaner h30"></div>
<div style="margin-left:5px;"><h4><?php echo $STR['InterviewTracking'];?></h4></div>

		<div style="margin-left:5px; float:left; width:95px; text-align:center; padding-top:11px;" class="ui-corner-all ui-widget-content">
			<h1>1</h1>
		</div>
		<div style="margin-right: 12px; padding:5px; float:right; width:810px;" class="ui-corner-all ui-widget-content">

		<div class="v-header" style="display: inline-block;"><?php echo $STR['Status'].':';?></div> <div class="v-field" style="display: inline-block;"><?php echo $STR['TrackingStatus'][$postulationStatus]; ?></div>
		<div class="cleaner"></div>
		<div class="v-header" style="display: inline-block;"><?php echo $STR['Date'].':';?></div><div class="v-field" style="display: inline-block;"><?php echo $COMMON->getDateFormat($rData['dt_registry']); ?></div>
		<div class="cleaner"></div>
		<div class="v-header" style="display: inline-block;"><?php echo $STR['Comment'].':';?></div><div class="v-field" style="display: inline-block;"><?php echo $STR['WaitEvalutaion_comment']; ?></div>
		
</div>

</div> <!-- end of main -->
<div class="cleaner h40"></div>