<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>icons/fontawesome/fontawesome.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/modal/modal.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/modal/modal.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/slimscroll/slimscroll.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/tooltip/tooltip.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<style> 
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;
		font-family:arial;
		font-size:13px;
		margin:0px;
		padding:0px;
	}
	#page-content {
	    background: #ffffff !important;
	}

</style>

<script>
__baseUrl = '<?php echo $Layout->baseUrl?>';
function findDuplicate(){
	<?php if($showD==9 || $showD==11 || $showD==12):?>
	window.location = __baseUrl+'leads/pre_contacts/12';
	<?php else:?>
	window.location = __baseUrl+'leads/pre_contacts/2';
	<?php endif;?>
}
jQuery(document).ready(function(){
	jQuery('#inviteeCompanyId').select2();
})
</script>
<style>
.colorClass{
	color:#1E88E5 !important;
	text-decoration:underline;
}
.thVal{border:0px;}
</style>
<div class="modal modal-opened-header fade" id="modal_c_users" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:100%;z-index:999999">
	<div class="modal-dialog" style=''>
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-9px;margin-right:-5px;float:left;"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div style='max-height:300px;overflow-y:scroll' id="cUsers"></div>
			</div>
		<div class="modal-footer"></div>
		</div>
	</div>
</div>
<h4><?php if($showD==9 || $showD==11 || $showD==12):?>Manage Import Pre-contacts<?php else:?>Import new contacts<?php endif;?></h4> 
<div class='col-lg-12'>
<div class="row" style='margin-bottom:10px;'>
<div class='col-xs-12'>
<?php 
if($showD==2 || $showD==12):
?>
 Delete pre-contacts of people that already exist in the database: use the trash icon or select the checkbox on the Title line in order to automatically uncheck the people to be deleted and then click <a href='javascript://' onclick='deleteDuplicate();' class='colorClass' style='display:inline-block;'>Delete unchecked items</a>. When done click <a style='display:inline-block;' href='<?php echo $Layout->baseUrl;?>leads/pre_contacts/11' class='colorClass'>here</a><br/>
<?php else:?>
1) To add Pre-Contacts to the Contact database skip to 2. To add new contacts to the Pre-Contacts table: paste the list to <a class='colorClass' href='<?php echo $Layout->baseUrl;?>leads/pre_contacts/'>this Adding Table</a> edit the list and click <a style='display:inline-block;' href='javascript://' class='colorClass' onclick="addSheettoPreContacts()" >Save</a> to create Pre-Contacts.
<br/>2) Remove duplicates: To identify duplicates click <a href='javascript://' class='colorClass' style='display:inline-block;' onclick='findDuplicate();'>Find Duplicates</a> to create a sub group of people with similar first and last names.<br/>
3) To delete from the Pre-Contacts table right click and delete. To add Pre-Contacts to the Contacts database: open <a style='display:inline-block;' href='<?php echo $Layout->baseUrl;?>leads/pre_contacts/11' class='colorClass'>Pre-Contacts Table</a>, select one or more persons, associate them with an existing company from the list: <select class="" id="inviteeCompanyId" name="invitee[company_id]" class="form-control" style='width:150px;'><?php 												
					if(count($companies)>0){
					?>
					<option value=''></option>
					<?php
						foreach($companies as $company){
				?> <option value="<?php echo $company->id;?>"><?php echo $company->company_name;?></option> <?php
						}
					}
				?> </select>, and click <a style='display:inline-block;' href='javascript://' onclick="addPreToContact(0)" class='colorClass'>Add Contact</a>. To add a new company to the dropdownlist click <a href='javascript://' onclick="openAddForm()" class='colorClass' style='display:inline-block;'>Add a Company</a>. Alternatively, select the Pre-Contacts, and click <a style='display:inline-block;' href='javascript://' onclick="addPreToContact(1)" class='colorClass'>Add a Company</a>. The selected contacts will automatically be included within the newly added companies. <br/>
To import contacts from Google Contacts: <a style='' href='javascript://' onclick="window.parent.openGoogleContacts()" class='colorClass' style='display:inline-block;'>Import Google Contact</a>.</span><br/> To delete the contact of the Pre-Contact table click <a class='colorClass' style='display:inline-block;' href='javascript://' onclick="deleteAllPreContacts()">Clear Pre-Contact table</a><?php endif;?><br/> To export the contact of the Pre-Contact table in CSV click <a href='javascript://' id='export-file' class='colorClass'>here</a></div>
</div>
<div class='col-xs-12 hide' id='frm_import'>
	
</div>
<div class="col-xs-12" id="wait_message" style='display:none;'>
	<p class='alert '></p>
</div>
<?php 
	if((int)$showD ==0):
?>
 <link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.js"></script>
<style>
	/*#paste_contacts{overflow:hidden !important;overflow-y:scroll !important;}*/.htCore, .handsontable{font-family:arial;font-size:13px;}
