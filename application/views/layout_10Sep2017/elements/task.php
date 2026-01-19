<?php 
	$openTask = true;
	if((int)$this->session->userdata['type']!=9){  
		if(!in_array(6,$this->session->userdata['modules_assign'])){
			$openTask = false;
		}
	}
	if($openTask===true):
?>

<style>
	#task_list,
	#my_c_task_list {
		display: none !important;
	}

	#task_list .dashboard-box, #my_c_task_list .dashboard-box {
		overflow-y: auto !important;
	}
	.modal.modal-opened-header, .modal{margin-top:78px !important}
</style>
<div class="col-md-2 col-sm-2 col-xs-2 hide" id="my_c_task_list" >
</div>
<div class="col-md-2 col-sm-2 col-xs-2" id="task_list" >
<?php 
    $checkLead = $this->uri->segment(3);
	if((int)$this->session->userdata['type']!=9){
	$pageAssigned = getUserPageAssigned();
	$litigationCreate = 0; 
	$marketCreate = 0;
	if(count($pageAssigned)>0){		
		foreach($pageAssigned as $page){
			if($page->page_url=='leads/litigation'){
				$litigationCreate = 1;
			}
			if($page->page_url=='leads/market'){
				$marketCreate = 1;
			}
		}
	}
	/*if($litigationCreate>0){
		$checkTask = checkUserCreatedLeadFromLitigation();
		if((int)$checkTask->leads==0 || (int)$checkTask->leads<3){
			$checkApprovalSend = checkApprovalSend();
			if((int)$checkApprovalSend->sendTask==0){
				$allAdminUsers = findAdminUsers();
				if(count($allAdminUsers)>0){
					$getData = getTaskAccToType("LEAD");
					$subject="Create leads for this week";
					$message = "You have to create 3 leads per week.";
					if(count($getData)>0){
						$subject = $getData->subject;
						$message = $getData->message;
					}
					$requestArray = array('lead_id'=>0,'user_id'=>$this->session->userdata['id'],'parent_id'=>0,'subject'=>$subject,'message'=>$message,'from_user_id'=>$allAdminUsers[0]->id,'doc_url'=>$Layout->baseUrl."leads/litigation","execution_date"=>date('Y-m-d'),"type"=>"LEAD","status"=>0);
					sendApprovalRequest($requestArray);
				}				
			}			
		}
	}*/	
}
	$waiting_approval = getUserTaskList();
	
?>
<script>
___taskICreated="";
___taskCreatedFor="";
__dashFlag = true;
<?php if((int)$this->session->userdata['user']['type']==9 || in_array(5,$this->session->userdata['modules_assign'])):?>
/*setInterval(callnotification,300000); */
<?php endif;?>
<?php if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):?>
/*setInterval(licensesEmails,600000); */
<?php endif;?>
window.imbedCount= function(data,textStatus,xhr){
	jQuery('#licenses_emails').find('span').html(data);
}
function licensesEmails(){
	data = {};
	call(__baseUrl+'users/countUnseenMeesagesImap','GET',data,imbedCount,'text');
}
_UserProfile ='<?php echo $this->session->userdata['profile_pic']?>';
	$(document).ready(function() {		
			runExpandCollapse();
	});

	$(window).on('resize', function() {
		var height = $(window).height() - 130;
		$('#tasksICreatedSlidebarTable_wrapper .dataTables_scrollBody').height(height);
		$('#tasksCreatedForMeSlidebarTable_wrapper .dataTables_scrollBody').height(height);
	});
