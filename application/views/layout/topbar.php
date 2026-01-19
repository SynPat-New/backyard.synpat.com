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
jQuery(document).ready(function(){initEditor();});function checkModalFrontOrHide(c,f){var b=jQuery("body").data("modalzindex"),e=+c.css("z-index");var a=0;$(".modal:visible, .sb-slidebar:visible").each(function(g,h){if(+$(h).css("z-index")>a){a=+$(h).css("z-index")}});if(a===e){c.modal("hide");if(typeof f==="function"){f()}}else{b+=1;jQuery("body").data("modalzindex",b);c.css("z-index",b)}}function openTaskModal(p,c){if(!jQuery("#createTaskModal1").is(":visible")){if(leadGlobal==0){alert('Please select lead first.');} else {_activity = jQuery("#activityMainType").val();jQuery("#formTask").get(0).reset();jQuery('#taskLeadId').val(leadGlobal);jQuery('#taskEmailId,#taskRecord,#taskParentId,#taskId').val(0);jQuery('#taskType').val(''); jQuery('#openTaskModal').addClass('menu-active');let pID = 0, cID = 0;if(typeof p !="undefined"){ pID = p }if(typeof c !="undefined"){ cID = c }jQuery('#taskPID').val(pID);jQuery('#taskCID').val(cID);
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
	jQuery(".modal-backdrop-drive:eq(0)