</style>
	<div id="paste_contacts" class="handsontable col-lg-12" style='height:400px;overflow:hidden !important;overflow-y:scroll !important;padding:0px !important;'></div>
	<script>
		width =jQuery(window).width();		
		
		var totalHeight = jQuery(window).height();
		var mainHeight = totalHeight - 210;
		var container = document.getElementById('paste_contacts'),handObj;
		
		jQuery("#paste_contacts").css('width',width+'px');
		objHands = new Handsontable(container, {
					  autoWrapCol:true,
					  wordWrap:true,
					  rowHeaders: false,
					  colHeaders: [    
							"First Name",
							"Last Name",
							"Title",
							"Company",
							"Email",							
							"S.Email",
							"Telephone",
							"Cellphone",
							"Address",
							"LinkedIn",
							"Image",
							"CC",
							"Type",
							
						],
					  startRows:1,
					  minSpareRows: 1,
					  minSpareCols:0,
					  width:function(){return width;},
					  height:function(){return mainHeight;},
					  stretchH:"all",
					  columnSorting: true,sortIndicator:true,contextMenu: ['remove_row'],
					  filters: true,
					  dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
				});
jQuery(document).ready(function(){
	windowResize();
})	
function windowResize(){
	jQuery(window).resize(function(){
		var totalHeight = jQuery(window).height();
		var mainHeight = totalHeight - 210;
		var availableWidth = jQuery(window).width();
		availableWidth = availableWidth-20;
		objHands.updateSettings({
			 width:function(){console.log(availableWidth);return availableWidth;},
			 height:function(){return mainHeight;},
		});
		objHands.render()
	})
}	
	</script>
<?php 
	elseif($showD==2 || $showD==12):
