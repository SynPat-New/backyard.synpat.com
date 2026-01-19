<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/13.0.4/css/intlTelInput.css">-->
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/menu.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/autocomplete.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script type="text/javascript" src="https://mottie.github.io/tablesorter/dist/js/jquery.tablesorter.min.js"></script> 
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/13.0.4/js/intlTelInput.min.js"></script>-->
<style>
	body {
		overflow: auto !important;overflow-x:hidden !important;
		min-width: 0;
		width: 100% !important;font-size:13px;font-family:arial;margin:0px;
	}
	.ui-menu-item{list-style:none;padding:10px;border:1px solid #56b2fe;margin-bottom:3px;}
	.ui-menu-item:hover{background-color:#56b2fe;color:#fff;}	
	.ui-helper-hidden-accessible{display:none;}
	.ui-autocomplete {
	padding:0px;margin:0px;
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;width:300px !important;background:#fff;
  }
  .show_name{margin-top:8px;}
.form-control{font-family:arial;}.mrg5L{margin-left:5px;margin-top:5px;}
#inviteeLinkedinUrl{cursor:pointer !important;color:#56b2fe !important;}
table thead th, table thead td{padding:5px 4px;font-size:13px;}
.table > thead > tr > th, .table > tbody > tr > td{border:solid 1px #dddddd;text-align:left;padding:8px}
.table > thead > tr > th{border:0px;background-color:#f9f9f9;}
.table > tbody > tr > td{border-top:0px;border-left:0px;border-right:0px;}
.containerResearchHeader, .containerHeader{width:100%;overflow:hidden;}
.containerResearchBody, .containerBody{width:100%;height:250px;overflow:scroll;}
.containerResearchBody ::-webkit-scrollbar{-webkit-appearance: none;width: 10px;}
 .containerResearchBody ::-webkit-scrollbar:vertical{width: 18px;}
 .containerResearchBody ::-webkit-scrollbar-thumb{border-radius: 1px;background-color: rgba(0,0,0,.3);box-shadow: 0 0 1px rgba(255,255,255,.3);}
 th.tablesorter-headerDesc{background: url(<?php echo $Layout->baseUrl?>public/images/sort_desc.png);    background-repeat: no-repeat;background-position: right;background-color: #fff;}
 th.tablesorter-headerAsc{background: url(<?php echo $Layout->baseUrl?>public/images/sort_asc.png);    background-repeat: no-repeat;background-position: right;background-color: #fff;}
 .form-flat .form-group.input-string-group label{padding-right:0px !important;}
 /*.iti-flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/13.0.4/img/flags.png");}

@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
  .iti-flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/13.0.4/img/flags@2x.png");}
}*/
h4{font-size:13px;}
.error_red{color:red;}
.form-row{
				margin-bottom: 0.5rem;
			}
			label{
				margin-bottom: 0;
			}
			.form-control{
				border-top:0px;border-left:0px;border-right:0px;border-radius:0px;font-size:0.82rem;
			}
	</style>
	
<script>
__baseUrl = '<?php echo $Layout->baseUrl?>';
_opened = <?php echo $open?>;
function ValidURL(str) {
 /* var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;*/
  var regex = /linkedin/;
  if(!regex .test(str)) {
    alert("Please enter valid URL.");
    return false;
  } else {
    return true;
  }
}

function findContactsForThisCompany(companyID){
	jQuery.ajax({
		url: __baseUrl+'opportunity/find_c_cc',
		dataType: "json",
		data: { query: companyID },
		success: function (data) {
			if(data.length>0){
				var _table  = "<table class='table'><thead><tr><th>First name</th><th>Last Name</th><th>Job Title</th><th>Email</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
				jQuery.each(data,function(id,c){
					_table +="<tr><td><a href='javascript://' data-id='"+c.id+"' onclick='openDetails(jQuery(this))'>"+c.first_name+"</a></td><td>"+c.last_name+"</td><td>"+c.job_title+"</td><td>"+c.email+"</td><td>"+c.telephone+"</td><td>"+c.phone+"</td></tr>";
				});
				_table +="</tbody></table>";
				jQuery("#my_list").html(_table);
			}
		}
	});
}

function openDetails(obj){
	var _contactID = obj.data("id");
	window.location = __baseUrl+'opportunity/add_contact/'+_contactID;
}

function getScrapeEmail(){
	_cID = jQuery("#inviteeId").val();
	_companyID = jQuery("#inviteeCompanyId").val();
	/*jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/emailScrapeSelectedCompaniesSelectedContact',
		cache:false,
		data:{c_id:_cID,co_id:_companyID},
		dataType:'json'
	}).done(function(d){
		if(d.companies.length>0){
			window.parent.sendEmailScrapperRequest();
		}
		if(d.no_domain.length>0){
			alert("Domain not found");
		}
	});*/
	let companies = [],contacts=[];
	contacts.push(_cID);
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'users/run_email_scrapper',
		cache:false,
		data:{company_list:companies,contacts:contacts,d:'http://webdriverforscrape.site/find_emails_scrapper.php'}
	}).done(function(d){
		console.log(d);
	});
}

function scrapeMe(){
	/*send request to scrapper*/
	var linkedinURL = jQuery("#inviteeLinkedinUrl").val();
	linkedinURL = linkedinURL.toString();
	if(linkedinURL.indexOf('linkedin')>=0){
		if(jQuery("#inviteeId").val()>0){
			if(jQuery("#inviteeCompanyId").val()>0){
				console.log('I am in scrapper and found person ID');
				var list = [];
				var lObject = {};
				lObject.id = jQuery("#inviteeId").val();
				lObject.linkedin_url = linkedinURL;
				lObject.first_name = jQuery("#inviteeFirstName").val();
				lObject.last_name = jQuery("#inviteeLastName").val();
				list.push(lObject);
				jQuery.ajax({
					url:__baseUrl+'opportunity/saveSingleScrapperData/',
					type:'POST',
					data:{company_id:jQuery("#inviteeCompanyId").val(),type:3,list:list,p:0}
				}).done(function(d){
					if(d>0){
						/*if(window.parent.scraperRequest==null || (typeof window.parent.scraperRequest.readyState!=undefined && window.parent.scraperRequest.readyState==4)){
							window.parent.sendContactScrapperRequest();
						}*/
						
						checkRunningStage(4);
					}
				});	
			}	else {
				alert("Please add company first");
			}
		} else {			
			checkUserFirstByLinkedinUrl(linkedinURL);
		}
	}
}

function checkRunningStage(t) {
	jQuery.ajax({
		url:__baseUrl+'opportunity/check_running_stage/'+t,
		type:'get',
		dataType:'json',
		success:function(d){
			if(d.d == 0){
				window.parent.sendContactSingleScrapperRequest();				
			} else {
				console.log("Please wait, profile card is already running.")
			}
		}
	})
}

function checkUserFirstByLinkedinUrl(linkedinURL){
	/*Find user by linkedin url*/
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/check_contact_linkedin_url',
		data:{linkedin_url:linkedinURL},
		dataType:'json',
		success:function(d){
			if(typeof d.id!="undefined" && d.id>0){
				console.log('Old in the list contact');
				jQuery("#inviteeId").val(d.id);
				jQuery("#inviteeFirstName").val(d.first_name);
				jQuery("#inviteeLastName").val(d.last_name);
				jQuery("#inviteeJobTitle").val(d.job_title);
				jQuery("#inviteeTelephone").val(d.telephone);
				jQuery("#invitePhone").val(d.phone);
				jQuery("#inviteeCompanyPhone").val(d.company_tel);
				jQuery("#inviteeEmail").val(d.email);
				jQuery("#inviteeSecondaryEmailAddress").val(d.secondary_email);
				jQuery("#inviteeWebAddress").val(d.web_address);
				jQuery("#inviteeAcksesUrl").val(d.ackses_url);
				jQuery("#cc").val(d.c_C);
				jQuery("#proximity").val(d.proximity);
				jQuery("#current_c").val(d.current_company);
				jQuery("#inviteeAddress").val(d.address);
				jQuery("#inviteeNote").val(d.note);
				if(d.gateway==1){
					jQuery("#inviteeGateway").prop('checked',true);
				}
				if(d.no_contact==1){
					jQuery("#inviteeNoContact").prop('checked',true);
				}
				jQuery("#show_images").empty();
				if(d.linkedin_image!=null && d.linkedin_image!=""){			
					jQuery("#profileImage").html("<img src='"+d.linkedin_image+"' style='height:120px;'/>");		
				}
				if(d.img_card!="" && d.img_card!=null){
					_images = JSON.parse(d.img_card);
					jQuery.map(_images,function(i,img){
						$div = jQuery("<div/>").addClass('col-xs-12').html("<img src='"+img+"' style='width:100%;'/><a href='javascript://' onclick='deleteMe(jQuery(this))' data-img='"+img+"'><i class='fa fa-trash'></i></a>");
						jQuery("#show_images").append($div);
					});
				}
				scrapeMe();
				/*Synchronise*/
				if(typeof window.parent.pushingContact=="function"){
					window.parent.pushingContact(jQuery("#inviteeCompanyId").val(),d.success);
				}
				/*End Synchronise*/
			} else {
				console.log('New');
				//Save it first 
				if(jQuery("#inviteeCompanyId").val()>0){
					jQuery.ajax({
						type:'POST',
						url:jQuery("#ccompanyFormSubmit").attr("action"),
						data:jQuery("#ccompanyFormSubmit").serializeArray(),
						dataType:'json',
						success:function(d){
							if(typeof d.success!="undefined" && d.success>0){
								jQuery("#inviteeId").val(d.success);
								scrapeMe();
								/*Synchronise*/
								if(typeof window.parent.pushingContact=="function"){
									window.parent.pushingContact(jQuery("#inviteeCompanyId").val(),d.success);
								}
								/*End Synchronise*/
							}
						}
					});
				} else {
					alert("Please add company first");
				}
			}
		}
	});
}

function resetForm(){
	window.location =  __baseUrl+'opportunity/add_contact/0';
}

function openBusinessCard(){
	window.parent.scannedBusinessCard();
}

function openCompany(t){
	if(typeof window.parent.openCompanyEdit=="function"){
		if(t==0){
			window.parent.openCompanyEdit(0);
		} else {
			window.parent.openCompanyEdit(jQuery("#inviteeCompanyId").val());
		}
	} else if(typeof window.parent.parent.openCompanyEdit =="function"){
		if(t==0){
			window.parent.parent.openCompanyEdit(0);
		} else{
			window.parent.parent.openCompanyEdit(jQuery("#inviteeCompanyId").val());
		}
		
	}
	
}
function changeStringBox(){
	jQuery('.input-string-group').each(function(){
		_w = jQuery(this).width();
		if(jQuery(this).find('.control-label').length>0){
			lbl = jQuery(this).find('.control-label').width();
			inputW = _w - lbl-11;
			if(jQuery(this).find('input[type="text"]').length>0){
				jQuery(this).find('input[type="text"]').css('width',inputW+'px');				
			}else if(jQuery(this).find('input[type="email"]').length>0){
				jQuery(this).find('input[type="email"]').css('width',inputW+'px');
			}else if(jQuery(this).find('textarea').length>0){
				jQuery(this).find('textarea').css('width',inputW+'px');
			} else if(jQuery(this).find('span.show_name').length>0){
				jQuery(this).find('span.show_name').css('width',inputW+'px');
				jQuery(this).addClass('pull-left').css('width','100%');
			}
		}
	});
}
var _userList = [];
var minTable;
var oldLinkedinURL = "";
jQuery(document).ready(function(){
	changeStringBox();
	newHeight = (jQuery(window).height() - 120);
	if(jQuery("#inviteeLinkedinUrl").val() != ""){
		oldLinkedinURL = jQuery("#inviteeLinkedinUrl").val();
	}
	jQuery("#inviteeLinkedinUrl,#inviteeAcksesUrl").on("click",function(){
		if(jQuery(this).val()!=""){
			window.open(jQuery(this).val(),"_blank");
		}
	});
	
	jQuery("#inviteeLinkedinUrl").on("keydown",function(){
		if(oldLinkedinURL != jQuery("#inviteeLinkedinUrl").val()){
			jQuery("#inviteeLinkedinError").val(1);
		}		
	});
	jQuery("#inviteeLinkedinUrl").on("change",function(){
		if(oldLinkedinURL != jQuery("#inviteeLinkedinUrl").val()){
			jQuery("#inviteeLinkedinError").val(1);
		}
	});
	jQuery(window).resize(function(){
		_dataTable.destroy();
		enableDataTable();
		resizeTable();
		//changeStringBox();
	});
	/*$("#inviteeTelephone,#inviteeCompanyPhone,#invitePhone").intlTelInput();*/
	if(parseInt(_opened)==1){
		if(window.parent.leadGlobal>0){
			window.parent.checkProcessForAttachEmail();window.parent.processContact(<?php echo $contactID?>);
		} else {
			console.log('Mang Sang')
			window.parent.checkProcessForAttachEmail();
		}
		setTimeout(function(){
			window.parent.closeSlideBarContact();
		},400);
	}
	jQuery("#search_box").autocomplete({
		minLength: 2,
		source: function (request, response) {
			jQuery.ajax({
				url: __baseUrl+'opportunity/search_company_by_name',
				dataType: "json",
				data: { query: request.term },
				success: function (data) {
					response($.map(data, function (item) {
						return {
							label: item.Name,
							value: item.Name,
							realValue: item.UID,
							sectorId: item.SectorID,
							sectorName: item.SectorName,
						};
					}));
				},
			});
		},
		select: function (event, ui) {
			const oldCompany = jQuery("#inviteeCompanyId").val();
			jQuery("#inviteeCompanyId").val(ui.item.realValue);
			jQuery(".show_name").html('<strong><a href="javascript://" onclick="window.parent.openCompanyEdit('+ui.item.realValue+');" class="mrg5L">'+ui.item.label+'</a></strong>');
			/*Check Company Frame open*/
			if(oldCompany > 0){
				jQuery("#ccompanyFormSubmit").submit();
				let companyListSlider = window.parent.jQuery("#open_ccompany_gd");
				if(companyListSlider.length > 0) {
					if(companyListSlider.hasClass('is-open')) {
						window.parent.updateContactFromCompanyList(oldCompany);
					}
				} else {
					companyListSlider = window.parent.jQuery("#open_sales_gd");
					if(companyListSlider.length > 0) {
						if(companyListSlider.hasClass('is-open')) {
							window.parent.updateContactFromCompanyList(oldCompany);
						}
					} 
				}
			}			
			findContactsForThisCompany(ui.item.realValue);
		}
	});
	setTimeout(function(){jQuery('.ui-autocomplete').css('height',newHeight+'px');},200);
	jQuery('input[type="checkbox"]').on("change",function(){
		document.getElementById("buttonADDContact").click();
	});
	jQuery("#ccompanyFormSubmit").on('submit',function(e){
		
		e.preventDefault();
		if((jQuery("#inviteeCompanyId").val()=="" || jQuery("#inviteeCompanyId").val()=="0")&& jQuery("#search_box").val()==""){
			alert("Please assign company.");
		} else {			
			jQuery("#loading_message").html("Please wait...");
			console.log("I am in  submit...");
			jQuery.ajax({
				type:'POST',
				url:jQuery("#ccompanyFormSubmit").attr("action"),
				data:jQuery("#ccompanyFormSubmit").serializeArray(),
				dataType:'json',
				success:function(d){
					if(typeof d.success!="undefined" && d.success>0){
						jQuery("#loading_message").html("Updated...");
						setTimeout(function(){
							jQuery("#loading_message").html("");
						}, 1000);
						jQuery("#inviteeId").val(d.success);
						if(typeof d.opened!="undefined" && d.opened==1){
							if(typeof window.parent.checkProcessForAttachEmail=="function"){
								window.parent.checkProcessForAttachEmail();
							} else if(typeof window.parent.parent.checkProcessForAttachEmail=="function"){
								window.parent.parent.checkProcessForAttachEmail();
							}							
						}
						_checkIframe = false;
						var _frame;
						if(typeof window.parent.jQuery == "object" && window.parent.jQuery("#open_prefined_message").length>0){
							_checkIframe = true;
							_frame = window.parent.jQuery("#open_prefined_message");
						} else if(typeof window.parent.parent.jQuery == "object" && window.parent.parent.jQuery("#open_prefined_message").length>0){
							_checkIframe = true;
							_frame = window.parent.parent.jQuery("#open_prefined_message");
						}
						if(_checkIframe===true){
							if(_frame.hasClass('is-open')){
								console.log('PACK');
								if(_frame.find("#predefineFormIframe").attr('src')== __baseUrl+"leads/business_cards_list/"){
									console.log('PACK2');
									_frame.find("#predefineFormIframe").get(0).contentWindow.checkContactSaved();
								}
							}
						}
						/*Check Contact list open*/
						const contactListSlider = window.parent.jQuery("#open_contact_gd");
						if(contactListSlider.length > 0) {
							if(contactListSlider.hasClass('is-open')) {
								window.parent.updateContactFromList(jQuery("#inviteeId").val());
							}
						}
						/*Check Company Frame open*/
						let companyListSlider = window.parent.jQuery("#open_ccompany_gd");
						if(companyListSlider.length > 0) {
							if(companyListSlider.hasClass('is-open')) {
								window.parent.updateContactFromCompanyList(jQuery("#inviteeCompanyId").val());
							}
						} else {
							companyListSlider = window.parent.jQuery("#open_sales_gd");
							if(companyListSlider.length > 0) {
								if(companyListSlider.hasClass('is-open')) {
									window.parent.updateContactFromCompanyList(jQuery("#inviteeCompanyId").val());
								}
							} 
						}
						_checkIframe = false;
						var _frame;
						if(typeof window.parent.jQuery == "object" && window.parent.jQuery("#open_company_add").length>0){
							_checkIframe = true;
							_frame = window.parent.jQuery("#open_company_add");
						} else if(typeof window.parent.parent.jQuery == "object" && window.parent.parent.jQuery("#open_company_add").length>0){
							_checkIframe = true;
							_frame = window.parent.parent.jQuery("#open_company_add");
						}
						if(_checkIframe===true && _frame.hasClass('is-open')){
							_frame.find('iframe')[0].src = _frame.find('iframe')[0].src;
						}
						/*Synchronise*/
						if(typeof window.parent.pushingContact=="function"){
							window.parent.pushingContact(jQuery("#inviteeCompanyId").val(),d.success);
						} else if(typeof window.parent.parent.pushingContact=="function"){
							window.parent.parent.pushingContact(jQuery("#inviteeCompanyId").val(),d.success);
						}
						/*End Synchronise*/
						/*Close Slider*/
						_location = window.parent.location;
						if(_location.toString().indexOf('business_cards_list')>=0){
							/*window.location = window.location.url;*/
						} else {
							/*setTimeout(function(){
								window.parent.closeSlideBarContact();
							},400);*/
						}		
					}else  {
						if(typeof d.error_message!="undefined" && d.error_message!=""){
							alert(d.error_message);
						} else {
							alert("Please try after sometime.");
						}
					}
				}
			});
		}
	});	
	minTable = document.getElementById("box");
	enableDataTable();
	setTimeout(function(){	
		if(jQuery("#inviteeId").val()>0){
			findUserActivites();
		}
	}, 1000);
});
var _dataTable = {
	destroy:function(){

	}
};
function findUserActivites(){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/find_user_activites',
		data:{id:jQuery("#inviteeId").val()},
		dataType:'json',
	}).done(function(d){
		if(d.length>0){
			jQuery("#my_activity_list").find('tbody').empty();
			d.map(function(activity){
				jQuery("#my_activity_list").find('tbody').append("<tr><td style='width:50%;'>"+activity.leadName+" <a href='javascript://' onclick='deleteUserActivity(jQuery(this),"+activity.contact_id+","+activity.lead_id+","+activity.company_id+");'><i class='fa fa-trash'></i></a></td><td style='width:30%;'>"+activity.companyName+"</td><td style='width:20%;'><a href='javascript://;' onclick='openAllActivities("+activity.contact_id+","+activity.lead_id+","+activity.company_id+")'><i class='fa fa-envelope' title='Contacts' style='color:#2196f3' ></i></a></td></tr>");
			});
			enableDataTable();	
			resizeTable();		
		}
	})
}
function enableDataTable(){
	
}
function deleteUserActivity(o,contactID,leadID,companyID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/delete_user_activity',
		data:{contact_id:contactID,lead_id:leadID,company_id:companyID}
	}).done(function(d){
		if(d>0){
			_dataTable.destroy();
			o.parents('tr').remove();
			enableDataTable();
		}
	});
}
function resizeTable(){
	var tableResearcherT = jQuery(minTable).find('table.tableData');
	var tableResearcherFixed = jQuery(minTable).find('table.fixedHeader');
		tableResearcherThead = tableResearcherFixed.find('tr');
		tableResearcherTbody = tableResearcherT.find('tbody tr');
		j=0;
		/*tableResearcherTbody.find('td').css('width','').css('max-width','').css('min-width','');
		tableResearcherThead.find('th').css('width','').css('max-width','').css('min-width','');
		tableResearcherThead.eq(0).find('th').each(function(i,th){
			var $this = jQuery(this);
			var outerWidthTF = $this.outerWidth();
			width = outerWidthTF;
			tableResearcherTbody.each(function(){
				var innerThis = jQuery(this);
				_innerW = innerThis.find('td').eq(i).outerWidth();
				if(_innerW>width){
					width = _innerW;
				}
				innerThis.find('td').eq(i).css({width:width+"px",minWidth:width+"px",maxWidth:width+"px",wordBreak:'break-all'});
			});			
			$this.css({width:width+"px",minWidth:width+"px",maxWidth:width+"px",wordBreak:'break-all'});
			j++;
		});*/
		tableResearcherT.css({tableLayout:'fixed',wordBreak:'break-all'});
		tableResearcherFixed.css({tableLayout:'fixed',wordBreak:'break-all'});
		setTimeout(scrollSynchronize,100);sortTables();
}
function scrollSynchronize(){
	var $childE = jQuery("#box").find("div.containerResearchBody");
	var $childEH = jQuery("#box").find("div.containerResearchHeader");
	if($childE.length>0){		
		$childE.off('scroll').on('scroll',function(){
			var left = $childE.scrollLeft();
				$childEH.scrollLeft(left);
		});
	}
}
function sortTables(){
	try{
		jQuery("#my_activity_list").trigger("destroy");
	}catch(e){
		console.log(e);
	}	
	jQuery("#my_activity_list").tablesorter();
}
function openAllActivities(contactID,leadID,companyID){
	if(typeof window.parent.getAllActivites=="function"){
		window.parent.getAllActivites(leadID,contactID,companyID);
	} else {
		window.parent.parent.getAllActivites(leadID,contactID,companyID);
	}
}
function deleteContact(){
	if(jQuery("#inviteeId").val()>0){
		if(typeof window.parent.deleteGoogleContactModal=="function"){
			window.parent.deleteGoogleContactModal(jQuery("#inviteeId").val(),jQuery("#inviteeCompanyId").val());
		} else {
			window.parent.parent.deleteGoogleContactModal(jQuery("#inviteeId").val(),jQuery("#inviteeCompanyId").val());
		}
	}	
}
function deleteMe(o) {
	var imgCards = jQuery("#inviteeImgCard").val();
	if(imgCards != "") {
		try {
			var imgList = JSON.parse(imgCards);
			if(imgList.length > 0) {
				var findImageIndex = imgList.indexOf(o.attr('data-img'));
				if(findImageIndex >= 0) {
					imgList.splice(findImageIndex,1);
				}
				imgList = JSON.stringify(imgList);
				jQuery("#inviteeImgCard").val(imgList);
			}
		} catch(e) {				
		}			
	} else {
		jQuery("#inviteeImgCard").val('');
	}
	if(jQuery("#inviteeId").val()>0){
		if(o.attr('data-img') != "") {
			jQuery("#buttonADDContact").trigger("click");
			callUpdateUser(o);
		}
	}
}

