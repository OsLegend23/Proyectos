<?php
/*
/index.php
*/
session_start();
include('../inc/common.inc.php');

$viewpage = isset($_REQUEST['page'])?  $_REQUEST['page']: 'vacancy';
include($viewpage.'/'.$viewpage.'.header.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
        <title><?php echo $GLOBAL['site'];?></title>
        <link href="<?php echo $COMMON->getMedia('icon', $GLOBAL['icon']);?>" type="image/x-icon" rel="shortcut icon">
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
            var message_dialog      = '';
            var message_form        = '';
            var companyColony       = '<?php   echo  $rData['tx_colony'];  ?>';
            var companyStreet       = '<?php   echo  $rData['tx_street'];  ?>';
            var companyURL          = '<?php   echo  $rData['tx_web'];  ?>';
            var publicationmode     = '<?php   echo  $rData['ch_confidential'];  ?>';
            var companyName         = '<?php   echo  $rData['ch_confidential']=='S'? $rData['tx_confidential_trademark'] : $rData['tx_trademark'];  ?>';
            var aGender             = new ArrayCollection();
            var aMaritalStatus      = new ArrayCollection();
            var aLikeStudies        = new ArrayCollection();
            var aLikeLanguages      = new ArrayCollection();
            var STATE_INIT          = 'init';
            var STATE_AUTENTICATE   = 'autenticate';
            var STATE_APPLY         = 'apply';
            var STATE_SHARE         = 'share';
            <?php   
            $COMMON->fillArrayCollection('aLikeStudies',
                                 $QUERY->getVacancyStudyLevel("WHERE a.id_vacancy = '$vacancyId'"),
                                 array('id_studylevel','tx_studyarea','studylevel_tx_description','studyarea_tx_description'),
                                 null,
                                 true);
            $COMMON->fillArrayCollection('aLikeLanguages',
                                 $QUERY->getVacancyLanguage("WHERE a.id_vacancy = '$vacancyId'"),
                                 array('id_language','nm_domain','tx_description_language'),
                                 null,
                                 true
                                );
            $COMMON->fillArrayCollection('aGender',
                                 $STR['GenderList'],
                                 null,
                                 array('X',$STR['NoRequired']),
                                 false
                                );
            $COMMON->fillArrayCollection('aMaritalStatus',
                                 $STR['MaritalStatusList'],
                                 null,
                                 array('X',$STR['NoRequired']),
                                 false
                                );
            ?>

            $(document.body).ready(function() {
            fillDataFields();

            $('.shortcut_vcn').live("click", function(e) {
            var dialog  = 'dialog_'+$(this).attr('id');
            var width   = $('#'+dialog).attr('width');
            var height  = parseInt($('#'+dialog).attr('height')) + parseInt(10);
            openModal(dialog, width, height);
            change_captcha($(this).attr('id')+'chars');
            return false;
            });

            $('#print').live("click", function(e) {
            top.location.href="?vcn=<?php   echo  $vacancyId ?>&print=yes";
            return false;
            });

            $('#btnCreateAccount').live("click", function(e) {
            top.location.href="<?php   echo  $COMMON->getRoot(); ?>postulantregister/"; 
            return false;
            });

            $("#btnApply").live("click", function(e) {
            var params = 
            {
                url:            '<?php   echo  $COMMON->getRoot(); ?>remote.php',
                beforeSubmit:   showRequest,
                success:        showResponse,
                error:          errorResponse,
                type:           'post',
                dataType:       'json',
                data:           { 'opt': STATE_AUTENTICATE}
            };
            message_dialog = 'msessage_apply';
            message_form   = 'formID_waitdialog';
            setRemoteRequest('#formID', params);
            });

            $("#btnShare").live("click", function(e) {
            var params =
            {
                url:            '<?php   echo  $viewpage.'/'; ?>remote.php',
                beforeSubmit:   showRequest,
                success:        showResponse,
                error:          errorResponse,
                type:           'post',
                dataType:       'json',
                data:           { 'opt': STATE_SHARE, 'vcn':'<?php   echo  $vacancyId ?>'}
            };
            message_dialog = 'msessage_share';
            message_form   = 'formShareID_waitdialog';
            setRemoteRequest('#formShareID', params);
            });
            });

            function showRequest() {
            openModalOverlay();
            displayPrompt('#'+message_form, '', 'wait_progress', false);
            return true; 
            }

            function showResponse(data) {
            closeModalOverlay();

            if(isBlank(data)) {
            displayPrompt('#'+message_form, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
            return false;
            }

            if(data.state == STATE_AUTENTICATE) {
            if(data.answer == 'fail') {
                change_captcha('applychars');
                displayPrompt('#'+message_form, data.msg, data.answer, false);
            } else if(data.answer == 'correct') {
                apply();
            }
            } else if(data.state == STATE_APPLY) {
            closeModal();
            openModal('dialog_applyAnswer', '600', '250');
            $('#applyAnswer').html(data.msg);
            } else if(data.state == STATE_SHARE) {
            change_captcha('sharechars');
            displayPrompt('#'+message_form, data.msg, data.answer, false);
            }
            }

            function errorResponse(data) {
            closeModalOverlay();
            displayPrompt(message_dialog, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);
            }

            function apply() {
            $('.vcn_iframe').html('<div style="text-align:center;"><img src="<?php   echo  $COMMON->getRoot(); ?>media/icon/wait.gif"></div>');
            var params =
            {
            url:            '<?php   echo  $viewpage.'/'; ?>remote.php',
            type:           'post',
            dataType:       'json',
            data:           {
                                'opt': STATE_APPLY, 
                                'vcn':'<?php   echo  $vacancyId ?>', 
                                'companyId':'<?php   echo  $companyId ?>'
                            }
            };
            message_dialog = 'msessage_apply';
            message_form   = 'formID_waitdialog';
            setAjaxRemoteRequest(params);
            }

            function fillDataFields() {
            if(publicationmode == '<?php   echo  $GLOBAL['confidential_YES'];  ?>') {
            $("#vf_Company").html(companyName);
            $("#vf_About_lbl").hide();
            $("#vf_About").html('');
            $("#vf_CompanyInfo").html('');
            <?php  
            if(strlen($rData['tx_confidentialemail']) > 0)
                echo  '$("#vf_CompanyInfo").append(\'<li>'.$STR['SendByEmail'].': <a href="mailto:'.$rData['tx_confidentialemail'].'">'.$rData['tx_confidentialemail'].'</a></li>\');';
             ?> 
            } else {
            $("#vf_Company").html(companyName);
            $("#vf_About_lbl").show();
            $("#vf_About").html($("#about_vf").val());
            $("#vf_CompanyInfo").html('');
            <?php
            if(strlen($rData['tx_companyemail']) > 0)
                echo  '$("#vf_CompanyInfo").append(\'<li>'.$STR['SendByEmail'].': <a href="mailto:'.$rData['tx_companyemail'].'">'.$rData['tx_companyemail'].'</a></li>\');';
             ?>
            <?php
            if(strlen($rData['tx_web']) > 0)
             echo  '$("#vf_CompanyInfo").append(\'<li>'.$STR['URLWeb'].': <a target="_blank" href="http://www.'.$rData['tx_web'].'">'.$rData['tx_web'].'</a></li>\');';
            ?>
            <?php
            if(strlen($rData['tx_facebook']) > 0)
                echo  '$("#vf_CompanyInfo").append(\'<li>'.$STR['LinkFacebook'].': <a target="_blank" href="http://www.facebook.com/'.$rData['tx_facebook'].'">'.$rData['tx_facebook'].'</a></li>\');';
            ?>
            <?php
            if(strlen($rData['tx_twitter']) > 0)
                echo  '$("#vf_CompanyInfo").append(\'<li>'.$STR['LinkTwitter'].': <a target="_blank" href="http://www.twitter.com/'.$rData['tx_twitter'].'">'.$rData['tx_twitter'].'</a></li>\');';
            ?>
            }

            $("#vf_Location").html('<?php   echo  $location; ?>');
            $("#vf_Activity").html('<?php   echo  $workarea; ?>');
            $("#vf_VacancyType").html('<?php   echo  $vacancytype; ?>');
            $("#vf_JobExperiencealone").html('<?php   echo  $timeExperience; ?>');
            $("#vf_vacancyName").html('<?php   echo  $rData['tx_name']; ?>');
            $("#vf_ReferenceCode").html('<?php   echo  $vacancyId; ?>');
            /*$("#vf_StudySpecs").html('');
            for( var i = 0 ; i < aLikeStudies.size() ; i++) 
            if($("#vf_StudySpecs").html().indexOf(aLikeStudies.getItemAt(i)[2]) == -1) {
                if($("#vf_StudySpecs").html().length > 0) 
                    $("#vf_StudySpecs").append(', ');
                $("#vf_StudySpecs").append(aLikeStudies.getItemAt(i)[2]);
            }*/

            var finishAge = parseInt(<?php echo $rData['nm_maxage']; ?>);
            var initAge = parseInt(<?php echo $rData['nm_minage']; ?>);
            if(initAge == 0)
            $("#vf_AgeOld").html('<span><b><?php echo $STR['AgeOld'].':</b></span> '.'<label>'.$STR['NoRequired']; ?></label>');
            else if(finishAge == initAge)
            $("#vf_AgeOld").html('<span><b><?php echo $STR['AgeOld']; ?>:</b></span> '+'<label>'+initAge+' <?php echo $STR['Year'].'s'; ?></label>');
            else if(initAge > 0 && finishAge == 0)
            $("#vf_AgeOld").html('<span><b><?php echo $STR['AgeOld']; ?>:</b></span> '+'<label>'+initAge+' <?php echo $STR['Year'].'s '.$STR['Onwards']; ?></label>');
            else if(finishAge == 100)
            $("#vf_AgeOld").html('<span><b><?php echo $STR['AgeOld']; ?>:</b></span> '+'<label>'+initAge+' <?php echo $STR['Year'].'s '.$STR['Onwards']; ?></label>');
            else
            $("#vf_AgeOld").html('<span><b><?php echo $STR['AgeOld']; ?>:</b></span> '+'<label>'+initAge+' <?php echo $STR['Until']; ?> '+finishAge+' <?php   echo  $STR['Year'].'s'; ?></label>');

            for( var i = 0 ; i < aGender.size() ; i++)
            if(aGender.getItemAt(i)[0] == '<?php   echo  $rData['ch_gender']; ?>')
                $("#vf_Gender").html('<span><b><?php   echo  $STR['Gender']; ?>:</b></span> '+'<label>'+aGender.getItemAt(i)[1]+'</label>');

            for( var i = 0 ; i < aMaritalStatus.size() ; i++)
            if(aMaritalStatus.getItemAt(i)[0] == '<?php echo $rData['ch_maritalstatus'];  ?>')
                $("#vf_MaritalStatus").html('<span><b><?php echo $STR['MaritalStatus']; ?>:</b></span> '+'<label>'+aMaritalStatus.getItemAt(i)[1]+'</label>');

            $("#vf_StudySpecsList").html('');
            for( var i = 0 ; i < aLikeStudies.size() ; i++) {
            if(aLikeStudies.getItemAt(i)[0] == <?php   echo  $GLOBAL['noRequiredId']; ?>)
                $("#vf_StudySpecsList").append(aLikeStudies.getItemAt(i)[2]);
            else
                $("#vf_StudySpecsList").append(aLikeStudies.getItemAt(i)[2]+', '+aLikeStudies.getItemAt(i)[3]+'/ ');
            }

            if('<?php  echo $rData['ch_relatedstudylevel'] ?>' == 'S')
            $("#vf_StudySpecsList").append('<?php   echo  $STR['RelatedstudylevelList']; ?>');

            $("#vf_StudySpecsList").append('<?php   echo  $tx_reqstudy; ?>');
            $("#vf_LanguageRequires").html('');

            for( var i = 0; i < aLikeLanguages.size(); i++ ) {
            if(aLikeLanguages.getItemAt(i)[0] == <?php   echo  $GLOBAL['noRequiredId']; ?>)
                $("#vf_LanguageRequires").append(aLikeLanguages.getItemAt(i)[2]);
            else
                $("#vf_LanguageRequires").append(aLikeLanguages.getItemAt(i)[2]+', '+aLikeLanguages.getItemAt(i)[1]+'%');

            }
            $("#vf_JobExperience").html('');
            $("#vf_JobExperience").append('<?php   echo  $tx_reqwork; ?>');
            $("#vf_WorkDetail").html('<?php   echo  $tx_workdetail; ?>');
            }
        </script>
    </body>
</html>