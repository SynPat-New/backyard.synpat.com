<input type="email" style='position:absolute;left:-9999px;'/>
<input type="password" style='position:absolute;left:-9999px;'/>
<style>
   body {
	overflow: auto !important;
	overflow-x: hidden !important;
	min-width: 0;
	width: 100% !important;
}

    #page-content {
        padding: 0;
		background:#fff;
    }
	.form-horizontal>.form-group{
		margin-left:0px;margin-right:0px;
	}


	/** Tables */
	.textarea-wrapper {
		position: relative;
	}
	#timelineDataTable textarea.form-control {
		border: #dfe8f1 solid 1px;
		box-shadow: none;
		display: block;
		height: 25px;
		left: 0;
		line-height: 1.4;
		min-height: 25px;
		overflow: hidden !important;
		padding: 3px;
		position: absolute;
		top: 0;
		width: 100%;
	}
	.textarea-content {  
		border: #dfe8f1 solid 1px;
		min-height: 26px;
		padding: 3px;
		/*display: none;*/
	}
	#userPassword,#userConfirmPassword{width:70px!important;}
    
	.ui-datepicker {
		width: 200px;
	}
	.ui-datepicker td.ui-datepicker-today a{
		color:#fff;
		background:#3071a9;
		border-color:#204d74;
	}

	/** Print styles */
	@media print {
		#frmUserTimeLog > .row,
		#frmUserTimeLog > .col-lg-12 {
			display: none !important;
		}
		.timeline-wrapper-inner {
			width: 100% !important;
		}
		.timeline-wrapper-inner + .pull-right {
			display: none !important;
		}

		.dataTables_scrollHead {
			display: none !important;
		}
		.dataTables_scrollBody {
			border-top: solid 1px #d1c8c8 !important;
			height: auto !important;
			overflow: visible !important;
		}
		.dataTables_scrollBody thead tr,
		.dataTables_scrollBody thead th {
			height: auto !important;
		}
		.dataTables_scrollBody thead th div {
			font-weight: bold !important;
			height: auto !important;
			padding-top: 5px !important;
			padding-bottom: 5px !important;
		}

		.dataTables_info {
			display: none !important;
		}

		#timelineDataTable textarea.form-control {
			display: none;
		}
		.textarea-content {
			border: none;
			/*display: block;*/
			min-height: 0;
			padding: 0;
		}
	}
	.form-flat .form-group{margin-bottom:0px;}
	.form-flat .form-group.input-string-group{margin-left:10px;}
</style>
<script>
function findUserTimeLog(o){
	if(o.val()!=""){
		/*document.getElementById('frmUserTimeLog').submit();*/
	}
}
var updateLogs=[];function saveFlagUpdate(a){if(jQuery.inArray(a,updateLogs)=="-1"){updateLogs.push(a);updateLogData(a)}else{updateLogData(a)}}function updateLogData(a){_aH=jQuery("#actualHrs"+a).val();_c=jQuery("#comment"+a).val();jQuery.ajax({url:"<?php echo $Layout->baseUrl;?>users/updateLogHr",type:"POST",data:{i:a,ah:_aH,c:_c},cache:false,success:function(b){if(b!="0"){jQuery("#"+a).find("td").eq(6).html(b)}}})}



window.resizeDataTable = function(height) {
	console.log("profile page","Height",height);
	setTimeout(function(){
		console.log("profile page assign","Height",height);
		jQuery('#timelineDataTable_wrapper .dataTables_scrollBody').height(height);
	},100);	
}

