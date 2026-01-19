<style>
#emailListSearch .message-item {
	background:#fff;
	border-top: 1px solid #dfe8f1;
	padding-bottom:4px;
	padding-top:5px;
}
#emailListSearch .message-item.message-active {
	background:#2196f3;
	color:#fff;
}
.bs-badge.badge-absolute {
	left: 4px !important;
	top: -15px !important;
}
#page-header .dropdown .bs-badge.badge-absolute,  #page-header .header-btn .bs-badge.badge-absolute {
	left: 11px !important;
	top: -12px !important;
}
.ui-autocomplete {
	max-height: 350px;
	/*max-width:285px;*/
            overflow-y: auto;
	/* prevent horizontal scrollbar */
            overflow-x: hidden;
	/* add padding to account for vertical scrollbar */
            padding-right: 20px;
}
#page-header .user-account-btn{ float:right!important;}
.main-header-custom{ float:left; /*padding-right:10px;*/}
#header-nav-right .dropdown{ display:inline!important;}
.header-nav-right{ width:60%; margin-left:0!important;}
#header-nav-right ul{ padding-left:0; float:left; margin:0;}
#header-nav-right ul li  {
list-style:none;
}
.main-header-custom .header-nav > li > ul{padding-top:0px !important;}
/*#header-nav-right{ float:left!important;}*/
/*.icon-angle-down{ float:right;} */
#header-nav-right ul li a { width:auto;}
#header-nav-left{ text-align:left; width:52px;}
#page-header .user-account-btn > a.user-profile{ min-width:inherit!important;}
.today_user_event{margin:2px 0 0 0;list-style:none;height:77px;overflow-x:none;overflow-y:auto;padding:0px !important;}
.today_user_event li{float:left;width:100%;padding-top:1px;}
.main-header-custom ul.header-nav >li, .today_user_event li{margin-bottom:6px;}
.today_user_event li a{color:#fff;}
.value{ font-size:13px!important;}
.downArrow{ line-height:20px!important; width:10px!important;}
#header-logo{ height:60px;	}
.breadcrumb{padding-left:0px;}
.breadcrumb-wrapper{ left:3px; top:52px;}
.breadcrumb li{ margin-right:5px!important;}
.topbar-lead-name{ margin-left:5px!important;}
/*#close-sidebar, .breadcrumb-wrapper{ left:0!important;}*/
@media(max-width:1280px){
	.main-header-custom{padding-right:1px;}
}
.user-account-btn img{border-radius:0px;}
.login-box .user-img{height:90px;width:auto;max-width:90px;}
</style>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>moment-timezone-with-data-2010-2020.min.js"></script>
<?php 
	$getUserList = getAllUsersIncAdmin();
	$drpUser = array();
	if(count($getUserList)>0){
		foreach($getUserList as $user){
			$drpUser[] = array('id'=>$user->id,'name'=>addslashes($user->name));
		}
	}
?>
<script type="text/javascript">snapGlobalFileID="";_userList='<?php echo json_encode($drpUser)?>';jQuery(document).ready(function(){$("#ticket__body_button").off("click").on("click",function(h){$(this).toggleClass("is-open");$("#ticket__body").toggleClass("is-open");return false});function signalA(){if(jQuery.active>0){jQuery("#signalA").removeClass('green').addClass('red')} else{jQuery("#signalA").addClass('green').removeClass('red')}}setInterval(signalA,1000);
	/*$(".modal").draggable({handle:".modal-header"});*/
	/*$(".modal").resizable();*/$("#open_lucidchart").on("shown.bs.modal",function(h){c()});$(window).on("resize",function(){var h=$("#open_lucidchart");if(h.length&&h.is(":visible")){c()}});function c(){var i=$("#open_lucidchart").find(".modal-body iframe"),h=$(window).height()-231;if(i.length){i.height(h)}}$("#open_opportunity").on("shown.bs.modal",function(h){d()});$(window).on("resize",function(){var h=$("#open_opportunity");if(h.length&&h.is(":visible")){d()}});function d(){var i=$("#open_opportunity").find(".modal-body iframe"),h=$(window).height()-231;if(i.length){i.height(h)}}$("#btnComments").on("shown.bs.modal",function(h){b()});$(window).on("resize",function(){var h=$("#btnComments");if(h.length&&h.is(":visible")){b()}});function b(){var j=$("#btnComments").find(".modal-body"),i=$("#patentees_data"),h=$(window).height()-226;if(j.length){j.height(h);j.css("overflow-y","auto")}if(i.length){i.height(h)}}$("#open_calendar").on("shown.bs.modal",function(h){e()});$(window).on("resize",function(){var h=$("#open_calendar");if(h.length&&h.is(":visible")){e()}});function e(){var i=$("#open_calendar").find(".modal-body iframe"),h=$(window).height()-113;if(i.length){i.height(h)}}$("#replyTaskModal").on("shown.bs.modal",function(h){g();jQuery("#replyTaskModal").css('margin-right','0px');});$(window).on("resize",function(){var h=$("#replyTaskModal");if(h.length&&h.is(":visible")){g()}});function g(){var i=$("#replyTaskModal").find(".modal-body"),h=$(window).height()-83;if(i.length){i.css("overflow","auto").height(h)}} $("#callInOutModal").on("shown.bs.modal",function(h){jQuery("#callInOutModal").css('margin-right','0px');});autocompleteLeadFormSearchFields();});  
	function nl2br(c,b){var a=(b||typeof b==="undefined")?"<br />":"<br>";return(c+"").replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g,"$1"+a+"$2")}
	var availableTags=[];
	function aSplit(c){return c.split(/,\s*/)}
	function bPop(c){return aSplit(c).pop()}	
	$(function(){		
		callAutoComplete();
	});
	var findDataRemove=[], findDataCCRemove=[], findDataBCCRemove=[], findDataRemoveEve=[], findDataSearchTo=[], findDataSearchFrom=[];
	function callAutoComplete() {
		$(".emailSubject,.emailMessage").focus(function(){
			if(findDataCCRemove.length==0){$(".emailCC").val("")}
			if(findDataRemove.length==0){$(".emailTo").val("")}
			if(findDataBCCRemove.length==0){$(".emailBCC").val("")}
		});
		$(".search_from").blur(function(){
			if(findDataSearchFrom.length==0){$(".search_from").val("")}
		})
		.bind("keydown",function(c){
			if(c.keyCode===$.ui.keyCode.TAB&&$(this).autocomplete("instance").menu.active){
				c.preventDefault();
			}
		})
		.autocomplete({
			open: function(){setTimeout(function () {$('.ui-autocomplete').css('z-index', 99999999999999);}, 0);},
			source:function(d,c){findDataSearchFrom=$.ui.autocomplete.filter(availableTags,bPop(d.term));c($.ui.autocomplete.filter(availableTags,bPop(d.term)))},
			search:function(){var c=bPop(this.value);if(c.length<2){return false}},
			focus:function(){return false},
			select:function(d,e){var c=aSplit(this.value);c.pop();c.push(e.item.value);c.push("");this.value=c.join(", ");return false}
		});	
		$(".search_to").blur(function(){
			if(findDataSearchTo.length==0){$(".search_to").val("")}
		})
		.bind("keydown",function(c){
			if(c.keyCode===$.ui.keyCode.TAB&&$(this).autocomplete("instance").menu.active){
				c.preventDefault();
			}
		})
		.autocomplete({
			open: function(){setTimeout(function () {$('.ui-autocomplete').css('z-index', 99999999999999);}, 0);},
			source:function(d,c){findDataSearchTo=$.ui.autocomplete.filter(availableTags,bPop(d.term));c($.ui.autocomplete.filter(availableTags,bPop(d.term)))},
			search:function(){var c=bPop(this.value);if(c.length<2){return false}},
			focus:function(){return false},
			select:function(d,e){var c=aSplit(this.value);c.pop();c.push(e.item.value);c.push("");this.value=c.join(", ");return false}
		});
		$("#attendeeEmail").blur(function(){
			if(findDataRemoveEve.length==0){$("#attendeeEmail").val("")}
		})
		.bind("keydown",function(c){
			if(c.keyCode===$.ui.keyCode.TAB&&$(this).autocomplete("instance").menu.active){c.preventDefault()}
		})
		.autocomplete({
			open: function(){setTimeout(function () {$('.ui-autocomplete').css('z-index', 99999999999999);}, 0);},
			source:function(d,c){findDataRemoveEve=$.ui.autocomplete.filter(availableTags,bPop(d.term));c($.ui.autocomplete.filter(availableTags,bPop(d.term)))},
			search:function(){var c=bPop(this.value);if(c.length<2){return false}},
			focus:function(){return false},
			select:function(d,e){var c=aSplit(this.value);c.pop();c.push(e.item.value);c.push("");this.value=c.join(", ");return false}
		});
		$(".emailTo").blur(function(){
			if(findDataRemove.length==0){$(".emailTo").val("")}
		})
		.bind("keydown",function(c){
			if(c.keyCode===$.ui.keyCode.TAB&&$(this).autocomplete("instance").menu.active){c.preventDefault()}
		})
		.autocomplete({
			open: function(){setTimeout(function () {$('.ui-autocomplete').css('z-index', 99999999999999);}, 0);},
			source:function(d,c){findDataRemove=$.ui.autocomplete.filter(availableTags,bPop(d.term));c($.ui.autocomplete.filter(availableTags,bPop(d.term)))},
			search:function(){var c=bPop(this.value);if(c.length<2){return false}},
			focus:function(){return false},
			select:function(d,e){var c=aSplit(this.value);c.pop();c.push(e.item.value);c.push("");this.value=c.join(", ");return false}
		});
		$(".emailCC").blur(function(){
			if(findDataCCRemove.length==0){$(".emailCC").val("")}
		})
		.bind("keydown",function(c){
			if(c.keyCode===$.ui.keyCode.TAB&&$(this).autocomplete("instance").menu.active){c.preventDefault()}
		})
		.autocomplete({
			open: function(){setTimeout(function () {$('.ui-autocomplete').css('z-index', 99999999999999);}, 0);},
			source:function(d,c){findDataCCRemove=$.ui.autocomplete.filter(availableTags,bPop(d.term));c($.ui.autocomplete.filter(availableTags,bPop(d.term)))},
			search:function(){var c=bPop(this.value);if(c.length<2){return false}},
			focus:function(){return false},
			select:function(d,e){var c=aSplit(this.value);c.pop();c.push(e.item.value);c.push("");this.value=c.join(", ");return false}
		});
		$(".emailBCC").blur(function(){
			if(findDataBCCRemove.length==0){$(".emailBCC").val("")}
		})
		.bind("keydown",function(c){
			if(c.keyCode===$.ui.keyCode.TAB&&$(this).autocomplete("instance").menu.active){c.preventDefault()}
		})
		.autocomplete({
			open: function(){setTimeout(function () {$('.ui-autocomplete').css('z-index', 99999999999999);}, 0);},
			source:function(d,c){findDataBCCRemove=$.ui.autocomplete.filter(availableTags,bPop(d.term));c($.ui.autocomplete.filter(availableTags,bPop(d.term)))},
			search:function(){var c=bPop(this.value);if(c.length<2){return false}},
			focus:function(){return false},
			select:function(d,e){var c=aSplit(this.value);c.pop();c.push(e.item.value);c.push("");this.value=c.join(", ");return false}
		})
	}
