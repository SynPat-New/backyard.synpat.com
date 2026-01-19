<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Outsource_Dataentry extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$data = $this->session->userdata('miner');
		if (!$this->session->userdata('miner')){
				redirect('outsource/login');
		}		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));		
	}

	function index(){
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->load->model('outsource_model');
		$user = $this->session->userdata("miner");
		$data['my_projects'] = $this->outsource_model->findUserProjectByUserID($user->id);
		$this->layout->render('outsource/dataentry/index',$data);
	}
	
	function logout(){
		$this->session->sess_destroy();
		session_destroy();
		if(!isset($_SESSION)){
			session_start();
		}
		unset($_SESSION['user_show_me']);
		redirect('outsource/login');
	}
	
	function ws_data(){
		require(APPPATH.'third_party/push/autoload.php');
		$options = array(
			'cluster' => 'eu','host'=>'api-eu.pusher.com',
			'encrypted' => true
		  );
		 $pusher = new Pusher('11f422c81016234a51c8','7247daa528abdcbb68c4','221679',$options);
		 $getData = array('sd'=>$_POST['sd'],'r'=>$_POST['r'],'c'=>$_POST['c'],'s'=>$_POST['s'],'socket_id'=>$_POST['socket_id']);
		 $data['message'] = $getData;
		 $socket_id = $_POST[ 'socket_id' ];
		 $response = $pusher->trigger('my-channel', 'my_event', $data, $socket_id, true);
		 print_r($response );
		 die;
	}
	
	function show_me(){
		if(isset($_POST)){
			if(!isset($_SESSION)){
				session_start();
			}
			$_SESSION['user_show_me']=0;
		}
		die;
	}
	
	function temp_project($key=null){
		$user = $this->session->userdata('miner');
		$this->load->model('outsource_model');
		/*$data['my_projects'] = $this->outsource_model->findUserProjectByUserID($user->id);*/
		$data['my_projects'] = $this->outsource_model->findAllProjects();
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
			if(count($getDetailsOfProject['project_details'])>0){
				$data['full_project_details'] = $getDetailsOfProject;
				$projectsEntry = $this->outsource_model->getUserEntryProjects($user->id);
				$data['find_my_all_projects'] = $projectsEntry;
				
				/*$data['find_my_current_month_entry'] = $projectsEntry['current_project'];
				$data['find_all_project_entry'] = $projectsEntry['all_project'];*/
				$data['transactions'] = $this->outsource_model->findUserTransactions($user->id);
				$data['user_rejected_data'] = $this->outsource_model->findUserRejectedData($user->id,$getDetailsOfProject['project_details']->id);
				$data['id'] = $key;	
			} else {
				$data['project_details'] = array();
				$data['column_heading'] = array();
				$data['project_data'] = array();
				$data['find_my_all_projects'] = array();
				$data['find_my_current_month_entry'] = array();
				$data['find_all_project_entry'] = array();
				$data['transactions'] = array();
				$data['user_rejected_data'] = array();
				$data['id'] = "";
			}			
		}
		$data['userData'] = $this->outsource_model->findUserDetails($user->id);		
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->render('outsource/dataentry/start',$data);
	}
	
	function start_project($key=null){
		$user = $this->session->userdata('miner');
		$this->load->model('outsource_model');
		/*$data['my_projects'] = $this->outsource_model->findUserProjectByUserID($user->id);*/
		$data['my_projects'] = $this->outsource_model->findAllProjects();
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
			if(count($getDetailsOfProject['project_details'])>0){
				$data['full_project_details'] = $getDetailsOfProject;
				$projectsEntry = $this->outsource_model->getUserEntryProjects($user->id);
				$data['find_my_all_projects'] = $projectsEntry;
				/*$data['find_my_current_month_entry'] = $projectsEntry['current_project'];
				$data['find_all_project_entry'] = $projectsEntry['all_project'];*/
				$data['transactions'] = $this->outsource_model->findUserTransactions($user->id);
				$data['user_rejected_data'] = $this->outsource_model->findUserRejectedData($user->id,$getDetailsOfProject['project_details']->id);
				$data['id'] = $key;	
			} else {
				$data['project_details'] = array();
				$data['column_heading'] = array();
				$data['project_data'] = array();
				$data['find_my_all_projects'] = array();
				$data['find_my_current_month_entry'] = array();
				$data['find_all_project_entry'] = array();
				$data['transactions'] = array();
				$data['user_rejected_data'] = array();
				$data['id'] = "";
			}			
		}
		$data['userData'] = $this->outsource_model->findUserDetails($user->id);		
		$data['my_error'] = $this->outsource_model->findUserError($user->id);
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->render('outsource/dataentry/start',$data);
	}
	
	function mydata($key=null){
		$user = $this->session->userdata('miner');
		$this->load->model('outsource_model');
		$data['my_projects'] = $this->outsource_model->findAllProjects();
		$decryptKey = explode('~',$key);
		if(count($decryptKey)==2){				
			$projectID = $decryptKey[1];	
			$getDetailsOfProject = $this->outsource_model->findProjectFullDetailWithColumnsEncryptID($projectID,$user->id);
			if(count($getDetailsOfProject['project_details'])>0){
				$data['full_project_details'] = $getDetailsOfProject;
				$projectsEntry = $this->outsource_model->getUserEntryProjects($user->id);
				$data['find_my_all_projects'] = $projectsEntry;
				$data['transactions'] = $this->outsource_model->findUserTransactions($user->id);
				$data['user_rejected_data'] = $this->outsource_model->findUserRejectedData($user->id,$getDetailsOfProject['project_details']->id);
				$data['id'] = $key;	
			} else {
				$data = array('project_details'=>array(),'column_heading'=>array(),'project_data'=>array());
				$data['find_my_all_projects'] = array();
				$data['find_my_current_month_entry'] = array();
				$data['find_all_project_entry'] = array();
				$data['transactions'] = array();
				$data['user_rejected_data'] = array();
				$data['id'] = "";
			}			
		}
		$data['userData'] = $this->outsource_model->findUserDetails($user->id);		
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->render('outsource/dataentry/mydata',$data);
	}
	
	function dialer_list(){
		$user = $this->session->userdata('miner');
		$this->load->model('outsource_model');
		$data['phone_list'] = $this->outsource_model->findCallingDataForDialer();
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->render('outsource/dataentry/dialer',$data);
	}
	
	function updateDropHistory(){
		$data = 0;
		if(isset($_POST)){
			$dataID = $this->input->post('id');
			$this->load->model('outsource_model');
			$data = $this->outsource_model->updateDropHistory(array('status'=>1),$dataID);
		}
		echo $data;
		die;
	}
	
	function call_verified(){
		$data = array('row'=>0,'status'=>'','verified'=>0);
		if(isset($_POST) && count($_POST)>0){
			$data = $this->input->post();
			$status = 0;
			
			switch($data['status']){
				case 'gold':
					$status = 1;
				break;
				case 'correct':
					$status = 2;
				break;
				case 'wrong':
					$status = 3;
				break;
				case 'not-answer':
					$status = 4;
				break;
			}
			$this->load->model('outsource_model');
			$findData = $this->outsource_model->findProjectDataWithId($data['row']);
			$user = $this->session->userdata('miner');
			if(count($findData)>0){
				if($status == 3){
					/*put data to history table and then clean data from main table i.e project_data */				
					$insertToHistoryTable = (array)$findData;
					$insertToHistoryTable['update_by'] = $user->id;
					$insertToHistoryTable['update_date'] = date('Y-m-d H:i:s');
					$this->outsource_model->uploadDataToDropHistory($insertToHistoryTable);
					$data['verified'] = $this->outsource_model->updateFormData(array('status'=>$status,'data'=>'','enter_by'=>'Free'),$data['row']);
				} else {
					$data['verified'] = $this->outsource_model->updateFormData(array('status'=>$status),$data['row']);
				}
			}						
			if(isset($data['verified']) && $data['verified']>0){
				/*Save verified by which user*/
				$checkCol = $this->outsource_model->checkColumnByProject($user->id,$findData->col,$findData->id);
				if(count($checkCol)==0){
					$this->outsource_model->insertProjectColUserAmount(array('user_id'=>$user->id,'col'=>$col,'count'=>1,'recorded_date'=>date('Y-m-d H:i:s'),'project_id'=>$findData->id));
				}else {
					$this->outsource_model->updateProjectColUserAmount(array('count'=>$checkCol->count + 1),$checkCol->id);
				}
				/**/
			}
			echo json_encode($data);
		}
		die;
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
						$user = $this->session->userdata('miner');						
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
							$findData = $this->outsource_model->findProjectDataWithRowColByID($free_ride,$getDetailsOfProject['project_details']->id);
							if(count($findData)>0){
								$postformData = trim($postData[3]);
								if(!empty($postformData)){
									$enterCheck = true;
									if((int)$findData->col==6 || (int)$findData->col==7){
										$checkEntry = $this->outsource_model->checkPhoneEntry($postformData);
										if(count($checkEntry)>0){
											$enterCheck = false;
										}
									}
									if($enterCheck===true){
										$success = $this->outsource_model->updateFormData(array('data'=>$postformData,'enter_by'=>'User','user_id'=>$user->id,'pass'=>1,'recorded_date'=>date('Y-m-d H:i:s')),$findData->id);
										if((int)$findData->col==5){
											/*Enter in Email Verifier*/
											$emailVerifies = $findData;
											$emailVerifies->record_id = $emailVerifies->id;
											$emailVerifies->data = $postformData;
											$emailVerifies->user_id = $user->id;
											$emailVerifies->enter_by = "User";
											unset($emailVerifies->id);
											unset($emailVerifies->contact_id);
											unset($emailVerifies->recorded_date);
											unset($emailVerifies->message_id);
											unset($emailVerifies->pass);
											unset($emailVerifies->status);
											$this->outsource_model->insertEmailVerifier($emailVerifies);
										}
										$checkCol = $this->outsource_model->checkColumnByProject($user->id,$col,$getDetailsOfProject['project_details']->id);
										if(count($checkCol)==0){
											$this->outsource_model->insertProjectColUserAmount(array('user_id'=>$user->id,'col'=>$col,'count'=>1,'recorded_date'=>date('Y-m-d H:i:s'),'project_id'=>$getDetailsOfProject['project_details']->id));
										}else {
											$this->outsource_model->updateProjectColUserAmount(array('count'=>$checkCol->count + 1),$checkCol->id);
										}
									}																
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
	
	
	function check_email() {
		$success = 0;
		if(isset($_POST) && count($_POST)>0){
			$key = $this->input->post('key');
			$postData = $this->input->post('enter_data');
			$domain = "sandbox16993e3c0bb4463c806e1bc5d0e80167.mailgun.org";
			$ch = curl_init();
			$to = $postData[3];
			$message = "Congratulation";
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch, CURLOPT_USERPWD, 'api:key-3cf64d493227e4799da49c3d32bcdfd0');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			$plain = strip_tags(nl2br($message));
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
			curl_setopt($ch, CURLOPT_POSTFIELDS, array('from'    => 'Mailgun Sandbox <postmaster@sandbox16993e3c0bb4463c806e1bc5d0e80167.mailgun.org>',
				'to' => $to,
				'subject' => "Offer",
				'text' => $plain));
			$j = json_decode(curl_exec($ch));
			$info = curl_getinfo($ch);
			curl_close($ch);
			if($info['http_code'] == 200){
				if(!empty($key)){
					$decryptKey = explode('~',$key);
					if(count($decryptKey)==2){
						$this->load->model('outsource_model');
						$projectID = $decryptKey[1];
						$getDetailsOfProject = $this->outsource_model->findProjectFullDetailWithColumnsEncryptID($projectID);
						if(count($getDetailsOfProject['project_details'])>0 && count($getDetailsOfProject['column_heading'])>0){
							$user = $this->session->userdata('miner');						
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
								$findData = $this->outsource_model->findProjectDataWithRowCol($row,$col,$getDetailsOfProject['project_details']->id);
								if(count($findData)>0){
									$postformData = trim($postData[3]);
									if(!empty($postformData)){
										$success = $this->outsource_model->updateFormData(array('data'=>$postformData,'enter_by'=>'User','user_id'=>$user->id,'recorded_date'=>date('Y-m-d H:i:s'),'message_id'=>$j->id),$findData->id);
										/*$this->outsource_model->insertProjectColUserAmount(array('user_id'=>$user->id,'col'=>$col,'recorded_date'=>date('Y-m-d H:i:s'),'project_id'=>$getDetailsOfProject['project_details']->id));*/
										$checkCol = $this->outsource_model->checkColumnByProject($user->id,$col,$getDetailsOfProject['project_details']->id);
										if(count($checkCol)==0){
											$this->outsource_model->insertProjectColUserAmount(array('user_id'=>$user->id,'col'=>$col,'count'=>1,'recorded_date'=>date('Y-m-d H:i:s'),'project_id'=>$getDetailsOfProject['project_details']->id));
										}else {
											$this->outsource_model->updateProjectColUserAmount(array('count'=>$checkCol->count + 1),$checkCol->id);
										}	
										
										/*
										$this->load->model('client_model');
										$this->client_model->update($findData->contact_id,array('email'=>$postformData,'new_email'=>1));*/
									}
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
			echo json_encode(array('email_error'=>1,'changes'=>$postData,'email'=>$postData[3]));
		}
		die;
	}
	
	function check_bounce_emails(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$key = $this->input->post('key');
			$decryptKey = explode('~',$key);
			if(count($decryptKey)==2){
				$this->load->model('outsource_model');
				$projectID = $decryptKey[1];
				$getDetailsOfProject = $this->outsource_model->findProjectFullDetailWithColumnsEncryptID($projectID);
				if(count($getDetailsOfProject['project_details'])>0 && count($getDetailsOfProject['column_heading'])>0){
					$user = $this->session->userdata('miner');
					$data['get_all_bounce_emails'] = $this->outsource_model->checkAllBounceEmailByProjectIDAndUserID($getDetailsOfProject['project_details']->id,$user->id);
				}
			}
		}
		echo json_encode($data);
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
						$user = $this->session->userdata('miner');
						$postData = $data['put'];
						if(!empty($postData) && $postData!="dataentry"){
							$dataOnPost = json_decode($postData,true);
							if(count($dataOnPost)>0){
								$row=0;
								for($i=0;$i<count($dataOnPost);$i++){
									$row = $i+1;
									$col=0;
									for($j=0;$j<count($dataOnPost[$i]);$j++){
										$col = $j+1;
										$dataEnter = false;
										if(count($getDetailsOfProject['column_heading'])>0){
											foreach($getDetailsOfProject['column_heading'] as $heading){
												if((int)$heading->status==1 && (int) $heading->column_num==$col){
													$dataEnter=true;
												}
											}											
										}
										if($dataEnter===true){
											$findData = $this->outsource_model->findProjectDataWithRowCol($row,$col,$getDetailsOfProject['project_details']->id);
											if(count($findData)>0){
												$postformData = trim($dataOnPost[$i][$j]);
												if(!empty($postformData)){
													$success = $this->outsource_model->updateFormData(array('data'=>$postformData,'enter_by'=>'User','user_id'=>$user->id,'recorded_date'=>date('Y-m-d H:i:s')),$findData->id);
												}
											}
										}
									}
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
/* End of file dataentry.php */
/* Location: ./application/controllers/outsource/dataentry.php */