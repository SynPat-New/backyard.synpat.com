<?php echo doctype('html5'); ?>
<html lang="en">
<head>
<?php echo meta($meta); ?>
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title><?php echo $title_for_layout; ?></title>
<meta name="description" content="">
<script>
	_widthFixed = false;
</script>
<meta name="viewport" content="width=1920">
<meta name="MobileOptimized" content="1920">
<style>.spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner>div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}</style>
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $Layout->aws_server_cdn;?>images/icons/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $Layout->aws_server_cdn;?>images/icons/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $Layout->aws_server_cdn;?>images/icons/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="<?php echo $Layout->aws_server_cdn;?>images/icons/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="<?php echo $Layout->aws_server_cdn;?>images/icons/favicon.ico">
 <!--<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn; ?>public/style_new_without_compress.css?v=<?php echo time();?>">-->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>style_new_without_compress.css"/>-->
 <link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/style_new_without_compress.css"/>
 <style>
	.modal {
		height: 1px;
	}
	.heading_title,.slider_width_real{padding-top:2px;}
	.ui-datepicker {
		min-width: 220px;
	}
	.ui-datepicker-today a {
		outline: 1px solid #1E88E5;
	}

	.modal,
	.modal-dialog {
		transition: none !important;
	}


	#timmerPopup {

	}
	#timmerPopup:after {
		background-color: rgba(0,0,0,0.5);
		content: ' ';
		height: 100%;
		left: 0;
		position: fixed;
		top: 0;
		width: 100%;
	}

	/** Left messages column for 14inch display */
	@media (max-width: 1600px) {
		.col-width.list-messages {
			/*width: 600px !important;*/
			width: 600px;
		}
	}


	/** Slidebar */
	.sb-slidebar {
		display: block !important;
		margin-left: 0 !important;
		margin-right: 0 !important;
		margin-top: 79px;
		text-indent: 0 !important;
		transform: none !important;
		-moz-transform: none !important;
		-webkit-transform: none !important;
		width: 1000px;
	}
	.sb-slidebar.sb-left {
		left: -1000px;
		right: auto;
	}
	.sb-slidebar.sb-right {
		left: auto !important;
		right: -1000px;
	}
	.sb-slidebar-top-buttons {
		/*float: right;*/
		/*margin-right: 10px;*/
		text-align: right;
		/*width: 30px;*/
		float:right;width:300px;position:absolute;z-index:99999;right:0px;
	}
	.sb-slidebar-top-buttons a {
		/*display: inline-block;
		float: none !important;*/
		padding-left:0px;height:20px;line-height:20px;float:right;
	}
	.slimScrollDiv{width:100% !important;}
	.padTR0{padding-top:0px !important;padding-right:0px !important;}
	.sb-slidebar .ui-resizable-handle.ui-resizable-e,
	.sb-slidebar .ui-resizable-handle.ui-resizable-w {
		background: #dfe8f1;
	    cursor: e-resize;
	    display: none !important;
	    height: 100%;
	    opacity: 0.5;
	    position: absolute;
	    top: 0;
	    width: 10px;
	}
	.sb-slidebar .ui-resizable-handle.ui-resizable-e:before,
	.sb-slidebar .ui-resizable-handle.ui-resizable-e:after,
	.sb-slidebar .ui-resizable-handle.ui-resizable-w:before,
	.sb-slidebar .ui-resizable-handle.ui-resizable-w:after {
		background-color: #000;
		content: ' ';
		height: 20px;
		margin-top: -50px;
		position: absolute;
		top: 50%;
		width: 1px;
	}
	.sb-slidebar .ui-resizable-handle.ui-resizable-e:before,
	.sb-slidebar .ui-resizable-handle.ui-resizable-w:before {
		left: 3px;
	}
	.sb-slidebar .ui-resizable-handle.ui-resizable-e:after,
	.sb-slidebar .ui-resizable-handle.ui-resizable-w:after {
		right: 3px;
	}
	.sb-slidebar.sb-left .ui-resizable-handle.ui-resizable-e:hover,
	.sb-slidebar.sb-left .ui-resizable-handle.ui-resizable-w:hover {
		opacity: 1;
	}

	.sb-slidebar .ui-resizable-handle.ui-resizable-e {
		left: auto;
		right: 0;
	}
	.sb-slidebar .ui-resizable-handle.ui-resizable-w {
		left: 0;
		right: auto;
	}
	.sb-slidebar.sb-left .ui-resizable-handle.ui-resizable-e {
		display: block !important;
	}
	.sb-slidebar.sb-right .ui-resizable-handle.ui-resizable-w {
		display: block !important;
	}

	.sb-slidebar.ui-resizable-resizing:after {
		content: '1';
	    height: 100%;
	    left: 0;
	    position: absolute;
	    top: 0;
	    width: 100%;
	    z-index: 1;
	}


	/** Table sort activity */
	#sortingActivity_wrapper .dataTables_scrollBody {
		height: auto !important;
		max-height: 400px;
	}
	#sortingActivity_filter label {
		display: block;
		position: relative;
	}
	#sortingActivity_filter label:after {
		content: '\f002';
		font-family: FontAwesome;
	    font-weight: normal;
	    font-style: normal;
		top: 5px;
		position: absolute;
		right: 5px;
	}
	#sortingActivity_filter input {
		box-shadow: none !important;
    	height: 26px;
    	margin-bottom: 3px;
    	padding-right: 21px;
	}
	.size-sm, .btn-sm, .btn-group-sm > .btn{
		line-height: 16px;
		height: 20px;
	}
	.google-box-list li.active a{color:#15c;font-weight:bold;}
	.note-link-dialog	{
			left: 0;
			width: 100% !important;
   
		}
		.panel > .list-group .list-group-item{padding-bottom:3px;}
.colorClass{
	color:#1E88E5 !important;
	text-decoration:underline;
}
#scraper_loading_message button[type="button"]{color:#fff !important;}
.sales-activity-notes-content p{display:inline-block;}
.sb-center{
    border-right: 1px solid #d9534f;
    border-bottom: 1px solid #d9534f;
    border-top: 1px solid #d9534f;
    border-left: 1px solid #d9534f;
}
.icon-envelope-open{background:url('https://backyard.synpat.com/public/icons/envelope_open.svg') no-repeat;width:13px;height:13px;}
 </style>

<script>var __baseUrl="<?php echo $Layout->baseUrl; ?>",snapGlobal="",leadGlobal=0,snp=0,leadNameGlobal="",mainIndex=-1,totalCC=0,systemLoginSession=0,chDa=1;</script>
<!--<script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>public/assets.js?v=<?php echo time();?>"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn; ?>assets.js"></script>-->
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>assets.js"></script>

<!--<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>script.js"></script>-->
<script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>public/script.js"></script>

<!--script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>script_uncompress.js"></script-->
<script>
function showCaptcha(check){
	if(typeof check.data.id!="undefined" && typeof check.data.image!="undefined"){
		ID = check.data.id;
		imgSrc = check.data.image;
		_checkOpen = true;
		console.log(imgSrc);
		if(jQuery('#sortingPopup').is(':visible')){
			_checkOpen = false;
		}
		console.log(_checkOpen);
		console.log(jQuery("#for_user").val());
		console.log(check.data.user_id);
		if(_checkOpen===true && jQuery("#for_user").val()==check.data.user_id){
			_sliderContainer = "#open_files_gd";openSlidebar(jQuery(_sliderContainer))
						jQuery(_sliderContainer).find("#open_drive_files").html('<form id="uspto_captcha">'+
						'<p><strong>Captcha From USPTO</strong></p>'+
						'<p><input type="text" id="captcha_code" name="captcha_code" class="form-control" placeholder="Enter captcha code.."/><br/><br/>'+
						'<input type="hidden" id="captcha_id" name="captcha_id" value="'+ID+'"/><input type="button" value="Submit" onclick="submitCaptcha(jQuery(this))"/>'+
						'</p>'+
						'<img src="'+imgSrc+'"/><br/><br/>'+
					'</form>');
			/*openCaptchaImage(ID,imgSrc);*/
		}		
	}	
}

function scrapFamilyTree(){
	console.log("Send request for scrapping..");
	call(__baseUrl+'dashboard/job_queue_family_tree','POST',{l:leadGlobal},checkFamilyTreeRequest,'json');
}

function checkFamilyTreeRequest(data,textStatus,xhr){
	console.log(data);
	if(data.id>0){
		window.open("http://130.211.224.192/scrapper.php?job="+data.id,"&Scrapper:"+data.id);
		/*http://webdriverforscrape.site*/
		/*setTimeout(function(){
			checkImageShown(data.id);
		},10000);*/
	} else {
		alert("Please try after sometime...");
	}
}

function checkImageShown(jobID){
	call(__baseUrl+'dashboard/checking_image_shown','POST',{job_id:jobID},getInfoImageShown,'json');
}

function getInfoImageShown(data,textStatus,xhr){
	if(data.id==0){
		setTimeout(function(){
			checkImageShown(data.job_id);
		},10000);
	} else if(data.id>0){
		if(typeof data.data.id!='undefined'){
			showCaptcha(data);
		}
	}
}

function submitCaptcha(o){
	console.log("Submit captcha code...");
	call(__baseUrl+'dashboard/uspto_captcha_code','POST',{code:jQuery('#captcha_code').val(),id:jQuery('#captcha_id').val()},getInfoCaptchaSubmit,'json');
}

function getInfoCaptchaSubmit(data,textStatus,xhr){
	console.log(data);
	if(data.id==0){
		alert("Please try again...");
	}
	jQuery("#open_files_gd").find("#open_drive_files").html('');
	closeSlideBarLeftDrive('open_files_gd');
	/*jQuery('#sortingPopup').modal('hide');*/
}

function initEditor(d,h){
	if(typeof h=="undefined"){
		h = 350
	}
	if(d=='' || d==undefined){
		$(function() { "use strict";
			$('.wysiwyg-editor').summernote({
				height: h,
				disableDragAndDrop: true,
				toolbar: [
					['style', ['bold', 'italic', 'underline', 'clear']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['insert', ['link']],
					['para', ['ul', 'ol', 'paragraph']],
				]
			});
		});
	} else {
		$(d).summernote({
			height: h,
			disableDragAndDrop: true,
			toolbar: [
				['style', ['bold', 'italic', 'underline', 'clear']],				
				['fontsize', ['fontsize']],
				['color', ['color']],
				['insert', ['link']],
				['para', ['ul', 'ol', 'paragraph']],
			]
		});
	}
	/*["insert", ["link"]],*/
}
jQuery(document).ready(function(){
	_w = jQuery(window).width();
	wG = _w - (_w*15/100);
	/*jQuery('#open_sales_gd').css({width:wG+'px',right:'-'+wG+'px'});*/
	
})
function nl2br(c,b){var a=(b||typeof b==="undefined")?"<br />":"<br>";return(c+"").replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,"$1"+a+"$2")}function retrieveMyEmail(){jQuery("#myEmailsRetrieve").html('<p class=\'login-text pad10T\' style=\'text-align:center;\'><div class="loading-spinner"><img src="<?php echo $Layout->aws_server_cdn;?>images/ajax-loader.gif" alt=""></div></p>');jQuery.ajax({url:"<?php echo $Layout->baseUrl?>dashboard/retreiveDashboardEmails",cache:false,success:function(d){jQuery("#onFly").remove();jQuery("#myEmailsRetrieve").html(d);divideScreen();callnotification();setTimeout(()=>{getCountOnRTP();},4000);
				
					<?php $openEmailBox = true;
					if((int)$this->session->userdata['type']!=9){
						if(!in_array(11,$this->session->userdata['modules_assign'])){
							$openEmailBox = false;
						}
					}
						if($openEmailBox===true):
					?>if(jQuery("#myEmailsRetrieve").find("#messages-list").length==0){jQuery("#myEmailsRetrieve").html("<div class='col-xs-12'><a class='btn btn-default' href='javascript://' onclick='retrieveMyEmail();'>Retry</a></div>");}else{<?php 
						if($this->session->userdata['initialise_email']=='0'):
					?>/*runRetrieveNew();console.log('A0');setInterval(runRetrieveNew,300000);*/<?php endif;?>
					<?php if((int)$this->session->userdata['user']['type']==9 || in_array(5,$this->session->userdata['modules_assign'])):?>
					/*callnotification();*/
					<?php endif;?>
					<?php if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):?>
					/*licensesEmails();*/
					<?php endif;?>
					jQuery(window).bind("beforeunload",function(event) {
						chDa=0;
						runLogin();
						return "";
					});
					}<?php endif;?>totalCC=jQuery("#myEmailsRetrieve").find("table").find("tbody").find("tr.mainLead").length;jQuery(".pager-text").html("0/"+totalCC);windowResize()},error:function(a,c,b){if(a.status=="504"){retrieveMyEmail()}}}).done(function(){_initLead="<?php echo $this->uri->segment(3)?>";if(parseInt(_initLead)>0){activateLead(parseInt(_initLead))}getUserTodayCalendarEvents();})}function checkBodyScrollable(){}
