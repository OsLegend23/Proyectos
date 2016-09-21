<?php
/* /index.php */
session_start();
include('inc/common.inc.php');
$viewpage = isset($_REQUEST['page']) ? $_REQUEST['page'] : 'main';
include($viewpage . '/' . $viewpage . '.header.php'); //main/main.header.php 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="description" content="Vacantes de empleo.">
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
        include($COMMON->getHeaderPage("inicio"));
        include($viewpage . '/index.php');
        include($COMMON->getFooterPage());
        $COMMON->getJs('jquery.form');
        $COMMON->getJs('ArrayCollection');
        ?>
        <script src="theme/Materialize/js/materialize.js"></script>
        <script src="inc/js/init.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                if (window.location.pathname == window.location.pathname) {
                    $('#inicio').addClass('current');
                }
                $("#btnSearch").live("click", function (e) {
                    var key = $("#key").val();
                    var location = $("#location").val();
                    top.location.href = "<?php   echo  $COMMON->getRoot(); ?>search/?opt=simplequery&keyword=" + key + "&city=" + location;
                    return false;
                });

                $("#btnMailingList").live("click", function (e) {
                    var params = {
                        url: '<?php   echo  $COMMON->getRoot(); ?>remote.php',
                        beforeSubmit: showRequest,
                        success: showResponse,
                        error: errorResponse,
                        type: 'post',
                        dataType: 'json',
                        data: {'opt': STATE_MAILINGLIST}
                    };
                    tagId = 'formID_waitdialog';
                    setRemoteRequest('#formID', params);
                });

                showRequest = function () {
                    Materialize.toast('Enviando...', 2000);
                    return true;
                };

                showResponse = function (data) {
                    if (isBlank(data)) {
                        Materialize.toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
                        return false;
                    }

                    if (data.state == STATE_MAILINGLIST) {
                        change_captcha('Chars');
                        Materialize.toast(data.msg, 4000);
                    }
                };

                errorResponse = function (data) {
                    Materialize.toast('<?php   echo  $STR['Msg_WebError']; ?>', 4000);
                };
            });
            var prevCurrentState = '';
            var currentState = '';
            var selectedRowID = -1;

            $(document.body).ready(function () {
                $(".custom-input-file input:file").change(function () {
                    $(this).parent().find(".archivo").html($(this).val());
                });

                $("#signIn").live("click", function (e) {
                    <?php if($_SESSION['enlaceemp_loginon']) echo  'top.location.href="'.$COMMON->getRoot().$GLOBAL['user_list'][$_SESSION['enlaceemp_accounttype']]['location'].'";'; else echo  'top.location.href="'.$COMMON->getRoot().'account/";'; ?>
                    return false;
                });

                $("#registry").live("click", function (e) {
                    openModal('dialog_registry', '750', '650');
                    return false;
                });

                $("#btnIwanttohire").live("click", function (e) {
                    top.location.href = "<?php echo  $COMMON->getRoot(); ?>companyregister/";
                    return false;
                });

                $("#btnLookingforwork").live("click", function (e) {
                    top.location.href = "<?php echo  $COMMON->getRoot(); ?>postulantregister/";
                    return false;
                });

                $('img[id^="refresh_"]').live("click", function (e) {
                    var idCaptcha = $(this).attr('alt');
                    change_captcha(idCaptcha);
                });

                $("form :input").each(function () {
                    var input = $(this);
                    if (input[0]['className'].indexOf('validate[required') == 0) {
                        $('#lbl_' + input[0]['id']).css('color', '#0981a9');
                    }
                });

                $('button[id^="btnConfirmation_"]').live("click", function (e) {
                    var buttonID = $(this).attr('id');
                    if (buttonID == 'btnConfirmation_Yes') {
                        confirmationYes();
                    } else if (buttonID == 'btnConfirmation_No') {
                        confirmationNo();
                    }
                });

                <?php if ( !isset($_SESSION['enlaceemp_Hitscounter']) ) {
                    $_SESSION['enlaceemp_Hitscounter'] = md5(Date("H:i:s"));
                    echo  "var params = {url: '".$COMMON->getRoot()."remote.php', type: 'post', dataType:  'json', data: { 'opt': 'hitsCounter', 'session': '".$_SESSION['enlaceemp_Hitscounter']."' } }; ";
                    echo  "setAjaxRemoteRequest(params); ";
                }
              ?>
            });

            function setRemoteRequest(form, params) {
                $(form).ajaxForm(params);
            }

            function setAjaxRemoteRequest(params) {

                if (params.data['opt'] != "hitsCounter")
                    showRequest();

                $.ajax({
                    type: params.type,
                    url: params.url,
                    data: params.data,
                    success: function (data) {
                        if (data.answer != "hitsCounter")
                            showResponse(data);
                    },
                    error: function (x, t, m) {
                        errorResponse();
                    },
                    fail: function () {
                        errorResponse();
                    },
                    dataType: params.dataType
                });
            }

            function getMenuSelected(selectedId) {
                $('ul[id="menu"] li').each(function (index, value) {
                    if (selectedId == $(this).attr('id'))
                        $(this).addClass('menu_selected');
                    else
                        $(this).removeClass('menu_selected');
                });
            }

            function enableDatepicker() {
                $(".datepicker").datepicker({
                    showButtonPanel: true,
                    changeMonth: true,
                    changeYear: true
                });
                $(".datepicker").datepicker("option", "yearRange", '<?php   echo  $GLOBAL['date_lastYear'];  ?>:<?php   echo  $GLOBAL['date_currentYear'];  ?>');
                $(".datepicker").datepicker("option", $.datepicker.regional["<?php   echo  $COMMON->getLang();  ?>"]);
                $(".datepicker").datepicker("option", "dateFormat", 'yy-mm-dd');
            }

            function validateForm(formId) {
                return $('#' + formId).validationEngine('validate');
            }

            function hideValidationForm(tagId) {
                $('#' + tagId).validationEngine('hide');
            }

            function clearForm(formId) {
                $("#" + formId).get(0).reset();
            }

            function disableFormButtons(disable) {
                if (disable) {
                    $('.formButton').attr("disabled", true);
                } else {
                    $(".formButton").removeAttr("disabled");
                }
            }

            function disableButton(tagId, disable) {
                $(tagId).prop('disabled', disable);
            }

            function closePromt(tagId) {
                $(tagId).validationEngine('hide');
            }

            function displayPrompt(tagId, msg, answer, showInAlert) {
                var icon = 'ui-icon-comment';
                var message = '';
                var uiState = 'ui-state-highlight';
                if (answer == null) {
                    $(tagId).validationEngine('hide');
                    return false;
                }
                if (answer == 'wait_progress') {
                    icon = '<div class="' + uiState + '  ui-corner-all" style="margin-top: 0px;"> <p><span class="" style="float: left;"></span><?php   echo  $STR['WaitaMoment'];  ?> ' + msg + ' <img src="<?php   echo  $COMMON->getRoot(); ?>media/icon/wait.gif"/></p> </div>';
                } else if (answer == 'correct') {
                    icon = 'ui-icon-comment';
                } else if (answer == 'fail') {
                    icon = 'ui-icon-alert';
                    uiState = 'ui-state-error';
                } else if (answer == 'error') {
                    icon = 'ui-icon-alert';
                    uiState = 'ui-state-error';
                }

                if (showInAlert) {
                    alert(msg);
                } else {
                    if (answer == 'wait_progress')
                        message = icon;
                    else
                        message = '<div class="' + uiState + '  ui-corner-all" style="margin-top: 0px; "> <p><img src="<?php   echo  $COMMON->getRoot()."media/icon/comments.png"; ?>"><span class="" style="float: left;"></span>' + msg + '</p> <div class="closeclic ui-corner-all">clic para cerrar.</div> </div>';

                    //$(tagId).validationEngine('showPrompt', message, 'remoteRequest');
                }
            }

            function disableForm(formId, disable) {
                $.each($('#' + formId).serializeArray(), function (i, field) {
                    $("#" + field.name).prop('disabled', disable);
                });

                disableFormButtons(disable);
            }

            function disableFormField(formId, tagId, disable) {
                $(formId + ' ' + tagId).prop('disabled', disable);
            }

            function serializeArray(formId) {
                var ARRAY_DATAFIELDS = "";

                $.each($('#' + formId).serializeArray(), function (i, field) {
                    ARRAY_DATAFIELDS += field.name + '|@:|' + field.value;
                    ARRAY_DATAFIELDS += '|@&|';
                });
                return ARRAY_DATAFIELDS;
            }

            function change_captcha(idCaptcha) {
                document.getElementById('captcha_' + idCaptcha).src = "<?php   echo  $COMMON->getRoot().'media/icon/wait.gif'; ?>";
                document.getElementById('captcha_' + idCaptcha).src = "<?php   echo  $COMMON->getRoot().'inc/tool/captcha/'; ?>get_captcha.php?rnd=" + Math.random();
            }

            function openOverlay() {
                $('#overlay').fadeIn('fast')
            }

            function closeOverlay() {
                $('#overlay').fadeOut('fast')
            }

            function openModalOverlay() {
                $('#modalOverlay').fadeIn('fast')
            }

            function closeModalOverlay() {
                $('#modalOverlay').fadeOut('fast')
            }

            function openModal(dialog, mWidth, mHeight) {
                $("#" + dialog).modal({
                    containerCss: {
                        backgroundColor: "#fff",
                        height: mHeight,
                        padding: 0,
                        width: mWidth
                    },
                    onClose: function (dialog) {
                        $.modal.close();
                    },
                    onShow: function (dialog) {
                    }
                });
            }

            function closeModal() {
                $.modal.close();
            }

            function setCurrentState(state) {
                prevCurrentState = currentState;
                currentState = state;
            }

            function getCurrentState() {
                return currentState;
            }

            function getPrevCurrentState() {
                return prevCurrentState;
            }

            function setSelectedRow(rowID) {
                selectedRowID = rowID;
            }

            function getSelectedRow() {
                return selectedRowID;
            }

            function enableBasicTinyMCE(textAreaId, mWidth) {
                $(textAreaId).tinymce({
                    script_url: '<?php   echo  $COMMON->getRoot() ?>inc/tool/tinymce/jscripts/tiny_mce/tiny_mce.js',
                    theme: "advanced",
                    mode: "none",
                    plugins: "",
                    theme_advanced_buttons1: "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo",
                    theme_advanced_buttons2: "",
                    theme_advanced_buttons3: "",
                    theme_advanced_resizing: false,
                    theme_advanced_toolbar_location: "top",
                    theme_advanced_toolbar_align: "left",
                    add_unload_trigger: false,
                    remove_linebreaks: false,
                    inline_styles: false,
                    convert_fonts_to_spans: false,
                    width: mWidth
                });
            }

            function ToggleEditorTinyMCE(textAreaId) {
                $(textAreaId).each(function (index) {
                    tinyMCE.execCommand('mceToggleEditor', false, $(this).attr('id'));
                });
            }

            function fillCombobox(comboboxId, array, params) {
                $(comboboxId).attr("disabled", true);
                var select = $(comboboxId);
                var options = $(comboboxId).attr('options');
                $('option', $(comboboxId)).remove();
                var initGroup = null;

                if (!isBlank(params.comboTrigger)) {
                    for (var i = 0; i < array.size(); i++) {
                        if (!isBlank(params.group)) {
                            if (initGroup != array.getItemAt(i)[0] && array.getItemAt(i)[0] != 9999) {
                                if (!isBlank(initGroup))
                                    $(comboboxId).append('</optgroup>');

                                $(comboboxId).append('<optgroup label="' + array.getItemAt(i)[params.group] + '">');
                                initGroup = array.getItemAt(i)[0];
                            }
                        }

                        if (params.comboTrigger == array.getItemAt(i)[0] || array.getItemAt(i)[0] == 9999) {
                            var selected = "";

                            if (!isBlank(params.select))
                                if (array.getItemAt(i)[params.value] == params.select)
                                    selected = "selected=selected";

                            $(comboboxId).append('<option value="' + array.getItemAt(i)[params.value] + '" ' + selected + '>' + array.getItemAt(i)[params.label] + '</option>');
                        }
                    }

                    if (!isBlank(params.group))
                        $(comboboxId).append('</optgroup>');
                } else {
                    for (var i = 0; i < array.size(); i++) {
                        if (!isBlank(params.group)) {
                            if (initGroup != array.getItemAt(i)[0] && array.getItemAt(i)[0] != 9999) {
                                if (!isBlank(initGroup))
                                    $(comboboxId).append('</optgroup>');

                                $(comboboxId).append('<optgroup label="' + array.getItemAt(i)[params.group] + '">');
                                initGroup = array.getItemAt(i)[0];
                            }
                        }

                        var selected = "";
                        if (!isBlank(params.select))
                            if (array.getItemAt(i)[params.value] == params.select)
                                selected = "selected=selected";

                        $(comboboxId).append('<option value="' + array.getItemAt(i)[params.value] + '" ' + selected + '>' + array.getItemAt(i)[params.label] + '</option>');
                    }

                    if (!isBlank(params.group))
                        $(comboboxId).append('</optgroup>');
                }

                $(comboboxId).removeAttr("disabled");
            }

            function isBlank(str) {
                return (!str || /^\s*$/.test(str));
            }
        </script>
    </body>
</html>