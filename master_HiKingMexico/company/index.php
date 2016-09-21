<?php
/*
/index.php
*/
session_start();
include('../inc/common.inc.php');
include($COMMON->getBossSecurity());
include($COMMON->getMySQL());
include($COMMON->getQuery());
include($COMMON->getGenForm());
$db = new MySQL($GLOBAL['db_host'], $GLOBAL['db_user'], $GLOBAL['db_password'], $GLOBAL['db_name']);
$QUERY = new Query($db, $GLOBAL);

$accountId = $_SESSION['enlaceemp_accountid'];

$rGetCompanyPlan 				= $QUERY->getCompany_Plan("WHERE a.id_company = '".$accountId."' ORDER BY a.id DESC LIMIT 0,1");
$rDataCompanyPlan				= $rGetCompanyPlan->fetch();

$companyPlanParams = array(
			'{planName}' 			=> $rDataCompanyPlan['tx_planname']
			,'{statusPlan}' 		=> $GLOBAL['plan_status'][$rDataCompanyPlan['ch_status']]['label']
			,'{initialPeriod}' 		=> $COMMON->getDateFormat($rDataCompanyPlan['dt_initialperiod'])
			,'{periodEnded}' 		=> $COMMON->getDateFormat($rDataCompanyPlan['dt_periodended'])
);


$companyPlanStatus = $GLOBAL['plan_status'][$rDataCompanyPlan['ch_status']]['value'];

if($COMMON->getDaysBetweenDates($STR['CurrentDate'], $rDataCompanyPlan['dt_periodended']) < 0)
{
	$QUERY->updateCompany_Plan(array('ch_status'=>$GLOBAL['plan_outrange']['value']),"WHERE id_company = '".$accountId."' ");
	$companyPlanStatus = $GLOBAL['plan_outrange']['value'];
}


