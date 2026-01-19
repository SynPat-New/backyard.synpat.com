<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	
	function __construct(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
		parent::__construct();
		$this->load->model('client_model');
		$this->layout->layout='default';
		/*$this->layout->add_css('public/libs/jqueryui/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		$this->layout->add_css('public/libs/bootstrap/css/bootstrap.min.css');
		$this->layout->add_css('public/libs/font-awesome/css/font-awesome.min.css');
		$this->layout->add_css('public/libs/fontello/css/fontello.css');
		$this->layout->add_css('public/libs/animate-css/animate.min.css');
		$this->layout->add_css('public/libs/nifty-modal/css/component.css');
		$this->layout->add_css('public/libs/magnific-popup/magnific-popup.css');
		$this->layout->add_css('public/libs/ios7-switch/ios7-switch.css');
		$this->layout->add_css('public/libs/pace/pace.css');
		$this->layout->add_css('public/libs/sortable/sortable-theme-bootstrap.css');
		$this->layout->add_css('public/libs/bootstrap-datepicker/css/datepicker.css');
		$this->layout->add_css('public/libs/jquery-icheck/skins/all.css');		
		
		$this->layout->add_css('public/libs/bootstrap-select/bootstrap-select.min.css');
		$this->layout->add_css('public/libs/summernote/summernote.css');
		$this->layout->add_css('public/css/style.css');
		$this->layout->add_css('public/css/style-responsive.css');
		
		
		$this->layout->add_js('public/libs/jquery/jquery-1.11.1.min.js');
		$this->layout->add_js('public/libs/bootstrap/js/bootstrap.min.js');
		$this->layout->add_js('public/libs/jqueryui/jquery-ui-1.10.4.custom.min.js');
		$this->layout->add_js('public/libs/jquery-ui-touch/jquery.ui.touch-punch.min.js');
		$this->layout->add_js('public/libs/jquery-detectmobile/detect.js');
		$this->layout->add_js('public/libs/jquery-animate-numbers/jquery.animateNumbers.js');
		$this->layout->add_js('public/libs/ios7-switch/ios7.switch.js');
		$this->layout->add_js('public/libs/fastclick/fastclick.js');
		$this->layout->add_js('public/libs/jquery-blockui/jquery.blockUI.js');
		$this->layout->add_js('public/libs/bootstrap-bootbox/bootbox.min.js');
		$this->layout->add_js('public/libs/jquery-slimscroll/jquery.slimscroll.js');
		$this->layout->add_js('public/libs/jquery-sparkline/jquery-sparkline.js');
		$this->layout->add_js('public/libs/nifty-modal/js/classie.js');
		$this->layout->add_js('public/libs/nifty-modal/js/modalEffects.js');
		$this->layout->add_js('public/libs/sortable/sortable.min.js');
		$this->layout->add_js('public/libs/bootstrap-fileinput/bootstrap.file-input.js');
		$this->layout->add_js('public/libs/bootstrap-select/bootstrap-select.min.js');
		$this->layout->add_js('public/libs/bootstrap-select2/select2.min.js');
		$this->layout->add_js('public/libs/magnific-popup/jquery.magnific-popup.min.js');
		$this->layout->add_js('public/libs/pace/pace.min.js');
		$this->layout->add_js('public/libs/bootstrap-datepicker/js/bootstrap-datepicker.js');
		$this->layout->add_js('public/libs/jquery-icheck/icheck.min.js');
		$this->layout->add_js('public/libs/prettify/prettify.js');
		$this->layout->add_js('public/js/init.js');
		
		$this->layout->add_js('public/libs/bootstrap-select/bootstrap-select.min.js');
		$this->layout->add_js('public/libs/bootstrap-inputmask/inputmask.js');
		$this->layout->add_js('public/libs/summernote/summernote.js');
		$this->layout->add_js('public/js/pages/forms.js');*/
	}
	public function index()
	{
		$this->layout->auto_render=false;		
		$this->layout->title_for_layout = 'Backyard Client List';
		$this->layout->render('client/index');
	}
	public function add(){	
		if(isset($_POST) && count($_POST)>0){
			$clientData = $this->input->post();
			$save = $this->client_model->insert($clientData['client']);
			if($save>0){
				$this->session->set_flashdata('message','Record added.');
				redirect('client/add');
			} else {
				$this->session->set_flashdata('error','Please try after sometime.');
				redirect('client/add');
			}
		}
		$this->layout->auto_render=false;		
		$this->layout->title_for_layout = 'Backyard New Client';
		$this->layout->render('client/add');
	}
	
	function getUserToken($userID){
		$this->load->library('DriveServiceHelper');
		if(!isset($_SESSION)){
			session_start();		
		}
		$service = new GmailServiceHelper();
		$this->load->model('user_model');
		$getUserData = $this->user_model->getUserData($userID,"google_token");
		$google_token = '' ;
		if(count($getUserData)>0 && !empty($getUserData->google_token)){				
			$userAccessToken = $getUserData->google_token;
			$service->setAccessToken($userAccessToken);
			if($service->checkExpiredToken()){
				$google_token= json_decode($userAccessToken);
				if(isset($google_token->refresh_token)){
					$service->refreshToken($google_token->refresh_token);
					$newToken = json_decode($service->getAccessToken());
					$google_token->id_token = $newToken->id_token;
					$google_token->access_token = $newToken->access_token;
					$google_token->created = $newToken->created;
					$google_token = json_encode($google_token);	
				} else {
					$google_token=$userAccessToken;
				} 
			}else {
				$google_token= $userAccessToken;
			}
		}
		return $google_token;
	}
	
	function findJobDetailsAndGoogleToken(){
		$data = array('job_detail'=>array(),'google_token'=>'');
		if(isset($_POST) && count($_POST)>0){
			$jobID = $this->input->post('job_id');
			$this->load->model('user_model');
			$data['job_detail'] = $this->user_model->getJobQueueData($jobID);
			$this->load->library('DriveServiceHelper');		
			try{
				if(count($data['job_detail'])>0){
					$data['google_token'] = $this->getUserToken($data['job_detail']->user_id);
				}
								
			}catch(Exception $e){}
		}
		echo json_encode($data);
		die;
	}
	
	function updateJobQueue(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$updateArray = $this->input->post();
			$id = $updateArray['id'];
			unset($updateArray['id']);
			$this->load->model('user_model');
			$data = $this->user_model->updateJobQueue($updateArray,$id);
		}
		echo $data;
		die;
	}
	
	function get_que_emails(){
		$data = 0;
		$jobID = $this->input->get('job_id');
		$this->load->model('user_model');
		$getJobData = $this->user_model->getJobQueueData($jobID);
		if(count($getJobData)>0){
			$type = $getJobData->type;
			$userID = $getJobData->user_id;
			$paging = $getJobData->paging;
			if((int)$getJobData->status==0){
				$this->load->library('DriveServiceHelper');		
				try{
					$googleToken = $this->getUserToken($userID);
					if(!empty($googleToken)){
						$service = new GmailServiceHelper();
						$service->setAccessToken($googleToken);
						$emails = $service->newMessageList($paging,$type);
						$stringEmails = "";
						$mimeTypePayload = array('multipart/mixed','multipart/alternative','multipart/related');
						if(count($emails)>0){
							$messagesFormattedArray = array();
							foreach($emails as $message){
								$from ="";													
								$subject="";													
								$date = "";	
								$_dateD = "";
								$messageIDDD ="";
								foreach($message['header'] as $header){									
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
								$parts = $message['parts'];
								$countAttachments = 0;
								if(isset($parts[0]) && (in_array($parts[0]->mimeType,$mimeTypePayload))){
									for($i=1;$i<count($parts);$i++){											
										$attachmentID = $parts[$i]->getBody()->getAttachmentId();
										if(!empty($attachmentID)){
											$countAttachments++;
										}
									}
								}
								$messagesFormattedArray[] = array('date'=>$date,'id'=>$message['message_id'],'message_id'=>$messageIDDD,'labelIds'=>$message['labelIds'],'from'=>$from,'subject'=>$subject,'countAttachments'=>$countAttachments);							
							}
							$data = $this->user_model->updateJobQueue(array('data_raw'=>serialize($messagesFormattedArray),'status'=>1),$jobID);
						}
					}
				}catch(Exception $e){
					
				}
			} else {
				$data = 1;
			}
		}
		echo $data;
		die;
	}
	
	function checkUserLoggedIN(){
		if(!isset($this->session->userdata['type']) || empty($this->session->userdata['email'])){
			if(!isset($_SESSION)){
				session_start();
			}
			if(isset($_SESSION['find_user']) && !empty($_SESSION['find_user']['type'])){
				$this->session->set_userdata($_SESSION['find_user']);
			}
		}
		if(isset($this->session->userdata['id']) && $this->session->userdata['id']>0){
			$this->load->model('user_model');
			$userData = $this->user_model->checkUserActive($this->session->userdata['id']);
			if(count($userData)==0){
				$this->session->sess_destroy();
				if(!isset($_SESSION)){
					session_start();
				}
				unset($_SESSION['find_user']);
				unset($_SESSION['another_access_token']);
				unset($_SESSION['access_token']);
				unset($_SESSION['my_emails']);
				unset($_SESSION['INBOX']);
				unset($_SESSION['STARRED']);
				unset($_SESSION['DRAFT']);
				unset($_SESSION['SENT']);
				unset($_SESSION['TRASH']);
				unset($_SESSION['LEAD']);
			}
		} else {
			$userData = array();
		}
		
		echo json_encode(array("cu"=>count($userData)));
		die;
	} 
	function search_contact(){
		if(!isset($_SESSION)){
			session_start();
		}
		$this->load->model('client_model');
		$data = $this->client_model->getAllAutoCompleteContacts();
		$contacts = array();
		$newContacts = array();
		foreach($data as $contact){
			$secondaryEmail  = trim($contact->secondary);
			unset($contact->secondary);
			$contacts[] = $contact;
			if(!empty($secondaryEmail)){
				$newContact = (object)array();
				$newContact->id = $contact->id;
				$newContact->label = $contact->label.', Secondary Email';
				$newContact->value = $secondaryEmail;
				array_push($newContacts,$newContact);
			}
		}
		$mergeContacts = array_merge($contacts,$newContacts);
		echo json_encode($mergeContacts);
		die;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */