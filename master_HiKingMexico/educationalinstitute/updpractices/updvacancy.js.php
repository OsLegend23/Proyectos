<?php if(!isset($COMMON)){ echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();} ?>var rows = new Array();$(document.body).ready(function()
{	  		$("#TableLikeStudies").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opc', value: 'getPostulants'}, {name:'vacancyId', value: '<?php   echo  $vacancyId; ?>'}],
			singleSelect:true,			colModel : [											{display: '<?php   echo  $STR['Delete'];  ?>', name : 'Delete', width : 90, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['StudyLevel'];  ?>', name : 'StudyLevel', width : 300, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['StudyArea'];  ?>', name : 'StudyArea', width :300, sortable : false, align: 'left'}								],						
			sortname: "",			sortorder: "",			usepager: false,						useRp: false,			rp: 15,			showTableToggleBtn: false,			
			height: 200		});		 $("#AddStudyLevel").live("click", function(e)         {                                    				rows.push({cell: [1, 2, 3] });							
				var data = {				    total: 3,    				    page:2,				    rows: rows				}
				$('#TableLikeStudies').flexAddData(data);//.flexReload();                return false;                });
		$("#TableLikeLanguages").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',			dataType: 'json',						params:[{name:'opc', value: 'getPostulants'}, {name:'vacancyId', value: '<?php   echo  $vacancyId; ?>'}],
			singleSelect:true,			colModel : [											{display: '<?php   echo  $STR['View'];  ?>', name : 'preview', width : 90, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Name'];  ?>', name : 'name', width : 200, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['AgeOld'];  ?>', name : 'age', width :120, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['StudyLevel'];  ?>', name : 'studylevel', width : 200, sortable : false, align: 'left'}				
				],									sortname: "",			sortorder: "",			usepager: false,						useRp: false,			rp: 15,
			showTableToggleBtn: false,						height: 200		});		$("#TableLikeWorkExperience").flexigrid({			url: '<?php   echo  $viewpage.'/'; ?>remote.php',
			dataType: 'json',						params:[{name:'opc', value: 'getPostulants'}, {name:'vacancyId', value: '<?php   echo  $vacancyId; ?>'}],			singleSelect:true,			colModel : [											{display: '<?php   echo  $STR['View'];  ?>', name : 'preview', width : 90, sortable : false, align: 'center'},				{display: '<?php   echo  $STR['Name'];  ?>', name : 'name', width : 200, sortable : false, align: 'left'},
				{display: '<?php   echo  $STR['AgeOld'];  ?>', name : 'age', width :120, sortable : false, align: 'left'},				{display: '<?php   echo  $STR['StudyLevel'];  ?>', name : 'studylevel', width : 200, sortable : false, align: 'left'}								],									sortname: "",			sortorder: "",			usepager: false,			
			useRp: false,			rp: 15,			showTableToggleBtn: false,						height: 200		});
});