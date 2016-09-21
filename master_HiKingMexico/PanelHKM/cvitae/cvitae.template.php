<?php
//..\cvitae\cvitae.php
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='http://www.hikingmexico.com',0)></body>";die();}
?>

<div class="">


<div class=""  style="float:right; width:100%;">
				    <fieldset>				    	
				    <legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['AccountData']; ?></legend>
				    <div style="display: inline-block;  width:15%; margin:19px;">
						<img src="<?php echo $postulantPhoto; ?>" style="float:left;">
				    </div>
				    <div style="display: inline-block;  width:80%;">
				    <div class="cv-field"><?php echo $STR['Name'];?></div><div class="cv-data"><?php echo $Name; ?></div><div class="cleaner"></div>
				    <div class="cv-field cv-bgline"><?php echo $STR['BornDate'];?></div><div class="cv-data cv-bgline"><?php echo $BornDate; ?></div><div class="cleaner"></div>
				    <div class="cv-field"><?php echo $STR['Gender'];?></div><div class="cv-data"><?php echo $Gender;?></div><div class="cleaner"></div>
				    <div class="cv-field cv-bgline"><?php echo $STR['RFC'];?></div><div class="cv-data cv-bgline"><?php echo $RFC; ?></div><div class="cleaner"></div>				    
				    <div class="cv-field"><?php echo $STR['Location'];?></div><div class="cv-data"><?php echo $ActualAddress; ?></div><div class="cleaner"></div>				    
				    <div class="cv-field cv-bgline"><?php echo $STR['Phone'];?></div><div class="cv-data cv-bgline"><?php echo $Phone; ?></div><div class="cleaner"></div>
				    <div class="cv-field"><?php echo $STR['Mobil'];?></div><div class="cv-data"><?php echo $Mobil; ?></div><div class="cleaner"></div>				    
				    <div class="cv-field cv-bgline"><?php echo $STR['Email'];?></div><div class="cv-data cv-bgline"><?php echo $Email; ?></div><div class="cleaner"></div>
				    </div>
				    </fieldset>
</div>
			<div class="cleaner h10"></div>
			<fieldset>
			<legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['Laborexperience']; ?></legend>
<?php
			while ($row = $rGetPostulant_Experience->fetch()) 
			{

			$TradeName				= $row['tx_tradename'];			
			$WorkArea				= $row['workarea_tx_description'];
			$JobTitle				= $row['tx_jobtitle'];			
			$Hierarchy				= $row['id_hierarchy'] != -1 ? $STR['HierarchyLevelList'][$row['id_hierarchy']]: $STR['NotSpecificated'];

			if($row['ch_isactualwork'] == 'S')
				$WorkPeriod				= $STR['ActualWork'] ;
			else
				$WorkPeriod				= $monthFull[$row['dt_startdatemonth']].' '.$STR['From'].' '.$row['dt_startdateyear'].' '.$STR['Until'].' '.$monthFull[$row['dt_enddatemonth']].' '.$STR['From'].' '.$row['dt_enddateyear'];
			
			$ActivityDescription	= $row['tx_activitydetail'];
?>
				    
			<br/>	    	    
			<div style="margin-left:20px;">
				    <div class="ui-widget-content ui-corner-all cv-header"><?php echo $TradeName.', '.$WorkPeriod;?></div><div class="cleaner"></div>
				    <div class="cv-field cv-bgline" style=""><?php echo $STR['WorkArea'];?></div><div class="cv-data cv-bgline" style=""><?php echo $WorkArea;?></div><div class="cleaner"></div>
				    <div class="cv-field" style=""><?php echo $STR['JobTitle'];?></div><div class="cv-data" style=""><?php echo $JobTitle;?></div><div class="cleaner"></div>
				    <div class="cv-field cv-bgline" style=""><?php echo $STR['Hierarchy'];?></div><div class="cv-data cv-bgline" style=""><?php echo $Hierarchy; ?></div><div class="cleaner"></div>				    				    
				    <div class="cv-field" style=""><?php echo $STR['ActivityDescription'];?></div><div class="cv-data" style=""><?php echo $ActivityDescription; ?></div><div class="cleaner"></div>
			</div>
			<div class="cleaner"></div>
<?php
			}
