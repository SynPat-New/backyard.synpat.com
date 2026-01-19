<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manager_Dataentry extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata('manager')){
				redirect('manager/login');
		}		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));		
	}

	function index(){
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->load->model('manager_model');
		$user = $this->session->userdata("manager");
		$data['userData'] = $this->manager_model->findUserDetails($user->id);	
		$data['my_projects'] = $this->manager_model->findUserProjectByUserID($user->id);
		$data['all_users'] = $this->manager_model->getAllActiveUsersByType(1);
		$this->layout->render('manager/start',$data);
	}
	
	function logout(){
		$this->session->sess_destroy();
		session_destroy();
		if(!isset($_SESSION)){
			session_start();
		}
		unset($_SESSION['show_me']);
		unset($_SESSION);
		redirect('manager/login');
	}
	
	function change_status(){
		$d = 0;
		if(isset($_POST)){
			$data = $this->input->post();
			$this->load->model('outsource_model');
			if((int)$data['l']>0){
				$d = $this->outsource_model->updateProfile(array('block'=>$data['p']),$data['l']);
			}
		}
		echo $d;
		die;
	}
	
	/*Receive data from files upload check extension only CSV*/
	function project_file_upload(){
		$getFileData = array();
		if(isset($_FILES) && isset($_FILES['file']) && $_FILES['file']['size']>0){
			$fileParts = pathinfo($_FILES['file']['name']);
			$fileExtensions = array('csv');
			try{
				if (in_array(strtolower(strtoupper($fileParts['extension'])), $fileExtensions)){
					$fileSave = file_get_contents($_FILES['file']['tmp_name']);
					$fileName =  $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$_FILES['file']['name'];
					$fileCreate = fopen($fileName,"w+");
					fwrite($fileCreate,$fileSave);
					$file = fopen($fileName,"r");
					while(!feof($file)){
						$getFileData[] = fgetcsv($file);
					}
					unlink($fileName);
				}
			} catch(Extension $e){}			
		}
		echo json_encode($getFileData);
		die;
	}
	/*Create project */
	function create_project(){
		$this->load->model('manager_model');
		$data['column_heading'] = $this->manager_model->findPredefinedHeadings('id,heading');
		$user = $this->session->userdata("manager");
		$data['my_clients'] = $this->manager_model->findMyClients($user->id,'id,first_name,last_name');
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->render('manager/create',$data);
	}
	
	function addTemplate(){
		$data = array();
		$this->load->model('manager_model');
		if(isset($_POST) && count($_POST)>0){
			$subject = $this->input->post('s');
			$template = $this->input->post('te');
			$data = $this->manager_model->insertTemplate(array('subject'=>$subject,'template'=>$template));
		} 
		$data = $this->manager_model->getTemplates();
		echo json_encode($data);
		die;
	}
	
	function sendMassEmail(){
		$message = "";
		if(isset($_POST) && count($_POST)>0){
			$users = $this->input->post('selected_expert');
			$this->load->model('manager_model');
			$subject = $this->input->post('subject');
			if(count($users)>0){
				$this->load->library('email');
				$config['protocol'] = 'sendmail';
				$config['mailtype'] = 'html'; // Append This Line
				$this->email->initialize($config);
				foreach($users as $user){
					$userDetail = $this->manager_model->getUser($user);
					if(count($userDetail)>0){
						$name = $userDetail->first_name." ".$userDetail->last_name;
						$email = $this->input->post('email_message');
						$project_id =$this->input->post('project_id');
						$email = str_replace("#NAME#",$name,$email);
						$projectDetails = $this->manager_model->getProject($project_id);
						if(count($projectDetails)>0){
							$projectID = '~'.md5($projectDetails->id);
							$email = str_replace("#LINK#","<a href='" . $this->config->base_url() . "outsource/dataentry/start/" . $projectID . "'>" . $projectDetails->project_name . "</a>",$email);
							$this->email->from('info@synpat.com', 'SynPat Outsource');
							/*$this->email->to("er.vivek2512@gmail.com");	*/						 
							$this->email->to($userDetail->email);
							$this->email->subject($subject);
							$this->email->message($email);
							$this->email->send();
							sleep(1);		
							$message = "Email sent!";
						} else {
							$message = "Project not found.";
						}
					} else {
						$message = "User not found.";
					}
				}
			} else {
				$message = "Please select users.";
			}
		} else {
			$message = "No data found!";
		}
		$this->session->set_flashdata('msg', $message);
		redirect('manager/dataentry/invitation');
	}
	
	function invitation(){
		$data = array();		
		$this->load->model('manager_model');
		$user = $this->session->userdata('manager');
		$data['templates'] = $this->manager_model->getTemplates();
		$data['my_projects'] = $this->manager_model->findUserProjectByUserID($user->id);
		$data['experts'] = $this->manager_model->getAllActiveUsersByType(1);		
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->render('manager/invitation',$data);
	}
	
	function show_me(){
		if(isset($_POST)){
			if(!isset($_SESSION)){
				session_start();
			}
			$_SESSION['show_me']=0;
		}
		die;
	}
	
	function project_status(){
		$data = array('p'=>0,'label'=>'','sp'=>0);
		if(isset($_POST)){
			$status  = (int) $this->input->post('s');
			$projectID  = (int) $this->input->post('d');
			if($status==0){
				$status = 1;
			} else {
				$status = 0;
			}
			$this->load->model('manager_model');
			$data['p'] = $this->manager_model->updateProject(array('status'=>$status),$projectID);
			if($data['p']>0){
				if($status==1){
					$data['label'] = "Ongoing";
				} else {
					$data['label'] = "Ended";
				}
				$data['sp'] = $status;
			}
		}
		echo json_encode($data);
		die;
	}
	
	function account_all(){
		$this->load->model('manager_model');
		$find_entry_for_users = $this->manager_model->findMyEntryForAllUsersCurrentMonth($projectID,$userID);
		echo json_encode($find_entry_for_users);
		die;
	}
	
	function update_project(){
		$data=0;
		if(isset($_POST) && count($_POST)){
			$data = $this->input->post();
			$this->load->model('outsource_model');
			$id = $data['id'];
			unset($data['id']);
			$data = $this->outsource_model->updateProject($data,$id);
		}
		echo $data;
		die;
	}
	
	function account($key=null){
		$user = $this->session->userdata('manager');		
		$this->load->model('manager_model');
		$data['ty'] = 3;
		if(isset($user->id) && $user->id>0){
			if(isset($_POST) && count($_POST)>0){
				$projectID = $this->input->post('s');
				$userID = (int)$this->input->post('u');
				$find_entry_for_users = $this->manager_model->findMyEntryForAllUsersCurrentMonth($projectID,$userID);
				echo json_encode($find_entry_for_users);
				die;
			} else {
				$this->load->model('outsource_model');
				$data['my_projects'] = $this->outsource_model->findAllProjects();		
				if(!is_null($key)){
					$decryptKey = explode('~',$key);
					if(count($decryptKey)!=2){
						$key = '~'.md5($data['my_projects'][0]->id);
					}			
				} else {
					$key = '~'.md5($data['my_projects'][0]->id);
				}
				$projectID = $data['my_projects'][0]->id;
				if(count($decryptKey)==2){				
					$encryptAmount = $decryptKey[1];
					$projectDetails = $this->outsource_model->getProjectDetailswithEncryptID($encryptAmount);
					if(count($projectDetails)>0){
						$projectID = $projectDetails->id;
					}
				}
				$data['id'] = $key;	
				$data['all_users'] = $this->manager_model->getAllActiveUsersByType(1);
				if(count($data['all_users'])>0){
					$data['find_entry_for_users'] = $this->manager_model->findMyEntryForAllUsersCurrentMonth($projectID);
				}
				$data['userData'] = $this->manager_model->findUserDetails($user->id);
				$this->layout->auto_render=false;	
				$this->layout->layout='outsource';
				$this->layout->render('manager/account',$data);
			}
		}
	}
	
	function mass_payment(){
		$items = $this->input->post('item');
		$data = "";
		try{
			$allItems = json_decode($items,true);
			$itemString = "";
			if(count($allItems)>0){
				$i=0;
				$postPaymentArray = array();
				/*
				//Sandbox
				$postPaymentArray['USER'] = 'uzi-facilitator_api1.synpat.com';
				$postPaymentArray['PWD'] = 'J35CPSGABS3T385W';
				$postPaymentArray['SIGNATURE'] = 'AFcWxV21C7fd0v3bYYYRCpSSRl31A4coQXyoFi1ISsm15c0mDvcJaVZy';
				*/
				//Live
				$postPaymentArray['USER'] = 'uzi_api1.synpat.com';
				$postPaymentArray['PWD'] = 'J8HUAQDYCSTUFNL9';
				$postPaymentArray['SIGNATURE'] = 'AiPC9BjkCyDFQXbSkoZcgqH3hpacA6eh2vrIgO0jfWLhvFYYUSTd3R8l';
				/*Payment Method*/
				$postPaymentArray['METHOD'] = 'MassPay';
				$postPaymentArray['VERSION'] = '99';
				$postPaymentArray['CURRENCYCODE'] = 'USD';
				$postPaymentArray['RECEIVERTYPE'] = 'EmailAddress';
				$postPaymentArray['EMAILSUBJECT'] = 'Testing payment';
				/*
				//Sandbox
				$paypalUrl = "https://api-3t.sandbox.paypal.com/nvp";
				*/
				
				//Live
				$paypalUrl = "https://api-3t.paypal.com/nvp";				
				for ($i = 0; $i < count($allItems); $i++) {
					$postPaymentArray['L_EMAIL'.$i] = $allItems[$i]['email'];
					$postPaymentArray['L_AMT'.$i] = $allItems[$i]['amount'];
					$postPaymentArray['L_NOTE'.$i] = 'Payment for filling holdes in dataFills';						
				}
				 $curl = curl_init();					
					curl_setopt($curl, CURLOPT_URL, $paypalUrl);
					curl_setopt($ch, CURLOPT_VERBOSE, 1);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postPaymentArray));
					$response = curl_exec($curl);
					curl_close($curl);
					$httpResponseAr = explode('&',$response);
					$httpParsedResponseAr = array();
					foreach ($httpResponseAr as $i => $value){
						$tmpAr = explode("=", $value);
						if(sizeof($tmpAr) > 1){
							$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
						}
					}
					if(sizeof($httpParsedResponseAr)>0 && array_key_exists('ACK', $httpParsedResponseAr)){
						$this->load->model('outsource_model');
						for ($i = 0; $i < count($allItems); $i++) {
							$insertPayment = array("user_id"=>$allItems[$i]['id'],"project_id"=>$allItems[$i]['project_id'],"txn_id"=>$httpParsedResponseAr['CORRELATIONID'],"payment_gross"=>$allItems[$i]['amount'],"currency_code"=>"USD","payer_email"=>$allItems[$i]['email'],"payment_status"=>$httpParsedResponseAr['ACK'],"payment_date"=>urldecode($httpParsedResponseAr['TIMESTAMP']));
							$this->outsource_model->insertPayment($insertPayment);	
						}
						$data = $httpParsedResponseAr['ACK'];
					} else {
						$data = $httpParsedResponseAr['L_LONGMESSAGE0'];
					}					
					echo $data;
				die;
				/*require(APPPATH.'third_party/paypal-php-merchants/PPBootStrap.php');
				$massPayRequest = new MassPayRequestType();
				$massPayRequest->MassPayItem = array();
				for ($i = 0; $i < count($allItems); $i++) {
					$masspayItem = new MassPayRequestItemType();					
					$masspayItem->Amount = new BasicAmountType('USD', $allItems[$i]['amount']);
					$masspayItem->ReceiverEmail = $allItems[$i]['email'];
					$masspayItem->UniqueId = 'res_txn_'.$allItems[$i]['id'];
					$masspayItem->Note = 'Payment for filling holdes in dataFills';
					$massPayRequest->MassPayItem[] = $masspayItem;
				}
				$massPayRequest->EmailSubject="Payment for filling holdes in dataFills";
				$massPayRequest->ReceiverType="uzi@synpat.com";
				$massPayReq = new MassPayReq();
				$massPayReq->MassPayRequest = $massPayRequest;				
				$paypalService = new PayPalAPIInterfaceServiceService(Configuration::getAcctAndConfig());
				$massPayResponse = $paypalService->MassPay($massPayReq);
				echo "<pre>";
				print_r($massPayResponse);*/
			}
		}catch(Exception $ex){
			/*$ex_message = $ex->getMessage();
			$ex_type = get_class($ex);
			echo "A".$ex_message."B<br/>";
			echo $ex_type;
			if($ex instanceof PPConnectionException) {
				$ex_detailed_message = "Error connecting to " . $ex->getUrl();
			} else if($ex instanceof PPMissingCredentialException || $ex instanceof PPInvalidCredentialException) {
				$ex_detailed_message = $ex->errorMessage();
			} else if($ex instanceof PPConfigurationException) {
				$ex_detailed_message = "Invalid configuration. Please check your configuration file";
			}
			echo "<pre>";
			print_r($ex);*/
		}
		die;
	}
	
	function start_project($key=null){
		$user = $this->session->userdata('manager');
		$this->load->model('outsource_model');
		$this->load->model('manager_model');
		$data['my_projects'] = $this->manager_model->findUserProjectByUserID($user->id);
		
		if(!is_null($key)){
			$decryptKey = explode('~',$key);
			if(count($decryptKey)!=2){
				$key = '~'.md5($data['my_projects'][0]->id);
			}			
		} else {
			$key = '~'.md5($data['my_projects'][0]->id);
		}
		$decryptKey = explode('~',$key);
		if(count($decryptKey)==2){				
			$projectID = $decryptKey[1];				
			$getDetailsOfProject = $this->outsource_model->findProjectFullDetailWithColumnsEncryptID($projectID);
			$data['full_project_details'] = $getDetailsOfProject;
			if(count($getDetailsOfProject['project_details'])>0){				
				$data['id'] = $key;
			} else {
				$data['id'] = "";
			}							
		}
		$data['userData'] = $this->manager_model->findUserDetails($user->id);
		$data['all_users'] = $this->manager_model->getAllActiveUsersByType(1);		
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->render('manager/start',$data);
	}
	
	function profile(){
		$data = array();
		$success = 0;
		if(isset($_POST) && count($_POST)>0){
			$user = $this->session->userdata('miner');
			if((int)$user->id>0){
				$userPostData = $this->input->post('profile');
				if(isset($userPostData['password']) && empty($userPostData['password'])){
					unset($userPostData['password']);
				}
				$this->load->model('outsource_model');
				$success = $this->outsource_model->updateProfile($userPostData,$user->id);
			}			
		}
		if($success==1){
			$data = array('success'=>'Profile updated!');
		} else {
			$data = array('success'=>'','error'=>'Error!');
		}
		echo json_encode($data);
		die;
	}
	
	function find_user_data(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			if(isset($postData['l']) && (int)$postData['l'] && isset($postData['key']) && !empty($postData['key'])){
				$this->load->model('outsource_model');
				$decryptKey = explode('~',$postData['key']);
				if(count($decryptKey)==2){				
					$projectID = $decryptKey[1];				
					$checkProject = $this->outsource_model->findProjectWithEncryptID($projectID);
					if(count($checkProject)>0){
						$data = $this->outsource_model->findUserData($checkProject->id,$postData['l']);
					}							
				}				
			}			
		}		
		echo json_encode($data);
		die;
	}
	
	function u_singleton(){
		$success = 0;
		if(isset($_POST) && count($_POST)>0){
			$key = $this->input->post('key');
			$free_ride = $this->input->post('free_ride');
			$postData = $this->input->post('enter_data');
			if(!empty($key)){
				$decryptKey = explode('~',$key);
				if(count($decryptKey)==2){
					$this->load->model('outsource_model');
					$projectID = $decryptKey[1];
					$getDetailsOfProject = $this->outsource_model->findProjectFullDetailWithColumnsEncryptID($projectID);
					if(count($getDetailsOfProject['project_details'])>0 && count($getDetailsOfProject['column_heading'])>0){
						$dataEnter = false;
						$row = (int)$postData[0] + 1;
						$col = (int)$postData[1] + 1;
						if(count($getDetailsOfProject['column_heading'])>0){
							foreach($getDetailsOfProject['column_heading'] as $heading){
								if((int)$heading->status==1 && (int) $heading->column_num==$col){
									$dataEnter=true;
								}
							}											
						}
						if($dataEnter===true){							
							/*$findData = $this->outsource_model->findProjectDataWithRowColOpen($row,$col,$getDetailsOfProject['project_details']->id);*/
							$findData = $this->outsource_model->findProjectDataWithRowColByIDByEd($free_ride,$getDetailsOfProject['project_details']->id);
							if(count($findData)>0){
								$postformData = trim($postData[3]);
								/*Put in history*/
								$user = $this->session->userdata('manager');
								$history = (array)$findData;
								$history['update_by'] = $user->id;
								$history['update_date'] = date('Y-m-d H:i:s');
								unset($history['id']);
								$this->outsource_model->uploadDataToDropHistory($history);
								$success = $this->outsource_model->updateFormData(array('pass'=>0,'enter_by'=>'Free','recorded_date'=>'0000-00-00 00:00:00'),$findData->id);
								$findUserErrors = $this->outsource_model->findUserError($findData->user_id);
								if(count($findUserErrors)==0){
									$this->outsource_model->insertError(array('user_id'=>$findData->user_id,"counter"=>1));
								} else {
									$this->outsource_model->updateError(array('user_id'=>$findData->user_id,"counter"=>$findUserErrors->counter + 1),$findUserErrors->id);
								}
								$checkCol = $this->outsource_model->checkColumnByProject($findData->user_id,$col,$getDetailsOfProject['project_details']->id);
								if(count($checkCol)>0){
									$this->outsource_model->updateProjectColUserAmount(array('count'=>$checkCol->count - 1),$checkCol->id);
								}		
							}
						}
					}
				}
			}
		}
		if($success==1){
			echo json_encode(array('verified'=>1,'changes'=>$postData));
		} else {
			echo json_encode(array('error'=>1,'changes'=>$postData));
		}
		die;
	}
	
	function update_data(){
		$success = 0;
		if(isset($_POST) && count($_POST)>0){
			$data = $this->input->post('dataentry');
			if(!empty($data['key'])){
				$decryptKey = explode('~',$data['key']);
				if(count($decryptKey)==2){
					$this->load->model('outsource_model');
					$projectID = $decryptKey[1];
					$getDetailsOfProject = $this->outsource_model->findProjectFullDetailWithColumnsEncryptID($projectID);
					if(count($getDetailsOfProject['project_details'])>0 && count($getDetailsOfProject['column_heading'])>0){
						$user = $this->session->userdata('manager');
						/*find All  dataentry data*/
						$getListUserData = $this->outsource_model->findFilledDataByUser($getDetailsOfProject['project_details']->id);
						if(count($getListUserData)>0){
							$this->load->model('client_model');
							foreach($getListUserData as $contact){
								switch((int)$contact->col){
									case 5:
										$success = $this->client_model->update($contact->contact_id,array('email'=>$contact->data,'new_email'=>1));
									break;
									case 6:
										$success = $this->client_model->update($contact->contact_id,array('phone'=>$contact->data,'new_phone'=>1));
									break;
									case 7:
										$success = $this->client_model->update($contact->contact_id,array('telephone'=>$contact->data,'new_phone'=>1));
									break;
									case 8:
										$success = $this->client_model->update($contact->contact_id,array('linkedin_url'=>$contact->data,'new_linkedin'=>1));
									break;
								}
							}
						}
					}
				}
			}
		}
		echo $success;
		die;
	}

}
/* End of file manager_dataentry.php */
/* Location: ./application/controllers/manager_dataentry.php */