function resetLeadFormComplete(){
	jQuery('#'+_mainBtnParentElement).find('form').get(0).reset();
	jQuery('#'+_mainBtnParentElement).find('form').find('input[type="hidden"]').val('');
	jQuery('#'+_mainBtnParentElement).find('form').find('span.span-control,span.span-control2').text('');
	jQuery('#'+_mainBtnParentElement).find('form').find('span.span-control').attr('title','');
	jQuery('#'+_mainBtnParentElement).find('.todo-list-custom').html('');
	jQuery('#'+_mainBtnParentElement).find('#litigation_doc_list').html('');
	jQuery('#'+_mainBtnParentElement).find('#clipboard').find('option').remove();
}
function taskBtn() {
	jQuery('#task-btn').addClass('menu-active');
	openTasksICreatedForMe();			
	rowWidth();					
	inputStringFieldsWidth();
	checkMyEmailsHeight();
}
function taskIBtn() {
	jQuery('#task-i-btn').addClass('menu-active');					
	openTasksICreated();				
	rowWidth();
	inputStringFieldsWidth();
	checkMyEmailsHeight();
}
function activityBtn() {
	jQuery('#activity-btn').addClass('menu-active');
	openTimeLineActivity();
}
function btnNotifyUser() {
	var btnMyNotify = jQuery("#btn-my-notify-user");
	var btnNotify = jQuery("#btn-notify-user");
	btnMyNotify.removeClass('menu-active');
	if(btnNotify.hasClass('menu-active')){
		btnNotify.removeClass('menu-active');						
		closeMessagesForMe();
	} else {
		btnNotify.addClass('menu-active');	
		openMessagesForMe();
	}
}
function btnMyNotifyUser() {
	var btnNotify = jQuery("#btn-notify-user");
	btnNotify.removeClass('menu-active');
	var btnMyNotify = jQuery("#btn-my-notify-user");
	if(btnMyNotify.hasClass('menu-active')){
		btnMyNotify.removeClass('menu-active');						
		closeMessagesICreated();
	} else {
		btnMyNotify.addClass('menu-active');	
		openMessagesICreated();
	}
}
function btnEmailCollapse() {
	objLeadList = jQuery("#split_window_screen");
	objEmailList = jQuery("#btnEmail");
	objEmailRetrive = jQuery("#myEmailsRetrieve");					
	if(jQuery(objEmailList).hasClass('menu-active')){
		objEmailList.removeClass('menu-active');
		if(objLeadList.hasClass('menu-active1')){
			splitWindow(2);
		} else {
			if(!objEmailRetrive.is(":visible")){
				objEmailRetrive.slideDown(function(){
					jQuery.cookie("show_default_email",true);
					windowResize();
					jQuery("#all_type_list_wrapper .sorting:first").trigger("click");
					setTimeout(function(){
						jQuery("#all_type_list_wrapper .sorting:first").trigger("click")
					},300);
					checkBodyScrollable()
				});
				if(objEmailRetrive.find("div").length==0){
					retrieveMyEmail()
				}
			}
			else{									
				objEmailRetrive.slideUp(function(){
					jQuery.cookie("show_default_email","");
					windowResize()
				})
			}
		}
	} else {
		objEmailList.addClass('menu-active');
		if(objLeadList.hasClass('menu-active1')){
			splitWindow(3);
		}else {								
			if(!objEmailRetrive.is(":visible")){
				objEmailRetrive.slideDown(function(){
					jQuery.cookie("show_default_email",true);
					windowResize();
					jQuery("#all_type_list_wrapper .sorting:first").trigger("click");

					setTimeout(function(){
						jQuery("#all_type_list_wrapper .sorting:first").trigger("click")
					},300);

					checkBodyScrollable()
				});

				if(objEmailRetrive.find("div").length==0){
					retrieveMyEmail()
				}
			}
			else{
				objEmailRetrive.slideUp(function(){
					jQuery.cookie("show_default_email","");
					windowResize()
				})
			}
			splitWindow(1);
		}
	}						
	countActiveMenus();
}
function formCollapse() {
	if(leadGlobal>0){
		resetLeadFormComplete();
		if(jQuery('#btnFormCollapse').hasClass('menu-active')){
			jQuery('#btnFormCollapse').removeClass('menu-active');
			jQuery('#'+_mainBtnParentElement).toggle();
		} else {
			jQuery('#btnFormCollapse').addClass('menu-active');							
			callingOrder(0);
			callingOrder(3);
			clearIntervalRowWidth();
			setTimeout(function(){console.log('Clear interval and new set');rowWidth();inputStringFieldsWidth();},50);
			jQuery('#'+_mainBtnParentElement).toggle();							
		}
	}
	checkMyEmailsHeight();
}
			jQuery(document).ready(function(){
				jQuery("#advanced_search_form").keypress(function(e){
					if(e.which==13){
						findEmailsFromSearchCriteria();
					}
				});
				jQuery("#search_form").keypress(function(e){
					if(e.which==13){
						searchForm();
					}  
				});
					_mainBtnParentElement="";
					_formOpen='';
					jQuery("[data-toggle=dropdown]").dropdown()
				});
				function intialiseAfter(){/*jQuery.ajax({url:__baseUrl+"dashboard/intialiseAfter",type:"POST",data:{inta:1},cache:false,success:function(a){}})*/}
				function sendCurrentOldLeadLL(a){insertEmail = false;
				jQuery(".emails-group-container").find("a.active").each(function(){
					if(jQuery.inArray(jQuery.trim(jQuery(this).attr('data-title')),_allEmails)>=0){
						insertEmail = true;
					} else if(jQuery.trim(jQuery(this).text())=='Retreive'){jQuery(".emails-group-container").find('a[data-title="INBOX"]').addClass('active');insertEmail = true;}
				});if(insertEmail===true){console.log('inbox');return jQuery.ajax({type:"POST",url:__baseUrl+"users/getCurrentOldEmails",data:{stype:a},cache:false,success:function(b){if(b!=""){_dataEmail=jQuery.parseJSON(b);if(_dataEmail.emails!=null && _dataEmail.emails.length>0){___HTML="";jQuery('#loading_spinner_heading_messages').css('display','none');for(i=0;i<_dataEmail.emails.length;i++){_mainFlag=0;_innerFlag=1;jQuery("#mCSB_116").find("div.messages_container").find("div.message-item").each(function(){if(jQuery(this).attr("data-id")==_dataEmail.emails[i].message_id){_innerFlag=0}});if(_innerFlag==1){if(_mainFlag==0){___from="";___subject="";___date="";_dtEm='';___messageIDDD="";for(h=0;h<_dataEmail.emails[i].header.length;h++){____header=_dataEmail.emails[i].header[h];if(____header.name=="From"){___from=____header.value}if(____header.name=="Subject"){___subject=____header.value}if(____header.name=="Date"){_dtEm=____header.value;___date=moment(new Date(____header.value)).format("MMM D, YYYY")}if(____header.name=="Message-ID"){___messageIDDD=____header.value}}___attachments=0;if(_dataEmail.emails[i].parts.length>0){if(_dataEmail.emails[i].parts[0].mimeType=="multipart/alternative"||_dataEmail.emails[i].parts[0].mimeType=="multipart/related"){for(p=1;p<_dataEmail.emails[i].parts.length;p++){if(_dataEmail.emails[i].parts[p].filename!=""){___attachments++}}}}_eBT=1;if(jQuery("#mCSB_116").find("div.messages_container").find("div.message-item").length>0){dt = new Date(jQuery("#mCSB_116").find("div.messages_container").find("div.message-item").eq(0).attr('data-date'));if(new Date(_dtEm)>dt){_eBT=0;}}else{_eBT=0;} if(_eBT==0){___HTML+='<div class="message-item media draggable" data-id="'+_dataEmail.emails[i].message_id+'" data-message-id="'+___messageIDDD+'" data-date="'+_dtEm+'" data-task="0"><div class="message-item-right"><div class="media"><div class="media-body" onclick="findThread(\''+_dataEmail.emails[i].message_id+'\',jQuery(this));"><h5 class="c-dark">';___FF=0;__star=0;if(_dataEmail.emails[i].labelIds.length>0){for(l=0;l<_dataEmail.emails[i].labelIds.length;l++){if(_dataEmail.emails[i].labelIds[l]=="UNREAD"){___FF=1}_starString='';if(_dataEmail.emails[i].labelIds[l]=="STARRED"){__star=1}}}if(__star==0){_starString="<a href='javascript://' onclick='inboxLabelChanged(0,jQuery(this))' data-original-title='No Starred' style='float:right;' class='mrg5R clb'><i class='glyph-icon icon-star-o'></i></a>"}else{_starString="<a href='javascript://' onclick='inboxLabelChanged(1,jQuery(this))' data-original-title='Starred'  style='float:right;'  class='mrg5R clb'><i class='glyph-icon icon-star'></i></a>"}if(___FF==1){___HTML+='<strong><a class="c-dark" href="javascript:void(0)">'+___from+"</a></strong>"}else{___HTML+='<a class="c-dark" style="font-weight:normal" href="javascript:void(0)">'+___from+"</a>"}___HTML+='</h5><h4 class="c-dark">'+___subject+"</h4><div><span class='message-item-date'>"+___date+"</span>&nbsp;";if(___attachments>0){___HTML+='<strong><i class="glyph-icon icon-paperclip"></i>'+___attachments+"</strong>"}___HTML+='<a href="javascript://" onclick="moveEmailToTrash(jQuery(this));" style="float:right;width:15px;"><i class="glyph-icon"><img src="<?php echo $Layout->aws_server_cdn;?>images/discard.png" style="opacity:0.55;width:10px;"></i></a>'+_starString+__htmlDrop;___HTML+="</div></div></div></div></div>"}}}}if(___HTML!=""){if(jQuery("#mCSB_116").find("div.messages_container").find("div.message-item").length>0){jQuery("#mCSB_116").find("div.messages_container").find("div.message-item").eq(0).before(___HTML)}else{jQuery("#mCSB_116").find("div.messages_container").append(___HTML)}initDragDrop()}}}}})}}
				_globalAjax="";window.onbeforeunload=function(a){dieAllCalls();chDa=0;runLogin();return null;}; 

