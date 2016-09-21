<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>        
<div class="cleaner h10"></div>
        
<div id="templatemo_main">

<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnGetPortalInfo" style='display: inline-block; cursor: pointer; width:340px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:right;'><?php echo $STR['getPortalInfo'];?></button>	
<div class="cleaner h10"></div>
<fieldset class="boxshadow" style="padding:10px; margin-bottom:10px;">				    	
	    <legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['Postulants']; ?></legend>	    
	    <div style="display: inline-block;  width:100%;">
		    <div class="cv-field"><?php echo $STR['TotalPostulants'];?></div><div class="cv-data" id="totalPostulants"></div><div class="cleaner"></div>
		    <div class="cv-field"><?php echo $STR['TotalAutenticated'];?></div><div class="cv-data" id="totalAutenticated"></div><div class="cleaner"></div>
		    <div class="cv-field"><?php echo $STR['TotalUnAutenticate'];?></div><div class="cv-data" id="totalUnAutenticate"></div><div class="cleaner"></div>
	    	<div class="cv-field"><?php echo $STR['UnVerified'];?></div><div class="cv-data" id="unVerified"></div><div class="cleaner"></div>
	    </div>
</fieldset>
<div class="cleaner h20"></div>
<fieldset class="boxshadow" style="padding:10px; margin-bottom:10px;">				    	
	    <legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['Companies']; ?></legend>	    
	    <div style="display: inline-block;  width:100%;">
		    <div class="cv-field"><?php echo $STR['TotalCompanies'];?></div><div class="cv-data" id="totalCompanies"></div><div class="cleaner"></div>
		    <div class="cv-field"><?php echo $STR['TotalAutenticated'];?></div><div class="cv-data" id="totalAutenticatedCompanies"></div><div class="cleaner"></div>
		    <div class="cv-field"><?php echo $STR['TotalUnAutenticate'];?></div><div class="cv-data" id="totalUnAutenticateCompanies"></div><div class="cleaner"></div>
		    <div class="cv-field"><?php echo $STR['UnVerified'];?></div><div class="cv-data" id="unVerifiedCompanies"></div><div class="cleaner"></div>
	    </div>
</fieldset>


<fieldset class="boxshadow" style="padding:10px; margin-bottom:10px;">				    	
	    <legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['HitsCounter']; ?></legend>	    
	    <div style="display: inline-block;  width:100%;">
		    <div class="cv-field"><?php echo $STR['TotalHitsCounter'];?></div><div class="cv-data" id="totalHitsCounter"></div><div class="cleaner"></div>
		    <div class="cleaner h20"></div>

<table id="tableHitsCounter" width="100%" border="0" cellpadding="1" cellspacing="1" class="elmts">
  <thead>
  <tr>
  	<th><?php echo $STR['Year'];?></th>
    <th><?php echo $monthFull['1'];?></th>
    <th><?php echo $monthFull['2'];?></th>
    <th><?php echo $monthFull['3'];?></th>
    <th><?php echo $monthFull['4'];?></th>
    <th><?php echo $monthFull['5'];?></th>
    <th><?php echo $monthFull['6'];?></th>
    <th><?php echo $monthFull['7'];?></th>
    <th><?php echo $monthFull['8'];?></th>
    <th><?php echo $monthFull['9'];?></th>
    <th><?php echo $monthFull['10'];?></th>
    <th><?php echo $monthFull['11'];?></th>
    <th><?php echo $monthFull['12'];?></th>
    <th><?php echo $STR['TotalHitsCounter'];?></th>
  </tr>
  </thead>
  <tbody>
  </tbody>	
</table> 
	</div>
</fieldset>


<div class="cleaner h20"></div>
<fieldset class="boxshadow" style="padding:10px; margin-bottom:10px;">				    	
	    <legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['Vacancies']; ?></legend>	    
	    <div style="display: inline-block;  width:100%;">
		    <div class="cv-field"><?php echo $STR['TotalVacancies'];?></div><div class="cv-data" id="totalVacancies"></div><div class="cleaner"></div>
		    
		<table id="tableTopPublicated" width="100%" border="0" cellpadding="1" cellspacing="1" class="elmts">
		  <thead>
		  <tr>
		    <th width="51%" scope="col"><?php echo $STR['TradeName'];?></th>
		    <th width="49%" scope="col"><?php echo $STR['TotalVacancies'];?></th>
		  </tr>

		</thead>
		  <tbody>
		  </tbody>
		</table>


		</div>
</fieldset>

</div> <!-- end of main -->
<div class="cleaner h40"></div>