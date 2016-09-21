<?php
/*
/main/index.php
*/
if(!isset($COMMON)){echo "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();}

?>        
<div class="cleaner h10"></div>
        
<div id="templatemo_main">
    <div class="ui-widget-content ui-corner-all list" style="padding:10px;">        
		<?php echo $COMMON->str_replace($STR['AnnualPlansHeaderComment'], array('{portalLink}'=>'<a href="'.$GLOBAL['domain-root'].'">'.$GLOBAL['site'].'</a>'  ) );?>
	</div>

	<div class="cleaner h40"></div>

	<div class="cbox_small float_l">
		<?php 
	    while ($row = $rGetAnnualPlan->fetch()) 
	    {                     
	    ?>
            <div class="fp_box">
				<h4><?php echo 'Plan Anual '.$row['tx_name'];?></h4>
                <?php echo $STR['AnnualPosts'].': '.$row['tx_description'];?>
                 <div class="cleaner h05"></div>
                <?php echo $STR['PostsCost'].': '.$row['tx_cost'];?>
                <div class="cleaner h05"></div>
                <a href="#" id="<?php echo $row['id'];?>" class="more float_r"><?php echo $STR['GetAnnualPlan'];?></a>
            </div>	            
            <div class="cleaner h10"></div>
	    <?php    
	    }
	    ?>
	</div>
	
	<div class="cbox_large  float_r">
		<div class="ui-widget-content ui-corner-all list"  style="padding:10px;">
			<?php echo $COMMON->str_replace($STR['AnnualPlansFooterComment'], array('{associatedMail}'=>'<a href="mailto:'.$GLOBAL['email_associated'].'">'.$GLOBAL['email_associated'].'</a>') );?>
		</div>
		
		<div class="cleaner h40"></div>
		<div class="ui-widget-content ui-corner-all" style="padding:10px;" id="companyPlanStatus">
			<?php echo $COMMON->str_replace($STR['CompanyActualPlan'], $companyPlanParams);?>
		</div>
		<div class="cleaner h40"></div>
		<?php $gForm->show();?>
	</div>

	
	
	
</div> <!-- end of main -->
<div class="cleaner h40"></div>