$viewpage = isset($_REQUEST['page'])?  $_REQUEST['page']: 'main';
include($viewpage.'/'.$viewpage.'.header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $GLOBAL['site'];?></title>
<link href="<?php echo $COMMON->getMedia('icon', $GLOBAL['icon']);?>" type="image/x-icon" rel="shortcut icon">
<?php
	include($viewpage.'/'.$viewpage.'.lib.php');
	$COMMON->getTool('css', 'mainmenu/mainmenu.css');
?>
<script type="text/javascript">

$(document.body).ready(function()
{	  
	<?php		
	if(!isset($_REQUEST['print']))
	{
	?>
		getMenuSelected('<?php echo $viewpage;?>');
	<?php 
	}
	else{
		echo "$('body').css({backgroundImage : 'url()' });";
		echo "window.print();";
	}
	?>

	$("#btnSendAutentication").live("click", function(e)
	{		
			var params = 
			{
				url: 			'<?php echo $COMMON->getRoot();?>remote.php',
				type: 			'post',
				dataType:      	'json',
			    data: 			{ 'opt': 'sendCompanyAutentication'}
			};

			tagId = 'btnSendAutentication';

			$.ajax({
			    type: params.type,
			    url: params.url,
			    data:params.data,
			    success: function(data)
			    {   
			    	closeOverlay();
					displayPrompt('#btnSendAutentication', data.msg, data.answer, false);					
					$('#PendingEmailVerify').fadeOut(4000);
			    },
			    error: function(x, t, m) { 
			        
			    },
			    fail: function() {
			        
			    },    
			    dataType: params.dataType     
			});
		
	});	

});

<?php
	include($viewpage.'/'.$viewpage.'.js.php');	
?>
</script>
</head>
<body>	
<?php
	if(!isset($_REQUEST['print']))
	{
?>	
<div id="templatemo_body_wrapper">
	<div id="templatemo_wrapper">
<?php	
	include($COMMON->getHeaderPage());
?>
	<div class="cleaner h50"></div>
	<div id="menuContainer-options">
			<ul id="menu" class="">
				<li id='main'><a href="<?php echo $php_self.'?page=main'; ?>" ><b><?php echo $STR['MyAccount'];?></b></a></li>
				<li id='personal'><a href="<?php echo $php_self.'?page=personal'; ?>" ><b><?php echo $STR['AccountData'];?></b></a></li>
				<li id='annualplan'><a href="<?php echo $php_self.'?page=annualplan'; ?>" ><b><?php echo $STR['AnnualPlans'];?></b></a></li>
				<li id='listvacancy'><a href="<?php echo $php_self.'?page=listvacancy'; ?>" ><b><?php echo $STR['PublicatedVacancies'];?></b></a></li>
				<li id='addvacancy'><a href="<?php echo $php_self.'?page=addvacancy'; ?>" ><b><?php echo $STR['AddVacancy'];?></b></a></li>
				<!-- <li id='interviewdate'><a href="<?php echo $php_self.'?page=interviewdate'; ?>" ><b><?php echo $STR['InterviewDate'];?></b></a></li> -->
				
			</ul>
	</div>

<div id="notifications" class="ui-widget">

<?php 
	if($_SESSION['enlaceemp_verified'] == $GLOBAL['Verified_NO'])
	{
?>	
	<div id="CompanyVerifiedAccount" class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p>			
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span><?php echo $COMMON->str_replace($STR['CompanyVerifiedAccount'], array('{userName}'=>$_SESSION['enlaceemp_accountname']) )?>
		</p>
	</div>
	<div class="cleaner h10"></div>
<?php 
	} 
?>

<?php 
	if($_SESSION['enlaceemp_signed'] == 0)
	{
?>	
	<div id="PendingEmailVerify" class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p>
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
			<?php echo $COMMON->str_replace($STR['PendingEmailVerify'], array('{userName}'=>$_SESSION['enlaceemp_accountname'], '{number}'=>$_SESSION['enlaceemp_remainingdays']) )?>
			<div class="cleaner h10"></div>
			<?php echo $COMMON->str_replace($STR['EmailVerifyForwarding'], array('{userEmail}'=>$_SESSION['enlaceemp_accountmail']) ); ?> <button class="btn-large waves-effect waves-light deep-purple darken-4" id="btnSendAutentication" style='display: inline-block; cursor: pointer; width:100px; height:35px; text-align:center; margin:3px 5px 3px 3px;'><?php echo $STR['Autentication'];?></button>
		</p>
	</div>
	<div class="cleaner h10"></div>
<?php 
	} 
?>

<?php 
	if($companyPlanStatus == $GLOBAL['plan_outrange']['value'])
	{
?>	
	<div id="PendingEmailVerify" class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p>
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
			<?php echo $COMMON->str_replace($STR['PlanOutRangeNotification'], array('{limitDate}'=>$COMMON->getDateFormat($rDataCompanyPlan['dt_periodended'])) ); ?>
		</p>
	</div>
	<div class="cleaner h10"></div>
<?php 
	} 
?>

<?php 
	if( $COMMON->getDaysBetweenDates($STR['CurrentDate'], $rDataCompanyPlan['dt_periodended']) > 0 &&  $COMMON->getDaysBetweenDates($STR['CurrentDate'], $rDataCompanyPlan['dt_periodended']) < 7 )
	{
?>	
	<div id="PendingEmailVerify" class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p>
			<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
			<?php echo $COMMON->str_replace($STR['PlanApproachesExpirationDate'], array('{limitDate}'=>$COMMON->getDateFormat($rDataCompanyPlan['dt_periodended'])) ); ?>
		</p>
	</div>
	<div class="cleaner h10"></div>
<?php 
	} 
?>


</div>

<?php
	} 
	include($viewpage.'/index.php');
?>

<?php 
	if(!isset($_REQUEST['print']))
	{
		include($COMMON->getFooterPage());
	}
?>
<?php 
	if(!isset($_REQUEST['print']))
	{
?>
    </div>
</div>

<?php
	}
?>
</body>
</html>