<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
	
	private $skey = "sYnP@TpRoJ3cT5#%"; 
	
	public function __construct(){
		parent::__construct();
		$this->load->library('DriveServiceHelper');
		$service = new GmailServiceHelper();
		if(!isset($this->session->userdata['type']) || empty($this->session->userdata['email'])){
			/*$this->session->set_flashdata('error','Please login first!');*/
			if(!isset($_SESSION)){
				session_start();
			}
			if(isset($_SESSION['find_user']) && !empty($_SESSION['find_user']['type'])){
				$this->session->set_userdata($_SESSION['find_user']); 
			} else {
				redirect('login');
			}
		}
		$this->load->model('user_model');
		$this->load->model('lead_model');
		$this->load->model('client_model');
		$this->load->model('customer_model');
		$this->load->model('general_model');		
		$this->load->model('acquisition_model');
		$this->load->model('opportunity_model');
		if(!isset($this->session->userdata['signature']) || empty($this->session->userdata['signature'])){
			$sign = $this->user_model->signature();
			$originalSignature = $sign->signature;
			$emailSignature = $originalSignature;
			$user = $this->user_model->getUserData($this->session->userdata['id']);
			$emailSignature = str_replace('#Name#',$user->name,$emailSignature);
			if(!empty($user->mobile_number)){
				$emailSignature = str_replace('#Mobile#',"M: ".$user->mobile_number,$emailSignature);
			} else {
				$emailSignature = str_replace('#Mobile#',"",$emailSignature);
			}
			$emailSignature = str_replace('#Email#',$user->email_for_signature,$emailSignature);
			$emailSignature = str_replace('#Title#',$user->title,$emailSignature);
			if(!empty($user->direct_number)){
				$emailSignature = str_replace('#Direct#',"D: ".$user->direct_number,$emailSignature);
			} else {
				$emailSignature = str_replace('#Direct#',"",$emailSignature);
			}
			$user_data = $this->session->userdata;
			$user_data['user'] = (array)$user;
			$user_data['email'] = $user->email;
			$user_data['name'] = $user->name;
			$user_data['phone_number'] = $user->phone_number;
			$user_data['mobile_number'] = $user->mobile_number;
			$user_data['direct_number'] = $user->direct_number;
			$user_data['email_for_signature'] = $user->email_for_signature;
			$user_data['title'] = $user->title;
			$user_data['signature'] = $emailSignature;
			$user_data['original_signature'] = $originalSignature;
			if(!isset($_SESSION)){
				session_start();
			}
			$_SESSION['find_user'] = $user_data;					
			$this->session->set_userdata($user_data);
		}
		
		$this->layout->auto_render=false;	
		$this->layout->layout='default';
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));		
	}
	
	private function getTokenKey(){
		return $this->skey;
	}
	
	private  function safe_b64encode($string) {
		$data = base64_encode($string);
		$data = str_replace(array('+','/','='),array('-','_',''),$data);
		return $data;
	}

	private function safe_b64decode($string) {
		$data = str_replace(array('-','_'),array('+','/'),$string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}

	private  function encode($value){ 		
		if(!$value){return false;}
		$text = $value;
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->getTokenKey(), $text, MCRYPT_MODE_ECB, $iv);
		return trim($this->safe_b64encode($crypttext)); 
	}

	private function decode($value){
		if(!$value){return false;}
		$crypttext = $this->safe_b64decode($value); 
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->getTokenKey(), $crypttext, MCRYPT_MODE_ECB, $iv);
		return trim($decrypttext);
	}
	
	public function activity($leadID = 0){
		$data['getTimelineData'] = $this->user_model->getAllUsersActivity($leadID);
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Users Activities';
		$this->layout->render('user/activities',$data);
	}
	
	public function send_scrapper_request_to_server(){
		$content = '';
		if(isset($_POST) && count($_POST)>0){
			$url = $this->input->post('url');
			$d = $this->input->post('d');
			if($d!=""){
				$url .="?d=".$d;
			}
			set_time_limit(0);
			/*ignore_user_abort(true);
			set_time_limit(0);*/
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			$content = curl_exec($ch);
			curl_close($ch);
			echo $content;
		}
		die;
	}
	
	public function call_web_driver_scrape_google() {
		$url = "http://webdriverforscrape.site/scrap_google_page.php";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$content = curl_exec($ch);
		curl_close($ch);
		echo $content;
		die;
	}
	
	public function run_email_scrapper() {
		$content = '';
		if(isset($_POST) && count($_POST)>0){
			$url = $this->input->post('d');			
			set_time_limit(0);
			ignore_user_abort(true);
			set_time_limit(0);			
			$ch = curl_init($url);
			$postData = array();
			$companies = array();
			$contacts = array();
			if(isset($_POST['company_list'])){
				$companies = $_POST['company_list'];
			}
			if(isset($_POST['contacts'])){
				$contacts = $_POST['contacts'];
			}
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, array(
				'companies' => json_encode($companies),
				'contacts'  => json_encode($contacts)
			));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			$content = curl_exec($ch);
			curl_close($ch);			
		}
		echo $content;
		die;
	}
	
	public function calling($p=null,$f=null,$e=null){		
		require(APPPATH.'third_party/caller/autoload.php');		
		set_error_handler(function ($errno, $errstr, $errfile, $errline) {
			if (!(error_reporting() & $errno)) {
				return;
			}
			throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		});
		set_exception_handler(function (Exception $e) {

			print 'Exception: ' . $e->getMessage() . PHP_EOL;

			if ($e instanceof RingCentral\SDK\Http\HttpException) {

				print 'SDK HTTP Error at ' . $e->getTransaction()->getRequest()->getUri() . PHP_EOL .
					  'Response body: ' . $e->getTransaction()->getText() . PHP_EOL;

			}

			if ($e->getPrevious()) {
				print 'Previous: ' . $e->getPrevious()->getMessage() . PHP_EOL;
			}

			print $e->getTraceAsString() . PHP_EOL;

		});
		$password = "!Q2w3e4r";
		$ext = "101";
		if($e=="102"){
			$password = "!Q2w3e4r";
			$ext = "102";
		}
		$credentials = array(
				'appKey'=>'WNQTfX1oSW-RdYpZj1NEfQ',
				'appSecret'=>'37v6dCLpTY-SqLE4dhHA6ArwQMMF5xSlqKXJ-hsg6j7Q',
				'server'=>'https://platform.ringcentral.com',
				'username'=>'+14158058818',
				'extension'=>$ext,
				'password'=>$password,
				'mobileNumber'=>'+14159025901'
		);
		$rcsdk = new RingCentral\SDK\SDK($credentials['appKey'], $credentials['appSecret'], $credentials['server'], 'Demo', '1.0.0');
		$platform = $rcsdk->getPlatform();
		$platform->authorize($credentials['username'], $credentials['extension'], $credentials['password'], false);
		

		$from = "+14158058818";
		if($f!=null && !empty($f)){
			$from = $f;
		}
		
		$response = $platform->post('/account/~/extension/~/ringout', null, array(
			'from' => array('phoneNumber' => urldecode($from)),
			'to'   => array('phoneNumber' => urldecode($p))
		));
		$json = $response->getJson();
		$lastStatus = $json->status->callStatus;
		echo json_encode(array('uri'=>$json->uri));
		// Poll for call status updates
		/*while ($lastStatus == 'InProgress') {
			$current = $platform->get($json->uri);
			$currentJson = $current->getJson();
			echo "<pre>";
			print_r($currentJson);
			$lastStatus = $currentJson->status->callStatus;
			print 'Status: ' . json_encode($currentJson->status) . PHP_EOL;
			sleep(2);
		}
		print 'Done.' . PHP_EOL;*/
		die;
	}
	
	function callingStatus(){
		require(APPPATH.'third_party/caller/autoload.php');		
		set_error_handler(function ($errno, $errstr, $errfile, $errline) {
			if (!(error_reporting() & $errno)) {
				return;
			}
			throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		});
		set_exception_handler(function (Exception $e) {

			print 'Exception: ' . $e->getMessage() . PHP_EOL;

			if ($e instanceof RingCentral\SDK\Http\HttpException) {

				print 'SDK HTTP Error at ' . $e->getTransaction()->getRequest()->getUri() . PHP_EOL .
					  'Response body: ' . $e->getTransaction()->getText() . PHP_EOL;

			}

			if ($e->getPrevious()) {
				print 'Previous: ' . $e->getPrevious()->getMessage() . PHP_EOL;
			}

			print $e->getTraceAsString() . PHP_EOL;

		});
		$password = "!Q2w3e4r";
		$ext = "101";
		if($e=="102"){
			$password = "!Q2w3e4r";
			$ext = "102";
		}
		$credentials = array(
				'appKey'=>'WNQTfX1oSW-RdYpZj1NEfQ',
				'appSecret'=>'37v6dCLpTY-SqLE4dhHA6ArwQMMF5xSlqKXJ-hsg6j7Q',
				'server'=>'https://platform.ringcentral.com',
				'username'=>'+14158058818',
				'extension'=>$ext,
				'password'=>$password,
				'mobileNumber'=>'+14159025901'
		);
		$rcsdk = new RingCentral\SDK\SDK($credentials['appKey'], $credentials['appSecret'], $credentials['server'], 'Demo', '1.0.0');
		$platform = $rcsdk->getPlatform();
		$platform->authorize($credentials['username'], $credentials['extension'], $credentials['password'], false);
		$current = $platform->get($this->input->post('uri'));
		$currentJson = $current->getJson();
		echo json_encode($currentJson->status) ;
		die;
	}
	
	function getActiveCalls(){
		require(APPPATH.'third_party/caller/autoload.php');		
		set_error_handler(function ($errno, $errstr, $errfile, $errline) {
			if (!(error_reporting() & $errno)) {
				return;
			}
			throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
		});
		set_exception_handler(function (Exception $e) {

			print 'Exception: ' . $e->getMessage() . PHP_EOL;

			if ($e instanceof RingCentral\SDK\Http\HttpException) {

				print 'SDK HTTP Error at ' . $e->getTransaction()->getRequest()->getUri() . PHP_EOL .
					  'Response body: ' . $e->getTransaction()->getText() . PHP_EOL;

			}

			if ($e->getPrevious()) {
				print 'Previous: ' . $e->getPrevious()->getMessage() . PHP_EOL;
			}

			print $e->getTraceAsString() . PHP_EOL;

		});
		$password = "!Q2w3e4r";
		$ext = "101";
		/*if($e=="102"){
			$password = "!Q2w3e4r";
			$ext = "102";
		}*/
		$credentials = array(
				'appKey'=>'WNQTfX1oSW-RdYpZj1NEfQ',
				'appSecret'=>'37v6dCLpTY-SqLE4dhHA6ArwQMMF5xSlqKXJ-hsg6j7Q',
				'server'=>'https://platform.ringcentral.com',
				'username'=>'+14158058818',
				'extension'=>$ext,
				'password'=>$password,
				'mobileNumber'=>'+14159025901'
		);
		$rcsdk = new RingCentral\SDK\SDK($credentials['appKey'], $credentials['appSecret'], $credentials['server'], 'Demo', '1.0.0');
		$platform = $rcsdk->getPlatform();
		$platform->authorize($credentials['username'], $credentials['extension'], $credentials['password'], false);
		$subscription = $rcsdk->getSubscription();
$subscription->setKeepPolling(true);
		$subs = $subscription->subscribe(array('events'=>array('/account/~/extension/'.$ext.'/presence?detailedTelephonyState=true&aggregated=true'),'deliveryMode'=>array('transportType'=>'WebHook','address'=>'https://synpat.com/ringcentral.php','encryption'=>false)));

		
print_r($subs->getJson(false));
die;
		
		
		$subscription->on(Subscription::EVENT_NOTIFICATION, function (NotificationEvent $e) {
			print 'Notification' . print_r($e->getPayload(), true) . PHP_EOL;
		});

		print 'Subscribing' . PHP_EOL;

		$subscription->register();

		print 'End' . PHP_EOL;
		
		
		
	}
	
	public function anyDoLogin(){
		$loginURL = "https://sm-prod.any.do/j_spring_security_check";
		echo $loginURL."<br/>";
		$curl = curl_init();
		$header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,"; 
		$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5"; 
		$header[] = "Cache-Control: max-age=0"; 
		$header[] = "Connection: keep-alive"; 
		$header[] = "Keep-Alive: 300"; 
		$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7"; 
		$header[] = "Accept-Language: en-us,en;q=0.5"; 
		$header[] = "Pragma: "; // browsers keep this blank.
		curl_setopt($curl, CURLOPT_URL, $loginURL); 
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.2 Safari/537.36'); 
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header); 
		curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate,sdch'); 
		curl_setopt($curl, CURLOPT_COOKIESESSION, true); 
		curl_setopt($curl, CURLOPT_POST, true); 
		curl_setopt(CURLOPT_POSTFIELDS, array(
				'j_username' => "webmaster@synpat.com",
				'j_password'=>"N@mish2512",
				'_spring_security_remember_me'=>"on",
			)); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($curl, CURLOPT_TIMEOUT, 180000); 		
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		echo "<pre>";
		print_r($resp);
		die;
	}
	
	public function countUnseenMeesagesImap(){
		$count = 0;
		$hostname = 'imap.gmail.com:993';
		$this->config->load('config');
		$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl','folder'=>'INBOX');
		$this->load->library('Imap',$params);
		if($this->imap->isConnected()){
			/*$messages = $this->imap->imapSearch('UNSEEN');*/
			$messages = $this->imap->getMessages();
			$count = count($messages);
		}
		echo $count;
		die;
	}
	
	function check_is_tap($t=1){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$messages  = array();
		$params = array();
		/*$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';*/
		$hostname = 'imap.gmail.com:993';
		$this->config->load('config');
		$accessAccount = "";
		switch((int)$t){
			case 1:
				/*Licenses*/
				if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):
					$accessAccount = $this->config->item('license_email');
				endif;
			break;
			case 2:
				/*Patents*/
				if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):
					$accessAccount = $this->config->item('operations_email');
				endif;
			break;
			case 3:
				/*Experts*/
				if((int)$this->session->userdata['user']['type']==9 || in_array(27,$this->session->userdata['modules_assign'])):
					$accessAccount = $this->config->item('experts_email');
				endif;
			break;
		}
		$params = array('mailbox'=>$hostname,'username'=>$this->config->item('imap_email'),'password'=>$this->config->item('imap_password'),'encryption'=>'ssl');
		if(count($params)>0){
			$this->load->library('Imap',$params);
			if($this->imap->isConnected()){
				$messages = $this->imap->searchEmails('TO "'.$accessAccount.'"');
			} else {
				echo $this->imap->getError();
				die;
			}
		}
		echo json_encode($messages);
		die;
	}
	
	public function imap_emails($t=1){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$messages  = array();
		$params = array();
		/*$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';*/
		$hostname = 'imap.gmail.com:993';
		$this->config->load('config');
		$accessAccount = "";
		switch((int)$t){
			case 1:
				/*Licenses*/
				if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):
					/*$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl');*/
					$accessAccount = $this->config->item('license_email');
				endif;
			break;
			case 2:
				/*Patents*/
				if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):
					/*$params = array('mailbox'=>$hostname,'username'=>$this->config->item('operations_email'),'password'=>$this->config->item('operations_password'),'encryption'=>'ssl');*/
					$accessAccount = $this->config->item('operations_email');
				endif;
			break;
			case 3:
				/*Experts*/
				if((int)$this->session->userdata['user']['type']==9 || in_array(27,$this->session->userdata['modules_assign'])):
					$accessAccount = $this->config->item('experts_email');
				endif;
			break;
		}
		$params = array('mailbox'=>$hostname,'username'=>$this->config->item('imap_email'),'password'=>$this->config->item('imap_password'),'encryption'=>'ssl');
		if(count($params)>0){
			$this->load->library('Imap',$params);
			/*if($this->imap->isConnected()){
				$this->imap->selectFolder('INBOX');
				$messages = $this->imap->getMessages();
			}*/
			if($this->imap->isConnected()){
				$this->imap->selectFolder('INBOX');
				$messages = $this->imap->searchEmails('TO "'.$accessAccount.'"');
			} else {
				echo $this->imap->getError();
				die;
			}
		}
		if((int)$t == 1){
			/*campaign messages*/
			$this->load->model('lead_model');
			foreach($messages as $message){
				
				$message = (array)$message;
				if(isset($message['overview']) && $message['overview']->in_reply_to){
					$repliedID = $message['overview']->in_reply_to;
					$emailSubject = $message['overview']->subject;
					$tested = 1;
					if(strpos($emailSubject,"Delivery Status Notification (Failure)") === false){
						$tested = 0;
					}
					if($tested === 1){
						if(strpos($emailSubject,"Delivery Status Notification (Delay)") === false){
							$tested = 0;
						}
					}
					if($tested === 1){
						if(strpos($emailSubject,"Undelivered Mail Returned to Sender") === false){
							$tested = 0;
						}
					}
					if($tested === 1){
						if(strpos($emailSubject,"Returned mail: see transcript for details") === false){
							$tested = 0;
						}
					}
					if($tested === 1){
						if(strpos($emailSubject,"Undeliverable: ") === false){
							$tested = 0;
						}
					}
					if($tested == 1){
						/**/
						$getEmail = $this->lead_model->searchBoxListByContent($repliedID,"id");
						if(count($getEmail) > 0){
							$getCamapignListID = $this->lead_model->getCampaignListIDByEmailID($getEmail->id,'id');
							if(count($getCamapignListID) > 0){
								$this->lead_model->updateCampaignListByID(array('open'=>1),$getCamapignListID->id);
								$this->lead_model->updateBox($getEmail->id,array('open'=>1));
							}
						}
					}
				}
			}
		}
		echo json_encode($messages);
		die;		
	}
	
	public function count_imap_emails(){
		$data = array('license'=>0,'operation'=>0,'expert'=>0);
		$hostname = 'imap.gmail.com:993';
		$this->config->load('config');
		$tap = 0;
		$params = array('mailbox'=>$hostname,'username'=>$this->config->item('imap_email'),'password'=>$this->config->item('imap_password'),'encryption'=>'ssl'); 
		$this->load->library('Imap',$params);
		if($this->imap->isConnected()){
			if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])){
				$accessAccount = $this->config->item('license_email');	
				$this->imap->selectFolder('INBOX');
				$data['license'] = $this->imap->searchEmailsCount('TO "'.$accessAccount.'"');				
			}
			if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])){
				$accessAccount = $this->config->item('operations_email');
				$this->imap->selectFolder('INBOX');
				$data['operation'] = $this->imap->searchEmailsCount('TO "'.$accessAccount.'"');				
			}
			if((int)$this->session->userdata['user']['type']==9 || in_array(27,$this->session->userdata['modules_assign'])){
				$accessAccount = $this->config->item('experts_email');
				$this->imap->selectFolder('INBOX');
				$data['expert'] = $this->imap->searchEmailsCount('TO "'.$accessAccount.'"');				
			}			
		}
		echo json_encode($data);
		die;
	}
	
	public function deleteImapMessage(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$dt = 0;
		$msgNo = $this->input->post('msg_no');
		$uid = $this->input->post('uid');
		$t = $this->input->post('t');
		$params = array();
		$hostname = 'imap.gmail.com:993';
		$this->config->load('config');
		$params = array('mailbox'=>$hostname,'username'=>$this->config->item('imap_email'),'password'=>$this->config->item('imap_password'),'encryption'=>'ssl');
		$fromEmail = "";
		switch((int)$t){
			case 1:
				if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):
					$fromEmail = $this->config->item('license_email');
				endif;
			break;
			case 2:
				if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):
					$fromEmail = $this->config->item('operations_email');
				endif;
			break;
			case 3:
				if((int)$this->session->userdata['user']['type']==9 || in_array(27,$this->session->userdata['modules_assign'])):
					$fromEmail = $this->config->item('experts_email');
				endif;
			break;
		}
		if(count($params)>0){
			$this->load->library('Imap',$params);
			if($this->imap->isConnected()){
				$deleteM = $this->imap->permanentDeleteMessage($uid);
				if($deleteM===true){
					$dt = 1;
				}
			}
		}
		echo $dt;
		die;
	}
	
	public function sendRequestZoomMeeting($calledFunction, $data){
		/*Creates the endpoint URL*/
		$this->config->load('config');
		$request_url = $this->config->item('zoom_api_url').$calledFunction;
		/*Adds the Key, Secret, & Datatype to the passed array*/
		$data['api_key'] = $this->config->item('zoom_api_key');
		$data['api_secret'] = $this->config->item('zoom_api_secret');
		$data['data_type'] = 'JSON';
		$postFields = http_build_query($data);
		/*Preparing Query...*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		curl_close($ch);
		if(!$response){
			return false;
		}
		/*Return the data in JSON format*/
		return $response;
	}
	
	public function contacts_in_c(){
		$data = array();
		$post = $this->input->post();
		if(count($post)>0){
			$data = $this->client_model->getAllContactBelongToCompany($post['c']);
		}
		echo json_encode($data);
		die;
	}
	
	function company_list(){
		$this->load->model('lead_model');
		$companyList = $this->lead_model->getAllCompaniesList('id,company_name');
		echo json_encode($companyList);
		die;
	}
	
	function getUserToken(){
		$this->load->library('DriveServiceHelper');
		if(!isset($_SESSION)){
			session_start();		
		}
		$service = new GmailServiceHelper();
		$this->load->model('user_model');
		$getUserData = $this->user_model->getUserData($this->session->userdata['id'],"google_token");
		$userAccessToken = '' ;
		if(count($getUserData)>0 && !empty($getUserData->google_token)){				
			$userAccessToken = $getUserData->google_token;
		}
		if($service->checkExpiredToken()){
			$google_token= json_decode($userAccessToken);
			if(isset($google_token->refresh_token)){
				$service->refreshToken($google_token->refresh_token);
				$newToken = json_decode($service->getAccessToken());
				$google_token->id_token = $newToken->id_token;
				$google_token->access_token = $newToken->access_token;
				$google_token->created = $newToken->created;
				$google_token = json_encode($google_token);	
				$this->user_model->updateUserData(array("google_token"=>$google_token),$this->session->userdata['id']);
				$_SESSION['another_access_token'] = $google_token;
				$_SESSION['access_token'] = $google_token;
			} else {
				$google_token=$userAccessToken;
			} 
		}else {
			$google_token= $userAccessToken;
		}
		return $google_token;
	}
	
	function search_gmail(){
		$post = $this->input->post();
		$awsUrl = $this->config->item('aws_server_cdn');
		if(count($post)>0){			
			$q = "";
			$from="";
			$to="";
			$subject="";
			$has="";
			$doesntHave="";
			if(isset($post['search']) && !empty($post['search'])){
				$q = $post['search']." ";
			}
			
			if(isset($post['search_from']) && !empty($post['search_from'])){
				$q .= "from:(".$post['search_from'].") ";
				$from = $post['search_from'];
			}
			if(isset($post['search_to']) && !empty($post['search_to'])){
				$q .= "to:(".$post['search_to'].") ";
				$to = $post['search_to'];
			}
			if(isset($post['search_subject']) && !empty($post['search_subject'])){
				$q .= "subject:".$post['search_subject']." ";
				$subject = $post['search_subject'];
			}
			if(isset($post['has']) && !empty($post['has'])){
				$q .= $post['has']." ";
				$has =  $post['has'];
			}
			if(isset($post['doesnt_have']) && !empty($post['doesnt_have'])){
				$q .= "-{".$post['doesnt_have']."} ";
				$doesntHave = $post['doesnt_have'];
			}
			$q = trim($q);
			echo $q;
			if(!empty($q)){
				if($post['search']=="in:lead"){
					/*Search from emails database*/
					$emails = $this->lead_model->emailSearch($from,$to,$subject,$has,$doesntHave);
					if(count($emails)>0){
						foreach($emails as $message){
							$from = "";
							$subject = "";
							$data = "";
							$_dateD = "";
							$messageIDDD = "";
							$threadID = "";
							$messageID = "";
							$id=$message->id;
							$countAttachments = 0;
							$content = json_decode($message->content);					
							switch($message->account_type){
								case 1:
									$headers = $content[0]->header;
									foreach($headers as $header){					
										if($header->name=="From"){	
											$from = $header->value;
										}
										if($header->name=="Subject"){
											$subject = $header->value;	
										}
										if($header->name=="Date"){
											$date = $header->value;
										}
										if($header->name=="Message-ID"){
											$messageIDDD = $header->value;
										}
									}
									$threadID = $message->thread_id;
									$messageID = $message->message_id;
									$parts = $content[0]->parts;
									$countAttachments = 0;
									if(isset($parts[0]) && ($parts[0]->mimeType=="multipart/alternative" || $parts[0]->mimeType=="multipart/related")){
										for($i=1;$i<count($parts);$i++){
											$attachmentID = $parts[$i]->getBody()->getAttachmentId();
											if(!empty($attachmentID)){
												$countAttachments++;
											}
										}
									}
								break;
								case 2:
									$date = $content->header->Date;
									$subject = $content->header->subject;
									$from = $content->header->from[0]->personal;
									$messageIDDD = $content->header->message_id;
									$countAttachments = 0;
									$parts = $message->file_attach;
									$countAttachments = explode(',',$parts);
									$countAttachments = count($countAttachments)-1;
								break;
							}							
						?>
							<div class="message-item media draggable" data-date='<?php echo $date?>' data-message-thread-id="<?php echo $threadID?>" data-id="<?php echo $messageID?>" data-message-id="<?php echo $messageIDDD;?>" data-task="0" data-acompany="<?php echo $message->aCompanyID?>" data-scompany="<?php echo $message->sCompanyID?>" data-atype="<?php echo $message->aType?>" data-stype="<?php echo $message->sType?>" data-lead="<?php echo $message->lead_id?>" data-lead-name="<?php echo $message->lead_name?>" data-send="<?php echo $message->account_type?>" data-type="<?php echo $message->from_activity?>">														
					<div class="message-item-right">
						<div class="media">																
							<div class="media-body">
								<h5 class="c-dark" onclick="findOwnThread(<?php echo $id;?>,jQuery(this),2,2);">								
									<a class="c-dark" style='font-weight:normal' href="javascript:void(0)"><?php echo $from;?></a>
								</h5>
								<h4 class="c-dark" onclick="findOwnThread(<?php echo $id;?>,jQuery(this),2,2);"><?php echo $subject;?></h4>
								<div>
									<span class="message-item-date"  onclick="findOwnThread(<?php echo $id;?>,jQuery(this),2,2);"><?php echo date('M d, Y',strtotime($date));?></span>
									&nbsp;									
									<?php 
										
										if($countAttachments>0):
									?>
									<strong><i class="glyph-icon icon-paperclip"></i> <?php echo $countAttachments;?></strong>
									<?php endif;?>	
									<span class="lead_name"></span>
									<!--<a href='javascript://' onclick="enableTask(jQuery(this))" style='float:right;width:15px;'><i class="glyph-icon icon-plus"></i></a>
									--><a href='javascript://' onclick="moveEmailToTrash(jQuery(this))" style='float:right;width:15px;'><i class="glyph-icon"><img src="<?php echo $awsUrl;?>images/discard.png" style="opacity:0.55;width:10px"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
						<?php
						}
					}
			}else{
				$this->load->library('DriveServiceHelper');
				$service = new GmailServiceHelper();
				if(!isset($_SESSION)){
					session_start();
				}
				$googleToken = $_SESSION['another_access_token'];
				if(empty($googleToken)){
					$googleToken = $this->getUserToken();
				}
				$service->setAccessToken($googleToken);
				$labels = $service->listLabels();
				$labelID = "";
				foreach($labels as $key=>$label){
					if(strtoupper($label)=="LEAD"){
						$labelID = $key;
					} 
				}
				$emails = $service->searchEmails($q);
				$mimeTypePayload = array('multipart/mixed','multipart/alternative','multipart/related');
				foreach($emails as $message){
				$from ="";													
				$to ="";													
				$subject="";													
				$date = "";	
				$_dateD = "";
				$messageIDDD ="";
				foreach($message['header'] as $header){
					
					if($header->name=="From"){	
						$from = $header->value;
					}
					if($header->name=="To"){	
						$to = $header->value;
					}
					if($header->name=="Subject"){
						$subject = $header->value;	
					}
					if($header->name=="Date"){
						$date = $header->value;
					}
					if($header->name=="Message-ID"){
						$messageIDDD = $header->value;
					}
				}
				
				
			?>
				<div class="message-item media draggable" data-date='<?php echo $date?>' data-id="<?php echo $message['message_id']?>" data-message-id="<?php echo $messageIDDD;?>">														
					<div class="message-item-right">
						<div class="media">																
							<div class="media-body">
								<h5 class="c-dark"  onclick="findNewThread('<?php echo $message['message_id']?>',jQuery(this));">
								<?php 
									if(in_array(strtoupper('unread'),$message['labelIds'])){
								?>
										<strong>From: <a class="c-dark" href="javascript:void(0)"><?php echo $from;?></a></strong>
										<strong>To: <a class="c-dark" href="javascript:void(0)"><?php echo $to;?></a></strong>
								<?php
									} else {
								?>
										From: <a class="c-dark" style='font-weight:normal' href="javascript:void(0)"><?php echo $from;?></a> To: <a class="c-dark" style='font-weight:normal' href="javascript:void(0)"><?php echo $to;?></a>
								<?php
									}
								?>
								</h5>
								<h4 class="c-dark" onclick="findNewThread('<?php echo $message['message_id']?>',jQuery(this));"><?php echo $subject;?></h4>
								<div>
									<span class="message-item-date"  onclick="findNewThread('<?php echo $message['message_id']?>',jQuery(this));"><?php echo date('M d, Y',strtotime($date));?></span>
									&nbsp;									
									<?php 
										
										$countAttachments = count($message['attachments']);
										/*$parts = $message['parts'];
										if(isset($parts[0]) && (in_array($parts[0]->mimeType,$mimeTypePayload))){
											for($i=1;$i<count($parts);$i++){											
												$attachmentID = $parts[$i]->getBody()->getAttachmentId();
												if(!empty($attachmentID)){
													$countAttachments++;
												}
											}
										}*/
										
										/*if(count($message['attachments'])>0):*/
										if($countAttachments>0){
									?>
									<strong><i class="glyph-icon icon-paperclip"></i> <?php echo $countAttachments;?></strong>
										<?php }
										if(!empty($labelID) && in_array($labelID, $message['labelIds'])){
											echo '&nbsp;<i class="glyph-icon icon-folder" style="color:#2196f3"></i>';
										}
										?>
										<span class="lead_name"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
			}
			} else{
				echo "<p>No messages matched your search.</p>";
			}			
		}
		die;
	}
	
	function template_file_content(){
		if(isset($_POST) && count($_POST)>0 && isset($_POST['name'])){
			if(!empty($_POST['name'])){
				$serverUrl = $this->config->base_url();
				/*$serverUrl = "http://backyard.synpat.com/";*/
				$fileName = $_POST['name'];
				$fileName = str_replace("https://synpat.com/","/var/www/synpat/synpat/",$fileName);
				if(file_exists($fileName)){					
					if($_POST['s']==1 || $_POST['s']==3){
						echo file_get_contents($_POST['name']);
					} else if($_POST['s']==2){
						$fileContent = file_get_contents($_POST['name']);
						//echo strip_tags($fileContent);
						echo $fileContent;
					}
					
				}
			}  
		}
		die;
	}
	
	function lead_templates($leadID = 0, $s=1){
		$data['lead_templates'] = array();
		$data['count_bank_template'] = array();
		if($leadID>0){
			/*$data['lead_templates_email'] = $this->lead_model->getLeadTemplates($leadID,0);
			$data['lead_templates_email_text'] = $this->lead_model->getLeadTemplates($leadID,1);
			$data['lead_templates_linkedin'] = $this->lead_model->getLeadTemplates($leadID,3);*/
			$data['stages'] = $this->lead_model->getLeadTemplatesStages($leadID);
			$data['count_bank_template'] = $this->general_model->getCountTemplateBYLead($leadID);
		}
		
		$data['s'] = $s;
		$data['acquisition'] = $this->acquisition_model->getData($leadID);
		$data['categoryList'] = $this->lead_model->getLeadCategoryList($leadID);
		/*$data['category_list'] = $this->customer_model->categoryList(0);*/
		$data['category_list'] = $this->customer_model->getCategoryBySector(21);
		$data['lead_data'] = $this->lead_model->getLeadData($leadID);
		$data['lead_id'] = $leadID;
		$this->layout->title_for_layout = 'Predefined Messages';
		$this->layout->layout='opportunity';
		$this->layout->render('user/lead_templates',$data);
	}
	
	function delete_campaign(){
		$data = array('d'=>0);
		$request_body = file_get_contents('php://input');
		$body = json_decode($request_body,true);
		if(count($body) > 0){
			$data['d'] = $this->lead_model->deleteCampaign($body['id']);
		}
		echo json_encode($data);
		die;
	}
	
	function resume_campaign(){
		$data = array('resume_email_campaign'=>array(),'resume_linkedin_campaign'=>array());
		$getEmailCampaignList = $this->lead_model->getCampaign(0,1);
		$getLinkedinCampaignList = $this->lead_model->getCampaign(0,2);
		$getTelephoneCampaignList = $this->lead_model->getCampaign(0,3);
		$data['resume_email_campaign'] = $getEmailCampaignList;
		$data['resume_linkedin_campaign'] = $getLinkedinCampaignList;
		$data['resume_telephone_campaign'] = $getTelephoneCampaignList;
		$file = "user/campaign";
		$this->layout->title_for_layout = 'Campaign Resume';
		$this->layout->layout='outsource';
		$this->layout->render('user/campaign',$data);
	}
	
	function telephone_auto_campaign(){
		$data = array('campaign_data'=>array());
		if(isset($_POST) && count($_POST)>0){
			$campaign_data = $this->input->post();	
			switch($campaign_data['setup']){
				case 'resume':
					$personList = array();
					$company = array();
					$emailList = array();	
					$ids = array();
					$getCampaign = $this->lead_model->getCampaign($campaign_data['campaign_id'],3);
					if(count($getCampaign) > 0){
						if(isset($getCampaign['campaign']) && count($getCampaign['campaign']) > 0){
							$campaign_data = $getCampaign['campaign'];
							$list = array();
							$leadID = $campaign_data->lead_id;
							$signalList = array();
							if(isset($getCampaign['list']) && count($getCampaign['list']) > 0){
								$list = $getCampaign['list'];
								foreach($list as $person){			
									$emailList[] = $person->address;
									$personList[] = $person->person_name;
									$company[] = $person->company;
									$ids[] = $person->id;
								}
							}
							$user_id = $campaign_data->user_id;
							$campaign_date = $campaign_data->start_date;
							$campaign_data->campaign_id = $campaign_data->id;
							$campaign_data->mail_start = 0;
							$campaign_data->campaign_date = $campaign_date;
							$campaign_data->user_id = $user_id;
							$campaign_data->contact_form = 0;
							$campaign_data->contact_list = $list;
							$data['campaign_data'] = (array)$campaign_data;	
						}
					}
				break;
				case 'implementation':					
					$personList = array();
					$company = array();
					$emailList = array();	
					$ids = array();
					if(isset($campaign_data['person_list'])){
						try{
							$personList = json_decode($campaign_data['person_list']);
						}catch(Exception $e){
							
						}
					}
					if(isset($campaign_data['company_list'])){
						try{
							$company = json_decode($campaign_data['company_list']);
						}catch(Exception $e){
							
						}
					}
					if(isset($campaign_data['email_list'])){
						try{
							$emailList = json_decode($campaign_data['email_list']);
						}catch(Exception $e){
							
						}
					}	
					if(isset($campaign_data['ids_list'])){
						try{
							$ids = json_decode($campaign_data['ids_list']);
						}catch(Exception $e){
							
						}
					}
					$user_id = $this->session->userdata['id'];
					$campaign_date = date("Y-m-d H:i:s");
					$contactForm = 0;
					if(isset($campaign_data['contact_from']) && $campaign_data['contact_from']>0){
						$contactForm = $campaign_data['contact_from'];
					}	
					$userEmailList = array();					
					$campaign_data['contact_from'] = $contactForm;	
					$getLeadData = $this->lead_model->getLeadDataWithOptions($campaign_data['lead_id'],'serial_number');
					$sType = 3;
					$templateID = 0;
					if(isset($_POST['template_id']) && $_POST['template_id'] > 0){
						$templateID = $_POST['template_id'];
					}
					$campaign_id = $this->lead_model->insertCampaign(array("lead_id"=>$campaign_data['lead_id'],"lead_name"=>$campaign_data['lead_name'],"campaign_type"=>$sType,'activity_type'=>$campaign_data['activity_type'],"template_file"=>$campaign_data['template_file'],"user_id"=>$campaign_data['user_id'],"subject"=>$campaign_data['subject'],"body"=>$campaign_data['email_message'],"start_date"=>$campaign_date,"contact_form"=>$contactForm,'template_id'=>$templateID));
					if($campaign_id>0){	
						
						$campaign_data['campaign_id'] = $campaign_id;
						$serialNumber = 0;
						if(count($getLeadData) > 0){
							$serialNumber = $getLeadData->serial_number;
						}
						$campaign_data['mail_start'] = 0;
						$campaign_data['campaign_date'] = $campaign_date;
						$campaign_data['user_id'] = $user_id;
						if(count($emailList)>0){
							$insertCampaignBatch = array();
							for($i=0;$i<count($emailList);$i++){
							   if(trim($emailList[$i]) != "" && trim($emailList[$i])!=","){
								   $userEmailList[] = trim($ids[$i]);
								   $insertCampaignBatch[] = array("campaign_id"=>$campaign_id,"person_name"=>trim($personList[$i]),"company"=>trim($company[$i]),"address"=>trim($emailList[$i]),'contact_id'=>$ids[$i],'open'=>0);
							   }						   
							}
							$this->lead_model->insertCampaignBatchList($insertCampaignBatch);
						}
					}
					$getAllContactsWithList = array();
					if(count($userEmailList) > 0){
						$getAllContactsWithList = $this->lead_model->findContactsWithAllTelephoneinCampaignList($userEmailList,$campaign_id);
					}
					$campaign_data['contact_list'] = $getAllContactsWithList;
					$data['campaign_data'] = $campaign_data;
					break;
			}
		}
		$this->layout->title_for_layout = 'Telephone Campaign';
		$this->layout->layout='outsource';
		$this->layout->render('user/telephone_campaign',$data);
	}
	
	function linkedin_auto_campaign(){
		$data = array('campaign_data'=>array());
		if(isset($_POST) && count($_POST)>0){
			$campaign_data = $this->input->post();	
			switch($campaign_data['setup']){
				case 'resume':
					$personList = array();
					$company = array();
					$emailList = array();	
					$ids = array();
					$getCampaign = $this->lead_model->getCampaign($campaign_data['campaign_id'],2);
					if(count($getCampaign) > 0){
						if(isset($getCampaign['campaign']) && count($getCampaign['campaign']) > 0){
							$campaign_data = $getCampaign['campaign'];
							$list = array();
							$leadID = $campaign_data->lead_id;
							$signalList = array();
							if(isset($getCampaign['list']) && count($getCampaign['list']) > 0){
								$list = $getCampaign['list'];
								foreach($list as $person){			
									$emailList[] = $person->address;
									$personList[] = $person->person_name;
									$company[] = $person->company;
									$ids[] = $person->id;
								}
							}
							$user_id = $campaign_data->user_id;
							$campaign_date = $campaign_data->start_date;
							$campaign_data->campaign_id = $campaign_data->id;
							$campaign_data->mail_start = 0;
							$campaign_data->campaign_date = $campaign_date;
							$campaign_data->user_id = $user_id;
							$campaign_data->contact_form = 0;
							$campaign_data->contact_list = $list;
							$data['campaign_data'] = (array)$campaign_data;	
						}
					}
				break;
				case 'implementation':					
					$personList = array();
					$company = array();
					$emailList = array();	
					$ids = array();
					if(isset($campaign_data['person_list'])){
						try{
							$personList = json_decode($campaign_data['person_list']);
						}catch(Exception $e){
							
						}
					}
					if(isset($campaign_data['company_list'])){
						try{
							$company = json_decode($campaign_data['company_list']);
						}catch(Exception $e){
							
						}
					}
					if(isset($campaign_data['email_list'])){
						try{
							$emailList = json_decode($campaign_data['email_list']);
						}catch(Exception $e){
							
						}
					}	
					if(isset($campaign_data['ids_list'])){
						try{
							$ids = json_decode($campaign_data['ids_list']);
						}catch(Exception $e){
							
						}
					}
					$user_id = $this->session->userdata['id'];
					$campaign_date = date("Y-m-d H:i:s");
					$contactForm = 0;
					if(isset($campaign_data['contact_from']) && $campaign_data['contact_from']>0){
						$contactForm = $campaign_data['contact_from'];
					}	
					$userEmailList = array();					
					$campaign_data['contact_from'] = $contactForm;	
					$getLeadData = $this->lead_model->getLeadDataWithOptions($campaign_data['lead_id'],'serial_number');
					$sType = 2;
					$campaign_id = $this->lead_model->insertCampaign(array("lead_id"=>$campaign_data['lead_id'],"lead_name"=>$campaign_data['lead_name'],"campaign_type"=>$sType,'activity_type'=>$campaign_data['activity_type'],"template_file"=>$campaign_data['template_file'],"user_id"=>$campaign_data['user_id'],"subject"=>$campaign_data['subject'],"body"=>$campaign_data['email_message'],"start_date"=>$campaign_date,"contact_form"=>$contactForm));
					if($campaign_id>0){	
						
						$campaign_data['campaign_id'] = $campaign_id;
						$serialNumber = 0;
						if(count($getLeadData) > 0){
							$serialNumber = $getLeadData->serial_number;
						}
						$campaign_data['mail_start'] = 0;
						$campaign_data['campaign_date'] = $campaign_date;
						$campaign_data['user_id'] = $user_id;
						if(count($emailList)>0){
							$insertCampaignBatch = array();
							for($i=0;$i<count($emailList);$i++){
							   if(trim($emailList[$i]) != "" && trim($emailList[$i])!=","){
								   $userEmailList[] = trim($ids[$i]);
								   $insertCampaignBatch[] = array("campaign_id"=>$campaign_id,"person_name"=>trim($personList[$i]),"company"=>trim($company[$i]),"address"=>trim($emailList[$i]),'contact_id'=>$ids[$i],'open'=>0);
							   }						   
							}
							$this->lead_model->insertCampaignBatchList($insertCampaignBatch);
						}
					}
					$getAllContactsWithList = array();
					if(count($userEmailList) > 0){
						$getAllContactsWithList = $this->lead_model->findContactsWithAllLinkedinCampaignList($userEmailList,$campaign_id);
					}
					$campaign_data['contact_list'] = $getAllContactsWithList;
					$data['campaign_data'] = $campaign_data;
					break;
			}
		}
		$this->layout->title_for_layout = 'Linkedin Campaign';
		$this->layout->layout='outsource';
		$this->layout->render('user/linkedin_campaign',$data);
	}
	
	function update_campaign_message(){
		$data = 0;
		if(isset($_POST) && count($_POST) > 0){
			$campaignID = $this->input->post('campaign_id');
			$message = $this->input->post('m');
			$this->load->model('lead_model');
			$data = $this->lead_model->updateCampaign($campaignID,array('body'=>$message));
			if($data > 0){
				$getCampaignData = $this->lead_model->getCampaignData($campaignID);
				if($getCampaignData->template_id > 0){
					$this->load->model('general_model');
					$data = $this->general_model->updateTemplate(array('template_html'=>$message),$getCampaignData->template_id);
				}
			}
		}		
		echo $data;
	}
	
	function delete_user_from_campaign(){
		$data = 0;
		if(isset($_POST) && count($_POST) > 0){
			$campaignID = $this->input->post('campaign_id');
			$campaignListID = $this->input->post('list_id');
			$this->load->model('lead_model');
			$data = $this->lead_model->delete_from_campaign_list_by_id_and_campaign_id($campaignID,$campaignListID);
		}		
		echo $data;
	}
	
	function email_campaign(){
		$data = array('campaign_data'=>array());
		if(isset($_POST) && count($_POST)>0){
			$campaign_data = $this->input->post();	
			switch($campaign_data['setup']){
				case 'resume':
					$getCampaign = $this->lead_model->getCampaign($campaign_data['campaign_id'],0);
					if(count($getCampaign) > 0){
						if(isset($getCampaign['campaign']) && count($getCampaign['campaign']) > 0){
							$campaign_data = $getCampaign['campaign'];
							$list = array();
							$leadID = $campaign_data->lead_id;
							$signalList = array();
							if(isset($getCampaign['list']) && count($getCampaign['list']) > 0){
								$list = $getCampaign['list'];
								foreach($list as $person){			
									$signalList[] = array($person->address,$person->email_status);
									$emailList[] = $person->address;
									$personList[] = $person->person_name;
									$companyList[] = $person->company;
								}								
							}
							
							$user_id = $campaign_data->user_id;
							$campaign_date = $campaign_data->start_date;
							$campaign_data->campaign_id = $campaign_data->id;
							$campaign_data->mail_start = 0;
							$campaign_data->campaign_date = $campaign_date;
							$campaign_data->user_id = $user_id;
							if($campaign_data->contact_form >0 && count($emailList) > 0){
								/*User List*/
								$campaign_data->user_list = $this->lead_model->findContactsWithAllEmailsWithSignal($emailList);
							} else {
								$campaign_data->user_list = array();
							}
							
							$getAllContactsWithList = array();
							if(count($emailList) > 0){
								$getAllContactsWithList = $this->lead_model->findContactsWithAllEmails($emailList);
							}
							$campaign_data->contact_list = $getAllContactsWithList;
							$campaign_data->person_list = json_encode($personList);
							$campaign_data->email_list = json_encode($emailList);
							$campaign_data->company_list = json_encode($companyList);
							$campaign_data->signal_list = json_encode($signalList);
							$campaign_data->email_message = $campaign_data->body;
							$campaign_data->send_account_type = $campaign_data->activity_type;
							$data['campaign_data'] = (array)$campaign_data;	
						}
					}
				break;
				case 'implementation':
					/*start_campaign*/							
					$personList = array();
					$company = array();
					$emailList = array();	
					$ids = array();
					if(isset($campaign_data['person_list'])){
						try{
							$personList = json_decode($campaign_data['person_list']);
						}catch(Exception $e){
							
						}
					}
					if(isset($campaign_data['company_list'])){
						try{
							$company = json_decode($campaign_data['company_list']);
						}catch(Exception $e){
							
						}
					}
					if(isset($campaign_data['email_list'])){
						try{
							$emailList = json_decode($campaign_data['email_list']);
						}catch(Exception $e){
							
						}
					}	
					if(isset($campaign_data['ids_list'])){
						try{
							$ids = json_decode($campaign_data['ids_list']);
						}catch(Exception $e){
							
						}
					}
					$user_id = $this->session->userdata['id'];
					$campaign_date = date("Y-m-d H:i:s");
					$contactForm = 0;
					if(isset($campaign_data['contact_from']) && $campaign_data['contact_from']>0){
						$contactForm = $campaign_data['contact_from'];
					}	
					$userEmailList = array();					
					$campaign_data['contact_from'] = $contactForm;	
					$getLeadData = $this->lead_model->getLeadDataWithOptions($campaign_data['lead_id'],'serial_number');
					$sType = 2;
					if(isset($campaign_data['send_account_type']) && ($campaign_data['send_account_type'] != 5)){
						$sType = 1;
					}
					$campaign_id = $this->lead_model->insertCampaign(array("lead_id"=>$campaign_data['lead_id'],"lead_name"=>$campaign_data['lead_name'],"campaign_type"=>$sType,'activity_type'=>$campaign_data['activity_type'],"template_file"=>$campaign_data['template_file'],"user_id"=>$campaign_data['user_id'],"subject"=>$campaign_data['subject'],"body"=>$campaign_data['email_message'],"start_date"=>$campaign_date,"contact_form"=>$contactForm));
					if($campaign_id>0){	
						$campaign_data['campaign_id'] = $campaign_id;
						$serialNumber = 0;
						if(count($getLeadData) > 0){
							$serialNumber = $getLeadData->serial_number;
						}
						$campaign_data['tracking_code'] = $this->encode($serialNumber."_".$campaign_data['lead_id']."_".$campaign_id);
						if($campaign_data['tracking_code'] != ""){
							$this->lead_model->updateCampaign($campaign_id,array('tracking_code'=>$campaign_data['tracking_code']));
						}						
						$campaign_data['mail_start'] = 0;
						$campaign_data['campaign_date'] = $campaign_date;
						$campaign_data['user_id'] = $user_id;
						if(count($emailList)>0){
							$insertCampaignBatch = array();
							for($i=0;$i<count($emailList);$i++){
							   if(trim($emailList[$i]) != "" && trim($emailList[$i])!=","){
								   $userEmailList[] = trim($emailList[$i]);
								   $insertCampaignBatch[] = array("campaign_id"=>$campaign_id,"person_name"=>trim($personList[$i]),"company"=>trim($company[$i]),"address"=>trim($emailList[$i]),'contact_id'=>$ids[$i],'open'=>0);
							   }						   
							}
							$this->lead_model->insertCampaignBatchList($insertCampaignBatch);
						}
					}
					
					if($contactForm>0){
						/*User List*/
						
						$campaign_data['user_list'] = $this->lead_model->findContactsWithAllEmails($userEmailList);
					} else {
						$campaign_data['user_list'] = array();
					}
					$getAllContactsWithList = array();
					if(count($userEmailList) > 0){
						$getAllContactsWithList = $this->lead_model->findContactsWithAllEmails($userEmailList);
					}
					$campaign_data['contact_list'] = $getAllContactsWithList;
					$data['campaign_data'] = $campaign_data;	
				break;
				case 'start':
				break;
				case 'final_step':
				break;
				case 'ignore':
				break;
				case 'send':
				break;
			}
		}
		$this->layout->title_for_layout = 'Email Campaign';
		$this->layout->layout='outsource';
		$this->layout->render('user/email_campaign',$data);
	}
	
	function delete_lead_template(){
		$data = 0;
		if(isset($_POST['id']) && (int)$_POST['id']>0){
			$data = $this->lead_model->deleteLeadTemplate($_POST['id']);
		}
		echo $data;
	}
	
	function update_status_lead_template(){
		$data = 0;
		if(isset($_POST['id']) && (int)$_POST['id']>0){
			$data = $this->lead_model->updateLeadTemplate($this->input->post('id'),array('status'=>$this->input->post('status')));
		}
		echo $data;
	}
	
	function find_message_template_stage(){
		$data= array();
		if($this->input->post('st')!="" && (int)$this->input->post('lead')>0){
			$data = $this->general_model->checkLeadTemplateStage($this->input->post('st'),$this->input->post('lead'));
		}
		echo json_encode($data);
	}
	
	function saveTemplateScript(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$stage = $this->input->post('stage');
			if(!empty($stage)){
				if((int)$this->input->post('type')==1){
					if($this->input->post('lead')>0){
						$checkTemplate = $this->general_model->checkLeadTemplateStage($this->input->post('stage'),$this->input->post('lead'));
						if(count($checkTemplate)>0){
							$data = $this->general_model->updateTemplate(array('template_html'=>$_POST['template'],'subject'=>$_POST['subject'],'type'=>'2','template_name'=>$this->input->post('stage'),'stage'=>$this->input->post('stage')),$checkTemplate->id);
							$user_history = array('lead_id'=>$this->input->post('lead'),'user_id'=>$this->session->userdata['id'],'message'=>"Template updated in lead bank",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);
						} else {
							$data = $this->general_model->insertTemplate(array('template_html'=>$_POST['template'],'subject'=>$_POST['subject'],'type'=>'2','template_name'=>$this->input->post('stage'),'stage'=>$this->input->post('stage'),'lead_id'=>$this->input->post('lead')));
							$user_history = array('lead_id'=>$this->input->post('lead'),'user_id'=>$this->session->userdata['id'],'message'=>"Save template in lead bank",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);
						}						
					}
				} else {
					$checkTemplate = $this->general_model->checkBankTemplateStage($this->input->post('stage'));
					if(count($checkTemplate)>0){
						$data = $this->general_model->updateBankTemplate(array('template_html'=>$_POST['template'],'subject'=>$_POST['subject'],'type'=>'2','template_name'=>$this->input->post('stage'),'stage'=>$this->input->post('stage')),$checkTemplate->id);
						$user_history = array('lead_id'=>0,'user_id'=>$this->session->userdata['id'],'message'=>"Template updated in skeleton",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
					} else {
						$data = $this->general_model->insertBankTemplate(array('template_html'=>$_POST['template'],'subject'=>$_POST['subject'],'type'=>'2','template_name'=>$this->input->post('stage'),'stage'=>$this->input->post('stage')));
						$user_history = array('lead_id'=>0,'user_id'=>$this->session->userdata['id'],'message'=>"Save template in skeleton",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
					}
					
				}
			}
		}
		echo $data;
		die;
	}
	
	public function save_new_template(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			if(isset($_POST['temp']) && !empty($_POST['temp'])){
				if($this->input->post('activity_type')=="208"){
					$data = $this->general_model->insertBankTemplate(array('template_html'=>$_POST['temp'],'subject'=>$_POST['subject'],'type'=>'2','template_name'=>$_POST['name'],'template_type'=>$_POST['template_type'],'template_stage'=>$_POST['template_stage']));
					$user_history = array('lead_id'=>0,'user_id'=>$this->session->userdata['id'],'message'=>"Create predefined template",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
				} else if($this->input->post('activity_type')=="7"){
					$data = $this->general_model->insertTemplate(array('template_html'=>$_POST['temp'],'subject'=>$_POST['subject'],'type'=>'2','template_name'=>$_POST['name'],'lead_id'=>$this->input->post('lead_id'),'template_type'=>$_POST['template_type'],'template_stage'=>$_POST['template_stage']));
					$user_history = array('lead_id'=>$this->input->post('lead_id'),'user_id'=>$this->session->userdata['id'],'message'=>"Create predefined template",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
				}
			}
		} 
		echo $data;
		die;
	}
	
	public function update_template(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			if(isset($_POST['temp']) && !empty($_POST['temp'])){
				if($this->input->post('activity_type')=="208"){
					$data = $this->general_model->updateBankTemplate(array('template_html'=>$_POST['temp'],'subject'=>$_POST['subject'],'template_name'=>$_POST['name'],'template_type'=>$_POST['template_type'],'template_stage'=>$_POST['template_stage']),$_POST['id']);
					if($data==0){
						$data = $_POST['id'];
					}
					$user_history = array('lead_id'=>0,'user_id'=>$this->session->userdata['id'],'message'=>"Update predefined template",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
				} else {
					$data = $this->general_model->updateTemplate(array('template_html'=>$_POST['temp'],'subject'=>$_POST['subject'],'template_name'=>$_POST['name'],'template_type'=>$_POST['template_type'],'template_stage'=>$_POST['template_stage']),$_POST['id']);
					$user_history = array('lead_id'=>$this->input->post('lead_id'),'user_id'=>$this->session->userdata['id'],'message'=>"Update predefined template",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
				}
			}
		}
		echo $data;
		die;
	}
	
	public function delete_predefined_template(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			if(isset($_POST['t']) && $_POST['t'] == 4){
				$data = $this->general_model->delete_skeleton_template($_POST['id']);
			} else {				
				$data = $this->general_model->delete_template($_POST['id']);
			}
		}
		echo $data;
		die;
	}
	
	public function html2txt($document){ 
		$search = array('@<script[^>]*?>.*?</script>@si','@<[\/\!]*?[^<>]*?>@si',  			   '@<style[^>]*?>.*?</style>@siU',   '@<![\s\S]*?--[ \t\n\r]*>@'); 
		$text = preg_replace($search, '<br/>', $document); 
		return $text; 
	}
	
	function campaign_process(){
		$data = array('list'=>array(),'lead'=>0);
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('lead');
			if($leadID > 0){
				$data['lead'] = $leadID;
				$data['list'] = $this->lead_model->findProcessCampaignList($leadID);
			}
		}
		echo json_encode($data);die;
	}
	
	public function save_template_file(){
		$data = "";
		if(isset($_POST) && count($_POST)>0){
			if(isset($_POST['temp']) && !empty($_POST['temp']) && isset($_POST['lead_id']) && (int)$_POST['lead_id']>0){				
				$template = $this->input->post('temp');
				$lead_id = $this->input->post('lead_id');
				$urlName ="";
				$acquisition = $this->acquisition_model->getData($lead_id);
				$categoryList = $this->lead_model->getLeadCategoryList($lead_id);
				$category_list = $this->customer_model->categoryList(0);
				$lead_data = $this->lead_model->getLeadData($lead_id);
				if(count($categoryList) > 0){
					foreach($categoryList as $cat){
						if($cat->main_category == 1){
							$urlName ='/catalog?'.md5($lead_data->serial_number);
						}
					}
				}
				
				if(!empty($urlName)){
					$urlName = "https://synpat.com".$urlName;
				}
				$template =  str_replace('link-data-href=""',"href='".$urlName."'",$template);
				$template =  str_replace('link-data-href-another=""',"href='".$urlName."'",$template);
				$fileName = $lead_id.time().".html";
				if($_POST['type'] == 0){
					$fileName = $lead_data->serial_number.".html";
				}
				$filePath = "/var/www/synpat/synpat/invite/".$fileName;
				/*if(file_exists($filePath)){
					unlink($filePath);
				}*/
				$fh = fopen($filePath,"w+");
				fwrite($fh,$template);
				fclose($fh);
				if(isset($_POST['t']) && $_POST['t'] == 0){
					/*Check template stage and template type*/
					$this->lead_model->deleteLeadTemplateByStageAndType($_POST['template_type'],$_POST['template_stage']);
					$templateID = $this->input->post('template_id');
					$data = $this->lead_model->saveLeadTemplate(array('name'=>$_POST['name'],"lead_id"=>$lead_id ,"file_name"=>"https://synpat.com/invite/".$fileName,'subject'=>$_POST['subject'],'type'=>$_POST['type'],'template_type'=>$_POST['template_type'],'template_stage'=>$_POST['template_stage'],'template_id'=>$templateID));	
					$user_history = array('lead_id'=>$lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"Create campaign template in lead",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
				} else if(!isset($_POST['t'])){
					$data = 1;
					$user_history = array('lead_id'=>$lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"update invitation template",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
				}
			}			
		}
		echo $data;
		die;
	}
	
	
	
	
	function leadLogTime(){
		$timeLine="";$timehours="";
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('l');
			$getMyLogTime = array('all_work'=>array());
			if((int)$leadID>0){
				$getMyLogTime = $this->user_model->getMyLogTimeWithLead($this->session->userdata['id'],$leadID);	
				$getLeadDetail = $this->lead_model->getLeadData($leadID);
			}?>
			
			<div class="row"> <div class="col-lg-12"> <div> <b><big>Time Flow</big></b> </div> <div class="timeline-wrapper-inner" style='height:500px;width:73%;float:left'> <?php 
										
										if(count($getMyLogTime['all_work'])>0){
									?> <table id="timelineDataTable" class='table dataTable no-footer' style='width:100%!important'> <thead> <tr> <th>Date</th> <th>Start</th> <th>End</th> <th>Duration</th> <th>Leads</th> <th>Adjustments</th> <th>Total Time</th> <th>Comment</th> </tr> </thead> <tbody> <?php
										for($i=0;$i<count($getMyLogTime['all_work']);$i++){
									?> <tr id="<?php echo $getMyLogTime['all_work'][$i]->id;?>"> <td><?php echo date('Y-m-d',strtotime($getMyLogTime['all_work'][$i]->login_date))?></td> <td><?php echo date('H:i',strtotime($getMyLogTime['all_work'][$i]->login_date));?></td> <td><?php echo date('H:i',strtotime($getMyLogTime['all_work'][$i]->logout_date));?></td> <td><?php echo $getMyLogTime['all_work'][$i]->hrsWorked?></td> <td> <?php echo $getLeadDetail->lead_name;?> </td> <td><select name="actualHrs<?php echo $getMyLogTime['all_work'][$i]->id;?>" id="actualHrs<?php echo $getMyLogTime['all_work'][$i]->id;?>" style='width:73px' onchange="saveFlagUpdate(<?php echo $getMyLogTime['all_work'][$i]->id;?>)"> <option value="">-- Adjust. --</option> <option value="-00:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-00:15")?'SELECTED="SELECTED"':'';?>>-00:15</option> <option value="-00:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-00:30")?'SELECTED="SELECTED"':'';?>>-00:30</option> <option value="-00:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-00:45")?'SELECTED="SELECTED"':'';?>>-00:45</option> <option value="-01:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-01:00")?'SELECTED="SELECTED"':'';?>>-01:00</option> <option value="-01:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-01:15")?'SELECTED="SELECTED"':'';?>>-01:15</option> <option value="-01:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-01:30")?'SELECTED="SELECTED"':'';?>>-01:30</option> <option value="-01:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-01:45")?'SELECTED="SELECTED"':'';?>>-01:45</option> <option value="-02:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-02:00")?'SELECTED="SELECTED"':'';?>>-02:00</option> <option value="-02:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-02:15")?'SELECTED="SELECTED"':'';?>>-02:15</option> <option value="-02:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-02:30")?'SELECTED="SELECTED"':'';?>>-02:30</option> <option value="-02:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-02:45")?'SELECTED="SELECTED"':'';?>>-02:45</option> <option value="-03:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-03:00")?'SELECTED="SELECTED"':'';?>>-03:00</option> <option value="-03:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-03:15")?'SELECTED="SELECTED"':'';?>>-03:15</option> <option value="-03:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-03:30")?'SELECTED="SELECTED"':'';?>>-03:30</option> <option value="-03:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-03:45")?'SELECTED="SELECTED"':'';?>>-03:45</option> <option value="-04:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-04:00")?'SELECTED="SELECTED"':'';?>>-04:00</option> <option value="-04:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-04:15")?'SELECTED="SELECTED"':'';?>>-04:15</option> <option value="-04:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-04:30")?'SELECTED="SELECTED"':'';?>>-04:30</option> <option value="-04:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-04:45")?'SELECTED="SELECTED"':'';?>>-04:45</option> <option value="-05:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="-05:00")?'SELECTED="SELECTED"':'';?>>-05:00</option> <option value="00:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="00:15")?'SELECTED="SELECTED"':'';?>>00:15</option> <option value="00:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="0:30")?'SELECTED="SELECTED"':'';?>>00:30</option> <option value="00:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="0:45")?'SELECTED="SELECTED"':'';?>>00:45</option> <option value="01:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="01:00")?'SELECTED="SELECTED"':'';?>>01:00</option> <option value="01:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="01:15")?'SELECTED="SELECTED"':'';?>>01:15</option> <option value="01:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="01:30")?'SELECTED="SELECTED"':'';?>>01:30</option> <option value="01:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="01:45")?'SELECTED="SELECTED"':'';?>>01:45</option> <option value="02:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="2:00")?'SELECTED="SELECTED"':'';?>>02:00</option> <option value="02:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="02:15")?'SELECTED="SELECTED"':'';?>>02:15</option> <option value="02:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="02:30")?'SELECTED="SELECTED"':'';?>>02:30</option> <option value="02:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="02:45")?'SELECTED="SELECTED"':'';?>>02:45</option> <option value="03:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="03:00")?'SELECTED="SELECTED"':'';?>>03:00</option> <option value="03:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="03:15")?'SELECTED="SELECTED"':'';?>>03:15</option> <option value="03:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="03:30")?'SELECTED="SELECTED"':'';?>>03:30</option> <option value="03:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="03:45")?'SELECTED="SELECTED"':'';?>>03:45</option> <option value="04:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="04:00")?'SELECTED="SELECTED"':'';?>>04:00</option> <option value="04:15" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="04:15")?'SELECTED="SELECTED"':'';?>>04:15</option> <option value="04:30" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="04:30")?'SELECTED="SELECTED"':'';?>>04:30</option> <option value="04:45" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="04:45")?'SELECTED="SELECTED"':'';?>>04:45</option> <option value="05:00" <?php echo ($getMyLogTime['all_work'][$i]->actual_hrs=="05:00")?'SELECTED="SELECTED"':'';?>>05:00</option> </select> </td> <td> <?php
													$duration = $getMyLogTime['all_work'][$i]->hrsWorked;
													$adjustedlHrs = $getMyLogTime['all_work'][$i]->actual_hrs;
													if(!empty($adjustedlHrs)){
														$adjustedlHrs = $adjustedlHrs.":00";
													}
													$totalHrs = $duration;
													if($duration!='' && $duration!='00:00:00'){
														$d = strtotime($duration);
														$lengthOfAdjustedHrs = strlen($adjustedlHrs);
														if($lengthOfAdjustedHrs==9){
															list($h,$m,$s) = explode(':',$adjustedlHrs);
															$totalHrs = date('H:i:s',strtotime("-".$h." hour  -".$m." minutes",$d));
														} else if($lengthOfAdjustedHrs==8){
															list($h,$m,$s) = explode(':',$adjustedlHrs);
															$totalHrs = date('H:i:s',strtotime("+".$h." hour  +".$m." minutes",$d));
														}
													} else{
														$lengthOfAdjustedHrs = strlen($adjustedlHrs);
														if($lengthOfAdjustedHrs==9 || $lengthOfAdjustedHrs==8){
															$totalHrs = $adjustedlHrs;
														}
													}
													echo $totalHrs;
												?> </td> <td style='width:430px'><textarea class='form-control' onchange="saveFlagUpdate(<?php echo $getMyLogTime['all_work'][$i]->id;?>)" placeholder="Comment" name="comment<?php echo $getMyLogTime['all_work'][$i]->id;?>" id="comment<?php echo $getMyLogTime['all_work'][$i]->id;?>" style='width:400px;height:25px;border:0px'><?php echo $getMyLogTime['all_work'][$i]->comment?></textarea></td> </tr> <?php
										}
									?> </tbody> </table> <script>var timelineDataTable=$("#timelineDataTable").DataTable({autoWidth:true,paging:false,searching:false,destroy:true,oLanguage: {sEmptyTable:"No record found!"},scrollY:400,order:[[0,"desc"]]});</script> <?php
										}
									?> <div class="col-lg-12" style='border-top:1px solid #d1c8c8;width:99%'></div> </div> <div class='pull-right' style="width:25%;margin-top:8px"> <div class="row"> <div class="col-lg-12" style="width:285px"> <select class='form-control' onchange="findLeadHrs(jQuery(this))"> <option>--Select Lead--</option> <?php 
														if(count($getMyLogTime['allLeadsWorked'])>0){
															foreach($getMyLogTime['allLeadsWorked'] as $lead){
													?> <option value="<?php echo $lead->lead_id?>"><?php echo $lead->lead_name?></option> <?php
															}
														}
													?> </select>
									<?php $timehours  = $this->user_model->findFullHoursForLead($leadID,$this->session->userdata['id']);?>
													<label class='show mrg10T'><strong>Total Time Spent in this Lead: <?php echo $timehours;?></strong></label> </div> <div class="col-lg-12 mrg10T"> <label><strong>Total time spent in current month: <?php echo ($getMyLogTime['totalHoursCurrent']->totalHrsWorked!=null)?$getMyLogTime['totalHoursCurrent']->totalHrsWorked:'';?></strong></label> </div> <div class="col-lg-12 mrg10T"> <label><strong>Total time spend in previous month: <?php echo ($getMyLogTime['totalHours']->totalHrsWorked!=null)?$getMyLogTime['totalHours']->totalHrsWorked:'';?></strong></label> </div> </div> </div> </div> </div> <div class="mrg25T"> <b><big>Activity Flow</big></b> </div> <div id="mytimeline" class="mrg10T"></div>
								<?php 
									$getTimeLine = $this->user_model->getAllUserHistory($this->session->userdata['id'],$leadID,0);
								?>
								<script>__timelineD =[];</script>
								<?php 
								$checkURIController = "leads";
							if(count($getTimeLine)>0){
								foreach($getTimeLine as $timeline){	
									$label = "";
									$colorClass="";
									if($checkURIController=="leads"){
										$label = "Leads";
										$colorClass= "bg-yellow";
									} else if($checkURIController=="opportunity"){
										$label =  "Opportunity";
										$colorClass= "label-info";
									} else {
										if($timeline->opportunity_id==0){
											$label =  "Leads";
											$colorClass= "bg-yellow";
										} else {
											$label =  "Opportunity";
											$colorClass= "label-info";
										}
									}
									
									if(isset($timeline->leadType)){
										switch($timeline->leadType){
											case 'Litigation':
												$colorClass = "bg-yellow";
											break;
											
											case 'Market':
												$colorClass = "bg-green";
											break;
											
											case 'General':
												$colorClass = "label-info";
											break;
											
											case 'SEP':
												$colorClass = "bg-warning";
											break;
										}
										$label = (!empty($timeline->lead_name))?$timeline->lead_name:$timeline->plantiffs_name;
									}
								
						?>
<script>__timelineD.push({'start':new Date('<?php echo $timeline->create_date?>'),'content':'<span class="tl-label bs-label <?php echo $colorClass;?>"><?php echo $label;?></span><span class="todo-content"><?php echo $timeline->message;?></span>'});</script>
			<?php 
								}
			?>
			<script>jQuery(document).ready(function(){var items=new vis.DataSet(__timelineD);var container=document.getElementById('mytimeline');var options={maxHeight:'300px',type:'point',selectable:false,showMajorLabels:false,zoomMin:1000*60*60*24,zoomMax:1000*60*60*24*31*3};if(typeof timeline!='string'){timeline.destroy();}timeline=new vis.Timeline(container);timeline.setOptions(options);timeline.setItems(items);timeline.moveTo(new Date(),{animate:true});});</script>
			
			<?php
							}
		}
		die;
	}
	
	
	function updateLogHr(){
		$data="0";
		if(isset($_POST) && count($_POST)>0){
			$aH = $this->input->post('ah');
			$c =(string) $this->input->post('c');
			$id = (int) $this->input->post('i');
			if($id>0){
				$this->user_model->updateLogTimeById($id,array('comment'=>$c,'actual_hrs'=>(string)$aH));	
				$getData  = $this->user_model->getLog($id);			
				$duration = $getData->hrsWorked;
				$adjustedlHrs = $getData->actual_hrs;
				if(!empty($adjustedlHrs)){
					$adjustedlHrs = $adjustedlHrs.":00";
				}
				$data = $duration;
				if($duration!='' && $duration!='00:00:00'){
					$d = strtotime($duration);
					$lengthOfAdjustedHrs = strlen($adjustedlHrs);
					if($lengthOfAdjustedHrs==9){
						list($h,$m,$s) = explode(':',$adjustedlHrs);
						list($hd,$md,$sd) = explode(':',$duration);						
						if(strlen($h)==3){
							$h = $h*-1;
							if($hd>=$h){
								if($md>=$m){
									$data = date('H:i:s',strtotime("-".$h." hour  -".$m." minutes",$d));
								} else {
									$data = "00:00:00";
								}
							} else {
								$data = "00:00:00";
							}
						} else {
							$data = date('H:i:s',strtotime("-".$h." hour  -".$m." minutes",$d));
						}											
					} else if($lengthOfAdjustedHrs==8){
						list($h,$m,$s) = explode(':',$adjustedlHrs);
						$data = date('H:i:s',strtotime("+".$h." hour  +".$m." minutes",$d));
					}
				} else {
					$data = $adjustedlHrs;
				}
			}
		}
		echo  $data;
		die;
	}
	
	
	function search_email($gmailMessageID = null){
		$findThreadData = array();
		if($gmailMessageID!=null){
			$this->load->library('DriveServiceHelper');
			$service = new GmailServiceHelper();
			if(!isset($_SESSION)){
				session_start();
			}
			$checkFromThread = $this->lead_model->findBoxByMessageID($gmailMessageID);
			if(count($checkFromThread)>0){
				redirect('users/own_server_email/'.$checkFromThread[0]->id);
			}
			$googleToken = $_SESSION['another_access_token'];
			if(empty($googleToken)){
				$googleToken = $this->getUserToken();
			}
			$service->setAccessToken($googleToken);
			$findThreadData = $service->findThreadData($gmailMessageID);
		}
		$data['thread_detail'] = $findThreadData;
		$data['type'] = 3;
		$this->layout->title_for_layout = 'Backyard Email Detail';
		$this->layout->layout='email';
		// $this->layout->layout='email';
		$this->layout->render('user/email',$data);
	}
	
	function getEventForUser(){
		$time = new DateTime(date('Y-m-d'));
		$timeMin = $time->format(DateTime::ATOM);
		$time = new DateTime(date('Y-m-d').' 23:00:00');
		$timeMax = $time->format(DateTime::ATOM);
		$todayDate = date('Y-m-d');
		if(isset($_POST) && count($_POST)>0){
			$dateCal = date('Y-m-d',strtotime($this->input->post('p').' day'));
			$todayDate = $dateCal;
			$time = new DateTime($dateCal);
			$timeMin = $time->format(DateTime::ATOM);
			$time = new DateTime($dateCal.' 23:00:00');
			$timeMax = $time->format(DateTime::ATOM);
			$todayDate = $dateCal;
		}
		$this->load->library('DriveServiceHelper');
		$service = new CalendarServiceHelper();
		$calendarList = $service->getCalendarList();
		$eventsAllUsersList = array();
		
		foreach($calendarList as $calendar){
			$loggedInUserEmail = $this->session->userdata['email'];
			if($calendar->id == $loggedInUserEmail){
				$eventList = $service->getEventsList($calendar->id,$timeMin,$timeMax,'startTime');
				foreach($eventList as $event){	
					$eventData = date('Y-m-d',strtotime($event->start->dateTime));
					if($todayDate==$eventData){
						$eventsAllUsersList[] = array('title'=>$event->summary,"htmlLink"=>$event->htmlLink,"hangoutLink"=>$event->hangoutLink,'start'=>$event->start->dateTime);
					}					
				}				
				break;
			}
		}
		echo json_encode(array('date'=>date('D, M d',strtotime($todayDate)),'list'=>$eventsAllUsersList));
		die;
	}
	
	function getServiceAccountCalendar(){
		$time = new DateTime;
		$timeMin = $time->format(DateTime::ATOM);
		$this->load->library('DriveServiceHelper');
		$service = new CalendarServiceHelper();
		/*$colors = $service->getColor();
		$availableColor = array();
		foreach ($colors->getCalendar() as $key => $color) {
		  $availableColor[] = $color->getBackground();
		}*/
		$calendarList = $service->getCalendarList();
		$eventsAllUsersList = array();
		$eventUserAndColor = array();
		foreach($calendarList as $calendar){
			$userID = $calendar->id;
			$_name = explode('@',$userID);
			$userForegroundColor = $calendar->foregroundColor;
			$userBackgroundColor = $calendar->backgroundColor;
			$userTimezone = $calendar->timeZone;
			$userEtag = $calendar->etag;
			$eventList = $service->getEventsList($calendar->id,$timeMin);
			$eventUserAndColor[] = array('user_id'=>$userEtag,'backgroundColor'=>$userBackgroundColor,'color'=>$userForegroundColor,'time_zone'=>$userTimezone,'name'=>$userID);
			foreach($eventList as $event){				
				$allDay = false;/*$allDay = true;*/
				if($event->start->dateTime!=null && $event->end->dateTime!=null){
					$datetime1 = new DateTime($event->start->dateTime);
					$datetime2 = new DateTime($event->end->dateTime);
					$interval = $datetime1->diff($datetime2);
					if($interval->format('%a')>0 || $interval->format('%h')>8){
						$allDay = true;
					} 
					$eventsAllUsersList[] = array('user_id'=>$userEtag,'allDay'=>$allDay,'backgroundColor'=>$userBackgroundColor,'color'=>$userForegroundColor,'textColor'=>$userForegroundColor,"htmlLink"=>$event->htmlLink,'start'=>$event->start->dateTime,'end'=>$event->end->dateTime,'event_id'=>$event->id,'id'=>$event->etag,'title'=>ucfirst($_name[0]).', '.$event->summary.", ".$event->location);
				}
				
			}
		}
		/*$fileName = $_SERVER['DOCUMENT_ROOT'].'/backyardgithub/public/upload/events.json';*/		
		$fileName = $_SERVER['DOCUMENT_ROOT'].'/public/upload/events.json';
		$f = fopen($fileName,"w+");
		$data= json_encode($eventsAllUsersList);
		fwrite($f,$data);
		fclose($f);
		$fileName = $_SERVER['DOCUMENT_ROOT'].'/public/upload/user_event.json';
		/*$fileName = $_SERVER['DOCUMENT_ROOT'].'/backyardgithub/public/upload/user_event.json';*/
		$f = fopen($fileName,"w+");
		$data= json_encode($eventUserAndColor);
		fwrite($f,$data);
		fclose($f);
		die;
	}
	
	function getCalendarEvent(){
		$data = array();
		if(isset($_POST) && isset($_POST['event_id'])){
			$this->load->library('DriveServiceHelper');
			$service = new CalendarServiceHelper();
			$event = $service->getEvent($this->input->post('event_id'));
			if(is_object($event) && isset($event->htmlLink) && !empty($event->htmlLink)){
				$data = array('summary'=>$event->summary,
							  'start_time'=>$event->start->dateTime,
							  'end_time'=>$event->end->dateTime,
							  'attendes'=>$event->attendees,
							  'location'=>$event->location,
							  'description'=>$event->description,
							  'id'=>$event->id);
			}
		}
		echo json_encode($data);
		die;
	}
	
	function company_calendar(){
		$this->layout->title_for_layout = 'Company Calendar';
		$this->layout->layout='calendar';
		$data=array();
		$this->layout->render('user/company_calendar',$data);
	}
	
	function sendImapEmailHtml(){
		$this->layout->title_for_layout = 'Backyard Email Detail';
		$this->layout->layout='email';
		$this->layout->render('user/imap_email');
	}
	
	function email($gmailMessageID = null){
		$findThreadData = array();
		if($gmailMessageID!=null){
			$this->load->library('DriveServiceHelper');
			$service = new GmailServiceHelper();
			if(!isset($_SESSION)){
				session_start();
			}
			$googleToken = $_SESSION['another_access_token'];
			if(empty($googleToken)){
				$googleToken = $this->getUserToken();
			}
			$service->setAccessToken($googleToken);
			$emails = $_SESSION['STARRED'];
			$findIDFlag = 0;
			$message = "";
			/*$gmailMessageID = $this->input->post('thread');	*/
			if(count($emails)>0){
				foreach($emails as $email){
					if($email['message_id'] == $gmailMessageID){
						$findIDFlag = 1;
						$message = $email['content'];
						break;
					}
				}
			}
			if($findIDFlag==0){
				$emails = $_SESSION['INBOX'];
				if(count($emails)>0){
					foreach($emails as $email){
						if($email['message_id'] == $gmailMessageID){
							$findIDFlag = 1;
							$message = $email['content'];
							break;
						}
					}
				}
			}			
			if($findIDFlag==0){
				$emails = $_SESSION['TRASH'];
				if(count($emails)>0){
					foreach($emails as $email){
						if($email['message_id'] == $gmailMessageID){
							$findIDFlag = 1;
							$message = $email['content'];
							break;
						}
					}
				}
			}
			if($findIDFlag==0){
				$emails = $_SESSION['LEAD'];
				if(count($emails)>0){
					foreach($emails as $email){
						if($email['message_id'] == $gmailMessageID){
							$findIDFlag = 1;
							$message = $email['content'];
							break;
						}
					}
				}
			}
			if($findIDFlag==0){
				$emails = $_SESSION['SENT'];
				if(count($emails)>0){
					foreach($emails as $email){
						if($email['message_id'] == $gmailMessageID){
							$findIDFlag = 1;
							$message = $email['content'];
							break;
						}
					}
				}
			}
			$filesAttachment = "";	
			$attachmentArray = array();
			$attachments = array();	
			$content = array();
			if(gettype($message)=="string"){
				$email = $service->findThreadData($gmailMessageID);
				if(count($email)>0){
					$message = $email[0]['content'];
				}
			}
			$findStatus = 0;
			if(is_object($message)>0){
				$threadId= $message->threadId;
				$findStatus = $this->lead_model->findBoxByMessageID($gmailMessageID);
				$messageBody = '';
				$attachmentsConnect = array();
				$parts = $message->getPayload()->getParts();
				$payLoadMimeType =$message->getPayload()->mimeType;
				$header = $message->getPayload()->getHeaders();
				if(count($parts)>0){
					if($parts[0]->mimeType=='text/plain' || $parts[0]->mimeType=='text/html'){
						if(isset($parts[1]) && $parts[1]->mimeType=='text/html'){
							$rawBody = $parts[1]->getBody();
						}  else {
							$rawBody = $parts[0]->getBody();
						}
						$rawData = $rawBody->data;	
						$sanitizedData = strtr($rawData,'-_', '+/');
						$messageBody = base64_decode($sanitizedData);
					} else if($parts[0]->mimeType=="multipart/alternative" || $parts[0]->mimeType=="multipart/related" || $parts[0]->mimeType=="multipart/mixed"){						
						$internalParts = $parts[0]->getParts();							
						if(isset($internalParts[1])){
							$rawBody = $internalParts[1]->getBody();
							if($rawBody->size>0){
								$rawData = $rawBody->data;	
							} else {
								if(isset($internalParts[0])  && method_exists($internalParts[0], 'getBody')){
									$rawBody = $internalParts[0]->getBody();
									$rawData = $rawBody->data;
								}		
							}								
						}else if(isset($internalParts[0])  && method_exists($internalParts[0], 'getBody')){
							$rawBody = $internalParts[0]->getBody();
							$rawData = $rawBody->data;
						}							
						if(empty($rawData)){
							$rawParts = $internalParts[0]->getParts();
							if(count($rawParts)>1){
								$rawBody = $rawParts[1]->getBody();
								$rawData = $rawBody->data;
							} else if(count($rawParts)==1){
								$rawBody = $rawParts[0]->getBody();
								$rawData = $rawBody->data;
							} 							
						}
						$sanitizedData = strtr($rawData,'-_', '+/');
						$messageBody = base64_decode($sanitizedData);
					} 
					if(empty($messageBody)){
						if(isset($parts[0])){
							$internalParts = $parts[0]->getParts();
							if(isset($internalParts[1]) && method_exists($internalParts[1], 'getBody')){
								$rawBody = $internalParts[1]->getBody();
								$rawData = $rawBody->data;									
							} else if(isset($internalParts[0])){
								$rawParts = $internalParts[0]->getParts();
								$rawBody = $rawParts[1]->getBody();
								$rawData = $rawBody->data;
							} else if(isset($parts[0])){
								$rawBody = $parts[1]->getBody();
								$rawData = $rawBody->data;									
							} else {
								$rawBody = $parts[0]->getBody();
								$rawData = $rawBody->data;		
							}
							if(!empty($rawData)){
								$sanitizedData = strtr($rawData,'-_', '+/');
								$messageBody = base64_decode($sanitizedData);
							} else {
								$rawBody = $parts[0]->getBody();
								$rawData = $rawBody->data;
								$sanitizedData = strtr($rawData,'-_', '+/');
								$messageBody = base64_decode($sanitizedData);
							}								
						}
					}
				} else {
					$rawBody = $message->getPayload()->getBody();
					$rawData = $rawBody->data;	 
					$sanitizedData = strtr($rawData,'-_', '+/');
					$messageBody = base64_decode($sanitizedData);	
				}
				$checkMimeType = false;
				/*if(count($parts)>0){
					foreach($parts as $part){
						if($part->mimeType=="multipart/alternative" || $part->mimeType=="multipart/related" || $part->mimeType=="multipart/mixed"){
							$checkMimeType = true;
						}
					}
				}*/
				if($payLoadMimeType=="multipart/alternative" || $payLoadMimeType=="multipart/related" || $payLoadMimeType=="multipart/mixed"){
					$checkMimeType = true;
				}
				if($checkMimeType===true){
					for($i=1;$i<count($parts);$i++){ 
						switch($parts[$i]->mimeType){
							case "multipart/alternative":
							case "multipart/mixed":
							case "multipart/related":
							default:
								$fileName = $parts[$i]->filename;
								/*if(!empty($fileName)):*/
								$partId = $parts[$i]->partId;
								$attachmentID = $parts[$i]->getBody()->getAttachmentId();
								if(!empty($attachmentID )){
									if(!in_array($attachmentID,$attachmentArray)){
										$attachmentArray[] = $attachmentID ;
										foreach($partHeaders as $h){
											if($h->name=='X-Attachment-Id'){
												$realAttachID= $h->value;
											}
										}
										$mimeType = $parts[$i]->mimeType;
										$fileSize = $parts[$i]->getBody()->getSize();
										$attachments[] = array('filename'=>$fileName,'mimeType'=>base64_encode($mimeType),'attachmentId'=>$attachmentID,'size'=>$fileSize,"realAttachID"=>$realAttachID,"partId"=>$partId);
									}
								} else {
									$internalParts = $parts[$i]->getParts();
									if(count($internalParts)>0){
										foreach($internalParts as $innerParts){
											/*$sanitizedData = $innerParts->getBody();
												$sanitizedData = strtr($rawData,'-_', '+/');
												$messageBody = base64_decode($sanitizedData);	
												echo $messageBody."<br/>";*/
											if(!empty($innerParts->filename)){
												
												$attachmentID = $innerParts->getBody()->getAttachmentId();
												if(!empty($attachmentID)){
													if(!in_array($attachmentID,$attachmentArray)){
														$partInnerHeaders= $innerParts->getHeaders();
														$attachmentArray[] = $attachmentID ;
														foreach($partInnerHeaders as $h){
															if($h->name=='X-Attachment-Id'){
																$realAttachID= $h->value;
															}
														}
														$mimeType = $innerParts->mimeType;
														$fileSize = $innerParts->getBody()->getSize();
														$attachments[] = array('filename'=>$innerParts->filename,'mimeType'=>base64_encode($mimeType),'attachmentId'=>$attachmentID,'size'=>$fileSize,"realAttachID"=>$realAttachID,"partId"=>$partId);
													}
												}
											}												
										}
									}
								}
								/*endif;*/
							break;
						}
						/*if((($parts[$i]->mimeType=="multipart/alternative" || $part[$i]->mimeType=="multipart/related" || $part[$i]->mimeType=="multipart/mixed"))){
							$fileName = $parts[$i]->filename;
							$realAttachID = "";
							$partHeaders= $parts[$i]->getHeaders();
							$attachmentID = $parts[$i]->getBody()->getAttachmentId();								
							if(!empty($attachmentID )){
								if(!in_array($attachmentID,$attachmentArray)){
									$attachmentArray[] = $attachmentID ;
									foreach($partHeaders as $h){
										if($h->name=='X-Attachment-Id'){
											$realAttachID= $h->value;
										}
									}
									$mimeType = $parts[$i]->mimeType;
									$fileSize = $parts[$i]->getBody()->getSize();
									$attachments[] = array('filename'=>$fileName,'mimeType'=>base64_encode($mimeType),'attachmentId'=>$attachmentID,'size'=>$fileSize,"realAttachID"=>$realAttachID);
								}
							} else {									
								$internalParts = $parts[$i]->getParts();
								if(count($internalParts)>0){
									foreach($internalParts as $innerParts){
										$attachmentID = $innerParts->getBody()->getAttachmentId();
										if(!empty($attachmentID)){
											if(!in_array($attachmentID,$attachmentArray)){
												$partInnerHeaders= $innerParts->getHeaders();
												$attachmentArray[] = $attachmentID ;
												foreach($partInnerHeaders as $h){
													if($h->name=='X-Attachment-Id'){
														$realAttachID= $h->value;
													}
												}
												$mimeType = $innerParts->mimeType;
												$fileSize = $innerParts->getBody()->getSize();
												$attachments[] = array('filename'=>$fileName,'mimeType'=>base64_encode($mimeType),'attachmentId'=>$attachmentID,'size'=>$fileSize,"realAttachID"=>$realAttachID);
											}
										}
									}
								}
							}
							
						}*/
					}
				}
				$findThreadData[] = array("thread_id"=>$threadId,"message_id"=>$message->id,"labelIds"=>$message->labelIds,"header"=>$header,"body"=>$messageBody,"attachments"=>$attachments,"content"=>$message,"parts"=>$parts);				
			}			
		}
		$data['thread_find'] = $findStatus;
		$data['thread_detail'] = $findThreadData;
		$data['type'] = 1;
		$this->layout->title_for_layout = 'Backyard Email Detail';
		$this->layout->layout='email';
		// $this->layout->layout='email';
		$this->layout->render('user/email',$data);
	}
	
	public function predefined_templates($t=1,$lead_id=0){
		$this->layout->title_for_layout = 'Predefined Messages';
		$this->layout->layout='opportunity';
		$data['t'] = $t;
		$data['lead_id'] = $lead_id;
		$this->layout->render('user/predefined_templates',$data);
	}
	
	public function moveAllToLeadBankTemplate(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$lead_id = $this->input->post('lead_id');
			if($lead_id>0){
			$allTemplates = $this->general_model->getAllTemplates();
			if(count($allTemplates)>0){
				foreach($allTemplates as $row){					
					$template = $row->template_html;					
					$urlName ="";
					if($row->main_type=="2"){	
						$acquisition = $this->acquisition_model->getData($lead_id);
						$category_list = $this->customer_model->categoryList(0);
						$lead_data = $this->lead_model->getLeadData($lead_id);
						$categoryList = $this->lead_model->getLeadCategoryList($lead_id);						
						if(count($categoryList) > 0){
							foreach($categoryList as $cat){
								if($cat->main_category == 1){
									$urlName ='/catalog?'.md5($lead_data->serial_number);
								}
							}
						}
						
						
						/*
						if(!empty($acquisition['acquisition']->store_name)):				
						if($acquisition['acquisition']->category>0){
							if(count($category_list)>0){
								for($cc=0;$cc<count($category_list);$cc++){
									if($category_list[$cc]->id==$acquisition['acquisition']->category){
										$urlName = $category_list[$cc]->name;
										$urlName = str_replace('','_',$urlName);
										$urlName = str_replace('-','_',$urlName);
										$urlName = str_replace('&',' ',$urlName);
										$urlName = str_replace('&amp;',' ',$urlName);
										$urlName = preg_replace("/[^a-zA-Z0-9_\s-]/", "_", $urlName);
										$urlName = preg_replace('/-/','_',$urlName);
										$urlName = preg_replace('/[\s,\-!]/',' ',$urlName);
										$urlName = preg_replace('/\s+/','_',$urlName);
									}
								}
							}
							if(!empty($urlName)){
								$urlName ='/catalog?'.md5($lead_data->serial_number);
							}
						}
						endif;*/
						if(!empty($urlName)){
							$urlName = "https://synpat.com".$urlName;
						}
						$template =  str_replace('link-data-href=""',"href='".$urlName."'",$template);
					}
					$data =  $this->general_model->moveAllToLeadBankTemplate(array('lead_id'=>$lead_id,'subject'=>$row->subject,'template_html'=>$template,'type'=>$row->type,'template_name'=>$row->template_name,'main_type'=>$row->main_type));
				}
				if($data>0){
					$user_history = array('lead_id'=>$this->input->post('lead_id'),'user_id'=>$this->session->userdata['id'],'message'=>"Move skeleton to lead templates.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
				}
			}
			}
		}
		echo $data;
		die;
	}
	
	function imap_show_data($thread=null){
		$findThreadData = array();
		if($thread!=null){
			$findThreadData =  $this->lead_model->findBoxNewById($thread);			
		}
		$data['thread_detail'] = $findThreadData;
		$data['ID'] = $thread;
		$this->layout->title_for_layout = 'Backyard Email Detail';
		$this->layout->layout='email';
		$this->layout->render('user/small_imap_email',$data);
	}
	
	function own_server_show_small($thread=null){
		$findThreadData = array();
		if($thread!=null){
			$findThreadData =  $this->lead_model->findBoxNewById($thread);			
		}
		$data['thread_detail'] = $findThreadData;
		$data['ID'] = $thread;
		$data['type'] = 2;
		$this->layout->title_for_layout = 'Backyard Email Detail';
		$this->layout->layout='email';
		if(count($findThreadData)>0){
			if((int)$findThreadData[0]->account_type==2){
				$this->layout->render('user/small_imap_email',$data);
			} else {
				$this->layout->render('user/small_email',$data);
			}
		} else {
			echo "Page not found";
			die;
		}			
	}
	
	function own_server_email($thread=null){
		$findThreadData = array();
		if($thread!=null){
			$findThreadData =  $this->lead_model->findBoxNewById($thread);			
		}
		/*echo "<pre>";
		print_r($findThreadData);
		die;*/
		$data['thread_detail'] = $findThreadData;
		$data['ID'] = $thread;
		$data['type'] = 2;
		$data['person_email_detail'] = $this->lead_model->getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($thread);
		if(count($data['person_email_detail'])==0){
			$data['person_email_detail'] = $this->lead_model->getPersonCompanyDetailFromSalesActivityLogByEmailID($thread);
		}
		/*echo "<pre>";
		print_r(json_decode($data['thread_detail'][0]->content));die;*/
		$this->layout->title_for_layout = 'Backyard Email Detail';
		$this->layout->layout='email';
		$this->layout->render('user/email',$data);
	}
	
	function profile(){
		
		$data['user_id'] = $this->session->userdata['id'];
		$data['from'] = '';
		$data['to'] = '';
		$data['lead'] = '';
		$data['post'] = 0;
		$data['activity_type'] = 0;
		if(isset($_POST) && count($_POST)>0){			
			if((int)$_POST['profile']['selected_user']>0){
				if($this->session->userdata['type']==9){
					$data['user_id'] = $_POST['profile']['selected_user'];
				}
			}
			if(!empty($_POST['profile']['from'])){
				$data['from'] = $_POST['profile']['from'];
			}
			if(!empty($_POST['profile']['end'])){
				$data['end'] = $_POST['profile']['end'];
			}
			if(!empty($_POST['profile']['lead'])){
				$data['lead'] = $_POST['profile']['lead'];
			}
			$activity_type= 0;
			if(!empty($_POST['profile']['activity_type'])){
				$activity_type = $_POST['profile']['activity_type'];
			}
			$data['activity_type'] = $activity_type;
			$data['post'] = 1;
		}
		$data['userData'] = $this->user_model->getUserData($this->session->userdata['id']);
		$this->layout->title_for_layout = 'Backyard User Profile';
		$this->layout->layout='opportunity';
		$this->layout->render('user/profile',$data);
	}
	
	
	
	
	function linkWithMessage(){
			$box['thread'] = $this->input->get('thread');
			$box['old_thread'] = $this->input->get('old_thread');
			if(!isset($_SESSION)){
				session_start();
			}
			$this->load->library('DriveServiceHelper');
			$service = new GmailServiceHelper();
			$googleToken = $_SESSION['another_access_token'];
			if(empty($googleToken)){
				$googleToken = $this->getUserToken();
			}
			$service->setAccessToken($googleToken);
			$getMessageData = $service->findThreadData($box['thread']);			
			$listOfLabels = $service->listLabels();			
			$filesAttachment = "";
			$labelID = "";
			if(count($listOfLabels)>0){
				foreach($listOfLabels as $key=> $label){
					if(strtolower($label)=='lead'){
						$labelID = $key;
					}
				}
			}
			if(empty($labelID)){
				$label = $service->createLabel('Lead');
				if($label){
					$labelID = $label->getId();
				}
				
			}
			/**/
			$gmailMessageID = $box['thread'];
			$attachmentArray = array();
			if(count($getMessageData)>0){
				foreach($getMessageData as $message){
					foreach($message['attachments'] as $attachments){
						$attachmentID = $attachments['attachmentId'];
						if(!in_array($attachmentID,$attachmentArray)){
							$filename =  $attachments['filename'];
							$attachmentsData = $service->downloadAttachments($gmailMessageID,$attachmentID);
							if(is_object($attachmentsData)){
								$rawData = $attachmentsData->data;
								$sanitizedData = strtr($rawData,'-_', '+/');
								$data = strtr($rawData, array('-' => '+', '_' => '/'));
								$body = base64_decode($sanitizedData);
								$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
								fwrite($fh, $body);
								fclose($fh);	
								$filesAttachment .=$this->config->base_url()."public/upload/".$filename.",";
							}
						}
					}
				}
			}
			if(!empty($filesAttachment)){
				$filesAttachment = substr($filesAttachment,0,-1);
			}			
			$sendData = $this->lead_model->insertBox(array("lead_id"=>$box['old_thread'],"thread_id"=>$box['thread'],"content"=>json_encode($getMessageData),"file_attach"=>$filesAttachment));
			if($sendData>0){
				if(!empty($labelID)){
					$service->modifyThreadRemove($gmailMessageID,"me",'INBOX');
					$service->modifyThreadRemove($gmailMessageID,"me",'UNREAD');
					$service->modifyThread($gmailMessageID,"me",$labelID);
				}
				$user_history = array('lead_id'=>$box['old_thread'],'user_id'=>$this->session->userdata['id'],'message'=>"Add email into box.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
				$this->user_model->addUserHistory($user_history);
				echo json_encode(array('send'=>1));
			} else {
				echo json_encode(array('send'=>0));
			}
		
		die;
	}
	
	
	function notificationEmail(){
		if(isset($_POST) && count($_POST)>0){
			$type = $this->input->post('type');
			$this->user_model->errorNotification(array("user_id"=>$this->session->userdata('id'),"create_date"=>date('Y-m-d h:i:s'),'type'=>$type));
		}
		die;
	}
	
	function list_from_google_cloud_bucket(){
		try{
			require(APPPATH.'third_party/google_cloud/autoload.php');
			$storage = new Google\Cloud\Storage\StorageClient([
				'projectId' => '78157078768',
				'keyFilename'=>'/var/www/html/backyard.synpat.com/application/third_party/Project-0da2ce476d80.p12',
				'acl' => 'public-read'
			]);
			$bucket = $storage->bucket('static.synpat.com');
			$objects = $bucket->objects(array('prefix'=>'store_images/22232/','fields' => 'items/name,nextPageToken'));

			foreach ($objects as $object) {
				echo $object->name() . '<br/>';
			}
			
			
		}catch(Exception $e){
			
		}
		die;
	}
	
	function add_google_cloud_file(){		
		try{
			require(APPPATH.'third_party/google_cloud/autoload.php');
			$storage = new Google\Cloud\Storage\StorageClient([
				'projectId' => '78157078768',
				'keyFilename'=>'/var/www/html/backyard.synpat.com/application/third_party/Project-0da2ce476d80.p12',
				'acl' => 'public-read'
			]);
			$bucket = $storage->bucket('static.synpat.com');
			//$acl = $bucket->acl();
			$getData = $bucket->upload(fopen('/var/www/html/backyard.synpat.com/pack.txt', 'r'),array('name'=>'tam.txt','predefinedAcl'=>'publicRead'));
			$info = $getData->info();
			echo "<pre>";
			print_r($info);
			die;
			
			
		}catch(Exception $e){
			
		}
		die;
	}
	
	function add_aws_file($fileName,$sourceFile){
		require(APPPATH.'third_party/vendor/autoload.php');
		try{
			$this->config->load('config');
			$client = Aws\S3\S3Client::factory(array(
					'credentials' => array(
						'key'    => $this->config->item('aws_key_id'),
						'secret' => $this->config->item('aws_secret_key'),
					)));
			$bucket = $this->config->item('aws_buket_name');
			$result = $client->putObject(array(
				'Bucket'      => $bucket,
				'Key'         => 'public/upload/'.$fileName,
				'ACL'         => 'public-read',
				'SourceFile'  => $sourceFile,
				'StorageClass'=> 'REDUCED_REDUNDANCY'
			));
			return array('file_details'=>$result,'file_url'=>$result->get('ObjectURL'),'error'=>0);
		}catch(Exception $e){
			return array('file_details'=>$result,'error'=>1,'error_message'=>$e->getMessage());
		}		
	}
	
	function update(){
		if(isset($_POST) && count($_POST)>0){
			$profilePIC = "";
			$user = $this->input->post('user');
			/*if(isset($_FILES) && !empty($_FILES['user']['name']['profile_pic'])){
				$target_file = $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$_FILES['user']['name']['profile_pic'];
				if(move_uploaded_file($_FILES['user']["tmp_name"]['profile_pic'], $target_file)){
					$fileData = $this->add_aws_file($_FILES['user']['name']['profile_pic'],$target_file);
					$fileAWS = "";
					if(count($fileData)>0 && $fileData['error']==0){
						unlink($target_file);
						$profilePIC = $fileData['file_url'];
					}
				}
			} else {
				$profilePIC = $user['old_pic'];
			}*/
			if(!empty($user['password'])){
				if($user['password'] == $user['confirm_password']){
					$updateData = $this->simpleloginsecure->updatePassword($this->session->userdata['id'],$user['password'],true);
				}				
			}						
			if($updateData){
				$this->session->set_flashdata('message','<p class="alert alert-success">Record Saved!</p>');
			} else {
				$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime.</p>');
			}
			die;
			//redirect('users/profile');
		}
	}
	
	function getMoreRecordsInEmail(){
		$type = $this->input->post('t');
		$records = $this->input->post('r');
		$this->load->library('DriveServiceHelper');
		$service = new GmailServiceHelper();
		if(!isset($_SESSION)){
			session_start();
		}	
		if(!empty($type)){
			$googleToken = $_SESSION['another_access_token'];
			if(empty($googleToken)){
				$googleToken = $this->getUserToken();
			}
			$service->setAccessToken($googleToken);
			$getOldEmails = $_SESSION[$type];
			$token = $getOldEmails[count($getOldEmails)-1]['pageToken'];
			if(!empty($token)){
				$nextPageEmails = $service->newMessageList($records,$type,$token);
				$allEmails = array_merge($getOldEmails, $nextPageEmails);
				$_SESSION[$type] = $allEmails;
			}
		}
		die;
	}
	
	public function queueData(){
		$getJobData = $this->user_model->getJobQueueData($this->input->get('job_id'));
		if(count($getJobData)>0){
			$this->load->library('DriveServiceHelper');
			$service = new GmailServiceHelper();
			try{
				echo "SAS<br/>";
				echo $getJobData->data_raw."<br/>";
				$emails = json_decode($getJobData->data_raw,true);
				echo "<pre>";
				print_r($emails);						
			}catch(Exception $e){
				echo "<pre>";
				print_r($e);
			}
		}
		die;
	}
	
	public function retrieveQueueData(){
		$data = array('type'=>'','status'=>0,'job_id'=>0,'t'=>-1);
		if(isset($_GET) && count($_GET)>0){
			$data['job_id'] = $this->input->get('job_id');
			$data['t'] = $this->input->get('t');
			$getJobData = $this->user_model->getJobQueueData($this->input->get('job_id'));
			if(count($getJobData)>0){
				if((int)$getJobData->status==1 && $this->session->userdata['id']==$getJobData->user_id){
					if(!isset($_SESSION)){
						session_start();
					}
					if(!empty($getJobData->data_raw) && $getJobData->data_raw!=null){
						$this->load->library('DriveServiceHelper');
						$service = new GmailServiceHelper();
						try{
							$emails = json_decode($getJobData->data_raw,true);
							$_SESSION[$getJobData->type] = $emails;							
						}catch(Exception $e){}
						$data['status'] = $getJobData->status;
						$data['type'] = $getJobData->type;
					}
				}
			}
		} 
		echo json_encode($data);
		die;
	}
	
	public function pushMessageToQueue(){
		$job_id = 0;
		try{			
			$getData = $this->input->post();
			if(!isset($getData['user_id'])){
				if($this->session->userdata['id']>0){
					$getData['user_id'] = $this->session->userdata['id'];
				}/* else {
					$getData['user_id'] = 1;
				}*/
			}
			/*$getData['user_id'] = $this->session->userdata['id'];*/
			if(isset($getData['user_id'])>0){
				/*require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
				$rabbitmq = parse_url(getenv('CLOUDAMQP_URL'));
				define("RABBITMQ_HOST", $rabbitmq['host']);
				define("RABBITMQ_PORT", isset($rabbitmq['port']) ? $rabbitmq['port'] : 5672);
				define("RABBITMQ_USERNAME", $rabbitmq['user']);
				define("RABBITMQ_PASSWORD", $rabbitmq['pass']);
				define("RABBITMQ_VHOST", substr($rabbitmq['path'], 1) ?: '/');
				$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
					RABBITMQ_HOST, 
					RABBITMQ_PORT, 
					RABBITMQ_USERNAME, 
					RABBITMQ_PASSWORD,
					RABBITMQ_VHOST
				);
				$channel = $connection->channel();
				# Create the queue if it doesn't already exist.
				$channel->queue_declare('task_queue_gmail', false, true, false, false);*/
				$getData['module_name']='Email';
				$job_id=$this->user_model->addJobQueue($getData);
				exec('php5.6 -f /var/www/html/backyard.synpat.com/gmail_queue.php');
/*exec('php /home/claimcha/public_html/synpat_backyard/gmail_queue.php');*/
				/*$jobArray = array(
					'id' => $job_id,
					'task' => 'sleep',
					'sleep_period' => rand(0, 3)
				);
				$msg = new \PhpAmqpLib\Message\AMQPMessage(
					json_encode($jobArray, JSON_UNESCAPED_SLASHES),
					array('delivery_mode' => 2) # make message persistent
				);
				$channel->basic_publish($msg, '', 'task_queue_gmail');
				$channel->close();
				$connection->close();*/
			}			
		}catch(Exception $e){
			
		}
		echo $job_id;
		die;
	}
	public function getEmails(){
		$type = $this->input->post('type');
		$paging = $this->input->post('paging');
		$this->load->library('DriveServiceHelper');
		$service = new GmailServiceHelper();
		if(!isset($_SESSION)){
			session_start();
		}		
		if(!empty($type)){
			$googleToken = $_SESSION['another_access_token'];
			if(empty($googleToken)){
				$googleToken = $this->getUserToken();
			}
			$service->setAccessToken($googleToken);			
			if(strtolower($type)!='lead'){
				$emails = $service->newMessageList($paging,$type);
				$_SESSION[$type] = $emails;
			} else {
				/*
				$service->setAccessToken($_SESSION['another_access_token']);
				$listOfLabels = $service->listLabels();			
				$labelID = "";
				if(count($listOfLabels)>0){
					foreach($listOfLabels as $key=> $label){
						if(strtolower($label)=='lead'){
							$labelID = $key;
						}
					}
				}
				if(empty($labelID)){
					$label = $service->createLabel('Lead');
					if($label){
						$labelID = $label->getId();							
					}
				}
				if(!empty($labelID)){
					$service->setAccessToken($_SESSION['another_access_token']);
					$emails = $service->newMessageList(30,$labelID);
					$_SESSION[$type] = $emails ;
				}*/
				/*Get Leads emails from database*/				
			}
		}
		die;		
	}
	
	public function getCurrentOldEmails(){		
		$type = $this->input->post('stype');
		if(!empty($type)){
			$this->load->library('DriveServiceHelper');
			$service = new GmailServiceHelper();
			if(!isset($_SESSION)){
				session_start();
			}
			$emails = $_SESSION[$type];
			/*$incomplete = $this->lead_model->findIncompleteANDCompleteList('Market');
			$boxList = $this->lead_model->findAllBoxThreadList();
			$pass_lead = $this->lead_model->getPassLead();	*/
			$boxList = array();
			$pass_lead = array();
			echo json_encode(array("emails"=>$emails,"boxList"=>$boxList,"pass_lead"=>$pass_lead));
		}
	}
	
	function getCalendarColors(){
		$this->load->library('DriveServiceHelper');
		$service = new CalendarServiceHelper();
		$colors = $service->getColor();
		$availableColor = array();
		foreach ($colors->getCalendar() as $key => $color) {
		  $availableColor[] = $color->getBackground();
		  /*print "colorId : {$key}<br/>";
		  print "  Background: {$color->getBackground()}\n";
		  print "  Foreground: {$color->getForeground()}\n";*/
		}
		echo json_encode($availableColor);
		die;
	}
	
	function activitylog($activityLog){
		if(isset($activityLog['task_id'])){
			unset($activityLog['task_id']);
		}
		if(isset($activityLog['next_call_date'])){
			unset($activityLog['next_call_date']);
		}
		$this->lead_model->insertActivityLog($activityLog);
	}
	
	function insert_event(){
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');			
			if(!isset($_SESSION)){
				session_start();
			}
			/*
			$service = new GmailServiceHelper();
			$service->setAccessToken($_SESSION['another_access_token']);*/
			$service = new CalendarServiceHelper();
			$event = $this->input->post("event");
			$email = $this->input->post("email");
			if(!empty($email)){
				$allEmails = explode(',',$email);
				foreach($allEmails as $email){
					if(trim($email)!=""){
						$event['attendees'][] = array("email"=>trim($email));
					}					
				}
			}	
			$sessionUserIN = false;
			foreach($event['attendees'] as $attende){
				if(trim($attende['email']) == $this->session->userData['email']){
					$sessionUserIN = true;break;
				}
			}
			if($sessionUserIN ===false){
				$event['attendees'][] = array("email"=>$this->session->userdata['email']);
			}
			$eventsSendEmail = "";
			foreach($event['attendees'] as $attende){
				$eventsSendEmail .= trim($attende['email']).",";
			}
			$eventsSendEmail = substr($eventsSendEmail,0,-1);
			if(isset($event['color']) && !empty($event['color'])){
				$event['colorId'] = $event['color'];
			}
			unset($event['color']);
			$sTime = $event['start_time'];
			$sT = explode(" ",$sTime);
			$UTCAttached = "";
			if(date('I')){
				$UTCAttached = "00-07:00";
			} else {
				$UTCAttached = "00-08:00";
			}
			if(count($sT)==2){
				if(trim($sT[1])=="PM"){
					$explodeM = explode(":",$sT[0]);
					if(count($explodeM)==2){
						if((int)$explodeM[0]<12){
							$mT = (int)$explodeM[0] + 12;
						} else {
							$mT = (int)$explodeM[0];
						}
						
					} else {
						$mT = (int)$explodeM[0];
					}
					$sD = date('Y-m-d',strtotime($event['start_date']));
					$time = strtotime($sD.$mT.':'.$explodeM[1]);
					$m = date('G:i',$time);
					$sD = $sD.'T'.$m.':'.$UTCAttached;
					$event['start']=array('dateTime'=>$sD,'timeZone'=> 'America/Los_Angeles');
				} else {
					$explodeM = explode(":",$sT[0]);
					$sD = date('Y-m-d',strtotime($event['start_date']));
					$first = $explodeM[0];
					if($first==12){
						$first = 00;
					}
					$time = strtotime($sD.$first.':'.$explodeM[1]);
					$m = date('G:i',$time);
					$sD = $sD.'T'.$m.':'.$UTCAttached;
					$event['start']=array('dateTime'=>$sD,'timeZone'=> 'America/Los_Angeles');
				}
			}
			$eTime = $event['end_time'];
			$eT = explode(" ",$eTime);
			if(count($eT)==2){
				if(trim($eT[1])=="PM"){
					$explodeM = explode(":",$eT[0]);
					if(count($explodeM)==2){
						if((int)$explodeM[0]<12){
							$mT = (int)$explodeM[0] + 12;
						} else {
							$mT = (int)$explodeM[0];
						}						
					} else {
						$mT = (int)$explodeM[0];
					}
					$sD = date('Y-m-d',strtotime($event['end_date']));
					$time = strtotime($sD.$mT.':'.$explodeM[1]);
					$m = date('G:i',$time);
					$sD = $sD.'T'.$m.':'.$UTCAttached;
					$event['end']=array('dateTime'=>$sD,'timeZone'=> 'America/Los_Angeles');
				} else {
					$explodeM = explode(":",$eT[0]);
					$sD = date('Y-m-d',strtotime($event['end_date']));
					$first = $explodeM[0];
					if($first==12){
						$first = 00;
					}
					$time = strtotime($sD.$first.':'.$explodeM[1]);
					$m = date('G:i',$time);
					$sD = $sD.'T'.$m.':'.$UTCAttached;
					$event['end']=array('dateTime'=>$sD,'timeZone'=> 'America/Los_Angeles');
				}
			}
			/*$event['recurrence'] = array('RRULE:FREQ=DAILY;COUNT=2');*/
			$event['guestsCanModify'] = true;
			$event['reminders'] = array(
									'useDefault' => FALSE,
									'overrides' => array(
									  array('method' => 'email', 'minutes' => 24 * 60),
									  array('method' => 'email', 'minutes' => 10),
									),
								  );
			$startDateEvent = $event['start_date']." ".$event['start_time'];
			unset($event['end_time']);
			unset($event['end_date']);
			unset($event['start_time']);
			unset($event['start_date']);
			$eventID = $event['id'];
			unset($event['id']);
			/*if($eventID==""){
				$eventRes = $service->insert_event($event);
			} else {
				$eventRes = $service->update_event($event,$eventID);
			}*/
			$meetingLink = "";
			$meetingID = "";
			$getZoomUserList = $this->sendRequestZoomMeeting('user/list',array('page_size'=>30,'page_number'=>1));
			$usersList = json_decode($getZoomUserList,true);
			if(isset($usersList['users']) && count($usersList['users'])>0){
				$userID = $usersList['users'][0]['id'];
				$createAMeetingArray = array();
				$createAMeetingArray['host_id'] = $userID;
				$createAMeetingArray['topic'] = "SynPat schedule meeing";
				$createAMeetingArray['type'] = 2;
				$createAMeetingArray['start_time'] = $event['start']['dateTime'];
				$createAMeetingArray['timezone'] = "America/Los_Angeles";
				$result =  $this->sendRequestZoomMeeting('meeting/create', $createAMeetingArray);
				$result =  json_decode($result,true);
				if(isset($result['join_url'])){
					$meetingLink = $result['join_url'];
					$meetingID = $result['id'];
				}
			}
			$description = $event['summary'].'\n\nPlease use the following link to join a screenshare call:\n'.$meetingLink.'\nMake sure your microphone and speakers are connected.\n\nAlternatively, dial +14086380968,'.$meetingID.'#\nInternational numbers available: https://zoom.us/zoomconference?m=jj2TrQZc7GEKn_IqOx8lXZtAI2TvTXUE';
			$descriptionEmail = '<div><table cellspacing="0" cellpadding="8" border="0" summary="" style="width:100%;font-family:Arial,Sans-serif;border:1px Solid #ccc;border-width:1px 2px 2px 1px;background-color:#fff"><tbody><tr><td><div style="padding:2px"><span></span><div style="padding-bottom:15px;font-size:13px;color:#222;white-space:pre-wrap!important;white-space:-moz-pre-wrap!important;white-space:-pre-wrap!important;white-space:-o-pre-wrap!important;white-space:pre-wrap;word-wrap:break-word"><p>'.$event['summary'].'</p><p>Please use the following link to join a screenshare call:</p><p><a href="'.$meetingLink.'">'.$meetingLink.'</a></p><p>Make sure your microphone and speakers are connected.</p><p>Alternatively, dial +14086380968,'.$meetingID.'#</p><p>International numbers available: <a href="https://zoom.us/zoomconference?m=jj2TrQZc7GEKn_IqOx8lXZtAI2TvTXUE">https://zoom.us/zoomconference?m=jj2TrQZc7GEKn_IqOx8lXZtAI2TvTXUE</a></p></div></div></td></tr></tbody></table></div>';
			date_default_timezone_set('America/Los_Angeles');
			$properties = array(
			  'dtstart' => gmdate('Y-m-d H:i:s', strtotime($event['start']['dateTime'])),
			  'dtend' => gmdate('Y-m-d H:i:s', strtotime($event['end']['dateTime'])),
			  'description'=>$description,
			  'location'=>$meetingLink.'\n\n',
			  'organizer'=>$this->session->userdata['email'],
			  'summary'=>$event['summary']
			);
			$this->load->library('ICS',$properties);
			$ics_file_contents = $this->ics->to_string();
			$filename = uniqid().time().".ics";
			$fileICS = $_SERVER['DOCUMENT_ROOT']."/public/upload/".$filename;
			$fh = fopen($fileICS, "w");
			fwrite($fh, $ics_file_contents);
			fclose($fh);	
			$email_id = "";
			if(!empty($fileICS)){
				$activityType = 2;
				if(isset($_POST['acitivity_event_type']) && (int)$_POST['acitivity_event_type']>0){
					$activityType = $_POST['acitivity_event_type'];
				}
				switch((int)$activityType){
					case 1:
						/*SALES ACTIVITY*/
						if($this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])){
							require_once(APPPATH.'libraries/PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php');
							$mail = new PHPMailer;
							$mail->InReplyTo = "";
							$mail->References = "";
							$this->config->load('config');
							$username=$this->config->item('license_email');
							$password=$this->config->item('license_password');
							$FROM = $this->config->item('license_email');
							$FROMName = "SynPat Patents";
							$mail->isSMTP();                                      // Set mailer to use SMTP
							$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
							$mail->SMTPAuth = true;                               // Enable SMTP authentication
							$mail->Username = $username;                 // SMTP username
							$mail->Password = $password;                           // SMTP password
							$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
							$mail->Port = 465;                                    // TCP port to connect to
							$mail->From = $FROM;
							$mail->FromName = $FROMName;
							$mail->isHTML(true);                                
							// Set email format to HTML
							$mail->Subject = $event['summary'];
							$strToMail = explode(',',$eventsSendEmail);
							if(isset($strToMail[0]) && !empty($strToMail[0])){
								foreach($strToMail as $ema){
									$to= trim($ema);
									if(!empty($to)){					
										$mail->addAddress($to,$to);
									}				
								}
							}
							$mail->Body = $descriptionEmail;
							$mail->addAttachment($fileICS, $filename);
							try{
								if($mail->send()) {
									$email_id = 1;
								}
							} catch(Exception $e){
							
							}
						}
					break;
					case 2:
					default:
						if($this->session->userdata['user']['type']==9 || in_array(11,$this->session->userdata['modules_assign'])){
							/*SEND EMAIL FROM AUTHENTICATE GMAIL ACCOUNT*/
							$googleToken = $_SESSION['another_access_token'];
							if(empty($googleToken)){
								$googleToken = $this->getUserToken();
							}
							if(!empty($googleToken)){
								$service = new GmailServiceHelper();							
								$service->setAccessToken($googleToken);
								/*SEND EMAIL*/
								try{
									$data = array();
									$data['message'] = $descriptionEmail;
									$data['to_name'] = "";
									$data['to'] = $eventsSendEmail;
									$data['subject'] = $event['summary'];
									$data['from_email'] = $this->session->userdata['email'];
									$data['from_name'] = $this->session->userdata['name'];
									$data['fileName'] = $filename;
									$data['fileSrc'] = $fileICS;
									$send  = $service->sendMessage($data);
									if(is_object($send)){
										if(isset($send->labelIds) && count($send->labelIds)>0 && in_array("SENT", $send->labelIds)){
											$email_id = $send->id;
											$listOfLabels = $service->listLabels();			
											$labelID = "";
											if(count($listOfLabels)>0){
												foreach($listOfLabels as $key=> $label){
													if(strtolower($label)=='lead'){
														$labelID = $key;
													}
												}
											}
											if(empty($labelID)){
												$label = $service->createLabel('Lead');
												if($label){
													$labelID = $label->getId();							
												}
											}
											/*ADD LABEL LEAD*/
											if(!empty($labelID)){
												$service->modifyMessage($send->id,"me",$labelID);
											}
										}	
									}
								}catch(Exception $e){
								
								}
							}
						} else if(in_array(26,$this->session->userdata['modules_assign'])){
							/*IMAP USER*/
							require_once(APPPATH.'libraries/PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php');
							$mail = new PHPMailer;
							$mail->InReplyTo = "";
							$mail->References = "";
							$this->config->load('config');
							$username=$this->config->item('license_email');
							$password=$this->config->item('license_password');
							$FROM = $this->config->item('license_email');
							$FROMName = "SynPat Patents";
							$mail->isSMTP();                                      // Set mailer to use SMTP
							$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
							$mail->SMTPAuth = true;                               // Enable SMTP authentication
							$mail->Username = $username;                 // SMTP username
							$mail->Password = $password;                           // SMTP password
							$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
							$mail->Port = 465;                                    // TCP port to connect to
							$mail->From = $FROM;
							$mail->FromName = $FROMName;
							$mail->isHTML(true);                                
							// Set email format to HTML
							$mail->Subject = $event['summary'];
							$strToMail = explode(',',$eventsSendEmail);
							if(isset($strToMail[0]) && !empty($strToMail[0])){
								foreach($strToMail as $ema){
									$to= trim($ema);
									if(!empty($to)){					
										$mail->addAddress($to,$to);
									}				
								}
							}
							$mail->Body = $descriptionEmail;
							$mail->addAttachment($fileICS, $filename);
							try{
								if($mail->send()) {
									$email_id = 1;
								}
							} catch(Exception $e){
							
							}
						}
						
					break;
				}
			}
			$eventID = "";
			if(!empty($email_id)){
				unlink($fileICS);
				/*if(isset($eventRes->htmlLink)){*/
					if($this->input->post("lead_id")>0 && $eventID==""):
					$this->lead_model->saveLeadEvent(array("lead_id"=>$this->input->post("lead_id"),"subject"=>$event['summary'],"event_link"=>'',"date"=>$startDateEvent));
					$startDate = date('Y-m-d H:i:s');
					$user_history = array('lead_id'=>$this->input->post("lead_id"),'user_id'=>$this->session->userdata['id'],'message'=>"Create an event",'opportunity_id'=>0,'create_date'=>$startDate);
					$this->user_model->addUserHistory($user_history);
					
					if(isset($_POST['acitivity_event_type']) && (int)$_POST['acitivity_event_type']>0){
						$email = $this->input->post("email");
						if(!empty($email)){	
							/*Only one user in activities entry*/
							$emailTo = explode(',',$this->input->post("email"));
							if(count($emailTo)>1){
								$emailCurrent = $emailTo[0];
								$emailTo = array();
								$emailTo[] = $emailCurrent;
							}
							$leadID = $this->input->post("lead_id");
							$activityType = $_POST['acitivity_event_type'];
							$subject = $event['summary'];
							$description = $event['description'];
							$event= array();
							for($t=0;$t<count($emailTo);$t++){
								$toEmail = trim($emailTo[$t]);
								if(!empty($toEmail)){
									$getContactDetail = $this->lead_model->getContactByEmail(trim($emailTo[$t]));
									if(count($getContactDetail)>0 && $getContactDetail->email!=""){
										if($activityType==1){
											$checkCompanyInSalesActivity = $this->opportunity_model->checkCompanyInSales($leadID,$getContactDetail->company_id);
											if(count($checkCompanyInSalesActivity)==0){
												$this->opportunity_model->insertInvitees(array('lead_id'=>$leadID,'contact_id'=>$getContactDetail->company_id));
											}											
										} else {
											$checkCompanyInAcquisitionActivity = $this->opportunity_model->checkCompanyInAcquisition($leadID,$getContactDetail->company_id);
											if(count($checkCompanyInAcquisitionActivity)==0){
												$this->opportunity_model->insertAcquisitionCompany(array('lead_id'=>$leadID,'contact_id'=>$getContactDetail->company_id));
											}
										}
										$event['company_id'] = $getContactDetail->company_id;
										$event['contact_id'] = $getContactDetail->id;
										$event['type'] = 11;
										$dateCreate = new DateTime($startDateEvent, new DateTimeZone('America/Los_Angeles'));
 										$eventDate = $dateCreate->format('D, d M Y H:i');
										/*$event['note'] = "<a href='".$eventRes->htmlLink."' target='_BLANK'><i class='glyph-icon icon-calendar'></i>&nbsp;&nbsp;".$event['summary']." and ".$startDate."</a>";*/
										/*$note = "<a href='".$eventRes->htmlLink."' target='_BLANK'><i class='glyph-icon icon-calendar'></i>&nbsp;&nbsp;".$subject." and ".$eventDate."</a><br/><a href='".$eventRes->hangoutLink."' target='_BLANK'><i class='glyph-icon icon-video-camera'>&nbsp;Join meeting</i></a>";*/
										$note = "<i class='glyph-icon icon-calendar'></i>&nbsp;&nbsp;".$subject." and ".$eventDate."<br/><a href='".$meetingLink."' target='_BLANK'><i class='glyph-icon icon-video-camera'>&nbsp;Join meeting</i></a>";
										if(!empty($description)){
											$note .="<br/>".$description;
										}
										$event['note'] = $note;
										$event['user_id'] = $this->session->userdata['id'];
										$event['email_id'] = 0;
										$event['subject'] = $subject;
										$event['lead_id'] = $leadID;
										$event['activity_date'] = $startDate;
										$findPersonLastActivty = $this->lead_model->findPersonLastActivty($leadID,$event['company_id'],$event['contact_id'],$activityType);
										$this->activitylog($event);
										if($activityType==1){
											if(count($findPersonLastActivty)==0){
												$this->lead_model->insetSalesActivity($event);
											} else {
												if(isset($event['id'])){
													unset($event['id']);
												}
												$data = $this->lead_model->updateSalesActivity($findPersonLastActivty->id,$event);
											}
										} else if($activityType==2){
											if(count($findPersonLastActivty)==0){
												$this->lead_model->insertAcquistionActivity($event);
											} else {
												if(isset($event['id'])){
													unset($event['id']);
												}
												$data = $this->lead_model->updateAcquistionActivity($findPersonLastActivty->id,$event);
											}
										}
									}
								}
							}
						}
					}
					endif;
					echo json_encode(array('link'=>$meetingLink));
				/*}*/					
			}
		}
		die;
	}
	
	
	public function getOldEmails(){
		$type = $this->input->post('type');
		$this->config->load('config');
		$awsUrl = $this->config->item('aws_server_cdn');
		if(!empty($type)){
			$this->load->library('DriveServiceHelper');
			$service = new GmailServiceHelper();
			if(!isset($_SESSION)){
				session_start();
			}
			
			
			/*if(count($emails)==0){
				$googleToken = $_SESSION['another_access_token'];
				if(empty($googleToken)){
					$googleToken = $this->getUserToken();
				}
				$service->setAccessToken($googleToken);			
				if(strtolower($type)!='lead'){
					$emails = $service->newMessageList($paging,$type);
					$_SESSION[$type] = $emails;
				}
			}*/
			
			/*$incomplete = $this->lead_model->findIncompleteANDCompleteList('Market');
			$boxList = $this->lead_model->findAllBoxList();
			$boxList = $this->lead_model->findAllBoxThreadList();
			$pass_lead = $this->lead_model->getPassLead();*/
			if($type!="LEAD"):
			
			
			$emails = $_SESSION[$type];
			if(count($emails)>0){		
			$dontShowLabel = array('CATEGORY_PERSONAL','CATEGORY_SOCIAL','CATEGORY_UPDATES','CATEGORY_FORUMS','CATEGORY_PROMOTIONS');
			$gmailLabel='<select class="mrg5R pull-right" style="color:#000 !important;border:0px;background:#fff;max-width:90px;" onchange="moveEmailToLabel(jQuery(this))"><option value=""></option>';
			if(isset($_SESSION['user_gmail_label']) && count($_SESSION['user_gmail_label'])>0){
				foreach($_SESSION['user_gmail_label'] as $key=>$value){
					if(!in_array($value,$dontShowLabel)){
						$gmailLabel .='<option value="'.$key.'" style="color:#000 !important;">'.ucfirst(strtolower(strtoupper($value))).'</option>';
					}
				}
			}
			$gmailLabel .='</select>';
			foreach($emails as $message){
				
				$from =$message['from'];													
				$to =$message['to'];													
				$subject=$message['subject'];													
				$date = $message['date'];	
				$_dateD = "";
				$messageIDDD = $message['message_id'];	
				
			?>
				<div class="message-item media draggable" data-date='<?php echo date('D, d M Y H:i:s O',strtotime($date))?>' data-message-thread-id="<?php echo $message['thread_id']?>" data-id="<?php echo $message['id']?>" data-message-id="<?php echo $messageIDDD;?>" data-task="0">														
					<div class="message-item-right">
						<div class="media">																
							<div class="media-body" onclick="findThread('<?php echo $message['id']?>',jQuery(this));">
								<h5 class="c-dark">
								<?php 
									if(in_array(strtoupper('unread'),$message['labelIds'])){
								?>
										<a class="c-dark" href="javascript:void(0)"><strong><span class='pull-left'>From: <?php echo $from;?></span><span class='pull-left mrg5L'>To: <?php echo $to;?></span></strong></a>
								<?php
									} else {
								?>
										<a class="c-dark" style='font-weight:normal' href="javascript:void(0)"><span class='pull-left'>From: <?php echo $from;?></span><span class='pull-left mrg5L'>To: <?php echo $to;?></span></a>
								<?php
									}
								?>
								</h5>
								<h4 class="c-dark"><?php echo $subject;?></h4>
								<div>
									<span class="message-item-date"><?php echo date('M d, Y',strtotime($date));?></span>
									&nbsp;									
									<?php 
										
										$countAttachments = $message['countAttachments'];
										
										$starEmail="";
										if($type=="INBOX" || $type=="STARRED"){
											if(count($message['labelIds'])>0){
												if(in_array(strtoupper('starred'),$message['labelIds'])){
													$starEmail="<a href='javascript://' onclick='inboxLabelChanged(1,jQuery(this))' data-original-title='Starred' style='float:right;' class='mrg5R clb'><i class='glyph-icon icon-star'></i></a>";
												} else {
													$starEmail="<a href='javascript://' onclick='inboxLabelChanged(0,jQuery(this))' data-original-title='No Starred' style='float:right;' class='mrg5R clb'><i class='glyph-icon icon-star-o'></i></a>";
												}
											}
										}
										/*if(count($message['attachments'])>0):*/
										if($countAttachments>0):
									?>
									<strong><i class="glyph-icon icon-paperclip"></i> <?php echo $countAttachments;?></strong>
									<?php endif;?>
									<a href='javascript://' onclick="moveEmailToTrash(jQuery(this))" style='float:right;width:15px;'><i class="glyph-icon"><img src="<?php echo $awsUrl;?>images/discard.png" style="opacity:0.55;width:10px"></i></a><?php echo $starEmail;?><?php echo $gmailLabel;?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			
				
			}} else {
				echo "<p>Session expired click on to retrieve.</p>";
			}
			else:
				$emails = $this->lead_model->getEmailList(100);
				foreach($emails as $message){
					$from = "";
					$to ="";
					$subject = "";
					$data = "";
					$_dateD = "";
					$messageIDDD = "";
					$threadID = "";
					$messageID = "";
					$id=$message->id;					
					$content = json_decode($message->content);					
					switch($message->account_type){
						case 1:
									$headers = $content[0]->header;
									foreach($headers as $header){					
										if($header->name=="From"){	
											$from = $header->value;
										}
										if($header->name=="Subject"){
											$subject = $header->value;	
										}
										if($header->name=="Date"){
											$date = $header->value;
										}
										if($header->name=="Message-ID"){
											$messageIDDD = $header->value;
										}
									}
									$threadID = $message->thread_id;
									$messageID = $message->message_id;
									$parts = $content[0]->parts;
									$countAttachments = 0;
									if(isset($parts[0]) && ($parts[0]->mimeType=="multipart/alternative" || $parts[0]->mimeType=="multipart/related")){
										for($i=1;$i<count($parts);$i++){	$attachmentID = $parts[$i]->getBody()->getAttachmentId();
											if(!empty($attachmentID)){
												$countAttachments++;
											}
										}
									}
								break;
								case 2:
									$date = $content->header->Date;
									$subject = $content->header->subject;
									$from = $content->header->from[0]->personal;
									$messageIDDD = $content->header->message_id;
									$countAttachments = 0;
									$parts = $message->file_attach;
									$countAttachments = explode(',',$parts);
									$countAttachments = count($countAttachments)-1;
								break;
					}
				?>
					<div class="message-item media draggable" data-date='<?php echo $date?>' data-message-thread-id="<?php echo $threadID?>" data-id="<?php echo $messageID?>" data-message-id="<?php echo $messageIDDD;?>" data-task="0" data-acompany="<?php echo $message->aCompanyID?>" data-scompany="<?php echo $message->sCompanyID?>" data-atype="<?php echo $message->aType?>" data-stype="<?php echo $message->sType?>" data-lead="<?php echo $message->lead_id?>" data-lead-name="<?php echo $message->lead_name?>" data-send="<?php echo $message->account_type?>" data-type="<?php echo $message->from_activity?>">														
					<div class="message-item-right">
						<div class="media">																
							<div class="media-body" onclick="findOwnThread(<?php echo $id;?>,jQuery(this),2,1);">
								<h5 class="c-dark">	
									
									<a class="c-dark" style='font-weight:normal' href="javascript:void(0)"><span class='pull-left'>From: <?php echo $from;?></span><span class='pull-left mrg5L'>To: <?php echo $to;?></span></a>
								</h5>
								<h4 class="c-dark"><?php echo $subject;?></h4>
								<div>
									<span class="message-item-date"><?php echo date('M d, Y',strtotime($date));?></span>
									&nbsp;									
									<?php 
										if($countAttachments>0):
									?>
									<strong><i class="glyph-icon icon-paperclip"></i> <?php echo $countAttachments;?></strong>
									<?php endif;?>
									<!--<a href='javascript://' onclick="enableTask(jQuery(this))" style='float:right;width:15px;'><i class="glyph-icon icon-plus"></i></a>
									--><a href='javascript://' onclick="moveEmailToTrash(jQuery(this))" style='float:right;width:15px;'><i class="glyph-icon"><img src="<?php echo $awsUrl;?>images/discard.png" style="opacity:0.55;width:10px"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
				}
			endif;
		}
		die;		
	}
    
	public function findThread(){
		$findThreadData = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');
			if(!isset($_SESSION)){
				session_start();
			}
			$service = new GmailServiceHelper();
			$googleToken = $_SESSION['another_access_token'];
			if(empty($googleToken)){
				$googleToken = $this->getUserToken();
			}
			$service->setAccessToken($googleToken);
			$findThreadData =  $service->findThreadData($this->input->post('thread'));			
		}
		echo json_encode($findThreadData);
		die;
	}
	
    public function ajax_call(){
        /*echo 'test';*/
    }
	
	public function setGlobal(){
		if(!isset($_SESSION)){
			session_start();
		}
		unset($_SESSION['clicked_url']);
		$_SESSION['clickedd_url'] = "allGlobal";
	}
	public function is_session_started(){
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_NONE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}
	
	public function findSystemLeads(){
		$incomplete = array();
		if((int)$this->session->userdata['type']!=9){
			$incomplete = $this->lead_model->findIncompleteANDCompleteListAccUser($this->session->userdata['id']);
		} else{
			$incomplete = $this->lead_model->findIncompleteANDCompleteList('Market');
		}
		if(count($incomplete)>0){
		foreach($incomplete as $message){
			$mainFlag = 0;
			$type="";
			$stage ="";
			$main = "mainLead";
			switch($message->type){
				case 'Litigation':
					$type ="Lit.";
				break;
				case 'Market':
					$type ="Mkt.";
				break;
				case 'General':
					$type ="Pro.";
				break;
				case 'SEP':
					$type ="SEP";
				break;
				default:
					$type = $message->type;
					$main = "outterLead";
				break;
			}
			if($message->complete<2){
				$stage="Lead";
			} else {
				$stage ="Oppt.";
			}
			$sellerInfo = "";
			if($message->seller_info_text!="" && $message->seller_info_text!=null){
				$sellerInfo = date('m d,y',strtotime($message->seller_info_text));
			}
			$createDate = date('m d,y',strtotime($message->create_date));
			$sellerLike = "";
			if($message->seller_like!="" && $message->seller_like!=null){
				$sellerLike = date('m d,y',strtotime($message->seller_like));
			}
			$synpatLike = "";
			if($message->synpat_like!="" && $message->synpat_like!=null){
				$synpatLike = date('m d,y',strtotime($message->synpat_like));
			}
			$ppa = "";
			if($message->ppa_date!="" && $message->ppa_date!=null){
				$ppa = date('m d,y',strtotime($message->ppa_date));
			}
			$fundingTrnsfr = "";
			if($message->funding_trnsfr!="" && $message->funding_trnsfr!=null){
				$fundingTrnsfr = date('m d,y',strtotime($message->funding_trnsfr));
			}
			$sellerClass = "";
			if($message->seller_info==1){
				$sellerClass = "btn-blink";
			}
			if($mainFlag == 0){
?> <tr class="border-blue-alt droppable old_lead <?php echo $main;?>" data-id="<?php echo $message->id?>" data-type="<?php echo $message->type?>" onclick="threadDetail(jQuery(this))" <?php if($stage=="Oppt."):?>ondblclick="opportunityRedirect('<?php echo $message->id?>');"<?php endif;?>> <td style="padding:3px 2px;border-right:0;border-left:none;width:200px" data-id="<?php echo $message->id?>" data-type="<?php echo $message->type?>" class=""><label><a style='text-align:left' title="<?php echo $message->lead_name;?>" class='btn' href="javascript:void(0)"><?php echo substr($message->lead_name,0,30);?></a></label></td> <td style="padding:3px 2px;border-right:0;border-left:none;width:45px"><?php echo $type;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='one-line-cell'><?php echo $createDate;?></td> <td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $sellerClass;?> one-line-cell'><?php echo $sellerInfo;?></td> <td style="padding:3px 2px;border-right:0;border-left:none;width:71px"> <div style="white-space:nowrap"> <?php echo $sellerLike;?> </div> </td> <td style="padding:3px 2px;border-right:0;border-left:none;width:71px"> <div style="white-space:nowrap"> <?php echo $synpatLike;?> </div> </td> <td style="padding:3px 2px;border-right:0;border-left:none;width:71px"> <div style="white-space:nowrap"> <?php echo $ppa;?> </div> </td> <td style="padding:3px 2px;border-right:0;border-left:none;width:71px"> <div style="white-space:nowrap"> <?php echo $fundingTrnsfr;?> </div> </td> <td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $message->broker_person_contact;?></td> <td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"> <?php 
						if(empty($message->seller_contact)){
							echo $message->plantiffs_name;
						} else {
							echo $message->seller_contact;
						}
						?> </td> <td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $message->person_name_1;?></td> <td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $message->person_name_2;?></td> <td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $message->relates_to;?></td> </tr> <?php
			} 
		}
	}
	die;
														
	}
	
}
/* End of file user.php */
/* Location: ./application/controllers/user.php */