jQuery(document).ready(function(){initEditor();});function checkModalFrontOrHide(c,f){var b=jQuery("body").data("modalzindex"),e=+c.css("z-index");var a=0;$(".modal:visible, .sb-slidebar:visible").each(function(g,h){if(+$(h).css("z-index")>a){a=+$(h).css("z-index")}});if(a===e){c.modal("hide");if(typeof f==="function"){f()}}else{b+=1;jQuery("body").data("modalzindex",b);c.css("z-index",b)}}function openTaskModal(p,c){if(!jQuery("#createTaskModal1").is(":visible")){if(leadGlobal==0){alert('Please select lead first.');} else {_activity = jQuery("#activityMainType").val();jQuery("#formTask").get(0).reset();jQuery('#taskLeadId').val(leadGlobal);jQuery('#taskEmailId,#taskRecord,#taskParentId,#taskId').val(0);jQuery('#taskType').val(''); jQuery('#openTaskModal').addClass('menu-active');let pID = 0, cID = 0;if(typeof p !="undefined"){ pID = p }if(typeof c !="undefined"){ cID = c }jQuery('#taskPID').val(pID);jQuery('#taskCID').val(cID);jQuery("#taskActivityType").val(_activity);
emailID = 0;
if(_activity>0){
	if(_activity=="2"){
		if(jQuery("#aquisitionTable").find('tbody.main_active').find('tr.master').find('td.active').length>0){
			if(jQuery("#displayEmail").find('iframe').length>0){
				_src = jQuery("#displayEmail").find('iframe').attr("src");
				email = _src.split("/").pop();
				if(email!="" && parseInt(email)>0){
					emailID = email;
				}
			}			
		}
	} else if(_activity=="1"){
		if(jQuery("#activityTable").find('tbody.main_active').find('tr.master').find('td.active').length>0){
			if(jQuery("#displayEmail").find('iframe').length>0){
				_src = jQuery("#displayEmail").find('iframe').attr("src");
				email = _src.split("/").pop();
				if(email!="" && parseInt(email)>0){
					emailID = email;
				}
			}	else {
				email = jQuery("#activityTable").find('tbody.main_active').find('tr.master').find('td.active').find('a').attr('data-tr');
				if(email!="" && email!=undefined && parseInt(email)>0){
					emailID = email;
				}
			}		
		}
	} else if(_activity=="3"){
		if(jQuery("#preSaleActivityTable").find('tbody.main_active').find('tr.master').find('td.active').length>0){
			if(jQuery("#displayEmail").find('iframe').length>0){
				_src = jQuery("#displayEmail").find('iframe').attr("src");
				email = _src.split("/").pop();
				if(email!="" && parseInt(email)>0){
					emailID = email;
				}
			}	else {
				email = jQuery("#preSaleActivityTable").find('tbody.main_active').find('tr.master').find('td.active').find('a').attr('data-tr');
				if(email!="" && email!=undefined && parseInt(email)>0){
					emailID = email;
				}
			}		
		}
	}
} 
jQuery("#createTaskModal1").on('hidden.bs.modal', function(e) { 
  jQuery('#openTaskModal').removeClass('menu-active');
});
	jQuery("#taskEmailId").val(emailID);jQuery("#createTaskModal1").modal("show");jQuery("#createTaskModalLabel").html("Create Task for - "+leadNameGlobal) }}else{checkModalFrontOrHide(jQuery("#createTaskModal1"))}closeSlidebar(jQuery('#callInOutModal'));}
	function openCalendar(){if(!jQuery("#open_calendar").is(":visible")){_height=jQuery(window).height()-80;jQuery("#open_calendar").find("iframe").attr("src","https://www.google.com/calendar/embed?title=SynPat%40SynPat%20-%20Team%20Calendar&amp;mode=WEEK&amp;height=800&amp;wkst=1&amp;bgcolor=%23ffffff&amp;src=admin%40synpat.com&amp;color=%236B3304&amp;src=kerry%40synpat.com&amp;color=%238D6F47&amp;src=ron%40synpat.com&amp;color=%235A6986&amp;src=sanjay%40synpat.com&amp;color=%23865A5A&amp;src=synpat%40synpat.com&amp;color=%23060D5E&amp;src=uzi%40synpat.com&amp;color=%2328754E&amp;src=webmaster%40synpat.com&amp;color=%238D6F47&amp;ctz=America%2FLos_Angeles").css("height",_height);jQuery("#open_calendar").modal("show")}else{checkModalFrontOrHide(jQuery("#open_calendar"))}}function openConmmentModal(){if(leadGlobal==0){alert("Please select a lead first.")}else{callingOrder(0);$('#openConmmentModal').addClass('menu-active');if(!$("#btnComments").is(":visible")){jQuery("#msg_div").html("");jQuery("#btnComments").modal("show");}else{checkModalFrontOrHide(jQuery("#btnComments"))}}}if(!String.linkify){String.prototype.linkify=function(){var b=/\b(?:https?|ftp):\/\/[a-z0-9-+&@#\/%?=~_|!:,.;]*[a-z0-9-+&@#\/%=~_|]/gim;var c=/(^|[^\/])(www\.[\S]+(\b|$))/gim;var a=/[\w.]+@[a-zA-Z_-]+?(?:\.[a-zA-Z]{2,6})+/gim;return this.replace(b,'<a href="$&" target="_BLANK">$&</a>').replace(c,'$1<a href="http://$2" target="_BLANK">$2</a>').replace(a,'<a href="mailto:$&" target="_BLANK">$&</a>')}}
function openLicenseesModal(t){
	var sliderID = "open_licensees";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {		
		appendSlider(sliderID,'Licensees','Licensees');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="manageLicenseIframe" src="'+
__baseUrl+'dashboard/licensees/'+leadGlobal+'/'+t+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
}
function analysisType(){	
	var $slider = jQuery("#btnComments");
	$slider.find("#commentComment1,#commentComment2,#commentComment3").typing({
		delay:1000,
		start:function(){
			console.log('type in analysis');
		},
		stop:function(){
			console.log('Stop analysis..');
			saveComment();
		}
	});
	$slider.find("#attractiveness").off("change").on('change',function(){
		saveComment();
	});
}
function closeSlideBarLeftAnalysis(){
	jQuery('#btnComments').find('#topbar_commentForm').get(0).reset();
	jQuery("#btnComments").find("#comment_upper_list").html("<table class='table'><thead><tr><th>Are there >10 potential licensees? Who?</th><th>Easy to show infringement? Are there EoU? How clear?</th><th>Seller's concerns + Your general observations</th><th>Attractiveness</th><th>Created</th><th>Updated</th><th>By</th></tr></thead><tbody><tr><td colspan='7'>No record found!</td></tr></tbody></table>")
	closeSlidebar(jQuery("#btnComments"));
	jQuery('#openConmmentModal').removeClass('menu-active');
	jQuery(".modal-backdrop-drive:eq(0)").remove()
}
function openConmmentModal(){
	if(leadGlobal==0){
		alert("Please select a lead first.");
	} else {
		var sliderID = "btnComments";
		if(jQuery("#"+sliderID).hasClass('is-open')) {
			jQuery('#openConmmentModal').removeClass('menu-active');
			checkModalFrontOrHide(jQuery("#"+sliderID), function() {
				closeSlideBar(jQuery("#"+sliderID))
			});
		} else {
			callingOrder(0);
			$('#openConmmentModal').addClass('menu-active');
			appendSlider(sliderID,'Team Notes','TeamNotes');
			if(jQuery("#"+sliderID).length > 0) {
				openSlidebar(jQuery("#"+sliderID));
				slidebarOpenCallback(jQuery("#"+sliderID));
				changeIframeHeight(jQuery("#"+sliderID));
				jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeTeamNotes)');
				jQuery("#"+sliderID).find('.slider_container').html(jQuery("#team_notes_panel").html());
				analysisType();
			}
		}
	}
}
function closeTeamNotes() {
	jQuery('#openConmmentModal').removeClass('menu-active');
}
jQuery(window).on('resize', function() {
	open_licenseResize();
});
function autocompleteLeadFormSearchFields(){
	jQuery( ".searchSerialNumber" ).autocomplete({
		source: function( request, response ) {
        jQuery.ajax({
			url: __baseUrl+"dashboard/search_serial_number",
			dataType: "json",
			data: {
			q: request.term
			},
			success: function( data ) {
				response( data );
			}
        });
		},
		minLength: 1,
		select: function( event, ui ) {
			/*log( ui.item ?
			  "Selected: " + ui.item.label :
			  "Nothing selected, input was " + this.value);*/
			if(ui.item) {
				this.value = ui.item.value
			} else {
				this.value = '';
			}			
		},
		open: function() {
			jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
		},
		close: function() {
			jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
		}
    });
	jQuery( ".searchlead_name" ).autocomplete({
		source: function( request, response ) {
        jQuery.ajax({
			url: __baseUrl+"dashboard/search_lead_name",
			dataType: "json",
			data: {
			q: request.term
			},
			success: function( data ) {
				response( data );
			}
        });
		},
		minLength: 3,
		select: function( event, ui ) {
			/*log( ui.item ?
			  "Selected: " + ui.item.label :
			  "Nothing selected, input was " + this.value);*/
			if(ui.item) {
				this.value = ui.item.label
			} else {
				this.value = '';
			}
		},
		open: function() {
			jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
		},
		close: function() {
			jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
		}
    });
	jQuery( ".searchOwner, .searchBroker, .searchBrokerPerson" ).autocomplete({source: availableTags});
}
function open_licenseResize(){
}
function closeSlideBarEou(){jQuery("#eou_frame").html('');jQuery("#open_eou_folder").removeClass("is-open");$('#openEOUModal').removeClass('menu-active');closeSlidebar(jQuery("#open_eou_folder"));$(".modal-backdrop-drive:eq(0)").remove()}
function closeSlideBarLicensees(){}
function openLucidChartModal(){if(leadGlobal==0){alert("First you have to select a portfolio.")}else{if(!jQuery("#open_lucidchart").is(":visible")){jQuery("#open_lucidchart").modal("show");if(jQuery("#open_lucidchart").find(".showLucidData").length==0){jQuery(".lucidChartBody").html("<iframe height='600px' width='100%' style='overflow-x: hidden; overflow-y: auto' src='<?php echo $Layout->baseUrl;?>dashboard/charts/"+leadGlobal+"'></iframe>")}}else{checkModalFrontOrHide(jQuery("#open_lucidchart"))}}}

	function openDocketModal() {
		if(leadGlobal==0) {
			alert("Please select a Portfolio first.")
		}
		else {
			// window.open(__baseUrl+'opportunity/docket/'+leadGlobal,'Docket','height=' + screen.height + ',width=' + screen.width + ',resizable=yes,scrollbars=yes,toolbar=yes,menubar=yes,location=yes');
			$('#openDocketModal').addClass('menu-active');
			openDocketSlidebar(leadGlobal);
		}
	}

	function openEOUModal(){
		var sliderID = "open_eou_folder";
		if(jQuery("#"+sliderID).hasClass('is-open')) {
			jQuery('#openEOUModal').removeClass('menu-active');
			checkModalFrontOrHide(jQuery("#"+sliderID), function() {
				closeSlideBar(jQuery("#"+sliderID))
			});
		} else {
			jQuery('#openEOUModal').addClass('menu-active')
			appendSlider(sliderID,'Outsource','Outsource');
			if(jQuery("#"+sliderID).length > 0) {
				jQuery("#"+sliderID).find('.slider_container').html('<iframe id="opensource_slidebar_iframe" src="' + __baseUrl + 'opportunity/eou_in_folder/'+leadGlobal+'" width="100%" height="100px" scrolling="yes"></iframe>');
				openSlidebar(jQuery("#"+sliderID));
				slidebarOpenCallback(jQuery("#"+sliderID));
				jQuery("#"+sliderID).addClass("is-open");
				changeIframeHeight(jQuery("#"+sliderID));
				jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeOpenSource)');
			}
			/*
				if(jQuery("#leadOpenLegalOpenStatus").length>0){
					leftWidth = jQuery("#"+_mainBtnParentElement).find('.formWithCheckBox').width();
					w = w - leftWidth - 10;
				}
			*/
		}
	}
	
	function closeOpenSource() {
		jQuery('#openEOUModal').removeClass('menu-active');
	}
	_emailAttachFiles="";
	function saveComment(){var $slider = jQuery("#btnComments");$slider.find("#loading_lead_comment").show();jQuery.ajax({url:"<?php echo site_url(); ?>dashboard/saveComment",type:"POST",data:{lead_id:leadGlobal,type:$slider.find("#leadType").val(),comment1:$slider.find("#commentComment1").val(),comment2:$slider.find("#commentComment2").val(),comment3:$slider.find("#commentComment3").val(),attractiveness:$slider.find("#attractiveness").val(),id:$slider.find("#commentId").val()},success:function(a){$slider.find("#loading_lead_comment").hide();var b=jQuery.parseJSON(a);if(b.error==0){if($slider.find("#commentId").val()>0){$slider.find("#msg_div").html("<p style='color:#ff0000;font-weight:bold;margin-left:14px;margin-top:10px;'>Successfully Comments Updated</p>")}else{$slider.find("#msg_div").html("<p style='color:#ff0000;font-weight:bold;margin-left:14px;margin-top:10px;'>Successfully Comments Added</p>")}}else{alert("Try after sometime")}}})}function openContactForm(){if(!jQuery("#contactForm").is(":visible")){jQuery.ajax({type:"POST",url:"<?php echo $this->config->base_url()?>dashboard/search_contact",cache:false,success:function(a){availableTags=jQuery.parseJSON(a)}});jQuery("#contactForm").find(".modal-body").html('<iframe id="contactFormIframe" src="<?php echo $Layout->baseUrl;?>opportunity/contact" width="100%" height="700px" scrolling="no"></iframe>');jQuery("#contactForm").modal("show");$("#contactForm").draggable({handle:".modal-header"});/*$("#contactForm .modal-content").resizable()*/}else{jQuery("#contactForm").modal("hide")}jQuery("#contactForm").on("hidden.bs.modal",function(){jQuery("#contactFormIframe").remove()})}function openMarketButton(a){if(leadGlobal>0){if(!jQuery("#marketContactForm").is(":visible")){jQuery("#marketContactFormIframe").attr("src","<?php echo $Layout->baseUrl;?>opportunity/market_form/"+leadGlobal+"/"+a).css("display","block");jQuery("#marketContactForm").modal("show")}}else{alert("Please select lead first.")}}function submitContactForm(){_data="";_data=jQuery("#contactFormSubmit").serialize();jQuery.ajax({type:"POST",url:"<?php echo $Layout->baseUrl; ?>/opportunity/add_topbar_contact",data:_data,success:function(a){alert(a);jQuery("#contactForm").modal("hide")}})}function openMessageBox(a){jQuery("#replyParentId").val(a);approvedFile(a)}var chDa=0;jQuery(document).ready(function(){jQuery("#sellerContactForm").on('hidden.bs.modal', function(e) { 
  jQuery('#contactSellerFormIframe').attr('src',"about:blank");
});$(function(){$(".input-switch").bootstrapSwitch();$(".input-switch").on("switchChange.bootstrapSwitch",function(b,a){if(jQuery("input[name='checkbox-example-2221']").is(":checked")){chDa=1}else{chDa=0}runLogin()})})});function runLogin(){jQuery.ajax({url:"<?php echo $Layout->baseUrl?>dashboard/run_login",type:"POST",data:{d:chDa,l:leadGlobal},cache:false,success:function(a){}})}function logout(){if(jQuery("input[name='checkbox-example-2221']").is(":checked")){window.location="<?php echo $Layout->baseUrl?>login/logout/<?php echo $this->session->userdata['id']?>/1"}else{window.location="<?php echo $Layout->baseUrl?>login/logout/<?php echo $this->session->userdata['id']?>/0"}}function checkCompanyName(a){if(a.val()!=""){jQuery("#inviteeCompanyId").find("option").removeAttr("selected");jQuery("#inviteeCompanyId").find("option").removeAttr("SELECTED");jQuery("#companySector").find("option").removeAttr("selected");jQuery("#companySector").find("option").removeAttr("SELECTED")}}function findLeadHrs(a){if(a.val()!=""){jQuery.ajax({type:"POST",url:"<?php echo $Layout->baseUrl?>users/leadLogTime",data:{l:a.val()},success:function(b){jQuery("#timeLineWrapper").html(b)}});}}jQuery(document).ready(function(){jQuery("#dashboard_charts").on("hidden.bs.modal",function(){if(updateLogs.length>0){for(d=0;d<updateLogs.length;d++){updateLogData(updateLogs[d])}}})});$(function(){$(".bootstrap-datepicker").bsdatepicker({format:"yyyy-mm-dd"})});function submitTask(){if(leadGlobal==0||leadGlobal==""){alert("No entity found!")}else{if(jQuery("#taskLeadId").val()==""||jQuery("#taskLeadId").val()==0){jQuery("#taskLeadId").val(leadGlobal)}if(jQuery("#taskType").val()=="" && typeof __mainEntityType!="undefined"){jQuery("#taskType").val(__mainEntityType)}/*jQuery("#formTask").eq(0).submit()*/jQuery.ajax({type:'POST',url:jQuery("#formTask").attr('action'),data:jQuery("#formTask").serializeArray(),cache:false,success:function(d){window.parent.sendTask = 0;jQuery('#createTaskModal1').modal('hide');callnotification();_calBack = jQuery("#createTaskModal1").data('file'); if(typeof _calBack!="undefined"){_bID = jQuery("#createTaskModal1").data('cr-r');if(typeof _calBack=="function"){_calBack(_bID);} else {x = eval(_calBack);	if(typeof x=="function"){x(_bID);}}} refreshAcquisitionAndSalesActivity();}})}}function replyTask(){if(parseInt(jQuery("#replyLeadId").val())>0){/*jQuery("#formReplyTask").eq(0).submit()*/jQuery.ajax({type:'POST',url:jQuery("#formReplyTask").attr('action'),data:jQuery("#formReplyTask").serializeArray(),cache:false,success:function(d){jQuery('#replyTaskModal').modal('hide');callnotification();refreshAcquisitionAndSalesActivity();if(jQuery("#tasksICreated").hasClass('is-open')){if(jQuery("#tasksICreated").find('iframe').length>0){jQuery("#tasksICreated").find('iframe').get(0).contentWindow.location.reload()}}else if(jQuery("#tasksCreatedForMe").hasClass('is-open')){if(jQuery("#tasksCreatedForMe").find('iframe').length>0){jQuery("#tasksCreatedForMe").find('iframe').get(0).contentWindow.location.reload()}}}})}else{alert("No entity found!")}}function openCompanyBrokerFirm(){openContactForFrom('9','company_form');}function refreshContacts(){jQuery.ajax({type:"POST",url:"<?php echo $this->config->base_url()?>dashboard/search_contact",cache:false,success:function(a){availableTags=jQuery.parseJSON(a);/*jQuery('#sb-site').prepend('<div class="col-lg-12 alert alert-info noticeInfoAlert mrg5T" style="position:absolute;z-index:9999">Contact list refreshed.</div>');setTimeout(function(){jQuery('.noticeInfoAlert').remove()},3000);*/}})}jQuery(document).ready(function(){jQuery(".multi-select").multiSelect("refresh");jQuery(".ms-container").append('<i class="glyph-icon icon-exchange"></i>')});_serialiseData="";_formClone="";jQuery(document).ready(function(){$("#myDashboardComposeEmails").on("submit",function(e){e.preventDefault();$(this).find(":submit").prop("disabled",true);_errorE=0;_errorEM = '';if(jQuery('#emailTo').val()==''){_errorE=1;_errorEM = 'Please enter email address.';}if(_errorE==0 && jQuery('#emailSubject').val()==''){/*_errorE=1;_errorEM = 'Please enter subject';*/} if(_errorE==0 && (isNaN(parseInt(jQuery('#messageLeadId').val()))|| parseInt(jQuery('#messageLeadId').val())==0)){_errorE=1;_errorEM = 'Please select lead first.';} if(_errorE==1){alert(_errorEM)} else if(_errorE==0){jQuery('#emailMessage').val(jQuery('#emailMessage').code());_op=0;if(jQuery('#imap_licenses').hasClass('active')){
		_op=1;
	} else if(jQuery('#imap_operation').hasClass('active')){
		_op=2;
	} else if(jQuery('#imap_expert').hasClass('active')){
		_op=3;
	}
	if(_op==0){
		_op = jQuery("#email_authorize").val();
	}
	if(jQuery("#eventT").val()==3){
				_p = 0;
				jQuery('#preSaleActivityTable').find("input[name='sales_person[]']:checked").each(function(){
					_p =jQuery(this).parent().parent().attr('data-c');				
				});
				jQuery("#eventCid").val(_p);
			}frmEmail =$("#myDashboardComposeEmails");_serialiseData = frmEmail.serialize();jQuery.ajax({type:'POST',async:true,url:frmEmail.attr('action')+'/'+_op,data:_serialiseData}).done(function(em){console.log("Send email.");
			sd = 0;
			fileType = 0;
			if(em!=""){
				try{
					_emL = JSON.parse(em);
					if(typeof _emL.email_id!="undefined" && _emL.email_id>0){
						sd = _emL.email_id;
						fileType = _emL.file_type;
					}
				}catch(e){}
			}
			jQuery("#legal_patents").val(0);jQuery("#legal_log").val(0);jQuery('input[name="another[legal_log]"]').val(0);jQuery("#anotherSys").val(0);if(sendTask==1&& sd!='' && parseInt(sd)>0){openTaskModal();jQuery('#createTaskModal1').find('#taskEmailId').val(sd);}jQuery("#myDashboardComposeEmails").find(":submit").removeAttr("disabled");jQuery("#myDashboardComposeEmails").find(":submit").prop("disabled",false);
			if(sd>0){
				if(fileType>0){
					/*_serialiseData*/
					console.log('Process of Sending DD password via email.');
					//_serialiseData = decodeURIComponent(_serialiseData)
					/*serializedString = _serialiseData.replace(/\+/g, '%20');*/
					var formFieldArray = _serialiseData.split("&");
					console.log(formFieldArray);
					jQuery.ajax({
						type:'POST',
						url:__baseUrl+"dashboard/find_dd_password",data:{l:leadGlobal,type:fileType},cache:false,dataType:'json'
					}).done(function(_dataPass){
						if(_dataPass!=""){
							try{
								console.log(_dataPass.password);
								if(typeof _dataPass.password!="undefined" && _dataPass.access_code!="undefined"){
									_stackData = [];
									$.each(formFieldArray, function(i, pair){
										var nameValue = pair.split("=");
										if(nameValue[0]=="email%5Bmessage%5D"){
											_newMessage = "Access Code: "+_dataPass.access_code+"%3Cbr%3EPassword: "+_dataPass.password+"%3Cbr%3E%3Cbr%3E%3Cbr%3E";
											_signature = jQuery("#original_signature").val();
											/*_newMessage = _newMessage+encodeURIComponent(_signature);*/
											_newMessage = _newMessage+encodeURIComponent("Best Regards,<br/>SynPat");
											nameValue[1] = _newMessage;
											console.log(nameValue);
											pair = nameValue.join("=");
											console.log(pair);
										} else if(nameValue[0]=="email%5Bdoc_url%5D"){
											nameValue[1]="";
											pair = nameValue.join("=");
										} else if(nameValue[0]=="event%5Bevent_user_type%5D"){
											nameValue[1]="2";
											pair = nameValue.join("=");
										} else if(nameValue[0]=="email%5Baccount_type%5D"){
											nameValue[1]="2";
											pair = nameValue.join("=");
										}
										_stackData.push(pair);
									});
									console.log(_stackData);
									_stackData = _stackData.join('&');
									//serializedString = _stackData.replace(/%20/g,'+');
									//_serialiseData = encodeURIComponent(serializedString);
									_serialiseData = "";
									console.log("Sending Password Email");
									jQuery.ajax({type:'POST',async:true,url:frmEmail.attr('action')+'/'+_op,data:_stackData}).done(function(d){
										console.log("Send email.");
										sd = 0;
										fileType = 0;
										if(em!=""){
											try{
												_emL = JSON.parse(em);
												if(typeof _emL.email_id!="undefined" && _emL.email_id>0){
													sd = _emL.email_id;
													fileType = _emL.file_type;
												}
											}catch(e){}
										}
										if(sd>0){
											console.log("Password Email Sent");
										}
									})
								}
							}catch(e){
								
							}
						}
					})
				}
			_emailAttachFiles = jQuery("#emailDocUrl").val();
			refreshAcquisitionAndSalesActivity();jQuery("#myDashboardComposeEmails").get(0).reset();jQuery("#emailMessage").code("<br/><br/><br/>"+jQuery("#original_signature").val());jQuery("#attach_droppable").html('');jQuery("#eventPid").val(0);jQuery("#eventCid").val(0);jQuery("#f_t").val('');jQuery("#emailReference").val('');jQuery("#emailMessageId").val('');jQuery("#emailThreadId").val('');jQuery("#emailDocUrl").val('');jQuery("#emailAccountType").val(2);closeSlideBarLeftMessage();jQuery('#discardEmail').empty();
				callback = jQuery("#displayEmail").data('file');
				console.log("DD"+callback);
				if(typeof callback!="undefined"){
					console.log("CALL BACK");
					_importEmailID = sd;
					console.log("EMAILID:"+_importEmailID);
					if(_importEmailID>0){
						x = jQuery("#displayEmail").data('cr-r');
						f = jQuery("#displayEmail").data('cr-id');
						if(x=='3' && f>0){
							updatePaymentNofication(f,_emailAttachFiles);
							_emailAttachFiles = "";
						}else if(x=='4' && f>0){
							confirmRequestPayment(f);
						}
						console.log('asdas'+typeof callback);
						if(typeof callback=="function"){
							console.log('I am in callback');
							if(x=="updateButton"){								
								callback(f);
							} else {
								callback();
							}
							/*x = eval(callback);
							if(typeof x=="function"){
								x();
							}*/
						} else {
							x = eval(callback);
							if(typeof x=="function"){
								console.log('Calling.....')
								if(x=="updateButton"){	
									x(f);
								} else {
									x();
								}
							}
						}
					}					
				}
				if(typeof jQuery("#open_prefined_message")!="undefined"){
					console.log("Predefined Message");
					var iframe= jQuery("#open_prefined_message").find('#predefineFormIframe').get(0);
					if(typeof iframe!="undefined" && (typeof iframe.contentWindow!="undefined" || typeof iframe.contentDocument!="undefined")){
						var iframewindow= iframe.contentWindow? iframe.contentWindow : iframe.contentDocument.defaultView;
						console.log("Path Name",iframewindow.document.location.pathname);
						let patheName = iframewindow.document.location.pathname;
						if(patheName.indexOf("email_campaign") >= 0 || patheName.indexOf("resume_campaign") >= 0){
							console.log("Path found");
							if(typeof iframewindow.campaignSendEmail =="function"){
								console.log("campaignSendEmail fn found.");
								iframewindow.campaignSendEmail(sd);
							}
						}
					}					
				}
			} else {alert("Email not send.");}
			});}})});function refreshCompanyList(){jQuery.ajax({type:'POST',url:__baseUrl+'users/company_list',cache:false,success:function(d){if(d!=""){_d = jQuery.parseJSON(d);if(_d.length>0){_option='';for(i=0;i<_d.length;i++){_option+='<option data-b="'+_d[i].sectorID+'" data-bn="'+_d[i].sectorName+'" value="'+_d[i].id+'">'+_d[i].company_name+'</option>';}if(_option!=""){jQuery("#inviteeCompanyId").html(_option);}}}}});}function companyPopResize(){jQuery('#addCCompanyForm').find('.modal-body').css({height:jQuery(window).height()-200,overflowY:'scroll'})}
	function runTimeZone(){
		/*America*/
		jQuery("#pst").html(moment(new Date()).tz('America/Los_Angeles').format('H:m'));
		jQuery("#est").html(moment(new Date()).tz('America/New_York').format('H:m'));
		jQuery("#cst").html(moment(new Date()).tz('America/Chicago').format('H:m'));
		jQuery("#mst").html(moment(new Date()).tz('America/Denver').format('H:m'));
		/*Asia*/
		jQuery("#china").html(moment(new Date()).tz('Asia/Shanghai').format('H:m'));
		jQuery("#japan").html(moment(new Date()).tz('Asia/Tokyo').format('H:m'));
		jQuery("#korea").html(moment(new Date()).tz('Asia/Seoul').format('H:m'));
		jQuery("#taiwan").html(moment(new Date()).tz('Asia/Taipei').format('H:m'));
		/*Europe*/
		jQuery("#uk").html(moment(new Date()).tz('Europe/London').format('H:m'));
		jQuery("#germany").html(moment(new Date()).tz('Europe/Berlin').format('H:m'));
		jQuery("#finland").html(moment(new Date()).tz('Europe/Helsinki').format('H:m'));
		jQuery("#sweden").html(moment(new Date()).tz('Asia/Taipei').format('H:m'));
		/*Other*/
		jQuery("#italy").html(moment(new Date()).tz('Europe/Rome').format('H:m'));
		jQuery("#israel").html(moment(new Date()).tz('Asia/Jerusalem').format('H:m'));
		jQuery("#ireland").html(moment(new Date()).tz('Europe/Dublin').format('H:m'));
		jQuery("#france").html(moment(new Date()).tz('Europe/Paris').format('H:m'));
		setInterval(function(){
		/*America*/
		jQuery("#pst").html(moment(new Date()).tz('America/Los_Angeles').format('H:m'));
		jQuery("#est").html(moment(new Date()).tz('America/New_York').format('H:m'));
		jQuery("#cst").html(moment(new Date()).tz('America/Chicago').format('H:m'));
		jQuery("#mst").html(moment(new Date()).tz('America/Denver').format('H:m'));
		/*Asia*/
		jQuery("#china").html(moment(new Date()).tz('Asia/Shanghai').format('H:m'));
		jQuery("#japan").html(moment(new Date()).tz('Asia/Tokyo').format('H:m'));
		jQuery("#korea").html(moment(new Date()).tz('Asia/Seoul').format('H:m'));
		jQuery("#taiwan").html(moment(new Date()).tz('Asia/Taipei').format('H:m'));
		/*Europe*/
		jQuery("#uk").html(moment(new Date()).tz('Europe/London').format('H:m'));
		jQuery("#germany").html(moment(new Date()).tz('Europe/Berlin').format('H:m'));
		jQuery("#finland").html(moment(new Date()).tz('Europe/Helsinki').format('H:m'));
		jQuery("#sweden").html(moment(new Date()).tz('Asia/Taipei').format('H:m'));
		/*Other*/
		jQuery("#italy").html(moment(new Date()).tz('Europe/Rome').format('H:m'));
		jQuery("#israel").html(moment(new Date()).tz('Asia/Jerusalem').format('H:m'));
		jQuery("#ireland").html(moment(new Date()).tz('Europe/Dublin').format('H:m'));
		jQuery("#france").html(moment(new Date()).tz('Europe/Paris').format('H:m'));
	},60000);
	}
	jQuery(document).ready(function(){
		/*runTimeZone();*/
	})
	 jQuery(document).ready(function() {
        $('.header-nav > li').hover(function(){
            $(this).addClass('sfHover');
        },
        function(){
            $(this).removeClass('sfHover');
        });
		
    });
	function openContactForFrom(b,a){
		var h = jQuery(window).height();
		h = h-100;
		if(leadGlobal>0 || b==9 || b == 27){
			var sliderID = "sellerContactForm";
			if(!jQuery("#"+sliderID).hasClass('is-open')) {
				appendSlider(sliderID,'Seller/Broker','SellerBroker');
				openSlidebar(jQuery("#"+sliderID));
				slidebarOpenCallback(jQuery("#"+sliderID));
				jQuery("#"+sliderID).addClass("is-open");
			}		
			if(jQuery("#"+sliderID).find("#contactSellerFormIframe").length == 0){
				jQuery("#"+sliderID).find('.slider_container').html('<iframe id="contactSellerFormIframe" scrolling="no" src="about:blank" width="100%" height="650px" style="display:none"></iframe>');
			}
			if(b==1){
				jQuery("#contactSellerFormIframe").attr("src","<?php echo $Layout->baseUrl;?>opportunity/company_contact_form/"+leadGlobal+"/"+b+"/"+a).css({"display":"block",height:h+"px"});jQuery("#sellerContactForm").css({width:'80%'});
			} else {
				jQuery("#contactSellerFormIframe").attr("src","<?php echo $Layout->baseUrl;?>opportunity/contact_form/"+leadGlobal+"/"+b+"/"+a).css({"display":"block",height:h+"px"});
				jQuery("#sellerContactForm").css({width:'50%'});
			}
		} else {
			alert("Please select lead first.");
		}
	}
</script> 
 <style>.modal{right:0!important;left:none}.modal.ui-resizable{margin:0}.modal-dialog{margin-right:0;margin-left:0}.modal-content.ui-resizable{overflow:auto}.ui-draggable-handle{cursor:move}color:#79b9c7;text-decoration:underline;.ui-resizable-handle.ui-icon{background:url(<?php echo $Layout->aws_server_cdn;?>images/resize.png) no-repeat;z-index:9999}.ui-resizable-handle.ui-resizable-e{right:0}.ui-resizable-handle.ui-resizable-s{bottom:0}#addContactForm{/*z-index:10000!important*/}.gmail-modal{/*position:fixed;*/left:0;width:100% !important;z-index:1050}.gmail-modal .modal-body{overflow:auto}.gmail-modal .attachment-list-item{float:none;padding:4px 27px;position:relative}.gmail-modal .attachment-list-item img{left:5px;margin:0;position:absolute;top:5px}.gmail-modal .attachment-list-item>a{display:block;float:none;padding:0}.gmail-modal .attachment-list-item span{position:absolute;right:1px;top:0}.ui-autocomplete{z-index:9999}.tl-content,.todo-content,.todo-box{font-weight:normal!important}.comment_content{padding:6px 25px 7px 10px!important}#ticket__body{display:block!important;max-height:56px;min-height:20px;overflow:visible}#ticket__body.is-open{max-height:10000px}#ticket__body p{margin:0}#ticket__body_button{cursor:pointer!important;position:absolute;right:0;width:19px;height:100%;border-left:1px solid #e6e6e6;background:#f2f2f2;background:-moz-linear-gradient(top,#f2f2f2 0,#e6e6e6 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#f2f2f2),color-stop(100%,#e6e6e6));background:-webkit-linear-gradient(top,#f2f2f2 0,#e6e6e6 100%);background:-o-linear-gradient(top,#f2f2f2 0,#e6e6e6 100%);background:-ms-linear-gradient(top,#f2f2f2 0,#e6e6e6 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f2f2f2',endColorstr='#e6e6e6',GradientType=0);background:linear-gradient(top,#f2f2f2 0,#e6e6e6 100%);font-size:20px;font-weight:700;text-decoration:none;text-align:center}#ticket__body_button span{background:url(<?php echo $Layout->aws_server_cdn;?>images/plus_11x11_bw.gif) no-repeat left top;height:11px;margin:-5px 0 0 -5px;left:50%;position:absolute;top:50%;width:11px}#ticket__body_button.is-open span{background:url(<?php echo $Layout->aws_server_cdn;?>images/minus_11x3_bw.gif) no-repeat left top;height:3px;margin:-2px 0 0 -5px}.message-inbox-detail{max-height:16px;min-height:16px;overflow:visible}.message-inbox-detail.is-open{max-height:10000px}.message-inbox-toggler{cursor:pointer!important;position:absolute;right:0;width:19px;height:100%;border-left:1px solid #e6e6e6;background:#f2f2f2;background:-moz-linear-gradient(top,#f2f2f2 0,#e6e6e6 100%);background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#f2f2f2),color-stop(100%,#e6e6e6));background:-webkit-linear-gradient(top,#f2f2f2 0,#e6e6e6 100%);background:-o-linear-gradient(top,#f2f2f2 0,#e6e6e6 100%);background:-ms-linear-gradient(top,#f2f2f2 0,#e6e6e6 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f2f2f2',endColorstr='#e6e6e6',GradientType=0);background:linear-gradient(top,#f2f2f2 0,#e6e6e6 100%);font-size:20px;font-weight:700;text-decoration:none;text-align:center}.message-inbox-toggler span{background:url(<?php echo $Layout->aws_server_cdn;?>images/plus_11x11_bw.gif) no-repeat left top;height:11px;margin:-5px 0 0 -5px;left:50%;position:absolute;top:50%;width:11px}.message-inbox-toggler.is-open span{background:url(<?php echo $Layout->aws_server_cdn;?>images/minus_11x3_bw.gif) no-repeat left top;height:3px;margin:-2px 0 0 -5px}#timelineDataTable_info{display:none!important}#list_seller_material{margin:0;padding:0}#list_seller_material li{list-style:none;padding:5px;}#list_seller_material a{color:#2196f3}.main-header-custom{position:relative;float:left;}
	.main-header-custom .header-nav {
			    float: right;
    list-style: none;
    margin: 0;
    padding: 0;
		}
		.main-header-custom .header-nav > li a{color:#fff;}
		.main-header-custom .header-nav > li > ul{
			position: absolute;
			list-style: none;
			margin: 20px 0 0;
			padding: 10px;
			min-width: 116px;
			top: 0px;
			left: 0;
			border-bottom-left-radius: 3px;
			border-bottom-right-radius: 3px;
			opacity: 0;
			background:#033A64;
			z-index:9999999999999999999999999999999999;
			visibility: hidden;
		}
		.main-header-custom .header-nav > li > ul> li {
			display: block;
    list-style: none;
    /*float: left;*/
    position: relative;padding-top:10px;
		}
	.main-header-custom .header-nav > li > ul li>a	{
			    padding: 10px 20px;
    font-size: 13px;
    float: none;
    display: block;
    border-radius: 2px;
		}
		.main-header-custom .header-nav > li.sfHover > ul {
    opacity: 1;
    visibility: visible;
    -webkit-transform: translateY(0);
    -moz-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
}
.menu-active1 {
    background: #7f8c8d !important;
    color: #fff !important;
}
#btnComments .cHalf input[name="r_link[]"]{ 
    cursor:pointer;
}

.logoSection{width:175px; float:left;}
.eventSection{ width:100%; float:left; position:relative;}
.menuSection { /*width:680px;*/}
.logOutSection{ width:100px;}
.ui-datepicker{z-index:99999999999999999!important;}
#side_bar_menu{display:none;margin:40px 0 0 0;padding:0px 10px;;width:250px;background:#033A64;position:absolute;z-index:9999;left:160px;text-align:left;list-style:none;}
#side_bar_menu li a {color:#fff;}
#side_bar_menu li a:hover{text-decoration:underline;}
#header-logo:hover #side_bar_menu{display:block;}
#page-header #close-sidebar{left:3px;}
</style>
<div id="page-header" class="bg-gradient-9" style='height:82px;'>
	
	<table width="100%" cellpadding="0" cellspacing="0">
        <tr>
        	<td style='width:255px;'><div class="logoSection">
		<div class='pull-left' id='header-main-ct' style='height:78px;width:100%'>
			<div id="mobile-navigation"> <a href="#" class="logo-content-small" title="Backyard" style='left:10px;'>S</a> </div>
			<div id="header-logo" class="logo-bg" style='width:175px'> 
			<a id="close-sidebar" href="#" title="Close sidebar"> <span class="logo-content-big" title="Dashboard">SynPat</span> <i class="glyph-icon icon-angle-right"></i> 
			</a> 
			<?php if((int)$this->session->userdata['type']==9):?>
			<ul id="side_bar_menu">
				<li><?php echo anchor('javascript://','<span>Forms Data</span>', array('title' => 'Forms Data','onclick'=>"getSectorsPage('general/forms_data')"));?></li>
				<li><?php echo anchor('javascript://','<span>Transaction</span>', array('title' => 'Transaction','onclick'=>"getSectorsPage('general/transaction')"));?></li>
				<li><?php echo anchor('javascript://','<span>Document Selections</span>', array('title' => 'Manage Opportunites Type','onclick'=>"getSectorsPage('general/manage_opportunity_type')"));?></li>
				<li><?php echo anchor('javascript://','<span>Manage Sectors / Categories</span>', array('title' => 'Manage Sectors / Categories','onclick'=>"getSectorsPage('general/manage_sectors')"));?></li>
				<li><?php echo anchor('javascript://','<span>Manage User</span>', array('title' => 'Manage User','onclick'=>"getSectorsPage('general/add_user')"));?></li>
				<li><?php echo anchor('javascript://','<span>Manage Sliders</span>', array('title' => 'Manage Sliders','onclick'=>"getSectorsPage('general/manage_sliders')"));?></li>
				<li><?php echo anchor('javascript://','<span>Manage Assignment Types</span>', array('title' => 'Manage Assignment Types','onclick'=>"getSectorsPage('general/manage_assignment_types')"));?></li>
				<li><?php echo anchor('javascript://','<span>Users Activities</span>', array('title' => 'All Activity List','onclick'=>"getSectorsPage('general/user_activities')"));?></li>
				<li><?php echo anchor('javascript://','<span>Users Timelines</span>', array('title' => 'All Activity List','onclick'=>"getSectorsPage('general/user_timeline')"));?></li>
				<li><?php echo anchor('javascript://','<span>Users Timelines(Table View)</span>', array('title' => 'All Activity List','onclick'=>"getSectorsPage('general/user_timeline_table')"));?></li>
				<li><?php echo anchor('javascript://','<span>Manage Portfolios</span>', array('title' => 'Manage Portfolios','onclick'=>"getSectorsPage('general/manage_leads')"));?></li>
				<li><?php echo anchor('javascript://','<span>Manage Stages</span>', array('title' => 'Manage Button Stages','onclick'=>"getSectorsPage('general/manage_stages')"));?></li>
				<li><?php echo anchor('javascript://','<span>Manage Task</span>', array('title' => 'Manage Task','onclick'=>"getSectorsPage('general/manage_task')"));?></li>
				<li><?php echo anchor('javascript://','<span>Manage Button List</span>', array('title' => 'Manage Button List','onclick'=>"getSectorsPage('general/button_boxes')"));?></li>
				<li><?php echo anchor('javascript://','<span>Manage Text Templates</span>', array('title' => 'Manage Text Templates','onclick'=>"getSectorsPage('general/email_templates')"));?></li>
			</ul>
			<?php endif; ?>
			</div>
	  </div> 
		<div style='position:absolute;top:0px;width:75px; '><div style='position:relative;padding-top:4px;left:180px;' data-p='0'><span id="event-date" style="color:#fff; width:100%; float:left;"></span>&nbsp;<a href='javascript://' id='prev-event'><i class='glyph-icon icon-arrow-left' onclick="findEvents('prev')" style='color:#fff'></i></a> | <a href='javascript://' onclick="findEvents('next')" style='color:#fff'><i class='glyph-icon icon-arrow-right'></i></a></div></div>
	</div></td>
            <td> 
            <!-- event-->
	  <div class="eventSection">  
	  
	  <ul class="header-nav today_user_event pull-left" style='width:100%;'>
	  </ul>
	  </div>
	  
      </td>
			
            <td>
            <!--menu -->
	 <div class="pull-right menuSection" >
  <div id="header-nav-right" style='margin-top:2px;'>
    <div class='main-header-custom'>
      <ul class="header-nav " style='min-width:120px;'>
		<?php 
			$higlightUtilities = "";
			if((int)$this->session->userdata['type']!=9){
				$modules = array(17,1,3,9,8,28);
				$checkTap = false;
				foreach($modules as $m){
					if(in_array($m,$this->session->userdata['modules_assign'])){
						$checkTap = true;
						break;
					}
				}
				if($checkTap === false) {
					$higlightUtilities = "style='color:#7f8c8d !important;'";
				}
			}
		?>
        <li style='padding:2px 0px;'> <a href="#" title="Homepages" <?php echo $higlightUtilities;?>> <i class="glyph-icon icon-sliders tooltip-button" title="Utilities" data-placement="bottom" style='margin-right:6px'></i> Utilities <i class="glyph-icon icon-angle-down"></i> </a>
          <ul style='top:18px;width:145px'>
            <li>
              <?php
	$openCreateLead = true;
	if((int)$this->session->userdata['type']!=9){
		if(!in_array(17,$this->session->userdata['modules_assign'])){
			$openCreateLead = false;
		}
	}
	if($openCreateLead===true):
	?>
              <a href='javascript://' style='color:#fff;' onclick='return openNewLeadDialogueBox()'><i class="glyph-icon icon-plus tooltip-button" title="Search" data-placement="bottom" style='margin-right:6px'></i> New portfolio</a>
              <?php else: ?>
              <a href='javascript://' style='color:#7f8c8d !important;'><i class="glyph-icon icon-plus tooltip-button" title="Search" data-placement="bottom" style='margin-right:6px'></i> New portfolio</a>
              <?php endif;?>
            </li>
			<li>
              <?php
				$openCreateLead = true;
				if((int)$this->session->userdata['type']!=9){
					$openCreateLead = false;
				}
				if($openCreateLead===true):
				?>
              <a href='javascript://' style='color:#fff;' onclick='deleteLeadRightClick()'><i class="glyph-icon icon-trash tooltip-button" title="Search" data-placement="bottom" style='margin-right:6px'></i> Delete portfolio</a>
              <?php else: ?>
              <a href='javascript://' style='color:#7f8c8d !important;'><i class="glyph-icon icon-trash tooltip-button" title="Search" data-placement="bottom" style='margin-right:6px'></i> Delete portfolio</a>
              <?php endif;?>
            </li>
			<li>
              <?php
				$openNotepad = true;
				if((int)$this->session->userdata['type']!=9){
					if(!in_array(37,$this->session->userdata['modules_assign'])){
						$openNotepad = false;
					}
				}
				if($openNotepad===true):
				?>
              <a href='javascript://' id="notepad_request" style='color:#fff;' onclick='openNotepad()'><i class="glyph-icon icon-file tooltip-button" title="Notepad" data-placement="bottom" style='margin-right:6px'></i> Notepad</a>
              <?php else: ?>
              <a href='javascript://' id="notepad_request" style='color:#7f8c8d !important;'><i class="glyph-icon icon-file tooltip-button" title="Notepad" data-placement="bottom" style='margin-right:6px'></i> Notepad</a>
              <?php endif;?>
            </li>
			<li>
              <?php
				$openSources = true;
				if((int)$this->session->userdata['type']!=9){
					if(!in_array(38,$this->session->userdata['modules_assign'])){
						$openSources = false;
					}
				}
				if($openSources===true):
				?>
              <a href='javascript://' id="sources_request" style='color:#fff;' onclick='openSources()'><i class="glyph-icon icon-database tooltip-button" title="Sources" data-placement="bottom" style='margin-right:6px'></i> Sources</a>
              <?php else: ?>
              <a href='javascript://' id="sources_request" style='color:#7f8c8d !important;'><i class="glyph-icon icon-database tooltip-button" title="Sources" data-placement="bottom" style='margin-right:6px'></i> Sources</a>
              <?php endif;?>
            </li>
            <li>
              <?php if((int)$this->session->userdata['user']['type']==9 || in_array(1,$this->session->userdata['modules_assign'])):?>
              <a  href="javascript://" id="advanced_search_button"  onclick="open_advanced_search(jQuery(this))" style='color:#fff;'><i class="glyph-icon icon-search tooltip-button" title="Search" data-placement="bottom" style='margin-right:6px'></i>Search</a>
              <?php 
			else:	
		?>
              <a  href="javascript://" id="advanced_search_button" style='color:#7f8c8d !important;'><i class="glyph-icon icon-search tooltip-button" title="Search" data-placement="bottom" style='margin-right:6px'></i>Search</a>
              <?php endif;?>
            </li>
            <li>
              <?php if((int)$this->session->userdata['user']['type']==9 || in_array(3,$this->session->userdata['modules_assign'])):?>
              <a  href="javascript://" id="scanned_documents" onclick="open_scanned_documents(jQuery(this))" style='color:#fff;'><i class="glyph-icon icon-file-text-o tooltip-button" title="Scanner" data-placement="bottom" style='margin-right:6px'></i>Scanner</a>
              <?php else:?>
              <a  href="javascript://" id="scanned_documents" style='color:#7f8c8d !important;'><i class="glyph-icon icon-file-text-o tooltip-button" title="Scanner" data-placement="bottom" style='margin-right:6px'></i>Scanner</a>
              <?php endif;?>
            </li>
			<li>
              <?php if((int)$this->session->userdata['user']['type']==9 || in_array(8,$this->session->userdata['modules_assign'])):?>
              <a href="javascript://" id='open_lead_messages'  onclick="getPredefinedMessages(3)" style='color:#fff'><i class="glyph-icon icon-user tooltip-button" title="Manage Contact" data-placement="bottom" style='margin-right:6px'></i>Portfolio Messages</a>
			   <?php else:?>
			    <a href="javascript://" id='open_lead_messages' style='color:#7f8c8d !important;'><i class="glyph-icon icon-user tooltip-button" title="Manage Contact" data-placement="bottom" style='margin-right:6px'></i>Portfolio Messages</a>
			   <?php endif;?>
			 </li>
            <li>
			  <?php if((int)$this->session->userdata['user']['type']==9 || in_array(28,$this->session->userdata['modules_assign'])):?>
              <a href="javascript://" id='open_messages_bank'  onclick="getPredefinedMessages(4)" style='color:#fff'><i class="glyph-icon icon-user tooltip-button" title="Manage Companies" data-placement="bottom" style='margin-right:6px'></i>Messages Bank</a>
              <?php else:?>             
              <a href="javascript://" id='open_messages_bank' style='color:#7f8c8d !important;'><i class="glyph-icon icon-user tooltip-button" title="Manage Contact" data-placement="bottom" style='margin-right:6px'></i>Messages Bank</a>
              <?php endif;?>
            </li>
            <li>
              <?php if((int)$this->session->userdata['user']['type']==9 || in_array(9,$this->session->userdata['modules_assign'])):?>
              <a id="btnTopCalendar" style='color:#fff'  href="javascript://" onclick="open_all_invitation()"><i class="glyph-icon icon-calendar tooltip-button" title="Calendar" data-placement="bottom" style='margin-right:6px'></i>Calendar</a>
              <?php else:?>
              <a id="btnTopCalendar" style='color:#7f8c8d !important;'  href="javascript://"><i class="glyph-icon icon-calendar tooltip-button" title="Calendar" data-placement="bottom" style='margin-right:6px'></i>Calendar</a>
              <?php endif;?>
            </li>
			<li>
              <?php if((int)$this->session->userdata['user']['type']==9 || in_array(42,$this->session->userdata['modules_assign'])):?>
              <a id="btnTopCalendar" style='color:#fff'  href="javascript://" onclick="open_scheduler()"><i class="glyph-icon icon-calendar tooltip-button" title="Scheduler" data-placement="bottom" style='margin-right:6px'></i>Scheduler</a>
              <?php else:?>
              <a id="btnTopCalendar" style='color:#7f8c8d !important;'  href="javascript://"><i class="glyph-icon icon-calendar tooltip-button" title="Scheduler" data-placement="bottom" style='margin-right:6px'></i>Scheduler</a>
              <?php endif;?>
            </li>
			<li>
              <?php if((int)$this->session->userdata['user']['type']==9 || in_array(8,$this->session->userdata['modules_assign'])):?>
              <a href="javascript://" id='open_current_contact_list_ico'  onclick="open_current_contact_list(jQuery(this))" style='color:#fff'><i class="glyph-icon icon-user tooltip-button" title="Manage Contact" data-placement="bottom" style='margin-right:6px'></i>Current Company</a>
			   <?php else:?>
			    <a href="javascript://" id='open_contact_list_ico' style='color:#7f8c8d !important;'><i class="glyph-icon icon-user tooltip-button" title="Manage Contact" data-placement="bottom" style='margin-right:6px'></i>Current Company</a>
			   <?php endif;?>
			 </li>
            <li>
              <?php if((int)$this->session->userdata['user']['type']==9 || in_array(8,$this->session->userdata['modules_assign'])):?>
              <a href="javascript://" id='open_contact_list_ico'  onclick="open_contact_list(jQuery(this))" style='color:#fff'><i class="glyph-icon icon-user tooltip-button" title="Manage Contact" data-placement="bottom" style='margin-right:6px'></i>Contacts</a>
			   <?php else:?>
			    <a href="javascript://" id='open_contact_list_ico' style='color:#7f8c8d !important;'><i class="glyph-icon icon-user tooltip-button" title="Manage Contact" data-placement="bottom" style='margin-right:6px'></i>Contacts</a>
			   <?php endif;?>
			 </li>
            <li>
			  <?php if((int)$this->session->userdata['user']['type']==9 || in_array(28,$this->session->userdata['modules_assign'])):?>
              <a href="javascript://" id='open_company_list_ico'  onclick="window.openCContact()" style='color:#fff'><i class="glyph-icon icon-user tooltip-button" title="Manage Companies" data-placement="bottom" style='margin-right:6px'></i>Companies</a>
              <?php else:?>             
              <a href="javascript://" id='open_company_list_ico' style='color:#7f8c8d !important;'><i class="glyph-icon icon-user tooltip-button" title="Manage Contact" data-placement="bottom" style='margin-right:6px'></i>Companies</a>
              <?php endif;?>
            </li>
			<li>
			  <?php if((int)$this->session->userdata['user']['type']==9 || in_array(43,$this->session->userdata['modules_assign'])):?>
              <a href="javascript://" id='open_pre_company_list_ico'  onclick="window.openPreCContact()" style='color:#fff'><i class="glyph-icon icon-user tooltip-button" title="Open Pre Companies" data-placement="bottom" style='margin-right:6px'></i>Pre Companies</a>
              <?php else:?>       
              <a href="javascript://" id='open_pre_company_list_ico' style='color:#7f8c8d !important;'><i class="glyph-icon icon-user tooltip-button" title="Manage Contact" data-placement="bottom" style='margin-right:6px'></i>Pre Companies</a>
              <?php endif;?>
            </li>
          </ul>
        </li>
        <li >
          <?php if((int)$this->session->userdata['user']['type']==9 || in_array(21,$this->session->userdata['modules_assign'])):?>
          <a href="javascript://" id="btn-notify-user" onclick="btnNotifyUser()" aria-expanded="false" style='color:#fff;'> <i class="glyph-icon icon-inbox tooltip-button" title="In Messages" data-placement="bottom"></i>&nbsp;In Messages&nbsp; <span class="value" title="In Messages" data-placement="bottom" style='color:#F04235;font-size:15px;'>0</span></a>
          <?php else:?>
          <a href="javascript://" id="btn-notify-user" style='color:#7f8c8d !important;'> <i class="glyph-icon icon-inbox tooltip-button" title="In Messages" data-placement="bottom"></i>&nbsp;In Messages&nbsp; <span class="value" title="In Messages" data-placement="bottom" style='color:#F04235;font-size:15px;'></span></a>
          <?php endif;?>
        </li>
        <li >
          <?php if((int)$this->session->userdata['user']['type']==9 || in_array(22,$this->session->userdata['modules_assign'])):?>
          <a href="javascript://" id="btn-my-notify-user" onclick="btnMyNotifyUser()" style='color:#fff;'><i class="glyph-icon icon-send-o tooltip-button" title="Out Messages"></i>&nbsp;Out Messages&nbsp;<span class="value" title="Out Messages" data-placement="bottom" style='color:#F04235;font-size:15px;'>0</span></a>
          <?php else:?>
          <a href="javascript://" id="btn-my-notify-user" style='color:#7f8c8d !important;position:relative;top:3px'> <i class="glyph-icon icon-inbox tooltip-button" title="Out Messages" data-placement="bottom"></i>&nbsp;Out Messages&nbsp;<span class="value" title="Out Messages" data-placement="bottom" style='color:#F04235;font-size:15px;'></span></a>
          <?php endif;?>
        </li>
      </ul>
    </div>
    
    <div class='main-header-custom'>
    <ul class="header-nav " style='min-width:85px;'>
      <li  class="ms-hover">
        <?php if((int)$this->session->userdata['user']['type']==9 || in_array(5,$this->session->userdata['modules_assign'])):?>
        <a href="javascript://" id='openTaskModal' onclick="openTaskModal()"  style='color:#fff;'><i class="glyph-icon icon-plus tooltip-button" title="Create a Task" data-placement="bottom" style='margin-right:6px'></i>Task</a>
        <?php else:?>
        <a href="javascript://" id='openTaskModal' style='color:#7f8c8d !important;'><i class="glyph-icon icon-plus tooltip-button" title="Create a Task" data-placement="bottom" style='margin-right:6px'></i>Task</a>
        <?php endif;?>
      </li>
      <li class="ms-hover">
        <?php 
			$openMyTask = true;
			if((int)$this->session->userdata['user']['type']!=9){
				if(!in_array(6,$this->session->userdata['modules_assign'])){
					$openMyTask = false;
				}
			}
			if($openMyTask===true):				
		?>
        <a href="javascript://"  id="task-btn" onclick="taskBtn()" style='color:#fff;'><i class="glyph-icon icon-tasks tooltip-button" title="Task Created For Me" data-placement="bottom" style='margin-right:6px; font-size:14px;'></i>For Me&nbsp;<span class="value" style='color:#F04235;font-size:13px;'>0</span></a>
        <?php else:?>
        <a href="javascript://"  id="task-btn" style='color:#7f8c8d !important;'><i class="glyph-icon icon-tasks tooltip-button" title="Task Created For Me" data-placement="bottom" style='margin-right:6px; font-size:14px;'></i>For Me&nbsp;<span class="value" style='color:#F04235;font-size:15px;'></span></a>
        <?php endif;?>
      </li>
      <li class="ms-hover">
        <?php 			
			if($openMyTask===true):
		?>
        <a href="javascript://"  id="task-i-btn" onclick="taskIBtn()" style='color:#fff;position:relative;top:3px'><i class="glyph-icon icon-tasks tooltip-button" title="Task I created" data-placement="bottom" style='margin-right:6px'></i>I created&nbsp;<span class="value" style='color:#F04235;font-size:13px;'>0</span></a>
        <?php else:?>
        <a href="javascript://"  id="task-i-btn"  style='color:#7f8c8d !important;position:relative;top:3px'><i class="glyph-icon icon-tasks tooltip-button" title="Task I created" data-placement="bottom" style='margin-right:6px'></i>I created&nbsp;<span class="value" style='color:#F04235;font-size:15px;'></span></a>
        <?php endif;?>
      </li>
    </ul>
    </div>    
    <div class='main-header-custom'>
      <ul class="header-nav " style='min-width:100px;'>
        <li  class="ms-hover">
          <?php if((int)$this->session->userdata['user']['type']==9 || in_array(14,$this->session->userdata['modules_assign'])):?>
          <a href="javascript://"  style='color:#fff'  id='acquisitionActivityButton'><i class="glyph-icon icon-cubes tooltip-button" data-placement="bottom" title='Acquisition' style='margin-right:6px'></i>Acquisition</a>
          <?php else:?>
          <a href="javascript://"  style='color:#7f8c8d !important;'><i class="glyph-icon icon-cubes tooltip-button" data-placement="bottom" title='Acquisition' style='margin-right:6px'></i>Acquisition</a>
          <?php endif;?>
        </li>
		<?php 
			$higlightUtilities = "";
			if((int)$this->session->userdata['type']!=9){
				$modules = array(4,29,2,20,16,30,31);
				$checkTap = false;
				foreach($modules as $m){
					if(in_array($m,$this->session->userdata['modules_assign'])){
						$checkTap = true;
						break;
					}
				}
				if($checkTap === false) {
					$higlightUtilities = "style='color:#7f8c8d !important;'";
				}
			}
		?>
        <li style='padding:2px 0px;'> <a href="#" title="Homepages" <?php echo $higlightUtilities;?>> <i class="glyph-icon icon-users tooltip-button" title="Operations" data-placement="bottom" style='margin-right:6px'></i>Operations <i class="glyph-icon icon-angle-down"></i> </a>
          <ul style='top:43px;padding-right:0px;min-width:110px;'>
            <li>
              <?php 
					$openComment = true;
					if((int)$this->session->userdata['user']['type']!=9){
						if(!in_array(4,$this->session->userdata['modules_assign'])){
							$openComment = false;
						}
					}
					if($openComment===true):
				?>
              <a  href="javascript://" id='openConmmentModal' onclick="openConmmentModal()" style='color:#fff;'><i class="glyph-icon icon-comments-o tooltip-button" title="Analysis" data-placement="bottom" style='margin-right:6px'></i>Analysis</a>
              <?php else:?>
              <a  href="javascript://" style='color:#7f8c8d !important;'><i class="glyph-icon icon-comments-o tooltip-button" title="Analysis" data-placement="bottom" style='margin-right:6px'></i>Analysis</a>
              <?php endif;?>
            </li>
			<li>
				<?php 
				$declareSEP = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(29,$this->session->userdata['modules_assign'])){
						$declareSEP = false;
					}
				}
				
				if($declareSEP===true): ?>
				<a href='javascript://' id="declare_sep" onclick="openSEPFull()" style='color:#fff;'><i class="glyph-icon icon-comments-o tooltip-button" title="Declared Sep" data-placement="bottom" style='margin-right:6px'></i>Declared Sep</a>
				 <?php else:?>
				 <a  href="javascript://" id="declare_sep" style='color:#7f8c8d !important;'><i class="glyph-icon icon-comments-o tooltip-button" title="Declared Sep" data-placement="bottom" style='margin-right:6px'></i>Declared Sep</a>
              <?php endif;?>
			</li>
            <li>
              <?php 
					$openDocket = true;
					if((int)$this->session->userdata['user']['type']!=9){
						if(!in_array(2,$this->session->userdata['modules_assign'])){
							$openDocket = false;
						}
					}
					if($openDocket===true):
				?>
              <a  href="javascript://" id='openDocketModal' onclick="openDocketModal()" style='color:#fff;'><i class="glyph-icon icon-stack-exchange tooltip-button" title="Docket" data-placement="bottom" style='margin-right:6px'></i>Docket</a>
              <?php else:?>
              <a  href="javascript://" style='color:#7f8c8d !important;'><i class="glyph-icon icon-stack-exchange tooltip-button" title="Docket" data-placement="bottom" style='margin-right:6px'></i>Docket</a>
              <?php endif;?>
            </li>
            
            <li>
              <?php 
					$openEOU = true;
					if((int)$this->session->userdata['user']['type']!=9){
						if(!in_array(20,$this->session->userdata['modules_assign'])){
							$openEOU = false;
						}
					}
					if($openEOU===true):
				?>
              <a  href="javascript://" id='openEOUModal' onclick="openEOUModal()" style='color:#fff;'><i class="glyph-icon icon-folder tooltip-button" title="Due Dilligence Project" data-placement="bottom" style='margin-right:6px'></i>Outsource</a>
              <?php else:?>
              <a  href="javascript://" style='color:#7f8c8d !important;'><i class="glyph-icon icon-folder tooltip-button" title="Due Dilligence Project" data-placement="bottom" style='margin-right:6px'></i>Outsource</a>
              <?php endif;?>
            </li>
			<li>
				<?php 
				$openClaimcharts = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(30,$this->session->userdata['modules_assign'])){
						$openClaimcharts = false;
					}
				}
				if($openClaimcharts===true):?>
				<a href="javascript://" id='btnClaimcharts' class='' style='color:#fff;' onclick="openLeadDocketClaimchart()"><i class="glyph-icon icon-cube tooltip-button"   data-placement="bottom" title='Claimcharts' style='margin-right:6px'></i>Claimcharts <span id="claim_reports" style="color:#F04235;font-size:13px;"></span></a>
				<?php else:?>
				<a href="javascript://" id='btnClaimcharts' class='' style='color:#7f8c8d !important;' ><i class="glyph-icon icon-cube tooltip-button"   data-placement="bottom" title='Claimcharts' style='margin-right:6px'></i>Claimcharts <span id="claim_reports" style="color:#F04235;font-size:13px;"></span></a>
				<?php endif;?>
			</li>
			<li> 
				<?php 
				$openLicenses = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(31,$this->session->userdata['modules_assign'])){
						$openLicenses = false;
					}
				}
				if($openLicenses===true):?>
				<a href="javascript://" id='btnAllLicense' class='' style='color:#fff;' onclick="openAllLicensesForAllLead()"><i class="glyph-icon icon-cube tooltip-button"   data-placement="bottom" title='Licenses' style='margin-right:6px'></i>Licenses</a>
				<?php else:?>
				<a href="javascript://" id='btnAllLicense' class='' style='color:#7f8c8d !important;'><i class="glyph-icon icon-cube tooltip-button"   data-placement="bottom" title='Licenses' style='margin-right:6px'></i>Licenses</a>
				<?php endif;?>
			</li>
			<li>
				<?php 
				$openFamilyStandalone = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(32,$this->session->userdata['modules_assign'])){
						$openFamilyStandalone = false;
					}
				}
				if($openFamilyStandalone===true):?>
				<a href="javascript://" id='btnFamilySlider' class='' style='color:#fff;' onclick="openFamilySlider()"><i class="glyph-icon icon-folder tooltip-button" title="Family" data-placement="bottom" style='margin-right:6px'></i>Family</a>
				<?php else:?>
				<a href="javascript://" id='btnFamilySlider' class='' style='color:#7f8c8d;' ><i class="glyph-icon icon-folder tooltip-button" title="Family" data-placement="bottom" style='margin-right:6px'></i>Family</a>
				<?php endif;?>
			</li>
			<li>
				<?php 
				$openAssignmentStandalone = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(33,$this->session->userdata['modules_assign'])){
						$openAssignmentStandalone = false;
					}
				}
				if($openAssignmentStandalone===true):?>
				<a href="javascript://" id='btnAssignmentSlider' class='' style='color:#fff;' onclick="openAssignmentSlider()"><i class="glyph-icon icon-folder tooltip-button" title="Assignment" data-placement="bottom" style='margin-right:6px'></i>Assignment</a>
				<?php else:?>
				<a href="javascript://" id='btnAssignmentSlider' class='' style='color:#7f8c8d;' ><i class="glyph-icon icon-folder tooltip-button" title="Assignment" data-placement="bottom" style='margin-right:6px'></i>Assignment</a>
				<?php endif;?>
			</li>
			<li>
				<?php 
				$openCitationComp = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(34,$this->session->userdata['modules_assign'])){
						$openCitationComp = false;
					}
				}
				if($openCitationComp===true):?>
				<a href="javascript://" id='btnCitationSlider' class='' style='color:#fff;' onclick="openCitationCompSlider()"><i class="glyph-icon icon-folder tooltip-button" title="Citing Comp." data-placement="bottom" style='margin-right:6px'></i>Citing Comp.</a>
				<?php else:?>
				<a href="javascript://" id='btnCitationSlider' class='' style='color:#7f8c8d;' ><i class="glyph-icon icon-folder tooltip-button" title="Citation Comp." data-placement="bottom" style='margin-right:6px'></i>Citation Comp.</a>
				<?php endif;?>
			</li>
			<li>
				<?php 
				$openLitigationScrape = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(39,$this->session->userdata['modules_assign'])){
						$openLitigationScrape = false;
					}
				}
				if($openLitigationScrape===true):?>
				<a href="javascript://" id='btnLitigationScrapeSlider' class='' style='color:#fff;' onclick="openLitigationScrapeSlider()"><i class="glyph-icon icon-folder tooltip-button" title="Citing Comp." data-placement="bottom" style='margin-right:6px'></i>Litigation</a>
				<?php else:?>
				<a href="javascript://" id='btnCitationSlider' class='' style='color:#7f8c8d;' ><i class="glyph-icon icon-folder tooltip-button" title="Citation Comp." data-placement="bottom" style='margin-right:6px'></i>Litigation</a>
				<?php endif;?>
			</li>
			<li>
				<?php 
				$openLitigationScrape = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(40,$this->session->userdata['modules_assign'])){
						$openLitigationScrape = false;
					}
				}
				if($openLitigationScrape===true):?>
				<a href="javascript://" id='btnLitigationCompSlider' class='' style='color:#fff;' onclick="openLitigationCompSlider()"><i class="glyph-icon icon-folder tooltip-button" title="Citing Comp." data-placement="bottom" style='margin-right:6px'></i>Litigation Comp.</a>
				<?php else:?>
				<a href="javascript://" id='btnLitigationCompSlider' class='' style='color:#7f8c8d;' ><i class="glyph-icon icon-folder tooltip-button" title="Citation Comp." data-placement="bottom" style='margin-right:6px'></i>Litigation Comp.</a>
				<?php endif;?>
			</li>
			<li>
				<?php 
				$openOwlerFinder = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(35,$this->session->userdata['modules_assign'])){
						$openOwlerFinder = false;
					}
				}
				if($openOwlerFinder===true):?>
				<a href="javascript://" id='btnOwlerSlider' class='' style='color:#fff;' onclick="openOwlerFinderSlider()"><i class="glyph-icon icon-folder tooltip-button" title="Comparables" data-placement="bottom" style='margin-right:6px'></i>Comparables</a>
				<?php else:?>
				<a href="javascript://" id='btnOwlerSlider' class='' style='color:#7f8c8d;' ><i class="glyph-icon icon-folder tooltip-button" title="Comparables" data-placement="bottom" style='margin-right:6px'></i>Comparables</a>
				<?php endif;?>
			</li>
			<li>
				<?php 
				$openCompanyFinder = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(36,$this->session->userdata['modules_assign'])){
						$openCompanyFinder = false;
					}
				}
				if($openCompanyFinder===true):?>
				<a href="javascript://" id='btnCompanyFinderSlider' class='' style='color:#fff;' onclick="openCompanyFinderSlider()"><i class="glyph-icon icon-folder tooltip-button" title="Company Finder" data-placement="bottom" style='margin-right:6px'></i>Comp. Finder</a>
				<?php else:?>
				<a href="javascript://" id='btnCompanyFinderSlider' class='' style='color:#7f8c8d;' ><i class="glyph-icon icon-folder tooltip-button" title="Company Finder" data-placement="bottom" style='margin-right:6px'></i>Comp. Finder</a>
				<?php endif;?>
			</li>
			<li>
				<?php 
				$openNotification = true;
				if((int)$this->session->userdata['user']['type']!=9){
					if(!in_array(41,$this->session->userdata['modules_assign'])){
						$openNotification = false;
					}
				}
				if($openNotification===true):?>
				<a href="javascript://" id='btnNotificationSlider' class='' style='color:#fff;' onclick="openNotificationSlider()"><i class="glyph-icon icon-folder tooltip-button" title="Notifications" data-placement="bottom" style='margin-right:6px'></i>Notifications</a>
				<?php else:?>
				<a href="javascript://" id='btnNotificationSlider' class='' style='color:#7f8c8d;' ><i class="glyph-icon icon-folder tooltip-button" title="Notifications" data-placement="bottom" style='margin-right:6px'></i>Notifications</a>
				<?php endif;?>
			</li>
            <li> <a  href="javascript://" id='openContratorModal' onclick="openContratorModal()" style='color:#7f8c8d !important;'><i class="glyph-icon icon-folder tooltip-button" title="Contrators" data-placement="bottom" style='margin-right:6px'></i>Contractors</a> </li>
          </ul>
        </li>
        <li>
              <?php if((int)$this->session->userdata['user']['type']==9 || in_array(16,$this->session->userdata['modules_assign'])):?>
              <a href="javascript://" id='btnPatentsAll' class='' style='color:#fff;'><i class="glyph-icon icon-cube tooltip-button"   data-placement="bottom" title='Patents' style='margin-right:6px'></i>Patents</a>
              <?php else:?>
              <a href="javascript://" class='' style='color:#7f8c8d !important;'><i class="glyph-icon icon-cube tooltip-button"  data-placement="bottom" title='Patents' style='margin-right:6px'></i>Patents</a>
              <?php endif;?>
            </li>
      </ul>
    </div>
    
    <div class='main-header-custom'>
    <ul  class="header-nav " style='min-width:90px;'>
		<li class="ms-hover">
        <?php if((int)$this->session->userdata['user']['type']==9 || in_array(15,$this->session->userdata['modules_assign'])):?>
        <a href="javascript://"  style='color:#fff'  id='salesActivityButton'><i class="glyph-icon icon-rocket tooltip-button" data-placement="bottom" title='Sales' style='margin-right:6px; font-size:14px;'></i>Sales</a>
        <?php else:?>
        <a href="javascript://"  style='color:#7f8c8d !important;'><i class="glyph-icon icon-rocket tooltip-button" data-placement="bottom" title='Sales' style='margin-right:6px'></i>Sales</a>
        <?php endif;?>
		</li>
		<li  class="ms-hover">
        <?php if((int)$this->session->userdata['user']['type']==9 || in_array(18,$this->session->userdata['modules_assign'])):?>
        <a  href="javascript://" style='color:#fff;' id='openLicenseesModalB'><i class="glyph-icon icon-newspaper-o tooltip-button" title="POS" data-placement="bottom" style='margin-right:6px; font-size:14px;'></i>POS <span class="value" title="In Messages" data-placement="bottom" style="color:yellow;font-size:15px;font-weight:bold;"></span> <i class="glyph-icon icon-angle-down"></i></a>
		<ul style='top:43px;padding-right:0px;min-width:190px;'>
			<li class="ms-hover"><a  href="javascript://" id="customer_request" style='color:#fff;position:relative;top:1px' onclick="openCustomerRequest()"><i class="glyph-icon icon-envelope tooltip-button" title="Licenses Email Unread" data-placement="bottom" style='margin-right:6px; font-size:13px;'></i>Customers List <span class="value" style="color:yellow;font-size:13px;max-width: 15px;display: inline-block;font-weight:bold"></span></a></li>
			<li><a href='javascript://'  onclick="openLicenseesModal(4)"><i class="glyph-icon icon-file-text-o tooltip-button" title="" data-placement="bottom" style="margin-right:6px" data-original-title="Check Availability"></i>Availability Checks <span class="value" title="In Messages" data-placement="bottom" style="color:yellow;font-size:15px;font-weight:bold;"></span></a></li>
			<li><a href='javascript://'  onclick="openLicenseesModal(2)"><i class="glyph-icon icon-file-text-o tooltip-button" title="" data-placement="bottom" style="margin-right:6px" data-original-title="Revised Document"></i>Drafts PLA/ERA <span class="value" title="In Messages" data-placement="bottom" style="color:yellow;font-size:15px;font-weight:bold;"></span></a></li>
            <li><a href='javascript://'  onclick="openLicenseesModal(1)" style='color:#2196F3 !important;'><i class="glyph-icon icon-file-text-o tooltip-button" title="" data-placement="bottom" style="margin-right:6px;" data-original-title="Request to Participate"></i>Requests to Participate <span class="value" title="In Messages" data-placement="bottom" style="color:yellow;font-size:15px;font-weight:bold;"></span></a></li>
			 <li><a href='javascript://'  onclick="openLicenseesModal(3)" style='color:#2196F3 !important;'><i class="glyph-icon icon-file-text-o tooltip-button" title="" data-placement="bottom" style="margin-right:6px" data-original-title="Confirmed Request"></i>Confirmed Requests</a></li>
			 <li><a href='javascript://'  onclick="openLicenseesModal(10)"><i class="glyph-icon icon-file-text-o tooltip-button" title="" data-placement="bottom" style="margin-right:6px" data-original-title="Request to Participate"></i>Pending Payments <span class="value" title="In Messages" data-placement="bottom" style="color:yellow;font-size:15px;font-weight:bold;"></span></a></li>
			 <li><a href='javascript://'  onclick="openLicenseesModal(11)"><i class="glyph-icon icon-file-text-o tooltip-button" title="" data-placement="bottom" style="margin-right:6px" data-original-title="Archived Participants"></i>Archived Partcipants</a></li>
			 <li><a href='javascript://'  onclick="openLicenseesModal(12)"><i class="glyph-icon icon-file-text-o tooltip-button" title="" data-placement="bottom" style="margin-right:6px" data-original-title="Agreements"></i>Agreements</a></li>
            <li><a href='javascript://'  onclick="openLicenseesModal(8)"><i class="glyph-icon icon-file-text-o tooltip-button" title="" data-placement="bottom" style="margin-right:6px" data-original-title="Request to Participate"></i>Counter Exec. Agree. <span class="value" title="In Messages" data-placement="bottom" style="color:yellow;font-size:15px;font-weight:bold;"></span></a></li>
            <li><a href='javascript://'  onclick="attachDocumentToPOSCustomerList()"><i class="glyph-icon icon-stack-exchange tooltip-button" title="" data-placement="bottom" style="margin-right:6px" data-original-title="Deal Flow"></i>Deals Flow</a></li>
		</ul>
        <?php else:?>
        <a  href="javascript://" style='color:#7f8c8d !important;'><i class="glyph-icon icon-newspaper-o tooltip-button" title="POS" data-placement="bottom" style='margin-right:6px'></i>POS</a>
        <?php endif;?>
		</li>
		<li style='padding-left:20px;'>
			<?php /*if((int)$this->session->userdata['user']['type']==9):?>
			<div class="df-hole" data-crmname='backyard_synpat' data-sitekey="7pqhLfdlK7TJoDKlP7CBVf3zsnY0ICTq2pEgdi6q1pk=" data-secret="1ee9247397c05d94cbf0e283b95460a1b90ddfd4" data-domain="backyard.synpat.com" data-login="webmaster@synpat.com"></div>
			<script src='https://app.datafills.com/public/assets/dfills/app.js'></script>
			<?php endif;*/?>
		</li>
      <!--<li   class="ms-hover">
        <?php if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):?>
        <a  href="javascript://" id="licenses_emails" style='color:#fff;position:relative;top:2px' onclick="getImapEmails('messages_container',jQuery('.emails-group-container').find('a.list-group-item').eq(jQuery('.emails-group-container').find('a.list-group-item').length-2))"><i class="glyph-icon icon-envelope tooltip-button" title="Licenses Email Unread" data-placement="bottom" style='margin-right:6px'></i>Licenses <span class="value" style="color:#F04235;font-size:15px;"></span></a>
        <?php else:?>
        <a  href="javascript://" id="licenses_emails" style='color:#7f8c8d !important;position:relative;top:2px'><i class="glyph-icon icon-envelope tooltip-button" title="Licenses Email Unread" data-placement="bottom" style='margin-right:6px'></i>Licenses <span class="value" style="color:#F04235;font-size:15px;"></span></a>
        <?php endif;?>
      </li>-->
		<li class="ms-hover"></li>
    </ul>
    </div>
    
    <div class='main-header-custom'>
    <ul class="header-nav " style='min-width:95px;'>
      <li  class="ms-hover">
        <?php 
			$openLeadActivities = true;
			if((int)$this->session->userdata['user']['type']!=9){
				if(!in_array(7,$this->session->userdata['modules_assign'])){
					$openLeadActivities = false;
				}
			}
			if($openLeadActivities===true):
		?>
        <a href="javascript://"  id="activity-btn" onclick="activityBtn()" style='color:#fff;'> <i class="glyph-icon icon-exclamation-circle tooltip-button" title="Activities" data-placement="bottom" style='margin-right:6px; font-size:14px;'></i>Activities</a>
        <?php else:?>
        <a href="javascript://"  id="activity-btn" style='color:#7f8c8d !important;'> <i class="glyph-icon icon-exclamation-circle tooltip-button" title="Activities" data-placement="bottom" style='margin-right:6px'></i>Activities</a>
        <?php endif;?>
      </li>
      <li  class="ms-hover">
        <?php if((int)$this->session->userdata['user']['type']==9 || in_array(19,$this->session->userdata['modules_assign'])):?>
        <a href="javascript://" class='' onclick="displayLitigationCampaign('from_litigation',jQuery(this))" id='displayLitigationCampaign' style='color:#fff;'><i class="glyph-icon icon-table tooltip-button" data-placement="bottom" title='Litigation' style='margin-right:6px; font-size:14px;'></i>Litigation</a>
        <?php else:?>
        <a href="javascript://"  style='color:#7f8c8d !important;'><i class="glyph-icon icon-table tooltip-button" data-placement="bottom" title='Litigation' style='margin-right:6px; font-size:14px;'></i>Litigation</a>
        <?php endif;?>
      </li>
      <li class="ms-hover">
        <?php if((int)$this->session->userdata['user']['type']==9 || in_array(13,$this->session->userdata['modules_assign'])):?>
        <a href="javascript://" id="web_lead" onclick="open_all_list()" style='color:#fff;position:relative'><i class="glyph-icon icon-globe tooltip-button" title="Portfolios" data-placement="bottom" style='margin-right:6px; font-size:14px;'></i>Web Form&nbsp;<span style="color:#F04235;font-size:13px;">00</span></a>
        <?php else:?>
        <a href="javascript://" id="" style='color:#7f8c8d !important;position:relative'><i class="glyph-icon icon-globe tooltip-button" title="Portfolios" data-placement="bottom" style='margin-right:10px'></i>Web Form&nbsp;<span style="color:#F04235;font-size:15px;"></span></a>
        <?php endif;?>
      </li>
    </ul>
    </div>
    
    <div class='main-header-custom' style='padding-right:0px;'>
    <ul class="header-nav " style='min-width:90px;'>
      <li  class="ms-hover">
        <?php if((int)$this->session->userdata['user']['type']==9 || in_array(12,$this->session->userdata['modules_assign'])):?>
        <a id="btnFormCollapse"  href="javascript://" onclick="formCollapse();" style='color:#fff;' class=''> <i class="glyph-icon icon-list-alt tooltip-button" title="Portfolio Form Collapse" data-placement="bottom" style='margin-right:6px; font-size:14px;'></i>Portfolio Form</a>
        <?php else:?>
        <a href="javascript://" style='color:#7f8c8d !important;' class=''> <i class="glyph-icon icon-list-alt tooltip-button" title="Portfolio Form Collapse" data-placement="bottom" style='margin-right:6px; font-size:14px;'></i>Portfolio Form</a>
        <?php endif;?>
      </li>
      <li  class="ms-hover">
        <?php if((int)$this->session->userdata['user']['type']==9 || in_array(11,$this->session->userdata['modules_assign'])):?>
        <a id="btnEmail"  href="javascript://" onclick="btnEmailCollapse()" style='color:#fff' class='menu-active'> <i class="glyph-icon icon-envelope tooltip-button" title="Emails" data-placement="bottom" style='margin-right:6px; font-size:13px;'></i>Emails</a>
        <?php else:?>
		<a href="javascript://" style='color:#7f8c8d !important'> <i class="glyph-icon icon-envelope tooltip-button" title="Emails" data-placement="bottom" style='margin-right:6px'></i>Emails</a>
		<?php endif;?>
      </li>
      <li  class="ms-hover"> 
	  <?php if((int)$this->session->userdata['user']['type']==9 || in_array(13,$this->session->userdata['modules_assign'])):?>
	  <a  href="javascript://" style='color:#fff' class='menu-active1' id='split_window_screen' data-split='combined' onclick='checkWindow();'><i class="glyph-icon icon-dashboard tooltip-button" title="Dashboard" data-placement="bottom" style='margin-right:6px; font-size:14px;'></i>Portfolios</a> 
	  <?php else:?>
	  <a  href="javascript://" style='color:#7f8c8d !important;background:none !important;' class='menu-active1' id='split_window_screen' data-split='combined' ><i class="glyph-icon icon-dashboard tooltip-button" title="Dashboard" data-placement="bottom" style='margin-right:6px; font-size:14px;'></i>Portfolios</a> 
	  <?php endif;?>
	  </li>
    </ul>
    </div>
    <?php /*
    <div class='main-header-custom'>
    <ul class="header-nav ">
      <li  class="ms-hover">
        <?php 
			$openPreSale = true;
			if((int)$this->session->userdata['user']['type']!=9){
				if(!in_array(25,$this->session->userdata['modules_assign'])){
					$openPreSale = false;
				}
			}
			if($openPreSale===true):
		?>
        <a  href="javascript://" id='preSaleActivityButton1' style='color:#fff;'><i class="glyph-icon icon-folder tooltip-button" title="PreSale Activity" data-placement="bottom" style='margin-right:6px'></i>PreSale</a>
        <?php else:?>
        <a  href="javascript://" style='color:#7f8c8d !important;'><i class="glyph-icon icon-folder tooltip-button" title="PreSale Activity" data-placement="bottom" style='margin-right:6px'></i>PreSale</a>
        <?php endif;?>
      </li>
    </ul>
    </div><?php */?>
  </div>
  </div>
            </td>
            
            <td style='width:100px;'>
             
	 <!-- logout-->
  <div class="pull-right logOutSection" >
  <div id="header-nav-left" style='margin: 8px 5px 0px 5px;'>
    <div style='text-align:right;'>
      <?php  

					if(empty($this->session->userdata['profile_pic'])):

				?>
      <img  height="48" src="<?php echo $Layout->aws_server_cdn;?>image-resources/gravatar.jpg" alt="Profile image"/>
      <?php else:?>
      <img  height="48" src="<?php echo $this->session->userdata['profile_pic']; ?>" alt="Profile image"/>
      <?php endif;?>
      <div class="create-lead-pager-wrapper" style="position:absolute; top:-10000px;">
        <ul class="pager create-lead clearfix pull-left mrg10T mrg10R" style='margin-bottom:0px'>
          <li>
            <input type="checkbox" data-on-color="danger" data-size="mini" name="checkbox-example-2221" class="input-switch" checked data-size="mini" data-on-text="On" data-off-text="Off" onclick="checkLogin(jQuery(this))" value="yes" />
          </li>
        </ul>
      </div>
    </div>
    <div class="user-account-btn dropdown" style='margin:0px;text-align:right;'> <a href="#" title="My Account" class="user-profile clearfix" data-toggle="dropdown" style='margin-right:0px;overflow:hidden;height:20px;line-height:20px;margin-top:-4px;'> <i class="glyph-icon icon-angle-down downArrow" style='float:right'></i> <span style='margin-right:15px; display:block;width:80px;overflow:hidden;'><?php echo $this->session->userdata['name'];?></span> </a>
      <div class="dropdown-menu float-left">
        <div class="box-sm">
          <div class="login-box clearfix">
            <div class="user-img">
              <?php 

								if(empty($this->session->userdata['profile_pic'])):

							?>
              <img src="<?php echo $Layout->aws_server_cdn;?>image-resources/gravatar.jpg" alt="">
              <?php else:?>
              <img src="<?php echo $this->session->userdata['profile_pic']; ?>" alt="">
              <?php endif;?>
            </div>
            <div class="user-info"> <span> <?php echo $this->session->userdata['name'];?> <i>
              <?php 

										echo $this->session->userdata['title'];

									?>
              </i> </span> <a href='javascript://' onclick="myProfile()">Edit Profile</a>
              <?php /*echo anchor('users/profile', 'Edit profile', 'title="Edit profille"')*/;?>
            </div>
          </div>
          <div class="divider"></div>
          <div class="pad5A button-pane button-pane-alt text-center"> <a href="javascript://" onclick="logout()" class="btn display-block font-normal btn-danger" style="color:#ffffff"> <i class="glyph-icon icon-power-off"></i> Logout </a> </div>
        </div>
      </div>
    </div>
  </div>
  </div>
            </td>
        </tr>
   </table>
	
		<!--<div style='float:right'><a data-toggle="dropdown" href="javascript://" aria-expanded="false">Timmer</a><div class="dropdown-menu box-md"><ul class='clockUl'><li>PST <span id="pst"></span></li><li>MST <span id="mst"></span></li><li>CST <span id="cst"></span></li><li>EST <span id="est"></span></li></ul><ul class='clockUl'><li>China <span id="china"></span></li><li>Japan <span id="japan"></span></li><li>Korea <span id="korea"></span></li><li>Taiwan <span id="taiwan"></span></li></ul><ul class='clockUl' style='width:100px;'><li>UK <span id="uk"></span></li><li>Germany <span id="germany"></span></li><li>Finland <span id="finland"></span></li><li>Sweden <span id="sweden"></span></li></ul><ul class='clockUl'><li>Italy <span id="italy"></span></li><li>Israel <span id="israel"></span></li><li>Ireland <span id="ireland"></span></li><li>France <span id="france"></span></li></ul></div></div>-->  <div class="breadcrumb-wrapper clearfix" style='width:40%;'>
    <ol class="breadcrumb pull-left clearfix">
    </ol>
    <div id="signalA" class='circle pull-left' style='position:relative;top:6px;z-index: 999;left:0px;'></div>
    <div class="topbar-lead-name pull-left" style='width: 150px;overflow: hidden;height: 20px;'></div>
  </div> </div>  <div class="modal modal-opened-header fade" id="open_calendar" tabindex="-1" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style='width:100%'> <div class="modal-dialog" style='width:100%'> <div class="modal-content"> <div class="modal-body"> <div class="row"> <div class="col-lg-12"> <iframe id="calendarFramePg" src="" style="border-width:0;width:100%" height="800" frameborder="0" scrolling="no"></iframe> </div> </div> <div class="clearfix"></div> </div> </div> </div> </div><div class="modal modal-opened-header fade" id="open_opportunity" role="dialog" aria-labelledby="calendarLabel" aria-hidden="true" style='width:100%'> <div class="modal-dialog" style='width:100%'> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title" id="docketLabel">Docket</h4> </div> <div class="modal-body"> <div class="row"> <div class="col-lg-12" id="docket_frame"> </div> </div> <div class="clearfix"> </div> </div> <div class="modal-footer"> <button type="button" class="btn btn-default btn-mwidth" data-dismiss="modal">Cancel</button> </div> </div> </div> </div> 
  <div class="modal modal-opened-header fade" id="open_lucidchart" tabindex="-1" role="dialog" aria-labelledby="lucidchartLabel" aria-hidden="true" style='width:100%'> <div class="modal-dialog" style='width:100%'> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title" id="calendarLabel">Docket</h4> </div> <div class="modal-body lucidChartBody"> <div class="clearfix"> </div> </div> <div class="modal-footer"> <button type="button" class="btn btn-default btn-mwidth" data-dismiss="modal">Cancel</button> </div> </div> </div> </div> 
