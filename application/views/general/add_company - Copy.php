<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>nestable.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<style>
	body {
		overflow: auto !important;overflow-x:hidden !important;
		min-width: 0;
		width: 100% !important;font-size:13px;font-family:arial;margin:0px;
	}
	
	</style>
<script>
__baseUrl = '<?php echo $Layout->baseUrl?>';
function checkSector(a,f){jQuery("#preferenceDepartments").find("option").remove();jQuery("#tbl_preferenceDepartments").find('tbody').html('');jQuery("#tbl_subDepartments").find('tbody').html('');if(a>0){jQuery.ajax({type:"POST",url:__baseUrl+"customers/find_departments",data:{s:a,c:jQuery('#companyId').val()},cache:false,success:function(b){if(b!=""){_data=jQuery.parseJSON(b);if(_data.dep.length>0){for(i=0;i<_data.dep.length;i++){_selected='';_checked='';if(_data.c_d.length>0){for(cd=0;cd<_data.c_d.length;cd++){if(_data.c_d[cd].preference_id==_data.dep[i].id){_selected='selected="selected"';_checked='CHECKED="CHECKED"';}}}jQuery("#preferenceDepartments").append("<option "+_selected+" value='"+_data.dep[i].id+"'>"+_data.dep[i].name+"</option>");jQuery("#tbl_preferenceDepartments").find('tbody').append("<tr><td><input type='checkbox' onclick=\"updateVal('preferenceDepartments',jQuery(this))\" value='"+_data.dep[i].id+"' "+_checked+" name='categories[]'/> "+_data.dep[i].name+"</td></tr>");}if(f==1){findMySubDeptt(jQuery("#preferenceDepartments"));}} }}})}}
function findMySubDeptt(a){jQuery("#subDepartments").find("option").remove();jQuery("#tbl_subDepartments").find('tbody').html('');_selectCategories = []; a.find('option').each(function(){if(jQuery(this).is(':selected') && jQuery(this).val()!=''){_selectCategories.push(jQuery(this).val())}});if(_selectCategories.length>0){jQuery.ajax({type:"POST",url:__baseUrl+"customers/find_sub_deptt",data:{s:a.val(),c:jQuery('#companyId').val()},cache:false,success:function(b){if(b!=""){_data=jQuery.parseJSON(b);console.log(_data.dep);if(_data.dep.length>0){for(i=0;i<_data.dep.length;i++){
	_selected='';_checked='';if(_data.c_d.length>0){for(cd=0;cd<_data.c_d.length;cd++){if(_data.c_d[cd].preference_id==_data.dep[i].id){_selected='selected="selected"';_checked='CHECKED="CHECKED"';}}}console.log(_data.dep[i].name);jQuery("#subDepartments").append("<option value='"+_data.dep[i].id+"' "+_selected+">"+_data.dep[i].name+"</option>");jQuery("#tbl_subDepartments").find('tbody').append("<tr><td><input type='checkbox' value='"+_data.dep[i].id+"' "+_checked+" onclick=\"updateVal('subDepartments',jQuery(this))\" name='subcategories[]'/> "+_data.dep[i].name+"</td></tr>");console.log(jQuery("#tbl_subDepartments").find('tbody').html());
	}}}}})}}
function updateVal(t,o){
	jQuery("#"+t).find("option").prop("selected",false);
	jQuery("#tbl_"+t).find("input[type='checkbox']:checked").each(function(){
		_itemChecked = jQuery(this).val();
		console.log(_itemChecked);
		jQuery("#"+t).find("option").each(function(index){
			console.log("A"+jQuery(this).val()+"B:"+_itemChecked);
			if(jQuery(this).val()==_itemChecked){
				console.log("asdsad");
				jQuery("#"+t).find("option").eq(index).prop("selected",true);
			}
		})
	})
	if(t=="preferenceDepartments"){
		findMySubDeptt(jQuery("#preferenceDepartments"));
	} 
}
function changeCompanySector(o){
	jQuery("#companySector").val(o.val());
	checkSector(o.val(),0);
}
function linkedInSearch(){
	_companyName = jQuery("#companyJobTitle").val();
	urlString = "";
	if(_companyName!=""){
		urlString = "https://www.linkedin.com/vsearch/p?company="+_companyName+"&openAdvancedForm=true&companyScope=C&locationType=Y&orig=ADVS&sa=D&sntz=1";
		window.open(urlString,'_blank');
	} else {
		alert("Company name is blank");
	}	
}