?>
	<script>
		function deleteDuplicate(){
			_getAllContactsIDs = [];
			_getAllPreContactsIDs = [];
			jQuery('input[name="delete_contact[]"]:not(:checked)').each(function(){
				if(jQuery(this).data('type')=="0"){
					_getAllPreContactsIDs.push(jQuery(this).data('tap'));
				} else if(jQuery(this).data('type')=="1"){
					_getAllContactsIDs.push(jQuery(this).data('tap'));
				}
			})
			if(_getAllContactsIDs.length>0 || _getAllPreContactsIDs.length>0){
				jQuery.ajax({
					type:'POST',
					url:__baseUrl+'leads/data_from_temp_to_delete',
					data:{c:JSON.stringify(_getAllContactsIDs),p:JSON.stringify(_getAllPreContactsIDs)},
					cache:false,
					dataType:'json',
					success:function(d){
						if(d.status>0){
							window.location = __baseUrl+'leads/pre_contacts/2';
						} else {
							alert('System not able to delete.');
						}						
					}
				});
			} else {
				alert('No contact selected');
			}
		}
		function checkAll(o){
			if(o.is(':checked')){
				name = "";
				wholeListUpdate=[];
				jQuery('input[name="delete_contact[]"]').each(function(index){
					_name = jQuery(this).parents('tr').find('td').eq(2).text();
					if(jQuery.trim(name)!=jQuery.trim(_name)){
						console.log('NOT MATCH: '+_name+' OTHER :'+name);
						name = jQuery.trim(_name);
						jQuery(this).prop('checked',true);
					} else {
						/*_tr = jQuery(this).parents('tr');
						_pre = _tr.prev();
						_dt = false;
						_tr.find('td').each(function(ind){
							if(jQuery.trim(jQuery(this).text())!=""){
								if(_pre.find('td').eq(ind).text()==""){
									_dt = true;
									console.log("Update In Pre:"+jQuery(this).text());
									_pre.find('td').eq(ind).text(jQuery(this).text());
								}
							}							
						});
						if(_dt===true){							
							field={};
							_tr.find('td').each(function(){
								if(jQuery(this).data('field')=="id"){
									field['id'] = jQuery(this).find('input[type="checkbox"]').data('tap');
									field['type'] = jQuery(this).find('input[type="checkbox"]').data('type');
								} else {
									fieldName = jQuery(this).data('field');
									if(typeof(fieldName)!='undefined'){
										if(fieldName=="img_card"){
											field[fieldName] = jQuery(this).data('field-val');
										}else if(fieldName=="profile_url"){
											field[fieldName] = jQuery(this).data('field-val');
										} else {
											field[fieldName] = jQuery(this).text();
										}	
									}									
								}
								
							});
							wholeListUpdate.push(field);
						}
						_dt = false;*/
					}					
				});			
				updateData(wholeListUpdate);
			} else {
				jQuery('input[name="delete_contact[]"]').each(function(){
					jQuery(this).prop('checked',false);
				});
			}
		}
		function updateData(wholeListUpdate){
			if(wholeListUpdate.length>0){
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'leads/update_companies_from_duplicates',
				data:{update_dt:JSON.stringify(wholeListUpdate)},
				dataType:'json',
				success:function(d){
					console.log(d);
				}
			});
			}
		}
		jQuery(document).ready(function(){
			jQuery('#db_from_litigation1').find("tbody").find("tr>td").dblclick(function(e){
				e.stopPropagation();
				var currentEle = $(this);
				console.log(currentEle.html());
				var value = $(this).html();
				if($(this).find('span').length>0){
					var value = $(this).find('span').html();
				}
				if($(this).find('textarea.thVal').length==0){
					updateAnotherVal(currentEle, value);
				}
			});
		});
		String.prototype.stripSlashes = function(){
			return this.replace(/\\(.)/mg, "$1");
		}
		function updateAnotherVal(currentEle, value) {
			jQuery('#db_from_litigation1').find("tbody").find("tr>td").find('.thVal').each(function(index){
				if(urlregex.test($(this).val().trim())){
					console.log('1asd');
					if(jQuery(this).parent().data('field')=="img_card"){
						if($(this).parent().find('span').length>0){
							$(this).parent().find('span').html("<a href='"+$(this).val().trim()+"' target='_BLANK'><img src='"+$(this).val().trim()+"' width='50px'/></a>");
						} else {
							$(this).parent().html("<span class='span_draggable'><a href='"+$(this).val().trim()+"' target='_BLANK'><img src='"+$(this).val().trim()+"' width='50px'/></a></span>");
							$(this).parent().find('span').draggable({helper: "clone",cursor: "crosshair"});
						}
					} else if(jQuery(this).parent().data('field')=="profile_url"){
						if($(this).parent().find('span').length>0){
							$(this).parent().find('span').html("<a href='"+$(this).val().trim()+"' target='_BLANK'>Url</a>");
						} else {
							$(this).parent().html("<span class='span_draggable'><a href='"+$(this).val().trim()+"' target='_BLANK'>Url</a></span>");
							$(this).parent().find('span').draggable({helper: "clone",cursor: "crosshair"});
						}
					}
				} else {
					console.log('2asd');
					if($(this).parent().find('span').length>0){
						$(this).parent().find('span').html($(this).val().trim());
					} else {
						$(this).parent().html("<span class='span_draggable'>'"+$(this).val().trim()+"'</span>");
						$(this).parent().find('span').draggable({helper: "clone",cursor: "crosshair"});
					}
				}					
				$(".thVal").remove();
			});
			if(value.indexOf('<a')>=0){
				value = jQuery(value).attr('href');
			}
			_wi = $(currentEle).width();
			_he = $(currentEle).height();
			value = value.stripSlashes() ;
			$(currentEle).html('<textarea class="thVal" style="width:'+_wi+'px;height:'+_he+'px">' + value + '</textarea>');
			$(".thVal").focus();
			$(".thVal").keyup(function (event) {
				if (event.keyCode == 13) {
					_pObject = $(this).parents('tr');
					if(urlregex.test($(this).val().trim())){
						if(jQuery(this).parent().data('field')=="img_card"){
							if($(this).parent().find('span').length>0){
								$(this).parent().find('span').html("<a href='"+$(this).val().trim()+"' target='_BLANK'><img src='"+$(this).val().trim()+"' width='50px'/></a>");
							} else {
								$_this = $(this).parent();
								$_this.html("<span class='span_draggable'><a href='"+$(this).val().trim()+"' target='_BLANK'><img src='"+$(this).val().trim()+"' width='50px'/></a></span>");
								$_this.find('span').draggable({helper: "clone",cursor: "crosshair"});
							}
						} else if(jQuery(this).parent().data('field')=="profile_url"){
							if($(this).parent().find('span').length>0){
								$(this).parent().find('span').html("<a href='"+$(this).val().trim()+"' target='_BLANK'>Link</a>");
								$(this).parent().attr('data-field-val',$(this).val().trim());
								$(this).parent().data('field-val',$(this).val().trim());
								console.log('ds1');
							} else {
								$_this = $(this).parent();
								$(this).parent().html("<span class='span_draggable'><a href='"+$(this).val().trim()+"' target='_BLANK'>Link</a></span>");
								$(this).parent().attr('data-field-val',$(this).val().trim());
								$(this).parent().data('field-val',$(this).val().trim());
								console.log('ds');
								$_this.find('span').find('span').draggable({helper: "clone",cursor: "crosshair"});
							}
						}
						
						
						
						
						/*$(this).parent().html("<a href='"+$(this).val().trim()+"' target='_BLANK'>Url</a>");*/
					} else {
						/*$(this).parent().html($(this).val().trim());*/
						console.log('2asd2');
						if($(this).parent().find('span').length>0){
							$(this).parent().find('span').html($(this).val().trim());
							console.log('2asd21');
						} else {
							$_this = $(this).parent();
							$(this).parent().html("<span class='span_draggable'>"+$(this).val().trim()+"</span>");
							$_this.find('span').draggable({helper: "clone",cursor: "crosshair"});
						}
					}
					$(".thVal").remove();
					wholeListUpdate = [];
					field={};
					_pObject.find('td').each(function(){
						if(jQuery(this).data('field')=="id"){
							field['id'] = jQuery(this).find('input[type="checkbox"]').data('tap');
							field['type'] = jQuery(this).find('input[type="checkbox"]').data('type');
						} else {
							fieldName = jQuery(this).data('field');
							if(typeof(fieldName)!='undefined'){
								if(fieldName=="img_card"){
									if(typeof jQuery(this).data('field-val')=="object"){
										field[fieldName] = JSON.stringify(jQuery(this).data('field-val'));
									} else {
										field[fieldName] = jQuery(this).data('field-val');
									}									
								}else if(fieldName=="profile_url"){
									if(jQuery(this).data('field-val')!=""){
										field[fieldName] = jQuery(this).data('field-val');
									} else if(jQuery(this).find('span.span_draggable').length>0){
										if(jQuery(this).find('span.span_draggable').find('a').length>0){
											field[fieldName] = jQuery(this).find('span.span_draggable').find('a').attr('href');
										}
									}									
								} else {
									field[fieldName] = jQuery(this).find('span').text();
								}	
							}													
						}
						
					});
					wholeListUpdate.push(field);
					updateData(wholeListUpdate);
				}
			});
			jQuery('#db_from_litigation1').find("tbody").find("tr>td").off('dblclick').on('dblclick',function(e){
				e.stopPropagation();
				var currentEle = $(this);
				var value = $(this).html();
				if($(this).find('span').length>0){
					var value = $(this).find('span').html();
				}
				if($(this).find('textarea.thVal').length==0){
					updateAnotherVal(currentEle, value);
				}
			});
		}
		jQuery(document).ready(function(){
			enableDragDropEditableTable();
			
		});
		function enableDragDropEditableTable(){
			if(jQuery("#db_from_litigation1 td").is('.ui-droppable')){
				jQuery("#db_from_litigation1 td").droppable('disable');
			}
			if(jQuery("#db_from_litigation1 td>span").is('.ui-draggable')){
				jQuery("#db_from_litigation1 td>span").draggable('disable');
			}
			jQuery("#db_from_litigation1 td").droppable({
				drop:function(event,ui){
					 var droppedItem = $(ui.draggable).clone();
					droppedItem.draggable({helper: "clone",cursor: "crosshair"});
					jQuery(this).empty().append(droppedItem);	
					if(typeof(jQuery(this).data('field'))!='undefined' && jQuery(this).data('field')=="img_card"){
						jQuery(this).data('field-val',ui.draggable.parent().data('field-val'));
					} else if(typeof(jQuery(this).data('field'))!='undefined' && jQuery(this).data('field')=="profile_url"){
						jQuery(this).data('field-val',ui.draggable.parent().data('field-val'));
					}
					_pObject = jQuery(this).parent();
					wholeListUpdate = [];
					field={};
					fieldName = jQuery(this).data('field');
					field['id'] = _pObject.find('input[type="checkbox"]').data('tap');
					field['type'] = _pObject.find('input[type="checkbox"]').data('type');
					if(typeof(fieldName)!='undefined'){
						if(fieldName=="img_card"){
							field[fieldName] = jQuery(this).data('field-val');
						}else if(fieldName=="profile_url"){
							field[fieldName] = jQuery(this).data('field-val');
						} else {
							field[fieldName] = jQuery(this).find('span').text();
						}	
					}
					wholeListUpdate.push(field);
					updateData(wholeListUpdate);
				}
			});
			jQuery("#db_from_litigation1 td>span").draggable({helper: "clone",cursor: "crosshair"});
		}
		
	</script>
	<div class="col-md-12" id="litigation_container">
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="db_from_litigation1" >
	<thead>
		<tr>     
			<th># <input type="checkbox" onclick="checkAll(jQuery(this))"/></th>
			<th>ID</th>
			<th>First Name</th>  
			<th>Last Name</th> 
			<th>Job Title</th>   
			<th>Company</th>  
			<th>Email</th>  
			<th>Telephone</th>  
			<th>Mobile Phone</th>  
			<th>LinkedIn Url</th>
			<th>Img</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($all_contacts)>0){
				foreach($all_contacts as $lit){
		?>
					<tr data-i="<?php echo $lit->id;?>" style='color:<?php if($lit->contact_type=='1'):?>#000<?php elseif($lit->contact_type=='0'):?>red<?php endif;?>;'>
					<td data-field="id"><input type='checkbox' name='delete_contact[]' data-tap='<?php echo $lit->contact_id;?>' data-type='<?php echo $lit->contact_type;?>' value="<?php echo $lit->contact_id;?>"/><a href='javascript://' onclick="removeDuplicateContact(jQuery(this),<?php echo $lit->contact_type;?>,<?php echo $lit->contact_id?>)"><img src="<?php echo $Layout->aws_server_cdn;?>images/discard.png"/></a></td>
					<td><?php echo $lit->id?></td>
					<td data-field="first_name"><span class='span_draggable'><?php echo $lit->first_name?></span></td>
					<td data-field="last_name"><span class='span_draggable'><?php echo $lit->last_name?></span></td>
					<td data-field="job_title"><span class='span_draggable'><?php echo $lit->job_title?></span></td>
					<td data-field="company_name"><span class='span_draggable'><?php echo $lit->company_name?></span></td>					
					<td data-field="email"><span class='span_draggable'><?php echo $lit->email?></span></td>					
					<td data-field="telephone"><span class='span_draggable'><?php echo $lit->telephone?></span></td>					
					<td data-field="cellphone"><span class='span_draggable'><?php echo $lit->cellphone?></span></td>					
					<td data-field="profile_url" data-field-val='<?php echo $lit->linkedin_url?>'>
					
					<?php 
						if(trim($lit->linkedin_url)!=""){
						?>
							<span class='span_draggable'><a href="<?php echo $lit->linkedin_url?>" target="_BLANK">Link</a></span>
						<?php
						}?></td>					
					<td data-field="img_card" data-field-val='<?php echo $lit->img_card;?>'><?php 
						if($lit->img_card!=""){
							try{
								$images = json_decode($lit->img_card,true);
								if(count($images)>0):
								foreach($images as $img){
						?> 
						<span class='span_draggable'><a target="_BLANK" href="<?php echo $img?>"><img src="<?php echo $img;?>" width="50px"/></a></span>
						<?php
								}
								endif;
							}catch(Exception $e){
								
							}
						}
					?></td>					
				</tr>
		<?php
				}
			}
		?>
	</tbody>
