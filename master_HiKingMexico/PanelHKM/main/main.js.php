<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var STATE_GETPOSTULANTINFO		= "getpostulantinfo";var STATE_GETCOMPANYINFO		= "getcompanyinfo";
var STATE_GETHITSCOUNTERINFO	= "gethitscounter";var STATE_GETVACANCYINFO		= "getvacancyinfo";$(document.body).ready(function(){	  
	$('#btnGetPortalInfo').live("click", function(e)	{		getpostulantinfo();		getcompanyinfo();
		gethitscounter();		getvacancyinfo();		$('#totalPostulants, #totalCompanies, #totalHitsCounter, #totalVacancies').html('<img src="<?php   echo  $COMMON->getMedia('icon', 'wait.gif'); ?>">');
		return false;	});});function getpostulantinfo()
{		var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',
	    data: 			{ 'opt': STATE_GETPOSTULANTINFO}	};		setAjaxRemoteRequest(params);}
function setpostulantinfo(data){		$('#totalPostulants').html(data.totalPostulants);	$('#totalAutenticated').html(data.totalAutenticated);	$('#totalUnAutenticate').html(data.totalUnAutenticate);	$('#unVerified').html(data.unVerified);
}function getcompanyinfo(){		var params = 	{
		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_GETCOMPANYINFO}	};	
	setAjaxRemoteRequest(params);}function setcompanyinfo(data){		$('#totalCompanies').html(data.totalCompanies);
	$('#totalAutenticatedCompanies').html(data.totalAutenticatedCompanies);	$('#totalUnAutenticateCompanies').html(data.totalUnAutenticateCompanies);	$('#unVerifiedCompanies').html(data.unVerifiedCompanies);}function gethitscounter()
{		var params = 	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',
	    data: 			{ 'opt': STATE_GETHITSCOUNTERINFO}	};		setAjaxRemoteRequest(params);}
function sethitscounter(data){		var totalHitsCounter = 0;	$("#tableHitsCounter").find("tr:gt(0)").remove();
	$.each(data, function(index, array)	{				if(array!='gethitscounter')		{							$('#tableHitsCounter tr:last').after('<tr> <td>'+array[0]+'</td> <td>'+array[1]+'</td> <td>'+array[2]+'</td> <td>'+array[3]+'</td> <td>'+array[4]+'</td> <td>'+array[5]+'</td> <td>'+array[6]+'</td> <td>'+array[7]+'</td> <td>'+array[8]+'</td> <td>'+array[9]+'</td> <td>'+array[10]+'</td> <td>'+array[11]+'</td> <td>'+array[12]+'</td> <td>'+array[13]+'</td> </tr>');			totalHitsCounter += array[13];
		}	});	$("#totalHitsCounter").html(totalHitsCounter);
}function getvacancyinfo(){	var params = 
	{		url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',		type: 			'post',		dataType:      	'json',	    data: 			{ 'opt': STATE_GETVACANCYINFO}	};	
	setAjaxRemoteRequest(params);}function setvacancyinfo(data)
{	$("#tableTopPublicated").find("tr:gt(0)").remove();	$.each(data, function(index, array)	{
		if(array!='getvacancyinfo' && !isBlank(array[1]))			{							$('#tableTopPublicated tr:last').after('<tr> <td>'+array[0]+'</td> <td>'+array[1]+'</td> </tr>');		}	});
	$("#totalVacancies").html(data.totalVacancies[0]);}function showRequest(formData, jqForm, options) {   	
    return true; } function showResponse(data)  
{ 	if(isBlank(data))	{		return false;	}
	if(data.state == STATE_GETPOSTULANTINFO)	{		setpostulantinfo(data);	}	if(data.state == STATE_GETCOMPANYINFO)
	{		setcompanyinfo(data);	}	if(data.state == STATE_GETHITSCOUNTERINFO)	{
		sethitscounter(data);	}	if(data.state == STATE_GETVACANCYINFO)	{		setvacancyinfo(data);
	}}function errorResponse(data){
}
