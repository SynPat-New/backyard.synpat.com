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


    <script src="<?php echo $Layout->baseUrl;?>public/pure-md5.js"></script>
	
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro_v6/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro_v6/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro_v6/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro_v6/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>../handsontable_pro_v6/dist/handsontable.full.min.js"></script>
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
	
	a{text-decoration:none;}h4{font-size:13px;font-weight:400;margin:0;line-height:20px;}
	
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
#availability_request_box_confirmed .handsontable tbody tr td:nth-child(7),#availability_request_box .handsontable tbody tr td:nth-child(7),#confirmed_request_box .handsontable tbody tr td:nth-child(9){text-align:center}
#availability_request_box .handsontable tbody tr td:last-child,#availability_request_box .handsontable thead tr th:last-child,
#confirmed_revised_request_box .handsontable tbody tr td:last-child,#confirmed_revised_request_box .handsontable thead tr th:last-child,#revised_request_box .handsontable tbody tr td:last-child,#revised_request_box .handsontable thead tr th:last-child,#participate_request_box .handsontable tbody tr td:last-child,#participate_request_box .handsontable thead tr th:last-child,#confirmed_request_box .handsontable tbody tr td:last-child,#confirmed_request_box .handsontable thead tr th:last-child{text-align:left}
.wrap_all{width:100%;}
</style>
<div class="panel dashboard-box" style="padding-top:0px;">
    <div class="panel-body">
		<div class="example-box-wrapper">	
			<div class="example-box-wrapper">
				<div id="" class=''>
					<?php if($t==1 || $t==8 || $t==9):?>
					<?php 
						if($t<=1){
					?>
					<h4 style="padding-left:65px;">Request To Participate</h4>
						<?php } else if($t==8){ ?>
					<h4 style="padding-left:65px;">Customer Counter Execute Agreement</h4>
					<?php } else if($t==9){ ?>
					<h4 style="padding-left:65px;">Proof Of Payment</h4>
					<?php }  ?>
					<div class=''>
						<?php 
							if($t<=1){
						?>
							<div class="col-lg-8">
								<div class="scroll-container col-lg-12 cp-border">
									<div id='participate_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style="height: 320px; overflow: hidden; width: 1255px;" data-originalstyle="height: 320px; overflow: hidden; width: 1255px;"></div>
								</div>
								<h5 style='font-size:16px;font-weight:300;margin-top:30px;float:left' style="">Rejected Request</h5>
								<div class="scroll-container col-lg-12 cp-border">
									<div id='participate_denied_box' class="hot handsontable htRowHeaders htColumnHeaders" style="height: 320px; overflow: hidden; width: 1255px;" data-originalstyle="height: 320px; overflow: hidden; width: 1255px;"></div>
								</div>
							</div>
							<div class="col-lg-4">
								<div id='available_license' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
							</div>
						<?php
							} else {
						?>
							<div class="scroll-container col-lg-12 cp-border">
								<div id='participate_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style="height: 320px; overflow: hidden; width: 1858px;" data-originalstyle="height: 320px; overflow: hidden; width: 1858px;"></div>
							</div>
						<?php
							}
						?>
						
					</div>
					<?php endif;?>
					<?php if($t==2):?>
					<h4 style="padding-left:65px;">Revised Document</h4>
					<div class=''>
						<div class="scroll-container col-lg-12 cp-border">
							<div id='revised_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style="height: 320px; overflow: hidden; width: 1858px;" data-originalstyle="height: 320px; overflow: hidden; width: 1858px;"></div>
						</div>
						<div class="scroll-container col-lg-12 cp-border" style="margin-top:30px;">
							<div id='confirmed_revised_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style="height: 320px; overflow: hidden; width: 1858px;" data-originalstyle="height: 320px; overflow: hidden; width: 1858px;"></div>
						</div>
					</div>
					<?php endif;?>
					<?php if($t==4):?>
					<h4 style="padding-left:65px;">Check Availability (<span id="countAvailability"></span>)</h4>
					<div style="float:left;width:70%;">
						<div class="scroll-container col-lg-12 cp-border">
							<div id='availability_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
						</div>
						<h5 style='font-size:16px;font-weight:300;' style="margin-top:50px;">Replied Quests:</h5>
						<div class="scroll-container col-lg-12 cp-border">
							<div id='availability_request_box_confirmed' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
						</div>
					</div>
					<div style="float:right;width:30%;">
						<div id='available_license' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
					</div>
					<?php endif;?>
					<?php if($t==3 || $t==10 || $t==11 || $t==12):?>
					<?php 
						$heading = "Confirmed Requests";
						if($t==10){
							$heading = "Pending Payments";
						}else if($t==11){
							$heading = "Archived Payments";
						}else if($t==12){
							$heading = "Agreements";
						}
					?>
					<h4 style="padding-left:65px;"><?php echo $heading;?></h4>
					<div class=''>
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
$participantsArray = array();
$participantsDeniedArray = array();
if($t==1){
	if(isset($licensees->participant) && count($licensees->participant)>0){
		foreach($licensees->participant as $participant){
			if($participant->status<2){
				array_push($participantsArray,$participant);
			} else {
				array_push($participantsDeniedArray,$participant);
			}
		}
	}
} else if($t==8 || $t==9){
	$participantsArray = $licensees->participant;
}