</table>
</div>
<script>
var totalHeight = jQuery(window).height();
var mainHeight = totalHeight - 210;
jQuery('#litigation_container').css({overflow:'auto',maxHeight:mainHeight+"px",minHeight:mainHeight+"px",height:mainHeight+'px'});
</script>
<?php 
	
	elseif($showD ==1 || $showD ==11):
	
?>

 <link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.js"></script>
<style>
	/*#paste_contacts{overflow:hidden !important;overflow-y:scroll !important;}*/.htCore, .handsontable{font-family:arial;font-size:13px;}
	.htCore td{color:red}.htCore td a{color:#1E88E5 !important}
</style>
<p>No of Records <span><strong id='no_of_rows'></strong></span></p>
<div class="scroll-container col-lg-12 cp-border">
	<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
</div>
<script>
var totalHeight = jQuery(window).height();
var mainHeight = totalHeight - 210;
var availableWidth = jQuery(window).width();
availableWidth = availableWidth-20;
console.log(availableWidth);
jQuery('.scroll-container').css('height',mainHeight+'px');
var company_table = document.getElementById('companies_box'),hot1;
var _red=<?php echo count($pre_contacts);?>;
_companiesINString=[];
<?php 
	$selected=0;
	if(count($pre_contacts)>0){
		foreach($pre_contacts as $lit){		
			$checked = 'no';	
			$image = "";
			if(trim($lit->img_card)!=""){
				$images = json_decode($lit->img_card,true);
				if(count($images)>0){
					$image = $images[0];
				}
			}
		?>
		objectS = {};
		objectS.id = <?php echo $lit->id?>;
		objectS.selected = '<?php echo $checked?>';
		objectS.type = 'pre-contact';
		objectS.first_name = '<?php echo addslashes($lit->first_name)?>';
		objectS.last_name = '<?php echo addslashes($lit->last_name)?>';
		objectS.job_title = '<?php echo addslashes($lit->job_title)?>';
		objectS.company_name = '<?php echo addslashes($lit->company_name)?>';
		objectS.email = '<?php echo $lit->email?>';
		objectS.cellphone = '<?php echo $lit->cellphone?>';
		objectS.telephone = '<?php echo $lit->telephone?>';
		objectS.profile_url = '<?php echo $lit->profile_url?>';
		objectS.img_card = '<?php echo $image?>';
		objectS.proximity = '<?php echo $lit->proximity?>';
		objectS.c_c = '<?php echo $lit->c_c?>';
		_companiesINString.push(objectS);
		<?php
		}
	}
?>
function implementCompanyTable(){
	
	  hot1 = new Handsontable(company_table, {
			data: _companiesINString,
			  autoWrapCol:true,
			  wordWrap:true,
			  rowHeaders: false,
			  colHeaders: ['#','id','First Name', 'Last Name', 'Job Title','Company','Email','Cell Phone','Telephone','Url','Image','Proximity','Shared Conn.'],
			  minSpareRows: 0,
			  minSpareCols: 0,
			  manualColumnResize:true ,
			  minCols: 13,
			  maxCols: 13,
			  maxRows: _companiesINString.length,
			  width:function(){console.log(availableWidth);return availableWidth;},
			  height:function(){return mainHeight;},
			  stretchH:"all",
			  contextMenu: ['remove_row'],
			  columnSorting: {
				column: 4,
				sortOrder: true
			  },
			filters: true,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
			columns: [
			
			  {
				data:'id',
				readonly:true
			  },
			  {
				data:'selected',
				type:'checkbox',
				checkedTemplate: 'yes',
				uncheckedTemplate: 'no'
			  },
			  {
				data:'first_name',
			  },
			  {
				data:'last_name',
			  },
			  {
				data:'job_title',
			  },
			  {
				data:'company_name',
			  },
			  {
				data:'email',
			  },
			  {
				data:'cellphone',
			  },
			  {
				data:'telephone',
			  },
			  {
				data:'profile_url',
				renderer: URLRender,
			  },
			  {
				data:'img_card',
				renderer: IMAGERender,
			  },
			  {
				data:'proximity',
			  },
			  {
				data:'c_c',
			  }
			],
			afterChange: function (changes, source) {
				if(!changes){return;}	
				console.log(changes[0][1]);
				objectS = {};
				objectS.id = hot1.getDataAtRowProp(changes[0][0],'id');
				if(objectS.id>0 && changes[0][1]!="selected"){
					objectS.first_name = hot1.getDataAtRowProp(changes[0][0],'first_name');
					objectS.last_name = hot1.getDataAtRowProp(changes[0][0],'last_name');
					objectS.job_title = hot1.getDataAtRowProp(changes[0][0],'job_title');
					objectS.company = hot1.getDataAtRowProp(changes[0][0],'company_name');
					objectS.email = hot1.getDataAtRowProp(changes[0][0],'email');
					objectS.phone = hot1.getDataAtRowProp(changes[0][0],'cellphone');
					objectS.telephone = hot1.getDataAtRowProp(changes[0][0],'telephone');
					objectS.url = hot1.getDataAtRowProp(changes[0][0],'profile_url');
					objectS.t = 'pre-contact';	
					jQuery.ajax({
					type:'POST',
						url:__baseUrl+'customers/update_pre_contacts',
						data:objectS,
						cache:false,
						success:function(res){						
						}
					});
				}				
			},
			afterInit:function(){
				jQuery("#no_of_rows").text(_companiesINString.length);
			},
			beforeRemoveRow: function(index, amount){
				rowCount = this.countRows();
				var absoulteIndex = (rowCount + index) % rowCount;				
				_companyID = hot1.getDataAtRowProp(absoulteIndex,'id');
				console.log(_companyID);
				jQuery.ajax({
					type:'POST',
					url:__baseUrl+'leads/remove_precontacts',
					data:{id:_companyID},
					success:function(d){
					}
				});
			}
  });	
 }
implementCompanyTable();
jQuery(document).ready(function(){
	windowResize();
})
var exportPlugin = hot1.getPlugin('exportFile');
document.getElementById('export-file').addEventListener('click', function() {
    exportPlugin.downloadFile('csv', {filename: 'PreContacts'});
});
function URLRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.Dom.empty(td);
	if(value!=""){
		td.innerHTML="<a href='"+value+"' target='_blank'>Link</a>";
	} else {
		td.innerHTML="";
	}
	
	return td;
}
function IMAGERender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.Dom.empty(td);
	if(jQuery.trim(value)!=''){
		td.innerHTML="<img src='"+value+"' width='50px'/>";
	}	
	return td;
}
function windowResize(){
	jQuery(window).resize(function(){
		console.log("window1");
		var totalHeight = jQuery(window).height();
		var mainHeight = totalHeight - 210;
		var availableWidth = jQuery(window).width();
		availableWidth = availableWidth-20;
		hot1.updateSettings({
			 width:function(){console.log(availableWidth);return availableWidth;},
			 height:function(){return mainHeight;},
		});
	})
}
</script>

