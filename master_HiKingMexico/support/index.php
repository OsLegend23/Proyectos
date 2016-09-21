<?php
/*
  support/index.php
 */
session_start();
include('../inc/common.inc.php');

$viewpage = isset($_REQUEST['page']) ? $_REQUEST['page'] : 'support';
include($viewpage . '/' . $viewpage . '.header.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
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
        <script type="text/javascript">
            $(document).ready(function () {
                if (window.location.pathname == window.location.pathname){
                    $('#soporte').addClass('current');
                }
            });
        </script>
    </body>
</html>