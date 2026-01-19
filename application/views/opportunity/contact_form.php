<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/slimscroll/slimscroll.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/datatable/datatable-tabletools.js"></script>
<style>
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;font-family:arial;font-size:13px;
	}
	#page-content {
	    background: #ffffff !important;
	}

	#datatable-contacts-sharing_wrapper .dataTables_filter label {
		padding-top: 2px;
	}
	#datatable-contacts-sharing_wrapper .dataTables_filter input {
	    box-shadow: none;
	    float: right;
	    height: 24px;
	    margin: -4px 0 2px 2px;
	    padding-left: 5px;
	    padding-right: 5px;
	}

	#datatable-contacts-sharing_wrapper .dataTables_scroll {
		background: none;
		clear: both;
	}
	#datatable-contacts-sharing_wrapper .dataTables_info {
		display: none;
	}
</style>
<script>
	var ___table ;
	jQuery(document).ready(function(){
		___table = $('#datatable-contacts-sharing')
			.DataTable({								
				"searching":false,
				"autoWidth": true,
				"paging": false,
				"sScrollY": "490px",
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			});
	});
	_checked=0;
	<?php 
		if($parentElement!='company_form'):
	?>
	__leadData = JSON.parse('<?php echo json_encode($lead_data)?>');
	<?php 
		else:
	?>
	__leadData = [];
	<?php endif;?>
	__type=<?php echo $type?>;
	function findContact(){
		_checked=0;
		if(jQuery("#search").val()!=""){
			jQuery('#datatable-contacts-sharing').find("tbody").html('');
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl?>opportunity/contact_form/<?php echo $leadID;?>/<?php echo $type;?>/<?php echo $parentElement;?>',
				data:{search:jQuery("#search").val(),p:500},
				dataType:'json',
				success:function(s){					
					_tbody = '';
					if(s.list.length>0){
						d = s.list;
						for(i=0;i<d.length;i++){
							_phoneString = "";
							if(d[i].phone!=""){
								_phoneString += d[i].phone;
							}
							if(_phoneString!=""){
								_phoneString +="<br/>";
							}
							if(d[i].telephone!=""){
								_phoneString += d[i].telephone;
							}							
							if(typeof __leadData.id!="undefined"){
								switch(__type){
									case 1:
										if(__leadData.plantiffs_name!=''){
											if(d[i].id==__leadData.plantiffs_name){
												_checked = d[i].id;
											}
										}
									break;
									case 2:
										if(__leadData.broker!=''){
											if(d[i].id==__leadData.broker){
												_checked = d[i].id;
											}
										}
									break;
									case 3:
										if(__leadData.broker_person!=''){
											if(d[i].id==__leadData.broker_person){
												_checked = d[i].id;
											}
										}
									break;
									case 4:
										if(__leadData.person_title_1!=''){
											if(d[i].id==__leadData.person_title_1){
												_checked = d[i].id;
											}
										}
									break;
									case 5:
										if(__leadData.person_title_2!=''){
											if(d[i].id==__leadData.person_title_2){
												_checked = d[i].id;
											}
										}
									break;
								}
							}
							_sectorName ='';
							if(d[i].sectorName!=null){
								_sectorName = d[i].sectorName;
							}
							_tbody +='<tr><td style="width:10px;"><input type="radio" data-sp="'+d[i].id+'" name="vendor_select" data-profile-pic="'+d[i].linkedin_image+'" data-phone="'+d[i].phone+'" data-telephone="'+d[i].telephone+'" data-company_tel="'+d[i].company_tel+'" data-email="'+d[i].email+'" data-name="'+d[i].first_name+' '+d[i].last_name+'" data-title="'+d[i].job_title+'" data-company-id="'+d[i].companyID+'" data-company="'+d[i].company_name+'" value="'+d[i].id+'"  onchange="getVendor(jQuery(this),<?php echo $type;?>,\'<?php echo $parentElement?>\');"/></td><td style="width:120px;">'+d[i].first_name+' '+d[i].last_name+'</td><td style="width:120px;">'+d[i].job_title+'</td><td style="width:120px;">'+d[i].company_name+'</td><td style="width:120px;" class="phone">'+_phoneString+'</td><td style="width:120px;">'+_sectorName+'</td></tr>';
						}
					}
					if(typeof ___table=="object"){
						___table.destroy();
					}
					jQuery('#datatable-contacts-sharing').find("tbody").html(_tbody);
					
					
					___table = jQuery('#datatable-contacts-sharing')
						.DataTable({								
							"searching":false,
							"autoWidth": true,
							"paging": false,
							"sScrollY": "490px",
							"sScrollX": "100%",
							"sScrollXInner": "100%"
						});
					setTimeout(function () {
						if(jQuery('#datatable-contacts-sharing').find("tbody").find('input[data-sp="'+_checked+'"]').length>0){
							jQuery('#datatable-contacts-sharing').find("tbody").find('input[data-sp="'+_checked+'"]').prop('checked',true);
						}
					},300 );
				}
			});
		} else {
			alert("Search box is empty.")
		}
	}
	jQuery(document).ready(function(){
		jQuery("#search").on("keypress",function(e){		
			if(e.which==13){
				e.preventDefault();
				console.log("Searching...");
				findContact();
			}
		})
	})
	