<div id="team_notes_panel" class="hide"><div id="msg_div"></div> <div class="scrollable-content scrollable-slim-sidebar"> <div class="pad15A pad0T"><div class="row"><div class="col-lg-12 mrg5T"><span style="font-size:13px;margin-left:3px;"><a href="javascript://" onclick="getPreLeadDetails();" style="color:#56b2fe">Web Form</a></span></div>  <div class="col-lg-12" id="comment_upper_list" style="max-height:300px;overflow-x:hidden;overflow-y:auto"></div> <div id="form_comment_upper" class="mrg10T col-lg-12"> <form name="topbar_commentForm" action="" id="topbar_commentForm" class="form-flat form-horizontal"> <div class="row row-width"> <div class="col-xs-4"> <label class="control-label" for="marketProspectsName" style="min-height:43px;">Are there >10 potential licensees? Who?</label> <?php echo form_textarea(array('name'=>'comment[comment1]','id'=>'commentComment1','value' => '','class'=>'form-control','rows'=>4,'cols'=>15));?> </div> <div class="col-xs-4"> <label class="control-label" for="marketProspectsName" style="min-height:43px;">Easy to show infringement? Are there EoU? How clear?</label> <?php echo form_textarea(array('name'=>'comment[comment2]','id'=>'commentComment2','value' => '','class'=>'form-control','rows'=>4,'cols'=>15));?> </div> <div class="col-xs-4"> <label class="control-label" for="marketProspectsName" style="min-height:43px;">Seller's concerns + Your general observations</label> <?php echo form_textarea(array('name'=>'comment[comment3]','id'=>'commentComment3','value' => '','class'=>'form-control','rows'=>4,'cols'=>15));?> </div> <div class="col-width" style="/*width:68px*/"> <div style="margin-right:-4px"> <label class="control-label" for="marketProspectsName" style="min-height:43px;">Attractive</label> <select name="attractiveness" id="attractiveness" class="form-control" style='/*width:90px;*/'><?php for($i=1;$i<11;$i++){ ?><option value="<?php echo $i;?>"><?php echo $i;?></option><?php }?></select> </div></div> </div> <input type="hidden" name="comment_id" id="commentId"/> <input type="hidden" name="type" value="" id="leadType"/><div id="loading_lead_comment" class="loading-spinner hide"> <img src="<?php echo $Layout->aws_server_cdn;?>images/ajax-loader.gif" alt=""> </div></form> </div> </div></div> </div></div> 		
<div class="modal fade" id="createTaskModal1" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel" aria-hidden="true" style="width:50%;left:0px"> <div class="modal-dialog" style='width:100%'> <div class="modal-content"> 
<?php echo form_open("opportunity/task",array("class"=>"form-horizontal form-flat","id"=>"formTask"));?> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title" id="createTaskModalLabel"></h4> </div> 
<div class="modal-body"> 
<div class="row"> 
<div class="col-xs-12"> <div class="clearfix"> <label class="control-label" style="float:left">For:</label> <select name="task[user_id]" id="taskUserId" required="required" class="form-control" style="float:left;width:225px;margin-top:2px;margin-left:3px"> <option value="">-- Select User --</option> <?php 
	foreach($getUserList as $user){
?> <option value="<?php echo $user->id?>"><?php echo $user->name;?></option> <?php                                               
	}
