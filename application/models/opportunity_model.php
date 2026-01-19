<?php
class opportunity_model extends CI_Model{
	public $table_assign = "assign_leads";
	public $table_user = "users";
	public $table_leads = "litigations";
	public $table_technology_preference = 'technology_preference';
	public $table_category = 'category';
	public $table_map_sector_category = 'map_sectors_departments';
	public $table_sectors = 'sectors';
	public $table_company_sector = 'company_sector';
	public $table_stage = 'lead_stages';
	public $table_level = 'lead_levels';
	public $table_report = 'lead_reports';
	public $table_lead_patent = 'lead_patent';
	public $table_lead_patent_family = 'lead_patent_family';
	public $table_lead_patent_scrap_data = 'lead_patent_scrap_data';
	public $table_share_doc = 'share_docs';
	public $table_doc_list = 'document_lists';
	public $table_technologies = 'technologies';
	public $table_requests = 'approval_requests';
	public $table_eou_data = 'eou_datas';
	public $table_sep_data = 'sep_datas';
	public $table_sep_another_data = 'sep_another_datas';
	public $table_company = 'company';
	public $table_precompany = 'pre_companies';
	public $table_contacts = 'contacts';
	public $table_assets = 'assets';
	public $table_invitees = 'backyard_invitees';
	public $table_store_invitees = 'invitees';
	public $table_acquisition_company = 'acquisition_company';
	public $table_acquisition_activity_log_detail = 'acquisition_activity_log_detail';
	public $table_invitees_in_sectors = 'invitees_in_sectors';
	public $table_potential = 'backyard_potential_syndicates';
	public $table_commitment = 'commitments';
	public $table_chart_left = 'backyard_chart_lefts';
	public $table_due_dilligence_chart_left = 'chart_lefts';
	public $table_chart_middle = 'backyard_chart_middles';
	public $table_chart_right = 'backyard_chart_rights';
	public $table_dchart_right = 'chart_rights';
	public $table_comparable = 'backyard_comparables';
	public $table_damages = 'backyard_damages';
	public $table_history = 'history';
	public $table_sec_agreements = 'sec_agreements';
	public $table_sales_activity_log_detail = 'sales_activity_log_detail';
	public $table_presales_activity_log_detail = 'presale_activity_log_detail';
	public $table_activity_log_detail = 'activity_log_detail';
	public $table_presale_broker = 'presale_broker';
	public $table_listing_company = 'listing_company';
	public $table_docket_inventions = 'due_dilligence_inventions';
	public $table_docket_legal = 'due_dilligence_legal';
	public $table_docket_due = 'due_dilligences';
	public $table_docket_licenses = 'licenses';
	public $table_docket_images = 'due_images';
	public $table_due_activity = 'due_activity';
	public $table_outsource_project_data = 'outsource_project_data';
	public $table_docket_counterparts = 'due_dilligence_counterparts';
	public $table_scrapper_linkedin_single_job = 'scrapper_linkedin_single_job';
	public $table_scrapper_linkedin_job = 'scrapper_linkedin_job';
	public $table_scrapper_linkedin_cjob = 'scrapper_linkedin_cjob';
	public $table_scrapper_owler_list = 'scrapper_owler_list';
	public $table_similar_industry = 'similar_industry';
	public $table_scrapper_profile_captcha = 'scrapper_profile_captcha';
	public $table_scrapper_company_running_stage = 'scrapper_company_running_stage';
	public $table_scrapper_owler_running_stage = 'scrapper_owler_running_stage';
	public $table_scrapper_company_linkedin_people_job = 'scrapper_company_linkedin_people_job';
	public $table_scrapper_contacts_connect_job = 'scrapper_contacts_connect_job';
	public $table_store_images = 'store_images';
	public $table_companies_people_research = 'companies_people_research';
	public $table_email_scrapper = 'email_scrapper';
	public $table_scrapper_run = 'scrapper_run';
	public $table_scraper_timmer = 'scraper_timmer';
	
	function __construct() {
		parent::__construct();
	}
	
	
	function myButtonList(){
		return '';
	}
	
	function insertContactsInBatch($data){
		$this->db->insert_batch($this->table_contacts,$data);
	}
	
	function insertStoreImagesInBulk($data){
		$this->db->insert_batch($this->table_store_images,$data);
	}
	
	function deleteContactsInBatch($allIds){
		$this->db->where_in('id', $allIds );
		$this->db->delete($this->table_contacts);
		return $this->db->affected_rows();
	}
	
	function deletePotential($leadID){
		$this->db->delete($this->table_potential,array('lead_id'=>$leadID));		
	}
	
	function insertLinkedInScrapperList($data){
		$this->db->insert($this->table_scrapper_linkedin_job,$data);
		return $this->db->insert_id();
	}
	
	function insertLinkedInSingleScrapperList($data){
		$this->db->insert($this->table_scrapper_linkedin_single_job,$data);
		return $this->db->insert_id();
	}

	function insertLinkedInScrapperListInBatch($data){
		$this->db->insert_batch($this->table_scrapper_linkedin_job,$data);
		return $this->db->insert_id();
	}
	
	function insertLinkedInConnectListInBatch($data){
		$this->db->insert_batch($this->table_scrapper_contacts_connect_job,$data);
		return $this->db->insert_id();
	}
	
	function insertLinkedInCompanyScrapperListInBatch($data){
		$this->db->insert_batch($this->table_scrapper_linkedin_cjob,$data);
		return $this->db->insert_id();
	}
	
	function insertLinkedInCompanyPeopleScrapperListInBatch($data){
		$this->db->insert_batch($this->table_scrapper_company_linkedin_people_job,$data);
		return $this->db->insert_id();
	}
	
	function insertOwlerInCompanyScrapperListInBatch($data){
		$this->db->insert_batch($this->table_scrapper_owler_list,$data);
		return $this->db->insert_id();
	}
	
	function deleteListingCompany($data){
		$this->db->delete($this->table_listing_company,$data);
		return $this->db->affected_rows();
	}
	
	function addListingCompany($data){
		$this->db->insert($this->table_listing_company,$data);
		return $this->db->insert_id();
	}
	
	function addResearcherCompanyBulk($bulkData){
		$this->db->insert_batch($this->table_companies_people_research, $bulkData); 
		return $this->db->insert_id();
	}
	
	function deleteResearcherCompanyBulk($companyIDs,$lead_id){
		$this->db->where_in('company_id',$companyIDs);
		$this->db->where_in('lead_id',$lead_id);
		$this->db->delete($this->table_companies_people_research); 
		return $this->db->affected_rows();
	}
	
	function updateListingContact($data,$id){
		$this->db->where('id',$id);
		$this->db->update($this->table_listing_company,$data);
		return $this->db->affected_rows();
	}

	function update_captcha_confirm_scrapper($data,$id){
		$this->db->where('id',$id);
		$this->db->update($this->table_scrapper_profile_captcha,$data);
		return $this->db->affected_rows();
	}
	
	function update_researcher_data($data,$id){
		$this->db->where('id',$id);
		$this->db->update($this->table_companies_people_research,$data);
		return $this->db->affected_rows();
	}
	
	function updateContactsListByIDs($data,$listIds){
		$IDs = json_decode($listIds);
		$this->db->where_in('id',$IDs);
		$this->db->update($this->table_contacts,$data);
		return $this->db->affected_rows();
	}
	
	function savePotential($data){
		$this->db->insert($this->table_potential,$data);
		return $this->db->insert_id();
	}
	
	function insertStoreInvitee($data){		
		$this->db->insert($this->table_store_invitees,$data);
		return $this->db->insert_id();
	}
	function deleteStoreInvitee($companyName,$licenseID){
		$this->db->delete($this->table_store_invitees,array('company'=>$companyName,'license_id'=>$licenseID));
		return $this->db->affected_rows();
	}
	
	function dropCompanyTable(){
		$this->db->query("DROP TABLE ".$this->table_company);
	}
	
	function checkContactsCorrespondense($allIds){
		$data = array('acquisition'=>array(),'sales'=>array(),'activity'=>array());
		$query = $this->db->select("count(id), contact_id")->from($this->table_acquisition_activity_log_detail)->where_in('contact_id',$allIds)->group_by('contact_id')->get();		
		if($query->num_rows()>0){
			$data['acquisition'] = $query->result();
		}
		$query = $this->db->select("count(id), contact_id")->from($this->table_sales_activity_log_detail)->where_in('contact_id',$allIds)->group_by('contact_id')->get();		
		if($query->num_rows()>0){
			$data['sales'] = $query->result();
		}
		$query = $this->db->select("count(id), contact_id")->from($this->table_activity_log_detail)->where_in('contact_id',$allIds)->group_by('contact_id')->get();		
		if($query->num_rows()>0){
			$data['activity'] = $query->result();
		}
		return $data;
	}