jQuery(document).ready(function(){
	/*window.parent.myProfileResize();*/
	window.parent.changeIframeHeight(jQuery("#myprofile"));
	$(".is-date").datepicker({dateFormat:"yy-mm-dd"});
	window.parent.jQuery("#user_mobile_number").val('<?php echo $userData->phone_number?>')

	jQuery('#timelineDataTable textarea.form-control').each(function(index, textarea) {
		checkTexareaHeight(jQuery(textarea));
	});
	jQuery('#timelineDataTable textarea.form-control').on('keyup blur', function() {
		var $this = jQuery(this),
			$textareaContent = $this.next();

		if($textareaContent.length && $textareaContent.hasClass('textarea-content')) {
			$textareaContent.html($this.val().replace(/\n/g, '<br>'));
		}

		checkTexareaHeight($this);
	});
	setTimeout(function(){
		jQuery("#profileFormFields").css('display','');
		
	},1000);
	

	function checkTexareaHeight($textarea) {
		// var lines = $textarea.val().split('\n'),
		// 	height = 25;

		// if(lines.length) {
		// 	height = 8 + lines.length * 18;
		// }
		var $textareaContent = $textarea.next();

		if($textareaContent.length && $textareaContent.hasClass('textarea-content')) {
			$textarea.outerHeight($textareaContent.outerHeight());
		}

	}
});
window.timeAct=[];
</script>


<div class="col-xs-12">

 <div class="timeline-wrapper col-lg-12"  id='timeLineWrapper'> <div class="row"> <div class="col-lg-12">  <div class="timeline-wrapper-inner" style='height:440px;width:100%;float:left'> 
 <?php 
	$getMyLogTime = array();
	if($post==1){
		if($this->session->userdata['type']!=9):
			$user_id = $this->session->userdata['id'];
		endif;
		$getMyLogTime = getMyLogTime($user_id,$from,$to,$lead,$activity_type);
	} else {
		$getMyLogTime = getMyLogTime($this->session->userdata['id'],date('Y').'-'.date('m').'-01',date('Y-m-d'),0);
	}
	echo form_open_multipart('users/profile',array('class'=>'form-horizontal','role'=>'form','id'=>'frmUserTimeLog','autocomplete'=>"off"));