?>
			</fieldset>
			<div class="cleaner h10"></div>
			<fieldset>
			<legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['Studies']; ?></legend>
<?php
			while ($row = $rGetPostulant_studies->fetch()) 
			{
			
			$InstitutionName 		= $row['studylevel_tx_description'].', '.$row['tx_institution'];
			$StudyArea 				= isset($row['studyarea_tx_description'])? $row['studyarea_tx_description']:$row['tx_graduate'];
			$ActualStatus 			= $STR['StatusStudies'][$row['ch_status']];			
			$StudiesComment	 		= $row['tx_comment'];

			if($row['ch_status'] == 'C')
				$StudyPeriod		= $STR['ActualStudy'];
			else
				$StudyPeriod		= $monthFull[$row['dt_startdatemonth']].' '.$STR['From'].' '.$row['dt_startdateyear'].' '.$STR['Until'].' '.$monthFull[$row['dt_enddatemonth']].' '.$STR['From'].' '.$row['dt_enddateyear'];
?>			
			<br/>	    	    
			<div style="margin-left:20px;">
				    <div class="ui-widget-content ui-corner-all cv-header"><?php echo $InstitutionName.', '.$StudyPeriod;?></div><div class="cleaner"></div>
				    <div class="cv-field"><?php echo $STR['StudyArea'];?></div><div class="cv-data"><?php echo $StudyArea;?></div><div class="cleaner"></div>
				    <div class="cv-field cv-bgline"><?php echo $STR['ActualStatus'];?></div><div class="cv-data cv-bgline"><?php echo $ActualStatus;?></div><div class="cleaner"></div>
				    <div class="cv-field"><?php echo $STR['Comment'];?></div><div class="cv-data"><?php echo $StudiesComment;?></div><div class="cleaner"></div>
			</div>
			<div class="cleaner"></div>
<?php
			}
?>			
			</fieldset>
			<div class="cleaner h10"></div>
			
			<fieldset>
			<legend style="font-size: 18px; background-color:#FFF; padding:5px; background-color:#FFF; padding:5px;"><?php echo $STR['Informatic']; ?></legend>
<?php
			while ($row = $rGetPostulant_informatic->fetch()) 
			{
				$SoftwareType			= $row['software_tx_description'];
				$SoftwareName			= $row['tx_softwarename'];
				$Domain					= $STR['DomainList'][$row['ch_domain']];
				$SoftwareComment		= $row['postulant_informatic_tx_description'];
?>		
			<br/>	    	    
			<div style="margin-left:20px;">
			    <div class="ui-widget-content ui-corner-all  cv-header"><?php echo $SoftwareType;?></div><div class="cleaner"></div>
			    <div class="cv-field"><?php echo $STR['SoftwareName'];?></div><div class="cv-data"><?php echo $SoftwareName;?></div><div class="cleaner"></div>
			    <div class="cv-field cv-bgline"><?php echo $STR['Domain'];?></div><div class="cv-data cv-bgline"><?php echo $Domain;?></div><div class="cleaner"></div>
			    <div class="cv-field"><?php echo $STR['SoftwareComment'];?></div><div class="cv-data"><?php echo $SoftwareComment;?></div><div class="cleaner"></div>
			</div>
			<div class="cleaner"></div>
<?php
			}
?>			
			</fieldset>
			<div class="cleaner h10"></div>
			<fieldset>
			<legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['Knowledge']; ?></legend>
<?php
			while ($row = $rGetPostulant_knowledge->fetch()) 
			{
			
			$KnowledgeName			= $row['tx_knowledgename'];
			$Domain					= $STR['DomainList'][$row['ch_domain']];
			$Description 			= $row['postulant_knowledge_tx_description'];
?>			
			<br/>	    	    
			<div style="margin-left:20px;">
				    <div class="ui-widget-content ui-corner-all  cv-header"><?php echo $KnowledgeName;?></div><div class="cleaner"></div>				    
				    <div class="cv-field cv-bgline"><?php echo $STR['Domain'];?></div><div class="cv-data cv-bgline"><?php echo $Domain;?></div><div class="cleaner"></div>
				    <div class="cv-field  cv-bgline"><?php echo $STR['Description'];?></div><div class="cv-data"><?php echo $Description;?></div><div class="cleaner"></div>
			</div>
			<div class="cleaner"></div>
<?php
			}
