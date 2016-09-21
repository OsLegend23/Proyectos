<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>$(document.body).ready(function(){	  
	$("#TableRecords").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opc', value: 'getPostulants'}, {name:'vacancyId', value: '<?php   echo  $vacancyId; ?>'}],			singleSelect:true,
			colModel : [											{display: '<?php   echo  $STR['Delete'];  ?>', name : 'Delete', width : 90, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['StudyLevel'];  ?>', name : 'StudyLevel', width : 300, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['StudyArea'];  ?>', name : 'StudyArea', width :300, sortable : false, align: 'left'}								],									sortname: "",
			sortorder: "",			usepager: true,						useRp: false,			rp: 15,			showTableToggleBtn: false,						height: 500
	});});
