<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var aState 			= new ArrayCollection();
var aArea 			= new ArrayCollection();var aStudyArea 		= new ArrayCollection();var aStudies 		= new ArrayCollection();var aLanguages 		= new ArrayCollection();
var aGender 		= new ArrayCollection();var aMaritalStatus 	= new ArrayCollection();var companyName 			= '<?php   echo  $rData['tx_trademark'];  ?>';var confidentialtrademark 	= '<?php   echo  $rData['tx_confidential_trademark'];  ?>';var companyColony 			= '<?php   echo  $rData['tx_colony'];  ?>';
var companyStreet 			= '<?php   echo  $rData['tx_street'];  ?>';var companyURL	 			= '<?php   echo  $rData['tx_web'];  ?>';var tableSelected 			= '';var STATE_UPDVACANCY = 'updVacancy';
<?php 	$COMMON->fillArrayCollection('aState' 		, $QUERY->getState('ORDER BY tx_state ASC')		, array('id_country','id','tx_state')
		, null		, true);	$COMMON->fillArrayCollection('aArea' 		, $QUERY->getWorkArea('ORDER BY a.tx_description')		, array('id', 'workarea_tx_description')
		, array('-1',$STR['SelectArea'])		, true );	$COMMON->fillArrayCollection('aStudyArea' 		, $QUERY->getStudyArea('WHERE id_studylevel != "9999" ORDER BY tx_description')		, array('id_studylevel','id','tx_description')
		, array('9999','-1',$STR['SelectStudyArea'])		, true);	$COMMON->fillArrayCollection('aGender' 		, $STR['GenderList']		, null  	 	 	 
		, array('X',$STR['NoRequired'])		, false);	$COMMON->fillArrayCollection('aMaritalStatus' 		, $STR['MaritalStatusList']		, null  	 	 	 
		, array('X',$STR['NoRequired'])		, false);	$COMMON->fillArrayCollection('aStudies' 		, $QUERY->getVacancyStudyLevel("WHERE a.id_vacancy = '$vacancyId'")
		, array('id_studylevel','studylevel_tx_description','studyarea_tx_description', 'id_studylevel', 'tx_studyarea')  	 	 	 		, null		, true);	$COMMON->fillArrayCollection('aLanguages' 		, $QUERY->getVacancyLanguage("WHERE a.id_vacancy = '$vacancyId'")
		, array('id_language','tx_description_language','nm_domain', 'id_language', 'nm_domain')  	 	 	 		, null		, true); ?>$(document.body).ready(function()
{	<?php  	if($rGetVacancy->size() == 0 )	{ ?>	$("#btnReturn").live("click", function(e)
     {               				top.location.href="<?php   echo  $php_self; ?>?page=listvacancy";    	return false;     });<?php  	
	} ?> 	fillCombobox('#WorkArea', aArea, {'select':'<?php   echo  $rVacancyData['id_workarea']; ?>' ,'value':'0', 'label':'1'});	fillCombobox('#StudyArea', aStudyArea, {'comboTrigger': '1','value':'1', 'label':'2'});
	selectStudyLevel(-1);	$('#StudyLevel').live("change", function(e){		selectStudyLevel($(this).val());		return false;
	});	$('#InitAge').live("change", function(e){		selectAgeOld($(this).val());		return false;	});
	$('#Language').live("change", function(e){		selectLanguage($(this).val());		return false;	});
	$("#AddStudyLevel").live("click", function(e)     {               				addStudyLevel();    	return false;     });
	$("#AddLanguage").live("click", function(e)     {               				addLanguage();    	return false;     });
	$("#tblStudies").flexigrid({				dataType: 'json',								singleSelect:true,		colModel : [										{display: '<?php   echo  $STR['Delete'];  ?>', name : 'Delete', width : 100, sortable : false, align: 'center'},			{display: '<?php   echo  $STR['StudyLevel'];  ?>', name : 'StudyLevel', width : 370, sortable : false, align: 'left'},
			{display: '<?php   echo  $STR['StudyArea'];  ?>', name : 'StudyArea', width :390, sortable : false, align: 'left'}							],							usepager: false,					useRp: false,		rp: 15,		showTableToggleBtn: false,			
		height: 200	});	$('#tblStudies, #tblLanguages').on('click', 'tr[id*="row"]', function()	{		id = $(this).attr('id').substr(3);
		rowID =	id != getSelectedRow()? id : getSelectedRow();		setSelectedRow(rowID);		var domEl = $(this).get(0);  					tableSelected 	= domEl.offsetParent.id;
	});    $('img[id^="delete"]').live("click", function(e)	{							if(getSelectedRow()!= -1)		{
	    	$('#confirmation_question').html('<div class="cleaner h10"></div><?php   echo  $STR['Msg_Delete_Dialog']; ?><div class="cleaner h30"></div>');			 openModal('confirmation_dialog', 360, 150);		}	});
     $("#btnGotopreview").live("click", function(e)     {         	         	     	ToggleEditorTinyMCE('textarea');     	$( "#edit" ).hide( 'slide', {}, 200,$( "#preview" ).show( 'slide', {}, 200));		fillDataFields();
     	return false;     });	$("#btnSubmit").live("click", function(e)    {  
		updVacancy();    });     $("#btnGotoedit").live("click", function(e)     {
     	$( "#preview" ).hide( 'slide', {}, 200);     	$('#edit').show('slide', function()      	{			ToggleEditorTinyMCE('textarea');		});
     	return false;     });	$("#tblLanguages").flexigrid({				dataType: 'json',						
		singleSelect:true,		colModel : [										{display: '<?php   echo  $STR['Delete'];  ?>', name : 'Delete', width : 100, sortable : false, align: 'center'},			{display: '<?php   echo  $STR['Language'];  ?>', name : 'language', width : 395, sortable : false, align: 'center'},			{display: '<?php   echo  $STR['Domain'];  ?>', name : 'speak', width : 345, sortable : false, align: 'center'}			],						
		sortname: "",		sortorder: "",		usepager: false,					useRp: false,		rp: 15,		showTableToggleBtn: false,			
		height: 200	});    enableBasicTinyMCE('textarea', 950);      updateDataFields();
    restoreTables(); });function restoreTables(){
	for(var i = 0; i<aStudies.size();i++)	{			if(aStudies.getItemAt(i)[0] == '<?php   echo  $GLOBAL['noRequiredId']; ?>')		{			aStudies.removeAll();
			aStudies.addItem(new Array(aStudies.size(),			'<?php   echo  $STR['NoRequired']; ?>',			'---',			<?php   echo  $GLOBAL['noRequiredId']; ?>,			<?php   echo  $GLOBAL['noRequiredId']; ?>
			));			break;		}		else					if(aStudies.getItemAt(i)[0] > '3')
				aStudies.getItemAt(i)[2] = aStudies.getItemAt(i)[4];			}	for(var i = 0; i<aLanguages.size();i++)	{		if(aLanguages.getItemAt(i)[0] == '<?php   echo  $GLOBAL['noRequiredId']; ?>')		{
			aLanguages.removeAll();			aLanguages.addItem(new Array(aLanguages.size(),			'<?php   echo  $STR['NoRequired']; ?>',			'---',
			<?php   echo  $GLOBAL['noRequiredId']; ?>,			<?php   echo  $GLOBAL['noRequiredId']; ?>			));			break;		}
		else									aLanguages.getItemAt(i)[2] = aLanguages.getItemAt(i)[2]+'%';	}	flexAddDataRow(aStudies, '#tblStudies');	flexAddDataRow(aLanguages, '#tblLanguages');
}function updVacancy(){	var params = 	{
		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',        beforeSubmit:  	showRequest,        success:       	showResponse, 		error:   		errorResponse, 		type: 			'post', 		dataType:      	'json',
        data: 			{ 'opt': STATE_UPDVACANCY, 'aStudies':aStudies.toArray().join(','), 'aLanguages':aLanguages.toArray().join(','), 'vacancyId':'<?php   echo  $vacancyId; ?>', 'companyId':'<?php   echo  $companyId;  ?>'}    };	setRemoteRequest('#formID', params);}