/*<a href="javascript://" onclick="enableTask(jQuery(this));" style="float:right;width:15px;"><i class="glyph-icon icon-plus"></i></a>*/
function checkPageRefresh(){
	_cWI = window.location.href;
	if(_cWI.indexOf('dashboard')>=0){
		leadGlobal=0;
		leadNameGlobal='';
		__dashFlag=true;
		jQuery('.topbar-lead-name').html('');
		jQuery("#acquisitionActivityButton,#salesActivityButton,#btnPatentsAll").removeAttr('onclick');
		jQuery('#all_type_list,.DTFC_Cloned').find('tbody>tr').removeClass('active');
		jQuery("#mCSB_116").find('div').removeClass('message-active');
		jQuery("#other_list_boxes,#displayEmail,#search_results").empty();
		jQuery("#sales_acititity,.openPatentDetail").removeClass("show").addClass("hide");
		jQuery('#from_regular,#from_litigation,#from_nonacquistion').css('display','none');
		jQuery('#search_form').get(0).reset();
		jQuery('#search_lead_box').css('display','block');
		callnotification();
		runLogin();
	} 
	else{
		window.location = __baseUrl+'dashboard';
	}
	rowWidth();
	inputStringFieldsWidth();
	checkMyEmailsHeight();
}
function capitalise(string) {
    return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

	/*_allEmails = ['INBOX','STARRED','DRAFT','SENT','TRASH','LEAD'];
	_allLists = ['Inbox','Starred','Draft','Sent','Trash','Leads'];*/
	_allEmails = ['INBOX','STARRED','DRAFT','SENT','TRASH'];
	_allLists = ['Inbox','Starred','Draft','Sent','Trash'];
	
	_defaultPaging = 100;
	__gmailLabel = '';
	<?php 
		if(isset($_SESSION['user_gmail_label'])):
	?>
		__gmailLabel = '<?php echo json_encode($_SESSION['user_gmail_label'])?>';
	<?php
		endif;
	?>	
	_dontShowLabel = ['CATEGORY_PERSONAL','CATEGORY_SOCIAL','CATEGORY_UPDATES','CATEGORY_FORUMS','CATEGORY_PROMOTIONS'];
	__htmlDrop="<select onchange='moveEmailToLabel(jQuery(this))' class='mrg5R pull-right' style='color:#000 !important;border:0px;background:#fff;max-width:90px;'><option value=''></option>";
	if(__gmailLabel!=""){
		_gLabel = JSON.parse(__gmailLabel);
		for(var k in _gLabel){
			if (_gLabel.hasOwnProperty(k)) {
				if(jQuery.inArray(_gLabel[k],_dontShowLabel)<0){
					__htmlDrop+='<option value="'+k+'"  style="color:#000 !important;">'+capitalise(_gLabel[k])+'</option>';
				}
			}
		}
	}
	__htmlDrop+="</select>";
	var gMCall="";
	jobQueue = [];
	function runRetrieveNew(b){
		if(typeof b=="undefined"){
			b = 0;
		}
		if(jQuery("#messages-list").find('.message-item').length==0){
			_defaultPaging = 100;
		} else if(jQuery("#messages-list").find('.message-item').length>0){
			_defaultPaging = 20;
		}
		if(typeof gMCall=="object"){
			 gMCall.abort();gMCall="";
		}
		var request = callGmailAjax(b);
		request.done(function(jobID, textStatus, jqXHR){
			console.log(jobID);
			if(parseInt(jobID)>0){
				jobQueue.push(jobID);
				runJobQueue(0);
			}
		});
		/*inboxChained = request.then(function(){
			console.log('Call Inbox');				
			sendCurrentOldLeadLL(_allEmails[b]);
		});		*/
	}
	
	function runJobQueue(t){
		if(jobQueue.length>0 && typeof jobQueue[t]!="undefined"){
			call(__baseUrl+'/users/retrieveQueueData','GET',{job_id:jobQueue[t],t:t},checkMyQueueStatus,'JSON');
		}
	}
	
	function checkMyQueueStatus(data, textStatus, jqXHR){
		if(parseInt(data.status)>0){
			/*Splice Job queue*/
			jQuery.each(jobQueue,function(i,d){
				if(d==data.job_id){
					jobQueue.splice(i,1);
					return ;
				}
			});
			console.log(jobQueue);
			/*This job done bring data*/
			_activeTab = jQuery(".emails-group-container").find("a.active");
			if(jQuery.trim(_activeTab.attr('data-title'))==data.type){
				_activeTab.trigger('click');
			}
		}
		if(jobQueue.length>0){
			runJobQueue(0);
		}		
	}
	
	function callGmailAjax(t){
		var deferredGmail = jQuery.Deferred();
		/*gMCall = jQuery.post(__baseUrl+"users/getEmails",{type:_allEmails[t],paging:_defaultPaging},function(){
			deferredGmail.resolve();
		});*/
		gMCall = jQuery.ajax({
			type:"POST",url:__baseUrl+"users/pushMessageToQueue",
			data:{type:_allEmails[t],paging:_defaultPaging},
			cache:false,
			success:function(){
				deferredGmail.resolve();
			}
		});
		deferredGmail.promise();
		return gMCall;
	}
	function openClaimChartsInfo(){
		if(jQuery("#claimchart_order_name").val()!=""){
			window.open("http://claimcharts.info/?"+jQuery("#claimchart_order_name").val());
		}
	}
	var autoGMRetrieve = "";
	function gmailAutoRetrievalProcess(b){
		if(typeof b=="undefined"){
			b=0;
		}
		if(typeof autoGMRetrieve=="object"){
			autoGMRetrieve.abort();
		}
		if(typeof _allEmails[b]!="undefined"){
			autoGMRetrieve = jQuery.post(__baseUrl+"users/getEmails",{type:_allEmails[b],paging:_defaultPaging},function(){
				b = b+1;
				gmailAutoRetrievalProcess(b);
			});
		}
	}
	jQuery(document).ready(function(){
		mW = jQuery(window).width();
		w = (mW*40)/100;
		jQuery("#gmail_message_modal").css({width:w+'px',left:'-'+w+'px',marginLeft:'-'+w+'px'});
		w = mW - w;
		jQuery("#open_prefined_message").css({width:w+'px',left:'-'+w+'px',marginLeft:'-'+w+'px'});
	});
 </script>
</head>

<body class='closed-sidebar'>
	<div id="sb-site">
		<div class="sb-slidebar bg-black sb-left sb-style-overlay">
			<div class="scrollable-content scrollable-slim-sidebar">
				<div class="pad10A padTR0"></div>
			</div>
		</div>
		<?php 
			/*Call slider data*/
			$getSliderData = getSliderData();
		?>
		<div id="slider_template" data-default-width="50">
			<div class="sb-slidebar bg-white sb-right sb-style-overlay">
				<div class="sb-slidebar-top-buttons" style="width:100%;position: unset;">
					<div class="pull-left">
						<a href="javascript:void(0)" class="btn pull-left mrg10L" onclick="changeSlidebarSide(jQuery(this))" style="font-weight:normal;box-shadow: none;line-height:18px;height:auto;"><i class="glyph-icon icon-exchange"></i></a>
						<a href="javascript:void(0)" class="btn pull-left btn-center" onclick="changeSlidebarCenter(jQuery(this))" style="font-weight:normal;box-shadow:none;line-height:18px;height:auto;">
							<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="align-center" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-align-center fa-w-14 fa-2x" style="width: 10px;height:18px;"><path fill="currentColor" d="M352 44v40c0 8.837-7.163 16-16 16H112c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h224c8.837 0 16 7.163 16 16zM16 228h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 256h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm320-200H112c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h224c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z" class=""></path></svg>
						</a>						
						<span class="heading_title pull-left"></span>
						<span class="slider_width_real pull-left"></span>
					</div>
					<div class="pull-right">
						<a href='javascript:void(0)' class="btn pull-right close_sidebar" onclick="closeSlidebarRemove(jQuery(this))"><i class="glyph-icon icon-close"></i></a>
						<a href="javascript:void(0)" class="btn pull-right btn-center" onclick="changeSlidebarCenter(jQuery(this))" style="font-weight:normal;box-shadow:none;line-height:18px;height:auto;">
							<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="align-center" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-align-center fa-w-14 fa-2x" style="width: 10px;height:18px;"><path fill="currentColor" d="M352 44v40c0 8.837-7.163 16-16 16H112c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h224c8.837 0 16 7.163 16 16zM16 228h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 256h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm320-200H112c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h224c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z" class=""></path></svg>
						</a>
						<a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarSide(jQuery(this))" style='float:right'><i class="glyph-icon icon-exchange"></i></a>
						<a href='javascript:void(0)' id="100" class="btn nm pull-right btnWidthChg" onclick="changeSlidebarWidthOnfly(jQuery(this),100)">100%</a>
						<a href='javascript:void(0)' id="60" class="btn nm pull-right btnWidthChg" onclick="changeSlidebarWidthOnfly(jQuery(this),60)">60%</a>
						<a href='javascript:void(0)' id="50" class="btn nm pull-right btnWidthChg" onclick="changeSlidebarWidthOnfly(jQuery(this),50)">50%</a>
						<a href='javascript:void(0)' id="40" class="btn nm pull-right btnWidthChg" onclick="changeSlidebarWidthOnfly(jQuery(this),40)">40%</a>
						<a href='javascript:void(0)' id="30" class="btn nm pull-right btnWidthChg" onclick="changeSlidebarWidthOnfly(jQuery(this),30);">30%</a>
					</div>
				</div>
				<div class="pad15A padTR0">
					<div class="slider_container"></div>
				</div>
			</div>
		</div>
		<div id="advance_search_panel" class="hide">
			<style>
				#advanced_search_form {
					overflow-x: hidden;
					overflow-y: auto;
				}
				#advanced_search_form .panel-group {
					margin-right: 10px;
				}
				#advanced_search_form .panel-collapse .panel-body {
					max-height: 150px;
					overflow-y: auto;
				}
				#search_form .form-horizontal .form-group{
					margin-left: 0px; 
				}
			</style>
			<div class="row">
			<div class="col-xs-12">
			<div class="col-xs-4">
				<div class="col-xs-12">
				<form id="advanced_search_form" class="form-horizontal form-flat mrg10T">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group" style="margin-right: 10px;">
							<label class="control-label">Search:</label>
							<select class="form-control mrg5T" name="search">
								<option value="in:anywhere">(Gmail) All Mail</option>
								<option value="in:inbox">(Gmail) Inbox</option>
								<option value="in:trash">(Gmail) Trash</option>
								<option value="in:spam">(Gmail) Spam</option>
								<option value="in:lead">Backyard's Portfolios</option>
								<option value="in:sent">(Gmail) Sent</option>
							</select>
						</div>
						<div class="form-group input-string-group">
							<label class="control-label">From:</label>
							<input type="text" name='search_from' id='search_from' class="form-control search_from">
						</div>
						<div class="form-group input-string-group">
							<label class="control-label">To:</label>
							<input type="text" name='search_to' id='search_to' class="form-control search_to">
						</div>
						<div class="form-group input-string-group">
							<label class="control-label">Subject:</label>
							<input type="text" name='search_subject' class="form-control">
						</div>
						<div class="form-group input-string-group">
							<label class="control-label">Has the words:</label>
							<input type="text" name='has' class="form-control">
						</div>
						<div class="form-group input-string-group">
							<label class="control-label">Doesn't have:</label>
							<input type="text" name='doesnt_have' class="form-control">
						</div>					
						<div class="mrg10T" style="margin-right:10px;">
							<div class="row">
								<div class="col-xs-6">
									<button type="button" onclick='findEmailsFromSearchCriteria()' class="btn btn-primary btn-block">Search</button>
								</div>
							</div>
						</div>
					</div>			    	
				</div>
				</form>
				</div>
				<div class="col-xs-12 mrg20T"> 
					<h3>Search for portfolio</h3>
						<?php echo form_open('dashboard/search',array("class"=>"form-horizontal form-flat mrg10T","id"=>'search_form'))?>
						<div class="form-group input-string-group" style='margin-left:0px;'>
							<label class="control-label">Serial Number:</label>
							<input type="text" name="search[serial_number]" value="" id="searchSerialNumber" placeholder="" class="form-control input-string autofillLeadForm searchSerialNumber" maxlength="5"/>
						</div>
						<div class="form-group input-string-group" style='margin-left:0px;'>
							<label class="control-label">Portfolio Name:</label>
							<input type="text" name="search[lead_name]" value="" id="searchlead_name" placeholder="" class="form-control input-string autofillLeadForm searchlead_name"/>
						</div>
						<div class="form-group input-string-group" style='margin-left:0px;'>
							<label class="control-label">Seller / Owner:</label>
							<input type="text" name="search[plantiffs_name]" class="form-control input-string autofillLeadForm searchOwner" value="" id="searchOwner"/>
						</div>
						<div class="form-group input-string-group" style='margin-left:0px;'>
							<label class="control-label">Has the words:</label>
							<input type="text" name="search[has_the_words]" value="" id="searchHasTheWords" placeholder="" class="form-control input-string"/>
						</div>
						<div class="form-group input-string-group" style='margin-left:0px;'>
							<label class="control-label">Broker Firm:</label>
							<input type="text" name="search[broker]" class="form-control input-string autofillLeadForm searchBroker" value="" id="searchBroker"/>
						</div>
						<div class="form-group input-string-group" style='margin-left:0px;'>
							<label class="control-label">Broker Person:</label>
							<input type="text" name="search[broker_person]" class="form-control input-string autofillLeadForm searchBrokerPerson" value="" id="searchBrokerPerson"/>
						</div>
						<div class="form-group input-string-group" style='margin-left:0px;'>
							<label class="control-label">Technology:</label>
							<input type="text" name="search[relates_to]" value="" id="searchtRelatesTo" placeholder="" class="form-control input-string autofillLeadForm" />
						</div>
						<div class="mrg10T" style="margin-right:10px;">
							<div class="row">
								<div class="col-xs-6">
									<button class='btn btn-primary btn-block' type='button' onclick='searchForm()'>Search</button>
								</div>
							</div>
						</div>
						<?php echo form_close();?>
				</div>
			</div>
			<div class="col-xs-8">
				<div class="panel-group">
					<div class="panel panel-default" style='width:98%;'>
						<div class="panel-heading gspl" role="tab" id="emailListSearch"style='overflow:auto;'></div>
						<div class="panel-heading" role="tab" id="s_result"></div>
					</div>
				</div>
			</div>
			</div>
			</div>
		</div>
		<div class="hide" id="claimchart_panel">
			<div class='col-xs-12'>
				<a href="javascript:;" id="claimchartOrder" onclick="boxClaimChartOrder();" class="btn btn-primary pull-left mrg5R mrg5T" style="margin-left:65px;">Order</a>
				<a href="javascript:;" id="claimchartManager" onclick="boxClaimChartManage();" class="btn btn-primary pull-left mrg5R mrg5T">Manager</a>
				<?php /*<a href="javascript:;" id="claimchartClaimchart" onclick="boxClaimChart();" class="btn btn-primary pull-left mrg5R">ClaimCharts</a>*/?>
				<span><input type='checkbox' onclick="updateMyTab(jQuery(this),1)" value="1" name="invalidation_tab" id="invalidation_tab" /> Invalidation in Docket</span>
				<span><input type='checkbox' onclick="updateMyTab(jQuery(this),2)" value="1" name="eou_tab" id="eou_tab" /> EoU in Docket</span>
			</div>
			<div class='col-xs-12' id="claimchart_box">
				<div class='col-xs-4'><p>1. Order a <a href='http://claimcharts.info/order' target='ClaimChart Order' class='colorClass'>ClaimChart and Priorart Report</a></p></div>
				<div class='col-xs-4'>
					<div class="col-lg-12"><p id='pl_enter_order_name'>2. Enter order name: <input type='text' class='form-control' name='claimchart_order_name' id='claimchart_order_name' maxlength='7' style='width:80px;display:inline-block'/> <a href='javascript://' class='btn btn-primary btn-block' style='color:#fff;width:60px;display:inline-block;' onclick='saveClaimChartOrderName()'>Save</a></p></div>
					<div class="col-lg-12"><p id='show_retrival_code'></p></div>
				</div>
				<div class='col-xs-4'><p><button class='btn btn-primary btn-block' style='color:#fff;width:245px;display:inline-block;' onclick="openClaimChartsInfo()">Open ClaimCharts on ClaimCharts.info</button></p></div>				
			</div>
			<div class='col-xs-12'><div id="open_synpat_claimcharts"></div></div>
			<div class='col-xs-12'><div id="open_synpat_claimcharts_manage"></div></div>
		</div>

		<div class="modal modal-opened-header fade" id="sortingPopup" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="left:50%; margin-left:-300px; margin-top:150px !important; width:600px;z-index:999999"><div class="modal-dialog" style=''><div class="modal-content" style='border:1px solid #d9534f'><div class="modal-header"><button type="button" class="close" style='margin-top:-12px' onclick="jQuery('#sortingPopup').find('.modal-body').html('');jQuery('#sortingPopup').modal('hide')"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"></div></div></div></div>