?>
<script>
function openFile(o){
	window.parent.open_drive_files(o.data('href'));
}
var participate_request_table = document.getElementById('participate_request_box'),hot1,_participateRequestJSON = [],_participateDeniedJSON=[],confirmed_request_table = document.getElementById('confirmed_request_box'),hot2,_confirmedRequestJSON = [],revised_request_table = document.getElementById('revised_request_box'),hot3,cofirmed_revised_request_table = document.getElementById('confirmed_revised_request_box'),hot6,_revisedRequestJSON = [],_revisedConfirmedRequestJSON = [],availability_request_table = document.getElementById('availability_request_box'),hot4,_availabilityRequestJSON = [],availability_request_table_confirmed = document.getElementById('availability_request_box_confirmed'),hot5,_availabilityConfirmedJSON = [],hot9,participate_denied_table;
if(document.getElementById('participate_denied_box')!=null){
	participate_denied_table = document.getElementById('participate_denied_box')
}
_availabilityRequestJSON=[
	<?php
		if(count($availability)>0){
			$i=0;
			foreach($availability as $contact){
				$companyName = (!empty($contact->contactCompanyName))?$contact->contactCompanyName:'';
				$companyID = (!empty($contact->companyID))?$contact->companyID:'';
				$contactCompanyName = (!empty($contact->contactCompanyName))?$contact->company_name:'';
				$personName = (!empty($contact->person_name))?$contact->person_name:'';
				$personContactID = (!empty($contact->contactID))?$contact->contactID:'';
				$leadName = $contact->lead_name;				
				$leadNameString = $leadName;
				$enter = false;
				$firstColor = "";
				$secondColor = "";
				$thirdColor = "";
				$leadID = $contact->leadID;
				 
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
				$companyName = (!empty($contact->contactCompanyName))?$contact->contactCompanyName:'';
				$companyID = (!empty($contact->companyID))?$contact->companyID:'';
				$contactCompanyName = (!empty($contact->contactCompanyName))?$contact->contactCompanyName:'';
				$personContactID = (!empty($contact->contactID))?$contact->contactID:'';
				$personName = (!empty($contact->person_name))?$contact->person_name:'';
				$leadName = $contact->lead_name;				
				$leadNameString = $leadName;
				$firstColor = "";
				$secondColor = "";
				$thirdColor = "";
				$leadID = $contact->leadID;
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
		if(isset($participantsArray) && count($participantsArray)>0){
			$i=0;
			foreach($participantsArray as $contact){
				$companyName = (!empty($contact->contactCompanyName))?$contact->contactCompanyName:'';
				$companyID = (!empty($contact->companyID))?$contact->companyID:'';
				$contactCompanyName = (!empty($contact->contactCompanyName))?$contact->contactCompanyName:'';
				$personContactID = (!empty($contact->contactID))?$contact->contactID:'';
				$personName = (!empty($contact->person_name))?$contact->person_name:'';
				$leadName = str_replace('_',' ',$contact->lead_name);
				$targetCompanyName = "";
				$licensePrice = 0;
				$documentType = "";
				$status = -1;
				if(isset($contact->target_company_name)){
					$targetCompanyName = $contact->target_company_name;
				}
				if(isset($contact->price)){
					$licensePrice = $contact->price;
				}
				if(isset($contact->document_type)){
					if($contact->document_type==2){
						$documentType = 'NEL';
					}else if($contact->document_type==3){
						$documentType = 'STL';
					}
				}
				if(isset($contact->status)){
					$status = $contact->status;
				}
				$fileData = "";
				if(!empty($contact->file)):
					$fileUrl = $contact->file;
					$fileData="";					
					$file = explode('?',$fileUrl);
					if(count($file)==2){
						$file = str_replace("edit?usp=drivesdk","preview",$fileUrl);
						$file = str_replace("view?usp=drivesdk","preview",$file);
					} else {
						$file = $fileUrl;
					}
					$fileData='<a data-mainhref="'.$contact->file.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue"><i class="fa fa-file-o"></i></a>';
					
				endif;
				$leadNameString = $leadName;
				$enter = false;
				$firstColor = "";
				$secondColor = "";
				$thirdColor = "";
				$leadID = $contact->leadID;
				$companyID = (!empty($contact->companyID))?$contact->companyID:'';
				$contactCompanyName = (!empty($contact->contactCompanyName))?$contact->company_name:'';
				$personContactID = (!empty($contact->contactID))?$contact->contactID:'';
				$message = addslashes($contact->message);
				$message = str_replace(array("\r", "\n"), '&#10;', $message);
				$participateType = '';
				switch((int)$contact->type){
					case 0:
					case 1:
						$participateType = 'Participate';
					break;
					case 2:
						$participateType = 'NEL';
					break;
					case 3:
						$participateType = 'STL';
					break;
					case 4:
						$participateType = 'Proof of Payment';
					break;
				}				
				$date = (!empty($contact->create_date))?date('H:i m/d/y',strtotime($contact->create_date)):'';
				echo "{'id':". $contact->id.",'message':'" . trim($message). "','company_name':'" . trim($companyName) . "','telephone':'" . $contact->person_phone . "','person_name':'" . $personName . "','lead_name':'" . trim($leadNameString) . "','email':'" . $contact->contactEmail . "','date':'" . $date . "','file_text':'" . $fileData . "','participate_type':'" . $participateType . "','action':'" . $contact->id . "','first_color':'" . $firstColor . "','second_color':'" . $secondColor . "','third_color':'" . $thirdColor . "','lead_id':'" . $leadID . "','contact_id':'".$personContactID."','customer_company_name':'".$contactCompanyName."','company_id':'".$companyID."','price':'".$licensePrice."','target_company':'".$targetCompanyName."','doc_type':'".$documentType."','status':'".$status."'}";
				if ($i < count($participantsArray) - 1) {
					echo ",";
				}
			}
		}
?>];
_participateDeniedJSON=[
	<?php
		if(isset($participantsDeniedArray) && count($participantsDeniedArray)>0){
			$i=0;
			foreach($participantsDeniedArray as $contact){
				$companyName = (!empty($contact->company_name))?$contact->company_name:'';
				$companyID = (!empty($contact->companyID))?$contact->companyID:'';
				$contactCompanyName = (!empty($contact->contactCompanyName))?$contact->contactCompanyName:'';
				$personContactID = (!empty($contact->contactID))?$contact->contactID:'';
				$personName = (!empty($contact->person_name))?$contact->person_name:'';
				$leadName = str_replace('_',' ',$contact->lead_name);
				$targetCompanyName = "";
				$licensePrice = 0;
				$status = -1;
				$documentType = "";
				if(isset($contact->target_company_name)){
					$targetCompanyName = $contact->target_company_name;
				}
				if(isset($contact->price)){
					$licensePrice = $contact->price;
				}
				if(isset($contact->document_type)){
					if($contact->document_type==2){
						$documentType = 'NEL';
					}else if($contact->document_type==3){
						$documentType = 'STL';
					}
				}
				if(isset($contact->status)){
					$status = $contact->status;
				}
				$fileData = "";
				if(!empty($contact->file)):
					$fileUrl = $contact->file;
					$fileData="";					
					$file = explode('?',$fileUrl);
					if(count($file)==2){
						$file = str_replace("edit?usp=drivesdk","preview",$fileUrl);
						$file = str_replace("view?usp=drivesdk","preview",$file);
					} else {
						$file = $fileUrl;
					}
					$fileData='<a data-mainhref="'.$contact->file.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue"><i class="fa fa-file-o"></i></a>';
					
				endif;
				$leadNameString = $leadName;
				$enter = false;
				$firstColor = "";
				$secondColor = "";
				$thirdColor = "";
				$leadID = $contact->leadID;
				$message = addslashes($contact->message);
				$message = str_replace(array("\r", "\n"), '&#10;', $message);
				$participateType = '';
				switch((int)$contact->type){
					case 0:
					case 1:
						$participateType = 'Participate';
					break;
					case 2:
						$participateType = 'NEL';
					break;
					case 3:
						$participateType = 'STL';
					break;
					case 4:
						$participateType = 'Proof of Payment';
					break;
				}				
				$date = (!empty($contact->create_date))?date('H:i m/d/y',strtotime($contact->create_date)):'';
				echo "{'id':". $contact->id.",'message':'" . trim($message). "','company_name':'" . trim($companyName) . "','telephone':'" . $contact->person_phone . "','person_name':'" . $personName . "','lead_name':'" . trim($leadNameString) . "','email':'" . $contact->contactEmail . "','date':'" . $date . "','file_text':'" . $fileData . "','participate_type':'" . $participateType . "','action':'" . $contact->id . "','first_color':'" . $firstColor . "','second_color':'" . $secondColor . "','third_color':'" . $thirdColor . "','lead_id':'" . $leadID . "','contact_id':'".$personContactID."','customer_company_name':'".$contactCompanyName."','company_id':'".$companyID."','price':'".$licensePrice."','target_company':'".$targetCompanyName."','doc_type':'".$documentType."','status':'".$status."','tap':''}";
				if ($i < count($participantsDeniedArray) - 1) {
					echo ",";
				}
			}
		}
?>];
_confirmedRequestJSON = [
<?php 
	if(isset($licensees->potential) && count($licensees->potential)>0){
		$i = 0;
		$leadNameArray = array();
		foreach($licensees->potential as $contact){
			$companyName = (!empty($contact->contactCompanyName))?$contact->contactCompanyName:'';
			$personName = (!empty($contact->person_name))?$contact->person_name:'';
			$leadName = str_replace('_',' ',$contact->lead_name);
			$leadNameString = $leadName;
			$enter = false;
			$firstColor = "";
			$secondColor = "";
			$thirdColor = "";
			if(count($leadNameArray)>0){
				foreach($leadNameArray as $lead){
					if($lead[0]==$leadName){
						$firstColor = $lead[1];
						$secondColor = $lead[2];
						$thirdColor = $lead[3];
						$enter = true;
						break;
					}
				}
			}
			if($enter==false){
				$firstColor = generateRandomNumber(3);
				$secondColor = generateRandomNumber(2);
				$thirdColor = generateRandomNumber(2);
				$leadNameArray[] = array($leadName,$firstColor,$secondColor,$thirdColor);
			}
			$leadID = $contact->leadID;
			$date = ($contact->create_date!='0000-00-00 00:00:00')?date('H:i  m/d/y',strtotime($contact->create_date)):'';
			$sendDate = "";
			if(isset($contact->send_date)){
				$sendDate = ($contact->send_date!='0000-00-00 00:00:00')?date('H:i  m/d/y',strtotime($contact->send_date)):'';
			}
			$payment_notice ='';
			if(isset($contact->payment_notice)){
				$payment_notice = ($contact->payment_notice!='0000-00-00 00:00:00')?date('H:i  m/d/y',strtotime($contact->payment_notice)):'';
			}
			$upload_date = '';
			if(isset($contact->upload_date)){
				$upload_date = ($contact->upload_date!='0000-00-00 00:00:00' && $contact->upload_date!='')?date('H:i  m/d/y',strtotime($contact->upload_date)):'';
			}
			$deadline = '';
			if(isset($contact->deadline)){
				$deadline = ($contact->deadline!='0000-00-00 00:00:00' && $contact->deadline!='')?date('m/d/y',strtotime($contact->deadline)):'';
			}
			$upfront = '';
			if(isset($contact->upfront)){
				$upfront = $contact->upfront;
			}
			$viewFile="";
			$targetCompanyName = "";
			if(isset($contact->target_company_name)){
				$targetCompanyName = $contact->target_company_name;
			}
			$documentType = "";
			if(isset($contact->doc_type)){
				if($contact->doc_type==2){
					$documentType = "NEL";
				} else if($contact->doc_type==3){
					$documentType = "STL";
				}
			}
			if(!empty($contact->file)):
				$file = explode('?',$contact->file);
				if(count($file)==2){
					$file = str_replace("edit?usp=drivesdk","preview",$contact->file);
					$file = str_replace("view?usp=drivesdk","preview",$file);
				} else {
					$file = $contact->file;
				}
				$viewFile='<a data-mainhref="'.$contact->file.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue"><i class="fa fa-file-o"></i></a>';
			endif;		
			$participateType = '';
			switch((int)$contact->type){
				case 0:
				case 1:
					$participateType = 'RTP';
				break;
				case 2:
				case 3:
				case 4:
					$participateType = 'License';
				break;
			}
			$price = "";
			if(isset($contact->price)){
				$price = $contact->price;
			}
			$amount = "";
			if(isset($contact->amount)){
				$amount = $contact->amount;
			}
			$display = "";
			if(isset($contact->display)){
				$display = $contact->display;
			}
			$cost_price = 0.00;
			if(isset($contact->cost_price)){
				$cost_price = $contact->cost_price;
			}
			$checked="";
			if($display==1){
				$checked='CHECKED="CHECKED"';
			}
			$displayString = '<input type="checkbox" name="potential_syndicates[]" '.$checked.' value="'.$contact->id.'" onclick="showBtnUpdate(jQuery(this))"/>';
			$companyID = (!empty($contact->companyID))?$contact->companyID:'';
			$contactCompanyName = (!empty($contact->contactCompanyName))?$contact->contactCompanyName:'';
			$personContactID = (!empty($contact->contactID))?$contact->contactID:'';
			$message = '';
			if(isset($contact->message)){
				$message = addslashes($contact->message);
				$message = str_replace(array("\r", "\n"), '&#10;', $message);
			}
			$proof_of_payment = "";
			$execute_agreement = "";
			if(isset($contact->proof_of_payment) && $contact->proof_of_payment!=null && $contact->proof_of_payment!=""){
				$file = explode('?',$contact->proof_of_payment);
				if(count($file)==2){
					$file = str_replace("edit?usp=drivesdk","preview",$contact->proof_of_payment);
					$file = str_replace("view?usp=drivesdk","preview",$file);
				} else {
					$file = $contact->proof_of_payment;
				}
				$proof_of_payment='<span style="display:inline-block;width:100%;text-align:center;"><a data-mainhref="'.$contact->proof_of_payment.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue"><i class="fa fa-file-o"></i></a></span>';
			}
			if($contact->execute_agreement!=null && $contact->execute_agreement!=""){
				$file = explode('?',$contact->execute_agreement);
				if(count($file)==2){
					$file = str_replace("edit?usp=drivesdk","preview",$contact->execute_agreement);
					$file = str_replace("view?usp=drivesdk","preview",$file);
				} else {
					$file = $contact->execute_agreement;
				}
				$execute_agreement='<a data-mainhref="'.$contact->execute_agreement.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue"><i class="fa fa-file-o"></i></a>';
			}
			$avg = 0.00;
			if(isset($contact->avg)){
				$avg = $contact->avg;
			}
			$sum = 0.00;
			if(isset($contact->sum)){
				$sum = $contact->sum;
			}
			$upfront_diff = $sum - $upfront;
			$diff = $price - $avg;
			$participant_status ="";
			if(isset($contact->participant_status)){
				$participant_status = $contact->participant_status;
			}
			$colored = 0;
			if(isset($contact->colored)){
				$colored = $contact->colored;
			}
			$person_phone = "";
			if(isset($contact->person_phone)){
				$person_phone = $contact->person_phone;
			}
			$person_email = "";
			if(isset($contact->contactEmail)){
				$person_email = $contact->contactEmail;
			}
			$type = 0;
			if(isset($contact->type)){
				$type = $contact->type;
			}
			echo "{'id':". $contact->id.",'license_id':". $contact->license_id.",'message':'" . trim($message). "','company_name':'" . trim($companyName) . "','person_name':'" . trim($personName) . "','telephone':'" . $person_phone . "','lead_name':'" . $leadNameString . "','email':'" . $person_email . "','date':'" . $date . "','send_date':'" . $sendDate . "','view_file':'" . $viewFile . "','participate_type':'" . $participateType . "','price':'" . $price . "','displayString':'" . $displayString . "','display':'" . $display . "','type':".(int)$type.",'colored':" . $colored . ",'payment_notice':'" . $payment_notice . "','proof_of_payment':'" . $proof_of_payment . "','execute_agreement':'" . $execute_agreement . "','first_color':'" . $firstColor . "','second_color':'" . $secondColor . "','third_color':'" . $thirdColor . "','lead_id':'" . $leadID . "','amount':'" . $amount . "','cost_price':'" . $cost_price . "','contact_id':'".$personContactID."','customer_company_name':'".$contactCompanyName."','company_id':'".$companyID."','doc_type':'".$documentType."','target_company_name':'".$targetCompanyName."','participant_status':'".$participant_status."','received_date':'".$upload_date."','upfront':'".$upfront."','deadline':'".$deadline."','avg':'".$avg."','diff':'".$diff."','sum':'".$sum."','upfront_diff':'".$upfront_diff."'}";
			if ($i < count($licensees->potential) - 1) {
				echo ",";
			}
			$i++;
		}
	}
?>
];
_revisedRequestJSON = [
<?php 
	if(isset($licensees->revised) && count($licensees->revised)>0){
		$i=0;
		foreach($licensees->revised as $contact){
			$companyName = (!empty($contact->contactCompanyName))?$contact->contactCompanyName:'';
			$personName = (!empty($contact->person_name))?$contact->person_name:'';
			$leadName = str_replace('_',' ',$contact->lead_name);
			$leadNameString = $leadName;
			$enter = false;
			$firstColor = "";
			$secondColor = "";
			$thirdColor = "";
			$leadID = $contact->leadID;
			$serialNumber = $contact->serial_number;
			$participateType="";
			$date = (!empty($contact->create_date))?date('H:i m/d/y',strtotime($contact->create_date)):'';
			$confirmDate = (!empty($contact->confirm_date) && $contact->confirm_date!=null&& $contact->confirm_date!='0000-00-00 00:00:00')?date('H:i m/d/y',strtotime($contact->confirm_date)):'';
			$approval = $contact->approved;
			
			switch((int)$contact->rf_type){
				case 1:
				case 2:
					$participateType = 'NEL';
				break;
				case 3:
					$participateType = 'STL';
				break;
			}
			$license_aggreement="";
			if(!empty($contact->license_aggreement)):
				$file = pathinfo($contact->license_aggreement);
				$fileUrl = str_replace("/var/www/html/","https://www.synpat.com/",$file['dirname']);
				$fileUrl = str_replace("/home/synpatne/public_html/synpat_com/store/","https://www.synpat.com/",$fileUrl);
				$fileUrl = str_replace("/var/www/synpat/store/","https://www.synpat.com/",$fileUrl);
				$license_aggreement='<a class="font-blue" href="'.$fileUrl.'/'.$file['basename'].'" target="_BLANK"><i class="fa fa-edit"></i></a>';
			endif;
			$strategic_aggreement="";
			if(!empty($contact->strategic_aggreement)):
				$file = pathinfo($contact->strategic_aggreement);
				$fileUrl = str_replace("/var/www/html/","https://www.synpat.com/",$file['dirname']);
				$fileUrl = str_replace("/home/synpatne/public_html/synpat_com/store/","https://www.synpat.com/",$fileUrl);
				$fileUrl = str_replace("/var/www/synpat/store/","https://www.synpat.com/",$fileUrl);
				$strategic_aggreement='<a class="font-blue" href="'.$fileUrl.'/'.$file['basename'].'" target="_BLANK"><i class="fa fa-edit"></i></a>';
			endif;
			$request_aggreement="";
			if(!empty($contact->request_aggreement)):
				$file = pathinfo($contact->request_aggreement);
				$fileUrl = str_replace("/var/www/html/","https://www.synpat.com/",$file['dirname']);
				$fileUrl = str_replace("/home/synpatne/public_html/synpat_com/store/","https://www.synpat.com/",$fileUrl);
				$fileUrl = str_replace("/var/www/synpat/store/","https://www.synpat.com/",$fileUrl);
				$request_aggreement='<a class="font-blue" href="'.$fileUrl.'/'.$file['basename'].'" target="_BLANK"><i class="fa fa-edit"></i></a>';
			endif;
			$program_aggreement="";
			if(!empty($contact->program_aggreement)):
				$file = pathinfo($contact->program_aggreement);
				$fileUrl = str_replace("/var/www/html/","https://www.synpat.com/",$file['dirname']);
				$fileUrl = str_replace("/home/synpatne/public_html/synpat_com/store/","https://www.synpat.com/",$fileUrl);
				$fileUrl = str_replace("/var/www/synpat/store/","https://www.synpat.com/",$fileUrl);
				$program_aggreement='<a class="font-blue" href="'.$fileUrl.'/'.$file['basename'].'" target="_BLANK"><i class="fa fa-edit"></i></a>';
			endif;
			$fileType = $contact->rf_type;
			$fileLinkWithText = "";
			$file = "";
			switch((int)$fileType){
				case 1:
					if(!empty($contact->request_aggreement)){
						$file = $contact->request_aggreement;
						$fileLinkWithText='<a data-mainhref="'.$file.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue" ><i class="fa fa-edit"></i></a>';
					}
				break;
				case 2:
					if(!empty($contact->license_aggreement)){
						$file = $contact->license_aggreement;
						$fileLinkWithText='<a data-mainhref="'.$file.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue" ><i class="fa fa-edit"></i></a>';
					}
				break;
				case 3:
					if(!empty($contact->strategic_aggreement)){
						$file = $contact->strategic_aggreement;
						$fileLinkWithText='<a data-mainhref="'.$file.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue" ><i class="fa fa-edit"></i></a>';
					}
				break;
			}
			$todo = "";
			if($contact->status==1){
				$todo = "ToDo";
			} else if ($contact->status==2){
				$todo = "Done";
			}
			$companyID = (!empty($contact->companyID))?$contact->companyID:'';
			$personContactID = (!empty($contact->contactID))?$contact->contactID:'';
			$message = addslashes($contact->message);
			$message = str_replace(array("\r", "\n"), '&#10;', $message);
			echo "{'id':". $contact->id.",'approve':'" . $approval. "','message':'" . trim($message). "','company_name':'" . trim($companyName) . "','person_name':'" . trim($personName) . "','lead_name':'" . trim($leadNameString) . "','email':'" . $contact->contactEmail . "','date':'" . $date . "','file':'".$file."','file_text':'" . $fileLinkWithText . "','action':'" . $contact->id . "','first_color':'" . $firstColor . "','second_color':'" . $secondColor . "','third_color':'" . $thirdColor . "','todo':'".$todo."','type':'".$participateType."','contact_id':'".$personContactID."','doc_status':'".$contact->status."','confirm_date':'".$confirmDate."','lead_id':'" . $leadID . "','company_id':'".$companyID."','serial_number':'".$serialNumber."','target_company_name':'".$contact->target_company_name."'}";
			if ($i < count($licensees->revised) - 1) {
				echo ",";
			}
			$i++;
		}
	}
?>
];
_revisedConfirmedRequestJSON = [
<?php 
	if(isset($licensees->confirmed_revised) && count($licensees->confirmed_revised)>0){
		$i=0;
		foreach($licensees->confirmed_revised as $contact){
			$companyName = (!empty($contact->contactCompanyName))?$contact->contactCompanyName:'';
			$personName = (!empty($contact->person_name))?$contact->person_name:'';
			$leadName = str_replace('_',' ',$contact->lead_name);
			$leadNameString = $leadName;
			$enter = false;
			$firstColor = "";
			$secondColor = "";
			$thirdColor = "";
			$leadID = $contact->leadID;
			$serialNumber = $contact->serial_number;
			$participateType="";
			$date = (!empty($contact->create_date))?date('H:i m/d/y',strtotime($contact->create_date)):'';
			$confirmDate = (!empty($contact->confirm_date) && $contact->confirm_date!=null&& $contact->confirm_date!='0000-00-00 00:00:00')?date('H:i m/d/y',strtotime($contact->confirm_date)):'';
			$approval = $contact->approved;
			switch((int)$contact->rf_type){
					case 1:
					case 2:
						$participateType = 'NEL';
					break;
					case 3:
						$participateType = 'STL';
					break;
				}
			$license_aggreement="";
			if(!empty($contact->license_aggreement)):
				$file = pathinfo($contact->license_aggreement);
				$fileUrl = str_replace("/var/www/html/","https://www.synpat.com/",$file['dirname']);
				$fileUrl = str_replace("/home/synpatne/public_html/synpat_com/store/","https://www.synpat.com/",$fileUrl);
				$fileUrl = str_replace("/var/www/synpat/store/","https://www.synpat.com/",$fileUrl);
				$license_aggreement='<a class="font-blue" href="'.$fileUrl.'/'.$file['basename'].'" target="_BLANK"><i class="fa fa-edit"></i></a>';
			endif;
			$strategic_aggreement="";
			if(!empty($contact->strategic_aggreement)):
				$file = pathinfo($contact->strategic_aggreement);
				$fileUrl = str_replace("/var/www/html/","https://www.synpat.com/",$file['dirname']);
				$fileUrl = str_replace("/home/synpatne/public_html/synpat_com/store/","https://www.synpat.com/",$fileUrl);
				$fileUrl = str_replace("/var/www/synpat/store/","https://www.synpat.com/",$fileUrl);
				$strategic_aggreement='<a class="font-blue" href="'.$fileUrl.'/'.$file['basename'].'" target="_BLANK"><i class="fa fa-edit"></i></a>';
			endif;
			$request_aggreement="";
			if(!empty($contact->request_aggreement)):
				$file = pathinfo($contact->request_aggreement);
				$fileUrl = str_replace("/var/www/html/","https://www.synpat.com/",$file['dirname']);
				$fileUrl = str_replace("/home/synpatne/public_html/synpat_com/store/","https://www.synpat.com/",$fileUrl);
				$fileUrl = str_replace("/var/www/synpat/store/","https://www.synpat.com/",$fileUrl);
				$request_aggreement='<a class="font-blue" href="'.$fileUrl.'/'.$file['basename'].'" ><i class="fa fa-edit"></i></a>';
			endif;
			$program_aggreement="";
			if(!empty($contact->program_aggreement)):
				$file = pathinfo($contact->program_aggreement);
				$fileUrl = str_replace("/var/www/html/","https://www.synpat.com/",$file['dirname']);
				$fileUrl = str_replace("/home/synpatne/public_html/synpat_com/store/","https://www.synpat.com/",$fileUrl);
				$fileUrl = str_replace("/var/www/synpat/store/","https://www.synpat.com/",$fileUrl);
				$program_aggreement='<a class="font-blue" href="'.$fileUrl.'/'.$file['basename'].'" ><i class="fa fa-edit"></i></a>';
			endif;
			$fileType = $contact->rf_type;
			$fileLinkWithText = "";
			switch((int)$fileType){
				case 1:
					if(!empty($contact->request_aggreement)){
						$file = $contact->request_aggreement;
						$fileLinkWithText='<a data-mainhref="'.$file.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue"><i class="fa fa-edit"></i></a>';
					}
				break;
				case 2:
					if(!empty($contact->license_aggreement)){
						$file = $contact->license_aggreement;
						$fileLinkWithText='<a data-mainhref="'.$file.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue"><i class="fa fa-edit"></i></a>';
					}
				break;
				case 3:
					if(!empty($contact->strategic_aggreement)){
						$file = $contact->strategic_aggreement;
						$fileLinkWithText='<a data-mainhref="'.$file.'"  data-href="'.$file.'"  href="javascript://" onclick="openFile(jQuery(this))" class="font-blue"><i class="fa fa-edit"></i></a>';
					}
				break;
			}
			$todo = "";
			if($contact->status==1){
				$todo = "ToDo";
			} else if ($contact->status==2){
				$todo = "Done";
			}
			$companyID = (!empty($contact->companyID))?$contact->companyID:'';
			$personContactID = (!empty($contact->contactID))?$contact->contactID:'';
			$message = addslashes($contact->message);
			$message = str_replace(array("\r", "\n"), '&#10;', $message);
			echo "{'id':". $contact->id.",'approve':'" . $approval. "','message':'" . trim($message). "','company_name':'" . trim($companyName) . "','person_name':'" . trim($personName) . "','lead_name':'" . trim($leadNameString) . "','email':'" . $contact->contactEmail . "','date':'" . $date . "','file_text':'" . $fileLinkWithText . "','action':'" . $contact->id . "','first_color':'" . $firstColor . "','second_color':'" . $secondColor . "','third_color':'" . $thirdColor . "','todo':'".$todo."','type':'".$participateType."','contact_id':'".$personContactID."','doc_status':'".$contact->status."','confirm_date':'".$confirmDate."','lead_id':'" . $leadID . "','company_id':'".$companyID."','serial_number':'".$serialNumber."'}";
			if ($i < count($licensees->confirmed_revised) - 1) {
				echo ",";
			}
			$i++;
		}
	}
?>
];
_licenseAvailable =[
<?php
	if(isset($license_list) && count($license_list)){
		$i=0;
		foreach($license_list as $license){
			$leadName = $license->lead_name;				
			$licenseType = "";
			$companyName = $license->company_name;
			if($license->file_type==2){
				$licenseType = "NEL";
			}else if($license->file_type==3){
				$licenseType = "STL";
			}
			$availableFor = $license->target;
			echo "{'lead_name':'". $leadName."','license_type':'" . $licenseType. "','company_name':'" . $companyName. "','available_for':'" . $availableFor . "'}";
			if ($i < count($license_list) - 1) {
				echo ",";
			}
			$i++;
		}
	}
?>
];
var _licenseKey = '139eb-e1f6b-37930-9440d-a1020';
	var __baseUrl = '<?php echo $Layout->baseUrl?>';
	var totalHeight = jQuery(window).height();
	var mainHeight = (totalHeight - 120);
	var availableWidth = jQuery(window).width();
	availableWidth = availableWidth-45;	
	jQuery('.scroll-container').eq(0).css('height',mainHeight+'px');
	cont = mainHeight - 50;
	jQuery('.scroll-container').eq(1).css('height',cont+'px');
	jQuery('.scroll-container').eq(2).css('height',cont+'px');
	jQuery('.scroll-container').eq(3).css('height',cont+'px');
	
var _t = '<?php echo $t?>';
jQuery(window).on('resize',function(){
	console.log('T:'+_t);
	availableWidth = jQuery(window).width();
	availableWidth = availableWidth-45;	
	if(_t==2){
		_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width = _width-10; 
		hot3.updateSettings({
			width:_width,
			modifyColWidth: function(width, col){
		  switch(col){
			  case 0:
				return 104;
				break;
			case 1:
				return 174;
				break;
			case 2:
				return 164;
				break;
			case 3:
				return 100;
				break;
			 case 4:
				return 55;
				break;
			case 5:
				return 164;
				break;
			  case 6:
				return parseInt(_width * (19/100));
				break;
			  case 7:
				return parseInt(_width * (15/100));
				break;
		  } 
		}
		});
		hot6.updateSettings({
			width:_width,
			modifyColWidth: function(width, col){
			  switch(col){
			  case 0:
				return 104;
				break;
			case 1:
				return 104;
				break;
			case 2:
				return 174;
				break;
			case 3:
				return 164;
				break;
			 case 4:
				return 100;
				break;
			case 5:
				return 55;
				break;
			  case 6:
				return 164;
				break;
			  case 7:
				return parseInt(_width * (15/100));
				break;
		  }
			}
		});
	}else if(_t==3){
		_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width = _width-10; 
		hot2.updateSettings({
			width:_width,
		modifyColWidth: function(width, col){
			  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 104;
					break;
				  case 2:
					return 174;
					break;
				  case 3:
					return 164;
					break;
				  case 4:
					return 100;
					break;
				case 5:
					return parseInt(_width * (3/100));
					break;
				case 6:
					return 55;
					break;
				case 7:
					return 164;
				break;
				case 8:
					return parseInt(_width * (3/100));
					break;
				case 9:
					return parseInt(_width * (4/100));
					break;
				case 10:
					return parseInt(_width * (8/100));
					break;
			  } 
			}
		});
	}else if(_t==4){
		_width = jQuery('#availability_request_box').parent().width();
		//_width = _width-30; 
		hot4.updateSettings({
			width:_width,
			modifyColWidth: function(width, col){
			  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				  case 4:
					return 55;
					break;
				  case 5:
					return 164;
					break;
				case 6:
					return 80;
					break;
			   case 7:
					return 89;
					break;
				}  
			}
		});
		hot5.updateSettings({
			width:jQuery('#availability_request_box').parent().width(),
			modifyColWidth: function(width, col){
			  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				  case 4:
					return 55;
					break;
				  case 5:
					return 164;
					break;
				case 6:
					return 80;
					break;
				case 7:
					return 89;
					break;	
				}  
			}
		});
		_width = jQuery('#available_license').parent().width();
		//_width = _width-30; 
		h20.updateSettings({
			width:_width,
		});
	}else if(_t==1){
		_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width = _width-30; 
		hot1.updateSettings({
			width:_width,
			modifyColWidth: function(width, col){
				  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				  case 4:
					return 55;
					break;
				  case 5:
					return 164;
					break;
				   case 6:
					return parseInt(_width * (4/100));
					break;
				  case 7:
					return parseInt(_width * (13/100));
						
					break;
				}
			}
		});
		hot9.updateSettings({
			width:_width,
			modifyColWidth: function(width, col){
			  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				  case 4:
					return 55;
					break;
				  case 5:
					return 164;
					break;
				   case 6:
					return parseInt(_width * (4/100));
					break;
				  case 7:
					return parseInt(_width * (13/100));
						
					break;
				}
			}
		});
	} else if(_t==8 || _t==9){
		hot1.updateSettings({
			width:_width,
		modifyColWidth: function(width, col){
			    switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				  case 4:
					return 55;
					break;
				  case 5:
					return parseInt(_width * (20/100));
					break;
				  case 6:
					return parseInt(_width * (15/100));
					break;
				}  
			}
		});
	}
});
function sortDateFunction(sortOrder, columnMeta){	
console.log('sort');
  	return function(a, b) {
		if (a[1] === b[1]) {
			return 0;
		}
		if (a[1] === null || a[1] === '') {
			return 1;
		}
		if (b[1] === null || b[1] === '') {
			return -1;
		}
		var aDate = moment(a[1], 'HH:mm MM/DD/YY');
		var bDate = moment(b[1], 'HH:mm MM/DD/YY');
		console.log('aDate %s , bDate %s',aDate,bDate);
		if (!aDate.isValid()) {
			return 1;
		}
		if (!bDate.isValid()) {
			return -1;
		}
		if (bDate.isAfter(aDate)) {
			return sortOrder ? -1 : 1;
		}
		if (bDate.isBefore(aDate)) {
			return sortOrder ? 1 : -1;
		}
    }	
}
function implementLicenseAvailable(){
	elementC = document.getElementById('available_license');
	_width = jQuery('#available_license').parent().width();
	_width -=10;
	h20 = new Handsontable(elementC,{
		data: _licenseAvailable,
		licenseKey:_licenseKey,
		autoWrapCol:true,
		wordWrap:true,
		rowHeaders: false,
		minSpareRows: 0,
		minSpareCols: 0,
		manualColumnResize:true ,
		minCols: 8,
		maxCols: 8,
		maxRows: _licenseAvailable.length,
		width:function(){return _width;},
		height:function(){return dHeight;},
		fillHandle: false,
		stretchH:"all",
		colHeaders:['Portfolio','Customer','Type','Target'],
		columnSorting: {						
			sortOrder: true
		},
		contextMenu: false,
		filters: true,
		dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
		columns: [
			{
				data:'lead_name',
				readOnly: true
			},
			{
				data:'company_name',
				readOnly:true
			},
			{
				data:'license_type',
				readOnly:true
			},
			{
				data:'available_for',
				readOnly: true
			},
		]
	});
}
<?php if($t==4):?>	
dHeight = mainHeight;
dHeight -=70;
dHeight = dHeight/2;
jQuery('.scroll-container').eq(0).css({height:dHeight+'px',overflow:'auto'});
jQuery('.scroll-container').eq(1).css({height:dHeight+'px',overflow:'auto'});
/*availableWidth = jQuery("#availability_request_box").parent().parent().width() - 20;
availableWidth = jQuery(window).width() - 45;*/
function implementAvailabilityTable(){
	_width = jQuery('.scroll-container').eq(0).outerWidth();
	_width -=30;
	jQuery('#countAvailability').html(_availabilityRequestJSON.length);
	hot4 = new Handsontable(availability_request_table, {
		data: _availabilityRequestJSON,
		licenseKey:_licenseKey,
		autoWrapCol:true,
		wordWrap:true,
		rowHeaders: false,
		minSpareRows: 0,
		minSpareCols: 0,
		manualColumnResize:true ,
		minCols: 8,
		maxCols: 8,
		maxRows: _availabilityRequestJSON.length,
		width:function(){return jQuery("#availability_request_box").parent().width();},
		height:function(){return dHeight;},
		fillHandle: false,
		stretchH:"all",
		colHeaders:['Arrived At','Portfolio','Customer','Name','Type','3rd Party','Available','<span style="margin-right:10px;margin-left:5px;display:inline-block;width:20px;" title="Reply"><i class="fa fa-reply"></i></span>'],
		columnSorting: {						
			sortOrder: true
		},
		contextMenu: false,
		filters: true,
		modifyColWidth: function(width, col){
			  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				  case 4:
					return 55;
					break;
				  case 5:
					return 164;
					break;
				case 6:
					return 80;
					break;
			   case 7:
					return 89;
					break;
				}
			},
		dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
		columns: [
			{
				data:'date',
				type: 'text',
				sortFunction: sortDateFunction,
				readOnly: true
			},
			{
				data:'lead_name',
				renderer: htmlParticipateLeadRender,
				readOnly:true
			},
			{
				data:'company_name',
				renderer:htmlCompanyProfileRender,
				readOnly:true
			},
			{
				data:'person_name',
				renderer:htmlPersonProfileRender,
				readOnly:true
			},			
			{
				data:'participate_type',
				readOnly: true
			},
			{
				data:'check_for',
				readOnly: true
			},			
			{
				data:'available',
				type: 'checkbox',
				checkedTemplate: 'yes',
				uncheckedTemplate: 'no'
			},
			{
				data:'action',
				readOnly: true,
				renderer: actionAvailabilityRender,
			}		  
		]
	});
}
implementAvailabilityTable();
function implementAvailabilityConfirmedTable(){	
	_width = jQuery('.scroll-container').eq(0).outerWidth();
	_width -=30;
	hot5 = new Handsontable(availability_request_table_confirmed, {
		data: _availabilityConfirmedJSON,
		licenseKey:_licenseKey,
		autoWrapCol:true,
		wordWrap:true,
		rowHeaders: false,
		minSpareRows: 0,
		minSpareCols: 0,
		manualColumnResize:true ,
		minCols: 8,
		maxCols: 8,
		maxRows: _availabilityConfirmedJSON.length,
		width:function(){return jQuery("#availability_request_box_confirmed").parent().width();},
		height:function(){return dHeight;},
		fillHandle: false,
		stretchH:"all",
		colHeaders:['Arrived At','Portfolio','Customer','Name','Type','3rd Party','Available',''],
		modifyColWidth: function(width, col){
			  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				  case 4:
					return 55;
					break;
				  case 5:
					return 164;
					break;
				case 6:
					return 80;
					break;
					case 7:
					return 89;
					break;
				}
		},
		columnSorting: {						
			sortOrder: true
		},
		contextMenu: false,
		filters: true,
		dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
		columns: [
			{
				data:'date',
				type: 'text',
				sortFunction: sortDateFunction,
				readOnly: true
			},
			{
				data:'lead_name',
				renderer: htmlParticipateLeadRender,
				readOnly:true
			},
			{
				data:'company_name',
				renderer:htmlCompanyProfileRender,
				readOnly:true
			},
			{
				data:'person_name',
				renderer:htmlPersonProfileRender,
				readOnly:true
			},			
			{
				data:'participate_type',
				readOnly: true
			},
			{
				data:'check_for',
				readOnly: true
			},			
			{
				data:'available',
				type: 'checkbox',
				checkedTemplate: 'yes',
				uncheckedTemplate: 'no',readOnly: true
			}
			,			
			{
				data:'id',
				renderer:htmlEmptyRender,
				readOnly: true
			}
		]
	});
}
implementAvailabilityConfirmedTable();
implementLicenseAvailable();
<?php endif;?>
<?php if($t==1 || $t==8 || $t==9):?>
dHeight = mainHeight;
availableWidth = jQuery(window).width() - 45;
jQuery('.scroll-container').eq(0).css({height:dHeight+'px',overflow:'auto'});
dHeight -=50;
jQuery('#participate_request_box').css({height:dHeight+'px'}).attr('data-originalstyle','height: '+dHeight+'px; overflow: hidden; width: 1858px;');
function implementParticipateTable(){
	if(_t==1){
		dHeight -=30;
		dHeight = dHeight/2;
		_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width = _width-30;
		jQuery('.scroll-container').eq(0).css({height:dHeight+'px',overflow:'auto'});
		jQuery('.scroll-container').eq(1).css({height:dHeight+'px',overflow:'auto'});
		_colHeaders = ['Arrived At','Portfolio','Customer','Name','Type','Target','$','<span style="margin-right:10px;margin-left:5px;display:inline-block;width:20px;" title="Open"><i class="fa fa-file-o"></i></span><span style="margin-right:10px;display:inline-block;width:20px;" title="Reply"><i class="fa fa-reply"></i></span>'];
		_columns = [
			  {
				data:'date',
				type: 'text',
				sortFunction: sortDateFunction,
				readOnly: true
			  },
			  {
				data:'lead_name',
				renderer: htmlParticipateLeadRender,
				readOnly:true
			  },
			  {
				data:'company_name',
				renderer:htmlCompanyProfileRender,
				readOnly:true
			  },
			  {
				data:'person_name',
				renderer:htmlPersonProfileRender,
				readOnly:true
			  },
			  {
				data:'doc_type',
				type: 'dropdown',
				source: ['NEL', 'STL'],
				readOnly: false
			  },
			  {
				data:'target_company',
				type: 'autocomplete',
				source: function (query, process) {
					jQuery.ajax({
					   url: __baseUrl+'opportunity/find_company_list_by_name',
					  dataType: 'json',
					  data: {
						query: query
					  },
					  success: function (response) {
						console.log("response", response);
						//process(JSON.parse(response.data)); // JSON.parse takes string as a argument
						process(response);

					  }
					});
			     },
				strict: false
			  },
			  {
				data:'price',
				readOnly:false
			  },		  
			  {
				data:'action',
				readOnly: true,
				renderer: actionParticipateStatusRender,
			  }		  
			];
			hot1 = new Handsontable(participate_request_table, {
			data: _participateRequestJSON,
			licenseKey:_licenseKey,
			rowHeaders: false,
			minSpareRows: 0,
			minSpareCols: 0,
			minCols: 8,
			maxCols: 8,
			maxRows: _participateRequestJSON.length,
			width:function(){return 930;},
			height:function(){return dHeight;},
			fillHandle: false,
			stretchH:"all",		
			colHeaders:_colHeaders,
			columnSorting: {						
				sortOrder: true
			},
			modifyColWidth: function(width, col){
				  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				  case 4:
					return 55;
					break;
				  case 5:
					return 164;
					break;
				   case 6:
					return 70;
					break;
				  case 7:
					return 99;						
					break;
				}
			},
			contextMenu: false,
			filters: true,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
			columns: _columns,
			afterChange: function(changes, source) {
				if(source=="edit"){
					if(typeof changes[0]!="undefined" && changes[0][1]!=null && typeof changes[0][1]!="undefined"){
						_sp = false;
						switch(changes[0][1]){
							case 'price':
								_sp = true;
								break;
							case 'doc_type':
								_sp = true;
								break;
							case 'target_company':
								_sp = true;
								break;
						}
						if(_sp === true){
							console.log(changes);
							/*save changes to DB*/
							var logicalIndex = changes[0][0];
							if(typeof hot1.sortIndex!="undefined" && typeof hot1.sortIndex.length!="undefined"){
								/*var physicalIndex = hot2.sortIndex.length > 0 ? hot2.sortIndex[logicalIndex][0] : logicalIndex;*/
								logicalIndex = hot1.sortIndex.length > 0 ? hot1.sortIndex[logicalIndex][0] : logicalIndex;
							}
							_rowID = hot1.getDataAtRowProp(logicalIndex,'id');
							if(_rowID>0){
								jQuery.ajax({
									url:__baseUrl+'opportunity/update_request_to_participate_data',
									type:'POST',
									data:{d:changes[0],t:_rowID},
									cache:false
								}).done(function(data,textStatus,xhr){
									
								})
							}							
						}
					}					
				}
			}
		});
		hot9 = new Handsontable(participate_denied_table, {
			data: _participateDeniedJSON,
			licenseKey:_licenseKey,
			rowHeaders: false,
			minSpareRows: 0,
			minSpareCols: 0,
			manualColumnResize:true ,
			minCols: 9,
			maxCols: 9,
			maxRows: _participateDeniedJSON.length,
			width:function(){return 930;},
			height:function(){return dHeight;},
			fillHandle: false,
			stretchH:"all",		
			colHeaders:['Arrived At','Portfolio','Customer','Name','Type','Target','$','<span style="margin-right:10px;margin-left:5px;display:inline-block;width:20px;" ></span>'],
			columnSorting: {						
				sortOrder: true
			},
			modifyColWidth: function(width, col){
				  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				  case 4:
					return 55;
					break;
				  case 5:
					return 164;
					break;
				   case 6:
					return 79;
					break;
				  case 7:
					return 89;
						
					break;
				}
			},
			contextMenu: false,
			filters: true,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
			columns: [
			  {
				data:'date',
				type: 'text',
				sortFunction: sortDateFunction,
				readOnly: true
			  },
			  {
				data:'lead_name',
				renderer: htmlParticipateLeadRender,
				readOnly:true
			  },
			  {
				data:'company_name',
				renderer:htmlCompanyProfileRender,
				readOnly:true
			  },
			  {
				data:'person_name',
				renderer:htmlPersonProfileRender,
				readOnly:true
			  },
			  {
				data:'doc_type',
				readOnly: true
			  },
			  {
				data:'target_company',
				readOnly: true
			  },
			  {
				data:'price',
				readOnly:true
			  }	,
			  {
				data:'tap',
				readOnly:true
			  }
			]
		});
		implementLicenseAvailable();
	} else {
		_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width = _width-30;
		hot1 = new Handsontable(participate_request_table, {
			data: _participateRequestJSON,
			licenseKey:_licenseKey,
			autoWrapCol:true,
			wordWrap:true,
			rowHeaders: false,
			minSpareRows: 0,
			minSpareCols: 0,
			manualColumnResize:true ,
			minCols: 7,
			maxCols: 7,
			maxRows: _participateRequestJSON.length,
			width:function(){return _width;},
			height:function(){return dHeight;},
			fillHandle: false,
			stretchH:"all",		
			colHeaders:['Arrived At','Portfolio','Customer','Name','Type','Message','<span style="margin-right:10px;margin-left:5px;display:inline-block;width:30px;" title="Open"><i class="fa fa-file-o"></i></span><span style="margin-right:10px;display:inline-block;width:30px;" title="Reply"><i class="fa fa-reply"></i></span>'],
			columnSorting: {						
				sortOrder: true
			},
			modifyColWidth: function(width, col){
			    switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				  case 4:
					return 55;
					break;
				  case 5:
					return parseInt(_width * (20/100));
					break;
				  case 6:
					return parseInt(_width * (15/100));
					break;
				} 
			},
			contextMenu: false,
			filters: true,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
			columns: [
			  {
				data:'date',
				type: 'text',
				sortFunction: sortDateFunction,
				readOnly: true
			  },
			  {
				data:'lead_name',
				renderer: htmlParticipateLeadRender,
				readOnly:true
			  },
			  {
				data:'company_name',
				renderer:htmlCompanyProfileRender,
				readOnly:true
			  },
			  {
				data:'person_name',
				renderer:htmlPersonProfileRender,
				readOnly:true
			  },
			  
			  {
				data:'participate_type',
				readOnly: true
			  },
			  {
				data:'message',
				renderer: htmlParticipateRender,
				readOnly:true
			  },		  
			  {
				data:'action',
				readOnly: true,
				renderer: actionParticipateRender,
			  }		  
			]
		});
	}
	
	
}
implementParticipateTable();
<?php endif;?>
function htmlEmptyRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	td.innerHTML = "";
	return td;
}
function deleteButtonRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	td.innerHTML = "<a href='javascript://' class='font-blue' onclick='deleteCheckAvailability("+value+");' style='display:block'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";			  		  
	return td;
}
function actionParticipateRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	currentEmail = instance.getDataAtRowProp(row,'email');
	lead = instance.getDataAtRowProp(row,'lead_id');
	fileText = instance.getDataAtRowProp(row,'file_text');
	Handsontable.dom.empty(td);
	td.innerHTML = "<span class='colHeader'><span style='display:inline-block;width:30px;margin-right:10px;margin-left:5px;line-height:1.1;'>"+fileText+"</span><span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a href='javascript://' class='font-blue' onclick='sendConfirmation(jQuery(this),0);' data-lead='"+lead+"' data-email='"+currentEmail+"' data-id='"+value+"'><i class='fa fa-reply'></i></a></span></span>";			  		  
	return td;
}
function actionParticipateStatusRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	currentEmail = instance.getDataAtRowProp(row,'email');
	lead = instance.getDataAtRowProp(row,'lead_id');
	fileText = instance.getDataAtRowProp(row,'file_text');
	status = instance.getDataAtRowProp(row,'status');
	Handsontable.dom.empty(td);
	td.innerHTML = "<span class='colHeader'><span style='display:inline-block;width:20px;margin-right:10px;margin-left:5px;line-height:1.1;'>"+fileText+"</span><span style='display:inline-block;width:20px;margin-right:10px;line-height:1.1;'><a href='javascript://' class='font-blue' onclick='sendConfirmation(jQuery(this),0);' data-lead='"+lead+"' data-email='"+currentEmail+"' data-id='"+value+"'><i class='fa fa-reply'></i></a></span></span><span style='display:inline-block;float:right;width:20px'><input type='checkbox' onchange='partcipant_confirmed(jQuery(this));' data-id='"+currentVal+"' /></span>";			  		  
	return td;
}
function actionAvailabilityRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	currentEmail = instance.getDataAtRowProp(row,'email');
	lead = instance.getDataAtRowProp(row,'lead_id');
	Handsontable.dom.empty(td);
	td.innerHTML = "<span class='colHeader'><span style='display:inline-block;width:20px;margin-right:10px;margin-left:5px;line-height:1.1;'><a  href='javascript://' class='font-blue' onclick='sendConfirmation(jQuery(this),5);' data-lead='"+lead+"' title='Reply' data-email='"+currentEmail+"' data-id='"+value+"'><i class='fa fa-reply' aria-hidden='true'></i></a></span></span><a style='float:right' href='javascript://' class='font-blue' style='float:right' onclick='deleteCheckAvailability("+currentVal+");' ><i class='fa fa-trash-o' aria-hidden='true'></i></a>";			  		  
	return td;
}
function actionUnlockRevisedRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	lead = instance.getDataAtRowProp(row,'lead_id');
	status = instance.getDataAtRowProp(row,'doc_status');
	_class ='fa-unlock-alt';
	_status = 1;
	if(value==1){
		_class ='fa-lock';
		_status = 0;
	}
	_inputType = "<span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a href='javascript://'  class='font-blue' onclick='getCountSelection(jQuery(this),"+_status+",0)' data-id='"+currentVal+"' data-lead='"+lead+"'><i class='fa "+_class+"'></i></a></span>";
	if(status==3){
		_classStatus ='fa-undo';
		_inputType += "<span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a href='javascript://'  class='font-blue' onclick='getCountSelection(jQuery(this),0,0)' data-id='"+currentVal+"' data-lead='"+lead+"'><i class='fa "+_classStatus+"'></i></a></span>";
	}else{
		_inputType += "<span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'></span>";
	}
	Handsontable.dom.empty(td);
	td.innerHTML = _inputType;			  		  
	return td;
}
function actionRevisedRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	currentEmail = instance.getDataAtRowProp(row,'email');
	serialNumber = instance.getDataAtRowProp(row,'serial_number');
	leadName = instance.getDataAtRowProp(row,'lead_name');
	lead = instance.getDataAtRowProp(row,'lead_id');
	fileText = instance.getDataAtRowProp(row,'file_text');
	_approve = instance.getDataAtRowProp(row,'approve');
	_class = 'fa-unlock-alt';
	_status = 1;
	_downloadStatus = 0;
	if(_approve==1){
		_class = 'fa-lock';
		_status = 0;
		_downloadStatus = 1;
	}
	_inputType = "<span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a href='javascript://' onclick='getCountSelection(jQuery(this),"+_status+",1)' data-id='"+value+"' data-lead='"+lead+"' class='font-blue'><i class='fa "+_class+"'></i></a></span>";
	Handsontable.dom.empty(td);
	_html = "<span class='colHeader'><span style='display:inline-block;width:30px;margin-right:10px;margin-left:5px;line-height:1.1;'>"+fileText+"</span><span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a style='' href='javascript://' class='font-blue' onclick='sendConfirmation(jQuery(this),1);' data-lead='"+lead+"' data-email='"+currentEmail+"' data-lead_name='"+leadName+"' data-serial_number='"+serialNumber+"' data-id='"+value+"'><i class='fa fa-reply' aria-hidden='true'></i></a></span>"+_inputType;
	if(_downloadStatus==1){
		file = instance.getDataAtRowProp(row,'file');
		_html +="<span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a style='' href='javascript://' class='font-blue' onclick='downloadRevisedDocument(jQuery(this),"+currentVal+");' data-file='"+file+"'><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a></span>";
	} else {
		_html +="<span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'></span>";
	}
	_html +="</span><a style='float:right' href='javascript://' class='font-blue' onclick='deleteRevisedDocument("+currentVal+");'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
	td.innerHTML = _html;
	return td;
}
function lockOnly(o){
	console.log("Tacccckkk");
}
function actionPaymentDisplayRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	currentEmail = instance.getDataAtRowProp(row,'email');
	leadID = instance.getDataAtRowProp(row,'lead_id');
	participateType = instance.getDataAtRowProp(row,'type');
	status = instance.getDataAtRowProp(row,'participant_status');
	Handsontable.dom.empty(td);
	_html = "<span class='colHeader'><span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a href='javascript://' class='font-blue' onclick='sendConfirmation(jQuery(this),2);' data-lead='"+leadID+"' data-email='"+currentEmail+"' data-id='"+currentVal+"'><i class='fa fa-reply'></i></a></span></span><span style='float:right'><input type='checkbox' onclick='paymentCompleted(jQuery(this),"+currentVal+")' data-id='"+currentVal+"'/></span>";
	td.innerHTML = _html;			  		  
	return td;
}
function actionDisplayRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	currentEmail = instance.getDataAtRowProp(row,'email');
	leadID = instance.getDataAtRowProp(row,'lead_id');
	participateType = instance.getDataAtRowProp(row,'type');
	status = instance.getDataAtRowProp(row,'participant_status');
	fileText = instance.getDataAtRowProp(row,'view_file');
	Handsontable.dom.empty(td);
	_html = '';
	switch(parseInt(participateType)){
		case 0:
		case 1:
			/*if(parseInt(value)==0){
				_html = "<span class='colHeader'><span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a href='javascript://' class='font-blue' onclick='sendConfirmation(jQuery(this),2);' data-lead='"+leadID+"' data-email='"+currentEmail+"' data-id='"+currentVal+"'><i class='fa fa-reply'></i></a></span><span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><input type='checkbox' onclick='confirmedParticipantPayment(jQuery(this))' data-id='"+currentVal+"'/></span></span>";	
			}*/	
			_checked='';
			if(status==1){
				_checked="CHECKED='CHECKED'";
			}
			_html = "<span class='colHeader'><span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'>"+fileText+"</span><span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a href='javascript://' class='font-blue' onclick='sendConfirmation(jQuery(this),2);' data-lead='"+leadID+"' data-email='"+currentEmail+"' data-id='"+currentVal+"'><i class='fa fa-reply'></i></a></span><span style='display:inline-block;margin-right:3px;line-height:1.1;'><input type='checkbox' onclick='confirmedParticipantPayment(jQuery(this))' data-id='"+currentVal+"' "+_checked+"/></span></span><a style='float:right;' href='javascript://' onclick='moveToParticipateUnPromise(jQuery(this),"+currentVal+")'><i class='fa fa-trash'></i></a>";
		break;
		case 2:
		case 3:
			_html = "<a href='javascript://' class='font-blue' onclick='sendConfirmation(jQuery(this),3);' data-lead='"+leadID+"' data-email='"+currentEmail+"' data-id='"+currentVal+"'>Send counter executed agreement</a>";	
		break;
		case 4:
			_html = "<a href='javascript://' class='font-blue' onclick='sendConfirmation(jQuery(this),4);' data-lead='"+leadID+"' data-email='"+currentEmail+"' data-id='"+currentVal+"'>Confirm receipt of payment</a>";	
		break;
	}
	td.innerHTML = _html;			  		  
	return td;
}
function actionParticipateDisplayRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	currentEmail = instance.getDataAtRowProp(row,'email');
	display = instance.getDataAtRowProp(row,'display');
	Handsontable.dom.empty(td);
	_checked ='';
	if(display==1){
		_checked ='CHECKED="CHECKED"';
	}
	td.innerHTML = "<span style='width:100%;text-align:center;display:inline-block;'><input type='checkbox' onclick='showBtnUpdate(jQuery(this));' "+_checked+" data-email='"+currentEmail+"' data-id='"+currentVal+"'/></span>";			  		  
	return td;
}
function htmlParticipateRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	td.innerHTML = value;
	return td;
}
function htmlParticipateLeadRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	firstColor = instance.getDataAtRowProp(row,'first_color');
	secondColor = instance.getDataAtRowProp(row,'second_color');
	thirdColor = instance.getDataAtRowProp(row,'third_color');
	docStatus = instance.getDataAtRowProp(row,'doc_status');
	/*if(typeof docStatus!='undefined' && docStatus=="1"){
		value = "<strong>"+value+"</strong>";
	}*/
	td.innerHTML = '<span style="display:inline-block;width:100%;background-color:rgba('+firstColor+','+secondColor+','+thirdColor+',0.5)">'+value+'</span>';
	return td;
}
function htmlMessageRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	td.innerHTML = '<div class="wrap_all">'+value+'</div>';
	return td;
}
function htmlCompanyProfileRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	company_id = instance.getDataAtRowProp(row,'company_id');
	if(typeof company_id!='undefined' && company_id>0){
		value = "<a href='javascript://' onclick='window.parent.openCompanyEdit("+company_id+")' style='color:#15c'>"+value+"</a>";
	}
	td.innerHTML = value;
	return td;
}
function htmlPersonProfileRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	contact_id = instance.getDataAtRowProp(row,'contact_id');
	if(typeof contact_id!='undefined' && contact_id>0){
		value = "<a href='javascript://' onclick='window.parent.openContactEditForm("+contact_id+")' style='color:#15c'>"+value+"</a>";
	}
	td.innerHTML = value;
	return td;
}
function htmlColoredRender(instance, td, row, col, prop, value, cellProperties){
	colored = instance.getDataAtRowProp(row,'colored');
	Handsontable.dom.empty(td);
	if(colored==1){
		td.style.backgroundColor = "red";
	}
	td.innerHTML = value;
	return td;
}
function amountDisplayRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	if(value!='0.000'){
		td.innerHTML = value;
	} else {
		td.innerHTML = '';
	}	
	return td;
}
<?php if($t==2):?>
dHeight = (mainHeight-60)/2;
availableWidth = jQuery(window).width() - 45;
jQuery('.scroll-container').eq(0).css({height:dHeight+'px',overflow:'auto'});
jQuery('.scroll-container').eq(1).css({height:dHeight+'px',overflow:'auto'});
dHeight -=20; 
jQuery('#revised_request_box').css({height:dHeight+'px'}).attr('data-originalstyle','height: '+dHeight+'px; overflow: hidden; width: 1858px;');
jQuery('#confirmed_revised_request_box').css({height:dHeight+'px'}).attr('data-originalstyle','height: '+dHeight+'px; overflow: hidden; width: 1858px;');
function implementRevisedTable(){
	
	_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width -=10;
	hot3 = new Handsontable(revised_request_table, {
		data: _revisedRequestJSON,
		licenseKey:_licenseKey,
		autoWrapCol:true,
		wordWrap:true,
		rowHeaders: false,
		minSpareRows: 0,
		minSpareCols: 0,
		manualColumnResize:true ,
		minCols: 8,
		maxCols: 8,
		maxRows: _revisedRequestJSON.length,
		width:function(){return 1434;},
		height:function(){return dHeight},
		fillHandle: false,
		stretchH:"all",
		colHeaders:['Date','Portfolio','Customer','Name','Type','Target','Message','<span style="margin-right:10px;margin-left:5px;display:inline-block;width:30px;" title="Open"><i class="fa fa-edit"></i></span><span style="margin-right:10px;display:inline-block;width:30px;" title="Reply"><i class="fa fa-reply"></i></span><span style="margin-right:10px;display:inline-block;width:30px;"><i class="fa fa-unlock-alt" title="Lock"></i></span><span style="margin-right:10px;display:inline-block;width:30px;"><i class="fa fa-file-pdf-o" title="PDF"></i></span>'],
		columnSorting: {						
			sortOrder: true
		},		
		contextMenu: false,
		filters: true,
		dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
		modifyColWidth: function(width, col){
		  switch(col){
			  case 0:
				return 104;
				break;
			case 1:
				return 174;
				break;
			case 2:
				return 164;
				break;
			case 3:
				return 100;
				break;
			 case 4:
				return 55;
				break;
			case 5:
				return 164;
				break;
			  case 6:
				return 426;
				break;
			  case 7:
				return 247;
				break;
		  } 
		},
		columns: [
			{
				data:'date',
				type: 'text',
				sortFunction: sortDateFunction,
			},
			{
				data:'lead_name',
				renderer: htmlParticipateLeadRender,
				readOnly:true
			},
			{
				data:'company_name',
				renderer:htmlCompanyProfileRender,
				readOnly:true
			},
			{
				data:'person_name',
				renderer:htmlPersonProfileRender,
				readOnly:true
			},
			
			{
				data:'type',
				readOnly:true
			},
			{
				data:'target_company_name',
				type: 'autocomplete',
				source: function (query, process) {
					jQuery.ajax({
					   url: __baseUrl+'opportunity/find_company_list_by_name',
					  dataType: 'json',
					  data: {
						query: query
					  },
					  success: function (response) {
						console.log("response", response);
						//process(JSON.parse(response.data)); // JSON.parse takes string as a argument
						process(response);

					  }
					});
			     },
				strict: false
			  },
			{
				data:'message',
				renderer: htmlMessageRender,
				readOnly:true
			},
			{
				data:'action',
				readOnly: true,
				renderer: actionRevisedRender,
			}		  
		],afterChange: function (changes, source) {
			if(!changes){return;}	
			if(source=="edit"){
				if(typeof changes[0]!="undefined" && changes[0][1]!=null && typeof changes[0][1]!="undefined"){
					_sp = false;
					switch(changes[0][1]){						
						case 'target_company_name':
							_sp = true;
							break;
					}
					if(_sp === true){
						var logicalIndex = changes[0][0];
						if(typeof hot3.sortIndex!="undefined" && typeof hot3.sortIndex.length!="undefined"){
							/*var physicalIndex = hot2.sortIndex.length > 0 ? hot2.sortIndex[logicalIndex][0] : logicalIndex;*/
							logicalIndex = hot3.sortIndex.length > 0 ? hot3.sortIndex[logicalIndex][0] : logicalIndex;
						}
						_rowID = hot3.getDataAtRowProp(logicalIndex,'id');
						if(_rowID>0){
							jQuery.ajax({
								url:__baseUrl+'opportunity/updateRevisesdTargetData',
								type:'POST',
								data:{d:changes[0],t:_rowID},
								cache:false
							}).done(function(data,textStatus,xhr){
								
							})
						}
					}
				}
			}
		},afterSelection:function(r,c,r2,c2){
			/*setTimeout(function(){getCountSelection(r,c,r2,c2)},300);*/
		}
	});
}
function implementConfirmedRevisedTable(){

	_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width -=10;
	hot6 = new Handsontable(cofirmed_revised_request_table, {
		data: _revisedConfirmedRequestJSON,
		licenseKey:_licenseKey,
		autoWrapCol:true,
		wordWrap:true,
		rowHeaders: false,
		minSpareRows: 0,
		minSpareCols: 0,
		manualColumnResize:true ,
		minCols: 8,
		maxCols: 8,
		maxRows: _revisedConfirmedRequestJSON.length,
		width:function(){return 1434;},
		height:function(){return dHeight;},
		fillHandle: false,
		stretchH:"all",
		colHeaders:['Date','Replied','Portfolio','Customer','Name','Type','Message','<span style="margin-right:10px;display:inline-block;width:30px;"><i class="fa fa-lock" title="UnLock"></i></span><span style="display:inline-block;width:30px;" title="Revive"><i class="fa fa-undo"></i></span>'],
		columnSorting: {						
			sortOrder: true
		},
		modifyColWidth: function(width, col){
		   switch(col){
			  case 0:
				return 104;
				break;
			case 1:
				return 104;
				break;
			case 2:
				return 174;
				break;
			case 3:
				return 164;
				break;
			 case 4:
				return 100;
				break;
			case 5:
				return 55;
				break;
			  case 6:
				return 487;
				break;
			  case 7:
				return 246;
				break;
		  }
		},
		contextMenu: false,
		filters: true,
		dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
		columns: [
			{
				data:'date',
				type: 'text',
				sortFunction: sortDateFunction,
			},
			{
				data:'confirm_date',
				type: 'text',
				sortFunction: sortDateFunction,
			},
			{
				data:'lead_name',
				renderer: htmlParticipateLeadRender,
				readOnly:true
			},
			{
				data:'company_name',
				renderer:htmlCompanyProfileRender,
				readOnly:true
			},
			{
				data:'person_name',
				renderer:htmlPersonProfileRender,
				readOnly:true
			},			
			{
				data:'type',
				readOnly:true
			},
			{
				data:'message',
				renderer: htmlMessageRender,
				readOnly:true
			},			
			{
				data:'approve',
				readOnly: true,
				renderer: actionUnlockRevisedRender,
			}		  
		],afterChange: function (changes, source) {	
			console.log('tap');
		},afterSelection:function(r,c,r2,c2){			
		},afterRender:function(){
			console.log(_revisedConfirmedRequestJSON);
		}
	});
}
implementRevisedTable();
implementConfirmedRevisedTable();
<?php endif;?>
function getCountSelection(o,_approval,t){
	_rowID = o.data('id');
	/*_rowID = hot3.getDataAtRowProp(r,'id');
	_approval = hot3.getDataAtRowProp(r,'approve');*/
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'dashboard/approved_revised_agreement',
		data:{i:_rowID,p:_approval,t:t},
		cache:false,
		success:function(data){
			if(t==1){
				jQuery(_revisedRequestJSON).each(function(i,s){
					if(s.id ==_rowID){
						_revisedRequestJSON[i].approve = _approval ;
						if(_approval==1){
							_revisedRequestJSON[i].download = 1 ;
						} else {
							_revisedRequestJSON[i].download = 0 ;
						}
						return;
					}
				});				
			}
			if(t==0){
				jQuery(_revisedConfirmedRequestJSON).each(function(i,s){
					if(s.id ==_rowID){
						_ROw = _revisedConfirmedRequestJSON[i];
						_ROw.approve = 0;
						_revisedConfirmedRequestJSON.splice(i,1);
						_revisedRequestJSON.push(_ROw);
						return;
					}
				});				
			}
			window.parent.getCountOnRTP();
			hot3.destroy();
			hot6.destroy();
			implementRevisedTable();
			implementConfirmedRevisedTable();
		}
	});
}
<?php if($t==3 || $t==10 || $t==11 || $t==12):?>
_MainRow = 0;
dHeight = mainHeight;
jQuery('.scroll-container').eq(0).css({height:dHeight+'px',overflow:'auto'});
function implementConfirmedTable(){
	if(_t==3){
		_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width -=10;
		hot2 = new Handsontable(confirmed_request_table, {
			data: _confirmedRequestJSON,
			licenseKey:_licenseKey,
			autoWrapCol:true,
			wordWrap:true,
			rowHeaders: false,
			minSpareRows: 0,
			minSpareCols: 0,
			manualColumnResize:true ,
			minCols: 16,
			maxCols: 16,
			maxRows: _confirmedRequestJSON.length,
			width:function(){return 1434;},
			height:function(){return mainHeight;},
			fillHandle: false,
			stretchH:"all",
			modifyColWidth: function(width, col){
			  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 104;
					break;
				case 2:
					return 70;
					break;
				  case 3:
					return 174;
					break;
				  case 4:
					return 164;
					break;
				  case 5:
					return 100;
					break;
				case 6:
					return 55;
					break;
				case 7:
					return 164;
				break;
				case 8:
				case 9:
				case 10:
				case 11:
				case 13:
					return 50;
					break;
				case 12:
					return 60;
					break;
				case 14:
					return 50;
					break;
				case 15:
					return 135;
					break;
			  } 
			},
			colHeaders:['Received','Confirmed','Deadline','Portfolio','Customer','Name','Type','Target','$','Avg.','Diff.','Sum','Upfront $','Diff','Chart','<span style="margin-right:10px;display:inline-block;width:30px;" title="File"><i class="fa fa-file-o"></i></span><span style="margin-right:10px;display:inline-block;width:30px;" title="Reply"><i class="fa fa-reply"></i></span><span style="display:inline-block;" title="Reply"><i class="fa fa-check"></i></span>'],
			columnSorting: {						
				sortOrder: true
			},
			contextMenu: false,
			filters: true,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
			columns: [	
				{
					data:'date',
					type: 'text',
					sortFunction: sortDateFunction,
					readOnly: true
				},
				{
					data:'send_date',
					type: 'text',
					sortFunction: sortDateFunction,
					readOnly: true
				},
				{
					data:'deadline',
					type: 'text',
					sortFunction: sortDateFunction,
					readOnly: true
				},
				{
					data:'lead_name',
					renderer: htmlParticipateLeadRender,
					readOnly:true
				},
				{
					data:'company_name',
					renderer:htmlCompanyProfileRender,
					readOnly:true
				},
				{
					data:'person_name',
					renderer:htmlPersonProfileRender,
					readOnly:true
				},
				{
					data:'doc_type',
					readOnly: true
				},
				{
					data:'target_company_name',
					readOnly: true
				},
				{
					data:'price',
					renderer: htmlColoredRender,
					readOnly: false
				},
				{
					data:'avg',
					renderer: htmlColoredRender,
					readOnly: false
				},
				{
					data:'diff',
					renderer: htmlColoredRender,
					readOnly: false
				},
				{
					data:'sum',
					renderer: htmlColoredRender,
					readOnly: false
				},
				{
					data:'upfront',
					renderer: htmlColoredRender,
					readOnly: false
				},
				{
					data:'upfront_diff',
					renderer: htmlColoredRender,
					readOnly: false
				},				
				{
					data:'displayString',
					readOnly: true,
					renderer: actionParticipateDisplayRender
				},
				{
					data:'colored',
					readOnly: true,
					renderer: actionDisplayRender
				}
			],
			afterSelection:function(r,c,r2,c2){
				_MainRow = r;
			},
			afterChange: function(changes, source) {
				if(source=="edit"){
					/*Call Update Price*/
					var logicalIndex = changes[0][0];
					if(typeof hot2.sortIndex!="undefined" && typeof hot2.sortIndex.length!="undefined"){
						/*var physicalIndex = hot2.sortIndex.length > 0 ? hot2.sortIndex[logicalIndex][0] : logicalIndex;*/
						logicalIndex = hot2.sortIndex.length > 0 ? hot2.sortIndex[logicalIndex][0] : logicalIndex;
					}
					
					_rowID = hot2.getDataAtRowProp(logicalIndex,'id');/*_confirmedRequestJSON[physicalIndex].id;*/
					console.log("SOURCEID:"+_rowID);
					if(_rowID>0){
						if(changes[0][1]=="price"){
							jQuery.ajax({
								type:'POST',
								url:__baseUrl+'dashboard/updatePricePotential',
								data:{i:_rowID,p:changes[0][3]},
								cache:false,
								success:function(data){
									if(parseInt(data)>0){
										/*hot2.alter('remove_row', r);
										*update price
										*hot2.render();
										*/
										jQuery(_confirmedRequestJSON).each(function(i,s){
											if(s.id ==_rowID){
												_confirmedRequestJSON[i].price = changes[0][3];
												_confirmedRequestJSON[i].display = 0;
												_confirmedRequestJSON[i].colored = 0;
												return;
											}
										});
										runAlgoCheckSyndicationDone(_rowID);
										hot2.render();
									} else {
										alert("Please try again after sometime.");
									}
								}
							}).fail(function(){
								alert("Please try again after sometime.");
							});
						} else if (changes[0][1]=="amount"){
							console.log("Update amount..");
							jQuery.ajax({
								type:'POST',
								url:__baseUrl+'dashboard/updateAmountPotential',
								data:{i:_rowID,p:changes[0][3]},
								cache:false,
								success:function(data){
									if(parseInt(data)>0){
										/*hot2.alter('remove_row', r);
										*update price
										*hot2.render();
										*/
										jQuery(_confirmedRequestJSON).each(function(i,s){
											if(s.id ==_rowID){
												_confirmedRequestJSON[i].amount = changes[0][3];
												return;
											}
										});
										hot2.render();
									} else {
										alert("Please try again after sometime.");
									}
								}
							}).fail(function(){
								alert("Please try again after sometime.");
							});
						}					
					}
				}
			}
		});
	} else if(_t==10){
		_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width -=10;
		hot2 = new Handsontable(confirmed_request_table, {
			data: _confirmedRequestJSON,
			licenseKey:_licenseKey,
			autoWrapCol:true,
			wordWrap:true,
			rowHeaders: false,
			minSpareRows: 0,
			minSpareCols: 0,
			manualColumnResize:true ,
			minCols: 12,
			maxCols: 12,
			maxRows: _confirmedRequestJSON.length,
			width:function(){return 1434;},
			height:function(){return mainHeight;},
			fillHandle: false,
			stretchH:"all",
			modifyColWidth: function(width, col){
			  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 104;
					break;
				  case 2:
					return 174;
					break;
				  case 3:
					return 164;
					break;
				  case 4:
					return 100;
					break;
				case 5:
					return 55;
					break;
				case 6:
					return 164;
					break;
				case 7:
					return 100;
					break;
				case 8:
					return 100;
					break;
				case 9:
					return 70;
					break;
				case 10:
					return 70;
					break;
				case 11:
					return 208;
					break;
			  } 
			},
			colHeaders:['Noticed','Received','Portfolio','Customer','Name','Type','Target','Payment','Agreement','Price','$ <span style="margin-left:5px;display:inline-block;" title="Edit"><i class="fa fa-edit"></i></span>','<span style="margin-right:10px;display:inline-block;width:30px;" title="Reply"><i class="fa fa-reply"></i></span>'],
			columnSorting: {						
				sortOrder: true
			},
			contextMenu: false,
			filters: true,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
			columns: [	
				{
					data:'payment_notice',
					type: 'text',
					sortFunction: sortDateFunction,
					readOnly: true
				},
				{
					data:'received_date',
					type: 'text',
					sortFunction: sortDateFunction,
					readOnly: true
				},
				{
					data:'lead_name',
					renderer: htmlParticipateLeadRender,
					readOnly:true
				},
				{
					data:'company_name',
					renderer:htmlCompanyProfileRender,
					readOnly:true
				},
				{
					data:'person_name',
					renderer:htmlPersonProfileRender,
					readOnly:true
				},
							
				{
					data:'doc_type',
					readOnly: true
				},
				{
					data:'target_company_name',
					readOnly: true
				},
				{
					data:'proof_of_payment',
					renderer: htmlParticipateRender,
					readOnly: true
				},
				{
					data:'execute_agreement',
					renderer: htmlParticipateRender,
					readOnly: true
				},
				{
					data:'cost_price',
					renderer: amountDisplayRender,
					readOnly: false
				},
				{
					data:'amount',
					renderer: amountDisplayRender,
					readOnly: false
				},
				{
					data:'id',
					readOnly: true,
					renderer: actionPaymentDisplayRender
				}
			],
			afterChange: function(changes, source) {
				if(source=="edit"){
					/*Call Update Price*/
					var logicalIndex = changes[0][0];
					if(typeof hot2.sortIndex!="undefined" && typeof hot2.sortIndex.length!="undefined"){
						/*var physicalIndex = hot2.sortIndex.length > 0 ? hot2.sortIndex[logicalIndex][0] : logicalIndex;*/
						logicalIndex = hot2.sortIndex.length > 0 ? hot2.sortIndex[logicalIndex][0] : logicalIndex;
					}
					
					_rowID = hot2.getDataAtRowProp(logicalIndex,'id');/*_confirmedRequestJSON[physicalIndex].id;*/
					console.log("SOURCEID:"+_rowID);
					if(_rowID>0){
						if (changes[0][1]=="amount"){
							console.log("Update amount..");
							jQuery.ajax({
								type:'POST',
								url:__baseUrl+'dashboard/updateAmountPotential',
								data:{i:_rowID,p:changes[0][3]},
								cache:false,
								success:function(data){
									if(parseInt(data)>0){
										/*hot2.alter('remove_row', r);
										*update price
										*hot2.render();
										*/
										jQuery(_confirmedRequestJSON).each(function(i,s){
											if(s.id ==_rowID){
												_confirmedRequestJSON[i].amount = changes[0][3];
												return;
											}
										});
										hot2.render();
									} else {
										alert("Price not change.");
									}
								}
							}).fail(function(){
								alert("Price not change.");
							});
						}
					}
				}
			}
		});
	} else if(_t==11){
		_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width -=10;
		hot2 = new Handsontable(confirmed_request_table, {
			data: _confirmedRequestJSON,
			licenseKey:_licenseKey,
			autoWrapCol:true,
			wordWrap:true,
			rowHeaders: false,
			minSpareRows: 0,
			minSpareCols: 0,
			manualColumnResize:true ,
			minCols: 7,
			maxCols: 7,
			maxRows: _confirmedRequestJSON.length,
			width:function(){return 1434;},
			height:function(){return mainHeight;},
			fillHandle: false,
			stretchH:"all",
			modifyColWidth: function(width, col){
			  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				case 4:
					return 55;
					break;
				case 5:
					return 164;
					break;
				case 6:
					return 100;
					break;
			  } 
			},
			colHeaders:['Arrived At','Portfolio','Customer','Name','Type','Target','Price'],
			columnSorting: {						
				sortOrder: true
			},
			contextMenu: false,
			filters: true,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
			columns: [	
				{
					data:'date',
					type: 'text',
					sortFunction: sortDateFunction,
					readOnly: true
				},
				{
					data:'lead_name',
					renderer: htmlParticipateLeadRender,
					readOnly:true
				},
				{
					data:'company_name',
					renderer:htmlCompanyProfileRender,
					readOnly:true
				},
				{
					data:'person_name',
					renderer:htmlPersonProfileRender,
					readOnly:true
				},
							
				{
					data:'doc_type',
					readOnly: true
				},
				{
					data:'target_company_name',
					readOnly: true
				},
				{
					data:'price',
					renderer: amountDisplayRender,
					readOnly: false
				}
			]
		});
	} else if(_t==12){
		_width = jQuery('.scroll-container').eq(0).outerWidth();
		_width -=10;
		hot2 = new Handsontable(confirmed_request_table, {
			data: _confirmedRequestJSON,
			licenseKey:_licenseKey,
			autoWrapCol:true,
			wordWrap:true,
			rowHeaders: false,
			minSpareRows: 0,
			minSpareCols: 0,
			manualColumnResize:true ,
			minCols: 9,
			maxCols: 9,
			maxRows: _confirmedRequestJSON.length,
			width:function(){return 1434;},
			height:function(){return mainHeight;},
			fillHandle: false,
			stretchH:"all",
			modifyColWidth: function(width, col){
			  switch(col){
				  case 0:
					return 104;
					break;
				  case 1:
					return 174;
					break;
				  case 2:
					return 164;
					break;
				  case 3:
					return 100;
					break;
				case 4:
					return 55;
					break;
				case 5:
					return 164;
					break;
				case 6:
					return 100;
					break;
				case 7:
					return 100;
					break;
				case 8:
					return 100;
					break;
			  } 
			},
			colHeaders:['Arrived At','Portfolio','Customer','Name','Type','Target','Price','Payment','Agreement'],
			columnSorting: {						
				sortOrder: true
			},
			contextMenu: false,
			filters: true,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
			columns: [	
				{
					data:'date',
					type: 'text',
					sortFunction: sortDateFunction,
					readOnly: true
				},
				{
					data:'lead_name',
					renderer: htmlParticipateLeadRender,
					readOnly:true
				},
				{
					data:'company_name',
					renderer:htmlCompanyProfileRender,
					readOnly:true
				},
				{
					data:'person_name',
					renderer:htmlPersonProfileRender,
					readOnly:true
				},
							
				{
					data:'doc_type',
					readOnly: true
				},
				{
					data:'target_company_name',
					readOnly: true
				},
				{
					data:'amount',
					renderer: amountDisplayRender,
					readOnly: false
				},
				{
					data:'proof_of_payment',
					renderer: htmlParticipateRender,
					readOnly: true
				},
				{
					data:'execute_agreement',
					renderer: htmlParticipateRender,
					readOnly: true
				}
			]
		});
	}
	
}
implementConfirmedTable();
<?php endif;?>
function paymentCompleted(o,_p){
	display = 3;
	if(o.is(':checked')){
		display = 4;
	} 
	_p = o.attr('data-id');
	jQuery.ajax({
		
		url:__baseUrl+'opportunity/update_potential_participants_status',
		type:'POST',
		data:{p:_p,a:display},
		cache:false
	}).done(function(data){
		
	})
}
function moveToParticipateUnPromise(o,_p){
	_confirm = confirm("Are you sure?");
	if(_confirm){
		jQuery.ajax({
			url:__baseUrl+'opportunity/move_participate_unPromise',
			type:'POST',
			data:{p:_p},
			cache:false
		}).done(function(data){
			if(data>0){
				_tp= false;
				jQuery.each(_confirmedRequestJSON,function(i,r){
					if(r.id == _p){
						_confirmedRequestJSON.splice(i,1);
						_tp= true;
						return false;
					}
				});
				if(_tp === true){
					hot2.destroy();
					implementConfirmedTable();
				}
			}
		})
	}
}
function confirmedParticipantPayment(o){
	display = 0;
	if(o.is(':checked')){
		display = 1;
	} 
	_p = o.attr('data-id');
	jQuery.ajax({
		url:__baseUrl+'opportunity/update_potential_participants_status',
		type:'POST',
		data:{p:_p,a:display},
		cache:false
	}).done(function(data){
		
	})
}
function partcipant_confirmed(o){
	display = 0;
	if(o.is(':checked')){
		display = 1;
	} 
	_p = o.attr('data-id');
	jQuery.ajax({
		url:__baseUrl+'opportunity/update_participants_status',
		type:'POST',
		data:{p:_p,a:display},
		cache:false
	}).done(function(data){
		
	})
}
function showBtnUpdate(o){
	_action = "";
	display = 0;
	if(o.is(':checked')){
		/*Add*/
		_action = "add";
		display = 1;
	} else {
		/*Delete*/
		_action = "delete";display = 0;
	}
	if(_action!=""){
		_p = o.attr('data-id');
		jQuery.ajax({
			url:__baseUrl+'opportunity/potential_syndicate',
			type:'POST',
			data:{p:_p,a:_action},
			cache:false
		}).done(function(data){
			if(parseInt(data)>0){
				/*window.location = window.location.href;*/
				/*
				*update checkbox settings
				*run algorithm
				*/
				pushToDocket(_p);
				jQuery(_confirmedRequestJSON).each(function(i,s){
					if(s.id ==_p){
						_confirmedRequestJSON[i].display = display;
						return;
					}
				});
				hot2.render();
				runAlgoCheckSyndicationDone(o.data('id'));
			} else {
				alert("Please try again after sometime.");
				runAlgoCheckSyndicationDone(o.data('id'));
				window.location = window.location.href;
			}
		});
	} else {
		alert("Please try after sometime.");
	}
}
function pushToDocket(_p){
	window.parent.call(__baseUrl+'opportunity/get_display_prices','POST',{p:_p},window.parent.push_chart_price,'json');
}
function runAlgoCheckSyndicationDone(ID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/runAlgoCheckSyndication',
		data:{p:ID},
		dataType:'json',
		cache:false,
		success:function(data){
			if(data.length>0){
				jQuery(_confirmedRequestJSON).each(function(i,s){
					jQuery(data).each(function(n,p){
						if(parseInt(p)==parseInt(s.id)){
							_confirmedRequestJSON[i].colored = 1;
						}
					});
				});
				hot2.render();
			} else {
				_licenseID = 0;
				jQuery(_confirmedRequestJSON).each(function(i,s){
					if(s.id==ID){
						_licenseID = _confirmedRequestJSON[i].license_id;
					}
				});
				if(_licenseID>0){
					jQuery(_confirmedRequestJSON).each(function(i,s){
						if(s.license_id==_licenseID){
							_confirmedRequestJSON[i].colored = 0;
						}
					});
				}
				hot2.render();
			}
		}
	});
}
function checkSerialNumber(s,l,n,e){
	if(window.parent.jQuery("#gmail_message_modal").hasClass('sb-active')){
		if(window.parent.leadGlobal == l){
			console.log("I am in check serial");
			docketLink = "https://synpat.com/catalog?"+md5(s.toString());
			_html = '<ul class="attachment-list"><li class="attachment-list-item">'+n+' - <a id="btnLinkToDocket" class="" file-type="docket" target="'+n+'"  href="'+docketLink+'" style="color:#15c;">Docket</a><span class="remove-attachment pull-right"><a class="" onclick="deleteMe(jQuery(this))"><i class="glyph-icon icon-close"></i></a></span></li></ul>';
			window.parent.jQuery("#attach_droppable:hidden").html(_html);
			window.parent.jQuery("#attach_droppable").html(_html);
			window.parent.jQuery("#emailDocUrl").val(_html);
		}		
	}else{
		setTimeout(function(){checkSerialNumber(s,l,n,e)},500);
	}
}
function sendConfirmation(o,t){
	console.log("Open Email counter");
	window.parent.jQuery("#activityMainType").val(1);
	window.parent.emptyDisplayEmail();
	/*
	0 Participate
	1 Revised
	2 Payment
	3 Send Counter Executed Agreement
	4 Confirm Receipt of Payment
	5 Check Availability
	*/
	window.parent.jQuery("#displayEmail").data('cr-type','Customer');
	switch(t){
		case 0:
			l=o.data('id');
			lead=o.data('lead');
			window.parent.jQuery("#displayEmail").data('cr-id',l);
			window.parent.jQuery("#displayEmail").data('cr-r',1);
			window.parent.jQuery("#displayEmail").data('cr-lead',lead);
			window.parent.findActivitesLeadsFromEmailCustomerRequest(o.data('email'),1,1);
			break;
		case 1:
			l=o.data('id');
			lead=o.data('lead');
			serial_number=o.data('serial_number');
			leadName=o.data('lead_name');
			window.parent.jQuery("#displayEmail").data('cr-id',l);
			window.parent.jQuery("#displayEmail").data('cr-r',2);
			window.parent.jQuery("#displayEmail").data('cr-lead',lead);
			window.parent.findActivitesLeadsFromEmailCustomerRequest(o.data('email'),1,1);
			if(serial_number>0){checkSerialNumber(serial_number,lead,leadName,o.data('email'));}
			break;
		case 2:
			l=o.data('id');
			lead=o.data('lead');
			window.parent.jQuery("#displayEmail").data('cr-id',l);
			window.parent.jQuery("#displayEmail").data('cr-r',3);
			window.parent.jQuery("#displayEmail").data('cr-lead',lead);
			window.parent.findActivitesLeadsFromEmailCustomerRequest(o.data('email'),1,1);
			break;
		case 3:
			l=o.data('id');
			lead=o.data('lead');
			window.parent.jQuery("#displayEmail").data('cr-id',l);
			window.parent.jQuery("#displayEmail").data('cr-r',0);
			window.parent.jQuery("#displayEmail").data('cr-lead',lead);
			window.parent.findActivitesLeadsFromEmailCustomerRequest(o.data('email'),1,1);
			break;
		case 4:
			l=o.data('id');
			lead=o.data('lead');
			window.parent.jQuery("#displayEmail").data('cr-id',l);
			window.parent.jQuery("#displayEmail").data('cr-r',4);
			window.parent.jQuery("#displayEmail").data('cr-lead',lead);
			window.parent.findActivitesLeadsFromEmailCustomerRequest(o.data('email'),1,1);
			break;
		case 5:
			l=o.data('id');
			/*Check Availability*/
			lead=o.data('lead');
			window.parent.jQuery("#displayEmail").data('cr-id',l);
			window.parent.jQuery("#displayEmail").data('cr-r',5);
			/*Checkbox checked*/
			_sourceData = hot4.getSourceData()
			checkBox = 'no';
			jQuery.each(_sourceData,function(i,s){
				if(s.id==l){
					checkBox = s.available;
				}
			});
			window.parent.jQuery("#displayEmail").data('cr-ch',checkBox);
			window.parent.jQuery("#displayEmail").data('cr-lead',lead);
			window.parent.findActivitesLeadsFromEmailCustomerRequest(o.data('email'),1,1);
			break;
	}
	
}
function updateSalesActivity(p,message,fileUrl,le,icon,mime,title){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'customers/docketDocumentSalesActivity',
		data:{p:p,le:le,file:fileUrl,m:message,i:icon,mine:mime,title:title},
		cache:false,
		success:function(data){
			if(data>0){
				/*window.parent.jQuery("#anotherSys").val(data);*/
			}
		}
	});
}
function updatePotentialParticipant(l,le,fileUrl){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'dashboard/potentialParticipant',
		data:{l:l,le:le,file:fileUrl},
		cache:false,
		success:function(data){
			if(data>0){
				/*window.parent.jQuery("#anotherSys").val(data);*/
				window.location = __baseUrl+'dashboard/licensees';
			}
		}
	});
}
function deleteButtonRevisedRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	td.innerHTML = value+ "&nbsp;<a href='javascript://' class='font-blue' onclick='deleteRevisedDocument("+value+");' style='display:block'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";			  		  
	return td;
}
jQuery(function() {
	/*jQuery( "#accordion" ).accordion({ active: 3});*/
	/*jQuery('#accordion .hide').hide();
	jQuery('#accordion h4').click(function () {
		jQuery(this).addClass('uactive').next().slideToggle().siblings('.hide').slideUp().prev().removeClass('uactive');
	});
	jQuery('#accordion h4').eq(jQuery('#accordion h4').length-1).trigger('click');*/
});

