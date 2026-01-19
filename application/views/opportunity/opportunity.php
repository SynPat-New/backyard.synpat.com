<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Opportunity extends CI_Controller {

	function __construct(){
		parent::__construct();
		$skipMethods = array('add_contact','search_company_by_name','find_c_cc','contact','sales_contact','add_company');
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
		$this->layout->auto_render=false;	
		$this->layout->layout='default';		
	}
	
	public function updateDuplicateLinkedinurlCompanies(){
		$this->load->model('customer_model');
		$getCompaniesList = $this->customer_model->findDuplicatesLinkedinUrlCompanies();
		foreach($getCompaniesList as $company){
			echo "Linkedin: ".$company->linkedin_url."<br/>";
			$getAllCompanies = $this->customer_model->getAllCompaniesWithLinkedinUrl($company->linkedin_url);
			if(count($getAllCompanies)>1){
				echo count($getAllCompanies)."<br/>";
				for($i=0;$i<count($getAllCompanies);$i++){
					echo "CurrentI:".$i."<br/>";
					$checkUsers = $this->customer_model->getCountAllContactBelongToCompany($getAllCompanies[$i]->id);
					echo "<pre>";
					print_r($getAllCompanies[$i+1]);
					echo "</pre>";
					if(isset($getAllCompanies[$i+1]) && $getAllCompanies[$i+1]->linkedin_url==$getAllCompanies[$i]->linkedin_url){
						$checkAnotherUsers = $this->customer_model->getCountAllContactBelongToCompany($getAllCompanies[$i+1]->id);
						if($checkAnotherUsers==0){
							if($getAllCompanies[$i]->id<$getAllCompanies[$i+1]->id){
								echo "Delete:".$getAllCompanies[$i+1]->id."<br/>";
								$this->customer_model->deleteCompany($getAllCompanies[$i+1]->id);
							} else {
								echo "Delete:".$getAllCompanies[$i]->id."<br/>";
								$this->customer_model->deleteCompany($getAllCompanies[$i]->id);
							}
						} else {
							if($checkUsers==0){
								echo "Delete:".$getAllCompanies[$i]->id."<br/>";
								$this->customer_model->deleteCompany($getAllCompanies[$i]->id);
							} else {
								$this->customer_model->updateALLContactsBelongToCompany(array('company_id'=>$getAllCompanies[$i]->id),$getAllCompanies[$i+1]->id);
								echo "Update all contacts of to this company ".$getAllCompanies[$i]->id." and Delete this:".$getAllCompanies[$i+1]->id."<br/>";
								$this->customer_model->deleteCompany($getAllCompanies[$i+1]->id);
							}
						}
						$i = $i+1;
					}
				}
			}
		}
		die;
	}
	public function uploadBackupFile(){
		$table = $this->input->post('table');
		$backupDate = $this->input->post('backup_date');
		$varServerPath = '/var/www/synpat/';
		$fileName = $backupDate.'.company.gz';
		$filePath = $varServerPath.'backup_db/'.$fileName;
		if(file_exists($filePath)){
			copy($filePath, $varServerPath.'backyard/'.$fileName);
			if(file_exists($varServerPath.'backyard/'.$fileName)){
				shell_exec("cd ".$varServerPath."backyard/; gunzip ".$fileName."; tar xvzf ".$backupDate.".company.tar;");
				if(file_exists($varServerPath.'backyard/'.$backupDate.".company")){
					rename($varServerPath.'backyard/'.$backupDate.".company",$varServerPath.'backyard/'.$backupDate.".company.sql");
					$this->config->load('database',TRUE);
					$databaseConfig = $this->config->item('database');
					/*print_r($databaseConfig);*/
					if(isset($databaseConfig['database']['hostname'])){						
						$mysqlDatabaseName = $databaseConfig['database']['database'];
						$mysqlUserName =$databaseConfig['database']['username'];
						$mysqlPassword = $databaseConfig['database']['password'];
						$mysqlHostName =$databaseConfig['database']['hostname'];
						
						
						/*take_db_backup*/
						/*$backup_file = $varServerPath.'backup_db/backup_'.date("YmdHis") . '.server_company.gz';
						echo $backup_file."<br/>";
						echo $command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' company | gzip > ' .$backup_file;
						shell_exec($command);
						if(file_exists($backup_file)){*/
						if(1==1){
							echo "Took backup";
							/*Drop Table*/
							$this->load->model('opportunity_model');
							$this->opportunity_model->dropCompanyTable();
							$mysqlImportFilename = $varServerPath.'backyard/'.$backupDate.".company.sql";
							$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
							$output=array();
							exec($command,$output,$worked);
							switch($worked){
								case 0:
									echo 'Imported file <b>' .$mysqlImportFilename .'</b> successfully imported to database <b>' .$mysqlDatabaseName .'</b>';
									unlink($mysqlImportFilename);
									break;
								case 1:
									echo 'There was an error during import.';
									break;
							}
						} else {
							echo "Not table able to take backup of table";
						}						
					} else {
						echo "Database server gone away";
					}
				} else {
					echo "No backup file";
				}				
			} else {
				echo "No backup file";
			}
		} else {
			echo "No backup file";
		}
		die;
	}
	
	public function split_speciality($start,$end){
		$this->load->model('customer_model');
		$getCompanyList = $this->customer_model->companyOptimizeListWithPaging("","","","","","","","",array(),array(),"","",array(),'',$sort='c.id','ASC',$start,$end,0,0,2,false);
		$specialityList = array();
		$companiesMapList = array();
		echo count($getCompanyList['data'])."<br/>";
		$tap = 0;
		foreach($getCompanyList['data'] as $company){
			$speciality = $company->specialties;
			if($speciality!=null && $speciality!=""){
				$lists = explode(',',$speciality);
				foreach($lists as $list){
					if(trim($list)!=""){
						$specialityID = $this->customer_model->checkSpeciality(trim($list));
						if($specialityID==0){
							$specialityID = $this->customer_model->insertSpeciality(array('name'=>trim($list)));
						} 
						if($specialityID>0){
							array_push($companiesMapList,array('speciality_id'=>$specialityID,'company_id'=>$company->id));
						}						
					}
				}
				$tap++;
			}
		}
		echo $tap."<br/>";
		if(count($companiesMapList)>0){
			$getAffectedRows = $this->customer_model->addMapSpecialityCompanyInBulk($companiesMapList);
			echo $getAffectedRows;
		}die;
	}
	
	public function category_transfer_tospreadsheet($fileID,$parentCat){
		$this->load->model('customer_model');
		$getCategoryList = $this->customer_model->getCategoryAndSubCategoryList($parentCat);
		if(count($getCategoryList)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$fileGet = $service->getFileInfo($fileID);
			if(is_object($fileGet) && isset($fileGet->title)){
				$spreadSheetService = new SpreadsheetServiceHelper();
				$spreadsheet = $spreadSheetService->getSpreadsheetById($fileGet->id);
				$newListFeed = $spreadSheetService->getWorkSheetByName("Sheet1");
				for($i=0;$i<count($getCategoryList);$i++){
					/*$categoryInsert = array('name'=>$getCategoryList[$i]->name,'parent'=>'','explanation'=>'');
					$newListFeed->insert($categoryInsert);*/
					if(count($getCategoryList[$i]->sub_category)>0){
						for($j=0;$j<count($getCategoryList[$i]->sub_category);$j++){
							$subcategory = $getCategoryList[$i]->sub_category[$j];
							$subcategoryInsert = array('name'=>$subcategory->name,'parent'=>$getCategoryList[$i]->name,'explanation'=>$subcategory->explanation);
							$newListFeed->insert($subcategoryInsert);
						}
					}
				}
			}			
		}
		die;
	}
	
	/*public function read_datafills_spreadsheet($fileID,$projectID){
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();
		$spreadSheetService = new SpreadsheetServiceHelper();
		$spreadsheet = $spreadSheetService->getSpreadsheetById($fileID);
		$allWorkSheet = $spreadSheetService->getAllWorkSheets();
		$workSheetName = "Sheet1";
		$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
		$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());
		$companyList = array();
		if(count($asset_data)>0){
			foreach($asset_data as $data){
				if($data['workmail']!=""){
					if(!in_array($data['company'],$companyList)){
						array_push($companyList,$data['company']);
					}
				}				
			}
		}
		$companyNotExist = array();		
		if(count($companyList)>0){
			$this->load->model('customer_model');
			$newListFeed = $spreadSheetService->getWorkSheetByName("Sheet2");
			$newListFeed3 = $spreadSheetService->getWorkSheetByName("Sheet3");
			foreach($companyList as $company){
				$checkCompanyExist = $this->customer_model->checkCompanyExist($company);
				if($checkCompanyExist==0){
					array_push($companyNotExist,$company);
					if(count($getCategoryList[$i]->sub_category)>0){
						for($j=0;$j<count($getCategoryList[$i]->sub_category);$j++){
							$subcategoryInsert = array('name'=>$company);
							$newListFeed->insert($subcategoryInsert);
						}
					}
				} 
			}
			foreach($asset_data as $data){
				if(!in_array($data['company'],$companyNotExist)){
					$getCompanyData = $this->customer->model($data['company']);
					if(count($getCompanyData)>0){
						$findContact = $this->customer_model->findContactByCompanyIDWithFirstAndLastName($data['company'],$data['firstname'],$data['lastname']);
						if(count($findContact)==0){
							$dfArray = array();
							$data['company'],$data['firstname'],$data['lastname']
						} else {
							$subcategoryInsert = array('firstname'=>$data['firstname'],'lastname'=>$data['lastname'],'jobtitle'=>$data['jobtitle']);
							$newListFeed3->insert($subcategoryInsert);
						}
					} else {
						$subcategoryInsert = array('name'=>$data['company']);
						$newListFeed->insert($subcategoryInsert);
					}
				}
			}
		}
		echo "<pre>";
		print_r($companyNotExist);
		die;
	}*/
	
	public function givePermission(){
		/*$fileID = "1E5v1ySd7hqqVOyXPYJmoc3VFLC4sG9hxPuu_F7n3R_M";
		
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();
		$getFileInfo = $service->getFileInfo($fileID);
		echo "<pre>";
		print_r($getFileInfo);
		$service->setPermissions($fileID,'uzi@synpat.com');
		$service->setPermissions($fileID,'webmaster@synpat.com');*/
		die;
	}	
	public function deleteContact(){
		$post = $this->input->post('delete_link');
		if($post!=""){
			$this->load->model('client_model');
			$this->load->model('opportunity_model');
			$checkContactsHasCorrespondence = $this->opportunity_model->checkContactsCorrespondense(array($post));			
			if(count($checkContactsHasCorrespondence['acquisition'])>0){
				echo -1;
				die;
			}
			if(count($checkContactsHasCorrespondence['sales'])>0){
				echo -1;
				die;
			}
			$data= $this->client_model->deleteContact($post);
			if ((function_exists('session_status') 
			  && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
			  session_start();
			}
			unset($_SESSION['all_contacts']);
			echo $data;
		}
		die;
	}
	public function deleteContactsInBatch(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$deleteContactsIDs = $this->input->post('c');
			try{
				$allIds = json_decode($deleteContactsIDs);
				$this->load->model('opportunity_model');
				$checkContactsHasCorrespondence = $this->opportunity_model->checkContactsCorrespondense($allIds);
				if(count($checkContactsHasCorrespondence['acquisition'])>0){
					foreach($checkContactsHasCorrespondence['acquisition'] as $contact){
						$key = array_search($contact->contact_id, $allIds);
						if($key!==false){
							unset($allIds[$key]);
							$allIds = array_values($allIds);
						}
					}
				}
				if(count($checkContactsHasCorrespondence['sales'])>0){
					foreach($checkContactsHasCorrespondence['sales'] as $contact){
						$key = array_search($contact->contact_id, $allIds);
						if($key!==false){
							unset($allIds[$key]);
							$allIds = array_values($allIds);
						}
					}
				}
				if(count($allIds)>0){
					$data = $this->opportunity_model->deleteContactsInBatch($allIds);
				} else {
					$data = -1;
				}	
			}catch(Exception $e){
				
			}
		}
		echo $data;
		die;
	}	
	
	function create_df_hole(){
		$this->layout->title_for_layout = 'Backyard Client List';
		$this->layout->layout='ajax';	
		$this->layout->render('opportunity/create_df_hole');
	}
	
	public function callTechScraper(){
		try{
			$getContent = file_get_contents("http://webee.technion.ac.il/People/Graduate-Students");
			if(!empty($getContent)){
				libxml_use_internal_errors(true);
				$dom = new DOMDocument;
				$dom->recover = true;
				$dom->strictErrorChecking = false;
				$dom->loadHTML($getContent);
				$peopleDiv = $dom->getElementById('people');
				$ulList = $peopleDiv->getElementsByTagName('ul')->item(0);
				$liList = $ulList->getElementsByTagName('li');
				foreach ($liList as $li) {
					$image = $li->getElementsByTagName('img')->item(0);
					$profileImage = $image->getAttribute('src');
					if(!empty($profileImage)){
						$profileImage ='http://webee.technion.ac.il/'.$profileImage;
					}
					$name = $li->getElementsByTagName('h4')->item(0)->textContent;
					$dl = $li->getElementsByTagName('dl')->item(0);
					$nodes= $dl->getElementsByTagName('dd') ;
					if($nodes->length>0){
						for($i=0;$i<$nodes->length;$i++){
							$dt = $dl->getElementsByTagName('dt')->item($i)->textContent;
							switch(trim($dt)){
								case "Email:":
									$dd = $dl->getElementsByTagName('dd')->item($i);
									$email = $dd->getElementsByTagName('a')->item(0)->getAttribute('rel');
									$email = str_replace('/','@',$email);
								break;
								case "Phone:":
									$phone = $dl->getElementsByTagName('dd')->item($i)->textContent;
								break;
								case "Office:":
									$office = $dl->getElementsByTagName('dd')->item($i)->textContent;
								break;
							}
						}
					}
					$contacts[] = array('company_id'=>4368,'img_card'=>json_encode(array($profileImage)),'first_name'=>$name,'email'=>$email,'phone'=>$phone,'street'=>$office);
				}
				if(count($contacts)>0){
					$this->load->model('opportunity_model');
					$this->opportunity_model->insertContactsInBatch($contacts);
				}				
			}
		}catch(Exception $e){
			
		}
		die;
	}	
	public function buildCompanyMenu(){
		$response = "";
		if(isset($_POST) && count($_POST)>0){
			$response =  buildCompanyMenu($this->input->post('c'),$this->input->post('s'));
		}
		echo $response;
		die;
	}	
	public function addNewSector(){
		$data = array('data'=>array('error'=>1,'message'=>'Please enter category name..'));
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('general_model');
			$ID = $this->general_model->insertSector(array('name'=>$this->input->post('sector_name')));
			if($ID>0){
				$data['data']['error'] = 0;
				$data['data']['message'] = "Added successfully";
			}
		}
		echo json_encode($data);
		die;
	}	
	public function addNewTechnology(){
		$data = array('data'=>array('error'=>1,'message'=>'Please enter category name..'));
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('general_model');
			$ID = $this->general_model->insertCategory(array('name'=>$this->input->post('category_name'),'parent'=>0));
			if($ID>0){
				$this->general_model->insertSectorDepartment(array('sector_id'=>21,'category_id'=>$ID));
				$data['data']['error'] = 0;
				$data['data']['message'] = "Added successfully";
			}
		}
		echo json_encode($data);
		die;
	}	
	public function refreshSectorCategory(){
		$sectoryID = 0;
		$companyID = 0;
		if(isset($_POST) && count($_POST)>0){
			$companyID = $this->input->post('company_id');
			$sectorID = $this->input->post('sector_id');
		}
		$this->load->helper('notification_helper');
		$sector = buildCompanyMenu($companyID,$sectorID);
		$category = buildTechnologyMenu($companyID);
		echo json_encode(array('sector'=>$sector,'category'=>$category));
		die;
	}	
	public function updateFromCategoryToTechnologies(){
		$this->load->model('customer_model');
		$this->customer_model->updateFromCategoryToTechnologies();
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
	
	public function update_sector_category_subcategory(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$source = $this->input->post('source');
			$sourceType = $this->input->post('sourceType');
			$destination = $this->input->post('destination');
			$destType = $this->input->post('destType');
			$order = $this->input->post('order');
			$rootOrder = $this->input->post('rootOrder');
			/*Move source to sector*/
			$this->load->model('customer_model');
			$this->load->model('general_model');
			$getData = array();
			switch($sourceType){
				case 'sector':
					$getData = $this->general_model->findSector($source);
					$this->general_model->delete_sector($source);
				break;
				case 'technology':
				case 'sub-technology':
				case 'subsub-technology':
				case 'category':
				case 'subcategory':
					$getData = $this->general_model->findCategory($source);
					$this->general_model->delete_category($source);
					if($getData->parent==0){
						$this->general_model->deleteSectorDepartmentByCategory($getData->id);
					}
					
				break;
			}
			if(count($getData)>0){
				switch($destType){
					case 'sector':
						/*Add new Sector*/
						$data = $this->general_model->insertSector(array('name'=>$getData->name));
					break;
					case 'category':
					case 'technology':
						/*
							@get data from destination
							@add new category and and map new category with destination sector
						*/
						$data = $this->general_model->insertCategory(array('name'=>$getData->name,'parent'=>0));
						if($destType=="technology"){
							$destination = 21;
						}
						$findSector = $this->general_model->findSector($destination);
						if(count($findSector)>0 && $data>0){
							$this->general_model->insertSectorDepartment(array('sector_id'=>$findSector->id,'category_id'=>$data));
						}
						$checkOldCategoryHasChild = $this->customer_model->categoryListWithMoreThanOne($getData->id);
						if(count($checkOldCategoryHasChild)>0){
							$updateBatchCategory = array();
							foreach($checkOldCategoryHasChild as $child){
								$updateBatchCategory[] = array('parent'=>$data,'id'=>$child->id);
							}							
							if(count($updateBatchCategory)>0){
								$this->general_model->updateBatchSubCategory($updateBatchCategory,"id");
							}
						}
					break;
					case 'subcategory':
					case 'subsub-technology':
					case 'sub-technology':
						/*Add new Sub category*/
						$type = 1;
						if( $destType== "subsub-technology"){
							$type = 2;
						}
						$data = $this->general_model->insertCategory(array('name'=>$getData->name,'parent'=>$destination,'type'=>$type));
					break;
				}
			}
		}
		echo $data;
		die;
	}	
	public function update_contacts_from_datafills(){
		$data = array('success'=>0);
		$this->load->model('opportunity_model');
		$this->load->model('client_model');
		$getListUserData = $this->opportunity_model->getDataFromDataFills();
		if(count($getListUserData)>0){
			foreach($getListUserData as $contact){
				switch((int)$contact->col){
					case 5:
						$data['success'] = $this->client_model->update($contact->contact_id,array('email'=>$contact->data,'new_email'=>1));
					break;
					case 6:
						$data['success'] = $this->client_model->update($contact->contact_id,array('phone'=>$contact->data,'new_phone'=>1));
					break;
					case 7:
						$data['success'] = $this->client_model->update($contact->contact_id,array('telephone'=>$contact->data,'new_phone'=>1));
					break;
					case 8:
						$data['success'] = $this->client_model->update($contact->contact_id,array('linkedin_url'=>$contact->data,'new_linkedin'=>1));
					break;
				}
			}
		}
		echo json_encode($data);
	}	
	public function assets_list(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('assets_model');
			$data = $this->assets_model->getList($this->input->post('l'));
		}
		echo json_encode($data);
		die;
	}	
	public function getDataForPatentDue(){
		$data = array('legal'=>array(),'tech'=>array());
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('opportunity_model');
			$data = $this->opportunity_model->secGetPatentDueTechAndLegal($this->input->post('p'));
		}
		echo json_encode($data);
		die;
	}	
	public function change_docket_password(){
		$data = array('id'=>0);
		if(isset($_POST) && count($_POST)>0){
			if($this->input->post('file_type')>0){
				try{
					if(!empty($this->input->post('columns'))){
						$columns = json_decode($this->input->post('columns'),true);
						if(!empty($this->input->post('new_access_code'))){
							$updateData[$columns[0]] = $this->input->post('new_access_code');
							$this->load->model('opportunity_model');
							$data['id'] = $this->opportunity_model->updateLicenseAccessCode($updateData,$this->input->post('id'));
						}						
					}
				}catch(Exception $e){}
			}			
		}
		echo json_encode($data);
		die;
	}	
	public function check_docket_password(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('opportunity_model');
			$data = $this->opportunity_model->check_docket_password($this->input->post('l'),$this->input->post('file_type'));
		}
		/*$data = $this->opportunity_model->check_docket_password(265,3);*/
		echo json_encode($data);
		die;
	}	
	public function collectPublishedAndPatentData(){
		if(isset($_GET) && count($_GET)>0){
			$this->load->model('opportunity_model');
			$findLeadData = $this->opportunity_model->getLeadDataByIdWithSelect($this->input->get('lead_id'),'serial_number');
			if(count($findLeadData)>0){
				$findLicenseID = $this->opportunity_model->getLicenseDataByLeadID($findLeadData->serial_number,'id');
				if(count($findLicenseID)>0){
					$getPatentList = $this->opportunity_model->getDuePatentDataListByLeadID($findLicenseID->id,'patent_number,id');
					if(count($getPatentList)>0){
						$allPatentApplication = array();
						foreach($getPatentList as $patent){
							$allPatentApplication[] = array('type'=>'Patent','patent_number'=>$patent->patent_number);
							$getPublishedData = $this->opportunity_model->patentPublishedData($patent->patent_number,'type,publication_number');
							if(count($getPublishedData)>0){
								foreach($getPublishedData as $publish){
									$type = '';
									if($publish->type=="Grant"){
										$type = 'Patent';
									} else if($publish->type=="Application"){
										$type = 'Application';
									}
									$allPatentApplication[] = array('type'=>$type,'patent_number'=>$publish->publication_number);
								}
							}
						}
						if(count($allPatentApplication)>0){
							$chartLeftData = array();
							foreach($allPatentApplication as $publishedPatent){
								$first2Letter = substr($publishedPatent['patent_number'],0,2);
								if(count($chartLeftData)>0){
									$enter = false;
									$l=0;
									foreach($chartLeftData as $left){
										if($left['country']==$first2Letter){
											$patentCount = $left['patents'];
											$applicationCount = $left['applications'];
											if($publishedPatent['type']=="Patent"){
												$patentCount = (int) $patentCount + 1;
											} else if($publishedPatent['type']=="Application"){
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
										if($publishedPatent['type']=="Patent"){
											$patentCount = 1;
										} else if($publishedPatent['type']=="Application"){
											$applicationCount = 1;
										}
										$chartLeftData[] = array('license_id'=>$findLicenseID->id,'country'=>$first2Letter,'patents'=>$patentCount,'applications'=>$applicationCount);
									}
								} else {
									$patentCount = 0;
									$applicationCount = 0;
									if($publishedPatent['type']=="Patent"){
										$patentCount = 1;
									} else if($publishedPatent['type']=="Application"){
										$applicationCount = 1;
									}
									$chartLeftData[] = array('license_id'=>$findLicenseID->id,'country'=>$first2Letter,'patents'=>$patentCount,'applications'=>$applicationCount);
								}
							}
							if(count($chartLeftData)>0){
								$this->opportunity_model->deleteDuedilligenceLeftChart($findLicenseID->id);
								$this->opportunity_model->deleteLeftChart($this->input->get('lead_id'));
								foreach($chartLeftData as $chart){
									$this->opportunity_model->saveDuediligenceChartLeft($chart);
									unset($chart['license_id']);
									$chart['lead_id'] = $this->input->get('lead_id');
									$this->opportunity_model->saveChartLeft($chart);
								}
							}
						}
					}
				}
			}
		}
		die;
	}	
	public function callCreateScreenshotFromUrl(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){			
			try {
				$this->load->model('opportunity_model');
			$findLeadData = $this->opportunity_model->getLeadDataByIdWithSelect($this->input->post('lead_id'),'image_folder');
			if(count($findLeadData)>0){
				$patentData = $this->opportunity_model->getDuePatentData($this->input->post('name'));
				$folderID = $findLeadData->image_folder;	 
				$url = $this->input->post('url');
				if(!empty($folderID)){			
					$dataUrlCheck = $this->opportunity_model->checkUrlFromDatabase($url);
					$scrapPost = json_decode($this->input->post('scrap'),true);
					if(is_object($scrapPost)){
						$scrapPost = (array)$scrapPost;
					}
					if(count($scrapPost)>4){
						unset($scrapPost[4]);
						unset($scrapPost[5]);
						unset($scrapPost[6]);
						array_values($scrapPost);
					}
					$post= array();
					foreach($scrapPost as $p){
						array_push($post,$p);
					}
					$InventionData = $this->opportunity_model->getDocketInventionDataPatentSingle($this->input->post('id'),"infringe_text");
					if(count($dataUrlCheck)>0 && !empty($dataUrlCheck->image)){						
						$post[] = $patentData->id;
						$post[] = $this->input->post('url');
						$post[] = $dataUrlCheck->image;	
						$data = $this->updatePostDataAndSave($post,$InventionData->infringe_text,$this->input->post('id'),0);
					} else {
						$newData = array();
						if(!empty($url) && $url!=null && $url!='null' && $url!='undefined'){
							if(isset($post[3]) && is_string($post[3])){
								$newData['link'] = $post[3];
							} else {
								$newData['link'] = $post[2];
							}
							
							$json_data = $this->runCurlFetchImage($url);
							if(isset($json_data['id']) && $json_data['status']!="finished"){
								$imageData = $this->fetchImageFromID($json_data['id']);
							} else {
								$imageData = (object)$json_data;
							}
							if(isset($imageData) && count($imageData)>0){
								if($imageData->{'status'} == 'finished'){
									$newData['image'] = $imageData->{'screenshot_url'};
									$post[] = $patentData->id;
									$post[] = $this->input->post('url');
									$post[] = $newData['image'];									
									$data = $this->updatePostDataAndSave($post,$InventionData->infringe_text,$this->input->post('id'),1);
								}
							}
						}
					}
				}
			}
			}catch(Exception $e){
				
			}
		}
		echo $data;
		die;
	}	
	public function fetchImageFromID($ID){
		require_once(APPPATH.'libraries/Browshot.php');
		$browshot = new Browshot('oUnAlHUsWOlbzz51xFahrTguIE7I6JQN');
		sleep(5);
		$status = $browshot->screenshot_info($ID);	
		while ($status->{'status'} != 'finished' && $status->{'status'} != 'error') {
		  sleep(5);
		  $status = $browshot->screenshot_info($ID);
		}
		return $status;
	}	
	public function runCurlFetchImage($file){
		$ch = curl_init();		
		 $api_url = 'https://api.browshot.com/api/v1/screenshot/create?key=oUnAlHUsWOlbzz51xFahrTguIE7I6JQN&instance_id=12&url='.$file.'&size=screen';
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$response = curl_exec($ch);
		/*echo "<pre>";
		print_r($response);*/
		curl_close($ch);
		$json_data = array();
		try{
			if(!empty($response)) {
				$json_data = json_decode($response,true);
			}
		}catch(Exception $e){}
		return $json_data;
	}	
	public function updatePostDataAndSave($post,$infringe_text,$id,$t){
		$data = 0;
		$productsCompanies = json_decode($infringe_text,true);
		$stringUpdateCompanies = "";
		$updateData = array();
		if(count($productsCompanies)>0){
			for($i=0;$i<count($productsCompanies)-1;$i++){
				$linkP="";
				if(isset($productsCompanies[$i][3])){
					$linkP = $productsCompanies[$i][3];
				} else {
					$linkP = $productsCompanies[$i][2];
				}
				$linkCheck = "";
				if(count($post)>6){
					$linkCheck =$post[3];
				} else {
					$linkCheck =$post[2];
				}
				if($linkP !='' && $linkCheck!='' && $linkP ==$linkCheck){
					/*echo "DONE";*/
					if(is_object($post)){
						$post = (array)$post;
					}
					$productsCompanies[$i] = $post;
				}
				if(count($productsCompanies[$i])>6){
					$companyName= $productsCompanies[$i][0];
					$product = $productsCompanies[$i][2];
					$link = $productsCompanies[$i][3];
					if(isset($productsCompanies[$i][6]) && !empty($productsCompanies[$i][6])){
						$link = $productsCompanies[$i][6];
					}
					$mainLink = $productsCompanies[$i][3];
				} else {
					$companyName= $productsCompanies[$i][0];
					$product = $productsCompanies[$i][1];
					$link = $productsCompanies[$i][2];
					$mainLink = $productsCompanies[$i][2];
					if(isset($productsCompanies[$i][5]) && !empty($productsCompanies[$i][5])){
						$link = $productsCompanies[$i][5];
					}
				}										
				$stringUpdateCompanies .= '<a data-mainlink="'.$mainLink.'" href="'.$link.'">'.$companyName.' - '.$product.'</a><br/>';
			}
		}
		if(!empty($stringUpdateCompanies)){
			$updateData['infringe_text'] = json_encode($productsCompanies);
			$updateData['p_infringe'] = $stringUpdateCompanies;
		}
		
		/*echo "<pre>";
		print_r($updateData);*/
		if(count($updateData)>0){
			$this->load->model('opportunity_model');
			$data =  $this->opportunity_model->updateDocketDue("due_dilligence_inventions",$updateData,$id);
			if(count($post)>6){
				if(!empty($post[5]) && !empty($post[6]) && (int)$t==1){
					$ch = $this->opportunity_model->checkUrlFromDatabase($post[5]);
					if(count($ch)==0){
						$this->opportunity_model->addDocketDue("due_images",array('link'=>$post[5],'image'=>$post[6]));
					}
				}
			} else {
				if(!empty($post[4]) && !empty($post[5]) && (int)$t==1){
					$ch = $this->opportunity_model->checkUrlFromDatabase($post[4]);
					if(count($ch)==0){
						$this->opportunity_model->addDocketDue("due_images",array('link'=>$post[4],'image'=>$post[5]));
					}
				}
			}			
		}
		return $data;
	}	
	public function callGrabImageToDrive(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			/*echo "<pre>";
			print_r($_POST);*/
			$this->load->model('opportunity_model');
			$findLeadData = $this->opportunity_model->getLeadDataByIdWithSelect($this->input->post('lead_id'),'image_folder');
			if(count($findLeadData)>0){
				$folderID = $findLeadData->image_folder;	 							
				if(!empty($folderID)){			
					$fileURL = $this->input->post('field_data');
					if(!empty($fileURL) && $fileURL!='null' && $fileURL!=null){
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
							/*$service->setAdditionalPermissions( $getUploadFileData->id, "","reader","anyone");*/
							$fileArray = array('from'=>$fileURL,'drive_url'=>$getUploadFileData->alternateLink,'id'=>$getUploadFileData->id);
							$updateData = array();
							$updateData[$this->input->post('field_name')] = json_encode($fileArray);
							$data = $this->opportunity_model->updateDocketDue("due_dilligence_legal",$updateData,$this->input->post('id'));
						}
					}
				}
			}
		}
		echo $data;
		die;
	}	
	public function add_list_selection(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$id = $this->input->post('id');
			$type= $this->input->post('t');
			$leadID = $this->input->post('lead_id');
			$this->load->model('opportunity_model');
			$checkCompanyInListing = $this->opportunity_model->checkCOmpanyINListing($id,$type,$leadID);
			if(count($checkCompanyInListing)==0){
				$data = $this->opportunity_model->addListingCompany(array('company_id'=>$id,'type'=>$type,'lead_id'=>$leadID));
			} else {
				$data = $checkCompanyInListing->id;
			}
		}
		echo $data;
		die;
	}	
	public function delete_list_selection(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$id = $this->input->post('id');
			$type= $this->input->post('t');
			$leadID = $this->input->post('lead_id');
			$this->load->model('opportunity_model');
			$data = $this->opportunity_model->deleteListingCompany(array('company_id'=>$id,'type'=>$type,'lead_id'=>$leadID));
		}
		echo $data;
		die;
	}
	public function new_password_for_outsource(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$ID = $this->input->post('id');
			$leadID = $this->input->post('lead_id');
			$colType = $this->input->post('col_type');
			$nVal = $this->input->post('n_val');
			$this->load->model('user_model');
			$getOutsourceData = $this->user_model->getDueDataByID($ID);
			$updateData = array();
			if(count($getOutsourceData)>0){
				if($colType=="access_code"){
					switch((int)$getOutsourceData->project_type){
						case 2:
							$updateData['tech_access_code'] = $nVal;
						break;
						case 3:
							$updateData['legal_access_code'] = $nVal;
						break;
						case 4:
							$updateData['illus_access_code'] = $nVal;
						break;
						case 7:
							$updateData['due_access_code'] = $nVal;
						break;
						case 8:
							$updateData['portfolio_access_code'] = $nVal;
						break;
						case 9:
							$updateData['comparables_access_code'] = $nVal;
						break;
						case 10:
							$updateData['pdf_access_code'] = $nVal;
						break;
						case 11:
							$updateData['images_access_code'] = $nVal;
						break;
						case 12:
							$updateData['market_access_code'] = $nVal;
						break;
						case 13:
							$updateData['dictionary_access_code'] = $nVal;
						break;
					}
					if(count($updateData)>0){
						$this->load->model('lead_model');
						$this->load->model('opportunity_model');
						$getLeadData = $this->lead_model->getLeadDataWithOptions($leadID,"l.serial_number");
						if(count($getLeadData)>0){
							$data = $this->opportunity_model->updateLicenseAccessCode($updateData,0,$getLeadData->serial_number);
						}						
					}
				} else if($colType=="password"){
					$this->load->model('lead_model');
					$updateData['password'] = $nVal;
					$data = $this->lead_model->updateOpenProjectDataByLeadType($leadID,(int)$getOutsourceData->project_type,$updateData);
				}				
			}
		}
		echo $data;
		die;
	}	
	
	public function removeAndGrantIllustrationPermissions($leadID,$grantAccess){	
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
					$allFilesAddAdditionalPermission = array();
					if(count($listFiles)>0){ 
						foreach($listFiles as $file){							
							if(count($getLastUserOpenProject)>0){
								$getPermissionsList = $service->getPrmissionsList($file->id);
								if(count($getPermissionsList)>0){
									foreach($getPermissionsList as $permission){
										$entry = false;
										if($permission->emailAddress==$getLastUserOpenProject->email || (!empty($getLastUserOpenProject->secondary_email) && $permission->emailAddress==$getLastUserOpenProject->secondary_email)){
											$allFilesRemovePermission[] = array('id'=>$file->id,'permission_id'=>$permission->id); 
											$entry = true;
										}
										if($entry===false):
											if($permission->id=="anyone" || $permission->type=="anyone" || $permission->id=="anyoneWithLink" || $permission->role=="reader"){
												$allFilesRemovePermission[] = array("id"=>$file->id,'permission_id'=>$permission->id);
											}
										endif;
									}
								}
							}
							$allFilesAddPermission[] = $file->id;					
							/*$service->setPermissions( $file->id, $contactEmail);*/
						} 
						if(count($allFilesRemovePermission)>0){
							$service->batchRequestForRemovePermissions($allFilesRemovePermission);
						}
						if(count($allFilesAddPermission)>0 && $grantAccess==0){								/*$service->batchRequestForSetPermissions($allFilesAddPermission,$getLastUserOpenProject->email);
							if(!empty($getLastUserOpenProject->secondary_email)){
								$service->batchRequestForSetPermissions($allFilesAddPermission,$getLastUserOpenProject->secondary_email);
							}*/							
							$service->batchRequestForSetPermissionsWithLink($allFilesAddPermission);
						} else {
							$service->batchRequestForSetPermissionsWithLink($allFilesAddPermission,"reader");
						}
					}
				}
			}				
		}
	}
	
	public function outsource_permission(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$data = $this->input->post();
			$leadID = $this->input->post('l');
			$action = $this->input->post('ac');
			$attachFileName = $this->input->post('f');
			$accessCode = '12345';
			if($action=='change'){
				$accessCode = '@1!2#';
			}
			$fileType = 0;
			if(strpos($attachFileName,'patent')!==false){
				$fileType = 1;
			} else if(strpos($attachFileName,'tech')!==false){
				$fileType = 2;
			} else if(strpos($attachFileName,'legal')!==false){
				$fileType = 3;
			} else if(strpos($attachFileName,'claim')!==false){
				$fileType = 4;
			} else if(strpos($attachFileName,'royalty')!==false){
				$fileType = 5;
			} else if(strpos($attachFileName,'invitees')!==false){
				$fileType = 6;
			} else if(strpos($attachFileName,'seller')!==false){
				$fileType = 7;
			}else if(strpos($attachFileName,'intro')!==false){
				$fileType = 8;
			}else if(strpos($attachFileName,'comparable')!==false){
				$fileType = 9;
			}else if(strpos($attachFileName,'pdf')!==false){
				$fileType = 10;
			}else if(strpos($attachFileName,'images')!==false){
				$fileType = 11;
			}else if(strpos($attachFileName,'market')!==false){
				$fileType = 12;
			}
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$getOpenData = $this->lead_model->checkOpenProjectData($leadID,$fileType);
			$openAccess = 1;
			if(count($getOpenData)>0){				
				if($action=='revert'){
					$openAccess = 0;
				}
				$data['update'] = $this->lead_model->updateOpenProjectData(array('status'=>$openAccess),$getOpenData->id);
			}
			/*Get DUe Log Time*/
			$getDataList = $this->user_model->getDueLogDataByType($leadID,$attachFileName,"d.id,d.file_url");
			if(count($getDataList)>0){
				$allowORRemoveAccess = 0;
				if($action=='revert'){
					$allowORRemoveAccess = 1;
				}
				foreach($getDataList as $d){
					$this->user_model->update_due_logtime(array('permmission'=>$allowORRemoveAccess),$d->id);
				}
			}
			/*Update Access Code According to Type*/
			$updateDataInDocket = array();
			switch((int)$fileType){				
				case 2:
					/*TechDD*/
					$updateDataInDocket = array('tech_access_code'=>$accessCode,'tech_email_address'=>'');
				break;
				case 3:
					/*LegalDD*/
					$updateDataInDocket = array('legal_access_code'=>$accessCode,'legal_email_address'=>'');
				break;				
				case 4:
					$updateDataInDocket = array('illus_access_code'=>$accessCode,'illus_email_address'=>'');
					$this->removeAndGrantIllustrationPermissions($leadID,$openAccess);
				break;
				case 5:
				case 6:
					/*Change File Permissions*/
					if(count($getDataList)>0){
						$this->load->library('DriveServiceHelper');
						$service = new DriveServiceHelper();
						foreach($getDataList as $getData){
							$fileURL = $getData->file_url;
							$fileURL = str_replace("/edit?usp=drivesdk","",$fileURL);
							$fileURL = str_replace("/view?usp=drivesdk","",$fileURL);
							$fileUrlExplode = explode('/',$fileURL);
							$fileID = array_pop($fileUrlExplode);
							if(!empty($fileID)){								
								$getFileDetail = $service->getFileInfo($file);
								if($getFileDetail){
									$service->deletePermission($getFileInfo->id,"anyoneWithLink");				
								}
							}
						}
					}					
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
					/*introiamges*/
					$updateDataInDocket = array('images_access_code'=>$accessCode,'images_email_address'=>'');
				break;
				case 12:
					/*marketdd*/
					$updateDataInDocket = array('market_access_code'=>$accessCode,'market_email_address'=>'');
				break;
				
			}
			if(count($updateDataInDocket)>0){
				$this->load->model('acquisition_model');
				$getAcqData = $this->acquisition_model->getData($leadID);	
				$updateDataInDocket['license_number'] = $getAcqData['acquisition']->store_name;
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/resetDocketAccessCode',
					CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => $updateDataInDocket
				));
				// Send the request & save response to $resp
				$resp = curl_exec($curl);
				if($resp){
				}
			}
		}
		echo json_encode($data);
		die;
	}	
	public function docket_accordion($leadID = 0){
		$data = array('acordion_text'=>array(),'lead_id'=>$leadID);
		if($leadID>0){
			$this->load->model('acquisition_model');
			$getAcqData = $this->acquisition_model->getDataByOptions($leadID,'a.store_name');
			if(count($getAcqData)>0){
				
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/getLicenseData',
					CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'license_number' => $getAcqData->store_name,
					)
				));
				// Send the request & save response to $resp
				$resp = curl_exec($curl);
				if($resp){
					$data['acordion_text'] = json_decode($resp);
				}				
			}			
		}
		$this->load->model('opportunity_model');
		$data['template_accordion'] = $this->opportunity_model->getDocketTemplateAccordion('12345','portfolio_tab,counter_tab,simulator_tab,document_tab,claim_tab,invention_tab,price_tab,evidence_tab,comparables_tab,royalties_tab,fcitation_tab,seller_tab,pdf_tab,validity_tab,bcitation_tab,prior_tab,legal_tab,privacy_tab,tech_dd,market_dd,legal_dd,illustration_dd,image_dd,pdf_dd,seller_dd,dictionary_dd');
		$this->layout->layout='opportunity';	
		$this->layout->title_for_layout = 'Backyard Opportunity List';
		$this->layout->render('opportunity/docket_accordion',$data);
	}	
	public function store_intro(){
		$data = array('store_intro'=>'');
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('acquisition_model');
			$getAcqData = $this->acquisition_model->getDataByOptions($this->input->post('l'),'a.store');
			if(count($getAcqData)>0){			
				$data['store_intro'] = $getAcqData->store;
			}
		}
		echo json_encode($data);
		die;
	}	
	public function find_docket_documents(){
		$data = array('drive_files'=>array(),'ppa'=>'','pla'=>'','sla'=>'','rtp'=>'','ppp'=>'','royalty'=>'');
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('acquisition_model');
			/*$leadData = $this->lead_model->getLeadData($this->input->post('l'));
			if(count($leadData)>0){*/
				$getAcqData = $this->acquisition_model->getDataByOptions($this->input->post('l'),'a.ppa,a.pla,a.sla,a.rtp,a.ppp,a.other_damages');
				if(count($getAcqData)>0){
					$data['ppa'] = $getAcqData->ppa;
					$data['pla'] = $getAcqData->pla;
					$data['sla'] = $getAcqData->sla;
					$data['rtp'] = $getAcqData->rtp;
					$data['ppp'] = $getAcqData->ppp;
					$data['royalty'] = $getAcqData->other_damages;
				}				
			/*}*/	
			/*
			$getFolderID = $leadData->folder_id;
			if(!empty($getFolderID) && $getFolderID!=false){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();					
				$data['drive_files'] = $service->getFileIDFromChildern($getFolderID);
			}*/
		}
		echo json_encode($data);
		die;
	}	
	public function find_order_name(){
		$data = "";
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('acquisition_model');
			$getAcqData = $this->acquisition_model->getData($this->input->post('l'));
			$data = $getAcqData['acquisition']->order_name;
		}
		echo $data;
		die;
	}	
	public function retrieve_embed_code_from_claimcharts(){
		$data = array('embed_code'=>'','work_code'=>'');
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('acquisition_model');
			$getAcqData = $this->acquisition_model->getData($this->input->post('l'));
			if(count($getAcqData)>0 && count($getAcqData['acquisition'])>0){
				$claimChart = '<iframe src="http://claimcharts.info/index.php/component/survey/?tmpl=component&task=customer.generateClientRequest&client_id='.$this->input->post('o').'&pr=2" width="100%" height="680" frameborder="0" scrolling="yes"></iframe>';
				$this->acquisition_model->updateData($this->input->post('l'),array("order_name"=>$this->input->post('o'),'cc_embed_code'=>$claimChart));
				$this->load->model('user_model');
				$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$this->input->post('l'),'message'=>'Update data in docket','create_date'=>date('Y-m-d H:i:s')));
				$workCode = 'http://claimcharts.info/?'.$this->input->post('o');
				$data['embed_code'] = $claimChart;
				$data['work_code'] = $workCode;
			}
		}
		echo json_encode($data);
		die;
	}	
	public function store_intro_save($lead=0){
		$data = 0;
		if(isset($_POST) && count($_POST)>0 && $lead>0){
			$other = $this->input->post('acquisition');
			$this->load->model('acquisition_model');
			$acquisitionData = $this->acquisition_model->getDataByOptions($lead,'a.id');
			if(count($acquisitionData)>0){
				$data = $this->acquisition_model->updateData($lead,$other);
			}			
		}
		echo $data;
		die;
	}	
	public function find_docket_documents_save($lead=0){
		$data = 0;
		if(isset($_POST) && count($_POST)>0 && $lead>0){
			$other = $this->input->post('other');
			$this->load->model('acquisition_model');
			$acquisitionData = $this->acquisition_model->getData($lead);	
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/docs_update_other_docs',
				CURLOPT_USERAGENT => 'Send Request for create demo portfolio',   
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					'license_number' => $acquisitionData['acquisition']->store_name,
					'ppa'=>$other['ppa'],
					'pla'=>$other['pla'],
					'rtp'=>$other['rtp'],
					'ppp'=>$other['ppp'],
					'sla'=>$other['sla'],
					'royalty'=>$other['royalty'],
				)
			));				
			$other['other_damages'] = $other['royalty'];
			unset($other['royalty']);
			$resp = curl_exec($curl);	
			$this->acquisition_model->updateData($lead,$other);
			$data = 1;
		}
		echo $data;
		die;
	}
	public function file_permission_technical(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$allowORRemoveAccess = $this->input->post('d');
		}
		$leadID = $this->input->post('t');
		$id = $this->input->post('i');
		$this->load->model('user_model');
		$getData = $this->user_model->getDueDataByID($id);
		if((int)$allowORRemoveAccess>=0 && count($getData) && (int)$getData->project_type==9){
			$this->user_model->update_due_logtime(array('permmission'=>$allowORRemoveAccess),$id);
			$emailTo = explode(',',$getData->expert);
			$contactEmail = trim($emailTo[0]);
			if(!empty($contactEmail)){	
				$this->load->model('lead_model');
				$contactDetails = $this->lead_model->getContactByEmail($contactEmail);
				if(count($contactDetails)>0){
					$getOpenData = $this->lead_model->checkOpenProjectDataByContactID($leadID,$contactDetails->id,(int)$getData->project_type);
					if(count($getOpenData)>0){
						$status = 2;
						if((int)$allowORRemoveAccess==1){
							$status = 1;
						}
						$this->lead_model->updateOpenProjectData(array('status'=>$status),$getOpenData->id);
						$data = 1;
					}
				}				
			}
		}
		echo $data;
		die;
	}	
	/*
	public function file_permission_technical(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$allowORRemoveAccess = $this->input->post('d');
			$leadID = $this->input->post('t');
			$id = $this->input->post('i');
			$getData = $this->user_model->getDueDataByID($id);
			if(count($getData)>0){
				$accessCode = '12345';
				if((int)$allowORRemoveAccess==0){
					$accessCode = 'synpat@123';
				}
				$this->user_model->update_due_logtime(array('permmission'=>$allowORRemoveAccess),$id);
				
				$emails = explode(',',$getData->expert);
				$contactEmail = trim($emailTo[0]);
				if(!empty($contactEmail)){					
					
					$contactDetails = $this->lead_model->getContactByEmail($contactEmail);
					$fileType = 0;
					if(count($contactDetails)>0){
						$attachFileName = strtolower(strtoupper($getData->type));
						if(strpos($attachFileName,'patent')!==false){
							$fileType = 1;
						} else if(strpos($attachFileName,'tech')!==false){
							$fileType = 2;
						} else if(strpos($attachFileName,'legal')!==false){
							$fileType = 3;
						} else if(strpos($attachFileName,'claim')!==false){
							$fileType = 4;
						} else if(strpos($attachFileName,'royalty')!==false){
							$fileType = 5;
						} else if(strpos($attachFileName,'invitees')!==false){
							$fileType = 6;
						} else if(strpos($attachFileName,'seller')!==false){
							$fileType = 7;
						}else if(strpos($attachFileName,'intro')!==false){
							$fileType = 8;
						}else if(strpos($attachFileName,'comparable')!==false){
							$fileType = 9;
						}else if(strpos($attachFileName,'pdf')!==false){
							$fileType = 10;
						}else if(strpos($attachFileName,'images')!==false){
							$fileType = 11;
						}
						if($fileType>0){
							$getOpenData = $this->lead_model->checkOpenProjectData($leadID,$fileType);
							if(count($getOpenData)>0){
								$openAccess = 1;
								if($allowORRemoveAccess==1){
									$openAccess = 0;
								}
								$this->lead_model->updateOpenProjectData(array('status'=>$openAccess),$getOpenData->id);
							}
							
							$updateDataInDocket = array();
							switch((int)$fileType){
								case 11:
									
									$updateDataInDocket = array('images_access_code'=>$accessCode,'images_email_address'=>'');
								break;
								case 10:
									
									$updateDataInDocket = array('pdf_access_code'=>$accessCode,'pdf_email_address'=>'');
								break;
								case 9:
									
									$updateDataInDocket = array('comparables_access_code'=>$accessCode,'comparables_email_address'=>'');
								break;
								case 2:
									
									$updateDataInDocket = array('tech_access_code'=>$accessCode,'tech_email_address'=>'');
								break;
								case 1:
									
									$updateDataInDocket = array('legal_access_code'=>$accessCode,'legal_email_address'=>'');
								break;
								case 7:
																
								break;
								case 4:
								case 5:
								case 6:
									
									$fileURL = $getData->file_url;
									$fileURL = str_replace("/edit?usp=drivesdk","",$fileURL);
									$fileURL = str_replace("/view?usp=drivesdk","",$fileURL);
									$fileUrlExplode = explode('/',$fileURL);
									$fileID = array_pop($fileUrlExplode);
									if(!empty($fileID)){
										$this->load->library('DriveServiceHelper');
										$service = new DriveServiceHelper();
										$getFileDetail = $service->getFileInfo($file);
										if($getFileDetail){
											$service->deletePermission($getFileInfo->id,"anyoneWithLink");				
										}
									}
								break;
							}
							if(count($updateDataInDocket)>0){
								$getAcqData = $this->acquisition_model->getData($leadID);	
								$updateDataInDocket['license_number'] = $getAcqData['acquisition']->store_name;
								$curl = curl_init();
								curl_setopt_array($curl, array(
									CURLOPT_RETURNTRANSFER => 1,
									CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/resetDocketAccessCode',
									CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
									CURLOPT_POST => 1,
									CURLOPT_POSTFIELDS => $updateDataInDocket
								));
								// Send the request & save response to $resp
								$resp = curl_exec($curl);
								if($resp){
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
	*/
	
	/*
	public function clear_cache(){
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
	*/
	/*
	function generate_comparables_pdf(){
		
		$links = array('http://www.sec.gov/Archives/edgar/containers/fix068/855683/000112528206002245/b412754ex10_10.txt','http://www.sec.gov/Archives/edgar/containers/fix049/1081197/000089161899001414/0000891618-99-001414.txt','http://www.sec.gov/Archives/edgar/data/1096325/000088981200003853/0000889812-00-003853-0001.txt','http://www.sec.gov/Archives/edgar/data/1074828/000119983514000047/exhibit_10-52.htm','http://www.sec.gov/Archives/edgar/data/1386262/000114036109009648/form10k.htm','http://www.sec.gov/Archives/edgar/containers/fix061/1107947/0001005477-00-002036.txt','http://www.sec.gov/Archives/edgar/data/1322705/000119312505187045/dex106.htm','http://www.sec.gov/Archives/edgar/data/1322705/000119312505187045/dex107.htm','http://www.sec.gov/Archives/edgar/data/1381272/000119312506261688/dex1010.htm');
		$links = array('http://www.sec.gov/Archives/edgar/containers/fix068/855683/000112528206002245/b412754ex10_10.txt');
		$curl = curl_init();
		$postData = array('links'=>$links,'paper'=>"letter",'orientation'=>"portrait");
		echo "<pre>";
		print_r($postData);
		die;
		
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://synpat.com/generate_pdf/generate_pdf.php',
			CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => array(
				'data' => json_encode($postData)
			)
		));
		
		$resp = curl_exec($curl);
		echo $resp;
		die;
		$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/comparables.pdf', "w+");
		fwrite($fh, $resp);
		fclose($fh);
		echo $_SERVER['DOCUMENT_ROOT'].'/public/upload/comparables.pdf';
		die;
		echo "<pre>";
		print_r($resp);
		die;
	}*/
	
	public function google_contact(){
		$data = array();
		$this->load->library('DriveServiceHelper');
		$gmailContact = new GmailServiceHelper();
		if(!isset($_SESSION)){
			session_start();
		}
		if($gmailContact->checkExpiredToken()){
			if($_SESSION['another_access_token']!=""){
				$google_token= json_decode($_SESSION['another_access_token']);
				if(isset($google_token->refresh_token)){						
					$gmailContact->refreshToken($google_token->refresh_token);
					$newToken = json_decode($gmailContact->getAccessToken());
					$google_token->id_token = $newToken->id_token;
					$google_token->access_token = $newToken->access_token;
					$google_token->created = $newToken->created;
					$google_token = json_encode($google_token);						
					$_SESSION['another_access_token'] = $google_token;
					$_SESSION['access_token'] = $google_token;
				}	
			}
		}			
		$gmailContact->setAccessToken($_SESSION['another_access_token']);
		$allFeed = $gmailContact->getAllContacts();		
		try{
			if(count($allFeed)>0){
				$pathInclude = get_include_path().PATH_SEPARATOR;
				set_include_path($pathInclude.$_SERVER['DOCUMENT_ROOT']."/application/libraries/ZendGdata-1.12.9/library");
				$this->load->library('Google_Contact');
				$feed = new Zend_Gdata_App_Feed();
				$feed->setMajorProtocolVersion(null);
				$feed->setMinorProtocolVersion(null);
				$feed->transferFromXML($allFeed);
				$feed->setHttpClient(new Zend_Http_Client());
				$results = array();				
				foreach($feed as $entry){
					$xml = simplexml_load_string($entry->getXML());						
					$obj = new stdClass;
					$obj->id = $entry->getEditLink()->href;
					$obj->name = (string) $entry->title;
					$obj->orgName = (string) $xml->organization->orgName; 
					$obj->orgTitle = (string) $xml->organization->orgTitle; 
					foreach ($xml->email as $e) {
					  $obj->emailAddress[] = (string) $e['address'];
					}
					
					if(isset($xml->userDefinedField)){
						foreach($xml->userDefinedField as $e){
							$obj->sectors[] = (string) $e['value'];
						}
					} else {
						$obj->sectors = "";
					}
					foreach ($xml->phoneNumber as $p) {
					  $obj->phoneNumber[] = (string) $p;
					}
					foreach ($xml->website as $w) {
					  $obj->website[] = (string) $w['href'];
					}
					$results[] = $obj;  
				}
				$data['contacts'] = $results;
			}
		} catch(Exception $e){
			
		}
		$this->layout->layout='opportunity';	
		$this->layout->title_for_layout = 'Backyard Opportunity List';
		$this->layout->render('opportunity/google_contact',$data);
	}	
	public function full_copy( $source, $target ) {
		if ( is_dir( $source ) ) {
			if(!is_dir($target)){
				@mkdir( $target );
			}			
			$d = dir( $source );
			while ( FALSE !== ( $entry = $d->read() ) ) {
				if ( $entry == '.' || $entry == '..' ) {
					continue;
				}
				$Entry = $source . '/' . $entry; 
				if ( is_dir( $Entry ) ) {
					$this->full_copy( $Entry, $target . '/' . $entry );
					continue;
				}
				copy( $Entry, $target . '/' . $entry );
			}

			$d->close();
		}else {
			copy( $source, $target );
		}
	}	
	public function store_folder_updated(){
		if(session_id() == '') {
			session_start();
		}
		unset($_SESSION["run_update_docket_files"]);
		die;
	}
	public function getStoreDIRList(){
		$storeDirectories = array('store','dd','comparedd','legaldd','marketdd','techdd');
		/*foreach($storeDirectories as $storeDirectorie){
			$dir = $_SERVER['DOCUMENT_ROOT'].'/../synpat/'.$storeDirectorie.'/';
			$directoryList = scandir($dir);
			$src = $_SERVER['DOCUMENT_ROOT'].'/../synpat/'.$storeDirectorie.'/12345/';
			$srcDirectoryList = scandir($src);
			for($i=2;$i<count($directoryList);$i++){
				if($directoryList[$i]!='12345'){
					$destination = $_SERVER['DOCUMENT_ROOT'].'/../synpat/'.$storeDirectorie.'/'.$directoryList[$i];
					if(is_dir($destination)){
						foreach($srcDirectoryList as $directory){
							if($directory!='license.php' && $directory!='.' && $directory!='..'&& $directory!='uploads'){
								$this->full_copy( $src.$directory, $destination.'/'.$directory );
							}
						}					
					}
				}
			}
		}*/
		die;
	}	
	public function viewFile(){
		$messageID = $this->input->post('message_id');
		$attachmentID = $this->input->post('attachment');
		$mimeType = base64_decode($this->input->post('mimeType'));
		$this->load->library('DriveServiceHelper');
		if(!isset($_SESSION)){
			session_start();
		}
		$service = new GmailServiceHelper();
		$service->setAccessToken($_SESSION['access_token']);
		$findThreadData =  $service->downloadAttachments($messageID,$attachmentID);	
		$fileName = time().$this->input->post('filename');
		$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$fileName, "w+");
		fwrite($fh, base64_decode($findThreadData->data));
		fclose($fh);
		echo json_encode(array("url"=>$this->config->base_url()."public/upload/".$fileName));
		die;
	}	
	public function index()	{			
		$this->layout->title_for_layout = 'Backyard Client List';
		$this->layout->render('client/index');
	}	
	public function opportunity_list(){		
		$userID = $this->session->userdata['id'];
		$this->load->model('opportunity_model');
		if((int)$this->session->userdata['type']!=9){
			$data['projects'] = $this->opportunity_model->getMyAssignedLeads($userID);
		} else {
			$data['projects'] = $this->opportunity_model->getAllLeads();
		}		 
		$this->layout->title_for_layout = 'Backyard Opportunity List';
		$this->layout->render('opportunity/opportunity_list',$data);
	}
	public function invitees_list($leadID=0){
		$data  = array('list'=>array());
		if($leadID>0){
			$this->load->model('opportunity_model');
			$data['list'] = $this->opportunity_model->getCompanyByNameListing("co.id,co.company_name,lc.company_id,lc.type",$leadID);
		}
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Outsource Charts';
		$this->layout->render('opportunity/invitees',$data);
	}
	public function editPreCompanyOrCompanyData(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$companyID = $this->input->post('company_id');
			$type = $this->input->post('type');
			$linkedinURL = $this->input->post('url');
			switch($type){
				case 'company':
					$this->load->model('customer_model');
					$data = $this->customer_model->updateCompanyData($companyID,array('linkedin_url'=>$linkedinURL));
				break;
				case 'pre-company':
					$this->load->model('lead_model');
					$data = $this->lead_model->updatePreCompanies(array('linkedin_url'=>$linkedinURL),$companyID);
				break;
			}
		}
		echo $data;
		die;
	}
	public function eou_in_folder($id=null,$filterOption = null){
		/*$this->layout->layout='opportunity';	*/
		$this->layout->layout='outsource';	
		$data = array();
		/*if($id!=null){
			$data['lead_id'] = $id;
			$leadData = $this->lead_model->getLeadData($id);
			if(count($leadData)>0){
				$data['eou_data'] =$this->user_model->getAllDueDilligenceProject($id);
			}			
		} else {
			$data['eou_data'] =$this->user_model->getAllDueDilligenceProject();
		}*/
		$this->load->model('user_model');
		$data['eou_data'] =$this->user_model->getAllDueDilligenceProject();
		$data['filter_option'] = $filterOption;
		$this->layout->title_for_layout = 'EOU in Folder';
		$this->layout->render('opportunity/eou_in_folder',$data);
	}
	public function ajax_eou_in_folder(){
		$this->load->model('user_model');
		$eou_data = $this->user_model->getAllDueDilligenceProject();
		$result = array();
		if(count($eou_data)>0){
			$i=0;
			for($i=0;$i<count($eou_data);$i++){
				$allEmails = explode(',',$eou_data[$i]->expert);
				$companyID = 0;
				$getData = array();
				$companyName = "";
				if(trim($allEmails[0])!=''){
					$this->load->model('opportunity_model');
					$getData = $this->opportunity_model->find_contact_by_email($allEmails[0]);
					if(count($getData)>0){
						$companyID = $getData->company_id;
						$companyName = $getData->company_name;
					}
				}
				$type = "";
				switch((int)$eou_data[$i]->project_type){
					case 1:
						$type = "Patent";
					break;
					case 2:
						$type = "TechDD";
					break;
					case 3:
						$type = "LegalDD";
					break;
					case 4:
						$type = "IllustrationDD";
					break;
					case 5:
						$type = "Royalty";
					break;
					case 6:
						$type = "Invitees";
					break;
					case 7:
						$type = "SellerDD";
					break;
					case 8:
						$type = "Introduction";
					break;
					case 9:
						$type = "CompareDD";
					break;
					case 10:
						$type = "PdfDD";
					break;
					case 11:
						$type = "IntroImages";
					break;
					case 12:
						$type = "MarketDD";
					break;
					case 13:
						$type = "DictionaryDD";
					break;
				}
				$htmlGetData='';
				$company_id = 0;
				if(count($getData)>0){
					$htmlGetData= $getData->company_name;
				}
				$checkBox = 'hide';
				$checked=false;
				if($eou_data[$i]->permmission==1):$checked=true; endif;
				if((int)$eou_data[$i]->project_type==9 || (int)$eou_data[$i]->project_type==13):
					$checkBox = 'show';
				endif;
				$projectName = $eou_data[$i]->lead_name;
				$result[] = array("id"=>$eou_data[$i]->id,"lead_id"=>$eou_data[$i]->lead_id,"project_type"=>$eou_data[$i]->project_type,"company_name"=>$companyName,"companyID"=>$companyID,"project_name"=>$projectName,"type"=>$type,"create_date"=>date('M d,y',strtotime($eou_data[$i]->create_date)),"email"=>$allEmails[0],"get_html_data"=>$htmlGetData,"permission_check"=>$checkBox,"duration"=>$eou_data[$i]->duration,"total_patent"=>$eou_data[$i]->total_patent,"checked"=>$checked,"access_code"=>$eou_data[$i]->access_code,"password"=>$eou_data[$i]->password);
			}
		}
		echo json_encode($result);
		die;
	}	
	public function save_accordion_text(){
	    $data ="";
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			if((int)$postData['lead_id']>0){
				$this->load->model('acquisition_model');
				$getAcqData = $this->acquisition_model->getData($postData['lead_id']);	
				if(count($getAcqData)>0){
					$mode = $postData['mode'];
					unset($postData['lead_id']);
					unset($postData['mode']);
					if((int)$mode==0){
						$postData['license_number'] = $getAcqData['acquisition']->store_name;
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
					} else if((int)$mode==1){
						$this->load->model('opportunity_model');
						$data = $this->opportunity_model->updateLicenseAccessCode($postData,0,12345);
					}
				}				
			}
		}
		echo $data;
		die;
	}	
	public function mime_type($file) {
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
	public function save_pre_lead(){
		$data = $this->input->post();
		if(count($data)>0){
			$serialNumber = $data['serial_number'];
			$leadID = $data['lead_id'];
			$this->load->model('lead_model');
			$getLeadData = $this->lead_model->getLeadDataWithOptions($leadID,'l.lead_name,l.seller_material_folder_id');
			$leadName = "";
			if(count($getLeadData)>0){
				$leadName = $getLeadData->lead_name;
			}
			if(isset($_FILES) && isset($_FILES['drive_file_upload'])){
				if(count($getLeadData)>0 && !empty($getLeadData->seller_material_folder_id)){
					/*Upload to Google Drive*/
					if(!empty($_FILES['drive_file_upload']['tmp_name'])):
					$filename = $_FILES['drive_file_upload']['name'];
					$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
					fwrite($fh, file_get_contents($_FILES['drive_file_upload']['tmp_name']));
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
					}
					endif;
				} else{
					/*Upload to AWS Server*/
					if(!empty($_FILES['drive_file_upload']['tmp_name'])):
						$filename = $_FILES['drive_file_upload']['name'];
						$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename, "w+");
						fwrite($fh, file_get_contents($_FILES['drive_file_upload']['tmp_name']));
						fclose($fh);
						$fileName = $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$filename;
						$fileData = $this->add_aws_file($filename,$fileName);
						$fileAWS = "";
						if(count($fileData)>0 && $fileData['error']==0){
							unlink($fileName);
							/*$fileAWS = $fileData['file_url'];*/
						}
					endif;
				}
			}
			$data['n_name'] = json_encode($data['n_name'],JSON_UNESCAPED_SLASHES);
			$data['r_lice'] = json_encode($data['r_lice'],JSON_UNESCAPED_SLASHES);
			$data['r_link'] = json_encode($data['r_link'],JSON_UNESCAPED_SLASHES);
			$data['country_n'] = json_encode($data['country_n']);
			$data['application_n'] = json_encode($data['application_n']);
			$data['patent_n'] = json_encode($data['patent_n']);
			$data['lead_name'] = $leadName;
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'https://synpat.com/pre_lead.php',
				CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS =>$data
			));
			$resp = curl_exec($curl);

			if($resp){
				$data =$resp;
				$this->load->model('user_model');
				$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$leadID,'message'=>'Update pre lead data','create_date'=>date('Y-m-d H:i:s')));
			} else {
				$data= array();
			}
			if(isset($serialNumber) && isset($leadID) && (int)$leadID>0 && (int)$serialNumber>0){
				redirect("opportunity/all_list?alx=".$serialNumber."&plx=".$leadID);			
			} else {
				redirect("opportunity/all_list");			
			}	
		} else {
			redirect("opportunity/all_list");
		}			
	}	
	public function add_aws_file($fileName,$sourceFile){
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
	public function pre_lead_on_fly(){
		$data = $this->input->post();
		if(count($data)>0){
			if(isset($data['serial_number'])){
				$serialNumber = $data['serial_number'];
				$leadID = 0;
				if(isset($data['lead_id'])){
					$this->load->model('lead_model');
					$leadID = $data['lead_id'];
					$getLeadData = $this->lead_model->getLeadData($leadID);
					$leadName = "";
					if(count($getLeadData)>0){
						$leadName = $getLeadData->lead_name;
					}
					$data['n_name'] = json_encode($data['n_name']);
					$data['r_lice'] = json_encode($data['r_lice']);
					$data['r_link'] = json_encode($data['r_link']);
					$data['country_n'] = json_encode($data['country_n']);
					$data['application_n'] = json_encode($data['application_n']);
					$data['patent_n'] = json_encode($data['patent_n']);
					$data['seller_material_link'] = json_encode($data['seller_material_link']);
					$data['lead_name'] = $leadName;
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, 'https://synpat.com/pre_lead.php');
					curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6');
					curl_setopt($curl, CURLOPT_HEADER, 0);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_POST, 1);
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 120);
					curl_setopt($curl, CURLOPT_TIMEOUT, 120);
					$resp = curl_exec($curl);
					if($resp){
						$data =$resp;
						$this->load->model('user_model');
						$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$leadID,'message'=>'Update pre lead data','create_date'=>date('Y-m-d H:i:s')));
					} else {
						$data= array();
					}
				}
			}			
		}
		die;
	}	
	public function checkValidateMinPrice($data,$askingPrice,$list){		
		$validData = array();
		if(count($data)>0){
			$minPrice = (float)($askingPrice/count($data));
			$minPrice = number_format($minPrice,3); 
			/*echo "In validated:".$minPrice."<br/>";*/
			foreach($data as $passedID){
				if(count($list)>0){
					foreach($list as $participant){
						if($participant->id==$passedID){
							$price = number_format($participant->price,3);		
							if((int)str_replace('.','',$price)>= (int)str_replace('.','',$minPrice)){
								$validData[] = $participant->id;
							}
						}
					}
				}
			}
		}
		/*echo "<pre>";print_r($validData);*/
		if(count($validData)==count($data)){
			/*echo "BINGO<br/>";*/
			return true;
		} else {
			return false;
		}
	}	
	
	public function get_display_prices(){
		$data = array();
		$this->load->model("lead_model");
		if(isset($_POST) && count($_POST)>0){
			$licenseData = $this->lead_model->getPotentialDataByID($this->input->post('p'),'license_id');
			if(count($licenseData)>0 && $licenseData->license_id>0){
				$findSerialNumber = $this->lead_model->findLeadFromLicenseID($licenseData->license_id,'l.serial_number');
				$data = $this->lead_model->findCommitmentsData($licenseData->license_id,'license_id,amount,commitment_date');
				if(count($data)>0){
					for($i=0;$i<count($data);$i++){
						$data[$i]->license_id = $findSerialNumber->serial_number;
					}
				}
			}
		}
		echo json_encode($data);
	}
	
	public function updateRevisesdTargetData(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			$this->load->model("lead_model");
			$getRevisedData = $this->lead_model->getRevisedDocumentByID($postData['t'],'id,type,company_id');
			if(count($getRevisedData)>0){
				if($getRevisedData->type ==3){
					$updateArray = array();
					switch($postData['d'][1]){
						case 'target_company_name':
							if(trim($postData['d'][3])!=""){
								$checkCompany = $this->lead_model->getCompanyName($postData['d'][3],'id');
								if(count($checkCompany)>0){
									$updateArray['company_id'] = $checkCompany->id;
								}
							}
						break;
					}
					if(count($updateArray)>0){
						$data = $this->lead_model->updateRevisedDocumentRequest($updateArray,$getRevisedData->id);
					}
				} else {
					$data =$getRevisedData->id;
				}				
			}
		}
		echo $data;
	}
	
	public function update_request_to_participate_data(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			$this->load->model("lead_model");
			$getParticipantData = $this->lead_model->findRequestToParticipantById($postData['t'],'id,price,document_type,company_id');
			if(count($getParticipantData)>0){
				$updateArray = array();
				switch($postData['d'][1]){
					case 'price':
						if($postData['d'][2]==$getParticipantData->price){
							if($postData['d'][3]>0){
								$updateArray['price'] = $postData['d'][3];
							}
						}
						break;
					case 'doc_type':
						$dt = 0;
						if($postData['d'][2]=="NEL"){
							$dt = 2;
						}else if($postData['d'][2]=="STL"){
							$dt = 3;
						}
						if($dt==$getParticipantData->document_type){
							$nDT = 0;
							if($postData['d'][3]=="NEL"){
								$nDT = 2;
							}else if($postData['d'][3]=="STL"){
								$nDT = 3;
							}
							if($nDT>0){
								$updateArray['document_type'] = $nDT;
							}
						}
						break;
					case 'target_company':
						if(trim($postData['d'][3])!=""){
							$checkCompany = $this->lead_model->getCompanyName($postData['d'][3],'id');
							if(count($checkCompany)>0){
								$updateArray['company_id'] = $checkCompany->id;
							}
						}
						break;
				}
				if(count($updateArray)>0){
					$data = $this->lead_model->updateRequestParticpantData($updateArray,$getParticipantData->id);
				}
			}
		}
		echo $data;
		die;
	}
	
	public function move_participate_unPromise(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			$this->load->model("lead_model");
			$getPotentialParticipantData = $this->lead_model->getPotentialDataByID($postData['p'],'id,status');
			if(count($getPotentialParticipantData)>0){
				$insertUnPromisingArray = array('license_id'=>$getPotentialParticipantData->license_id,'customer_id'=>$getPotentialParticipantData->customer_id,'company_name'=>$getPotentialParticipantData->company_name,'person_name'=>$getPotentialParticipantData->person_name,'person_phone'=>$getPotentialParticipantData->person_phone,'person_email'=>$getPotentialParticipantData->person_email,'message'=>$getPotentialParticipantData->message,'file'=>$getPotentialParticipantData->file,'price'=>$getPotentialParticipantData->price,'type'=>$getPotentialParticipantData->type,'create_date'=>$getPotentialParticipantData->create_date,'doc_type'=>$getPotentialParticipantData->doc_type,'company_id'=>$getPotentialParticipantData->company_id);
				$data = $this->lead_model->insertUpromisingParticipants($insertUnPromisingArray);
			}
		}
		echo $data;
		die;
	}
	
	public function update_potential_participants_status(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			$this->load->model("lead_model");
			$getPotentialParticipantData = $this->lead_model->getPotentialDataByID($postData['p'],'id,status');
			if(count($getPotentialParticipantData)>0){
				if($postData['a']!=$getPotentialParticipantData->status){
					$data = $this->lead_model->updatePotentialData(array('status'=>$postData['a']),$getPotentialParticipantData->id);
				} else {
					$data = $getPotentialParticipantData->id;
				}		
			}
		}
		echo $data;
		die;
	}
	
	public function update_participants_status(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			$this->load->model("lead_model");
			$getParticipantData = $this->lead_model->findRequestToParticipantById($postData['p'],'id,status');
			if(count($getParticipantData)>0){
				if($postData['a']!=$getParticipantData->status){
					$data = $this->lead_model->updateRequestParticpantData(array('status'=>$postData['a']),$getParticipantData->id);
				} else {
					$data = $getParticipantData->id;
				}		
			}
		}
		echo $data;
		die;
	}
	
	public function find_company_list_by_name(){
		$data = array();
		if(isset($_GET) && isset($_GET['query']) && $_GET['query']!="" && strlen($_GET['query'])>2){
			$postData = $this->input->post();
			$this->load->model("lead_model");
			$getCompanyNames = $this->lead_model->getCompanyList($_GET['query'],'company_name');
			if(count($getCompanyNames)>0){
				foreach($getCompanyNames as $company){
					array_push($data,$company->company_name);
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function runAlgoCheckSyndication(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model("lead_model");
			$getParticipantData = $this->lead_model->runAlgoCheckSyndication($this->input->post('p'));
			if(count($getParticipantData['particpant_list']>0)){
				if(count($getParticipantData['license_detail'])>0){
					$getAskingPrice = (float)$getParticipantData['license_detail']->asking_price;
					$getAskingPrice = number_format($getAskingPrice,3);
					/*echo "ASK:".$getAskingPrice."N<br/>";*/
					if($getAskingPrice>0 && count($getParticipantData['particpant_list']>0)){
						$total = 0.000;
						$endSyndicate = 0;
						$epsilon = 0.1;
						$minPrice = (float)($getAskingPrice/count($getParticipantData['particpant_list']));
						$minPrice = number_format($minPrice,3);
						$allIDs = array();
						/*echo "MIn Price:".$minPrice."N<br/>";*/
						/*echo "<pre>";
						print_r($getParticipantData['particpant_list']);*/
						foreach($getParticipantData['particpant_list'] as $participant){
							/*$total = $participant->price + $total;
							if($getAskingPrice>=$total){
								if($participant->price>=$minPrice){
									array_push($data,$participant->id);
								}
							} else {
								if($participant->price>=$minPrice){
									$endSyndicate = 1;
									array_push($data,$participant->id);
									break;
								} else {
									$total = $total - $participant->price;
								}
							}*/
							array_push($allIDs,$participant->id);
							$price = number_format($participant->price,3);	
							/*echo "CURRENT Price:".$price."N<br/>";*/
							$total = (float)$total + (float)$price;	
							$total =  number_format($total,3);	
							/*echo "Total Now:".$total."N<br/>";*/
							if((int)str_replace('.','',$price)>= (int)str_replace('.','',$minPrice)){
								/*echo "Validated<br/>";*/
								array_push($data,$participant->id);
							} else {								
								$total = $total - $participant->price;
							}
							if(($this->checkValidateMinPrice($data,$getAskingPrice,$getParticipantData['particpant_list'])) && ((int)str_replace('.','',$total)>= (int)str_replace('.','',$getAskingPrice))){								
								$endSyndicate = 1;								
								break;
							}
						}	
						if(count($allIDs)>0){
							/*update avg and sum*/
							$updateBatch = array();
							foreach($allIDs as $d){
								$updateBatch[] = array('avg'=>$minPrice,'sum'=>$total,'id'=>$d);
							}
							if(count($updateBatch)>0){
								$this->lead_model->updatePotentialInBatch($updateBatch);
							}
						}
						if($endSyndicate==0){
							$data = array();
						}
						$updateData = $this->lead_model->updatePotentialDataByLicense(array('colored'=>0),$getParticipantData['license_detail']->id);
						if(count($data)>0){							
							$updateBatch = array();
							foreach($data as $d){
								$updateBatch[] = array('colored'=>1,'id'=>$d);
							}
							if(count($updateBatch)>0){
								$this->lead_model->updatePotentialInBatch($updateBatch);
								/*update in synpat store as well*/								
							}
						}
						$getLeadData = $this->lead_model->findSerialNumber($getParticipantData['license_detail']->serial_number);
						if(count($getLeadData)>0){
							$this->load->model("acquisition_model");
							$costPrice = 0.000;
							if(count($data)>0){
								$costPrice = $getAskingPrice/count($data);
							}
							$this->acquisition_model->updateData($getLeadData->id,array('potential_participants'=>count($getParticipantData['particpant_list']),'final_participants'=>count($data),'cost_price'=>number_format($costPrice, 3)));
						}
					}
				}
			}
		}
		echo json_encode($data);
		die;
	}	
	public function update_store_active_button(){
		$data = "0";
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();			
			$this->load->model('acquisition_model');
			$this->load->model('lead_model');
			$data = $this->acquisition_model->updateData($postData['l'],array('active_button'=>$postData['s']));
			/*Update in licenses*/
			$leadSerialNumber = $this->lead_model->getLeadDataWithOptions($postData['l'],"l.serial_number");
			if(count($leadSerialNumber)>0){
				$this->lead_model->updateLicenseDataBySerialNumber($postData['s'],$leadSerialNumber->serial_number);
			}
		}
		echo $data;
		die;
	}	
	
	
	public function potential_syndicate(){
		$data = "0";
		if(isset($_POST) && count($_POST)>0){
			$postData = $this->input->post();
			if((int)$postData['p']>0){
				$this->load->model('lead_model');
				$getPotentialData = $this->lead_model->getPotentialDataByID($postData['p'],"license_id");
				if(count($getPotentialData)>0){
					$dataUpdate = array();
					if($postData['a']=="add"){
						$dataUpdate = array('display'=>1);
					} else if($postData['a']=="delete"){
						$dataUpdate = array('display'=>0);
					}
					if(count($dataUpdate)>0){
						$data = $this->lead_model->updatePotentialData($dataUpdate,$postData['p']);
						if($data>0){
							$commitedData = $this->lead_model->findAllDisplayPriceData($getPotentialData->license_id,"send_date,price");
							$this->lead_model->deleteCommitments($getPotentialData->license_id);
							if(count($commitedData)>0){
								/*Delete COmmitted Data*/
								for($i=0;$i<count($commitedData);$i++){	
									$this->lead_model->insertCommitment(array('license_id'=>$getPotentialData->license_id,'commitment_date'=>$commitedData[$i]->send_date,'amount'=>$commitedData[$i]->price));
								}								
							}
							$this->load->model('opportunity_model');
							$this->opportunity_model->updateLicenseAccessCode(array('current_requesting_companies'=>count($commitedData)),$getPotentialData->license_id,0);
						}
					}
				}
			}
		}
		echo $data;
		die;
	}	
	public function assign_sales_company_to_broker(){
		$data= 0;
		if(isset($_POST) && count($_POST)>0){
			$salesCompanies = $this->input->post('companies');
			if(!empty($salesCompanies)){
				$salesC = json_decode($salesCompanies);
				$leadID = $this->input->post('l');
				$brokerCompany = $this->input->post('broker_company');
				if(count($salesC)>0 && is_array($salesC) && (int) $leadID>0 && (int)$brokerCompany>0){
					for($i=0;$i<count($salesC);$i++){
						/*Assign broker to sales companies*/
						if((int)$salesC[$i]>0){
							$this->load->model('lead_model');
							$this->lead_model->deleteSalesBrokerLeadCompany(array('lead_id'=>$leadID,'sales_company_id'=>$salesC[$i]));
							$data = $this->lead_model->insertSalesBrokerLeadCompany(array('lead_id'=>$leadID,'broker_company_id'=>$brokerCompany,'sales_company_id'=>$salesC[$i]));
						}						
					}
				}
			}
		}
		echo $data;
		die;
	}	
	public function assign_presales_company_to_broker(){
		$data= 0;
		if(isset($_POST) && count($_POST)>0){
			$salesCompanies = $this->input->post('companies');
			if(!empty($salesCompanies)){
				$salesC = json_decode($salesCompanies);
				$leadID = $this->input->post('l');
				$brokerCompanyRaw = $this->input->post('broker_company');
				$brokerCompany = array();
				if(!empty($brokerCompanyRaw)){
					$brokerCompany = json_decode($brokerCompanyRaw);
				}				
				if(count($salesC)>0 && is_array($salesC) && (int) $leadID>0 && count($brokerCompany)>0){
					for($i=0;$i<count($salesC);$i++){
						/*Assign broker to sales companies*/
						if((int)$salesC[$i]>0){
							$this->load->model('lead_model');
							for($j=0;$j<count($brokerCompany);$j++){
								if((int)$brokerCompany[$j][0]>0){
									$data = $this->lead_model->insertPreSalesBrokerLeadCompany(array('lead_id'=>$leadID,'broker_company_id'=>$brokerCompany[$j][1],'company_id'=>$salesC[$i],'broker_id'=>$brokerCompany[$j][0]));
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
	public function sales_pre_contact($id=0,$activity=0){
		$data = array();
		if($id>0){
			$this->load->model('lead_model');
			$this->load->model('client_model');
			$data['companies'] = $this->client_model->getAllContacts();
			$data['selected_sales_companies'] = $this->lead_model->getPreSalesBrokerListByLead($id);
			$data['selected_acquisition_companies'] = array();
			$data['lead_id'] = $id;
			$data['activity'] = $activity;
			$this->layout->layout='opportunity';
			$this->layout->title_for_layout = 'Backyard';
			$this->layout->render('opportunity/sales_pre_contact',$data);
		} else {
			echo 'Sorry page not found.';
			die;
		}
	}

	public function find_company_users(){
		$data = array();
		if(isset($_POST['c']) && (int)$_POST['c']){
			$this->load->model('customer_model');
			if(isset($_POST['p']) && $_POST['p']==0){
				$this->customer_model->updateALLContactsBelongToCompany(array('scraped_p'=>0),$_POST['c']);
			}
			$data = $this->customer_model->getAllContactBelongToCompany($_POST['c']);
		}
		echo json_encode($data);
		die;
	}	

	public function listOfUsers(){
		$data = array();
		if(isset($_POST['c']) && (int)$_POST['c']){
			$this->load->model('customer_model');
			$data = $this->customer_model->getAllContactBelongToCompany($_POST['c']);
		}
		echo json_encode($data);
		die;
	}

	public function saveScrapperData(){
		if(isset($_POST) && count($_POST)>0){
			$companyID = $this->input->post('company_id');
			$type = $this->input->post('type');
			$list = $this->input->post('list');
			$saveData = array("company"=>$companyID,"type"=>$type,"list"=>json_encode($list));
			$this->load->model('opportunity_model');
			$insertID = $this->opportunity_model->insertLinkedInScrapperList($saveData);
			echo $insertID;
		}
		die;
	}
	
	function check_my_pending_request() {
		$data = array('l'=>0);
		$this->load->model('opportunity_model');
		/*$checkPendingRequest = $this->opportunity_model->checkCompanyListForScrapeByUserID($this->session->userdata['id']);*/
		$checkPendingRequest = $this->opportunity_model->checkCompanyListForScrapeByUserID();
		if($checkPendingRequest > 0) {
			$data['l'] = $checkPendingRequest;
		}
		echo json_encode($data);
		die;
	}
	
	function check_my_pending_contact_request() {
		$data = array('l'=>0);
		$this->load->model('opportunity_model');
		$checkPendingContactRequest = $this->opportunity_model->checkContactListForScrape();
		if($checkPendingContactRequest > 0) {
			$data['l'] = $checkPendingContactRequest;
		}
		echo json_encode($data);
		die;
	}
	
	function findAllCompaniesLinkedin() {
		$data = array();
		if(isset($_POST['c']) && $_POST['c']!=""){
			$this->load->model('customer_model');
			$this->load->model('opportunity_model');
			$companies = json_decode($_POST['c']);
			$type = $this->input->post('t');
			$companiesLinkedinData = $this->customer_model->getAllCompaniesListWithLinkedinUrl($companies);
			$saveCData= array();
			if(count($companiesLinkedinData) > 0 ){
				foreach($companiesLinkedinData as $cd){
					if(strpos($cd->linkedin_url,'linkedin.com')!==false){
						array_push($saveCData,array('company'=>$cd->id,'linkedin_url'=>$cd->linkedin_url,'company_name'=>$cd->company_name,"type"=>$type,"user_id"=>$this->session->userdata['id']));
					}
				}
			}
			if(count($saveCData)>0){
				$data = $saveCData;
				$this->opportunity_model->insertLinkedInCompanyScrapperListInBatch($saveCData);
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function check_running_stage($t=0) {
		$this->load->model('opportunity_model');
		$data = $this->opportunity_model->checkScrapperCompanyRunningStage($t);
		echo json_encode($data);
		die;
	}
	
	public function findAllCompaniesUsers(){
		$data = array('co'=>array(),'c'=>array());
		if(isset($_POST['c']) && $_POST['c']!=""){
			$this->load->model('customer_model');
			$this->load->model('opportunity_model');
			$companies = json_decode($_POST['c']);
			if(isset($_POST['p']) && $_POST['p']==0){
				$this->customer_model->updateALLCompanyContacts(array('scraped_p'=>0),$companies);
			}
			$type = $this->input->post('t');
			$companiesData = $this->customer_model->getAllCompaniesContactWithLinkedinUrl($companies);
			$companiesLinkedinData = $this->customer_model->getAllCompaniesListWithLinkedinUrl($companies);
			
			$saveData = array();
			$saveCData = array();
			$saveCIDs = array();
			if(count($companiesLinkedinData) > 0 ){
				foreach($companiesLinkedinData as $cd){
					if(strpos($cd->linkedin_url,'linkedin.com')!==false){
						if(!in_array($cd->id,$saveCIDs)){
							array_push($saveCData,array('company'=>$cd->id,'linkedin_url'=>$cd->linkedin_url,'company_name'=>$cd->company_name,"type"=>$type,"user_id"=>$this->session->userdata['id']));
							array_push($saveCIDs,$cd->id);
						}
					}
				}
			}
			$requestType = $this->input->post('request_type');
			if($requestType == 'User') {
				foreach($companies as $c){
					$list = array();
					foreach($companiesData as $cd){
						if($c==$cd->company_id){
							$linkedinURL = $cd->linkedin_url;
							if(strpos($linkedinURL,'linkedin.com')!== false){
								$userData = array('id'=>$cd->id,'linkedin_url'=>$linkedinURL,'first_name'=>$cd->first_name,'last_name'=>$cd->last_name);
								$list[] = $userData;
								
							}
						}
					}
					if(count($list)>0){
						$data['c'][] = array("company"=>$c,"type"=>$type,"list"=>$list);
						if(isset($_POST['s']) && $_POST['s']==1){
							/*Check company */
							$check = $this->opportunity_model->checkCompanyInScrappingList($c);
							if($check==0 || $check==null){
								$saveData[] = array("company"=>$c,"type"=>$type,"list"=>json_encode($list));
							}
						}
					}
				}
				if(isset($_POST['s']) && $_POST['s']==1){
					/*Save list to the scrapper table */
					if(count($saveData)>0){
						/*Save to User Queue*/
						$this->opportunity_model->insertLinkedInScrapperListInBatch($saveData);
					}
				}
			} else if($requestType == 'Company') {
				$data['co'] = $saveCData;
				if(count($saveCData)>0){
					/*Save to Company Queue*/
					$this->opportunity_model->insertLinkedInCompanyScrapperListInBatch($saveCData);
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function find_company_detail($leadID,$id=0,$activity=0){
		$this->load->model('customer_model');
		$list = $this->customer_model->companyByID($activity,$leadID,$id);
		echo json_encode($list);
		die;
	}
	
	public function find_companies_to_sectors(){
		$companies = $this->input->post('companies');
		$sectors = array();
		if(count($companies)>0){
			$this->load->model('customer_model');
			$sectors = $this->customer_model->findSectorListFromCompanies($companies);
		}
		echo json_encode($sectors);
	}
	
	public function find_companies_to_sectors_categories_technology(){
		$companies = $this->input->post('companies');
		$allSectorCategoriesTechnologies = array('sectors'=>array(),'categories'=>array(),'subcategories'=>array(),'technologies'=>array(),'subtechnologies'=>array(),'subsubtechnologies'=>array());
		if(count($companies)>0){
			$this->load->model('customer_model');
			$sectors = $this->customer_model->findSectorListFromCompanies($companies);
			if(count($sectors)>0){
				foreach($sectors as $s){
					$allSectorCategoriesTechnologies['sectors'][] = $s->sector_id;
				}
			}
			$mapSectors = array();
			$mapSubSectors = array();
			foreach($companies as $c){
				$departments = $this->customer_model->findMyPreferenceWithNameSub($c,1);
				$mapSubCategory = array();
			    $mapCategpry = array();
			    $category = array();
			    $subCategory = array();
				foreach($departments as $deptt){
					if($deptt->parent==0){
						if(!in_array($deptt->id,$mapCategpry)){
							$mapCategpry[] = $deptt->id;
							$category[] = $deptt->id;
						}						
					} else {					
						if(!in_array($deptt->id,$mapSubCategory)){
							$mapSubCategory[] = $deptt->id;
							$subCategory[] = $deptt->id;
						}
					}					
				}
				$allSectorCategoriesTechnologies['categories'] = $category ;
				$allSectorCategoriesTechnologies['subcategories'] = $subCategory ;
				
				$technologies = $this->customer_model->findTechnologiesPreferenceWithNameSub($c,0);
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$allSectorCategoriesTechnologies['technologies'][] = $tech->id;
					}
				}
				$subTechnologies = $this->customer_model->findTechnologiesPreferenceWithNameSub($c,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$allSectorCategoriesTechnologies['subtechnologies'][] = $tech->id;
					}
				}
				$subsubTechnologies = $this->customer_model->findTechnologiesPreferenceWithNameSub($c,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$allSectorCategoriesTechnologies['subsubtechnologies'][] = $tech->id;
					}
				}
			}
		}
		echo json_encode($allSectorCategoriesTechnologies);
		die;
	}
	
	public function scrapeAllCompaniesByFilterIDs(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			/*$allFromQuery = (int)$this->input->post('all_from_query');
			*/
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sc');
				$subCat = $this->input->post('sst');
				$tech = $this->input->post('stt');
				$subTech = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				$users = $this->input->post('u');
				$industry = $this->input->post('industry');
				$company_size = $this->input->post('company_size');
				$no_of_size = $this->input->post('no_of_size');
				$label = $this->input->post('label');
				$specialist = $this->input->post('specialist');
				$alpha = $this->input->post('alpha');
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
					/*$industry = implode(',',$inds);
					$industry = implode(',',$industry);*/
				} else {
					$industry = array();
				}
				if(is_array($specialist)){
					$specialities = array();
					foreach($specialist as $spec){
						$specialities[] = trim($spec);
					}
					$specialist = $specialities;
				} else {
					$specialist = array();
				}
				if(is_array($company_size)){
					$cs = array();
					foreach($company_size as $c){
						$cs[] = '"'.$c.'"';
					}
					$company_size = $cs;
					/*$company_size = implode(',',$company_size);*/
				} else {
					$company_size = array();
				}
				if(is_array($no_of_size)){					
					$no_of_size = implode(',',$no_of_size);
				} else {
					$no_of_size = "";
				}
				if(is_array($sector)){
					$sector = implode(',',$sector);
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}	
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}	
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}	
				if(is_array($users)){
					$users = implode(',',$users);
				} else {
					$users = "";
				}			
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$start = 0;
				$end = 0;
				$leadID = $this->input->post('lead_id');
				$activity = $this->input->post('a');
				$invited = $this->input->post('invite');
				$this->load->model('customer_model');
				$resultData = $this->customer_model->companyOptimizeListWithPaging($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$label,$specialist,$alpha,$sort,$sortBy,0,0,$leadID,$activity,$invited,false);
				if(count($resultData['data'])>0){
					foreach($resultData['data'] as $c){
						$data[] = $c->id;						
					}
				}				
			}catch(Exception $e){
				
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function add_companies_to_sectors(){
		$data = array('error'=>1,'message'=>'','data'=>array());
		if(isset($_POST) && count($_POST)>0){
			$getData = $this->input->post();
			$sectorIDs = $getData['company']['sector'];
			$jsonCompany = $getData['companies_sel'];
			if(!empty($jsonCompany)){
				try{
					$companies = json_decode($jsonCompany);
					if(count($companies)>0){
						$this->load->model('customer_model');
						$insertArray = array();
						if(count($sectorIDs)>0){
							$addCompanySectorInBatch = array();
							$deleteCompanySectorInBatch = array();
							foreach($companies as $company){
								foreach($sectorIDs as $sec){
									$addCompanySectorInBatch[] = array("sector_id"=>$sec,"company_id"=>$company);
								}
							}
							if(count($addCompanySectorInBatch)>0){
								$this->customer_model->deleteCompanySectors($companies);
								$this->customer_model->addCompanySectorInBatch($addCompanySectorInBatch);
							}
						}	
						$categoriesInBatch = array();
						if(isset($getData['preferences']) && isset($getData['preferences']['departments']) && is_array($getData['preferences']['departments']) && count($getData['preferences']['departments'])>0){
							foreach($companies as $company){
								foreach($getData['preferences']['departments'] as $dept){
									$categoriesInBatch[] = array("customer_id"=>$company,"preference_id"=>$dept,"category_type"=>0);
								}
							}
						}
						
						if(isset($getData['sub']) && isset($getData['sub']['departments']) && is_array($getData['sub']['departments']) && count($getData['sub']['departments'])>0){
							foreach($companies as $company){
								foreach($getData['sub']['departments'] as $dept){
									$categoriesInBatch[] = array("customer_id"=>$company,"preference_id"=>$dept,"category_type"=>1);
								}							
							}							
						}
						if(count($categoriesInBatch)>0){
							$this->customer_model->deleteCustomersPreference($companies);
							$this->customer_model->insertCustomerPreferenceInBatch($categoriesInBatch);
						}
						$technologiesInBatch = array();
						if(isset($getData['preferences']) && isset($getData['preferences']['technology']) && is_array($getData['preferences']['technology']) && count($getData['preferences']['technology'])>0){
							foreach($companies as $company){
								foreach($getData['preferences']['technology'] as $tech){
									$technologiesInBatch[] = array("company_id"=>$company,"preference_id"=>$tech,"type"=>0);
								}
							}
						}
						if(isset($getData['preferences']) && isset($getData['preferences']['subtechnology']) && is_array($getData['preferences']['subtechnology']) && count($getData['preferences']['subtechnology'])>0){
							foreach($companies as $company){
								foreach($getData['preferences']['subtechnology'] as $tech){
									$technologiesInBatch[] = array("company_id"=>$company,"preference_id"=>$tech,"type"=>1);
								}
							}
						}
						
						if(isset($getData['sub']) && isset($getData['sub']['technology']) && is_array($getData['sub']['technology']) && count($getData['sub']['technology'])>0){
							foreach($companies as $company){
								foreach($getData['sub']['technology'] as $tech){
									$technologiesInBatch[] = array("company_id"=>$company,"preference_id"=>$tech,"type"=>2);
								}
							}
						}
						if(count($technologiesInBatch)>0){
							$this->customer_model->deleteCustomersTechnologyPreference($companies);
							$this->customer_model->insertCustomerTechnologyPreferenceInBatch($technologiesInBatch);
						}
						$data['error'] = 0;
						if((int)$this->input->post('mode')==0){
							$data['data'] = $this->customer_model->getSelectedCompaniesSectorsTechnologiesList($companies);
						}						
					} else {
						$data['message'] = "Please select companies.";
					}
				}catch(Exception $e){
					
				}
			} else {
				$data['message'] = "Please select companies.";
			}
		} else {
			$data['message'] = "Please select companies.";
		}
		echo json_encode($data);
		die;
	}
	
	public function find_next_batch(){
		$data = array();
		if(!isset($_SESSION)){
			session_start();
		}
		if(isset($_SESSION['batch_data']['companies']) && count($_SESSION['batch_data']['companies'])>0){
			$batchStart = (int)$this->input->post('s');
			$batchEnd = (int)$this->input->post('e');
			$data = $_SESSION['batch_data'];
			if(isset($data['companies'][$batchStart])){
				if(isset($data['companies'][$batchEnd])){
					$newCompanies = array();
					for($i=$batchStart;$i<$batchEnd;$i++){
						$newCompanies[] = $data['companies'][$i];
					}
					if(count($data['companies'])>$batchEnd){
						$batchStart = $batchEnd;
						$batchEnd = $batchEnd + 250;
						if(!isset($data['companies'][$batchEnd])){
							$batchEnd = count($data['companies']);
						}
						$data['batch_next_start'] = (int)$batchStart;
						$data['batch_next_end'] = (int)$batchEnd;
					} else {
						$data['batch_start'] = false;
						unset($_SESSION['batch_data']);
					}
					$data['companies'] = $newCompanies;
				} else {
					$newCompanies = array();
					for($i=$batchStart;$i<count($data['companies']);$i++){
						$newCompanies[] = $data['companies'][$i];
					}
					$data['companies'] = $newCompanies;
					$data['batch_start'] = false;
					unset($_SESSION['batch_data']);
				}
			} else {
				$data['batch_start'] = false;
				$data['new'] = true;
				unset($_SESSION['batch_data']);
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function run_update_specialties(){
		$this->load->model('customer_model');
		$getAllSpecialities = $this->customer_model->getAllSpecialities();
		foreach($getAllSpecialities as $getAllSpeciality){
			$tagName = $getAllSpeciality->name;
			$ping = false;
			switch(substr($tagName,0,1)){
				case '#':
				case '&':
				case '@':
				case '*':
				case '-':
				case '-':
				case '•':
				case '+':
				case '>':
				case '<':
				$tagName = trim(substr($tagName,1));
				echo "TAG:".$tagName."<br/>";
				$ping = true;
				break;
				default:
					echo "TAG1:".$tagName."<br/>";
				break;
			}
			if(substr($tagName,0,1)=='"'){
				$tagName = trim(preg_replace("/[^a-zA-Z0-9]+/", "",html_entity_decode($tagName)));
				$ping = true;
			} else if(substr($tagName,0,3)=='and'){				
				$tagName = trim(substr($tagName,3));
				$ping = true;
			}
			if($ping===true){
				$this->customer_model->updateSpeciality($getAllSpeciality->id,array('name'=>$tagName));
			}
		}
		die;
	}
	
	public function get_filter_list($id=0,$activity=0,$show='html',$noOfRecords=200){
		$data = array('data'=>array());
		$this->load->model('customer_model');
		$sort = 'c.company_name';
		$sortBy = 'ASC';
		$t = true;
		if(isset($_POST) && count($_POST)>0){
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');				
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sc');
				$subCat = $this->input->post('sst');
				$tech = $this->input->post('stt');
				$subTech = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				$users = $this->input->post('u');
				$industry = $this->input->post('industry');
				$company_size = $this->input->post('company_size');
				$no_of_size = $this->input->post('no_of_size');	
				$label = $this->input->post('label');				
				$specialist = $this->input->post('specialist');
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
					/*$industry = implode(',',$inds);
					$industry = implode(',',$industry);*/
				} else {
					$industry = array();
				}
				if(is_array($specialist)){
					$specialities = array();
					foreach($specialist as $spec){
						$specialities[] = trim($spec);
					}
					$specialist = $specialities;
				} else {
					$specialist = array();
				}
				if(is_array($company_size)){
					$cs = array();
					foreach($company_size as $c){
						$cs[] = '"'.$c.'"';
					}
					$company_size = $cs;
					/*$company_size = implode(',',$company_size);*/
				} else {
					$company_size = array();
				}
				if(is_array($no_of_size)){					
					$no_of_size = implode(',',$no_of_size);
				} else {
					$no_of_size = "";
				}
				if(is_array($sector)){
					if(in_array('Unclassify',$sector)){
						$sector = "Unclassify";
					} else {
						$sector = implode(',',$sector);
					}					
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}	
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}	
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}	
				if(is_array($users)){
					$users = implode(',',$users);
				} else {
					$users = "";
				}			
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				/*$t = $this->input->post('t');
				if($t==true){
					$end = 1000;
				}*/
				$leadID = 0;
				$activity = 0;
				$invited = 2;
				$filterIgnore = $this->input->post('ignore');
				$tagSearch = $this->input->post('tagSearch');
				switch($filterIgnore){
					case 'no_of_users':
						$users = "";
					break;
					case 'no_of_employees':
						$no_of_size = '';
					break;
					case 'company_size':
						$company_size = array();
					break;
					case 'industry':
						$industry = array();
					break;
					case 'specialties':
						$specialist = array();
					break;
					case 'sector':
						$sector = "";
					break;
					case 'tech':
						$tech = "";
					break;
				}
				$data = $this->customer_model->companyOptimizeListWithoutPaging($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$label,$specialist,$sort,$sortBy,$start,$end,$leadID,$activity,$invited,false,$filterIgnore,$tagSearch);
			} catch(Exception $e){}		
		}
		echo json_encode($data);
		die;
	}
	
	public function sales_contact_test1($id=0,$activity=0,$show='html',$noOfRecords=200){
		$data = array('selected_sales_companies'=>array(),'selected_acquisition_companies'=>array(),'contacts'=>array(),'count_all'=>0,'no_of_records'=>$noOfRecords,'lead_id'=>0,'activity'=>0);
		if($id>0){
			$this->load->model('lead_model');
			$data['selected_sales_companies'] = $this->lead_model->getSalesActivityCompaniesByLead($id);
			$data['selected_acquisition_companies'] = $this->lead_model->getAcquisitionActivityCompaniesByLead($id);
		}
		$data['lead_id'] = $id;
		$data['activity'] = $activity;
		$resultData = array('data'=>array(),'count_all'=>0);
		$this->load->model('customer_model');
		$sort = 'c.company_name';
		$sortBy = 'ASC';
		$batchStart = false;
		$t = false;
		if(isset($_POST) && count($_POST)>0){ 
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');				
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sc');
				$subCat = $this->input->post('sst');
				$tech = $this->input->post('stt');
				$subTech = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				$users = $this->input->post('u');
				$industry = $this->input->post('industry');
				$company_size = $this->input->post('company_size');
				$no_of_size = $this->input->post('no_of_size');	
				$label = $this->input->post('label');				
				$specialist = $this->input->post('specialist');
				$alpha = $this->input->post('alpha');
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
					/*$industry = implode(',',$inds);
					$industry = implode(',',$industry);*/
				} else {
					$industry = array();
				}
				if(is_array($specialist)){
					$specialities = array();
					foreach($specialist as $spec){
						$specialities[] = trim($spec);
					}
					$specialist = $specialities;
				} else {
					$specialist = array();
				}
				if(is_array($company_size)){
					$cs = array();
					foreach($company_size as $c){
						$cs[] = '"'.$c.'"';
					}
					$company_size = $cs;
					/*$company_size = implode(',',$company_size);*/
				} else {
					$company_size = array();
				}
				if(is_array($no_of_size)){					
					$no_of_size = implode(',',$no_of_size);
				} else {
					$no_of_size = "";
				}
				if(is_array($sector)){
					if(in_array('Unclassify',$sector)){
						$sector = "Unclassify";
					} else {
						$sector = implode(',',$sector);
					}					
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}	
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}	
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}	
				if(is_array($users)){
					$users = implode(',',$users);
				} else {
					$users = "";
				}			
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				/*$t = $this->input->post('t');
				if($t==true){
					$end = 1000;
				}*/
				$leadID = 0;
				$activity = 0;
				$invited = 2;
				$resultData = $this->customer_model->companyOptimizeListWithPaging($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$label,$specialist,$alpha,$sort,$sortBy,$start,$end,$leadID,$activity,$invited,false);
			} catch(Exception $e){}				
		} else {
			$resultData = $this->customer_model->companyListWithPaging('','','','','','','','',array(),array(),'',$sort,$sortBy,0,30000,0,0,2,false);
			/*$resultData = array('data'=>array(),'count_all'=>0,'company_size_list'=>array(),'linkedin_company_users'=>array(),'cat'=>array(),'sub_cat'=>array(),'sub_tech'=>array());*/
		}

		$data['companies'] = $resultData['data'];
		/*$selectedData = $this->customer_model->companyList($activity,$id);
		if(count($selectedData)>0){
			foreach($selectedData as $sel){
				array_push($data['companies'],$sel);
			}
		}*/
		$data['no_of_records'] = count($data['companies']);
		$data['count_all'] = $resultData['count_all'];
		$data['batch_start'] = $batchStart;
		if(isset($resultData['cat'])){
			$data['cat'] = $resultData['cat'];
		}
		if(isset($resultData['sub_cat'])){
			$data['sub_cat'] = $resultData['sub_cat'];
		}
		if(isset($resultData['sub_tech'])){
			$data['sub_tech'] = $resultData['sub_tech'];
		}
		if($t==true){			
			if($data['no_of_records']>250){
				$data['batch_start'] = true;
				if(!isset($_SESSION)){
					session_start();
				}
				$_SESSION['batch_data'] = $data;
				$data['batch_next_start'] = 250;
				$next = 250*2;
				if($next<$data['no_of_records']){
					$data['batch_next_end'] = $next;
				} else {
					$data['batch_next_end'] = $data['no_of_records'];
				}
				$companiesList = array();
				$i=0;
				foreach($data['companies'] as $c){
					if($i<250){
						$companiesList[] = $c;
					} else {
						break;
					}
					$i++;
				}
				$data['companies'] = $companiesList;
			}else{
				$data['batch_start'] = false;
			}
		}
		if($show=="html"){
			$this->layout->layout='outsource';
			$this->layout->title_for_layout = 'Backyard';
			$this->layout->render('opportunity/sales_contact_test1',$data);
		} else {
			echo json_encode($data);
			die;
		}
	}
	
	public function get_all_specialist(){		
		$this->load->model('customer_model');
		$start=0;$end=200;
		if((int)$this->input->post('s')>0){
			$start=(int)$this->input->post('s');
		}
		if((int)$this->input->post('e')>0){
			$end=(int)$this->input->post('e');
		}
		$data = $this->customer_model->get_all_specialist($start,$end);
		echo json_encode($data);
		die;
	}
	
	public function get_all_specialist_by_char(){		
		$this->load->model('customer_model');
		$q=$this->input->post('q');
		$data = $this->customer_model->get_all_specialist_by_char($q);
		echo json_encode($data);
		die;
	}
	
	public function no_of_employee_company_size(){		
		$this->load->model('customer_model');
		$data = $this->customer_model->no_of_employee_company_size();
		echo json_encode($data);
		die;
	}
	
	public function getAllMarketSectors(){
		$this->load->model('opportunity_model');
		$data = $this->opportunity_model->getAllMarketSectors();
		echo json_encode($data);
		die;
	}
	
	public function getAllCompanyIndustry(){
		$this->load->model('customer_model');
		$data = $this->customer_model->getAllCompanyIndustry();
		echo json_encode($data);
		die;
	}
	public function testing_table(){
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Backyard';
		$this->layout->render('opportunity/testing_table',array());
	}
	
	public function sales_contact_filter($id=0,$activity=0,$show='html',$noOfRecords=200){
		$data = array('selected_sales_companies'=>array(),'selected_acquisition_companies'=>array(),'contacts'=>array(),'count_all'=>0,'no_of_records'=>$noOfRecords,'lead_id'=>0,'activity'=>0);
		$data['lead_id'] = $id;
		$data['activity'] = $activity;
		$resultData = array('data'=>array(),'count_all'=>0);
		$this->load->model('customer_model');
		$sort = 'c.company_name';
		$sortBy = 'ASC';
		if(isset($_POST) && count($_POST)>0){ 
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');				
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sc');
				$subCat = $this->input->post('sst');
				$tech = $this->input->post('stt');
				$subTech = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				$users = $this->input->post('u');
				$industry = $this->input->post('industry');
				$company_size = $this->input->post('company_size');
				$no_of_size = $this->input->post('no_of_size');	
				$label = $this->input->post('label');				
				$specialist = $this->input->post('specialist');
				$alpha = $this->input->post('alpha');
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
					/*$industry = implode(',',$inds);
					$industry = implode(',',$industry);*/
				} else {
					$industry = array();
				}
				if(is_array($specialist)){
					$specialities = array();
					if(in_array('none',$specialist)){
						$specialist = array();
						$specialist[] = "none";
					} else {
						foreach($specialist as $spec){
							$specialities[] = trim($spec);
						}
						$specialist = $specialities;
					}					
				} else {
					$specialist = array();
				}
				if(is_array($company_size)){
					$cs = array();
					foreach($company_size as $c){
						$cs[] = '"'.$c.'"';
					}
					$company_size = $cs;
					/*$company_size = implode(',',$company_size);*/
				} else {
					$company_size = array();
				}
				if(is_array($no_of_size)){					
					$no_of_size = implode(',',$no_of_size);
				} else {
					$no_of_size = "";
				}
				if(is_array($sector)){
					if(in_array('Unclassify',$sector)){
						$sector = "Unclassify";
					} else {
						$sector = implode(',',$sector);
					}					
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}	
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}	
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}	
				if(is_array($users)){
					$users = implode(',',$users);
				} else {
					$users = "";
				}			
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				/*$t = $this->input->post('t');
				if($t==true){
					$end = 1000;
				}*/
				$leadID = 0;
				$activity = 0;
				$invited = 2;
				$resultData = $this->customer_model->companyOptimizeListWithPagingIDs($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$label,$specialist,$alpha,$sort,$sortBy,$start,$end,$leadID,$activity,$invited,false);
				$fileTemp = "";
				if(count($resultData['data'])>0){
					$fileTemp = rand(0,10000).time().'.csv';
					$path = "/var/www/synpat/backyard/temp/";
					$fp = fopen($path.$fileTemp,"w");
					$allcompaniesIDs = array();
					for($i=0;$i<count($resultData['data']);$i++){
						array_push($allcompaniesIDs,$resultData['data'][$i]->company_id);
					}
					fputcsv($fp, $allcompaniesIDs);
					fclose($fp);
					$data['no_of_records']=count($allcompaniesIDs);
				}
				$data['file_no'] = $fileTemp;
			} catch(Exception $e){}				
		}
		echo json_encode($data);
		die;
	}
	public function unlink_file(){
		$data = "";
		$fileTemp = $this->input->post('_f');
		if($fileTemp!=""){
			$path = "/var/www/synpat/backyard/temp/";
			if(file_exists($path.$fileTemp)){
				unlink($path.$fileTemp);
				$data = "File Deleted";
			}
		}
		echo $data;
		die;
	}
	public function sales_contact_batch(){
		$start = $this->input->post('_s');
		$end = $this->input->post('_e');
		$fileTemp = $this->input->post('_f');
		$d = $this->input->post('_d');
		$sortField = $this->input->post('_so');
		$sortBy = $this->input->post('_b');
		$path = "/var/www/synpat/backyard/temp/";
		$fp = fopen($path.$fileTemp,"r");
		$allCompanies = array();
		$data = array();
		if (($handle = $fp) !== FALSE) {			
			$allCompanies = fgetcsv($handle);
		}

		if(count($allCompanies)>0){
			$this->load->model('customer_model');
			$list = array();
			for($s = $start;$s<($start+$end);$s++){
				if(isset($allCompanies[$s])){
					array_push($list,$allCompanies[$s]) ;
				}				
			}
			if(count($list)>0){
				$data = $this->customer_model->getCompanyDataByIDs($list,true,$sortField,$sortBy);
			}			
		}
		$data['count_all'] = count($allCompanies);
		echo json_encode($data);
		die;
	}
	
	public function sales_contact_test($id=0,$activity=0,$show='html',$noOfRecords=200){
		$data = array('selected_sales_companies'=>array(),'selected_acquisition_companies'=>array(),'contacts'=>array(),'count_all'=>0,'no_of_records'=>$noOfRecords,'lead_id'=>0,'activity'=>0);
		if($id>0){
			$this->load->model('lead_model');
			$data['selected_sales_companies'] = $this->lead_model->getSalesActivityCompaniesByLead($id);
			$data['selected_acquisition_companies'] = $this->lead_model->getAcquisitionActivityCompaniesByLead($id);
		}
		$data['lead_id'] = $id;
		$data['activity'] = $activity;
		$resultData = array('data'=>array(),'count_all'=>0);
		$this->load->model('customer_model');
		$sort = 'c.company_name';
		$sortBy = 'ASC';
		$batchStart = false;
		$t = false;
		if(isset($_POST) && count($_POST)>0){ 
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');				
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sc');
				$subCat = $this->input->post('sst');
				$tech = $this->input->post('stt');
				$subTech = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				$users = $this->input->post('u');
				$industry = $this->input->post('industry');
				$company_size = $this->input->post('company_size');
				$no_of_size = $this->input->post('no_of_size');	
				$label = $this->input->post('label');				
				$specialist = $this->input->post('specialist');
				$alpha = $this->input->post('alpha');
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
					/*$industry = implode(',',$inds);
					$industry = implode(',',$industry);*/
				} else {
					$industry = array();
				}
				if(is_array($specialist)){
					$specialities = array();
					foreach($specialist as $spec){
						$specialities[] = trim($spec);
					}
					$specialist = $specialities;
				} else {
					$specialist = array();
				}
				if(is_array($company_size)){
					$cs = array();
					foreach($company_size as $c){
						$cs[] = '"'.$c.'"';
					}
					$company_size = $cs;
					/*$company_size = implode(',',$company_size);*/
				} else {
					$company_size = array();
				}
				if(is_array($no_of_size)){					
					$no_of_size = implode(',',$no_of_size);
				} else {
					$no_of_size = "";
				}
				if(is_array($sector)){
					if(in_array('Unclassify',$sector)){
						$sector = "Unclassify";
					} else {
						$sector = implode(',',$sector);
					}					
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}	
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}	
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}	
				if(is_array($users)){
					$users = implode(',',$users);
				} else {
					$users = "";
				}			
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				/*$t = $this->input->post('t');
				if($t==true){
					$end = 1000;
				}*/
				$leadID = 0;
				$activity = 0;
				$invited = 2;
				$resultData = $this->customer_model->companyOptimizeListWithPaging($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$label,$specialist,$alpha,$sort,$sortBy,$start,$end,$leadID,$activity,$invited,false);
			} catch(Exception $e){}				
		} else {
			/*$resultData = $this->customer_model->companyListWithPaging('','','','','','','','',array(),array(),'',$sort,$sortBy,0,200,0,0,2);*/
			$resultData = array('data'=>array(),'count_all'=>0,'company_size_list'=>array(),'linkedin_company_users'=>array(),'cat'=>array(),'sub_cat'=>array(),'sub_tech'=>array());
		}

		$data['companies'] = $resultData['data'];
		/*$selectedData = $this->customer_model->companyList($activity,$id);
		if(count($selectedData)>0){
			foreach($selectedData as $sel){
				array_push($data['companies'],$sel);
			}
		}*/
		$data['no_of_records'] = count($data['companies']);
		$data['count_all'] = $resultData['count_all'];
		$data['batch_start'] = $batchStart;
		if(isset($resultData['cat'])){
			$data['cat'] = $resultData['cat'];
		}
		if(isset($resultData['sub_cat'])){
			$data['sub_cat'] = $resultData['sub_cat'];
		}
		if(isset($resultData['sub_tech'])){
			$data['sub_tech'] = $resultData['sub_tech'];
		}
		if($t==true){			
			if($data['no_of_records']>250){
				$data['batch_start'] = true;
				if(!isset($_SESSION)){
					session_start();
				}
				$_SESSION['batch_data'] = $data;
				$data['batch_next_start'] = 250;
				$next = 250*2;
				if($next<$data['no_of_records']){
					$data['batch_next_end'] = $next;
				} else {
					$data['batch_next_end'] = $data['no_of_records'];
				}
				$companiesList = array();
				$i=0;
				foreach($data['companies'] as $c){
					if($i<250){
						$companiesList[] = $c;
					} else {
						break;
					}
					$i++;
				}
				$data['companies'] = $companiesList;
			}else{
				$data['batch_start'] = false;
			}
		}
		if($show=="html"){
			$this->layout->layout='outsource';
			$this->layout->title_for_layout = 'Backyard';
			$this->layout->render('opportunity/sales_contact_test',$data);
		} else {
			echo json_encode($data);
			die;
		}
	}		
	public function sales_contact($id=0,$activity=0,$show='html',$noOfRecords=200){
		$data = array('selected_sales_companies'=>array(),'selected_acquisition_companies'=>array(),'contacts'=>array(),'count_all'=>0,'no_of_records'=>$noOfRecords,'lead_id'=>0,'activity'=>0);
		if($id>0){
			$this->load->model('lead_model');
			$data['selected_sales_companies'] = $this->lead_model->getSalesActivityCompaniesByLead($id);
			$data['selected_acquisition_companies'] = $this->lead_model->getAcquisitionActivityCompaniesByLead($id);
		}
		$data['lead_id'] = $id;
		$data['activity'] = $activity;
		$resultData = array('data'=>array(),'count_all'=>0);
		$this->load->model('customer_model');
		$sort = 'c.company_name';
		$sortBy = 'ASC';
		$batchStart = false;
		$t = false;
		if(isset($_POST) && count($_POST)>0){ 
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');				
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sc');
				$subCat = $this->input->post('sst');
				$tech = $this->input->post('stt');
				$subTech = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				$users = $this->input->post('u');
				$industry = $this->input->post('industry');
				$company_size = $this->input->post('company_size');
				$no_of_size = $this->input->post('no_of_size');				
				$label = $this->input->post('label');
				$alpha = $this->input->post('alpha');				
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
					/*$industry = implode(',',$inds);
					$industry = implode(',',$industry);*/
				} else {
					$industry = array();
				}
				if(is_array($company_size)){
					$cs = array();
					foreach($company_size as $c){
						$cs[] = '"'.$c.'"';
					}
					$company_size = $cs;
					/*$company_size = implode(',',$company_size);*/
				} else {
					$company_size = array();
				}
				if(is_array($no_of_size)){					
					$no_of_size = implode(',',$no_of_size);
				} else {
					$no_of_size = "";
				}
				if(is_array($sector)){
					if(in_array('Unclassify',$sector)){
						$sector = "Unclassify";
					} else {
						$sector = implode(',',$sector);
					}					
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}	
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}	
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}	
				if(is_array($users)){
					$users = implode(',',$users);
				} else {
					$users = "";
				}			
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				/*$t = $this->input->post('t');
				if($t==true){
					$end = 1000;
				}*/
				$leadID = 0;
				$activity = 0;
				$invited = 2;
				$resultData = $this->customer_model->companyOptimizeListWithPaging($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$label,$alpha,$sort,$sortBy,$start,$end,$leadID,$activity,$invited);
			} catch(Exception $e){}				
		} else {
			/*$resultData = $this->customer_model->companyListWithPaging('','','','','','','','',array(),array(),'',$sort,$sortBy,0,200,0,0,2);*/
			$resultData = array('data'=>array(),'count_all'=>0,'company_size_list'=>array(),'linkedin_company_users'=>array(),'cat'=>array(),'sub_cat'=>array(),'sub_tech'=>array());
		}

		$data['companies'] = $resultData['data'];
		/*$selectedData = $this->customer_model->companyList($activity,$id);
		if(count($selectedData)>0){
			foreach($selectedData as $sel){
				array_push($data['companies'],$sel);
			}
		}*/
		$data['no_of_records'] = count($data['companies']);
		$data['count_all'] = $resultData['count_all'];
		$data['batch_start'] = $batchStart;
		if(isset($resultData['cat'])){
			$data['cat'] = $resultData['cat'];
		}
		if(isset($resultData['sub_cat'])){
			$data['sub_cat'] = $resultData['sub_cat'];
		}
		if(isset($resultData['sub_tech'])){
			$data['sub_tech'] = $resultData['sub_tech'];
		}
		if($t==true){			
			if($data['no_of_records']>250){
				$data['batch_start'] = true;
				if(!isset($_SESSION)){
					session_start();
				}
				$_SESSION['batch_data'] = $data;
				$data['batch_next_start'] = 250;
				$next = 250*2;
				if($next<$data['no_of_records']){
					$data['batch_next_end'] = $next;
				} else {
					$data['batch_next_end'] = $data['no_of_records'];
				}
				$companiesList = array();
				$i=0;
				foreach($data['companies'] as $c){
					if($i<250){
						$companiesList[] = $c;
					} else {
						break;
					}
					$i++;
				}
				$data['companies'] = $companiesList;
			}else{
				$data['batch_start'] = false;
			}
		}
		if($show=="html"){
			$this->layout->layout='outsource';
			$this->layout->title_for_layout = 'Backyard';
			$this->layout->render('opportunity/sales_contact_test',$data);
		} else {
			echo json_encode($data);
			die;
		}
	}
	
	
	public function company_list($id=0,$activity=0,$show='html'){
		/*if(isset($_POST) && count($_POST) > 0) {
			$postData = $this->input->post();
			$this->load->model('customer_model');
			$resultData = $this->customer_model->company_list(true,'c.company_name','ASC');
			echo json_encode($resultData);
			die;
		}*/
		$data = array('selected_sales_companies'=>array(),'selected_acquisition_companies'=>array(),'contacts'=>array(),'count_all'=>0,'no_of_records'=>0,'lead_id'=>0,'activity'=>0);
		if($id>0){
			$this->load->model('lead_model');
			$data['selected_sales_companies'] = $this->lead_model->getSalesActivityCompaniesByLead($id);
			$data['selected_acquisition_companies'] = $this->lead_model->getAcquisitionActivityCompaniesByLead($id);
		}
		$data['lead_id'] = $id;
		$data['activity'] = $activity;
		$resultData = array('data'=>array(),'count_all'=>0);
		$this->load->model('customer_model');
		$sort = 'c.company_name';
		$sortBy = 'ASC';
		$batchStart = false;
		$t = false;
		if(isset($_POST) && count($_POST)>0){ 
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');				
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sc');
				$subCat = $this->input->post('sst');
				$tech = $this->input->post('stt');
				$subTech = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				$users = $this->input->post('u');
				$industry = $this->input->post('industry');
				$company_size = $this->input->post('company_size');
				$no_of_size = $this->input->post('no_of_size');	
				$label = $this->input->post('label');				
				$specialist = $this->input->post('specialist');
				$alpha = $this->input->post('alpha');
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
					/*$industry = implode(',',$inds);
					$industry = implode(',',$industry);*/
				} else {
					$industry = array();
				}
				if(is_array($specialist)){
					$specialities = array();
					foreach($specialist as $spec){
						$specialities[] = trim($spec);
					}
					$specialist = $specialities;
				} else {
					$specialist = array();
				}
				if(is_array($company_size)){
					$cs = array();
					foreach($company_size as $c){
						$cs[] = '"'.$c.'"';
					}
					$company_size = $cs;
					/*$company_size = implode(',',$company_size);*/
				} else {
					$company_size = array();
				}
				if(is_array($no_of_size)){					
					$no_of_size = implode(',',$no_of_size);
				} else {
					$no_of_size = "";
				}
				if(is_array($sector)){
					if(in_array('Unclassify',$sector)){
						$sector = "Unclassify";
					} else {
						$sector = implode(',',$sector);
					}					
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}	
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}	
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}	
				if(is_array($users)){
					$users = implode(',',$users);
				} else {
					$users = "";
				}			
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				/*$t = $this->input->post('t');
				if($t==true){
					$end = 1000;
				}*/
				$leadID = 0;
				$activity = 0;
				$invited = 2;
				$resultData = $this->customer_model->companyOptimizeListWithGrid($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$label,$specialist,$alpha,$sort,$sortBy,$leadID,$activity,$invited,false);
			} catch(Exception $e){}			
		} else {
			$resultData = array('data'=>array(),'count_all'=>0,'company_size_list'=>array(),'linkedin_company_users'=>array(),'cat'=>array(),'sub_cat'=>array(),'sub_tech'=>array());
		}
		$data['companies'] = $resultData['data'];
		$data['no_of_records'] = count($data['companies']);
		$data['count_all'] = $resultData['count_all'];
		if(isset($resultData['cat'])){
			$data['cat'] = $resultData['cat'];
		}
		if(isset($resultData['sub_cat'])){
			$data['sub_cat'] = $resultData['sub_cat'];
		}
		if(isset($resultData['sub_tech'])){
			$data['sub_tech'] = $resultData['sub_tech'];
		}		
		if($show=="html"){
			$this->layout->layout='outsource';
			$this->layout->title_for_layout = 'Backyard';
			$this->layout->render('opportunity/company_list',$data);
		} else {
			echo json_encode($data);
			die;
		}
	}

	public function find_invites_company(){
		$list = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('customer_model');
			$list = $this->customer_model->companyList($_POST['a'],$_POST['l']);
		}
		echo json_encode($list);
		die;
	}
	
	public function delete_c_sales(){
		$data =0;
		if(isset($_POST) && count($_POST)>0){
			$companyID = $this->input->post("c");
			$leadID = $this->input->post("l");
			$explodeCompany = explode(',',$companyID);
			if(count($explodeCompany)>0){
				$this->load->model('opportunity_model');
				$this->load->model('customer_model');
				$this->load->model('acquisition_model');
				foreach($explodeCompany as $company){
					if((int)$company>0){
						$delete = $this->opportunity_model->deleteInviteesByLeadAndCompany($leadID,$company);
						$checkCompanyAlreadyInvite = $this->customer_model->getCompanyDataByID($company);	
						$acquisitionData = $this->acquisition_model->getData($leadID);	
						$curl = curl_init();				
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/delete_single_invitee',
							CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
							CURLOPT_POST => 1,
							CURLOPT_POSTFIELDS => array(
								'license_number' => $acquisitionData['acquisition']->store_name,
								'company_name'=>$checkCompanyAlreadyInvite->company_name
							)
						));
						$resp = curl_exec($curl);
						$data=1;
					}
				}
			}			
		}
		echo $data;
		die;
	}	
	public function delete_c_acquisition(){
		$data =0;
		if(isset($_POST) && count($_POST)>0){
			$companyID = $this->input->post("c");
			$leadID = $this->input->post("l");
			$this->load->model('opportunity_model');
			$delete = $this->opportunity_model->deleteAcquisitionByLeadAndCompany($leadID,$companyID);
			$data=1;
		}
		echo $data;
		die;
	}	
	public function invitees_in_bulk(){
		if(isset($_POST) && count($_POST)>0){
			$getData = $this->input->post();
			$leadID = $getData['lead_id'];
			$companies = json_decode($getData['companies']);
			if(count($companies)>0){
				$this->load->model('acquisition_model');
				$this->load->model('opportunity_model');
				$this->load->model('customer_model');
				$acquisitionData = $this->acquisition_model->getData($leadID);		
				foreach($companies as $companyID){
					if((int)$companyID>0){
						$checkCompanyAlreadyInvite = $this->opportunity_model->checkCompanyInSales($leadID,$companyID);
						if(count($checkCompanyAlreadyInvite)==0){
							$saveData = $this->opportunity_model->insertInvitees(array('lead_id'=>$leadID,'contact_id'=>$companyID));
							$checkCompanyAlreadyInvite = $this->customer_model->getCompanyDataByID($companyID);	
							$acquisitionData = $this->acquisition_model->getData($leadID);				
							$curl = curl_init();				
							curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/add_single_invitee',
								CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
								CURLOPT_POST => 1,
								CURLOPT_POSTFIELDS => array(
									'license_number' => $acquisitionData['acquisition']->store_name,
									'company_name'=>$checkCompanyAlreadyInvite->company_name
								)
							));
							$resp = curl_exec($curl);
							echo $saveData;
						} else {
							echo $checkCompanyAlreadyInvite->id;
						}
					}
				}
			}
		}
		die;
	}
	
	public function merge_companies_data(){
		$data = array('update'=>0,'survivour_data'=>array());
		if(isset($_POST) && count($_POST)>0){
			$merger = $this->input->post('m');
			$survivour = $this->input->post('s');
			$remainingArray = array_unique($merger,SORT_NUMERIC );
			$s= 0;
			foreach($remainingArray as $arrayRe){
				if($arrayRe==$survivour[0]){
					unset($remainingArray[$s]);
				}
				$s++;
			}
			$remainingArray = array_values($remainingArray);
			$this->load->model('customer_model');
			$data['update'] = $this->customer_model->updateContactsFromAllCompanies($remainingArray,$survivour);
			if($data['update']>0){
				$data['survivour_data'] = $this->customer_model->getCompanyDataByID($survivour[0]);
			}
		}
		echo json_encode($data);die;
	}
	
	public function scrape_data_from_linkedin(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$list = $this->input->post('l');
			$count = $this->input->post('c');
			$this->load->model('opportunity_model');
			$data = $this->opportunity_model->insertLinkedInScrapperList(array('list'=>$list,'count'=>$count,'status'=>0));
			$this->opportunity_model->updateContactsListByIDs(array('scraped_p'=>0),$list);
		}
		echo $data;
		die;
	}
	
	public function check_linkedin_scrapper_request(){
		$data = array('list'=>array(),'data'=>array());
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('opportunity_model');
			$scrapperID = $this->input->post('i');
			$data['data'] = $this->opportunity_model->getScrapperDataByID($scrapperID);
			if($data['data']->status>0){
				$data['list'] = $this->opportunity_model->getContactListByIDs($data['data']->list);
			}
		}
		echo json_encode($data);
		die;
	}
		
	public function callDFAPI($url,$data,$headerToken=''){
		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,'http://api.datafills.com/'.$url);
		if($headerToken!=""){
			$headers = array(
				'Content-Type:application/json',
				'Authorization:'. $headerToken 
			);
			curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
		}
		curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
		curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
		if(count($data)>0){
			curl_setopt($curl_handle, CURLOPT_POST, true);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS,$data );
		}		
		$result = curl_exec($curl_handle);
		curl_close($curl_handle);
		return $result;
	}
	
	public function connectDFAPI($leadID){
		/*$result = $this->callDFAPI('authenticate',array('user'=>'backyard_synpat','password'=>'d4e4a4016b62e22eae8743372c192e2de24010c9'));
		echo "<pre>";
				print_r($result);
		die;
		if($result){
			try{
				$decodeResult = json_decode($result,true);
				echo "<pre>";
				print_r($decodeResult);
				if(isset($decodeResult['token']) &&  $decodeResult['token']!=""){
					$token = $decodeResult['token'];
					$accountData = $this->callDFAPI('account',array('email'=>'uzi@synpat.com'),$token);
					echo "<pre>";
					print_r($accountData);
				}
			}catch(Exception $e){
				
			}
		}
		die;*/
		$thisGetProjectDetails = $this->callDFAPI('project_by_lead/'.$leadID,array(),'');
		echo "<pre>";
		print_r($thisGetProjectDetails);
		die;
	}
	
	public function invite_single_company(){
		$data = array('local'=>0,'df'=>0);
		if(isset($_POST) && count($_POST)>0){
			$companyIDs = $this->input->post("company");
			$leadID = $this->input->post("l");
			$checked = $this->input->post("t");
			$activity = $this->input->post("activity");
			$this->load->model('customer_model');
			$this->load->model('opportunity_model');
			$checkCompanyAlreadyInvite = $this->customer_model->getCompanyDataByID($companyIDs);
			if($activity==1){
				/*Sales Activity */
				$leadData = $this->opportunity_model->getLeadDataByIdWithSelect($leadID,'l.serial_number');
				$getLicenseData = $this->opportunity_model->getDocketTemplateAccordion($leadData->serial_number,'id');
				if(count($checkCompanyAlreadyInvite)>0){
					/*delete*/
					$data['local'] = $this->opportunity_model->deleteStoreInvitee($checkCompanyAlreadyInvite->company_name,$getLicenseData->id);
					$data['local'] = $this->opportunity_model->deleteInviteesByCompanyID($companyIDs,$leadID);
				}
				if($checked=='true'){
					if(count($checkCompanyAlreadyInvite)>0){
						$data['local'] = $this->opportunity_model->insertInvitees(array('lead_id'=>$leadID,'contact_id'=>$companyIDs));
						$bulkCompanyData = array('company'=>$checkCompanyAlreadyInvite->company_name,'license_id'=>$getLicenseData->id);
						$data['local'] = $this->opportunity_model->insertStoreInvitee($bulkCompanyData);
						
						/*Insert into datafills*/
						$thisGetProjectDetails = $this->callDFAPI('project_by_lead/'.$leadID,array(),'');
						if($thisGetProjectDetails!=""){
							try{
								$projectDetails = json_decode($thisGetProjectDetails,true);
								if(count($projectDetails)>0 && isset($projectDetails['details']['key'])){
									/*get contact details*/
									$getContactDataList = $this->opportunity_model->getAllContactBelongToCompany($companyIDs) ;
									if(count($getContactDataList)>0){
										$dataInsertDF = array('project_id'=>$projectDetails['details']['key'],'list'=>json_encode($getContactDataList));
										$thisGetProjectInsertion = $this->callDFAPI('add_records',$dataInsertDF,'');
										$data['server'] = $thisGetProjectInsertion;
									}
								}
							}catch(Exception $e){
								
							}
						}
						
					}
				}
			} else if($activity==2){
				/*Acquisition Activity */
				if(count($checkCompanyAlreadyInvite)>0){
					/*delete*/
					$data['local'] = $this->opportunity_model->deleteAcquisitionByLeadAndCompany($leadID,$companyIDs);
				}
				if($checked=='true'){
					if(count($checkCompanyAlreadyInvite)>0){
						$data['local'] = $this->opportunity_model->insertAcquisitionCompany(array('lead_id'=>$leadID,'contact_id'=>$companyIDs));
					}
				}
			}
			 
		}
		echo json_encode($data);
		die;
	}
	
	public function invite_company(){
		if(isset($_POST) && count($_POST)>0){
			$companyIDs = $this->input->post("company");
			$leadID = $this->input->post("l");
			if(!empty($companyIDs)){
				try{
					$this->load->model('customer_model');
					$this->load->model('opportunity_model');
					$this->load->model('acquisition_model');
					$this->load->model('user_model');
					$allCompanies = json_decode($companyIDs,true);
					if(count($allCompanies)>0){						
						/*Delete All Invitees*/
						$this->opportunity_model->deleteInvitees($leadID);
						$bulkCompanyData = array();
						for($i=0;$i<count($allCompanies);$i++){
							$saveData = $this->opportunity_model->insertInvitees(array('lead_id'=>$leadID,'contact_id'=>$allCompanies[$i]));
							$checkCompanyAlreadyInvite = $this->customer_model->getCompanyDataByID($allCompanies[$i]);
							$bulkCompanyData[] = array('name'=>$checkCompanyAlreadyInvite->company_name,'orgName'=>$checkCompanyAlreadyInvite->company_name);
						}
						if(count($bulkCompanyData)>0){
							$acquisitionData = $this->acquisition_model->getData($leadID);	
							$curl = curl_init();				
							curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/add_invitees',
								CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
								CURLOPT_POST => 1,
								CURLOPT_POSTFIELDS => array(
									'license_number' => $acquisitionData['acquisition']->store_name,
									'invitees'=>json_encode($bulkCompanyData)
								)
							));
							$resp = curl_exec($curl);
						}
						$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Update list of invitees",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						/*if($saveData>0){
							$acquisitionData = $this->acquisition_model->getData($leadID);
							$getAllCompanyName = $this->customer_model->getCompanyNameByAllIdList(implode(',',$allCompanies));	
							if(count($getAllCompanyName)>0){
								$curl = curl_init();				
								curl_setopt_array($curl, array(
									CURLOPT_RETURNTRANSFER => 1,
									CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/add_single_invitee',
									CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
									CURLOPT_POST => 1,
									CURLOPT_POSTFIELDS => array(
										'license_number' => $acquisitionData['acquisition']->store_name,
										'company_name'=>json_encode($getAllCompanyName)
									)
								));
								$resp = curl_exec($curl);
							}
						}*/
					}
				} catch(Exception $e){
					
				}
			}
			/*
			if(count($checkCompanyAlreadyInvite)==0){
				$saveData = $this->opportunity_model->insertInvitees(array('lead_id'=>$leadID,'contact_id'=>$companyID));
				$checkCompanyAlreadyInvite = $this->customer_model->getCompanyDataByID($companyID);	
				$acquisitionData = $this->acquisition_model->getData($leadID);				
				$curl = curl_init();				
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/add_single_invitee',
					CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'license_number' => $acquisitionData['acquisition']->store_name,
						'company_name'=>$checkCompanyAlreadyInvite->company_name
					)
				));
				$resp = curl_exec($curl);
				echo $saveData;
			} else {
				echo $checkCompanyAlreadyInvite->id;
			}*/			
		}
		die;
	}	
	public function acquisition_company(){		
		$saveData = 0;
		if(isset($_POST) && count($_POST)>0){
			$companyID = $this->input->post("company");
			$leadID = $this->input->post("l");
			if(!empty($companyID)){
				try{
					$allCompanies = json_decode($companyID,true);
					if(count($allCompanies)>0){
						$this->load->model('opportunity_model');
						$this->opportunity_model->deleteAcquisitionCompany($leadID);
						for($i=0;$i<count($allCompanies);$i++){
							$saveData = $this->opportunity_model->insertAcquisitionCompany(array('lead_id'=>$leadID,'contact_id'=>$allCompanies[$i]));
						}
					}
				}catch(Exception $e){}
			}
		}
		echo $saveData;
		die;		
	}	
	public function change_store_status(){
		$data = array('status'=>0,'category'=>'0','success'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('acquisition_model');
			$this->load->model('lead_model');
			$getAcData = $this->acquisition_model->getData($this->input->post('lead_id'));
			$category=0;
			$status = $this->input->post('store_status');
			if((int)$status==1){
				$status = 1;
				if($getAcData['acquisition']->old_category>0){
					$category = $getAcData['acquisition']->old_category;
				} else {
					$category = $getAcData['acquisition']->category;
				}				
			} else {
				$status = 0;
				$category=0;
			}
			$leadData = $this->lead_model->getLeadData($this->input->post('lead_id'));
			$updateData = $this->acquisition_model->updateData($this->input->post('lead_id'),array('store_status'=>$status,'category'=>$category,'old_category'=>$getAcData['acquisition']->category));
			if($updateData>0){
				$data['success'] = $result['success'];
			}
			$data['status'] = $status;
			$data['category'] = $category;
		}
		echo json_encode($data);
		die;
	}
	public function change_docket_status(){
		$data = array('status'=>0,'category'=>'0','success'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('acquisition_model');
			$this->load->model('lead_model');
			$getAcData = $this->acquisition_model->getData($this->input->post('lead_id'));
			$category=0;
			$status = $this->input->post('docket_status');
			if((int)$status==1){
				$status = 0;
			} else {
				$status = 1;
			}
			$leadData = $this->lead_model->getLeadData($this->input->post('lead_id'));
			$this->acquisition_model->updateData($this->input->post('lead_id'),array('docket_status'=>$status));
			$resp = $this->changeToOnlineOffline($leadData->serial_number,$status);
			if(!empty($resp)){
				$result = json_decode($resp,true);
				$data['success'] = $result['success'];
			}
			$data['status'] = $status;
		}
		echo json_encode($data);
		die;
	}
	public function changeToOnlineOffline($license_number,$status){
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/change_portfolio_status',
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => array(
				'status' => $status,
				'license_number' => $license_number,
			)
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		return $resp;
	}	
	public function checkingPDFIsValid($url){
		$fileFormat = "";
		if(!empty($url)){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_NOBODY, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$results = explode("\n", trim(curl_exec($ch)));
			foreach($results as $line) {
				if (strtok($line, ':') == 'Content-Type') {
						$parts = explode(":", $line);
						$fileFormat =  trim($parts[1]); // output: application/pdf
						break;
				}
			}
		}		
		return $fileFormat;
	}	
	public function createPDFUrlForPatent($patent){
		$url = "";
		if(strtolower(strtoupper(substr($patent,0,2)))=="us"){
			$patentNumber = substr($patent,2);
			if(strlen($patentNumber)==9){
				$patentNumber = substr($patentNumber,0,7);
			} else if(strlen($patentNumber)==13){
				$patentNumber = substr($patentNumber,0,11);
			}
			if(!empty($patentNumber)){
				if(strlen($patentNumber)==7){
					$patentFirst = substr($patentNumber,0,2);
					$patentSecond = substr($patentNumber,2,3);
					$patentThird = substr($patentNumber,5,2);
					$url = 'http://pimg-fpiw.uspto.gov/fdd/'.$patentThird.'/'.$patentSecond.'/0'.$patentFirst.'/0.pdf';
				} else if(strlen($patentNumber)==11){
					$patentFirst = substr($patentNumber,0,4);
					$patentSecond = substr($patentNumber,4,3);
					$patentThird = substr($patentNumber,7,2);
					$patentFour = substr($patentNumber,9,2);
					$url = 'http://pdfaiw.uspto.gov/fdd/'.$patentFour.'/'.$patentFirst.'/'.$patentThird.'/'.$patentSecond.'/0.pdf';
				} else {
					$url="patentimages.storage.googleapis.com/pdfs/".$patent.".pdf";
				}	
			}
		} else {
			if(strlen($patent)>9){
				$patent = substr($getPatentNumber,0,-2);
				$url="https://patentimages.storage.googleapis.com/pdfs/".$patent.".pdf";
			} else {
				$url="https://patentimages.storage.googleapis.com/pdfs/".$patent.".pdf";
			}
		}
		return $url;
	}	
	
	function check_patent_and_docket(){
		$data = array("patent"=>1,"docket"=>1);
		if(isset($_POST) && isset($_POST['l'])){
			$this->load->model('acquisition_model');
			$this->load->model('lead_model');
			$getAcData = $this->acquisition_model->getData($this->input->post('l'));
			if(count($getAcData)>0){
				if(empty($getAcData['acquisition']->store_name)){
					$data['docket'] = 0;
				}
			} else {
				$data['docket'] = 0;
			}
			$patent = $this->lead_model->getLeadPatentParentData($this->input->post('l'));
			if(count($patent)==0){
				$data['patent'] = 0;
			}
		} else {
			$data = array("patent"=>0,"docket"=>0);
		}		
		echo json_encode($data);
		die;
	}
	
	public function docket(){
	   $this->layout->layout='docket';	
	   $user_id  = $this->session->userdata['id'];
       $oppData['opp']['create_date']= date('Y-m-d H:i:s');
		if ($this->uri->segment(3) === FALSE){
			$lead_id = 0;
		} else {
			$lead_id = $this->uri->segment(3);
		}
		$this->load->model('lead_model');
		$this->load->model('user_model');
		$this->load->model('acquisition_model');
		$this->load->model('general_model');
		$this->load->model('opportunity_model');
		$this->load->model('customer_model');
		if($lead_id>0){
		  /*$data['timeline'] = getUserTimeLine('',$lead_id,'');*/
		  $data['timeline'] = $this->user_model->getAllUserHistory('',$lead_id,'');
		
			$createFlag = 0;
			$getAcData = $this->acquisition_model->getData($lead_id);
			if(count($getAcData)>0){
				if(empty($getAcData['acquisition']->store_name)){
					$createFlag = 1;
				}
			} else {
				$createFlag = 1;
			}
			$data['lead_data'] = $this->lead_model->getLeadData($lead_id);
		
			if($createFlag ==1){
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/demo_portfolio',
					CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'access_code' => '12345',
						'license_number' => str_replace(' ','_',$data['lead_data']->lead_name),
						'serial_number' => $data['lead_data']->serial_number,
						'asking_price'=>0,
						'license_status'=>'0'
					)
				));
				// Send the request & save response to $resp
				$resp = curl_exec($curl);
				if($resp){
					$getData = json_decode($resp);
					if(count($getData)>0){
						$storeName = $getData->name;
						$storeID = $getData->id;
						if($storeID>0 && !empty($storeName)){
							$getAcqData = array();
							$getAcqData['acquisition']['create_date'] = date('Y-m-d H:i:s');
							$getAcqData['acquisition']['store_name'] = $storeName;
							$getAcqData['acquisition']['lead_id'] = $lead_id;
							$reportArray = array('lead_id'=>$lead_id);
							$this->load->library('DriveServiceHelper');
							$service = new DriveServiceHelper();
							if($data['lead_data']->ppa_id!=""){
								$getFileInfo = $service->getFileInfo($data['lead_data']->ppa_id);
								/*$service->setAdditionalPermissions( $getFileInfo->id, "","reader","anyone");*/
								$url = $getFileInfo->alternateLink;
								$getAcqData['acquisition']['ppa'] = $url;
								$reportArray['draft_a_ppa'] = 2;
							}
							if($data['lead_data']->ppa_date!=null){
								$reportArray['execute_ppa'] = 3;
							}
							if($data['lead_data']->ppa_text_date!=null){
								$reportArray['execute_ppa'] = 2;
							}
							$saveData = $this->acquisition_model->insertAcquisition($getAcqData['acquisition']);
							/*Insert Docket Buttons*/
							$getButtonList = $this->general_model->getAllButtonList("DOCKET");
							if(count($getButtonList)>0){
								foreach($getButtonList as $button){
									$this->lead_model->insertDocketButton(array("lead_id"=>$lead_id,"sort"=>$button->sort,"button_id"=>$button->id));
								}
							}
							/*End Insert Docket Buttons*/
							/*Check Patent PDF*/
							$findLeadData = $this->opportunity_model->getLeadDataByIdWithSelect($lead_id,'serial_number');
							$licenseData = $this->opportunity_model->getLicenseDataByLeadID($findLeadData->serial_number,"id");
							if(count($licenseData)>0){
								$this->opportunity_model->deleteDueDilligencePatent($licenseData->id);
								$this->opportunity_model->addDueDilligencePatentThroughLead($lead_id,$licenseData->id);
								$patentList = $this->opportunity_model->getDuePatentDataListByLeadID($licenseData->id,"patent_number");
								if(count($patentList)>0){
									foreach($patentList as $patent){
										$checkFileFormat = $this->checkingPDFIsValid($this->createPDFUrlForPatent($patent->patent_number));
										if(!empty($checkFileFormat) && $checkFileFormat=="application/pdf"){
											$updatedRows = $this->lead_model->updatePatentDueDilligencePDF(array('status'=>1),$patent->patent_number);
											if($updatedRows==0){
												/*Check And Insert*/
												$checkPDFRow = $this->lead_model->checkDueDilligencePDF($patent->patent_number);
												if($checkPDFRow==0){
													/*Insert*/
													$this->lead_model->insertDueDilligencePDF(array('status'=>1,'patent_id'=>$patent->patent_number));
												}
											}
										}
									}
								}
							}
							/*END checking PDF*/
							/*Check Left Chart*/
							$curl = curl_init();
							curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => 'https://synpat.com/file_get.php',
								CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
								CURLOPT_POST => 1,
								CURLOPT_POSTFIELDS => array(
									's'=>$data['lead_data']->serial_number
								)
							));	
							$response = curl_exec($curl);
							
							if($response){
								$getPreData = json_decode($response,true);
								
								if(count($getPreData)>0){
									$otherData = json_decode($getPreData['other_field'],true);
									
									$mainLeftChartData = array();
									if(isset($otherData['patent_list']) && count($otherData['patent_list'])>0){
										for($pl=0;$pl<count($otherData['patent_list']);$pl++){
											$mainLeftChartData[] = array($otherData['patent_list'][$pl]['country'],$otherData['patent_list'][$pl]['patent'],$otherData['patent_list'][$pl]['application']);
										}
									}
									
									if(count($mainLeftChartData)>0){
										$curl = curl_init();
										curl_setopt_array($curl, array(
											CURLOPT_RETURNTRANSFER => 1,
											CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/license_update_left_chart',
											CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
											CURLOPT_POST => 1,
											CURLOPT_POSTFIELDS => array(
												'license_number' => $storeName,
												'chart_left'=>json_encode($mainLeftChartData)
											)
										));
										// Send the request & save response to $resp
										$respChart = curl_exec($curl);
										/*chart Left*/
										$chartLeftData = $mainLeftChartData;
										if(count($chartLeftData)>0){
											$this->opportunity_model->deleteLeftChart($lead_id);
											for($i=0;$i<count($chartLeftData);$i++){
												if(!empty($chartLeftData[$i]->{'0'})){
													$this->opportunity_model->saveChartLeft(array('lead_id'=>$lead_id,'country'=>$chartLeftData[$i]->{'0'},'applications'=>$chartLeftData[$i]->{'1'},'patents'=>$chartLeftData[$i]->{'2'}),false);
												} else if(!is_object($chartLeftData[$i]) && isset($chartLeftData[$i]['0']) && !empty($chartLeftData[$i]['0'])){
													$this->opportunity_model->saveChartLeft(array('lead_id'=>$lead_id,'country'=>$chartLeftData[$i]['0'],'applications'=>$chartLeftData[$i]['1'],'patents'=>$chartLeftData[$i]['2']),false);
												}							
											}
										}
																			
									}
								}
							}							
							/*End Left Chart*/
		
							$update = $this->opportunity_model->updateLevel($lead_id,array('level'=>5));
							if($update==0){
								$this->opportunity_model->insertLevel(array('lead_id'=>$lead_id,'level'=>5));
							}
							$updateReport = $this->opportunity_model->updateReport($lead_id,$reportArray);
							if($updateReport==0){
								$this->opportunity_model->insertReport($reportArray);
							}
							
		
						} else if(!empty($getData->error)){
							echo "<p class='alert alert-danger'>".$getData->error."</p>";
							die;
						}						
					} else {
						echo "<p class='alert alert-danger'>Server is busy, Please try after sometime.</p>";
						die;
					}
				}
			}
			
			$findLeadData = $this->opportunity_model->getLeadDataByIdWithSelect($lead_id,'serial_number');
			$licenseData = $this->opportunity_model->getLicenseDataByLeadID($findLeadData->serial_number,"id");
			$this->opportunity_model->deleteDueDilligencePatent($licenseData->id);
								$this->opportunity_model->addDueDilligencePatentThroughLead($lead_id,$licenseData->id);
								$patentList = $this->opportunity_model->getDuePatentDataListByLeadID($licenseData->id,"patent_number");
			$data['acquisition'] = $this->acquisition_model->getData($lead_id);
			$checkStage = $this->opportunity_model->checkStage($lead_id);
			if(count($checkStage)==0){
				/*Insert Stage*/
				$this->opportunity_model->insertStage(array('lead_id'=>$lead_id,'stage'=>1));
				$checkStage = $this->opportunity_model->checkStage($lead_id);
			} else {
				/*if Stage is 2 then Check on Which Level it is*/
				if((int)$checkStage->stage>=2){		
					$checkLevel = $this->opportunity_model->checkLevel($lead_id);        
					$data['lead_level'] = $checkLevel;
				}
				if( isset($checkLevel) && count($checkLevel)>0 && (int)$checkLevel->level>2){
					$data['lead_contacts'] = array();
					$data['doc_shared'] = array();
        
				} else {
					$data['lead_contacts'] = array();
					$data['doc_shared'] = array();
				}
			}
				
			$data['buttons'] = $this->lead_model->checkDocketButtonList($lead_id);
			if(count($data['acquisition'])>0 && isset($data['acquisition']['acquisition']) && count($data['acquisition']['acquisition'])>0):
				if(count($data['buttons'])==0){
					$getButtonList = $this->general_model->getAllButtonList("DOCKET");
					if(count($getButtonList)>0){
						foreach($getButtonList as $button){
							$this->lead_model->insertDocketButton(array("lead_id"=>$lead_id,"sort"=>$button->sort,"button_id"=>$button->id));
						}
					}
					$data['buttons'] = $this->lead_model->checkDocketButtonList($lead_id);
				}
			endif;
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/getLicenseData',
				CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					'license_number' => $data['acquisition']['acquisition']->store_name,
				)
			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			if($resp){
				$data['acordion_text'] = json_decode($resp);
			} else {
				$data['acordion_text'] = array();
			}
			
			$data['lead_stage'] = $checkStage;        
			$data['lead_report'] = $this->opportunity_model->checkLeadReport($lead_id);
			$getFolderID = $folderID = $data['lead_data']->folder_id;
			if(!empty($getFolderID) && $getFolderID!=false){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$data['docs_list']['doc_info'] =  $service->getFileInfo($getFolderID);						
				$data['docs_list']['list'] = $service->getFileIDFromChildern($getFolderID);
				if($data['lead_data']->image_folder!="" && $data['lead_data']->image_folder!=null){
					$data['docs_list']['images'] = $service->getFileIDFromChildern($data['lead_data']->image_folder);
				} else {
					$fileParent = new Google_Service_Drive_ParentReference();
					$fileParent->setId( $data['lead_data']->folder_id );
					$getImageFolderInfo = $service->createSubFolder('image',$fileParent);
					$this->lead_model->from_litigation_update($lead_id,array("image_folder"=>$getImageFolderInfo));
					$data['docs_list']['images'] = $service->getFileIDFromChildern($getImageFolderInfo);
				}
				
			} else {
				$data['docs_list'] = array();
			}			
			
			$data['assets_data'] =$this->opportunity_model->getAllAssets($lead_id);
			if(count($data['lead_data'])>0){
				$patentScraperData = json_decode($data['lead_data']->patent_data);
				if(count($patentScraperData)>0){
					foreach($patentScraperData as $patent){
						if(isset($patent['0']) && $patent['0']!=null && $patent['0']!=""){
							$data['patent_data'][] = $patent['0'];
						}						
					}
				} else {
					$data['patent_data'] = array();
				}
			} else {
				$data['patent_data'] = array();
			}
			/*$data['market_sectors'] = $this->opportunity_model->getAllMarketSectors();*/
			/*$data['technologies'] = $this->opportunity_model->getAllTechnologies();*/
			$data['technologies'] = array();
			$data['potential'] = $this->opportunity_model->getPotential($lead_id);
			/*$data['commitment'] = $this->opportunity_model->getCommitment($lead_id);*/
			$data['chart_left'] = $this->opportunity_model->getChartLeft($lead_id);
			$data['chart_middle'] = $this->opportunity_model->getChartMiddle($lead_id);
			$data['chart_right'] = $this->opportunity_model->getChartRight($lead_id);
			$data['comparables'] = $this->opportunity_model->getComparable($lead_id);
			$data['damages'] = $this->opportunity_model->getDamages($lead_id);
			$data['lead_id'] = $lead_id;
			$data['category_list'] = $this->customer_model->getCategoryBySector(21);			
			$data['button_list'] = $this->opportunity_model->myButtonList($lead_id);			
			$data['template_accordion'] = $this->opportunity_model->getDocketTemplateAccordion('12345','portfolio_tab,counter_tab,simulator_tab,document_tab,claim_tab,invention_tab,price_tab,evidence_tab,comparables_tab,royalties_tab,fcitation_tab,seller_tab,pdf_tab,validity_tab,bcitation_tab,prior_tab,legal_tab,privacy_tab,tech_dd,market_dd,legal_dd,illustration_dd,image_dd,pdf_dd,seller_dd,dictionary_dd');
			$this->layout->title_for_layout = 'Backyard Working on Opportunity';
			$this->layout->render('opportunity/docket',$data);
		} else {
			redirect('dashboard');
		}
	}	
	public function drive_mode(){
		$data =array('status'=>'','url'=>'');
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$driveMode = $this->input->post();
			$getLeadData = $this->lead_model->getLeadData($driveMode['l']);
			if(count($getLeadData)>0){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$getFileDetail = $service->getFileInfo($driveMode['r']);
				if($getFileDetail){
					$folderID = $getLeadData->folder_id;
					$fileParent = new Google_Service_Drive_ParentReference();
					$fileParent->setId( $folderID );
					$title =  $getFileDetail->title;
					/*$strPos = stripos($title,"SynPat");
					if($strPos!==false){
						$title = substr($title,$strPos);
						$title = str_replace("Master",$getLeadData->lead_name,$title);
						$strPos = stripos($title,$getLeadData->lead_name);
						if($strPos===false){
							$title = $title." - ".$getLeadData->lead_name;
						}
					}*/
					$title = str_replace("Master",$getLeadData->lead_name,$title);
					$title = str_replace("master",$getLeadData->lead_name,$title);
					$getFileInfo = $service->copyFile($getFileDetail->id,$title,$fileParent);
					if(is_object($getFileInfo)){
						$updateDate = date('Y-m-d H:i:s');
						$update = $this->lead_model->updateDocketButton(array('file_name'=>$title,'file_url'=>$getFileInfo->alternateLink,'status'=>1,'update_date'=>$updateDate),$driveMode['b']);
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
	public function task_mode(){
		$data =array('status'=>'');
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$emailMode = $this->input->post();
			$getLeadData = $this->lead_model->getLeadData($emailMode['l']);
			if(count($getLeadData)>0){
				$updateDate = date('Y-m-d H:i:s');
				$update = $this->lead_model->updateDocketButton(array('status'=>1,'update_date'=>$updateDate),$emailMode['b']);
				if($update){
					$data['status'] = $updateDate;
				}
			}
		}
		echo json_encode($data);
		die;
	}
	public function email_mode(){
		$data =array('status'=>'','detail'=>'');
		if(isset($_POST) && count($_POST)>0){
			$emailMode = $this->input->post();
			$this->load->model('lead_model');
			$this->load->model('general_model');
			$findTemplate = $this->general_model->getTemplate($emailMode['r']);
			if(count($findTemplate)>0){
				$data['detail'] = $findTemplate;
				$updateDate = date('Y-m-d H:i:s');
				$update = $this->lead_model->updateDocketButton(array('status'=>1,'update_date'=>$updateDate),$emailMode['b']);
				if($update){
					$data['status'] = $updateDate;
				}
			}			
		}
		echo json_encode($data);
		die;
	}
	public function nda(){
		if(isset($_POST) && count($_POST)>0){
			$lead_id = $this->input->post('token');
			if(!empty($lead_id) && $lead_id!=0){
				$this->load->model('opportunity_model');
				$this->load->model('general_model');
				$this->load->model('lead_model');
				$this->load->model('acquisition_model');
				$findLeadData = $this->opportunity_model->getLeadData($lead_id);
				if(count($findLeadData)>0){
					switch($findLeadData->type){
						case 'Litigation':
							$plantiffName = $findLeadData->case_name." - ".$findLeadData->case_number;
						break;
						case 'Market':
						case 'General':
						case 'SEP':
							$plantiffName = $findLeadData->plantiffs_name." - ".$findLeadData->relates_to." - ".$findLeadData->portfolio_number;
						break;
						default:
							$plantiffName = $findLeadData->plantiffs_name.'_NDA';
						break;
					}				
			
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();			
					$folderID = $this->opportunity_model->assigned_lead_folder_ID($lead_id,'l.folder_id');
					if($folderID===false){						
						$fileParent = new Google_Service_Drive_ParentReference();
						$fileParent->setId( LEADS_FOLDERID);
						$folderID = $service->createSubFolder($findLeadData->lead_name.'_folder',$fileParent);
						if($folderID){
							/*Save Folder ID  in DB*/
							$this->general_model->updateFolderIDByLead($folderID,$lead_id);			
						}
					}			
					$fileID = $service->getFileNameFromChildern($folderID,$plantiffName);					
					if($fileID===false){
						/*Save File From Master Document to Opportunity Folder*/
			
						$parentFolderID = $service->getFileIdByName(MASTER_FOLDER);
						if($parentFolderID){
							$getNDAFileNameWithAccordingLeadType = $this->opportunity_model->doc_list('NDA',$findLeadData->type);
							if(count($getNDAFileNameWithAccordingLeadType)>0){
								/*Create Object*/
								$saveDocFIle = $getNDAFileNameWithAccordingLeadType->doc_id;
								$fileID = (object) array("id"=>$saveDocFIle);
							} else {
								$fileID = (object) array("id"=>"1-Pw8-L5yzkFyi8OKbWteAf6FnfUabDg1g-DtONZwL5o");
							}
							if(!empty($fileID)){
								$fileParent = new Google_Service_Drive_ParentReference();
								$fileParent->setId( $folderID );
								$getFileInfo = $service->copyFile($fileID->id,$plantiffName,$fileParent);
								if($getFileInfo){
									/*Change Level*/
			
									$user_history = array('lead_id'=>$lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"NDA created",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
									$this->load->model('user_model');
									$this->user_model->addUserHistory($user_history);	
			
									$service->setAdditionalPermissions( $getFileInfo->id, "","reader","anyone");
									$leadLevel = $this->opportunity_model->checkLevel($findLeadData->id);
									/*Update Leaddata*/
									$this->lead_model->from_litigation_update($lead_id,array("nda_id"=>$fileID->id));
									$this->acquisition_model->updateData($lead_id,array("nda_id"=>$getFileInfo->id));
									
									if(count($leadLevel)==0){
										$this->opportunity_model->insertLevel(array('lead_id'=>$findLeadData->id,'level'=>1));
									} else {
										$this->opportunity_model->updateLevel($findLeadData->id,array('level'=>1));
									}
									/*End Change Level*/
									/*Lead Report Card*/
									$checkLeadReport = $this->opportunity_model->checkLeadReport($findLeadData->id);
									if(count($checkLeadReport)==0){
										$this->opportunity_model->insertReport(array('lead_id'=>$findLeadData->id,'draft_nda'=>1));
									} else {
										$this->opportunity_model->updateReport(array('lead_id'=>$findLeadData->id,'draft_nda'=>1));
									}
									$url = $getFileInfo->alternateLink;
									echo json_encode(array('url'=>$url));
								} else {
									echo json_encode(array('url'=>''));
								}
							} else {
								echo json_encode(array('url'=>''));
							}
						} else {
							echo json_encode(array('url'=>''));
						}
					} else {
					   $service->setAdditionalPermissions($fileID->id,$this->session->userdata['email'],"reader","anyone",array("emailMessage"=>'NDA for '.$findLeadData->lead_name));
						$leadLevel = $this->opportunity_model->checkLevel($findLeadData->id);
						/*Update Leaddata*/
						$this->lead_model->from_litigation_update($lead_id,array("nda_id"=>$fileID->id));
						/*Update Acquisition*/
						$this->acquisition_model->updateData($lead_id,array("nda_id"=>$fileID->id));
                        /*End Update Acquisition*/
						if(count($leadLevel)==0){
							$this->opportunity_model->insertLevel(array('lead_id'=>$findLeadData->id,'level'=>1));
						} else {
							$this->opportunity_model->updateLevel($findLeadData->id,array('level'=>1));
						}
						/*End Change Level*/
						/*Lead Report Card*/
						$checkLeadReport = $this->opportunity_model->checkLeadReport($findLeadData->id);
						if(count($checkLeadReport)==0){
							$this->opportunity_model->insertReport(array('lead_id'=>$findLeadData->id,'draft_nda'=>1));
						} else {
							$this->opportunity_model->updateReport(array('lead_id'=>$findLeadData->id,'draft_nda'=>1));
						}
						$url = $fileID->alternateLink;
						echo json_encode(array('url'=>$url));
					}
				} else {
					echo json_encode(array('url'=>''));
				}
			} else {
				echo json_encode(array('url'=>''));
			}
		}
		die;
	}
	public function cipo_approval(){
		if(isset($_POST) && count($_POST)>0){
			$lead_id = $this->input->post('token');
			if(!empty($lead_id) && $lead_id!=0){
				$this->load->model('acquisition_model');
				$this->load->model('opportunity_model');
				$this->load->model('notification_model');
				$this->load->model('user_model');
				$this->load->model('general_model');
				$findLeadData = $this->opportunity_model->getLeadData($lead_id);
				/*Update Lead Report*/
				$this->opportunity_model->updateReport($findLeadData->id,array('cipo_approved'=>1));
				/*End Update*/
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				/*$folderID = $service->getFileIdByName($findLeadData->lead_name.'_folder');*/
                $folderID = $this->opportunity_model->assigned_lead_folder_ID($lead_id);
				if($folderID){
			        $getAcquisitionData = $this->acquisition_model->getData($lead_id);                    
                    $getFileInfo = $service->getFileInfo($getAcquisitionData['acquisition']->nda_id);
					if($getFileInfo){						
						$url = $getFileInfo->alternateLink;	
						$CIPOEmailAddress = $this->user_model->findUserByType('8');
						if(count($CIPOEmailAddress)>0){			
							$service->setAdditionalPermissions( $getFileInfo->id, "","reader","anyone");
							/*Send Notification to CIPO with link*/
							$sendID = $this->notification_model->insert(array('user_id'=>$CIPOEmailAddress->id,'message'=>'Waiting for your approval for <a href="'.$url.'" target="_BLANK">'.$url.'</a>'));
							/*Check DB Message and Subject*/
							$getData = $this->general_model->getTaskAccToType('NDA');
							$subject="NDA Approval";
							$message = "Waiting for you to approve NDA.";
							if(count($getData)>0){
								$subject = $getData->subject;
								$message = $getData->message;
							}
							/*End Checking*/
							$executionDate = date('Y-m-d');							
							$approvalRequest = $this->opportunity_model->sendApprovalRequest(array('subject'=>$subject,'message'=>$message,'user_id'=>$CIPOEmailAddress->id,'from_user_id'=>$this->session->userdata['id'],'lead_id'=>$lead_id,'execution_date'=>$executionDate,'doc_url'=> $url,'parent_id'=>'0','type'=>'NDA','status'=>'0'));						
							$user_history = array('lead_id'=>$lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"Send request to CIPO for NDA approval",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);	
							$updateLeadLevel = $this->opportunity_model->updateLevel($lead_id,array('level'=>2));
							$this->opportunity_model->updateReport($lead_id,array('cipo_approved'=>1));
							if($sendID>0){
								echo json_encode(array('send'=>$sendID,'subject'=>$subject,'message'=>$message,'user_id'=>$CIPOEmailAddress->id,'from_user_id'=>$this->session->userdata['id'],'lead_id'=>$lead_id,'execution_date'=>$executionDate,'doc_url'=> $url,'parent_id'=>'0','type'=>'NDA','status'=>'0','task_id'=>$approvalRequest));
							} else {
								echo json_encode(array('send'=>0));
							}
							/*Send Notification to CIPO with Link*/
						} else {
							echo json_encode(array('send'=>0));
						}				
						/*END PERMISSION RIGHT*/
					} else {
						echo json_encode(array('send'=>0));
					}	
				} else {
					echo json_encode(array('send'=>0));
				}	
			} else {
				echo json_encode(array('send'=>0));
			}	
		}else {
			echo json_encode(array('send'=>0));
		}	
		die;
	}	
	public function approved_doc($approvedID){
		if($approvedID>0){
		$this->load->model('opportunity_model');
		$this->load->model('user_model');
		$this->load->model('lead_model');
		$this->load->model('general_model');
		$checkApprovedData = $this->opportunity_model->checkApprovalData($approvedID,$this->session->userdata['id']);
		if(count($checkApprovedData)>0){
			if($this->session->userdata['type']=='8'){
				$update = $this->opportunity_model->updateApprovalData($approvedID,array('status'=>1));
				switch($checkApprovedData->type){
					case 'NDA':						
					$updateLeadReport = $this->opportunity_model->updateReport($checkApprovedData->lead_id,array('cipo_approved'=>2));
					$updateLeadLevel = $this->opportunity_model->updateLevel($checkApprovedData->lead_id,array('level'=>3));
					if($updateLeadLevel){
						$user_history = array('lead_id'=>$checkApprovedData->lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"CIPO approved NDA",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						$this->session->set_flashdata('message','<p class="alert alert-success">Approved</p>');
						return 1;
			
					} else {
			
						return 0;
					}
					break;
                    case 'PLA':						
					$updateLeadReport = $this->opportunity_model->updateReport($checkApprovedData->lead_id,array('draft_pla'=>2));
					if($updateLeadReport){
						$user_history = array('lead_id'=>$checkApprovedData->lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"CIPO approved PLA",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						$this->session->set_flashdata('message','<p class="alert alert-success">Approved</p>');
						return 1;
			
					} else {
			
						return 0;
					}
					break;
                    case 'Participant':						
					$updateLeadReport = $this->opportunity_model->updateReport($checkApprovedData->lead_id,array('draft_participant'=>2));
					if($updateLeadReport){
						$user_history = array('lead_id'=>$checkApprovedData->lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"CIPO approved Participant Request",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						$this->session->set_flashdata('message','<p class="alert alert-success">Approved</p>');
						return 1;
			
					} else {
			
						return 0;
					}
					break;
					case 'NDA_EXECUTE_APPROVAL':
						$updateReport = $this->opportunity_model->updateReport($checkApprovedData->lead_id,array('nda_execute'=>2));
						$updateStage = $this->opportunity_model->updateStage($checkApprovedData->lead_id,array('stage'=>3));
						if($updateReport){
							$user_history = array('lead_id'=>$checkApprovedData->lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"CIPO executed NDA",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);
							$this->session->set_flashdata('message','<p class="alert alert-success">Approved</p>');
							return 1;
						} else {
			
							return 0;
						}
					break;
					case 'DD':
					$updateLeadReport = $this->opportunity_model->updateReport($checkApprovedData->lead_id,array('start_dd'=>2));
					if($updateLeadReport){
						$this->session->set_flashdata('message','<p class="alert alert-success">Approved</p>');
						return 1;
					} else {
			
						return 0;
					}
					break;
					case 'ASSETS':
			
						$findLeadData = $this->lead_model->getLeadData($checkApprovedData->lead_id);						
						$asset_data = array();
						$this->load->library('DriveServiceHelper');
						$service = new SpreadsheetServiceHelper();
						$ss_id = $findLeadData->spreadsheet_id;
						$spreadsheet = $service->getSpreadsheetById($ss_id);
						$allWorkSheet = $service->getAllWorkSheets();
						$sheetID = $findLeadData->worksheet_id;
						$sheetName = "Sheet1";
						if(!empty($findLeadData->worksheet_id)){
							foreach($allWorkSheet as $worksheet){
								if(trim($worksheet['id'])==trim($sheetID)){
									$sheetName = $worksheet['text'];
									break;
								}
							}
						}
						if(!empty($sheetName)){
							$listFeed = $service->getWorkSheetByName($sheetName);
							$asset_data =$service->getAllRows($listFeed->getEntries());
						}
						
						if(count($asset_data)>0){
							$this->opportunity_model->deleteAssetData($checkApprovedData->lead_id );
							$insertData = 0;
							for($i=0;$i<count($asset_data);$i++){
								$insertData = $this->opportunity_model->insertAssetData(array('lead_id'=>$checkApprovedData->lead_id,'name'=>$asset_data[$i]['title']));
							}
							if($insertData>0){
								$user_history = array('lead_id'=>$checkApprovedData->lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"CIPO Approved assets.",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
								$this->user_model->addUserHistory($user_history);	
								$this->session->set_flashdata('message','<p class="alert alert-success">Approved</p>');
								return 1;
							} else {
								//$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime.</p>');
								return 0;
							}
						} else {
							return 0;
						}
						/*END*/
					break;
				}
			} else if($this->session->userdata['type']=='9'){
				$update = $this->opportunity_model->updateApprovalData($approvedID,array('status'=>1));
				switch($checkApprovedData->type){
					case 'NDA':								
						$updateLeadReport = $this->opportunity_model->updateReport($checkApprovedData->lead_id,array('executed_nda'=>2));
						$cipoUser = $this->user_model->findUserByType('8');
						$url = "";
						$getData = $this->lead_model->getLeadData($checkApprovedData->lead_id);
						if(count($getData)>0){
							$url = $getData->nda_id;
						}						
						/*Check DB Message and Subject*/
						$getData = $this->general_model->getTaskAccToType('NDA_EXECUTE_APPROVAL');
						$subject="NDA Approval Execution";
						$message = "NDA Approval Execution.";
						if(count($getData)>0){
							$subject = $getData->subject;
							$message = $getData->message;
						}
						/*End Checking*/
						$approvalRequest = $this->opportunity_model->sendApprovalRequest(array('from_user_id'=>$this->session->userdata['id'],'subject'=>$subject,'message'=>$message,'parent_id'=>0,'execution_date'=>date("Y-m-d"),'lead_id'=>$checkApprovedData->lead_id,'user_id'=>$cipoUser->id,'type'=>'NDA_EXECUTE_APPROVAL','doc_url'=>$url,'status'=>'0'));
						$insertData = $this->notification_model->insert(array('user_id'=>$cipoUser->id,'message'=>'<a href="'.$url.'" target="_BLANK">NDA</a> executed by CEO.'));
						if($updateLeadReport){
							$user_history = array('lead_id'=>$checkApprovedData->lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"NDA approved ",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);	
							$this->session->set_flashdata('message','<p class="alert alert-success">Approved</p>');
							return 1;
						} else {
							return 0;
						}
					break;
					case 'PPA':
						$updateLeadReport = $this->opportunity_model->updateReport($checkApprovedData->lead_id,array('execute_ppa'=>2));
						if($updateLeadReport){
							$user_history = array('lead_id'=>$checkApprovedData->lead_id,'user_id'=>$this->session->userdata['id'],'message'=>"PPA executed ",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);
							$this->session->set_flashdata('message','<p class="alert alert-success">Approved</p>');
							//echo json_encode(array('send'=>1));
							return 1;
						} else {
							return 0;
						}
					break;
				}
			}
		} else {
	
			return 0;
		}
	}
		
	}	
	public function executeNDA(){
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('general_model');
			$this->load->model('lead_model');
			$this->load->model('acquisition_model');
			$this->load->model('user_model');
			$this->load->model('notification_model');
			$this->load->model('opportunity_model');
			$leadID = $this->input->post('token');
			$getData = $this->lead_model->getLeadDataWithOptions($leadID,'l.type,l.folder_id');
			if(count($getData)>0 ){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$q = "title contains 'NDA' and mimeType = 'application/vnd.google-apps.document'";
				$listFiles = $service->searchFileIDFromChildern($getData->folder_id,$q);
				if(count($listFiles)>0){
					/*Update Leaddata*/
					$this->lead_model->from_litigation_update($leadID,array("nda_id"=>$listFiles[0]->id));
					$this->acquisition_model->updateData($leadID,array("nda_id"=>$listFiles[0]->id));
					$findAllAdminUsers = $this->user_model->findAdminUsers();
					$insertData = 0;
					if(count($findAllAdminUsers)>0){						
						foreach($findAllAdminUsers as $user){					
							$insertData = $this->notification_model->insert(array('user_id'=>$user->id,'message'=>'Execute NDA <a href="'.$listFiles[0]->alternateLink.'" target="_BLANK">NDA</a>'));	
							$getNDAData = $this->general_model->getTaskAccToType('NDA');
							$subject="NDA Execute";
							$message = "NDA Execute.";
							if(count($getNDAData)>0){
								$subject = $getNDAData->subject;
								$message = $getNDAData->message;
							}
							/*End Checking*/
							$approvalRequest = $this->opportunity_model->sendApprovalRequest(array('subject'=>$subject,'message'=>$message,'parent_id'=>0,'execution_date'=>date('Y-m-d'),'from_user_id'=>$this->session->userdata['id'],'user_id'=>$user->id,'lead_id'=>$leadID,'doc_url'=> $listFiles[0]->alternateLink,'type'=>'NDA','status'=>'0'));
						}
					}
					if($insertData>0){
						$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Execute NDA by PD",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						$update = $this->opportunity_model->updateLevel($leadID,array('level'=>5));
						if($update==0){
							$this->opportunity_model->insertLevel(array('lead_id'=>$leadID,'level'=>5));
						}
						$updateReport = $this->opportunity_model->updateReport($leadID,array('executed_nda'=>1));
						if($updateReport==0){
							$this->opportunity_model->insertReport(array('lead_id'=>$leadID,'executed_nda'=>1));
						}
						$buttonData = $this->lead_model->findButtonByButtonID($getData->type,"EXECUTE_NDA");
						echo json_encode(array('send'=>1,'subject'=>$subject,'message'=>$message,'parent_id'=>0,'execution_date'=>date('Y-m-d'),'from_user_id'=>$this->session->userdata['id'],'user_id'=>$user->id,'lead_id'=>$leadID,'doc_url'=> $listFiles[0]->alternateLink,'type'=>'NDA','status'=>'0','task_id'=>$approvalRequest,'button_data'=>$buttonData,'date_update'=>date('m d,y')));
					} else {
						echo json_encode(array('send'=>0,'message'=>'Not able to send task to users.'));
					}
				} else {
					echo json_encode(array('send'=>0,'message'=>'NDA not created. Please create NDA first.'));
				}
			} else {
				echo json_encode(array('send'=>0,'message'=>'Lead not exist.'));
			}
		} else {
			echo json_encode(array('send'=>0,'message'=>'Try to send request again.'));
		}  
		die;
	}	
	public function ndaExecuted(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('opportunity_model');
			$updateReport = $this->opportunity_model->updateReport($leadID,array('nda_execute'=>2));
			$updateStage = $this->opportunity_model->updateStage($leadID,array('stage'=>3));
			if($updateStage){
				echo json_encode(array('send'=>1));
			} else {
				echo json_encode(array('send'=>0));
			}
		}else {
			echo json_encode(array('send'=>0));
		}
		die;
	}	
	public function eouConfirmation(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('opportunity_model');
			$updateReport = $this->opportunity_model->updateReport($leadID,array('eou_folder'=>2));	
			$this->opportunity_model->updateStage($leadID,array('stage'=>5));
			if($updateReport){
				$date = date('Y-m-d H:i:s');
				$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"EOU confirmed",'opportunity_id'=>1,'create_date'=>$date);
				$this->load->model('user_model');
				$this->user_model->addUserHistory($user_history);	
				echo json_encode(array('send'=>1,'created'=>date('d-m-y', strtotime($date))));
			} else {
				echo json_encode(array('send'=>0));
			}
		}else {
			echo json_encode(array('send'=>0));
		}
		die;
	}    
    public function draft_pla(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('lead_id');
			$this->load->model('opportunity_model');
            $findLeadData = $this->opportunity_model->getLeadData($leadID);
			if(count($findLeadData)>0){
				$plantiffName = $findLeadData->lead_name.'_PLA';
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$folderID = $findLeadData->folder_id;
				if(!empty($folderID)){
					$fileID = $service->getFileNameFromChildern($folderID,$plantiffName);
					if($fileID===false){
						$parentFolderID = $service->getFileInfo(MASTER_FOLDERID);
						if(is_object($parentFolderID)){
							$getNDAFileNameWithAccordingLeadType = $this->opportunity_model->doc_list('PLA',$findLeadData->type);
							if(count($getNDAFileNameWithAccordingLeadType)>0){								
								$fileID = (object)array("id"=>$getNDAFileNameWithAccordingLeadType->doc_id) ;
							} else {
								$fileID = $service->getFileNameFromChildern($parentFolderID->id,'PLA - Patent License Agreement - Master');
							}
							if(!empty($fileID)){
								$fileParent = new Google_Service_Drive_ParentReference();
								$fileParent->setId( $folderID );
								$getFileInfo = $service->copyFile($fileID->id,$plantiffName,$fileParent);
								if($getFileInfo){
									$updateReport = $this->opportunity_model->updateReport($leadID,array('draft_pla'=>2));
									$service->setAdditionalPermissions( $getFileInfo->id, "","reader","anyone");
									$this->acquisition_model->updateData($leadID,array("pla"=>$getFileInfo->alternateLink));														
									$url = $getFileInfo->alternateLink;
									$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"PLA Created",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
									$this->load->model('user_model');
									$this->user_model->addUserHistory($user_history);	
									echo json_encode(array('url'=>$url));
								} else {
									echo json_encode(array('url'=>''));
								}
							} else {
								echo json_encode(array('url'=>''));
							}
						} else {
							echo json_encode(array('url'=>''));
						}
					} else {
						$updateReport = $this->opportunity_model->updateReport($leadID,array('draft_pla'=>2));
						$service->setAdditionalPermissions( $fileID->id, "","reader","anyone");
						$this->load->model('acquisition_model');
						$this->acquisition_model->updateData($leadID,array("pla"=>$fileID->alternateLink));
						$url = $fileID->alternateLink;
						echo json_encode(array('url'=>$url));
					}
				} else {
					echo json_encode(array('url'=>''));
				}				
			} else {
				echo json_encode(array('url'=>''));
			}
		} else {
			echo json_encode(array('url'=>''));
		}
		die;
	}    
	public function draft_participant(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('lead_id');
			$this->load->model('opportunity_model');
			$this->load->model('acquisition_model');
			$this->load->model('user_model');
            $findLeadData = $this->opportunity_model->getLeadData($leadID);
			if(count($findLeadData)>0){
				$plantiffName = $findLeadData->lead_name.' - RTP';
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$folderID = $findLeadData->folder_id;
				if(!empty($folderID)){
					$fileID = $service->getFileNameFromChildern($folderID,$plantiffName);
					if($fileID===false){
						$parentFolderID = $service->getFileIdByName(MASTER_FOLDERID);
						if(is_object($parentFolderID)){
							$getNDAFileNameWithAccordingLeadType = $this->opportunity_model->doc_list('RTP',$findLeadData->type);
							if(count($getNDAFileNameWithAccordingLeadType)>0){								
								$fileID = (object)array("id"=>$getNDAFileNameWithAccordingLeadType->doc_id) ;
							} else {
								$fileID = $service->getFileNameFromChildern($parentFolderID->id,'5 SynPat - Request to Participate - Master');
							}
							if(!empty($fileID)){
								$fileParent = new Google_Service_Drive_ParentReference();
								$fileParent->setId( $folderID );
								$getFileInfo = $service->copyFile($fileID->id,$plantiffName,$fileParent);
								if($getFileInfo){
									$updateReport = $this->opportunity_model->updateReport($leadID,array('draft_participant'=>2));
									$service->setAdditionalPermissions( $getFileInfo->id, "","reader","anyone");									
									$this->acquisition_model->updateData($leadID,array("rtp"=>$getFileInfo->alternateLink));
									$fileID = $getFileInfo->id;									
									$url = $getFileInfo->alternateLink;
									$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"RTP Created",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
									$this->user_model->addUserHistory($user_history);	
									echo json_encode(array('url'=>$url));
								} else {
									echo json_encode(array('url'=>''));
								}
							} else {
								echo json_encode(array('url'=>''));
							}
						} else {
							echo json_encode(array('url'=>''));
						}
					} else {
						$updateReport = $this->opportunity_model->updateReport($leadID,array('draft_participant'=>2));
						$service->setAdditionalPermissions( $fileID->id, "","reader","anyone");
						$this->acquisition_model->updateData($leadID,array("rtp"=>$fileID->alternateLink));
						$fileID = $getFileInfo->id;									
						$url = $getFileInfo->alternateLink;
						echo json_encode(array('url'=>$url));
					}
				} else {
					echo json_encode(array('url'=>''));
				}				
			} else {
				echo json_encode(array('url'=>''));
			}
		} else {
			echo json_encode(array('url'=>''));
		}
		die;
	}    	
	public function sendEouData(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$eouData = json_decode($this->input->post('eou_data'));
			$sep = $this->input->post('sep');
			$potential = $this->input->post('potential');
			$this->load->model('acquisition_model');
			$this->load->model('opportunity_model');
			$update = $this->acquisition_model->updateData($leadID,array('no_of_sep'=>$sep,'no_of_potential_licensees'=>$potential));
			if(count($eouData)>1){
				$this->opportunity_model->deleteEouData($leadID );
				$insertData = 0;
				for($i=0;$i<count($eouData)-1;$i++){
					$insertData = $this->opportunity_model->insertEouData(array('lead_id'=>$leadID,'standard'=>$eouData[$i]->{'0'},'company'=>$eouData[$i]->{'1'},'product'=>$eouData[$i]->{'2'},'eou'=>$eouData[$i]->{'3'},'quality'=>$eouData[$i]->{'4'},'in_folder'=>$eouData[$i]->{'5'},'created'=>date('Y-m-d'),'user_id'=>$this->session->userdata['id']));
				}
				if($insertData>0){	
					$this->load->model('user_model');
					$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Send EOU",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);	
					echo json_encode(array('send'=>1));
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
	public function sep_data(){		
		if(isset($_POST) && count($_POST)>0){			
			$getData = $this->input->post();	
			$this->load->model('acquisition_model');
			$this->load->model('opportunity_model');
			if(isset($getData['sep']['lead_id']) && (int) $getData['sep']['lead_id']>0){				
				$leadID = $getData['sep']['lead_id'];
				$this->acquisition_model->updateData($leadID,array('no_of_sep'=>$getData['sep']['numbers'],'no_of_potential_licensees'=>$getData['sep']['potential_licensees']));
				$sepData = json_decode($getData['sep']['sep_data']);				
				$sepAnotherData = json_decode($getData['sep']['sep_another_data']);
				if(count($sepData)>1){
					$this->opportunity_model->deleteSepData($leadID );
					for($i=0;$i<count($sepData)-1;$i++){
						$insertData = $this->opportunity_model->insertSepData(array('lead_id'=>$leadID,'standard'=>$sepData[$i]->{'0'},'product'=>$sepData[$i]->{'1'},'eou'=>$sepData[$i]->{'2'},'in_folder'=>$sepData[$i]->{'3'}  ));
					}
				} 
				if(count($sepAnotherData)>1){
					$this->opportunity_model->deleteSepAnotherData($leadID );
					for($i=0;$i<count($sepAnotherData)-1;$i++){
						$insertData = $this->opportunity_model->insertSepAnotherData(array('lead_id'=>$leadID,'company'=>$sepAnotherData[$i]->{'0'},'product'=>$sepAnotherData[$i]->{'1'},'eou'=>$sepAnotherData[$i]->{'2'},'in_folder'=>$sepAnotherData[$i]->{'3'}  ));
					}					
				}
				redirect('opportunity/docket/'.$leadID);
			} else {
				redirect('dashboard');
			}
		} else {
			$this->session->set_flashdata('message','<p class="alert alert-warning">Invalid data</p>');
			redirect('dashboard');
		}	
	}	
	public function upload_image_file(){
		$data =0;
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('l');
			$fileName = $this->input->post('n');
			if((int)$leadID>0){
				$this->load->model('opportunity_model');
				$findLeadData = $this->opportunity_model->getLeadData($leadID);
				if(count($findLeadData)>0){
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$folderID = $findLeadData->image_folder;	 							
					if(!empty($folderID)){
						$fileParent = new Google_Service_Drive_ParentReference();
						$fileParent->setId( $folderID );
						$fileURL = $this->input->post('i');
						$pathInfo = pathinfo($fileURL);
						if(count($pathInfo)>0){
							if(!empty($pathInfo['extension'])){
								$fileName = $fileName.".".$pathInfo['extension'];
								
								$finfo = new finfo(FILEINFO_MIME);
								$mimeType =  $finfo->buffer(file_get_contents($fileURL)); 
								if(!empty($mimeType)){
									$m = explode(";",$mimeType);
									$mimeType = $m[0];
								}								 
								if(empty($mimeType)){
									$mimeType = "image/jpeg";
								}								
								$convert=false;								
								$getUploadFileData = $service->insertFile($fileName,$mimeType,$fileURL,$fileParent,$convert);
								if($getUploadFileData){
									/*$service->setAdditionalPermissions( $getUploadFileData->id, $this->session->userdata['email'],"reader","anyone",array('emailMessage'=>'File has been share with you .','sendNotificationEmails'=>true));*/									
									$service->setAdditionalPermissions( $getUploadFileData->id, "","reader","anyone");
									if(isset($getUploadFileData->id) && !empty($getUploadFileData->id)){
										$downloadContent = $service->downloadFile($getUploadFileData);
										if($downloadContent!=null){
											/*$filename = $getUploadFileData->title;*/
											$fh = fopen($_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$fileName, "w+");
											fwrite($fh, $downloadContent);
											fclose($fh);
											$data = 1;
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

	public function find_user_activites(){
		if(isset($_POST) && $_POST['id']>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->findCallActivityLogByContactID($_POST['id']);
			echo json_encode($data);
		}
		die;
	}

	public function delete_user_activity(){
		if(isset($_POST) && $_POST['id']>0){
			$contactID = $this->input->post('contact_id');
			$leadID = $this->input->post('lead_id');
			$companyID = $this->input->post('company_id');
			$this->load->model('lead_model');
			$getActivityDetail = $this->lead_model->getActivityDetailsByCLC($contactID,$leadID,$companyID);
			if(count($getActivityDetail)>0){
				$allActivityIDs = array();
				$emailIDs = array();
				foreach($getActivityDetail as $activity){
					$allActivityIDs[] = $activity->id;
					if($activity->type==3 || $activity->type==6){
						if($activity->email_id>0){
							$emailIDs[] = $activity->email_id;
						}
					}
				}
				$data = $this->lead_model->delete_user_activity_by_ids($allActivityIDs);
				if(count($emailIDs)>0){
					/*Delete from emails table */
					$this->lead_model->deleteEmailActivityByIds($emailIDs);
				}
			}			
			echo $data;
		}
		die;
	}
	
	public function find_company_scrape_date(){
		if(isset($_POST) && $_POST['c']>0){
			$this->load->model('opportunity_model');
			$data = $this->opportunity_model->find_company_data_by_id($_POST['c'],'co.scrapped_date,co.company_name');
			$data->count_users = $this->opportunity_model->getCountAllContactBelongToCompany($_POST['c']);
			echo json_encode($data);
		}
		die;
	}

	public function find_company_scrape_data(){
		if(isset($_POST) && $_POST['c']>0){
			$this->load->model('opportunity_model');
			$data = $this->opportunity_model->find_company_data_by_id($_POST['c'],'co.*',false,true);
			echo json_encode($data);
		}
		die;
	}

	public function captcha_challenge_confirm(){
		if(isset($_POST) && $_POST['id']>0){
			$this->load->model('opportunity_model');
			$data = $this->opportunity_model->update_captcha_confirm_scrapper(array('status'=>1), $_POST['id']);
			echo json_encode($data);
		}
	}
	
	public function draft_a_ppa(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			if((int)$leadID>0){
				$this->load->model('opportunity_model');
				$this->load->model('acquisition_model');
				$this->load->model('lead_model');
				$this->load->model('user_model');
				$findLeadData = $this->lead_model->getLeadDataWithOptions($leadID,'id,lead_name,folder_id,type');
				if(count($findLeadData)>0){
					/*$sellerAskingPrice= 0;
					$getAcqusitionData = $this->acquisition_model->getData($leadID);
					if(count($getAcqusitionData)>0){
						$sellerAskingPrice = $getAcqusitionData['acquisition']->seller_upfront;
					}*/
					if(count($findLeadData)>0){
						$plantiffName = "Patent Purchase Agreement with Seller - ".$findLeadData->lead_name;
						$this->load->library('DriveServiceHelper');
						$service = new DriveServiceHelper();
						$folderID = $findLeadData->folder_id;
						if(!empty($folderID)){	
							$fileID = false;
							if($fileID===false){
								/*Save File From Master Document to Opportunity Folder*/
								/*$parentFolderID = $service->getFileInfo(MASTER_FOLDERID);*/
								$parentFolderID = (object)array('id'=>$service->getFileInfo(MASTER_FOLDERID));
								if($parentFolderID){
									$getNDAFileNameWithAccordingLeadType = $this->opportunity_model->doc_list('PPA',$findLeadData->type);
									if(count($getNDAFileNameWithAccordingLeadType)>0){										
										$fileID = (object)array("id"=>$getNDAFileNameWithAccordingLeadType->doc_id) ;
									} else {
										switch($findLeadData->type){
											/*case 'Litigation':
												$fileID = $service->getFileNameFromChildern($parentFolderID,'3 SynPat - Patent Purchase Agreement (PPA) - Litigated - Master');
											break;*/
											default:												
												$fileID = (object)array('id'=>'1WTY1pSDY8ElMsQlIwjj4-n9cFtcWCRA_jIdTi5Sc0K4');
											break;
										}										
									}
									if(!empty($fileID)){
										$fileParent = new Google_Service_Drive_ParentReference();
										$fileParent->setId( $folderID );
										$getFileInfo = $service->copyFile($fileID->id,$plantiffName,$fileParent);
										if(is_object($getFileInfo)){
											$dateUpdated = date('Y-m-d H:i:s');
	
											$this->lead_model->from_litigation_update($leadID,array("ppa_id"=>$getFileInfo->id,'ppa_text_date'=>$dateUpdated));
											$this->acquisition_model->updateData($leadID,array("ppa_id"=>$getFileInfo->id));
											$fileID = $getFileInfo->id;
											/*Create PPP*/
											/*$filePPPOID = $service->getFileNameFromChildern($folderID,"Program Procedure and Policies (PPP) - ".$findLeadData->lead_name);*/
											$filePPPOID = false;
											$alternateUrlPPP="";
											if($filePPPOID==false){
												$getNDAFileNameWithAccordingLeadType = $this->opportunity_model->doc_list('PPP',$findLeadData->type);
												$PPPfileID="";
												if(count($getNDAFileNameWithAccordingLeadType)>0){												
													$PPPfileID = (object)array("id"=>$getNDAFileNameWithAccordingLeadType->doc_id) ;
												} else {
													/*$PPPfileID = $service->getFileNameFromChildern($parentFolderID->id,'PPP - Program Procedure and Policies - Master 12-9-14');
													*/
													$PPPfileID = (object) array("id"=>"1_p4w6fHQ7o-LLJdCQibssM0B7qQkKGwPxs9X5-wbXGU");
												}												
												if(!empty($PPPfileID)){
													$PPPName = "Program Procedure and Policies (PPP) - ".$findLeadData->lead_name;
													$getPPPFileInfo = $service->copyFile($PPPfileID->id,$PPPName,$fileParent);
													if(is_object($getPPPFileInfo)){
														$alternateUrlPPP = $getPPPFileInfo->id;
													}
												}
											} else {
												$alternateUrlPPP = $filePPPOID->id;
											}
											$originalButtonData = $this->lead_model->findButtonByButtonID($findLeadData->type,"DRAFT_PPA");
											if(count($originalButtonData)>0){
												$leadButtonData = $this->lead_model->findLeadButtonByButtonID($findLeadData->id,$originalButtonData->id);
												if(count($leadButtonData)>0){
													$newStatus = "";									
													$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($dateUpdated)).'</span>'.$originalButtonData->status_message.' <br/>';
													$newStatus = $leadButtonData->status_message_fill.$newStatus;	
													$this->lead_model->updateButton(array('status'=>1,'update_date'=>$dateUpdated,'status_message_fill'=>$newStatus),$leadButtonData->id);
												}
											}
											$this->opportunity_model->updateReport($findLeadData->id,array('draft_a_ppa'=>2));
											$this->opportunity_model->updateStage($findLeadData->id,array('stage'=>'5'));
											$url = $getFileInfo->alternateLink;
											$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"PPP Created",'opportunity_id'=>1,'create_date'=>$dateUpdated);
											$this->user_model->addUserHistory($user_history);
											$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"PPA drafted ",'opportunity_id'=>1,'create_date'=>$dateUpdated);
											$this->user_model->addUserHistory($user_history);	
											echo json_encode(array('url'=>$url,'date_updated'=>$dateUpdated,"ppp_url"=>$alternateUrlPPP));
										} else {
											echo json_encode(array('url'=>''));
										}
									} else {
										echo json_encode(array('url'=>''));
									}
								} else {
									echo json_encode(array('url'=>''));
								}
							} else {
								$dateUpdated = date('Y-m-d H:i:s');
								$this->lead_model->from_litigation_update($findLeadData->id,array("ppa_id"=>$fileID->id,'ppa_text_date'=>$dateUpdated));
								$this->opportunity_model->updateReport($findLeadData->id,array('draft_a_ppa'=>2));
								$url = $fileID->alternateLink;										
								$service->setAdditionalPermissions( $getFileInfo->id, "","reader","anyone");
								echo json_encode(array('url'=>$url,'date_updated'=>$dateUpdated));
							}
						} else {
							echo json_encode(array('url'=>''));
						}
					} else {
						echo json_encode(array('url'=>''));
					}							
				} else {
					echo json_encode(array('url'=>''));
				}
			} else {
				echo json_encode(array('url'=>''));
			}
		} else {
			echo json_encode(array('url'=>''));
		}
		die;
	}	
	public function startUpdatePatent(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('lead_model');
			$this->load->model('opportunity_model');
			$findLeadData = $this->lead_model->getLeadData($leadID);
			if(count($findLeadData)>0){
				$this->load->library('DriveServiceHelper');
				$service = new SpreadsheetServiceHelper();
				$ss_id = $findLeadData->spreadsheet_id;
				if(empty($ss_id)){
					$string = $findLeadData->file_url;
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
				}
				if(!empty($ss_id)):
				$spreadsheet = $service->getSpreadsheetById($ss_id);
				$allWorkSheet = $service->getAllWorkSheets();
				$sheetID = $findLeadData->worksheet_id;
				$sheetName = "Sheet1";
				if(!empty($findLeadData->worksheet_id)){
					foreach($allWorkSheet as $worksheet){
						if(trim($worksheet['id'])==trim($sheetID)){
							$sheetName = $worksheet['text'];
							break;
						}
					}
				}
				$asset_data = array();
				if(!empty($sheetName)){
					$listFeed = $service->getWorkSheetByName($sheetName);
					$asset_data =$service->getAllRows($listFeed->getEntries());
				}
				
				if(count($asset_data)>0){
					$this->opportunity_model->deleteAssetData($findLeadData->id );
					$insertData = 0;
					for($i=0;$i<count($asset_data);$i++){
						if(isset($asset_data[$i]['patent'])){
							$insertData = $this->opportunity_model->insertAssetData(array('lead_id'=>$findLeadData->id,'name'=>$asset_data[$i]['patent']));
						} else if(isset($asset_data[$i]['patents'])){
							$insertData = $this->opportunity_model->insertAssetData(array('lead_id'=>$findLeadData->id,'name'=>$asset_data[$i]['patents']));
						} else if(isset($asset_data[$i]['assets'])){
							$insertData = $this->opportunity_model->insertAssetData(array('lead_id'=>$findLeadData->id,'name'=>$asset_data[$i]['assets']));
						}						
					}
				}
				$data = $this->opportunity_model->getAllAssets($leadID);
				endif;
			}
		}
		echo json_encode($data);
		die;
	}	
	public function patent_update(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('acquisition_model');
			$acquisitionData = $this->acquisition_model->getData($this->input->post('l'));
			if(count($acquisitionData)>0){
				$curl = curl_init();
				// Set some options - we are passing in a useragent too here
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/update_patent_one_by_one',
					CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'license_number' => $acquisitionData['acquisition']->store_name,
						'patent_data'=>json_encode($_POST)
					)
				));						
				$resp = curl_exec($curl);
				if($resp){
					$data = json_decode($resp);
					if(isset($data->send) && $data->send==1){
						$data = 1;
						$this->load->model('user_model');
						$user_history = array('lead_id'=>$this->input->post('l'),'user_id'=>$this->session->userdata['id'],'message'=>"Updated list of Patentees in Store",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);	
					}
				}				
			}
		}
		echo $data;
		die;
	}	
	public function updateIllustration(){
		$data = 0;
		$dataFindIllustration = false;
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('lead_model');
			$this->load->model('acquisition_model');
			$leadInfo = $this->lead_model->getLeadData($leadID);
			if(count($leadInfo)>0){
				$this->load->library('DriveServiceHelper');
				$service = new SpreadsheetServiceHelper();
				$fileName = "Claim Illustration - ".$leadInfo->lead_name;
				$leadFolderID = $leadInfo->folder_id;
				$ss_id = $leadInfo->spreadsheet_id;
				if(empty($ss_id)){
					$getFilePatent = $service->getFileNameFromChildern($leadFolderID,"Patent List - ".$leadInfo->lead_name);
					if($getFilePatent){
						$ss_id = $getFilePatent->id;
					}
				}
				if(!empty($ss_id)){
					$driveService = new DriveServiceHelper();
					$illuFolder = $driveService->getFileNameFromChildern($leadFolderID,"Illustration");
					if(is_object($illuFolder)){
						$allFilesFromIllustration = $driveService->getFileIDFromChildern($illuFolder->getId());
						$spreadsheet = $service->getSpreadsheetById($ss_id);
						$allWorkSheet = $service->getAllWorkSheets();
						$sheetName = "Sheet1";
						if(!empty($sheetName)){
							$listFeed = $service->getWorkSheetByName($sheetName);
							$asset_data =$service->getAllRows($listFeed->getEntries());
							$inventionsData = array();
							$driveService = new DriveServiceHelper();
							for($i=0;$i<count($asset_data);$i++){
								$patent = "";
								if(isset($asset_data[$i]['patents'])){
									$patent = $asset_data[$i]['patents'];
								} else if(isset($asset_data[$i]['patent'])){
									$patent = $asset_data[$i]['patent'];
								} else if(isset($asset_data[$i]['assets'])){
									$patent = $asset_data[$i]['assets'];
								}
								/*strpos Expired*/
								if(!empty($patent)){
									$illustrationFileName = 'Synpat - Claim Illustration - '.$leadInfo->lead_name.' - '.$patent;
									/*$getIllustrationFileInfo = $driveService->getFileNameFromChildern($illuFolder->getId(),$illustrationFileName);
									if(is_object($getIllustrationFileInfo)){
										$illuID = $getIllustrationFileInfo->getId();
										if(is_object($getIllustrationFileInfo)&& !empty($illuID)){
											$inventionsData[] = array("patent_id"=>$patent,"file"=>$getIllustrationFileInfo->alternateLink);
											$dataFindIllustration = true;
										}
									}*/
									if(count($allFilesFromIllustration)>0){
										foreach($allFilesFromIllustration as $illustrationFile){
											if($illustrationFile->getTitle()==$illustrationFileName){
												$inventionsData[] = array("patent_id"=>$patent,"file"=>$illustrationFile->alternateLink);
												$dataFindIllustration = true;
											}
										}
									}
								}
							}							
							if(count($inventionsData)>0){
								$acquisitionData = $this->acquisition_model->getData($leadID);
								if(count($acquisitionData) && !empty($acquisitionData['acquisition']->store_name)){
									$curl = curl_init();
									curl_setopt_array($curl, array(
										CURLOPT_RETURNTRANSFER => 1,
										CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/updateillustrationData',
										CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
										CURLOPT_POST => 1,
										CURLOPT_POSTFIELDS => array(
											'license_number' => $acquisitionData['acquisition']->store_name,
											'inventions_data'=>json_encode($inventionsData)
										)
									));
									
									$resp = curl_exec($curl);
									if($resp){
										$data = $resp;				
									} 
								}
							}
						}
					}
				}
			}
		}
		if($dataFindIllustration ===false){
			echo "1";
		} else {
			echo $data;
		}
		
		die;
	}	
	public function startInventionData(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('lead_model');
			$this->load->model('acquisition_model');
			$this->load->model('user_model');
			$leadInfo = $this->lead_model->getLeadData($leadID);
			if(count($leadInfo)>0){
				$this->load->library('DriveServiceHelper');
				$service = new SpreadsheetServiceHelper();
				$fileID = "";
				if(!empty($leadInfo->technical_file)){
					$fileID = $leadInfo->technical_file;
				} else {
					$fileName = "Technical Due Dilligence - ".$leadInfo->lead_name;
					$leadFolderID = $leadInfo->folder_id;
					$driveService = new DriveServiceHelper();
					$fileInfo = $driveService->getFileIdByName($fileName);
					if($fileInfo!=""){
						$fileID = $fileInfo;
					}
				}
				if(!empty($fileID)){
					$ss_id = $fileID;
					$spreadsheet = $service->getSpreadsheetById($ss_id);
					$allWorkSheet = $service->getAllWorkSheets();
					$sheetName = "Sheet1";
					if(!empty($sheetName)){
						$listFeed = $service->getWorkSheetByName($sheetName);
						$asset_data =$service->getAllRows($listFeed->getEntries());
						$inventionsData = array();
						for($i=0;$i<count($asset_data);$i++){
							$s=0;
							$inLineArray = array();
							foreach($asset_data[$i] as $key=>$patent){
								if($s<7){
									$inLineArray[] = $patent;
								}
								$s++;
							}
							$inventionsData[] = array("patent_id"=>$inLineArray[0],"problem"=>$inLineArray[1],"solution"=>$inLineArray[2],"system"=>$inLineArray[3],"products"=>$inLineArray[4],"companies"=>$inLineArray[5],"p_infringe"=>$inLineArray[6]);
						}
						
						if(count($inventionsData)){
							$acquisitionData = $this->acquisition_model->getData($leadID);
							if(count($acquisitionData) && !empty($acquisitionData['acquisition']->store_name)){
								$curl = curl_init();
								curl_setopt_array($curl, array(
									CURLOPT_RETURNTRANSFER => 1,
									CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/updateInventionData',
									CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
									CURLOPT_POST => 1,
									CURLOPT_POSTFIELDS => array(
										'license_number' => $acquisitionData['acquisition']->store_name,
										'inventions_data'=>json_encode($inventionsData)
									)
								));
								// Send the request & save response to $resp
								$resp = curl_exec($curl);
								if($resp){
									$data = $resp;
									$this->load->library('DriveServiceHelper');
									$service = new DriveServiceHelper();
									$getFileInfo = $service->getFileInfo($leadInfo->technical_file);
									if($getFileInfo){
										$service->deletePermission($getFileInfo->id,"anyoneWithLink");
										$getDueLogTime = $this->user_model->getDueData($leadID);
										if(count($getDueLogTime)>0){
											$this->user_model->update_due_logtime(array("permmission"=>0),$getDueLogTime->id);
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
	public function approvalList(){
		if(isset($_POST) && count($_POST)>0){		  
			$leadID = $this->input->post('token');
			$asset_data = json_decode($this->input->post('asset_data'));
			if($leadID>0){
				$this->load->model('lead_model');
				$this->load->model('opportunity_model');
				$this->load->model('user_model');
				$this->load->model('notification_model');
				$this->load->model('acquisition_model');
				$this->load->model('general_model');
				/*Find Sheet*/
				$insertData = 0;
				$asset_data = array();
				$leadData = $this->lead_model->getLeadData($leadID);
				$this->load->library('DriveServiceHelper');
				$service = new SpreadsheetServiceHelper();
				$ss_id = $leadData->spreadsheet_id;
				$spreadsheet = $service->getSpreadsheetById($ss_id);
				$allWorkSheet = $service->getAllWorkSheets();
				$sheetID = $leadData->worksheet_id;
				$sheetName = "Sheet1";
				if(!empty($leadData->worksheet_id)){
					foreach($allWorkSheet as $worksheet){
						if(trim($worksheet['id'])==trim($sheetID)){
							$sheetName = $worksheet['text'];
							break;
						}
					}
				}
				if(!empty($sheetName)){
					$listFeed = $service->getWorkSheetByName($sheetName);
					$asset_data =$service->getAllRows($listFeed->getEntries());
				}
				
				for($i=0;$i<count($asset_data);$i++){
					foreach($asset_data[$i] as $key=>$patent){
						if(!empty($patent)){
							$insertData = $this->opportunity_model->insertAssetData(array('lead_id'=>$leadID,'name'=>$patent));
						}						
					}
				}
				if($insertData>0){
					$CIPOEmailAddress = $this->user_model->findUserByType('8');
					$url = $leadData->file_url;	
					$sendID = $this->notification_model->insert(array('user_id'=>$CIPOEmailAddress->id,'message'=>'Waiting for your approval for <a href="'.$url.'" target="_BLANK">'.$url.'</a>'));
					$this->acquisition_model->updateData($leadID,array("assets_id"=>$leadData->spreadsheet_id));
					$getData = $this->general_model->getTaskAccToType('ASSETS');
					$subject="Assets";
					$message = "Approve list of Assets.";
					if(count($getData)>0){
						$subject = $getData->subject;
						$message = $getData->message;
					}
					$approvalRequest = $this->opportunity_model->sendApprovalRequest(array('subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$CIPOEmailAddress->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'ASSETS','status'=>'0'));
					$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Insert list of Assets",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);	
					echo json_encode(array('url'=>$url,'subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$CIPOEmailAddress->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'ASSETS','status'=>'0','task_id'=>$approvalRequest));
				} else {
					echo json_encode(array('url'=>''));
				}
			} else {
				echo json_encode(array('url'=>''));
			}			
		} else {
			echo json_encode(array('url'=>''));
		}
		die;
	}	
	public function execute_ppa(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('opportunity_model');
			$this->load->model('acquisition_model');
			$this->load->model('user_model');
			$this->load->model('notification_model');
			$this->load->model('general_model');
			$findLeadData = $this->opportunity_model->getLeadData($leadID);
            $acquisitionData = $this->acquisition_model->getData($leadID);
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$folderID = $findLeadData->folder_id;
			if(!empty($folderID)){
				if(count($acquisitionData)>0 && isset($acquisitionData['acquisition']) && count($acquisitionData['acquisition'])>0){
					$fileID = $service->getFileInfo($acquisitionData['acquisition']->ppa_id);
				} else if($findLeadData->ppa_id!=""){
					$fileID = $service->getFileInfo($findLeadData->ppa_id);
				} else {
					$fileID = false;
				}				
				if($fileID){
					$url = $fileID->alternateLink;
					$this->lead_model->from_litigation_update($findLeadData->id,array("execute_ppa"=>2));
					$adminUsers = $this->user_model->findAdminUsers();		
					if(count($adminUsers)>0){
						$send = 0;
						foreach($adminUsers as $user){
							$sendID = $this->notification_model->insert(array('user_id'=>$user->id,'message'=>'Waiting for your approval for <a href="'.$url.'" target="_BLANK">'.$url.'</a>'));
							$updateReport = $this->opportunity_model->updateReport($leadID,array('execute_ppa'=>1));
							/*Check DB Message and Subject*/
							$getData = $this->general_model->getTaskAccToType('PPA');
							$subject="Execute PPA";
							$message = "PPA Execute.";
							if(count($getData)>0){
								$subject = $getData->subject;
								$message = $getData->message;
							}
							/*End Checking*/
							$approvalRequest = $this->opportunity_model->sendApprovalRequest(array('subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$user->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'PPA','status'=>'0'));
							
							if($approvalRequest>0){
								$send=1;
							}
						}
						if($send>0){
							$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Executed PPA",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);	
							echo json_encode(array('send'=>'1','subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$user->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'PPA','status'=>'0','task_id'=>$approvalRequest));
						} else {
							echo json_encode(array('send'=>'1','subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$user->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'PPA','status'=>'0'));
						}
					} else {
						echo json_encode(array('send'=>'0'));
					}
				} else {
					echo json_encode(array('send'=>'0'));
				}
			} else {
				echo json_encode(array('send'=>'0'));
			}
		} else {
			echo json_encode(array('send'=>'0'));
		}
		die;
	}	
	public function ppaExecuted(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('opportunity_model');
			$this->load->model('lead_model');
			$this->load->model('user_model');
			$findLeadData = $this->opportunity_model->getLeadData($leadID);
			if(count($findLeadData)>0){	
				$dateUpdate = date('Y-m-d H:i:s');
				$updateReport = $this->opportunity_model->updateReport($leadID,array('execute_ppa'=>3));
				$updateReport = $this->lead_model->from_litigation_update($findLeadData->id,array("ppa_execute"=>2,'ppa_date'=>$dateUpdate));
				if($updateReport){
					$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"PPA Executed",'opportunity_id'=>1,'create_date'=>$dateUpdate);
					$this->user_model->addUserHistory($user_history);
					$getLeadData = $this->lead_model->getLeadData($leadID);
					$buttonData = $this->lead_model->findButtonByButtonID($getLeadData->type,"PPA_EXECUTE");
					$this->user_model->addUserHistory(array('user_id'=>$this->session->userdata['id'],'lead_id'=>$leadID,'message'=>'Funds Transfer','create_date'=>date('Y-m-d H:i:s')));	
					echo json_encode(array('send'=>'1','button_data'=>$buttonData,'date_update'=>date('m d,y',strtotime($dateUpdate))));
				} else {
					echo json_encode(array('send'=>'0'));
				}
			} else {
				echo json_encode(array('send'=>'0'));
			}
		} else {
			echo json_encode(array('send'=>'0'));
		}
		die;
	}	
	public function patents_charts_from_lead(){
		$left_chart_patent = $this->input->post('left_chart_patent');
		$leadID = $this->input->post('lead');
		if((int)$leadID>0){
			$this->load->model('acquisition_model');
			$this->load->model('lead_model');
			$this->load->model('opportunity_model');
			if(!empty($left_chart_patent)){				
				$leadData = $this->lead_model->getLeadData($leadID);
				$acquisitionData = $this->acquisition_model->getData($leadID);
				if(count($acquisitionData)>0){
					$chartLeftData = json_decode($left_chart_patent,true);
					if(count($chartLeftData)>0){
						$chartArray = array();
						$this->opportunity_model->deleteLeftChart($leadID);
						for($i=0;$i<count($chartLeftData);$i++){
							if(!empty($chartLeftData[$i]->{'0'})){
								$chartArray[] =array($chartLeftData[$i]->{'0'},$chartLeftData[$i]->{'2'},$chartLeftData[$i]->{'1'});
								$this->opportunity_model->saveChartLeft(array('lead_id'=>$leadID,'country'=>$chartLeftData[$i]->{'0'},'patents'=>$chartLeftData[$i]->{'1'},'applications'=>$chartLeftData[$i]->{'2'}),false);
							} else if(!is_object($chartLeftData[$i]) && isset($chartLeftData[$i]['0']) && !empty($chartLeftData[$i]['0'])){
								$chartArray[] =array($chartLeftData[$i]['0'],$chartLeftData[$i]['2'],$chartLeftData[$i]['1']);
								$this->opportunity_model->saveChartLeft(array('lead_id'=>$leadID,'country'=>$chartLeftData[$i]['0'],'patents'=>$chartLeftData[$i]['1'],'applications'=>$chartLeftData[$i]['2']),false);
							}							
						}
						$chartArray[] = array(null,null,null);
						$left_chart_patent = json_encode($chartArray);
					}
					$curl = curl_init();
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/license_update_left_chart',
						CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
						CURLOPT_POST => 1,
						CURLOPT_POSTFIELDS => array(
							'license_number' => $acquisitionData['acquisition']->store_name,
							'chart_left'=>$left_chart_patent
						)
					));
					// Send the request & save response to $resp
					$resp = curl_exec($curl);	
					if($resp){						
						/*$getData = json_decode($resp);
						$chartLeftData = json_decode($left_chart_patent,true);
						if(count($chartLeftData)>0){
							$this->opportunity_model->deleteLeftChart($leadID);
							for($i=0;$i<count($chartLeftData);$i++){
								if(!empty($chartLeftData[$i]->{'0'})){
									$this->opportunity_model->saveChartLeft(array('lead_id'=>$leadID,'country'=>$chartLeftData[$i]->{'0'},'applications'=>$chartLeftData[$i]->{'1'},'patents'=>$chartLeftData[$i]->{'2'}),false);
								} else if(!is_object($chartLeftData[$i]) && isset($chartLeftData[$i]['0']) && !empty($chartLeftData[$i]['0'])){
									$this->opportunity_model->saveChartLeft(array('lead_id'=>$leadID,'country'=>$chartLeftData[$i]['0'],'applications'=>$chartLeftData[$i]['1'],'patents'=>$chartLeftData[$i]['2']),false);
								}							
							}
						}*/
					}
				}
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'https://synpat.com/license_update_left_chart.php',
					CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'serial_number' => $leadData->serial_number,
						'chart_left'=>$this->input->post('left_chart_patent'),
						'lead_name' =>$leadData->lead_name
					)
				));
				$resp = curl_exec($curl);	
				if($resp){
					/*End API Request*/
					
				}				
			}
		}
		redirect('dashboard/findLeadPrePatent/'.$leadID);
	}
	public function docket_save(){
		if(isset($_POST) && count($_POST)>0){
			$docketData = $this->input->post();
			$other = $docketData['other'];
			$leadID = $docketData['other']['lead_id'];
			$this->load->model('acquisition_model');
			$this->load->model('user_model');
			$this->load->model('general_model');
			$this->load->model('customer_model');
			$this->load->model('lead_model');
			$this->load->model('opportunity_model');
			$acquisitionData = $this->acquisition_model->getData($leadID);
			$activeButton = 0;
			if(isset($docketData['acquisition']['active_button'])){
				$activeButton = $docketData['acquisition']['active_button'];
			}
			if(isset($docketData['embed'])){
				/*Embedding Code*/
				if(!empty($docketData['embed']['order_name']) && (!empty($docketData['embed']['cc_embed_code']) || !empty($docketData['embed']['par_embed_code']))){
					if(count($acquisitionData)>0){
						/*API for APPDMIN*/
						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/license_update_embed_code',
							CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
							CURLOPT_POST => 1,
							CURLOPT_POSTFIELDS => array(
								'license_number' => $acquisitionData['acquisition']->store_name,
								'claimchart'=>$docketData['embed']['cc_embed_code'],
								'prior_art'=>$docketData['embed']['par_embed_code'],
								'active_button'=>$activeButton,
							)
						));
						// Send the request & save response to $resp
						$resp = curl_exec($curl);
						if($resp){
							/*End API Request*/
							$getDataRes = json_decode($resp);
							if(count($getDataRes)>0 && (int)$getDataRes->send>0){
								$saveData = $this->acquisition_model->updateData($leadID,array('cc_embed_code'=>$docketData['embed']['cc_embed_code'],'order_name'=>$docketData['embed']['order_name'],'par_embed_code'=>$docketData['embed']['par_embed_code']));
								$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Insert embed coded.",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
								$this->user_model->addUserHistory($user_history);	
								if($saveData){  
									$this->session->set_flashdata('message','<p class="alert alert-success">Record Saved!</p>');
								} else {
									$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');				
								}
							
							} else {
								$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');	
							
							}								
						} else {
							$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');	
							
						}
					}
				}
			}
			/*End Embedding Code*/
			/*Other Data*/			
			if(count($acquisitionData)>0){
				$other = $docketData['other'];
				$curl = curl_init();
				// Set some options - we are passing in a useragent too here
				/*'damage'=>$other['damage'],
						'syndication_file'=>$other['syndication_file'],*/
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/license_update_other_docs',
					CURLOPT_USERAGENT => 'Send Request for create demo portfolio',   
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'license_number' => $acquisitionData['acquisition']->store_name,
						'syndication_file'=>'',
						'potential_data'=>$other['potential_data'],
						'commitment_data'=>$other['commitment_data'],
						'chart_left'=>$other['chart_left']
					)
				));
				/*CURLOPT_POSTFIELDS => array(
						'license_number' => $acquisitionData['acquisition']->store_name,
						'ppa'=>$other['ppa'],
						'pla'=>$other['pla'],
						'rtp'=>$other['rtp'],
						'ppp'=>$other['ppp'],
						'sla'=>$other['sla'],
						'damage'=>'',
						'syndication_file'=>'',
						'potential_data'=>$other['potential_data'],
						'commitment_data'=>$other['commitment_data'],
						'chart_left'=>$other['chart_left'],
						'chart_middle'=>$other['chart_middle'],
						'chart_right'=>$other['chart_right'],
						'comparable'=>$other['comparable'],
						'damages'=>$other['damages']
					)*/
				// Send the request & save response to $resp
				$resp = curl_exec($curl);	
				
				if($resp){
					/*End API Request*/
					$getData = json_decode($resp);
					
					if(count($getData)>0 && (int)$getData->send>0){
						$activeButton = 0;
						$potential_participants = 0;
						$final_participants = 0;
						if(isset($docketData['acquisition']['active_button'])){
							$activeButton = $docketData['acquisition']['active_button'];
						}
						if(!empty($docketData['acquisition']['final_participants'])){
							$final_participants = $docketData['acquisition']['final_participants'];
						}
						if(!empty($docketData['acquisition']['potential_participants'])){
							$potential_participants = $docketData['acquisition']['potential_participants'];
						}
						$saveData = $this->acquisition_model->updateData($leadID,array('syndication'=>'','damage'=>'','category'=>$docketData['acquisition']['category'],'active_button'=>$activeButton,'potential_participants'=>$potential_participants,'final_participants'=>$final_participants,'regular_license_starts'=>$docketData['acquisition']['regular_license_starts'],'late_license_starts'=>$docketData['acquisition']['late_license_starts'],'store'=>$docketData['acquisition']['store'],'cost_price'=>$docketData['acquisition']['cost_price']));
						/*Link update in invitation template*/
						if((int)$docketData['acquisition']['category']>0){
							$getTemplate = $this->general_model->findInvitationTemplateByLead($leadID);
							if(count($getTemplate)>0){
								$template = $getTemplate->template_html;					
								$urlName ="";
								$category_list = $this->customer_model->categoryList(0);
								$lead_data = $this->lead_model->getLeadData($leadID);
								if(!empty($acquisitionData['acquisition']->store_name)):				
								if($acquisitionData['acquisition']->category>0){
									if(count($category_list)>0){
										for($cc=0;$cc<count($category_list);$cc++){
											if($category_list[$cc]->id==$acquisitionData['acquisition']->category){
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
										$urlName ='/departments/'.$urlName.'-'.$acquisitionData['acquisition']->category.'/'.$lead_data->serial_number.'/';
									}
								}
								endif;
								if(!empty($urlName)){
									$urlName = "http://www.synpat.com".$urlName;
								}
								$template =  str_replace('link-data-href=""',"href='".$urlName."'",$template);
								$getTemplate->template_html = $template;
								$getTemplate = (array)$getTemplate;
								$this->general_model->updateTemplate($getTemplate,$getTemplate['id']);
							}
						}
						/*End link update in invitation*/
						/*Insert Data Potential*/
						$potentialSyndicateData = json_decode($other['potential_data']);
						if(count($potentialSyndicateData)>0){
							$this->opportunity_model->deletePotential($leadID);
							for($i=0;$i<count($potentialSyndicateData);$i++){
								if(!empty($potentialSyndicateData[$i]->{'0'})){
									$this->opportunity_model->savePotential(array('lead_id'=>$leadID,'participate'=>$potentialSyndicateData[$i]->{'0'},'fees'=>$potentialSyndicateData[$i]->{'1'}),false);
								} else if(!is_object($potentialSyndicateData[$i]) && isset($potentialSyndicateData[$i]['0']) && !empty($potentialSyndicateData[$i]['0'])){
									$this->opportunity_model->savePotential(array('lead_id'=>$leadID,'participate'=>$potentialSyndicateData[$i]['0'],'fees'=>$potentialSyndicateData[$i]['1']),false);
								}							
							}
						}
						/*chart Left*/
						$chartLeftData = json_decode($other['chart_left']);
						$chartData = json_encode(array(array(null,null,null)));
						if(count($chartLeftData)>0){
							$chartArray = array();
							$this->opportunity_model->deleteLeftChart($leadID);
							for($i=0;$i<count($chartLeftData);$i++){
								if(!empty($chartLeftData[$i]->{'0'})){
									$chartArray[] = array($chartLeftData[$i]->{'0'},$chartLeftData[$i]->{'2'},$chartLeftData[$i]->{'1'});
									$this->opportunity_model->saveChartLeft(array('lead_id'=>$leadID,'country'=>$chartLeftData[$i]->{'0'},'applications'=>$chartLeftData[$i]->{'1'},'patents'=>$chartLeftData[$i]->{'2'}),false);
								} else if(!is_object($chartLeftData[$i]) && isset($chartLeftData[$i]['0']) && !empty($chartLeftData[$i]['0'])){
									$this->opportunity_model->saveChartLeft(array('lead_id'=>$leadID,'country'=>$chartLeftData[$i]['0'],'applications'=>$chartLeftData[$i]['1'],'patents'=>$chartLeftData[$i]['2']),false);
									$chartArray[] = array($chartLeftData[$i]['0'],$chartLeftData[$i]['2'],$chartLeftData[$i]['1']);
								}							
							}
							$chartData = json_encode($chartArray);
						}
						$leadData = $this->lead_model->getLeadData($leadID);
						
						$curl = curl_init();
						curl_setopt_array($curl, array(
							CURLOPT_RETURNTRANSFER => 1,
							CURLOPT_URL => 'https://synpat.com/license_update_left_chart.php',
							CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
							CURLOPT_POST => 1,
							CURLOPT_POSTFIELDS => array(
								'serial_number' => $leadData->serial_number,
								'chart_left'=>$chartData,
								'lead_name' =>$leadData->lead_name
							)
						));
						$resp = curl_exec($curl);	
						
						if($resp){
							/*End API Request*/
							
						}
						
						
						
						/*Chart Middle*/					
						/*$chartMiddleData = json_decode($other['chart_middle']);
						if(count($chartMiddleData)>0){
							$this->opportunity_model->deleteMiddleChart($leadID);
							for($i=0;$i<count($chartMiddleData);$i++){
								if(!empty($chartMiddleData[$i]->{'0'})){
									$this->opportunity_model->saveChartMiddle(array('lead_id'=>$leadID,'technologies'=>$chartMiddleData[$i]->{'0'},'data'=>$chartMiddleData[$i]->{'1'}),false);
								} else if(!is_object($chartMiddleData[$i]) && isset($chartMiddleData[$i]['0']) && !empty($chartMiddleData[$i]['0'])){
									$this->opportunity_model->saveChartMiddle(array('lead_id'=>$leadID,'technologies'=>$chartMiddleData[$i]['0'],'data'=>$chartMiddleData[$i]['1']),false);
								}							
							}
						}
						
						$chartRightData = json_decode($other['chart_right']);
						if(count($chartRightData)>0){
							$this->opportunity_model->deleteRightChart($leadID);
							for($i=0;$i<count($chartRightData);$i++){
								if(!empty($chartRightData[$i]->{'0'})){
									$this->opportunity_model->saveChartRight(array('lead_id'=>$leadID,'Year'=>$chartRightData[$i]->{'0'},'data'=>$chartRightData[$i]->{'1'}),false);
								} else if(!is_object($chartRightData[$i]) && isset($chartRightData[$i]['0']) && !empty($chartRightData[$i]['0'])){
									$this->opportunity_model->saveChartRight(array('lead_id'=>$leadID,'Year'=>$chartRightData[$i]['0'],'data'=>$chartRightData[$i]['1']),false);
								}							
							}
						}*/
						
						/*$chartComparableData = json_decode($other['comparable']);
						if(count($chartComparableData)>0){
							$this->opportunity_model->deleteComparable($leadID);
							for($i=0;$i<count($chartComparableData);$i++){
								if(!empty($chartComparableData[$i]->{'0'})){
									$this->opportunity_model->saveComparable(array('lead_id'=>$leadID,'file_name'=>$chartComparableData[$i]->{'0'},'file_link'=>$chartComparableData[$i]->{'1'}));
								} else if(!is_object($chartComparableData[$i]) && isset($chartComparableData[$i]['0']) && !empty($chartComparableData[$i]['0'])){
									$this->opportunity_model->saveComparable(array('lead_id'=>$leadID,'file_name'=>$chartComparableData[$i]['0'],'file_link'=>$chartComparableData[$i]['1']));
								}							
							}
						}*/
						if(isset($other['damages'])){
							$damagesData = $other['damages'];
						}
						if(!empty($damagesData)){
							$this->opportunity_model->deleteDamages($leadID);
							$this->opportunity_model->saveDamage(array('lead_id'=>$leadID,'file_name'=>'Royalty Study','file_link'=>$damagesData));
						}
						$userID = $this->session->userdata['id'];
						if(isset($other['id'])){
							$approvalRequest = $this->opportunity_model->updateApprovalData($acquisitionData['acquisition']->id,array('status'=>'1'));
						}									
						$updateReport = $this->opportunity_model->updateReport($leadID,array('other_doc'=>2));
						$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Other docs uploaded",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);	
						$this->session->set_flashdata('message','<p class="alert alert-success">Record Saved!</p>');
					}								
				}
			}
			$imageLeft = "";
			$imageMiddle = "";
			$imageRight = "";
			$imageFour ="";
			$imageFive ="";
			$imageSix ="";
			$imageSeven ="";
			$imageEight ="";
			$imageNine ="";
			$imageTen ="";
			$imageEleven ="";
			$imageTwelve ="";
			/*if(isset($docketData['other']['image_left'])){
				$imageLeft = $this->config->base_url().'public/upload/'.$docketData['other']['image_left'];
			}
			if(isset($docketData['other']['image_middle'])){
				$imageMiddle = $this->config->base_url().'public/upload/'.$docketData['other']['image_middle'];
			}
			if(isset($docketData['other']['image_right'])){
				$imageRight = $this->config->base_url().'public/upload/'.$docketData['other']['image_right'];
			}
			if(isset($docketData['other']['image_four'])){
				$imageFour = $this->config->base_url().'public/upload/'.$docketData['other']['image_four'];
			}
			if(isset($docketData['other']['image_five'])){
				$imageFive = $this->config->base_url().'public/upload/'.$docketData['other']['image_five'];
			}
			if(isset($docketData['other']['image_six'])){
				$imageSix = $this->config->base_url().'public/upload/'.$docketData['other']['image_six'];
			}
			if(isset($docketData['other']['image_seven'])){
				$imageSeven = $this->config->base_url().'public/upload/'.$docketData['other']['image_seven'];
			}
			if(isset($docketData['other']['image_eight'])){
				$imageEight = $this->config->base_url().'public/upload/'.$docketData['other']['image_eight'];
			}
			if(isset($docketData['other']['image_nine'])){
				$imageNine = $this->config->base_url().'public/upload/'.$docketData['other']['image_nine'];
			}
			if(isset($docketData['other']['image_ten'])){
				$imageTen = $this->config->base_url().'public/upload/'.$docketData['other']['image_ten'];
			}
			if(isset($docketData['other']['image_eleven'])){
				$imageEleven = $this->config->base_url().'public/upload/'.$docketData['other']['image_eleven'];
			}
			if(isset($docketData['other']['image_twelve'])){
				$imageTwelve = $this->config->base_url().'public/upload/'.$docketData['other']['image_twelve'];
			}	*/	
			if(isset($docketData['other']['image_left'])){
				$imageLeft = $docketData['other']['image_left'];
			}
			if(isset($docketData['other']['image_middle'])){
				$imageMiddle = $docketData['other']['image_middle'];
			}
			if(isset($docketData['other']['image_right'])){
				$imageRight = $docketData['other']['image_right'];
			}
			if(isset($docketData['other']['image_four'])){
				$imageFour = $docketData['other']['image_four'];
			}
			if(isset($docketData['other']['image_five'])){
				$imageFive = $docketData['other']['image_five'];
			}
			if(isset($docketData['other']['image_six'])){
				$imageSix = $docketData['other']['image_six'];
			}
			if(isset($docketData['other']['image_seven'])){
				$imageSeven = $docketData['other']['image_seven'];
			}
			if(isset($docketData['other']['image_eight'])){
				$imageEight = $docketData['other']['image_eight'];
			}
			if(isset($docketData['other']['image_nine'])){
				$imageNine = $docketData['other']['image_nine'];
			}
			if(isset($docketData['other']['image_ten'])){
				$imageTen = $docketData['other']['image_ten'];
			}
			if(isset($docketData['other']['image_eleven'])){
				$imageEleven = $docketData['other']['image_eleven'];
			}
			if(isset($docketData['other']['image_twelve'])){
				$imageTwelve = $docketData['other']['image_twelve'];
			}
			$do['docket']['image_left'] = $imageLeft;
			$do['docket']['image_middle'] = $imageMiddle;
			$do['docket']['image_right'] = $imageRight;
			$do['docket']['image_four'] = $imageFour;
			$do['docket']['image_five'] = $imageFive;
			$do['docket']['image_six'] = $imageSix;
			$do['docket']['image_seven'] = $imageSeven;
			$do['docket']['image_eight'] = $imageEight;
			$do['docket']['image_nine'] = $imageNine;
			$do['docket']['image_ten'] = $imageTen;
			$do['docket']['image_eleven'] = $imageEleven;
			$do['docket']['image_twelve'] = $imageTwelve;
			$do['docket']['option_expiration_data'] = $docketData['docket']['option_expiration_data'];
			$findLeadData = $this->opportunity_model->getLeadData($leadID);
			if(count($findLeadData)>0){
				$do['docket']['seller_asking_price'] = $findLeadData->expected_price;
				if(count($acquisitionData)>0){
					
					/*API for APPDMIN*/
					$curl = curl_init();
					// Set some options - we are passing in a useragent too here
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/update_docket_data', 
						CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
						CURLOPT_POST => 1, 
						CURLOPT_POSTFIELDS => array(
							'license_number' => $acquisitionData['acquisition']->store_name,
							'image_left'=>$imageLeft,
							'image_middle'=>$imageMiddle,
							'image_right'=>$imageRight,
							'image_four'=>$imageFour,
							'image_five'=>$imageFive,
							'image_six'=>$imageSix,
							'image_seven'=>$imageSeven,
							'image_eight'=>$imageEight,
							'image_nine'=>$imageNine,
							'image_ten'=>$imageTen,
							'image_eleven'=>$imageEleven,
							'image_twelve'=>$imageTwelve,
							'expiration_date'=>$do['docket']['option_expiration_data'],
							'asking_price'=>$do['docket']['seller_asking_price'],
							'person_name'=>$docketData['docket']['person_name'],
							'person_email'=>$docketData['docket']['person_email'],
							'person_phone'=>$docketData['docket']['person_phone'],
							'person_picture'=>$docketData['docket']['person_picture'],
						)
					));
					// Send the request & save response to $resp
					$resp = curl_exec($curl);
					
					if($resp){
						$getData = json_decode($resp);						
						if(count($getData)>0 && (int)$getData->send>0){
							$saveData = $this->acquisition_model->updateData($leadID,$do['docket']);
							if($saveData){
								$this->lead_model->from_litigation_update($leadID,array("option_expiration_date"=>$do['docket']['option_expiration_data']));
								$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Upload example images.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
								$this->user_model->addUserHistory($user_history);	
								$this->session->set_flashdata('message','<p class="alert alert-success">Record Saved!</p>');
							}							
						}
					}
					/*END API*/
				}
			} else {
				$this->session->set_flashdata('message','<p class="alert alert-warning">Invalid Lead</p>');				
			}			
			
			/*End Image Files*/			
			/*redirect('opportunity/docket/'.$leadID);*/
			die;
		} else {
			echo "Invalid Request";
			die;
		}
	}
	public function startDD(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('acquisition_model');
			$this->load->model('opportunity_model');
			$findLeadData = $this->opportunity_model->getLeadData($leadID);
			if(count($findLeadData)>0){
				$acquisitionData = $this->acquisition_model->getData($leadID);
				if(count($acquisitionData)>0){					
					$patentData = $this->opportunity_model->getAllAssets($leadID);
					/*$patentData = json_decode($findLeadData->patent_data);*/
										
				/*API for APPDMIN*/
				$curl = curl_init();
				// Set some options - we are passing in a useragent too here
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/add_due_diligence_patent',
					CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'license_number' => $acquisitionData['acquisition']->store_name,
						'patent_data'=>json_encode($patentData)
					)
				));
				// Send the request & save response to $resp
				$resp = curl_exec($curl);
				if($resp){
				
				
				}
				$this->load->model('user_model');
				$this->load->model('notification_model');
				$this->load->model('general_model');
				/*END API*/
				$cipoUsers = $this->user_model->findUserByType('8');		
				if(count($cipoUsers)>0){
					$acquisitionData = $this->acquisition_model->getData($leadID);
					if(count($acquisitionData)>0){
						$url = "http://www.synpat.com/store/".$acquisitionData['acquisition']->store_name."/due_diligence.php";
						$sendID = $this->notification_model->insert(array('user_id'=>$cipoUsers->id,'message'=>'Start DD <a href="'.$url.'" target="_BLANK">'.$url.'</a>'));
						$updateReport = $this->opportunity_model->updateReport($leadID,array('start_dd'=>1));
						/*Check DB Message and Subject*/
						$getData = $this->general_model->getTaskAccToType('DD');
						$subject="Start DD";
						$message = "Start DD.";
						if(count($getData)>0){
							$subject = $getData->subject;
							$message = $getData->message;
						}
						/*End Checking*/						
						$approvalRequest = $this->opportunity_model->sendApprovalRequest(array('subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$cipoUsers->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'DD','status'=>'0'));
						if($approvalRequest>0){
							$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Send request to CIPO to start work on DD",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);	
							echo json_encode(array('send'=>'1','subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$cipoUsers->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'DD','status'=>'0','task_id'=>$approvalRequest,'create_date'=>date('Y-m-d H:i:s')));
						} else {
							echo json_encode(array('send'=>'0'));
						}
					} else {
						echo json_encode(array('send'=>'0'));
					}
				} else {
					echo json_encode(array('send'=>'0'));
				}
			}
			} else {
				echo json_encode(array('send'=>'0'));
			}
		} else {
			echo json_encode(array('send'=>'0'));
		}
		die;		
	}	
	public function updateAllInvitees($lead_id){
		$this->load->model('acquisition_model');
		$this->load->model('lead_model');
		$acquisitionData = $this->acquisition_model->getData($lead_id);
		$getAllContact = $this->lead_model->findSalesActivityCompanies($lead_id);		
		if(count($acquisitionData)>0){
			$curl = curl_init();
			// Set some options - we are passing in a useragent too here
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/add_invitees',
				CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					'license_number' => $acquisitionData['acquisition']->store_name,
					'invitees'=>json_encode($getAllContact)
				)
			));			
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			echo "<pre>";
			print_r($resp);
			die;
			if($resp){		
			}							
		}
	}
	public function invitees(){
		if(isset($_POST) && count($_POST)>0){
			$getData = $this->input->post();
			if(isset($getData['invite']['lead_id']) && (int) $getData['invite']['lead_id']>0){
				if(count($getData['invite']['contact_id'])>0){
					/*$saveData = 0;
					$deleteOldData = $this->opportunity_model->deleteInvitees($getData['invite']['lead_id']);
					$contactsUpdate = array();
					$getAllContact = array();
					if(!isset($_SESSION)){
						session_start();
					}
					$contacts = $_SESSION['all_contacts'];
					foreach($getData['invite']['contact_id'] as $contactID){
						$saveData = $this->opportunity_model->insertInvitees(array('lead_id'=>$getData['invite']['lead_id'],'contact_id'=>$contactID));
						if(count($contacts)>0){
							foreach($contacts as $contact){
								if($contact->id==$contactID){
									$getAllContact[] = $contact;
								}
							}
						}						
					}*/
					/*$getAllContact = $this->opportunity_model->findInvitees(implode(",",$getData['invite']['contact_id']));*/
					if($saveData>0){
						/*Send Invitees*/
						$this->load->model('acquisition_model');
						$acquisitionData = $this->acquisition_model->getData($getData['invite']['lead_id']);
						if(count($acquisitionData)>0){
							$curl = curl_init();
							// Set some options - we are passing in a useragent too here
							curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/add_invitees',
								CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
								CURLOPT_POST => 1,
								CURLOPT_POSTFIELDS => array(
									'license_number' => $acquisitionData['acquisition']->store_name,
									'invitees'=>json_encode($getAllContact)
								)
							));
							// Send the request & save response to $resp
							$resp = curl_exec($curl);
							if($resp){		
							}							
						}
						/*End Invitees*/
						$this->load->model('user_model');
						$user_history = array('lead_id'=>$getData['invite']['lead_id'],'user_id'=>$this->session->userdata['id'],'message'=>"Added list of invitees",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);	
						$this->session->set_flashdata('message','<p class="alert alert-success">Record Saved!</p>');
						redirect('opportunity/docket/'.$getData['invite']['lead_id']);
					}else{
						$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');
						redirect('opportunity/docket/'.$getData['invite']['lead_id']);
					}
				} else {
					$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');
					redirect('opportunity/docket/'.$getData['invite']['lead_id']);
				}				
			} else {
				$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');
				redirect('dashboard');
			}
		} else {
			$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');
			redirect('dashboard');
		}		
	}	
	public function addCompanyBulk(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$getData = $this->input->post();
			$listCompany =  explode(PHP_EOL,$getData['company']['list']);
			$this->load->model('customer_model');
			if(count($listCompany)>0){
				foreach($listCompany as $company){
					$getCompanyId = $this->customer_model->insertCompany(array('company_name'=>$company));
					if($getCompanyId>0){
						$this->customer_model->addCompanySector(array("sector_id"=>0,"company_id"=>$getCompanyId));
						$data = 1;
					}
				}
				
			}
		}
		echo $data;
		die;
	}	
	public function get_list_technologies(){
		$query = $this->input->get('query');
		$this->load->model('client_model');
		$getList = $this->client_model->get_list_technologies(0);
		echo json_encode($getList);
		die;
	}
	public function search_company_by_name(){
		$query = $this->input->get('query');
		$this->load->model('customer_model');
		$getList = $this->customer_model->findCompanyBySearch($query,"distinct(c.id),c.id,c.company_name,s.name as sectorName, s.id as sectorID");
		$companyList = array();
		if(count($getList)>0){
			foreach($getList as $company){
				array_push($companyList,array('Name'=>$company->company_name,'UID'=>$company->id,'SectorID'=>$company->sectorID,'SectorName'=>$company->sectorName));
			}
		}
		echo json_encode($companyList);
		die;
	}
	public function search_contact_by_name(){
		$query = $this->input->get('query');
		$this->load->model('client_model');
		$getList = $this->client_model->find_contact_by_name_list($query);
		$this->findContactList($getList);
	}
	public function search_contact_by_title(){
		$query = $this->input->get('query');
		$this->load->model('client_model');
		$getList = $this->client_model->find_contact_by_jobtitle_list($query);
		$this->findContactList($getList);
	}

	public function findContactList($getList){
		$contactList = array();
		if(count($getList)>0){
			foreach($getList as $contact){
				array_push($contactList,array('Name'=>$contact->name,'UID'=>$contact->id));
			}
		}
		echo json_encode($contactList);
		die;
	}

	public function find_c_cc(){
		$companyID = $this->input->get('query');
		if((int)$companyID>0){
			$data = array();
			$this->load->model('opportunity_model');
			$data = $this->opportunity_model->getAllContactBelongToCompany((int)$companyID);
			echo json_encode($data);
		}
		die;
	}
	
	public function add_contact($contactID=0){
		$data = array();
		$opened = 0;
		if(isset($_POST) && count($_POST)>0){
			$getData = $this->input->post();
			$newID = $this->insertContact($getData);
			if($newID>0){
				echo json_encode(array("success"=>$newID,'opened'=>1));
			} else {
				echo json_encode(array("error"=>1,"error_message"=>"Please try after sometime"));
			}
			die;
			/*if($contactID==0){
				$contactID = $newID;
				$opened=1;
			}*/
		}
		$data['open'] = $opened;
		$data['contactID'] = $contactID;
		if($contactID>0){
			$this->load->model('client_model');
			$data['contact'] = $this->client_model->find_contact($contactID);
		} else {
			$data['contact'] = array();
		}
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Backyard Add Contact';
		$this->layout->render('opportunity/add_contact',$data);
	}	
	public function add_company($companyID=0){
		if(isset($_POST) && count($_POST)>0){
			$getData = $this->input->post();			
			$message = "";
			if(isset($getData['company'])){
				unset($getData['company']['street']);
				unset($getData['company']['zip']);
				$contractor = 0;
				if(!isset($getData['company']['contractor'])){
					$getData['company']['contractor'] = $contractor;
				}			
				$sectorId = array();
				if(isset($getData['company']['sector'])){
					$sectorId = $getData['company']['sector'];
					unset($getData['company']['sector']);
				}				
				if($getData['company']['no_of_employees']!=""){
					$getData['company']['no_of_employees'] = filter_var($getData['company']['no_of_employees'], FILTER_SANITIZE_NUMBER_INT);
				}				
				$this->load->model('customer_model');				
				if((int)$getData['company']['id']==0){
					unset($getData['company']['id']);					
					$check = $this->customer_model->checkCompanyExist(trim($getData['company']['company_name']));
					if($check==0){
						$getCompanyId = $this->customer_model->insertCompany($getData['company']);
						if($getCompanyId>0){
							$message = "Insert new company.";
							$getData['company']['id'] = $getCompanyId;
							$companyID = $getCompanyId;
							/*$this->customer_model->addCompanySector(array("sector_id"=>$sectorId,"company_id"=>$getCompanyId));*/
							if(count($sectorId)>0){
								$addCompanySectorInBatch = array();
								foreach($sectorId as $sec){
									$addCompanySectorInBatch[] = array("sector_id"=>$sec,"company_id"=>$getCompanyId);
									/*$this->customer_model->addCompanySector(array("sector_id"=>$sec,"company_id"=>$getCompanyDetail->id));	*/
								}
								if(count($addCompanySectorInBatch)>0){
									$this->customer_model->addCompanySectorInBatch($addCompanySectorInBatch);
								}
							}
						} 
					}else {
						$getCompanyDetail = $this->customer_model->getCompanyData(trim($getData['company']['company_name']));
						if(count($getCompanyDetail)>0){
							$this->customer_model->updateCompanyData($getCompanyDetail->id,$getData['company']);
							$message = "Update company data.";
							if(count($sectorId)>0){
								$this->customer_model->deleteCompanySector($getCompanyDetail->id);
								$addCompanySectorInBatch = array();
								/*$this->customer_model->addCompanySector(array("sector_id"=>$sectorId,"company_id"=>$getCompanyDetail->id));	*/		
								foreach($sectorId as $sec){
									/*$this->customer_model->addCompanySector(array("sector_id"=>$sec,"company_id"=>$getCompanyDetail->id));	*/
									$addCompanySectorInBatch[] = array("sector_id"=>$sec,"company_id"=>$getCompanyDetail->id);
								}
								if(count($addCompanySectorInBatch)>0){
									$this->customer_model->addCompanySectorInBatch($addCompanySectorInBatch);
								}
							}
							$getData['company']['id'] = $getCompanyDetail->id;
							$companyID = $getCompanyDetail->id;
						}
					}
				} else {
					$getCompanyDetail = $this->customer_model->getCompanyDataByID((int)$getData['company']['id']);
					if($companyID==0 && $getData['company']['id']>0){
						$companyID=$getData['company']['id'];
					}
					unset($getData['company']['id']);
					if(count($getCompanyDetail)>0){
						$this->customer_model->updateCompanyData($getCompanyDetail->id,$getData['company']);
						$message = "Update company data.";
						if(count($sectorId)>0){
							$this->customer_model->deleteCompanySector($getCompanyDetail->id);
							$addCompanySectorInBatch = array();
							foreach($sectorId as $sec){
								/*$this->customer_model->addCompanySector(array("sector_id"=>$sec,"company_id"=>$getCompanyDetail->id));	*/
								$addCompanySectorInBatch[] = array("sector_id"=>$sec,"company_id"=>$getCompanyDetail->id);
							}
							if(count($addCompanySectorInBatch)>0){
								$this->customer_model->addCompanySectorInBatch($addCompanySectorInBatch);
							}	
						}
						$getData['company']['id'] = $getCompanyDetail->id;
					}
				}				
				if((int)$getData['company']['id']>0){
					/*Delete Preferences*/
					$this->customer_model->deleteCustomerPreference($getData['company']['id']);
					if(isset($getData['preferences']) && isset($getData['preferences']['departments']) && is_array($getData['preferences']['departments']) && count($getData['preferences']['departments'])>0){
						foreach($getData['preferences']['departments'] as $dept){
							$this->customer_model->insertCustomerPreference(array("customer_id"=>$getData['company']['id'],"preference_id"=>$dept));
						}							
					}
					if(isset($getData['sub']) && isset($getData['sub']['departments']) && is_array($getData['sub']['departments']) && count($getData['sub']['departments'])>0){
						foreach($getData['sub']['departments'] as $dept){
							$this->customer_model->insertCustomerPreference(array("customer_id"=>$getData['company']['id'],"preference_id"=>$dept,'category_type'=>1));
						}							
					}
					$this->load->model('opportunity_model');
					/*Technology*/
					$this->opportunity_model->deleteCustomerTechnologyPreference($getData['company']['id'],0);
					if(isset($getData['preferences']) && isset($getData['preferences']['technology']) && is_array($getData['preferences']['technology']) && count($getData['preferences']['technology'])>0){
						foreach($getData['preferences']['technology'] as $tech){
							$this->opportunity_model->insertCustomerTechnologyPreference(array("company_id"=>$getData['company']['id'],"preference_id"=>$tech,"type"=>0));
						}
					}
					/*Sub Technology*/
					$this->opportunity_model->deleteCustomerTechnologyPreference($getData['company']['id'],1);
					if(isset($getData['preferences']) && isset($getData['preferences']['subtechnology']) && is_array($getData['preferences']['subtechnology']) && count($getData['preferences']['subtechnology'])>0){
						foreach($getData['preferences']['subtechnology'] as $tech){
							$this->opportunity_model->insertCustomerTechnologyPreference(array("company_id"=>$getData['company']['id'],"preference_id"=>$tech,"type"=>1));
						}
					}
					/*SubSub Technology*/
					$this->opportunity_model->deleteCustomerTechnologyPreference($getData['company']['id'],2);
					if(isset($getData['sub']) && isset($getData['sub']['technology']) && is_array($getData['sub']['technology']) && count($getData['sub']['technology'])>0){
						foreach($getData['sub']['technology'] as $tech){
							$this->opportunity_model->insertCustomerTechnologyPreference(array("company_id"=>$getData['company']['id'],"preference_id"=>$tech,"type"=>2));
						}
					}					
				}
				if((int)$getData['company']['id']>0){					
					if(isset($this->session->userdata['id'])){
						$this->load->model('user_model');
						$user_history = array('lead_id'=>0,'user_id'=>$this->session->userdata['id'],'message'=>$message,'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);	
					}					
					$this->session->set_flashdata('message','<p class="alert alert-success">Record Saved!</p>');
					$data = (int)$getData['company']['id'] ;
				}				
			}
			if($companyID>0){
				echo json_encode(array("success"=>$companyID));
			} else {
				echo json_encode(array("error"=>1,"error_message"=>"Please try after sometime"));
			}
			die;
		}
		$data = array();
		$data['companyID'] = $companyID;
		if($companyID>0){
			$this->load->model('customer_model');
			$data['company'] = $this->customer_model->getCompanyDataByID($companyID);
		} else {
			$data['company'] = array();
		}
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Backyard Add Company';
		$this->layout->render('opportunity/add_company',$data);
		/*echo $data; 
		die;*/
	}	
	public function get_company_list_from_invitees_contacts(){
		$this->load->model('opportunity_model');
		$getDataListing = $this->opportunity_model->get_company_list_from_invitees_contacts("DISTINCT(co.company_id)");
		echo json_encode($getDataListing);
		die;
	}	

	public function check_contact_linkedin_url(){
		$data = array('id'=>0);
		if(isset($_POST) && isset($_POST['linkedin_url']) && $_POST['linkedin_url']!=''){
			$this->load->model('client_model');	
			$data = $this->client_model->find_contact_by_linkedin($_POST['linkedin_url']);
		}
		echo json_encode($data);
		die;
	}

	public function check_company_linkedin_url(){
		$data = array('id'=>0);
		if(isset($_POST) && isset($_POST['linkedin_url']) && $_POST['linkedin_url']!=''){
			$this->load->model('client_model');	
			$data = $this->client_model->find_company_by_linkedin($_POST['linkedin_url']);
		}
		echo json_encode($data);
		die;
	}

	public function insertContact($getData){
		$data = 0;
		$message = "";
		if(isset($getData['invitee']) && count($getData['invitee'])>0){
			$recordID = 0;
			$this->load->model('lead_model');	
			$this->load->model('customer_model');	
			$this->load->model('opportunity_model');	
			$this->load->model('client_model');					
			if((int)$getData['invitee']['id']==0){
				if($getData['invitee']['company_id']==""){
					if(!empty($getData['invitee']['company_name'])){
						/*checkCompany First*/
						$checkCompany = $this->customer_model->getCompanyData($getData['invitee']['company_name']);
						if(count($checkCompany)==0){
							$companyID = $this->customer_model->insertCompany(array('company_name'=>$getData['invitee']['company_name'],'start_date'=>'0000-00-00 00:00:00','end_date'=>'0000-00-00 00:00:00'));
							/*find company from pre contacts and delete*/
							if($companyID>0){
								$preCompanyContact =  $this->lead_model->getPreCompanyName($getData['invitee']['company_name'],"id,linkedin_url,linkedin_name");								
								$this->lead_model->findCompanyInPreContactAndDelete($getData['invitee']['company_name']);
								/*Update Listing to Pre to Main*/
								if(count($preCompanyContact)>0){
									/*UpdateCompany Linkedin URL*/
									if(trim($preCompanyContact->linkedin_url)!="" || trim($preCompanyContact->linkedin_name)!="" ){
										$this->customer_model->updateCompanyData($companyID,array('linkedin_url'=>trim($preCompanyContact->linkedin_url),'linkedin_name'=>trim($preCompanyContact->linkedin_name)));
									}
									$getDataListing = $this->opportunity_model->checkCOmpanyINListing($preCompanyContact->id,"pre-company");
									if(count($getDataListing)>0){
										$this->opportunity_model->updateListingContact(array('company_id'=>$companyID,'type'=>'company'),$getDataListing->id);
									}
								}
								
							}
						} else {
							$companyID = $checkCompany->id;
						}						
					}
					$getData['invitee']['company_id'] = $companyID;
				}
				if(isset($getData['invitee']['company_name'])){
					unset($getData['invitee']['company_name']);
				}
				$saveData = $this->client_model->insert($getData['invitee']);
				$recordID = $saveData;
				$message = "New record in contacts";
			} else {
				if(isset($getData['invitee']['company_name'])){
					unset($getData['invitee']['company_name']);
				}
				$recordID = $getData['invitee']['id'];
				unset($getData['invitee']['id']);
				if(!isset($getData['invitee']['gateway'])){
					$getData['invitee']['gateway'] = 0;
				}
				if(!isset($getData['invitee']['no_contact'])){
					$getData['invitee']['no_contact'] = 0;
				}
				if(isset($getData['invitee']['note']) && $getData['invitee']['note']==""){
					unset($getData['invitee']['note']);
				}
				$saveData = $this->client_model->update($recordID,$getData['invitee']);	
				$saveData =$recordID;
				$message = "Update contacts";					
			}				
			if($saveData>0){			
				$this->load->model('user_model');
				if(isset($this->session->userdata['id'])){
					$user_history = array('lead_id'=>0,'user_id'=>$this->session->userdata['id'],'message'=>$message,'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);	
					$this->session->set_flashdata('message','<p class="alert alert-success">Record Saved!</p>');
				}
				
				$data = $recordID ;
			}
		}
		return $data;
	}
	
	public function addContactByDriveFile(){
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();
		$service = new SpreadsheetServiceHelper();
		$ss_id = "1AT4p8evjyZNzlaUuto20HXr9S6SR4Yse-0OaQp5sfn8";
		$spreadsheet = $service->getSpreadsheetById($ss_id);
		$allWorkSheet = $service->getAllWorkSheets();
		$sheetName = "PreContacts (1).csv";
		if(!empty($sheetName)){
			$listFeed = $service->getWorkSheetByName($sheetName);
			$asset_data =$service->getAllRows($listFeed->getEntries());
		}
		$arrayNotFind = array();
		$arrayFind = array();
		/*for($i=0;$i<count($asset_data);$i++){*/
		$this->load->model('customer_model');	
		for($i=5003;$i<count($asset_data);$i++){
			$rowData = $asset_data[$i];
			$companyName = $rowData['company'];
			$tobedeleted = $rowData['tobedeleted'];
			
			if($tobedeleted=="No"){
				if(!empty(trim($companyName))){
					/*checkCompany First*/
					$checkCompany = $this->customer_model->getCompanyData(trim($companyName));
					if(count($checkCompany)==0){
						if(!in_array(trim($companyName),$arrayNotFind)){
							$arrayNotFind[] = trim($companyName);
						}
						
						echo $tobedeleted."Not Found<br/>";
						echo "Company Name:".trim($companyName)."<br/>";
						$checkCompany = $this->customer_model->findCompanyByName(trim($companyName));
						echo "<pre>";
						print_r($checkCompany);
					} else {
						echo $tobedeleted."Found<br/>";
						echo "<pre>";
						print_r($checkCompany);
						if(!in_array(trim($companyName),$arrayFind)){
							$arrayFind[] = trim($companyName);
						}
						
						//$companyID = $checkCompany->id;
					}						
				}
			}			
		}
		echo "<pre>";
		/*print_r($asset_data);*/
		echo "Not Found<br/>";
		print_r($arrayNotFind);
		echo "Found<br/>";
		print_r($arrayFind);
		die;
	}

	public function addRefinedContacts(){
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();
		$service = new SpreadsheetServiceHelper();
		$ss_id = "1AT4p8evjyZNzlaUuto20HXr9S6SR4Yse-0OaQp5sfn8";
		$spreadsheet = $service->getSpreadsheetById($ss_id);
		$allWorkSheet = $service->getAllWorkSheets();
		$sheetName = "PreContacts (1).csv";
		if(!empty($sheetName)){
			$listFeed = $service->getWorkSheetByName($sheetName);
			$asset_data =$service->getAllRows($listFeed->getEntries());
		}	
		$this->load->model('lead_model');	
		$this->load->model('client_model');	
		$s = 0;
		for($i=5003;$i<count($asset_data);$i++){
			$companyID = 0;
			$rowData = $asset_data[$i];			
			$companyName = $rowData['company'];
			$tobedeleted = $rowData['tobedeleted'];
			if($tobedeleted=="No"){
				echo "SP:".$s."IP.".$i.":preID:".$rowData['id']."<br/>";
				if(!empty(trim($companyName))){
					$getFromPreContact = $this->lead_model->getPreContactById($rowData['id']);
					if(count($getFromPreContact)>0){
						$getDataFromPreContact = array(
											'first_name'=>$getFromPreContact->first_name,
											'last_name'=>$getFromPreContact->last_name,
											'email'=>'',
											'job_title'=>$getFromPreContact->job_title,
											'linkedin_url'=>$getFromPreContact->profile_url,
											'img_card'=>$getFromPreContact->img_card,
											'telephone'=>'',
											'phone'=>'',
											'web_address'=>'',
											'company_name'=>$companyName,
											'street'=>trim($getFromPreContact->address),
											'city'=>'',
											'state'=>'',
											'zip'=>'',
											'country'=>''
											);
						
						
						$saveData = $this->client_model->insertDummy($getDataFromPreContact);
						if($saveData>0){
							echo "NewID:".$saveData."<br/>";
						} else {
							echo "<pre>";
							print_r($getDataFromPreContact);
						}													
					}
				}				
			}
			echo "<br/>==========================<br/>";
			$s++;
		}
		die;
	}

	public function addBulkContactsFromSpreadSheet(){
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();
		$service = new SpreadsheetServiceHelper();
		$ss_id = "1D1Sl38P4YHD8V-PLzArknJqVp5hRU6Isza9AFYAkeXE";
		$spreadsheet = $service->getSpreadsheetById($ss_id);
		$allWorkSheet = $service->getAllWorkSheets();
		$sheetName = "Not to be deleted";
		if(!empty($sheetName)){
			$listFeed = $service->getWorkSheetByName($sheetName);
			$asset_data =$service->getAllRows($listFeed->getEntries());
		}	
		$this->load->model('lead_model');	
		$this->load->model('client_model');	
		$this->load->model('customer_model');
		for($i=0;$i<count($asset_data);$i++){
			$companyID = 0;
			$rowData = $asset_data[$i];			
			$companyName = $rowData['companyname'];
			$imgCard = $rowData['imgcard'];
			if(strpos($imgCard,'data:image')!==false){
				$imgCard = "";
			}
			if(!empty(trim($companyName))){
				$email = $rowData['email'];
				$linkedin_url = $rowData['linkedinurl'];
				$entry = true;
				if(!empty($email)){
					$checkContactData = $this->lead_model->getContactByEmailOrSecondary($email);
					if(count($checkContactData)>0){
						$entry = false;
					}
				}
				if($entry===true){
					if(!empty($linkedin_url)){
						$checkContactData = $this->client_model->find_contact_by_linkedin($linkedin_url);
						if(count($checkContactData)>0){
							$entry = false;
						}
					}
				}
				if($entry===true){
					$companyName = trim($companyName);
					if(!empty($companyName)){
						$checkContactData = $this->lead_model->getCompanyName($companyName,'id');
						if(count($checkContactData)>0){
							$companyID = $checkContactData->id;
						}
						if($companyID==0){
							/*add company*/
							$companyID = $this->customer_model->insertCompany(array('company_name'=>$companyName));
						}
						if($companyID>0){
							$insertDataContact = array(
								'first_name'=>$rowData['firstname'],
								'last_name'=>$rowData['lastname'],
								'email'=>$rowData['email'],
								'job_title'=>$rowData['jobtitle'],
								'linkedin_url'=>$rowData['linkedinurl'],
								'telephone'=>$rowData['telephone'],
								'phone'=>$rowData['phone'],
								'company_id'=>$companyID,
								'img_card'=>$imgCard,
								'proximity'=>$rowData['proximity'],
								'c_c'=>$rowData['cc'],
								'zip'=>'',
								'country'=>''
								);
							$saveData = $this->client_model->insert($insertDataContact);
							if($saveData>0){
								echo "NewID:".$saveData."<br/>";
							} else {
								echo "<pre>";
								print_r($insertDataContact);
							}
						}
					}					
				}
			} else {
					$insertDataContact = array(
								'first_name'=>$rowData['firstname'],
								'last_name'=>$rowData['lastname'],
								'email'=>$rowData['email'],
								'job_title'=>$rowData['jobtitle'],
								'profile_url'=>$rowData['linkedinurl'],
								'telephone'=>$rowData['telephone'],
								'cellphone'=>$rowData['phone'],
								'company_name'=>trim($companyName),
								'img_card'=>$imgCard,
								'proximity'=>$rowData['proximity'],
								'c_c'=>$rowData['cc']
								);
				
				
				$saveData = $this->lead_model->insertPreContacts($insertDataContact);
				if($saveData>0){
					echo "NewID:".$saveData."<br/>";
				} else {
					echo "<pre>";
					print_r($insertDataContact);
				}	
			}
		}
		die;
	}



	
	public function insertDataInBulkOneByOne(){
		$data = array('id'=>0,'pre_id'=>0);
		if(isset($_POST) && count($_POST)>0){
			$getData = $this->input->post();
			$data['pre_id'] = $getData['invitee']['pre_id'];
			unset($getData['invitee']['pre_id']);
			
			$data['id'] = $this->insertContact($getData);		
			if($data['id']>0 && $data['pre_id']>0){
				/*Remove Pre Contacts*/
				$this->load->model('lead_model');	
				$this->lead_model->deletePreContact($data['pre_id']);
			}
		}	
		echo json_encode($data);
		die;	
	}	
	public function contacts_bulk_sector_deptt(){
		$data = array('data'=>0);
		if(isset($_POST) && count($_POST)>0){
			$companiesEnc = $this->input->post('c');
			$sector = $this->input->post('s');
			$depttEnc = $this->input->post('d');
			$subDepttEnc = $this->input->post('sc');
			$companies = json_decode($companiesEnc,true);
			$deptt = json_decode($depttEnc,true);
			$subDeptt = json_decode($subDepttEnc,true);
			$this->load->model('customer_model');			
			for($i=0;$i<count($companies);$i++){
				if(!empty($sector) && (int)$sector>0){
					/*Update company with sector*/
					$this->customer_model->deleteCompanySector($companies[$i]);
					$data['data'] = $this->customer_model->addCompanySector(array("sector_id"=>$sector,"company_id"=>$companies[$i]));
					/**/
					if(count($deptt)>0){
						/*Delete Category from company*/
						$this->customer_model->deleteCustomerPreference($companies[$i]);
						for($j=0;$j<count($deptt);$j++){
							/**/
							if((int)$deptt[$j]>0){
								$data['data'] =  $this->customer_model->insertCustomerPreference(array("customer_id"=>$companies[$i],"preference_id"=>$deptt[$j]));
							}							
						}
						if(count($subDeptt)>0){
							/*Delete Sub Category from company*/
							for($j=0;$j<count($subDeptt);$j++){
								/**/
								if((int)$subDeptt[$j]>0){
									$data['data']  = $this->customer_model->insertCustomerPreference(array("customer_id"=>$companies[$i],"preference_id"=>$subDeptt[$j]));
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
	public function dueDiligenceFileMaker(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('general_model');
			$this->load->model('opportunity_model');
			$this->load->model('acquisition_model');
			$this->load->model('user_model');
			$this->load->model('notification_model');
			$findLeadData = $this->opportunity_model->getLeadData($leadID);
			if(count($findLeadData)>0){
				$acquisitionData = $this->acquisition_model->getData($leadID);
				if(count($acquisitionData)>0){
					$url = "http://www.synpat.com/store/".$acquisitionData['acquisition']->store_name."/due.php";
					$adminUsers = $this->user_model->findAdminUsers();
					if(count($adminUsers)>0){
						$send = 0;
						foreach($adminUsers as $user){
							$sendID = $this->notification_model->insert(array('user_id'=>$user->id,'message'=>'Due Diligence FileMaker <a href="'.$url.'" target="_BLANK">'.$url.'</a>'));
							/*Check DB Message and Subject*/
							$getData = $this->general_model->getTaskAccToType('DD_FILE_MAKER');
							$subject="DD File Maker";
							$message = "DD File Maker.";
							if(count($getData)>0){
								$subject = $getData->subject;
								$message = $getData->message;
							}
							/*End Checking*/
							$approvalRequest = $this->opportunity_model->sendApprovalRequest(array('subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$user->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'DD_FILE_MAKER','status'=>'0'));
							if($approvalRequest>0){
								$send = 1;
							}
						}
						if($send>0){
							$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Send request to Admin for Due diligence filemaker.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
							$this->user_model->addUserHistory($user_history);	
							echo json_encode(array('send'=>'1','subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$user->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'DD_FILE_MAKER','status'=>'0','task_id'=>$approvalRequest));
						} else {
							echo json_encode(array('send'=>'0'));
						}
					} else {
						echo json_encode(array('send'=>'0'));
					}
				} else {
					echo json_encode(array('send'=>'0'));
				}				
			} else {
				echo json_encode(array('send'=>'0'));
			}
		} else {
			echo json_encode(array('send'=>'0'));
		}
		die;
	}	
	public function startMarketResearch(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('opportunity_model');
			$this->load->model('user_model');
			$this->load->model('notification_model');
			$this->load->model('general_model');
			$findLeadData = $this->opportunity_model->getLeadData($leadID);
			if(count($findLeadData)>0){
				$adminUsers = $this->user_model->findAdminUsers();
				if(count($adminUsers)>0){
					$send = 0;
					$acquisitionData = $this->acquisition_model->getData($leadID);
					$url="";
					if(count($acquisitionData)>0){
						$url = "http://www.synpat.com/store/".$acquisitionData['acquisition']->store_name."/due.php";
					}
					foreach($adminUsers as $user){
						$sendID = $this->notification_model->insert(array('user_id'=>$user->id,'message'=>'Market Research <a href="'.$url.'" target="_BLANK">'.$url.'</a>'));		
						/*Check DB Message and Subject*/
						$getData = $this->general_model->getTaskAccToType('MARKET_RESEARCH');
						$subject="Market Research";
						$message = "Market Research.";
						if(count($getData)>0){
							$subject = $getData->subject;
							$message = $getData->message;
						}
						/*End Checking*/						
						$approvalRequest = $this->opportunity_model->sendApprovalRequest(array('subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$user->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'MARKET_RESEARCH','status'=>'0'));
						if($approvalRequest>0){
							$send = 1;
						}
					}
					if($send>0){
						$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Send request to Admin for market research.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);	
						echo json_encode(array('send'=>'1','subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$user->id,'lead_id'=>$leadID,'doc_url'=> $url,'type'=>'MARKET_RESEARCH','status'=>'0','task_id'=>$approvalRequest));
					} else {
						echo json_encode(array('send'=>'0'));
					}
				} else {
					echo json_encode(array('send'=>'0'));
				}
			} else {
				echo json_encode(array('send'=>'0'));
			}
		} else {
			echo json_encode(array('send'=>'0'));
		}
		die;
	}	
	public function orderDamagesByCIPO(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('user_model');
			$this->load->model('opportunity_model');
			$this->load->model('notification_model');
			$this->load->model('general_model');
			$findLeadData = $this->opportunity_model->getLeadData($leadID);
			if(count($findLeadData)>0){
				$cipoUsers = $this->user_model->findUserByType('8');
				if(count($cipoUsers)>0){
					$sendID = $this->notification_model->insert(array('user_id'=>$cipoUsers->id,'message'=>'Upload Damages Report'));
					/*Check DB Message and Subject*/
					$getData = $this->general_model->getTaskAccToType('ORDER_DAMAGES');
					$subject="Order Damages";
					$message = "Order Damages.";
					if(count($getData)>0){
						$subject = $getData->subject;
						$message = $getData->message;
					}
					/*End Checking*/
					$approvalRequest = $this->opportunity_model->sendApprovalRequest(array('subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$cipoUsers->id,'lead_id'=>$leadID,'doc_url'=> '','type'=>'ORDER_DAMAGES','status'=>'0'));
					$updateReport = $this->opportunity_model->updateReport($leadID,array('order_damage'=>1));
					if($updateReport){
						$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Send request to CIPO for uploading damages report.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);	
						echo json_encode(array('send'=>'1','subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$cipoUsers->id,'lead_id'=>$leadID,'doc_url'=> '','type'=>'ORDER_DAMAGES','status'=>'0','task_id'=>$approvalRequest,'create_date'=>date('Y-m-d H:i:s')));
					} else {
						echo json_encode(array('send'=>'0'));
					}
				} else {
					echo json_encode(array('send'=>'0'));
				}
			} else {
				echo json_encode(array('send'=>'0'));
			}
		} else {
			echo json_encode(array('send'=>'0'));
		}
		die;
	}	
	public function uploadImageFile($tmp,$target){
		$imageFile = "";
		$target_file = $_SERVER['DOCUMENT_ROOT'].'/public/upload/'.$target;
		if(move_uploaded_file($tmp, $target_file)){
			$imageFile= $this->config->base_url().'public/upload/'.$target;
		}
		return $imageFile;
	}	
	public function docket_entry(){
		if(isset($_POST) && count($_POST)>0){			
			$docket = $this->input->post();
			$imageLeft = "";
			$imageMiddle = "";
			$imageRight = "";
			$imageFour ="";
			$imageFive ="";
			$imageSix ="";
			$imageSeven ="";
			$imageEight ="";
			$imageNine ="";
			$imageTen ="";
			$imageEleven ="";
			$imageTwelve ="";
			if(isset($_FILES) && !empty($_FILES['docket']['name']['image_left'])){
				$imageLeft = $this->uploadImageFile($_FILES['docket']["tmp_name"]['image_left'],$_FILES['docket']['name']['image_left']);
			}
			if(isset($_FILES) && !empty($_FILES['docket']['name']['image_middle'])){
				$imageMiddle= $this->uploadImageFile($_FILES['docket']["tmp_name"]['image_middle'],$_FILES['docket']['name']['image_middle']);
			}
			if(isset($_FILES) && !empty($_FILES['docket']['name']['image_right'])){
				$imageRight= $this->uploadImageFile($_FILES['docket']["tmp_name"]['image_right'],$_FILES['docket']['name']['image_right']);
			}
			
			$docket['docket']['image_left'] = $imageLeft;
			$docket['docket']['image_middle'] = $imageMiddle;
			$docket['docket']['image_right'] = $imageRight;
			
			$this->load->model('opportunity_model');
			$this->load->model('acquisition_model');
			/*Save to DOCKET*/
			$findLeadData = $this->opportunity_model->getLeadData($docket['docket']['lead_id']);
			if(count($findLeadData)>0){
				$docket['docket']['seller_asking_price'] = $findLeadData->expected_price;
				$acquisitionData = $this->acquisition_model->getData($docket['docket']['lead_id']);
				if(count($acquisitionData)>0){
					/*API for APPDMIN*/
					$curl = curl_init();
					// Set some options - we are passing in a useragent too here
					curl_setopt_array($curl, array(
						CURLOPT_RETURNTRANSFER => 1,
						CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/update_docket_data', 
						CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
						CURLOPT_POST => 1,
						CURLOPT_POSTFIELDS => array(
							'license_number' => $acquisitionData['acquisition']->store_name,
							'image_left'=>$imageLeft,
							'image_middle'=>$imageMiddle,
							'image_right'=>$imageRight,
							'expiration_date'=>$docket['docket']['option_expiration_data'],
							'asking_price'=>$docket['docket']['seller_asking_price'],
						)
					));
					// Send the request & save response to $resp
					$resp = curl_exec($curl);
					if($resp){
						$getData = json_decode($resp);
						if(count($getData)>0 && (int)$getData->send>0){
							$saveData = $this->acquisition_model->updateData($docket['docket']['lead_id'],$docket['docket']);
							if($saveData){
								$this->load->model('user_model');
								$user_history = array('lead_id'=>$docket['docket']['lead_id'],'user_id'=>$this->session->userdata['id'],'message'=>"Upload example images.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
								$this->user_model->addUserHistory($user_history);	
								$this->session->set_flashdata('message','<p class="alert alert-success">Record Saved!</p>');
							} else {
								$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime.</p>');
							}
							redirect('opportunity/docket/'.$docket['docket']['lead_id']);
						} else {
							$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime.</p>');
							redirect('opportunity/docket/'.$docket['docket']['lead_id']);
						}
					} else {
						$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime.</p>');
						redirect('opportunity/docket/'.$docket['docket']['lead_id']);
					}
					/*END API*/
				} else {
					$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime.</p>');
					redirect('dashboard');
				}
			} else {
				$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime.</p>');
				redirect('dashboard');
			}
		} else {
			$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime.</p>');
			redirect('dashboard');
		}
	}	
	public function uploadDocumentByCIPO(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $this->input->post('token');
			$this->load->model('user_model');
			$this->load->model('opportunity_model');
			$this->load->model('notification_model');
			$this->load->model('general_model');
			$findLeadData = $this->opportunity_model->getLeadData($leadID);
			if(count($findLeadData)>0){
				$cipoUsers = $this->user_model->findUserByType('8');
				if(count($cipoUsers)>0){
					$sendID = $this->notification_model->insert(array('user_id'=>$cipoUsers->id,'message'=>'Upload Other Docs'));
					/*Check DB Message and Subject*/
					$getData = $this->general_model->getTaskAccToType('OTHER_DOCS');
					$subject="Other Docs";
					$message = "Other Docs.";
					if(count($getData)>0){
						$subject = $getData->subject;
						$message = $getData->message;
					}
					/*End Checking*/
					$approvalRequest = $this->opportunity_model->sendApprovalRequest(array('subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$cipoUsers->id,'lead_id'=>$leadID,'doc_url'=> '','type'=>'OTHER_DOCS','status'=>'0'));
					$updateReport = $this->opportunity_model->updateReport($leadID,array('other_doc'=>1));
					if($updateReport){
						$user_history = array('lead_id'=>$leadID,'user_id'=>$this->session->userdata['id'],'message'=>"Send request to CIPO for upload documents.",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);	
						echo json_encode(array('send'=>'1','subject'=>$subject,'message'=>$message,'execution_date'=>date("Y-m-d"),'parent_id'=>0,'from_user_id'=>$this->session->userdata['id'],'user_id'=>$cipoUsers->id,'lead_id'=>$leadID,'doc_url'=> '','type'=>'OTHER_DOCS','status'=>'0','task_id'=>$approvalRequest));
					} else {
						echo json_encode(array('send'=>'0'));
					}
				} else {
					echo json_encode(array('send'=>'0'));
				}
			} else {
				echo json_encode(array('send'=>'0'));
			}
		} else {
			echo json_encode(array('send'=>'0'));
		}
		die;
	}	
	public function getCheckListContact(){
		$getData = array();
		if(isset($_POST) && count($_POST)>0){
			$sector_id = $this->input->post('token');
			$selected = array();
			if(!empty($sector_id)){
				$sector_id = json_decode($sector_id );
				if(!isset($_SESSION)){
					session_start();
				}
				$contacts = $_SESSION['all_contacts'];	
				if(count($contacts)>0){
					foreach($contacts as $contact){
						if(is_array($contact->sectors)){
							foreach($contact->sectors as $sector){
								if(in_array($sector,$sector_id)){
									if(!in_array($contact->id,$selected)){
										$selected[] = $contact->id;
										$getData[] = $contact;
									}
									
								}
							}
						}
					}
				}				
				/*$getData = $this->client_model->getContactListBySectorID($sector_id);*/
			}
		}
		echo json_encode($getData);
		die;
	}	
	public function damages_report(){
		if(isset($_POST) && count($_POST)>0){
			$other = $this->input->post('other');
			if((int)$other['lead_id']>0){
				$this->load->model('opportunity_model');
				$this->load->model('acquisition_model');
				$this->load->model('user_model');
				$findLeadData = $this->opportunity_model->getLeadData($other['lead_id']);
				if(count($findLeadData)>0){
					if(!empty($other['damages_report'])){
						/*Send API Request*/
						$acquisitionData = $this->acquisition_model->getData($other['lead_id']);
						if(count($acquisitionData)>0){
							/*API for APPDMIN*/
							$curl = curl_init();
							// Set some options - we are passing in a useragent too here
							curl_setopt_array($curl, array(
								CURLOPT_RETURNTRANSFER => 1,
								CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/license_update',
								CURLOPT_USERAGENT => 'Send Request for create demo portfolio',
								CURLOPT_POST => 1,
								CURLOPT_POSTFIELDS => array(
									'license_number' => $acquisitionData['acquisition']->store_name,
									'damage'=>$other['damages_report']
								)
							));
							// Send the request & save response to $resp
							$resp = curl_exec($curl);
							if($resp){
								$getData = json_decode($resp);
								/*End API Request*/
								if(count($getData)>0 && (int)$getData->send>0){
									$saveData = $this->acquisition_model->updateData($other['lead_id'],array('other_damages'=>$other['damages_report']));
									$userID = $this->session->userdata['id'];
									$approvalRequest = $this->opportunity_model->updateApprovalData($other['id'],array('status'=>'1'));
									$updateReport = $this->opportunity_model->updateReport($other['lead_id'],array('order_damage'=>2));
									if($saveData){
										$user_history = array('lead_id'=>$other['lead_id'],'user_id'=>$this->session->userdata['id'],'message'=>"Damages reports uploaded",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
										$this->user_model->addUserHistory($user_history);	
										$this->session->set_flashdata('message','<p class="alert alert-success">Record Saved!</p>');
									} else {
										$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');				
									}
									redirect('dashboard');
								} else {
									$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');	
									redirect('dashboard');
								}								
							} else {
								$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');	
								redirect('dashboard');
							}						
						} else {
							$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');	
							redirect('dashboard');
						}					
					} else {
						$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');	
						redirect('dashboard');
					}
				} else {
					$this->session->set_flashdata('message','<p class="alert alert-warning">Please try after sometime!</p>');	
					redirect('dashboard');
				}
			} else {
				$this->session->set_flashdata('message','<p class="alert alert-warning">Invalid request!</p>');	
				redirect('dashboard');
			}
		} else {
			$this->session->set_flashdata('message','<p class="alert alert-warning">Invalid request!</p>');	
			redirect('dashboard');
		}
	}	
	public function activityLog($activityLog){
		if(isset($activityLog['task_id'])){
			unset($activityLog['task_id']);
		}
		if(isset($activityLog['next_call_date'])){
			unset($activityLog['next_call_date']);
		}
		$this->load->model('lead_model');
		$this->lead_model->insertActivityLog($activityLog);		
	}	
	public function task(){
		if(isset($_POST) && count($_POST)>0){
			$task = $this->input->post('task');
			$record=0;
			$type="";
			$email="";
			if(count($task)>0 && (int)$task['lead_id']>0){
				$this->load->model('opportunity_model');				
				$this->load->model('user_model');				
				$this->load->model('lead_model');				
				if((int)$task['id']==0){
					unset($task['id']);
					$sendEmail = 0;
					if(isset($task['send_email']) && $task['send_email']!=""){
						$sendEmail = $task['send_email'];
					}
					unset($task['send_email']);
					if(isset($task['record']) && $task['record'] >0){
						$record= $task['record'];
						$type= $task['type'];
					}
					unset($task['record']);
					unset($task['type']);
					if(!isset($task['execution_date']) || empty($task['execution_date'])){
						$task['execution_date'] = date('Y-m-d');
					}
					$send = $this->opportunity_model->sendApprovalRequest($task);
					$checkUserData = $this->user_model->getUserData($task['user_id']);
					$activities = $this->input->post('activity');
					if(!empty($activities['activity_type']) && (int)$activities['activity_type']>0){
						$personID = $activities['person_id'];
						$companyID = $activities['company_id'];
						if((int)$personID>0 && (int)$companyID>0){
							$act['lead_id'] = $task['lead_id'];
							$act['contact_id'] = $personID;
							$act['company_id'] = $companyID;
							$act['note'] = $task['subject'];
							$act['activity_date'] = date('Y-m-d H:i:s');
							$act['user_id'] = $task['user_id'];
							$act['subject'] = "";
							$act['task_id'] = $send;
							$act['type'] = 10;
							switch((int)$activities['activity_type']){
								case 1:
									$this->lead_model->insetSalesActivity($act);
								break;
								case 2:
									$this->lead_model->insertAcquistionActivity($act);
								break;
								case 3:
									$this->lead_model->insertPreSaleActivity($act);
								break;
							}							
						}
					}
					if(count($checkUserData) && (int)$sendEmail==1){
						/*$leadData = $this->lead_model->getLeadData($task['lead_id']);*/
						/*$this->load->library('email');
						$this->email->from($this->session->userdata['email'], $this->session->userdata['name']);
						$this->email->to($checkUserData->email); 
						$this->email->set_mailtype('html'); 
						$this->email->subject($task['subject']);*/
						if(!isset($_SESSION)){
							session_start();
						}
						$email = array();
						$email['to'] = $checkUserData->email;
						$email['to_name'] = $checkUserData->name;
						$email['subject'] =  $task['subject'];
						$email['cc'] = '';
						$email['bcc'] = '';
						$email['thread_id'] = '';
						$email['message_id'] = '';
						$email['from_name'] = $this->session->userdata['name'];
						$email['from_email'] = $this->session->userdata['email'];
						$email['reference'] = '';
						$message = '<html><head><title>New Task</title></head><body>'.$task['message'];
						$message .='<p>Hello, you have a task from SynPat. To access SynPat\'s Backyard system please <a href="'.$this->config->base_url().'dashboard/index/'.$task['lead_id'].'">log in</a>.</p>';
						if(isset($task['doc_url']) && !empty($task['doc_url'])){
							$message .='<p>Document URL: <a href="'.$task['doc_url'].'">'.$task['doc_url'].'</a></p>';
						}
						$signature = "";
						if(!empty($_POST['other']['signature'])){
							$signature = $_POST['other']['signature'];
						}
						$message .=$signature.'</body></html>';						
						$email['message'] = $message;
						$this->load->library('DriveServiceHelper');
						$email['href'] = array();
						$service = new GmailServiceHelper();
						$service->setAccessToken($_SESSION['another_access_token']);
						$send  = $service->sendMessage($email);
						/*$this->email->message($message);	
						$this->email->send();*/
					}
				} else {
					unset($task['record']);
					unset($task['type']);
					$send = $this->opportunity_model->updateApprovalData($task['id'],$task);
				}				
				if($send>0){
					if($record>0){
						if(!empty($type) && !empty($email)){
							$allEmails = $email;
							$dataArray = array("lead_id"=>$task['lead_id'],"type"=>$type,"total_patent"=>0,"create_date"=>date('Y-m-d H:i:s'),"expert"=>$allEmails,'file_url'=>$task['doc_url']);
							$this->user_model->due_logtime($dataArray);
						}
					}
					$user_history = array('lead_id'=>$task['lead_id'],'user_id'=>$this->session->userdata['id'],'message'=>"Create a task",'opportunity_id'=>1,'create_date'=>date('Y-m-d H:i:s'));
					$this->user_model->addUserHistory($user_history);
					$this->session->set_flashdata('message','<p class="alert alert-success">Task Send!</p>');					
					$this->load->library('user_agent');
					if(isset($_POST['other']['return'])){
						/*redirect('opportunity/docket/'.$task['lead_id']);*/
					}  else if ($this->agent->is_referral()){
						/*redirect($this->agent->referrer());*/
					} else {
						/*redirect('dashboard/index/'.$task['lead_id']);*/
					}					
				} else {
					$this->session->set_flashdata('message','<p class="alert alert-warning">Server busy please try after sometime.</p>');
					if(isset($_POST['other']['return'])){
						/*redirect('opportunity/docket/'.$task['lead_id']);*/
					} else {
						/*redirect('dashboard/index/'.$task['lead_id']);*/
					}						
				}
			} else {
				$this->session->set_flashdata('message','<p class="alert alert-warning">Invalid data!</p>');
				/*redirect('dashboard');*/	
			}		
		} else {
			$this->session->set_flashdata('message','<p class="alert alert-warning">Invalid data!</p>');
			/*redirect('dashboard');*/	
		}
		die;
	}	
	public function find_task(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){			
			if($this->input->post('token')!=""){
				$this->load->model('opportunity_model');
				$data = $this->opportunity_model->findTask($this->input->post('token'));
			}
		}
		echo json_encode($data);
		die;
	}	
	public function reply_task(){
		if(isset($_POST) && count($_POST)>0){
			$task = $this->input->post('reply');
			$this->load->model('opportunity_model');
			$this->load->model('user_model');
			$this->load->model('lead_model');
			if(count($task)>0 && isset($task['forward']) && (int)$task['forward']==1){
				/* Change Status of Parent ID*/
				$parentTask= array('status'=>2,"completion_date"=>date('Y-m-d'));
				$updated = $this->opportunity_model->updateApprovalData($task['parent_id'],$parentTask);
				if($updated>0){
					if(empty($task['execution_date'])){
						$task['execution_date'] = date('Y-m-d');
					}
					$newTask= array("from_user_id"=>$task['from_user_id'],"lead_id"=>$task['lead_id'],"execution_date"=>$task['execution_date'],"message"=>$task['message'],"subject"=>$task['subject'],"user_id"=>$task['user_id'],"status"=>0,"type"=>$task['type'],"parent_id"=>$task['parent_id']);
					$send = $this->opportunity_model->sendApprovalRequest($newTask);
					if($send>0){
						$user_history = array('lead_id'=>$task['lead_id'],'user_id'=>$this->session->userdata['id'],'message'=>"Forward a task",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
						$sendEmail = 0;
						if(isset($task['send_email']) && $task['send_email']!=""){
							$sendEmail = $task['send_email'];
						}
						unset($task['send_email']);
						$checkUserData = $this->user_model->getUserData($task['user_id']);
						if(count($checkUserData) && (int)$sendEmail==1){
							$leadData = $this->lead_model->getLeadData($task['lead_id']);
							$this->load->library('email');
							$this->email->from($this->session->userdata['email'], $this->session->userdata['name']);
							$this->email->to($checkUserData->email); 
							$this->email->set_mailtype('html'); 
							$this->email->subject($task['subject']);
							$this->email->message('<html><head><title>New Task</title></head><body>'.$task['message'].'<p>Hello, you have a task from SynPat. To access SynPat\'s Backyard system please <a href="'.$this->config->base_url().'dashboard/index/'.$leadData->id.'">log in</a>.</p></body></html>');	
							$this->email->send();
						}
						$this->session->set_flashdata('message','<p class="alert alert-success">Task Created!</p>');
						$this->load->library('user_agent');
						if ($this->agent->is_referral()){
							redirect($this->agent->referrer());
						} else {
							redirect('dashboard/index/'.$task['lead_id']);
						}					
					} else {
						$this->session->set_flashdata('message','<p class="alert alert-warning">Server busy please try after sometime!</p>');
						redirect('dashboard/index/'.$task['lead_id']);	
					}
				} else {
					$this->session->set_flashdata('message','<p class="alert alert-warning">Server busy please try after sometime!</p>');
					redirect('dashboard/index/'.$task['lead_id']);	
				}
			}  else if(count($task)>0 && isset($task['reply']) &&(int) $task['reply']==2){
				$parentTask = array('status'=>2,"completion_date"=>date('Y-m-d'));
				$updated = $this->opportunity_model->updateApprovalData($task['parent_id'],$parentTask);
				$this->lead_model->deleteTask($task['parent_id']);
				if($updated>0){
					$user_history = array('lead_id'=>$task['lead_id'],'user_id'=>$this->session->userdata['id'],'message'=>"Delete a task",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
					$this->approved_doc($task['parent_id']);
					$this->session->set_flashdata('message','<p class="alert alert-success">Remove Task</p>');
					$this->load->library('user_agent');
					if ($this->agent->is_referral()){
						redirect($this->agent->referrer());
					} else {
						redirect('dashboard/index/'.$task['lead_id']);
					}
				} else {
					$this->session->set_flashdata('message','<p class="alert alert-warning">Server busy please try after sometime!</p>');
					redirect('dashboard/index/'.$task['lead_id']);
				}
			} else if(count($task)>0 && isset($task['complete']) &&(int) $task['complete']==1){
				/*Change Status to complete and Insert completion date*/
				$parentTask = array('status'=>1,"completion_date"=>date('Y-m-d'));
				$updated = $this->opportunity_model->updateApprovalData($task['parent_id'],$parentTask);
				if($updated>0){
					$user_history = array('lead_id'=>$task['lead_id'],'user_id'=>$this->session->userdata['id'],'message'=>"Complete a task",'opportunity_id'=>0,'create_date'=>date('Y-m-d H:i:s'));
						$this->user_model->addUserHistory($user_history);
					$this->approved_doc($task['parent_id']);
					$this->session->set_flashdata('message','<p class="alert alert-success">Task Completed!</p>');
					$this->load->library('user_agent');
					if ($this->agent->is_referral()){
						redirect($this->agent->referrer());
					} else {
						redirect('dashboard/index/'.$task['lead_id']);
					}
				} else {
					$this->session->set_flashdata('message','<p class="alert alert-warning">Server busy please try after sometime!</p>');
					redirect('dashboard/index/'.$task['lead_id']);
				}
			} else {
				$this->session->set_flashdata('message','<p class="alert alert-warning">Invalid data!</p>');
				redirect('dashboard');	
			}			
		} else {
			$this->session->set_flashdata('message','<p class="alert alert-warning">Invalid data!</p>');
			redirect('dashboard');	
		}
	}			
	public function deleteCompany(){
		$data = 0;
		$post = $this->input->post('delete_link');
		if($post!=""){
			$this->load->model('client_model');
			$data = $this->client_model->deleteCompany($post);			
		}
		echo $data;
		die;
	}
	
	function emailScrapeAllCompaniesByFilter(){
		$getContactList = array('companies'=>array(),'no_domain'=>array());
		if(isset($_POST) && count($_POST)>0){
			/*$allFromQuery = (int)$this->input->post('all_from_query');
			*/
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sc');
				$subCat = $this->input->post('sst');
				$tech = $this->input->post('stt');
				$subTech = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				$users = $this->input->post('u');
				$industry = $this->input->post('industry');
				$company_size = $this->input->post('company_size');
				$no_of_size = $this->input->post('no_of_size');
				$label = $this->input->post('label');
				$specialist = $this->input->post('specialist');
				$alpha = $this->input->post('alpha');
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
					/*$industry = implode(',',$inds);
					$industry = implode(',',$industry);*/
				} else {
					$industry = array();
				}
				if(is_array($specialist)){
					$specialities = array();
					foreach($specialist as $spec){
						$specialities[] = trim($spec);
					}
					$specialist = $specialities;
				} else {
					$specialist = array();
				}
				if(is_array($company_size)){
					$cs = array();
					foreach($company_size as $c){
						$cs[] = '"'.$c.'"';
					}
					$company_size = $cs;
					/*$company_size = implode(',',$company_size);*/
				} else {
					$company_size = array();
				}
				if(is_array($no_of_size)){					
					$no_of_size = implode(',',$no_of_size);
				} else {
					$no_of_size = "";
				}
				if(is_array($sector)){
					$sector = implode(',',$sector);
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}	
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}	
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}	
				if(is_array($users)){
					$users = implode(',',$users);
				} else {
					$users = "";
				}			
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$start = 0;
				$end = 0;
				$leadID = $this->input->post('lead_id');
				$activity = $this->input->post('a');
				$invited = $this->input->post('invite');
				$this->load->model('customer_model');
				/*$resultData = $this->customer_model->companyListWithPaging($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$sort,$sortBy,0,0,$leadID,$activity,$invited,false);	*/			
				$resultData = $this->customer_model->companyOptimizeListWithPaging($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$label,$specialist,$alpha,$sort,$sortBy,0,0,$leadID,$activity,$invited,false);				
				if(count($resultData['data'])>0){
					foreach($resultData['data'] as $c){
						$domain = $c->web_address;
						if($domain!=""){
							$host = parse_url($domain, PHP_URL_HOST);
							$host = str_replace("www.",'',$host);
							$getList = $this->customer_model->getAllContactBelongToCompany($c->id);	
							if(count($getList)>0){
								foreach($getList as $u){
									$getContactList['companies'][] = array('first_name'=>$u->first_name,'last_name'=>$u->last_name,'domain'=>$host,'contact_id'=>$u->id,'company_id'=>$c->id);
								}
							}
						} else {
							$getContactList['no_domain'][] = $c->id;
						}						
					}
				}
				if(count($getContactList['companies'])>0){
					$this->customer_model->insertBatchEmailScrapper($getContactList['companies']);
				}
			}catch(Exception $e){
				
			}
		}
		echo json_encode($getContactList);
		die;
	}
	function emailScrapeSelectedCompaniesSelectedContact(){
		$getContactList = array('companies'=>array(),'no_domain'=>array());
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('customer_model');
			$companyData = $this->customer_model->getCompanyDataByIDWithOptions($this->input->post('co_id'),'c.web_address');
			if(count($companyData)>0){
				$domain = $companyData->web_address;
				if($domain!=""){
					$host = parse_url($domain, PHP_URL_HOST);
					$host = str_replace("www.",'',$host);
					$getData = $this->customer_model->getContactData($this->input->post('c_id'));	
					if(count($getData)>0){
						$getContactList['companies'][] = array('first_name'=>$getData->first_name,'last_name'=>$getData->last_name,'domain'=>$host,'contact_id'=>$getData->id,'company_id'=>$this->input->post('co_id'));
						$this->customer_model->insertBatchEmailScrapper($getContactList['companies']);
					}
				} else {
					$getContactList['no_domain'][] = $this->input->post('co_id');
				}
			}
		}
		echo json_encode($getContactList);
		die;
	}
	function emailScrapeSelectedCompanies(){
		$getContactList = array('companies'=>array(),'no_domain'=>array());
		if(isset($_POST) && count($_POST)>0){
			$companyIDs = $this->input->post('list');
			if(count($companyIDs)>0){
				$this->load->model('customer_model');
				foreach($companyIDs as $c){
					$companyData = $this->customer_model->getCompanyDataByIDWithOptions($c,'c.web_address');
					if(count($companyData)>0){
						$domain = $companyData->web_address;
						if($domain!=""){
							$host = parse_url($domain, PHP_URL_HOST);
							$host = str_replace("www.",'',$host);
							$getList = $this->customer_model->getAllContactBelongToCompany($c);	
							if(count($getList)>0){
								foreach($getList as $u){
									$getContactList['companies'][] = array('first_name'=>$u->first_name,'last_name'=>$u->last_name,'domain'=>$host,'contact_id'=>$u->id,'company_id'=>$c);
								}
							}
						} else {
							$getContactList['no_domain'][] = $c;
						}
					}
				}
				if(count($getContactList['companies'])>0){
					$this->customer_model->insertBatchEmailScrapper($getContactList['companies']);
				}
			}
		}
		echo json_encode($getContactList);
		die;
	}
		
	function scrapeAllCompaniesByFilter(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			/*$allFromQuery = (int)$this->input->post('all_from_query');
			*/
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sc');
				$subCat = $this->input->post('sst');
				$tech = $this->input->post('stt');
				$subTech = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				$users = $this->input->post('u');
				$industry = $this->input->post('industry');
				$company_size = $this->input->post('company_size');
				$no_of_size = $this->input->post('no_of_size');
				$label = $this->input->post('label');
				$specialist = $this->input->post('specialist');
				$alpha = $this->input->post('alpha');
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
					/*$industry = implode(',',$inds);
					$industry = implode(',',$industry);*/
				} else {
					$industry = array();
				}
				if(is_array($specialist)){
					$specialities = array();
					foreach($specialist as $spec){
						$specialities[] = trim($spec);
					}
					$specialist = $specialities;
				} else {
					$specialist = array();
				}
				if(is_array($company_size)){
					$cs = array();
					foreach($company_size as $c){
						$cs[] = '"'.$c.'"';
					}
					$company_size = $cs;
					/*$company_size = implode(',',$company_size);*/
				} else {
					$company_size = array();
				}
				if(is_array($no_of_size)){					
					$no_of_size = implode(',',$no_of_size);
				} else {
					$no_of_size = "";
				}
				if(is_array($sector)){
					$sector = implode(',',$sector);
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}	
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}	
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}	
				if(is_array($users)){
					$users = implode(',',$users);
				} else {
					$users = "";
				}			
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$start = 0;
				$end = 0;
				$leadID = $this->input->post('lead_id');
				$activity = $this->input->post('a');
				$invited = $this->input->post('invite');
				$this->load->model('customer_model');
				$resultData = $this->customer_model->companyOptimizeListWithPaging($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$label,$specialist,$alpha,$sort,$sortBy,0,0,$leadID,$activity,$invited,false);
				if(count($resultData['data'])>0){
					foreach($resultData['data'] as $c){
						if($c->linkedin_url!="" && strpos($c->linkedin_url,"linkedin")!== false){
							//array_push($data, array('id'=>$c->id,'linkedin_url'=>$c->linkedin_url));
							array_push($data,array('company'=>$c->id,'linkedin_url'=>$c->linkedin_url,'company_name'=>$c->company_name,"type"=>1,"user_id"=>$this->session->userdata['id']));
						}						
					}
					if($this->input->post('request_type') == "Company" && count($data) > 0) {
						$this->load->model('opportunity_model');
						$this->opportunity_model->insertLinkedInCompanyScrapperListInBatch($data);
					}
				}				
			}catch(Exception $e){
				
			}
		}
		echo json_encode($data);
		die;
	}
	
	function deleteCompanyInBulkQuery(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			/*$allFromQuery = (int)$this->input->post('all_from_query');
			*/
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');
			$unselectedCompanies = $this->input->post('unselected');
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sc');
				$subCat = $this->input->post('sst');
				$tech = $this->input->post('stt');
				$subTech = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				$users = $this->input->post('u');
				$industry = $this->input->post('industry');
				$company_size = $this->input->post('company_size');
				$no_of_size = $this->input->post('no_of_size');
				$label = $this->input->post('label');
				$specialist = $this->input->post('specialist');
				$alpha = $this->input->post('alpha');
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
					/*$industry = implode(',',$inds);
					$industry = implode(',',$industry);*/
				} else {
					$industry = array();
				}
				if(is_array($company_size)){
					$cs = array();
					foreach($company_size as $c){
						$cs[] = '"'.$c.'"';
					}
					$company_size = $cs;
					/*$company_size = implode(',',$company_size);*/
				} else {
					$company_size = array();
				}
				if(is_array($specialist)){
					$specialities = array();
					foreach($specialist as $spec){
						$specialities[] = trim($spec);
					}
					$specialist = $specialities;
				} else {
					$specialist = array();
				}
				if(is_array($no_of_size)){					
					$no_of_size = implode(',',$no_of_size);
				} else {
					$no_of_size = "";
				}
				if(is_array($sector)){
					$sector = implode(',',$sector);
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}	
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}	
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}	
				if(is_array($users)){
					$users = implode(',',$users);
				} else {
					$users = "";
				}			
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$start = 0;
				$end = 0;
				$leadID = $this->input->post('lead_id');
				$activity = $this->input->post('a');
				$invited = $this->input->post('invite');
				$this->load->model('customer_model');
				$resultData = $this->customer_model->companyOptimizeListWithPaging($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedin,$industry,$company_size,$no_of_size,$label,$specialist,$alpha,$sort,$sortBy,0,0,$leadID,$activity,$invited,false);
				$companyIDs = array();
				if(count($resultData['data'])>0){
					foreach($resultData['data'] as $c){
						$_selected = false;
						if(count($unselectedCompanies)>0){							
							foreach($unselectedCompanies as $un){
								if((int)$un == $c->id){
									$_selected = true;break;
								}
							}
						}
						if($_selected===false){
							$companyIDs[] = $c->id;
						}						
					}
				}
				if(count($companyIDs)>0){
					$this->load->model('client_model');
					$data = $this->client_model->deleteCompanyInBulk($companyIDs);	
				}
			}catch(Exception $e){
				
			}
		}
		echo $data;
		die;
	}
	
	public function deleteBulkCompanyList(){
		$data = 0;
		$deleteCompanyIDs = $this->input->post('delete_link');
		if(count($deleteCompanyIDs) > 0) {
			$this->load->model('client_model');
			$data = $this->client_model->deleteCompanyInBulk($deleteCompanyIDs);	
		}
		echo $data;
		die;
	}
	
	public function deleteCompanyInBulk(){
		$data = 0;
		$post = $this->input->post('delete_link');
		$selected = array();
		$selected = $this->input->post('selected');
		
		if($post!="" || count($selected)>0){
			$contacts = explode(',',$post);
			$companyList = array();
			foreach($contacts as $contact){
				$contact = trim($contact);
				if(!empty($contact)){					
					$companyList[] = $contact;					
				}
			}

			if(count($selected)>0){
				$companyList = $selected;
			}

			if(count($companyList)>0){
				$this->load->model('client_model');
				$data = $this->client_model->deleteCompanyInBulk($companyList);	
			}
		} 
		echo $data;
		die;
	}	
	public function findContact($ID =null){
		$post = $this->input->post('edit_link');
		$data = array();
		if((int)$post>0){
			$this->load->model('client_model');
			$data = $this->client_model->find_contact($post);
		}
		echo json_encode($data);
		die;
	}	
	public function findCompany($ID=null){
		$post = $this->input->post('edit_link');
		$data = array();
		if((int)$post>0){
			$this->load->model('customer_model');
			$data = $this->customer_model->getCompanyDataByID($post);
		}
		echo json_encode($data);
		die;
	}    
	public function market_form($leadID=null,$t=null){
		if($leadID!=null && $t!=null){
			$data = array();
			$this->load->model('lead_model');
			$data['lead_data'] = $this->lead_model->getLeadDataWithOptions($leadID,"l.id,l.market_data");
			$data['t'] = $t;
			$this->layout->layout='outsource';		
			$this->layout->title_for_layout = 'Market';
			$this->layout->render('opportunity/market_form',$data);
		} else {
			echo "Sorry page not found!";
			die;
		}
	}	
	public function contact_form($leadID=null,$type=null,$parent=null){
		if($leadID!=null && $type!=null && $parent!=null){
			$data = array();
			if($parent!='company_form'){
				$this->load->model('lead_model');
				$data['lead_data'] = $this->lead_model->getLeadDataWithOptions($leadID,'l.id,l.lead_name,l.plantiffs_name,l.broker,l.broker_person,l.person_title_1,l.person_title_2');
			}			
			$data['leadID'] = $leadID;
			$data['type'] = $type;
			$data['parentElement'] = $parent;
			if(isset($_POST) && count($_POST)>0){
				$this->load->model('client_model');
				$data['contacts'] =  $this->client_model->getAllContactsBySectorWithPagingOptimizing($_POST['search'],"",0,500,"c.first_name","ASC","","","","","","","","","","",0,"web",false);
				echo  json_encode($data['contacts']);
				die;
			}		
			$data['contacts'] = array();
			$this->layout->layout='outsource';	
			$this->layout->title_for_layout = 'Contact';
			$this->layout->render('opportunity/contact_form',$data);
		} else {
			echo "Server busy, Please try after sometime.";
			die;
		}
	}	
	public function company_contact_form($leadID=null,$type=null,$parent=null){
		if($leadID!=null && $type!=null && $parent!=null){
			$data = array();
			if($parent!='company_form'){
				$this->load->model('lead_model');	
				$data['lead_data'] = $this->lead_model->getLeadDataWithOptions($leadID,'l.id,l.lead_name,l.plantiffs_name,l.broker,l.broker_person,l.person_title_1,l.person_title_2');
			}			
			$data['leadID'] = $leadID;
			$data['type'] = $type;
			$data['parentElement'] = $parent;
			if(isset($_POST) && count($_POST)>0){
				$this->load->model('customer_model');
				$search = $this->input->post('search');
				$data['companies'] =  $this->customer_model->companyOptimizeListWithPaging($search,'','','','','','','',array(),array(),'','',array(),'','c.company_name','ASC',0,500,0,0,2);
				echo  json_encode($data['companies']);
				die;
			}		
			$data['companies'] = array();
			$this->layout->layout='outsource';	
			$this->layout->title_for_layout = 'Contact';
			$this->layout->render('opportunity/company_contact_form',$data);
		} else {
			echo "Server busy, Please try after sometime.";
			die;
		}
	}	
	
	public function find_claimcharts_reports(){
		$ch = curl_init();		
		$api_url = 'http://claimcharts.synpat.com/index.php?option=com_survey&task=api.findNewReports';
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
		$response = curl_exec($ch); 
		curl_close($ch);
		echo $response;
		die;
	}
	
	public function open_project_contact_form($leadID=null,$type=null,$parent=null){
		if($leadID!=null && $type!=null && $parent!=null){
			$data = array();
			$this->load->model('client_model');			
			if($parent!='company_form'){
				$this->load->model('lead_model');
				$data['lead_data'] = $this->lead_model->checkOpenProjectData($leadID,$type);
			}			
			$data['type'] = $type;
			$data['parentElement'] = $parent;
			$data['contacts'] = $this->client_model->getAllContacts();
			$this->layout->layout='opportunity';	
			$this->layout->title_for_layout = 'Contact';
			$this->layout->render('opportunity/open_project_contact_form',$data);
		} else {
			echo "Error loading page, Please try after sometime.";
			die;
		}
	}	
	public function emailSetting(){
		$service_url = 'https://www.google.com/accounts/ClientLogin';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt($curl, CURLOPT_POSTFIELDS, "Email=webmaster@synpat.com&Passwd=l3n0v0@123&accountType=GOOGLE&service=apps");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		$response = json_decode($curl_response);
		//print_r($curl_response);
		$authString =  substr($curl_response,strrpos($curl_response,"Auth"));
		$str = explode("=",$authString);
		$service_url = 'https://apps-apis.google.com/a/feeds/emailsettings/2.0/synpat.com/uzi/signature';
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
		curl_setopt($curl, CURLOPT_HTTPGET, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/atom+xml','Authorization: GoogleLogin '.$authString,'| tidy -xml -indent -quiet'));
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
		curl_close($curl);
		if(!empty($curl_response)){
			$xmlString =  substr($curl_response,strrpos($curl_response,"<?xml"));
			$xml = new SimpleXmlElement($xmlString);
			$alias_email = $xml->children('apps', true)->property[0]->attributes();
			if(count($alias_email)>0){
				echo $alias_email['value'];
			}
		}
		die;
	}	
	
	public function contact_list($show='html',$noOfRecords=200) {
		$data = array('contacts'=>array(),'noOfRecords'=>$noOfRecords);
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		if(isset($_POST) && count($_POST)>0){			
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');
			$this->load->model('client_model');
			try{
				$sector = $this->input->post('s');
				$category = $this->input->post('cat');
				$subType = $this->input->post('sst');
				$tech = $this->input->post('t');
				$subTech = $this->input->post('st');
				if(is_array($sector)){
					if(in_array('Unclassify',$sector)){
						$sector = "Unclassify";
					} else {
						$sector = implode(',',$sector);
					}					
				} else {
					$sector = "";
				}
				if(is_array($category)){
					$category = implode(',',$category);
				} else {
					$category = "";
				}
				if(is_array($subType)){
					$subType = implode(',',$subType);
				} else {
					$subType = "";
				}
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				$filterEmail = $this->input->post('filterEmail');
				$filterPhone = $this->input->post('filterPhone');
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$filterCompany = $this->input->post('filterCompany');				
				$filterProfileName = $this->input->post('filterProfileName');				
				$filterTitle = $this->input->post('filterTitle');				
				$leadID = $this->input->post('lead_id');				
				$sort_field = $this->input->post('sort_field');
				$sort_by = $this->input->post('sort_by');
				$getSearchData = $this->client_model->getAllContactsBySectorWithPagingOptimizing($searchString,$sector,$start,$end,$sort_field,$sort_by,$filterEmail,$filterPhone,$filterLinkedin,$filterCompany,$filterProfileName,$filterTitle,$category,$subType,$tech,$subTech,$leadID);
				$data['contacts'] = $getSearchData['list'];
				$data['result'] = $getSearchData['result'];				
				$data['categories'] = $getSearchData['categories'];
				$data['sub_type'] = $getSearchData['sub_type'];
				$data['sub_tech'] = $getSearchData['sub_tech'];
			}catch(Exception $e){}
		} else {
			$this->load->model('client_model');
			/*$data['contacts'] = $this->client_model->getAllContactsWithPaging($noOfRecords);*/
			$data['contacts'] = array();
			$data['companies'] = array();
			/*$data['companies'] = $this->client_model->uniqueCompanies();*/
		}
		if($show=="html"){
			$this->layout->layout='outsource';	
			$this->layout->title_for_layout = 'Contact';
			$this->layout->render('opportunity/contact_list',$data);
		} else {
			echo json_encode($data);
			die;
		}
	}
	
    public function contact($show='html',$noOfRecords=200){   
		$data = array('contacts'=>array(),'noOfRecords'=>$noOfRecords);
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		if(isset($_POST) && count($_POST)>0){			
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');
			$this->load->model('client_model');
			try{
				$sector = $this->input->post('s');
				$category = $this->input->post('cat');
				$subType = $this->input->post('sst');
				$tech = $this->input->post('t');
				$subTech = $this->input->post('st');
				if(is_array($sector)){
					if(in_array('Unclassify',$sector)){
						$sector = "Unclassify";
					} else {
						$sector = implode(',',$sector);
					}					
				} else {
					$sector = "";
				}
				if(is_array($category)){
					$category = implode(',',$category);
				} else {
					$category = "";
				}
				if(is_array($subType)){
					$subType = implode(',',$subType);
				} else {
					$subType = "";
				}
				if(is_array($tech)){
					$tech = implode(',',$tech);
				} else {
					$tech = "";
				}
				if(is_array($subTech)){
					$subTech = implode(',',$subTech);
				} else {
					$subTech = "";
				}
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				$filterEmail = $this->input->post('filterEmail');
				$filterPhone = $this->input->post('filterPhone');
				$filterLinkedin = $this->input->post('filterLinkedIn');
				$filterCompany = $this->input->post('filterCompany');				
				$filterProfileName = $this->input->post('filterProfileName');				
				$filterTitle = $this->input->post('filterTitle');				
				$leadID = $this->input->post('lead_id');				
				$sort_field = $this->input->post('sort_field');
				$sort_by = $this->input->post('sort_by');
				$getSearchData = $this->client_model->getAllContactsBySectorWithPagingOptimizing($searchString,$sector,$start,$end,$sort_field,$sort_by,$filterEmail,$filterPhone,$filterLinkedin,$filterCompany,$filterProfileName,$filterTitle,$category,$subType,$tech,$subTech,$leadID);
				$data['contacts'] = $getSearchData['list'];
				$data['result'] = $getSearchData['result'];				
				$data['categories'] = $getSearchData['categories'];
				$data['sub_type'] = $getSearchData['sub_type'];
				$data['sub_tech'] = $getSearchData['sub_tech'];
			}catch(Exception $e){}
		} else {
			$this->load->model('client_model');
			/*$data['contacts'] = $this->client_model->getAllContactsWithPaging($noOfRecords);*/
			$data['contacts'] = array();
			$data['companies'] = array();
			/*$data['companies'] = $this->client_model->uniqueCompanies();*/
		}
		if($show=="html"){
			$this->layout->layout='outsource';	
			$this->layout->title_for_layout = 'Contact';
			$this->layout->render('opportunity/contact',$data);
		} else {
			echo json_encode($data);
			die;
		}
	}

	public function getContactWithCompanyInfo($contactID = 0) {
		$data = array();
		if($contactID > 0 ) {
			$this->load->model('client_model');
			$data = $this->client_model->findContactWithCompanyinfo($contactID);
		}
		echo json_encode($data);
		die;
	}	
	public function getListOfActiveLeads(){
		$this->load->model('lead_model');
		$leads = $this->lead_model->findIncompleteANDCompleteListByFields(array('id','lead_name'));
		echo json_encode($leads);
		die;
	}
	public function get_users_count_list_companies(){
		$this->load->model('opportunity_model');
		$getList = $this->opportunity_model->get_users_count_list_companies();
		echo json_encode($getList);
		die;
	}
	public function find_departments_bulk(){
		$data = array('deptt'=>array(),'companies'=>array());
		if(isset($_POST) && count($_POST)>0){
			try{
				$sector = $this->input->post('s');
				if(!empty($sector)){
					$sectors = implode(',',json_decode($sector));
					$this->load->model('general_model');
					$this->load->model('client_model');
					$data['deptt'] = $this->general_model->getMultipleSectorDepartmentsName($sectors);
					$data['companies'] = $this->client_model->getAllCompaniesWithMemAndSectorsSelected($sectors);
				}
			} catch(Exception $e){
			}
		}
		echo json_encode($data);
	}	
	public function find_sub_departments_bulk(){
		$data = array('deptt'=>array(),'companies'=>array());
		if(isset($_POST) && count($_POST)>0){
			try{
				$sector = $this->input->post('s');
				$category = $this->input->post('d');
				if(!empty($sector)){
					$deptt = implode(',',json_decode($category));
					$this->load->model('customer_model');
					$this->load->model('client_model');
					$data['deptt'] = $this->customer_model->categoryListWithMoreThanOne($deptt);
					$data['companies'] = $this->client_model->getAllCompaniesWithMemAndSectorsSelectedWithPreference($sector,$deptt,$this->input->post('mode'));
				}
			} catch(Exception $e){
			}
		}
		echo json_encode($data);
	}
	public function find_sub_sub_departments_bulk(){
		$data = array('deptt'=>array(),'companies'=>array());
		if(isset($_POST) && count($_POST)>0){
			try{
				$sector = $this->input->post('s');
				$category = $this->input->post('dep');
				$subCategory =json_decode($this->input->post('sub'));
				$newArray = array_merge($category,$subCategory);
				if(!empty($sector)){
					$this->load->model('client_model');
					$data['companies'] = $this->client_model->getAllCompaniesWithMemAndSectorsSelectedWithPreference($sector,implode(',',$newArray));
				}
			} catch(Exception $e){
			}
		}
		echo json_encode($data);
	}	
	public function companies(){
		redirect('opportunity/sales_contact/0/0');
	}
	/*public function companies($show='html',$noOfRecords=50){
		$data = array('contacts'=>array(),'no_of_records'=>$noOfRecords);
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}		
		$sectors = "";
		$categories = array();
		$subCategories = array();
		$sort = 'c.company_name';
		$sortBy = 'ASC';
		$resultData = array('data'=>array(),'count_all'=>0);
		$this->load->model('customer_model');
		if(isset($_POST) && count($_POST)>0){ 
			$sectors = "";
			$categories = array();
			$subCategories = array();
			$searchString = $this->input->post('search');				
			try{
				$sector = $this->input->post('s');
				$cat = $this->input->post('sst');
				$subCat = $this->input->post('st');
				$sort = $this->input->post('sort_field');
				$sortBy = $this->input->post('sort_by');
				if(is_array($sector)){
					$sector = implode(',',$sector);
				} else {
					$sector = "";
				}
				if(is_array($cat)){
					$cat = implode(',',$cat);
				} else {
					$cat = "";
				}
				if(is_array($subCat)){
					$subCat = implode(',',$subCat);
				} else {
					$subCat = "";
				}				
				$start = $this->input->post('start');
				$end = $this->input->post('end');
				$resultData = $this->customer_model->companyListWithPaging($searchString,$sector,$cat,$subCat,$sort,$sortBy,$start,$end);
			} catch(Exception $e){}	
		} else {			
			$resultData = $this->customer_model->companyListWithPaging('','','','',$sort,$sortBy,0,200);
		}
		$data['companies'] = $resultData['data'];
		if($show=="html"){
			$this->layout->layout='outsource';
			$this->layout->title_for_layout = 'Companies';
			$this->layout->render('opportunity/companies',$data);
		} else {
			echo json_encode($data);
			die;
		}
	}	*/
	public function all_list(){
		$serialNumber = $this->input->get('alx', 0);
		$leadNumber = $this->input->get('plx', 0);
		$data = array();
		$this->load->model('lead_model');
		$data['lead_id'] = 0;
		$data['serial_number'] = 0;
		if($serialNumber==0 && $leadNumber>0){
			$getLeadData = $this->lead_model->getLeadDataWithOptions($leadNumber,'l.id,l.serial_number,l.seller_material_folder_id,l.seller_contact,l.broker_contact,l.broker_person_contact,l.broker_person');
			if(count($getLeadData)>0){
				$data['lead_id'] = $getLeadData->id;
				$serialNumber = $getLeadData->serial_number;
				$data['serial_number'] = $serialNumber;
				$data['lead_seller_contact'] = $getLeadData->seller_contact;
				$data['lead_broker_contact'] = $getLeadData->broker_contact;
				$data['lead_broker_person_contact'] = $getLeadData->broker_person_contact;
				if((int)$getLeadData->broker_person>0){
					$this->load->model('client_model');
					$getInfo = $this->client_model->getInfo($getLeadData->broker_person,'email');
					if(count($getInfo)>0){
						$data['lead_broker_person_contact_email'] = $getInfo->email; 
					}
				}
				if(!empty($getLeadData->seller_material_folder_id)){
					$data['folder_id'] = $getLeadData->seller_material_folder_id;
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$data['driveFiles'] = $service->getFileIDFromChildern($getLeadData->seller_material_folder_id);
				}
			}
		} else if($serialNumber>0 && $leadNumber>0){
			$getLeadData = $this->lead_model->getLeadDataWithOptions($leadNumber,'l.id,l.serial_number,l.seller_material_folder_id,l.seller_contact,l.broker_contact,l.broker_person_contact,l.broker_person');
			if(count($getLeadData)>0){
				$data['lead_id'] = $getLeadData->id;
				$serialNumber = $getLeadData->serial_number;
				$data['serial_number'] = $serialNumber;
				$data['lead_seller_contact'] = $getLeadData->seller_contact;
				$data['lead_broker_contact'] = $getLeadData->broker_contact;
				$data['lead_broker_person_contact'] = $getLeadData->broker_person_contact;
				if((int)$getLeadData->broker_person>0){
					$this->load->model('client_model');
					$getInfo = $this->client_model->getInfo($getLeadData->broker_person,'email');
					if(count($getInfo)>0){
						$data['lead_broker_person_contact_email'] = $getInfo->email; 
					}
				}
				if(!empty($getLeadData->seller_material_folder_id)){
					$data['folder_id'] = $getLeadData->seller_material_folder_id;
					$this->load->library('DriveServiceHelper');
					$service = new DriveServiceHelper();
					$data['driveFiles'] = $service->getFileIDFromChildern($getLeadData->seller_material_folder_id);
				}
			}
		}		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://synpat.com/file_all.php',
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => array(
				's' => 0,
				'serial_number'=>$serialNumber
			)
		));
		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		$data['lists'] = array();
		$data['single_data'] = array();
		if($resp!=""){
			$getAllData = json_decode($resp);
			if(isset($getAllData->all_list) && isset($getAllData->single_data)){
				/**/
				$data['lists'] = $getAllData->all_list;
				$data['single_data'] = $getAllData->single_data;
			}
			
			$data['lead_number'] = $leadNumber;
			$data['serial_number'] = $serialNumber;
		}	
		$this->layout->layout='opportunity';	
		$this->layout->title_for_layout = 'Synpat.com Patent Form List';
		$this->layout->render('opportunity/all_list',$data);
	}	
	
	public function find_seller_materials(){
		$data = array();
		$this->folderList = array();
		$this->filesList = array();
		if(isset($_POST['sr']) && (int)$_POST['sr']>0){
			$this->load->model('lead_model');
			$getLeadData = $this->lead_model->findSerialNumber($_POST['sr']);
			if(count($getLeadData)>0 && !empty($getLeadData->seller_material_folder_id)){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$this->getChildFolders($service,$getLeadData->seller_material_folder_id);
				$data = $this->filesList;				
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function getChildFolders($service,$folderID) {
		$list = $service->getFileIDFromChildern($folderID);
		if(count($list) > 0 ) {
			$folderList = array();
			foreach($list as $file) {
				if($file->mimeType == "application/vnd.google-apps.folder"){
					array_push($folderList,$file->id);
				} else {
					if($file->mimeType != "application/zip" && $file->mimeType != "application/octet-stream"){
						array_push($this->filesList,$file);
					}
				}
			}
			foreach($folderList as $folder) {
				$this->getChildFolders($service,$folder);
			}
		}
	}
	
	public function delete_request_lead(){
		$data = "0";
		if(isset($_POST) && count($_POST) > 0){
            $getData = $this->input->post();
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'http://appadmin.synpat.com/index.php/Users/delete_request_lead',
				CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					'i' => $getData['i']
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
	public function delete_web_lead(){
		$data = "0";
		if(isset($_POST) && count($_POST) > 0){
            $getData = $this->input->post();
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'https://synpat.com/delete_request_lead.php',
				CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => array(
					'i' => $getData['i']
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
	public function sr_attached(){
		if(isset($_POST) && count($_POST) > 0){
            $getData = $this->input->post();
			if($getData['sr']!="0"){
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'https://synpat.com/update_data.php',
					CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						'id' => $getData['contact'],
						"serial_number"=>$getData['sr']
					)
				));
				// Send the request & save response to $resp
				$resp = curl_exec($curl);
				if($resp){
					/*if($resp !=""){
						try{
							$dataResp = json_decode($resp);
							if(count($dataResp)>0){
								$sellerFirm = "";
								$brokerFirm = "";
								$brokerName = "";
								if(isset($dataResp->type_name){
									$sellerFirm = $dataResp->type_name;
								}
								if(isset($dataResp->broker){
									$brokerFirm = $dataResp->broker;
								}
								$leadData = array();
								if(!empty($sellerFirm) || !empty($brokerFirm)){
									
									$this->load->model('client_model');
									if(!empty($sellerFirm)){
										$findSellerFirm = $this->client_model->find_contact_by_name($sellerFirm);
										if(count($findSellerFirm)>0){
											$leadData['seller_contact'] = $findBrokerFirm->company_name;
											$leadData['plantiffs_name'] = $findBrokerFirm->company_id;
											$leadData['person_name_1'] = $findBrokerFirm->name;
											$leadData['person_title_1'] = $findBrokerFirm->id;
										}
									}
									if(!empty($brokerFirm)){
										$findBrokerFirm = $this->client_model->find_contact_by_name($brokerFirm);
										if(count($findBrokerFirm)>0){
											$leadData['broker_contact'] = $findBrokerFirm->company_name;
											$leadData['broker'] = $findBrokerFirm->company_id;
											$leadData['broker_person_contact'] = $findBrokerFirm->name;
											$leadData['broker_person'] = $findBrokerFirm->id;
										}
									}
								}
								if(count($leadData)>0){
									$this->load->model('lead_model');
									$this->lead_model->from_litigation_update($getData['lead'],$leadData);
								}
							}
						}catch(Exception $e){
							
						}
					}*/
					echo $resp;
				}
			}
		}
		die;
	}
    
}

/* End of file opportunity.php */
/* Location: ./application/controllers/opportunity.php */