?> </select> </div> </div> 
<div class="col-xs-12 mrg5T"> <div class="clearfix"> <label class="control-label" style="float:left">Subject:</label> <input type="text" maxlength="40" class="form-control input-string" name="task[subject]" id="taskSubject" style="float:left;width:225px;margin-top:4px"/> </div> </div> </div>
<div class="clearfix mrg10T"> <div class="form-group"> <label>Message:</label> <textarea name="task[message]" class="form-control input-string" id="taskMessage" rows="5"></textarea> </div> </div>
<div class="row"><div class="col-xs-12 mrg5T"> <div class="clearfix"> <label class="control-label" style="float:left">Execution Date:</label> <input name="task[execution_date]" class="bootstrap-datepicker form-control input-string" id="taskExecutionDate" placeholder="yyyy-mm-dd" style="float:left;width:82px;margin-top:4px" /> </div> </div><div class="col-xs-12 mrg5T"> <div class="clearfix"> <label class="control-label" style="float:left">Send Email:</label> <input type='checkbox' name="task[send_email]" class=" " id="taskSendEmail" style="float:left;margin-top:9px" value='1'/> </div> </div><div class="col-xs-12"> <div class="clearfix"> <label class="control-label" style="float:left">Link Url:</label> <input  name="task[doc_url]" class="form-control input-string" id="taskDocUrl" style="float:left;width:518px;margin-top:4px" /> </div> </div> </div> 
<div class="clearfix"> </div> </div>
<div class="modal-footer"> 
<button type="button" class="btn btn-default btn-mwidth" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-primary btn-mwidth" onclick="submitTask()">Create</button> <input type="hidden" name="task[parent_id]" value="0" id="taskParentId" /> 
<input type="hidden" name="task[from_user_id]" value="<?php echo $this->session->userdata['id']?>" id="taskFromUserId" /> 
<input type="hidden" name="task[lead_id]" value="0" id="taskLeadId" /> 
<input type="hidden" name="task[type]" id="taskType" /> 
<input type="hidden" name="task[id]" id="taskId" value="0" />
<input type="hidden" name="task[contact_id]" id="taskPID" value="0" />
<input type="hidden" name="task[company_id]" id="taskCID" value="0" />
<input type="hidden" name="task[activity_type]" id="taskActivityType" value="0" />
<input type="hidden" name="task[record]" id="taskRecord" value="0" />
<input type="hidden" name="task[email_id]" id="taskEmailId" value="0" />
<input type="hidden" name="other[signature]" id="otherSignature" value="" />
<input type="hidden" name="activity[person_id]" id="activityPersonID"/>
<input type="hidden" name="activity[company_id]" id="activityCompanyID"/>
<input type="hidden" name="activity[activity_type]" id="activityActivityType"/>
</div><?php echo form_close();?>  </div> </div> </div> 										
<div class="modal fade sb-right" id="replyTaskModal" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel" aria-hidden="true" style="width:50%;right:0px;margin-right:0px;margin-top:82px !important"> <div class="modal-dialog" style='width:100%'> <div class="modal-content"> <div class="modal-header"> <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<span style="position:absolute;left:0px;width: 70px;z-index: 999;"><a href="javascript:void(0)" class="btn " onclick="changeSlidebarCenter(jQuery(this))" style="float: right;font-weight: normal;box-shadow: none;line-height: 18px;height: auto;"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="align-center" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-align-center fa-w-14 fa-2x" style="width: 10px;height:18px;"><path fill="currentColor" d="M352 44v40c0 8.837-7.163 16-16 16H112c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h224c8.837 0 16 7.163 16 16zM16 228h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 256h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm320-200H112c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h224c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z" class=""></path></svg></a><a href="javascript:void(0)" class="btn " onclick="changeSlidebarSide(jQuery(this))" style="float: right;font-weight: normal;box-shadow: none;line-height: 18px;height: auto;"><i class="glyph-icon icon-exchange"></i></a></span>
<a href="javascript:void(0)" class="btn close" data-dismiss="modal" aria-label="Close" style="float:right !important;height:28px;"><span aria-hidden="true">&times;</span></a>
<a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarCenter(jQuery(this))" style='float:right'><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="align-center" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-align-center fa-w-14 fa-2x" style="width:10px;height:18px;"><path fill="currentColor" d="M352 44v40c0 8.837-7.163 16-16 16H112c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h224c8.837 0 16 7.163 16 16zM16 228h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 256h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm320-200H112c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h224c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z" class=""></path></svg></a>
<a href="javascript:void(0)" class="btn nm" onclick="changeSlidebarSidePop(jQuery(this))" style="float:right !important;height:30px;"><i class="glyph-icon icon-exchange"></i></a>
<a href='javascript:void(0)' class="btn nm" onclick="changePopWidthOnfly('replyTaskModal',100)" style='float:right;height:30px;'>100%</a>
<a href='javascript:void(0)' class="btn nm" onclick="changePopWidthOnfly('replyTaskModal',60)" style='float:right;height:30px;'>60%</a>
<a href='javascript:void(0)' class="btn nm" onclick="changePopWidthOnfly('replyTaskModal',50)" style='float:right;height:30px;'>50%</a>
<a href='javascript:void(0)' class="btn nm" onclick="changePopWidthOnfly('replyTaskModal',40)" style='float:right;height:30px;'>40%</a><a href='javascript:void(0)' class="btn nm" onclick="changePopWidthOnfly('replyTaskModal',30);" style='float:right'>30%</a>
<h4 class="modal-title" id="replyTaskModalLabel" style='padding-left:65px;'> Task Details</h4> </div> <div class="modal-body" style="width:100%;"> <?php echo form_open("opportunity/reply_task",array("class"=>"form-horizontal form-flat","id"=>"formReplyTask"));?> <div class="row" id='other_user_task'> <div class="col-xs-2" style='width:12%;overflow:hidden'> <div class="form-group"> <label><strong>From:</strong></label> <span id="replyFromUser"></span> </div> </div> <div class="col-xs-2" style='width:12%;overflow:hidden'> <div class="form-group"> <label><strong>To:</strong></label> <span id="replyToUser"></span> </div> </div> <div class="col-xs-3"> <div class="form-group"> <label><strong>Subject:</strong></label> <span id="replySubject" style='overflow:hidden'></span> </div> </div> <div class="col-xs-2" style='margin-left:3px'> <div class="form-group"> <label><strong>Created On:</strong></label> <span id="replyReceived"></span> </div> </div> <div class="col-xs-2"> <div class="form-group"> <label><strong>Execut. Dt:</strong></label> <span id="replyExecutionDate"></span> </div> </div> <div class="col-xs-2"> <div class="form-group"> <label><strong>Link:</strong></label> <span id="replyLink"></span> </div> </div> <div class="col-xs-2" id="emailMain"> <div class="form-group"> <label><strong>Email:</strong></label> <span id="emailLink"></span> </div> </div></div> 
<div class='row' id='my_own_task'>
<div  class="col-xs-12">
<div class="form-group"> <label><strong>To:</strong></label><select name="mytask[user_id]" id="mytaskTouser" class="form-control" style="width:225px;display:inline-block;margin-top:2px;margin-left:3px"><option value="0">-- Select User--</option> 
<?php 
foreach($getUserList as $user){
?> 
<option value="<?php echo $user->id?>"><?php echo $user->name;?></option> 
<?php                                               
}
?>
</select></div>
</div>
<div class="col-xs-12 mrg5T"> 
<div class="clearfix"> 
<label class="control-label" style="float:left">Subject:</label> 
<input type="text" maxlength="40" class="form-control input-string" name="mytask[subject]" id="mytaskSubject" style="float:left;width:225px;margin-top:4px"/> 
</div> 
</div> 
<div class="clearfix mrg10T"> 
<div class="form-group"> 
<label>Message:</label> 
<textarea name="mytask[message]" class="form-control input-string" id="mytaskMessage" rows="5"></textarea> 
</div> 
</div>
<div class="row"><div class="col-xs-12 mrg5T"> <div class="clearfix"><div class="col-xs-5"> <label class="control-label" style="float:left">Execution Date:</label> <input name="mytask[execution_date]" class="bootstrap-datepicker form-control input-string" id="mytaskExecutionDate" placeholder="yyyy-mm-dd" style="float:left;width:82px;margin-top:4px" /></div><div class="col-xs-7"><div class="pull-right" id="mytask_contact_detail"></div></div> </div> </div>
<div class="col-xs-12 mrg5T"> <div class="clearfix"> <label class="control-label" style="float:left">Send Email:</label> <input type='checkbox' name="mytask[send_email]" class=" " id="mytaskSendEmail" style="float:left;margin-top:9px" value='1'/> </div> </div>
<div class="col-xs-12"> <div class="clearfix"> <label class="control-label" style="float:left">Link Url:</label> <input  name="mytask[doc_url]" class="form-control input-string" id="mytaskDocUrl" style="float:left;width:518px;margin-top:4px" /> </div> </div> </div> 
<div class="clearfix"> </div></div>
<div class="row" id='send_task_message'> <div class="col-xs-12"> <div class="viewticket"> <div class="box_content p9"> <div class="databox blue"> <div class="comments"> <div class="comment"> <div class="comment_content"> <div id="ticket__body"> <p></p> </div> </div> <a id="ticket__body_button"><span></span></a> </div> </div> </div> </div> </div> </div> </div> <div class="row mrg10T"> <div class="col-xs-4" id="replyForwardTask"> <div class="form-group"> <label> Forward Task <input type="checkbox" name="reply[forward]" id="replyForward" value="1" onclick="forwardEnabled(jQuery(this))"/> </label> </div> </div> <div class="col-xs-4" id="deleteTask"> <div class="form-group"> <label> Remove Task <input type="checkbox" name="reply[reply]" value="2" onclick="taskMyComplete(jQuery(this))" id="replyRemoveTask" /> </label> </div> </div> <div class="col-xs-4" id="replyCompleteTask"> <div class="form-group"> <label> Complete <input type="checkbox" name="reply[complete]" value="1" onclick="taskComplete(jQuery(this))" id="replyComplete" /> </label> </div> </div> </div> <div class="" id="forwardUserTo" style="display:none"> <div class="form-group"> <label style="float:left" class="control-label">User:</label> <select name="reply[user_id]" id="taskUserId" required="required" class="form-control" style="float:left;width:225px;margin-top:2px;margin-left:3px"> <option value="">-- Select User --</option> <?php 										
	foreach($getUserList as $user){
		if($user->id!=$this->session->userdata['id']):
?> <option value="<?php echo $user->id?>"><?php echo $user->name;?></option> <?php
		endif;
	}