setInterval(getLoggedTime,600000);
function callnotification(){
	<?php if((int)$this->session->userdata['user']['type']==9 || in_array(5,$this->session->userdata['modules_assign'])):?>
	jQuery.ajax({
		type:'POST',
		url:'<?php echo $this->config->base_url()?>dashboard/callnotification',
		data:{f:__dashFlag,l:leadGlobal},
		cache:false,
		success:function(data){
			_data = jQuery.parseJSON(data);	
			if(_data.taskCount>0){
				if(jQuery("#task-btn").find('span').length>0){
					jQuery("#task-btn").find('span').html(_data.taskCount);
				} else {
					jQuery("#task-btn").append("<span style='color:#d9534f;font-weight:bold;font-size:15px;'>"+_data.taskCount+"</span>");
				}
			}else {
				jQuery("#task-btn").find('span').html('0');								
			}	
			if(_data.taskICount>0){
				if(jQuery("#task-i-btn").find('span').length>0){
					jQuery("#task-i-btn").find('span').html(_data.taskICount);
				} else {
					jQuery("#task-i-btn").append("<span style='color:#d9534f;font-weight:bold;font-size:15px;'>"+_data.taskICount+"</span>");
				}
			}else {
				jQuery("#task-i-btn").find('span').html('0');								
			}		
			if(_data.countReceieve>0){
				if(jQuery("#btn-notify-user").find('span').length>0){
					jQuery("#btn-notify-user").find('span').html(_data.countReceieve);
				} else {
					jQuery("#btn-notify-user").append("<span class='' style='color:#d9534f;font-weight:bold;font-size:15px;'>"+_data.countReceieve+"</span>");
				}
			}else {
				jQuery("#btn-notify-user").find('span').html('0');								
			}	
			if(_data.countSend>0){
				if(jQuery("#btn-my-notify-user").find('span').length>0){
					jQuery("#btn-my-notify-user").find('span').html(_data.countSend);
				} else {
					jQuery("#btn-my-notify-user").append("<span class='' style='color:#d9534f;font-weight:bold;font-size:15px;'>"+_data.countSend+"</span>");
				}
			}else {
				jQuery("#btn-my-notify-user").find('span').html('0');								
			}	
			runExpandCollapse();
		}
	});
	<?php endif;?>
}

function getLoggedTime(){
	jQuery.ajax({
		type:'GET',
		url:'<?php echo $Layout->baseUrl?>dashboard/m_time',
		cache:false,
		success:function(data){
			jQuery("#nc_t").html("("+data+")");
		}
	});
}

