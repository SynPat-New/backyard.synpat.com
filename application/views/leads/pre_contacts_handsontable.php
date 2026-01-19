<style> 
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;
	}
	#page-content {
	    background: #ffffff !important;
	}

</style>
<script>
function findDuplicate(){
	window.location = __baseUrl+'leads/pre_contacts/2';
}



function checkCompanyPop(o){
	if(jQuery("#db_from_litigation").find('input[type="checkbox"]').is(":checked")===false){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'dashboard/find_contacts_in_company',
			data:{c:o.val()},
			cache:false,
			success:function(d){
				html = "";
				if(d!=""){
					_list = jQuery.parseJSON(d);
					html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
									if(_list.length>0){
										for(i=0;i<_list.length;i++){
											name = _list[i].first_name + " "+_list[i].last_name;
									html+="<tr>"+
										"<td><a href='javascript://' onclick='window.parent.editContact("+_list[i].id+");'>"+name+"</a></td>"+
										"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_list[i].phone+"\"))'>"+_list[i].phone+"</a></td>"+
										"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_list[i].telephone+"\"))'>"+_list[i].telephone+"</a></td>"+
									"</tr>"; 
								
										}
									}
								
							html+="</tbody></table>";
				}
				jQuery("#cUsers").html(html);
				jQuery("#modal_c_users").modal("show");
			}
		});
	}
}
</script>
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
<h4>Import new contacts</h4>
<div class='col-lg-12'>
<div class="row" style='margin-bottom:10px;'>
<?php 
	$companies = getAllCompanies();
?>
<div class='col-xs-12'>To import a list of contacts to the database: 1) Copy the list to the table below in the right columns. 2) Compare the new contacts to those already in the database: <a style='width:100px;display:inline-block;' href='javascript://' onclick="addSheettoPreContacts()" class='btn btn-primary btn-block mrg5R'>Compare</a> 3) In the table below delete red people that already exist in the database 4) Import the red people to the database by either:<br/>1) Selecting one or more persons and select a company to be associated with: <select class="" id="inviteeCompanyId" name="invitee[company_id]" onchange="checkCompanyPop(jQuery(this))" class="form-control" style='width:150px;'><?php 												
					if(count($companies)>0){
					?>
					<option value=''></option>
					<?php
						foreach($companies as $company){
				?> <option data-b='<?php echo $company->sectorID?>' data-bn='<?php echo $company->sectorName?>' value="<?php echo $company->id;?>"><?php echo $company->company_name;?></option> <?php
						}
					}
				?> </select> and click <a style='width:100px;display:inline-block;' href='javascript://' onclick="addPreToContact()" class='btn btn-primary btn-block mrg5R'>Add Contact</a> To add a new company to the dropdownlist click: <a href='javascript://' onclick="openAddForm()" class='btn btn-primary btn-block mrg5R' style='width:100px;display:inline-block;'>Add a company</a><br/>
2) Selecting the contact double click the company name edit it, press Enter and click <a style='width:100px;display:inline-block;' href='javascript://' onclick="addPreToContact()" class='btn btn-primary btn-block mrg5R'>Add Contact</a><br/>
To import contacts from Google Contacts: <a style='' href='javascript://' onclick="window.parent.openGoogleContacts()" class='btn btn-primary mrg5R' style='width:130px;display:inline-block;'>Import Google Contact</a><br/> To retrieve the most recent imported data that haven't been saved in the database click the "Compare" button above.  <span style='text-align:right'>To delete duplicates click  <a href='javascript://' class='btn btn-primary btn-block mrg5R' style='width:100px;display:inline-block;' onclick='findDuplicate();'>Find Duplicates</a> and then click <a href='javascript://' onclick='deleteDuplicate();' class='btn btn-primary btn-block mrg5R' style='width:155px;display:inline-block;'>Delete unchecked items</a><?php if((int)$showD ==1):?><a href='javascript://' onclick='selectNormalise();' class='btn btn-primary btn-block mrg5R' style='width:110px;display:inline-block;'>Select Normalise</a> <a href='javascript://' onclick='updateAllNormalise();' class='btn btn-primary btn-block mrg5R' style='width:135px;display:inline-block;'>Update All Normalise</a><?php endif;?></span></div>
		
</div>
<div class='col-xs-12 hide' id='frm_import'>
	
</div>
<div class="col-xs-12" id="wait_message" style='display:none;'>
	<p class='alert '></p>
</div>
<?php 
	if((int)$showD ==0):
