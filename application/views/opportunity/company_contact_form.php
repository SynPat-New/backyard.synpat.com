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
				"searching":false,
				"autoWidth": true,
				"paging": false,
				"sScrollY": "660px",
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			});
	});
	_checked=0;
	<?php 
		if($parentElement!='company_form'):
	?> /*= JSON.parse('<?php echo json_encode($lead_data)?>');*/
	__leadData = {};
	__leadData.id = <?php echo $lead_data->id?>; 
	__leadData.lead_name = "<?php echo $lead_data->lead_name?>"; 
	__leadData.plantiffs_name = "<?php echo $lead_data->plantiffs_name?>"; 
	__leadData.broker = "<?php echo $lead_data->broker?>"; 
	__leadData.broker_person = "<?php echo $lead_data->broker_person?>"; 
	__leadData.person_title_1 = "<?php echo $lead_data->person_title_1?>"; 
	__leadData.person_title_2 = "<?php echo $lead_data->person_title_2?>"; 
	<?php 
		else:
	?>
	__leadData = [];
	<?php endif;?>
	__type=<?php echo $type?>;
	function findContact(){
		_checked=0;
		if(jQuery("#search").val()!=""){
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl?>opportunity/company_contact_form/<?php echo $leadID;?>/<?php echo $type;?>/<?php echo $parentElement;?>',
				data:{search:jQuery("#search").val(),p:500},
				dataType:'json',
				success:function(data){
					$('#datatable-contacts-sharing').find("tbody").html('');
					_tbody = '';
					if(data.data.length>0){	
						d= data.data;	
						for(i=0;i<d.length;i++){
							/*_cat = d[i].department_names;
							if(_cat==undefined || _cat==false){
								_cat='';
							}
							_subcat = d[i].sub_department_names;
							if(_subcat==undefined || _subcat==false){
								_subcat='';
							}
							_tbody +='<tr><td style="width:10px;"><input type="radio" data-sp="'+d[i].id+'" name="vendor_select" data-name="" data-title="" data-company-id="'+d[i].id+'" data-company="'+d[i].company_name+'" value="'+d[i].id+'"  onchange="getVendor(jQuery(this),<?php echo $type;?>,\'<?php echo $parentElement?>\');"/></td><td style="width:120px;">'+d[i].company_name+'</td><td style="width:120px;">'+d[i].sectorName+'</td><td style="width:120px;">'+_cat+'</td><td style="width:120px;">'+_subcat+'</td></tr>';*/
							_tbody +='<tr><td style="width:10px;"><input type="radio" data-sp="'+d[i].id+'" name="vendor_select" data-name="" data-title="" data-company-id="'+d[i].id+'" data-company="'+d[i].company_name+'" value="'+d[i].id+'"  onchange="getVendor(jQuery(this),<?php echo $type;?>,\'<?php echo $parentElement?>\');"/></td><td style="width:120px;">'+d[i].company_name+'</td></tr>';
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
							"sScrollY": "660px",
							"sScrollX": "100%",
							"sScrollXInner": "100%"
						});
					setTimeout(function () {
						if(jQuery('#datatable-contacts-sharing').find("tbody").find('input[data-sp="'+_checked+'"]').length>0){
							jQuery('#datatable-contacts-sharing').find("tbody").find('input[[data-sp="'+_checked+'"]').prop('checked',true);
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
			console.log(e.which);	
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
	<div class="col-xs-6">	
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
					<th style="width:120px;">Company Name</th>
					<!--<th style="width:120px;">Sector</th>
					<th style="width:120px;">Category</th>
					<th style="width:120px;">Sub Category</th>-->
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
	</div>
	<div class="col-xs-6">
		<?php 
			$companyID = 0;
			if(isset($lead_data) && count($lead_data)>0){
				if($parentElement!='company_form'){
					if($type==1){
						if(isset($lead_data->plantiffs_name) && $lead_data->plantiffs_name>0){
							$companyID = $lead_data->plantiffs_name;
						}
					} else if($type==4){
						if(isset($lead_data->person_title_1) && $lead_data->person_title_1>0){
							$companyID = $lead_data->person_title_1;
						}
					} else if($type==5){
						if(isset($lead_data->person_title_2) && $lead_data->person_title_2>0){
							$companyID = $lead_data->person_title_2;
						}
					} else if($type==3 || $type==2){
						if(isset($lead_data->broker) && $lead_data->broker>0){
							$companyID = $lead_data->broker;
						}
					}
				}				
				
			}
		?>
		<iframe src="<?php echo $Layout->baseUrl;?>opportunity/add_company/<?php echo $companyID;?>" style="width:100%;height:500px;" id="company_for_show"></iframe>
	</div>
</div>

<script>
	__backSpace = "";
	
	function getVendor(v,type,parentElement){	
		jQuery("#company_for_show").attr('src','<?php echo $Layout->baseUrl;?>opportunity/add_company/'+v.val())
		switch(parentElement){	
			case 'company_form':
				_st = window.parent.jQuery("#open_company_add").find('iframe').get(0);
				_htmlIframe = _st.contentDocument;
				jQuery(_st.contentDocument).find("#companyBroker").val(v.val());
				jQuery(_st.contentDocument).find('#companyBrokerFirm').val(v.attr('data-company'));
				jQuery(_st.contentDocument).find('#companyBrokerName').val(v.attr('data-name'));
			break;
			case 'from_regular':
				switch(parseInt(type)){
					case 1:
						window.parent.___FLAG = 1;
						window.parent.$("#marketOwner").val(v.attr('data-company-id'));
						window.parent.$("#"+parentElement).find("#spnleadOpenSellerCompanyContact").html("<a href='javascript://' onclick='openCompanyEdit("+v.attr('data-company-id')+")'>"+v.attr('data-company')+"</a>");
						window.parent.$("#marketSellerContact").val(v.attr('data-company'));
					break;
					case 2:
					case 3:
						window.parent.___FLAG = 1;
						window.parent.$("#marketBroker").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showBrokerFirm").html(v.attr('data-company'));*/
						window.parent.$("#marketBrokerContact").val(v.attr('data-company'));					
						window.parent.$("#marketBrokerPerson").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showBrokerPerson").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#marketBrokerPersonContact").val(v.attr('data-name')+","+v.attr('data-title'));
					break;
					case 4:
						window.parent.___FLAG = 1;
						window.parent.$("#marketPersonTitle1").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showNameFirst").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#marketPersonName1").val(v.attr('data-name')+","+v.attr('data-title'));
					break;
					case 5:
						window.parent.___FLAG = 1;
						window.parent.$("#marketPersonTitle2").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showNameSecond").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#marketPersonName2").val(v.attr('data-name')+","+v.attr('data-title'));
					break;
				}
				window.parent.callRunLeadSave();
			break;
			case 'from_litigation':
				switch(parseInt(type)){
					case 1:
						window.parent.___FLAG = 1;
						window.parent.$("#litigationOwner").val(v.attr('data-company-id'));
						/*window.parent.$("#"+parentElement).find("#showSellerName").html(v.attr('data-company'));*/
						window.parent.$("#litigationSellerContact").val(v.attr('data-company'));
					break;
				}
				window.parent.callRunLeadSave();
			break;
			case 'from_nonacquistion':
				switch(parseInt(type)){
					case 1:
						window.parent.___FLAG = 1;
						window.parent.$("#acquisitionOwner").val(v.attr('data-company-id'));
						/*window.parent.$("#"+parentElement).find("#showSellerName").html(v.attr('data-company'));*/
						window.parent.$("#"+parentElement).find("#spnleadOpenSellerCompanyContact").html("<a href='javascript://' onclick='openCompanyEdit("+v.attr('data-company-id')+")'>"+v.attr('data-company')+"</a>");
						window.parent.$("#acquisitionSellerContact").val(v.attr('data-company'));
					break;
					case 2:
					case 3:
						window.parent.___FLAG = 1;
						window.parent.$("#acquisitionBroker").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showBrokerFirm").html(v.attr('data-company'));*/
						window.parent.$("#acquisitionBrokerContact").val(v.attr('data-company'));				
						window.parent.$("#acquisitionBrokerPerson").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showBrokerPerson").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#acquisitionBrokerPersonContact").val(v.attr('data-name')+","+v.attr('data-title'));
					break;
					case 4:
						window.parent.___FLAG = 1;
						window.parent.$("#acquisitionPersonTitle1").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showNameFirst").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#acquisitionPersonName1").val(v.attr('data-name')+","+v.attr('data-title'));
					break;
					case 5:
						window.parent.___FLAG = 1;
						window.parent.$("#acquisitionPersonTitle2").val(v.val());
						/*window.parent.$("#"+parentElement).find("#showNameSecond").html(v.attr('data-name')+","+v.attr('data-title'));*/
						window.parent.$("#acquisitionPersonName2").val(v.attr('data-name')+","+v.attr('data-title'));
					break;
				}
				window.parent.callRunLeadSave();
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