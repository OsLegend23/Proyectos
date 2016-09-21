<?php
/*
  /index.php
 */
session_start();
include('../inc/common.inc.php');

if (isset($_REQUEST['logout'])) {
    session_unset();
    session_destroy();
}

$viewpage = isset($_REQUEST['page']) ? $_REQUEST['page'] : 'account';
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
        <script src="../inc/js/jQueryValidation/jquery.validate.js"></script>
        <script src="../inc/js/jQueryValidation/localization/messages_es.min.js"></script>
        <script src="../inc/js/init.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                if (window.location.pathname == window.location.pathname) {
                    $('#signIn').addClass('current');
                }
                $('#frmLogin').validate();
                var STATE_AUTENTICATE = 'autenticate';

                $(document.body).ready(function () {
                    $("#btnAutenticate").live("click", function (e) {
                        var params = {
                            url: '<?php   echo  $COMMON->getRoot(); ?>remote.php',
                            beforeSubmit: showRequest,
                            success: showResponse,
                            error: errorResponse,
                            type: 'post',
                            dataType: 'json',
                            data: {'opt': STATE_AUTENTICATE}
                        };
                        setRemoteRequest('#frmLogin', params);
                    });
                    <?php if(isset($_REQUEST['validation'])) { echo  "showValidationAnswer();";	} ?>
                });

                function showValidationAnswer() {
                    $('#validation_answer').html('<div class="cleaner h10"></div><?php   echo  $answer; ?>');
                    openModal('validation_dialog', 460, 250);
                }

                showRequest = function (formData, jqForm, options) {
                    Materialize.toast('Enviando...', 4000);
                    return true;
                }

                showResponse = function (data) {
                    if (isBlank(data)) {
                        Materialize.toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
                        return false;
                    }
                    if (data.state == STATE_AUTENTICATE) {
                        if (data.answer == 'fail') {
                            change_captcha('Chars');
                            Materialize.toast(data.msg, 4000);
                        } else if (data.answer == 'correct') {
                            top.location.href = "<?php   echo  $COMMON->getRoot(); ?>" + data.accounttype + "/";
                        }
                    }
                }

                function errorResponse(data) {
                    Materialize.toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
                }

            });
        </script>
    </body>
</html>