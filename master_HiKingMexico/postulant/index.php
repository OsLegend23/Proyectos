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

if($boss->getAccountType() == $GLOBAL['user_administrator']['value'])
{
	$ptl = $COMMON->getEscapeString($_REQUEST['ptl']);
	
	if( isset($ptl) && is_numeric($ptl) )
	{
		$boss->setUserId($ptl);
		$accountId = $ptl;
	}
	else
	{
		/*$_SESSION['enlaceemp_userid']*/
		$accountId = $boss->getUserId();
	}

	
		
}
else
	$accountId = $_SESSION['enlaceemp_accountid'];

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
		$menuSelectedId = $viewpage;
		if($viewpage == 'academicstudies' || $viewpage == 'informatic' || $viewpage == 'knowledge' || $viewpage == 'languages')
			$menuSelectedId = 'studies';
		
		if(!isset($_REQUEST['print']))
		{
		?>
		getMenuSelected('<?php echo $menuSelectedId;?>');

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
			    data: 			{ 'opt': 'sendPostulantAutentication'}
			};			

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

				<li id='studies'><a class="sub" href="" ><b><?php echo $STR['Studies'];?></b></a>
					<ul class="sub2">
						<li id='academicstudies'><a href="<?php echo $php_self.'?page=academicstudies'; ?>" ><?php echo $STR['Academic'];?></a></li>
						<li id='informatic'><a href="<?php echo $php_self.'?page=informatic'; ?>" ><?php echo $STR['Informatic'];?></a></li>
						<li id='knowledge'><a href="<?php echo $php_self.'?page=knowledge'; ?>" ><?php echo $STR['Knowledge'];?></a></li>
						<li id='languages'><a href="<?php echo $php_self.'?page=languages'; ?>" ><?php echo $STR['Languages'];?></a></li>
					</ul>
				
				</li>

				<li id='laborexperience'><a href="<?php echo $php_self.'?page=laborexperience'; ?>" ><b><?php echo $STR['Laborexperience'];?></b></a></li>
				<li id='expectatives'><a href="<?php echo $php_self.'?page=expectatives'; ?>" ><b><?php echo $STR['Expectatives'];?></b></a></li>
				<li id='listpostulation'><a href="<?php echo $php_self.'?page=listpostulation'; ?>" ><b><?php echo $STR['InterviewTracking'];?></b></a></li>
				<li id='cvitae'><a href="<?php echo $php_self.'?page=cvitae'; ?>" ><b><?php echo $STR['CV'];?></b></a></li>
				
			</ul>
	</div>
<div id="notifications" class="ui-widget">

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