?> </select> </div> </div> <div class="row"> <div class="col-xs-12 mrg10T" id="forwardMessageTo" style="display:none"> <div class="form-group"> <label>Message:</label> <textarea name="reply[message]" class="form-control input-string" id="replyMessage" rows="5"></textarea> </div> </div> <div class="col-xs-12 mrg5T" id="forwardExecutionDate" style="display:none"> <div class="form-group"> <label class="control-label" style="float:left">Execution Date:</label> <input name="reply[execution_date]" class="bootstrap-datepicker form-control input-string" id="replyExecutionDate" style="float:left;width:82px;margin-top:4px" placeholder="yyyy-mm-dd" /> </div> </div> <div class="col-xs-12 mrg5T"><div class="form-group"> <label class="control-label" style="float:left">Send Email:</label> <input type='checkbox' name="reply[send_email]" class="" id="replySendEmail" style="float:left;margin-top:9px" value="1" /> </div></div></div> <div class="row"> <button type="button" class="btn btn-primary btn-mwidth" onclick="replyTask()" id="replyButton" style='display:none'>Submit</button> <button type="button" class="btn btn-primary btn-mwidth" id="formOPen" style='display:none'>Open Form</button> <input type="hidden" name="reply[parent_id]" value="0" id="replyParentId" /> <input type="hidden" name="reply[from_user_id]" value="<?php echo $this->session->userdata['id']?>" id="replyFromUserId" /> <input type="hidden" name="reply[lead_id]" value="0" id="replyLeadId" /> <input type="hidden" name="reply[type]" id="replyType" /> <input type="hidden" name="reply[subject]" id="replyInputSubject" /> <input type="hidden" name="reply[flag]" value="0" id="replyFlag" /> </div> <?php echo form_close();?> <h3 class="font-blue mrg10T">Messages</h3> <?php echo form_open("opportunity/task_conversation",array("class"=>"form-horizontal form-flat","id"=>"formTaskConversation"));?> <div class="row"> <img src="<?php echo $Layout->aws_server_cdn;?>images/ajax-loader.gif" alt="" id="messageListTask" style="display:none"> <div> <div class="viewticket"> <div class="box m0"> <div class="box_content p9"> <div class="databox blue"> <h5> <a id="expand_collapse_button" class="fright" href="">+ Expand All</a> </h5> <div class="comments" id="message-inbox-task-list" style="max-height:260px;overflow:hidden;overflow-y:scroll;overflow-x:none"> </div> </div> </div> </div> </div> </div> <div class="col-lg-12 mrg10T"> <textarea name="message[message]" id="messageConversationTask" class="form-control" rows="3" col="29" style='height:65px!important;border-color:#3daeff!important'></textarea> </div> <div class="col-lg-12 mrg10T"> <select name="message[user][]" id="messageUser" multiple required="required" class="multi-select"> <?php 
	foreach($getUserList as $user){
?> <option value="<?php echo $user->id;?>"><?php echo $user->name;?></option> <?php
	}
