<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller { 
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
									if(count($findLicenseAgreement)>0){
										/*Update*/
										$this->lead_model->updateCustomerLicenseAgreementByID(array('date'=>date('Y-m-d H:i:s'),'document'=>$fileUrl),$findLicenseAgreement->id);
									} else {
										/*Insert*/
										$price = '0.0';
										if((int)$acquisitionData->active_button==2){
											$price = round(1.5*$acquisitionData->cost_price, 3,PHP_ROUND_HALF_UP);
										}else if((int)$acquisitionData->active_button==3){
											$price = round(3*$acquisitionData->cost_price, 3,PHP_ROUND_HALF_UP);
										}
										if($price!='0.0'){
											$licenseData = array('lead_id'=>$getDealFlowData->lead_id,'company_id'=>$findCustomerData->company_id,'file_type'=>$getDealFlowData->license_type,'target'=>$getDealFlowData->available_for,'price'=>$price,'date'=>date('Y-m-d H:i:s'),'stage'=>$acquisitionData->active_button,'document'=>$fileUrl,'document_name'=>$documentName);
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
						$updateDate = date('Y-m-d H:i:s');
						$leadButtonData = $this->lead_model->findButtonID($driveMode['b'],$driveMode['l']);
						$newStatus = "";
						if(count($leadButtonData)>0){
							$originalButton = $this->lead_model->findOriginalButtonByButtonID($leadButtonData->button_id);
							if(count($originalButton)>0){
								$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButton->status_message.' <br/>';
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
							$data['status'] = $updateDate;
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
						$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButton->status_message.' <br/>';
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
			$findTemplate = $this->general_model->getTemplate($emailMode['r']);
			if(count($findTemplate)>0){
				$data['detail'] = $findTemplate;
				$updateDate = date('Y-m-d H:i:s');
				$this->load->model('lead_model');
				$leadButtonData = $this->lead_model->findButtonID($emailMode['b'],$emailMode['l']);
				$newStatus = "";
				if(count($leadButtonData)>0){
					$originalButton = $this->lead_model->findOriginalButtonByButtonID($leadButtonData->button_id);
					if(count($originalButton)>0){
						$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButton->status_message.' <br/>';
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
					if($activityType==1){
						$sendData = $this->lead_model->insetSalesActivity($event);
					} else if((int)$activityType==3){
						$data = $this->lead_model->insertPreSaleActivity($event);
					} else {
						$sendData = $this->lead_model->insertAcquistionActivity($event);
					}					
					$this->activityLog($event);
				}
				if($sendData>0){
					$this->lead_model->updateBox($thread->id,array('type'=>1,'lead_id'=>$box['old_thread']));					
					$user_history = array('lead_id'=>$box['old_thread'],'user_id'=>$this->session->userdata['id'],'message'=>"Add email into acquisition activity.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
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
		$params= array();
		switch((int)$op){
			case 1:
				if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):
					$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl','folder'=>'[Gmail]/Sent Mail');
				endif;
			break;
			case 2:
				if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):
					$params = array('mailbox'=>$hostname,'username'=>$this->config->item('operations_email'),'password'=>$this->config->item('operations_password'),'encryption'=>'ssl','folder'=>'[Gmail]/Sent Mail');
				endif;
			break;
		}
		$this->load->library('Imap',$params);
		$sendDate = date('d F Y',strtotime($date));
		if($this->imap->isConnected()){
			$results = $this->imap->searchEmails('TO "'.$toUsers[0].'" SUBJECT "'.$subject.'" SINCE "'.$sendDate.'"');
			$mainMessage=array();
			if(count($results)>0){
				$mainMessage = $results[count($results) - 1];
			}
			if(count($mainMessage)==0 && !isset($mainMessage['date'])){	
				$results = $this->imap->searchEmails('TO "'.$toUsers[0].'" SINCE "'.$sendDate.'"');
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
			$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl');
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
			$params= array();
			switch((int)$box['t']){
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
					$this->imap->moveMessage($box['msg_no'],'Leads');
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
				$getData = array('customer');
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
							$getRevisedRequestDocument = $this->lead_model->findRequestFromCheckAvailability($getRequest->request_id,'id');
							if(count($getRevisedRequestDocument)>0){
								$this->lead_model->updateCheckAvailabilityRequest(array('customer_id'=>$customerR),$getRequest->request_id);
								$this->lead_model->updateCheckAvailabilityRequestByEmail(array('customer_id'=>$customerR),$getRequest->email);
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
					$availability = 1;
					if(isset($post['available']) && $post['available']=="yes"){
						$availability = 2;
					}
					$this->lead_model->updateCheckAvailabilityRequest(array('availability'=>$availability,'status'=>2),$post['i']);
					/*Insert entry in deal flow*/
					$dealFlow = array();
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
					$dealFlow['created_date'] = date('Y-m-d H:i:s');
					$dealFlow['modified_date'] = '0000-00-00 00:00:00';
					$data['id'] = $this->lead_model->insertCustomerDealFlow($dealFlow);
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
	
	function delete_revised_document_request(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();
			if(isset($post['l']) && $post['l']>0){
				$this->load->model('lead_model');
				$data = $this->lead_model->deleteRevisedDocumentRequest($post['l']);
			}			
		}
		echo $data;
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
										$getRevisedRequestDocument = $this->lead_model->findRequestFromCheckAvailability($getRequest->request_id,'id');
										if(count($getRevisedRequestDocument)>0){
											$this->lead_model->updateCheckAvailabilityRequest(array('customer_id'=>$customerR),$getRequest->request_id);
											$this->lead_model->updateCheckAvailabilityRequestByEmail(array('customer_id'=>$customerR),$getRequest->email);
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
		if(isset($_POST) && count($_POST)>0){
			if((int)$this->input->post('inta')==1){
				$user_data = $this->session->userdata;
				$user_data['initialise_email'] = 1;
				$this->session->set_userdata($user_data);
				/**/
				$this->load->model('user_model');
				$this->user_model->updateAllLogTime($this->session->userdata['id']);
				/**/
			}
		}
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
		$user_data['email_for_signature'] = $user->email_for_signature;
		$user_data['title'] = $user->title;
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
								$getImageFolderInfo = $service->createSubFolder('image',$fileParent);
								if($getImageFolderInfo){
									$service->setAdditionalPermissions($getImageFolderInfo, "","writer","anyone");
									$this->lead_model->from_litigation_update($lead_id,array("image_folder"=>$getImageFolderInfo));
								}
								$getPdfFolderInfo = $service->createSubFolder('pdf',$fileParent);
								if($getPdfFolderInfo){
									$service->setAdditionalPermissions($getPdfFolderInfo, "","writer","anyone");
									$this->lead_model->from_litigation_update($lead_id,array("pdf_folder"=>$getPdfFolderInfo));
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
												$urlName = "http://www.synpat.com".$urlName;
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
			if(count($allRequestData)>0){
				$newPotentialData = array('company_name'=>$allRequestData->company_name,'person_name'=>$allRequestData->person_name,'person_phone'=>$allRequestData->person_phone,'person_email'=>$allRequestData->person_email,'message'=>$allRequestData->message,'file'=>$fileURL,'create_date'=>$allRequestData->create_date,'send_date'=>date('Y-m-d H:i:s'),'type'=>$allRequestData->type,'license_id'=>$allRequestData->license_id);
				$resp = $this->lead_model->insertPotentialParticipant($newPotentialData);
				if($resp>0){					
					$this->lead_model->deleteRequestToParticipate($ID);
				}
			}
		}
		return $resp;
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
			$request = $this->lead_model->getRevisedDocumentByID($postData['i'],'message,license_aggreement,strategic_aggreement,request_aggreement,program_aggreement,license_id,customer_id,type,file_name,create_date,approved,');
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
						
						/*
						$fileInfo = pathinfo($file);
						$filename = $fileInfo['basename'];
						$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
						if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename)){
							$dataFileUpload = $this->fileUploadFromFTPAndDrive($file,$filename,$postData['l'],$request);
							if(is_object($dataFileUpload) && isset($dataFileUpload->id) && !empty($dataFileUpload->id)){
								$licenseUpload = array('file_url'=>$dataFileUpload->alternateLink,'id'=>$dataFileUpload->id,'name'=>$dataFileUpload->title);	
							}
						}*/
					}
					if(!empty($strategic_aggreement)){
						$file = $strategic_aggreement;
						$ID = $this->getFileIDFromUrl($file);
						$strategicUpload = array('file_url'=>$file,'id'=>$ID,'name'=>"SLA");
						/*$fileInfo = pathinfo($file);
						$filename = $fileInfo['basename'];
						$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
						if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename)){
							$dataFileUpload = $this->fileUploadFromFTPAndDrive($file,$filename,$postData['l'],$request);
							if(is_object($dataFileUpload) && isset($dataFileUpload->id) && !empty($dataFileUpload->id)){
								$strategicUpload = array('file_url'=>$dataFileUpload->alternateLink,'id'=>$dataFileUpload->id,'name'=>$dataFileUpload->title);	
							}
						}*/
					}
					if(!empty($request_aggreement)){
						$file = $request_aggreement;
						$ID = $this->getFileIDFromUrl($file);
						$requestUpload = array('file_url'=>$file,'id'=>$ID,'name'=>"RTP");
						/*$fileInfo = pathinfo($file);
						$filename = $fileInfo['basename'];
						$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
						if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename)){
							$dataFileUpload = $this->fileUploadFromFTPAndDrive($file,$filename,$postData['l'],$request);
							if(is_object($dataFileUpload) && isset($dataFileUpload->id) && !empty($dataFileUpload->id)){
								$requestUpload = array('file_url'=>$dataFileUpload->alternateLink,'id'=>$dataFileUpload->id,'name'=>$dataFileUpload->title);	
							}
						}*/
					}
					if(!empty($program_aggreement)){
						$file = $program_aggreement;
						$ID = $this->getFileIDFromUrl($file);
						$programUpload = array('file_url'=>$file,'id'=>$ID,'name'=>"PPP");
						/*$fileInfo = pathinfo($file);
						$filename = $fileInfo['basename'];
						$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
						if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename)){
							$dataFileUpload = $this->fileUploadFromFTPAndDrive($file,$filename,$postData['l'],$request);
							if(is_object($dataFileUpload) && isset($dataFileUpload->id) && !empty($dataFileUpload->id)){
								$programUpload = array('file_url'=>$dataFileUpload->alternateLink,'id'=>$dataFileUpload->id,'name'=>$dataFileUpload->title);	
							}
						}*/
					}
								
					$fileURL = '';
					$getLeadInfo = $this->lead_model->getLeadData($postData['l']);
					if(count($getLeadInfo)>0){
						$note = $request->message;
						if(!empty($licenseUpload['file_url'])){
							$fileURL = $licenseUpload['file_url'];
							$note = $note.'<br/><a  href="javascript://" data-file-id="'.$licenseUpload['id'].'" onclick=\'open_drive_files("'.trim($licenseUpload['file_url']).'");\' data-href="'.$licenseUpload['file_url'].'" data-mime="" target="_blank" style="color:#2196f3"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$licenseUpload['name'].'</a>';		
						}
						if(!empty($strategicUpload['file_url'])){
							$fileURL = $strategicUpload['file_url'];
							$note = $note.'<br/><a  href="javascript://" data-file-id="'.$strategicUpload['id'].'" onclick=\'open_drive_files("'.trim($strategicUpload['file_url']).'");\' data-href="'.$strategicUpload['file_url'].'" data-mime="" target="_blank" style="color:#2196f3"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$strategicUpload['name'].'</a>';		
						}
						/*if(!empty($requestUpload['file_url'])){
							$note = $note.'<br/><a  href="javascript://" data-file-id="'.$requestUpload['id'].'" onclick=\'open_drive_files("'.trim($requestUpload['file_url']).'");\' data-href="'.$requestUpload['file_url'].'" data-mime="" target="_blank" style="color:#2196f3"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$requestUpload['name'].'</a>';		
						}
						if(!empty($programUpload['file_url'])){
							$note = $note.'<br/><a  href="javascript://" data-file-id="'.$programUpload['id'].'" onclick=\'open_drive_files("'.trim($programUpload['file_url']).'");\' data-href="'.$programUpload['file_url'].'" data-mime="" target="_blank" style="color:#2196f3"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$programUpload['name'].'</a>';		
						}*/							
						$saveData = array('lead_id'=>$postData['l'],'company_id'=>$postData['c'],'contact_id'=>$postData['p'],'type'=>6,'note'=>$note,'user_id'=>$this->session->userdata['id'],'subject'=>$getLeadInfo->lead_name,'activity_date'=>date('Y-m-d H:i:s'));
						$dataSales = $this->lead_model->insetSalesActivity($saveData);
						$this->activityLog($saveData);
						if($dataSales>0){
							$data['id'] = $dataSales;
							$this->load->model('user_model');
							$user_history = array('lead_id'=>$postData['l'],'user_id'=>$this->session->userdata['id'],'message'=>'Add Email in sales activity','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);
							/*$this->lead_model->deleteRevisedDocumentByID($postData['i']);*/
							/*Update Revised Document with send date and bold for customer and read by synpat*/
							if(isset($postData['e']) && $postData['e']>0){
								$emailID = $postData['e'];
								$emailDate = $this->lead_model->findEmailDate($emailID);
								$this->lead_model->updateRevisedDocumentRequest(array("confirm_date"=>$emailDate,"status"=>2),$postData['i']);
								if(!empty($fileURL)){
									/*Update Customer Transaction*/
									/*$this->lead_model->updateCustomerTransactionRequest(array("user_send"=>2),$fileURL);*/
									/*Get data from revised document and add or update in deal flow.*/
									$checkRecordInDeal = $this->lead_model->findCustomerDealFlowByUrlAndCustomerID($fileURL,$request->customer_id,'id');
									if(count($checkRecordInDeal)==0){
										$dealFlow = array();
										$dealFlow['customer_id'] = $request->customer_id;
										$dealFlow['license_type'] = $request->type;
										$dealFlow['user_send'] = 2;
										$dealFlow['customize_file'] = $fileURL;
										$dealFlow['customize_filename'] = $request->file_name;
										$dealFlow['agreement_status'] = 1;
										$dealFlow['availability'] = 2;
										$dealFlow['created_date'] = $request->create_date;
										$dealFlow['lead_id'] = $postData['l'];
										$this->lead_model->insertCustomerDealFlow($dealFlow);
									} else {
										$this->lead_model->updateCustomerDealFlow(array('user_send'=>2),$checkRecordInDeal->id);
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
			$request = $this->lead_model->findRequestToParticipantById($postData['i'],'file,type,message');
			if($resp){
				/*$request = json_decode($resp);*/
				if(count($request)>0){
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
										$note = $request->message.'<br/><a  href="javascript://" data-file-id="'.$getUploadFileData->id.'" onclick=\'open_drive_files("'.trim($fileURL).'");\' data-href="'.$getUploadFileData->alternateLink.'" data-mime="'.$getUploadFileData->mimeType.'" target="_blank" style="color:#2196f3"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$getUploadFileData->title.'</a>';
										$saveData = array('lead_id'=>$getLeadData->id,'company_id'=>$postData['c'],'contact_id'=>$postData['p'],'type'=>6,'note'=>$note,'user_id'=>$this->session->userdata['id'],'subject'=>$getLeadData->lead_name,'activity_date'=>date('Y-m-d H:i:s'));
										$dataSales = $this->lead_model->insetSalesActivity($saveData);
										$this->activityLog($saveData);
										if($dataSales>0){
											/*current_requesting_companies*/
											$this->load->model('user_model');
											$this->potentialParticipant($postData['i'],$getLeadData->id,$getUploadFileData->alternateLink);
											$data = array("error"=>0,"id"=>$dataSales,"message"=>"");
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
			$updateData = $this->lead_model->updatePotentialData(array('payment_notice'=>date('Y-m-d H:i:s')),$postData['i']);
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
			if((int)$postData['i']>0 && !empty($postData['p'])){
				$this->load->model('lead_model');
				$approval = 0;
				if($postData['p']=="yes"){
					$approval = 1;
				}
				$data = $this->lead_model->updateRevisedDocumentRequest(array("approved"=>$approval),$postData['i']);	
				$getRevisedData = $this->lead_model->getRevisedDocumentByID($postData['i'],'type,license_aggreement,strategic_aggreement');
				if(count($getRevisedData)>0){
					$file = "";
					if($getRevisedData->type==2){
						$file = $getRevisedData->license_aggreement;
					} else if($getRevisedData->type==3){
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
							if(count($getPermissionList)>0){
								$allFilesRemovePermission = array();
								foreach($getPermissionList as $permission){
									if(count($permission->additionalRoles)>0 && $permission->type="anyone"){
										$allFilesRemovePermission[] = array('id'=>$fileID,'permission_id'=>$permission->id); 
										break;
									}
								}
								if(count($allFilesRemovePermission)>0){
									$service->batchRequestForRemovePermissions($allFilesRemovePermission);
								}
								if($approval==1){
									/*Can View only*/
									$service->setPermissions($fileID,null,"reader","anyone");
								} else if($approval==0){
									/*Can edit*/
									$service->setAdditionalPermissions($fileID, '', 'reader', $type = 'anyone');
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
		if($t<=3){
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
		}
		$data['availability'] = array();
		$data['availability_confirmed'] = array();
		$data['license_list'] = array();
		if($t==4){
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
						if($docket['regular_license_starts']=="" || $docket['regular_license_starts']=="Invalid date"){
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
						if(isset($docket['status']) && $docket['status']==1){
							$updateData = $this->acquisition_model->updateData($lead_id,array('seller_asking_price'=>$marketData['market']['expected_price'],'option_expiration_data'=>$marketData['market']['option_expiration_date'],'regular_license_starts'=>$docket['regular_license_starts'],'late_license_starts'=>$docket['late_license_starts'],'active_button'=>$docket['active_button']));
						} else {
							if($docket['category']==0){
								$docket['category'] = $getAcqusitionData['acquisition']->category;
							}
							$updateData = $this->acquisition_model->updateData($lead_id,array('seller_asking_price'=>$marketData['market']['expected_price'],'option_expiration_data'=>$marketData['market']['option_expiration_date'],'regular_license_starts'=>$docket['regular_license_starts'],'late_license_starts'=>$docket['late_license_starts'],'active_button'=>$docket['active_button'],'category'=>$docket['category']));
						}
												
						$lead_data = $this->lead_model->getLeadDataWithOptions($lead_id,'l.serial_number');
						$this->load->model('opportunity_model');
						$docketData = $this->opportunity_model->updateLicenseAccessCode(array('asking_price'=>$marketData['market']['expected_price'],'expiration_date'=>$marketData['market']['option_expiration_date'],'active_button'=>$docket['active_button']),0,$lead_data->serial_number);
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
									$urlName = "http://synpat.com".$urlName;
								}
								$template =  str_replace('link-data-href=""',"href='".$urlName."'",$template);
								$getTemplate->template_html = $template;
								$getTemplate = (array)$getTemplate;
								$this->general_model->updateTemplate($getTemplate,$getTemplate['id']);
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
			$data['d'] = $this->lead_model->from_litigation_update($this->input->post('l'),array('patent_data'=>''));
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
									$urlName = "http://synpat.com".$urlName;
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
		if(isset($_POST) && count($_POST)>0){			
			if(!isset($_SESSION)){
				session_start();
			}
			$popEmail=0;
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
			/*check Activity Type*/
			$date = date('Y-m-d H:i:s');
			
			switch((int)$activityType){
				case 1:
					/*SALES ACTIVITY*/
					if($this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])){
						require_once(APPPATH.'libraries/PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php');
						$mail = new PHPMailer;
						if(isset($email['message_id'])){
							$mail->InReplyTo = $email['message_id'];
						}
						if(isset($email['reference'])){
							$mail->References = $email['reference'];
						}
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
								
								$send = $this->searchImapEmails(1,$email['subject'],$strToMail,$date,$leadID,1,1);
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
				case 2:
				default:
					/*ACQUSITION ACTIVITY*/
					/*Check User*/
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
								$send  = $service->sendMessage($email);								
								if(is_object($send)){
									if(isset($another['sys']) && $another['sys']!='0'){
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
									}
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
					} else if(in_array(26,$this->session->userdata['modules_assign'])){
						/*IMAP USER*/
						require_once(APPPATH.'libraries/PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php');
						$mail = new PHPMailer;
						if(isset($email['message_id'])){
							$mail->InReplyTo = $email['message_id'];
						}
						if(isset($email['reference'])){
							$mail->References = $email['reference'];
						}
						$this->config->load('config');
						$username=$this->config->item('operations_email');
						$password=$this->config->item('operations_password');
						$FROM = $this->config->item('operations_email');
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
								$strMailContent .=" <br/><div class='gmail_chipgmail_drive_chip'style='width:396px;height:18px;max-height:18px;background-color:#f5f5f5;padding:5px;color:#222;font-family:arial;font-style:normal;font-weight:bold;font-size:13px;border:1px solid #ddd;line-height:1'><a href='".$drive['href']."' target='_blank' style='display:inline-block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;text-decoration:none;padding:1px 0px;border:none;width:100%'><img style='vertical-align: bottom; border: none;' src='".$drive['img']."'>&nbsp;<span dir='ltr' style='color:#15c;text-decoration:none;vertical-align:bottom'>".$drive['title']."</div></span></div> ";
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
								$send = $this->searchImapEmails(2,$email['subject'],$strToMail,$date,$leadID,1,1);
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
			if($popEmail>0){
				/*INSERT USER HISTORY*/
				$this->load->model('user_model');
				$this->load->model('lead_model');
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
				if(isset($another['legal_log']) && (int) $another['legal_log']>0){
					/*$totalPatents = $another['legal_patents'];*/
					$getList = $this->opportunity_model->getChartLeft($leadID);
					$totalPatents = 0;
					if(count($getList)>0){
						foreach($getList as $pat){
							$a = (int)$pat->patents + (int)$pat->applications;
							$totalPatents = $totalPatents + $a;
						}
					}
					$projectType = $email['subject'];
					if(!empty($projectType)){						
						/*Check file name and enter in lead open project table
							1=>'Patent List',2=>'Technical DD',3=>'Legal DD',4=>'Illustration',5=>'Royalty report',6=>'List of Invitees'
						*/
						$fileType = 0;
						if(count($allAnchor)>0){
							foreach($allAnchor as $file){
								$attachFileHref = strtolower(strtoupper($file['href']));
								$attachFileName = strtolower(strtoupper($file['title']));
								if(strpos($attachFileName,'patent')!==false){
									$fileType = 1;
								} else if(strpos($attachFileHref,'techdd')!==false){
									$fileType = 2;
								} else if(strpos($attachFileHref,'legaldd')!==false){
									$fileType = 3;
								} else if(strpos($attachFileHref,'illustrationdd')!==false){
									$fileType = 4;
								} else if(strpos($attachFileName,'royalty')!==false){
									$fileType = 5;
								} else if(strpos($attachFileName,'invitees')!==false){
									$fileType = 6;
								} else if(strpos($attachFileName,'seller')!==false){
									$fileType = 7;
								}else if(strpos($attachFileHref,'?edit')!==false){
									$fileType = 8;
								}else if(strpos($attachFileHref,'comparedd')!==false){
									$fileType = 9;
								}else if(strpos($attachFileHref,'pdfdd')!==false){
									$fileType = 10;
								}else if(strpos($attachFileHref,'introimages')!==false){
									$fileType = 11;
								}else if(strpos($attachFileHref,'marketdd')!==false){
									$fileType = 12;
								}else if(strpos($attachFileHref,'dictionarydd')!==false){
									$fileType = 13;
								}
							}
						}
						if($fileType>0){
							$updateDataInDocket = array();
							$accessCode = '12345';
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
									$updateDataInDocket = array('market_access_code'=>$accessCode,'images_email_address'=>'');
								break;	
								case 13:
									/*dictionarydd*/
									$updateDataInDocket = array('dictionary_access_code'=>$accessCode,'images_email_address'=>'');
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
											$projectEntry = $this->lead_model->insertOpenProjectData(array('lead_id'=>$leadID,'type'=>$fileType,'contact_id'=>$contactDetails->id));
											
											/**
												*If FileType=>4 for illustrationComplete
												*Find All files from Illustration Folder and give permission to this user for edit and remove Permissions for other users if granted											
											**/
											if($fileType==4){
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
		echo $popEmail;
		die;
	}
	
	private function removeAndGrantIllustrationPermissions($leadID,$contactEmail){	
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();
		$this->load->model('lead_model');
		$getLastUserOpenProject = $this->lead_model->findLastOpenProject($leadID,4,1);
		if(count($getLastUserOpenProject)>0){
			$getLeadFolderID = $this->lead_model->getLeadDataWithOptions($leadID,'l.folder_id');
			if(count($getLeadFolderID)>0){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$q = "title='Illustration' and mimeType = 'application/vnd.google-apps.folder'";
				$findFolders = $service->searchFileIDFromChildern($getLeadFolderID->folder_id,$q);
				if(count($findFolders)==1){
					$folderIllustrationID = $findFolders[0]->id;
					$q = "title  contains  'Synpat - Claim Illustration' and mimeType = 'application/vnd.google-apps.presentation'";
					$listFiles = $service->searchFileIDFromChildern($folderIllustrationID,$q);
					$allFilesRemovePermission = array();
					$allFilesAddPermission = array();
					if(count($listFiles)>0){ 
						foreach($listFiles as $file){							
							$getPermissionsList = $service->getPrmissionsList($file->id);
							if(count($getPermissionsList)>0){
								foreach($getPermissionsList as $permission){
									if($permission->emailAddress==$getLastUserOpenProject->email || (!empty($getLastUserOpenProject->secondary_email) && $permission->emailAddress==$getLastUserOpenProject->secondary_email)){
										$allFilesRemovePermission[] = array('id'=>$file->id,'permission_id'=>$permission->id); 
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
					$thread_id = $message['thread_id'];
					$getMessageData = $message['content'];
					$parts = $getMessageData->getPayload()->getParts();
					$content[] = array("message_id"=>$message['message_id'],"labelIds"=>$message['labelIds'],"header"=>$message['header'],"body"=>$message['body'],"attachments"=>$attachmentsConnect,'ppp'=>$parts);
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
		if((int)$this->session->userdata['type']!=9 && $this->session->userdata['type']!=8){
			$incomplete = $this->lead_model->findIncompleteANDCompleteListAccUser($this->session->userdata['id']);
		} else{
			$incomplete = $this->lead_model->findIncompleteANDCompleteList('Market');
		}
		$openEmailBox = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(11,$this->session->userdata['modules_assign'])){
				$openEmailBox = false;
			}
		}
		
	  $this->config->load('config');
	  /*$awsUrl = $this->config->item('aws_server_url');*/
	  $awsUrl = $this->config->item('aws_server_cdn');

	?><style>.circle {width: 10px;height: 10px;-moz-border-radius: 50px;-webkit-border-radius: 50px;border-radius: 50px;}li.docDragable.acive a{font-weight:bold;}.red{background:#d9534f;}.green{background: green;}#all_type_list thead tr th.header{padding:5px;display:table-cell;cursor:hand;cursor:pointer}#all_type_list thead tr th.headerSortUp,#all_type_list thead tr th.headerSortDown{background:#acc8dd}.attachment-list-item{float:left;width:100%}.attachment-list-item a{float:left;width:95%}.dpDropdown {
  position: absolute;
  top:50%;
  transform: translateY(-50%);
    left: 10px;
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
		}showDataClickPrevent();});}function initAttachRemove(){jQuery(document).ready(function(){jQuery("ul.attachment-list").find("li").mouseover(function(){jQuery(this).find(".remove-attachment").removeClass("hide")}).mouseleave(function(){jQuery(this).find(".remove-attachment").addClass("hide")})})}function deleteMe(a){a.parent().parent().remove()}function initDragDrop(){/*$(".draggable").draggable({revert:true,zIndex:9999});*/$(".label-dropable").droppable({hoverClass:"drop-hover",tolerance:"pointer",drop:function(a,b){b.draggable.css("display","none");_thread=b.draggable.attr("data-id");_label=jQuery(this).attr("data-title");_active=jQuery.trim(jQuery(".emails-group-container").find("a.active").html());if(_thread!=undefined&&_thread!=""&&_label!=undefined&&_label!=""&&_active!=undefined&&_active!=""){jQuery.ajax({type:"POST",url:__baseUrl+"dashboard/moveThreadDiff",data:{thread:b.draggable.attr("data-id"),label:_label,active:_active},cache:false,success:function(e){if(e>0){b.draggable.remove()}else{b.draggable.css("display","block");b.draggable.css("top","0px");b.draggable.css("left","0px")}}})}}});
$("#taskDocUrl").droppable({hoverClass:"drop-hover",drop:function(a,b){if(b.draggable.parent().hasClass('todo-box-1') && b.draggable.find('a').length>0){jQuery(this).val(b.draggable.find('a').attr('data-href'));}}});
/*$(".droppable").droppable({
	hoverClass: "drop-hover",
	accept:function(d) { 
		// console.log(!$('#gmail_message_modal').hasClass('sb-active'));
        if(!$('#gmail_message_modal').hasClass('sb-active')) {
    		return true;
		}
    },
	drop:function(a,b){
		jQuery("#other_list_boxes").find("table").find("tr").find("td").removeClass("active");/*if(jQuery("#marketLead").length>0){jQuery("#marketLead").get(0).reset()}*//*	jQuery(".messages-list-leads").find(".message-item").each(function(){jQuery(this).removeClass("message-active");jQuery(this).find("h5").addClass("c-dark");jQuery(this).find("h4").addClass("c-dark");jQuery(this).find("p").addClass("c-gray");jQuery(this).find("a").addClass("c-dark")});	jQuery("#subject").empty();jQuery(".message_detail").empty().html('<div class="loading-spinner" id="loading_spinner" style="display:none;"><img src="<?php echo $awsUrl; ?>images/ajax-loader.gif" alt=""></div>');jQuery("#messages-boxlist").find("ul.todo-box").find("li").each(function(){jQuery(this).removeClass("active")});if(jQuery(this).hasClass("old_lead")){_neLD=b.draggable.attr("data-id");_dateEmail=b.draggable.attr("data-date");if(_dateEmail==undefined){_dateEmail=""}_newObject=jQuery(this);if(b.draggable.hasClass("driveDragable")&&jQuery(this).attr("data-id")!=undefined&&parseInt(jQuery(this).attr("data-id"))>0&&jQuery("#gmail_message_modal").hasClass("sb-active")==false){} else if(jQuery(this).attr('data-id')!=undefined && parseInt(jQuery(this).attr('data-id'))>0 && jQuery(this).find('td').length>1 && b.draggable.attr('data-id')!=undefined && b.draggable.attr('data-id')!="" && b.draggable.attr('data-message-id')!=undefined){/*_mainActivity = parseInt(jQuery("#activityMainType").val());*/
/*_fromEmail = b.draggable.find('h5.c-dark').find('a.c-dark').html();
_emailFrom = "";
if(_fromEmail.indexOf('<')>=0){
	_start = _fromEmail.indexOf('<')
	_end = _fromEmail.indexOf('></');
	_emailFrom = _fromEmail.substring(_start+1,_end);
}
jQuery("#moveEmailPopup").modal('show');
_lID = jQuery(this).attr('data-id');
jQuery.ajax({
	type:"POST",url:__baseUrl+"dashboard/linkWithMessage",
	data:{old_thread:_lID,thread:b.draggable.attr('data-id'),date:b.draggable.attr('data-date'),t:2,from_email:_emailFrom},
	success:function(et){
		jQuery("#moveEmailPopup").modal("hide");
		if(et!=""){
			_send=jQuery.parseJSON(et);
			if(_send.send>0){				
				_newObject.addClass('active');
				_aObject = _newObject.find('a');
				threadDetail(_aObject,"",1);
				if(b.draggable.attr('data-task')!='undefined' && b.draggable.attr('data-task')==1){
					leadGlobal = _lID;
					openTaskModal();
					jQuery("#taskEmailId").val(_send.send);
				}
				b.draggable.remove();
			} else{
				if(typeof _send.message!='undefined'){
					alert(_send.message);
				} else {
					alert("Please try after sometime");
				}				
			}
		} else {
			alert("Please try after sometime")
		}
	}
});}            }}});*/$("#attach_droppable").droppable({hoverClass:"drop-hover",drop:function(e,j){var b=j.draggable.find("a").attr("href");var a=j.draggable.html();_file_name=j.draggable.find('a').html();if($(this).find("ul").length>0){$(this).find("ul").append("<li class='attachment-list-item'>"+a+" <span class='remove-attachment hide pull-right'><a class='' onclick='deleteMe(jQuery(this))'><i class='glyph-icon icon-close'></i></a></span></li>")}else{$(this).append("<ul class='attachment-list'><li class='attachment-list-item'>"+a+"<span class='remove-attachment hide pull-right'><a class='' onclick='deleteMe(jQuery(this))'><i class='glyph-icon icon-close'></i></a></span></li></ul>")}$(this).find('li>a').removeClass('btn').removeClass('btn-block').removeClass('btn-primary');/*jQuery('#emailSubject').val(_file_name+' - '+leadNameGlobal);*/jQuery("#emailDocUrl").val($(this).html());initAttachRemove()}});$('.dragToMePOS').droppable({
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
	function docFileDraggable(){jQuery(document).ready(function(){$(".docDragable").draggable({revert:true,helper:"clone",zIndex:9999});/*$(".emailDragable").draggable({revert:true,helper:"clone",zIndex:9999});*/$(".docDropable").droppable({hoverClass:"drop-hover",drop:function(e,j){if(j.draggable.hasClass('driveDragable')===false){var b=j.draggable.find("a").attr("data-href");var a=j.draggable.find("a").text();_id=jQuery(this).find("ul").attr("data-id");mainParent=jQuery(this);jQuery("#mainDocWaitBox").modal("show");if(b!=""&&a!=""&&_id!=""&&_id!=undefined&&a!=undefined&&b!=undefined){_container='';if(jQuery('#from_nonacquistion').is(':visible')){_container='from_nonacquistion';}if(jQuery('#from_litigation').is(':visible')){_container='from_litigation';}if(jQuery('#from_regular').is(':visible')){_container='from_regular';}_fF='';if(_container!=''){_fF = jQuery('#'+_container).find('select#clipboard').val();}jQuery.ajax({url:__baseUrl+"leads/fileInsert",type:"POST",data:{file_name:a,doc_url:b,d:_id,f:_fF},cache:false,success:function(k){jQuery("#mainDocWaitBox").modal("hide");_data=jQuery.parseJSON(k);if(_data.error=="0"){/*Refresh Drive Folder*/findThisDriveFile(jQuery('#'+_container).find('select#clipboard'));}else{alert("Please try later")}}})}}}})})}function findOwnThread(a,e,b,c){if(typeof _globalAjax=='object'){_globalAjax.abort();}if(typeof c=='undefined'){jQuery('#displayEmail').empty();}_mainActivity = parseInt(jQuery("#activityMainType").val());if(typeof(b)==="undefined"){b=0}jQuery(".mCSB_container").find(".message-item").each(function(){jQuery(this).removeClass("message-active");jQuery(this).find("h5").addClass("c-dark");jQuery(this).find("h4").addClass("c-dark");jQuery(this).find("p").addClass("c-gray");jQuery(this).find("a").addClass("c-dark")});if(b==0){e.parent().parent().parent().find("h5").removeClass("c-dark");e.parent().parent().parent().find("h4").removeClass("c-dark");e.parent().parent().parent().find("p").removeClass("c-gray");e.parent().parent().parent().find("a").removeClass("c-dark");e.parent().parent().parent().find("a").css("color","#FFF");e.parent().parent().parent().addClass("message-active");jQuery("#gmail_message").hide();jQuery("#from_regular").hide();jQuery("#from_litigation").hide();if(jQuery("#myDashboardComposeEmails").length>0){jQuery("#myDashboardComposeEmails").get(0).reset()}$("#all_type_list tbody td").removeClass("active");$("#all_type_list tbody tr").removeClass("active");$(".DTFC_Cloned tbody td").removeClass("active");$(".DTFC_Cloned tbody tr").removeClass("active");$("#other_list_boxes").empty()}if(typeof c!='undefined'){ if(c==2){e.parent().parent().parent().parent().find('div.message-item').removeClass('message-active')}if(c==1 || c==2) {leadGlobal='0';leadNameGlobal='';$("#all_type_list tbody td, #all_type_list tbody tr").removeClass("active");$(".DTFC_Cloned tbody td,.DTFC_Cloned tbody tr").removeClass("active"); jQuery("#marketLead").get(0).reset();jQuery('#from_regular,#from_litigation,#from_nonacquistion').css('display','none');e.parent().parent().parent().addClass('message-active');}}$("#other_list_boxes .message td").removeClass("active");if(!b){$("#all_type_list tbody td").removeClass("active");$(".DTFC_Cloned tbody td").removeClass("active")}jQuery("#messages-boxlist").find("ul.todo-box").find("li").each(function(){jQuery(this).removeClass("active");jQuery("#marketLead").get(0).reset()});if(b){jQuery("#aquisitionTable").find('tbody>tr>td').removeClass('active');jQuery("#aquisitionTable").find('tbody>tr>td').find('div').removeClass('active');jQuery("#activityTable").find('tbody>tr>td').removeClass('active');jQuery("#activityTable").find('tbody>tr>td').find('div').removeClass('active');jQuery("#preSaleActivityTable").find('tbody>tr>td').removeClass('active');jQuery("#preSaleActivityTable").find('tbody>tr>td').find('div').removeClass('active');e.parent().addClass("active")}if(_mainActivity>0 && typeof(e)=='object'){p=0,c_id=0;if(_mainActivity==2){if(jQuery("#aquisitionTable:visible").length>0){if(jQuery("#aquisitionTable:visible").find('input[name="sales_person[]"]:checked').length>0){if(jQuery("#aquisitionTable:visible").find('input[name="sales_person[]"]:checked').length==1){p=jQuery("#aquisitionTable:visible").find('input[name="sales_person[]"]:checked').val();c_id=jQuery("#aquisitionTable:visible").find('input[name="sales_person[]"]:checked').parent().parent().attr("data-c");} else {alert("Please select only one person from whom you received email")}}}}if(p>0&&c_id>0){thr=0;if(e.parent().parent().attr("data-tr")!='undefined'){thr = e.parent().parent().attr("data-tr")} else {thr = e.parent().parent().attr("data-id")}jQuery('#moveEmailPopup').modal('show');jQuery.ajax({type:"POST",url:__baseUrl+"dashboard/oldlinkWithMessage",data:{old_thread:leadGlobal,c_id:c_id,p:p,thread:thr,t:_mainActivity},cache:false,success:function(et){jQuery('#moveEmailPopup').modal('hide');if(et!=""){__data=jQuery.parseJSON(et);if(__data.send){e.parent().parent().remove();refreshAcquisitionAndSalesActivity();/*threadDetail(jQuery("#all_type_list").find("tbody").find("tr.active"))*/}else{alert("Please try after sometime")}}else{showLocalEmail(a,e,b);}}})}else{showLocalEmail(a,e,b);}} else {showLocalEmail(a,e,b);}}function showLocalEmail(a,e,b){var j=jQuery("#message-detail").height()-jQuery("#message-detail .panel-heading").outerHeight()+12;j=296;
	jQuery("#displayEmail").html('<iframe src="'+__baseUrl+"users/own_server_email/"+jQuery.trim(a)+'" scrolling="yes" width="100%" height="'+j+'">')
	jQuery("#displayEmail iframe").off('load').on('load', function() {
		checkMyEmailsHeight();
	});
}_leadPatent="";_lT="";function updatePatenteesData(b){__HTMLL='<div id="TextBoxesGroup"><h2 class="headingPOP1 mainColor" style="margin-top:0px;margin-bottom:0px;">Assets:</h2><div class="cHalf"><p class="patenteespara patenteespara1 mainPaddingTop" style="width:100% !important"><span class="mainColor mainFont">1. Number of patents you wish to sell:</span></p><span style="width: 120px;display: inline-block;text-align:center">Country</span><span style="width: 120px;display: inline-block;text-align: center;">Patent</span><span style="width: 120px;display: inline-block;text-align: center;">Application</span></div><div id="patentNumbers" style="margin-bottom: 5px !important;"><div id="patentNumbers1"><div class="cHalf"><input type="text" readonly="" name="country_n[]" class="p_tet noPadding noMargin  mainFont mainTextCenter" style="display:inline-block !important;width: 120px !important;" id="textbox1" value="USA" placeholder="Country"> <input type="text" readonly="" name="patent_n[]" class="p_tet noPadding noMargin  mainFont mainTextCenter" style="display:inline-block !important;width: 120px !important;" value="3" id="textbox1" placeholder="Patents"> <input type="text" readonly="" name="application_n[]" class="p_tet noPadding noMargin  mainFont mainTextCenter" style="display:inline-block !important;width: 120px !important;" value="0" id="textbox1" placeholder="Applications"></div></div></div><div class="cHalf"><p class="patenteespara patenteespara1 mainPaddingTop"><span class="mainColor mainFont">2. How many are Standard Essential?</span></p><input id="essnt" readonly class="p_tet noPadding  mainFont  p_100 mainTextCenter"  maxlength="3" name="essnt"  type="text" value="" placeholder=""  /></div><h2 class="headingPOP1 mainColor" style="margin-top:0px;margin-bottom:0px;">Price:</h2><div class="cHalf"><p class="patenteespara patenteespara1 mainPaddingTop" ><span class="mainColor mainFont">3. Your total asking price ($): </span></p><input id="u_upfront" readonly class="p_tet  noPadding  mainFont p_100 mainTextCenter" maxlength="9" name="u_upfront" required="" type="text" value="" placeholder=" " /></div><div class="cHalf" id="alert_message" style="display:none"></div><h2 class="headingPOP1 mainColor" style="margin-top:0px;margin-bottom:0px;">Market:</h2><div class="cHalf"><p class="patenteespara patenteespara1 mainPaddingTop" ><span class="mainColor mainFont">4. Number of expected licensees (total):</span></p><input id="n_lic" readonly  class="p_tet noPadding  mainFont p_100 mainTextCenter" maxlength="3" name="n_lic" type="text" value="" placeholder=" " /></div><div class="cHalf"><p class="patenteespara patenteespara1 mainPaddingTop" ><span class="mainColor mainFont" style="width:200px!important;">5.Relating Technologies: </span></p><input id="relatedTechnologies" class="tertext mainFont" name="Technologies" type="text" value="" readonly/></div><div class="cHalf"><p class="patenteespara patenteespara1 mainPaddingTop" ><span class="mainColor mainFont" style="width:200px!important;">6.Relating Standards: </span></p><input id="Standards" readonly class="tertext mainFont" name="Standards"  type="text" value="" /></div><div class="cHalf"><p class="patenteespara patenteespara1 mainPaddingTop" ><span class="mainColor mainFont" style="width:200px!important;">7.Relating Markets: </span></p><input id="Markets" readonly class="tertext mainFont" name="Markets"  type="text" value="" /></div><div class="cHalf"><p class="patenteespara patenteespara1 mainPaddingTop" ><span class="mainColor mainFont" style="width:200px!important;">8.Relating Products: </span></p><input id="Products" readonly class="tertext mainFont" name="Products"  type="text" value="" /></div><div class="cHalf"><p class="patenteespara  mainPaddingTop" style="width: 100% !important;"><span class="mainColor mainFont">9. Potential interested licensees under your patents:</span></p></div><div id="TaxtBoxesGroup" style="margin-bottom: 5px !important;"><div id="TaxtBoxesGroup1"><div class="cHalf"><input readonly id="" class="tertext mainFont" name="n_name[]"  type="text" value="" placeholder="Name" /></div><div class="cHalf"><input id="" class="tertext mainFont" readonly name="r_lice[]"  type="text" value="" placeholder="Reason it may desire a license" /></div><div class="patenteespara mainColor mainWidth mainMarginBottom mainFont">Is there existing Evidence of Use?<input id="" style="padding-top: 0px; margin-bottom:3px;margin-left:8px;margin-right:3px;" name="evidence_e1" type="radio" value="No" />NO<input id="" style="padding-top: 0px; margin-bottom: 3px;margin-left:10px;margin-right:3px;" name="evidence_e1" type="radio" value="Yes" />YES, here is a link</div><div class="cHalf"><p class="patenteespara  mainPaddingTop" style="width: 181px !important;"><span class="mainColor mainFont">to the Evidence of Use: </span></p><input id="" class="tertext mainFont" readonly style="width: 260px !important;" name="r_link[]" type="text" value="" placeholder=""></div><div class="cHalf mainMarginTop mainMarginBottom" style="padding-left: 13px;"></div></div></div><div id="TaxtBoxesGroup" style="margin-bottom: 5px !important;"><h2 class="headingPOP1 mainColor">Seller’s sales materials:</h2><ul id="list_seller_material"></ul></div><h2 class="headingPOP1 mainColor">Seller’s Info:</h2><div class="cHalf"><input id="companyname" class="tertext mainFont" name="companyname"  type="text" value="" placeholder="Seller’s Name " readonly/></div><div class="cHalf"><input id="Broker" class="tertext mainFont" name="Broker"  type="text" value="" placeholder="Broker " readonly/></div><div class="cHalf"><input id="fname" class="tertext mainFont" name="fname"  type="text" value="" placeholder="First Name " readonly/></div><div class="cHalf"><input id="lname" readonly class="tertext mainFont" name="lname"  type="text" value="" placeholder="Last Name " /></div><div class="cHalf"><input type="text" name="email" readonly value="" class="tertext mainFont" id="email" required   placeholder="Email Address"></div><div class="cHalf"><textarea readonly class="tertext" id="address" style="width: 100%; height: 100px !important; padding: 10px;" cols="4" name="address" rows="4" placeholder="Note"></textarea></div></div>';counterPatent=1;jQuery("#patentees_data").html(__HTMLL);if(b!=null&&typeof b.popup_type!="undefined"&&parseInt(b.popup_type)==4){jQuery("#TextBoxesGroup").before("<a target='_BLANK' href='http://www.synpat.com/sellerform/?sr="+snp+"' class='btn btn-primary btn-block'>Synpat.com</a>");_anotherLicense=jQuery.parseJSON(b.other_field);if(_anotherLicense.patent_list!=undefined){jQuery("#patentNumbers").empty();for(i=0;i<_anotherLicense.patent_list.length;i++){var a=$("<div/>").attr("id","patentNumbers"+counterPatent);_country=_anotherLicense.patent_list[i].country;_application=_anotherLicense.patent_list[i].application;_patent=_anotherLicense.patent_list[i].patent;a.html(' <div class="cHalf" ><input type="text" readonly name="country_n[]" class="p_tet noPadding noMargin  mainFont mainTextCenter" style="display:inline-block !important;width:120px !important;" id="textbox'+counterPatent+'" value="'+_country+'"    placeholder="Country" readonly > <input type="text" readonly name="patent_n[]" class="p_tet noPadding noMargin  mainFont mainTextCenter" style="display:inline-block !important;width:120px !important;" readonly value="'+_patent+'"   id="textbox'+counterPatent+'"    placeholder="Patents"  > <input type="text" readonly name="application_n[]" readonly class="p_tet noPadding noMargin  mainFont mainTextCenter" style="display:inline-block !important;width:120px !important;" value="'+_application+'"   id="textbox'+counterPatent+'"    placeholder="Applications"  ></div>');jQuery("#patentNumbers").append(a);if(jQuery("#patentNumbers").find(".rem").length>1){jQuery("#patentNumbers").find(".rem").css("display","inline-block")}counterPatent++}}jQuery("#n_patents").val(_anotherLicense.n_patents);jQuery("#essnt").val(_anotherLicense.essnt);jQuery("#n_lic").val(_anotherLicense.n_lic);jQuery("#u_upfront").val(_anotherLicense.u_upfront);jQuery("#relatedTechnologies").val(_anotherLicense.technologies);jQuery("#Standards").val(_anotherLicense.standards);jQuery("#Markets").val(_anotherLicense.markets);jQuery("#Products").val(_anotherLicense.products);if(_anotherLicense.another_license.length>0){counter=1;jQuery("#TaxtBoxesGroup").empty();for(i=0;i<_anotherLicense.another_license.length;i++){jQuery("#TaxtBoxesGroup").find(".adem").css("display","none");var a=$("<div/>").attr("id","TaxtBoxesGroup"+counter);_name=_anotherLicense.another_license[i].name;_r_lice=_anotherLicense.another_license[i].lice;ychecked="disabled";nchecked="disabled";_link="";if(_anotherLicense.another_license[i].link!=undefined){_link=_anotherLicense.another_license[i].link;}if(_anotherLicense.another_license[i].evidence=="No"){nchecked="CHECKED='CHECKED'"}if(_anotherLicense.another_license[i].evidence=="Yes"){ychecked="CHECKED='CHECKED'"}a.html(' <div class="cHalf" ><input type="text" readonly name="n_name[]" value="'+_name+'" class="tertext mainFont" id="textbox'+counter+'"    placeholder="Name "  ></div><div class="cHalf"> <input type="text" readonly name="r_lice[]" value="'+_r_lice+'" class="tertext mainFont" id="textbox'+counter+'"    placeholder="Reason it may desire a license "  ></div><div class="cHalf patenteespara mainColor mainWidth mainMarginBottom mainFont" >Is there existing Evidence of Use?<input type="radio"  name="evidence_e'+counter+'" value="No" '+nchecked+' class="" id="" style="margin-bottom:3px;margin-left:8px;margin-right:3px" >NO<input type="radio" name="evidence_e'+counter+'" '+ychecked+' value="Yes" class="" id="" style="margin-bottom:3px;margin-left:10px;margin-right:3px;">YES, here is a link</div><div class="cHalf"><p class="patenteespara  mainPaddingTop" style="width: 145px !important;"><span class="mainColor mainFont">to the Evidence of Use: </span></p><input id="textbox1" class="tertext mainFont" style="width: 212px !important;" readonly name="r_link[]" type="text" value="'+_link+'" placeholder=""></div>');jQuery("#TaxtBoxesGroup").append(a);counter++}} var _sellerName = b.type_name; if(typeof b.lead_seller_contact!="undefined"){_sellerName = b.lead_seller_contact} var _broker = b.broker; if(typeof b.lead_broker_contact!="undefined"){_broker = b.lead_broker_contact} var _brokerEmail = b.email_address; if(typeof b.lead_broker_person_contact_email!="undefined"){_brokerEmail = b.lead_broker_person_contact_email;} if(typeof b.lead_broker_person_contact!="undefined"){ var _nameAll = b.lead_broker_person_contact.split(' '); if(_nameAll.length>0 && _nameAll[0]!=""){b.first_name = _nameAll[0]; for(n=1;n<_nameAll.length;n++){ b.last_name +=_nameAll[n]+" ";} b.last_name = jQuery.trim(b.last_name); } } jQuery("#companyname").val(_sellerName);jQuery("#Broker").val(_broker);jQuery("#fname").val(b.first_name);jQuery("#lname").val(b.last_name);jQuery("#email").val(_brokerEmail);jQuery("#address").val(b.note)}ml='';if(b!=null && typeof b.seller_material_link!='undefined'){ml = b.seller_material_link; }list_seller_material(ml);linkOpen();}
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
	<?php if((int)$this->session->userdata['user']['type']==9 || (in_array(14,$this->session->userdata['modules_assign']) && in_array(15,$this->session->userdata['modules_assign']) && in_array(16,$this->session->userdata['modules_assign']))):?>
	if(_leadFormType=='from_litigation'){jQuery("#salesActivityButton").attr("onclick","displaySaleActivityTable('from_litigation',jQuery(this))");jQuery("#acquisitionActivityButton").attr("onclick","displayAquisitionActivityTable('from_litigation',jQuery(this))");jQuery("#btnPatentsAll").attr("onclick","displayPatentTable('from_litigation')");jQuery("#preSaleActivityButton").attr("onclick","displayPreSaleActivityTable('from_litigation',jQuery(this))");
	} else if(_leadFormType=='from_regular'){jQuery("#salesActivityButton").attr("onclick","displaySaleActivityTable('from_regular',jQuery(this))");jQuery("#acquisitionActivityButton").attr("onclick","displayAquisitionActivityTable('from_regular',jQuery(this))");jQuery("#btnPatentsAll").attr("onclick","displayPatentTable('from_regular')");jQuery("#preSaleActivityButton").attr("onclick","displayPreSaleActivityTable('from_regular',jQuery(this))");
	} else if(_leadFormType=='from_nonacquistion'){jQuery("#salesActivityButton").attr("onclick","displaySaleActivityTable('from_nonacquistion',jQuery(this))");jQuery("#acquisitionActivityButton").attr("onclick","displayAquisitionActivityTable('from_nonacquistion',jQuery(this))");jQuery("#btnPatentsAll").attr("onclick","displayPatentTable('from_nonacquistion')");jQuery("#preSaleActivityButton").attr("onclick","displayPreSaleActivityTable('from_nonacquistion',jQuery(this))"); 
	}
	<?php elseif(in_array(14,$this->session->userdata['modules_assign'])):?>
	if(_leadFormType=='from_litigation'){jQuery("#acquisitionActivityButton").attr("onclick","displayAquisitionActivityTable('from_litigation',jQuery(this))");}else if(_leadFormType=='from_regular'){jQuery("#acquisitionActivityButton").attr("onclick","displayAquisitionActivityTable('from_regular',jQuery(this))");}else if(_leadFormType=='from_nonacquistion'){jQuery("#acquisitionActivityButton").attr("onclick","displayAquisitionActivityTable('from_nonacquistion',jQuery(this))");}
	<?php elseif(in_array(15,$this->session->userdata['modules_assign'])):?>
	if(_leadFormType=='from_litigation'){jQuery("#salesActivityButton").attr("onclick","displaySaleActivityTable('from_litigation',jQuery(this))");
	} else if(_leadFormType=='from_regular'){jQuery("#salesActivityButton").attr("onclick","displaySaleActivityTable('from_regular',jQuery(this))");
	} else if(_leadFormType=='from_nonacquistion'){jQuery("#salesActivityButton").attr("onclick","displaySaleActivityTable('from_nonacquistion',jQuery(this))");}
	<?php elseif(in_array(25,$this->session->userdata['modules_assign'])):?>
	if(_leadFormType=='from_litigation'){jQuery("#preSaleActivityButton").attr("onclick","displayPreSaleActivityTable('from_litigation',jQuery(this))");
	} else if(_leadFormType=='from_regular'){jQuery("#preSaleActivityButton").attr("onclick","displayPreSaleActivityTable('from_regular',jQuery(this))");
	} else if(_leadFormType=='from_nonacquistion'){jQuery("#preSaleActivityButton").attr("onclick","displayPreSaleActivityTable('from_nonacquistion',jQuery(this))");}
	<?php elseif(in_array(16,$this->session->userdata['modules_assign'])):?>
	if(_leadFormType=='from_litigation'){jQuery("#btnPatentsAll").attr("onclick","displayPatentTable('from_litigation')")
	} else if(_leadFormType=='from_regular'){jQuery("#btnPatentsAll").attr("onclick","displayPatentTable('from_regular')")
	} else if(_leadFormType=='from_nonacquistion'){jQuery("#btnPatentsAll").attr("onclick","displayPatentTable('from_nonacquistion')");}
	<?php endif;?>
}


function leadDataDisplay(_data){
	if(_data.detail.length>0){
		snapGlobal=_data.detail[0].litigation.file_url;_st="<?php echo $this->session->userdata['type'];?>";_sp="<?php echo $this->session->userdata['id'];?>";leadGlobal=_data.detail[0].litigation.id;snp=_data.detail[0].litigation.serial_number;leadNameGlobal=_data.detail[0].litigation.lead_name;snapGlobalFileID=_data.detail[0].litigation.spreadsheet_id;snapGlobalFileWorkID = _data.detail[0].litigation.worksheet_id;snapGlobalFileWorkName = _data.detail[0].litigation.worksheet_name;jQuery(".topbar-lead-name").css("width","440px;").html(leadNameGlobal+' '+leadSerialGlobal);/*jQuery("#from_regular").find("#serialNumber").html(_data.detail[0].litigation.serial_number);jQuery("#from_nonacquistion").find("#serialNumber").html(_data.detail[0].litigation.serial_number);jQuery("#from_litigation").find("#serialNumber").html(_data.detail[0].litigation.serial_number);*/
		<?php 
		$openTask = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(4,$this->session->userdata['modules_assign'])){
				$openTask = false;
			}
		}
		if($openTask===true):?>
		_senddt="<?php echo $this->session->userdata['id'];?>";
		if(typeof _data.detail[0].patentees!="undefined"){_ddata=_data.detail[0].patentees;updatePatenteesData(_ddata)}
		jQuery("#commentComment1").val("");jQuery("#commentComment2").val("");jQuery("#commentComment3").val("");jQuery("#leadType").val(_data.detail[0].litigation.type);jQuery("#commentID").val("0");jQuery("select[name='attractiveness']").find("option").each(function(){jQuery(this).removeAttr("SELECTED")});
		_objComment = jQuery("#btnComments:hidden");
		if(_objComment.length==0){_objComment = jQuery("#btnComments");}
		_objComment.find("#comment_upper_list").empty().html("<table class='table'><thead><tr><th>Are there >10 potential licensees? Who?</th><th>Easy to show infringement? Are there EoU? How clear?</th><th>Seller's concerns + Your general observations</th><th>Attractiveness</th><th>Created</th><th>Updated</th><th>By</th></tr></thead><tbody><tr><td colspan='7'>No record found!</td></tr></tbody></table>");if(_data.detail[0].comment.length>0){_tr="";jQuery("#btnComments:hidden").find("table").find("tbody").html("");_objComment.find('tbody').empty();
		for(i=0;i<_data.detail[0].comment.length;i++){
		_flag=0;_comment=_data.detail[0].comment[i];
		if(_comment.user_id==_senddt){
		_flag=1;_commentID=_comment.id;_commentText1=_comment.comment1;_commentText2=_comment.comment2;_commentText3=_comment.comment3;_commentAttractive=_comment.attractive;jQuery("#commentComment1").val(_commentText1);jQuery("#commentComment2").val(_commentText2);jQuery("#commentComment3").val(_commentText3);jQuery("#commentId").val(_commentID);jQuery("select[name='attractiveness']").find("option").each(function(){if(jQuery(this).attr("value")==_commentAttractive){jQuery(this).attr("SELECTED","SELECTED")}else{jQuery(this).removeAttr("SELECTED")}})}
		<?php if((int)$this->session->userdata['type']==9):?>
		if(_flag==0){createdDate="";u="";if(_comment.created==null||_comment.created=="0000-00-00 00:00:00"){createdDate=""}else{createdDate=moment(new Date(_comment.created)).format("MM-D-YY")}
		if(_comment.updated==null||_comment.updated=="0000-00-00 00:00:00"){u=""}else{var u=moment(new Date(_comment.updated)).format("MM-D-YY")}
		comment1=nl2br(_comment.comment1);comment2=nl2br(_comment.comment2);comment3=nl2br(_comment.comment3);
		_tr="<tr><td>"+comment1.linkify()+" </td><td>"+comment2.linkify()+" </td><td>"+comment3.linkify()+' </td><td><span class="label alert">'+_comment.attractive+"</span></td>	<td>"+createdDate+"</td><td>"+u+"</td><td>"+_comment.name+"</td></tr>";
		_objComment.find("table").find("tbody").append(_tr)
		}<?php endif;?>}}		
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
			for(op=0;op<open_project.length;op+=1){
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
					/*window.parent.jQuery('#'+_mainButtonParentElement).find('input#leadOpenPatentOpenContact').val(open_project[op].personName+', '+open_project[op].company_name);
					window.parent.jQuery('#'+_mainButtonParentElement).find('input#leadOpenPatentContact').val(open_project[op].contact_id);
					window.parent.jQuery('#'+_mainButtonParentElement).find('input#leadOpenPatentOpenStatus').prop('checked',check);*/
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
		if(_userList!=""){
			try{
				_user = JSON.parse(_userList);
				_portfolioPerson = _data.detail[0].litigation.portfolio_person_name;
				if(_user.length>0){
					jQuery.each(_user,function(i,u){
						_selected = '';
						if(jQuery.trim(_portfolioPerson)==jQuery.trim(u.name)){
							_selected= "SELECTED='SELECTED'";
						}
						objMainElement.find('select#userUser').append("<option value='"+u.id+"' "+_selected+">"+u.name+"</option>");
					});
				}
			}catch(e){
				
			}
		}
		objMainElement.find('span#spnleadOpenIllustrationPatent').attr('title',_data.detail[0].litigation.illustrationComplete).text(_data.detail[0].litigation.illustrationComplete);
		objMainElement.find('span#spnleadOpenTechnicalPatent').attr('title',_data.detail[0].litigation.techDDComplete).text(_data.detail[0].litigation.techDDComplete);
		objMainElement.find('span#spnleadOpenMarketPatent').attr('title',_data.detail[0].litigation.marketDDComplete).text(_data.detail[0].litigation.marketDDComplete);
		objMainElement.find('span#spnleadOpenLegalPatent').attr('title',_data.detail[0].litigation.legalDDComplete).text(_data.detail[0].litigation.legalDDComplete);
		objMainElement.find('span#spnleadOpenPdfPatent').attr('title',_data.detail[0].litigation.pdfDDComplete).text(_data.detail[0].litigation.pdfDDComplete);
		objMainElement.find('span#spnleadOpenComparablesPatent').attr('title',_data.detail[0].litigation.comparablesComplete).text(_data.detail[0].litigation.comparablesComplete);
		objMainElement.find('span#spnleadOpenInviteesPatent').attr('title',_data.detail[0].litigation.invitesComplete).text(_data.detail[0].litigation.invitesComplete);
		objMainElement.find('span#spnleadOpenIntroPatent').attr('title',_data.detail[0].litigation.imageComplete).text(_data.detail[0].litigation.imageComplete);
		objMainElement.find('span#spnleadOpenRoyaltyOpenContactPatent').attr('title',_data.detail[0].litigation.imageComplete).text(_data.detail[0].litigation.royaltyComplete);
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
			case "DRIVE":_statusMessage="";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}_refrence=_data.detail[0].buttons[bt].reference_id;jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="drive_button'+_data.detail[0].buttons[bt].id+'"></div></div>');
			if(_data.detail[0].buttons[bt].btnStatus=="0"||_data.detail[0].buttons[bt].renewable=="1"){
				jQuery("#"+_mainButtonParentElement).find("#drive_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-status="'+_data.detail[0].buttons[bt].status_message+'" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="driveMode('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"','"+_refrence+"',"+_data.detail[0].buttons[bt].send_task+");\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>');
			}else{
				if(_data.detail[0].buttons[bt].blink==1){
					jQuery("#"+_mainButtonParentElement).find("#drive_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth btn-blink " data-status="'+_data.detail[0].buttons[bt].status_message+'" title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="btnModeStatus('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>');
				} else {
					if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#drive_button"+_data.detail[0].buttons[bt].id).addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{jQuery("#"+_mainButtonParentElement).find("#drive_button"+_data.detail[0].buttons[bt].id).addClass("staRenewalAction").html('<span class="date-style">'+moment(new Date(_data.detail[0].buttons[bt].update_date)).format("MM-D-YY")+"</span> "+_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}}
			}
			break;
			case "EMAIL":
			_statusMessage="";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}_refrence=_data.detail[0].buttons[bt].reference_id;jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="email_button'+_data.detail[0].buttons[bt].id+'"></div></div>');
			if(_data.detail[0].buttons[bt].btnStatus=="0"||_data.detail[0].buttons[bt].renewable=="1"){jQuery("#"+_mainButtonParentElement).find("#email_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-status="'+_data.detail[0].buttons[bt].status_message+'" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="emailMode('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"','"+_refrence+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
			}else{
				if(_data.detail[0].buttons[bt].blink==1){
					jQuery("#"+_mainButtonParentElement).find("#email_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth btn-blink lead_button" data-status="'+_data.detail[0].buttons[bt].status_message+'" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="btnModeStatus('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>');
				} else {
					if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#email_button"+_data.detail[0].buttons[bt].id).addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{jQuery("#"+_mainButtonParentElement).find("#email_button"+_data.detail[0].buttons[bt].id).addClass("staRenewalAction").html('<span class="date-style">'+moment(new Date(_data.detail[0].buttons[bt].update_date)).format("MM-D-YY")+"</span> "+_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}
				}												
			}
			break;
			case "TASK":
			_statusMessage="";if(_data.detail[0].buttons[bt].status_message!=""){_statusMessage=_data.detail[0].buttons[bt].status_message}_refrence=_data.detail[0].buttons[bt].reference_id;jQuery("#"+_mainButtonParentElement).find(".button-list").append('<div class="row '+_aC+'" data-item-idd="'+_data.detail[0].buttons[bt].id+'"><div class="col-sm-12" id="task_button'+_data.detail[0].buttons[bt].id+'"></div></div>');
			if(_data.detail[0].buttons[bt].btnStatus=="0"||_data.detail[0].buttons[bt].renewable=="1"){jQuery("#"+_mainButtonParentElement).find("#task_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth lead_button" data-status="'+_data.detail[0].buttons[bt].status_message+'" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="taskMode('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"','"+_refrence+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
			}else{
				if(_data.detail[0].buttons[bt].blink==1){
					jQuery("#"+_mainButtonParentElement).find("#task_button"+_data.detail[0].buttons[bt].id).removeClass("btn").removeClass("btn-mwidth").html('<a class="btn btn-default btn-mwidth btn-blink lead_button" data-status="'+_data.detail[0].buttons[bt].status_message+'" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="btnModeStatus('+_data.detail[0].buttons[bt].id+",'"+_mainButtonParentElement+"');\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_'+_data.detail[0].buttons[bt].id+'" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>');
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
			if(_data.detail[0].litigation.claim_status_dd=="1"&&_data.detail[0].buttons[bt].renewable=="0"){jQuery("#"+_mainButtonParentElement).find("#claim_illus").removeClass("btn").removeClass("btn-mwidth").addClass("btn-blink").html('<a class="btn btn-default btn-mwidth lead_button" data-title="'+_data.detail[0].buttons[bt].description+'" href="javascript://" onclick="claimIllusStatusChange(\''+_mainButtonParentElement+"')\">"+_data.detail[0].buttons[bt].name+'</a><div id="loader_claim_illus_dd_market" class="glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A hide" title="" data-original-title="Processing Importing Data" style="color:#222222;"></div>')
			jQuery("#"+_mainButtonParentElement).find("#claim_illus").find('a').removeAttr('onclick');	
			}else{
				if(_data.detail[0].litigation.claim_status_dd=="2"&&_data.detail[0].buttons[bt].renewable=="0"){
					jQuery("#"+_mainButtonParentElement).find("#claim_illus").find('a').removeAttr('onclick');
					if(_data.detail[0].buttons[bt].status_message_fill!=""){jQuery("#"+_mainButtonParentElement).find("#claim_illus").addClass("staRenewalAction").html(_allStatus+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}else{jQuery("#"+_mainButtonParentElement).find("#claim_illus").addClass("staRenewalAction").removeClass("btn-blink").html(_statusMessage+'&nbsp;<i class="glyph-icon icon-repeat"></i>')}
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
		if(_data.detail[0].litigation.type!="Litigation"&&_data.detail[0].litigation.type!="NON"&&_data.detail[0].litigation.type!="INT"&&jQuery("#marketOwner").length>0){
		<?php if($openLeadDT===true):?>
			jQuery("#marketOwner").val(_data.detail[0].litigation.plantiffs_name);jQuery("#marketProspects").val(_data.detail[0].litigation.no_of_prospects);jQuery("#marketExpectedPrice").val(_data.detail[0].litigation.upfront_price);jQuery("#marketProspectsName").val(_data.detail[0].litigation.prospects_name);jQuery("#marketlead_name").val(_data.detail[0].litigation.lead_name);jQuery("#marketTechnologies").val(_data.detail[0].litigation.technologies);jQuery("#marketNo_of_us_patents").val(_data.detail[0].litigation.no_of_us_patents);jQuery("#marketno_of_non_us_patents").val(_data.detail[0].litigation.no_of_non_us_patents);jQuery("#marketFileUrl").val(_data.detail[0].litigation.file_url);jQuery("#marketSellerInfo").val(_data.detail[0].litigation.seller_info);jQuery("#marketProposal_letter").val(_data.detail[0].litigation.send_proposal_letter);jQuery("#marketCreate_patent_list").val(_data.detail[0].litigation.create_patent_list);if(_data.detail[0].litigation.complete==1){if(_data.detail[0].litigation.forward_to_review_text=="0000-00-00 00:00:00"||_data.detail[0].litigation.create_patent_list_text==null){jQuery("#forward_to_review").html(" Review")}else{jQuery("#forward_to_review").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.forward_to_review_text)).format("MM-D-YY")+"</span> Review")}}_mainValue=_data.detail[0].litigation.market_data;jQuery("#marketMarketData").val(_mainValue);if(_mainValue!=""){marketData=_mainValue.split(",");if(marketData.length>0){$("#marketBoxList").empty();$("#marketBoxList").append("<ul class='todo-box-1'></ul>");for(mk=0;mk<marketData.length;mk++){$("#marketBoxList").find("ul.todo-box-1").append("<li>"+marketData[mk]+"</li>")}}}jQuery("#showSellerName").html(_data.detail[0].litigation.seller_contact);jQuery("#marketSellerContact").val(_data.detail[0].litigation.seller_contact);jQuery("#marketOwner").val(_data.detail[0].litigation.plantiffs_name);jQuery("#sellerBtn").attr("onclick","openContactForFrom(1,'from_regular');");jQuery("#showBrokerFirm").html(_data.detail[0].litigation.broker_contact);jQuery("#optionExpirationDate").val(_data.detail[0].litigation.option_expiration_date);jQuery("#marketBrokerContact").val(_data.detail[0].litigation.broker_contact);jQuery("#marketBroker").val(_data.detail[0].litigation.broker);jQuery("#brokerFirmBtn").attr("onclick","openContactForFrom(2,'from_regular');");jQuery("#showBrokerPerson").html(_data.detail[0].litigation.broker_person_contact);jQuery("#marketBrokerPersonContact").val(_data.detail[0].litigation.broker_person_contact);jQuery("#marketBrokerPerson").val(_data.detail[0].litigation.broker_person);jQuery("#brokerPersonBtn").attr("onclick","openContactForFrom(3,'from_regular');");jQuery("#showNameFirst").html(_data.detail[0].litigation.person_name_1);jQuery("#marketPersonName1").val(_data.detail[0].litigation.person_name_1);jQuery("#marketPersonTitle1").val(_data.detail[0].litigation.person_title_1);jQuery("#showNameBtn").attr("onclick","openContactForFrom(4,'from_regular');");jQuery("#showNameSecond").html(_data.detail[0].litigation.person_name_2);jQuery("#marketPersonName2").val(_data.detail[0].litigation.person_name_2);jQuery("#marketPersonTitle2").val(_data.detail[0].litigation.person_title_2);jQuery("#showNameSecondBtn").attr("onclick","openContactForFrom(5,'from_regular');");jQuery("#from_regular").find("#marketComplete").val(_data.detail[0].litigation.complete);jQuery("#marketAddress").val(_data.detail[0].litigation.address);jQuery("#from_regular").find("#taskLeadId").val(_data.detail[0].litigation.id);jQuery("#marketLeadId").val(_data.detail[0].litigation.id);jQuery("#marketPersonName1").val(_data.detail[0].litigation.person_name_1);jQuery("#marketRelatesTo").val(_data.detail[0].litigation.relates_to);jQuery("#marketupfront_price").val(_data.detail[0].litigation.expected_price);
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
				jQuery("#acquisitionOwner").val(_data.detail[0].litigation.plantiffs_name);jQuery("#acquisitionProspects").val(_data.detail[0].litigation.no_of_prospects);jQuery("#acquisitionExpectedPrice").val(_data.detail[0].litigation.upfront_price);jQuery("#acquisitionProspectsName").val(_data.detail[0].litigation.prospects_name);jQuery("#acquisitionlead_name").val(_data.detail[0].litigation.lead_name);jQuery("#acquisitionTechnologies").val(_data.detail[0].litigation.technologies);jQuery("#acquisitionNo_of_us_patents").val(_data.detail[0].litigation.no_of_us_patents);jQuery("#acquisitionno_of_non_us_patents").val(_data.detail[0].litigation.no_of_non_us_patents);jQuery("#acquisitionFileUrl").val(_data.detail[0].litigation.file_url);jQuery("#acquisitionSellerInfo").val(_data.detail[0].litigation.seller_info);jQuery("#acquisitionProposal_letter").val(_data.detail[0].litigation.send_proposal_letter);jQuery("#acquisitionCreate_patent_list").val(_data.detail[0].litigation.create_patent_list);jQuery("#acquisitionType").val(_data.detail[0].litigation.type);jQuery("#acquisitionCreateDate").val(moment(new Date(_data.detail[0].litigation.create_date)).format("YYYY-MM-DD"));_update="";if(_data.detail[0].litigation.update_date!=""&&_data.detail[0].litigation.update_date!="0000-00-00 00:00:00"){_update=moment(new Date(_data.detail[0].litigation.update_date)).format("YYYY-MM-DD")}jQuery("#acquisitionUpdateDate").val(_update);_nextAction="";if(_data.detail[0].litigation.next_action!=""&&_data.detail[0].litigation.next_action!="0000-00-00 00:00:00"){_nextAction=moment(new Date(_data.detail[0].litigation.next_action)).format("YYYY-MM-DD")}jQuery("#acquisitionNextAction").val(_nextAction);if(_data.detail[0].litigation.complete==1){if(_data.detail[0].litigation.forward_to_review_text=="0000-00-00 00:00:00"||_data.detail[0].litigation.create_patent_list_text==null){jQuery("#forward_to_review").html(" Review")}else{jQuery("#forward_to_review").html('<span class="date-style">'+moment(new Date(_data.detail[0].litigation.forward_to_review_text)).format("MM-D-YY")+"</span> Review")}}_mainValue=_data.detail[0].litigation.market_data;jQuery("#acquisitionMarketData").val(_mainValue);if(_mainValue!=""){marketData=_mainValue.split(",");if(marketData.length>0){$("#acquisitionBoxList").empty();$("#acquisitionBoxList").append("<ul class='todo-box-1'></ul>");for(mk=0;mk<marketData.length;mk++){$("#acquisitionBoxList").find("ul.todo-box-1").append("<li>"+marketData[mk]+"</li>")}}}_acquisitionObject.find("#showSellerName").html(_data.detail[0].litigation.seller_contact);jQuery("#acquisitionSellerContact").val(_data.detail[0].litigation.seller_contact);_acquisitionObject.find("#sellerBtn").attr("onclick","openContactForFrom(1,'from_nonacquistion');");_acquisitionObject.find("#showBrokerFirm").html(_data.detail[0].litigation.broker_contact);jQuery("#acquisitionBrokerContact").val(_data.detail[0].litigation.broker_contact);jQuery("#acquisitionBroker").val(_data.detail[0].litigation.broker);_acquisitionObject.find("#brokerFirmBtn").attr("onclick","openContactForFrom(2,'from_nonacquistion');");_acquisitionObject.find("#showBrokerPerson").html(_data.detail[0].litigation.broker_person_contact);jQuery("#acquisitionBrokerPersonContact").val(_data.detail[0].litigation.broker_person_contact);jQuery("#acquisitionBrokerPerson").val(_data.detail[0].litigation.broker_person);_acquisitionObject.find("#brokerPersonBtn").attr("onclick","openContactForFrom(3,'from_nonacquistion');");_acquisitionObject.find("#showNameFirst").html(_data.detail[0].litigation.person_name_1);jQuery("#acquisitionPersonName1").val(_data.detail[0].litigation.person_name_1);jQuery("#acquisitionPersonTitle1").val(_data.detail[0].litigation.person_title_1);_acquisitionObject.find("#showNameBtn").attr("onclick","openContactForFrom(4,'from_nonacquistion');");_acquisitionObject.find("#showNameSecond").html(_data.detail[0].litigation.person_name_2);jQuery("#acquisitionPersonName2").val(_data.detail[0].litigation.person_name_2);jQuery("#acquisitionPersonTitle2").val(_data.detail[0].litigation.person_title_2);_acquisitionObject.find("#showNameSecondBtn").attr("onclick","openContactForFrom(5,'from_nonacquistion');");_acquisitionObject.find("#marketComplete").val(_data.detail[0].litigation.complete);jQuery("#acquisitionBroker").val(_data.detail[0].litigation.broker);jQuery("#acquisitionAddress").val(_data.detail[0].litigation.address);_acquisitionObject.find("#taskLeadId").val(_data.detail[0].litigation.id);jQuery("#acquisitionLeadId").val(_data.detail[0].litigation.id);jQuery("#acquisitionRelatesTo").val(_data.detail[0].litigation.relates_to);jQuery("#acquisitionOptionExpirationDate").val(_data.detail[0].litigation.option_expiration_date);
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
		windowResize();checkBodyScrollable();
		/*if(_leadPatent!=""){
			showPatentData(_leadPatent);
		}*/
		acquisitions = _data.detail[0].acquisitions;
		portfolioName = _data.detail[0].portfolio;
		if(typeof acquisitions.store_name!='undefined'){		
			jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('#btnLinkToDocket').attr('href','http://synpat.com/store/'+acquisitions.store_name).attr('target',"Docket - "+leadNameGlobal);		
			jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToIntroDD').attr('href','http://synpat.com/store/'+acquisitions.store_name+'/?edit').attr('target',"Intro DD - "+leadNameGlobal);		
			
		} else {								
			jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('#btnLinkToDocket').attr('href','javascript://').attr('target',"Docket - "+leadNameGlobal);	
			jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('#btnLinkToIntroDD').attr('href','javascript://').attr('target',"Intro DD - "+leadNameGlobal);	
			
		}
		if(typeof acquisitions.order_name!='undefined'){
			jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToClaimcharts').attr('data-href','http://claimcharts.info/?'+acquisitions.order_name);		
		} else {
			jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToClaimcharts').removeAttr('data-href');
		}
		if(typeof portfolioName!='undefined' && portfolioName!=""){
			jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('#btnLinkToStore').attr('href','https://synpat.com/portfolio/?'+portfolioName).attr('target',"Store - "+leadNameGlobal);	
		} else {
			jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('#btnLinkToStore').attr('href','javascript://').attr('target',"Store - "+leadNameGlobal);	
		}
		console.log('COST:'+acquisitions.cost_price);
		if(typeof acquisitions.cost_price!='undefined'){
			console.log('COST:'+acquisitions.cost_price);
			costPrice = acquisitions.cost_price;
			if(costPrice>0){
				_actualPrice = 0
				stage = 1;
				if(acquisitions.regular_license_starts!="0000-00-00 00:00:00"){
					_actualPrice = costPrice * 1.5;
					stage = 2;
				}
				lateLicense = acquisitions.late_license_starts;
				if(lateLicense!="0000-00-00 00:00:00"){
					_todayDate = moment(_todayDate).format('MM/DD/YYYY');
					lateLicense = moment(lateLicense).format('MM/DD/YYYY');
					if(moment(new Date(_todayDate)).isAfter(lateLicense,'MM/DD/YYYY')===true){
						_actualPrice = costPrice * 3;
						stage = 3;
					}
				}
				switch(stage){
					case 2:
						jQuery('#'+_mainButtonParentElement).find('#stage').html('Regular Price: ');
					break;
					case 3:
						jQuery('#'+_mainButtonParentElement).find('#stage').html('Validated Price: ');
					break;
				}
				if(_actualPrice>0){
					switch(stage){
						case 2:
							jQuery('#'+_mainButtonParentElement).find('#stage').html('Regular Price: '+_actualPrice.toFixed(1)+'M');
						break;
						case 3:
							jQuery('#'+_mainButtonParentElement).find('#stage').html('Validated Price: '+_actualPrice.toFixed(1)+'M');
						break;
					}
					if(stage!=acquisitions.active_button){
						/*need to update active button*/
						console.log("Update button");
						call(__baseUrl+'opportunity/update_store_active_button','POST',{l:leadGlobal,s:stage},checkResultOfActive,'text');
						jQuery('#'+_mainButtonParentElement).find("#docketActiveButton").val(stage);
					}
				}
			}
		}
		
		
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToTechDD').attr('href','http://synpat.com/techdd/'+_data.detail[0].litigation.serial_number).attr('target',"Technical DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToMarketDD').attr('href','http://synpat.com/marketdd/'+_data.detail[0].litigation.serial_number).attr('target',"Market DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToLegalDD').attr('href','http://synpat.com/legaldd/'+_data.detail[0].litigation.serial_number).attr('target',"Legal DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToSellerDD').attr('href','https://synpat.com/dd/'+_data.detail[0].litigation.serial_number).attr('target',"Seller DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToComparable').attr('href','https://synpat.com/comparedd/'+_data.detail[0].litigation.serial_number).attr('target',"Comparables DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToPDF').attr('href','https://synpat.com/pdfdd/index/'+_data.detail[0].litigation.serial_number).attr('target',"PDF DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToIllusDD').attr('href','http://synpat.com/illustrationdd/index/'+_data.detail[0].litigation.serial_number).attr('target',"Illustration DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToIntroImages').attr('href','http://synpat.com/introimages/index/'+_data.detail[0].litigation.serial_number).attr('target',"Intro Images DD - "+_data.detail[0].litigation.lead_name);
		jQuery("#from_regular,#from_litigation,#from_nonacquistion").find('#btnLinkToDictionaryDD').attr('href','https://synpat.com/dictionarydd/'+_data.detail[0].litigation.serial_number).attr('target',"Dictionary DD - "+_data.detail[0].litigation.lead_name);
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
		}
		if(typeof acquisitions.active_button!='undefined'){
			jQuery('#'+_mainButtonParentElement).find("#docketActiveButton").val(acquisitions.active_button);
		}
		if(typeof acquisitions.docket_status!='undefined'){
			if(acquisitions.docket_status==0){
				jQuery('#'+_mainButtonParentElement).find("#docketStatus").prop('checked',false);
			} else if(acquisitions.docket_status==1){
				jQuery('#'+_mainButtonParentElement).find("#docketStatus").prop('checked',true);
			}
		} else {
			jQuery('#'+_mainButtonParentElement).find("#docketStatus").prop('checked',false);
		}
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

function checkDocketStatus(o){status=(o.is('checked')?0:1);jQuery.ajax({type:'POST',url:__baseUrl+'opportunity/change_docket_status',data:{lead_id:leadGlobal,docket_status:status},success:function(resp){obj = JSON.parse(resp);if(obj.success==1){if(obj.status==1){o.prop('checked',true);}else {o.prop('checked',false);}}jQuery('#'+_mainBtnParentElement).find('#docketCategory').val(obj.category);}})}
	
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
	}
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
		console.log("INDEX:"+_inde);
		if(jQuery("#search_lead_box").is(":visible")){
			_leadDT.find("tbody").find("tr").each(function(index){
				if(jQuery(this).attr("data-id")==g){
					_inde = index;jQuery(this).addClass("active")
				}
			});
		}
		console.log("MAIN");
		_leadDT.find("tbody tr").eq(_inde).addClass("active");
		a.parents('tr').addClass("active");
	}else{
		console.log("ANCH");
		g=a.parent().parent().attr("data-id");t=a.parent().parent().attr("data-type");_inde=a.parent().parent().parent().index();
	_leadDT.find("tbody tr").eq(_inde).addClass("active");
	}
	___FLAG=0;leadRunEntry(leadGlobal,g);jQuery("#search_lead_box").css("display","none");if(jQuery("#all_type_list_wrapper>.row").css("display")=="block"){if(_leadDT.find("tbody").find("tr.active").length>0){/*_leadDT.find("tbody").html(__TableDT);
	tableDT=_leadDT.DataTable({
		destroy:true,
		scrollY:"270px",
		scrollX:true,
		scrollCollapse:true,
		searching:true,
		order: [[ 0, "asc" ]],
		paging:false,
		fnInitComplete:function(j,e) {
			_parentContainer = jQuery("#all_type_list");
			_parentContainerBody = _parentContainer.find("tbody");
			_parentContainerBody.find("tr").removeClass("active");
			_index=_parentContainerBody.find('tr[data-id="'+g+'"]').index();
			_parentContainerBody.find("tr").eq(_index).addClass("active");
			jQuery(".DTFC_Cloned").find("tbody").find("tr").eq(_index).addClass("active");
			_scrollTop=_parentContainerBody.find("tr.active").offset();
			if(jQuery("#dashboard_charts").is(":visible")){
				_parentContainer.parent().scrollTop(_scrollTop.top-263.5)
			} else {
				_parentContainer.parent().scrollTop(_scrollTop.top-106)
			}
			removeDTResizeEvents();
			runTableLeadBal();
		},
		fnDrawCallback: function() {
			checkMyEmailsHeight();
		}
	})
	*/

}}jQuery(".messages-list-leads").find(".message-item").each(function(){jQuery(this).removeClass("message-active");jQuery(this).find("h5").addClass("c-dark");jQuery(this).find("h4").addClass("c-dark");jQuery(this).find("p").addClass("c-gray");jQuery(this).find("a").addClass("c-dark")});jQuery(".message-detail-title").css("display","none");jQuery(".message-detail-right").hide();jQuery("#subject").empty();jQuery(".message-detail-subject").empty();if(typeof(b)==="undefined"){jQuery("#other_list_boxes").empty()}jQuery("#other_list_boxes").find("table").find("tr").removeClass("activetr");jQuery(".message_detail").empty().html('<div class="loading-spinner" id="loading_spinner" style="display:none;"><img src="<?php echo $awsUrl; ?>images/ajax-loader.gif" alt=""></div>');if(jQuery("#marketLead").length>0){jQuery("#marketLead").get(0).reset()}if(jQuery("#leadForm").length>0){jQuery("#leadForm").get(0).reset()}if(jQuery("#formLitigation").length>0){jQuery("#formLitigation").get(0).reset()}
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
		console.log("Not find");
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
	console.log('Start interval');
	runLeadSelectInterval();
	
	/*
	leadCacheScript(g);	
	enableActionRightAgain()*/
}}
_referenceString="";
function findThread(a,e,b){dieAllCalls();_formOpen='';jQuery('#displayEmail,#message-detail').data('file','');jQuery('#displayEmail').empty();_mainActivity = parseInt(jQuery("#activityMainType").val());if(_mainActivity>0 && typeof(e)=='object'){p=0,c_id=0,_dateEmail="";if(_mainActivity==1){_atO = jQuery("#activityTable:visible");if(_atO.length>0){_atOSP=_atO.find('input[name="sales_person[]"]:checked');if(_atOSP.length>0){if(_atOSP.length==1){p=_atOSP.val();c_id=_atOSP.parent().parent().attr("data-c");_dateEmail=e.parent().parent().parent().attr("data-date");} else {alert("Please select only one person from whom you received email")}}}}else if(_mainActivity==3){_atO = jQuery("#preSaleActivityTable:visible");if(_atO.length>0){_atOSP=_atO.find('input[name="sales_person[]"]:checked');if(_atOSP.length>0){if(_atOSP.length==1){p=_atOSP.val();c_id=_atOSP.parent().parent().attr("data-c");_dateEmail=e.parent().parent().parent().attr("data-date");} else {alert("Please select only one person from whom you received email")}}}} else if(_mainActivity==2){_aatO = jQuery("#aquisitionTable:visible");if(_aatO.length>0){_aatOSP=_aatO.find('input[name="sales_person[]"]:checked');if(_aatOSP.length>0){if(_aatOSP.length==1){p=_aatOSP.val();c_id=_aatOSP.parent().parent().attr("data-c");_dateEmail=e.parent().parent().parent().attr("data-date");} else {alert("Please select only one person from whom you received email")}}}}if(p>0&&c_id>0&&_dateEmail!=""){msg = confirm('Are you sure you want to associate email with this person?');if(msg==true){jQuery("#moveEmailPopup").modal("show");jQuery.ajax({type:"POST",url:__baseUrl+"dashboard/linkWithMessage",data:{old_thread:leadGlobal,c_id:c_id,p:p,thread:e.parent().parent().parent().attr("data-id"),date:_dateEmail,t:_mainActivity},cache:false,success:function(et){jQuery("#moveEmailPopup").modal("hide");if(et!=""){_send=jQuery.parseJSON(et);if(_send.send>0){e.parent().parent().parent().remove();refreshAcquisitionAndSalesActivity();}else{alert("Please try after sometime")}}else{alert("Please try after sometime")}}});}}else{releaseAll();showServerEmail(a,e,b);}} else {releaseAll();showServerEmail(a,e,b)}}
function  showServerEmail(a,e,b){if(typeof(b)==="undefined"){b=0}resetMenus();jQuery(".mCSB_container").find(".message-item").each(function(){if(jQuery(this).attr("data-id")==jQuery.trim(a)){if(b==0){e.parent().parent().parent().find("a").css("color","#FFF");e.parent().parent().parent().addClass("message-active");e.parent().parent().parent().find("h5").removeClass("c-dark");e.parent().parent().parent().find("h4").removeClass("c-dark");e.parent().parent().parent().find("p").removeClass("c-gray");e.parent().parent().parent().find("a").removeClass("c-dark");jQuery("#gmail_message").hide();jQuery("#from_regular").hide();jQuery("#from_litigation").hide();jQuery('#sales_acititity').removeClass('show').addClass('hide');jQuery("#from_nonacquistion").hide();if(jQuery("#myDashboardComposeEmails").length>0){jQuery("#myDashboardComposeEmails").get(0).reset()}$("#all_type_list tbody tr").removeClass("active");$("#all_type_list tbody td").removeClass("active");$("#other_list_boxes").empty()}}else{jQuery(this).removeClass("message-active");jQuery(this).find("h5").addClass("c-dark");jQuery(this).find("h4").addClass("c-dark");jQuery(this).find("p").addClass("c-gray");jQuery(this).find("a").addClass("c-dark")}});$("#other_list_boxes .message td").removeClass("active");if(!b){jQuery('.DTFC_Cloned tbody tr, .DTFC_Cloned tbody td').removeClass('active');$("#all_type_list tbody td").removeClass("active")}if(b){e.parent().addClass("active")}jQuery("#messages-boxlist").find("ul.todo-box").find("li").each(function(){jQuery(this).removeClass("active");jQuery("#marketLead").get(0).reset()});var j=jQuery("#message-detail").height()-jQuery("#message-detail .panel-heading").outerHeight()+12;j=296;jQuery("#displayEmail").html('<iframe src="'+__baseUrl+"users/email/"+jQuery.trim(a)+'" scrolling="yes" width="100%" height="'+j+'">')
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


function composeEmail(a) {
	if(leadGlobal==0) {
		alert("Please select lead first")
	}
	else {
		if(a==undefined) {
			jQuery("#emailDocUrl").val("");
			jQuery("#attach_droppable").empty()
		}

		jQuery("#anotherSys").val(0);
		refreshContacts();
		jQuery("#emailCC").css("width","725px");
		$("body").append('<div class="modal-backdrop modal-backdrop-drive"></div>');
		openSlidebar(jQuery("#gmail_message_modal"));
		enableZIndex(jQuery("#gmail_message_modal"));
		openSlideBarLeftMessageResize();
		$(".dropdown-toggle").dropdown();
		jQuery("#emailThreadId").val("");
		jQuery("#emailMessageId").val("");
		jQuery("#attach_droppable").empty();
		jQuery("#emailSubject").removeAttr("readonly").val('');
		jQuery("#gmail_message").css("display","block");
		jQuery(".gmail-modal").css("display","block");

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
	}
}

/*jQuery(document).ready(function(){jQuery("#gmail_message_modal").on("hidden.bs.modal",function(){jQuery("body").attr("onselectstart","return false");document.oncontextmenu=new Function("return false")})});*/
function discardEmail(){jQuery("#myDashboardComposeEmails").get(0).reset();jQuery('#emailAccountType').val(1);jQuery("#emailThreadId").val("");jQuery("#emailMessageId").val("");jQuery("#gmail_message_modal").hide();jQuery("#attach_droppable").empty();jQuery("#emailTo").focus();jQuery("#emailMessage").code("<br/><br/><br/><br/>"+jQuery("#original_signature").val());closeSlideBarLeftMessage();checkBodyScrollable();windowResize();checkCampaignModalOpen()}
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
function openNewLeadDialogueBox(){jQuery("#from_litigation,#from_regular,#from_nonacquistion").hide();jQuery('#show_data').removeClass('show').addClass('hide');clearLeadSelectInterval();window.leadGlobal=0;jQuery("#all_type_list").find("tbody").find("tr").removeClass("active");jQuery('.topbar-lead-name').html('');jQuery("#newLeadFormElement").find('#popupLeadname,#popupType').val('');jQuery("#newLeadFormElement").modal("show");/*releaseAll();*/return false}
__TableDT="";
function toggleTableFilter(a){var b=a.parent().parent().parent().parent().parent().parent().parent().parent().prev();b.toggle();return false}
function leadsTableOneLineCells(){$(".one-line-cell").each(function(a,b){var e=$(b);e.html(e.html().replace(/ /g,"&nbsp;"))})}</script>
<script src="<?php echo $awsUrl?>widgets/typing/typing.min.js"></script> <div class="page-mailbox" id="main-content"> <div data-equal-height="true" class="row" style="margin-right:-9px"> <div class="col-md-8 list-messages" style='padding:0px;'> <div class="row row-width" style="margin:0"> <div class="col-width" style='padding:0;width:73px' id='listLabels'> <div class="panel panel-default panel-no-margin panel-blue-border" style="border-right:0px;">
 <?php if($openEmailBox===true){?><!-- <button class="btn btn-default btn-block text-left" type="button" onclick="composeEmail()" style="padding-left:8px;margin-bottom:-1px;margin-top:-1px;border-left:medium none;border-right:medium none">Compose</button> --><div class="list-group emails-group-container"><span class='bbblock active'><a href="javascript:void(0)" data-title="INBOX" onclick="getEmails('messages_container','INBOX',jQuery(this))" class="list-group-item active bbinline pd84">Inbox</a><a href="javascript:void(0)" onclick="getNewEmails('messages_container',0,jQuery(this))" class='pull-right pd81'><img src='<?php echo $awsUrl?>images/1475283531_cloud-download.png' width="15"/></a></span><span class='bbblock'><a href="javascript:void(0)" data-title="STARRED" onclick="getEmails('messages_container','STARRED',jQuery(this))" class="list-group-item label-dropable  bbinline pd84">Starred</a><a href="javascript:void(0)" onclick="getNewEmails('messages_container',1,jQuery(this))" class='pull-right pd81'><img src='<?php echo $awsUrl?>images/1475283531_cloud-download.png' width="15"/></a></span><span class='bbblock'><a href="javascript:void(0)" data-title="LEAD" onclick="getEmails('messages_container','LEAD',jQuery(this))" class="list-group-item  bbinline pd84" style='display:inline-block'>Leads</a><!--<a href='' class='pull-right pd81'><img src='<?php echo $awsUrl?>images/download-icon-cloud.png'/ width="15"/></a>--></span><!--<span class='bbblock'><a href="javascript:void(0)" data-title="NONLEAD" onclick="getEmails('messages_container','NONLEAD',jQuery(this))" class="list-group-item label-dropable  bbinline pd84" style='display:inline-block'>Non</a><a href='' class='pull-right pd81'><img src='<?php echo $awsUrl?>images/download-icon-cloud.png'/ width="15"/></a></span>--><span class='bbblock'><a href="javascript:void(0)" data-title="DRAFT" onclick="getEmails('messages_container','DRAFT',jQuery(this))" class="list-group-item  bbinline pd84" style='display:inline-block'>Draft</a><a href="javascript:void(0)" onclick="getNewEmails('messages_container',2,jQuery(this))" class='pull-right pd81'><img src='<?php echo $awsUrl?>images/1475283531_cloud-download.png' width="15"/></a></span><span class='bbblock'><a href="javascript:void(0)" data-title="SENT" onclick="getEmails('messages_container','SENT',jQuery(this))" class="list-group-item  bbinline pd84" style='display:inline-block'>Sent</a><a href="javascript:void(0)" onclick="getNewEmails('messages_container',3,jQuery(this))" class='pull-right pd81'><img src='<?php echo $awsUrl?>images/1475283531_cloud-download.png' width="15"/></a></span><span class='bbblock'><a href="javascript:void(0)" data-title="TRASH" onclick="getEmails('messages_container','TRASH',jQuery(this))" class="list-group-item label-dropable  bbinline pd84" style='display:inline-block'>Trash</a><a href="javascript:void(0)" onclick="getNewEmails('messages_container',4,jQuery(this))" class='pull-right pd81'><img src='<?php echo $awsUrl?>images/1475283531_cloud-download.png' width="15"/></a></span> <?php }?><?php if((int)$this->session->userdata['user']['type']==9 || in_array(23,$this->session->userdata['modules_assign'])):?> <a href="javascript:void(0)" id='imap_licenses' onclick="getImapEmails('messages_container',jQuery(this),1)" class="list-group-item btn-block pd84" style='margin:0px;padding-right:0px;'>Licenses<span id='license_counter'></span></a><?php endif;?><?php if((int)$this->session->userdata['user']['type']==9 || in_array(26,$this->session->userdata['modules_assign'])):?> <a href="javascript:void(0)" id='imap_operation' onclick="getImapEmails('messages_container',jQuery(this),2)" class="list-group-item btn-block pd84" style='margin:0px;padding-right:0px;'>Patents<span id='operation_counter'></span></a><?php endif;?><a href="javascript:void(0)" onclick="voiceMailCalls()" class="list-group-item btn-block pd84" style='margin:0px;'>V.Mails</a>
 <?php /*if($openEmailBox===true){?><a href="javascript:void(0)" onclick="getNextInboxEmails('messages_container',jQuery(this),100)" class="list-group-item btn-block" style='padding:0px 8px 3px 8px;margin:0px;'>Next 100</a><?php }*/?></div>  </div> </div> <div class="" style='padding:0;margin-top:0;margin-left:0px;z-index:1;float:left' id='listMainContainerModif'> <div class="panel panel-default panel-no-margin panel-blue-border" style=""> <?php if($openEmailBox===true  || in_array(23,$this->session->userdata['modules_assign'])):?> <div class="messages messages-list-leads"> <div data-padding="90" data-height="window" class="withScroll mCustomScrollbar _mCS_116" id="messages-list"> <div style="max-height:300px;min-height:300px;overflow-x:hidden!important;overflow-y:auto!important;max-width:100%" id="mCSB_116" class="mCustomScrollBox mCS-dark-2"> <div style="max-width:100%;overflow:hidden" class="mCSB_container messages_container"> <div class="loading-spinner" id="loading_spinner_heading_messages" style='display:none'> <img src="<?php echo $awsUrl?>images/ajax-loader.gif" alt=""> </div> 
<?php 
			/*if(count($emails)>0){	
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
				$gmailLabel .='</select>';
				foreach($emails as $message){	
					$mainFlag = 0;
					if($mainFlag==0){
						$flag = 0;
						if($flag==0){
							$from ="";													
							$subject="";													
							$date = "";	
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
			?>
			<div class="message-item media draggable" data-date='<?php echo $date?>' data-id="<?php echo $message['message_id']?>" data-message-id="<?php echo $messageIDDD;?>" data-task="0"> <div class="message-item-right"> <div class="media"> <div class="media-body" onclick="findThread('<?php echo $message['message_id']?>',jQuery(this))">
			<h5 class="c-dark"> 
			<?php 
				if(in_array(strtoupper('unread'),$message['labelIds'])){
			?> <strong><a class="c-dark" href="javascript:void(0)"><?php echo $from;?></a></strong> <?php
			} else {
			?> <a class="c-dark" style='font-weight:normal' href="javascript:void(0)"><?php echo $from;?></a> <?php
			}
			?> </h5> 
			<h4 class="c-dark"><?php echo $subject;?></h4> <div> <span class="message-item-date"><?php echo  date('M d, Y',strtotime($date));?></span> &nbsp; <?php 
				$parts = $message['parts'];
				$countAttachments = 0;
				if(isset($parts[0]) && ($parts[0]->mimeType=="multipart/alternative" || $parts[0]->mimeType=="multipart/related")){
					for($i=1;$i<count($parts);$i++){
						$attachmentID = $parts[$i]->getBody()->getAttachmentId();
						if(!empty($attachmentID)){
							$countAttachments++;
						}
					}
				}				
				$starEmail="";				
				if(count($message['labelIds'])>0){
					if(in_array(strtoupper('starred'),$message['labelIds'])){
						$starEmail="<a href='javascript://' onclick='inboxLabelChanged(1,jQuery(this))' data-original-title='Starred' style='float:right;' class='mrg5R clb'><i class='glyph-icon icon-star'></i></a>";
					} else {
						$starEmail="<a href='javascript://' onclick='inboxLabelChanged(0,jQuery(this))' data-original-title='No Starred' style='float:right;' class='mrg5R clb'><i class='glyph-icon icon-star-o'></i></a>";
					}
				}				
				if($countAttachments>0):?>
				<strong><i class="glyph-icon icon-paperclip"></i> <?php echo $countAttachments;?></strong> <?php endif;?> <!--<a href='javascript://' onclick="enableTask(jQuery(this))" style='float:right;width:15px;'><i class="glyph-icon icon-plus"></i></a>--><a href='javascript://' onclick="moveEmailToTrash(jQuery(this))" style='float:right;width:15px;'><i class="glyph-icon"><img src="<?php echo $awsUrl; ?>images/discard.png" style="opacity:0.55;width:10px;"></i></a> <?php echo $starEmail;?> <?php echo $gmailLabel;?></div> </div> </div> </div> </div> 
			<?php
				}
			}
		}												
	}*/
?>
				</div></div></div></div><?php endif;?></div>
				</div><div class=" list-messages" style='padding:0;margin-top:0;margin-left:0px;margin-right:-1px;width:900px;float:left'> <div class="panel panel-default panel-no-margin panel-blue-border" id="old_lead" style='border-left:0px;'> <div class="messages"> <div data-padding="90" data-height="window" class="withScroll mCustomScrollbar _mCS_116" id="messages-boxlist"> <div style="height:300px;overflow-x:hidden!important;overflow-y:auto!important;max-width:100%" id="mCSB_116" class="mCustomScrollBox mCS-dark-2"> 
<script>
	var tableDT="";
	function resetTableFilter(o){
		stringSearch = [];
		jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').find('div.multiSelect:hidden').find("input[type='checkbox']:checked").each(function(){
				if(jQuery.inArray(jQuery(this).val(),stringSearch)<0){
					_mPt = jQuery(this).parent().parent().parent().parent().parent().parent();
					if(_mPt.find('span').hasClass('textRed')==true){
						_mPt.find('span').removeClass('textRed');
					}
					stringSearch.push(_mPt.index());
				}
			});
		jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').find('div.multiSelect:hidden').find("input[type='checkbox']:checked").removeAttr('checked');
		jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').find('div.multiSelect:hidden').find("input[type='checkbox']:checked").prop('checked',false);
		if(stringSearch.length>0){
			for(i=stringSearch.length;i>=1;i--){
				/*console.log(i);*/
				tableDT.columns(stringSearch[i]).search('' ,true,false ).draw();
			}
		}
	}
	function filterTable(o,i){
		jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').find('span').removeClass('textRed');
		jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').eq(i).find('span').addClass('textRed');
		stringSearch = [];
		jQuery("#sortingPopup").find('input[type="checkbox"]:checked').each(function(){
			stringSearch.push(jQuery.trim(jQuery(this).val()));
		});	
		jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').eq(i).find('div.multiSelect:hidden').find("input[type='checkbox']").prop('checked',false);
		jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').eq(i).find('div.multiSelect:hidden').find("input[type='checkbox']").prop('checked',false).removeAttr('checked');
		_iValid = false;
		if(stringSearch.length==0){
			_iValid = true;
		}
		jQuery(stringSearch).each(function(ind,sv){
			jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').eq(i).find('div.multiSelect:hidden').find("input[type='checkbox']").each(function(){
				if(jQuery(this).val()==sv){
					jQuery(this).attr('checked','checked');
					jQuery(this).prop('checked',true);
				}
			}); 
		});
		stP = -1;
		if(jQuery("#sortingPopup").find('input[type="checkbox"]:checked').length==0){
			jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').eq(i).find('span').removeClass('textRed');
		}
		if(jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').find('div.multiSelect:hidden').find("input[type='checkbox']:checked").length==0){
			jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').removeClass('textRed'); 
		} else {
			jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').find('div.multiSelect:hidden').find("input[type='checkbox']:checked").each(function(){
				if(jQuery.inArray(jQuery(this).val(),stringSearch)<0){
					_mPt = jQuery(this).parent().parent().parent().parent().parent().parent();
					if(_iValid===true){
						stP = _mPt.index();
					}
					if(_mPt.find('span').hasClass('textRed')==false){
						_mPt.find('span').addClass('textRed');
					}
					stringSearch.push(jQuery.trim(jQuery(this).val()));
				}
			});
		}
		if(_iValid===true){			  
			tableDT.columns(i).search('' ,true,false ).draw();
			i = stP;
		}
		_stringS = stringSearch.join('|');
		console.log(_stringS);
		tableDT.columns(i).search(_stringS ,true,false ).draw();
	}
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
	
	$(document).ready(function(){
		jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('input[type="text"],textarea').typing({
			delay:1000,
			start:function(){
				console.log('Start.......');
				console.log('CHANGE');
			},
			stop:function(){
				console.log('Stop.......');
				callRunLeadSave();
			}
		});
		getCountOnImap();
		jQuery("#from_litigation,#from_regular,#from_nonacquistion").find('input[type="checkbox"],select,.is-date').change(function(){
			console.log("Change Lead Checkbox");
			callRunLeadSave();
		});
		
		tableDT=$("#all_type_list").DataTable({
			scrollY:"270px",
			scrollX:true,
			scrollCollapse:true,
			searching:true,
			paging:false,
			order: [[ 0, "asc" ]],
			aoColumnDefs: [{
				'bSortable': false,
				'aTargets': ['nosort']
			}],
			fnInitComplete:function(b,a){
				__TableDT=jQuery("#all_type_list").find("tbody").html();
				this.api().columns('.select-filter').eq(0).each(function(index){					
					var column = this.column( index );
					var data = column.data();
					_dH = $(column.header()).html(); 					
					_dpString = '<dl class="dpDropdown"><dt></dt><dd><div class="multiSelect"><ul>';
					column.data().unique().sort().each( function ( d, j ) {
						_str = d;
						_str = _str.replace(/(<([^>]+)>)/ig,"");
						_dpString +='<li><input type="checkbox" value="'+_str+'" onclick="filterTable(jQuery(this),'+index+')">'+_str+'</li>';
						/*select.append( '<option value="'+d+'">'+d+'</option>' )*/
					});
					_dpString +='</ul></div></dd></dl>';
					
					/*jQuery(column.header()).empty().append(_dH+'&nbsp;&nbsp;'+_dpString);*/
					
					jQuery(_dpString).appendTo(jQuery(column.header()).empty()).before(_dH);
					_aSort = jQuery("<a/>").data('order','none').attr('href','javascript://').addClass('mrg19R float-left').append("<i class='glyph-icon icon-sort'></i>").click(function(e){
						e.preventDefault();
						_order = jQuery(this).data('order');
						if(_order=='none'){
							_order = 'asc';
						}
						tableDT.column( index+':visible' ).order( _order ).draw();
						if(_order=='asc'){
							_order = 'desc';
						} else {
							_order = 'asc';
						}
						jQuery(this).data('order',_order);
					});
					jQuery(column.header()).find('span').append(_aSort);
					/*_btnFilter = jQuery('<a/>').attr('href','javascript://').attr('id','tblFilter').append('Filter').addClass('btn btn-primary').attr('onclick','filterTable(jQuery(this))');	*/				
					_a = jQuery("<input/>").attr('type','checkbox').click(function(e){						
						e.preventDefault();
						if(jQuery("#sortingPopup").is(':visible')==true){
							jQuery("#sortingPopup").modal('hide');
						} else {
							_width = jQuery(this).parents('th').width();
							_width = _width + 80;
							if(_width>300){
								_width = 300;
							}
							_postion = jQuery(this).offset();
							_left = _postion.left + 350;
							jQuery("#sortingPopup").find('div.modal-body').empty().html('<div style="overflow:auto;" id="onspot_fill"></div>');
							_indX = jQuery(this).parent().parent().parent().index();
							if(_indX>0){
								_addDistinct = [];
								_dpString = "<div class='multiSelect'><ul>";
								jQuery("#all_type_list").find("tbody").find('tr').each(function(){
									_str = jQuery(this).find('td').eq(_indX).text();
									if(jQuery.inArray(_str,_addDistinct)<0){
										check='';
										if(jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').eq(_indX).find('div.multiSelect:hidden').find("input[type='checkbox']:checked").length>0){
											jQuery("#all_type_list_wrapper").find("div.dataTables_scrollHeadInner").find('table>thead').find('th').eq(_indX).find('div.multiSelect:hidden').find("input[type='checkbox']:checked").each(function(){
												if(jQuery.trim(jQuery(this).val())==jQuery.trim(_str)){
													check = "CHECKED='CHECKED'";
													return;
												}
											})
										}
										_dpString +='<li><input data-p type="checkbox" '+check+' value="'+_str+'" onclick="filterTable(jQuery(this),'+_indX+')">'+_str+'</li>';
										_addDistinct.push(_str);
									}
								});
								_dpString += "</ul></div>";
								jQuery("#sortingPopup").find('div.modal-body').find('div#onspot_fill').append(_dpString);
							} else {
								jQuery("#sortingPopup").find('div.modal-body').find('div#onspot_fill').append(jQuery(this).parent().parent().find('div.multiSelect:hidden').parent().html());
							}
							jQuery("#sortingPopup").find('div.modal-body').find('div.multiSelect:hidden').css('display','');
							jQuery("#sortingPopup").find('div.modal-body').find('a#tblFilter').css('display','inline-block');
							_height = jQuery("#sortingPopup").find('div.modal-body').find('div.multiSelect:hidden').height();
							if(_height==0 || _height>300){
								_height = 300;
							}
							if(jQuery("#sortingPopup").find('div.modal-body:hidden').length==1){
								jQuery("#sortingPopup").find('div.modal-body:hidden').find('div#onspot_fill').css('height',_height+'px');
							} else {
								jQuery("#sortingPopup").find('div.modal-body').find('div#onspot_fill').css('height',_height+'px');
							}						
							jQuery("#sortingPopup").find(".modal-content").css({width:_width+"px",'float':'left'});
							jQuery("#sortingPopup").css({left:_left+"px",top:'-49px'});
							jQuery("#sortingPopup").modal('show');
						}
					});
					jQuery(column.header()).find('dt').empty().append(_a);
					/*jQuery(column.header()).find('div.multiSelect').prepend(_btnFilter);*/
					jQuery(column.header()).find('div.multiSelect').css('display','none');
					
					/*
					var select = jQuery('<select />')
						.appendTo(
							jQuery(column.header()).empty()
						).addClass('dropdown-filter').css('width','100px').before(_dH+'&nbsp;&nbsp;').on( 'change', function () {
							column
								.search( jQuery(this).val() )
								.draw();
						} );
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					});*/
				});
				// console.log(location.href.indexOf('/dashboard/index/') !== -1);
				if(location.href.indexOf('/dashboard/index/') !== -1) {
					var highlightedLeadId = location.href.split('/dashboard/index/')[1];

					// jQuery("#all_type_list").find("tbody").find("tr").removeClass("active");
					// _index=jQuery("#all_type_list").find("tbody").find('tr[data-id="'+highlightedLeadId+'"]').index();
					// jQuery("#all_type_list").find("tbody").find("tr").eq(_index).addClass("active");
					// jQuery(".DTFC_Cloned").find("tbody").find("tr").eq(_index).addClass("active");
					// _scrollTop=jQuery("#all_type_list").find("tbody").find("tr.active").offset();
					// console.log(_scrollTop);

					// if(jQuery("#dashboard_charts").is(":visible")){
					// 	jQuery("#all_type_list").parent().scrollTop(_scrollTop.top-163.5)
					// } else {
					// 	jQuery("#all_type_list").parent().scrollTop(_scrollTop.top-106)
					// }

					setTimeout(function() {
						var offsetTop = jQuery("#all_type_list").find("tbody").find('tr[data-id="'+highlightedLeadId+'"]').offset().top;
						jQuery("#all_type_list").parent().scrollTop(0);
						jQuery("#all_type_list").parent().scrollTop(offsetTop-106);
						runTableLeadBal();
						// console.log([highlightedLeadId, offsetTop-106]);
					}, 500);

				}
				setTimeout(function(){jQuery("#header-nav-left").find("div.dropdown-menu").css('left','-230px');},500);
				removeDTResizeEvents();
			},
			fnDrawCallback: function() {
				checkMyEmailsHeight();
			}
		})
	});
	</script>

	<table class="table" id="all_type_list" style="border-left:none;border-right:0;width:599px!important"> <thead> <tr> <th class="no-sort select-filter nosort" style="text-align:center;border-right:0;border-left:none;width:200px"> <div class="prelative"> 
	<span style="width:55px; display:inline-block">Lead</span><a href='javascript://' class='pabsolute' style='right:0;padding:0;min-width:0;border-radius:3px;width:18px;' onclick='return toggleTableFilter($(this))'> <i class="glyph-icon icon-search"></i></a><a class='pabsolute' style='right:20px;padding:0;min-width:0;border-radius:3px;width:40px;font-size:11px;color:#2196F3 !important;' onclick='return resetTableFilter($(this))'>Reset</a></div> </th> <th style="text-align:left;border-right:0;border-left:none;" class='select-filter nosort'><span title="S/N" style="width:35px; display:inline-block"></span></th><th style="text-align:left;border-right:0;border-left:none;" class='select-filter nosort'><span title="Attractive" style="width:20px; display:inline-block"></span></th><th style="text-align:left;border-right:0;border-left:none;" class='select-filter nosort'><span title="Type" style="width:25px; display:inline-block"></span></th> <th style="text-align:left;border-right:0;border-left:none;" class='select-filter nosort'><span title="Last" style="width:53px; display:inline-block">Last</span></th><th style="text-align:left;border-right:0;border-left:none" class='select-filter nosort'><span title="EOU" style='width:40px;display:inline-block'>E</span></th><th style="text-align:left;border-right:0;border-left:none" class='select-filter nosort'><span title="Broker" style='width:95px;display:inline-block'>Broker Firm</span></th><th style="text-align:left;border-right:0;border-left:none" class='select-filter nosort'><span title="Broker">Broker</span></th><th style="text-align:left;border-right:0;border-left:none" class='select-filter nosort'><span title="Seller">Seller</span></th><th style="text-align:left;border-right:0;border-left:none;" class='select-filter nosort'><span title="Info" style="width:65px; display:inline-block">Info</span></th><th style="text-align:left;border-right:0;border-left:none;" class='select-filter nosort'><span title="Synpat" style="width:75px; display:inline-block">Synpat</span></th><th style="text-align:left;border-right:0;border-left:none;" class='select-filter nosort'><span title="Seller" style="width:75px; display:inline-block">Seller</span></th><th style="text-align:left;border-right:0;border-left:none;" class='select-filter nosort'><span title="Create" style="width:75px; display:inline-block">Create</span></th><th style="text-align:left;border-right:0;border-left:none;" class='select-filter nosort'><span title="PPA" style="width:65px; display:inline-block">PPA</span></th> <th style="text-align:left;border-right:0;border-left:none;" class='select-filter nosort'><span title="Close" style="width:75px; display:inline-block">Close</span></th> <th style="text-align:left;border-right:0;border-left:none;min-width:110px;" class='select-filter nosort'><span title="Title1">Name, Title1</span></th> <th style="text-align:left;border-right:0;border-left:none;min-width:110px;" class='select-filter nosort'><span title="Title2">Name, Title2</span></th> <th style="text-align:left;border-right:0;border-left:none;min-width:110px;" class='select-filter nosort'><span title="Tech. / Markets">Tech. / Markets</span></th> </tr> </thead> <tbody>
	<?php 
		if(count($incomplete)>0){
			$noShot = '<em>Blank</em>';
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
				$sellerInfo = $noShot;
				$createDate = date('m/d/y',strtotime($message->create_date));
				if($message->seller_info_text!="" && $message->seller_info_text!=null){
					$sellerInfo = date('m/d/y',strtotime($message->seller_info_text));
				}
				$sellerLike = $noShot;
				if($message->seller_like!="" && $message->seller_like!=null){
					$sellerLike = date('m/d/y',strtotime($message->seller_like));
				}
				$synpatLike = $noShot;
				if($message->synpat_like!="" && $message->synpat_like!=null){
					$synpatLike = date('m/d/y',strtotime($message->synpat_like));
				}
				$ppa = $noShot;
				if($message->ppa_date!="" && $message->ppa_date!=null){
					$ppa = date('m/d/y',strtotime($message->ppa_date));
				}
				$fundingTrnsfr = $noShot;
				if($message->funding_trnsfr!="" && $message->funding_trnsfr!=null){
					$fundingTrnsfr = date('m/d/y',strtotime($message->funding_trnsfr));
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
				}
				$brokerContact = $noShot;
				if(!empty($message->broker_contact)){
					$brokerContact = $message->broker_contact;
				}
				$broker_person_contact = $noShot;
				if(!empty($message->broker_person_contact)){
					$broker_person_contact = $message->broker_person_contact;
				}
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
				$lastSeen = '';
				$eou=0;
				if(isset($message->lead_last_seen) && $message->lead_last_seen!='0000-00-00'){
					$lastSeen = date('m/d/y',strtotime($message->lead_last_seen));
				}
				if(isset($message->eou)){
					$eou= (int) $message->eou;
				} else {
					$eou= 0;
				}
				
				$attractive = (int)$message->attractive;
				if($mainFlag == 0){
	?> <tr class="border-blue-alt droppable old_lead <?php echo $main;?>" data-sr="<?php echo $message->serial_number?>" data-id="<?php echo $message->id?>" data-type="<?php echo $message->type?>" onclick="threadDetail(jQuery(this))" <?php if($stage=="Oppt."):?>ondblclick="opportunityRedirect('<?php echo $message->id?>');"<?php endif;?>><td style="padding:3px 2px;border-right:0;border-left:none;/*width:210px*/" data-id="<?php echo $message->id?>" data-type="<?php echo $message->type?>" class=""><label><a style='text-align:left' title="<?php echo $message->lead_name;?>" class='btn' href="javascript:void(0)"><?php echo substr($message->lead_name,0,30);?></a></label></td><td style="padding:3px 2px;border-right:0;border-left:none;width:35px"><?php echo $message->serial_number?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:20px" class=' one-line-cell'><?php echo $attractive;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:25px"><?php echo $type;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:53px" class=' one-line-cell'><?php echo $lastSeen;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none;width:40px;text-align:center;"><?php echo $eou;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none;width:95px;"><?php echo $brokerContact;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $broker_person_contact;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $sellerContact;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class='<?php echo $sellerClass;?> one-line-cell'><?php echo $sellerInfo;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px"><div style="white-space:nowrap"><?php echo $synpatLike;?></div></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px"><div style="white-space:nowrap"><?php echo $sellerLike;?></div></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px" class=' one-line-cell'><?php echo $createDate;?></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px"><div style="white-space:nowrap"><?php echo $ppa;?></div></td><td style="padding:3px 2px;border-right:0;border-left:none;width:71px"><div style="white-space:nowrap"><?php echo $fundingTrnsfr;?></div></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $person_name_1;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $person_name_2;?></td><td class="one-line-cell" style="padding:3px 2px;border-right:0;border-left:none"><?php echo $relates_to;?></td></tr><?php
					} 
				}
			}
		?> </tbody> </table> </div> </div> </div> </div> </div> <!--div class="col-xs-6 list-messages" style='padding:0;margin-top:0'> <div class="panel panel-default panel-no-margin panel-blue-border" style='min-height:302px;max-height:302px;height:302px;overflow-y:scroll;margin-right:2px; position: relative; z-index: 10;'> <div id="other_list_boxes"></div> </div> </div--> </div> </div> <div class="col-lg-4 col-md-4 email-hidden-sm detail-message" style="padding:0;margin-top:0;margin-left:0px;border:1px solid #2196f3;background:#fff;border-left:0px;" id="displayEmail"></div> </div> </div> <?php
					
		else:		
		?> <script>window.location="<?php echo $service->createAuthUrl()?>";</script> <?php
		endif;
		die;
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */