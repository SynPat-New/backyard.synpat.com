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
	    min-width: auto;
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
#send_list_heading th:nth-child(2),#send_list_heading th:nth-child(4),#send_list tr td:nth-child(2),#send_list tr td:nth-child(4){display:none;}
.dataTables_info{display:none;}
.table>thead>tr>th,.table > tbody > tr > td{word-break:break-word;}
.table{margin:0px !important;}
.circle{display:inline-block;width:10px;height:10px;border-radius:50%;}
.green{background-color:green !important;}
.orange{background-color:orange !important;}
.yellow{background-color:yellow !important;}
.note-editor{float:left;}
</style>
<?php
$leadID = $campaign_data['lead_id'];
$campaignID = $campaign_data['campaign_id'];
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
if(isset($campaign_data['body'])){
	$body = $campaign_data['body'];
}
$body = str_replace("\n\n\n","\n\n",$body);
$body = str_replace("\n\n\n","\n\n",$body);
/*echo json_encode((string)$body);*/
/*
$sp  = json_encode((string)$body);
echo $sp;*/
$peronList = array();$companyList = array();$mailList = array();$signalList = array();
try{
	$peronList = json_decode($campaign_data['person_list']);
	$companyList = json_decode($campaign_data['company_list']);
	$mailList = json_decode($campaign_data['email_list']);
	$signalList = json_decode($campaign_data['signal_list']);
}catch(Exception $e){
	
}

/*$companyList = explode(',',$campaign_data['company_list']);
$mailList = explode(',',$campaign_data['email_list']);*/
$ignoreEmails = array();
$contact_list = $campaign_data['contact_list'];
?>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script> 
<link rel="stylesheet" href="<?php echo $Layout->cdn_server_url_static;?>email_campaign/css/bootstrap.min.css" />
<script type="text/javascript" src="<?php echo $Layout->cdn_server_url_static;?>email_campaign/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo $Layout->cdn_server_url_static;?>email_campaign/font-awesome-4.4.0/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl;?>public/widgets/summernote-wysiwyg/summernote-wysiwyg.css"/>
<script type='text/javascript' src="<?php echo $Layout->baseUrl;?>public/widgets/summernote-wysiwyg/summernote-wysiwyg.js"></script>
<script>
jQuery(document).ready(function() {
	jQuery('#body').summernote({
	  height:350,
	  toolbar:[]
	});
});
/*console.log(_companyList);*/
</script>