function showRequest(formData, jqForm, options) {   	var finishAge = parseInt($("#FinishAge").val());    var initAge = parseInt($("#InitAge").val());
    var SalaryOffered = $('#SalaryOffered').val();    SalaryOffered = (SalaryOffered.replace("$","")).replace(",","");	if(isBlank($('#Requirements').val()))	{
		displayPrompt('#formID_waitdialog', '<?php   echo  $STR['EnterJobRequirements']; ?>', 'fail', false);        return false;	}	else	if(aStudies.size() <= 0)    {        
        displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_FormValidate_fail_list'].' '.$STR['StudySpecs']; ?>', 'fail', false);        return false;    }    else if(aLanguages.size() <= 0)    {        displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_FormValidate_fail_list'].' '.$STR['Language']; ?>', 'fail', false);        
    	return false;    }       else if(finishAge < initAge && initAge > 0)    {        displayPrompt('#formID_waitdialog', '<?php   echo  $STR['AgeOldError']; ?>', 'fail', false);       	return false;
    }    else if($('#VacancyType').val()!= '5' && ( SalaryOffered < <?php   echo  $GLOBAL['salaryOffered'];  ?>  || !$.isNumeric(SalaryOffered) ) )    {    	displayPrompt('#formID_waitdialog', '<?php   echo  $COMMON->str_replace($STR['SalaryOfferedError'], array('{salaryOffered}' => $GLOBAL['salaryOffered']) ) ; ?>', 'fail', false);       	return false;    }
	openOverlay();	displayPrompt('#formID_waitdialog', '', 'wait_progress', false);    return true; } 