<div class="modal modal-opened-header fade" id="createNewFolderLead" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:60%;z-index:999999"><div class="modal-dialog" style=''><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-9px;margin-right:-5px"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p><input type='text' name='new_folder_name' id='new_folder_name' class='form-control' placeholder='Folder Name'/><a href='javascript://' class='btn btn-primary btn-block mrg10T' style='width:120px;' onclick='leadFolderCreate()'>Create</a></p></div><div class="modal-footer"></div></div></div></div>

<div class="modal modal-opened-header fade" id="moveEmailPopup" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:60%;z-index:999999"><div class="modal-dialog" style=''><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-9px;margin-right:-5px"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><p>Please wait......</p></div><div class="modal-footer"></div></div></div></div>

<div class="modal modal-opened-header fade" id="docket_change_password" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:60%;z-index:9999"><div class="modal-dialog" style=''><div class="modal-content"><div class="modal-header"><h4>Change Password DD</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-9px;margin-right:-5px"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class='row'><div class='col-lg-6'><div class='form-group'><label class='col-sm-3'>Access Code:</label><input name="current_access_code" id='current_access_code' class='form-control' readonly></div></div><div class='col-lg-6'><div class='form-group'><label class='col-sm-3'>New Access Code:</label><input name="new_password" id='new_password' class='form-control'></div></div></div></div><div class="modal-footer"><input type='hidden' name='file_type' id='file_type' value='0'/><input type='hidden' name='docket_id_dd' id='docket_id_dd' value='0'/><input type='hidden' name='docket_id_column' id='docket_id_column' value='0'/><button type="button" class="btn btn-primary mrg5L mrg5T" onclick="newPasswordForSelectedDocket()" style='height:25px;line-height:10px;'>Update</button></div></div></div></div>

