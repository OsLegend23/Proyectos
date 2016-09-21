<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var aAnnualPlan 			= new ArrayCollection();var tagId 					= 'formID_waitdialog';var STATE_SENDANNUALPLAN 	= 'sendannualplan';
<?php  	$COMMON->fillArrayCollection('aAnnualPlan' 		, $rGetAnnualPlan		, array('id','tx_name','tx_cost', 'tx_description')
		, array('-1',$STR['SelectPlan'])		, true); ?>$(document.body).ready(function(){	  
	 fillCombobox('#plan', aAnnualPlan, {'value':'0', 'label':'1'});	 $('#plan').live("change", function(e){		if($(this).val() > 0)		{
		 $('#annualPosts').val(aAnnualPlan.getItemAt($(this).val())[3]);		 $('#postsCost').val(aAnnualPlan.getItemAt($(this).val())[2]);			}		return false;	});
	 $('.more').live("click", function(e){		$('#plan').val($(this).attr('id'));		$('#plan').trigger('change');		$('#btnSubmit').focus();
		return false;	});	 $("#btnSubmit").live("click", function(e)    {  
		sendAnnualPlan();    }); 	 enableBasicTinyMCE('textarea', 620);   });
function sendAnnualPlan(){	var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',
        beforeSubmit:  	showRequest,        success:       	showResponse, 		error:   		errorResponse, 		type: 			'post', 		dataType:      	'json',        data: 			{ 'opt': STATE_SENDANNUALPLAN, 'aAnnualPlan':JSON.stringify(aAnnualPlan.toArray())}
    };	setRemoteRequest('#formID', params);}
function showRequest(formData, jqForm, options) {   		openOverlay();	displayPrompt('#'+tagId, '', 'wait_progress', false);    return true; } 
function showResponse(data)  { 	closeOverlay();
	if(isBlank(data))	{		displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);		return false;	}
	if(data.state == STATE_SENDANNUALPLAN)	{		clearForm("formID");		displayPrompt('#'+tagId, data.msg, data.answer, false);
		$('#companyPlanStatus').html(data.msg);	}}function errorResponse(data){
	closeOverlay();	displayPrompt('#'+tagId, '<?php   echo  $STR['Msg_WebError']; ?>', 'error', false);}
