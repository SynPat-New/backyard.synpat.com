<?php 
use \Firebase\JWT\JWT;
use Slim\Http\Response;
date_default_timezone_set('America/Los_Angeles');
ini_set('date.timezone', 'America/Los_Angeles');
class DataController{
	static private $backEndUrl = "https://backyard.synpat.com/";
	
	static private $skey = "sYnP@TpRoJ3cT5#%"; // you can change it
	
	
	public function getTokenKey(){
		return DataController::$skey;
	}
	
	
	public function getBackendUrl(){
		return DataController::$backEndUrl;
	}
	
	private function insertData($tableName,$data,$t=0){
		$fieldNames = array();
		$questMark = array();
		$dataValues = array();
		$insertID = 0;
		if(count($data)>0){
			foreach($data as $key=>$value){
				array_push($fieldNames,$key);
				array_push($questMark,"?");
				array_push($dataValues,$value);
			}
		}
		try {
			$queryStmt = "INSERT INTO ".$tableName." ( ".implode(',',$fieldNames)." ) VALUES ( ".implode(',',$questMark)." ) ";
			$db = $this->db;
			if($t == 1) {
				$db = $this->db1;
			}
			$stmt= $db->prepare($queryStmt);
			$stmt->execute($dataValues);
			$insertID = $db->lastInsertId();
		}catch (Exception $e){
			/*Error in query*/
			$this->logger->addInfo($e->getMessage());
		}
		return $insertID;
	}
	
	private function updateData($tableName,$where,$data){
		$fieldNames = array();
		$fieldWhereNames = array();
		$dataValues = array();
		$updateID = 0;
		if(count($data)>0){
			foreach($data as $key=>$value){
				array_push($fieldNames,$key.="=?");
				array_push($dataValues,$value);
			}
		}
		if(count($where)>0){
			foreach($where as $key=>$value){
				array_push($fieldWhereNames,$key.="=?");
				array_push($dataValues,$value);
			}
		}
		if(count($fieldNames)>0 && count($fieldWhereNames)>0  && count($dataValues)>0){
			try {
				$queryStmt = "UPDATE ".$tableName." SET ".implode(',',$fieldNames)." WHERE   ".implode(' AND ',$fieldWhereNames)."  ";
				$stmt= $this->db->prepare($queryStmt);
				$stmt->execute($dataValues);
				$updateID = $stmt->rowCount();
			}catch (Exception $e){
				/*Error in query*/
				$this->logger->addInfo($e->getMessage());
			}
		}
		return $updateID;
	}
	
	public function auth($app,$req,$resp, $args = [])  {
		/*Get Post data*/
		$data = $req->getParsedBody();
		$apiKey = $data['key'];
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		try {
			$stmt = $this->db->prepare("SELECT id,secret_key FROM api_users WHERE secret_key=?");
			$stmt->execute([$apiKey]);
			$num_rows = $stmt->rowCount();
			if($num_rows==1){
				/*	Authenticated
					Generate Token
				*/
				$queryData = $stmt->fetch();
				$payload = array(
					"iss"     => "https://synpat.com/store",
					"iat"     => time(),
					"exp"     => time() + (14400 * 24 * 15),
					"context" => [
						"user" => [
							"user_login" => $queryData->secret_key,
							"user_id"    => $queryData->id,
							"crm_alias"    => 'docket-api',
							"type" => "OverAll"
						]
					]
				);	
				$key = $this->get('settings')['docket-key'];
				$jwt = JWT::encode($payload, $key);
				$insertID = DataController::insertData('docket_tokens',array('user_id'=>$queryData->id,'token'=>$jwt,'date_created'=>$payload['iat'],'date_expiration'=>$payload['exp']));
				if($insertID>0){
					$returnData['status'] = 200;
					$returnData['data'] = ["token" => $jwt];
					$returnData['message'] = "Authenticated!";
				} else {
					$returnData['status'] = 500;
					$returnData['error_code'] = "100";
					$returnData['message'] = "Internal server error";
				}				
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "200";
				$returnData['message'] = "Invalid key";
			}			
		} catch (PDOException $e) {
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
			$this->logger->addInfo($e->getMessage());
		}
		return $resp->withJson($returnData, $returnData['status']);
    }
	
	private function updateTabAccordionWithSkeleton($docketData){
		$stmt = $this->db->prepare("SELECT li.person_name,li.person_email,li.person_picture,li.person_phone,li.person_email,li.introduction,li.portfolio_tab,li.counter_tab ,li.price_tab,li.simulator_tab,li.document_tab,li.claim_tab,li.invention_tab,li.evidence_tab ,li.comparables_tab,li.litigation_tab,li.royalties_tab,li.fcitation_tab,li.seller_tab,li.pdf_tab,li.validity_tab,li.bcitation_tab,li.prior_tab,li.legal_tab,li.dmca,li.privacy_tab FROM licenses as li WHERE li.license_number=? LIMIT 1");
		$stmt->execute([12345]);
		$num_rows = $stmt->rowCount();
		if($num_rows > 0){
			$row = $stmt->fetch();
			if($docketData->privacy_tab == "" || $docketData->privacy_tab == null){
				$docketData->privacy_tab = $row->privacy_tab;
			}
			if($docketData->legal_tab == "" || $docketData->legal_tab == null){
				$docketData->legal_tab = $row->legal_tab;
			}
			if($docketData->dmca == "" || $docketData->dmca == null){
				$docketData->dmca = $row->dmca;
			}
			if($docketData->prior_tab == "" || $docketData->prior_tab == null){
				$docketData->prior_tab = $row->prior_tab;
			}
			if($docketData->bcitation_tab == "" || $docketData->bcitation_tab == null){
				$docketData->bcitation_tab = $row->bcitation_tab;
			}
			if($docketData->validity_tab == "" || $docketData->validity_tab == null){
				$docketData->validity_tab = $row->validity_tab;
			}
			if($docketData->pdf_tab == "" || $docketData->pdf_tab == null){
				$docketData->pdf_tab = $row->pdf_tab;
			}
			if($docketData->seller_tab == "" || $docketData->seller_tab == null){
				$docketData->seller_tab = $row->seller_tab;
			}
			if($docketData->fcitation_tab == "" || $docketData->fcitation_tab == null){
				$docketData->fcitation_tab = $row->fcitation_tab;
			}
			if($docketData->royalties_tab == "" || $docketData->royalties_tab == null){
				$docketData->royalties_tab = $row->royalties_tab;
			}
			if($docketData->comparables_tab == "" || $docketData->comparables_tab == null){
				$docketData->comparables_tab = $row->comparables_tab;
			}
			if($docketData->litigation_tab == "" || $docketData->litigation_tab == null){
				$docketData->litigation_tab = $row->litigation_tab;
			}
			if($docketData->evidence_tab == "" || $docketData->evidence_tab == null){
				$docketData->evidence_tab = $row->evidence_tab;
			}
			if($docketData->invention_tab == "" || $docketData->invention_tab == null){
				$docketData->invention_tab = $row->invention_tab;
			}
			if($docketData->claim_tab == "" || $docketData->claim_tab == null){
				$docketData->claim_tab = $row->claim_tab;
			}
			if($docketData->document_tab == "" || $docketData->document_tab == null){
				$docketData->document_tab = $row->document_tab;
			}
			if($docketData->simulator_tab == "" || $docketData->simulator_tab == null){
				$docketData->simulator_tab = $row->simulator_tab;
			}
			if($docketData->price_tab == "" || $docketData->price_tab == null){
				$docketData->price_tab = $row->price_tab;
			}			
			if($docketData->counter_tab == "" || $docketData->counter_tab == null){
				$docketData->counter_tab = $row->counter_tab;
			}
			if($docketData->portfolio_tab == "" || $docketData->portfolio_tab == null){
				$docketData->portfolio_tab = $row->portfolio_tab;
			}
			if($docketData->introduction == "" || $docketData->introduction == null){
				$docketData->introduction = $row->introduction;
			}
		}
		return $docketData;
	}
	
