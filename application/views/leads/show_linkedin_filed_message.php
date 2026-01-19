<?php 
$date = $message->activity_date;
$ID = $message->id;
$body = $message->note;
$name = "";
$conversationID = "";
$contactID = 0;
$companyID = 0;
$companyName = "";
if(is_object($message->contact)){
	$name = $message->contact->first_name." ".$message->contact->last_name;
	$contactID = $message->contact->id;
	$companyID = $message->contact->company_id;
	$companyName = $message->contact->company_name;
}
?>
<style>
body{width:100%;min-width:100%;max-width:100%;}.message-detail-title{font-size:13px !important;font-weight:normal !important;}.message-detail-title a{font-weight:normal !important;}
</style>
<div data-padding="40" data-height="window" class="panel panel-default panel-no-margin withScroll mCustomScrollbar _mCS_117" id="message-detail" style="height:300px;max-height:300px;border:0;overflow-y:auto">
<div id="mCSB_117" class="mCustomScrollBox mCS-dark-2">
<div class="mCSB_container">
<div class="panel-heading messages message-result">
<h2 class="message-detail-title is-subject p-t-20 w-500 show">
</h2>
<div class="row">
<div class="col-xs-3">
<h2 id="messageDetailTitleSubject" class="message-detail-title p-t-20 w-500 show">
<strong><span class="message-detail-from show"><?php echo ($contactID == 0) ? $name : '<a href="javascript://" onclick="window.parent.editContact('.$contactID.')" style="color:#2196F3 !important">'.$name.'</a>';?></span></strong>
</h2>
<h2 class="message-detail-title p-t-20 w-500 show">
to: <span class="message-detail-to"></span>
<div class="message-detail-buttons-left btn-group" role="group">
<div class="btn-group" role="group">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
<span class="caret"></span>
</button>
<div class="dropdown-menu" role="menu" style="width:300px">
<div class="row">
<div class="col-xs-3">
<label>from:</label>
</div>
<div class="col-xs-9">
<strong class="message-detail-from" style='word-wrap:break-word'><?php echo $name;?></strong>
</div>
</div>
<div class="row">
<div class="col-xs-3">
<label></label>
</div>
<div class="col-xs-9">
<span class="message-detail-to" style='word-wrap:break-word'></span>
</div>
</div>
<div class="row">
<div class="col-xs-3">
<label></label>
</div>
<div class="col-xs-9">
<span class="message-detail-cc" style='word-wrap:break-word'></span>
</div>
</div>
<div class="row">
<div class="col-xs-3">
<label>date:</label>
</div>
<div class="col-xs-9">
<span class="message-detail-date"><?php echo date('M d Y H:i',strtotime($date));?></span>
</div>
</div>
<div class="row">
<div class="col-xs-3">
</div>
<div class="col-xs-9">
<span class="message-detail-subject"></span>
</div>
</div>
</div>
</div>
</div>
</h2>
</div>
<?php if($companyID > 0): ?>
<div class="col-xs-3">
<?php echo ($companyID >0) ? '<a style="color:#2196F3 !important" href="javascript://" onclick="window.parent.openCompanyContact('.$companyID.')">'.$companyName.'</a>':''?>
</div>
<?php endif;?>
<div class="<?php echo ($companyID >0) ? 'col-xs-6':'col-xs-9';?> text-right">
<h2 class="message-detail-title p-t-20 w-500 is-date show">
<span class="message-detail-date"><?php echo date('M d Y H:i',strtotime($date));?></span>
</h2>
<div class="message-detail-right show">
<div class="message-detail-buttons-right btn-group" role="group">
<button type="button" class="btn btn-default tooltip-button mrg5R" onclick="window.parent.sendMessageOnLinkedin(<?php echo $contactID;?>)" title="File" data-placement="bottom">Reply</button>
</div>
</div>
</div>
</div>
</div>
<div class="panel-body messages message-result message_detail">
<div class="loading-spinner" id="loading_spinner" style='display:none'>
<img src="<?php echo $Layout->aws_server_cdn;?>images/ajax-loader.gif" alt="">
</div>
<pre><?php echo $body;?></pre>
</div>
</div>
</div>
</div>
<script>
let __siteUrl='<?php echo $Layout->baseUrl;?>',ID = '<?php echo $ID;?>',conversationID = '<?php echo $conversationID;?>',date='<?php echo $date;?>';
function bigContent() {
	_height = jQuery(window).height() - 90;
	$('#message-detail').css('height', _height+'px');
	$('#message-detail').css('max-height', '99999px');
	$('body').addClass('is-scrollable-body');
}
jQuery(document).ready(function(){
	jQuery(".dropdown-toggle").dropdown();
	bigContent();
});
let _task = 0; 
function fileAndTask(){
	_task = 1;
	findPeople();
}
function fileOnly(){
	_task = 0;
	findPeople();
}
function findPeople(){
	jQuery.ajax({
		type:'POST',
		url:__siteUrl+'leads/find_contact_by_name',
		data:{first_name:firstName,last_name:lastName,conversation_id:conversationID},
		dataType:'json'
	}).done(c => {
		if(c.length > 0){
			console.log("Contacts",c);
			if(c.length == 1){
				findActivitesLeadsFromCompanyID(c[0].id,c[0].company_id,conversationID);
			} else {
				let _table = '<div style="/*overflow-x:none;overflow-y:scroll;height:300px;*/"> <table id="lb'+ID+'" class="table table-striped table-hover" data-order="[]"><thead><tr><th>Name</th><th>Company Name</th></tr></thead><tbody>';
				c.forEach(m => {
					_table +='<tr onclick="jQuery(\'#displayEmail\').find(\'iframe\')[0].contentWindow.findActivitesLeadsFromCompanyID('+m.id+','+m.company_id+','+conversationID+');" style="cursor:pointer;"><td><a onclick="window.parent.editContact('+m.id+')" style="color:#2196f3;">'+m.first_name+' '+m.last_name+'</a></td><td>'+m.company_name+'</td></tr>';
				});
				_table += "</tbody></table>";
				window.parent.jQuery("#sortingPopup").find(".modal-body").html(_table);
				window.parent.jQuery("#sortingPopup").find("#lb"+ID).DataTable().destroy();
				window.parent.jQuery("#sortingPopup").find('.modal-content').css({width:'600px'});
				window.parent.jQuery("#sortingPopup").css({width:'600px'}).modal("show");
				_tableAssociate = window.parent.jQuery("#sortingPopup").find("#lb"+ID).DataTable({destroy:true,paging:false,searching:true,language:{emptyTable:"No record found!"},"aaSorting": [],"order": []});
				setTimeout(function(){
					_tableAssociate.destroy();
					_tableAssociate = window.parent.jQuery("#sortingPopup").find("#lb"+ID).DataTable({destroy:true,paging:false,searching:true,"scrollY":"300px","scrollCollapse": true,language:{emptyTable:"No record found!"},"aaSorting": [],"order": []});
				},1000);
			}
		}
	});
}
function findActivitesLeadsFromCompanyID(contactID,companyID,conversationID){
	console.log("findActivitesLeadsFromCompanyID",contactID,companyID,conversationID);
	jQuery.ajax({
		type:'post',
		data:{contact_id:contactID,company_id:companyID,conversation_id:conversationID},
		url:__siteUrl+'dashboard/find_activites_leads_from_contact_id',
		dataType:'json',
		success:function(_d){
			console.log("findActivitesLeadsFromCompanyID",_d);
			if(_d.person_id>0 && _d.list.length>0){
				_table = '<div style="/*overflow-x:none;overflow-y:scroll;height:300px;*/"> <table id="lb'+conversationID+'" class="table table-striped table-hover" data-order="[]"><thead><tr><th>Lead</th><th>Activity</th></tr></thead><tbody>';
				for(l=0;l<_d.list.length;l++){
					_row = _d.list[l];
					_activityName="";
					if(_d.list[l].activity==1){
						_activityName = "Sales";
					} else if(_d.list[l].activity==2){
						_activityName = "Acquisition";
					} else if(_d.list[l].activity==3){
						_activityName = "Pre Sale";
					}
					_leadName = _d.list[l].lead_name;
					/*Check Lead in activelist*/
					if(_d.active_list.length>0){
						for(j=0;j<_d.active_list.length;j++){
							if(_d.active_list[j].id==_row.id && _d.active_list[j].activity==_d.list[l].activity){
								_leadName = "<b>"+_leadName+"</b>";
							}   
						}
					}						
					__leadName = _leadName.replace(/'/g, "\\'");
					_table +='<tr onclick="jQuery(\'#displayEmail\').find(\'iframe\')[0].contentWindow.associateMessageWithLead('+conversationID+','+_d.list[l].activity+','+_d.company_id+','+_d.person_id+','+_d.list[l].id+',\''+__leadName+'\');" style="cursor:pointer;"><td>'+_leadName+'</td><td>'+_activityName+'</td></tr>';
				}
				_table +='</tbody></table>';
				window.parent.jQuery("#sortingPopup").find(".modal-body").html(_table);
				window.parent.jQuery("#sortingPopup").find("#lb"+conversationID).DataTable().destroy();
				window.parent.jQuery("#sortingPopup").find('.modal-content').css({width:'600px'});
				window.parent.jQuery("#sortingPopup").css({width:'600px'}).modal("show");
				_tableAssociate = window.parent.jQuery("#sortingPopup").find("#lb"+conversationID).DataTable({destroy:true,paging:false,searching:true,language:{emptyTable:"No record found!"},"aaSorting": [],"order": []});
				setTimeout(function(){
					_tableAssociate.destroy();
					_tableAssociate = window.parent.jQuery("#sortingPopup").find("#lb"+conversationID).DataTable({destroy:true,paging:false,searching:true,"scrollY":"300px","scrollCollapse": true,language:{emptyTable:"No record found!"},"aaSorting": [],"order": []});
				},1000);
			}
		}
	});
}
function associateMessageWithLead(conversationID,activity,companyID,contactID,leadID){
	console.log("associateMessageWithLead",conversationID,activity,companyID,contactID,leadID,ID,conversationID);
	jQuery.ajax({
		type:'POST',
		url:__siteUrl+'dashboard/linkWithLinkedinMessage',
		data:{thread:ID,old_thread:leadID,c_id:companyID,p:contactID,t:activity,date:window.parent.formatDateFromTimeStamp(date),conversation_id:conversationID},
		dataType:'json',
		success:function(_d){
			console.log(_d);
			if(_d.send>0){
				_id = _d.send;
				window.parent.jQuery("#sortingPopup").modal("hide");
				window.parent.jQuery("#messages-list").find('div[data-id='+ID+']').remove();
				window.parent.jQuery("#displayEmail").empty();
				window.parent.jQuery("#activityMainType").val(activity);
				activateLead(leadID,activity,companyID,contactID,_id);
				if(_task == 1){
					window.parent.openTaskModal();
					window.parent.jQuery("#taskEmailId").val(_d.send);
					window.parent.jQuery("#taskPID").val(_person_id);
					window.parent.jQuery("#taskCID").val(_company_id);
				}
			}
		}
	});
}
function threadPermanentDelete(o){
	jQuery.ajax({
		type:'POST',
		url:__siteUrl+'dashboard/delete_linkedin_message',
		data:{id:ID},
		success:function(_d){
			if(_d > 0){
				window.parent.jQuery("#messages-list").find('div[data-id='+ID+']').remove();
				window.parent.jQuery("#displayEmail").empty();
			}
		}
	});
}

function activateLead(leadID, activity, companyID, contactID, ID){
	if(parseInt(activity)==1){
		console.log("ENTER1");
		window.parent.jQuery('#sales_acititity').removeClass('hide').addClass('show');
		window.parent.jQuery('#activityTable').removeClass('hide').addClass('show');
		window.parent.jQuery("#preSaleActivityTable").removeClass("show").addClass("hide");
		window.parent.jQuery('#aquisitionTable').removeClass('show').addClass('hide');
		//window.parent.jQuery('#salesActivityButton').addClass('menu-active');
		window.parent.jQuery('#acquisitionActivityButton').removeClass('menu-active');
	} else if(parseInt(activity)==2){
		console.log("ENTER2");
		window.parent.jQuery('#sales_acititity').removeClass('hide').addClass('show');
		window.parent.jQuery('#aquisitionTable').removeClass('hide').addClass('show');
		window.parent.jQuery("#preSaleActivityTable").removeClass("show").addClass("hide");
		window.parent.jQuery('#activityTable').removeClass('show').addClass('hide');
		window.parent.jQuery('#salesActivityButton').removeClass('menu-active');		
		//window.parent.jQuery('#acquisitionActivityButton').addClass('menu-active');
	}
	_index=window.parent.jQuery("#all_type_list").find("tbody").find('tr[data-id="'+leadID+'"]').index();
	if(_index>=0){
		window.parent.jQuery("#all_type_list").find("tbody").find("tr").removeClass("active");
		window.parent.jQuery("#all_type_list").find("tbody").find("tr").eq(_index).addClass("active");
		window.parent.threadDetail(window.parent.jQuery("#all_type_list").find("tbody").find("tr.active"),'undefined',1);
		_scrollTop=window.parent.jQuery("#all_type_list").find("tbody").find("tr.active").offset();
		console.log(_scrollTop);
		if(window.parent.jQuery("#dashboard_charts").is(":visible")){
			window.parent.jQuery("#all_type_list").parent().scrollTop(_scrollTop.top-263.5);
			console.log('KS');
		} else {
			window.parent.jQuery("#all_type_list").parent().scrollTop(_scrollTop.top-106);
			console.log('BKS');
		}
		_activityTable = activity;
		_company_id = companyID;
		if(window.parent.jQuery("#acquisitionActivityButton").hasClass('menu-active')){			
			window.parent.jQuery("#acquisitionActivityButton").trigger("click");
		} else if (window.parent.jQuery("#salesActivityButton").hasClass('menu-active')){			
			window.parent.jQuery("#salesActivityButton").trigger("click");
		}
		checkProcess = false;
		if(parseInt(activity)==1){	
			objectTable = '#activityTable';
			window.parent.jQuery("#salesActivityButton").trigger("click");
		} else if(parseInt(activity)==2){
			objectTable = '#aquisitionTable';
			window.parent.jQuery("#acquisitionActivityButton").trigger("click");
		}
		if(typeof companyID!='undefined' && objectTable!=""){
			console.log("I am in obj");
			/*intervalCheck = setInterval(function(){
				clickA=0;			
				if(checkProcess===false){
					console.log("In Process:"+objectTable);
					if(window.parent.jQuery("#sales_acititity").hasClass('show')===false){
						window.parent.jQuery("#sales_acititity").addClass('show').removeClass('hide');
						window.parent.jQuery(objectTable).addClass('show').removeClass('hide');
					}
					if(window.parent.jQuery(objectTable).find('tbody.main_active').find('tr.master[data-c="'+companyID+'"]').length>0){					
						console.log("Entered into");
						checkProcess = true;
						console.log("Check Process: "+checkProcess);
						window.parent.jQuery(objectTable).find('tbody.main_active').find('tr.master[data-c="'+companyID+'"]').next().toggle();
						if(_id>0){
							console.log("I am in email ID");
							window.parent.jQuery(objectTable).find('tbody.main_active').find('tr.master[data-c="'+companyID+'"]').find('a[data-tr="'+_id+'"]').parent().addClass('active');		
							if(window.parent.jQuery(objectTable).find('tbody.main_active').find('tr.master[data-c="'+companyID+'"]').find('a[data-tr="'+_id+'"]').parent().hasClass('active')){
								clickA=1;
								window.parent.jQuery(objectTable).find('tbody.main_active').find('tr.master[data-c="'+companyID+'"]').find('a[data-tr="'+_id+'"]').trigger('click');
													
							}
							window.parent.jQuery(objectTable).find('tbody.main_active').find('tr.master[data-c="'+companyID+'"]').next().find('td').find('table>tbody>tr').find('div.sales-activity-notes').find('a[data-tr="'+_id+'"]').parent().addClass('active');
							if(clickA==0 && window.parent.jQuery(objectTable).find('tbody.main_active').find('tr.master[data-c="'+companyID+'"]').next().find('td').find('table>tbody>tr').find('div.sales-activity-notes').find('a[data-tr="'+_id+'"]').parent().hasClass('active')){
								window.parent.jQuery(objectTable).find('tbody.main_active').find('tr.master[data-c="'+companyID+'"]').next().find('td').find('table>tbody>tr').find('div.sales-activity-notes').find('a[data-tr="'+_id+'"]').trigger('click');
								
							}	
							clearInterval(intervalCheck);							
						} else {
							console.log("I am in email href");
							window.parent.jQuery(objectTable).find('tbody.main_active').find('tr.master[data-c="'+companyID+'"]').find('a[data-message_id="'+_href+'"]').trigger('click');
							clearInterval(intervalCheck);
						}
					}
				}				
			},3000);*/
		}
	} else {
		alert("Please load lead first into lead table");
		setTimeout(function(){
			window.parent.closeSlideBarLeftMessage();
		});
		return false;
	}
}
</script>