<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leads extends CI_Controller {
	public $_import_contacts_data = array();
	public $skey = "sYnP@TpRoJ3cT5@%"; // you can change it
	function __construct(){
		parent::__construct();
		$this->load->library('DriveServiceHelper'); 
		$service = new GmailServiceHelper();
		$skipMethods = array('remove_precontacts','pre_contacts','update_companies_from_duplicates','business_cards_list','delete_scan_card');
		if(!in_array($this->router->fetch_method(),$skipMethods)){
			if(empty($this->session->userdata('email'))){
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
		} 
		
		/*$this->clear_cache();*/
		$this->layout->layout='default';
	}
	/*
	public function clear_cache(){
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }*/
	public function index()
	{
		$this->layout->auto_render=false;		
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('client/index');
	}
	
	public function patent_family_list($leadID){
		$this->load->model('lead_model');
		$data = array();
		$data['all_family'] = $this->lead_model->getAllEPOFamilies($leadID);
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'EPO Data';
		$this->layout->render('leads/epo_family',$data);
	}
	
	/*public function patent_illustration($patentNumber = null){
		$this->load->model('lead_model');
		$data['patent_family'] = array();
		if($patentNumber!=null){
			$data['patent_family'] = $this->lead_model->getAllEPOFamiliesByPatent($patentNumber);
		}
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Patent Famil';
		$this->layout->render('leads/illustration',$data);
	}*/
	
	public function family_data($patentNumber){
		$data = array('id'=>0);
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		
		try{
			$epoDocToken = $this->epodoc->read_token('HedCET');	
			
			if(! $epoDocToken['error']) {
				$patentType = 'publication';
				if(strlen($patentNumber)==11 || strlen($patentNumber)==13){
					$patentNumber = substr($patentNumber,0,-2);
				}
				if(strlen($patentNumber)==13){
					$patentType = 'application';
				}
				$getFamilyData = $this->epodoc->runUrl($epoDocToken,'family',$patentType,'epodoc',$patentNumber,'legal');
				if(empty($getFamilyData['error'])){
					echo "<pre><code>";
					print_r($getFamilyData['data']);
					echo "</code></pre>";
					die;
					if(!empty($getFamilyData['data'])){
						$xml=simplexml_load_string($getFamilyData['data']);
						if ($xml !== false) {
							$xmlObject = new SimpleXMLElement($getFamilyData['data']);
							$patentObject = $xmlObject->xpath('//ops:patent-family');
							$listOfFamily = $xmlObject->xpath('//ops:family-member');
							$familyList = array();
							if(count($listOfFamily)>0){
								foreach($listOfFamily as $family){
									$familyID = (string)$family['family-id'];
									$publicationReference = $family->{'publication-reference'}->{'document-id'};
									$publicationNumber = "";
									$publicationDate = "";
									$country="";
									$kind="";
									$applicationNumber = "";
									$applicationOriginal = "";
									$applicationDate = "";
									$applicationCountry="";
									$applicationKind="";	
									$applicants = array();
									$inventors = array();
									$title = "";
									if(count($publicationReference)>0){
										foreach($publicationReference as $pubRef){	
											if((string)$pubRef['document-id-type']=="epodoc"){
												$publicationNumber = (string)$pubRef->{'doc-number'};
												$publicationDate = (string)$pubRef->{'date'};
											} else if((string)$pubRef['document-id-type']=="docdb"){
												$country = (string)$pubRef->{'country'};
												$kind = (string)$pubRef->{'kind'};
											}
										}
									}
									$applicationReference = $family->{'application-reference'}->{'document-id'};
									if(count($applicationReference)>0){
										foreach($applicationReference as $appRef){	
											if((string)$appRef['document-id-type']=="docdb"){
												$applicationCountry = (string)$appRef->{'country'};
												$applicationKind = (string)$appRef->{'kind'};
												$applicationNumber = (string)$appRef->{'doc-number'};
												$applicationDate = (string)$appRef->{'date'};
											}
										}
									}
									/*$biblioData = $family->{'exchange-document'}->{'bibliographic-data'};
									$appOriginal = $biblioData->{'application-reference'};
									if(count($appOriginal->{'document-id'})>0){
										foreach($appOriginal->{'document-id'} as $appRefOrg){
											if((string)$appRefOrg['document-id-type']=="original"){
												$applicationOriginal = (string)$appRefOrg->{'doc-number'};
											}
										}
									}
									$parties = $biblioData->parties->applicants;									
									$allInventors = $biblioData->parties->inventors;
									if(count($parties->applicant)>0){
										foreach($parties->applicant as $party){
											$applicants[] = (string)$party->{'applicant-name'}->name;
										}
									}
									if(count($allInventors->inventor)>0){
										foreach($allInventors->inventor as $inventor){
											$inventors[] = (string)$inventor->{'inventor-name'}->name;
										}
									}*/
									/*$title = (string) $biblioData->{'invention-title'};*/
									$title = "";
									$familyList[] = array('family_id'=>$familyID,'publicationNumber'=>$publicationNumber,'publicationDate'=>$publicationDate,'country'=>$country,'kind'=>$kind,'applicationNumber'=>$applicationNumber,'applicationOriginal'=>$applicationOriginal,'applicationDate'=>$applicationDate,'applicationCountry'=>$applicationCountry,'applicationKind'=>$applicationKind,'applicants'=>$applicants,'inventors'=>$inventors,'title'=>$title);
								}
							}
							if(count($familyList)>0){
								/*Check FamilyID Patent relation*/
								$this->load->model('lead_model');
								foreach($familyList as $family){
									$checkPatentRelation = $this->lead_model->checkFamilyPatentRelation($family['family_id'],$patentNumber);
									if($checkPatentRelation==0){
										$data['id'] = $this->lead_model->insertFamilyPatentRelation(array('family_id'=>$family['family_id'],'patent_id'=>$patentNumber));
									}
									$checkFamilyMember = $this->lead_model->checkFamilyMember($family['family_id'],$family['publicationNumber'],$family['applicationNumber']);
									if(count($checkFamilyMember)==0){
										$data['id'] = $this->lead_model->insertPatentFamilyMember(array('family_id'=>$family['family_id'],'publication_number'=>$family['publicationNumber'],'publication_date'=>$family['publicationDate'],'publication_country'=>$family['country'],'publication_kind'=>$family['kind'],'application_number'=>$family['applicationNumber'],'application_date'=>$family['applicationDate'],'application_country'=>$family['applicationCountry'],'application_kind'=>$family['applicationKind'],'application_original'=>$family['applicationOriginal'],'title'=>$family['title'],'applicants'=>json_encode($family['applicants']),'inventors'=>json_encode($family['inventors'])));
									} else{
										$data['id'] = $checkFamilyMember->id;
									}
								}
							}
						}
					}
				} else {
					/*echo $getFamilyData['error'];*/
				}
			}
		}catch(Exception $e){
			
		}
		echo json_encode($data);
		die;	
	}
	
	public function captcha_image(){
		$data['id'] = $this->input->get('ID');
		$data['imgsrc'] = $this->input->get('img');
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Captcha Image';
		$this->layout->render('leads/captcha_image',$data);
	}
	
	public function patent_illustration($patentNumber = null){
		$this->load->model('lead_model');
		/*$data['patent_family'] = array();
		if($patentNumber!=null){
			$data['patent_family'] = $this->lead_model->findPatentFamilyChild($patentNumber);
		}*/
		$data['number'] = $patentNumber;
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Patent Famil';
		$this->layout->render('leads/illustration',$data);
	}
	
	
	
	public function messages($messageType=0,$leadID=0){
		/*MessageType=>0 for Messages Sent and MessageType=>1 is received*/
		$this->load->model('lead_model');
		$data['heading'] = "Messages I Sent";
		if($messageType==1){
			$data['heading'] = "Messages For Me";
		}
		$data['listConversation'] = $this->lead_model->getMessageTaskList($this->session->userdata['id'],$leadID,$messageType);
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('leads/messages',$data);
	}
	
	public function user_task_list($taskType=0,$leadID=0){
		/*taskType=>0 for Task I created and taskType=>1 is Tasks Created For Me*/
		$this->load->model('lead_model');
		if($taskType==1 && $leadID==0){
			$data['mycreatedTaskList'] = $this->lead_model->waitingCalApproval($this->session->userdata['id']);
		} else if($taskType==1 && $leadID>0) {
			$data['mycreatedTaskList'] = $this->lead_model->getAllTaskMeFromLead($leadID);
		} else if($taskType==0 && $leadID==0){
			$data['mycreatedTaskList'] = $this->lead_model->waitingICalApproval($this->session->userdata['id']);
		} else if($taskType==0 && $leadID>0){
			$data['mycreatedTaskList'] = $this->lead_model->myTaskApproval($leadID);
		}
		$data['taskType'] = $taskType;
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'User task list';
		$this->layout->render('leads/user_task_list',$data);
	}
	
	function save_linkedin_query(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$getQueryData = $this->lead_model->getLinkedinQueryData();
			if(count($getQueryData)==0){
				/*Insert */
				$data = $this->lead_model->insertLinkedInQuery($this->input->post());
			} else {
				$data = $this->lead_model->updateLinkedInQuery($this->input->post(),$getQueryData->id);
			}			
		}
		echo $data;
		die;
	}
	
	function deleteFreePreContact(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->deleteFreePreContact($_POST['id']);
		}
		echo $data;
		die;
	}
	
	function findSalesCompaniesPeopleInLead(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->getSalesContatcsByLead($_POST['l']);
		}
		echo json_encode($data);
		die;
	}
	
	function findSalesCompaniesInLead(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('client_model');
			$data = $this->client_model->getAllCompaniesWithMem($_POST['l']);
		}
		echo json_encode($data);
		die;
	}
	
	function import_file_dr1(){
		$url = "https://api.fullcontact.com/v2/cardReader?webhookUrl=http://backyard.synpat.com/leads/import_data_from_full_contact_webhook&apiKey=8c3cd4e4ac3c5abf&verified=medium";
		
		$imageAsBase64 = base64_encode(file_get_contents('http://goo.gl/0SHjZ4')); 
		$requestBody = array(); 
		$requestBody['front'] = $imageAsBase64;
		$connection = curl_init(); 
		curl_setopt($connection, CURLOPT_URL, $url); 
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($connection, CURLOPT_POST, true); 
		curl_setopt($connection, CURLOPT_POSTFIELDS, json_encode($requestBody)); 
		curl_setopt($connection, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		$result = curl_exec($connection);
		echo "<pre>";
		echo "1";
		print_r($result);
		die;
	}
	
	function import_data_from_full_contact_webhook(){
		$this->load->model('lead_model');
		$saveData = array('message'=>$this->input->post());
		$data = $this->lead_model->insertFreePreContacts($saveData);
	}
	
	function fetch_list_full_contacts($page=0){
		$this->_import_contacts_data = array();
		$data = $this->retrieveContactFromFullContactsAPI(0);
		echo "<pre>";
		print_r($this->_import_contacts_data);
		die;
	}
	
	function retrieveContactFromFullContactsAPI($page){
		$url = "https://api.fullcontact.com/v2/cardReader?page=".$page."&apiKey=8c3cd4e4ac3c5abf";
		$data = array();
		$connection = curl_init(); 
		curl_setopt($connection, CURLOPT_URL, $url); 
		curl_setopt($connection, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($connection, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		$result = curl_exec($connection);
		if(!empty($result)){
			$data = json_decode($result,true);
			if(count($data)>0){
				if($data['count']>0){					
					$this->load->model('lead_model');
					for($i=0;$i<count($data['results']);$i++){
						if(isset($data['results'][$i]['contact'])){
							$row = $data['results'][$i]['contact'];
							$this->_import_contacts_data[] = $this->arrangeCardData($data['results'][$i]);
							$this->lead_model->insertPreContacts($this->arrangeCardData($data['results'][$i]));
						}
					}
					if($page<$data['totalPages']-1){
						$data = $this->retrieveContactFromFullContactsAPI((int)$page+1);
					}
				}		
			}
		}
		return $data;
	}
	
	function updatePreContactByFullContact($contactDetail){
		$insertData = $this->arrangeCardData($contactDetail);
		if(count($insertData)>0){
			$this->load->model('lead_model');
			$fullContact= $contactDetail['contactId'];
			$this->lead_model->updatePreContactByFullContact($fullContact,$insertData);
		}	
	}
	
	function arrangeCardData($contactDetail){
		$insertData = array();
		if(!empty($contactDetail['contactId'])){
			$address="";
			$row = $contactDetail['contact'];
			$email = "";
			$secondaryEmail = "";
			if(isset($row['emails'][0]['value']) && !empty($row['emails'][0]['value'])){
				$email = $row['emails'][0]['value'];
			}
			if(isset($row['emails'][1]['value']) && !empty($row['emails'][1]['value'])){
				$secondaryEmail = $row['emails'][1]['value'];
			}
			if(isset($row['addresses'])){
				if(isset($row['addresses'][0]['streetAddress']) && !empty($row['addresses'][0]['streetAddress'])){
					$address = $row['addresses'][0]['streetAddress'];
				}
				if(isset($row['addresses'][0]['locality']) && !empty($row['addresses'][0]['locality'])){
					$address .= ', '.$row['addresses'][0]['locality'];
				}
				if(isset($row['addresses'][0]['region']) && !empty($row['addresses'][0]['region'])){
					$address .= ', '.$row['addresses'][0]['region'];
				}
				if(isset($row['addresses'][0]['postalCode']) && !empty($row['addresses'][0]['postalCode'])){
					$address .= ', '.$row['addresses'][0]['postalCode'];
				}
				if(isset($row['addresses'][0]['country']) && !empty($row['addresses']['country'])){
					$address .= ', '.$row['addresses'][0]['country'];
				}
			}
			$firstName ='';
			$lastName ='';
			if(isset($row['name']['givenName']) && !empty($row['name']['givenName'])){
				$firstName = $row['name']['givenName'];
			}
			if(isset($row['name']['familyName']) && !empty($row['name']['familyName'])){
				$lastName = $row['name']['familyName'];
			}						
			$company = "";
			if(isset($row['organizations'][0]['name']) && !empty($row['organizations'][0]['name'])){
				$company = $row['organizations'][0]['name'];
			}
			$title = "";
			if(isset($row['organizations'][0]['title']) && !empty($row['organizations'][0]['title'])){
				$title = $row['organizations'][0]['title'];
			}
			$telephone = "";
			$cellphone = "";
			if(isset($row['phoneNumbers']) && count($row['phoneNumbers'])>0){
				for($p=0;$p<count($row['phoneNumbers']);$p++){
					if(isset($row['phoneNumbers'][$p]['type']) && $row['phoneNumbers'][$p]['type']=="Work"){
						$cellphone = $row['phoneNumbers'][$p]['value'];
					}
					if(isset($row['phoneNumbers'][$p]['type']) && $row['phoneNumbers'][$p]['type']=="General/phone"){
						$telephone = $row['phoneNumbers'][$p]['value'];
					}
				}
			}	
			$fullContact= $contactDetail['contactId'];
			$imgCard =array();
			if(count($row['photos'])>0){
				foreach($row['photos'] as $photo){
					$imgCard[] = $photo['value'];
				}
			}
			$linkedIN = "";
			$twitter = "";
			if(isset($row['accounts']) && count($row['accounts'])>0){
				foreach($row['accounts'] as $account){
					if($account['domain']=='twitter.com'){
						$twitter = $account['urlString'];
					}
					if($account['domain']=='linkedin.com'){
						$linkedIN = $account['urlString'];
					}
				}
			}
			$insertData = array('first_name'=>$firstName,'last_name'=>$lastName,'email'=>$email,'company_name'=>$company,'job_title'=>$title,'address'=>$address,'telephone'=>$telephone,'fullcontact'=>$fullContact,'cellphone'=>$cellphone,'profile_url'=>$linkedIN,'twitter'=>$twitter,'img_card'=>json_encode($imgCard));
		}
		return $insertData;
	}
	
	function updateContactByFullContact($contactDetail){
		$insertData = $this->arrangeCardData($contactDetail);
		$insertData['phone'] = $insertData['cellphone'];
		$insertData['linkedin_url'] = $insertData['profile_url'];
		unset($insertData['company_name']);
		unset($insertData['cellphone']);
		unset($insertData['profile_url']);
		if(count($insertData)>0){
			$this->load->model('lead_model');
			$fullContact= $contactDetail['contactId'];
			$this->lead_model->updateContactByFullContact($fullContact,$insertData);
		}		
	}
	
	function open_project_contact_data_update(){
		$data = array();
		if(isset($_POST)&& count($_POST)>0){
			$this->load->model('lead_model');
			$checkDataInLeadOpenProject = $this->lead_model->checkOpenProjectData($this->input->post('lead_id'),$this->input->post('type'));
			if(count($checkDataInLeadOpenProject)==0){
				/*Insert*/
				$data['id'] = $this->lead_model->insertOpenProjectData($this->input->post());
			} else {
				/*Update*/
				$data['id'] = $this->lead_model->updateOpenProjectData($this->input->post(),$checkDataInLeadOpenProject->id);
			}
		}
		echo json_encode($data);
		die;
	}
	
	function import_file_dr(){
		$data = array('error'=>'','data'=>'');
		if(isset($_POST) && count($_POST)>0){
			if(!empty($_POST['id'])){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$getFileInfo = $service->getFileInfo($_POST['id']);	
				$fileNameImage = '';
				if(is_object($getFileInfo) && isset($getFileInfo->title) && !empty($getFileInfo->title)){
					$downloadContent = $service->downloadFile($getFileInfo);
					if($downloadContent!=null){
						$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/businesscards/'.$getFileInfo->title, "w+");
						fwrite($fh, $downloadContent);
						fclose($fh);
						$filePath = $_SERVER['DOCUMENT_ROOT'].'/public/upload/businesscards/'.$getFileInfo->title;
						if(is_readable($filePath) ){
							$fileNameImage = 'http://backyard.synpat.com/public/upload/businesscards/'.$getFileInfo->title;
							$applicationId = 'synpat_business_cards';
							$password = 'Ec605h+GvehNKmxnLaSRgagj';
							$url = 'http://cloud.ocrsdk.com/processImage?language=english&exportFormat=rtf';
							$curlHandle = curl_init();
							curl_setopt($curlHandle, CURLOPT_URL, $url);
							curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
							curl_setopt($curlHandle, CURLOPT_POST, 1);
							curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
							$post_array['my_file'] = new CurlFile($filePath,$getFileInfo->mimeType,$getFileInfo->title);
							/*array(
							  "my_file"=>"@".$filePath,
							);*/
							curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $post_array); 
							$response = curl_exec($curlHandle);
							if($response == TRUE) {
								$httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
								curl_close($curlHandle);
								$xml = simplexml_load_string($response);
								if($httpCode == 200) {
									$arr = $xml->task[0]->attributes();
									$taskStatus = $arr["status"];
									if($taskStatus == "Queued") {
										// Task id
										$taskid = $arr["id"];  
										$url = 'http://cloud.ocrsdk.com/getTaskStatus';
										$qry_str = "?taskid=".$taskid;
										while(true)
										{
											sleep(5);
											$curlHandle = curl_init();
											curl_setopt($curlHandle, CURLOPT_URL, $url.$qry_str);
											curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
											curl_setopt($curlHandle, CURLOPT_USERPWD, "$applicationId:$password");
											curl_setopt($curlHandle, CURLOPT_USERAGENT, "PHP Cloud OCR SDK Sample");
											$response = curl_exec($curlHandle);
											$httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
											curl_close($curlHandle);
											$xml = simplexml_load_string($response);
											if($httpCode == 200) {
												$arr = $xml->task[0]->attributes();
												$taskStatus = $arr["status"];
												if($taskStatus == "Queued" || $taskStatus == "InProgress") {
													continue;
												}
												if($taskStatus == "Completed") {
													break;
												}
												if($taskStatus == "ProcessingFailed") {
													$data = array('error'=>"Task processing failed: ".$arr["error"],'data'=>'');
													break;
												}
												$data = array('error'=>"Unexpected task status ".$taskStatus,'data'=>'');
											} else {
												if(property_exists($xml, "message")) {
													$data = array('error'=>$xml->message,'data'=>'');
												} else {
													$data = array('error'=>$response,'data'=>'');
												}
											}
										}
										if(isset($arr["resultUrl"]) && !empty($arr["resultUrl"])){
											$url = $arr["resultUrl"];  
											$curlHandle = curl_init();
											curl_setopt($curlHandle, CURLOPT_URL, $url);
											curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
											curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
											$response = curl_exec($curlHandle);
											curl_close($curlHandle);	
											$fileNameRtf = time().'.rtf';
											$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/businesscards/'.$fileNameRtf, "w+");
											fwrite($fh, $response);
											fclose($fh);
											$this->load->library('RtfHtml');
											$reader = new RtfReader();
											$rtf = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/public/upload/businesscards/'.$fileNameRtf);
											$reader->Parse($rtf);
											/*$reader->root->dump();*/
											$formatter = new RtfHtml();
											$content =  $formatter->Format($reader->root);
											$data = array('error'=>'','data'=>$content,'file'=>$fileNameImage);
										} else {
											$data = array('error'=>"Process failed",'data'=>'');
										}										
									} else {
										$data = array('error'=>$taskStatus,'data'=>'');
									}									
								} else {
									if(property_exists($xml, "message")) {
										$data = array('error'=>$xml->message,'data'=>'');
									} else {
										$data = array('error'=>$response,'data'=>'');
									}
								}
							} else {
								$errorText = curl_error($curlHandle);
								curl_close($curlHandle);
								$data = array('error'=>$errorText,'data'=>'');
							}
						}						
					}
				}				
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function litigation(){
		redirect("dashboard");
	}
 

	public function market(){		
		$data = array();
		$this->load->library('user_agent');
		if(isset($_POST) && count($_POST)>0){
			redirect("dashboard");
		} else {
			$this->load->library('DriveServiceHelper');
			if(!isset($_SESSION)){
				session_start();
			}
			$service = new GmailServiceHelper();
			$data = array();
			if(isset($_REQUEST['code']) && $_REQUEST['code']!=""){				
				$service->clientAuthenticate($_REQUEST['code']);
				$_SESSION['another_access_token'] = $service->getAccessToken();
				$_SESSION['access_token'] = $service->getAccessToken();
				$this->load->model('user_model');
				$this->user_model->updateUserData(array("google_token"=>$service->getAccessToken()),$this->session->userdata['id']);
				$dataLog = '----------FIRST PART---------------------------\n';
				$dataLog .= $this->session->userdata['id'].'-------------------------------------\n';
				$dataLog .= date('Y-m-d H:i:s').'-----------\n\n';
				$dataLog .='Request Code: @'.$_REQUEST['code'].'@@------------\n';
				$dataLog .='GET Code: @'.$service->getAccessToken().'@@------------\n';
				$dataLog .= '--------------FINISH-----------------------\n';
				$fh = fopen($_SERVER['DOCUMENT_ROOT']."/public/upload/log_gmail.txt","a");
				fwrite($fh,$dataLog);
				fclose($fh);
			} else if(isset($_REQUEST['error'])){
				$dataLog = '----------ERROR---------------------------\n';
				$dataLog .= $this->session->userdata['id'].'-------------------------------------\n';
				$dataLog .= date('Y-m-d H:i:s').'-----------\n\n';
				$dataLog .='Request Code: '.$_REQUEST['error'].'@@------------\n';
				$dataLog .='GET Code: ------@@------------\n';
				$dataLog .= '--------------FINISH-----------------------\n';
				$fh = fopen($_SERVER['DOCUMENT_ROOT']."/public/upload/log_gmail.txt","a");
				fwrite($fh,$dataLog);
				fclose($fh);
				$_SESSION['guess_login'] = 1;
				$_SESSION['another_access_token'] = '';
				$_SESSION['access_token'] = '';
			} else {
				redirect('login/logout/1/1');
			}
		}
		redirect("dashboard");
	}
	
	public function find_syndicate_price(){
		$data = array('cost_price'=>0);
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('l');
			if($leadID>0){
				$this->load->model('acquisition_model');
				$data = $this->acquisition_model->getDataByOptions($leadID,'a.cost_price');
			}
		}
		echo json_encode($data);die;
	}
	
	public function findSalesBoxes(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$data = array('detail'=>array(),'portfolio'=>'');		
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['detail'] = $this->lead_model->getSalesActivityLead($this->input->post('boxes'));
			/*$serialNumber = $this->lead_model->getLeadSerialNumber($this->input->post('boxes'));
			$acquisitionData = $this->lead_model->getAcquisitionData($this->input->post('boxes'));
			$data['acquisition'] = $acquisitionData;	
			$this->load->model('customer_model');
			$category_list = $this->customer_model->categoryList(0);
			if(count($acquisitionData)>0 && !empty($acquisitionData->store_name)){
				$urlName ="";
				if($acquisitionData->category>0){
					if(count($category_list)>0){
						for($cc=0;$cc<count($category_list);$cc++){
							if($category_list[$cc]->id==$acquisitionData->category){
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
						$urlName ='/departments/'.$urlName.'-'.$acquisitionData->category.'/'.$serialNumber.'/';						
					}
				}
				$data['portfolio'] = $urlName;		
			}*/
		}
		echo json_encode($data);
		die;
	}
	
	public function findLeadTable(){
		$data = array('detail'=>array());
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['detail'] = $this->lead_model->findLeadTableData($this->input->post('boxes'));
		}
		echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);		
		die;
	}	
	

	public  function safe_b64encode($string) {
		$data = base64_encode($string);
		$data = str_replace(array('+','/','='),array('-','_',''),$data);
		return $data;
	}

	public function safe_b64decode($string) {
		$data = str_replace(array('-','_'),array('+','/'),$string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}

	public  function encode($value){ 
		if(!$value){return false;}
		$text = $value;
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
		return trim($this->safe_b64encode($crypttext)); 
	}

	public function decode($value){
		if(!$value){return false;}
		$crypttext = $this->safe_b64decode($value); 
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
		return trim($decrypttext);
	}
	
	public function plang(){
		$this->load->model('lead_model');
		$this->lead_model->findOneLitigationWithIncomplete1(464,'');
		die;
	}
	
	public function findBoxList(){
		$data = array('detail'=>array(),'boxes'=>array());
		if(isset($_POST) && count($_POST)>0){
		  $type = "Market";
           /* if($this->input->post('t')!=false && $this->input->post('t')!=""){
                $type =$this->input->post('t'); 
            }*/
			$this->load->model('lead_model');
			$data['detail'] = $this->lead_model->findOneLitigationWithIncomplete($this->input->post('boxes'),$type);
			$this->load->model('customer_model');
			$category_list = $this->customer_model->categoryList(0);
			$serialNumber = $data['detail'][0]['litigation']->serial_number;
			if(count($data['detail'][0]['acquisitions'])>0 && !empty($data['detail'][0]['acquisitions']->store_name)){
				$urlName ="";
				if($data['detail'][0]['acquisitions']->category>0){
					if(count($category_list)>0){
						for($cc=0;$cc<count($category_list);$cc++){
							if($category_list[$cc]->id==$data['detail'][0]['acquisitions']->category){
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
						$urlName ='/departments/'.$urlName.'-'.$data['detail'][0]['acquisitions']->category.'/'.$serialNumber.'/';
						$urlName = $this->encode($urlName);
					}
				}
				$data['detail'][0]['portfolio'] = $urlName;		
			}
			
			
			if(isset($data['detail'][0]['litigation']) && (int)$data['detail'][0]['litigation']->serial_number!=0){				
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://synpat.com/file_get.php',
					CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						's' => $data['detail'][0]['litigation']->serial_number
					)
				));
				
				$resp = curl_exec($curl);
				if($resp){
					$data['detail'][0]['patentees'] = json_decode($resp);
				}
			} else {
				$data['detail'][0]['patentees'] = array();
			}			
		}		
		echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);		
		die;
	}
	
	public function findAcquisitionAndSalesData(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$data = array('acquisition'=>array(),'sales_activity'=>array(),'presales_activity'=>array());
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['sales_activity'] = $this->lead_model->getSalesActivity($this->input->post('boxes'));
			$data['presales_activity'] = $this->lead_model->getPreSalesActivity($this->input->post('boxes'));
			$data['broker_as_companies'] = $this->lead_model->findLeadCompanyBrokerDetails($this->input->post('boxes'));
			$data['acquisition'] = $this->lead_model->getAcquisitionActivity($this->input->post('boxes'));
		}
		echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);		
		die;
	}
	
	public function findEmailsInLeadBulk(){
		$data = array();
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->findEmailsInLeadBulk($this->input->post('message_ids'));
		}
		echo json_encode($data);
		die;
	}
	
	public function change_order(){
		if(isset($_POST) && count($_POST)>0){
			$data = $this->input->post('spliting');
			if(!empty($data) && count($data)>0){
				$this->load->model('lead_model');
				foreach($data as $val){
					if(!empty($val)){
						$newString = explode("_",$val);
						if(count($newString)==2){
							$this->lead_model->updateButton(array("sort"=>$newString[1]),$newString[0]);
						}
					}
				}				
			}
		}
		die;
	}
	
	public function findEmailBoxes(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$data = array('boxes'=>array());
		
			$openEmailBox = true;
			if((int)$this->session->userdata['type']!=9){
				if(!in_array(14,$this->session->userdata['modules_assign'])){
					$openEmailBox = false;
				}
			}
			if($openEmailBox===true):
		
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['acquisition']= $this->lead_model->getAcquisitionActivity($this->input->post('boxes'));
		}
		endif;
		echo json_encode($data);		
		die;
	}
	
	
	public function findLeadButtonData(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->findLeadButtonData($this->input->post('l'),$this->input->post('b'));
		}
		echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
		die;
	}
	
	function all_active_system($activityType,$emailID){
		$this->load->model('lead_model');
		$data['lead'] = $this->lead_model->allLeadsWithActivity($activityType);
		$data['activity'] = $activityType;
		$data['email'] = $emailID;
		$this->layout->layout='opportunity';
		$this->layout->auto_render=false;	
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('leads/all_active_system',$data);
	}
	
	function normalise_all_selected_data(){
		$data = array('status'=>0);
		if(isset($_POST) && count($_POST)>0){
			try{
				$updateData = json_decode($this->input->post('send_data'),true);
				if(count($updateData)>0){
					$this->load->model('lead_model');
					$selectedContact = $this->input->post('selected_company');
					$selectedType = $this->input->post('selected_type');
					$companyData = array();
					$companyName = "";
					$companyID = 0;
					if($selectedType=="contact"){
						$getContactData = $this->lead_model->getContactById($selectedContact);
						if(count($getContactData)>0){
							$companyData = $this->lead_model->findCompanyData($getContactData->company_id);
							if(count($companyData)>0){
								$companyName = $companyData->company_name;
								$companyID  = $companyData->id;
							}
						}
						
					} else if($selectedType=="pre-contact"){
						$companyData = $this->lead_model->getPreContactById($selectedContact);
						if(count($companyData)>0){
							$companyName = $companyData->company_name;
							$companyID  = $companyData->id;
						}
					}
					if($companyName!="" && $companyID>0){
						$i=0;
						foreach($updateData as $contact){
							switch($contact['type']){
								case 'pre-contact':
									$data['status'] = $this->lead_model->updatePreContacts(array('company_name'=>trim($companyName)),$contact['id']);
								break;
								case 'contact':
									if($i==0){
										$data['status'] = $this->lead_model->updateCompany(array('company_name'=>trim($companyName)),$companyID);
										$i++;
									}
								break;
							}
						}
					}
					
				}
				
			}catch(Exception $e){
				
			}
		}
		echo json_encode($data);
		die;
	}
	
	function data_from_temp_to_delete(){
		$data = array('status'=>0);
		if(isset($_POST) && count($_POST)>0){
			try{
				$contacts = json_decode($this->input->post('c'),true);
				$precontacts = json_decode($this->input->post('p'),true);
				$this->load->model('lead_model');
				if(count($contacts)>0){
					foreach($contacts as $contact){
						if((int)$contact>0){
							$data['status'] = $this->lead_model->deleteContact($contact);
						}
					}
				}
				if(count($precontacts)>0){
					foreach($precontacts as $contact){
						if((int)$contact>0){
							$data['status'] = $this->lead_model->deletePreContact($contact);
						}
					}
				}
			
			}catch(Exception $e){
				
			}
		}
		echo json_encode($data);
		die;
	}
	
	function update_companies_from_duplicates(){
		$data = array('status'=>0);
		if(isset($_POST) && count($_POST)>0){
			if($this->input->post('update_dt')!=""){
				try{
					$updateData = json_decode($this->input->post('update_dt'),true);
					$this->load->model('lead_model');
					if(count($updateData)>0){
						foreach($updateData as $update){
							if(isset($update['id'])):
							$type = $update['type'];
							unset($update['type']);
							$id = $update['id'];
							unset($update['id']);
							if((int)$id >0){
								if($type=="1"){
									/*Update Contacts*/
									if(isset($update['company_name'])){
										$company = $update['company_name'];
										unset($update['company_name']);
									}
									if(isset($update['cellphone'])){
										$update['phone'] = $update['cellphone'];
										unset($update['cellphone']);
									}
									if(isset($update['profile_url'])){
										$update['linkedin_url'] = $update['profile_url'];
										unset($update['profile_url']);
									}
									if(isset($update['img_card']) && $update['img_card']!=""){
										if(is_array($update['img_card'])){
											/*echo "Ads2";*/
											$update['img_card'] = json_encode($update['img_card']);
										} else {
											/*echo "Ads1";*/
											$update['img_card'] = json_encode(array($update['img_card']));
										}
									}
									if(isset($update['img_card']) && is_array($update['img_card'])){
										/*echo "Ads3";*/
										$update['img_card'] = json_encode($update['img_card']);
									}
									if(count($update)>0){
										$data['status'] = $this->lead_model->updateContact($update,$id);
									}									
									if(isset($company)){
										$getContact = $this->lead_model->getContactById($id);
										$data['status'] = $this->lead_model->updateCompany(array('company_name'=>$company),$getContact->company_id);
									}
									
								}else if($type=="0"){
									/*Update Pre Contacts*/
									$data['status'] = $this->lead_model->updatePreContacts($update,$id);
								}
								
							}
							endif;
						}
					}
				}catch(Exception $e){
					
				}
			}
		}
		echo json_encode($data);
		die;
	}
		
	function merger_contact_activites(){
		$data = array('status'=>0);
		if(isset($_POST) && count($_POST)>0){
			$fromMerger = $this->input->post('from_merge');
			$toMerge = $this->input->post('to_merge');
			$this->load->model('lead_model');
			$data['status'] = $this->lead_model->updateAcquisitionActivityByContactID($fromMerger,array('contact_id'=>$toMerge));
			$data['status'] = $this->lead_model->updateSalesActivityByContactID($fromMerger,array('contact_id'=>$toMerge));
			$data['status'] = $this->lead_model->updateActivityLogByContactID($fromMerger,array('contact_id'=>$toMerge));
		}
		echo json_encode($data);
		die;
	}
	
	function test_pre_contacts(){
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 30000);
		$this->load->model('lead_model');
		$data['pre_contacts'] = $this->lead_model->getPreContacts();
		$this->layout->layout='outsource';
		$this->layout->auto_render=false;	
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('leads/test_pre_companies',$data);
	}
	
	function delete_scan_card(){
		if(isset($_POST)){
			$id = $this->input->post('card');
			$this->load->model('lead_model');
			$affectedRows = $this->lead_model->deleteScanCard($id);
			echo $affectedRows;
		}
		die;
	}
	
	function business_cards_list(){
		$this->load->model('lead_model');
		$data['business_cards'] = $this->lead_model->getActiveScannedBusinessCardsList(0);
		$this->layout->layout='outsource';
		$this->layout->auto_render=false;	
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('leads/business_cards',$data);
	}
		
	function pre_contacts($sp=0){
		$this->load->model('lead_model');
		/*$this->load->model('client_model');*/
		$data = array();
		$data['showD'] = (int)$sp;
		if((int)$sp==1 || (int)$sp==11){
			$data['pre_contacts'] = $this->lead_model->getPreContacts();
			$data['contacts'] = array();
			$data['free_pre_contacts'] = array();
			/*$data['contacts'] = $this->client_model->getAllContacts();
			$data['free_pre_contacts'] = $this->lead_model->getFreePreContacts();*/
		} else if((int) $sp==2 || (int) $sp==12){
			/*Combine both Contacts and Pre Contacts together and merge in temp  table for order by  lastName and FirstName*/
			$data['all_contacts'] = $this->lead_model->getMergePreContactsAndContact();
			/*End*/
		}	
		$data['companies'] = $this->lead_model->getAllCompaniesList('id,company_name');
		$this->layout->layout='outsource';
		$this->layout->auto_render=false;	
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('leads/pre_contacts',$data);
	}
	
	function find_hole_contacts(){
		$numbers = $this->input->get('send');
		$this->load->model('client_model');
		if($numbers!=""){
			$selectedContacts = json_decode($numbers);
			$data['contacts'] = $this->client_model->getHoleContacts($selectedContacts);			
		} else {
			$data['contacts'] = $this->client_model->getHoleContacts();
		}
		
		$this->layout->layout='outsource';
		$this->layout->auto_render=false;	
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('leads/hole_contacts',$data);
	}
	
	
	function pre_companies($leadID=0){
		$this->load->model('lead_model');
		$this->load->model('opportunity_model');
		$data = $this->lead_model->getAllPreCompaniesWithOther();
		if($leadID>0){
			$data['listing_companies'] = $this->opportunity_model->getCompanyListing("company_id,type",$leadID);
		} else {
			$data['listing_companies'] = array();
		}
		$this->layout->layout='outsource';	
		$this->layout->auto_render=false;	
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('leads/pre_companies',$data);
	}
	
	function companies_assign_lead(){
		$data = array();
		$this->load->model('client_model');
		$data['companies'] = $this->client_model->getAllCompaniesWithMem();
		$this->layout->layout='outsource';
		$this->layout->auto_render=false;	
		$this->layout->title_for_layout = 'Backyard Companies Leads';
		$this->layout->render('leads/companies_assign_lead',$data);
	}
	
	function litigation_scrap(){
		$this->load->model('lead_model');
		$data['litigation_scrap'] = $this->lead_model->getLitigationScrap();
		$this->layout->layout='opportunity';
		$this->layout->auto_render=false;	
		$this->layout->title_for_layout = 'Backyard Litigaion Scrap';
		$this->layout->render('leads/litigation_scrap',$data);
	}
	
	function deleteLitigationScrap(){
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			echo $this->lead_model->deleteLitigationScrap($this->input->post('id'));
		}
		die;
	}
	
	function remove_precontacts(){
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			echo $this->lead_model->deletePreContact($this->input->post('id'));
		}
		die;
	}
	
	function delete_all_precontacts(){
		$this->load->model('lead_model');
		echo $this->lead_model->delete_all_precontacts();
		die;
	}
	
	function remove_precompanies(){
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			echo $this->lead_model->deletePreCompany($this->input->post('id'));
		}
		die;
	}
	
	public function findDriveFiles(){
		$data = array('drive'=>array());		
		$openDriveBox = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(14,$this->session->userdata['modules_assign'])){
				$openDriveBox = false;
			}
		}
		if($openDriveBox===true):		
			if(isset($_POST) && count($_POST)>0){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$this->load->model('lead_model');
				$findLeadData = $this->lead_model->getLeadData($this->input->post('boxes'));
				if(count($findLeadData)>0 && !empty($findLeadData->folder_id)){
					$data['drive'] = $service->getFileIDFromChildern($findLeadData->folder_id);
				}			
			}
		endif;
		echo json_encode($data);		
		die;
	}
	
	function findDriveFilesSubFolder(){
		$data = array('drive'=>array());		
		$openDriveBox = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(14,$this->session->userdata['modules_assign'])){
				$openDriveBox = false;
			}
		}
		if($openDriveBox===true):
			if(isset($_POST) && count($_POST)>0){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				if(!empty($this->input->post('f'))){
					$data['drive'] = $service->getFileIDFromChildern($this->input->post('f'));
				}		
			}
		endif;
		echo json_encode($data);		
		die;
	}
	
	public function find_seller_material(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('l');
			if((int)$leadID>0){
				$this->load->model('lead_model');
				$findLeadData = $this->lead_model->getLeadDataWithOptions($leadID,'l.seller_material_folder_id');
				if(count($findLeadData)>0 && !empty($findLeadData->seller_material_folder_id)){
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$data = $service->getFileIDFromChildern($findLeadData->seller_material_folder_id);
				}
			}
		}
		echo json_encode($data);		
		die;
	}
	
	function scanning_document_files(){
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();		
		$data['drive'] = $service->getFileIDFromChildern("0B61I0m5ybHrFbDdvZTdTU1lVTEk");
		$this->layout->layout='opportunity';
		$this->layout->auto_render=false;	
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('leads/scanning_document_files',$data);
	}
	
	function is_JSON() {
		call_user_func_array('json_decode',func_get_args());
		return (json_last_error()===JSON_ERROR_NONE);
	}
	
	function file_import_update_contacts_precontacts(){
		$fileID = "1Dd3FFroSCMOnMZ2kdVaMMpw4BLKD_gggffC1UuCk-4g";
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();		
		$fileGet =  $service->getFileInfo($fileID);
		if(is_object($fileGet) && isset($fileGet->title)){
			$spreadSheetService = new SpreadsheetServiceHelper();
			$spreadsheet = $spreadSheetService->getSpreadsheetById($fileGet->id);
			$allWorkSheet = $spreadSheetService->getAllWorkSheets();
			$workSheetName = "";			
			if(empty($workSheetName)){
				$workSheetName = "Sheet1";
			}						
			$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
			$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());
			if(count($asset_data)>0){
				$this->load->model('lead_model');
				$this->load->model('opportunity_model');
				for($i=0;$i<count($asset_data);$i++){
					$type = "";
					if(isset($asset_data[$i]['type'])){
						$type = $asset_data[$i]['type'];
					}
					if(isset($asset_data[$i]['linkedinname'])){
						$linkedName = $asset_data[$i]['linkedinname'];
					}
					$linkedName = trim(preg_replace('/\s\s+/', ' ', $linkedName));
					$linkedName = preg_replace("~[\r\n]~", "",$linkedName);
					$linkedName = str_replace(array("\r\n","\r"),"",$linkedName);
					$linkedName = preg_replace("/\r\n|\r|\n/", ' ', $linkedName);
					if(isset($asset_data[$i]['linkedinurl'])){
						$linkedUrl = $asset_data[$i]['linkedinurl'];
					}
					$ID = 0;
					if(isset($asset_data[$i]['id'])){
						$ID = $asset_data[$i]['id'];
					}
					$noOfUsers = 0;
					$delete = "";
					/*$noOfUsers = 0;
					if(isset($asset_data[$i]['no_of_users'])){
						$noOfUsers = $asset_data[$i]['no_of_users'];
					}
					$delete = "";
					if(isset($asset_data[$i]['delete'])){
						$delete = $asset_data[$i]['delete'];
					}*/
					echo "ID:".$ID."Type:".$type."<br/>";
					switch($type){
						case 'pre-company':
							if($delete=="Yes" && $ID>0){
								echo "PreCompany ID: ".$ID."<br/>";
								$this->lead_model->deletePreCompany($ID);
							} else {
								if(!empty($linkedUrl) && strpos(strtolower($linkedUrl),"linkedin")!==false && $ID>0){
									$data = $this->lead_model->updatePreCompanies(array('linkedin_name'=>$linkedName,'linkedin_url'=>$linkedUrl),$ID);
								}
							}
						break;
						case 'company':
							if((int)$noOfUsers==0 && $delete=="Yes" && $ID>0){
								echo "Company ID: ".$ID."<br/>";
								  $this->lead_model->deleteCompany($ID);
							} else {
								if(!empty($linkedUrl) && strpos(strtolower($linkedUrl),"linkedin")!==false && $ID>0){
									$data = $this->lead_model->updateCompany(array('linkedin_name'=>$linkedName,'linkedin_url'=>$linkedUrl),$ID);
								}
							}
						break;
						default:
							if(!empty($linkedUrl) && strpos(strtolower($linkedUrl),"linkedin")!==false){
								$checkPreCompanyInList = $this->opportunity_model->checkPreCompanyWithLinkedinUrl($linkedUrl);
								if(count($checkPreCompanyInList)==0){
									$checkCompany = $this->opportunity_model->checkCompanyWithLinkedinUrl($linkedUrl);
									if(count($checkCompany)==0){
										$data = $this->lead_model->insertPreCompanies(array('company_name'=>$asset_data[$i]['companyname'],'linkedin_name'=>$linkedName,'linkedin_url'=>$linkedUrl));
									}
								}
							}
						break;
					}
				}	
			}
		}
		die;
	}
	
	function file_import_in_companies(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();
			if(isset($post['file_url']) && !empty($post['file_url'])){
				$url = explode('/',$post['file_url']);
				$fileID = '';
				if(count($url)>1){
					$fileID = $url[count($url)-2]; 
				}
				if(!empty($fileID) && (int) $post['lead_id']==0){
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();		
					$fileGet =  $service->getFileInfo($fileID);
					if(is_object($fileGet) && isset($fileGet->title)){
						$spreadSheetService = new SpreadsheetServiceHelper();
						$spreadsheet = $spreadSheetService->getSpreadsheetById($fileGet->id);
						$allWorkSheet = $spreadSheetService->getAllWorkSheets();
						$workSheetName = "";			
						if(empty($workSheetName)){
							$workSheetName = "Sheet1";
						}						
						$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
						$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());
						if(count($asset_data)>0){
							$this->load->model('lead_model');
							$this->load->model('opportunity_model');
							for($i=0;$i<count($asset_data);$i++){								
								$address = '';								
								$linkedName = '';								
								$linkedUrl = '';								
								if(isset($asset_data[$i]['webaddress'])){
									$address = $asset_data[$i]['webaddress'];
								}	
								if(isset($asset_data[$i]['linkedinname'])){
									$linkedName = $asset_data[$i]['linkedinname'];
								}
								
								$linkedName = trim(preg_replace('/\s\s+/', ' ', $linkedName));
								$linkedName = preg_replace("~[\r\n]~", "",$linkedName);
								$linkedName = str_replace(array("\r\n","\r"),"",$linkedName);
								$linkedName = preg_replace("/\r\n|\r|\n/", ' ', $linkedName);
								if(isset($asset_data[$i]['linkedinurl'])){
									$linkedUrl = $asset_data[$i]['linkedinurl'];
								}
								if(!empty($linkedUrl) && strpos(strtolower($linkedUrl),"linkedin")!==false){
									$checkPreCompanyInList = $this->opportunity_model->checkPreCompanyWithLinkedinUrl($linkedUrl);
									if(count($checkPreCompanyInList)==0){
										$checkCompany = $this->opportunity_model->checkCompanyWithLinkedinUrl($linkedUrl);
										if(count($checkCompany)==0){
											$data = $this->lead_model->insertPreCompanies(array('company_name'=>$asset_data[$i]['companyname'],'web_address'=>$address,'linkedin_name'=>$linkedName,'linkedin_url'=>$linkedUrl));
										}
									}
									/*$companyName = $asset_data[$i]['companyname'];
									$findCompanyData = $this->lead_model->getCompanyName($companyName,'c.id,c.company_name,c.linkedin_url');
									if(count($findCompanyData)>0){
										$data = $this->lead_model->updateCompany(array('linkedin_name'=>$linkedName,'linkedin_url'=>$linkedUrl),$findCompanyData->id);
									}*/
								}
								
								/*if($data>0){
									$checkListingCompany = $this->opportunity_model->checkCOmpanyINListing($data,'pre-company',0);
									if(count($checkListingCompany)==0){
										$this->opportunity_model->addListingCompany(array('company_id'=>$data,'type'=>'pre-company','lead_id'=>0));
									}									
								}*/
							}
						}
					}
				} else {
					/*From from Due INventions table*/
					$this->load->model('lead_model');
					$getLeadData = $this->lead_model->getLeadData($post['lead_id']);
					if(count($getLeadData)>0){
						$this->load->model('opportunity_model');
						$getListData = $this->opportunity_model->getDocketInventionData($getLeadData->serial_number,'i.infringe_text');
						if(count($getListData)>0){
							for($i=0;$i<count($getListData);$i++){
								$InfringeText = $getListData[$i]->infringe_text;
								if(!empty($InfringeText)){
									if($this->is_JSON($InfringeText)){
										$listCompany = json_decode($InfringeText,true);
										if(count($listCompany)>0){
											for($l=0;$l<count($listCompany)-1;$l++){
												$companyName = $listCompany[$l][0];
												$companyLink = trim($listCompany[$l][1]);
												if(!empty($companyLink) && $companyLink!=null && stripos($companyLink, "linkedin")!==false){
													$findCompanyData = $this->lead_model->getCompanyName($companyName,'c.id,c.company_name,c.linkedin_url');
													if(count($findCompanyData)==0){
														$checkCompany = $this->lead_model->getPreCompanyName($companyName,'c.id,c.company_name,c.linkedin_url');
														if(count($checkCompany)==0){
															$data = $this->lead_model->insertPreCompanies(array('company_name'=>$companyName,'linkedin_url'=>$companyLink));
															if($data>0){
																$checkListingCompany = $this->opportunity_model->checkCOmpanyINListing($data,'pre-company',$post['lead_id']);
																if(count($checkListingCompany)==0){
																	$this->opportunity_model->addListingCompany(array('company_id'=>$data,'type'=>'pre-company','lead_id'=>$post['lead_id']));
																}																
															}
														} else {
															if(stripos($companyLink, "linkedin")!==false){
																$data = $this->lead_model->updatePreCompanies(array('linkedin_url'=>$companyLink),$checkCompany->id);
															} 
															$data = $checkCompany->id;
															$checkListingCompany = $this->opportunity_model->checkCOmpanyINListing($data,'pre-company',$post['lead_id']);
															if(count($checkListingCompany)==0){
																$this->opportunity_model->addListingCompany(array('company_id'=>$checkCompany->id,'type'=>'pre-company','lead_id'=>$post['lead_id']));
															}
														}
													} else {
														if(stripos($companyLink, "linkedin")!==false){
															$data = $this->lead_model->updateCompany(array('linkedin_url'=>$companyLink),$findCompanyData->id);
														}
														$data = $findCompanyData->id;
														$checkListingCompany = $this->opportunity_model->checkCOmpanyINListing($data,'company',$post['lead_id']);
														if(count($checkListingCompany)==0){
															$this->opportunity_model->addListingCompany(array('company_id'=>$findCompanyData->id,'type'=>'company','lead_id'=>$post['lead_id']));
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
			}
		}
		echo $data;
		die;
	}
	
	function deleteContact(){
		$data = array('status'=>1,'message'=>"Please wait.....");
		if(isset($_POST) && count($_POST)>0){
			$contactID = $this->input->post('id');
			/*Check  user is associated with any activities*/
			$this->load->model('lead_model');
			$checkUserInAnyActivity = $this->lead_model->findPersonInAnyActivity($contactID);
			if(count($checkUserInAnyActivity)==0){
				/*Delete contact*/
				$status = $this->lead_model->deleteContact($contactID);
				$data = array('status'=>$status,'message'=>"");
			} else {
				$data = array('status'=>0,'message'=>"Contact is already associated with some lead activities");
			}
			/*End Checking User*/
		}
		echo json_encode($data);
		die;
	}
	
	
	function contact_import_from_table_in_precontacts(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$contacts = $this->input->post('contacts');
			if(!empty($contacts)){
				try{
					$asset_data = json_decode($contacts ,true);
					if(count($asset_data)>1){
						$this->load->model('lead_model');
						for($i=0;$i<count($asset_data)-1;$i++){
							$data = $this->lead_model->insertPreContacts(array('first_name'=>$asset_data[$i][0],'last_name'=>$asset_data[$i][1],'job_title'=>$asset_data[$i][2],'company_name'=>$asset_data[$i][3],'email'=>$asset_data[$i][4],'secondary_email'=>$asset_data[$i][5],'telephone'=>$asset_data[$i][6],'cellphone'=>$asset_data[$i][7],'address'=>$asset_data[$i][8],'profile_url'=>$asset_data[$i][9],'img_card'=>json_encode(array($asset_data[$i][10])),'proximity'=>$asset_data[$i][12],'c_c'=>$asset_data[$i][11]));
						}
					}
				}catch(Exception $e){					
				}
			}
		}
		echo $data;
		die;
	}
	
	function file_import_in_contacts(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$post = $this->input->post();
			if(isset($post['file_url']) && !empty($post['file_url'])){
				$url = explode('/',$post['file_url']);
				$fileID = '';
				if(count($url)>1){
					$fileID = $url[count($url)-2]; 
				}
				if(!empty($fileID)){
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();		
					$fileGet =  $service->getFileInfo($fileID);
					if(is_object($fileGet) && isset($fileGet->title)){
						$spreadSheetService = new SpreadsheetServiceHelper();
						$spreadsheet = $spreadSheetService->getSpreadsheetById($fileGet->id);
						$allWorkSheet = $spreadSheetService->getAllWorkSheets();
						$workSheetName = "";			
						if(empty($workSheetName)){
							$workSheetName = "Sheet1";
						}
						
						$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
						$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());	
						
						if(count($asset_data)>0){
							$this->load->model('lead_model');
							for($i=0;$i<count($asset_data);$i++){
								$profile_url='';
								if(isset($asset_data[$i]['linkedin'])){
									$profile_url= $asset_data[$i]['linkedin'];
								}
								$address = '';
								$address1 = '';
								$city = '';
								$state = '';
								if(isset($asset_data[$i]['address'])){
									$address = $asset_data[$i]['address'];
								}
								if(isset($asset_data[$i]['address1'])){
									$address1 = $asset_data[$i]['address1'];
								}
								if(isset($asset_data[$i]['city'])){
									$city = $asset_data[$i]['city'];
								}
								if(isset($asset_data[$i]['state'])){
									$state = $asset_data[$i]['state'];
								}
								$data = $this->lead_model->insertPreContacts(array('company_name'=>$asset_data[$i]['company'],'job_title'=>$asset_data[$i]['title'],'first_name'=>$asset_data[$i]['firstname'],'last_name'=>$asset_data[$i]['lastname'],'email'=>$asset_data[$i]['email'],'cellphone'=>$asset_data[$i]['phone'],'address'=>$address.', '.$address1.', '.$city.', '.$state,'profile_url'=>$profile_url));
							}
						}
					}
				}
			}
		}
		echo $data;
		die;
		
		/*
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();		
		$fileGet =  $service->getFileNameFromChildern("0B61I0m5ybHrFUHNFMjRiSWFsSWM","High Tech Current Members - 7-02-15");
		if(is_object($fileGet)){
			$spreadSheetService = new SpreadsheetServiceHelper();
			$spreadsheet = $spreadSheetService->getSpreadsheetById($fileGet->id);
			$allWorkSheet = $spreadSheetService->getAllWorkSheets();
			$workSheetName = "";			
			if(empty($workSheetName)){
				$workSheetName = "Sheet1";
			}
			
			$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
			$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());	
			
			if(count($asset_data)>0){
				$this->load->model('customer_model');
				for($i=0;$i<count($asset_data);$i++){
					$companyExist = $this->customer_model->getCompanyData($asset_data[$i]['company']);
					$companyID = 390;
					if(count($companyExist)>0){
						$companyID = $companyExist->id;
						echo "COmpanyID: ".$companyID."<br/>";
					} else {
						$companyID = $this->customer_model->insertCompany(array('company_name'=>$asset_data[$i]['company'],'start_date'=>'0000-00-00 00:00:00','end_date'=>'0000-00-00 00:00:00'));
					}
					if($companyID>0){
						$data = $this->client_model->insert(array('company_id'=>$companyID,'job_title'=>$asset_data[$i]['title'],'first_name'=>$asset_data[$i]['firstname'],'last_name'=>$asset_data[$i]['lastname'],'email'=>$asset_data[$i]['email'],'phone'=>$asset_data[$i]['phone'],'address'=>$asset_data[$i]['address'].', '.$asset_data[$i]['address1'].', '.$asset_data[$i]['city'].', '.$asset_data[$i]['state']));
						echo $data."<br/>";
					}
				}
			}
		}	
		die;*/
	}
	
	function removeFromBox(){
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$removeFromBox = $this->lead_model->removeFromBox($this->input->post('g'),$this->input->post('thread'));
			if($removeFromBox>0){
				/*Delete Acquisition Activity*/
				$this->lead_model->removeFromAcquisition($this->input->post('g'),$this->input->post('thread'));
				/*Delete Sales*/
				$this->lead_model->removeFromSales($this->input->post('g'),$this->input->post('thread'));
				/*End*/
				$user_history = array('lead_id'=>$this->input->post('g'),'user_id'=>$this->session->userdata['id'],'message'=>"Remove message from box.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
				$this->user_model->addUserHistory($user_history);
				echo json_encode(array('send'=>'1'));
			} else {
				echo json_encode(array('send'=>'0'));
			}
		} else {
			echo json_encode(array('send'=>'0'));
		}		
		die;
	}
	
	function delete_drive(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$fileMoved = $service->moveFile($this->input->post('d'),"0B-7JHq4pougDLUkyZ19lMWdHVW8");
			if(is_object($fileMoved)){
				$data = 1;
			} 
		}
		echo $data;
		die;
	}
	
	function linkWithMessage(){
		if(isset($_POST) && count($_POST)>0){
			$box = $_POST;
			if(!isset($_SESSION)){
				session_start();
			}
			$this->load->library('DriveServiceHelper');
			$service = new GmailServiceHelper();
			$service->setAccessToken($_SESSION['access_token']);
			$getMessageData = $service->findThreadData($box['thread']);
			$filesAttachment = "";
			/**/
			if(count($getMessageData)>0){
				foreach($getMessageData as $message){
					foreach($message['attachments'] as $attachments){
						$attachmentID = $attachments['attachmentId'];
						$filename =  $attachments['filename'];
						$attachmentsData = $service->downloadAttachments($box['thread'],$attachmentID);
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
			if(!empty($filesAttachment)){
				$filesAttachment = substr($filesAttachment,0,-1);
			}
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$sendData = $this->lead_model->insertBox(array("lead_id"=>$box['old_thread'],'user_id'=>$this->session->userdata['id'],"thread_id"=>$box['thread'],"content"=>json_encode($getMessageData),"file_attach"=>$filesAttachment));
			if($sendData>0){
				$user_history = array('lead_id'=>$box['old_thread'],'user_id'=>$this->session->userdata['id'],'message'=>"Add email into box.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
				$this->user_model->addUserHistory($user_history);
				echo json_encode(array('send'=>1));
			} else {
				echo json_encode(array('send'=>0));
			}
		} else {
			echo json_encode(array('send'=>0));
		}
		die;
	}
	
	
	function sendRequestURL(){
		$data =array();
		if(isset($_POST) && count($_POST)>0){
			if($this->input->post('t')=='c3luUGF0TWFya2V0'){
				if(!isset($_SESSION)){
					session_start();
				}
				$_SESSION['clickedddd_url']="market_review";
				unset($_SESSION['clicked_url']);
				$data =array(base64_encode(rand()));
			}
		}
		echo json_encode($data);
		die;
	}
    
    function sendRequestURLMarketExecute(){
		$data =array();
		if(isset($_POST) && count($_POST)>0){
			if($this->input->post('t')=='c3luUGF0TWFya2V0'){
				if(!isset($_SESSION)){
					session_start();
				}
				$_SESSION['clickedddd_url']="market_execute";
				unset($_SESSION['clicked_url']);
				$data =array(base64_encode(rand()));
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function createNDATermsheet(){
		$data = array("error"=>"1","message"=>"Please try  after sometime");
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('v');
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$this->load->model('opportunity_model');
			$getLeadData = $this->lead_model->getLeadData($leadID);
          	if(count($getLeadData)>0){
				$ndaID = "";
				$term_sheet = "";				
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				if(empty($ndaID)){					
					/*Create NDA*/
					$parentFolderID = $service->getFileInfo(MASTER_FOLDERID);	
					if(is_object($parentFolderID)){
						$getNDAFileNameWithAccordingLeadType = $this->opportunity_model->doc_list('NDA',$getLeadData->type);
						if(count($getNDAFileNameWithAccordingLeadType)>0){
							/*Create Object*/
							$saveDocFIle = $getNDAFileNameWithAccordingLeadType->doc_id;
							$fileID = (object) array("id"=>$saveDocFIle);
						} else {
							/*$fileID = $service->getFileNameFromChildern($parentFolderID,'NDA with Patent Owners - SynPat - Master');*/
							$fileID = $service->getFileInfo('1-Pw8-L5yzkFyi8OKbWteAf6FnfUabDg1g-DtONZwL5o');
						} 
						if(!empty($fileID) && !empty($getLeadData->folder_id)){
							$folderID = $getLeadData->folder_id; 
							$fileParent = new Google_Service_Drive_ParentReference();
							$fileParent->setId( $folderID );
							
							$getFileInfo = $service->copyFile($fileID->id,"NDA with Seller - ".$getLeadData->lead_name,$fileParent);
							if($getFileInfo){
								$data['error'] = 0;
								$data['nda'] = $getFileInfo->alternateLink;
								$saveLead = $this->lead_model->from_litigation_update($leadID,array("nda_id"=>$getFileInfo->alternateLink));
								$updateDate = date('Y-m-d H:i:s');
								$originalButtonData = $this->lead_model->findButtonByButtonID($getLeadData->type,"NDA_TERMSHEET");
								if(count($originalButtonData)>0){
									$leadButtonData = $this->lead_model->findLeadButtonByButtonID($getLeadData->id,$originalButtonData->id);
									if(count($leadButtonData)>0){
										$newStatus = "";									
										$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButtonData->status_message.' <br/>';
										$newStatus = $leadButtonData->status_message_fill.$newStatus;	
										$this->lead_model->updateButton(array('status'=>1,'update_date'=>$updateDate,'status_message_fill'=>$newStatus),$leadButtonData->id);
									}
								}		
								$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"NDA created for ".$getLeadData->lead_name,'opportunity_id'=>0,'create_date'=>$updateDate);
								$this->user_model->addUserHistory($user_history);									
								$service->setAdditionalPermissions( $getFileInfo->id, "","reader","anyone");								
							}
						}
					}
				}
				if(empty($term_sheet)){
					$parentFolderID = $service->getFileInfo(MASTER_FOLDERID);	
					if(is_object($parentFolderID)){
						$getNDAFileNameWithAccordingLeadType = $this->opportunity_model->doc_list('TIMESHEET',$getLeadData->type);
						if(count($getNDAFileNameWithAccordingLeadType)>0){
							/*Create Object*/
							$saveDocFIle = $getNDAFileNameWithAccordingLeadType->doc_id;
							$fileID = (object) array("id"=>$saveDocFIle);
						} else {
							$fileID = $service->getFileInfo('1qmuamSzEHHSVR0mF539o0C6INpbaHBLtve7k3HHX9Qk');
						}
						if(!empty($fileID) && !empty($getLeadData->folder_id)){
							$folderID = $getLeadData->folder_id;
							$fileParent = new Google_Service_Drive_ParentReference();
							$fileParent->setId( $folderID );
							$getFileInfo = $service->copyFile($fileID->id,"Acquisition Term Sheet - ".$getLeadData->lead_name,$fileParent);
							if($getFileInfo){
								$data['error'] = 0;
								$data['term_sheet'] = $getFileInfo->alternateLink;
                                $created_date = date('Y-m-d H:i:s');
								$saveLead = $this->lead_model->from_litigation_update($leadID,array("term_sheet"=>$getFileInfo->alternateLink,'nda_term_sheet'=>2,'nda_term_sheet_text'=>$created_date));								
								$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Termsheet created for ".$getLeadData->lead_name,'opportunity_id'=>0,'create_date'=>$created_date);
                                $data['date_created'] = $created_date;
								$this->user_model->addUserHistory($user_history);
								$service->setAdditionalPermissions( $getFileInfo->id, "","reader","anyone");
							}
						}
					}
				}				
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function updateLeadData(){
		$data = array("error"=>1);
		if(isset($_POST) && count($_POST)>0){
			$lead_id = $this->input->post("lead_id");
			$send_proposal_letter = $this->input->post("send_proposal_letter");
			if($send_proposal_letter<2){
				$send_proposal_letter = "2";
			} else if($send_proposal_letter>2){
				$send_proposal_letter = "2";
			}
			$this->load->model('lead_model');
			$update_data = array('send_proposal_letter'=>$send_proposal_letter ,'send_proposal_letter_text'=>date('Y-m-d H:i:s'));
			$savedData = $this->lead_model->from_litigation_update($lead_id,$update_data);
			if($savedData){
				$data = array("error"=>"0","date_created"=>date("m d, y", strtotime($update_data['send_proposal_letter_text'])));
			} 
		}
		echo json_encode($data);
		die;		
	}
	public function letter_proposal(){
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();
		/*Find File From Master Document*/
		$name = $this->input->post('name');
		if(empty($name)){
			$name = "Acquisition Proposal Letter - ".date('YYMM')."_Proposal";
		} else{
			$name = "Acquisition Proposal Letter - ".$name;
		}
		$fileID = false;		
		$leadFolderID = false;
		$this->load->model('lead_model');
		$leadInfo = $this->lead_model->getLeadData($_POST['lead_id']);
		if(count($leadInfo)>0){
			if(!empty($leadInfo->folder_id)){
				$leadFolderID = $leadInfo->folder_id;
			}else {
		        $this->load->library("DriveServiceHelper");
					$service = new DriveServiceHelper();
					$mainFolderID = $service->getFileInfo(LEADS_FOLDERID);
                	if(is_object($mainFolderID)){
						$fileParent = new Google_Service_Drive_ParentReference();
						$fileParent->setId( $mainFolderID->id );
						$getFolderInfo = $service->createSubFolder($leadInfo->lead_name.'_folder',$fileParent);
						if($getFolderInfo){
							/*Save Folder ID  in DB*/
							$this->lead_model->from_litigation_update($_POST['lead_id'],array('folder_id'=>$getFolderInfo));
							
						}
					}
	       	}
		}       
		$findFile = $service->getFileNameFromChildern($leadFolderID,$name);
		if(is_object($findFile)){
			$data['link'] = $findFile->alternateLink;
			if(isset($_POST['ds'])){
				$update_data = array('send_proposal_letter'=>'1',"proposal_id"=>$findFile->id);
				$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
			}
		} else {
			switch($this->input->post('type')){
				case 'Litigation':								
					$parentFolderID = $service->getFileIdByName(BACKUP_FOLDERID);
					if(is_object($parentFolderID)){
						$getFolderID = $service->getFileNameFromChildern($parentFolderID->id,OPERATIONS_FOLDER);
						if($getFolderID){	
							$innerFolderID = $service->getFileNameFromChildern($getFolderID->id,MASTER_FOLDER);
							if($innerFolderID){	
								$fileID = $service->getFileNameFromChildern($innerFolderID->id,'Proposal Letter to Sellers - Proactive');
								if($fileID){
									$fileID = $fileID->id;
								}
							}
						}	
					}				
				break;
				case 'Market':
					$parentFolderID = $service->getFileIdByName(BACKUP_FOLDERID);	
					if(is_object($parentFolderID)){
						$getFolderID = $service->getFileNameFromChildern($parentFolderID->id,OPERATIONS_FOLDER);
						if($getFolderID){	
							$innerFolderID = $service->getFileNameFromChildern($getFolderID->id,MASTER_FOLDER);						
							if($innerFolderID){	
								$fileID = $service->getFileNameFromChildern($innerFolderID->id,'Proposal Letter to Sellers - Proactive');
								if($fileID){	
									$fileID = $fileID->id;		
								}
							}
						}
					}
				
				break;
				case 'General':
				case 'SEP':
					$parentFolderID = $service->getFileIdByName(BACKUP_FOLDERID);	
					if(is_object($parentFolderID)){
						$getFolderID = $service->getFileNameFromChildern($parentFolderID->id,OPERATIONS_FOLDER);
						if($getFolderID){	
							$innerFolderID = $service->getFileNameFromChildern($getFolderID->id,MASTER_FOLDER);
							if($innerFolderID){	
								$fileID = $service->getFileNameFromChildern($innerFolderID->id,'Proposal Letter to Sellers - Proactive');
								if($fileID){	
									$fileID = $fileID->id;		
								}
							}
						}
					}
				break;
			}

			$data = array();	
			if($leadFolderID && $fileID){
				/*Find File*/
				$file = $service->getFileNameFromChildern($leadFolderID,$name);
				/*End Find*/
				if($file){
					$data['link'] = $file->alternateLink;
					$update_data = array('send_proposal_letter'=>'1',"proposal_id"=>$file->id);
					$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
				} else {
					$fileParent = new Google_Service_Drive_ParentReference();
					$fileParent->setId( $leadFolderID );
					$getFileInfo = $service->copyFile($fileID,$name,$fileParent);
					if($getFileInfo){
						$this->load->model('user_model');
						$service->setAdditionalPermissions( $getFileInfo->id, "","reader","anyone");
						$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$this->input->post('lead_id'),'message'=>'Create a letter proposal','create_date'=>date('Y-m-d H:i:s')));
						$data['link'] = $getFileInfo->alternateLink;
						if(isset($_POST['ds'])){
							$update_data = array('send_proposal_letter'=>'1',"proposal_id"=>$getFileInfo->id);
							$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
						}
					} else {
						$data['link'] = '';
					}
				}				
			} else {
				$data['link'] = "";
			}
		}
		echo json_encode($data);		
		die;
	}
	
	public function email_proposal_history(){
		$this->load->model('user_model');
		$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$this->input->post('lead_id'),'message'=>'Create a email proposal','create_date'=>date('Y-m-d H:i:s')));
	}
	
	public function comment(){
		if(isset($_POST) && count($_POST)>0){
			$commentData = $this->input->post();
    
            $patent_data = $commentData['litigation']['patent_data'];
          
			$commentData['other']['user_id']= $this->session->userdata['id'];
			$commentData['other']['created']= date('Y-m-d H:i:s');
			$this->load->model('lead_model');
			$this->load->model('user_model');
			if(isset($commentData['litigation']['complete'])){
				$this->lead_model->from_litigation_update($commentData['other']['parent_id'],array('complete'=>2,'status'=>'0','patent_data' => $patent_data));
			}
            else
            {
                $this->lead_model->from_litigation_update($commentData['other']['parent_id'],array('patent_data' => $patent_data));
            }
			if($commentData['other']['id']==0){
				$saveComment = $this->lead_model->from_litigation_comment($commentData['other']);
				$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$commentData['other']['parent_id'],'message'=>'Add a comment','create_date'=>date('Y-m-d H:i:s')));
			} else {
				$saveComment = $this->lead_model->from_litigation_update_comment($commentData['other']);
				$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$commentData['other']['parent_id'],'message'=>'Update comment','create_date'=>date('Y-m-d H:i:s')));
			}
			if($saveComment>0){
				echo json_encode(array('message'=>'Records added','id'=>$saveComment));
			} else {
				echo json_encode(array('error'=>'Try after sometime.'));
			}
		}
		die;
	}
	
    public function insert_patent_data(){
        if(isset($_POST) && count($_POST)>0)
        {
			$this->load->model('lead_model');
			$patent_data = $this->input->post();
			$this->lead_model->from_litigation_update($patent_data['parent_id'],array('patent_data' => $patent_data['patent_data']));
        }
        die;
    }
    
	function change_status_lead(){
		if(isset($_POST) && count($_POST)>0){
			$leadID =$_POST['token'];
			$dateUpdate = date('Y-m-d H:i:s');
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$this->load->model('opportunity_model');
			$updatedRows = $this->lead_model->updateLeadStatus(array('id'=>$leadID,'status'=>'1','complete'=>'2','synpat_like'=>$dateUpdate));
			$getLeadData = $this->lead_model->getLeadData($leadID);
			$buttonData = $this->lead_model->findButtonByButtonID($getLeadData->type,"APPROVED_LEAD");
			$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$leadID,'message'=>'Approved Lead','create_date'=>date('Y-m-d H:i:s')));
			/*Create Task for admin to create opportunity*/
			$getAdminUsers = $this->user_model->findAdminUsers();
			foreach($getAdminUsers as $user){
				$this->opportunity_model->sendApprovalRequest(array('lead_id'=>$leadID,'user_id'=>$user->id,"doc_url"=>$this->config->base_url()."general/create_an_opportunity","status"=>0,"type"=>"CREATE_OPPORTUNITY"));
			}
			echo json_encode(array('rows'=>$updatedRows,'button_data'=>$buttonData,'date_update'=>date('m d,y',strtotime($dateUpdate))));
		}
		die;
	}
	
	function sellerInterested(){
		if(isset($_POST) && count($_POST)>0){
			$leadID =$_POST['token'];
			$dateUpdate = date('Y-m-d H:i:s');
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$updatedRows = $this->lead_model->from_litigation_update($leadID,array('seller_like'=>$dateUpdate));
			$getLeadData = $this->lead_model->getLeadData($leadID);
			$buttonData = $this->lead_model->findButtonByButtonID($getLeadData->type,"SELLER_IS_INTERSTED");
			$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$leadID,'message'=>'Seller like the Deal','create_date'=>date('Y-m-d H:i:s')));			
			echo json_encode(array('rows'=>$updatedRows,'button_data'=>$buttonData,'date_update'=>date('m d,y',strtotime($dateUpdate))));
		}
		die;
	}
	
	function fundsTransfer(){
		if(isset($_POST) && count($_POST)>0){
			$leadID =$_POST['token'];
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$dateUpdate = date('Y-m-d H:i:s');
			$updatedRows = $this->lead_model->from_litigation_update($leadID,array('funding_trnsfr'=>$dateUpdate));
			$getLeadData = $this->lead_model->getLeadData($leadID);
			$buttonData = $this->lead_model->findButtonByButtonID($getLeadData->type,"FUNDING");
			$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$leadID,'message'=>'Funds Transfer','create_date'=>date('Y-m-d H:i:s')));	
			echo json_encode(array('rows'=>$updatedRows,'button_data'=>$buttonData,'date_update'=>date('m d,y',strtotime($dateUpdate))));
		}
		die;
	}
	//patentimages.storage.googleapis.com/thumbnails/US9110563B2/US09110563-20150818-D00007.png
	//patentimages.storage.googleapis.com/thumbnails/US7352200B2/US07352200-20080401-D00000.png
	/*public function scrapData($getPatentNumber){
		
		if(!empty($getPatentNumber)){
			$getPatentNumber = strtoupper($getPatentNumber);
			if(strpos($getPatentNumber,"US")===false){
				if(strlen($getPatentNumber)==7){
					$getPatentNumber = "US".$getPatentNumber;
				}
			}
			$content = $this->executeCurl($getPatentNumber);		
			$content = str_replace("/patents/css/","http://www.google.co.in/patents/css/",$content);
			$content = str_replace("/books/javascript/","http://www.google.co.in/books/javascript/",$content);
			$content = str_replace("/googlebooks/images/kennedy/page_left.png","http://www.google.co.in/googlebooks/images/kennedy/page_left.png",$content);
			$content = str_replace("/googlebooks/images/kennedy/page_right.png","http://www.google.co.in/googlebooks/images/kennedy/page_right.png",$content);
		}
		echo '<style>
.knowledge-card.patent-result > header.patent-result {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    background: #4285F4;
    color: #fff;
    padding: 20px 12px;
	position:inherit;
	width:inherit;
	height:inherit;
}
.knowledge-card.patent-result > header.patent-result h2.patent-result {
    font-size: 20px;
}
.knowledge-card.patent-result > header.patent-result h2.patent-result, .knowledge-card.patent-result > header.patent-result .tagline.patent-result {
    margin: 0;
    font-weight: normal;
    padding-top: 4px;
}
.knowledge-card.patent-result > header.patent-result h2.patent-result, .knowledge-card.patent-result > header.patent-result .tagline.patent-result {
    margin: 0;
    font-weight: normal;
    padding-top: 4px;
}
.knowledge-card.patent-result .knowledge-card-action-bar.patent-result {
    background: #3367D6;
    padding: 10px 12px;
    margin: 20px -12px -20px;
}
.knowledge-card.patent-result > header.patent-result a.patent-result:link, .knowledge-card.patent-result > header.patent-result a.patent-result:visited {
    color: inherit;
    margin: 0px 12px 0px 0px;
    display: inline-block;
}
.iron-icon-0 {
    display: -ms-inline-flexbox;
    display: -webkit-inline-flex;
    display: inline-flex;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    position: relative;
    vertical-align: middle;
    fill: currentcolor;
    stroke: none;
    width: 24px;
    height: 24px;
}
.knowledge-card.patent-result > header.patent-result a.patent-result:link, .knowledge-card.patent-result > header.patent-result a.patent-result:visited {
    color: inherit;
    margin: 0px 12px 0px 0px;
    display: inline-block;
}
.gb_ga.gb_ha,#gb div.gb_hf,#gb a.gb_Ha.gb_Ha, .gb_ia,#gbwa,.search-ui-0 .layout.horizontal.search-ui,#leftBar,#gb{display:none !important} .search-ui-0 [wide].search-ui main.search-ui{margin:0px !important}
</style>';
		echo $content;
		die;	
	}*/
	
	public function scrapData($getPatentNumber){
		$content = "";
		if(!empty($getPatentNumber)){
			$getPatentNumber = strtoupper($getPatentNumber);
			if(strpos($getPatentNumber,"US")===false){
				if(strlen($getPatentNumber)==7){
					$getPatentNumber = "US".$getPatentNumber;
				}
			}
			$content = $this->executeCurlOld($getPatentNumber);	
		}
		echo $content;
		echo "<style>.gb_Uf, .gb_Vf,.kd-appbar,.gb_4f,#gba,.gb_1b,#gbq,#gbq1{display:none;}</style>";
		die;
		
	}
	
	public function findWorksheetList(){
		if($_POST && count($_POST)):
			$this->load->library('DriveServiceHelper');
			$service = new SpreadsheetServiceHelper();
			$ss_id = $this->input->post('v');
			$spreadsheet = $service->getSpreadsheetById($ss_id);
			$allWorkSheet = $service->getAllWorkSheets();
			echo json_encode($allWorkSheet);			
		endif;
		die;
	}
	
	public function findWorksheetListFromUrl(){
		if($_POST && count($_POST)):
			$this->load->library('DriveServiceHelper');
			$service = new SpreadsheetServiceHelper();
			$ss_id = $this->input->post('v');
			$ss_id = str_replace("https://docs.google.com/spreadsheets/d/","",$ss_id);
			$ss_id = str_replace("https://docs.google.com/a/synpat.com/spreadsheets/d/","",$ss_id);
			$ss_id = str_replace("/edit?usp=drivesdk","",$ss_id);	
			$ss_id = str_replace("/edit#gid=0","",$ss_id);	
			$spreadsheet = $service->getSpreadsheetById($ss_id);
			$allWorkSheet = $service->getAllWorkSheets();
			echo json_encode($allWorkSheet);			
		endif;
		die;
	}
	
	public function searchAllPatentFiles(){
		$listFiles = array();
		if(isset($_POST) && count($_POST)>0){
			$folderID = "";
			if($this->input->post('f')=="undefined"){
				$leadID = $this->input->post('l');
				if($leadID!="" && (int)$leadID>0){
					$this->load->model('lead_model');		
					$getData = $this->lead_model->getLeadDataWithOptions($leadID,'l.folder_id');
					if(count($getData)>0){
						$folderID = $getData->folder_id;
					}
				}
			} else {
				$folderID = $this->input->post('f');
			}
			if(!empty($folderID )){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$q = "title contains 'Patent List' and mimeType = 'application/vnd.google-apps.spreadsheet'";
				$listFiles = $service->searchFileIDFromChildern($folderID,$q);
			}
		}
		echo json_encode($listFiles);	
		die;
	}
	
	public function findPatentsAll(){
		/*if ( ! session_id() ) { 
			session_start();
		}
		unset($_SESSION['overAllArray']);
		$asset_data = array();*/
		$data = 0;
		$string = $this->input->post('file_url');
		$fileID = $this->input->post('file_id');
		$this->load->library('DriveServiceHelper');
		$service = new SpreadsheetServiceHelper();
		if(empty($string)){
			$driveService = new DriveServiceHelper();
			$getInfo = $driveService->getFileInfo($fileID);
			if($getInfo){
				$string = $getInfo->alternateLink;
			}
		}
		if(!empty($string)){
			$ss_id = explode("/",$string);
			$ss_id =$ss_id[count($ss_id)-2];
			$workSheetString = explode("#",$string);
			$sheetID = 0;
			if(count($workSheetString)>1){
				$workSheetString = $workSheetString[1];
				if(!empty($workSheetString)){
					$sheetExplode = explode("=",$workSheetString);
					if(count($sheetExplode)>1){
						$sheetID = $sheetExplode[1];
					}
				}
			}
			
			$spreadsheet = $service->getSpreadsheetById($ss_id);
			$allWorkSheet = $service->getAllWorkSheets();
			$sheetName = "";
			$sheetInnerID = "";
			foreach($allWorkSheet as $worksheet){
				if(trim($worksheet['link'])==trim($sheetID)){
					$sheetName = $worksheet['text'];
					$sheetInnerID = $worksheet['id'];
					break;
				}
			}
			if(!empty($sheetName)){
				$listFeed = $service->getWorkSheetByName($sheetName);
				$asset_data =$service->getAllRows($listFeed->getEntries());
				if(count($asset_data)>0){
					$leadID = $this->input->post('lead_id');
					/*Delete Old Patent List*/
					$this->load->model('lead_model');
					$this->lead_model->leadOldPatentListWithFamily($leadID);
					/*Insert New List*/
					$this->lead_model->insertLeadPatentBulk($asset_data,$leadID);
					/*Create JOB Queue*/
					$checkJobQueue = $this->lead_model->checkPendingJobByLead($leadID);
					if(count($checkJobQueue)==0){
						$jobQueryInsert = array('module_name'=>'Patent_Family','type'=>'Patent_Family','account'=>$leadID,'user_id'=>$this->session->userdata['id']);
						$data = $this->lead_model->insertJobQueue($jobQueryInsert);
					} else {
						$data = $checkJobQueue->id;
					}					
				}
			}
		}
		/*echo json_encode($asset_data);*/
		echo $data;
		die;
	}
	
	
	public function googleSpreadSheet(){
		$openPatentTable = true;
		if((int)$this->session->userdata['type']!=9){
			if(!in_array(16,$this->session->userdata['modules_assign'])){
				$openPatentTable = false;
			}
		}
		ini_set("memory_limit","256M");
		$allPatentFromSheet = array();
		if($openPatentTable===true):		
		$asset_data=array();
		$patent = $this->input->post('p');
		$originalPatent = $patent;
		$this->load->model('lead_model');
		if(!empty($patent)){
			$patent = strtoupper($patent);
			if(strpos($patent,"US")===false){
				if(strlen($patent)==7){
					$patent = "US".$patent;
				}				
			}			
			$leadID = $this->input->post('boxes');
			$getData = $this->lead_model->getLeadData($leadID );
			$patentData = "";
			if(count($getData)){
				$patentData = json_decode($getData->patent_data);
			}
			$key = array();
			$value = array();
			$overAllArray = array();
			$content = $this->executeCurl($patent);		
			$this->load->library('simple_html_dom');
			$title=null;
			$html = $this->simple_html_dom->load($content,true,true);
			$forwardCitation = 0;
			$backwardCitation = 0;
			$patentString = $patent;
			$patentCorrect = $html->find('header.patent-result',0);
			if(is_object($patentCorrect)){
				$cPatentS = $patentCorrect->find('h2.patent-result',0)->plaintext;
				if(!empty($cPatentS)){
					$patentString = $cPatentS;
				}
			}
			$plain = $html->find('h3#patentCitations',0);
			if(is_object($plain)){
				$string =  $html->find('h3#patentCitations',0)->plaintext;
				$backwardCitation = filter_var($string, FILTER_SANITIZE_NUMBER_INT);
			}			
			$plainT = $html->find('h3#citedBy',0);
			if(is_object($plainT)){
				$stringT =  $html->find('h3#citedBy',0)->plaintext;
				$forwardCitation = filter_var($stringT, FILTER_SANITIZE_NUMBER_INT);
			}
			foreach($html->find('div#wrapper') as $asWrapper) {	
				foreach($asWrapper->find('h1#title') as $title){
					$title = trim($title->innertext);
				}
			}
			foreach($html->find('dl.general-info') as $dlWrapper) {	
				foreach($dlWrapper->find('dt.patent-result') as $dt){
					if($dt->find('span')){
						$text = "";
						foreach($dt->find('span') as $span){
							$text .= $span->innertext." ";
						}																
						$key[] = trim($text);	
					} else {
						$key[] = trim($dt->innertext);
					}						
				}
				foreach($dlWrapper->find('dd.patent-result') as $dd){
					if($dd->find('a')){
						$anchor_text = "";
						foreach($dd->find('a') as $anchor){
							$anchor_text .= (string)$anchor->innertext.", ";
						}																
						$value[] = trim(substr($anchor_text,0,-2)) ;	
					} else {
						$value[] = trim((string)$dd->innertext);
					}								
				}
			}
			foreach($html->find('dl.important-people') as $dlWrapper) {	
				foreach($dlWrapper->find('dt.patent-result') as $dt){
					if($dt->find('span')){
						$text = "";
						foreach($dt->find('span') as $span){
							$text .= $span->innertext." ";
						}																
						$key[] = trim($text);	
					} else {
						$key[] = trim($dt->innertext);
					}						
				}
				$inventor="";
				$currentAssignee="";
				$originalAssignee="";
				foreach($dlWrapper->find('dd.patent-result') as $dd){
					if($dd->find('a')){
						$anchor_text = "";
						foreach($dd->find('a') as $anchor){
							$attribute = $anchor->getAttribute("add-inventor");
							if($attribute!=""){
								$inventor .=$attribute.", ";
							} else{
								$attribute = $anchor->getAttribute("add-assignee");
								if($attribute!=""){
									$originalAssignee .= $attribute.", ";
								}
							}
						}
					} else {
						$currentAssignee = trim($dd->innertext);
					}								
				}
				$value[] = trim($inventor);
				if(in_array('Current Assignee',$key)){
					$value[] = trim($currentAssignee);
				}				
				$value[] = trim($originalAssignee);					
			}
			foreach($html->find('dl.key-dates') as $dlWrapper) {	
				foreach($dlWrapper->find('dt.patent-result') as $dt){
					if($dt->find('span')){
						$text = "";
						foreach($dt->find('span') as $span){
							$text .= $span->innertext." ";
						}																
						$key[] = trim($text);	
					} else {
						$key[] = trim($dt->innertext);
					}						
				}
				foreach($dlWrapper->find('dd.patent-result') as $dd){
					if($dd->find('a')){
						$anchor_text = "";
						foreach($dd->find('a') as $anchor){
							$anchor_text .= strip_tags($anchor->innertext).", ";
						}																
						$value[] = trim(substr($anchor_text,0,-2)) ;	
					} else {
						$value[] = trim(strip_tags($dd->innertext));
					}								
				}
			}
			$forwardArray = array();
			$sp=0;
			foreach($html->find('div.responsive-table') as $table) {
				$PublicationNumber = false;
				$PriorityDate = false;
				$PublicationDate = false;
				$Assignee = false;
				$Title = false;
				$enter = false;
				$c = 0;
				foreach($table->find('div.thead') as $thead){
					foreach($thead->find('div.tr') as $trh){
						foreach($trh->find('span.th') as $th){
							switch($c){
								case 0:
									if(trim($th->plaintext)=="Publication number"){
										$PublicationNumber =true;
									}
								break;
								case 1:
									if(trim($th->plaintext)=="Priority date"){
										$PriorityDate =true;
									}													
								break;
								case 2:
									if(trim($th->plaintext)=="Publication date"){
										$PublicationDate =true;
									}
								break;
								case 3:
									if(trim($th->plaintext)=="Assignee"){
										$Assignee =true;
									}
								break;
								case 4:
									if(trim($th->plaintext)=="Title"){
										$Title =true;
									}
								break;
							}
							$c++;
						}
					}
				}
				if($PublicationNumber == true && $PriorityDate == true && $PublicationDate == true  && $Assignee == true && $Title == true){
					$enter = true;$sp++;
				}
				if($sp>0 && $enter==true):
				foreach($table->find('div.tbody') as $tbody){
					foreach($tbody->find('div.tr') as $tr){
						$ntd = 0;
						$applicant="";
						foreach($tr->find('span.td') as $td){
							if($ntd==3){
								$applicant = trim($td->innertext);
							}
							$ntd++;
						}
						if(!empty($applicant)){
							$forwardArray[] = $applicant;													
							$overAllArray[] = $applicant;
						}
					}
				}
				break;
				endif;				
			}
			
			/*Find Family For this patent*/
			$familyArray = array();
			if(is_object($html) && isset($html->nodes)):
				foreach($html->find('div.responsive-table') as $table) {
					$enter = false;
					$Date = false;
					$Number = false;
					$Type = false;
					$c = 0;
					foreach($table->find('div.thead') as $thead){
						foreach($thead->find('div.tr') as $trh){
							foreach($trh->find('span.th') as $th){
								switch($c){
									case 0:
										if(trim($th->plaintext)=="Publication number"){
											$Number =true;

										}
									break;
									case 1:
										if(trim($th->plaintext)=="Publication date"){
											$Date =true;

										}													
									break;
									case 2:
										if(trim($th->plaintext)=="Type"){
											$Type =true;

										}
									break;
								}
								$c++;
							}
						}
					}
					if($Date == true && $Number == true && $Type == true ){
						$enter = true;
					}				
					if($enter===true){
						foreach($table->find('div.tbody') as $tbody){
							foreach($tbody->find('div.tr') as $tr){
								$publication_number ="";
								$c = 0;
								foreach($tr->find('span.td') as $td){
									switch($c){
										case 0:
											$publication_number = trim($td->plaintext);
										break;
									}
									$c++;
								}
								$familyArray[] = array('child_number'=>$publication_number,'parent_number'=>$patentString);
							}
						}
						break;
					}					
				}
				if(count($familyArray)>0){
					$this->lead_model->insertLeadPatentFamilyBulk($familyArray);
					
				}
				endif;
				/*Family Diagram*/
				$number = $patentString;
				$patentNumbers = "";
				$kc = "";
				if(strlen($number)>9){	
					$patentNumbers = substr($number,0,-2);
					$kc = substr($number,strlen($number)-2);
				} else {
					$patentNumbers = $number;
				}
				if(empty($kc)){
					$kc = "B2";
				}
				$ch = curl_init();
				/*curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, 'uzi@synpat.com:1q2w3e4r');*/
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'userid:uzi@synpat.com','password:1q2w3e4r','Host:api.patseer.com'));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
				curl_setopt($ch, CURLOPT_URL, 'http://api.patseer.com/RecordData/familytree/'.$patentNumbers.'/'.$kc);
				$j = curl_exec($ch);
				$info = curl_getinfo($ch);
				curl_close($ch);
				if(isset($info['http_code']) && (int)$info['http_code']==200){
					$result = json_decode($j,true);
					$this->lead_model->insertFamilyDiagram(array('patent_number'=>$patentString,'html_data'=>$result['Result'],'lead_id'=>$leadID)) ;
				}
			
			/*End Family Diagram*/
			
			/*foreach($html->find('dl.links') as $dlWrapper) {	
				foreach($dlWrapper->find('dt.patent-result') as $dt){
					if($dt->find('span')){
						$text = "";
						foreach($dt->find('span') as $span){
							$text .= $span->innertext." ";
						}																
						$key[] = trim($text);	
					} else {
						$key[] = trim($dt->innertext);
					}						
				}
				foreach($dlWrapper->find('dd.patent-result') as $dd){
					if($dd->find('a')){
						$anchor_text = "";
						foreach($dd->find('a') as $anchor){
							$anchor_text .= strip_tags($anchor->innertext).", ";
						}																
						$value[] = trim(substr($anchor_text,0,-2)) ;	
					} else {
						$value[] = trim(strip_tags($dd->innertext));
					}								
				}
			}*/						
			
			$newPubData = array();
			if(is_array($key) && is_array($value) && count($key) > 0 && count($value) > 0 && count($key) == count($value)){
				$newPubData = array_combine($key, $value);
			}
			$referenced = array_count_values($forwardArray);
			$applicationNumber ="";
			$originalAssignee ="";
			$priority ="";
			$feeStatus ="";
			$family ="";
			$currentAssignee="";
			$question1 = null;
			$question2 = null;
			$question3 = null;
			if(count($newPubData)>0){
				if(isset($newPubData['Application number'])){
					$applicationNumber = (string)$newPubData['Application number'];
				}
				if(isset($newPubData['Original Assignee'])){
					$originalAssignee = (string)$newPubData['Original Assignee'];
				}
				if(isset($newPubData['Current Assignee'])){
					$currentAssignee = (string)$newPubData['Current Assignee'];
				}
				/*if(isset($newPubData['Publication number'])){
					$family = strip_tags($newPubData['Publication number']);
					$family = explode(',',$family);
					$family = implode(',',array_filter($family,'strlen'));
				}*/
				if(isset($newPubData['Priority date'])){
					$priority = (string)$newPubData['Priority date'];
				}
				/*if(isset($newPubData['Fee status'])){
					$feeStatus = strip_tags($newPubData['Fee status']);
				}*/
				
				if(isset($newPubData['Legal status'])){
					$feeStatus = (string)$newPubData['Legal status'];
				}
			}
			if(is_array($patentData) && count($patentData)>0){
				foreach($patentData as $pp){
					if(isset($pp[1])){
						$question1 = $pp[1];
					}
					if(isset($pp[2])){
						$question2 = $pp[2];
					}
					if(isset($pp[3])){
						$question3 = $pp[3];
					}
					/*
					if(isset($pp[4]) && !empty($currentAssignee)){
						$currentAssignee = $pp[4];
					}*/
				}
			}
			if(!isset($_SESSION)){
				session_start();
			}
			if(isset($_SESSION['overAllArray'])){
				$getOldArrayData = $_SESSION['overAllArray'];
			} else{
				$getOldArrayData = array();
			}				
			if(is_array($getOldArrayData)){
				if(count($getOldArrayData)==0){
					$getOldArrayData = $overAllArray;
				} else {
					for($i=0;$i<count($overAllArray);$i++){
						array_push($getOldArrayData,$overAllArray[$i]);
					}
				}
			} else {
				$getOldArrayData = $overAllArray;							
			}				
			$_SESSION['overAllArray'] = $getOldArrayData;
			$expired = "";
			if(!empty($priority)){
				$pTime = strtotime($priority);
				$priority = date('m/d/Y',$pTime);
				$expired  = date('m/d/Y',strtotime('+20 years',$pTime));
			}
			/*$allPatentFromSheet = array($patent,$question1,$question2,$question3,$currentAssignee,$applicationNumber,$title,$originalAssignee,$priority,$feeStatus,$family,$referenced,array_count_values($getOldArrayData));*/
			$allPatentFromSheet = array($patentString,$backwardCitation,$forwardCitation,$question3,$currentAssignee,$applicationNumber,$title,$originalAssignee,$priority,$feeStatus,$family,$referenced,array_count_values($getOldArrayData));
			$insertFamily = $this->lead_model->insertLeadPatentScrapData(array('lead_id'=>$leadID ,'patent_number'=>$patentString,'b_citations'=>$backwardCitation,'f_citations'=>$forwardCitation,'expired'=>$expired,'application'=>$applicationNumber,'title'=>$title,'current_assignee'=>$currentAssignee,'original_assignee'=>$originalAssignee,'priority'=>$priority,'status'=>$feeStatus,'family'=>$family,'referenced'=>json_encode($referenced),'over_all'=>json_encode(array_count_values($getOldArrayData))));
			if($insertFamily>0){
				/*Update Patent status scrap*/
				$this->lead_model->updateLeadPatentByPatentNumber(array('scrap_status'=>1,'patent_number'=>$patentString),$originalPatent);
			}
		}
		endif;
		echo json_encode($allPatentFromSheet);
		die;
	}
	
	public function checkrabbit(){
		$data = array();
		$this->load->model('lead_model');
		$jobQueryInsert = array('module_name'=>'Patent_Family','type'=>'Patent_Family','account'=>398,'user_id'=>1);
		$data['job_queue'] = $this->lead_model->insertJobQueue($jobQueryInsert);
		if($data['job_queue']>0){
			require_once($_SERVER['DOCUMENT_ROOT'] . '/backyard/vendor/autoload.php');
			$rabbitmq = array('host'=>"104.198.240.158","port"=>15672,"user"=>"RabbitUser","pass"=>"fX4?nb");
			define("RABBITMQ_HOST", $rabbitmq['host']);
			define("RABBITMQ_PORT", isset($rabbitmq['port']) ? $rabbitmq['port'] : 5672);
			define("RABBITMQ_USERNAME", $rabbitmq['user']);
			define("RABBITMQ_PASSWORD", $rabbitmq['pass']);
			define("RABBITMQ_VHOST", '/');
			$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
				RABBITMQ_HOST, 
				RABBITMQ_PORT, 
				RABBITMQ_USERNAME, 
				RABBITMQ_PASSWORD
			);
			echo "<pre>";
			print_r($connection);
			die;
			$channel = $connection->channel();
			# Create the queue if it doesn't already exist.
			$channel->queue_declare('task_queue_patent', false, true, false, false);
			$jobArray = array(
				'id' => $data['job_queue'],
				'task' => 'sleep',
				'sleep_period' => rand(0, 3)
			);
			$msg = new \PhpAmqpLib\Message\AMQPMessage(
				json_encode($jobArray, JSON_UNESCAPED_SLASHES),
				array('delivery_mode' => 2) # make message persistent
			);
			echo "<pre>";
			print_r($msg);
			$channel->basic_publish($msg, '', 'task_queue_patent');
			$channel->close();
			$connection->close();
		}
			die;
	}
	
	public function find_lead_patent_with_family(){
		$data = array('job_queue'=>0,'patent_family'=>array(),'lead_id'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['lead_id'] = $this->input->post('l');
			$getFamilyDataFrom = $this->lead_model->getLeadPatentFamilyData($this->input->post('l'));
			if(count($getFamilyDataFrom['child_detail'])>0){
				$data['patent_family'] = $getFamilyDataFrom['child_detail'];
			}			
			/*$checkJObStatus = $this->lead_model->findJobDetailsByLead($this->input->post('l'),'status,id');*/
			if($getFamilyDataFrom['child_count']>0 && $getFamilyDataFrom['child_total']>0 && $getFamilyDataFrom['child_total']==$getFamilyDataFrom['child_count']){
				$data['job_queue'] = 0;
			} else if($getFamilyDataFrom['child_count']>0 && $getFamilyDataFrom['child_total']>0 && $getFamilyDataFrom['child_total']!=$getFamilyDataFrom['child_count']){
				$data['job_queue'] = $this->input->post('l');
			}
			/* else {*/
				/*start queue process*/		
				/*$jobQueryInsert = array('module_name'=>'Patent_Family','type'=>'Patent_Family','account'=>$this->input->post('l'),'user_id'=>$this->session->userdata['id']);
				$data['job_queue'] = $this->lead_model->insertJobQueue($jobQueryInsert);*/
				/*if($data['job_queue']>0){
					require_once($_SERVER['DOCUMENT_ROOT'] . '/backyard/vendor/autoload.php');
					$rabbitmq = array('host'=>"104.198.240.158","port"=>15672,"user"=>"RabbitUser","pass"=>"fX4?nb");
					define("RABBITMQ_HOST", $rabbitmq['host']);
					define("RABBITMQ_PORT", isset($rabbitmq['port']) ? $rabbitmq['port'] : 5672);
					define("RABBITMQ_USERNAME", $rabbitmq['user']);
					define("RABBITMQ_PASSWORD", $rabbitmq['pass']);
					define("RABBITMQ_VHOST", '/');
					$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
						RABBITMQ_HOST, 
						RABBITMQ_PORT, 
						RABBITMQ_USERNAME, 
						RABBITMQ_PASSWORD,
						RABBITMQ_VHOST
					);
					$channel = $connection->channel();
					# Create the queue if it doesn't already exist.
					$channel->queue_declare('task_queue_patent', false, true, false, false);
					$jobArray = array(
						'id' => $data['job_queue'],
						'task' => 'sleep',
						'sleep_period' => rand(0, 3)
					);
					$msg = new \PhpAmqpLib\Message\AMQPMessage(
						json_encode($jobArray, JSON_UNESCAPED_SLASHES),
						array('delivery_mode' => 2) # make message persistent
					);
					$channel->basic_publish($msg, '', 'task_queue_patent');
					$channel->close();
					$connection->close();
				}*/
			/*}*/
		}
		echo json_encode($data);
		die;
	}
	
	public function start_queue_process(){
		exec('php5.6 -f /var/www/synpat/backyard/patent_family_queue.php');
		echo "File run...";
		die;
	}
	
	
	function dueDilligenceLeftRightChart($leadID){
		$this->load->model('lead_model');
		$getLeadData = $this->lead_model->getLeadDataWithOptions($leadID,'l.serial_number');
		if(count($getLeadData)>0){
			$this->load->model('opportunity_model');
			$getLicenseData = $this->opportunity_model->getLicenseDataByLeadID($getLeadData->serial_number,"id");
			if(count($getLicenseData)>0){
				/*Delete Patents*/
				$this->opportunity_model->deleteDueDilligencePatent($getLicenseData->id);
				$this->opportunity_model->addDueDilligencePatentThroughLead($leadID,$getLicenseData->id);
				/**/
				/*Left Chart*/
				$allPatentApplication = $this->opportunity_model->findFamilyPatents($leadID);
				/*echo "<pre>";
				print_r($allPatentApplication);
				echo "COUNT".count($allPatentApplication)."<br/>";
				echo "</pre>";*/
				if(count($allPatentApplication)>0){
					$chartLeftData = array();
					foreach($allPatentApplication as $publishedPatent){
						$first2Letter = substr($publishedPatent->patent_number,0,2);
						if(count($chartLeftData)>0){
							$enter = false;
							$l=0;
							foreach($chartLeftData as $left){
								if($left['country']==$first2Letter){
									/*echo "COUNTRY:".$left['country']."MATTER:".$first2Letter."<br/>";*/
									$patentCount = $left['patents'];
									$applicationCount = $left['applications'];
									/*echo '1'.$publishedPatent->type."@@".$publishedPatent->patent_number."LEN".strlen($publishedPatent->patent_number)."<br/>";*/
									if($publishedPatent->type=="Patent"  || $publishedPatent->type=="Grant"){
										if(strlen($publishedPatent->patent_number)>11){
											$applicationCount = (int) $applicationCount + 1;
										} else {
											$patentCount = (int) $patentCount + 1;
											/*echo "PATENT: ".$patentCount."<br/>";*/
										}
									} else if($publishedPatent->type=="Application"){
										$applicationCount = (int) $applicationCount + 1;
									}
									$chartLeftData[$l]['patents'] = $patentCount;
									$chartLeftData[$l]['applications'] = $applicationCount;
									$enter = true;
									break;
								}
								$l++;
							}
							if($enter===false){
								$patentCount = 0;
								$applicationCount = 0;
								if($publishedPatent->type=="Patent" || $publishedPatent->type=="Grant"){
									/*echo '2'.$publishedPatent->type."@@".$publishedPatent->patent_number."LEN".strlen($publishedPatent->patent_number)."<br/>";*/
									if(strlen($publishedPatent->patent_number)>11){
										$applicationCount = (int) $applicationCount + 1;
									} else {
										$patentCount = (int) $patentCount + 1;
										/*echo "PATENT: ".$patentCount."<br/>";*/
									}
								} else if($publishedPatent->type=="Application"){
									$applicationCount = 1;
								}
								$chartLeftData[] = array('license_id'=>$getLicenseData->id,'country'=>$first2Letter,'patents'=>$patentCount,'applications'=>$applicationCount);
							}
						} else {
							$patentCount = 0;
							$applicationCount = 0;
							/*echo '3'.$publishedPatent->type."@@".$publishedPatent->patent_number."LEN".strlen($publishedPatent->patent_number)."<br/>";*/
							if($publishedPatent->type=="Patent" || $publishedPatent->type=="Grant"){
								if(strlen($publishedPatent->patent_number)>11){
									$applicationCount = (int) $applicationCount + 1;
								} else {
									$patentCount = (int) $patentCount + 1;
									/*echo "PATENT: ".$patentCount."<br/>";*/
								}
							} else if($publishedPatent->type=="Application"){
								$applicationCount = 1;
							}
							$chartLeftData[] = array('license_id'=>$getLicenseData->id,'country'=>$first2Letter,'patents'=>$patentCount,'applications'=>$applicationCount);
						}
					}
					/*echo "<pre>";
					print_r($chartLeftData);
					die;*/
					if(count($chartLeftData)>0){
						$this->opportunity_model->deleteDuedilligenceLeftChart($getLicenseData->id);
						$this->opportunity_model->deleteLeftChart($leadID);
						foreach($chartLeftData as $chart){
							$this->opportunity_model->saveDuediligenceChartLeft($chart);
							unset($chart['license_id']);
							$chart['lead_id'] = $leadID;
							$this->opportunity_model->saveChartLeft($chart);
						}
					}
				}
				/*End Left Chart*/
				/*Right Chart*/
				$lifeSpan = array();
				$lifeSpanChartData = array();	
				$patentData = $this->opportunity_model->findScrapDataFromParent($leadID,'sd.priority,sd.expired');
				foreach($patentData as $patentsFillData){
					$currentDate = trim($patentsFillData->priority);
					$expirationDate = $patentsFillData->expired;	
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
				}
				if(count($lifeSpanChartData)>0){
					$this->opportunity_model->deleteRightChart($leadID);
					$this->opportunity_model->deleteDRightChart($getLicenseData->id);
					for($i=0;$i<count($lifeSpanChartData);$i++){
						if(isset($lifeSpanChartData[$i]['0']) && !empty($lifeSpanChartData[$i]['0'])){
							$this->opportunity_model->saveChartRight(array('lead_id'=>$leadID,'Year'=>$lifeSpanChartData[$i]['0'],'data'=>$lifeSpanChartData[$i]['1']),false);
							$this->opportunity_model->saveDChartRight(array('license_id'=>$getLicenseData->id,'year'=>$lifeSpanChartData[$i]['0'],'data'=>$lifeSpanChartData[$i]['1']),false);
						}							
					}
				}							
				/*End Right Chart*/				
			}
		}
	}
	
	public function check_job_parent_patent(){
		$data = array('count'=>0,'job_id'=>0,'account_id'=>0,'data'=>array());
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$checkJObStatus = $this->lead_model->findJobDetails($this->input->post('j'),'status,account');
			if(count($checkJObStatus)>0){
				$data = $this->lead_model->getLeadPatentDataList($checkJObStatus->account);
				if($data['count']>0 && count($data['data'])>0 && count($data['data'])==$data['count']){					
					$this->dueDilligenceLeftRightChart($checkJObStatus->account);
				}
				$data['account_id'] = $checkJObStatus->account;
			}
			$data['job_id'] = $this->input->post('j');
		} 
		echo json_encode($data);
		die;
	}
	
	public function lead_patent_data(){
		$data = array('data'=>array(),'job_queue'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['data'] = $this->lead_model->getLeadPatentParentData($this->input->post('l'));
			if(count($data['data'])>0){
				$this->dueDilligenceLeftRightChart($this->input->post('l'));
			} else {
				/*Find is in Queue*/
				$checkJObStatus = $this->lead_model->findJobDetailsByLead($this->input->post('l'),'status,id');
				if(count($checkJObStatus)>0 && $checkJObStatus->status==0){
					$data['job_queue'] = $checkJObStatus->id;
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function check_job_patent(){
		$data = array('status'=>0,'job_id'=>0,'patent_family'=>array());
		if(isset($_POST) && count($_POST)>0){
			$data['job_id'] = $this->input->post('j');
			$this->load->model('lead_model');
			$checkJObStatus = $this->lead_model->findJobDetails($data['job_id'],'status,account');
			if(count($checkJObStatus)>0){
				$data['status'] = $checkJObStatus->status;
				if((int)$data['status']==1){
					$getFamilyDataFrom = $this->lead_model->getLeadPatentFamilyData($this->input->post('l'));
					if(count($getFamilyDataFrom)>0){
						$data['patent_family'] = $getFamilyDataFrom;
					}
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	function embedScheduleCall(){
		if(isset($_POST) && count($_POST)){
			$this->load->model('lead_model');
			$embedCode = $this->input->post('embed_code');			
			$getData = $this->lead_model->getLeadData($_POST['lead_id']);
			if(count($getData)>0){
				if(!empty($getData->embed_code)){
					$embedCode = $getData->embed_code.",".$embedCode;
				}
			}
			$update_data = array('embed_code'=>$embedCode);
			$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
			echo "1";
		} else {
			echo "0";
		}
		die;
	}
	/*
	function create_spreadsheet_for_hole(){
		$data = array("url"=>'');
		if(isset($_POST) && count($_POST)>0){
			$lead = $this->input->post('lead');
			$activity = $this->input->post('activity');
			$records = $this->input->post('rec');
			if(!empty($records)){
				$list = json_decode($records);
				if(count($list)>0){
					
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$leadFolderID = false;
					$leadInfo = $this->lead_model->getLeadData($lead);
					if(count($leadInfo)>0){
						if(!empty($leadInfo->folder_id)){
							$leadFolderID = $leadInfo->folder_id;
						}
					}
					if($leadFolderID){
						$fileParent = new Google_Service_Drive_ParentReference();
						$fileParent->setId($leadFolderID);
						$fileName = "Hole Data - ".$leadInfo->lead_name;
						$getFile = $service->copyFile('1f7kpUyr7KUZONyrFUcWhIS_rwKHc2ZbQ_SYF7alBPvY',$fileName,$fileParent);
						$updateDate = date('Y-m-d H:i:s');
						if($getFile){
							$data['url'] = $getFile->alternateLink;
							$spreadSheetService = new SpreadsheetServiceHelper();
							$spreadsheet = $spreadSheetService->getSpreadsheetById($getFile->id);
							$newListFeed = $spreadSheetService->getWorkSheetByName("Sheet1");
							for($i=0;$i<count($list);$i++){
								$phone=$list[$i]->telephone;
								if(!empty($phone)){
									$phone = "Client property";
								}
								$email = $list[$i]->email;
								if(!empty($email)){
									$email = "Client property";
								}
								$linkedin = $list[$i]->linkedin;
								if(!empty($linkedin)){
									$linkedin = "Client property";
								}
								$newListFeed->insert(array("name"=>$list[$i]->name,"title"=>$list[$i]->title,"company"=>$list[$i]->company,"phone"=>$phone,"email"=>$email,"linkedin"=>$linkedin));
							}
							
							$this->lead_model->from_litigation_update($leadInfo->id,array('hole_spreadsheet'=>$getFile->alternateLink));
							$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$leadInfo->id,'message'=>'Create hole spreadsheet','create_date'=>date('Y-m-d H:i:s')));
						}
					}
				}
			}
		}
		echo json_encode($data);
		die;
	}*/
	
	function removeDoubleQuotes($string){
		$pattern = "/\"/"; 
		$replace = ""; 
		return preg_replace($pattern,$replace,$string);
	}
	
	function create_spreadsheet_for_hole(){
		$data = array("url"=>'');
		if(isset($_POST) && count($_POST)>0){
			$records = $this->input->post('rec');
			$projectName = $this->input->post('project_name');
			$deadline = $this->input->post('deadline');
			$heading = $this->input->post('heading');
			if(!empty($records)){
				$list = json_decode($records);
				if(count($list)>0){
					$this->load->model('outsource_model');
					/*Create Project*/
					$headings = json_decode($heading);
					$columnCount = 4 + count($headings);
					$projectID = $this->outsource_model->insertProject(array('project_name'=>$projectName,'deadline'=>$deadline,'row_count'=>count($list),'col_count'=>$columnCount,'created_date'=>date('Y-m-d H:i:s')));
					$this->outsource_model->insertUserProject(array('project_id'=>$projectID,'user_id'=>10));
					$this->outsource_model->insertColumns(array('project_id'=>$projectID,'column_num'=>1,"heading"=>"First Name","price"=>'0.00','status'=>0));
					$this->outsource_model->insertColumns(array('project_id'=>$projectID,'column_num'=>2,"heading"=>"Last Name","price"=>'0.00','status'=>0));
					$this->outsource_model->insertColumns(array('project_id'=>$projectID,'column_num'=>3,"heading"=>"Title","price"=>'0.00','status'=>0));
					$this->outsource_model->insertColumns(array('project_id'=>$projectID,'column_num'=>4,"heading"=>"Company","price"=>'0.00','status'=>0));
					
					if(count($headings)>0){
						foreach($headings as $head){
							$headingName = "";
							$verified=0;
							switch((int)$head->id){
								case 5:
									$headingName = "Email";
									$verified=1;
								break;
								case 6:
									$headingName = "Workphone";
									$verified=2;
								break;
								case 7:
									$headingName = "Cellphone";
									$verified=2;
								break;
								case 8:
									$headingName = "LinkedIn";
									$verified=3;
								break;
							}
							$this->outsource_model->insertColumns(array('project_id'=>$projectID,'column_num'=>$head->id,"heading"=>$headingName,"price"=>$head->price,"verified"=>$verified));
						}
					}
					/*
					$this->outsource_model->insertColumns(array('project_id'=>$projectID,'column_num'=>6,"heading"=>"Mobile Number","price"=>'0.20'));
					$this->outsource_model->insertColumns(array('project_id'=>$projectID,'column_num'=>7,"heading"=>"Telephone","price"=>'0.20'));
					$this->outsource_model->insertColumns(array('project_id'=>$projectID,'column_num'=>8,"heading"=>"LinkedIn","price"=>'0.20'));
					*/
					$n=1;
					for($i=0;$i<count($list);$i++){
						$firstName = $this->removeDoubleQuotes(trim($list[$i]->first_name));
						$lastName = $this->removeDoubleQuotes(trim($list[$i]->last_name));
						$title = $this->removeDoubleQuotes(trim($list[$i]->title));
						$company = $this->removeDoubleQuotes(trim($list[$i]->company));
						$this->outsource_model->insertProjectData(array('project_id'=>$projectID,'row'=>$n,'col'=>1,'data'=>$firstName,'contact_id'=>$list[$i]->contact_id,'enter_by'=>'Client','created_date'=>date('Y-m-d H:i:s')));
						$this->outsource_model->insertProjectData(array('project_id'=>$projectID,'row'=>$n,'col'=>2,'data'=>$lastName,'contact_id'=>$list[$i]->contact_id,'enter_by'=>'Client','created_date'=>date('Y-m-d H:i:s')));
						$this->outsource_model->insertProjectData(array('project_id'=>$projectID,'row'=>$n,'col'=>3,'data'=>$title,'contact_id'=>$list[$i]->contact_id,'enter_by'=>'Client','created_date'=>date('Y-m-d H:i:s')));
						$this->outsource_model->insertProjectData(array('project_id'=>$projectID,'row'=>$n,'col'=>4,'data'=>$company,'contact_id'=>$list[$i]->contact_id,'enter_by'=>'Client','created_date'=>date('Y-m-d H:i:s')));
						$enterColumn=false;
						if(count($headings)>0){
							foreach($headings as $head){
								if($head->id==5){
									$enterColumn=true;
								}
							}
						}
						if($enterColumn===true){
							$email = trim($list[$i]->email);
							$type="Free";
							if(!empty($email)){
								$type="Client";
							}
							$this->outsource_model->insertProjectData(array('project_id'=>$projectID,'row'=>$n,'col'=>5,'data'=>$email,'contact_id'=>$list[$i]->contact_id,'enter_by'=>$type,'created_date'=>date('Y-m-d H:i:s')));
						}
						$enterColumn=false;
						if(count($headings)>0){
							foreach($headings as $head){
								if($head->id==6){
									$enterColumn=true;
								}
							}
						}
						if($enterColumn===true){						
							$phone=trim($list[$i]->phone);
							$type="Free";
							if(!empty($phone)){
								$type="Client";
							}
							$this->outsource_model->insertProjectData(array('project_id'=>$projectID,'row'=>$n,'col'=>6,'data'=>$phone,'contact_id'=>$list[$i]->contact_id,'enter_by'=>$type,'created_date'=>date('Y-m-d H:i:s')));
						}
						$enterColumn=false;
						if(count($headings)>0){
							foreach($headings as $head){
								if($head->id==7){
									$enterColumn=true;
								}
							}
						}
						if($enterColumn===true){
							$telephone=trim($list[$i]->telephone);
							$type="Free";
							if(!empty($telephone)){
								$type="Client";
							}
							$this->outsource_model->insertProjectData(array('project_id'=>$projectID,'row'=>$n,'col'=>7,'data'=>$telephone,'contact_id'=>$list[$i]->contact_id,'enter_by'=>$type,'created_date'=>date('Y-m-d H:i:s')));
						}
						$enterColumn=false;
						if(count($headings)>0){
							foreach($headings as $head){
								if($head->id==8){
									$enterColumn=true;
								}
							}
						}
						if($enterColumn===true){
							$type="Free";
							$linkedin = trim($list[$i]->linkedin);
							if(!empty($linkedin)){
								$type="Client";
							}
							$this->outsource_model->insertProjectData(array('project_id'=>$projectID,'row'=>$n,'col'=>8,'data'=>$linkedin,'contact_id'=>$list[$i]->contact_id,'enter_by'=>$type,'created_date'=>date('Y-m-d H:i:s')));
						}
						$n++;
					}
					$data = array("url"=>$projectID);
					/*$this->lead_model->from_litigation_update($leadInfo->id,array('hole_spreadsheet'=>$projectID));*/
					$this->load->model('user_model');
					$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>0,'message'=>'Create hole spreadsheet','create_date'=>date('Y-m-d H:i:s')));
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	
	function createLeadPatentSpreadSheet(){
		$data = array("url"=>'',"error"=>1,"message"=>"Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			$spreadSheetName = $this->input->post('n');
			if(!empty($spreadSheetName)){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$leadFolderID = false;
				$this->load->model('lead_model');
				$leadInfo = $this->lead_model->getLeadData($_POST['lead_id']);
				if(count($leadInfo)>0){
					if(!empty($leadInfo->folder_id)){
						$leadFolderID = $leadInfo->folder_id;
					}
				}				
				if($leadFolderID){					
					/*Check File*/
					//$existFile = $service->getFileNameFromChildern($leadFolderID,"Patent List - ".ucfirst($spreadSheetName));
					$existFile =false;
					if($existFile==false){
						$fileParent = new Google_Service_Drive_ParentReference();
						$fileParent->setId($leadFolderID);
						/*$getFileInfo = $service->createSpreadSheetFile("Patent List - ".ucfirst($spreadSheetName),$fileParent);*/
						$getFile = $service->copyFile('1BPgiG3USyx1TQmQ81q721-6PJhlFsbaU4FlUNf5C0Ow',"Patent List - ".ucfirst($spreadSheetName),$fileParent);
						if($getFile){
							/*$getFile = $service->getFileInfo($getFileInfo);*/
							if(is_object($getFile)){
								$updateDate = date('Y-m-d H:i:s');
								$originalButtonData = $this->lead_model->findButtonByButtonID($leadInfo->type,"PATENT_LIST");
								if(isset($_POST['ds'])){
									$updateLeadData = array('create_patent_list'=>'2','spreadsheet_id'=>$getFile->id,'spreadsheet_name'=>$getFile->title,'file_url'=>$getFile->alternateLink,'create_patent_list_text' => $updateDate);
									$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$updateLeadData);
									/*Transfer ownership*/
									$service->setPermissions( $getFile->id, "uzi@synpat.com","writer","user");
									$spreadSheet = new SpreadsheetServiceHelper();
									/*$newSpreadsheet = $spreadSheet->getSpreadsheetById($getFile->id);*/									
									$spreadSheet->protectRange($getFile->id);
									/*$getPermissionList = $service->getPrmissionsList($getFile->id);
									if(count($getPermissionList)>0){
										foreach($getPermissionList as $permission){
											echo $permission->emailAddress."<br/>";
											if($permission->emailAddress=='uzi@synpat.com'){
												/**/
												/*echo "FileID:".$getFile->id."<br/>";
												echo "PermissionID:".$permission->id."<br/>";
												$changePermissions = $service->updatePermission($getFile->id,$permission->id,'owner',array('transferOwnership'=>true,"removeExpiration"=>true));
												echo "<pre>";
												print_r($changePermissions);
												break;
												
											}
										}
									}*/
								}
								if(count($originalButtonData)>0){
									$leadButtonData = $this->lead_model->findLeadButtonByButtonID($_POST['lead_id'],$originalButtonData->id);
									if(count($leadButtonData)>0){
										$newStatus = "";									
										$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButtonData->status_message.' <br/>';
										$newStatus = $leadButtonData->status_message_fill.$newStatus;	
										$this->lead_model->updateButton(array('status'=>1,'update_date'=>$updateDate,'status_message_fill'=>$newStatus),$leadButtonData->id);
									}
								}
								$data = array("url"=>$getFile->alternateLink,"spread_sheet_id"=>$getFile->id,"error"=>0,"message"=>"Successfully created.",'date_created' => date("m d, y"));
							} else {
								$data = array("url"=>'',"error"=>1,"message"=>"File not created. Please try after sometime.");
							}
						
						} else {
							$data = array("url"=>'',"error"=>1,"message"=>"File not created. Please try after sometime.");
						}
					} else {
						$updateDate = date('Y-m-d H:i:s');
						$originalButtonData = $this->lead_model->findButtonByButtonID($leadInfo->type,"PATENT_LIST");
						if(isset($_POST['ds'])){
							$updateLeadData = array('create_patent_list'=>'2','spreadsheet_id'=>$existFile->id,'spreadsheet_name'=>$existFile->title,'file_url'=>$existFile->alternateLink,'create_patent_list_text' => $updateDate);
							$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$updateLeadData);
						}	
						if(count($originalButtonData)>0){
							$leadButtonData = $this->lead_model->findLeadButtonByButtonID($_POST['lead_id'],$originalButtonData->id);
							if(count($leadButtonData)>0){
								$newStatus = "";									
								$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButtonData->status_message.' <br/>';
								$newStatus = $leadButtonData->status_message_fill.$newStatus;	
								$this->lead_model->updateButton(array('status'=>1,'update_date'=>$updateDate,'status_message_fill'=>$newStatus),$leadButtonData->id);
							}
						}	
						$data = array("url"=>$existFile->alternateLink,"spread_sheet_id"=>$existFile->id,"error"=>0,"message"=>"Successfully created.",'date_created' => date("m d, y"));
					}
				} else {
					$data = array("url"=>'',"error"=>1,"message"=>"File not created. Please try after sometime.");
				}
			} else {
				$data = array("url"=>'',"error"=>1,"message"=>"Please enter filename.");
			}
		}
		echo json_encode($data);
		die;
	}
	
	function legalStatusChange(){
		$data = array("url"=>'',"error"=>1,"message"=>"Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$leadInfo = $this->lead_model->getLeadData($_POST['lead_id']);
			if(count($leadInfo)>0){
				$update_data = array('legal_status_dd'=>'2','legal_dd' => date('Y-m-d H:i:s'));
				$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
				if($saveMarket>0){
					$data = array("error"=>0,"message"=>"Successfully created.",'date_created' => date("m d, y"));
				} else {
					$data = array("error"=>1,"message"=>"Server busy, Try after sometime.");
				}				
			}
		}
		echo json_encode($data);
		die;
	}
	
	function btn_status_change(){
		$data = array("url"=>'',"error"=>1,"message"=>"Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$btnInfo = $this->lead_model->findLeadButtonByID($_POST['lead_id'],$_POST['b']);
			if(count($btnInfo)==0){
				$btnInfo = $this->lead_model->findDocketButtonByID($_POST['lead_id'],$_POST['b']);
			}
			$update_data = array('blink'=>'2','status'=>1,'update_date' => date('Y-m-d H:i:s'));
			$saveMarket = $this->lead_model->updateButton($update_data,$btnInfo->id);
			if($saveMarket>0){
				$data = array("error"=>0,"message"=>"Successfully created.",'date_created' => date("m d, y"));
			} else {
				$saveMarket = $this->lead_model->updateDocketButton($update_data,$btnInfo->id);
				if($saveMarket>0){
					$data = array("error"=>0,"message"=>"Successfully created.",'date_created' => date("m d, y"));
				} else {
					$data = array("error"=>1,"message"=>"Server busy, Try after sometime.");
				} 
			}	
		}
		echo json_encode($data);
		die;
	}
	
	function technicalStatusChange(){
		$data = array("url"=>'',"error"=>1,"message"=>"Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$leadInfo = $this->lead_model->getLeadData($_POST['lead_id']);
			if(count($leadInfo)>0){
				$update_data = array('technical_status_dd'=>'2','technical_dd' => date('Y-m-d H:i:s'));
				$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
				if($saveMarket>0){
					$data = array("error"=>0,"message"=>"Successfully created.",'date_created' => date("m d, y"));
				} else {
					$data = array("error"=>1,"message"=>"Server busy, Try after sometime.");
				}				
			}
		}
		echo json_encode($data);
		die;
	}
	
	function claimIllusStatusChange(){
		$data = array("url"=>'',"error"=>1,"message"=>"Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$leadInfo = $this->lead_model->getLeadData($_POST['lead_id']);
			if(count($leadInfo)>0){
				$update_data = array('claim_status_dd'=>'2','claim_illus' => date('Y-m-d H:i:s'));
				$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
				if($saveMarket>0){
					$data = array("error"=>0,"message"=>"Successfully created.",'date_created' => date("m d, y"));
				} else {
					$data = array("error"=>1,"message"=>"Server busy, Try after sometime.");
				}				
			}
		}
		echo json_encode($data);
		die;
	}
	
	function createLegalDD(){
		$data = array("url"=>'',"error"=>1,"message"=>"Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$leadFolderID = false;
			$this->load->model('lead_model');
			$leadInfo = $this->lead_model->getLeadData($_POST['lead_id']);
			if(count($leadInfo)>0){
				if(!empty($leadInfo->folder_id)){
					$leadFolderID = $leadInfo->folder_id;
				}
			}				
			if($leadFolderID){				
				$fileParent = new Google_Service_Drive_ParentReference();
				$fileParent->setId($leadFolderID);
	
				$fileName = "Legal Due Dilligence - ".$leadInfo->lead_name;
				$getFile = $service->copyFile('1vYY9A5d1xQOsuiFEDFw_nPqPniiopHX10-s_6J6hcr8',$fileName,$fileParent);
				if($getFile){	
					$updateDate = date('Y-m-d H:i:s');
					if(isset($_POST['ds'])){
						$updateLead = array('legal_status_dd'=>'1','legal_dd' => $updateDate);
						$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$updateLead);
					}
					$originalButtonData = $this->lead_model->findButtonByButtonID($leadInfo->type,"LEGAL_DD");
					if(count($originalButtonData)>0){
						$leadButtonData = $this->lead_model->findLeadButtonByButtonID($leadInfo->id,$originalButtonData->id);
						if(count($leadButtonData)>0){
							$newStatus = "";									
							$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButtonData->status_message.' <br/>';
							$newStatus = $leadButtonData->status_message_fill.$newStatus;	
							$this->lead_model->updateButton(array('status'=>1,'update_date'=>$updateDate,'status_message_fill'=>$newStatus),$leadButtonData->id);
						}
					}
					/*Get Patent File*/
					$asset_data = array();
					$ss_id = $leadInfo->spreadsheet_id;
					if(!empty($ss_id)){
						$this->load->library('DriveServiceHelper');
						$spreadSheetService = new SpreadsheetServiceHelper();
						$spreadsheet = $spreadSheetService->getSpreadsheetById($ss_id);
						$allWorkSheet = $spreadSheetService->getAllWorkSheets();
						$workSheetName = "";
						if(!empty($leadInfo->worksheet_id)){
							foreach($allWorkSheet as $worksheet){
								if($worksheet['id']==$leadInfo->worksheet_id){
									$workSheetName = $worksheet['text'];
								}
							}
						}
						if(empty($workSheetName)){
							$workSheetName = "Sheet1";
						}
						
						$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
						$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());	
						if(count($asset_data)>0){
							/*New SpreadSheet*/
							$newSpreadsheet = $spreadSheetService->getSpreadsheetById($getFile->id);
							$allWorkSheet = $spreadSheetService->getAllWorkSheets();
							$newListFeed = $spreadSheetService->getWorkSheetByName("Legal DD");
							$newSheetData =$spreadSheetService->getAllRows($newListFeed->getEntries());	
							$a=2;
							for($i=0;$i<count($asset_data);$i++){
								$patent ='=hyperlink(concatenate("https://patents.google.com/patent/",importrange("'.$ss_id.'","Sheet1!A'.$a.':A'.$a.'"),"/en"),importrange("'.$ss_id.'","Sheet1!A'.$a.':A'.$a.'"))';
								$newListFeed->insert(array("bibliographicinformation"=>$patent));
								$a++;
							}
						}
					}
					/*End Patent File*/
					
											
					$data = array("url"=>$getFile->alternateLink,"spread_sheet_id"=>$getFile->id,"mimeType"=>$getFile->mimeType,'iconLink'=>$getFile->iconLink,'title'=>$getFile->title,"pp"=>count($asset_data),"f_t"=>'Legal',"error"=>0,"message"=>"Successfully created.",'date_created' => date("m d, y"));
					
				} else {
					$data = array("url"=>'',"error"=>1,"message"=>"File not created. Please try after sometime.");
				}
			} else {
				$data = array("url"=>'',"error"=>1,"message"=>"File not created. Please try after sometime.");
			}
		}
		echo json_encode($data);
		die; 
	}
	
	function createClaimillustration(){
		$data = array("url"=>'',"error"=>1,"message"=>"Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$leadFolderID = false;
			$this->load->model('lead_model');
			$leadInfo = $this->lead_model->getLeadDataWithOptions($_POST['lead_id'],'l.folder_id,l.lead_name,l.type,l.id,l.worksheet_id,l.spreadsheet_id,l.claim_illus_file');
			if(count($leadInfo)>0){
				if(!empty($leadInfo->folder_id)){
					$leadFolderID = $leadInfo->folder_id;
				}
			}				
			if($leadFolderID){			
				/*if(!empty($leadInfo->claim_illus_file)){
					$getFile = $service->getFileInfo($leadInfo->claim_illus_file);
				} else {
					$fileParent = new Google_Service_Drive_ParentReference();
					$fileParent->setId($leadFolderID);	
					$fileName = "Claim Illustration - ".$leadInfo->lead_name;
					$getFile = $service->copyFile('1wzKB9Ot8TQaBw7vcKBB-prigY36Q85pyn2R_pbhj6g4',$fileName,$fileParent);
				}		*/			
				$updateDate = date('Y-m-d H:i:s');
				$getFile = (object)array("id"=>"no_file_create");
				if(is_object($getFile)){
					if(isset($_POST['ds'])){
						$updateInfo = array('claim_status_dd'=>'1','claim_illus_file'=>$getFile->id,'claim_illus' => $updateDate);
						$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$updateInfo);
					}
					$originalButtonData = $this->lead_model->findButtonByButtonID($leadInfo->type,"CLAIM_ILLUS");
					if(count($originalButtonData)>0){
						$leadButtonData = $this->lead_model->findLeadButtonByButtonID($leadInfo->id,$originalButtonData->id);
						if(count($leadButtonData)>0){
							$newStatus = "";									
							$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButtonData->status_message.' <br/>';
							$newStatus = $leadButtonData->status_message_fill.$newStatus;	
							$this->lead_model->updateButton(array('status'=>1,'update_date'=>$updateDate,'status_message_fill'=>$newStatus),$leadButtonData->id);
						}
					}
					$spreadSheetService = new SpreadsheetServiceHelper();
					/*$newSpreadsheet = $spreadSheetService->getSpreadsheetById($getFile->id);
					$newListFeed = $spreadSheetService->getWorkSheetByName("Sheet1");*/
					$fileParent = new Google_Service_Drive_ParentReference();
					$fileParent->setId($leadFolderID);
					$subfolderCreate = $service->createSubFolder("Illustration",$fileParent);
					/*End Patent File*/
					$asset_data = $this->lead_model->getLeadPatentList($_POST['lead_id']);					
					/*End Patent File*/														    
					$data = array("url"=>$subfolderCreate,"spread_sheet_id"=>$subfolderCreate,"mimeType"=>$subfolderCreate,'iconLink'=>'','title'=>'',"pp"=>count($asset_data),"f_t"=>'Claim',"error"=>0,"message"=>"Successfully created.",'date_created' => date("m d, y"),'patent_list'=>$asset_data,'folder_id'=>$subfolderCreate,'ss_id'=>$ss_id,'lead_name'=>$leadInfo->lead_name);					
				
				} else {
					$data = array("url"=>'',"error"=>1,"message"=>"File not created. Please try after sometime.");
				}
			} else {
				$data = array("url"=>'',"error"=>1,"message"=>"File not created. Please try after sometime.");
			}
		}
		echo json_encode($data);
		die;
	}
	
	function createPatentIllustration(){
		$data = array("url"=>'',"error"=>1,"message"=>"File not created. Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			/*$spreadSheetService = new SpreadsheetServiceHelper();*/
			if(isset($_POST['folder_id']) && !empty($_POST['folder_id'])){
				$p = $this->input->post('p');
				$a = $this->input->post('a');
				$ss_id = $this->input->post('ss_id');
				$lead_name = $this->input->post('lead_name');
				/*$calimFileID = $this->input->post('spread_sheet_id');
				$newSpreadsheet = $spreadSheetService->getSpreadsheetById($calimFileID);
				$newListFeed = $spreadSheetService->getWorkSheetByName("Sheet1");*/
				$subfolderCreate = $this->input->post('folder_id');
				if($subfolderCreate){
					$fileParent = new Google_Service_Drive_ParentReference();
					$fileParent->setId($subfolderCreate);
					$name = "Synpat - Claim Illustration - ".$lead_name." - ".$p;
					$getPresentationFileInfo = $service->copyFile('132wUJ3B9V_g0VYTebtnlWvuBzf4FtCsMjZEHT_dhawc',$name,$fileParent);
					if($getPresentationFileInfo){
						/*Create Slide Files*/
						$service->setAdditionalPermissions( $getPresentationFileInfo->id, "","reader","anyone");
						/*$getPresentationFileInfo = $service->getFileInfo($getPresentationFile);*/
						$fileUrl = $getPresentationFileInfo->alternateLink;
						/*$url = '=hyperlink("'.$fileUrl.'","Chart")';
						$patent ='=hyperlink(concatenate("https://patents.google.com/patent/",importrange("'.$ss_id.'","Sheet1!A'.$a.':A'.$a.'"),"/en"),importrange("'.$ss_id.'","Sheet1!A'.$a.':A'.$a.'"))';
						$newListFeed->insert(array("patents"=>$patent,"url"=>$url));*/
						$data = array("url"=>$fileUrl,"error"=>0,"message"=>"Successfully created.");
					}
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	function createTechnicalDD(){
		$data = array("url"=>'',"error"=>1,"message"=>"Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$leadFolderID = false;
			$this->load->model('lead_model');
			$leadInfo = $this->lead_model->getLeadData($_POST['lead_id']);
			if(count($leadInfo)>0){
				if(!empty($leadInfo->folder_id)){
					$leadFolderID = $leadInfo->folder_id;
				}
			}				
			if($leadFolderID){				
				$fileParent = new Google_Service_Drive_ParentReference();
				$fileParent->setId($leadFolderID);
	
				$fileName = "Technical Due Dilligence - ".$leadInfo->lead_name;
				$getFile = $service->copyFile('1n7IczwCjb5XavWGesFEYbDk3ttPDw8lIPUcykyu25oY',$fileName,$fileParent);
				if($getFile){
					$updateDate = date('Y-m-d H:i:s');
					if(isset($_POST['ds'])){
						$updateLeadInfo = array('technical_status_dd'=>'1','technical_file'=>$getFile->id,'technical_dd' => $updateDate);
						$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$updateLeadInfo);
					}
					$originalButtonData = $this->lead_model->findButtonByButtonID($leadInfo->type,"TECHNICAL_DD");
					if(count($originalButtonData)>0){
						$leadButtonData = $this->lead_model->findLeadButtonByButtonID($leadInfo->id,$originalButtonData->id);
						if(count($leadButtonData)>0){
							$newStatus = "";									
							$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButtonData->status_message.' <br/>';
							$newStatus = $leadButtonData->status_message_fill.$newStatus;	
							$this->lead_model->updateButton(array('status'=>1,'update_date'=>$updateDate,'status_message_fill'=>$newStatus),$leadButtonData->id);
						}
					}
										
					/*End Patent File*/
					/*Get Patent File*/
					$ss_id = $leadInfo->spreadsheet_id;
					$asset_data  = array();
					if(!empty($ss_id)){
						$this->load->library('DriveServiceHelper');
						$spreadSheetService = new SpreadsheetServiceHelper();
						$spreadsheet = $spreadSheetService->getSpreadsheetById($ss_id);
						$allWorkSheet = $spreadSheetService->getAllWorkSheets();
						$workSheetName = "";
						if(!empty($leadInfo->worksheet_id)){
							foreach($allWorkSheet as $worksheet){
								if($worksheet['id']==$leadInfo->worksheet_id){
									$workSheetName = $worksheet['text'];
								}
							}
						}
						if(empty($workSheetName)){
							$workSheetName = "Sheet1";
						}
						$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
						$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());	
						if(count($asset_data)>0){
							/*New SpreadSheet*/
							$newSpreadsheet = $spreadSheetService->getSpreadsheetById($getFile->id);
							$newListFeed = $spreadSheetService->getWorkSheetByName("Sheet1");
							/*$newSheetData =$spreadSheetService->getAllRows($newListFeed->getEntries());	*/
							$a=2;
							for($i=0;$i<count($asset_data);$i++){
								$patent ='=hyperlink(concatenate("https://patents.google.com/patent/",importrange("'.$ss_id.'","Sheet1!A'.$a.':A'.$a.'"),"/en"),importrange("'.$ss_id.'","Sheet1!A'.$a.':A'.$a.'"))';
								$newListFeed->insert(array("patent"=>$patent));
								$a++;
							}
						}
					}
					/*End Patent File*/														    
					$data = array("url"=>$getFile->alternateLink,"spread_sheet_id"=>$getFile->id,"mimeType"=>$getFile->mimeType,'iconLink'=>$getFile->iconLink,'title'=>$getFile->title,"pp"=>count($asset_data),"f_t"=>'Technical',"error"=>0,"message"=>"Successfully created.",'date_created' => date("m d, y"));
					
				
				} else {
					$data = array("url"=>'',"error"=>1,"message"=>"File not created. Please try after sometime.");
				}
			} else {
				$data = array("url"=>'',"error"=>1,"message"=>"File not created. Please try after sometime.");
			}
		}
		echo json_encode($data);
		die;
	}
	
	
    
    function update_ndaTimeStampStatus(){
        $update_data = array('nda_term_sheet_text'=>date('Y-m-d H:i:s'));
		$this->load->model('lead_model');
		$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
    }
    
	function executeCurl($getPatentNumber){
		$content = "";
		if(!empty($getPatentNumber)){
			/*$last2Char = substr($getPatentNumber,strlen($getPatentNumber)-2);
			if(is_numeric($last2Char)){$getPatentNumber = $getPatentNumber."B2";}*/
			/*$url = "ec2-52-38-222-126.us-west-2.compute.amazonaws.com/webdriver/index.php?patent=".$getPatentNumber;*/
			$url = "http://104.197.127.111/index.php?patent=".$getPatentNumber;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			$content = curl_exec($ch);
			curl_close($ch);			
		}
		return $content;
	}
	
	function executeCurlOld($getPatentNumber){
		$content = "";
		if(!empty($getPatentNumber)){
			/*$last2Char = substr($getPatentNumber,strlen($getPatentNumber)-2);
			if(is_numeric($last2Char)){$getPatentNumber = $getPatentNumber."B2";}*/
			/*$url = "ec2-52-38-222-126.us-west-2.compute.amazonaws.com/webdriver/index.php?patent=".$getPatentNumber;*/
			$url = "http://104.197.127.111/pagesource.php?patent=".$getPatentNumber;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			$content = curl_exec($ch);
			curl_close($ch);			
		}
		return $content;
	}
	
	public function post_seller_info(){ 
		$data = array("error"=>1,"message"=>"Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			$dateUpdate = date('Y-m-d H:i:s');
			$update_data = array('seller_info'=>'1','seller_info_text'=>$dateUpdate);
			$this->load->model('lead_model');
			$updatedRows = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
			$data = array('rows'=>$updatedRows,'date_created'=>date('m d,y',strtotime($dateUpdate)));
		}
		echo json_encode($data);
        die;
	}
    
    public function assign_lead(){
        $data = array("error"=>1,"message"=>"Please try after sometime.");
        if(isset($_POST) && count($_POST)>0){
			if(isset($_POST['ds'])){
				$dateUpdate = date('Y-m-d H:i:s');
				$update_data = array('seller_info'=>'2','seller_info_text'=>$dateUpdate);
				$this->load->model('lead_model');
				$this->load->model('user_model');
                $updatedRows = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
				$leadID = $_POST['lead_id'];
				$getLeadData = $this->lead_model->getLeadData($leadID);
				$buttonData = $this->lead_model->findButtonByButtonID($getLeadData->type,"SELLER");
				$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$leadID,'message'=>'Funds Transfer','create_date'=>date('Y-m-d H:i:s')));	
				$data = array('rows'=>$updatedRows,'button_data'=>$buttonData,'date_created'=>date('m d,y',strtotime($dateUpdate)));
			}
        }
        echo json_encode($data);
        die;
    }
    
    public function forward_to_review(){
        if(isset($_POST) && count($_POST)>0){
            $update_data = array('complete'=>1,'forward_to_review_text'=>date('Y-m-d H:i:s'));
			$this->load->model('lead_model');
			$this->load->model('user_model');
            $saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$update_data);
            $user_id = $this->session->userdata['id'];
            $create_date = date('Y-m-d H:i:s');
            $this->user_model->addUserHistory(array('user_id'=>$user_id,'lead_id'=>$_POST['lead_id'],'message'=>'Lead Forward to Review','create_date'=>$create_date));
            $data = array('date_created' => $create_date,'msg' => '1');
            
        } else { 
            $data = array('msg' => '2');
		}

        echo json_encode($data);
        die;
    }
	
	function mime_type($file) {
		// there's a bug that doesn't properly detect
		// the mime type of css files
		// https://bugs.php.net/bug.php?id=53035
		// so the following is used, instead
		// src: http://www.freeformatter.com/mime-types-list.html#mime-types-list
		
		/**
		 *                  **DISCLAIMER**
		 * This will just match the file extension to the following
		 * array. It does not guarantee that the file is TRULY that
		 * of the extension that this function returns.
		 */
		$mime_type = array(
			"3dml"			=>	"text/vnd.in3d.3dml",
			"3g2"			=>	"video/3gpp2",
			"3gp"			=>	"video/3gpp",
			"7z"			=>	"application/x-7z-compressed",
			"aab"			=>	"application/x-authorware-bin",
			"aac"			=>	"audio/x-aac",
			"aam"			=>	"application/x-authorware-map",
			"aas"			=>	"application/x-authorware-seg",
			"abw"			=>	"application/x-abiword",
			"ac"			=>	"application/pkix-attr-cert",
			"acc"			=>	"application/vnd.americandynamics.acc",
			"ace"			=>	"application/x-ace-compressed",
			"acu"			=>	"application/vnd.acucobol",
			"adp"			=>	"audio/adpcm",
			"aep"			=>	"application/vnd.audiograph",
			"afp"			=>	"application/vnd.ibm.modcap",
			"ahead"			=>	"application/vnd.ahead.space",
			"ai"			=>	"application/postscript",
			"aif"			=>	"audio/x-aiff",
			"air"			=>	"application/vnd.adobe.air-application-installer-package+zip",
			"ait"			=>	"application/vnd.dvb.ait",
			"ami"			=>	"application/vnd.amiga.ami",
			"apk"			=>	"application/vnd.android.package-archive",
			"application"		=>	"application/x-ms-application",
			"apr"			=>	"application/vnd.lotus-approach",
			"asf"			=>	"video/x-ms-asf",
			"aso"			=>	"application/vnd.accpac.simply.aso",
			"atc"			=>	"application/vnd.acucorp",
			"atom"			=>	"application/atom+xml",
			"atomcat"		=>	"application/atomcat+xml",
			"atomsvc"		=>	"application/atomsvc+xml",
			"atx"			=>	"application/vnd.antix.game-component",
			"au"			=>	"audio/basic",
			"avi"			=>	"video/x-msvideo",
			"aw"			=>	"application/applixware",
			"azf"			=>	"application/vnd.airzip.filesecure.azf",
			"azs"			=>	"application/vnd.airzip.filesecure.azs",
			"azw"			=>	"application/vnd.amazon.ebook",
			"bcpio"			=>	"application/x-bcpio",
			"bdf"			=>	"application/x-font-bdf",
			"bdm"			=>	"application/vnd.syncml.dm+wbxml",
			"bed"			=>	"application/vnd.realvnc.bed",
			"bh2"			=>	"application/vnd.fujitsu.oasysprs",
			"bin"			=>	"application/octet-stream",
			"bmi"			=>	"application/vnd.bmi",
			"bmp"			=>	"image/bmp",
			"box"			=>	"application/vnd.previewsystems.box",
			"btif"			=>	"image/prs.btif",
			"bz"			=>	"application/x-bzip",
			"bz2"			=>	"application/x-bzip2",
			"c"			=>	"text/x-c",
			"c11amc"		=>	"application/vnd.cluetrust.cartomobile-config",
			"c11amz"		=>	"application/vnd.cluetrust.cartomobile-config-pkg",
			"c4g"			=>	"application/vnd.clonk.c4group",
			"cab"			=>	"application/vnd.ms-cab-compressed",
			"car"			=>	"application/vnd.curl.car",
			"cat"			=>	"application/vnd.ms-pki.seccat",
			"ccxml"			=>	"application/ccxml+xml,",
			"cdbcmsg"		=>	"application/vnd.contact.cmsg",
			"cdkey"			=>	"application/vnd.mediastation.cdkey",
			"cdmia"			=>	"application/cdmi-capability",
			"cdmic"			=>	"application/cdmi-container",
			"cdmid"			=>	"application/cdmi-domain",
			"cdmio"			=>	"application/cdmi-object",
			"cdmiq"			=>	"application/cdmi-queue",
			"cdx"			=>	"chemical/x-cdx",
			"cdxml"			=>	"application/vnd.chemdraw+xml",
			"cdy"			=>	"application/vnd.cinderella",
			"cer"			=>	"application/pkix-cert",
			"cgm"			=>	"image/cgm",
			"chat"			=>	"application/x-chat",
			"chm"			=>	"application/vnd.ms-htmlhelp",
			"chrt"			=>	"application/vnd.kde.kchart",
			"cif"			=>	"chemical/x-cif",
			"cii"			=>	"application/vnd.anser-web-certificate-issue-initiation",
			"cil"			=>	"application/vnd.ms-artgalry",
			"cla"			=>	"application/vnd.claymore",
			"class"			=>	"application/java-vm",
			"clkk"			=>	"application/vnd.crick.clicker.keyboard",
			"clkp"			=>	"application/vnd.crick.clicker.palette",
			"clkt"			=>	"application/vnd.crick.clicker.template",
			"clkw"			=>	"application/vnd.crick.clicker.wordbank",
			"clkx"			=>	"application/vnd.crick.clicker",
			"clp"			=>	"application/x-msclip",
			"cmc"			=>	"application/vnd.cosmocaller",
			"cmdf"			=>	"chemical/x-cmdf",
			"cml"			=>	"chemical/x-cml",
			"cmp"			=>	"application/vnd.yellowriver-custom-menu",
			"cmx"			=>	"image/x-cmx",
			"cod"			=>	"application/vnd.rim.cod",
			"cpio"			=>	"application/x-cpio",
			"cpt"			=>	"application/mac-compactpro",
			"crd"			=>	"application/x-mscardfile",
			"crl"			=>	"application/pkix-crl",
			"cryptonote"		=>	"application/vnd.rig.cryptonote",
			"csh"			=>	"application/x-csh",
			"csml"			=>	"chemical/x-csml",
			"csp"			=>	"application/vnd.commonspace",
			"css"			=>	"text/css",
			"csv"			=>	"text/csv",
			"cu"			=>	"application/cu-seeme",
			"curl"			=>	"text/vnd.curl",
			"cww"			=>	"application/prs.cww",
			"dae"			=>	"model/vnd.collada+xml",
			"daf"			=>	"application/vnd.mobius.daf",
			"davmount"		=>	"application/davmount+xml",
			"dcurl"			=>	"text/vnd.curl.dcurl",
			"dd2"			=>	"application/vnd.oma.dd2+xml",
			"ddd"			=>	"application/vnd.fujixerox.ddd",
			"deb"			=>	"application/x-debian-package",
			"der"			=>	"application/x-x509-ca-cert",
			"dfac"			=>	"application/vnd.dreamfactory",
			"dir"			=>	"application/x-director",
			"dis"			=>	"application/vnd.mobius.dis",
			"djvu"			=>	"image/vnd.djvu",
			"dna"			=>	"application/vnd.dna",
			"doc"			=>	"application/msword",
			"docm"			=>	"application/vnd.ms-word.document.macroenabled.12",
			"docx"			=>	"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
			"dotm"			=>	"application/vnd.ms-word.template.macroenabled.12",
			"dotx"			=>	"application/vnd.openxmlformats-officedocument.wordprocessingml.template",
			"dp"			=>	"application/vnd.osgi.dp",
			"dpg"			=>	"application/vnd.dpgraph",
			"dra"			=>	"audio/vnd.dra",
			"dsc"			=>	"text/prs.lines.tag",
			"dssc"			=>	"application/dssc+der",
			"dtb"			=>	"application/x-dtbook+xml",
			"dtd"			=>	"application/xml-dtd",
			"dts"			=>	"audio/vnd.dts",
			"dtshd"			=>	"audio/vnd.dts.hd",
			"dvi"			=>	"application/x-dvi",
			"dwf"			=>	"model/vnd.dwf",
			"dwg"			=>	"image/vnd.dwg",
			"dxf"			=>	"image/vnd.dxf",
			"dxp"			=>	"application/vnd.spotfire.dxp",
			"ecelp4800"		=>	"audio/vnd.nuera.ecelp4800",
			"ecelp7470"		=>	"audio/vnd.nuera.ecelp7470",
			"ecelp9600"		=>	"audio/vnd.nuera.ecelp9600",
			"edm"			=>	"application/vnd.novadigm.edm",
			"edx"			=>	"application/vnd.novadigm.edx",
			"efif"			=>	"application/vnd.picsel",
			"ei6"			=>	"application/vnd.pg.osasli",
			"eml"			=>	"message/rfc822",
			"emma"			=>	"application/emma+xml",
			"eol"			=>	"audio/vnd.digital-winds",
			"eot"			=>	"application/vnd.ms-fontobject",
			"epub"			=>	"application/epub+zip",
			"es"			=>	"application/ecmascript",
			"es3"			=>	"application/vnd.eszigno3+xml",
			"esf"			=>	"application/vnd.epson.esf",
			"etx"			=>	"text/x-setext",
			"exe"			=>	"application/x-msdownload",
			"exi"			=>	"application/exi",
			"ext"			=>	"application/vnd.novadigm.ext",
			"ez2"			=>	"application/vnd.ezpix-album",
			"ez3"			=>	"application/vnd.ezpix-package",
			"f"			=>	"text/x-fortran",
			"f4v"			=>	"video/x-f4v",
			"fbs"			=>	"image/vnd.fastbidsheet",
			"fcs"			=>	"application/vnd.isac.fcs",
			"fdf"			=>	"application/vnd.fdf",
			"fe_launch"		=>	"application/vnd.denovo.fcselayout-link",
			"fg5"			=>	"application/vnd.fujitsu.oasysgp",
			"fh"			=>	"image/x-freehand",
			"fig"			=>	"application/x-xfig",
			"fli"			=>	"video/x-fli",
			"flo"			=>	"application/vnd.micrografx.flo",
			"flv"			=>	"video/x-flv",
			"flw"			=>	"application/vnd.kde.kivio",
			"flx"			=>	"text/vnd.fmi.flexstor",
			"fly"			=>	"text/vnd.fly",
			"fm"			=>	"application/vnd.framemaker",
			"fnc"			=>	"application/vnd.frogans.fnc",
			"fpx"			=>	"image/vnd.fpx",
			"fsc"			=>	"application/vnd.fsc.weblaunch",
			"fst"			=>	"image/vnd.fst",
			"ftc"			=>	"application/vnd.fluxtime.clip",
			"fti"			=>	"application/vnd.anser-web-funds-transfer-initiation",
			"fvt"			=>	"video/vnd.fvt",
			"fxp"			=>	"application/vnd.adobe.fxp",
			"fzs"			=>	"application/vnd.fuzzysheet",
			"g2w"			=>	"application/vnd.geoplan",
			"g3"			=>	"image/g3fax",
			"g3w"			=>	"application/vnd.geospace",
			"gac"			=>	"application/vnd.groove-account",
			"gdl"			=>	"model/vnd.gdl",
			"geo"			=>	"application/vnd.dynageo",
			"gex"			=>	"application/vnd.geometry-explorer",
			"ggb"			=>	"application/vnd.geogebra.file",
			"ggt"			=>	"application/vnd.geogebra.tool",
			"ghf"			=>	"application/vnd.groove-help",
			"gif"			=>	"image/gif",
			"gim"			=>	"application/vnd.groove-identity-message",
			"gmx"			=>	"application/vnd.gmx",
			"gnumeric"		=>	"application/x-gnumeric",
			"gph"			=>	"application/vnd.flographit",
			"gqf"			=>	"application/vnd.grafeq",
			"gram"			=>	"application/srgs",
			"grv"			=>	"application/vnd.groove-injector",
			"grxml"			=>	"application/srgs+xml",
			"gsf"			=>	"application/x-font-ghostscript",
			"gtar"			=>	"application/x-gtar",
			"gtm"			=>	"application/vnd.groove-tool-message",
			"gtw"			=>	"model/vnd.gtw",
			"gv"			=>	"text/vnd.graphviz",
			"gxt"			=>	"application/vnd.geonext",
			"h261"			=>	"video/h261",
			"h263"			=>	"video/h263",
			"h264"			=>	"video/h264",
			"hal"			=>	"application/vnd.hal+xml",
			"hbci"			=>	"application/vnd.hbci",
			"hdf"			=>	"application/x-hdf",
			"hlp"			=>	"application/winhlp",
			"hpgl"			=>	"application/vnd.hp-hpgl",
			"hpid"			=>	"application/vnd.hp-hpid",
			"hps"			=>	"application/vnd.hp-hps",
			"hqx"			=>	"application/mac-binhex40",
			"htke"			=>	"application/vnd.kenameaapp",
			"html"			=>	"text/html",
			"hvd"			=>	"application/vnd.yamaha.hv-dic",
			"hvp"			=>	"application/vnd.yamaha.hv-voice",
			"hvs"			=>	"application/vnd.yamaha.hv-script",
			"i2g"			=>	"application/vnd.intergeo",
			"icc"			=>	"application/vnd.iccprofile",
			"ice"			=>	"x-conference/x-cooltalk",
			"ico"			=>	"image/x-icon",
			"ics"			=>	"text/calendar",
			"ief"			=>	"image/ief",
			"ifm"			=>	"application/vnd.shana.informed.formdata",
			"igl"			=>	"application/vnd.igloader",
			"igm"			=>	"application/vnd.insors.igm",
			"igs"			=>	"model/iges",
			"igx"			=>	"application/vnd.micrografx.igx",
			"iif"			=>	"application/vnd.shana.informed.interchange",
			"imp"			=>	"application/vnd.accpac.simply.imp",
			"ims"			=>	"application/vnd.ms-ims",
			"ipfix"			=>	"application/ipfix",
			"ipk"			=>	"application/vnd.shana.informed.package",
			"irm"			=>	"application/vnd.ibm.rights-management",
			"irp"			=>	"application/vnd.irepository.package+xml",
			"itp"			=>	"application/vnd.shana.informed.formtemplate",
			"ivp"			=>	"application/vnd.immervision-ivp",
			"ivu"			=>	"application/vnd.immervision-ivu",
			"jad"			=>	"text/vnd.sun.j2me.app-descriptor",
			"jam"			=>	"application/vnd.jam",
			"jar"			=>	"application/java-archive",
			"java"			=>	"text/x-java-source,java",
			"jisp"			=>	"application/vnd.jisp",
			"jlt"			=>	"application/vnd.hp-jlyt",
			"jnlp"			=>	"application/x-java-jnlp-file",
			"joda"			=>	"application/vnd.joost.joda-archive",
			"jpeg"			=>	"image/jpeg",
			"jpg"			=>	"image/jpeg",
			"jpgv"			=>	"video/jpeg",
			"jpm"			=>	"video/jpm",
			"js"			=>	"application/javascript",
			"json"			=>	"application/json",
			"karbon"		=>	"application/vnd.kde.karbon",
			"kfo"			=>	"application/vnd.kde.kformula",
			"kia"			=>	"application/vnd.kidspiration",
			"kml"			=>	"application/vnd.google-earth.kml+xml",
			"kmz"			=>	"application/vnd.google-earth.kmz",
			"kne"			=>	"application/vnd.kinar",
			"kon"			=>	"application/vnd.kde.kontour",
			"kpr"			=>	"application/vnd.kde.kpresenter",
			"ksp"			=>	"application/vnd.kde.kspread",
			"ktx"			=>	"image/ktx",
			"ktz"			=>	"application/vnd.kahootz",
			"kwd"			=>	"application/vnd.kde.kword",
			"lasxml"		=>	"application/vnd.las.las+xml",
			"latex"			=>	"application/x-latex",
			"lbd"			=>	"application/vnd.llamagraphics.life-balance.desktop",
			"lbe"			=>	"application/vnd.llamagraphics.life-balance.exchange+xml",
			"les"			=>	"application/vnd.hhe.lesson-player",
			"link66"		=>	"application/vnd.route66.link66+xml",
			"lrm"			=>	"application/vnd.ms-lrm",
			"ltf"			=>	"application/vnd.frogans.ltf",
			"lvp"			=>	"audio/vnd.lucent.voice",
			"lwp"			=>	"application/vnd.lotus-wordpro",
			"m21"			=>	"application/mp21",
			"m3u"			=>	"audio/x-mpegurl",
			"m3u8"			=>	"application/vnd.apple.mpegurl",
			"m4v"			=>	"video/x-m4v",
			"ma"			=>	"application/mathematica",
			"mads"			=>	"application/mads+xml",
			"mag"			=>	"application/vnd.ecowin.chart",
			"map"			=>	"application/json",
			"mathml"		=>	"application/mathml+xml",
			"mbk"			=>	"application/vnd.mobius.mbk",
			"mbox"			=>	"application/mbox",
			"mc1"			=>	"application/vnd.medcalcdata",
			"mcd"			=>	"application/vnd.mcd",
			"mcurl"			=>	"text/vnd.curl.mcurl",
			"md"			=>	"text/x-markdown", // http://bit.ly/1Kc5nUB
			"mdb"			=>	"application/x-msaccess",
			"mdi"			=>	"image/vnd.ms-modi",
			"meta4"			=>	"application/metalink4+xml",
			"mets"			=>	"application/mets+xml",
			"mfm"			=>	"application/vnd.mfmp",
			"mgp"			=>	"application/vnd.osgeo.mapguide.package",
			"mgz"			=>	"application/vnd.proteus.magazine",
			"mid"			=>	"audio/midi",
			"mif"			=>	"application/vnd.mif",
			"mj2"			=>	"video/mj2",
			"mlp"			=>	"application/vnd.dolby.mlp",
			"mmd"			=>	"application/vnd.chipnuts.karaoke-mmd",
			"mmf"			=>	"application/vnd.smaf",
			"mmr"			=>	"image/vnd.fujixerox.edmics-mmr",
			"mny"			=>	"application/x-msmoney",
			"mods"			=>	"application/mods+xml",
			"movie"			=>	"video/x-sgi-movie",
			"mp1"			=>	"audio/mpeg",
			"mp2"			=>	"audio/mpeg",
			"mp3"			=>	"audio/mpeg",
			"mp4"			=>	"video/mp4",
			"mp4a"			=>	"audio/mp4",
			"mpc"			=>	"application/vnd.mophun.certificate",
			"mpeg"			=>	"video/mpeg",
			"mpga"			=>	"audio/mpeg",
			"mpkg"			=>	"application/vnd.apple.installer+xml",
			"mpm"			=>	"application/vnd.blueice.multipass",
			"mpn"			=>	"application/vnd.mophun.application",
			"mpp"			=>	"application/vnd.ms-project",
			"mpy"			=>	"application/vnd.ibm.minipay",
			"mqy"			=>	"application/vnd.mobius.mqy",
			"mrc"			=>	"application/marc",
			"mrcx"			=>	"application/marcxml+xml",
			"mscml"			=>	"application/mediaservercontrol+xml",
			"mseq"			=>	"application/vnd.mseq",
			"msf"			=>	"application/vnd.epson.msf",
			"msh"			=>	"model/mesh",
			"msl"			=>	"application/vnd.mobius.msl",
			"msty"			=>	"application/vnd.muvee.style",
			"mts"			=>	"model/vnd.mts",
			"mus"			=>	"application/vnd.musician",
			"musicxml"		=>	"application/vnd.recordare.musicxml+xml",
			"mvb"			=>	"application/x-msmediaview",
			"mwf"			=>	"application/vnd.mfer",
			"mxf"			=>	"application/mxf",
			"mxl"			=>	"application/vnd.recordare.musicxml",
			"mxml"			=>	"application/xv+xml",
			"mxs"			=>	"application/vnd.triscape.mxs",
			"mxu"			=>	"video/vnd.mpegurl",
			"n3"			=>	"text/n3",
			"nbp"			=>	"application/vnd.wolfram.player",
			"nc"			=>	"application/x-netcdf",
			"ncx"			=>	"application/x-dtbncx+xml",
			"n-gage"		=>	"application/vnd.nokia.n-gage.symbian.install",
			"ngdat"			=>	"application/vnd.nokia.n-gage.data",
			"nlu"			=>	"application/vnd.neurolanguage.nlu",
			"nml"			=>	"application/vnd.enliven",
			"nnd"			=>	"application/vnd.noblenet-directory",
			"nns"			=>	"application/vnd.noblenet-sealer",
			"nnw"			=>	"application/vnd.noblenet-web",
			"npx"			=>	"image/vnd.net-fpx",
			"nsf"			=>	"application/vnd.lotus-notes",
			"oa2"			=>	"application/vnd.fujitsu.oasys2",
			"oa3"			=>	"application/vnd.fujitsu.oasys3",
			"oas"			=>	"application/vnd.fujitsu.oasys",
			"obd"			=>	"application/x-msbinder",
			"oda"			=>	"application/oda",
			"odb"			=>	"application/vnd.oasis.opendocument.database",
			"odc"			=>	"application/vnd.oasis.opendocument.chart",
			"odf"			=>	"application/vnd.oasis.opendocument.formula",
			"odft"			=>	"application/vnd.oasis.opendocument.formula-template",
			"odg"			=>	"application/vnd.oasis.opendocument.graphics",
			"odi"			=>	"application/vnd.oasis.opendocument.image",
			"odm"			=>	"application/vnd.oasis.opendocument.text-master",
			"odp"			=>	"application/vnd.oasis.opendocument.presentation",
			"ods"			=>	"application/vnd.oasis.opendocument.spreadsheet",
			"odt"			=>	"application/vnd.oasis.opendocument.text",
			"oga"			=>	"audio/ogg",
			"ogv"			=>	"video/ogg",
			"ogx"			=>	"application/ogg",
			"onetoc"		=>	"application/onenote",
			"opf"			=>	"application/oebps-package+xml",
			"org"			=>	"application/vnd.lotus-organizer",
			"osf"			=>	"application/vnd.yamaha.openscoreformat",
			"osfpvg"		=>	"application/vnd.yamaha.openscoreformat.osfpvg+xml",
			"otc"			=>	"application/vnd.oasis.opendocument.chart-template",
			"otf"			=>	"application/x-font-otf",
			"otg"			=>	"application/vnd.oasis.opendocument.graphics-template",
			"oth"			=>	"application/vnd.oasis.opendocument.text-web",
			"oti"			=>	"application/vnd.oasis.opendocument.image-template",
			"otp"			=>	"application/vnd.oasis.opendocument.presentation-template",
			"ots"			=>	"application/vnd.oasis.opendocument.spreadsheet-template",
			"ott"			=>	"application/vnd.oasis.opendocument.text-template",
			"oxt"			=>	"application/vnd.openofficeorg.extension",
			"p"			=>	"text/x-pascal",
			"p10"			=>	"application/pkcs10",
			"p12"			=>	"application/x-pkcs12",
			"p7b"			=>	"application/x-pkcs7-certificates",
			"p7m"			=>	"application/pkcs7-mime",
			"p7r"			=>	"application/x-pkcs7-certreqresp",
			"p7s"			=>	"application/pkcs7-signature",
			"p8"			=>	"application/pkcs8",
			"par"			=>	"text/plain-bas",
			"paw"			=>	"application/vnd.pawaafile",
			"pbd"			=>	"application/vnd.powerbuilder6",
			"pbm"			=>	"image/x-portable-bitmap",
			"pcf"			=>	"application/x-font-pcf",
			"pcl"			=>	"application/vnd.hp-pcl",
			"pclxl"			=>	"application/vnd.hp-pclxl",
			"pcurl"			=>	"application/vnd.curl.pcurl",
			"pcx"			=>	"image/x-pcx",
			"pdb"			=>	"application/vnd.palm",
			"pdf"			=>	"application/pdf",
			"pfa"			=>	"application/x-font-type1",
			"pfr"			=>	"application/font-tdpfr",
			"pgm"			=>	"image/x-portable-graymap",
			"pgn"			=>	"application/x-chess-pgn",
			"pgp"			=>	"application/pgp-signature",
			"pic"			=>	"image/x-pict",
			"pki"			=>	"application/pkixcmp",
			"pkipath"		=>	"application/pkix-pkipath",
			"plb"			=>	"application/vnd.3gpp.pic-bw-large",
			"plc"			=>	"application/vnd.mobius.plc",
			"plf"			=>	"application/vnd.pocketlearn",
			"pls"			=>	"application/pls+xml",
			"pml"			=>	"application/vnd.ctc-posml",
			"png"			=>	"image/png",
			"pnm"			=>	"image/x-portable-anymap",
			"portpkg"		=>	"application/vnd.macports.portpkg",
			"potm"			=>	"application/vnd.ms-powerpoint.template.macroenabled.12",
			"potx"			=>	"application/vnd.openxmlformats-officedocument.presentationml.template",
			"ppam"			=>	"application/vnd.ms-powerpoint.addin.macroenabled.12",
			"ppd"			=>	"application/vnd.cups-ppd",
			"ppm"			=>	"image/x-portable-pixmap",
			"ppsm"			=>	"application/vnd.ms-powerpoint.slideshow.macroenabled.12",
			"ppsx"			=>	"application/vnd.openxmlformats-officedocument.presentationml.slideshow",
			"ppt"			=>	"application/vnd.ms-powerpoint",
			"pptm"			=>	"application/vnd.ms-powerpoint.presentation.macroenabled.12",
			"pptx"			=>	"application/vnd.openxmlformats-officedocument.presentationml.presentation",
			"prc"			=>	"application/x-mobipocket-ebook",
			"pre"			=>	"application/vnd.lotus-freelance",
			"prf"			=>	"application/pics-rules",
			"psb"			=>	"application/vnd.3gpp.pic-bw-small",
			"psd"			=>	"image/vnd.adobe.photoshop",
			"psf"			=>	"application/x-font-linux-psf",
			"pskcxml"		=>	"application/pskc+xml",
			"ptid"			=>	"application/vnd.pvi.ptid1",
			"pub"			=>	"application/x-mspublisher",
			"pvb"			=>	"application/vnd.3gpp.pic-bw-var",
			"pwn"			=>	"application/vnd.3m.post-it-notes",
			"pya"			=>	"audio/vnd.ms-playready.media.pya",
			"pyv"			=>	"video/vnd.ms-playready.media.pyv",
			"qam"			=>	"application/vnd.epson.quickanime",
			"qbo"			=>	"application/vnd.intu.qbo",
			"qfx"			=>	"application/vnd.intu.qfx",
			"qps"			=>	"application/vnd.publishare-delta-tree",
			"qt"			=>	"video/quicktime",
			"qxd"			=>	"application/vnd.quark.quarkxpress",
			"ram"			=>	"audio/x-pn-realaudio",
			"rar"			=>	"application/x-rar-compressed",
			"ras"			=>	"image/x-cmu-raster",
			"rcprofile"		=>	"application/vnd.ipunplugged.rcprofile",
			"rdf"			=>	"application/rdf+xml",
			"rdz"			=>	"application/vnd.data-vision.rdz",
			"rep"			=>	"application/vnd.businessobjects",
			"res"			=>	"application/x-dtbresource+xml",
			"rgb"			=>	"image/x-rgb",
			"rif"			=>	"application/reginfo+xml",
			"rip"			=>	"audio/vnd.rip",
			"rl"			=>	"application/resource-lists+xml",
			"rlc"			=>	"image/vnd.fujixerox.edmics-rlc",
			"rld"			=>	"application/resource-lists-diff+xml",
			"rm"			=>	"application/vnd.rn-realmedia",
			"rmp"			=>	"audio/x-pn-realaudio-plugin",
			"rms"			=>	"application/vnd.jcp.javame.midlet-rms",
			"rnc"			=>	"application/relax-ng-compact-syntax",
			"rp9"			=>	"application/vnd.cloanto.rp9",
			"rpss"			=>	"application/vnd.nokia.radio-presets",
			"rpst"			=>	"application/vnd.nokia.radio-preset",
			"rq"			=>	"application/sparql-query",
			"rs"			=>	"application/rls-services+xml",
			"rsd"			=>	"application/rsd+xml",
			"rss"			=>	"application/rss+xml",
			"rtf"			=>	"application/rtf",
			"rtx"			=>	"text/richtext",
			"s"			=>	"text/x-asm",
			"saf"			=>	"application/vnd.yamaha.smaf-audio",
			"sbml"			=>	"application/sbml+xml",
			"sc"			=>	"application/vnd.ibm.secure-container",
			"scd"			=>	"application/x-msschedule",
			"scm"			=>	"application/vnd.lotus-screencam",
			"scq"			=>	"application/scvp-cv-request",
			"scs"			=>	"application/scvp-cv-response",
			"scurl"			=>	"text/vnd.curl.scurl",
			"sda"			=>	"application/vnd.stardivision.draw",
			"sdc"			=>	"application/vnd.stardivision.calc",
			"sdd"			=>	"application/vnd.stardivision.impress",
			"sdkm"			=>	"application/vnd.solent.sdkm+xml",
			"sdp"			=>	"application/sdp",
			"sdw"			=>	"application/vnd.stardivision.writer",
			"see"			=>	"application/vnd.seemail",
			"seed"			=>	"application/vnd.fdsn.seed",
			"sema"			=>	"application/vnd.sema",
			"semd"			=>	"application/vnd.semd",
			"semf"			=>	"application/vnd.semf",
			"ser"			=>	"application/java-serialized-object",
			"setpay"		=>	"application/set-payment-initiation",
			"setreg"		=>	"application/set-registration-initiation",
			"sfd-hdstx"		=>	"application/vnd.hydrostatix.sof-data",
			"sfs"			=>	"application/vnd.spotfire.sfs",
			"sgl"			=>	"application/vnd.stardivision.writer-global",
			"sgml"			=>	"text/sgml",
			"sh"			=>	"application/x-sh",
			"shar"			=>	"application/x-shar",
			"shf"			=>	"application/shf+xml",
			"sis"			=>	"application/vnd.symbian.install",
			"sit"			=>	"application/x-stuffit",
			"sitx"			=>	"application/x-stuffitx",
			"skp"			=>	"application/vnd.koan",
			"sldm"			=>	"application/vnd.ms-powerpoint.slide.macroenabled.12",
			"sldx"			=>	"application/vnd.openxmlformats-officedocument.presentationml.slide",
			"slt"			=>	"application/vnd.epson.salt",
			"sm"			=>	"application/vnd.stepmania.stepchart",
			"smf"			=>	"application/vnd.stardivision.math",
			"smi"			=>	"application/smil+xml",
			"snf"			=>	"application/x-font-snf",
			"spf"			=>	"application/vnd.yamaha.smaf-phrase",
			"spl"			=>	"application/x-futuresplash",
			"spot"			=>	"text/vnd.in3d.spot",
			"spp"			=>	"application/scvp-vp-response",
			"spq"			=>	"application/scvp-vp-request",
			"src"			=>	"application/x-wais-source",
			"sru"			=>	"application/sru+xml",
			"srx"			=>	"application/sparql-results+xml",
			"sse"			=>	"application/vnd.kodak-descriptor",
			"ssf"			=>	"application/vnd.epson.ssf",
			"ssml"			=>	"application/ssml+xml",
			"st"			=>	"application/vnd.sailingtracker.track",
			"stc"			=>	"application/vnd.sun.xml.calc.template",
			"std"			=>	"application/vnd.sun.xml.draw.template",
			"stf"			=>	"application/vnd.wt.stf",
			"sti"			=>	"application/vnd.sun.xml.impress.template",
			"stk"			=>	"application/hyperstudio",
			"stl"			=>	"application/vnd.ms-pki.stl",
			"str"			=>	"application/vnd.pg.format",
			"stw"			=>	"application/vnd.sun.xml.writer.template",
			"sub"			=>	"image/vnd.dvb.subtitle",
			"sus"			=>	"application/vnd.sus-calendar",
			"sv4cpio"		=>	"application/x-sv4cpio",
			"sv4crc"		=>	"application/x-sv4crc",
			"svc"			=>	"application/vnd.dvb.service",
			"svd"			=>	"application/vnd.svd",
			"svg"			=>	"image/svg+xml",
			"swf"			=>	"application/x-shockwave-flash",
			"swi"			=>	"application/vnd.aristanetworks.swi",
			"sxc"			=>	"application/vnd.sun.xml.calc",
			"sxd"			=>	"application/vnd.sun.xml.draw",
			"sxg"			=>	"application/vnd.sun.xml.writer.global",
			"sxi"			=>	"application/vnd.sun.xml.impress",
			"sxm"			=>	"application/vnd.sun.xml.math",
			"sxw"			=>	"application/vnd.sun.xml.writer",
			"t"			=>	"text/troff",
			"tao"			=>	"application/vnd.tao.intent-module-archive",
			"tar"			=>	"application/x-tar",
			"tcap"			=>	"application/vnd.3gpp2.tcap",
			"tcl"			=>	"application/x-tcl",
			"teacher"		=>	"application/vnd.smart.teacher",
			"tei"			=>	"application/tei+xml",
			"tex"			=>	"application/x-tex",
			"texinfo"		=>	"application/x-texinfo",
			"tfi"			=>	"application/thraud+xml",
			"tfm"			=>	"application/x-tex-tfm",
			"thmx"			=>	"application/vnd.ms-officetheme",
			"tiff"			=>	"image/tiff",
			"tmo"			=>	"application/vnd.tmobile-livetv",
			"torrent"		=>	"application/x-bittorrent",
			"tpl"			=>	"application/vnd.groove-tool-template",
			"tpt"			=>	"application/vnd.trid.tpt",
			"tra"			=>	"application/vnd.trueapp",
			"trm"			=>	"application/x-msterminal",
			"tsd"			=>	"application/timestamped-data",
			"tsv"			=>	"text/tab-separated-values",
			"ttf"			=>	"application/x-font-ttf",
			"ttl"			=>	"text/turtle",
			"twd"			=>	"application/vnd.simtech-mindmapper",
			"txd"			=>	"application/vnd.genomatix.tuxedo",
			"txf"			=>	"application/vnd.mobius.txf",
			"txt"			=>	"text/plain",
			"ufd"			=>	"application/vnd.ufdl",
			"umj"			=>	"application/vnd.umajin",
			"unityweb"		=>	"application/vnd.unity",
			"uoml"			=>	"application/vnd.uoml+xml",
			"uri"			=>	"text/uri-list",
			"ustar"			=>	"application/x-ustar",
			"utz"			=>	"application/vnd.uiq.theme",
			"uu"			=>	"text/x-uuencode",
			"uva"			=>	"audio/vnd.dece.audio",
			"uvh"			=>	"video/vnd.dece.hd",
			"uvi"			=>	"image/vnd.dece.graphic",
			"uvm"			=>	"video/vnd.dece.mobile",
			"uvp"			=>	"video/vnd.dece.pd",
			"uvs"			=>	"video/vnd.dece.sd",
			"uvu"			=>	"video/vnd.uvvu.mp4",
			"uvv"			=>	"video/vnd.dece.video",
			"vcd"			=>	"application/x-cdlink",
			"vcf"			=>	"text/x-vcard",
			"vcg"			=>	"application/vnd.groove-vcard",
			"vcs"			=>	"text/x-vcalendar",
			"vcx"			=>	"application/vnd.vcx",
			"vis"			=>	"application/vnd.visionary",
			"viv"			=>	"video/vnd.vivo",
			"vsd"			=>	"application/vnd.visio",
			"vsf"			=>	"application/vnd.vsf",
			"vtu"			=>	"model/vnd.vtu",
			"vxml"			=>	"application/voicexml+xml",
			"wad"			=>	"application/x-doom",
			"wav"			=>	"audio/x-wav",
			"wax"			=>	"audio/x-ms-wax",
			"wbmp"			=>	"image/vnd.wap.wbmp",
			"wbs"			=>	"application/vnd.criticaltools.wbs+xml",
			"wbxml"			=>	"application/vnd.wap.wbxml",
			"weba"			=>	"audio/webm",
			"webm"			=>	"video/webm",
			"webp"			=>	"image/webp",
			"wg"			=>	"application/vnd.pmi.widget",
			"wgt"			=>	"application/widget",
			"wm"			=>	"video/x-ms-wm",
			"wma"			=>	"audio/x-ms-wma",
			"wmd"			=>	"application/x-ms-wmd",
			"wmf"			=>	"application/x-msmetafile",
			"wml"			=>	"text/vnd.wap.wml",
			"wmlc"			=>	"application/vnd.wap.wmlc",
			"wmls"			=>	"text/vnd.wap.wmlscript",
			"wmlsc"			=>	"application/vnd.wap.wmlscriptc",
			"wmv"			=>	"video/x-ms-wmv",
			"wmx"			=>	"video/x-ms-wmx",
			"wmz"			=>	"application/x-ms-wmz",
			"woff"			=>	"application/x-font-woff",
			"woff2"			=>	"application/font-woff2",
			"wpd"			=>	"application/vnd.wordperfect",
			"wpl"			=>	"application/vnd.ms-wpl",
			"wps"			=>	"application/vnd.ms-works",
			"wqd"			=>	"application/vnd.wqd",
			"wri"			=>	"application/x-mswrite",
			"wrl"			=>	"model/vrml",
			"wsdl"			=>	"application/wsdl+xml",
			"wspolicy"		=>	"application/wspolicy+xml",
			"wtb"			=>	"application/vnd.webturbo",
			"wvx"			=>	"video/x-ms-wvx",
			"x3d"			=>	"application/vnd.hzn-3d-crossword",
			"xap"			=>	"application/x-silverlight-app",
			"xar"			=>	"application/vnd.xara",
			"xbap"			=>	"application/x-ms-xbap",
			"xbd"			=>	"application/vnd.fujixerox.docuworks.binder",
			"xbm"			=>	"image/x-xbitmap",
			"xdf"			=>	"application/xcap-diff+xml",
			"xdm"			=>	"application/vnd.syncml.dm+xml",
			"xdp"			=>	"application/vnd.adobe.xdp+xml",
			"xdssc"			=>	"application/dssc+xml",
			"xdw"			=>	"application/vnd.fujixerox.docuworks",
			"xenc"			=>	"application/xenc+xml",
			"xer"			=>	"application/patch-ops-error+xml",
			"xfdf"			=>	"application/vnd.adobe.xfdf",
			"xfdl"			=>	"application/vnd.xfdl",
			"xhtml"			=>	"application/xhtml+xml",
			"xif"			=>	"image/vnd.xiff",
			"xlam"			=>	"application/vnd.ms-excel.addin.macroenabled.12",
			"xls"			=>	"application/vnd.ms-excel",
			"xlsb"			=>	"application/vnd.ms-excel.sheet.binary.macroenabled.12",
			"xlsm"			=>	"application/vnd.ms-excel.sheet.macroenabled.12",
			"xlsx"			=>	"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
			"xltm"			=>	"application/vnd.ms-excel.template.macroenabled.12",
			"xltx"			=>	"application/vnd.openxmlformats-officedocument.spreadsheetml.template",
			"xml"			=>	"application/xml",
			"xo"			=>	"application/vnd.olpc-sugar",
			"xop"			=>	"application/xop+xml",
			"xpi"			=>	"application/x-xpinstall",
			"xpm"			=>	"image/x-xpixmap",
			"xpr"			=>	"application/vnd.is-xpr",
			"xps"			=>	"application/vnd.ms-xpsdocument",
			"xpw"			=>	"application/vnd.intercon.formnet",
			"xslt"			=>	"application/xslt+xml",
			"xsm"			=>	"application/vnd.syncml+xml",
			"xspf"			=>	"application/xspf+xml",
			"xul"			=>	"application/vnd.mozilla.xul+xml",
			"xwd"			=>	"image/x-xwindowdump",
			"xyz"			=>	"chemical/x-xyz",
			"yaml"			=>	"text/yaml",
			"yang"			=>	"application/yang",
			"yin"			=>	"application/yin+xml",
			"zaz"			=>	"application/vnd.zzazz.deck+xml",
			"zip"			=>	"application/zip",
			"zir"			=>	"application/vnd.zul",
			"zmm"			=>	"application/vnd.handheld-entertainment+xml"
		);
		$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		if (isset($mime_type[$extension])) {
			return $mime_type[$extension];
		} else {
			return 'inode/x-empty';
		}
	} 

	public function tpopen(){
		$file = '/var/www/synpat/backyard/public/upload/12345.mp3';
		unlink($file);
		die;
		$fs = fopen($file,'w+');
		if( $fs ) {
			echo 'The file is open';
			fclose( $fs );
		  }else{
			echo 'The file could not be open.';
		  }
		  die;
	}
	
	public function fileInsert(){
		$data = array("error"=>1);
		if(isset($_POST) && count($_POST)>0){	
			$sip = 0;
			$this->load->model('lead_model');		
			$getLeadData = $this->lead_model->getLeadData($this->input->post('d'));
			if(count($getLeadData)>0 && $getLeadData->folder_id!=""){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$parent = new Google_Service_Drive_ParentReference();
				if($this->input->post('f')=="" || $this->input->post('f')=="undefined"){
					$parent->setId($getLeadData->folder_id);
				} else if($this->input->post('f')!=""){
					$parent->setId($this->input->post('f'));
				} else{
					$parent->setId($getLeadData->folder_id);
				}
				$change=0;
				if(isset($_POST['change']) && $_POST['change']==1){
					$change = $_POST['change'];
				}
				$fileName = stripslashes($this->input->post('doc_url'));
				if(!empty($fileName) && $change==0){
					$fileName = str_replace($this->config->base_url(),$_SERVER['DOCUMENT_ROOT'].'/',$fileName);
					$fileName = str_replace("http://backyard.synpat.com/",$_SERVER['DOCUMENT_ROOT'].'/',$fileName);
					
				}
				if(stripos($fileName,'s3.amazonaws.com')!==false){
					require(APPPATH.'third_party/vendor/autoload.php');
					$bucket = $this->config->item('aws_buket_name');
					try{
						$this->config->load('config');
						$keyName = str_replace("https://".$bucket.".s3.amazonaws.com/",'',$fileName);						
						$keyName = urldecode($keyName);
						$client = Aws\S3\S3Client::factory(array(
							'credentials' => array(
								'key'    => $this->config->item('aws_key_id'),
								'secret' => $this->config->item('aws_secret_key'),
							)));
						$splitDir = explode('/',$keyName);
						$actualFileName = array_pop($splitDir);
						$actualFileName = urldecode($actualFileName);
						$fileName = $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$actualFileName;
						
						$fileName = urldecode($fileName);
						$file = $client->getObject(array(
								  'Bucket' => $bucket,
								  'Key'    => $keyName,
								  'SaveAs' => $fileName
								));
						if($file['Body']->getUri()!=""){
							$sip = 1;
						}
					}catch(Exception $e){
						
					}
				}
				if(file_exists($fileName)){					
					$mimeType = $this->mime_type($fileName);
					$convert=true;
					if($mimeType=="inode/x-empty" ||  $mimeType=="application/pdf" || $mimeType=="image/jpeg" || $mimeType=="image/png" || $mimeType=="image/gif" || $mimeType=="image/bmp" || $mimeType=="image/bmp"){
						$convert=false;
					}
					if($mimeType=="inode/x-empty"){
						 $mimeType="application/pdf";
					}
					$docName = stripslashes($this->input->post('file_name'));
					$docName = urldecode($docName);
					$getUploadFileData = $service->insertFile($docName,$mimeType,$fileName,$parent,$convert);
					if($getUploadFileData){
						if((int)$sip==1){
							unlink($fileName);
						}
						$service->setAdditionalPermissions( $getUploadFileData->id, $this->session->userdata['email'],"reader","anyone",array('emailMessage'=>'File has been share with you .','sendNotificationEmails'=>true));
						$data['error'] = 0;
						$data['box'] = $getUploadFileData;
					}
				} else {
					/*File not exist*/					
					$data['error'] = 1;
				}
			}			
		}
		echo json_encode($data);
		die;
	}
	
	function getCallData(){
		$data= array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->findCallData($this->input->post('activity'),$this->input->post('t'));
		}
		echo json_encode($data);
		die;
	}
	
	function callActivityLog($leadID=0,$personID=0,$companyID=0){
		$data = array();
		$_ul  = "";
		$this->layout->layout='log';
		if((int)$leadID>0 && (int)$personID&& (int)$companyID>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->findCallActivityLog($leadID,$personID,$companyID);
			if(count($data)>0){
				foreach($data as $detail){
					$_icon = "";
					switch((int)($detail->type)){
						case 1:
							$_icon = "<i class='glyph-icon icon-phone' title='Contacts' style='color:#2196f3' ></i>";
						break;
						case 2:
							$_icon = "<i class='glyph-icon icon-phone' title='Contacts' style='color:#d1c8c8' ></i> ";
						break;
						case 37:
						case 207:
							$_icon="<img src='https://storage.googleapis.com/static.synpat.com/backyard/images/Conference_Call-512.png' style='width:16px;height:auto !important; float:none;display:inline-block;margin:0'/>";
						break;
						case 6:
							/*Received*/
							$_icon = "<i class='glyph-icon icon-envelope' title='Contacts' style='color:#2196f3' ></i> ";
						break;
						case 3:
							$_icon = "<i class='glyph-icon icon-envelope' title='Contacts' style='color:#d1c8c8' ></i> ";
							/*Send*/
						break;
					}
					if((int)$detail->type==3 || (int) $detail->type==6){
						if($detail->email_id>0){
							/*Change iframe to show data directly.*/
							$_ul .='<li class="pad10L">';
								/*Email Details*/
								if(count($detail->email_details)>0){
									$findThreadData = $detail->email_details;
									$emailH = array();
									$emailH['thread_detail'] = $findThreadData;
									$emailH['ID'] = $detail->email_id;
									$emailH['type'] = 2;
									if((int)$findThreadData[0]->account_type==2){
										$this->layout->render('user/small_imap_email_render',$emailH);
									} else {
										$this->layout->render('user/small_email_render',$emailH);
									}
									$emailHtml = $this->layout->data['contents_for_layout'];
									$emailHtml = $this->closetags($emailHtml);
									$_ul .=$emailHtml;
								}
							$_ul .='</li>';
						} else {
							$_ul .='<li><div class="comment_content"><span>'.$_icon.' '.date('M D, Y',strtotime($detail->activity_date)).'</span><p>'.$detail->note.'</p></div></li>';
						}				
					} else {
						$_ul .='<li><div class="comment_content"><span>'.$_icon.' '. date('M D, Y',strtotime($detail->activity_date)).'</span><p>'.$detail->note.'</p></div></li>';
					}
				}
			}
		}
		$data['ul'] = $_ul;	
		$this->layout->data['contents_for_layout'] = "";
		$this->layout->title_for_layout = 'Log Acitivity';
		$this->layout->render('leads/callActivityLog',$data);
	}
	
	function closetags($html) {
		preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
		$openedtags = $result[1];
		preg_match_all('#</([a-z]+)>#iU', $html, $result);
		$closedtags = $result[1];
		$len_opened = count($openedtags);
		if (count($closedtags) == $len_opened) {
			return $html;
		}
		$openedtags = array_reverse($openedtags);
		for ($i=0; $i < $len_opened; $i++) {
			if (!in_array($openedtags[$i], $closedtags)) {
				$html .= '</'.$openedtags[$i].'>';
			} else {
				unset($closedtags[array_search($openedtags[$i], $closedtags)]);
			}
		}
		return $html;
	}
	
	function activityLog($activityLog){
		if(isset($activityLog['task_id'])){
			unset($activityLog['task_id']);
		}
		if(isset($activityLog['next_call_date'])){
			unset($activityLog['next_call_date']);
		}
		$this->lead_model->insertActivityLog($activityLog);		
	}
	
	function callinout(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$call = $this->input->post('call');
			if(count($call)>0 && isset($call['lead_id']) && isset($call['company_id']) && isset($call['person']) && (int) $call['lead_id']>0 && (int) $call['company_id']>0  && (int) $call['person']>0){
				$call['contact_id'] = (int)$call['person'];		
				/*$call['activity_date'] = date('Y-m-d H:i:s',strtotime($call['execution_date'].' '.$call['time_start'].':'.$call['time_end'].':00'));*/
				$call['activity_date'] = date('Y-m-d H:i:s');
				$call['note'] = $call['purpose'].' - '. $call['note'];
				$call['user_id'] = $call['from_user_id'];
				$call['subject'] = "";
				$activity = $call['main_activity'];
				unset($call['person']);
				unset($call['execution_date']);
				unset($call['time_start']);
				unset($call['time_end']);
				unset($call['participant']);
				unset($call['purpose']);
				unset($call['main_activity']);
				unset($call['from_user_id']);				
				$this->load->model('lead_model');
				$this->load->model('user_model');
				$this->activityLog($call);
				$findPersonLastActivty = $this->lead_model->findPersonLastActivty($call['lead_id'],$call['company_id'],$call['contact_id'],$activity);				
				if($activity=="2"){
					if($call['id']>0){
						$data = $this->lead_model->updateAcquistionActivity($call['id'],$call);
					} else {
						if(count($findPersonLastActivty)==0){
							$data = $this->lead_model->insertAcquistionActivity($call);
						} else {
							unset($call['id']);
							$data = $this->lead_model->updateAcquistionActivity($findPersonLastActivty->id,$call);
						}
						/**/
					}		
				} else {
					if($call['id']>0){
						$data = $this->lead_model->updateSalesActivity($call['id'],$call);
					} else {
						if(count($findPersonLastActivty)==0){
							$data = $this->lead_model->insetSalesActivity($call);
						} else {
							unset($call['id']);
							$data = $this->lead_model->updateSalesActivity($findPersonLastActivty->id,$call);
						}
					}					
				}
				$message="";
				if($call['type']==1){
					$message = "Call In";
				} else if($call['type']==2){
					$message = "Call Out";
 				} else if($call['type']==37){
					$message = "Conference Call";
				}
				if($data>0){
					$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$call['lead_id'],'message'=>$message,'create_date'=>$call['activity_date']));
				}
			}			
		}
		echo $data;
		die; 
	}
	
	function sales_acititity_data(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$activity = $this->input->post('activity');
			if(count($activity)>0 && isset($activity['lead_id']) && isset($activity['c_id']) && isset($activity['person']) && (int) $activity['lead_id']>0 && (int) $activity['c_id']>0  && (int) $activity['person']>0){
				$activity['company_id'] = $activity['c_id'];
				$activity['contact_id'] = (int)$activity['person'];				
				$activity['user_id'] = $this->session->userdata['id'];
				$activity['activity_date'] = date('Y-m-d H:i:s');
				unset($activity['c_id']);
				unset($activity['person']);
				$this->load->model('lead_model');
				$this->load->model('user_model');
				if((int)$_POST['name']['main_type']==2){
					$data = $this->lead_model->insertAcquistionActivity($activity);
				} else {
					$data = $this->lead_model->insetSalesActivity($activity);
				}
				$this->activityLog($activity);
				if($data>0){
					$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$activity['lead_id'],'message'=>'Activity in sale','create_date'=>$activity['activity_date']));
				}
			}			
		}
		echo $data;
		die;
	}
}

/* End of file leads.php */
/* Location: ./application/controllers/leads.php */