<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public $skey = "sYnP@TpRoJ3cT5@%";	
	function __construct(){
		parent::__construct();
		$this->load->library('DriveServiceHelper');
		$service = new GmailServiceHelper();
		if(empty($this->session->userdata('email'))){
			if(!isset($_SESSION)){
				session_start();
			}
			if(isset($_SESSION['find_user']) && !empty($_SESSION['find_user']['type'])){
				$this->session->set_userdata($_SESSION['find_user']);
			} else {
				redirect('login');
			}
		}		
		$this->layout->auto_render=false;
		$this->layout->layout='default';
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
	
	function updateLEadButtonsOnFly(){
		$this->load->model('general_model');
		$this->load->model('lead_model');
		$getButtonList = $this->general_model->getAllButtonList("Market");
		if(count($getButtonList)>0){
			$bulkArray = array();
			foreach($getButtonList as $button){				    /*$this->lead_model->insertLeadButton(array("lead_id"=>$lead_id,"sort"=>$button->sort,"button_id"=>$button->id));*/
				$bulkArray[] = array("lead_id"=>"498","sort"=>$button->sort,"button_id"=>$button->id);
			}
			/*Insert Bulk*/
			$this->lead_model->insertLeadButtonBulk($bulkArray);
		}
		die;
	}
	
	function lead_invitees_customer_list(){
		$this->load->model('lead_model');
		$data = array('list'=>array());
		/*if(isset($_POST) && count($_POST)>0){
			$data['list'] = $this->lead_model->getPOSAgreementsWithCustomer($this->input->post('lead'));			
		}*/
		$data['list'] = $this->lead_model->getCustomerDealFlow();
		echo json_encode($data);
		die;
	}
	
	function all_leads_licenses(){
		$this->load->model('lead_model');
		$data = array('list'=>array());		
		$data['list'] = $this->lead_model->getAllCustomerLicense();
		echo json_encode($data);
		die;
	}
	
	function deleteFileFromDealFlow(){
		$data = array('id'=>0);
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();
			$this->load->model('lead_model');
			$getDealFlowData = $this->lead_model->findDealFlowDataByID($post['id']);
			if(count($getDealFlowData)>0){
				
			}
			$data['id'] = $this->lead_model->updateCustomerDealFlow($dataUpdateArray,$post['id']);
		}
		echo json_encode($data);
		die;
	}
	
	function attach_file_deal_flow(){		
		$data = array('id'=>0);
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();
			if(isset($post['d']) && $post['d']==1){
				$data['d'] = 1;
			}
			$dataUpdateArray = array();
			switch($post['p']){
				case 1:
					$dataUpdateArray['syndication'] = $post['f'];
					$dataUpdateArray['syndication_filename'] = $post['n'];
				break;
				case 2:
					$dataUpdateArray['executed_by_synpat'] = $post['f'];
					$dataUpdateArray['synpat_filename'] = $post['n'];
				break;
				case 3:
					$dataUpdateArray['executed_by_customer'] = $post['f'];
					$dataUpdateArray['customer_filename'] = $post['n'];
				break;
			}
			if(count($dataUpdateArray)>0 && $post['id']>0){
				$this->load->model('lead_model');
				if(($post['p']==2 || $post['p']==3) && $post['f']==""){
					$oldDealFlowData = $this->lead_model->findDealFlowDataByID($post['id']);
				}
				$data['id'] = $this->lead_model->updateCustomerDealFlow($dataUpdateArray,$post['id']);
				if($post['p']==2){
					$getDealFlowData = $this->lead_model->findDealFlowDataByID($post['id']);
					if(count($getDealFlowData)>0){
						if($post['f']!=""){
							$this->lead_model->insertPosAgreement(array('lead_id'=>$getDealFlowData->lead_id,'customer_id'=>$getDealFlowData->customer_id,'type'=>1,'file_type'=>$getDealFlowData->license_type,'file'=>$getDealFlowData->executed_by_synpat,'executed_date'=>date('Y-m-d H:i:s')));						
						} else {
							/*delete in pos agreement*/
							$this->lead_model->deletePosAgreementByUrl($oldDealFlowData->executed_by_synpat);
						}
					}
				}
				/*Insert in License Agreement*/
				if($post['p']==2 || $post['p']==3){
					if($post['p']==3){
						$getDealFlowData = $this->lead_model->findDealFlowDataByID($post['id']);
					}
					if(count($getDealFlowData)>0){
						$findCustomerData = $this->lead_model->getCustomerInfoByID($getDealFlowData->customer_id,"company_id");
						if(count($findCustomerData)>0){						
							/*Find Stage and Price*/
							$acquisitionData = $this->lead_model->getAcquisitionData($getDealFlowData->lead_id,"a.active_button,a.cost_price");
							if(count($acquisitionData)>0){
								$findLicenseAgreement = array();
								if($post['f']!=''){
									$findLicenseAgreement = $this->lead_model->findLicenseAgreementByFileUrl($getDealFlowData->executed_by_synpat);
									$fileUrl = "";
									$documentName = "";
									if($post['p']==2){
										$fileUrl = $getDealFlowData->executed_by_synpat;
										$documentName = $getDealFlowData->synpat_filename;
									} else if($post['p']==3){
										$fileUrl = $getDealFlowData->executed_by_customer;
										$documentName = $getDealFlowData->customer_filename;
									}
								}
								
								if($post['f']=="" && (int)$post['p']==2){
									/*Delete*/
									if(isset($oldDealFlowData) && count($oldDealFlowData)>0){
										$this->lead_model->deleteFromCustomerLicenseAgreementByUrl($oldDealFlowData->executed_by_synpat);
									}
								} else {
									$companyID = 0;
									if($getDealFlowData->company_id > 0 && $getDealFlowData->license_type == 3){
										$getCompanyName = $this->lead_model->findCompanyData($getDealFlowData->company_id);
										if(count($getCompanyName)>0){
											$companyID = $getCompanyName->id;
										}
									} else if( $getDealFlowData->license_type == 2){
										$getCompanyName = $this->lead_model->findCompanyData($findCustomerData->company_id);
										if(count($getCompanyName)>0){
											$companyID = $getCompanyName->id;
										}
									}
									if($companyID > 0){
										if(count($findLicenseAgreement)>0){
											/*Update*/
											$this->lead_model->updateCustomerLicenseAgreementByID(array('date'=>date('Y-m-d H:i:s'),'document'=>$fileUrl,'target_company_id'=>$companyID),$findLicenseAgreement->id);
										} else {
											/*Insert*/
											$price = $acquisitionData->cost_price;
											if((int)$acquisitionData->active_button==2){
												$price = round(1.5*$acquisitionData->cost_price, 3,PHP_ROUND_HALF_UP);
											}else if((int)$acquisitionData->active_button==3){
												$price = round(3*$acquisitionData->cost_price, 3,PHP_ROUND_HALF_UP);
											}
											if($price > 0){
												$licenseData = array('lead_id'=>$getDealFlowData->lead_id,'company_id'=>$findCustomerData->company_id,'file_type'=>$getDealFlowData->license_type,'target_company_id'=>$companyID,'price'=>$price,'date'=>date('Y-m-d H:i:s'),'stage'=>$acquisitionData->active_button,'document'=>$fileUrl,'document_name'=>$documentName);
												$this->lead_model->insertCustomerLicenseAgreement($licenseData);
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
		echo json_encode($data);
		die;
	}
	
	function attach_pos_file_customer(){
		$this->load->model('lead_model');
		$data = array('id'=>0);
		if(isset($_POST) && count($_POST)>0){
			$data['id'] = $this->lead_model->insertPosAgreement(array('lead_id'=>$this->input->post('lead'),'customer_id'=>$this->input->post('co'),'type'=>1,'file_type'=>$this->input->post('p'),'file'=>$this->input->post('f'),'executed_date'=>date('Y-m-d H:i:s')));
			/*if($data['id']>0){
				$licenseData = $this->lead_model->findLicenseFromLeadID($this->input->post('lead'),'li.id');
				$getContactDetail = $this->lead_model->getContactById($this->input->post('c'),"c.*,co.company_name");
				if(count($getContactDetail)>0 && count($licenseData)>0){
					$name = $getContactDetail->first_name." ".$getContactDetail->last_name;
					$phone = "";
					if($getContactDetail->phone!=""){
						$phone = $getContactDetail->phone;
					} else if($getContactDetail->telephone!=""){
						$phone = $getContactDetail->telephone;
					}
					$type = 0;
					switch($this->input->post('p')){
						case 1:
							$type = 5;
						break;
						case 2:
							$type = 6;
						break;
						case 3:
							$type = 7;
						break;
					}
					$this->lead_model->insertPotentialParticipant(array('license_id'=>$licenseData->id,'customer_id'=>$this->input->post('c'),'company_name'=>$getContactDetail->company_name,'person_name'=>$name,'person_phone'=>$phone,'person_email'=>$getContactDetail->email,'message'=>'','file'=>$this->input->post('f'),'price'=>'0.0','type'=>$type,'create_date'=>date('Y-m-d H:i:s')));
				}				
			}*/
		}
		echo json_encode($data);
		die;
	}
	
	function add_notification_data(){
		require(APPPATH.'third_party/push/autoload.php');
		$this->config->load('config');
		$options = array('encrypted' => true,'cluster' => $this->config->item('APP_CLUSTER'),'host'=>$this->config->item('APP_CLUSTER_HOST'));
		$pusher = new Pusher($this->config->item('PUSHER_APP_ID'),$this->config->item('PUSHER_APP_KEY'),$this->config->item('PUSHER_APP_SECRET'),$options);
		$data['message'] = 'hello world';
		$pusher->trigger('notifications', 'new_notification', $data);
		die;
	} 
	
	function checking_image_shown(){
		$data = array('id'=>0,'job_id'=>0,'data'=>array());
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('customer_model');
			$data['job_id'] = $this->input->post('job_id');
			$checkConnection = $this->customer_model->getCaptchaImage($this->input->post('job_id'));
			if(count($checkConnection['details'])>0){
				$data = array('id'=>1,'data'=>$checkConnection['details']);
			}
			if($checkConnection['count']>0){
				$data['id'] = $checkConnection['count'];
			}
		}
		echo json_encode($data);
		die;
	}
	
	function job_queue_family_tree(){
		$data = array('id'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			if($this->input->post('l')>0){
				$findParentPatentTable = $this->lead_model->getLeadPatentList($this->input->post('l'));
				if(count($findParentPatentTable)>0){
					/*Insert Job Queue*/
					$data['id'] = $this->lead_model->insertJobQueue(array('user_id'=>$this->session->userdata['id'],'module_name'=>'Family_Tree','type'=>'Family_Tree','account'=>$this->input->post('l')));
				}
			}			
		}
		echo json_encode($data);
		die;
	}
	
	function uspto_captcha_code(){
		$data = array('id'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('customer_model');
			$data['id'] = $this->customer_model->updateCaptchaCode(array('code'=>$this->input->post('code'),'status'=>1),$this->input->post('id'));
		}
		echo json_encode($data);
		die;
	}
		
	function run_process_single(){
		$this->load->model('lead_model');
		$data= array();
		if(isset($_POST) && count($_POST)>0 && isset($_POST['email']) && !empty($_POST['email'])){
			$data  = $this->lead_model->getCampaignListByEmailInProccess($_POST['email'],$_POST['campaign_id']);
		}		
		echo json_encode($data);
		die;
	}
	
	function run_process(){
		$this->load->model('lead_model');
		$data = $this->lead_model->getRecentCampaignProcess();
		echo json_encode($data);
		die;
	}
	
	function activityLog($activityLog){
		if(isset($activityLog['task_id'])){
			unset($activityLog['task_id']);
		}
		if(isset($activityLog['next_call_date'])){
			unset($activityLog['next_call_date']);
		}
		if(isset($activityLog['c_id'])){
			unset($activityLog['c_id']);
		}
		if(isset($activityLog['p_id'])){
			unset($activityLog['p_id']);
		}
		$this->load->model('lead_model');
		$this->lead_model->insertActivityLog($activityLog);	
	}
	
	public function sales_activity_email_save(){
		$showData = array('email_id'=>0); 
		if(isset($_POST) && count($_POST)>0){			
			if(isset($_POST['lead_id']) && (int)$_POST['lead_id']>0){
				if(isset($_POST['address'])){
					$to = trim($_POST['address']);
					if(!empty($to)){
						$message = "";
						$this->load->model('client_model');
						if((int)$_POST['type']==3){
							$getContact = $this->client_model->find_contact_by_email($to);
							$message = "Sales activity for email.";
						} else {
							$getContact = $this->client_model->find_contact_by_linkedin($to);
							$message = "Sales activity for linkedin.";
						}
						
						if(count($getContact)){
							$note = '';
							$subject = '';							
							if(isset($_POST['subject'])){
								$subject = $_POST['subject'];
							}
							$date = $this->input->post('campaign_date');
							$email_id = 0 ;
							$enter= true;
							if((int)$_POST['type']==3){
								/*$send = $this->findEmailImapSendBox(1,$subject,array($to,""),$date,$_POST['lead_id'],1,1,$_POST['user_id']);*/
								$send = $this->searchImapEmails(1,$subject,array($to,""),$date,$_POST['lead_id'],1,1,$_POST['user_id']);
								$dataSend = json_decode($send,true);
								if(isset($dataSend['send'])){
									$email_id = $dataSend['send'];
								} else if(isset($dataSend->send)){
									$email_id = $dataSend->send;
								}
							}
							$this->load->model('lead_model');
							if($email_id>0){
								$date = $this->lead_model->findEmailDate($email_id);
							}	
							
							$saveData = array('lead_id'=>$_POST['lead_id'],'company_id'=>$getContact->company_id,'contact_id'=>$getContact->id,'type'=>$_POST['type'],'note'=>$note,'user_id'=>$_POST['user_id'],'subject'=>$subject,'activity_date'=>$date,"email_id"=>$email_id);		
							
							if((int)$_POST['main_activity']==2){
								$data = $this->lead_model->insertAcquistionActivity($saveData);
							} else if((int)$_POST['main_activity']==3){
								$saveData['company_id'] = $_POST['pre_co_id'];
								$data = $this->lead_model->insertPreSaleActivity($saveData);
							} else {
								/*$saveData['note'] = '<div>'.$note.'</div>';*/
								$data = $this->lead_model->insetSalesActivity($saveData);
							}
								/*Open Task*/
							$this->activityLog($saveData);	
							if($email_id>0){
								$showData = $saveData;
								$showData['email_id'] = $email_id;
								$showData['note'] = "Open Task";
								$showData['type'] = 2;
							}
							
							if($data>0){
								$this->lead_model->updateCampaignList($_POST['campaign_id'],$to,array('send'=>1,'proccessed'=>1));
								$this->load->model('user_model');
								$user_history = array('lead_id'=>$_POST['lead_id'],'user_id'=>$_POST['user_id'],'message'=>$message,'opportunity_id'=>0,'create_date'=>$date);
								$this->user_model->addUserHistory($user_history);
							}							
						}
					}
				}
			}
		}
		echo json_encode($showData);
		die;
	}
	
	function open_activity_from_campaign_process(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			if(isset($postData['email_id']) && (int)$postData['email_id']>0){
				unset($postData['email_id']);
				$postData['activity_date'] = date('Y-m-d H:i:s');
				$postData['next_call_date'] = date('Y-m-d H:i:s');
				$this->load->model('lead_model');
				$data = $this->lead_model->insetSalesActivity($postData);
			}
		}
		echo $data;
		die;
	}
	
	function open_activity_from_campaign_after_send(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			if(isset($postData['send']) && (int)$postData['send']>0){
				$this->load->model('lead_model');
				$findLogDetail = $this->lead_model->findCallActivityLogByEmailID($postData['send']);
				if(count($findLogDetail)>0){
					$showData = array('lead_id'=>$findLogDetail->lead_id,'company_id'=>$findLogDetail->company_id,'contact_id'=>$findLogDetail->contact_id,'type'=>2,'note'=>"Open Task",'user_id'=>$postData['user_id'],'subject'=>$findLogDetail->subject,'activity_date'=>$findLogDetail->activity_date,'next_call_date'=>$findLogDetail->activity_date,"email_id"=>$postData['send']);
					if($postData['main_activity']==2){
						$data = $this->lead_model->insertAcquistionActivity($showData);						
					} else {
						$data = $this->lead_model->insetSalesActivity($showData);
					}
				}
			}
		}
		echo $data;
		die;
	}
	
	function end_campaign_process(){
		$data = array('lead_id','update');
		if(isset($_POST) && count($_POST)>0 && $_POST['process_id']>0){
			$this->load->model('lead_model');
			$data['lead_id']= $this->lead_model->findLeadIdFromProcess($_POST['process_id']);
			$data['update'] = $this->lead_model->deleteCampaignProcess($_POST['process_id']);
		}
		echo json_encode($data);
		die;
	}
	
	function log_user_history(){
		$data =0;
		if(isset($_POST) && count($_POST)>0){
			$user_history = array('lead_id'=>$_POST['lead_id'],'user_id'=>$this->session->userdata['id'],'message'=>$_POST['message'],'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
			$this->load->model('user_model');
			$data = $this->user_model->addUserHistory($user_history);
		}
		echo $data;
		die;
	}
	
	function update_sales_company_stage(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			if((int)$this->input->post('activity')==2){
				$data = $this->lead_model->updateAcquisitionCompanyStage($_POST['lead'],$_POST['c'],array("stage"=>$_POST['s']));
			} else {
				$data = $this->lead_model->updateSalesCompanyStage($_POST['lead'],$_POST['c'],array("stage"=>$_POST['s']));
			}
		}
		echo $data;
		die;
	}
	
	function find_contacts_in_company(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->c_my_contact_list($_POST['c'],"*");
		}
		echo json_encode($data);
		die;
	}
	
		
	function extract_email_address ($string) {
	   $emails = array();
	   $string = str_replace("\r\n",' ',$string);
	   $string = str_replace("\n",' ',$string);

	   foreach(preg_split('/ /', $string) as $token) {
			$email = filter_var($token, FILTER_VALIDATE_EMAIL);
			if ($email !== false) { 
				$emails[] = $email;
			}
		}
		return $emails;
	}
	
	
	
	function sendRequestURL(){
		$data =array();
		if(isset($_POST) && count($_POST)>0){
			if($this->input->post('t')=='c3luUGF0TWFya2V0'){
				if(!isset($_SESSION)){
					session_start();
				}
				$_SESSION['clicked_url']="dashboard";
				unset($_SESSION['clickedd_url']);
				unset($_SESSION['clickedddd_url']);
				$data =array(base64_encode(rand()));
			}
		} 
		echo json_encode($data);
		die;
	}
	
	
	
	function m_time(){
		$start_date = new DateTime($this->session->userdata['login_date']);
		$end_date = new DateTime(date('Y-m-d H:i:s'));
		$interval = $start_date->diff($end_date);
		$hours   = $interval->format('%h'); 
		$minutes = $interval->format('%i');
		echo $hours.":".$minutes;
		die;
	}
	
	function validateDriveFilePermission(){
		if(isset($_POST) && count($_POST)>0){
			$file = $this->input->post('f');
			$file = str_replace("https://docs.google.com/document/d/","",$file);
			$file = str_replace("https://docs.google.com/spreadsheets/d/","",$file);
			$file = str_replace("https://docs.google.com/file/d/","",$file);
			$file = str_replace("https://drive.google.com/file/d/","",$file);
			$file = str_replace("/view?usp=drivesdk","",$file);
			$file = str_replace("/preview","",$file);
			$file = str_replace("/edit?usp=drivesdk","",$file);
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$getFileDetail = $service->getFileInfoWithOptions($file,array('fields'=>'id,mimeType'));
			if($getFileDetail){
				if($getFileDetail->mimeType=="application/vnd.google-apps.spreadsheet"){
					$service->setAdditionalPermissions( $getFileDetail->id, "","writer","anyone");
					/*$service->setAdditionalPermissions( $getFileDetail->id, "","reader","anyone");*/
				} else {
					$service->setAdditionalPermissions($getFileDetail->id,"","reader","anyone");
				}				
			}
		}		
		die;
	}
	
	function lead_patent_data(){
		$data =array('status'=>'',);
		if(isset($_POST) && count($_POST)>0){
			$patent = $this->input->post();
			$this->load->model('lead_model');
			$getLeadData = $this->lead_model->getLeadData($patent['lead_id']);
			if(count($getLeadData)>0){
				$data['status'] = $this->lead_model->from_litigation_update($patent['lead_id'],array('patent_data'=>$patent['patent_data']));
				/*Calculate Data for Chart*/
				$patentData = json_decode($patent['patent_data'],true);
				if(count($patentData)>0 && $patentData[0][0]!=null && trim($patentData[0][0])!=''){
					$technologies = array();
					$technologiesChartData = array();
					$lifeSpan = array();
					$lifeSpanChartData = array();					
					foreach($patentData as $patentsFillData){
						/*if(trim($patentsFillData[1])!=''){
							if(!in_array(trim($patentsFillData[1]),$technologies)){
								$technologies[] = trim($patentsFillData[1]);
								$technologiesChartData[] = array(trim($patentsFillData[1]),1,trim($patentsFillData[2]));
							} else {
								for($i=0;$i<count($technologiesChartData);$i++){
									if($technologiesChartData[$i][0] == trim($patentsFillData[1])){
										$technologiesChartData[$i][1] = (int)$technologiesChartData[$i][1] + 1;
									}
								}
							}
						}*/
						/*Life Span Chart*/
						$currentDate = trim($patentsFillData[8]);
						$expirationDate = date('m/d/Y',strtotime("+20 years",strtotime($currentDate)));	
						if($currentDate!=null && $currentDate!='' && $expirationDate!=null && $expirationDate!=''){
							try{
								$expirationYear = date('Y',strtotime($expirationDate));
								$currentYear = date('Y');
								for($i=$currentYear;$i<=$expirationYear;$i++){
									if(!in_array($i,$lifeSpan)){
										$lifeSpan[] = $i;
										$lifeSpanChartData[] = array($i,1);
									} else {
										for($j=0;$j<count($lifeSpanChartData);$j++){
											if($lifeSpanChartData[$j][0] == $i){
												$lifeSpanChartData[$j][1] = (int)$lifeSpanChartData[$j][1] + 1;
											}
										}
									}
								}
							}catch(Exception $e){
								
							}							
						}
						/*End Life Span*/
					}
					$this->load->model('opportunity_model');
					/*$this->opportunity_model->deleteMiddleChart($patent['lead_id']);
					for($i=0;$i<count($technologiesChartData);$i++){
						if(isset($technologiesChartData[$i]['0']) && !empty($technologiesChartData[$i]['0'])){
							$this->opportunity_model->saveChartMiddle(array('lead_id'=>$patent['lead_id'],'technologies'=>$technologiesChartData[$i]['0'],'data'=>$technologiesChartData[$i]['1'],'tooltip'=>$technologiesChartData[$i]['2']),false);
						}							
					}*/					
					$this->opportunity_model->deleteRightChart($patent['lead_id']);
					for($i=0;$i<count($lifeSpanChartData);$i++){
						if(isset($lifeSpanChartData[$i]['0']) && !empty($lifeSpanChartData[$i]['0'])){
							$this->opportunity_model->saveChartRight(array('lead_id'=>$patent['lead_id'],'Year'=>$lifeSpanChartData[$i]['0'],'data'=>$lifeSpanChartData[$i]['1']),false);
						}							
					}
					$this->load->model('acquisition_model');
					$acquisitionData = $this->acquisition_model->getData($patent['lead_id']);
					if(count($acquisitionData)>0){
						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/license_update_middle_right_charts',
							CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
							CURLOPT_POST => 1,
							CURLOPT_POSTFIELDS => array(
								'license_number' => $acquisitionData['acquisition']->store_name,
								'chart_right' =>json_encode($lifeSpanChartData)
							)
						));
						$resp = curl_exec($curl);	
						
						if($resp){
							/*End API Request*/
							
						}
					}
					
				}
				/*End Calculation*/
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function countFilesInFolder(){
		$data = array("count"=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			/*$filesList = $service->searchFileIDFromChildern($this->input->post('f'));*/
			$q = "'".$this->input->post('f')."' in parents";
			$filesList = $service->getAllFilesAndFolder($q);
			$data['count'] = count($filesList);
		}
		echo json_encode($data);
		die;
	}
	
	function drive_mode(){
		$data =array('status'=>'','url'=>'');
		if(isset($_POST) && count($_POST)>0){
			$driveMode = $this->input->post();
			$this->load->model('lead_model');
			$getLeadData = $this->lead_model->getLeadDataWithOptions($driveMode['l'],'folder_id,lead_name');
			if(count($getLeadData)>0){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$getFileDetail = $service->getFileInfo($driveMode['r']);
				if($getFileDetail){
					$folderID = $getLeadData->folder_id;
					$fileParent = new Google_Service_Drive_ParentReference();
					$fileParent->setId( $folderID );
					$title =  $getFileDetail->title;
					$title = str_replace("Master",$getLeadData->lead_name,$title);
					$title = str_replace("master",$getLeadData->lead_name,$title);
					/*$strPos = stripos($title,"Master");					
					if($strPos!==false){
						$title = substr($title,$strPos);
						$title = str_replace("Master",$getLeadData->lead_name,$title);
						$title = str_replace("master",$getLeadData->lead_name,$title);
						$strPos = stripos($title,$getLeadData->lead_name);
						if($strPos===false){
							$title = $title." - ".$getLeadData->lead_name;
						}
					} else {
						$title = str_replace("Master",$getLeadData->lead_name,$title);
						$title = str_replace("master",$getLeadData->lead_name,$title);
						$strPos = stripos($title,$getLeadData->lead_name);
						if($strPos===false){
							$title = $title." - ".$getLeadData->lead_name;
						}
					}*/
					$getFileInfo = $service->copyFile($getFileDetail->id,$title,$fileParent);
					if(is_object($getFileInfo)){
						if($getFileDetail->mimeType=="application/vnd.google-apps.spreadsheet"){
							$spreadSheet = new SpreadsheetServiceHelper();
							$spreadSheet->protectRange($getFileInfo->id);
						}
						$updateDate = date('Y-m-d H:i:s');
						$leadButtonData = $this->lead_model->findButtonID($driveMode['b'],$driveMode['l']);
						$newStatus = "";
						if(count($leadButtonData)>0){
							$originalButton = $this->lead_model->findOriginalButtonByButtonID($leadButtonData->button_id);
							if(count($originalButton)>0){
								$statusMessage = $originalButton->status_message;
								if($originalButton->blink==1){
									$statusMessage = $originalButton->status_message_click;
								}								
								$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$statusMessage.' <br/>';
								$newStatus = $leadButtonData->status_message_fill.$newStatus;
							}
						} else {
							$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span> <br/>';
						}
						$update = $this->lead_model->updateButton(array('file_url'=>$getFileInfo->alternateLink,'file_name'=>$title,'status'=>1,'update_date'=>$updateDate,'status_message_fill'=>$newStatus),$driveMode['b']);
						$user_history = array('lead_id'=>$driveMode['l'],'user_id'=>$this->session->userdata['id'],'message'=>$newStatus,'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->load->model('user_model');
						$this->user_model->addUserHistory($user_history);
						if($update){
							$data['status'] = date('m/d/y',strtotime($updateDate));
							$data['url'] = $getFileInfo->alternateLink;
						}
					}
				}				
			}
		}
		echo json_encode($data);
		die;
	}
	
	function task_mode(){
		$data =array('status'=>'');
		if(isset($_POST) && count($_POST)>0){
			$emailMode = $this->input->post();
			$this->load->model('lead_model');
			$getLeadData = $this->lead_model->getLeadDataWithOptions($emailMode['l'],'id');
			if(count($getLeadData)>0){
				$updateDate = date('Y-m-d H:i:s');
				$leadButtonData = $this->lead_model->findButtonID($emailMode['b'],$emailMode['l']);
				$newStatus = "";
				if(count($leadButtonData)>0){
					$originalButton = $this->lead_model->findOriginalButtonByButtonID($leadButtonData->button_id);
					if(count($originalButton)>0){
						$statusMessage = $originalButton->status_message;
						if($originalButton->blink==1){
							$statusMessage = $originalButton->status_message_click;
						}
						$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$statusMessage.' <br/>';
						$newStatus = $leadButtonData->status_message_fill.$newStatus;
					}
				} else {
					$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span> <br/>';
				}
				$update = $this->lead_model->updateButton(array('status'=>1,'update_date'=>$updateDate,'status_message_fill'=>$newStatus),$emailMode['b']);
				$user_history = array('lead_id'=>$emailMode['l'],'user_id'=>$this->session->userdata['id'],'message'=>$newStatus,'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
				$this->load->model('user_model');
				$this->user_model->addUserHistory($user_history);
				if($update){
					$data['status'] = $updateDate;
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	
	function email_mode(){
		$data =array('status'=>'','detail'=>'');
		if(isset($_POST) && count($_POST)>0){
			$emailMode = $this->input->post();
			$this->load->model('general_model');
			$findTemplate = array("template_html"=>"","subject"=>"");
			if($emailMode['r']!=""){
				$findTemplate = $this->general_model->getTemplate($emailMode['r']);
				if(count($findTemplate)==0){
					$findTemplate = array("template_html"=>"","subject"=>"");
				}
			}
			$data['detail'] = $findTemplate;				
			$updateDate = date('Y-m-d H:i:s');
			$this->load->model('lead_model');
			$leadButtonData = $this->lead_model->findButtonID($emailMode['b'],$emailMode['l']);
			$newStatus = "";
			if(count($leadButtonData)>0){
				$originalButton = $this->lead_model->findOriginalButtonByButtonID($leadButtonData->button_id);
				if(count($originalButton)>0){
					$statusMessage = $originalButton->status_message;
					if($originalButton->blink==1){
						$statusMessage = $originalButton->status_message_click;
					}
					$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$statusMessage.' <br/>';
					$newStatus = $leadButtonData->status_message_fill.$newStatus;
				}
			} else {
				$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span> <br/>';
			}
			/*$update = $this->lead_model->updateButton(array('status'=>1,'update_date'=>$updateDate,'status_message_fill'=>$newStatus),$emailMode['b']);
			$user_history = array('lead_id'=>$emailMode['l'],'user_id'=>$this->session->userdata['id'],'message'=>$newStatus,'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
			$this->load->model('user_model');
			$this->user_model->addUserHistory($user_history);
			if($update){
				$data['status'] = $updateDate;
			}	*/
			$data['status'] = "";
		}
		echo json_encode($data);
		die;
	}
	
	function button_status_change(){
		$data = array("update"=>0);
		if(isset($_POST) && isset($_POST['b']) && isset($_POST['l']) && (int)$_POST['b']>0 && (int)$_POST['l']>0){
			$this->load->model('lead_model');
			$leadButtonData = $this->lead_model->findLeadButtonData($_POST['l'],$_POST['b']);
			$newStatus = "";
			if(count($leadButtonData)>0){
				$updateDate = date('Y-m-d H:i:s');
				$originalButton = $this->lead_model->findOriginalButtonByButtonID($leadButtonData->buttonID);
				if(count($originalButton)>0){
					$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButton->status_message.' <br/>';
					//$newStatus = $leadButtonData->status_message_fill.$newStatus;
				} else {
					$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span> <br/>';
				}
				$status = 1;
				if($leadButtonData->btnStatus==1){
					$status = 2;
				}
				$update = $this->lead_model->updateButton(array('status'=>$status,'update_date'=>$updateDate,'status_message_fill'=>$newStatus),$_POST['b']);
				$user_history = array('lead_id'=>$_POST['l'],'user_id'=>$this->session->userdata['id'],'message'=>$newStatus,'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s',strtotime($updateDate)));
				$this->load->model('user_model');
				$this->user_model->addUserHistory($user_history);
				if($update){
					$data['update'] = 1;
					$data['b'] = $_POST['b'];
					$data['status'] = date('m/d/y',strtotime($updateDate));
					if($leadButtonData->lead_columns!=""){
						$updateData[$leadButtonData->lead_columns] = date('Y-m-d H:i:s',strtotime($updateDate));
						$this->lead_model->from_litigation_update($_POST['l'],$updateData);
					}
				}
			}
		}		
		echo json_encode($data);
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
		$_SESSION['all_contacts'] = $mergeContacts;
		echo json_encode($_SESSION['all_contacts']);
		die;
	}
	
	public function c_my_contact_list(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->c_my_contact_list($this->input->post('c'),"c.id as contactID,c.first_name as firstName, c.last_name as lastName");
		}
		echo json_encode($data);
		die;
	}	
	function run_login(){
		$data = "0";
		if(isset($_POST) && count($_POST)>0){
			$check = $this->input->post('d');
			$this->load->model('user_model');
			if((int)$check==1){
				/*Insert*/
				if($this->input->post('l')>0){					
					$checkLead = $this->user_model->checkLastTimeLoglead($this->input->post('l'),date('Y-m-d H:i:s',strtotime('-1 hours')),$this->session->userdata['id']);
					if(count($checkLead)==0){						
						$this->user_model->insertLogTime(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$this->input->post('l'),'sid'=>$this->session->userdata['session_id'],'login_date'=>date('Y-m-d H:i:s')));
						$data = 1;
					} else {						
						$this->user_model->updateLogTime($this->session->userdata['id'],array('logout_date'=>date('Y-m-d H:i:s')));
						$data = 1;
					} 
				} else {					
					$this->user_model->insertLogTime(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$this->input->post('l'),'sid'=>$this->session->userdata['session_id'],'login_date'=>date('Y-m-d H:i:s')));
					$data = 1;
				}				
			} else if((int)$check==0){
				
				/*update*/
				$data = 1;
				$this->user_model->updateLogTime($this->session->userdata['id'],array('logout_date'=>date('Y-m-d H:i:s')));
			}
		}
		echo $data;
		die;
	}
	
	function lead_last_acitivity(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('user_model');
			$data = $this->user_model->getLeadLastActivity($this->input->post('l'),"create_date as date,lead_id as lead");
		}
		echo json_encode($data);
		die;
	}
	
		
	function lead_login(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('user_model');
			$oldLead = $this->input->post('o');
			$newLead = $this->input->post('n');
			$this->user_model->updateLogTime($this->session->userdata['id'],array('logout_date'=>date('Y-m-d H:i:s')));
			if((int)$oldLead !=(int)$newLead && (int)$oldLead>0 && (int)$newLead>0){
				$logoutDate = date('Y-m-d H:i:s',strtotime('2 seconds',time()));
				$loginDate = date('Y-m-d H:i:s',strtotime('1 seconds',strtotime($logoutDate)));
				if((int)$oldLead>0){
					$data = date('m/d/y');
					$this->user_model->updateLeadLogTime($this->session->userdata['id'],$oldLead,array('logout_date'=>$logoutDate));
				}
				if((int)$newLead>0){
					$data = date('m/d/y');
					$this->user_model->insertLogTime(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$newLead,'sid'=>$this->session->userdata['session_id'],'login_date'=>$loginDate));
				}
			} else {
				if((int)$oldLead==0 && (int)$newLead>0){
					$checkLead = $this->user_model->checkLastTimeLoglead($newLead,date('Y-m-d H:i:s',strtotime('-1 hours')),$this->session->userdata['id']);
					if(count($checkLead)==0){
						$data = date('m/d/y');
						$this->user_model->insertLogTime(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$newLead,'sid'=>$this->session->userdata['session_id'],'login_date'=>date('Y-m-d H:i:s')));
					} else {
						$data = date('m/d/y');
					$this->user_model->updateLeadLogTime($this->session->userdata['id'],$newLead,array('logout_date'=>date('Y-m-d H:i:s')));
					}
				} else if((int)$oldLead==(int)$newLead)	{
					$data = date('m/d/y');
					$this->user_model->updateLeadLogTime($this->session->userdata['id'],$oldLead,array('logout_date'=>date('Y-m-d H:i:s')));
				}			
			}		
		}
		echo $data;
		die;
	}
	
	function check_login(){
		$data = "0";
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('user_model');
			$lastLogin = $this->user_model->checkLastLog($this->session->userdata['id']);
			if($lastLogin==true){
				$this->user_model->insertLogTime(array('user_id'=>$this->session->userdata['id'],'sid'=>$this->session->userdata['session_id'],'login_date'=>date('Y-m-d H:i:s')));
				$data = 1;
			}
		}
		echo $data;
		die;
	}
	
	function button_renewable(){
		$data = "";
		if(isset($_POST) && count($_POST)>0){
			$buttonID = $this->input->post('b');
			$leadID = $this->input->post('l');
			if($buttonID>0){
				$this->load->model('lead_model');
				$buttonData = $this->lead_model->findButtonID($buttonID,$leadID);
				if(count($buttonData)>0){
					$renewable = 0;
					if($buttonData->renewable==0){
						$renewable = 1;
					}
					$this->lead_model->updateButton(array("renewable"=>$renewable),$buttonID);
					if($renewable=="0"){
						$data = "Disable renewable.";
					} else {
						$data = "Enable renewable.";
					}
				}
			}
		}
		echo $data;
		die;
	}
	
	function oldLinkInBulk(){
		$send =0;
		if(isset($_POST) && count($_POST)>0){
			$box = $_POST;
			if(!empty($box['e'])){
				$allEm = json_decode($box['e']);
				$activityType=0;
				if(isset($box['t']) && (int)$box['t']){
					$activityType=$box['t'];
					unset($box['t']);
				}
				if(count($allEm)>0){
					$this->load->model('lead_model');
					for($e=0;$e<count($allEm);$e++){
						$findData = $this->lead_model->findBoxNewById($allEm[$e]);
						if(count($findData)>0){
							$sendData = 0;
							foreach($findData as $thread){
								$this->lead_model->updateBox($thread->id,array("sent_from"=>1));								
								$event = array();
								if(isset($box['p']) && !empty($box['p']) && $box['p']!="," && $box['p']!=", "){
									$type=1;
								}
								
								$message = "";
								if(!empty($thread->file_attach)){
									$attachment = explode(',',$thread->file_attach);
									foreach($attachment as $url){
										if($url!=""){
											$href = $url;
											$title = pathinfo($href,PATHINFO_FILENAME);
											$message .= '<a  href="javascript://" data-file-id="" onclick=\'open_drive_files("'.trim($href).'");\' data-href="'.$href.'" data-mime="" target="_blank" style="color:#2196f3" class="file_draggable"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$title.'</a> &nbsp; &nbsp; &nbsp;';
										}							
									}
								}
								$event['company_id'] = $box['c_id'];
								$event['contact_id'] = $box['p'];
								if($thread->sent_from==1){
									$event['type'] = 3;
								} else{
									$event['type'] = 6;
								}								
								$event['note'] = $message;
								$event['user_id'] = $this->session->userdata['id'];
								$event['email_id'] = $thread->id;
								$event['subject'] = "View Email";
								$event['lead_id'] = $box['l'];
								$event['activity_date'] = date('Y-m-d H:i:s');
								if($activityType==2){
									$sendData = $this->lead_model->insertAcquistionActivity($event);
								}/* else {
									$this->lead_model->insertAcquistionActivity($event);
								}*/

							}
							if($sendData>0){
								$this->lead_model->updateBox($thread->id,array('type'=>1));
								$user_history = array('lead_id'=>$box['l'],'user_id'=>$this->session->userdata['id'],'message'=>"Add email into acquisition activity.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
								$this->load->model('user_model');
								$this->user_model->addUserHistory($user_history);
								$send= 1;
							} else {
								$send= 0;
							}
						}
					}
				}				
			}
		}
		echo json_encode(array('send'=>$send));
		die;
	}
	
	function oldlinkWithMessage(){
		if(isset($_POST) && count($_POST)>0){
			$box = $_POST;
			/*$findData = $this->lead_model->findBoxByThread($box['thread']);*/
			$this->load->model('lead_model');
			$findData = $this->lead_model->findBoxNewById($box['thread']);
			if(count($findData)>0){
				$sendData = 0;
				foreach($findData as $thread){
					$date = $thread->date_received;
					/*$this->lead_model->updateBox($thread->id,array("sent_from"=>1));*/
					$activityType=0;
					$event = array();
					if(isset($box['p']) && !empty($box['p']) && $box['p']!="," && $box['p']!=", "){
						$type=1;
					}
					if(isset($box['t']) && (int)$box['t']){
						$activityType=$box['t'];
						unset($box['t']);
					}
					$message = "";
					if(!empty($thread->file_attach)){
						$attachment = explode(',',$thread->file_attach);
						foreach($attachment as $url){
							if($url!=""){
								$href = $url;
								$title = pathinfo($href,PATHINFO_FILENAME);
								$message .= '<a  href="javascript://" data-file-id="" onclick=\'open_drive_files("'.trim($href).'");\' data-href="'.$href.'" data-mime="" target="_blank" style="color:#2196f3" class="file_draggable"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$title.'</a> &nbsp; &nbsp; &nbsp;';
							}							
						}
					}
					$getContactDetail = $this->lead_model->getContactById($box['p']);
					$this->load->model('opportunity_model');
					if(count($getContactDetail)>0){
						if($activityType==1){
							$checkCompanyInSalesActivity = $this->opportunity_model->checkCompanyInSales($box['old_thread'],$getContactDetail->company_id);
							if(count($checkCompanyInSalesActivity)==0){
								$this->opportunity_model->insertInvitees(array('lead_id'=>$box['old_thread'],'contact_id'=>$getContactDetail->company_id));
							}
							
						} else if($activityType==2){
							$checkCompanyInAcquisitionActivity = $this->opportunity_model->checkCompanyInAcquisition($box['old_thread'],$getContactDetail->company_id);
							if(count($checkCompanyInAcquisitionActivity)==0){
								$this->opportunity_model->insertAcquisitionCompany(array('lead_id'=>$box['old_thread'],'contact_id'=>$getContactDetail->company_id));
							}
						}
					}
					$event['company_id'] = $box['c_id'];
					$event['contact_id'] = $box['p'];
					if($thread->sent_from==1){
						$event['type'] = 3;
					} else{
						$event['type'] = 6;
					}
					$event['note'] = $message;
					$event['user_id'] = $this->session->userdata['id'];
					$event['email_id'] = $thread->id;
					$event['subject'] = "View Email";
					$event['lead_id'] = $box['old_thread'];
					$event['activity_date'] = date('Y-m-d H:i:s',strtotime($date));
					$this->lead_model->deleteAcquisitionActivity($thread->id);
					$this->lead_model->deleteSalesActivity($thread->id);
					//$this->lead_model->delete_user_activity_by_emailID($thread->id);
					if($activityType==1){
						$sendData = $this->lead_model->insetSalesActivity($event);
					} else if((int)$activityType==3){
						$data = $this->lead_model->insertPreSaleActivity($event);
					} else {
						$sendData = $this->lead_model->insertAcquistionActivity($event);
					}					
					//$this->activityLog($event);
				}
				if($sendData>0){
					//$this->lead_model->updateBox($thread->id,array('type'=>1,'lead_id'=>$box['old_thread']));					
					$user_history = array('lead_id'=>$box['old_thread'],'user_id'=>$this->session->userdata['id'],'message'=>"Moved email.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->load->model('user_model');
					$this->user_model->addUserHistory($user_history);
					echo json_encode(array('send'=>1));
				} else {
					echo json_encode(array('send'=>0));
				}
			}else {
				echo json_encode(array('send'=>0));
			}
		}else {
			echo json_encode(array('send'=>0));
		}
		die;
	}
	
	function move_drive_file(){
		$data = array('send'=>0);
		if(isset($_POST) && count($_POST)>0){
			$box = $_POST;
			$this->load->model('lead_model');
			$leadInfo = $this->lead_model->getLeadData($box['old_thread']);
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$fileMoved = $service->moveFile($box['drive'],$leadInfo->folder_id);
			if(is_object($fileMoved)){
				$data['send'] = 1;
			} 
		}
		echo json_encode($data);
		die;
	}
	
	function move_drive_file_in_lead_folder(){
		$data = array('send'=>0);
		if(isset($_POST) && count($_POST)>0){
			$box = $_POST;
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			if($box['f']=="GoTOMain"){
				$this->load->model('lead_model');
				$leadInfo = $this->lead_model->getLeadDataWithOptions($box['l'],"folder_id");
				$box['f'] = $leadInfo->folder_id;
			}
			$fileMoved = $service->moveFile($box['d'],$box['f']);
			if(is_object($fileMoved)){
				$data['send'] = 1;
			} 
		}
		echo json_encode($data);
		die;
	}
	
	function updateOneEmail(){
		$send = $this->searchImapEmails(1,'SynPat | The Sensible Approach To Acquiring Licenses Under High-Impact Patents',array('tyuasa@cusa.canon.com',''),'2016-04-04 13:21:00',127,162,4335);
		$dataSend = json_decode($send,true);
		if(isset($dataSend['send'])){
			$email_id = $dataSend['send'];
		} else if(isset($dataSend->send)){
			$email_id = $dataSend->send;
		}
		echo $email_id;
		if($email_id>0){
			$event = array();
			$event['contact_id'] = 4335;
			$event['company_id'] = 162;
			$event['type'] = 3;
			$event['note'] = '';
			$event['user_id'] = 23;
			$event['email_id'] = $email_id;
			$event['subject'] = 'SynPat | The Sensible Approach To Acquiring Licenses Under High-Impact Patents';
			$event['lead_id'] = 127;
			$event['activity_date'] = '2016-04-04 13:21:00';
			$this->load->model('lead_model');
			$this->lead_model->insetSalesActivity($event);
			$activityLog = $event;
			
			if(isset($activityLog['task_id'])){
				unset($activityLog['task_id']);
			}
			if(isset($activityLog['next_call_date'])){
				unset($activityLog['next_call_date']);
			}
			$this->lead_model->insertActivityLog($activityLog);
		}
		die;
	}
	
	function searchImapEmails($op=1,$subject,$toUsers,$date,$leadID,$type=1,$sendFrom=0,$userID=0){
		$data = array('send'=>0);
		$hostname = 'imap.gmail.com:993';
		$this->config->load('config');
		$params = array('mailbox'=>$hostname,'username'=>$this->config->item('imap_email'),'password'=>$this->config->item('imap_password'),'encryption'=>'ssl','folder'=>'[Gmail]/Sent Mail');
		$fromAccount = "";
		switch((int)$op){
			case 1:
				if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):
					$fromAccount = $this->config->item('license_email');
				endif;
			break;
			case 2:
				if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):
					$fromAccount = $this->config->item('operations_email');
				endif;
			break;
			case 3:
				if((int)$this->session->userdata['user']['type']==9 || in_array(27,$this->session->userdata['modules_assign'])):
					$fromAccount = $this->config->item('experts_email');
				endif;
			break;
		}
		$this->load->library('Imap',$params);
		$sendDate = date('d F Y',strtotime($date));
		if($this->imap->isConnected() && $fromAccount!=''){
			$results = $this->imap->searchEmails('FROM "'.$fromAccount.'" TO "'.$toUsers[0].'" SUBJECT "'.$subject.'" SINCE "'.$sendDate.'"');
			$mainMessage=array();
			if(count($results)>0){
				$mainMessage = $results[count($results) - 1];
			}
			if(count($mainMessage)==0 && !isset($mainMessage['date'])){	
				$results = $this->imap->searchEmails('FROM "'.$fromAccount.'" TO "'.$toUsers[0].'" SINCE "'.$sendDate.'"');
				$mainMessage=array();
				if(count($results)>0){
					$mainMessage = $results[count($results) - 1];
				}
			}
			if(count($mainMessage)>0 && isset($mainMessage['date'])){	
				$attachmentsConnect = array();
				$filesAttachment = "";
				if(isset($mainMessage['attachments']) && count($mainMessage['attachments'])>0){
					$a = 0;
					foreach($mainMessage['attachments'] as $attachment){
						$filename = $attachment['name'];
						$filename = str_replace(',','-',$filename);
						$attachmentBody = $this->imap->getAttachment($mainMessage['uid'],$a);
						if(isset($attachmentBody['content'])&& !empty($attachmentBody['content'])){
							$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
							fwrite($fh, $attachmentBody['content']);
							fclose($fh);
							$finfo = finfo_open(FILEINFO_MIME_TYPE); 
							$mimeType = finfo_file($finfo, $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
							/*$fileData = $this->add_aws_file($filename,$_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
							$fileAWS = "";
							if(count($fileData)>0 && $fileData['error']==0){
								unlink($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
								$filesAttachment .= $fileData['file_url'].",";
								$fileAWS = $fileData['file_url'];
							}*/
							$filesAttachment .= $this->config->base_url()."public/upload/".$filename.",";
							$fileAWS = $this->config->base_url()."public/upload/".$filename;
							$attachmentsConnect[] = array('filename'=>$fileAWS,'mimeType'=>$mimeType,"attachmentId"=>$a,"size"=>$attachmentBody['size']);
						}
						$a++;
					}
				}
				$mainMessage['attachments'] = $attachmentsConnect;
				$saveData = array('content'=>json_encode($mainMessage),'file_attach'=>$filesAttachment,"lead_id"=>$leadID,"user_id"=>$userID,"date_received"=>date('Y-m-d H:i:s', strtotime($mainMessage['date'])),'type'=>1,'sent_from'=>$sendFrom,'account_type'=>'2');
				$this->load->model('lead_model');
				$sendData = $this->lead_model->insertBox($saveData);			
				if($sendData>0){
					$data = array('send'=>$sendData);
				}
			}
		}		
		return json_encode($data);
		die;
	}
	
	function findEmailImapSendBox($op=1,$subject,$toUsers,$date,$leadID,$type=1,$sendFrom=0,$userID=0){
		if($userID==0){
			$userID = $this->session->userdata['id'];
		}
		$data = array('send'=>0);
		$hostname = 'imap.gmail.com:993';
		$this->config->load('config');
		/*$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl');*/
		$params= array();
		switch((int)$op){
			case 1:
				if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):
					$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl');
				endif;
			break;
			case 2:
				if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):
					$params = array('mailbox'=>$hostname,'username'=>$this->config->item('operations_email'),'password'=>$this->config->item('operations_password'),'encryption'=>'ssl');
				endif;
			break;
		}
		
		
		$this->load->library('Imap',$params);
		$s = 0;
		$mainMessage=array();
		if($this->imap->isConnected()){
			$this->imap->selectFolder('[Gmail]/Sent Mail');
			$messages = $this->imap->getMessages();			
			if(count($messages)>0){
				for($m=0;$m<count($messages);$m++){
					$s = 0;
					if(trim($messages[$m]['subject'])==trim($subject)){						
						$toSendBox = $messages[$m]['to'];
						foreach($toSendBox as $to){
							$to = substr($to,0,stripos($to,'<'));
							if(count($toUsers)>0){
								for($i=0;$i<count($toUsers)-1;$i++){
									if(trim($toUsers[$i]) == trim($to)){
										$s = $s +1;
									}
								}
							}
						}					
						if($s == count($toSendBox)){
							$mainMessage=$messages[$m];
							break; 
						}
					}
				}
			}
		}
		if($s>0 && $mainMessage>0){			
			$attachmentsConnect = array();
			$filesAttachment = "";
			if(isset($mainMessage['attachments']) && count($mainMessage['attachments'])>0){
				$a = 0;
				foreach($mainMessage['attachments'] as $attachment){
					$filename = $attachment['name'];
					$filename = str_replace(',','-',$filename);
					$attachmentBody = $this->imap->getAttachment($mainMessage['uid'],$a);
					if(isset($attachmentBody['content'])&& !empty($attachmentBody['content'])){
						$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
						fwrite($fh, $attachmentBody['content']);
						fclose($fh);
						$finfo = finfo_open(FILEINFO_MIME_TYPE); 
						$mimeType = finfo_file($finfo, $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
						/*$fileData = $this->add_aws_file($filename,$_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
						$fileAWS = "";
						if(count($fileData)>0 && $fileData['error']==0){
							unlink($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
							$filesAttachment .= $fileData['file_url'].",";
							$fileAWS = $fileData['file_url'];
						}*/
						$filesAttachment .= $this->config->base_url()."public/upload/".$filename.",";
						$fileAWS = $this->config->base_url()."public/upload/".$filename;
						$attachmentsConnect[] = array('filename'=>$fileAWS,'mimeType'=>$mimeType,"attachmentId"=>$a,"size"=>$attachmentBody['size']);
					}
					$a++;
				}
			}
			$mainMessage['attachments'] = $attachmentsConnect;
			$saveData = array('content'=>json_encode($mainMessage),'file_attach'=>$filesAttachment,"lead_id"=>$leadID,"user_id"=>$userID,"date_received"=>date('Y-m-d H:i:s', strtotime($mainMessage['date'])),'type'=>1,'sent_from'=>$sendFrom,'account_type'=>'2');
			$this->load->model('lead_model');
			$sendData = $this->lead_model->insertBox($saveData);			
			if($sendData>0){
				$data = array('send'=>$sendData);
			}
		}
		return json_encode($data);
	}
	
	function find_lead_by_contact_id(){
		$list = array();
		if(isset($_POST) && isset($_POST['contact_id']) && !empty($_POST['contact_id']) && (int)$_POST['contact_id']){
			$this->load->model('opportunity_model');
			$list = $this->opportunity_model->checkAllLeadsByContact($_POST['contact_id']);
		}
		echo json_encode(array('list'=>$list));
		die;
	}
	
	function find_activites_leads_from_email_id(){
		$data= array();
		if(isset($_POST) && isset($_POST['id']) && !empty($_POST['id'])){
			$this->load->model('opportunity_model');
			$data = $this->opportunity_model->checkAllLeadsFromEmailActivityByID($_POST['id']);
		}
		echo json_encode($data);
	}
	
	function find_activites_leads_from_contact_id(){
		$this->load->model('opportunity_model');
		$list = array();
		$active_list = array();
		$companyID = 0;
		$personID = 0;
		if(isset($_POST)){
			$personID = $this->input->post('contact_id');
			$companyID = $this->input->post('company_id');
			$getList = $this->opportunity_model->checkAllLeadsFromContactID($personID,$companyID);
			$list = $getList['list'];
			$active_list = $getList['active_list']; 
		}
		$data = array('company_id'=>$companyID,'person_id'=>$personID,'list'=>$list,'active_list'=>$active_list);
		echo json_encode($data);
		die;
	}
	
	function find_activites_leads_from_email(){
		$list = array();
		$active_list = array();
		$lead=0;
		$leadName="";
		$activity=0;
		$companyID=0;
		$personID=0;
		$count=0;
		if(isset($_POST) && isset($_POST['email']) && !empty($_POST['email'])){
			$this->load->model('opportunity_model');
			$getList = $this->opportunity_model->checkAllLeadsFromEmailActivity($_POST['email']);
			if(count($getList['contact'])>0){
				$personID = $getList['contact']->id;
				$companyID = $getList['contact']->company_id;
			}
			$list = $getList['list'];
			$active_list = $getList['active_list']; 			
		}		
		$data = array('company_id'=>$companyID,'person_id'=>$personID,'list'=>$list,'active_list'=>$active_list);
		echo json_encode($data);
		die;		
	}
	
	function runCheckingEmailFailureActivity(){
		$data = array('email'=>'','failure'=>'0');
		if(isset($_POST) && count($_POST)>0){
			$data = $_POST;
			$data['failure'] = 0;
			$hostname = 'imap.gmail.com:993';
			$this->config->load('config');
			/*$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl');*/
			$params = array('mailbox'=>$hostname,'username'=>$this->config->item('imap_email'),'password'=>$this->config->item('imap_password'),'encryption'=>'ssl');
			$this->load->library('Imap',$params);
			if($this->imap->isConnected()){
				if(isset($data['sentFrom'])){
					if((int)$data['sentFrom']==0){
						$this->imap->selectFolder('INBOX');
					}else if((int)$data['sentFrom']==1){
						$this->imap->selectFolder('[Gmail]/Sent Mail');
					}	
				} else {
					$this->imap->selectFolder('INBOX');
				}							
				$message = $this->imap->getMessage($data['msgNo']);
				$body = $message['body'];
				$pos = strpos($body,'Message-ID');
				if($pos!=false){
					$body = substr($body,$pos) ;
					$pos1 = strpos($body,"backyard.synpat.com");					
					$email = "";
					if($pos1 !=false){
						$body = substr($body,11,$pos1+19) ;
						$explodeLess = explode('&lt;',trim($body));
						$stringAgain = implode('',$explodeLess);
						$stringAgain = trim($stringAgain);
						$stringAgain = explode('<',$stringAgain);
						$stringAgain = implode('',$stringAgain);
						$stringAgain = trim($stringAgain);
						$explodeLess = explode('&gt;',$stringAgain);
						if(count($explodeLess)>0){
							$emailSp = trim($explodeLess[0]);
							if(!empty($emailSp)){
								$email = $emailSp;
								if(strpos($email,'>')){
									$email = substr($email,0,strpos($email,'>'));
								}
								$email =filter_var($email, FILTER_VALIDATE_EMAIL);
							}
						}
					}
					if(empty($email)):
						$pos1 = strpos($body,"X-Mailer");
						if($pos1 !=false){
							$body = substr($body,11,$pos1+9) ;
							$explodeLess = explode('&lt;',trim($body));
							$stringAgain = implode('',$explodeLess);
							$stringAgain = trim($stringAgain);
							$stringAgain = explode('<',$stringAgain);
							$stringAgain = implode('',$stringAgain);
							$stringAgain = trim($stringAgain);
							$explodeLess = explode('&gt;',$stringAgain);
							if(count($explodeLess)>0){
								$emailSp = trim($explodeLess[0]);
								if(!empty($emailSp)){
									$email = $emailSp;
									if(strpos($email,'>')){
										$email = substr($email,0,strpos($email,'>'));
									}
									$email =filter_var($email, FILTER_VALIDATE_EMAIL);
								}
							}
						}
					endif;
					if(!empty($email)){
						$this->load->model('lead_model');
						$searchData = $this->lead_model->fincImapEmailWithMessageID($email);
						if(count($searchData)>0){							
							$data['failure'] = 1;							
							$data['found_email_attached'] = $searchData[0]->id;
						}
					} else {
						$data['failure'] = 0;
					}					
				} else {
					$data['failure'] = 0;
				}
			} else {
				$data['failure'] = 0;
			}
		}
		echo json_encode($data);
		die;
	}
	
	function attachImapFailureActivity($t=0){
		$data = array('email'=>'','failure'=>'0');
		if(isset($_POST) && count($_POST)>0){
			$data = $_POST;
			if(isset($data['attached']) && (int) $data['attached']>0){
				/**/
				$hostname = 'imap.gmail.com:993';
				$this->config->load('config');
				/*$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl');*/
				$params= array();
				switch((int)$op){
					case 1:
						if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):
							$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl');
						endif;
					break;
					case 2:
						if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):
							$params = array('mailbox'=>$hostname,'username'=>$this->config->item('operations_email'),'password'=>$this->config->item('operations_password'),'encryption'=>'ssl');
						endif;
					break;
				}
				$this->load->library('Imap',$params);
				if($this->imap->isConnected()){
					if(isset($data['sentFrom'])){
						if((int)$data['sentFrom']==0){
							$this->imap->selectFolder('INBOX');
						}else if((int)$data['sentFrom']==1){
							$this->imap->selectFolder('[Gmail]/Sent Mail');
						}	
					} else {
						$this->imap->selectFolder('INBOX');
					}							
					$message = $this->imap->getMessage($data['msgNo']);
					$body = $message['body'];
					$this->load->model('lead_model');
					$searchData = $this->lead_model->findBoxNewById($data['attached']);
					/*Assign failure email with contact and lead and */
					$attachmentsConnect = array();
					$filesAttachment = "";
					if(isset($message['attachments']) && count($message['attachments'])>0){
						$a = 0;
						foreach($message['attachments'] as $attachment){
							$filename = $attachment['name'];
							$filename = str_replace(',','-',$filename);
							$attachmentBody = $this->imap->getAttachment($data['UID'],$a);
							if(isset($attachmentBody['content'])&& !empty($attachmentBody['content'])){
								$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
								fwrite($fh, $attachmentBody['content']);
								fclose($fh);
								$finfo = finfo_open(FILEINFO_MIME_TYPE); 
								$mimeType = finfo_file($finfo, $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
								/*$fileData = $this->add_aws_file($filename,$_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
								$fileAWS = "";
								if(count($fileData)>0 && $fileData['error']==0){
									unlink($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
									$filesAttachment .= $fileData['file_url'].",";
									$fileAWS = $fileData['file_url'];
								}*/
								$filesAttachment .= $this->config->base_url()."public/upload/".$filename.",";
								$fileAWS = $this->config->base_url()."public/upload/".$filename;
								$attachmentsConnect[] = array('filename'=>$fileAWS,'mimeType'=>$mimeType,"attachmentId"=>$a,"size"=>$attachmentBody['size']);
							}
							$a++;
						}
					}
					$contact = $this->lead_model->getPersonCompanyDetailFromSalesActivityLogByEmailID($searchData[0]->id);
					if(count($contact)==0){
						$contact = $this->lead_model->getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($searchData[0]->id);
						if(count($contact)>0){
							$activity = 2;
						} else {
							$contact = $this->lead_model->getPersonCompanyDetailFromPreSalesActivityLogByEmailID($searchData[0]->id);
							if(count($contact)>0){
								$activity = 3;
							} else {
								$contact = (object)array('contact_id'=>0,'company_id'=>0);
							}
						}
					} else{
						$activity = 1;
					}
					$message['attachments'] = $attachmentsConnect;
					if((int)$searchData[0]->lead_id>0):
						$saveData = array('content'=>json_encode($message),'file_attach'=>$filesAttachment,"lead_id"=>$searchData[0]->lead_id,"user_id"=>$this->session->userdata['id'],"date_received"=>date('Y-m-d H:i:s', strtotime($message['date'])),'type'=>1,'account_type'=>'2');
						$sendData = $this->lead_model->insertBox($saveData);
						if($sendData>0){
							/*Move Message to Lead Folder*/
							$this->imap->copyMessage($data['msgNo'],'Leads');
							$data['lead_id'] = $searchData[0]->lead_id;
							$data['activity'] = $activity;
							if($activity==1){
								$this->lead_model->updateSalesActivityByEmailID($searchData[0]->id,array('error'=>1));
							} else if($activity==3){
								$this->lead_model->updatePreSaleActivityByEmailID($searchData[0]->id,array('error'=>1));
							} else if($activity==2){
								$this->lead_model->updateAcquistionActivityByEmailID($searchData[0]->id,array('error'=>1));
							}								
							$event = array();
							$event['company_id'] = $contact->company_id;
							$event['contact_id'] = $contact->contact_id;
							$event['type'] = 6;
							$event['note'] = '';
							$event['error'] = 1;
							$event['user_id'] = $this->session->userdata['id'];
							$event['email_id'] = $sendData;
							$event['subject'] = $message['subject'];
							$event['lead_id'] = $searchData[0]->lead_id;
							$event['activity_date'] = date('Y-m-d H:i:s', strtotime($message['date']));
							/*$this->lead_model->insetSalesActivity($event);*/
							if($activity==1){
								$this->lead_model->insetSalesActivity($event);
							} else if($activity==3){
								$this->lead_model->insertPreSaleActivity($event);
							} else if($activity==2){
								$this->lead_model->insertAcquistionActivity($event);
							}
							unset($event['error']);
							$this->activityLog($event);
							/*$data = $sendData;*/
							/*update sales activity*/
							$data['failure'] = 1;
							$data['attach_email'] = $sendData;
							$user_history = array('lead_id'=>$searchData[0]->lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"Add email into box.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
							$this->load->model('user_model');
							$this->user_model->addUserHistory($user_history);						
						}
					endif;
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	function linkImapMessage(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$box = $_POST;				
			$hostname = 'imap.gmail.com:993';
			$this->config->load('config');
			$params = array('mailbox'=>$hostname,'username'=>$this->config->item('imap_email'),'password'=>$this->config->item('imap_password'),'encryption'=>'ssl');
			$from = "";
			switch((int)$box['t']){
				case 1:
					if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):
						$from = $this->config->item('license_email');
					endif;
				break;
				case 2:
					if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):
						$from = $this->config->item('operations_email');
					endif;
				break;
				case 3:
					if((int)$this->session->userdata['user']['type']==9 || in_array(27,$this->session->userdata['modules_assign'])):
						$from = $this->config->item('experts_email');
					endif;
				break;
			}
			/*$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl');*/
			if(count($params)):
			$this->load->library('Imap',$params);
			if($this->imap->isConnected()){
				$this->imap->selectFolder('INBOX');
				$message = $this->imap->getMessage($box['msg_no']);
				$attachmentsConnect = array();
				$filesAttachment = "";
				if(isset($message['attachments']) && count($message['attachments'])>0){
					$a = 0;
					try{
						foreach($message['attachments'] as $attachment){
							$filename = $attachment['name'];
							$filename = str_replace(',','-',$filename);
							$attachmentBody = $this->imap->getAttachment($box['uid'],$a);
							if(isset($attachmentBody['content'])&& !empty($attachmentBody['content'])){
								$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
								fwrite($fh, $attachmentBody['content']);
								fclose($fh);
								$finfo = finfo_open(FILEINFO_MIME_TYPE); 
								$mimeType = finfo_file($finfo, $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
								/*$fileData = $this->add_aws_file($filename,$_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
								$fileAWS = "";
								if(count($fileData)>0 && $fileData['error']==0){
									unlink($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
									$filesAttachment .= $fileData['file_url'].",";
									$fileAWS = $fileData['file_url'];
								}*/
								$filesAttachment .= $this->config->base_url()."public/upload/".$filename.",";
								$fileAWS = $this->config->base_url()."public/upload/".$filename;
								$attachmentsConnect[] = array('filename'=>$fileAWS,'mimeType'=>$mimeType,"attachmentId"=>$a,"size"=>$attachmentBody['size']);
							}
							$a++;
						}
					}catch(Exception $e){
						
					}
				}
				$message['attachments'] = $attachmentsConnect;
				/*$emailMessageBody = $message['text_body']['body'];*/
				$saveData = array('content'=>json_encode($message),'file_attach'=>$filesAttachment,"lead_id"=>$box['lead_id'],"user_id"=>$this->session->userdata['id'],"date_received"=>date('Y-m-d H:i:s', strtotime($message['date'])),'type'=>1,'account_type'=>'2');
				$this->load->model('lead_model');
				$sendData = $this->lead_model->insertBox($saveData);
				$date = "";
				if($message['date']!=""){
					$date = date('Y-m-d H:i:s',strtotime($message['date']));
				} else {
					$date = date('Y-m-d H:i:s');
				}
				if($sendData>0){				
					$this->imap->moveMessage($box['msg_no'],'Lead');
					$event = array();
					$event['company_id'] = $box['c_id'];
					$event['contact_id'] = $box['p_id'];
					$event['type'] = 6;
					$event['note'] = '';
					$event['user_id'] = $this->session->userdata['id'];
					$event['email_id'] = $sendData;
					$event['subject'] = $message['subject'];
					$event['lead_id'] = $box['lead_id'];
					$event['activity_date'] = $date;					
					if($box['activity_type']==1){
						$this->lead_model->insetSalesActivity($event);
					}else if((int)$box['activity_type']==3){
						$data = $this->lead_model->insertPreSaleActivity($event);
					} else if((int)$box['activity_type']==2){
						$this->lead_model->insertAcquistionActivity($event);
					}
					$this->activityLog($event);
					$data = $sendData;
					$user_history = array('lead_id'=>$box['lead_id'],'user_id'=>$this->session->userdata['id'],'message'=>"Add email into box.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->load->model('user_model');
					$this->user_model->addUserHistory($user_history);						
				}
			}
			endif;
		}
		echo $data;
		die;
	}
	
	function activateCustomerRequest(){
		$data = array('send'=>0);
		if(isset($_POST) && count($_POST)>0){
			$data = $this->input->post();
			$this->load->model('customer_model');
			$getRequest = $this->customer_model->getCustomerRequest($data['p']);
			if(count($getRequest)>0){
				$this->load->model('lead_model');
				$findContactByEmail = $this->lead_model->getContactByEmail($getRequest->email);
				$contactID = 0;
				if(count($findContactByEmail)>0){
					$contactID = $findContactByEmail->id;
					$data['c'] = $findContactByEmail->company_id;
				}
				$customerR = 0;
				if($contactID > 0){
					$checkCustomerByContactID = $this->customer_model->checkCustomerByContactID($contactID);
					if(count($checkCustomerByContactID) > 0){
						$customerR = $checkCustomerByContactID->id;
					}
				}
				if($customerR == 0){				
					$getData = array('customer');
					$getData['customer']['first_name'] = $getRequest->first_name;
					$getData['customer']['last_name'] = $getRequest->last_name;
					$getData['customer']['company_name'] = $getRequest->company_name;
					$getData['customer']['email'] = $getRequest->email;
					$getData['customer']['phone_number'] = $getRequest->phone_number;
					$getData['customer']['password'] = $getRequest->password;
					$getData['customer']['status'] = 0;
					$getData['customer']['company_id'] = $data['c'];
					$getData['customer']['contact_id'] = $contactID;
					$getData['customer']['create_date'] = $getRequest->create_date;							
					$customerR = $this->customer_model->insertCustomer($getData['customer']);
				}
				if($customerR>0){			
					$this->customer_model->deleteCustomerRequest($getRequest->id);
					/*Check any Document Request send by this customer*/
					if($getRequest->request_id>0){
						/*Update in request to particpate table*/
						$this->load->model('lead_model');
						/*Add in customer history*/
						if($getRequest->type==0){
							$getParticpantRequestData = $this->lead_model->findRequestToParticipantById($getRequest->request_id,'license_id,type,create_date,file');
							if(count($getParticpantRequestData)>0){
								$this->lead_model->updateRequestParticpantData(array('customer_id'=>$customerR),$getRequest->request_id);
								$findLeadIDFromLicenseID = $this->lead_model->findLeadFromLicenseID($getParticpantRequestData->license_id,'l.id');
								if(count($findLeadIDFromLicenseID)>0){
									/*$this->lead_model->insertCustomerTransaction(array('customer_id'=>$customerR,'lead_id'=>$findLeadIDFromLicenseID->id,'type'=>$getParticpantRequestData->type,'executed_date'=>$getParticpantRequestData->create_date,'file'=>$getParticpantRequestData->file));*/
								}										
							}
						} else if($getRequest->type==1) {
							$getRevisedRequestDocument = $this->lead_model->findDraftRevisedDocumentRequest($getRequest->request_id,'*');
							if(count($getRevisedRequestDocument)>0){
								$getRevisedRequestDocument->customer_id =$customerR;
								unset($getRevisedRequestDocument->id);
								unset($getRevisedRequestDocument->request_id);
								$getRevisedRequestDocument->company_id = 0;
								$this->lead_model->insertRevisedDocument($getRevisedRequestDocument);
								//$this->lead_model->updateDraftRevisedDocumentRequest(array('customer_id'=>$customerR),$getRequest->request_id);
							}
						} else if($getRequest->type==2){
							$getRevisedRequestDocument = $this->lead_model->findRequestFromCheckAvailability($getRequest->request_id,'id,type');
							if(count($getRevisedRequestDocument)>0){
								$updateData = array('customer_id'=>$customerR);
								if($getRevisedRequestDocument->type == 2){
									$updateData['company_id'] = $data['c'];
								}
								$this->lead_model->updateCheckAvailabilityRequest($updateData,$getRevisedRequestDocument->id);
								/*$this->lead_model->updateCheckAvailabilityRequestByEmail(array('customer_id'=>$customerR),$getRequest->email);*/
							}
						}									
					}								
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	function update_deal_flow_assign_for(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();	
			if(isset($post['id']) && $post['id']>0){
				$name = $post['name'];
				$this->load->model('lead_model');
				$data = $this->lead_model->updateCustomerDealFlow(array('available_for'=>$name),$post['id']);
			}
		}
		echo $data;
		die;
	}
	
	function insert_check_availability_request_deal_flow(){
		$data = array('id'=>0);
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();	
			if(isset($post['i'])){
				/*Find Datafrom Check Availaility*/
				$this->load->model('lead_model');
				$getData  = $this->lead_model->findRequestFromCheckAvailability($post['i']);
				if(count($getData)>0){
					$getEmailData = $this->lead_model->findBoxNewById($post['e']);
					$date = date('Y-m-d H:i:s');
					if(count($getEmailData) > 0){
						$date = $getEmailData[0]->date_received;
					}
					$availability = 1;
					if(isset($post['available']) && $post['available']=="yes"){
						$availability = 2;
					}
					$this->lead_model->updateCheckAvailabilityRequest(array('availability'=>$availability,'status'=>2,'replied'=>$date),$post['i']);
					/*Insert entry in deal flow*/
					$dealFlow = array();
					$entry = false;
					$this->load->model('customer_model');
					if((int)$getData->type == 3 && $getData->company_id > 0){						
						$findCompany = $this->customer_model->getCompanyDataByIDWithOptions($getData->company_id,"c.id");
						if(count($findCompany) > 0){
							$dealFlow['company_id'] = $getData->company_id;
							$entry = true;
						}
					} else {
						$findCustomerData = $this->customer_model->getCustomerByID($getData->customer_id);
						if(count($findCustomerData) > 0){
							$dealFlow['company_id'] = $findCustomerData->company_id;
							$entry = true;
						}
					}
					if($entry === true){
						$dealFlow['customer_id'] = $getData->customer_id;
						$dealFlow['lead_id'] = $post['l'];
						$dealFlow['license_type'] = $getData->type;
						$dealFlow['available_for'] = $getData->check_for;
						$dealFlow['availability'] = $availability;
						$dealFlow['customize_file'] = '';
						$dealFlow['agreement_status'] = '';
						$dealFlow['syndication'] = '';
						$dealFlow['executed_by_synpat'] = '';
						$dealFlow['executed_by_customer'] = '';
						$dealFlow['created_date'] = $date;
						$dealFlow['modified_date'] = '0000-00-00 00:00:00';
						$data['id'] = $this->lead_model->insertCustomerDealFlow($dealFlow);
					}					
				}
			}			
		}
		echo json_encode($data);
		die;
	}
	
	function delete_check_availability(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();
			if(isset($post['l']) && $post['l']>0){
				$this->load->model('lead_model');
				$data = $this->lead_model->deleteCheckAvailability($post['l']);
			}			
		}
		echo $data;
		die;
	}
	
	function check_availability_data_target(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();
			if(isset($post['i']) && $post['i']>0){
				$this->load->model('lead_model');
				$findData = $this->lead_model->findRequestFromCheckAvailability($post['i']);
				if(count($findData) > 0){
					if($findData->type == 3 && $findData->company_id > 0){
						$data = $findData->company_id;
					} else if($findData->type == 2){
						if($findData->company_id == 0){
							$this->load->model('customer_model');
							$getCustomerData = $this->customer_model->getCustomerByID($findData->customer_id);
							if(count($getCustomerData) > 0 && $getCustomerData->company_id > 0){
								$updateData = $this->lead_model->updateCheckAvailabilityRequest(array('company_id'=>$getCustomerData->company_id),$findData->id);
								if($updateData > 0){
									$data = $getCustomerData->company_id;
								}
							}
						}
					}
				}
			}			
		}
		echo $data;
		die;
	}
	
	function check_revised_document_target(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();
			if(isset($post['i']) && $post['i']>0){
				$this->load->model('lead_model');
				$findData = $this->lead_model->getRevisedDocumentByID($post['i']);
				if(count($findData) > 0){
					if($findData->rf_type == 3 && $findData->company_id > 0){
						$data = $findData->company_id;
					} else if($findData->rf_type == 2){
						if($findData->company_id == 0){
							$this->load->model('customer_model');
							$getCustomerData = $this->customer_model->getCustomerByID($findData->customer_id);
							if(count($getCustomerData) > 0 && $getCustomerData->company_id > 0){
								$updateData = $this->lead_model->updateRevisedDocumentRequest(array('company_id'=>$getCustomerData->company_id),$findData->id);
								if($updateData > 0){
									$data = $getCustomerData->company_id;
								}
							}
						}
					}
				}
			}			
		}
		echo $data;
		die;
	}
	
	function check_participant_request_target(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();
			if(isset($post['i']) && $post['i']>0){
				$this->load->model('lead_model');
				$findData = $this->lead_model->findRequestToParticipantById($post['i']);
				if(count($findData) > 0){
					if($findData->document_type == 3 && $findData->company_id > 0){
						$data = $findData->company_id;
					} else if($findData->document_type == 2){
						if($findData->company_id == 0){
							$this->load->model('customer_model');
							$getCustomerData = $this->customer_model->getCustomerByID($findData->customer_id);
							if(count($getCustomerData) > 0 && $getCustomerData->company_id > 0){
								$updateData = $this->lead_model->updateRequestParticpantData(array('company_id'=>$getCustomerData->company_id),$findData->id);
								if($updateData > 0){
									$data = $getCustomerData->company_id;
								}
							}
						}
					}
				}
			}			
		}
		echo $data;
		die;
	}
	
	function delete_revised_document_request(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();
			if(isset($post['l']) && $post['l']>0){
				$this->load->model('lead_model');
				$data = $this->lead_model->updateRevisedDocumentRequest(array("status"=>3),$post['l']);
			}			
		}
		echo $data;
		die;
	}
	function delete_request_activate(){
		$data = array('send'=>0);
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			$this->load->model('client_model');
			$contact = $this->client_model->find_contact($postData['p']);
			if(count($contact)>0){
				$data['e'] = $contact->email;
				$data['n'] = $contact->first_name.' '.$contact->last_name;
				$contactID = $contact->id;
				$this->load->model('customer_model');
				$getRequest = $this->customer_model->findCustomerRequestByEmail($data['e']);
				if(count($getRequest)>0){
					
					$getData = array('customer');
					$getData['customer']['first_name'] = $getRequest->first_name;
					$getData['customer']['last_name'] = $getRequest->last_name;
					$getData['customer']['company_name'] = $getRequest->company_name;
					$getData['customer']['email'] = $getRequest->email;
					$getData['customer']['phone_number'] = $getRequest->phone_number;
					$getData['customer']['password'] = $getRequest->password;
					$getData['customer']['status'] = 0;
					$getData['customer']['company_id'] = $contact->company_id;
					$getData['customer']['contact_id'] = $contactID;
					$getData['customer']['create_date'] = $getRequest->create_date;							
					$customerR = $this->customer_model->insertCustomer($getData['customer']);
					if($customerR>0){			
						$this->customer_model->deleteCustomerRequest($getRequest->id);
						/*Request all from check Availability*/
						if($getRequest->request_id > 0){
							$this->load->model('lead_model');
							$data['send'] = 1;
							$getRevisedRequestDocument = $this->lead_model->findRequestFromCheckAvailability($getRequest->request_id,'id');
							if(count($getRevisedRequestDocument)>0){
								$this->lead_model->updateCheckAvailabilityRequest(array('customer_id'=>$getRequest->id),$getRequest->request_id);
								$this->lead_model->updateCheckAvailabilityRequestByEmail(array('customer_id'=>$getRequest->id),$getRequest->email);
							}
						}
					}
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	
	
	function customer_request_activate(){
		$data = array('send'=>0);
		if(isset($_POST) && count($_POST)>0){
			$data = $this->input->post();
			$this->load->model('opportunity_model');
			$checkCompany = 0;
			if($data['a']==1){
				$checkCompanyInSalesActivity = $this->opportunity_model->checkCompanyInSales($data['l'],$data['c']);
				if(count($checkCompanyInSalesActivity)==0){
					$checkCompany = $this->opportunity_model->insertInvitees(array('lead_id'=>$data['l'],'contact_id'=>$data['c']));
				} else {
					$checkCompany = 1;
				}
			} else if($data['a']==2){
				$checkCompanyInAcquisitionActivity = $this->opportunity_model->checkCompanyInAcquisition($data['l'],$data['c']);
				if(count($checkCompanyInAcquisitionActivity)==0){
					$checkCompany = $this->opportunity_model->insertAcquisitionCompany(array('lead_id'=>$data['l'],'contact_id'=>$data['c']));
				} else {
					$checkCompany = 1;
				}
			}
			$data['send'] = $checkCompany;	
			if($data['send']>0){
				/*Detail for Contact*/				
				$this->load->model('client_model');
				if($data['p']>0){
					$contact = $this->client_model->find_contact($data['p']);
					if(count($contact)>0){
						$data['e'] = $contact->email;
						$data['n'] = $contact->first_name.' '.$contact->last_name;
						$this->load->model('customer_model');
						$getRequest = $this->customer_model->findCustomerRequestByEmail($data['e']);
						if(count($getRequest)>0){
							/*check user is already customer*/
							$checkEmail = $this->customer_model->checkEmail($getRequest->email,2);
							$customerR = 0;
							if(count($checkEmail)==0){
								/*$getData = array('customer');
								$getData['customer']['first_name'] = $getRequest->first_name;
								$getData['customer']['last_name'] = $getRequest->last_name;
								$getData['customer']['email'] = $getRequest->email;
								$getData['customer']['phone_number'] = $getRequest->phone_number;
								$getData['customer']['password'] = $getRequest->password;
								$getData['customer']['status'] = 0;
								$getData['customer']['company_id'] = $data['c'];
								$getData['customer']['create_date'] = $getRequest->create_date;							
								$customerR = $this->customer_model->insertCustomer($getData['customer']);
								if($customerR>0){
									$this->customer_model->deleteCustomerRequest($getRequest->id);
								}*/
								$data['customer_new']=$getRequest->id.'^'.$data['c'];
							} else {
								$customerR = $checkEmail->id;
							}							
							if($customerR>0){						
								/*Check any Document Request send by this customer*/
								if($getRequest->request_id>0){
									/*Update in request to particpate table*/
									$this->load->model('lead_model');
									/*Add in customer history*/
									if($getRequest->type==0){
										$getParticpantRequestData = $this->lead_model->findRequestToParticipantById($getRequest->request_id,'license_id,type,create_date,file');
										if(count($getParticpantRequestData)>0){
											$this->lead_model->updateRequestParticpantData(array('customer_id'=>$customerR),$getRequest->request_id);
											$findLeadIDFromLicenseID = $this->lead_model->findLeadFromLicenseID($getParticpantRequestData->license_id,'l.id');
											if(count($findLeadIDFromLicenseID)>0){
												/*$this->lead_model->insertCustomerTransaction(array('customer_id'=>$customerR,'lead_id'=>$findLeadIDFromLicenseID->id,'type'=>$getParticpantRequestData->type,'executed_date'=>$getParticpantRequestData->create_date,'file'=>$getParticpantRequestData->file));*/
											}										
										}
									} else if($getRequest->type==1) {
										$getRevisedRequestDocument = $this->lead_model->findDraftRevisedDocumentRequest($getRequest->request_id,'id');
										if(count($getRevisedRequestDocument)>0){
											$this->lead_model->updateDraftRevisedDocumentRequest(array('customer_id'=>$customerR),$getRequest->request_id);
										}
									} else if($getRequest->type==2){
										$getRevisedRequestDocument = $this->lead_model->findRequestFromCheckAvailability($getRequest->request_id,'id,type');
										if(count($getRevisedRequestDocument)>0){
											$updateData = array('customer_id'=>$customerR);
											if($getRevisedRequestDocument->type == 2){
												$updateData['company_id'] = $contact->company_id;
											}
											$this->lead_model->updateCheckAvailabilityRequest($updateData,$getRevisedRequestDocument->id);
											/*$this->lead_model->updateCheckAvailabilityRequestByEmail(array('customer_id'=>$customerR),$getRequest->email);*/
										}
									}									
								}								
							}
						}
					}
				}
			}
		}
		echo  json_encode($data);
		die;
	}
	
	function linkWithLinkedinMessage(){
		$data =  array('send'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$this->load->model('opportunity_model');
			$getMessage = $this->lead_model->getLinkedinMessageById($this->input->post('thread'));
			if(count($getMessage) > 0){
				$activityType = $this->input->post('t');
				$conversationID = $this->input->post('conversation_id');
				if($activityType==1){
					$checkCompanyInSalesActivity = $this->opportunity_model->checkCompanyInSales($this->input->post('old_thread'),$this->input->post('c_id'));
					if(count($checkCompanyInSalesActivity)==0){
						$this->opportunity_model->insertInvitees(array('lead_id'=>$this->input->post('old_thread'),'contact_id'=>$this->input->post('c_id')));
					}					
				} else if($activityType==2){
					$checkCompanyInAcquisitionActivity = $this->opportunity_model->checkCompanyInAcquisition($this->input->post('old_thread'),$this->input->post('c_id'));
					if(count($checkCompanyInAcquisitionActivity)==0){
						$this->opportunity_model->insertAcquisitionCompany(array('lead_id'=>$this->input->post('old_thread'),'contact_id'=>$this->input->post('c_id')));
					}
				}
				
				$date = $this->input->post('date');
				$event = array();
				$event['company_id'] = $this->input->post('c_id');
				$event['contact_id'] = $this->input->post('p');
				$event['type'] = 21;
				$event['note'] = $getMessage->message;
				$event['user_id'] = $this->session->userdata['id'];
				$event['email_id'] = 0;
				$event['subject'] = "Message received from Linkedin";
				$event['lead_id'] = $this->input->post('old_thread');
				$event['activity_date'] = $date;		
				if((int)$activityType==1){
					$data['send'] = $this->lead_model->insetSalesActivity($event);
					$message = "Associate linkedin message to sales activity.";
				} else {
					$data['send'] = $this->lead_model->insertAcquistionActivity($event);
					$message = "Associate linkedin message to acquisition activity.";
				}
				try{
					$this->activityLog($event);
					if($data['send'] > 0){
						$this->lead_model->deleteLinkedinMessage($this->input->post('thread'));
						$this->load->model('client_model');
						$this->client_model->update($this->input->post('p'), array('linkedin_thread_id'=>$conversationID));
						$this->load->model('user_model');
						$user_history = array('lead_id'=>$this->input->post('old_thread'),'user_id'=>$this->session->userdata['id'],'message'=>$message,'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						
					}
				}catch(Exception $e){
					
				}				
			}
		}
		echo  json_encode($data);
		die;
	}
	
	function delete_linkedin_message(){
		$data = 0;
		if(isset($_POST)){
			$this->load->model('lead_model');
			$data = $this->lead_model->deleteLinkedinMessage($this->input->post('id'));
		}
		echo $data;
	}
	
	function linkWithMessage(){
		if(isset($_POST) && count($_POST)>0){
			$box = $_POST;			
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
			$emails = array();
			$threadComesFrom = "";
			if(isset($_SESSION['STARRED'])){
				$emails = $_SESSION['STARRED'];
				$threadComesFrom = "STARRED";
			}
			$findIDFlag = 0;
			$message = "";
			$thread_id = "";
			if(count($emails)>0){
				foreach($emails as $email){
					if($email['message_id'] == $box['thread']){
						$findIDFlag = 1;
						$message = $email['content'];
						$thread_id = $email['thread_id'];
					}
				}
			}
			if($findIDFlag==0){
				$emails = array();
				$threadComesFrom = "";
				if(isset($_SESSION['INBOX'])){
					$emails = $_SESSION['INBOX'];
					$threadComesFrom = "INBOX";
				}
				if(count($emails)>0){
					foreach($emails as $email){
						if($email['message_id'] == $box['thread']){
							$findIDFlag = 1;
							$message = $email['content'];
							$thread_id = $email['thread_id'];
						}
					}
				}
			}			
			if($findIDFlag==0){
				$emails = array();
				$threadComesFrom = "";
				if(isset($_SESSION['TRASH'])){
					$emails = $_SESSION['TRASH'];
					$threadComesFrom = "TRASH";
				}
				if(count($emails)>0){
					foreach($emails as $email){
						if($email['message_id'] == $box['thread']){
							$findIDFlag = 1;
							$message = $email['content'];
							$thread_id = $email['thread_id'];
						}
					}
				}
			}
			/*if($findIDFlag==0){
				$emails = $_SESSION['LEAD'];
				$threadComesFrom = "LEAD";
				if(count($emails)>0){
					foreach($emails as $email){
						if($email['message_id'] == $box['thread']){
							$findIDFlag = 1;
							$message = $email['content'];
							$thread_id = $email['thread_id'];
						}
					}
				}
			}
			if($findIDFlag==0){
				$messageDetail = $service->findThreadData($box['thread']);
				$findIDFlag = 1;
				$message = $messageDetail[0]['content'];
				$thread_id = $messageDetail[0]['thread_id'];
			}*/
			if($findIDFlag==0){
				$emails = array();
				$threadComesFrom = "";
				if(isset($_SESSION['SENT'])){
					$emails = $_SESSION['SENT'];
					$threadComesFrom = "SENT";
				}
				if(count($emails)>0){
					foreach($emails as $email){
						if($email['message_id'] == $box['thread']){
							$findIDFlag = 1;
							$message = $email['content'];
							$thread_id = $email['thread_id'];
						}
					}
				}
			}
			if(gettype($message)=="string"){
				$email = $service->findThreadData($box['thread']);
				if(count($email)>0){
					$message = $email[0]['content'];
					$thread_id = $email[0]['thread_id'];
				}
			}
			$filesAttachment = "";			
			$gmailMessageID = $box['thread'];			
			$attachmentArray = array();
			$content = array();
			$subjectMessage = "";
			if(is_object($message)>0){
					$messageBody = '';
					$attachmentsConnect = array();
					$parts = $message->getPayload()->getParts();
					$header = $message->getPayload()->getHeaders();
					for($j=0;$j<count($header);$j++){												
						if($header[$j]->name=='Subject'){
							$subjectMessage = $header[$j]->value;
						}
					}
					if(count($parts)>0){
						if($parts[0]->mimeType=='text/plain' || $parts[0]->mimeType=='text/html'){						
							if(isset($parts[1])  && $parts[1]->mimeType=='text/html'){
								$rawBody = $parts[1]->getBody();
							} else {
								$rawBody = $parts[0]->getBody();
							}
							$rawData = $rawBody->data;	
							$sanitizedData = strtr($rawData,'-_', '+/');
							$messageBody = base64_decode($sanitizedData);
						} else if($parts[0]->mimeType=="multipart/alternative" || $parts[0]->mimeType=="multipart/related" || $parts[0]->mimeType=="multipart/mixed"){						
							$internalParts = $parts[0]->getParts();
							if(isset($internalParts[1])){
								$rawBody = $internalParts[1]->getBody();
								$rawData = $rawBody->data;
							}
							
							if(empty($rawData)){
								$rawParts = $internalParts[0]->getParts();
								if(count($rawParts)>1){
									$rawBody = $rawParts[1]->getBody();
									$rawData = $rawBody->data;
								}	else {
									$rawBody = $internalParts[0]->getBody();
									$rawData = $rawBody->data;	
								}							
							}
							$sanitizedData = strtr($rawData,'-_', '+/');
							$messageBody = base64_decode($sanitizedData);
						} 
						if(empty($messageBody)){
							if(isset($parts[0])){
								$internalParts = $parts[0]->getParts();
								if(isset($internalParts[1])){
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
								$sanitizedData = strtr($rawData,'-_', '+/');
								$messageBody = base64_decode($sanitizedData);
							}
						}
					} else {
						$rawBody = $message->getPayload()->getBody();
						$rawData = $rawBody->data;	 
						$sanitizedData = strtr($rawData,'-_', '+/');
						$messageBody = base64_decode($sanitizedData);
						$messageBody = nl2br($messageBody);
					}					
					if(count($parts)>0 && (isset($parts[0]) && ($parts[0]->mimeType=="multipart/alternative" || $parts[0]->mimeType=="multipart/related" || $parts[0]->mimeType=="multipart/mixed") || $parts[0]->mimeType=="text/plain" || $parts[0]->mimeType=="text/html")){
						for($i=1;$i<count($parts);$i++){
							if(isset($parts[$i])){
								$attachments = $parts[$i];
								$filename =  $attachments->filename;
								$fileExt = explode('.',$filename);
								if(empty($filename) && empty($attachments->getBody()->getAttachmentId())){
									$internalParts = $parts[$i]->getParts();
									if(count($internalParts)>0){
										foreach($internalParts as $innerParts){
											if(!empty($innerParts->filename)){													
												$attachmentID = $innerParts->getBody()->getAttachmentId();
												if(!empty($attachmentID)){
													$attachmentsData = $service->downloadAttachments($gmailMessageID,$attachmentID);
													if(is_object($attachmentsData)){
														$filename = $innerParts->filename;
														$filename = str_replace(',','-',$filename);
														$rawData = $attachmentsData->data;
														$sanitizedData = strtr($rawData,'-_', '+/');
														$data = strtr($rawData, array('-' => '+', '_' => '/'));
														$body = base64_decode($sanitizedData);
														$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
														fwrite($fh, $body);
														fclose($fh);	
														/*$filesAttachment .=$this->config->base_url()."public/upload/".$filename.",";*/
														/*$fileData = $this->add_aws_file($filename,$_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
														$fileAWS = "";
														if(count($fileData)>0 && $fileData['error']==0){
															unlink($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
															$filesAttachment .= $fileData['file_url'].",";
															$fileAWS = $fileData['file_url'];
														}*/
														$filesAttachment .= $this->config->base_url()."public/upload/".$filename.",";
														$fileAWS = $this->config->base_url()."public/upload/".$filename;
														$attachmentsConnect[] = array('filename'=>$fileAWS,'mimeType'=>$parts[$i]->mimeType,"attachmentId"=>$attachmentID,"size"=>$parts[$i]->getBody()->getSize(),"realAttachID"=>'');
													}
												}
											}
										}
									}
								} else {
									if(count($fileExt)==2){
										if($fileExt[1]==""){
											switch($parts[$i]->mimeType){
												case 'application/pdf':
												$filename= $filename.".pdf";
												break;
												case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
												$filename= $filename.".docx";
												break;
												case 'application/msword':
												$filename= $filename.".doc";
												break;
												case 'application/oda':
												$filename= $filename.".oda";
												break;
												case 'application/vnd.openxmlformats-officedocument.wordprocessingml.template':
												$filename= $filename.".dotx";
												break;
												case 'application/vnd.ms-excel':
												$filename= $filename.".xls";
												break;
												case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
												$filename= $filename.".xlsx";
												break;
												case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
												$filename= $filename.".pptx";
												break;
												case 'application/vnd.openxmlformats-officedocument.presentationml.slide':
												$filename= $filename.".sldx";
												break;
												case 'application/vnd.openxmlformats-officedocument.presentationml.slideshow':
												$filename= $filename.".ppsx";
												break;
												case 'image/jpeg':
												$filename= $filename.".jpeg";
												break;
												case 'image/png':
												$filename= $filename.".png";
												break;										
												case 'image/bmp':
												$filename= $filename.".bmp";
												break;
												case 'image/gif':
												$filename= $filename.".gif";
												break;
												
											}
										}
									}
									$attachmentID = $attachments->getBody()->getAttachmentId();	
									if(!in_array($attachmentID,$attachmentArray)){
										if(!empty($filename) && !empty($attachmentID)){
											$filename = str_replace(',','-',$filename);
											$attachmentsData = $service->downloadAttachments($gmailMessageID,$attachmentID);
											if(is_object($attachmentsData)){
												$rawData = $attachmentsData->data;
												$sanitizedData = strtr($rawData,'-_', '+/');
												$data = strtr($rawData, array('-' => '+', '_' => '/'));
												$body = base64_decode($sanitizedData);
												$fileAWS = "";
												try{
													$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w");
													fwrite($fh, $body);
													fclose($fh);	
													$fileAWS =$this->config->base_url()."public/upload/".$filename;
													/*$fileData = $this->add_aws_file($filename,$_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
													$fileAWS = $fileData;*/
												}catch(Exception $e){
													
												}
												
												/*$filesAttachment .=$this->config->base_url()."public/upload/".$filename.",";*/
												
												/*if(count($fileData)>0 && $fileData['error']==0){
													unlink($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
													$filesAttachment .= $fileData['file_url'].",";
													$fileAWS = $fileData['file_url'];
												}*/
												$filesAttachment .= $this->config->base_url()."public/upload/".$filename.",";
												
												$attachmentsConnect[] = array('filename'=>$fileAWS,'mimeType'=>$parts[$i]->mimeType,"attachmentId"=>$attachmentID,"size"=>$parts[$i]->getBody()->getSize(),"realAttachID"=>'');
											}
										}
									}
								}
							}														
						}
					}
					$content[] = array("message_id"=>$message->id,"thread_id"=>$message->threadId,"labelIds"=>$message->labelIds,"header"=>$header,"body"=>$messageBody,"attachments"=>$attachmentsConnect,'ppp'=>$parts);
			}
			$this->load->model('opportunity_model');
			$this->load->model('lead_model');
			$sentFrom = 0;
			if(in_array("SENT", $message->labelIds)){
				$sentFrom = 1;
				/*Get Company ID and Company name in To first email address c_id and p*/
				$header = $message->getPayload()->getHeaders();
				$toEmailAddress = "";
				for($j=0;$j<count($header);$j++){												
					if($header[$j]->name=='To'){
						$text = $header[$j]->value;
						preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $text, $matches);
						if(isset($matches[0])){
							if(is_array($matches[0])){
								$toEmailAddress = $matches[0][0];
							} else {
								$toEmailAddress = $matches[0];
							}
						} else {
							$toEmailAddress = $text;
						}						
						break;
					}
				}
				if(!empty($toEmailAddress)){
					$getContactDetail = $this->lead_model->getContactByEmail(trim($toEmailAddress));
					if(count($getContactDetail)>0){
						$box['c_id'] = $getContactDetail->company_id;
						$box['p'] = $getContactDetail->id;
					} else {
						echo json_encode(array('send'=>0,'message'=>'Email address does not exist, Please add email address in contacts.'));
						die;
					}
				}
				/**/
			}
			$type = 0;
			if(isset($box['c_id']) && isset($box['p']) && (int)$box['p']>0 && (int)$box['c_id']>0){
				$type = 1;
			}
			$activityType=0;
			if(isset($box['t']) && (int)$box['t']){
				$activityType=$box['t'];
			}
			
			if(isset($box['from_email']) && !empty($box['from_email'])){
				$getContactDetail = $this->lead_model->getContactByEmail(trim($box['from_email']));
				if(count($getContactDetail)>0){
					if($activityType!=3){
						$box['c_id'] = $getContactDetail->company_id;
					}
					
					$box['p'] = $getContactDetail->id;
					$act = 0;
					
					$checkCompanyInSalesActivity = $this->opportunity_model->checkCompanyInSales($box['old_thread'],$getContactDetail->company_id);
					if(count($checkCompanyInSalesActivity)>0){
						$act = 1;						
					}
					if($act==0){
						$checkCompanyInAcquisitionActivity = $this->opportunity_model->checkCompanyInAcquisition($box['old_thread'],$getContactDetail->company_id);
						if(count($checkCompanyInAcquisitionActivity)>0){
							$act = 2;
						} 
					}
					if($activityType==3){
						$act = 3;
					}
					if($act>0){
						$activityType=$act;
						$type = 1;
					} else {
						echo json_encode(array('send'=>0,'message'=>'Email address does not exist in any activity.'));
						die;
					}
				} else {
					echo json_encode(array('send'=>0,'message'=>'Email address does not exist, Please add email address in contacts.'));
					die;
				}
				if($act==0 || $type==0){
					echo json_encode(array('send'=>0,'message'=>'Got some error, Please try again.'));
					die;
				}
			}
			$this->load->model('user_model');	
			if(!empty($content)){
				/*Check Thread in DB*/
				$this->lead_model->removeFromBox($box['old_thread'],$box['thread']);
				/*End checking*/
				if(!empty($filesAttachment)){
					$filesAttachment = substr($filesAttachment,0,-1);
				}
				$checkMessageInBox = $this->lead_model->findBoxByMessageID($box['thread']);
				$insertEmail= false;
				if(count($checkMessageInBox)==0){
					$sendData = $this->lead_model->insertBox(array("lead_id"=>$box['old_thread'],"user_id"=>$this->session->userdata['id'],"thread_id"=>$thread_id,'message_id'=>$box['thread'],"content"=>json_encode($content),"file_attach"=>$filesAttachment,"date_received"=>date('Y-m-d H:i:s', strtotime($box['date'])),'type'=>$type,'sent_from'=>$sentFrom));
					$user_history = array('lead_id'=>$box['old_thread'],'user_id'=>$this->session->userdata['id'],'message'=>"Add email into box.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));					
					$this->user_model->addUserHistory($user_history);
					$insertEmail = true;
					/*Delete Message*/
					if(isset($_SESSION[$threadComesFrom])):
					$unEmail = $_SESSION[$threadComesFrom];
					if(count($unEmail)>0){					
						$index=-1;
						$i=0;
						foreach($unEmail as $email){
							if($email['message_id'] == $box['thread']){							
								$index=$i;
							}
							$i++;
						}
						if($index>=0){
							unset($unEmail[$index]);
							$emailsREIndex = array_values($unEmail);
							$_SESSION[$threadComesFrom] = $emailsREIndex;
						}					
					}
					endif;
					/*Delete Message From Session*/
				} else {
					$sendData = $checkMessageInBox[0]->id;
				}
							
				if($type==1 && $insertEmail===true){
					
					if($activityType==1){
						$checkCompanyInSalesActivity = $this->opportunity_model->checkCompanyInSales($box['old_thread'],$box['c_id']);
						if(count($checkCompanyInSalesActivity)==0){
							$this->opportunity_model->insertInvitees(array('lead_id'=>$box['old_thread'],'contact_id'=>$box['c_id']));
						}
						
					} else if($activityType==2){
						$checkCompanyInAcquisitionActivity = $this->opportunity_model->checkCompanyInAcquisition($box['old_thread'],$box['c_id']);
						if(count($checkCompanyInAcquisitionActivity)==0){
							$this->opportunity_model->insertAcquisitionCompany(array('lead_id'=>$box['old_thread'],'contact_id'=>$box['c_id']));
						}
					}
					if($box['date']==""){
						$date = date('Y-m-d H:i:s');
					} else {
						$date = date('Y-m-d H:i:s', strtotime($box['date']));
					}
					$event = array();
					$event['company_id'] = $box['c_id'];
					$event['contact_id'] = $box['p'];
					$event['type'] = 6;
					$event['note'] = '';
					$event['user_id'] = $this->session->userdata['id'];
					$event['email_id'] = $sendData;
					$event['subject'] = $subjectMessage;
					$event['lead_id'] = $box['old_thread'];
					$event['activity_date'] = $date;
					$message = "";
					if((int)$activityType==1){
						$this->lead_model->insetSalesActivity($event);
						$message = "Associate email to sales activity.";
					}else if((int)$activityType==3){
						$this->lead_model->insertPreSaleActivity($event);
						$message = "Associate email to PreSale activity.";		
					} else {
						$this->lead_model->insertAcquistionActivity($event);
						$message = "Associate email to acquisition activity.";
					}
					$this->activityLog($event);
					$user_history = array('lead_id'=>$box['old_thread'],'user_id'=>$this->session->userdata['id'],'message'=>$message,'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
				}
				if($sendData>0){
					$labels = $service->listLabels();
					$labelID = "";
					foreach($labels as $key=>$label){
						if(strtoupper($label)=="LEAD"){
							$labelID = $key;
						} 
					}
					if(empty($labelID)){
						/*Create label*/
						$label = $service->createLabel("LEAD");
						if(is_object($label) && $label->getId()!=""){
							$labelID = $label->getId();
						}
						/*End Create Label*/
					}
					if(!empty($labelID) && $insertEmail===true){
						$service->modifyMessage($gmailMessageID,"me",$labelID);
						$service->modifyMessageRemove($gmailMessageID,"me",array('INBOX','STARRED'));
						/*$service->modifyMessageRemove($gmailMessageID,"me",'STARRED');*/
					}  
					echo json_encode(array('send'=>$sendData));
				} else {
					echo json_encode(array('send'=>0));
				}
			} else {
				echo json_encode(array('send'=>0));
			}			
		} else {
			echo json_encode(array('send'=>0));
		}
		die;
	}
	
	function intialiseAfter(){
		/*if(isset($_POST) && count($_POST)>0){
			if((int)$this->input->post('inta')==1){
				$user_data = $this->session->userdata;
				$user_data['initialise_email'] = 1;
				$this->session->set_userdata($user_data);
				/**/
				/*$this->load->model('user_model');
				$this->user_model->updateAllLogTime($this->session->userdata['id']);*/
				/**/
			/*}
		}*/
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
	
	function index($id=null){		
		$data = array();
		$this->load->model('opportunity_model');
		if((int)$this->session->userdata['type']==8 || (int)$this->session->userdata['type']==9 ){
			$data['waiting_approval'] = $this->opportunity_model->waitingApproval($this->session->userdata['id']);
		}
		$data['emails'] = array();
		$this->load->library('DriveServiceHelper');
		if(!isset($_SESSION)){
			session_start();		
		}
		
		$service = new GmailServiceHelper();
		$this->load->model('user_model');
		unset($_SESSION['clicked_url']);
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
		$user_data['title'] = $user->title;
		$user_data['email_for_signature'] = $user->email_for_signature;
		$user_data['signature'] = $emailSignature;
		$user_data['original_signature'] = $originalSignature;
		
		if(!isset($_SESSION)){
			session_start();
		}	
		
		$_SESSION['find_user'] = $user_data;
		
		$this->session->set_userdata($user_data);

		$getUserData = $this->user_model->getUserData($this->session->userdata['id'],"google_token");
		$userAccessToken = '' ;
		
		if(count($getUserData)>0 && !empty($getUserData->google_token)){				
			$userAccessToken = $getUserData->google_token;
		}
		
		if(empty($userAccessToken)){
			$data['auth_url'] = $service->createAuthUrl();
			$data['emails'] = array();	
		} else {			
			$google_token= json_decode($userAccessToken);
			$newToken = "";
			if($service->checkExpiredToken()){
				if(isset($google_token->refresh_token)){
					try{
						$service->refreshToken($google_token->refresh_token);
						$newToken = json_decode($service->getAccessToken());
						$google_token->id_token = $newToken->id_token;
						$google_token->access_token = $newToken->access_token;
						$google_token->created = $newToken->created;
						$google_token = json_encode($google_token);	
						$this->user_model->updateUserData(array("google_token"=>$google_token),$this->session->userdata['id']);
						$_SESSION['another_access_token'] = $google_token;
						$_SESSION['access_token'] = $google_token;
					}catch(Exception $e){
						$data['auth_url'] = $service->createAuthUrl();
						$data['emails'] = array();
						$google_token= "";
					}					
				} else {
					$data['auth_url'] = $service->createAuthUrl();
					$data['emails'] = array();
					$google_token= "";
				}		
			} else {
				$google_token= $userAccessToken;
			}			
			if(!empty($google_token)):
			$service->setAccessToken($google_token);
			$_SESSION['user_gmail_label'] = $service->listLabels();
			$userInfoArray = 	$service->getAuthUserEmail();
			if(isset($userInfoArray->email)){
				if($userInfoArray->email==$this->session->userdata['email']){					
					$sign = $this->user_model->signature();
					$originalSignature = $sign->signature;
					$emailSignature = $originalSignature;
					$user = $this->user_model->getUserData($this->session->userdata['id']);
					unset($user->google_token);
					$emailSignature = str_replace('#Name#',$user->name,$emailSignature);
					if(!empty($user->mobile_number)){
						$emailSignature = str_replace('#Mobile#',"M: ".$user->mobile_number,$emailSignature);
					} else {
						$emailSignature = str_replace('#Mobile#',"",$emailSignature);
					}
					$emailSignature = str_replace('#Email#',$user->email,$emailSignature);
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
					$user_data['title'] = $user->title;
					$user_data['signature'] = $emailSignature;
					$user_data['original_signature'] = $originalSignature;
					if(!isset($_SESSION)){
						session_start();
					}
					$_SESSION['find_user'] = $user_data;
					$this->session->set_userdata($user_data);
					$data['auth_url'] = "";
				} else {
					$this->session->set_flashdata('error','Login with your email id only.');
					$data['emails'] = array();
					$data['auth_url'] = $service->createAuthUrl();
					$_SESSION['clicked_url'] = "dashboard";	
					unset($_SESSION['another_access_token']);
				}
			} else {
				$data['auth_url'] = $service->createAuthUrl();
				$_SESSION['clicked_url'] = "dashboard";	
				$data['emails'] = array();
				unset($_SESSION['another_access_token']);
			}
			endif;
		}
		$this->load->model('customer_model');
		$data['category_list'] = $this->customer_model->getCategoryBySector(21);
		$this->layout->title_for_layout = 'Backyard Dashboard';
		$this->layout->render('user/dashboard',$data);
	}
	
	public function charts($id=null){
		$this->layout->layout='opportunity';
		$this->layout->title_for_layout = 'Backyard Charts';
		$this->load->model('lead_model');
		$data['lucidPatents'] = $this->lead_model->findLucidData($id);
		if(count($data['lucidPatents'])==0){
			$getLeadData = $this->lead_model->getLeadData($id);
			if(count($getLeadData)>0){
				if(!empty($getLeadData->patent_data)){
					try{
						$patentData = json_decode($getLeadData->patent_data);
						if(count($patentData)>0){
							foreach($patentData as $patent){
								if($patent[0]!=null){
									$this->lead_model->insertChart(array("lead_id"=>$id,"patent"=>$patent[0]));
								}
							}
							$data['lucidPatents'] = $this->lead_model->findLucidData($id);
						}
					} catch(Exception $e ){
						
					}
				}
			}
		}
		$this->layout->render('user/chart',$data);
	}
	
	function createDocument($patent,$leadID){
		$documentId = $this->input->get('documentId');
		if(!empty($patent) && !empty($leadID) && !empty($documentId)){
			$this->load->model('lead_model');
			$this->lead_model->updateChartWithLead($leadID,$patent,array("file_url"=>$documentId));
			redirect('dashboard/index/'.$leadID);
		} else {
			redirect('dashboard');
		}
	}
	function generateRandomString($digits = 5) {
		$min = pow(10, $digits - 1);
		$max = pow(10, $digits) - 1;
		return mt_rand($min, $max);		
	}
	
	function setDrivePermissionToServiceAccount(){
		$this->load->library("DriveServiceHelper");
		$this->config->load('config');
		$service = new DriveServiceHelper();
		$serviceAccount = $this->config->item("g_service_account");
		/*
			Operations Folder: 0B61I0m5ybHrFTENoYUpZcGVMbGM
			Leads Folder: 0B61I0m5ybHrFLUN0UG1LLW8wSXM
			Internal Folder: 0B_Do1Yd0xSmXfjBRakRTUHVyWnhIaGswM1U3SXc4cEQ3QWRuUTFDMnhLMkd5XzhlR21NWmM
			Non Acquisiton Folder: 0B_Do1Yd0xSmXfjBLUUlhZEF0UTVRRFdEcnpVVERyMzd5M0FmZ2hyN0NZQWxBcUoydG1PR00			
		*/
		$folderList = array('0B61I0m5ybHrFTENoYUpZcGVMbGM','0B61I0m5ybHrFLUN0UG1LLW8wSXM','0B_Do1Yd0xSmXfjBRakRTUHVyWnhIaGswM1U3SXc4cEQ3QWRuUTFDMnhLMkd5XzhlR21NWmM','0B_Do1Yd0xSmXfjBLUUlhZEF0UTVRRFdEcnpVVERyMzd5M0FmZ2hyN0NZQWxBcUoydG1PR00');
		foreach($folderList as $folder){
			$permissionList = $service->getPrmissionsList($folder);
			if(count($permissionList)>0){
				foreach($permissionList as $list){
					if($list->name == $serviceAccount){
						$service->updatePermission($folder,$list->id,"writer");
					}
				}
			}
		}
	}
	
	function create_lead(){
		if(isset($_POST) && count($_POST)>0){
			$name = $this->input->post('n');
			$type = $this->input->post('t');
			if(!empty($name) && !empty($type)){
				$this->load->model('lead_model');
				/*Check Lead Name*/				
				$findLead = $this->lead_model->findLeadByName($name);
				if(count($findLead)==0){
					$serial_number = $this->getNewSerialNumber(0,$this->generateRandomString());
					$this->load->library("DriveServiceHelper");
					$service = new DriveServiceHelper();
					$leadFolderID = false;
					switch($type){
						case 'NON':
							/*$leadFolderID = $service->getFileInfo(NONACQUISITIONS_FOLDERID);*/
							$leadFolderID = (object)array('id'=>NONACQUISITIONS_FOLDERID);
						break;
						case 'INT':
							/*$leadFolderID = $service->getFileInfo(INTERNAL_FOLDERID);*/
							$leadFolderID = (object)array('id'=>INTERNAL_FOLDERID);
						break;
						default:
							/*$leadFolderID = $service->getFileInfo(LEADS_FOLDERID);	*/
							$leadFolderID = (object)array('id'=>LEADS_FOLDERID);
						break;
					}					
					if(is_object($leadFolderID)){
						$fileParent = new Google_Service_Drive_ParentReference();
						$fileParent->setId( $leadFolderID->id );
						$getFolderInfo = $service->createSubFolder($name.'_folder',$fileParent);
						if($getFolderInfo){							
							$lead = array("lead_name"=>$name,"type"=>$type,'folder_id'=>$getFolderInfo,'serial_number'=>$serial_number,"user_id"=>$this->session->userdata['id'],"complete"=>0,"create_date"=>date('Y-m-d H:i:s'));		
							$lead_id = $this->lead_model->from_litigation_insert($lead);
							if($lead_id>0){
								/*image_folder*/
								$fileParent = new Google_Service_Drive_ParentReference();
								$fileParent->setId( $getFolderInfo );
								$getImageFolderInfo = $service->createSubFolder('Docket Files',$fileParent);
								if($getImageFolderInfo){
									$service->setAdditionalPermissions($getImageFolderInfo, "","writer","anyone");
									$this->lead_model->from_litigation_update($lead_id,array("image_folder"=>$getImageFolderInfo));
								}
								$getPdfFolderInfo = $service->createSubFolder('RTP',$fileParent);
								if($getPdfFolderInfo){
									$service->setAdditionalPermissions($getPdfFolderInfo, "","writer","anyone");
									$this->lead_model->from_litigation_update($lead_id,array("pdf_folder"=>$getPdfFolderInfo));
								}
								
								$getCustomerFolderInfo = $service->createSubFolder(CUSTOMER_FOLDER,$fileParent);
								if($getCustomerFolderInfo){
									$service->setAdditionalPermissions($getCustomerFolderInfo, "","writer","anyone");
									$this->lead_model->from_litigation_update($lead_id,array("customer_folder"=>$getCustomerFolderInfo));
								}
								/*Seller Material Folder*/
								$getSellerFolderInfo = $service->createSubFolder(SELLER_MATERIAL,$fileParent);
								if($getSellerFolderInfo){
									$service->setAdditionalPermissions($getSellerFolderInfo, "","writer","anyone");
									$this->lead_model->from_litigation_update($lead_id,array("seller_material_folder_id"=>$getSellerFolderInfo));
								}
								$this->load->model('user_model');
								$this->load->model('general_model');
								$findUser = $this->user_model->findAllInsiderUser('1');
								if(count($findUser)>0){
									$bulkAssignLead = array();
									foreach($findUser as $user){	/*$this->user_model->insert_assign_lead(array('lead_id'=>$lead_id,'pd_id'=>$user->id));*/
										$bulkAssignLead[] = array('lead_id'=>$lead_id,'pd_id'=>$user->id);
									}
									if(count($bulkAssignLead)>0){
										$this->user_model->insert_assign_lead_bulk($bulkAssignLead);
									}
								} else {
									$this->user_model->insert_assign_lead(array('lead_id'=>$lead_id,'pd_id'=>$this->session->userdata['id']));
								}								
								/*End*/
								if($type=="SEP"){
									$type="General";
								}
								$getButtonList = $this->general_model->getAllButtonList($type);
								if(count($getButtonList)>0){
									$bulkArray = array();
									foreach($getButtonList as $button){				    /*$this->lead_model->insertLeadButton(array("lead_id"=>$lead_id,"sort"=>$button->sort,"button_id"=>$button->id));*/
										$bulkArray[] = array("lead_id"=>$lead_id,"sort"=>$button->sort,"button_id"=>$button->id);
									}
									/*Insert Bulk*/
									$this->lead_model->insertLeadButtonBulk($bulkArray);
								}
								/*Move all skeleton to lead*/
								$allTemplates = $this->general_model->getAllTemplates();
								if(count($allTemplates)>0){
									$this->load->model('acquisition_model');
									$this->load->model('customer_model');
									$bulkArrayTemplates = array();
									foreach($allTemplates as $row){					
										$template = $row->template_html;					
										$urlName ="";
										if($row->main_type=="2"){	
											$acquisition = $this->acquisition_model->getData($lead_id);
											$category_list = $this->customer_model->categoryList(0);
											$lead_data = $this->lead_model->getLeadDataWithOptions($lead_id,'serial_number');
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
													$urlName ='/departments/'.$urlName.'-'.$acquisition['acquisition']->category.'/'.$lead_data->serial_number.'/';
												}
											}
											endif;
											if(!empty($urlName)){
												$urlName = "https://www.synpat.com".$urlName;
											}
											$template =  str_replace('link-data-href=""',"href='".$urlName."'",$template);
										}
										$bulkArrayTemplates[] = array('lead_id'=>$lead_id,'subject'=>$row->subject,'template_html'=>$template,'type'=>$row->type,'template_name'=>$row->template_name,'main_type'=>$row->main_type);
										/*$data =  $this->general_model->moveAllToLeadBankTemplate(array('lead_id'=>$lead_id,'subject'=>$row->subject,'template_html'=>$template,'type'=>$row->type,'template_name'=>$row->template_name,'main_type'=>$row->main_type));*/
									}
									if(count($bulkArrayTemplates)>0){
										$data =  $this->general_model->moveAllToLeadBankTemplateBulk($bulkArrayTemplates);
									}
									if($data>0){
										$user_history = array('lead_id'=>$this->input->post('lead_id'),'user_id'=>$this->session->userdata['id'],'message'=>"Move skeleton to lead templates.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
										$this->user_model->addUserHistory($user_history);
									}
								}								
								/*End*/
								$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$lead_id,'message'=>'Created lead from '.$type,'create_date'=>date('Y-m-d H:i:s')));
								echo $lead_id;
							} else {
								echo "0";
							}
						} else {
							echo "0";
						}
					} else {
						echo "0";
					}					
				} else {
					echo "-1";
				}
			} else {
				echo "0";
			}
		} else {
			echo "0";
		}
		die;
	}
	
	public function delete_lead(){
		$data = 0;
		if(isset($_POST) && $this->input->post('b')>0){
			$this->load->model('lead_model');
			$checkLeadData = $this->lead_model->getLeadData($this->input->post('b'));
			$status = '3';
			if(count($checkLeadData)>0){
				$this->load->model('user_model');
				if($checkLeadData->status=='3'){
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$deleteFiles = $service->deleteFilesFolder($checkLeadData->folder_id);
					if($deleteFiles){
						$data = $this->lead_model->deleteLead($this->input->post('b'));
						$data = 1;
						$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$this->input->post('b'),'message'=>'Delete lead - '.$checkLeadData->lead_name,'create_date'=>date('Y-m-d H:i:s')));
					}
				} else {
					$this->lead_model->from_litigation_update($this->input->post('b'),array("status"=>$status));
					$data =  1;
					$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$this->input->post('b'),'message'=>'Change Status of lead.','create_date'=>date('Y-m-d H:i:s')));
				}
			}
		}		
		echo $data;
	}
	
	
	public function findLeadPrePatent($lead=0){
		$data['prePatents'] = array();
		$data['lead'] = 0;
		if(isset($lead) && count($lead)>0){
			if((int)$lead>0){
				$this->load->model('lead_model');
				$getLeadData =  $this->lead_model->getLeadDataWithOptions($lead,'l.id,l.serial_number');
				if(count($getLeadData)>0){
					$curl = curl_init();
					curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://synpat.com/getPrePatents.php',
					CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'serial_number' => $getLeadData->serial_number,
					)				
					));
					$resp = curl_exec($curl);
					if($resp){
						$data['prePatents'] = json_encode($resp);
					}
					$data['lead'] = $lead;
				}
			}			
		}
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Backyard Pre Lead Patents';
		$this->layout->render('user/lead_pre_patent',$data);
	}
	
	function potentialParticipant($ID,$leadID,$fileURL){
		$resp= 0;
		if($ID>0){			
			$this->load->model('lead_model');
			$allRequestData = $this->lead_model->findRequestToParticipantById($ID,"*");
			$resp = 0;
			if(count($allRequestData)>0 && $allRequestData->status==1){
				$createDate = date('Y-m-d H:i:s');
				$newPotentialData = array('company_name'=>$allRequestData->company_name,'person_name'=>$allRequestData->person_name,'person_phone'=>$allRequestData->person_phone,'person_email'=>$allRequestData->person_email,'message'=>$allRequestData->message,'file'=>$fileURL,'create_date'=>$allRequestData->create_date,'send_date'=>$createDate,'type'=>$allRequestData->type,'license_id'=>$allRequestData->license_id,'customer_id'=>$allRequestData->customer_id,'price'=>$allRequestData->price,'doc_type'=>$allRequestData->document_type,'company_id'=>$allRequestData->company_id,'display'=>1);
				$resp = $this->lead_model->insertPotentialParticipant($newPotentialData);
				if($resp>0){
					/*display data on chart*/
					$commitedData = $this->lead_model->findAllDisplayPriceData($allRequestData->license_id,"send_date,price",array(1));
					$this->lead_model->deleteCommitments($allRequestData->license_id);
					if(count($commitedData)>0){
						/*Delete COmmitted Data*/
						for($i=0;$i<count($commitedData);$i++){	
							$this->lead_model->insertCommitment(array('license_id'=>$allRequestData->license_id,'commitment_date'=>$commitedData[$i]->send_date,'amount'=>$commitedData[$i]->price));
						}								
					}
					$this->load->model('opportunity_model');
					$this->opportunity_model->updateLicenseAccessCode(array('current_requesting_companies'=>count($commitedData)),$allRequestData->license_id,0);					
					/*Send Notification*/
					$getLeadData = $this->lead_model->findLeadFromLicenseID($allRequestData->license_id,'l.id,l.serial_number');
					if(count($getLeadData) >0){
						$getPortfolioData = $this->callPortfolioData($allRequestData->license_id,$getLeadData->id,$getLeadData->serial_number);
						$this->sendPushNotification('store',$getPortfolioData);
					}
					
					/*End chart*/
					/*Update request to participate in deal flow*/
					$checkDealFlow = $this->lead_model->findCustomerDealFlowByCustomerAndCompanyIDAndleadID($allRequestData->customer_id,$allRequestData->company_id,$leadID,$allRequestData->document_type,"id");
					if(count($checkDealFlow) > 0){
						$this->lead_model->updateCustomerDealFlow(array('syndication'=>$fileURL,"syndication_filename"=>$allRequestData->file_name,"modified_date"=>$createDate),$checkDealFlow->id);
					}
					$this->lead_model->deleteRequestToParticipate($ID);
					$checkCustomerLicenseAgreement = $this->lead_model->findLicenseAgreementByFileUrl($fileURL);
					$companyID = 0;
					if($allRequestData->company_id > 0 && $allRequestData->document_type == 3){
						$getCompanyName = $this->lead_model->findCompanyData($allRequestData->company_id);
						if(count($getCompanyName)>0){
							$companyID = $getCompanyName->id;
						}
					} else if( $allRequestData->document_type == 2){
						$getCompanyName = $this->lead_model->findCompanyData($findCustomerData->company_id);
						if(count($getCompanyName)>0){
							$companyID = $getCompanyName->id;
						}
					}
					$findCustomerData = $this->lead_model->getCustomerInfoByID($allRequestData->customer_id,"company_id");
					if(count($checkCustomerLicenseAgreement)==0){
						if($companyID>0){
							$licenseData = array('lead_id'=>$leadID,'company_id'=>$findCustomerData->company_id,'file_type'=>$allRequestData->document_type,'target'=>'','target_company_id'=>$companyID,'price'=>$allRequestData->price,'date'=>date('Y-m-d H:i:s'),'stage'=>$allRequestData->type,'document'=>$fileURL,'document_name'=>'');
							$this->lead_model->insertCustomerLicenseAgreement($licenseData);
						}
					} else {					
						if($companyID>0){
							$licenseData = array('lead_id'=>$leadID,'company_id'=>$findCustomerData->company_id,'file_type'=>$allRequestData->document_type,'target'=>'','target_company_id'=>$companyID,'price'=>$allRequestData->price,'date'=>date('Y-m-d H:i:s'),'stage'=>$allRequestData->type,'document'=>$fileURL);
							$this->lead_model->updateCustomerLicenseAgreementByID($licenseData,$checkCustomerLicenseAgreement->id);
						}
					}		
					/*Send Notification*/
					$getLeadData = $this->lead_model->getLeadDataWithOptions($leadID,'l.id,l.serial_number');
					if(count($getLeadData) >0){
						$getPortfolioData = $this->callPortfolioData($allRequestData->license_id,$getLeadData->id,$getLeadData->serial_number);
						$this->sendPushNotification('store',$getPortfolioData);
					}
				}
			}
		}
		return $resp;
	}
	
	public function callPortfolioData($licenseID,$leadID,$serialNumber){
		$data = array();
		$this->load->model('lead_model');
		$getLeadData = $this->lead_model->getLeadDataWithOptions($leadID,"l.serial_number");
		if(count($getLeadData) > 0){
			$this->load->model('acquisition_model');
			$rowData = $this->acquisition_model->getDataByOptions($leadID,'a.*');
			$data['portfolio_number'] = $serialNumber;
			if($rowData->option_expiration_data != "0000-00-00"){
				$data['option_expiration_data'] = date('d M y',strtotime($rowData->option_expiration_data));
			}
			if($rowData->regular_license_starts != "0000-00-00 00:00:00"){
				$data['regular_license_starts'] = date('d M y',strtotime($rowData->regular_license_starts));
			}
			if($rowData->late_license_starts  != "0000-00-00 00:00:00"){
				$data['late_license_starts'] = date('d M y',strtotime($rowData->late_license_starts ));
			}
			if($rowData->active_button  > 0){
				$data['active_button'] = $rowData->active_button;
			}
			if($rowData->final_participants < 1) {
				$data['final_participants'] = 'TBD';
			} else {
				$data['final_participants'] = $rowData->final_participants;
			}
			if($rowData->potential_participants < 1) {
				$data['potential_participants'] = 3;
			} else {
				$data['potential_participants'] = $rowData->potential_participants;
			}
			$million  = 1000000;
			if($rowData->seller_asking_price != '0.0') {
				/*$rowData->seller_asking_price = '$'.$rowData->seller_asking_price.'M';*/
				$data['seller_asking_price'] = '$'.number_format($rowData->seller_asking_price*$million);
			} else {
				$data['seller_asking_price'] = '0.0';
			}
			$validatedPrice = '3 x TBD';
			$validate = false;
			if((int)$rowData->active_button > 1) {
				$validate = true;
				if(!is_numeric($rowData->cost_price)) {
					$validatedPrice = '3 x '.$rowData->cost_price;
				} else {
					/*$validatedPrice = '$'. round(3 * $rowData->cost_price, 3,PHP_ROUND_HALF_UP).'M'; */
					$validatedPrice = '$'. number_format((3 * $rowData->cost_price)*$million); 
				}
			}
			$data['validate_price'] = $validatedPrice;
			$data['validate'] = $validate;
			if($rowData->late_license_starts!='0000-00-00 00:00:00') {
				$data['validate_start'] = date('d M Y',strtotime($rowData->late_license_starts));
			}
			$regular = false;
			$regularPrice = '1.5 x TBD';
			if((int)$rowData->active_button > 1) {
				if(!is_numeric($rowData->cost_price)) {
					$regularPrice = '1.5 x '.$rowData->cost_price;
				} else {
					/*$regularPrice = '$'. round(1.5 * $rowData->cost_price, 3,PHP_ROUND_HALF_UP).'M'; */
					$regularPrice = '$'. number_format((1.5 * $rowData->cost_price)*$million); 
				}
			}
			if((int)$rowData->active_button == 2) {
				$regular = true;
			}			
			$data['regular_price'] = $regularPrice;
			$data['regular'] = $regular;
			$sold = false;
			if((int)$rowData->active_button > 2) {
				$sold = true;
			}
			$data['sold']= $sold;
			$participate = false;
			$participatePrice = 'TBD';
			if($rowData->cost_price!=0.0) {
				if(!is_numeric($rowData->cost_price)) {
					$participatePrice = $rowData->cost_price;
				} else {
					/*$participatePrice = '$'. round($rowData->cost_price, 3,PHP_ROUND_HALF_UP).'M'; */
					$participatePrice = '$'. number_format($rowData->cost_price * $million); 
				}
			}
			$data['cost_price'] = number_format($rowData->cost_price*$million);
			if((int)$rowData->active_button == 1) {
				$participate = true;
			}			
			$data['participate_price'] = $participatePrice;
			$data['participate'] = $participate;
			$data['commitments'] = $this->lead_model->findCommitmentsData($licenseID,"*");
		}
		return $data;
	}
	
	public function sendPushNotification($action,$portfolioData){
		require(APPPATH.'third_party/push/autoload.php');
		$this->config->load('config');
		$postData = $this->input->post();
		$options = array('encrypted' => true,'cluster' => $this->config->item('APP_CLUSTER'),'host'=>$this->config->item('APP_CLUSTER_HOST'));
		$pusher = new Pusher($this->config->item('PUSHER_APP_ID'),$this->config->item('PUSHER_APP_KEY'),$this->config->item('PUSHER_APP_SECRET'),$options);
		$showData = array('action'=>$action,'data'=>0,'message'=>json_encode($portfolioData),'type'=>0);
		$data = array();
		$data['message'] = json_encode($showData);
		$pusher->trigger('notifications', 'new_notification', $data);
	}
	
	function fileUploadFromFTPAndDrive($file,$filename,$l,$request){
		$getUploadFileData = (object) array();
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/uploadFileToServer',
			CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => array(
				'source' => $file,
				'destination'=>$filename,
			)				
		));							
	$resp = curl_exec($curl);
	if(!empty($resp)){
		if($resp=="Done"){
			$this->load->model('lead_model');
			$getLeadData = array();
			if($l>0){
				$getLeadData = $this->lead_model->getLeadData($l);
			} else {
				if($request->License->serial_number>0){
					$getLeadData = $this->lead_model->findSerialNumber($request->License->serial_number);
				}										
			}									
			if(count($getLeadData)>0){
				if(!empty($getLeadData->folder_id)){
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$parent = new Google_Service_Drive_ParentReference();
					$parent->setId($getLeadData->folder_id);
					$fileName = $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename;
					$finfo = finfo_open(FILEINFO_MIME_TYPE);
					$mimeType =  finfo_file($finfo, $fileName);
					if($mimeType=="application/zip"  && strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) == 'docx'){
						$mimeType = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
					}
					finfo_close($finfo);
					$convert=true;
					if($mimeType=="application/pdf" || ($mimeType == 'inode/x-empty' && strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) == 'pdf')) {    
						$convert=false;
						$mimeType="application/pdf";
					}					
					$getUploadFileData = $service->insertFile($filename,$mimeType,$fileName,$parent,$convert);
					if($getUploadFileData){												
						unlink($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
					}
				}
			}
		}
	}
	return $getUploadFileData;
	}
	
	function getFileIDFromUrl($file){
		$file = str_replace("/view?usp=drivesdk","",$file);
		$file = str_replace("/edit?usp=drivesdk","",$file);
		$fileUrlExplode = explode('/',$file);
		return array_pop($fileUrlExplode);
	}
	
	function send_revised(){
		$data = array('id'=>0);
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			/*$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/fineRevisedDocData',
				CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					'i' => $postData['i']
				)				
			));
			$resp = curl_exec($curl);		*/	
			$this->load->model('lead_model');	
			$request = $this->lead_model->getRevisedDocumentByID($postData['i'],'message,license_aggreement,strategic_aggreement,request_aggreement,program_aggreement,license_id,customer_id,type,rf_type,file_name,create_date,approved,download,company_id,company_name,your_name,email_address,telephone');
			$resp = true;
			if($resp){
				/*$request = json_decode($resp);*/
				if(count($request)>0){
					$license_aggreement = $request->license_aggreement;
					$strategic_aggreement = $request->strategic_aggreement;
					$request_aggreement = $request->request_aggreement;
					$program_aggreement = $request->program_aggreement;
					$licenseUpload = array('file_url'=>'','id'=>'','name'=>'');
					$strategicUpload = array('file_url'=>'','id'=>'','name'=>'');
					$requestUpload = array('file_url'=>'','id'=>'','name'=>'');
					$programUpload = array('file_url'=>'','id'=>'','name'=>'');
					if(!empty($license_aggreement)){
						$file = $license_aggreement;
						$ID = $this->getFileIDFromUrl($file);
						$licenseUpload = array('file_url'=>$file,'id'=>$ID,'name'=>"PLA");
					}
					if(!empty($strategic_aggreement)){
						$file = $strategic_aggreement;
						$ID = $this->getFileIDFromUrl($file);
						$strategicUpload = array('file_url'=>$file,'id'=>$ID,'name'=>"ERA");
					}
					if(!empty($request_aggreement)){
						$file = $request_aggreement;
						$ID = $this->getFileIDFromUrl($file);
						$requestUpload = array('file_url'=>$file,'id'=>$ID,'name'=>"RTP");
					}
					if(!empty($program_aggreement)){
						$file = $program_aggreement;
						$ID = $this->getFileIDFromUrl($file);
						$programUpload = array('file_url'=>$file,'id'=>$ID,'name'=>"PPP");
					}								
					$fileURL = '';
					$getLeadInfo = $this->lead_model->getLeadDataWithOptions($postData['l'],'l.lead_name');
					if(count($getLeadInfo)>0){
						$note = $request->message;
						if(!empty($licenseUpload['file_url']) && (int)$request->rf_type == 2){
							$fileURL = $licenseUpload['file_url'];
							$note = $note.'<br/><a  href="javascript://" data-file-id="'.$licenseUpload['id'].'" onclick=\'open_drive_files("'.trim($licenseUpload['file_url']).'");\' data-href="'.$licenseUpload['file_url'].'" data-mime="" target="_blank" style="color:#2196f3"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$licenseUpload['name'].'</a>';		
						}
						if(!empty($strategicUpload['file_url']) && (int)$request->rf_type == 3){
							$fileURL = $strategicUpload['file_url'];
							$note = $note.'<br/><a  href="javascript://" data-file-id="'.$strategicUpload['id'].'" onclick=\'open_drive_files("'.trim($strategicUpload['file_url']).'");\' data-href="'.$strategicUpload['file_url'].'" data-mime="" target="_blank" style="color:#2196f3"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$strategicUpload['name'].'</a>';		
						}											
						$eDate = date('Y-m-d H:i:s');
						if(isset($postData['e']) && $postData['e']>0){
							$emailActivityData = $this->lead_model->getPersonCompanyDetailFromSalesActivityLogByEmailID($postData['e']);
							if(count($emailActivityData)>0){
								$eDate = $emailActivityData->activity_date;
								$eDate = date('Y-m-d H:i:s',strtotime('-1 seconds',strtotime($eDate)));
							}
						}
						$saveData = array('lead_id'=>$postData['l'],'company_id'=>$postData['c'],'contact_id'=>$postData['p'],'type'=>6,'note'=>$note,'user_id'=>$this->session->userdata['id'],'subject'=>$getLeadInfo->lead_name,'activity_date'=>$eDate);
						$dataSales = $this->lead_model->insetSalesActivity($saveData);
						$this->activityLog($saveData);
						if($dataSales>0){
							$data['id'] = $dataSales;
							$this->load->model('user_model');
							$user_history = array('lead_id'=>$postData['l'],'user_id'=>$this->session->userdata['id'],'message'=>'Add Email in sales activity','opportunity_id'=>0,'create_date'=>$eDate);
							$this->user_model->addUserHistory($user_history);
							/*$this->lead_model->deleteRevisedDocumentByID($postData['i']);*/
							/*Update Revised Document with send date and bold for customer and read by synpat*/
							if(isset($postData['e']) && $postData['e']>0){
								$emailID = $postData['e'];
								$emailDate = $this->lead_model->findEmailDate($emailID);
								$this->lead_model->updateRevisedDocumentRequest(array("confirm_date"=>$emailDate,"status"=>2),$postData['i']);
								$executedFileUrl = "";
								$executedFileName = "";
								if($request->download==1){
									$getLicenseData = $this->lead_model->findLeadFromLicenseID($request->license_id,'l.option_expiration_date');
									$todayDate = strtotime(date('Y-m-d'));
									if($todayDate>strtotime($getLicenseData->option_expiration_date)){
										/*In License stage and now move to the pending proof of payment i.e potential_participant table*/
										
										if(isset($postData['f']) && $postData['f']!=""){
											
											$this->load->library('simple_html_dom');
											$html = $this->simple_html_dom->load($postData['f'],true,true);
											$allAnchor = array();
											foreach($html->find('<ul class="attachment-list">') as $asTable) {
												foreach($asTable->find('<li class="attachment-list-item">') as $title){
													$titles = "";
													$img = "";
													$href = "";
													foreach($title->find("img") as $img){
														if(!empty($img->src)){
															$img = $img->src;
														}
													}
													foreach($title->find("a") as $anchor){
														if(!empty($anchor->innertext) && empty($titles)){
															$titles = $anchor->innertext;
														}
														if(!empty($anchor->plaintext) && empty($titles)){
															$titles = $anchor->plaintext;
														}
														if(!empty($anchor->{'data-href'})){
															$href = $anchor->{'data-href'};
														}
														if(empty($href)){
															if(!empty($anchor->{'href'})){
																$href = $anchor->{'href'};
															}
														}
													}
													$allAnchor[] = array('title'=>$titles,'img'=>$img,'href'=>$href);
												}									
											}	
											if(count($allAnchor)>0){		
												foreach($allAnchor as $href){
													if(strpos($href['href'],"drive.google.com")!==false){
														$executedFileUrl = $href['href'];
														$executedFileName = $href['title'];
														break;
													}
												}
											}
										}
										
										$tDate = date('Y-m-d H:i:s');
										/*$potentialParticipant = array('license_id'=>$request->license_id,'customer_id'=>$request->customer_id,'company_name'=>$request->company_name,'person_name'=>$request->your_name,'person_phone'=>$request->telephone,'person_email'=>$request->email_address,'file'=>$fileURL,'type'=>2,'create_date'=>$tDate,'upload_date'=>$tDate,'proof_of_payment'=>'','execute_agreement'=>$executedFileUrl,'doc_type'=>$request->rf_type,'company_id'=>$request->company_id,'status'=>3);	
										$insertData = $this->lead_model->insertPotentialParticipant($potentialParticipant);
										
										if($insertData>0){
											$this->lead_model->deleteRevisedDocumentByID($postData['i']);
										}*/
										$this->lead_model->deleteRevisedDocumentByID($postData['i']);
									}
								}
								if(!empty($fileURL)){
									/*Update Customer Transaction*/
									/*$this->lead_model->updateCustomerTransactionRequest(array("user_send"=>2),$fileURL);*/
									/*Get data from revised document and add or update in deal flow.*/
									$checkRecordInDeal = $this->lead_model->findCustomerDealFlowByUrlAndCustomerID($fileURL,$request->customer_id,'id');
									$dealFlow = array();
									$dealFlow['user_send'] = 2;
									if($executedFileUrl != ""){
										$dealFlow['executed_by_synpat'] = $executedFileUrl;
										$dealFlow['synpat_filename'] = $executedFileName;
									}
									if(count($checkRecordInDeal)==0){										
										$dealFlow['customer_id'] = $request->customer_id;
										$dealFlow['license_type'] = $request->rf_type;
										$dealFlow['customize_file'] = $fileURL;
										$dealFlow['customize_filename'] = $request->file_name;
										$dealFlow['agreement_status'] = 1;
										$dealFlow['availability'] = 2;
										$dealFlow['created_date'] = $request->create_date;
										$dealFlow['lead_id'] = $postData['l'];
										$this->lead_model->insertCustomerDealFlow($dealFlow);
									} else {
										$this->lead_model->updateCustomerDealFlow($dealFlow,$checkRecordInDeal->id);
									}
								}
							}
						}						
					}
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	function send_c(){
		$data = array("error"=>1);
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			/*$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/findRequestData',
				CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					'i' => $postData['i']
				)				
			));
			$resp = curl_exec($curl);*/
			/*Find Request*/
			$resp = true;
			$this->load->model('lead_model');
			$request = $this->lead_model->findRequestToParticipantById($postData['i'],'file,type,message,status,price');
			if($resp){
				/*$request = json_decode($resp);*/
				if(count($request)>0){
					if($request->status==0){
						$date = date('Y-m-d H:i:s');
						if(isset($postData['e']) && $postData['e'] > 0){
							$getEmail = $this->lead_model->findBoxNewById($postData['e']);
							if(count($getEmail) > 0){
								$date = $getEmail[0]->date_received;
							}
						}
						$affectedRows = $this->lead_model->updateRequestParticpantData(array('status'=>2,'replied'=>$date),$postData['i']);
						if($affectedRows>0){
							$data = array("error"=>0,"id"=>$postData['i'],"message"=>"");
						} else {
							$data = array("error"=>1,"id"=>$postData['i'],"message"=>"");
						}
					} else {
						if(!empty($request->file)){
							$file = $request->file;
							/*$fileInfo = pathinfo($file);*/
							/*$filename = $fileInfo['filename'].".".$fileInfo['extension'];	*/	
							/*$filename = $fileInfo['basename'];		*/
							$filename = '';		
							if((int)$request->type==0){
								$filename = "RTP - ".$filename;
							} else if((int)$request->type==1){
								$filename = "RFL - ".$filename;
							}
							if(!empty($file)){
								$fileId = $this->getFileIDFromUrl($file);
								
								$getLeadData = array();
								if($postData['l']>0){
									$getLeadData = $this->lead_model->getLeadData($postData['l']);
								} else {
									if($request->License->serial_number>0){
										$getLeadData = $this->lead_model->findSerialNumber($request->License->serial_number);
									}										
								}
								if(count($getLeadData)>0){
									if(!empty($getLeadData->folder_id)){
										$this->load->library('DriveServiceHelper');
										$service = new DriveServiceHelper();
										$getUploadFileData = $service->moveFile($fileId,$getLeadData->folder_id);
										if($getUploadFileData){
											/*$templateData = $this->general_model->getTemplateBYType(1);
											$data['error']= "0";
											$data['file']= $getUploadFileData;
											$data['template']= $templateData->template_html;
											$data['subject']= $templateData->subject;
											$data['lead_id'] = $getLeadData->id;*/
											$service->setAdditionalPermissions( $getUploadFileData->id, $this->session->userdata['email'],"reader","anyone",array('emailMessage'=>'File has been share with you .','sendNotificationEmails'=>true));	
											$fileURL = "https://docs.google.com/file/d/".$getUploadFileData->id."/preview";										
											$note = $request->message.'<br/><a  href="javascript://" data-file-id="'.$getUploadFileData->id.'" onclick=\'open_drive_files("'.trim($fileURL).'");\' data-href="'.$getUploadFileData->alternateLink.'" data-mime="'.$getUploadFileData->mimeType.'" style="color:#2196f3"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$getUploadFileData->title.'</a>';
											$saveData = array('lead_id'=>$getLeadData->id,'company_id'=>$postData['c'],'contact_id'=>$postData['p'],'type'=>6,'note'=>$note,'user_id'=>$this->session->userdata['id'],'subject'=>$getLeadData->lead_name,'activity_date'=>date('Y-m-d H:i:s'));
											$dataSales = $this->lead_model->insetSalesActivity($saveData);
											$this->activityLog($saveData);
											if($dataSales>0){
												/*current_requesting_companies*/
												$this->load->model('user_model');
												/*Request go to potential participate if status=>1*/
												$potential = $this->potentialParticipant($postData['i'],$getLeadData->id,$getUploadFileData->alternateLink);
												$data = array("error"=>0,"id"=>$dataSales,"message"=>"","potential"=>$potential);
												$user_history = array('lead_id'=>$getLeadData->id,'user_id'=>$this->session->userdata['id'],'message'=>'Add Email in sales activity','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
												$this->user_model->addUserHistory($user_history);
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
		echo json_encode($data);
		die;
	}
	
	function confirm_request_payment(){
		$data = array("error"=>1);
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			$this->load->model('lead_model');
			$getParticpantRequestData = $this->lead_model->findRequestToParticipantById($postData['i'],'license_id,customer_id,type,create_date,file,company_name,person_name,person_phone,person_email');
			/*Send payment notification*/
			if(count($getParticpantRequestData)>0){
				$this->lead_model->insertRequestParticipant(array('license_id'=>$getParticpantRequestData->license_id,'customer_id'=>$getParticpantRequestData->customer_id,'create_date'=>date('Y-m-d H:i:s'),'type'=>5,'company_name'=>$getParticpantRequestData->company_name,'person_name'=>$getParticpantRequestData->person_name,'person_phone'=>$getParticpantRequestData->person_phone,'person_email'=>$getParticpantRequestData->person_email));
			}
			
			/*End payment notice*/
			if($updateData>0){
				$data = array("error"=>0,"id"=>$postData['i'],"message"=>"");
			} else {
				$data['message'] = "Please try after sometime.";
			}
		}
		echo json_encode($data);
		die;
	}
	
	function update_payment_notification(){
		$data = array("error"=>1);
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			$this->load->model('lead_model');
			
			$getPotentialParticipantData = $this->lead_model->getPotentialDataByID($postData['i'],'id,status,file');
			if(count($getPotentialParticipantData)>0){
				switch($getPotentialParticipantData->status){
					case 0:
					case 1:
					case 3:	
						$updateArray = array('payment_notice'=>date('Y-m-d H:i:s'));
						if($getPotentialParticipantData->status==1){
							$files = $postData['files'];
							$allAnchor = array();
							$updateArray['status'] =3;
							/*if($getPotentialParticipantData->file!=""){
								$updateArray['execute_agreement'] = $getPotentialParticipantData->file;
							}*/
							/*if(!empty($files)){
								$this->load->library('simple_html_dom');
								$html = $this->simple_html_dom->load($files,true,true);
								foreach($html->find('<ul class="attachment-list">') as $asTable) {
									foreach($asTable->find('<li class="attachment-list-item">') as $title){
										$titles = "";
										$img = "";
										$href = "";
										foreach($title->find("img") as $img){
											if(!empty($img->src)){
												$img = $img->src;
											}
										}
										foreach($title->find("a") as $anchor){
											if(!empty($anchor->innertext) && empty($titles)){
												$titles = $anchor->innertext;
											}
											if(!empty($anchor->plaintext) && empty($titles)){
												$titles = $anchor->plaintext;
											}
											if(!empty($anchor->{'data-href'})){
												$href = $anchor->{'data-href'};
											}
											if(empty($href)){
												if(!empty($anchor->{'href'})){
													$href = $anchor->{'href'};
												}
											}
										}
										$allAnchor[] = array('title'=>$titles,'img'=>$img,'href'=>$href);
									}									
								}						
							} 
							if(count($allAnchor)>0){
								$updateArray['execute_agreement'] = $allAnchor[0]['href'];
							}*/
						}/* else if($getPotentialParticipantData->status==0){
							$updateArray = array('status'=>2);
						}*/
						if(count($updateArray)>0){
							$updateData = $this->lead_model->updatePotentialData($updateArray,$postData['i']);
							/*End payment notice*/
							if($updateData>0){
								$data = array("error"=>0,"id"=>$postData['i'],"message"=>"");
							} else {
								$data['message'] = "Please try after sometime.";
							}
						} else {
							if($getPotentialParticipantData->status==0){
								$data = array("error"=>0,"id"=>$postData['i'],"message"=>"");
							}
						}
					break;
					case 4:
						$getPotentialParticipantData = $this->lead_model->getPotentialDataByID($postData['i'],'*');
						$insertLicenseGranted = array('license_id'=>$getPotentialParticipantData->license_id,'customer_id'=>$getPotentialParticipantData->customer_id,'company_name'=>$getPotentialParticipantData->company_name,'type'=>$getPotentialParticipantData->type,'create_date'=>date('Y-m-d H:i:s'),'proof_of_payment'=>$getPotentialParticipantData->proof_of_payment,'execute_agreement'=>$getPotentialParticipantData->execute_agreement,'amount'=>$getPotentialParticipantData->amount,'doc_type'=>$getPotentialParticipantData->doc_type,'company_id'=>$getPotentialParticipantData->company_id);
						$insertData = $this->lead_model->insertLicenseGranted($insertLicenseGranted);
						if($insertData>0){
							$data = array("error"=>0,"id"=>$insertData,"message"=>"License Granted");
							$this->lead_model->deletePotentialParticipant($getPotentialParticipantData->id);
						}
					break;
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	
	function downloadRevisedDocumentLockFile(){
		$data = array('download_link'=>'','update'=>0);
		if(isset($_POST) && count($_POST)>0){
			$file = $this->input->post('file');
			$fileId = $this->getFileIDFromUrl($file);
			if($fileId!=""){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$getFileInfo = $service->getFileInfo($fileId);
				if(is_object($getFileInfo)){
					$getDownloadPDFLink = $getFileInfo->exportLinks['application/pdf'];
					if($getDownloadPDFLink!=""){
						$this->load->model('lead_model');
						$data['update'] = $this->lead_model->updateRevisedDocumentRequest(array('download'=>1),$this->input->post('l'));
						if($data['update']==0){
							$getRevisedData = $this->lead_model->getRevisedDocumentByID($this->input->post('l'),'download');
							if($getRevisedData->download==1){
								$data['update'] = 1;
							}
						}
						$data['download_link'] = $getDownloadPDFLink;
					}					
				}
			}
		}
		echo json_encode($data);
		die;
		
	}
	
	function updatePricePotential(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			if((int)$postData['i']>0 && (float)$postData['p']>0){
				$this->load->model('lead_model');
				$data = $this->lead_model->updatePotentialData(array('colored'=>0,"price"=>$postData['p'],"display"=>0),$postData['i']);				
			}
		}
		echo $data;
		die;
	}
	
	function updateAmountPotential(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			if((int)$postData['i']>0 && (float)$postData['p']>0){
				$this->load->model('lead_model');
				$data = $this->lead_model->updatePotentialData(array("amount"=>$postData['p']),$postData['i']);		
				if($data>0){
					/*Update in Customer Transaction*/
					$getPotentialInfo = $this->lead_model->getPotentialDataByID($postData['i'],"file");
					if(count($getPotentialInfo)>0){
						$fineCustomerTransactionData = $this->lead_model->findCustomerTrasactionDataByFileUrl($getPotentialInfo->file,"id");
						if(count($fineCustomerTransactionData)>0){
							$this->lead_model->updateCustomerTransactionRequest(array('amount'=>$postData['p']),$getPotentialInfo->file);
						}
					}
				}
			}
		}
		echo $data;
		die;
	}
	
	function approved_revised_agreement(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			if((int)$postData['i']>0 && isset($postData['p'])){
				$this->load->model('lead_model');
				$approval = $postData['p'];
				$dataUpdate = array("approved"=>$approval);
				$t = $postData['t'];
				if($t==0){
					$dataUpdate['status'] = 1;
				}
				$dataUpdate['download'] = 0;
				if($approval==1){
					$dataUpdate['download'] = 1;
				}
				/*$t = $postData['p'];
				$status = 1;
				if($t==1){
					$status = 2;
				}*/
				/*$data = $this->lead_model->updateRevisedDocumentRequest(array("approved"=>$approval,'status'=>$status),$postData['i']);	*/
				$data = $this->lead_model->updateRevisedDocumentRequest($dataUpdate,$postData['i']);
				$getRevisedData = $this->lead_model->getRevisedDocumentByID($postData['i'],'type,rf_type,license_aggreement,strategic_aggreement');
				if(count($getRevisedData)>0){
					$file = "";
					if($getRevisedData->rf_type==2){
						$file = $getRevisedData->license_aggreement;
					} else if($getRevisedData->rf_type==3){
						$file = $getRevisedData->strategic_aggreement;
					}
					if(!empty($file)){
						if($data>0){
							/*Update in deal flow*/
							$agreementStatus = 1;
							if($approval==1){
								/*Locked and only for view*/
								$agreementStatus = 2;
							}
							$findDealRow = $this->lead_model->findCustomerDealFlowByUrl($file);
							if(count($findDealRow)>0){
								$this->lead_model->updateCustomerDealFlow(array('user_send'=>1,'agreement_status'=>$agreementStatus),$findDealRow->id);
							}						
						}
						$fileID = $this->getFileIDFromUrl($file);
						
						if(!empty($fileID)){
							$service = new DriveServiceHelper();
							$getPermissionList = $service->getPrmissionsList($fileID);
							/*echo"<pre>";
								print_r($getPermissionList);*/
							if(count($getPermissionList)>0){
								$allFilesRemovePermission = array();
								if($approval==0){
									foreach($getPermissionList as $permission){
										/*count($permission->additionalRoles)>0 && */
										if($permission->type=="anyone"){
											$allFilesRemovePermission[] = array('id'=>$fileID,'permission_id'=>$permission->id); 
											break;
										}
									}
									if(count($allFilesRemovePermission)>0){
										/*echo "<pre>";print_r($allFilesRemovePermission);*/
										foreach($allFilesRemovePermission as $per){
											$service->deletePermission($per['id'],$per['permission_id']);
										}
										//$service->batchRequestForRemovePermissions($allFilesRemovePermission);
									}
									$getPermissionList = $service->getPrmissionsList($fileID);
								}
								$service->setPermissions($fileID,'uzi@synpat.com');
								/*$service->setPermissions($fileID,'webmaster@synpat.com');*/
								if($approval==1){
									/*Can View only*/
									$getData = $service->setPermissions($fileID,null,"reader","anyone");
									//$getData = $service->updatePermission($fileID,"anyoneWithLink","reader");

								} else if($approval==0){
									/*Can edit*/
									/*$service->setAdditionalPermissions($fileID, '', 'writer', $type = 'anyone');*/
									$getData = $service->setAdditionalPermissions($fileID, '', 'reader', 'anyone');
								}
								$getPermissionList = $service->getPrmissionsList($fileID);
								/*echo"<pre>";
								print_r($getPermissionList);*/
							}
						}
					}
				}				
			}
		}
		echo $data;
		die;
	}
	
	function get_count_on_rtp(){
		$this->load->model('lead_model');
		/*$data = array('rtp'=>0,'rd'=>0,'ca'=>0);*/
		/*Count request to participate and request for revised documents*/
		$data = $this->lead_model->count_request();
		echo json_encode($data);
		die;
	}
	
	function get_count_on_customer_request(){
		$this->load->model('lead_model');
		echo $this->lead_model->count_customer_request();
		die;
	}
	
	public function licensees($leadID=0,$t=1){
		$data = array('licensees'=>array());
		/*if((int)$leadID==0){
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/findRequestToParticipant',
				CURLOPT_USERAGENT => 'Send Request for create demo portfolio'				
			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			if($resp){
				$data['licensees'] = json_decode($resp);
			}
		} else {
			$this->load->model('acquisition_model');
			$getStoreName = $this->acquisition_model->getData($leadID);
			if(count($getStoreName)>0){
				$curl = curl_init();
				// Set some options - we are passing in a useragent too here
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/findRequestToParticipant/'.$getStoreName['acquisition']->store_name,
					CURLOPT_USERAGENT => 'Send Request for create demo portfolio'				
				));
				// Send the request & save response to $resp
				$resp = curl_exec($curl);
				if($resp){
					$data['licensees'] = json_decode($resp);
				}
			}
		}*/
		/*if($t<1 || $t==3){
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/findRequestToParticipant',
				CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					't' => $t
				)				
			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			if($resp){
				$data['licensees'] = json_decode($resp);
			}
		}*/
		$data['availability'] = array();
		$data['availability_confirmed'] = array();
		$data['license_list'] = array();
		if($t==3 || $t==10 || $t==11 || $t==12){
			$this->load->model('lead_model');
			/*$leadID*/
			$c = 0;
			if($t==3){
				$status = array(0,1,2,3);
				$type = array(0,1);
				$c = 1;
				$data['licensees'] = $this->lead_model->findPotentialParticipants(0,$status,$c,$type);
			} else if($t==10){
				$type = array(3,4);
				$status = array(1,2,3,4);
				$c = 2;
				$data['licensees'] = $this->lead_model->findPotentialParticipants(0,$status,$c,$type);
			} else if($t==11){
				$data['licensees'] = $this->lead_model->findUnPromisedParticipants(0);
			} else if($t==12){
				$data['licensees'] = $this->lead_model->findGrantedLicense(0);
			}
		} else if($t==2){
			$this->load->model('lead_model');
			/*$leadID*/
			$data['licensees'] = $this->lead_model->findRevisedDocuments(0);
		} else if($t<=1 || $t==8 || $t==9){
			$this->load->model('lead_model');
			/*$leadID*/
			$arrayDoc = array();
			$tap = 0;
			if($t<=1){
				$arrayDoc = array(0,1);
				$tap = 1;
			}else if($t==8){
				$arrayDoc = array(2,3);
			}else if($t==9){
				$arrayDoc = array(4);
			}
			if(count($arrayDoc)>0){
				$data['licensees'] = $this->lead_model->findRequestToParticpants(0,$arrayDoc,$tap);
			} else {
				$data['licensees'] = (object)array('participant'=>array());
			}			
			$data['license_list'] = $this->lead_model->getAllCustomerLicense();
		} else if($t==4){
			$this->load->model('lead_model');
			$dataAvailability = $this->lead_model->checkRequestForAvailability();
			$data['availability'] = $dataAvailability['availability'];
			$data['availability_confirmed'] = $dataAvailability['availability_confirmed'];
			$data['license_list'] = $this->lead_model->getAllCustomerLicense();
		}		
		$data['t'] = $t;
		$this->layout->layout='outsource';	
		$this->layout->title_for_layout = 'POS';
		$this->layout->render('user/licensees',$data);
	}
	
	public function litigation(){
		$lead_id = 0;
		$data = array('update'=>0,'data'=>array(),'message'=>"");
		if(isset($_POST) && count($_POST)>0){
			$litigationData = $this->input->post();			
            $litigationData['litigation']['user_id']= $this->session->userdata['id'];
			if(!isset($litigationData['complete'])){
				$litigationData['complete'] = 0;
			}
			if(isset($litigationData['litigation']['worksheet_id']) && $litigationData['litigation']['worksheet_id']=='-- Select Worksheet --'){
				$litigationData['litigation']['worksheet_id'] = '';
			}
			$user_id  = $this->session->userdata['id'];
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$this->load->model('acquisition_model');
			if((int)$litigationData['litigation']['id']>0) {
				/*Check Lead Name*/
				$litigationData['litigation']['update_date']= date('Y-m-d H:i:s');
				$findLeadByName = $this->lead_model->findLeadByName($litigationData['litigation']['lead_name'],'l.id,l.serial_number');
				if(count($findLeadByName)>0){
					if($findLeadByName->id ==$litigationData['litigation']['id']){
						if((int)$findLeadByName->serial_number==0){
							$litigationData['litigation']['serial_number'] = $this->getNewSerialNumber(0,$this->generateRandomString());
						}
						$data['update'] = $this->lead_model->from_litigation_update($litigationData['litigation']['id'],$litigationData['litigation']);
						$lead_id = $saveLitigation;
						$data['message'] = 'Record updated.';
						$this->user_model->addUserHistory(array('user_id'=>$user_id,'lead_id'=>$saveLitigation,'message'=>'Update lead data From Litigation.','create_date'=>date('Y-m-d H:i:s')));
					} else {
						$data['message'] = 'Lead name already exist.';
					}
				} else {
					/*Rename Lead name*/
					$data['update'] = $this->lead_model->from_litigation_update($litigationData['litigation']['id'],$litigationData['litigation']);
					$lead_id = $saveLitigation;
					$findLeadByName = $this->lead_model->getLeadDataWithOptions($lead_id,'l.folder_id');
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$service->renameFile($findLeadByName->folder_id,$litigationData['litigation']['lead_name'].'_folder');
					$data['message'] = 'Record updated.';
					$this->user_model->addUserHistory(array('user_id'=>$user_id,'lead_id'=>$saveLitigation,'message'=>'Update lead data From Litigation.','create_date'=>date('Y-m-d H:i:s')));
				}
				if($lead_id>0){
					$data['data'] = $this->lead_model->findLeadTableData($lead_id);
				}
				$portfolioName = "Licensing";
				if(!empty($litigationData['litigation']['seller_contact']) && !empty($litigationData['litigation']['market_industry'])){
					$portfolioName = "Licensing of ".$litigationData['litigation']['market_industry']." acquired from ".$litigationData['litigation']['seller_contact'];
				} else if(!empty($litigationData['litigation']['seller_contact'])){
					$portfolioName = "Licensing of acquired from ".$litigationData['litigation']['seller_contact'];
				} else if(!empty($litigationData['litigation']['market_industry'])){
					$portfolioName = "Licensing of ".$litigationData['litigation']['market_industry']." acquired from ";
				}
				$this->updatePortfolioname($postData['lead_id'],$portfolioName);
			}			
		} else {
			$data['message'] = 'No data submit.';
		}
		echo json_encode($data);
		die;
	}
	
	public function updatePortfolioname($lead_id,$portfolioName){
		/*Update portfolio name in Docket if enable*/
		$this->load->model('acquisition_model');
		$getAcqData = $this->acquisition_model->getData($lead_id);
		$data = array();		
		if(count($getAcqData)>0){
			if(isset($getAcqData['acquisition']) && count($getAcqData['acquisition'])>0){
				$postData = array();
				$postData['license_number'] = $getAcqData['acquisition']->store_name;
				$postData['portfolio_name'] = $portfolioName;
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/update_accordion_data',
					CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => $postData
				));
				// Send the request & save response to $resp
				$resp = curl_exec($curl);
				if($resp){
					$data =$resp;
				}
			}
		}		
		return $data;
	}
	
	Public function getNewSerialNumber($flag=0,$serialNumber){
		if($flag==1){
			$serialNumber = $this->generateRandomString();
		}		
		$this->load->model('lead_model');
		$checkSerialNumber = $this->lead_model->findSerialNumber($serialNumber);
		if(count($checkSerialNumber)==0){
			return $serialNumber;
		} else {
			return $this->getNewSerialNumber(1,$serialNumber);
		}
	}
	
	public function update_category(){
		$updateData = 0;
		if(isset($_POST) && count($_POST)>0){		
			$category = $this->input->post('c');	
			$leadID = $this->input->post('l');	
			$acquisitionID = $this->input->post('a');
			if($leadID > 0){
				$this->load->model('acquisition_model');
				$getAcqusitionData = $this->acquisition_model->getData($leadID);
				if(count($getAcqusitionData)>0){
					$updateData = $this->acquisition_model->updateData($lead_id,array('category'=>$category));
				}
			}			
		}
		echo $updateData;
	}
	
	/*function market(){
		$lead_id = 0;
		if(isset($_POST) && count($_POST)>0){			
			$marketData = $this->input->post();			
			
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$this->load->model('acquisition_model');
			$checkData = $this->lead_model->checkDataFromSameOwnerToday($marketData['market']['plantiffs_name'],date('Y-m-d'),'Market');
			$portfolioIncrementNumber = (int)$checkData->portfolio + 1;
			$portfolioNumber = 'PN'.date('mdy').'-'.$portfolioIncrementNumber;
						
			$marketData['market']['user_id']= $this->session->userdata['id'];
			$marketData['market']['create_date']= date('Y-m-d H:i:s');
			$marketData['market']['type']= 'Market';
			$marketData['market']['portfolio_number']= $portfolioNumber;
			$gmailMessageID = $marketData['market']['gmail_message_id'];
			unset($marketData['market']['gmail_message_id']);
			if(!isset($marketData['market']['complete'])){
				$marketData['market']['complete'] = 0;
			}
			if(isset($marketData['market']['worksheet_id'])&& $marketData['market']['worksheet_id']=='-- Select Worksheet --'){
				$marketData['market']['worksheet_id'] = '';
			} 
			
			if((int)$marketData['market']['id']==0){
			    $this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$saveMarket = $this->lead_model->from_litigation_insert($marketData['market']);
				$lead_id = $saveMarket;
				$leadFolderID = $service->getFileInfo(LEADS_FOLDERID);
				if(is_object($leadFolderID)){
					$fileParent = new Google_Service_Drive_ParentReference();
					$fileParent->setId( $leadFolderID->id );
					$getFolderInfo = $service->createSubFolder($marketData['market']['lead_name'].'_folder',$fileParent);
					if($getFolderInfo){
						$this->lead_model->from_litigation_update($saveMarket,array('folder_id'=>$getFolderInfo));
					}
				}
				
				if(isset($_SESSION['another_access_token']) && !empty($_SESSION['another_access_token'])){
					if(!empty($gmailMessageID)){
						if(!isset($_SESSION)){
							session_start();
						}
						$service = new GmailServiceHelper();
						$service->setAccessToken($_SESSION['access_token']);
						$getMessageData = $service->findThreadData($gmailMessageID);
						$filesAttachment = "";						
						if(count($getMessageData)>0){
							foreach($getMessageData as $message){
								foreach($message['attachments'] as $attachments){
									$attachmentID = $attachments['attachmentId'];
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
										$fileData = $this->add_aws_file($filename,$_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
										if(count($fileData)>0 && $fileData['error']==0){
											unlink($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
											$filesAttachment .= $fileData['file_url'].",";
										}										
									}
								}
							}
						}
						$labels = $service->listLabels();
						$labelID = "";
						foreach($labels as $key=>$label){
							if(strtoupper($label)=="LEAD"){
								$labelID = $key;
							}
						}
						if(empty($labelID)){
							
							$label = $service->createLabel("LEAD");
							if(is_object($label) && $label->getId()!=""){
								$labelID = $label->getId();
							}
							
						}
						if(!empty($labelID)){
							$service->modifyThreadRemove($gmailMessageID,"me",'INBOX');
							$service->modifyThread($gmailMessageID,"me",$labelID);
						}
						$filesAttachment = substr($filesAttachment,0,-1);
						$this->lead_model->insertBox(array("lead_id"=>$saveMarket,"thread_id"=>$gmailMessageID,"content"=>json_encode($getMessageData),"file_attach"=>$filesAttachment));
					}
				}
				$lead_id = $saveMarket;
				$user_history = array('lead_id'=>$saveMarket,'user_id'=>$this->session->userdata['id'],'message'=>'Create a lead from Market.','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
				$this->user_model->addUserHistory($user_history);
			} else {
				$id = $marketData['market']['id'];
				$lead_id = $id;
				unset($marketData['market']['id']);
				unset($marketData['market']['gmail_message_id']); 
				
				$findLeadByName = $this->lead_model->findLeadByName($marketData['market']['lead_name']);
				if(count($findLeadByName)>0){
					if($findLeadByName->id == $id){
						if((int)$findLeadByName->serial_number==0){
							$marketData['market']['serial_number'] = $this->getNewSerialNumber(0,$this->generateRandomString());
						}
						$saveMarket = $this->lead_model->from_litigation_update($id,$marketData['market']);
						$user_history = array('lead_id'=>$id,'user_id'=>$this->session->userdata['id'],'message'=>'Update a lead from Market.','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						$this->session->set_flashdata('message','Record updated.');
					} else {
						$this->session->set_flashdata('error','Lead name already exist.');
						echo "Lead name already exist;";
					}
				}  else {
					$saveMarket = $this->lead_model->from_litigation_update($id,$marketData['market']);
					$findLeadByName = $this->lead_model->getLeadData($id);
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$service->renameFile($findLeadByName->folder_id,$marketData['market']['lead_name'].'_folder');
					
					$user_history = array('lead_id'=>$lead_id,'user_id'=>$this->session->userdata['id'],'message'=>'Update a lead from Market.','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
					$this->session->set_flashdata('message','Record updated.');
				}
			}
			if(isset($lead_id) && $lead_id>0){
				if(isset($marketData['market']['expected_price']) && !empty($marketData['market']['expected_price'])){
					$getAcqusitionData = $this->acquisition_model->getData($lead_id);
					if(count($getAcqusitionData)>0){
						$updateData = $this->acquisition_model->updateData($lead_id,array('seller_asking_price'=>$marketData['market']['expected_price'],'option_expiration_data'=>$marketData['market']['option_expiration_date']));
						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/license_other_update_data',
							CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
							CURLOPT_POST => 1,
							CURLOPT_POSTFIELDS => array(
								'license_number' => $getAcqusitionData['acquisition']->store_name,
								'asking_price'=>$marketData['market']['expected_price'],
								'option_expiration_date'=>$marketData['market']['option_expiration_date']
							)				
						));
						$resp = curl_exec($curl);
						
					}
				}
				$portfolioName = "Licensing";
				if(!empty($marketData['market']['seller_contact']) && !empty($marketData['market']['relates_to'])){
					$portfolioName = "Licensing of ".$marketData['market']['relates_to']." acquired from ".$marketData['market']['seller_contact'];
				} else if(!empty($marketData['market']['seller_contact'])){
					$portfolioName = "Licensing of acquired from ".$marketData['market']['seller_contact'];
				} else if(!empty($marketData['market']['relates_to'])){
					$portfolioName = "Licensing of ".$marketData['market']['relates_to']." acquired from ";
				}
				$this->updatePortfolioname($lead_id,$portfolioName);
			}
		} else {
			$this->session->set_flashdata('error','Please try after sometime.');
		}		
	}*/
	function update_main_category(){
		$data = 0;
		if(isset($_POST) && count($_POST) > 0){
			$leadID = $this->input->post('lead');
			$c = $this->input->post('c');
			if($leadID > 0 && $c > 0){
				$this->load->model('lead_model');
				$this->lead_model->updateLeadCategory($leadID,array('main_category'=>0));
				$data = $this->lead_model->updateLeadCategoryByLeadIDCategory($leadID,$c,array('main_category'=>1));
			}
		}
		echo $data;
		die;
	}
	
	function findPDFFolder($start,$field,$reName){
		$field = 'seller_material_folder_id';
		
		$this->load->model('lead_model');
		$getLeads = $this->lead_model->findLeads($start,$field);
		if(count($getLeads)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$reName = SELLER_MATERIAL;
			foreach($getLeads as $lead){
				echo "Filed:".$lead->id."@@".$lead->{$field}."<br/>";
				$service->renameFile($lead->{$field},urldecode($reName));
			}
		}
		die;
	}
	
	function searchFolderLeadDriveFolder($start,$field= 'seller_material_folder_id'){
		$field= 'seller_material_folder_id';
		$this->load->model('lead_model');
		$getLeads = $this->lead_model->findLeads($start,$field);
		if(count($getLeads)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			foreach($getLeads as $lead){
				$q = "title  contains  Customers Files and mimeType = 'application/vnd.google-apps.folder'";
				$listFiles = $service->searchFileIDFromChildern($lead->folder_id,$q);
				$customerFolderID = "";
				if(count($listFiles)==0){
					/*Create Customer Folder*/
					$fileParent = new Google_Service_Drive_ParentReference();
					$fileParent->setId($lead->folder_id);	
					$customerFolderID = $service->createSubFolder(CUSTOMER_FOLDER,$fileParent);
				} else {
					if(count($listFiles)>0){ 
						foreach($listFiles as $file){
							if($file->title=="Customers Files"){
								$customerFolderID = $file->id;
								break;
							}
						}
					}
					if($customerFolderID != ""){						
						$service->renameFile($customerFolderID,CUSTOMER_FOLDER);
					}
				}
				if($customerFolderID != ""){
					/*echo "Filed:".$lead->id."@@".$customerFolderID."<br/>";*/
					$this->lead_model->from_litigation_update($lead->id,array('customer_folder'=>$customerFolderID));
				}				
			}
		}
	}
	function share_image($leadID,$t=0){
		$data = array('t'=>$t);
		$this->load->model('lead_model');
		$getLeadInfo = $this->lead_model->getLeadDataWithOptions($leadID,'l.serial_number');
		if(count($getLeadInfo) >0){
			$queryString = md5($getLeadInfo->serial_number);
			$data['portfolioToken'] = $queryString;
		}
		$this->layout->title_for_layout = 'Portfolio Sharing';
		$this->layout->layout='outsource';
		$this->layout->render('user/portfolio_share',$data);
	}
	function getIntroImages($leadID){
		$data = array('images'=>array(),'selected_images'=>'');
		$this->load->model('lead_model');
		$getLeadInfo = $this->lead_model->getLeadDataWithOptions($leadID,'l.serial_number');
		if(count($getLeadInfo) >0){
			$queryString = md5($getLeadInfo->serial_number);
			$data = $this->lead_model->getDocketIntroImages($getLeadInfo->serial_number);
		}
		echo json_encode($data);
		die;
	}
	
	function updateIntroImages(){
		$leadID = 387;
		$this->load->model('lead_model');
		$getLeadInfo = $this->lead_model->getLeadDataWithOptions($leadID,'l.serial_number');
		$updateData = array();
		if(count($getLeadInfo) >0){
			$queryString = md5($getLeadInfo->serial_number);
			$data = $this->lead_model->getDocketIntroImagesWithFields($getLeadInfo->serial_number);
			if(count($data) > 0){
				$leftImage = $data->file_left;
				if($leftImage != ""){
					$updateData['file_left'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_middle;
				if($leftImage != ""){
					$updateData['file_middle'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_right;
				if($leftImage != ""){
					$updateData['file_right'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_four;
				if($leftImage != ""){
					$updateData['file_four'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_five;
				if($leftImage != ""){
					$updateData['file_five'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_six;
				if($leftImage != ""){
					$updateData['file_six'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_seven;
				if($leftImage != ""){
					$updateData['file_seven'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_eight;
				if($leftImage != ""){
					$updateData['file_eight'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_nine;
				if($leftImage != ""){
					$updateData['file_nine'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_ten;
				if($leftImage != ""){
					$updateData['file_ten'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_eleven;
				if($leftImage != ""){
					$updateData['file_eleven'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twelve;
				if($leftImage != ""){
					$updateData['file_twelve'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_thirteen;
				if($leftImage != ""){
					$updateData['file_thirteen'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_fourteen;
				if($leftImage != ""){
					$updateData['file_fourteen'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_fiveteen;
				if($leftImage != ""){
					$updateData['file_fiveteen'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_sixteen;
				if($leftImage != ""){
					$updateData['file_sixteen'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_seventeen;
				if($leftImage != ""){
					$updateData['file_seventeen'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_eighteen;
				if($leftImage != ""){
					$updateData['file_eighteen'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_nineteen;
				if($leftImage != ""){
					$updateData['file_nineteen'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twenty;
				if($leftImage != ""){
					$updateData['file_twenty'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twentyone;
				if($leftImage != ""){
					$updateData['file_twentyone'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twentytwo;
				if($leftImage != ""){
					$updateData['file_twentytwo'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twentythree;
				if($leftImage != ""){
					$updateData['file_twentythree'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twentyfour;
				if($leftImage != ""){
					$updateData['file_twentyfour'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twentyfive;
				if($leftImage != ""){
					$updateData['file_twentyfive'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twentysix;
				if($leftImage != ""){
					$updateData['file_twentysix'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twentyseven;
				if($leftImage != ""){
					$updateData['file_twentyseven'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twentyeight;
				if($leftImage != ""){
					$updateData['file_twentyeight'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_twentynine;
				if($leftImage != ""){
					$updateData['file_twentynine'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_thirty;
				if($leftImage != ""){
					$updateData['file_thirty'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_thirtyone;
				if($leftImage != ""){
					$updateData['file_thirtyone'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}
				$leftImage = $data->file_thirtytwo;
				if($leftImage != ""){
					$updateData['file_thirtytwo'] = str_replace("/var/www/synpat/synpat","https://synpat.com",$leftImage);
				}				
			}
		}
		if(count($updateData) > 0){
			//$this->lead_model->updateData($leadID,$updateData);
		}
		die;
	}
	
	function listOfIntroImages($leadID){
		$this->load->model('lead_model');
		$getLeadInfo = $this->lead_model->getLeadDataWithOptions($leadID,'l.serial_number');
		$updateData = array();
		if(count($getLeadInfo) >0){
			$data = $this->lead_model->getDocketIntroImagesWithFields($getLeadInfo->serial_number);
			echo "<pre>";
			print_r($data);
			if(count($data) > 0){
				$leftImage = $data->file_left;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_left'] = $newImage;
					}
				}
				$leftImage = $data->file_middle;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_middle'] = $newImage;
					}
				}
				$leftImage = $data->file_right;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_right'] = $newImage;
					}
				}
				$leftImage = $data->file_four;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_four'] = $newImage;
					}
				}
				$leftImage = $data->file_five;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_five'] = $newImage;
					}
				}
				$leftImage = $data->file_six;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_six'] = $newImage;
					}
				}
				$leftImage = $data->file_seven;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_seven'] = $newImage;
					}
				}
				$leftImage = $data->file_eight;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_eight'] = $newImage;
					}
				}
				$leftImage = $data->file_nine;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_nine'] = $newImage;
					}
				}
				$leftImage = $data->file_ten;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_ten'] = $newImage;
					}
				}
				$leftImage = $data->file_eleven;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_eleven'] = $newImage;
					}
				}
				$leftImage = $data->file_twelve;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twelve'] = $newImage;
					}
				}
				$leftImage = $data->file_thirteen;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_thirteen'] = $newImage;
					}
				}
				$leftImage = $data->file_fourteen;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_fourteen'] = $newImage;
					}
				}
				$leftImage = $data->file_fiveteen;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_fiveteen'] = $newImage;
					}
				}
				$leftImage = $data->file_sixteen;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_sixteen'] = $newImage;
					}
				}
				$leftImage = $data->file_seventeen;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_seventeen'] = $newImage;
					}
				}
				$leftImage = $data->file_eighteen;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_eighteen'] = $newImage;
					}
				}
				$leftImage = $data->file_nineteen;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_nineteen'] = $newImage;
					}
				}
				$leftImage = $data->file_twenty;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twenty'] = $newImage;
					}
				}
				$leftImage = $data->file_twentyone;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twentyone'] = $newImage;
					}
				}
				$leftImage = $data->file_twentytwo;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twentytwo'] = $newImage;
					}
				}
				$leftImage = $data->file_twentythree;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twentythree'] = $newImage;
					}
				}
				$leftImage = $data->file_twentyfour;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twentyfour'] = $newImage;
					}
				}
				$leftImage = $data->file_twentyfive;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twentyfive'] = $newImage;
					}
				}
				$leftImage = $data->file_twentysix;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twentysix'] = $newImage;
					}
				}
				$leftImage = $data->file_twentyseven;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twentyseven'] = $newImage;
					}
				}
				$leftImage = $data->file_twentyeight;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twentyeight'] = $newImage;
					}
				}
				$leftImage = $data->file_twentynine;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_twentynine'] = $newImage;
					}
				}
				$leftImage = $data->file_thirty;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_thirty'] = $newImage;
					}
				}
				$leftImage = $data->file_thirtyone;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_thirtyone'] = $newImage;
					}
				}
				$leftImage = $data->file_thirtytwo;
				if($leftImage != ""){
					$newImage = $this->convertToWebP($leftImage);
					if($newImage !=""){
						$updateData['file_thirtytwo'] = $newImage;
					}
				}				
			}
		}
		if(count($updateData) > 0){
			$this->lead_model->updateData($leadID,$updateData);
		}
		die;
	}
	
	function convertToWebP($leftImage){
		$absolutePath = str_replace("https://synpat.com","/var/www/synpat/synpat",$leftImage);
		$ext = pathinfo($absolutePath,PATHINFO_EXTENSION);
		$newImage = "";
		//echo $absolutePath."<br/>";
		if(in_array($ext,array('jpg','jpeg','png','PNG','JPG','JPEG'))){
			if(file_exists($absolutePath)){
				$newImage = str_replace($ext,"webp",$absolutePath);
				echo $absolutePath.'!!!!'.$newImage."<br/>";
				exec("cwebp -q 90 ".$absolutePath." -o ".$newImage);
				if(!file_exists($newImage)){
					$newImage = "";
				} else {
					$newImage = str_replace("/var/www/synpat/synpat","https://synpat.com",$newImage);
				}
			}
		}		
		return $newImage;
	}
	
	function save_linkedin_images(){
		$data = 0;
		if(isset($_POST) && count($_POST) > 0){
			$leadID = $this->input->post('lead');
			$images = $this->input->post('images');
			if(count($images) > 0){
				$this->load->model('lead_model');
				$data = $this->lead_model->updateData($leadID,array('show_linkedin_images'=>implode(',',$images)));
			}
		}
		echo $data;
		die;
	}
	function upload_portfolio_screenshot($leadID){
		$data = array("main_image"=>'',"file_link"=>'');
		if(isset($_FILES) && count($_FILES) > 0){
			$this->load->model('lead_model');
			$getLeadInfo = $this->lead_model->getLeadDataWithOptions($leadID,'l.serial_number,l.lead_name');
			if(count($getLeadInfo) >0){
				$getAcquisitionData = $this->lead_model->getAcquisitionData($leadID,'a.store,a.store_title');
				$description = "";
				$title = "";
				if(count($getAcquisitionData) > 0){
					$description = $getAcquisitionData->store;
					$title = $getAcquisitionData->store_title;
				}
				$queryString = md5($getLeadInfo->serial_number);
				$fileName = $queryString.'_'.$_FILES['portfolio_screenshot_image']['name'];
				$fileType = $_FILES['portfolio_screenshot_image']['type'];
				$fileError = $_FILES['portfolio_screenshot_image']['error'];
				//$fileContent = file_get_contents($_FILES['portfolio_screenshot_image']['tmp_name']);
				if($fileError == UPLOAD_ERR_OK){
					$target_dir = "/var/www/synpat/synpat/docket-services/assets/images/".$getLeadInfo->serial_number."/";
					$target_file = $target_dir .$fileName ;
					try{
						if (move_uploaded_file($_FILES["portfolio_screenshot_image"]["tmp_name"], $target_file)) {
							$fetchImageURL = "http://webdriverforscrape.site/portfolio_screenshot.php";
							$postData = array('serial_number'=>$getLeadInfo->serial_number,'url'=>"https://synpat.com/catalog?tap=show&c=".$queryString);
							$mainPortfolioImage = "";
							$v = time();
							$ch = curl_init();		
							curl_setopt($ch, CURLOPT_URL, $fetchImageURL);
							curl_setopt($ch, CURLOPT_HEADER, 0);
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
							curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
							$response = curl_exec($ch); 
							curl_close($ch);
							if($response !=""){
								try{
									$imageData = json_decode($response,true);
									if(isset($imageData['drive_url']) && $imageData['drive_url'] != ""){
										$fileReplace = str_replace("https://synpat.com","/var/www/synpat/synpat",$imageData['drive_url']);
										if($fileReplace != "" && file_exists($fileReplace)){
											$mainPortfolioImage = $imageData['drive_url'].'?v='.$v;
										}
									}
								}catch(Exception $e){
									
								}
							}
							$fileURL = "https://synpat.com/docket-services/assets/images/".$getLeadInfo->serial_number."/".$fileName;
							if($fileName != ""){
								$this->load->model('acquisition_model');
								$this->acquisition_model->updateData($leadID,array('main_portfolio_image'=>$fileURL));
							}
							$fileURL .="?latest";
							$fileData = array('image'=>$fileURL,'title'=>$title,'description'=>$description,'main_image'=>$mainPortfolioImage,'file_url'=>'https://synpat.com/portfolio/'.$queryString.'.html?latest');
							$this->layout->title_for_layout = 'Portfolio';
							$this->layout->layout='blank';
							$getData = $this->layout->getRenderHTML('user/portfolio_sharing_file',$fileData);
							$portfolioFile = "/var/www/synpat/synpat/portfolio/".$queryString.".html";
							if(file_exists($portfolioFile)){
								unlink($portfolioFile);								
							}
							$f = fopen($portfolioFile,"w+");
							fwrite($f,$getData);
							fclose($f);
							$fileURL = str_replace("?latest","",$fileURL);
							$data = array("main_image"=>$fileURL,"file_link"=>'https://synpat.com/portfolio/'.$queryString.'.html?latest');
						} 
					}catch(Exception $e){
						/*echo "Error while uploading file";*/
					}
				}
			}
		}
		echo json_encode($data);
		die;
	}
	function update_lead_category(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){	
			$categories = $this->input->post('c');
			$lead_id = $this->input->post('lead');
			$this->load->model('lead_model');
			if(!isset($_POST['c'])){
				$this->lead_model->deleteCategoryListByLeadID($lead_id);
			} else {
				if($lead_id > 0 && count($categories ) > 0){					
					$categoryArray = array();
					$mainCategory = 0;
					$checkInOldList = $this->lead_model->findMainCategory($lead_id,$categories);
					if(count($checkInOldList) > 0){
						$mainCategory = $checkInOldList[0];
					}
					foreach($categories as $cat){
						$mainSelect = 0;
						if($mainCategory == $cat){
							$mainSelect = 1;
						}
						array_push($categoryArray,array('category_id'=>$cat,'lead_id'=>$lead_id,'main_category'=>$mainSelect));
					}
					if(count($categoryArray) > 0){
						$this->lead_model->deleteCategoryListByLeadID($lead_id);
						$data = $this->lead_model->insertCategoryBatch($categoryArray);
					}
				}
			}			
		}
		echo $data;
	}
	function market(){
		$lead_id = 0;
		$data = array('update'=>0,'data'=>array(),'message'=>"");
		if(isset($_POST) && count($_POST)>0){			
			$marketData = $this->input->post();	
			/*Create Portfolio Number*/
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$this->load->model('acquisition_model');
			/*End Creating*/			
			$marketData['market']['user_id']= $this->session->userdata['id'];
			$marketData['market']['update_date']= date('Y-m-d H:i:s');
			$marketData['market']['type']= 'Market';
			
			$gmailMessageID = $marketData['market']['gmail_message_id'];
			unset($marketData['market']['gmail_message_id']);
			if(!isset($marketData['market']['complete'])){
				$marketData['market']['complete'] = 0;
			}
			if(isset($marketData['market']['worksheet_id'])&& $marketData['market']['worksheet_id']=='-- Select Worksheet --'){
				$marketData['market']['worksheet_id'] = '';
			} 
			if((int)$marketData['market']['id']>0) {
				$id = $marketData['market']['id'];
				$lead_id = $id;
				/*unset($marketData['market']['id']);*/
				unset($marketData['market']['gmail_message_id']); 
				/*Check Lead Name*/
				$findLeadByName = $this->lead_model->findLeadByName($marketData['market']['lead_name'],'l.id,l.serial_number');
				if(count($findLeadByName)>0){
					if($findLeadByName->id == $marketData['market']['id']){
						if((int)$findLeadByName->serial_number==0){
							$marketData['market']['serial_number'] = $this->getNewSerialNumber(0,$this->generateRandomString());
						}
						if($marketData['market']['option_expiration_date'] != ""){
							$explodeExpirationDate = explode('/',$marketData['market']['option_expiration_date']);
							if(count($explodeExpirationDate) == 3){
								$marketData['market']['option_expiration_date'] = date('Y-m-d H:i:s',strtotime($marketData['market']['option_expiration_date']));
							}
						
						}
						
						if($marketData['market']['port_price'] == '') {
							$marketData['market']['port_price'] = 0.0;
						}
						
						if($marketData['market']['agreed_price'] == '') {
							$marketData['market']['agreed_price'] = 0.0;
						}
						
						if($marketData['market']['expected_price'] == '') {
							$marketData['market']['expected_price'] = 0.0;
						}
						
						if($marketData['market']['upfront_price'] == '') {
							$marketData['market']['upfront_price'] = 0.0;
						}
						
						if($marketData['market']['plantiffs_name']  > 0 && $marketData['market']['seller_contact_id'] == '') {
							$marketData['market']['seller_contact_id'] = $marketData['market']['plantiffs_name'];
						}
						
						if($marketData['market']['no_of_us_patents'] == '') {
							$marketData['market']['no_of_us_patents'] = 0;
						}
						
						if($marketData['market']['no_of_non_us_patents'] == '') {
							$marketData['market']['no_of_non_us_patents'] = 0;
						}
						
						if($marketData['market']['no_of_prospects'] == '') {
							$marketData['market']['no_of_prospects'] = 0;
						}
						
						if($marketData['market']['seller_info'] == '') {
							unset($marketData['market']['seller_info']);
						}
						
						if($marketData['market']['complete'] == '') {
							unset($marketData['market']['complete']);
						}
						
						if($marketData['market']['send_proposal_letter'] == '') {
							unset($marketData['market']['send_proposal_letter']);
						}
						
						if($marketData['market']['create_patent_list'] == '') {
							unset($marketData['market']['create_patent_list']);
						}
						
						if($marketData['market']['market_data'] == '') {
							unset($marketData['market']['market_data']);
						}
						
						if($marketData['market']['file_url'] == '') {
							unset($marketData['market']['file_url']);
						}
						
						if($marketData['market']['spreadsheet_id'] == '') {
							unset($marketData['market']['spreadsheet_id']);
						}
						
						if($marketData['market']['worksheet_id'] == '') {
							unset($marketData['market']['worksheet_id']);
						}
						
						$data['update'] = $this->lead_model->from_litigation_update($marketData['market']['id'],$marketData['market']);
						$user_history = array('lead_id'=>$id,'user_id'=>$this->session->userdata['id'],'message'=>'Update a lead from Market.','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						$data['message'] = 'Record updated.';
					} else {
						$data['message'] = 'Lead name already exist.';
					}
				}  else {
					$data['update'] =  $this->lead_model->from_litigation_update($marketData['market']['id'],$marketData['market']);
					$findLeadByName = $this->lead_model->getLeadDataWithOptions($marketData['market']['id'],'l.folder_id');
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$service->renameFile($findLeadByName->folder_id,$marketData['market']['lead_name'].'_folder');
					$user_history = array('lead_id'=>$lead_id,'user_id'=>$this->session->userdata['id'],'message'=>'Update a lead from Market.','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
					$data['message'] = 'Record updated.';
				}
			}
			if(isset($lead_id) && $lead_id>0){
				$data['data'] = $this->lead_model->findLeadTableData($lead_id);
				if(isset($marketData['market']['expected_price']) && !empty($marketData['market']['expected_price'])){
					$getAcqusitionData = $this->acquisition_model->getData($lead_id);
					if(count($getAcqusitionData)>0){
						$user = $marketData['user'];	
						if($user['user']>0){
							$this->updatePortfolio($user['user'],$lead_id);
						}
						$docket = $marketData['docket'];
						/*if($docket['regular_license_starts']=="" || $docket['regular_license_starts']=="Invalid date"){
							$docket['regular_license_starts'] = "0000-00-00 00:00:00";
						} else {
							list($month,$date,$year) = explode('/',$docket['regular_license_starts']);
							$docket['regular_license_starts'] = $year.'-'.$month.'-'.$date." 00:00:00";
							$newDate = date('m/d/Y',strtotime('+4 months',strtotime($docket['regular_license_starts'])));
							$docket['late_license_starts'] = $newDate;
							if($docket['late_license_starts']=="" || $docket['late_license_starts']=="Invalid date"){
								$docket['active_button'] = 2;
							}
						}
						if($docket['late_license_starts']=="" || $docket['late_license_starts']=="Invalid date"){
							$docket['late_license_starts'] = "0000-00-00 00:00:00";
						} else {
							list($month,$date,$year) = explode('/',$docket['late_license_starts']);
							$docket['late_license_starts'] = $year.'-'.$month.'-'.$date." 00:00:00";
						}
						if($marketData['market']['option_expiration_date']=="" || $marketData['market']['option_expiration_date']=="Invalid date"){
							$docket['option_expiration_date'] = "0000-00-00 00:00:00";
						} else {
							$docket['option_expiration_date'] = $marketData['market']['option_expiration_date'];
						}		
						$docket['asking_price'] = $marketData['market']['expected_price'];
						
						if($docket['regular_license_starts']!="" && $docket['regular_license_starts']!="Invalid date"){
							$todayDate = date('Y-m-d');
							$regularLicenseDate = date('Y-m-d',strtotime($docket['regular_license_starts']));
							if($todayDate==$regularLicenseDate){
								$docket['active_button'] = 2;
							}else if($docket['late_license_starts']!="" && $docket['late_license_starts']!="Invalid date"){
								$lastLicensesDate = date('Y-m-d',strtotime($docket['late_license_starts']));
								if($todayDate==$lastLicensesDate){
									$docket['active_button'] = 3;
								}
							}
						}*/
						if($docket['closing_date'] != ""){
							$explodeClosingDate = explode('/',$docket['closing_date']);
							if(count($explodeClosingDate) == 3){
								$docket['closing_date'] = date('Y-m-d H:i:s',strtotime($docket['closing_date']." 00:00:00"));
							}
						}
						if(strpos($docket['closing_date'],1969) !== false || strpos($docket['closing_date'],1970) !== false){
							$docket['closing_date'] = "";
						}
						if($marketData['market']['option_expiration_date']=="" || $marketData['market']['option_expiration_date']=="Invalid date"){
							$docket['option_expiration_date'] = "0000-00-00 00:00:00";
							$docket['regular_license_starts'] = "0000-00-00 00:00:00";
							$docket['late_license_starts'] = "0000-00-00 00:00:00";
						} else {
							$docket['option_expiration_date'] = $marketData['market']['option_expiration_date']." 00:00:00";
							if($docket['closing_date'] != "" && $docket['closing_date'] != "Invalid date"){
								$todayDate = date('Y-m-d');
								$todayDate = strtotime($todayDate." 00:00:00");
								$docket['regular_license_starts'] = date('Y-m-d',strtotime('+1 days',strtotime($docket['closing_date'])));
								$docket['late_license_starts'] = date('Y-m-d',strtotime('+4 months',strtotime($docket['regular_license_starts'])));
								$regularLicenseDate = strtotime($docket['regular_license_starts']);
								$lastLicensesDate = strtotime($docket['late_license_starts']);
								if($todayDate>=$regularLicenseDate && $todayDate < $lastLicensesDate){
									$docket['active_button'] = 2;
								}else if($todayDate>=$lastLicensesDate){
									$docket['active_button'] = 3;
								}else{
									$docket['active_button'] = 1;
								}
							} else {
								$docket['regular_license_starts'] = "0000-00-00 00:00:00";
								$docket['late_license_starts'] = "0000-00-00 00:00:00";
								$docket['active_button'] = 1;
							}							
						}		
						$docket['asking_price'] = $marketData['market']['expected_price'];
						if(isset($docket['status']) && $docket['status']==1){
							$updateData = $this->acquisition_model->updateData($lead_id,array('seller_asking_price'=>$marketData['market']['expected_price'],'option_expiration_data'=>$marketData['market']['option_expiration_date'],'regular_license_starts'=>$docket['regular_license_starts'],'late_license_starts'=>$docket['late_license_starts'],'active_button'=>$docket['active_button'],'closing_date'=>$docket['closing_date']));
						} else {
							/*if($docket['category']==0){
								$docket['category'] = $getAcqusitionData['acquisition']->category;
							}*/
							$updateData = $this->acquisition_model->updateData($lead_id,array('seller_asking_price'=>$marketData['market']['expected_price'],'option_expiration_data'=>$marketData['market']['option_expiration_date'],'regular_license_starts'=>$docket['regular_license_starts'],'late_license_starts'=>$docket['late_license_starts'],'active_button'=>$docket['active_button'],'closing_date'=>$docket['closing_date']));
						}												
						$lead_data = $this->lead_model->getLeadDataWithOptions($lead_id,'l.serial_number');
						$this->load->model('opportunity_model');
						$docketData = $this->opportunity_model->updateLicenseAccessCode(array('asking_price'=>$marketData['market']['expected_price'],'expiration_date'=>$marketData['market']['option_expiration_date'],'active_button'=>$docket['active_button']),0,$lead_data->serial_number);
						if(isset($marketData['checkList']) && count($marketData['checkList']) > 0){
							$this->load->model('general_model');							
							$getTemplate = $this->general_model->findInvitationTemplateByLead($lead_id);
							if(count($getTemplate)>0){
								$this->load->model('customer_model');
								$template = $getTemplate->template_html;					
								$urlName ="";
								$category_list = $this->customer_model->categoryList(0);								
								if(!empty($getAcqusitionData['acquisition']->store_name)):				
									$urlName = "https://synpat.com/catalog?".md5($lead_data->serial_number);
								endif;
								if(!empty($urlName)){
									$data['detail'][0]['portfolio'] = $this->encode($urlName);
									$template =  str_replace('link-data-href=""',"href='".$urlName."'",$template);
									$getTemplate->template_html = $template;
									$getTemplate = (array)$getTemplate;
									$this->general_model->updateTemplate($getTemplate,$getTemplate['id']);
								}
							}
						}					
						/*
						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/license_other_update_data',
							CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
							CURLOPT_POST => 1,
							CURLOPT_POSTFIELDS => array(
								'license_number' => $getAcqusitionData['acquisition']->store_name,
								'asking_price'=>$marketData['market']['expected_price'],
								'option_expiration_date'=>$marketData['market']['option_expiration_date']
							)				
						));
						$resp = curl_exec($curl);
						*/
					}
				}
				$portfolioName = "Licensing";
				if(!empty($marketData['market']['seller_contact']) && !empty($marketData['market']['relates_to'])){
					$portfolioName = "Licensing of ".$marketData['market']['relates_to']." acquired from ".$marketData['market']['seller_contact'];
				} else if(!empty($marketData['market']['seller_contact'])){
					$portfolioName = "Licensing of acquired from ".$marketData['market']['seller_contact'];
				} else if(!empty($marketData['market']['relates_to'])){
					$portfolioName = "Licensing of ".$marketData['market']['relates_to']." acquired from ";
				}
				$this->updatePortfolioname($lead_id,$portfolioName);
			}
		} else {
			$data['message'] = 'No data submit.';
		}
		echo json_encode($data);
		die;		
	}
		
	function clear_lead_patent_data(){
		$data = array('d'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['d'] = $this->lead_model->from_litigation_update($this->input->post('lead_id'),array('patent_data'=>''));
			$this->lead_model->deleteLeadPatentParentData($this->input->post('lead_id'));
		}
		echo json_encode($data);
		die;
	}
	
	function updatePortfolio($userID,$leadID){
		$this->load->model('lead_model');
		$userDetail = $this->lead_model->findUserDetails($userID,"email as person_email,name as person_name,phone_number as person_phone,profile_pic as person_picture");
		if(count($userDetail)>0){
			$getSerialNumber = $this->lead_model->getLeadDataWithOptions($leadID,'l.serial_number');
			$this->lead_model->updateLicenseBySerialNumber($userDetail,$getSerialNumber->serial_number);
		}
	}
	
	function lead_form(){
		$data = array('update'=>0,'data'=>array(),'message'=>"");
		if(isset($_POST) && count($_POST)>0){
			$formData = $this->input->post();			
			/*Create Portfolio Number*/
			$this->load->model('lead_model');
			$this->load->model('user_model');
			/*End Creating*/
			$id = $formData['acquisition']['id'];
			$formData['acquisition']['update_date']= date('Y-m-d H:i:s');
			$lead_id = $id;
			unset($formData['acquisition']['id']);
			unset($formData['acquisition']['gmail_message_id']); 
			if(!isset($formData['acquisition']['complete'])){
				$formData['acquisition']['complete'] = 0;
			}
			if(isset($formData['acquisition']['worksheet_id'])&& $formData['acquisition']['worksheet_id']=='-- Select Worksheet --'){
				$formData['acquisition']['worksheet_id'] = '';
			}
			if((int)$id>0){
				/*Check Lead Name*/
				$findLeadByName = $this->lead_model->findLeadByName($formData['acquisition']['lead_name'],'l.id,l.serial_number');
				if(count($findLeadByName)>0){
					if($findLeadByName->id == $id){
						if((int)$findLeadByName->serial_number==0){
							$formData['acquisition']['serial_number'] = $this->getNewSerialNumber(0,$this->generateRandomString());
						}
						$data['update'] = $this->lead_model->from_litigation_update($id,$formData['acquisition']);
						$user_history = array('lead_id'=>$id,'user_id'=>$this->session->userdata['id'],'message'=>'Update a lead from '.$formData['acquisition']['type'].'.','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						$data['message'] = 'Record updated.';
					} else {
						$data['message'] = 'Lead name already exist.';
					}
				}  else {
					$data['update'] = $this->lead_model->from_litigation_update($id,$formData['acquisition']);
					$user_history = array('lead_id'=>$id,'user_id'=>$this->session->userdata['id'],'message'=>'Update a lead from '.$formData['acquisition']['type'].'.','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$findLeadByName = $this->lead_model->getLeadDataWithOptions($id,'l.folder_id');
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$service->renameFile($findLeadByName->folder_id,$formData['acquisition']['lead_name'].'_folder');							
					$this->user_model->addUserHistory($user_history);
					$data['message'] = 'Record updated.';
				}
			}
			if(isset($id) && $id>0){
				$data['data'] = $this->lead_model->findLeadTableData($id);
				$portfolioName = "Licensing";
				if(!empty($formData['acquisition']['seller_contact']) && !empty($formData['acquisition']['relates_to'])){
					$portfolioName = "Licensing of ".$formData['acquisition']['relates_to']." acquired from ".$formData['acquisition']['seller_contact'];
				} else if(!empty($formData['acquisition']['seller_contact'])){
					$portfolioName = "Licensing of acquired from ".$formData['acquisition']['seller_contact'];
				} else if(!empty($formData['acquisition']['relates_to'])){
					$portfolioName = "Licensing of ".$formData['acquisition']['relates_to']." acquired from ";
				}
				$this->updatePortfolioname($id,$portfolioName);
				$docket = $formData['docket'];							
				$lead_id = $id;
				
				if(isset($formData['acquisition']['expected_price']) && !empty($formData['acquisition']['expected_price'])){
					$getAcqusitionData = $this->acquisition_model->getData($lead_id);
					if(count($getAcqusitionData)>0){
						$user = $formData['user'];	
						if($user['user']>0){
							$this->updatePortfolio($user['user'],$lead_id);
						}
						if($docket['regular_license_starts']=="" || $docket['regular_license_starts']=="Invalid date"){
							$docket['regular_license_starts'] = "0000-00-00 00:00:00";
						} else {
							list($month,$date,$year) = explode('/',$docket['regular_license_starts']);
							$docket['regular_license_starts'] = $year.'-'.$month.'-'.$date." 00:00:00";
							if($docket['late_license_starts']=="" || $docket['late_license_starts']=="Invalid date"){
								$newDate = date('m/d/Y',strtotime('+4 months',strtotime($docket['regular_license_starts'])));
								$docket['late_license_starts'] = $newDate;
								$docket['active_button'] = 2;
							}
						}
						if($docket['late_license_starts']=="" || $docket['late_license_starts']=="Invalid date"){
							$docket['late_license_starts'] = "0000-00-00 00:00:00";
						} else {
							list($month,$date,$year) = explode('/',$docket['late_license_starts']);
							$docket['late_license_starts'] = $year.'-'.$month.'-'.$date." 00:00:00";
						}
						if($formData['acquisition']['option_expiration_date']=="" || $formData['acquisition']['option_expiration_date']=="Invalid date"){
							$docket['option_expiration_date'] = "0000-00-00 00:00:00";
						} else {
							$docket['option_expiration_date'] = $formData['acquisition']['option_expiration_date'];
						}		
						$docket['asking_price'] = $formData['acquisition']['expected_price'];
						if(isset($docket['status']) && $docket['status']==1){
							$updateData = $this->acquisition_model->updateData($lead_id,array('seller_asking_price'=>$formData['acquisition']['expected_price'],'option_expiration_data'=>$formData['acquisition']['option_expiration_date'],'regular_license_starts'=>$docket['regular_license_starts'],'late_license_starts'=>$docket['late_license_starts'],'active_button'=>$docket['active_button']));
						} else {
							if($docket['category']==0){
								$docket['category'] = $getAcqusitionData['acquisition']->category;
							}
							$updateData = $this->acquisition_model->updateData($lead_id,array('seller_asking_price'=>$formData['acquisition']['expected_price'],'option_expiration_data'=>$formData['acquisition']['option_expiration_date'],'regular_license_starts'=>$docket['regular_license_starts'],'late_license_starts'=>$docket['late_license_starts'],'active_button'=>$docket['active_button'],'category'=>$docket['category']));
						}
												
						$lead_data = $this->lead_model->getLeadDataWithOptions($lead_id,'l.serial_number');
						$this->load->model('opportunity_model');
						$docketData = $this->opportunity_model->updateLicenseAccessCode(array('asking_price'=>$formData['acquisition']['expected_price'],'expiration_date'=>$formData['acquisition']['option_expiration_date'],'active_button'=>$docket['active_button']),0,$lead_data->serial_number);
						if((int)$docket['category']>0){
							$this->load->model('general_model');							
							$getTemplate = $this->general_model->findInvitationTemplateByLead($lead_id);
							if(count($getTemplate)>0){
								$this->load->model('customer_model');
								$template = $getTemplate->template_html;					
								$urlName ="";
								$category_list = $this->customer_model->categoryList(0);								
								if(!empty($getAcqusitionData['acquisition']->store_name)):				
								if($docket['category']>0){
									$categoryACQ = $this->lead_model->getAcquisitionData($lead_id,'a.category');
									if(count($category_list)>0){										 
										for($cc=0;$cc<count($category_list);$cc++){
											if($category_list[$cc]->id==$categoryACQ->category){
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
										$urlName ='/departments/'.$urlName.'-'.$categoryACQ->category.'/'.$lead_data->serial_number.'/';
									}
								}
								endif;
								if(!empty($urlName)){
									$urlName = "https://synpat.com".$urlName;
								}
								$template =  str_replace('link-data-href=""',"href='".$urlName."'",$template);
								$getTemplate->template_html = $template;
								$getTemplate = (array)$getTemplate;
								$this->general_model->updateTemplate($getTemplate,$getTemplate['id']);
							}
						}	
					}
				}
			}
		} else {
			$data['message'] = 'No data submit.';
		}
		echo json_encode($data);
		die;		
	}
	
	function create_new_folder(){
		$data =0;
		if(isset($_POST) && count($_POST)>0){
			if(isset($_POST['l']) && (int) $_POST['l']>0){
				$this->load->model('lead_model');
				$findLeadByName = $this->lead_model->getLeadData($this->input->post('l'));
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$fileParent = new Google_Service_Drive_ParentReference();
				$fileParent->setId( $findLeadByName->folder_id );
				$getImageFolderInfo = $service->createSubFolder($this->input->post('folder_name'),$fileParent);
				if($getImageFolderInfo){
					$service->setAdditionalPermissions($getImageFolderInfo, "","writer","anyone");
					$data = 1;
				}
			}
		}
		echo $data;
		die;
	}
	
	function findAllLeadWithSellerFolder(){
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();
		$this->load->model('lead_model');
		$getAllLead = $this->lead_model->getAllLeadWithoutSellerID();
		for($i=0;$i<count($getAllLead);$i++){
			$fileParent = new Google_Service_Drive_ParentReference();
			$fileParent->setId( $getAllLead[$i]->folder_id );
			$getImageFolderInfo = $service->createSubFolder(SELLER_MATERIAL,$fileParent);
			if($getImageFolderInfo){
				$service->setAdditionalPermissions($getImageFolderInfo, "","writer","anyone");
				$this->lead_model->from_litigation_update($getAllLead[$i]->id,array("seller_material_folder_id"=>$getImageFolderInfo));
				echo "DONE:".$getImageFolderInfo."<br/>";
			}
		}
		die;
	}
	
	public function lititgation_scrap_data(){
		$data =0;
		if(isset($_POST) && count($_POST)>0){
			if(isset($_POST['lead']) && (int) $_POST['lead']>0){
				$this->load->model('lead_model');
				$this->load->model('user_model');
				$saveMarket = $this->lead_model->from_litigation_update($_POST['lead'],array('scrapper_data'=>$_POST['scrap']));
				$user_history = array('lead_id'=>$_POST['lead'],'user_id'=>$this->session->userdata['id'],'message'=>'Update Litigation data scrap','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
				$this->user_model->addUserHistory($user_history);
			}
		}
		echo $data;
		die;
	}
	
	public function taskList(){
		$this->load->library('DriveServiceHelper');
		$service = new TaskServiceHelper();
		$getList = $service->taskList();
		foreach ($getList['items'] as $list) {
			print "<h3>ID: ".$list['title']." TITLE: ".$list['title']."</h3>";
			$tasks = $service->findTask($list['id']);
			foreach ($tasks['items'] as $task) {
				print "<p id='post'>".$task['title']."</p>";
			}
		}
		die;
	}

	public function addOrRemoveEmailLabel(){
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
			if($this->input->post("step")==0){
				$modifyData = $service->modifyMessage($this->input->post('token'),"me",strtoupper(strtolower($this->input->post('label'))));
				if(is_object($modifyData)){
					echo json_encode(array('text'=>"Starred",'thread'=>$this->input->post('token')));
				}
			} else {
				$service->modifyMessageRemove($this->input->post('token'),"me",strtoupper(strtolower($this->input->post('label'))));
				echo json_encode(array('text'=>"Not Starred",'thread'=>$this->input->post('token')));
			}
		} else {
			echo json_encode(array('text'=>"",'thread'=>''));
		}
		die;
	}
	
	public function deleteEmailPermanently(){
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
			$deleteMessage = $service->deleteMessagePermanent("me",$this->input->post('token'));
			if($deleteMessage){
				echo "1";
			} else {
				echo "0";
			}
		}
		die;
	}
	
	public function modifyLabel(){
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
			$service->modifyMessageRemove($this->input->post('token'),"me","INBOX");
			$service->modifyMessageRemove($this->input->post('token'),"me","STARRED");
			$modifyData = $service->modifyThread($this->input->post('token'),"me",strtoupper(strtolower($this->input->post('label'))));
			if(is_object($modifyData)){
				$type = strtoupper(strtolower($this->input->post("active")));
				if(isset($_SESSION[$type])){
					$emails = $_SESSION[$type];
					if(count($emails)>0){
						for($i=0;$i<count($emails);$i++){
							if((isset($emails[$i]['message_id']) && $emails[$i]['message_id']==$this->input->post('token')) || (isset($emails[$i]['id']) && $emails[$i]['id']==$this->input->post('token'))){
								unset($emails[$i]);
							}
						}
						$_SESSION[$type] = $emails;
					}
				}
				echo "Starred";
			} else {
				echo "Not Starred";
			}		
		}
		die;
	}
	
	function moveThreadDiff(){
		$data = 0;
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
			$service->modifyMessageRemove($this->input->post('thread'),"me","INBOX");
			$service->modifyMessageRemove($this->input->post('thread'),"me","STARRED");
			$labelID = $this->input->post('label');
			if(strtolower($labelID)=="nonlead"){
				$labelID ="";
				$service->setAccessToken($googleToken);
				$listOfLabels = $service->listLabels();			
				if(count($listOfLabels)>0){
					foreach($listOfLabels as $key=> $label){
						if(strtolower($label)=='nonlead'){
							$labelID = $key;
						}
					}
				}
				if(empty($labelID)){
					$label = $service->createLabel('Nonlead');
					if($label){
						$labelID = $label->getId();							
					}
				}
			}		
			if(!empty($labelID)){
				$modifyData = $service->modifyMessage($this->input->post('thread'),"me",$labelID);
				if(is_object($modifyData)){
					/*Remove from Session*/
					$type = strtoupper(strtolower($this->input->post("active")));
					if(isset($_SESSION[$type])){
						$emails = $_SESSION[$type];
						if(count($emails)>0){
							for($i=0;$i<count($emails);$i++){
								if(isset($emails[$i]['message_id']) && $emails[$i]['message_id']==$this->input->post('thread')){
									unset($emails[$i]);
								}
							}
							$_SESSION[$type] = $emails;
						}
					}					
					/*End Session Remove*/
					$data = 1;
				}
			}
		}
		echo $data;
		die;
	}
	
	public function saveComment(){
		if(isset($_POST) && count($_POST)>0){
			$commentData = $this->input->post();
            $comment['other']['comment1'] = $commentData['comment1'];
            $comment['other']['comment2'] = $commentData['comment2'];
            $comment['other']['comment3'] = $commentData['comment3'];          
            $comment['other']['parent_id'] = $commentData['lead_id']; 
            $comment['other']['type'] = $commentData['type'];           
            $comment['other']['attractive'] = $commentData['attractiveness'];          
			$comment['other']['user_id']= $this->session->userdata['id'];				
			$comment['other']['id']= $commentData['id'];
			$this->load->model('lead_model');			
			$this->load->model('user_model');			
			if($commentData['id']==0){
				$comment['other']['created']= date('Y-m-d H:i:s');	
                $comment['other']['updated']= date('Y-m-d H:i:s');	
				$checkComment = $this->lead_model->userLeadTeamNote($commentData['lead_id'],$this->session->userdata['id']);
				if(count($checkComment)>0){
					$comment['other']['updated']= date('Y-m-d H:i:s');
					$comment['other']['id']= $checkComment->id;
					$saveComment = $this->lead_model->from_litigation_update_comment($comment['other']);
					$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$commentData['lead_id'],'message'=>'Update comment','create_date'=>date('Y-m-d H:i:s')));
				} else {
					$saveComment = $this->lead_model->from_litigation_comment($comment['other']);
					$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$commentData['lead_id'],'message'=>'Add a comment','create_date'=>date('Y-m-d H:i:s')));
				}
				
			} else {
				$comment['other']['updated']= date('Y-m-d H:i:s');
				$saveComment = $this->lead_model->from_litigation_update_comment($comment['other']);
				$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$commentData['lead_id'],'message'=>'Update comment','create_date'=>date('Y-m-d H:i:s')));
			}
            
			if($saveComment>0){
				echo json_encode(array('message'=>'Records added','id'=>$saveComment,'error'=>''));
                
			} else {
				echo json_encode(array('error'=>'Try after sometime.'));
			}
		}
		die;
	}
	
	function resendImapEmail(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$id = $this->input->post('which_n');
			$findEmail = array();
			$this->load->model('lead_model');
			/*$this->load->model('user_model');*/
			if((int)$id>0){
				$findEmail  = $this->lead_model->findBoxNewById($id);
			}

			$to="";
			if(count($findEmail)>0 && isset($findEmail[0]->lead_id) && (int)$findEmail[0]->lead_id>0){
				$emailAddress = $this->lead_model->findEmailFromWhichActivity($id);
				$too = array();
				if(!empty($emailAddress)){
					$too[] = $emailAddress;
					$to = implode(',',$too);
				}
				
				$message = $findEmail[0]->content;
				$threadMessage = json_decode($message);
				if($threadMessage->body!=""){
					$body = $threadMessage->body;
					$headerTo = $threadMessage->header->to;
					if(count($too)==0){
						foreach($headerTo as $hTo){
							$too[] = $hTo->personal;
						}
						$to = implode(',',$too);
					}
					
					$ccc = "";
					if(isset($threadMessage->cc)){
						$ccc = implode(',',$threadMessage->cc);
					}
					$subject = $threadMessage->subject;
					$this->config->load('config');		
					$username="";
					$password="";
					$params= array();
					$FROM = "";
					$FROMName = "";
					switch((int)$this->input->post('t')){
						case 1:
							if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):
								$username=$this->config->item('license_email');
								$password=$this->config->item('license_password');
								$FROM = $this->config->item('license_email');
								$FROMName = "SynPat Licenses";
							endif;
						break;
						case 2:
							if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):
								$username=$this->config->item('operations_email');
								$password=$this->config->item('operations_password');
								$FROM = $this->config->item('operations_email');
								$FROMName = "SynPat Patents";
							endif;
						break;
					}
					require_once(APPPATH.'libraries/PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php');
					$mail = new PHPMailer;
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
					$mail->Subject = $subject;
					$strToMail = explode(',',$to);
					if(isset($strToMail[0]) && !empty($strToMail[0])){
						foreach($strToMail as $ema){
							$to= trim($ema);
							if(!empty($to)){
								$mail->AddAddress(trim($ema),trim($ema));
							}				
						}
					}
					if(isset($ccc)){
						$cc = explode(",",$ccc);
						if(isset($cc[0]) && !empty($cc[0])){
							foreach($cc as $ema){
								$emailCC= trim($ema);
								if(!empty($emailCC)){					
									$mail->addCC($emailCC,$emailCC);
								}
							}
						}					
					}
					$strMailContent = $body;
					/*$mail->SMTPDebug = 2;  */
					$mail->Body = $strMailContent;
					if($mail->send()) {	
						$date = date('Y-m-d H:i:s');
						$leadID = $this->input->post('lead');
						$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Email send",'opportunity_id'=>0,'create_date'=>$date);
						array_push($strToMail,'');
						/*$send = $this->findEmailImapSendBox((int)$this->input->post('t'),$subject,$strToMail,$date,$leadID,1,1);*/
						$send = $this->searchImapEmails((int)$this->input->post('t'),$subject,$strToMail,$date,$leadID,1,1);
					
						$email_id = 0 ;
						$dataSend = json_decode($send,true);
						if(isset($dataSend['send'])){
							$email_id = $dataSend['send'];
						} else if(isset($dataSend->send)){
							$email_id = $dataSend->send;
						}
						if($email_id>0){	
							$data= $email_id;
							$message = $strMailContent;
							$emailTo = $strToMail;
							if(count($emailTo)>0){						
								for($t=0;$t<count($emailTo);$t++){
									$toEmail =	trim($emailTo[$t]);
									if(!empty($toEmail)){
										/*$getContactDetail = $this->lead_model->getContactByEmail($toEmail);*/
										$getContactDetail = $this->lead_model->getContactByEmailOrSecondary($toEmail);
										if(count($getContactDetail)>0){
											if(array_key_exists('c_id',$event)){
												unset($event['c_id']);
											}
											if(array_key_exists('p_id',$event)){
												unset($event['p_id']);
											}
											$event['contact_id'] = $getContactDetail->id;
											$event['company_id'] = $getContactDetail->company_id;
											$event['type'] = 3;
											$event['note'] = $message;
											$event['user_id'] = $this->session->userdata['id'];
											$event['email_id'] = $email_id;
											$event['subject'] = $subject;
											$event['lead_id'] = $leadID;
											$event['activity_date'] = $date;
											$this->lead_model->insetSalesActivity($event);
											$this->activityLog($event);
										}
									}									
								}
							}
						}
					}
				}
			}
		}
		echo $data;
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
	
	function search_serial_number(){
		$searchNumber = $this->input->get('q');
		$this->load->model('lead_model');
		$data = $this->lead_model->findAllLeadBySerialNumberBySearch($searchNumber);
		echo json_encode($data);
		die;
	}
	
	function search_lead_name(){
		$searchNumber = $this->input->get('q');
		$this->load->model('lead_model');
		$data = $this->lead_model->findAllLeadByLeadNameBySearch($searchNumber);
		echo json_encode($data);
		die;
	}
		
	function reply_email($op=0){
		$fileType = 0;
		$popEmail=0;
		if(isset($_POST) && count($_POST)>0){			
			if(!isset($_SESSION)){
				session_start();
			}	
			$this->load->library('DriveServiceHelper');
			$email = $this->input->post('email');
			$another = $this->input->post('another');
			$fileName="";
			$fileSrc = "";
			$type=0;
			$arrayPID = array();
			$activityType=2;
			$event = array();
			$preSaleBrokerCompanyID = 0;
			if(isset($_POST['event'])){
				$event = $this->input->post('event');
			}	
			if(isset($event['c_id']) && (int)$event['c_id']>0){
				$preSaleBrokerCompanyID = $event['c_id'];
			}
			if(count($event)>0 && isset($event['p_id']) && !empty($event['p_id']) && $event['p_id']!="," && $event['p_id']!=", "){
				$type=1;
			}
			if(isset($event['t'])){
				if((int)$event['t']>0){
					$activityType=$event['t'];
				}				
				unset($event['t']);
			}
			if(isset($another['legal_log']) && (int)$another['legal_log']>0){
				$activityType=2;
			}
			/*if($op==1){
				$activityType=1;
			}*/
			$templateSave = 0;
			if(isset($email['save_template']) && $email['save_template']==1){
				$templateSave = $email['save_template'];
				unset($email['save_template']);
			}
			$leadID = $email['lead_id'];
			unset($email['lead_id']);
			$trackingCode = "";
			$this->load->model('lead_model');
			if($leadID > 0){
				$getLeadData = $this->lead_model->getLeadDataWithOptions($leadID,'serial_number');
				$serialNumber = 0;
				if(count($getLeadData) > 0){
					$serialNumber = $getLeadData->serial_number;
				}
				$trackingCode = $this->encode($serialNumber."_".$leadID."_".time());
				$message = $email['message'];
				$message .= "<br/><a><img src='https://synpat.com/display_synpat_logo.php?width=100&height=100&image_id=".$trackingCode."&display_for=".$email['to']."' /></a><br/><br/>";
				$email['message'] = $message;
			}
			$allAnchor = array();
			if(isset($email['doc_url']) && !empty($email['doc_url'])){
				$this->load->library('simple_html_dom');
				$html = $this->simple_html_dom->load($email['doc_url'],true,true);
				foreach($html->find('<ul class="attachment-list">') as $asTable) {
					foreach($asTable->find('<li class="attachment-list-item">') as $title){
						$titles = "";
						$img = "";
						$href = "";
						foreach($title->find("img") as $img){
							if(!empty($img->src)){
								$img = $img->src;
							}
						}
						foreach($title->find("a") as $anchor){
							if(!empty($anchor->innertext) && empty($titles)){
								$titles = $anchor->innertext;
							}
							if(!empty($anchor->plaintext) && empty($titles)){
								$titles = $anchor->plaintext;
							}
							if(!empty($anchor->{'data-href'})){
								$href = $anchor->{'data-href'};
							}
							if(empty($href)){
								if(!empty($anchor->{'href'})){
									$href = $anchor->{'href'};
								}
							}
						}
						$allAnchor[] = array('title'=>$titles,'img'=>$img,'href'=>$href);
					}									
				}
				if(count($allAnchor)>0){
					$email['href'] = $allAnchor;
				} else {
					$email['href'] = array();
				}
			} else {
				$email['href'] = array();
			} 
			
			$accountType = "1";
			if(isset($email['account_type'])){
				$accountType = $email['account_type'];
				unset($email['account_type']);
			}
			$email_id = 0 ;
			$eventUserType = 2;
			if(isset($event['event_user_type']) && $event['event_user_type']>0){
				$eventUserType = $event['event_user_type'];
				unset($event['event_user_type']);
			}
			/*check Activity Type*/
			$date = date('Y-m-d H:i:s');
			switch($accountType){
				case 1:
				default:
					/*Personal account*/
					if($this->session->userdata['user']['type']==9 || in_array(11,$this->session->userdata['modules_assign'])){
						/*SEND EMAIL FROM AUTHENTICATE GMAIL ACCOUNT*/
						$googleToken = "";
						if(isset($_SESSION['another_access_token'])){
							$googleToken = $_SESSION['another_access_token'];
						}
						if(empty($googleToken)){
							$googleToken = $this->getUserToken();
						}
						if(!empty($googleToken)){
							$service = new GmailServiceHelper();							
							$service->setAccessToken($googleToken);
							/*SEND EMAIL*/
							try{
								$send  = $service->sendMessage($email);
								if(is_object($send)){
									/*if(isset($another['sys']) && $another['sys']!='0'){
										$curl = curl_init();
										curl_setopt_array($curl, array(
											CURLOPT_RETURNTRANSFER => 1,
											CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/updatePricePotential',
											CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
											CURLOPT_POST => 1,
											CURLOPT_POSTFIELDS => array(
												'i' => $another['sys'],
												'thread_id'=>$send->threadId,
											)				
										));
										$resp = curl_exec($curl);					
									}*/
									if(isset($send->labelIds) && count($send->labelIds)>0 && in_array("SENT", $send->labelIds)){
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
										/*Link to Email Box*/	
										$send = $this->linkWithMessageOnGo($leadID,$send->id,$date,$type,1);
										/*End Link to Email Box*/
										$dataSend = json_decode($send,true);										
										if(isset($dataSend['send'])){
											$email_id = $dataSend['send'];
										} else if(isset($dataSend->send)){
											$email_id = $dataSend->send;
										}										
									}
								}								
							}catch(Exception $e){
								/*print_r($e);*/
								print 'An error occurred: ' . $e->getMessage();
							}							
						}
					}
				break;
				case 2:
					/*imap accounts*/
					$this->config->load('config');
					$FROM = '';
					switch((int)$eventUserType){
						case 1:
							/*Licenses*/
							if($this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])){
								$FROM = $this->config->item('license_email');
								$FROMName = "SynPat Licenses";
							}
						break;
						case 2:
							/*Patents*/
							if($this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])){
								$FROM = $this->config->item('operations_email');
								$FROMName = "SynPat - Patent Rights";
							}
						break;
						case 3:
							/*Experts*/
							if($this->session->userdata['user']['type']==9 || in_array(27,$this->session->userdata['modules_assign'])){
								$FROM = $this->config->item('experts_email');
								$FROMName = "SynPat Experts";
							}
						break;
					}
					if($FROM!=""){
						require_once(APPPATH.'libraries/PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php');
						$mail = new PHPMailer;
						if(isset($email['message_id'])){
							$mail->InReplyTo = $email['message_id'];
						}
						if(isset($email['reference'])){
							$mail->References = $email['reference'];
						}
						$username=$this->config->item('imap_email');
						$password=$this->config->item('imap_password');
						$mail->isSMTP();   
						$mail->Host = 'smtp.gmail.com';  
						$mail->SMTPAuth = true;     
						$mail->Username = $username;  
						$mail->Password = $password; 
						$mail->SMTPSecure = 'ssl';  
						$mail->Port = 465;         
						$mail->From = $FROM;
						$mail->FromName = $FROMName;
						$mail->isHTML(true);   
						// Set email format to HTML
						$mail->Subject = $email['subject'];
						$strToMail = explode(',',$email['to']);
						$cc = array();
						if(isset($strToMail[0]) && !empty($strToMail[0])){
							foreach($strToMail as $ema){
								$to= trim($ema);
								if(!empty($to)){					
									$mail->addAddress($to,$to);
								}				
							}
						}
						
						if(isset($email['cc'])){
							$cc = explode(",",$email['cc']);
							if(isset($cc[0]) && !empty($cc[0])){
								foreach($cc as $ema){
									$emailCC= trim($ema);
									if(!empty($emailCC)){					
										$mail->addCC($emailCC,$emailCC);
									}
								}
							}					
						}
						if(isset($email['bcc'])){
							$bcc = explode(",",$email['bcc']);
							if(isset($bcc[0]) && !empty($bcc[0])){
								foreach($bcc as $ema){
									$emailBcc= trim($ema);
									if(!empty($emailBcc)){					
										$mail->addBCC($emailBcc,$emailBcc);
									}
								}
							}					
						}
						$strMailContent = $email['message'];
						if(isset($email['href']) && count($email['href'])>0){
							$i=0;
							foreach($email['href'] as $drive){
								$strMailContent .=" <br/><div class='gmail_chipgmail_drive_chip'style='width:396px;height:18px;max-height:18px;background-color:#f5f5f5;padding:5px;color:#222;font-family:arial;font-style:normal;font-weight:bold;font-size:13px;border:1px solid #ddd;line-height:1'><a href='".$drive['href']."' target='_blank' style='display:inline-block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;text-decoration:none;padding:1px 0px;border:none;width:100%'><img style='vertical-align: bottom; border: none;' src='".$drive['img']."'/>&nbsp;<span dir='ltr' style='color:#15c;text-decoration:none;vertical-align:bottom'>".$drive['title']."</span></a></div>";
								if($i==count($email['href'])-1){
									$strMailContent .="<br/>";
								}
								$i++;
							}	
						}
						$mail->Body = $strMailContent;
						try{
							if($mail->send()) {								
								/*Link to Email Box*/								
								$send = $this->searchImapEmails($eventUserType,$email['subject'],$strToMail,$date,$leadID,1,1);
								$dataSend = json_decode($send,true);
								if(isset($dataSend['send'])){
									$email_id = $dataSend['send'];
								} else if(isset($dataSend->send)){
									$email_id = $dataSend->send;
								}
								unset($event['c_id']);
								unset($event['p_id']);
							}
						} catch(Exception $e){
							
						}						
					}
				break;
			}
			$popEmail= $email_id; 
			$fileType = 0;
			if($popEmail>0){
				/*Update tracking code*/
				$this->lead_model->updateBox($popEmail,array('tracking_code'=>$trackingCode));
				/*INSERT USER HISTORY*/
				$this->load->model('user_model');
				
				$this->load->model('opportunity_model');
				$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Email send",'opportunity_id'=>0,'create_date'=>$date);
				$this->user_model->addUserHistory($user_history);
				
				
				$message = $email['message'];	
				if(count($email['href'])>0){
					$message .= "<br/>";
					foreach($email['href'] as $url){
						$href = $url['href'];
						if(stristr($url['title'],"pdf")!==false){
							$href = str_replace("view?usp=drivesdk","preview",$href);
						}
						$message .= '<a  href="javascript://" data-file-id="" onclick=\'open_drive_files("'.trim($href).'");\' data-href="'.$url['href'].'" data-mime="" target="_blank" style="color:#2196f3"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$url['title'].'</a> &nbsp; &nbsp; &nbsp;';
					}
				}
				$emailTo = explode(',',$email['to']);						
				if(count($emailTo)>0){			
					$to = $emailTo[0];
					$emailTo = array($to);
					for($t=0;$t<count($emailTo);$t++){
						$toEmail =	trim($emailTo[$t]);
						if(!empty($toEmail)){
							/*$getContactDetail = $this->lead_model->getContactByEmail($toEmail);*/
							$getContactDetail = $this->lead_model->getContactByEmailOrSecondary($toEmail);
							if(count($getContactDetail)>0){
								if($activityType==1){
									$checkCompanyInSalesActivity = $this->opportunity_model->checkCompanyInSales($leadID,$getContactDetail->company_id);
									if(count($checkCompanyInSalesActivity)==0){
										$this->opportunity_model->insertInvitees(array('lead_id'=>$leadID,'contact_id'=>$getContactDetail->company_id));
									}									
								} else if($activityType==2){
									$checkCompanyInAcquisitionActivity = $this->opportunity_model->checkCompanyInAcquisition($leadID,$getContactDetail->company_id);
									if(count($checkCompanyInAcquisitionActivity)==0){
										$this->opportunity_model->insertAcquisitionCompany(array('lead_id'=>$leadID,'contact_id'=>$getContactDetail->company_id));
									}
								}
								/*update user with new email*/
								if((int)$getContactDetail->new_email == 1){
									$this->load->model('client_model');
									$this->client_model->update($getContactDetail->id,array('new_email'=>0));
								}								
								/*End*/
								if(array_key_exists('c_id',$event)){
									unset($event['c_id']);
								}
								if(array_key_exists('p_id',$event)){
									unset($event['p_id']);
								}
								$event['contact_id'] = $getContactDetail->id;
								$event['company_id'] = $getContactDetail->company_id;
								$event['type'] = 3;
								$event['note'] = $message;
								$event['user_id'] = $this->session->userdata['id'];
								$event['email_id'] = $email_id;
								$event['subject'] = $email['subject'];
								$event['lead_id'] = $leadID;
								$event['activity_date'] = $date;
								$this->activityLog($event);
								if($activityType==1){
									$this->lead_model->insetSalesActivity($event);
								} else if($activityType==3){
									/*Change Company ID*/
									$event['company_id'] = $preSaleBrokerCompanyID;
									$this->lead_model->insertPreSaleActivity($event);
								} else {
									 $this->lead_model->insertAcquistionActivity($event);
								}
							}	
						}
					}
				}
				/*if(isset($another['legal_log']) && (int) $another['legal_log']>0){*/
				if(isset($another['legal_log'])){					
					$projectType = $email['subject'];
					if(!empty($projectType)){						
						/*Check file name and enter in lead open project table
							1=>'Patent List',2=>'Technical DD',3=>'Legal DD',4=>'Illustration',5=>'Royalty report',6=>'List of Invitees'
						*/
						
						if(count($allAnchor)>0){
							foreach($allAnchor as $file){
								$attachFileHref = strtolower(strtoupper($file['href']));
								$attachFileName = strtolower(strtoupper($file['title']));
								if(strpos($attachFileName,'patent')!==false){
									$fileType = 1;break;
								} else if(strpos($attachFileHref,'techdd')!==false){
									$fileType = 2;break;
								} else if(strpos($attachFileHref,'legaldd')!==false){
									$fileType = 3;break;
								} else if(strpos($attachFileHref,'illustrationdd')!==false){
									$fileType = 4;break;
								} else if(strpos($attachFileName,'royalty')!==false){
									$fileType = 5;break;
								} else if(strpos($attachFileName,'invitees')!==false){
									$fileType = 6;break;
								} else if(strtolower($attachFileName) == "seller dd"){
									$fileType = 7;break;
								}else if(strpos($attachFileHref,'introdd')!==false){
									$fileType = 8;break;
								}else if(strpos($attachFileHref,'comparedd')!==false){
									$fileType = 9;break;
								}else if(strpos($attachFileHref,'pdfdd')!==false){
									$fileType = 10;break;
								}else if(strpos($attachFileHref,'introimages')!==false){
									$fileType = 11;break;
								}else if(strpos($attachFileHref,'marketdd')!==false){
									$fileType = 12;break;
								}else if(strpos($attachFileHref,'dictionarydd')!==false){
									$fileType = 13;break;
								}
							}
						}
						if($fileType>0){
							/*$totalPatents = $another['legal_patents'];*/
							$getList = $this->opportunity_model->getChartLeft($leadID);
							$totalPatents = 0;
							if(count($getList)>0){
								foreach($getList as $pat){
									$a = (int)$pat->patents + (int)$pat->applications;
									$totalPatents = $totalPatents + $a;
								}
							}
							$updateDataInDocket = array();
							$accessCode = $this->generateRandomString();
							switch($fileType){
								case 2:
									/*TechDD*/
									$updateDataInDocket = array('tech_access_code'=>$accessCode,'tech_email_address'=>'');
								break;
								case 3:
									/*LegalDD*/
									$updateDataInDocket = array('legal_access_code'=>$accessCode,'legal_email_address'=>'');
								break;				
								case 4:
									/*Illustrationdd*/
									$updateDataInDocket = array('illus_access_code'=>$accessCode,'illus_email_address'=>'');
								break;
								case 7:
									/*SellerDD*/									
									$updateDataInDocket = array('due_access_code'=>$accessCode,'email_address'=>'');									
								break;
								case 8:
									/*intro*/
									$updateDataInDocket = array('portfolio_access_code'=>$accessCode,'portfolio_email_address'=>'');
								break;
								case 9:
									/*Comparables*/
									$updateDataInDocket = array('comparables_access_code'=>$accessCode,'comparables_email_address'=>'');
								break;
								case 10:
									/*pdf*/
									$updateDataInDocket = array('pdf_access_code'=>$accessCode,'pdf_email_address'=>'');
								break;
								case 11:
									/*introimages*/
									$updateDataInDocket = array('images_access_code'=>$accessCode,'images_email_address'=>'');
								break;
								case 12:
									/*marketdd*/
									$updateDataInDocket = array('market_access_code'=>$accessCode,'market_email_address'=>'');
								break;	
								case 13:
									/*dictionarydd*/
									$updateDataInDocket = array('dictionary_access_code'=>$accessCode,'dictionary_email_address'=>'');
								break;
							}
							if(count($updateDataInDocket)>0){
								/**/
								$this->opportunity_model->changeLicenseAccessCode($leadID,$updateDataInDocket);
							}
							$href = "";
							if(is_array($email['href']) && count($email['href'])){
								foreach($email['href'] as $url){
									$href = $url['href'].",";
								}
								$href = substr($href,0,-1);
							}
							$allEmails = $email['to'].$email['cc'].$email['bcc'];
							$dataArray = array("lead_id"=>$leadID,'project_type'=>$fileType,"type"=>$projectType,"total_patent"=>$totalPatents,"create_date"=>date('Y-m-d H:i:s'),"expert"=>$allEmails,'file_url'=>$href);
							$this->user_model->due_logtime($dataArray);
							if(count($email['to'])>0){
								$emailTo = explode(',',$email['to']);
								if(count($emailTo)>0){
									/*Always take first email to attach with lead open project*/
									$contactEmail = trim($emailTo[0]);
									if(!empty($contactEmail)){
										/*get contact details from this email address*/
										/*$contactDetails = $this->lead_model->getContactByEmail($contactEmail);*/
										$contactDetails = $this->lead_model->getContactByEmailOrSecondary($contactEmail);
										if(count($contactDetails)>0){
											/*Update status of other LeadOpenProject by LEADID, TYPE*/
											$this->lead_model->updateOpenProjectDataByLeadType($leadID,$fileType);
											/*Insert data in lead open project*/
											$password = $this->generateRandomString();
											$projectEntry = $this->lead_model->insertOpenProjectData(array('lead_id'=>$leadID,'type'=>$fileType,'contact_id'=>$contactDetails->id,'password'=>$password));
											
											/**
												*If FileType=>4 for illustrationComplete
												*Find All files from Illustration Folder and give permission to this user for edit and remove Permissions for other users if granted											
											**/
											if((int)$fileType==4){
												$this->removeAndGrantIllustrationPermissions($leadID,$contactEmail);
											}
										}
									}
								}
							}
						}
					}
				}
			} else {
				/*Save post email data*/
				$jsonData = json_encode($_POST);
				$this->load->model('lead_model');
				$this->lead_model->addEmailRawData(array('raw_data'=>$jsonData));
			}
		}
		echo json_encode(array('email_id'=>$popEmail,'file_type'=>$fileType));
		die;
	}
	
	public function find_dd_password(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$lead = $this->input->post('l');
			$type = $this->input->post('type');
			if($type>0 && $lead>0){
				try{
					$this->load->model('opportunity_model');
					$this->load->model('lead_model');
					$getFieldsData = $this->opportunity_model->check_docket_password($lead,$type);
					$getPassword = $this->lead_model->checkOpenProjectData($lead,$type);
					if(count($getFieldsData) && count($getPassword)>0 && $getPassword->status==0){
						$data['password'] = $getPassword->password;
						$data['access_code'] = $getFieldsData['access_code'];
					}
				}catch(Exception $e){
					
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function removeAndGrantIllustrationPermissions($leadID,$contactEmail){	
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();
		$this->load->model('lead_model');
		$getLastUserOpenProject = $this->lead_model->findLastOpenProject($leadID,4,1);

		$getLeadFolderID = $this->lead_model->getLeadDataWithOptions($leadID,'l.folder_id');
		if(count($getLeadFolderID)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$q = "title='Illustration' and mimeType = 'application/vnd.google-apps.folder'";
			$findFolders = $service->searchFileIDFromChildern($getLeadFolderID->folder_id,$q);
			if(count($findFolders)>0){
				foreach($findFolders as $folder){
					$folderIllustrationID = $folder->id;
					$q = "title  contains  'Synpat - Claim Illustration' and mimeType = 'application/vnd.google-apps.presentation'";
					$listFiles = $service->searchFileIDFromChildern($folderIllustrationID,$q);
					$allFilesRemovePermission = array();
					$allFilesAddPermission = array();
					if(count($listFiles)>0){ 
						foreach($listFiles as $file){							
							if(count($getLastUserOpenProject)>0){
								$getPermissionsList = $service->getPrmissionsList($file->id);
								if(count($getPermissionsList)>0){
									foreach($getPermissionsList as $permission){
										if($permission->emailAddress==$getLastUserOpenProject->email || (!empty($getLastUserOpenProject->secondary_email) && $permission->emailAddress==$getLastUserOpenProject->secondary_email) || (!empty($getLastUserOpenProject->tertiary_email) && $permission->emailAddress==$getLastUserOpenProject->tertiary_email)){
											$allFilesRemovePermission[] = array('id'=>$file->id,'permission_id'=>$permission->id); 
										}
									}
								}
							}
							$allFilesAddPermission[] = $file->id;
							/*$service->setPermissions( $file->id, $contactEmail);*/
						} 
						if(count($allFilesRemovePermission)>0){
							$service->batchRequestForRemovePermissions($allFilesRemovePermission);
						}
						if(count($allFilesAddPermission)>0){
							$service->batchRequestForSetPermissions($allFilesAddPermission,$contactEmail);
						}
					}
				}
			}				
		}
	}
	
	
	function linkSearchMessage(){
		$data = 0;		
		if(!isset($_SESSION)){
			session_start();
		}
		if(isset($_POST) && count($_POST)>0){
			$send = $this->linkWithMessageOnGo($_POST['lead'],$_POST['mesg'],$_POST['date'],$_POST['type'],$_POST['send_from']);
			$dataSend = json_decode($send,true);
			$email_id = 0 ;
			if(isset($dataSend['send'])){
				$email_id = $dataSend['send'];
			} else if(isset($dataSend->send)){
				$email_id = $dataSend->send;
			}
			$date = "";
			if($_POST['date']!=""){
				$date = date('Y-m-d H:i:s',strtotime($_POST['date']));
			} else {
				$date = date('Y-m-d H:i:s');
			}
			if($email_id>0){
				$this->load->model('lead_model');
				$data = $email_id;
				$event = array();
				$event['company_id'] = $_POST['c_id'];
				$event['contact_id'] = $_POST['p_id'];
				$event['type'] = 6;
				$event['note'] = "";
				$event['user_id'] = $this->session->userdata['id'];
				$event['email_id'] = $email_id;
				$event['subject'] = $_POST['subject'];
				$event['lead_id'] = $_POST['lead'];
				$event['activity_date'] = $date;
				if($_POST['activity_type']==1){
					$this->lead_model->insetSalesActivity($event);
				} else if($_POST['activity_type']==3){
					$this->lead_model->insertPreSaleActivity($event);
				} else {
					$this->lead_model->insertAcquistionActivity($event);
				}
				$this->activityLog($event);
				$emails = array();
				if(isset($_SESSION['STARRED'])){
					$emails = $_SESSION['STARRED'];	
				}				
				$threadComesFrom = "";
				$findIDFlag = 0;				
				if(count($emails)>0){
					foreach($emails as $email){
						if($email['message_id'] == $_POST['mesg']){
							$findIDFlag = 1;
							$threadComesFrom = "STARRED";
						}
					}
				}
				if($findIDFlag==0){
					$emails = array();
					if(isset($_SESSION['INBOX'])){
						$emails = $_SESSION['INBOX'];
					}					
					if(count($emails)>0){
						foreach($emails as $email){
							if($email['message_id'] == $_POST['mesg']){
								$findIDFlag = 1;
								$threadComesFrom = "INBOX";
							}
						}
					}
				}			
				if($findIDFlag==0){
					$emails = array();
					if(isset($_SESSION['TRASH'])){
						$emails = $_SESSION['TRASH'];
					}
					if(count($emails)>0){
						foreach($emails as $email){
							if($email['message_id'] == $_POST['mesg']){
								$findIDFlag = 1;
								$threadComesFrom = "TRASH";
							}
						}
					}
				}
				/*if($findIDFlag==0){
					$emails = $_SESSION['LEAD'];
					if(count($emails)>0){
						foreach($emails as $email){
							if($email['message_id'] == $_POST['mesg']){
								$findIDFlag = 1;
								$threadComesFrom = "LEAD";
							}
						}
					}
				}*/
				if($findIDFlag==0){
					$emails = array();
					if(isset($_SESSION['SENT'])){
						$emails = $_SESSION['SENT'];
					}
					if(count($emails)>0){
						foreach($emails as $email){
							if($email['message_id'] == $_POST['mesg']){
								$findIDFlag = 1;
								$threadComesFrom = "SENT";
							}
						}
					}
				}
				if(!empty($threadComesFrom)){
					$unEmail = $_SESSION[$threadComesFrom];
					if(count($unEmail)>0){					
						$index=-1;
						$i=0;
						foreach($unEmail as $email){
							if($email['message_id'] == $_POST['mesg']){							
								$index=$i;
							}
							$i++;
						}
						if($index>=0){						
							unset($unEmail[$index]);
							$emailsREIndex = array_values($unEmail);
							$_SESSION[$threadComesFrom] = $emailsREIndex;
						}					
					}
					$service = new GmailServiceHelper();
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
					if(empty($labelID)){
						/*Create label*/
						$label = $service->createLabel("LEAD");
						if(is_object($label) && $label->getId()!=""){
							$labelID = $label->getId();
						}
						/*End Create Label*/
					}
					if(!empty($labelID)){
						$service->modifyMessage($_POST['mesg'],"me",$labelID);
						$service->modifyMessageRemove($_POST['mesg'],"me",'INBOX');
						$service->modifyMessageRemove($_POST['mesg'],"me",'STARRED');
					}
				}				
			}
		}
		echo $data;
		die;
	}
	
	
	function linkWithMessageOnGo($leadID,$threadID,$date,$type,$sendFrom=0){
		if(!empty($leadID) && !empty($threadID)){
			if(!isset($_SESSION)){
				session_start();
			}
			$this->load->library('DriveServiceHelper');
			$service = new GmailServiceHelper();
			$service->setAccessToken($_SESSION['access_token']);
			$getMessagesDetails = $service->findThreadData($threadID);
			$filesAttachment = "";
			$gmailMessageID = $threadID;
			$content = array();
			$thread_id = "";
			if(count($getMessagesDetails)>0){
				$attachmentArray = array();
				foreach($getMessagesDetails as $message){					
					$attachmentsConnect = array();
					$attachments = $message['attachments'];
					if(count($attachments)>0){
						foreach($attachments as $attachment){
							$filename =  $attachment['filename'];
							$filename = str_replace(',','-',$filename);
							$attachmentID  =  $attachment['attachmentId'];
							if(!in_array($attachmentID,$attachmentArray)){
								if(!empty($filename) && !empty($attachmentID)){
									$attachmentsData = $service->downloadAttachments($gmailMessageID,$attachmentID);
									if(is_object($attachmentsData)){
										$attachmentArray[] = $attachmentID;
										$rawData = $attachmentsData->data;
										$sanitizedData = strtr($rawData,'-_', '+/');
										$data = strtr($rawData, array('-' => '+', '_' => '/'));
										$body = base64_decode($sanitizedData);
										$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
										fwrite($fh, $body);
										fclose($fh);	
										/*$filesAttachment .=$this->config->base_url()."public/upload/".$filename.",";*/
										/*$fileData = $this->add_aws_file($filename,$_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
										$fileAWS = "";
										if(count($fileData)>0 && $fileData['error']==0){
											unlink($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
											$filesAttachment .= $fileData['file_url'].",";
											$fileAWS = $fileData['file_url'];
										}*/
										$filesAttachment .= $this->config->base_url()."public/upload/".$filename.",";
										$fileAWS = $this->config->base_url()."public/upload/".$filename;
										$attachmentsConnect[] = array('filename'=>$fileAWS,'mimeType'=>$attachment['mimeType'],"attachmentId"=>$attachmentID,"size"=>$attachment['size'],"realAttachID"=>$attachment['realAttachID']);
									}
								}
							}
						}
					}
					/*Find DD's link*/
					$newDDs = array();
					$body = $message['body'];
					$body = preg_replace("/https:\/\/synpat.com\/display_synpat_logo.php/m", '', $body);
					$this->load->library('simple_html_dom');
					try{
						$html = $this->simple_html_dom->load($body,true,true);
						if(is_object($html)){	
							$includedLink = array();
							foreach($html->find('<div class="gmail_chipgmail_drive_chip">') as $asTable) {
								foreach($asTable->find("a") as $anchor){
									$titles = "";$href="";
									if(!empty($anchor->innertext) && empty($titles)){
										$titles = $anchor->innertext;
									}
									if(!empty($anchor->plaintext) && empty($titles)){
										$titles = $anchor->plaintext;
									}
									if(empty($href)){
										if(!empty($anchor->{'href'})){
											$href = $anchor->{'href'};
										}
									}
									if(strpos($href,'synpat.com')===false && strpos($href,'javascript://')===false && strpos($href,'mailto:')===false && strpos($href,'docs.google.com')===false){
										if(!in_array($href,$includedLink)){
											$includedLink[] = $href;
											$filesAttachment .= $href.",";
											$newDDs[] = array('filename'=>$href,'mimeType'=>'',"attachmentId"=>'',"size"=>'',"realAttachID"=>'');
										}										
									}									
								}
							}
						}
					} catch(Exception $e){
						
					}
					
					if(count($newDDs)>0){
						$attachmentsConnect = array_merge($attachmentsConnect,$newDDs);
					}
					$thread_id = $message['thread_id'];
					$getMessageData = $message['content'];
					$parts = $getMessageData->getPayload()->getParts();
					$content[] = array("message_id"=>$message['message_id'],"labelIds"=>$message['labelIds'],"header"=>$message['header'],"body"=>$body,"attachments"=>$attachmentsConnect,'ppp'=>$parts);
				}
				if(!empty($filesAttachment)){
					$filesAttachment = substr($filesAttachment,0,-1);
				}
				$this->load->model('lead_model');
				$this->load->model('user_model');
				$sendFrom = 0;
				if(in_array("SENT", $message['labelIds'])){
					$sendFrom = 1;
				}
				$checkMessageInBox = $this->lead_model->findBoxByMessageID($threadID);
				if(count($checkMessageInBox)==0){
					$sendData = $this->lead_model->insertBox(array("lead_id"=>$leadID,"user_id"=>$this->session->userdata['id'],"message_id"=>$threadID,"thread_id"=>$thread_id,"content"=>json_encode($content),"file_attach"=>$filesAttachment,'date_received'=>date('Y-m-d H:i:s',strtotime($date)),'type'=>$type,'sent_from'=>$sendFrom));
					if($sendData>0){
						$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Add email into box.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						return json_encode(array('send'=>$sendData));
					} else {
						return json_encode(array('send'=>0));
					}
				} else {
					return json_encode(array('send'=>$checkMessageInBox[0]->id));
				}								
			} else {
				return json_encode(array('send'=>0));
			} 
		} else {
			return json_encode(array('send'=>0));
		}
	} 
	
	function message_task_conversation_send(){
		$getList = array();
		if(isset($_POST) && count($_POST)>0){
			$message = $this->input->post('message');	
			$mytask = $this->input->post('mytask');			
			if(isset($message['task_id']) && (int)$message['task_id']>0){
				$this->load->model('lead_model');				
				$this->load->model('opportunity_model');				
				$this->load->model('user_model');				
				$getDetails = $this->lead_model->getTaskConversationList($message['task_id']);
				$savedID = 0;
				$message['create_c'] = date('Y-m-d H:i:s');
				$users = array();
				if(isset($message['user'])){
					$users = $message['user'];
					unset($message['user']);
				}
				$sendEmail = 0;
				if(isset($message['send_email']) && $message['send_email']!=""){
					$sendEmail = $message['send_email'];
				}
				unset($message['send_email']);				
				$messageText = trim($message['message']);
				if(!empty($messageText)){
					$savedID = $this->lead_model->saveTaskConversation($message);
				}
				$sendMessgae = array();
				$getTaskDetail = $this->opportunity_model->findTask($message['task_id']);
				if(count($mytask)>0 && isset($mytask['user_id']) && (int)$mytask['user_id']>0  && count($getTaskDetail)>0){
					$this->opportunity_model->updateApprovalData($message['task_id'],$mytask);
				}
				if($savedID>0):
				if(count($getDetails)==0){					
					if(count($getTaskDetail)>0){
						$sendUserID = 0;
						if($getTaskDetail->fromUserID!=$this->session->userdata['id']){
							$sendMessgae[] = $getTaskDetail->fromUserID;
							$sendUserID = $getTaskDetail->fromUserID;
							$this->lead_model->saveTaskConversationFlag(array("user_id"=>$getTaskDetail->fromUserID,"task_id"=>$message['task_id'],"message_id"=>$savedID,'status'=>1));
						} else {
							$sendMessgae[] = $getTaskDetail->toUserID;	
							$sendUserID = $getTaskDetail->toUserID;
							$this->lead_model->saveTaskConversationFlag(array("user_id"=>$getTaskDetail->toUserID,"task_id"=>$message['task_id'],"message_id"=>$savedID,'status'=>1));
						}
						if($sendUserID>0){
							$checkUserData = $this->user_model->getUserData($sendUserID);
							if(count($checkUserData) && (int)$sendEmail==1){
								$leadData = $this->lead_model->getLeadData($getTaskDetail['id']);
								$this->load->library('email');
								$this->email->from($this->session->userdata['email'], $this->session->userdata['name']);
								$this->email->to($checkUserData->email); 
								$this->email->set_mailtype('html'); 
								$this->email->subject($getTaskDetail['subject']);
								$this->email->message('<html><head><title>New Task</title></head><body>'.$message['message'].'<p><a href="'.$this->config->base_url().'dashboard/index/'.$leadData->id.'">Click</a> href.</p></body></html>');	
								$this->email->send();
							}
						}
					}
				} else {					
					$setFlag = 0;
					foreach($getDetails as $user){			
						if($savedID>0){
							if($user->fromUser!=$this->session->userdata['id']  && !in_array($user->fromUser,$sendMessgae)){
								$sendMessgae[] = $user->fromUser;															
								$this->lead_model->saveTaskConversationFlag(array("user_id"=>$user->fromUser,"task_id"=>$message['task_id'],"message_id"=>$savedID,'status'=>1));
								$checkUserData = $this->user_model->getUserData($user->fromUser);
								if(count($checkUserData) && (int)$sendEmail==1){
									$leadData = $this->lead_model->getLeadData($getTaskDetail['id']);
									$this->load->library('email');
									$this->email->from($this->session->userdata['email'], $this->session->userdata['name']);
									$this->email->to($checkUserData->email); 
									$this->email->set_mailtype('html'); 
									$this->email->subject($getTaskDetail['subject']);
									$this->email->message('<html><head><title>New Task</title></head><body>'.$message['message'].'<p><a href="'.$this->config->base_url().'dashboard/index/'.$leadData->id.'">Click</a> href.</p></body></html>');	
									$this->email->send();
								}
								$setFlag = 1;
							}
						}						
					}
					
					if($setFlag ==0){
						if($savedID>0){
							$sendUserID = 0;
							if(count($getTaskDetail)>0){
								if($getTaskDetail->fromUserID!=$this->session->userdata['id']){
									$sendUserID = $getTaskDetail->fromUserID;
									$sendMessgae[] = $getTaskDetail->fromUserID;		
									$this->lead_model->saveTaskConversationFlag(array("user_id"=>$getTaskDetail->fromUserID,"task_id"=>$message['task_id'],"message_id"=>$savedID,'status'=>1));
								} else {
									$sendUserID = $getTaskDetail->toUserID;
									$sendMessgae[] = $getTaskDetail->toUserID;		
									$this->lead_model->saveTaskConversationFlag(array("user_id"=>$getTaskDetail->toUserID,"task_id"=>$message['task_id'],"message_id"=>$savedID,'status'=>1));
								}								
							}
							
							if($sendUserID>0){
								$checkUserData = $this->user_model->getUserData($sendUserID);
								if(count($checkUserData) && (int)$sendEmail==1){
									$leadData = $this->lead_model->getLeadData($getTaskDetail['id']);
									$this->load->library('email');
									$this->email->from($this->session->userdata['email'], $this->session->userdata['name']);
									$this->email->to($checkUserData->email); 
									$this->email->set_mailtype('html'); 
									$this->email->subject($getTaskDetail['subject']);
									$this->email->message('<html><head><title>New Task</title></head><body>'.$message['message'].'<p><a href="'.$this->config->base_url().'dashboard/index/'.$leadData->id.'">Click</a> href.</p></body></html>');	
									$this->email->send();
								}
							}
							
						}
					}
				}
				endif;
				if(count($users)>0){
					if($savedID>0){
						foreach($users as $user){
							if(!in_array($user,$sendMessgae)){
								$sendMessgae[] = $user;								
								$this->lead_model->saveTaskConversationFlag(array("user_id"=>$user,"task_id"=>$message['task_id'],"message_id"=>$savedID,'status'=>1));
								$checkUserData = $this->user_model->getUserData($user);
								if(count($checkUserData) && (int)$sendEmail==1){
									$leadData = $this->lead_model->getLeadData($getTaskDetail['id']);
									$this->load->library('email');
									$this->email->from($this->session->userdata['email'], $this->session->userdata['name']);
									$this->email->to($checkUserData->email); 
									$this->email->set_mailtype('html'); 
									$this->email->subject($getTaskDetail['subject']);
									$this->email->message('<html><head><title>New Task</title></head><body>'.$message['message'].'<p><a href="'.$this->config->base_url().'dashboard/index/'.$leadData->id.'">Click</a> href.</p></body></html>');	
									$this->email->send();
								}
							}
						}
					}
				}
			}
		}
		$getList = $this->lead_model->getTaskConversation($message['task_id']);	
		echo json_encode($getList);
		die;
	}
	
	function task_conversation(){
		$getList = array();
		if(isset($_POST) && count($_POST)>0){
			$c = $this->input->post('c');
			$this->load->model('lead_model');
			$getList = $this->lead_model->getTaskConversation($c);
		}
		echo json_encode($getList);
		die;
	}
	
	function message_task_conversation_remove(){
		if(isset($_POST) && count($_POST)>0){
			$c = $this->input->post('c');
			$this->load->model('lead_model');
			$this->lead_model->updateTaskFlagConversation($c,$this->session->userdata['id'],array('status'=>'2'));
		}
		die;
	}
	
	function callnotification(){
		$userID = $this->session->userdata['id'];
		$this->load->model('lead_model');
		$getList = $this->lead_model->getFlagConversations($userID,$this->input->post('f'),$this->input->post('l'));
		echo json_encode($getList);
		die;
	}
	
	
	function search_lead(){
		$searchData = array();
		if(isset($_POST) && count($_POST)>0){
			$searchFields = $this->input->post();
			$this->load->model('lead_model');
			$searchData = $this->lead_model->searchLeads($searchFields['search']);			
		}
		echo json_encode($searchData);
		die;
	}
	
	public function getDateWithFormat($sortDateFormat,$columData,$noShot){
		$data = $noShot;
		if($columData!="" && $columData!=null && $columData!='0000-00-00 00:00:00'){
			$data = date($sortDateFormat,strtotime($columData));
		}
		return $data;
	}
	
	public function getBlinkClass($content){
		$data = "";
		if((int)$content==1){
			$data = 'btn-blink';
		}
		return $data;
	}
	
	function getHtmlLeadTable($incomplete){
		if(count($incomplete)>0){
			$noShot = '<em>Blank</em>';
			$noShot = '';
			$sortDateFormat = 'd/m/y';
			$sortDateFormat = 'm/d/y';
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
				$lastSeen = '';
				$eou=0;
				if(isset($message->lead_last_seen) && $message->lead_last_seen!='0000-00-00'){
					$lastSeen = date($sortDateFormat,strtotime($message->lead_last_seen));
				}
				if(isset($message->eou)){
					$eou= (int) $message->eou;
				} else {
					$eou= 0;
				}
				$attractive = (int)$message->attractive;
				$brokerContact = $noShot;
				$brokerID = $message->broker_company;
				if(!empty($message->broker_contact)){
					$brokerContact = $message->broker_contact;
				}
				$broker_person_contact = $noShot;
				if(!empty($message->broker_person_contact)){
					$brokerContact .= " / ".$message->broker_person_contact;
				}
				$createDate = date($sortDateFormat,strtotime($message->create_date));
				$sellerC = 	$message->seller_contact;
				$column8 = $this->getDateWithFormat($sortDateFormat,$message->column8,$noShot);
				$column8B = $this->getBlinkClass($message->column8B);
				$column9 = $this->getDateWithFormat($sortDateFormat,$message->column9,$noShot);
				$column9B = $this->getBlinkClass($message->column9B);
				$column10 = $this->getDateWithFormat($sortDateFormat,$message->column10,$noShot);
				$column10B = $this->getBlinkClass($message->column10B);
				$column11 = $this->getDateWithFormat($sortDateFormat,$message->column11,$noShot);
				$column11B = $this->getBlinkClass($message->column11B);
				$column12 = $this->getDateWithFormat($sortDateFormat,$message->column12,$noShot);
				$column12B = $this->getBlinkClass($message->column12B);
				$column13 = $this->getDateWithFormat($sortDateFormat,$message->column13,$noShot);
				$column13B = $this->getBlinkClass($message->column13B);
				$column14 = $this->getDateWithFormat($sortDateFormat,$message->option_expiration_date,$noShot);
				$column14B = $this->getBlinkClass($message->column14B);
				$column15 = $this->getDateWithFormat($sortDateFormat,$message->column15,$noShot);
				$column15B = $this->getBlinkClass($message->column15B);
				$column25 = $this->getDateWithFormat($sortDateFormat,$message->column25,$noShot);
				$column25B = $this->getBlinkClass($message->column25B);
				$column26 = $this->getDateWithFormat($sortDateFormat,$message->column26,$noShot);
				$column26B = $this->getBlinkClass($message->column26B);
				$column27 = $this->getDateWithFormat($sortDateFormat,$message->column27,$noShot);
				$column27B = $this->getBlinkClass($message->column27B);
				$column28 = $this->getDateWithFormat($sortDateFormat,$message->column28,$noShot);
				$column28B = $this->getBlinkClass($message->column28B);
				$column29 = $this->getDateWithFormat($sortDateFormat,$message->column29,$noShot);
				$column29B = $this->getBlinkClass($message->column29B);
				$column30 = $this->getDateWithFormat($sortDateFormat,$message->column30,$noShot);
				$column30B = $this->getBlinkClass($message->column30B);
				$column31 = $this->getDateWithFormat($sortDateFormat,$message->column31,$noShot);
				$column31B = $this->getBlinkClass($message->column31B);
				$column32 = $this->getDateWithFormat($sortDateFormat,$message->column32,$noShot);
				$column32B = $this->getBlinkClass($message->column32B);
				$column33 = $this->getDateWithFormat($sortDateFormat,$message->column33,$noShot);
				$column33B = $this->getBlinkClass($message->column33B);
				$column34 = $this->getDateWithFormat($sortDateFormat,$message->column34,$noShot);
				$column34B = $this->getBlinkClass($message->column34B);
				$column35 = $this->getDateWithFormat($sortDateFormat,$message->column35,$noShot);
				$column35B = $this->getBlinkClass($message->column35B);
				/*DD List*/
				$column16 = $message->column16;
				$column17 = $message->column17;
				$column18 = $message->column18;
				$column19 = $message->column19;
				$column20 = $message->column20;
				$column21 = $message->column21;
				$column22 = $message->column22;
				$column23 = $message->column23;
				$column24 = $message->column24;
				
				
				/*
				$sellerInfo = $noShot;
				if($message->seller_info_text!="" && $message->seller_info_text!=null){
					$sellerInfo = date($sortDateFormat,strtotime($message->seller_info_text));
				}
				$sellerLike = $noShot;
				if($message->seller_like!="" && $message->seller_like!=null){
					$sellerLike = date($sortDateFormat,strtotime($message->seller_like));
				}
				$synpatLike = $noShot;
				if($message->synpat_like!="" && $message->synpat_like!=null){
					$synpatLike = date($sortDateFormat,strtotime($message->synpat_like));
				}
				$ppa = $noShot;
				if($message->ppa_date!="" && $message->ppa_date!=null){
					$ppa = date($sortDateFormat,strtotime($message->ppa_date));
				}
				$fundingTrnsfr = $noShot;
				if($message->funding_trnsfr!="" && $message->funding_trnsfr!=null){
					$fundingTrnsfr = date($sortDateFormat,strtotime($message->funding_trnsfr));
				}
				$sellerClass = "";
				if($message->seller_info==1){
					$sellerClass = "btn-blink";
				}
				$sellerContact = $noShot;
				if(empty($message->seller_contact)){
					if(!empty($message->plantiffs_name)){
						$sellerContact =  $message->plantiffs_name;
					}
				} else {
					$sellerContact =  $message->seller_contact;
				}*/
				
				$person_name_1 =$noShot;
				if(!empty($message->person_name_1)){
					$person_name_1 = $message->person_name_1;
				}
				$person_name_2 =$noShot;
				if(!empty($message->person_name_2)){
					$person_name_2 = $message->person_name_2;
				}
				$relates_to =$noShot;
				if(!empty($message->relates_to)){
					$relates_to = $message->relates_to;
				}
				
				if($mainFlag == 0){
	?> 
		<tr class="border-blue-alt droppable old_lead <?php echo $main;?>" data-sr="<?php echo $message->serial_number?>" data-id="<?php echo $message->id?>" data-type="<?php echo $message->type?>" data-b="<?php echo $brokerID;?>" onclick="threadDetail(jQuery(this))" <?php if($stage=="Oppt."):?>ondblclick="opportunityRedirect('<?php echo $message->id?>');"<?php endif;?>><td style="padding:3px 2px;border-right:0;border-left:none;width:150px" data-id="<?php echo $message->id?>" data-type="<?php echo $message->type?>" class=""><label><a style='text-align:left' title="<?php echo $message->lead_name;?>" class='btn' href="javascript:void(0)"><?php echo $sellerC;?></a></label></td><td style="padding:3px 2px;border-right:0;border-left:none;/*width:210px*/" data-id="<?php echo $message->id?>" data-type="<?php echo $message->type?>" class=""><label><a style='text-align:left' title="<?php echo $message->lead_name;?>" class='btn' href="javascript:void(0)"><?php echo substr($message->lead_name,0,30);?></a></label></td><td style="padding:3px 2px;border-right:0;border-left:none;width:35px"><?php echo $message->serial_number?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:20px" class=' one-line-cell'><?php echo $attractive;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:25px"><?php echo $type;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:53px" class=' one-line-cell' data-sort-value="<?php echo ($lastSeen!="")?strtotime($lastSeen):'0';?>"><?php echo $lastSeen;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none;width:40px;text-align:center;"><?php echo $eou;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none;width:95px;"><?php echo $brokerContact;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column8B;?> one-line-cell' data-sort-value="<?php echo($column8!="")?strtotime($column8):'0';?>"><?php echo $column8;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column9B;?> one-line-cell' data-sort-value="<?php echo($column9!="")?strtotime($column9):'0';?>"><?php echo $column9;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column10B;?> one-line-cell' data-sort-value="<?php echo($column10!="")?strtotime($column10):'0';?>"><?php echo $column10;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column11B;?> one-line-cell' data-sort-value="<?php echo($column11!="")?strtotime($column11):'0';?>"><?php echo $column11;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column12B;?> one-line-cell' data-sort-value="<?php echo($column12!="")?strtotime($column12):'0';?>"><?php echo $column12;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column13B;?> one-line-cell' data-sort-value="<?php echo($column13!="")?strtotime($column13):'0';?>"><?php echo $column13;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column14B;?> one-line-cell' data-sort-value="<?php echo($column14!="")?strtotime($column14):'0';?>"><?php echo $column14;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column15B;?> one-line-cell' data-sort-value="<?php echo($column15!="")?strtotime($column15):'0';?>"><?php echo $column15;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column16;?> one-line-cell'><?php echo $column16;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column17;?> one-line-cell'><?php echo $column17;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column18;?> one-line-cell'><?php echo $column18;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column19;?> one-line-cell'><?php echo $column19;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column20;?> one-line-cell'><?php echo $column20;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column21;?> one-line-cell'><?php echo $column21;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column22;?> one-line-cell'><?php echo $column22;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column23;?> one-line-cell'><?php echo $column23;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column24;?> one-line-cell'><?php echo $column24;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column25B;?> one-line-cell' data-sort-value="<?php echo($column25!="")?strtotime($column25):'0';?>"><?php echo $column25;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column26B;?> one-line-cell' data-sort-value="<?php echo($column26!="")?strtotime($column26):'0';?>"><?php echo $column26;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column27B;?> one-line-cell' data-sort-value="<?php echo($column27!="")?strtotime($column27):'0';?>"><?php echo $column27;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column28B;?> one-line-cell' data-sort-value="<?php echo($column28!="")?strtotime($column28):'0';?>"><?php echo $column28;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column29B;?> one-line-cell' data-sort-value="<?php echo($column29!="")?strtotime($column29):'0';?>"><?php echo $column29;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column30B;?> one-line-cell' data-sort-value="<?php echo($column30!="")?strtotime($column30):'0';?>"><?php echo $column30;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column31B;?> one-line-cell' data-sort-value="<?php echo($column31!="")?strtotime($column31):'0';?>"><?php echo $column31;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column32B;?> one-line-cell' data-sort-value="<?php echo($column32!="")?strtotime($column32):'0';?>"><?php echo $column32;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column33B;?> one-line-cell' data-sort-value="<?php echo($column33!="")?strtotime($column33):'0';?>"><?php echo $column33;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column34B;?> one-line-cell' data-sort-value="<?php echo($column34!="")?strtotime($column34):'0';?>"><?php echo $column34;?></td>
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $column35B;?> one-line-cell' data-sort-value="<?php echo($column35!="")?strtotime($column35):'0';?>"><?php echo $column35;?></td>
		
		
		<?php /*
		<td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $sellerClass;?> one-line-cell'><?php echo $sellerInfo;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px"><?php echo $synpatLike;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class=' one-line-cell'><?php echo $createDate;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px"><?php echo $ppa;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px"><?php echo $fundingTrnsfr;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $person_name_1;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $person_name_2;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $relates_to;?></td>
		<?php*/?>
		</tr>
	<?php
				} 
			}
		} else {
		?>
		<tr><td colspan="15">No lead found!</td></tr>
		<?php
		}
	}
	
	public function filterCheckHtml($li){
	?>
		<dl class="dpDropdown"><dt><input type="checkbox" class='filter_lead_box'/></dt><dd><div class="multiSelect" style="display: none;"><ul><?php echo $li;?></ul></div></dd></dl>
	<?php
	}
	
	function load_search_leads(){
		$postFields = $this->input->post();
		$pageNo = $postFields['page_no'];
		$orderBy = $postFields['sort_by'];
		$orderFields = $postFields['order'];
		/*$search = "";
		if(isset($postFields['search'])){
			$search = $postFields['search'];
		}*/
		$filterSearch = array();
		try{
			if(isset($postFields['filter_search'])){
				$filterSearch = json_decode($postFields['filter_search'],true);
			}
		}catch(Exception $e){
			
		}
		$noOfRecords = 35;
		$start = 0;
		$getLeads = array();
		if($pageNo>1){
			$start = ($pageNo-1)*$noOfRecords;
		} else if($pageNo==1){
			$start = $noOfRecords;
		}		
		$this->load->model('lead_model');
		if(count($filterSearch)==0){
			if((int)$this->session->userdata['type']!=9 && $this->session->userdata['type']!=8){
				$getLeads = $this->lead_model->findIncompleteANDCompleteListAccUser($this->session->userdata['id'],$start,$noOfRecords,$orderFields,$orderBy);
			} else {
				$getLeads = $this->lead_model->findIncompleteANDCompleteList('Market',$start,$noOfRecords,$orderFields,$orderBy);
			}
		} else {						
			$getLeads = $this->lead_model->findLeadByFilter($filterSearch,$this->session->userdata['type'],$this->session->userdata['id'],$start,$noOfRecords,$orderFields,$orderBy);
		}
		if(count($getLeads)>0){
			$this->getHtmlLeadTable($getLeads);
		}		
		die;
	}	
	
	function get_leads(){
		$postFields = $this->input->post();
		$incomplete = array();
		$this->load->model('lead_model');
		$page = 35;
		$leadTableFields = array('serial_number','lead_name','type','seller_info_text','synpat_like','create_date','ppa_date','funding_trnsfr','relates_to');
		$orderByFields = "l.lead_name";
		$orderBy = "ASC";
		$incomplete = array();
		if(isset($postFields['order']) && in_array($postFields['order'],$leadTableFields)){
			$orderByFields = "l.".$postFields['order'];
		}
		if(isset($postFields['sort_by']) &&	$postFields['sort_by']=="sorting_desc"){
			$orderBy = "DESC";
		}
		if((int)$this->session->userdata['type']!=9 && $this->session->userdata['type']!=8){
			$incomplete = $this->lead_model->findIncompleteANDCompleteListAccUser($this->session->userdata['id'],0,$page,$orderByFields,$orderBy);
		} else {
			$incomplete = $this->lead_model->findIncompleteANDCompleteList('Market',0,$page,$orderByFields,$orderBy);
		}
		/*$leadTableFields = array('serial_number','lead_name','attractive','type','lead_last_seen','eou','broker_contact','seller_info_text','synpat_like','create_date','ppa_date','funding_trnsfr','person_name_1','person_name_2','relates_to');*/
		$this->getHtmlLeadTable($incomplete);
		die;
	}
	
	function dFilter($type,$columnNo){
		$datesFilter ="<li><input type=\"checkbox\" value='blink' onclick='filterTable(jQuery(this),".$columnNo.")' data-field='".$type."'>Blink</li><li><input type=\"checkbox\" value='not_blink' onclick='filterTable(jQuery(this),".$columnNo.")' data-field='".$type."'>Not Blink</li><li><input type=\"checkbox\" value='empty' onclick='filterTable(jQuery(this),".$columnNo.")' data-field='".$type."'>Empty</li><li><input type=\"checkbox\" value='all' onclick='filterTable(jQuery(this),".$columnNo.")' data-field='".$type."'>Everything</li>";
		return $datesFilter;
	}
	
	function retreiveDashboardEmails(){		
		$this->load->library('DriveServiceHelper');
		$service = new GmailServiceHelper();
		if(!isset($_SESSION)){
			session_start();	
		}		
		$sessionAccessToken = "";
		if(!isset($_SESSION['guess_login'])){
			$_SESSION['guess_login']="0";
		}
		if(isset($_SESSION['guess_login']) && $_SESSION['guess_login']=="0"){
			if(isset($_SESSION['another_access_token'])){				
				$sessionAccessToken = $_SESSION['another_access_token'];
			}
			if(empty($sessionAccessToken)){
				$sessionAccessToken = $this->getUserToken();
			}
		} else {
			$sessionAccessToken= "synPat Guess Login";
		}
		if(!empty($sessionAccessToken)):
		if(isset($_SESSION['INBOX'])){
			$emails = $_SESSION['INBOX'];
		} else {
			$emails = array();
		}
		$incomplete = array();
		$this->load->model('lead_model');
		$page = 35;
		if((int)$this->session->userdata['user']['type']==9 || in_array(13,$this->session->userdata['modules_assign'])){
			if((int)$this->session->userdata['type']!=9 && $this->session->userdata['type']!=8){
				$page = $this->lead_model->countAssignedLead($this->session->userdata['id']);
				$incomplete = $this->lead_model->findIncompleteANDCompleteListAccUser($this->session->userdata['id'],0,$page);
			} else{
				$page = $this->lead_model->countLead();			
				$incomplete = $this->lead_model->findIncompleteANDCompleteList('Market',0,$page);
			}
		}		
		$getLeadColumnHeadings = $this->lead_model->getLeadColumnHeadings();
		$openEmailBox = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(11,$this->session->userdata['modules_assign'])){
				$openEmailBox = false;
			}
		}
		$sortDateFormat = 'm/d/y';
		/*Filter for all columns*/
		$leadNamesFilter = $serialNumberFilter = $attractiveFilter = $typeFilter = $leadLastSeenFilter =$eouFilter = $brokerFirmFilter = $sellerInfoTextFilter = $synpatLikeFilter = $createDateFilter =$ppaDateFilter = $fundingTrnsfrFilter = $personName1Filter = $personName2Filter = $relatesToFilter = $column8Filter = $column9Filter =  $column10Filter = $column11Filter = $column12Filter = $column13Filter = $column14Filter = $column15Filter = $column16Filter = $column17Filter = $column18Filter = $column19Filter = $column20Filter = $column21Filter = $column22Filter = $column23Filter = $column24Filter = $column25Filter = $column26Filter = $column27Filter = $column28Filter = $column29Filter = $column30Filter = $column31Filter = $column32Filter = $column33Filter = $column34Filter = $column35Filter = "";
		$column8FilterA = $column9FilterA =  $column10FilterA = $column11FilterA = $column12FilterA = $column13FilterA = $column14FilterA = $column15FilterA = $column16FilterA = $column17FilterA = $column18FilterA = $column19FilterA = $column20FilterA = $column21FilterA = $column22FilterA = $column23FilterA = $column24FilterA = $column25FilterA = $column26FilterA = $column27FilterA = $column28FilterA = $column29FilterA = $column30FilterA = $column31FilterA = $column32FilterA = $column33FilterA = $column34FilterA = $column35FilterA = array();
		$datesFiles="";
		if(count($incomplete)>0){
			$typeFilter .="<li><input type=\"checkbox\" value='Mkt.' onclick='filterTable(jQuery(this),3)' data-field='type'>Market</li><li><input type=\"checkbox\" value='Lit.' onclick='filterTable(jQuery(this),3)' data-field='type'>Litigation</li><li><input type=\"checkbox\" value='Pro.' onclick='filterTable(jQuery(this),3)' data-field='type'>Pro.</li><li><input type=\"checkbox\" value='SEP' onclick='filterTable(jQuery(this),3)' data-field='type'>SEP</li>";
			$column8Filter = $this->dFilter('column8',7);
			$column9Filter = $this->dFilter('column9',8);
			$column10Filter = $this->dFilter('column10',9);
			$column11Filter = $this->dFilter('column11',10);
			$column12Filter = $this->dFilter('column12',11);
			$column13Filter = $this->dFilter('column13',12);
			$column14Filter = $this->dFilter('column14',13);
			$column15Filter = $this->dFilter('column15',15);
			$column25Filter = $this->dFilter('column25',24);
			$column26Filter = $this->dFilter('column26',25);
			$column27Filter = $this->dFilter('column27',26);
			$column28Filter = $this->dFilter('column28',27);
			$column29Filter = $this->dFilter('column29',28);
			$column30Filter = $this->dFilter('column30',29);
			$column31Filter = $this->dFilter('column31',30);
			$column32Filter = $this->dFilter('column32',31);
			$column33Filter = $this->dFilter('column33',32);
			$column34Filter = $this->dFilter('column34',33);
			$column35Filter = $this->dFilter('column35',34);
			$brokerListArray = array();
			foreach($incomplete as $leads){				
				$leadNamesFilter .="<li><input type=\"checkbox\" value='".$leads->id."' onclick='filterTable(jQuery(this),0)' data-field='lead_name'>".$leads->lead_name."</li>";
				if(!empty(trim($leads->broker_person)) && !in_array($leads->broker_contact,$brokerListArray)){
				$brokerListArray[]= $leads->broker_contact;
				/*$brokerFirmFilter .="<li><input type=\"checkbox\" value='".$leads->broker_person."' onclick='filterTable(jQuery(this),6)' data-field='broker_contact'>".$leads->broker_contact."</li>";*/
				$brokerFirmFilter .="<li><input type=\"checkbox\" value='".$leads->broker_company."' onclick='filterTable(jQuery(this),6)' data-field='broker_contact'>".$leads->broker_contact."</li>";
				}	
			}
		}
		
	  $this->config->load('config');
	  /*$awsUrl = $this->config->item('aws_server_url');*/
	  $awsUrl = $this->config->item('aws_server_cdn');

	?><style>.circle {width: 10px;height: 10px;-moz-border-radius: 50px;-webkit-border-radius: 50px;border-radius: 50px;}li.docDragable.acive a{font-weight:bold;}.red{background:#d9534f;}.green{background: green;}#all_type_list thead tr th.header{padding:5px;display:table-cell;cursor:hand;cursor:pointer}#all_type_list thead tr th.headerSortUp,#all_type_list thead tr th.headerSortDown{background:#acc8dd}.attachment-list-item{float:left;width:100%}.attachment-list-item a{float:left;width:95%}.dpDropdown {
  position: absolute;
  top:50%;
  transform: translateY(-50%);
    left: 0px;
  /*right:10px;*/
  margin:0px;
}

.dpDropdown a {
  color: #fff;
}

.dpDropdown dd,
.dpDropdown dt {
  margin: 0px;
  padding: 0px;
}

.dpDropdown ul {
  margin: -1px 0 0 0;
}

.dpDropdown dd {
  position: relative;
}

.dpDropdown a,
.dpDropdown a:visited {
  color: #fff;
  text-decoration: none;
  outline: none;
  font-size: 12px;
}

.dpDropdown dt a {
 float:right;
}

.dpDropdown dt a span,
.multiSel span {
  cursor: pointer;
  display: inline-block;
  padding: 0 3px 2px 0;
}

.dpDropdown dd ul {
  background-color: #4F6877;
  border: 0;
  color: #fff;
  display: none;
  left: 0px;
  padding: 2px 15px 2px 5px;
  position: absolute;
  top: 2px;
  width: 280px;
  list-style: none;
  height: 100px;
  overflow: auto;
}

.dpDropdown span.value {
  display: none;
}
.dpDropdown dd ul li , .multiSelect ul li{
	list-style:none;
}
.multiSelect ul{padding:0px;
	list-style:none;
}
.dpDropdown dd ul li a {
  padding: 5px;
  display: block;
}

.dpDropdown dd ul li a:hover {
  background-color: #fff;
}
.dataTables_scrollBody .dpDropdown{display:none;}

.mrg19R {
    margin-right: 19px !important;
}
div#myEmailsRetrieve {
    /*overflow: inherit !important;*/
}
.panel > .list-group span.active{background:#2196f3; border:1px solid #1e88e5;}
a.list-group-item.active, a.list-group-item.active:hover, a.list-group-item.active:focus {border-left:0px solid #fff !important; border-right:0px #fff !important;}
.panel > .list-group .list-group-item{border-width:0px 0px}
.textRed{color:red}
td em{color:#ffffff}
.bbblock{display:block;}
.pd81{padding:4px 1px 0 0}
.pd84{padding:4px 4px}
.bbinline{display:inline-block;}</style> <script>snapGlobalFileWorkName='',snapGlobalFileWorkID='';$(function(){$(".gmail-modal .close").on("click",function(){$(".gmail-modal").hide()})});jQuery(document).ready(function(){initDragDrop();tabDropInit();leadsTableOneLineCells()});_cmU="<?php echo $this->session->userdata['email'];?>";window.specialChars={8:"\\b",9:"\\t",10:"\\n",12:"\\f",13:"\\r",39:"\\'",92:"\\\\"};window.escapedString=function(j){if(!j){return undefined}var a="";for(var b=0;b<j.length;b++){var e=j.charCodeAt(b);a+=specialChars[e]?specialChars[e]:String.fromCharCode(e)}return a};var timeline="";_CS="<?php echo $this->session->userdata['id']?>";function removeFromBox(b,a){if(jQuery.trim(a)!=""){jQuery.ajax({type:"POST",url:"<?php echo $this->config->base_url();?>leads/removeFromBox",data:{thread:a,g:b},cache:false,success:function(e){_data=jQuery.parseJSON(e);if(parseInt(_data.send)>0){refreshAcquisitionAndSalesActivity()}}})}}function initHoverEmailClose(){jQuery(document).ready(function(){jQuery("#aquisitionTable,#activityTable").find("table").find("tbody").find("tr").mouseover(function(){jQuery(this).find(".email-close").removeClass("hide")}).mouseleave(function(){jQuery(this).find(".email-close").addClass("hide")});jQuery("#aquisitionTable,#activityTable").find("tbody").find("tr").mouseover(function(){jQuery(this).find(".email-close").removeClass("hide")}).mouseleave(function(){jQuery(this).find(".email-close").addClass("hide")});jQuery("#from_regular,#from_litigation,#from_nonacquistion").find("#litigation_doc_list").find("ul").find("li").mouseover(function(){jQuery(this).find(".drive-close").removeClass("hide")}).mouseleave(function(){jQuery(this).find(".drive-close").addClass("hide")})})}function salesEmailDroppable(){}function recordLocal(a){switch(a){case"next":mainIndex=mainIndex+1;if(mainIndex>totalCC){mainIndex=totalCC}break;case"prev":mainIndex=mainIndex-1;if(mainIndex<0){mainIndex=0}break}threadDetail(jQuery("#all_type_list").find("tbody").find("tr").eq(mainIndex))}function activateLead(a){jQuery("#all_type_list").find("tbody").find("tr").each(function(){if(jQuery(this).attr("data-id")==a){threadDetail(jQuery(this))}})}function tabDropInit(){jQuery("#show_data").find(".nav-responsive").find("li").find("a").click(function(a){a.preventDefault();_tab=jQuery(this).attr("href");jQuery("#show_data").find(".nav-responsive").find("li").removeClass("active");jQuery("#show_data").find(".tab-pane").removeClass("active");jQuery(this).parent().addClass("active");jQuery("#show_data").find(_tab).addClass("active");reinitTabData();if(jQuery("#show_data").find('input[type="search"]').parent().find('i').length==0){
			jQuery("#show_data").find('input[type="search"]').css('width','80%').parent().append('<i class="glyph-icon icon-search" style="margin-left:-20px;"></i>');
		}showDataClickPrevent();});}function initAttachRemove(){jQuery(document).ready(function(){jQuery("ul.attachment-list").find("li").mouseover(function(){jQuery(this).find(".remove-attachment").removeClass("hide")}).mouseleave(function(){jQuery(this).find(".remove-attachment").addClass("hide")})})}function deleteMe(a){a.parent().parent().remove();jQuery("#emailDocUrl").val('');}function initDragDrop(){$(".label-dropable").droppable({hoverClass:"drop-hover",tolerance:"pointer",drop:function(a,b){b.draggable.css("display","none");_thread=b.draggable.attr("data-id");_label=jQuery(this).attr("data-title");_active=jQuery.trim(jQuery(".emails-group-container").find("a.active").html());if(_thread!=undefined&&_thread!=""&&_label!=undefined&&_label!=""&&_active!=undefined&&_active!=""){jQuery.ajax({type:"POST",url:__baseUrl+"dashboard/moveThreadDiff",data:{thread:b.draggable.attr("data-id"),label:_label,active:_active},cache:false,success:function(e){if(e>0){b.draggable.remove()}else{b.draggable.css("display","block");b.draggable.css("top","0px");b.draggable.css("left","0px")}}})}}});
$("#taskDocUrl").droppable({hoverClass:"drop-hover",drop:function(a,b){if(b.draggable.parent().hasClass('todo-box-1') && b.draggable.find('a').length>0){jQuery(this).val(b.draggable.find('a').attr('data-href'));}}});$("#attach_droppable").droppable({hoverClass:"drop-hover",drop:function(e,j){var b=j.draggable.find("a").attr("href");var a=j.draggable.html();var fileType = j.draggable.find('a').attr('file-type');_file_name=j.draggable.find('a').html(); if(j.draggable.hasClass('btnOutsidedraggable')){if(fileType=='seller'){_file_name='Seller DD';}a = leadNameGlobal+' - '+a;}if($(this).find("ul").length>0){$(this).find("ul").append("<li class='attachment-list-item'>"+a+" <span class='remove-attachment hide pull-right'><a class='' onclick='deleteMe(jQuery(this))'><i class='glyph-icon icon-close'></i></a></span></li>")}else{$(this).append("<ul class='attachment-list'><li class='attachment-list-item'>"+a+"<span class='remove-attachment hide pull-right'><a class='' onclick='deleteMe(jQuery(this))'><i class='glyph-icon icon-close'></i></a></span></li></ul>")}if(fileType=='seller'){$(this).find('li>a').text('Seller DD');}$(this).find('li>a').removeClass('btn').removeClass('btn-block').removeClass('btn-primary');if(j.draggable.hasClass('btnOutsidedraggable')){jQuery('#emailSubject').val(leadNameGlobal+' - '+_file_name);}jQuery("#emailDocUrl").val($(this).html());initAttachRemove()}});$('.dragToMePOS').droppable({
        over: function(event, ui){
			console.log("over");
            $( ".droppable" ).droppable(  "option", "disabled", true  )
        },
        out: function(event, ui){
			console.log("over");
            $( ".droppable" ).droppable( "option", "disabled", false )
        },hoverClass:"drop-hover",drop:function(e,j){var b=j.draggable.find("a").attr("href");var a=j.draggable.html();_fileHref=j.draggable.find('a').data('href');_fileName = j.draggable.find('a').html();fileAttachedToPost(_fileName,_fileHref,$(this).parents('tr'),$(this).data('p'));}});}function driveFileDraggable(){jQuery(document).ready(function(){$(".btnOutsidedraggable").draggable({helper:"clone",revert:true,zIndex:9999});$(".driveDragable").draggable({revert:true,helper:"clone",zIndex: 999999999})})}function deleteSalesInvitedC(a){con=confirm("Are you sure?");if(con){jQuery.ajax({type:"POST",url:__baseUrl+"opportunity/delete_c_sales",data:{l:leadGlobal,c:a},cache:false,success:function(b){refreshAcquisitionAndSalesActivity();}})}}function deleteAcquisitionInvitedC(a){con=confirm("Are you sure?");if(con){jQuery.ajax({type:"POST",url:__baseUrl+"opportunity/delete_c_acquisition",data:{l:leadGlobal,c:a},cache:false,success:function(b){if(b>0){refreshAcquisitionAndSalesActivity();}}})}}
_leadCompaniesAssignBroker=[];
_bUsT = <?php echo $this->session->userdata['type'];?>;
function salesActivityList(data){
	a = data.detail.sales_activity;
	_leadCompaniesAssignBroker=data.detail.broker_as_companies;
	if(a.length>0){
		activityHtmlEmbed('activityTable',1,a);
	} else {
		window.SalesUser=[];
		jQuery("#activityTable").find("tbody.main_active").empty();
	}
}


	function checkProcessColor(parentElement){
		objContainer = "";
		if(typeof parentElement=="undefined"){
			_mainActivity = jQuery("#activityMainType").val();
			if(_mainActivity=="1"){
				objContainer = "#activityTable";
			} else {
				objContainer = "#aquisitionTable";
			}
		} else {
			objContainer = "#"+parentElement;
		}
		
		jQuery(objContainer).find("tbody.main_active").find('tr.master').each(function(){
				_p = jQuery(this).find("select");
				if(_p.find('option:selected')){
					className = _p.find('option:selected').attr('class');
				}
				_p.removeClass('no-contact').removeClass('torquoise').removeClass('seablue').removeClass('darksea').removeClass('redsea');
				_p.addClass(className);
			});
	}
	function preSalesActivityList(a){}
	function docFileDraggable(){jQuery(document).ready(function(){$(".docDragable").draggable({revert:true,helper:"clone",zIndex:9999});$(".docDropable").droppable({hoverClass:"drop-hover",drop:function(e,j){if(j.draggable.hasClass('driveDragable')===false){var b=j.draggable.find("a").attr("data-href");var a=j.draggable.find("a").text();_id=jQuery(this).find("ul").attr("data-id");mainParent=jQuery(this);jQuery("#mainDocWaitBox").modal("show");if(b!=""&&a!=""&&_id!=""&&_id!=undefined&&a!=undefined&&b!=undefined){_container='';if(jQuery('#from_nonacquistion').is(':visible')){_container='from_nonacquistion';}if(jQuery('#from_litigation').is(':visible')){_container='from_litigation';}if(jQuery('#from_regular').is(':visible')){_container='from_regular';}_fF='';if(_container!=''){_fF = jQuery('#'+_container).find('select#clipboard').val();}jQuery.ajax({url:__baseUrl+"leads/fileInsert",type:"POST",data:{file_name:a,doc_url:b,d:_id,f:_fF},cache:false,success:function(k){jQuery("#mainDocWaitBox").modal("hide");_data=jQuery.parseJSON(k);if(_data.error=="0"){/*Refresh Drive Folder*/findThisDriveFile(jQuery('#'+_container).find('select#clipboard'));}else{alert("Please try later")}}})}}}})})}function findOwnThread(a,e,b,c){if(typeof _globalAjax=='object'){_globalAjax.abort();}if(typeof c=='undefined'){jQuery('#displayEmail').empty();}_mainActivity = parseInt(jQuery("#activityMainType").val());if(typeof(b)==="undefined"){b=0}jQuery(".mCSB_container").find(".message-item").each(function(){jQuery(this).removeClass("message-active");jQuery(this).find("h5").addClass("c-dark");jQuery(this).find("h4").addClass("c-dark");jQuery(this).find("p").addClass("c-gray");jQuery(this).find("a").addClass("c-dark")});if(b==0){e.parent().parent().parent().find("h5").removeClass("c-dark");e.parent().parent().parent().find("h4").removeClass("c-dark");e.parent().parent().parent().find("p").removeClass("c-gray");e.parent().parent().parent().find("a").removeClass("c-dark");e.parent().parent().parent().find("a").css("color","#FFF");e.parent().parent().parent().addClass("message-active");jQuery("#gmail_message").hide();jQuery("#from_regular").hide();jQuery("#from_litigation").hide();if(jQuery("#myDashboardComposeEmails").length>0){jQuery("#myDashboardComposeEmails").get(0).reset()}$("#all_type_list tbody td").removeClass("active");$("#all_type_list tbody tr").removeClass("active");$(".DTFC_Cloned tbody td").removeClass("active");$(".DTFC_Cloned tbody tr").removeClass("active");$("#other_list_boxes").empty()}if(typeof c!='undefined'){ if(c==2){e.parent().parent().parent().parent().find('div.message-item').removeClass('message-active')}if(c==1 || c==2) {leadGlobal='0';leadNameGlobal='';$("#all_type_list tbody td, #all_type_list tbody tr").removeClass("active");$(".DTFC_Cloned tbody td,.DTFC_Cloned tbody tr").removeClass("active"); jQuery("#marketLead").get(0).reset();jQuery('#from_regular,#from_litigation,#from_nonacquistion').css('display','none');e.parent().parent().parent().addClass('message-active');}}$("#other_list_boxes .message td").removeClass("active");if(!b){$("#all_type_list tbody td").removeClass("active");$(".DTFC_Cloned tbody td").removeClass("active")}jQuery("#messages-boxlist").find("ul.todo-box").find("li").each(function(){jQuery(this).removeClass("active");jQuery("#marketLead").get(0).reset()});if(b){jQuery("#aquisitionTable").find('tbody>tr>td').removeClass('active');jQuery("#aquisitionTable").find('tbody>tr>td').find('div').removeClass('active');jQuery("#activityTable").find('tbody>tr>td').removeClass('active');jQuery("#activityTable").find('tbody>tr>td').find('div').removeClass('active');jQuery("#preSaleActivityTable").find('tbody>tr>td').removeClass('active');jQuery("#preSaleActivityTable").find('tbody>tr>td').find('div').removeClass('active');e.parent().addClass("active")}if(_mainActivity>0 && typeof(e)=='object'){p=0,c_id=0;if(_mainActivity==2){if(jQuery("#aquisitionTable:visible").length>0){if(jQuery("#aquisitionTable:visible").find('input[name="sales_person[]"]:checked').length>0){if(jQuery("#aquisitionTable:visible").find('input[name="sales_person[]"]:checked').length==1){p=jQuery("#aquisitionTable:visible").find('input[name="sales_person[]"]:checked').val();c_id=jQuery("#aquisitionTable:visible").find('input[name="sales_person[]"]:checked').parent().parent().attr("data-c");} else {alert("Please select only one person from whom you received email")}}}}if(p>0&&c_id>0){thr=0;if(e.parent().parent().attr("data-tr")!='undefined'){thr = e.parent().parent().attr("data-tr")} else {thr = e.parent().parent().attr("data-id")}jQuery('#moveEmailPopup').modal('show');jQuery.ajax({type:"POST",url:__baseUrl+"dashboard/oldlinkWithMessage",data:{old_thread:leadGlobal,c_id:c_id,p:p,thread:thr,t:_mainActivity},cache:false,success:function(et){jQuery('#moveEmailPopup').modal('hide');if(et!=""){__data=jQuery.parseJSON(et);if(__data.send){e.parent().parent().remove();refreshAcquisitionAndSalesActivity();}else{alert("Please try after sometime")}}else{showLocalEmail(a,e,b);}}})}else{showLocalEmail(a,e,b);}} else {showLocalEmail(a,e,b);}}function showLocalEmail(a,e,b){var j=jQuery("#message-detail").height()-jQuery("#message-detail .panel-heading").outerHeight()+12;j=296;
	jQuery("#displayEmail").html('<iframe src="'+__baseUrl+"users/own_server_email/"+jQuery.trim(a)+'" scrolling="no" width="100%" height="'+j+'">')
	jQuery("#displayEmail iframe").off('load').on('load', function() {
		checkMyEmailsHeight();
	});
}_leadPatent="";_lT="";
	function linkOpen(){
		jQuery("#patentees_data").find("input[name='r_link[]']").on('focus',function(){if(jQuery(this).val()!=""){window.open(jQuery(this).val(),"_BLANK");}});
	}
	function list_seller_material(ml){
		jQuery("#list_seller_material").html("<li>Loading...</li>");
		if(leadGlobal>0){
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'leads/find_seller_material',
				data:{l:leadGlobal},
				dataType:'json',
				success:function(d){
					_li = "";
					if(d.length>0){
						for(i=0;i<d.length;i++){
							 obj = d[i];
							_fileURL = obj.alternateLink;
							_fileURL = _fileURL.replace("view?usp=drivesdk","preview");
							_fileURL = _fileURL.replace("edit?usp=drivesdk","preview");
							_icon = obj.iconLink;
							_title = obj.title;
							_li +='<li class=""><img src="'+_icon+'"> <a data-href="'+_fileURL+'" target="_BLANK" href="javascript://" onclick="open_drive_files(\''+_fileURL+'\')">'+_title+'</a></li>';
						}
					}
					jQuery("#list_seller_material").html(_li);
					if(ml!=""){
						links = ml.split(',');
						if(links.length>0){
							_li = "";
							for(s=0;s<links.length;s++){
								if(links[s]!=""){
									_li +='<li class=""><a href="javascript://" onclick="open_drive_files(\''+links[s]+'\')">'+links[s]+'</a></li>';
								}								
							}
							jQuery("#list_seller_material").append(_li);
						}
					}
				}
			});
		} else {
			jQuery("#list_seller_material").html("");
			alert("Please select lead first");
		}
	}
	
	function leadRunEntry(b,a){
		setTimeout(function(){checkLeadActivePosition()},500);
		jQuery.ajax({
			type:"POST",
			url:__baseUrl+"dashboard/lead_login",
			data:{o:b,n:a},
			cache:false,
			success:function(e){
				if(e!=0){
					if(jQuery("#all_type_list").find('tbody').find('tr[data-id="'+a+'"]').length>0){
												
					}
				}
			}
		})
	}
	function checkLeadActivePosition(){
		if(jQuery("#all_type_list").find("tbody").find("tr.active").length>0){
			_scrollTop=jQuery("#all_type_list").find("tbody").find("tr.active").offset();
			if(jQuery("#dashboard_charts").is(":visible")){
				_top = jQuery("#all_type_list").parent().scrollTop();
				_top = _top + _scrollTop.top
				jQuery("#all_type_list").parent().scrollTop(_top-113);
				/*jQuery("#all_type_list").parent().scrollTop(_top-110.5);*/
			} else {
				console.log("Pang");
				jQuery("#all_type_list").parent().scrollTop(_scrollTop.top-106);
			}
		} else {
			setTimeout(function(){checkLeadActivePosition()},500);
		}
	}
	
	leadRetrieveDataOrder = [0,1,2,3];//0=>leadForm,1=>Acquisition,2=>Sales,3=>Drive Files
function moduleShuffleLoader(){
	if(jQuery("#btnFormCollapse").hasClass('menu-active')){
		leadRetrieveDataOrder = [0,1,2,3];
	} else if(jQuery("#salesActivityButton").hasClass('menu-active')){
		leadRetrieveDataOrder = [2,0,1,3];
	} else if(jQuery("#acquisitionActivityButton").hasClass('menu-active')){
		leadRetrieveDataOrder = [1,0,2,3];
	} else {
		leadRetrieveDataOrder = [0,1,2,3];
	}
	<?php 
		/*If modules not assigned remove from leadRetrieveDataOrder*/
		if((int)$this->session->userdata['user']['type']<8):
			if(!in_array(14,$this->session->userdata['modules_assign'])){
	?>
				jQuery.each(leadRetrieveDataOrder,function(index,element){
					if(element==1){
						leadRetrieveDataOrder.splice(index,1);
					}
				});
	<?php 
			}
			if(!in_array(12,$this->session->userdata['modules_assign'])){
	?>
				jQuery.each(leadRetrieveDataOrder,function(index,element){
					if(element==0 || element==3){
						leadRetrieveDataOrder.splice(index,1);
					}
				});
	<?php
			}
			if(!in_array(15,$this->session->userdata['modules_assign'])){
	?>
				jQuery.each(leadRetrieveDataOrder,function(index,element){
					if(element==2){
						leadRetrieveDataOrder.splice(index,1);
					}
				});
	<?php
			}
		endif;
	?>
}

window.checkModuleOpen = function(){
	if(jQuery("#btnFormCollapse").hasClass('menu-active') || jQuery("#displayLitigationCampaign").hasClass('menu-active') || jQuery("#btnPatentsAll").hasClass('menu-active')){		
		callingOrder(0);
		if(jQuery("#btnFormCollapse").hasClass('menu-active')){
			console.log("ramp");
			/*callingOrder(3);*/
		}
	} 
	if(jQuery("#salesActivityButton").hasClass('menu-active')){
		callingOrder(2);
	} 
	if(jQuery("#acquisitionActivityButton").hasClass('menu-active')){
		callingOrder(1);
	}
}
var leadCache = [];
window.leadCacheScript = function(leadID){
	moduleShuffleLoader();
	leadID = parseInt(leadID);
	if(!leadCache[leadID]){
		leadObject = {lead_data:'',drive_data:'',acquisition_data:'',sales_data:''};
		leadCache[leadID] = leadObject;
		leadGlobal = leadID;
		jQuery.each(leadRetrieveDataOrder,function(index,element){
			callingOrder(element);
		});
	} else {
		runLeadData = false;
		jQuery.each(leadRetrieveDataOrder,function(index,element){
			switch(element){
				case 0:
					if(typeof(leadCache[leadID].lead_data)=="undefined" || typeof(leadCache[leadID].lead_data.detail) =="undefined"){
						runLeadData = true;
					}
				break;
				case 1:
					if(typeof(leadCache[leadID].acquisition_data)=="undefined" || leadCache[leadID].acquisition_data.length==0){
						runLeadData = true;
					}
				break;
				case 2:
					if(typeof(leadCache[leadID].sales_data)=="undefined" || typeof(leadCache[leadID].sales_data.detail)=="undefined"){
						runLeadData = true;
					}
				break;
				case 3:
					if(typeof(leadCache[leadID].drive_data)=="undefined" || typeof(leadCache[leadID].drive_data.drive)=="undefined"){
						runLeadData = true;
					}
				break;
			} 
		});
		if(runLeadData===false){	
			leadGlobal = leadID;
			jQuery.each(leadRetrieveDataOrder,function(index,element){
				switch(element){
					case 0:
						showLeadData();
					break;
					case 1:
						showAcqusitionData();
					break;
					case 2:
						showSalesData();
					break;
					case 3:
						showDriveData();
					break;
				}
			});
		} else {
			leadObject = {lead_data:'',drive_data:'',acquisition_data:'',sales_data:''};
			leadCache[leadID] = leadObject;
			leadGlobal = leadID;
			jQuery.each(leadRetrieveDataOrder,function(index,element){
				callingOrder(element);
			});
		}		
	}
}
leadSerialGlobal=0;
function enableButtonScript(g){
	lead_type = jQuery("#all_type_list").find('tbody>tr[data-id="'+g+'"]').data('type');
	leadNameGlobal = jQuery("#all_type_list").find('tbody>tr[data-id="'+g+'"]').find('td').eq(0).find('a').attr('title');
	leadSerialGlobal = jQuery("#all_type_list").find('tbody>tr[data-id="'+g+'"]').data('sr');
	_leadFormType='';
		switch(lead_type){
		case 'Market':
		case 'General':
			_leadFormType='from_regular';
		break;
		case 'NON':
		case 'INT':
			_leadFormType='from_nonacquistion';
		break;
		case 'Litigation':
			_leadFormType='from_litigation';
		break;	
	}
	_mainBtnParentElement = _mainButtonParentElement = _leadFormType;
	if(leadNameGlobal!=undefined){
		jQuery('.topbar-lead-name').html(leadNameGlobal+' '+leadSerialGlobal);
	}
	<?php if((int)$this->session->userdata['user']['type']==9):?>
	jQuery("#salesActivityButton").attr("onclick","displaySaleActivityTable('',jQuery(this))");
	jQuery("#acquisitionActivityButton").attr("onclick","displayAquisitionActivityTable('',jQuery(this))");
	jQuery("#btnPatentsAll").attr("onclick","displayPatentTable('')");jQuery("#preSaleActivityButton").attr("onclick","displayPreSaleActivityTable('',jQuery(this))");
	<?php 
		else:
		foreach($this->session->userdata['modules_assign'] as $m){
			switch($m){
				case 14:
		?>
			jQuery("#acquisitionActivityButton").attr("onclick","displayAquisitionActivityTable('',jQuery(this))");
		<?php
				break;
				case 15:
		?>
				jQuery("#salesActivityButton").attr("onclick","displaySaleActivityTable('',jQuery(this))");
		<?php
				break;
				case 16:
		?>
				jQuery("#btnPatentsAll").attr("onclick","displayPatentTable('from_litigation')");
		<?php
				break;
				case 25:
		?>
				jQuery("#preSaleActivityButton").attr("onclick","displayPreSaleActivityTable('',jQuery(this))");
		<?php
				break;				
			}
		}
		endif;?>
}


function leadDataDisplay(_data){
	if(_data.detail.length>0){
		snapGlobal=_data.detail[0].litigation.file_url;_st="<?php echo $this->session->userdata['type'];?>";_sp="<?php echo $this->session->userdata['id'];?>";leadGlobal=_data.detail[0].litigation.id;snp=_data.detail[0].litigation.serial_number;leadNameGlobal=_data.detail[0].litigation.lead_name;snapGlobalFileID=_data.detail[0].litigation.spreadsheet_id;snapGlobalFileWorkID = _data.detail[0].litigation.worksheet_id;snapGlobalFileWorkName = _data.detail[0].litigation.worksheet_name;jQuery(".topbar-lead-name").css("width","440px;").html(leadNameGlobal+' '+leadSerialGlobal);
		<?php 
		$openTask = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(4,$this->session->userdata['modules_assign'])){
				$openTask = false;
			}
		}
		if($openTask===true):?>
		_senddt="<?php echo $this->session->userdata['id'];?>";
		_objComment = jQuery("#btnComments");
		if(_objComment.length > 0){
			_objComment.find("#commentComment1").val("");_objComment.find("#commentComment2").val("");_objComment.find("#commentComment3").val("");_objComment.find("#leadType").val(_data.detail[0].litigation.type);_objComment.find("#commentID").val("0");_objComment.find("select[name='attractiveness']").find("option").each(function(){jQuery(this).removeAttr("SELECTED")});
			_objComment.find("#comment_upper_list").empty();
			if(_data.detail[0].comment.length>0){
				console.log("Lead Comments");
				<?php /*if((int)$this->session->userdata['type']==9):*/?>
				_objComment.find("#comment_upper_list").empty().html("<table class='table'><thead><tr><th>Are there >10 potential licensees? Who?</th><th>Easy to show infringement? Are there EoU? How clear?</th><th>Seller's concerns + Your general observations</th><th>Attractiveness</th><th style='width:70px;'>Created</th><th style='width:70px;'>Updated</th><th>By</th></tr></thead><tbody></tbody></table>");
				<?php /*endif;*/?>
				for(i=0;i<_data.detail[0].comment.length;i++){
					_flag=0;_comment=_data.detail[0].comment[i];
					if(_comment.user_id==_senddt){
						_flag=1;_commentID=_comment.id;_commentText1=_comment.comment1;_commentText2=_comment.comment2;_commentText3=_comment.comment3;_commentAttractive=_comment.attractive;
						_objComment.find("#commentComment1").val(_commentText1);					
						_objComment.find("#commentComment2").val(_commentText2);
						_objComment.find("#commentComment3").val(_commentText3);
						_objComment.find("#commentId").val(_commentID);
						_objComment.find("select[name='attractiveness']").find("option").each(function(){
							if(jQuery(this).attr("value")==_commentAttractive){
								jQuery(this).attr("SELECTED","SELECTED");
							} else {
								jQuery(this).removeAttr("SELECTED");
							}
						});
					}
					<?php /*if((int)$this->session->userdata['type']==9):*/?>
					if(_flag==0){
						var createdDate="";var u="";
						if(_comment.created==null||_comment.created=="0000-00-00 00:00:00"){
							createdDate="";
						} else {
							createdDate=moment(new Date(_comment.created)).format("MM-D-YY");
						}
						if(_comment.updated==null||_comment.updated=="0000-00-00 00:00:00"){
							u="";
						} else {
							u=moment(new Date(_comment.updated)).format("MM-D-YY");
						}
						var comment1=nl2br(_comment.comment1);
						var comment2=nl2br(_comment.comment2);
						var comment3=nl2br(_comment.comment3);
						var _tr="<tr><td>"+comment1.linkify()+" </td><td>"+comment2.linkify()+" </td><td>"+comment3.linkify()+' </td><td><span class="label alert">'+_comment.attractive+"</span></td>	<td>"+createdDate+"</td><td>"+u+"</td><td>"+_comment.name+"</td></tr>";
						_objComment.find("table").find("tbody").append(_tr)
					}
					<?php /*endif;*/?>
				}
			}
		}
		<?php endif;
		$openDocket = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(2,$this->session->userdata['modules_assign'])){
				$openDocket = false;
			}
		}
		if($openDocket===true):?>
			if(jQuery("#open_opportunity").is(":visible")){/*jQuery("#docket_frame").html('<iframe width="100%" height="600px" scrolling="yes" src="'+__baseUrl+'opportunity/dummy_opportunity/'+leadGlobal+'"></iframe>');*/jQuery("#open_opportunity").find("#docketLabel").html("Docket - "+leadNameGlobal)}
		<?php endif;
		$openEOU = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(20,$this->session->userdata['modules_assign'])){
				$openEOU = false;
			}
		}
		if($openEOU===true):?>
		if(jQuery("#open_eou_folder").is(":visible")){/*jQuery("#eou_frame").html('<iframe width="100%" height="600px" scrolling="yes" src="'+__baseUrl+'opportunity/eou_in_folder/'+leadGlobal+'"></iframe>')*/}
		<?php endif;
		$openTimeline = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(7,$this->session->userdata['modules_assign'])){
				$openTimeline = false;
			}
		}
		if($openTimeline===true):?>
		var I="";$('#activitySlidebarTable').DataTable().destroy();
		_dataTimeLine=_data.detail[0].timeLine;for(i=0;i<_dataTimeLine.length;i++){switch(jQuery.trim(_dataTimeLine[i].message)){case"PPA drafted":_draft_ppa_date=_dataTimeLine[i].create_date;break;case"Executed PPA":_executed_ppa=_dataTimeLine[i].create_date;break;case"PPA executed":_executed_ppa=_dataTimeLine[i].create_date;break;case"Send request to CIPO for uploading damages report.":_upload_damage_report=_dataTimeLine[i].create_date;break;case"Send request to CIPO to start work on DD":_cipo_start_work_dd=_dataTimeLine[i].create_date;break;case"NDA created":_nda_created=_dataTimeLine[i].create_date;break;case"NDA approved":_nda_approved=_dataTimeLine[i].create_date;break;case"Execute NDA by PD":_nda_execute=_dataTimeLine[i].create_date;break;case"CIPO approved NDA":_nda_approved=_dataTimeLine[i].create_date;break;case"Send request to CIPO for NDA approval":_send_req_nda_approval=_dataTimeLine[i].create_date;break;case"EOU confirmed":_eou_confirmed=_dataTimeLine[i].create_date;break;case"NDA shared with Sellers":_nda_shared=_dataTimeLine[i].create_date;break;case"Insert list of Assets":_list_of_assets_send=_dataTimeLine[i].create_date;break;case"CIPO Approved assets.":_list_of_assets_approve=_dataTimeLine[i].create_date;break;case"Drafted PLA":_draft_pla=_dataTimeLine[i].create_date;break;case"Drafted Participant":_draft_participant=_dataTimeLine[i].create_date;break}if(_dataTimeLine[i].hasOwnProperty("leadType")){switch(_dataTimeLine[i].leadType){case"Litigation":_colorClass="bg-yellow";break;case"Market":_colorClass="bg-green";break;case"General":_colorClass="label-info";break;case"SEP":_colorClass="bg-warning";break}_colorClass="";_label="";_label=(_dataTimeLine[i].lead_name!="")?_dataTimeLine[i].lead_name:_dataTimeLine[i].plantiffs_name}I+='<tr><td  onclick="openLeadDetail('+_dataTimeLine[i].lead_id+')">'+_label+'</td><td>'+_dataTimeLine[i].name+'</td><td>'+_dataTimeLine[i].message+'</td><td>'+moment(new Date(_dataTimeLine[i].create_date)).format("MMM D, YYYY")+'</td></tr>'}jQuery("#activity").find('table').find('tbody').html(I);$('#activitySlidebarTable').find('thead').html('<tr><th>Lead</th><th>Person</th><th>Activity</th><th>Date</th></tr>');$('#activitySlidebarTable').DataTable({
													"searching":false,
													"autoWidth": true,
													"paging": false,
													"sScrollY": $(window).height() - 130 + 'px',
													"sScrollX": "100%",
													"sScrollXInner": "100%"
												});
		<?php endif;?>
		jQuery("#taskType").val(_data.detail[0].litigation.type);
		<?php 
		$openTask = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(6,$this->session->userdata['modules_assign'])){
				$openTask = false;
			}
		}
		if($openTask===true):?>
		var K="";_dataTask=_data.detail[0].task;for(i=0;i<_dataTask.length;i++){_colors_array="";switch(_dataTask[i].type){case"Litigation":_colors_array="bg-yellow";break;case"Market":case"NON":case"INT":_colors_array="bg-green";break;case"General":_colors_array="label-info";break;case"SEP":_colors_array="bg-warning";break}if(parseInt(_dataTask[i].userType)==9&&_dataTask[i].approved_type=="LEAD"){_userName="System"}else{_userName=_dataTask[i].userName}_img='<img title="'+_dataTask[i].uuserName+'" src="<?php echo $awsUrl; ?>upload/user.png" width="28" />';if(_dataTask[i].profile_pic!=""){_img='<img title="'+_dataTask[i].uuserName+'" src="'+_dataTask[i].profile_pic+'" width="28" />'}_leadName=(_dataTask[i].lead_name!="")?_dataTask[i].lead_name:_dataTask[i].plantiffs_name;K+='<li><a href="javascript://" onclick="approvedFile('+_dataTask[i].approved_id+')"><span class="tl-label bs-label '+_colors_array+'">'+_leadName+'</span><span class="todo-container"><span class="todo-content" for="todo-1" title="'+_dataTask[i].subject+'">'+_dataTask[i].subject+'</span><span class="todo-footer clearfix"><span class="todo-footer-dateuser"> '+moment(new Date(_dataTask[i].taskCreateDate)).format("MMM D, YYYY")+"	&nbsp;&nbsp;&nbsp;"+_userName+"</span>"+_img+"</span></span></a></li>"}
		jQuery("#task_list").find("ul.todo-box").html(K);_dataTask=_data.detail[0].task_i;if(_dataTask.length>0){jQuery("#my_c_task_list").find("ul.todo-box").empty();K="";for(i=0;i<_dataTask.length;i++){_colors_array="";switch(_dataTask[i].type){case"Litigation":_colors_array="bg-yellow";break;case"Market":case"NON":case"INT":_colors_array="bg-green";break;case"General":_colors_array="label-info";break;case"SEP":_colors_array="bg-warning";break}if(parseInt(_dataTask[i].userType)==9&&_dataTask[i].approved_type=="LEAD"){_userName="System"}else{_userName="<?php echo $this->session->userdata['name']?>"}_img='<img title="'+_dataTask[i].userName+'" src="<?php echo $awsUrl; ?>upload/user.png" width="28" />';if(_dataTask[i].profile_pic!=""){_img='<img title="'+_dataTask[i].userName+'" src="'+_dataTask[i].profile_pic+'" width="28" />'}_leadName=(_dataTask[i].lead_name!="")?_dataTask[i].lead_name:_dataTask[i].plantiffs_name;K+='<li><a href="javascript://" onclick="approvedFile('+_dataTask[i].approved_id+')"><span class="tl-label bs-label '+_colors_array+'">'+_leadName+'</span><span class="todo-container"><span class="todo-content" for="todo-1" title="'+_dataTask[i].subject+'">'+_dataTask[i].subject+'</span><span class="todo-footer clearfix"><span class="todo-footer-dateuser"> '+moment(new Date(_dataTask[i].taskCreateDate)).format("MMM D, YYYY")+"	&nbsp;&nbsp;&nbsp;"+_userName+"</span>"+_img+"</span></span></a></li>"}jQuery("#my_c_task_list").find("ul.todo-box").html(K)}else{jQuery("#my_c_task_list").find("ul.todo-box").empty()}
		<?php endif;	
		$openLeadDT = true;
		$openPatentTable = true;
		$openLitigationTable = true;
		if((int)$this->session->userdata['type']!=9){												
			if(!in_array(12,$this->session->userdata['modules_assign'])){
				$openLeadDT = false;
			} 
		}
		if((int)$this->session->userdata['type']!=9){												
			if(!in_array(16,$this->session->userdata['modules_assign'])){
				$openPatentTable = false;
			} 
		}
		if((int)$this->session->userdata['type']!=9){												
			if(!in_array(19,$this->session->userdata['modules_assign'])){
				$openLitigationTable = false;
			} 
		}
		if((int)$this->session->userdata['user']['type']==9 || in_array(15,$this->session->userdata['modules_assign'])):?>
			
		<?php endif;
		if((int)$this->session->userdata['user']['type']==9 || in_array(25,$this->session->userdata['modules_assign'])):?>
			
		<?php endif;?>			
		if(_data.detail[0].litigation.type!="Litigation"&&_data.detail[0].litigation.type!="NON"&&_data.detail[0].litigation.type!="INT"){_mainButtonParentElement="from_regular"}else{if(_data.detail[0].litigation.type=="NON"||_data.detail[0].litigation.type=="INT"){_mainButtonParentElement="from_nonacquistion"}else{if(_data.detail[0].litigation.type=="Litigation"){_mainButtonParentElement="from_litigation"}}}
		<?php if($openLeadDT===true):?>
		if(_data.detail[0].litigation.type!="Litigation"&&_data.detail[0].litigation.type!="NON"&&_data.detail[0].litigation.type!="INT"){jQuery("#from_litigation,#from_nonacquistion").hide();if(jQuery('#btnFormCollapse').hasClass('menu-active')){jQuery("#from_regular").show();}_mainButtonParentElement="from_regular"}else{if(_data.detail[0].litigation.type=="NON"||_data.detail[0].litigation.type=="INT"){jQuery("#from_litigation,#from_regular").hide();if(jQuery('#btnFormCollapse').hasClass('menu-active')){jQuery("#from_nonacquistion").show();}_mainButtonParentElement="from_nonacquistion"}else{if(_data.detail[0].litigation.type=="Litigation"){if(jQuery('#btnFormCollapse').hasClass('menu-active')){jQuery("#from_litigation").show();}jQuery("#from_regular,#from_nonacquistion").hide();_mainButtonParentElement="from_litigation"}}}
		<?php endif;?>
		_leadPatent=_data.detail[0].litigation.patent_data;jQuery("#mytimeline").empty();_createDD=moment(new Date(_data.detail[0].litigation.create_date)).format("D.MM.YYYY");$("#timeline-html-wrap:hidden").empty();
		jQuery("#from_nonacquistion,#from_regular,#from_litigation").find(".button-list").empty();
		<?php if($openLeadDT===true):?>
		resetLeadFormComplete();
		objMainElement = jQuery('#'+_mainButtonParentElement);
		if(_data.detail[0].open_project.length>0){
			open_project = _data.detail[0].open_project;
			for(op=0;op<open_project.length;op++){
				check= false;
				if(parseInt(open_project[op].status)==1){
					check=true;
				}
				_nameCombine = open_project[op].personName+', '+open_project[op].company_name;
				if(objMainElement.length==0){
					objMainElement = window.parent.jQuery('#'+_mainButtonParentElement);
				}
				switch(parseInt(open_project[op].type)){
					case 1:
					break;
					case 2:
					objMainElement.find('input#leadOpenTechnicalOpenContact').val(_nameCombine);
					objMainElement.find('span#spnleadOpenTechnicalOpenContact').attr('title',_nameCombine).text(_nameCombine);
					objMainElement.find('input#leadOpenTechnicalContact').val(open_project[op].contact_id);
					objMainElement.find('input#leadOpenTechnicalOpenStatus').prop('checked',check);
					break;
					case 12:
					objMainElement.find('input#leadOpenMarketOpenContact').val(_nameCombine);
					objMainElement.find('span#spnleadOpenMarketOpenContact').attr('title',_nameCombine).text(_nameCombine);
					objMainElement.find('input#leadOpenMarketContact').val(open_project[op].contact_id);
					objMainElement.find('input#leadOpenMarketOpenStatus').prop('checked',check);
					break;
					case 3:
					objMainElement.find('input#leadOpenLegalOpenContact').val(_nameCombine);
					objMainElement.find('span#spnleadOpenLegalOpenContact').attr('title',_nameCombine).text(_nameCombine);
					objMainElement.find('input#leadOpenLegalContact').val(open_project[op].contact_id);
					objMainElement.find('input#leadOpenLegalOpenStatus').prop('checked',check);
					break;
					case 4:
					objMainElement.find('input#leadOpenIllustrationOpenContact').val(_nameCombine);
					objMainElement.find('span#spnleadOpenIllustrationOpenContact').attr('title',_nameCombine).text(_nameCombine);
					objMainElement.find('input#leadOpenIllustrationContact').val(open_project[op].contact_id);
					objMainElement.find('input#leadOpenIllustrationOpenStatus').prop('checked',check);
					break;
					case 5:
					objMainElement.find('input#leadOpenRoyaltyOpenContact').val(_nameCombine);
					objMainElement.find('span#spnleadOpenRoyaltyOpenContact').attr('title',_nameCombine).text(_nameCombine);
					objMainElement.find('input#leadOpenRoyaltyContact').val(open_project[op].contact_id);
					objMainElement.find('input#leadOpenRoyaltyOpenStatus').prop('checked',check);
					break;
					case 6:
					objMainElement.find('input#leadOpenInviteesOpenContact').val(_nameCombine);
					objMainElement.find('span#spnleadOpenInviteesOpenContact').attr('title',_nameCombine).text(_nameCombine);
					objMainElement.find('input#leadOpenInviteesContact').val(open_project[op].contact_id);
					objMainElement.find('input#leadOpenInviteesOpenStatus').prop('checked',check);
					break;
					case 7:
						/*Seller*/
						objMainElement.find('input#leadOpenSellerOpenContact').val(_nameCombine);
						objMainElement.find('input#leadOpenSellerContact').val(open_project[op].contact_id);
						objMainElement.find('span#spnleadOpenSellerOpenContact').attr('title',_nameCombine).text(_nameCombine);
						objMainElement.find('input#leadOpenSellerOpenStatus').prop('checked',check);
					break;
					case 8:
					objMainElement.find('input#leadOpenIntroOpenContact').val(_nameCombine);
					objMainElement.find('span#spnleadOpenIntroOpenContact').attr('title',_nameCombine).text(_nameCombine);
					objMainElement.find('input#leadOpenIntroContact').val(open_project[op].contact_id);
					objMainElement.find('input#leadOpenIntroOpenStatus').prop('checked',check);
					break;
					case 9:
					objMainElement.find('input#leadOpenComparablesOpenContact').val(_nameCombine);
					objMainElement.find('span#spnleadOpenComparablesOpenContact').attr('title',_nameCombine).text(_nameCombine);
					objMainElement.find('input#leadOpenComparablesContact').val(open_project[op].contact_id);
					objMainElement.find('input#leadOpenComparablesOpenStatus').prop('checked',check);
					break;					
					case 10:
					objMainElement.find('input#leadOpenPdfOpenContact').val(_nameCombine);
					objMainElement.find('span#spnleadOpenPdfOpenContact').attr('title',_nameCombine).text(_nameCombine);
					objMainElement.find('input#leadOpenPdfContact').val(open_project[op].contact_id);
					objMainElement.find('input#leadOpenPdfOpenStatus').prop('checked',check);
					break;
					case 11:
					objMainElement.find('input#leadOpenIntroimagesOpenContact').val(_nameCombine);
					objMainElement.find('span#spnleadOpenIntroimagesOpenContact').attr('title',_nameCombine).text(_nameCombine);
					objMainElement.find('input#leadOpenIntroimagesContact').val(open_project[op].contact_id);
					objMainElement.find('input#leadOpenIntroimagesOpenStatus').prop('checked',check);
					break;					
				}				
			}
		}
		_user = _data.detail[0].user_list;
		if(_user.length>0){
			try{
				_portfolioPerson = _data.detail[0].litigation.portfolio_person_name;
				jQuery.each(_user,function(i,u){
					_selected = '';
					if(jQuery.trim(_portfolioPerson)==jQuery.trim(u.name)){
						_selected= "SELECTED='SELECTED'";
					}
					objMainElement.find('select#userUser').append("<option value='"+u.id+"' "+_selected+">"+u.name+"</option>");
				});
			}catch(e){
				
			}
		}
		objMainElement.find('#marketLeadId').val(leadGlobal);
		if(objMainElement.find('#market_port_price').length>0){
			objMainElement.find('#market_port_price').val(_data.detail[0].litigation.port_price);
			objMainElement.find('#market_price').val(_data.detail[0].litigation.agreed_price);
			if(_data.detail[0].litigation.agreed_price>0){
				_rem = _data.detail[0].litigation.agreed_price - _data.detail[0].litigation.expected_price;
				objMainElement.find('#spnMarketRemainigP').val(_rem);
			}
		} else{
			console.log("Element not found!");
		}
		if(objMainElement.find('span#spnleadRequest').length>0){
			objMainElement.find('span#spnleadRequest').text(_data.detail[0].participants_data.request);
		}
		if(objMainElement.find('span#spnLeadMinPrice').length>0){
			_minPrice = parseFloat(_data.detail[0].participants_data.min_price);
			objMainElement.find('span#spnLeadMinPrice').text(_minPrice.toFixed(3));
		}
		if(objMainElement.find('span#spnleadParticipants').length>0){
			objMainElement.find('span#spnleadParticipants').text(_data.detail[0].participants_data.participants);
		}
		if(objMainElement.find('span#spnLeadRegular').length>0){
			objMainElement.find('span#spnLeadRegular').text(_data.detail[0].participants_data.regular);
		}
		if(objMainElement.find('span#spnLeadLate').length>0){
			objMainElement.find('span#spnLeadLate').text(_data.detail[0].participants_data.late);
		}
		objMainElement.find('span#spnleadOpenIllustrationPatent').attr('title',_data.detail[0].litigation.illustrationComplete).text(_data.detail[0].litigation.illustrationComplete);
		objMainElement.find('span#spnleadOpenTechnicalPatent').attr('title',_data.detail[0].litigation.techDDComplete).text(_data.detail[0].litigation.techDDComplete);
		objMainElement.find('span#spnleadOpenMarketPatent').attr('title',_data.detail[0].litigation.marketDDComplete).text(_data.detail[0].litigation.marketDDComplete);
		objMainElement.find('span#spnleadOpenLegalPatent').attr('title',_data.detail[0].litigation.legalDDComplete).text(_data.detail[0].litigation.legalDDComplete);
		objMainElement.find('span#spnleadOpenPdfPatent').attr('title',_data.detail[0].litigation.pdfDDComplete).text(_data.detail[0].litigation.pdfDDComplete);
		objMainElement.find('span#spnleadOpenComparablesPatent').attr('title',_data.detail[0].litigation.comparablesComplete).text(_data.detail[0].litigation.comparablesComplete);
		objMainElement.find('span#spnleadOpenInviteesPatent').attr('title',_data.detail[0].litigation.invitesComplete).text(_data.detail[0].litigation.invitesComplete);
		objMainElement.find('span#spnMarketProspects').attr('title',_data.detail[0].litigation.gateway).text(_data.detail[0].litigation.gateway);
		objMainElement.find('span#spnleadOpenIntroPatent').attr('title',_data.detail[0].litigation.imageComplete).text(_data.detail[0].litigation.imageComplete);
		objMainElement.find('span#spnleadOpenIntroComplete').attr('title',_data.detail[0].litigation.introAccordionComplete).text(_data.detail[0].litigation.introAccordionComplete);
		objMainElement.find('span#spnleadOpenRoyaltyOpenContactPatent').attr('title',_data.detail[0].litigation.royaltyComplete).text(_data.detail[0].litigation.royaltyComplete);
		objMainElement.find('span#spnleadOpenSellerPatent').attr('title',_data.detail[0].litigation.sellerdd).text(_data.detail[0].litigation.sellerdd);
		objMainElement.find('span#spnFamily').text(_data.detail[0].litigation.family);
		objMainElement.find('span#spnAssets').text(_data.detail[0].litigation.assets);
		objMainElement.find('span#spnJur').text(_data.detail[0].litigation.jurisdiction);
		if(_mainButtonParentElement=="from_regular"){
			objMainElement.find('div#marketBoxList').html(_data.detail[0].litigation.marketCategoriesString);
		}		
		for(bt=0;bt<_data.detail[0].buttons.length;bt++){
			_aC="";if(jQuery("#"+_mainButtonParentElement).find(".button-list").find("div.row").length>0){_aC="mrg5T"}
			_msg = _data.detail[0].buttons[bt].status_message_fill;
			_allStatus = _msg.split('<br/>');
			if(_allStatus[_allStatus.length-1]==''){
				_allStatus.splice(_allStatus.length-1,1);
			}
			_allStatus.join('<br/>');
			switch(_data.detail[0].buttons[bt].button_id){
			case "ALL":
				_statusMessage="";
				if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}
				_refrence=_data.detail[0].buttons[bt].reference_id;
				_driveRefrence=_data.detail[0].buttons[bt].drive_refrence_id;
				_email=_data.detail[0].buttons[bt].email;
				_task=_data.detail[0].buttons[bt].send_task;
				_blink=_data.detail[0].buttons[bt].blink;
				_title = _data.detail[0].buttons[bt].description;
				_clickMessage =_data.detail[0].buttons[bt].status_message_click;
				_statusMessage =_data.detail[0].buttons[bt].status_message;
				jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="all_button'+_data.detail[0].buttons[bt].id+'" title="'+_title+'"></div></div>');
				var _aLeadBtn = jQuery("<a/>");
				var _aFnEmbed = false;
				_aLeadBtn.addClass('btn btn-default btn-mwidth lead_button').attr('href','javascript://').html(_data.detail[0].buttons[bt].name).data('status',_data.detail[0].buttons[bt].status_message).data('status_click',_clickMessage).data('drive',_driveRefrence).data("reference",_refrence).data("email",_email).data("task",_task).data('parent_element',_mainButtonParentElement).data("id",_data.detail[0].buttons[bt].id).data("blink",_blink).data('title',_title).data('update',_data.detail[0].buttons[bt].lead_columns).data('message',_statusMessage);
				if(_data.detail[0].buttons[bt].btnStatus=="0" || _data.detail[0].buttons[bt].btnStatus=="2"){					
					_aLeadBtn.off("click").on("click",function(){
						globalFnLeadButton(jQuery(this));
					});
					_aFnEmbed = true;
					if(_data.detail[0].buttons[bt].btnStatus=="2"){
						if(_data.detail[0].buttons[bt].status_message_fill!=""){
							_aLeadBtn.html(_allStatus);
						} else {
							_aLeadBtn.html('<span class="date-style">'+moment(new Date(_data.detail[0].buttons[bt].update_date)).format("MM-D-YY")+"</span> "+_statusMessage);
						}
						jQuery("#"+_mainButtonParentElement).find("#all_button"+_data.detail[0].buttons[bt].id).addClass('staRenewalAction');
					}
				} else if(_data.detail[0].buttons[bt].blink==1 && _data.detail[0].buttons[bt].btnStatus=="1"){
						if(_data.detail[0].buttons[bt].status_message_fill!=""){
							_aLeadBtn.html(_allStatus);
						} else {
							_aLeadBtn.html('<span class="date-style">'+moment(new Date(_data.detail[0].buttons[bt].update_date)).format("MM-D-YY")+"</span> "+_statusMessage);
						}
						
						/**/
						_aLeadBtn.css('width','90%');
						jQuery("#"+_mainButtonParentElement).find("#all_button"+_data.detail[0].buttons[bt].id).append('<a style="width:10%;float:right;" href="javascript://" onclick="callRepeatAction('+_data.detail[0].buttons[bt].id+')">&nbsp;<i class="glyph-icon icon-repeat"></i></a>');
						_aLeadBtn.addClass("btn-blink").off("click").on("click",function(){
							console.log("Status Field CLose");
							updateButtonStatusToField(jQuery(this).data('id'));
						});
						_aFnEmbed = true;
					
				}
				if(_aFnEmbed===true){					
					jQuery("#"+_mainButtonParentElement).find("#all_button"+_data.detail[0].buttons[bt].id).append(_aLeadBtn).append('<div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>');
				}
			break;case "DRIVE":_statusMessage="";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}_refrence=_data.detail[0].buttons[bt].reference_id;jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="drive_button'+_data.detail[0].buttons[bt].id+'"></div></div>');
			if(_data.detail[0].buttons[bt].btnStatus=="0"||_data.detail[0].buttons[bt].renewable=="1"){
				jQuery("#"+_mainButtonParentElement).find("#drive_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-update="'+_data.detail[0].buttons[bt].lead_columns+'" data-status="'+_data.detail[0].buttons[bt].status_message+'" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="driveMode('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"','"+_refrence+"',"+_data.detail[0].buttons[bt].send_task+",jQuery(this));\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>');
			}else{
				if(_data.detail[0].buttons[bt].blink==1){
					jQuery("#"+_mainButtonParentElement).find("#drive_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth btn-blink " data-update="'+_data.detail[0].buttons[bt].lead_columns+'" data-status="'+_data.detail[0].buttons[bt].status_message+'" title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="btnModeStatus('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>');
				} else {
					if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#drive_button"+_data.detail[0].buttons[bt].id).addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{jQuery("#"+_mainButtonParentElement).find("#drive_button"+_data.detail[0].buttons[bt].id).addClass("staRenewalAction").html('<span class="date-style">'+moment(new Date(_data.detail[0].buttons[bt].update_date)).format("MM-D-YY")+"</span> "+_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}}
			}
			break;
			case "EMAIL":
			_statusMessage="";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}_refrence=_data.detail[0].buttons[bt].reference_id;jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="email_button'+_data.detail[0].buttons[bt].id+'"></div></div>');
			if(_data.detail[0].buttons[bt].btnStatus=="0"||_data.detail[0].buttons[bt].renewable=="1"){jQuery("#"+_mainButtonParentElement).find("#email_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-update="'+_data.detail[0].buttons[bt].lead_columns+'" data-status="'+_data.detail[0].buttons[bt].status_message+'" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="emailMode('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"','"+_refrence+"',jQuery(this));\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
			}else{
				if(_data.detail[0].buttons[bt].blink==1){
					jQuery("#"+_mainButtonParentElement).find("#email_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth btn-blink lead_button" data-status="'+_data.detail[0].buttons[bt].status_message+'" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" data-update="'+_data.detail[0].buttons[bt].lead_columns+'" onclick="btnModeStatus('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>');
				} else {
					if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#email_button"+_data.detail[0].buttons[bt].id).addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{jQuery("#"+_mainButtonParentElement).find("#email_button"+_data.detail[0].buttons[bt].id).addClass("staRenewalAction").html('<span class="date-style">'+moment(new Date(_data.detail[0].buttons[bt].update_date)).format("MM-D-YY")+"</span> "+_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}
				}												
			}
			break;
			case "TASK":
			_statusMessage="";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}_refrence=_data.detail[0].buttons[bt].reference_id;jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="task_button'+_data.detail[0].buttons[bt].id+'"></div></div>');
			if(_data.detail[0].buttons[bt].btnStatus=="0"||_data.detail[0].buttons[bt].renewable=="1"){jQuery("#"+_mainButtonParentElement).find("#task_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-update="'+_data.detail[0].buttons[bt].lead_columns+'" data-status="'+_data.detail[0].buttons[bt].status_message+'" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="taskMode('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"','"+_refrence+"',jQuery(this));\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
			}else{
				if(_data.detail[0].buttons[bt].blink==1){
					jQuery("#"+_mainButtonParentElement).find("#task_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth btn-blink lead_button" data-update="'+_data.detail[0].buttons[bt].lead_columns+'" data-status="'+_data.detail[0].buttons[bt].status_message+'" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="btnModeStatus('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>');
				} else {
					if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#task_button"+_data.detail[0].buttons[bt].id).addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>');
					}else{
						jQuery("#"+_mainButtonParentElement).find("#task_button"+_data.detail[0].buttons[bt].id).addClass("staRenewalAction").html('<span class="date-style">'+moment(new Date(_data.detail[0].buttons[bt].update_date)).format("MM-D-YY")+"</span> "+_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>');
					}
				}												
			}
			break;
			case "SELLER":
			_statusMessage="Seller Info Done";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="assign_task_market"></div></div>');if(_data.detail[0].litigation.seller_info==1){jQuery("#"+_mainButtonParentElement).find("#assign_task_market").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth btn-blink lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="assign_task_mode(2,\''+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_seller_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
			}else{
				if(_data.detail[0].litigation.seller_info==2){if(_data.detail[0].litigation.seller_info_text=="0000-00-00 00:00:00"||_data.detail[0].litigation.seller_info_text==null){jQuery("#"+_mainButtonParentElement).find("#assign_task_market").html(_statusMessage)}else{jQuery("#"+_mainButtonParentElement).find("#assign_task_market").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.seller_info_text)).format("MM-D-YY")+"</span> "+_statusMessage);}
				}else{
					if(_data.detail[0].litigation.seller_info==0){jQuery("#"+_mainButtonParentElement).find("#assign_task_market").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="assign_task_mode(1,\''+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_seller_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')}
				}
			}
			break;
			case "SELLER_IS_INTERSTED":_statusMessage="Seller like the deal";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="seller_deal_for_market"></div></div>');if(_data.detail[0].litigation.seller_like!=""&&_data.detail[0].litigation.seller_like!=null){jQuery("#"+_mainButtonParentElement).find("#seller_deal_for_market").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.seller_like)).format("MM-D-YY")+"</span> "+_statusMessage)}else{jQuery("#"+_mainButtonParentElement).find("#seller_deal_for_market").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="sellerInterested(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_seller_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')}
			break;
			case "FUNDING":_statusMessage="Funding Successful";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="funding_successful"></div></div>');if(_data.detail[0].litigation.funding_trnsfr!=""&&_data.detail[0].litigation.funding_trnsfr!=null){jQuery("#"+_mainButtonParentElement).find("#funding_successful").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.funding_trnsfr)).format("MM-D-YY")+"</span> "+_statusMessage)}else{jQuery("#"+_mainButtonParentElement).find("#funding_successful").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="fundingTransfer(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_funding_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')}
			break;
			case "CLAIM_ILLUS":_statusMessage="Claim Illustration done";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}if(_data.detail[0].litigation.claim_illus!=null){_statusMessage='<span class="date-style">'+moment(new Date(_data.detail[0].litigation.claim_illus)).format("MM-D-YY")+"</span> "+_statusMessage}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="claim_illus"></div></div>');
			if(_data.detail[0].buttons[bt].btnStatus=="1") {
				if(_data.detail[0].buttons[bt].blink=="1") {
					jQuery("#"+_mainButtonParentElement).find("#claim_illus").removeClass("btn").removeClass("btn-mwidth").addClass("btn-blink");
				}
				var btnHTML = "";
				var btnCWidth = "100%";
				if(_data.detail[0].buttons[bt].renewable=="1") {
					btnCWidth = "90%";
				}
				btnHTML = '<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" data-tp="0" style="width:'+btnCWidth+'" href="javascript://" onclick="claimIllusStatusChange(\''+_mainButtonParentElement+"')\" >"+_statusMessage+'</a>';
				if(_data.detail[0].buttons[bt].renewable=="1") {
					btnHTML += '&nbsp;<a style="width:7%;float:right;" href="javascript://" onclick="callRepeatAction('+_data.detail[0].buttons[bt].id+')">&nbsp;<i class="glyph-icon icon-repeat"></i></a> ';
				}
				btnHTML += '<div id="loader_claim_illus_dd_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>';
				jQuery("#"+_mainButtonParentElement).find("#claim_illus").html(btnHTML);
			} else{
				if(_data.detail[0].buttons[bt].btnStatus=="2"){
					jQuery("#"+_mainButtonParentElement).find("#claim_illus").find('a').removeAttr('onclick');
					if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#claim_illus").addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{jQuery("#"+_mainButtonParentElement).find("#claim_illus").removeClass("btn-blink").html(_statusMessage)}
				}else{jQuery("#"+_mainButtonParentElement).find("#claim_illus").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="claimIllus(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_claim_illus_dd_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')}
			}
			break;
			case "TECHNICAL_DD":_statusMessage="Techinical Due Dilligence Done";
			if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}if(_data.detail[0].litigation.technical_dd!=null){_statusMessage="<span class='date-style'>"+moment(new Date(_data.detail[0].litigation.technical_dd)).format("MM-D-YY")+"</span> "+_statusMessage}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="technical_dd"></div></div>');
			if(_data.detail[0].litigation.technical_status_dd=="1"&&_data.detail[0].buttons[bt].renewable=="0"){jQuery("#"+_mainButtonParentElement).find("#technical_dd").removeClass("btn").removeClass("btn-mwidth").addClass("btn-blink").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="technicalStatusChange(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_technical_dd_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
			}else{
				if(_data.detail[0].litigation.technical_status_dd=="2"&&_data.detail[0].buttons[bt].renewable=="0"){if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#technical_dd").addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{jQuery("#"+_mainButtonParentElement).find("#technical_dd").addClass("staRenewalAction").removeClass("btn-blink").html(_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}
				}else{jQuery("#"+_mainButtonParentElement).find("#technical_dd").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="technicalDD(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_technical_dd_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')}
			}
			break;
			case "LEGAL_DD":_statusMessage="Legal Due Dilligence Done";
			if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}if(_data.detail[0].litigation.legal_dd!=null){_statusMessage='<span class="date-style">'+moment(new Date(_data.detail[0].litigation.legal_dd)).format("MM-D-YY")+"</span> "+_statusMessage}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="legal_dd"></div></div>');
			if(_data.detail[0].litigation.legal_status_dd=="1"&&_data.detail[0].buttons[bt].renewable=="0"){jQuery("#"+_mainButtonParentElement).find("#legal_dd").removeClass("btn").removeClass("btn-mwidth").addClass("btn-blink").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="legalStatusChange(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_legal_dd_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
			}else{
				if(_data.detail[0].litigation.legal_status_dd=="2"&&_data.detail[0].buttons[bt].renewable=="0"){if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#legal_dd").addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{jQuery("#"+_mainButtonParentElement).find("#legal_dd").addClass("staRenewalAction").removeClass("btn-blink").html(_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}
				}else{jQuery("#"+_mainButtonParentElement).find("#legal_dd").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="legalDD(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_legal_dd_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
				}
			}
			break;
			case"PROPOSAL":break;
			case "OUTSOURCE":
				_statusMessage="Project Outsourced";
				if(_data.detail[0].buttons[bt].status_message!=""){
					_statusMessage=_data.detail[0].buttons[bt].status_message;
				}
				jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="outsource_project"></div></div>');
				if(_data.detail[0].buttons[bt].status_message_fill!=""){
					jQuery("#"+_mainButtonParentElement).find("#outsource_project").addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>');
				}
				jQuery("#"+_mainButtonParentElement).find("#outsource_project").append('<a class="btn btn-default renewable btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="outsource_project(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_outsource_project" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>');
			break;
			case"PATENT_LIST":
				_statusMessage="Patent Spreadsheet created";
				if(_data.detail[0].buttons[bt].status_message!=""){
					_statusMessage=_data.detail[0].buttons[bt].status_message
				}
				jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="create_patent_list_market"></div></div>');
				if(_data.detail[0].litigation.create_patent_list==1&&_data.detail[0].buttons[bt].renewable=="0"){
						jQuery("#"+_mainButtonParentElement).find("#create_patent_list_market").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth btn-blink lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="spreadsheet_box_mode(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_patent_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
				}else{
					if(_data.detail[0].litigation.create_patent_list==2&&_data.detail[0].buttons[bt].renewable=="0"){
						if(_data.detail[0].buttons[bt].status_message_fill!=""){					
							jQuery("#"+_mainButtonParentElement).find("#create_patent_list_market").addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>');
						}else{
							if(_data.detail[0].litigation.create_patent_list_text==null||_data.detail[0].litigation.create_patent_list_text=="0000-00-00 00:00:00"){
								jQuery("#"+_mainButtonParentElement).find("#create_patent_list_market").addClass("staRenewalAction").removeClass("btn").removeClass("btn-mwidth").html(_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')
							}else{
								jQuery("#"+_mainButtonParentElement).find("#create_patent_list_market").removeClass("btn").removeClass("btn-mwidth").addClass("staRenewalAction").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.create_patent_list_text)).format("MM-D-YY")+"</span> "+_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>');
							}
						}
					}else{
						if(_data.detail[0].litigation.create_patent_list==0||_data.detail[0].buttons[bt].renewable=="1"){
							jQuery("#"+_mainButtonParentElement).find("#create_patent_list_market").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default renewable btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="spreadsheet_box_mode(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_patent_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
						}
					}
				}
			break;
			case "REVIEW":
				_statusMessage="Review";
				if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="forward_to_review_market"></div></div>');
				if(_data.detail[0].litigation.complete==1||_data.detail[0].litigation.complete==2){if(_data.detail[0].litigation.forward_to_review_text=="0000-00-00 00:00:00"||_data.detail[0].litigation.forward_to_review_text==null){jQuery("#"+_mainButtonParentElement).find("#forward_to_review_market").html(_statusMessage)}else{jQuery("#"+_mainButtonParentElement).find("#forward_to_review_market").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.forward_to_review_text)).format("MM-D-YY")+"</span> "+_statusMessage);}
				}else{jQuery("#"+_mainButtonParentElement).find("#forward_to_review_market").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" onclick="forward_to_review_mode(\''+_mainButtonParentElement+'\')" href="javascript://">'+_data.detail[0].buttons[bt].name+'</a><div id="loader_review_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
				}
			break;
			case"SCHEDULE":break;
			case"NDA_TERMSHEET":_statusMessage="NDA and TermSheet created";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="ndaTermSheetMarket"></div></div>');if(_data.detail[0].litigation.nda_term_sheet==1&&_data.detail[0].buttons[bt].renewable=="0"){if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#ndaTermSheetMarket").addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{if(_data.detail[0].litigation.nda_term_sheet_text=="0000-00-00 00:00:00"||_data.detail[0].litigation.nda_term_sheet_text==null){jQuery("#"+_mainButtonParentElement).find("#ndaTermSheetMarket").addClass("staRenewalAction").html(_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{jQuery("#"+_mainButtonParentElement).find("#ndaTermSheetMarket").addClass("staRenewalAction").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.nda_term_sheet_text)).format("MM-D-YY")+"</span> "+_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>');}}}else{if(_data.detail[0].litigation.nda_term_sheet==2&&_data.detail[0].buttons[bt].renewable=="0"){if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#ndaTermSheetMarket").addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{if(_data.detail[0].litigation.nda_term_sheet_text=="0000-00-00 00:00:00"||_data.detail[0].litigation.nda_term_sheet_text==null){jQuery("#"+_mainButtonParentElement).find("#ndaTermSheetMarket").addClass("staRenewalAction").html(_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{jQuery("#"+_mainButtonParentElement).find("#ndaTermSheetMarket").addClass("staRenewalAction").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.nda_term_sheet_text)).format("MM-D-YY")+"</span> "+_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>');}}}else{if(_data.detail[0].litigation.nda_term_sheet==0||_data.detail[0].buttons[bt].renewable=="1"){jQuery("#"+_mainButtonParentElement).find("#ndaTermSheetMarket").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript:void(0);" onclick="createPartNDATermsheetMode(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_NDA_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')}}}
			break;
			case"APPROVED_LEAD":
			_statusMessage="Synpat like the deal";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="approved_lead"></div></div>');if(_data.detail[0].litigation.status==1||_data.detail[0].litigation.status==2){jQuery("#"+_mainButtonParentElement).find("#approved_lead").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.synpat_like)).format("MM-D-YY")+"</span> "+_statusMessage);}else{jQuery("#"+_mainButtonParentElement).find("#approved_lead").removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript:void(0);" onclick="approvedLead(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_approved_lead" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')}
			break;
			case"EXECUTE_NDA":
			_nda_execute='';
			_statusMessage="NDA Executed successfully by CIPO";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="execute_nda"></div></div>');if(typeof(_data.detail[0].report)!="undefined"&&typeof(_data.detail[0].report.id)!="undefined"){if(_data.detail[0].report.executed_nda==0){jQuery("#"+_mainButtonParentElement).find("#execute_nda").html('<a class="btn btn-default btn-mwidth lead_button" href="javascript:void(0);" data-title="'+_data.detail[0].buttons[bt].description+'" onclick="executeNDA(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_execute_nda" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Executing NDA" style="color:#222222;"></div>')}else{if(_data.detail[0].report.executed_nda==1){jQuery("#"+_mainButtonParentElement).find("#execute_nda").html('<span class="date-style">'+moment(new Date(_nda_execute)).format("MM-D-YY")+"</span> Waiting for Admin to execute NDA"); }else{if(_data.detail[0].report.executed_nda==2&&_data.detail[0].report.nda_execute==0){jQuery("#"+_mainButtonParentElement).find("#execute_nda").html('<span class="date-style">'+moment(new Date(_send_req_nda_approval)).format("MM-D-YY")+"</span> Waiting for CIPO to execute NDA")}else{if(_data.detail[0].report.executed_nda==2&&_data.detail[0].report.nda_execute==2){jQuery("#"+_mainButtonParentElement).find("#execute_nda").html('<span class="date-style">'+moment(new Date(_nda_approved)).format("MM-D-YY")+"</span> "+_statusMessage);}}}}}else{jQuery("#"+_mainButtonParentElement).find("#execute_nda").html('<a class="btn btn-default btn-mwidth" href="javascript:void(0);" title="'+_data.detail[0].buttons[bt].description+'" onclick="executeNDA(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_execute_nda" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Executing NDA" style="color:#222222;"></div>')}
			break;
			case"EOU":
			_statusMessage="Seller EOU is in the Lead folder";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="seller_rou"></div></div>');if(typeof(_data.detail[0].report)!="undefined"&&typeof(_data.detail[0].report.id)!="undefined"){if(_data.detail[0].report.eou_folder==0){jQuery("#"+_mainButtonParentElement).find("#seller_rou").html('<a class="btn btn-default btn-mwidth lead_button" href="javascript:void(0);" data-title="'+_data.detail[0].buttons[bt].description+'" onclick="eouConfirmation(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_seller_eou" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Seller eou" style="color:#222222;"></div>')}else{if(_data.detail[0].report.eou_folder==2){if(typeof(_eou_confirmed)!="undefined"){jQuery("#"+_mainButtonParentElement).find("#seller_rou").html('<span class="date-style">'+moment(new Date(_eou_confirmed)).format("MM-D-YY")+"</span> "+_statusMessage);}else{jQuery("#"+_mainButtonParentElement).find("#seller_rou").html(_statusMessage)}}}}else{jQuery("#"+_mainButtonParentElement).find("#seller_rou").html('<a class="btn btn-default btn-mwidth lead_button" href="javascript:void(0);" data-title="'+_data.detail[0].buttons[bt].description+'" onclick="eouConfirmation(\''+_mainButtonParentElement+'\')">Seller\'s EOU in Folder</a><div id="loader_seller_eou" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Seller eou" style="color:#222222;"></div>')}
			break;
			case "DRAFT_PPA":
			_statusMessage="PPA has been successfully drafted";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="draft_a_ppa"></div></div>');if((typeof(_data.detail[0].report)!="undefined"&&typeof(_data.detail[0].report.id)!="undefined")||_data.detail[0].litigation.ppa_id!=""&&_data.detail[0].buttons[bt].renewable=="0"){if(_data.detail[0].litigation.ppa_id!=""){jQuery("#"+_mainButtonParentElement).find("#draft_a_ppa").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.ppa_text_date)).format("MM-D-YY")+"</span> "+_statusMessage);}else{if(_data.detail[0].report.draft_a_ppa==0||_data.detail[0].buttons[bt].renewable=="1"){jQuery("#"+_mainButtonParentElement).find("#draft_a_ppa").html('<a class="btn btn-default btn-mwidth lead_button renewable" href="javascript:void(0);" data-title="'+_data.detail[0].buttons[bt].description+'" onclick="draft_a_ppa(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_ppa" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Drafting PPA" style="color:#222222;"></div>')}else{if(_data.detail[0].report.draft_a_ppa==2&&_data.detail[0].buttons[bt].renewable=="0"){if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#draft_a_ppa").addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{if(typeof(_draft_ppa_date)!="undefined"){jQuery("#"+_mainButtonParentElement).find("#draft_a_ppa").addClass("staRenewalAction").html('<span class="date-style">'+moment(new Date(_draft_ppa_date)).format("MM-D-YY")+"</span> "+_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>');}else{jQuery("#"+_mainButtonParentElement).find("#draft_a_ppa").addClass("staRenewalAction").html(_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}}}}}}else{jQuery("#"+_mainButtonParentElement).find("#draft_a_ppa").html('<a class="btn btn-default btn-mwidth renewable lead_button" href="javascript:void(0);" data-title="'+_data.detail[0].buttons[bt].description+'" onclick="draft_a_ppa(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_ppa" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Drafting PPA" style="color:#222222;"></div>')}
			break;
			case "EXECUTE_PPA":
			_statusMessage="PPA has successfully executed";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="execute_a_ppa"></div></div>');if((typeof(_data.detail[0].report)!="undefined"&&typeof(_data.detail[0].report.id)!="undefined")||_data.detail[0].litigation.execute_ppa!="0"){if(_data.detail[0].litigation.execute_ppa!="0"){if(typeof(_executed_ppa)!="undefined"){jQuery("#"+_mainButtonParentElement).find("#execute_a_ppa").html('<span class="date-style">'+moment(new Date(_executed_ppa)).format("MM-D-YY")+"</span> "+_statusMessage);}else{jQuery("#"+_mainButtonParentElement).find("#execute_a_ppa").html(_statusMessage)}}else{if(_data.detail[0].report.execute_ppa==0){jQuery("#"+_mainButtonParentElement).find("#execute_a_ppa").html('<a class="btn btn-default btn-mwidth lead_button" href="javascript:void(0);" data-title="'+_data.detail[0].buttons[bt].description+'" onclick="execute_ppa(\''+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="spinner-loader-execute_ppa" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Execute a PPA" style="color:#222222;"></div>')}else{if(_data.detail[0].report.execute_ppa==1){jQuery("#"+_mainButtonParentElement).find("#execute_a_ppa").html('<p class="label-after-btn is-blink"><i class="glyph-icon icon-caret-right"></i> <span>Waiting for CEO for execute PPA</span></p>')}else{if(_data.detail[0].report.execute_ppa>1&&(_data.detail[0].report.execute_ppa==2||_data.detail[0].report.execute_ppa==3)){if(typeof(_executed_ppa)!="undefined"){jQuery("#"+_mainButtonParentElement).find("#execute_a_ppa").html('<span class="date-style">'+moment(new Date(_executed_ppa)).format("MM-D-YY")+"</span> "+_statusMessage);}else{jQuery("#"+_mainButtonParentElement).find("#execute_a_ppa").html(_statusMessage);}}}}}}else{jQuery("#"+_mainButtonParentElement).find("#execute_a_ppa").html('<a class="btn btn-default btn-mwidth lead_button" href="javascript:void(0);" data-title="'+_data.detail[0].buttons[bt].description+'" onclick="execute_ppa(\''+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="spinner-loader-execute_ppa" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Execute a PPA" style="color:#222222;"></div>')}
			break;
			case "PPA_EXECUTE":
			_statusMessage="PPA has successfully executed by CEO";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="ppa_execute"></div></div>');if((typeof(_data.detail[0].report)!="undefined"&&typeof(_data.detail[0].report.id)!="undefined")||_data.detail[0].litigation.ppa_execute!="0"){if(_data.detail[0].litigation.ppa_execute!="0"){jQuery("#"+_mainButtonParentElement).find("#ppa_execute").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.ppa_date)).format("MM-D-YY")+"</span> "+_statusMessage);}else{if(typeof(_data.detail[0].report)!="undefined"){if(_data.detail[0].report.execute_ppa==2||_data.detail[0].report.execute_ppa==1){jQuery("#"+_mainButtonParentElement).find("#ppa_execute").html('<a class="btn btn-default btn-mwidth lead_button" href="javascript:void(0);" data-title="'+_data.detail[0].buttons[bt].description+'" onclick="ppaExecuted(\''+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="spinner-loader-ppa_executed" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide"  data-original-title="PPA Executed" style="color:#222222;"></div>')}else{if(_data.detail[0].report.execute_ppa==3){jQuery("#"+_mainButtonParentElement).find("#ppa_execute").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.ppa_date)).format("MM-D-YY")+"</span> "+_statusMessage);}}}else{jQuery("#"+_mainButtonParentElement).find("#ppa_execute").html('<a class="btn btn-default btn-mwidth lead_button" href="javascript:void(0);" data-title="'+_data.detail[0].buttons[bt].description+'" onclick="ppaExecuted(\''+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="spinner-loader-ppa_executed" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="PPA Executed" style="color:#222222;"></div>')}}}else{jQuery("#"+_mainButtonParentElement).find("#ppa_execute").html('<a class="btn btn-default btn-mwidth" href="javascript:void(0);" title="'+_data.detail[0].buttons[bt].description+'" onclick="ppaExecuted(\'from_regular\');">'+_data.detail[0].buttons[bt].name+'</a><div id="spinner-loader-ppa_executed" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="PPA Executed" style="color:#222222;"></div>')}
			break;
		}
		}
		enableActionRightAgain();
		<?php endif; ?> 
		var expirationDate = _data.detail[0].litigation.option_expiration_date;
			if(expirationDate != "" && expirationDate != '0000-00-00' && expirationDate != null){
				expirationDate = moment(new Date(expirationDate)).format('MM/DD/YYYY');
			}
		var closingDate = _data.detail[0].acquisitions.closing_date;
			if(closingDate != "" && closingDate != '0000-00-00' && closingDate != null){
				closingDate = moment(new Date(closingDate)).format('MM/DD/YYYY');
			}
		if(_data.detail[0].litigation.type!="Litigation"&&_data.detail[0].litigation.type!="NON"&&_data.detail[0].litigation.type!="INT"&&jQuery("#marketOwner").length>0){
		<?php if($openLeadDT===true):?>var sellerContactID = _data.detail[0].litigation.seller_contact_id;if(sellerContactID!= ""){if(parseInt(sellerContactID) == 0){sellerContactID = _data.detail[0].litigation.plantiffs_name}} else {sellerContactID = _data.detail[0].litigation.plantiffs_name}
			jQuery("#marketOwner").val(_data.detail[0].litigation.plantiffs_name);jQuery("#marketProspects").val(_data.detail[0].litigation.no_of_prospects);jQuery("#marketExpectedPrice").val(_data.detail[0].litigation.upfront_price);jQuery("#marketProspectsName").val(_data.detail[0].litigation.prospects_name);jQuery("#marketlead_name").val(_data.detail[0].litigation.lead_name);jQuery("#marketTechnologies").val(_data.detail[0].litigation.technologies);jQuery("#marketNo_of_us_patents").val(_data.detail[0].litigation.no_of_us_patents);jQuery("#marketno_of_non_us_patents").val(_data.detail[0].litigation.no_of_non_us_patents);jQuery("#marketFileUrl").val(_data.detail[0].litigation.file_url);jQuery("#marketSellerInfo").val(_data.detail[0].litigation.seller_info);jQuery("#marketProposal_letter").val(_data.detail[0].litigation.send_proposal_letter);jQuery("#marketCreate_patent_list").val(_data.detail[0].litigation.create_patent_list);if(_data.detail[0].litigation.complete==1){if(_data.detail[0].litigation.forward_to_review_text=="0000-00-00 00:00:00"||_data.detail[0].litigation.create_patent_list_text==null){jQuery("#forward_to_review").html(" Review")}else{jQuery("#forward_to_review").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.forward_to_review_text)).format("MM-D-YY")+"</span> Review")}}_mainValue=_data.detail[0].litigation.market_data;jQuery("#marketMarketData").val(_mainValue);if(_mainValue!=""){marketData=_mainValue.split(",");if(marketData.length>0){$("#marketBoxList").empty();$("#marketBoxList").append("<ul class='todo-box-1'></ul>");for(mk=0;mk<marketData.length;mk++){$("#marketBoxList").find("ul.todo-box-1").append("<li>"+marketData[mk]+"</li>")}}}jQuery("#showSellerName").html(_data.detail[0].litigation.seller_contact);jQuery("#from_regular").find("#spnleadOpenSellerCompanyContact").html("<a href='javascript://' onclick='openCompanyEdit("+sellerContactID+");'>"+_data.detail[0].litigation.seller_contact+"<a/>");jQuery("#marketSellerContact").val(_data.detail[0].litigation.seller_contact);jQuery("#from_regular").find("#marketSellerContactID").val(sellerContactID);jQuery("#marketOwner").val(_data.detail[0].litigation.plantiffs_name);jQuery("#sellerBtn").attr("onclick","openContactForFrom(1,'from_regular');");jQuery("#showBrokerFirm").html(_data.detail[0].litigation.broker_contact);jQuery("#optionExpirationDate").val(expirationDate);jQuery("#docketClosingDate").val(closingDate);jQuery("#marketBrokerContact").val(_data.detail[0].litigation.broker_contact);jQuery("#marketBroker").val(_data.detail[0].litigation.broker);_brokerNameCompany = ''; if(_data.detail[0].litigation.broker_person_contact!=''){_brokerNameCompany = _data.detail[0].litigation.broker_person_contact+', ';}if(_data.detail[0].litigation.broker_contact!=''){_brokerNameCompany+=_data.detail[0].litigation.broker_contact;}jQuery("#brokerFirmBtn").attr("onclick","openContactForFrom(2,'from_regular');");_showBroker="";if(_data.detail[0].litigation.broker_person>0){_showBroker +="<a href='javascript://'  onclick='editContact("+_data.detail[0].litigation.broker_person+")'>"+_data.detail[0].litigation.broker_person_contact+", </a>";}if(_data.detail[0].litigation.broker_company>0){_showBroker +="<a href='javascript://' onclick='openCompanyEdit("+_data.detail[0].litigation.broker_company+")'>"+_data.detail[0].litigation.broker_contact+"</a>";}jQuery("#showBrokerPerson").html(_showBroker);jQuery("#marketBrokerPersonContact").val(1);jQuery("#marketBrokerPerson").val(_data.detail[0].litigation.broker_person);jQuery("#brokerPersonBtn").attr("onclick","openContactForFrom(3,'from_regular');");jQuery("#showNameFirst").html(_data.detail[0].litigation.person_name_1);jQuery("#marketPersonName1").val(_data.detail[0].litigation.person_name_1);jQuery("#marketPersonTitle1").val(_data.detail[0].litigation.person_title_1);jQuery("#showNameBtn").attr("onclick","openContactForFrom(4,'from_regular');");jQuery("#showNameSecond").html(_data.detail[0].litigation.person_name_2);jQuery("#marketPersonName2").val(_data.detail[0].litigation.person_name_2);jQuery("#marketPersonTitle2").val(_data.detail[0].litigation.person_title_2);jQuery("#showNameSecondBtn").attr("onclick","openContactForFrom(5,'from_regular');");jQuery("#from_regular").find("#marketComplete").val(_data.detail[0].litigation.complete);jQuery("#marketAddress").val(_data.detail[0].litigation.address);jQuery("#from_regular").find("#taskLeadId").val(_data.detail[0].litigation.id);jQuery("#marketLeadId").val(_data.detail[0].litigation.id);jQuery("#marketPersonName1").val(_data.detail[0].litigation.person_name_1);jQuery("#marketRelatesTo").val(_data.detail[0].litigation.relates_to);jQuery("#marketupfront_price").val(_data.detail[0].litigation.expected_price);
			jQuery("#marketupfront_price").val(_data.detail[0].litigation.expected_price);
			<?php endif;?>
			_regularObject = jQuery("#from_regular");
			_regularObject.find("#litigation_doc_list").empty();
			jQuery("#scrap_patent_data").find("tbody").empty();
			<?php if($openLeadDT===true):?>
			_regularObject.find("#litigation_doc_list").addClass("docDropable").append("<ul class='todo-box-1 ' data-id='"+_data.detail[0].litigation.id+"'></ul>");
			fillPatentSheetListMode(_data.detail[0].litigation.folder_id);
			jQuery("#marketPatentData").val(_data.detail[0].litigation.patent_data);<?php endif;?>
		}else{
			if((_data.detail[0].litigation.type=="NON"||_data.detail[0].litigation.type=="INT")&&jQuery("#acquisitionOwner").length>0){
				_acquisitionObject = jQuery("#from_nonacquistion");
				<?php if($openLeadDT===true):?>
				jQuery("#acquisitionOwner").val(_data.detail[0].litigation.plantiffs_name);jQuery("#acquisitionProspects").val(_data.detail[0].litigation.no_of_prospects);jQuery("#acquisitionExpectedPrice").val(_data.detail[0].litigation.upfront_price);jQuery("#acquisitionProspectsName").val(_data.detail[0].litigation.prospects_name);jQuery("#acquisitionlead_name").val(_data.detail[0].litigation.lead_name);jQuery("#acquisitionTechnologies").val(_data.detail[0].litigation.technologies);jQuery("#acquisitionNo_of_us_patents").val(_data.detail[0].litigation.no_of_us_patents);jQuery("#acquisitionno_of_non_us_patents").val(_data.detail[0].litigation.no_of_non_us_patents);jQuery("#acquisitionFileUrl").val(_data.detail[0].litigation.file_url);jQuery("#acquisitionSellerInfo").val(_data.detail[0].litigation.seller_info);jQuery("#acquisitionProposal_letter").val(_data.detail[0].litigation.send_proposal_letter);jQuery("#acquisitionCreate_patent_list").val(_data.detail[0].litigation.create_patent_list);jQuery("#acquisitionType").val(_data.detail[0].litigation.type);jQuery("#acquisitionCreateDate").val(moment(new Date(_data.detail[0].litigation.create_date)).format("YYYY-MM-DD"));_update="";if(_data.detail[0].litigation.update_date!=""&&_data.detail[0].litigation.update_date!="0000-00-00 00:00:00"){_update=moment(new Date(_data.detail[0].litigation.update_date)).format("YYYY-MM-DD")}jQuery("#acquisitionUpdateDate").val(_update);_nextAction="";if(_data.detail[0].litigation.next_action!=""&&_data.detail[0].litigation.next_action!="0000-00-00 00:00:00"){_nextAction=moment(new Date(_data.detail[0].litigation.next_action)).format("YYYY-MM-DD")}jQuery("#acquisitionNextAction").val(_nextAction);if(_data.detail[0].litigation.complete==1){if(_data.detail[0].litigation.forward_to_review_text=="0000-00-00 00:00:00"||_data.detail[0].litigation.create_patent_list_text==null){jQuery("#forward_to_review").html(" Review")}else{jQuery("#forward_to_review").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.forward_to_review_text)).format("MM-D-YY")+"</span> Review")}}_mainValue=_data.detail[0].litigation.market_data;jQuery("#acquisitionMarketData").val(_mainValue);if(_mainValue!=""){marketData=_mainValue.split(",");if(marketData.length>0){$("#acquisitionBoxList").empty();$("#acquisitionBoxList").append("<ul class='todo-box-1'></ul>");for(mk=0;mk<marketData.length;mk++){$("#acquisitionBoxList").find("ul.todo-box-1").append("<li>"+marketData[mk]+"</li>")}}};var sellerContactID = _data.detail[0].litigation.seller_contact_id;if(sellerContactID!= ""){if(parseInt(sellerContactID) == 0){sellerContactID = _data.detail[0].litigation.plantiffs_name}} else {sellerContactID = _data.detail[0].litigation.plantiffs_name}_acquisitionObject.find("#acquisitionSellerContactID").val(sellerContactID);_acquisitionObject.find("#showSellerName").html(_data.detail[0].litigation.seller_contact);_acquisitionObject.find("#spnleadOpenSellerCompanyContact").html("<a href='javascript://' onclick='openCompanyEdit("+sellerContactID+");'>"+_data.detail[0].litigation.seller_contact+"<a/>");jQuery("#acquisitionSellerContact").val(_data.detail[0].litigation.seller_contact);_acquisitionObject.find("#sellerBtn").attr("onclick","openContactForFrom(1,'from_nonacquistion');");_acquisitionObject.find("#showBrokerFirm").html(_data.detail[0].litigation.broker_contact);jQuery("#acquisitionBrokerContact").val(_data.detail[0].litigation.broker_contact);jQuery("#acquisitionBroker").val(_data.detail[0].litigation.broker);_acquisitionObject.find("#brokerFirmBtn").attr("onclick","openContactForFrom(2,'from_nonacquistion');");_showBroker="";if(_data.detail[0].litigation.broker_person>0){_showBroker +="<a href='javascript://'  onclick='editContact("+_data.detail[0].litigation.broker_person+")'>"+_data.detail[0].litigation.broker_person_contact+", </a>";}if(_data.detail[0].litigation.broker_company>0){_showBroker +="<a href='javascript://' onclick='openCompanyEdit("+_data.detail[0].litigation.broker_company+")'>"+_data.detail[0].litigation.broker_contact+"</a>";}_acquisitionObject.find("#showBrokerPerson").html(_showBroker);jQuery("#acquisitionBrokerPersonContact").val(_data.detail[0].litigation.broker_person_contact);jQuery("#acquisitionBrokerPerson").val(_data.detail[0].litigation.broker_person);_acquisitionObject.find("#brokerPersonBtn").attr("onclick","openContactForFrom(3,'from_nonacquistion');");_acquisitionObject.find("#showNameFirst").html(_data.detail[0].litigation.person_name_1);jQuery("#acquisitionPersonName1").val(_data.detail[0].litigation.person_name_1);jQuery("#acquisitionPersonTitle1").val(_data.detail[0].litigation.person_title_1);_acquisitionObject.find("#showNameBtn").attr("onclick","openContactForFrom(4,'from_nonacquistion');");_acquisitionObject.find("#showNameSecond").html(_data.detail[0].litigation.person_name_2);jQuery("#acquisitionPersonName2").val(_data.detail[0].litigation.person_name_2);jQuery("#acquisitionPersonTitle2").val(_data.detail[0].litigation.person_title_2);_acquisitionObject.find("#showNameSecondBtn").attr("onclick","openContactForFrom(5,'from_nonacquistion');");_acquisitionObject.find("#marketComplete").val(_data.detail[0].litigation.complete);jQuery("#acquisitionBroker").val(_data.detail[0].litigation.broker);jQuery("#acquisitionAddress").val(_data.detail[0].litigation.address);_acquisitionObject.find("#taskLeadId").val(_data.detail[0].litigation.id);jQuery("#acquisitionLeadId").val(_data.detail[0].litigation.id);jQuery("#acquisitionRelatesTo").val(_data.detail[0].litigation.relates_to);jQuery("#acquisitionOptionExpirationDate").val(expirationDate);
			<?php endif;?>		
			_acquisitionObject.find("#litigation_doc_list").empty();
			jQuery("#scrap_patent_data").find("tbody").empty();
			<?php if($openLeadDT===true):?>
			_acquisitionObject.find("#litigation_doc_list").addClass("docDropable").append("<ul class='todo-box-1 ' data-id='"+_data.detail[0].litigation.id+"'></ul>");jQuery("#acquisitionPatentData").val(_data.detail[0].litigation.patent_data)
			<?php endif;?>
			}else{
				if(_data.detail[0].litigation.type=="Litigation"&&jQuery("#litigationleadName").length>0){
					_litigationObject = jQuery("#from_litigation");
					<?php if($openLeadDT===true):?>
				jQuery("#litigationCaseName").val(_data.detail[0].litigation.case_name);jQuery("#litigationLitigationStage").val(_data.detail[0].litigation.litigation_stage);jQuery("#litigationMarketIndustry").val(_data.detail[0].litigation.market_industry);jQuery("#litigationCaseType").val(_data.detail[0].litigation.case_type);jQuery("#litigationCaseNumber").val(_data.detail[0].litigation.case_number);jQuery("#litigationCause").val(_data.detail[0].litigation.cause);jQuery("#litigationNoOfPatent").val(_data.detail[0].litigation.no_of_patent);jQuery("#litigationFillingDate").val(_data.detail[0].litigation.filling_date);jQuery("#litigationActiveDefendants").val(_data.detail[0].litigation.active_defendants);jQuery("#litigationFileUrl").val(_data.detail[0].litigation.file_url);			
				_litigationObject.find("#litigationleadName").val(_data.detail[0].litigation.lead_name);jQuery("#litigationId").val(_data.detail[0].litigation.id);_litigationObject.find("#litigationLeadAttorney").val(_data.detail[0].litigation.lead_attorney);jQuery("#litigationScrapperData").val(_data.detail[0].litigation.scrapper_data);jQuery("#litgationPatentData").val(_data.detail[0].litigation.patent_data);jQuery("#litigationOriginalDefendants").val(_data.detail[0].litigation.original_defendants);jQuery("#litigationCourt").val(_data.detail[0].litigation.court);jQuery("#litigationLinkToPacer").val(_data.detail[0].litigation.link_to_pacer);jQuery("#litigationLinkToRPX").val(_data.detail[0].litigation.link_to_rpx);jQuery("#litigationProspects").val(_data.detail[0].litigation.no_of_prospects);jQuery("#litigationExpectedPrice").val(_data.detail[0].litigation.upfront_price);jQuery("#litigationSellerInfo").val(_data.detail[0].litigation.seller_info);jQuery("#litigationProposal_letter").val(_data.detail[0].litigation.send_proposal_letter);jQuery("#litigationCreate_patent_list").val(_data.detail[0].litigation.create_patent_list);jQuery("#litigationUpfront_price").val(_data.detail[0].litigation.expected_price);_litigationObject.find("#litigationComplete").val(_data.detail[0].litigation.complete);if(_data.detail[0].litigation.complete==1){if(_data.detail[0].litigation.forward_to_review_text=="0000-00-00 00:00:00"||_data.detail[0].litigation.forward_to_review_text==null){jQuery("#forward_to_review").html("Review")}else{jQuery("#forward_to_review").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.forward_to_review_text)).format("MM-D-YY")+"</span> Review")}}
			<?php endif;?>
			jQuery("#taskLeadId").val(_data.detail[0].litigation.id);
			_litigationObject.find("#show_data").html("");
			<?php if($openLitigationTable===true):?>
			if(_data.detail[0].litigation.defendants==""&&_data.detail[0].litigation.court_docket_entries==""){
				emptyForm();
				initDataTableLitigation();
				jQuery(function(){jQuery(".tabs").tabs()});
				jQuery(function(){jQuery(".tabs-hover").tabs({event:"mouseover"})});
				tabDropInit();
				_cUT="<?php echo $this->session->userdata['type']?>";							
				if(_data.detail[0].litigation.scrapper_data!=""&&_data.detail[0].litigation.scrapper_data!=null){
						implementLitigationScrap(JSON.parse(_data.detail[0].litigation.scrapper_data));tabDropInit();
				}else{
					_litigationObject.find("#show_data").html("")
				}
			}else{
				_litigationObject.find("#show_data").html('<div class="col-sm-12 noPadding" style="overflow-y:scroll;overflow:x:none;height:400px;"><div class="col-sm-6 noPadding" id="defendant"><img src="'+_data.detail[0].litigation.court_docket_entries+'" style="width:490px;"/></div><div class="col-sm-6" id="court_docket"><img src="'+_data.detail[0].litigation.court_docket_entries+'" style="width:490px;"/></div></div>')
			}
			<?php endif;?>		
			_litigationObject.find("#litigation_doc_list").empty();
			jQuery("#scrap_patent_data").find("tbody").empty();
			<?php if($openLeadDT===true):?>					
			_litigationObject.find("#litigation_doc_list").addClass("docDropable").append("<ul class='todo-box-1' data-id='"+_data.detail[0].litigation.id+"'></ul>");
			_litigationObject.find("#litigationId").val(_data.detail[0].litigation.id);
			_litigationObject.find("#litigationPatentData").val(_data.detail[0].litigation.patent_data);
			<?php endif;?>
			
			}
			}
		}
		if(_mainButtonParentElement != ""){
			let catList = _data.detail[0].lead_category_list;
			let catIDList = [];
			let catNameList = [];
			let maincategorySelected = 0;
			let maincategorySelectedName = "";
			if(catList.length > 0){
				for(let l =0;l<catList.length;l++){
					catIDList.push(catList[l].category_id);
					if(catList[l].main_category == 1){
						maincategorySelected = catList[l].category_id;
					}
				}
			}
			console.log(catList,catIDList);
			const catMultiSelect = jQuery("#"+_mainButtonParentElement).find('.multiselect');
			const checkList = catMultiSelect.find("input[type='checkbox']");
			checkList.prop('checked',false);
			catMultiSelect.find("a").removeClass('active');
			catIDList.forEach(function(c){
				console.log(c);
				let cCheckBox = catMultiSelect.find("input.check_list[value='"+c+"']");
				if(cCheckBox.length > 0){
					cCheckBox.prop("checked",true);
					if(maincategorySelected == c){
						console.log("MainSeletcted",c,cCheckBox.val());
						maincategorySelectedName = cCheckBox.parent().find("span").text();
						cCheckBox.parent().find('a').addClass('active');
					}
					catNameList.push(cCheckBox.parent().find("span").text());
				}
			});
			if(maincategorySelected == 0){
				console.log("No main selected");
				catMultiSelect.find("input[type='radio']").prop('checked',false);
			}
			console.log(catNameList);
			catNameList = [];
			if(maincategorySelectedName != "" && maincategorySelected > 0){
				catNameList.push(maincategorySelectedName);
			}
			catMultiSelect.find(".overSelect").html(catNameList.join(',')).attr('title',catNameList.join(','));
		}
		windowResize();checkBodyScrollable();
		/*if(_leadPatent!=""){
			showPatentData(_leadPatent);
		}*/
		acquisitions = _data.detail[0].acquisitions;
		portfolioName = _data.detail[0].portfolio;
		if(typeof acquisitions.store_name!='undefined'){		
			/*jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('#btnLinkToDocket').attr('href','https://synpat.com/catalog/?'+portfolioName).attr('target',"Docket - "+leadNameGlobal);	*/	
			jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToIntroDD').attr('href','https://synpat.com/docket-services/introdd/'+acquisitions.store_name).attr('target',"Intro DD - "+leadNameGlobal);		
			
		} else {								
			jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('#btnLinkToDocket').attr('href','javascript://').attr('target',"Docket - "+leadNameGlobal);	
			jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('#btnLinkToIntroDD').attr('href','javascript://').attr('target',"Intro DD - "+leadNameGlobal);	
			
		}
		if(typeof acquisitions.order_name!='undefined'){
			jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToClaimcharts').attr('data-href', 'https://synpat.com/experts/?tap='+acquisitions.order_name);		
		} else {
			jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToClaimcharts').removeAttr('data-href');
		}
		if(typeof portfolioName!='undefined' && portfolioName!=""){
			let invitationUrl = "";
			if(parseInt(acquisitions.category) > 0) {
				invitationUrl = 'https://synpat.com/catalog/?'+portfolioName;
			} else {
				invitationUrl = 'https://synpat.com/catalog/?tap=show&c='+portfolioName;
			}
			jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('#btnLinkToDocket').attr('href',invitationUrl).attr('target',"Store - "+leadNameGlobal);	
		} else {
			jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('#btnLinkToDocket').attr('href','javascript://').attr('target',"Store - "+leadNameGlobal);	
		}
		jQuery('#'+_mainButtonParentElement).find('#schedulerLink').val(_data.detail[0].litigation.scheduler_link);
		jQuery('#'+_mainButtonParentElement).find('#invitationLink').val(_data.detail[0].invitation_link);
		console.log('COST:'+acquisitions.cost_price);
		if(typeof acquisitions.cost_price!='undefined'){
			console.log('COST:'+acquisitions.cost_price);
			costPrice = acquisitions.cost_price;
			if(costPrice>0){
				_actualPrice = 0
				stage = 1;
				_todayDate = moment(_todayDate).format('MM/DD/YYYY');
				if(acquisitions.regular_license_starts!="0000-00-00 00:00:00"){
					regularLicense = moment(acquisitions.regular_license_starts).format('MM/DD/YYYY');
					if(regularLicense==_todayDate || moment(new Date(_todayDate)).isAfter(regularLicense,'MM/DD/YYYY')===true){
						_actualPrice = costPrice * 1.5;
						stage = 2;
					}
				}
				lateLicense = acquisitions.late_license_starts;
				if(lateLicense!="0000-00-00 00:00:00"){
					lateLicense = moment(lateLicense).format('MM/DD/YYYY');
					if(moment(new Date(_todayDate)).isAfter(lateLicense,'MM/DD/YYYY')===true){
						_actualPrice = costPrice * 3;
						stage = 3;
					}
				}				
				switch(stage){
					case 2:
						jQuery('#'+_mainButtonParentElement).find('#spnMarketStage').html('Regular Price: ');
					break;
					case 3:
						jQuery('#'+_mainButtonParentElement).find('#spnMarketStage').html('Validated Price: ');
					break;
				}
				if(_actualPrice>0){
					switch(stage){
						case 2:
							jQuery('#'+_mainButtonParentElement).find('#spnMarketStage').html(_actualPrice.toFixed(1)+'M');
						break;
						case 3:
							jQuery('#'+_mainButtonParentElement).find('#spnMarketStage').html(_actualPrice.toFixed(1)+'M');
						break;
					}
					if(stage!=acquisitions.active_button){
						/*need to update active button*/
						console.log("Update button");
						call(__baseUrl+'opportunity/update_store_active_button','POST',{l:leadGlobal,s:stage},checkResultOfActive,'text');
						jQuery('#'+_mainButtonParentElement).find("#docketActiveButton").val(stage);
					}
				}
			} else {
				jQuery('#'+_mainButtonParentElement).find('#spnMarketStage').html('Syndication');
			}
		} else {
			jQuery('#'+_mainButtonParentElement).find('#spnMarketStage').html('Syndication');
		}
		
		if(parseInt(_data.detail[0].litigation.invalidation_tab)==0){
			jQuery("#invalidation_tab").prop('checked',true);
			jQuery("#invalidation_tab").attr('checked','checked');
		} else {
			jQuery("#invalidation_tab").prop('checked',false);
			jQuery("#invalidation_tab").removeAttr('checked');
		}
		if(parseInt(_data.detail[0].litigation.eou_tab)==0){
			jQuery("#eou_tab").prop('checked',true);
			jQuery("#eou_tab").attr('checked','checked');
		} else {
			jQuery("#eou_tab").prop('checked',false);
			jQuery("#eou_tab").removeAttr('checked');
		}
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToTechDD').attr('href','https://synpat.com/docket-services/techdd/'+_data.detail[0].litigation.serial_number).attr('target',"Technical DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToMarketDD').attr('href','https://synpat.com/docket-services/marketdd/'+_data.detail[0].litigation.serial_number).attr('target',"Market DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToLegalDD').attr('href','https://synpat.com/docket-services/legaldd/'+_data.detail[0].litigation.serial_number).attr('target',"Legal DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToSellerDD').attr('href','https://synpat.com/docket-services/dd/'+_data.detail[0].litigation.serial_number).attr('target',"Seller DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToComparable').attr('href','https://synpat.com/docket-services/comparedd/'+_data.detail[0].litigation.serial_number).attr('target',"Comparables DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToPDF').attr('href','https://synpat.com/docket-services/pdfdd/index/'+_data.detail[0].litigation.serial_number).attr('target',"PDF DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToIllusDD').attr('href','https://synpat.com/docket-services/illustrationdd/index/'+_data.detail[0].litigation.serial_number).attr('target',"Illustration DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToIntroImages').attr('href','https://synpat.com/docket-services/introimages/index/'+_data.detail[0].litigation.serial_number).attr('target',"Intro Images DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToDictionaryDD').attr('href','https://synpat.com/docket-services/dictionarydd/'+_data.detail[0].litigation.serial_number).attr('target',"Dictionary DD - "+_data.detail[0].litigation.lead_name);
		<?php if((int)$this->session->userdata['user']['type']==9 || (in_array(14,$this->session->userdata['modules_assign']) && in_array(15,$this->session->userdata['modules_assign']) && in_array(16,$this->session->userdata['modules_assign']))):?>
		if(_data.detail[0].litigation.spreadsheet_id!=""){jQuery("#patentSpreadsheetId").val(_data.detail[0].litigation.spreadsheet_id)}if(_data.detail[0].litigation.spreadsheet_id!=""&&_data.detail[0].litigation.worksheet_id==""){findWorksheetMode(jQuery("#patentSpreadsheetId"),'','undefined')}if(_data.detail[0].litigation.spreadsheet_id!=""&&_data.detail[0].litigation.worksheet_id!=""){findWorksheetMode(jQuery("#patentSpreadsheetId"),_data.detail[0].litigation.worksheet_id,'undefined')}
		/*fillPatentSheetListMode(_data.detail[0].litigation.folder_id);
		if(snapGlobal!='' || snapGlobalFileID!=''){
			findPatentFromSheetForm('undefined','undefined');
			jQuery("#patentFileUrl").val(snapGlobal);
			console.log(snapGlobal);
		}*/
		<?php elseif(in_array(16,$this->session->userdata['modules_assign'])):?>
		if(_data.detail[0].litigation.spreadsheet_id!=""){jQuery("#patentSpreadsheetId").val(_data.detail[0].litigation.spreadsheet_id)}if(_data.detail[0].litigation.spreadsheet_id!=""&&_data.detail[0].litigation.worksheet_id==""){findWorksheetMode(jQuery("#patentSpreadsheetId"),'','undefined')}if(_data.detail[0].litigation.spreadsheet_id!=""&&_data.detail[0].litigation.worksheet_id!=""){findWorksheetMode(jQuery("#patentSpreadsheetId"),_data.detail[0].litigation.worksheet_id,'undefined')}
		<?php endif;?>
		<?php if((int)$this->session->userdata['user']['type']==9 || in_array(12,$this->session->userdata['modules_assign'])):?>
		_worksheet="";
		_spreadSheet="";
		_fileURLInput="";
		jQuery('#'+_mainButtonParentElement).find("#acquisitionRegularLicenseStarts").val('');jQuery('#'+_mainButtonParentElement).find("#acquisitionLateLicenseStarts").val('');
		if(typeof acquisitions.regular_license_starts!='undefined'){
			_dR = moment(new Date(acquisitions.regular_license_starts)).format('MM/DD/YYYY');
			jQuery('#'+_mainButtonParentElement).find("#docketRegularLicenseStarts").val(_dR);
		}
		if(typeof acquisitions.late_license_starts!='undefined'){
			_dL = moment(new Date(acquisitions.late_license_starts)).format('MM/DD/YYYY');
			jQuery('#'+_mainButtonParentElement).find("#docketLateLicenseStarts").val(_dL);
		}
		if(typeof acquisitions.category!='undefined'){
			jQuery('#'+_mainButtonParentElement).find("#docketCategory").val(acquisitions.category);
		} else {
			jQuery('#'+_mainButtonParentElement).find("#docketCategory").val(0);
		}
		if(typeof acquisitions.active_button!='undefined'){
			jQuery('#'+_mainButtonParentElement).find("#docketActiveButton").val(acquisitions.active_button);
		}
		/*if(typeof acquisitions.docket_status!='undefined'){
			if(acquisitions.docket_status==1){
				jQuery('#'+_mainButtonParentElement).find("#docketStatus").prop('checked',false);
				jQuery('#'+_mainButtonParentElement).find("#docketStatus").removeAttr('checked');
			} else if(acquisitions.docket_status==0){
				jQuery('#'+_mainButtonParentElement).find("#docketStatus").prop('checked',true);
				jQuery('#'+_mainButtonParentElement).find("#docketStatus").attr('checked','checked');
			}
		} else {
			jQuery('#'+_mainButtonParentElement).find("#docketStatus").prop('checked',true);
			jQuery('#'+_mainButtonParentElement).find("#docketStatus").attr('checked','checked');
		}
		if(typeof acquisitions.store_status!='undefined'){
			if(acquisitions.store_status==1){
				jQuery('#'+_mainButtonParentElement).find("#storeStatus").prop('checked',false);
				jQuery('#'+_mainButtonParentElement).find("#storeStatus").removeAttr('checked');
			} else if(acquisitions.store_status==0){
				jQuery('#'+_mainButtonParentElement).find("#storeStatus").prop('checked',true);
				jQuery('#'+_mainButtonParentElement).find("#storeStatus").attr('checked','checked');
			}
		} else {
			jQuery('#'+_mainButtonParentElement).find("#storeStatus").prop('checked',true);
			jQuery('#'+_mainButtonParentElement).find("#storeStatus").attr('checked','checked');
		}*/
		switch(_mainButtonParentElement){
			case 'from_litigation':
				_worksheet="#litigationWorksheetId";
				_spreadSheet="#litigationSpreadsheetId";			
				_fileURLInput="#litigationFileUrl";			
			break;
			case 'from_regular':
				_worksheet="#marketWorksheetId";
				_spreadSheet="#marketSpreadsheetId";
				_fileURLInput="#marketFileUrl";
			break;
			case 'from_nonacquistion':
				_worksheet="#acquisitionWorksheetId";
				_spreadSheet="#acquisitionSpreadsheetId";
				_fileURLInput="#acquisitionFileUrl";
			break;
		}
		if(_data.detail[0].litigation.spreadsheet_id!=""){jQuery("#"+_mainButtonParentElement).find(_spreadSheet).val(_data.detail[0].litigation.spreadsheet_id)}
		if(_data.detail[0].litigation.worksheet_id!=""){
			jQuery("#"+_mainButtonParentElement).find(_worksheet).val(_data.detail[0].litigation.worksheet_id);
		}
		jQuery("#"+_mainButtonParentElement).find(_fileURLInput).val(snapGlobal);
		<?php endif;?>
		runTableLeadBal();			
		if(_mainButtonParentElement!=undefined){
			_mainBtnParentElement = _mainButtonParentElement;
		}
		if(jQuery("#btnPatentsAll").hasClass("menu-active")){
			if(jQuery("#family_patent_container").hasClass("show")){
				console.log('DISSSPLLLAYWWWWW');
				jQuery("#family_patent_container").addClass("hide").removeClass("show");
				jQuery(".ppatent").addClass("show").removeClass("hide");
			}
			console.log('DISSSPLLLAY');
			displayPatentTable(_mainBtnParentElement,'1');
		}
		countActiveMenus();
		setTimeout(function(){console.log('updateDD');updateDDButtonOnClick();},500);
	}
}

window.checkResultOfActive = function (data){
	console.log(data);
}

window.showLeadData = function(){
	/*Show LeadForm Data*/
	if(leadCache[leadGlobal]){
		wholeLeadData = leadCache[leadGlobal];
		if(wholeLeadData.lead_data){
			leadDataDisplay(wholeLeadData.lead_data);
		}
	}
};
window.showAcqusitionData = function(){
	/*Show Acquisition Data*/
	leadGlobal = parseInt(leadGlobal);
	if(leadCache[leadGlobal]){
		if(typeof leadCache[leadGlobal].acquisition_data!="undefined" && typeof leadCache[leadGlobal].acquisition_data!=""){
			acquisitionImport(leadCache[leadGlobal].acquisition_data);
		}
	}
};
window.showSalesData = function(){
	/*Show Sales Data*/
	leadGlobal = parseInt(leadGlobal);
	if(leadCache[leadGlobal]){
		if(typeof leadCache[leadGlobal].sales_data!="undefined" && leadCache[leadGlobal].sales_data!=""){
			salesActivityList(leadCache[leadGlobal].sales_data);
		}
	}
};
window.showDriveData = function(){
	/*Show Drive Data*/
	if(leadCache[leadGlobal]){
		if(typeof leadCache[leadGlobal]['drive_data']!="undefined" && leadCache[leadGlobal]['drive_data']!=""){
			console.info('Creating HtML....');
			loadDriveFiles(leadCache[leadGlobal]['drive_data']);
		}
	}
};
function callingOrder(n){
	if(typeof n =="undefined"){
		n=0;
	}
	if(parseInt(n)>=0){
		switch(parseInt(n)){
			case 0:
				/*LeadForm*/
				getLeadData = leadFormData();
				getLeadData.done(function(){
					showLeadData();
					console.log("Ramp2");
					getLeadDriveData =  driveFilesData();
					getLeadDriveData.done(function(){
						showDriveData();
					});
				});
			break;
			case 1:
				/*Acquisition*/
				getLeadAcquisitionData =  acquisitionData();
				getLeadAcquisitionData.done(function(){
					showAcqusitionData();
				});
			break;
			case 2:
				/*Sales*/
				getLeadSalesData =  salesData();
				getLeadSalesData.done(function(){
					showSalesData()
				});
			break;
			case 3:		
				/*Drive Files*/
				/*getLeadDriveData =  driveFilesData();
				getLeadDriveData.done(function(){
					console.info('Drive Call Done....');
					showDriveData();
				});*/
			break;
		}
	}
}
var ajLeadForm="";
function leadFormData(){
	var leadDefer = jQuery.Deferred();
	ajLeadForm = jQuery.ajax(__baseUrl+"leads/findBoxList",{type:'POST',data:{boxes:leadGlobal},dataType:'json'}).then(function(data){
		if(typeof leadCache[leadGlobal]=="undefined"){
			initLeadCache(leadGlobal);
			leadCache[leadGlobal]['lead_data'] = data;
		} else {
			leadCache[leadGlobal]['lead_data'] = data;
		}
		leadDefer.resolve();
	},function(){
		if(typeof leadCache[leadGlobal]=="undefined"){
			initLeadCache(leadGlobal);
			leadCache[leadGlobal]['lead_data'] = {};
		} else {
			leadCache[leadGlobal]['lead_data'] = {};
		}
		leadDefer.reject();
	}).promise();
	return leadDefer;
}

var ajLeadTable="";
function leadTableData(){
	var leadDefer = jQuery.Deferred();
	ajLeadTable = jQuery.ajax(__baseUrl+"leads/findLeadTable",{type:'POST',data:{boxes:leadGlobal},dataType:'json'}).then(function(data){
		if(typeof leadCache[leadGlobal]=="undefined"){
			initLeadCache(leadGlobal);
			leadCache[leadGlobal]['lead_table'] = data;
		} else {
			leadCache[leadGlobal]['lead_table'] = data;
		}
		leadDefer.resolve();
	},function(){
		if(typeof leadCache[leadGlobal]=="undefined"){
			initLeadCache(leadGlobal);
			leadCache[leadGlobal]['lead_table'] = {};
		} else {
			leadCache[leadGlobal]['lead_table'] = {};
		}
		leadDefer.reject();
	}).promise();
	return leadDefer;
}
var ajAcquisitionData="";
function acquisitionData(){
	var acquisitionDefer = jQuery.Deferred();
	ajAcquisitionData = jQuery.ajax(__baseUrl+"leads/findEmailBoxes",{type:'POST',dataType:'json',data:{boxes:leadGlobal}}).then(function(data){		
		if(typeof leadCache[leadGlobal]=="undefined"){
			initLeadCache(leadGlobal);
			leadCache[leadGlobal]['acquisition_data'] = data;
		} else {
			leadCache[leadGlobal].acquisition_data = data;
		}
		acquisitionDefer.resolve();
	},function(){
		if(typeof leadCache[leadGlobal]=="undefined"){
			initLeadCache(leadGlobal);
			leadCache[leadGlobal]['acquisition_data'] = {};
		} else {
			leadCache[leadGlobal]['acquisition_data'] = {};
		}
		acquisitionDefer.reject();
	}).promise();
	return acquisitionDefer;
}
var ajSalesData="";
function salesData(){
	var salesDefer = jQuery.Deferred();
	ajSalesData = jQuery.ajax(__baseUrl+"leads/findSalesBoxes",{type:'POST',dataType:'json',data:{boxes:leadGlobal}}).then(function(data){
		if(typeof leadCache[leadGlobal]=="undefined"){
			initLeadCache(leadGlobal);
			leadCache[leadGlobal]['sales_data'] = data;
		} else {
			leadCache[leadGlobal].sales_data = data;
		}
		salesDefer.resolve();
	},function(){
		if(typeof leadCache[leadGlobal]=="undefined"){
			initLeadCache(leadGlobal);
			leadCache[leadGlobal]['sales_data'] = {};
		} else {
			leadCache[leadGlobal].sales_data = {};
		}
		salesDefer.reject() ;
	}).promise();
	return salesDefer;
}
function initLeadCache(g){
	leadCache = [];
	leadObject = {lead_table:'',lead_data:'',drive_data:'',acquisition_data:'',sales_data:''};
	leadCache[g] = leadObject;
}
var ajDriveData = "";
function driveFilesData(){
	var driveDefer = jQuery.Deferred();
	ajDriveData = jQuery.ajax(__baseUrl+"leads/findDriveFiles",{type:'POST',dataType:'json',data:{boxes:leadGlobal}}).then(function(data){
		console.log("Drive data..");
		if(typeof leadCache[leadGlobal]=="undefined"){
			leadCache[leadGlobal].drive_data = data;
		} else {
			leadCache[leadGlobal].drive_data = data;
		}
		driveDefer.resolve();
	},function(){
		if(typeof leadCache[leadGlobal]=="undefined"){
			leadCache[leadGlobal].drive_data = {};
		} else {
			leadCache[leadGlobal].drive_data = {};
		}
		driveDefer.reject();
	}).promise();
	return driveDefer;
}

function checkDocketStatus(o){status=(o.is(':checked')?1:0);jQuery.ajax({type:'POST',url:__baseUrl+'opportunity/change_docket_status',data:{lead_id:leadGlobal,docket_status:status},success:function(resp){obj = JSON.parse(resp);if(obj.success==1){if(obj.status==0){o.prop('checked',true);}else {o.prop('checked',false);}}}})}
function checkStoreStatus(o){status=(o.is(':checked')?1:0);jQuery.ajax({type:'POST',url:__baseUrl+'opportunity/change_store_status',data:{lead_id:leadGlobal,store_status:status},success:function(resp){obj = JSON.parse(resp);if(obj.success==1){if(obj.status==0){o.prop('checked',true);}else {o.prop('checked',false);}}jQuery('#'+_mainBtnParentElement).find('#docketCategory').val(obj.category);}})}
function changeUpFromPrice(o){
	_price = o.val();
	console.log('PortPrice'+_price);
	if(_price>0){
		_upFrontPrice = parseFloat(_price/2);
		_upFrontPrice = _upFrontPrice.toFixed(2);
		jQuery("#"+_mainBtnParentElement).find("#marketupfront_price,#spnMarketRemainigP").val(_upFrontPrice);
	}
}
function changePriceUP(o){
	console.log("UP change");
	let _agreedPrice = jQuery("#"+_mainBtnParentElement).find("#market_price").val();
	let _upFrontPrice = jQuery("#"+_mainBtnParentElement).find("#marketupfront_price").val();
	let _rPrice = 0;
	try{
		_agreedPrice = parseFloat(_agreedPrice);
		_upFrontPrice = parseFloat(_upFrontPrice);
	}catch(e){		
	}
	if(_agreedPrice > 0 && _upFrontPrice > 0){		
		_rPrice = _agreedPrice - _upFrontPrice;
	} else if(_agreedPrice > 0){
		_rPrice = _agreedPrice
	} else if(_upFrontPrice > 0){		
		_rPrice = -1*_upFrontPrice;
	}
	_rPrice =  parseFloat(_rPrice).toFixed(3);
	jQuery("#"+_mainBtnParentElement).find("#spnMarketRemainigP").val(_rPrice);
}
	
function threadDetail(a,b,c){
	if(___FLAG===1){if(jQuery("#from_litigation").is(":visible")){submitData()}else{if(jQuery("#from_regular").is(":visible")){submitDataMarket()}else{if(jQuery("#from_nonacquistion").is(":visible")){submitFromData("from_nonacquistion")}}}}mainAllPatentData=[];_allMainPatents=[];dieAllCalls();clearLeadSelectInterval();_formOpen='';jQuery('.actBtn').removeClass('active');jQuery("#activityType").val('');if(typeof c =='undefined'){jQuery("#displayEmail").empty();}jQuery('#aquisitionTable').find('tbody').empty();jQuery('#activityTable').find('tbody').empty();jQuery('#preSaleActivityTable').find('tbody').empty();mainLogBox=0;__dashFlag=false;
	_leadDT = $("#all_type_list");
	_leadDT.find("tbody td").removeClass("active");
	_leadDT.find("tbody tr").removeClass("active");
	/*$(".message-item").removeClass("message-active");*/$("#other_list_boxes .message td").removeClass("active");
	if(jQuery('#from_litigation,#from_nonacquistion,#from_regular').find('form').length>0){
		jQuery('#from_litigation,#from_nonacquistion,#from_regular').find('form').get(0).reset();
		jQuery('#from_litigation,#from_nonacquistion,#from_regular').find('form').find('input[type="hidden"]').val('');
		jQuery('#from_litigation,#from_nonacquistion,#from_regular').find('form').find('span.span-control').text('');
		jQuery('#from_litigation,#from_nonacquistion,#from_regular').find('form').find('span.span-control').attr('title','');
		jQuery('#from_litigation,#from_nonacquistion,#from_regular').find('form').find('div.overSelect').attr('title','').html('');
		jQuery('#from_litigation,#from_nonacquistion,#from_regular').find("#loadingLink").html('<i class="glyph-icon icon-recycle" style="font-size:16px;"></i> Import / Update Data').attr('onclick','findPatentFromSheetForm(\'undefined\')');
	}
	jQuery("#sales_acititity").find("#show_selected_count").text('');
	jQuery("#patentWorksheetId").find("option").remove();
	jQuery('#from_litigation,#from_nonacquistion,#from_regular').find('.todo-list-custom').html('');
	jQuery('#from_litigation,#from_nonacquistion,#from_regular').find('#litigation_doc_list').html('');
	jQuery('#from_litigation,#from_nonacquistion,#from_regular').find('#clipboard').find('option').remove();
	if(a.attr("data-id")!=undefined){
		g=a.attr("data-id");
		g = parseInt(g);
		
		t=a.attr("data-type");
		a.parent().find("tr").removeClass("active");
		_inde=a.index();
		if(jQuery("#search_lead_box").is(":visible")){
			_leadDT.find("tbody").find("tr").each(function(index){
				if(jQuery(this).attr("data-id")==g){
					_inde = index;jQuery(this).addClass("active")
				}
			});
		}
		_leadDT.find("tbody tr").eq(_inde).addClass("active");
		a.parents('tr').addClass("active");
	}else{
		g=a.parent().parent().attr("data-id");t=a.parent().parent().attr("data-type");_inde=a.parent().parent().parent().index();
	_leadDT.find("tbody tr").eq(_inde).addClass("active");
	}
	___FLAG=0;leadRunEntry(leadGlobal,g);jQuery("#search_lead_box").css("display","none");jQuery(".messages-list-leads").find(".message-item").each(function(){jQuery(this).removeClass("message-active");jQuery(this).find("h5").addClass("c-dark");jQuery(this).find("h4").addClass("c-dark");jQuery(this).find("p").addClass("c-gray");jQuery(this).find("a").addClass("c-dark")});jQuery(".message-detail-title").css("display","none");jQuery(".message-detail-right").hide();jQuery("#subject").empty();jQuery(".message-detail-subject").empty();if(typeof(b)==="undefined"){jQuery("#other_list_boxes").empty()}jQuery("#other_list_boxes").find("table").find("tr").removeClass("activetr");jQuery(".message_detail").empty().html('<div class="loading-spinner" id="loading_spinner" style="display:none;"><img src="<?php echo $awsUrl; ?>images/ajax-loader.gif" alt=""></div>');if(jQuery("#marketLead").length>0){jQuery("#marketLead").get(0).reset()}if(jQuery("#leadForm").length>0){jQuery("#leadForm").get(0).reset()}if(jQuery("#formLitigation").length>0){jQuery("#formLitigation").get(0).reset()}
_gModal = jQuery("#gmail_message_modal");
if(jQuery("#myDashboardComposeEmails").length>0 && !_gModal.is(':visible')){jQuery("#myDashboardComposeEmails").get(0).reset();_gModal.hide().find("#attach_droppable").empty();}
jQuery("#scrap_patent_data").find("tbody").empty();
jQuery("#from_regular,#from_litigation,#from_nonacquistion").find("#litigation_doc_list").empty();
if(parseInt(g)>0){
	_leInTBR = jQuery("#all_type_list").find("tr[data-id='"+g+"']")
	if(_leInTBR.length>0 && jQuery("#btnFormCollapse").hasClass('menu-active')){
		_ty = _leInTBR.attr('data-type');
		/*jQuery("#from_regular,#from_litigation,#from_nonacquistion").find("#serialNumber").html(_leInTBR.attr('data-sr'));*/
		switch(_ty){
			case 'Market':
				jQuery("#from_litigation,#from_nonacquistion").css("display","none");
				jQuery("#from_regular").css("display","");
			break;
			case 'Litigation':
				jQuery("#from_regular,#from_nonacquistion").css("display","none");
				jQuery("#from_litigation").css("display","");
			break;
			default:
				jQuery("#from_regular,#from_litigation").css("display","none");
				jQuery("#from_nonacquistion").css("display","");
			break;
		}
	} else {
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").css("display","none");
	}
	jQuery("#scrap_patent_data").find("tbody").empty();
	jQuery("#patent_data").find("#patentSpreadsheetId,#patentWorksheetId").find('option').remove();
	jQuery("#patent_data").find("#patentFileUrl").val('');
	jQuery("#bottom_form_market").css("display","none");
	leadGlobal = g;  
	_entireFamily = false;
	jQuery("#scrap_patent_data").DataTable().destroy();
	jQuery("#scrap_patent_data").find('tbody').empty();
	jQuery("#patent_family").DataTable().destroy();
	jQuery("#patent_family").find('tbody').empty();
	jQuery("#show_patent_core_results,#show_patent_family_results").find("label").empty();
	jQuery("#show_patent_family_results,#loadingLabel").empty();	
	enableButtonScript(g);
	leadCache = [];
	leadObject = {lead_table:'',lead_data:'',drive_data:'',acquisition_data:'',sales_data:''};
	leadCache[g] = leadObject;	
	checkModuleOpen();
	callnotification();
	runLeadSelectInterval();
	checkOpenSliders();
	var fOpenS = false;
	if(jQuery("#open_sales_gd").hasClass('is-open')){
		var findFrame = jQuery("#open_sales_gd").find("iframe").get(0).contentWindow;
		fOpenS = true;
	} else if(jQuery("#open_ccompany_gd").hasClass('is-open')){
		var findFrame = jQuery("#open_ccompany_gd").find("iframe").get(0).contentWindow;
		fOpenS = true;
	}
	if(fOpenS===true){
		findFrame.findCompaniesInLead(leadGlobal , false);
	}
	if(jQuery("#open_lead_docket_claimchart").hasClass("sb-active")){
		openLeadDocketClaimchart();
	}
	/*
	leadCacheScript(g);	
	enableActionRightAgain()*/
}}
_referenceString="";
function findThread(a,e,b){dieAllCalls();_formOpen='';jQuery('#displayEmail,#message-detail').data('file','');jQuery('#displayEmail').empty();_mainActivity = parseInt(jQuery("#activityMainType").val());if(_mainActivity>0 && typeof(e)=='object'){p=0,c_id=0,_dateEmail="";if(_mainActivity==1){_atO = jQuery("#activityTable:visible");if(_atO.length>0){_atOSP=_atO.find('input[name="sales_person[]"]:checked');if(_atOSP.length>0){if(_atOSP.length==1){p=_atOSP.val();c_id=_atOSP.parent().parent().attr("data-c");_dateEmail=e.parent().parent().parent().attr("data-date");} else {alert("Please select only one person from whom you received email")}}}}else if(_mainActivity==3){_atO = jQuery("#preSaleActivityTable:visible");if(_atO.length>0){_atOSP=_atO.find('input[name="sales_person[]"]:checked');if(_atOSP.length>0){if(_atOSP.length==1){p=_atOSP.val();c_id=_atOSP.parent().parent().attr("data-c");_dateEmail=e.parent().parent().parent().attr("data-date");} else {alert("Please select only one person from whom you received email")}}}} else if(_mainActivity==2){_aatO = jQuery("#aquisitionTable:visible");if(_aatO.length>0){_aatOSP=_aatO.find('input[name="sales_person[]"]:checked');if(_aatOSP.length>0){if(_aatOSP.length==1){p=_aatOSP.val();c_id=_aatOSP.parent().parent().attr("data-c");_dateEmail=e.parent().parent().parent().attr("data-date");} else {alert("Please select only one person from whom you received email")}}}}if(p>0&&c_id>0&&_dateEmail!=""){msg = confirm('Are you sure you want to associate email with this person?');if(msg==true){jQuery("#moveEmailPopup").modal("show");jQuery.ajax({type:"POST",url:__baseUrl+"dashboard/linkWithMessage",data:{old_thread:leadGlobal,c_id:c_id,p:p,thread:e.parent().parent().parent().attr("data-id"),date:_dateEmail,t:_mainActivity},cache:false,success:function(et){jQuery("#moveEmailPopup").modal("hide");if(et!=""){_send=jQuery.parseJSON(et);if(_send.send>0){e.parent().parent().parent().remove();refreshAcquisitionAndSalesActivity();}else{alert("Please try after sometime")}}else{alert("Please try after sometime")}}});}}else{releaseAll();showServerEmail(a,e,b);}} else {releaseAll();showServerEmail(a,e,b)}}
function  showServerEmail(a,e,b){if(typeof(b)==="undefined"){b=0}resetMenus();jQuery(".mCSB_container").find(".message-item").each(function(){if(jQuery(this).attr("data-id")==jQuery.trim(a)){if(b==0){e.parent().parent().parent().find("a").css("color","#FFF");e.parent().parent().parent().addClass("message-active");e.parent().parent().parent().find("h5").removeClass("c-dark");e.parent().parent().parent().find("h4").removeClass("c-dark");e.parent().parent().parent().find("p").removeClass("c-gray");e.parent().parent().parent().find("a").removeClass("c-dark");jQuery("#gmail_message").hide();jQuery("#from_regular").hide();jQuery("#from_litigation").hide();jQuery('#sales_acititity').removeClass('show').addClass('hide');jQuery("#from_nonacquistion").hide();if(jQuery("#myDashboardComposeEmails").length>0){jQuery("#myDashboardComposeEmails").get(0).reset()}$("#all_type_list tbody tr").removeClass("active");$("#all_type_list tbody td").removeClass("active");$("#other_list_boxes").empty()}}else{jQuery(this).removeClass("message-active");jQuery(this).find("h5").addClass("c-dark");jQuery(this).find("h4").addClass("c-dark");jQuery(this).find("p").addClass("c-gray");jQuery(this).find("a").addClass("c-dark")}});$("#other_list_boxes .message td").removeClass("active");if(!b){jQuery('.DTFC_Cloned tbody tr, .DTFC_Cloned tbody td').removeClass('active');$("#all_type_list tbody td").removeClass("active")}if(b){e.parent().addClass("active")}jQuery("#messages-boxlist").find("ul.todo-box").find("li").each(function(){jQuery(this).removeClass("active");jQuery("#marketLead").get(0).reset()});var j=jQuery("#message-detail").height()-jQuery("#message-detail .panel-heading").outerHeight()+12;j=296;jQuery("#displayEmail").html('<iframe src="'+__baseUrl+"users/email/"+jQuery.trim(a)+'" scrolling="no" width="100%" height="'+j+'">')
	jQuery("#displayEmail iframe").off('load').on('load', function() {
		checkMyEmailsHeight();
		iframe = jQuery("#displayEmail iframe").get(0);
	iframewindow= iframe.contentWindow? iframe.contentWindow : iframe.contentDocument.defaultView;
	if(iframewindow!=undefined){
		if(typeof iframewindow.bigContent==="function"){
			iframewindow.bigContent();
		}
	}
	});
}


function composeEmail(a,b) {
	if(leadGlobal==0) {
		alert("Please select lead first")
	}
	else {
		if(a==undefined) {
			jQuery("#emailDocUrl").val("");
			jQuery("#attach_droppable").empty()
		}

		jQuery("#anotherSys").val(0);
		if(typeof b == "undefined"){
			refreshContacts();
		}		
		jQuery("#emailCC").css("width","725px");
		$("body").append('<div class="modal-backdrop modal-backdrop-drive"></div>');
		openSlidebar(jQuery("#gmail_message_modal"));
		enableZIndex(jQuery("#gmail_message_modal"));
		openSlideBarLeftMessageResize();
		$(".dropdown-toggle").dropdown();
		jQuery("#emailThreadId").val("");
		jQuery("#emailMessageId").val("");
		jQuery("#attach_droppable").empty();
		jQuery("#emailAccountType").val(_emailActivate);
		jQuery("#emailSubject").removeAttr("readonly").val('');
		jQuery("#gmail_message").css("display","block");
		jQuery(".gmail-modal").css("display","block");
		jQuery("#myDashboardComposeEmails").find("button[type='submit']").prop("disabled",false);
		if(mainLogBox==1){ 
			jQuery("#legal_log").val(1)
		}
		else {
			jQuery("#legal_log").val(0)
		}
		jQuery("#gmail_message_modal").find("h4").html("Compose Message: "+leadNameGlobal);
		jQuery("#messageLeadId").val(leadGlobal);
		jQuery("body").data("modalzindex",jQuery("#gmail_message_modal").css("z-index"));
		jQuery("#emailTo").focus();
		clearIntervalRowWidth();
		setTimeout(function(){console.log('Clear interval and new set');rowWidth();inputStringFieldsWidth();},100);
	}
}

/*jQuery(document).ready(function(){jQuery("#gmail_message_modal").on("hidden.bs.modal",function(){jQuery("body").attr("onselectstart","return false");document.oncontextmenu=new Function("return false")})});*/
function discardEmail(){jQuery("#myDashboardComposeEmails").get(0).reset();jQuery('#emailAccountType').val(_emailActivate);jQuery("#emailThreadId").val("");jQuery("#emailMessageId").val("");jQuery("#gmail_message_modal").hide();jQuery("#attach_droppable").empty();jQuery("#emailTo").focus();jQuery("#emailMessage").code("<br/><br/><br/><br/>"+jQuery("#original_signature").val());closeSlideBarLeftMessage();checkBodyScrollable();windowResize();checkCampaignModalOpen()}
function checkCampaignModalOpen(){
	if(jQuery("#open_prefined_message").hasClass("is-open")){
		var iframe= jQuery("#open_prefined_message").find('#predefineFormIframe').get(0);
		var iframewindow= iframe.contentWindow? iframe.contentWindow : iframe.contentDocument.defaultView;
		if(iframewindow.document.location.pathname=="/users/email_campaign/"){
			if(typeof iframewindow.ignoreEmail =="function"){
				iframewindow.ignoreEmail();
			}
		}
	}
}
function removeAlert(){jQuery(".alert-close-btn").click(function(a){a.preventDefault();jQuery(this).parent().remove()})}
___check="";function getEmails(a,b,e){jQuery(".emails-group-container").find(".list-group-item,span").removeClass("active");jQuery('.emails-group-container').find(a).eq(jQuery('.emails-group-container').find(a).length-2).removeClass('active');e.addClass("active");e.parent().addClass("active");_string='<div class="loading-spinner" id="loading_spinner_heading_messages" style="display:none;"><img src="'+__IMAGEURL+'images/ajax-loader.gif" alt=""></div>';jQuery("."+a).html(_string);jQuery("#loading_spinner_heading_messages").css("display","block");jQuery.ajax({type:"POST",url:__baseUrl+"users/getOldEmails",data:{type:b},cache:false,success:function(j){jQuery("#loading_spinner_heading_messages").css("display","none");jQuery("."+a).html(j);if(b!="DRAFT"){initDragDrop()}}})}
function getNewEmails(a,b,e){jQuery(".emails-group-container").find('span.active').removeClass('active');jQuery(".emails-group-container").find(".list-group-item").removeClass("active");e.parent().addClass('active');e.parent().find('a').eq(0).addClass("active");_string='<div class="loading-spinner" id="loading_spinner_heading_messages" style="display:none;"><img src="'+__IMAGEURL+'images/ajax-loader.gif" alt=""></div>';jQuery("."+a).html(_string);jQuery("#loading_spinner_heading_messages").css("display","block");_defaultPaging=100;runRetrieveNew(b)}
function openNewLeadDialogueBox(){jQuery("#from_litigation,#from_regular,#from_nonacquistion").hide();jQuery('#show_data').removeClass('show').addClass('hide');clearLeadSelectInterval();window.leadGlobal=0;jQuery("#all_type_list").find("tbody").find("tr").removeClass("active");jQuery('.topbar-lead-name').html('');jQuery("#newLeadFormElement").find('#popupLeadname,#popupType').val('');jQuery("#newLeadFormElement").modal("show");setTimeout(function(){inputStringFieldsWidth();},500);/*releaseAll();*/return false}
__TableDT="";
function toggleTableFilter(a){var b = jQuery("#search_lead_panel"); if(b.hasClass('hide')){b.removeClass('hide').addClass("show");jQuery("#header-fixed").hide();} else {b.removeClass('show').addClass("hide");jQuery("#all_type_list").parent().data("page",'-1');/*loadMoreData();*/}}
function leadsTableOneLineCells(){$(".one-line-cell").each(function(a,b){var e=$(b);e.html(e.html().replace(/ /g,"&nbsp;"))})}</script>
<script src="<?php echo $awsUrl?>widgets/typing/typing.min.js"></script><style>.prelative span{margin-left:0px;}#all_type_list thead th.sorting_asc:after,#header-fixed thead th.sorting_asc:after,#all_type_list thead th.sorting_desc:after,#header-fixed thead th.sorting_desc:after{content:'';}</style> <div class="page-mailbox" id="main-content"> <div data-equal-height="true" class="row" style="margin-right:-9px"> <div class="col-md-8 list-messages" style='padding:0px;'> <div class="row row-width" style="margin:0"> <div class="col-width" style='padding:0;width:73px' id='listLabels'> <div class="panel panel-default panel-no-margin panel-blue-border" style="border-right:0px;"><div class="list-group emails-group-container">
 <?php if($openEmailBox===true){?><span class='bbblock active'><a href="javascript:void(0)" data-title="INBOX" onclick="getEmails('messages_container','INBOX',jQuery(this))" class="list-group-item active bbinline pd84">Inbox</a><a href="javascript:void(0)" onclick="getNewEmails('messages_container',0,jQuery(this))" class='pull-right pd81'><img src='<?php echo $awsUrl?>images/1475283531_cloud-download.png' width="15"/></a></span><span class='bbblock'><a href="javascript:void(0)" data-title="STARRED" onclick="getEmails('messages_container','STARRED',jQuery(this))" class="list-group-item label-dropable  bbinline pd84">Starred</a><a href="javascript:void(0)" onclick="getNewEmails('messages_container',1,jQuery(this))" class='pull-right pd81'><img src='<?php echo $awsUrl?>images/1475283531_cloud-download.png' width="15"/></a></span><span class='bbblock'><a href="javascript:void(0)" data-title="LEAD" onclick="getEmails('messages_container','LEAD',jQuery(this))" class="list-group-item  bbinline pd84" style='display:inline-block'>Leads</a></span><span class='bbblock'><a href="javascript:void(0)" data-title="DRAFT" onclick="getEmails('messages_container','DRAFT',jQuery(this))" class="list-group-item  bbinline pd84" style='display:inline-block'>Draft</a><a href="javascript:void(0)" onclick="getNewEmails('messages_container',2,jQuery(this))" class='pull-right pd81'><img src='<?php echo $awsUrl?>images/1475283531_cloud-download.png' width="15"/></a></span><span class='bbblock'><a href="javascript:void(0)" data-title="SENT" onclick="getEmails('messages_container','SENT',jQuery(this))" class="list-group-item  bbinline pd84" style='display:inline-block'>Sent</a><a href="javascript:void(0)" onclick="getNewEmails('messages_container',3,jQuery(this))" class='pull-right pd81'><img src='<?php echo $awsUrl?>images/1475283531_cloud-download.png' width="15"/></a></span><span class='bbblock'><a href="javascript:void(0)" data-title="TRASH" onclick="getEmails('messages_container','TRASH',jQuery(this))" class="list-group-item label-dropable  bbinline pd84" style='display:inline-block'>Trash</a><a href="javascript:void(0)" onclick="getNewEmails('messages_container',4,jQuery(this))" class='pull-right pd81'><img src='<?php echo $awsUrl?>images/1475283531_cloud-download.png' width="15"/></a></span> <?php }?><?php if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):?> <a href="javascript:void(0)" id='imap_licenses' onclick="getImapEmails('messages_container',jQuery(this),1)" class="list-group-item btn-block pd84" style='margin:0px;padding-right:0px;'>Licenses<span id='license_counter'></span></a><?php endif;?><?php if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):?> <a href="javascript:void(0)" id='imap_operation' onclick="getImapEmails('messages_container',jQuery(this),2)" class="list-group-item btn-block pd84" style='margin:0px;padding-right:0px;'>Patents<span id='operation_counter'></span></a><?php endif;?><?php if((int)$this->session->userdata['user']['type']==9 || in_array(27,$this->session->userdata['modules_assign'])):?><a href="javascript:void(0)" id='imap_expert' onclick="getImapEmails('messages_container',jQuery(this),3)" class="list-group-item btn-block pd84" style='margin:0px;padding-right:0px;'>Experts<span id='expert_counter'></span></a><?php endif;?><?php if((int)$this->session->userdata['user']['type']==9):?><a href="javascript:void(0)" onclick="getLinkedinMessages()" class="list-group-item btn-block pd84" style='margin:0px;'><i class='glyph-icon icon-linkedin' style='float:none;' title="Linkedin"></i><span id='linkedin_counter' class="counter_message"></span></a><?php endif;?><?php if($openEmailBox===true){?><a href="javascript:void(0)" onclick="voiceMailCalls()" class="list-group-item btn-block pd84" style='margin:0px;'>V.Mails</a><?php }?>
 <?php /*if($openEmailBox===true){?><a href="javascript:void(0)" onclick="getNextInboxEmails('messages_container',jQuery(this),100)" class="list-group-item btn-block" style='padding:0px 8px 3px 8px;margin:0px;'>Next 100</a><?php }*/?>
 </div>  </div> </div> <div class="" style='padding:0;margin-top:0;margin-left:0px;z-index:1;float:left' id='listMainContainerModif'> <div class="panel panel-default panel-no-margin panel-blue-border" style=""> <?php if($openEmailBox===true  || in_array(23,$this->session->userdata['modules_assign'])):?> <div class="messages messages-list-leads"> <div data-padding="90" data-height="window" class="withScroll mCustomScrollbar _mCS_116" id="messages-list"> <div style="max-height:300px;min-height:300px;overflow-x:hidden!important;overflow-y:auto!important;max-width:100%" id="mCSB_116" class="mCustomScrollBox mCS-dark-2"> <div style="max-width:100%;overflow:hidden" class="mCSB_container messages_container"> <div class="loading-spinner" id="loading_spinner_heading_messages" style='display:none'> <img src="<?php echo $awsUrl?>images/ajax-loader.gif" alt=""> </div></div></div></div></div><?php endif;?></div></div><div class=" list-messages" style='padding:0;margin-top:0;margin-left:0px;margin-right:-1px;width:900px;float:left'> <div class="panel panel-default panel-no-margin panel-blue-border" id="old_lead" style='border-left:0px;'> <div class="messages"> <div data-padding="90" data-height="window" class="withScroll mCustomScrollbar _mCS_116" id="messages-boxlist"> <div style="height:300px;/*overflow-x:hidden!important;overflow-y:auto!important;*/overflow:auto!important;max-width:100%" id="mCSB_116" class="mCustomScrollBox mCS-dark-2"> <?php if((int)$this->session->userdata['user']['type']==9  || in_array(13,$this->session->userdata['modules_assign'])):?>
<script>
	var tableDT="";		
	function callRunLeadSave(t){
		if(leadGlobal>0){
			switch(_mainBtnParentElement){
				case 'from_litigation':
					submitData(t);
				break;
				case 'from_regular':
					console.log("From Market");
					submitDataMarket(t);
				break;
				case 'from_nonacquistion':
					submitFromData('from_nonacquistion',t);
				break;
			}
		}
	}
	
	function editingTypingEditFor(){
		jQuery('.assigned_for_editing').typing({
			delay:1500,
			start:function(){
				console.log('Start.......');
				console.log('CHANGE');
			},
			stop:function(){
				console.log('Stop editing in assigned for.......');
				assignedForUpdate(jQuery(this))
			}
		});
	}
	var $stupdTable;
	$(document).ready(function(){
		jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('input[type="text"],textarea').typing({
			delay:1000,
			start:function(){
				console.log('Start.......');
				console.log('CHANGE');
				
			},
			stop:function(){
				console.log('Stop.......');
				console.log("Change Price");
				changePriceUP(jQuery('#'+_mainBtnParentElement).find("#marketupfront_price"));
				callRunLeadSave();
			}
		});
		getCountOnImap();
		jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('input[type="checkbox"],select,.is-date').change(function(){
			console.log("Change Lead Checkbox");
			setTimeout(callRunLeadSave,100);
		});
		if(jQuery("#from_regular").find('#schedulerLink').length > 0){
			jQuery("#from_regular").find('#schedulerLink').on('keyup change paste',function(){
				setTimeout(callRunLeadSave,100);
			});
		}
		//sortMeLead();
		filter_lead_box();
		$stupdTable = jQuery("#all_type_list").stupidtable();
		scrollTableLoadData();
		jQuery("#search_from_all_lead").off("keyup").on("keyup",function(){
			allLeadSearchFromPanel(jQuery("#btnAllLeadSearchFromPanel"));
		});
	});
	
	var searchLoad;
	var stringSearch = {};
	function loadMoreData(){
		leadGlobal = 0;
		jQuery(".topbar-lead-name").html('');
		_page = jQuery("#all_type_list").parent().data("page");
		if(typeof _page=='undefined'){
			_page = 1;
		}	
		console.log(_page);
		_page++;		
		_search = jQuery("#search_from_all_lead").val();
		if(typeof _search=="undefined"){
			_search = "";
		}
		_orderFields="lead_name";
		_orderBy="asc";
		jQuery("#all_type_list").find("th").each(function(){
			if(jQuery(this).hasClass("sorting_asc")){
				_orderBy="asc";
				_orderFields = jQuery(this).find("a.sort_me").data("field");
				return false;
			}else if(jQuery(this).hasClass("sorting_desc")){
				_orderBy="desc";
				_orderFields = jQuery(this).find("a.sort_me").data("field");
				return false;
			}
		});
		/*if(typeof searchLoad=="object"){
			searchLoad.abort();
		}*/
		var postData = {sort_by:_orderBy,order:_orderFields,search:_search,page_no:_page,filter_search:JSON.stringify(stringSearch)};
		searchLoad = call(__baseUrl+'dashboard/load_search_leads',"POST",postData,getSearchLeadTable,"html");
		if(_page==0){
			_page = 1;
		}
		jQuery("#all_type_list").parent().data("page",_page);
	}
	function getSearchLeadTable(data,textStatus,xhr){
		if(data!=""){
			jQuery("#all_type_list tbody").append(data);	
			/*jQuery("#all_type_list").parent().scrollTop(0);	*/		
			leadsTableOneLineCells();
			runFixedHeaderWidthAdjustment();
			if(leadGlobal>0 && jQuery("#all_type_list").find("tr[data-id='"+leadGlobal+"']").hasClass('active')){
				checkLeadActivePosition();
			}
		}
	}	
	function filterTable(o,i){		
		jQuery("#all_type_list").find('thead').find('th').find('span').removeClass('textRed');
		jQuery("#all_type_list").find('thead').find('th').eq(i).find('span').addClass('textRed');
		stringSearch = {};
		jQuery("#sortingPopup").find('input[type="checkbox"]:checked').each(function(){			
			if(typeof stringSearch[jQuery(this).data('field')]!="undefined"){
				var getOldData = stringSearch[jQuery(this).data('field')];				
				if(getOldData.length>0){
					getOldData.push(jQuery.trim(jQuery(this).val()));
				} else {
					getOldData = [];
					getOldData.push(jQuery.trim(jQuery(this).val()));
				}
				stringSearch[jQuery(this).data('field')] = getOldData;
			} else {				
				getOldData = [];
				getOldData.push(jQuery.trim(jQuery(this).val()));
				stringSearch[jQuery(this).data('field')] = getOldData;				
			}			
		});	
		console.log("Old:"+stringSearch);
		jQuery("#all_type_list").find('thead').find('th').eq(i).find('div.multiSelect:hidden').find("input[type='checkbox']").prop('checked',false).removeAttr('checked');
		_iValid = false;
		if(stringSearch.length==0){
			_iValid = true;
		}
		var fieldName = jQuery("#all_type_list").find('thead').find('th').eq(i).find('a.sort_me').data("field");
		var searchValue = stringSearch[fieldName];
		if(typeof searchValue=="undefined"){
			searchValue = [];
		}
		if(searchValue.length>0){
			jQuery(searchValue).each(function(ind,sv){	
				jQuery("#all_type_list").find('thead').find('th').eq(i).find('div.multiSelect:hidden').find("input[type='checkbox']").each(function(){
					if(jQuery(this).val()==sv){
						jQuery(this).attr('checked','checked').prop('checked',true)
					}
				});
			});
		}
		stP = -1;
		if(jQuery("#sortingPopup").find('input[type="checkbox"]:checked').length==0){	
			jQuery("#all_type_list").find('thead').find('th').eq(i).find('span').removeClass('textRed');
		}		
		if(jQuery("#all_type_list").find('thead').find('th').find('div.multiSelect:hidden').find("input[type='checkbox']:checked").length==0){	
			jQuery("#all_type_list").find('thead').find('th').removeClass('textRed'); 
		} else {		
			jQuery("#all_type_list").find('thead').find('th').find('div.multiSelect:hidden').find("input[type='checkbox']:checked").each(function(){
				_mPt = jQuery(this).parent().parent().parent().parent().parent().parent();
				_fieldName = _mPt.find('a.sort_me').data('field');
				if(typeof stringSearch[_fieldName]=="undefined"){
					console.log("TIp");
					var getOldData =[];
					getOldData.push(jQuery(this).val());					
					stringSearch[_fieldName] = getOldData;
				} else {
					console.log("TIp1");
					var getOldData = stringSearch[_fieldName];
					_crrValue = jQuery(this).val();
					if(jQuery.inArray(_crrValue,getOldData)<0){
						if(_mPt.find('span').hasClass('textRed')==false){
							_mPt.find('span').addClass('textRed');
						}
						getOldData.push(_crrValue);
					}
					stringSearch[_fieldName] = getOldData;
				}
			});
		}
		var filteredLeads = [];
		var mainStaticFields = [];
		var staticFieldCol = [];
		console.log(stringSearch);
		for(var key in stringSearch){
			if (stringSearch.hasOwnProperty(key)) {
				var staticCols = ['lead_name','type','broker_contact'];
				if(key=='lead_name'){
					if(jQuery.inArray(0,staticFieldCol)<0){
						staticFieldCol.push(0);
					}
				} else if(key=='type'){
					if(jQuery.inArray(3,staticFieldCol)<0){
						staticFieldCol.push(3);
					}
				}else if(key=='broker_contact'){
					if(jQuery.inArray(6,staticFieldCol)<0){
						staticFieldCol.push(6);
					}
				}
				if(jQuery.inArray(key,staticCols)>=0){
					$values = stringSearch[key];
					for(i=0;i<$values.length;i++){
						mainStaticFields.push($values[i]);
					}
				}
			}
		}
		if(mainStaticFields.length>0){
			jQuery("#all_type_list").find('tbody tr').hide();
			if(jQuery.inArray(0,staticFieldCol)>=0){
				_searchValues = stringSearch.lead_name;
				console.log(_searchValues);
				if(_searchValues.length>0){
					jQuery.each(_searchValues,function(idx,filter){
						if(jQuery("#all_type_list").find('tbody tr[data-id="'+filter+'"]').length>0){
							jQuery("#all_type_list").find('tbody tr[data-id="'+filter+'"]').show();
							filteredLeads.push(parseInt(filter));
						}
					})
				} else {
					jQuery("#all_type_list").find('tbody tr').show();
				}
			} else {
				if(filteredLeads.length==0){
					jQuery("#all_type_list").find('tbody tr').show();
				}
			}
			console.log("After First"+filteredLeads);
			if(jQuery.inArray(3,staticFieldCol)>=0){
				_searchValues = stringSearch.type;
				if(_searchValues.length>0){
					if(filteredLeads.length==0){
						jQuery("#all_type_list").find('tbody tr').hide();
						jQuery.each(_searchValues,function(idx,filter){						
							jQuery("#all_type_list").find('tbody tr').each(function(index){		
								$row = $(this);
								var $tdElement = $row.find("td").eq(3).text();
								var matchedIndex = $tdElement.search(filter);
								console.log("Match Index:"+matchedIndex);
								if (matchedIndex >= 0) {
									filteredLeads.push(parseInt($row.data('id')));
									$row.show();								
								}
							})
						})
					} else {
						console.log(filteredLeads);
						_rremoveLeads = [];
						jQuery.each(filteredLeads,function(idx,id){
							$row = jQuery("#all_type_list").find('tbody tr[data-id="'+id+'"]');
							var $tdElement = $row.find("td").eq(3).text();
							var foundText = false;
							jQuery.each(_searchValues,function(idx,filter){
								var matchedIndex = $tdElement.search(filter);
								console.log("Lead find "+id+" Match for:"+filter+" Got result:"+matchedIndex);
								if (matchedIndex >=0) {								
									foundText = true
								}
							})
							if(foundText===false){
								_rremoveLeads.push(idx)
								$row.hide();
								/*console.log("Not found in:"+id);
								filteredLeads.splice(id,1);
								console.log("Remaining leads");
								console.log(filteredLeads);*/
							}
						});
						if(_rremoveLeads.length>0){
							jQuery.each(_rremoveLeads,function(idx,id){
								filteredLeads.splice(id,1);
							})
						}
					}
				} else {
					if(filteredLeads.length==0){
						jQuery("#all_type_list").find('tbody tr').show();
					}
				}
			} else {
				if(filteredLeads.length==0){
					jQuery("#all_type_list").find('tbody tr').show();
				}
			}
			if(jQuery.inArray(6,staticFieldCol)>=0){
				console.log("I am in Broker Filter");
				_searchValues = stringSearch.broker_contact;
				console.log("Search:"+_searchValues);
				if(_searchValues.length>0){
					if(filteredLeads.length==0){
						console.log("No filter lead");
						jQuery("#all_type_list").find('tbody tr').hide();
						jQuery.each(_searchValues,function(idx,filter){
							$row = jQuery("#all_type_list").find('tbody tr[data-b="'+filter+'"]');
							if($row.length>0){
								$row.show();
								filteredLeads.push(parseInt($row.data('id')));
							}
						});
						/*jQuery.each(_searchValues,function(idx,filter){						
							jQuery("#all_type_list").find('tbody tr').each(function(index){		
								$row = $(this);
								var $tdElement = $row.find("td").eq(6).text();
								console.log("Text inTD:"+$tdElement+" Search For:"+filter);
								var matchedIndex = $tdElement.search(filter);
								console.log("Match Index:"+matchedIndex);
								if (matchedIndex >= 0) {
									filteredLeads.push($row.data('id'));
									$row.show();								
								}
							})
						})*/
					}else {
						_rremoveLeads = [];
						jQuery.each(filteredLeads,function(idx,id){
							$row = jQuery("#all_type_list").find('tbody tr[data-id="'+id+'"]');
							var foundText = false;
							jQuery.each(_searchValues,function(idx,filter){
								_inxV = parseInt($row.attr('data-b'));
								if(_inxV==parseInt(filter)){
									if(foundText===false){
										foundText = true;
									}
								}
							})
							if(foundText===false){
								_rremoveLeads.push(idx)
								$row.hide();
								/*console.log("Not found in:"+id);
								filteredLeads.splice(idx,1);
								console.log("Remaining leads");
								console.log(filteredLeads);*/
							}
						})
						if(_rremoveLeads.length>0){
							jQuery.each(_rremoveLeads,function(idx,id){
								filteredLeads.splice(id,1);
							})
						}
					}
				}else {
					if(filteredLeads.length==0){
						jQuery("#all_type_list").find('tbody tr').show();
					}
				}
			} else {
				if(filteredLeads.length==0){
					jQuery("#all_type_list").find('tbody tr').show();
				}
			}
		} else {
			jQuery("#all_type_list").find('tbody tr').show();
		}
		for(var key in stringSearch){
			if (stringSearch.hasOwnProperty(key)) {
				if(jQuery.inArray(key,staticCols)<0){
					var $selectedField = jQuery("#all_type_list").find('thead th').find('a.sort_me[data-field="'+key+'"]');
					var $tdIndex = $selectedField.parent().index();
					$values = stringSearch[key];
					if(filteredLeads.length==0){
						for(i=0;i<$values.length;i++){
							$selectedVal = $values[i];
							//console.log('selectedVal:'+$selectedVal);
							switch($selectedVal){
								case 'blink':					
									jQuery("#all_type_list").find('tbody tr').each(function(){
										if(!jQuery(this).find('td').eq($tdIndex).hasClass('btn-blink')){
											jQuery(this).addClass('hi').hide();
										} else {
											filteredLeads.push(jQuery(this).data('id'));
											jQuery(this).show();
										}
									});
								break;
								case 'not_blink':
									jQuery("#all_type_list").find('tbody tr').each(function(){
										findL = true;
										if(jQuery(this).find('td').eq($tdIndex).text()==""){
											jQuery(this).hide();
											findL = false;
										}
										if(jQuery(this).find('td').eq($tdIndex).hasClass('btn-blink')){
											jQuery(this).hide();
											findL = false;
										}
										if(findL===true){
											filteredLeads.push(jQuery(this).data('id'));
											jQuery(this).show();
										}
									});
								break;
								case 'empty':					
									jQuery("#all_type_list").find('tbody tr').each(function(){
										if(jQuery(this).find('td').eq($tdIndex).text()!=""){
											jQuery(this).hide();
										} else {
											filteredLeads.push(jQuery(this).data('id'));
											jQuery(this).show();
										}
									});
								break;
								case 'all':
									jQuery("#all_type_list").find('tbody tr').show();
									filteredLeads=[];
								break;							
							}
						}
					} else {
						jQuery.each(filteredLeads,function(idx,id){
							var $row = jQuery("#all_type_list").find('tbody tr[data-id="'+id+'"]');
							for(i=0;i<$values.length;i++){
								$selectedVal = $values[i];
								switch($selectedVal){
									case 'blink':	
										if(!$row.find('td').eq($tdIndex).hasClass('btn-blink')){
											$row.hide();
											filteredLeads.splice(id,1);
										}
									break;
									case 'not_blink':
										if($row.find('td').eq($tdIndex).text()==""){
											$row.hide();
											filteredLeads.splice(id,1);
										}
										if($row.find('td').eq($tdIndex).hasClass('btn-blink')){
											$row.hide();
											filteredLeads.splice(id,1);
										}
									break;
									case 'empty':
										if($row.find('td').eq($tdIndex).text()!=""){
											$row.hide();
											filteredLeads.splice(id,1);
										}
									break;
									case 'all':
										$row.show();
										if(jQuery.inArray(id,filteredLeads)<0){
											filteredLeads.push(id);
										}
									break;	
								}
							}
						});
					}
				}
			}
		}
		
		runFixedHeaderWidthAdjustment()
		/*if(stringSearch.length>0){
			jQuery("#all_type_list").find('tbody tr').hide();
			jQuery.each(stringSearch,function(idx,filter){
				jQuery("#all_type_list").find('tbody tr td').each(function(){
					var $currentText = jQuery(this).text();
					console.log('@'+$currentText+'@'+filter+'@');
					$find = false;
					if($currentText.indexOf(filter)>-1){
						jQuery(this).parent().show();
						$find = true;
					}
					if($find===true){
						return '';
					}
				});
			});
		} else {
			jQuery("#all_type_list").find('tbody tr').show();
		}*/
		console.log(stringSearch);
		//loadMoreData();		
	}
	function resetTableFilter(o){
		stringSearch = [];	
		jQuery("#all_type_list").find('thead').find('th').find('div.multiSelect:hidden').find("input[type='checkbox']:checked").removeAttr('checked');
		jQuery("#all_type_list").find('thead').find('th').find('span').removeClass('textRed');
		jQuery("#search_from_all_lead").val('');
		jQuery("#all_type_list").parent().data("page",'-1');
		jQuery(this).data('oldScroll',0);
		jQuery("#all_type_list tbody").html("");
		releaseAll();
		loadMoreData();
	}
	</script>
	<?php 
		$leadHeadings = array(
						"column_0"=>"Seller",
						"column_1"=>"Portfolio",
						"column_2"=>"",
						"column_3"=>"",
						"column_4"=>"",
						"column_5"=>"Last",
						"column_6"=>"E",
						"column_7"=>"Broker Firm",
						"column_8"=>"Column 8",
						"column_9"=>"Column 9",
						"column_10"=>"Column 10",
						"column_11"=>"Column 11",
						"column_12"=>"Column 12",
						"column_13"=>"Column 13",
						"column_14"=>"Deadline",
						"column_15"=>"Column 15",
						"column_16"=>"Legal DD",
						"column_17"=>"Illustration DD",
						"column_18"=>"Tech DD",
						"column_19"=>"Market DD",
						"column_20"=>"Pdf DD",
						"column_21"=>"Comparables",
						"column_22"=>"Royalty Report",
						"column_23"=>"Intro Images",
						"column_24"=>"Intro DD",
						"column_25"=>"Column 25",
						"column_26"=>"Column 26",
						"column_27"=>"Column 27",
						"column_28"=>"Column 28",
						"column_29"=>"Column 29",
						"column_30"=>"Column 30",
						"column_31"=>"Column 31",
						"column_32"=>"Column 32",
						"column_33"=>"Column 33",
						"column_34"=>"Column 34",
						"column_35"=>"Column 35",
						"column_36"=>"Name, Title1",
						"column_37"=>"Name, Title2",
						"column_38"=>"Tech. / Markets"
						);
		if(count($getLeadColumnHeadings)>0){
			foreach($getLeadColumnHeadings as $heading){
				switch($heading->column_name){
					case 'seller':
						$leadHeadings['column_0'] = $heading->display_name;
					break;
					case 'lead_name':
						$leadHeadings['column_1'] = $heading->display_name;
					break;
					case 'serial_number':
						$leadHeadings['column_2'] = $heading->display_name;
					break;
					case 'attractive':
						$leadHeadings['column_3'] = $heading->display_name;
					break;
					case 'type':
						$leadHeadings['column_4'] = $heading->display_name;
					break;
					case 'lead_last_seen':
						$leadHeadings['column_5'] = $heading->display_name;
					break;
					case 'eou':
						$leadHeadings['column_6'] = $heading->display_name;
					break;
					case 'broker_contact':
						$leadHeadings['column_7'] = $heading->display_name;
					break;
					case 'column8':
						$leadHeadings['column_8'] = $heading->display_name;
					break;
					case 'column9':
						$leadHeadings['column_9'] = $heading->display_name;
					break;
					case 'column10':
						$leadHeadings['column_10'] = $heading->display_name;
					break;
					case 'column11':
						$leadHeadings['column_11'] = $heading->display_name;
					break;
					case 'column12':
						$leadHeadings['column_12'] = $heading->display_name;
					break;
					case 'column13':
						$leadHeadings['column_13'] = $heading->display_name;
					break;
					case 'column14':
						$leadHeadings['option_expiration_date'] = $heading->display_name;
					break;
					case 'column15':
						$leadHeadings['column_15'] = $heading->display_name;
					break;
					case 'column16':
						$leadHeadings['column_16'] = $heading->display_name;
					break;
					case 'column17':
						$leadHeadings['column_17'] = $heading->display_name;
					break;
					case 'column18':
						$leadHeadings['column_18'] = $heading->display_name;
					break;
					case 'column19':
						$leadHeadings['column_19'] = $heading->display_name;
					break;
					case 'column20':
						$leadHeadings['column_20'] = $heading->display_name;
					break;
					case 'column21':
						$leadHeadings['column_21'] = $heading->display_name;
					break;
					case 'column22':
						$leadHeadings['column_22'] = $heading->display_name;
					break;
					case 'column23':
						$leadHeadings['column_23'] = $heading->display_name;
					break;
					case 'column24':
						$leadHeadings['column_24'] = $heading->display_name;
					break;
					case 'column25':
						$leadHeadings['column_25'] = $heading->display_name;
					break;
					case 'column26':
						$leadHeadings['column_26'] = $heading->display_name;
					break;
					case 'column27':
						$leadHeadings['column_27'] = $heading->display_name;
					break;
					case 'column28':
						$leadHeadings['column_28'] = $heading->display_name;
					break;
					case 'column29':
						$leadHeadings['column_29'] = $heading->display_name;
					break;
					case 'column30':
						$leadHeadings['column_30'] = $heading->display_name;
					break;
					case 'column31':
						$leadHeadings['column_31'] = $heading->display_name;
					break;
					case 'column32':
						$leadHeadings['column_32'] = $heading->display_name;
					break;
					case 'column33':
						$leadHeadings['column_33'] = $heading->display_name;
					break;
					case 'column34':
						$leadHeadings['column_34'] = $heading->display_name;
					break;
					case 'column35':
						$leadHeadings['column_35'] = $heading->display_name;
					break;
				} 
			}
		}
	?>
	<div class="col-md-4 hide" id="search_lead_panel"><input type="text" id="search_from_all_lead" name="search_from_all_lead" class='form-control' placeholder="Search....." style='border-color:#efefef;'/> <a href='javascript://' id='btnAllLeadSearchFromPanel' onclick="allLeadSearchFromPanel(jQuery(this))" style='position: absolute;right: 10px;top:7px'><i class='glyph-icon icon-search'></i></a></div>
	<div style='position: fixed; z-index: 111;overflow: hidden;' id='headFixedPos'><table id="header-fixed" style='display:none;position:relative;z-index:112;top:-1px;table-layout:fixed;border-left:0px !important;border-right:0px !important;margin:0px !important' class='table dataTable '></table></div>
	<table class="table dataTable " id="all_type_list" style="border-left:none;border-right:0;table-layout:fixed;"> <thead> <tr> <th class="no-sort select-filter nosort sorting_asc" style="text-align:center;border-right:0;border-left:none;min-width:140px;max-width:150px;width:150px;" data-sort="string" data-sort-default="desc"> <div class="prelative"> 
	<a href="javascript://" class="mrg20L sort_me pull-left" data-field="seller_contact"><span style="/*width:55px;*/ display:inline-block"><?php echo $leadHeadings['column_0'];?></span></a><a id="tblLeadSearch" href='javascript://' class='' style='right:0;padding:0;min-width:0;border-radius:3px;width:18px;float:right;' onclick='return toggleTableFilter($(this))'> <i class="glyph-icon icon-search"></i></a><a class='' id="leadReset" style='padding:0;min-width:0;border-radius:3px;width:40px;font-size:11px;color:#2196F3 !important;float:right;margin-right:20px;' onclick='return resetTableFilter($(this))'>Reset</a></div><?php echo $this->filterCheckHtml($leadNamesFilter);?> </th><th class="no-sort select-filter nosort sorting_asc" style="text-align:center;border-right:0;border-left:none;min-width:225px;max-width:225px;width:225px;" data-sort="string" data-sort-default="desc"><a href="javascript://" class="mrg20L sort_me pull-left" data-field="lead_name"><span style="/*width:55px;*/ display:inline-block"><?php echo $leadHeadings['column_1'];?></span></a></th> <th style="text-align:left;border-right:0;border-left:none;min-width:45px;max-width:45px;width:45px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class=" sort_me" data-field="serial_number"><span title="<?php echo $leadHeadings['column_2'];?>" style="width:35px; display:inline-block"><?php echo $leadHeadings['column_2'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:20px;max-width:20px;width:20px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class=" sort_me" data-field="attractive"><span title="<?php echo $leadHeadings['column_3'];?>" style="width:10px; display:inline-block"><?php echo $leadHeadings['column_3'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:30px;max-width:30px;width:30px;" class='select-filter nosort ' data-sort="string"><a href="javascript://" class="sort_me" data-field="type"><span title="<?php echo $leadHeadings['column_4'];?>" style="width:20px; display:inline-block"><?php echo $leadHeadings['column_4'];?></span></a><?php echo $this->filterCheckHtml($typeFilter);?></th> <th style="text-align:left;border-right:0;border-left:none;min-width:55px;max-width:55px;width:55px;" class='select-filter nosort ukdate' data-sort-default="desc" data-sort="int"><a href="javascript://" class="sort_me" data-field="lead_last_seen"><span title="<?php echo $leadHeadings['column_5'];?>" style="width:25px; display:inline-block"><?php echo $leadHeadings['column_5'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:25px;max-width:25px;width:25px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="sort_me" data-field="eou"><span title="<?php echo $leadHeadings['column_6'];?>" style='width:15px;display:inline-block'><?php echo $leadHeadings['column_6'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:321px;max-width:321px;width:321px;" class='select-filter nosort' data-sort="string"><a href="javascript://" class=" mrg20L sort_me" data-field="broker_contact"><span title="<?php echo $leadHeadings['column_7'];?>" style='width:95px;display:inline-block'><?php echo $leadHeadings['column_7'];?></span></a><?php echo $this->filterCheckHtml($brokerFirmFilter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:75px;max-width:75px;width:75px;" class='select-filter nosort ukdate' data-sort="int"><a href="javascript://" class=" mrg20L sort_me" data-field="column8"><span title="<?php echo $leadHeadings['column_8'];?>" style="width:55px; display:inline-block"><?php echo substr($leadHeadings['column_8'],0,8);?></span></a><?php echo $this->filterCheckHtml($column8Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:85px;max-width:85px;width:85px;" class='select-filter nosort ukdate' data-sort="int"><a href="javascript://" class=" mrg20L sort_me" data-field="column9"><span title="<?php echo $leadHeadings['column_9'];?>" style="width:70px; display:inline-block"><?php echo substr($leadHeadings['column_9'],0,8);?></span></a><?php echo $this->filterCheckHtml($column9Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort ukint' data-sort="int"><a href="javascript://" class=" mrg20L sort_me" data-field="column10"><span title="<?php echo $leadHeadings['column_10'];?>" style="width:50px; display:inline-block"><?php echo $leadHeadings['column_10'];?></span></a><?php echo $this->filterCheckHtml($column10Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:80px;max-width:80px;width:80px;" class='select-filter nosort ukdate' data-sort="int"><a href="javascript://" class=" mrg20L sort_me" data-field="column11"><span title="<?php echo $leadHeadings['column_11'];?>" style="width:78px; display:inline-block"><?php echo $leadHeadings['column_11'];?></span></a><?php echo $this->filterCheckHtml($column11Filter);?></th> <th style="text-align:left;border-right:0;border-left:none;min-width:108px;max-width:108px;width:108px;" class='select-filter nosort ukdate' data-sort="int"><a href="javascript://" class=" mrg20L sort_me" data-field="column12"><span title="<?php echo $leadHeadings['column_12'];?>" style="width:50px; display:inline-block"><?php echo $leadHeadings['column_12'];?></span></a><?php echo $this->filterCheckHtml($column12Filter);?></th> <th style="text-align:left;border-right:0;border-left:none;min-width:90px;max-width:90px;width:90px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column13"><span title="<?php echo $leadHeadings['column_13'];?>"><?php echo $leadHeadings['column_13'];?></span></a><?php echo $this->filterCheckHtml($column13Filter);?></th> <th style="text-align:left;border-right:0;border-left:none;min-width:90px;max-width:90px;width:90px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column14"><span title="<?php echo $leadHeadings['column_14'];?>" style="color:#c20000;"><?php echo $leadHeadings['column_14'];?></span></a><?php echo $this->filterCheckHtml($column14Filter);?></th> <th style="text-align:left;border-right:0;border-left:none;min-width:105px;max-width:105px;width:105px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column15"><span title="<?php echo $leadHeadings['column_15'];?>"><?php echo $leadHeadings['column_15'];?></span></a><?php echo $this->filterCheckHtml($column15Filter);?></th> <th style="text-align:left;border-right:0;border-left:none;min-width:90px;max-width:90px;width:90px;" class='select-filter nosort' data-sort="int" data-sort-default="desc"><a href="javascript://" class="" data-field="column16"><span title="<?php echo $leadHeadings['column_16'];?>"><?php echo $leadHeadings['column_16'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:120px;max-width:120px;width:120px;" class='' data-sort="int" data-sort-default="desc"><a href="javascript://" class="sort_me" data-field="column17"><span title="<?php echo $leadHeadings['column_17'];?>"><?php echo $leadHeadings['column_17'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:90px;max-width:90px;width:90px;" class='' data-sort="int" data-sort-default="desc"><a href="javascript://" class="sort_me" data-field="column18"><span title="<?php echo $leadHeadings['column_18'];?>"><?php echo $leadHeadings['column_18'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='' data-sort="int" data-sort-default="desc"><a href="javascript://" class="sort_me" data-field="column19"><span title="<?php echo $leadHeadings['column_19'];?>"><?php echo $leadHeadings['column_19'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:85px;max-width:85px;width:85px;" class='' data-sort="int" data-sort-default="desc"><a href="javascript://" class="sort_me" data-field="column20"><span title="<?php echo $leadHeadings['column_20'];?>"><?php echo $leadHeadings['column_20'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:120px;max-width:120px;width:120px;" class='' data-sort="int" data-sort-default="desc"><a href="javascript://" class="sort_me" data-field="column21"><span title="<?php echo $leadHeadings['column_21'];?>"><?php echo $leadHeadings['column_21'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:125px;max-width:125px;width:125px;" class='' data-sort="int" data-sort-default="desc"><a href="javascript://" class="sort_me" data-field="column22"><span title="<?php echo $leadHeadings['column_22'];?>"><?php echo $leadHeadings['column_22'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:110px;max-width:110px;width:110px;" class='' data-sort="int" data-sort-default="desc"><a href="javascript://" class="sort_me" data-field="column23"><span title="<?php echo $leadHeadings['column_23'];?>"><?php echo $leadHeadings['column_23'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:90px;max-width:90px;width:90px;" class='' data-sort="int" data-sort-default="desc"><a href="javascript://" class="sort_me" data-field="column24"><span title="<?php echo $leadHeadings['column_24'];?>"><?php echo $leadHeadings['column_24'];?></span></a></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column25"><span title="<?php echo $leadHeadings['column_25'];?>"><?php echo $leadHeadings['column_25'];?></span></a><?php echo $this->filterCheckHtml($column25Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column26"><span title="<?php echo $leadHeadings['column_26'];?>"><?php echo $leadHeadings['column_26'];?></span></a><?php echo $this->filterCheckHtml($column26Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column27"><span title="<?php echo $leadHeadings['column_27'];?>"><?php echo $leadHeadings['column_27'];?></span></a><?php echo $this->filterCheckHtml($column27Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column28"><span title="<?php echo $leadHeadings['column_28'];?>"><?php echo $leadHeadings['column_28'];?></span></a><?php echo $this->filterCheckHtml($column28Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column29"><span title="<?php echo $leadHeadings['column_29'];?>"><?php echo $leadHeadings['column_29'];?></span></a><?php echo $this->filterCheckHtml($column29Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column30"><span title="<?php echo $leadHeadings['column_30'];?>"><?php echo $leadHeadings['column_30'];?></span></a><?php echo $this->filterCheckHtml($column30Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column31"><span title="<?php echo $leadHeadings['column_31'];?>"><?php echo $leadHeadings['column_31'];?></span></a><?php echo $this->filterCheckHtml($column31Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column32"><span title="<?php echo $leadHeadings['column_32'];?>"><?php echo $leadHeadings['column_32'];?></span></a><?php echo $this->filterCheckHtml($column32Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column33"><span title="<?php echo $leadHeadings['column_33'];?>"><?php echo $leadHeadings['column_33'];?></span></a><?php echo $this->filterCheckHtml($column33Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column34"><span title="<?php echo $leadHeadings['column_34'];?>"><?php echo $leadHeadings['column_34'];?></span></a><?php echo $this->filterCheckHtml($column34Filter);?></th><th style="text-align:left;border-right:0;border-left:none;min-width:100px;max-width:100px;width:100px;" class='select-filter nosort' data-sort="int"><a href="javascript://" class="mrg20L sort_me" data-field="column35"><span title="<?php echo $leadHeadings['column_35'];?>"><?php echo $leadHeadings['column_35'];?></span></a><?php echo $this->filterCheckHtml($column35Filter);?></th></tr> </thead> <tbody><?php $this->getHtmlLeadTable($incomplete);?>
	 </tbody> </table> <?php endif;?> </div> </div> </div> </div> </div> <!--div class="col-xs-6 list-messages" style='padding:0;margin-top:0'> <div class="panel panel-default panel-no-margin panel-blue-border" style='min-height:302px;max-height:302px;height:302px;overflow-y:scroll;margin-right:2px; position: relative; z-index: 10;'> <div id="other_list_boxes"></div> </div> </div--> </div> </div> <div class="col-lg-4 col-md-4 email-hidden-sm detail-message" style="padding:0;margin-top:0;margin-left:0px;border:1px solid #2196f3;background:#fff;border-left:0px;" id="displayEmail"></div> </div> </div> <?php
					
		else:		
		?> <script>window.location="<?php echo $service->createAuthUrl()?>";</script> <?php
		endif;
		die;
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */