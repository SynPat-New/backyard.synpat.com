<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Customers extends CI_Controller {
	public $serverPathDocketServicesAssets = '/var/www/synpat/synpat/docket-services/assets/';
	public function __construct(){
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('acquisition_model');
		$this->load->model('opportunity_model');
		$this->load->model('lead_model');
		$this->load->model('general_model');
		$this->load->model('client_model');
		$this->load->model('user_model');
		$this->layout->auto_render=false;	
		$this->layout->layout='default';
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));		
	}
	
	public function add_contact(){
		$message = "Please try after sometime.";
		if(isset($_POST) && count($_POST)>0){
			$getData = $this->input->post();
			if(isset($getData['invitee']['form_id']) && $getData['invitee']['form_id']==1 && isset($getData['invitee']['form_fields_id']) && isset($getData['invitee']['form_email'])){
				$checkUserData = $this->lead_model->checkUserDataWithIDAndEmail($getData['invitee']['form_fields_id'],$getData['invitee']['form_email']);
				if(count($checkUserData)>0){
					if($getData['invitee']['email']==""){
						$getData['invitee']['email'] = $getData['invitee']['form_email'];
					}
					$recordID = $getData['invitee']['form_fields_id'];
					unset($getData['invitee']['form_id']);
					unset($getData['invitee']['form_fields_id']);
					unset($getData['invitee']['form_email']);
					$saveData = $this->client_model->update($recordID,$getData['invitee']);	
					$saveData = $recordID;
					if($saveData>0){
						$message = "Data successfully posted.";
					}
				}
			}				
		}
		echo $message;
		die;
	}
	
	public function add_company(){
		$message = "Please try after sometime.";
		$postData = $this->input->post();
		if(isset($postData['source_data']) && !empty($postData['source_data'])){
			try{
				$sourceData = json_decode($postData['source_data']);
				$getData = json_decode($postData['data']);
				echo "Count Source Data:".count($sourceData);
				echo "Count Get Data:".count($getData);
				echo "<pre>";
				print_r($sourceData);
				print_r($getData);
			}catch(Exception $e){
				
			}
		}
		/**/
		
		
		echo "<pre>";
		print_r($_POST['team']);
		die;
		if(isset($_POST) && count($_POST)>0){
			$getData = $this->input->post();
			if(isset($getData['company']['form_id']) && $getData['company']['form_id']==2 && isset($getData['company']['form_fields_id']) && isset($getData['company']['form_email'])){
				$checkUserData = $this->lead_model->checkUserDataWithIDAndEmail($getData['company']['form_fields_id'],$getData['company']['form_email']);
				if(count($checkUserData)>0){
					$getCompanyDetail = $this->customer_model->getCompanyDataByID((int)$checkUserData->company_id);
					if(count($getCompanyDetail)>0){
						unset($getData['company']['form_id']);
						unset($getData['company']['form_fields_id']);
						unset($getData['company']['form_email']);
						$this->customer_model->updateCompanyData($getCompanyDetail->id,$getData['company']);
						if($checkUserData->company_id>0){
							$message = "Data successfully posted.";
							$this->opportunity_model->deleteCustomerTechnologyPreference($checkUserData->company_id,0);
							if(isset($getData['preferences']) && is_array($getData['preferences']['technology']) && count($getData['preferences']['technology'])>0){
								foreach($getData['preferences']['technology'] as $tech){
									$this->opportunity_model->insertCustomerTechnologyPreference(array("company_id"=>$checkUserData->company_id,"preference_id"=>$tech,"type"=>0));
								}
							}
							/*Sub Technology*/
							$this->opportunity_model->deleteCustomerTechnologyPreference($checkUserData->company_id,1);
							if(isset($getData['preferences']) && isset($getData['preferences']['subtechnology']) && is_array($getData['preferences']['subtechnology']) && count($getData['preferences']['subtechnology'])>0){
								foreach($getData['preferences']['subtechnology'] as $tech){
									$this->opportunity_model->insertCustomerTechnologyPreference(array("company_id"=>$checkUserData->company_id,"preference_id"=>$tech,"type"=>1));
								}
							}
							/*SubSub Technology*/
							$this->opportunity_model->deleteCustomerTechnologyPreference($checkUserData->company_id,2);
							if(isset($getData['sub']) && isset($getData['sub']['technology']) && is_array($getData['sub']['technology']) && count($getData['sub']['technology'])>0){
								foreach($getData['sub']['technology'] as $tech){
									$this->opportunity_model->insertCustomerTechnologyPreference(array("company_id"=>$checkUserData->company_id,"preference_id"=>$tech,"type"=>2));
								}
							}
						}
					}
				}
			}
		}
		echo $message;
		die;
	}
	
	function invitee_form_data($contactForm=0,$userID=0){
		$data = array();
		if($contactForm>0 && ($contactForm==1 || $contactForm==2)){
			$userEmailAddress="";
			if($this->input->get('email')!=''){
				$userEmailAddress = $this->input->get('email');
			}
			if($userID>0 && $userEmailAddress!="" && strpos($userEmailAddress,"@")!==false){
				if($contactForm==2){
					$checkUserCompanyData = $this->lead_model->checkUserDataWithIDAndEmail($userID,$userEmailAddress);
					if(count($checkUserCompanyData)>0){
						$data['company'] = $this->customer_model->getCompanyDataByID($checkUserCompanyData->company_id);
						$data['companyID'] = $checkUserCompanyData->company_id;
						$data['invitee_form_id'] = $contactForm;
						$data['invitee_form_fields_id'] = $userID;
						$data['invitee_form_email'] = $userEmailAddress;
						$data['allSectors'] = $this->opportunity_model->getTechnologies();	
						if($checkUserCompanyData->company_id>0){
							$data['findMyPreference'] = $this->opportunity_model->findMyPreferenceTechnologies($checkUserCompanyData->company_id);
						}
					}
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function invitee_form($contactForm=0,$userID=0){
		if($contactForm>0 && ($contactForm==1 || $contactForm==2)){
			$userEmailAddress="";
			if($this->input->get('email')!=''){
				$userEmailAddress = $this->input->get('email');
			}
			if($userID>0 && $userEmailAddress!="" && strpos($userEmailAddress,"@")!==false){
				if($contactForm==1){
					$checkUserData = $this->lead_model->checkUserDataWithIDAndEmail($userID,$userEmailAddress);
					if(count($checkUserData)>0){
						$data['contact'] = $checkUserData;
						$data['invitee_form_id'] = $contactForm;
						$data['invitee_form_fields_id'] = $userID;
						$data['invitee_form_email'] = $userEmailAddress;
						$this->layout->layout='outsource';
						$this->layout->title_for_layout = 'Backyard Add Contact';
						$this->layout->render('customer/add_contact',$data);
					} else {
						echo "";
						die;
					}
				} else if($contactForm==2){
					$checkUserCompanyData = $this->lead_model->checkUserDataWithIDAndEmail($userID,$userEmailAddress);
					if(count($checkUserCompanyData)>0){
						$data['company'] = $this->customer_model->getCompanyDataByID($checkUserCompanyData->company_id);
						$data['companyID'] = $checkUserCompanyData->company_id;
						$data['invitee_form_id'] = $contactForm;
						$data['invitee_form_fields_id'] = $userID;
						$data['invitee_form_email'] = $userEmailAddress;
						$this->layout->layout='outsource';
						$this->layout->title_for_layout = 'Backyard Add Contact';
						$this->layout->render('customer/add_company',$data);
					} else {
						echo "";
						die;
					}
				}
				
			} else {
				echo "";
				die;
			}
		} else {
			echo "";
			die;
		}
	}
	
	public function add_sector_category_subcategory(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$data = $this->input->post();
			$this->load->model('general_model');
			$type = $this->input->post('t');
			$name = $this->input->post('n');
			switch($type){
				case 'sector':
					$data['id'] = $this->general_model->insertSector(array('name'=>$name));					
				break;
				case 'category':
				case 'technology':
					$sector = $this->input->post('p');
					$data['id'] = $this->general_model->insertCategory(array('name'=>$name,'parent'=>0));
					$findSector = $this->general_model->findSector($sector);
					if(count($findSector)>0 && $data['id']>0){
						$this->general_model->insertSectorDepartment(array('sector_id'=>$findSector->id,'category_id'=>$data['id']));
					}
				break;
				case 'sub-category':
				case 'sub-technology':
				case 'subsub-technology':
					$p = $this->input->post('p');
					$typee = 1;
					if($type=="subsub-technology"){
						$typee = 2;
					}
					$data['id'] = $this->general_model->insertCategory(array('name'=>$name,'parent'=>$p,'type'=>$typee));
				break;
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function delete_all_types(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$id = $this->input->post('id');
			$sourceType = $this->input->post('t');
			$name = $this->input->post('name');
			$this->load->model('general_model');
			$this->load->model('customer_model');
			switch($sourceType){
				case 'sector':
					$data = $this->general_model->delete_sector($id,array('name'=>$name));
				break;
				case 'category':
				case 'subcategory':
				case 'technology':
				case 'sub-technology':
				case 'subsub-technology':
					$data = $this->general_model->delete_category($id);
					$checkOldCategoryHasChild = $this->customer_model->categoryListWithMoreThanOne($id);
					if(count($checkOldCategoryHasChild)>0){
						$this->general_model->deleteAllChildCategory($id);
					}
					
				break;
			}
		}
		echo $data;
		die;
	}
	
	public function update_all_types(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$id = $this->input->post('id');
			$sourceType = $this->input->post('t');
			$name = $this->input->post('name');
			$this->load->model('general_model');
			switch($sourceType){
				case 'sector':
					$data = $this->general_model->updateSector($id,array('name'=>$name));
				break;
				case 'technology':
				case 'sub-technology':
				case 'subsub-technology':
				case 'category':
				case 'subcategory':
					$data = $this->general_model->updateCategory($id,array('name'=>$name));
				break;
				
			}
		}
		echo $data;
		die;
	}
	
	public function patent_illustration_json($patentNumber = null){
		$this->load->model('lead_model');
		if($patentNumber!=null){
			$data = $this->lead_model->findPatentFamilyChild($patentNumber);
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		die;
	}
	
	public function new_linkedin_scraper(){
		if(isset($_POST)){
			$contacts = $this->input->post('scrapped_results');
			if(!empty($contacts)){
				try{
					$asset_data = json_decode($contacts ,true);
					if(count($asset_data)>0){
						$this->load->model('lead_model');
						for($i=0;$i<count($asset_data);$i++){
							$name = $asset_data[$i]['name'];
							$name = explode(" ",$name);
							$last_name = $name[count($name)-1];
							unset($name[count($name)-1]);
							$first_name = implode(" ",$name);	
							/*Check Pre Contact with LinkedinUrl*/
							$checkPreContact = $this->lead_model->checkPreContactWithLinkedinUrl($asset_data[$i]['profile_link']);
							if(count($checkPreContact)==0){
								$data = $this->lead_model->insertPreContacts(array('first_name'=>$first_name,'last_name'=>$last_name,'job_title'=>$asset_data[$i]['job_title'],'company_name'=>$asset_data[$i]['company'],'email'=>'','secondary_email'=>'','telephone'=>'','cellphone'=>'','address'=>$asset_data[$i]['address'],'profile_url'=>$asset_data[$i]['profile_link'],'img_card'=>json_encode(array($asset_data[$i]['profile_image'])),'proximity'=>$asset_data[$i]['distance'],'c_c'=>$asset_data[$i]['shared']));
							} else {
								$data = $this->lead_model->updatePreContactsByLinkedInUrl(array('first_name'=>$first_name,'last_name'=>$last_name,'job_title'=>$asset_data[$i]['job_title'],'company_name'=>$asset_data[$i]['company'],'email'=>'','secondary_email'=>'','telephone'=>'','cellphone'=>'','address'=>$asset_data[$i]['address'],'profile_url'=>$asset_data[$i]['profile_link'],'img_card'=>json_encode(array($asset_data[$i]['profile_image'])),'proximity'=>$asset_data[$i]['distance'],'c_c'=>$asset_data[$i]['shared']),$asset_data[$i]['profile_link']);
							}
							
						}
					}
				}catch(Exception $e){					
				}
			}
			/*sleep(1);*/
		?>
			<script>window.close();</script>
		<?php
			die;
		}
	}
	
	public function get_outsource_chart_by_project($leadID=0,$type=0,$companyID=0){
		$data = array('activity_data'=>array(),'activity_user'=>array(),'activity_patent'=>array());
		if($leadID>0 && $type>0 && $companyID>0){
			$getLeadData = $this->lead_model->getLeadData($leadID);
			if(count($getLeadData)>0){
				$data = $this->opportunity_model->getChartDueActivityData($getLeadData->serial_number,$type,$companyID);
			}
		}
		$data['leadID'] = $leadID;
		$data['type']=$type;
		$data['companyID']=$companyID;
		$data['lead_name']=$getLeadData->lead_name;
		$data['company_data']=$this->opportunity_model->find_company_data_by_id($companyID,'company_name');
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Outsource Charts';
		$this->layout->render('opportunity/outsource_chart_by_project',$data);
	}
	public function get_outsource_chart_by_company($leadID=0,$companyID=0){
		$data = array('activity_data'=>array(),'activity_timing'=>array());
		if($leadID>0 && $companyID>0){
			$getLeadData = $this->lead_model->getLeadData($leadID);
			if(count($getLeadData)>0){
				$data = $this->opportunity_model->getChartCompanyDueActivityData($getLeadData->serial_number,$companyID);
			}
		}
		$data['leadID'] = $leadID;
		$data['companyID']=$companyID;
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Outsource Charts';
		$this->layout->render('opportunity/outsource_chart_by_company',$data);
	}
	
	
	function push_notification_captcha(){
		if(isset($_POST) && count($_POST)>0){
			$captchaData = $this->customer_model->getUSPTOCaptcha($this->input->post('id'));
			if(count($captchaData)>0){
				require(APPPATH.'third_party/push/autoload.php');
				$this->config->load('config');
				$options = array('encrypted' => true,'cluster' => $this->config->item('APP_CLUSTER'),'host'=>$this->config->item('APP_CLUSTER_HOST'));
				$pusher = new Pusher($this->config->item('PUSHER_APP_ID'),$this->config->item('PUSHER_APP_KEY'),$this->config->item('PUSHER_APP_SECRET'),$options);
				$showData = array('action'=>'captcha','data'=>$captchaData);
				$data['message'] = json_encode($showData);
				$pusher->trigger('notifications', 'new_notification', $data);
			}
		}
		die;
	}
	
	
	function push_notification_scrape_linkedin(){
		require(APPPATH.'third_party/push/autoload.php');
		$this->config->load('config');
		$postData = $this->input->post();
		$options = array('encrypted' => true,'cluster' => $this->config->item('APP_CLUSTER'),'host'=>$this->config->item('APP_CLUSTER_HOST'));
		$pusher = new Pusher($this->config->item('PUSHER_APP_ID'),$this->config->item('PUSHER_APP_KEY'),$this->config->item('PUSHER_APP_SECRET'),$options);
		$showData = array('action'=>$postData['action'],'data'=>$postData['id'],'message'=>$postData['d_d'],'type'=>$postData['type']);
		$data = array();
		$data['message'] = json_encode($showData);
		$pusher->trigger('notifications', 'new_notification', $data);
		die;
	} 
	
	function push_notification_patent(){
		require(APPPATH.'third_party/push/autoload.php');
		$this->config->load('config');
		$postData = $this->input->post();
		$options = array('encrypted' => true,'cluster' => $this->config->item('APP_CLUSTER'),'host'=>$this->config->item('APP_CLUSTER_HOST'));
		$pusher = new Pusher($this->config->item('PUSHER_APP_ID'),$this->config->item('PUSHER_APP_KEY'),$this->config->item('PUSHER_APP_SECRET'),$options);
		$showData = array('action'=>$postData['action'],'data'=>$postData['patent_data']);
		$data = array();
		$data['message'] = json_encode($showData);
		$pusher->trigger('notifications', 'new_notification', $data);
		die;
	}
	
	function push_notification_pos(){
		require(APPPATH.'third_party/push/autoload.php');
		$this->config->load('config');
		$options = array('encrypted' => true,'cluster' => $this->config->item('APP_CLUSTER'),'host'=>$this->config->item('APP_CLUSTER_HOST'));
		$pusher = new Pusher($this->config->item('PUSHER_APP_ID'),$this->config->item('PUSHER_APP_KEY'),$this->config->item('PUSHER_APP_SECRET'),$options);
		$showData = array('action'=>'new_pos','data'=>'');
		$data = array();
		$data['message'] = json_encode($showData);
		$pusher->trigger('notifications', 'new_notification', $data);
		die;
	}
	
	function push_commitment_chart_data(){
		/*request comes from confirmed request page*/
		require(APPPATH.'third_party/push/autoload.php');
		$this->config->load('config');
		$options = array('encrypted' => true,'cluster' => $this->config->item('APP_CLUSTER'),'host'=>$this->config->item('APP_CLUSTER_HOST'));
		$pusher = new Pusher($this->config->item('PUSHER_APP_ID'),$this->config->item('PUSHER_APP_KEY'),$this->config->item('PUSHER_APP_SECRET'),$options);
		$postData = $this->input->post('commitment_data');
		$showData = array('action'=>'commitment_data','data'=>$postData['id']);
		$data = array();
		$data['message'] = json_encode($showData);
		$pusher->trigger('notifications', 'new_notification', $data);
		die;
	}
	
	function list_companies(){
		$data = array('companies'=>array(),'other_list'=>array());
		if(isset($_GET)){
			$data = $this->customer_model->getCompaniesListJSON($this->input->get('query'));
		}
		header('Content-type: application/json');
		echo json_encode($data);
		die;
	}
	
	public function c_l(){
		$data = "0";
		if(isset($_POST) && count($_POST) > 0){
            $getData = $this->input->post();
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'https://synpat.com/count_leads.php',
				CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					's' => $getData['s']
				)
			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			if($resp){
				$data = $resp;
			}
		}
		echo $data;
		die;
	}
	
	function updateAllInOne(){
		$this->lead_model->updateAllInOne();
		die;
	}
	
	function list_categories(){
		$data = array('categories'=>array(),'sub_category'=>array(),'other_list'=>array());
		if(isset($_GET)){
			$data = $this->customer_model->getCategoriesListJSON($this->input->get('query'));
		}
		echo json_encode($data);
		die;
	}	
	
	public function retriveImageFolder(){
		$images = array();
		if(isset($_POST)){
			try{
				$lead_data = $this->opportunity_model->getLeadDataBySerialNumber($this->input->post('serial_number'),'image_folder');
				if(count($lead_data)>0){
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$images = $service->getFileIDFromChildern($lead_data->image_folder);
				}
			}catch(Exception $e){}
		}
		echo json_encode($images);
		die;
	}
	
	public function retriveCloudImageFolder(){
		$images = array();
		if(isset($_POST)){
			try{
				$lead_data = $this->opportunity_model->getLeadDataBySerialNumber($this->input->post('serial_number'),'image_folder');
				if(count($lead_data)>0){
					require(APPPATH.'third_party/google_cloud/autoload.php');
					$this->config->load('config');		
					$storage = new Google\Cloud\Storage\StorageClient([
						'projectId' => $this->config->item('google_cloud_project_id'),
						'keyFilename'=>'/var/www/synpat/backyard/application/third_party/Project-0da2ce476d80.p12',
						'acl' => 'public-read'
					]);
					$bucket = $storage->bucket('static.synpat.com');
					$objects = $bucket->objects(array('prefix'=>'store_images/'.$this->input->post('serial_number').'/','fields' => 'items/name,nextPageToken'));
					foreach ($objects as $object) {
						$name = $object->name();
						if($name!='store_images/'.$this->input->post('serial_number').'/'){
							$images[] = (object)array('title'=>$name,'url'=>"https://storage.googleapis.com/static.synpat.com/".$name);
						}
					}
				}
			}catch(Exception $e){}
		}
		echo json_encode($images);
		die;
	}
	
	function deleteFileFromBucket(){
		$fileURL = urldecode($this->input->post('file1'));
		if(!empty($fileURL)){
			require(APPPATH.'third_party/google_cloud/autoload.php');
			$this->config->load('config');		
			$storage = new Google\Cloud\Storage\StorageClient([
				'projectId' => $this->config->item('google_cloud_project_id'),
				'keyFilename'=>'/var/www/synpat/backyard/application/third_party/Project-0da2ce476d80.p12',
				'acl' => 'public-read'
			]);
			$bucket = $storage->bucket('static.synpat.com');
			$name = str_replace("https://storage.googleapis.com/static.synpat.com/",'',$fileURL);
			$object = $bucket->object($name);
			$object->delete();
		}
	}
	
	public function getAllImagesFromStore(){
		require(APPPATH.'third_party/google_cloud/autoload.php');
		$this->config->load('config');		
		$storage = new Google\Cloud\Storage\StorageClient([
			'projectId' => $this->config->item('google_cloud_project_id'),
			'keyFilename'=>'/var/www/synpat/backyard/application/third_party/Project-0da2ce476d80.p12',
			'acl' => 'public-read'
		]);
		$bucket = $storage->bucket('static.synpat.com');
		$serialNumbers = array(22232,28665,37166,49370,61638,71627,72101,73182,85865,90385);
		$images = array();
		foreach($serialNumbers as $serialNumber){
			$objects = $bucket->objects(array('prefix'=>'store_images/'.$serialNumber.'/','fields' => 'items/name,nextPageToken'));
			foreach ($objects as $object) {
				$name = $object->name();
				if($name!='store_images/'.$serialNumber.'/'){
					$images[] = (object)array('title'=>$name,'url'=>"https://storage.googleapis.com/static.synpat.com/".$name);
				}
			}
		}
		if(count($images)>0){
			$allInsertArray = array();
			foreach($images as $img){
				$getImageData = $this->opportunity_model->getImageFile($img->url);
				if(count($getImageData)==0){
					$extension = pathinfo($img->url,PATHINFO_EXTENSION);
					$name = array_pop(explode('/',$img->url));
					$name = str_replace('.'.$extension,'',$name);
					$allInsertArray[] = array('name'=>$name,'link'=>$img->url);
				}
			}
			$this->opportunity_model->insertStoreImagesInBulk($allInsertArray);
		}		
		die;
	}
	
	public function fromTextToFileToCdn() {
		$fileArray = array('from'=>'','drive_url'=>'','id'=>'','content'=>0);
		if(isset($_POST)){
			try{
				
				$serial_number = $this->input->post('license_number');
				$content = $this->input->post('file1');
				if(!empty($content)){
					$fileArray['content'] = 1;
					$serverPath = $this->serverPathDocketServicesAssets.'images/';
					$directoryName = $serial_number;
					if(!is_dir($serverPath.$directoryName)){
						mkdir($serverPath.$directoryName, 0777);
					}
					
					if (preg_match('/^data:image\/(\w+);base64,/', $content, $type)) {
						$content = substr($content, strpos($content, ',') + 1);
						$type = strtolower($type[1]); // jpg, png, gif

						if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
							throw new \Exception('invalid image type');
						}

						$content = base64_decode($content);

						if ($content === false) {
							throw new \Exception('base64_decode failed');
						} else {
							$patentNumber = $this->input->post('patent');
							$caseOpen = $this->input->post('case_open');
							$caseName = "";
							switch($caseOpen) {
								case 'legaldd_col_1_0':
									$caseName = "legal_source";
									break;
								case 'legaldd_col_2_0':
									$caseName = "terminal_source";
									break;
								case 'legaldd_col_7_0':
									$caseName = "patent_term_adjustment_source";
									break;
								case 'legaldd_col_8_0':
									$caseName = "scope_source";
									break;
								case 'legaldd_col_3_0':
									$caseName = "ipr_source";
									break;
								case 'legaldd_col_1_1':
									$caseName = "maintenance_source";
									break;
								case 'legaldd_col_6_0':
									$caseName = "chain_source";
									break;	
								case 'legaldd_col_5_0':
									$caseName = "liitigation_source";
									break;
							}
							$fileName = trim($patentNumber)."_".$caseName.".".$type;
							$fout = fopen($serverPath.$directoryName.'/'.$fileName, "w");
							$fw  = fwrite($fout, $content,strlen($content));
							fclose($fout);
							if($fw!=false){
								
								$fileUrlPath = "https://synpat.com/docket-services/assets/images/".$directoryName."/".$fileName;
								$fileArray = array('from'=>$fileUrlPath,'drive_url'=>$fileUrlPath,'id'=>$fileName);
							}
							
						}
					} else {
						throw new \Exception('did not match data URI with image data');
					}
					
				}
			}catch(Exception $e){}			
		}
		echo json_encode($fileArray);
		die;
	}
	
	public function uploadFileToCdnFromImageUrl(){
		$fileArray = array('from'=>'','drive_url'=>'','id'=>'');
		if(isset($_POST)){
			try{
				$fileName = $this->input->post('filename');
				$serial_number = $this->input->post('license_number');
				$fileURL = urldecode($this->input->post('file1'));
				if(!empty($fileURL)){							
					$content = file_get_contents($fileURL);	
					/*Upload file to google server*/
					$serverPath = $this->serverPathDocketServicesAssets.'images/';
					$directoryName = $serial_number;
					if(!is_dir($serverPath.$directoryName)){
						 mkdir($serverPath.$directoryName, 0777);
					}
					$fout = fopen($serverPath.$directoryName.'/'.$fileName, "w");
					 $fw  = fwrite($fout, $content,strlen($content));
					fclose($fout);
					if($fw!=false){
						$fileUrlPath = "https://synpat.com/docket-services/assets/images/".$directoryName."/".$fileName;
						$fileArray = array('from'=>$fileUrlPath,'drive_url'=>$fileUrlPath,'id'=>$fileName);
					}
					/*End upload file*/
					/*require(APPPATH.'third_party/google_cloud/autoload.php');
					$this->config->load('config');	
					$storage = new Google\Cloud\Storage\StorageClient([
						'projectId' => $this->config->item('google_cloud_project_id'),
						'keyFilename'=>'/var/www/synpat/backyard/application/third_party/Project-0da2ce476d80.p12',
						'acl' => 'public-read'
					]);
					$bucket = $storage->bucket('static.synpat.com');
					$getData = $bucket->upload($content,array('name'=>'store_images/'.$serial_number.'/'.$fileName,'predefinedAcl'=>'publicRead','metadata'=>array('cacheControl'=>"public,max-age=1314000,no-transform")));
					if($getData){
						$info = $getData->info();
						$name = $info['name'];
						$fileArray = array('from'=>"https://storage.googleapis.com/static.synpat.com/".$name,'drive_url'=>"https://storage.googleapis.com/static.synpat.com/".$name,'id'=>$name);
					}*/							
				}
			}catch(Exception $e){}			
		}
		echo json_encode($fileArray);
		die;
	}
	
	public function uploadCloudImages(){
		$fileArray = array('from'=>'','drive_url'=>'','id'=>'');		
		if(isset($_FILES)){
			try{
				$fileNameRaw = $_FILES['file1']['name'];
				$fileNameRawExplode = explode(';',$fileNameRaw);
				if(count($fileNameRawExplode)==2){
					$fileName = $fileNameRawExplode[0];
					$rawLicenseNumber = explode('=',$fileNameRawExplode[1]);
					$serial_number = array_pop($rawLicenseNumber);
					if(!empty($serial_number)){											
						$fileURL = $_FILES['file1']['tmp_name'];
						if(!empty($fileURL)){							
							$content = file_get_contents($fileURL);
							/*Upload file to google server*/
							$serverPath = $this->serverPathDocketServicesAssets.'images/';
							$directoryName = $serial_number;
							if(!is_dir($serverPath.$directoryName)){
								 mkdir($serverPath.$directoryName, 0777);
							}
							$fout = fopen($serverPath.$directoryName.'/'.$fileName, "w");
							 $fw  = fwrite($fout, $content,strlen($content));
							fclose($fout);
							if($fw!=false){
								$fileUrlPath = "https://synpat.com/docket-services/assets/images/".$directoryName."/".$fileName;
								$fileArray = array('from'=>$fileUrlPath,'drive_url'=>$fileUrlPath,'id'=>$fileName);
							}
							/*End upload file*/
							/*require(APPPATH.'third_party/google_cloud/autoload.php');
							$this->config->load('config');	
							$storage = new Google\Cloud\Storage\StorageClient([
								'projectId' => $this->config->item('google_cloud_project_id'),
								'keyFilename'=>'/var/www/synpat/backyard/application/third_party/Project-0da2ce476d80.p12',
								'acl' => 'public-read'
							]);
							$bucket = $storage->bucket('static.synpat.com');
							//$acl = $bucket->acl();
							$getData = $bucket->upload($content,array('name'=>'store_images/'.$serial_number.'/'.$fileName,'predefinedAcl'=>'publicRead'));
							if($getData){
								$info = $getData->info();
								$name = $info['name'];
								$fileArray = array('from'=>"https://storage.googleapis.com/static.synpat.com/".$name,'drive_url'=>"https://storage.googleapis.com/static.synpat.com/".$name,'id'=>$name);
							}*/							
						}
					}
				}				
			}catch(Exception $e){}			
		}
		echo json_encode($fileArray);
		die;
	}
	
	public function scrapDataGooglePatent($getPatentNumber){
		/*$getPatentNumber = $this->input->post('scrap_data');*/
		if(!empty($getPatentNumber)){
			$getPatentNumber = strtoupper($getPatentNumber);
			if(strpos($getPatentNumber,"US")===false){
				$getPatentNumber = "US".$getPatentNumber;
			}
			/*$url = "http://ec2-52-38-222-126.us-west-2.compute.amazonaws.com/webdriver/index.php?patent=".$getPatentNumber;*/
			/*$url = "http://webdriverforscrape.site/index.php?patent=".$getPatentNumber;*/
			$url = "http://webdriverforscrape.site/pagesource.php?patent=".$getPatentNumber;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20150101 Firefox/31.0");
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			$content = curl_exec($ch);
			curl_close($ch);			
		}
		echo $content;
		echo "<style>.gb_Uf, .gb_Vf,.kd-appbar,.gb_4f,#gba,.gb_1b,#gbq{display:none;}</style>";
		die;
		/*$data['scrap_data'] = $content;
		$this->layout->layout='scrap_data';
		$this->layout->auto_render=false;		 
		$this->layout->title_for_layout = 'Backyard From Patent Detail';
		$this->layout->render('leads/scrap_data',$data);*/				
	}
	
	public function uploadDocketImages(){
		$fileArray = array('from'=>'','drive_url'=>'','id'=>'');
		if(isset($_FILES)){
			try{
				$fileNameRaw = $_FILES['file1']['name'];
				$fileNameRawExplode = explode(';',$fileNameRaw);
				if(count($fileNameRawExplode)==2){
					$fileName = $fileNameRawExplode[0];
					$rawLicenseNumber = explode('=',$fileNameRawExplode[1]);
					$serial_number = array_pop($rawLicenseNumber);
					$fileURL = $_FILES['file1']['tmp_name'];
					if(!empty($serial_number) && !empty($fileURL)){	
						$content = file_get_contents($fileURL);
						/*Upload file to google server*/
						$serverPath = $this->serverPathDocketServicesAssets.'images/';
						$directoryName = $serial_number;
						if(!is_dir($serverPath.$directoryName)){
							 mkdir($serverPath.$directoryName, 0777);
						}
						$fout = fopen($serverPath.$directoryName.'/'.$fileName, "w");
						 $fw  = fwrite($fout, $content,strlen($content));
						fclose($fout);
						if($fw!=false){
							$fileUrlPath = "https://synpat.com/docket-services/assets/images/".$directoryName."/".$fileName;
							$fileArray = array('from'=>$fileUrlPath,'drive_url'=>$fileUrlPath,'id'=>$fileName);
						}
						/*End upload file*/
						/*$findLeadData = $this->opportunity_model->getLeadDataBySerialNumber($serial_number,'image_folder');
						if(count($findLeadData)>0){
							$folderID = $findLeadData->image_folder;	 							
							if(!empty($folderID)){					
								$fileURL = $_FILES['file1']['tmp_name'];
								if(!empty($fileURL)){
									$finfo = new finfo(FILEINFO_MIME);
									$mimeType =  $finfo->buffer(file_get_contents($fileURL)); 
									if(!empty($mimeType)){
										$m = explode(";",$mimeType);
										$mimeType = $m[0];
									}
									if(empty($mimeType)){
										$mimeType = "image/png";
									}
									$convert=false;			
									$this->load->library('DriveServiceHelper');
									$service = new DriveServiceHelper();
									$fileParent = new Google_Service_Drive_ParentReference();
									$fileParent->setId( $folderID );
									$getUploadFileData = $service->insertFile($fileName,$mimeType,$fileURL,$fileParent,$convert);
									if($getUploadFileData){
										$fileArray = array('from'=>$fileURL,'drive_url'=>$getUploadFileData->alternateLink,'id'=>$getUploadFileData->id);
									}
								}
							}
						}
						*/
					}
				}				
			}catch(Exception $e){}			
		}
		echo json_encode($fileArray);
		die;
	}
	
	public function uploadImage(){
		$fileArray = array('from'=>'','drive_url'=>'','id'=>'');
		if(isset($_POST)){
			try{
				$serial_number = $this->input->post('serial_number');
				$fileURL = $this->input->post('image_url');
				if(!empty($serial_number) && !empty($fileURL)){	
					$content = file_get_contents($fileURL);
					/*Upload file to google server*/
					$fileName = basename($fileURL);
					$serverPath = $this->serverPathDocketServicesAssets.'images/';
					$directoryName = $serial_number;
					if(!is_dir($serverPath.$directoryName)){
						mkdir($serverPath.$directoryName, 0777);
					}
					$fout = fopen($serverPath.$directoryName.'/'.$fileName, "w+");
					$fw  = fwrite($fout, $content,strlen($content));
					fclose($fout);
					if(file_exists($serverPath.$directoryName.'/'.$fileName)){
						$fileUrlPath = "https://synpat.com/docket-services/assets/images/".$directoryName."/".$fileName;
						$fileArray = array('from'=>$fileUrlPath,'drive_url'=>$fileUrlPath,'id'=>$fileName);
					}
				}
				
				
				
				/*
				$findLeadData = $this->opportunity_model->getLeadDataBySerialNumber($this->input->post('serial_number'),'image_folder');
				if(count($findLeadData)>0){
					$folderID = $findLeadData->image_folder;	 							
					if(!empty($folderID)){					
						$fileURL = $this->input->post('image_url');
						if(!empty($fileURL)){
							$finfo = new finfo(FILEINFO_MIME);
							$mimeType =  $finfo->buffer(file_get_contents($fileURL)); 	
							$fileName = "img_".time();
							if(!empty($mimeType)){
								$m = explode(";",$mimeType);
								$mimeType = $m[0];
							}
							if(empty($mimeType)){
								$mimeType = "image/png";
							}
							$convert=false;			
							$this->load->library('DriveServiceHelper');
							$service = new DriveServiceHelper();
							$fileParent = new Google_Service_Drive_ParentReference();
							$fileParent->setId( $folderID );
							$getUploadFileData = $service->insertFile($fileName,$mimeType,$fileURL,$fileParent,$convert);
							if($getUploadFileData){
								$fileArray = array('from'=>$fileURL,'drive_url'=>$getUploadFileData->alternateLink,'id'=>$getUploadFileData->id);
							}
						}
					}
				}*/
			}catch(Exception $e){}			
		}
		echo json_encode($fileArray);
		die;
	}
	
	public function resize($newWidth, $targetFile, $originalFile) {
		$newFile = $targetFile;
		try{
			$info = getimagesize($originalFile);
			$mime = $info['mime'];
			switch ($mime) {
					case 'image/jpeg':
							$image_create_func = 'imagecreatefromjpeg';
							$image_save_func = 'imagejpeg';
							$new_image_ext = '.jpg';
							break;
					case 'image/png':
							$image_create_func = 'imagecreatefrompng';
							$image_save_func = 'imagepng';
							$new_image_ext = '.png';
							break;
					case 'image/gif':
							$image_create_func = 'imagecreatefromgif';
							$image_save_func = 'imagegif';
							$new_image_ext = '.gif';
							break;
					default: 
							//throw new Exception('Unknown image type.');
			}
			if(isset($new_image_ext) && $new_image_ext != ""){
				$img = $image_create_func($originalFile);
				list($width, $height) = getimagesize($originalFile);
				if($width > $height){
					$newHeight =  floor(($height / $width) * $newWidth);
				} else {
					$newHeight = $newWidth;
					$newWidth = floor(($width / $height) * $newHeight);
				}
				$tmp = imagecreatetruecolor($newWidth, $newHeight);
				$color = imagecolorallocatealpha($tmp, 0, 0, 0, 127); //fill transparent back
				imagefill($tmp, 0, 0, $color);
				imagesavealpha($tmp, true);
				imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
				if (file_exists($targetFile)) {
					unlink($targetFile);
				}
				$targetFile = str_replace(array('.png','.jpg','.gif'),"",strtolower($targetFile));
				$newFile = $targetFile.$new_image_ext;
				$image_save_func($tmp, $newFile);
			}			
		}catch(Exception $e){
			
		}		
		return $newFile;
	}
	
	public function uploadImageContacts(){
		$fileArray = array('from'=>'','drive_url'=>'','id'=>'');
		if(isset($_POST)){
			try{

				$folderID = "1Evk_zcEbbfXYSVJ1rskq0lWsoPs08B3X";
				if(!empty($folderID)){					
					$fileURL = $this->input->post('image_url');
					$ID = $this->input->post('contact_id');
					if(!empty($fileURL)){
						$finfo = new finfo(FILEINFO_MIME);
						$content = file_get_contents($fileURL);
						$mimeType =  $finfo->buffer($content); 	
						$fileName = $ID ."_img_".time();
						if(!empty($mimeType)){
							$m = explode(";",$mimeType);
							$mimeType = $m[0];
						}
						if(empty($mimeType)){
							$mimeType = "image/jpeg";
						}
						if(strpos($mimeType,"jpeg")!==false){
							$fileName .=".jpg";
						}else if(strpos($mimeType,"jpg")!==false){
							$fileName .=".jpg";
						}else if(strpos($mimeType,"png")!==false){
							$fileName .=".png";
						}else{
							$fileName .=".jpg";
						}
						if($content!="" && strpos($content,"Access Denied")===false){
							try{
								$target_dir = $_SERVER['DOCUMENT_ROOT']."/public/upload/contacts/";
								$target_file = $target_dir.$fileName;
								$file = fopen($target_file,"w");
								fwrite($file,$content);
								fclose($file);
								if(isset($_POST['company']) && $_POST['company'] == 1){
									$newFile = $this->resize(120, $target_file, $target_file,$imageFileType);
									if($newFile != ""){
										$target_file = $newFile;
										$fileName = str_replace($target_dir,"",$newFile);
									}
								}
								$fileArray['file'] = $fileName;
								$fileArray['drive_url'] = $this->config->base_url()."public/upload/contacts/".$fileName;
							}catch(Exception $e){
								
							}
						}
						
						
						
					}
				}
			}catch(Exception $e){}			
		}
		echo json_encode($fileArray);
		die;
	}
	
	public function uploadImageCompanyLogo(){
		$fileArray = array('from'=>'','drive_url'=>'','id'=>'');
		if(isset($_POST)){
			try{

				$folderID = "1Evk_zcEbbfXYSVJ1rskq0lWsoPs08B3X";
				if(!empty($folderID)){					
					$fileURL = $this->input->post('image_url');
					$ID = $this->input->post('contact_id');
					if(!empty($fileURL)){
						$finfo = new finfo(FILEINFO_MIME);
						$content = file_get_contents($fileURL);
						$mimeType =  $finfo->buffer($content); 	
						$fileName = $ID ."_img_".time();
						if(!empty($mimeType)){
							$m = explode(";",$mimeType);
							$mimeType = $m[0];
						}
						if(empty($mimeType)){
							$mimeType = "image/jpeg";
						}
						if(strpos($mimeType,"jpeg")!==false){
							$fileName .=".jpg";
						}else if(strpos($mimeType,"jpg")!==false){
							$fileName .=".jpg";
						}else if(strpos($mimeType,"png")!==false){
							$fileName .=".png";
						}else{
							$fileName .=".jpg";
						}
						if($content!="" && strpos($content,"Access Denied")===false){
							try{
								$target_file = $_SERVER['DOCUMENT_ROOT']."/public/upload/contacts/".$fileName;
								fwrite($file,$content);
								fclose($file);
								$newUrl = "";
								if(isset($_POST['company']) && $_POST['company'] == 1){
									$newFile = $this->resize(120, $target_file, $target_file,$imageFileType);
									if($newFile != ""){
										$logo = $newFile;
										$destination = "/var/www/synpat/backyard/public/upload/company_logo/optimize/".$fileName;
										$newUrl = $this->compressImage($logo,$destination,80);
										$newUrl = str_replace("/var/www/synpat/backyard","https://backyard.synpat.com",$newUrl);
										$fileName = str_replace("https://backyard.synpat.com/public/upload/company_logo/optimize/","",$newUrl);										
										//$target_file = $newFile;
										//$fileName = str_replace($target_dir,"",$newFile);
									}
								}
								$fileArray['file'] = $fileName;
								$fileArray['drive_url'] = $this->config->base_url()."public/upload/company_logo/".$fileName;
							}catch(Exception $e){
								
							}
						}
						
						
						
					}
				}
			}catch(Exception $e){}			
		}
		echo json_encode($fileArray);
		die;
	}
	
	
	public function uploadLinkedinImagestoBackyard(){
		$getAllCompanyLogos = $this->client_model->getAllLogos();
		foreach($getAllCompanyLogos as $l){
			if(strpos($l->company_logo,"backyard")===false){
				$finfo = new finfo(FILEINFO_MIME);
				$fileURL = $l->company_logo;
				$ID = $l->id;
				$content = file_get_contents($fileURL);
				$mimeType =  $finfo->buffer($content); 	
				$fileName = $ID ."_img_".time();
				if(!empty($mimeType)){
					$m = explode(";",$mimeType);
					$mimeType = $m[0];
				}
				if(empty($mimeType)){
					$mimeType = "image/jpeg";
				}
				if(strpos($mimeType,"jpeg")!==false){
					$fileName .=".jpg";
				}else if(strpos($mimeType,"jpg")!==false){
					$fileName .=".jpg";
				}else if(strpos($mimeType,"png")!==false){
					$fileName .=".png";
				}else{
					$fileName .=".jpg";
				}
				if($content!="" && strpos($content,"Access Denied")===false){
					try{
						$file = fopen($_SERVER['DOCUMENT_ROOT']."/public/upload/contacts/".$fileName,"w");
						fwrite($file,$content);
						fclose($file);
						$this->client_model->updateCompanyLogo(array('company_logo'=>$this->config->base_url()."public/upload/contacts/".$fileName),$ID);
					}catch(Exception $e){
						
					}
				}
			}	
		}
	}
	
	public function file_change_parent_pdf(){
		if(isset($_POST)){
			try{
				$fileURL = $this->input->post('image_url');
				if(strpos($fileURL,'docket-services')!==false){
					$fileURL = str_replace($fileURL,"https://synpat.com/","/var/www/synpat/synpat/");
					$fileURL = str_replace($fileURL,"http://synpat.com/docket-services/assets/pdf/","/var/www/synpat/synpat/");
					$fileAllUrl = explode("/",$fileURL);
						$fileID = array_pop($fileAllUrl);
					$newFileUrl = "/var/www/synpat/synpat/docket-services/assets/pdf/".$this->input->post('serial_number')."/".$fileID;
					rename($fileURL, $newFileUrl);
				}
				/*$findLeadData = $this->opportunity_model->getLeadDataBySerialNumber($this->input->post('serial_number'),'pdf_folder');
				if(count($findLeadData)>0){
					$folderID = $findLeadData->pdf_folder;	 							
					if(!empty($folderID)){					
						$fileURL = $this->input->post('image_url');
						$fileURL = str_replace('/view?usp=drivesdk',"",$fileURL);
						$fileURL = str_replace('/edit?usp=drivesdk',"",$fileURL);
						$fileURL = str_replace('/preview',"",$fileURL);
						$fileAllUrl = explode("/",$fileURL);
						$fileID = array_pop($fileAllUrl);
						if(!empty($fileID)){
							$this->load->library('DriveServiceHelper');
							$service = new DriveServiceHelper();
							$service->moveFile($fileID,$folderID);
						}					
					}
				}*/
			}catch(Exception $e){}			
		}
		echo json_encode($fileArray);
		die;
	}
	
	public function renameDraftFileInCustomer(){
		$data = false;
		if(isset($_POST)){
			if(isset($_POST['file_id']) && !empty($_POST['file_id'])){
				$fileURL = $this->input->post('file_id');
				$companyName = $this->input->post('company_name');
				$fileURL = str_replace('/view?usp=drivesdk',"",$fileURL);
				$fileURL = str_replace('/edit?usp=drivesdk',"",$fileURL);
				$fileURL = str_replace('/preview',"",$fileURL);
				$fileAllUrl = explode("/",$fileURL);
				$fileID = array_pop($fileAllUrl);
				if(!empty($fileID)){
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$getFileInfo = $service->getFileInfo($fileID);
					if(is_object($getFileInfo) && isset($getFileInfo->id) && !empty($getFileInfo->id)){
						$name = $getFileInfo->title." ".$companyName;
						$updateFileName = $service->renameFile($fileID,$name);
						if($updateFileName){
							$data = true;
						}
					}
				}
			}
		}
		echo $data;
		die;
	}
	
	public function findFileIDFromUrl($fileURL ){
		$fileURL = str_replace('/view?usp=drivesdk',"",$fileURL);
		$fileURL = str_replace('/edit?usp=drivesdk',"",$fileURL);
		$fileURL = str_replace('/preview',"",$fileURL);
		$fileURL = str_replace('/edit',"",$fileURL);
		$fileURL = str_replace('/view',"",$fileURL);
		$fileURL = str_replace('/permissions',"",$fileURL);
		$fileAllUrl = explode("/",$fileURL);
		$fileID = array_pop($fileAllUrl);
		return $fileID;
	}
	
	public function giveStoreCustomerFilePermissionsToUsers($userIds){
		if(count($userIds)>0){
			if(count($userIds)==1){
				$this->givePermissionToUser($userIds[0],0,false);
			} else {
				$this->givePermissionToUser($userIds[0],0,true);
			}
		}
	}
	
	public function deletePermissionFromStoreCustomerFile($companyID,$emailID){
		$getAllEmailIds = $this->lead_model->findAllContactsFromCompany($companyID,'c.email,c.id');
		if(count($getAllEmailIds)>0){
			$customerIDs = array();
			foreach($getAllEmailIds as $ids){
				if(!in_array($ids->id,$customerIDs)){
					$customerIDs[] = $ids->id;
				}
			}
			$filesFromDraft = $this->lead_model->findDraftRevisedDocumentRequestFromUserList($customerIDs,$licenseID,'license_aggreement,strategic_aggreement');
			$files = array();
			$filesID = array();
			if(count($filesFromDraft)>0){
				/**/						
				foreach($filesFromDraft as $file){
					if(!empty($file->license_aggreement)){
						if(!in_array($file->license_aggreement,$files)){
							$filesID[] = $this->findFileIDFromUrl($file->license_aggreement);
							$files[] = $file->license_aggreement;
						}
					}
					if(!empty($file->strategic_aggreement)){
						if(!in_array($file->strategic_aggreement,$files)){
							$filesID[] = $this->findFileIDFromUrl($file->strategic_aggreement);
							$files[] = $file->strategic_aggreement;
						}
					}
				}
			}
			$filesFromCustomerTransactions = $this->lead_model->findCustomerTransactionFromUserList($customerIDs,$licenseID,'file');
			if(count($filesFromCustomerTransactions)>0){
				foreach($filesFromCustomerTransactions as $file){
					if(!empty($file->file)){
						if(!in_array($file->file,$files)){
							$filesID[] = $this->findFileIDFromUrl($file->file);
							$files[] = $file->file;
						}
					}
				}
			}
			if(count($filesID)>0){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$filesWithPermissions = $service->batchRequestPermissionList($filesID);
				if(count($filesWithPermissions)>0){
					$removePermissions = array();
					foreach($filesWithPermissions as $permission){
						$fileLink = $permission['file_link'];
						$getFileID = $this->findFileIDFromUrl($fileLink);
						if(count($permission['items'])>0){
							for($i=0;$i<count($permission['items']);$i++){
								$perm = $permission['items'][$i];
								if($perm->emailAddress==$emailID){
									$removePermissions[] = array("id"=>$getFileID,'permission_id'=>$perm->id);
								}
							}									
						}								
					}
					if(count($removePermissions)>0){
						$service->batchRequestForRemovePermissions($removePermissions);
					}
				}
			}
		}
	}
	
	public function customer_permission_files_company(){
		if(isset($_POST) && count($_POST)>0 && isset($_POST['customer_id']) && isset($_POST['license_id'])){
			$customerID = $this->input->post('customer_id');
			$licenseID = $this->input->post('license_id');
			$this->givePermissionToUser($customerID,$licenseID,true);
		}
		die;
	}
	
	public function givePermissionToUser($customerID,$licenseID=0,$bulk = true){
		/*Find Files*/
		$getAllEmailIds = $this->lead_model->findAllContactsFromCustomerCompany($customerID,'c.email,c.id');
		if(count($getAllEmailIds)>0){
			$customerIDs = array();
			$userEmails = array();
			foreach($getAllEmailIds as $ids){
				if(!in_array($ids->id,$customerIDs)){
					$customerIDs[] = $ids->id;
				}
				if(!in_array($ids->email,$userEmails)){
					$userEmails[] = $ids->email;
				}
			}
			$filesFromDraft = $this->lead_model->findDraftRevisedDocumentRequestFromUserList($customerIDs,$licenseID,'license_aggreement,strategic_aggreement');
			$files = array();
			$filesID = array();
			if(count($filesFromDraft)>0){
				/**/						
				foreach($filesFromDraft as $file){
					if(!empty($file->license_aggreement)){
						if(!in_array($file->license_aggreement,$files)){
							$filesID[] = $this->findFileIDFromUrl($file->license_aggreement);
							$files[] = $file->license_aggreement;
						}
					}
					if(!empty($file->strategic_aggreement)){
						if(!in_array($file->strategic_aggreement,$files)){
							$filesID[] = $this->findFileIDFromUrl($file->strategic_aggreement);
							$files[] = $file->strategic_aggreement;
						}
					}
				}
			}
			$filesFromCustomerTransactions = $this->lead_model->findCustomerTransactionFromUserList($customerIDs,$licenseID,'file');
			if(count($filesFromCustomerTransactions)>0){
				foreach($filesFromCustomerTransactions as $file){
					if(!empty($file->file)){
						if(!in_array($file->file,$files)){
							$filesID[] = $this->findFileIDFromUrl($file->file);
							$files[] = $file->file;
						}
					}
				}
			}
			if(count($filesID)>0){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				if($licenseID>0){
					$filesWithPermissions = $service->batchRequestPermissionList($filesID);
					if(count($filesWithPermissions)>0){
						$removePermissions = array();
						foreach($filesWithPermissions as $permission){
							$fileLink = $permission['file_link'];
							$getFileID = $this->findFileIDFromUrl($fileLink);
							if(count($permission['items'])>0){
								for($i=0;$i<count($permission['items']);$i++){
									$perm = $permission['items'][$i];
									if($perm->id=="anyone" || $perm->type=="anyone" || $perm->id=="anyoneWithLink" || $perm->role=="reader"){
										$removePermissions[] = array("id"=>$getFileID,'permission_id'=>$perm->id);
									}
								}									
							}								
						}
						if(count($removePermissions)>0){
							$service->batchRequestForRemovePermissions($removePermissions);
						}
					}
				}						
				/*Give Permissions*/
				if($licenseID==0 && $bulk==false){
					$getCustomerInfo = $this->lead_model->getCustomerInfoByID($customerID,'c.email');
					if($getCustomerInfo>0){
						$userEmails = array($getCustomerInfo->email);
					}
				}
				$newPermissions = array();
				if(count($filesID)>0){
					foreach($filesID as $file){
						foreach($userEmails as $email){
							$sendNotification = true;
							$domain = explode('@',$email);
							if(count($domain)==2 && (strtolower($domain[1])=="gmail.com" || strtolower($domain[1])=="synpat.com")){
								$sendNotification = false;
							}
							$newPermissions[] = array('id'=>$file,'email_address'=>$email,'send_notification'=>$sendNotification);
						}
					}
				}
				if(count($newPermissions)>0){
					$returnService = $service->batchRequestForSetPermissionsWithComments($newPermissions,'reader');
				}						
			}
		}
	}
	
	public function draftFileInCustomer(){
		$data = array('file'=>'','error'=>0,'success'=>0,'message'=>'','file_name'=>'');
		if(isset($_POST)){
			if(isset($_POST['folder_id']) && isset($_POST['file_id']) && !empty($_POST['file_id']) && !empty($_POST['folder_id'])){
				$fileURL = $this->input->post('file_id');
				$fileURL = str_replace('/view?usp=drivesdk',"",$fileURL);
				$fileURL = str_replace('/edit?usp=drivesdk',"",$fileURL);
				$fileURL = str_replace('/preview',"",$fileURL);
				$fileAllUrl = explode("/",$fileURL);
				$fileID = array_pop($fileAllUrl);
				if(!empty($fileID)){
					/*Find Customer Folder*/
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$q = "title  contains  ".CUSTOMER_FOLDER." and mimeType = 'application/vnd.google-apps.folder'";
					$listFiles = $service->searchFileIDFromChildern($this->input->post('folder_id'),$q);
					$customerFolderID = "";
					if(count($listFiles)==0){
						/*Create Customer Folder*/
						$fileParent = new Google_Service_Drive_ParentReference();
						$fileParent->setId($this->input->post('folder_id'));	
						$customerFolderID = $service->createSubFolder(CUSTOMER_FOLDER,$fileParent);
					} else {
						if(count($listFiles)>0){ 
							foreach($listFiles as $file){
								if($file->title==CUSTOMER_FOLDER){
									$customerFolderID = $file->id;
									break;
								}
							}
						}
					}				
					if(!empty($customerFolderID)){
						/*Find Original File Info*/
						$getFileInfo = $service->getFileInfo($fileID);
						if(is_object($getFileInfo) && isset($getFileInfo->id) && !empty($getFileInfo->id)){
							/*Create a draft file in Customer Folder*/
							$fileParent = new Google_Service_Drive_ParentReference();
							$fileParent->setId($customerFolderID);
							$postTitle = $getFileInfo->title;
							if(isset($_POST['file_title'])){
								$postTitle = $_POST['file_title'];
							}
							$fileName = $postTitle." - ".$this->input->post('company_name');
							$copyFileDetails = $service->copyFile($getFileInfo->id,$fileName,$fileParent);
							if(is_object($copyFileDetails)){
								$service->setAdditionalPermissions($copyFileDetails->id, '', 'reader', $type = 'anyone');
								$data['file'] = $copyFileDetails->alternateLink;
								$data['file_name'] = $copyFileDetails->title;
								$data['success'] = 1;
							} else {
								$data['message'] = 'Please try after sometime.';
							}
						} else {
							$data['message'] = 'Please try after sometime.';
						}
					} else {
						$data['message'] = 'Please try after sometime.';
					}
				} else {
					$data['message'] = 'Please try after sometime.';
				}
			} else {
				$data['message'] = 'System don\'t find file for draft.';
			}
		} else {
			$data['message'] = 'Fields are empty.';
		}
		echo json_encode($data);
		die;
	}
	
	public function store_file_upload(){
		$fileUploadLink = array('file1'=>'','file2'=>'','file3'=>'','file4'=>'','title1'=>'','title2'=>'','title3'=>'','title4'=>'');
		if(isset($_FILES)){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$fileParent = new Google_Service_Drive_ParentReference();
			$parentID = "0B_Do1Yd0xSmXWEJUZ3lTZ1ktaHM";
			if(isset($_GET) && !empty($_GET['parent_id'])){
				$parentID = $this->input->get('parent_id');
			}
			$fileParent->setId($parentID);			
			for($i=1;$i<=4;$i++){
				if(isset($_FILES['file'.$i]['name'])){
					$convert = true;
					$mimeType = "";
					if(strtolower(pathinfo($_FILES['file'.$i]["name"], PATHINFO_EXTENSION)) == 'docx' || strtolower(pathinfo($_FILES['file'.$i]["name"], PATHINFO_EXTENSION))=='doc'){
						$mimeType = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
					} else if(strtolower(pathinfo($_FILES['file'.$i]["name"], PATHINFO_EXTENSION)) == 'pdf'){
						$convert = false;
						$mimeType="application/pdf";
					}
					if(!empty($mimeType)){
						$getUploadFileData = $service->insertFile($_FILES['file'.$i]['name'],$mimeType,$_FILES['file'.$i]['tmp_name'],$fileParent,$convert);
						if($getUploadFileData){				
							$fileUploadLink['file'.$i] = $getUploadFileData->alternateLink;
							$fileUploadLink['title'.$i] = $getUploadFileData->title;
							$service->setAdditionalPermissions($getUploadFileData->id,"","reader","anyone");
						}
					}
				}
			}
		}
		echo json_encode($fileUploadLink) ;
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
	
	public function find_seller_materials(){
		$data = array();
		if(isset($_POST['sr']) && (int)$_POST['sr']>0){
			$getLeadData = $this->lead_model->findSerialNumber($_POST['sr']);
			if(count($getLeadData)>0 && !empty($getLeadData->seller_material_folder_id)){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				/*$data = $service->getFileIDFromChildern($getLeadData->seller_material_folder_id);*/
				$q = "'".$getLeadData->seller_material_folder_id."' in parents";
				$data = $service->getAllFilesAndFolder($q);
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function upload_pdf_files_and_insert(){
		$fileArray = array('from'=>'','drive_url'=>'','id'=>'');
		if(isset($_POST['lead_id']) && (int)$_POST['lead_id']>0){
			$getLeadData = $this->lead_model->getLeadDataWithOptions($this->input->post('lead_id'),'l.serial_number');
			if(count($getLeadData)>0){
				$fileLink = $this->input->post('file_link');
				$patent = $this->input->post('patent_id');
				$fileName = $patent.".pdf";
				$content = file_get_contents($fileLink);
				$serialNumber = $getLeadData->serial_number;
				$serverPath = $this->serverPathDocketServicesAssets.'pdf/';
				$directoryName = $serialNumber;
				if(!is_dir($serverPath.$directoryName)){
					 mkdir($serverPath.$directoryName, 0777);
				}
				$fout = fopen($serverPath.$directoryName.'/'.$fileName, "w");
				  $fw  = fwrite($fout, $content,strlen($content));
				fclose($fout);
				if($fw!=false){
					$fileUrlPath = "https://synpat.com/docket-services/assets/pdf/".$directoryName."/".$fileName;
					$fileArray = array('from'=>$fileUrlPath,'drive_url'=>$fileUrlPath,'id'=>$fileName);
				}
			}
		}
		echo json_encode($fileArray);
		die;
	}
	
	public function seller_material_to_drive(){
		$fileURL = array();
		$getLeadData = array();
		$result = 0;
		if(isset($_POST['serial_number']) && (int)$_POST['serial_number']>0){
			$getLeadData = $this->lead_model->findSerialNumber($_POST['serial_number']);
			if(count($getLeadData)>0 && !empty($getLeadData->seller_material_folder_id)){
				$file = $_POST['file'];
				$filename = array_pop(explode('/',$file));
				$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
				fwrite($fh, file_get_contents($file));
				fclose($fh);	
				$mimeType = $this->mime_type($filename);
				$convert=true;
				if($mimeType=="inode/x-empty" || $mimeType=="application/pdf" || $mimeType=="image/jpeg" || $mimeType=="image/png" || $mimeType=="image/gif" || $mimeType=="image/bmp"){
					$convert=false;
				}
				if($mimeType=="inode/x-empty"){
					 $mimeType="application/pdf";
				}
				$fileName = $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename;
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$parent = new Google_Service_Drive_ParentReference();
				$parent->setId($getLeadData->seller_material_folder_id);
				$getUploadFileData = $service->insertFile($filename,$mimeType,$fileName,$parent,$convert);
				if($getUploadFileData){
					unlink($fileName);
					$service->setAdditionalPermissions( $getUploadFileData->id,"","reader","anyone");
					$result = 1;
				}
			}
		}		
		echo $result;
		die;
	}
	
	public function seller_material(){
		$fileURL = array();
		$getLeadData = array();
		if(isset($_POST['serial_number']) && (int)$_POST['serial_number']>0){
			$getLeadData = $this->lead_model->findSerialNumber($_POST['serial_number']);
		}
		if(isset($_FILES) && isset($_FILES['file'])){
			if(count($getLeadData)>0 && !empty($getLeadData->seller_material_folder_id)){
				/*Upload to Google Drive*/
				$filename = $_FILES['file']['name'];
				$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
				fwrite($fh, file_get_contents($_FILES['file']['tmp_name']));
				fclose($fh);	
				$mimeType = $this->mime_type($filename);
				$convert=true;
				if($mimeType=="inode/x-empty" || $mimeType=="application/pdf" || $mimeType=="image/jpeg" || $mimeType=="image/png" || $mimeType=="image/gif" || $mimeType=="image/bmp"){
					$convert=false;
				}
				if($mimeType=="inode/x-empty"){
					 $mimeType="application/pdf";
				}
				$fileName = $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename;
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$parent = new Google_Service_Drive_ParentReference();
				$parent->setId($getLeadData->seller_material_folder_id);
				$getUploadFileData = $service->insertFile($filename,$mimeType,$fileName,$parent,$convert);
				if($getUploadFileData){
					unlink($fileName);
					$service->setAdditionalPermissions( $getUploadFileData->id,"","reader","anyone");
					$fileURL = array('filename'=>$getUploadFileData->title,'url'=>$getUploadFileData->alternateLink,'icon'=>$getUploadFileData->iconLink);
				}
			} else{
				/*Upload to AWS Server*/
				$filename = $_FILES['file']['name'];
				$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
				fwrite($fh, file_get_contents($_FILES['file']['tmp_name']));
				fclose($fh);
				$fileName = $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename;
				$fileData = $this->add_aws_file($filename,$fileName);
				$fileAWS = "";
				if(count($fileData)>0 && $fileData['error']==0){
					unlink($fileName);
					$fileURL = array('filename'=>$filename,'url'=>$fileData['file_url'],'icon'=>'');
				}
			}
		}
		echo json_encode($fileURL);
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
	
	public function file_content(){
		$fileContent = "";
		if(isset($_POST)){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$fileUrl = $this->input->post('file_url');
			if(!empty($fileUrl)){
				$files = explode("/view",$fileUrl);
				if(is_array($files)){
					if(isset($files[0]) && !empty($files[0])){
						$fileAllUrl = explode("/",$files[0]);
						$fileID = array_pop($fileAllUrl);
						if(!empty($fileID)){
							$file = $service->getFileInfo($fileID);
							$fileContent = $service->downloadFile($file);
						}
					}
				}
			}
		}
		echo $fileContent;
		die;
	}
	
	/*public function importing_agreement(){
		if(isset($_POST)){
			$data = array('status'=>0,'message'=>'Wait while importing....');
			$agreementData = $this->input->post();
			$agreementData['created_date'] = date('Y-m-d H:i:s');
			$checkAgreement = $this->opportunity_model->checkAgreement($agreementData['agreement_id']);
			if(count($checkAgreement)>0){
				$data['status'] = $this->opportunity_model->updateAgreement(array('agreement_penalty'=>1),$checkAgreement->id);
			} else {
				$data['status'] = $this->opportunity_model->saveScrappingAgreement($agreementData);
			}
			echo json_encode($data);
		}
		die;
	}*/
	
	public function importing_agreement(){
		if(isset($_POST)){
			$data = array('status'=>0,'message'=>'Wait while importing....');
			if(isset($_POST['agreement_string'])){
				$checkAgreement = $this->opportunity_model->checkAgreement($_POST['agreement_id']);
				if(count($checkAgreement)>0 && $checkAgreement->agreement_royalty==0 && $checkAgreement->agreement_penalty==1){
					$fileName = "sec_aggreements_".time().".html";
					$fh = fopen($_SERVER['DOCUMENT_ROOT']."/public/upload/agreements/".$fileName,"w+");
					fwrite($fh,$_POST['agreement_string']);
					fclose($fh);				
					$curl = curl_init();
					$data['status'] = $this->opportunity_model->updateAgreement(array('agreement_url'=>$fileName,'agreement_string'=>$_POST['agreement_string']),$checkAgreement->id);
					echo json_encode($data);
				}
				
				// Set some options - we are passing in a useragent too here
				/*'damage'=>$other['damage'],
						'syndication_file'=>$other['syndication_file'],*/
				/*curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/scrapping_comparables',
					CURLOPT_USERAGENT => 'Send Request for create demo portfolio',   
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'license_id'=>153,
						'file_name'=>'',
						'payment_terms'=>'',
						'licensor'=>'',
						'licensee'=>'',
						'file_link'=>$fileName
						)
				));		
				$resp = curl_exec($curl);
				$data = array('status'=>$resp,'message'=>'Imported');	*/			
				/*$this->opportunity_model->saveComparable(array('lead_id'=>227,'file_name'=>'','file_link'=>$fileName));*/
				
				/*$this->opportunity_model->saveScrappingAgreement(array('agreement_url'=>$fileName,'agreement_string'=>$_POST['agreement_string'],'created_date'=>date('Y-m-d H:i:s')));
				echo json_encode($data);*/
			}
		}
		die;
	}
	
	public function importDataFromDBTOFILE(){
		$getAgreementList = $this->opportunity_model->getAgreementList();
		if(count($getAgreementList)>0){
			foreach($getAgreementList as $agreement){
				$fh = fopen($_SERVER['DOCUMENT_ROOT']."/public/upload/agreements/".$agreement->agreement_url,"w+");
				fwrite($fh,$agreement->agreement_string);
				fclose($fh);		
			}
		}
	}
	
	public function importAgreementFromExcelFile(){
		$this->load->library('DriveServiceHelper');
		$spreadSheetService = new SpreadsheetServiceHelper();
		$spreadsheet = $spreadSheetService->getSpreadsheetById('1Z0A-S7db5UvWtnr2lq7dTdt8iuNa5haGJ2pUvbqcMQk');
		$allWorkSheet = $spreadSheetService->getAllWorkSheets();
		$workSheetName = "";
		$workSheetName = "Sheet1";
		$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
		$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());
		if(count($asset_data)>0){
			foreach($asset_data as $asset){
				$agreement_royalty = 0;
				$agreement_penalty = 0;
				if($asset['patentroyalty']=="R"){
					$agreement_royalty = 1;
				}
				if($asset['patentroyalty']=="P"){
					$agreement_penalty = 1;
				}
				$data = array('agreement_id'=>$asset['agreementid'],'filling_company'=>$asset['filingcompany'],'sic_code'=>$asset['siccode'],'filing_date'=>$asset['filingdate'],'filing_type'=>$asset['filingtype'],'exhibit_no'=>$asset['exhibitno.'],'agreement_royalty'=>$agreement_royalty,'agreement_penalty'=>$agreement_penalty);
				$this->opportunity_model->updateAgreement($data,$asset['_cn6ca']);
				
				/*echo "<pre>";
				print_r($data);*/
			}
		}
		
		echo "<pre>";
		print_r($asset_data);
		
		die;
	}
	
	
	public function direct_scrap_contacts(){
		$name = explode(' ',$this->input->get('first_name'));
		$saveData = array('first_name'=>$name[0],'last_name'=>$name[1],'email'=>$this->input->get('email'),'company_name'=>$this->input->get('company'),'profile_url'=>$this->input->get('url'),'job_title'=>$this->input->get('job_title'));
		$data = $this->lead_model->insertPreContacts($saveData);
		if($data>0){
		?>
		<script>window.close()</script>
		<?php
		}
		die;
	}
	
	public function free_precontacts(){	
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			if(!empty($this->input->post('text'))){
				$saveData = array('message'=>$this->input->post('text'));
				$data = $this->lead_model->insertFreePreContacts($saveData);
			}
		}
		echo $data;
		die;
	}
	
	public function litigation_scrap(){	
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			if(!empty($this->input->post('text')) && !empty($this->input->post('url'))){
				$saveData = array('data'=>$this->input->post('text'),'url'=>$this->input->post('url'));
				$data = $this->lead_model->insertLitigationScrap($saveData);
			}
		}
		echo $data;
		die;
	}
	
	public function contact_by_linkedinurl(){
		$data = array('salutation'=>0);
		if(isset($_POST) && count($_POST)>0){
			if($_POST['linkedin_url'] != ""){
				$getData = $this->client_model->find_contact_by_linkedin($this->input->post('linkedin_url'));
				$data['salutation'] = $getData->gender;
			}
		}		
		echo json_encode($data);
		die;
	}
	
	public function campaign(){
		$data = array('email'=>array(),'linked_in'=>array()); 
		if(isset($_POST) && count($_POST)>0){
			if((int)$_POST['id']>0){
				$data = $this->lead_model->getCampaign($_POST['id'],$_POST['campaign_type']);
			}else{
				$data['email'] = $this->lead_model->getCampaign($_POST['id'],1);
				$data['linked_in'] = $this->lead_model->getCampaign($_POST['id'],2);
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function delete_address_from_campaign(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$campaignID = $_POST['campaign_id'];
					$to = $_POST['to'];
			$data = $this->lead_model->delete_address_from_campaign($campaignID,$to);
		}
		echo $data;
		die;
	}
	
	public function get_contact_list_by_ids(){
		$getContactList = array();
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			$ids = $postData['ids'];
			$ids = trim($ids);
			if(substr($ids,-1) == ","){
				$ids = substr($ids,0,-1);
			}
			$getContactList = $this->client_model->getContactListByIDs(explode(',',$ids),"id,first_name,last_name,gender,linkedin_image,job_title,linkedin_url");
		}
		echo json_encode($getContactList);
		die;
	}
	
	public function start_campaign(){
		$campaign_id = 0; 
		if(isset($_POST) && count($_POST)>0){
			$campaign = json_decode($_POST['campaign_data'],true);
			$personList = explode(',',$campaign['person']);
			$company = explode(',',$campaign['company']);
			$ids = array();
			if(isset($campaign['ids'])){
				$ids = explode(',',$campaign['ids']);
			}			
			$emailList = explode(',',$campaign['email']);
			$campaign_id = $this->lead_model->insertCampaign(array("lead_id"=>$campaign['lead_id'],"lead_name"=>$campaign['lead_name'],"campaign_type"=>$campaign['campaign_type'],"template_file"=>$campaign['template_file'],"user_id"=>$campaign['user_id'],"subject"=>$campaign['subject'],"body"=>$campaign['body'],"start_date"=>$campaign['start_date']));
			if($campaign_id>0){				   
			  if(count($emailList)>0){
					$insertBatch = array();
				    for($i=0;$i<count($emailList);$i++){
					   if(!empty(trim($emailList[$i]))){
							$contactID = 0;
							if(isset($ids[$i]) && (int)$ids[$i] > 0){
								$contactID = (int)$ids[$i];
							}
							$insertBatch[] = array("campaign_id"=>$campaign_id,"person_name"=>trim($personList[$i]),"company"=>trim($company[$i]),"address"=>trim($emailList[$i]),"contact_id"=>$contactID);
					   }						   
				    }
					$this->lead_model->insertCampaignBatchList($insertBatch);
			   }
			}
		}
		echo $campaign_id;
		die;
	}
	
	public function search_company(){
		$data = array();
		$data = $this->lead_model->getCompanyList($this->input->get('term'),"c.id,c.company_name as label,c.company_name as value");
		echo json_encode($data);
		die;
	}
	
	public function contact_scan_camcard(){
		$data = 0; 
		if(isset($_POST) && count($_POST)>0){
			$getData= $this->input->post();
			$companyName = $getData['company'];
			if(empty($companyName)){
				$companyName = 'N/A';
			}
			/*checkCompany First*/
			if((int)$getData['company_id']==0){
				$checkCompany = $this->customer_model->getCompanyData($companyName);
				if(count($checkCompany)==0){
					$companyID = $this->customer_model->insertCompany(array('company_name'=>$getData['company'],'start_date'=>'0000-00-00 00:00:00','end_date'=>'0000-00-00 00:00:00'));
				} else {
					$companyID = $checkCompany->id;
				}
			} else {
				$companyID = (int)$getData['company_id'];
			}
				
			if($companyID>0){
				$saveData = array('company_id'=>$companyID,'first_name'=>$getData['first_name'],'last_name'=>$getData['last_name'],'email'=>$getData['email'],'img_card'=>json_encode(array($getData['image_url'])),'phone'=>$getData['phone_number'],'telephone'=>$getData['mobile_number'],'job_title'=>$getData['job_title'],'street'=>$getData['address'],'note'=>$getData['note']);
				$data = $this->client_model->insert($saveData);
			}			
		}
		echo $data;
		die;
	}
	
	public function pre_contacts(){
		$data = 0; 
		if(isset($_POST) && count($_POST)>0){
			$saveData = array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'email'=>$_POST['email'],'company_name'=>$_POST['company'],'profile_url'=>$_POST['url'],'c_c'=>$_POST['c_c'],'job_title'=>$_POST['job_title']);
			$data = $this->lead_model->insertPreContacts($saveData);
		}
		echo $data;
		die;
	}
	
	function update_pre_contacts(){ 
		$data = 0; 
		if(isset($_POST) && count($_POST)>0){
			if($_POST['t']=='pre-contact'){
				/*$saveData = array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'email'=>$_POST['email'],'company_name'=>$_POST['company'],'profile_url'=>$_POST['url'],'address'=>$_POST['address'],'job_title'=>$_POST['job_title'],'telephone'=>$_POST['telephone'],'cellphone'=>$_POST['phone']);*/
				$saveData = array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'email'=>$_POST['email'],'company_name'=>$_POST['company'],'profile_url'=>$_POST['url'],'job_title'=>$_POST['job_title'],'telephone'=>$_POST['telephone'],'cellphone'=>$_POST['phone']);
				/*$saveData = array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'company_name'=>$_POST['company'],'job_title'=>$_POST['job_title']);*/
				$data = $this->lead_model->updatePreContacts($saveData,$_POST['id']);
			} else if($_POST['t']=='contact'){
				/*$saveData = array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'email'=>$_POST['email'],'linkedin_url'=>$_POST['url'],'address'=>$_POST['address'],'job_title'=>$_POST['job_title'],'telephone'=>$_POST['telephone'],'phone'=>$_POST['phone']);*/
				$saveData = array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'email'=>$_POST['email'],'linkedin_url'=>$_POST['url'],'job_title'=>$_POST['job_title'],'telephone'=>$_POST['telephone'],'phone'=>$_POST['phone']);
				/*$saveData = array('first_name'=>$_POST['first_name'],'last_name'=>$_POST['last_name'],'job_title'=>$_POST['job_title']);*/
				$data = $this->lead_model->updateContact($saveData,$_POST['id']);
			}
		}
		echo $data;
		die;
	}
	
	function save_process_campaign(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){			
			if(isset($_POST['lead_id']) && (int)$_POST['lead_id']>0){
				if(isset($_POST['to'])){
					$to = trim($_POST['to']);
					if(!empty($to)){
						$checkCampaign = $this->lead_model->checkCampaignProcess($this->input->post('campaign_id'));
						if($checkCampaign==0){
							$data = $this->lead_model->insertCampaignProcess($this->input->post());
						}						
					}
				}
			}
		}
		echo $data;
		die;
	}
	
	function findEmailImapSearch(){
		$folder = '[Gmail]/Sent Mail';
		$emailAddress = 'webmaster@synpat.com';
		$time = date('D, d M Y',strtotime('-5 days',strtotime('now')));
		$data = array('send'=>0);
		$hostname = 'imap.gmail.com:993';
		$this->config->load('config');
		$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl','folder'=>$folder);
		$this->load->library('Imap',$params);
		$s = 0;
		if($this->imap->isConnected()){
			/*$this->imap->selectFolder('[Gmail]/Sent Mail');*/
			/*$messages = $this->imap->getMessages();*/
			echo $q = "TO (".$emailAddress.") SINCE  ".$time."  00:00:00";
			$messages = $this->imap->imapSearch($q);
			echo "<pre>";
			print_r($messages);
		}
		die;
	}
	
	function findEmailImapSendBox($subject,$toUsers,$date,$leadID,$type=1,$sendFrom =0,$userID){
		$data = array('send'=>0);
		$hostname = 'imap.gmail.com:993';
		$this->config->load('config');
		$params = array('mailbox'=>$hostname,'username'=>$this->config->item('license_email'),'password'=>$this->config->item('license_password'),'encryption'=>'ssl');
		$this->load->library('Imap',$params);
		$s = 0;
		$mainMessage=array();
		if($this->imap->isConnected()){
			$this->imap->selectFolder('[Gmail]/Sent Mail');
			$messages = $this->imap->getMessages();
			if(count($messages)>0){
				for($m=count($messages)-1;$m>=0;$m--){
					if($messages[$m]['subject']==$subject){						
						$toSendBox = $messages[$m]['to'];
						foreach($toSendBox as $to){
							if(count($toUsers)>0){
								for($i=0;$i<count($toUsers)-1;$i++){
									if(!empty(trim($toUsers[$i])) == trim($to)){
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
					$attachmentBody = $this->imap->getAttachment($mainMessage['uid'],$a);
					if(isset($attachmentBody['content'])&& !empty($attachmentBody['content'])){
						$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
						fwrite($fh, $attachmentBody['content']);
						fclose($fh);
						$finfo = finfo_open(FILEINFO_MIME_TYPE); 
						$mimeType = finfo_file($finfo, $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename);
						$filesAttachment .=$this->config->base_url()."public/upload/".$filename.",";
						$attachmentsConnect[] = array('filename'=>$_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename,'mimeType'=>$mimeType,"attachmentId"=>$a,"size"=>$attachmentBody['size']);
					}
					$a++;
				}
			}
			$mainMessage['attachments'] = $attachmentsConnect;
			$saveData = array('content'=>json_encode($mainMessage),'file_attach'=>$filesAttachment,"lead_id"=>$leadID,"user_id"=>$userID,"date_received"=>date('Y-m-d H:i:s', strtotime($mainMessage['date'])),'type'=>1,'sent_from'=>1,'account_type'=>'2');
			$sendData = $this->lead_model->insertBox($saveData);
			if($sendData>0){
				$data = array('send'=>$sendData);
			}
		}
		return json_encode($data);
	}
	
	public function update_campaign_skip(){
		$data = 0; 
		if(isset($_POST) && count($_POST)>0){
			if(isset($_POST['campaign_id']) && (int)$_POST['campaign_id']>0){
				if(isset($_POST['id'])){
					$to = $_POST['id'];
					if($to > 0){
						$data = $this->lead_model->updateCampaignListByID($to,array('send'=>$_POST['send'],'open'=>0,'proccessed'=>$_POST['proccessed']));
					}
				}
			}
		}
		echo $data ;
		die;
	}
	
	public function update_campaign_addresss_send(){
		$data = 0; 
		if(isset($_POST) && count($_POST)>0){
			if(isset($_POST['campaign_id']) && (int)$_POST['campaign_id']>0){
				if(isset($_POST['to'])){
					$to = trim($_POST['to']);
					if(!empty($to)){
						$data = $this->lead_model->updateCampaignList($_POST['campaign_id'],$to,array('send'=>$_POST['send'],'open'=>0,'proccessed'=>$_POST['proccessed'],'email_id'=>$_POST['email_id']));
					}
				}
			}
		}
		echo $data ;
		die;
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
	
	public function sales_activity_email_save(){
		$data = 0; 
		if(isset($_POST) && count($_POST)>0){			
			if(isset($_POST['lead_id']) && (int)$_POST['lead_id']>0){
				if(isset($_POST['to'])){
					$to = trim($_POST['to']);
					if(!empty($to)){
						$message = "";
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
							if(isset($_POST['body'])){
								$note = $_POST['body'];
							}
							if(isset($_POST['subject'])){
								$subject = $_POST['subject'];
							}
							if(isset($_POST['file_html']) && !empty($_POST['file_html'])){
								$note = $note."<br/><a href='".$_POST['file_html']."' target='_blank' style='color:#2196f3'>File</a>";
							}
							
							$date = date('Y-m-d H:i:s');
							$email_id = 0 ;
							if((int)$_POST['type']==3){
								$send = $this->findEmailImapSendBox($subject,array($to,""),$date,$_POST['lead_id'],1,1,$_POST['user_id']);
								$dataSend = json_decode($send,true);
								if(isset($dataSend['send'])){
									$email_id = $dataSend['send'];
								} else if(isset($dataSend->send)){
									$email_id = $dataSend->send;
								}
							}
							$saveData = array('lead_id'=>$_POST['lead_id'],'company_id'=>$getContact->company_id,'contact_id'=>$getContact->id,'type'=>$_POST['type'],'note'=>$note,'user_id'=>$_POST['user_id'],'subject'=>$subject,'activity_date'=>$date,"email_id"=>$email_id);		
							if((int)$_POST['main_activity']==2){
								$data = $this->lead_model->insertAcquistionActivity($saveData);
							} else {
								/*$saveData['note'] = '<div>'.$note.'</div>';*/
								$data = $this->lead_model->insetSalesActivity($saveData);
							}
							$this->activityLog($saveData);
							if($data>0){
								$this->lead_model->updateCampaignList($_POST['campaign_id'],$to,array('send'=>1,'proccessed'=>1));
								$user_history = array('lead_id'=>$_POST['lead_id'],'user_id'=>$_POST['user_id'],'message'=>$message,'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
								$this->user_model->addUserHistory($user_history);
							}							
						}
					}
				}
			}
		}
		echo $data;
		die;
	}
	
	function docketDocumentSalesActivity(){
		$data = array("error"=>1,"id"=>0,"message"=>"Server busy, Please try after sometime.");
		if(isset($_POST) && count($_POST)>0){
			if(isset($_POST['le']) && (int)$_POST['le']>0 && (int)$_POST['p']>0){
				$getContact = $this->client_model->getInfo($_POST['p']);
				$getLeadInfo = $this->lead_model->getLeadData($_POST['le']);
				if(count($getContact)>0){
					$note = $_POST['m'];
					if(isset($_POST['file'])&& !empty($_POST['file'])){
						$note = $note.'<br/><a  href="javascript://" data-file-id="'.$_POST['i'].'" onclick=\'open_drive_files("'.trim($_POST['file']).'");\' data-href="'.$_POST['file'].'" data-mime="'.$_POST['mime'].'" target="_blank" style="color:#2196f3"><i class="glyph-icon tooltip-button pull-left icon-file-o"></i>&nbsp;&nbsp;'.$_POST['title'].'</a>';				
						$saveData = array('lead_id'=>$_POST['le'],'company_id'=>$getContact->company_id,'contact_id'=>$getContact->id,'type'=>6,'note'=>$note,'user_id'=>$this->session->userdata['id'],'subject'=>$getLeadInfo->lead_name,'activity_date'=>date('Y-m-d H:i:s'));
						$dataSales = $this->lead_model->insetSalesActivity($saveData);
						$this->activityLog($saveData);
						if($dataSales>0){
							$data = array("error"=>0,"id"=>$dataSales,"message"=>"");
							$user_history = array('lead_id'=>$_POST['le'],'user_id'=>$this->session->userdata['id'],'message'=>'Add Email in sales activity','opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);
						}
					}	
				}				
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function create_account(){
		$post = $this->input->post();
		if(isset($post['email']) && !empty($post['email'])){
			/*$checkUser = $this->customer_model->checkEmail($post['email']);			
			if($checkUser==0){
				unset($post['confirm_password']);
				unset($post['captcha']);
				$post['create_date'] = date('Y-m-d H:i:s');
				$post['password'] = md5($post['password']);
				$checkCompany = $this->customer_model->checkCompanyExist($post['company_name']);
				if($checkCompany==0){
					$companyID = $this->customer_model->insertCompany(array('company_name'=>$post['company_name'],'company_address'=>$post['company_address']));
					if($companyID>0){
						$post['company_id'] = $companyID;
						unset($post['company_name']);
						unset($post['company_address']);
						$id = $this->customer_model->insertCustomer($post);
						if($id>0){
							echo json_encode(array("error"=>'User saved successfully',"id"=>$id));
						} else {
							echo json_encode(array("error"=>'Server is busy. Please try after sometime.',"id"=>0));
						}
					} else {
						echo json_encode(array("error"=>'Server busy, Please try after sometime.',"id"=>0));
					}
				} else {
					echo json_encode(array("error"=>'Company already exist.',"id"=>0));
				}
			} else {
				echo json_encode(array("error"=>'Email is already exist.',"id"=>0));
			}*/
			/*Store In Temporary Data*/
			/*$checkUserFromTempTable = $this->customer_model->checkEmailFromRequest($post['email']);
			if($checkUserFromTempTable==0){*/
				unset($post['confirm_password']);
				unset($post['captcha']);
				$post['create_date'] = date('Y-m-d H:i:s');
				$post['password'] = md5($post['password']);
				$id=$this->customer_model->insertCustomerRequest($post);
				if($id>0){
					/*Push Notification for customer request*/
					require(APPPATH.'third_party/push/autoload.php');
					$this->config->load('config');
					$options = array('encrypted' => true,'cluster' => $this->config->item('APP_CLUSTER'),'host'=>$this->config->item('APP_CLUSTER_HOST'));
					$pusher = new Pusher($this->config->item('PUSHER_APP_ID'),$this->config->item('PUSHER_APP_KEY'),$this->config->item('PUSHER_APP_SECRET'),$options);
					$showData = array('action'=>'create_customer','data'=>'');
					$data = array();
					$data['message'] = json_encode($showData);
					$pusher->trigger('notifications', 'new_notification', $data);
					echo json_encode(array("error"=>'User saved successfully',"id"=>$id));
				} else {
					echo json_encode(array("error"=>'Server is busy. Please try after sometime.',"id"=>0));
				}
			/*} else {
				echo json_encode(array("error"=>'Email already exists.',"id"=>0));
			}*/
		} else {
			echo json_encode(array("error"=>'Data is not valid. Please try after sometime.',"id"=>0));
		}
		die;
	}
	
	public function delete_customer(){
		$post = $this->input->post();
		$data = 0;
		if(isset($post['token']) && !empty($post['token'])){
			$decodeToken = base64_decode($post['token']);
			$explodeToken = explode('&&&',$decodeToken);
			if(count($explodeToken)==3){
				if((int)$explodeToken[1]>0){
					$getCustomerInfo = $this->lead_model->getCustomerInfoByID($explodeToken[1],'c.email,c.company_id,c.id');
					if($getCustomerInfo>0){
						$data = $this->customer_model->deleteCustomer($getCustomerInfo->id);
						/*$this->deletePermissionFromStoreCustomerFile($getCustomerInfo->company_id,$getCustomerInfo->email);*/
					}					
				}
			}
		}
		echo $data;
		die;
	}
	
	function deleteCustomerRequest(){
		$post = $this->input->post();
		$data = 0;
		if(isset($post['s']) && !empty($post['s'])){
			if((int)$post['s']>0){
				$data = $this->customer_model->deleteCustomerRequest($post['s']);
			}
		}
		echo $data;
		die;
	}
	
	public function login(){
		$post = $this->input->post();
		if(isset($post['email']) && !empty($post['email']) && isset($post['password']) && !empty($post['password'])){
			$checkUser = $this->customer_model->login($post['email'],md5($post['password']));	
			if(count($checkUser)>0){				
				if((int)$checkUser->status==1){
					echo json_encode(array("error"=>'Please make sure the email address and password you provided relate to an activated account. If you have not yet received an activation email you may either contact SynPat customer relations by phone or at customers@synpat.com.',"id"=>0));
				} else if((int)$checkUser->status==0){
					echo json_encode(array("error"=>'',"id"=>1,"data"=>$checkUser));
				} else {
					echo json_encode(array("error"=>'You account is suspended. Please wait.',"id"=>0));
				}				
			} else {
				echo json_encode(array("error"=>'Email or Password is wrong.',"id"=>0));
			}
		} else {
			echo json_encode(array("error"=>'Data is not valid. Please try after sometime.',"id"=>0));
		}
		die;
	}
	
	public function user_bulk_add_and_personal_password(){
		$postData = $this->input->post();
		$post = json_decode($postData ['post_data']);
		$successUser = array();
		$errorUser = array();
		$error = "";
		$insertUsers = array();
		if(isset($post->first_name) && count($post->first_name)>0){
			for($i=0;$i<count($post->first_name);$i++){
				if(!empty($post->first_name[$i]) && !empty($post->email_address[$i])){
					$checkUser = $this->customer_model->checkEmail($post->email_address[$i]);			
					if($checkUser==0){
						$user = array();
						$user['first_name'] = $post->first_name[$i];
						$user['last_name'] = $post->last_name[$i];
						$user['email'] = $post->email_address[$i];
						$user['phone_number'] = $post->phone_number[$i];
						$user['password'] = md5('123456');
						$user['status'] = $post->status;
						$user['company_id'] = $post->company_id;
						$user['create_date'] = date('Y-m-d H:i:s');
						$userID = $this->customer_model->insertCustomer($user);
						if($userID>0){
							$insertUsers[] = $userID;
							unset($user['create_date']);
							unset($user['status']);
							unset($user['password']);
							$user['phone'] = $user['phone_number'];
							unset($user['phone_number']);
							$this->client_model->insert($user);
							$successUser[] = $user['email'];
							$error = "";
						} else {
							$error = "Server busy, Please try after sometime.";
						}
					} else {
						$errorUser[] = $post->email_address[$i];
					}
				}
			}
			if(count($insertUsers)>0){
				/*$this->giveStoreCustomerFilePermissionsToUsers($insertUsers);*/
			}
		}
		if(isset($post->change_password) && $post->change_password=='1'){
			if(isset($post->old_password) && !empty($post->old_password) && !empty($post->new_password)){
				$checkUserInfo = $this->customer_model->checUserDetail($post->login_user);
				if(count($checkUserInfo)>0){
					if(md5($post->old_password) == $checkUserInfo->password){
						if(!empty($post->new_password) && !empty($post->confirm_password) && $post->new_password == $post->confirm_password){
							$data['password'] = md5($post->new_password);
							$updateUserInfo = $this->customer_model->updateUserInfo($checkUserInfo->id,$data);
							if($updateUserInfo>0){
								$errorPersonalInfo = "";
								$successPersonalInfo = "Successfully update your password.";
							} else {
								$errorPersonalInfo = "Server busy, Please try after sometime.";
								$successPersonalInfo = "";
							}
						} else {
							$errorPersonalInfo = "Password and confirm password not match.";
							$successPersonalInfo = "";
						}
					} else {
						$errorPersonalInfo = "Old password doesn't match.";
							$successPersonalInfo = "";
					}
				} else {
					$errorPersonalInfo = "Server busy, Please try after sometime.";
					$successPersonalInfo = "";
				}
			} else {
				$errorPersonalInfo = "Old password cannot be left blank.";
				$successPersonalInfo = "";
			}
		}
		if(isset($post->change_details) && $post->change_details=='1'){
			if(!empty($post->my_first_name) && !empty($post->my_phone_number)){
				$checkUserInfo = $this->customer_model->checUserDetail($post->login_user);
				$updateUserInfo = $this->customer_model->updateUserInfo($checkUserInfo->id,array('first_name'=>$post->my_first_name,'last_name'=>$post->my_last_name,'phone_number'=>$post->my_phone_number));
				if($updateUserInfo>0){
					$errorPersonalInfo = "";
					$successPersonalInfo = "Successfully update your information.";
				} else {
					$errorPersonalInfo = "Server busy, Please try after sometime.";
					$successPersonalInfo = "";
				}
			}
		}
		if(isset($post->company_address) && !empty($post->company_address) && !empty($post->telephone) && !empty($post->bank_name) && !empty($post->bank_account_no) && !empty($post->routing_no)){
			$this->customer_model->updateCompanyData($post->company_id,array("company_address"=>$post->company_address,'telephone'=>$post->telephone,'bank_name'=>$post->bank_name,'bank_account_no'=>$post->bank_account_no,'routing_no'=>$post->routing_no));
		}
		echo json_encode(array("all_messages"=>array("personal_detail"=>array("error"=>$errorPersonalInfo,"success"=>$successPersonalInfo)),"userDetail"=>array("error"=>$error,"errorUser"=>$errorUser,"successUser"=>$successUser)));
		die;
	}
	
	public function check_activation_code(){
		$post = $this->input->post();
		$data = array();
		if(isset($post['code']) && !empty($post['code'])){
			$data= $this->customer_model->checkActivationCode($post['code']);
		}
		echo json_encode($data);
		die;
	}
	
	public function customer_request_activate_activation_code(){
		$post = $this->input->post();
		$send = array('act'=>0);
		if(isset($post['code']) && !empty($post['code'])){
			$data = $this->customer_model->customerRequestActivationCode($post['code']);
			if(count($data) > 0){
				$send['act'] = $this->customer_model->updateCustomerRequest($data->id,array('activation_code'=>''));
			}
		}
		echo json_encode($send);
		die;
	}
	
	public function update_password(){
		$post = $this->input->post();
		$dataUpdated = 0;
		if(isset($post['activation_code']) && !empty($post['activation_code'])){
			$data= $this->customer_model->checkActivationCode($post['activation_code']);
			if(count($data)>0){
				if($post['new_password'] == $post['confirm_password']){
					$dataUpdated = $this->customer_model->updateUserInfo($data->id,array('password'=>md5(trim($post['new_password'])),'activation_code'=>''));
					if($dataUpdated==0){
						$dataUpdated = $this->customer_model->updateUserInfo($data->id,array('activation_code'=>$post['activation_code']));
					}
				}
			}			
		}
		echo $dataUpdated;
		die;
	}
	
	public function check_user_email(){
		$post = $this->input->post();
		$data = array();
		if(isset($post['email']) && !empty($post['email'])){
			$checkUserInfo= $this->customer_model->checkEmail($post['email'],0);			
			if(count($checkUserInfo)>0){
				$userData['activation_code'] = md5($checkUserEmail->email."@@".mt_rand(15,80));
				$userUpdate = $this->customer_model->updateUserInfo($checkUserInfo->id,$userData);
				if($userUpdate>0){
					$data = $this->customer_model->checkEmail($post['email'],0);
				}				
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function dashboard(){
		$post = $this->input->post();
		$data = array("users"=>array(),"wishlist"=>array(),"preferences"=>array(),"portfolios"=>array());
		if(count($post)>0){
			if(isset($post['company_id']) && (int) $post['company_id']>0){
				$data['users'] = $this->customer_model->getUsersList($post['company_id']);
			}
			if(isset($post['customer_id']) && (int)$post['customer_id']>0){
				$getAllPortfolioIDs = $this->customer_model->getCustomerWishListIDs($post['customer_id']);
				
				if(count($getAllPortfolioIDs)>0){
					$data['wishlist'] = $this->acquisition_model->getAllPortfoliosWithIDs($getAllPortfolioIDs);						
				}
				$data['preferences'] = $this->customer_model->findMyPreferenceWithName($post['customer_id']);
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function usersListInCompany(){
		$post = $this->input->post();
		$getUsersList = array();
		if(count($post)>0){
			if(isset($post['company_id']) && (int) $post['company_id']>0){
				$getUsersList = $this->customer_model->getUsersList($post['company_id']);
			}
		}
		echo json_encode($getUsersList);
		die;
	}
	
	public function insertMyPreference(){
		$post= $this->input->post();
		$data = 0;
		if(isset($post['all_preference'])){
			$preference = json_decode($post['all_preference']);
			if(count($preference)>0){
				$this->customer_model->deleteCustomerPreference($post['customer_id']);
				foreach($preference as $pref){
					if((int)$pref>0){
						$data = $this->customer_model->insertCustomerPreference(array("customer_id"=>$post['customer_id'],"preference_id"=>$pref));
					}
				}
			}
		}
		$getMyPreference = $this->customer_model->findMyPreference($post['customer_id']);
		echo json_encode(array("preference"=>$getMyPreference,"data"=>$data));
		die;
	}
	
	function addToWishList(){
		$post= $this->input->post();
		$data = "";
		if(isset($post['token'])){
			$token =  $post['token'];
			$decodeValue = base64_decode($token);
			$explodeDecodeValue = explode('&&&',$decodeValue);
			if(count($explodeDecodeValue)==3){
				$checkUser = $this->customer_model->checkUserWithIDAndEmail($explodeDecodeValue[1],$explodeDecodeValue[2]);
				if(count($checkUser)>0){
					$checkProductInWhishList = $this->customer_model->checkWishList($explodeDecodeValue[0],$explodeDecodeValue[1]);
					
					if(count($checkProductInWhishList)==0){
						$saveToWishList = $this->customer_model->insertWishlist(array('portfolio_id'=>$explodeDecodeValue[0],'customer_id'=>$explodeDecodeValue[1]));
						if($saveToWishList>0){
							$data = "This product is added in your wishlist.";
						}
					} else {
						$data = "This product is already in your wishlist.";
					}					
				} else {
					$data = "Server busy, Please try after sometime.";
				}
			} else {
				$data = "Server busy, Please try after sometime.";
			}
		}
		echo $data;
		die;
	}
	
	function removeToWishList(){
		$post= $this->input->post();
		$data = 0;
		if(isset($post['token'])){
			$token =  $post['token'];
			$decodeValue = base64_decode($token);
			$explodeDecodeValue = explode('DELETE',$decodeValue);
			if(count($explodeDecodeValue)==3){
				$checkUser = $this->customer_model->checUserDetail($explodeDecodeValue[2]);
				if(count($checkUser)>0){
					$checkProductInWhishList = $this->customer_model->checkWishList($explodeDecodeValue[1],$explodeDecodeValue[2]);
					if(count($checkProductInWhishList)>0){
						$saveToWishList = $this->customer_model->deleteWishlist($checkProductInWhishList->id);
						if($saveToWishList>0){
							$data = $saveToWishList;
						}
					}				
				} 
			} 
		}
		echo $data;
		die;
	}
	
	function getCustomerWishList(){
		$post= $this->input->post();
		$getData = array();
		if(isset($post['customer_id']) && (int)$post['customer_id']>0){
			$getAllPortfolioIDs = $this->customer_model->getCustomerWishListIDs($post['customer_id']);
			if(count($getAllPortfolioIDs)>0){
				$getData = $this->acquisition_model->getAllPortfoliosWithIDs($getAllPortfolioIDs);	
			}
		}
		echo json_encode($getData);
		die;
	}
	
	public function getPreference($customerID){
		$post= $this->input->post();
		$getMyPreference = array();
		if(isset($post['customer_id'])){
			$getMyPreference = $this->customer_model->findMyPreference($post['customer_id']);
		}
		echo json_encode($getMyPreference);
		die;
	}
	
	public function getCategoryList(){
		$post = $this->input->post();
		$category = 0;
		if(isset($post['category'])){
			$cat = explode('-',$post['category']);
			if(count($cat)==2){
				$category = (int)$cat[1];
			}
		}
		$getCategory = $this->customer_model->getCategoryBySector(21);
		if(count($getCategory)>0){
			for($i=0;$i<count($getCategory);$i++){
				$getCategory[$i]->child_list = $this->customer_model->categoryList($getCategory[$i]->id);
			}
		}
		
		$productList = array();
		if($category>0){
			$productList = $this->acquisition_model->findPortfolios($category);			
		}
		$invitationProduct= array();
		if($post['invitation']>0){
			$invitationProduct= $this->lead_model->findPortfolioWithSerial($post['invitation']);
		}		
		$data = array('categories'=>$getCategory,'products'=>$productList,'invitation_product'=>$invitationProduct);
		/*echo "<pre>";print_r($productList);print_r($invitationProduct);die;*/
		echo json_encode($data);
		die;
	}
	
	public function get_demo_portfolios(){
		$demoProducts = $this->lead_model->findDemoPortfolioWithSerialList(array(73182,72101,22232,85865));
		echo json_encode(array('demo_product'=>$demoProducts));
		die;
	}
	
	public function deactivate_all_users($ID=null){
		$data = 0;
		if($ID!=null){
			$getAllUsersInCompany = $this->customer_model->customersList($ID);
			if(count($getAllUsersInCompany)>0){
				foreach($getAllUsersInCompany as $user){
					$data = $this->customer_model->updateUserInfo($user->id,array('status'=>1));
				}
			}
		}
		echo $data;
		die;
	}
	public function activate_all_users($ID=null){
		$data = 0;
		if($ID!=null){
			$getAllUsersInCompany = $this->customer_model->customersList($ID);
			if(count($getAllUsersInCompany)>0){
				foreach($getAllUsersInCompany as $user){
					$data = $this->customer_model->updateUserInfo($user->id,array('status'=>0));
				}
			}
		}
		echo $data;
		die;
	}
	
	
	public function companies_list(){
		if(!isset($this->session->userdata['type'])){
			if(!isset($_SESSION)){
				session_start();
			}
			if(isset($_SESSION['find_user']) && !empty($_SESSION['find_user']['type'])){
				$this->session->set_userdata($_SESSION['find_user']);
			} else {
				redirect('login');
			}
		} else if((int)$this->session->userdata['type']!=9){
			$this->session->set_flashdata('error','You are not authorized user to view this page.');
			redirect('dashboard');
		}
		$this->layout->auto_render=false;
		$this->layout->layout='outsource';		
		$data['companies'] = $this->customer_model->getAllCustomerCompanyList();
		$data['customer_request'] = $this->customer_model->getAllCustomerRequest();
		$data['membership_payment'] = $this->customer_model->getAllMembersipPayments();
		/*$data['company_list'] = $this->customer_model->companyList();
		$data['sector_list'] = $this->general_model->getAllSector();*/
		$this->layout->title_for_layout = 'SynPat Companies List';
		$this->layout->render('customer/companies_list',$data);
	}
	
	public function update_membershhip() {
		$data = array('id'=>0);
		if(isset($_POST) && count($_POST) > 0) {
			$postData = $this->input->post();
			$updateData = array();
			$updateData[$postData['field']] =  $postData['v'];
			$data['id'] = $this->customer_model->updateMembership($updateData,$postData['id']);
		}		
		echo json_encode($data);
		die;
	}
	
	public function update_customer_membership() {
		$data = array('id'=>0);
		if(isset($_POST) && count($_POST) > 0) {
			$postData = $this->input->post();
			$getMembershipData = $this->customer_model->getMembershipData($postData['i']);
			if(count($getMembershipData) > 0) {
				$membershipType = $getMembershipData->membership_type;
				$numberOfYears = $getMembershipData->no_of_years;
				$startDate = $getMembershipData->enter_effective_date;
				$file = $getMembershipData->file;
				$amount = $getMembershipData->amount;
				$submitRequest = $getMembershipData->create_date;
				$membership = 0;
				if($membershipType == "Licensees") {
					$membership = 1;
				} else if($membershipType == "Participants") {
					$membership = 2;
				}
				$expiryDate = date('Y-m-d',strtotime('+ '.$numberOfYears.' years',strtotime($startDate)));
				$updateData = array(
					'file'=>$file,
					'amount'=>$amount,
					'start_date'=>$startDate,
					'end_date'=>$expiryDate,
					'request_date'=>date('Y-m-d',strtotime($submitRequest)),'membership'=>$membership);
				$data['id'] = $this->client_model->updateCompanyLogo($updateData,$getMembershipData->company_id);
				if($data['id'] > 0) {
					$this->customer_model->deleteMembershipPayments($postData['i']);
				}
			}
		}		
		echo json_encode($data);
		die;
	}
	
	public function get_all_customers($companyID = null){
		$users_list = $this->customer_model->customersList($companyID);
		echo json_encode($users_list);
		die;
	}
	
	public function find_departments(){
		$data= array('dep'=>array(),'c_d'=>array());
		if(isset($_POST) && count($_POST)>0){
			if((int)$this->input->post('s')>0){
				$data['dep'] = $this->general_model->getSectorDepartmentsName($this->input->post('s'));
			}
			if((int)$this->input->post('c')>0){
				$data['c_d'] = $this->customer_model->findMyPreference($this->input->post('c'));
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function find_sub_deptt(){
		$data= array('dep'=>array(),'c_d'=>array());
		if(isset($_POST) && count($_POST)>0){
			if(count($this->input->post('s'))>0){
				$deptt = implode(',',$this->input->post('s'));
				$data['dep'] = $this->customer_model->categoryListWithMoreThanOne($deptt);
			}
			if((int)$this->input->post('c')>0){
				$data['c_d'] = $this->customer_model->findMyPreference($this->input->post('c'));
			}
		}
		echo json_encode($data);
		die;
	}
	public function find_sub_deptt_another(){
		$data= array('dep'=>array(),'c_d'=>array());
		if(isset($_POST) && count($_POST)>0){
			if(count($this->input->post('s'))>0){
				$deptt = implode(',',json_decode($this->input->post('s'),true));
				$data['dep'] = $this->customer_model->categoryListWithMoreThanOne($deptt);
			}
			if((int)$this->input->post('c')>0){
				$data['c_d'] = $this->customer_model->findMyPreference($this->input->post('c'));
			}
		}
		echo json_encode($data);
		die;
	}
	public function myTransaction(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			if((int)$this->input->post('customer_id')>0){
				$data = $this->general_model->getAllTransactionByContactID($this->input->post('customer_id'));
			}
		}
		echo json_encode($data,true);
		die;
	}
	
	public function last_page_no(){
		$resultOver = $this->general_model->getCountInsertedData();
		echo $resultOver + 1;
		die;
	}
	
	public function extension_linkedin_scrap(){
		$data = array('page_no'=>0,'saved'=>0);
		if(isset($_POST) && count($_POST)>0){
			$scrap = $this->input->post('scrap');
			$saved = 0;
			if(!empty($scrap)){
				$result = json_decode($scrap);
				if(count($result)>0){
					for($i=0;$i<count($result);$i++){
						$record = array("name"=>(string)$result[$i]->name,"company_name"=>(string)$result[$i]->company_name,"job_title"=>(string)$result[$i]->job_title,"profile_url"=>(string)$result[$i]->profile_url,"c_c"=>(int)$result[$i]->c_c,"distance"=>(int)$result[$i]->distance);
						$saved = $this->general_model->insertLinkedinContacts($record);
					}
				}
			}
			$this->general_model->updatePageNo(1,array('page_no'=>$this->input->post('page_no')));
			$resultOver = $this->general_model->getCountInsertedData();
			$data = array('page_no'=>$resultOver+1,'saved'=>$saved);
		}
		echo json_encode($data);
		die;
	}
	
	function bounce_email(){
		$fileName = $_SERVER['DOCUMENT_ROOT'].'/public/upload/bounce.json';
		$f = fopen($fileName,"w+");
		$data= $_POST;
		fwrite($f,json_encode($data));
		fclose($f);
		if($data['event']=="dropped"){
			$messageID = $data['Message-Id'];
			$this->load->model('outsource_model');
			$checkDropEmail = $this->outsource_model->checkProjectDataWithMessageID($messageID);
			if(count($checkDropEmail)>0){
				$this->outsource_model->updateFormData(array('data'=>'','enter_by'=>'Free','user_id'=>0,'recorded_date'=>'0000-00-00 00:00:00','message_id'=>''),$checkDropEmail->id);
				/*$this->load->model('client_model');*/
				$this->outsource_model->deleteProjectColUserAmount($checkDropEmail->user_id,$checkDropEmail->col,$checkDropEmail->project_id);
				unset($checkDropEmail->id);
				$this->outsource_model->uploadDataToDropHistory($checkDropEmail);
				$this->client_model->update($checkDropEmail->contact_id,array('email'=>'','new_email'=>0));
			}
		}		
		die;
	}
	
	function getEventCalendar(){
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
	
	function insert_event(){
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');	
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
			$event['reminders'] = array(
									'useDefault' => FALSE,
									'overrides' => array(
									  array('method' => 'popup', 'minutes' => 10),
									),
								  );
			$startDateEvent = $event['start_date']." ".$event['start_time'];
			unset($event['end_time']);
			unset($event['end_date']);
			unset($event['start_time']);
			unset($event['start_date']);
			$eventID = $event['id'];
			unset($event['id']);
			if($eventID==""){
				$eventRes = $service->insert_event($event);
			} else {
				$eventRes = $service->update_event($event,$eventID);
			}	
			if(is_object($eventRes)){
				if(isset($eventRes->htmlLink)){					
					echo json_encode(array('link'=>$eventRes->htmlLink));
				}					
			}
		}
		die;
	}
	
	function getCalendarEvent(){
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
					$eventsAllUsersList[] = array('user_id'=>$userEtag,'allDay'=>$allDay,'backgroundColor'=>$userBackgroundColor,'color'=>$userForegroundColor,'textColor'=>$userForegroundColor,'start'=>$event->start->dateTime,'end'=>$event->end->dateTime,'event_id'=>$event->id,'id'=>$event->etag,'title'=>ucfirst($_name[0]).', '.$event->summary.", ".$event->location);
				}
				
			}
		}
		$data= json_encode($eventsAllUsersList);
		echo $data;
		die;
	}
	
	
	public function scrapData($getPatentNumber){
		/*$getPatentNumber = $this->input->post('scrap_data');*/
		if(!empty($getPatentNumber)){
			$this->scrapDataGooglePatent($getPatentNumber);
		}
		die;
	}
	private function sort_array_of_array(&$array, $subfield){
		$sortarray = array();
		foreach ($array as $key => $row)
		{
			$sortarray[$key] = $row[$subfield];
		}

		array_multisort($sortarray, SORT_ASC, $array);
	}
	
	private function findIndex($array,$findValue){
		$findArray = array();
		foreach($array as $list){
			if($list->id == $findValue){
				array_push($findArray,$list);
				break;
			}
		}
		return $findArray;
	}
	
	private function findUpdateBankAxis($startIndex,$list,$start){
		$bankIndex = array();
		$companyIndex = array();
		$max = -1;
		if(isset($list[$startIndex])){
			$yAxis = 0;
			for($i=$startIndex;$i<count($list);$i++){
				if($i == $startIndex){
					$yAxis = $list[$i]->y_axis;
				}
				if($list[$i]->y_axis == $yAxis) {
					if(strpos(strtolower($list[$i]->description),"security interest") !== false && strpos(strtolower($list[$i]->description),"release") === false) {
						array_push($bankIndex,$i);
					} else {
						array_push($companyIndex,$i);
					}
				} else {
					break;
				}
			}		
			$constantValue = 220;
			if(count($bankIndex) > 0 && count($companyIndex) == 0) {
				$s = 0;			
				foreach($bankIndex as $bIndex) {
					$xAxis = 290;
					if($s > 0) {
						$xAxis = $list[$bIndex-1]->x_axis + $constantValue;
					}
					if((int)$xAxis > 0) {
						$list[$bIndex]->old_x_axis = $list[$bIndex]->x_axis;
						$list[$bIndex]->x_axis = $xAxis;
					}
					$s++;
				}
				$max = max($bankIndex);
			} else if(count($bankIndex) > 0 && count($companyIndex) > 0) {
				$allC = array_merge($bankIndex,$companyIndex);
				$max = max($allC);
				if($start === false) {
					if(in_array($startIndex,$companyIndex)){
						$intialX =$list[$startIndex]->x_axis;
						$st = 0;
						foreach($companyIndex as $bIndex) {
							$intialX +=$constantValue;
							$list[$bIndex]->old_x_axis = $list[$bIndex]->x_axis;
							$list[$bIndex]->x_axis = $intialX;
							if($st>0) {
								$list[$bIndex]->same = true;
							} else {
								$list[$bIndex]->same = false;
							}
							$st++;
						}
						foreach($bankIndex as $bIndex) {
							$intialX +=$constantValue;
							$list[$bIndex]->same = true;
							$list[$bIndex]->old_x_axis = $list[$bIndex]->x_axis;
							$list[$bIndex]->x_axis = $intialX;
						}
					}
					
				} else {
					if(in_array($startIndex,$bankIndex)){
						$intialX =$list[$startIndex]->x_axis;
						$st = 0;
						foreach($companyIndex as $bIndex) {		
							$list[$bIndex]->old_x_axis = $list[$bIndex]->x_axis;
							$list[$bIndex]->x_axis = $intialX;
							$intialX +=$constantValue;
							if($st>0) {
								$list[$bIndex]->same = true;
							}else {
								$list[$bIndex]->same = false;
							}
							$st++;
						}
						foreach($bankIndex as $bIndex) {
							$list[$bIndex]->same = true;
							$list[$bIndex]->old_x_axis = $list[$bIndex]->x_axis;
							$list[$bIndex]->x_axis = $intialX;
							$intialX +=$constantValue;
						}
					}
				}
			}
			if($max == -1){
				$max = $startIndex;
			}		
			return array('list'=>$list,'max'=>$max);
		}
		
	}	
	
	public function assignment_reel_data($patentNumber = null){
		$data = array('box'=>array(),'inventor_boxes'=>array(),'connection'=>array(),'popup'=>array(),'assignments'=>array(),'names'=>array());
		if($patentNumber != null) {
			switch(strlen($patentNumber)){
				case 9:
					$patentNumber =substr($patentNumber,2);
				break;
				case 11:
				case 13:
					$patentNumber =substr($patentNumber,2);
					$patentNumber =substr($patentNumber,0,-2);
				break;
				default:
					$patentNumber = $patentNumber;
				break;
			}
			$this->load->model('lead_model');
			$family_data = $this->lead_model->findAssignmentFamily($patentNumber);
			$assignmentList = $family_data['all_assignment'];
			if(count($assignmentList) > 0) {
				for($i=0;$i<count($assignmentList);$i++) {
					$modified = preg_replace("/\"/","",$assignmentList[$i]->modified);
					$original = preg_replace("/\"/","",$assignmentList[$i]->original);
					$assignmentList[$i]->modified = $modified;
					$assignmentList[$i]->original = $original;
				}
			}
			$data['assignments'] = $assignmentList;
			$data['names'] = $family_data['all_names'];
			$data['inventor_boxes'] = $family_data['inventor_boxes'];
			if(count($family_data['inventor_boxes'])>0){ 
				$data['box'] = $family_data['inventor_boxes'];
			}
			unset($data['inventor_boxes']);
			if(count($family_data['other_boxes'])>0){ 
				for($i=0;$i<count($family_data['other_boxes']);$i++){
					$type = "";
					if($family_data['other_boxes'][$i]->type == 2){
						$type = "3rdParties";
					} else {
						if(strpos(strtolower($family_data['other_boxes'][$i]->description),'assignment of assignors interest') !== false){
							$type = "Ownership";
						} else if(strpos(strtolower($family_data['other_boxes'][$i]->description),'change of name') !== false){
							$type = "ChangeOfName";
						} else if(strpos(strtolower($family_data['other_boxes'][$i]->description),'security interest') !== false || strpos(strtolower($family_data['other_boxes'][$i]->description),'security agreement') !== false){
							$type = "Security";							
						} else if(strpos(strtolower($family_data['other_boxes'][$i]->description),'license') !== false){
							$type = "License";
						}
					}
					$boxArray = array('id'=>$family_data['other_boxes'][$i]->id,'name'=>$family_data['other_boxes'][$i]->name,'execution_date'=>date('M d,Y',strtotime($family_data['other_boxes'][$i]->execution_date)),'recorded_date'=>date('M d,Y',strtotime($family_data['other_boxes'][$i]->recorded)),'document'=>$family_data['other_boxes'][$i]->document_file,'type'=>$type,'date_1'=>strtotime($family_data['other_boxes'][$i]->date_1));
					if($type === "3rdParties") {
						$boxArray['execution_date'] = '';
						$boxArray['recorded_date'] = '';
					}
					array_push($data['box'],$boxArray);
				}
			}
			$jsonRelations = $family_data['relation'];
			foreach($jsonRelations as $relation){		
				if($relation->connection_type == 2) {			
					$parentID = $relation->parent_id;
					$childID = $relation->child_id;
					$parentData = $this->findIndex($family_data['list'],$childID);
					if(count($parentData) == 1){
						$childData = $this->findIndex($family_data['list'],$parentID);
						if(count($childData) == 1) {			
							$pRelation = array();
							foreach($jsonRelations as $r){
								if($r->parent_id == $childID && $r->child_id == $parentID) {
									$pRelation = $r;
									break;
								}
							}	
							if(count($pRelation) >0 ) {
								$pRelation->parent_name = $parentData[0]->name;
								$pRelation->child_name = $childData[0]->name;
								$jsonRelations[$re]->org_relation = $pRelation;
							}
						}
					}
				}
				$re++;
			}
			$jsRIncrement = 0;
			foreach($jsonRelations as $relation){		
				if((int)$relation->connection_type == 2) {			
					if(isset($relation->org_relation)) {
						$jsonRelations[$jsRIncrement]->reverse = true;
						$jsonRelations[$jsRIncrement]->reverse_frame = $relation->org_relation->frame;
						$jsonRelations[$jsRIncrement]->reverse_reel = $relation->org_relation->reel;
						$jsonRelations[$jsRIncrement]->reff_id = $relation->org_relation->id;
						$jsonRelations[$jsRIncrement]->assignment_no2 = $relation->org_relation->assignment_no;
					}
				}
				$jsRIncrement++;
			}
			if(count($jsonRelations)>0){
				foreach($jsonRelations as $relation){
					$pouptop = $relation->reel.'-'.$relation->frame;
					$assignment_no1 = $relation->assignment_no;
					$poupbottom = "";
					$reffID = 0;
					$assignment_no2 = 0;
					if(isset($relation->reverse) && $relation->reverse === true) {
						$poupbottom = $relation->reverse_reel.'-'.$relation->reverse_frame;
						$reffID = $relation->reff_id;
						$assignment_no2 = $relation->assignment_no2;
					}
					$type = "";
					if(strpos(strtolower($relation->description),'assignment of assignors interest') !== false){
						$type = "Ownership";
					} else if(strpos(strtolower($relation->description),'change of name') !== false){
						$type = "ChangeOfName";
					} else if(strpos(strtolower($relation->description),'security interest') !== false || strpos(strtolower($relation->description),'secured party') !== false){
						if(strpos(strtolower($relation->description),'release') !== false) {
							$type = "Release";		
						} else {
							$type = "Security";		
						}											
					} else if(strpos(strtolower($relation->description),'license') !== false){
						if(strpos(strtolower($relation->description),'expiration') !== false) {
							$type = "LicenseCancellation";		
						} else {
							$type = "License";
						}
					}
					array_push($data['connection'],array('id'=>$relation->id,'date'=>date('M d,Y',strtotime($relation->date)),'start_id'=>$relation->parent_id,'end_id'=>$relation->child_id,'popuptop'=>$pouptop,'popupbottom'=>$poupbottom,'type'=>$type,'ref_id'=>$reffID,'assignment_no1'=>$assignment_no1,'assignment_no2'=>$assignment_no2,'date_1'=>strtotime($relation->date)));
				}				 
			}
			$file = file_get_contents("/var/www/synpat/backyard/public/upload/".$patentNumber.".json");
			if($file != "") {
				try{
					$docs = json_decode($file);
					if(isset($docs->response)) {
						if($docs->response->numFound > 0) {
							$data['popup'] = $docs->response->docs;
						}
					}
				}catch(Exception $e) {					
				}
			}
		}
		/*$newArray = array_merge($data['box'],$data['connection']);
		$date = array_column($newArray, 'date_1');
		array_multisort($date, SORT_ASC, $newArray);
		echo "<pre>";
		print_r($newArray);
		
		die;*/
		
		echo json_encode($data);
		die;
	}
	
	public function assignment_data($patentNumber = null){
		$data = array('_width'=>0,'_height'=>0,'numberp'=>$patentNumber,'_defaultGap'=>30,'namesList'=>array(),'assignmentList'=>array(),'jsonRectangles'=>array(),'jsonAirRectangles'=>array(),'jsonRelations'=>array(),'_chList'=>array(),'_prList'=>array(),'_verticals'=>array(),'_nonverticals'=>array(),'_nonverticalsExits'=>array());
		if($patentNumber != null) {
			$this->load->model('lead_model');
			$family_data = $this->lead_model->findAssignmentFamily($patentNumber);
			$airAssignor = array();
			/*on Air Assignors*/
			if(count($family_data['list'])>0){ 
				for($i=0;$i<count($family_data['list']);$i++){
					if($family_data['list'][$i]->type == 2) {
						array_push($airAssignor,$family_data['list'][$i]);
					}
				}
			}
			$jsonRelations = array();
			$jsonRectangles = array();
			$searchPatent = "";
			$svgWidth = 700;
			$svgHeight = 500;
			$lastBigX = 70;
			$height = 72;
			$width = 190;
			$fS = false;
			if(count($family_data['list'])>0){
				$cpCount = 0;
				$chCount = 1;
				for($i=0;$i<count($family_data['list']);$i++){
					$family = $family_data['list'][$i];
					$same = false;
					$fillingDate = $family->execution_date;
					$fillingType = $family->type;
					$previousFillingDate = "";
					$previousType = "";
					$outside = false;
					if($i>0){
						$previousFillingDate = $family_data['list'][$i-1]->execution_date;
						$previousType = $family_data['list'][$i-1]->type;
					}
					if($previousFillingDate == $fillingDate){
						
						if($fillingType == $previousType) {
							$same = true;	
							$cpCount++;
						}			
						$w = $cpCount*220;
						$w = $w + 220;
						if($w>$svgWidth){
							$svgWidth = $w;
						}
					} else {
						$cpCount = 0;
					}
					$family_data['list'][$i]->same = $same;
					$family_data['list'][$i]->count = $cpCount;
					if($i==0){
						$x = 70;
						$y = 10;
					} else {
						$x = 70;
						$y = (int)$family_data['list'][$i-1]->y_axis + 140;
						
						if($same===true){
							$previousSame = $family_data['list'][$i-1]->same;
							if($previousSame==true){
								$x = (int)$family_data['list'][$i-1]->x_axis + 220;
								$y = (int)$family_data['list'][$i-1]->y_axis;
								if($family_data['list'][$i]->type == 2) { 
									if($family_data['list'][$i - 1]->type != 2) { 
										$x = (int)$family_data['list'][$i-1]->x_axis;
									}
								}
							} else {
								if($fS===false){
									if($cpCount==1){
										$x = 290;
										if($family_data['list'][$i]->type == 2) { 
											if($family_data['list'][$i - 1]->type != 2) { 
												$x = (int)$family_data['list'][$i-1]->x_axis;
											}
										}
									} else {
										$x = $family_data['list'][$i-1]->y_axis + 190;
										if($family_data['list'][$i]->type == 2) { 
											if($family_data['list'][$i - 1]->type != 2) { 
												$x = (int)$family_data['list'][$i-1]->x_axis;
											}
										}
									}
									$fS = true;
								} else {
									$x = 290;
									if($family_data['list'][$i]->type == 2) { 
										if($family_data['list'][$i - 1]->type != 2) { 
											$x = (int)$family_data['list'][$i-1]->x_axis;
										}
									}
								}					
							}
							if($same == true) {
								if($family_data['list'][$i]->type == 2) {
									if($family_data['list'][$i - 1]->type == 1) {
										$y = (int)$family_data['list'][$i-1]->y_axis + 100;
										$chCount++;
									} else {
										$y = (int)$family_data['list'][$i-1]->y_axis;
									}
								} else {
									$y = (int)$family_data['list'][$i-1]->y_axis;
								}
							} else {
								$y = (int)$family_data['list'][$i-1]->y_axis;
							}
							
							
							/*
							if($family_data['list'][$i]->type == 2 && $previousSame != true ) {
								$y = (int)$family_data['list'][$i-1]->y_axis + 100;
							} else if($family_data['list'][$i - 1]->type == 1 && $family_data['list'][$i]->type == 2 && $previousSame == false && $same == true) {
								$y = (int)$family_data['list'][$i-1]->y_axis + 100;
							} else {
								
							}	*/			
						} else {
							$chCount++;
						}
					}
					if($x>$lastBigX) {
						$lastBigX = $x;
					}
					$family_data['list'][$i]->x_axis = $x;
					$family_data['list'][$i]->y_axis = $y;
					$family_data['list'][$i]->width = $width;
					$family_data['list'][$i]->height = $height;
				}
				/*Move banks to different index*/
				for($i=0;$i<count($family_data['list']);$i++) {
					if($i > 0) {
						$current = $family_data['list'][$i];
						$previous = $family_data['list'][$i-1];
						$currentY = $current->y_axis;
						$previousY = $previous->y_axis;
						$previousName = $previous->description;
						$currentName = $current->description;
						$indexStart = -1;
						if((int)$previousY == (int)$currentY) {
							/*Check bank institute*/				
							$start =  false;
							if(strpos(strtolower($previousName),"security interest") !== false && strpos(strtolower($previousName),"release") === false) {
								$indexStart = $i-1;
							} else if(strpos(strtolower($currentName),"security interest") !== false && strpos(strtolower($currentName),"release") === false) {
								$indexStart = $i;
								$start = true;
							}				
						} else if(strpos(strtolower($currentName),"security interest") !== false && strpos(strtolower($currentName),"release") === false) {
							$indexStart = $i;
							$start = true;
						}
						if($indexStart >=0) {
							$returnIndexArray = $this->findUpdateBankAxis($indexStart,$family_data['list'],$start);
							if(count($returnIndexArray['list']) > 0 ) {
								$family_data['list'] = $returnIndexArray['list'];
								if($returnIndexArray['max'] >= 0) {
									$i = $returnIndexArray['max'];
								}
							}
						}
					}
				}
				/*On Air Assignors rectangles X and Y*/
				if(count($airAssignor) >0 ) {
					for($i=0;$i<count($airAssignor);$i++){
						$x = $lastBigX;
						if($i==0){
							$y = 10;
						} else {
							$y = (int)$airAssignor[$i-1]->y_axis + 40;
						}
						$airAssignor[$i]->x_axis = $x;
						$airAssignor[$i]->y_axis = $y;
						$airAssignor[$i]->width = 320;
						$airAssignor[$i]->height = 30;
						$t = 0;
						foreach($family_data['list'] as $list){
							if($list->id == $airAssignor[$i]->id) {
								$family_data['list'][$t]->x_axis = $x;
								$family_data['list'][$t]->y_axis = $y;
								$family_data['list'][$t]->width = 320;
								$family_data['list'][$t]->height = 30;
								break;
							}
							$t++;
						}			
					}		
				}
				
				/*$svgWidth += 420;*/
				$svgHeight = $chCount * 155;
				$verticals = array();
				/*Find Verticals*/
				if(count($family_data['list'])>0){
					for($i=0;$i<count($family_data['list']);$i++){
						$relation = $family_data['list'][$i]->relation;
						$xAppNumber = $family_data['list'][$i]->id;
						$xAxis = $family_data['list'][$i]->x_axis;
						$yAxis = $family_data['list'][$i]->y_axis;
						if(count($relation)>0){
							foreach($relation as $rel){
								$relAppNumber = $rel->parent_id;
								foreach($family_data['list'] as $assets){
									if($assets->id == $relAppNumber && $xAxis == $assets->x_axis && $assets->x_axis<=70){
										$verticals[] = array("id"=>$xAppNumber.$rel->child_id,"yexit"=>$yAxis,"yentry"=>$assets->y_axis);
										break;
									}
								}
							}
						}
					}
				}
				/*for($i=0;$i<count($family_data['list']);$i++) {
					$conveyanceText = $family_data['list'][$i]->description;
					$family_data['list'][$i]->original_description = $conveyanceText;
					foreach($family_data['all_assignment'] as $assignment) {
						if($assignment->original == $conveyanceText) {
							if($assignment->modified != "") {
								$conveyanceText = $assignment->modified;
							}
							break;
						}
					}
					if($conveyanceText != "") {
						$family_data['list'][$i]->description = $conveyanceText;
					}
				}	*/
				$jsonRectangles = $family_data['list'];
				$childListIDs = array();
				$childList = array();
				$parentList = array();
				$applicationListIDS = array();
				if(count($jsonRectangles)>0){
					foreach($jsonRectangles as $rectangle){
						$applicationListIDS[] = $rectangle->id;
					}
				}
				if(count($jsonRectangles)>0){
					foreach($jsonRectangles as $rectangle){
						if(count($rectangle->relation)>0){				
							foreach($rectangle->relation as $relation){
								$pID = $relation->parent_id;
								$cID = $relation->child_id;
								$ID = $pID.$cID;
								if(in_array($cID,$applicationListIDS)==true){
									$entry = false;
									if(count($childListIDs)>0){
										if(in_array($ID,$childListIDs)==false){
											$childListIDs[] = $ID;
										} else {
											$entry = true;
										}
									}						
									if($entry===false){
										if(count($childList)==0){
											$childList[] = array($pID,1,155);
											$parentList[] = array($cID,1,155);
										}else {
											$findApp = false;
											$findPApp = false;
											for($i=0;$i<count($childList);$i++){
												if($childList[$i][0]==$pID){
													$childList[$i][1] = $childList[$i][1]+1;
													$childList[$i][2] = (float) number_format(155/$childList[$i][1],2, '.', '');
													$findApp = true;
													break;
												}
											}
											if($findApp === false){
												$childList[] = array($pID,1,155);
											}
											for($i=0;$i<count($parentList);$i++){
												if($parentList[$i][0]==$cID){
													$parentList[$i][1] = $parentList[$i][1]+1;
													$parentList[$i][2] = (float)number_format(155/$parentList[$i][1],2, '.', '');
													$findPApp = true;
													break;
												}
											}
											if($findPApp === false){
												$parentList[] = array($cID,1,155);
											}
										}							
									}
								}					
							}
						}
					}
				}
				
				if(count($family_data['list'])>0){
					foreach($family_data['list'] as $rec){
						if(count($rec->relation)>0){
							foreach($rec->relation as $relation){
								$jsonRelations[] = $relation;
							}				
						}			
					}
				}
				/*if(count($airAssignor)>0){
					foreach($airAssignor as $rec){
						if(count($rec->relation)>0){
							foreach($rec->relation as $relation){
								$jsonRelations[] = $relation;
							}				
						}			
					}
				}*/
				$grAdded = array();
				$re = 0;
				$removeConnections = array();
				foreach($jsonRelations as $relation){		
					if($relation->connection_type == 2) {			
						$parentID = $relation->parent_id;
						$childID = $relation->child_id;
						$parentData = $this->findIndex($family_data['list'],$childID);
						if(count($parentData) == 1){
							$childData = $this->findIndex($family_data['list'],$parentID);
							if(count($childData) == 1) {			
								$pRelation = array();
								foreach($jsonRelations as $r){
									if($r->parent_id == $childID && $r->child_id == $parentID) {
										$pRelation = $r;
										break;
									}
								}	
								if(count($pRelation) >0 ) {
									$pRelation->parent_name = $parentData[0]->name;
									$pRelation->child_name = $childData[0]->name;
									$jsonRelations[$re]->org_relation = $pRelation;
								}
							}
						}
					}
					$re++;
				}
				$jsRIncrement = 0;
				foreach($jsonRelations as $relation){		
					if((int)$relation->connection_type == 2) {			
						if(isset($relation->org_relation)) {
							$s = 0;
							foreach($jsonRelations as $re) {
								if($re->id == $relation->org_relation->id) {
									$jsonRelations[$s]->reverse = true;
									$jsonRelations[$s]->reverse_frame = $relation->frame;
									$jsonRelations[$s]->reverse_reel = $relation->reel;
									break;
								}
								$s++;
							}
						}
					}
					$jsRIncrement++;
				}
				/*Remove all garbase release connection which don't have any relation with security*/
				$links = array();
				foreach($jsonRelations as $relation){		
					if((int)$relation->connection_type != 2) {
						array_push($links,$relation);
					}
				}

				$jsonRelations = $links;
				/*print_r($jsonRelations);die;*/
			}
			if(count($verticals)>0){
				$this->sort_array_of_array($verticals, 'yentry');
				$this->sort_array_of_array($verticals, 'yexit');
				if(count($verticals)>15){
					$gapValue = 180/count($verticals);
				} else {
					$gapValue = 9;
				}
				/*$gapValue = 9;*/
				$start = 80;
				for($i=0;$i<count($verticals);$i++){
					if($i>0){$start +=$gapValue;}
					$verticals[$i]['x_axis'] = $start;
				}
			}

			$nonVerticalsEntries = array();
			$nonVerticalsExits = array();
			$childAppNumber = array();
			if(count($family_data['list'])>0){
				for($i=0;$i<count($family_data['list']);$i++){
					$rect = $family_data['list'][$i];
					$relation = $rect->relation;
					$xAppNumber = $rect->id;
					$xAxis = $rect->x_axis;
					$yAxis = $rect->y_axis;
					$childX = 0;
					$parentCount = 0;
					if(count($relation)>0){
						$xCount = $xAxis;
						$parentCount = 1;
						$childECount = 0;
						$childXCount = 0;
						foreach($relation as $rel){
							$relationNumber = $rel->child_id;
							$childX = 0;
							if(count($childAppNumber)>0){
								foreach($childAppNumber as $chd){
									if($chd['app_number'] == $relationNumber){
										$childX = $chd['x_axis'];
										break;
									}
								}
							}
							if($childX==0){
								foreach($family_data['list'] as $assets){
									if($assets->id==$relationNumber){
										$childX = $assets->x_axis;
										$childAppNumber[] =array('app_number'=>$relationNumber,'x_axis'=>$assets->x_axis);
										break;
									}
								}
							}
							if($childX>0 && $xAxis!=$childX){
								foreach($family_data['list'] as $assets){
									if(count($assets->relation)>0){
										foreach($assets->relation as $aRelation){
											if($aRelation->child_id == $relationNumber ){
												$parentCount++;
												$xCount +=$assets->x_axis;
												break;
											}
										}
									}
								}
								$entry = "";
								$avg = $xCount/$parentCount;
								if($avg>$childX){
									$entry = "right";
								}else if($avg<$childX){
									$entry = "left";
								}else if($avg==$childX){
									$entry = "center";
								}
								if($entry!=""){
									$nonVerticalsEntries[] = array('app_rel_number'=>$xAppNumber.$relationNumber,'entry'=>$entry,'avg'=>$avg,'parent_count'=>$parentCount,'childX'=>$childX);
								}
								$childECount +=$childX;
								$childXCount++;
							}
						}
						if($childXCount>0){
							$avg = $childECount/$childXCount;
							if($avg>$xAxis){
								$entry = "right";
							}else if($avg<$xAxis){
								$entry = "left";
							}else if($avg==$xAxis){
								$entry = "center";
							}
							if($entry!=""){
								$nonVerticalsExits[] = array('app_rel_number'=>$xAppNumber,'entry'=>$entry,'avg'=>$avg,'parent_count'=>$childXCount,'childX'=>$xAxis);
							}
						}
					}
				}
			}
			$assignmentList = $family_data['all_assignment'];
			if(count($assignmentList) > 0) {
				for($i=0;$i<count($assignmentList);$i++) {
					$modified = preg_replace("/\"/","",$assignmentList[$i]->modified);
					$original = preg_replace("/\"/","",$assignmentList[$i]->original);
					$assignmentList[$i]->modified = $modified;
					$assignmentList[$i]->original = $original;
				}
			}
			$jsRectangle = array();
			if(count($jsonRectangles)>0){
				for($i=0;$i<count($jsonRectangles);$i++){
					$obj = array();
					foreach($jsonRectangles[$i] as $key=>$dt){
							if(is_string($dt) || is_numeric($dt)){
								$obj[$key] = $dt;
							} else {
								$obj[$key] = $dt;
							}
					}
					array_push($jsRectangle,$obj);
				}		
			}
			$jsAirRectangle = array();
			if(count($airAssignor)>0){
				for($i=0;$i<count($airAssignor);$i++){
					$obj = array();
					foreach($airAssignor[$i] as $key=>$dt){
							if(is_string($dt) || is_numeric($dt)){
								$obj[$key] = $dt;
							} else {
								$obj[$key] = $dt;
							}
					}
					array_push($jsAirRectangle,$obj);
				}		
			}
			$data = array('_width'=>($svgWidth+50),'_height'=>$svgHeight,'numberp'=>$patentNumber,'_defaultGap'=>30,'namesList'=>$family_data['all_names'],'assignmentList'=>$assignmentList,'jsonRectangles'=>$jsRectangle,'jsonAirRectangles'=>$jsAirRectangle,'jsonRelations'=>$jsonRelations,'_chList'=>$childList,'_prList'=>$parentList,'_verticals'=>$verticals,'_nonverticals'=>$nonVerticalsEntries,'_nonverticalsExits'=>$nonVerticalsExits );
		}
		echo json_encode($data);
		die;
	}
	
	
	public function changePhoneFormating(){
		$allContacts = $this->client_model->getAllContacts();
		foreach($allContacts as $contact){
			$phone = $contact->phone;			
			$originalPhone = $phone;			
			/*$phone = str_replace('+','',$phone);
			$phone = str_replace('(','',$phone);
			$phone = str_replace(')','',$phone);
			$phone = str_replace('-','',$phone);
			$phone = str_replace('.','',$phone);
			$phone = str_replace(' ','',$phone);
			if(strlen($phone)==10){
				$phone = '+1'.$phone;
			} else if(strlen($phone)>10){
				$phone = '+'.$phone;
			}*/
			$telephone = $contact->telephone;			
			$originalTelephone = $telephone;
			/*$telephone = str_replace('+','',$telephone);
			$telephone = str_replace('(','',$telephone);
			$telephone = str_replace(')','',$telephone);
			$telephone = str_replace('-','',$telephone);
			$telephone = str_replace('.','',$telephone);
			$telephone = str_replace(' ','',$telephone);
			if(strlen($telephone)==10){
				$telephone = '+1'.$telephone;
			} else if(strlen($telephone)>10){
				$telephone = '+'.$telephone;
			}
			if(!empty($phone)){
				$phoneAll = substr($phone,0,-4);
				$phoneFormat = substr($phone,strlen($phone)-4);
				$phone = $phoneAll." ".$phoneFormat;
				$phoneAll = substr($phone,0,-8);
				$phoneFormat = substr($phone,strlen($phone)-8);
				$phone = $phoneAll." ".$phoneFormat;
				$phone = trim($phone);
			}
			if(!empty($telephone)){
				$phoneAll = substr($telephone,0,-4);
				$phoneFormat = substr($telephone,strlen($telephone)-4);
				$telephone = $phoneAll." ".$phoneFormat;
				$phoneAll = substr($telephone,0,-8);
				$phoneFormat = substr($telephone,strlen($telephone)-8);
				$telephone = $phoneAll." ".$phoneFormat;
				$telephone = trim($telephone);
			}
			$this->lead_model->updateContact(array('phone'=>$phone,'telephone'=>$telephone),$contact->id);*/
			echo "Name: ".$contact->first_name." ".$contact->last_name."<br/>----Orginal".$originalPhone."<br/>---- Phone: ".$phone." <br/>----Original Telephone".$originalTelephone."<br/>---- Telephone: ".$telephone."<br/>";
		}
	}
}
/* End of file customers.php */
/* Location: ./application/controllers/customers.php */