_allParent = "";
function enterData(t,ID){
	if(t==1){
		jQuery('.other_damages').css('display','none');
		jQuery('.other_docs').css('display','none');
		jQuery("#otherDamages_"+ID).css('display','block');
	} else if(t==2){
		jQuery('.other_docs').css('display','none');
		jQuery('.other_damages').css('display','none');
		jQuery("#otherDOCS_"+ID).css('display','block');
	}
}
	function approvedFile(token,o){
		if(token!="" && token>0){
			var lead_url = "";
			var refreshParent = $("#sb-site");
			var loaderTheme = "bg-default";
			var loaderOpacity = "60";
			var loaderStyle = "dark";
			var loader = 
				'<div id="refresh-overlay" class="ui-front loader ui-widget-overlay ' + loaderTheme + ' opacity-' + loaderOpacity + '">' +
					'<div class="loading-spinner is-window">' +
						'<img src="<?php echo $Layout->aws_server_cdn;?>images/ajax-loader.gif" alt="">' +
					'</div>' +
				'</div>';
			if ( $('#refresh-overlay').length ) {
				$('#refresh-overlay').remove();
			}
			$(refreshParent).append(loader);
			$('#refresh-overlay').fadeIn('fast');
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl?>opportunity/find_task',
				data:{token:token},
				cache:false,
				success:function(res){					
					_data = jQuery.parseJSON(res);
					_allParent = _data;
					$('#refresh-overlay').fadeOut('fast');
					$('.glyph-icon', this).removeClass('icon-spin');
					if(_data!=undefined){						
						if (_data.hasOwnProperty('type')) {
							if(parseInt(_data.userType)==9 && _data.approved_type=='LEAD'){
								jQuery("#replyFromUser").html("Admin");
							} else {
								jQuery("#replyFromUser").html(_data.userName);
							}					
							jQuery("#replyToUser").html(_data.toUserName);							
							jQuery("#replyReceived").html(moment(new Date(_data.receivedData+' 00:00:00')).format('MMM D, YY'));
							
							jQuery("#replySubject").html(_data.subject);
							jQuery("#replyInputSubject").val(_data.subject);
							if(_data.doc_url!=""){
								jQuery("#replyLink").html("<a target='_BLANK' style='color:#3498db;' href='"+_data.doc_url+"'>Document Link</a>");
							} else {
								jQuery("#replyLink").html("No docs");
							}							
							__message = _data.message;
							_executionDate = "";
							if(_data.executionDate!=null && _data.executionDate!='0000-00-00'){
								_executionDate = moment(new Date(_data.executionDate+' 00:00:00')).format('MMM D, YY');
							}
							/*My Task*/
							if(_data.fromUserID==_CS){
								jQuery("#my_own_task").css('display','');
								jQuery("#other_user_task").css('display','none');
								jQuery("#mytaskSubject").val(_data.subject);
								jQuery("#mytaskTouser").val(_data.toUserID);
								jQuery("#mytaskDocUrl").val(_data.doc_url);
								jQuery("#mytaskMessage").val(__message);
								jQuery("#mytaskExecutionDate").val(_data.executionDate);
							} else{
								jQuery("#my_own_task").css('display','none');
								jQuery("#other_user_task").css('display','');
							}
							
							/*jQuery("#mytaskSendEmail").val(_executionDate);*/							
							/*End My Task*/
							if(_data.fromUserID!=_CS){
								if(_data.hasOwnProperty('parents') && _data.parents.length>0){
									for(i=0;i<_data.parents.length;i++){
										_pa = _data.parents[i];
										__message += "<br/><hr/>FROM: "+_pa.userName+"<br/>"+_pa.message;
									}
								}						
								jQuery("#ticket__body p").html(__message);
								jQuery("#send_task_message").css('display','');
							} else {
								jQuery("#send_task_message").css('display','none');
							}
							if(_data.emailID>0){
								jQuery("#emailMain").css('display','');
								jQuery("#emailLink").html('<a href="javascript://" onclick="findOwnThread('+_data.emailID+',jQuery(this),5);">Email</a>');
							} else {
								jQuery("#emailLink").html('');
								jQuery("#emailMain").css('display','none');
							}
							
							
														
							jQuery("#replyExecutionDate").html(_executionDate);
							jQuery("#replyLeadId").val(_data.id);
							_leadName = "";
							if(_data.lead_name!="" && _data.lead_name!=null){
								_leadName = _data.lead_name;
							} else if(_data.plantiffs_name!="" && _data.plantiffs_name!=null){
								_leadName = _data.plantiffs_name;
							}
                            /*
							lead_url = "<?php echo $Layout->baseUrl; ?>dashboard/index/"+_data.id;
							*/
                            /*jQuery("#replyTaskModalLabel").html("<a href='"+lead_url+"'>"+_leadName.toUpperCase()+' S/N '+_data.serial_number+"</a>");*/
							_a = jQuery("<a/>").append(_leadName.toUpperCase()+' S/N '+_data.serial_number).attr('href','javascript://').click(function(e){
								if(jQuery("#tasksICreated").hasClass("is-open")){
									closeSlideBarTasksICreated()
								}
								if(jQuery("#tasksCreatedForMe").hasClass("is-open")){
									closeSlideBarTasksCreatedForMe()
								}
								jQuery('#replyTaskModal').modal('hide');
								threadDetail(jQuery("#all_type_list").find("tbody").find('tr[data-id="'+_data.id+'"]'));
								return false;
							});
                            jQuery("#replyTaskModalLabel").empty().append(_a);
            				jQuery("#replyParentId").val(_data.approved_id);
							jQuery("#replyType").val(_data.approved_type);							
							jQuery("#formOPen").removeAttr('onclick').hide();
							jQuery("#replyForwardTask").show();
							jQuery("#replyCompleteTask").show();
							if(_data.notifyStatus==1){
								jQuery("#replyComplete").attr("checked","checked");
							} else {
								jQuery("#replyComplete").removeAttr("checked");
							}
							if(typeof o!="undefined"){
								jQuery("#deleteTask").css("display","block");
								jQuery("#replyComplete").attr("disabled","disabled");
							} else {
								jQuery("#deleteTask").css("display","none");
								jQuery("#replyComplete").removeAttr("disabled");
							}
							if(_data.approved_type=="OTHER_DOCS"){
								jQuery("#replyForwardTask").hide();
								jQuery("#replyCompleteTask").show();
								jQuery("#formOPen").show();
								jQuery("#formOPen").attr('onclick','enterData(2,'+_data.approved_id+')');
							} else if(_data.approved_type=="ORDER_DAMAGES"){
								jQuery("#formOPen").show();
								jQuery("#formOPen").attr('onclick','enterData(1,'+_data.approved_id+')');
								jQuery("#replyForwardTask").hide();
								jQuery("#replyCompleteTask").show();
							}
							if(_CS!=_data.toUserID && _CS!=_data.user_id){
								jQuery("#replyForwardTask").hide();
								jQuery("#replyCompleteTask").hide();
								jQuery("#replySendEmail").parent().parent().hide();
							}
							
							
							if(_data.id===null){
								jQuery("#replyFlag").val(1);
								jQuery("#replyForwardTask").hide();
							} else {
								jQuery("#replyFlag").val(0);								
							}
							_h = jQuery(window).height()-83;
							jQuery('#replyTaskModal').find('.modal-body').css({height:_h+'px',maxHeight:_h+'px',minHeight:_h+'px'});
							jQuery('#replyTaskModal').modal('show');
							resizeTaslModal()
							messageListCheck();
						} else {
							alert("Please try after sometime");
						}						
					} else {
						alert("Please try after sometime");
					}
				}
			});
		}
	}
	
	function resizeTaslModal(){
		$sideBar = jQuery('#replyTaskModal');
		if (typeof $sideBar!="undefined" && $sideBar.hasClass('ui-resizable')) {
			$sideBar.resizable('destroy');
		}		
        $sideBar.resizable({
            handles: 'e, w',
            resize: function(event, ui) {
                if ($(ui).hasClass('sb-right')) {
                    $(ui).css({
                        left: 'auto',
                        right: 0
                    });
                }
            }
        });    
	}
	
	function goToMainTask(){
		jQuery('#messagTaskModal').modal('hide');
		approvedFile(jQuery("#replyParentId").val());
	}
	function messageListCheck(){
		jQuery("#messageListTask").css('display','block');
		_taskID = jQuery("#replyParentId").val();
		
		if(_taskID>0){
			jQuery("#messageTaskID").val(_taskID);
			jQuery.ajax({
				url:'<?php echo $Layout->baseUrl?>dashboard/task_conversation',
				type:'POST',
				data:{c:_taskID},
				cache:false,
				success:function(data){
					jQuery("#messageListTask").css('display','none');
					_dd = jQuery.parseJSON(data);
					if(_dd.length>0){
						jQuery("#message-inbox-task-list").empty();
						
						for(i=0;i<_dd.length;i++){
							_profilePic = '<?php echo $Layout->aws_server_cdn;?>upload/user.png';
							if(_dd[i].profile_pic!=""){
								_profilePic = _dd[i].profile_pic;
							}
							_string = '<div class="comment">'+
								'<div class="comment_content">'+
									'<div class="meta">'+
										'<a href="#"><img src="'+_profilePic+'" alt="'+_dd[i].fromUserName+'" width="28px"></a>'+
										'<ul class="userinfo" style="width: 92%;">'+
											'<li class="pull-left"><h6><a href="javascript://">'+_dd[i].fromUserName+'</a></h6></li>' +
											'<li class="fright">Posted on '+moment(new Date(_dd[i].create_c)).format('MMM D, YY h:mm')+'</li>'+
										'</ul>'+
									'</div>'+
									'<div id="ticket_'+_dd[i].id+'_body" class="message-inbox-detail">'+
										'<p style="">'+_dd[i].message+'</p>'+
									'</div>'+
								'</div>'+
								'<a id="ticket_'+_dd[i].id+'_body_button" href="" class="message-inbox-toggler"><span></span></a>'+
							'</div>';
							jQuery("#message-inbox-task-list").append(_string);
						}

						runExpandCollapse();
					} else {
						jQuery("#message-inbox-task-list").empty();
					}
				}
			});
		}
	}
	
	function runExpandCollapse(){
		if($('.message-inbox-toggler').length>0){
			$('.message-inbox-toggler').off('click').on('click', function(e) {
				$(this).toggleClass('is-open');
				$(this).parent().find('.message-inbox-detail').toggleClass('is-open');

				return false;
			});
		}
		if($('#expand_collapse_button').length>0){
			$('#expand_collapse_button').off('click').on('click', function() {
				var $this = $(this);

				if(!$this.hasClass('is-open')) {
					$this.parent().parent().find('.message-inbox-detail').addClass('is-open');
					$this.parent().parent().find('.message-inbox-toggler').addClass('is-open');
					$this.addClass('is-open').html('- Collapse All');
				}
				else {
					$this.parent().parent().find('.message-inbox-detail').removeClass('is-open');
					$this.parent().parent().find('.message-inbox-toggler').removeClass('is-open');
					$this.removeClass('is-open').html('+ Expand All');
				}

				return false;
			});
		}		
	}
	/*
	function expand(elid){
		$('#'+elid).slideToggle(600);
		$('#'+elid + '_button' ).removeClass( 'expand' );
		$('#'+elid + '_button' ).addClass( 'collapsee' );
		$('#'+elid + '_button' ).attr('href',$('#'+elid + '_button' ).attr('href').replace( 'expand', 'collapse' ));
	}
	function collapse(elid){
		$('#'+elid).slideToggle(600);
		$('#'+elid + '_button' ).removeClass( 'collapsee' );
		$('#'+elid + '_button' ).addClass( 'expand' );
		$('#'+elid + '_button' ).attr('href',$('#'+elid + '_button' ).attr('href').replace( 'collapse', 'expand' ));
	}
	function collapseAll(){
		$('div[id^=ticket_]').each(function(){
			jQuery(this).slideToggle(600);
			elid = jQuery(this).attr('id');
			$('#'+elid + '_button' ).removeClass( 'collapsee' );
			$('#'+elid + '_button' ).addClass( 'expand' );
			$('#'+elid + '_button' ).attr('href',$('#'+elid + '_button' ).attr('href').replace( 'collapse', 'expand' ));
		});
		$( '#expand_collapse_button' ).attr('href',$( '#expand_collapse_button' ).attr('href').replace( 'collapse', 'expand' ));
		$( '#expand_collapse_button' ).html( '+ Expand All' );
	}
	function expandAll(){
		$('div[id^=ticket_]').each(function(){
			jQuery(this).slideToggle(600);
			elid = jQuery(this).attr('id');
			$('#'+elid + '_button' ).removeClass( 'expand' );
			$('#'+elid + '_button' ).addClass( 'collapsee' );
			$('#'+elid + '_button' ).attr('href',$('#'+elid + '_button' ).attr('href').replace( 'expand', 'collapse' ));
		});
		$( '#expand_collapse_button' ).attr('href',$( '#expand_collapse_button' ).attr('href').replace( 'expand', 'collapse' ));
		$( '#expand_collapse_button' ).html( '- Collapse All' );
	}*/
	
	function removeTaskConversation(){
		_taskID = jQuery("#replyParentId").val();
		if(_taskID>0){
			jQuery("#senTaskConversation").removeAttr('onclick');
			jQuery.ajax({
				url:'<?php echo $Layout->baseUrl?>dashboard/message_task_conversation_remove',
				type:'POST',
				data:{c:_taskID},
				cache:false,
				success:function(){
					jQuery('#messagTaskModal').modal('show');
				}
			});
		}
	}
	
	function sendMessageTaskFor(){
		jQuery("#loading_task_conversation").show();
		if(jQuery("#messageReplyTask").val()!=""){			
			jQuery("#senTaskConversation").removeAttr('onclick');
			_searilise = jQuery("#formTaskConversation,#formReplyTask").serialize();
			jQuery.ajax({
				url:'<?php echo $Layout->baseUrl?>dashboard/message_task_conversation_send',
				type:'POST',
				data:_searilise,
				cache:false,
				success:function(data){
					_data = jQuery.parseJSON(data);
					if(_data.length>0){
						jQuery("#messageConversationTask").val('');
						jQuery("#loading_task_conversation").hide();
						jQuery("#senTaskConversation").attr('onclick','sendMessageTaskFor()');
						jQuery("#message-inbox-task-list").empty();
						for(i=0;i<_data.length;i++){
							_profilePic = '<?php echo $Layout->aws_server_cdn;?>upload/user.png';
							if(_data[i].profile_pic!=""){
								_profilePic = _data[i].profile_pic;
							}
							_string = '<div class="comment">'+
								'<div class="comment_content">'+
									'<div class="meta">'+
										'<a href="javascript://"><img src="'+_profilePic+'" width="28px" alt="'+_data[i].fromUserName+'"></a>'+
										'<ul class="userinfo" style="width: 92%;">'+
											'<li class="pull-left"><h6><a href="javascript://">'+_data[i].fromUserName+'</a></h6></li><li class="fright">Posted on '+moment(new Date(_data[i].create_c)).format('MMM D, YY h:mm')+'</li>'+
										'</ul>'+
									'</div>'+
									'<div id="ticket_'+_data[i].id+'_body" style="overflow: visible; display: none;" class="message-inbox-detail">'+
										'<p style="">'+_data[i].message+'</p>'+
									'</div>'+
								'</div>'+
								'<a id="ticket_'+_data[i].id+'_body_button" href="javascript: expand(\'ticket_'+_data[i].id+'_body\' )" class="expander expand"><span></span></a>'+
							'</div>';
							jQuery("#message-inbox-task-list").append(_string);
						}
						runExpandCollapse();
						callnotification();
					} else {
						jQuery("#loading_task_conversation").hide();
						jQuery("#senTaskConversation").attr('onclick','sendMessageTaskFor()');
						alert("Server busy, Please refresh page");
					}
				}
			});			
		} else {
			jQuery("#loading_task_conversation").hide();
			alert("Please enter message");
			jQuery("#senTaskConversation").attr('onclick','sendMessageTaskFor');
		}
	}
	function forwardEnabled(object){
		if(object.is(':checked')){
			jQuery("#forwardUserTo").show();
			jQuery("#forwardMessageTo").show();
			jQuery("#forwardExecutionDate").show();
			jQuery("#replyButton").html('Forward').show();
			jQuery("#replyCompleteTask").hide();
		} else {
			jQuery("#forwardUserTo").hide();
			jQuery("#forwardMessageTo").hide();
			jQuery("#forwardExecutionDate").hide();
			jQuery("#replyButton").hide();
			jQuery("#replyCompleteTask").show();
		}
	}
	function taskMyComplete(object){
		if(object.is(':checked')){
			jQuery("#replyButton").html('Confirm Removal').show();
			jQuery("#forwardUserTo").hide();
			jQuery("#forwardMessageTo").hide();
			jQuery("#forwardExecutionDate").hide();
		} else{
			jQuery("#replyButton").hide();
			jQuery("#forwardUserTo").hide();
			jQuery("#forwardMessageTo").hide();
			jQuery("#forwardExecutionDate").hide();
		}
	}
	function taskComplete(object){
		if(object.is(':checked')){
			jQuery("#replyButton").html('Confirm Completion').show();
			jQuery("#forwardUserTo").hide();
			jQuery("#forwardMessageTo").hide();
			jQuery("#forwardExecutionDate").hide();
		} else{
			jQuery("#replyButton").hide();
			jQuery("#forwardUserTo").hide();
			jQuery("#forwardMessageTo").hide();
			jQuery("#forwardExecutionDate").hide();
		}
	}