	public function docket_data($app,$req,$resp,$args = [])  {
		/**print_r($req->getHeaders());*/
		$returnData = array('status'=>500,'message'=>'','data'=>'');
        $headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			$docketNumber = DataController::decode($docketNumber);
			if($docketNumber>0){
				$stmt = $this->db->prepare("SELECT l.lead_name as docket_name,li.purchase_license,li.purchase_buy,li.strategic_license_agreement,li.program_policies_file,li.purchase_file,li.active_button,li.asking_price as acquisition_price,li.expiration_date as deadline,li.portfolio_accordion_complete,li.current_requesting_companies,li.person_name,li.person_email,li.person_picture,li.person_phone,li.file_left,li.file_middle,li.file_right,li.file_four,li.file_five,li.file_six,li.file_seven,li.file_eight,li.file_nine,li.file_ten,li.file_eleven,li.file_twelve,li.file_thirteen,li.file_fourteen,li.file_fiveteen,li.file_sixteen,li.file_seventeen,li.file_eighteen,li.file_nineteen,li.file_twenty,li.file_twentyone,li.file_twentytwo,li.file_twentythree,li.file_twentyfour,li.file_twentyfive,li.file_twentysix,li.file_twentyseven,li.file_twentyeight,li.file_twentynine,li.file_thirty,li.file_thirtyone,li.file_thirtytwo,li.introduction,li.portfolio_tab,li.counter_tab ,li.price_tab,li.simulator_tab,li.document_tab,li.claim_tab,li.invention_tab,li.evidence_tab ,li.comparables_tab,li.litigation_tab,li.royalties_tab,li.fcitation_tab,li.seller_tab,li.pdf_tab,li.validity_tab,li.bcitation_tab,li.prior_tab,li.legal_tab,li.dmca,li.privacy_tab,li.serial_number as docket_number, li.id as docketID,l.id as leadID,l.invalidation_tab,l.eou_tab,a.cost_price,a.regular_license_starts,a.late_license_starts,a.option_expiration_data,a.order_name,l.scheduler_link as appointment_link FROM licenses as li INNER JOIN litigations as l ON l.serial_number = li.serial_number INNER JOIN acquisition as a ON a.lead_id = l.id  WHERE li.license_number=? LIMIT 1");
				$stmt->execute([$docketNumber]);
				$num_rows = $stmt->rowCount();
				if($num_rows==1){
					$docketData = $stmt->fetch();
					$docketData = DataController::updateTabAccordionWithSkeleton($docketData);
					$docketData->families = DataController::getPatentCount($docketData->leadID);
					$docketData->current_requesting_companies = DataController::getCountRequestingCompanies($docketNumber);
					$images = array();
					if($docketData->file_left!=""){
						array_push($images,$docketData->file_left);
					}
					unset($docketData->file_left);
					if($docketData->file_middle!=""){
						array_push($images,$docketData->file_middle);
					}
					unset($docketData->file_middle);
					if($docketData->file_right!=""){
						array_push($images,$docketData->file_right);
					}
					unset($docketData->file_right);
					if($docketData->file_four!=""){
						array_push($images,$docketData->file_four);
					}
					unset($docketData->file_four);
					if($docketData->file_five!=""){
						array_push($images,$docketData->file_five);
					}
					unset($docketData->file_five);
					if($docketData->file_six!=""){
						array_push($images,$docketData->file_six);
					}
					unset($docketData->file_six);
					if($docketData->file_seven!=""){
						array_push($images,$docketData->file_seven);
					}
					unset($docketData->file_seven);
					if($docketData->file_eight!=""){
						array_push($images,$docketData->file_eight);
					}
					unset($docketData->file_eight);
					if($docketData->file_nine!=""){
						array_push($images,$docketData->file_nine);
					}
					unset($docketData->file_nine);
					if($docketData->file_ten!=""){
						array_push($images,$docketData->file_ten);
					}
					unset($docketData->file_ten);
					if($docketData->file_eleven!=""){
						array_push($images,$docketData->file_eleven);
					}
					unset($docketData->file_eleven);
					if($docketData->file_twelve!=""){
						array_push($images,$docketData->file_twelve);
					}
					unset($docketData->file_twelve);
					if($docketData->file_thirteen!=""){
						array_push($images,$docketData->file_thirteen);
					}
					unset($docketData->file_thirteen);
					if($docketData->file_fourteen!=""){
						array_push($images,$docketData->file_fourteen);
					}
					unset($docketData->file_fourteen);
					if($docketData->file_fiveteen!=""){
						array_push($images,$docketData->file_fiveteen);
					}
					unset($docketData->file_fiveteen);
					if($docketData->file_sixteen!=""){
						array_push($images,$docketData->file_sixteen);
					}
					unset($docketData->file_sixteen);
					if($docketData->file_seventeen!=""){
						array_push($images,$docketData->file_seventeen);
					}
					unset($docketData->file_seventeen);
					if($docketData->file_eighteen!=""){
						array_push($images,$docketData->file_eighteen);
					}
					unset($docketData->file_eighteen);
					if($docketData->file_nineteen!=""){
						array_push($images,$docketData->file_nineteen);
					}
					unset($docketData->file_nineteen);
					if($docketData->file_twenty!=""){
						array_push($images,$docketData->file_twenty);
					}
					unset($docketData->file_twenty);
					if($docketData->file_twentyone!=""){
						array_push($images,$docketData->file_twentyone);
					}
					unset($docketData->file_twentyone);
					if($docketData->file_twentytwo!=""){
						array_push($images,$docketData->file_twentytwo);
					}
					unset($docketData->file_twentytwo);
					if($docketData->file_twentythree!=""){
						array_push($images,$docketData->file_twentythree);
					}
					unset($docketData->file_twentythree);
					if($docketData->file_twentyfour!=""){
						array_push($images,$docketData->file_twentyfour);
					}
					unset($docketData->file_twentyfour);
					if($docketData->file_twentyfive!=""){
						array_push($images,$docketData->file_twentyfive);
					}
					unset($docketData->file_twentyfive);
					if($docketData->file_twentysix!=""){
						array_push($images,$docketData->file_twentysix);
					}
					unset($docketData->file_twentysix);
					if($docketData->file_twentyseven!=""){
						array_push($images,$docketData->file_twentyseven);
					}
					unset($docketData->file_twentyseven);
					if($docketData->file_twentyeight!=""){
						array_push($images,$docketData->file_twentyeight);
					}
					unset($docketData->file_twentyeight);
					if($docketData->file_twentynine!=""){
						array_push($images,$docketData->file_twentynine);
					}
					unset($docketData->file_twentynine);
					if($docketData->file_thirty!=""){
						array_push($images,$docketData->file_thirty);
					}
					unset($docketData->file_thirty);
					if($docketData->file_thirtyone!=""){
						array_push($images,$docketData->file_thirtyone);
					}
					unset($docketData->file_thirtyone);
					if($docketData->file_thirtytwo!=""){
						array_push($images,$docketData->file_thirtytwo);
					}
					unset($docketData->file_thirtytwo);
					if(count($images) > 0){
						$docketData->images = DataController::getAllImagesWithNameAndType($images);
					} else {
						$docketData->images = array();
					}
					$activeButton = DataController::updateActiveButton($docketData->leadID,$docketData->docket_number,$docketData->cost_price,$docketData->active_button,$docketData->option_expiration_data,$docketData->regular_license_starts,$docketData->late_license_starts);
					$docketData->skeleton_data = DataController::getSkeletonTabData();
					if($activeButton>0){
						$docketData->active_button = $activeButton;
					}	
					$participate_button = false;
					$license_button = false;
					$available_soon = false;
					$completed = false;
					if($docketData->active_button<2){
						$participate_button = true;
						$available_soon = true;
					}else if($docketData->active_button>1){
						$license_button = true;
						$completed = true;
					}
					$lateLicenseDate = "4 months later";
					$regularLicenseDate = "Closing";
					if($docketData->active_button > 1) {
						$todayDate = strtotime(date('Y-m-d',strtotime('now')));
						$expirationDate = strtotime($docketData->option_expiration_data);
						$regularLicense = strtotime($docketData->regular_license_starts);
						$lateLicense = strtotime($docketData->late_license_starts);
						$lateLicenseDate = date('M d, y',strtotime('+4 months',$regularLicense));
						$lateLicenseDate = date('M d, y',strtotime('+1 days',strtotime($lateLicenseDate)));
						$regularLicenseDate = date('M d, y',$regularLicense);
					}
					
					$docketData->min_price = 0;
					$minPrice = 0;
					if($docketData->current_requesting_companies>0){
						$docketData->min_price = $docketData->acquisition_price/$docketData->current_requesting_companies;						
						$minPrice = $docketData->min_price;
						$requestPriceInMillion = $docketData->min_price * 1000000;
						$docketData->min_price = '$'.number_format($requestPriceInMillion,0,',',',');
					} else {
						$docketData->min_price = $docketData->acquisition_price/3;	
						$minPrice = $docketData->min_price;
						$requestPriceInMillion = $docketData->min_price * 1000000;
						$docketData->min_price = '<span class="demo-request">$'.number_format($requestPriceInMillion,0,',',',').'</span>';
					}
					
					$costPrice = $docketData->cost_price;
					$showRegularPrice = 0;
					$showLatePrice = 0;
					if($docketData->current_requesting_companies > 0) {
						$costPrice = $docketData->acquisition_price/$docketData->current_requesting_companies;
					} else {
						$costPrice = $minPrice;
					}
					if((int)$docketData->active_button == 2 || (int)$docketData->active_button == 3) {	
						$showPrice = 1.5 * $costPrice; 
						$showRegularPrice = $showPrice;
						$showRegularPrice = $showRegularPrice * 1000000;
						$showRegularPrice = '$'.number_format($showRegularPrice,0,',',',');
						$showPrice = 3 * $costPrice;
						$showLatePrice = $showPrice;
						$showLatePrice = $showLatePrice * 1000000;
						$showLatePrice = '$'.number_format($showLatePrice,0,',',',');
					} else {
						if($docketData->current_requesting_companies > 0) {
							$showRegularPrice = 1.5 * $costPrice; 
							$showRegularPrice = $showRegularPrice * 1000000;
							$showRegularPrice = '$'.number_format($showRegularPrice,0,',',',');
							$showLatePrice = 3 * $costPrice; 
							$showLatePrice = $showLatePrice * 1000000;
							$showLatePrice = '$'.number_format($showLatePrice,0,',',',');
						}
					}
					
					$demoStartAmount = $docketData->acquisition_price/3;
					$demoMiddleAmount = $demoStartAmount/2;
					$demoEndAmount = $demoStartAmount * 2;
					$demoStartDate = date("Y-m-d H:i:s",strtotime("-60 days",strtotime($docketData->option_expiration_data)));
					$demoMiddleDate = date("Y-m-d H:i:s",strtotime("-40 days",strtotime($docketData->option_expiration_data)));
					$demoEndDate = date("Y-m-d H:i:s",strtotime("-20 days",strtotime($docketData->option_expiration_data)));
					$docketData->demostartamount = number_format($demoStartAmount,2,'.','');
					$docketData->demostartdate = $demoStartDate;
					
					$docketData->demomiddleamount = number_format($demoMiddleAmount,2,'.','');
					$docketData->demomiddledate = $demoMiddleDate;
					
					$docketData->demoendamount = number_format($demoEndAmount,2,'.','');
					$docketData->demoenddate = $demoEndDate;
					
					$docketData->regular_price = $showRegularPrice;
					$docketData->validate_price = $showLatePrice;
					$docketData->end_date = $lateLicenseDate;
					$docketData->regular_date = $regularLicenseDate;
					$docketData->available_soon = $available_soon;
					$docketData->completed = $completed;
					$docketData->participate_button = $participate_button;
					$docketData->license_button = $license_button;
					$docketData->heading_jurisdiction = "JURISDICTIONS";
					$docketData->heading_technologies = "COVERED TECHNOLOGIES";
					$docketData->heading_assets = "ASSETS ALIVE / YEAR";
					$commitmentData = array();
					$jurisdictionData = array();
					$technologiesData = array();
					$assetsData = array();
					/*Commitment Chart Data*/
					$commitmentStmt = $this->db->prepare("SELECT amount,commitment_date,ar FROM commitments WHERE license_id=?");
					$commitmentStmt->execute([$docketData->docketID]);
					if($commitmentStmt->rowCount()>0){
						while($row = $commitmentStmt->fetch()){
							array_push($commitmentData ,$row);
						}
					}
						
					$assets_count = 0;
					$countCountry = [];
					/*Jurisdiction Chart Data*/
					$jurisdictionStmt = $this->db->prepare("SELECT country,applications,patents FROM chart_lefts WHERE license_id=?");
					$jurisdictionStmt->execute([$docketData->docketID]);
					if($jurisdictionStmt->rowCount()>0) {
						while($row = $jurisdictionStmt->fetch()) {
							if(strtolower(strtoupper($row->country)) != "wo" && strtolower(strtoupper($row->country)) != "ep"){
								array_push($jurisdictionData,$row);
								$assets_count = $assets_count + (int)$row->applications + (int)$row->patents;
								if(!in_array($row->country,$countCountry)){
									array_push($countCountry, $row->country);
								}
							}							
						}
					}
					
					$docketData->assets_count = $assets_count;
					$docketData->juridiction_count = count($countCountry);
					/*Technologies Chart Data*/
					$technologiesStmt = $this->db->prepare("SELECT technologies,data,tooltip FROM chart_middles WHERE license_id=? ORDER BY technologies ASC");
					$technologiesStmt->execute([$docketData->docketID]);
					if($technologiesStmt->rowCount()>0){
						while($row = $technologiesStmt->fetch()){
							array_push($technologiesData,$row);
						}
					}
					/*Assets/Live Chart Data*/
					$assetsStmt = $this->db->prepare("SELECT year,data FROM chart_rights WHERE license_id=? ORDER BY data ASC");
					$assetsStmt->execute([$docketData->docketID]);
					if($assetsStmt->rowCount()>0){
						while($row = $assetsStmt->fetch()){
							array_push($assetsData,$row);
						}
					}
					unset($docketData->docketID);
					unset($docketData->leadID);
					$docketData->commitments = $commitmentData;
					$docketData->jurisdiction = $jurisdictionData;
					$docketData->technologies = $technologiesData;
					$docketData->assets = $assetsData;
					$docketData->purchase_file = DataController::changeFileToViewOnly($docketData->purchase_file);
					$docketData->purchase_license = DataController::changeFileToViewOnly($docketData->purchase_license);
					$docketData->strategic_license_agreement = DataController::changeFileToViewOnly($docketData->strategic_license_agreement);
					$docketData->purchase_buy = DataController::changeFileToViewOnly($docketData->purchase_buy);
					$docketData->program_policies_file = DataController::changeFileToViewOnly($docketData->program_policies_file);
					
					
					
					
					$docketData->option_expiration_data = date('M j, Y', strtotime($docketData->option_expiration_data));
					$showPriceInMillion = $docketData->acquisition_price * 1000000;
					$docketData->show_price = '$'.number_format($showPriceInMillion, 0, ',', ',');
					$sliderImages = array(
							array('image_url'=>"https://storage.googleapis.com/static.synpat.com/front/slider/img/chart_01.png","description"=>"SynPat acquires for its license store high-quality high-impact patents. The acquisition begins with the execution of an obligatory Term Sheet that secures SynPat's 100 days option to acquire the listed patents at an agreed upon price, in addition to 1/3 of SynPat future revenue generated from the acquired patents.","alt"=>"","id"=>1),
							array('image_url'=>"https://storage.googleapis.com/static.synpat.com/front/slider/img/chart_02.png","description"=>"To fund the purchase price, we invite our customers - all relevant operating companies to jointly and equally fund the purchase price. This way we validate customers demand, avoid acquiring undesired patents, and ensure reasonable license prices.","alt"=>"","id"=>2),
							array('image_url'=>"https://storage.googleapis.com/static.synpat.com/front/slider/img/chart_03.png","description"=>"Companies interested in acquiring defensive Non-Exclusive Licenses and/or Strategic Licenses to strengthen their competitive advantages vis-a-vis their direct competitors, or interested in investing in the venture - fill in the Request to Participate form, and state the MAXIMUM amount they would contribute to the ad-hoc funding syndicate.","alt"=>"","id"=>3),
							array('image_url'=>"https://storage.googleapis.com/static.synpat.com/front/slider/img/chart_04.png","description"=>"The price of each License is simply calculated as the patents purchase price divided by the number of licenses requested by participating companies. As soon as sufficient commitments arrive, we close the syndicate for additional participation. Each participant will pay a pro-rata share proportional to the number of Licenses it requested.","alt"=>"","id"=>4),
							array('image_url'=>"https://storage.googleapis.com/static.synpat.com/front/slider/img/chart_05.png","description"=>"The Closing is made of three stages: Signing a Patent Purchase Agreement (&#34;PPA&#34;), Payment of Purchase Price and Transfer of Title. To secure the payment of the purchase price, the PPA entitles SynPat to grant licenses to the participating companies.","alt"=>"","id"=>5),
							array('image_url'=>"https://storage.googleapis.com/static.synpat.com/front/slider/img/chart_06.png","description"=>"SynPat grants licenses to the participating companies by executing Non-Exclusive License Agreements and Strategic License Agreements and sending them to the participants. In turn, participants asked to pay their share in the purchase price within 7 business days.","alt"=>"","id"=>6),
							array('image_url'=>"https://storage.googleapis.com/static.synpat.com/front/slider/img/chart_07.png","description"=>"With valid executed Licenses in hand, participating companies can now pay for their Licenses. To simplify the process, and to reduce the seller’s risk, the amounts are wired directly to the seller's bank account.","alt"=>"","id"=>7),
							array('image_url'=>"https://storage.googleapis.com/static.synpat.com/front/slider/img/chart_08.png","description"=>"To complete the licensing cycle, participants counter execute their Licenses Agreements and send them to SynPat for its records and maintain the integrity of inventory, so no conflicting rights assigned to another. Since the payment is made to the seller's bank account, we also need participants to send us a proof that such a payment was made.","alt"=>"","id"=>8),
							array('image_url'=>"https://storage.googleapis.com/static.synpat.com/front/slider/img/chart_09.png","description"=>"The seller keeps the title for the patents until the purchase price is paid in full. Only after the seller receives from all participants their participation fees, which add up to the purchase price, does the title on the patents transfer to SynPat.","alt"=>"","id"=>9)
					);
					$docketData->slider_images = $sliderImages;
					$returnData['status'] = 200;
					$returnData['data'] = $docketData;
				} else {
					$returnData['status'] = 404;
					$returnData['data'] = array();
					$returnData['error_code'] = 300;
					$returnData['message'] = "Invalid docket number";
				}
			} else {
				$returnData['status'] = 500;
				$returnData['data'] = array();
				$returnData['error_code'] = 600;
				$returnData['message'] = "Invalid docket number";
			}
		}catch(Exception $e){
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
			$this->logger->addInfo($e->getMessage());
		}
		return $resp->withJson($returnData, $returnData['status']);
    }
	
	private function getAllImagesWithNameAndType($images){
		$portfolioImages = array();
		if(count($images) > 0) {
			/*for($i = 0; $i< count($images); $i++){
				$images[$i] = "'".$images[$i]."'";
			}*/
			$allLinksImplode = str_repeat ('?, ',  count ($images) - 1) . '?';
			$queryLead = "SELECT link,name FROM store_images WHERE link IN($allLinksImplode) ";
			
			$queryFindImagesName = $this->db->prepare($queryLead);
			$queryFindImagesName->execute($images);
			if($queryFindImagesName->rowCount()>0){
				$allData = array();
				while($img = $queryFindImagesName->fetch()){
					$imgSrc = true;
					if(strpos(strtolower($img->link),".webm") !== false){
						$imgSrc = false;
					}
					array_push($allData,array('name'=>$img->name,'link'=>$img->link,'img'=>$imgSrc));
				}
				foreach($images as $img){
					foreach($allData as $fImg){
						if($img == $fImg['link']){
							array_push($portfolioImages,$fImg);
							break;
						}
					}
				}
			}
		}
		return $portfolioImages;
	}
	
	
	/*
		Scope
		return Patent simple family data
	*/
	public function docket_scope($app,$req,$resp,$args = [])  {
		/*
			Checking request with All or Patent number
		*/
		$returnData = array('status'=>500,'message'=>'','data'=>'');
        $headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];		
		$docketNumber = $req->getAttribute('docket_number');
		$patentNumber = $req->getAttribute('values');
		$family_data = array('number'=>'','list'=>array(),'country'=>array());
		$calledNumber = $patentNumber;
		if($patentNumber=="all"){
			/*Get family list for all patents*/
			$queryLead = "SELECT id FROM litigations WHERE serial_number=?";
			$leadStmt = $this->db->prepare($queryLead);
			$leadStmt->execute([$docketNumber]);
			if($leadStmt->rowCount()>0){
				$rowData = $leadStmt->fetch();
				$queryPatents = "SELECT distinct(lp.patent_number) as patent_number FROM lead_patent as lp WHERE lp.lead_id=?";
				$patentsStmt = $this->db->prepare($queryPatents);
				$patentsStmt->execute([$rowData->id]);
				//$patentsStmt->debugDumpParams();
				if($patentsStmt->rowCount()>0){
					$family = array();
					while($rowPatent = $patentsStmt->fetch()){
						$patentNumber = $rowPatent->patent_number;
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
						$queryIllustration = "SELECT id,family_id FROM lead_patent_family_member as fm WHERE fm.publication_number LIKE ? order by id DESC LIMIT 1";
						$illustrationStmt = $this->db->prepare($queryIllustration);
						$illustrationStmt->execute(['%'.$newNumber.'%']);
						if($illustrationStmt->rowCount()>0){
							$rowFamily = $illustrationStmt->fetch();
							$family[] = $rowFamily->family_id;
						}
					}
					if(count($family)>0){
						$familyImplode = str_repeat ('?, ',  count ($family) - 1) . '?';
						$querySimpleFamily = "SELECT fpr.*,pfm.publication_country,pfm.publication_number,publication_kind,pfm.application_number,pfm.application_date,pfm.claims,pfm.abstracts,pfm.images,pfm.publication_date,pfm.application_country,pfm.application_kind,pfm.title,pfm.priority_date,pfm.applicants,pfm.assignee,pfm.inventors,pfm.assigments FROM lead_patent_family_relation  as fpr LEFT JOIN lead_patent_family_member as pfm ON pfm.publication_number = fpr.patent_id WHERE fpr.family_id IN ($familyImplode) ORDER BY fpr.filling_date ASC, fpr.id ASC";
						$simpleFamilyStmt = $this->db->prepare($querySimpleFamily);
						$simpleFamilyStmt->execute($family);
						if($simpleFamilyStmt->rowCount()>0){
							while($rowF = $simpleFamilyStmt->fetch()){
								/**/
								array_push($family_data['list'],$rowF);
							}
						}
						for($i=0;$i<count($family_data['list']);$i++){
							$relation = array();
							$patentNumber = $family_data['list'][$i]->patent_id;
							$status = "";
							$assignee = "";
							if(strtolower(strtoupper($family_data['list'][$i]->publication_country))=='us'){
								$applicationNumber = $family_data['list'][$i]->application_number;
								$queryRelation = "SELECT distinct(relation_number) as relation_number,id, patent_app_number,relation_type,filed_date FROM lead_patent_family_child WHERE child = ? AND patent_app_number=?";
								$relationStmt = $this->db->prepare($queryRelation);
								$relationStmt->execute([1,$applicationNumber]);
								if($relationStmt->rowCount()>0){
									while($row = $relationStmt->fetch()){
										array_push($relation,$row);
									}
								}
								$queryStatus = "SELECT status FROM patent_illustration_detail WHERE patent_number=? LIMIT 1";
								$statusStmt = $this->db->prepare($queryStatus);
								$statusStmt->execute([$patentNumber]);
								if($statusStmt->rowCount()>0){
									$statusRow = $statusStmt->fetch();
									$status= $statusRow->status;
								}
								$patentNumber = $family_data['list'][$i]->publication_country.$family_data['list'][$i]->publication_number.$family_data['list'][$i]->publication_kind;
								$queryAssignee = "SELECT current_assignee,original_assignee FROM lead_patent_scrap_data WHERE patent_number=? limit 1";
								$assigneeStmt = $this->db->prepare($queryAssignee);
								$assigneeStmt->execute([$patentNumber]);
								if($assigneeStmt->rowCount()>0){
									$row = $assigneeStmt->fetch();
									if($row->current_assignee != ""){
										$assignee = $row->current_assignee;
									}else if($row->original_assignee != ""){
										$assignee = $row->original_assignee;
									}
								}
							}
							if($assignee != "") {
								$family_data['list'][$i]->assignee = $assignee;
							}
							$family_data['list'][$i]->status = $status;
							$family_data['list'][$i]->relation = $relation;
						}
					}
				}
			}			
		} else if($patentNumber!="") {
			/*Get family list from particular patent*/
			$family_data['number'] = $patentNumber;
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
			$queryIllustration = "SELECT id,family_id FROM lead_patent_family_member as fm WHERE fm.publication_number LIKE ? LIMIT 1";
			$illustrationStmt = $this->db->prepare($queryIllustration);
			$illustrationStmt->execute(['%'.$newNumber.'%']);
			$family_data['list'] = array();
			if($illustrationStmt->rowCount()>0){
				$rowData = $illustrationStmt->fetch();
				$querySimpleFamily = "SELECT fpr.*,pfm.publication_country,publication_kind,pfm.application_number,pfm.application_date,pfm.claims,pfm.abstracts,pfm.images,pfm.publication_date,pfm.application_country,pfm.application_kind,pfm.title,pfm.priority_date,pfm.applicants,pfm.assignee,pfm.inventors,pfm.assigments FROM lead_patent_family_relation  as fpr LEFT JOIN lead_patent_family_member as pfm ON pfm.publication_number = fpr.patent_id WHERE fpr.family_id = ? ORDER BY fpr.filling_date ASC, fpr.id ASC";
				$simpleFamilyStmt = $this->db->prepare($querySimpleFamily);
				$simpleFamilyStmt->execute([$rowData->family_id]);
				if($simpleFamilyStmt->rowCount()>0){
					while($row = $simpleFamilyStmt->fetch()){
						array_push($family_data['list'],$row);
					}
					for($i=0;$i<count($family_data['list']);$i++){
						$relation = array();
						$patentNumber = $family_data['list'][$i]->patent_id;
						$status = "";
						if(strtolower(strtoupper($family_data['list'][$i]->publication_country))=='us'){
							$applicationNumber = $family_data['list'][$i]->application_number;
							$queryRelation = "SELECT distinct(relation_number) as relation_number,id, patent_app_number,relation_type,filed_date FROM lead_patent_family_child WHERE child = ?  AND patent_app_number=?";
							$relationStmt = $this->db->prepare($queryRelation);
							$relationStmt->execute([1,$applicationNumber]);
							if($relationStmt->rowCount()>0){
								while($row = $relationStmt->fetch()){
									array_push($relation,$row);
								}
							}
							$queryStatus = "SELECT status FROM patent_illustration_detail WHERE patent_number=? LIMIT 1";
							$statusStmt = $this->db->prepare($queryStatus);
							$statusStmt->execute([$patentNumber]);
							if($statusStmt->rowCount()>0){
								$statusRow = $statusStmt->fetch();
								$status= $statusRow->status;
							}
						}
						$family_data['list'][$i]->status = $status;
						$family_data['list'][$i]->relation = $relation;
					}
				}
			}
		}
		$returnData = DataController::create_patent_family_illustration_data($family_data,$calledNumber);
		return $resp->withJson($returnData, $returnData['status']);
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
					$claims = DataController::cleanString($claims);
				} else {
					$claims = DataController::cleanStringWithoutStripTag($claims);
				}
				$abstract = DataController::cleanString($abstract);
				$title = DataController::cleanString($title);
				$inventors = DataController::cleanString($inventors);
				$assignee = DataController::cleanString($assignee);
				$applicants = DataController::cleanString($applicants);
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
			DataController::sort_array_of_array($verticals, 'yentry');
			DataController::sort_array_of_array($verticals, 'yexit');
			if(count($verticals)>15){
				$gapValue = 150/count($verticals);
			} else {
				$gapValue = 9;
			}
			$start = 100;
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
	
	public function patent_family_illustration($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
        $headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		$patentNumber = $req->getAttribute('values');
		$family_data = array('number'=>'','list'=>array(),'country'=>array());
		$calledNumber = $patentNumber;
		/*Get family list from particular patent*/
		$family_data['number'] = $patentNumber;
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
		$queryIllustration = "SELECT id,family_id FROM lead_patent_family_member as fm WHERE fm.publication_number LIKE ? LIMIT 1";
		$illustrationStmt = $this->db->prepare($queryIllustration);
		$illustrationStmt->execute(['%'.$newNumber.'%']);
		$family_data['list'] = array();
		if($illustrationStmt->rowCount()>0){
			$rowData = $illustrationStmt->fetch();
			$querySimpleFamily = "SELECT fpr.*,pfm.publication_country,publication_kind,pfm.application_number,pfm.application_date,pfm.claims,pfm.abstracts,pfm.images,pfm.publication_date,pfm.application_country,pfm.application_kind,pfm.title,pfm.priority_date,pfm.applicants,pfm.assignee,pfm.inventors,pfm.assigments FROM lead_patent_family_relation  as fpr LEFT JOIN lead_patent_family_member as pfm ON pfm.publication_number = fpr.patent_id WHERE fpr.family_id = ? ORDER BY fpr.filling_date ASC, fpr.id ASC";
			$simpleFamilyStmt = $this->db->prepare($querySimpleFamily);
			$simpleFamilyStmt->execute([$rowData->family_id]);
			if($simpleFamilyStmt->rowCount()>0){
				while($row = $simpleFamilyStmt->fetch()){
					array_push($family_data['list'],$row);
				}
				for($i=0;$i<count($family_data['list']);$i++){
					$relation = array();
					$patentNumber = $family_data['list'][$i]->patent_id;
					$status = "";
					if(strtolower(strtoupper($family_data['list'][$i]->publication_country))=='us'){
						$applicationNumber = $family_data['list'][$i]->application_number;
						$queryRelation = "SELECT distinct(relation_number) as relation_number,id, patent_app_number,relation_type,filed_date FROM lead_patent_family_child WHERE child = ?  AND patent_app_number=?";
						$relationStmt = $this->db->prepare($queryRelation);
						$relationStmt->execute([1,$applicationNumber]);
						if($relationStmt->rowCount()>0){
							while($row = $relationStmt->fetch()){
								array_push($relation,$row);
							}
						}
						$queryStatus = "SELECT status FROM patent_illustration_detail WHERE patent_number=? LIMIT 1";
						$statusStmt = $this->db->prepare($queryStatus);
						$statusStmt->execute([$patentNumber]);
						if($statusStmt->rowCount()>0){
							$statusRow = $statusStmt->fetch();
							$status= $statusRow->status;
						}
					}
					$family_data['list'][$i]->status = $status;
					$family_data['list'][$i]->relation = $relation;
				}
			}
		}
		$returnData = DataController::create_patent_family_illustration_data($family_data,$calledNumber);
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	public function formatApplicant($value){
		$value = strtolower(trim($value));
		$value = preg_replace('/[.,]/', '', $value);
		$value = preg_replace('/[-]/', ' ', $value);
		return $value;
	}
	public function formatApplicantA($value){
		$value = strtolower(trim($value));
		$value = preg_replace('/[.]/', '', $value);
		$value = preg_replace('/[,]/', ' ', $value);
		$value = preg_replace('/[-]/', ' ', $value);
		return $value;
	}
	
	/*
	* Litigation 
	* return valid json data
	*/
	public function litigation_data($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>'');
        $headers = $req->getHeaders();
		/*$auth = $headers['HTTP_AUTHORIZATION'];*/
		$docketNumber = $req->getAttribute('docket_number');
		$litigation_data = array('all_boxes'=>array(),'assignments'=>array(),'popup'=>array(),'box'=>array(),'connection'=>array(),'names'=>array(),'legend'=>array());
		$queryLitigation = "SELECT id,parties as name,party1,party2,filled_date as execution_date ,pdf_file_url as document ,'Ownership' as type,article_content,company_id1,company_id2 FROM lead_litigation WHERE `show` = 0 AND serial_number = ? AND party1 <> '' AND party2 <> '' ";
		$litigationStmt = $this->db->prepare($queryLitigation);
		$litigationStmt->execute([$docketNumber]);
		$litigation_data['box'] = array();
		if($litigationStmt->rowCount()>0){
			while($row = $litigationStmt->fetch()){		
				$row->recorded_date = null;
				$party1 = trim($row->party1);
				$party2 = trim($row->party2);
				if(substr($party1,-1) == "."){
					$party1 = substr($party1,0,-1);
				}
				if(substr($party2,-1) == "."){
					$party2 = substr($party2,0,-1);
				}
				if(strpos($party1,"(") !== false){
					$party1 = substr($party1,0,stripos($party1,"("));
				}
				if(strpos($party2,"(") !== false){
					$party2 = substr($party2,0,stripos($party2,"("));
				}
				$row->party1 = DataController::formatApplicant(trim($party1));
				$row->party2 = DataController::formatApplicant(trim($party2));
				$row->logo1 = "";
				$row->logo2 = "";
				$time = strtotime($row->execution_date);
				$a = false;
				if($row->execution_date != 'Unknown Date'){
					$time = strtotime($row->execution_date);
					$a = true;
				} else if (count($litigation_data['box']) > 0 && $row->execution_date == 'Unknown Date'){
					$time = strtotime($litigation_data['box'][count($litigation_data['box'])-1]->execution_date);
					$a = true;
				}
				if($a === true){
					$row->date_1 = $time;
					$row->execution_date = date('Y-m-d 00:00:00',$time);
					array_push($litigation_data['box'],$row);
				}				
			}
			for($i=0;$i<count($litigation_data['box']);$i++){
				if($litigation_data['box'][$i]->company_id1 > 0){
					$party1C = DataController::findCompanyLogoByID($litigation_data['box'][$i]->company_id1,$litigation_data['box'][$i]->party1,array(),1);
					unset($litigation_data['box'][$i]->company_id1);
				} else {
					$party1C = DataController::findCompanyLogo($litigation_data['box'][$i]->party1,array(),1);
				}				
				if(isset($party1C['img']) && $party1C['img']!=""){
					$litigation_data['box'][$i]->logo1 = $party1C['img'];
				}
				if($litigation_data['box'][$i]->company_id2 > 0){
					$party2C = DataController::findCompanyLogoByID($litigation_data['box'][$i]->company_id2,$litigation_data['box'][$i]->party2,array(),1);
				} else {
					$party2C = DataController::findCompanyLogo($litigation_data['box'][$i]->party2,array(),1);
				}				
				if(isset($party2C['img']) && $party2C['img']!=""){
					$litigation_data['box'][$i]->logo2 = $party2C['img'];
				}
			}
			/*for($i=0;$i<count($litigation_data['box']);$i++){
				if($litigation_data['box'][$i]->execution_date == 'Unknown Date'){
					$time = strtotime($litigation_data['box'][$i-1]->execution_date);
					$litigation_data['box'][$i]->date_1 = $time;
					$litigation_data['box'][$i]->execution_date = date('Y-m-d 00:00:00',$time);
				} else {
					$time = strtotime($litigation_data['box'][$i]->execution_date);
					$litigation_data['box'][$i]->date_1 = $time;
					$litigation_data['box'][$i]->execution_date = date('Y-m-d 00:00:00',$time);
				}			
			}*/
			$filledDate = array_map(function($element){return $element->date_1;}, $litigation_data['box']);
			array_multisort($filledDate, SORT_ASC, $litigation_data['box']);
		}
		$returnData['data']= $litigation_data;
		return $resp->withJson($returnData, $returnData['status']);
	}

	/*
		Claim Illustration
		return Google Drive file link
	*/
	public function docket_claim($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			if($docketNumber>0){
				$getLeadID = DataController::getLeadID($docketNumber);
				if($getLeadID>0){
					$getPatentList = DataController::getPatentList($getLeadID);
					if(count($getPatentList)>0){
						$patents = array();
						foreach($getPatentList as $p){
							array_push($patents, $p->patent_number);
						}
						$illustrationData = array();
						$patentImplode = str_repeat ('?, ',  count ($patents) - 1) . '?';
						$queryIllustration = "SELECT distinct(patent_id), file FROM due_dilligence_illustrations WHERE patent_id IN ($patentImplode) order by id desc";
						$illustrationStmt = $this->db->prepare($queryIllustration);
						$illustrationStmt->execute($patents);
						if($illustrationStmt->rowCount()>0){
							while($rowData = $illustrationStmt->fetch()){
								$fileUrl = DataController::fileReplaceToView($rowData->file);
								array_push($illustrationData, array('file'=>$fileUrl,'patent_number'=>$rowData->patent_id));
							}
							for($i=0;$i<count($illustrationData);$i++) {
								foreach($getPatentList as $patent){
									if($illustrationData[$i]['patent_number'] == $patent->patent_number){
										$illustrationData[$i]['id'] = $patent->id;
										break;
									}
								}
							}
							$returnData = array('status'=>200,'message'=>'','data'=>$illustrationData);
						} else {
							$returnData = array('status'=>200,'message'=>'No record found');
						}
					} else {
						$returnData = array('status'=>200,'message'=>'No record found');
					}
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Invalid docket','error_code'=>300);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>200,'message'=>'Internal server error','error_code'=>100);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/*
		Docket Invention
	*/
	
	public function docket_invention($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			if($docketNumber>0){
				$patentNumber = $req->getAttribute('value');
				if(!empty($patentNumber)){
					$sqlInvention ="SELECT problem,solution,infringement,system,products,companies,p_infringe,related_system_texts,infringe_text FROM due_dilligence_inventions WHERE patent_id=?";
					$inventionStmt = $this->db->prepare($sqlInvention);
					$inventionStmt->execute([$patentNumber]);
					$problem="&nbsp;";
					$solution="&nbsp;";
					$infringement="&nbsp;";
					$system="&nbsp;";
					$products="&nbsp;";
					$companies="&nbsp;";
					$p_infringe="&nbsp;";
					$relatedSystemText = "";
					$allExplanationText = array();
					if($inventionStmt->rowCount()>0){
						$getInventionData = $inventionStmt->fetch();
						$problem = (!empty($getInventionData->problem))?$getInventionData->problem:'&nbsp;';
						$solution = (!empty($getInventionData->solution))?$getInventionData->solution:'&nbsp;';
						$infringement = (!empty($getInventionData->infringement))?$getInventionData->infringement:'&nbsp;';
						$system = (!empty($getInventionData->system))?$getInventionData->system:'&nbsp;';
						$products = (!empty($getInventionData->products))?$getInventionData->products:'&nbsp;';
						$companies = (!empty($getInventionData->companies))?$getInventionData->companies:'&nbsp;';
						$p_infringe = (!empty($getInventionData->p_infringe))?$getInventionData->p_infringe:'&nbsp;';
						$relatedSystemText = $getInventionData->related_system_texts;
						$infringe_text = $getInventionData->infringe_text;						
						if($infringe_text!=""){
							$textInfringe = json_decode($infringe_text);
							if(count($textInfringe)>0 && (is_object($textInfringe) || is_array($textInfringe))){
								foreach($textInfringe as $t){
									array_push($allExplanationText,$t);
								}
							}
						}
						if(!empty($relatedSystemText)){
							$allSystems = json_decode($relatedSystemText,true);
							if(count($allSystems)>0 && is_array($allSystems)){
								$al = 0;
								$system = "";
								foreach($allSystems as $allSystem){
									if($al<3){
										if(!empty($allSystem[0]) && !empty($allSystem[1])){
$sqlPatentCategory ="SELECT name,parent,type FROM category WHERE id=( SELECT parent FROM category WHERE name = ? LIMIT 1)";
$parentCatStmt = $this->db->prepare($sqlPatentCategory);
$parentCatStmt->execute([$allSystem[1]]);
if($parentCatStmt->rowCount()>0){
	$parentCatData =$parentCatStmt->fetch();
	if((int)$parentCatData->type==1){
		$sqlPPatentCategory ="SELECT name,parent FROM category WHERE id = ?";
		$ppatentCatStmt = $this->db->execute($sqlPPatentCategory);
		$ppatentCatStmt->execute([$parentCatData->parent]);
		if($ppatentCatStmt->rowCount()>0){
		$parentPCatData = $ppatentCatStmt->fetch();
		$system .= $parentPCatData->name .' - '.$parentCatData->name.' - '.$allSystem[1];
		}else {
			$system .= $parentCatData->name.' - '.$allSystem[1];
		}
	} else {
		$system .= $parentCatData->name.' - '.$allSystem[1];
	}
} else {
	$system .= $allSystem[1];
}
if($al<count($allSystem)){
	$system .="<br/>";
}
										}
									}
									$al++;
								}
							}
						}
					}
					$inventionData = array('problem'=>preg_replace("/Â/","",$problem),'solution'=>preg_replace("/Â/","",$solution),'infringement'=>preg_replace("/Â/","",$infringement),'system'=>preg_replace("/Â/","",$system),'products'=>$products,'companies'=>$companies,'p_infringe'=>$p_infringe,'related_system_text'=>$relatedSystemText,'all_explanation'=>$allExplanationText);
					$returnData = array('status'=>200,'data'=>$inventionData);
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Invalid docket','error_code'=>300);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/*
	*	Evidence of Use
	*
	*/
	public function docket_evidence_of_use($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		try{
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$docketNumber = $req->getAttribute('docket_number');
				if($docketNumber>0){
					$patentNumber = $req->getAttribute('value');
					$t = $req->getAttribute('t');
					if($t!=1 && $t!=2){
						$t = 2;
					}
					if(!empty($patentNumber)){
						/**/
						/*Get LeadID*/
						$getLeadID = DataController::getLeadID($docketNumber);
						if($getLeadID>0){
							/*Find ClaimChart Order*/
							$orderName = DataController::getClaimchartOrderName($getLeadID);
							if(trim($orderName)!=""){
								$paypalURL = "";
								$paypalEmail="";
								$getPaypalData = DataController::getPaypalData();
								if(count($getPaypalData)>0){
									$paypalEmail = $getPaypalData->email_id;
									if($getPaypalData->mode==1){ 
										$paypalURL = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9&business=";
									} else {
										$paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&notify_version=2.9&business=";
									}
								}
								$getProjectData = DataController::getClaimChartsQuestionAnswerData($orderName,$patentNumber,$t);
								$getProjectData['p_email'] = $paypalEmail;
								$getProjectData['payment_gateway_url'] = $paypalURL;
								$getProjectData['site_url'] ='https://experts.synpat.com/';
								$returnData['data'] = $getProjectData;
								$returnData['status'] = 200;
							} else {
								$returnData = array('status'=>200,'message'=>'No record found');
							}
						} else {
							$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
						}						
					} else {
						$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
					}
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Invalid token','error_code'=>110);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>100);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	
	/*
	*	Buy a Report for Claimchart or Prior Art
	*
	*/
	
	public function claimchart_buy_report($app,$req,$resp,$args = []) {
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		try{
			
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$docketNumber = $req->getAttribute('docket_number');
				if($docketNumber>0){
					$getLeadID = DataController::getLeadID($docketNumber);
					if($getLeadID>0){
						/*Find ClaimChart Order*/
						$orderName = DataController::getClaimchartOrderName($getLeadID);
						if(trim($orderName)!=""){
							$postData = $req->getParsedBody();	
							$random = $postData['amt'];
							$surveyID = $postData['su'];
							$expertID = $postData['ex'];
							$target = $postData['target'];
							$target_product = $postData['target_product'];
							if ($random != "" && $target!="" && $expertID > 0 && $surveyID > 0 &&  $random > 0) {
								$insertTransaction = array('amount'=>$random,'success'=>'unpaid','create_date'=>date('Y-m-d H:i:s'),'message'=>'Redirect to paypal','survey_id'=>$surveyID,'expert_id'=>$expertID,'type'=>0,'discount_amt'=>0,'target'=>$target,'target_product'=>$target_product);
								$insertData = DataController::insertData('ep7gx_transactions',$insertTransaction,1);
								if($insertData > 0) {
									$returnData['data'] = array('file_no'=>$insertData);
									$returnData['status'] = 200;
								} else {
									$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>100);
								}
							} else {
								$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
							}
						} else {
							$returnData = array('status'=>200,'message'=>'No record found');
						}
					} else {
						$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
					}
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Invalid token','error_code'=>110);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>100);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/*
		Docket Comparables
		return list of agreements
	*/
	public function docket_comparables($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			if($docketNumber>0){
				$docketID = DataController::getDocketID($docketNumber);
				if($docketID>0){
					$queryComparable = "SELECT file_name,payment_terms,licensor,licensee,file_link FROM comparables WHERE license_id= ?";
					$comparableStmt = $this->db->prepare($queryComparable);
					$comparableList = array();
					$comparableStmt->execute([$docketID]);
					if($comparableStmt->rowCount()>0){
						while($row = $comparableStmt->fetch()){
							$row->file_link = str_replace("http:","https:",$row->file_link);
							$licensor = $row->licensor;
							$licensor = explode(" ",$licensor);
							for($p = 0;$p<count($licensor);$p++){
								$licensor[$p] = ucfirst(strtolower(trim($licensor[$p])));
							}
							$row->licensor = implode(" ",$licensor);
							$licensee = $row->licensee;
							$licensee = explode(" ",$licensee);
							for($p = 0;$p<count($licensee);$p++){
								$licensee[$p] = ucfirst(strtolower(trim($licensee[$p])));
							}
							$row->licensee = implode(" ",$licensee);
							array_push($comparableList,$row);							
						}
						$returnData = array('status'=>200,'data'=>$comparableList);
					} else {
						$returnData = array('status'=>200,'message'=>'No record found','data'=>$comparableList);
					}
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid docket','error_code'=>300);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Bad Inputs','error_code'=>400);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>100);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	/*
		Docket Royalties
		return royalty file
	*/
	public function docket_royalties($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			if($docketNumber>0){
				$docketID = DataController::getDocketID($docketNumber);
				if($docketID>0){
					/*$queryRoyalty = "SELECT file_name,file_link FROM damages WHERE license_id= ?";
					$royaltyStmt = $this->db->prepare($queryRoyalty);
					$royaltyList = array();
					$royaltyStmt->execute([$docketID]);
					if($royaltyStmt->rowCount()>0){
						while($row = $royaltyStmt->fetch()){
							$row->file_link = DataController::changeFileToViewOnly($row->file_link);
							array_push($royaltyList,$row);
						}
						$returnData = array('status'=>200,'data'=>$royaltyList);
					} else {
						$returnData = array('status'=>200,'message'=>'No record found','data'=>$royaltyList);
					}*/
					/*query comparables*/
					$queryComparable = "SELECT s.payment_terms,s.licensor,s.licensee,s.filing_date,s.agreement_date,s.file_name FROM comparables as c INNER JOIN sec_agreements as s ON s.id = c.sec_id WHERE c.license_id= ?";
					$comparableStmt = $this->db->prepare($queryComparable);
					$comparableList = array();
					$comparableStmt->execute([$docketID]);
					if($comparableStmt->rowCount()>0){
						while($row = $comparableStmt->fetch()){
							$paymentTerm = $row->payment_terms;
							$p = 0;
							$value = null;
							$value1 = null ;
							if(strpos($paymentTerm,'%') !== false){								
								preg_match_all('/\d+\.\d{1,2}/', $paymentTerm, $list);
								if(count($list) > 0 && count($list[0]) > 0){
									$p = 1;
									$value = $list[0][0];
								} else {
									preg_match_all('/\d+\%/', $paymentTerm, $list);
									if(count($list) > 0 && count($list[0]) > 0){
										$p = 1;
										$value = $list[0][0];
									}
								}
							} else {
								/*preg_match_all('/((?:[0-9]+,)*[0-9]+(?:\.[0-9]+)?)/', $paymentTerm, $list); */
								preg_match_all('/\$\d+\,\d+/', $paymentTerm, $list); 
								if(count($list) > 0 && count($list[0]) > 0){
									$p = 2;
									$value1 = $list[0][0] ;
									$value1 = str_replace(array(','),'',$value1);
								} else {
									/**/
									preg_match_all('/\$\d+\.\d+\M/', $paymentTerm, $list);
									if(count($list) > 0 && count($list[0]) > 0){
									$p = 2;
									$value1 = $list[0][0] ;
									$value1 = str_replace(array('$','M'),'',$value1);
									$value1 = $value1 * 1000000;
									$value1 = '$'.$value1;
									} else {
										preg_match_all('/\$\d+/', $paymentTerm, $list);
										if(count($list) > 0 && count($list[0]) > 0){
											$p = 2;
											$value1 = $list[0][0] ;
										}
									}									
								}								
							}
							if($p == 1 || $p == 2){
								$date = $row->filing_date;
								if($date == null){
									$date = $row->agreement_date;
								}
								$d  = date('Y-m-d',strtotime($date));
							}
							array_push($comparableList,array('licensor'=>$row->licensor,'licensee'=>$row->licensee,'p'=>$p,'value'=>$value,'value1'=>$value1,'d'=>$d,'payment_terms'=>$row->payment_terms,'file_name'=>$row->file_name));							
						}						
					}
					/*End query*/
					
					$queryLitigation = "SELECT id,parties,party1,party2,filled_date,company_id1,company_id2 FROM lead_litigation WHERE `show` = 0 AND serial_number = ? ";
					$litigationStmt = $this->db->prepare($queryLitigation);
					$litigationStmt->execute([$docketNumber]);
					$litigation_data = array();
					if($litigationStmt->rowCount()>0){
						while($row = $litigationStmt->fetch()){		
							$parties = explode(' v. ',$row->parties);
							if(count($parties) == 2){
								if(trim($parties[0]) != "" && trim($parties[1]) != ""){
									$date = $row->filled_date;
									$party1 = trim($parties[0]);
									$party2 = trim($parties[1]);
									$d = "";
									if($row->filled_date != 'Unknown Date'){
										$date = date('Y-m-d',strtotime($row->filled_date));
										$d = date('Y',strtotime($row->filled_date));
									} else if($row->filled_date == 'Unknown Date' && count($litigation_data) > 0){
										$filled_date = $litigation_data[count($litigation_data)-1]['filled_date'];
										$date = date('Y-m-d',strtotime($filled_date));
										$d = date('Y',strtotime($filled_date));
									}									
									if(substr($party1,-1) == "."){
										$party1 = substr($party1,0,-1);
									}
									if(substr($party2,-1) == "."){
										$party2 = substr($party2,0,-1);
									}
									if(strpos($party1,"(") !== false){
										$party1 = substr($party1,0,stripos($party1,"("));
									}
									if(strpos($party2,"(") !== false){
										$party2 = substr($party2,0,stripos($party2,"("));
									}
									$party1 = trim($party1);
									$party2 = trim($party2);									
									$operation = DataController::findCompanySector($party1,$party2,$row->company_id1,$row->company_id2);
									array_push($litigation_data,array('id'=>$row->id,'company'=>$party1,'company2'=>$party2,'filled_date'=>$date,'d'=>$d,'data'=>1,"operation"=>$operation));
								}								
							}
						}
						/*for($i=0;$i<count($litigation_data);$i++){
							if($litigation_data[$i]['filled_date'] == 'Unknown Date'){
								$time = strtotime($litigation_data[$i-1]['filled_date']);
								$litigation_data[$i]['filled_date'] = date('Y-m-d',$time);
								$litigation_data[$i]['d'] = date('Y',$time);
							}			
						}*/
						$filledDate = array_map(function($element){return $element['d'];}, $litigation_data);
						$countvalues = array_count_values($filledDate);
						foreach($countvalues as $key=> $value){
							if($value > 1){
								$date = $key;
								$data = 1;
								for($i=0;$i<count($litigation_data);$i++){									
									if(date('Y',strtotime($litigation_data[$i]['filled_date'])) == $date){
										$litigation_data[$i]['data'] = $data;
										$data +=1;
									}
								}
							}
						}
					}
					$data = array('litigation_cases'=>$litigation_data,'royalty_cases'=>$comparableList);
					$returnData = array('status'=>200,'data'=>$data);
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid docket','error_code'=>300);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Bad Inputs','error_code'=>400);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>100);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	private function findCompanySector($company1,$company2,$companyID1,$companyID2){
		$operation = "#C20000";
		$where = "";
		if($companyID1 > 0){
			$where = "c.id = ?";
		} else {
			$where = "(c.company_name = ? OR con.name = ?)";
		}
		$applicantC = "SELECT c.id  FROM company as c INNER JOIN company_sector as cs ON cs.company_id = c.id LEFT JOIN company_other_names as con ON con.company_id = c.id WHERE ".$where." AND cs.sector_id IN(79,21) ORDER BY c.company_name ASC LIMIT 1";
		$applicantStmt = $this->db->prepare($applicantC);
		$companyName = htmlspecialchars_decode(trim($company1), ENT_NOQUOTES);
		if($companyID1 > 0){
			$applicantStmt->execute([$companyID1]);
		} else {
			$applicantStmt->execute([$companyName,$companyName]);
		}		
		$countRows = $applicantStmt->rowCount();
		if($countRows > 0){
			$where = "";
			if($companyID2 > 0){
				$where = "c.id = ?";
			} else {
				$where = "(c.company_name = ? OR con.name = ?)";
			}
			$applicantC = "SELECT c.id  FROM company as c INNER JOIN company_sector as cs ON cs.company_id = c.id LEFT JOIN company_other_names as con ON con.company_id = c.id WHERE ".$where." AND cs.sector_id IN(79,21) ORDER BY c.company_name ASC LIMIT 1";
			$applicantStmt = $this->db->prepare($applicantC);
			$companyName = htmlspecialchars_decode(trim($company2), ENT_NOQUOTES);
			if($companyID2 > 0){
				$applicantStmt->execute([$companyID2]);
			} else {
				$applicantStmt->execute([$companyName,$companyName]);
			}
			$countRows = $applicantStmt->rowCount();
			if($countRows > 0){
				$operation = "#0a860a";
			}
		}
		return $operation;
	}
	
	/*
		Docket Citations
		param: t=>1(FCitations)or t=>0(BCitations)
	*/
	public function docket_citations($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			if($docketNumber>0){
				$getLeadID = DataController::getLeadID($docketNumber);
				if($getLeadID>0){
					$patentList = DataController::getPatentList($getLeadID);
					if(count($patentList)>0){
						$patents = array();
						foreach($patentList as $p){
							array_push($patents, $p->patent_number);
						}
						$citationList = array();
						$type = $req->getAttribute('t');
						$patentImplode = str_repeat ('?, ',  count ($patents) - 1) . '?';
						array_push($patents, $type);
						$queryCitation = "SELECT id,cited_patent,original_assignee,applicant,title,patent_id FROM due_dilligence_citations WHERE patent_id IN ($patentImplode) AND type=? ORDER BY applicant ASC";
						$citationStmt = $this->db->prepare($queryCitation);
						$citationStmt->execute($patents);
						$list = array();
						if($citationStmt->rowCount()>0){
							while($row = $citationStmt->fetch()){
								array_push($list,$row);
							}
						}
						foreach($patentList as $p) {
							$patentDataList = array();
							foreach($list as $l) {
								if($l->patent_id == $p->patent_number){
									array_push($patentDataList,$l);
								}
							}
							array_push($citationList,array('patent_number'=>$p->patent_number,'file_no'=>$p->id,'list'=>$patentDataList));
						}
						$returnData = array('status'=>200,'data'=>array('all'=>$list,'patents'=>$citationList));
					} else {
						$returnData = array('status'=>200,'data'=>array(),'message'=>'No record found!');
					}
				} else {
					$returnData = array('status'=>200,'error_code'=>400,'message'=>'Invalid input');
				}
			} else {
				$returnData = array('status'=>200,'error_code'=>400,'message'=>'Invalid input');
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'error_code'=>500,'message'=>'Internal server error');
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	
	public function docket_clogos_by_id($app,$req,$resp,$args = []) {
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		//$headers = $req->getHeaders();
		//$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$postData = $req->getParsedBody();	
			$docketNumber = $req->getAttribute('docket_number');
			$citationID = $req->getAttribute('citation_id');
			if($docketNumber > 0 && $citationID > 0) {
				$getLeadID = DataController::getLeadID($docketNumber);
				if($getLeadID > 0) {
					$queryCitation = "SELECT id, original_assignee,applicant,'' as logo, '' as logo1,company_id FROM due_dilligence_citations WHERE id = ?";
					$citationStmt = $this->db->prepare($queryCitation);
					$citationStmt->execute([$citationID]);
					$displayData = array();
					if($citationStmt->rowCount()>0){
						$c = $citationStmt->fetch();
						$getData = array();
						if($c->company_id > 0){
							$getData = DataController::findCompanyLogoByID($c->company_id,$c->applicant,array(),1);
						}
						$tap = true;
						if(isset($getData['img']) && $getData['img'] != ""){
							$tap = false;
						}
						if($tap === true) {
							$getData = DataController::findCompanyLogo($c->applicant,array(),1);
						}						
						/*if($getData['count']==0){
							if(explode(" ",$c->applicant)>1){
								$getData = DataController::findCompanyLogo($c->applicant,array(),2);
								if($getData['count']==0){
									$getData = DataController::findCompanyLogo($c->applicant,array(),3);
									if($getData['count']==0){
										$getData = array('applicant'=>$c->applicant,'applicantList'=>array(),'img'=>'','count'=>0,'company_logo'=>'');
									}
								}
							}
						}*/
						if(isset($getData['img']) && $getData['img']!=""){
							$imgCurrentAssignee = $getData['img'];
							$newData = array('id'=>$c->id,'logo'=>$imgCurrentAssignee,'sd'=>true,'logo1'=>'','applicant'=>$getData['applicant'],'applicant1'=>'');
							if($c->applicant == $c->original_assignee){
								array_push($displayData,$newData);
							} else {
								$getData = DataController::findCompanyLogo($c->original_assignee,array(),1);
								/*if($getData['count']==0){
									if(explode(" ",$c->original_assignee)>1){
										$getData = DataController::findCompanyLogo($c->original_assignee,array(),2);
										if($getData['count']==0){
											$getData = DataController::findCompanyLogo($c->original_assignee,array(),3);
											if($getData['count']==0){
												$getData = array('applicant'=>$c->original_assignee,'applicantList'=>array(),'img'=>'','count'=>0,'company_logo'=>0);
											}
										}
									}
								}*/
								if(isset($getData['img']) && $getData['img']!=""){
									if($imgCurrentAssignee != $getData['img']){
										$newData['sd'] = false;
										$newData['logo1'] = $getData['img'];
										$newData['applicant1'] = $getData['applicant'];
									} 
								}
								array_push($displayData,$newData);
							}							
						}
					}
					$returnData = array('status'=>200,'message'=>'','data'=>$displayData);
				} else {
					$returnData = array('status'=>200,'message'=>'Bad Input','error_code'=>400);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Bad Input','error_code'=>400);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>500);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	
	/*
		Docket Clogos
		param: t=>1(FCitations)or t=>0(BCitations)
	*/
	public function docket_clogos($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$postData = $req->getParsedBody();	
			$docketNumber = $postData['docket_number'];
			if($docketNumber>0){
				$getLeadID = DataController::getLeadID($docketNumber);
				if($getLeadID>0){
					$patentList = DataController::getPatentList($getLeadID);
					if(count($patentList)>0){
						$displayData = array();
						$applicantsList = array();						
						if(isset($postData['app_list'])){
							$applicantsList = $postData['app_list'];
						}
						$patents = array();
						foreach($patentList as $p){
							$patents[] = $p->patent_number;
						}
						$patentImplode = str_repeat ('?, ',  count ($patents) - 1) . '?';
						$type = $postData['t'];
						$queryCitation = "SELECT id, original_assignee,applicant,'' as logo, '' as logo1 FROM due_dilligence_citations WHERE patent_id IN ($patentImplode) AND type=?";
						$citationStmt = $this->db->prepare($queryCitation);
						$citationStmt->execute(array_merge($patents,array($type)));
						if($citationStmt->rowCount()>0){
							$citationData = array();
							while($row = $citationStmt->fetch()){
								array_push($citationData,$row);
							}
							foreach($citationData as $c){
								$recordData = array();
								if(count($applicantsList)>0){
									foreach($applicantsList as $app){
										$app = (object)$app;
										if(trim($app->applicant)!="" && trim($c->applicant)!=""){
											if(strpos($app->applicant,$c->applicant)!==false){
												$recordData = $app;
												break;
											}
										}
									}
								}
								$newData = array();
								if(count($recordData)>0){
									if($recordData->img!="" && strpos($recordData->img,"http")!==false){
										$newData = array('id'=>$c->id,'logo'=>$recordData->img,'sd'=>true,'logo1'=>'','applicant'=>$recordData->applicant,'applicant1'=>'');
									}
								}
								if(count($newData)>0){
									if($c->applicant==$c->original_assignee){
										array_push($displayData,$newData);
									} else {
										$recordData1 = array();
										if(count($applicantsList)>0){
											foreach($applicantsList as $app){
												$app = (object)$app;
												if(trim($app->applicant)!="" && trim($c->original_assignee)!=""){
													if(strpos($app->applicant,$c->original_assignee)!==false){
														$recordData1 = $app;
														break;
													}
												}
											}
										}
										$newData1 = array();
										if(count($recordData1)>0){
											if($recordData1->img!="" && strpos($recordData1->img,"http")!==false){
												$newData1 = array('id'=>$c->id,'logo'=>$recordData1->img,'sd'=>false,'logo1'=>'','applicant'=>$recordData1->applicant);
											}
										}
										if(count($newData1)>0){
											if($newData1['logo']!=$newData['logo']){
												$newData['sd'] = false;
												$newData['logo1'] = $newData1['logo'];
												$newData['applicant1'] = $newData1['applicant'];
											} 
										} else {
											$getData = DataController::findCompanyLogo($c->original_assignee,$applicantsList,1);
											/*if($getData['count']==0){
												if(explode(" ",$c->original_assignee)>1){
													$getData = DataController::findCompanyLogo($c->original_assignee,$applicantsList,2);
													if($getData['count']==0){
														$getData = DataController::findCompanyLogo($c->original_assignee,$applicantsList,3);
														if($getData['count']==0){
															$getData = array('applicant'=>$c->original_assignee,'applicantList'=>$applicantsList,'img'=>'','count'=>0,'company_logo'=>'');
														}
													}
												}
											}*/
											$applicantsList = $getData['applicantList'];
											if($getData['company_logo']!="" && $newData['logo']!=$getData['company_logo']){
												$newData['sd'] = false;
												$newData['logo1'] = $getData['company_logo'];
												$newData['applicant1'] = $getData['applicant'];
											}
										}
										array_push($displayData,$newData);
									}
								} else {
									$getData = DataController::findCompanyLogo($c->applicant,$applicantsList,1);
									/*if($getData['count']==0){
										if(explode(" ",$c->applicant)>1){
											$getData = DataController::findCompanyLogo($c->applicant,$applicantsList,2);
											if($getData['count']==0){
												$getData = DataController::findCompanyLogo($c->applicant,$applicantsList,3);
												if($getData['count']==0){
													$getData = array('applicant'=>$c->applicant,'applicantList'=>$applicantsList,'img'=>'','count'=>0,'company_logo'=>'');
												}
											}
										}
									}*/
									$applicantsList = $getData['applicantList'];
									if(isset($getData['img']) && $getData['img']!=""){
										$imgCurrentAssignee = $getData['img'];
										$newData = array('id'=>$c->id,'logo'=>$imgCurrentAssignee,'sd'=>true,'logo1'=>'','applicant'=>$getData['applicant'],'applicant1'=>'');
										if($c->applicant == $c->original_assignee){
											array_push($displayData,$newData);
										} else {
											$recordData1 = array();
											if(count($applicantsList)>0){
												foreach($applicantsList as $app){
													$app = (object)$app;
													if(trim($app->applicant)!="" && trim($c->original_assignee)!=""){
														if(strpos($app->applicant,$c->original_assignee)!==false){
															$recordData1 = $app;
															break;
														}
													}
												}
											}
											$newData1 = array();
											if(count($recordData1)>0){
												if($recordData1->img!="" && strpos($recordData1->img,"http")!==false){
													$newData1 = array('id'=>$c->id,'logo'=>$recordData1->img,'sd'=>false,'logo1'=>'','applicant'=>$recordData1->applicant);
												}
											}
											if(count($newData1)>0){
												if($newData1['logo']!=$imgCurrentAssignee){
													$newData['sd'] = false;
													$newData['logo1'] = $newData1['logo'];
													$newData['applicant1'] = $newData1['applicant'];
												} 
											} else {
												$getData = DataController::findCompanyLogo($c->original_assignee,$applicantsList,1);
												/*if($getData['count']==0){
													if(explode(" ",$c->original_assignee)>1){
														$getData = DataController::findCompanyLogo($c->original_assignee,$applicantsList,2);
														if($getData['count']==0){
															$getData = DataController::findCompanyLogo($c->original_assignee,$applicantsList,3);
															if($getData['count']==0){
																$getData = array('applicant'=>$c->original_assignee,'applicantList'=>$applicantsList,'img'=>'','count'=>0,'company_logo'=>0);
															}
														}
													}
												}*/
												$applicantsList = $getData['applicantList'];
												if(isset($getData['img']) && $getData['img']!=""){
													if($imgCurrentAssignee != $getData['img']){
														$newData['sd'] = false;
														$newData['logo1'] = $getData['img'];
														$newData['applicant1'] = $getData['applicant'];
													} 
												}
											}
											array_push($displayData,$newData);
										}
									}
								}
							}
						}
						$cLogosData = array('i_list'=>$displayData,'a_list'=>$applicantsList);
						$returnData = array('status'=>200,'data'=>$cLogosData);
					} else {
						$returnData = array('status'=>200,'message'=>'Invalid docket','error_code'=>300);
					}
				} else {
					$returnData = array('status'=>200,'message'=>'Bad Input','error_code'=>400);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Bad Input','error_code'=>400);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>500);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/*
		Docket Seller
		param: patent number
	*/
	
	public function docket_seller($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			$patentNumber = $req->getAttribute('value');
			if($docketNumber>0 && trim($patentNumber)!=""){
				$getLicenseID = DataController::getDocketID($docketNumber);
				$formatD = 'm-d-Y';
				if($getLicenseID>0){
					$licenseData = array('target'=>false,'target1'=>false,'grant'=>false,'list'=>array(),'pt'=>trim($patentNumber));
					$sqlLicenseData ="SELECT licensee_file,licensee,expiration,expiration_valid,license_products,license_products_text,territory,territory_text,license_fee,transferable as assignable,subject_condition_assignable,sublicense,subject_condition_sublicense,exclusive,subject_condition_exclusive,right_to_sue,subject_condition_right_to_sue,target,show_data FROM due_dilligence_licenses_data WHERE license_id=? AND patent_id=?";
					$licenseStmt = $this->db->prepare($sqlLicenseData);
					$licenseStmt->execute([$getLicenseID,$patentNumber]);
					$checkLicense = false;
					if($licenseStmt->rowCount()>0){
						$tap = false;
						while($row = $licenseStmt->fetch()){
							if($checkLicense==false){
								$licenseData['grant'] = false;
								if($row->show_data==2){
									$licenseData['grant'] = true;
								}
								$licenseData['target'] = false;
								$licenseData['target1'] = false;
								if($row->target==1){
									$licenseData['target'] = true;
								} else if($row->target==2){
									$licenseData['target1'] = true;
								}
								$checkLicense = true;
							}
							if((int)$row->show_data==1){
								$tap = true;
								break;
							}
							if((int)$row->show_data==2){
								unset($row->target);
								unset($row->show_data);
								if($row->expiration_valid == 1){
									$row->expiration_show = true;
									$row->expiration_valid = false;
								} else {
									$row->expiration_show = false;
									$row->expiration_valid = false;
								}
								if($row->expiration!="" && $row->expiration!="0000-00-00 00:00:00" && $row->expiration!="1970-Jan-01"){
									$row->expiration = date($formatD,strtotime($row->expiration));
								} else {
									$row->expiration = "";
								}
								
								if($row->license_products == 1) {
									$row->license_products = true;
								} else {
									$row->license_products = false;
								}
								
								if($row->territory == 1) {
									$row->territory = true;
								} else {
									$row->territory = false;
								}
								
								if($row->license_fee == 1) {
									$row->license_fee = true;
								} else {
									$row->license_fee = false;
								}
								
								if($row->assignable == 1) {
									$row->transferable = true;
								} else {
									$row->transferable = false;
								}
								$row->transferable1 = false;
								if($row->assignable == 2) {
									$row->transferable1 = true;
									$row->transferable = 1;
								}
								
								if($row->sublicense == 1) {
									$row->sublicense = true;
								} else {
									$row->sublicense = false;
								}
								$row->sublicense1 = false;
								if($row->sublicense == 2) {
									$row->sublicense1 = true;
								}
								
								if($row->exclusive == 1) {
									$row->exclusive = true;
								} else {
									$row->exclusive = false;
								}
								
								if($row->right_to_sue == 1) {
									$row->right_to_sue = true;
								} else {
									$row->right_to_sue = false;
								}
								
								if(!empty($row->licensee_file)){
									$row->licensee_file ="<a href='javascript://' onclick='openSourceLink($(this),1)' data-href='https://synpat.com/docket-services/dd/assets/uploads/".rawurlencode(str_replace(':','_',$row->licensee_file))."'><i class='fa fa-file'></i></a>";
								}								
								array_push($licenseData['list'],$row);
							}							
						}
						if($tap === true) {
							$row = array('expiration_valid'=> false, 'expiration'=>'','license_products'=>false,'territory'=>false,'license_fee'=>false,'transferable'=>false,'transferable1'=>false,'sublicense'=>false,'sublicense1'=>false,'exclusive'=>false,'right_to_sue'=>false,'licensee_file'=>'');
							array_push($licenseData['list'],$row);
						}
					} else {
						$row = array('expiration_valid'=> false, 'expiration'=>'','license_products'=>false,'territory'=>false,'license_fee'=>false,'transferable'=>false,'transferable1'=>false,'sublicense'=>false,'sublicense1'=>false,'exclusive'=>false,'right_to_sue'=>false,'licensee_file'=>'');
						array_push($licenseData['list'],$row);
					}
					$titleData = array();
					$patentData = "";
					$lengthString = strlen($patentNumber);
					switch($lengthString){
						case 9:
							$patentData =substr($patentNumber,2);
						break;
						case 11:
						case 13:
							$patentData =substr($patentNumber,2);
							$patentData =substr($patentData,0,-2);
						break;
						default:
							$patentData = $patentNumber;
						break;
					}
					if(strtolower(substr($patentNumber,0,2))=="us"){
						$patentData = $patentNumber;
						if(strlen($patentData)>9){
							$patentData = substr($patentData,2,-2);
						} else if(strlen($patentData)==9) {
							$patentData = substr($patentData,2);
						}
						if($patentData != "") {
							$sqlTitle = "SELECT assigments FROM lead_patent_family_member WHERE publication_number=?";
							$titleStmt = $this->db->prepare($sqlTitle);
							$titleStmt->execute([$patentData]);
							if($titleStmt->rowCount()>0){
								$row = $titleStmt->fetch();
								$dtAssign = $row->assigments;
								if($dtAssign!=""){
									try{
										$assignmentData = json_decode($dtAssign);
										if(count($assignmentData)>0){
											foreach($assignmentData as $ad){
												$asData = (object) array('recorded'=>$ad->recorded,
																'assignee_date'=>$ad->assignee_date,
																'rights'=>$ad->rights,
																'assignor'=>$ad->assignor,
																'assignee'=>$ad->assignee,
																'title_file'=>'',
																'comment'=>'');
												array_push($titleData,$asData);
											}
										}
									}catch(Exception $e){
										
									}
								}
							}
						}
					} else {
						$sqlTitle ="SELECT title_file,assignor,assignee,assignee_date,recorded,rights,comment FROM due_dilligence_titles WHERE patent_id=?";
						$titleStmt = $this->db->prepare($sqlTitle);
						$titleStmt->execute([$patentData]);
						if($titleStmt->rowCount()>0){
							while($row = $titleStmt->fetch()){
								array_push($titleData,$row);
							}
						}
					}
					$titleList = array();
					if(count($titleData)>0){
						foreach($titleData as $getTitleData){
							$recorded ="";
							$lastColor = '';
							$lastDate = '';
							if(!empty($getTitleData->recorded)){
								$recorded = date('M d,Y',strtotime($getTitleData->recorded));
							}
							$execDt = "";
							if(!empty($getTitleData->assignee_date)){
								$execDt = date('M d,Y',strtotime($getTitleData->assignee_date));
							}
							$flagColor = 0;
							if(!empty($getTitleData->rights)) {
								if(strpos($getTitleData->rights,strtoupper(strtolower('Assignment')))!==false){	
									$flagColor = 1;
									$anotherColor = '';
									if(empty($lastColor)){
										$lastColor = 'blueton';	
										$lastDate = $recorded;	
									} else {
										if(!empty($lastDate) && $lastDate!=$recorded){
											$lastColor = ($lastColor=='blueton')?'orangeton':'blueton';
											$lastDate = $recorded;
										}else if(!empty($lastDate) && $lastDate==$recorded){
											$lastDate = $recorded;
										}
									}
								} else {
									if(strpos($getTitleData->rights,'Security')!==false){
										$anotherColor = 'redton';
										$flagColor = 1;
									} else if(strpos($getTitleData->rights,'Secured')!==false){
										$anotherColor = 'redton';
										$flagColor = 1;
									} else {
										$flagColor = 0;
										$anotherColor = '';
									}
								}
							} else {
								$flagColor = 0;
							}
							$classShow = "";
							if($flagColor == 1) {
								$classShow = $lastColor." ".$anotherColor;
							}
							$document = "";
							if(!empty($getTitleData->title_file)) {
								$document = "<a href='javascript://' class='colorBlue' onclick='openSourceLink($(this),1)' data-href='https://synpat.com/docket-services/dd/assets/uploads/".rawurlencode(str_replace(':','_',$getTitleData->title_file))."'><i class='fa fa-file'></i></a>";
							}			
							$show_comment = false;
							if(!empty($getTitleData->title_file)){
								$show_comment = true;
							}
							array_push($titleList, array('class'=>$classShow,'execDt'=>$execDt,'assignor'=>$getTitleData->assignor,'assignee'=>$getTitleData->assignee,'rights'=>$getTitleData->rights,'recorded'=>$getTitleData->recorded,'comment'=>$getTitleData->comment,'file'=>$document,'show_comment'=>$show_comment));
						}
					}					
					$thirdPartyData = array('target'=>false,'grant'=>false,'list'=>array(),'pt'=>trim($patentNumber));
					$sqlParty ="SELECT invloved_third_party,date_of_aggreement,comment,party as file,knowledge,show_data FROM due_dilligence_parties_data WHERE patent_id=? AND license_id=?";
					$partyStmt = $this->db->prepare($sqlParty);
					$partyStmt->execute([$patentNumber,$getLicenseID]);
					$checkTitle = false;
					if($partyStmt->rowCount()>0){
						$tap = false;
						while($row = $partyStmt->fetch()){
							if($checkTitle==false){
								$thirdPartyData['grant'] = false;
								if($row->show_data==2){
									$thirdPartyData['grant'] = true;
								}
								$thirdPartyData['target'] = false;
								if($row->knowledge==1){
									$thirdPartyData['target'] = true;
								}
								$checkTitle = true;
							}
							if((int)$row->show_data==1){
								$tap = true;
								break;
							}
							if((int)$row->show_data==2){
								unset($row->knowledge);
								unset($row->show_data);
								$pDate = date('Y-m-d',strtotime($row->date_of_aggreement));
								if(!empty($row->date_of_aggreement) && $pDate!='1969-12-31' && $pDate!='1970-01-01' && $row->date_of_aggreement!='0000-00-00 00:00:00'){
									$row->date_of_aggreement = date($formatD,strtotime($row->date_of_aggreement));
								} else {
									$row->date_of_aggreement = '';
								}
								if(!empty($row->party)) {
									$row->party = "<a href='javascript://'  class='colorBlue' onclick='openSourceLink($(this),1)' data-href='https://synpat.com/docket-services/dd/assets/uploads/".rawurlencode(str_replace(':','_',$row->party))."'><i class='fa fa-file'></i></a>";
								}
								array_push($thirdPartyData['list'],$row);
							}	
						}
						if($tap === true) {
							$row = array('invloved_third_party'=> '', 'date_of_aggreement'=>'','comment'=>'','party'=>'');
							array_push($thirdPartyData['list'],$row);
						}
					} else {
						$row = array('invloved_third_party'=> '', 'date_of_aggreement'=>'','comment'=>'','party'=>'');
						array_push($thirdPartyData['list'],$row);
					}
					$standardData = array('target'=>false,'grant'=>false,'list'=>array(),'pt'=>trim($patentNumber));
					$sqlStandard ="SELECT sdo,working_group,start_date,participants_claim,patent_file,commitment_file,knowledge,show_data,patent_data_another FROM due_dilligence_standards_data WHERE patent_id=? AND license_id=?";
					$standardStmt = $this->db->prepare($sqlStandard);
					$standardStmt->execute([$patentNumber,$getLicenseID]);
					$checkStandards=false;
					if($standardStmt->rowCount()>0){
						$tap = false;
						while($row = $standardStmt->fetch()){							
							if($checkStandards==false){
								$standardData['grant'] = false;
								if($row->show_data==2){
									$standardData['grant'] = true;
								}
								$standardData['target'] = false;
								if($row->knowledge==1){
									$standardData['target'] = true;
								}
								$checkStandards = true;
							}
							if((int)$row->show_data==1){
								$tap = true;
								break;
							}
							if((int)$row->show_data==2){
								unset($row->knowledge);
								unset($row->show_data);
								
								$pDate = date('Y-m-d',strtotime($row->start_date));
								if(!empty($row->start_date) && $pDate!='1969-12-31' && $pDate!='1970-01-01' && $row->start_date!='0000-00-00 00:00:00') { 
									$row->start_date =  date($formatD,strtotime($row->start_date));
								} else {
									$row->start_date =  '';
								}
								$claim = false;
								if($row->participants_claim == 1) {
									$claim = true;
								}
								$row->participants_claim = $claim;
								if($row->patent_file != "") {
									$row->patent_file = "<a href='javascript://'  class='colorBlue' onclick='openSourceLink($(this),1)' data-href='https://synpat.com/docket-services/dd/assets/uploads/".rawurlencode(str_replace(':','_',$row->patent_file))."'><i class='fa fa-file'></i></a>";
								}
								if($row->commitment_file != "") {
									$row->commitment_file = "<a href='javascript://'  class='colorBlue' onclick='openSourceLink($(this),1)' data-href='https://synpat.com/docket-services/dd/assets/uploads/".rawurlencode(str_replace(':','_',$row->commitment_file))."'><i class='fa fa-file'></i></a>";
								}
								array_push($standardData['list'],$row);
							}
						}
						if($tap === true) {
							$row = array('sdo'=> '','working_group'=> '', 'start_date'=>'','participants_claim'=>false,'commitment_file'=>'','patent_file'=>'');
							array_push($standardData['list'],$row);
						}
					} else {
						$row = array('sdo'=> '','working_group'=> '', 'start_date'=>'','participants_claim'=>false,'commitment_file'=>'','patent_file'=>'');
						array_push($standardData['list'],$row);
					}
					$collateralData = array('target'=>false,'grant'=>false,'list'=>array(),'pt'=>trim($patentNumber));
					$sqlCollateral ="SELECT creditor_name,date_for_aggreement,expirtation_date,terminated_file,comment,knowledge,show_data FROM due_dilligence_collaterals_data WHERE patent_id=? AND license_id=?";
					$collateralStmt = $this->db->prepare($sqlCollateral);
					$collateralStmt->execute([$patentNumber,$getLicenseID]);
					$checkCollaterals = false;
					if($collateralStmt->rowCount()>0){
						$tap = false;
						while($row = $collateralStmt->fetch()){
							if($checkCollaterals==false){
								$collateralData['grant'] = false;
								if($row->show_data==2){
									$collateralData['grant'] = true;
								}
								$collateralData['target'] = false;
								if($row->knowledge==1){
									$collateralData['target'] = true;
								}
								$checkCollaterals = true;
							}
							if((int)$row->show_data==1){
								$tap = true;
								break;
							}
							if((int)$row->show_data==2){
								unset($row->knowledge);
								unset($row->show_data);
								$pDate = date('Y-m-d',strtotime($row->date_for_aggreement));
								if(!empty($row->date_for_aggreement) && $collateralData['target'] == true  && $pDate!='1969-12-31' && $pDate!='1970-01-01' && $row->date_for_aggreement!='0000-00-00 00:00:00') {
									$row->date_for_aggreement = date($formatD,strtotime($row->date_for_aggreement));
								} else {
									$row->date_for_aggreement = '';
								}
								$pDate = date('Y-m-d',strtotime($row->expirtation_date));
								if(!empty($row->expirtation_date) && $collateralData['target'] == true  && $pDate!='1969-12-31' && $pDate!='1970-01-01' && $row->expirtation_date!='0000-00-00 00:00:00') {
									$row->expirtation_date = date($formatD,strtotime($row->expirtation_date));
								} else {
									$row->expirtation_date = '';
								}
								if($row->terminated_file != "" && $collateralData['target'] == true) {
									$row->terminated_file = "<a href='javascript://'  class='colorBlue' onclick='openSourceLink($(this),1)' data-href='https://synpat.com/docket-services/dd/assets/uploads/".rawurlencode(str_replace(':','_',$row->terminated_file))."'><i class='fa fa-file'></i></a>";
								} else {
									$row->terminated_file = '';
								}
								array_push($collateralData['list'],$row);
							}
						}
						if($tap === true) {
							$row = array('creditor_name'=> '','date_for_aggreement'=> '', 'expirtation_date'=>'','terminated_file'=>'','comment'=>'');
							array_push($collateralData['list'],$row);
						}
					} else {
						$row = array('creditor_name'=> '','date_for_aggreement'=> '', 'expirtation_date'=>'','terminated_file'=>'','comment'=>'');
						array_push($collateralData['list'],$row);
					}
					$returnData = array('status'=>200,'data'=>array('licenses'=>$licenseData,'title'=>$titleList,'party'=>$thirdPartyData,'standards'=>$standardData,'collaterals'=>$collateralData));
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid docket','error_code'=>300);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Bad Input','error_code'=>400);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>500);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	
	/*
		Docket PDF
		return Google Drive file link
	*/
	public function docket_pdf($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			if($docketNumber>0){
				$getLeadID = DataController::getLeadID($docketNumber);
				if($getLeadID>0){
					$getPatentList = DataController::getPatentList($getLeadID);
					if(count($getPatentList)>0){
						$patents = array();
						foreach($getPatentList as $p){
							array_push($patents, $p->patent_number);
						}
						$patentImplode = str_repeat ('?, ',  count ($patents) - 1) . '?';
						$pdfData = array();
						$queryPdf = "SELECT file_url,patent_id FROM due_dilligence_pdf WHERE patent_id IN ($patentImplode)";
						$pdfStmt = $this->db->prepare($queryPdf);
						$pdfStmt->execute($patents);
						if($pdfStmt->rowCount()>0){
							while($rowData = $pdfStmt->fetch()){
								$fileUrl = DataController::fileReplaceToView($rowData->file_url);
								if($fileUrl != "") {
									$fileUrl .="#toolbar=0";
								}
								array_push($pdfData, array('file'=>$fileUrl,'patent_number'=>$rowData->patent_id));
							}
							for($i=0;$i<count($pdfData);$i++) {
								foreach($getPatentList as $patent){
									if($pdfData[$i]['patent_number'] == $patent->patent_number){
										$pdfData[$i]['id'] = $patent->id;
										break;
									}
								}
							}							
							$returnData = array('status'=>200,'message'=>'','data'=>$pdfData);
						} else {
							$returnData = array('status'=>200,'message'=>'No record found');
						}
					} else {
						$returnData = array('status'=>200,'message'=>'No record found');
					}
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Invalid docket','error_code'=>300);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>200,'message'=>'Internal server error','error_code'=>100);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	
	/*
		Docket Validity
		param: patent number
	*/
	
	public function docket_validity($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			$patentNumber = $req->getAttribute('value');
			if($docketNumber>0 && trim($patentNumber)!=""){
				$sqlValidity ="SELECT expired_status,legal_text,legal_status,maintainence_text,legal_source,legal_source_drive,legal_source1,legal_source1_drive,term_adjustment_days,term_adjustment_source_drive,term_adjustment_source,terminal_status,terminal_text,terminal_date,terminal_source,terminal_source_drive,claim_source,claim_status,ipr_status,ip_text,ip_complete,ipr_date,ipr_by,ipr_complete_date,ipr_source,ipr_source_drive,reexam_status,reexam_text,reexam_complete,reexam_date,reexam_by,reexam_source,reexam_source_drive,reexam_complete_date,litigation_status,litigation_text,litigation_defandants,litigation_source,litigation_source_drive,chain_status,chain_text,chain_longer,chain_source,chain_source_drive,correction_sec_source,reexam_sec_source,sup_sec_source,ptab_sec_source FROM due_dilligence_legal WHERE patent_id=?";
				$validityStmt = $this->db->prepare($sqlValidity);
				$validityStmt->execute([$patentNumber]);
				$validityData = array();
				if($validityStmt->rowCount()>0){
					$getExpertProfile = DataController::findExpertProfileData($docketNumber);
					$row = $validityStmt->fetch();
					$row->expert_data = $getExpertProfile;
					$row->legal_status_class = "";
					if($row->expired_status=="1") {
						$row->expired_status = "Yes";
						$row->legal_status_class = "redFa";
					} else if($row->expired_status=="0") {
						$row->expired_status = "No";
					}
					$row->ptab_files = DataController::getPtabFiles($patentNumber);
					$row->ptab_files_show = false;
					if(count($row->ptab_files) > 0) {
						$row->ptab_files_show = true;
					}
					$row->files_wrapper = DataController::getTerminalFiles($patentNumber);
					$row->files_wrapper_show = false;
					if(count($row->files_wrapper) > 0) {
						$row->files_wrapper_show = true;
					}
					$row->legal_status = DataController::formatDate($row->legal_status);
					$row->legal_source = DataController::returnFile($row->legal_source,$row->legal_source_drive);
					$row->legal_source1 = DataController::returnFile($row->legal_source1,$row->legal_source1_drive);
					$row->legal_source_1 = false;
					$row->legal_source_0 = false;
					if($row->legal_source1 != "") {
						$row->legal_source_1 = true;
					}
					if($row->legal_source != "") {
						$row->legal_source_0 = true;
					}
					
					$row->terminal_desc_class = "";
					if($row->terminal_status=="1") {
						$row->terminal_status = "Yes";
						$row->terminal_desc_class = "redFa";
					} else if($row->terminal_status=="0") {
						$row->terminal_status = "No";
					}
					$row->claim_status_class = "";
					if($row->claim_status=="1") {
						$row->claim_status = "Yes";
						$row->claim_status_class = "redFa";
					} else if($row->claim_status=="0") {
						$row->claim_status = "No";
					}
					$row->claim_class = "";
					if($row->chain_status == "1") {
						$row->claim_class = "redFa";
						$row->chain_status = "Broken";
					} else {
						$row->chain_status = "Complete";
					}
					$row->terminal_date = DataController::formatDate($row->terminal_date);
					$row->terminal_source = DataController::returnFile($row->terminal_source,$row->terminal_source_drive);
					$row->terminal_source_0 = false;
					if($row->terminal_source != "") {
						$row->terminal_source_0 = true;
					}
					$row->claim_source_show = false;
					if($row->claim_source != "") {
						$row->claim_source_show = true;
					}
					$row->ipr_class = "";
					if($row->ipr_status=="1") {
						$row->ipr_status = "Yes";
						$row->ipr_class = "redFa";
					} else if($row->ipr_status=="0") {
						$row->ipr_status = "No";
					}
					$row->ipr_date = DataController::formatDate($row->ipr_date);
					$row->ipr_complete_date = DataController::formatDate($row->ipr_complete_date);
					$row->ipr_source = DataController::returnFile($row->ipr_source,$row->ipr_source_drive);
					$row->ipr_source_0 = false;
					if($row->ipr_source != "") {
						$row->ipr_source_0 = true;
					}
					
					$row->reexam_class = "";
					if($row->reexam_status=="1") {
						$row->reexam_status = "Yes";
						$row->reexam_class = "redFa";
					} else if($row->reexam_status=="0") {
						$row->reexam_status = "No";
					}
					$row->reexam_date = DataController::formatDate($row->reexam_date);
					$row->reexam_complete_date = DataController::formatDate($row->reexam_complete_date);
					$row->reexam_source = DataController::returnFile($row->reexam_source,$row->reexam_source_drive);
					$row->reexam_source_0 = false;
					if($row->reexam_source != "") {
						$row->reexam_source_0 = true;
					}
					
					$row->litigation_class = "";
					if($row->litigation_status=="1") {
						$row->litigation_status = "Yes";
						$row->litigation_class = "redFa";
					} else if($row->litigation_status=="0") {
						$row->litigation_status = "No";
					}
					$row->litigation_source = DataController::returnFile($row->litigation_source,$row->litigation_source_drive);
					$row->litigation_source_0 = false;
					if($row->litigation_source != "") {
						$row->litigation_source_0 = true;
					}
					if($row->term_adjustment_days !="") {
						$row->term_adjustment_days = "<u>+".$row->term_adjustment_days."</u>";
					} else {
						$row->term_adjustment_days = "<u>+0</u>";
					}
					$row->term_adjustment_source = DataController::returnFile($row->term_adjustment_source,$row->term_adjustment_source_drive);
					$row->term_adjustment_source_drive_show = false;
					if($row->term_adjustment_source != "") {
						$row->term_adjustment_source_drive_show = true;
					}
					
					$row->chain_class = "";
					if($row->chain_longer=="1") {
						$row->chain_longer = "Yes";
						$row->chain_class = "redFa";
					} else if($row->chain_longer=="0") {
						$row->chain_longer = "No";
					}
					$row->chain_source = DataController::returnFile($row->chain_source,$row->chain_source_drive);
					$row->chain_source_0 = false;
					if($row->chain_source != "") {
						$row->chain_source_0 = true;
					}
					$row->correction_sec_source_show = false;
					$row->reexam_sec_source_show = false;
					$row->sup_sec_source_show = false;
					$row->ptab_sec_source_show = false;
					
					if($row->correction_sec_source != "") {
						$row->correction_sec_source_show = true;
					}
					if($row->reexam_sec_source != "") {
						$row->reexam_sec_source_show = true;
					}
					if($row->sup_sec_source != "") {
						$row->sup_sec_source_show = true;
					}
					if($row->ptab_sec_source != "") {
						$row->ptab_sec_source_show = true;
					}
					$validityData = $row;
				}
				$returnData = array('status'=>200,'data'=>$validityData);
			} else {
				$returnData = array('status'=>200,'message'=>'Invalid docket','error_code'=>300);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>500);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	private function findExpertProfileData($docketNumber) {
		$data = array('profile_link'=>'','name'=>'');
		$getLeadID = DataController::getLeadID($docketNumber);
		if($getLeadID > 0) {
			$sqlExpertEmail = "SELECT c.email,c.secondary_email FROM lead_open_project as op INNER JOIN contacts as c ON c.id = op.contact_id WHERE op.lead_id=? AND op.type = 3 AND op.contact_id > 0 ORDER BY op.id DESC limit 1";
			$expertEmailStmt = $this->db->prepare($sqlExpertEmail);
			$expertEmailStmt->execute([$getLeadID]);
			if($expertEmailStmt->rowCount()>0){
				$rowData = $expertEmailStmt->fetch();
				$sqlExpertProfile = "SELECT id,name FROM ep7gx_expert WHERE ";
				$emailArray = array();
				if($rowData->email != "") {
					$sqlExpertProfile .= "email=?";
					array_push($emailArray,$rowData->email);
				}
				if($rowData->secondary_email != "") {
					$sqlExpertProfile .= " OR email=?";
					array_push($emailArray,$rowData->secondary_email);
				}
				if(count($emailArray) > 0) {
					$expertProfileStmt = $this->db1->prepare($sqlExpertProfile);
					$expertProfileStmt->execute($emailArray);
					if($expertProfileStmt->rowCount()>0){
						$row = $expertProfileStmt->fetch();
						$display = openssl_encrypt($row->id,"AES-128-ECB",$key = $this->get('settings')['sy-password']);
						$data = array('profile_link'=>$display ,'name'=>$row->name);
					}
				}
			}
		}
		return $data;
	}
	
	private function getPtabFiles($patentNumber) {
		$queryPtab = "SELECT file FROM due_legal_dd_ptab as d WHERE d.patent_id =?";
		$ptabStmt = $this->db->prepare($queryPtab);
		$ptabStmt->execute([$patentNumber]);
		$files = array();
		if($ptabStmt->rowCount()>0){
			while($rowData = $ptabStmt->fetch()){
				array_push($files,$rowData);
			}
		}
		return $files;
	}
	
	private function getTerminalFiles($patentNumber) {
		$queryTerminal = "SELECT file FROM due_legal_dd_terminal_disclaimer as d WHERE d.patent_id =?";
		$terminalStmt = $this->db->prepare($queryTerminal);
		$terminalStmt->execute([$patentNumber]);
		$files = array();
		if($terminalStmt->rowCount()>0){
			while($rowData = $terminalStmt->fetch()){
				array_push($files,$rowData);
			}
		}
		return $files;
	}
	
	/*
		Docket companies
		return list of companies
	*/
	
	public function docket_companies($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			if($docketNumber>0){
				$getLeadID = DataController::getLeadID($docketNumber);
				if($getLeadID>0){
					$queryInvitees = "SELECT c.company_name as company FROM backyard_invitees as b INNER JOIN company as c ON c.id = b.contact_id WHERE lead_id =?  AND c.id<>? ORDER BY company ASC";
					$inviteesStmt = $this->db->prepare($queryInvitees);
					$inviteesStmt->execute([$getLeadID, 1]);
					$companiesList = array();
					if($inviteesStmt->rowCount()>0){
						while($rowData = $inviteesStmt->fetch()){
							array_push($companiesList,$rowData->company);
						}
						$returnData = array('status'=>200,'message'=>'','data'=>$companiesList);
					}else {
						$returnData = array('status'=>200,'message'=>'No record found');
					}
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Invalid docket','error_code'=>300);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>200,'message'=>'Internal server error','error_code'=>100);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/*
		Docket patents
		return list of patents
	*/
	
	public function docket_patents($app,$req,$resp,$args = []){
		$returnData = array('status'=>500,'message'=>'','data'=>'');
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		/*Get docketNumber*/
		try{
			$docketNumber = $req->getAttribute('docket_number');
			if($docketNumber>0){
				$getLeadID = DataController::getLeadID($docketNumber);
				if($getLeadID>0){
					$patentList = DataController::getPatentList($getLeadID);
					for($i=0;$i<count($patentList);$i++) {
						$expired = false;
						if(strpos(strtolower($patentList[$i]->patent_number),'expired') ===true) {
							$expired = true;;
						}
						$patentList[$i]->isExpired = $expired;
					}
					$message = "";
					if(count($patentList)==0){
						$message = "No record found";
					}
					$returnData = array('status'=>200,'message'=>$message,'data'=>$patentList);
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
				}
			} else {
				$returnData = array('status'=>200,'message'=>'Invalid docket','error_code'=>300);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>200,'message'=>'Internal server error','error_code'=>100);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	*	Categories
	*	return list of child categories
	*/
	public function categories($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		$showD = false;
		if($auth != null && $auth!= ""){
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							if((int)$getUserInfo->membership > 0){
								$showD = true;
							}
						}
					}
				} catch(Exception $e){
					
				}
			}
		}
		if($showD === true){
			try{
				$list = DataController::getCategoryList($parentCategoryID);
				$returnData = array('status'=>200,'message'=>'','data'=>$list);
			}catch(Exception $e){
				$this->logger->addInfo($e->getMessage());
				$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>500);
			}
		} else {
			$returnData = array('status'=>200,'message'=>'Accessible for member only.','error_code'=>1001);
		}	
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	private function getCategoryList($parentCategoryID){
		$queryChildCategory = "SELECT name FROM category WHERE parent=? ORDER BY name ASC";
		$categoryStmt = $this->db->prepare($queryChildCategory);
		$categoryStmt->execute([$parentCategoryID]);
		$list = array();
		if($categoryStmt->rowCount()>0){
			while($row = $categoryStmt->fetch()){
				array_push($list,$row);
			}
		}
		return $list;
	}
	
	/**
	*	main_categories
	*	return list of main categories
	*/
	public function main_categories($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		try{
			$queryChildCategory = "SELECT distinct(c.id) as id, c.name FROM category as c INNER JOIN map_sectors_departments as sc ON sc.category_id= c.id WHERE sc.sector_id=? ORDER BY c.id ASC";
			$categoryStmt = $this->db->prepare($queryChildCategory);
			$categoryStmt->execute([21]);
			if($categoryStmt->rowCount()>0){
				$list = array();
				while($row = $categoryStmt->fetch()){
					array_push($list,$row);
				}
				$returnData = array('status'=>200,'message'=>'','data'=>$list);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>500);
		}		
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Customer Login
	* Two parameter email and password and return valid token in which it contains customer information
	*/
	public function login($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$postData = $req->getParsedBody();
			if(isset($postData['email']) && isset($postData['password'])){
				if(trim($postData['email'])!="" && trim($postData['password'])!=""){
					$checkUser = DataController::checkCustomerLogin($postData['email'],$postData['password']);
					if(count($checkUser)>0){
						if((int)$checkUser->status==1){
							$returnData['message'] = "Please make sure the email address and password you provided relate to an activated account. If you have not yet received an activation email you may either contact SynPat customer relations by phone or at customers@synpat.com.";
						} else if((int)$checkUser->status==0){
							/*	Authenticated
								Generate Token
							*/
							$payload = array(
								"iss"     => "https://synpat.com/shop",
								"iat"     => time(),
								"exp"     => time() + (14400 * 24 * 15),
								"context" => [
									"user" => [
										"user_login" => $checkUser->email,
										"user_id"    => $checkUser->id,
										"user_data"  => $checkUser,
										"crm_alias"  => 'docket-api',
										"type"       => 'Customer'
									]
								]
							);	
							$key = $this->get('settings')['docket-key'];
							$jwt = JWT::encode($payload, $key);
							/**/
							DataController::deleteToken($checkUser->id);
							$insertID = DataController::insertData('docket_tokens',array('user_id'=>$checkUser->id,'token'=>$jwt,'date_created'=>$payload['iat'],'date_expiration'=>$payload['exp']));
							if($insertID>0){
								$returnData['status'] = 200;
								$returnData['data'] = ["token" => $jwt];
								$returnData['message'] = "Authenticated!";
							} else {
								$returnData['status'] = 500;
								$returnData['error_code'] = "100";
								$returnData['message'] = "Internal server error";
							}
						} else {
							$returnData['message']='You account is suspended. Please wait.';
						}
					} else {
						$returnData['message']="Invalid email and password";
					}
				} else {
					$returnData['message']="Invalid email and password";
				}
			} else {
				$returnData['message']="Invalid email and password";
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Customer forgot password
	* One parameter email and return message
	*/
	public function forgot_password($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			$checkAuthorization = true;
			if($checkAuthorization===true){
				$postData = $req->getParsedBody();
				if(isset($postData['email']) && trim($postData['email'])!=""){
					$checkUser = DataController::checkCustomerByEmail($postData['email']);
					if(count($checkUser)>0){
						if((int)$checkUser->status==0){ 
							$activation_code = md5($checkUser->email."@@".mt_rand(15,80));
							$updateActivationCode = DataController::updateData('customers',array('id'=>$checkUser->id),array('activation_code'=>$activation_code));
							if($updateActivationCode > 0) {
								/*Send Email Link*/
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
								$headers .= 'From: SynPat <no-reply@synpat.com>';
								$message = "Dear ".$checkUser->first_name." ".$checkUser->last_name.", <br/><br/>We received a request to reset the password associated with your account with SynPat. To reset, please <a href='https://synpat.com/forget-password/?activation=".$activation_code."'>click here</a>. <br/><br/>SynPat takes your account security very seriously. If you did not request a password reset, please report this e-mail to SynPat for investigation.<br/><br/> Hope to see you soon. <br/>SynPat.com<br/><br/><br/>";
								//mail( $checkUser->email, 'Reset your password', $message, $headers );
								require_once('/var/www/synpat/backyard/application/libraries/PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php');
								/*Send Email Link*/
								$mail = new PHPMailer;
								$mail->isSMTP();   
								$mail->Host = 'smtp.gmail.com';  
								$mail->SMTPAuth = true;   
								$mail->SMTPSecure = 'ssl';  
								$mail->Port = 465;   
								$mail->isHTML(true);   
								$mail->Username = 'synpat@synpat.com';  
								$mail->Password = 'synpat@_12341234'; 	
								$mail->From = 'no-reply@synpat.com';
								$mail->FromName = 'SynPat - Patent Rights';	
								$mail->Subject = 'Reset your password';
								$mail->Body = $message;
								$mail->addAddress($checkUser->email,$checkUser->email);
								if($mail->send()) {	
									$returnData['message']='We have send an email to reset your password.';
								} else {
									$returnData['message']='Invalid email address.';
								}
							} else {
								$returnData['message'] = "Internal server error";
							}
						} else {
							$returnData['message']='Invalid email.';
						}
					} else {
						$returnData['message']="Invalid email.";
					}					
				} else {
					$returnData['message']="Invalid email.";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}	
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Check Captcha
	*/
	public function check_captcha($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'validate'=>false);
		try{
			$postData = $req->getParsedBody();
			$returnData['validate'] = DataController::googleCaptcha($postData['captcha']);			
		}catch(Exception $e){
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Check Availability
	* receive user login parameter or new user parameter, and valid auth token and check_available_company if it is empty then customer wants to check availability for his/her company if it is not blank then customer wants strategic license against company which is in this field
	*/
	public function check_availability($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$postData = $req->getParsedBody();
		$licenseNumber = $postData['portfolio_number'];
		try{
			$checkLicense = DataController::checkLicense($licenseNumber);
			if(count($checkLicense)>0){
				/*Request from Store or Docket, if request from docket then check with email and password and if request from store then check with Authentication Token p_type=>0 from docket and p_type=>1 from store*/
				$newUser = 0;
				$send = 0;
				$userData = array();
				if($postData['p_type'] == 0){
					if($postData['user']['email_address']!="" && $postData['user']['password']!=""){
						$checkUser = DataController::checkCustomerLogin($postData['user']['email_address'],$postData['user']['password']);
						if(count($checkUser)>0){
							if($checkUser->status==0){
								$userData = $checkUser;
							}
						}
					} else {
						$insertUser = DataController::insertCustomerRequest($postData['register'],0);
						if(isset($insertUser['id']) && $insertUser['id']>0){
							$name = explode(" ",$postData['register']['person_name']);
							$lastName = str_replace($name[0],"",$postData['register']['person_name']);
							$userData = (object)array('id'=>$insertUser['id'],'email'=>$postData['register']['person_email'],'first_name'=>$name[0],'last_name'=>trim($lastName),'company_name'=>$postData['register']['company_name'],'phone_number'=>$postData['register']['person_phone']);
							$newUser = 1;
							$activation_code = md5($userData->email."@@".time()."@@".$userData->id);
							$updateActivationCode = DataController::updateData('customer_request',array('id'=>$userData->id),array('activation_code'=>$activation_code));
							if($updateActivationCode > 0) {
								/*Send Email Link*/
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
								$headers .= 'From: SynPat <no-reply@synpat.com>';
								$message = "Dear ".$userData->first_name." ".$userData->last_name.", <br/><br/>We received your request for an inventory check. Please expect an answer within one business day from your confirmation.<br/> To confirm, please <a href='https://synpat.com/verify_email/?activation=".$activation_code."'>click here</a>. <br/><br/>If you did not request an inventory check, please ignore this message.<br/><br/> Hope to see you soon. <br/>SynPat.com<br/><br/><br/>";
								require_once('/var/www/synpat/backyard/application/libraries/PHPMailer-master/PHPMailer-master/PHPMailerAutoload.php');
								/*Send Email Link*/
								$mail = new PHPMailer;
								$mail->isSMTP();   
								$mail->Host = 'smtp.gmail.com';  
								$mail->SMTPAuth = true;   
								$mail->SMTPSecure = 'ssl';  
								$mail->Port = 465;   
								$mail->isHTML(true);   
								$mail->Username = 'synpat@synpat.com';  
								$mail->Password = 'synpat@_12341234'; 	
								$mail->From = 'no-reply@synpat.com';
								$mail->FromName = 'SynPat - Patent Rights';	
								$mail->Subject = 'Verify your email';
								$mail->Body = $message;
								$mail->addAddress($userData->email,$userData->email);
								if($mail->send()) {
									$send = 1;
								} else {
									
								}
							}
						} else {
							$returnData['message'] = $insertUser['message'];
						}
					}					
				} else if($postData['p_type'] == 1){
					$headers = $req->getHeaders();
					$auth = $headers['HTTP_AUTHORIZATION'];
					$checkAuthorization = false;
					if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
						$checkAuthorization = DataController::checkToken($auth[0]);
					}
					if($checkAuthorization===true){
						$key = $this->get('settings')['docket-key'];
						$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
						try{
							if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
								if($decodeToken->context->user->type=="Customer"){
									$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
								} else {
									$returnData['status'] = 200;
									$returnData['error_code'] = "101";
									$returnData['message'] = "Token Invalid";
								}								
							}
						}catch(\Exception $e){						
							$this->logger->addInfo($e->getMessage());
							$returnData['status'] = 200;
							$returnData['error_code'] = "102";
							$returnData['message'] = "Token Expired";
						}
					}					
				}
				if(count($userData)>0){
					if(!empty($postData['check_available_company'])){
						$postData['check_availability_request_for'] = 3;
					} else {
						$postData['check_availability_request_for'] = 2;
					}
					$name = $userData->first_name." ".$userData->last_name;
					$customerID = 0;
					if($newUser == 0){
						$customerID = $userData->id;
					}
					$insertCheckRequest = DataController::insertData('request_for_check_availabilty',array('license_id'=>$checkLicense->id,'company_name'=>$userData->company_name,'person_name'=>$name,'person_phone'=>$userData->phone_number,'person_email'=>$userData->email,'create_date'=>date('Y-m-d H:i:s'),'customer_id'=>$customerID,'check_for'=>$postData['check_available_company'],'type'=>$postData['check_availability_request_for']));
					if($insertCheckRequest>0){
						/*Send notification*/
						DataController::sendNotificationToUser(array('action'=>'new_pos','id'=>0,'d_d'=>'Refresh POS','type'=>0));
						if($newUser==1){
							$queryUpdate= "UPDATE customer_request SET request_id=?,type=? WHERE id=?";
							$requestStmt = $this->db->prepare($queryUpdate);
							$requestStmt->execute([$insertCheckRequest,2,$userData->id]);
						}
						$message = "Thank you, please expect an answer within 1 business day.";
						if($newUser==1 && $send == 1){
							$message = "Thank you for your request. Please check your email and activate your request. Upon activation, expect an answer to your inventory check within one business day.";
						}else if($newUser==1 && $send == 0){
							$message = "We are not able to send email, Please check your email address.";
						}
						$returnData['message'] = $message;
					} else {
						$returnData['status'] = 500;
						$returnData['error_code'] = "100";
						$returnData['message'] = "Internal server error";
					}
				} else {
					$returnData['status'] = 200;
					$returnData['error_code'] = "101";
					$returnData['message'] = "Invalid user details";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "102";
				$returnData['message'] = "Invalid docket";
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/*
	* Download Agreement File
	*/
	public function download_file($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$postData = $req->getParsedBody();
			$licenseNumber = $postData['portfolio_number'];
			$checkLicense = DataController::checkLicense($licenseNumber);
			if(count($checkLicense)>0){
				/*Request from Store or Docket, if request from docket then check with email and password and if request from store then check with Authentication Token p_type=>0 from docket and p_type=>1 from store*/
				$userData = array();
				if($postData['p_type'] == 0){
					if($postData['user']['email_address']!="" && $postData['user']['password']!=""){
						$checkUser = DataController::checkCustomerLogin($postData['user']['email_address'],$postData['user']['password']);
						if(count($checkUser)>0){
							if($checkUser->status==0){
								$userData = $checkUser;
							}
						}
					}					
				} else if($postData['p_type'] == 1){
					$headers = $req->getHeaders();
					$auth = $headers['HTTP_AUTHORIZATION'];
					$checkAuthorization = false;
					if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
						$checkAuthorization = DataController::checkToken($auth[0]);
					}
					if($checkAuthorization===true){
						$key = $this->get('settings')['docket-key'];
						$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
						try{
							if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
								$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
							}
						}catch(\Exception $e){						
							$this->logger->addInfo($e->getMessage());
							$returnData['status'] = 200;
							$returnData['error_code'] = "102";
							$returnData['message'] = "Token Expired";
						}
					}					
				}
				if(count($userData)>0){
					$queryCheckDownload = "SELECT file FROM pos_agreements WHERE customer_id IN (SELECT id FROM customers WHERE company_id=?) AND type=1 AND file_type=? AND lead_id=(SELECT id FROM litigations WHERE serial_number=?) ORDER BY id ASC LIMIT 1";
					$downloadStmt = $this->db->prepare($queryCheckDownload);
					$downloadStmt->execute([$userData->company_id,$postData['rf_type'],$licenseNumber]);
					if($downloadStmt->rowCount()>0){
						$getDownloadResult = $downloadStmt->fetch();
						$fileDownload = $getDownloadResult->file;
						if(!empty($fileDownload)){
							$fileDownload = str_replace('/edit?usp=drivesdk','&exportFormat=pdf',$fileDownload);
							$fileDownload = str_replace('/view?usp=drivesdk','&exportFormat=pdf',$fileDownload);
							$fileDownload = str_replace('/edit','&exportFormat=pdf',$fileDownload);
							$fileDownload = str_replace('/view','&exportFormat=pdf',$fileDownload);
							$fileDownload = str_replace('https://docs.google.com/document/d/','https://docs.google.com/feeds/download/documents/export/Export?id=',$fileDownload);
							$fileDownload = str_replace('https://drive.google.com/file/d/','https://docs.google.com/feeds/download/documents/export/Export?id=',$fileDownload);
							$returnData['data']['file'] = $fileDownload;
						} else {
							$returnData['status'] = 200;
							$returnData['message'] = "No file for download.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['message'] = "No file for download.";
					}
				} else {
					$returnData['status'] = 200;
					$returnData['error_code'] = "101";
					$returnData['message'] = "Invalid user details";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "102";
				$returnData['message'] = "Invalid docket";
			}
		}catch(Exception $e){
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Send Message to SynPat
	* post parameter with email, password, message, file id. If user is in the customer request table then we will check email and password from customer_request table and update message in draft_revised_documents table otherwise we will update in revised_documents table
	*/
	public function send_message($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$postData = $req->getParsedBody();
			$licenseNumber = $postData['portfolio_number'];
			$checkLicense = DataController::checkLicense($licenseNumber);
			if(count($checkLicense)>0){
				/*Request from Store or Docket, if request from docket then check with email and password and if request from store then check with Authentication Token p_type=>0 from docket and p_type=>1 from store*/
				$userData = array();
				$newUser = 0;
				if($postData['p_type'] == 0){
					if($postData['user']['email_address']!="" && $postData['user']['password']!=""){
						$checkUser = DataController::checkCustomerLogin($postData['user']['email_address'],$postData['user']['password']);
						if(count($checkUser)>0){
							$newUser = 1;
							if($checkUser->status==0){
								$userData = $checkUser;
							}
						}
					} else {
						$checkUserFromRequest = DataController::checkCustomerRequestLogin($postData['user']['email_address'],$postData['user']['password']);
						if(count($checkUserFromRequest)>0){
							$userData = $checkUserFromRequest;
							$newUser = 0;
						} else {
							$checkUserFromRequest = DataController::checkCustomerRequestLogin($postData['register']['person_email'],$postData['register']['password']);
							if(count($checkUserFromRequest)>0){
								$userData = $checkUserFromRequest;
								$newUser = 0;
							}								
						}
					}					
				} else if($postData['p_type'] == 1){
					$headers = $req->getHeaders();
					$auth = $headers['HTTP_AUTHORIZATION'];
					$checkAuthorization = false;
					if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
						$checkAuthorization = DataController::checkToken($auth[0]);
					}
					if($checkAuthorization===true){
						$key = $this->get('settings')['docket-key'];
						$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
						try{
							if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
								$newUser = 1;
								$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
							}
						}catch(\Exception $e){						
							$this->logger->addInfo($e->getMessage());
							$returnData['status'] = 200;
							$returnData['error_code'] = "102";
							$returnData['message'] = "Token Expired";
						}
					}					
				}				
				if(count($userData)>0){
					$tableName = "";
					if($newUser == 1){
						$tableName = "revised_documents";
					}else if($newUser == 0){
						$tableName = "draft_revised_documents";
					}
					
					if(isset($postData['file_no']) && (int)$postData['file_no']>0){
						if($newUser == 1){
							$query = "UPDATE ".$tableName." SET message=?, status=1 WHERE id=? AND customer_id IN (SELECT id FROM customers WHERE company_id=?) AND license_id=?";
						} else {
							$query = "UPDATE ".$tableName." SET message=? WHERE id=? AND customer_id =? AND license_id=?";
						}						
						$messageStmt = $this->db->prepare($query);
						try{
							if($newUser == 1){
								$messageStmt->execute([$postData['message'],(int)$postData['file_no'],$userData->company_id,$checkLicense->id]);
							} else {					
								$messageStmt->execute([$postData['message'],(int)$postData['file_no'],$userData->id,$checkLicense->id]);
							}
							DataController::sendNotificationToUser(array('action'=>'new_pos','id'=>0,'d_d'=>'Refresh POS','type'=>0));
							$returnData['status'] = 200;
							$returnData['message'] = "Message sent successfully. We will get back to you shortly.";
						}catch(Exception $e){
							$returnData['status'] = 500;
							$returnData['error_code'] = "100";
							$returnData['message'] = "Internal server error4.";
						}
						
						/*
						if($messageStmt->rowCount()>0){
							
						} else {
							
						}*/
					} else if(isset($postData['revised']['file_draft'])){
						$columnName = "";
						switch((int)$postData['p_type']){
							case 1:
								$columnName = "request_aggreement";
							break;
							case 2:
								$columnName = "license_aggreement";
							break;
							case 3:
								$columnName = "strategic_aggreement";
							break;
						}
						$query ="UPDATE  ".$tableName."  SET message=? WHERE ".$columnName." = ?";
						$messageStmt = $this->db->prepare($query);
						$messageStmt->execute([$postData['message'],$postData['file_draft']]);
						if($messageStmt->rowCount()>0){
							$returnData['status'] = 200;
							$returnData['message'] = "Message sent successfully. We will get back to you shortly.";
						} else {
							$returnData['status'] = 500;
							$returnData['error_code'] = "100";
							$returnData['message'] = "Internal server error2.";
						}
					}
				} else {
					$returnData['status'] = 500;
					$returnData['error_code'] = "105";
					$returnData['message'] = "Invalid user";
				}			
			} else {
				$returnData['status'] = 500;
				$returnData['error_code'] = "106";
				$returnData['message'] = "Invalid portfolio";
			}
		}catch(Exception $e){
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error1";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* List of Pending Documents
	*
	*/
	public function pending_list_of_documents($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$postData = $req->getParsedBody();
			$licenseNumber = $postData['portfolio_number'];
			$checkLicense = DataController::checkLicense($licenseNumber);
			$list = array();
			if(count($checkLicense)>0){
				/*Request from Store or Docket, if request from docket then check with email and password and if request from store then check with Authentication Token p_type=>0 from docket and p_type=>1 from store*/
				$userData = array();
				if($postData['p_type'] == 0){
					if($postData['user']['email_address']!="" && $postData['user']['password']!=""){
						$checkUser = DataController::checkCustomerLogin($postData['user']['email_address'],$postData['user']['password']);
						if(count($checkUser)>0){
							if($checkUser->status==0){
								$userData = $checkUser;
							}
						}
					}					
				} else if($postData['p_type'] == 1){
					$headers = $req->getHeaders();
					$auth = $headers['HTTP_AUTHORIZATION'];
					$checkAuthorization = false;
					if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
						$checkAuthorization = DataController::checkToken($auth[0]);
					}
					if($checkAuthorization===true){
						$key = $this->get('settings')['docket-key'];
						$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
						try{
							if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
								$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
							}
						}catch(\Exception $e){						
							$this->logger->addInfo($e->getMessage());
							$returnData['status'] = 200;
							$returnData['error_code'] = "102";
							$returnData['message'] = "Token Expired";
						}
					}					
				}
				if(count($userData)>0){
					$queryPendingExecutedPaymentList = "SELECT a.type as action_type,a.doc_type as license,a.id as fileNo ,target.company_name as target FROM potential_participates as a LEFT JOIN company as target ON target.id = a.company_id WHERE a.status=3 AND a.license_id=(SELECT id FROM licenses WHERE license_number=?) AND a.customer_id IN(SELECT id FROM customers WHERE company_id =?)";
					$listStmt = $this->db->prepare($queryPendingExecutedPaymentList);
					$listStmt->execute([$licenseNumber,$userData->company_id]);
					if($listStmt->rowCount()>0){
						while($row = $listStmt->fetch()){
							array_push($list,$row);
						}
					}
				} else {
					$returnData['status'] = 200;
					$returnData['error_code'] = "101";
					$returnData['message'] = "Invalid user details";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "102";
				$returnData['message'] = "Invalid docket";
			}
			$returnData['data'] = $list;
		}catch(Exception $e){
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	*	Draft Document
	* receive user login parameter or new user parameter, and valid auth token return will get draft document file url and customer message
	*/
	public function customize_document($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$postData = $req->getParsedBody();
		$licenseNumber = $postData['portfolio_number'];
		try{
			$checkLicense = DataController::checkLicense($licenseNumber);
			if(count($checkLicense)>0){
				/*Request from Store or Docket, if request from docket then check with email and password and if request from store then check with Authentication Token p_type=>0 from docket and p_type=>1 from store*/
				$newUser = 0;
				$userData = array();
				if($postData['p_type'] == 0){
					if($postData['user']['email_address']!="" && $postData['user']['password']!=""){
						$checkUser = DataController::checkCustomerLogin($postData['user']['email_address'],$postData['user']['password']);
						if(count($checkUser)>0){
							if($checkUser->status==0){
								$userData = $checkUser;
							}
						}
					} else if(isset($postData['register']) && count($postData['register']) > 0){
						$insertUser = DataController::insertCustomerRequest($postData['register'],0);
						if(isset($insertUser['id']) && $insertUser['id']>0){
							$name = explode(" ",$postData['register']['person_name']);
							$lastName = str_replace($name[0],"",$postData['register']['person_name']);
							$userData = (object)array('id'=>$insertUser['id'],'email'=>$postData['register']['person_email'],'first_name'=>$name[0],'last_name'=>trim($lastName),'company_name'=>$postData['register']['company_name'],'phone_number'=>$postData['register']['person_phone']);
							$newUser = 1;
						} else {
							$returnData['message'] = $insertUser['message'];
						}
					}					
				} else if($postData['p_type'] == 1){
					$headers = $req->getHeaders();
					$auth = $headers['HTTP_AUTHORIZATION'];
					$checkAuthorization = false;
					if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
						$checkAuthorization = DataController::checkToken($auth[0]);
					}
					if($checkAuthorization===true){
						$key = $this->get('settings')['docket-key'];
						$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
						try{
							if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
								$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
							}
						}catch(Exception $e){						
							$this->logger->addInfo($e->getMessage());
							$returnData['status'] = 200;
							$returnData['error_code'] = "102";
							$returnData['message'] = "Token Expired";
						}
					}					
				}
				
				if(count($userData)>0){
					$checkDraftFile = "";
					$columnName = "";
					switch((int)$postData['rf_type']){
						case 1:
							$columnName = "request_aggreement";
							break;
						case 2:
							$columnName = "license_aggreement";							
							break;
						case 3:
							$columnName = "strategic_aggreement";
							break;
					}
					$type = $postData['submit_type'];
					$rfType = (int)$postData['rf_type'];
					$checkData = array();
					$myMessage = "";
					$file = "";
					$fileStatus = 0;
					$draft = 0;
					if($newUser==0){
						if(!empty($columnName)){
							$queryCheck = "SELECT * FROM revised_documents WHERE customer_id IN (SELECT id FROM customers WHERE company_id=?) AND ".$columnName." <> '' AND license_id =  ? AND type=? AND rf_type=? ORDER BY id DESC LIMIT 1";
							$revisedStmt = $this->db->prepare($queryCheck);
							$revisedStmt->execute([$userData->company_id,$checkLicense->id,$type,$rfType]);
							/*$revisedStmt->execute([$userData->company_id,$checkLicense->id,$type]);*/
							if($revisedStmt->rowCount()>0){
								$checkData = $revisedStmt->fetch();
								if(!empty($checkData->{$columnName})){
									$checkDraftFile = $checkData->{$columnName};
									$myMessage =  $checkData->message;
									$fileStatus = $checkData->approved;
								}
								$draft = $checkData->id;
							}
						}
					}
					if(empty($checkDraftFile)){
						$queryColumn = "";
						$licenseName = "";
						switch($rfType){
							case 1:
								$queryColumn = "purchase_buy";
								$licenseName = "Request to Participate";
							break;
							case 2:
								$queryColumn = "purchase_license";
								$licenseName = "Patent License Agreement";
							break;
							case 3:
								$queryColumn = "strategic_license_agreement";
								$licenseName = "Enforcement Rights Agreement";
							break;
						}
						if(!empty($queryColumn)){
							$query = "SELECT li.id,l.id as leadID, l.customer_folder as folderID,".$queryColumn." FROM licenses as li INNER JOIN litigations as l ON l.serial_number = li.license_number WHERE li.license_number=?";
							$documentStmt = $this->db->prepare($query);
							$documentStmt->execute([$licenseNumber]);
							if($documentStmt->rowCount()>0){
								$licenseResult = $documentStmt->fetch();
								$title = $licenseNumber." - ".$licenseName;
								$fileDraft = DataController::createDraftFile($licenseResult->folderID,$licenseResult->{$queryColumn},"SynPat - ".$userData->company_name,$title);
								$checkResponse = preg_replace('/\\\\\"/',"\"", $fileDraft);
								$checkResponse = json_decode($checkResponse);
								if(isset($checkResponse->file) && $checkResponse->success>0){
									if(!empty($checkResponse->file)){
										$name = $userData->first_name ." ".$userData->last_name;
										if(array_key_exists('message',$postData) && $postData['message'] != ""){
											$myMessage = $postData['message'];
										}
										$fType = $postData['rf_type'];
										$licenseAgreementFile = "";
										$strategicAgreementFile = "";
										$requestAgreementFile = "";
										if($fType==2){
											$licenseAgreementFile = $checkResponse->file;
										} else if($fType==3){
											$strategicAgreementFile = $checkResponse->file;
										} else if($fType==1){
											$requestAgreementFile = $checkResponse->file;
										}
										$update = false;
										if(count($checkData)>0){
											$update = true;
										}
										$fileName = $checkResponse->file_name;
										$tablename = "draft_revised_documents";
										if($newUser==0){
											$tablename = "revised_documents";
										}
										if($update === false){
											$insertData = DataController::insertData($tablename, array('license_id'=>$checkLicense->id,'message'=>'','license_aggreement'=>$licenseAgreementFile,'strategic_aggreement'=>$strategicAgreementFile,'request_aggreement'=>$requestAgreementFile,'customer_id'=>$userData->id,'type'=>$type,'rf_type'=>$fType,'create_date'=>date('Y-m-d H:i:s'),'file_name'=>$fileName));
											if($insertData>0){
												if($newUser==1){
													$query = "UPDATE customer_request SET request_id=? WHERE id=?";
													$requestStmt = $this->db->prepare($query);
													$requestStmt->execute([$insertData,$userData->id]);
													DataController::sendNotificationToUser(array('action'=>'new_pos','id'=>0,'d_d'=>'Refresh POS','type'=>0));
												}
												$draft = $insertData;
												$error = 0;
												$success = 1;
												$message = "";
												$file = $checkResponse->file;
											}
										} else {
											/*Update*/
											$queryUpdate = "";
											if($fType==2){
												$queryUpdate = "UPDATE draft_revised_documents SET license_aggreement=? WHERE id=?";
											} else if($fType==3){
												$queryUpdate = "UPDATE draft_revised_documents SET strategic_aggreement=? WHERE id=?";
											} else if($fType==1){
												$queryUpdate = "UPDATE draft_revised_documents SET request_aggreement=? WHERE id=?";
											}
											if(!empty($queryUpdate)){
												$documentRevisedStmt = $this->db->prepare($queryUpdate);
												$documentRevisedStmt->execute([$checkResponse->file,$checkData->id]);
											}
										}
									}
								}
							}
						}
					}else {
						$error = 0;
						$success = 1;
						$message = "";
						$file = $checkDraftFile;
					}
					if($file!=""){
						$returnData['data']['file'] = $file;
						$returnData['data']['file_no'] = $draft;
						$returnData['data']['customer_message'] = $myMessage;
						$returnData['data']['file_status'] = $fileStatus;
					}
				} else {
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Invalid user details";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "101";
				$returnData['message'] = "Invalid docket";
			}
		}catch(Exception $e){
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server errorwwwwww";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	/**
	* Request for Participation
	* post parameter with customer login information i.e email and password and also portfolio_number and upload_request_file and p_type =>0 if request from docket and p_type=>1 if request comes from shop
	*/
	public function request_for_participate($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$postData = $req->getParsedBody();
			$licenseNumber = $postData['portfolio_number'];
			$checkLicense = DataController::checkLicense($licenseNumber);
			$list = array();
			if(count($checkLicense)>0){
				/*Request from Store or Docket, if request from docket then check with email and password and if request from store then check with Authentication Token p_type=>0 from docket and p_type=>1 from store*/
				$userData = array();
				if($postData['p_type'] == 0){
					if($postData['user']['email_address']!="" && $postData['user']['password']!=""){
						$checkUser = DataController::checkCustomerLogin($postData['user']['email_address'],$postData['user']['password']);
						if(count($checkUser)>0){
							if($checkUser->status==0){
								$userData = $checkUser;
							}
						}
					}					
				} else if($postData['p_type'] == 1){
					$headers = $req->getHeaders();
					$auth = $headers['HTTP_AUTHORIZATION'];
					$checkAuthorization = false;
					if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
						$checkAuthorization = DataController::checkToken($auth[0]);
					}
					if($checkAuthorization===true){
						$key = $this->get('settings')['docket-key'];
						$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
						try{
							if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
								$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
							}
						}catch(\Exception $e){						
							$this->logger->addInfo($e->getMessage());
							$returnData['status'] = 200;
							$returnData['error_code'] = "102";
							$returnData['message'] = "Token Expired";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "101";
						$returnData['message'] = "Invalid Token.";
					}					
				}
				
				if(count($userData)>0){
					$fileName = "";								
					$type = 1;
					$fileObject = "";
					$uploadedFiles = $req->getUploadedFiles();
					if($postData['p_type'] == 0){
						$fileObject = $uploadedFiles['upload_request_file'];
					} else if($postData['p_type'] == 1){
						$fileObject = $uploadedFiles['upload_agreement'];
					}					
					if ($fileObject->getError() === UPLOAD_ERR_OK) {
						$uploadFileName = $fileObject->getClientFilename();
						$tmp_name = $fileObject->file;
						$allowed =  array('pdf');
						/*$name = $licenseNumber."_".$uploadFileName;*/
						$name = $uploadFileName;
						$ext = pathinfo($name, PATHINFO_EXTENSION);
						if(in_array(strtolower(strtoupper($ext)),$allowed) ) {
							$data = array('file1' => "@".$tmp_name.';filename='.$name);
							$getFolderID = DataController::getLeadFolderID($licenseNumber,"pdf_folder");
							$fileName = DataController::uploadFile($data,$getFolderID);
							if (count($fileName)>0 && isset($fileName['file1']) && !empty($fileName['file1'])) {
								try{
									$name = $userData->first_name." ".$userData->last_name;
									$insertData = DataController::insertData('request_to_participates',array('license_id'=>$checkLicense->id,'file'=>$fileName['file1'],'type'=>$type,'create_date'=>date('Y-m-d H:i:s'),'customer_id'=>$userData->id));
									if((int)$insertData>0){
										$returnData['error'] = 0;
										$returnData['success'] = 1;
										$returnData['message'] = "Thank you for sending your request. We will get back to you shortly.";
										DataController::sendNotificationToUser(array('action'=>'new_pos','id'=>0,'d_d'=>'Refresh POS','type'=>0));
									} else {
										$returnData['status'] = 500;
										$returnData['error_code'] = "100";
										$returnData['message'] = "Internal server error";
									}
								}catch(Exception $e){
									$this->logger->addInfo($e->getMessage());
									$returnData['status'] = 500;
									$returnData['error_code'] = "100";
									$returnData['message'] = "Internal server error";
								}
							} else {
								$returnData['status'] = 500;
								$returnData['error_code'] = "100";
								$returnData['message'] = "Internal server error";
							}
						} else {
							$returnData['status'] = 500;
							$returnData['error_code'] = "110";
							$returnData['message'] = "Upload only PDF file";
						}
					} else {
						$returnData['status'] = 500;
						$returnData['error_code'] = "111";
						$returnData['message'] = "File is corrupted";
					}
				} else {
					$returnData['status'] = 500;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Invalid user details";
				}
			} else {
				$returnData['status'] = 500;
				$returnData['error_code'] = "102";
				$returnData['message'] = "Invalid portfolio number";
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	/**
	* Proof of Payment or Signed Agreement
	* customer login parameters, request_for i.e request for which ID in potential table, drp_upload_agreements=>2,3,4 for non-exclusive license or strategic license or proof of payments
	*/
	
	public function uploadAgreementOrProofOfPayment($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$s = 0;
			$postData = $req->getParsedBody();
			$licenseNumber = $postData['portfolio_number'];
			$checkLicense = DataController::checkLicense($licenseNumber);
			if(count($checkLicense)>0){
				/*Request from Store or Docket, if request from docket then check with email and password and if request from store then check with Authentication Token p_type=>0 from docket and p_type=>1 from store*/
				$userData = array();
				if($postData['p_type'] == 0){
					if($postData['user']['email_address']!="" && $postData['user']['password']!=""){
						$checkUser = DataController::checkCustomerLogin($postData['user']['email_address'],$postData['user']['password']);
						if(count($checkUser)>0){
							if($checkUser->status==0){
								$userData = $checkUser;
							}
						}
					}					
				} else if($postData['p_type'] == 1){					
					$headers = $req->getHeaders();
					$auth = $headers['HTTP_AUTHORIZATION'];
					$checkAuthorization = false;
					if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
						$checkAuthorization = DataController::checkToken($auth[0]);
					}
					
					if($checkAuthorization===true){						
						$key = $this->get('settings')['docket-key'];
						$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
						try{							
							if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){								
								$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
							}
						}catch ( \Firebase\JWT\ExpiredException $e ) {
							$this->logger->addInfo($e->getMessage());
							$returnData['status'] = 200;
							$returnData['error_code'] = "103";
							$returnData['message'] = "Token Expired";
						}catch(\Exception $e){
							$this->logger->addInfo($e->getMessage());
							$returnData['status'] = 200;
							$returnData['error_code'] = "103";
							$returnData['message'] = "Token Expired";
						}
					}					
				}
				if(count($userData)>0){
					$s = 1;
					/*check files*/
					$uploadedFiles = $req->getUploadedFiles();
					$uploadedFile = $uploadedFiles['upload_agreement'];
					if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
						$uploadFileName = $uploadedFile->getClientFilename();
						$tmp_name = $uploadedFile->file;
						$allowed =  array('pdf');
						$name = $licenseNumber."_".$uploadFileName;
						$ext = pathinfo($name, PATHINFO_EXTENSION);
						if(in_array(strtolower(strtoupper($ext)),$allowed) ) {
							$data = array('file1' => "@".$tmp_name.';filename='.$name);
							$getFolderID = DataController::getLeadFolderID($licenseNumber,"pdf_folder");
							$fileName = DataController::uploadFile($data,$getFolderID);
							if (count($fileName)>0 && isset($fileName['file1']) && !empty($fileName['file1'])) {
								try{
									$cusID = $userData->id;
									$companyID = $userData->company_id;
									if($cusID>0 && $companyID>0){
										if((int)$postData['page_no']>0){
											$checkPotentialData = DataController::checkPotentialData($checkLicense->id,$companyID,$postData['page_no']);
											if(count($checkPotentialData)>0){
												$fileUpload = $postData['upload_type'];
												$filed = "";
												if($fileUpload==2 || $fileUpload==3){
													$filed = "execute_agreement=?";
												}else if($fileUpload==4){
													$filed = "proof_of_payment=?";
												}
												if($filed!=""){
													$updateQuery = "UPDATE potential_participates SET ".$filed." ,upload_date=? WHERE id=? AND customer_id=? AND license_id=?";
													$potentialStmt = $this->db->prepare($updateQuery);
													$potentialStmt->execute([$fileName['file1'],date('Y-m-d H:i:s'),$checkPotentialData->id,$cusID,$checkLicense->id]);
													if($potentialStmt->rowCount()>0){
														$returnData['message'] = "Your file submitted successfully, We will contact you shortly.";
														DataController::sendNotificationToUser(array('action'=>'new_pos','id'=>0,'d_d'=>'Refresh POS','type'=>0));
													} else {
														$returnData['status'] = 200;
														$returnData['error_code'] = "100";
														$returnData['message'] = "Internal server error";
													}
												} else {
													$returnData['status'] = 200;
													$returnData['error_code'] = "109";
													$returnData['message'] = "Invalid input data";
												}
											} else {
												$returnData['status'] = 200;
												$returnData['error_code'] = "109";
												$returnData['message'] = "Invalid input data";
											}
										} else {
											$returnData['status'] = 200;
											$returnData['error_code'] = "109";
											$returnData['message'] = "Invalid input data";
										}
									} else {
										$returnData['status'] = 200;
										$returnData['error_code'] = "109";
										$returnData['message'] = "Invalid user";
									}
								}catch(Exception $e){
									$returnData['status'] = 200;
									$returnData['error_code'] = "100";
									$returnData['message'] = "Internal server error";
								}
							} else {
								$returnData['status'] = 200;
								$returnData['error_code'] = "100";
								$returnData['message'] = "Internal server error";
							}
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "115";
							$returnData['message'] = "Upload only PDF file.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "114";
						$returnData['message'] = "File is corrupted.";
					}
				} else {
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Invalid user.";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "102";
				$returnData['message'] = "Invalid portfolio number.";
			}
		}catch ( \Firebase\JWT\ExpiredException $e ) {
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 200;
			$returnData['error_code'] = "103";
			$returnData['message'] = "Token Expired";
		}catch(Exception $e){
			$returnData['status'] = 200;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Find User Whishlist
	*/
	public function user_wishlist($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$errorPersonalInfo = "";
		$successPersonalInfo = "";
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0 && isset($decodeToken->context->user->type) && $decodeToken->context->user->type == "Customer"){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							$queryWhishlist = 'SELECT w.portfolio_id FROM wishlist as w WHERE w.customer_id IN (SELECT id FROM customers WHERE company_id = ?) ORDER BY w.id ASC';
							$whishlistStmt = $this->db->prepare($queryWhishlist);
							$whishlistStmt->execute([$getUserInfo->company_id]);
							if($whishlistStmt->rowCount()>0){
								$list = array();
								while($row = $whishlistStmt->fetch()){
									array_push($list,$row->portfolio_id);
								}
								$portfoliosID = str_repeat ('?, ',  count ($list) - 1) . '?';
								$queryPortfolio = "SELECT a.id,a.store_name,a.option_expiration_data,a.seller_asking_price,a.category,c.name as categoryName,a.active_button,a.potential_participants,a.final_participants,a.regular_license_starts,a.late_license_starts,a.store,a.cost_price,li.file_left,li.file_middle,li.file_right,li.file_four,li.file_five,li.file_six,li.file_seven,li.file_eight,li.file_nine,li.file_ten,li.file_eleven,li.file_twelve,li.file_thirteen,li.file_fourteen,li.file_fiveteen,li.file_sixteen,li.file_seventeen,li.file_eighteen,li.file_nineteen,li.file_twenty,li.file_twentyone,li.file_twentytwo,li.file_twentythree,li.file_twentyfour,li.file_twentyfive,li.file_twentysix,li.file_twentyseven,li.file_twentyeight,li.file_twentynine,li.file_thirty,li.file_thirtyone,li.file_thirtytwo,l.id as lead_id,l.lead_name,l.serial_number,c.name as categoryName,li.id as licenseID FROM acquisition as a LEFT JOIN litigations as l ON l.id=a.lead_id LEFT JOIN licenses as li ON l.serial_number=li.serial_number LEFT JOIN category as c ON c.id=a.category  WHERE li.id IN ($portfoliosID) AND l.status IN ('0','1','2')";
								$portfolioStmt = $this->db->prepare($queryPortfolio);
								$portfolioStmt->execute($list);
								if($portfolioStmt->rowCount()>0){
									$productList = DataController::getListFromQuery($portfolioStmt,$getUserInfo);
									$returnData['status'] = 200;
									$returnData['data'] = $productList;
								}
							}
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Add Customer Wish list
	* paramter portfolioID
	*/
	public function add_customer_wishlist($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'');
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							$postData = $req->getParsedBody();
							if(isset($postData['token']) && !empty($postData['token'])){
								$token =  $postData['token'];
								$decodeValue = base64_decode($token);
								$explodeDecodeValue = explode('&&&',$decodeValue);
								if(count($explodeDecodeValue)==3){
									if($getUserInfo->email == $explodeDecodeValue[2] && $getUserInfo->id == $explodeDecodeValue[1]){
										$wishList = DataController::checkUserWishList($getUserInfo->company_id,$explodeDecodeValue[0]);
										if(count($wishList)==0){
											$insertWishlist = DataController::insertData('wishlist',array('portfolio_id'=>$explodeDecodeValue[0],'customer_id'=>$getUserInfo->id));
											if($insertWishlist>0){
												$returnData['message'] = "This product is added in your wishlist.";
												$returnData['status'] = 200;
											}
										} else {
											$returnData['status'] = 200;
											$returnData['error_code'] = "801";
											$returnData['message'] = "This product is already in your wishlist.";
										}
									} else {
										$returnData['status'] = 200;
										$returnData['error_code'] = "997";
										$returnData['message'] = "Invalid input data";
									}
								} else {
									$returnData['status'] = 200;
									$returnData['error_code'] = "997";
									$returnData['message'] = "Invalid input data";
								}
							} else {
								$returnData['status'] = 200;
								$returnData['error_code'] = "997";
								$returnData['message'] = "Invalid input data";
							}
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Delete Customer Wish list
	* paramter portfolioID
	*/
	public function delete_customer_wishlist($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'');
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							$postData = $req->getParsedBody();
							if(isset($postData['token']) && !empty($postData['token'])){
								$token =  $postData['token'];
								$decodeValue = base64_decode($token);
								$explodeDecodeValue = explode('&&&',$decodeValue);
								if(count($explodeDecodeValue) == 3) {
									if($getUserInfo->email == $explodeDecodeValue[2] && $getUserInfo->id == $explodeDecodeValue[1]) {
										$checkProductInWhishList = DataController::checkUserWishList($getUserInfo->company_id,$explodeDecodeValue[0]);
										if(count($checkProductInWhishList)>0) {
											$deleteQuery = "DELETE FROM wishlist WHERE customer_id IN (SELECT id FROM customers WHERE company_id=?) AND id=?";
											$deleteStmt = $this->db->prepare($deleteQuery);
											$deleteStmt->execute([$getUserInfo->company_id,$checkProductInWhishList->id]);
											if($deleteStmt->rowCount()>0){
												$returnData['message'] = "Portfolio deleted from your wish list.";
												$returnData['status'] = 200;
											} else {
												$returnData['status'] = 200;
												$returnData['error_code'] = "101";
												$returnData['message'] = "Internal server error.";
											}
										} else {
											$returnData['status'] = 200;
											$returnData['error_code'] = "997";
											$returnData['message'] = "Invalid input data";
										}
									} else {
										$returnData['status'] = 200;
										$returnData['error_code'] = "997";
										$returnData['message'] = "Invalid input data";
									}
								} else {
									$returnData['status'] = 200;
									$returnData['error_code'] = "997";
									$returnData['message'] = "Invalid input data";
								}
							} else {
								$returnData['status'] = 200;
								$returnData['error_code'] = "997";
								$returnData['message'] = "Invalid input data";
							}
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	
	public function update_user_preferences($app,$req,$resp,$args = []) {
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							$postData = $req->getParsedBody();
							if(count($postData['preferences']) > 0) {
								/*Delete Old preferences*/
								$queryDelete = "DELETE FROM preferences WHERE customer_id IN (SELECT id FROM customers WHERE company_id=?)";
								$preferencesStmt = $this->db->prepare($queryDelete);
								$preferencesStmt->execute([$getUserInfo->company_id]);
								$tapUpdate = false;
								/*Insert New preferences*/
								$query = "INSERT INTO preferences (customer_id, preference_id, category_type) VALUES ";
								foreach($postData['preferences'] as $preference) {
									if($preference != "" && $preference > 0) {
										$query .=" (".$getUserInfo->id.",".$preference.",0), ";
									}										
								}
								if($query !=""){
									$query = substr($query,0,-2);
									$preferencesStmt = $this->db->prepare($query);
									$preferencesStmt->execute();
									if($preferencesStmt->rowCount()>0){
										$tapUpdate = true;
										$returnData['status'] = 200;
										$returnData['message'] = "Your preferences updated";
									}
								}
								
								if($tapUpdate === false) {
									$returnData['status'] = 200;
									$returnData['error_code'] = "996";
									$returnData['message'] = "Internal server error.";
								}
							} else {
								$returnData['status'] = 200;
								$returnData['error_code'] = "996";
								$returnData['message'] = "Please select your preferences";
								
							}
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);		
	}
	
	/**
	* Find User preferences
	*/
	
	public function user_preferences($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							$query = "SELECT p.preference_id,c.name FROM preferences as p INNER JOIN category as c ON c.id = p.preference_id WHERE p.customer_id IN (SELECT id FROM customers WHERE company_id=?)";
							$preferencesStmt = $this->db->prepare($query);
							$preferencesStmt->execute([$getUserInfo->company_id]);
							if($preferencesStmt->rowCount()>0){
								$list = array();
								while($row = $preferencesStmt->fetch()){
									array_push($list,$row);
								}
								$returnData['data'] = $list;
							}
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	public function get_all_parent_child_category($app,$req,$resp,$args = []) {
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							$queryChildCategory = "SELECT distinct(c.id) as id, c.name FROM category as c INNER JOIN map_sectors_departments as sc ON sc.category_id= c.id WHERE sc.sector_id=? ORDER BY c.id ASC";
							$categoryStmt = $this->db->prepare($queryChildCategory);
							$categoryStmt->execute([21]);
							$list = array();
							if($categoryStmt->rowCount()>0){
								while($row = $categoryStmt->fetch()){
									array_push($list,$row);
								}
								for($i=0;$i<count($list);$i++) {
									$parentCategoryID = $req->getAttribute('parent_category');
									$queryChildCategory = "SELECT id,name FROM category WHERE parent=? ORDER BY name ASC";
									$categoryStmt = $this->db->prepare($queryChildCategory);
									$categoryStmt->execute([$list[$i]->id]);
									$childList = array();
									if($categoryStmt->rowCount()>0){
										while($row = $categoryStmt->fetch()){
											array_push($childList,$row);
										}
									}
									$list[$i]->child = $childList;
								}
							}
							$returnData = array('status'=>200,'message'=>'','data'=>$list);
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(Exception $e){	
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	public function my_membership($app,$req,$resp,$args = []) {
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							$membership = "";
							if((int)$getUserInfo->membership == 0){
								$membership = 'Visitor';
							} else if((int)$getUserInfo->membership == 1){
								$membership = 'Licensees';
							} else if((int)$getUserInfo->membership == 2) {
								$membership = 'Participant';
							} 
							$showF = false;
							$file = "";
							if($getUserInfo->file != "") {
								$file = DataController::fileReplaceToView($getUserInfo->file);
								$showF = true;
							}
							$endDate = "";
							if($getUserInfo->end_date != '0000-00-00') {
								$endDate = date('M d, Y',strtotime($getUserInfo->end_date));
							}
							$returnData['status'] = 200;
							$returnData['data'] = array("membership"=>$membership,"file"=>$file,'expiry'=>$endDate,'show_f'=>$showF);
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);		
	}
	
	
	/**
	* Upload membership proof of payment
	* post parameter with customer login information i.e email and password and also portfolio_number and upload_request_file and p_type =>0 if request from docket and p_type=>1 if request comes from shop
	*/
	public function membership_payment($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
				try{
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($userData)>0){
							$uploadedFiles = $req->getUploadedFiles();
							$uploadedFile = $uploadedFiles['upload_membership_payment'];
							if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
								$uploadFileName = $uploadedFile->getClientFilename();
								$tmp_name = $uploadedFile->file;
								$allowed =  array('pdf');
								$name = $userData->first_name."_".$uploadFileName;
								$ext = pathinfo($name, PATHINFO_EXTENSION);
								if(in_array(strtolower(strtoupper($ext)),$allowed) ) {
									$data = array('file1' => "@".$tmp_name.';filename='.$name);
									$getFolderID = DataController::getLeadFolderID($licenseNumber,"customer_folder");
									$fileName = DataController::uploadFile($data,$getFolderID);
									if (count($fileName)>0 && isset($fileName['file1']) && !empty($fileName['file1'])) {
										try{											
											$insertData = DataController::insertData('membership_payments',array('file'=>$fileName['file1'],'create_date'=>date('Y-m-d H:i:s'),'customer_id'=>$userData->id));
											if((int)$insertData>0){
												$returnData['error'] = 0;
												$returnData['success'] = 1;
												$returnData['message'] = "Thank you for sending your request. We will get back to you shortly.";
											} else {
												$returnData['status'] = 500;
												$returnData['error_code'] = "100";
												$returnData['message'] = "Internal server error";
											}
										}catch(Exception $e){
											$this->logger->addInfo($e->getMessage());
											$returnData['status'] = 500;
											$returnData['error_code'] = "100";
											$returnData['message'] = "Internal server error";
										}
									} else {
										$returnData['status'] = 500;
										$returnData['error_code'] = "100";
										$returnData['message'] = "Internal server error";
									}
								} else {
									$returnData['status'] = 500;
									$returnData['error_code'] = "110";
									$returnData['message'] = "Upload only PDF file";
								}
							} else {
								$returnData['status'] = 500;
								$returnData['error_code'] = "111";
								$returnData['message'] = "File is corrupted";
							}
						} else {
							$returnData['status'] = 500;
							$returnData['error_code'] = "102";
							$returnData['message'] = "Invalid user details";
						}
					} else {
						$returnData['status'] = 500;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Invalid user details";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "102";
				$returnData['message'] = "Token Expired";
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Find User company Info
	*
	*/
	public function company_info($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							$queryCompany = "SELECT company_name,company_address,telephone,bank_name,bank_account_no,routing_no FROM company WHERE id=?";
							$companyStmt = $this->db->prepare($queryCompany);
							$companyStmt->execute([$getUserInfo->company_id]);
							if($companyStmt->rowCount()>0){
								$companyInfo = $companyStmt->fetch();
								$accountNumber = $companyInfo->bank_account_no;
								if(!empty($accountNumber)){
									$accountNumber = str_repeat('x', (strlen($accountNumber) - 4)). substr($accountNumber,-4,4);
								}
								$companyInfo->bank_account_no = $accountNumber;
								$routingNo = $companyInfo->routing_no;
								if(!empty($routingNo)){
									$routingNo = str_repeat('x', (strlen($routingNo) - 3)). substr($routingNo,-3,3);
								}
								$companyInfo->routing_no = $routingNo;
								$returnData['data'] = $companyInfo;
							}
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Find Company users list
	*
	*/
	public function users_list($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							$queryCustomers = "SELECT first_name,last_name,email,phone_number,id FROM customers WHERE company_id =?";
							$customersStmt = $this->db->prepare($queryCustomers);
							$customersStmt->execute([$getUserInfo->company_id]);
							if($customersStmt->rowCount()>0){
								$list = array();
								while($row = $customersStmt->fetch()){
									$row->token = base64_encode($row->email.'&&&'.$row->id.'&&&');
									unset($row->id);
									array_push($list,$row);
								}
								$returnData['data'] = $list;
							}
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Find User company Info
	*
	*/
	public function user_info($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							unset($getUserInfo->id);
							$returnData['data'] = $getUserInfo;
							$returnData['status'] = 200;
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	
	/**
	* User account 
	* change password or add user
	*/
	public function update_user_account($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$errorPersonalInfo = "";
		$errorCompanyInfo = "";
		$successPersonalInfo = "";
		$successCompanyInfo = "";
		$successUser = array();
		$errorUser = array();
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
				if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
					$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
					if(count($userData)>0){						
						$postData = $req->getParsedBody();
						if(isset($postData['change_password']) && $postData['change_password']==1){
							if(isset($postData['old_password']) && !empty($postData['old_password']) && !empty($postData['new_password'])){
								if(md5($postData['old_password']) == $userData->password){
									$queryUpdate = "UPDATE customers SET password =? WHERE id = ?";
									$this->logger->addInfo($queryUpdate);
									$this->logger->addInfo(json_encode([md5($postData['new_password']),$userData->id]));
									$customerStmt = $this->db->prepare($queryUpdate);
									$customerStmt->execute([md5($postData['new_password']),$userData->id]);
									if($customerStmt->rowCount()>0){
										$errorPersonalInfo = "";
										$successPersonalInfo = "Successfully update your password.";
									} else {
										$errorPersonalInfo = "Internal server error";
										$successPersonalInfo = "";
									}
								}
							}
						}
						if(isset($postData['change_details']) && $postData['change_details'] == '1'){
							if(!empty($postData['my_first_name']) && !empty($postData['my_last_name']) && !empty($postData['my_phone_number'])){
								$queryUpdate = "UPDATE customers SET first_name =?,last_name =?,phone_number =? WHERE id = ?";
								$this->logger->addInfo($queryUpdate);
								$this->logger->addInfo(json_encode([$postData['my_first_name'],$postData['my_last_name'],$postData['my_phone_number'],$userData->id]));
								$customerStmt = $this->db->prepare($queryUpdate);
								$customerStmt->execute([$postData['my_first_name'],$postData['my_last_name'],$postData['my_phone_number'],$userData->id]);
								if($customerStmt->rowCount()>0){
									$errorPersonalInfo = "";
									if($successPersonalInfo == "") {
										$successPersonalInfo = "Successfully update personal info.";
									} else {
										$successPersonalInfo .= " and personal info.";
									}									
								}
							}
						}
						if(isset($postData['company_address']) && !empty($postData['company_address']) && !empty($postData['telephone']) && !empty($postData['bank_name']) && !empty($postData['bank_account_no']) && !empty($postData['routing_no'])){
							$updateCompany = "UPDATE company SET company_address=?,telephone=?,bank_name=?,bank_account_no=?,routing_no=? WHERE id=?";
							$this->logger->addInfo($updateCompany);
							$this->logger->addInfo(json_encode(array($postData['company_address'],$postData['telephone'],$postData['bank_name'],$postData['bank_account_no'],$postData['routing_no'],$userData->company_id)));
							$companyStmt = $this->db->prepare($updateCompany);
							$companyStmt->execute([$postData['company_address'],$postData['telephone'],$postData['bank_name'],$postData['bank_account_no'],$postData['routing_no'],$userData->company_id]);
							if($companyStmt->rowCount()>0){
								$errorCompanyInfo = "";
								$successCompanyInfo = "Successfully update company info.";
							}
						}
						if(isset($postData['first_name']) && count($postData['first_name'])>0){
							for($i=0;$i<count($postData['first_name']);$i++){
								if(!empty($postData['first_name'][$i]) && !empty($postData['email_address'][$i])){
									$checkUser = DataController::checkEmail($postData['email_address'][$i]);
									if($checkUser==0){
										$user = array();
										$user['first_name'] = $postData['first_name'][$i];
										$user['last_name'] = $postData['last_name'][$i];
										$user['email'] = $postData['email_address'][$i];
										$user['phone_number'] = $postData['phone_number'][$i];
										$user['password'] = md5('123456');
										$user['status'] = 0;
										$user['company_id'] = $userData->company_id;
										$user['create_date'] = date('Y-m-d H:i:s');
										$userID = DataController::insertData('customers',$user);
										if($userID>0){
											$insertUsers[] = $userID;
											unset($user['create_date']);
											unset($user['status']);
											unset($user['password']);
											$user['phone'] = $user['phone_number'];
											unset($user['phone_number']);
											DataController::insertData('contacts',$user);
											$successUser[] = $user['email'];
											$error = "";
										} else {
											$error = "Internal server error";
										}
									} else {
										$errorUser[] = $postData['email_address'][$i];
									}
								}
							}
						}
						$returnData['status'] = 200;
						$returnData['data'] = array('errorUser'=>$errorUser,'successUser'=>$successUser,'errorPersonalInfo'=>$errorPersonalInfo,'successPersonalInfo'=>$successPersonalInfo,'errorCompanyInfo'=>$errorCompanyInfo,'successCompanyInfo'=>$successCompanyInfo);
					} else {
						$returnData['status'] = 500;
						$returnData['error_code'] = "100";
						$returnData['message'] = "Invalid user token.";
					}
				} else {
					$returnData['status'] = 500;
					$returnData['error_code'] = "100";
					$returnData['message'] = "Invalid user token.";
				}
			} else {
				$message = "Invalid token";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Delete User from customer account 
	* return 1 or 0;
	*/
	public function remove_user($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array('d'=>0));
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
				if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
					$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
					if(count($userData)>0){						
						$postData = $req->getParsedBody();
						if(isset($postData['token']) && $postData['token'] != ""){
							$decodeToken = base64_decode($postData['token']);
							$explodeToken = explode('&&&',$decodeToken);
							if(count($explodeToken) == 3) {
								if((int)$explodeToken[1] > 0) {
									$getCustomerInfo = DataController::getCustomerInfoByID($explodeToken[1]);
									if(count($getCustomerInfo) > 0) {
										$returnData['status'] = 200;
										$returnData['data']['d'] = DataController::deleteCustomer($getCustomerInfo->id);
									}					
								}
							}
						}
					} else {
						$returnData['status'] = 500;
						$returnData['error_code'] = "100";
						$returnData['message'] = "Invalid user token.";
					}
				} else {
					$returnData['status'] = 500;
					$returnData['error_code'] = "100";
					$returnData['message'] = "Invalid user token.";
				}
			} else {
				$message = "Invalid token";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Customer Transaction 
	* return list of licenses bought by customer
	*/
	
	public function user_transaction($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array('granted'=>array(),'demo'=>array(),'footer'=>array()));
		$errorPersonalInfo = "";
		$successPersonalInfo = "";
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							/**/
							$query = "SELECT l.*, lead.lead_name,lead.serial_number,cs.email as person_email FROM license_granted as l INNER JOIN licenses as li ON li.id = l.license_id INNER JOIN litigations as lead ON lead.serial_number = li.serial_number INNER JOIN customers as cs ON cs.id = l.customer_id WHERE l.customer_id IN (SELECT co.id FROM customers as co WHERE co.company_id=?)  ORDER BY l.id DESC";
							$transactionStmt = $this->db->prepare($query);
							$transactionStmt->execute([$getUserInfo->company_id]);
							$list = array();
							if($transactionStmt->rowCount()>0){
								while($data = $transactionStmt->fetch()){
									$type_name = '';
									switch((int)$data->doc_type){
										case 0:								
										case 1:
											$type_name = 'Request to Participate';
										break;
										case 2:
											$type_name = 'Non-Exclusive License';
										break;
										case 3:
											$type_name = 'Strategic License';
										break;
										case 4:
											$type_name = 'Proof Of Payment';
										break;
										case 5:
											$type_name = 'Payment Notice';
										break;
									}
									$data->type_name = $type_name;
									$proof_of_payment = $data->proof_of_payment;
									if($proof_of_payment!=""){
										$proof_of_payment = str_replace('view?usp=drivesdk','preview',$proof_of_payment);
										$proof_of_payment = str_replace('edit?usp=drivesdk','preview',$proof_of_payment);
									}			
									$data->proof_of_payment = $proof_of_payment;
									$execute_agreement = $data->execute_agreement;
									if($execute_agreement!=""){
										$execute_agreement = str_replace('view?usp=drivesdk','preview',$execute_agreement);
										$execute_agreement = str_replace('edit?usp=drivesdk','preview',$execute_agreement);
									}			
									$data->execute_agreement = $execute_agreement;
									if($data->amount!='0.000'){
										$data->amount = round($data->amount, 3,PHP_ROUND_HALF_UP);
									} else {
										$data->amount = '';
									}
									if($data->company_id>0){
										/*Find company name */
										$getCompanyData = DataController::getCompanyInfo($data->company_id);
										if(count($getCompanyData)>0){
											$data->license_company = $getCompanyData->company_name;
										}				
									}
									$data->create_date = date('M, d y',strtotime($data->create_date));
									array_push($list,$data);
								}
							}
							$returnData['data']['granted'] = $list;
							$list = array();
							if($getUserInfo->demo==0){
								$queryDemo = "SELECT c.lead_id,c.type,c.amount,c.executed_date,c.file,c.file_name,c.file_type,c.user_send, lead.lead_name,lead.serial_number,cs.email as person_email FROM demo_request_to_participates as c INNER JOIN litigations as lead ON lead.id = c.lead_id INNER JOIN customers as cs ON cs.id = c.customer_id ORDER BY c.id DESC";
								$demoStmt = $this->db->prepare($queryDemo);
								$demoStmt->execute();
								if($demoStmt->rowCount()>0){
									while($data = $demoStmt->fetch()){
										$type_name = '';
										switch((int)$data->type){
											case 0:								
											case 1:
												$type_name = 'Request to Participate';
											break;
											case 2:
												$type_name = 'Non-Exclusive License';
											break;
											case 3:
												$type_name = 'Strategic License';
											break;
											case 4:
												$type_name = 'Proof Of Payment';
											break;
											case 5:
												$type_name = 'Payment Notice';
											break;
										}
										$data->type_name = $type_name;
										$file = $data->file;
										$file = str_replace('view?usp=drivesdk','preview',$file);
										$file = str_replace('edit?usp=drivesdk','preview',$file);
										$data->file = $file;
										$data->amount = '';
										$data->date = date('M, d y',strtotime($data->executed_date));
										array_push($list,$data);
									}
								}
							}
							$returnData['data']['demo'] = $list;
							$newFooter = (object)array('id'=>'','lead_id'=>'','type'=>'','amount'=>'','date'=>'','file'=>'','file_type'=>0,'user_send'=>0,'lead_name'=>'','serial_number'=>'','person_email'=>'','type_name'=>'Total:','file_name'=>'Total:'); 
							$returnData['data']['footer'] = $newFooter;
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "999";
				$returnData['message'] = "Invalid token, Login again.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Customer Deal flow 
	* return list of licenses customer is dealing with
	*/
	
	public function user_deal_flow($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$errorPersonalInfo = "";
		$successPersonalInfo = "";
		try{
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo)>0){
							/**/
							$query = "SELECT c.license_type,c.lead_id,c.available_for,c.customize_file,c.customize_filename,c.agreement_status,c.syndication,c.syndication_filename,c.availability,c.executed_by_synpat,c.synpat_filename,c.executed_by_customer,c.customer_filename,c.created_date,c.modified_date,c.user_send, lead.lead_name,lead.serial_number FROM customer_deal_flow as c INNER JOIN litigations as lead ON lead.id = c.lead_id INNER JOIN customers as cs ON cs.id = c.customer_id WHERE c.customer_id IN (SELECT co.id FROM customers as co WHERE co.company_id=?) ORDER BY c.id DESC";
							$dealStmt = $this->db->prepare($query);
							$dealStmt->execute([$getUserInfo->company_id]);
							if($dealStmt->rowCount()>0){
								$list = array();
								$customerCompanyName = DataController::getCompanyInfo($getUserInfo->company_id);
								while($data = $dealStmt->fetch()){
									$data->customer_name = $customerCompanyName->company_name;
									$fileNo = 0;
									if($data->customize_file != ""){
										$columName = "";
										switch($data->license_type){
											case 2:
												$columName = "license_aggreement";
												break;
											case 3:
												$columName = "strategic_aggreement";
												break;
										}
										if($columName != ""){
											$query = "SELECT id FROM revised_documents WHERE {$columName} = ? AND customer_id = ? LIMIT 1";
											
											$customizeStmt = $this->db->prepare($query);
											$customizeStmt->execute([$data->customize_file,$getUserInfo->id]);
											if($customizeStmt->rowCount()>0){
												$fileFetch = $customizeStmt->fetch();
												$fileNo = $fileFetch->id;
											}
										}
									}
									$data->file_no = $fileNo;
									if($data->agreement_status==2){
										$file = $data->customize_file;
										$file = str_replace('view?usp=drivesdk','preview',$file);
										$file = str_replace('edit?usp=drivesdk','preview',$file);			
										$data->customize_file = $file;
									}
									if(!empty($data->syndication)){
										$file = $data->syndication;
										$file = str_replace('view?usp=drivesdk','preview',$file);
										$file = str_replace('edit?usp=drivesdk','preview',$file);			
										$data->syndication = $file;
									}
									if(!empty($data->executed_by_synpat)){
										$file = $data->executed_by_synpat;
										$file = str_replace('view?usp=drivesdk','preview',$file);
										$file = str_replace('edit?usp=drivesdk','preview',$file);			
										$data->executed_by_synpat = $file;
									}
									if(!empty($data->executed_by_customer)){
										$file = $data->executed_by_customer;
										$file = str_replace('view?usp=drivesdk','preview',$file);
										$file = str_replace('edit?usp=drivesdk','preview',$file);			
										$data->executed_by_customer = $file;
									}
									array_push($list,$data);
								}
								$returnData['data'] = $list;
							}
						} else {
							$returnData['status'] = 200;
							$returnData['error_code'] = "998";
							$returnData['message'] = "User blocked. Contact SynPat customer relations by phone or at customers@synpat.com.";
						}
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired1.";
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired2";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "102";
				$returnData['message'] = "Token Expired3.";
			}			
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Portfolio Detail 
	* post customer login information or valid customer token and portfolio_number
	* return detail of portfolio and also list of pending payment information and executed files with download link
	*/
	
	public function portfolio_info($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$errorPersonalInfo = "";
		$successPersonalInfo = "";
		try{	
			$postData = $req->getParsedBody();
			$userData = array();
			$newUser = 0;
			if($postData['p_type'] == 0){
				if($postData['user']['email_address']!="" && $postData['user']['password']!=""){
					$checkUser = DataController::checkCustomerLogin($postData['user']['email_address'],$postData['user']['password']);
					if(count($checkUser)>0){
						$newUser = 1;
						if($checkUser->status==0){
							$userData = $checkUser;
						}
					} else {
						$checkUserFromRequest = DataController::checkCustomerRequestLogin($postData['user']['email_address'],$postData['user']['password']);
						if(count($checkUserFromRequest)>0){
							$userData = $checkUserFromRequest;
							$newUser = 0;
						}
					}
				}					
			} else if($postData['p_type'] == 1){
				$headers = $req->getHeaders();
				$auth = $headers['HTTP_AUTHORIZATION'];
				$checkAuthorization = false;
				if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
					$checkAuthorization = DataController::checkToken($auth[0]);
				}
				if($checkAuthorization===true){
					$key = $this->get('settings')['docket-key'];
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					try{
						if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0){
							$newUser = 1;
							$userData = DataController::getUserInfo($decodeToken->context->user->user_id);
						}
					}catch(\Exception $e){						
						$this->logger->addInfo($e->getMessage());
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}					
			}
			if(count($userData)>0){
				$portfolioNumber = $postData['serial_number'];
				$queryPortfolio = "SELECT id FROM licenses WHERE serial_number=?";
				$portfolioStmt = $this->db->prepare($queryPortfolio);
				$portfolioStmt->execute([$portfolioNumber]);
				if($portfolioStmt->rowCount()>0){
					$getLicenseData = $portfolioStmt->fetch();
					$queryData = "SELECT a.purchase_license,a.purchase_buy,a.strategic_license_agreement,active_button,l.lead_name,l.id as leadID,l.customer_folder as folder_id FROM licenses as a INNER JOIN litigations as l ON l.serial_number = a.serial_number WHERE l.serial_number = ?";
					$infoStmt = $this->db->prepare($queryData);
					$infoStmt->execute([$portfolioNumber]);
					if($infoStmt->rowCount()>0){
						$data = array();
						$getFilesData = $infoStmt->fetch();
						$pla = DataController::fileReplaceToView($getFilesData->purchase_license);
						$rtp = DataController::fileReplaceToView($getFilesData->purchase_buy);
						$sla = DataController::fileReplaceToView($getFilesData->strategic_license_agreement);
						$rtpd = DataController::fileReplaceToExport($getFilesData->purchase_buy,'&exportFormat=pdf');
						$data['files'] = array('pla'=>$pla,'rtp'=>$rtp,'sla'=>$sla,'rtpd'=>$rtpd);
						$data['message'] = $getFilesData->lead_name;
						$data['session_no'] = $getFilesData->leadID;
						$data['cookie_no'] = $getLicenseData->id;
						$data['folder_id'] = $getFilesData->folder_id;
						$data['active'] = $getFilesData->active_button;
						$download = array();
						$queryExecuted = "SELECT file,file_name FROM pos_agreements WHERE customer_id IN ( SELECT id FROM customers WHERE company_id=?)";
						$executedStmt = $this->db->prepare($queryExecuted);
						$executedStmt->execute([$userData->company_id]);
						if($executedStmt->rowCount()>0){
							while($file = $executedStmt->fetch()){
								$download[] = array('file'=>DataController::fileReplaceToView($file->file),'name'=>$file->file_name,'download'=>DataController::fileReplaceToExport($file->file,'&exportFormat=pdf'));
							}
						}
						$data['executed_files'] = $download;
						$queryPendingPayments = "SELECT a.type as action_type,a.doc_type as license,a.id as fileNo ,target.company_name as target FROM potential_participates as a LEFT JOIN company as target ON target.id = a.company_id WHERE a.status=3 AND a.license_id=? AND a.customer_id IN (SELECT id FROM customers WHERE company_id=?)";
						$pendingPayments = $this->db->prepare($queryPendingPayments);
						$pendingPayments->execute([$getLicenseData->id,$userData->company_id]);
						$pendingPaymentList = array();
						if($pendingPayments->rowCount()>0){
							while($row = $pendingPayments->fetch()){
								array_push($pendingPaymentList,$row);
							}
						}
						$data['pending_payments'] = $pendingPaymentList;
						$returnData['data'] = $data;
					} else {
						$returnData['status'] = 200;
						$returnData['error_code'] = "997";
						$returnData['message'] = "Not a valid number.";
					}
				} else {
					$returnData['status'] = 200;
					$returnData['error_code'] = "997";
					$returnData['message'] = "Not a valid number.";
				}
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "101";
				$returnData['message'] = "Invalid user";
			}
		} catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/**
	* Demo Portfolio List
	*
	*/
	public function demo_portfolio_list($app,$req,$resp,$args = []) {
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$listShow = false;
			$getUserInfo = array();
			$headers = $req->getHeaders();
			$auth = $headers['HTTP_AUTHORIZATION'];
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){								
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0 && isset($decodeToken->context->user->type) && $decodeToken->context->user->type == "Customer") {
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo) > 0) {
							$listShow = true;
						}
					} else {
						$listShow = true;
						
					}
				}catch(\Exception $e){						
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			} else {
				$listShow = true;
				
			}
			$productList = array();
			if($listShow===true) {
				/*Customer is logged in*/		
				$productList = DataController::getDemoportfolios($getUserInfo);	
				$returnData['status'] = 200;
				$returnData['data'] = array('portfolio_list'=>$productList);
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "101";
				$returnData['message'] = "Invalid input";
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	private function getDemoportfolios($getUserInfo){
		$productList = array();
		$portfolioQuery = "SELECT DISTINCT(l.serial_number),a.store_name,a.option_expiration_data,a.seller_asking_price,a.category,c.name as categoryName,a.active_button,a.potential_participants,a.final_participants,a.regular_license_starts,a.late_license_starts,a.store,a.cost_price,l.id as lead_id,li.file_left,li.file_middle,li.file_right,li.file_four,li.file_five,li.file_six,li.file_seven,li.file_eight,li.file_nine,li.file_ten,li.file_eleven,li.file_twelve,li.file_thirteen,li.file_fourteen,li.file_fiveteen,li.file_sixteen,li.file_seventeen,li.file_eighteen,li.file_nineteen,li.file_twenty,li.file_twentyone,li.file_twentytwo,li.file_twentythree,li.file_twentyfour,li.file_twentyfive,li.file_twentysix,li.file_twentyseven,li.file_twentyeight,li.file_twentynine,li.file_thirty,li.file_thirtyone,li.file_thirtytwo,l.lead_name,l.serial_number,li.id as licenseID FROM acquisition as a LEFT JOIN litigations as l ON l.id=a.lead_id LEFT JOIN licenses as li ON li.serial_number=l.serial_number INNER JOIN lead_category as cat ON cat.lead_id = l.id LEFT JOIN category as c ON c.id = cat.category_id WHERE l.serial_number IN (?,?,?,?) AND l.status IN ('0','1','2')";
		$portfolioStmt = $this->db->prepare($portfolioQuery);
		$portfolioStmt->execute([73182,72101,22232,85865]);
		if($portfolioStmt->rowCount()>0){
			$productList = DataController::getListFromQuery($portfolioStmt,$getUserInfo,true);
		}
		$productList = array();
		return $productList;
	}
	
	/**
	*
	* Portfolios List
	*/
	public function portfolio_list($app,$req,$resp,$args = []) {
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		try{
			$invitation = $req->getAttribute('invitation');
			$getCategory = $req->getAttribute('category');
			$listShow = false;
			$getUserInfo = array();
			if($invitation != "") {
				$listShow = true;
			} else {
				$headers = $req->getHeaders();
				$auth = $headers['HTTP_AUTHORIZATION'];
				$checkAuthorization = false;
				if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
					$checkAuthorization = DataController::checkToken($auth[0]);
				}				
				if($checkAuthorization === true) {	
					$key = $this->get('settings')['docket-key'];
					try{
						$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
						if(count($decodeToken) > 0 && isset($decodeToken->context->user) && count($decodeToken->context->user) > 0) {
							if(isset($decodeToken->context->user->type) && $decodeToken->context->user->type == "Customer") {
								$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
								if(count($getUserInfo) > 0) {
									$listShow = true;
								}
							} else {
								/*If comes from invitation link*/
								$listShow = true;	
							}							
						}
					}catch(Exception $e) {
						$this->logger->addInfo($e->getMessage());
						$returnData['status'] = 200;
						$returnData['error_code'] = "102";
						$returnData['message'] = "Token Expired";
					}
				}
			}
			$productList = array();	
			
			if($listShow === true) {				
				/*Invitation*/		
				$invitationCategory = 0;
				$invitationSerialNumber = 0;
				if($invitation != "") {
					/*
					$invitation = DataController::decode($invitation);
					*/
					$invitationQuery = "SELECT DISTINCT(l.serial_number),a.store_name,a.option_expiration_data,a.seller_asking_price,a.active_button,a.potential_participants,a.final_participants,a.regular_license_starts,a.late_license_starts,a.store,a.cost_price,li.file_left,li.file_middle,li.file_right,li.file_four,li.file_five,li.file_six,li.file_seven,li.file_eight,li.file_nine,li.file_ten,li.file_eleven,li.file_twelve,li.file_thirteen,li.file_fourteen,li.file_fiveteen,li.file_sixteen,li.file_seventeen,li.file_eighteen,li.file_nineteen,li.file_twenty,li.file_twentyone,li.file_twentytwo,li.file_twentythree,li.file_twentyfour,li.file_twentyfive,li.file_twentysix,li.file_twentyseven,li.file_twentyeight,li.file_twentynine,li.file_thirty,li.file_thirtyone,li.file_thirtytwo,l.id as lead_id,l.lead_name,l.serial_number,li.id as licenseID FROM acquisition as a LEFT JOIN litigations as l ON l.id=a.lead_id LEFT JOIN licenses as li ON l.serial_number=li.serial_number LEFT JOIN lead_category as cat ON cat.lead_id = l.id LEFT JOIN category as c ON c.id=cat.category_id WHERE md5(l.serial_number)=? AND l.status IN ('0','1','2')";
					$invitationStmt = $this->db->prepare($invitationQuery);
					$invitationStmt->execute([$invitation]);
					if($invitationStmt->rowCount()>0){
						$productList = DataController::getListFromQuery($invitationStmt,$getUserInfo);
						$productList[0]->invitation = true;
						if(isset($productList[0]->category)){
							$invitationCategory = $productList[0]->category;
						}						
						$invitationSerialNumber = $productList[0]->serial_number;
					}
				}				
				/*Customer is logged in or comes from invitation link*/
				$category = 0;
				$catInvitation = false;
				if(isset($getCategory) && $getCategory!="") {
					if(!is_numeric($getCategory)) {
						$cat = explode('-',$getCategory);
						if(count($cat)==2){
							$category = (int)$cat[1];
						}						
					} else {
						$category = $invitationCategory;
						$catInvitation = true;
					}
				}
				$showListingFromCategory = false;
				if(isset($decodeToken->context->user->type) && $decodeToken->context->user->type == "Customer" && $catInvitation === false) {
					if((int)$getUserInfo->membership > 0){
						$showListingFromCategory = true;
					}
				}
				if($showListingFromCategory === false && $invitation != "" && $catInvitation === true){
					$showListingFromCategory = true;
				}
				if($category>0 && $showListingFromCategory === true) {
					$portfolioQuery = "SELECT DISTINCT(l.serial_number),a.store_name,a.option_expiration_data,a.seller_asking_price,cat.category_id as category,c.name as categoryName,a.active_button,a.potential_participants,a.final_participants,a.regular_license_starts,a.late_license_starts,a.store,a.cost_price,li.file_left,li.file_middle,li.file_right,li.file_four,li.file_five,li.file_six,li.file_seven,li.file_eight,li.file_nine,li.file_ten,li.file_eleven,li.file_twelve,li.file_thirteen,li.file_fourteen,li.file_fiveteen,li.file_sixteen,li.file_seventeen,li.file_eighteen,li.file_nineteen,li.file_twenty,li.file_twentyone,li.file_twentytwo,li.file_twentythree,li.file_twentyfour,li.file_twentyfive,li.file_twentysix,li.file_twentyseven,li.file_twentyeight,li.file_twentynine,li.file_thirty,li.file_thirtyone,li.file_thirtytwo,l.id as lead_id,l.lead_name,l.serial_number,c.name as categoryName, li.id as licenseID,l.scheduler_link as appointment_link FROM acquisition as a LEFT JOIN litigations as l ON l.id=a.lead_id LEFT JOIN licenses as li ON li.serial_number = l.serial_number LEFT JOIN lead_category as cat ON cat.lead_id = l.id LEFT JOIN category as c ON c.id=cat.category_id WHERE cat.category_id=? AND l.status IN ('0','1','2')";
					if($invitationSerialNumber > 0) {
						$portfolioQuery .= " AND l.serial_number <> ?";
					}
					$portfolioStmt = $this->db->prepare($portfolioQuery);
					
					if($invitationSerialNumber > 0) {
						$portfolioStmt->execute([$category,$invitationSerialNumber]);
					} else {
						$portfolioStmt->execute([$category]);
					}
					
					if($portfolioStmt->rowCount()>0) {
						$list  = DataController::getListFromQuery($portfolioStmt,$getUserInfo);
						$productList = array_merge($productList,$list);
					} else {
						/*Get List of demo portfolios*/
						/*$list  = DataController::getDemoportfolios($getUserInfo);
						$productList = array_merge($productList,$list);		*/				
					}
				} else {
					/*$list  = DataController::getDemoportfolios($getUserInfo);	
					$productList = array_merge($productList,$list);*/
				}
				$catList = array();
				if($invitation != "" && $category > 0 && $catInvitation === true){
					/*get child category list*/
					$catList = DataController::getCategoryList($category);
				}
				$returnData['status'] = 200;
				$returnData['data'] = array('portfolio_list'=>$productList,'portfolio_cat_list'=>$catList);
			} else {
				$returnData['status'] = 200;
				$returnData['error_code'] = "101";
				$returnData['message'] = "Invalid input";
				$returnData['data'] = array('portfolio_list'=>array());
			}
		} catch(Exception $e) {
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	/*
	*
	* Search Portfolios List
	*/
	public function search_portfolio($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		try{
			$checkAuthorization = false;
			$listShow = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0],1);
			}
			if($checkAuthorization===true){								
				$key = $this->get('settings')['docket-key'];
				try{
					$decodeToken = JWT::decode($auth[0], $key, array('HS256'));
					if(count($decodeToken)>0 && isset($decodeToken->context->user) && count($decodeToken->context->user)>0 && isset($decodeToken->context->user->type) && $decodeToken->context->user->type == "Customer") {
						$getUserInfo = DataController::getUserInfo($decodeToken->context->user->user_id);
						if(count($getUserInfo) > 0) {
							$listShow = true;
						}
					}
				}catch(Exception $e){	
					$this->logger->addInfo($e->getMessage());
					$returnData['status'] = 200;
					$returnData['error_code'] = "102";
					$returnData['message'] = "Token Expired";
				}
			}
			if($listShow===true){
				$postData = $req->getParsedBody();
				$searchString = $postData['q'];
				$searchQuery = false;
				if((int)$getUserInfo->membership > 0){
					$searchQuery = true;
				}
				if($searchString!="" && $searchQuery === true){
					$orderBY = $postData['order_by'];
					$searchSql = "SELECT DISTINCT(l.serial_number),a.store_name,a.option_expiration_data,a.seller_asking_price,c.id as category,c.name as categoryName,a.active_button,a.potential_participants,a.final_participants,a.regular_license_starts,a.late_license_starts,a.store,a.cost_price,li.file_left,li.file_middle,li.file_right,li.file_four,li.file_five,li.file_six,li.file_seven,li.file_eight,li.file_nine,li.file_ten,li.file_eleven,li.file_twelve,li.file_thirteen,li.file_fourteen,li.file_fiveteen,li.file_sixteen,li.file_seventeen,li.file_eighteen,li.file_nineteen,li.file_twenty,li.file_twentyone,li.file_twentytwo,li.file_twentythree,li.file_twentyfour,li.file_twentyfive,li.file_twentysix,li.file_twentyseven,li.file_twentyeight,li.file_twentynine,li.file_thirty,li.file_thirtyone,li.file_thirtytwo,l.id as lead_id,l.lead_name,li.id as licenseID FROM acquisition as a LEFT JOIN litigations as l ON l.id=a.lead_id LEFT JOIN licenses as li ON l.serial_number=li.serial_number LEFT JOIN lead_category as cat ON cat.lead_id = l.id INNER JOIN category as c ON c.id=cat.category_id WHERE cat.main_category = 1 AND l.status IN ('0','1','2') AND ";
					if(is_numeric($searchString)){
						$searchSql .= "l.serial_number = ? ";
					} else {
						$searchSql .= "(a.store LIKE ? OR l.lead_name LIKE ? ) ";
					}
					if($orderBY==""){
						$searchSql .=" ORDER BY a.store_name ASC";
					} else {
						switch($orderBY){
							case "l_h":
								/*Lowest to Highest*/
								$searchSql .=" ORDER BY a.cost_price ASC";
							break;
							case "h_l":
								/*Highest to Lowest*/
								$searchSql .=" ORDER BY a.cost_price DESC";
							break;
							case "e_l":
								/*Early to Later*/
								$searchSql .=" ORDER BY a.option_expiration_data ASC";
							break;
							case "l_e":
								/*Later to Early*/
								$searchSql .=" ORDER BY a.option_expiration_data DESC";
							break;
						}
					}
					$searchStmt = $this->db->prepare($searchSql);
					if(is_numeric($searchString)){
						$searchStmt->execute([$searchString]);
					} else {
						$searchStmt->execute(["%$searchString%","%$searchString%"]);
					}
					$getSearchData = array();
					if($searchStmt->rowCount()>0){
						$getSearchData = DataController::getListFromQuery($searchStmt,$getUserInfo);
					}
					$returnData['status'] = 200;
					$returnData['data'] = array('list'=>$getSearchData);
				} else {
					$returnData = array('status'=>200,'message'=>'Invalid input','error_code'=>300);
				}				
			} else {
				$returnData = array('status'=>200,'message'=>'Invalid token','error_code'=>110);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData['status'] = 500;
			$returnData['error_code'] = "100";
			$returnData['message'] = "Internal server error";
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	
	private function findMainCategory($leadID){
		$data = array();
		$query = "SELECT c.id as category,c.name as categoryName FROM lead_category as lc INNER JOIN category as c ON c.id = lc.category_id WHERE lc.main_category = 1 AND lc.lead_id=?";
		$catStmt = $this->db->prepare($query);
		$catStmt->execute([$leadID]);
		if($catStmt->rowCount()>0){
			while($row = $catStmt->fetch()) {
				$data = array('category'=>$row->category,'categoryName'=>$row->categoryName);
			}			
		}
		return $data;
	}
	
	private function getListFromQuery($portfolioStmt, $getUserInfo, $demo=false) {
		$productList = array();
		while($row = $portfolioStmt->fetch()) {
			if(!isset($row->category)){
				$getMainCategory = DataController::findMainCategory($row->lead_id);
				if(count($getMainCategory) > 0){
					$row->category = $getMainCategory['category'];
					$row->categoryName = $getMainCategory['categoryName'];
				}
			}
			$v = time();
			$rowData = $row;
			$rowData->invitation = false;
			$rowData->portfolio_token = DataController::encode($rowData->serial_number);
			$rowData->portfolio_share_url = "https://synpat.com/portfolio/".md5($rowData->serial_number).".html?v=".$v;
			$rowData->portfolio_token_url = "https://synpat.com/";
			$activeButton = DataController::updateActiveButton($rowData->lead_id,$rowData->serial_number,$rowData->cost_price,$rowData->active_button,$rowData->option_expiration_data,$rowData->regular_license_starts,$rowData->late_license_starts);
			if($activeButton>0){
				$rowData->active_button = $activeButton;
			}
			
			if($rowData->option_expiration_data != '0000-00-00 00:00:00') {
				$portfolioExpiration = strtotime($rowData->option_expiration_data);
				
				if($portfolioExpiration>time() && !is_numeric($rowData->cost_price)) {
					$rowData->option_expiration_data = "<span class='blink'>MISSED</span>";
				} else {
					$rowData->option_expiration_data = date('d M y',strtotime($rowData->option_expiration_data));
				}
			} else {
				$rowData->option_expiration_data = '&nbsp;';
			}			

			if($rowData->regular_license_starts != '0000-00-00 00:00:00') {
				$rowData->regular_license_starts = date('d M y',strtotime($rowData->regular_license_starts));
			} else {
				$rowData->regular_license_starts = '&nbsp;';
			}			
			$regularLicenseEnd = '&nbsp;';
			if($rowData->late_license_starts != '0000-00-00 00:00:00') {
				$rowData->late_license_starts = date('d M y',strtotime($rowData->late_license_starts));
				$regularLicenseEnd = date('d M y',strtotime('-1 day',strtotime($rowData->late_license_starts)));
			} else {
				$rowData->late_license_starts = '&nbsp;';
			}
			$rowData->regular_license_end = $regularLicenseEnd;
			
			if($rowData->final_participants < 1) {
				$rowData->final_participants = '<span class="clearfix">TBD</span>';
			}
			if($rowData->potential_participants < 1) {
				$rowData->potential_participants = '<span class="clearfix">&nbsp;</span>';
			}
			$million  = 1000000;
			if($rowData->seller_asking_price != '0.0') {
				/*$rowData->seller_asking_price = '$'.$rowData->seller_asking_price.'M';*/
				$rowData->seller_asking_price = '$'.number_format($rowData->seller_asking_price*$million);
			} else {
				$rowData->seller_asking_price = '0.0';
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
			$rowData->validate_price = $validatedPrice;
			$rowData->validate = $validate;
			if($rowData->late_license_starts!='0000-00-00 00:00:00') {
				$rowData->validate_start = date('d M Y',strtotime($rowData->late_license_starts));
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
			$rowData->regular_price = $regularPrice;
			$rowData->regular = $regular;
			
			$sold = false;
			if((int)$rowData->active_button > 2) {
				$sold = true;
			}
			$rowData->sold = $sold;
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
			$rowData->cost_price = number_format($rowData->cost_price*$million);
			if((int)$rowData->active_button == 1) {
				$participate = true;
			}			
			$rowData->participate_price = $participatePrice;
			$rowData->participate = $participate;
			if(isset($getUserInfo->id) && $getUserInfo->id > 0) {
				$token = base64_encode($rowData->licenseID."&&&".$getUserInfo->id."&&&".$getUserInfo->email);
			} else {
				$token = "";
			}		
			$description = addslashes($rowData->store);
			$description = str_replace('"','&#34;',$description);
			$rowData->description = $description;
			if(isset($rowData->categoryName) && isset($rowData->category)){
				$rowData->portfolio_url= "https://synpat.com/store/".$rowData->categoryName."-".$rowData->category.'/'.$rowData->serial_number;
			}			
			$rowData->token = $token;
			$rowData->demo = $demo;
			$images = array();
			if($rowData->file_left!=""){
				array_push($images,$rowData->file_left);
			}
			unset($rowData->file_left);
			if($rowData->file_middle!=""){
				array_push($images,$rowData->file_middle);
			}
			unset($rowData->file_middle);
			if($rowData->file_right!=""){
				array_push($images,$rowData->file_right);
			}
			unset($rowData->file_right);
			if($rowData->file_four!=""){
				array_push($images,$rowData->file_four);
			}
			unset($rowData->file_four);
			if($rowData->file_five!=""){
				array_push($images,$rowData->file_five);
			}
			unset($rowData->file_five);
			if($rowData->file_six!=""){
				array_push($images,$rowData->file_six);
			}
			unset($rowData->file_six);
			if($rowData->file_seven!=""){
				array_push($images,$rowData->file_seven);
			}
			unset($rowData->file_seven);
			if($rowData->file_eight!=""){
				array_push($images,$rowData->file_eight);
			}
			unset($rowData->file_eight);
			if($rowData->file_nine!=""){
				array_push($images,$rowData->file_nine);
			}
			unset($rowData->file_nine);
			if($rowData->file_ten!=""){
				array_push($images,$rowData->file_ten);
			}
			unset($rowData->file_ten);
			if($rowData->file_eleven!=""){
				array_push($images,$rowData->file_eleven);
			}
			unset($rowData->file_eleven);
			if($rowData->file_twelve!=""){
				array_push($images,$rowData->file_twelve);
			}
			unset($rowData->file_twelve);
			if($rowData->file_thirteen!=""){
				array_push($images,$rowData->file_thirteen);
			}
			unset($rowData->file_thirteen);
			if($rowData->file_fourteen!=""){
				array_push($images,$rowData->file_fourteen);
			}
			unset($rowData->file_fourteen);
			if($rowData->file_fiveteen!=""){
				array_push($images,$rowData->file_fiveteen);
			}
			unset($rowData->file_fiveteen);
			if($rowData->file_sixteen!=""){
				array_push($images,$rowData->file_sixteen);
			}
			unset($rowData->file_sixteen);
			if($rowData->file_seventeen!=""){
				array_push($images,$rowData->file_seventeen);
			}
			unset($rowData->file_seventeen);
			if($rowData->file_eighteen!=""){
				array_push($images,$rowData->file_eighteen);
			}
			unset($rowData->file_eighteen);
			if($rowData->file_nineteen!=""){
				array_push($images,$rowData->file_nineteen);
			}
			unset($rowData->file_nineteen);
			if($rowData->file_twenty!=""){
				array_push($images,$rowData->file_twenty);
			}
			unset($rowData->file_twenty);
			if($rowData->file_twentyone!=""){
				array_push($images,$rowData->file_twentyone);
			}
			unset($rowData->file_twentyone);
			if($rowData->file_twentytwo!=""){
				array_push($images,$rowData->file_twentytwo);
			}
			unset($rowData->file_twentytwo);
			if($rowData->file_twentythree!=""){
				array_push($images,$rowData->file_twentythree);
			}
			unset($rowData->file_twentythree);
			if($rowData->file_twentyfour!=""){
				array_push($images,$rowData->file_twentyfour);
			}
			unset($rowData->file_twentyfour);
			if($rowData->file_twentyfive!=""){
				array_push($images,$rowData->file_twentyfive);
			}
			unset($rowData->file_twentyfive);
			if($rowData->file_twentysix!=""){
				array_push($images,$rowData->file_twentysix);
			}
			unset($rowData->file_twentysix);
			if($rowData->file_twentyseven!=""){
				array_push($images,$rowData->file_twentyseven);
			}
			unset($rowData->file_twentyseven);
			if($rowData->file_twentyeight!=""){
				array_push($images,$rowData->file_twentyeight);
			}
			unset($rowData->file_twentyeight);
			if($rowData->file_twentynine!=""){
				array_push($images,$rowData->file_twentynine);
			}
			unset($rowData->file_twentynine);
			if($rowData->file_thirty!=""){
				array_push($images,$rowData->file_thirty);
			}
			unset($rowData->file_thirty);
			if($rowData->file_thirtyone!=""){
				array_push($images,$rowData->file_thirtyone);
			}
			unset($rowData->file_thirtyone);
			if($rowData->file_thirtytwo!=""){
				array_push($images,$rowData->file_thirtytwo);
			}
			unset($rowData->file_thirtytwo);
			$rowData->images = $images;
			if(count($images) > 0){
				$rowData->images = DataController::getAllImagesWithNameAndType($images);
			} else {
				$rowData->images = array();
			}
			if(count($rowData->images)>0) {
				$rowData->image = $rowData->images[0]['link'];
			}
								
			unset($rowData->lead_id);
			array_push($productList, $rowData);
		}
		return $productList;
	}
	
	/*Update active button*/
	private function updateActiveButton($lead_id,$serial_number,$cost_price,$active_button,$option_expiration_data,$regular_license_starts,$late_license_starts){
		try{
			$todayDate = strtotime(date('Y-m-d',strtotime('now')));
			$expirationDate = strtotime($option_expiration_data);
			$regularLicense = strtotime($regular_license_starts);
			$lateLicense = strtotime($late_license_starts);
			if($cost_price==0.0 || ($option_expiration_data!='0000-00-00 00:00:00' && $regular_license_starts=='0000-00-00 00:00:00' && $expirationDate>$todayDate )) {
				if($active_button!='1'){
					$active_button = 1;
					/*UpdateData*/	
					DataController::updateData('acquisition',array('lead_id'=>$lead_id),array('active_button'=>$active_button));
					DataController::updateData('licenses',array('serial_number'=>$serial_number),array('active_button'=>$active_button));
				}
			} else if($cost_price>0 && $regular_license_starts!='0000-00-00 00:00:00'){
				if($late_license_starts=='0000-00-00 00:00:00'){
					/*echo "1";*/
					$latelicense = date('m/d/Y',strtotime('+4 months',$regularLicense));
					$late_license_starts = date('Y-m-d H:i:s',strtotime($latelicense));
					DataController::updateData('acquisition',array('lead_id'=>$lead_id),array('late_license_starts'=>$late_license_starts));
				} 
				if($todayDate>$regularLicense && $todayDate<$lateLicense ){
					/*echo "2";*/
					if($active_button!=2){
						$active_button = 2;
						DataController::updateData('acquisition',array('lead_id'=>$lead_id),array('active_button'=>$active_button));
						DataController::updateData('licenses',array('serial_number'=>$serial_number),array('active_button'=>$active_button));
					}
				} else if($todayDate>$regularLicense && $todayDate>=$lateLicense){
					/*echo "3";*/
					if($active_button!=3){
						$active_button = 3;
						DataController::updateData('acquisition',array('lead_id'=>$lead_id),array('active_button'=>$active_button));
						DataController::updateData('licenses',array('serial_number'=>$serial_number),array('active_button'=>$active_button));
					}						
				}					
			}
		} catch(Exception $e) {
		}

		return $active_button;
	}
	
	
	private function getSkeletonTabData() {
		$skeletonData = array();
		$stmt = $this->db->prepare("SELECT li.introduction,li.portfolio_tab,li.counter_tab ,li.price_tab,li.simulator_tab,li.document_tab,li.claim_tab,li.invention_tab,li.evidence_tab ,li.comparables_tab,li.litigation_tab,li.royalties_tab,li.fcitation_tab,li.seller_tab,li.pdf_tab,li.validity_tab,li.bcitation_tab,li.prior_tab,li.legal_tab,li.dmca,li.privacy_tab FROM licenses as li WHERE li.license_number=12345 LIMIT 1");
		$stmt->execute();
		$num_rows = $stmt->rowCount();
		if($num_rows==1){
			$skeletonData = $stmt->fetch();
		}		
		return $skeletonData;
	}
	
	/*Format Date*/
	
	private function formatDate($date){
		try{
			if($date!=null && !empty($date)){
				$dformat = explode('-',$date);
				if(count($dformat)==3){
					$date = implode('-',array($dformat[1],$dformat[2],$dformat[0]));
				}
			}
		}catch(Exception $e){
			
		}
		return $date;
	}
	
	
	private function returnFile($file,$jsonString){
		if(strpos($jsonString,"storage.googleapis")!==false){
			$file = $jsonString;
		} else {
			try{
				$jsonObj = json_decode($jsonString,true);
				if(isset($jsonObj['from']) && $jsonObj['from']==$file && $jsonObj['id']!=""){
					$file="https://drive.google.com/uc?export=view&id=".$jsonObj['id'];
				} else if(!empty($file)){
					if(strpos($file,"drive")!==false){
						$file = str_replace('/view?usp=drivesdk','',$file);
						$fileIDs = array_pop(explode('/',$file));
						if(!empty($fileIDs)){
							$file="https://drive.google.com/uc?export=view&id=".$fileIDs;
						}
					}															
				}
			}catch(Exception $e){}
		}
		
		return $file;
	}
	
	/*Change file to viewOnly*/
	
	
	private function changeFileToViewOnly($file) {
		if(!empty($file)){
			$file = str_replace('/edit?usp=drivesdk','/preview',$file);
			$file = str_replace('/view?usp=drivesdk','/preview',$file);
			$file = str_replace('/edit','/preview',$file);
			$file = str_replace('/view','/preview',$file);
		}
		return $file;
	}
	
	/*Check user wishlist*/
	
	private function checkUserWishList($companyID,$portfolioID) {
		$queryWishList = "SELECT id FROM wishlist WHERE customer_id IN (SELECT id FROM customers WHERE company_id=?) AND portfolio_id=?";
		$wishlistStmt = $this->db->prepare($queryWishList);
		$wishlistStmt->execute([$companyID,$portfolioID]);
		$data = array();
		if($wishlistStmt->rowCount()>0){
			$data = $wishlistStmt->fetch();
		}
		return $data;
	}
	
	private function fileReplaceToExport($file,$format) {
		$file = str_replace('/edit?usp=drivesdk',$format,$file);
		$file = str_replace('/view?usp=drivesdk',$format,$file);
		$file = str_replace('/edit',$format,$file);
		$file = str_replace('/view',$format,$file);
		$file = str_replace('https://docs.google.com/document/d/','https://docs.google.com/feeds/download/documents/export/Export?id=',$file);
		return $file;
	}

	private function fileReplaceToView($file) {
		$file = str_replace('/edit?usp=drivesdk','/preview',$file);
		$file = str_replace('/view?usp=drivesdk','/preview',$file);
		$file = str_replace('/edit','/preview',$file);
		$file = str_replace('/view','/preview',$file);
		return $file;
	}
	
	/**
	*
	* Company Information
	*/
	private function getCompanyInfo($companyID){
		$queryCompanyName = "SELECT company_name FROM company where id=?";
		$companyStmt = $this->db->prepare($queryCompanyName);
		$companyStmt->execute([$companyID]);
		$data = array();
		if($companyStmt->rowCount()>0){
			$data = $companyStmt->fetch();
		}
		return $data;
	}
	
	/**
	*
	* Customer Information
	*/
	private function getUserInfo($customerID){
		$query = "SELECT c.*, co.company_name,co.membership,co.end_date,co.file FROM customers as c INNER JOIN company as co ON co.id = c.company_id WHERE c.id=? AND c.status=0";
		$userStmt = $this->db->prepare($query);
		$userStmt->execute([$customerID]);
		$data = array();
		if($userStmt->rowCount()>0){
			$data = $userStmt->fetch();
		}
		return $data;
	}
	
	/**
	* PotentialData
	*
	*/
	private function checkPotentialData($licenseID,$companyID,$potentialRowID){
		$data = array();
		$query = "SELECT id,proof_of_payment,execute_agreement FROM potential_participates WHERE status=3 AND customer_id IN (SELECT id FROM customers WHERE company_id=?) AND license_id=? AND id=?";
		$potentialStmt = $this->db->prepare($query);
		$potentialStmt->execute([$companyID,$licenseID,$potentialRowID]);
		if($potentialStmt->rowCount()>0){
			$data = $potentialStmt->fetch();
		}
		return $data;
	}
	/**
	* Check License
	*/
	private function checkLicense($licenseNumber){
		$data = array();
		if($licenseNumber!=""){
			$queryLicense = "SELECT id FROM licenses WHERE license_number=?";
			$licenseStmt = $this->db->prepare($queryLicense);
			$licenseStmt->execute([$licenseNumber]);
			if($licenseStmt->rowCount()>0){
				$data = $licenseStmt->fetch();
			}
		}
		return $data;
	}
	/**
	*
	* Check Google Captcha
	*/
	private function googleCaptcha($request){
		$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".CAPTCHA_SECRET_KEY."&response=".$request."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
		$dataResponse = false;
		if(isset($response['success'])){
			$dataResponse = $response['success'];
		}
		return $dataResponse;
	}
	
	/**
	* Insert new Customer request 
	* receive $user array parameter and type if type is 0 then it comes from docket and if it comes from store then it will be 1. and return will new user id from customer request table or it will give error message
	*/
	
	private function insertCustomerRequest($userData = array(),$type=0){
		$returnData = array('id'=>0,'error'=>0,'verification'=>2,'message'=>'');
		if(strlen(trim($userData['person_email']))==0 || strlen(trim('/^[a-zA-Z0-9]+$/i', $userData['person_name']))==0 || strlen(trim('/^[a-zA-Z0-9]+$/i', $userData['company_name']))==0 || strlen(trim($userData['password']))==0 || strlen(trim($userData['confirm_password']))==0){
			$returnData['error'] = 2;
			$returnData['verification'] = 2;
			$returnData['message'] = "Some fields are empty";
		} else if($userData['password'] == $userData['confirm_password']){			
			$name = explode(" ",$userData['person_name']);
			if(!isset($name[1])){
				$name[1] = "";
			}
			$customerFields = array('first_name'=>$name[0],'last_name'=>$name[1],'email'=>$userData['person_email'],'password'=>md5($userData['password']),'company_name'=>$userData['company_name'],'company_address'=>'','phone_number'=>$userData['person_phone'],'create_date'=>date('Y-m-d H:i:s'),'type'=>$type);
			try{
				$returnData['id'] = DataController::insertData('customer_request',$customerFields);
				if($returnData['id']>0){
					$returnData['error'] = 0;
					$returnData['message'] = "Request send";
				}
			}catch(Exception $e){
				$this->logger->addInfo($e->getMessage());
				$returnData['error'] = "3";
				$returnData['message'] = "Internal server error";
			}			
		} else {
			$returnData['error'] = 1;
			$returnData['verification'] = 2;
			$returnData['message'] = "Password and confirm password not match.";
		}
		return $returnData;
	}
	
	/**
	* Customer Login
	*/
	
	private function checkCustomerLogin($email,$password){
		/*check from db*/
		$checkUser = array();
		$queryLogin = "SELECT c.id,c.first_name,c.last_name,c.email,c.company_id,co.company_name,c.contact_id,c.type , c.status, c.phone_number FROM customers as c INNER JOIN company as co ON co.id = c.company_id WHERE c.email=? AND c.password=?";
		$loginStmt = $this->db->prepare($queryLogin);
		$loginStmt->execute([$email,md5($password)]);
		if($loginStmt->rowCount()>0){
			$checkUser = $loginStmt->fetch();
		}
		return $checkUser;
	}
	
	private function checkCustomerByEmail($email){
		/*check from db*/
		$checkUser = array();
		$queryLogin = "SELECT c.id,c.first_name,c.last_name,c.email,c.company_id,co.company_name,c.contact_id,c.type , c.status, c.phone_number FROM customers as c INNER JOIN company as co ON co.id = c.company_id WHERE c.email=?";
		$loginStmt = $this->db->prepare($queryLogin);
		$loginStmt->execute([$email]);
		if($loginStmt->rowCount()>0){
			$checkUser = $loginStmt->fetch();
		}
		return $checkUser;
	}
	
	/**
	* Customer Login from customer request table
	*/
	
	private function checkCustomerRequestLogin($email,$password){
		/*check from db*/
		$checkUser = array();
		$queryLogin = "SELECT c.id,c.first_name,c.last_name,c.email,c.company_name,c.type , c.status, c.phone_number FROM customer_request as c  WHERE c.email=? AND c.password=? ORDER BY id DESC LIMIT 1";
		$loginStmt = $this->db->prepare($queryLogin);
		$loginStmt->execute([$email,md5($password)]);
		if($loginStmt->rowCount()>0){
			$checkUser = $loginStmt->fetch();
		}
		return $checkUser;
	}
	
	/*
	* Create Agreement Draft file
	*/
	
	private function createDraftFile($folderID,$fileURL,$companyName,$title){		
		$fileName = json_encode(array());
		$sendFileData = array('file_id'=>$fileURL,'folder_id'=>$folderID,'company_name'=>$companyName,'file_title'=>$title);	
		$url = DataController::getBackendUrl();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url.'customers/draftFileInCustomer');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $sendFileData);
		$response = curl_exec($ch);		
		if (!curl_errno($ch)) {
			$fileName = $response;
		} else {
			$this->logger->addInfo($e->getMessage());
		}
		curl_close ($ch);
		return $fileName;
	}
	
	/**
	* Rename agreement draft file
	*/
	private function renameDraftFile($fileURL,$companyName){		
		$fileName = json_encode(array());
		$sendFileData = array('file_id'=>$fileURL,'company_name'=>$companyName);
		$url = DataController::getBackendUrl();		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url.'customers/renameDraftFileInCustomer');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $sendFileData);
		$response = curl_exec($ch);		
		if (!curl_errno($ch)) {
			$fileName = $response;
		} else {
			$this->logger->addInfo($e->getMessage());
		}
		curl_close ($ch);
		return $fileName;
	}
	
	/**
	* upload File
	*/
	
	private function uploadFile($data,$folderID = ""){
		$fileName = array();
		$url = DataController::getBackendUrl();		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url.'customers/store_file_upload?parent_id='.$folderID);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($ch);
		if (!curl_errno($ch)) {
			try{
				$response = json_decode($response,true);
				$fileName = $response;
			}catch(Exception $e){
				$this->logger->addInfo($e->getMessage());
			}			
		} else {
			$this->logger->addInfo($e->getMessage());
		}
		return $fileName;
	}
	
	/**
	*	Companies
	*	return list of companies based on search
	*/
	
	public function search_companies($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		try{
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization===true){
				$postData = $req->getParsedBody();
				$searchString = "";
				$sector = "";
				$cat = "";
				$subCat = "";
				$tech = "";
				$subTech = "";
				$sort = "";
				$sortBy = "";
				$users = "";
				$industry = "";
				$company_size = "";
				$no_of_size = "";
				$label = "";
				$specialist = "";
				$filterLinkedIn = "";
				$extend = false;
				$start = 0;
				$end = 500;
				if(isset($postData['q'])){
					$searchString = $postData['q'];
				}
				if(isset($postData['sector'])){
					$sector = $postData['sector'];
				}
				if(isset($postData['category'])){
					$cat = $postData['category'];
				}
				if(isset($postData['sub_category'])){
					$subCat = $postData['sub_category'];
				}
				if(isset($postData['technology'])){
					$tech = $postData['technology'];
				}
				if(isset($postData['sub_technology'])){
					$subTech = $postData['sub_technology'];
				}
				if(isset($postData['sort_field'])){
					$sort = $postData['sort_field'];
				}
				if(isset($postData['sort_by'])){
					$sortBy = $postData['sort_by'];
				}
				if(isset($postData['users'])){
					$users = $postData['users'];
				}
				if(isset($postData['industry'])){
					$industry = $postData['industry'];
				}
				if(isset($postData['no_of_size'])){
					$no_of_size = $postData['no_of_size'];
				}
				if(isset($postData['important'])){
					$label = $postData['important'];
				}
				if(isset($postData['specialist'])){
					$specialist = $postData['specialist'];
				}
				if(isset($postData['linkedin'])){
					$filterLinkedIn = $postData['linkedin'];
				}
				if(isset($postData['offset'])){
					$start = $postData['offset'];
				}
				if(isset($postData['end'])){
					$end = $postData['end'];
					if($end>500){
						$end = 500;
					}
				}
				if(isset($postData['extend'])){
					$extend = $postData['extend'];
				}
				if(is_array($industry)){
					$inds = array();
					foreach($industry as $ind){
						$inds[] = '"'.$ind.'"';
					}
					$industry = $inds;
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
				if($sort==""){
					$sort = 'c.company_name';
				}
				if($sortBy==""){
					$sortBy = 'ASC';
				}
				$leadID = 0;
				$activity = 0;
				$invited = 2;
				$data = DataController::companyOptimizeListWithPaging($searchString,$sector,$cat,$subCat,$tech,$subTech,$users,$filterLinkedIn,$industry,$company_size,$no_of_size,$label,$specialist,$sort,$sortBy,$start,$end,$leadID,$activity,$invited,$extend);
				$returnData = array('status'=>200,'message'=>'','data'=>$data);
			}
		}catch(Exception $e){
			$this->logger->addInfo($e->getMessage());
			$returnData = array('status'=>500,'message'=>'Internal server error','error_code'=>500);
		}
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	public function find_free_busy_time_slot($app,$req,$resp,$args = []){
		$returnData = array('status'=>200,'message'=>'','data'=>array());
		$headers = $req->getHeaders();
		$auth = $headers['HTTP_AUTHORIZATION'];
		try{
			$checkAuthorization = false;
			if(isset($auth[0]) && $auth[0]!="" && $auth[0] != null){
				$checkAuthorization = DataController::checkToken($auth[0]);
			}
			if($checkAuthorization === true){
				$postData = $req->getParsedBody();
				/*Find Docket Person*/
				$docketNumber = $postData['docket_number'];
				$docketNumber = DataController::decode($docketNumber);
				if($docketNumber>0){
					$stmt = $this->db->prepare("SELECT li.person_email FROM licenses as li INNER JOIN litigations as l ON l.serial_number = li.serial_number WHERE li.license_number=? LIMIT 1");
					$stmt->execute([$docketNumber]);
					$num_rows = $stmt->rowCount();
					if($num_rows==1){
						$docketData = $stmt->fetch();
						$personEmail = $docketData->person_email;
						$calendarID = "primary";
						/*include event helper file*/
						require_once('/var/www/synpat/backyard/application/libraries/EventServiceHelper.php');
						$service = new EventServiceHelper();	
						echo "<pre>";
						if($personEmail != ""){
							$getCalendarList = $service->getCalendarList();
							print_r($getCalendarList);
							if(count($getCalendarList) > 0){
								foreach($getCalendarList as $calendar){
									$calendarListID = $calendar->id;
									if($calendarListID == $personEmail){
										$calendarID = $calendarListID;
										break;
									}
								}
							}
						}
						$findCalendarID = array("id"=>$calendarID);
						$dateStart = $postData['date'];
						$startTime = $dateStart." 09:00:00";
						$endTime = $dateStart." 19:00:00";
						$maxTime = "";
						$minTime = "";
						$timeslotList = $service->getFreeBusy($findCalendarID,$startTime,$endTime);
						
						print_r($timeslotList);
						if(isset($timeslotList['calendars']) && isset($timeslotList['calendars'][$calendarID])){
							try{
								$minTime = $calendarList['timeMin'];
								$maxTime = $calendarList['timeMax'];
								if(strtotime($maxTime) > strtotime($endTime)){
									$maxTime = $endTime;
								}
								if(strtotime($minTime) < strtotime($startTime)){
									$minTime = $startTime;
								}
							}catch(Exception $e){
								$maxTime = $endTime;
								$minTime = $startTime;
							}
						}
						if($minTime != "" && $maxTime != ""){
							$getRangeList = $this->hoursRange(strtotime($minTime),strtotime($maxTime),60 * 30, 'h:i a');
							echo "<pre>";
							print_r($getRangeList);
						}
					}
				}				
				die;
			}
		}catch(Exception $e){
			
		}	
		die;
		return $resp->withJson($returnData, $returnData['status']);
	}
	
	private function hoursRange( $lower = 0, $upper = 86400, $step = 3600, $format = '' ) {
		$times = array();

		if ( empty( $format ) ) {
			$format = 'g:i a';
		}

		foreach ( range( $lower, $upper, $step ) as $increment ) {
			$increment = gmdate( 'H:i', $increment );

			list( $hour, $minutes ) = explode( ':', $increment );

			$date = new DateTime( $hour . ':' . $minutes );

			$times[(string) $increment] = $date->format( $format );
		}

		return $times;
	}

	
	private function companyOptimizeListWithPaging($search,$sector,$cat="",$subCat="",$tech="",$subTech="",$users="",$linkedin="",$industry=array(),$company_size=array(),$no_of_size="",$label="",$specialist=array(),$sort='c.company_name',$orderBy='ASC',$start,$end,$leadID = 0, $activity = 0,$invited = 2,$rs = false){
		$data = array('count_all'=>0,'data'=>array());
		$allCompanies = array();
		$mainFilter = false;
		if($leadID>0 && $activity>0 && $invited==0){			
			if($activity==1){
				$getLeadCompanyList = DataController::getSalesActivityCompaniesByLead($leadID);
			} else if($activity==2){
				$getLeadCompanyList = DataController::getAcquisitionActivityCompaniesByLead($leadID);
			}
			if(isset($getLeadCompanyList) && count($getLeadCompanyList)>0){
				foreach($getLeadCompanyList as $c){
					$allCompanies[] = $c->id;
				}
			}
		}
		if($linkedin!=""){
			$mainFilter = true;
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
				$no_of_employees = explode(',',$linkedin);
				$noOfEmployeesImplode = str_repeat ('?, ',  count ($no_of_employees) - 1) . '?';
				$allCompaniesImplode = str_repeat ('?, ',  count ($allCompanies) - 1) . '?';
				$queryLinkedin = "SELECT id FROM company WHERE no_of_employees IN ($noOfEmployeesImplode) AND id IN ($allCompaniesImplode)";
				$linkedINStmt = $this->db->prepare($queryLinkedin);
				$linkedINStmt->execute(array_merge($no_of_employees,$allCompanies));	
			} else {
				$no_of_employees = explode(',',$linkedin);
				$noOfEmployeesImplode = str_repeat ('?, ',  count ($no_of_employees) - 1) . '?';
				$queryLinkedin = "SELECT id FROM company WHERE no_of_employees IN ($noOfEmployeesImplode)";
				$linkedINStmt = $this->db->prepare($queryLinkedin);
				$linkedINStmt->execute($no_of_employees);
			}
			if(isset($linkedINStmt)){
				$allCompanies = array();
				if($linkedINStmt->rowCount()>0){
					while($c = $linkedINStmt->fetch()){
						array_push($allCompanies,$c->id);
					}
				}
			}			
		}
		if($label=='0' || $label =='1'){
			$mainFilter = true;
			$listImportantCompanies = array();		
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
			}
			if(count($allCompanies)>0){
				$allCompaniesImplode = str_repeat ('?, ',  count ($allCompanies) - 1) . '?';
				$queryImportantCompanies = "SELECT id FROM company WHERE id IN ($allCompaniesImplode) AND label=?";
				$imptCompaniesStmt = $this->db->prepare($queryImportantCompanies);
				$imptCompaniesStmt->execute(array_merge($allCompanies,array($label)));
			} else {
				$queryImportantCompanies = "SELECT id FROM company WHERE label=?";
				$imptCompaniesStmt = $this->db->prepare($queryImportantCompanies);
				$imptCompaniesStmt->execute([$label]);
			}
			if(isset($imptCompaniesStmt)){
				$allCompanies = array();
				if($imptCompaniesStmt->rowCount()>0){
					while($c = $imptCompaniesStmt->fetch()){
						array_push($allCompanies,$c->id);
					}
				}
			}	
		}
		if(count($company_size)>0){
			$mainFilter = true;
			$listCompanySize = array();		
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
			}
			if(count($allCompanies)>0){
				$allCompaniesImplode = str_repeat ('?, ',  count ($allCompanies) - 1) . '?';
			}
			foreach($company_size as $cs){
				if(count($allCompanies)>0){
					$queryCompanySize = "SELECT id FROM company WHERE id IN ($allCompaniesImplode) AND company_size=?";
					$companySizeStmt = $this->db->prepare($queryCompanySize);
					$companySizeStmt->execute(array_merge($allCompanies,array($cs)));
				} else {
					$queryCompanySize = "SELECT id FROM company WHERE company_size=?";
					$companySizeStmt = $this->db->prepare($queryCompanySize);
					$companySizeStmt->execute([$cs]);
				}
				if(isset($companySizeStmt)){
					if($companySizeStmt->rowCount()>0){
						while($c = $companySizeStmt->fetch()){
							array_push($listCompanySize,$c->id);
						}
					}
				}
			}
			$allCompanies = array();
			if(count($listCompanySize)>0){
				$allCompanies = $listCompanySize;
			}	
		}
		if(count($industry)>0){
			$mainFilter = true;
			$listIndustries = array();
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
			}
			if(count($allCompanies)>0){
				$allCompaniesImplode = str_repeat ('?, ',  count ($allCompanies) - 1) . '?';
			}
			foreach($industry as $ind){
				if(count($allCompanies)>0){
					$queryIndustry = "SELECT id FROM company WHERE id IN ($allCompaniesImplode) AND industry=?";
					$industryStmt = $this->db->prepare($queryIndustry);
					$industryStmt->execute(array_merge($allCompanies),array($ind));
				} else {
					$queryIndustry = "SELECT id FROM company WHERE industry=?";
					$industryStmt = $this->db->prepare($queryIndustry);
					$industryStmt->execute([$ind]);
				}
				if(isset($industryStmt) && $industryStmt->rowCount()>0){
					while($c = $industryStmt->fetch()){
						array_push($listIndustries,$c->id);
					}
				}
			}
			$allCompanies = array();
			if(count($listIndustries)>0){
				$allCompanies = $listIndustries;
			}
		}
		if(count($specialist)>0){
			$mainFilter = true;
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
			}
			$whereS = "";
			foreach($specialist as $spec){
				$whereS .="specialties LIKE '%".$spec."%' OR ";
			}
			$whereS = substr($whereS,0,-3);
			$queryS = "SELECT id FROM company WHERE ";
			if(count($allCompanies)>0){
				$queryS .= " id IN (".implode(',',$allCompanies).") AND ";
			}
			$queryS .= " (" .$whereS. ") ";
			try{
				$resultS = $this->db->prepare($queryS);
				$resultS->execute();
				if($resultS->rowCount()>0){
					$allCompanies = array();
					while($c = $resultS->fetch()){
						array_push($allCompanies,$c->id);
					}
				}
			}catch(Exception $e){
				
			}
		}
		if($no_of_size!=""){
			$mainFilter = true;
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
				$queryEmployeeSize = "SELECT id FROM company WHERE no_of_employees IN (".$no_of_size.") AND id IN (".implode(',',$allCompanies).")";
			} else {
				$queryEmployeeSize = "SELECT id FROM company WHERE no_of_employees IN (".$no_of_size.")";
			}
			$queryEmployeeSizeResult = $this->db->prepare($queryEmployeeSize);
			$queryEmployeeSizeResult->execute();
			$allCompanies = array();
			if($queryEmployeeSizeResult->rowCount()>0){
				$getCS = $queryEmployeeSizeResult->result();
				while($c = $queryEmployeeSizeResult->fetch()){
					array_push($allCompanies,$c->id);
				}
			}
		}
		if($cat!="" && $subCat!=""){
			try{
				$mainFilter = true;
				$jsonCat = explode(',',$cat);	
				$catImplode = str_repeat ('?, ',  count ($jsonCat) - 1) . '?';
				$spQuery = "SELECT p.customer_id FROM preferences as p WHERE p.preference_id IN($catImplode)";
				$catStmt = $this->db->prepare($spQuery);
				$catStmt->execute($jsonCat);
				if($catStmt->rowCount()>0){
					$getLs = $spQuery->result();
					$scList = array();
					while($ls = $catStmt-fetch()){
						array_push($scList,$ls->customer_id);
					}
					$jsonSubCat = explode(',',$subCat);
					if(count($allCompanies)>0){
						$scList = array_combine($scList,$allCompanies);
						$scList = array_unique($scList);
					}
					$scListImplode = str_repeat ('?, ',  count ($scList) - 1) . '?';
					$jsonSubCatImplode = str_repeat ('?, ',  count ($jsonSubCat) - 1) . '?';
					$spQuery = "SELECT p.customer_id FROM preferences as p WHERE p.preference_id IN($jsonSubCatImplode) AND p.customer_id IN($scListImplode)";
					$catStmt = $this->db->prepare($spQuery);
					$catStmt->execute(array_merge($scList,$jsonSubCat));
					if($catStmt->rowCount()>0){
						$scList = array();
						$allCompanies = array();
						while($ls = $catStmt->fetch()){
							array_push($allCompanies,$ls->customer_id);
						}
					} else {
						$allCompanies = array();
					}
				}								
			}catch(Exception $e){
			}
		} else if($cat!=""){
			try{
				$mainFilter = true;
				$jsonCat = explode(',',$cat);				
				$catImplode = str_repeat ('?, ',  count ($jsonCat) - 1) . '?';
				$spQuery = "SELECT p.customer_id FROM preferences as p WHERE p.preference_id IN($catImplode)";
				if(count($allCompanies)>0){
					$allCompaniesImplode = str_repeat ('?, ',  count ($allCompanies) - 1) . '?';
					$spQuery .= " AND p.customer_id IN($allCompaniesImplode)";
				}
				$catStmt = $this->db->prepare($spQuery);
				if(count($allCompanies)>0){
					$catStmt->execute(array_merge($jsonCat,$allCompanies));
				} else {
					$catStmt->execute($jsonCat);
				}
				if($catStmt->rowCount()>0){
					$allCompanies = array();
					while($ls = $catStmt->fetch()){
						array_push($allCompanies,$ls->customer_id);
					}
				} else {
					$allCompanies = array();
				}			
			}catch(Exception $e){
			}
		}
		$checkU = false;
		if($users!=""){
			$mainFilter = true;
			$explodeUsers = explode(',',$users);
			$companyList = array();
			$excludeCompanies = array();
			foreach($explodeUsers as $u){
				$queryString = "";
				if((int)$u>0){
					$queryString = "SELECT count(id) as countUsers,company_id FROM contacts ";
					if(count($allCompanies)>0){
						$allCompaniesImplode = str_repeat ('?, ',  count ($allCompanies) - 1) . '?';
						$queryString .= " WHERE company_id IN($allCompaniesImplode) ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers =".$u;
					$queryFindCompany = $this->db->prepare($queryString);
					if(count($allCompanies)>0){
						$queryFindCompany->execute($allCompanies);
					} else {
						$queryFindCompany->execute();
					}
					if($queryFindCompany->rowCount()>0){
						$companies = array();
						while($c = $queryFindCompany->fetch()){
							array_push($companies,$c);
						}
						$companyList = array_merge($companyList,$companies);
					}
				} else if((int)$u==0){
					if($checkU === false){
						$checkU = true;
					}
				}					
			}
			if($checkU===true){
				if(count($companyList)>0){
					$aCompanies = array();
					foreach($companyList as $company){
						$aCompanies[] = $company->company_id;
					}
					$allCompanies = array_merge($allCompanies,$aCompanies);	
					$allCompanies = array_unique($allCompanies);
				} else {
					$queryString = "SELECT count(id) as countUsers,company_id FROM contacts ";
					if(count($allCompanies)>0){
						$allCompaniesImplode = str_repeat ('?, ',  count ($allCompanies) - 1) . '?';
						$queryString .= " WHERE company_id IN($allCompaniesImplode) ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers >0";
					$queryFindCompany = $this->db->prepare($queryString);
					if(count($allCompanies)>0){
						$queryFindCompany->execute($allCompanies);
					} else {
						$queryFindCompany->execute();
					}
					if($queryFindCompany->rowCount()>0){
						$exCompany = array();
						while($c = $queryFindCompany->fetch()){
							array_push($exCompany,$c->company_id);
						}
						if(count($allCompanies)>0){
							$allCompanies  = array_diff($allCompanies,$exCompany);
						} else {
							$exCompanyImplode = str_repeat ('?, ',  count ($exCompany) - 1) . '?';
							$queryC = "SELECT distinct(id) as company_id FROM company WHERE id NOT IN ($exCompanyImplode)";
							$queryFindCompany = $this->db->prepare($queryC);
							$queryFindCompany->execute($exCompany);
							if($queryFindCompany->rowCount()>0){
								$allCompanies = array();
								while($company = $queryFindCompany->fetch()){
									array_push($allCompanies,$company->company_id);
								}
							}
						}
					}
				}
			} else {
				$allCompanies = array();
				if(count($companyList)>0){
					foreach($companyList as $company){
						$allCompanies[] = $company->company_id;
					}
					$allCompanies = array_unique($allCompanies);
				}
			}
		}
		$checkEntry = true;
		if($mainFilter===true && count($allCompanies)==0){
			$checkEntry = false;
		}
		$category = array();
		$subCategory = array();
		$subTechnology = array();
		if($checkEntry===true):
			$querySELECT = "";
			$queryJOIN = "";
			$queryWHERE = array();
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$queryJOIN = " INNER JOIN technology_preference as t ON t.company_id = c.id ";
						$queryWHERE[] = " t.preference_id IN (".implode(',',$allTech).") ";
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$queryJOIN = " INNER JOIN technology_preference as t ON t.company_id = c.id ";
						$queryWHERE[] = " t.preference_id IN (".implode(',',$jsonCat).") ";
					}					
				}catch(Exception $e){
				}
			}
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
				$queryWHERE[] = " c.id IN (".implode(',',$allCompanies).") ";
			}
			if(!empty($sector)){
				if($sector=='Unclassify'){
					$queryWHERE[] = 'c.id NOT IN (SELECT company_id FROM company_sector as temp_c)';	
				} else {
					$queryJOIN = "INNER JOIN company_sector as cs ON c.id = cs.company_id ";
					$queryWHERE[] = " cs.sector_id IN (".$sector.") ";
				}
			}
			if(!empty($search)){							
				$queryWHERE[] = 'c.company_name LIKE "%'.$search.'%"';
			}
			
			$querySELECT = "SELECT count(c.id) as countRecords FROM company as c ";
			if(count($queryWHERE)>0){
				$queryWHERE = implode(' AND ',$queryWHERE);
			} else {
				$queryWHERE = "";
			}
			$buildQuery = $querySELECT." ".$queryJOIN." ";
			if($queryWHERE!=""){
				$buildQuery .=" WHERE ".$queryWHERE;
			}			
			$resultCount = $this->db->prepare($buildQuery);
			$resultCount->execute();
			if($resultCount->rowCount()){
				$getCount = $resultCount->fetch();
				$data['count_all'] = $getCount->countRecords;
				$querySELECT = "SELECT distinct(c.id) as companyID, c.id, c.company_name,c.web_address, c.linkedin_url,c.scrapped_date,c.scrapped_profile_date,c.industry,c.no_of_employees,c.company_size,c.company_size_type,c.specialties,c.scrape_p, (SELECT count(*) as company_users FROM contacts WHERE company_id=c.id) as company_users,'' as sectorName, '' as department_names,'' as sub_department_names, '' as technology_names, '' as sub_technology_names , c.label, c.revenue FROM company as c ";
				
				$buildQuery = $querySELECT." ".$queryJOIN." ";
				if($queryWHERE!=""){
					$buildQuery .=" WHERE ".$queryWHERE;
				}
				$buildQuery .=" ORDER BY ".$sort." ".$orderBy;				
				if($end>0){
					$buildQuery .=" LIMIT ".$start.",".$end;
				}			
				$query = $this->db->prepare($buildQuery);
				$query->execute();
				$mapTech = array();
				$mapCategpry = array();		
				$mapSubCategory = array();
				if ($query->rowCount() > 0) {
					$companyDataResult = array();
					while($r = $query->fetch()){
						array_push($companyDataResult,$r);
					}
					if($rs === true){
						$companyIDs = array();
						$started = microtime(true);
						for($i=0;$i<count($companyDataResult);$i++){
							$companyIDs[] =  $companyDataResult[$i]->id;
						}
						$started = microtime(true);
						$sectorsList = DataController::findAllCompanySectorsOptimized($companyIDs);
						$sectorsCompanies = array();
						if(count($sectorsList)>0){
							foreach($sectorsList as $s){
								$i=0;
								foreach($companyDataResult as $co){
									if($co->id == $s->company_id){
										$sectorsCompanies[] = $s->company_id;
										$sectorName = "";
										if(isset($companyDataResult[$i]->sectorName)){
											$sectorName = $companyDataResult[$i]->sectorName;
										}
										if($sectorName!=""){
											$sectorName .=", ";
										}
										$sectorName .= $s->sectorName;
										$companyDataResult[$i]->sectorName = $sectorName;
										break;
									}
									$i++;
								}						
							}
						}
						if(count($sectorsCompanies)>0){
							$sectorsCompanies = array_unique($sectorsCompanies);
							/*Get Categories and Sub Categories*/
							$getDepartmentsList = DataController::findAllCompanyPreferenceWithNameSub($sectorsCompanies,1);
							if(count($getDepartmentsList)>0){
								foreach($getDepartmentsList as $deptt){
									$i=0;
									foreach($companyDataResult as $co){
										if($co->id == $deptt->customer_id){
											if($deptt->parent==0){
												$department_names = "";
												if(isset($companyDataResult[$i]->department_names)){
													$department_names = $companyDataResult[$i]->department_names;
												}
												if($department_names!=""){
													$department_names .=", ";
												}
												$department_names .= $deptt->name;
												$companyDataResult[$i]->department_names = $department_names;
												if(!in_array($deptt->id,$mapCategpry)){
													$mapCategpry[] = $deptt->id;
													$category[] = array('id'=>$deptt->id,'name'=>$deptt->name);
												}
											} else {
												$sub_department_names = "";
												if(isset($companyDataResult[$i]->sub_department_names)){
													$sub_department_names = $companyDataResult[$i]->sub_department_names;
												}
												if($sub_department_names!=""){
													$sub_department_names .=", ";
												}
												$sub_department_names .= $deptt->name;
												$companyDataResult[$i]->sub_department_names = $sub_department_names;
												if(!in_array($deptt->id,$mapSubCategory)){
													$mapSubCategory[] = $deptt->id;
													$subCategory[] = array('id'=>$deptt->id,'name'=>$deptt->name);
												}
											}
											break;
										}
										$i++;
									}
									
								}						
							}
						}
						$technologies = DataController::findAllCompaniesTechnologiesPreferenceWithNameSub($companyIDs,0);
						if(count($technologies)>0){
							$techCompanyIDs = array();
							foreach($technologies as $tech){
								$i=0;
								foreach($companyDataResult as $co){
									if($co->id == $tech->company_id){
										$techCompanyIDs[]=$tech->company_id;
										$technologyNames = "";
										if(isset($companyDataResult[$i]->technology_names)){
											$technologyNames = $companyDataResult[$i]->technology_names;
										}
										if($technologyNames!=""){
											$technologyNames .=", ";
										}
										$technologyNames .= $tech->name;
										$companyDataResult[$i]->technology_names = $technologyNames;
									}
									$i++;
								}
							}
							$techCompanyIDs = array_unique($techCompanyIDs);
							$subTechnologies = DataController::findAllCompaniesTechnologiesPreferenceWithNameSub($techCompanyIDs,1);
							if(count($subTechnologies)>0){
								$subTechCompanyIDs = array();
								foreach($subTechnologies as $tech){
									$i=0;
									foreach($companyDataResult as $co){
										if($co->id == $tech->company_id){
											$subTechCompanyIDs[]=$tech->company_id;
											$technologyNames = "";
											if(isset($companyDataResult[$i]->sub_technology_names)){
												$technologyNames = $companyDataResult[$i]->sub_technology_names;
											}
											if($technologyNames!=""){
												$technologyNames .=", ";
											}									
											if(!in_array($tech->id,$mapTech)){
												$mapTech[] = $tech->id;
												$subTechnology[] = array('id'=>$tech->id,'name'=>$tech->name);
												$technologyNames .= $tech->name;
												$companyDataResult[$i]->sub_technology_names = $technologyNames;
											}
										}
										$i++;
									}
								}
								$subTechCompanyIDs = array_unique($subTechCompanyIDs);
								$subsubTechnologies = DataController::findAllCompaniesTechnologiesPreferenceWithNameSub($subTechCompanyIDs,2);
								if(count($subsubTechnologies)>0){
									foreach($subsubTechnologies as $tech){
										$i=0;
										foreach($companyDataResult as $co){
											if($co->id == $tech->company_id){
												$technologyNames = "";
												if(isset($companyDataResult[$i]->sub_technology_names)){
													$technologyNames = $companyDataResult[$i]->sub_technology_names;
												}
												if($technologyNames!=""){
													$technologyNames .=", ";
												}										
												if(!in_array($tech->id,$mapTech)){
													$mapTech[] = $tech->id;
													$subTechnology[] = array('id'=>$tech->id,'name'=>$tech->name);
													$technologyNames .= $tech->name;
													$companyDataResult[$i]->sub_technology_names = $technologyNames;
												}
											}
											$i++;
										}
									}
								}
							}					
						}						
					}
					$data['data'] = $companyDataResult;
				}
			}			
		endif;
		$data['cat'] = $category;
		$data['sub_cat'] = $subCategory;
		$data['sub_tech'] = $subTechnology;
		return $data; 
	}
	
	private function findAllCompanySectorsOptimized($companyIDs){
		$data = array();
		if(count($companyIDs)>0){
			$companyImplode = str_repeat ('?, ',  count ($companyIDs) - 1) . '?';
			$queryS = "SELECT s.name as sectorName, s.id as sectorID, cs.company_id FROM company_sector as cs LEFT JOIN sectors as s ON s.id = cs.sector_id WHERE cs.company_id IN ($companyImplode)";
			$sectorStmt = $this->db->prepare($queryS);
			$sectorStmt->execute($companyIDs);
			$data = array();
			if ($sectorStmt->rowCount() > 0) {
				while($s = $sectorStmt->fetch()){
					array_push($data,$s);
				}
			}
		}
		return $data;
	}
	
	private function findAllCompanyPreferenceWithNameSub($companyIDs,$type){
		$companyImplode = str_repeat ('?, ',  count ($companyIDs) - 1) . '?';
		$queryS = "SELECT c.*,p.customer_id FROM technology_preference as p INNER JOIN category as c ON c.id = p.preference_id WHERE p.customer_id IN ($companyImplode) AND c.type=?";
		$technologyStmt = $this->db->prepare($queryS);
		$technologyStmt->execute(array_merge($companyIDs,array($type)));
		$data = array();
		if ($technologyStmt->rowCount() > 0) {
            while($r = $technologyStmt->fetch()){
				array_push($data,$r);
			}
        }
		return $data;
	}
	
	private function findAllCompaniesTechnologiesPreferenceWithNameSub($companyIDs,$type){
		$companyImplode = str_repeat ('?, ',  count ($companyIDs) - 1) . '?';
		$queryS = "SELECT c.*,p.company_id FROM technology_preference as p INNER JOIN category as c ON c.id = p.preference_id WHERE p.company_id IN ($companyImplode) AND c.type=?";
		$technologyStmt = $this->db->prepare($queryS);
		$technologyStmt->execute(array_merge($companyIDs,array($type)));
		$data = array();
		if ($technologyStmt->rowCount() > 0) {
            while($r = $technologyStmt->fetch()){
				array_push($data,$r);
			}
        }
		return $data; 
	}
	
	private function refreshToken($token,$key) {
		echo "adasda";die;
		JWT::$leeway = 720000;
		$decoded = (array) JWT::decode($token, $key, ['HS256']);
		// TODO: test if token is blacklisted
		$decoded['iat'] = time();
		$decoded['exp'] = time() + (14400 * 24 * 15);
		return JWT::encode($decoded, $key);
    }

	
	private function checkToken($auth,$t=0){
		$validate = false;
		try{
			if($auth!=""){
				if($t == 1) {
					$checkAuth = "SELECT id FROM docket_tokens WHERE token=? AND date_expiration>=? ORDER BY id DESC LIMIT 1";
					$condition = array($auth,strtotime('now'));
					
				} else {
					$checkAuth = "SELECT id FROM docket_tokens WHERE token=? ORDER BY id DESC LIMIT 1";
					$condition = array($auth);
				}
				$authStmt = $this->db->prepare($checkAuth);
				/**/
				$authStmt->execute($condition);
				if($authStmt->rowCount()>0){
					$validate = true;
				}
			}
		}catch(Exception $e){
		}
		return $validate;
	}
	
	private function getCountRequestingCompanies($docketNumber) {
		$count = 0;
		$queryPotentialParticipants = "SELECT count(a.id) as potentialParticipants FROM potential_participates as a JOIN licenses as l ON l.id = a.license_id JOIN litigations as lead ON lead.serial_number = l.serial_number JOIN customers as cu ON cu.id = a.customer_id JOIN contacts as c ON c.id = cu.contact_id JOIN company as co ON co.id = c.company_id LEFT JOIN company as target ON target.id = a.company_id WHERE a.status IN (0, 1, 2) AND a.type IN (0, 1, 2) AND lead.serial_number = ?";
		$participantsStmt = $this->db->prepare($queryPotentialParticipants);
		$participantsStmt->execute([(int)$docketNumber]);
		$participantCount = $participantsStmt->fetch();
		if($participantCount->potentialParticipants>0){
			$count = $participantCount->potentialParticipants;
		}
		return $count;
	}
	
	private function getPatentCount($leadID) {
		$count = 0;
		$queryPatents = "SELECT count(id) as patent_count FROM lead_patent WHERE lead_id=?";
		$patentsStmt = $this->db->prepare($queryPatents);
		$patentsStmt->execute([$leadID]);
		$patentCount = $patentsStmt->fetch();
		if($patentCount->patent_count>0){
			$count = $patentCount->patent_count;
		}
		return $count;
	}
	
	private function getPatentList($leadID){
		$list = array();
		$queryPatents = "SELECT id,patent_number FROM lead_patent WHERE lead_id=? ORDER BY patent_number ASC";
		$patentsStmt = $this->db->prepare($queryPatents);
		$patentsStmt->execute([$leadID]);
		if($patentsStmt->rowCount()>0){
			while($row = $patentsStmt->fetch()){
				array_push($list,$row);
			}
		}
		return $list;
	} 
	private function getLeadFolderID($docketNumber,$folderColumn){
		$folderID = "";
		$queryLead = "SELECT {$folderColumn} from litigations WHERE serial_number=?";
		$leadStmt = $this->db->prepare($queryLead);
		$leadStmt->execute([$docketNumber]);
		if($leadStmt->rowCount()>0){
			$leadData = $leadStmt->fetch();
			$folderID = $leadData->{$folderColumn};
		}
		if($folderID == null){
			$folderID = "";
		}
		return $folderID;
	} 
	private function getLeadID($docketNumber){
		$ID = 0;
		$queryLead = "SELECT id from litigations WHERE serial_number=?";
		$leadStmt = $this->db->prepare($queryLead);
		$leadStmt->execute([$docketNumber]);
		if($leadStmt->rowCount()>0){
			$leadData = $leadStmt->fetch();
			$ID = $leadData->id;
		}
		return $ID;
	}
	
	private function getClaimchartOrderName($leadID){
		$orderName = "";
		$queryOrder = "SELECT order_name from acquisition WHERE lead_id=?";
		$orderStmt = $this->db->prepare($queryOrder);
		$orderStmt->execute([$leadID]);
		if($orderStmt->rowCount()>0){
			$orderData = $orderStmt->fetch();
			$orderName = $orderData->order_name;
		}
		return $orderName;
	}
	
	private function getDocketID($docketNumber){
		$ID = 0;
		$queryDocket = "SELECT id from licenses WHERE serial_number=?";
		$docketStmt = $this->db->prepare($queryDocket);
		$docketStmt->execute([$docketNumber]);
		if($docketStmt->rowCount()>0){
			$docketData = $docketStmt->fetch();
			$ID = $docketData->id;
		}
		return $ID;
	}
	/*clean string with semicolon,colon,html tags*/
	private function cleanString($string){
		$string = trim($string);
		$string = strip_tags($string);
		$string = preg_replace("/;/", "",$string);
		$string = preg_replace("/'/", "",$string);
		$string = preg_replace("/\"/", "",$string);
		$regex = '/(\s|\\\\[rntv]{1})/';
		$string = preg_replace($regex, ' ', $string);
		return $string;
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
	
	/*Single company data*/
	private function companyData($companyID){
		$getDataAppC = array();
		$queryParent = "SELECT company_name,company_logo,linkedin_url,parent_c FROM company WHERE id=?";
		$parentStmt = $this->db->prepare($queryParent);
		$parentStmt->execute([$companyID]);
		if($parentStmt->rowCount()>0){
			$getDataAppC = $parentStmt->fetch();
		}
		return $getDataAppC;
	}
	
	/*Customer email*/
	private function checkEmail($email){
		$getDataAppC = 0;
		$queryParent = "SELECT count(id) as customerCount FROM customers WHERE email=?";
		$parentStmt = $this->db->prepare($queryParent);
		$parentStmt->execute([$email]);
		if($parentStmt->rowCount()>0){
			$getData = $parentStmt->fetch();
			$getDataAppC = $getData->customerCount;
		}
		return $getDataAppC;
	}
	
	/*get customer user data */
	private function getCustomerInfoByID($ID){
		$getData = array();
		$queryParent = "SELECT id,email FROM customers WHERE id=?";
		$parentStmt = $this->db->prepare($queryParent);
		$parentStmt->execute([$ID]);
		if($parentStmt->rowCount()>0){
			$getData = $parentStmt->fetch();
		}
		return $getData;
	}
	
	/*Delete user from customer account*/
	private function deleteToken($userID){
		$getData = 0;
		if($userID > 0) {
			$queryParent = "DELETE FROM docket_tokens WHERE user_id=?";
			$parentStmt = $this->db->prepare($queryParent);
			$parentStmt->execute([$userID]);
			if($parentStmt->rowCount()>0){
				$getData = 1;
			}
		}		
		return $getData;
	}
	
	/*Delete user from customer account*/
	private function deleteCustomer($ID){
		$getData = 0;
		if($ID > 0) {
			$queryParent = "DELETE FROM customers WHERE id=?";
			$parentStmt = $this->db->prepare($queryParent);
			$parentStmt->execute([$ID]);
			if($parentStmt->rowCount()>0){
				$getData = 1;
			}
		}		
		return $getData;
	}
	
	/*Find Company Logo By ID*/
	private function findCompanyLogoByID($companyID,$companyName,$applicantList,$mode = 1){
		$getDataAppC = array();
		$dataReturn = array('img'=>'','applicant'=>'','applicantList'=>$applicantList,'company_logo'=>'','count'=>0);
		$applicantC = "SELECT company_name,company_logo ,linkedin_url,parent_c FROM company WHERE id=?";
		$applicantStmt = $this->db->prepare($applicantC);
		$applicantStmt->execute([$companyID]);
		$img = "";$nameApplicant="";
		$countRows = $applicantStmt->rowCount();
		if($countRows>0){
			$getDataAppC = $applicantStmt->fetch();
			if($getDataAppC->parent_c>0){
				$getDataAppC = DataController::companyData($getDataAppC->parent_c);			
			}
			if(isset($getDataAppC->company_logo) && $getDataAppC->company_logo!="" && strpos($getDataAppC->company_logo,"http")!==false){
				$dataReturn['count'] = $countRows;
				$dataReturn['applicantList'][]= (object)array('img'=>$getDataAppC->company_logo,'applicant'=>$companyName,'company_name'=>$getDataAppC->company_name);
				$dataReturn['applicant']=$getDataAppC->company_name;
				$dataReturn['img'] = $getDataAppC->company_logo;
				$dataReturn['company_logo'] = $getDataAppC->company_logo;
			}
		}
		return $dataReturn;		
	}
	
	/*Find company logos*/
	private function findCompanyLogo($companyName,$applicantList,$mode = 1){
		$getDataAppC = array();
		$dataReturn = array('img'=>'','applicant'=>'','applicantList'=>$applicantList,'company_logo'=>'','count'=>0);
		$companyName = DataController::formatApplicantA(trim($companyName));
		switch($mode){
			case 1:
				$applicantC = "SELECT company_name,company_logo ,linkedin_url,parent_c FROM company WHERE (company_name = ?) AND  (company_logo <>'' OR parent_c>0) ORDER BY company_name ASC LIMIT 1";
				$applicantStmt = $this->db->prepare($applicantC);
				$companyName = htmlspecialchars_decode(trim($companyName), ENT_NOQUOTES);
				$applicantStmt->execute([$companyName]);
				$img = "";$nameApplicant="";
				$countRows = $applicantStmt->rowCount();
				if($countRows == 0){
					$applicantC = "SELECT c.company_name,c.company_logo ,c.linkedin_url,c.parent_c FROM company as c INNER JOIN company_other_names as co ON co.company_id = c.id WHERE (co.name = ? ) AND  (c.company_logo <>'' OR c.parent_c>0) ORDER BY co.name ASC LIMIT 1";
					$applicantStmt = $this->db->prepare($applicantC);
					$companyName = htmlspecialchars_decode(trim($companyName), ENT_NOQUOTES);
					//$applicantStmt->bindParam(':cName', $companyName, PDO::PARAM_STR);
					/*$companyName = str_replace(',','',htmlspecialchars_decode(trim($companyName), ENT_NOQUOTES)); */
					$applicantStmt->execute([$companyName]);
					/*$applicantStmt->debugDumpParams();*/
					$img = "";$nameApplicant="";
					$countRows = $applicantStmt->rowCount();
				}
				
				if($countRows>0){
					$getDataAppC = $applicantStmt->fetch();
					if($getDataAppC->parent_c>0){
						$getDataAppC = DataController::companyData($getDataAppC->parent_c);			
					}
					if(isset($getDataAppC->company_logo) && $getDataAppC->company_logo!="" && strpos($getDataAppC->company_logo,"http")!==false){
						$dataReturn['count'] = $countRows;
						$dataReturn['applicantList'][]= (object)array('img'=>$getDataAppC->company_logo,'applicant'=>$companyName,'company_name'=>$getDataAppC->company_name);
						$dataReturn['applicant']=$getDataAppC->company_name;
						$dataReturn['img'] = $getDataAppC->company_logo;
						$dataReturn['company_logo'] = $getDataAppC->company_logo;
					}
				} 
			break;
			case 2:
				$nameC = explode(" ",$companyName);
				if(count($nameC)>2){
					$searchWord = $nameC[0]." ".$nameC[1]." ".trim($nameC[2]);
					$searchWord = htmlspecialchars_decode(trim($searchWord), ENT_NOQUOTES);
					$searchWord = str_replace(",","",$searchWord);
					$searchWord = '"'.$searchWord.'"';
					$applicantC = "SELECT company_name,company_logo ,linkedin_url,parent_c FROM company WHERE MATCH (company_name,other1,other2,other3,other4,other5,other6) AGAINST (? IN BOOLEAN MODE)  AND  (company_logo <>'' OR parent_c>0)  ORDER BY company_name ASC LIMIT 1";
					$applicantStmt = $this->db->prepare($applicantC);
					$applicantStmt->execute([$searchWord]);
					$countRows = $applicantStmt->rowCount();
					if($countRows>0){
						$searchWord = substr($searchWord,1,-1);
						$getDataAppC = $applicantStmt->fetch();
						if($getDataAppC->parent_c>0){
							$getDataAppC = DataController::companyData($getDataAppC->parent_c);						
						}					
						if(isset($getDataAppC->company_logo) && $getDataAppC->company_logo!="" && strpos($getDataAppC->company_logo,"http")!==false){
							$dataReturn['applicantList'][]= (object)array('img'=>$getDataAppC->company_logo,'applicant'=>$searchWord,'company_name'=>$getDataAppC->company_name);
							$dataReturn['count'] = $countRows;
							$dataReturn['applicant']=$getDataAppC->company_name;
							$dataReturn['img'] = $getDataAppC->company_logo;
							$dataReturn['company_logo'] = $getDataAppC->company_logo;
						}
					}
				}
			break;
			case 3:
				$nameC = explode(" ",$companyName);
				if(count($nameC)>1){
					$searchWord = $nameC[0]." ".trim($nameC[1]);
					$searchWord = htmlspecialchars_decode(trim($searchWord), ENT_NOQUOTES);
					$searchWord = str_replace(",","",$searchWord);
					$searchWord = '"'.$searchWord.'"';
					$applicantC = "SELECT company_name,company_logo ,linkedin_url,parent_c FROM company WHERE MATCH (company_name,other1,other2,other3,other4,other5,other6) AGAINST (? IN BOOLEAN MODE)  AND  (company_logo <>'' OR parent_c>0)  ORDER BY company_name ASC LIMIT 1";
					$applicantStmt = $this->db->prepare($applicantC);
					$applicantStmt->execute([$searchWord]);
					$countRows = $applicantStmt->rowCount();
					if($countRows>0){
						$searchWord = substr($searchWord,1,-1);
						$getDataAppC = $applicantStmt->fetch();
						if($getDataAppC->parent_c>0){
							$getDataAppC = DataController::companyData($getDataAppC->parent_c);						
						}	
						if(isset($getDataAppC->company_logo) && $getDataAppC->company_logo!="" && strpos($getDataAppC->company_logo,"http")!==false){
							$dataReturn['applicantList'][]= (object)array('img'=>$getDataAppC->company_logo,'applicant'=>$searchWord,'company_name'=>$getDataAppC->company_name);
							$dataReturn['count'] = $countRows;
							$dataReturn['applicant']=$getDataAppC->company_name;
							$dataReturn['img'] = $getDataAppC->company_logo;
							$dataReturn['company_logo'] = $getDataAppC->company_logo;
						}
					}
				}
			break;
			case 4:
				$nameC = explode(" ",$companyName);
				if(count($nameC)>0){
					$searchWord = $nameC[0];
					$searchWord = htmlspecialchars_decode(trim($searchWord), ENT_NOQUOTES);
					$searchWord = str_replace(",","",$searchWord);
					$searchWord = '"'.$searchWord.'"';
					$applicantC = "SELECT company_name,company_logo ,linkedin_url,parent_c FROM company WHERE MATCH (company_name,other1,other2,other3,other4,other5,other6) AGAINST (? IN BOOLEAN MODE)  AND (company_logo <>'' OR parent_c>0)	ORDER BY company_name ASC LIMIT 1";
					$applicantStmt = $this->db->prepare($applicantC);
					$applicantStmt->execute([$searchWord]);
					$countRows = $applicantStmt->rowCount();
					if($countRows>0){
						$searchWord = substr($searchWord,1,-1);
						$getDataAppC = $applicantStmt->fetch();
						if($getDataAppC->parent_c>0){
							$getDataAppC = DataController::companyData($getDataAppC->parent_c);						
						}	
						if(isset($getDataAppC->company_logo) && $getDataAppC->company_logo!="" && strpos($getDataAppC->company_logo,"http")!==false){
							$dataReturn['applicantList'][]= (object)array('img'=>$getDataAppC->company_logo,'applicant'=>$searchWord,'company_name'=>$getDataAppC->company_name);
							$dataReturn['count'] = $countRows;
							$dataReturn['applicant']=$getDataAppC->company_name;
							$dataReturn['img'] = $getDataAppC->company_logo;
							$dataReturn['company_logo'] = $getDataAppC->company_logo;
						}
					}
				} 
			break;
		}
		return $dataReturn;
	}
	/**/
	private function getPaypalData(){
		$payPalData = array();
		$sqlPaypal = "SELECT * FROM ep7gx_paypal_setting";
		$paypalStmt = $this->db1->prepare($sqlPaypal);
		$paypalStmt->execute();
		$countRows = $paypalStmt->rowCount();
		if($countRows>0){
			$payPalData = $paypalStmt->fetch();
		}
		return $payPalData;
	}
	
	private function getClaimChartsQuestionAnswerData($orderName,$patentNumber,$t){
		$question = array();$expertList = array();$getAmountList = array();
		$queryProject = "SELECT id FROM ep7gx_projects WHERE name=? AND type=?";
		$projectStmt = $this->db1->prepare($queryProject);
		$projectStmt->execute([$orderName,$t]);
		$countRows = $projectStmt->rowCount();
		if($countRows>0){
			$getProjectData = $projectStmt->fetch();
			$querySurvey = "SELECT id,name,report_type FROM ep7gx_survey WHERE report_type=? AND project_id=? AND name=?";
			$surveyStmt = $this->db1->prepare($querySurvey);
			$surveyStmt->execute([$t,$getProjectData->id,$patentNumber]);
			$countSurveyRows = $surveyStmt->rowCount();
			if($countSurveyRows>0){
				$getSurveyData = $surveyStmt->fetch();
				$surveyID = $getSurveyData->id;
				$queryQuestions = "SELECT id, description FROM ep7gx_question WHERE survey_id=? ORDER BY question_order ASC";
				$questionStmt = $this->db1->prepare($queryQuestions);
				$questionStmt->execute([$surveyID]);
				$questionRows = $questionStmt->rowCount();
				if($questionRows>0){
					$getList = array();
					$targetProducts = array();
					$expertIDsList = array();
					while($row = $questionStmt->fetch()){
						array_push($getList,$row);
					}
					$targetProductsQuery = "SELECT qa.target, qa.target_product,qa.expert_id FROM ep7gx_survey_question_answer as qa LEFT JOIN ep7gx_question as q ON q.id = qa.ques_id LEFT JOIN ep7gx_survey as s ON s.id = q.survey_id WHERE qa.showed=0 AND qa.`show`=1 AND s.id= ? GROUP By qa.target,qa.target_product,qa.expert_id";
					$targetStmt = $this->db1->prepare($targetProductsQuery);
					$targetStmt->execute([$surveyID]);
					$targetRows = $targetStmt->rowCount();
					if($targetRows>0){
						while($row = $targetStmt->fetch()){
							array_push($targetProducts,$row);
						}
					}		
					if(count($targetProducts)>0){
						$expertIDs = array();	
						foreach($targetProducts as $tp){
							array_push($expertIDs,$tp->expert_id);
						}
						if(count($expertIDs)>0){
							$expertIDList = str_repeat ('?, ',  count ($expertIDs) - 1) . '?';
							$queryExpertDNDReport = "SELECT e.id FROM ep7gx_expert as e INNER JOIN ep7gx_users as u ON u.id = e.user_id WHERE e.id IN ($expertIDList) AND u.can_see=0";
							$expertDNDStmt = $this->db1->prepare($queryExpertDNDReport);
							$expertDNDStmt->execute($expertIDs);
							$expertCounts = $expertDNDStmt->rowCount();
							$dndExperts = array();
							if($expertCounts>0){
								while($row = $expertDNDStmt->fetch()){
									array_push($dndExperts,$row);
								}
							}
							if(count($dndExperts)>0){
								foreach($dndExperts as $e){
									for($i=0;$i<count($targetProducts);$i++){
										if($targetProducts[$i]->expert_id == $e->id){
											array_push($expertIDsList,$e->id);
											unset($targetProducts[$i]);
										}
									}
									$targetProducts = array_values($targetProducts);
								}
							} 
						}
					}
					$targetProducts = array_values($targetProducts);
					for ($i = 0; $i < count($getList); $i++) {
						$answersAll = array();
						if(count($targetProducts)>0){
							for($tp=0;$tp<count($targetProducts);$tp++){
								$ansSql = "SELECT ques_id,expert_id,status,target,target_product FROM ep7gx_survey_question_answer as sqe WHERE  sqe.showed=0 AND `show`=1 AND publish=0 AND sqe.expert_id=? AND sqe.ques_id=? AND sqe.target=? AND sqe.target_product=?";
								$ansStmt = $this->db1->prepare($ansSql);
								$ansStmt->execute([$targetProducts[$tp]->expert_id,$getList[$i]->id,$targetProducts[$tp]->target,$targetProducts[$tp]->target_product]);
								if($ansStmt->rowCount()>0){
									$getAnsList = $ansStmt->fetch();
									array_push($answersAll,$getAnsList);
								}								
							}
						}
						array_push($question,array('data' => $getList[$i], 'answer' => $answersAll));
					}					
					if(count($targetProducts)>0){
						for($tp=0;$tp<count($targetProducts);$tp++){
							$amountSurvey = "SELECT sae.*, s.payment_type FROM ep7gx_survey_amount_expert as sae LEFT JOIN ep7gx_survey as s ON s.id = sae.survey_id LEFT JOIN ep7gx_survey_question_answer as sqa ON sqa.target = sae.target  WHERE sqa.`show` = 1 AND sae.survey_id=? AND sae.expert_id=? AND sae.target=? AND sae.target_product=?  ORDER BY sae.target_product ASC LIMIT 1";
							$amtProductStmt = $this->db1->prepare($amountSurvey);
							$amtProductStmt->execute([$surveyID,$targetProducts[$tp]->expert_id,$targetProducts[$tp]->target,$targetProducts[$tp]->target_product]);
							if($amtProductStmt->rowCount()>0){
								$getAmount = $amtProductStmt->fetch();
								unset($getAmount->id);
								unset($getAmount->file_name);
								array_push($getAmountList,$getAmount);
							}
						}
					}				
					if(count($expertIDsList)==0){
						$expertSql = "SELECT e.id , e.name, e.linkedin_profile_url , ep.paypal_id , qa.target, qa.target_product, e.expert_type, e.company_name FROM ep7gx_survey_question_answer as qa LEFT JOIN  ep7gx_expert as e ON e.id = qa.expert_id LEFT JOIN  ep7gx_question as q ON q.id = qa.ques_id LEFT JOIN  ep7gx_survey as s ON s.id = q.survey_id LEFT JOIN ep7gx_expert_payment as ep ON ep.expert_id = e.id  WHERE q.survey_id = ? AND qa.`show` =1 AND qa.showed = 0 GROUP BY qa.target, qa.target_product ORDER BY e.name ASC";
					} else {
						$expertIDImplode = str_repeat ('?, ',  count ($expertIDsList) - 1) . '?';
						$expertSql = "SELECT e.id , e.name, e.linkedin_profile_url , ep.paypal_id , qa.target, qa.target_product, e.expert_type, e.company_name FROM ep7gx_survey_question_answer as qa LEFT JOIN  ep7gx_expert as e ON e.id = qa.expert_id LEFT JOIN  ep7gx_question as q ON q.id = qa.ques_id LEFT JOIN  ep7gx_survey as s ON s.id = q.survey_id LEFT JOIN ep7gx_expert_payment as ep ON ep.expert_id = e.id  WHERE qa.`show` =1 AND qa.showed = 0 AND qa.expert_id NOT IN ($expertIDImplode) AND q.survey_id = ? GROUP BY qa.target, qa.target_product ORDER BY e.name ASC";
					}
					$expertStmt = $this->db1->prepare($expertSql);
					if(count($expertIDsList)==0){
						$expertStmt->execute([$surveyID]);
					} else {
						array_push($expertIDsList,$surveyID);
						$expertStmt->execute($expertIDsList);
					}
					if($expertStmt->rowCount()>0){
						while($row = $expertStmt->fetch()){
							$display = openssl_encrypt($row->id,"AES-128-ECB",$key = $this->get('settings')['sy-password']);
							$row->profile_id = $display;
							/*expert ratings*/
							$ratingSql = "SELECT sum(er.rating) as rating, count(er.survey_id) as count_survey ,  e.id FROM ep7gx_expertrating as er LEFT JOIN ep7gx_expert as e ON e.id = er.expert_id LEFT JOIN ep7gx_survey as s ON s.id = er.survey_id WHERE er.expert_id=? GROUP BY er.survey_id";
							$ratingStmt = $this->db1->prepare($ratingSql);
							$ratings = array();
							if($ratingStmt->rowCount()>0){
								while($row = $ratingStmt->fetch()){
									array_push($ratings,$row);
								}
							}
							$row->ratings = $ratings;
							array_push($expertList,$row);
						}
					}
				}
			}
		}
		return array('question' => $question, 'expert' => $expertList, 'survey' => $getAmountList);
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

	public  function encode($value){ 		
		if(!$value){return false;}
		$text = $value;
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, DataController::getTokenKey(), $text, MCRYPT_MODE_ECB, $iv);
		return trim(DataController::safe_b64encode($crypttext)); 
	}

	private function decode($value){
		if(!$value){return false;}
		$crypttext = DataController::safe_b64decode($value); 
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, DataController::getTokenKey(), $crypttext, MCRYPT_MODE_ECB, $iv);
		return trim($decrypttext);
	}
	
	private function sendNotificationToUser($postData){
		$ch = curl_init();		
		$api_url = 'https://backyard.synpat.com/customers/push_notification_pos';
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
		$response = curl_exec($ch); 
		curl_close($ch);
		return $response;
	}
}