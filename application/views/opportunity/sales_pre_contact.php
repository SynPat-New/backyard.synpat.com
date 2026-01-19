<style>
	body { min-width: 0; }
	#page-content { background: #ffffff; }

	#datatable-contacts_wrapper {
		margin-top: 3px;
	}
	#datatable-contacts_wrapper .dataTables_filter label {
		padding-top: 2px;
	}
	#datatable-contacts_wrapper .dataTables_filter input {
	    box-shadow: none;
	    float: right;
	    height: 24px;
	    margin: -4px 0 2px 2px;
	    padding-left: 5px;
	    padding-right: 5px;
	}

	#datatable-contacts_wrapper .dataTables_scroll {
		background: none;
		clear: both;
	}
	#datatable-contacts_wrapper .dataTables_info {
		display: none;
	}
</style>
<script>
	var ___table ;
	jQuery(document).ready(function(){
		_h = window.parent.$(window).height() - 120;
		___table = $('#datatable-contacts')
			.DataTable({
				"searching":true,
				"autoWidth": true,
				"paging": false,
				// "sScrollY": _h+"px",
				"sScrollY": 100,
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			});
	});


	window.resizeDataTable = function(height) {
		$('#datatable-contacts_wrapper .dataTables_scrollBody').height(height - 35);
	}

	$(function() {
		parent.open_sales_listResize();
	})
	
</script>

<div class="row">
	<a href='javascript://' onclick='assignBrokerToCompany()' class='btn btn-primary btn-block pull-right mrg5B' style='width:235px;'>Assign Broker to Selected Companies</a>
	<div class="col-xs-12" style="overflow-x: auto; overflow-y: auto;">	
		<table class="table" id="datatable-contacts" width="99% !important">
			<thead>
				<tr>
					<th style="width:30px;"><div class="text-center">x</div></th>
					<th>Name</th>
					<th>Selected</th>
					<th style="width:20px;">Mail</th>
					<th style="width:20px;">In</th>
					<th style="width:120px;">Job Title</th>
					<th style="width:120px;">Company</th>
					<th style="width:120px;">Phone Number</th>
					<th style="width:120px;">Sectors</th>
				</tr>
			</thead> 
			<tbody>
				<?php 
						if(count($companies)>0):					
							foreach($companies as $invitee){
								$selected="";
								if($activity==1){
									if(count($selected_sales_companies)){
										foreach($selected_sales_companies as $sCompany){
											if($sCompany->id==$invitee->id){
												$selected="style='color:red'";
											}
										}
									}
								} else {
									if(count($selected_acquisition_companies)){
										foreach($selected_acquisition_companies as $sCompany){
											if($sCompany->id==$invitee->id){
												$selected="style='color:red'";
											}
										}
									}
								}
								
					?>
							<tr id="<?php echo $invitee->id;?>" <?php echo $selected;?>>
								<td style="width:30px;">
									<input type="checkbox"  name="invite[contact_id][]" value="<?php echo $invitee->id;?>" data-broker-company-id="<?php echo $invitee->company_id?>"/>
								</td>
								<td style="width:120px;"><a href='javascript://' onclick="editGoogleContact(<?php echo $invitee->id;?>)"><?php echo (!empty($invitee->first_name))?$invitee->first_name." ".$invitee->last_name:'';?></a><?php if($invitee->gateway>0):?>&nbsp;&nbsp;<i class="glyph-icon icon-key tooltip-button" title="" data-placement="bottom" data-original-title="Gateway"></i> <?php endif;?></td>
								<td><?php if(!empty($selected)):?>X<?php endif;?></td>
								
								<td style="width:20px;"><?php echo (!empty($invitee->email))?'<span style="text-indent:-99999px;display:inline-block">@@</span> <i class="glyph-icon icon-envelope-square"></i>':'<span style="text-indent:-99999px;display:inline-block">-@</span>';?></td>
								<td style="width:20px;"><?php echo (!empty($invitee->linkedin_url))?'<span style="text-indent:-99999px;display:inline-block">#</span> <i class="glyph-icon icon-linkedin"></i>':'<span style="text-indent:-99999px;display:inline-block">-#</span>';?></td>
								<td style="width:120px;"><?php echo (string)$invitee->job_title; ?></td>
								<td style="width:120px;"><?php echo (string)$invitee->company_name;?></td>
								<td style="width:120px;"><?php 
								$d=0;
								if(!empty($invitee->phone)){
									echo '<a href="javascript://" onclick=\'callFromLandline(encodeURIComponent("'.$invitee->phone.'"));\'>'.$invitee->phone."</a>";
									$d =1;
								}
								if(!empty($invitee->telephone)){
									if($d==1){
										echo ",<br/>";
									}
									echo '<a href="javascript://" onclick=\'callFromLandline(encodeURIComponent("'.$invitee->telephone.'"));\'>'.$invitee->telephone."</a>";
								}
							?></td>
								<td><?php echo $invitee->sectorName;?></td>
							</tr>
							
					<?php  } endif;?>
			</tbody>
		</table>
	</div>
</div>
<script>
	function assignBrokerToCompany(){
		_companiesSelected = [];
		_brokersWithCompanies=[];
		jQuery('input[name="invite[contact_id][]"]:checked').each(function(){
			up=[];
			up[0] = jQuery(this).val();
			up[1] = jQuery(this).attr('data-broker-company-id');			
			_brokersWithCompanies.push(up);
		});
		window.parent.jQuery('input[name="assign_delete[]"]:checked').each(function(){
			_companiesSelected.push(jQuery(this).parent().parent().attr('data-c'));
		});
		if(_companiesSelected.length>0 && _brokersWithCompanies.length>0){
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl?>opportunity/assign_presales_company_to_broker',
				data:{broker_company:JSON.stringify(_brokersWithCompanies),l:<?php echo $lead_id?>,companies:JSON.stringify(_companiesSelected)},
				cache:false,
				success:function(data){
					if(data>0){
						window.parent.refreshAcquisitionAndSalesActivity();
					} else {
						alert("Error!");
					}
				}
			})
		} else {
			alert('Please check checbox first in the list of activities.');
		}
	}
</script>