function widthChange(){
	jQuery('.input-string-group').each(function(){
		_w = jQuery(this).width();
		if(jQuery(this).find('.control-label').length>0){
			lbl = jQuery(this).find('.control-label').width();
			if(jQuery(this).find('input[type="text"]').length>0){
				inputW = _w - lbl-12;
				jQuery(this).find('input[type="text"]').css('width',inputW+'px');
			}
		}
	})
}

jQuery(document).ready(function(){
	widthChange()
})
jQuery(window).resize(function(){
	widthChange()
})
</script>
<?php 
	$company_name = "";
	$web_address = "";
	$state = "";
	$city = "";
	$company_name_alias = "";
	$postal_code = "";
	$telephone = "";
	$email = "";
	$contractor = "";
	$broker = 0;
	$broker_details = array();
	$company_address = "";
	$linkedin_url = "";
	$country = "";
	$sectorID = "0";
	$departments_list = array();
	$categories = array();
	$subdepartments_list = array();
	$sub_categories = array();
	$brokerFirm="";
	$brokerName="";
	$id = $companyID;
	$companyUsers = array();
	if(count($company)>0){
		$company_name = $company->company_name;
		$web_address = $company->web_address;
		$state = $company->state;
		$city = $company->city;
		$email = $company->email;
		$company_name_alias = $company->company_name_alias;
		$postal_code = $company->postal_code;
		$telephone = $company->telephone;
		$contractor = $company->contractor;
		$broker = $company->broker;
		$broker_details = $company->broker_details;
		if(count($broker_details)>0){
			$brokerFirm = $broker_details->company_name;
			$brokerName = $broker_details->first_name." ".$broker_details->last_name;
		}
		$company_address = $company->company_address;
		$linkedin_url = $company->linkedin_url;
		$country = $company->country;
		$sectorID = $company->sectorID;
		$categories = $company->categories;
		$departments_list = $company->departments_list;
		$subdepartments_list = $company->subdepartments_list;
		$sub_categories = $company->sub_categories;
		$companyUsers = $company->companyUsers;
	}
?>
<script>
	jQuery(document).ready(function() {
    jQuery('#table_list_user').DataTable( {
        fixedHeader: true,
		searching:false,
		paging:false,
		deferRender:    true,
        scrollY:        500,
        scrollCollapse: true,
        scroller:       true
    } );
	jQuery("#ccompanyFormSubmit").submit(function(e){
		e.preventDefault();
		jQuery.ajax({
			type:'POST',
			url:jQuery("#ccompanyFormSubmit").attr("action"),
			data:jQuery("#ccompanyFormSubmit").serializeArray(),
			dataType:'json',
			success:function(d){
				if(typeof d.success!="undefined" && d.success>0){
					/*alert("Record updated");*/
					/*Close Slider*/
					window.parent.closeSlideBarCompany();
				}else  {
					if(typeof d.error_message!="undefined" && d.error_message!=""){
						alert(d.error_message);
					} else {
						alert("Please try after sometime.");
					}
				}
			}
		})
	})
	
} );
</script>
<style>
table.dataTable thead th, table.dataTable tfoot th{font-weight:normal;}
.nested-list-item .dd-handle {
    width: 22px;
    padding-left: 3px;
    background: none !IMPORTANT;
    border: 0;
    padding-right: 0;
}
div.nested-list-content .listbox{
	display: inline;
    margin-left: 10px;
    line-height: 10px;
}
div.nested-list-content {
    font-weight: normal;
    background: none;
    border: 0;
    border-bottom: 1px solid rgba(204, 204, 204, 0.2);
    padding-left: 25px;
}
</style>
<?php echo form_open('opportunity/add_company/'.$companyID,array('class'=>"form-flat",'id'=>'ccompanyFormSubmit', 'style'=>'margin-left:2px; margin-right:-10px;'));?>
<div class="row">
	<div class="col-xs-12">
		<h4 class="modal-title pull-left" id="createContactModalLabel" style="width:100%;height:30px">Company</h4>
		<div class="col-lg-12"><button type="submit" id="buttonADDCCompany" class="btn btn-primary btn-mwidth">Save</button> <button type="button" onclick="window.parent.getSectorsPage();" id="btnManageCategories" class="btn btn-primary btn-mwidth">Manage Categories</button>
		<button type="button" onclick="linkedInSearch();" id="btnManageCategories" class="btn btn-primary btn-mwidth">LinkedIn Search</button>	
		<button type="button" onclick="window.parent.openContactBoxForSelectedCompany(<?php echo $companyID?>,'<?php echo $company_name?>');" id="" class="btn btn-primary btn-mwidth">Add Contact</button>
		</div>
	</div>
