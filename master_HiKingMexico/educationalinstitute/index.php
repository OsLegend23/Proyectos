<?php
/*
/index.php
*/
session_start();
include('../inc/common.inc.php');

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
<?php
	include($viewpage.'/'.$viewpage.'.js.php');	
?>
</script>
</head>
<body>	
<div id="templatemo_body_wrapper">
	<div id="templatemo_wrapper">
<?php
	include($COMMON->getHeaderPage());
?>
	<div class="cleaner h60"></div>
	<div id="menuContainer-options">
			<ul id="menu" class="boxshadow">
				<li ><a href="<?php echo $php_self.'?page=main'; ?>" ><b><?php echo $STR['MyAccount'];?></b></a></li>
				<li ><a href="<?php echo $php_self.'?page=personal'; ?>" ><b><?php echo $STR['AccountData'];?></b></a></li>
				<li ><a href="<?php echo $php_self.'?page=listvacancy'; ?>" ><b><?php echo $STR['PublicatedVacancies'];?></b></a></li>
				<li ><a href="<?php echo $php_self.'?page=addvacancy'; ?>" ><b><?php echo $STR['AddVacancy'];?></b></a></li>
				
			</ul>
	</div>

<?php 
	include($viewpage.'/index.php');
?>

<?php 
	include($COMMON->getFooterPage());
?>
    </div>
</div>
</body>
</html>