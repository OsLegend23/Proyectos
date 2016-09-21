<?php
/*
/index.php
*/
session_start();
include('../inc/common.inc.php');

$viewpage = isset($_REQUEST['page']) ? $_REQUEST['page'] : 'forgotpassword';
include($viewpage . '/' . $viewpage . '.header.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $GLOBAL['site']; ?></title>
    <link href="<?php echo $COMMON->getMedia('icon', $GLOBAL['icon']); ?>" type="image/x-icon" rel="shortcut icon">
    <?php
    $COMMON->addCommonsCSS();
    ?>
</head>
    <body>
        <?php
        $COMMON->addCommonsJS();
        include($COMMON->getHeaderPage());
        include($viewpage . '/index.php');
        include($COMMON->getFooterPage());
        $COMMON->getJs('jquery.form');
        $COMMON->getJs('ArrayCollection');
        $COMMON->getTool('js', 'tinymce/jscripts/tiny_mce/jquery.tinymce.js');
        ?>
        <script src="../theme/Materialize/js/materialize.js"></script>
        <script src="../inc/js/init.js"></script>
    </body>
</html>