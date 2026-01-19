<style>
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;
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
				"searching":true,
				"autoWidth": true,
				"paging": false,
				"sScrollY": "780px",
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			});
	});
</script>
<style>
div.dataTables_filter label{
	float:left;
}
</style>
<div class="row" style='width:100%;'>	
		<div class="col-xs-12" style='width:100%;'>		
		<table class="table" class="table" id="datatable-contacts-sharing">
			<thead>
				<tr>
					<th>#</th>
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
							if(count($lead_data)>0){
								if($contact->id==$lead_data->contact_id){
									$checked = "CHECKED='CHECKED'";
								}
							}
				?>
				<tr>
					<td style="width:10px;"><input type="radio" name="vendor_select" data-name="<?php echo $contact->first_name." ".$contact->last_name;?>" data-title="<?php echo $contact->job_title; ?>" data-company-id="<?php echo $contact->companyID;?>" data-company="<?php echo $contact->company_name;?>" value="<?php echo $contact->id;?>" onchange="getVendor(jQuery(this),<?php echo $type;?>,'<?php echo $parentElement?>');" <?php echo $checked?> /></td>
					<td style="width:120px;"><?php echo (!empty($contact->first_name))?$contact->first_name." ".$contact->last_name:'';?></td>
					<td style="width:120px;"><?php echo (string)$contact->job_title; ?></td>
					<td style="width:120px;"><?php echo (string)$contact->company_name;?></td>
					<td style="width:120px;"><?php 
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
		updateValue = v.attr('data-name')+", "+v.attr('data-company');
		contactID = v.val();
		switch(parseInt(type)){
			case 1:
			window.parent.jQuery('#'+parentElement).find('input#leadOpenPatentOpenContact').val(updateValue);
			window.parent.jQuery('#'+parentElement).find('input#leadOpenPatentContact').val(contactID);
			break;
			case 2:
			window.parent.jQuery('#'+parentElement).find('input#leadOpenTechnicalOpenContact').val(updateValue);
			window.parent.jQuery('#'+parentElement).find('input#leadOpenTechnicalContact').val(contactID);
			break;
			case 3:
			window.parent.jQuery('#'+parentElement).find('input#leadOpenLegalOpenContact').val(updateValue);
			window.parent.jQuery('#'+parentElement).find('input#leadOpenLegalContact').val(contactID);
			break;
			case 4:
			window.parent.jQuery('#'+parentElement).find('input#leadOpenIllustrationOpenContact').val(updateValue);
			window.parent.jQuery('#'+parentElement).find('input#leadOpenIllustrationOpenStatus').val(contactID);
			break;
			case 5:
			window.parent.jQuery('#'+parentElement).find('input#leadOpenRoyaltyOpenContact').val(updateValue);
			window.parent.jQuery('#'+parentElement).find('input#leadOpenRoyaltyOpenStatus').val(contactID);
			break;
			case 6:
			window.parent.jQuery('#'+parentElement).find('input#leadOpenInviteesOpenContact').val(updateValue);
			window.parent.jQuery('#'+parentElement).find('input#leadOpenInviteesOpenStatus').val(contactID);
			break;			
		}
		window.parent.saveUpdateOpenProjectLead(type,contactID);
	}
	
	

	function refreshContactTableHeader() {
		$('#datatable-contacts-sharing_wrapper .sorting_asc, #datatable-contacts-sharing_wrapper .sorting_desc').trigger('click');
		setTimeout(function() {
			$('#datatable-contacts-sharing_wrapper .sorting_asc, #datatable-contacts-sharing_wrapper .sorting_desc').trigger('click');
		}, 300);
	}
</script>