function callUpdateUser(o) {
	setTimeout(function(){
		checkUpdatedUser(o);
	},500);
}

function checkUpdatedUser(o) {
	if(jQuery("#loading_message").html() == "Updated...") {
		window.location = window.location.href;
	} else {
		callUpdateUser(o);
	}
}
</script>
<?php 
	$first_name = "";
	$last_name = "";
	$job_title = "";
	$telephone = "";
	$phone = "";
	$companyPhone = "";
	$email = "";
	$secondary_email = "";
	$tertiary_email = "";
	$linkedin_url = "";
	$web_address = "";
	$address = "";
	$gateway = "";
	$no_contact = "";
	$note = "";
	$company_id = "0";
	$street = "";
	$city = "";
	$state = "";
	$zip = "";
	$country = "";
	$company_name = "";
	$imgUrl = "";
	$ackses_url = "";
	$proximity = 0;
	$cc = 0;
	$currentCompany = "";
	$profileUrl = "";
	$gender = 0;
	$active_email = 0;
	$linkedinError = 0;
	$error_email = 0;
	$error_secondary = 0;
	$error_tertiary = 0;
	if(count($contact)>0){
		$first_name = $contact->first_name;
		$last_name = $contact->last_name;
		$job_title = $contact->job_title;
		$gender = $contact->gender;
		$active_email = $contact->active_email;
		$linkedinError = $contact->linkedin_error;
		$telephone = $contact->telephone;
		$companyPhone = $contact->company_tel;
		$proximity = $contact->proximity;
		$cc = $contact->c_c;
		$currentCompany = $contact->current_company;
		$phone = $contact->phone;
		$email = $contact->email;
		$secondary_email = $contact->secondary_email;
		$tertiary_email = $contact->tertiary_email;
		$linkedin_url = $contact->linkedin_url;
		$ackses_url = $contact->ackses_url;
		$web_address = $contact->web_address;
		$address = $contact->address;
		$gateway = $contact->gateway;
		$no_contact = $contact->no_contact;
		$note = $contact->note;
		$company_id = $contact->company_id;
		$company_name = $contact->company_name;
		$street = $contact->street;
		$city = $contact->city;
		$state = $contact->state;
		$zip = $contact->zip;
		$country = $contact->country;
		$imgUrl = $contact->img_card;
		$profileUrl = $contact->linkedin_image;
		$error_email = $contact->error_email;
		$error_secondary = $contact->error_secondary;
		$error_tertiary = $contact->error_tertiary;
	}
	if(!isset($contactID)){
		$contactID = 0;
	}