?>
  <link  rel="stylesheet" media="screen" href="<?php echo $Layout->aws_server_cdn;?>assets/handsontable-master/dist/handsontable.css">
  <link  rel="stylesheet" media="screen" href="<?php echo $Layout->aws_server_cdn;?>assets/handsontable-master/dist/pikaday/pikaday.css">
  <script  src="<?php echo $Layout->aws_server_cdn;?>assets/handsontable-master/dist/pikaday/pikaday.js"></script>
  <script  src="<?php echo $Layout->aws_server_cdn;?>assets/handsontable-master/dist/moment/moment.js"></script>
  <script  src="<?php echo $Layout->aws_server_cdn;?>assets/handsontable-master/dist/zeroclipboard/ZeroClipboard.js"></script>
  <script  src="<?php echo $Layout->aws_server_cdn;?>assets/handsontable-master/dist/handsontable.full.js"></script>
<style>
	/*#paste_contacts{overflow:hidden !important;overflow-y:scroll !important;}*/
</style>
	<div id="paste_contacts" class="handsontable col-lg-12" style='height:400px;overflow:hidden !important;overflow-y:scroll !important;'></div>
	<script>
		width = window.parent.jQuery('#open_prefined_message').width();
		if(width>0){
			width = width-85;
		} else {
			width = 1200
		}
		var container = document.getElementById('paste_contacts'),handObj;
		/*jQuery("#paste_contacts").css('width',width+'px');
		jQuery("#paste_contacts").handsontable({
		stretchH: "all",
		scrollH: 'hidden',
		height:400,
		startRows:1,
		autoWrapRow: true,
		rowHeaders: false,
		minSpareCols:0,minSpareRows:1,
		columns:[{},{},{},{}],
		colHeaders: [    
			"First Name",
			"Last Name",
			"Company",
			"Title",
		]
});*/
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
							"LinkedIn Url",
							"Telephone",
							"Mobile Phone"
						],
					  columns:[{},{},{},{},{},{},{},{}],
					  height:400,
					  startRows:1,
					  minSpareRows: 1,
					  minSpareCols:0,
					  width:width,
					  stretchH:"all",
					  contextMenu: false,
				});
		setTimeout(function(){
			width = width - 20;
			jQuery('.handsontable table.htCore').css('width',width+'px');
		},500)
	</script>
<?php 
	elseif($showD==2):
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
				var value = $(this).find('span').html();
				updateAnotherVal(currentEle, value);
			});
		});
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
			$(currentEle).html('<input class="thVal" type="text" value="' + value + '" />');
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
								$(this).parent().find('span').html("<a href='"+$(this).val().trim()+"' target='_BLANK'>Url</a>");
								console.log('ds1');
							} else {
								$_this = $(this).parent();
								$(this).parent().html("<span class='span_draggable'><a href='"+$(this).val().trim()+"' target='_BLANK'>Url</a></span>");
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
									field[fieldName] = jQuery(this).data('field-val');
								}else if(fieldName=="profile_url"){
									field[fieldName] = jQuery(this).data('field-val');
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
				updateAnotherVal(currentEle, value);
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
					<td data-field="id"><input type='checkbox' name='delete_contact[]' data-tap='<?php echo $lit->contact_id;?>' data-type='<?php echo $lit->contact_type;?>' value="<?php echo $lit->contact_id;?>"/><a href='javascript://' onclick="removeContact(jQuery(this),<?php echo $lit->id?>)"><img src="<?php echo $Layout->aws_server_cdn;?>images/discard.png"/></a></td>
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
						if($lit->linkedin_url!=""){
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
<?php 
	
	elseif($showD ==1):
?>
<script>
	_mainCompanySelected=0;
	_mainCompanyType = "";
	function selectNormalise(){
		if(jQuery('input[type="checkbox"]:checked').length==1){
			_mainCompanySelected = jQuery('input[type="checkbox"]:checked').val();
			_mainCompanyType = jQuery('input[type="checkbox"]:checked').parents('tr').data('attr');
			jQuery('input[type="checkbox"]:checked').prop('checked',false);
		}
	}
	function updateAllNormalise(){
		allList = [];
		jQuery('input[type="checkbox"]:checked').each(function(){
			updateDT = {};
			updateDT.id = jQuery(this).val();
			updateDT.type = jQuery(this).parents('tr').data('attr');
			allList.push(updateDT);
		});
		if(allList.length>0){
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'leads/normalise_all_selected_data',
				data:{send_data:JSON.stringify(allList),selected_company:_mainCompanySelected,selected_type:_mainCompanyType},
				dataType:'json',
				success:function(d){
					/*console.log(d);
					window.location = __baseUrl+'leads/pre_contacts/1';*/
					_mainCompanySelected=0;
					_mainCompanyType = "";
					if(d.status>0){
						companyName = jQuery('#db_from_litigation').find('tr[data-i="'+_mainCompanySelected+'"]').find('td').eq(4).html();
						for(s=0;s<allList.length;s++){
							if(jQuery('#db_from_litigation').find('tr[data-i="'+allList[s].id+'"]').length>0){
								jQuery('#db_from_litigation').find('tr[data-i="'+allList[s].id+'"]').find('input[type="checkbox"]').prop('checked',false);
								jQuery('#db_from_litigation').find('tr[data-i="'+allList[s].id+'"]').find('td').eq(4).html(companyName);
							}
						}
						allList = [];
					} else {
						alert("System not able to normalise,Please try after sometime.");
					}										
				}
			});
		}
	}