</div>
<div class="row"><?php if($companyID!=0):?> <div class="col-xs-5"> <?php else:?> <div class="col-xs-12"><?php endif;?>
 <div class="row"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Company Name:</label> <input type="text" name="company[company_name]" id="companyJobTitle" value="<?php echo $company_name?>" class="form-control" placeholder=""/> </div> </div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Short version for mail:</label> <input type="text" name="company[company_name_alias]" id="companyCompanyNameAlias" class="form-control" placeholder="" value="<?php echo $company_name_alias?>"/><input type="hidden" name="company[postal_code]" id="companyZip" class="form-control" placeholder="" value="<?php echo $postal_code?>"/> </div> </div> </div>
<div class="row"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Web address:</label> <input type="text" name="company[web_address]" id="companyWebAddress" class="form-control" placeholder="" value="<?php echo $web_address?>"/><input type="hidden" name="company[state]" id="companyState" class="form-control" placeholder="" value="<?php echo $state?>"/> </div> </div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Telephone:</label> <input type="text" name="company[telephone]" id="companyTelephone" class="form-control" placeholder="" value="<?php echo $telephone?>"/> </div> </div>
  </div> 
 <div class="row"> 
 <div class="col-xs-12"> <div class="form-group"> <label class="control-label">Contractor:</label> <input type="checkbox" name="company[contractor]" id="companyContractor" value="1" style="text-align: left;margin-top: 10px;"/> </div> </div> </div> 
 <div class="row"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label"><a href='javascript://' onclick='if(typeof window.parent.openCompanyBrokerFirm=="function"){window.parent.openCompanyBrokerFirm();} else {window.parent.parent.openCompanyBrokerFirm();}'>Broker:</a></label><input type="text"  id="companyBrokerName" class="form-control" placeholder="" value="<?php echo $brokerName;?>"/> <input type="hidden" name="company[broker]" id="companyBroker" class="form-control" placeholder="" value="<?php echo $broker?>"/><input type="hidden" name="company[email]" id="companyEmail" class="form-control" placeholder="" value="<?php echo $email?>"/>
 </div> </div> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Broker Firm:</label> <input type="text"  id="companyBrokerFirm" class="form-control" placeholder="" value="<?php echo $brokerFirm?>"/> </div> </div> </div>
 <div class="row"> <div class="col-xs-12"> <div class="form-group input-string-group"> <label class="control-label">Street:</label> <input type="text" name="company[company_address]" value="<?php echo $company_address?>" id="inviteeStreet" class="form-control" placeholder=""/> </div> </div> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">City:</label> <input type="text" name="company[city]" id="companyCity" value="<?php echo $city?>" class="form-control" placeholder=""/> </div> </div> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Country/Region:</label> <input type="text" name="company[country]" value="<?php echo $country?>" id="companyCountry" class="form-control" placeholder=""/> </div> </div></div>
  </div>
  <?php if($companyID!=0):?>
