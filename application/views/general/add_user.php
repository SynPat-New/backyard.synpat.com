<style>
	div.dataTables_filter label {
		float: right;
	}
	div.dataTables_filter input {
	    box-shadow: none;
	    float: left;
	    height: 24px;
	    margin-bottom: 2px;
	    padding-left: 5px;
	    padding-right: 5px;
	}
	#leadTable_info{display:none;}
	th,td{white-space:nowrap;}
	#leadTable_wrapper{margin-top:25px;}
	.ms-container .ms-list{height:230px;}
</style>
<script>
jQuery(document).ready(function(){
	jQuery('.breadcrumb').html("<li><a>General</a></li><li class='active'>Manage User</li>");
});
</script>

<?php 
	$modules = getAllBackyardModules();
?>
<script>
_moduleList = <?php echo json_encode($modules);?>;
</script>
<!--<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/widgets/multi-select/multiselect.css">-->
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn; ?>widgets/multi-select/multiselect.js"></script>
<script type="text/javascript">
    /* Multiselect inputs */
    $(function() { "use strict";
        $(".multi-select").multiSelect();
        $(".ms-container").append('<i class="glyph-icon icon-exchange"></i>');
    });
_pageList = '';
_userList = '';

_leadList = '';
<?php 

	if(count($pages_list)>0):

?>

_pageList = <?php echo json_encode($pages_list);?>;

<?php endif;?>

<?php 

	if(count($leads)>0):

?>

_leadList = <?php echo json_encode($leads);?>;

<?php endif;?>

<?php 

	if(count($users)>0):

?>

_userList = <?php echo json_encode($users);?>;

<?php endif;?>
var _leadTable;
jQuery(document).ready(function(){
	_leadTable = jQuery("#leadTable").DataTable({
		paging: false,
		scrollY:"450px",
		scrollX:false,
		columnDefs: [
		  { targets: 1 }
		],
		searching:false,
	});
});
</script>

<div class="panel dashboard-box" style="border:0px;">
    <div class="panel-body pad0T">
		<div class="example-box-wrapper">
			<!-- <h3 class="title-hero">User Pages Permission</h3> -->
			<!-- <p>Select select user and select multiple page by pressig Ctrl.</p> -->
			<?php 
				if(count($pages_list)==0) {
			?>
			<p class="alert alert-warning">No files found from Master Document of Google Drive. Please upload files in Master document folder and after upload refresh this page.</p>
			<?php
				}
				if($this->session->flashdata('message')) {
					echo $this->session->flashdata('message');
				}
			?>
			
			<div class="row">
				<?php echo form_open('general/user_permissions',array('class'=>"form-horizontal form-flat"));?>
				<div style="width:100%;" class="float-left" id="userSection">
					<h4><span class="selected_user"></span></h4>
					<div style="margin-top:10px;" class="float-left"><a href="javascript://" onclick='jQuery(".selected_user").text("");window.parent.openContactForFrom(27,"user_form");' style="color:#15c"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width:20px;" class="svg-inline--fa fa-user-plus fa-w-20 fa-2x"><path fill="currentColor" d="M224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96zm89.6 256c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zm224-248h-72v-72c0-8.8-7.2-16-16-16h-16c-8.8 0-16 7.2-16 16v72h-72c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h72v72c0 8.8 7.2 16 16 16h16c8.8 0 16-7.2 16-16v-72h72c8.8 0 16-7.2 16-16v-16c0-8.8-7.2-16-16-16z" class=""></path></svg></a></div>
					<div style="width:150px;" class="float-left">						
						<div class="form-group input-string-group select-string-group" style="border:0px !important;">
							<select name="page[user_id]"  class="form-control" onchange="getUserPageList(jQuery(this));">
								<option value="">-- Select User --</option>
								<?php 
									if(count($users)>0){
										foreach($users as $user){
								?>
										<option value="<?php echo $user->id?>"><?php echo ucfirst(strtolower($user->name));?></option>
								<?php
										}
									}
								?>
							</select>
						</div>
					</div>
					<div style="width:120px;" class="float-left">
						<div class="form-group input-string-group select-string-group" style="border:0px !important;margin-right:0px;">
	                        <select name="user[type]" id="userType" class='form-control' style="float:left;">
								<option value="0">--Select Type--</option>
								<option value="1" selected="selected">Flexible</option>
								<option value="2" >Broker</option>
								<option value="3" >Pre Sales</option>
								<option value="8">See everything in front</option>
								<option value="9">Admin</option>
							</select>
		                </div>
					</div>
					<div style="width:120px;" class="float-left">
						<div class="form-group input-string-group select-string-group" style="border:0px !important;">
	                        <select name="user[flag]" id="userFlag" class='form-control'>
								<option value="1">--Select Insider/Outside--</option>
								<option value="1" selected="selected">Insider</option>
								<option value="0">Outsider</option>
							</select>
		                </div>
					</div>
					<div  style="width:120px;" class="float-left">
						<div class="form-group input-string-group">
	                        <input type="text" name="user[password]" placeholder="Password" id="userbPassword" class='form-control' autocomplete="aad" />
		                </div>
					</div>
					<div  style="width:80px;" class="float-left">
						<div class="">
		                    <label class="control-label float-left">Active:</label>
	                        <input type="checkbox" value="0" name="user[active]" id="userActive" class='form-control float-left' style="width:12px;"  />
		                </div>
					</div>
					<div class="float-left" style="width:50px;">
						<button type="submit" class="btn btn-primary"><i class="glyph-icon icon-save"></i></button>
					</div>
					<input type="hidden" name="user[id]" id="userId" value="0"/>
					<input type="hidden" name="user[name]" id="userbName" value="" />
					<input type="hidden" name="user[email]" id="userEmail" value="" />
					<input type="hidden" name="user[title]" id="userTitle" value="" />
					<input type="hidden" name="user[phone_number]" id="userPhone" value="" />
					<input type="hidden" name="user[direct_number]" id="userDirect" value="" />
					<input type="hidden" name="user[ext]" id="userExt" value="" />
					<input type="hidden" name="user[email_for_signature]" id="userEmailForSignature" value=""/>
					<input type="hidden" name="user[mobile_number]" id="userMobileNumber" value=""/>
					<input type="hidden" name="user[profile_pic]" id="userProfilePic" value=""/>
				</div>
				<div style="width:370px;float:left;">					
					<div class="row" style="">
		                <label class="col-sm-12 control-label">Lead Type:</label>
						<div class="col-sm-12" style="padding-right:12px;">
	                    <select multiple class="multi-select" name="page[type][]" id="pageType">
							<option value="Litigation">From Litigation</option>
							<option value="Market">From Market</option>
							<option value="General">From Proactive General</option>
							<option value="SEP">From Proactive SEP</option>
							<option value="NON">Non Acquisition</option>
							<option value="INT">Internal</option>
						</select>
						</div>
		            </div>					
					<div class="row">
		                <label class="col-sm-12 control-label">List of Module:</label>
		                <div class="col-sm-12" style="padding-right:12px;">
		                    <select multiple class="multi-select" name="page[module_id][]" id="moduleModuleID">
		                        <?php 
									foreach($modules as $module){
								?>
									<option value="<?php echo $module->id;?>"><?php echo $module->name;?></option>
								<?php
									}
								?>
		                    </select>
		                </div>
		            </div>
				</div>
				<div style="width:280px;float:left;">
					<div class="row">
		               <div class="col-sm-12" style="padding-right:12px;">
							<table class='table table-bordered table-hover' id="leadTable">
								<thead>
									<tr>
										<th>#</th>
										<th>Associated Leads</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach($leads as $list){
									?>
									<tr>
										<td><input type='checkbox' name="page[lead_id][]" value="<?php echo $list->id?>"/></td>
										<td><?php echo $list->lead_name;?></td>
									</tr>
									<?php
										}
									?>
								</tbody>
							</table>
		                </div>
		            </div>			
				</div>
				<?php echo form_close();?>
			</div>			
		</div>
	</div>