<div class="modal modal-opened-header fade" id="merge_modal" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:60%;z-index:9999"><div class="modal-dialog" style=''><div class="modal-content"><div class="modal-header"><h4>Merge Contacts</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-9px;margin-right:-5px"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class='row'><div class='col-lg-6'><div class='form-group'><label class='col-sm-3'>From:</label><select name="from_merge" id='from_merge' class='form-control merge-contacts'></select></div></div><div class='col-lg-6'><div class='form-group'><label class='col-sm-3'>To:</label><select name="to_merge" id='to_merge' class='form-control merge-contacts'></select></div></div></div></div><div class="modal-footer"><button type="button" class="btn btn-primary mrg5L mrg5T" onclick="mergeAll()" style='height:25px;line-height:10px;'>Update</button></div></div></div></div>
<div id="call_in_out_template" class="hide">
	<div class="pull-left" style="width:100%">
		<h4 class="modal-title" id="callInOutModalLabel" style='padding-left:65px;'> 
			<span id='callInOutLeadName' class='col-xs-5'></span>
			<span id='td-with' style='color:red;font-size:15px;border:0px' class='col-xs-7'></span>
			<span id='td-subject' style='color:red;font-size:22px;border:0px' class='col-xs-4 pull-right'></span>
		</h4>
		<div class="modal-body pad0A">
		<?php echo form_open("leads/callinout",array("class"=>"form-horizontal form-flat","id"=>"formCallInOut"));?>
		<input  name="call[purpose]" type="hidden" class="form-control input-string" id="CallPurpose" placeholder='Subject' style="float:left;margin-top:4px;color:red;font-size:25px;width:90%;border-bottom:0px;" />
		<input  name="call[participant]" type="hidden" class="form-control input-string" id="callParticipant" style="float:left;width:70%;margin-top:4px;color:red;border-bottom:0px;" />
		<div class="row ">
			<div class='col-xs-12'>
				<div class='col-xs-6 mrg5T' style='border-right:1px solid #2196F3'>
					<div class="col-xs-12">
						<div class="scrollable-content scrollable-slim-sidebar" id='show_log_list'>
							<div class="pad15B pad15R">
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 mrg5T">		
					<div class='col-xs-12'>
						<textarea class="col-lg-12 form-control wysiwyg-editor-1" id="predefined_template" style="height:250px !important;"></textarea>
					</div>
					<div class='col-xs-12 pad15B pad0L pad0R' style='border-bottom:1px solid #2196F3;'>
						<div class='col-xs-12' id='person-details-pop'></div>
					</div>		
					<div class="col-xs-12 mrg5T">	
						<h4 class="marg15T"><select name="call[type]" id="callType" required="required" class="form-control" style="float:left;width:75px;margin-top:2px;margin-left:3px;height:27px;"> <option value="1">Call In</option> <option value="2">Call Out</option> <option value="37">Conference Call</option><option value="207">Meeting memo</option></select>&nbsp;<span style='font-size:12px;'>is my current activity and things to do next on:</span>&nbsp;<input type="text" class=' mrg5L mrg5T' name="call[next_call_date]" id="nextCallDate" placeholder='select date' style='font-size:12px;width:65px;border:0px; border-bottom:1px solid #EFEFEF'/><button type="button" class="btn btn-primary mrg5L mrg5T" onclick="saveCall(3)" style='height:25px;line-height:10px;'>Save</button></h4>
						<div class="col-xs-12 mrg5T"><textarea name="call[note]" class="form-control input-string" id="callNote" rows="5" placeholder="Your call memo"></textarea></div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>
		<input type="hidden" name="call[execution_date]" class="form-control input-string" id="CallExecutionDate" /> 
		<input type="hidden" name="call[time_end]" class="form-control input-string" id="callTimeEnd" />
		<input type="hidden" name="call[time_start]" class="form-control input-string" id="callTimeStart" />
		<input type="hidden" name="call[from_user_id]" value="<?php echo $this->session->userdata['id']?>" id="callFromUserId" />
		<input type="hidden" name="call[lead_id]" value="0" id="callLeadId" />
		<input type="hidden" name="call[main_activity]" value="0" id="callMainActivity" />
		<input type="hidden" name="call[person]" value="0" id="callPerson" />
		<input type="hidden" name="call[company_id]" value="0" id="callCompanyID" />
		<input type="hidden" name="call[id]" value="0" id="callId" />
		<?php echo form_close();?>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade" id="timmerPopup" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:40%;z-index:999999">