?> </select> </div> </div> <div class="row"> <input type="hidden" name="message[task_id]" value="0" id="messageTaskID" /> <input type="hidden" name="message[from_u]" value="<?php echo $this->session->userdata['id']?>" id="messageSend" /> <button type="button" class="btn btn-primary btn-mwidth mrg10T pull-right" onclick="sendMessageTaskFor()" id="senTaskConversation">Send</button> <div id="loading_task_conversation" class="loading-spinner hide"> <img src="<?php echo $Layout->aws_server_cdn;?>images/ajax-loader.gif" alt=""/> </div> </div> <?php echo form_close();?> </div> </div> </div> </div> 
<div id="gmail_message_modal" class="sb-slidebar bg-white sb-left sb-style-overlay"><span style="position:absolute;left:0px;width: 70px;z-index: 999;"><a href="javascript:void(0)" class="btn " onclick="changeSlidebarCenter(jQuery(this))" style="float: right;font-weight: normal;box-shadow: none;line-height: 18px;height: auto;"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="align-center" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-align-center fa-w-14 fa-2x" style="width: 10px;height:18px;"><path fill="currentColor" d="M352 44v40c0 8.837-7.163 16-16 16H112c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h224c8.837 0 16 7.163 16 16zM16 228h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 256h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm320-200H112c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h224c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z" class=""></path></svg></a><a href="javascript:void(0)" class="btn " onclick="changeSlidebarSide(jQuery(this))" style="float: right;font-weight: normal;box-shadow: none;line-height: 18px;height: auto;"><i class="glyph-icon icon-exchange"></i></a></span><div class="sb-slidebar-top-buttons"><a href="javascript:void(0)" class="btn nm" onclick="closeSlideBarLeftMessage()" style="float:right"><i class="glyph-icon icon-close"></i></a><a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarCenter(jQuery(this))" style='float:right'><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="align-center" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-align-center fa-w-14 fa-2x" style="width:10px;height:18px;"><path fill="currentColor" d="M352 44v40c0 8.837-7.163 16-16 16H112c-8.837 0-16-7.163-16-16V44c0-8.837 7.163-16 16-16h224c8.837 0 16 7.163 16 16zM16 228h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 256h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm320-200H112c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16h224c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16z" class=""></path></svg></a><a href="javascript:void(0)" class="btn nm" onclick="changeSlidebarSide(jQuery(this))" style="float:right"><i class="glyph-icon icon-exchange"></i></a><!--<a href='javascript:void(0)' onclick="changeSlidebarBackward('gmail_message_modal',100)" class="btn nm"><span class="glyph-icon icon-backward"></span></a>--><a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarWidthOnfly('gmail_message_modal',100);rowWidth();inputStringFieldsWidth();" style='float:right'>100%</a><a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarWidthOnfly('gmail_message_modal',60);rowWidth();inputStringFieldsWidth();" style='float:right'>60%</a><a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarWidthOnfly('gmail_message_modal',50);rowWidth();inputStringFieldsWidth();" style='float:right'>50%</a><a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarWidthOnfly('gmail_message_modal',40);rowWidth();inputStringFieldsWidth();" style='float:right'>40%</a>
<a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarWidthOnfly('gmail_message_modal',30);rowWidth();inputStringFieldsWidth();" style='float:right'>30%</a>
</div> <div class="scrollable-content scrollable-slim-sidebar"> <div class="">  <?php echo form_open_multipart('dashboard/reply_email',array('class'=>'form-horizontal form-flat','role'=>'form','style'=>'padding-left:2px','id'=>"myDashboardComposeEmails",'autocomplete'=>'off'));?> <?php echo form_input(array('name'=>'email[to_name]','type'=>'hidden','id'=>'emailName','required'=>'required','placeholder'=>'Name','class'=>'form-control'));?> <div class="gmail-modal" id="" style='width:96%'> <div class="modal-content"> <div class="modal-header" style='float:left;width:100%;margin-top:10px;'><h4 class="modal-title" style='font-size:13px;width:100%;display:none;'>Reply Message</h4><!--<button type="button" class="close" onclick="closeSlideBarLeftMessage()"><span aria-hidden="true">&times;</span></button>--> <button type="button" onclick='refreshContacts()' class="btn btn-primary pull-right mrg20R" title="Refresh Contacts"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sync" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-sync fa-w-16 fa-2x" style="width:10px;height:20px;margin-top: 5px;"><path fill="currentColor" d="M440.65 12.57l4 82.77A247.16 247.16 0 0 0 255.83 8C134.73 8 33.91 94.92 12.29 209.82A12 12 0 0 0 24.09 224h49.05a12 12 0 0 0 11.67-9.26 175.91 175.91 0 0 1 317-56.94l-101.46-4.86a12 12 0 0 0-12.57 12v47.41a12 12 0 0 0 12 12H500a12 12 0 0 0 12-12V12a12 12 0 0 0-12-12h-47.37a12 12 0 0 0-11.98 12.57zM255.83 432a175.61 175.61 0 0 1-146-77.8l101.8 4.87a12 12 0 0 0 12.57-12v-47.4a12 12 0 0 0-12-12H12a12 12 0 0 0-12 12V500a12 12 0 0 0 12 12h47.35a12 12 0 0 0 12-12.6l-4.15-82.57A247.17 247.17 0 0 0 255.83 504c121.11 0 221.93-86.92 243.55-201.82a12 12 0 0 0-11.8-14.18h-49.05a12 12 0 0 0-11.67 9.26A175.86 175.86 0 0 1 255.83 432z" class=""></path></svg></button><button type="submit" class="btn btn-primary pull-left mrg10R" title="Send"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-paper-plane fa-w-16 fa-2x" style="width:10px;height:20px;margin-top: 5px;"><path fill="currentColor" d="M440 6.5L24 246.4c-34.4 19.9-31.1 70.8 5.7 85.9L144 379.6V464c0 46.4 59.2 65.5 86.6 28.6l43.8-59.1 111.9 46.2c5.9 2.4 12.1 3.6 18.3 3.6 8.2 0 16.3-2.1 23.6-6.2 12.8-7.2 21.6-20 23.9-34.5l59.4-387.2c6.1-40.1-36.9-68.8-71.5-48.9zM192 464v-64.6l36.6 15.1L192 464zm212.6-28.7l-153.8-63.5L391 169.5c10.7-15.5-9.5-33.5-23.7-21.2L155.8 332.6 48 288 464 48l-59.4 387.3z" class=""></path></svg></button><button type="button" class="btn btn-primary pull-right mrg10R" onclick='sendEmailAddTask()' title="Send + Task"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tasks" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-tasks fa-w-16 fa-2x" style="width:10px;height:20px;margin-top: 5px;"><path fill="currentColor" d="M208 132h288c8.8 0 16-7.2 16-16V76c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16zm0 160h288c8.8 0 16-7.2 16-16v-40c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16zm0 160h288c8.8 0 16-7.2 16-16v-40c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16zM64 368c-26.5 0-48.6 21.5-48.6 48s22.1 48 48.6 48 48-21.5 48-48-21.5-48-48-48zm92.5-299l-72.2 72.2-15.6 15.6c-4.7 4.7-12.9 4.7-17.6 0L3.5 109.4c-4.7-4.7-4.7-12.3 0-17l15.7-15.7c4.7-4.7 12.3-4.7 17 0l22.7 22.1 63.7-63.3c4.7-4.7 12.3-4.7 17 0l17 16.5c4.6 4.7 4.6 12.3-.1 17zm0 159.6l-72.2 72.2-15.7 15.7c-4.7 4.7-12.9 4.7-17.6 0L3.5 269c-4.7-4.7-4.7-12.3 0-17l15.7-15.7c4.7-4.7 12.3-4.7 17 0l22.7 22.1 63.7-63.7c4.7-4.7 12.3-4.7 17 0l17 17c4.6 4.6 4.6 12.2-.1 16.9z" class=""></path></svg></button><button type="button" onclick="getPredefinedMessages(1);" class="btn btn-primary  pull-right mrg10R" title="Predefine Messages"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="folder-open" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-folder-open fa-w-18 fa-2x" style="width:10px;height:20px;margin-top: 5px;"><path fill="currentColor" d="M527.9 224H480v-48c0-26.5-21.5-48-48-48H272l-64-64H48C21.5 64 0 85.5 0 112v288c0 26.5 21.5 48 48 48h400c16.5 0 31.9-8.5 40.7-22.6l79.9-128c20-31.9-3-73.4-40.7-73.4zM48 118c0-3.3 2.7-6 6-6h134.1l64 64H426c3.3 0 6 2.7 6 6v42H152c-16.8 0-32.4 8.8-41.1 23.2L48 351.4zm400 282H72l77.2-128H528z" class=""></path></svg></button><button type="button" onclick="saveTemplateInB(jQuery('#emailMessage'));" class="btn btn-primary  pull-right mrg10R" title="Save Template"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="save" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-save fa-w-14 fa-2x"  style="width:10px;height:20px;margin-top: 5px;"><path fill="currentColor" d="M433.941 129.941l-83.882-83.882A48 48 0 0 0 316.118 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V163.882a48 48 0 0 0-14.059-33.941zM272 80v80H144V80h128zm122 352H54a6 6 0 0 1-6-6V86a6 6 0 0 1 6-6h42v104c0 13.255 10.745 24 24 24h176c13.255 0 24-10.745 24-24V83.882l78.243 78.243a6 6 0 0 1 1.757 4.243V426a6 6 0 0 1-6 6zM224 232c-48.523 0-88 39.477-88 88s39.477 88 88 88 88-39.477 88-88-39.477-88-88-88zm0 128c-22.056 0-40-17.944-40-40s17.944-40 40-40 40 17.944 40 40-17.944 40-40 40z" class=""></path></svg></button> </div> <div class="modal-body clearfix" style='width:100%'> <div id="gmail_message" style="margin-top:-13px"> <div class="col-md-12 pull-left mrg5T"><div class="form-group input-string-group" style="border:none!important;margin-bottom:0"> <label class="control-label">From:</label> <?php echo form_input(array('name'=>'message_send_from_email','id'=>'message_send_from_email','placeholder'=>'','class'=>'form-control textCC','style'=>'width:80%;','autocomplete'=>'off','value'=>'','readonly'=>'readonly'));?> </div><div class="" style="border-top:1px solid #dfe8f1;margin-top:1px;margin-left:-17px;margin-right:-17px"></div> <div class="form-group input-string-group" style="border:none!important;margin-bottom:0"> <label class="control-label">To:</label> <?php echo form_input(array('name'=>'email[to]','id'=>'emailTo','required'=>'required','placeholder'=>'','class'=>'form-control textCC emailTo','style'=>'width:80%;','autocomplete'=>'off','value'=>''));?> </div> <div class="" style="border-top:1px solid #dfe8f1;margin-top:1px;margin-left:-17px;margin-right:-17px"></div> <div class="form-group input-string-group mrg5T" style="border:none!important;margin-bottom:0"> <label class="control-label">CC:</label> <?php echo form_input(array('name'=>'email[cc]','id'=>'emailCC','placeholder'=>'','class'=>'form-control textCC emailCC','style'=>'width:80%;'));?> </div> <div class="" style="border-top:1px solid #dfe8f1;margin-top:1px;margin-left:-17px;margin-right:-17px"></div> <div class="form-group input-string-group mrg5T" style="border:none!important;margin-bottom:0"> <label class="control-label">BCC:</label> <?php echo form_input(array('name'=>'email[bcc]','id'=>'emailBCC','placeholder'=>'','class'=>'form-control textCC emailBCC','style'=>'width:80%;'));?> </div> <div class="" style="border-top:1px solid #dfe8f1;margin-top:1px;margin-left:-17px;margin-right:-17px"></div> <div class="form-group input-string-group mrg5T" style="border:none!important;margin-bottom:0"> <label class="control-label">Subject:</label> <?php echo form_input(array('name'=>'email[subject]','id'=>'emailSubject','required'=>'required','placeholder'=>'','class'=>'form-control emailSubject','style'=>'width:80%;'));?> </div> <div class="" style="border-top:1px solid #dfe8f1;margin-top:1px;margin-left:-17px;margin-right:-17px"></div> <div class="clearfix mrg5T"> <label class="control-label" style="float:left">Attachment:</label> <div id="attach_droppable" style='min-height:25px;padding:0;margin-left:75px;width:auto'></div> </div> <div class="mrg10T" style="border-top:1px solid #dfe8f1;margin-left:-17px;margin-right:-17px"></div> <div class="form-group mrg5T"> <div class="row"> 
	<?php 
	$signature = "";
	if(!empty($this->session->userdata['signature'])){
	$signature = $this->session->userdata['signature'];
	}
