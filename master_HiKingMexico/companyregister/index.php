<?php
/*  /index.php */
session_start();
include('../inc/common.inc.php');
$viewpage = isset($_REQUEST['page']) ? $_REQUEST['page'] : 'form';
include($viewpage . '/' . $viewpage . '.header.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
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
        //$COMMON->getTool('js', 'tinymce/jscripts/tiny_mce/jquery.tinymce.js');
        ?>
        <script src="../theme/Materialize/js/materialize.js"></script>
        <script src="../inc/js/jQueryValidation/jquery.validate.js"></script>
        <script src="../inc/js/jQueryValidation/localization/messages_es.min.js"></script>
        <script src="../inc/js/Trumbowyg/trumbowyg.js"></script>
        <script src="../inc/js/Trumbowyg/langs/es.min.js"></script>
        <script src="../inc/js/Trumbowyg/plugins/upload/trumbowyg.upload.js"></script>
        <script src="../inc/js/Trumbowyg/plugins/base64/trumbowyg.base64.js"></script>
        <script src="../inc/js/Trumbowyg/plugins/colors/trumbowyg.colors.js"></script>
        <script src="../inc/js/init.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                if (window.location.pathname == window.location.pathname) {
                    $('#registro').addClass('current');
                }
                $('#formCompany').validate();
                $('#trumbowyg').trumbowyg({
                    lang: 'es',
                    mobile: true,
                    fixedBtnPane: true,
                    removeformatPasted: true,
                    semantic: true,
                    resetCss: true,
                    autoAjustHeight: true,
                    autogrow: true,
                    btns: ['btnGrp-design', '|', 'btnGrp-justify', '|', 'btnGrp-lists', 'link']
                });
                var aState = new ArrayCollection();
                var aSector = new ArrayCollection();
                <?php
                $COMMON->fillArrayCollection('aState',
                                             $QUERY->getState('ORDER BY tx_state ASC'),
                                             array('id_country','id','tx_state'),
                                             array('9999','9999', $STR['OutOfCountry']),
                                             true);
                $COMMON->fillArrayCollection('aSector',
                                             $QUERY->getSector('WHERE id != "9999" ORDER BY tx_description ASC'),
                                             array('id','tx_description'),
                                             array('-1', $STR['SelectSector']),
                                             true);
                 ?>
                var STATE_COMPANYREGISTER = 'companyRegister';

                //enableBasicTinyMCE('textarea', '100%');
                fillCombobox('#Sector', aSector, {'value': '0', 'label': '1'});
                fillCombobox('#State', aState, {'comboTrigger': '134', 'select': '2', 'value': '1', 'label': '2'});

                $("#termsAndConditions").live("click", function (e) {
                    $('#AceptPolitics').attr('checked', true);
                });

                $("#btnRegistry").live("click", function () {
                    var params = {
                        url: '<?php   echo  $viewpage.'/'; ?>remote.php',
                        beforeSubmit: showRequest,
                        success:      showResponse,
                        error:        errorResponse,
                        type:         'post',
                        dataType:     'json',
                        data:         {'opt': STATE_COMPANYREGISTER}
                    };
                    setRemoteRequest('#formCompany', params);
                });

                $("#btnGoToAdmin").live("click", function (e) {
                    top.location.href = "<?php   echo  $COMMON->getRoot(); ?>company/";
                });

                showRequest = function (formData, jqForm, options) {
                    var DateInstrYear = $('#DateInstrYear').val();
                    var DateOutstrYear = $('#DateOutstrYear').val();

                    if (DateOutstrYear < DateInstrYear) {
                        Materialize.toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
                        return false;
                    }
                    Materialize.toast('Enviando...', 4000);
                    return true;
                };

                showResponse = function (data) {
                    if (isBlank(data)) {
                        Materialize.toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000)
                        return false;
                    }
                    if (data.state == STATE_COMPANYREGISTER) {
                        if (data.answer == 'fail') {
                            change_captcha('Chars');
                            Materialize.toast(data.msg, 4000)
                        } else if (data.answer == 'correct') {
                            clearForm('formCompany');
                            $(data.msg).appendTo('.modal-content');
                            $('#successModal').openModal();
                        }
                    }
                };

                errorResponse = function (data) {
                    Materialize.toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
                }
            });
        </script>
    </body>
</html>