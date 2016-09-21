<?php 

if(!isset($COMMON)){ 
    echo  "<body onLoad=window.setTimeout(top.location.href='../index.php',0)></body>";die();
} ?>
var consult 			= '<?php   echo  isset($_REQUEST['consult'])? $_REQUEST['consult']:'simplequery';  ?>';
var company 			= '<?php   echo  $_REQUEST['companyid'];  ?>';
var area 				= '<?php   echo  $_REQUEST['area'];  ?>';
var city 				= '<?php   echo  $_REQUEST['city'];  ?>';
var keyword 			= '<?php   echo  $_REQUEST['keyword'];  ?>';
var launcherId			= '';
var totalRows			=0;
var page				=1;
var rowsPerPage			=10;
var aArea 		        = new ArrayCollection();
var aStudyArea 	        = new ArrayCollection();
<?php 	
$COMMON->fillArrayCollection('aArea', 
                             $QUERY->getWorkArea('ORDER BY a.tx_description'), 
                             array('id', 'workarea_tx_description'), 
                             array('-1',$STR['AllArea']), 
                             true );
$query=$COMMON->fillArrayCollection('aStudyArea',
                             $QUERY->getStudyArea('WHERE id_studylevel != "9999" ORDER BY tx_description'),
                             array('id_studylevel','id','tx_description'),
                             array('9999','-1',$STR['AllStudyArea']),
                             true);
?>
$(document.body).ready(function(){
    $('#companyscroll').carouFredSel({ 
        auto: {
            pauseOnHover: 'resume'            
        },
        prev: '#prev2',
        next: '#next2',
        mousewheel: true,
        scroll : 
        {
            items           : 5,
            easing          : "elastic",
            duration        : 2000,                         
            pauseOnHover    : true        
        },
        swipe: 
        {
            onMouse: true,
            onTouch: true            
        }
    });	
    consultType(consult);	
    getMenuSelected(consult);	
    fillCombobox('#workArea', aArea, {'value':'0', 'label':'1'});
	fillCombobox('#studyArea', aStudyArea, {'comboTrigger': '1','value':'1', 'label':'2'});
    initParams();	
    
    $('button[class^="flanges"]').live("click", function(e) {
        consult = $(this).attr('id');		
        getMenuSelected(consult);		
        consultType(consult);		
        return false;	
    });

	$("#btnSubmit").live("click", function(e) {
        searchVacancy();	
    });
	
    $('#studyLevel').live("change", function(e)	{
        fillCombobox('#studyArea', aStudyArea, {'comboTrigger': $(this).val(),'value':'1', 'label':'2'});
    });	
    
    launcherId = 'formID_waitdialog';
	$('#btnSubmit').trigger('click');	
    
    $("#prev,#prev2").live("click", function(e) {
        if(page>1)
            page -= parseInt(1);
		else {
            page = 1;
            return false;		
        }
		launcherId = $(this).attr('id');
        $('#btnSubmit').trigger('click');
        return false;    
    });
	
    $("#next,#next2").live("click", function(e) {
        page++;		
        if(page>totalPages) {
            page = totalPages;
            return false;
        }
        launcherId = $(this).attr('id');
		$('#btnSubmit').trigger('click');
        return false;
    });
});

function searchVacancy() {
    var params = {
        url: 			'<?php   echo  $viewpage.'/'; ?>remote.php',
        beforeSubmit:  	showRequest,
        success:       	showResponse,
        error:   		errorResponse,
        type: 			'post',
        dataType:      	'json',
        data: 			{ 'opt': consult, 'company':company, 'area':area, 'page':page, 'rowsPerPage':rowsPerPage}
    };
    setRemoteRequest('#formID', params);
    
    if(consult == 'company')
        consult = 'simplequery';
}

function initParams() {
    if(!isBlank(keyword)) {
        $('#keyword').val(keyword);	
    }	
    if(!isBlank(city)) {
        $('#location').val(city);
	}
    if(!isBlank(area)) {
        $('#workArea').val(area);
    }
}

function showRequest(formData, jqForm, options) {
    openOverlay();	
    displayPrompt('#'+launcherId, '', 'wait_progress', false);
    return true; 
} 

function showResponse(data) {
    closeOverlay();
    closePromt('#'+launcherId);
    totalRows			= data.total;
    page				= data.page;
    totalPages 			= (Math.round(totalRows/rowsPerPage)) < (totalRows/rowsPerPage) ? (Math.round(totalRows/rowsPerPage)+1):Math.round(totalRows/rowsPerPage);	
    
    if(totalRows == 0) {
        $('.paginator').hide();
        $('#vacancyRequestList').html('');
        $('#vacancyRequestList').html("<div class='card col l12 s12 white' style='padding: 0 .7em; text-align:center;'><p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><strong><?php   echo  $STR['VacancyNotFound']; ?></strong></p></div>");	
    } else {
        $('.paginator').show();
        $('.list_paginator').html('<?php   echo  $STR['Page']; ?>  '+page+'/'+totalPages);
		$('#vacancyRequestList').html('');		
    }
    $.each(data.rows,
        function(index, array) {
            var tx_tradename				=array.tx_tradename;
            var idVacancy					=array.idVacancy;
            var fileImage					=array.fileImage;
            var tx_name						=array.tx_name;
            var labelVacancyType			=array.labelVacancyType;
            var vacancytype					=array.vacancytype;
            var day 						=array.day;
            var month 						=array.month;
            var year 						=array.year;
            var labelLocation				=array.labelLocation;
            var location					=array.location;
        $("#vacancyRequestList").append('<a href="<?php   echo  $COMMON->getRoot(); ?>vacancy/?vcn='+idVacancy+'"><div class="card-panel"><div class="infoPanel row valign-wrapper"><div class="logo col s3"> <img class="responsive-img" src="'+fileImage+'" alt="'+tx_tradename+'" class=" ui-corner-all" /> </div> <div class="info col s10"><h4 class="titleJob">'+tx_name+'</h4> <p class="company"><span class="companyName">'+tx_tradename+'</span><span class="location mdi-communication-location-on"><span style="font-family: Roboto,sans-serif;"> '+location+'</span></span></p><p class="vacancyType"><span><b>'+labelVacancyType+': </b>'+vacancytype+'</span><span class="location"><b>Publicación: </b>'+day+'/'+month+'/'+year+'</span></p></div> <div class="cleaner"></div><div class="cleaner"></div></div></div></div></a>');
	});
}

function errorResponse(data) {
    closeOverlay();	
    closePromt('#waitdialog');
}

function consultType(consult) {
    $('#formrow_keyword').hide();
    $('#formrow_workArea').hide();
    $('#formrow_location').hide();
    $('#formrow_studyLevel').hide();
    $('#formrow_studyArea').hide();
	
    if(consult == 'advancedquery') {
        $('#formrow_workArea').show();
        $('#formrow_location').show();
    }
	else if(consult == 'practices')	{
        $('#formrow_studyLevel').show();
        $('#formrow_studyArea').show();
        $('#formrow_location').show();
    }
	else {
        $('#formrow_keyword').show();
        $('#formrow_location').show();
    }
}