?>

									<div class="row form-flat"> 
										<div style="float:left;width:150px;">
											<?php 
												$users = getAllUsersIncAdmin();
											?>
											<select class='form-control' name="profile[selected_user]" id="selectedUser" onchange="findUserTimeLog(jQuery(this))">
												<option>--Select User--</option> 
												<?php 
													if(count($users)>0){
														if($this->session->userdata['type']==9)
														foreach($users as $user){
												?> 
												<option value="<?php echo $user->id?>" <?php if($user_id==$user->id):?> selected='selected' <?php endif;?>>
												<?php echo $user->name?>
												</option> 
												<?php
														}else{
																if($this->session->userdata['id']>0):
												?> 
												<option value="<?php echo $this->session->userdata['id']?>" selected='selected'>
												<?php echo $this->session->userdata['name'];?>
												</option> 
												<?php
															endif;
														}
													}
												?> 
											</select>
										</div>
										<div style="float:left;width:120px;">
											<div class="form-group input-string-group" style="margin-left:10px;">
												<label for="profileInfoFrom" class="control-label">From:</label>
												<input type="text" autocomplete="false" value='<?php echo $from?>' name="profile[from]" id="profileInfoFrom" class="form-control is-date">
											</div>
										</div>
										<div style="float:left;width:120px;">
											<div class="form-group input-string-group">
												<label for="profileInfoEnd" class="control-label">End:</label>
												<input type="text" autocomplete="false" value='<?php echo $to?>' name="profile[end]" id="profileInfoEnd" class="form-control is-date">
											</div>
										</div>
										<div style="float:left;width:140px;">
											<div class="form-group input-string-group"  style='border:0px !important;'>
												<select name="profile[lead]" id="profileLead" class="form-control">
													<option value="0">--Lead --</option>
													<?php 
														$leads = array();
														if($this->session->userdata['type']==9) {
															$leads = findIncompleteANDCompleteList();
														} else {
															$leads = findIncompleteANDCompleteListAccUser($this->session->userdata['id']);
														}														
														if(count($leads)>0){
															foreach($leads as $lea){
																$select = "";
																if($lea->id==$lead){
																	$select = "SELECTED='SELECTED'";
																}
													?>
															<option value="<?php echo $lea->id?>" <?php echo $select;?>><?php echo $lea->lead_name;?></option>
													<?php
															}
														}
													?>
												</select>
											</div>
										</div> 
										<div style="float:left;width:120px;">
											<div class="form-group input-string-group" style='border:0px !important;'>
												<select name="profile[activity_type]" id="profileActivity" class="form-control">
													<option value="0">--Activity --</option>
													<option value="1"> Sales Activity</option>
													<option value="2"> Acquisition Activity</option>
												</select>
											</div>
										</div>
										<div style="float:left;width:80px;">
											<button type="submit" class="btn btn-primary"><i class="glyph-icon icon-search"></i></button>
											<button class="btn btn-primary" onclick="return printTable()"><i class="glyph-icon icon-print"></i></button>
										</div>
									</div>
									<div class="col-lg-12 mrg10T">
										<div class="row form-flat">
											<div class="col-xs-5" style='margin-top:7px;width:390px;'>
												<label style='margin-right:10px;'>This month: <?php echo ($getMyLogTime['totalHoursCurrent']->totalHrsWorked!=null)?substr($getMyLogTime['totalHoursCurrent']->totalHrsWorked,0,-3):'';?></label>
												<label style='margin-right:10px;'>
													Previous month: <?php echo ($getMyLogTime['totalHours']->totalHrsWorked!=null)?substr($getMyLogTime['totalHours']->totalHrsWorked,0,-3):'';?>
												</label>
												<label>
													This query: <?php echo ($getMyLogTime['resultHours']->totalRowHours!=null)?substr($getMyLogTime['resultHours']->totalRowHours,0,-3):'';?>
												</label>
											</div>
											<div class="col-xs-7 float-right" style="width:450px;">
												<div style="width:100%;float:right;display:none" id="profileFormFields">
													<div style="width:30px;float:right;">
														<input type='hidden' name='user[token]' value='<?php echo $userData->id;?>' />
														<button name="btnSubmit" type='button' class="btn btn-primary float-right" onclick="updateProfile()"><i class="glyph-icon icon-save"></i></button>
													</div>
													<div style="width:200px;float:right;">
														<div class="form-group input-string-group">
															<label class="control-label">Confirm Password:</label>
															<input type='password' autocomplete="new-password" class='form-control input-string profile' name='user[confirm_password]' id="userConfirmPassword"/> 
														</div>	
													</div>
													<div style="width:182px;float:right;">
														<div class="form-group input-string-group">
															<label class="control-label">New Password:</label>
															<input type='password' autocomplete="new-password" class='form-control input-string profile' name='user[password]' id="userPassword"/> 
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									 <?php 
										   
										if(count($getMyLogTime['all_work'])>0){
									?>
									<table id="timelineDataTable" class='table dataTable no-footer' style='width:100%!important'>
									<thead> 
										<tr>
											<th>Date</th>
											<th><div style="width:45px;">Start</div></th>
											<th><div style="width:45px;">End</div></th>
											<th><div style="width:65px;">Duration</div></th>
											<th><div style="width:100px;">Leads</div></th>
											<th><div style="width:100px;">Type</div></th>
											<th><div style="width:100px;">Activites</div></th>
											<th><div style="width:90px;">Adjustments</div></th>
											<th><div style="width:80px;">Total Time</div></th>
											<th>Comment</th>
										</tr>
									</thead>
									<tbody> <?php
										for($i=0;$i<count($getMyLogTime['all_work']);$i++){
											$logoutTime = date('H:i',strtotime($getMyLogTime['all_work'][$i]->logout_date));
									?> <tr id="<?php echo $getMyLogTime['all_work'][$i]->id;?>"> <td><div style="white-space:nowrap;"><?php echo date('M d,Y',strtotime($getMyLogTime['all_work'][$i]->login_date))?></div> 
									</td> <td><?php echo date('H:i',strtotime($getMyLogTime['all_work'][$i]->login_date));?></td> <td><?php echo $logoutTime;?></td> <td><?php
									$logoutDate = date('H:i',strtotime($getMyLogTime['all_work'][$i]->logout_date));
									if($logoutDate!='00:00'){echo substr($getMyLogTime['all_work'][$i]->hrsWorked,0,-3);}
									?></td>
									<?php 
										$leadType = "";
									?>
									<td> <?php 
													if((int)$getMyLogTime['all_work'][$i]->lead_id>0){
														$getLeadDetail = getLeadDetail($getMyLogTime['all_work'][$i]->lead_id);
														if(count($getLeadDetail)>0){
															$leadType = $getLeadDetail->type;
															echo $getLeadDetail->lead_name;
														}
													}
												?> </td> 
									<td><?php echo $leadType;?></td>
									<td>
									<?php 											
											if(count($getMyLogTime['all_work'][$i]->activities_record)>0):
												$activityTow = $getMyLogTime['all_work'][$i]->activities_record;
												$activityString='';
												for($a=0;$a<count($activityTow);$a++){												
													$activityString .= $activityTow[$a]->message.', ';
												}	
												echo substr($activityString,0,-2);
										 endif;?>
									</td>
									<td>
									<select  id="actualHrs<?php echo $getMyLogTime['all_work'][$i]->id;?>" style='width:73px' onchange="saveFlagUpdate(<?php echo $getMyLogTime['all_work'][$i]->id;?>)">
									<option value="">-- Adjust. --</option>
									<option value="-00:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-00:15")?'SELECTED="SELECTED"':'';?>>-00:15</option>
									<option value="-00:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-00:30")?'SELECTED="SELECTED"':'';?>>-00:30</option>
									<option value="-00:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-00:45")?'SELECTED="SELECTED"':'';?>>-00:45</option>
									<option value="-01:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-01:00")?'SELECTED="SELECTED"':'';?>>-01:00</option>
									<option value="-01:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-01:15")?'SELECTED="SELECTED"':'';?>>-01:15</option>
									<option value="-01:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-01:30")?'SELECTED="SELECTED"':'';?>>-01:30</option>
									<option value="-01:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-01:45")?'SELECTED="SELECTED"':'';?>>-01:45</option>
									<option value="-02:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-02:00")?'SELECTED="SELECTED"':'';?>>-02:00</option>
									<option value="-02:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-02:15")?'SELECTED="SELECTED"':'';?>>-02:15</option>
									<option value="-02:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-02:30")?'SELECTED="SELECTED"':'';?>>-02:30</option>
									<option value="-02:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-02:45")?'SELECTED="SELECTED"':'';?>>-02:45</option>
									<option value="-03:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-03:00")?'SELECTED="SELECTED"':'';?>>-03:00</option>
									<option value="-03:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-03:15")?'SELECTED="SELECTED"':'';?>>-03:15</option>
									<option value="-03:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-03:30")?'SELECTED="SELECTED"':'';?>>-03:30</option>
									<option value="-03:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-03:45")?'SELECTED="SELECTED"':'';?>>-03:45</option>
									<option value="-04:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-04:00")?'SELECTED="SELECTED"':'';?>>-04:00</option>
									<option value="-04:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-04:15")?'SELECTED="SELECTED"':'';?>>-04:15</option>
									<option value="-04:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-04:30")?'SELECTED="SELECTED"':'';?>>-04:30</option>
									<option value="-04:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-04:45")?'SELECTED="SELECTED"':'';?>>-04:45</option>
									<option value="-05:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-05:00")?'SELECTED="SELECTED"':'';?>>-05:00</option>
									<option value="00:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="00:15")?'SELECTED="SELECTED"':'';?>>00:15</option>
									<option value="00:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="00:30")?'SELECTED="SELECTED"':'';?>>00:30</option>
									<option value="00:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="00:45")?'SELECTED="SELECTED"':'';?>>00:45</option> 
									<option value="01:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="01:00")?'SELECTED="SELECTED"':'';?>>01:00</option>
									<option value="01:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="01:15")?'SELECTED="SELECTED"':'';?>>01:15</option>
									<option value="01:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="01:30")?'SELECTED="SELECTED"':'';?>>01:30</option> 
									<option value="01:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="01:45")?'SELECTED="SELECTED"':'';?>>01:45</option>
									<option value="02:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="02:00")?'SELECTED="SELECTED"':'';?>>02:00</option> 
									<option value="02:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="02:15")?'SELECTED="SELECTED"':'';?>>02:15</option>
									<option value="02:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="02:30")?'SELECTED="SELECTED"':'';?>>02:30</option>
									<option value="02:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="02:45")?'SELECTED="SELECTED"':'';?>>02:45</option>
									<option value="03:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="03:00")?'SELECTED="SELECTED"':'';?>>03:00</option>
									<option value="03:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="03:15")?'SELECTED="SELECTED"':'';?>>03:15</option>
									<option value="03:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="03:30")?'SELECTED="SELECTED"':'';?>>03:30</option>
									<option value="03:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="03:45")?'SELECTED="SELECTED"':'';?>>03:45</option>
									<option value="04:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="04:00")?'SELECTED="SELECTED"':'';?>>04:00</option> 
									<option value="04:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="04:15")?'SELECTED="SELECTED"':'';?>>04:15</option>
									<option value="04:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="04:30")?'SELECTED="SELECTED"':'';?>>04:30</option>
									<option value="04:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="04:45")?'SELECTED="SELECTED"':'';?>>04:45</option> 
									<option value="05:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="05:00")?'SELECTED="SELECTED"':'';?>>05:00</option>
									</select> 
									</td> 
									<td> <?php
													$duration = $getMyLogTime['all_work'][$i]->hrsWorked;
													$adjustedlHrs = $getMyLogTime['all_work'][$i]->actual_hrs;
													if(!empty($adjustedlHrs)){
														$adjustedlHrs = $adjustedlHrs.":00";
													}
													$totalHrs = $duration;
													if($duration!='' && $duration!='00:00:00'){
														$d = strtotime($duration);
														$lengthOfAdjustedHrs = strlen($adjustedlHrs);
														if($lengthOfAdjustedHrs==9){
															list($h,$m,$s) = explode(':',$adjustedlHrs);
															$totalHrs = date('H:i:s',strtotime("-".$h." hour  -".$m." minutes",$d));
														} else if($lengthOfAdjustedHrs==8){
															list($h,$m,$s) = explode(':',$adjustedlHrs);
															$totalHrs = date('H:i:s',strtotime("+".$h." hour  +".$m." minutes",$d));
														}
													} else{
														$lengthOfAdjustedHrs = strlen($adjustedlHrs);
														if($lengthOfAdjustedHrs==9 || $lengthOfAdjustedHrs==8){
															$totalHrs = $adjustedlHrs;
														}
													}
													echo ($logoutTime!="00:00")? substr($totalHrs,0,-3):'';
												?> </td>
												
									<td style='width:430px'>
										<div class="textarea-wrapper">
											<textarea class='form-control' onchange="saveFlagUpdate(<?php echo $getMyLogTime['all_work'][$i]->id;?>)" placeholder="Comment" name="comment<?php echo $getMyLogTime['all_work'][$i]->id;?>" id="comment<?php echo $getMyLogTime['all_work'][$i]->id;?>"><?php echo $getMyLogTime['all_work'][$i]->comment?></textarea>
											<div class="textarea-content"><?php echo str_replace("\n", '<br>', $getMyLogTime['all_work'][$i]->comment);?></div>
										</div>
									</td>
								</tr> <?php
										}
									?> </tbody> </table> 
