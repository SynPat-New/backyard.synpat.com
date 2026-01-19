<?php 
	if(count($campaign_data)>0):
	$contactForm = 0;
	if(isset($campaign_data['contact_from'])){
		$contactForm = $campaign_data['contact_from'];
	}
?>
<style>
	body {
		margin: 0;
		padding: 0;
	}
	.emaillinked-form {
		font-family: Arial;
		margin: 8px;
		/*width: 290px;*/
	}
	.emaillinked-form input[type=text],
	.emaillinked-form input[type=email],
	.emaillinked-form input[type=password],.emaillinked-form select,
	.emaillinked-form textarea {
		background: #fff;
	    border: 1px solid #ddd;
	    color: #888;
	    box-sizing: border-box;
	    border-radius: 0px;
	    box-shadow: none;
	    display: block;
		font-family: Arial;
	    font-size: 14px;
	    height: 36px;
	    margin-bottom: 15px;
	    outline: none !important;
	    padding: 8px 8px 8px 8px;
	    text-overflow: ellipsis;
	    transition: color 300ms ease-in-out, background-color 300ms ease-in-out, border-color 300ms ease-in-out;
	    -moz-transition: color 300ms ease-in-out, background-color 300ms ease-in-out, border-color 300ms ease-in-out;
	    -webkit-transition: color 300ms ease-in-out, background-color 300ms ease-in-out, border-color 300ms ease-in-out;
	    -o-transition: color 300ms ease-in-out, background-color 300ms ease-in-out, border-color 300ms ease-in-out;
	    width: 100%;
	}
	.emaillinked-form textarea {
		height: 60px;
	}
	.emaillinked-form select {
		width: 130px;
	}
	.emaillinked-form input[type=text]:hover,
	.emaillinked-form input[type=email]:hover,
	.emaillinked-form input[type=password]:hover,.emaillinked-form select:hover,
	.emaillinked-form textarea:hover {
	    color:#333 !important;
	    border-color:#aaa !important;
	}
	.emaillinked-form input[type=text]:hover::-webkit-input-placeholder,
	.emaillinked-form input[type=email]:hover::-webkit-input-placeholder,
	.emaillinked-form input[type=password]:hover::-webkit-input-placeholder,
	.emaillinked-form textarea::-webkit-input-placeholder {
	    color: #333;
	    transition: color 300ms ease-in-out, background-color 300ms ease-in-out, border-color 300ms ease-in-out;
	    -moz-transition: color 300ms ease-in-out, background-color 300ms ease-in-out, border-color 300ms ease-in-out;
	    -webkit-transition: color 300ms ease-in-out, background-color 300ms ease-in-out, border-color 300ms ease-in-out;
	    -o-transition: color 300ms ease-in-out, background-color 300ms ease-in-out, border-color 300ms ease-in-out;
	}
	.emaillinked-form label {
	    display: block;
	    font-size: 13px;
	    font-weight: bold;
	    margin-bottom: 3px;
	}
	.emaillinked-form .button {
        background-color: #BD202F;
        border: none;
        border-radius: 0.21429em;
	    color: #ffffff;
   		cursor: pointer;
	    font-size: 14px;
	    font-weight: bold;
	    line-height: 1.4;
	    margin-bottom: 0;
	    margin-top: 0;
	    min-width: 200px;
	    padding: 8px 15px;
        text-transform: uppercase;
	    /*width: 100%;*/
	}
	.emaillinked-form .button:hover {
		background-color: #911924;
	}