<?php endif;?>

</div>
<script>
function openFormFields(){
	jQuery('#frm_import').toggle();
	window.parent.open_drive_files('https://docs.google.com/spreadsheets/d/1dNMAIvMuSBZRccQtFuScNL5HPFp4-TUF3ECutIC3iPw/edit#gid=821660973');
}
function addSheettoPreContacts(){
	if(typeof objHands!="undefined"){
		_data = objHands.getData();
		jQuery('.loader_import_file').removeClass('hide').addClass('show');
		jQuery.ajax({
			url:__baseUrl+'leads/contact_import_from_table_in_precontacts',
			type:'POST',
			data:{contacts:JSON.stringify(_data)},
			cache:false,
			success:function(d){
				jQuery('.loader_import_file').addClass('hide').removeClass('show');
				window.parent.jQuery("#predefineFormIframe").attr('src',__baseUrl+'leads/pre_contacts/11');
				/*window.parent.document.getElementById('predefineFormIframe').src = window.parent.document.getElementById('predefineFormIframe').src+'1';*/
				if(d>0){				
					/*window.parent.document.getElementById('predefineFormIframe').contentWindow.location.reload();*/
				}
			}
		});
	} else {
		window.parent.jQuery("#predefineFormIframe").attr('src',__baseUrl+'leads/pre_contacts/11');
	}
}
	