<script>
	var timelineDataTable=$("#timelineDataTable").DataTable({
		// autoWidth:true,
		paging:false,
		searching:false,
		scrollY:'715px',
		order:[[0,"desc"]]
		// aoColumns: [
	 //      	{ "sWidth": "90px" },
	 //      	{ "sWidth": "55px" },
	 //      	{ "sWidth": "55px" },
	 //      	{ "sWidth": "80px" },
	 //      	{ "sWidth": "100px" },
	 //      	{ "sWidth": "80px" },
	 //      	{ "sWidth": "80px" }
	 //    ]
	});

	var _windowResizeTimeout = null;
	$(window).on('resize', function() {
		clearTimeout(_windowResizeTimeout);
		_windowResizeTimeout = setTimeout(function() {
			resizeTimelineTable();
		}, 200);
	});
	function resizeTimelineTable() {
		// console.log(new Date().getTime());
		$('.dataTables_scrollHeadInner thead th:first-child').trigger('click');
		setTimeout(function() {
			$('.dataTables_scrollHeadInner thead th:first-child').trigger('click');
		}, 100);
	}
	function printTable() {
		window.print();
		return false;
	}
	 _first = 0;
	function findActivty(){
		jQuery("#activityPopup").modal("show");
		if($("#activity").length>0 && _first==0){
			$("#activity").DataTable({
				// autoWidth:true,
				paging:false,
				searching:false,
				scrollY:'300px',
				initComplete:function(){
					
				}
			});
			jQuery("#activityPopup").on('shown.bs.modal',function(){
				jQuery("#activity_wrapper").find('.dataTables_scrollHeadInner').find('table').find('th').eq(0).trigger("click");
			})
			_first = 1;
		}
		
	}
	