function updateDataFields(){	$('#InitAge').trigger('change');}
function showResponse(data)  { 	closeOverlay();
	if(isBlank(data))	{		displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}
	if(data.state == STATE_UPDVACANCY)	{    										if(data.answer =='correct' )		{			top.location.href="<?php   echo  $php_self.'?page=company&companyId='.$companyId; ?>";
		}		displayPrompt('#formID_waitdialog', data.msg, data.answer, false);			}}
function errorResponse(data){	closeOverlay();	displayPrompt('#formID_waitdialog', '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);}
function addStudyLevel(){	closePromt('#AddStudyLevel');	var exist = false;
	var existNoRequired = false;	for(var i = 0; i<aStudies.size();i++){		if(aStudies.getItemAt(i)[1] == $("#StudyLevel option:selected").text() && aStudies.getItemAt(i)[2] == $("#StudyArea option:selected").text())				exist = true;		if(aStudies.getItemAt(i)[1] == '<?php   echo  $STR['NoRequired']; ?>')
			existNoRequired = true;	}	if(exist)	{		displayPrompt('#AddStudyLevel', '<?php   echo  $STR['StudyLevelDuplicated']; ?>', 'error', false);
		return false;		}		if(aStudies.size() == 5)	{		displayPrompt('#AddStudyLevel', '<?php   echo  $STR['LimitList'].', '.$STR['Maximum']; ?> '+aStudies.size(), 'error', false);
		return false;	}	if($('#StudyLevel').val() == -1)	{		displayPrompt('#AddStudyLevel', '<?php   echo  $STR['NeededSelectStudyLevel']; ?> ', 'error', false);
		return false;		}	if($('#StudyArea').val() == -1 && $('#StudyLevel').val() <=3 )	{		displayPrompt('#AddStudyLevel', '<?php   echo  $STR['NeededSelectStudyArea']; ?> ', 'error', false);
		return false;		}	if( isBlank($('#StudyAreaDME').val()) && $('#StudyLevel').val() >3 )	{		displayPrompt('#AddStudyLevel', '<?php   echo  $STR['NeededSelectStudyAreaDME']; ?> ', 'error', false);
		return false;		}	if(existNoRequired)	{		aStudies.removeAll();
	}	aStudies.addItem(new Array(aStudies.size(),	$("#StudyLevel option:selected").text(),	$('#StudyLevel').val() <=3 ? $("#StudyArea option:selected").text():$('#StudyAreaDME').val(),	$('#StudyLevel').val(),
	$('#StudyLevel').val() <=3 ? $("#StudyArea").val():$('#StudyAreaDME').val()	));	flexAddDataRow(aStudies, '#tblStudies');}
function confirmationYes(){	deleteRecord();	closeModal();}
function confirmationNo(){	closeModal();	}
function deleteRecord(){	if(tableSelected == 'tblStudies')	{		if(aStudies.getItemAt(0)[1] == '<?php   echo  $STR['NoRequired']; ?>')		{
				$('#StudyLevel').val(-1); selectStudyLevel(-1);		}		aStudies.removeItemAt(getSelectedRow()-1);		flexAddDataRow(aStudies, '#tblStudies');
	}	else if(tableSelected == 'tblLanguages')	{		aLanguages.removeItemAt(getSelectedRow()-1);		flexAddDataRow(aLanguages, '#tblLanguages');	}
}function selectStudyLevel(level){
		disableFormField('#formID','#StudyArea', false);		disableFormField('#formID','#ActualStatus', false);		disableFormField('#formID','#Relatedstudylevel', false);		disableFormField('#formID','#AddStudyLevel', false);		if(level == -1)
		{			$('#formrow_StudyArea').show();			$('#formrow_StudyAreaDME').hide();			disableFormField('#formID','#StudyArea', true);		}
		else if(level <= 3)		{			fillCombobox('#StudyArea', aStudyArea, {'comboTrigger': level,'value':'1', 'label':'2'});						$('#formrow_StudyArea').show();			$('#formrow_StudyAreaDME').hide();		}		
		else if(level == <?php   echo  $GLOBAL['noRequiredId']; ?>)		{				$('input[id=Relatedstudylevel]').attr('checked', true);			$('#formrow_StudyArea').show();			$('#formrow_StudyAreaDME').hide();
			disableFormField('#formID','#StudyArea', true);			disableFormField('#formID','#ActualStatus', true);			disableFormField('#formID','#Relatedstudylevel', true);			disableFormField('#formID','#AddStudyLevel', true);
			aStudies.removeAll();			aStudies.addItem(new Array(aStudies.size(),			'<?php   echo  $STR['NoRequired']; ?>',			'---',
			<?php   echo  $GLOBAL['noRequiredId']; ?>,			<?php   echo  $GLOBAL['noRequiredId']; ?>			));			flexAddDataRow(aStudies, '#tblStudies');
		}		else		{			$('#formrow_StudyArea').hide();			$('#formrow_StudyAreaDME').show();		}
}function flexAddDataRow(aParam, tableTagId){	var rowList 	= new Array();
	for(var i = 0; i<aParam.size();i++)	{		rowList[i] = {'id':(i+1),'cell':aParam.getItemAt(i)};		rowList[i]['cell'][0] = "<img src='..\/media\/icon\/_delete_min.png' style='cursor: pointer;' id='delete'>";	}
	$(tableTagId).flexAddData(		eval(		{"page":"1",		"total":aParam.size(),		"rows":rowList
		}	));	for(var i = 0; i<aParam.size();i++)	{		rowList[i] = {'id':(i+1),'cell':aParam.getItemAt(i)};
		rowList[i]['cell'][0] = i;	}}function selectAgeOld(age)
{	disableFormField('#formID','#FinishAge', false);	if(age == 0)	{		disableFormField('#formID','#FinishAge', true);
	}}function selectLanguage(language){	disableFormField('#formID','#Domain', false);
	disableFormField('#formID','#AddLanguage', false);	if(language == <?php   echo  $GLOBAL['noRequiredId']; ?>)	{		aLanguages.removeAll();
		aLanguages.addItem(new Array(aLanguages.size(),		'<?php   echo  $STR['NoRequired']; ?>',		'---',		<?php   echo  $GLOBAL['noRequiredId']; ?>,		<?php   echo  $GLOBAL['noRequiredId']; ?>		));
		flexAddDataRow(aLanguages, '#tblLanguages');		disableFormField('#formID','#Domain', true);		disableFormField('#formID','#AddLanguage', true);
	}}function addLanguage(){
	closePromt('#AddLanguage');	var exist = false;	var existNoRequired = false;	for(var i = 0; i<aLanguages.size();i++){
		if(aLanguages.getItemAt(i)[1] == $("#Language option:selected").text())				exist = true;		if(aLanguages.getItemAt(i)[1] == '<?php   echo  $STR['NoRequired']; ?>')			existNoRequired = true;	}
	if(exist)	{		displayPrompt('#AddLanguage', '<?php   echo  $STR['LanguageDuplicated']; ?>', 'error', false);		return false;		}
	if(aLanguages.size() == 5)	{		displayPrompt('#AddLanguage', '<?php   echo  $STR['LimitList'].', '.$STR['Maximum']; ?> '+aLanguages.size(), 'error', false);		return false;	}
	if($('#Language').val() == -1)	{		displayPrompt('#AddLanguage', '<?php   echo  $STR['NeededSelectLanguage']; ?> ', 'error', false);		return false;		}
	if($('#Domain').val() == -1)	{		displayPrompt('#AddLanguage', '<?php   echo  $STR['NeededSelectDomain']; ?> ', 'error', false);		return false;		}
	if(existNoRequired)	{		aLanguages.removeAll();	}
	aLanguages.addItem(new Array(aLanguages.size(),	$("#Language option:selected").text(),	$("#Domain option:selected").text(),	$("#Language").val(),	$("#Domain").val()	));
	flexAddDataRow(aLanguages, '#tblLanguages');	}function fillDataFields(){
	if($('input[name=ConfidentialMode]:checked', '#formID').val() == '<?php   echo  $GLOBAL['confidential_YES'];  ?>')	{		$("#vf_Company").html(confidentialtrademark);		$("#vf_About_lbl").hide();		$("#vf_About").html('');
		$("#vf_CompanyInfo").html('');		<?php  if(strlen($rData['tx_confidentialemail']) > 0)			 echo  '$("#vf_CompanyInfo").append(\'<li>'.$STR['SendByEmail'].': <a href="mailto:'.$rData['tx_confidentialemail'].'">'.$rData['tx_confidentialemail'].'</a></li>\');';		 ?>	}
	else	{		$("#vf_Company").html(companyName);		$("#vf_About_lbl").show();		$("#vf_About").html('<?php   echo  $rData['tx_about']; ?>');		$("#vf_CompanyInfo").html('');
		<?php  if(strlen($rData['tx_companyemail']) > 0)			 echo  '$("#vf_CompanyInfo").append(\'<li>'.$STR['SendByEmail'].': <a href="mailto:'.$rData['tx_companyemail'].'">'.$rData['tx_companyemail'].'</a></li>\');';		 ?>		<?php  if(strlen($rData['tx_web']) > 0)
			 echo  '$("#vf_CompanyInfo").append(\'<li>'.$STR['URLWeb'].': <a target="_blank" href="http://www.'.$rData['tx_web'].'">'.$rData['tx_web'].'</a></li>\');';		 ?>		<?php  if(strlen($rData['tx_facebook']) > 0)			 echo  '$("#vf_CompanyInfo").append(\'<li>'.$STR['LinkFacebook'].': <a target="_blank" href="http://www.facebook.com/'.$rData['tx_facebook'].'">'.$rData['tx_facebook'].'</a></li>\');';		 ?>				
		<?php  if(strlen($rData['tx_twitter']) > 0)			 echo  '$("#vf_CompanyInfo").append(\'<li>'.$STR['LinkTwitter'].': <a target="_blank" href="http://www.twitter.com/'.$rData['tx_twitter'].'">'.$rData['tx_twitter'].'</a></li>\');';		 ?>	}	$("#vf_Location").html($("#Location option:selected").text());
	$("#vf_Activity").html($("#WorkArea option:selected").text());	$("#vf_VacancyType").html($("#VacancyType option:selected").text());	$("#vf_JobExperiencealone").html($("#ExperienceTime option:selected").text());				$("#vf_vacancyName").html($("#VacancyName").val());       	$("#vf_ReferenceCode").html('<?php   echo  $vacancyId; ?>');
	$("#vf_StudySpecs").html('');	for( var i = 0 ; i < aStudies.size() ; i++)			if($("#vf_StudySpecs").html().indexOf(aStudies.getItemAt(i)[1]) == -1)		{			if($("#vf_StudySpecs").html().length > 0)
				$("#vf_StudySpecs").append(', ');			$("#vf_StudySpecs").append(aStudies.getItemAt(i)[1]);		}	var initAge = parseInt($("#InitAge").val());
	var finishAge = parseInt($("#FinishAge").val());    if(initAge == 0)        $("#vf_AgeOld").html('<?php   echo  $STR['AgeOld'].': '.$STR['NoRequired']; ?>');    else if(initAge == -1)        $("#vf_AgeOld").html('<?php   echo  $STR['AgeOld'].': '.$STR['SelectAge']; ?>');
    else if(finishAge == initAge)        $("#vf_AgeOld").html('<?php   echo  $STR['AgeOld']; ?>: '+initAge+' <?php   echo  $STR['Year'].'s'; ?>');    else if(initAge > 0 && finishAge == 0)        $("#vf_AgeOld").html('<?php   echo  $STR['AgeOld']; ?>: '+initAge+' <?php   echo  $STR['Year'].'s  '.$STR['Onwards']; ?>');    else if(finishAge == 100)      	$("#vf_AgeOld").html('<?php   echo  $STR['AgeOld']; ?>: '+initAge+' <?php   echo  $STR['Year'].'s  '.$STR['Onwards']; ?>');
    else    	$("#vf_AgeOld").html('<?php   echo  $STR['AgeOld']; ?>: '+initAge+' <?php   echo  $STR['Until']; ?> '+finishAge+' <?php   echo  $STR['Year'].'s'; ?>');	for( var i = 0 ; i < aGender.size() ; i++)		if(aGender.getItemAt(i)[0] == $('input[name=Gender]:checked', '#formID').val())	
			$("#vf_Gender").html('<?php   echo  $STR['Gender']; ?>: '+aGender.getItemAt(i)[1]);	for( var i = 0 ; i < aMaritalStatus.size() ; i++)		if(aMaritalStatus.getItemAt(i)[0] == $('input[name=MaritalStatus]:checked', '#formID').val())				$("#vf_MaritalStatus").html('<?php   echo  $STR['MaritalStatus']; ?>: '+aMaritalStatus.getItemAt(i)[1]);
    $("#vf_StudySpecsList").html('');    for( var i = 0 ; i < aStudies.size() ; i++)		{		if(aStudies.getItemAt(i)[1] == '<?php   echo  $STR['NoRequired']; ?>')
			$("#vf_StudySpecsList").append('<li>'+aStudies.getItemAt(i)[1]+'</li>');		else			$("#vf_StudySpecsList").append('<li>'+aStudies.getItemAt(i)[1]+', '+aStudies.getItemAt(i)[2]+'</li>');	}	if($('input[name=Relatedstudylevel]:checked', '#formID').val() == '<?php   echo  $GLOBAL['confidential_YES'];  ?>')
		    $("#vf_StudySpecsList").append('<li><?php   echo  $STR['RelatedstudylevelList']; ?></li>');	$("#vf_StudySpecsList").append('<div class="cleaner h20"></div>'+$('#OtherStudyRequires').val());
	$("#vf_LanguageRequires").html('');    for( var i = 0 ; i < aLanguages.size() ; i++)		{		if(aLanguages.getItemAt(i)[1] == '<?php   echo  $STR['NoRequired']; ?>')			$("#vf_LanguageRequires").append('<li>'+aLanguages.getItemAt(i)[1]+'</li>');		else
			$("#vf_LanguageRequires").append('<li>'+aLanguages.getItemAt(i)[1]+' '+aLanguages.getItemAt(i)[2]+'</li>');	}	$("#vf_JobExperience").html('');	$("#vf_JobExperience").append('<div class="cleaner h20"></div>'+$('#Requirements').val());
	$("#vf_WorkDetail").html('<div class="cleaner h20"></div>'+$('#ActivityDetail').val());}