</script>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="db_from_litigation" >
	<thead>
		<tr>     
			<th>#</th>
			<th>First Name</th>  
			<th>Last Name</th> 
			<th>Job Title</th>  
			<th>Company</th>  
			<th>Email</th>  
			<th>Cell Phone</th>  
			<th>Telephone</th>  
			<th>Url</th>  
			<th>Img Card</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($pre_contacts)>0){
				foreach($pre_contacts as $lit){					
		?>
				<tr data-i="<?php echo $lit->id;?>" style='color:#ff0000;' data-attr="pre-contact">
					<td data-first='<?php echo $lit->first_name?>' data-last='<?php echo $lit->last_name?>' data-title='<?php echo $lit->job_title?>' data-company='<?php echo $lit->company_name?>' data-email='<?php echo $lit->email?>' data-shared='<?php echo $lit->c_c?>' data-url='<?php echo $lit->profile_url?>' data-address='<?php echo $lit->address?>' data-phone='<?php echo $lit->cellphone?>' data-telephone='<?php echo $lit->telephone?>' data-twitter='<?php echo $lit->twitter?>' data-fullcontact='<?php echo $lit->fullcontact?>' data-card='<?php echo $lit->img_card?>'><input name='contact_id[]' value='<?php echo $lit->id;?>' type="checkbox" /><a href='javascript://' onclick="removePreContact(jQuery(this),<?php echo $lit->id?>)"><img src="<?php echo $Layout->aws_server_cdn;?>images/discard.png"/></a></td>
					<td><?php echo $lit->first_name?></td>
					<td><?php echo $lit->last_name?></td>
					<td><?php echo $lit->job_title?></td>
					<td><?php echo $lit->company_name?></td>
					<td><?php echo $lit->email?></td>
					<td><?php echo $lit->cellphone?></td>
					<td><?php echo $lit->telephone?></td>
					<td><?php 
						if($lit->profile_url!=""){
						?>
							<a href="<?php echo $lit->profile_url?>" target="_BLANK">Link</a>
						<?php
						}?>
					</td>					
					<td><?php 
						if($lit->img_card!=""){
							try{
								$images = json_decode($lit->img_card);
								if(count($images)>0):
								foreach($images as $img){
						?> 
								<a target="_BLANK" href="<?php echo $img?>"><img src="<?php echo $img;?>" width="50px"/></a>
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
			if(count($contacts)>0){
				foreach($contacts as $lit){
		?>
					<tr data-i="<?php echo $lit->id;?>" style='color:#000;' data-attr="contact">
					<td data-first='<?php echo $lit->first_name?>' data-last='<?php echo $lit->last_name?>' data-title='<?php echo $lit->job_title?>' data-company-id='<?php echo $lit->companyID;?>' data-company='<?php echo $lit->company_name?>' data-email='<?php echo $lit->email?>' data-url='<?php echo $lit->linkedin_url?>' data-address='<?php echo $lit->address?>' data-phone='<?php echo $lit->phone?>' data-telephone='<?php echo $lit->telephone?>' data-twitter='<?php echo $lit->twitter?>' data-fullcontact='<?php echo $lit->fullcontact?>' data-card='<?php echo $lit->img_card?>'><input name='contact_id[]' value='<?php echo $lit->id;?>' type="checkbox" /><a href='javascript://' onclick="removeContact(jQuery(this),<?php echo $lit->id?>)"><img src="<?php echo $Layout->aws_server_cdn;?>images/discard.png"/></a></td>
					<td><?php echo $lit->first_name?></td>
					<td><?php echo $lit->last_name?></td>
					<td><?php echo $lit->job_title?></td>
					<td><?php echo $lit->company_name?></td>
					<td><?php echo $lit->email?></td>
					<td><?php echo $lit->phone?></td>
					<td><?php echo $lit->telephone?></td>
					<td><?php 
						if($lit->linkedin_url!=""){
						?>
							<a href="<?php echo $lit->linkedin_url?>" target="_BLANK">Link</a>
						<?php
						}?>
						</td>
					<td><?php 
						if($lit->img_card!=""){
							try{
								$images = json_decode($lit->img_card,true);
								if(count($images)>0):
								foreach($images as $img){
						?> 
								<a target="_BLANK" href="<?php echo $img?>"><img src="<?php echo $img;?>" width="50px"/></a>
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
<?php endif;?>

</div>
<script>
function openFormFields(){
	jQuery('#frm_import').toggle();
	window.parent.open_drive_files('https://docs.google.com/spreadsheets/d/1dNMAIvMuSBZRccQtFuScNL5HPFp4-TUF3ECutIC3iPw/edit#gid=821660973');
}
function addSheettoPreContacts(){
	_data = objHands.getData();
	jQuery('.loader_import_file').removeClass('hide').addClass('show');
	jQuery.ajax({
		url:__baseUrl+'leads/contact_import_from_table_in_precontacts',
		type:'POST',
		data:{contacts:JSON.stringify(_data)},
		cache:false,
		success:function(d){
			jQuery('.loader_import_file').addClass('hide').removeClass('show');
			window.parent.jQuery("#predefineFormIframe").attr('src',__baseUrl+'leads/pre_contacts/1');
			/*window.parent.document.getElementById('predefineFormIframe').src = window.parent.document.getElementById('predefineFormIframe').src+'1';*/
			if(d>0){				
				/*window.parent.document.getElementById('predefineFormIframe').contentWindow.location.reload();*/
			}
		}
	});
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
var pageScrollPos = 0;
	var ___table,___tablePre, ___tableSca ;
	jQuery(document).ready(function(){
		___table = $('#db_from_litigation')
			.DataTable({								
				"searching":true,
				"autoWidth": true,
				"paging": false,
				// "sScrollY": _h+"px",
				"sScrollY": 100,
				"sScrollX": "100%",
				"sScrollXInner": "100%",
				 "order": [[ 4, "asc" ]],
				 "preDrawCallback": function (settings) {
					pageScrollPos = $('body').scrollTop();
				  },
				  "drawCallback": function (settings) {
					$('body').scrollTop(pageScrollPos);
				  }
			});
			___tablePre = $('#db_from_free_litigation')
			.DataTable({								
				"searching":false,
				"autoWidth": true,
				"paging": false,
				// "sScrollY": _h+"px",
				"sScrollY": 100,
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			}); 
			
			/*___tableSca = $('#db_drive_scanner')
			.DataTable({								
				"searching":false,
				"autoWidth": true,
				"paging": false,
				// "sScrollY": _h+"px",
				"sScrollY": 100,
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			});*/
			/*

			$('#db_from_litigation thead th:eq(1)').unbind('click').click(function(){
			var aaSorting = ___table.fnSettings().aaSorting;
			if( aaSorting[0][0] !=2 || aaSorting[0][1] == 'desc'){
				___table.fnSort( [[1,'asc'], [2,'asc']]);
			}else{
				___table.fnSort( [[1,'desc'], [2,'asc']]);
			}
			});

			*/
			
			
	});


	window.resizeDataTable = function(height) {
		/*h = height/2;*/
		h = height;
		$('#db_from_litigation_wrapper .dataTables_scrollBody').height(h - 60);
		/*$('#db_from_free_litigation_wrapper .dataTables_scrollBody').height(h - 60);*/
		/*$('#db_drive_scanner_wrapper .dataTables_scrollBody').height(h - 60);*/
	}

	$(function() {
		parent.open_prefined_listResize();
	})

setTimeout(function(){ window.parent.open_prefined_listResize();
	window.parent.myProfileResize(); }, 1000);
jQuery(document).ready(function(){
	window.parent.open_prefined_listResize();
	window.parent.myProfileResize();
	jQuery('#db_from_litigation').find("tbody").find("tr>td").dblclick(function(e){
		console.log('asd1');
		e.stopPropagation();
        var currentEle = $(this);
        var value = $(this).html();
        updateVal(currentEle, value);
	});
});
jQuery(window).load(function(){
	window.parent.open_prefined_listResize();
	window.parent.myProfileResize();
});



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
        var value = $(this).html();
        updateVal(currentEle, value);
	});
}
function refreshCompanyList(){jQuery.ajax({type:'POST',url:__baseUrl+'users/company_list',cache:false,success:function(d){if(d!=""){_d = jQuery.parseJSON(d);if(_d.length>0){_option='<option value=""></option>';for(i=0;i<_d.length;i++){_option+='<option data-b="'+_d[i].sectorID+'" data-bn="'+_d[i].sectorName+'" value="'+_d[i].id+'">'+_d[i].company_name+'</option>';}if(_option!=""){jQuery("#inviteeCompanyId").html(_option);}}}}});}
function openAddForm(){
	window.parent.jQuery("#ccompanyFormSubmit").get(0).reset();
	window.parent.jQuery("#ccompanyFormSubmit").find("#companyId").val("");
	window.parent.jQuery("#ccompanyFormSubmit").find("#marSector").find("option").removeAttr("selected");
	window.parent.jQuery("#addCCompanyForm").css('z-index','9999');
	window.parent.jQuery(".multi-select").multiSelect('refresh');
	window.parent.jQuery(".ms-container").append('<i class="glyph-icon icon-exchange"></i>');
	window.parent.jQuery("#company_users_show_table").empty();
	window.parent.jQuery("#addCCompanyForm").modal("show");
}
_step=0;
function addPreToContact(){
	var iframe = window.parent.$('#companyFormIframe').contents();
	/*if(iframe.find('input[name="vendor_select"]').is(':checked')){*/
	company_id = ''
	if(jQuery('#inviteeCompanyId').val()!=""){
		company_id = jQuery('#inviteeCompanyId').val();
	}		
	if(jQuery('input[name="contact_id[]"]').is(':checked')){
		_s=0;
		jQuery('#wait_message').find('p').addClass('alert-warning').html('Please wait while system importing pre-contacts to contacts');
		setTimeout(function(){
			jQuery('#wait_message').toggle();
		},500);
		jQuery('input[name="contact_id[]"]:checked').each(function(index){
			inputObject = jQuery(this);
			firstName = inputObject.parent().attr('data-first');
			lastName = inputObject.parent().attr('data-last');
			jobTitle = inputObject.parent().attr('data-title');
			email = inputObject.parent().attr('data-email');
			linked_in = inputObject.parent().attr('data-url');
			address = inputObject.parent().attr('data-address');
			telephone = inputObject.parent().attr('data-telephone');
			phone = inputObject.parent().attr('data-phone');
			twitter = inputObject.parent().attr('data-twitter');
			fullcontact = inputObject.parent().attr('data-fullcontact');
			card = inputObject.parent().attr('data-card');
			company_name = inputObject.parent().attr('data-company');
			var invitee = {};
			invitee['job_title'] = jobTitle;
			invitee['first_name'] = firstName;
			invitee['last_name'] = lastName;
			invitee['telephone'] = telephone;
			invitee['address'] = address;
			invitee['phone'] = phone;
			invitee['email'] = email;
			invitee['web_address'] = '';
			invitee['linkedin_url'] = linked_in;
			invitee['twitter'] = twitter;
			invitee['fullcontact'] = fullcontact;
			invitee['img_card'] = card;
			invitee['street']= '';
			invitee['city'] = '';
			invitee['state'] = '';
			invitee['zip'] = '';
			invitee['country'] = '';
			invitee['note'] = '';
			invitee['company_id']=company_id;
			invitee['company_name']=company_name;
			if(inputObject.parent().parent().attr('data-attr')=='contact'){
			 invitee['id']= inputObject.parent().parent().attr('data-i');
			 invitee['pre_id']= 0;
			} else {
			 invitee['id']=0;
			 invitee['pre_id']= inputObject.parent().parent().attr('data-i');
			}
			resp = false;
			if(company_id=='' && _step==0){
				resp = confirm('Are you sure you want to move this contact with new company?');
				_step =1;
			} else {
				resp = true;
			}
			if(resp ==true){
				jQuery.ajax({type:"POST",url:__baseUrl+"opportunity/insertDataInBulkOneByOne",dataType:'json',data:{invitee:invitee},cache:false,success:function(b){if(b.id>0){_s=1;removePreContact(jQuery(this),b.pre_id);
				_obj = $('input[type=checkbox][value='+b.pre_id+']');
				_obj.parent().parent().attr('data-i',b.id).attr('data-attr','contact').css('color','#000');_obj.remove();
				if(company_id==''){   refreshCompanyList();}jQuery('#inviteeCompanyId').val('');
				}}});
			}
		});		
		startCheck();
	} else {
		alert("Please select contact to move.");
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