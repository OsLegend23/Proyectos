<?php
/*
/index.php
*/
session_start();
include('../inc/common.inc.php');

$viewpage = isset($_REQUEST['page'])?  $_REQUEST['page']: 'form';
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
	include($viewpage.'/index.php');
	include($COMMON->getFooterPage());
?>
    </div>
</div>
</body>
</html>