</script>
</div>
<?php endif;?>




<style>
	#tasksICreatedSlidebarTable_wrapper .dataTables_info {
		display: none;
	}
	#tasksCreatedForMeSlidebarTable_wrapper .dataTables_info {
		display: none;
	}
</style>

<div id="tasksICreated" class="sb-slidebar bg-white sb-left sb-style-overlay">
	<div class="sb-slidebar-top-buttons">
		<a href='javascript:void(0)' class="btn" onclick="closeSlideBarTasksICreated()" style='float:right'><i class="glyph-icon icon-close"></i></a>
		<a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarSide(jQuery(this))" style='float:right'><i class="glyph-icon icon-exchange"></i></a>
	</div>
	<h2 class='mrg15L font-black font-size-17 text-center'>Tasks that I Created</h2>
	<div class="pad0A" style='padding-left:5px !important;'></div>
</div>
<div id="tasksCreatedForMe" class="sb-slidebar bg-white sb-left sb-style-overlay">
	<div class="sb-slidebar-top-buttons">
		<a href='javascript:void(0)' class="btn" onclick="closeSlideBarTasksCreatedForMe()" style='float:right'><i class="glyph-icon icon-close"></i></a>
		<a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarSide(jQuery(this))" style='float:right'><i class="glyph-icon icon-exchange"></i></a>
	</div>
	<h2 class='mrg15L font-black font-size-17 text-center'>Tasks Created For Me</h2>
	<div class="pad0A" style='padding-left:5px !important;'></div>
</div>
<div id="voiceMailContainer" class="sb-slidebar bg-white sb-left sb-style-overlay">
	<div class="sb-slidebar-top-buttons">
		<a href='javascript:void(0)' class="btn" onclick="closeSlideBarVoiceMail()" style='float:right'><i class="glyph-icon icon-close"></i></a>
		<a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarSide(jQuery(this))" style='float:right'><i class="glyph-icon icon-exchange"></i></a>
	</div>
	<h2 class='mrg15L font-black font-size-17 text-center'>Voicemail</h2>
	<div class="scrollable-content scrollable-slim-sidebar">
		<div class="pad15A">
			<ul class='todo-box embedVoiceMail'></ul>
		</div>
    </div>
</div>