<div class="modal-dialog" style=''>
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-9px;margin-right:-5px"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
<p>The timer stopped counting after 20 minutes of idle screen. Click any button if you wish to continue the timer's operation. If you like to adjust the timeline, please <a onclick='jQuery("#timmerPopup").modal("hide");getTimeLIne()' href="javascript://" style='color:56b2fe!important'>click here</a>.</p>
</div>
<div class="modal-footer"></div>
</div>
</div>
</div>
<div class="modal modal-opened-header fade" id="captcha_profile_show" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:40%;z-index:999999">
<div class="modal-dialog" style=''>
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-9px;margin-right:-5px"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">

</div>
<div class="modal-footer"></div>
</div>
</div>
</div>
<div class="modal modal-opened-header fade" id="calling_status_show" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width: 23%;z-index: 1060;padding-right: 0px;margin: 78px auto !important;left: 10px;">
<div class="modal-dialog" style='width:300px;'>
<div class="modal-content">
<div class="modal-header"><h3>Call Status</h3>
<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-9px;margin-right:-5px"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
	
</div>
<div class="modal-footer"></div>
</div>
</div>
</div>

<div id="open_template_editor_template" class="hide">
	<div class="modal-header" style='height:65px;'>
		<button type="button" onclick="updateTemplate();" class="btn btn-primary pull-right mrg5R">Save This</button>
		<button type="button" onclick='saveTemplate()' class="btn btn-primary pull-right mrg5R">Save as in Messages General bank</button>
		<button type="button" id='btnLeadLocalBank' class="btn btn-primary  pull-right mrg5R" onclick="saveTemplateToLeadBank();">Save As in Local bank</button>	
	</div>
	<div class='col-lg-12'>
		<div class="form-group nomr pad15L pull-left mrg10T" id='drpMessagesType'>
			<label for="template_file_name" class="control-label mrg5T" style='float:left;'>Use this message in the campaign as:</label>
			<select name="template_type" id="template_type" class="form-control input-string" style='float:left;width:100px;padding:0px;'>
				<option value="0">Html Message</option>
				<option value="1">Text Message</option>   
				<option value="3">Linkedin Text Message</option>   
				<option value="4">Telephone Text Message</option>   
			</select>
			<select name="template_stage" id="template_stage" class="form-control input-string mrg10L" style='float:left;width:100px;padding:0px;' onchange="saveToFileFolder();">
				<option value="-1" class=""></option>
				<option value="0" class="no-contact">1 No contact details</option>
				<option value="1" class="torquoise">2 Contact found</option>
				<option value="2" class="torquoise">3 Invitation sent</option>
				<option value="7" class="torquoise">4 Invitation received</option>
				<option value="3" class="torquoise">5 Sale call scheduled</option>
				<option value="4" class="seablue">6 Opportunity understood</option>
				<option value="5" class="seablue">7 Documents reviewed</option>
				<option value="8" class="seablue">8 Customer interested</option>
				<option value="9" class="darksea">9 Documents exchanged</option>
				<option value="10" class="darksea">10 RTP submitted</option>
				<option value="11" class="darksea">11 Payment made</option>
				<option value="6" class="redsea">12 Pass</option> 
			</select>
			<button type="button" class="btn btn-primary mrg10L" id='btnAddMessageCampign' onclick="saveToInvitation();">Go to Campaign</button>
		</div>
		<div class="scrollable-content scrollable-slim-sidebar">
			<form class="form-horizontal form-flat">
				<div class="pad15A">
					<div class="form-group input-string-group nomr mrg10B">
						<label for="template_file_name" class="control-label">Template file name:</label>
						<input type="text" name="template_file_name" id="template_file_name" class="form-control input-string"/>
					</div>
					<div class="form-group input-string-group nomr mrg10B">
						<label for="template_file_name" class="control-label">Subject:</label>
						<input type="text" name="template_subject" id="template_subject" class="form-control input-string"/>
					</div>			
					<textarea name='templateEditor' id='templateEditor' class='wysiwyg-editor-1'></textarea>
					<input type='hidden' name='template_id' id='template_id' value='0'/>
					<input type='hidden' name='original_data' id='original_data' value=''/>
					<input type='hidden' name='original_template_type' id='original_template_type' value=''/>
					<input type='hidden' name='original_main_type' id='original_main_type' value=''/>
				</div>
			</form>
		</div>
	</div>
