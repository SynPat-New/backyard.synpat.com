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

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/accordion-ui/accordion.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/accordion-ui/accordion.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro/handsontable-pro-1.9.1-05f89dcd8ad97b633fe4444dce1928f3528c3389/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro/handsontable-pro-1.9.1-05f89dcd8ad97b633fe4444dce1928f3528c3389/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro/handsontable-pro-1.9.1-05f89dcd8ad97b633fe4444dce1928f3528c3389/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro/handsontable-pro-1.9.1-05f89dcd8ad97b633fe4444dce1928f3528c3389/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro/handsontable-pro-1.9.1-05f89dcd8ad97b633fe4444dce1928f3528c3389/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro/handsontable-pro-1.9.1-05f89dcd8ad97b633fe4444dce1928f3528c3389/dist/handsontable.full.min.js"></script>
<style>
	body {
		overflow: auto !important;margin:0px;
		min-width: 0;
		width: 100% !important;font-family:arial;font-size:13px;
	}
	.title-hero{font-family:arial;font-size:20px;}
	#page-content {
	    background: #ffffff !important;
	}
	
	a{text-decoration:none;}h4{font-size:16px;font-weight:300;margin:0}
	
	.mrg5R{margin-right:5px;}
	.scroll-container {
	width: 99%;
	height: 250px;
	margin: 0px 0 1rem;
	overflow: hidden;
}
.font-blue{color:#56B2fe}
.htCore, .handsontable{font-family:arial;font-size:13px;}
.handsontable .htDimmed{color:#222222}
.dashboard-box{padding:10px;}
.uheader {
   /* font-size: 15px;
    font-weight: bold;
    
    
    margin-top: 2px;
    padding: 10px;
    cursor: pointer;
    border-width: 1px;
    border-style: solid;
	border-color: #dfe8f1;
	color: #555a60;
    background-color: #FEFEFF;*/
}
.uactive{
/*	border-color:#00a792;
	background:#2196F3;
	color:#fff;*/
}
.table > thead > tr > th{font-weight:normal;border-bottom-width:1px;}
#availability_request_box .handsontable tbody tr td:nth-child(7),#availability_request_box_confirmed .handsontable tbody tr td:nth-child(7){text-align:center}
.wrap_all{width:80%;}
</style>
<div class="panel dashboard-box">
    <div class="panel-body">
		<div class="example-box-wrapper">	
			<div class="example-box-wrapper">
				<div id="accordion" class=''>
					<?php if($t==1):?>
					<h4>Request To Participate/Customer Counter Execute Agreement/Proof Of Payment (<span id="countParticipants"></span>)</h4>
					<div class='hide'>
						<div class="scroll-container col-lg-12 cp-border">
							<div id='participate_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
						</div>
					</div>
					<?php endif;?>
					<?php if($t==2):?>
					<h4>Revised Document</h4>
					<div class='hide'>
						<div class="scroll-container col-lg-12 cp-border">
							<div id='revised_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
						</div>
						<div class="scroll-container col-lg-12 cp-border" style="margin-top:30px;">
							<div id='confirmed_revised_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
						</div>
					</div>
					<?php endif;?>
					<?php if($t==4):?>
					<h4>Check Availability (<span id="countAvailability"></span>)</h4>
					<div class='hide'>
						<div class="col-lg-7">
							<div class="scroll-container col-lg-12 cp-border">
								<div id='availability_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
							</div>
							
							<div class="scroll-container col-lg-12 cp-border" style="margin-top:50px;">
								<h5 style='font-size:16px;font-weight:300;'>Replied Quests:</h5>
								<div id='availability_request_box_confirmed' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
							</div>
						</div>
						<div class="col-lg-5">
							<table class="table">
								<thead>
									<tr>
										<th>Portfolio</th>
										<th>Customer</th>
										<th>Type</th>
										<th>Target</th>
										<th>Price</th>
										<th>Date</th>
										<th>Stage</th>
										<th>Document</th>										
									</tr>
								</thead>
								<tbody>
									<?php 
										if(count($license_list)>0){
											foreach($license_list as $license){
												$leadName = $license->lead_name;				
												$licenseType = "";
												$companyName = $license->company_name;
												if($license->file_type==2){
													$licenseType = "Non-Exclusive";
												}else if($license->file_type==3){
													$licenseType = "Strategic";
												}
												$stage = "";
												if($license->stage==2){
													$stage = "Regular";
												}else if($license->stage==3){
													$stage = "Validated";
												}
												$availableFor = $license->target;
												$price = $license->price;
												if($price!='0.0'){
													$price = '$'.$price;
												}
												$date = "";
												if($license->date!='0000-00-00 00:00:00'){
													$date = date('M-d-Y',strtotime($license->date));
												}
												$documentFile= '';
												if($license->document!="" && $license->document!=null){
													$documentFile = '<a data-mainhref="'.$license->document.'"  data-href="'.$license->document.'"  href="javascript://" onclick="open_drive_files(\''.$license->document.'\')" class="font-blue"><img src="https://ssl.gstatic.com/docs/doclist/images/icon_12_pdf_list.png" style="position:relative;top:3px;"/> '.$license->document_name.'</a>';
												}
										?>
												<tr><td class='cpBor'><?php echo $leadName;?></td><td class='cpBor'><?php echo $companyName;?></td><td class='cpBor'><?php echo $licenseType;?></td><td class='cpBor'><?php echo $availableFor;?></td><td class='cpBor'><?php echo $price;?></td><td class='cpBor'><?php echo $date;?></td><td class='cpBor'><?php echo $stage;?></td><td class='cpBor'><?php echo $documentFile;?></td></tr>";
									<?php
											}
										} else {
									?>
										<tr><td colspan="8">No record found!</td></tr>
									<?php
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
					<?php endif;?>
					<?php if($t==3):?>
					<h4>Confirmed Request</h4>
					<div class='hide'>
						<div class="scroll-container col-lg-12 cp-border">
							<div id='confirmed_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
						</div>
					</div>	
					<?php endif;?>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
$leadNameArray = array();
?>
<script>
function openFile(o){
	window.parent.open_drive_files(o.data('href'));
}
var participate_request_table = document.getElementById('participate_request_box'),hot1,_participateRequestJSON = [],confirmed_request_table = document.getElementById('confirmed_request_box'),hot2,_confirmedRequestJSON = [],revised_request_table = document.getElementById('revised_request_box'),hot3,cofirmed_revised_request_table = document.getElementById('confirmed_revised_request_box'),hot6,_revisedRequestJSON = [],_revisedConfirmedRequestJSON = [],availability_request_table = document.getElementById('availability_request_box'),hot4,_availabilityRequestJSON = [],availability_request_table_confirmed = document.getElementById('availability_request_box_confirmed'),hot5,_availabilityConfirmedJSON = [];
_availabilityRequestJSON=[
	<?php
		if(count($availability)>0){
			$i=0;
			foreach($availability as $contact){
				$companyName = (!empty($contact->company_name))?$contact->company_name:'';
				$companyID = (!empty($contact->companyID))?$contact->companyID:'';
				$contactCompanyName = (!empty($contact->contactCompanyName))?$contact->company_name:'';
				$personName = (!empty($contact->person_name))?$contact->person_name:'';
				$personContactID = (!empty($contact->contactID))?$contact->contactID:'';
				$leadName = $contact->lead_name;				
				$leadNameString = "";
				$enter = false;
				$firstColor = "";
				$secondColor = "";
				$thirdColor = "";
				$leadID = 0;
				foreach($leadNameArray as $lead){
					if($lead[0]==$leadName){
						if(is_numeric($leadName)){
							$getLeadName = getLeadName($leadName);
							if(count($getLeadName)>0){
								$leadName = $getLeadName->lead_name;
								$leadID = $getLeadName->id;
							}
						} else {
							$leadID = $contact->leadID;
						}
						$firstColor = $lead[1];
						$secondColor = $lead[2];
						$thirdColor = $lead[3];
						$leadNameString = $leadName;
						$enter = true;
						break;
					}
				}
				if($enter==false){
					$firstColor = generateRandomNumber(3);
					$secondColor = generateRandomNumber(2);
					$thirdColor = generateRandomNumber(2);
					$leadNameArray[] = array($leadName,$firstColor,$secondColor,$thirdColor);
					if(is_numeric($leadName)){
						$getLeadName = getLeadName($leadName);
						if(count($getLeadName)>0){
							$leadName = $getLeadName->lead_name;
							$leadID = $getLeadName->id;
						}
					} else {
						$leadID = $contact->leadID;
					}
					$leadNameString = $leadName;
				} 
				$participateType = '';
				switch((int)$contact->type){
					case 2:
						$participateType = 'NEL';
					break;
					case 3:
						$participateType = 'STL';
					break;
				}		
				$available = "no";
				if((int)$contact->availability==2){
					$available = "yes";
				}
				$date = (!empty($contact->create_date))?date('H:i m/d/y',strtotime($contact->create_date)):'';
				echo "{'id':". $contact->id.",'company_name':'" . trim($companyName) . "','telephone':'" . $contact->person_phone . "','person_name':'" . $personName . "','lead_name':'" . trim($leadNameString) . "','email':'" . $contact->contactEmail . "','date':'" . $date . "','participate_type':'" . $participateType . "','action':'" . $contact->id . "','first_color':'" . $firstColor . "','second_color':'" . $secondColor . "','third_color':'" . $thirdColor . "','lead_id':".$leadID.",'check_for':'".$contact->check_for."','available':'" . $available . "','contact_id':'".$personContactID."','customer_company_name':'".$contactCompanyName."','company_id':'".$companyID."'}";
				if ($i < count($availability) - 1) {
					echo ",";
				}
			}
		}
	?>
];
_availabilityConfirmedJSON=[
	<?php
		if(count($availability_confirmed)>0){
			$i=0;
			foreach($availability_confirmed as $contact){
				$companyName = (!empty($contact->company_name))?$contact->company_name:'';
				$companyID = (!empty($contact->companyID))?$contact->companyID:'';
				$contactCompanyName = (!empty($contact->contactCompanyName))?$contact->company_name:'';
				$personName = (!empty($contact->person_name))?$contact->person_name:'';
				$personContactID = (!empty($contact->contactID))?$contact->contactID:'';
				$leadName = $contact->lead_name;				
				$leadNameString = "";
				$enter = false;
				$firstColor = "";
				$secondColor = "";
				$thirdColor = "";
				$leadID = 0;
				foreach($leadNameArray as $lead){
					if($lead[0]==$leadName){
						if(is_numeric($leadName)){
							$getLeadName = getLeadName($leadName);
							if(count($getLeadName)>0){
								$leadName = $getLeadName->lead_name;
								$leadID = $getLeadName->id;
							}
						} else {
							$leadID = $contact->leadID;
						}
						$firstColor = $lead[1];
						$secondColor = $lead[2];
						$thirdColor = $lead[3];
						$leadNameString = $leadName;
						$enter = true;
						break;
					}
				}
				if($enter==false){
					$firstColor = generateRandomNumber(3);
					$secondColor = generateRandomNumber(2);
					$thirdColor = generateRandomNumber(2);
					$leadNameArray[] = array($leadName,$firstColor,$secondColor,$thirdColor);
					if(is_numeric($leadName)){
						$getLeadName = getLeadName($leadName);
						if(count($getLeadName)>0){
							$leadName = $getLeadName->lead_name;
							$leadID = $getLeadName->id;
						}
					} else {
						$leadID = $contact->leadID;
					}
					$leadNameString = $leadName;
				} 
				$participateType = '';
				switch((int)$contact->type){
					case 2:
						$participateType = 'NEL';
					break;
					case 3:
						$participateType = 'STL';
					break;
				}		
				$available = "no";
				if((int)$contact->availability==2){
					$available = "yes";
				}
				$date = (!empty($contact->create_date))?date('H:i m/d/y',strtotime($contact->create_date)):'';
				echo "{'id':". $contact->id.",'company_name':'" . trim($companyName) . "','telephone':'" . $contact->person_phone . "','person_name':'" . $personName . "','lead_name':'" . trim($leadNameString) . "','email':'" . $contact->contactEmail . "','date':'" . $date . "','participate_type':'" . $participateType . "','action':'" . $contact->id . "','first_color':'" . $firstColor . "','second_color':'" . $secondColor . "','third_color':'" . $thirdColor . "','lead_id':".$leadID.",'check_for':'".$contact->check_for."','available':'" . $available . "','contact_id':'".$personContactID."','customer_company_name':'".$contactCompanyName."','company_id':'".$companyID."'}";
				if ($i < count($availability_confirmed) - 1) {
					echo ",";
				}
			}
		}
	?>
];
_participateRequestJSON=[
	<?php
		if(isset($licensees->participant) && count($licensees->participant)>0){
			$i=0;
			foreach($licensees->participant as $contact){
				$companyName = (!empty($contact->Request_to_participates->company_name))?$contact->Request_to_participates->company_name:'';
				$personName = (!empty($contact->Request_to_participates->person_name))?$contact->Request_to_participates->person_name:'';
				$leadName = str_replace('_',' ',$contact->License->license_number);
				$fileData = "";
				if(!empty($contact->Request_to_participates->file)):
					/*$file = pathinfo($contact->Request_to_participates->file);
					$fileUrl = str_replace("/var/www/html/","http://www.synpat.com/",$file['dirname']);
					$fileUrl = str_replace("/home/synpatne/public_html/synpat_com/store/","http://www.synpat.com/",$fileUrl);
					$fileUrl = str_replace("/var/www/synpat/store/","http://www.synpat.com/",$fileUrl);
					$fileData ='<a class="font-blue" href="'.$fileUrl.'/'.$file['basename'].'" target="_BLANK">View</a>';
					*/
					$fileUrl = $contact->Request_to_participates->file;
					$fileData="";					
					$file = explod