?>
<div class="container-fluid">	
	<?php echo form_open('opportunity/add_contact/'.$contactID,array('class'=>"needs-validation",'id'=>'ccompanyFormSubmit'));?>
	<div class="row">
		<div class="col-12">
			<button type="submit" id="buttonADDContact" class='btn btn-primary' title="Save"><i class='fa fa-save'></i></button>
			<button type="button" onclick="deleteContact()" id="buttonDeleteContact" class='btn btn-primary' title="Delete"><i class='fa fa-trash'></i></button>
			<button type="button" onclick="resetForm()" id="btnResetForm" class='btn btn-primary' title="Reset"><i class='fa fa-undo'></i></button>
			<!--<button type="button" onclick="openCompany(1)" id="btnManageCategories" class='btn btn-primary'>Open Company</button>--> 
			<button type="button" onclick="getScrapeEmail();"  class='btn btn-primary' title="Scrape Email"><i class='fa fa-envelope'></i></button> 
			<button type="button" onclick="scrapeMe();"  class='btn btn-primary' title="Scrape from Linkedin"><i class='fa fa-linkedin'></i></button>
			<button onclick="openBusinessCard()" type="button" class="btn btn-primary"><i class='fa fa-id-card-o' title="Scanned B. Cards"></i></button>
			<button type="button" onclick="openCompany(0);"  class='btn btn-primary' title="Add a Company"><i class="fa fa-building"></i></button>
			<span id='loading_message' style='margin-left:100px'></span><img src="<?php echo $Layout->aws_server_cdn?>images/ajax-loader.gif" alt="" id="addContactTask" style='display:none;margin-left:10px'>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<!-- First, Last, Job title, Current Company, Gateway, No contact, Gender, Profile Img -->
			<div class="form-row">
				<div class="col-8">
					<div class="form-row">
						<div class="col-6">
							<label for="inviteeFirstName">First:</label>
							<input type="text" tabindex="1" class="form-control" name="invitee[first_name]" value="<?php echo $first_name;?>" id="inviteeFirstName" placeholder=""/>
						</div>
						<div class="col-6">
							<label for="inviteeLastName">Last:</label>
							<div style="position: absolute;top: 0px;left: 50px;width: 325px;z-index:999;">
								<label class="form-check-label" for="invalidCheck">Gateway:</label>
								<input type="checkbox" value='1' <?php if((int)$gateway==1):?>CHECKED='CHECKED' <?php endif;?> name="invitee[gateway]" id="inviteeGateway" tabindex="18"/>
								<label class="form-check-label ml-3" for="invalidCheck">No contact:</label>
								<input type="checkbox" value='1' name="invitee[no_contact]" id="inviteeNoContact" <?php if((int)$no_contact==1):?>CHECKED='CHECKED' <?php endif;?> tabindex="19"/>
								<label class="form-check-label ml-3" for="invalidCheck">Female:</label>
								<input name="invitee[gender]" id="inviteeGender" <?php if($gender == 1):?>CHECKED='CHECKED' <?php endif;?> type='checkbox' value="1" tabindex="20"/> 
							</div>
							<input type="text" tabindex="2" class="form-control" name="invitee[last_name]" id="inviteeLastName" value="<?php echo $last_name;?>" placeholder=""/>
						</div>
					</div>
					<div class="form-row mb-0">
						<div class="col-6">
							<label for="job_title">Job Title:</label>
							<input type="text" tabindex="3" class="form-control" name="invitee[job_title]" value="<?php echo $job_title;?>" id="inviteeJobTitle" placeholder=""/>
						</div>
						<div class="col-6">
							<label for="current_c">Current Company:</label>
							<input type="text" tabindex="4" class="form-control" id="current_c" name="invitee[current_company]" value="<?php echo $currentCompany;?>" placeholder=""/>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-row mb-0">	
						<div class="col-12">
							<label class="" for="invalidCheck">&nbsp;</label>
						</div>
						<div class="col-12" id="profileImage">
							<?php 
								if(!empty($profileUrl) && $profileUrl!=null){
							?>
								<img src="<?php echo $profileUrl;?>" style="height:108px;"  class="img-fluid img-thumbnail"/>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<!-- Search Company, and Selected Company -->
			<div class="form-row">
				<div class="col-6">
					<label for="email">Search:</label>
					<input type="text" tabindex="5" class="form-control" id="search_box" placeholder=""/>
				</div>
				<div class="col-6">
					<label for="email" id='lblCompany'>Company:</label>
					<div>
						<span class='show_name pull-left' style="max-height:18px;overflow:hidden;">
						<strong><?php if($company_id>0){echo '<a href="javascript://" onclick="window.parent.openCompanyEdit('.$company_id.');" class="mrg5L mrg5T" style="text-decoration:none;">'.$company_name.'</a>';} ?></strong>
						</span>
					</div>					
				</div>
			</div>
			<!-- Email, Secondary Email, Teritary Email, Active Email -->
			<div class="form-row">
				<div class="col-4"> 
					<input type="radio" value="1" style="position:relative;top:3px;" name="invitee[active_email]" <?php echo ((int)$active_email == 1)?'CHECKED="CHECKED"':'';?> tabindex="6"> 
					<label for="inviteeEmail">Email:</label>
					<input type="email" tabindex="7" class="form-control <?php echo ($error_email==1)?'error_red':''?>" type="email" name="invitee[email]" value="<?php echo $email;?>" id="inviteeEmail" placeholder=""/>
				</div>
				<div class="col-4">
					<input type="radio" tabindex="8" style="position:relative;top:3px;" name="invitee[active_email]" <?php echo ((int)$active_email == 2)?'CHECKED="CHECKED"':'';?>> 
					<label for="inviteeSecondaryEmailAddress">2nd:</label>
					<input type="email" tabindex="9" class="form-control <?php echo ($error_secondary==1)?'error_red':''?>" name="invitee[secondary_email]" value="<?php echo $secondary_email;?>" id="inviteeSecondaryEmailAddress" placeholder=""/>
				</div>	
				<div class="col-4">
					<input type="radio" tabindex="10" name="invitee[active_email]" <?php echo ((int)$active_email == 3)?'CHECKED="CHECKED"':'';?>> 
					<label for="inviteeTertiaryEmailAddress">3rd:</label>
					<input type="email" tabindex="11" class="form-control <?php echo ($error_tertiary==1)?'error_red':''?>" name="invitee[tertiary_email]" value="<?php echo $tertiary_email;?>" id="inviteeTertiaryEmailAddress" placeholder=""/>
				</div>
			</div>
			<!--Phone, Telephone, Company telephone -->
			<div class="form-row">
				<div class="col-4"> 
					<label for="inviteeTelephone"><i class="fa fa-phone" style="width:13px;"></i></label>
					<input type="text" tabindex="12" name="invitee[telephone]"  value="<?php echo $telephone;?>" id="inviteeTelephone" class="form-control phone" placeholder="DirectTel"/>
				</div>
				<div class="col-4">
					<label for="inviteeCompanyPhone"><i class="fa fa-phone-square" style="width:13px;"></i></label>
					<input type="text" tabindex="13" name="invitee[company_tel]" value="<?php echo $companyPhone;?>" id="inviteeCompanyPhone" class="form-control phone" placeholder="CompanyTel"/>
				</div>	
				<div class="col-4">
					<label for="invitePhone"><i class="fa fa-mobile" style="width:13px;"></i></label>
					<input type="text" tabindex="14" name="invitee[phone]" value="<?php echo $phone;?>" id="invitePhone" class="form-control phone" placeholder="MobileTel"/>
				</div>
			</div>
			<!-- Linkedin, Type, Common -->
			<div class="form-row">
				<div class="col-8">
					<label for="linkedin_url">Linkedin:</label>
					<input type="text" tabindex="15" class="form-control" name="invitee[linkedin_url]" value="<?php echo $linkedin_url;?>" id="inviteeLinkedinUrl" placeholder=""/>
				</div>
				<div class="col-2">
					<label for="last_name">Type:</label>
					<input type="text" tabindex="16" class="form-control" value="<?php echo $proximity;?>" id="proximity" placeholder=""/>
				</div>
				<div class="col-2">
					<label for="last_name">Common:</label>
					<input type="text" tabindex="17" value="<?php echo $cc;?>"  class="form-control" id="cc" placeholder=""/>
				</div>	
			</div>
			<!--Ackses, Address -->
			<div class="form-row">
				<div class="col-6">
					<label for="inviteeAcksesUrl">Ackses:</label>
					<input type="text" tabindex="18" name="invitee[ackses_url]" value="<?php echo $ackses_url;?>" class="form-control" id="inviteeAcksesUrl" placeholder=""/>
				</div>
				<div class="col-6">
					<label for="inviteeAddress">Address:</label>
					<input type="text" tabindex="19" class="form-control" name="invitee[address]" value="<?php echo $address;?>" id="inviteeAddress" placeholder=""/>
				</div>
			</div>
			<!-- Note -->
			<div class="form-row">
				<div class="col-12">
					<label for=""></label>
					<textarea type="text" tabindex="20" class="form-control" name="invitee[note]" id="inviteeNote" rows="3" placeholder=""><?php echo $note;?></textarea>
				</div>
			</div>
		</div>				
	</div>		
	<input type="hidden" name="invitee[id]" id="inviteeId" value="<?php echo $contactID;?>"/>
	<input type="hidden" name="invitee[linkedin_error]" id="inviteeLinkedinError" value="<?php echo $linkedinError;?>"/>
	<input type="hidden" name="invitee[img_card]" id="inviteeImgCard" value='<?php echo $imgUrl;?>'/>
	<input type="hidden" name="invitee[company_id]" id="inviteeCompanyId" value="<?php echo $company_id;?>" />
	<input type="hidden" name="invitee[street]" id="inviteeStreet" value="<?php echo $street;?>"/>
	<input type="hidden" name="invitee[city]" id="inviteeCity" value="<?php echo $city;?>"/>
	<input type="hidden" name="invitee[state]" id="inviteeState" value="<?php echo $state;?>"/>
	<input type="hidden" name="invitee[zip]" id="inviteeZip" value="<?php echo $zip;?>"/>
	<input type="hidden" name="invitee[country]" id="inviteeCountry" value="<?php echo $country;?>" />
	<input type="hidden" name="invitee[web_address]" id="inviteeWebAddress" value="<?php echo $web_address;?>"/>
	<?php echo form_close();?>
	<div class="row">
		<div class="col-12" id="show_images">
			<?php
				if(!empty($imgUrl) && $imgUrl!=null){
					try{
						$images = json_decode($imgUrl);
						if(count($images)>0){
							foreach($images as $img){
								if(!empty($img) && strpos($img,'profile-displayphoto-shrink_800_800')===false && strpos($img,'licdn')===false){
									if(strpos($img,"app.synpat.com") === false) {
										$img = str_replace("synpat.com","app.synpat.com",$img);
									}
				?>
								<div class="col-xs-6">
									<img src="<?php echo $img;?>" style='width:100%;'/>
									<span><a href="javascript://" onclick="deleteMe(jQuery(this))" data-img="<?php  echo $img;?>"><i class="fa fa-trash"></i></a></span>
								</div>
				<?php
								}
							}
						}
					}catch(Exception $e){
						
					}
				}
			?>
		</div>
	</div>	
	<div class="row">
		<div class="col-12">
			<div id="show_myactivites"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-12" id="box" style="margin-top:5px;">
			<div class="containerResearchHeader">
				<table class="table fixedHeader" style="width:99%">
					<thead>
						<tr>
							<th style='width:50%;'>Lead</th>
							<th style='width:30%;'>Company</th>
							<th style='width:20%;'>Activity</th>
						</tr>
					</thead>
				</table>
			</div>
			<div class="containerResearchBody dragscroll" style='height:300px;overflow:auto;width:99%'>
				<table id="my_activity_list" class="table tableData" style="width:99%">
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>