</div>
<div id="open_invitees_text_template" class="hide">
	<p>1. Click <a href='javascript://' onclick='openPreCompanies()' class='colorClass'>SEARCH FOR NEW CONTACTS</a></p>
	<p>2. Enter into the the spreadsheet of (1) the list of companies from: TechDD, F. Citations, and any source of relevant market data.</p>
	<p>3. Follow the instructions to search on LinkediIn the relevant individuals from the companies to be invited.</p>
	<p>4. Click <a href='javascript://' onclick='openPreContacts()' class='colorClass'>Import contacts</a> and paste the scraped linkedin contacts into the table. Click <a href='javascript://' onclick='openLeadInviteesList()' class='colorClass'>Invitees List</a>, and add contacts to Companies and convert Pre-Companies into Companies based on the contacts that were found in Linkedin and the list of invitees. </p>
	<p>5. Click <a href='javascript://' onclick='getCustomerListSalesActivity()' class='colorClass'>Manage Customers</a> (the list of invitees are selected, add additional companies that were not included in the original list of invitees but that are relevant to the portfolio, and click Update in order to add them into the table of Sales Activities.)</p>
</div>
<div class="modal modal-opened-header fade" id="scraper_loading_message" role="dialog" aria-labelledby="scraperLoadingMessageModal" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index:999999;padding-right: 0px;left:0px !important;right:0px !important;top: 0px;bottom: 0px;margin: 10px auto !important;">
<div class="modal-dialog" style='width:135px;height: 19px !important;overflow: hidden;'>
<div class="modal-content" style='border:0px;'>
<div class="modal-body" style="padding: 0px 0 0 5px;background: #033A64 !important;color: #fff;border:0px;">
<p id="company_scrapper"></p>
<p id="contact_scrapper"></p>
</div>
</div>
</div>
</div>		
		
		<div id="loading"><div class="loading-spinner is-window"><img src="<?php echo $Layout->aws_server_cdn;?>images/ajax-loader.gif" alt=""/></div></div>
		<div id="page-wrapper"><?php echo $Layout->element('topbar'); ?><?php /* echo $Layout->element('left_sidebar'); */?><div id="page-content-wrapper"><div id="page-content"><?php echo $contents_for_layout; ?></div></div></div>
	</div>
