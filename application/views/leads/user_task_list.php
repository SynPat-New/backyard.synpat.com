<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Task List</title>
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
		<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/datatable/datatable.css">
		<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/datatable/datatable.js"></script>
		<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/datatable/datatable-bootstrap.js"></script>
		<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/datatable/datatable-tabletools.js"></script>
		<style>
			body {
				overflow: auto !important;
				min-width: 0;
				width: 100% !important;
				font-family:arial;margin:0px;
			}	
			#tasksSlidebarTable .dataTables_filter label {
				padding-top: 2px;
			}
			#tasksSlidebarTable .dataTables_filter input {
				box-shadow: none;
				float: right;
				height: 24px;
				margin: -4px 0 2px 2px;
				padding-left: 5px;
				padding-right: 5px;
			}
			#tasksSlidebarTable_wrapper .dataTables_scroll {
				background: none;
				clear: both;
			}
			#tasksSlidebarTable_wrapper .dataTables_info {
				display: none;
			}
			.icon-mobile{background:url(https://backyard.synpat.com/public/svg_icons/icon_mobile.svg) no-repeat;display:inline-block;width:12px;height:15px;}
			.icon-mobile_green{background:url(https://backyard.synpat.com/public/svg_icons/icon_mobile_green.svg) no-repeat;display:inline-block;width:12px;height:15px;}
			.icon-phone{background:url(https://backyard.synpat.com/public/svg_icons/icon_phone.svg) no-repeat;display:inline-block;width:12px;height:15px;}
			.icon-phone_green{background:url(https://backyard.synpat.com/public/svg_icons/icon_phone_green.svg) no-repeat;display:inline-block;width:12px;height:15px;}
			.icon-phone-square{background:url(https://backyard.synpat.com/public/svg_icons/icon_phone_square.svg) no-repeat;display:inline-block;width:12px;height:15px;}
			.icon-phone-square_green{background:url(https://backyard.synpat.com/public/svg_icons/icon_phone_square.svg) no-repeat;display:inline-block;width:12px;height:15px;}
			.icon-linkedin{background:url(https://backyard.synpat.com/public/svg_icons/icon_linkedin.svg) no-repeat;display:inline-block;width:12px;height:15px;}
			.icon-linkedin_green{background:url(https://backyard.synpat.com/public/svg_icons/icon_linkedin_green.svg) no-repeat;display:inline-block;width:12px;height:15px;}
			.icon-envelope{background:url(https://backyard.synpat.com/public/svg_icons/icon_envelope.svg) no-repeat;display:inline-block;width:12px;height:15px;}			
			.icon-envelope_green{background:url(https://backyard.synpat.com/public/svg_icons/icon_envelope_green.svg) no-repeat;display:inline-block;width:12px;height:15px;}			
			.icon-envelope_red{background:url(https://backyard.synpat.com/public/svg_icons/icon_envelope_red.svg) no-repeat;display:inline-block;width:12px;height:15px;}			
		</style>
		<script>
			var ___table ;
			h= jQuery(window).height();h = h-70;			
			jQuery(document).ready(function(){
				___table = $('#tasksSlidebarTable')
					.DataTable({								
						"searching":false,
						"autoWidth": true,
						"paging": false,
						"sScrollY": h+'px',
						"sScrollX": "100%",
						"sScrollXInner": "100%",
						"sScrollX": "100%",
						"language": {
							"emptyTable":     "No task created"
						},
						"width":'98%',
						"order":[[4, "desc"]],
					});
			});
		</script>
	</head>
<body>
<table id="tasksSlidebarTable" class="table">
	<thead>
		<tr>
			<th>Portfolio</th>			
			<?php if($taskType==0):?>
			<th>For</th>
			<?php 
				else:
			?>
			<th>By</th>
			<?php endif;?>
			<th>Activity</th>
			<th>Message</th>
			<th>Phone</th>
			<th>Person</th>
			<th>Company</th>
			<th>Execution</th>
		</tr>
	</thead>
	<tbody>
		<?php 		
		if(count($mycreatedTaskList)>0){
			for($i=0;$i<count($mycreatedTaskList);$i++){
				if((int)$mycreatedTaskList[$i]->userType==9 && $mycreatedTaskList[$i]->approved_type=='LEAD'){
					$userName = "System";
				} else {
					$userName = $mycreatedTaskList[$i]->userName;
				}
				$leadName = (!empty($mycreatedTaskList[$i]->lead_name))?$mycreatedTaskList[$i]->lead_name:$mycreatedTaskList[$i]->plantiffs_name;
			?>
		<tr role="row" class="<?php echo ($i%2)?'even':'odd'?>" >
			<td onclick="window.parent.approvedFile(<?php echo $mycreatedTaskList[$i]->approved_id;?>,1)"><?php echo $leadName;?></td>			
			<td onclick="window.parent.approvedFile(<?php echo $mycreatedTaskList[$i]->approved_id;?>,1)"><?php echo $userName;?></td>
			<td onclick="window.parent.approvedFile(<?php echo $mycreatedTaskList[$i]->approved_id;?>,1)"><?php echo $mycreatedTaskList[$i]->subject;
				if(isset($mycreatedTaskList[$i]->notifyStatus) && $mycreatedTaskList[$i]->notifyStatus==1){											
					echo '&nbsp;&nbsp;&nbsp;<span class="btn-blink" style="color:red;"><b>Completed</></span>';
				}
			?></td>
			<td onclick="window.parent.approvedFile(<?php echo $mycreatedTaskList[$i]->approved_id;?>,1)"><?php echo $mycreatedTaskList[$i]->message;?></td>
			<td>
				<?php 
					if($mycreatedTaskList[$i]->contactID != null && (int)$mycreatedTaskList[$i]->contactID > 0){
						$contactName = "";
						$_phone = "";
						$phoneAttr="";
						$telephonephoneAttr="";
						$companyphoneAttr="";
						$_sLinks="";
						if($mycreatedTaskList[$i]->phone!='' || $mycreatedTaskList[$i]->telephone!='' || $mycreatedTaskList[$i]->companyphone!=''){
							$phoneAttr = 'data-phone="'.$mycreatedTaskList[$i]->phone.'"';
							$telephonephoneAttr = 'data-telephone="'.$mycreatedTaskList[$i]->telephone.'"';
							$companyphoneAttr = 'data-companyphone="'.$mycreatedTaskList[$i]->companyphone.'"';
							$_colorPhone = "icon-mobile";
							if((int)$mycreatedTaskList[$i]->new_phone==1){
								$_colorPhone = "icon-mobile_green";
							}
							if($mycreatedTaskList[$i]->phone!=''){
								$_phone .='&nbsp;<a class="'.$_colorPhone.'"  href="javascript://" onclick=\'window.parent.checkActivityOpenEvenDialogFront('.$mycreatedTaskList[$i]->id.','.$mycreatedTaskList[$i]->companyID.','.$mycreatedTaskList[$i]->contactID.','.$mycreatedTaskList[$i]->activity_type.')\' '.$phoneAttr.' '.$telephonephoneAttr.' '.$companyphoneAttr.'></a>';
							}
							$_colorTelephone = "icon-phone";
							if((int)$mycreatedTaskList[$i]->new_telephone==1){
								$_colorTelephone = "icon-phone_green";
							}
							if($mycreatedTaskList[$i]->telephone!=''){
								$_phone .='&nbsp;<a class="'.$_colorTelephone.'" href="javascript://" onclick=\'window.parent.checkActivityOpenEvenDialogFront('.$mycreatedTaskList[$i]->id.','.$mycreatedTaskList[$i]->companyID.','.$mycreatedTaskList[$i]->contactID.','.$mycreatedTaskList[$i]->activity_type.')\' '.$phoneAttr.' '.$telephonephoneAttr.' '.$companyphoneAttr.'></a>';
							}
							$_colorCompanyPhone = "icon-phone-square";
							if((int)$mycreatedTaskList[$i]->new_company==1){
								$_colorCompanyPhone = "icon-phone-square_green";
							}
							if($mycreatedTaskList[$i]->companyphone!=''){
								$_phone .='&nbsp;<a class="'.$_colorCompanyPhone.'" href="javascript://" onclick=\'window.parent.checkActivityOpenEvenDialogFront('.$mycreatedTaskList[$i]->id.','.$mycreatedTaskList[$i]->companyID.','.$mycreatedTaskList[$i]->contactID.','.$mycreatedTaskList[$i]->activity_type.')\' '.$phoneAttr.' '.$telephonephoneAttr.' '.$companyphoneAttr.'></a>';
							}
						}
						$_emailID = "";
						$_sendFail = false;
						switch((int)$mycreatedTaskList[$i]->active_email){
							case 1:
								$_emailID = $mycreatedTaskList[$i]->email;
								break;
							case 2:
								$_emailID = $mycreatedTaskList[$i]->secondary_email;
								if($_emailID == "" && $mycreatedTaskList[$i]->email != ""){
									$_sendFail = true;
								}
								break;
							case 3:
								$_emailID = $mycreatedTaskList[$i]->tertiary_email;
								if($_emailID == "" && $mycreatedTaskList[$i]->secondary_email != ""){
									$_sendFail = true;
								}
								break;
						}
						if($_emailID != null){
							$_emailID = trim($_emailID);
						}
						if($_emailID != ''){
							$_colorEmail = "icon-envelope";
							if((int)$mycreatedTaskList[$i]->new_email ==1){
								$_colorEmail = "icon-envelope_green";
							}
							$_sLinks ='<a href="javascript://" class="'.$_colorEmail.'" onclick=\'window.parent.checkActivityOpenEvenDialogFront('.$mycreatedTaskList[$i]->id.','.$mycreatedTaskList[$i]->companyID.','.$mycreatedTaskList[$i]->contactID.','.$mycreatedTaskList[$i]->activity_type.')\' ></a>';
						}
						if($_sendFail === true || $mycreatedTaskList[$i]->active_email == 4){
							$_sLinks ='<a class="icon-envelope_red" href="javascript://" onclick=\'window.parent.checkActivityOpenEvenDialogFront('.$mycreatedTaskList[$i]->id.','.$mycreatedTaskList[$i]->companyID.','.$mycreatedTaskList[$i]->contactID.','.$mycreatedTaskList[$i]->activity_type.')\' ></a>';
						}
						if($mycreatedTaskList[$i]->linkedin_url!=''){
							$_colorLinkedin = "icon_linkedin_black";
							if((int) $mycreatedTaskList[$i]->new_linkedin==1){
								$_colorLinkedin = "icon_linkedin_green";
							} else if($mycreatedTaskList[$i]->linkedin_error == 1){
								$_colorLinkedin = "icon_linkedin_red";
							} else if($mycreatedTaskList[$i]->proximity == 1){
								$_colorLinkedin = "icon_linkedin";
							} else if($mycreatedTaskList[$i]->proximity == 3){
								$_colorLinkedin = "icon_linkedin_grey";
							}
							$_sLinks .='&nbsp;<a class="'.$_colorLinkedin.'" href="javascript://" onclick=\'window.parent.checkActivityOpenEvenDialogFront('.$mycreatedTaskList[$i]->id.','.$mycreatedTaskList[$i]->companyID.','.$mycreatedTaskList[$i]->contactID.','.$mycreatedTaskList[$i]->activity_type.')\' ></a>';
						}
						$contactName .= "<div>".$_sLinks.$_phone."</div>";
						echo $contactName;
					}
				?>
			</td>
			<td><a href="javascript://" onclick="window.parent.editContact(<?php echo $mycreatedTaskList[$i]->contactID;?>)"><?php echo $mycreatedTaskList[$i]->first_name." ".$mycreatedTaskList[$i]->last_name;?></a></td>
			<td><a href="javascript://" onclick="window.parent.openCompanyContact(<?php echo $mycreatedTaskList[$i]->companyID;?>)"><?php echo $mycreatedTaskList[$i]->company_name;?></a></td>
			<td onclick="window.parent.approvedFile(<?php echo $mycreatedTaskList[$i]->approved_id;?>,1)"><?php echo date("M d, Y",strtotime($mycreatedTaskList[$i]->taskCreateDate));?></td>
		</tr>	
		<?php 
			}
		}
	?>
	</tbody>
</table>