<div style='float:left;width:70%;overflow:auto;'>
	<h4 style="height:20px;width:100%;overflow:hidden;">To Send (<span id="send_counter_list"><?php echo count($contact_list);?></span>)</h4>
	<table class='table' id="main_list_heading">
		<thead>
		<tr>
			<th>Person</th>
			<th>Title</th>
			<th>Company</th>
			<th>Current</th>
		</tr>
		</thead>
	</table>
	<div id="main_table_container" style="overflow:hidden;overflow-y:auto;height:77vh;">
		<table class='table' id="main_list">		
			<tbody>
			<?php 			
				if(count($contact_list)>0){
					for($i=0;$i<count($contact_list);$i++){
						$companyName = $contact_list[$i]->company_name;
						if($contact_list[$i]->company_name_alias != null && $contact_list[$i]->company_name_alias != ''){
							$companyName = $contact_list[$i]->company_name_alias;
						}
						
			?>
						<tr data-i="<?php echo $i;?>" data-camp-id="<?php echo $campaignID?>" data-cam-id="<?php echo $contact_list[$i]->campaign_list_id;?>" data-first_name="<?php echo $contact_list[$i]->first_name;?>" data-last_name="<?php echo $contact_list[$i]->last_name;?>" data-linkedin='<?php echo $contact_list[$i]->linkedin_url;?>' data-c='<?php echo $contact_list[$i]->id;?>' data-co='<?php echo $contact_list[$i]->company_id;?>' data-gender='<?php echo $contact_list[$i]->gender;?>'>
							<td class='contact' id="contact_<?php echo $contact_list[$i]->id;?>"><span id="profile_pic" style='margin-right:5px;'><?php if($contact_list[$i]->linkedin_image != ''){ ?><img src="<?php echo $contact_list[$i]->linkedin_image;?>" width="50"/> <?php }?></span> <a href='javascript://' onclick="window.parent.openContactEditForm(<?php echo $contact_list[$i]->id;?>)"><?php echo $contact_list[$i]->first_name." ".$contact_list[$i]->last_name;?> <span class="gender">(<?php echo $contact_list[$i]->gender==0?'M':'F';?>) <?php echo $class !=''?'<span class="'.$class.'"></span>':'';?></span></a><a href="javascript://" onclick="deleteUserFromCampaign(jQuery(this))" ><svg style="width:10px;position:relative;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-2x"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z" class=""></path></svg></a></td>
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
</div>
<div style='float:left;width:30%'> 
	<form action="" method="post" class="emaillinked-form">
		<button type="button" id='btnSendMessage' onclick="openLinkedin();" class="button" style='float:right;margin-bottom:10px;'>Open Linkedin</button><button type="button" id='btnSendMessage' onclick="updateMessage(<?php echo $campaignID?>)" class="button" style='float:right;margin-bottom:10px;margin-right:10px;'>Save</button>
		<span style='float:right;'>Legend: use for firstname #First#, for lastname #Last#, for company #Company#, for saluation #Salutation#<br/></span> 
		<label>Body:</label><textarea name="body" id="body"><?php echo nl2br($body);?></textarea>	
	</form>
</div>	
<script>
	jQuery(document).ready(function(){
		fixHeaderWidth('main_list');
	});
	jQuery(window).resize(function(){
		fixHeaderWidth('main_list');
	});
	function openLinkedin(){
		window.open('https://linkedin.com','_BLANK');
	}
	function createElementOnFly(name,t){
		const createD = document.createElement('div');
		createD.style = "float:left;position:relative;left:-99999px;padding:0;margin:0px;font:400 18px/1.6em Roboto,sans-serif;";
		createD.innerHTML = name;
		createD.setAttribute('id','stton');
		const bTag = document.getElementsByTagName('body')[0];
		bTag.appendChild(createD);
		const tagD = document.getElementById('stton');
		let text =  t==1?tagD:tagD.innerText;
		if(t != 1){tagD.remove();}
		return text;
	}
	function updateMessage(cID){		
		console.log(jQuery("#body").code());
		let message = $("#body").code();
		plainText = createElementOnFly(message,0);
		if(cID > 0 && plainText!= "" && plainText != undefined){
			jQuery.ajax({
				url:'https://backyard.synpat.com/users/update_campaign_message',
				type:'POST',
				data:{campaign_id:cID,m:plainText}
			}).done(d => {
				console.log("CampaignMessage:",d)
			})
		}
	}
	function fixHeaderWidth(c){
		let tableEle = jQuery("#"+c);
		let tableHeadingEle = jQuery("#"+c+'_heading');
		
		let width = 0;
		tableHeadingEle.find('th').each(function(i){
			width = 0;
			var $thisH = $(this);;
			tableEle.find('tr').each(function(){
				var $this  = $(this);
				width = width > $this.find('td').eq(i).width() ? width : $this.find('td').eq(i).width();
			});
			$thisH.width(width);
		});
	}
	function deleteUserFromCampaign(o){
		let $tr = o.parents('tr');
		let campaignID = $tr.attr('data-camp-id');
		let campaignListID = $tr.attr('data-cam-id');
		if(campaignID > 0 && campaignListID > 0){
			jQuery.ajax({
				url:'https://backyard.synpat.com/users/delete_user_from_campaign',
				type:'POST',
				data:{campaign_id:campaignID,list_id:campaignListID}
			}).done(d => {
				if(d>0){
					$tr.remove();
				}
			})
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
					trEle.find('td.contact').find("#profile_pic").html("<img src='"+contactData.linkedin_image+"' width='50'/>");
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
			}
		}
	}
</script>
<?php
endif;
?>