<script>

	function getUserPageList(object){
		jQuery("#userActive").prop('checked',false);
		jQuery("#userId").val(0);
		if(object.val()!=""){

			jQuery.ajax({

				type:'POST',

				url:'<?php echo $Layout->baseUrl?>general/getUserModuleLeadList',

				data:{token:object.val()},

				cache:false,

				success:function(res){
					_data = jQuery.parseJSON(res);
					if(_data.user_detail!="undefined"){
						jQuery("#userId").val(_data.user_detail.id);
						if(_data.user_detail.status == 0){
							jQuery("#userActive").prop('checked',true);
						}
						jQuery("#userType").val(_data.user_detail.type);
						jQuery("#userFlag").val(_data.user_detail.flag);
					}
					jQuery("#leadTable").find('input[type="checkbox"]').prop('checked',false);
					if(_data.leads!="undefined"){
						if(_data.leads.length>0){
							jQuery("#leadTable").find('input[type="checkbox"]').each(function(){
								for(j=0;j<_data.leads.length;j++){
									if(jQuery(this).attr('value')==_data.leads[j].lead_id){
										jQuery(this).prop('checked',true);
									}
								}
							});
						}						
						if(_data.leads_type.length>0){	
							jQuery("#pageType").multiSelect('deselect_all');	
							jQuery("#pageType").find('option').each(function(){
								for(j=0;j<_data.leads_type.length;j++){
									if(_data.leads_type[j].lead_type==jQuery(this).attr('value')){
										jQuery(this).attr('selected','selected');
									}
								}
							});								
							jQuery("#pageType").multiSelect('refresh');
							$(".ms-container").find('i').remove();
							$(".ms-container").find('i').append('<i class="glyph-icon icon-exchange"></i>');
						} else {
							jQuery("#pageType").multiSelect('deselect_all').multiSelect('refresh');
							$(".ms-container").find('i').remove();
							$(".ms-container").find('i').append('<i class="glyph-icon icon-exchange"></i>');
						}
						if(_data.module.length>0){
							if(_moduleList.length>0){
								_option="";				
								for(i=0;i<_moduleList.length;i++){
									_selected="";
									for(j=0;j<_data.module.length;j++){
										if(_data.module[j].module_id==_moduleList[i].id){
											_selected = "selected='selected'";
										}
									}
									_option +='<option '+_selected+' value="'+_moduleList[i].id+'">'+_moduleList[i].name+'</option>';
								}
								jQuery("#moduleModuleID").html(_option);
								$(".multi-select").multiSelect();
								$(".ms-container").find('i').remove();
								$(".ms-container").find('i').append('<i class="glyph-icon icon-exchange"></i>');
							}
						} else {
							jQuery("#moduleModuleID").multiSelect('deselect_all').multiSelect('refresh');
							$(".ms-container").find('i').remove();
							$(".ms-container").find('i').append('<i class="glyph-icon icon-exchange"></i>');
						}
					} else {
						jQuery("#leadLeadID").multiSelect('deselect_all').multiSelect('refresh');
						jQuery("#moduleModuleID").multiSelect('deselect_all').multiSelect('refresh');
						$(".ms-container").find('i').remove();
							$(".ms-container").find('i').append('<i class="glyph-icon icon-exchange"></i>');
					}
				}
			});
		}
	}

	

	function getPageUserList(object){

		if(object.val()!=""){

			jQuery.ajax({

				type:'POST',

				url:'<?php echo $Layout->baseUrl?>general/getPageUserList',

				data:{token:object.val()},

				cache:false,

				success:function(res){

					_data = jQuery.parseJSON(res);

					if(_data.length>0){

						if(_userList.length>0){

							_option="";							

							for(i=0;i<_userList.length;i++){

								_selected="";

								for(j=0;j<_data.length;j++){

									if(_data[j].user_id==_userList[i].id){

										_selected = "selected='selected'";

									}

								}

								_option +='<option '+_selected+' value="'+_userList[i].id+'">'+_userList[i].name+'</option>';

							}

							jQuery("#pageUserID").html(_option);

							$(".multi-select").multiSelect();

							$(".ms-container").find('i').remove();
							$(".ms-container").find('i').append('<i class="glyph-icon icon-exchange"></i>');

						}

					} else {

						jQuery("#pageUserID").multiSelect('deselect_all').multiSelect('refresh');

						$(".ms-container").find('i').remove();
							$(".ms-container").find('i').append('<i class="glyph-icon icon-exchange"></i>');

					}

				}

			});

		}

	}

