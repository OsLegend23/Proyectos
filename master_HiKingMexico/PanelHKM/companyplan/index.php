<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>
<div class="cleaner h20"></div>
<fieldset>				    	
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
<div class="cleaner h10"></div>        
<div id="templatemo_main">    
	<table id="tblRequest"></table>	
    <div class="cleaner h40"></div>	
	<table id="tblRecorded"></table>
</div> <!-- end of main -->
<div class="cleaner h40"></div>

<div id="dialog_plan" style="display: none;"  width="700" height="400">        
    <div class="overlay" id="modalOverlay" style="display:none;"></div>
<div id="requestPlan" class="boxshadow" style="padding:10px; margin-bottom:10px;">
	<p id="" style="font-size: 16px;"><strong><?php echo $STR['RequestPlanInfo']; ?></strong></p>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td><?php echo $STR['RequestCode']; ?></td>
	    <td id="requestCode"></td>
	  </tr>
	  <tr bgcolor="#CCCCCC">
	    <td><?php echo $STR['RequestStatus']; ?></td>
	    <td id="requestStatus"></td>
	  </tr>
	  <tr>
	    <td><?php echo $STR['RequestCreationDate']; ?></td>
	    <td id="requestCreationDate"></td>
	  </tr>
	  <tr bgcolor="#CCCCCC">
	    <td width="233"><?php echo $STR['RequestPlanName']; ?></td>
	    <td width="382" id="requestPlanName" ></td>
	  </tr>
	  <tr>
	    <td><?php echo $STR['PostsCost']; ?></td>
	    <td id="cpostsCost" ></td>
	  </tr>
	  <tr bgcolor="#CCCCCC">
	    <td><?php echo $STR['AnnualPosts']; ?></td>
	    <td id="cannualPosts" ></td>
	  </tr>
	  <tr>
	    <td><?php echo $STR['RequestComment']; ?></td>
	    <td id="requestComment" ></td>
	  </tr>
	</table>	
</div>
<div id="assignedPlan" class="boxshadow" style="padding:10px; margin-bottom:10px;">
	<p id="" style="font-size: 16px;"><strong><?php echo $STR['AsignedPlanInfo']; ?></strong></p>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td><?php echo $STR['RequestCode']; ?></td>
	    <td id="assignedCode"></td>
	  </tr>
	  <tr bgcolor="#CCCCCC">
	    <td><?php echo $STR['RequestStatus']; ?></td>
	    <td id="assignedStatus"></td>
	  </tr>
	  <tr>
	    <td><?php echo $STR['RequestCreationDate']; ?></td>
	    <td id="assignedCreationDate"></td>
	  </tr>
	  <tr bgcolor="#CCCCCC">
	    <td width="233"><?php echo $STR['RequestPlanName']; ?></td>
	    <td width="382" id="assignedPlanName" ></td>
	  </tr>
	  <tr>
	    <td><?php echo $STR['PostsCost']; ?></td>
	    <td id="assignedCost" ></td>
	  </tr>
	  <tr bgcolor="#CCCCCC">
	    <td><?php echo $STR['AnnualPosts']; ?></td>
	    <td id="assignedPosts" ></td>
	  </tr>
	  <tr>
	    <td><?php echo $STR['DateIn']; ?></td>
	    <td id="assignedDateIn" ></td>
	  </tr>
	  <tr bgcolor="#CCCCCC">
	    <td><?php echo $STR['DateOut']; ?></td>
	    <td id="assignedDateOut" ></td>
	  </tr>
	</table>	
</div>
        <?php 
           $gForm->show();
        ?>
</div>