?>
			</fieldset>
			<div class="cleaner h10"></div>
			<fieldset>
			<legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['Language']; ?></legend>	    
<?php
			$toeflScore = 0;
			while ($row = $rGetPostulant_language->fetch()) 
			{	

				$LanguageName	= $row['language_tx_description'];
				$SpeakDomain	= $row['nm_speak'];
				$ReadDomain		= $row['nm_read'];
				$WriteDomain	= $row['nm_write'];
?>			
			<br/>	    	    
			<div style="margin-left:20px;">
				    <div class="ui-widget-content ui-corner-all  cv-header"><?php echo $LanguageName;?></div><div class="cleaner"></div>				    
				    <div class="cv-field"><?php echo $STR['SpeakDomain'];?></div><div class="cv-data"><?php echo $SpeakDomain;?>%</div><div class="cleaner"></div>
				    <div class="cv-field cv-bgline"><?php echo $STR['ReadDomain'];?></div><div class="cv-data cv-bgline"><?php echo $ReadDomain;?>%</div><div class="cleaner"></div>
				    <div class="cv-field"><?php echo $STR['WriteDomain'];?></div><div class="cv-data"><?php echo $WriteDomain;?>%</div><div class="cleaner"></div>
			</div>
			<div class="cleaner"></div>
<?php
			}
			if($$TOEFLScore > 0)
			{
?>
			<br><br>
			<div style="margin-left:20px;">
			<div class="ui-widget-content ui-corner-all  cv-header"><?php echo $STR['TOEFL'];?></div><div class="cleaner"></div>
			<div class="cv-field"><?php echo $STR['TOEFLScore'];?></div><div class="cv-data"><?php echo $TOEFLScore;?></div><div class="cleaner"></div>
			</div>
			<div class="cleaner"></div>
			</fieldset>

<?php
			}
?>			
			<div class="cleaner h10"></div>
			<fieldset>
			<legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['Expectatives']; ?></legend>	    
			<br/>	    	    
			<div style="margin-left:20px;">							    
				    <div class="cv-field"><?php echo $STR['HierarchyLevel'];?></div><div class="cv-data"><?php echo $HierarchyLevel;?></div><div class="cleaner"></div>
				    <div class="cv-field cv-bgline"><?php echo $STR['HomeChange'];?></div><div class="cv-data cv-bgline"><?php echo $HomeChange;?></div><div class="cleaner"></div>
				    <div class="cv-field"><?php echo $STR['WorkCompleteTime'];?></div><div class="cv-data"><?php echo $WorkCompleteTime;?></div><div class="cleaner"></div>
				    <div class="cv-field cv-bgline"><?php echo $STR['WorkMiddleTime'];?></div><div class="cv-data cv-bgline"><?php echo $WorkMiddleTime;?></div><div class="cleaner"></div>
				    <div class="cv-field"><?php echo $STR['Workfees'];?></div><div class="cv-data"><?php echo $Workfees;?></div><div class="cleaner"></div>
				    <div class="cv-field cv-bgline"><?php echo $STR['WorkTemp'];?></div><div class="cv-data cv-bgline"><?php echo $WorkTemp;?></div><div class="cleaner"></div>
				    <div class="cv-field"><?php echo $STR['WantMoney'];?></div><div class="cv-data">$ <?php echo $WantMoney;?></div><div class="cleaner"></div>
				    <div class="cv-field cv-bgline"><?php echo $STR['Comment'];?></div><div class="cv-data"><?php echo $ExpectativesComment;?></div><div class="cleaner"></div>
			</div>
			<div class="cleaner"></div>
			</fieldset>
</div>
<div class="cleaner"></div>