</script>
</div>



<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn; ?>widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn; ?>widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn; ?>widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
	var _tableUser;
	jQuery(document).ready(function() {
        _tableUser = jQuery('#datatable-user').DataTable( {
            paging: false,
			scrollY:"240px",
			scrollX: false,
			columnDefs: [
			  { targets: 1 }
			],
        });
    });
	function editUser(u,o){
		jQuery("#userId").val(u);
		jQuery("#userFlag").val(o.attr('data-flag'));
		jQuery("#userType").val(o.attr('data-type'));
		jQuery("#userbName").val(o.attr('data-name'));
		jQuery("#userEmail").val(o.attr('data-email'));
		jQuery("#userEmailForSignature").val(o.attr('data-email'));
		jQuery("#userPhone").val(o.attr('data-phone'));
		jQuery("#userMobileNumber").val(o.attr('data-phone'));
		jQuery("#userExt").val(o.attr('data-ext'));
		jQuery("#userTitle").val(o.attr('data-title'));
		jQuery("#userDirect").val(o.attr('data-direct'));
	}
	function changeStatus(u,o){
		let s = o.attr('data-status');
		jQuery.ajax({
			type:'GET',
			url:'<?php echo $Layout->baseUrl?>general/modifyUser/'+u+'/'+s,
			success:function(){				
				if(s==0){
					o.attr('data-status',1).attr('title','activate');
				} else {
					o.attr('data-status',0).attr('title','deactivate');
				}
			}
		})
	}
	function alertFlag(o,id){
		chk = 0;
		if(o.prop('checked')){
			chk = 1;
		}
		jQuery.ajax({
			type:'POST',
			url:'<?php echo $Layout->baseUrl?>general/changeUserSend',
			data:{chk:chk,u:id},
			cache:false,
			success:function(res){
				
			}
		});
	}
	/*function getUserPageList(object){
		if(object.val()!=""){
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl?>general/getUserPageList',
				data:{token:object.val()},
				cache:false,
				success:function(res){
					_data = jQuery.parseJSON(res);
					if(_data.length>0){
						if(_pageList.length>0){
							_option="";							
							for(i=0;i<_pageList.length;i++){
								_selected="";
								for(j=0;j<_data.length;j++){
									if(_data[j].page_id==_pageList[i].id){
										_selected = "selected='selected'";
									}
								}
								_option +='<option '+_selected+' value="'+_pageList[i].id+'">'+_pageList[i].page_name+'</option>';
							}
							jQuery("#pagePageID").html(_option);
							$(function() { "use strict";
								$(".multi-select").multiSelect();
								$(".ms-container").find('i').remove().append('<i class="glyph-icon icon-exchange"></i>');
							});
						}
					} else {
						jQuery("#pagePageID").multiSelect('deselect_all').multiSelect('refresh');
					}
				}
			});
		}
	}*/
</script>