</script>
<style>
div.dataTables_filter label{
	float:left;
}
</style>
<div class="row" style='width:100%;'>	
		<div class="col-xs-12">
			<div class="form-group">
				<input type="text" class='form-control' name="search" placeholder="Search...." id="search" style='width:200px;'/>					
			</div>			
		</div>
		<div class="col-xs-12" style='width:100%;'>		
		<table class="table" class="table" id="datatable-contacts-sharing">
			<thead>
				<tr>
					<th style="width:10px;">#</th>
					<th style="width:120px;">Name</th>
					<th style="width:120px;">Job Title</th>
					<th style="width:120px;">Company</th>
					<th style="width:120px;">Phone Number</th>
					<th style="width:120px;">Sectors</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if(count($contacts)>0){
						foreach($contacts as $contact){
							$checked = "";
							if($type!=9 && count($lead_data)>0){
								switch((int)$type){
									case 1:
										if(!empty($lead_data->plantiffs_name)){
											if($contact->id==$lead_data->plantiffs_name){
												$checked = "CHECKED='CHECKED'";
											}
										}
									break;
									case 2:
										if(!empty($lead_data->broker)){
											if($contact->id==$lead_data->broker){
												$checked = "CHECKED='CHECKED'";
											}
										}
									break;
									case 3:
										if(!empty($lead_data->broker_person)){
											if($contact->id==$lead_data->broker_person){
												$checked = "CHECKED='CHECKED'";
											}
										}
									break;
									case 4:
										if(!empty($lead_data->person_title_1)){
											if($contact->id==$lead_data->person_title_1){
												$checked = "CHECKED='CHECKED'";
											}
										}
									break;
									case 5:
										if(!empty($lead_data->person_title_2)){
											if($contact->id==$lead_data->person_title_2){
												$checked = "CHECKED='CHECKED'";
											}
										}
									break;
								}
							}
				?>
				<tr>
					<td style="width:10px;"><input type="radio" name="vendor_select" data-name="<?php echo $contact->first_name." ".$contact->last_name;?>" data-profile-pic="<?php echo $contact->linkedin_image; ?>" data-email="<?php echo $contact->email; ?>" data-title="<?php echo $contact->job_title; ?>" data-company-id="<?php echo $contact->companyID;?>" data-company="<?php echo $contact->company_name;?>" data-phone="<?php echo $contact->phone;?>" data-telephone="<?php echo $contact->telephone;?>" data-company_tel="<?php echo $contact->company_tel;?>" value="<?php echo $contact->id;?>" onchange="getVendor(jQuery(this),<?php echo $type;?>,'<?php echo $parentElement?>');" <?php echo $checked?> /></td>
					<td style="width:120px;"><?php echo (!empty($contact->first_name))?$contact->first_name." ".$contact->last_name:'';?></td>
					<td style="width:120px;"><?php echo (string)$contact->job_title; ?></td>
					<td style="width:120px;"><?php echo (string)$contact->company_name;?></td>
					<td style="width:120px;" class='phone'><?php 
						$d=0;
						if(!empty($contact->phone)){
							echo $contact->phone;
							$d =1;
						}
						if(!empty($contact->telephone)){
							if($d==1){
								echo ",<br/>";
							}
							echo $contact->telephone;
						}
					?></td>
					<td style="width:120px;"><?php echo $contact->sectorName;?></td>			
				</tr>
				<?php
							
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>

<script>
	__backSpace = "";
	
	function getVendor(v,type,parentElement){		
		switch(parentElement){	
			case 'user_form':
				if(window.parent.jQuery("#open_manage_sector").find('iframe').length> 0){
					_st = window.parent.jQuery("#open_manage_sector").find('iframe').get(0);
				} else if(window.parent.parent.jQuery("#open_manage_sector").find('iframe').length > 0){
					_st = window.parent.parent.jQuery("#open_manage_sector").find('iframe').get(0);
				}
				if(_st != "undefined"){
					_htmlIframe = _st.contentDocument;
					jQuery(_htmlIframe).find("#userbName").val(v.attr('data-name'));
					jQuery(_htmlIframe).find(".selected_user").text(v.attr('data-name'));
					jQuery(_htmlIframe).find("#userTitle").val(v.attr('data-title'));
					jQuery(_htmlIframe).find("#userEmailForSignature").val(v.attr('data-email'));
					jQuery(_htmlIframe).find("#userEmail").val(v.attr('data-email'));
					jQuery(_htmlIframe).find("#userDirect").val(v.attr('data-phone'));
					jQuery(_htmlIframe).find("#userPhone").val(v.attr('data-telephone'));
					jQuery(_htmlIframe).find("#userMobileNumber").val(v.attr('data-phone'));
					jQuery(_htmlIframe).find("#userProfilePic").val(v.attr('data-profile-pic'));
				}
				break;
			case 'company_form':
				_st = window.parent.jQuery("#open_company_add").find('iframe').get(0);
				_htmlIframe = _st.contentDocument;
				jQuery(_htmlIframe).find("#companyBroker").val(v.val());
				jQuery(_htmlIframe).find('#companyBrokerFirm').val(v.attr('data-company'));
				/*jQuery(_htmlIframe).find('#companyBrokerName').val(v.attr('data-name'));*/
				jQuery(_htmlIframe).find('#companyBrokerName').val(v.attr('data-name')+", "+v.attr('data-company'));
				
				break;
			case 'from_regular':
				switch(parseInt(type)){
					case 1:
						/*window.parent.___FLAG = 1;*/
						window.parent.$("#marketOwner").val(v.attr('data-company-id'));
						/*window.parent.$("#"+parentElement).find("#showSellerName").html(v.attr('data-company'));*/
						window.parent.$("#marketSellerContact").val(v.attr('data-company'));
					break;
					case 2:
					case 3:
						/*window.parent.___FLAG = 1;*/
						window.parent.$("#marketBroker").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showBrokerFirm").html(v.attr('data-company'));*/
						window.parent.$("#marketBrokerContact").val(v.attr('data-company'));					
						window.parent.$("#marketBrokerPerson").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showBrokerPerson").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#marketBrokerPersonContact").val(v.attr('data-name')+", "+v.attr('data-title'));
						_showBroker="";
						if(v.val()>0){_showBroker +="<a href='javascript://'  onclick='editContact("+v.val()+")'> "+v.attr('data-name')+", </a>";}
						if(v.attr('data-company-id')>0){_showBroker +="<a href='javascript://' onclick='openCompanyEdit("+v.attr('data-company-id')+")'>"+v.attr('data-company')+"</a>";}
						window.parent.$("#showBrokerPerson").html(_showBroker);
					break;
					case 4:
						/*window.parent.___FLAG = 1;*/
						window.parent.$("#marketPersonTitle1").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showNameFirst").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#marketPersonName1").val(v.attr('data-name')+", "+v.attr('data-title'));
						window.parent.$("#marketOwner").val(v.attr('data-company-id'));
						window.parent.$("#marketSellerContact").val(v.attr('data-company'));
					break;
					case 5:
						/*window.parent.___FLAG = 1;*/
						window.parent.$("#marketPersonTitle2").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showNameSecond").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#marketPersonName2").val(v.attr('data-name')+", "+v.attr('data-title'));
					break;
				}
				window.parent.callRunLeadSave(1);
				break;
			case 'from_litigation':
				switch(parseInt(type)){
					case 1:
						/*window.parent.___FLAG = 1;*/
						window.parent.$("#litigationOwner").val(v.attr('data-company-id'));
						/*window.parent.$("#"+parentElement).find("#showSellerName").html(v.attr('data-company'));*/
						window.parent.$("#litigationSellerContact").val(v.attr('data-company'));
					break;
				}
				window.parent.callRunLeadSave(1);
				break;
			case 'from_nonacquistion':
				switch(parseInt(type)){
					case 1:
						/*window.parent.___FLAG = 1;*/
						window.parent.$("#acquisitionOwner").val(v.attr('data-company-id'));
						/*window.parent.$("#"+parentElement).find("#showSellerName").html(v.attr('data-company'));*/
						window.parent.$("#acquisitionSellerContact").val(v.attr('data-company'));
					break;
					case 2:
					case 3:
						/*window.parent.___FLAG = 1;*/
						window.parent.$("#acquisitionBroker").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showBrokerFirm").html(v.attr('data-company'));*/
						window.parent.$("#acquisitionBrokerContact").val(v.attr('data-company'));				
						window.parent.$("#acquisitionBrokerPerson").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showBrokerPerson").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#acquisitionBrokerPersonContact").val(v.attr('data-name')+", "+v.attr('data-title'));
						_showBroker="";
						if(v.val()>0){_showBroker +="<a href='javascript://'  onclick='editContact("+v.val()+")'> "+v.attr('data-name')+", </a>";}
						if(v.attr('data-company-id')>0){_showBroker +="<a href='javascript://' onclick='openCompanyEdit("+v.attr('data-company-id')+")'>"+v.attr('data-company')+"</a>";}
						window.parent.$("#showBrokerPerson").html(_showBroker);
					break;
					case 4:
						/*window.parent.___FLAG = 1;*/
						window.parent.$("#acquisitionPersonTitle1").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showNameFirst").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#acquisitionPersonName1").val(v.attr('data-name')+", "+v.attr('data-title'));
					break;
					case 5:
						/*window.parent.___FLAG = 1;*/
						window.parent.$("#acquisitionPersonTitle2").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showNameSecond").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#acquisitionPersonName2").val(v.attr('data-name')+", "+v.attr('data-title'));
					break;
				}
				window.parent.callRunLeadSave(1);
				break;
		}
		
	}
	
	

	function refreshContactTableHeader() {
		$('#datatable-contacts-sharing_wrapper .sorting_asc, #datatable-contacts-sharing_wrapper .sorting_desc').trigger('click');
		setTimeout(function() {
			$('#datatable-contacts-sharing_wrapper .sorting_asc, #datatable-contacts-sharing_wrapper .sorting_desc').trigger('click');
		}, 300);
	}
</script>