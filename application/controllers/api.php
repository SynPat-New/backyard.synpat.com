<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller {

	public function __construct(){
		header("Access-Control-Allow-Headers: X-API-KEY, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
		$method = $_SERVER['REQUEST_METHOD'];
		/*if($method == "OPTIONS") {
			die();
		}*/
		parent::__construct();
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
	}

	public function auth(){
		$data = $this->input->post();
		$response = array('auth'=>false);
		try{
			if(isset($data['USER_LOGIN']) && isset($data['USER_HASH'])){
				$this->load->model('api_model');
				$response = $this->api_model->checkClient($data['USER_LOGIN'],$data['USER_HASH']);
			}
		}catch(Exception $e){
			
		}		
		$this->printJSON(array('response'=>$response));
	}
	
	public function google_login_auth($accountID){
		$this->load->library('DriveServiceHelper');
		$service = new GmailServiceHelper();
		$service->ionicClient();
		$gmailLoginUrl = $service->createAuthUrl();
		redirect($gmailLoginUrl);
	}
	
	public function v2($field='contacts',$type='json'){
		$postData = $this->input->post();
		switch($field){
			case 'accounts':
				$response= array('account'=>array());
				if(isset($postData['USER_LOGIN']) && !empty($postData['USER_LOGIN'])){
					$this->load->model('api_model');
					$response['account'] = $this->api_model->getAccountInfo($postData['USER_LOGIN']);					
				}
				$this->printJSON(array('response'=>$response));
			break;
			case 'contacts':
				$noOfRecords = 500;
				$offSet = 0;
				if(isset($postData['limit_rows'])){
					if((int)$postData['limit_rows']<=500){
						$noOfRecords = (int)$postData['limit_rows'];
					}					
				}
				if(isset($postData['limit_offset'])){
					if((int)$postData['limit_offset']>=0){
						$offSet = (int)$postData['limit_offset'];
					}					
				}
				$this->load->model('api_model');
				$getList = $this->api_model->getAPIContactList($noOfRecords,$offSet);
				$this->printJSON(array('response'=>$getList));
			break;
			case 'update_contact':
				$printData = array('status' => 0, 'message'=>'');
				$this->load->model('client_model');
				$updatedFields = $postData;
				$contactID = $updatedFields['id'];
				unset($updatedFields['id']);
				$tapPass = false;
				if(isset($updatedFields['email'])){
					$updatedFields['new_email'] = 1;
					$tapPass = true;
				}else if(isset($updatedFields['phone']) || isset($updatedFields['telephone'])){
					$updatedFields['new_phone'] = 1;
					$tapPass = true;
				}else if(isset($updatedFields['linkedin_url'])){
					$updatedFields['new_linkedin'] = 1;
					$tapPass = true;
				}
				if($tapPass===true && (int)$contactID>0){
					$printData['status'] = $this->client_model->update($contactID,$updatedFields);
					if($printData['status']>0){
						$printData['message'] = "Updated";
					}
				}
				$this->printJSON(array('response'=>$printData));
			break;
			default:
			die;
			break;
		}
	}
	
	public function ionic_auth(){
		$request_body = file_get_contents('php://input');
		$data = json_decode($request_body,true);
		$response = array('auth'=>false);
		try{
			if(isset($data['username']) && isset($data['password'])){
				require_once(APPPATH.'libraries/phpass-0.3/PasswordHash.php');
				$this->load->model('api_model');
				$user_data = $this->api_model->ionic_login($data['username']);
				if(count($user_data)>0){
					$hasher = new PasswordHash(8, false);
					if($hasher->CheckPassword($data['password'], $user_data['password'])){
						unset($user_data['password']);
						$response = $user_data;
					}
				}
			}
		}catch(Exception $e){
			$response = array('auth'=>false);
		}		
		$this->printJSON(array('response'=>$response));
	}
	
	public function printJSON($data=array()){
		echo json_encode($data);
		die;
	}
}
/* End of file private.php */
/* Location: ./application/controllers/api.php */