<div class='col-xs-7'>
	<div class='col-md-12' id='company_users_show_table' style='margin-top:10px;padding-right:10px;'>
		<?php 
			if(count($companyUsers)>0){
		?>
			<table class="table" style='width:100%;' id="table_list_user">
				<thead><tr><th>Name</th><th>Title</th><th>Work</th><th>Mobile</th><th>Proximity</th><th>CC</th></tr></thead>
				<tbody>
					<?php 
						foreach($companyUsers as $user){
					?>
					<tr data-id="<?php echo $user->id?>">
					<td style='padding:5px;'><a href='javascript://' onclick='window.parent.editContact(<?php echo $user->id?>);'><?php echo $user->name?></a>&nbsp;&nbsp;<a href='javascript://' onclick='window.parent.deleteGoogleContactModal(<?php echo $user->id?>);'><i class='fa fa-trash colorClass' title='Companies'></i></a></td>
					<td style='padding:5px;'><?php echo $user->job_title?></td>
					<td align='center' style='padding:5px;'><?php if(trim($user->phone)!=''):?><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent("<?php echo $user->phone?>"))'><i class='fa fa-phone' style='color:green' title='Companies'></i></a><?php endif;?></td>
					<td align='center' style='padding:5px;'><?php if(trim($user->telephone)!=''):?><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent("<?php echo $user->telephone?>"))'><i class='fa fa-phone' style='color:#1E88E5' title='Companies'></i></a><?php endif;?></td>
					<td style='padding:5px;'><?php echo $user->proximity?></td>
					<td style='padding:5px;'><?php echo $user->c_c?></td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		<?php
			
			}
		?>
	</div>
</div>
 <?php endif;?>
</div> 
<div class="row" style='margin-top:10px;'>	
	<div class="col-sm-6">
		<div class="categorybtn "><button type='button' class='btn btn-primary ' onclick='createNewTypeBox()'>Create New Type</button></div>
		<div id="new_type_box" class="col-sm-12" style='margin-top:10px;display:none'>
			<input type="text" class='form-control' name="new_sector" id="new_sector" placeholder="Sector name"/>
			<a href='javascript://' class='btn btn-primary' style='margin-top:5px;' onclick='newSector()'>Create</a>
		</div>
		<div class='col-sm-12' style='padding:0px;' id='sector_nestable'>
			<div class="dd types" id="nestable1"><?php echo buildCompanySectorMenu($companyID);?></div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="categorybtn "><button type='button' class='btn btn-primary ' onclick='createNewBox()'>Create New Technology</button></div>
		<div id="new_cat_box" class="col-sm-12" style='margin-top:10px;display:none'>
			<input type="text" class='form-control' name="new_category" id="new_category" placeholder="Technology name"/>
			<a href='javascript://' class='btn btn-primary' style='margin-top:5px;' onclick='newCategory()'>Create</a>
		</div>
		<div class='cols-m-12' style='padding:0px' id='category_nestable'>
			<div class="dd categories" id="nestable"><?php echo buildCompanyCategoriesMenu($companyID);?></div>
		</div>
	</div>
	<div class="col-sm-12" id='loading' style='display:none;'>
		Loading......
	</div>