.table {
	margin:0px;padding:0px;
	width:100%;
	border:1px solid #e5e5e5;
	
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
	
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
	
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
	
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}.table table{
    border-collapse: collapse;
        border-spacing: 0;
	width:100%;
	height:100%;
	margin:0px;padding:0px;
}.table tr:last-child td:last-child {
	-moz-border-radius-bottomright:0px;
	-webkit-border-bottom-right-radius:0px;
	border-bottom-right-radius:0px;
}
.table table tr:first-child td:first-child {
	-moz-border-radius-topleft:0px;
	-webkit-border-top-left-radius:0px;
	border-top-left-radius:0px;
}
.table table tr:first-child td:last-child {
	-moz-border-radius-topright:0px;
	-webkit-border-top-right-radius:0px;
	border-top-right-radius:0px;
}.table tr:last-child td:first-child{
	-moz-border-radius-bottomleft:0px;
	-webkit-border-bottom-left-radius:0px;
	border-bottom-left-radius:0px;
}.table tr:hover td{
	
}
.table tr:nth-child(odd){ background-color:#ededed; }
.table tr:nth-child(even)    { background-color:#ffffff; }.table td{
	vertical-align:middle;
	
	
	border:1px solid #e5e5e5;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:10px;
	font-size:13px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.table tr:last-child td{
	border-width:0px 1px 0px 0px;
}.table tr td:last-child{
	border-width:0px 0px 1px 0px;
}.table tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.table thead tr:first-child td{
		background:-o-linear-gradient(bottom, #9b9b9b 5%, #c4c4c4 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #9b9b9b), color-stop(1, #c4c4c4) );
	background:-moz-linear-gradient( center top, #9b9b9b 5%, #c4c4c4 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#9b9b9b", endColorstr="#c4c4c4");	background: -o-linear-gradient(top,#9b9b9b,c4c4c4);

	background-color:#9b9b9b;
	border:0px solid #e5e5e5;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:14px;
	font-family:Arial;
	font-weight:bold;
	color:#ffffff;
}
.table thead tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #9b9b9b 5%, #c4c4c4 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #9b9b9b), color-stop(1, #c4c4c4) );
	background:-moz-linear-gradient( center top, #9b9b9b 5%, #c4c4c4 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#9b9b9b", endColorstr="#c4c4c4");	background: -o-linear-gradient(top,#9b9b9b,c4c4c4);

	background-color:#9b9b9b;
}
.table thead tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.table thead tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}
#send_list th:nth-child(2),#send_list th:nth-child(4),#send_list tr td:nth-child(2),#send_list tr td:nth-child(4){display:none;}
.dataTables_info{display:none;}
</style>
<?php
$leadID = $campaign_data['lead_id'];
$subject = "";
$body = "";
$trackingCode = "";
/*if(isset($campaign_data['tracking_code'])){
	$trackingCode = $campaign_data['tracking_code'];
}*/
if(isset($campaign_data['subject'])){
	$subject = $campaign_data['subject'];
}
if(isset($campaign_data['email_message'])){
	$body = $campaign_data['email_message'];
}
$peronList = array();$companyList = array();$mailList = array();
try{
	$peronList = json_decode($campaign_data['person_list']);
	$companyList = json_decode($campaign_data['company_list']);
	$mailList = json_decode($campaign_data['email_list']);
}catch(Exception $e){
	
}

/*$companyList = explode(',',$campaign_data['company_list']);
$mailList = explode(',',$campaign_data['email_list']);*/
$ignoreEmails = array();
$contact_list = $campaign_data['contact_list'];
?>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script> 
<link rel="stylesheet" href="<?php echo $Layout->cdn_server_url_static;?>email_campaign/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css" />
<script type="text/javascript" src="<?php echo $Layout->cdn_server_url_static;?>email_campaign/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo $Layout->cdn_server_url_static;?>email_campaign/font-awesome-4.4.0/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->cdn_server_url_static;?>email_campaign/css/summernote.css">
<script type='text/javascript' src="<?php echo $Layout->cdn_server_url_static;?>email_campaign/js/summernote.min.js"></script>
<script type='text/javascript' src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type='text/javascript' src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script type='text/javascript' src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<script type='text/javascript' src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script type='text/javascript' src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
<script>
jQuery(document).ready(function() {
	jQuery('#body').summernote({
	  height:350
	});
});
let _mail_ignore = [],_start = <?php echo $campaign_data['mail_start'];?>,_send_type = <?php echo $campaign_data['send_account_type'];?>, _activity_type = <?php echo $campaign_data['activity_type'];?>, _campaign_id = <?php echo $campaign_data['campaign_id'];?>, _leadID = <?php echo $campaign_data['lead_id'];?>, _lead_name = '<?php echo $campaign_data['lead_name'];?>', _campaign_date = '<?php echo $campaign_data['campaign_date'];?>', _user_id = '<?php echo $campaign_data['user_id'];?>', _contact_from = '<?php echo $contactForm;?>', _tracking_code = '<?php echo $trackingCode;?>', _processID = 0, _usersEmailListWithID = JSON.parse('<?php echo json_encode($campaign_data['user_list']);?>');
let _emailList = [
	<?php
		if(count($contact_list)>0){
			for($i=0;$i<count($contact_list);$i++){
				echo '"'.$contact_list[$i]->email.'",';
			}
		}
	?>
];
let _personList = [
	<?php
		if(count($contact_list)>0){
			for($i=0;$i<count($contact_list);$i++){
				$name = $contact_list[$i]->first_name .' '.$contact_list[$i]->last_name;
				echo '"'.addslashes($name).'",';
			}
		}
	?>
];
let _companyList = [
	<?php 
		if(count($contact_list)>0){
			for($i=0;$i<count($contact_list);$i++){
				$companyName = $contact_list[$i]->company_name;
				if($contact_list[$i]->company_name_alias != null && $contact_list[$i]->company_name_alias != ''){
					$companyName = $contact_list[$i]->company_name_alias;
				}
				echo '"'.addslashes($companyName).'",';
			}
		}
	?>
];
/*console.log(_companyList);*/
</script>

<div style='float:left;width:40%;'>
	<h3 style="height:26px;width:100%;overflow:hidden;">To Send (<span id="send_counter_list"><?php echo count($contact_list);?></span>)</h3>
	<table class='table' id="main_list" style="width:auto;">
		<thead>
		<tr>
			<th>Person</th>
			<th>Title</th>
			<th>Company</th>
			<th>Current</th>
		</tr>
		</thead>
		<tbody>
		<?php 			
			if(count($contact_list)>0){
				for($i=$campaign_data['mail_start'];$i<count($contact_list);$i++){
					$companyName = $contact_list[$i]->company_name;
					if($contact_list[$i]->company_name_alias != null && $contact_list[$i]->company_name_alias != ''){
						$companyName = $contact_list[$i]->company_name_alias;
					}
		?>
					<tr data-i="<?php echo $i;?>" data-first_name="<?php echo $contact_list[$i]->first_name;?>" data-last_name="<?php echo $contact_list[$i]->last_name;?>" data-email='<?php echo $contact_list[$i]->email;?>' data-c='<?php echo $contact_list[$i]->id;?>' data-co='<?php echo $contact_list[$i]->company_id;?>' data-gender='<?php echo $contact_list[$i]->gender;?>'>
						<td class='contact' id="contact_<?php echo $contact_list[$i]->id;?>"><span id="profile_pic" style='margin-left:5px;'><?php if($contact_list[$i]->linkedin_image != ''){ ?><img src="<?php echo $contact_list[$i]->linkedin_image;?>" width="30"/> <?php }?></span> <a href='javascript://' onclick="window.parent.openContactEditForm(<?php echo $contact_list[$i]->id;?>)"><?php echo $contact_list[$i]->first_name." ".$contact_list[$i]->last_name;?> <span class="gender">(<?php echo $contact_list[$i]->gender==0?'M':'F';?>)</span></a></td>
						<td class='job_title'><?php echo $contact_list[$i]->job_title;?></td>
						<td class='company' id="company_<?php echo $contact_list[$i]->company_id?>"><a href='javascript://' onclick="window.parent.openCompanyEdit(<?php echo $contact_list[$i]->company_id;?>)"><?php echo $companyName;?></a></td>						
						<td class='current_company'><?php echo $contact_list[$i]->current_company;?></td>
					</tr>
		<?php
				}
			}
		?>
		</tbody>
	</table>
</div>
<div style='float:left;width:20%;'>
	<h3 style="height:26px;width:100%;overflow:hidden;">Was Sent To (<span id="sent_counter_list">0</span>)</h3>
	<table class='table' id="send_list" style="width:auto;">
		<thead>
		<tr>
			<th>Person</th>
			<th>Title</th>
			<th>Company</th>
			<th>Current</th>
		</tr>
		</thead>
		<tbody>
		<?php 
			/*if($campaign_data['mail_start']>0){				
				for($i=0;$i<$campaign_data['mail_start'];$i++){
					$show = true;
					if(isset($mailList[$i]) && count($ignoreEmails)>0){
						foreach($ignoreEmails as $ignEmail){
							if(trim($ignEmail)==trim($mailList[$i])){
								$show = false;
								break;
							}
						}
					}
					if($show===true):
			?>
					<tr>
						<td><?php echo $peronList[$i]?></td>
						<td><?php echo $companyList[$i]?></td>
					</tr>
			<?php
					endif;
				}
			}*/
		?>
		</tbody>
	</table> 
</div>
<div style='float:left;width:40%'> 
	<form action="" method="post" class="emaillinked-form">
		<div style="float:left;width:100%;"><select style="float:left;width:130px;" onchange="updateLeadCampaignFrom();" name="event_user_type" id="event_user_type">
			<option value="0">Email Account</option>
			<option value="4">From Personal Account</option>
			<option value="3">From Experts Account</option>
			<option value="1">From Licenses Account</option>
		</select><button type="button" id='btnSendMessage' onclick="openMailBoxAndReplaceData();" class="button" style='float:right;margin-bottom:10px;'>Send this message to the next invitee</button>
		</select><button type="button" id='btnSendMessage' onclick="ignoreEmail();" class="button" style='float:right;margin-bottom:10px;margin-right:10px;'>Skip the next invitee</button>
		</div>
		<label>Subject:</label><input type="text" name="subject" id="subject" value="<?php echo $subject;?>"/>
		<span style='float:right;'>Legend: use for firstname #First#, for lastname #Last#, for company #Company#, for saluation #Salutation#<br/></span> 
		<label>Body:</label><textarea name="body" id="body"><?php echo $body;?></textarea>				
		<input type="hidden" name='setup' value="final_step"/>
	</form>
</div>	
<script>
	
	function saveCampaignProcess(processID){
		/*if(!isNaN(processID) && processID>0){
			_processID = processID;
		}*/
		_processID = processID;
	}
	
	function updateLeadCampaignFrom(){
		
	}
	function updateCompanyData(companyData){
		/*reff dashboard.js*/
		console.log("companyData",companyData);
		if(typeof companyData.id != "undefined"){
			let companyName;
			companyName = companyData.company_name;
			if(companyData.company_name_alias != "" && companyData.company_name_alias != null){
				companyName = companyData.company_name_alias;
			}
			let tblEle = jQuery("#main_list");
			let updateList = [];
			let companyList = tblEle.find('tr[data-co="'+companyData.id+'"]');
			
			if(companyList.length > 0){				
				companyList.each(function(i){
					var $this = jQuery(this);
					$this.find('td.company').find('a').text(companyName);
					updateList.push({email:$this.attr('data-email'),company_name:companyName});
				});
				
			}
			tblEle = jQuery("#send_list");
			companyList = tblEle.find('tr[data-co="'+companyData.id+'"]');
			if(companyList.length > 0){				
				companyList.each(function(i){
					var $this = jQuery(this);
					$this.find('td.company').find('a').text(companyName);
					updateList.push({email:$this.attr('data-email'),company_name:companyName});
				});
			}
			if(updateList.length > 0){
				updateList.forEach((ue)=>{
					if(_emailList.length > 0){
						_emailList.forEach((e,i)=>{
							if(e == ue.email){
								_companyList[i] = ue.company_name;
								return false;
							}
						});
					}
				})
			}
		}
	}
	function updateDataInList(contactData){
		/*reff dashboard.js*/
		console.log("contactData",contactData);
		if(typeof contactData.id != "undefined"){
			let tblEle = jQuery("#main_list");
			let trEle = tblEle.find('tr[data-c="'+contactData.id+'"]');
			if(trEle.length > 0){
				trEle
					.attr('data-email',contactData.email)
					.attr('data-c',contactData.id)
					.attr('data-co',contactData.company_id)
					.attr('data-gender',contactData.gender)
					.attr('data-first_name',contactData.first_name)
					.attr('data-last_name',contactData.last_name)
				if(contactData.linkedin_image != '' && contactData.linkedin_image != null){
					trEle.find('td.contact').find("#profile_pic").html("<img src='"+contactData.linkedin_image+"' width='30'/>");
				}				
				_name = contactData.first_name+" "+contactData.last_name;
				if(contactData.gender==0){
					_name +="<span class='gender'>(M)</span>";
				} else {
					_name +="<span class='gender'>(F)</span>";
				}
				let companyName = contactData.company_name;
				if(contactData.company_name_alias != "" && contactData.company_name_alias != null){
					companyName = contactData.company_name_alias;
				}
				console.log("CANME",contactData.company_name_alias,companyName,contactData.company_name);
				trEle.find('td.contact').find('a').html(_name);
				trEle.find('td.company').find('a').html(companyName);
				trEle.find('td.current_company').html(contactData.current_company);
				trEle.find('td.job_title').html(contactData.job_title);
				if(_emailList.length > 0){
					let update = false,index;
					var dataI = trEle.attr('data-i');
					if(dataI >=0){
						_personList[dataI] = contactData.first_name+" "+contactData.last_name;
						_companyList[dataI] = companyName;
						_emailList[dataI] = contactData.email;
					}					
				}
			} else {
				tblEle = jQuery("#send_list");
				trEle = tblEle.find('tr[data-c="'+contactData.id+'"]');
				if(trEle.length > 0){
					trEle
						.attr('data-email',contactData.email)
						.attr('data-c',contactData.id)
						.attr('data-co',contactData.company_id)
						.attr('data-gender',contactData.gender)
					if(contactData.linkedin_image != ''){
						trEle.find('td.contact').find("#profile_pic").html("<img src='"+contactData.linkedin_image+"' width='30'/>");
					}
					let companyName = contactData.company_name;
					if(contactData.company_name_alias != "" && contactData.company_name_alias != null){
						companyName = contactData.company_name_alias;
					}
					_name = contactData.first_name+" "+contactData.last_name;
					if(contactData.gender==0){
						_name +="<span class='gender'>(M)</span>";
					} else {
						_name +="<span class='gender'>(F)</span>";
					}					
					trEle.find('td.contact').find('a').html(_name);
					trEle.find('td.company').find('a').html(companyName);
				}
			}
		}
	}
	function campaignSendEmail(sd){
		/*Email Sent*/
		_email = _emailList[_start];
		if(!isNaN(sd)){
			window.parent.call(window.parent.__baseUrl+'customers/update_campaign_addresss_send','POST',{campaign_id:_campaign_id,to:_email,proccessed:1,send:1,email_id:sd},window.parent.noActionPerform,'text');
			/*window.parent.call(window.parent.__baseUrl+'dashboard/open_activity_from_campaign_after_send','POST',{send:sd,main_activity:_activity_type,user_id:_user_id},window.parent.noActionPerform,'text');*/
		}
		
		/*callForCreateOpenTaskLog*/
		mainTable.destroy();
		_data = jQuery("#main_list").find("tr[data-email='"+_email+"']").get(0).outerHTML;
		jQuery("#main_list").find("tr[data-email='"+_email+"']").remove();
		initializeMainTable();
		sendTable.destroy();
		let sendListEle = jQuery("#send_list").find('tbody');
		if(sendListEle.find('tr').length > 0){
			sendListEle.prepend(_data);
		} else {
			sendListEle.append(_data);
		}
		initializeSendTable();
		jQuery("#send_counter_list").text(jQuery("#main_list").find('tbody').find("tr").length);
		jQuery("#sent_counter_list").text(jQuery("#send_list").find('tbody').find("tr").length);
		if(_start==0){
			window.parent.call(window.parent.__baseUrl+'customers/save_process_campaign','POST',{lead_id:_leadID,type:3,subject:jQuery("#subject").val(),campaign_id:_campaign_id,main_activity:_activity_type,campaign_date:_campaign_date,user_id:_user_id,to:_emailList.join(',')},window.parent.callSaveProcessID,'text');
		}
		checkNext();
	}
	
	function checkNext(){
		console.log("I am in Next...",_start);
		if(typeof _emailList[_start+1]!="undefined"){
			_start = _start + 1;
			console.log("Next Done...",_start);
		} else {
			console.log("End Campaign",_start,_processID);
			jQuery("#btnSendMessage").hide();
			/*Campaign Done End Campaign run function*/
			if(_processID>0){
				window.parent.call(window.parent.__baseUrl+'dashboard/end_campaign_process','POST',{process_id:_processID},window.parent.endProcess,'json');
			}
		}
	}
	
	function getStart(){
		console.log(_start);
	}
	
	function ignoreEmail(){
		/*IGNORE EMAIL*/
		_email = _emailList[_start];
		_mail_ignore.push(_email);
		mainTable.destroy();
		let mainListTb = jQuery("#main_list").find('tr').eq(0);
		_email = mainListTb.attr('data-email');
		mainListTb.remove();
		initializeMainTable();
		/*Send Ajax Request For Ignore Email*/
		/*Send:2 IGNORE*/
		window.parent.call(window.parent.__baseUrl+'customers/update_campaign_addresss_send','POST',{campaign_id:_campaign_id,to:_email,proccessed:1,send:2},window.parent.noActionPerform,'text');
		checkNext();
	}

	function openMailBoxAndReplaceData(){
		if(jQuery("#event_user_type").val()==0){
			alert("Please select email account first.");
		} else {
			console.log("Next..",_start);
			if(_start<_emailList.length){
				_email = _emailList[_start];
				var tblEle = jQuery("#main_list").find('tbody tr').eq(0);
				indexStart = tblEle.attr('data-i');
				if(parseInt(indexStart) >=0 && parseInt(indexStart) != _start){
					_start = parseInt(indexStart);
				}
				let _lastName = "",_firstName = "";
				_salutation = "Mr.";
				if(tblEle.length > 0){
					_email = tblEle.attr('data-email');
					_lastName = tblEle.attr('data-last_name');
					_firstName = tblEle.attr('data-first_name');
					_company = tblEle.find('td.company').find('a').text();
					_gender  = tblEle.attr('data-gender');
					if(_gender == 1 || _gender == '1'){
						_salutation = "Ms.";
					}
				}				
				_getMailText = jQuery("#body").code().toString();
				_lastName = _lastName.trim();
				_firstName = _firstName.trim();
				_getMailText= _getMailText.replace(/#First#/gi, _firstName);
				_getMailText= _getMailText.replace(/#Last#/gi,_lastName);
				_getMailText= _getMailText.replace(/#Company#/gi,_company);
				_getMailText= _getMailText.replace(/#Salutation#/gi,_salutation);
				window.parent.composeEmail();
				var modelBox = window.parent.jQuery("#gmail_message_modal");
				modelBox.find("#eventT").val(_activity_type);/*window.parent.jQuery("#activityMainType").val()*/
				modelBox.find("#emailAccountType").val(1);
				modelBox.find("#eventUserType").val(4);
				modelBox.find("#message_send_from_email").val(window.parent.jQuery("#user_email").val());
				if(jQuery("#event_user_type").val()=="3" || jQuery("#event_user_type").val()=="1"){
					modelBox.find("#eventUserType").val(jQuery("#event_user_type").val());
					modelBox.find("#emailAccountType").val(2);
					if(jQuery("#event_user_type").val()=="3"){
						modelBox.find("#message_send_from_email").val("experts@synpat.com");
					} else if(jQuery("#event_user_type").val()=="1"){
						modelBox.find("#message_send_from_email").val("licenses@synpat.com");
					}
				}
				if(_email!=""){
					userID = 0;
					if(_contact_from>0){
						if(_usersEmailListWithID.length>0){
							jQuery.each(_usersEmailListWithID,function(i,s){
								if(s.email==_email || s.secondary_email==_email){
									userID = s.id;								
									return false;
								}
							});
						}
					}
					
					if(userID>0){					
						/*_getMailText +="<br/><a href='http://backyard.synpat.com/customers/invitee_form/"+_contact_from+"/"+userID+"?email="+_email+"' target='_blank'>Open Form</a><br/><br/>";*/
						if(_contact_from==2){
							_getMailText +="<br/><a href='http://synpat.com/partner/index.php/"+_contact_from+"/"+userID+"?email="+_email+"' target='_blank'>Open Form</a><br/><br/>";
						} else {
							_getMailText +="<br/><a href='http://backyard.synpat.com/customers/invitee_form/"+_contact_from+"/"+userID+"?email="+_email+"' target='_blank'>Open Form</a><br/><br/>";
						}						
					}
					/*if(_tracking_code != "") {
						_getMailText +="<br/><a><img src='https://synpat.com/display_synpat_logo.php?width=100&height=100&image_id="+_tracking_code+"&display_for="+_email+"' /></a><br/><br/>";
					}*/
					window.parent.jQuery('#gmail_message_modal').find("h4.modal-title").html('Compose Message: '+_lead_name);
					window.parent.jQuery("#messageLeadId").val(_leadID);
					window.parent.jQuery("#emailThreadId").val("");
					window.parent.jQuery("#emailMessageId").val("");
					window.parent.jQuery("#attach_droppable").empty();
					window.parent.jQuery("#emailDocUrl").val("");jQuery("#attach_droppable").empty();
					window.parent.jQuery("#anotherSys").val(0);
					window.parent.jQuery("#eventCid").val(0);
					window.parent.jQuery("#eventPid").val(0);
					window.parent.jQuery("#f_t").val('');
					window.parent.jQuery("#emailReference").val('');
					window.parent.jQuery("#emailSubject").val(jQuery('#subject').val()).removeAttr("readonly");
					window.parent.jQuery("body").data("modalzindex",jQuery("#gmail_message_modal").css("z-index"));
					window.parent.jQuery("#emailTo").val(_email+', ');
					window.parent.findDataRemove.push(_email);
					if(jQuery("#event_user_type").val()!="4"){
						window.parent.jQuery('#emailMessage').code(_getMailText+'<br/>');
					} else {
						window.parent.jQuery('#emailMessage').code(_getMailText+'<br/>'+window.parent.jQuery('#original_signature').val());
					}					
				}
			}
		}		
	}
	let sendTable,mainTable;
	jQuery(document).ready(function(){
		//initializeMainTable();
		//initializeSendTable();	
	});

	function initializeMainTable(){
		mainTable = $('#main_list').DataTable({
			responsive:     false,
			fixedHeader:    true,
			scrollY:        '78vh',
			scrollCollapse: true,
			paging:         false,
			info:			false,
			ordering:		false,
			searching:		false,
			"columnDefs": [ 
				{
					"targets": 0,
					"orderable": false
				},
				{
					"targets": 1,
					"orderable": false
				},
				{
					"targets": 2,
					"orderable": false
				},
				{
					"targets": 3,
					"orderable": false
				},
				{ responsivePriority: -1, targets: 0 },
                { responsivePriority: -1, targets: 1 },
                { responsivePriority: -1, targets: 2 },
                { responsivePriority: -1, targets: 3 }
			]
		});
	}
	function initializeSendTable(){
		sendTable = $('#send_list').DataTable({
			responsive:     false,
			fixedHeader:    true,
			scrollY:        '78vh',
			scrollCollapse: true,
			paging:         false,
			info:			false,
			ordering:		false,
			searching:		false,
			"columnDefs": [ 
				{
					"targets": 0,
					"orderable": false
				},
				{
					"targets": 1,
					"orderable": false
				},
				{
					"targets": 2,
					"orderable": false
				},
				{
					"targets": 3,
					"orderable": false
				},
				{ "visible": false,  "targets": [ 1,3 ]},
				{ responsivePriority: -1, targets: 0 },
                { responsivePriority: -1, targets: 1 },
			]
		});	
		
	}
	/*
	let titleCol = sendTable.column(1);
		titleCol.visible( ! titleCol.visible() );
	let currentCol = sendTable.column(1);
		currentCol.visible( ! currentCol.visible() );
	*/
</script>
<?php
endif;
?>