function importContactsFromFile(){
	jQuery('.loader_import_file').removeClass('hide').addClass('show');
	frm_data= jQuery('#import_sheet_form').serializeArray();
	jQuery.ajax({
		url:__baseUrl+'leads/file_import_in_contacts',
		type:'POST',
		data:frm_data,
		cache:false,
		success:function(d){
			jQuery('.loader_import_file').addClass('hide').removeClass('show');
			if(d>0){
				window.parent.document.getElementById('predefineFormIframe').contentWindow.location.reload();
			}
		}
	});
}


function importContactsFromCards(fileID,o){
	o.parent().find('.loader_new_lead').removeClass('hide').addClass('show');
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'leads/import_file_dr',
		data:{id:fileID},
		success:function(d){
			_d = jQuery.parseJSON(d);
			if(_d.data!=''){
				html = _d.data;
				if(typeof _d.file!='undefined'){
					html = '<p><a target="_BLANK" href="'+_d.file+'" style="color:#1976D2 text-decoration:underline">Imported File</a></p>'+_d.data;
				}
				jQuery("#cUsers").html(html);
				jQuery("#modal_c_users").modal("show");
				o.parent().find('.loader_new_lead').removeClass('show').addClass('hide');
				/*jQuery('table#db_from_free_litigation>tbody>tr[data-i="' + fileID + '"]').remove();*/
			} else {
				alert(_d.error);
			}
		}
	})
}