</script> 

									<?php
										}
									?> 
									
									
									<div class="col-lg-12" style='border-top:1px solid #d1c8c8;width:99%'></div><?php echo form_close();?> </div> 
									</div> </div>
									
									</div> </div>  


<div class="modal modal-opened-header fade" id="activityPopup" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:50%;z-index:999999"><div class="modal-dialog" style=''><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-9px;margin-right:-5px"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">
<?php 
	if($post==1){
		$userActivity = getUserTimeLineWithSearch($user_id,$from,$to,$lead);
		if(count($userActivity)>0){
	?>
			<table class='table table-bordered' id="activity" style='width:100%'>
				<thead>
					<tr>
						<th>Lead Name</th>
						<th>User</th>
						<th>Activity</th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($userActivity as $activity){
					?>
					<tr>
						<td><?php echo $activity->lead_name?></td>
						<td><?php echo $activity->name?></td>
						<td><?php echo $activity->message?></td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
	<?php
		}
	}
?>

</div><div class="modal-footer"></div></div></div></div><script>
jQuery(document).ready(function(){
	$("#userPhoneNumber,#userMobileNumber,#userEmailForSignature").on('change keydown paste input', function(){
          changeUserSignature();
     });
});
	function changeUserSignature(){	
		_string = jQuery("#original_signature").val();
		_name = jQuery("#userName").val();
		_phone = jQuery("#userMobileNumber").val();
		_direct = jQuery("#userDirectNumber").val();
		_email = jQuery("#userEmailForSignature").val();
		_title = jQuery("#userTitle").val();
		_string = _string.replace("#Name#",_name);
		if(_phone!=""){
			_string = _string.replace("#Mobile#",'M: '+_phone);
		} else {
			_string = _string.replace("#Mobile#",'');
		}
		if(_direct!=""){
			_string = _string.replace("#Direct#",'D: '+_direct);
		} else {
			_string = _string.replace("#Direct#",'');
		}
		_string = _string.replace("#Email#",_email);
		_string = _string.replace("#Title#",_title);
		jQuery("#your_signatue").html(_string);
	}
	function updateSignature(){
		//window.parent.jQuery('#original_signature').val(jQuery("#your_signatue").html());
		//window.parent.jQuery('#emailMessage').code(jQuery("#your_signatue").val());
	}
	function updateProfile() {
		/*users/update*/
		jQuery.ajax({
			type:'POST',
			url:"<?php echo $Layout->baseUrl;?>users/update",
			data:jQuery('.profile').serializeArray(),
			cache:false
		}).always(function(){
			window.location = window.location.href;
		});
	}
	</script>