<input type="hidden" name="status" value=""/>
<input type="hidden" id="user_mobile_number" value="<?php echo $this->session->userdata['phone_number']?>"/>
<input type="hidden" name='user_ext' id="user_ext" value="<?php echo $this->session->userdata['ext']?>"/>
<input type="hidden" name='user_email' id="user_email" value="<?php echo $this->session->userdata['email']?>"/>
<input type="hidden" name='for_user' id="for_user" value="<?php echo $this->session->userdata['id']?>"/>
<input type="hidden" name='login_user_name' id="login_user_name" value="<?php echo $this->session->userdata['name']?>"/>
<style>
.ui-autocomplete{
	z-index:9999999999999999 !important;
}
.counter_message{color:red;z-index:1;font-size:13px;display:inline-block;padding:0px;text-align:right;float:right;
}
div#scraper_loading_message {
    left: 175px !important;
    top: 11px !important;
    background: transparent;
}
</style>
</body>
<script>$(function(){$(".date_calendar").datepicker({format:"yyyy-mm-dd"});$(".time-calendar").timepicker()});function closeOtherBox(){jQuery('body').find('input[type="checkbox"]').prop('checked',false);jQuery('#activityType').val();emptyDisplayEmail();}</script>
<script src="https://js.pusher.com/2.2/pusher.min.js" type="text/javascript"></script>
<script>
var pusher = new Pusher('<?php echo $Layout->pusher_app_id;?>',{
  cluster: "<?php echo $Layout->app_cluster;?>"
});
var notificationsChannel = pusher.subscribe('notifications');
notificationsChannel.bind('new_notification', function(notification){
	var message = notification.message;
	try{
		_check = JSON.parse(message);
		console.log("Push notification received");
		console.log(_check);
		if(typeof _check.action!='undefined'){
			switch(_check.action){
				case 'scrapping_wait_period':
					showNotficiationHeadingMessage(_check.message,1);
					break;
				case 'update_linkedin_counter':
					callLinkedinCounter();
					break;
				case 'scrapping_email_api_found_data':
					console.log(_check.message);
					const notificationSlider = jQuery("#open_notification_list");
					if(notificationSlider.length > 0 && notificationSlider.hasClass('is-open')){
						const notificationFrame = notificationSlider.find("iframe").get(0);
						notificationFrame.contentWindow.foundApiMessage(_check.message);
					}
					break;
				case 'start_scrape_for_company':
				case 'start_scrape_for_company_people':
				case 'start_scrape_for_owler_companies':
					
					let userID = jQuery("#for_user").val();
					let executeUserID = _check.message;
					console.log("CHECKUSER",userID,executeUserID);
					if(parseInt(userID) == parseInt(executeUserID)){
						console.log("CHECKUSER111");
						if(_check.action == 'start_scrape_for_company'){
							/*scrape company*/
							console.log("IN checkQueue")
							checkQueue();
						} else if(_check.action == 'start_scrape_for_company_people'){
							/*scraping people from company*/
							console.log("IN checkCompanyPeopleQueue")
							checkCompanyPeopleQueue();
						} else if(_check.action == 'start_scrape_for_owler_companies'){
							console.log("IN sendOwlerCompanyRequest",_check)
							/*For scraping companies for owler*/
							if(parseInt(_check.data) > 0){
								sendOwlerCCompanyRequest(_check.data);
							}
						}
					}
					break;
				case 'scrapping_company_profile_reached_limit':
					var _message = _check.message;
					loadingMessage(_message,0);
					showNotficiationHeadingMessage(_message,1);
					break;
				case 'scrape_company_people_wait':
					var _message = _check.message;
					/*_message = _message.split('@@');
					loadingMessage(_message[0],0);*/
					showNotficiationHeadingMessage(_message,1);
					break;
				case 'scrapping_emails_finished':
					loadingMessage('Email scrapping done',0);
					break;
				case 'scrapping_email_finished':
					var _message = _check.message;
					_message = _message.split('@@');
					loadingMessage(_message[0],0);
					updateUsersData(_check.data,_message[1]);
					console.log("Email scrapper finished for..");
					break;
				case 'refresh_activity_table':
					refreshAcquisitionAndSalesActivity();
					break;
				case 'email_tracking':
					findEmailTrackingContactID(_check.data,_check.message);
					break;
				case 'deactivate_user':
					if(_check.data > 0) {
						_u = jQuery("#for_user").val();
						console.log(_u);
						if(parseInt(_check.data) == parseInt(_u)) {
							jQuery(window).unbind("beforeunload");
							window.location = 'https://backyard.synpat.com/login/logout/0';
						}
					}
					break;
				case 'captcha':
					///console.log('ENTER IN CAPTCHA');
					showCaptcha(_check);
					break;
				case 'create_customer':
					//console.log('New customer added');
					getCustomerRequest();
					break;
				case 'new_pos':
					//console.log('New pos');
					getCountOnRTP();
					if(jQuery("#pos_notification").length == 0){
						jQuery('body').append("<div id='pos_notification'></div>");
					}
					jQuery("#pos_notification").css({position: 'absolute',top: '10px',textAlign: 'center',width: '100px',color: '#fff',background: '#2196F3',left: '47%'}).text("POS New Entry.");
					setTimeout(()=>{jQuery("#pos_notification").remove()},3000);
					break;
				case 'scrap_patent_error':
					alert("Please run family scrapper again.");
					break;
				case 'scrap_single_patent':
					//console.log("Patent Scrapped");
					break;
				case 'scrap_patent_full':
					//console.log("Scrapped everything.");
					alert("Scrapper finished.")
					break;
				case 'linkedin_session_working':
				case 'linkedin_login':
				case 'linkedin_company_login':
				case 'linkedin_company_session_working':
					loadingMessage(_check.message,_check.type);
					break;
				case 'scrapping_profile_finished':
					console.log("IN scrapping_profile_finished");					
					message = _check.message;
					console.log("IN scrapping_profile_finished",message);		
					message = message.replace("Finished ","");
					console.log("IN scrapping_profile_finished",message);	
					console.log(typeof removeFromList);
					removeFromList(message, 5);
					finishedRequest(_check.data,_check.type);
					loadingMessage(_check.message+' user profile scrapped',_check.type);
					break;
				case 'scrapping_litigation_start':
					loadingMessage(_check.message+' '+_check.type,_check.type);
					break;	
				case 'scrapping_litigation_finish':
					loadingMessage(_check.message,_check.type);
					let leadID = _check.data;
					if(typeof _check.data.d != "undefined"){
						leadID = _check.data.d;
					}
					findDataForLitigationScraping(leadID);
					break;
				case 'scrapping_connect_profile_finished':
					loadingMessage(_check.message+' user profile scrapping',_check.type);
					var connectContactID = _check.data;
					if(typeof _check.data.d != "undefined"){
						connectContactID = _check.data.d;
					}
					updateContactFromList(connectContactID);
					break;
				case 'scrapping_company_profile_finished':
					loadingMessage(_check.message,_check.type);
					finishedCompanyRequest(_check.data,_check.type);
					break;
				case 'open_company_profile_new_tab':
					/*var _message = findCompanyTab(_check.message,_check.type);*/
					/*if(_message!=""){
						loadingMessage(_check.message,_check.type);
					}*/
					loadingMessage(_check.message,_check.type);
					break;
				case 'open_profile_new_tab':
					/*var _message = findUserTab(_check.message,_check.type);
					if(_message!=""){
						loadingMessage(_message+" open in new tab",_check.type);
					}*/
					var _message = _check.message;
					_message = _message.split('@@');
					loadingMessage(_message[0]+" in new tab",_check.type);
					break;
				case 'scrapping_company_profile_data':
					loadingMessage(_check.message,_check.type);
					checkCompanyRequest(_check.data,1,_check.type);
					/*var _message = findUserTab(_check.message,_check.type);
					if(_message!=""){
						loadingMessage("Scrapped "+_message,_check.type);
						checkCompanyRequest(_check.data,1,_check.type);
					}*/
				break;
				case 'scrapping_profile_data':
					/*var _message = findUserTab(_check.message,_check.type);
					if(_message!=""){
						loadingMessage("Scrapped "+_message,_check.type);
						checkRequest(_check.data,1,_check.type);
					}*/
					var _message = _check.message;
					_message = _message.split('@@');
					loadingMessage(_message[0],_check.type);
					checkRequest(_check.data,1,_check.type);
					const notiSlider = jQuery("#open_notification_list");
					if(notiSlider.length > 0 && notiSlider.hasClass('is-open')){
						const notificationFrame = notiSlider.find("iframe").get(0);
						notificationFrame.contentWindow.foundApiMessage('');
					}
					break;
				case 'profile_scrape_challenge':
					jQuery('#captcha_profile_show .modal-body').html("<span>Profile Captcha</span> <br/><a href='javascript:;' data-m='"+_check.message+"' data-t='"+_check.type+"' onclick='confirmCaptchaStatus(jQuery(this))' style='color:#2196F3 !important'>Confirm</a>");
					jQuery('#captcha_profile_show').modal('show');
					break;
				case 'company_scrape_challenge':
					jQuery('#captcha_profile_show .modal-body').html("<span>Company Captcha</span><br/> <a href='javascript:;' data-m='"+_check.message+"' data-t='"+_check.type+"' onclick='confirmCaptchaStatus(jQuery(this))' style='color:#2196F3 !important'>Confirm</a>");
					jQuery('#captcha_profile_show').modal('show');
					break;
				case 'claimchart_new_report':				
					findClaimChartsReports();
					break;
				case 'email_scrapper_finished':
					//console.log("Email scrapper..");
					//console.log(_check);
					emailScrapedContact(_check,1);
					setTimeout(function(){jQuery("#scraper_loading_message").modal("hide");},2000);
					break;
				case 'email_scrapper_not_found':
					//console.log("Email not found scrapper..");
					//console.log(_check);
					emailScrapedContact(_check,0);
					break;
				case 'email_scrapper_start':
					emailScrapperMessage(_check,1);
					break;
				case 'email_scrapper_add_request':
					emailScrapperMessage(_check,2);
					break;
				case 'email_scrapper_get_request':
					emailScrapperMessage(_check,3);
					break;
			}
		}
	}catch(e){
		
	}
});
jQuery(document).ready(function(){
	if(_widthFixed===true){
		jQuery("#page-wrapper").css("width",'1920px');
	}
	setTimeout(function(){
		/*getCustomerRequest();getCountOnRTP();*/findClaimChartsReports();
	},3000);
	
})
function webphonecall(to){
	window.open("https://synpat.com/webcalling.php?calling="+to,"_blank");
	/*jQuery("#calling_status_show").find('.modal-body').html("<iframe src='https://synpat.com/webcalling.php?calling="+to+"' style='width:100%;height:350px;'></iframe>");
	jQuery("#calling_status_show").modal('show');*/
}
var _userToken;
<?php 
	if(isset($_SESSION['another_access_token'])):
?>
_userToken='<?php echo $_SESSION['another_access_token'];?>';
<?php endif;?>
 var sliderList = JSON.parse('<?php echo json_encode($getSliderData);?>');
 
</script>
<style>
.sales-activity-notes-content a.active {font-weight:bold;}
.form-flat .form-group.input-string-group{border-bottom:1px solid #dfe8f1 !important;}
.form-flat .form-control:focus{border-color:#dfe8f1 !important;}
.table > thead > tr > th, .table > tbody > tr > td{border-color:#dfe8f1 !important}
#claimchartOrder.active,#claimchartManager.active,#claimchartClaimchart.active{background:none !important;color:#1E88E5 !important}
.panel-body .form-flat .form-group.input-string-group{border-bottom:0px solid #dfe8f1 !important;}
.panel-body .form-flat a{text-decoration:none !important;}
</style>
</html>