</div>
<input type="hidden" name="company[id]" id="companyId" class="form-control" value="<?php echo $companyID?>"/>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>jquery.nestable.js"></script>
<script>
_companyID = '<?php echo $companyID?>';
_sectorID = '<?php echo $sectorID?>';
function createNewBox(){
	jQuery("#new_cat_box").toggle();
	jQuery("#new_category").val('');
	if(jQuery("#new_cat_box").is(':visible')){
		jQuery('#nestable').animate({ 'marginTop': '100px'}, 1000);
	} else {
		jQuery('#nestable').animate({ 'marginTop': '0px'}, 1000);
	}
}
function createNewTypeBox(){
	jQuery("#new_type_box").toggle();
	jQuery("#new_sector").val('');
	if(jQuery("#new_type_box").is(':visible')){
		jQuery('#nestable1').animate({ 'marginTop': '100px'}, 1000);
	} else {
		jQuery('#nestable1').animate({ 'marginTop': '0px'}, 1000);
	}
}
function checkMeWithOther(o){
	console.log(o.parents('ol').html());
	_meID = o.val();
	o.parents('ol').find("li").find('input[type="radio"]').each(function(){
		if(jQuery(this).val()!=_meID){
			jQuery(this).prop("checked",false);
			jQuery(this).parent().parent().find('input[type="checkbox"]').prop("checked",false);
		}
	});
}
function newSector(){
	if(jQuery("#new_sector").val()!=''){
		jQuery("#loading").show();
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/addNewSector',
			async: true,
			cache: false,
			dataType: 'json',
			data:{sector_name:jQuery("#new_sector").val()},
			success: function(response) {
				jQuery("#loading").hide();
				if(typeof response.data.error!='undefined' && response.data.error==0){
					/*window.location = window.location.href;*/
					createNewBox();
					updateCategorySectorArea();
				} else if(typeof response.data.message!='undefined'){
					alert(response.data.message);
				}
			}
		});
	} else {
		alert("Please enter category name");
	}
}
function newCategory(){
	if(jQuery("#new_category").val()!=''){
		jQuery("#loading").show();
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/addNewCategory',
			async: true,
			cache: false,
			dataType: 'json',
			data:{sector_name:jQuery("#new_category").val()},
			success: function(response) {
				jQuery("#loading").hide();
				if(typeof response.data.error!='undefined' && response.data.error==0){
					/*window.location = window.location.href;*/
					createNewBox();
					updateCategorySectorArea();
				} else if(typeof response.data.message!='undefined'){
					alert(response.data.message);
				}
			}
		});
	} else {
		alert("Please enter category name");
	}
}	
__options = { 
		collapse:true,
		maxDepth:2,
		dropCallback: function(details) {		   
		    var order = new Array();
		    jQuery("li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
			 order[index] = jQuery(elem).attr('data-id');
		    });
			var rootOrder = new Array();
		    if (order.length === 0){
				var rootOrder = new Array();
				jQuery("#nestable > ol > li").each(function(index,elem) {
				  rootOrder[index] = jQuery(elem).attr('data-id');
				});
		    }
		    _sourceAdd = jQuery("li[data-id='"+details.sourceId +"']").data('type');
		    if(jQuery("li[data-id='"+details.destId +"']").find('ol:first').find('li').length==0 || jQuery("li[data-id='"+details.destId +"']").find('ol:first').find('li').length==1){			    
				_destAdd = jQuery("li[data-id='"+details.destId +"']").data('type');
			    if(typeof _destAdd!="undefined"){
					if(_destAdd=="category"){
						_destAdd ="subcategory"
					}
			 		jQuery("li[data-id='"+details.destId +"']").find('ol:first').data('t',_destAdd);
			    }
		    } else {
				_destAdd = jQuery("li[data-id='"+details.destId +"']").find('ol:first').data('t');
			}		
		    if(typeof _destAdd=="undefined"){
			   _destAdd = "category";
		    }
			sp = { source : details.sourceId, 
			  destination: details.destId, 
			  order:JSON.stringify(order),
			  rootOrder:JSON.stringify(rootOrder) ,
			  sourceType:_sourceAdd,
			  destType:_destAdd
			};
			
		    jQuery.post(__baseUrl+'opportunity/update_sector_category_subcategory', sp	, function(data) {
			  //console.log('data '+data); 
				
			})
		    .done(function() { 
				console.log('updated...');
				updateCategorySectorArea();
		    })
		    .fail(function() {  })
		    .always(function() {  });
		}
	};
	__options1 = { 
		collapse:true,
		maxDepth:2,
		dropCallback: function(details) {		   
		    var order = new Array();
		    jQuery("li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
			 order[index] = jQuery(elem).attr('data-id');
		    });
			var rootOrder = new Array();
		    if (order.length === 0){
				var rootOrder = new Array();
				jQuery("#nestable1 > ol > li").each(function(index,elem) {
				  rootOrder[index] = jQuery(elem).attr('data-id');
				});
		    }
		    _sourceAdd = jQuery("li[data-id='"+details.sourceId +"']").data('type');
		    if(jQuery("li[data-id='"+details.destId +"']").find('ol:first').find('li').length==0 || jQuery("li[data-id='"+details.destId +"']").find('ol:first').find('li').length==1){			    
				_destAdd = jQuery("li[data-id='"+details.destId +"']").data('type');
			    if(typeof _destAdd!="undefined"){
					if(_destAdd=="sector"){
						_destAdd ="sub-sector"
					}
			 		jQuery("li[data-id='"+details.destId +"']").find('ol:first').data('t',_destAdd);
			    }
		    } else {
				_destAdd = jQuery("li[data-id='"+details.destId +"']").find('ol:first').data('t');
			}		
		    if(typeof _destAdd=="undefined"){
			   _destAdd = "sector";
		    }
			sp = { source : details.sourceId, 
			  destination: details.destId, 
			  order:JSON.stringify(order),
			  rootOrder:JSON.stringify(rootOrder) ,
			  sourceType:_sourceAdd,
			  destType:_destAdd
			};
			
		    jQuery.post(__baseUrl+'opportunity/update_sector_category_subcategory', sp	, function(data) {
			  //console.log('data '+data); 
				
			})
		    .done(function() { 
				console.log('updated...');
				updateCategorySectorArea();
		    })
		    .fail(function() {  })
		    .always(function() {  });
		}
	};
