<?php
/*
/index.php
*/
session_start();
include('../inc/common.inc.php');

$viewpage = isset($_REQUEST['page']) ? $_REQUEST['page'] : 'form';
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
            $(document).ready(function() {
                if (window.location.pathname == window.location.pathname){
                    $('#registro').addClass('current');
                }
                $('#registroPostulante').validate();
                var aCountry = new ArrayCollection();
                var aState = new ArrayCollection();
                var aArea = new ArrayCollection();
                var aStudyArea = new ArrayCollection();
                var STATE_POSTULANTREGISTER = 'postulantRegister';

                <?php
                $COMMON->fillArrayCollection('aState',
                                             $QUERY->getState('ORDER BY tx_state ASC'),
                                             array('id_country','id','tx_state'),
                                             null,
                                             true
                                            );
                $COMMON->fillArrayCollection('aArea' ,
                                             $QUERY->getWorkArea('ORDER BY a.tx_description'),
                                             array('id', 'workarea_tx_description'),
                                             null,
                                             true
                                            );
                $COMMON->fillArrayCollection('aStudyArea' ,
                                             $QUERY->getStudyArea('WHERE id_studylevel != "9999" ORDER BY tx_description'),
                                             array('id_studylevel','id','tx_description'),
                                             null,
                                             true);
                ?>
                fillCombobox('#State', aState, {'comboTrigger': '134', 'select': '2', 'value': '1', 'label': '2'});
                fillCombobox('#WorkArea', aArea, {'value': '0', 'label': '1'});
                fillCombobox('#StudyArea', aStudyArea, {'comboTrigger': '3', 'value': '1', 'label': '2'});

                $('#StudyLevel').live("change", function (e) {
                    var studylevel = $(this).val() >= 3 ? 3 : $(this).val();
                    fillCombobox('#StudyArea', aStudyArea, {
                        'comboTrigger': studylevel,
                        'value': '1',
                        'label': '2'
                    });
                });

                $('#FirstJob').live("change", function (e) {
                    disableFormField('#formID', '#WorkArea, #JobTitle, #DateInstrYear, #DateOutstrYear', false);
                    if ($(this).val() == 'S')
                        disableFormField('#formID', '#WorkArea, #JobTitle, #DateInstrYear, #DateOutstrYear', true);
                });

                $("#termsAndConditions").live("click", function (e) {
                    $('#AceptPolitics').attr('checked', true);
                });

                $("#btnPostulate").live("click", function (e) {
                    var params =
                    {
                        url: '<?php   echo  $viewpage.'/'; ?>remote.php',
                        beforeSubmit: showRequest,
                        success: showResponse,
                        error: errorResponse,
                        type: 'post',
                        dataType: 'json',
                        data: {'opt': STATE_POSTULANTREGISTER}
                    };

                    setRemoteRequest('#registroPostulante', params);
                });

                $("#btnGoToAdmin").live("click", function (e) {
                    top.location.href = "<?php   echo  $COMMON->getRoot(); ?>postulant/";
                });

                showRequest = function(formData, jqForm, options){
                    if ($('input[id=FirstJob]:checked', '#formID').val() == 'N') {
                        var DateInstrYear = $('#DateInstrYear').val();
                        var DateOutstrYear = $('#DateOutstrYear').val();
                        if (DateOutstrYear < DateInstrYear) {
                            Materialize.toast('<?php   echo  $STR['Msg_DateJobExperienceError']; ?>', 4000);
                            return false;
                        }
                    }
                    Materialize.toast('Enviando...', 4000);
                    return true;
                };

                showResponse = function(data){
                    if (isBlank(data)) {
                        Materialize.toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
                        return false;
                    }

                    if (data.state == STATE_POSTULANTREGISTER) {
                        if (data.answer == 'fail') {
                            change_captcha('Chars');
                            Materialize.toast(data.msg, 4000);
                        } else if (data.answer == 'correct') {
                            clearForm('registroPostulante');
                            $(data.msg).appendTo('.modal-content');
                            $('#successModal').openModal();
                        }
                    }
                };
                errorResponse = function (data) {
                    Materialize.toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
                };

                $('#BornDate').pickadate({
                    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthsShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    weekdaysLetter: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
                    format: 'dd/mm/yyyy',
                    selectYears: true,
                    selectMonths: true,
                    today: 'Hoy',
                    clear: 'Limpiar',
                    close: 'Cerrar',
                    formatSubmit: 'yyyy-mm-dd'
                });

                //Ocultar experiencia de trabajo
                $("[name=FirstJob]").on('click', function(){
                    if( $('[name=FirstJob]').not(':checked')){
                        $(".element-expLaboral").toggle('slow');
                    }

                });
            });
        </script>
    </body>
</html>