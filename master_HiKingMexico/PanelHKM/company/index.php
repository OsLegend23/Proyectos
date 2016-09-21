<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>
<div class="cleaner h10"></div>        
<div id="templatemo_main">

<fieldset class="boxshadow">				    		    	    
		<div class="cv-field"><?php echo $STR['CompanyEmailAutenticate'];?></div><div class="cv-data" id="divEmailAutenticate" >
		<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnEmailAutenticate" style='display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:left;'><?php if($autenticated) echo $STR['Autentication_success']; else echo $STR['Autenticate']; ?></button></div><div class="cleaner"></div>
	    <div class="cv-field"><?php echo $STR['CompanyInfoVerified'];?></div><div class="cv-data" id="divInfoVerified" >
	    <button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnInfoVerified" style='display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:left;'><?php if($verified) echo $STR['Verificated_success']; else echo $STR['Verify']; ?></button></div><div class="cleaner h20"></div>
	    <div class="cv-field"><?php echo $STR['ChangeAccountStatus'];?></div><div class="cv-data" id="divChangeStatus" >
	    <button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnChangeStatus" style='display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:left;'><?php if($statusAccount) echo $STR['DisableAccount']; else echo $STR['EnableAccount']; ?></button></div><div class="cleaner"></div>
</fieldset>

<div class="cleaner h20"></div>
<fieldset class="boxshadow">				    	
	    <legend style="font-size: 18px; background-color:#FFF; padding:5px;"><?php echo $STR['Company']; ?></legend>
	    <div style="display: inline-block;  width:25%; margin:19px;">
			<img src="<?php echo $photoCompany; ?>" >
	    </div>
	    <div style="display: inline-block;  width:70%;">
	    <div class="cv-field"><?php echo $STR['TradeName'];?></div><div class="cv-data"><?php echo $tradeName; ?></div><div class="cleaner"></div>
	    <div class="cv-field"><?php echo $STR['UserName'];?></div><div class="cv-data cv-bgline"><?php echo $userName; ?></div><div class="cleaner"></div>
	    <div class="cv-field "><?php echo $STR['Email'];?></div><div class="cv-data "><?php echo $email; ?></div><div class="cleaner"></div>
	    <div class="cv-field"><?php echo $STR['Location'];?></div><div class="cv-data cv-bgline"><?php echo $location; ?></div><div class="cleaner"></div>
	    <div class="cv-field"><?php echo $STR['Phone'];?></div><div class="cv-data"><?php echo $phone; ?></div><div class="cleaner"></div>
	    <div class="cv-field"><?php echo $STR['Mobil'];?></div><div class="cv-data cv-bgline"><?php echo $mobil; ?></div><div class="cleaner"></div>
	    </div>
</fieldset>
<div class="cleaner h20"></div>
<fieldset>
<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnCompanyActualPlan" style='display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:right;'><?php echo $STR['AnnualPlans'];?></button>
<div id="" class="boxshadow" style="padding:10px; margin-bottom:10px;">
	<p id="" style="font-size: 16px;"><strong><?php echo $STR['AsignedPlanInfo']; ?></strong></p>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr bgcolor="#CCCCCC">
	    <td class="cv-field"><?php echo $STR['RequestStatus']; ?></td>
	    <td class="cv-data"><?php echo $status;?></td>
	  </tr>
	  <tr>
	    <td class="cv-field"><?php echo $STR['RequestCreationDate']; ?></td>
	    <td class="cv-data"><?php echo $creationdate;?></td>
	  </tr>
	  <tr bgcolor="#CCCCCC">
	    <td  class="cv-field" width="233"><?php echo $STR['RequestPlanName']; ?></td>
	    <td width="382" class="cv-data" ><?php echo $planname;?></td>
	  </tr>
	  <tr>
	    <td class="cv-field"><?php echo $STR['PostsCost']; ?></td>
	    <td class="cv-data"><?php echo $postcost;?></td>
	  </tr>
	  <tr bgcolor="#CCCCCC">
	    <td class="cv-field"><?php echo $STR['AnnualPosts']; ?></td>
	    <td class="cv-data"><?php echo $posts;?></td>
	  </tr>
	  <tr>
	    <td class="cv-field"><?php echo $STR['DateIn']; ?></td>
	    <td class="cv-data"><?php echo $initialperiod;?></td>
	  </tr>
	  <tr bgcolor="#CCCCCC">
	    <td class="cv-field"><?php echo $STR['DateOut']; ?></td>
	    <td class="cv-data"><?php echo $periodended;?></td>
	  </tr>
	</table>	
</div>
</fieldset>
<div class="cleaner h10"></div>
<button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnAddVacancy" style='display: inline-block; cursor: pointer; width:240px; height:35px; text-align:center; margin:3px 5px 3px 3px; float:right;'><?php echo $STR['AddVacancy'];?></button>
<div class="cleaner h10"></div>	
	<?php $gForm->show();?>
	<table id="tblRecorded"></table>
</div> <!-- end of main -->
<div class="cleaner h40"></div>