function deleteCheckAvailability(ID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'dashboard/delete_check_availability',
		data:{l:ID},
		cache:false,
		success:function(data){
			if(data>0){
				jQuery.each(_availabilityRequestJSON,function(i,c){
					if(parseInt(c.id)==parseInt(ID)){
						_availabilityRequestJSON.splice(i,1);
						hot4.render();
					}
					window.parent.getCountOnRTP();
				})
			} else {
				alert("Please try after sometime.")
			}
		}
	});
}
function downloadRevisedDocument(o,ID){
	_file = o.attr('data-file');
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'dashboard/downloadRevisedDocumentLockFile',
		data:{l:ID,file:_file},
		cache:false,
		dataType:'json',
		success:function(data){
			if(data!=null){
				if(data.update>0){
					if(data.download_link!=""){
						window.open(data.download_link,'_blank');
					}
					jQuery.each(_revisedRequestJSON,function(i,c){
						if(typeof c!="undefined" && c.id==ID){
							_revisedRequestJSON[i].download=1;
							return false;
						}
					});
					hot3.destroy();
					implementRevisedTable();
				}
			}
		}
	});
}
function deleteRevisedDocument(ID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'dashboard/delete_revised_document_request',
		data:{l:ID},
		cache:false,
		success:function(data){
			if(data>0){
				jQuery.each(_revisedRequestJSON,function(i,c){
					console.log(c);
					if(typeof c!="undefined" && c.id==ID){
						_ROw = _revisedRequestJSON[i];
						_ROw.status=3;
						_revisedConfirmedRequestJSON.push(_ROw);
						_revisedRequestJSON.splice(i,1);
					}					
					window.parent.getCountOnRTP();
					hot3.render();
					hot6.destroy();
					implementConfirmedRevisedTable();
				})
			} else {
				alert("Please try after sometime.")
			}
		}
	});
}
</script>