function deleteFreePreContact(ID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'leads/deleteFreePreContact',
		data:{id:ID},
		success:function(d){
			if(d>0){
				jQuery('table#db_from_free_litigation>tbody>tr[data-i="' + ID + '"]').remove();
			}
		}
	})
}
urlregex = /^(https?|ftp):\/\/([a-zA-Z0-9.-]+(:[a-zA-Z0-9.&%$-]+)*@)*((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(:[0-9]+)*(\/($|[a-zA-Z0-9.,?'\\+&%$#=~_-]+))*$/;
function updateVal(currentEle, value) {
	jQuery('#db_from_litigation').find("tbody").find("tr>td").find('.thVal').each(function(){
		if(urlregex.test($(this).val().trim())){
			$(this).parent().html("<a href='"+$(this).val().trim()+"' target='_BLANK'>Url</a>");
		} else {
			$(this).parent().html($(this).val().trim());
		}
			
		$(".thVal").remove();
	});
	if(value.indexOf('<a')>=0){
		value = jQuery(value).attr('href');
	}
    $(currentEle).html('<input class="thVal" type="text" value="' + value + '" />');
    $(".thVal").focus();
    $(".thVal").keyup(function (event) {
        if (event.keyCode == 13) {
			_pObject = $(this).parent().parent();
			if(urlregex.test($(this).val().trim())){
				$(this).parent().html("<a href='"+$(this).val().trim()+"' target='_BLANK'>Url</a>");
			} else {
				$(this).parent().html($(this).val().trim());
			}
			/*$(this).parent().html($(this).val().trim());*/			
            $(".thVal").remove();
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'customers/update_pre_contacts',
				data:{id:_pObject.attr('data-i'),first_name:_pObject.find('td').eq(1).html(),last_name:_pObject.find('td').eq(2).html(),job_title:_pObject.find('td').eq(3).html(),company:_pObject.find('td').eq(4).html(),email:_pObject.find('td').eq(5).html(),phone:_pObject.find('td').eq(6).html(),telephone:_pObject.find('td').eq(7).html(),url:_pObject.find('td').eq(8).html(),t:_pObject.attr('data-attr')},
				cache:false,
				success:function(res){
					_pObject.find('td').eq(0).data('first',_pObject.find('td').eq(1).html());
					_pObject.find('td').eq(0).data('last',_pObject.find('td').eq(2).html());
					_pObject.find('td').eq(0).data('title',_pObject.find('td').eq(3).html());
					_pObject.find('td').eq(0).data('company',_pObject.find('td').eq(4).html());
					_pObject.find('td').eq(0).data('email',_pObject.find('td').eq(5).html());
					_pObject.find('td').eq(0).data('phone',_pObject.find('td').eq(6).html());
					_pObject.find('td').eq(0).data('telephone',_pObject.find('td').eq(7).html());
					_pObject.find('td').eq(0).data('url',_pObject.find('td').eq(8).html());
					window.parent.open_prefined_listResize();
					window.parent.myProfileResize(); 
				}
			});
        }
    });
	jQuery('#db_from_litigation').find("tbody").find("tr>td").off('dblclick').on('dblclick',function(e){
		e.stopPropagation();
        var currentEle = $(this);
		console.log(currentEle.html());
        var value = $(this).html();
		if($(this).find('span').length>0){
			var value = $(this).find('span').html();
		}
		if($(this).find('textarea.thVal').length==0){
			updateVal(currentEle, value);
		}
        
	});
}
function refreshCompanyList(){jQuery.ajax({type:'POST',url:__baseUrl+'users/company_list',cache:false,success:function(d){if(d!=""){_d = jQuery.parseJSON(d);if(_d.length>0){_option='<option value=""></option>';for(i=0;i<_d.length;i++){_option+='<option value="'+_d[i].id+'">'+_d[i].company_name+'</option>';}if(_option!=""){jQuery("#inviteeCompanyId").html(_option);}}}}});}
function openAddForm(){
	window.parent.openCompanyEdit(0);
}
_step=0;
allContactsAddArray = [];
function addPreToContact(t){
	jQuery("#wait_message").html('Please wait....');
	_getAllDataSource = hot1.getSourceData();
	company_id = '';
	if(jQuery('#inviteeCompanyId').val()!=""){
		company_id = jQuery('#inviteeCompanyId').val();
	}
	_process = true;
	if(t==0){
		if(company_id==""){
			_process  =  false;
			alert("Please select company from the dropdown list");
		}
	} else if(t==1){
		company_id = "";
	}
	if(_process===true){
		jQuery.each(_getAllDataSource,function(ind,contact){
			if(contact.selected=="yes"){
				var invitee = {};
				invitee['job_title'] = contact.job_title;
				invitee['first_name'] = contact.first_name;
				invitee['last_name'] = contact.last_name;
				invitee['telephone'] = contact.telephone;
				invitee['address'] = '';
				invitee['phone'] = contact.cellphone;
				invitee['email'] = contact.email;
				invitee['web_address'] = '';
				invitee['linkedin_url'] = contact.profile_url;
				invitee['twitter'] = '';
				invitee['fullcontact'] = '';
				invitee['img_card'] = contact.img_card;
				invitee['proximity'] = contact.proximity;
				invitee['c_c'] = contact.c_c;
				invitee['street']= '';
				invitee['city'] = '';
				invitee['state'] = '';
				invitee['zip'] = '';
				invitee['country'] = '';
				invitee['note'] = '';
				invitee['company_id']=company_id;
				invitee['company_name']=contact.company_name;
				invitee['id']=0;
				invitee['pre_id']= contact.id;
				allContactsAddArray.push(invitee);
			}
		});
	
		if(allContactsAddArray.length>0){			
			startAddContacts(0,t);
		} else {
			alert("No contact selected.");
		}
	}
	
}


function startAddContacts(index,t){
	jQuery('#wait_message').find('p').addClass('alert-warning').html('Please wait while system importing pre-contacts to contacts');
	if(typeof allContactsAddArray[index]!="undefined"){
		invitee = allContactsAddArray[index];
		if(invitee.company_id=="" && _step==0 && t==1){
			resp = confirm('Are you sure you want to move this contact with new company?');
			_step =1;
		} else {
			resp = true;
		}
		if(resp ==true){
			jQuery.ajax({
				type:"POST",
				url:__baseUrl+"opportunity/insertDataInBulkOneByOne",
				dataType:'json',
				data:{invitee:invitee},
				cache:false,
				success:function(b){
					if(b.id>0){
						_getAllDataSource = hot1.getSourceData();
						jQuery.each(_getAllDataSource,function(ind,contact){
							if(contact.id==invitee.id){
								_getAllDataSource.splice(ind,1);
								return;
							}
						});
						hot1.loadData(_getAllDataSource);
						/*_s=1;
						_obj = $('input[type=checkbox][value='+b.pre_id+']');
						_obj.val(b.id);
						_obj.prop('checked',false);
						_obj.parents('tr').attr('data-i',b.id).attr('data-attr','contact').css('color','#000');*/
						next = index + 1;
						startAddContacts(next);
					}
				},error:function(){
					next = index + 1;
					startAddContacts(next);
				}
			});
		}
	} else {
		jQuery('#wait_message').find('p').addClass('alert-warning').html('Importing pre-contacts to contacts done successfully.');
		setTimeout(function(){
			jQuery('#wait_message').toggle();
		},1000);
		refreshCompanyList();
		jQuery('#inviteeCompanyId').val('');
		location.reload();
	}
}

function startCheck(){
	_ls = setInterval(function(){
		if(jQuery.active==0){
			_step=0;
			jQuery('#wait_message').find('p').removeClass('alert-warning').html('Contact added successfully.');
			window.parent.document.getElementById("contactFormIframe").contentWindow.location.reload();
			jQuery('#wait_message').toggle();
			clearInterval(_ls);
		}
	},1000);
}

function removeDuplicateContact(o,t,ID){
	if(t==0){
		jQuery.ajax({
		type:'POST',
		url:__baseUrl+'leads/remove_precontacts',
		data:{id:ID},
		success:function(d){
			if(parseInt(d)>0){
				o.parents('tr').remove();
			} else {
				alert("Please try after some time.");
			}
		}
	})
	} else {
		alert("Cannot delete data from contacts");
	}
}

function removeContact(o,ID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'leads/deleteContact',
		data:{id:ID},
		dataType:'json',
		success:function(d){
			if(d.status>0){
				_scrollTop = $('#db_from_litigation_wrapper .dataTables_scrollBody').scrollTop();
			___table.row( o.parents('tr') ).remove().draw();
			setTimeout(function(){
				$('#db_from_litigation_wrapper .dataTables_scrollBody').scrollTop(_scrollTop);
			},500);
			} else {
				alert(d.message);
			}
		}
	})
}
function deletePreContact(){
	if(jQuery('input[name="contact_id"]').is(':checked')){
		removePreContact(jQuery('input[name="contact_id"]:checked'),jQuery('input[name="contact_id"]:checked').val());
		
	} else {
		alert("Please select contact for delete");
	}
}
_scrollTop = 0;
function deleteAllPreContacts(){
	jQuery.ajax({
		url:__baseUrl+'leads/delete_all_precontacts',
		success:function(res){
			location.reload();
		}
	});
}
function removePreContact(o,preContactID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'leads/remove_precontacts',
		data:{id:preContactID},
		success:function(res){
			_scrollTop = $('#db_from_litigation_wrapper .dataTables_scrollBody').scrollTop();
			___table.row( o.parents('tr') ).remove().draw();
			setTimeout(function(){
				$('#db_from_litigation_wrapper .dataTables_scrollBody').scrollTop(_scrollTop);
			},500);
			/*jQuery('table#db_from_litigation>tbody>tr[data-i="'+preContactID+'"]').remove();
			window.parent.jQuery("#predefineFormIframe").attr('src',__baseUrl+'leads/pre_contacts/1');
			___table.Draw(true);*/
		}
	});
}
</script>