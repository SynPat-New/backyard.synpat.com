<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leads extends CI_Controller {
	public $_import_contacts_data = array();
	public $skey = "sYnP@TpRoJ3cT5@%"; // you can change it
	public $applicationList = array(
							   'US'=>array('A1','A2','A9','A'),
							   'CN'=>array('A','A8','A9'),
							   'AU'=>array('A','A0','S','A1','A3'),
							   'CA'=>array('A1'),
							   'DE'=>array('A','D1','D2'),
							   'EP'=>array('A','A1','A2','A3','A4','A8','A9'),
							   'JP'=>array('A','A5','A6'),
							   'WO'=>array('A1','A2','A3','A4','A','W'),
							   'KR'=>array('A','A2'),
							   'AP'=>array('A0'),
							   'AR'=>array('A','A1','A2','A3','A4'),
							   'AT'=>array('A','A1','A2','A3','A4','A5','A8','A9'),
							   'BE'=>array('A','A1','A2','A3','A4','A5','A8','A9'),
							   'BG'=>array('A','A1','A2','A3','A4'),
							   'BO'=>array('A'),
							   'BR'=>array('A','D0','S','A2','A8','A9'),
							   'CH'=>array('A','A1','A2','A3','A4','A5'),
							   'CL'=>array('A','A1','A2','A3'),
							   'CO'=>array('A','A1','A2','A3'),
							   'CR'=>array('A','A4','A3','U','S'),
							   'CS'=>array('A','A1','A2','A3'),
							   'CU'=>array('A','A1','A2','A3','A4','A5','A6','A7'),
							   'CY'=>array('A','A1'),
							   'CZ'=>array('A','A3'),
							   'DD'=>array('A','A1','A2','A3','A4','A5','A6','A7','A8','A9'),
							   'DK'=>array('A','A1','A8','A9'),
							   'DO'=>array('A'),
							   'EA'=>array('A','A1','A2','A3','A8','A9'),
							   'EC'=>array('A','S','U'),
							   'EE'=>array('A','A1'),
							   'TW'=>array('A','A1','A2','A3','A4','A5','A6','A7')
							   );
	function __construct(){
		parent::__construct();
		$this->load->library('DriveServiceHelper'); 
		$service = new GmailServiceHelper();
		$skipMethods = array('remove_precontacts','pre_contacts','update_companies_from_duplicates','business_cards_list','delete_scan_card','patent_illustration','illustration_store','patent_family_list','illustration_all_store','assigment_illustration_store','findCPCParentChild','getCPCXML','family_data','patent_assignment_illustration','patent_assignment_with_number');
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
	
	function importComparablesDataFromSpreadsheet(){
		$ss_id="1LgjvT5N9Zj7j3I2vbkacKqqluP1o8GMZpvdblAjPXFo";
		$this->load->library('DriveServiceHelper');
		$spreadSheetService = new SpreadsheetServiceHelper();
		$spreadsheet = $spreadSheetService->getSpreadsheetById($ss_id);
		$allWorkSheet = $spreadSheetService->getAllWorkSheets();
		$workSheetName = "Sheet1";
		$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
		$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());	
		if(count($asset_data)>0){
			$this->load->model('lead_model');
			for($i=0;$i<count($asset_data);$i++){
				$url = $fileUrl['link2'];
				$fileContent = file_get_contents($url);
				if(strpos($fileContent,"We can't find this file") === false){
					$fileType = strtolower(pathinfo($url,PATHINFO_EXTENSION));
					$name = pathinfo($url,PATHINFO_FILENAME);
					$fileName = $name.".".$fileType;
					$checkUrl = $this->lead_model->checkAgreementFile($fileName);
					if(count($checkFileUrl) == 0){
						$target_file = $target_dir.$fileName;
						if(file_exists($target_file)){
							unlink($target_file);
						}
						copy($url, $target_file);
						if(file_exists($target_file)){
							$postData = array();
							$postData['agreement_url'] = $fileName;
							$postData['created_date'] = date('Y-m-d H:i:s');
							$this->lead_model->insertAgreements($postData);
						}
					}
				} else {
					echo "No doc found!";
				}
				die;				
			}
		}
		die;
	}
	
	function updateAllBUttonsSort(){
		$this->load->model('lead_model');
		$this->lead_model->updateAllBUttonsSort();
		die;
	}
	public function index()
	{
		$this->layout->auto_render=false;		
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('client/index');
	}
	
	public function remove_all_garbage_specialities($start,$end){
		$this->load->model('customer_model');
		$this->customer_model->remove_all_garbage_specialities($start,$end);
		die;
	}
	
	public function importAllPanjiva(){
		$this->load->library('DriveServiceHelper');
		$spreadSheetService = new SpreadsheetServiceHelper();
		$spreadsheet = $spreadSheetService->getSpreadsheetById('1Zt6Ob24jjLgDa9B-qcdCtBzt8ECf7-p0dr27sEMPpS8');
		$workSheetName = "Sheet1";
		$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
		$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());
		$companies = array();
		foreach($asset_data as $company){
			if($company['company'] != ""){
				$companyFound = false;
				if(count($companies) > 0){
					$i = 0;
					foreach($companies as $c){
						if(strtolower(trim($c['name'])) == strtolower(trim($company['company']))){
							$companies[$i]['hts_code'] .= ",".$company['code'];
							$companyFound = true;
							break;
						}
						$i++;
					}
				}
				if($companyFound === false){
					array_push($companies,array('hts_code'=>$company['code'],'name'=>trim($company['company'])));
				}
			}			
		}
		$this->load->model('lead_model');
		$this->lead_model->addPanjivaCompaniesInBulk($companies);
		die;
	}
	
	public function importCIPO(){
		$this->load->library('DriveServiceHelper');
		$spreadSheetService = new SpreadsheetServiceHelper();
		$spreadsheet = $spreadSheetService->getSpreadsheetById('11Rp9mpw07d_AQkHD3eW-KzoKXufEARPO4vNJCCnAPdI');
		$workSheetName = "CIPO";
		$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
		$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());
		$companies = array();
		$this->load->model('client_model');
		$allContact = array();
		echo count($asset_data);
		$counter = 0;
		$found  = 0;
		$notfound  = 0;
		$foundArray = array();
		foreach($asset_data as $contact){
			if($contact['profileurl'] != ""){
				$counter++;
				$getInfo = $this->client_model->find_contact_by_linkedin($contact['profileurl']);
				if(count($getInfo) == 0){
					$checkUser = false;
					if(count($allContact) > 0){
						foreach($allContact as $c){
							if($c['linkedin_url'] == $contact['profileurl']){
								$checkUser = true;
								break;
							}
						}
					}
					if($checkUser === false){
						array_push($allContact,array('first_name'=>$contact['firstname'],'last_name'=>$contact['lastname'],'linkedin_url'=>$contact['profileurl'],'current_company'=>$contact['company'],'job_title'=>$contact['title'],'import_list'=>5));
						$notfound++;
					}
				} else {
					$found++;
					if((int)$getInfo->import_list == 0){
						array_push($foundArray,$getInfo->id);
					}
				}
			}
		}
		echo "Counter:".$counter."<br/>";
		echo "Found:".$found."<br/>";
		echo "Notfound:".$notfound."<br/>";
		echo "<pre>";
		print_r($allContact);
			echo implode(',',$foundArray);
			echo "</pre>";
		if(count($allContact) > 0){
			echo "INSERT<br/>";
			$this->client_model->insertContactsInBatch($allContact);
		}
		die;
		foreach($asset_data as $contact){
			if($contact['profileurl'] != ""){
				$getInfo = $this->client_model->find_contact_by_linkedin($contact['profileurl']);
				if(count($getInfo) == 0){
					array_push($allContact,array('first_name'=>$contact['firstname'],'last_name'=>$contact['lastname'],'linkedin_url'=>$contact['profileurl'],'current_company'=>$contact['company'],'job_title'=>$contact['title'],'import_list'=>1));
				} else {
					echo "<pre>";
					print_r($getInfo);
					echo "</pre>";
					$this->client_model->update($getInfo->id,array('found_import'=>1,'import_list'=>1));
				}
			}			
		}
		if(count($allContact) > 0){
			echo "<pre>";
			print_r($allContact);
			echo "</pre>";
			$this->client_model->insertContactsInBatch($allContact);
		}
		die;
	}
	
	public function litigation_scrape($leadID){
		if($leadID > 0){
			$this->load->model('lead_model');
			if(isset($_POST) && count($_POST) > 0){
				$url = $this->input->post('scrape_url');
				$data = array('id'=>0,'count'=>0);
				if($url != ""){
					$checkUrl  = $this->lead_model->checkLitigationScrapeURL($leadID,$url);
					$data['count'] = count($checkUrl);
					if(count($checkUrl) == 0){
						$data['id'] = $this->lead_model->insertLitigationScrape(array('url'=>$url,'lead_id'=>$leadID));
					}
				}
				echo json_encode($data);
				die;
			}
			$data = array();
			$data['lead_id'] = $leadID;
			$data['lead_litigation_scrape'] = $this->lead_model->getLitgationScrapeData($leadID);
			$this->layout->auto_render=false;	
			$this->layout->layout='outsource';
			$this->layout->title_for_layout = 'Litigation Scrape';
			$this->layout->render('leads/litigation_scrape',$data);
		} else {
			echo "Please select lead first.";
			die;
		}		
	}
	
	function litigation_scrape_data_show($leadID){
		$data = 0;
		if($leadID > 0){
			$this->load->model('lead_model');
			if(isset($_POST) && count($_POST) > 0){
				$data = $this->lead_model->updateLeadLitigation(array('show'=>$this->input->post('show')),$this->input->post('id'));
			}
		}
		echo $data;
		die;
	}
	
	public function patent_family_list($leadID){
		$this->load->model('lead_model');
		$data = array();
		$data['family_data'] = $this->lead_model->getAllEPOFamilies($leadID);
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
	
	public function iiflfamilysimple($patent){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://cdws21.ificlaims.com/family/simple?ucid=".$patent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = [
			'x-user:Syn_prem',
			'x-password:Elephantdancer200'
		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		echo "<pre>";
		print_r($server_output) ;
		die;
	}
	
	public function iiflfamilyextended($patent){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://cdws21.ificlaims.com/family/extended?ucid=".$patent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = [
			'x-user:Syn_prem',
			'x-password:Elephantdancer200'
		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		echo "<pre>";
		print_r($server_output) ;
		die;
	}
	
	public function iiflfamilymeta($patent){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://cdws21.ificlaims.com/family/meta/dn?id=".$patent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = [
			'x-user:Syn_prem',
			'x-password:Elephantdancer200'
		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		echo "<pre>";
		print_r($server_output) ;
		die;
	}
	
	public function iifltext($patent){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://cdws21.ificlaims.com/text/fetch?ucid=".$patent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$headers = [
			'x-user:Syn_prem',
			'x-password:Elephantdancer200'
		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		echo "<pre>";
		print_r($server_output) ;
		die;
	}
	
	public function read_parent_child_csv_file($start,$end){
		$row = 1;
		$fileName = $_SERVER['DOCUMENT_ROOT'].'/public/upload/application_data.csv';
		$this->load->model('lead_model');
		if (($handle = fopen($fileName, "r")) !== FALSE) {
			/*for ($i = 0; $row = fgetcsv($handle ); ++$i) {
				if($i>0){
					print_r($row);
					die;
				}
			}*/
			$i=0;
			
			/*$insert = "INSERT INTO lead_patent_family_parent_child (patent_app_number,`parent`,child,relation_number,relation_type,family_id,filed_date) VALUES ";*/
			
			while ( ($data = fgetcsv($handle) ) !== FALSE ) {
				//process
				if($i>$start && $i<=$end){
					$applicationNumber = $data[0];
					if(substr($applicationNumber,0,1)==0){
						$applicationNumber = substr($applicationNumber,1);
					}
					$fillingDate = $data[1];
					$applicationType = $data[3];
					$examinName = "";
					if(trim($data[5])!="None"){
						$examinName = $data[5]." ".$data[4];
					}
					$groupArtUnit = $data[8];
					$confirmNumber = $data[11];
					$attorneyDocNumber = $data[13];
					$classSubClass = $data[9];
					if($classSubClass !=""){
						$classSubClass = "-".$data[10];
					}
					$firstNameInventor= "";
					$patentNumber = $data[21];
					$applicationStatusDate = $data[15];
					$patentIssueDate = $data[22];
					$status="";
					if($data[24]=="ABN"){
						$status = "Abandoned";
					} else if($data[24]=="ISS"){
						$status = "Patented Case";
					}
					$country = "US";
					$insert = "INSERT INTO patent_illustration_detail (patent_app_number,application_number,filling_date,application_type,examiner_name,group_art_unit,confirmation_number,country,attorney_docket_number,class_subclass,status,status_date,patent_number,issue_date_of_patent) VALUES ";
					$insert .='("'.$applicationNumber.'","'.$applicationNumber.'","'.$fillingDate.'","'.$applicationType.'","'.$examinName.'","'.$groupArtUnit.'","'.$confirmNumber.'","'.$country.'","","'.$classSubClass.'","'.$status.'","'.$applicationStatusDate.'","'.$patentNumber.'","'.$patentIssueDate.'")';
					/*$insert = substr($insert,0,-2);*/
					echo $i.":". $this->lead_model->runQuery($insert)."<br/>";
					/*$relationNumber = $data[1];
					if(substr($relationNumber,0,1)==0){
						$relationNumber = substr($relationNumber,1);
					}
					if(is_numeric($relationNumber) && is_numeric($patentAppNumber)){
						$fillingDate = $data[2];
						$relationType = $data[3];
						$insert .='("'.$patentAppNumber.'",0,1,"'.$relationNumber.'","'.$relationType.'",0,"'.$fillingDate.'"), ';
					}*/
				}
				$i++;
			}
			
			fclose($handle);
			
			
			//echo "<br/>".$insert;
		}	
		die;
	}
	
	public function biblioData($publication,$db,$patent,$equivalents=''){
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$epoDocToken = $this->epodoc->read_token('HedCET');	
		if($equivalents!=""){
			$equivalents = implode(',',explode('-',$equivalents));
		}
		/*$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data',$publication,$db,$patent,$equivalents,'');*/
		/*$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data',$publication,$db,$patent,'equivalents',$equivalents);
		$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data','publication','docdb',$patent,'images','');*/
		/*$getFamilyData = $this->epodoc->runUrl($epoDocToken,'family',$publication,$db,$patent,'','');*/
		/*$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data','publication','epodoc',$patent,'abstract','');
		$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data','publication','epodoc',$patent,'biblio','');*/
		/*$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data','publication','epodoc',$patent,'abstract','');*/
		/*$getFamilyData = $this->epodoc->runUrl($epoDocToken,'family',$publication,$db,$patent,'','');*/
		$getFamilyData = $this->epodoc->runUrl($epoDocToken,'family',$publication,$db,$patent,'','');
		/*$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data','publication','epodoc',$patent,'biblio','');*/
	/*	$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data',$publication,$db,$patent,'biblio,abstract','');*/
		print_r($getFamilyData['data']);
		die;
	}
	
	public function legalBiblioData($publication,$db,$patent) {
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$epoDocToken = $this->epodoc->read_token('HedCET');	
		//$getFamilyData = $this->epodoc->runUrl($epoDocToken,'legal',$publication,$db,$patent,'','');
		$getBiblioData = $this->epodoc->runUrl($epoDocToken,'published-data',$publication,'epodoc',$patent,'biblio,abstract','');
		print_r($getBiblioData['data']);
		die;
	}
	
	public function findPatentAbstract($patent,$pub = 'publication',$kind){
		$abstractString = array('title'=>'','abstract'=>'','priority_date'=>'','assignee'=>'','applicant'=>'','inventor'=>array());
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$epoDocToken = $this->epodoc->read_token('HedCET');	
		/*$getBiblioData = $this->epodoc->runUrl($epoDocToken,'published-data',$pub,'epodoc',$patent,'abstract','');*/
		$worldPatentData = "";
		$getBiblioData = $this->epodoc->runUrl($epoDocToken,'published-data',$pub,'epodoc',$patent,'biblio,abstract','');
		
		if(empty($getBiblioData['error'])){
			if(!empty($getBiblioData['data'])){
				$xml=simplexml_load_string($getBiblioData['data']);
				if ($xml !== false) {
					$xmlObject = new SimpleXMLElement($getBiblioData['data']);
					try{
						if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && $xmlObject->message=="No results found"){
							$getBiblioData = $this->epodoc->runUrl($epoDocToken,'published-data',$pub,'epodoc',$patent.$kind,'biblio,abstract','');
							if(empty($getBiblioData['error'])){
								if(!empty($getBiblioData['data'])){
									$xml=simplexml_load_string($getBiblioData['data']);
									if ($xml !== false) {
										$xmlObject = new SimpleXMLElement($getBiblioData['data']);
										try{
											if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && $xmlObject->message=="No results found"){
												
											}else {
												$worldPatentData = $xmlObject->xpath('//ops:world-patent-data');
											}
										}catch(Exception $e){
											
										}
									}
								}
							}
						} else{				
							$worldPatentData = $xmlObject->xpath('//ops:world-patent-data');
						}
					}catch(Exception $e){}					
				}
			}
		}
		try{
			if(isset($worldPatentData[0])){
				$exchangeDocuments = $worldPatentData[0]->{'exchange-documents'};
				$exchangeDocumentList = $exchangeDocuments->{'exchange-document'};
				if(count($exchangeDocumentList)>0){
					$abs = $exchangeDocumentList[0]->{'abstract'};
					$abstractString['abstract'] = (string)$abs->p;
					$abstractString['title'] =  (string)$exchangeDocumentList[0]->{'bibliographic-data'}->{'invention-title'};
					$parties = $exchangeDocumentList[0]->{'bibliographic-data'}->{'parties'};
					if(count($parties)>0){
						$inventors = $parties[0]->{'inventors'}->{'inventor'};
						$listInventor = array();
						if(count($inventors)>0){
							foreach($inventors as $inventor){
								if($inventor['data-format']=="original"){
									array_push($listInventor,(string)$inventor->{'inventor-name'}->name);
								}
							}
						}						
						$abstractString['inventor'] = $listInventor;
						$applicants = $parties[0]->{'applicants'}->{'applicant'};
						$applicantList = array();
						if(count($applicants)>0){
							foreach($applicants as $applicant){
								if($applicant['data-format']=="original"){
									$applicantName = trim((string)$applicant->{'applicant-name'}->name);
									if(substr($applicantName,-1) == ","){
										$applicantName = substr($applicantName,0,-1);
									}
									array_push($applicantList,$applicantName);
								}
							}
							/*foreach($applicants as $applicant){
								if($applicant['data-format']=="original"){
									if((int)$applicant['sequence']==2){
										$abstractString['applicant'] = (string)$applicant->{'applicant-name'}->name;
									} else if((int)$applicant['sequence']==1){
										$abstractString['assignee'] = (string)$applicant->{'applicant-name'}->name;
									}
								}
							}
							if($kind !="US") {
								if($abstractString['assignee'] != "") {
									if($abstractString['applicant'] == "") {
										$abstractString['applicant'] = $abstractString['assignee'];
										$abstractString['assignee'] = "";
									}
								}
							}*/
						}	
						$abstractString['applicant'] = $applicantList;
					}
					
					$priorityClaims = $exchangeDocumentList[0]->{'bibliographic-data'}->{'priority-claims'};
					if(count($priorityClaims)>0){
						$priorityClaim = $priorityClaims[0]->{'priority-claim'};
						$priorityDocIds = $priorityClaim->{'document-id'};
						foreach($priorityDocIds as $docID){
							if($docID['document-id-type']=="epodoc"){
								$abstractString['priority_date'] = (string)$docID->{'date'};
							}
						}
					}
					/*CPC*/
					$patentClassifications = $exchangeDocumentList[0]->{'bibliographic-data'}->{'patent-classifications'};
					$classifications = $patentClassifications->{'patent-classification'};
					$classificationList = array();
					if(count($classifications)>0){
						foreach($classifications as $classification){
							$classificationScheme = $classification->{'classification-scheme'};
							if($classificationScheme['scheme']=="CPC"){
								$section = (string)$classification->{'section'};
								$class = (string)$classification->{'class'};
								$subclass = (string)$classification->{'subclass'};
								$mainGroup = (string)$classification->{'main-group'};
								$subGroup = (string)$classification->{'subgroup'};
								array_push($classificationList,$section.$class.$subclass.$mainGroup.'/'.$subGroup);
							}
						}
					}
					$abstractString['classifications'] = implode(',',$classificationList);	
				}
			}
		}catch(Exception $e){}
		/*echo "<pre>";
		print_r($abstractString);
		die;*/
		return $abstractString;
	}
	
	public function readMultipleXMl(){
		
		    
		$xml_file_path = $_SERVER['DOCUMENT_ROOT'].'/public/upload/pg030225.XML';
		$doc = new DOMDocument();
		$doc->loadHTML($xml_file_path);
		print_r($doc->getElementsByTagName('PATDOC'));
		die;
		$XMLReader = new XMLReader;          
		$XMLReader->open($xml_file_path); 
		while ($XMLReader->read()){
			echo "<pre>";print_r($XMLReader->readOuterXML());die;
			 $node = new SimpleXMLElement($XMLReader->readOuterXML());
			 
			 print_r($node);
		}		
		die;
	}
	
	public function runWebDriverScrapper($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$content = curl_exec($ch);
		curl_close($ch);
		return $content;
	}
	
	public function findClaim($patent,$countryCode,$pub='publication',$kind='',$date='',$pubDate='',$pubKind=''){
		/*$claim = "";
		set_time_limit(0);
		$content =  $this->executeCurlOld($patent);
		echo $content ;die;
		if(!empty($content)){
			$this->load->library('simple_html_dom');
			$html = $this->simple_html_dom->load($content,true,true);
			try{
				if(is_object($html) && isset($html->nodes)):
					$div = $html->find('div.claims',0);
					if(count($div)>0){
						$claim =  $div->innertext;
					} else {
						$div = $html->find('div[id="CLM-00001"]',0);
					}
				endif;
			}catch(Exception $e){
				
			}
		}*/
		$content = "";
		if(!empty($patent)){
			$apiAccessPatentCountries = array('EP','WO','AT','CA','CH','GB','FR','ES');
			if(!in_array($countryCode,$apiAccessPatentCountries)){
				if($countryCode=="US"){
					/*$url = "http://webdriverforscrape.site/abstract.php?patent=".$patent.$kind;*/
					$patent = str_replace($countryCode,'',$patent);
					$orgPatent = $patent;
					$patent = $patent.$kind;					
					$url = "http://webdriverforscrape.site/epo.php?nr=".$patent."&cc=".$countryCode."&kc=".$kind."&date=".$pubDate;
					$content = $this->runWebDriverScrapper($url);
					$content = trim($content);
					if(strlen($content)<100){
						$patent = $orgPatent.$pubKind;
						$url = "http://webdriverforscrape.site/epo.php?nr=".$patent."&cc=".$countryCode."&kc=".$pubKind."&date=".$pubDate;
						$content = $this->runWebDriverScrapper($url);
						$content = trim($content);
						if(strlen($content)<100){
							$patent = $patent.$kind;
							$url = "http://webdriverforscrape.site/epo.php?nr=".$patent."&cc=".$countryCode."&kc=".$kind."&date=".$date;
							$content = $this->runWebDriverScrapper($url);
							$content = trim($content);
							if(strlen($content)<100){
								$patent = $orgPatent.$pubKind;
								$url = "http://webdriverforscrape.site/epo.php?nr=".$patent."&cc=".$countryCode."&kc=".$pubKind."&date=".$date;
								$content = $this->runWebDriverScrapper($url);
								$content = trim($content);
							}
						}
					}
				} else {
					/*scrape from epo website*/
					$patent = str_replace($countryCode,'',$patent);
					$orgPatent = $patent;
					$patent = $patent.$kind;
					$url = "http://webdriverforscrape.site/epo.php?nr=".$patent."&cc=".$countryCode."&kc=".$kind."&date=".$pubDate;
					//echo $url."<br/>";
					$content = $this->runWebDriverScrapper($url);
					$content = trim($content);
					if(strlen($content)<100){
						$patent = $orgPatent.$pubKind;
						$url = "http://webdriverforscrape.site/epo.php?nr=".$patent."&cc=".$countryCode."&kc=".$pubKind."&date=".$pubDate;
						$content = $this->runWebDriverScrapper($url);
						$content = trim($content);
						if(strlen($content)<100){
							$patent = $patent.$kind;
							$url = "http://webdriverforscrape.site/epo.php?nr=".$patent."&cc=".$countryCode."&kc=".$kind."&date=".$date;
							$content = $this->runWebDriverScrapper($url);
							$content = trim($content);
							if(strlen($content)<100){
								$patent = $orgPatent.$pubKind;
								$url = "http://webdriverforscrape.site/epo.php?nr=".$patent."&cc=".$countryCode."&kc=".$pubKind."&date=".$date;
								$content = $this->runWebDriverScrapper($url);
								$content = trim($content);
							}
						}
					}
				}				
			} else{
				/*ini_set('memory_limit', '4096M');*/
				$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
				$epoDocToken = $this->epodoc->read_token('HedCET');	
				$getClaimsData = $this->epodoc->runUrl($epoDocToken,'published-data',$pub,'epodoc',$patent,'claims','');
				if(empty($getClaimsData['error'])){
					if(!empty($getClaimsData['data'])){
						$xml=simplexml_load_string($getClaimsData['data']);
						if ($xml !== false) {
							$xmlObject = new SimpleXMLElement($getClaimsData['data']);
							try{
								if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && $xmlObject->message=="No results found"){
								} else{				
									$worldPatentData = $xmlObject->xpath('//ops:world-patent-data');
									
									if(isset($worldPatentData[0])){
										$worldPatentData[0]->registerXPathNamespace('ftxt', 'http://www.epo.org/fulltext');
$fulltextDocuments = $worldPatentData[0]->xpath('//ftxt:fulltext-documents');
									
										$fulltextDocument = $fulltextDocuments[0]->xpath('//ftxt:fulltext-document');
									if(isset($fulltextDocument[0]->{'claims'})>0){
											$claims = $fulltextDocument[0]->{'claims'};
											if(count($claims)>0){
												foreach($claims as $claim){
													if($claim['lang']=='EN'){
														$claimT = $claim->{'claim'};
														if(isset($claimT->{'claim-text'}) && count($claimT->{'claim-text'})>0){
															$content = "<p>".(string)$claimT->{'claim-text'}[0]."</p>";
															/*foreach($claimT->{'claim-text'} as $text){
											$content .= "<p>".$text."</p>";
															}*/
														}
													}
												}
											}
										}
									}
								}
							} catch(Exception $e){
								
							}
						}
					}
				}
			}			
		}
		if(strpos($content,"installed.js")!==false){
			$str = strpos($content,"</script>");
			$content = substr($content,$str + 9);
			if(strpos($content,"leaf")!==false){
				$content = "<ul id='claimsTree' class='filetree treeview' width='100%'>".$content;
			}
		}
		return $content;
	}
	
	public function patent_legal($publication,$db,$patent){
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$epoDocToken = $this->epodoc->read_token('HedCET');	
		$getFamilyData = $this->epodoc->runUrl($epoDocToken,'legal',$publication,$db,$patent,'','');
		$allLegalData = array();
		if(!empty($getFamilyData['data'])){
			try{
			$xml=simplexml_load_string($getFamilyData['data']);
			if ($xml !== false) {				
				$xmlObject = new SimpleXMLElement($getFamilyData['data']);
				if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && $xmlObject->message=="No results found"){
					$allLegalData = array();
				} else{
				$patentObject = $xmlObject->xpath('//ops:patent-family');
				if(isset($patentObject[0])){
					$familyMember = $patentObject[0]->xpath('//ops:family-member');
					$legalObject = $familyMember[0]->xpath('//ops:legal');
					for($i=0;$i<count($legalObject);$i++){
						$lD = array();
						$dd = $legalObject[$i]->xpath('ops:L007EP');
						$lD['date'] = (string)$dd[0];
						$lD['code'] = (string)$legalObject[$i]['code'];
						$lD['title'] = (string)$legalObject[$i]['desc'];
						$attributes = $legalObject[$i]->xpath('ops:L500EP');
						$lD['description'] = array();
						if(trim($lD['code'])=="AS"){
							$owner = $attributes[0]->xpath('ops:L509EP');
							$lD['description'][] = array('label'=>(string)$owner[0]['desc'],'value'=>(string)$owner[0]);
							$freeFormat = $attributes[0]->xpath('ops:L510EP');
							$lD['description'][] = array('label'=>(string)$freeFormat[0]['desc'],'value'=>(string)$freeFormat[0]);
							$effectiveDt = $attributes[0]->xpath('ops:L525EP');
							$lD['description'][] = array('label'=>(string)$effectiveDt[0]['desc'],'value'=>(string)$effectiveDt[0]);
						} else {
							$att = $attributes[0]->xpath('ops:L520EP');
							$lD['description'][] = array('label'=>(string)$att[0]['desc'],'value'=>(string)$att[0]);
						}
						$allLegalData[] = $lD;
					}
				}
				}
			}
			}catch(Exception $e){
				
			}
		}
		return $allLegalData;
	}
	
	public function patent_images($publication,$db,$patent,$equivalents){
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$epoDocToken = $this->epodoc->read_token('HedCET');	
		$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data',$publication,$db,$patent,$equivalents,'');
		$patImages = array();
		if(!empty($getFamilyData['data'])){
			try{
			$xml=simplexml_load_string($getFamilyData['data']);
			if ($xml !== false) {
				$xmlObject = new SimpleXMLElement($getFamilyData['data']);
				if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && $xmlObject->message=="No results found"){
					$patImages = array();
				} else{
				$patentObject = $xmlObject->xpath('//ops:inquiry-result');
				if(isset($patentObject[0])){
					$mainDocumentReference = $patentObject[0]->xpath('//ops:document-instance');
					if(count($mainDocumentReference)>0){
						foreach($mainDocumentReference as $documentR){
							$imageLink =  (string)$documentR['link'];
							if((string)$documentR['desc']=='Drawing' || (string)$documentR['desc']=='FirstPageClipping'){
								$noOfPages = $documentR['number-of-pages'];
								if($noOfPages>0){
									for($i=1;$i<=$noOfPages;$i++){
										$accept = 'application/tiff';
										$getImagePDFData = $this->epodoc->singleUrl($epoDocToken,$accept,$imageLink.".tiff?Range=".$i);
										if(isset($getImagePDFData['data']) && $getImagePDFData['data']!=''){
											$imageType = array_pop(explode('/',$imageLink));
											$fileName = $patent.'_'.$imageType."_".$documentR['desc']."_".$i.".tiff";
											if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName)){
												$f = fopen($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName,"w+");
												fwrite($f, $getImagePDFData['data']);
												fclose($f);
											}
											if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName)){
												if($fileName != "") {
													$patImages[] = 'https://backyard.synpat.com/public/temp/'.$fileName;
												}	
											}
											//$patImages[] = 'https://backyard.synpat.com/public/temp/'.$fileName;
										}
									}
								}
							}
						}
					}
				}
				}
			}
			}catch(Exception $e){
				
			}
		}
		return $patImages;
	}
	
	public function patent_full_page_image($publication,$db,$patent,$equivalents){
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$epoDocToken = $this->epodoc->read_token('HedCET');	
		$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data',$publication,$db,$patent,$equivalents,'');
		$patImages = array();
		if(!empty($getFamilyData['data'])){
			try{
			$xml=simplexml_load_string($getFamilyData['data']);
			if ($xml !== false) {
				$xmlObject = new SimpleXMLElement($getFamilyData['data']);
				if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && $xmlObject->message=="No results found"){
					$patImages = array();
				} else{
				$patentObject = $xmlObject->xpath('//ops:inquiry-result');
				if(isset($patentObject[0])){
					$mainDocumentReference = $patentObject[0]->xpath('//ops:document-instance');
					if(count($mainDocumentReference)>0){
						foreach($mainDocumentReference as $documentR){
							$imageLink =  (string)$documentR['link'];
							if((string)$documentR['desc']=='Drawing'){
								
								$noOfPages = $documentR['number-of-pages'];
								if($noOfPages>0){
									for($i=1;$i<=$noOfPages;$i++){
										$accept = 'application/pdf';
										$getImagePDFData = $this->epodoc->singleUrl($epoDocToken,$accept,$imageLink.".pdf?Range=".$i);
										if(isset($getImagePDFData['data']) && $getImagePDFData['data']!=''){
											$imageType = array_pop(explode('/',$imageLink));
											$fileName = $patent.'_'.$imageType."_".$documentR['desc']."_".$i.".pdf";
											if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName)){
												$f = fopen($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName,"w+");
												fwrite($f, $getImagePDFData['data']);
												fclose($f);
											}
											if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName)){
												if($fileName != "") {
													$patImages[] = 'https://backyard.synpat.com/public/temp/'.$fileName;
												}	
											}
											//$patImages[] = 'https://backyard.synpat.com/public/temp/'.$fileName;
										}
										break;
									}
								}
							}
						}
					}
				}
				}
			}
			}catch(Exception $e){
				
			}
		}
		return $patImages;
	}
	
	public function patent_full_document_page_image($publication,$db,$patent,$equivalents){
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$epoDocToken = $this->epodoc->read_token('HedCET');	
		$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data',$publication,$db,$patent,$equivalents,'');
		$patImages = array();
		if(!empty($getFamilyData['data'])){
			try{
			$xml=simplexml_load_string($getFamilyData['data']);
			if ($xml !== false) {
				$xmlObject = new SimpleXMLElement($getFamilyData['data']);
				if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && $xmlObject->message=="No results found"){
					$patImages = array();
				} else{
				$patentObject = $xmlObject->xpath('//ops:inquiry-result');
				if(isset($patentObject[0])){
					$mainDocumentReference = $patentObject[0]->xpath('//ops:document-instance');
					if(count($mainDocumentReference)>0){
						foreach($mainDocumentReference as $documentR){
							$imageLink =  (string)$documentR['link'];
							if((string)$documentR['desc']=='FullDocument'){
								
								$noOfPages = $documentR['number-of-pages'];
								if($noOfPages>0){
									for($i=1;$i<=$noOfPages;$i++){
										$accept = 'application/pdf';
										$getImagePDFData = $this->epodoc->singleUrl($epoDocToken,$accept,$imageLink.".pdf?Range=".$i);
										if(isset($getImagePDFData['data']) && $getImagePDFData['data']!=''){
											$imageType = array_pop(explode('/',$imageLink));
											$fileName = $patent.'_'.$imageType."_".$documentR['desc']."_".$i.".pdf";
											if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName)){
												$f = fopen($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName,"w+");
												fwrite($f, $getImagePDFData['data']);
												fclose($f);
											}
											if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName)){
												if($fileName != "") {
													$patImages[] = 'https://backyard.synpat.com/public/temp/'.$fileName;
												}	
											}
											//$patImages[] = 'https://backyard.synpat.com/public/temp/'.$fileName;
										}
										break;
									}
								}
							}
						}
					}
				}
				}
			}
			}catch(Exception $e){
				
			}
		}
		return $patImages;
	}
	public function patent_first_page_image($publication,$db,$patent,$equivalents){
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$epoDocToken = $this->epodoc->read_token('HedCET');	
		$getFamilyData = $this->epodoc->runUrl($epoDocToken,'published-data',$publication,$db,$patent,$equivalents,'');
		$patImages = array();
		if(!empty($getFamilyData['data'])){
			try{
			$xml=simplexml_load_string($getFamilyData['data']);
			if ($xml !== false) {
				$xmlObject = new SimpleXMLElement($getFamilyData['data']);
				if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && $xmlObject->message=="No results found"){
					$patImages = array();
				} else{
				$patentObject = $xmlObject->xpath('//ops:inquiry-result');
				if(isset($patentObject[0])){
					$mainDocumentReference = $patentObject[0]->xpath('//ops:document-instance');
					if(count($mainDocumentReference)>0){
						foreach($mainDocumentReference as $documentR){
							$imageLink =  (string)$documentR['link'];
							if((string)$documentR['desc']=='FirstPageClipping'){
								$noOfPages = $documentR['number-of-pages'];
								if($noOfPages>0){
									for($i=1;$i<=$noOfPages;$i++){
										$accept = 'application/pdf';
										$getImagePDFData = $this->epodoc->singleUrl($epoDocToken,$accept,$imageLink.".pdf?Range=".$i);
										if(isset($getImagePDFData['data']) && $getImagePDFData['data']!=''){
											$imageType = array_pop(explode('/',$imageLink));
											$fileName = $patent.'_'.$imageType."_".$documentR['desc']."_".$i.".pdf";
											if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName)){
												$f = fopen($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName,"w+");
												fwrite($f, $getImagePDFData['data']);
												fclose($f);
											}
											if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$fileName)){
												if($fileName != "") {
													$patImages[] = 'https://backyard.synpat.com/public/temp/'.$fileName;
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
			}catch(Exception $e){
				
			}
		}
		return $patImages;
	}
	
	public function findImagesFromGooglePatent($patent){
		$url = "http://webdriverforscrape.site/find_google_source_image.php?p=".$patent;
		//echo $url."<br/>";
		ini_set("allow_url_fopen", true);
		$ch = curl_init($url);
		$patImages = array();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$content = curl_exec($ch);
		curl_close($ch);
		if($content!=""){
			try{
				if(strpos($content,"installed.js")!==false){
					$str = strpos($content,"</script>");
					$content = substr($content,$str + 9);
				}
				$pathInfo = pathinfo($content);
				$file_url = $pathInfo['dirname'].'/'.$pathInfo['basename'];
				/*file_get_contents("http://webdriverforscrape.site/patents/USRE045181-20141007-D00000.png");*/
				$f = fopen($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$pathInfo['basename'],"w+");
				fwrite($f, file_get_contents(trim($file_url)));
				fclose($f);
				$pathInfo['filename'] = str_replace('\n','',$pathInfo['filename']);
				if(file_exists($_SERVER['DOCUMENT_ROOT'].'/public/temp/'.$pathInfo['basename']) && trim($pathInfo['filename']) != ""){
					$patImages[] = 'https://backyard.synpat.com/public/temp/'.$pathInfo['basename'];
				}
			}catch(Exception $e){
				
			}
		}
		return $patImages;
	}
	
	public function familyepo($patentNumber){
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
				$linkageTypeOfAllCountry = array(
					array('country'=>'PCT','type'=>'A','status'=>'PCT application claimed under the Paris Convention'),
					array('country'=>'PCT','type'=>'W','status'=>'PCT application claimed as a regional filing'),
					array('country'=>'PCT','type'=>'0','status'=>'Prior application claimed for an addition'),
					array('country'=>'PCT','type'=>'1','status'=>'Prior application claimed for continuation'),
					array('country'=>'PCT','type'=>'2','status'=>'Prior application claimed for continuation in part'),
					array('country'=>'PCT','type'=>'3','status'=>'Prior application claimed for a division'),
					array('country'=>'AT','type'=>'A','status'=>'Cited application changed from patent to utility'),
					array('country'=>'AT','type'=>'U','status'=>'Cited application changed from utility to patent'),
					array('country'=>'AT','type'=>'0','status'=>'Prior application claimed for an addition'),
					array('country'=>'AT','type'=>'3','status'=>'Prior application claimed for a division'),
					array('country'=>'BA','type'=>'3','status'=>'Prior application claimed for a division'),
					array('country'=>'BR','type'=>'0','status'=>'Prior application claimed for an addition'),
					array('country'=>'BR','type'=>'3','status'=>'Prior application claimed for a division'),
					array('country'=>'CA','type'=>'3','status'=>'Prior application claimed for a division'),
					array('country'=>'CA','type'=>'4','status'=>'Prior application claimed for a division of a division'),
					array('country'=>'CA','type'=>'5','status'=>'Claimed application is a supplementary disclosure'),
					array('country'=>'CH','type'=>'0','status'=>'Prior application claimed for an addition'),
					array('country'=>'CH','type'=>'3','status'=>'Prior application claimed for a division'),
					array('country'=>'CH','type'=>'3','status'=>'Prior application claimed for a division')
				);
				
				/*$getFamilyData = $this->epodoc->runUrl($epoDocToken,'family',$patentType,'epodoc',$patentNumber,'legal');*/
				$getFamilyData = $this->epodoc->runUrl($epoDocToken,'family',$patentType,'epodoc',$patentNumber,'','');
				/*echo "<pre>";
				print_r($getFamilyData);
				die;*/
				if(empty($getFamilyData['error'])){
					if(!empty($getFamilyData['data'])){
						$this->load->model('lead_model');
						$xml=simplexml_load_string($getFamilyData['data']);
						if ($xml !== false) {
							$xmlObject = new SimpleXMLElement($getFamilyData['data']);
							$patentObject = $xmlObject->xpath('//ops:patent-family');
							$listOfFamilyMembers = $xmlObject->xpath('//ops:family-member');
							$publicationNumber = "";
							if(isset($patentObject[0])){
								$mainPatentPublicationReference = $patentObject[0]->xpath('//ops:publication-reference');
								if(isset($mainPatentPublicationReference[0])){
									$publicationNumber = (string)$mainPatentPublicationReference[0]->{'document-id'}->{'doc-number'};
								}
							}
							$mainPatentDetails = array();
							$searchNumber = $this->filterInt($patentNumber);
							$searchApplicationNumber = "";
							$allFamilyList = array();
							$primeFamily = array();
							$mainFamilyID = "";
							
							if(count($listOfFamilyMembers)>0){
								foreach($listOfFamilyMembers as $family){
									$familyID = (string)$family['family-id'];
									$includeOther = false;
									if($mainFamilyID!="" && $mainFamilyID==$familyID){
										$includeOther = true;
									} else if($mainFamilyID==""){
										$includeOther = true;
									}
									/*if($includeOther===true):*/
									$publicationReference = $family->{'publication-reference'}->{'document-id'};
									$publicationNumber = "";
									$publicationDate = "";
									$pubCountry="";
									$pubKind="";
									$applicationNumber = "";
									$applicationOriginal = "";
									$applicationDate = "";
									$applicationCountry="";
									$applicationKind="";	
									if(count($publicationReference)>0){
										foreach($publicationReference as $pubRef){	
											if((string)$pubRef['document-id-type']=="epodoc"){
												$publicationNumber = (string)$pubRef->{'doc-number'};
												
												$publicationDate = (string)$pubRef->{'date'};
											} else if((string)$pubRef['document-id-type']=="docdb"){
												$pubCountry = (string)$pubRef->{'country'};
												$pubKind = (string)$pubRef->{'kind'};
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
									/*check family*/
									$priorityClaim =$family->{'priority-claim'};
									$familyList = array();
									if(count($priorityClaim)>0){
										foreach($priorityClaim as $prC){
											$country = (string)$prC->{'document-id'}->{'country'};
											$docNumber = (string)$prC->{'document-id'}->{'doc-number'};
											$kind = (string)$prC->{'document-id'}->{'kind'};
											$date = (string)$prC->{'document-id'}->{'date'};
											$linkageType = (string)$prC->{'priority-linkage-type'};
											$familyList[] = array('country'=>$country,'doc_number'=>$docNumber,'kind'=>$kind,'date'=>$date,'linkage_type'=>$linkageType);
										}
									}
									$familyMember = array('family_id'=>$familyID,'publication_number'=>$publicationNumber,'publication_date'=>$publicationDate,'country'=>$pubCountry,'kind'=>$pubKind,'application_number'=>$applicationNumber,'application_date'=>$applicationDate,'application_country'=>$applicationCountry,'application_kind'=>$applicationKind,'list'=>$familyList);
									if($publicationNumber==$patentNumber && count($primeFamily)==0){
										$mainFamilyID = $familyID;
										$searchApplicationNumber = $familyMember['application_number'];
										$primeFamily = $familyMember;
									} else {
										$allFamilyList[] = $familyMember;
									}
									/*endif;*/
								}
							}
							$getPatentBiblio = array();
							if(count($primeFamily)>0){
								$checkData = $this->lead_model->checkPatentIllustrationDetail($primeFamily['application_number']);
								if($checkData==0){
									$this->lead_model->insertPatentIllustrationDetail(array('patent_app_number'=>$searchNumber,'application_number'=>$primeFamily['application_number'],'patent_number'=>$patentNumber,'issue_date_of_patent'=>$primeFamily['publication_date'],'filling_date'=>$primeFamily['application_date'],'status'=>'Patented Case','country'=>$primeFamily['country']));
									if(!in_array($patentNumber,$getPatentBiblio)){
										$getPatentBiblio[] = $patentNumber;
									}
								} else {
									$this->lead_model->updatePatentIllustrationDetailByAppNumber(array('patent_app_number'=>$searchNumber,'patent_number'=>$patentNumber,'issue_date_of_patent'=>$primeFamily['publication_date']),$primeFamily['application_number']);
								}								
								if(count($primeFamily['list'])>0){
									foreach($primeFamily['list'] as $f){
										$relationStatus = "";
										switch(strtolower($f['linkage_type'])){
											case 1:
											case 'b':
												$relationStatus = "is a continuation of";
											break;
											case 2:
											case 'c':
												$relationStatus = "is a Continuation-in-part of";
											break;
											case 3:
											case 'd':
												$relationStatus = "is a Division of";
											break;
											case 4:
											case 'f':
												$relationStatus = "sub";
											break;
											case 'w':
												$relationStatus = "sub";
											break;
										}
										
										$checkParentRelation = $this->lead_model->checkScraperLeadParent($patentNumber,$primeFamily['application_number'],$f['doc_number']);
										if($checkParentRelation==0){
											if($primeFamily['application_number']!=$f['doc_number']){
												$this->lead_model->insertScraperLeadParent(array('lead_id'=>0,'patent_number'=>$patentNumber,'pat_app_number'=>$primeFamily['application_number'],'relation_number'=>$f['doc_number'],'relation_status'=>$relationStatus,'prime'=>1,'main'=>0,'extended_family'=>1));
											}
										}										
										$checkData = $this->lead_model->checkPatentIllustrationDetail($f['doc_number']);
										if($checkData==0){
											$patentNumberP = $f['country'].$f['doc_number'];
											$this->lead_model->insertPatentIllustrationDetail(array('patent_app_number'=>$f['doc_number'],'application_number'=>$f['doc_number'],'filling_date'=>$f['date'],'patent_number'=>$patentNumberP,'status'=>'Patented Case','country'=>$f['country']));
											if($f['doc_number']!=""){
												if(!in_array($f['country'].$f['doc_number'],$getPatentBiblio)){
													$getPatentBiblio[] = $f['country'].$f['doc_number'];
												}
											}
										}									
									}
								}
							}
							
							if(count($allFamilyList)>0){
								for($i=0;$i<count($allFamilyList);$i++){
									$f = $allFamilyList[$i];
									$list = $f['list'];
									$foundMyPatent = false;
									$relationStatus = "";
									$extended_family = 0;
									if($f['family_id']==$mainFamilyID){
										$extended_family = 1;
									}
									if(count($list)>0){
										foreach($list as $li){
											if($li['doc_number']==$searchApplicationNumber){
												$foundMyPatent = true;
												switch(strtolower($li['linkage_type'])){
													case 1:
													case 'b':
														$relationStatus = "is a continuation of";
													break;
													case 2:
													case 'c':
														$relationStatus = "is a Continuation-in-part of";
													break;
													case 3:
													case 'd':
														$relationStatus = "is a Division of";
													break;
													case 4:
													case 'f':
														$relationStatus = "sub";
													break;
													case 'w':
														$relationStatus = "sub";
													break;
												}
												break;
											}
										}
									}
									
									
									if($foundMyPatent===true):
									$checkData = $this->lead_model->checkPatentIllustrationDetail($f['application_number']);
									if($checkData==0){
										$this->lead_model->insertPatentIllustrationDetail(array('patent_app_number'=>$f['application_number'],'application_number'=>$f['application_number'],'patent_number'=>$f['publication_number'],'issue_date_of_patent'=>$f['publication_date'],'filling_date'=>$f['application_date'],'status'=>'Patented Case','country'=>$f['country']));
										if(!in_array($f['publication_number'],$getPatentBiblio)){
											$getPatentBiblio[] = $f['publication_number'];
										}
									} else if($searchApplicationNumber!=$f['application_number']){
										$this->lead_model->updatePatentIllustrationDetailByAppNumber(array('patent_number'=>$f['publication_number'],'issue_date_of_patent'=>$f['application_date']),$f['application_number']);
									}
									/*Relation this family with searched item*/
									$checkParentRelation = $this->lead_model->checkScraperLeadChild($patentNumber,$primeFamily['application_number'],$f['application_number']);
									if($checkParentRelation==0){
										$this->lead_model->insertScraperLeadChild(array('lead_id'=>0,'patent_number'=>$patentNumber,'pat_app_number'=>$primeFamily['application_number'],'relation_number'=>$f['application_number'],'relation_status'=>$relationStatus,'extended_family'=>$extended_family ));
									}
									endif;
									/*End relation*/
									/*$patentNumberP="";
									
									if(count($list)>0){
										foreach($list as $li){
											$relationStatus = "";
											switch(strtolower($li['linkage_type'])){
												case 1:
												case 'b':
													$relationStatus = "is a continuation of";
												break;
												case 2:
												case 'c':
													$relationStatus = "is a Continuation-in-part of";
												break;
												case 3:
												case 'd':
													$relationStatus = "is a Division of";
												break;
												case 4:
												case 'f':
													$relationStatus = "sub";
												break;
												case 'w':
													$relationStatus = "sub";
												break;
											}
											
											$checkParentRelation = $this->lead_model->checkScraperLeadParent($patentNumber,$f['application_number'],$li['doc_number']);
											if($checkParentRelation==0){
												if($f['application_number']!=$li['doc_number']){
													$this->lead_model->insertScraperLeadParent(array('lead_id'=>0,'patent_number'=>$patentNumber,'pat_app_number'=>$f['application_number'],'relation_number'=>$li['doc_number'],'relation_status'=>$relationStatus,'prime'=>0,'main'=>1,'extended_family'=>1));
												}
											}
											$checkData = $this->lead_model->checkPatentIllustrationDetail($li['doc_number']);
											if($checkData==0){
												$patentNumberP = $li['country'].$li['doc_number'];
												$this->lead_model->insertPatentIllustrationDetail( array('patent_app_number'=>$li['doc_number'],'application_number'=>$li['doc_number'],'filling_date'=>$li['date'],'patent_number'=>$patentNumberP,'status'=>'Patented Case','country'=>$li['country']));
												if($li['doc_number']!=""){
													if(!in_array($li['country'].$li['doc_number'],$getPatentBiblio)){
														$getPatentBiblio[] = $li['country'].$li['doc_number'];
													}
												}
											}
										}
									}*/
								}
							}
							$getPatentBiblio = array_unique($getPatentBiblio);
							if(count($getPatentBiblio)>0){
								/*Find Biblio Data*/
								$numberOfRequest = ceil(count($getPatentBiblio)/10);
								for($i=0;$i<$numberOfRequest;$i++){
									$start = $i * 10;
									$end = 10;
									if($start>0){
										$end = $start + 10;
									}
									$requestPatentBatch = array();
									for($j=$start;$j<$end;$j++){
										if(isset($getPatentBiblio[$j])){
											$requestPatentBatch[] = $getPatentBiblio[$j];
										}
									}
									if(count($requestPatentBatch)>0){
										$patentList = implode(',',$requestPatentBatch);
										$getBiblioData = $this->epodoc->runUrl($epoDocToken,'published-data','publication','epodoc',$patentList,'biblio','');
										if(empty($getBiblioData['error'])){
											if(!empty($getBiblioData['data'])){
												$xml=simplexml_load_string($getBiblioData['data']);
												if ($xml !== false) {
													$xmlObject = new SimpleXMLElement($getBiblioData['data']);
													$worldPatentData = $xmlObject->xpath('//ops:world-patent-data');
													if(isset($worldPatentData[0])){
														$exchangeDocuments = $worldPatentData[0]->{'exchange-documents'};
														$exchangeDocumentList = $exchangeDocuments->{'exchange-document'};
														if(count($exchangeDocumentList)>0){
															foreach($exchangeDocumentList as $document){
																$documentNumber = $document['country'].$document['doc-number'];
																$abs = $document->{'abstract'};
																$abstractString = (string)$abs->p;
																if(trim($abstractString)!=""){
																	$this->lead_model->updatePatentIllustrationDetail(array('abstract_data'=>$abstractString),$documentNumber);
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
							/*Get Legal and Images data*/
							$getAllPatNumber = $this->lead_model->getAllRelationForPatent($patentNumber);
							if(count($getAllPatNumber)>0){
								foreach($getAllPatNumber as $ptNumber){
									$getImagesData = $this->patent_images('publication','epodoc',$ptNumber,'images');
									$getLegalData = $this->patent_legal('publication','epodoc',$ptNumber);
									$this->lead_model->updatePatentIllustrationDetail(array('legal'=>json_encode($getLegalData),'images'=>json_encode($getImagesData)),$ptNumber);
								}
							}
							/*End Legal and Images data*/
						}
					}
				}
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
		$data['number'] = $patentNumber;
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Patent Famil';
		$this->layout->render('leads/illustrationepo',$data);
	}
	
	function scrapeAllPatentsEPOData(){
		$this->load->model('lead_model');
		$getAllPatentsFromLead = $this->lead_model->getAllPatentsFromLeadForEPO();
		if(count($getAllPatentsFromLead)>0){
			foreach($getAllPatentsFromLead as $patent){
				echo "Running:".$patent->patent_number."<br/>";
				$this->family_data($patent->patent_number);
			}
		}
	}
	
	function update_left_chart_juridiction(){
		if(isset($_POST) && count($_POST)>0){
			$leadID = $_POST['l'];
			$this->load->model('lead_model');
			$getLeadData = $this->lead_model->getLeadDataWithOptions($leadID,'l.serial_number');
			if(count($getLeadData)>0){
				$this->load->model('opportunity_model');
				$getLicenseData = $this->opportunity_model->getLicenseDataByLeadID($getLeadData->serial_number,"id");
				if(count($getLicenseData)>0){
					/*Delete Patents*/
	/*$this->opportunity_model->deleteDueDilligencePatent($getLicenseData->id);
	$this->opportunity_model->addDueDilligencePatentThroughLead($leadID,$getLicenseData->id);*/
					$getAllPatentsFromFamily = $this->lead_model->getAllEPOFamiliesLeft($leadID);
					if(count($getAllPatentsFromFamily['publications'])>0){
						$applicationList = $this->applicationList;
						if(count($getAllPatentsFromFamily['publications'])>0){
							$i = 0;
							$unsetNumber = array();
							foreach($getAllPatentsFromFamily['publications'] as $patent){
								$publicationKind = $patent->publication_kind;
								$countryCode = strtoupper($patent->publication_country);
								if(isset($applicationList[$countryCode]) && count($applicationList[$countryCode])>0){
									if(in_array($publicationKind,$applicationList[$countryCode])){
										$unsetNumber[] = $i;
									}
								}
								$i++;
							}
							if(count($unsetNumber)>0){
								foreach($unsetNumber as $i){
									if(isset($getAllPatentsFromFamily['publications'][$i])){
										$getAllPatentsFromFamily['publications'][$i]->type = "Application";
									}
								}
							}
							for($i=0;$i<count($getAllPatentsFromFamily['publications']);$i++){
								if(!isset($getAllPatentsFromFamily['publications'][$i]->type)){
									$getAllPatentsFromFamily['publications'][$i]->type = "Patent";
								}
							}
						}
						
						$chartLeftData = array();
						$license_id = $getLicenseData->id;
						$cList = array();
						foreach($getAllPatentsFromFamily['publications'] as $family){
							$spNew = true;
							$spL = 0;
							if(count($chartLeftData)>0 && in_array($family->publication_country,$cList)){
								for($m=0;$m<count($chartLeftData);$m++){
									if($chartLeftData[$m]['country']==$family->publication_country){
										$spNew = false;
										$spL = $m;
										break;
									}
								}
							}
							if($spNew===true){
								$p = 0;
								$a = 0;
								if($family->type=="Patent"){
									$p = $p + 1;
								}
								if($family->type=="Application"){
									$a = $a + 1;
								}
								$cList[] = $family->publication_country;
								$chartLeftData[] = array('country'=>$family->publication_country,'applications'=>$a,'patents'=>$p,'license_id'=>$license_id);
							} else{
								if($family->type=="Patent"){
									$chartLeftData[$spL]['patents'] = $chartLeftData[$spL]['patents'] + 1;
								} else if($family->type=="Application"){
									$chartLeftData[$spL]['applications'] = $chartLeftData[$spL]['applications']+1;
								}
							}
						}
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
				}
			}
		}		
		die;
	}
	
	public function assignmentdata($getPatentNumber){
		$url = "https://assignment-api.uspto.gov/patent/advancedSearch?sort=ExecutionDate%20asc&patentNumber=".$getPatentNumber;
		$assignmentData = array();
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		/*curl_setopt ( $ch, CURLOPT_HEADER, array('Accept:application/xml') );*/
		curl_setopt ( $ch, CURLOPT_HEADER,false );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 0 );
		$dataUSPTO= curl_exec ( $ch );
		if (curl_errno ( $ch )) {			
			curl_close ( $ch );			
		} else {
			curl_close ( $ch );
			libxml_use_internal_errors(true);
			try{
				$xmlUSPTO = simplexml_load_string($dataUSPTO);
				if ($xmlUSPTO) {
					if(isset($xmlUSPTO->result)){
						$getNoDocument = $xmlUSPTO->result->attributes()['numFound'];
						if((int)$getNoDocument>0){
							$doc = $xmlUSPTO->result->doc;
							for($i=0;$i<$getNoDocument;$i++){
								$xmlObject = $doc[$i];
								$allAtrributes = $xmlObject->arr;
								if(count($allAtrributes)>0){
									$assignor = "";
									$assignee = "";
									$assignee_date = "";
									$inventors = "";
									foreach($allAtrributes as $attr){
										switch($attr->attributes()['name']){
											case 'patAssignorName':
												$assignor = (string)$attr->str;
											break;
											case 'patAssigneeName':
												$assignee  = (string)$attr->str;
											break;
											case 'patAssignorExDate':
												$assignee_date = (string)$attr->date;
											break;
											case 'inventors':
												$inventors = (string)$attr->str;
											break;
										}
									}
									$conveyanceText = (string)$xmlObject->str[10];
									$recordedDate = (string)$xmlObject->date[1];
									$assignmentData[] = array('rights'=>$this->cleanString($conveyanceText),'inventors'=>$this->cleanString($inventors),'assignor'=>$this->cleanString($assignor),'assignee'=>$this->cleanString($assignee),'assignee_date'=>date("Y-m-d H:i:s",strtotime($assignee_date)),'recorded'=>date("Y-m-d H:i:s",strtotime($recordedDate)));
								}
							}
						}
					}
				}
			}catch(Exception $e){
				
			}
		}
		return $assignmentData;
	}
	
	function cleanString($string){
		$string = trim($string);
		$string = strip_tags($string);
		$string = preg_replace("/;/", "",$string);
		$string = preg_replace("/'/", "",$string);
		$string = preg_replace("/\"/", "",$string);
		$regex = '/(\s|\\\\[rntv]{1})/';
		$string = preg_replace($regex, ' ', $string);
		return $string;
	}
	
	/*public function createClassificationImage(){
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$epoDocToken = $this->epodoc->read_token('HedCET');
		$getCPCCodeXML =  $this->epodoc->singleUrl($epoDocToken,'','classification/cpc/media/932.gif'); 
		if(empty($getCPCCodeXML['error'])){
			if(!empty($getCPCCodeXML['data'])){
				$f = fopen($_SERVER['DOCUMENT_ROOT'].'/public/temp/932.gif',"w+");
				fwrite($f, $getCPCCodeXML['data']);
				fclose($f);
				echo $getCPCCodeXML['data'];
				die;
			}
		}
		die;
	}*/
	
	public function getCPCXML($cpc,$depth){
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$listClassification = array();
		$classifyDescription = array();
		try{
			$epoDocToken = $this->epodoc->read_token('HedCET');
			if(!$epoDocToken['error']) {
				$getCPCCodeXML =  $this->epodoc->singleUrl($epoDocToken,'','classification/cpc/'.$cpc.'?depth='.$depth.'&ancestors=true'); 
				if(empty($getCPCCodeXML['error'])){
					if(!empty($getCPCCodeXML['data'])){
						$xml=simplexml_load_string($getCPCCodeXML['data']);
						if ($xml !== false) {
							$xmlObject = new SimpleXMLElement($getCPCCodeXML['data']);
							if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && 	$xmlObject->message=="No results found"){
							} else {
								$worldPatentData = $xmlObject->xpath('//ops:world-patent-data');
								if(isset($worldPatentData[0])){
									$classificationObject = $worldPatentData[0]->xpath('//ops:classification-scheme');
									if(isset($classificationObject[0])){
										$cpcSchema = $classificationObject[0]->xpath('//ops:classification-scheme');
										if(isset($cpcSchema[0])){
											$classSchema = $cpcSchema[0]->xpath('//cpc:class-scheme');
											if(isset($cpcSchema[0])){
												$classificationItems = $cpcSchema[0]->xpath('//cpc:classification-item');
												if(count($classificationItems)>0){
				foreach($classificationItems as $classification){
					$defination = "";
					$classTitle = $classification->xpath('.//cpc:class-title');
					if(isset($classTitle[0])){
						$titlePart = $classTitle[0]->xpath('.//cpc:title-part');
						if(isset($titlePart[0])){
							$definations =  $titlePart[0]->xpath('.//cpc:text');
							while(list( , $node) = each($definations)) {
								$defination .=$node." ";
								break;
							}
							$defination = trim($defination);
						}
					}
					if($defination!="" && !in_array($defination,$classifyDescription)){
						array_push($listClassification,array('classification_description'=>$defination,'name'=>(string)$classification['sort-key'],'parent'=>(string)$classification['level']));
						$classifyDescription[] = $defination;
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
		}catch(Exception $e){
		}
		return $listClassification;
	}
	
	public function findCPCParentChild(){
		$cpc = $this->input->get('cpc');
		$explodeClassification = explode(',',$cpc);
		$listCpc = array();
		$count = 0;
		$alreadyRun = array();
		if(count($explodeClassification)>0){
			foreach($explodeClassification as $classification){
				if(in_array($classification,$alreadyRun)){
					for($i=0;$i<count($listCpc);$i++){
						if($listCpc[$i]['name']==$classification){
							$listCpc[$i]['counter'] +=1;
							break;
						}
					}
				} else {
				$getList = $this->getCPCXML($classification,"0");
				array_push($alreadyRun,$classification);
				/*if(count($getList)==0){
					$getList = $this->getCPCXML($classification,"4");
					if(count($getList)==0){
						$getList = $this->getCPCXML($classification,"3");
						if(count($getList)==0){
							$getList = $this->getCPCXML($classification,"2");
							if(count($getList)==0){
								$getList = $this->getCPCXML($classification,"1");
							}
						}
					}
				}*/
				if(count($getList)>$count){
					$count = count($getList);
				}
				array_push($listCpc,array('name'=>$classification,'description_10'=>'','description_3'=>'','counter'=>1,'list'=>$getList));
				}
			}
		}
		echo json_encode(array('data'=>$listCpc,'count'=>$count));
		die;
	}
	
	public function family_data($patentNumber){
		$data = array('id'=>0,'status'=>'');
		$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
		$orgPatent = $patentNumber;
		try{
			$epoDocToken = $this->epodoc->read_token('HedCET');	
			$applicationList = $this->applicationList;
			if(!$epoDocToken['error']) {
				$patentType = 'publication';
				$searchedPatentNumber = $patentNumber;
				if(strlen($patentNumber)>9){
					if(strtolower(substr($patentNumber,0,2))=="us"){
						//$patentNumber = substr($patentNumber,0,9);
						if(substr($patentNumber,strlen($patentNumber)-2,1)=="E" || substr($patentNumber,-1)=="E"){
							$patentNumber = substr($patentNumber,0,10);
						} else {
							$patentNumber = substr($patentNumber,0,-2);
						}
					} else {
						$checkCode = substr($patentNumber,-1);
						if(is_numeric($checkCode)){
							$checkCode = substr($patentNumber,-2);
							if(is_numeric($checkCode)===false){
								$patentNumber = substr($patentNumber,0,-2);
							}
						} else {
							$patentNumber = substr($patentNumber,0,-1);
						}
					}					
				}
				if(strlen($patentNumber)==13){
					$patentType = 'application';
				}
				
				$getFamilyData = $this->epodoc->runUrl($epoDocToken,'family',$patentType,'epodoc',$patentNumber,'legal','');
				if(empty($getFamilyData['error'])){
					
					if(!empty($getFamilyData['data'])){
						$xml=simplexml_load_string($getFamilyData['data']);
						if ($xml !== false) {
							$xmlObject = new SimpleXMLElement($getFamilyData['data']);
							if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && 	$xmlObject->message=="No results found"){
								$data['status']= "No results found";
								/*Scrape data from different source*/
								$first2Letter = substr($orgPatent,0,2);
								if(strtolower($first2Letter)=="us"){
									$remainigLetter = substr($orgPatent,2);
								}
								$usptoURL = "";
								$title = "";
								$getPageSourceFromGoogle = $this->executeCurl($orgPatent);
								if(!empty($getPageSourceFromGoogle)){
									$this->load->library('simple_html_dom');
									$html = $this->simple_html_dom->load($getPageSourceFromGoogle,true,true);
									try{
										if(is_object($html) && isset($html->nodes)):
											$anchor = $html->find('a');
											if(count($anchor)>0){
												foreach($anchor as $a){
													if($a->innertext=="USPTO"){
														$usptoURL = $a->href;
														$title = $html->find('title')[0]->innertext;
														break;
													}
												}		
											}
										endif;
									}catch(Exception $e){
										
									}
								}
	if($usptoURL!=""){
		/*get scrape data*/
		$familyID="";
		$applicationNumber = "";
		$usptoURL = urldecode($usptoURL);
		$usptoURL = preg_replace('/&amp;/','&',$usptoURL);
		$getContent = file_get_contents($usptoURL);
		if(!empty($getContent)){
			$this->load->library('simple_html_dom');
			$html = $this->simple_html_dom->load($getContent,true,true);
			try{
				if(is_object($html) && isset($html->nodes)):
					$tables = $html->find('table');
					if(count($tables)>0){
						foreach($tables as $table){
							$trows = $table->find('tr');
							if(count($trows)>0){
								$applicationNumberFind = false;
								$applicationNumberEq = -1;
								$fillingDateFind = false;
								$fillingDateFindEq = -1;
								$patentNumberFind = false;
								$patentNumberFindEq = -1;
								$issueDateFind = false;
								$issueDateFindEq = -1;
								$sp = 0;
								foreach($trows as $tr){
									$thdata = $tr->find('th');
									$tdata = $tr->find('td');
									if(count($thdata)>0){
										if(count($thdata)==1){
											switch(trim($thdata[0]->innertext)){
												case "Family ID:":
												$familyID =	trim($tdata[0]->innertext);
												break;
												case "Appl. No.:":
												$applicationNumber = trim($tdata[0]->innertext);
												break;
												default:
													if(strpos(trim($thdata[0]->innertext),"Family ID:")!==false){
														$thText = str_replace("Family ID:",'',trim($thdata[0]->innertext));
														$thText = strip_tags($thText);
														if($familyID==""){
															$familyID =	trim($thText);
														}
													}			
												break;
											}			
										}/* else {											
											foreach($thdata as $th){
												$stripTags = trim(strip_tags($th->innertext));
												switch($stripTags){
													case 'Application Number':
														$applicationNumberFind = true;
														$applicationNumberEq = $sp;
													break;
													case 'Filing Date':
														$fillingDateFind = true;
														$fillingDateFindEq = $sp;
													break;
													case 'Patent Number':
														$patentNumberFind = true;
														$patentNumberFindEq = $sp;
													break;
													case 'Issue Date':
														$issueDateFind = true;
														$issueDateFindEq = $sp;
													break;
												}
												$sp++;
											}
											if($applicationNumberFind===true && $fillingDateFind===true && $patentNumberFind===true && $issueDateFind===true && count($tdata)>0{
												echo "ApplicationNo:".$tdata[$applicationNumberEq]->innertext."<br/>";
												echo "FillingDate:".$tdata[$fillingDateFindEq]->innertext."<br/>";
												echo "Patent Number:".$tdata[$patentNumberFindEq]->innertext."<br/>";
												echo "Issue Date:".$tdata[$issueDateFindEq]->innertext."<br/>";
											} else {
												foreach($tdata as $td){
													//echo $td->innertext."<br/>";
												}
											}
										}
										*/
										if($familyID!="" && $applicationNumber!=""){
											break;
										}
									}	
								}
								
								
							}
						}
						if($familyID!="" && $applicationNumber!=""){
							echo $title."<br/>";
							echo "FamilyID:".$familyID."<br/>";
							echo "ApplicationNumber:".$applicationNumber."<br/>";
						}
						
					}
				endif;
			}catch(Exception $e){
				
			}
		}
	}
								
								die;
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
							} else {
							$patentObject = $xmlObject->xpath('//ops:patent-family');
							$listOfFamily = $xmlObject->xpath('//ops:family-member');
							/*echo "<pre>";
							print_r($listOfFamily);die;*/
							$familyList = array();
							$mainFamilyID = "";
							if(count($listOfFamily)>0){
								foreach($listOfFamily as $family){
									$familyID = (string)$family['family-id'];
									$publicationReference = $family->{'publication-reference'}->{'document-id'};
									$patentNumber = "";
									$patentPublicationDate = "";
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
											if((string)$pubRef['document-id-type']=="docdb"){
												$country = (string)$pubRef->{'country'};
												$publicationNumber = (string)$pubRef->{'doc-number'};
												$patentNumber = (string)$pubRef->{'doc-number'};
												$kind = (string)$pubRef->{'kind'};
												$publicationDate = (string)$pubRef->{'date'};
												$patentPublicationDate = (string)$pubRef->{'date'};
											}
										}
									}
									if($publicationNumber!="" && $mainFamilyID==""){
										$xmlRef = $country.$publicationNumber.$kind;
										$lastDigit = substr($searchedPatentNumber,-1);
										if($kind=='E' && $country=="US"){
											if(is_numeric($lastDigit)){
												$xmlRef = $xmlRef.$lastDigit;
											}
										}
										$temp = $country.$publicationNumber;
										if(($xmlRef == $searchedPatentNumber) || $temp ==$searchedPatentNumber){
											$mainFamilyID = $familyID;
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
											if((string)$appRef['document-id-type']=="epodoc" && $applicationDate == ""){
												$applicationDate = (string)$appRef->{'date'};
											}
											if((string)$appRef['document-id-type']=="original"){
												$applicationNumber = (string)$appRef->{'doc-number'};
											}
										}
									}									
									$title = "";
									$familyList[] = array('family_id'=>$familyID,'patentNumber'=>$patentNumber,'patent_publication_date'=>$patentPublicationDate,'publicationNumber'=>$publicationNumber,'publicationDate'=>$publicationDate,'country'=>$country,'kind'=>$kind,'applicationNumber'=>$applicationNumber,'applicationOriginal'=>$applicationOriginal,'applicationDate'=>$applicationDate,'applicationCountry'=>$applicationCountry,'applicationKind'=>$applicationKind,'applicants'=>$applicants,'inventors'=>$inventors,'title'=>$title);
								}
							}
							/*die;*/
							/*Simple Family*/
							$simpleFamilyList = array();
							if($mainFamilyID!=""){
								foreach($familyList as $family){
									if($family['family_id']==$mainFamilyID){
										$simpleFamilyList[] = $family;
									}
								}
							}
							/*Remove Duplicate Application $applicationList*/
							$unsetNumber = array();
							for($i=0;$i<count($simpleFamilyList);$i++){
								$entry = true;
								if(count($unsetNumber)>0 && in_array($i,$unsetNumber)){
									$entry = false;
								}
								if($entry === true){
									$applicationNumber = $simpleFamilyList[$i]['applicationNumber'];
									$publicationNumber = $simpleFamilyList[$i]['publicationNumber'];
									for($j=0;$j<count($simpleFamilyList);$j++){
										if($simpleFamilyList[$j]['applicationNumber'] == $applicationNumber && $publicationNumber!=$simpleFamilyList[$j]['publicationNumber']){
											$countryCode = $simpleFamilyList[$j]['country'];
											if(isset($applicationList[$countryCode]) && count($applicationList[$countryCode])>0){
												if(in_array($simpleFamilyList[$j]['kind'],$applicationList[$countryCode])){
													$simpleFamilyList[$i]['patentNumber'] = $simpleFamilyList[$j]['publicationNumber'];
													$simpleFamilyList[$i]['patent_publication_date'] = $simpleFamilyList[$j]['publicationDate'];
													$unsetNumber[] = $j;
												} else if(in_array($simpleFamilyList[$i]['kind'],$applicationList[$countryCode])){
													$simpleFamilyList[$j]['patentNumber'] = $simpleFamilyList[$i]['publicationNumber'];
													$simpleFamilyList[$i]['patent_publication_date'] = $simpleFamilyList[$j]['publicationDate'];
													$unsetNumber[] = $i;
												}
											}
										} else if($simpleFamilyList[$j]['applicationNumber'] == $applicationNumber && $publicationNumber==$simpleFamilyList[$j]['publicationNumber'] && $simpleFamilyList[$i]['kind'] != $simpleFamilyList[$j]['kind']){
											$countryCode = $simpleFamilyList[$j]['country'];
											if(in_array($simpleFamilyList[$j]['kind'],$applicationList[$countryCode])){
												$unsetNumber[] = $j;
											} else if(in_array($simpleFamilyList[$i]['kind'],$applicationList[$countryCode])){
												$unsetNumber[] = $i;
											}
										}
									}
								}
								$unsetNumber = array_unique($unsetNumber);
								$unsetNumber = array_values($unsetNumber);
							}
						
							$unsetNumber = array_unique($unsetNumber);
							$unsetNumber = array_values($unsetNumber);
							if(count($unsetNumber)>0){
								foreach($unsetNumber as $uN){
									if(isset($simpleFamilyList[$uN])){
										unset($simpleFamilyList[$uN]);
									}
								}
								$simpleFamilyList = array_values($simpleFamilyList);
							}
							/*End Duplicate Application*/
							if(count($simpleFamilyList)>0){
								$this->load->model('lead_model');
								$tap = 0;
								$getListOfAppSeriesCode = $this->lead_model->getListOfSeriesCode();
								$f=0;
								foreach($simpleFamilyList as $family){
									$applicationNumber = $family['applicationNumber'];
									$appFillingYear = substr($family['applicationDate'],0,4);
									if($appFillingYear<2000){
										if(strtoupper($family['country'])=="US"){
											$usSeriesCode = "";
											if(count($getListOfAppSeriesCode)>0){
												foreach($getListOfAppSeriesCode as $seriesCode){
													if($seriesCode->year==$appFillingYear){
														$usSeriesCode = $seriesCode->code;
													}
												}
											}
											$yearLast2Digit = substr($appFillingYear,2);
											if(substr($applicationNumber,-2)==$yearLast2Digit){
												$applicationNumber = substr($applicationNumber,0,-2);
											}
											if($usSeriesCode!=""){
												$applicationNumber = $usSeriesCode.$applicationNumber;
												$simpleFamilyList[$f]['applicationNumber'] = $applicationNumber;
											}
										}
									} else {
										if(strtoupper($family['country'])=="US"){
											$firstFourDigit = substr($applicationNumber,0,4);
											if($firstFourDigit==$appFillingYear){
												$simpleFamilyList[$f]['applicationNumber'] = substr($applicationNumber,4);
											}
										}
									}
									
									$f++;
								}
								foreach($simpleFamilyList as $family){
									$checkFamilyMember = $this->lead_model->checkFamilyMember($family['family_id'],$family['publicationNumber'],$family['applicationNumber']);
									if(count($checkFamilyMember)==0){
										$data['id'] = $this->lead_model->insertPatentFamilyMember(array('family_id'=>$family['family_id'],'patent_number'=>$family['patentNumber'],'publication_number'=>$family['publicationNumber'],'publication_date'=>$family['publicationDate'],'publication_country'=>$family['country'],'publication_kind'=>$family['kind'],'application_number'=>$family['applicationNumber'],'application_date'=>$family['applicationDate'],'application_country'=>$family['applicationCountry'],'application_kind'=>$family['applicationKind'],'application_original'=>$family['applicationOriginal'],'title'=>$family['title'],'applicants'=>json_encode($family['applicants']),'inventors'=>json_encode($family['inventors'])));
									} else {
										$data['id'] = $checkFamilyMember->id;
										if((int)$checkFamilyMember->pub==2){
											$this->lead_model->updatePatentFamilyMember(array('publication_number'=>$family['publicationNumber'],'publication_date'=>$family['publicationDate'],'publication_country'=>$family['country'],'publication_kind'=>$family['kind']),$data['id']);
										}
									}
									if($data['id']>0){
										if($tap==0){
											$this->lead_model->deleteRelationByFamilyID($family['family_id']);
											$tap++;
										}
										$publicationNumber = $family['publicationNumber'];
										$applicationNumber = $family['applicationNumber'];
										$number = $publicationNumber;
										$type = "Patent";
										if($number==""){
											$number=$family['applicationCountry'].$applicationNumber;
											$type = "Application";
										}
										$date = $family['applicationDate'];
										$date = substr($date,0,4).'-'.substr($date,4,2).'-'.substr($date,-2);
										$this->lead_model->insertFamilyPatentRelation(array('family_id'=>$family['family_id'],'patent_id'=>$number,'filling_date'=>$date,'type'=>$type));
										/*find claims,images,abstract*/
										$publicationNumber = $family['country'].$family['patentNumber'];
										$abstract = $this->findPatentAbstract($publicationNumber,'publication',$family['kind']);
										/*if($family['country']=="US"){
											$claims = $this->findClaim($family['country'].$family['publicationNumber'],$family['country'],'publication');
										} else {
											$claims = $this->findClaim($publicationNumber,$family['country'],'publication',$family['applicationKind'],$family['applicationDate']);
										}*/	
										$claims = $this->findClaim($publicationNumber,$family['country'],'publication',$family['applicationKind'],$family['applicationDate'],$family['patent_publication_date'],$family['kind']);
										$getImagesData = $this->patent_first_page_image('publication','epodoc',$publicationNumber,'images');
										if(count($getImagesData)==0){
											$getImagesData = $this->patent_full_page_image('publication','epodoc',$publicationNumber,'images');
											if(count($getImagesData)==0){
												$getImagesData = $this->patent_full_document_page_image('publication','epodoc',$publicationNumber,'images');
												if(count($getImagesData)==0){
													$getImagesData = $this->patent_first_page_image('publication','epodoc',$publicationNumber.$family['kind'],'images');
													if(count($getImagesData)==0){
														$getImagesData = $this->patent_full_page_image('publication','epodoc',$publicationNumber.$family['kind'],'images');
														if(count($getImagesData)==0){
															$getImagesData = $this->patent_full_document_page_image('publication','epodoc',$publicationNumber.$family['kind'],'images');
														}
													}
												}
											}
										}
										if(count($getImagesData)==0){
											$getImagesData = $this->findImagesFromGooglePatent($publicationNumber);
										}
										/*if(count($getImagesData)==0){
											$getImagesData = $this->patent_first_page_image('application','epodoc',$publicationNumber,'images');
											if(count($getImagesData)==0){
												$getImagesData = $this->patent_full_page_image('application','epodoc',$publicationNumber,'images');
												if(count($getImagesData)==0){
													$getImagesData = $this->patent_full_document_page_image('application','epodoc',$publicationNumber,'images');
												}
											}
										}*/									
										$updateData = array();
										if($claims!=""){
											$updateData['claims'] = $claims;
										}
										if($getImagesData!=""){
											$updateData['images'] = json_encode($getImagesData);
										}
										if($abstract['abstract']!=""){
											$updateData['abstracts'] = $abstract['abstract'];
										}
										if($abstract['title']!=""){
											$updateData['title'] = $abstract['title'];
										}
										if($abstract['assignee']!=""){
											$updateData['assignee'] = $abstract['assignee'];
										}
										if($abstract['applicant']!=""){
											$updateData['applicants'] = implode(',',$abstract['applicant']);
										}
										if($abstract['priority_date']!=""){
											$updateData['priority_date'] = substr($abstract['priority_date'],0,4).'-'.substr($abstract['priority_date'],4,2).'-'.substr($abstract['priority_date'],-2);
										}
										if($abstract['inventor']!=""){
											$updateData['inventors'] = implode(',',$abstract['inventor']);
										}
										if(isset($abstract['classifications']) && $abstract['classifications'] !=""){
											$updateData['classifications'] = $abstract['classifications'];
										}
										if($family['country']=="US"){
											$getAssigmentData = $this->assignmentdata($family['publicationNumber']);
											if(count($getAssigmentData)>0){
												$updateData['assigments'] = json_encode($getAssigmentData);
											}
										}
										if(count($updateData)>0){
											$this->lead_model->updatePatentFamilyMember($updateData,$data['id']);
										}		
									}
								}
							}
							/*End Simple Family*/
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
	
	public function displayImage(){
		$data['imgsrc'] = $this->input->get('img');
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Captcha Image';
		$this->layout->render('leads/tiff_image',$data);
	}
	
	
	public function captcha_image(){
		$data['id'] = $this->input->get('ID');
		$data['imgsrc'] = $this->input->get('img');
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Captcha Image';
		$this->layout->render('leads/captcha_image',$data);
	}
	
	public function assigment_illustration_store($patentNumber = null,$leadID=0){
		/*$this->load->model('lead_model');
		$data = $this->lead_model->getApplicationNumber($patentNumber);
		$data = (array) $data;
		if(count($data) == 0) {
			$data = array('application_number'=>'');
		}*/
		$this->load->model('lead_model');
		$jobID = $this->lead_model->getJobID($leadID);
		$data = array('patent_number'=>$patentNumber,'job_id'=>$jobID);
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Assignment Data';
		$this->layout->render('leads/assigment_illustration_store',$data);
	}
	
	public function patent_citation_comp($leadID = null){
		$data = array('lead_id'=>0);
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Citation Comp.';
		if($leadID > 0){
			$data['lead_id'] = $leadID;
		}
		$this->layout->render('leads/patent_citation_comp',$data);
	}
	
	public function litigation_comp($leadID = null){
		$data = array('lead_id'=>0);
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Litigation Comp.';
		if($leadID > 0){
			$data['lead_id'] = $leadID;
		}
		$this->layout->render('leads/litigation_comp',$data);
	}
	
	public function get_all_litigation_companies($leadID = null){
		$this->load->model('lead_model');
		$allLitigationCompanies = $this->lead_model->getAllLitigationCompanies($leadID);
		echo json_encode($allLitigationCompanies);
		die;
	}
	
	public function get_all_citing_companies($leadID = null){
		$this->load->model('lead_model');
		$allCitationCompanies = $this->lead_model->getAllPatentCitationCompanies($leadID);
		echo json_encode($allCitationCompanies);
		die;
	}
	
	public function notepad($lead_id = null){
		$data = array('note_data'=>'');
		if($lead_id != null){
			$this->load->model('lead_model');
			$noteData = $this->lead_model->findLeadNotepadData($lead_id);
			if(count($noteData) >0){
				$data['note_data'] = $noteData->note;
			}
		}
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Notepad';
		$this->layout->render('leads/notepad',$data);
	}
	
	public function sources(){
		$data = array();
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Sources';
		$this->layout->render('leads/sources',$data);
	}
	
	public function sources_data(){
		$this->load->model('lead_model');
		$sourcesData = $this->lead_model->getAllSourcesData();
		echo json_encode($sourcesData);
		die;
	}
	
	public function company_finder(){
		//$this->load->model('lead_model');
		$data = array();
		//$data['allPanjivaCompanies'] = $this->lead_model->getAllPanjivaCompanies();
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Comp. Finder';
		$this->layout->render('leads/company_finder',$data);
	}
	
	public function get_all_panjiva_companies(){
		$this->load->model('lead_model');
		$allPanjivaCompanies = $this->lead_model->getAllPanjivaCompanies();
		echo json_encode($allPanjivaCompanies);
		die;
	}
	
	public function reset_all_assignment() {
		$data = 0;
		$patentNumber = $this->input->post('patent_number');
		if($patentNumber != ""){
			$this->load->model('lead_model');
			$patentNumber = $this->modified_patent_number($patentNumber);
			$this->lead_model->deleteAllAssignmentData($patentNumber);
		}
		echo $data;
		die;
	}
	
	public function lead_assignment_name_modified() {
		$data = array();
		$value = $this->input->post('value');
		$id = $this->input->post('id');
		$this->load->model('lead_model');
		$this->lead_model->updateAssignmentNames($id,array('modified'=>$value));
		$patentNumber = $this->modified_patent_number($this->input->post('patent_number'));		
		$data = $this->lead_model->getLeadAssignmentNames($patentNumber);
		echo json_encode($data);
		die;
	}
	
	public function modified_patent_number($patentNumber){
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
		return $patentNumber;
	}
	
	public function lead_assignment_heading_modified() {
		$data = array();
		$postData = $this->input->post();
		$id = $postData['id'];
		$this->load->model('lead_model');
		$data = $this->lead_model->updateAssignmentHeading($id,$postData);
		$patentNumber = $this->modified_patent_number($this->input->post('patent_number'));		
		$data = $this->lead_model->getLeadAssignmentHeadings($patentNumber);
		echo json_encode($data);
		die;
	}
	
	public function illustration_store($patentNumber = null){
		$this->load->model('lead_model');
		/*$data['patent_family'] = array();
		if($patentNumber!=null){
			$data['patent_family'] = $this->lead_model->findPatentFamilyChild($patentNumber);
		}*/
		$data['number'] = $patentNumber;
		if(strlen($patentNumber)>7){		
			$countryCode = substr($patentNumber,0,2);
			if(strtolower(strtoupper($countryCode))=="us"){
				if(strlen($patentNumber)==11){
					$patentNumber = substr($patentNumber,0,9);
				}
			}
		}
		$first2Letter = substr($patentNumber,0,2);
		$newNumber = "";
		if(!is_numeric($first2Letter)){
			$newNumber = substr($patentNumber,2);
			$last2Code = substr($newNumber,-2);
			$last1Code = substr($newNumber,-1);
			if(!is_numeric($last1Code)){
				$newNumber = substr($newNumber,0,-1);
			} else if(!is_numeric($last2Code)){
				$newNumber = substr($newNumber,0,-2);
			}
		}
		if($newNumber==""){
			$newNumber = $patentNumber;
		}
		$data['family_data'] = $this->lead_model->findPatentSimpleFamily($newNumber);		
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Patent Family';
		$this->layout->render('leads/illustration_store',$data);
		
	}
	
	public function illustration_all_store($serialNumber = null){
		if($serialNumber!=null){
			$this->load->model('lead_model');
			$data = array();
			$getLeadData = $this->lead_model->findSerialNumber($serialNumber);
			if(count($getLeadData)>0){
				$data['family_data'] = $this->lead_model->getAllEPOFamilies($getLeadData->id);
				$this->layout->auto_render=false;	
				$this->layout->layout='outsource';
				$this->layout->title_for_layout = 'EPO Data';
				$this->layout->render('leads/epo_family_store',$data);
			} else {
				redirect("https://synpat.com");
			}
		} else {
			redirect("https://synpat.com");
		}
	}
	
	public function patent_family_with_number($patentNumber = null) {
		$data = array('patent_number'=>'');
		if($patentNumber != null){
			$data['patent_number'] = $patentNumber;
		}
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Patent Family';
		$this->layout->render('leads/patent_family_with_number',$data);
	}
	
	public function patent_assignment_with_number($patentNumber = null) {
		$data = array('patent_number'=>'','show'=>true);
		if($patentNumber != null) {
			$data['patent_number'] = $patentNumber;
		}
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Patent Assignment';
		$this->layout->render('leads/patent_assignment_with_number',$data);
	}
	
	public function patent_assignment_illustration($patentNumber = null) {
		$data = array('patent_number'=>'','show'=>false);
		if($patentNumber != null) {
			$data['patent_number'] = $patentNumber;
		}
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Patent Assignment';
		$this->layout->render('leads/patent_assignment_with_number',$data);
	}
	
	public function patent_illustration($patentNumber = null){
		$data = array('patent_number'=>'');
		if($patentNumber != null){
			$data['patent_number'] = $patentNumber;
		}
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Patent Family';
		$this->layout->render('leads/patent_family_with_number',$data);
	}
	
	public function family_illustration_data($patentNumber = null){
		$this->load->model('lead_model');
		if(strlen($patentNumber)>7){		
			$countryCode = substr($patentNumber,0,2);
			if(strtolower(strtoupper($countryCode))=="us"){
				if(strlen($patentNumber)==11){
					$patentNumber = substr($patentNumber,0,9);
				}
			}
		}
		$first2Letter = substr($patentNumber,0,2);
		$newNumber = "";
		if(!is_numeric($first2Letter)){
			$newNumber = substr($patentNumber,2);
			$last2Code = substr($newNumber,-2);
			$last1Code = substr($newNumber,-1);
			if(!is_numeric($last1Code)){
				$newNumber = substr($newNumber,0,-1);
			} else if(!is_numeric($last2Code)){
				$newNumber = substr($newNumber,0,-2);
			}
		}
		if($newNumber==""){
			$newNumber = $patentNumber;
		}
		$family_data = $this->lead_model->findPatentSimpleFamily($newNumber);
		$returnData = $this->create_patent_family_illustration_data($family_data,$patentNumber);
		echo json_encode($returnData);
		die;
	}
	
	private function create_patent_family_illustration_data($family_data,$calledNumber) {
		$jsonRelations = array();
		$jsonRectangles = array();
		$childListIDs = array();
		$childList = array();
		$parentList = array();
		$verticals = array();
		$applicationListIDS = array();
		$nonVerticalsEntries = array();
		$nonVerticalsExits = array();
		$childAppNumber = array();
		$searchPatent = $calledNumber;
		$svgWidth = 500;
		$svgHeight = 500;
		$height = 85;
		$width = 200;
		$fS = false;
		$countries = array();
		if(count($family_data['country'])>0){
			foreach($family_data['country'] as $country){
				$countries[] = strtolower(strtoupper($country->publication_country));
			}
		}
		if(count($family_data['list'])>0){
			$cpCount = 0;
			$chCount = 1;
			for($i=0;$i<count($family_data['list']);$i++){
				$family = $family_data['list'][$i];
				$patentNumber = $family->patent_id;
				$countryCode = strtoupper($family->publication_country);
				$publicationKind = strtoupper($family->publication_kind);
				$label = $countryCode.$patentNumber;
				$label = $label.$publicationKind;
				$search = false;
				if($label!="" && $label==strtoupper($searchPatent)){
					$search = true;
				}
				$family_data['list'][$i]->search = $search;
				$family_data['list'][$i]->label = $label;
				$family_data['list'][$i]->application_org_number = $family->application_number;
				$family_data['list'][$i]->type = "CIP";
				$outside = false;
				if(strtolower(strtoupper($countryCode))!="us"){
					$outside = true;
				}
				$family_data['list'][$i]->country = strtolower(strtoupper($countryCode));
				$family_data['list'][$i]->outside = $outside;
				$family_data['list'][$i]->type = "CIP";
				$same = false;
				$fillingDate = $family->filling_date;
				$previousFillingDate = "";
				if($i>0){
					$previousFillingDate = $family_data['list'][$i-1]->filling_date;
				}
				if($previousFillingDate == $fillingDate){
					$same = true;	
					$cpCount++;
					$w = $cpCount*240;
					$w = $w + 240;
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
							$x = (int)$family_data['list'][$i-1]->x_axis + 230;
							$y = (int)$family_data['list'][$i-1]->y_axis;
						} else {
							if($fS===false){
								if($cpCount==1){
									$x = 300;
								} else {
									$x = $family_data['list'][$i-1]->y_axis + 220;
								}
								$fS = true;
							} else {
								$x = 300;
							}					
						}
						$y = (int)$family_data['list'][$i-1]->y_axis;
						
					} else {
						$chCount++;
					}
				}							
				$family_data['list'][$i]->x_axis = $x;
				$family_data['list'][$i]->y_axis = $y;
					if($i==0){
					if($search===false){
						$color = "#669900";
					} else {
						$color = "#ffbb33";
					}
				} else {
					if($outside===true){
						$color = "#33b5e5";
					} else {
						$color = "#ffbb33";
					}
				}
				$family_data['list'][$i]->color = $color;
				$family_data['list'][$i]->width = $width;
				$family_data['list'][$i]->height = $height;
				$claims = $family->claims;
				$abstract = $family->abstracts;
				$inventors = $family->inventors;
				$assignee = $family->assignee;
				$applicants = $family->applicants;
				$image = $family->images;
				$assigments = array();
				if($family->assigments!=""){
					try{
						$assigments = json_decode($family->assigments);
					}catch(Exception $e){
						$this->logger->addInfo($e->getMessage());
					}
				}
				if($image!=""){
					try{
						$images = json_decode($image);
						if(count($images)>0 && trim($images[0])!=""){
							$image = $images[0];
							if(strpos($image,'https')===false){
								$image = str_replace("http","https",$image);
							}
						}else {
							$image = "";
						}
					}catch(Exception $e){
						$this->logger->addInfo($e->getMessage());
					}
				}else {
					$image = "";
				}
				$publicationDate = $family->publication_date;
				$title = $family->title;
				if($publicationDate!=""){
					$publicationDate = substr($publicationDate,0,4).'-'.substr($publicationDate,4,2).'-'.substr($publicationDate,-2);
				}
				$applicationNumber = $family->application_country.$family->application_number.$family->application_kind;
				/*unset*/
				unset($family_data['list'][$i]->claims);
				unset($family_data['list'][$i]->abstracts);
				unset($family_data['list'][$i]->images);
				unset($family_data['list'][$i]->title);
				unset($family_data['list'][$i]->inventors);
				unset($family_data['list'][$i]->assignee);
				unset($family_data['list'][$i]->applicants);
				/*End unset*/
				if(strpos($claims,"claimsTree")===false){
					$claims = $this->cleanString($claims);
				} else {
					$claims = $this->cleanStringWithoutStripTag($claims);
				}
				$abstract = $this->cleanString($abstract);
				$title = $this->cleanString($title);
				$inventors = $this->cleanString($inventors);
				$assignee = $this->cleanString($assignee);
				$applicants = $this->cleanString($applicants);
				$family_data['list'][$i]->claims = trim($claims);
				$family_data['list'][$i]->abstract = trim($abstract);
				$family_data['list'][$i]->application_number = $applicationNumber;
				$family_data['list'][$i]->image = $image;
				$family_data['list'][$i]->title = trim($title);
				$family_data['list'][$i]->inventors = trim($inventors);
				$family_data['list'][$i]->assignee = trim($assignee);
				$family_data['list'][$i]->applicants = trim($applicants);
				$family_data['list'][$i]->issue_date = $publicationDate;
				$family_data['list'][$i]->assigments = $assigments;
			}			
			$svgHeight = $chCount * 160;
			if(count($family_data['list'])>0){
				for($i=0;$i<count($family_data['list']);$i++){
					$y_axis = $family_data['list'][$i]->y_axis;
					$x_axis = $family_data['list'][$i]->x_axis;
					$orgApp = $family_data['list'][$i]->application_number;
					if(isset($family_data['list'][$i+1]) && $family_data['list'][$i+1]->y_axis == $y_axis){
						$yAxisUSAArray = array();
						$nonUSAyAxisArray = array();
						$yChangeArrayOrg = array();
						if(strtolower($family_data['list'][$i]->publication_country)=="us"){
							$yChangeArrayOrg[] = $family_data['list'][$i];
							$yAxisUSAArray[] = $family_data['list'][$i]->application_number;
						} else {
							$nonUSAyAxisArray[] = $family_data['list'][$i]->application_number;
							$yChangeArrayOrg[] = $family_data['list'][$i];
						}				
						for($j=$i+1;$j<count($family_data['list']);$j++){
							$rec = $family_data['list'][$j];
							if($rec->y_axis == $y_axis){
								$yChangeArrayOrg[] = $rec;
								if(strtolower($rec->publication_country)=="us"){
									$yAxisUSAArray[] = $rec->application_number;
								} else {
									$nonUSAyAxisArray[] = $rec->application_number;
								}
							}					
						}
						sort($yAxisUSAArray);
						$i = $i-1;
						$tap = 0;
						if(count($yAxisUSAArray)>0){
							foreach($yAxisUSAArray as $appOrg){
								$dt = array();
								foreach($yChangeArrayOrg as $chgOrg){
									if($appOrg==$chgOrg->application_number){
										$dt =$chgOrg;
										break;
									}
								}
								if(count($dt)>0){
									$i +=1; 
									if($tap>0){
										$oldXaxis = $family_data['list'][$i-1]->x_axis;
										$dt->x_axis = $oldXaxis + 230;
										$dt->same = true;
									} else {
										if($orgApp!=$dt->application_number){
											$dt->x_axis = 70;
											$dt->same = false;
										}
									}
									$family_data['list'][$i] = $dt;
									$tap++;
								}
							}
						}
						if(count($nonUSAyAxisArray)>0){
							foreach($nonUSAyAxisArray as $appOrg){
								$dt = array();
								foreach($yChangeArrayOrg as $chgOrg){
									if($appOrg==$chgOrg->application_number){
										$dt =$chgOrg;
										break;
									}
								}
								if(count($dt)>0){
									$i +=1; 
									if(count($yAxisUSAArray)>0){
										$oldXaxis = $family_data['list'][$i-1]->x_axis;
										$dt->x_axis = $oldXaxis + 230; 
										$dt->same = true;	
									}
									$family_data['list'][$i] = $dt;
								}
							}
						}
					}
				}
			}
			/*Find Verticals*/
			if(count($family_data['list'])>0){
				for($i=0;$i<count($family_data['list']);$i++){
					$relation = $family_data['list'][$i]->relation;
					$xAppNumber = $family_data['list'][$i]->application_org_number;
					$xAxis = $family_data['list'][$i]->x_axis;
					$yAxis = $family_data['list'][$i]->y_axis;
					if(count($relation)>0){
						foreach($relation as $rel){
							$relAppNumber = $rel->relation_number;
							foreach($family_data['list'] as $assets){
								if($assets->application_org_number == $relAppNumber && $xAxis == $assets->x_axis){
									$verticals[] = array("id"=>$xAppNumber.$relAppNumber,"yexit"=>$yAxis,"yentry"=>$assets->y_axis);
									break;
								}
							}
						}
					}
				}
			}
			if(count($family_data['list'])>0){
				for($i=0;$i<count($family_data['list']);$i++){
					$relation = $family_data['list'][$i]->relation;
					if(count($relation)>0){	
						$recSort = array();
						foreach($relation as $rel){
							$recSort[]['relation_number'] = $rel->relation_number;
						}
						array_multisort($recSort, SORT_ASC, $relation);
						$family_data['list'][$i]->relation = $relation;
					}
				}
			}
			if(count($family_data['list'])>0){
				for($i=0;$i<count($family_data['list']);$i++){
					$rect = $family_data['list'][$i];
					$rectX = $rect->x_axis;
					$relation = $rect->relation;
					$xCArray = array();
					if(count($relation)>0){
						for($j=0;$j<count($relation);$j++){
							$relationAppNumber = $relation[$j]->relation_number;
							foreach($family_data['list'] as $list){
								if($list->application_org_number == $relationAppNumber && $rectX==$list->x_axis){
									$xCArray[] = $j;
									break;
								}
							}
						}
						if(count($xCArray)>0){
							foreach($xCArray as $c){
								$relation[$c]->count = count($xCArray);
							}
							$family_data['list'][$i]->relation = $relation;
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
			$jsonRectangles = $family_data['list'];
			if(count($jsonRectangles)>0){
				foreach($jsonRectangles as $rectangle){
					$applicationListIDS[] = $rectangle->application_org_number;
				}
			}
			if(count($jsonRectangles)>0){
				foreach($jsonRectangles as $rectangle){
					if(count($rectangle->relation)>0){
						foreach($rectangle->relation as $relation){
							$pID = $relation->patent_app_number;
							$cID = $relation->relation_number;
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
												$childList[$i][2] = number_format(155/$childList[$i][1],2, '.', '');
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
												$parentList[$i][2] = number_format(155/$parentList[$i][1],2, '.', '');
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
		}		
		/*End of manipulating family list */
		if(count($verticals)>0){
			/*First sort by Yentry and then Yexit*/
			$this->sort_array_of_array($verticals, 'yentry');
			$this->sort_array_of_array($verticals, 'yexit');
			if(count($verticals)>15){
				$gapValue = 150/count($verticals);
			} else {
				$gapValue = 9;
			}
			$start = 80;
			for($i=0;$i<count($verticals);$i++){
				if($i>0){$start +=$gapValue;}
				$verticals[$i]['x_axis'] = $start;
			}
		}
		/*End sorting*/
		if(count($family_data['list'])>0){
			for($i=0;$i<count($family_data['list']);$i++){
				$rect = $family_data['list'][$i];
				$relation = $rect->relation;
				$xAppNumber = $rect->application_org_number;
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
						$relationNumber = $rel->relation_number;
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
								if($assets->application_org_number==$relationNumber){
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
										if($aRelation->relation_number == $relationNumber ){
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
		$illustrationArray = array('_jsonRectangles'=>$jsonRectangles,'_jsonCountries'=>$countries,'_jsonRelations'=>$jsonRelations,'_chList'=>$childList,'_prList'=>$parentList,'_verticals'=>$verticals,'_nonverticals'=>$nonVerticalsEntries,'_nonverticalsExits'=>$nonVerticalsExits,'_width'=>($svgWidth+50),'_height'=>$svgHeight);
		if(count($family_data['list'])>0){
			$returnData = array('status'=>200,'data'=>$illustrationArray);
		} else {
			$returnData = array('status'=>200 ,'message'=>'No record found','data'=>array());
		}
		return $returnData;
	}
	
	/*clean string with semicolon,colon*/
	private function cleanStringWithoutStripTag($string){
		$string = trim($string);
		$string = preg_replace("/'/", "",$string);
		$regex = '/(\s|\\\\[rntv]{1})/';
		$string = preg_replace($regex, ' ', $string);
		return $string;
	}
	
	/*Multi sort array*/
	private function sort_array_of_array(&$array, $subfield){
		$sortarray = array();
		foreach ($array as $key => $row){
			$sortarray[$key] = $row[$subfield];
		}
		array_multisort($sortarray, SORT_ASC, $array);
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
	
	public function get_linkedin_messages(){		
		$this->load->model('lead_model');
		$list = $this->lead_model->getLinkedinMessagesList();
		echo json_encode($list);
		die;
	}
	
	public function show_linkedin_message($ID=0){
		if($ID > 0){
			$this->load->model('lead_model');
			$data['message'] = $this->lead_model->getLinkedinMessageById($ID);
			$this->layout->auto_render=false;	
			$this->layout->layout='email';
			$this->layout->title_for_layout = 'Linkedin Message';
			$this->layout->render('leads/show_linkedin_message',$data);
		} else{
			echo "Invalid input data";
			die;
		}		
	}
	
	public function show_linkedin_filed_message($ID = 0){
		if($ID > 0){
			$this->load->model('lead_model');
			$message = $this->lead_model->getSalesActivityLogByID($ID);
			if(count($message) == 0){
				$message = $this->lead_model->getAcquisitionActivityLogByID($ID);
			}
			$data['message'] = $message;
			$this->layout->auto_render=false;	
			$this->layout->layout='email';
			$this->layout->title_for_layout = 'Linkedin Message';
			$this->layout->render('leads/show_linkedin_filed_message',$data);
		} else{
			echo "Invalid input data";
			die;
		}
	}
	
	public function count_linkedin_messages(){
		$data = array("counter"=>0);
		$this->load->model('lead_model');
		$data['counter'] = $this->lead_model->countLinkedinMessages();
		echo json_encode($data);
		die;
	}
	
	public function send_linkedin_message_queue(){
		$data = array('send'=>0);
		if(isset($_POST)){
			$postData = $this->input->post();
			$postData['user_id'] = $this->session->userdata['id'];
			$this->load->model('lead_model');
			$data['send'] = $this->lead_model->insertSendLinkedinMessage($postData);
		}
		echo json_encode($data);
		die;
	}
	
	public function find_contact_by_name(){
		$list = array();
		if(isset($_POST)){
			$this->load->model('client_model');
			$threadID = $this->input->post('conversation_id');
			if($threadID != ""){
				$list = $this->client_model->findContactByThreadID($threadID);
				if(count($list) == 0){
					$list = $this->client_model->findContactByThreadIndentifier($threadID);
				}
				
			}
			if(count($list) == 0){
				$list = $this->client_model->getContactByName($this->input->post('first_name'),$this->input->post('last_name'));
			}
		}
		echo json_encode($list);
		die;
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
	
	function update_maximum_scrape_users(){		
		$data = 0;
		if(isset($_POST) && count($_POST)>0){			
			$maximumScrapeUsers = $this->input->post('scrape_numbers');
			if($maximumScrapeUsers > 0){
				$this->load->model('lead_model');
				$data = $this->lead_model->updateMaximumScrapeUsers(array('scrape_numbers'=>$maximumScrapeUsers));
			}
		}
		echo $data;
		die;
	}
	
	function update_expression_query(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){			
			$updateList = $this->input->post('e');
			if(count($updateList) > 0){
				$this->load->model('lead_model');
				foreach($updateList as $c){
					$d = (array)$c;
					if($d['id'] > 0){
						$data = $this->lead_model->updateLinkedInExpression(array('keyword'=>$d['keyword'],'title'=>$d['title']),$d['id']);
					}
				}
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
	
	function getContactDetail(){
	  $token = 'xx4ljfSFPorJ7dfG8fKcUw48vmqJOsel';
	   $ch = curl_init('https://api.fullcontact.com/v3/person.enrich'); // Initialise cURL
       $post = json_encode(array('email'=>"pcharatz@fujielectric.com","fullName"=>"Phil Charatz")); // Encode the data array into a JSON string
       $headers = [
            'Authorization: Bearer ' . $token,
        ];
	   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Inject the token into the header
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_POST, 1); // Specify the request method as POST
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post); // Set the posted fields
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // This will follow any redirects
       $result = curl_exec($ch); // Execute the cURL statement
       curl_close($ch); // Close the cURL connection
	   echo "<pre>";
	   if(!empty($result)){
		   print_r(json_decode($result ));
	   }
	   
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
							$fileNameImage = 'https://backyard.synpat.com/public/upload/businesscards/'.$getFileInfo->title;
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
		}
		echo json_encode($data);
		die;
	}
	
	public function findOtherSalesBoxes(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$data = array("list"=>array(),'company_id'=>$this->input->post('c'),'lead'=>$this->input->post('lead'),'t'=>$this->input->post('t'));
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['list'] = $this->lead_model->getOtherSalesActivityLead($this->input->post());
		}
		echo json_encode($data);
		die;
	}
	
	public function findAllCompanyActivities(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->getAllCompanyActivities($this->input->post());
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
				/*if($data['detail'][0]['acquisitions']->category>0){
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
						$urlName = md5($serialNumber);
						//$urlName = $this->encode($urlName);
					}
				}*/
				$urlName = md5($serialNumber);
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
					if(count($data['detail'][0]['patentees'])>0){
						$data['detail'][0]['patentees']->lead_seller_contact = $data['detail'][0]['litigation']->seller_contact;
						$data['detail'][0]['patentees']->lead_broker_contact = $data['detail'][0]['litigation']->broker_contact;
						$data['detail'][0]['patentees']->lead_broker_person_contact = $data['detail'][0]['litigation']->broker_person_contact;
						if((int)$data['detail'][0]['litigation']->broker_person>0){
							$this->load->model('client_model');
							$getInfo = $this->client_model->getInfo($data['detail'][0]['litigation']->broker_person,'email');
							if(count($getInfo)>0){
								$data['detail'][0]['patentees']->lead_broker_person_contact_email = $getInfo->email; 
							}
						}
					}					
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
	
	function search_temp_company(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$query = $this->input->get('query');
		$this->load->model('lead_model');
		$companyList = $this->lead_model->findTempCompanyBySearch($query," c.company_name as Name");
		echo json_encode($companyList);
		die;
	}
	
	function pre_merge_companies(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$sectors = "";
		$categories = array();
		$subCategories = array();
		$sort = 'c.company_name';
		$sortBy = 'ASC';
		$resultData = array('data'=>array(),'count_all'=>0);
		if(isset($_POST) && count($_POST)>0){
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
				$this->load->model('lead_model');
				$resultData = $this->lead_model->getAllMergeCompanies($searchString,$sector,$cat,$subCat,$sort,$sortBy,$start,$end);
			} catch(Exception $e){}
		}
		$data['companies'] = $resultData['data'];
		$data['count_all'] = $resultData['count_all'];
		$data['cat'] = $resultData['cat'];
		$data['sub_cat'] = $resultData['sub_cat'];
		echo json_encode($data);
		die;
	}
	
	function pre_companies($leadID=0){
		$this->load->model('lead_model');
		$this->load->model('opportunity_model');
		$data = array('companies'=>array(),'linkedin_query'=>array(),'listing_companies'=>array());
		$resultData = $this->lead_model->getAllMergeCompanies('','','','','c.company_name','ASC',0,200);
		$data['companies'] = $resultData['data'];
		$data['linkedin_query'] = $this->lead_model->getLinkedinQueryData();
		if($leadID>0){
			$data['listing_companies'] = $this->opportunity_model->getCompanyListing("company_id,type",$leadID);
		} 
		$this->layout->layout='outsource';	
		$this->layout->auto_render=false;	
		$this->layout->title_for_layout = 'Backyard Leads';
		$this->layout->render('leads/pre_companies',$data);
	}
	
	/*function pre_companies($leadID=0){
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
	}*/
	
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
	
	function delete_from_temp_company(){
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			echo $this->lead_model->deleteTempCompany($this->input->post('id'));
		}
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
					/*$data['drive'] = $service->getFileIDFromChildern($findLeadData->folder_id);*/
					$q = "'".$findLeadData->folder_id."' in parents";
					$data['drive'] = $service->getAllFilesAndFolder($q);
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
					/*$data['drive'] = $service->getFileIDFromChildern($this->input->post('f'));*/
					$q = "'".$this->input->post('f')."' in parents";
					$data['drive'] = $service->getAllFilesAndFolder($q);
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
					/*$data = $service->getFileIDFromChildern($findLeadData->seller_material_folder_id);*/
					$q = "'".$findLeadData->seller_material_folder_id."' in parents";
					$data = $service->getAllFilesAndFolder($q);
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
	
	function import_new_company_spreadsheet(){
		$fileID = '12YVwMoXJuxI4fjUMuZY9tNEr_wrDOipoo-q84Lc6_SU';
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();		
		$fileGet =  $service->getFileInfo($fileID);
		$spreadSheetService = new SpreadsheetServiceHelper();
		$spreadsheet = $spreadSheetService->getSpreadsheetById($fileGet->id);
		$allWorkSheet = $spreadSheetService->getAllWorkSheets();
		$workSheetName = "";			
		if(empty($workSheetName)){
			$workSheetName = "Sheet1";
		}						
		$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
		$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());
		$companyBulkData = array();
		foreach($asset_data as $c){
			array_push($companyBulkData,array('company_name'=>$c['companyname'],'industry'=>$c['industry'],'revenue'=>$c['revenuem'],'country'=>$c['country'],'city'=>$c['city'],'state'=>$c['areastate'],'company_address'=>$c['location'],'label'=>1));
		}
		$this->load->model('lead_model');
		$this->lead_model->insertCompanyBatch($companyBulkData);
		//insertCompanyBatch
		echo "<pre>";
		print_r($companyBulkData);
		die;
	}
	
	function export_ipc_code_definition($page,$start,$t){
		$fileID = '1-wDOLsPaCI5tHl0BaP1EuaUpsJpsOQ8bVUktS-N9UGg';
		$this->load->library('DriveServiceHelper');
		$service = new DriveServiceHelper();		
		$fileGet =  $service->getFileInfo($fileID);
		$spreadSheetService = new SpreadsheetServiceHelper();
		$mp = $t+2;
		/*$spreadsheet = $spreadSheetService->getSpreadsheetById($fileGet->id);
		$allWorkSheet = $spreadSheetService->getAllWorkSheets();
		$workSheetName = "";			
		if(empty($workSheetName)){
			$workSheetName = "Sheet1";
		}						
		$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
		$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());*/
		$this->load->model('lead_model');
		$asset_data =$this->lead_model->getAllIPCCodes($page,$start);
		if(count($asset_data)>0){
			
			$fileID = $fileGet->id;
			$sheetCellValues = array();
			$scrapeIPCCode = array();
			for($i=0;$i<count($asset_data);$i++){
				$ipcCode = $asset_data[$i]->ipc;
				if(!in_array(trim($ipcCode),$scrapeIPCCode)){
					$startCode = strtoupper(strtolower(substr($ipcCode,0,1)));
					if($startCode=="G" || $startCode=="H"){
						$findIPCDefinition = $this->lead_model->getIPCCodeList(trim($ipcCode));
						
						/*echo "Search For:".trim($ipcCode)."<br/>";*/
						$sheetRange = "Sheet1!A".($mp);
						$sheetCellValues[] = array('majorDimension'=>"COLUMNS",'range'=>$sheetRange,'values'=>[[trim($ipcCode)]]);
						if(count($findIPCDefinition)>0){
							
							/*echo "<pre>";
							print_r($findIPCDefinition);
							echo "</pre>";*/
							$count = count($findIPCDefinition);
							if($count>2){
								$count = $count-1;
							}
							$charArray = ["B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S"];
							$charA = 0;
							for($s = $count-1;$s>=0;$s--){
								$sheetRange = "Sheet1!".$charArray[$charA].($mp);
								$cellValue = $findIPCDefinition[$s]->classification_description;
								$sheetCellValues[] = array('majorDimension'=>"COLUMNS",'range'=>$sheetRange,'values'=>[[$cellValue]]);
								$charA++;
							}
							
						}
					}
					array_push($scrapeIPCCode,trim($ipcCode));
					$mp++;
				}
			}
			if(count($sheetCellValues)>0){
				/*echo "<pre>";
				print_r($sheetCellValues);
				die;*/
				$returnV = $spreadSheetService->updateCellValueBatch($fileID,$sheetCellValues);
				echo "<pre>";
				print_r($returnV);
				die;
			}			
		}
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
		echo "<style>.gb_Uf, .gb_Vf,.kd-appbar,.gb_4f,#gba,.gb_1b,#gbq,#gbq1,.gb_nb{display:none !important;}</style>";
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
	
	public function findLeadPatentFileAndSheet($leadID = 0){
		$data = array('file_url'=>'','spreadsheet_id'=>'');
		if($leadID!="" && (int)$leadID>0){
			$this->load->model('lead_model');		
			$getData = $this->lead_model->getLeadDataWithOptions($leadID,'l.file_url,l.spreadsheet_id');
			if(count($getData)>0){
				$data['file_url'] = $getData->file_url;
				$data['spreadsheet_id'] = $getData->spreadsheet_id;
			}
		}
		echo json_encode($data);
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
				$q = "title contains 'Patent List' and mimeType = 'application/vnd.google-apps.spreadsheet' and '".$folderID."' in parents";
				/*$listFiles = $service->searchFileIDFromChildern($folderID,$q);*/
				$listFiles = $service->getAllFilesAndFolder($q);
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
			/*$getInfo = $driveService->getFileInfo($fileID);*/
			$getInfo = $driveService->getFileInfoWithOptions($fileID,array('fields'=>'alternateLink'));
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
				$getAllPatentsFromFamily = $this->lead_model->getAllEPOFamiliesLeft($leadID);
				if(count($getAllPatentsFromFamily['publications'])>0){
					$applicationList = $this->applicationList;
					$i = 0;
					$unsetNumber = array();
					foreach($getAllPatentsFromFamily['publications'] as $patent){
						$publicationKind = $patent->publication_kind;
						$countryCode = strtoupper($patent->publication_country);
						if(isset($applicationList[$countryCode]) && count($applicationList[$countryCode])>0){
							if(in_array($publicationKind,$applicationList[$countryCode])){
								$unsetNumber[] = $i;
							}
						}
						$i++;
					}
					if(count($unsetNumber)>0){
						foreach($unsetNumber as $i){
							if(isset($getAllPatentsFromFamily['publications'][$i])){
								$getAllPatentsFromFamily['publications'][$i]->type = "Application";
							}
						}
					}
					for($i=0;$i<count($getAllPatentsFromFamily['publications']);$i++){
						if(!isset($getAllPatentsFromFamily['publications'][$i]->type)){
							$getAllPatentsFromFamily['publications'][$i]->type = "Patent";
						}
					}
				}
				$priorityPatentList = array();
				$epoToken = "";
				for($i = 0; $i<count($getAllPatentsFromFamily['publications']); $i++){
					$family = $getAllPatentsFromFamily['publications'][$i];
					if($family->publication_country != "EP" && $family->publication_country != "ES") {
						if($family->type == "Patent") {
							if($family->priority_date == null) {
								$date = "";
								if($family->publication_country == "US") {
									$priorityData = $this->lead_model->patentDetailInfo($family->publication_number,"filling_date");
									if(count($priorityData) > 0) {
										$date = $priorityData->filling_date;
									}
								}
								if($date != "" && $date != null) {
									$getAllPatentsFromFamily['publications'][$i]->priority_date = $date;
								} else {
									$publishPatentNumber = $family->publication_country.$family->publication_number.$family->publication_kind;
									if($epoToken == "") {
										$this->load->library('EpoDoc',array('key'=>'9Xx2YnGvcjhCkeGLFAyVJLJgZSuaPjYs','secret'=>'WgLvbrHl9QOyykTT'));
										try{
											$epoDocToken = $this->epodoc->read_token('HedCET');	
											if(! $epoDocToken['error']) {
												$epoToken = $epoDocToken;
											}
										}catch(Exception $e) {
											
										}
									}
									if($epoToken != "") {
										$publishPatentNumber = $family->publication_country.$family->publication_number.$family->publication_kind;
										$getBiblioData = $this->epodoc->runUrl($epoToken,'published-data','publication','epodoc',$publishPatentNumber,'biblio','');
										if(empty($getBiblioData['error'])){
											if(!empty($getBiblioData['data'])){
												$xml=simplexml_load_string($getBiblioData['data']);
												if ($xml !== false) {
													$xmlObject = new SimpleXMLElement($getBiblioData['data']);
													if(isset($xmlObject->code) && $xmlObject->code=="SERVER.EntityNotFound" &&  isset($xmlObject->message) && $xmlObject->message=="No results found"){
													} else {
														$worldPatentData = $xmlObject->xpath('//ops:world-patent-data');
														if(isset($worldPatentData[0])){
															$exchangeDocuments = $worldPatentData[0]->{'exchange-documents'};
															$exchangeDocument = $exchangeDocuments->{'exchange-document'};
															$biblioData = $exchangeDocument->{'bibliographic-data'};
															if(isset($biblioData->{'priority-claims'}) && count($biblioData->{'priority-claims'}) > 0) {
																$priorityClaims = $biblioData->{'priority-claims'};
																if(count($priorityClaims) > 0) {
																	$priorityClaim = $priorityClaims[0]->{'priority-claim'};
																	$priorityDocIds = $priorityClaim->{'document-id'};
																	foreach($priorityDocIds as $docID){
																		if($docID['document-id-type']=="epodoc"){
																			$date = (string)$docID->{'date'};
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
									if($date != "" && $date != null) {
										$getAllPatentsFromFamily['publications'][$i]->priority_date = $date;
									}
								}
							}						
						}
					}
				}
				$lifeSpan = array();
				$lifeSpanChartData = array();
				foreach($getAllPatentsFromFamily['publications'] as $family) {
					if($family->publication_country != "EP" && $family->publication_country != "ES") {
						$currentDate = trim($family->priority_date);
						if($currentDate != null && $currentDate != "") {
							$expirationDate = date('m/d/Y',strtotime("+20 years",strtotime($currentDate)));
							try{
								$expirationYear = date('Y',strtotime($expirationDate));
								$currentYear = date('Y');
								$publishPatentNumber = $family->publication_country.$family->publication_number.$family->publication_kind;
								for($i=$currentYear;$i<=$expirationYear;$i++){
									$lifeSpanChartData[] = array($i,$publishPatentNumber);
								}
							}catch(Exception $e){
								
							}
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
				/*Delete Patents*/
				$this->opportunity_model->deleteDueDilligencePatent($getLicenseData->id);
				$this->opportunity_model->addDueDilligencePatentThroughLead($leadID,$getLicenseData->id);
				/*End Right Chart*/				
			}
		}
		die;
	}
	
	function run_job_queue(){
		exec('php5.6 -f /var/www/synpat/backyard/patent_family_queue.php');
		$jobData = array();
		if(isset($_POST) && $this->input->post('job_id')){
			$this->load->model('lead_model');
			$jobData = $this->lead_model->findJobDetails($this->input->post('job_id'),'account as account_id');
		}
		echo json_encode($jobData);
		die;
	}
	
	function find_patent_list(){
		$patentList = array();
		if(isset($_POST) && $_POST['l']>0){
			$this->load->model('lead_model');
			$patentList = $this->lead_model->getLeadPatentList($this->input->post('l'));
		}
		echo json_encode($patentList);die;
	}	
	public function pam($leadID){
		$this->dueDilligenceLeftRightChart($leadID);
		die;
	}
	
	function update_docket_tab(){
		$data = 0;
		if(isset($_POST) && count($_POST)>0){
			$data = array();
			if($_POST['t']==1){
				$data['invalidation_tab'] = $_POST['c'];
			}else if($_POST['t']==2){
				$data['eou_tab'] = $_POST['c'];
			}
			if(count($data)>0 && $_POST['lead_id']>0){
				$this->load->model('lead_model');
				$data = $this->lead_model->from_litigation_update($_POST['lead_id'],$data);
			}
		}
		echo $data;
		die;
	}
	
	function getDocketTabData($leadID = 0){
		$getData = array("eou_tab"=>0,"invalidation_tab"=>0);
		if($leadID > 0){
			$this->load->model('lead_model');
			$getData = $this->lead_model->getLeadDataWithOptions($leadID,"l.eou_tab,l.invalidation_tab");
		}
		echo json_encode($getData);
		die;
	}
	
	public function check_job_parent_patent(){
		$data = array('count'=>0,'job_id'=>0,'account_id'=>0,'data'=>array(),'status'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$checkJObStatus = $this->lead_model->findJobDetails($this->input->post('j'),'status,account');
			if(count($checkJObStatus)>0){
				$data = $this->lead_model->getLeadPatentDataList($checkJObStatus->account);
				if($data['count']>0 && count($data['data'])>0 && count($data['data'])==$data['count']){
					$this->addUpdateDocket($checkJObStatus->account);
					$this->dueDilligenceLeftRightChart($checkJObStatus->account);
				}
				$data['account_id'] = $checkJObStatus->account;
				$data['status'] = $checkJObStatus->status;
			}
			$data['job_id'] = $this->input->post('j');
		} 
		echo json_encode($data);
		die;
	}
	
	function addUpdateDocket($leadID) {
		$this->load->model('acquisition_model');
		$createFlag = 0;
		$getAcData = $this->acquisition_model->getData($leadID);
		if(count($getAcData)>0){
			if(empty($getAcData['acquisition']->store_name)){
				$createFlag = 1;
			}
		} else {
			$createFlag = 1;
		}
		$this->load->model('opportunity_model');
		$leadData = $this->lead_model->getLeadDataWithOptions($leadID,'l.serial_number,l.lead_name,l.ppa_id,l.ppa_date,l.ppa_text_date');
		if(count($leadData) > 0) {
			if($createFlag === 1) {
				$newDataForAccordionText = $this->lead_model->getLicenseData(12345);
				$leadName = $leadData->lead_name;
				$leadName = str_replace(' ','_',$leadName);
				$license_status = 0;
				$asking_price = 0;
				$licenseData = array('license_status'=> $license_status,'license_number'=>$leadData->serial_number,'name'=>$leadName,'access_code'=>12345,'due_access_code'=>12345,'tabs_access_code'=>12345,'asking_price'=>$asking_price,'serial_number'=>$leadData->serial_number,'portfolio_tab'=>$newDataForAccordionText->portfolio_tab,'counter_tab'=>$newDataForAccordionText->counter_tab,'claim_tab'=>$newDataForAccordionText->claim_tab,'invention_tab'=>$newDataForAccordionText->invention_tab,'evidence_tab'=>$newDataForAccordionText->evidence_tab,'comparables_tab'=>$newDataForAccordionText->comparables_tab,'royalties_tab'=>$newDataForAccordionText->royalties_tab,'fcitation_tab'=>$newDataForAccordionText->fcitation_tab,'seller_tab'=>$newDataForAccordionText->seller_tab,'pdf_tab'=>$newDataForAccordionText->pdf_tab,'validity_tab'=>$newDataForAccordionText->validity_tab,'bcitation_tab'=>$newDataForAccordionText->bcitation_tab,'document_tab'=>$newDataForAccordionText->document_tab,'price_tab'=>$newDataForAccordionText->price_tab,'simulator_tab'=>$newDataForAccordionText->simulator_tab,'prior_tab'=>$newDataForAccordionText->prior_tab,'legal_tab'=>$newDataForAccordionText->legal_tab,'privacy_tab'=>$newDataForAccordionText->privacy_tab,'store_tab'=>$newDataForAccordionText->store_tab,'seller_dd'=>$newDataForAccordionText->seller_dd,'tech_dd'=>$newDataForAccordionText->tech_dd,'market_dd'=>$newDataForAccordionText->market_dd,'legal_dd'=>$newDataForAccordionText->legal_dd,'illustration_dd'=>$newDataForAccordionText->illustration_dd,'image_dd'=>$newDataForAccordionText->image_dd,'pdf_dd'=>$newDataForAccordionText->pdf_dd,'dictionary_dd'=>$newDataForAccordionText->dictionary_dd,'intro_dd'=>$newDataForAccordionText->intro_dd,'deactive_tooltip'=>$newDataForAccordionText->deactive_tooltip,'deactive_tooltip_regular'=>$newDataForAccordionText->deactive_tooltip_regular,'deactive_tooltip_risk'=>$newDataForAccordionText->deactive_tooltip_risk,'popup_text_participant'=>$newDataForAccordionText->popup_text_participant,'popup_text_regular'=>$newDataForAccordionText->popup_text_regular,'popup_text_risk'=>$newDataForAccordionText->popup_text_risk,'introduction'=>$newDataForAccordionText->introduction);
				$licenseID = $this->lead_model->insertLicenseData($licenseData);
				if($licenseID > 0) {
					$getAcqData = array();
					$getAcqData['acquisition']['create_date'] = date('Y-m-d H:i:s');
					$getAcqData['acquisition']['store_name'] = $leadName;
					$getAcqData['acquisition']['lead_id'] = $leadID;
					$reportArray = array('lead_id'=>$leadID);
					if($leadData->ppa_id!=""){
						$this->load->library('DriveServiceHelper');
						$service = new DriveServiceHelper();
						$getFileInfo = $service->getFileInfo($leadData->ppa_id);
						$url = $getFileInfo->alternateLink;
						$getAcqData['acquisition']['ppa'] = $url;
						$reportArray['draft_a_ppa'] = 2;
					}
					if($leadData->ppa_date!=null){
						$reportArray['execute_ppa'] = 3;
					}
					if($leadData->ppa_text_date!=null){
						$reportArray['execute_ppa'] = 2;
					}
					$saveData = $this->acquisition_model->insertAcquisition($getAcqData['acquisition']);
					/*Insert Docket Buttons*/
					$this->load->model('general_model');
					$getButtonList = $this->general_model->getAllButtonList("DOCKET");
					if(count($getButtonList)>0){
						foreach($getButtonList as $button){
							$this->lead_model->insertDocketButton(array("lead_id"=>$leadID,"sort"=>$button->sort,"button_id"=>$button->id));
						}
					}
					/*End Insert Docket Buttons*/
					$this->opportunity_model->addDueDilligencePatentThroughLead($leadID,$licenseData->id);
					$patentList = $this->opportunity_model->getDuePatentDataListByLeadID($licenseData->id,"patent_number");
					if(count($patentList)>0){
						$this->addUpdatePDF($patentList);
					}
					$this->opportunity_model->insertLevel(array('lead_id'=>$leadID,'level'=>5));
					$this->opportunity_model->insertReport($reportArray);
				}
			} else {
				$licenseData = $this->opportunity_model->getLicenseDataByLeadID($leadData->serial_number,"id");
				$this->opportunity_model->deleteDueDilligencePatent($licenseData->id);
				$this->opportunity_model->addDueDilligencePatentThroughLead($leadID,$licenseData->id);
				$patentList = $this->opportunity_model->getDuePatentDataListByLeadID($licenseData->id,"patent_number");
				if(count($patentList)>0){
					$this->addUpdatePDF($patentList);
				}
			}
		}
	}
	
	public function addUpdatePDF($patentList) {
		$this->load->model('lead_model');
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
	
	function filterInt($number){
		return filter_var($number, FILTER_SANITIZE_NUMBER_INT);
	}
	
	public function lead_illustration_table($patentNumber){
		$this->load->model('lead_model');
		if($patentNumber!=null){
			$getData = $this->lead_model->findFromRealTimeParentChildScrap($patentNumber);
			if(count($getData['parent'])>0){
	
	?>
			<h3>Prime Parents<h3>
			<table>
				<tbody>
					<?php 
						foreach($getData['parent'] as $p){
					?>
						<tr>
							<td><?php echo $p['relation_number']?></td>
						</tr>
					<?php
						}
					?>
				<tbody>
			</table>
			<?php }
			if(count($getData['child'])>0){
			
			?>
			
			<h3>Child<h3>
			<table style='width:50%;'>
				<tbody>
					<?php 
						$childShow = array();
						foreach($getData['child'] as $p){
							$show=true;
							if(count($childShow)>0){
								foreach($childShow as $t){
									if($this->filterInt($t['pat_app_number'])==$this->filterInt($p['pat_app_number']) && $this->filterInt($p['relation_number'])==$this->filterInt($t['relation_number'])){
										$show=false;
										break;
									}
								}
							}
							if($show==true):
							$childShow[] = array('pat_app_number'=>$p['pat_app_number'],'relation_number'=>$p['relation_number']);
					?>
						<tr>
							<td><?php echo $p['pat_app_number']?></td>
							<td><?php echo $p['relation_number']?></td>
							<td><?php echo $p['relation_type']?></td>
						</tr>
					<?php
							endif;
						}
					?>
				<tbody>
			</table>
	<?php
			}
		}
		die;
	}
	
	public function lead_patent_data(){
		$data = array('data'=>array(),'job_queue'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->getLeadPatentParentData($this->input->post('l'));
			if(count($data['data'])>0){				
				//$this->dueDilligenceLeftRightChart($this->input->post('l'));
			} else {
				/*Find is in Queue*/
				$checkJObStatus = $this->lead_model->findJobDetailsByLead($this->input->post('l'),'status,id');
				if(count($checkJObStatus)>0 && $checkJObStatus->status==0){
					$data['job_queue'] = $checkJObStatus->id;
				}
			}
			$data['lead'] = $this->lead_model->getLeadDataWithOptions($this->input->post('l'),'spreadsheet_id,worksheet_id,worksheet_name,folder_id');
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
				$leadInfo = $this->lead_model->getLeadDataWithOptions($_POST['lead_id'],'folder_id,type');
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
									/*$service->setPermissions( $getFile->id, "uzi@synpat.com","writer","user");*/
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
			/*$btnInfo = $this->lead_model->findLeadButtonByID($_POST['lead_id'],$_POST['b']);*/
			$btnInfo = $this->lead_model->findLeadButtonData($_POST['lead_id'],$_POST['b']);
			if(count($btnInfo)==0){
				$btnInfo = $this->lead_model->findDocketButtonByID($_POST['lead_id'],$_POST['b']);
			}
			$status = 1;
			if(isset($_POST['status']) && $_POST['status']>0){
				$status = $_POST['status'];
			}
			if($btnInfo->lead_columns!="" && $btnInfo->lead_columns!="--"){
				$status = 1;
			} else {
				$status = 2;
			}
			$update_data = array('blink'=>'2','status'=>$status,'update_date' => date('Y-m-d H:i:s'));
			$saveMarket = $this->lead_model->updateButton($update_data,$btnInfo->id);
			if($saveMarket==0){
				$getData = $this->lead_model->findButtonID($btnInfo->id,$_POST['lead_id']);
				if(count($getData)>0 && $getData->blink==2){
					$saveMarket = 1;
				}
			}
			if($saveMarket>0){
				if($btnInfo->lead_columns!="" && $btnInfo->lead_columns!="--"){
					$updateData = array();
					$updateData[$btnInfo->lead_columns] = date('Y-m-d H:i:s');
					$this->lead_model->from_litigation_update($_POST['lead_id'],$updateData);
				}
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
				$updateDate = date('Y-m-d H:i:s');
				$columnUpdate = "";
				$originalButtonData = $this->lead_model->findButtonByButtonID($leadInfo->type,"CLAIM_ILLUS");
				if(count($originalButtonData)>0){
					$leadButtonData = $this->lead_model->findLeadButtonByButtonID($leadInfo->id,$originalButtonData->id);
					if(count($leadButtonData)>0){
						$columnUpdate = $originalButtonData->lead_columns;
						$newStatus = "";									
						$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButtonData->status_message;
						/*$newStatus = $leadButtonData->status_message_fill.$newStatus;	*/
						$this->lead_model->updateButton(array('status'=>2,'update_date'=>date('m-d-y',strtotime($updateDate)),'status_message_fill'=>$newStatus),$leadButtonData->id);
						$data = array("error"=>0,"message"=>"Successfully created.", 'update_date'=>date('m/d/y',strtotime($updateDate)),"column_update"=>$columnUpdate);
						if($originalButtonData->lead_columns!=""){
							$updateData = array();
							$updateData[$originalButtonData->lead_columns] = date('Y-m-d H:i:s',strtotime($updateDate));
							$this->lead_model->from_litigation_update($_POST['lead_id'],$updateData);
						}
					}else {
						$data = array("error"=>1,"message"=>"Server busy, Try after sometime.");
					}
				}else {
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
						/*$updateInfo = array('claim_status_dd'=>'1','claim_illus_file'=>$getFile->id,'claim_illus' => $updateDate);
						$saveMarket = $this->lead_model->from_litigation_update($_POST['lead_id'],$updateInfo);*/
					}
					$columnUpdate = "";
					$originalButtonData = $this->lead_model->findButtonByButtonID($leadInfo->type,"CLAIM_ILLUS");
					if(count($originalButtonData)>0){
						$leadButtonData = $this->lead_model->findLeadButtonByButtonID($leadInfo->id,$originalButtonData->id);
						if(count($leadButtonData)>0){
							$columnUpdate = $originalButtonData->lead_columns;
							$newStatus = "";									
							$newStatus = '<span class="date-style">'.date('m-d-y',strtotime($updateDate)).'</span>'.$originalButtonData->status_message_click;
							/*$newStatus = $leadButtonData->status_message_fill.$newStatus;	*/
							$this->lead_model->updateButton(array('status'=>1,'update_date'=>date('m-d-y',strtotime($updateDate)),'status_message_fill'=>$newStatus),$leadButtonData->id);
							if($originalButtonData->lead_columns!=""){
								$updateData = array();
								$updateData[$originalButtonData->lead_columns] = date('Y-m-d H:i:s',strtotime($updateDate));
								$this->lead_model->from_litigation_update($_POST['lead_id'],$updateData);
							}
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
					if(count($asset_data) > 0) {
						$patentList = array();
						foreach($asset_data as $p){
							array_push($patentList,$p->patent);
						}
						$this->lead_model->emptyIllustrationTable($patentList);
					}
					/*End Patent File*/														    
					$data = array("url"=>$subfolderCreate,"spread_sheet_id"=>$subfolderCreate,"mimeType"=>$subfolderCreate,'iconLink'=>'','title'=>'',"pp"=>count($asset_data),"f_t"=>'Claim',"error"=>0,"message"=>"Successfully created.",'date_created' => date('m/d/y',strtotime($updateDate)),'patent_list'=>$asset_data,'folder_id'=>$subfolderCreate,'ss_id'=>"",'lead_name'=>$leadInfo->lead_name,"column_update"=>$columnUpdate);					
				
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
						$this->load->model('lead_model');
						$this->lead_model->addUpdatePatentIllustrationFile($getPresentationFileInfo->alternateLink,$p);
						/*$service->setAdditionalPermissions( $getPresentationFileInfo->id, "","reader","anyone"); */	
						$service->setAdditionalPermissions( $getPresentationFileInfo->id, "","writer","anyone");	
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
	
	function loadFileFromLinkedInCompany(){
		$this->load->library('DriveServiceHelper');
		$spreadSheetService = new SpreadsheetServiceHelper();
		$spreadsheet = $spreadSheetService->getSpreadsheetById("1NS6bo-jYjY5YUWbOofvuvqKqLL1BlDRz8WgL-8NTjcU");
		$allWorkSheet = $spreadSheetService->getAllWorkSheets();
		$workSheetName = "Sheet1";
		$listFeed = $spreadSheetService->getWorkSheetByName($workSheetName);
		$asset_data =$spreadSheetService->getAllRows($listFeed->getEntries());	
		if(count($asset_data)>0){
			foreach($asset_data as $company){
				if($company['type']!='company' && strpos($company['linkedinurl'],"linkedin")!==false){
					$this->load->model('opportunity_model');
					$companyData = $this->opportunity_model->checkCompanyWithLinkedinUrl($company['linkedinurl']);
					if(count($companyData)==0){
						$this->load->model('customer_model');
						$checkCompanyExist = $this->customer_model->checkCompanyExist($company['companyname']);
						if($checkCompanyExist==0){
							$insert = $this->customer_model->insertCompany(array('company_name'=>$company['companyname'],'linkedin_name'=>$company['linkedincompanyname'],'linkedin_url'=>$company['linkedinurl']));
							echo "Insert Company:".$insert."@@".$company['linkedinurl']."<br/>";
						} else if($checkCompanyExist==1){
							$getCompanyData = $this->customer_model->getCompanyData($company['companyname']);
							$update=$this->customer_model->updateCompanyData($getCompanyData->id,array('linkedin_name'=>$company['linkedincompanyname'],'linkedin_url'=>$company['linkedinurl']));
							echo "Update:".$update."@@".$company['linkedinurl']."<br/>";
						}						
					}
				}
			}
		}
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
			$url = "http://webdriverforscrape.site/index.php?patent=".$getPatentNumber;
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
			$url = "http://webdriverforscrape.site/pagesource.php?patent=".$getPatentNumber;
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
						case 21:
							$_icon = "<i class='glyph-icon icon-linkedin' title='Linkedin' style='color:#2196f3' ></i> ";
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
							$_ul .='<li style="padding:10px;list-style:none;"><div class="comment_content"><span>'.date('M d, Y',strtotime($detail->activity_date)).'</span><div>';
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
							$htmlUL['d']='<li style="padding:10px;list-style:none;"><div class="comment_content"><span>'.$_icon.' '.date('M d, Y',strtotime($detail->activity_date)).'</span><div>'.$detail->note.'</div></div></li>';
							$this->layout->render('user/show_layout_html',$htmlUL);
							$_ul .= $this->layout->data['contents_for_layout'];
						}				
					} else {
						$htmlUL['d'] = '<li style="padding:10px;list-style:none;"><div class="comment_content"><span>'.$_icon.' '. date('M d, Y',strtotime($detail->activity_date)).'</span><div><pre>'.$detail->note.'</pre></div></div></li>';
						$this->layout->render('user/show_layout_html',$htmlUL);
						$_ul .= $this->layout->data['contents_for_layout'];
					}
				}
			}
		}
		$data['ul'] = $_ul;
		//$this->layout->data['contents_for_layout'] = "";
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
	
	function callinout($t=0){
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