	function checkCompanyInScrappingList($c){
		return $this->db->select("count(*) as companyScrappingCount")->from($this->table_scrapper_linkedin_job)->where('company',$c)->where('check_r',0)->get()->row()->companyScrappingCount;
	}
	
	function getImageFile($link){
		$query = $this->db->select("*")->from($this->table_store_images)->where('link',$link)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->first_row();
		}
		return $data;
	}
	
	function getScrapperDataByID($scrapperID){
		$query = $this->db->select("*")->from($this->table_scrapper_linkedin_job)->where('id',$scrapperID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->first_row();
		}
		return $data;
	}
	
	function findLinkedinProfileScrapperList($type){
		$query = $this->db->select("*")->from($this->table_scrapper_linkedin_job)->where('type',$type)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->result();
		}
		return $data;
	}
	
	function findLinkedinSingleProfileScrapperList($type){
		$query = $this->db->select("*")->from($this->table_scrapper_linkedin_single_job)->where('type',$type)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->result();
		}
		return $data;
	}
	
	function checkContactListForScrape() {
		$query = $this->db->select("*")->from($this->table_scrapper_linkedin_job)->where('status',0)->get();
		$data = 0;
		if ($query->num_rows() > 0) {
			$data  = $query->num_rows();
		}
		$this->deleteMyFinishedContactJob();
		return $data;
	}
	
	function checkOwlerListForScrapeByUserID() {
		$query = $this->db->select("*")->from($this->table_scrapper_owler_list)->where('status',0)->get();
		$data = 0;
		if ($query->num_rows() > 0) {
			$data  = $query->num_rows();
		}
		$this->deleteOwlerFinishedJob();
		return $data;
	}
	
	function findCompaniesInScraperList($companyIDs){
		$query = $this->db->select("company")->from($this->table_scrapper_linkedin_cjob.' as c')->where_in('c.company',$companyIDs)->where('status',0)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	function checkCompanyListForScrapeByUserID() {
		$query = $this->db->select("*")->from($this->table_scrapper_linkedin_cjob)->where('status',0)->get();
		$data = 0;
		if ($query->num_rows() > 0) {
			$data  = $query->num_rows();
		}
		$this->deleteMyFinishedJob();
		return $data;
	}
	
	function checkContactListForConnect() {
		$query = $this->db->select("*")->from($this->table_scrapper_contacts_connect_job)->where('status',0)->get();
		$data = 0;
		if ($query->num_rows() > 0) {
			$data  = $query->num_rows();
		}
		return $data;
	}
	
	function checkCompanyPeopleListForScrape() {
		$query = $this->db->select("*")->from($this->table_scrapper_company_linkedin_people_job)->where('status',0)->get();
		$data = 0;
		if ($query->num_rows() > 0) {
			$data  = $query->num_rows();
		}
		return $data;
	}
	
	
	function getListFromAllQueues(){
		$data = array('find'=>array(),'company'=>array(),'owler'=>array(),'connect'=>array(),'contact'=>array(),'email'=>array(),'button_status'=>array(),'timmer'=>array());
		$querySearchPeople = $this->db->select("id,company as company_id,linkedin_url,company_name")->from($this->table_scrapper_company_linkedin_people_job)->where('status <>',5)->where('status <>',6)->order_by('id','ASC')->get();
		if ($querySearchPeople->num_rows() > 0) {
			$data['find']  = $querySearchPeople->result();
		}
		$queryCompany = $this->db->select("id,company as company_id,linkedin_url,company_name")->from($this->table_scrapper_linkedin_cjob)->where('status <>',5)->get();
		if ($queryCompany->num_rows() > 0) {
			$data['company']  = $queryCompany->result();
		}
		$queryOwler = $this->db->select("id,company as company_id,company_name,owler_url")->from($this->table_scrapper_owler_list)->where('status <>',5)->get();
		if ($queryOwler->num_rows() > 0) {
			$data['owler']  = $queryOwler->result();
		}
		$queryConnectPeople = $this->db->select("id,company as company_id,list")->from($this->table_scrapper_contacts_connect_job)->where('status <>',5)->get();
		if ($queryConnectPeople->num_rows() > 0) {
			$data['connect']  = $queryConnectPeople->result();
		}		
		$queryContact = $this->db->select("id,company as company_id,list")->from($this->table_scrapper_linkedin_job)->where('status <>',5)->get();
		if ($queryContact->num_rows() > 0) {
			$data['contact']  = $queryContact->result();
		}		
		$queryEmail = $this->db->select("id,first_name,last_name,domain,contact_id,company_id")->from($this->table_email_scrapper)->get();
		if ($queryEmail->num_rows() > 0) {
			$data['email']  = $queryEmail->result();
		}
		$queryButtonStatus = $this->db->select("id,type,status")->from($this->table_scrapper_run)->get();
		if ($queryButtonStatus->num_rows() > 0) {
			$data['button_status']  = $queryButtonStatus->result();
		}
		$queryTimmer = $this->db->select("id,min,max")->from($this->table_scraper_timmer)->get();
		if ($queryTimmer->num_rows() > 0) {
			$data['timmer']  = $queryTimmer->first_row();
		}
		return $data; 
	}
	
	function updateScrapeBtnStatusByType($type,$data){
		$this->db->where('type',$type);
		$this->db->update($this->table_scrapper_run,$data);
		return $this->db->affected_rows();
	}
	
	function updateScrapperMinMax($min,$max){
		$this->db->where('id >',0);
		$this->db->update($this->table_scraper_timmer,array('min'=>$min,'max'=>$max));
		return $this->db->affected_rows();
	}
	
	function findCompanyPeopleInLinkedinQueue($companiesList){		
		/*$query = $this->db->select("company")->from($this->table_scrapper_company_linkedin_people_job)->where_in('company',$companiesList)->where('status <>',6)->get();
		if ($query->num_rows() > 0) {
			$list  = $query->result();
			foreach($list as $company){
				$index =  array_search($company->company,$companiesList);
				if($index >=0){
					array_splice($companiesList,$index,1);
				}
			}			
		}*/
		return $companiesList;
	}
	
	function delete_company_search_people_from_queue($id,$company){
		$this->db->where('id',$id);
		$this->db->where('company',$company);
		$this->db->delete($this->table_scrapper_company_linkedin_people_job);
		return $this->db->affected_rows();
	}
	
	function delete_all_company_search_people_from_queue(){
		$this->db->where('id >',0);
		$this->db->delete($this->table_scrapper_company_linkedin_people_job);
		return $this->db->affected_rows();
	}
	
	function deleteOwlerFinishedJob() {
		$this->db->where_in('status',array(2));
		$this->db->delete($this->table_scrapper_owler_list);
	}
	
	function deleteMyFinishedJob() {
		$this->db->where_in('status',array(2));
		$this->db->delete($this->table_scrapper_linkedin_cjob);
	}
	
	function deleteMyFinishedContactJob() {
		$this->db->where_in('status',array(2));
		$this->db->delete($this->table_scrapper_linkedin_job);
	}
	
	function checkScrapperCompanyRunningStage($t) {
		$query = $this->db->select("status as d")->from($this->table_scrapper_company_running_stage)->where('type',$t)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->first_row();
		}
		return $data;
	}
	
	function checkScrapperOwlerRunningStage() {
		$query = $this->db->select("status as d")->from($this->table_scrapper_owler_running_stage)->where('id',1)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->first_row();
		}
		return $data;
	}

	function getCountAllContactBelongToCompany($companyID){
		return $this->db->select("count(c.id) as countUsers")->from($this->table_contacts.' as c')->where('c.company_id',$companyID)->get()->row()->countUsers;
	}
	function getCompanyResearcherData($ID){
		$query = $this->db->select("*")->from($this->table_companies_people_research)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->first_row();
		}
		return $data;
	}
	
	function findCompaniesPeopleResearch($leadID){
		$query = $this->db->select("r.*,c.company_name")->from($this->table_companies_people_research.' as r')->join($this->table_company.' as c','c.id = r.company_id','left')->where('r.lead_id',$leadID)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->result();
		}
		return $data;
	}
	
	function add_update_research_companies($companiesList,$leadID){
		if(count($companiesList) > 0 ){
			$query = $this->db->select('count(c.id) as noOfusers, c.company_id')->from($this->table_contacts.' as c')->where_in('company_id',$companiesList)->group_by('company_id')->get();
			if($query->num_rows()>0){
				$this->deleteResearcherCompanyBulk($companiesList,$leadID);
				$data = $query->result();
				$removC = array();
				foreach($data as $u){
					for($i = 0; $i<count($companiesList);$i++){
						if($companiesList[$i] === $u->company_id && $u->noOfusers > 0){
							array_push($removC,$i);
						}
					}
				}
				if(count($removC) > 0){
					foreach($removC as $d){
						unset($companiesList[$d]);
					}
				}
				if(count($companiesList) > 0){
					$researcherArray = array();
					foreach($companiesList as $c){
						array_push($researcherArray,array('company_id'=>$c,'lead_id'=>$leadID));
					}
					$this->addResearcherCompanyBulk($researcherArray);
				}
			}
		}
		return $companiesList;
	}

	function get_users_count_list_companies(){
		$query = $this->db->query('SELECT distinct(count(id)) as countUsers FROM '.$this->table_contacts.' GROUP BY company_id HAVING countUsers >0 ORDER BY countUsers');
		if($query->num_rows()>0){
			$data = $query->result();
		}
		return $data;
	}
	
	function getContactDetailByID($ID){
		$query = $this->db->select("c.*,co.company_name as companyName")->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->first_row();
		}
		return $data;
	}
	
	function getContactListByIDs($listIds){
		$IDs = json_decode($listIds);
		$query = $this->db->select("*")->from($this->table_contacts)->where_in('id',$IDs)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->result();
		}
		return $data;
	}
	
	function checkPreCompanyWithLinkedinUrl($linkedinUrl){
		$query = $this->db->select("*")->from($this->table_precompany)->where('linkedin_url',$linkedinUrl)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->first_row();
		}
		return $data;
	}
	
	function checkCompanyWithLinkedinUrl($linkedinUrl){
		$query = $this->db->select("*")->from($this->table_company)->where('linkedin_url',$linkedinUrl)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->first_row();
		}
		return $data;
	}
	
	function checkCOmpanyINListing($companyID,$type,$leadID=0){
		if($leadID==0){
			$query = $this->db->select("*")->from($this->table_listing_company)->where("company_id",$companyID)->where("type",$type)->get();
		} else {
			$query = $this->db->select("*")->from($this->table_listing_company)->where('lead_id',$leadID)->where("company_id",$companyID)->where("type",$type)->get();
		}		
		$data = array();
		if ($query->num_rows() > 0) {
			$data  = $query->first_row();
        }
		return $data;
	}
	
	public function getDataFromDataFills(){		
		$queryProjectData = $this->db->select("*")->from($this->table_outsource_project_data.' as pd')->where('enter_by', "User")->where('pd.row <>""')->where('pd.col <>""')->where('pass',1)->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			foreach($queryProjectData->result() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}
	
	function getCompanyByNameListing($select,$leadID=0){
		$data = array();
		if($leadID>0){
			$query = $this->db->select($select)->from($this->table_listing_company.' as lc')->join($this->table_company.' as co','co.id = lc.company_id')->where('lc.lead_id',$leadID)->where('lc.type','company')->get();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$usersList = $this->getAllContactBelongToCompany($row->id);
					$row->company_users = $usersList;
					$data[] = $row;
				}
			}
			$query = $this->db->select($select)->from($this->table_listing_company.' as lc')->join($this->table_precompany.' as co','co.id = lc.company_id')->where('lc.lead_id',$leadID)->where('lc.type','pre-company')->get();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$row->company_users = array();
					$data[] = $row;
				}
			}
		}
		return $data;
	}
	
	function getAllContactBelongToCompany($companyID){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name")->from($this->table_contacts.' as c')->where('c.company_id',$companyID)->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	function getCompanyListing($select,$leadID=0){
		if($leadID==0){
			$query = $this->db->select($select)->from($this->table_listing_company)->get();
		} else {
			$query = $this->db->select($select)->from($this->table_listing_company)->where('lead_id',$leadID)->get();
		}
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function find_contact_by_email($emailID){
		$query = $this->db->select('c.*, co.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.email',$emailID)->or_where('c.secondary_email',$emailID)->or_where('c.tertiary_email',$emailID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}
	
	function find_contact_by_linkedin_url($linkedin_url){
		$query = $this->db->select('c.*, co.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.linkedin_url',$linkedin_url)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}
	
	function find_all_contacts_by_emails($emailIDs){
		$query = $this->db->select('c.id,c.email,c.secondary_email,c.tertiary_email,c.company_id, co.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where_in('c.email',$emailIDs)->or_where_in('c.secondary_email',$emailIDs)->or_where_in('c.tertiary_email',$emailIDs)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function find_company_data_by_id($companyID,$select,$companyUsers = false, $similarOrganization = false){
		$query = $this->db->select($select)->from($this->table_company.' as co')->where('co.id',$companyID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();       
			if($companyUsers===true){
				$data->companyUsers = $this->getAllContactBelongToCompany($companyID);
			}  
			if($similarOrganization===true){
				$data->list = $this->getSimilarOrganizations($companyID);
			}
        }
		return $data;
	}

	public function getSimilarOrganizations($companyID){
		$data = array();
		if($companyID>0){
			$query = $this->db->select("co.*")->from($this->table_similar_industry.' as si')->join($this->table_company.' as co', 'co.id = si.similar_company_id','left')->where('si.company_id',$companyID)->get();
			$data = $query->result();
		}
		return $data;
	}
	
	function get_company_list_from_invitees_contacts($select){
		$query = $this->db->select($select)->from($this->table_listing_company.' as co')->join($this->table_contacts.' as c','c.company_id=co.company_id')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function findInviteesCompanies($leadID){
		$query = $this->db->select("*")->from($this->table_sales_activity_company)->where('id IN (SELECT DISTINCT(company_id) FROM '.$this->table_sales_activity_log.' WHERE lead_id='.(int)$leadID.') ')->order_by('company_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function getPotential($leadID){
		$query = $this->db->select("*")->from($this->table_potential)->where("lead_id",$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}

	function saveCommitment($data){
		$this->db->insert($this->table_commitment,$data);	
		return $this->db->insert_id();		
	}	
	
	function getCommitment($leadID){
		$query = $this->db->select("*")->from($this->table_commitment)->where("lead_id",$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	function deleteLeftChart($leadID){
		$this->db->delete($this->table_chart_left,array('lead_id'=>$leadID));		
	}
	
	function deleteDuedilligenceLeftChart($leadID){
		$this->db->delete($this->table_due_dilligence_chart_left,array('license_id'=>$leadID));		
	} 
	
	function saveChartLeft($data){	
		$this->db->insert($this->table_chart_left,$data);
		return $this->db->insert_id();
	}	
	
	function saveDuediligenceChartLeft($data){	
		$this->db->insert($this->table_due_dilligence_chart_left,$data);
		return $this->db->insert_id();
	}
	
	function getChartLeft($leadID){
		$query = $this->db->select("*")->from($this->table_chart_left)->where("lead_id",$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function deleteMiddleChart($leadID){
		$this->db->delete($this->table_chart_middle,array('lead_id'=>$leadID));		
	}
	
	function saveChartMiddle($data){
		$this->db->insert($this->table_chart_middle,$data);
		return $this->db->insert_id();		
	}

	function getChartMiddle($leadID){
		$query = $this->db->select("*")->from($this->table_chart_middle)->where("lead_id",$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function deleteRightChart($leadID){
		$this->db->delete($this->table_chart_right,array('lead_id'=>$leadID));		
	}
	
	function deleteDRightChart($licenseID){
		$this->db->delete($this->table_dchart_right,array('license_id'=>$licenseID));		
	}
	
	function saveDChartRight($data){	
		$this->db->insert($this->table_dchart_right,$data);	
		return $this->db->insert_id();
	}
	
	function saveChartRight($data){	
		$this->db->insert($this->table_chart_right,$data);	
		return $this->db->insert_id();
	}
	
	function getChartRight($leadID){
		$query = $this->db->select("*")->from($this->table_chart_right)->where("lead_id",$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	
	function deleteComparable($leadID){
		$this->db->delete($this->table_comparable,array('lead_id'=>$leadID));		
	}
	
	function saveComparable($data){	
		$this->db->insert($this->table_comparable,$data);	
		return $this->db->insert_id();
	}
	
	function getComparable($leadID){
		$query = $this->db->select("*")->from($this->table_comparable)->where("lead_id",$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	
	function deleteDamages($leadID){
		$this->db->delete($this->table_damages,array('lead_id'=>$leadID));		
	}
	
	function saveDamage($data){	
		$this->db->insert($this->table_damages,$data);
		return $this->db->insert_id();
	}
	
	function saveScrappingAgreement($data){
		$this->db->insert($this->table_sec_agreements,$data);
		return $this->db->insert_id();
	}
	
	function getAgreementList($leadID){
		$query = $this->db->select("*")->from($this->table_sec_agreements)->order_by('id','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function checkAgreement($agreementID){
		$query = $this->db->select("*")->from($this->table_sec_agreements)->where('agreement_id',$agreementID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	function updateAgreement($data,$id){
		$this->db->where('id', $id);
		$this->db->update($this->table_sec_agreements,$data);	
		return $this->db->affected_rows();
	}
	
	function getDamages($leadID){
		$query = $this->db->select("*")->from($this->table_damages)->where("lead_id",$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function insertInvitees($data){
		$this->db->insert($this->table_invitees,$data);
		return $this->db->insert_id();		
	}
	
	function insertAcquisitionCompany($data){
		$this->db->insert($this->table_acquisition_company,$data);
		return $this->db->insert_id();		
	}
	
	function findInvitees($contacts){
		$query = $this->db->select("*")->from($this->table_contacts)->where("id IN(".$contacts.")")->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	function checkAllLeadsByContact($contactID){
		$data = array(); 
		$activity=0;
		$queryContact = $this->db->select("company_id")->from($this->table_contacts)->where("id",$contactID)->get();
		if ($queryContact->num_rows() > 0) {
            $contact = $queryContact->first_row();
			$query = $this->db->select("distinct(l.id) as id, l.lead_name")->from($this->table_invitees.' as s')->join($this->table_leads.' as l','l.id=s.lead_id')->where('s.contact_id',$contact->company_id)->where('l.status <"3"')->get();
			if ($query->num_rows() > 0) {
				$activity = 1;
				foreach ($query->result() as $row) {	
					$leadIds[] = $row->id;
					$row->activity = 1;
					$data[] = $row;
				}
			}
			$query = $this->db->select("distinct(l.id) as id, l.lead_name")->from($this->table_acquisition_company.' as a')->join($this->table_leads.' as l','l.id=a.lead_id')->where('a.contact_id',$contact->company_id)->where('l.status <"3"')->get();
			if ($query->num_rows() > 0) {
				$activity = 2;
				foreach ($query->result() as $row) {
					/*if(!in_array($row->id,$leadIds)){*/
						$row->activity = 2;
						$data[] = $row;
					/*}*/	
				}
			}
		}
		return $data;
	}
	
	function checkAllLeadsFromEmailActivityByID($emailID){
		$data = array();
		$checkAquisitionActivity = $this->db->select('*')->from($this->table_acquisition_activity_log_detail)->where('email_id',$emailID)->get();
		if ($checkAquisitionActivity->num_rows() > 0) {
			$row = $checkAquisitionActivity->first_row();
			$row->activity = 2;
			$data = $row;
		} else {
			$checkSalesActivity = $this->db->select('*')->from($this->table_sales_activity_log_detail)->where('email_id',$emailID)->get();
			if ($checkSalesActivity->num_rows() > 0) {
				$row = $checkSalesActivity->first_row();
				$row->activity = 1;
				$data = $row;
			} else {
				$checkPreSalesActivity = $this->db->select('*')->from($this->table_presales_activity_log_detail)->where('email_id',$emailID)->get();
				if ($checkPreSalesActivity->num_rows() > 0) {
					$row = $checkPreSalesActivity->first_row();
					$row->activity = 3;
					$data = $row;
				}
			}
		}
		return $data;
	}
	
	function checkAllLeadsFromContactID($contactID,$companyID){
		$this->db->_protect_identifiers=false;
		$list = array();  
		$data = array();
		$query = $this->db->select("distinct(l.id) as id, 1 as activity")->from($this->table_invitees.' as s')->join($this->table_leads.' as l','l.id=s.lead_id')->where('s.contact_id',$companyID)->where('l.status <"3"')->get();
		if ($query->num_rows() > 0) {
			$preList = $query->result() ;
			$data = array_merge($data,$preList);
		}
		$this->db->_protect_identifiers=false;
		$query = $this->db->select("distinct(l.id) as id, 2 as activity")->from($this->table_acquisition_company.' as a')->join($this->table_leads.' as l','l.id=a.lead_id')->where('a.contact_id',$companyID)->where('l.status <"3"')->get();
		if ($query->num_rows() > 0) {
			$preList = $query->result() ;
			$data = array_merge($data,$preList);
		}
		$this->db->_protect_identifiers=false;
		$query = $this->db->select("distinct(l.id) as id, 3 as activity")->from($this->table_presale_broker.' as a')->join($this->table_leads.' as l','l.id=a.lead_id')->where('a.broker_id',$companyID)->where('l.status <"3"')->get();
		if ($query->num_rows() > 0) {
			$preList = $query->result() ;
			$data = array_merge($data,$preList);
		}
		$userID = $this->session->userdata['id'];
		$userList = array();
		$userHistoryQuery = $this->db->select('distinct(lead_id) as lead_id')->from($this->table_history)->where('user_id',$userID)->get();
		if($userHistoryQuery->num_rows() > 0){
			$userList = $userHistoryQuery->result();
		}
		$this->db->_protect_identifiers=false;
		/*$listQuery = $this->db->select("distinct(l.id) as id, l.lead_name, 1 as activity,0 as last_seen")->from($this->table_leads.' as l')->where('l.status <"3"')->get();*/
		$listQuery = $this->db->select("distinct(l.id) as id, l.lead_name, 1 as activity,0 as last_seen")->from($this->table_leads.' as l')->get();
		if ($listQuery->num_rows() > 0) {
			$list = $listQuery->result();
			$userHistoryQuery = $this->db->select('distinct(lead_id) as lead_id')->from($this->table_history)->where('user_id',$userID)->get();
			if($userList > 0){
				foreach($userList as $lead){
					$lastSeen = $this->db->select('create_date')->from($this->table_history)->where('user_id',$userID)->where('lead_id',$lead->lead_id)->order_by('create_date','DESC')->limit(1)->get()->row()->create_date;
					$n = 0;
					if($lastSeen != null || $lastSeen != '0000-00-00 00:00:00'){
						foreach($list as $l){
							if($l->id == $lead->lead_id){
								$list[$n]->last_seen = strtotime($lastSeen);
								break;
							}
							$n++;
						}
					}					
				}				
			}
			
			$activityList = array();
			foreach($list as $l){
				$newL = (array)$l;
				$newL['activity'] = 2;
				$activityList[] = (object)$newL;
			}
			$newList = array_merge($list,$activityList);
			
			$history = array();
			foreach ($newList as $key => $row){
				$history[$key] = $row->last_seen;
			}
			array_multisort($history, SORT_DESC, $newList);
			$list = $newList;
		}
		return array('list'=>$list,'active_list'=>$data);
	}
	
	function checkAllLeadsFromEmailActivity($email){
		$list = array();  
		$activity=0;
		$queryContact = $this->db->select("*")->from($this->table_contacts)->where("email",$email)->or_where('secondary_email',$email)->or_where('tertiary_email',$email)->get();
		$contact = array();
		$leadIds = array();
		$data = array();
		if ($queryContact->num_rows() > 0) {
            $contact = $queryContact->first_row();
			$this->db->_protect_identifiers=false;
			$query = $this->db->select("distinct(l.id) as id, 1 as activity")->from($this->table_invitees.' as s')->join($this->table_leads.' as l','l.id=s.lead_id')->where('s.contact_id',$contact->company_id)->where('l.status <"3"')->get();
			
			if ($query->num_rows() > 0) {
				$preList = $query->result() ;
				$data = array_merge($data,$preList);
			}
			$this->db->_protect_identifiers=false;
			$query = $this->db->select("distinct(l.id) as id, 2 as activity")->from($this->table_acquisition_company.' as a')->join($this->table_leads.' as l','l.id=a.lead_id')->where('a.contact_id',$contact->company_id)->where('l.status <"3"')->get();
			if ($query->num_rows() > 0) {
				$preList = $query->result() ;
				$data = array_merge($data,$preList);
			}
			$this->db->_protect_identifiers=false;
			$query = $this->db->select("distinct(l.id) as id, 3 as activity")->from($this->table_presale_broker.' as a')->join($this->table_leads.' as l','l.id=a.lead_id')->where('a.broker_id',$contact->company_id)->where('l.status <"3"')->get();
			if ($query->num_rows() > 0) {
				$preList = $query->result() ;
				$data = array_merge($data,$preList);
			}
        }
		$userID = $this->session->userdata['id'];
		$userList = array();
		$userHistoryQuery = $this->db->select('distinct(lead_id) as lead_id')->from($this->table_history)->where('user_id',$userID)->get();
		if($userHistoryQuery->num_rows() > 0){
			$userList = $userHistoryQuery->result();
		}
		/*All Lead With Activities*/
		
		$this->db->_protect_identifiers=false;
		/*$listQuery = $this->db->select("distinct(l.id) as id, l.lead_name, 1 as activity,0 as last_seen")->from($this->table_leads.' as l')->where('l.status <"3"')->get();*/
		$listQuery = $this->db->select("distinct(l.id) as id, l.lead_name, 1 as activity,0 as last_seen")->from($this->table_leads.' as l')->get();
		if ($listQuery->num_rows() > 0) {
			$list = $listQuery->result();
			$userHistoryQuery = $this->db->select('distinct(lead_id) as lead_id')->from($this->table_history)->where('user_id',$userID)->get();
			if($userList > 0){
				foreach($userList as $lead){
					$lastSeen = $this->db->select('create_date')->from($this->table_history)->where('user_id',$userID)->where('lead_id',$lead->lead_id)->order_by('create_date','DESC')->limit(1)->get()->row()->create_date;
					$n = 0;
					if($lastSeen != null || $lastSeen != '0000-00-00 00:00:00'){
						foreach($list as $l){
							if($l->id == $lead->lead_id){
								$list[$n]->last_seen = strtotime($lastSeen);
								break;
							}
							$n++;
						}
					}					
				}				
			}
			
			$activityList = array();
			foreach($list as $l){
				$newL = (array)$l;
				$newL['activity'] = 2;
				$activityList[] = (object)$newL;
			}
			$newList = array_merge($list,$activityList);
			
			$history = array();
			foreach ($newList as $key => $row){
				$history[$key] = $row->last_seen;
			}
			array_multisort($history, SORT_DESC, $newList);
			$list = $newList;
		}
		return array('list'=>$list,'active_list'=>$data,'contact'=>$contact,'activity'=>$activity);
	} 
	
	public function checkCompanyInSales($leadID,$companyID){
		$query = $this->db->select("*")->from($this->table_invitees)->where("lead_id",$leadID)->where('contact_id',$companyID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	public function checkCompanyInAcquisition($leadID,$companyID){
		$query = $this->db->select("*")->from($this->table_acquisition_company)->where("lead_id",$leadID)->where('contact_id',$companyID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	function deleteInvitees($recordID){
		$this->db->delete($this->table_invitees,array('lead_id'=>$recordID));		
	}
	
	function deleteInviteesByCompanyID($companyID,$leadID){
		$this->db->delete($this->table_invitees,array('contact_id'=>$companyID,'lead_id'=>$leadID));	
		return 	$this->db->affected_rows();
	}
	
	function deleteAcquisitionCompany($recordID){
		$this->db->delete($this->table_acquisition_company,array('lead_id'=>$recordID));		
	}
	
	function deleteInviteesByLeadAndCompany($recordID,$companyID){
		$this->db->delete($this->table_invitees,array('lead_id'=>$recordID,'contact_id'=>$companyID));		
	}
	
	function deleteAcquisitionByLeadAndCompany($recordID,$companyID){
		$this->db->delete($this->table_acquisition_company,array('lead_id'=>$recordID,'contact_id'=>$companyID));	
		return $this->db->affected_rows();
	}
	
	
	function insertInviteesInSector($data){
		$this->db->insert($this->table_invitees_in_sectors,$data);
		return $this->db->insert_id();		
	}
	
	function deleteInviteesInSector($recordID){
		$this->db->delete($this->table_invitees_in_sectors,array('invite_id'=>$recordID));		
	}
	
	
	function waitingApproval($userID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.status as notifyStatus,a.message,a.create_date as taskCreateDate,l.*,u.name as userName, u.type as userType')->from($this->table_requests.' as a')->join($this->table_leads.' as l','l.id=a.lead_id','left')->join($this->table_user.' as u','u.id=a.from_user_id')->where('a.user_id',$userID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		/*echo $this->db->last_query();*/
		return $data;
	}
	function myTaskApproval($userID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.status as notifyStatus,a.create_date as taskCreateDate,l.*,u.name as userName, u.type as userType,u.profile_pic')->from($this->table_requests.' as a')->join($this->table_leads.' as l','l.id=a.lead_id','left')->join($this->table_user.' as u','u.id=a.user_id')->where('a.from_user_id',$userID)->where('a.status <> 2')->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		/*echo $this->db->last_query();*/
		return $data;
	}
	
	
	/*
	function waitingApproval($userID,$lead_id=null){
	       if($lead_id > 0){
	           $query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.create_date as taskCreateDate,l.*,uu.name as userName, u.name as uuserName, u.type as userType,u.profile_pic')->from($this->table_requests.' as a')->join($this->table_leads.' as l','l.id=a.lead_id')->join($this->table_user.' as u','u.id=a.user_id')->join($this->table_user.' as uu','uu.id=a.from_user_id')->where('lead_id',$lead_id)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->order_by('a.id','DESC')->get();
               
	       
	       }else{
	           $query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.create_date as taskCreateDate,l.*,u.name as userName, u.type as userType,u.profile_pic')->from($this->table_requests.' as a')->join($this->table_leads.' as l','l.id=a.lead_id','left')->join($this->table_user.' as u','u.id=a.from_user_id')->where('a.user_id',$userID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->order_by('a.id','DESC')->get();
	       }
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}
	*/
	function checkApprovalSend($userID){
		$query = $this->db->select('count(*) as sendTask')->from($this->table_requests)->where('user_id',$userID)->where('status',0)->where('date_format(create_date,"%Y-%m-%d")',date('Y-m-d'))->get();
		return $query->row();
	}
	
	function findTask($taskID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.create_date as receivedData,a.execution_date as executionDate,a.status as notifyStatus,a.email_id as emailID,l.id,l.lead_name,l.plantiffs_name,l.serial_number,l.type,u.name as userName, u1.name as toUserName,u.type as userType,a.contact_id as contactID,a.company_id as companyID,a.activity_type')->from($this->table_requests.' as a')->join($this->table_leads.' as l','l.id=a.lead_id','left')->join($this->table_user.' as u','u.id=a.from_user_id')->join($this->table_user.' as u1','u1.id=a.user_id')->where('a.id',$taskID)->order_by('a.id','DESC')->get();
		/*echo $this->db->last_query();*/
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->first_row(); 
			$contactDetails = array();
		    if($data->contactID > 0){
			   $contactDetails = $this->getContactDetailByID($data->contactID);
		    }
			$data->contact_data = $contactDetails;
			if(count($data)>0 && (int)$data->parent_id>0){			   
			   $categories = array();
			   $this->findParentsTask($categories,$data->parent_id);
			   $data->parents = $categories;
			}
        }
		return $data;
	}
	
	function findParentsTask(&$categories,$parentID){
		if((int)$parentID>0){
			$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.create_date,l.id,l.lead_name,l.plantiffs_name,l.serial_number,l.type,u.name as userName')->from($this->table_requests.' as a')->join($this->table_leads.' as l','l.id=a.lead_id')->join($this->table_user.' as u','u.id=a.from_user_id')->where('a.id',$parentID)->order_by('a.id','DESC')->get();
			if ($query->num_rows() > 0) {
				$currentData = $query->first_row(); 
				if(count($currentData)>0){
					$categories[] = $currentData;
					$this->findParentsTask($categories,$currentData->parent_id);
				}
			}
		}
	}
	
	function findApprovalRequestNDA($leadID,$status,$type){
		$query = $this->db->select('a.doc_url,a.id as approved_id,l.*')->from($this->table_requests.' as a')->join($this->table_leads.' as l','l.id=a.lead_id')->where('`a`.`doc_url` <> ""')->where('a.type',$type)->where('a.status',$status)->where('a.lead_id',$leadID)->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
           $data = $query->first_row(); 
        }
		return $data;
	}
	
    function chkNdaExecuteBy($lead_id){
        $query = $this->db->select('*')->from($this->table_report)->where('lead_id',$lead_id)->get();
        if($query->num_rows()>0){
            $data=$query->first_row();
        }
        return $data;
    }
	
	function findApprovalRequest($leadID,$status,$type){
		$query = $this->db->select('a.doc_url,a.id as approved_id,l.*')->from($this->table_requests.' as a')->join($this->table_leads.' as l','l.id=a.lead_id')->where('a.type',$type)->where('a.status',$status)->where('a.lead_id',$leadID)->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
           $data = $query->first_row(); 
        }
		return $data;
	}
	
	function shareDoc($contactID,$type,$leadID,$fileID){
		$query = $this->db->select('s.*')->from($this->table_share_doc.' as s')->where('s.contact_id',$contactID)->where('s.type',$type)->where('s.lead_id',$leadID)->where('s.file_id',$fileID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row(); 
        }
		return $data;
	}
	
	function getAllSharedDocsWithID($leadID,$fileID){
		$query = $this->db->select('s.*')->from($this->table_share_doc.' as s')->where('s.file_id',$fileID)->where('s.lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function getAllSharedDocsWithContactID($contactID,$leadID,$fileID){
		$query = $this->db->select('s.*')->from($this->table_share_doc.' as s')->where('s.file_id',$fileID)->where('s.contact_id',$contactID)->where('s.lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function getAllSharedDocs($leadID,$type){
		$query = $this->db->select('s.*')->from($this->table_share_doc.' as s')->where('s.type',$type)->where('s.lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function getAllInviteesData($leadID){
		$query = $this->db->select('i.*')->from($this->table_invitees.' as i')->where('i.lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
		
	}
	
	function checkApprovalData($approvedID,$userID){
		$query = $this->db->select('a.*')->from($this->table_requests.' as a')->where('a.user_id',$userID)->where('a.id',$approvedID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row(); 
        }
		return $data;
	}
	
	function doc_list($fileType,$opportunityType){
		$query = $this->db->select('*')->from($this->table_doc_list)->where('file_type',$fileType)->where('opportunity_type',$opportunityType)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();           
        }
		return $data;
	}
	
	function insertLevel($data){
		$this->db->insert($this->table_level,$data);
		return $this->db->insert_id();
	}
	
	function updateLevel($id,$data){
		$this->db->where('lead_id', $id);
		$this->db->update($this->table_level,$data);	
		return $this->db->affected_rows();

	}
	
	function insertReport($data){
		$this->db->insert($this->table_report,$data);
		return $this->db->insert_id();
	}
	
	function updateReport($id,$data){
		$this->db->where('lead_id', $id);
		$this->db->update($this->table_report,$data);	
		return $this->db->affected_rows();

	}
	
	function insertShareDoc($data){
		$this->db->insert($this->table_share_doc,$data);
		return $this->db->insert_id();
	}
	
	function sendApprovalRequest($data){
		$data['create_date'] = date('Y-m-d');
		$this->db->insert($this->table_requests,$data);
		return $this->db->insert_id();
	}
	
	function updateApprovalData($id,$data){
		$this->db->where('id', $id);
		$this->db->update($this->table_requests,$data);	
		return $this->db->affected_rows();
	}
	
	function getMyAssignedLeads($userID){
		$query = $this->db->select('a.*,l.*')->from($this->table_leads." as l")->join($this->table_assign.' as a','l.id=a.lead_id')->where('a.pd_id',$userID)->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }			
		return $data;
	}
	
	function assigned_lead_folder_ID($leadID,$select = "l.*"){
		$query = $this->db->select($select)->from($this->table_assign." as l")->where('l.lead_id',$leadID)->get();
		if ($query->num_rows() > 0) {
			$getData = $query->first_row();
			return $getData->folder_id;
		} else{
			return false;
		}
	}
	
	function getAllLeads(){
		$query = $this->db->select('l.*,a.*')->from($this->table_leads." as l")->join($this->table_assign.' as a','l.id=a.lead_id')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	function getLeadDataBySerialNumber($serialNumber,$select){
		$query = $this->db->select($select)->from($this->table_leads." as l")->where('l.serial_number',$serialNumber)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();        
        }
		return $data;
	}
	
	function getLeadData($leadID,$select=""){
		if(!empty($select)){
			$query = $this->db->select($select)->from($this->table_leads." as l")->where('l.id',$leadID)->get();
		} else {
			$query = $this->db->select('l.*')->from($this->table_leads." as l")->where('l.id',$leadID)->get();
		}		
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();        
        }
		return $data;
	}
	
	function getLeadDataByIdWithSelect($leadID,$select ){
		$query = $this->db->select($select)->from($this->table_leads." as l")->where('l.id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();        
        }
		return $data;
	}
	
	function getAllMarketSectors(){
		$query = $this->db->select('*')->from($this->table_sectors)->order_by('name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	function updatePartnerTeamBatch($updateData){
		$this->db->trans_start();		
		$this->db->update_batch($this->table_contacts,$updateData, 'id');
		$this->db->trans_complete();     
		return ($this->db->trans_status() === FALSE)? FALSE:TRUE;
	}
	
	function insertPartnerTeamBatch($insertData){
		$this->db->insert_batch($this->table_contacts, $insertData); 
		return $this->db->insert_id();
	}
	
	function getAllMarketSectorsNotOldOperating(){
		$this->db->_protect_identifiers=false;
		$query = $this->db->select('*')->from($this->table_sectors)->where('id !=',21)->order_by('name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	function getAllCompanySectors($companyID){
		$data = array('sector'=>array(),'sub_sector'=>array());
		$querySector = $this->db->select('*')->from($this->table_company_sector)->where('company_id',$companyID)->get();
		if ($querySector->num_rows() > 0) {
            foreach ($querySector->result() as $row) {
                if($row->type==0){
					$data['sector'][] = $row;
				} else if($row->type==1){
					$data['sub_sector'][] = $row;
				}
            }            
        }
		return $data;
	}
	
	function getTechnologies($sectorID=21){
		$queryCategory = $this->db->query("SELECT * FROM ".$this->table_category." WHERE id IN (SELECT category_id FROM ".$this->table_map_sector_category."  WHERE sector_id=".(int)$sectorID.") ORDER BY name ASC");
		$data = array();
		if ($queryCategory->num_rows() > 0) {
			foreach ($queryCategory->result() as $row) {
				$querySubCategory = $this->db->select('*')->from($this->table_category)->where('type',1)->where('parent',(int)$row->id)->order_by('name','ASC')->get();
				$subCategory = array();
				if ($querySubCategory->num_rows() > 0) {
					foreach ($querySubCategory->result() as $rowSubCat) {
						$querySubSubCategory = $this->db->select('*')->from($this->table_category)->where('type',2)->where('parent',(int)$rowSubCat->id)->order_by('name','ASC')->get();
						$subSubCategory = array();
						if ($querySubSubCategory->num_rows() > 0) {
							foreach ($querySubSubCategory->result() as $rowSubSubCat) {
								$subSubCategory[] = $rowSubSubCat;
							}
						}
						$rowSubCat->sub_sub_category = $subSubCategory;
						$subCategory[] = $rowSubCat;
					}
				}
				$row->sub_category = $subCategory;
				$data[]=$row;
			}
		}
		return $data;
	}
	
	function findMyPreferenceTechnologies($companyID){
		$query = $this->db->select('preference_id')->from($this->table_technology_preference)->where('company_id',$companyID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	function getAllEouData($leadID){
		$query = $this->db->select('e.*,u.name as userName')->from($this->table_eou_data.' as e')->join($this->table_user.' as u','u.id = e.user_id')->where('lead_id',$leadID)->order_by('company','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	function getAllSepData($leadID){
		$query = $this->db->select('*')->from($this->table_sep_data)->where('lead_id',$leadID)->order_by('standard','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	function getAllSepAnotherData($leadID){
		$query = $this->db->select('*')->from($this->table_sep_another_data)->where('lead_id',$leadID)->order_by('company','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	function getAllAssets($leadID){
		$query = $this->db->select('*')->from($this->table_assets)->where('lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	function getPDUserForLead($leadID){
		$query = $this->db->select('*')->from($this->table_assign)->where('lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
           $data= $query->first_row();         
        }
		return $data;
	}
	
	function getAllUserShareList($leadID){
		$query = $this->db->select('distinct(s.contact_id) as contactID, c.*')->from($this->table_share_doc.' as s')->join($this->table_contacts.' as c','c.id = s.contact_id')->where('s.lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	function deleteAssetData($leadID){
		$this->db->delete($this->table_assets,array('lead_id'=>$leadID));		
	}
	
	function deleteCustomerTechnologyPreference($companyID,$type){
		$this->db->delete($this->table_technology_preference,array('company_id'=>$companyID,'type'=>$type));
	}
	
	function insertCustomerTechnologyPreference($data){
		$this->db->insert($this->table_technology_preference, $data);
		return $this->db->insert_id();
	}
	
	function insertCustomerTechnologyPreferenceBulk($insertData){
		$this->db->insert_batch($this->table_technology_preference, $insertData); 
		return $this->db->insert_id();
	}
	
	function addCompanySectorsInBulK($insertData){
		$this->db->insert_batch($this->table_company_sector, $insertData); 
		return $this->db->insert_id();
	}
	
	function insertAssetData($data){
		$this->db->insert($this->table_assets, $data);
		return $this->db->insert_id();
	}
	
	
	function deleteEouData($leadID){
		$this->db->delete($this->table_eou_data,array('lead_id'=>$leadID));		
	}
	
	function insertEouData($data){
		$this->db->insert($this->table_eou_data, $data);
		return $this->db->insert_id();
	}
	
	function deleteSepData($leadID){
		$this->db->delete($this->table_sep_data,array('lead_id'=>$leadID));		
	}
	
	function insertSepData($data){
		$this->db->insert($this->table_sep_data, $data);
		return $this->db->insert_id();
	}
	
	function deleteSepAnotherData($leadID){
		$this->db->delete($this->table_sep_another_data,array('lead_id'=>$leadID));		
	}
	
	function insertSepAnotherData($data){
		$this->db->insert($this->table_sep_another_data, $data);
		return $this->db->insert_id();
	}
	
	function checkStage($leadID){
		$query = $this->db->select('*')->from($this->table_stage)->where('lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function checkLevel($leadID){
		$query = $this->db->select('*')->from($this->table_level)->where('lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function checkLeadReport($leadID){
		$query = $this->db->select('*')->from($this->table_report)->where('lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function updateStage($leadID,$data){
		$this->db->where('lead_id',$leadID);
		$this->db->update($this->table_stage,$data);
		return $this->db->affected_rows();
	}
	
	function insertStage($data){
		$this->db->insert($this->table_stage, $data);
		return $this->db->insert_id();
	}
	/*
		DOCKET FUNCTIONS
	*/
	function secGetPatentDueTechAndLegal($patentNumber){
		$data = array('legal'=>array(),'tech'=>array());
		$queryLegal = $this->db2->select('id,patent_id,legal_source,legal_source_drive,legal_source1,legal_source1_drive,terminal_source,terminal_source_drive,ipr_source,ipr_source_drive,reexam_source,reexam_source_drive,litigation_source,litigation_source_drive,chain_source,chain_source_drive')->from($this->table_docket_legal)->where('patent_id',$patentNumber)->get();
		if ($queryLegal->num_rows() > 0) {
			 foreach ($queryLegal->result() as $row) {
                $data['legal'][] = $row;
            } 
		}
		$queryTech = $this->db2->select('id,patent_id,infringe_text,p_infringe')->from($this->table_docket_inventions)->where('patent_id',$patentNumber)->get();
		if ($queryTech->num_rows() > 0) {
			 foreach ($queryTech->result() as $row) {
                $data['tech'][] = $row;
            } 
		}
		return $data;
	}
	
	public function getChartCompanyDueActivityData($serialNumber,$companyID){
		$data = array('activity_data'=>array(),'activity_timing'=>array());
		$queryLicense = $this->db2->select("id")->from($this->table_docket_licenses)->where('serial_number',$serialNumber)->get();
		if ($queryLicense->num_rows() > 0) {
			$getDueData = $queryLicense->first_row();
			if(count($getDueData)>0){
				$sqlFromActivity = $this->db2->select("`id`,`name`,`start_date`,`end_date`,`patent_number`,`type`,(CASE `type` WHEN 1 THEN 'Patent List' WHEN 2 THEN 'Tech DD' WHEN 3 THEN 'Legal DD' WHEN 4 THEN 'Illustration DD' WHEN 5 THEN 'Royalty' WHEN 6 THEN 'Invitees List' WHEN 7 THEN 'Seller DD' WHEN 8 THEN 'Intro DD' WHEN 9 THEN 'Compare DD' WHEN 10 THEN 'PDF DD' WHEN 11 THEN 'Intro Images' WHEN 12 THEN 'Market DD' WHEN 13 THEN 'Dictionary DD' END) as typeName")->from($this->table_due_activity)->where('license_id',$getDueData->id)->where('user_id',$companyID)->where("patent_number <> ''")->get();
				if ($sqlFromActivity->num_rows() > 0) {
					 foreach ($sqlFromActivity->result() as $row) {
						$data['activity_data'][] = $row;
					} 
				}
				$sqlQueryTiming = "SELECT 0 as is_total, name AS Name, start_date, end_date, SEC_TO_TIME( SUM( TIME_TO_SEC(timediff(end_date, start_date)))) duration,type,CASE type WHEN 1 THEN 'Patent List' WHEN 2 THEN 'Tech DD' WHEN 3 THEN 'Legal DD' WHEN 4 THEN 'Illustration DD' WHEN 5 THEN 'Royalty' WHEN 6 THEN 'Invitees List' WHEN 7 THEN 'Seller DD' WHEN 8 THEN 'Intro DD' WHEN 9 THEN 'Compare DD' WHEN 10 THEN 'PDF DD' WHEN 11 THEN 'Intro Images' WHEN 12 THEN 'Market DD' WHEN 13 THEN 'Dictionary DD' END as typeName  FROM ".$this->table_due_activity." where license_id=".$getDueData->id."  AND user_id=".$companyID." AND patent_number <> '' GROUP BY type UNION SELECT 1 , 'Total Time Spent' , NULL , NULL , SEC_TO_TIME( SUM( TIME_TO_SEC( duration ) ) ),'Total Time Spent','Total Time Spent' FROM (
				SELECT 1 as is_total, name AS Name, start_date, end_date, SEC_TO_TIME( SUM( TIME_TO_SEC(timediff(end_date, start_date)))) duration,type  ,'Total Time Spent' FROM ".$this->table_due_activity." as da where license_id=".$getDueData->id." AND user_id=".$companyID." AND patent_number <> '' GROUP BY type
					)total ORDER BY is_total";
				$query = $this->db2->query($sqlQueryTiming);
				foreach ($query->result() as $row){
					$data['activity_timing'][] = $row;
				}
			}
		}
		return $data;
	}
	
	public function getChartDueActivityData($serialNumber,$type,$companyID){
		$data = array('activity_data'=>array(),'activity_user'=>array(),'activity_patent'=>array());
		$queryLicense = $this->db2->select("id")->from($this->table_docket_licenses)->where('serial_number',$serialNumber)->get();
		if ($queryLicense->num_rows() > 0) {
			$getDueData = $queryLicense->first_row();
			if(count($getDueData)>0){
				$sqlFromActivity = $this->db2->select("id,name,start_date,end_date,patent_number,email,history_string")->from($this->table_due_activity)->where('type',$type)->where('license_id',$getDueData->id)->where("patent_number <> ''")->where('user_id',$companyID)->get();
				if ($sqlFromActivity->num_rows() > 0) {
					 foreach ($sqlFromActivity->result() as $row) {
						$data['activity_data'][] = $row;
					} 
				}
				$sqlFromActivityDistinctUsers = $this->db2->select("name,email,telephone,linkedin")->from($this->table_due_activity)->where('type',$type)->where('license_id',$getDueData->id)->where('user_id',$companyID)->group_by('email')->get();
				if ($sqlFromActivityDistinctUsers->num_rows() > 0) {
					 foreach ($sqlFromActivityDistinctUsers->result() as $row) {
						$data['activity_user'][] = $row;
					} 
				}
				$sqlFromActivityDistinctPatentnumber = $this->db2->select("distinct(patent_number)")->from($this->table_due_activity)->where('type',$type)->where('license_id',$getDueData->id)->where('user_id',$companyID)->group_by('patent_number')->get();
				if ($sqlFromActivityDistinctPatentnumber->num_rows() > 0) {
					 foreach ($sqlFromActivityDistinctPatentnumber->result() as $row) {
						$data['activity_patent'][] = $row;
					} 
				}
			}
		}
		return $data;
	}
	
	
	function getDocketInventionDataPatentSingle($id,$select){
		$data = array();
		$queryTech = $this->db2->select($select)->from($this->table_docket_inventions)->where('id',$id)->get();
		if ($queryTech->num_rows() > 0) {
			$data = $queryTech->first_row();
		}
		return $data;
	}
	
	function getDocketInventionData($serialNumber,$select){
		 $data = array();
		$queryTech = $this->db2->select($select)->from($this->table_docket_inventions.' as i')->join($this->table_docket_due.' as d','d.patent_number = i.patent_id')->join($this->table_docket_licenses.' as l','l.id = d.license_id')->where('l.serial_number',$serialNumber)->get();
		if ($queryTech->num_rows() > 0) {
			 foreach ($queryTech->result() as $row) {
                $data[] = $row;
            } 
		}
		return $data;
	}
	
	function updateDocketDue($tableName,$postValues,$where){
		$stringName ="";
		foreach($postValues as $key=>$value){
			$stringName .=$key."='".$value."',";
		}
		$stringName = substr($stringName,0,-1);
		$sql = "UPDATE ".$tableName." SET ".$stringName." WHERE id= ".$where;
		/*echo $sql."<br/>";*/
		$result = $this->db2->query($sql);
		echo $this->db2->last_query();
		if($result){
			return $where;
		} else {
			return 0;
		}
	}
	
	function addDocketDue($tableName,$postValues){
		$stringName ="";
		$stringValue ="";
		foreach($postValues as $key=>$value){			
			$stringName .= $key.",";
			$stringValue .="'".stripslashes($value)."'".",";
		}
		$stringName = substr($stringName,0,-1);
		$stringValue =substr($stringValue,0,-1);
	    $sql = "INSERT INTO ".$tableName."(".$stringName.") VALUES (".$stringValue.")";	
		$result = $this->db2->query($sql);
		if($result){
			return 1;
		} else {
			return 0;
		}
	}
	
	function checkUrlFromDatabase($linkUrl){
		$data = array();
		$queryImg = $this->db2->select('*')->from($this->table_docket_images)->where('link',$linkUrl)->get();
		/*echo $this->db2->last_query();*/
		if ($queryImg->num_rows() > 0) {
			 $data = $queryImg->first_row();
		}
		return $data;
	}
	
	function getDuePatentData($patentNumber){
		$data = array();
		$queryImg = $this->db2->select('*')->from($this->table_docket_due)->where('patent_number',$patentNumber)->limit(1,0)->order_by('id','DESC')->get();
		if ($queryImg->num_rows() > 0) {
			$data = $queryImg->first_row();
		}
		return $data;
	}
	
	function getDuePatentDataListByLeadID($licenseID,$select){
		$data = array();
		$queryNumber = $this->db2->select($select)->from($this->table_docket_due)->where('license_id',$licenseID)->get();
		if ($queryNumber->num_rows() > 0) {
			$data = $queryNumber->result();
		}
		return $data;
	}
	
	function findCounterParts($leadID){
		$result = array();
		$getDataFromLeadPatent = $this->db->query("SELECT id, patent_number , 'Patent' as type FROM ".$this->table_lead_patent." WHERE lead_id=".(int)$leadID);
		$familyPatent = array();
		if ($getDataFromLeadPatent->num_rows() > 0) {
			$patentList = array();
			$data = array();
			foreach ($getDataFromLeadPatent->result() as $row) {
				$patentList[] = $row->patent_number;
				$data[] = (object) array('id'=>$row->id,'patent_id'=>$row->patent_number,'patent_number'=>$row->patent_number,'publication_date'=>'','patent_office'=>'','primary_language'=>'','type'=>'grant');
			}
			$query = $this->db->select('cp.*, cp.publication_number as patent_number')->from($this->table_docket_counterparts.' as cp')->where_in('cp.patent_id',$patentList)->get();
			$otherData = array();
			if ($query->num_rows() > 0) {
				$otherData = $query->result();
			}
			$result = array_merge($data,$otherData);
		}
		return $result;
	}
	
	function patentPublishedData($patentNumber,$select){
		$data = array();
		$queryNumber = $this->db2->select($select)->from($this->table_docket_counterparts)->where('patent_id',$patentNumber)->get();
		if ($queryNumber->num_rows() > 0) {
			$data = $queryNumber->result();
		}
		return $data;
	}
	
	function getLicenseDataByLeadID($serialNumber,$select){
		$data = array();
		$queryLicenseData = $this->db2->select($select)->from($this->table_docket_licenses)->where('serial_number',$serialNumber)->get();
		if ($queryLicenseData->num_rows() > 0) {
			 $data = $queryLicenseData->first_row();
		}
		return $data;
	}
	
	function getLicenseDataByID($ID,$select){
		$data = array();
		$queryLicenseData = $this->db2->select($select)->from($this->table_docket_licenses)->where('id',$ID)->get();
		if ($queryLicenseData->num_rows() > 0) {
			 $data = $queryLicenseData->first_row();
		}
		return $data;
	}
	
	function deleteDueDilligencePatent($licenseID){
		$this->db2->delete($this->table_docket_due,array('license_id'=>$licenseID));
	}
	
	function addDueDilligencePatentThroughLead($leadID,$licenseID){
		$getDataFromLeadPatent = $this->db->select('patent_number')->from($this->table_lead_patent)->where('lead_id',$leadID)->get();
		$dataInsert = 0;
		if ($getDataFromLeadPatent->num_rows() > 0) {
			foreach ($getDataFromLeadPatent->result() as $row) {
				$this->db2->insert($this->table_docket_due,array('patent_number'=>$row->patent_number,'license_id'=>$licenseID));	
				$dataInsert =  $this->db2->insert_id();	
			}
		}
		return $dataInsert;
	}
	
	function findFamilyPatents($leadID){
		/*$getDataFromLeadPatent = $this->db->select("patent_number , 'Patent' as type")->from($this->table_lead_patent)->where('lead_id',$leadID)->get();*/
		$getDataFromLeadPatent = $this->db->query("SELECT patent_number , 'Patent' as type FROM ".$this->table_lead_patent." WHERE lead_id=".(int)$leadID);
		$familyPatent = array();
		if ($getDataFromLeadPatent->num_rows() > 0) {
			$patentList = array();
			foreach ($getDataFromLeadPatent->result() as $row) {
				$familyPatent[] = $row;
				$patentList[] = $row->patent_number;
			}
			if(count($familyPatent)){
				$getDataFromLeadPatentFamily = $this->db->select("distinct(child_number) as patent_number , type")->from($this->table_lead_patent_family)->where_in('parent_number',$patentList)->where_not_in('child_number',$patentList)->get();
				foreach ($getDataFromLeadPatentFamily->result() as $rowFamily) {
					$familyPatent[] = $rowFamily;
				}
			}
		}
		return $familyPatent;
	}
	
	function findScrapDataFromParent($leadID,$select){
		$getData = $this->db->select($select)->from($this->table_lead_patent_scrap_data.' as sd')->join($this->table_lead_patent.' as lp','lp.patent_number = sd.patent_number')->where('lp.lead_id',$leadID)->get();
		$getPublishedData = array();
		if ($getData->num_rows() > 0) {
			foreach ($getData->result() as $row) {
				$getPublishedData[] =  $row;
			}
		}
		return $getPublishedData;
	}
	
	function updateLicenseAccessCode($data,$id=0,$serialNumber=0){
		if($id>0){
			$this->db2->where('id',$id);
		}
		if($serialNumber>0){
			$this->db2->where('serial_number',$serialNumber);
		}
		if($id>0 || $serialNumber>0){
			$this->db2->update($this->table_docket_licenses,$data);
			return $this->db2->affected_rows();
		} else {
			return 0;
		}		
	}
	
	function getDocketTemplateAccordion($licenseNumber,$select){
		$data = array();
		$queryAccessCode = $this->db2->select('id,'.$select)->from($this->table_docket_licenses)->where('license_number',$licenseNumber)->get();
		if ($queryAccessCode->num_rows() > 0) {
			 $data = $queryAccessCode->first_row();
		}
		return $data;
	}
	
	function changeLicenseAccessCode($leadID,$dataUpdate){
		$data = 0;
		$getLead = $this->getLeadData($leadID,'l.serial_number');
		if(count($getLead)>0){
			$data = $this->updateLicenseAccessCode($dataUpdate,0,$getLead->serial_number);
		}
		return $data;
	}
	
	function check_docket_password($leadID,$fileType=0){
		$data = array();
		if($fileType>0){
			$getLead = $this->getLeadData($leadID,'l.serial_number');
			if(count($getLead)>0){
				$passwordColumn="";
				$passwordEmailColumn = "";
				switch($fileType){
					case 2:
						/*techdd*/
						$passwordColumn="tech_access_code";
						$passwordEmailColumn = "tech_email_address";
					break;
					case 3:
						/*legaldd*/
						$passwordColumn="legal_access_code";
						$passwordEmailColumn = "legal_email_address";
					break;
					case 4:
						/*legaldd*/
						$passwordColumn="illus_access_code";
						$passwordEmailColumn = "illus_email_address";
					break;
					case 7:
						/*seller*/
						$passwordColumn="due_access_code";
						$passwordEmailColumn = "email_address";
					break;
					case 8:
						/*edit*/
						$passwordColumn="portfolio_access_code";
						$passwordEmailColumn = "portfolio_email_address";
					break;
					case 9:
						/*comparedd*/
						$passwordColumn="comparables_access_code";
						$passwordEmailColumn = "comparables_email_address";
					break;
					case 10:
						/*pdfdd*/
						$passwordColumn="pdf_access_code";
						$passwordEmailColumn = "pdf_email_address";
					break;
					case 11:
						/*introimages*/
						$passwordColumn="images_access_code";
						$passwordEmailColumn = "images_email_address";
					break;
					case 12:
						$passwordColumn="market_access_code";
						$passwordEmailColumn = "market_email_address";
					break;
					case 13:
						$passwordColumn="dictionary_access_code";
						$passwordEmailColumn = "dictionary_email_address";
					break;
				}
				if(!empty($passwordColumn) && !empty($passwordEmailColumn)){
					$combineSelect = $passwordColumn.", ".$passwordEmailColumn ;
					$queryAccessCode = $this->db2->select('id,'.$combineSelect)->from($this->table_docket_licenses)->where('serial_number',$getLead->serial_number)->get();
					if ($queryAccessCode->num_rows() > 0) {
						 $accessData = $queryAccessCode->first_row();
						 $data['id'] = $accessData->id;
						 $data['file_type'] = $fileType;
						 $data['access_code'] = $accessData->{$passwordColumn};
						 $data['email_address'] = $accessData->{$passwordEmailColumn};
						 $data['columns'] = array($passwordColumn,$passwordEmailColumn);
					}
				}
			}
		}
		return $data;
	}
	
	
}
?>