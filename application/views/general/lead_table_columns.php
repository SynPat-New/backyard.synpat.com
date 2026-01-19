<style>
body{width:auto;min-width:auto;}
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

	table .btn-primary,
	table .btn-danger {
		background: none !important;
		border: none !important;
		display: inline;
		line-height: 1;
		padding: 0;
	}
	table .btn-primary {
		color: #2196f3 !important;
	}
	table .btn-danger {
		color: #d9534f !important;
	}
</style> 
<?php
$buttons = array('DRIVE'=>'Drive Button','EMAIL'=>'Email Button','TASK'=>'Task Button','CREATE_DOCKET'=>'Create a Docket in the Store','SELLER'=>'Seller Info','PROPOSAL'=>'Proposal Letter','PATENT_LIST'=>'Patent List','TECHNICAL_DD'=>'Start Technical Due Dilligence','LEGAL_DD'=>'Start Legal Due Dilligence','CLAIM_ILLUS'=>'Start Claim Illustration','REVIEW'=>'Forward to Review','SCHEDULE'=>'Schedule 1st Call','NDA_TERMSHEET'=>'NDA + TermSheet','SELLER_IS_INTERSTED'=>'Seller like the deal','APPROVED_LEAD'=>'Synpat like the deal','EXECUTE_NDA'=>'Execute NDA','EOU'=>'Seller EOU in Folder','DRAFT_PPA'=>'Draft a PPA','EXECUTE_PPA'=>'Execute a PPA','PPA_EXECUTE'=>'PPA Execute','FUNDING'=>'Funding Successful','OUTSOURCE'=>'Outsource Project','ALL'=>'Flexible Button');
$columnsQuery = 


$columnsList = array(
	'lead_name' => 'Lead Column 1',
	'serial_number' => 'Lead Column 2',
	'attractive' => 'Lead Column 3',
	'type' => 'Lead Column 4',
	'lead_last_seen' => 'Lead Column 5',
	'eou' => 'Lead Column 6',
	'broker_contact' => 'Lead Column 7',
	'seller_info_text' => 'Lead Column 8',
	'synpat_like' => 'Lead Column 9',
	'create_date' => 'Lead Column 10',
	'ppa_date' => 'Lead Column 11',
	'funding_trnsfr' => 'Lead Column 12',
	'person_name_1' => 'Lead Column 13',
	'person_name_2' => 'Lead Column 14',
	'relates_to' => 'Lead Column 15',
  );
?>
<script>
jQuery(document).ready(function(){
	jQuery('.breadcrumb').html("<li><a>General</a></li><li class='active'>Button Boxes</li>");
	jQuery("#generalType").multiSelect();
	/*jQuery(".ms-container").append('<i class="glyph-icon icon-exchange"></i>');*/
});

function showAnotherFields(v){
	if(v!=""){
		if(v=="DRIVE"){
			jQuery("#extra_fields_drive").css('display','');
			jQuery("#extra_fields_email").css('display','none');
			jQuery("#extra_fields_task").css('display','none');
		} else if(v=="EMAIL"){
			jQuery("#extra_fields_drive").css('display','none');
			jQuery("#extra_fields_task").css('display','none');
			jQuery("#extra_fields_email").css('display','');
		} else if(v=='TASK'){
			jQuery("#extra_fields_email").css('display','none');
			jQuery("#extra_fields_drive").css('display','none');
			jQuery("#extra_fields_task").css('display','');
		} else {
			jQuery("#extra_fields_email").css('display','none');
			jQuery("#extra_fields_drive").css('display','none');
			jQuery("#extra_fields_task").css('display','none');
		}
	}
}
</script>

<div class="panel dashboard-box">
    <div class="panel-body">
		<div class="example-box-wrapper">
			<?php 
			if($this->session->flashdata('message')){
			?>
				<?php echo $this->session->flashdata('message');?>
			<?php					
				}
			?>
			<?php echo form_open('general/lead_table_columns',array('class'=>"form-horizontal form-flat", 'style'=>'margin-bottom: 0;'))?>           
			<div class="example-box-wrapper">
				<div class="row row-width">
					<table class='table'>
						<thead>
							<tr>
								<th>Column</th>
								<th>Button List</th>
								<th>DD List</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($columns_data as $column){
							?>
								<tr>
									<td><?php echo $column->column_name .'  ('.$column->display_name.')';?></td>
									<td>
										<select>
											<option value="">--</option>
											<?php 
												if(count($litigation)>0){
													foreach($litigation as $lit){
														
													}
												}
											?>
										</select>
									</td>
									<td>
										<select>
											<option value="">--</option>
											<option value="column22">Legal DD</option>
											<option value="column23">Illustration DD</option>
											<option value="column24">Tech DD</option>
											<option value="column25">Market DD</option>
											<option value="column26">Pdf DD</option>
											<option value="column27">Comparables</option>
											<option value="column28">Royalty Report</option>
											<option value="column29">Intro Images</option>
											<option value="column30">Intro DD</option>
										</select>
									</td>
								</tr>
							<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<?php echo form_close();?>
		</div>
	</div>
</div>