?><div class="col-sm-12"><input type='hidden' id='original_signature' value='<?php echo $signature;?>' /> <?php echo form_textarea(array('name'=>'email[message]','id'=>'emailMessage','required'=>'required','placeholder'=>'Message','class'=>'form-control ckeditor wysiwyg-editor emailMessage','cols'=>29, 'rows'=>50, 'style'=>'border: none !important; padding:0;height:300px !important;','value'=>"<br/><br/><br/>".$signature));?> </div> </div> </div> </div> </div> </div> <div class="modal-footer"> <div class="form-group"> <div class="row"> <div class="col-sm-offset-2 col-sm-10"> <input type="hidden" name="email[thread_id]" id="emailThreadId"/> <input type="hidden" name="email[message_id]" id="emailMessageId"/> <input type="hidden" name="email[lead_id]" id="messageLeadId"/> <input type="hidden" name="email[from_name]" value="<?php echo $this->session->userdata['name']?>" id="emailFromName"/> <input type="hidden" name="email[from_email]" value="<?php echo $this->session->userdata['email']?>" id="emailFromEmail"/> <input type="hidden" name="email[reference]" value="" id="emailReference"/> <input type="hidden" name="email[doc_url]" value="" id="emailDocUrl"/> <input type="hidden" name="email[account_type]" value="1" id="emailAccountType"/> <input type="hidden" name="another[sys]" value="0" id="anotherSys"/> <input type="hidden" name="another[legal_log]" value="0" id="legal_log"/> <input type="hidden" name="another[legal_patents]" value="0" id="legal_patents"/> <input type="hidden" name="another[f_t]" value="" id="f_t"/> <input type="hidden" name="event[c_id]" id="eventCid" value="0"/> <input type="hidden" name="event[p_id]" id="eventPid" value="0"/> <input type="hidden" name="event[t]" id="eventT" value="0"/><input type="hidden" name="event[event_user_type]" id="eventUserType" value="4"/> <button type="submit" class="btn btn-primary  pull-right" title="Send"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="paper-plane" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-paper-plane fa-w-16 fa-2x" style="width:10px;height:20px;margin-top: 5px;"><path fill="currentColor" d="M440 6.5L24 246.4c-34.4 19.9-31.1 70.8 5.7 85.9L144 379.6V464c0 46.4 59.2 65.5 86.6 28.6l43.8-59.1 111.9 46.2c5.9 2.4 12.1 3.6 18.3 3.6 8.2 0 16.3-2.1 23.6-6.2 12.8-7.2 21.6-20 23.9-34.5l59.4-387.2c6.1-40.1-36.9-68.8-71.5-48.9zM192 464v-64.6l36.6 15.1L192 464zm212.6-28.7l-153.8-63.5L391 169.5c10.7-15.5-9.5-33.5-23.7-21.2L155.8 332.6 48 288 464 48l-59.4 387.3z" class=""></path></svg></button> <button type="button" class="btn btn-primary  pull-right mrg10R" onclick='sendEmailAddTask()' title="Send + Task"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tasks" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-tasks fa-w-16 fa-2x" style="width:10px;height:20px;margin-top: 5px;"><path fill="currentColor" d="M208 132h288c8.8 0 16-7.2 16-16V76c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16zm0 160h288c8.8 0 16-7.2 16-16v-40c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16zm0 160h288c8.8 0 16-7.2 16-16v-40c0-8.8-7.2-16-16-16H208c-8.8 0-16 7.2-16 16v40c0 8.8 7.2 16 16 16zM64 368c-26.5 0-48.6 21.5-48.6 48s22.1 48 48.6 48 48-21.5 48-48-21.5-48-48-48zm92.5-299l-72.2 72.2-15.6 15.6c-4.7 4.7-12.9 4.7-17.6 0L3.5 109.4c-4.7-4.7-4.7-12.3 0-17l15.7-15.7c4.7-4.7 12.3-4.7 17 0l22.7 22.1 63.7-63.3c4.7-4.7 12.3-4.7 17 0l17 16.5c4.6 4.7 4.6 12.3-.1 17zm0 159.6l-72.2 72.2-15.7 15.7c-4.7 4.7-12.9 4.7-17.6 0L3.5 269c-4.7-4.7-4.7-12.3 0-17l15.7-15.7c4.7-4.7 12.3-4.7 17 0l22.7 22.1 63.7-63.7c4.7-4.7 12.3-4.7 17 0l17 17c4.6 4.6 4.6 12.2-.1 16.9z" class=""></path></svg></button> <a href='javascript://' class="mrg10R pull-right" onclick="discardEmail()" style="color:#222;font-size:20px;margin-top:2px"><i class="glyph-icon"><img src="<?php echo $Layout->aws_server_cdn;?>images/discard.png" style="opacity:0.55"/></i></a> </div> </div> </div> </div> </div> </div> <?php echo form_close();?> </div> </div> </div> <div class="modal modal-opened-header fade" id="emailOpenModal" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:50%;left:0px"> <div class="modal-dialog" style="width:100%"> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title" id="createContactModalLabel">Email Content</h4> </div> <div class="modal-body"> <div class="row"> <div class="col-lg-12" id="emailOpenContent" style='max-height:600px;overflow-y:scroll;overflow-x:none'> </div> </div> </div> <div class="modal-footer"></div> </div> </div> </div> <div class="modal modal-opened-header fade" id="contactForm" tabindex="" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:48%"> <div class="modal-dialog" style='width:100%!important'> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title" id="createContactModalLabel">SynPat's Contact</h4></div><div class="modal-body"> </div> </div> </div> </div>     
 <div class="modal modal-opened-header fade" id="marketContactForm" tabindex="-1" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:40%"> <div class="modal-dialog" style='width:100%!important'> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title" id="createContactModalLabel"> <button type="button" class="btn btn-primary mrg10L" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">SELECT</span></button></h4> </div> <div class="modal-body"> <iframe id="marketContactFormIframe" src="" width="100%" height="650px" style='display:none'></iframe> </div> <div class="modal-footer"></div> </div> </div> </div> <div class="modal modal-opened-header fade" id="openPrePatentF" tabindex="-1" role="dialog" aria-labelledby="openPrePatentFLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:30%;top:0"> <div class="modal-dialog" style='width:100%!important'> <div class="modal-content"> <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px"><span aria-hidden="true">&times;</span></button> <h4 class="modal-title" id=""></h4> </div> <div class="modal-body"> <iframe id="openPrePatentFIframe" src="" width="100%" height="350px" scrolling='yes'></iframe> </div> </div> </div> </div> <div id="myEmailsRetrieve" style='display:none;min-height:60px;overflow:hidden;overflow-y:auto' class="pad0A"> </div>