function callNestable(){
	jQuery('#nestable').nestable(__options);	
	jQuery('#nestable1').nestable(__options1);	
}

jQuery(document).ready(function(){
	callNestable();
});

function updateCategorySectorArea(){
	jQuery('#nestable').nestable('destroy');
	jQuery('#nestable1').nestable('destroy');
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/refreshSectorCategory',
		data:{company_id:_companyID,sector_id:_sectorID},
		success:function(d){
			if(d!=''){
				_d = JSON.parse(d);
				if(_d.sector!=''){
					jQuery('#nestable1').html(_d.sector);
				}
				if(_d.category!=''){
					jQuery('#nestable').html(_d.category);
				}
				console.log('calling nestable');
				callNestable();
				jQuery('#nestable').nestable('init');
				jQuery('#nestable1').nestable('init');
			}
		}
	});
}

function openForEdit(o){
	$parent = o.parents('li');
	_id = $parent.data('id');
	if(!isNaN(_id)){
		o.parents('div.listbox').find('span.show-span').hide();
		o.parents('div.listbox').find('span.edit-span').show();
	} else {
		alert("Open popup again....");
	}	
}
function deleteMe(o){
	$parent = o.parents('li');
	_id = $parent.data('id');
	if(!isNaN(_id)){
		jQuery("#loading").show();
		fields = {
			t:$parent.data('type'),
			id:$parent.data('id')
		};
		jQuery.post(__baseUrl+'opportunity/delete_all_types', fields	, function(data) {
		  //console.log('data '+data); 
		})
	   .done(function(d) { 
		jQuery("#loading").hide();
		 if(parseInt(d)>0){
			/*window.location = window.location.href;*/
			updateCategorySectorArea();
		 }
	   });
	} else {
		alert("Open popup again....");
	}
}
function updateMe(o){
	$inputBox = o.parents('div.listbox').find('span.edit-span').find('input[type="text"]');
	if($inputBox.length>0){
		jQuery("#loading").show();
		$parent = o.parents('li');
		_inputVal = $inputBox.val();
		fields = {
			t:$parent.data('type'),
			id:$parent.data('id'),
			name:_inputVal
		};
		jQuery.post(__baseUrl+'opportunity/update_all_types', fields	, function(data) {
		  //console.log('data '+data); 
		})
	    .done(function(d) { 
		jQuery("#loading").hide();
		if(d>0){
			$inputBox.val(_inputVal);
			o.parents('div.listbox').find('span.show-span').find('a.edit-btn').html(_inputVal); 
		}
		o.parents('div.listbox').find('span.edit-span').hide();
		o.parents('div.listbox').find('span.show-span').show();
	   });
	}	
}
function closeMe(o){
	o.parents('div.listbox').find('span.edit-span').hide();
	o.parents('div.listbox').find('span.show-span').show();
}
function checkedMyParent(o){
	$LI = o.parent().parent().parent().parent();
	if($LI.length>0 && o.is(':checked')===false){
		if($LI.find('input.parent').is(':checked')===true){
			$LI.find('input.parent').prop('checked',false);
		}
	}
}
function checkedMyChild(o){
	_nextChild = o.parent().next('.dd-list');
	if(_nextChild.length>0){
		_nextChild.find('li').each(function(i){
			if(o.is(':checked')){
				jQuery(this).find('input[type="checkbox"]').prop('checked',true);
			} else {
				jQuery(this).find('input[type="checkbox"]').prop('checked',false);
			}
			
		});
	}
	if(o.is(':checked')===true){
		o.parent().parent().parent().parent().find('input[name="company[sector]"]').prop('checked',true);
	} else {
		_df = false;		
		o.parent().parent().parent().parent().find('input.parent').each(function(){
			console.log("TAP");
			if(jQuery(this).is(':checked')){
				_df = true;
			}
		});
		if(_df===true){
			o.parent().parent().parent().parent().find('input[name="company[sector]"]').prop('checked',true);
		} else {
			o.parent().parent().parent().parent().find('input[name="company[sector]"]').prop('checked',false);
		}
	}
}
</script>
<?php echo form_close();?>