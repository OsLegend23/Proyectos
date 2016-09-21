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
		$menuSelectedId = $viewpage;
		if($viewpage == 'consultpostulant' || $viewpage == 'searchcandidate' || $viewpage == 'postulantreport' || $viewpage == 'postulantscrap')
			$menuSelectedId = 'postulantadmin';
		else if($viewpage == 'consultcompany' || $viewpage == 'addvacancy' || $viewpage == 'vacancyreport' || $viewpage == 'companyreport')
			$menuSelectedId = 'companyadmin';
		else if($viewpage == 'account' || $viewpage == 'sector' || $viewpage == 'areas' || $viewpage == 'vacancytype' || $viewpage == 'activity'||
				$viewpage == 'softwaretype' || $viewpage == 'lenguagelist' || $viewpage == 'studyarea' || $viewpage == 'studylevel' || $viewpage == 'annualplan')
			$menuSelectedId = 'catalog';

		?>
		getMenuSelected('<?php echo $menuSelectedId;?>');	  
		<?php 
		}
		else{
			echo "$('body').css({backgroundImage : 'url()' });";
			echo "window.print();";
		}
		?>
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
				<li id='publicitylist'><a href="<?php echo $php_self.'?page=publicitylist'; ?>" ><b><?php echo $STR['Publicity'];?></b></a></li>

				<li id='postulantadmin'><a class="sub" href="<?php echo $php_self.'?page=consultpostulant'; ?>" ><b><?php echo $STR['PostulantAdmin'];?></b></a><!--<![endif]-->
				
					<ul class="sub2">
						<li id='consultpostulant'><a href="<?php echo $php_self.'?page=consultpostulant'; ?>" ><?php echo $STR['ConsultPostulant'];?></a></li>
						<li id='searchcandidate'><a href="<?php echo $php_self.'?page=searchcandidate'; ?>" ><?php echo $STR['SearchCandidate'];?></a></li>
						<li id='postulantscrap'><a href="<?php echo $php_self.'?page=postulantscrap'; ?>" ><?php echo $STR['PostulantScrap'];?></a></li>
						<li id='postulantreport'><a href="<?php echo $php_self.'?page=postulantreport'; ?>" ><?php echo $STR['PostulantReport'];?></a></li>			
					</ul>
				
				</li>

				<li id='companyadmin'><a class="sub" href="<?php echo $php_self.'?page=consultcompany'; ?>" ><b><?php echo $STR['CompanyAdmin'];?></b></a><!--<![endif]-->
				
					<ul class="sub2">
						<li id='requestplan'><a href="<?php echo $php_self.'?page=requestplan'; ?>" ><?php echo $STR['RequestAnnualPlan'];?></a></li>						
						<li id='consultcompany'><a href="<?php echo $php_self.'?page=consultcompany'; ?>" ><?php echo $STR['ConsultCompany'];?></a></li>							
						<li id='companyreport'><a href="<?php echo $php_self.'?page=companyreport'; ?>" ><?php echo $STR['CompanyReport'];?></a></li>						
					</ul>				
				</li>

				<li id='vacancies'><a class="sub" href="" ><b><?php echo $STR['Vacancies'];?></b></a><!--<![endif]-->				
					<ul class="sub2">
						<!-- <li id='addvacancy'><a href="<?php echo $php_self.'?page=addvacancy'; ?>" ><?php echo $STR['AddVacancy'];?></a></li> -->
						<li id='vacancyreport'><a href="<?php echo $php_self.'?page=vacancyreport'; ?>" ><?php echo $STR['VacancyReport'];?></a></li>
					</ul>				
				</li>

				<li id='compensation'><a href="<?php echo $php_self.'?page=compensation'; ?>" ><b><?php echo $STR['Compensation'];?></b></a></li>

				<li id='catalog'><a class="sub" href="" ><b><?php echo $STR['Catalog'];?></b></a><!--<![endif]-->
				
					<ul class="sub2">
						<li id='account'><a href="<?php echo $php_self.'?page=account'; ?>" ><?php echo $STR['AccountAdmin'];?></a></li>
						<li id='sector'><a href="<?php echo $php_self.'?page=sector'; ?>" ><?php echo $STR['Sector'];?></a></li>
						<li id='areas'><a href="<?php echo $php_self.'?page=areas'; ?>" ><?php echo $STR['Areas'];?></a></li>	
						<li id='vacancytype'><a href="<?php echo $php_self.'?page=vacancytype'; ?>" ><?php echo $STR['VacancyType'];?></a></li>
						<li id='activity'><a href="<?php echo $php_self.'?page=activity'; ?>" ><?php echo $STR['Activity'];?></a></li>
						<li id='softwaretype'><a href="<?php echo $php_self.'?page=softwaretype'; ?>" ><?php echo $STR['SoftwareType'];?></a></li>
						<li id='lenguagelist'><a href="<?php echo $php_self.'?page=lenguagelist'; ?>" ><?php echo $STR['LenguageList'];?></a></li>
						<li id='studyarea'><a href="<?php echo $php_self.'?page=studyarea'; ?>" ><?php echo $STR['StudyArea'];?></a></li>
						<li id='studylevel'><a href="<?php echo $php_self.'?page=studylevel'; ?>" ><?php echo $STR['StudyLevel'];?></a></li>
						<li id='annualplan'><a href="<?php echo $php_self.'?page=annualplan'; ?>" ><?php echo $STR['AnnualPlans'];?></a></li>
					</ul>
				
				</li>
				
			</ul>
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