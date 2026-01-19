<?php
class lead_model extends CI_Model{	
	public $table_lead = 'litigations';
	public $table_lead_headings = 'lead_headings';
	public $table_comment = 'other_comments';
	public $table_box = 'box_list';
    public $table_history = 'history';
    public $table = 'users'; 
   	public $table_assign_lead = 'assign_leads';	
	public $table_assign_lead_type = 'assign_lead_type';
	public $table_gmail = "messages_gmail";
	public $table_requests = 'approval_requests';
	public $table_chart = "lead_chart";
	public $table_acquisition = "acquisition";
	public $table_lead_category = "lead_category";
	public $table_stage = 'lead_stages';
	public $table_level = 'lead_levels';
	public $table_report = 'lead_reports';
	public $table_lead_open_project = 'lead_open_project';
	public $table_buttons = 'buttons';
	public $table_lead_buttons = 'lead_buttons';
	public $table_lead_event = 'lead_event';
	public $table_docket_buttons = 'docket_buttons';
	public $table_contacts_access = 'contacts_access';
	public $table_task_conversation = 'task_conversation';
	public $table_task_flag = 'task_message_flag';
	public $table_contacts = 'contacts';
	public $table_company = 'company';
	public $table_invitees = 'backyard_invitees';
	public $table_pos_agreements = 'pos_agreements';
	public $table_sales_activity = 'sales_activity_log_detail';
	public $table_presale_broker = 'presale_broker';
	public $table_presales_activity = 'presale_activity_log_detail';
	public $table_acquisition_company = 'acquisition_company';
	public $table_acquisition_activity = 'acquisition_activity_log_detail';
	public $table_lead_template = 'lead_template_files';
	public $table_lead_bank_template = 'email_template';
	public $table_precontacts = 'pre_contacts';
	public $table_precompanies = 'pre_companies';
	public $table_free_precontacts = 'free_precontacts';
	public $table_litigation_scrap = 'litigation_scrap';
	public $table_campaign = 'campaigns';
	public $table_campaign_list = 'campaign_sender_lists';
	public $table_sector = "sectors";
	public $table_company_sector = 'company_sector';
	public $table_campaign_process = 'campaign_process';
	public $table_sales_broker_lead_company = 'sales_broker_lead_company';
	public $table_activity_log = 'activity_log_detail';
	public $table_linkedin_query = 'linkedin_query';
	public $table_linkedin_expression = 'linkedin_query_expression';
	public $table_category = 'category';
	public $table_preference = 'preferences';
	public $table_temp_contacts = 'temp_contacts';
	public $table_map_sectors_departments = 'map_sectors_departments';
	public $table_user_logtime = 'user_logtime';
	public $table_email_raw = 'email_raw';
	public $table_lead_patent = 'lead_patent';
	public $table_lead_patent_family = 'lead_patent_family';
	public $table_lead_patent_scrap_data = 'lead_patent_scrap_data';
	public $table_lead_patent_family_diagram = 'lead_patent_family_diagram';
	public $table_due_dilligence_illustrations = 'due_dilligence_illustrations';
	public $table_due_dilligence_inventions = 'due_dilligence_inventions';
	public $table_due_dilligence_legal = 'due_dilligence_legal';
	public $table_due_dilligence_pdf = 'due_dilligence_pdf';
	public $table_licenses = 'licenses';
	public $table_comparables = 'comparables';
	public $table_invitees_due = 'invitees';
	public $table_chart_lefts = 'chart_lefts';
	public $table_due_dilligences = 'due_dilligences';
	public $table_job_queue = 'job_queue';
	public $table_damages = 'damages';
	public $table_request_to_participate = 'request_to_participates';
	public $table_potential_participates = 'potential_participates';
	public $table_draft_revised_documents = 'draft_revised_documents';
	public $table_customer_request = 'customer_request';
	public $table_customer_transactions = 'customer_transactions';
	public $table_commitments = 'commitments';
	public $table_revised_documents = 'revised_documents';
	public $table_patent_family_illustration = 'patent_family_illustration';
	public $table_lead_patent_family_parent_child = 'lead_patent_family_parent_child';
	public $table_lead_patent_family_child = 'lead_patent_family_child';
	public $table_patent_illustration_detail = 'patent_illustration_detail';
	public $table_family_patent_relation = 'lead_patent_family_relation';
	public $table_patent_family_member = 'lead_patent_family_member';
	public $table_request_for_check_availabilty = 'request_for_check_availabilty';
	public $table_customers = 'customers';
	public $table_customer_deal_flow = 'customer_deal_flow';
	public $table_participates_unpromising = 'participates_unpromising';
	public $table_license_granted = 'license_granted';
	public $table_customer_license_agreements = 'customer_license_agreements';
	public $table_scanned_business_card = 'scanner_images';
	public $table_scraper_lead_parent = 'scraper_lead_parent';
	public $table_scraper_lead_child = 'scraper_lead_child';
	public $table_temp_companies = 'temp_companies';
	public $table_technology_preference = 'technology_preference';
	public $table_lead_patent_series_code = 'lead_patent_series_code';
	public $table_lead_patent_assignment = 'lead_patent_assignment';
	public $table_lead_patent_assigment_relation = 'lead_patent_assigment_relation';
	public $table_lead_assignment_names = 'lead_assignment_names';
	public $table_lead_assignment_heading = 'lead_assignment_heading';
	public $table_due_dilligence_citations = 'due_dilligence_citations';
	public $table_due_dilligence_titles = 'due_dilligence_titles';
	public $table_lead_assignment_heading_list = 'lead_assignment_heading_list';
	public $table_lead_assignment_box = 'lead_assignment_box';
	public $table_all_panjiva = 'all_panjiva';
	public $table_company_other_names = 'company_other_names';
	public $table_scrapper_linkedin_message_sync = 'scrapper_linkedin_message_sync';
	public $table_sources = 'sources';
	public $table_lead_notepad = 'lead_note';
	public $table_sec_agreements = 'sec_agreements';
	public $table_scrapper_litigation_scrape = 'scrapper_litigation_scrape';
	public $table_lead_litigation = 'lead_litigation';
	public $table_store_images = 'store_images';
	public $table_linkedin_threads = 'linkedin_threads';
	public $table_linkedin_messages = 'linkedin_messages';
	public $table_send_linkedin_messages = 'send_linkedin_messages';
	public $table_source_url = 'source_for_contacts';
	public $table_email_notification = 'email_notification';
	public $sOpen = array();
	public $myAllRelationList = array();
	public $myAllRelationDataList = array();
	public $myAllDetailList = array();
	public $select = 'l.id,l.serial_number,l.lead_name,l.type ,l.create_date ,l.seller_info ,l.seller_info_text ,l.seller_like ,l.funding_trnsfr ,l.complete ,l.status ,l.synpat_like ,l.ppa_id ,l.ppa_text_date ,l.execute_ppa ,l.ppa_execute ,l.ppa_date ,l.plantiffs_name ,l.technologies ,l.no_of_us_patents ,l.no_of_non_us_patents ,l.send_proposal_letter ,l.market_data ,l.seller_contact ,l.broker_contact,l.broker,l.broker_person ,l.broker_person_contact ,l.person_name_1 ,l.person_title_1,l.option_expiration_date ,l.person_name_2 ,l.person_title_2 ,l.address ,l.relates_to ,l.expected_price ,l.update_date,l.column8,l.column9,l.column10,l.column11,l.column12,l.column13,l.column14,l.column15,l.column25,l.column26,l.column27,l.column28,l.column29,l.column30,l.column31,l.column32,l.column33,l.column34,l.column35';
	public function __construct() {
		parent::__construct();			
	}
	
	public function addUpdatePatentIllustrationFile($fileUrl,$patent){
		$query = $this->db->select("id")->from($this->table_due_dilligence_illustrations)->where('patent_id',$patent)->order_by('id','DESC')->get();
		if ($query->num_rows() > 0) {
			$row = $query->first_row();
			$this->db->where('id',$row->id);
			$this->db->update($this->table_due_dilligence_illustrations,array('file'=>$fileUrl,'status'=>0));
			return $this->db->affected_rows();
		} else {
			$this->db->insert($this->table_due_dilligence_illustrations,array('patent_id'=>$patent,'file'=>$fileUrl));
			return $this->db->insert_id();
		}
	}
	
	public function updateAllBUttonsSort(){
		$query = $this->db->select("id,sort")->from($this->table_buttons)->order_by('sort')->get();
		if ($query->num_rows() > 0) {	
			foreach($query->result() as $row){	
				$this->db->where('button_id',$row->id);
				$this->db->update($this->table_lead_buttons,array('sort'=>$row->sort));
				$this->db->affected_rows();
			}
		}
	}
	
	public function updateAllInOne(){
		$query = $this->db->select("lead_id,company_id")->from($this->table_acquisition_activity)->group_by('lead_id')->group_by('company_id')->order_by('lead_id','ASC')->get();
		if ($query->num_rows() > 0) {	
			foreach($query->result() as $row){				
				$activityDate = $this->db->select("activity_date")->from($this->table_acquisition_activity)->where('lead_id',$row->lead_id)->where('company_id',$row->company_id)->order_by('activity_date','DESC')->limit(1)->get();
				if($activityDate->num_rows()>0){
					$activityData = $activityDate->first_row();
					$this->db->where('contact_id',$row->company_id)->where('lead_id',$row->lead_id)->update($this->table_acquisition_company,array('last_activity'=>$activityData->activity_date));
					echo $this->db->last_query();
				}
			}
		}
	}
	
	
	
	function getMergePreContactsAndContact(){
		/*truncate table temp*/
		$this->db->query("TRUNCATE ".$this->table_temp_contacts);
		/*INSERT DATA FROM  CONTACTS*/
		$this->db->query("INSERT INTO ".$this->table_temp_contacts."(`first_name`,`last_name`,`company_name`,`job_title`,`email`,`telephone`,`cellphone`,`linkedin_url`,`img_card`,`contact_type`,`contact_id`) SELECT c.first_name,c.last_name,co.company_name,c.job_title,c.email,c.telephone,c.phone,c.linkedin_url,c.img_card,1,c.id FROM ".$this->table_contacts." as c INNER JOIN ".$this->table_company." as co ON co.id = c.company_id");
		/*INSERT DATA FROM  PRECONTACTS*/
		$this->db->query("INSERT INTO ".$this->table_temp_contacts."(`first_name`,`last_name`,`company_name`,`job_title`,`email`,`telephone`,`cellphone`,`linkedin_url`,`img_card`,`contact_type`,`contact_id`) SELECT c.first_name,c.last_name,c.company_name,c.job_title,c.email,c.telephone,c.cellphone,c.profile_url,c.img_card,0,c.id FROM ".$this->table_precontacts." as c");		
		/*$query = $this->db->query("SELECT i.id, i.first_name,i.last_name,i.job_title,i.company_name,i.contact_id,i.contact_type FROM ".$this->table_temp_contacts." i
INNER JOIN (
 SELECT last_name
    FROM ".$this->table_temp_contacts."
    GROUP BY last_name,first_name
    HAVING COUNT( id ) > 1
) j ON i.last_name=j.last_name order by i.last_name");*/
		/*$query = $this->db->query("SELECT distinct(i.contact_id),i.id, i.first_name,i.last_name,i.job_title,i.email,i.telephone,i.cellphone,i.linkedin_url,i.company_name,i.img_card,i.contact_type FROM ".$this->table_temp_contacts." i
INNER JOIN (
 SELECT last_name
    FROM ".$this->table_temp_contacts."
    GROUP BY last_name,first_name
    HAVING COUNT( id ) > 1
) j ON i.last_name=j.last_name  INNER JOIN (SELECT first_name  FROM ".$this->table_temp_contacts."   GROUP BY first_name,last_name    HAVING  COUNT( id ) > 1) j1 
	ON i.first_name=j1.first_name   order by i.first_name ASC , i.last_name ASC");*/
		/*$preQuery = $this->db->query('SELECT id, first_name, last_name    FROM '.$this->table_temp_contacts.'    GROUP BY last_name,first_name HAVING  COUNT( id ) > 1');		
		$data = array();
		if ($preQuery->num_rows() > 0) {			
			foreach($preQuery->result() as $row){ 
				$postQuery = $this->db->query('SELECT distinct(i.contact_id),i.id, i.first_name,i.last_name,i.job_title,i.email,i.telephone,i.cellphone,i.linkedin_url,i.company_name,i.img_card,i.contact_type    FROM '.$this->table_temp_contacts.'  as i WHERE trim(i.first_name) = "'.trim($row->first_name).'" AND trim(i.last_name) = "'.trim($row->last_name).'"');		
				if ($postQuery->num_rows() > 1) {
					foreach($postQuery->result() as $postRow){ 
						$data[] = $postRow;
					}
				}				
			}
		}*/
		/*$preQuery = $this->db->query('select distinct(a1.contact_id),a1.id, a1.first_name,a1.last_name,a1.job_title,a1.email,a1.telephone,a1.cellphone,a1.linkedin_url,a1.company_name,a1.img_card,a1.contact_type  from temp_contacts a1 
inner join (select first_name, last_name,linkedin_url, count(id)  from temp_contacts  where first_name is not null   and last_name is not null  and linkedin_url is not null  group by first_name, last_name  having count(id)>1) u1 on u1.first_name = a1.first_name and u1.last_name = a1.last_name and u1.linkedin_url<> a1.linkedin_url order by a1.first_name ASC,a1.last_name ASC');*/
$preQuery = $this->db->query('select distinct(a1.contact_id),a1.id, a1.first_name,a1.last_name,a1.linkedin_url as linkedinUrl,u1.linkedin_url as linkedinUrl1,a1.job_title,a1.email,a1.telephone,a1.cellphone,a1.company_name,a1.img_card,a1.contact_type  from temp_contacts a1 
inner join 
(select first_name, last_name,linkedin_url, count(id)  from temp_contacts  
  where first_name is not null   
  and last_name is not null  
  group by first_name, last_name  
  having count(id)>1)
u1 on u1.first_name = a1.first_name and u1.last_name = a1.last_name 
WHERE ( u1.linkedin_url<> a1.linkedin_url)
order by a1.first_name ASC,a1.last_name ASC');
		$data = array();
		/*if ($preQuery->num_rows() > 0) {			
			foreach($preQuery->result() as $row){
				$data[] = $row;
			}
		}*/
		$finalData = array();
		if ($preQuery->num_rows() > 0) {
			foreach($preQuery->result() as $row){ 
				if($row->linkedinUrl1==$row->linkedinUrl){
					$data[] = $row;
				} else if(is_null($row->linkedinUrl1) || empty($row->linkedinUrl1)){
					$data[] = $row;
				}
				
				/*$postQuery = $this->db->query('SELECT distinct(i.contact_id),i.id, i.first_name,i.last_name,i.job_title,i.email,i.telephone,i.cellphone,i.linkedin_url,i.company_name,i.img_card,i.contact_type FROM '.$this->table_temp_contacts.'  as i WHERE trim(i.first_name) = "'.trim($row->first_name).'" AND trim(i.last_name) = "'.trim($row->last_name).'"');		
				if ($postQuery->num_rows() > 1) {
					foreach($postQuery->result() as $postRow){ 
						$data[] = $postRow;
					}
				}*/				
			}
			/*echo "<pre>";
			print_r($data);
			echo "</pre>";*/
			$finalData = $data;
			$newData = array();
			if(count($data)>0){
				foreach($data as $dt){
					$postQuery = $this->db->query('SELECT distinct(i.contact_id),i.id, i.first_name,i.last_name,i.job_title,i.email,i.telephone,i.cellphone,i.linkedin_url,i.company_name,i.img_card,i.contact_type    FROM '.$this->table_temp_contacts.'  as i WHERE contact_id!='.$dt->contact_id.' AND trim(i.first_name) = "'.trim($dt->first_name).'" AND trim(i.last_name) = "'.trim($dt->last_name).'"');	
					/*echo $this->db->last_query()."<br/>";*/					
					if ($postQuery->num_rows() > 0) {
						foreach($postQuery->result() as $postRow){ 
							/*echo "<pre>";
							print_r($postRow);
							echo "</pre>";*/
							$finalData[] = $postRow;
						}
					}
				}
			}
			$allContact = array();
			if(count($finalData)>0){
				foreach($finalData as $nd){
					if(!in_array($nd->id,$allContact)){
						$allContact[] = $nd->id;
					}
				}
			}
			if(count($allContact)>0){
				/*echo "<pre>";
				print_r($allContact);
				echo "</pre>";*/
				$postQuery = $this->db->query('SELECT distinct(i.contact_id),i.id, i.first_name,i.last_name,i.job_title,i.email,i.telephone,i.cellphone,i.linkedin_url,i.company_name,i.img_card,i.contact_type FROM '.$this->table_temp_contacts.'  as i WHERE i.id IN ('.implode(",",$allContact).') ORDER BY first_name ASC,last_name ASC ');		
				if ($postQuery->num_rows() > 0) {
					foreach($postQuery->result() as $postRow){ 
						$newData[] = $postRow;
					}
				}
			}
			
		}
		/*echo "<pre>";
		print_r($newData);
		die;*/
		return $newData;
	}
	
	public function findPatentChildFamily($patent){
		$data = array('links'=>array(),'details'=>array(),'main'=>array());
		$lengthString = strlen($patent);
		$first2Digit = "";
		switch($lengthString){
			case 9:
				$patentData =substr($patent,2);
				$first2Digit = substr($patent,0,2);
			break;
			case 11:
			case 13:
				$first2Digit = substr($patent,0,2);
				$patentData =substr($patent,2);
				$patentData =substr($patentData,0,-2);
			break;
			default:
				$patentData = $patent;
			break;
		}
		if(isset($patentData) && !empty($patentData) && strlen($patentData)==7 && ($first2Digit=="" || strtolower($first2Digit)=="us")){
			$queryPatent = $this->db->select('*')->from($this->table_patent_illustration_detail)->where('patent_app_number',$patentData)->get();
			if ($queryPatent->num_rows() > 0) {	
				$mainPatentDetail = $queryPatent->first_row();
				$data['main'] = $mainPatentDetail;
				/*Find patent child*/	
				$parentList = array();
				$childList = array();
			}
		}
	}
	
	public function findFromRealTimeParentChildScrap($patent){
		$data = array('parent'=>array(),'child'=>array());
		$lengthString = strlen($patent);
		$first2Digit = "";
		switch($lengthString){
			case 9:
				$patentData =substr($patent,2);
				$first2Digit = substr($patent,0,2);
			break;
			case 11:
			case 13:
				$first2Digit = substr($patent,0,2);
				$patentData =substr($patent,2);
				$patentData =substr($patentData,0,-2);
			break;
			default:
				$patentData = $patent;
			break;
		}		
		if(isset($patentData) && !empty($patentData) && strlen($patentData)==7 && ($first2Digit=="" || strtolower($first2Digit)=="us")){	
			$checkParent = $this->db->select('*')->from($this->table_scraper_lead_parent)->where('prime',1)->where('patent_number',$patentData)->get();
			if($checkParent->num_rows()>0){
				$findPatentAppNumber = $this->db->select('application_number')->from($this->table_patent_illustration_detail)->where('patent_app_number',$patentData)->get()->row();
				if(count($findPatentAppNumber)>0){
					$appNumber = $findPatentAppNumber->application_number;
					foreach($checkParent->result() as $row){
						$data['parent'][] = array('pat_app_number'=>$appNumber,'relation_number'=>$row->pat_app_number,'parent'=>1,'child'=>0,'relation_type'=>$row->relation_status);
					}
					$queryChildLinks = $this->db->select('*')->from($this->table_scraper_lead_child)->where('patent_number',$patentData)->get();
					if($queryChildLinks->num_rows()>0){
						foreach($queryChildLinks->result() as $row){
							$data['child'][] = array('pat_app_number'=>$row->pat_app_number,'relation_number'=>$row->relation_number,'parent'=>0,'child'=>1,'relation_type'=>$row->relation_status);
						}
					}
				}
			} else {
				$queryChildLinks = $this->db->select('*')->from($this->table_scraper_lead_child)->where('patent_number',$patentData)->get();
				if($queryChildLinks->num_rows()>0){
					foreach($queryChildLinks->result() as $row){
						$data['child'][] = array('pat_app_number'=>$row->pat_app_number,'relation_number'=>$row->relation_number,'parent'=>0,'child'=>1,'relation_type'=>$row->relation_status);
					}
				}
			}
		}
		return $data;
	}
	
	public function findFromRealTimeScrap($patent){
		$data = array('links'=>array(),'details'=>array());
		$lengthString = strlen($patent);
		$first2Digit = "";
		switch($lengthString){
			case 9:
				$patentData =substr($patent,2);
				$first2Digit = substr($patent,0,2);
			break;
			case 11:
			case 13:
				$first2Digit = substr($patent,0,2);
				$patentData =substr($patent,2);
				$patentData =substr($patentData,0,-2);
			break;
			default:
				$patentData = $patent;
			break;
		}
		$links = array();
		$allAppNumbers = array();
		if(isset($patentData) && !empty($patentData) && strlen($patentData)==7 && ($first2Digit=="" || strtolower($first2Digit)=="us")){	
			$checkParent = $this->db->select('*')->from($this->table_scraper_lead_parent)->where('prime',1)->where('patent_number',$patentData)->get();
			
			if($checkParent->num_rows()>0){
				$findPatentAppNumber = $this->db->select('application_number')->from($this->table_patent_illustration_detail)->where('patent_app_number',$patentData)->get();
				if(count($findPatentAppNumber)>0){
					$appNumber = $findPatentAppNumber->application_number;
					foreach($checkParent->result() as $row){
						$links[] = array('patent_app_number'=>$appNumber,'relation_number'=>$row->pat_app_number,'parent'=>1,'child'=>0,'relation_type'=>$row->relation_status);
						array_push($allAppNumbers,$appNumber);
						array_push($allAppNumbers,$row->pat_app_number);
					}
					$queryChildLinks = $this->db->select('*')->from($this->table_scraper_lead_child)->where('patent_number',$patentData)->get();
					if($queryChildLinks->num_rows()>0){
						foreach($queryChildLinks->result() as $row){
							$links[] = array('patent_app_number'=>$row->patent_app_number,'relation_number'=>$row->relation_number,'parent'=>0,'child'=>1,'relation_type'=>$row->relation_status);
							array_push($allAppNumbers,$row->patent_app_number);
							array_push($allAppNumbers,$row->relation_number);
						}
					}
				}
			} else {
				$queryChildLinks = $this->db->select('*')->from($this->table_scraper_lead_child)->where('patent_number',$patentData)->get();
				if($queryChildLinks->num_rows()>0){
					foreach($queryChildLinks->result() as $row){
						$links[] = array('patent_app_number'=>$row->patent_app_number,'relation_number'=>$row->relation_number,'parent'=>0,'child'=>1,'relation_type'=>$row->relation_status);
						array_push($allAppNumbers,$row->patent_app_number);
						array_push($allAppNumbers,$row->relation_number);
					}
				}
			}
		}
		if(count($links)>0){
			$data['links'] = $links;
			$detailsListNumber = array_unique($allAppNumbers);
			$this->db->_protect_identifiers=false;
			$childDetails = $this->db->select('distinct(application_number) as appNumber, d.*')->from($this->table_patent_illustration_detail.' as d')->where_in('application_number',$detailsListNumber)->order_by('str_to_date(`filling_date`, "%m-%d-%Y")','ASC')->get();
			if ($childDetails->num_rows() > 0) {	
				foreach($childDetails->result() as $row){
					$allDetails[] = $row;
				}
				$data['details'] = $allDetails;	
			}
		}
		return $data;
	}
	
	public function getAllRelationForPatent($patent){
		$lengthString = strlen($patent);
		$first2Digit = "";
		switch($lengthString){
			case 9:
				$patentData =substr($patent,2);
				$first2Digit = substr($patent,0,2);
			break;
			case 11:
			case 13:
				$first2Digit = substr($patent,0,2);
				$patentData =substr($patent,2);
				$patentData =substr($patentData,0,-2);
			break;
			default:
				$patentData = $patent;
			break;
		}
		$links = array();
		$allAppNumbers = array();
		if(isset($patentData) && !empty($patentData) && strlen($patentData)==7 && ($first2Digit=="" || strtolower($first2Digit)=="us")){	
			$checkParent = $this->db->select('*')->from($this->table_scraper_lead_parent)->where('prime',1)->where('patent_number LIKE ','%'.$patentData.'%')->order_by('id','ASC')->get();
			if($checkParent->num_rows()>0){
				foreach($checkParent->result() as $row){
					$links[] = array('patent_app_number'=>$row->pat_app_number,'relation_number'=>$row->relation_number,'parent'=>1,'child'=>0,'relation_type'=>$row->relation_status,'extended_family'=>$row->extended_family,'prime'=>$row->prime,'search'=>0);
					array_push($allAppNumbers,$row->relation_number);
					array_push($allAppNumbers,$row->pat_app_number);
				}				
			}
			$queryChildLinks = $this->db->select('*')->from($this->table_scraper_lead_child)->where('patent_number LIKE ','%'.$patentData.'%')->get();
			if($queryChildLinks->num_rows()>0){
				foreach($queryChildLinks->result() as $row){
					$links[] = array('patent_app_number'=>$row->pat_app_number,'relation_number'=>$row->relation_number,'parent'=>0,'child'=>1,'relation_type'=>$row->relation_status,'extended_family'=>$row->extended_family,'prime'=>0,'search'=>$row->search);
					array_push($allAppNumbers,$row->pat_app_number);
					array_push($allAppNumbers,$row->relation_number);
				}
			}
		}
		$allDetails = array();
		if(count($links)>0){
			$detailsListNumber = array_unique($allAppNumbers);
			$this->db->_protect_identifiers=false;
			$childDetails = $this->db->select('distinct(patent_number) as patNumber')->from($this->table_patent_illustration_detail.' as d')->where_in('application_number',$detailsListNumber)->order_by('str_to_date(`filling_date`, "%m-%d-%Y")','ASC')->get();
			if ($childDetails->num_rows() > 0) {	
				foreach($childDetails->result() as $row){
					$allDetails[] = $row->patNumber;
				}
			}
		}
		return $allDetails;
	}
	
	public function findFromRealTimeEPO($patent){
		$data = array('links'=>array(),'details'=>array());
		$lengthString = strlen($patent);
		$first2Digit = "";
		switch($lengthString){
			case 9:
				$patentData =substr($patent,2);
				$first2Digit = substr($patent,0,2);
			break;
			case 11:
			case 13:
				$first2Digit = substr($patent,0,2);
				$patentData =substr($patent,2);
				$patentData =substr($patentData,0,-2);
			break;
			default:
				$patentData = $patent;
			break;
		}
		$links = array();
		$allAppNumbers = array();
		if(isset($patentData) && !empty($patentData) && strlen($patentData)==7 && ($first2Digit=="" || strtolower($first2Digit)=="us")){	
			$checkParent = $this->db->select('*')->from($this->table_scraper_lead_parent)->where('prime',1)->where('patent_number LIKE ','%'.$patentData.'%')->order_by('id','ASC')->get();
			if($checkParent->num_rows()>0){
				foreach($checkParent->result() as $row){
					$links[] = array('patent_app_number'=>$row->pat_app_number,'relation_number'=>$row->relation_number,'parent'=>1,'child'=>0,'relation_type'=>$row->relation_status,'extended_family'=>$row->extended_family,'prime'=>$row->prime,'search'=>0);
					array_push($allAppNumbers,$row->relation_number);
					array_push($allAppNumbers,$row->pat_app_number);
				}				
			}
			$queryChildLinks = $this->db->select('*')->from($this->table_scraper_lead_child)->where('patent_number LIKE ','%'.$patentData.'%')->get();
			if($queryChildLinks->num_rows()>0){
				foreach($queryChildLinks->result() as $row){
					$links[] = array('patent_app_number'=>$row->pat_app_number,'relation_number'=>$row->relation_number,'parent'=>0,'child'=>1,'relation_type'=>$row->relation_status,'extended_family'=>$row->extended_family,'prime'=>0,'search'=>$row->search);
					array_push($allAppNumbers,$row->pat_app_number);
					array_push($allAppNumbers,$row->relation_number);
				}
			}
		}
		if(count($links)>0){
			$data['links'] = $links;
			$detailsListNumber = array_unique($allAppNumbers);
		/*	echo "<pre>";
			print_r($detailsListNumber);
			die;*/
			$this->db->_protect_identifiers=false;
			$childDetails = $this->db->select('distinct(application_number) as appNumber, d.*')->from($this->table_patent_illustration_detail.' as d')->where_in('application_number',$detailsListNumber)->order_by('str_to_date(`filling_date`, "%m-%d-%Y")','ASC')->get();
			if ($childDetails->num_rows() > 0) {	
				foreach($childDetails->result() as $row){
					$allDetails[] = $row;
				}
				$data['details'] = $allDetails;	
			}
		}
		return $data;
	}
	
	public function findPatentFamilyChild($patent){
		/*$data = array('links'=>array(),'details'=>array(),'main'=>array(),'all_datas'=>array());*/
		$data = array('links'=>array(),'details'=>array(),'main'=>array());
		$lengthString = strlen($patent);
		$first2Digit = "";
		switch($lengthString){
			case 9:
				$patentData =substr($patent,2);
				$first2Digit = substr($patent,0,2);
			break;
			case 11:
			case 13:
				$first2Digit = substr($patent,0,2);
				$patentData =substr($patent,2);
				$patentData =substr($patentData,0,-2);
			break;
			default:
				$patentData = $patent;
			break;
		}
		if(isset($patentData) && !empty($patentData) && strlen($patentData)==7 && ($first2Digit=="" || strtolower($first2Digit)=="us")){				
			$queryPatent = $this->db->select('*')->from($this->table_patent_illustration_detail)->where('patent_app_number',$patentData)->get();
			
			if ($queryPatent->num_rows() > 0) {	
				/*$data['details'] = $queryPatent->first_row();*/				
				$mainPatentDetail = $queryPatent->first_row();
				
				$data['main'] = $mainPatentDetail;
				/*Find patent child*/	
				$parentList = array();
				$childList = array();
				$patentParentList = $this->db->select('patent_app_number,relation_number,parent,child,relation_type')->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$mainPatentDetail->application_number)->where('parent',1)->order_by('id','ASC')->get();
				/*array_push($this->myAllRelationDataList,array('id'=>(int)$this->filterInt($mainPatentDetail->application_number),'description'=> $mainPatentDetail->application_number, 'email'=> "", 'groupTitleColor'=> "#4169e1", 'image'=>"", 'itemTitleColor'=> "#4169e1", 'phone'=> "",'relation_number'=>$mainPatentDetail->application_number , 'title'=> $mainPatentDetail->patent_app_number, 'label'=> $mainPatentDetail->patent_app_number));*/
				if ($patentParentList->num_rows() > 0) {	
					$myParents = array();
					foreach($patentParentList->result() as $row){
						$parentList[] = $row;
						array_push($this->sOpen,$row->patent_app_number);
						/*array_push($this->sOpen,$row->relation_number);*/
						array_push($this->myAllRelationList,$row);
						$myParents[] = (int)$this->filterInt($row->relation_number);
					}
					/*array_push($this->myAllRelationDataList,array('id'=>(int)$this->filterInt($mainPatentDetail->application_number), 'parent'=>$myParents,'description'=> $mainPatentDetail->application_number, 'email'=> "", 'groupTitleColor'=> "#4169e1", 'image'=>"", 'itemTitleColor'=> "#4169e1", 'phone'=> "",'relation_number'=>$mainPatentDetail->application_number , 'title'=> $mainPatentDetail->patent_app_number, 'label'=> $mainPatentDetail->patent_app_number));*/
				}
				$patentChildList = $this->db->select('patent_app_number,relation_number,parent,child,relation_type')->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$mainPatentDetail->application_number)->where('child',1)->order_by('id','ASC')->get();
				if ($patentChildList->num_rows() > 0) {	
					foreach($patentChildList->result() as $row){
						$childList[] = $row;
						/*array_push($this->sOpen,$row->relation_number);*/
						array_push($this->myAllRelationList,$row);
						/*array_push($this->myAllRelationDataList,array('id'=>$this->filterInt($row->relation_number), 'parent'=>array($this->filterInt($mainPatentDetail->application_number)),'description'=> $row->relation_number, 'email'=> "", 'groupTitleColor'=> "#4169e1", 'image'=>"", 'itemTitleColor'=> "#4169e1", 'phone'=> "",'relation_number'=>$row->relation_number , 'title'=> $row->relation_number, 'label'=> $row->relation_number));*/
					}
				}
				
				if(count($childList)>0){
					$this->findMyParentChildRelation($childList);
				}
				if(count($parentList)>0){
					$this->findMyParentChildRelation($parentList);
				}
				
				$allDetails = array();
				if(count($this->myAllRelationList)>0){
					$detailsListNumber = array();
					foreach($this->myAllRelationList as $relationList){
						$detailsListNumber[] = $relationList->patent_app_number;
						$detailsListNumber[] = $relationList->relation_number;
					}
					$detailsListNumber = array_unique($detailsListNumber);
					$this->db->_protect_identifiers=false;
					$childDetails = $this->db->select('distinct(application_number) as appNumber, d.*')->from($this->table_patent_illustration_detail.' as d')->where_in('application_number',$detailsListNumber)->order_by('str_to_date(`filling_date`, "%m-%d-%Y")','ASC')->get();
					if ($childDetails->num_rows() > 0) {	
						foreach($childDetails->result() as $row){
							$allDetails[] = $row;
						}
						$data['details'] = $allDetails;	
					}
				}
				if(count($data['main'])>0 && count($data['details'])==0){
					$this->db->_protect_identifiers=false;					
					$childDetails = $this->db->select('distinct(application_number) as appNumber, d.*')->from($this->table_patent_illustration_detail.' as d')->where_in('application_number',$data['main']->application_number)->order_by('str_to_date(`filling_date`, "%m-%d-%Y")','ASC')->get();
					if ($childDetails->num_rows() > 0) {	
						foreach($childDetails->result() as $row){
							$allDetails[] = $row;
						}
					}
				}
				$data['links'] = $this->myAllRelationList;
				/*$data['all_datas'] = $this->myAllRelationDataList;*/
						
			}
		}
		return $data;
	}
	
	function checkSopen($number){
		$enter = false;
		if(count($this->sOpen)>0){
			foreach($this->sOpen as $open){
				if($this->filterInt($open)==$this->filterInt($number)){
					$enter = true;
				}
			}
		}
		return $enter;
	}
	
	function filterInt($number){
		return filter_var($number, FILTER_SANITIZE_NUMBER_INT);
		/*return preg_replace("/[^0-9]/","",$number);*/
	}
	
	function findMyParentChildRelation($dataArray){
		if(count($dataArray)>0){
			foreach($dataArray as $dA){
				$parentList = array();
				$childList = array();
				$checkEntryLevel = $this->checkSopen($dA->relation_number);
				if($checkEntryLevel==false){
					$patentParentList = $this->db->select('patent_app_number,relation_number,parent,child,relation_type')->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$dA->relation_number)->where('parent',1)->order_by('id','ASC')->get();
					array_push($this->sOpen,$dA->relation_number);
					if ($patentParentList->num_rows() > 0) {
						foreach($patentParentList->result() as $row){
							$pNumber = $this->filterInt($row->patent_app_number);
							$rNumber = $this->filterInt($row->relation_number);
							$enter = false;
							if($pNumber!=$rNumber){
								/*if(count($this->myAllRelationList)>0){
									foreach($this->myAllRelationList as $mR){
										if(($this->filterInt($mR->patent_app_number)==$rNumber && $this->filterInt($mR->relation_number)==$pNumber) && ((int)$mR->parent==(int)$row->child) && ((int)$mR->child==(int)$row->parent)){
											$enter = true;break;
										}
									}
								}*/
								$enter = false;
							} else {
								$enter = true;
							}
							if($enter == false){
								$parentList[] = $row;								
								array_push($this->myAllRelationList,$row);
							}						
						}
					}
					$patentChildList = $this->db->select('patent_app_number,relation_number,parent,child,relation_type')->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$dA->relation_number)->where('child',1)->order_by('id','ASC')->get();
				/*	echo $this->db->last_query()."<br/>";
					echo "<pre>";
					print_r($this->myAllRelationList);*/
					if ($patentChildList->num_rows() > 0) {	
						foreach($patentChildList->result() as $row){
							$pNumber = $this->filterInt($row->patent_app_number);
							$rNumber = $this->filterInt($row->relation_number);
							/*echo $pNumber."SS".$rNumber."<br/>";*/
							$enter = false;
							if($pNumber!=$rNumber){
								/*if(count($this->myAllRelationList)>0){
									foreach($this->myAllRelationList as $mR){
										if(($this->filterInt($mR->patent_app_number)==$rNumber && $this->filterInt($mR->relation_number)==$pNumber) && ((int)$mR->parent==(int)$row->child) && ((int)$mR->child==(int)$row->parent)){
											$enter = true;break;
										}
									}
								}*/
								$enter = false;
							} else {
								$enter = true;
							}						
							if($enter == false){
								$childList[] = $row;
								array_push($this->myAllRelationList,$row);
							}
						}
					}
					if(count($parentList)>0){					
						$this->findMyParentChildRelation($parentList);
					}
					if(count($childList)>0){					
						$this->findMyParentChildRelation($childList);
					}
				}
			}
		}
	}
	
	public function findMyParentDetails($dataArray){
		if(count($dataArray)>0){
			for($i=0;$i<count($dataArray);$i++){
				$findChild = $this->db->select("relation_number,relation_type")->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$dataArray[$i]['number_id'])->where('child',1)->order_by('id','ASC')->get();
				echo $this->db->last_query()."<br/>";
				if($findChild->num_rows()>0){
					foreach($findChild->result() as $rowChild){
						$arrayChild = array('number_id'=>$rowChild->relation_number,'details'=>array(),'parent_relation'=>$rowChild->relation_type,'message'=>'','child'=>array(),'parent'=>array());						
						$childDetails = $this->db->select('*')->from($this->table_patent_illustration_detail)->where('patent_app_number',$rowChild->relation_number)->get();
						echo $this->db->last_query()."<br/>";
						if ($childDetails->num_rows() > 0) {
							$arrayChild['details'] = $childDetails->first_row();
						}
						array_push($dataArray[$i]['child'],$arrayChild);
					}
				}
				$findParent = $this->db->select("relation_number,relation_type")->from($this->table_lead_patent_family_parent_child)->where('patent_app_number',$dataArray[$i]['number_id'])->where('parent',1)->order_by('id','ASC')->get();
				echo $this->db->last_query()."<br/>";
				if($findParent->num_rows()>0){
					foreach($findParent->result() as $rowParent){
						$arrayParent = array('number_id'=>$rowParent->relation_number,'details'=>array(),'parent_relation'=>$rowParent->relation_type,'message'=>'','child'=>array(),'parent'=>array());
						$parentDetails = $this->db->select('*')->from($this->table_patent_illustration_detail)->where('patent_app_number',$rowParent->relation_number)->get();
						echo $this->db->last_query()."<br/>";
						if ($parentDetails->num_rows() > 0) {
							$arrayParent['details'] = $childDetails->first_row();
						}
						array_push($dataArray[$i]['parent'],$arrayParent);
					}
				}
				if(count($dataArray[$i]['parent'])>0){
					$dataArray[$i]['parent'] = $this->findMyParentDetails($dataArray[$i]['parent']);
				}
				if(count($dataArray[$i]['child'])>0){
					$dataArray[$i]['child'] = $this->findMyParentDetails($dataArray[$i]['child']);
				}
			}
		}
		return $dataArray;
	}

	public function getLeadPatentFamilyData($leadID){
		$data = array('child_count'=>0,'child_detail'=>0,'child_total'=>0);
		$leadOldPatentList = $this->db->select('patent_number,id')->from($this->table_lead_patent)->where('lead_id',$leadID)->get();
		if ($leadOldPatentList->num_rows() > 0) {	
			$childPatent = [];
			$parentPatent = [];
			$childTotal = 0;
			foreach($leadOldPatentList->result() as $row){				
				$getMyChild = $this->db->select('distinct(child_number) as child_number ,id,scrap_status')->from($this->table_lead_patent_family)->where('parent_number',$row->patent_number)->get();
				if ($getMyChild->num_rows() > 0) {	
					$data['child_total'] = $data['child_total'] + $getMyChild->num_rows();
					foreach($getMyChild->result() as $rowChild){ 
						if((int)$rowChild->scrap_status==1){
							$childPatent[] = $rowChild->child_number;
						}
					}
				}
				$parentPatent[] = $row->patent_number;				
			}
			$allPatent = array_merge($childPatent,$parentPatent);
			if(count($childPatent)>0){
				$data['child_count'] = count($childPatent);
			}
			if(count($allPatent)>0){
				$allPatentQuery = $this->db->select('distinct(patent_number) as patent_number,b_citations,f_citations,expired,application,title,current_assignee,original_assignee,priority,status')->from($this->table_lead_patent_scrap_data)->where_in('patent_number',$allPatent)->get();
				$childArray = array();
				foreach($allPatentQuery->result() as $rowChild){ 
					$childArray[] = $rowChild;
				}
				$data['child_detail'] = $childArray;
			}
		}
		return $data;
	}
	
	
	
	function getAllEPOFamiliesByPatent($patent){
		$data = array('family'=>array(),'publications'=>array());
		if(strlen($patent)==11 || strlen($patent)==13){
			$patent = substr($patent,0,-2);
		}
		$family = array();
		$allPatentQuery = $this->db->select('distinct(fpr.family_id) as familyID')->from($this->table_family_patent_relation.' as fpr')->where('fpr.patent_id',$patent)->order_by('fpr.id','DESC')->get();
		/*echo $this->db->last_query();*/
		if ($allPatentQuery->num_rows() > 0) {
			foreach($allPatentQuery->result() as $rowChild){ 
				$data['family'][] = $rowChild;
				$family[] = $rowChild->familyID;
			}		
		}
		if(count($family)>0){
			$allPatentQuery = $this->db->select('fm.publication_country,fm.publication_number as publication_number, fm.application_number as application_number,fm.application_country,fm.priority_date')->from($this->table_patent_family_member.' as fm')->where_in('fm.family_id',$family)->order_by('fm.id','DESC')->get();
			/*echo $this->db->last_query();*/
			if ($allPatentQuery->num_rows() > 0) {
				foreach($allPatentQuery->result() as $rowChild){ 
					$data['publications'][] = $rowChild;
				}		
			}
		}
		return $data;
	}
	
	public function getApplicationNumber($patentNumber) {
		$data = array();
		$queryPatent = $this->db->select('fpm.application_number')->from($this->table_patent_family_member.' as fpm')->where_in('fpm.publication_number',$patentNumber)->get();
		if ($queryPatent->num_rows() > 0) {	
			$data = $queryPatent->first_row();
		}
		return $data;
	}
	
	public function getLeadPatentParentData($leadID){
		/*$data = array('child_count'=>0,'child_detail'=>0);*/
		$data = array('data'=>array(),'referring'=>array());
		$queryPatent = $this->db->select('distinct(lp.patent_number) as patent_number')->from($this->table_lead_patent.' as lp')->where('lp.lead_id',$leadID)->get();
		if ($queryPatent->num_rows() > 0) {	
			foreach($queryPatent->result() as $rowParent){
				$allPatentQuery = $this->db->select('distinct(sd.patent_number) as patent_number,b_citations,f_citations,expired,application,title,current_assignee,original_assignee,priority,status,status,over_all')->from($this->table_lead_patent_scrap_data.' as sd')->where('sd.patent_number',$rowParent->patent_number)->order_by('sd.id','DESC')->limit(1)->get();
				/*echo $this->db->last_query();*/
				if ($allPatentQuery->num_rows() > 0) {	
					array_push($data['data'],$allPatentQuery->first_row());			
				}
				/*Forward Citation type=1*/
				$getAllPatentCitation = $this->db->select('applicant')->from($this->table_due_dilligence_citations)->where('patent_id',$rowParent->patent_number)->where('type',1)->get();
				if ($getAllPatentCitation->num_rows() > 0) {	
					$result = $getAllPatentCitation->result();
					$data['referring'] = array_merge($data['referring'],$result);
				}
			}
		}
		return $data;
	}
	
	
	public function leadOldPatentListWithFamily($leadID){
		$leadOldPatentList = $this->db->select('patent_number,id')->from($this->table_lead_patent)->where('lead_id',$leadID)->get();
		if ($leadOldPatentList->num_rows() > 0) {			
			foreach($leadOldPatentList->result() as $row){ 
				/*Find Child*/
				$allPatent = [];
				$allId = [];
				$getMyChild = $this->db->select('child_number,id')->from($this->table_lead_patent_family)->where('parent_number',$row->patent_number)->get();
				if ($getMyChild->num_rows() > 0) {			
					foreach($getMyChild->result() as $rowChild){ 
						$allPatent[] = $rowChild->child_number;
						$allId[] = $rowChild->id;
					}
				}
				$allPatent[] = $row->patent_number;
				if(count($allPatent)>0){
					$this->db->where_in('patent_number',$allPatent);
					$this->db->delete($this->table_lead_patent_scrap_data);					
				}
				if(count($allId)>0){
					$this->db->where_in('parent_number',$row->patent_number);
					$this->db->delete($this->table_lead_patent_family);
					$this->db->where_in('id',$allId);
					$this->db->delete($this->table_lead_patent_family_diagram);
				}
				
				$this->db->where('id',$row->id);
				$this->db->delete($this->table_lead_patent);	
			}			
		}
	}
	
	public function insertLeadPatentBulk($allAssets,$leadID){
		/*allAssets in array*/
		if(count($allAssets)>0){
			$insertArrayBulk = array();
			foreach($allAssets as $patent){
				$asset = "";
				if(isset($patent['patents'])){
					$asset = $patent['patents'];
				} else if(isset($patent['patent'])){
					$asset = $patent['patent'];
				} else if(isset($patent['assets'])){
					$asset = $patent['assets'];
				}
				if(!empty($asset)){
					$insertArrayBulk[] = array('patent_number'=>$asset,'lead_id'=>$leadID);
				}				
			}
			if(count($insertArrayBulk)>0){
				$this->db->insert_batch($this->table_lead_patent,$insertArrayBulk);
			}
		}		
	}
	
	public function insertCategoryBatch($data){
		$this->db->insert_batch($this->table_lead_category,$data);
		return $this->db->affected_rows();
	}
	
	public function deleteCategoryListByLeadID($leadID){
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_lead_category);
		return $this->db->affected_rows();
	}
	
	public function deleteSendLinkedinMessage($ID){
		$this->db->where('id',$ID);
		$this->db->delete($this->table_send_linkedin_messages);
		return $this->db->affected_rows();
	}
	
	
	public function findJobDetails($jobID,$select){
		$data = array();
		$jobData = $this->db->select($select)->from($this->table_job_queue)->where('id',$jobID)->get();
		if ($jobData->num_rows() > 0) {	
			$data = $jobData->first_row();
		}
		return $data;
	}
	
	public function checkPendingJobByLead($leadID,$select='*'){
		$data = array();
		$jobData = $this->db->select($select)->from($this->table_job_queue)->where('account',$leadID)->where('status',0)->where('type','Patent_Family')->where('module_name','Patent_Family')->order_by('id','desc')->get();
		if ($jobData->num_rows() > 0) {	
			$data = $jobData->first_row();
		}
		return $data;
	}
	
	public function findJobDetailsByLead($jobID,$select){
		$data = array();
		$jobData = $this->db->select($select)->from($this->table_job_queue)->where('id',$jobID)->order_by('id','DESC')->limit(1)->get();
		if ($jobData->num_rows() > 0) {	
			$data = $jobData->first_row();
		}
		return $data;
	}
	
	public function getLeadPatentList($leadID){
		$leadPatentList = $this->db->select('patent_number as patent,id')->from($this->table_lead_patent)->where('lead_id',$leadID)->get();
		$data =  array();
		if ($leadPatentList->num_rows() > 0) {	
			$data = $leadPatentList->result();
		}
		return $data;
	}
	
	public function getLeadPatentDataList($leadID){
		$data =  array('count'=>0,'data'=>array(),'referring'=>array());
		/*$leadPatentCount = $this->db->select("count(id) as patentCount")->from($this->table_lead_patent)->where('lead_id',$leadID)->get();
		if ($leadPatentCount->num_rows() > 0) {	
			$rowData = $leadPatentCount->first_row();
			$data['count'] =  $rowData->patentCount;
		}*/
		$queryPatent = $this->db->select('distinct(lp.patent_number) as patent_number')->from($this->table_lead_patent.' as lp')->where('lp.lead_id',$leadID)->get();
		if ($queryPatent->num_rows() > 0) {	
			$data['count'] = $queryPatent->num_rows();
			foreach($queryPatent->result() as $rowParent){
				$allPatentQuery = $this->db->select('distinct(sd.patent_number) as patent_number,b_citations,f_citations,expired,application,title,current_assignee,original_assignee,priority,status,status,over_all')->from($this->table_lead_patent_scrap_data.' as sd')->where('sd.patent_number',$rowParent->patent_number)->order_by('sd.id','DESC')->limit(1)->get();
				/*echo $this->db->last_query();*/
				if ($allPatentQuery->num_rows() > 0) {	
					array_push($data['data'],$allPatentQuery->first_row());			
				}
				/*Forward Citation type=1*/
				$getAllPatentCitation = $this->db->select('applicant')->from($this->table_due_dilligence_citations)->where('patent_id',$rowParent->patent_number)->where('type',1)->get();
				if ($getAllPatentCitation->num_rows() > 0) {	
					$result = $getAllPatentCitation->result();
					$data['referring'] = array_merge($data['referring'],$result);
				}
			}
		}
		return $data;
	}
	
	public function checkPatentIllustrationDetail($application_number){
		return  $this->db->select('count(id) as countRecord')->from($this->table_patent_illustration_detail)->where('application_number',$application_number)->get()->row()->countRecord;
	}
	
	public function checkScraperLeadParent($patentNumber,$pat_app_number,$relation_number){
		  $data = $this->db->select('count(id) as countRecord')->from($this->table_scraper_lead_parent)->where('patent_number',$patentNumber)->where('pat_app_number',$pat_app_number)->where('relation_number',$relation_number)->get()->row();
		  return  $data->countRecord;
	}
	
	public function checkScraperLeadChild($patentNumber,$pat_app_number,$relation_number){
		  $data = $this->db->select('count(id) as countRecord')->from($this->table_scraper_lead_child)->where('patent_number',$patentNumber)->where('pat_app_number',$pat_app_number)->where('relation_number',$relation_number)->get()->row();
		  return  $data->countRecord;
	}
	
	public function insertLeadPatentFamilyBulk($data){
		if(count($data)>0){
			$this->db->insert_batch($this->table_lead_patent_family,$data);
		}
		return $this->db->affected_rows();
	}
	
	public function updateLinkedinSynDate($data){		
		$this->db->where("id",1);
		$this->db->update($this->table_scrapper_linkedin_message_sync,$data);
		return $this->db->affected_rows();
	}
	
	public function updatePotentialInBatch($data){
		if(count($data)>0){
			$this->db->update_batch($this->table_potential_participates,$data,'id');
		}
		return $this->db->affected_rows();
	}
	
	public function updatePatentDueDilligencePDF($data,$patentNumber){		
		$this->db->where("patent_id",$patentNumber);
		$this->db->update($this->table_due_dilligence_pdf,$data);
		return $this->db->affected_rows();
	}
	
	public function updateCitationData($data,$id){		
		$this->db->where("id",$id);
		$this->db->update($this->table_due_dilligence_citations,$data);
		return $this->db->affected_rows();
	}
	
	public function updateLeadLitigation($data,$id){
		$this->db->where("id",$id);
		$this->db->update($this->table_lead_litigation,$data);
		return $this->db->affected_rows();
	}
	
	public function insertPatentIllustrationDetailBulk($data){
		if(count($data)>0){
			$this->db->insert_batch($this->table_patent_illustration_detail,$data);
		}
		return $this->db->affected_rows();
	}
	
	public function addLeadNotepad($data){
		$this->db->insert($this->table_lead_notepad, $data);
		return $this->db->insert_id();
	}
	
	public function updateLeadNotepad($data,$id){		
		$this->db->where("id",$id);
		$this->db->update($this->table_lead_notepad,$data);
		return $this->db->affected_rows();
	}
	
	public function updateThreadStatus($threadID,$data){		
		$this->db->where("thread_id",$threadID);
		$this->db->update($this->table_linkedin_threads,$data);
		return $this->db->affected_rows();
	}
	
	public function insertSourceData($data){
		$this->db->insert($this->table_sources, $data);
		return $this->db->insert_id();
	}
	
	public function insertLitigationScrape($data){
		$this->db->insert($this->table_scrapper_litigation_scrape, $data);
		return $this->db->insert_id();
	}
	
	public function insertAgreements($data){
		$this->db->insert($this->table_sec_agreements, $data);
		return $this->db->insert_id();
	}
	
	public function updateAgreements($id,$data){		
		$this->db->where("id",$id);
		$this->db->update($this->table_sec_agreements,$data);
		return $this->db->affected_rows();
	}
	
	public function updateSourceData($data,$id){		
		$this->db->where("id",$id);
		$this->db->update($this->table_sources,$data);
		return $this->db->affected_rows();
	}
	
	public function deleteSourceDataInBulk($IDs){
		$this->db->where_in('id',$IDs);
		$this->db->delete($this->table_sources);
		return $this->db->affected_rows();
	}
	
	public function insertScraperLeadParent($data){
		$this->db->insert($this->table_scraper_lead_parent, $data);
		return $this->db->insert_id();
	}
	
	public function insertScraperLeadChild($data){
		$this->db->insert($this->table_scraper_lead_child, $data);
		return $this->db->insert_id();
	}
	
	public function insertPatentIllustrationDetail($data){
		$this->db->insert($this->table_patent_illustration_detail, $data);
		return $this->db->insert_id();
	}
	
	public function insertDueDilligencePDF($data){
		$this->db->insert($this->table_due_dilligence_pdf, $data);
		return $this->db->insert_id();
	}
	
	public function insertLeadPatentScrapData($data){
		$this->db->insert($this->table_lead_patent_scrap_data, $data);
		return $this->db->insert_id();
	}
	
	public function insertFamilyDiagram($data){
		$this->db->insert($this->table_lead_patent_family_diagram, $data);
		return $this->db->insert_id();
	}
	
	public function insertSourceURL($data){
		$this->db->insert($this->table_source_url, $data);
		return $this->db->insert_id();
	}
	
	public function insertLicenseData($data){
		$this->db->insert($this->table_licenses, $data);
		return $this->db->insert_id();
	}
	
	public function insertJobQueue($data){
		$this->db->insert($this->table_job_queue, $data);
		return $this->db->insert_id();
	}
	
	public function updatePatentIllustrationDetail($data,$patentNumber){
		$this->db->where("patent_number",$patentNumber);
		$this->db->update($this->table_patent_illustration_detail,$data);
		return $this->db->affected_rows();
	}
	
	public function updatePatentIllustrationDetailByAppNumber($data,$applicationNumber){
		$this->db->where("application_number",$applicationNumber);
		$this->db->update($this->table_patent_illustration_detail,$data);
		return $this->db->affected_rows();
	}
	
	public function updateLeadPatentByPatentNumber($data,$patentNumber){
		$this->db->where("patent_number",$patentNumber);
		$this->db->update($this->table_lead_patent,$data);
		return $this->db->affected_rows();
	}
	
	public function insertLinkedInQuery($data){
		$this->db->insert($this->table_linkedin_query, $data);
		return $this->db->insert_id();
	}
	
	public function updateLinkedInQuery($data,$id){
		$this->db->where("id",$id);
		$this->db->update($this->table_linkedin_query,$data);
		return $this->db->affected_rows();
	}
	
	public function updateMaximumScrapeUsers($updateData){
		$this->db->where("id >",0);
		$this->db->update($this->table_linkedin_query,$updateData);
		$data = $this->db->affected_rows();
		$this->db->where("id >",0);
		$this->db->update($this->table_linkedin_expression,$updateData);
		$data = $this->db->affected_rows();
		return $data;
	}
	
	public function updateLinkedInExpression($data,$id){
		$this->db->where("id",$id);
		$this->db->update($this->table_linkedin_expression,$data);
		return $this->db->affected_rows();
	}
	
	public function insertOpenProjectData($data){
		$this->db->insert($this->table_lead_open_project, $data);
		return $this->db->insert_id();
	}
	
	public function addEmailRawData($data){
		$this->db->insert($this->table_email_raw, $data);
		return $this->db->insert_id();
	}
	
	public function insertActivityLog($data){
		$this->db->insert($this->table_activity_log, $data);
		return $this->db->insert_id();
	}
	
	public function insertPreSalesBrokerLeadCompany($data){
		$this->db->insert($this->table_presale_broker, $data);
		return $this->db->insert_id();
	}
	
	public function insertSalesBrokerLeadCompany($data){
		$this->db->insert($this->table_sales_broker_lead_company, $data);
		return $this->db->insert_id();
	}
	
	public function insertPosAgreement($data){
		$this->db->insert($this->table_pos_agreements, $data);
		return $this->db->insert_id();
	}
	
	public function deletePosAgreementByUrl($url){
		$this->db->where('file',$url)->delete($this->table_pos_agreements);
		return $this->db->affected_rows();
	}
	
	public function deleteSalesBrokerLeadCompany($data){
		$this->db->where('lead_id',$data['lead_id']);
		$this->db->where('sales_company_id',$data['sales_company_id']);
		$this->db->delete($this->table_sales_broker_lead_company);
		return $this->db->affected_rows();
	}
	
	public function insertCampaignProcess($data){
		$this->db->insert($this->table_campaign_process, $data);
		return $this->db->insert_id();
	}
	
	function deleteCampaignProcess($id){
		$query = $this->db->select('count(cl.id) as countID')->from($this->table_campaign_process.' as cp')->join($this->table_campaign_list.' as cl','cl.campaign_id = cp.campaign_id')->where('cp.id',$id)->where('send','0')->get();
		if($query->num_rows()>0){
			$count = $query->first_row();
			if($count->countID==0){
				$this->db->where('id',$id);
				$this->db->delete($this->table_campaign_process);
				return $this->db->affected_rows();
			} else {
				return 1;
			}
		} else {
			return 1;
		}
	}
	
	
	public function insertFreePreContacts($data){
		$this->db->insert($this->table_free_precontacts, $data);
		return $this->db->insert_id();
	}
	
	
	public function findEmailDate($id){
		$result = $this->db->select('date_received')->from($this->table_box)->where('id',$id)->get();
		if($result->num_rows()>0){
			$data = $result->first_row();
			return $data->date_received;
		} else {
			return date('Y-m-d H:i:s');
		}
	}
	
	public function insertLitigationScrap($data){
		$this->db->insert($this->table_litigation_scrap, $data);
		return $this->db->insert_id();
	}
	
	function deleteLitigationScrap($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_litigation_scrap);
		return $this->db->affected_rows();
	}
	
	function deleteFreePreContact($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_free_precontacts);
		return $this->db->affected_rows();
	}
	
	public function updateSalesCompanyStage($leadID,$contactID,$data){
		$this->db->where("lead_id",$leadID);
		$this->db->where("contact_id",$contactID);
		$this->db->update($this->table_invitees,$data);
		return $this->db->affected_rows();
	}
	
	public function updateAcquisitionCompanyStage($leadID,$contactID,$data){
		$this->db->where("lead_id",$leadID);
		$this->db->where("contact_id",$contactID);
		$this->db->update($this->table_acquisition_company,$data);
		return $this->db->affected_rows();
	}
	
	public function updateOpenProjectData($data,$id){
		$this->db->where("id",$id);
		$this->db->update($this->table_lead_open_project,$data);
		return $this->db->affected_rows();
	}
	
	public function updateAssignmentNames($id,$data){
		$this->db->where("id",$id);
		$this->db->update($this->table_lead_assignment_names,$data);
		return $this->db->affected_rows();
	}
	
	public function updateAssignmentHeading($id,$data){
		$this->db->where("id",$id);
		$this->db->update($this->table_lead_assignment_heading,$data);
		return $this->db->affected_rows();
	}
	
	public function deleteAssignmentNames($patentNumber){
		$this->db->where('patent_number',$patentNumber);
		$this->db->delete($this->table_lead_assignment_names);
		return $this->db->affected_rows();
	}
	
	public function deleteAssignmentHeading($patentNumber){
		$this->db->where('patent_number',$patentNumber);
		$this->db->delete($this->table_lead_assignment_heading);
		return $this->db->affected_rows();
	}
	
	public function deleteAssignmentData($patentNumber){
		$this->db->where('patent_number',$patentNumber);
		$this->db->delete($this->table_lead_patent_assignment);
		
		$this->db->where('patent_number',$patentNumber);
		$this->db->delete($this->table_lead_patent_assigment_relation);
		return $this->db->affected_rows();
	}
	
	public function deleteAllAssignmentData($patentNumber){
		$data = $this->deleteAssignmentNames($patentNumber);
		$data = $this->deleteAssignmentHeading($patentNumber);
		$data = $this->deleteAssignmentData($patentNumber);
		return $data;
	}
	
	public function updateOpenProjectDataByLeadType($leadID,$type,$data=array()){
		$this->db->where("lead_id",$leadID);
		$this->db->where("type",$type);
		$updata = array();
		if(count($data)>0){
			$updata = $data;
		} else {
			$updata = array('status'=>1);
		}
		$this->db->update($this->table_lead_open_project,$updata);
		/*echo $this->db->last_query()."<br/>";*/
		return $this->db->affected_rows();
	}
	
	public function deleteOpenProjectData($id){
		$this->db->where("id",$id);
		$this->db->delete($this->table_lead_open_project);
		return $this->db->affected_rows();
	}
	
	public function insertCampaign($data){
		$this->db->insert($this->table_campaign, $data);
		/*echo $this->db->last_query();*/
		return $this->db->insert_id();
	}
	
	public function updateCampaign($campainID,$data){
		$this->db->where("id",$campainID);
		$this->db->update($this->table_campaign,$data);
		return $this->db->affected_rows();
	}
	
	public function insertCampaignList($data){
		$this->db->insert($this->table_campaign_list, $data);
		return $this->db->insert_id();
	}
	
	public function insertCampaignBatchList($data){
		$this->db->insert_batch($this->table_campaign_list, $data);
		return $this->db->affected_rows();
	}
	
	public function updateCampaignList($campainID,$email,$data){
		$this->db->where("campaign_id",$campainID);
		$this->db->where("address",$email);
		$this->db->update($this->table_campaign_list,$data);
		return $this->db->affected_rows();
	}
	
	public function updateCampaignListByID($ID,$data){
		$this->db->where("id",$ID);
		$this->db->update($this->table_campaign_list,$data);
		return $this->db->affected_rows();
	}
	
	public function delete_address_from_campaign($campaignID,$email){
		$this->db->where("campaign_id",$campaignID);
		$this->db->where("address",$email);
		$this->db->delete($this->table_campaign_list);
		return $this->db->affected_rows();
	}
	
	public function delete_from_campaign_list_by_id_and_campaign_id($campaignID,$ID){
		$this->db->where("campaign_id",$campaignID);
		$this->db->where("id",$ID);
		$this->db->delete($this->table_campaign_list);
		return $this->db->affected_rows();
	}
	
	public function deleteCampaign($campaignID){
		$this->db->where("campaign_id",$campaignID);
		$this->db->delete($this->table_campaign_list);
		$this->db->where("id",$campaignID);
		$this->db->delete($this->table_campaign);
		return $this->db->affected_rows();
	}
	
	public function checkDueDilligencePDF($patentID){
		$data = $this->db->select('count(ddp.id) as countID')->from($this->table_due_dilligence_pdf.' as ddp')->where('patent_id',$patentID)->get()->row->countID;
		return $data;
	}
	
	public function checkCampaignProcess($campaignID){
		$data = $this->db->select('count(cp.id) as countID')->from($this->table_campaign_process.' as cp')->where('campaign_id',$campaignID)->get()->row->countID;
		return $data;
	}
	public function checkAgreementFile($fileUrl){
		$query = $this->db->select('*')->from($this->table_sec_agreements)->where('agreement_url',$fileUrl)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	public function findLeadIdFromProcess($processID){
		$data = $this->db->select('cp.lead_id')->from($this->table_campaign_process.' as cp')->where('cp.id',$processID)->get()->row()->lead_id;
		return $data;
	}
	
	public function getLitgationScrapeData($leadID,$select='*'){
		$query = $this->db->select($select)->from($this->table_lead_litigation.' as cp')->where('lead_id',$leadID)->order_by('cp.id','desc')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->result();
		}
		return $data;
	}
	
	public function findLastOpenProject($leadID,$projectType,$status){
		$query = $this->db->select('c.email,c.secondary_email,c.tertiary_email')->from($this->table_lead_open_project.' as cp')->join($this->table_contacts.' as c','c.id = cp.contact_id')->where('lead_id',$leadID)->where('type',$projectType)->where('status',$status)->limit(1)->order_by('cp.id','desc')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function getLinkedinQueryData(){
		$query = $this->db->select('id,title,keyword,scrape_numbers')->from($this->table_linkedin_query.' as cp')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function getLinkedinExpressionData(){
		$query = $this->db->select('id,keyword,title,scrape_numbers')->from($this->table_linkedin_expression.' as cp')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->result();
		}
		return $data;
	}
	
	public function findProcessCampaignList($leadID){
		$query = $this->db->select('cl.email_id')->from($this->table_campaign_list.' as cl')->join($this->table_campaign.' as c','c.id = cl.campaign_id')->where('cl.send >',0)->where('cl.proccessed',1)->where('cl.open',1)->where('cl.email_id >',0)->where('c.lead_id',$leadID)->order_by("cl.id","DESC")->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
		}
		return $data;
	}
	
	public function getCampaignListByEmailInProccess($email,$campaignID){
		$data = array();
		$query = $this->db->select('distinct(cp.campaign_id) as campaign_id, cp.id as campaignProcessID,cl.address,cp.subject,cp.type,cp.user_id,cp.main_activity,cp.campaign_date,cp.lead_id,cl.id as campaignListID')->from($this->table_campaign_process.' as cp')->join($this->table_campaign_list.' as cl','cl.campaign_id = cp.campaign_id')->where('(cl.send="1") AND (cl.proccessed = 0 OR cl.proccessed IS null)')->where('address',$email)->where('cl.campaign_id',$campaignID)->order_by("cp.id","DESC")->get();
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row){ 
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function getRecentCampaignProcess(){
		$data = array();
		$query = $this->db->select('distinct(cp.campaign_id) as campaign_id, cp.id as campaignProcessID,cl.address,cp.subject,cp.type,cp.user_id,cp.main_activity,cp.campaign_date,cp.lead_id,cl.id as campaignListID')->from($this->table_campaign_process.' as cp')->join($this->table_campaign_list.' as cl','cl.campaign_id = cp.campaign_id')->where('(cl.send="1") AND (cl.proccessed = 0 OR cl.proccessed IS null)')->order_by("cp.id","DESC")->get();
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) {
			$data = $query->result();
		}
		return $data;
	}
	
	function getCampaignListIDByEmailID($emailID){
		$data= array();
		$query = $this->db->select("cl.id")->from($this->table_campaign_list.' as cl')->where("cl.email_id",$emailID)->where('cl.send',1)->where('cl.open',1)->get();
		if ($query->num_rows() > 0) {
			$data = $query->result();
		}
		return $data;
	}
	
	public function getCampaignListSendSkipTotal($campaignID,$campaignType){
		$total = $this->db->select('count(cl.id) as total')->from($this->table_campaign_list.' as cl')->join($this->table_campaign.' as c','c.id = cl.campaign_id')->where('cl.campaign_id',$campaignID)->where("c.campaign_type",$campaignType)->get()->row()->total;
		$send = $this->db->select('count(cl.id) as send')->from($this->table_campaign_list.' as cl')->join($this->table_campaign.' as c','c.id = cl.campaign_id')->where('cl.campaign_id',$campaignID)->where("c.campaign_type",$campaignType)->where('send',1)->get()->row()->send;
		$skip = $this->db->select('count(cl.id) as skip')->from($this->table_campaign_list.' as cl')->join($this->table_campaign.' as c','c.id = cl.campaign_id')->where('cl.campaign_id',$campaignID)->where("c.campaign_type",$campaignType)->where('send >',1)->get()->row()->skip;
		return array('total'=>$total,'send'=>$send,'skip'=>$skip);
	}
	
	public function getCampaignData($id){
		$data= array();
		$query = $this->db->select("*")->from($this->table_campaign)->where('id',$id)->get();
		if ($query->num_rows() > 0) {
			$data = $query->result();
		}
		return $data;
	}
	
	public function getCampaign($id=0,$campaignType=0){
		$data= array();
		if($id==0 && $campaignType>0){
			$query = $this->db->select("*")->from($this->table_campaign)->where('id IN (SELECT distinct(campaign_id) FROM '.$this->table_campaign_list.' WHERE send=0)')->where("campaign_type",$campaignType)->order_by("start_date","DESC")->get();
			if ($query->num_rows() > 0) {
				$data = $query->result();
			}
		} else if($id>0){
			$query = $this->db->select("*")->from($this->table_campaign)->where("id",$id)->get();
			if ($query->num_rows() > 0) {
				$campaign = $query->first_row();
				$list = array();
				if($campaignType == 2){
					$query = $this->db->select("distinct(c.id),c.linkedin_url,c.first_name,c.last_name,c.linkedin_image,c.job_title,c.current_company,co.company_name,co.company_name_alias as company_name_alias,c.gender,cl.id as cListID,cl.id as campaign_list_id")->from($this->table_campaign_list.' as cl')->join($this->table_contacts.' as c', 'c.id = cl.contact_id')->join($this->table_company.' as co','co.id = c.company_id')->where("cl.campaign_id",$campaign->id)->where('cl.send',0)->get();
					if ($query->num_rows() > 0) {
						$list = $query->result();
					}
				} else {
					$query = $this->db->select("*")->from($this->table_campaign_list)->where("campaign_id",$campaign->id)->where('send',0)->get();
					if ($query->num_rows() > 0) {
						$list = $query->result();
					}
				}
				
				$data = array("campaign"=>$campaign,"list"=>$list);
			}
		}
		return $data;
	}
	
	public function saveTaskConversation($data){
		$this->db->insert($this->table_task_conversation, $data);
		return $this->db->insert_id();
	}
	
	public function saveLeadEvent($data){
		$this->db->insert($this->table_lead_event, $data);
		return $this->db->insert_id();
	}
	
	public function saveTaskConversationFlag($data){
		/*$this->deleteTaskConversation($data['task_id']);*/
		$this->db->insert($this->table_task_flag, $data);
		return $this->db->insert_id();
	}
	
	public function saveLeadTemplate($data){
		$this->db->insert($this->table_lead_template, $data);
		return $this->db->insert_id();
	}
	
	public function updateLeadTemplate($ID,$data){
		$this->db->where('id',$ID);
		$this->db->update($this->table_lead_template, $data);
		return $this->db->affected_rows();
	}
	
	public function deleteTaskConversation($taskID){
		$this->db->where('task_id',$taskID);
		$this->db->delete($this->table_task_flag);
		return $this->db->affected_rows();
	}
	
	function deleteLeadTemplate($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_lead_template);
		return $this->db->affected_rows();
	}
	
	public function deleteLeadTemplateByStageAndType($type,$stage){
		$this->db->where('template_type',$type);
		$this->db->where('template_stage',$stage);
		$this->db->delete($this->table_lead_template);
		return $this->db->affected_rows();
	}
	
	function getLeadTemplatesStages($leadID){
		$templateStages = array();
		$j = array(0,1,2,7,3,4,5,8,9,10,11,6);
		foreach($j as $i){
			$templateStages[$i] = array('lead_templates_email'=>array(),'lead_templates_email_text'=>array(),'lead_templates_linkedin'=>array(),'lead_templates_telephone'=>array());
		}
		$templateQuery = $this->db->select("*")->from($this->table_lead_template)->where('lead_id',$leadID)->get();
		if(count($templateQuery->num_rows())>0){
			$templateData = $templateQuery->result();
			foreach($templateData as $template){
				switch((int)$template->template_type){
					case 0:
						/*lead_templates_email*/
						$templateStages[(int)$template->template_stage]['lead_templates_email'][] = $template;
						break;
					case 1:
						/*lead_templates_email_text*/
						$templateStages[(int)$template->template_stage]['lead_templates_email_text'][] = $template;
						break;
					case 3:
						/*lead_templates_linkedin*/
						$templateStages[(int)$template->template_stage]['lead_templates_linkedin'][] = $template;
						break;
					case 4:
						/*lead_templates_telephone*/
						$templateStages[(int)$template->template_stage]['lead_templates_telephone'][] = $template;
						break;
				}
			}
		}
		return $templateStages;
	}
	
	function getLeadTemplates($leadID,$type=0){
		$boxQuery = $this->db->select("*")->from($this->table_lead_template)->where('lead_id',$leadID)->where('type',$type)->get();
		$boxData =array();
		if(count($boxQuery->num_rows())>0){
			$boxData = $boxQuery->result();
		}
		return $boxData;
	}
	
	public function emailSearch($from,$to='',$subject='',$has='',$doesntHave=''){
		$searchString = "";
		$stringInc = false;		
		if(!empty($from)){
			$explodeFrom = explode(',',$from);
			for($i=0;$i<count($explodeFrom);$i++){
				$fromSearch = trim($explodeFrom[$i]);
				if(!empty($fromSearch)){
					$searchString .= "content LIKE '%".$explodeFrom[$i]."%' OR ";
				}				
			}
			$searchString = substr($searchString,0,-3);
			$stringInc = true;
		}
		if(!empty($to)){
			if($stringInc == true){
				$searchString .= "OR ";
			}
			$explodeTo = explode(',',$to);
			for($i=0;$i<count($explodeTo)-1;$i++){
				$toSearch = trim($explodeTo[$i]);
				if(!empty($toSearch)){
					$searchString .= "content LIKE '%".$toSearch."%' OR ";
				}
			}
			$searchString = substr($searchString,0,-3);
			$stringInc = true;
		}
		if(!empty($subject)){
			if($stringInc == true){
				$searchString .= "AND ";
			}
			$searchString .= "content LIKE '%".$subject."%' ";
			$stringInc = true;
		}
		if(!empty($has)){
			if($stringInc == true){
				$searchString .= "AND ";
			}
			$searchString .= "content LIKE '%".$has."%' ";
			$stringInc = true;
		}
		if(!empty($doesntHave)){
			if($stringInc == true){
				$searchString .= "AND ";
			}
			$searchString .= "content NOT LIKE '%".$doesntHave."%' ";
			$stringInc = true;
		}
		$data = array();
		$searchString = trim($searchString);
		if(!empty($searchString)){
			/*if(!empty($from)){
				$searchString .=" AND b.user_id = (SELECT id FROM ".$this->table_contacts." as c WHERE c.email='".$from."')";
			}*/
			$data = array();
			$query = $this->db->select('b.*, a.company_id as aCompanyID, a.type as aType, s.company_id as sCompanyID,s.type as sType, p.company_id as pCompanyID,p.type as pType,l.lead_name,a.id as aID, s.id as sID, p.id as pID')->from($this->table_box.' as b')->join($this->table_acquisition_activity.' as a','b.id = a.email_id','left')->join($this->table_sales_activity.' as s','b.id = s.email_id','left')->join($this->table_presales_activity.' as p','b.id = p.email_id','left')->join($this->table_lead.' as l','l.id = b.lead_id')->where($searchString)->where("l.status IN ('0','1','2')")->order_by('b.id','desc')->get();
			/*echo $this->db->last_query();*/
			if(count($query->num_rows())>0){
				foreach($query->result() as $row){
					$activityType = $this->lead_model->getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($row->id);
					$activity = 0;
					if(count($activityType)==0){
						$activityType = $this->lead_model->getPersonCompanyDetailFromSalesActivityLogByEmailID($row->id);
						if(count($activityType)>0){
							$activity = 1;
						} else {
							$activityType = $this->lead_model->getPersonCompanyDetailFromPreSalesActivityLogByEmailID($row->id);
							if(count($activityType)>0){
								$activity = 3;
							}
						}
					} else {
						$activity = 2;
					}
					$row->from_activity = $activity;
					$data[] = $row;
				}
			}			
		}
		return $data;
	}
	
	public function fincImapEmailWithMessageID($messageID){
		$data = array();
			$query = $this->db->select('DISTINCT(b.id),b.*, a.company_id as aCompanyID, a.type as aType, s.company_id as sCompanyID,s.type as sType, p.company_id as pCompanyID,p.type as pType,l.lead_name,a.id as aID, s.id as sID, p.id as pID')->from($this->table_box.' as b')->join($this->table_acquisition_activity.' as a','b.id = a.email_id','left')->join($this->table_sales_activity.' as s','b.id = s.email_id','left')->join($this->table_presales_activity.' as p','b.id = p.email_id','left')->join($this->table_lead.' as l','l.id = b.lead_id')->where('b.content LIKE "%'.$messageID.'%"')->where("l.status IN ('0','1','2')")->where('b.sent_from','1')->order_by('b.id','ASC')->get();
			/*echo $this->db->last_query();*/
			if(count($query->num_rows())>0){
				$row = $query->first_row();
				foreach($query->result() as $row){
					$activityType = $this->lead_model->getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($row->id);
					$activity = 0;
					if(count($activityType)==0){
						$activityType = $this->lead_model->getPersonCompanyDetailFromSalesActivityLogByEmailID($row->id);
						if(count($activityType)>0){
							$activity = 1;
						} else {
							$activityType = $this->lead_model->getPersonCompanyDetailFromPreSalesActivityLogByEmailID($row->id);
							if(count($activityType)>0){
								$activity  = 3;
							}
						}
					} else {
						$activity = 2;
					}
					$row->from_activity = $activity;
					$data[] = $row;
				}
			}
			return $data;
	}
	
	public function findEmailFromWhichActivity($ID){
		$activityType = $this->getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($ID);
		if(count($activityType)==0){
			$activityType = $this->getPersonCompanyDetailFromSalesActivityLogByEmailID($ID);
			if(count($activityType)==0){
				$activityType = $this->getPersonCompanyDetailFromPreSalesActivityLogByEmailID($ID);
			}
		}	
		$email = "";
		if(count($activityType)>0){
			$getContactDetail = $this->findBrokerDetails($activityType->contact_id);
			if(count($getContactDetail)>0){
				$email = $getContactDetail->email;
			}
		}
		return $email;
	}
	
	public function getEmailList($limit){
		$data = array();
		$query = $this->db->select('b.*, a.company_id as aCompanyID, a.type as aType, s.company_id as sCompanyID,s.type as sType,l.lead_name')->from($this->table_box.' as b')->join($this->table_acquisition_activity.' as a','b.id = a.email_id','left')->join($this->table_sales_activity.' as s','b.id = s.email_id','left')->join($this->table_lead.' as l','l.id = b.lead_id')->where("l.status IN ('0','1','2')")->order_by('b.id','desc')->limit($limit,0)->get();
		if(count($query->num_rows())>0){
			foreach($query->result() as $row){
				$activityType = $this->lead_model->getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($row->id);
				$activity = 0;
				if(count($activityType)==0){
					$activityType = $this->lead_model->getPersonCompanyDetailFromSalesActivityLogByEmailID($row->id);
					if(count($activityType)>0){
						$activity = 1;
					} else {
						$activityType = $this->lead_model->getPersonCompanyDetailFromPreSalesActivityLogByEmailID($row->id);
						if(count($activityType)>0){
							$activity = 3;
						}
					}
				} else {
					$activity = 2;
				}
				$row->from_activity = $activity;
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function getMessageTaskList($userID,$leadID=0,$messageType=0){
		$counter=0;
		$list = array();
		if($messageType==0){
			if($leadID==0){
				$queryMySend = $this->db->select("DISTINCT(task_id) as taskID")->from($this->table_task_conversation.' as c')->where('c.from_u',$userID)->order_by('c.id','DESC')->get();
			} else {
				$queryMySend = $this->db->select("DISTINCT(task_id) as taskID")->from($this->table_task_conversation.' as c')->join($this->table_requests.' as r','r.id = c.task_id')->where('c.from_u',$userID)->where('r.lead_id',$leadID)->order_by('c.id','DESC')->get();
			}
			if(count($queryMySend->num_rows())>0){
				foreach($queryMySend->result() as $task){
					$queryTask = $this->db->select('c.from_u as sentUser,c.task_id as taskID,c.create_c,r.*,l.type as leadType,l.lead_name,u.name as fromUserName,u1.name as userName,u1.profile_pic,c.message as userMessage')->from($this->table_task_conversation.' as c')->join($this->table_requests.' as r','r.id = c.task_id')->join($this->table_lead.' as l','l.id = r.lead_id')->join('users as u','u.id=c.from_u')->join('users as u1','u1.id=r.user_id')->where('c.task_id',$task->taskID)->limit(1,0)->order_by('c.id','DESC')->get();
					/*echo $this->db->last_query()."<br/>";*/
					if ($queryTask->num_rows() > 0) {
						$data = $queryTask->first_row();
						if($data->sentUser==$userID){
							$list[] = $data;
							$counter++;
						}
					}
				}
			}
		} else if($messageType==1){
			if($leadID==0){
				$queryMyReceive = $this->db->select("DISTINCT(task_id) as taskID,f.message_id as messageID")->from($this->table_task_flag.' as f')->where('f.user_id',$userID)->where('f.status <> 2')->order_by('f.message_id','DESC')->get();
			} else {
				$queryMyReceive = $this->db->select("DISTINCT(task_id) as taskID,f.message_id as messageID")->from($this->table_task_flag.' as f')->join($this->table_requests.' as r','r.id = f.task_id')->where('f.user_id',$userID)->where('f.status <> 2')->where('r.lead_id',$leadID)->order_by('f.message_id','DESC')->get();
			}
			if(count($queryMyReceive->num_rows())>0){
				foreach($queryMyReceive->result() as $task){
					$currentMessage = $this->db->select("c.id as messageID")->from($this->table_task_conversation.' as c')->where('c.task_id',$task->taskID)->order_by('c.id','DESC')->get()->row();
					if(count($currentMessage)>0){
						$queryTask = $this->db->select('f.user_id as receiveUser,f.task_id as taskID,c.create_c,f.status as unRead,r.*,l.type as leadType,l.lead_name,u.name as fromUserName,u1.name as userName,u1.profile_pic,c.message as userMessage')->from($this->table_task_flag.' as f')->join($this->table_task_conversation.' as c', 'f.message_id= c.id')->join($this->table_requests.' as r','r.id = f.task_id')->join($this->table_lead.' as l','l.id = r.lead_id')->join('users as u','u.id=c.from_u')->join('users as u1','u1.id=r.user_id')->where('f.message_id',$currentMessage->messageID)->order_by('f.flag_id','DESC')->get();
						/*echo $this->db->last_query()."<br/>";*/
						if ($queryTask->num_rows() > 0) {
							foreach($queryTask->result() as $data){
								if($data->receiveUser==$userID){
									$list[] = $data;
									if($data->unRead=="1"){
										$counter++;
									}
								}
							}					
						}
					}
				}
			}
		}
		return array("count"=>$counter,"list"=>$list);		
	}
	
	public function getLinkedinMessagesList(){
		$list = array();
		$queryMessages = $this->db->select("*")->from($this->table_linkedin_messages.' as m')->order_by('created_at','DESC')->get();
		if($queryMessages->num_rows()>0){
			$list = $queryMessages->result();
		}
		return $list;
	}
	
	public function getListOfSourceURL(){
		$list = array();
		$querySources = $this->db->select("*")->from($this->table_source_url.' as s')->order_by('s.id','ASC')->get();
		if($querySources->num_rows()>0){
			$list = $querySources->result();
		}
		return $list;
	}
	
	public function deleteSendMessageById($ID){
		$this->db->where('id',$ID);
		$this->db->delete($this->table_send_linkedin_messages);
		return $this->db->affected_rows();
	}
	
	public function getLinkedinSendMessage($ID){
		$row = array();
		$queryLinkedinMessages = $this->db->select("m.*,c.id as contact_id,c.company_id")->from($this->table_send_linkedin_messages.' as m')->join($this->table_contacts.' as c', 'c.id = m.contact_id','left')->join($this->table_company.' as co', 'co.id = c.company_id','left')->where('m.id',$ID)->get();
		echo $this->db->last_query();
		if($queryLinkedinMessages->num_rows()>0){
			$row = $queryLinkedinMessages->first_row();
		}
		return $row;
	}
	
	public function getLinkedinSendMessagesList(){
		$list = array();
		$queryLinkedinMessages = $this->db->select("c.id,c.linkedin_url,c.first_name,c.last_name,c.job_title,c.linkedin_image,c.gender,c.linkedin_thread_id,co.company_name,co.company_name_alias,m.id as cListID,m.message")->from($this->table_send_linkedin_messages.' as m')->join($this->table_contacts.' as c', 'c.id = m.contact_id','left')->join($this->table_company.' as co', 'co.id = c.company_id','left')->where('c.linkedin_url <>','')->order_by('m.id','ASC')->get();
		
		if($queryLinkedinMessages->num_rows()>0){
			$list = $queryLinkedinMessages->result();
		}
		return $list;
	}
	
	public function deleteLinkedinMessage($ID){
		$this->db->where('id',$ID);
		$this->db->delete($this->table_linkedin_messages);
		return $this->db->affected_rows();
	}
	
	public function countLinkedinMessages(){
		$counter = $this->db->select("count(*) as counter")->from($this->table_linkedin_messages)->get()->row()->counter;
		if($counter == null){
			$counter = 0;
		}
		return $counter;
	}
	
	public function getEmailNotification(){
		$data = array();
		$queryMessages = $this->db->select("*")->from($this->table_email_notification.' as e')->order_by('system_update','DESC')->get();
		if($queryMessages->num_rows()>0){
			$data = $queryMessages->result();
		}
		return $data;
	}
	
	public function getThreadList($start, $end){
		$data = array();
		if($start > 0 && $end > 0){
			$this->db->where('last_conversation_date BETWEEN "'.$end.'" AND "'.$start.'"');
		}
		$queryMessages = $this->db->select("t.thread_id,t.id")->from($this->table_linkedin_threads.' as t')->where('status',0)->get();
		/*echo $this->db->last_query();*/
		if($queryMessages->num_rows()>0){
			$data = $queryMessages->result();
		}
		return $data;
	}
	
	public function findThreadsFromList($threadIDs){
		$data = array();
		print_r($threadIDs);
		$queryMessages = $this->db->select("t.thread_id,t.id")->from($this->table_linkedin_threads.' as t')->where_in('t.thread_id',$threadIDs)->get();
		echo $this->db->last_query()."<br/>";
		if($queryMessages->num_rows()>0){
			$data = $queryMessages->result();
		}
		return $data;
	}
	
	public function checkLinkedinMessage($createAT,$conversationID){
		$row = array();
		$queryMessages = $this->db->select("*")->from($this->table_linkedin_messages.' as m')->where('created_at',$createAT)->where('thread_id',$conversationID)->get();
		echo $this->db->last_query()."<br/>";
		if($queryMessages->num_rows()>0){
			$row = $queryMessages->first_row();
		}
		return $row;
	}	
	public function getLinkedinMessageById($ID){
		$row = array();
		$queryMessages = $this->db->select("*")->from($this->table_linkedin_messages.' as m')->where('id',$ID)->get();
		if($queryMessages->num_rows()>0){
			$row = $queryMessages->first_row();
			$contact = array();
			if($row->thread_id != ""){
				$linkedIN = $this->db->select('public_identifiers')->from($this->table_linkedin_threads)->where('thread_id',$row->thread_id)->get()->row()->public_identifiers;
				//echo $this->db->last_query();
				//echo $linkedIN;
				if($linkedIN != null && strpos($linkedIN,"linkedin") !== false){
					$anotherUrl = substr($linkedIN,-1);
					if($anotherUrl == "/"){
						$anotherUrl = substr($linkedIN,0,-1);
					} else {
						$anotherUrl = $linkedIN.'/';
					}
					$query = $this->db->select('c.*, co.company_name as company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.linkedin_url',$linkedIN)->or_where('c.linkedin_url',$anotherUrl)->get();
					//echo $this->db->last_query();
					if ($query->num_rows() > 0) {
						$contact = $query->first_row();         
					}
				}
			}
			$row->contact = $contact;
		}
		return $row;
	}
	
	public function getFlagConversations($userID,$flag=true,$leadID = 0){		
		$taskCount = (object) array("countNotify"=>0);
		$taskICount = (object) array("countNotify"=>0);
		if($flag==true && $leadID==0){
			/*$taskList = $this->waitingCalApproval($userID);*/
			$taskCount = $this->waitingApprovalCount($userID);
			/*$taskIList = $this->waitingICalApproval($userID);*/
			$taskICount = $this->waitingIApprovalCount($userID);
		} else {			
			/*$taskList = $this->getAllTaskMeFromLead($leadID);*/
			$taskCount = $this->getAllTaskFromLeadCount($leadID);
			/*$taskIList = $this->myTaskApproval($leadID);*/
			$taskICount = $this->myTaskApprovalCount($leadID);
		}		
		if($leadID==0){
			$queryMySend = $this->db->select("DISTINCT(task_id) as taskID")->from($this->table_task_conversation.' as c')->where('c.from_u',$userID)->order_by('c.id','DESC')->get();
		} else {
			$queryMySend = $this->db->select("DISTINCT(task_id) as taskID")->from($this->table_task_conversation.' as c')->join($this->table_requests.' as r','r.id = c.task_id')->where('c.from_u',$userID)->where('r.lead_id',$leadID)->order_by('c.id','DESC')->get();
		}
		$countSendUnread = 0;
		$countReceieveUnread = 0;
		if($queryMySend->num_rows()>0){
			foreach($queryMySend->result() as $task){
				$queryTask = $this->db->select('c.from_u as sentUser,c.task_id as taskID,c.create_c,r.*,l.type as leadType,l.lead_name,u.name as fromUserName,u1.name as userName,u1.profile_pic,c.message as userMessage')->from($this->table_task_conversation.' as c')->join($this->table_requests.' as r','r.id = c.task_id')->join($this->table_lead.' as l','l.id = r.lead_id')->join('users as u','u.id=c.from_u')->join('users as u1','u1.id=r.user_id')->where('c.task_id',$task->taskID)->limit(1,0)->order_by('c.id','DESC')->get();
				if ($queryTask->num_rows() > 0) {
					$data = $queryTask->first_row();
					if($data->sentUser==$userID){
						$countSendUnread++;
					}
				}
			}
		}
		if($leadID==0){
			$queryMyReceive = $this->db->select("DISTINCT(task_id) as taskID,f.message_id as messageID")->from($this->table_task_flag.' as f')->where('f.user_id',$userID)->where('f.status <> 2')->order_by('f.message_id','DESC')->get();
		} else {
			$queryMyReceive = $this->db->select("DISTINCT(task_id) as taskID,f.message_id as messageID")->from($this->table_task_flag.' as f')->join($this->table_requests.' as r','r.id = f.task_id')->where('f.user_id',$userID)->where('f.status <> 2')->where('r.lead_id',$leadID)->order_by('f.message_id','DESC')->get();
		}
		
		if(count($queryMyReceive->num_rows())>0){
			foreach($queryMyReceive->result() as $task){
				$currentMessage = $this->db->select("c.id as messageID")->from($this->table_task_conversation.' as c')->where('c.task_id',$task->taskID)->order_by('c.id','DESC')->get()->row();
				if(count($currentMessage)>0){
					$queryTask = $this->db->select('f.user_id as receiveUser,f.task_id as taskID,c.create_c,f.status as unRead,r.*,l.type as leadType,l.lead_name,u.name as fromUserName,u1.name as userName,u1.profile_pic,c.message as userMessage')->from($this->table_task_flag.' as f')->join($this->table_task_conversation.' as c', 'f.message_id= c.id')->join($this->table_requests.' as r','r.id = f.task_id')->join($this->table_lead.' as l','l.id = r.lead_id')->join('users as u','u.id=c.from_u')->join('users as u1','u1.id=r.user_id')->where('f.message_id',$currentMessage->messageID)->order_by('f.flag_id','DESC')->get();
					if ($queryTask->num_rows() > 0) {
						foreach($queryTask->result() as $data){
							if($data->receiveUser==$userID){
								if($data->unRead=="1"){
									$countReceieveUnread++;
								}
							}
						}					
					}
				}
			}
		}
		$returnArray['countSend'] = $countSendUnread;
		$returnArray['countReceieve'] = $countReceieveUnread;
		$returnArray['taskCount'] = $taskCount->countNotify;
		$returnArray['taskICount'] = $taskICount->countNotify;
		/*$returnArray['taskIList'] = $taskIList;*/
        /*$allArray['task_i'] = $this->myTaskApproval($row->id);*/		
		return $returnArray;
	}		
	
	public function getAllTaskMeFromLead($leadID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.activity_type,a.status as notifyStatus,a.create_date as taskCreateDate,l.id,l.lead_name,l.serial_number,l.type,l.create_date,uu.name as userName, u.name as uuserName, u.type as userType,u.profile_pic,c.id as contactID,c.company_id as companyID,c.first_name,c.last_name,c.email,c.secondary_email,c.tertiary_email,c.phone,c.telephone,co.telephone as companyphone,c.gateway,c.no_contact,c.active_email,c.new_email,c.new_phone,c.new_telephone,c.new_company,c.new_linkedin,c.linkedin_error,c.proximity,c.scrape_no,c.linkedin_url,co.company_name')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id')->join($this->table.' as u','u.id=a.user_id')->join($this->table.' as uu','uu.id=a.from_user_id')->join($this->table_contacts.' as c','c.id=a.contact_id','left')->join($this->table_company.' as co','co.id=c.company_id','left')->where('lead_id',$leadID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('a.user_id',$this->session->userdata['id'])->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		
		return $data;
	}	
	
	public function getAllTaskFromLeadCount($leadID){
		$query = $this->db->select('count(*) as countNotify')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id')->join($this->table.' as u','u.id=a.user_id')->join($this->table.' as uu','uu.id=a.from_user_id')->where('lead_id',$leadID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('a.user_id',$this->session->userdata['id'])->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get()->row();
		return $query;
	}
	
	public function myTaskApprovalCount($leadID){
		$data = $this->db->select('count(*) as countNotify')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.user_id')->where('a.from_user_id',$this->session->userdata['id'])->where('a.lead_id',$leadID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get()->row();		
		return $data;
	}
	
	public function myTaskApproval($leadID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.activity_type,a.status as notifyStatus,a.create_date as taskCreateDate,l.*,l.serial_number,u.name as userName, u.type as userType,u.profile_pic,c.id as contactID,c.company_id as companyID,c.first_name,c.last_name,c.email,c.secondary_email,c.tertiary_email,c.phone,c.telephone,co.telephone as companyphone,c.gateway,c.no_contact,c.active_email,c.new_email,c.new_phone,c.new_telephone,c.new_company,c.new_linkedin,c.linkedin_error,c.proximity,c.scrape_no,c.linkedin_url,co.company_name')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.user_id')->join($this->table_contacts.' as c','c.id=a.contact_id','left')->join($this->table_company.' as co','co.id=c.company_id','left')->where('a.from_user_id',$this->session->userdata['id'])->where('a.lead_id',$leadID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		/*echo $this->db->last_query();*/
		return $data;
	}
	
	public function getAllTaskFromLead($leadID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.status as notifyStatus,a.create_date as taskCreateDate,l.id,l.lead_name,l.type,l.create_date,uu.name as userName, u.name as uuserName, u.type as userType,u.profile_pic')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id')->join($this->table.' as u','u.id=a.user_id')->join($this->table.' as uu','uu.id=a.from_user_id')->where('lead_id',$leadID)->where('a.status <> 2')->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}
	
	public function waitingApprovalCount($userID){
		$query = $this->db->select('count(*) as countNotify')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.from_user_id')->where('a.user_id',$userID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get()->row();
		return $query;
	}
	
	public function waitingIApprovalCount($userID){
		$query = $this->db->select('count(*) as countNotify')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.user_id')->where('a.from_user_id',$userID)->where('a.status',0)->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get()->row();
		return $query;
	}
	
	public function waitingICalApproval($userID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.activity_type,a.status as notifyStatus,a.create_date as taskCreateDate,l.id,l.lead_name,l.serial_number,l.type,l.create_date,uu.name as userName, uu.type as userType,u.name as uuserName,u.profile_pic,c.id as contactID,c.company_id as companyID,c.first_name,c.last_name,c.email,c.secondary_email,c.tertiary_email,c.phone,c.telephone,co.telephone as companyphone,c.gateway,c.no_contact,c.active_email,c.new_email,c.new_phone,c.new_telephone,c.new_company,c.new_linkedin,c.linkedin_error,c.proximity,c.scrape_no,c.linkedin_url,co.company_name')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.from_user_id')->join($this->table.' as uu','uu.id=a.user_id')->join($this->table_contacts.' as c','c.id=a.contact_id','left')->join($this->table_company.' as co','co.id=c.company_id','left')->where('a.from_user_id',$userID)->where('a.status <> 2')->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		
		return $data;
	}
	
	public function waitingCalApproval($userID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.activity_type,a.status as notifyStatus,a.create_date as taskCreateDate,l.id,l.lead_name,l.serial_number,l.type,l.create_date,u.name as userName, u.type as userType,uu.name as uuserName,uu.profile_pic,c.id as contactID,c.company_id as companyID,c.first_name,c.last_name,c.email,c.secondary_email,c.tertiary_email,c.phone,c.telephone,co.telephone as companyphone,c.gateway,c.no_contact,c.active_email,c.new_email,c.new_phone,c.new_telephone,c.new_company,c.new_linkedin,c.linkedin_error,c.proximity,c.scrape_no,c.linkedin_url,c.linkedin_url,co.company_name')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.from_user_id')->join($this->table.' as uu','uu.id=a.user_id')->join($this->table_contacts.' as c','c.id=a.contact_id','left')->join($this->table_company.' as co','co.id=c.company_id','left')->where('a.user_id',$userID)->where('a.status <> 2')->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		
		return $data;
	}
	
	public function waitingApproval($userID){
		$query = $this->db->select('a.doc_url,a.id as approved_id,a.type as approved_type,a.subject, a.user_id as toUserID, a.from_user_id as fromUserID, a.parent_id,a.execution_date,a.completion_date,a.message,a.status as notifyStatus,a.create_date as taskCreateDate,l.*,u.name as userName, u.type as userType,c.first_name,c.last_name,co.company_name')->from($this->table_requests.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table.' as u','u.id=a.from_user_id')->join($this->table_contacts.' as c','c.id=a.contact_id','left')->join($this->table_company.' as co','co.id=c.company_id','inner')->where('a.user_id',$userID)->where('a.status <> 2')->where('date_format(a.execution_date,"%Y-%m-%d")<="'.date("Y-m-d").'"')->where('l.status IN (0,1,2)')->order_by('a.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		
		return $data;
	}
	
	public function deleteTask($taskID){
		$this->db->where('task_id',$taskID);
		$this->db->delete($this->table_task_flag);
		$this->db->where('task_id',$taskID);
		$this->db->delete($this->table_task_conversation);
		$this->db->where('id',$taskID);
		$this->db->delete($this->table_requests);
	}
	
	public function countUnreadMessage($userID){
		$query = $this->db->select('count(*) as messageCount')->from($this->table_task_flag.' as f')->where('f.user_id',$userID)->where('f.status','1')->get()->row();
		return $query->messageCount;
	}
	
	public function getTaskConversation($taskID){
		$this->updateTaskFlagConversation($taskID,$this->session->userdata['id'], array('status'=>'0'));
		$listQuery = $this->db->select("c.*,u1.id as fromUser, u1.name as fromUserName, u1.profile_pic,u2.id as toUser, u2.name as toUserName, u2.profile_pic")->from($this->table_task_conversation.' as c')->join($this->table_task_flag.' as tf','tf.message_id = c.id')->join('users as u1','u1.id=c.from_u')->join('users as u2','u2.id=tf.user_id')->where("c.task_id",$taskID)->order_by('c.id', 'ASC')->get();
		$list = array();
		if(count($listQuery->num_rows())>0){
			$count = 0;
			foreach($listQuery->result() as $box){
				$list[] = $box;				
			}
		}
		return $list;
	}
	
	public function getTaskConversationList($taskID){
		$listQuery = $this->db->select("c.*,u1.id as fromUser, u1.name as fromUserName, u1.profile_pic")->from($this->table_task_flag.' as c')->join('users as u1','u1.id=c.user_id')->where("c.task_id",$taskID)->order_by('c.flag_id', 'ASC')->get();
		$list = array();
		if(count($listQuery->num_rows())>0){
			$count = 0;
			foreach($listQuery->result() as $box){
				$list[] = $box;				
			}
		}
		return $list;
	}
	
	public function updateTaskFlagConversation($taskID,$userID,$data){
		$this->db->where('task_id',$taskID);
		$this->db->where('user_id',$userID);
		$this->db->update($this->table_task_flag, $data);
		
	}
	
	public function getContactToken(){
		$listQuery = $this->db->select("*")->from($this->table_contacts_access)->get();
		$data = array();
		if(count($listQuery->num_rows())>0){
			$data = $listQuery->first_row();
		}
		return $data;
	}
	
	public function findCompanyData($companyID){		
		$listQuery = $this->db->select("id,company_name")->from($this->table_company)->where('id',$companyID)->get();
		$data = array();
		if(count($listQuery->num_rows())>0){
			$data = $listQuery->first_row();
		}
		return $data;
	}
	
	public function findLucidData($leadID){
		$listQuery = $this->db->select("*")->from($this->table_chart)->where('lead_id',$leadID)->get();
		$list =array();
		if(count($listQuery->num_rows())>0){
			foreach($listQuery->result() as $box){
				$list[] = $box;
			}
		}
		return $list;
	}
	
	public function insertChart($data){
		// Inserting in Table(Litigation) 
		$this->db->insert($this->table_chart, $data);
		return $this->db->insert_id();
	}
	public function updateChart($id,$data){
		// Inserting in Table(Litigation) 
		$this->db->where('lead_id', $id);
		$this->db->update($this->table_chart, $data);
		return $id;
	}
	
	public function updateChartWithLead($leadID,$patent,$data){
		$this->db->where('lead_id', $leadID);
		$this->db->where('patent', $patent);
		$this->db->update($this->table_chart, $data);
		return $leadID;
	}
	
	public function from_litigation_insert($data){
		// Inserting in Table(Litigation) 
		$this->db->insert($this->table_lead, $data);
		return $this->db->insert_id();
	}
	public function from_litigation_update($id,$data){
		// Inserting in Table(Litigation) 
		/*$this->db->set_charset('utf8');*/
		$this->db->query("SET NAMES 'UTF8'");
		$this->db->query("SET CHARACTER SET 'utf8'");
		$this->db->query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
		$this->db->where('id', $id);
		$this->db->update($this->table_lead, $data);
		
		return $id;
	}
	
	public function insertPassLead($data){
		$this->db->insert($this->table_pass,$data);
		return $this->db->insert_id(); 
	}
	
	public function insertBox($data){
		/*$this->db->database();
		$this->db->reconnect();
		$this->load->database();*/
		$this->db->insert($this->table_box,$data);
		return $this->db->insert_id();
	}
	
	public function updateBox($id,$data){
		// Inserting in Table(Litigation) 
		$this->db->where('id', $id);
		$this->db->update($this->table_box, $data);
		
		return $id;
	}
	
	public function insertGmailMessages($data){
		$this->db->insert($this->table_gmail,$data);
		return $this->db->insert_id();
	}
	
	public function getPassLead(){		
		$data = array("message"=>array(),"lead"=>array());		
		return $data;
	}
	
	public function getGmailMessages($userID){
		$query= $this->db->select("*")->from($this->table_gmail)->where("user_id",$userID)->order_by('id','DESC')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();			
		}
		return $data;
	}
	
	public function findUserDetails($userID,$select){
		$query= $this->db->select($select)->from($this->table)->where("id",$userID)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();			
		}
		return $data;
	}
	
	public function getInnerUserList(){
		$query= $this->db->select("id,name")->from($this->table)->where("status",0)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->result();		
		}
		return $data;
	}
	
	public function removeFromBox($leadID,$threadID){
		$this->db->where('lead_id',$leadID);
		$this->db->where('id',$threadID);
		$this->db->delete($this->table_box);
		return $this->db->affected_rows();
	}
	public function removeFromAcquisition($leadID,$threadID){
		$this->db->where('lead_id',$leadID);
		$this->db->where('email_id',$threadID);
		$this->db->delete($this->table_acquisition_activity);
		return $this->db->affected_rows();
	}
	public function removeFromSales($leadID,$threadID){
		$this->db->where('lead_id',$leadID);
		$this->db->where('email_id',$threadID);
		$this->db->delete($this->table_sales_activity);
		return $this->db->affected_rows();
	}	
	public function deleteLead($leadID){
		$this->db->where('id',$leadID);
		$this->db->delete($this->table_lead);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_box);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_acquisition_company);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_presales_activity);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_acquisition_activity);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_sales_activity);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_invitees);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_acquisition);
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_assign_lead);
		$this->db->where('parent_id',$leadID);
		$this->db->delete('other_comments');
		$queryRequest = $this->db->select('*')->from($this->table_requests)->where('lead_id',$leadID)->get();
		if($queryRequest->num_rows()>0){
			foreach ($queryRequest->result() as $row) {
				$taskID = $row->id;
				$this->db->where('task_id',$taskID);
				$this->db->delete($this->table_task_flag);
				$this->db->where('task_id',$taskID);
				$this->db->delete($this->table_task_conversation);
				$this->db->where('id',$taskID);
				$this->db->delete($this->table_requests);				
				$this->deleteApprovalRequest($leadID);
				$this->deleteHistory($leadID);
				$this->deleteLeadButtons($leadID);
			}	
		}
		return $this->db->affected_rows();
	}	
	public function findIncompleteList($type){
		$query = $this->db->select('*')->from($this->table_lead)->where('complete','0')->where('type',$type)->get();
		$data = array();
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
				/*Broker Name*/
					if(!empty($row->broker)){
						$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker)->get()->row();
						if(count($brokderData)>0){
							$row->broker_contact = $brokderData->company_name;
							$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
						} else {
							$row->broker_contact ='';
							$row->broker_person_contact = '';
							$row->broker = '';
						}
					}
					
					/*End Broker Name*/
					/*Seller Name*/
					if(!empty($row->plantiffs_name)){
						$sellerInfo = $this->db->select('cc.company_name')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
						if(count($sellerInfo)>0){
							$row->seller_contact = $sellerInfo->company_name;
						} else {
							$row->seller_contact = '';
							$row->plantiffs_name = '';
						}
					}
					/*End Seller Name*/
				$boxQuery = $this->db->select("*")->from($this->table_box)->where('lead_id',$row->id)->get();
				$boxData =array();
				if(count($boxQuery->num_rows())>0){
					$boxData = $boxQuery->result();
				}
				$row->box_list = $boxData;
				$data[] = $row;
			}			
		}
		return $data;
	}
	public function getAllEmails(){
		$boxQuery = $this->db->select("*")->from($this->table_box)->where('date_received','0000-00-00 00:00:00')->get();
		$boxData =array();
		if(count($boxQuery->num_rows())>0){
			$boxData = $boxQuery->result();
		}
		return $boxData;
	}
	
	public function searchBoxListByContent($content){
		$boxQuery = $this->db->select("*")->from($this->table_box)->like('content',$content)->order_by('id','DESC')->limit(1)->get();
		$boxData =array();
		if(count($boxQuery->num_rows())>0){
			$boxData = $boxQuery->first_row();
		}
		return $boxData;
	}
	
	public function searchLeads($searchData){
		$data = array();
		$conditions = "";
		$flag = 0;
		if(!empty($searchData['has_the_words'])){
			/*From whole database*/
			$search_values = array($searchData['has_the_words']);
			$table_fields = array();
			$cumulative_results = array();
			$CI = &get_instance();
			$CI->load->database();
			$db_name = $CI->db->database;
			$tableNames = array('task_conversation','sectors','sec_agreements','sales_broker_lead_company','sales_activity_log_detail','litigations','lead_template_files','email_template','acquisition','acquisition_activity_log_detail','acquisition_company','activity_log_detail','category','map_sectors_departments','box_list','company','company_sector','contacts');
			// Pull all table columns that have character data types
			$result = $this->db->query("
				SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE
				FROM  `INFORMATION_SCHEMA`.`COLUMNS` 
				WHERE  `TABLE_SCHEMA` =  '{$db_name}'
				AND `DATA_TYPE` IN ('varchar', 'char', 'text')
				")->result_array();
			
			// Build table-keyed columns so we know which to query
			foreach ( $result  as $o ) 
			{
				$table_fields[$o['TABLE_NAME']][] = $o['COLUMN_NAME'];			
			}
			
			// Build search query to pull the affected rows
			// Search Each Row for matches
			foreach($table_fields as $table_name => $fields)
			{
				// Clear search array
				if(in_array($table_name,$tableNames)){
					$search_array = array();				
					// Add a search for each search match
					foreach($fields as $field)
					{
						foreach($search_values as $value) 
						{
							$search_array[] = " `{$field}` LIKE '%{$value}%' ";
						}
					}
					// Implode $search_array
					$search_string = implode (' OR ', $search_array);
					$query_string = "SELECT * FROM `{$table_name}` WHERE {$search_string}";
					
					$table_results = $this->db->query($query_string)->result_array();
					if(array_key_exists('lead_id',$table_results)){
						if(count($table_results)>0){
							foreach($table_results as $result){
								$cumulative_results[] = $result['lead_id'];
							}
						}						
					} else if($table_name=="litigations"){
						if(count($table_results)>0){
							foreach($table_results as $result){
								$cumulative_results[] = $result['id'];
							}
						}
					} else if (array_key_exists('company_name',$table_results)){
						/*Company Name*/
						if(count($table_results)>0){
							foreach($table_results as $result){
								$query = $this->db->select("distinct(l.id) as lead_id")->from($this->table_lead.' as l')->join($this->table_activity_log.' as a','l.id = a.lead_id')->where('a.company_id',$result['id'])->get()->result_array();
								if(count($query)>0){
									foreach($query as $val){
										$cumulative_results[] = $result['lead_id'];
									}
								}
							}
						}
					} else if (array_key_exists('first_name',$table_results)){
						/*Contacts*/
						if(count($table_results)>0){
							foreach($table_results as $result){
								$query = $this->db->select("distinct(l.id) as lead_id")->from($this->table_lead.' as l')->join($this->table_activity_log.' as a','l.id = a.lead_id')->where('a.contact_id',$result['id'])->get()->result_array();
								if(count($query)>0){
									foreach($query as $val){
										$cumulative_results[] = $result['lead_id'];
									}
								}
							}
						}
					} else if ($table_name=="sectors"){
						/*Sectors*/
						if(count($table_results)>0){
							foreach($table_results as $result){
								$query = $this->db->select("distinct(l.id) as lead_id")->from($this->table_lead.' as l')->join($this->table_activity_log.' as a','l.id = a.lead_id')->join($this->table_company_sector.' as cs','cs.company_id=a.company_id')->join($this->table_sector.' as s','s.id=cs.sector_id')->where('s.id',$result['id'])->get()->result_array();
								if(count($query)>0){
									foreach($query as $val){
										$cumulative_results[] = $result['lead_id'];
									}
								}
							}
						}
					} else if ($table_name=="category"){
						/*Category*/
						if(count($table_results)>0){
							foreach($table_results as $result){
								$query = $this->db->select("distinct(l.id) as lead_id")->from($this->table_lead.' as l')->join($this->table_activity_log.' as a','l.id = a.lead_id')->join($this->table_company_sector.' as cs','cs.company_id=a.company_id')->join($this->table_map_sectors_departments.' as ms','ms.sector_id=cs.sector_id')->join($this->table_category.' as c','c.id=ms.category_id')->where('c.id',$result['id'])->get()->result_array();
								if(count($query)>0){
									foreach($query as $val){
										$cumulative_results[] = $result['lead_id'];
									}
								}
							}
						}
					}
				}				
			}
			if(count($cumulative_results)>0){
				if((int)$this->session->userdata['type']!=9){
					$sql = "SELECT distinct(l.id) as id,l.lead_name,l.type,l.complete,l.seller_info_text,l.seller_like,l.synpat_like,l.ppa_date,l.funding_trnsfr,l.seller_info FROM ".$this->table_lead." as l INNER JOIN ".$this->table_assign_lead." as al ON al.lead_id = l.id WHERE l.id IN (".implode(',',$cumulative_results).") AND al.pd_id= ".$this->session->userdata['id']." AND l.status IN ('0','1','2') AND l.type <> 'INT' ORDER BY l.lead_name ASC";
				} else {
					$sql = "SELECT l.* FROM ".$this->table_lead." as l WHERE l.id IN (".implode(',',$cumulative_results).") AND l.status IN ('0','1','2') ORDER BY l.lead_name ASC";
				}
				$query = $this->db->query($sql);
				if($query->num_rows()>0){
					foreach ($query->result() as $row) {
						$data[] = $row;
					}
				}
			}	
		} else {
			if(!empty($searchData['lead_name'])){
				$flag = 1;
				$conditions = " lead_name LIKE '%".$this->db->escape_like_str($searchData['lead_name'])."%' ";
			}
			if(!empty($searchData['plantiffs_name'])){
				if($flag==1){
					$conditions .= " OR plantiffs_name LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'  OR seller_contact  LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'";
				} else {
					$flag = 1;
					$conditions = "  plantiffs_name LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'  OR seller_contact  LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'";
				}			
			}
			if(!empty($searchData['plantiffs_name'])){
				if($flag==1){
					$conditions .= " OR plantiffs_name LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'  OR seller_contact  LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'";
				} else {
					$flag = 1;
					$conditions = "  plantiffs_name LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'  OR seller_contact  LIKE '%".$this->db->escape_like_str($searchData['plantiffs_name'])."%'";
				}			
			}
			if(!empty($searchData['person_name_1'])){
				if($flag==1){
					$conditions .= " OR person_name_1 LIKE '%".$this->db->escape_like_str($searchData['person_name_1'])."%'  ";
				} else {
					$flag = 1;
					$conditions = "  person_name_1 LIKE '%".$this->db->escape_like_str($searchData['person_name_1'])."%' ";
				}			
			}
			if(!empty($searchData['person_name_2'])){
				if($flag==1){
					$conditions .= " OR person_name_2 LIKE '%".$this->db->escape_like_str($searchData['person_name_2'])."%'  ";
				} else {
					$flag = 1;
					$conditions = "  person_name_2 LIKE '%".$this->db->escape_like_str($searchData['person_name_2'])."%' ";
				}			
			}
			if(!empty($searchData['broker'])){
				if($flag==1){
					$conditions .= " OR broker_contact LIKE '%".$this->db->escape_like_str($searchData['broker'])."%'  ";
				} else {
					$flag = 1;
					$conditions = "  broker_contact LIKE '%".$this->db->escape_like_str($searchData['broker'])."%' ";
				}			
			}
			if(!empty($searchData['broker_person'])){
				if($flag==1){
					$conditions .= " OR broker_person_contact LIKE '%".$this->db->escape_like_str($searchData['broker_person'])."%'  ";
				} else {
					$flag = 1;
					$conditions = "  broker_person_contact LIKE '%".$this->db->escape_like_str($searchData['broker_person'])."%' ";
				}			
			}
			if(!empty($searchData['relates_to'])){
				if($flag==1){
					$conditions .= " OR relates_to LIKE '%".$this->db->escape_like_str($searchData['relates_to'])."%'  ";
				} else {
					$flag = 1;
					$conditions = "  relates_to LIKE '%".$this->db->escape_like_str($searchData['relates_to'])."%' ";
				}			
			}
			if(!empty($searchData['serial_number'])){			
				$conditions = "  serial_number ='".$this->db->escape_like_str($searchData['serial_number'])."'";						
			}
			if((int)$this->session->userdata['type']!=9){
				$sql = "SELECT distinct(l.id) as id,l.lead_name,l.type,l.complete,l.seller_info_text,l.seller_like,l.synpat_like,l.ppa_date,l.funding_trnsfr,l.seller_info FROM ".$this->table_lead." as l INNER JOIN ".$this->table_assign_lead." as al ON al.lead_id = l.id WHERE ".$conditions." AND al.pd_id= ".$this->session->userdata['id']." AND l.status IN ('0','1','2') AND l.type <> 'INT' ORDER BY l.lead_name ASC";
			} else {
				$sql = "SELECT distinct(l.id) as id,l.lead_name,l.type,l.complete,l.seller_info_text,l.seller_like,l.synpat_like,l.ppa_date,l.funding_trnsfr,l.seller_info FROM ".$this->table_lead." as l WHERE ".$conditions." AND l.status IN ('0','1','2') ORDER BY l.lead_name ASC";
			}
			$query = $this->db->query($sql);
			if($query->num_rows()>0){
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
			}
		}
		
		return $data;
	}	
	public function getAllLeads(){
		$query = $this->db->select('*')->from($this->table_lead)->where("status IN ('0','1','2')")->order_by('lead_name','ASC')->get();
		$data = array();
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
				$data[] = $row;
			}			
		}
		return $data;
	}	
	public function findEOULeadMaterial($serialNumber){
		$query = $this->db->select('other_field')->from('wp_popup_data')->where('serial_number',$serialNumber)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function countLead(){
		$totalLead = $this->db->select("count(id) as countLead")->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->get()->row()->countLead;
		return $totalLead;
	}
	
	public function findIncompleteANDCompleteListByFields($fieldsArray = array()){
		$data = array();
		if($this->session->userdata['type']==9){
			
			/*if($page>0){
				$this->db->limit($page,$start);
			}*/
			$query = $this->db->select(implode(',',$fieldsArray))->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->order_by('lead_name','ASC')->get();
			
			if($query->num_rows()>0){
				$data = $query->result();
			}
		} else {
			$checkUserAssignLead = $this->checkUserLeads($this->session->userdata['id']);
			$checkUserAssignLeadType = $this->checkUserAssignLeadType($this->session->userdata['id']);
			$data = array();
			/*$query = $this->db->select('l.*')->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
			*/
			$query = "";
			if(count($checkUserAssignLead)>0 && count($checkUserAssignLeadType)>0){
				$leadType = implode('","', $checkUserAssignLeadType);
				$leadAssigned = implode(',', $checkUserAssignLead);
				$query = $this->db->select(implode(',',$fieldsArray))->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->or_where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('lead_name','ASC')->get();
			} else if(count($checkUserAssignLead)>0){
				$leadAssigned = implode(',', $checkUserAssignLead);
				$query = $this->db->select(implode(',',$fieldsArray))->from($this->table_lead.' as l')->where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('lead_name','ASC')->get();
			} else if(count($checkUserAssignLeadType)>0){
				$leadType = implode('","', $checkUserAssignLeadType);
				$query = $this->db->select(implode(',',$fieldsArray))->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('lead_name','ASC')->get();
			}
			if(is_object($query) && $query->num_rows()>0){
				$data = $query->result();
			}
		}
		return $data;
	}
	
	
	
	public function findIncompleteANDCompleteList($type='',$start=0,$page=0,$orderByField="l.update_date",$orderBy="DESC"){
		//$query = $this->db->select('*')->from($this->table_lead)->where('type',$type)->get();
        $data = array();
		if(empty($orderByField)){
			$orderByField="l.update_date";
		}
		if(empty($orderBy)){
			$orderByField="DESC";
		}
		if($this->session->userdata['type']==9){
			
			/*if($page>0){
				$this->db->limit($page,$start);
			}*/
			$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->order_by($orderByField,$orderBy)->get();
			
			if($query->num_rows()>0){
				$data = $this->resultsCombineWithOtherData($query->result());
			}
		} else {
			$checkUserAssignLead = $this->checkUserLeads($this->session->userdata['id']);
			$checkUserAssignLeadType = $this->checkUserAssignLeadType($this->session->userdata['id']);
			$data = array();
			/*$query = $this->db->select('l.*')->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
			*/
			$query = "";
			if(count($checkUserAssignLead)>0 && count($checkUserAssignLeadType)>0){
				$leadType = implode('","', $checkUserAssignLeadType);
				$leadAssigned = implode(',', $checkUserAssignLead);
				$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->or_where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by($orderByField,$orderBy)->get();
			} else if(count($checkUserAssignLead)>0){
				$leadAssigned = implode(',', $checkUserAssignLead);
				$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by($orderByField,$orderBy)->get();
			} else if(count($checkUserAssignLeadType)>0){
				$leadType = implode('","', $checkUserAssignLeadType);
				$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by($orderByField,$orderBy)->get();
			}
			if(is_object($query) && $query->num_rows()>0){
				$data = $this->resultsCombineWithOtherData($query->result());
			}
		}		
		return $data;
	}

	public function getPOSAgreementsWithCustomer($leadID){
		$data = array();
		$getPosAgreements = $this->db->select("bi.lead_id as leadID, co.id as company_id,co.company_name as companyName")->from($this->table_invitees.' as bi')->join($this->table_company.' as co','co.id=bi.contact_id')->where("bi.lead_id",$leadID)->get();
		/*echo $this->db->last_query();*/
		if ($getPosAgreements->num_rows() > 0) {
			foreach ($getPosAgreements->result() as $agreements) {
				$data[] = $agreements;
			}
		}
		return $data;
	}
	
	public function getLeadInviteesSalesAndAcquisition($leadID,$activity){
		if($activity==1){
			$getInviteesCompanies = $this->db->select("c.id")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC')->get();
			$companies = array();
			if ($getInviteesCompanies->num_rows() > 0) {
				foreach ($getInviteesCompanies->result() as $company) {
					$companies[] = $company->id;
				}
			}
		} else if($activity==2){
			$getInviteesCompanies = $this->db->select("c.id")->from($this->table_acquisition_company.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC')->get();
			if ($getInviteesCompanies->num_rows() > 0) {
				foreach ($getInviteesCompanies->result() as $company) {
					$companies[] = $company->id;
				}
			}
		}		
		$data = array();
		if(count($companies)>0){
			$companies = array_unique($companies);			
			$contactsList = $this->db->select("c.id,CONCAT((c.first_name),(' '),(c.last_name),('- '),(co.company_name)) as label,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,c.company_id,c.job_title as title, c.email as `value`, c.secondary_email as secondary, c.tertiary_email as tertiary")->from($this->table_contacts.' as c')->join($this->table_company.' as co', 'co.id = c.company_id')->where_in("c.company_id",$companies)->order_by('c.first_name','ASC')->get();
			if ($contactsList->num_rows() > 0) {
				foreach ($contactsList->result() as $contact) {
					$data[] = $contact;
				}
			}
			$companiesGrouped = array();
			if(count($data)>0){
				$companiesCompiled = array();
				for($i=0;$i<count($data);$i++){
					if(!in_array($data[$i]->company_name,$companiesCompiled)){
						$name = $data[$i]->company_name;
						$companyID = $data[$i]->company_id;
						$list = array();
						for($t=0;$t<count($data);$t++){
							if($data[$t]->company_name==$name){
								$list[] = $data[$t];
							}
						}
						$companiesGrouped[] = array("name"=>$name,"list"=>$list,"company_id"=>$companyID);
						$companiesCompiled[] = $name;
					}
				}
			}
			$data = $companiesGrouped;
			
		}
		return $data;
	}
	
	public function getSalesActivityCompaniesByLead($leadID){
		$data = array();
		$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			foreach ($getInviteesCompanies->result() as $company) {
				$data[] = $company;
			}
		}
		return $data;
	}
	public function getAcquisitionActivityCompaniesByLead($leadID){
		$data = array();
		$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_acquisition_company.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			$data = $getInviteesCompanies->result();
		}
		return $data;
	}
	public function getPreSaleActivityCompaniesByLead($leadID){
		$data = array();
		$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.pre_sale_activity DESC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			foreach ($getInviteesCompanies->result() as $company) {
				$data[] = $company;
			}
		}
		return $data;
	}
	function findCallData($activityID,$t){
		$data = array();
		$query = "";
		if($t==1){
			$query = $this->db->select("s.*,CONCAT((p.first_name),(' '),(p.last_name)) as personName")->from($this->table_sales_activity.' as s')->join($this->table_contacts.' as p','p.id = s.contact_id')->where('s.id',$activityID)->get();
		} else if($t==2){
			$query = $this->db->select("s.*,CONCAT((p.first_name),(' '),(p.last_name)) as personName")->from($this->table_acquisition_activity.' as s')->join($this->table_contacts.' as p','p.id = s.contact_id')->where('s.id',$activityID)->get();
		}
		if(is_object($query)){
			if($query->num_rows()>0){
				$data = $query->first_row();
			}
		}
		return $data;
	}	
	function findPersonLastActivty($leadID,$companyID,$personID,$activity){
		$data = array();
		switch((int)$activity){
			case 2:
				$query = $this->db->select("*")->from($this->table_acquisition_activity)->where('lead_id',$leadID)->where('contact_id',$personID)->where('company_id',$companyID)->where('email_id',0)->order_by('id desc')->limit(1,0)->get();
				if($query->num_rows()>0){
					$data = $query->first_row();
				}
			break;
			case 1:
			default:
				$query = $this->db->select("*")->from($this->table_sales_activity)->where('lead_id',$leadID)->where('contact_id',$personID)->where('company_id',$companyID)->where('email_id',0)->order_by('id desc')->limit(1,0)->get();
				if($query->num_rows()>0){
					$data = $query->first_row();
				}
			break;
		}
		return $data;
	}
	function getSalesContatcsByLead($leadID){
		$persons = array();
		$getInviteesCompanies = $this->db->select("c.id,c.company_name,s.id as sectorID, s.name as sectorName")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->join($this->table_company_sector.' as cs', 'c.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			foreach ($getInviteesCompanies->result() as $company) {
				$getPersons = $this->db->select("*")->from($this->table_contacts)->where("company_id",$company->id)->order_by("first_name DESC")->get();
				if($getPersons->num_rows()>0){
					foreach ($getPersons->result() as $p) {
						$p->company_name = $company->company_name;
						$p->sectorName = $company->sectorName;
						$p->departments =  $this->departments($company->id);
						$persons[] = $p;
					}
				}
			}
		}
		return $persons;
	}	
	
	function departments($customerID){
		$query = $this->db->select("c.*")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.customer_id",$customerID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	public function allLeadsWithActivity($activity){
		/*2=>Acquisition,1=>Sales Activity*/
		$query = $this->db->select('id,lead_name')->from($this->table_lead)->where("status IN ('0','1','2')")->order_by('lead_name ASC')->get();
		$data = array();		
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
				$companyData = array();	
				if($activity==2){
					$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_acquisition_company.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$row->id)->order_by('i.last_activity DESC')->get();
					if ($getInviteesCompanies->num_rows() > 0) {
						foreach ($getInviteesCompanies->result() as $company) {
							$getPersons = $this->db->select("*")->from($this->table_contacts)->where("company_id",$company->id)->order_by("first_name DESC")->get();
							$persons =array();
							if($getPersons->num_rows()>0){
								$persons = $getPersons->result();
							}				
							$companyData[]=array("company"=>$company,"people"=>$persons);
						}
					}
				} else if($activity==3){
					$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$row->id)->order_by('i.pre_sale_activity DESC')->get();
					if ($getInviteesCompanies->num_rows() > 0) {
						foreach ($getInviteesCompanies->result() as $company) {
							$getPersons = $this->db->select("*")->from($this->table_contacts)->where("company_id",$company->id)->order_by("first_name DESC")->get();
							$persons =array();
							if($getPersons->num_rows()>0){
								$persons = $getPersons->result();
							}				
							$companyData[]=array("company"=>$company,"people"=>$persons);
						}
					}
				} else {
					$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$row->id)->order_by('i.last_activity DESC')->get();
					if ($getInviteesCompanies->num_rows() > 0) {
						foreach ($getInviteesCompanies->result() as $company) {
							$getPersons = $this->db->select("*")->from($this->table_contacts)->where("company_id",$company->id)->order_by("first_name DESC")->get();
							$persons =array();
							if($getPersons->num_rows()>0){
								$persons = $getPersons->result();
							}				
							$companyData[]=array("company"=>$company,"people"=>$persons);
						}
					}
				}				
				$row->box_list = $companyData;
				$data[] = $row;
			}			
		}
		return $data;
	}
	function checkUserLeads($userID){
		$data = array();
		$query = $this->db->select('l.lead_id as id')->from($this->table_assign_lead.' as l')->where('l.pd_id',$userID)->get();
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
				$data[] =  $row->id;
			}
		}/*
		$findUserEmail = $this->db->select('u.email')->from($this->table.' as u')->where('u.id',$userID)->get()->row()->email;
		if(!empty($findUserEmail) && $findUserEmail!=null){
			$getContactDetails = $this->db->select('c.*')->from($this->table_contacts.' as c')->where('trim(c.email)',$findUserEmail)->get();
			if($getContactDetails->num_rows()>0){
				$contact = $getContactDetails->first_row();
				<!--Leads from sales-->
				$findAllContactsBelongsToContactCompany = $this->db->select("c.id")->from($this->table_contacts.' as c')->where("c.company_id",$contact->company_id)->get();
				$allContacts = array();
				if($findAllContactsBelongsToContactCompany->num_rows()>0){
					foreach($findAllContactsBelongsToContactCompany->result() as $row){
						$allContacts[] = $row->id;
					}
					if(count($allContacts)>0){
						$findCompanyAssociateToThisContacts = $this->findCompaniesAssociate($allContacts);
						$findCompanyAssociateToThisContacts[] = $contact->company_id;
						if(count($findCompanyAssociateToThisContacts)>0){
							$companies = implode(',',$findCompanyAssociateToThisContacts);
							$getLeadsFromSales = $this->db->select('DISTINCT(i.lead_id) as lead_id')->from($this->table_invitees.' as i')->where('i.contact_id IN ('.$companies.')')->get();
							if($getLeadsFromSales->num_rows()>0){
								foreach($getLeadsFromSales->result() as $row){
									$data[] = $row->lead_id;
								}
							}
						}
					}
				}
			}
		}*/
		return $data;
	}	
	function checkUserAssignLeadType($userID){
		$data = array();
		$query = $this->db->select('l.lead_type as type')->from($this->table_assign_lead_type.' as l')->where('l.user_id',$userID)->get();
		if($query->num_rows()>0){
			foreach ($query->result() as $row) {
				$data[] =  '"'.$row->type.'"';
			}
		}
		return $data;
	}

	public function countAssignedLead($userID){
		$checkUserAssignLead = $this->checkUserLeads($userID);
		$checkUserAssignLeadType = $this->checkUserAssignLeadType($userID);
		$totalCount = 0;
		if(count($checkUserAssignLead)>0 && count($checkUserAssignLeadType)>0){
			$leadType = implode('","', $checkUserAssignLeadType);
			$leadAssigned = implode(',', $checkUserAssignLead);
			$totalCount = $this->db->select("count(id) as totalLead")->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->or_where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->get()->row()->totalLead;
		}else if(count($checkUserAssignLead)>0){
			$leadAssigned = implode(',', $checkUserAssignLead);
			$totalCount = $this->db->select("count(id) as totalLead")->from($this->table_lead.' as l')->where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->get()->row()->totalLead;
		} else if(count($checkUserAssignLeadType)>0){
			$leadType = implode('","', $checkUserAssignLeadType);
			$totalCount = $this->db->select("count(id) as totalLead")->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->get()->row()->totalLead;
		}
		return $totalCount;
	}
	
	public function resultsCombineWithOtherData($results){
		$data = array();
		foreach ($results as $row) {
			if(!empty($row->broker_person)){
				$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name,cc.company_name_alias,cc.id as companyID')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker_person)->get()->row();
				if(count($brokderData)>0){
					if(!empty($brokderData->company_name_alias)){
						$row->broker_contact = $brokderData->company_name_alias;
					} else {
						$row->broker_contact = $brokderData->company_name;
					}				
					$row->broker_company = $brokderData->companyID;
					$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
				} else {
					$row->broker_contact ='';
					$row->broker_company = 0;
					$row->broker_person_contact = '';
					$row->broker_person = '';
				}
			}else {
				$row->broker_company = 0;
			}
			/*End Broker Name*/
			/*Seller Name*/
			if(!empty($row->plantiffs_name)){
				$sellerInfo = $this->db->select('cc.company_name,cc.company_name_alias')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
				if(count($sellerInfo)>0){
					if(!empty($sellerInfo->company_name_alias)){
						$row->seller_contact = $sellerInfo->company_name_alias;
					} else {
						$row->seller_contact = $sellerInfo->company_name;
					}
				} else {
					$row->seller_contact = '';
					$row->plantiffs_name = '';
				}
			}
			/*End Seller Name*/
			/*Lead Last seen*/
			$row->lead_last_seen = "0000-00-00";
			$queryLastSeen = $this->db->select('create_date as login_date')->from($this->table_history)->where('lead_id',$row->id)->order_by('id','desc')->limit(1,0)->get();					
			if($queryLastSeen->num_rows()>0){
				$dataLastSeen = $queryLastSeen->first_row();
				$row->lead_last_seen = $dataLastSeen->login_date;
			}
			/*End Lead Last seen*/
			/*Person 1*/
			if(!empty($row->person_title_1)){
				$personOneData = $this->db->select('c.first_name,c.last_name,c.job_title')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_1)->get()->row();
				if(count($personOneData)>0){
					$row->person_name_1 = $personOneData->first_name.' '.$personOneData->last_name.', '.$personOneData->job_title;
				} else {
					$row->person_name_1 ='';
					$row->person_title_1 = '';
				}
			}
			/*End Person 1*/
			/*Person 2*/
			if(!empty($row->person_title_2)){
				$personSecondData = $this->db->select('c.first_name,c.last_name,c.job_title')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_2)->get()->row();
				if(count($personSecondData)>0){
					$row->person_name_2 = $personSecondData->first_name.' '.$personSecondData->last_name.', '.$personSecondData->job_title;
				} else {
					$row->person_name_2 ='';
					$row->person_title_2 = '';
				}
			}
			/*End Person 2*/
			/*Calculation Attractive*/
			$row->attractive = 0;
			$queryAttractive = $this->db->select('sum(attractive) as attractive,count(id) as counter')->from($this->table_comment)->where('parent_id',$row->id)->get();
			if($queryAttractive->num_rows()>0){
				$attractiveData = $queryAttractive->first_row();
				if($attractiveData->counter>0 && $attractiveData->attractive>0){
					$row->attractive = $attractiveData->attractive/$attractiveData->counter;
				}
			}
			/**/
			/*$boxQuery = $this->db->select("*")->from($this->table_box)->where('lead_id',$row->id)->order_by('lead_id','DESC')->get();
			$boxData =array();
			if(count($boxQuery->num_rows())>0){
				foreach($boxQuery->result() as $box){
					$boxData[] = $box;
				}
			}
			$row->box_list = $boxData;*/
			$getEouData = $this->findEOULeadMaterial($row->serial_number);
			$evidence = 0;
			if(count($getEouData)>0){
				$eouData = $getEouData->other_field;
				if(is_string($eouData)){
					$jsonDecodeEou = json_decode($eouData);							
					if(isset($jsonDecodeEou->another_license) && $jsonDecodeEou->another_license!='' && count($jsonDecodeEou->another_license)>0){
						foreach($jsonDecodeEou->another_license as $licenseEvidence){
							if($licenseEvidence->evidence=="Yes"){
								$evidence = $evidence+1;
							}
						}
					}
				}
			}
			$row->eou = $evidence;
			$row->column8B = $row->column9B = $row->column10B = $row->column11B = $row->column12B = $row->column13B = $row->column14B = $row->column15B = $row->column25B = $row->column26B = $row->column27B = $row->column28B = $row->column29B = $row->column30B = $row->column31B = $row->column32B = $row->column33B = $row->column34B = $row->column35B = "";
			$blinkButtonStatus = $this->db->select('b.lead_columns as lead_column')->from($this->table_lead_buttons.' as lb')->join($this->table_buttons.' as b','b.id = lb.button_id')->where_in('b.lead_columns',array('column8','column9','column10','column11','column12','column13','column14','column15','column25','column26','column27','column28','column29','column30','column31','column32','column33','column34','column35'))->where('lb.lead_id',$row->id)->where('b.blink',1)->where('lb.status',1)->get();
			/*echo $this->db->last_query();*/
			if($blinkButtonStatus->num_rows()>0){
				foreach($blinkButtonStatus->result() as $buttonRow){
					switch($buttonRow->lead_column){						
						case 'column8':
							$row->column8B=1;
						break;
						case 'column9':
							$row->column9B=1;
						break;
						case 'column10':
							$row->column10B=1;
						break;
						case 'column11':
							$row->column11B=1;
						break;
						case 'column12':
							$row->column12B=1;
						break;
						case 'column13':
							$row->column13B=1;
						break;
						case 'column14':
							$row->column14B=1;
						break;
						case 'column15':
							$row->column15B=1;
						break;
						case 'column26':
							$row->column26B=1;
						break;
						case 'column27':
							$row->column27B=1;
						break;
						case 'column28':
							$row->column28B=1;
						break;
						case 'column29':
							$row->column29B=1;
						break;
						case 'column30':
							$row->column30B=1;
						break;
						case 'column31':
							$row->column31B=1;
						break;
						case 'column32':
							$row->column32B=1;
						break;
						case 'column33':
							$row->column33B=1;
						break;
						case 'column34':
							$row->column34B=1;
						break;
						case 'column35':
							$row->column35B=1;
						break;
					}
				}
			}
			$row->column16 = $row->column17 = $row->column18 = $row->column19 = $row->column20 = $row->column21 = $row->column22 = $row->column23 = $row->column24 = 0;
			$allArray = array();
			$allArray['acquisitions'] = $this->getAcquisitionData($row->id,'a.store_name,a.order_name,a.category,a.regular_license_starts,a.late_license_starts,a.active_button,a.docket_status,a.image_left,a.image_middle,a.image_right,a.image_four,a.image_five,a.image_six,a.image_seven,a.image_eight,a.image_nine,a.image_ten,a.image_eleven,a.image_twelve');
			if(count($allArray['acquisitions'])>0){
				/*IntroImages*/
				$imageComplete = 0;
				if(!empty($imagesResult->image_left) && $imagesResult->image_left!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_middle) && $imagesResult->image_middle!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_right) && $imagesResult->image_right!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_four) && $imagesResult->image_four!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_five) && $imagesResult->image_five!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_six) && $imagesResult->image_six!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_seven) && $imagesResult->image_seven!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_eight) && $imagesResult->image_eight!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_nine) && $imagesResult->image_nine!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_ten) && $imagesResult->image_ten!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_eleven) && $imagesResult->image_eleven!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_twelve) && $imagesResult->image_twelve!=null){
					$imageComplete++;
				}
				/*End*/
				$row->column23 = $imageComplete;
				$getLeadPatentList = $this->getLeadPatentList($row->id);
				if(count($getLeadPatentList)>0){
					$patentsList = array();
					foreach($getLeadPatentList as $p){
						$patentsList[] = $p->patent;
					}
					if(count($patentsList)>0){
						/*Number of LegalDD Patent Complete*/
						$row->column16 = $this->db->select("count(id) as legalDDComplete")->from($this->table_due_dilligence_legal)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->legalDDComplete;
						/*End*/
						/*Number of Illustration Patent Complete*/
						$row->column17 = $this->db->select("count(id) as illustrationComplete")->from($this->table_due_dilligence_illustrations)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->illustrationComplete;
						/*End*/
						/*Number of TechDD Patent Complete*/
						$row->column18 = $this->db->select("count(id) as techDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('tech_status',1)->get()->row()->techDDComplete;	
						/*End*/
						/*Number of Market Patent Complete*/
						$row->column19 = $this->db->select("count(id) as marketDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('market_status',1)->get()->row()->marketDDComplete;	
						/*End*/
						/*Number of PDFs Patent Complete*/
						$row->column20 = $this->db->select("count(id) as pdfDDComplete")->from($this->table_due_dilligence_pdf)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->pdfDDComplete;
						/*End*/
					}
				}
				$getLicenseResult = $this->db->select('id as licenseID')->from($this->table_licenses)->where('serial_number',$row->serial_number)->get();
				if($getLicenseResult->num_rows()>0){
					$getLicenseData = $getLicenseResult->first_row();
					/*Number of Comparables Agreement*/
					$row->column21 = $this->db->select("count(id) as comparablesComplete")->from($this->table_comparables)->where('license_id',$getLicenseData->licenseID)->get()->row()->comparablesComplete;
					/*End*/
				}
				/*Check For Royalty report and Intro DD*/
				$royalty = $this->db->select('count(id) as royaltyReport,status')->from($this->table_lead_open_project)->where('type',5)->order_by('id','DESC')->limit(1,0)->get()->row();
				if(isset($royalty->status) && $royalty->status==1){
					$row->column22=1;
				}
				$intro = $this->db->select('count(id) as intro,status')->from($this->table_lead_open_project)->where('type',8)->order_by('id','DESC')->limit(1,0)->get()->row();
				if(isset($intro->status) && $intro->status==1){
					$row->column24=1;
				}
			}
			$data[] = $row;
		}
		return $data;
	}
	
	
	public function findLeadByFilter($filterSearch,$userType,$userID,$start,$noOfRecords=35,$orderByField,$orderBy){
		$searchFromDifferentTable = false;
		$searchBlinkColumn = false;
		$differentTableSearch = array('attractive','lead_last_seen','eou','broker_contact','person_name_1','person_name_2');
		$leadBlinkColumns = array("column8,column9,column10,column11,column12,column13,column14,column15,column25,column26,column27,column28,column29,column30,column31,column32,column33,column34,column35");
		$findFromAnotherTable = array("blink","not_blink");
		foreach($filterSearch as $key=>$value){
			if(in_array($key,$differentTableSearch)){				
				$searchFromDifferentTable = true;
				break;
			}
		}
		foreach($filterSearch as $key=>$value){
			if(in_array($key,$leadBlinkColumns)){				
				$searchBlinkColumn = true;
				break;
			}
		}
		$data = array();
		if($searchBlinkColumn===true){
			/*Search Blink or not blink*/
			$searchValue = false;
			$excludeFromSearch = array();
			foreach($filterSearch as $key=>$value){	
				if(count($value)>0){
					$i=0;
					foreach($value as $val){
						if(in_array($val,$findFromAnotherTable)){
							if($i==0){
								$excludeFromSearch[] = $key;
							}
							if($searchValue===false){
								$searchValue = true;
							}
						}
						$i++;
					}
				}
			}
			$searchWithInThisLead = array();
			$queryLeads = "";			
			if($searchValue===true){
				if(count($excludeFromSearch)>0){
					$whereCondition = "";
					$allColumns = "";
					foreach($excludeFromSearch as $val){
						$allColumns .='"'.addslashes($val).'", ';
					}	
					$status = array();
					foreach($excludeFromSearch as $val){
						if(isset($filterSearch[$val])){
							$filterValues = $filterSearch[$val];
							if(count($filterValues)>0){
								foreach($filterValues as $filVal){
									if($filVal=="blink" && !in_array(1,$status)){
										$status[] = 1;
									}
									if($filVal=="not_blink" && !in_array(2,$status)){
										$status[] = 2;
									}
								}
							}
						}
					}
					if($userType!=9 && $userType!=8){
						$checkUserAssignLead = $this->checkUserLeads($userID);
						$checkUserAssignLeadType = $this->checkUserAssignLeadType($userID);
						if(count($checkUserAssignLead)>0 && count($checkUserAssignLeadType)>0){
							$leadType = implode('","', $checkUserAssignLeadType);
							$leadAssigned = implode(',', $checkUserAssignLead);
							$queryLeads = $this->db->select('distinct(lb.lead_id) as leadID')
											->from($this->table_lead_buttons.' as lb')
											->join($this->table_buttons.' as b','b.id = lb.button_id')
											->where("l.type IN (".$leadType.")")
											->or_where("l.id IN (".$leadAssigned.")")
											->where_in('b.lead_columns',$allColumns)
											->where('lb.blink',1)
											->where_in('lb.status',$status)
											->get();
						} else if(count($checkUserAssignLead)>0){
							$leadAssigned = implode(',', $checkUserAssignLead);
							$queryLeads = $this->db->select('distinct(lb.lead_id) as leadID')->from($this->$table_lead_buttons.' as lb')->join($this->table_buttons.' as b','b.id = lb.button_id')->where("l.id IN (".$leadAssigned.")")->where_in('b.lead_columns',$allColumns)->where('lb.blink',1)->where_in('lb.status',$status)->get();
						} else if(count($checkUserAssignLeadType)>0){
							$leadType = implode('","', $checkUserAssignLeadType);
							$queryLeads = $this->db->select('distinct(lb.lead_id) as leadID')->from($this->table_lead_buttons.' as lb')->join($this->table_buttons.' as b','b.id = lb.button_id')->where("l.type IN (".$leadType.")")->where_in('b.lead_columns',$allColumns)->where('lb.blink',1)->where_in('lb.status',$status)->get();
						}						
					} else {
						$queryLeads = $this->db->select('distinct(lb.lead_id) as leadID')->from($this->table_lead_buttons.' as lb')->join($this->table_buttons.' as b','b.id = lb.button_id')->where_in('b.lead_columns',$allColumns)->where('lb.blink',1)->where_in('lb.status',$status)->get();
					}					
				}
			} else {
				$whereCondition = "";
				foreach($excludeFromSearch as $val){
					$conditionValue = "";
					if(isset($filterSearch[$val])){
						$filterValues = $filterSearch[$val];
						if(count($filterValues)>0){
							foreach($filterValues as $filVal){
								if($filVal=="empty"){
									$conditionValue = "0000-00-00 00:00:00";
								}else if($filVal=="all"){
									$conditionValue = "fill";
								}
							}
						}
					}
					if($conditionValue=="fill"){
						$whereCondition .= $val."!='' AND ";
					} else {
						$whereCondition .= $val."!='".$conditionValue."' AND ";
					}
				}
				$whereCondition = substr($whereCondition,0,-4);
				if(!empty($whereCondition)){
					if($userType!=9 && $userType!=8){
						$checkUserAssignLead = $this->checkUserLeads($userID);
						$checkUserAssignLeadType = $this->checkUserAssignLeadType($userID);
						if(count($checkUserAssignLead)>0 && count($checkUserAssignLeadType)>0){
							$leadType = implode('","', $checkUserAssignLeadType);
							$leadAssigned = implode(',', $checkUserAssignLead);
							$queryLeads = $this->db->select('id')->from($this->table_lead)->where("l.type IN (".$leadType.")")->or_where("l.id IN (".$leadAssigned.")")->where($whereCondition)->get();
						} else if(count($checkUserAssignLead)>0){
							$leadAssigned = implode(',', $checkUserAssignLead);
							$queryLeads = $this->db->select('id')->from($this->table_lead)->where("l.id IN (".$leadAssigned.")")->where($whereCondition)->get();
						} else if(count($checkUserAssignLeadType)>0){
							$leadType = implode('","', $checkUserAssignLeadType);
							$queryLeads = $this->db->select('id')->from($this->table_lead)->where("l.type IN (".$leadType.")")->where($whereCondition)->get();
						}
					} else {
						$queryLeads = $this->db->select('id')->from($this->table_lead)->where($whereCondition)->get();
					}					
				}
			}
			if(is_object($queryLeads) && $queryLeads->num_rows()>0){
				foreach($queryLeads->result() as $row){
					$searchWithInThisLead[] = $row->leadID;
				}
			}
			if(count($searchWithInThisLead)>0){
				$searchWithInThisLead = array_unique($searchWithInThisLead);
				/*if($noOfRecords>0){
					$this->db->limit($noOfRecords,$start);
				}*/
				$searchingCondition = "";
				foreach($filterSearch as $key=>$value){	
					if(!in_array($key,$excludeFromSearch)){
						$searchVal = "";
						if(count($value)>0){					
							foreach($value as $val){
								$searchVal .='"'.addslashes($val).'", ';
							}
							$searchVal = substr($searchVal,0,-2);
						}
						if(!empty($searchVal)){
							$searchingCondition .= "l.".$key." IN (".$searchVal.") AND ";
						}
					}					
				}
				if(!empty($searchingCondition)){
					$searchingCondition = substr($searchingCondition,0,-4);
				}				
				$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where_in('l.id',$searchWithInThisLead)->where($searchingCondition)->order_by($orderByField,$orderBy)->get();
				if(is_object($query) && $query->num_rows()>0){
					$data = $this->resultsCombineWithOtherData($query->result());
				}
			}
		} else if($searchFromDifferentTable === false){
			$searchingCondition = "";
			foreach($filterSearch as $key=>$value){				
				$searchVal = "";
				if(count($value)>0){					
					foreach($value as $val){
						$searchVal .='"'.addslashes($val).'", ';
					}
					$searchVal = substr($searchVal,0,-2);
				}
				if(!empty($searchVal)){
					$searchingCondition .= "l.".$key." IN (".$searchVal.") AND ";
				}
			}
			if(!empty($searchingCondition)){
				$searchingCondition = substr($searchingCondition,0,-4);
			}
			/*echo $searchingCondition;*/			
			/*if($noOfRecords>0){
				$this->db->limit($noOfRecords,$start);
			}*/
			$query = "";
			if($userType!=9 && $userType!=8){
				$checkUserAssignLead = $this->checkUserLeads($userID);
				$checkUserAssignLeadType = $this->checkUserAssignLeadType($userID);
				if(count($checkUserAssignLead)>0 && count($checkUserAssignLeadType)>0){
					$leadType = implode('","', $checkUserAssignLeadType);
					$leadAssigned = implode(',', $checkUserAssignLead);
					$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->or_where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->where($searchingCondition)->order_by($orderByField,$orderBy)->get();
				} else if(count($checkUserAssignLead)>0){
					$leadAssigned = implode(',', $checkUserAssignLead);
					$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->where($searchingCondition)->order_by($orderByField,$orderBy)->get();
				} else if(count($checkUserAssignLeadType)>0){
					$leadType = implode('","', $checkUserAssignLeadType);
					$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->where($searchingCondition)->order_by($orderByField,$orderBy)->get();
				}							
			} else {
				$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where($searchingCondition)->order_by($orderByField,$orderBy)->get();
			}
			/*echo $this->db->last_query();*/
			if(is_object($query) && $query->num_rows()>0){
				$data = $this->resultsCombineWithOtherData($query->result());
			}
		} else {
			$assignedLeads = array();
			$leadQuery  = "";
			if($userType!=9 && $userType!=8){
				$checkUserAssignLead = $this->checkUserLeads($userID);
				$checkUserAssignLeadType = $this->checkUserAssignLeadType($userID);
				if(count($checkUserAssignLead)>0 && count($checkUserAssignLeadType)>0){
					$leadType = implode('","', $checkUserAssignLeadType);
					$leadAssigned = implode(',', $checkUserAssignLead);
					$leadQuery = $this->db->select('l.id as leadID')->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->or_where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by($orderByField,$orderBy)->get();
				} else if(count($checkUserAssignLead)>0){
					$leadAssigned = implode(',', $checkUserAssignLead);
					$leadQuery  = $this->db->select('l.id as leadID')->from($this->table_lead.' as l')->where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by($orderByField,$orderBy)->get();
				} else if(count($checkUserAssignLeadType)>0){
					$leadType = implode('","', $checkUserAssignLeadType);
					$query = $this->db->select('l.id as leadID')->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by($orderByField,$orderBy)->get();
				}							
			} else {
				$leadQuery  = $this->db->select('l.id as leadID')->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->order_by($orderByField,$orderBy)->get();
			}
			if(is_object($leadQuery) && $leadQuery->num_rows()>0){
				foreach ($leadQuery->result() as $row) {
					$assignedLeads[] = $row->leadID;
				}
			}		
			if(count($assignedLeads)>0){
				$allLeads = array();
				foreach($filterSearch as $key=>$value){	
					switch($key){
						case 'attractive':
							$queryAttractive = $this->db->select('sum(attractive) as attractive,count(id) as counter, parent_id as leadID')->from($this->table_comment)->where_in('parent_id',$assignedLeads)->get();
							if($queryAttractive->num_rows()>0){
								foreach ($queryAttractive->result() as $attractiveData) {
									if($attractiveData->counter>0 && $attractiveData->attractive>0){
										$attractive = $attractiveData->attractive/$attractiveData->counter;
										if(in_array($attractive,$value)){
											array_push($allLeads,$attractiveData->leadID);
										}
									}
								}							
							}
						break;
						case 'lead_last_seen':
							$dates = "";
							foreach($value as $val){
								$dates .='"'.addslashes($val).'", ';
							}
							$dates = substr($dates,0,-2);
							$queryLastSeen = $this->db->select('DISTINCT(lead_id) as leadID')->from($this->table_history)->where_in('lead_id',$assignedLeads)->where('date_format(create_date,"%m/%d/%y") IN ('.$dates.')')->order_by('id','desc')->get();					
							if($queryLastSeen->num_rows()>0){
								foreach ($queryLastSeen->result() as $getLeadLastSeen) {
									array_push($allLeads,$getLeadLastSeen->leadID);
								}
							}
						break;
						case 'eou':
							$query = $this->db->select('p.other_field,l.id as leadID')->from('wp_popup_data as p')->join($this->table_lead .' as l','l.serial_number = p.serial_number')->where_in('l.id',$assignedLeads)->get();
							$data = array();
							if($query->num_rows()>0){
								foreach ($leadQuery->result() as $getEouData) {
									$evidence = 0;
									if(count($getEouData)>0){
										$eouData = $getEouData->other_field;
										if(is_string($eouData)){
											try{
												$jsonDecodeEou = json_decode($eouData);
												if(isset($jsonDecodeEou->another_license) && $jsonDecodeEou->another_license!='' && count($jsonDecodeEou->another_license)>0){
													foreach($jsonDecodeEou->another_license as $licenseEvidence){
														if($licenseEvidence->evidence=="Yes"){
															$evidence = $evidence+1;
														}
													}
												}
											}catch(Exception $e){
												
											}											
										}
									}
									if(in_array($evidence,$value)){
										array_push($allLeads,$getEouData->leadID);
									}
								}
							}
						break;
						case 'broker_contact':
							$brokerQuery = $this->db->select('DISTINCT(l.id) as leadID')->from($this->table_lead.' as l')->where_in('l.broker_person',$value)->where_in('l.id',$value)->get();
							if($brokerQuery->num_rows()>0){
								foreach ($brokerQuery->result() as $getBrokerData) {
									array_push($allLeads,$getBrokerData->leadID);
								}
							}
						break;
						case 'person_name_1':
							$person1Query = $this->db->select('DISTINCT(l.id) as leadID')->from($this->table_lead.' as l')->where_in('l.person_name_1',$value)->where_in('l.id',$value)->get();
							if($person1Query->num_rows()>0){
								foreach ($person1Query->result() as $getPersonData) {
									array_push($allLeads,$getPersonData->leadID);
								}
							}
						break;
						case 'person_name_2':
							$person2Query = $this->db->select('DISTINCT(l.id) as leadID')->from($this->table_lead.' as l')->where_in('l.person_name_2',$value)->where_in('l.id',$value)->get();
							if($person2Query->num_rows()>0){
								foreach ($person2Query->result() as $getPersonData) {
									array_push($allLeads,$getPersonData->leadID);
								}
							}
						break;
					}
				}
				if(count($allLeads)>0){
					$allLeads = array_unique($allLeads);
					/*if($noOfRecords>0){
						$this->db->limit($noOfRecords,$start);
					}		*/			
					$searchingCondition = "";
					foreach($filterSearch as $key=>$value){	
						if(!in_array($key,$differentTableSearch)){
							$searchVal = "";
							if(count($value)>0){					
								foreach($value as $val){
									$searchVal .='"'.addslashes($val).'", ';
								}
								$searchVal = substr($searchVal,0,-2);
							}
							if(!empty($searchVal)){
								$searchingCondition .= "l.".$key." IN (".$searchVal.") AND ";
							}
						}
					}
					if(!empty($searchingCondition)){
						$searchingCondition = substr($searchingCondition,0,-4);
					}
					if(empty($searchingCondition)){
						$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where_in('l.id',$allLeads)->order_by($orderByField,$orderBy)->get();
					} else {
						$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where_in('l.id',$allLeads)->where($searchingCondition)->order_by($orderByField,$orderBy)->get();
					}
					if(is_object($query) && $query->num_rows()>0){
						$data = $this->resultsCombineWithOtherData($query->result());
					}
				}			
			}			
		}
		return $data;
	}
	
	public function findIncompleteANDCompleteListAccUser($userID,$start=0,$page=0,$orderByField="l.update_date",$orderBy="DESC"){
		//$query = $this->db->select('*')->from($this->table_lead)->where('type',$type)->get();
        /*$query = $this->db->select('l.*')->from($this->table_lead.' as l')->join($this->table_assign_lead .' as al','al.lead_id = l.id')->where('al.pd_id',$userID)->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->get();*/
		$checkUserAssignLead = $this->checkUserLeads($userID);
		$checkUserAssignLeadType = $this->checkUserAssignLeadType($userID);
		$data = array();
        /*$query = $this->db->select('l.*')->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by('l.lead_name ASC')->get();
		*/
		$query = "";
		
		/*if($page>0){
			$this->db->limit($page,$start);
		}*/
		if(count($checkUserAssignLead)>0 && count($checkUserAssignLeadType)>0){
			$leadType = implode('","', $checkUserAssignLeadType);
			$leadAssigned = implode(',', $checkUserAssignLead);
			$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->or_where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by($orderByField,$orderBy)->get();
		} else if(count($checkUserAssignLead)>0){
			$leadAssigned = implode(',', $checkUserAssignLead);
			$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.id IN (".$leadAssigned.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by($orderByField,$orderBy)->get();
		} else if(count($checkUserAssignLeadType)>0){
			$leadType = implode('","', $checkUserAssignLeadType);
			$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where("l.type IN (".$leadType.")")->where("l.status IN ('0','1','2')")->where('l.type <> "INT"')->order_by($orderByField,$orderBy)->get();
		}
		if(is_object($query) && $query->num_rows()>0){
			$data = $this->resultsCombineWithOtherData($query->result());
		}
		return $data;
	}
	
	public function from_count_incomplete_litigation($type,$complete){
		$query = $this->db->select('count(*) as leadCount')->from($this->table_lead)->where('complete',$complete)->where('type',$type)->where('status','0')->get();
		$data = array();
		if($query->num_rows()>0){
			$data =$query->first_row();
		}
		return $data;
	}
	
	public function checkLitigationScrapeURL($leadID,$url){
		$query = $this->db->select('*')->from($this->table_scrapper_litigation_scrape)->where('url',$url)->where('lead_id',$leadID)->get();
		$data = array();
		if($query->num_rows()>0){
			$data =$query->result();
		}
		return $data;
	}
	
	public function record_count($type,$complete=1) {
		$this->db->where('type',$type);
		$this->db->where('status','0');
		$this->db->where('complete',$complete);
        return $this->db->count_all_results($this->table_lead);
    }
	
	function findBoxList($leadID,$type=0){
		$boxQuery = $this->db->select("*")->from($this->table_box)->where('lead_id',$leadID)->where('type',$type)->order_by('date_received','DESC')->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxList[] = $box;
			}
		}
		return $boxList;
	}
	
	function findEmailsInLeadBulk($messageIDs){
		$boxQuery = $this->db->select("l.id as leadID, l.lead_name,b.id,b.message_id,b.thread_id")->from($this->table_box.' as b')->join($this->table_lead.' as l','l.id = b.lead_id','INNER')->where_in('b.message_id',$messageIDs)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$foundEmail = $this->db->select("count(*) as countR")->from($this->table_acquisition_activity)->where('email_id',$box->id)->get()->row()->countR;
				$activity = 0;
				if($foundEmail == null || $foundEmail == 0){
					$foundEmail = $this->db->select("count(*) as countR")->from($this->table_sales_activity)->where('email_id',$box->id)->get()->row()->countR;
					if($foundEmail > 0){
						$activity = 1;
					}
				} else if($foundEmail > 0){
					$activity = 2;
				}
				$box->activity = $activity;
				$boxList[] = $box;
			}
		}
		return $boxList;
	}
	
	function findBoxByThread($threadID){
		$boxQuery = $this->db->select("*")->from($this->table_box)->where('thread_id',$threadID)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxList[] = $box;
			}
		}
		return $boxList;
	}
	
	function findBoxByMessageID($messsageID){
		$boxQuery = $this->db->select("*")->from($this->table_box)->where('message_id',$messsageID)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxList[] = $box;
			}
		}
		return $boxList;
	}
	
	function findBoxNewById($threadID){
		$boxQuery = $this->db->select("*")->from($this->table_box)->where('id',$threadID)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			$boxList[] = $boxQuery->first_row();			
		}
		return $boxList;
	}
	
	function findAllBoxList(){
		$boxQuery = $this->db->select("*")->from($this->table_box)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxList[] = $box;
			}
		}
		
		return $boxList;
	}
	function findAllBoxThreadList(){
		$boxQuery = $this->db->select("thread_id")->from($this->table_box)->get();
		$boxList =array();
		if(count($boxQuery->num_rows())>0){
			foreach($boxQuery->result() as $box){
				$boxList[] = $box;
			}
		}
		
		return $boxList;
	}
	
	
	public function checkUserCreatedLeadFromLitigation(){
		$userID = $this->session->userdata['id'];
		$start = (date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
		$finish = (date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d');
		$query = $this->db->select('count(*) as leads')->from($this->table_lead)->where('type','Litigation')->where('date_format(create_date,"%Y-%m-%d")>=',$start)->where('date_format(create_date,"%Y-%m-%d")<=',$finish)->where('user_id',$userID)->get();
		return $query->row();
		
	}
	public function findAllLitigationWithPaging($type,$limit,$start,$complete=1){
		$this->db->limit($limit, $start);
		$this->db->order_by('id','DESC');		
		$query = $this->db->select('l.*,u.name as userName')->from($this->table_lead.' as l')->join('users as u','u.id=l.user_id','left outer')->where('l.type',$type)->where('l.status','0')->where('complete',$complete)->order_by('l.id','DESC')->get();

	
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $allArray = array();
				$allArray['litigation'] = $row;
				$allArray['comment'] = $this->getLitigationComments($row->id,$type);
				$data[] = $allArray;
            }            
        }
		
		return $data;
	}
	
	function getActiveLeads($select){
		$query = $this->db->select($select)->from($this->table_lead.' as l')->where_in('l.status',array('0','1','2'))->order_by('l.lead_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$family = $this->db->select("count(patent_number) as family")->from($this->table_lead_patent)->where('lead_id',$row->id)->get()->row()->family;
				$row->family = $family;
				$data[] = $row;
			}
		}
		return $data;
	}
	
    public function findOneLitigationWithPaging($lead_id,$type){
		$query = $this->db->select('l.*,u.name as userName')->from($this->table_lead.' as l')->join('users as u','u.id=l.user_id','left outer')->where('l.type',$type)->where('l.status','0')->where('l.id',$lead_id)->order_by('l.id','DESC')->get();
       
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $allArray = array();
				$allArray['litigation'] = $row;
				$allArray['comment'] = $this->getLitigationComments($row->id,$type);
				$data[] = $allArray;
            }            
        }
		
		return $data;
	}
	
	public function findAllLeadBySerialNumberBySearch($serialNumber){
		$query = $this->db->select('l.lead_name as label, l.serial_number as value')->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where('l.serial_number LIKE "%'.$serialNumber.'%"')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();       
        }		
		return $data;
	}
	
	public function findAllLeadByLeadNameBySearch($leadName){
		$query = $this->db->select('l.lead_name as label, l.serial_number as value, l.id as id')->from($this->table_lead.' as l')->where("l.status IN ('0','1','2')")->where('l.lead_name LIKE "%'.$leadName.'%"')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();                
        }		
		return $data;
	}
		
	public function getSalesActivityLead($lead_id){
		$data = array();
		$data['sales_activity'] = $this->getSalesActivity($lead_id);
		$data['presales_activity'] = $this->getPreSalesActivity($lead_id);
		$data['broker_as_companies'] = $this->findLeadCompanyBrokerDetails($lead_id);
		$data['pre_broker_as_companies'] = $this->findLeadCompanyBrokerDetails($lead_id);
		return $data;
	}
	
	function getLeadSerialNumber($leadID){
		return $this->db->select('l.serial_number')->from($this->table_lead.' as l')->where('l.id',$leadID)->get()->row()->serial_number;
	}
	
	function getCompanyList($search,$select){
		$data = array();
		if(trim($search)!=""){
			$query = $this->db->select($select)->from($this->table_company.' as c')->where('c.company_name LIKE "%'.$search.'%"')->order_by('c.company_name','ASC')->get();
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}
			}
		}		
		return $data;
	}
	
	function getOpenProjectList($leadID){
		$query = $this->db->select("op.*, CONCAT((c.first_name),(' '),(c.last_name)) as personName,co.company_name")->from($this->table_lead_open_project.' as op')->join($this->table_contacts.' as c','c.id = op.contact_id','LEFT')->join($this->table_company.' as co','co.id = c.company_id','LEFT')->where('op.lead_id',$leadID)->order_by('op.id','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	public function findContactsWithAllTelephoneinCampaignList($IDs,$campaignID){
		$query = $this->db->select("distinct(c.id),c.first_name,c.last_name,c.gender,c.company_id,co.company_name,co.company_name_alias,c.linkedin_image,c.job_title,c.current_company,c.phone,c.telephone,co.telephone as companyphone,cl.id as campaign_list_id")->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id','LEFT')->join($this->table_campaign_list.' as cl','cl.contact_id = c.id')->where_in('c.id',$IDs)->where('campaign_id',$campaignID)->where("(c.phone <> '' OR c.telephone <> '' OR co.telephone <> '')")->order_by('co.company_name ASC')->order_by('co.company_name_alias ASC')->get();
		/*echo $this->db->last_query();*/
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	public function findContactsWithAllLinkedinCampaignList($IDs,$campaignID){
		$query = $this->db->select("distinct(c.id),c.first_name,c.last_name,c.gender,c.company_id,co.company_name,co.company_name_alias,c.linkedin_image,c.job_title,c.current_company,c.linkedin_url,cl.id as campaign_list_id")->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id','LEFT')->join($this->table_campaign_list.' as cl','cl.contact_id = c.id')->where_in('c.id',$IDs)->where('c.linkedin_url <>','')->where('campaign_id',$campaignID)->order_by('co.company_name ASC')->order_by('co.company_name_alias ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	public function getCampaignDataByListID($listID){
		$query = $this->db->select("distinct(c.id),c.first_name,c.last_name,c.gender,c.company_id,co.company_name,co.company_name_alias,ca.body,ca.lead_id,ca.activity_type")->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id','LEFT')->join($this->table_campaign_list.' as cl','cl.contact_id = c.id')->join($this->table_campaign.' as ca','ca.id = cl.campaign_id')->where('cl.id',$listID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->first_row();
        }
		return $data;
	}
	
	public function findContactsWithAllEmails($emails){
		$query = $this->db->select("c.id,c.email,c.secondary_email,c.tertiary_email,c.first_name,c.last_name,c.gender,c.company_id,co.company_name,c.linkedin_image,c.job_title,c.current_company,co.company_name_alias")->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id','LEFT')->where_in('c.email',$emails)->or_where_in('c.secondary_email',$emails)->or_where_in('c.tertiary_email',$emails)->order_by('co.company_name ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	public function checkUserDataWithIDAndEmail($userID,$userEmail){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name")->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where('c.id',$userID)->where('c.email',$userEmail)->or_where('c.secondary_email',$userEmail)->or_where('c.tertiary_email',$userEmail)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->first_row();
        } 
		return $data;
	}
	
	public function getAllLeadWithoutSellerID(){
		$query = $this->db->select('id,folder_id')->from($this->table_lead.' as l')->where_in('l.status',array(0,1,2))->where('seller_material_folder_id','')->order_by('l.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data[] = $row;
			}
		}
		return $data;
	}
	
	function findLeadTableData($lead_id){
		$query = $this->db->select($this->select)->from($this->table_lead.' as l')->where('l.id',$lead_id)->order_by('l.id','DESC')->get();		
		$data = array();
		if ($query->num_rows() > 0) {
			$resultedData = $this->resultsCombineWithOtherData($query->result());
            $allArray['litigation'] = $resultedData[0];				             
			$data[] = $allArray; 
        }		
		return $data;
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
	
	public function findOneLitigationWithIncomplete1($lead_id,$type){
		$select = 'l.id,l.serial_number,file_url,l.lead_name ,l.spreadsheet_id  ,l.worksheet_id ,l.worksheet_name ,l.type ,l.patent_data ,l.create_date,l.seller_contact_id ,l.seller_info ,l.seller_info_text ,l.seller_like ,l.funding_trnsfr ,l.claim_illus ,l.claim_status_dd ,l.technical_dd ,l.technical_status_dd ,l.legal_dd  ,l.legal_status_dd ,l.create_patent_list  ,l.create_patent_list_text ,l.complete ,l.forward_to_review_text  ,l.nda_term_sheet  ,l.nda_term_sheet_text ,l.status ,l.synpat_like ,l.ppa_id ,l.ppa_text_date ,l.execute_ppa ,l.ppa_execute ,l.ppa_date ,l.plantiffs_name ,l.no_of_prospects ,l.upfront_price ,l.prospects_name ,l.technologies ,l.no_of_us_patents ,l.no_of_non_us_patents ,l.send_proposal_letter ,l.market_data ,l.seller_contact ,l.broker_contact ,l.option_expiration_date ,l.broker,l.broker_person ,l.broker_person_contact ,l.person_name_1 ,l.person_title_1 ,l.person_name_2 ,l.person_title_2 ,l.address ,l.relates_to ,l.expected_price ,l.update_date ,l.next_action ,l.case_name ,l.litigation_stage ,l.market_industry ,l.case_type ,l.case_number ,l.cause no_of_patent ,l.filling_date ,l.active_defendants ,l.lead_attorney ,l.scrapper_data ,l.original_defendants ,l.court ,l.link_to_pacer ,l.link_to_rpx ,l.defendants ,l.court_docket_entries,l.folder_id,l.column8,l.column9,l.column10,l.column11,l.column12,l.column13,l.column14,l.column15,l.column25,l.column26,l.column27,l.column28,l.column29,l.column30,l.column31,l.column32,l.column33,l.column34,l.column35';
		$query = $this->db->select($select)->from($this->table_lead.' as l')->where('l.id',$lead_id)->order_by('l.id','DESC')->get();
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $allArray = array();
                /**/
                /*Broker Name*/
					if(!empty($row->broker_person)){
						$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker_person)->get()->row();
						if(count($brokderData)>0){
							$row->broker_contact = $brokderData->company_name;
							$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
						} else {
							$row->broker_contact ='';
							$row->broker_person_contact = '';
							$row->broker_person = '';
						}
					}
					
					/*End Broker Name*/
					/*Seller Name*/
					if(!empty($row->plantiffs_name)){
						$sellerInfo = $this->db->select('cc.company_name')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
						if(count($sellerInfo)>0){
							$row->seller_contact = $sellerInfo->company_name;
						} else {
							$row->seller_contact = '';
							$row->plantiffs_name = '';
						}
					}
					/*End Seller Name*/

					/*Person 1*/
					if(!empty($row->person_title_1)){
						$personOneData = $this->db->select('c.first_name,c.last_name')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_1)->get()->row();
						if(count($personOneData)>0){
							$row->person_name_1 = $personOneData->first_name.' '.$personOneData->last_name;
						} else {
							$row->person_name_1 ='';
							$row->person_title_1 = '';
						}
					}
					/*End Person 1*/
					/*Person 2*/
					if(!empty($row->person_title_2)){
						$personSecondData = $this->db->select('c.first_name,c.last_name')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_2)->get()->row();
						if(count($personSecondData)>0){
							$row->person_name_2 = $personSecondData->first_name.' '.$personSecondData->last_name;
						} else {
							$row->person_name_2 ='';
							$row->person_title_2 = '';
						}
					}
					/*End Person 2*/
					/*Lead Last seen*/
					$row->lead_last_seen = "0000-00-00";
					$queryLastSeen = $this->db->select('create_date as login_date')->from($this->table_history)->where('lead_id',$row->id)->order_by('id','desc')->limit(1,0)->get();					
					if($queryLastSeen->num_rows()>0){
						$dataLastSeen = $queryLastSeen->first_row();
						$row->lead_last_seen = $dataLastSeen->login_date;
					}
					/*End Lead Last seen*/
					/*Calculation Attractive*/
					$row->attractive = 0;
					$queryAttractive = $this->db->select('sum(attractive) as attractive,count(id) as counter')->from($this->table_comment)->where('parent_id',$row->id)->get();
					if($queryAttractive->num_rows()>0){
						$attractiveData = $queryAttractive->first_row();
						if($attractiveData->counter>0 && $attractiveData->attractive>0){
							$row->attractive = $attractiveData->attractive/$attractiveData->counter;
						}
					}
					/**/
					$getEouData = $this->findEOULeadMaterial($row->serial_number);
					$evidence = 0;
					if(count($getEouData)>0){
						$eouData = $getEouData->other_field;
						if(is_string($eouData)){
							$jsonDecodeEou = json_decode($eouData);							
							if(isset($jsonDecodeEou->another_license) && $jsonDecodeEou->another_license!='' && count($jsonDecodeEou->another_license)>0){
								foreach($jsonDecodeEou->another_license as $licenseEvidence){									
									if($licenseEvidence->evidence=="Yes"){										
										$evidence = $evidence+1;
									}
								}
							}
						}
					}
					$row->eou = $evidence;
                /**/
				$allArray['comment'] = $this->getLitigationComments($row->id,$type);
                /*$allArray['timeLine'] = $this->getAllUserHistory(0,$row->id,0);*/
                $allArray['timeLine'] = array();
                /*$allArray['task'] = $this->getAllTaskFromLead($row->id);
				$allArray['task_i'] = $this->myTaskApproval($row->id);*/
                $allArray['task'] = array();
                $allArray['task_i'] = array();
                $allArray['acquisitions'] = $this->getAcquisitionData($row->id,'a.store_name,a.order_name,a.category,a.regular_license_starts,a.late_license_starts,a.active_button,a.docket_status');
				$allArray['lead_category_list'] = $this->getLeadCategoryList($row->id);
				$illustrationComplete = 0;
				$techDDComplete = 0;
				$marketDDComplete = 0;
				$legalDDComplete = 0;
				$pdfDDComplete = 0;
				$comparablesComplete = 0;
				$invitesComplete = 0;
				$imageComplete = 0;
				$family = 0;
				$assets = 0;
				$jurisd = 0;
				$marketCategoriesString = "";
				$marketCategories= array();
				if(count($allArray['acquisitions'])>0){					
					$getLeadPatentList = $this->getLeadPatentList($row->id);
					if(count($getLeadPatentList)>0){
						$patentsList = array();
						foreach($getLeadPatentList as $p){
							$patentsList[] = $p->patent;
						}
						if(count($patentsList)>0){
							/*Number of Illustration Patent Complete*/
							$illustrationComplete = $this->db->select("count(id) as illustrationComplete")->from($this->table_due_dilligence_illustrations)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->illustrationComplete;							
							/*End*/
							/*Number of TechDD Patent Complete*/
							$techDDComplete = $this->db->select("count(id) as techDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('tech_status',1)->get()->row()->techDDComplete;	
							/*End*/
							/*Number of Market Patent Complete*/
							$marketDDComplete = $this->db->select("count(id) as marketDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('market_status',1)->get()->row()->marketDDComplete;	
							/*End*/
							/*Number of LegalDD Patent Complete*/
							$legalDDComplete = $this->db->select("count(id) as legalDDComplete")->from($this->table_due_dilligence_legal)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->legalDDComplete;
							/*End*/
							/*Number of PDFs Patent Complete*/
							$pdfDDComplete = $this->db->select("count(id) as pdfDDComplete")->from($this->table_due_dilligence_pdf)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->pdfDDComplete;
							/*End*/
						}
					}	
					$family = $this->db->select("count(patent_number) as family")->from($this->table_lead_patent)->where('lead_id',$row->id)->get()->row()->family;
					$getLicenseResult = $this->db->select('id as licenseID')->from($this->table_licenses)->where('serial_number',$row->serial_number)->get();
					$allPatentApplication = $this->findFamilyPatents($row->id);
					/*Lead Family, Assets, Jurisdiction*/
					$chartLeftData = array();
					if(count($allPatentApplication)>0){
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
					}					
					$assets = 0;
					$countCountry = array();
					if(count($chartLeftData)>0){
						foreach($chartLeftData as $chartL){
							$chartL = (object) $chartL;
							if(strtolower(strtoupper($chartL->country))!="wo" && strtolower(strtoupper($chartL->country))!="ep"){
								$assets = $assets + (int)$chartL->applications + (int)$chartL->patents;
								if(!in_array($chartL->country,$countCountry)){
									$countCountry[] = $chartL->country;
								}
							}								
						}
					}
					$jurisd = count($countCountry);
					if($getLicenseResult->num_rows()>0){
						$getLicenseData = $getLicenseResult->first_row();
						/*Number of Comparables Agreement*/
						$comparablesComplete = $this->db->select("count(id) as comparablesComplete")->from($this->table_comparables)->where('license_id',$getLicenseData->licenseID)->get()->row()->comparablesComplete;
						/*End*/
						/*Number of Invitees Patent Complete*/
						$invitesComplete = $this->db->select("count(id) as invitesComplete")->from($this->table_invitees_due)->where('license_id',$getLicenseData->licenseID)->get()->row()->invitesComplete;
						/*End*/
						
						/*Check due dilligence Inventions*/
						$dueInventionsResult = $this->db->select('DISTINCT(di.patent_id), di.related_system_texts')->from($this->table_due_dilligence_inventions.' as di')->join($this->table_due_dilligences.' as d','d.patent_number = di.patent_id','INNER')->join($this->table_licenses.' as l','l.id = d.license_id')->where('d.license_id',$getLicenseData->licenseID)->get();
						if($dueInventionsResult->num_rows()>0){							
							foreach($dueInventionsResult->result() as $dueRows){
								$getInvention = $dueRows->related_system_texts;
								if(!empty($getInvention) && $getInvention!=null){
									try{
										$inventionText = json_decode($getInvention,true);
										if(count($inventionText)>0){
											if(isset($inventionText[0][1]) && $inventionText[0][1]!=null && $inventionText[0][1]!=''){
												foreach($inventionText as $invention){
													if(isset($invention[1]) && $invention[1]!=null && $invention[1]!=''){
														$checkMe = $this->db->select('c.parent')->from($this->table_category.' as c')->where('c.name',$invention[1])->limit(1)->order_by('id','DESC')->get();
														if($checkMe->num_rows()>0){
															$getCategory = $checkMe->first_row();
															if((int)$getCategory->parent == 2){
																$checkParent = $this->db->select('c.name')->from($this->table_category.' as c')->where('c.id',$getCategory->parent)->get();
																if($checkParent->num_rows()>0){
																	$getParentCategory = $checkParent->first_row();
																	if(!in_array($getParentCategory->name,$marketCategories)){
																		$marketCategories[] = $getParentCategory->name;
																	}
																}
															}else {
																if(!in_array($invention[1],$marketCategories)){
																	$marketCategories[] = $invention[1];
																}
															}
														}
													}
												}
											}
										}
									} catch( Exception $e){
										
									}
								}
							}							
						}
						$marketCategoriesString = implode(',',$marketCategories);
						/*End due dilligence Inventions*/
					}
					/*Number of Images*/					
					$imagesResult = $this->getAcquisitionData($row->id,'a.image_left,a.image_middle,a.image_right,a.image_four,a.image_five,a.image_six,a.image_seven,a.image_eight,a.image_nine,a.image_ten,a.image_eleven,a.image_twelve');
					if(!empty($imagesResult->image_left) && $imagesResult->image_left!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_middle) && $imagesResult->image_middle!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_right) && $imagesResult->image_right!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_four) && $imagesResult->image_four!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_five) && $imagesResult->image_five!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_six) && $imagesResult->image_six!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_seven) && $imagesResult->image_seven!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_eight) && $imagesResult->image_eight!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_nine) && $imagesResult->image_nine!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_ten) && $imagesResult->image_ten!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_eleven) && $imagesResult->image_eleven!=null){
						$imageComplete++;
					}
					if(!empty($imagesResult->image_twelve) && $imagesResult->image_twelve!=null){
						$imageComplete++;
					}
					/*End*/
					/*IntroDD complete*/					
					/*End*/					
				}
				$row->family = $family;
				$row->assets = $assets;
				$row->jurisdiction = $jurisd;
				$row->illustrationComplete =$illustrationComplete;
				$row->techDDComplete = $techDDComplete;
				$row->marketDDComplete = $marketDDComplete;
				$row->legalDDComplete = $legalDDComplete;
				$row->pdfDDComplete = $pdfDDComplete;
				$row->comparablesComplete = $comparablesComplete;
				$row->invitesComplete = $invitesComplete;
				$row->imageComplete = $imageComplete;
				$row->marketCategoriesString = $marketCategoriesString;
				$allArray['litigation'] = $row;
                /*$allArray['stage'] = $this->checkStage($row->id);
                $allArray['level'] = $this->checkLevel($row->id);*/
                $allArray['level'] = array();
				$allArray['stage'] = array();
                $allArray['report'] = $this->checkLeadReport($row->id);
                $allArray['open_project'] = $this->getOpenProjectList($row->id);
                $allArray['buttons'] = $this->checkButtonList($row->id);               
				$data[] = $allArray;
            }            
        }
		
		return $data;
	}
	
	function getLeadCategoryList($leadID){
		$queryCategory = $this->db->select('*')->from($this->table_lead_category)->where('lead_id',$leadID)->get();
		$data = array();
		if($queryCategory->num_rows() > 0){
			$data = $queryCategory->result();
		}		
		return $data;
	}
	function findMainCategory($leadID,$categoryList){
		$queryCategory = $this->db->select('*')->from($this->table_lead_category)->where('lead_id',$leadID)->where_in('category_id',$categoryList)->get();
		$data = 0;
		if($queryCategory->num_rows() > 0){
			$list = $queryCategory->result();
			foreach($list as $l){
				$data = $l->category_id;
			}
		}		
		return $data;
	}
	function updateLeadCategory($leadID,$data){
		$this->db->where('lead_id',$leadID);
		$this->db->update($this->table_lead_category,$data);
		return $this->db->affected_rows();
	}
	function updateLeadCategoryByLeadIDCategory($leadID,$c,$data){
		$this->db->where('lead_id',$leadID);
		$this->db->where('category_id',$c);
		$this->db->update($this->table_lead_category,$data);
		return $this->db->affected_rows();
	}
	
	function findLeads($start,$field){
		$query = $this->db->select("id,folder_id,".$field)->from($this->table_lead)->where($field." <>",'')->limit(10,$start)->get();
		$data = array();
		if ($query->num_rows() > 0) {
           $data = $query->result();
		}
		return $data;
	}
	
	public function findOneLitigationWithIncomplete($lead_id,$type){
		$select = 'l.id,l.serial_number,file_url,l.lead_name ,l.spreadsheet_id  ,l.worksheet_id ,l.worksheet_name ,l.type ,l.patent_data ,l.create_date,l.seller_contact_id ,l.seller_info ,l.seller_info_text ,l.seller_like ,l.funding_trnsfr ,l.claim_illus ,l.claim_status_dd ,l.technical_dd ,l.technical_status_dd ,l.legal_dd  ,l.legal_status_dd ,l.create_patent_list  ,l.create_patent_list_text ,l.complete ,l.forward_to_review_text  ,l.nda_term_sheet  ,l.nda_term_sheet_text ,l.status ,l.synpat_like ,l.ppa_id ,l.ppa_text_date ,l.execute_ppa ,l.ppa_execute ,l.ppa_date ,l.plantiffs_name ,l.no_of_prospects ,l.upfront_price ,l.prospects_name ,l.technologies ,l.no_of_us_patents ,l.no_of_non_us_patents ,l.send_proposal_letter ,l.market_data ,l.seller_contact ,l.broker_contact ,l.option_expiration_date ,l.broker ,l.broker_person_contact,l.broker_person ,l.person_name_1 ,l.person_title_1 ,l.person_name_2 ,l.person_title_2 ,l.address ,l.relates_to ,l.expected_price ,l.update_date ,l.next_action ,l.case_name ,l.litigation_stage ,l.market_industry ,l.case_type ,l.case_number ,l.cause no_of_patent ,l.filling_date ,l.active_defendants ,l.lead_attorney ,l.scrapper_data ,l.original_defendants ,l.court ,l.link_to_pacer ,l.link_to_rpx ,l.defendants ,l.court_docket_entries,l.folder_id,l.invalidation_tab,l.eou_tab,l.port_price,l.agreed_price,l.scheduler_link';
		$query = $this->db->select($select)->from($this->table_lead.' as l')->where('l.id',$lead_id)->order_by('l.id','DESC')->get();
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $allArray = array();
                /**/
                /*Broker Name*/
				$row->broker_company = 0;
					if(!empty($row->broker_person)){
						$brokderData = $this->db->select('c.first_name,c.last_name,cc.company_name,c.company_id')->from($this->table_contacts.' as c')->join($this->table_company.' as cc','cc.id = c.company_id')->where('c.id',$row->broker_person)->get()->row();
						if(count($brokderData)>0){
							$row->broker_contact = $brokderData->company_name;
							$row->broker_person_contact = $brokderData->first_name.' '.$brokderData->last_name;
							$row->broker_company = $brokderData->company_id;
						} else {
							$row->broker_contact ='';
							$row->broker_person_contact = '';
							$row->broker_person = 0;
							$row->broker_company = 0;
						}
					}
					
					/*End Broker Name*/
					/*Seller Name*/
					if(!empty($row->plantiffs_name)){
						$sellerInfo = $this->db->select('cc.company_name')->from($this->table_company.' as cc')->where('cc.id',$row->plantiffs_name)->get()->row();
						if(count($sellerInfo)>0){
							$row->seller_contact = $sellerInfo->company_name;
						} else {
							$row->seller_contact = '';
							$row->plantiffs_name = '';
						}
					}
					/*End Seller Name*/

					/*Person 1*/
					if(!empty($row->person_title_1)){
						$personOneData = $this->db->select('c.first_name,c.last_name')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_1)->get()->row();
						if(count($personOneData)>0){
							$row->person_name_1 = $personOneData->first_name.' '.$personOneData->last_name;
						} else {
							$row->person_name_1 ='';
							$row->person_title_1 = '';
						}
					}
					/*End Person 1*/
					/*Person 2*/
					if(!empty($row->person_title_2)){
						$personSecondData = $this->db->select('c.first_name,c.last_name')->from($this->table_contacts.' as c')->where('c.id',$row->person_title_2)->get()->row();
						if(count($personSecondData)>0){
							$row->person_name_2 = $personSecondData->first_name.' '.$personSecondData->last_name;
						} else {
							$row->person_name_2 ='';
							$row->person_title_2 = '';
						}
					}
					/*End Person 2*/
					/*Lead Last seen*/
					$row->lead_last_seen = "0000-00-00";
					$queryLastSeen = $this->db->select('create_date as login_date')->from($this->table_history)->where('lead_id',$row->id)->order_by('id','desc')->limit(1,0)->get();					
					if($queryLastSeen->num_rows()>0){
						$dataLastSeen = $queryLastSeen->first_row();
						$row->lead_last_seen = $dataLastSeen->login_date;
					}
					/*End Lead Last seen*/
					/*Calculation Attractive*/
					$row->attractive = 0;
					$queryAttractive = $this->db->select('sum(attractive) as attractive,count(id) as counter')->from($this->table_comment)->where('parent_id',$row->id)->get();
					if($queryAttractive->num_rows()>0){
						$attractiveData = $queryAttractive->first_row();
						if($attractiveData->counter>0 && $attractiveData->attractive>0){
							$row->attractive = $attractiveData->attractive/$attractiveData->counter;
						}
					}
					/**/
					$getEouData = $this->findEOULeadMaterial($row->serial_number);
					$evidence = 0;
					if(count($getEouData)>0){
						$eouData = $getEouData->other_field;
						if(is_string($eouData)){
							$jsonDecodeEou = json_decode($eouData);							
							if(isset($jsonDecodeEou->another_license) && $jsonDecodeEou->another_license!='' && count($jsonDecodeEou->another_license)>0){
								foreach($jsonDecodeEou->another_license as $licenseEvidence){									
									if($licenseEvidence->evidence=="Yes"){										
										$evidence = $evidence+1;
									}
								}
							}
						}
					}
					$row->eou = $evidence;
                /**/
				$allArray['invitation_link'] = $this->getLeadInvitationLink($row->id);
				$allArray['comment'] = $this->getLitigationComments($row->id,$type);
                /*$allArray['timeLine'] = $this->getAllUserHistory(0,$row->id,0);*/
                $allArray['timeLine'] = array();
                /*$allArray['task'] = $this->getAllTaskFromLead($row->id);
				$allArray['task_i'] = $this->myTaskApproval($row->id);*/
                $allArray['task'] = array();
                $allArray['task_i'] = array();
                $allArray['acquisitions'] = $this->getAcquisitionData($row->id,'a.store_name,a.order_name,a.category,a.regular_license_starts,a.late_license_starts,a.active_button,a.docket_status,a.store_status,a.cost_price,a.option_expiration_data,a.closing_date,a.image_left,a.image_middle,a.image_right,a.image_four,a.image_five,a.image_six,a.image_seven,a.image_eight,a.image_nine,a.image_ten,a.image_eleven,a.image_twelve');
				$allArray['lead_category_list'] = $this->getLeadCategoryList($row->id);
				/*Check Date*/
				if(count($allArray['acquisitions'])>0){
					$acquisition = $allArray['acquisitions'];
					/*if($acquisition->regular_license_starts!='0000-00-00 00:00:00'){
						$todayDate = strtotime(date('Y-m-d',strtotime('now')));
						$lateLicense = $acquisition->late_license_starts;
						$regularLicense = strtotime($acquisition->regular_license_starts);
						if($lateLicense!='0000-00-00 00:00:00'){
							$lateLicense = strtotime($lateLicense);
							if($todayDate>$regularLicense){
								if((int)$acquisition->active_button!=3){
									$acquisition->active_button = 3;
									$this->updateAcquisition(array('active_button'=>$acquisition->active_button),$row->id);
									$this->updateLicenseDataBySerialNumber($acquisition->active_button,$row->serial_number);
									$allArray['acquisitions'] = $acquisition;
								}
							}
						}
					}*/
					$todayDate = strtotime(date('Y-m-d',strtotime('now')));
					if(count($acquisition)>0){
						$expirationDate = strtotime($acquisition->option_expiration_data);
						$regularLicense = strtotime($acquisition->regular_license_starts);
						$lateLicense = strtotime($acquisition->late_license_starts);
						if($acquisition->option_expiration_data!='0000-00-00 00:00:00' && $expirationDate>$todayDate && $acquisition->regular_license_starts=='0000-00-00 00:00:00'){
							if($acquisition->active_button!='1'){
								$acquisition->active_button = 1;
								$this->updateAcquisition(array('active_button'=>$acquisition->active_button),$row->id);
								$this->updateLicenseDataBySerialNumber($acquisition->active_button,$row->serial_number);
							}
						} else if($acquisition->regular_license_starts!='0000-00-00 00:00:00'){
							if($acquisition->late_license_starts=='0000-00-00 00:00:00'){
								$lateLicense = date('m/d/Y',strtotime('+4 months',$regularLicense));
								$acquisition->late_license_starts = date('Y-m-d H:i:s',strtotime($lateLicense));
								$acquisition->active_button = 2;
								$this->updateAcquisition(array('active_button'=>$acquisition->active_button,'late_license_starts'=>$acquisition->late_license_starts),$row->id);
								$this->updateLicenseDataBySerialNumber($acquisition->active_button,$row->serial_number);						
							} else {
								if($todayDate>$regularLicense && $todayDate<$lateLicense && $acquisition->active_button!='2'){
									$acquisition->active_button = 2;
									$this->updateAcquisition(array('active_button'=>$acquisition->active_button),$row->id);
									$this->updateLicenseDataBySerialNumber($acquisition->active_button,$row->serial_number);
								} else if($todayDate>$regularLicense && $todayDate>=$lateLicense && $acquisition->active_button!='3'){
									$acquisition->active_button = 3;
									$this->updateAcquisition(array('active_button'=>$acquisition->active_button),$row->id);
									$this->updateLicenseDataBySerialNumber($acquisition->active_button,$row->serial_number);
								}
							}
						}
					}
					
					$allArray['acquisitions'] = $acquisition;
				}
				$illustrationComplete = 0;
				$techDDComplete = 0;
				$marketDDComplete = 0;
				$legalDDComplete = 0;
				$pdfDDComplete = 0;
				$comparablesComplete = 0;
				$invitesComplete = 0;
				$gatewayC = 0;
				$imageComplete = 0;
				$royaltyComplete = 0;
				$introAccordionComplete = 0;
				$family = 0;
				$assets = 0;
				$jurisd = 0;
				$sellerDD = 0;
				$marketCategoriesString = "";
				$personName = "";
				$getParticipantsData = array('request'=>0,'min_price'=>0,'participants'=>0,'regular'=>0,'late'=>0);
				if(count($allArray['acquisitions'])>0){		
					$licenseID = 0;
					$personData = $this->db->select("*")->from($this->table_licenses)->where('serial_number',$row->serial_number)->get()->row();
					if(count($personData)>0){
						$personName = $personData->person_name;
						$licenseID = $personData->id;
					}
					$getLeadPatentList = $this->getLeadPatentList($row->id);
					if(count($getLeadPatentList)>0){
						$patentsList = array();
						foreach($getLeadPatentList as $p){
							$patentsList[] = $p->patent;
						}
						if(count($patentsList)>0){
							/*Number of Illustration Patent Complete*/
							$illustrationComplete = $this->db->select("count(id) as illustrationComplete")->from($this->table_due_dilligence_illustrations)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->illustrationComplete;							
							/*End*/
							/*Number of TechDD Patent Complete*/
							$techDDComplete = $this->db->select("count(id) as techDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('tech_status',1)->get()->row()->techDDComplete;	
							/*End*/
							/*Number of Market Patent Complete*/
							$marketDDComplete = $this->db->select("count(id) as marketDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('market_status',1)->get()->row()->marketDDComplete;	
							/*End*/
							/*Number of LegalDD Patent Complete*/
							$legalDDComplete = $this->db->select("count(id) as legalDDComplete")->from($this->table_due_dilligence_legal)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->legalDDComplete;
							/*End*/
							/*Number of PDFs Patent Complete*/
							$pdfDDComplete = $this->db->select("count(id) as pdfDDComplete")->from($this->table_due_dilligence_pdf)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->pdfDDComplete;
							/*echo $this->db->last_query();*/
							/*End*/		
							/*SellerDD*/
							if($licenseID>0){
								$checkLicense = $this->db->select("count(*) as licenseCount")->from("due_dilligence_licenses")->where("license_id",$licenseID)->get()->row()->licenseCount;
								if($checkLicense>0){
									for($i=0;$i<count($patentsList);$i++){
										$entryFalse = false;
										/*$ddTitle = $this->db->select("count(*) as ddTitles")->from("due_dilligence_titles")->where("patent_id",substr($patentsList[$i],2))->get()->row()->ddTitles;
										if($ddTitle==0){
											$sqlTitleFreeText = $this->db->select("count(*) as ddTitles")->from("due_dilligence_titles_free_texts")->where("patent_id",substr($patentsList[$i],2))->get()->row()->ddTitles;
											if($sqlTitleFreeText>0){
												$entryFalse=true;
											} else {
												$entryFalse=false;
											}
										} else {
											$entryFalse=true;
										}*/
										$checkLicenseData = $this->db->select("count(*) as licenseCount")->from("due_dilligence_licenses_data")->where("license_id",$licenseID)->where("patent_id",$patentsList[$i])->where('show_data > ',0)->get()->row()->licenseCount;
										if($checkLicenseData>0){
											$entryFalse=true;
										} else {
											$entryFalse=false;
											break;
										}
										
										if($entryFalse===true){
											$standardsCount = $this->db->select("count(*) as standardsCount")->from("due_dilligence_standards_data")->where("license_id",$licenseID)->where("patent_id",$patentsList[$i])->where('show_data > ',0)->get()->row()->standardsCount;
											if($standardsCount>0){
												$entryFalse=true;
											} else {
												$entryFalse=false;
												break;
											}
											if($entryFalse===true){
												$collateralsCount = $this->db->select("count(*) as collateralsCount")->from("due_dilligence_collaterals_data")->where("license_id",$licenseID)->where("patent_id",$patentsList[$i])->where('show_data > ',0)->get()->row()->collateralsCount;
												if($collateralsCount>0){
													$entryFalse=true;
												} else {
													$entryFalse=false;
													break;
												}
											}
											if($entryFalse===true){
												$partiesCount = $this->db->select("count(*) as partiesCount")->from("due_dilligence_parties_data")->where("license_id",$licenseID)->where("patent_id",$patentsList[$i])->where('show_data > ',0)->get()->row()->partiesCount;
												if($partiesCount>0){
													$entryFalse=true;
												} else {
													$entryFalse=false;
													break;
												}
											}
										}
										if($entryFalse===true){
											$sellerDD++;
										}
									}
								}
							}
						}
					}					
					//$getLicenseResult = $this->db->select('id as licenseID')->from($this->table_licenses)->where('serial_number',$row->serial_number)->get();
					/*if($getLicenseResult->num_rows()>0){*/
					if($licenseID>0){
						$getParticipantsData = $this->findRequestFromDockets($licenseID);
						
						/*$getLicenseData = $getLicenseResult->first_row();*/
						$getLicenseData = (object)array('licenseID'=>$licenseID);
						/*Royalty*/
						$royaltyComplete = $this->db->select("count(id) as royaltyComplete")->from($this->table_damages)->where('license_id',$getLicenseData->licenseID)->get()->row()->royaltyComplete;
						/*End*/
						/*Number of Comparables Agreement*/
						$comparablesComplete = $this->db->select("count(id) as comparablesComplete")->from($this->table_comparables)->where('license_id',$getLicenseData->licenseID)->get()->row()->comparablesComplete;
						/*End*/
						/*Number of Invitees Patent Complete*/
						/*$invitesComplete = $this->db->select("count(id) as invitesComplete")->from($this->table_invitees_due)->where('license_id',$getLicenseData->licenseID)->get()->row()->invitesComplete;*/
						$invitesQuery = $this->db->select("distinct(c.id) as companyID")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where('i.lead_id',$row->id)->get();
						if($invitesQuery->num_rows()>0){
							$invitesComplete = $invitesQuery->num_rows();
							$getInviteesCompanies = $invitesQuery->result();
							$allInviteesID = array();
							foreach($getInviteesCompanies as $c){
								$allInviteesID[] = $c->companyID;
							}
							if(count($allInviteesID)>0){
								$gatewayC = $this->db->select('count(id) as gateway')->from($this->table_contacts)->where_in('company_id',$allInviteesID)->where('gateway',1)->get()->row()->gateway;
								if($gatewayC==null){
									$gatewayC = 0;
								}
							}
						}
						/*echo $this->db->last_query();*/
						
						
						
						/*End*/
						/*Lead Family, Assets, Jurisdiction*/
						$family = $this->db->select("count(patent_number) as family")->from($this->table_due_dilligences)->where('license_id',$getLicenseData->licenseID)->get()->row()->family;
						$queryChartLeft = $this->db->select("country,patents,applications")->from($this->table_chart_lefts)->where('license_id',$getLicenseData->licenseID)->get();
						if($queryChartLeft->num_rows()>0){
							$getChartLeft = array();
							foreach($queryChartLeft->result() as $rowLeft){
								$getChartLeft[] = $rowLeft;
							}
							$assets = 0;
							$countCountry = array();
							if(count($getChartLeft)>0){
								foreach($getChartLeft as $chartL){
									if(strtolower(strtoupper($chartL->country))!="wo" && strtolower(strtoupper($chartL->country))!="ep"){
										$assets = $assets + (int)$chartL->applications + (int)$chartL->patents;
										if(!in_array($chartL->country,$countCountry)){
											$countCountry[] = $chartL->country;
										}
									}								
								}
							}
							$jurisd = count($countCountry);
						}
						/*Check due dilligence Inventions*/
						$dueInventionsResult = $this->db->select('DISTINCT(di.patent_id), di.related_system_texts')->from($this->table_due_dilligence_inventions.' as di')->join($this->table_due_dilligences.' as d','d.patent_number = di.patent_id','INNER')->join($this->table_licenses.' as l','l.id = d.license_id')->where('d.license_id',$getLicenseData->licenseID)->get();
						$marketCategories= array();
						if($dueInventionsResult->num_rows()>0){							
							foreach($dueInventionsResult->result() as $dueRows){
								$getInvention = $dueRows->related_system_texts;
								if(!empty($getInvention) && $getInvention!=null){
									try{
										$inventionText = json_decode($getInvention,true);
										if(count($inventionText)>0){
											if(isset($inventionText[0][1]) && $inventionText[0][1]!=null && $inventionText[0][1]!=''){
												foreach($inventionText as $invention){
													if(isset($invention[1]) && $invention[1]!=null && $invention[1]!=''){
														$checkMe = $this->db->select('c.parent')->from($this->table_category.' as c')->where('c.name',$invention[1])->limit(1)->order_by('id','DESC')->get();
														if($checkMe->num_rows()>0){
															$getCategory = $checkMe->first_row();
															if((int)$getCategory->parent == 2){
																$checkParent = $this->db->select('c.name')->from($this->table_category.' as c')->where('c.id',$getCategory->parent)->get();
																if($checkParent->num_rows()>0){
																	$getParentCategory = $checkParent->first_row();
																	if(!in_array($getParentCategory->name,$marketCategories)){
																		$marketCategories[] = $getParentCategory->name;
																	}
																}
															}else {
																if(!in_array($invention[1],$marketCategories)){
																	$marketCategories[] = $invention[1];
																}
															}
														}
													}
												}
											}
										}
									} catch( Exception $e){
										
									}
								}
							}							
						}
						$marketCategoriesString = implode(',',$marketCategories);
						/*End due dilligence Inventions*/
					}
					/*Number of Images*/					
					if(count($personData)>0){
						if($personData->portfolio_accordion_complete==1){
							$introAccordionComplete++;
						}
						if(!empty($personData->file_left) && $personData->file_left!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_middle) && $personData->file_middle!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_right) && $personData->file_right!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_four) && $personData->file_four!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_five) && $personData->file_five!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_six) && $personData->file_six!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_seven) && $personData->file_seven!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_eight) && $personData->file_eight!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_nine) && $personData->file_nine!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_ten) && $personData->file_ten!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_eleven) && $personData->file_eleven!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_twelve) && $personData->file_twelve!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_thirteen) && $personData->file_thirteen!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_fourteen) && $personData->file_fourteen!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_fiveteen) && $personData->file_fiveteen!=null){
							$imageComplete++;
						}
						if(!empty($personData->file_sixteen) && $personData->file_sixteen!=null){
							$imageComplete++;
						}					
					}
					/*End*/
					/*IntroDD complete*/					
					/*End*/					
				}
				
				
				
				$row->family = $family;
				$row->portfolio_person_name = $personName;
				$row->assets = $assets;
				$row->jurisdiction = $jurisd;
				$row->illustrationComplete =$illustrationComplete;
				$row->techDDComplete = $techDDComplete;
				$row->marketDDComplete = $marketDDComplete;
				$row->legalDDComplete = $legalDDComplete;
				$row->pdfDDComplete = $pdfDDComplete;
				$row->comparablesComplete = $comparablesComplete;
				$row->invitesComplete = $invitesComplete;
				$row->gateway = $gatewayC;
				$row->imageComplete = $imageComplete;
				$row->royaltyComplete = $royaltyComplete;
				$row->introAccordionComplete = $introAccordionComplete;
				$row->sellerdd = $sellerDD;
				$row->marketCategoriesString = $marketCategoriesString;
				$allArray['litigation'] = $row;
                /*$allArray['stage'] = $this->checkStage($row->id);
                $allArray['level'] = $this->checkLevel($row->id);*/
                $allArray['level'] = array();
				$allArray['stage'] = array();
				$allArray['participants_data'] = $getParticipantsData;
                $allArray['report'] = $this->checkLeadReport($row->id);
                $allArray['open_project'] = $this->getOpenProjectList($row->id);
                $allArray['buttons'] = $this->checkButtonList($row->id); 
				$allArray['user_list'] = $this->getInnerUserList();
				$data[] = $allArray;
            }            
        }
		
		return $data;
	}
	function getLeadInvitationLink($leadID){
		$templateLink = "";
		$query = $this->db->select("file_name")->from($this->table_lead_template)->where('lead_id',$leadID)->where('type',0)->get();
		if($query->num_rows() > 0){
			$getData = $query->first_row();
			$templateLink = $getData->file_name;
		}
		return $templateLink;
	}
	function getLeadOpenDDProjectUserAndCount($leadID){
		$getLeadData = $this->getLeadDataWithOptions($leadID,'serial_number');
		$acquisitions = $this->getAcquisitionData($leadID,'a.store_name,a.order_name,a.category,a.regular_license_starts,a.late_license_starts,a.active_button,a.docket_status,a.cost_price,a.option_expiration_data,a.image_left,a.image_middle,a.image_right,a.image_four,a.image_five,a.image_six,a.image_seven,a.image_eight,a.image_nine,a.image_ten,a.image_eleven,a.image_twelve');
		$illustrationComplete = 0;
		$techDDComplete = 0;
		$marketDDComplete = 0;
		$legalDDComplete = 0;
		$pdfDDComplete = 0;
		$comparablesComplete = 0;
		$invitesComplete = 0;
		$imageComplete = 0;
		$royaltyComplete = 0;
		$sellerDD = 0;
		if(count($acquisitions)>0){	
			$licenseID = 0;
			$personData = $this->db->select("id")->from($this->table_licenses)->where('serial_number',$getLeadData->serial_number)->get()->row();
			if(count($personData)>0){
				$licenseID = $personData->id;
			}			
			$getLeadPatentList = $this->getLeadPatentList($leadID);
			if(count($getLeadPatentList)>0){
				$patentsList = array();
				foreach($getLeadPatentList as $p){
					$patentsList[] = $p->patent;
				}
				if(count($patentsList)>0){
					/*Number of Illustration Patent Complete*/
					$illustrationComplete = $this->db->select("count(id) as illustrationComplete")->from($this->table_due_dilligence_illustrations)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->illustrationComplete;							
					/*End*/
					/*Number of TechDD Patent Complete*/
					$techDDComplete = $this->db->select("count(id) as techDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('tech_status',1)->get()->row()->techDDComplete;	
					/*End*/
					/*Number of Market Patent Complete*/
					$marketDDComplete = $this->db->select("count(id) as marketDDComplete")->from($this->table_due_dilligence_inventions)->where_in('patent_id',$patentsList)->where('market_status',1)->get()->row()->marketDDComplete;	
					/*End*/
					/*Number of LegalDD Patent Complete*/
					$legalDDComplete = $this->db->select("count(id) as legalDDComplete")->from($this->table_due_dilligence_legal)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->legalDDComplete;
					/*End*/
					/*Number of PDFs Patent Complete*/
					$pdfDDComplete = $this->db->select("count(id) as pdfDDComplete")->from($this->table_due_dilligence_pdf)->where_in('patent_id',$patentsList)->where('status',1)->get()->row()->pdfDDComplete;
					/*echo $this->db->last_query();*/
					/*End*/		
					/*SellerDD*/
					if($licenseID>0){
						$checkLicense = $this->db->select("count(*) as licenseCount")->from("due_dilligence_licenses")->where("license_id",$licenseID)->get()->row()->licenseCount;
						if($checkLicense>0){
							for($i=0;$i<count($patentsList);$i++){
								$entryFalse = false;
								/*$ddTitle = $this->db->select("count(*) as ddTitles")->from("due_dilligence_titles")->where("patent_id",substr($patentsList[$i],2))->get()->row()->ddTitles;
								if($ddTitle==0){
									$sqlTitleFreeText = $this->db->select("count(*) as ddTitles")->from("due_dilligence_titles_free_texts")->where("patent_id",substr($patentsList[$i],2))->get()->row()->ddTitles;
									if($sqlTitleFreeText>0){
										$entryFalse=true;
									} else {
										$entryFalse=false;
									}
								} else {
									$entryFalse=true;
								}*/
								$checkLicenseData = $this->db->select("count(*) as licenseCount")->from("due_dilligence_licenses_data")->where("license_id",$licenseID)->where("patent_id",$patentsList[$i])->get()->row()->licenseCount;
								if($checkLicenseData>0){
									$entryFalse=true;
								} else {
									$entryFalse=false;
									break;
								}
								
								if($entryFalse===true){
									$standardsCount = $this->db->select("count(*) as standardsCount")->from("due_dilligence_standards_data")->where("license_id",$licenseID)->where("patent_id",$patentsList[$i])->get()->row()->standardsCount;
									if($standardsCount>0){
										$entryFalse=true;
									} else {
										$entryFalse=false;
										break;
									}
									if($entryFalse===true){
										$collateralsCount = $this->db->select("count(*) as collateralsCount")->from("due_dilligence_collaterals_data")->where("license_id",$licenseID)->where("patent_id",$patentsList[$i])->get()->row()->collateralsCount;
										if($collateralsCount>0){
											$entryFalse=true;
										} else {
											$entryFalse=false;
											break;
										}
									}
									if($entryFalse===true){
										$partiesCount = $this->db->select("count(*) as partiesCount")->from("due_dilligence_parties_data")->where("license_id",$licenseID)->where("patent_id",$patentsList[$i])->get()->row()->partiesCount;
										if($partiesCount>0){
											$entryFalse=true;
										} else {
											$entryFalse=false;
											break;
										}
									}
								}
								if($entryFalse===true){
									$sellerDD++;
								}
							}
						}
					}
				}
			}
			if($licenseID>0){
				/*$getLicenseData = $getLicenseResult->first_row();*/
				$getLicenseData = (object)array('licenseID'=>$licenseID);
				/*Royalty*/
				$royaltyComplete = $this->db->select("count(id) as royaltyComplete")->from($this->table_damages)->where('license_id',$getLicenseData->licenseID)->get()->row()->royaltyComplete;
				/*End*/
				/*Number of Comparables Agreement*/
				$comparablesComplete = $this->db->select("count(id) as comparablesComplete")->from($this->table_comparables)->where('license_id',$getLicenseData->licenseID)->get()->row()->comparablesComplete;
				/*End*/
				/*Number of Images*/					
				$imagesResult = $acquisitions;
				if(!empty($imagesResult->image_left) && $imagesResult->image_left!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_middle) && $imagesResult->image_middle!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_right) && $imagesResult->image_right!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_four) && $imagesResult->image_four!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_five) && $imagesResult->image_five!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_six) && $imagesResult->image_six!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_seven) && $imagesResult->image_seven!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_eight) && $imagesResult->image_eight!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_nine) && $imagesResult->image_nine!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_ten) && $imagesResult->image_ten!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_eleven) && $imagesResult->image_eleven!=null){
					$imageComplete++;
				}
				if(!empty($imagesResult->image_twelve) && $imagesResult->image_twelve!=null){
					$imageComplete++;
				}
			}
		}
		$row = (object)array();
		$row->legalDDComplete = $legalDDComplete;
		$row->illustrationComplete =$illustrationComplete;
		$row->techDDComplete = $techDDComplete;
		$row->marketDDComplete = $marketDDComplete;
		$row->pdfDDComplete = $pdfDDComplete;
		$row->comparablesComplete = $comparablesComplete;
		$row->royaltyComplete = $royaltyComplete;
		$row->imageComplete = $imageComplete;
		$row->sellerdd = $sellerDD;
		$row->invitesComplete = $invitesComplete;
		$row->open_project = $this->getOpenProjectList($leadID);
		$row->serial_number = $getLeadData->serial_number;
		return $row;
	}
	
	function updateLicenseDataBySerialNumber($activeButton,$serialNumber){
		$this->db->where('serial_number', $serialNumber);
		$this->db->update($this->table_licenses, array('active_button'=>$activeButton));
		return $this->db->affected_rows();
	}
	
	function updateLicenseBySerialNumber($data,$serialNumber){
		$this->db->where('serial_number', $serialNumber);
		$this->db->update($this->table_licenses, $data);
		return $this->db->affected_rows();
	}
	
	function findCallActivityLogByEmailID($emailID){
		$logData =array();
		$getLogData = $this->db->select('a.*')->from($this->table_activity_log.' as a')->where('a.email_id',$emailID)->order_by('a.id','DESC')->get();
		if($getLogData->num_rows()>0){
			$logData = $getLogData->first_row();
		}
		return $logData;
	}	

	function findCallActivityLogByContactID($personID){		
		$loglist = array();
		$getLogList = $this->db->select('a.contact_id,a.company_id,a.lead_id,c.company_name as companyName,l.lead_name as leadName,')->from($this->table_activity_log.' as a')->join($this->table_company.' as c','c.id = a.company_id','left')->join($this->table_lead.' as l','l.id = a.lead_id','left')->where('a.contact_id',$personID)->group_by('a.lead_id')->get();
		if($getLogList->num_rows()>0){
			$loglist = $getLogList->result();
		}
		return $loglist;
	}

	function getActivityDetailsByCLC($contactID,$leadID,$companyID){
		$getLog = $this->db->select('a.*')->from($this->table_activity_log.' as a')->where("a.contact_id",$contactID)->where("a.lead_id",$leadID)->where("a.company_id",$companyID)->get();
		$activity = array();
		if($getLog->num_rows()>0){
			$activity = $getLog->result();
		}
		return $activity;
	}
	
	function getAcquisitionDetailsByCLC($contactID,$leadID,$companyID){
		$getLog = $this->db->select('a.*')->from($this->table_acquisition_activity.' as a')->where("a.contact_id",$contactID)->where("a.lead_id",$leadID)->where("a.company_id",$companyID)->get();
		$activity = array();
		if($getLog->num_rows()>0){
			$activity = $getLog->result();
		}
		return $activity;
	}
	
	function getSalesDetailsByCLC($contactID,$leadID,$companyID){
		$getLog = $this->db->select('a.*')->from($this->table_sales_activity.' as a')->where("a.contact_id",$contactID)->where("a.lead_id",$leadID)->where("a.company_id",$companyID)->get();
		$activity = array();
		if($getLog->num_rows()>0){
			$activity = $getLog->result();
		}
		return $activity;
	}
	
	function findCallActivityLog($leadID,$personID,$companyID){
		$loglist =array();
		/*$getLogList = $this->db->select('a.*')->from($this->table_activity_log.' as a')->join($this->table_lead.' as b','b.id = a.email_id','left outer')->where("a.company_id",$companyID)->where('a.lead_id',$leadID)->where('a.contact_id',$personID)->order_by('a.id','DESC')->order_by('b.date_received','DESC')->get();*/
		
		$getLogList = $this->db->select('a.*')->from($this->table_activity_log.' as a')->where("a.company_id",$companyID)->where('a.lead_id',$leadID)->where('a.contact_id',$personID)->order_by('a.id','DESC')->get();
		if($getLogList->num_rows()>0){
			foreach ($getLogList->result() as $p) {
				$emailDetails = array();
				if(((int)$p->type==3 || (int)$p->type==6) && $p->email_id>0){
					/**/
					$emailDetails = $this->findBoxNewById($p->email_id);
				}
				$p->email_details = $emailDetails;
				$loglist[] = $p;
			}
		}
		return $loglist;
	}
	
	function findAllContactsFromCustomerCompany($customerID,$select){
		$persons =array();
		$getPersons = $this->db->select($select)->from($this->table_customers.' as c')->where('c.company_id IN (SELECT cc.company_id FROM '.$this->table_customers.' as cc WHERE cc.id = '.$customerID.')')->get();
		if($getPersons->num_rows()>0){
			foreach ($getPersons->result() as $p) {
				$persons[] = $p;
			}
		}
		return $persons;
	}
	
	function findAllContactsFromCompany($companyID,$select){
		$persons =array();
		$getPersons = $this->db->select($select)->from($this->table_customers.' as c')->where('c.company_id',$companyID)->get();
		if($getPersons->num_rows()>0){
			foreach ($getPersons->result() as $p) {
				$persons[] = $p;
			}
		}
		return $persons;
	}
	
	function getCustomerInfoByID($id,$select="*"){
		$persons = array();
		if($id>0){
			$getPersons = $this->db->select($select)->from($this->table_customers.' as c')->where("c.id",$id)->get();
			if($getPersons->num_rows()>0){
				$persons = $getPersons->first_row();
			}
		}
		   
		return $persons;
	}
	
	function c_my_contact_list($cID,$select){
		$persons =array();
		$getPersons = $this->db->select($select)->from($this->table_contacts.' as c')->where("c.company_id",$cID)->order_by("c.first_name DESC")->get();
		if($getPersons->num_rows()>0){
			foreach ($getPersons->result() as $p) {
				$persons[] = $p;
			}
		}
		return $persons;
	}
	
	function getContactByEmail($email){
		$persons = array();
		$email = trim($email);
		if($email!="" && !empty($email))
		$getPersons = $this->db->select('*')->from($this->table_contacts.' as c')->where("c.email",trim($email))->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function getContactByEmailOrSecondary($email){
		$persons = array();
		$email = trim($email);
		if($email!="" && !empty($email))
		$getPersons = $this->db->select('*')->from($this->table_contacts.' as c')->where("c.email",trim($email))->or_where("c.secondary_email",trim($email))->or_where("c.tertiary_email",trim($email))->limit(1)->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function getContactFullContactID($fullContact){
		$persons = array();
		$fullContact = trim($fullContact);
		if($fullContact!="" && !empty($fullContact))
		$getPersons = $this->db->select('*')->from($this->table_contacts.' as c')->where("c.fullContact",trim($fullContact))->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function getPreCompanyName($companyName,$select){
		$persons = array();
		if(!empty($companyName)){
			$getPersons = $this->db->select($select)->from($this->table_precompanies.' as c')->where("c.company_name",$companyName)->get();
			if($getPersons->num_rows()>0){
				$persons = $getPersons->first_row();
			} 
		}		  
		return $persons;
	}
	
	function getCompanyName($companyName,$select){
		$getData = array();
		if(!empty($companyName)){
			$getResult = $this->db->select($select)->from($this->table_company.' as c')->where("c.company_name",$companyName)->get();
			if($getResult->num_rows()>0){
				$getData = $getResult->first_row();
			} 
		}		  
		return $getData;
	}
	
	function getPreContactById($ID){
		$persons = array();
		$getPersons = $this->db->select('*')->from($this->table_precontacts.' as c')->where("c.id",$ID)->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function getContactById($ID,$select="c.*"){
		$persons = array();
		$getPersons = $this->db->select($select)->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where("c.id",$ID)->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function checkPreContactWithLinkedinUrl($url){
		$persons = array();
		$url = trim($url);
		if($url!="" && !empty($url)){
			$getPersons = $this->db->select("c.profile_url")->from($this->table_precontacts.' as c')->where("c.profile_url",trim($url))->get();
			if($getPersons->num_rows()>0){
				$persons = $getPersons->first_row();
			} 
		}		  
		return $persons;
	}
	
	function getPreContactByEmail($email){
		$persons = array();
		$email = trim($email);
		if($email!="" && !empty($email))
		$getPersons = $this->db->select('*')->from($this->table_precontacts.' as c')->where("c.email",trim($email))->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	function getPreContactFullContactID($fullContact){
		$persons = array();
		$fullContact = trim($fullContact);
		if($fullContact!="" && !empty($fullContact))
		$getPersons = $this->db->select('*')->from($this->table_precontacts.' as c')->where("c.fullcontact",trim($fullContact))->get();
		if($getPersons->num_rows()>0){
			$persons = $getPersons->first_row();
		}   
		return $persons;
	}
	
	public function updateSalesActivity($id,$data){
		$this->db->where('id',$id);
		$this->db->update($this->table_sales_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('last_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function updateSalesActivityByContactID($contactID,$data){
		$this->db->where('contact_id',$contactID);
		$this->db->update($this->table_sales_activity, $data);
		return $this->db->affected_rows();
	}
	
	public function updateAcquisitionActivityByContactID($contactID,$data){
		$this->db->where('contact_id',$contactID);
		$this->db->update($this->table_acquisition_activity, $data);
		return $this->db->affected_rows();
	}
	
	public function updateActivityLogByContactID($contactID,$data){
		$this->db->where('contact_id',$contactID);
		$this->db->update($this->table_activity_log, $data);
		return $this->db->affected_rows();
	}
	
	public function updateSalesActivityByEmailID($id,$data){
		$this->db->where('email_id',$id);
		$this->db->update($this->table_sales_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('last_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function insetSalesActivity($data){
		$this->db->insert($this->table_sales_activity, $data);
		$id = $this->db->insert_id();
		if($id>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('last_activity'=>$data['activity_date']));
			
			
			/*echo $this->db->last_query();*/
		}
		return $id;
	}
	
	public function updatePreSaleActivity($id,$data){
		$this->db->where('id',$id);
		$this->db->update($this->table_presales_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('pre_sale_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function updatePreSaleActivityByEmailID($id,$data){
		$this->db->where('email_id',$id);
		$this->db->update($this->table_presales_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('pre_sale_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function updateAcquistionActivity($id,$data){
		$this->db->where('id',$id);
		$this->db->update($this->table_acquisition_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_acquisition_company,array('last_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function updateAcquistionActivityByEmailID($id,$data){
		$this->db->where('email_id',$id);
		$this->db->update($this->table_acquisition_activity, $data);
		if($this->db->affected_rows()>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_acquisition_company,array('last_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function insertAcquistionActivity($data){
		if(isset($data['c_id'])){
			unset($data['c_id']);
		}
		if(isset($data['p_id'])){
			unset($data['p_id']);
		}
		$this->db->insert($this->table_acquisition_activity, $data);
		$id = $this->db->insert_id();
		if($id>0){
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_acquisition_company,array('last_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	public function insertPreSaleActivity($data){
		$this->db->insert($this->table_presales_activity, $data);
		$id = 0;
		if($this->db->insert_id()>0){
			$id = $this->db->insert_id();
			$this->db->where('contact_id',$data['company_id']);
			$this->db->where('lead_id',$data['lead_id']);
			$this->db->update($this->table_invitees,array('pre_sale_activity'=>$data['activity_date']));
		}
		return $id;
	}
	
	function findSalesActivityCompanies($leadID){
		$companyData  = array();
		$getInviteesCompanies = $this->db->select("c.company_name as orgName")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('c.company_name ASC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			 foreach ($getInviteesCompanies->result() as $row) {
				$companyData[] = $row;
			 }
		}
		return $companyData;
	}
	
	public function findBrokerDetails($brokerID){
		$data = array();
		if($brokerID>0){
			$query = $this->db->select("c.*,co.company_name , co.id as companyID")->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.id',$brokerID)->get();
			if ($query->num_rows() > 0) {
				$data = $query->first_row();
			}
		}
		return $data;
	}
	
	function findLeadCompanyBrokerDetails($leadID){
		$userID = $this->session->userdata['id'];
		$type = $this->session->userdata['type'];
		$details = array();
		if($userID>0 && $type!=9 && $type!=8){
			$userEmail = $this->session->userdata['email'];
			$contactDetails = $this->getContactByEmail($userEmail);
			if(count($contactDetails)>0){
				$query = $this->db->select("co.company_name , co.id as companyID, sblc.sales_company_id as SBLCID")->from($this->table_company.' as co')->join($this->table_sales_broker_lead_company.' as sblc','sblc.broker_company_id = co.id')->where('sblc.broker_company_id',$contactDetails->company_id)->where('sblc.lead_id',$leadID)->get();
				foreach ($query->result() as $row) {
					$details[] = $row;
				}
			}			
		} else {
			$query = $this->db->select("co.company_name , co.id as companyID, sblc.sales_company_id as SBLCID")->from($this->table_company.' as co')->join($this->table_sales_broker_lead_company.' as sblc','sblc.broker_company_id = co.id')->where('sblc.lead_id',$leadID)->get();
			foreach ($query->result() as $row) {
				$details[] = $row;
			}
		}
		return $details;
	}
	
	function findLeadCompanyPreBrokerDetails($leadID){
		$userID = $this->session->userdata['id'];
		$type = $this->session->userdata['type'];
		$details = array();
		$query = $this->db->select("co.company_name , co.id as companyID, sblc.sales_company_id as SBLCID")->from($this->table_company.' as co')->join($this->table_presale_broker.' as sblc','sblc.broker_company_id = co.id')->where('sblc.lead_id',$leadID)->get();
		foreach ($query->result() as $row) {
			$details[] = $row;
		}
		return $details;
	}
	
	
	function findCompaniesAssociate($contacts = array()){
		$companies = array();
		if(count($contacts)>0){
			$contactsIDs = array();
			foreach($contacts as $c){
				$contactsIDs[] = $c->id;
			}
			if(count($contactsIDs)>0){
				$findCompaniesIDs = $this->db->select('DISTINCT(c.id) as companyID')->from($this->table_company.' as c')->where_in('c.broker',$contactsIDs)->get();
				if($findCompaniesIDs->num_rows()>0){
					foreach($findCompaniesIDs->result() as $row){
						$companies[] = $row->companyID;
					}
				}
			}
			
		}
		return $companies;
	}
	
	function getPreSalesBrokerListByLead($leadID){
		$getPersons = $this->db->select("c.*,co.company_name")->from($this->table_contacts.' as c')->join($this->table_presale_broker.' as pb', 'pb.broker_id= c.id')->join($this->table_company.' as co','co.id = c.company_id')->where('pb.lead_id',$leadID)->order_by("c.first_name DESC")->get();
		$persons =array();
		if($getPersons->num_rows()>0){
			foreach ($getPersons->result() as $p) {
				$persons[] = $p;
			}
		}
		return $persons;
	}
	
	function getPreSalesActivity($leadID){
		$userType = $this->session->userdata['type'];
		$getInviteesCompanies = (object)array();
		if($userType<8){					
			$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.pre_sale_activity DESC')->get();
			 
		} else {
			$getInviteesCompanies = $this->db->select("c.*")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.pre_sale_activity DESC')->get();
		}
		$companyData = array();		
		if (is_a($getInviteesCompanies, 'CI_DB_mysqli_result') && $getInviteesCompanies->num_rows() > 0) {
            foreach ($getInviteesCompanies->result() as $row) {
				$getPersons = $this->db->select("c.*,co.company_name")->from($this->table_contacts.' as c')->join($this->table_presale_broker.' as pb', 'pb.broker_id= c.id')->join($this->table_company.' as co','co.id = c.company_id')->where("pb.company_id",$row->id)->where('pb.lead_id',$leadID)->order_by("c.first_name DESC")->get();
				$persons =array();
				if($getPersons->num_rows()>0){
					foreach ($getPersons->result() as $p) {
						$persons[] = $p;
					}
				}
				$activities = array();
				$getActivities = $this->db->select("s.*,c.first_name as firstName, c.last_name as lastName")->from($this->table_presales_activity." as s")->join($this->table_contacts.' as c','c.id = s.contact_id')->where('s.company_id',$row->id)->where('lead_id',$leadID)->order_by('s.activity_date DESC')->get();
				if($getActivities->num_rows()>0){
					foreach ($getActivities->result() as $a) {
						$email = array();
						if($a->email_id>0){
							$email = $this->findBoxNewById($a->email_id);
						}
						$a->email = $email;
						$activities[] = $a;
					}
				}
				/*$row->broker_details = $this->findBrokerDetails($row->broker);*/
				
				$companyData[]=array("company"=>$row,"people"=>$persons,"activities"=>$activities);
			}
		}
		return $companyData;
	}
	
	function getAllCompanyActivities($data){
		$returnData = array();
		$getInviteesCompanies = $this->db->select("c.*")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$data['lead'])->order_by('i.pre_sale_activity DESC')->get();
		if (is_a($getInviteesCompanies, 'CI_DB_mysqli_result') && $getInviteesCompanies->num_rows() > 0) {
			foreach ($getInviteesCompanies->result() as $row) {
				$activities = array();
				$getActivities = $this->db->select("s.*,c.first_name as firstName, c.last_name as lastName")->from($this->table_sales_activity." as s")->join($this->table_contacts.' as c','c.id = s.contact_id')->where('s.company_id',$row->id)->where('lead_id',$data['lead'])->order_by('s.activity_date DESC')->get();
				/*echo $this->db->last_query()."<br/>";*/
				if($getActivities->num_rows()>0){
					foreach ($getActivities->result() as $a) {
						$email = array();
						if($a->email_id>0){
							$email = $this->findBoxNewById($a->email_id);
						}
						$a->email = $email;
						$activities[] = $a;
					}
				}
				$returnData[] = array("list"=>$activities,'company_id'=>$row->id,'lead'=>$data['lead'],'t'=>$data['t']);
			}
		}		
		return $returnData;
	}
	
	function getOtherSalesActivityLead($data){
		$activities = array();
		$getActivities = $this->db->select("s.*,c.first_name as firstName, c.last_name as lastName")->from($this->table_sales_activity." as s")->join($this->table_contacts.' as c','c.id = s.contact_id')->where('s.company_id',$data['c'])->where('lead_id',$data['lead'])->order_by('s.activity_date DESC')->get();
		/*echo $this->db->last_query()."<br/>";*/
		if($getActivities->num_rows()>0){
			foreach ($getActivities->result() as $a) {
				$email = array();
				if($a->email_id>0){
					$email = $this->findBoxNewById($a->email_id);
				}
				$a->email = $email;
				$activities[] = $a;
			}
		}
		return $activities;
	}
	
	function checkCompaniesNotInInvitees($list, $leadID){
		$query = $this->db->select('c.id')->from($this->table_customer_license_agreements.' as cl ')->join($this->company.' as c ','c.id = cl.target_company_id')->join($this->table_invitees.' as i ','cl.target_company_id = i.contact_id ', 'left')->where('cl.lead_id', $leadID)->where_in('cl.target_company_id', $list)->where('i.id IS NULL')->get();
		$data  = array();
		if($query->num_rows() > 0) {
			$data = $query->result();
		}
		return $data;
	}
	
	function getSalesActivity($leadID){
		$userType = $this->session->userdata['type'];
		$getInviteesCompanies = (object)array();
		if($userType<8){
			$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC ,c.company_name ASC')->get();
		} else {
			$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC ,c.company_name ASC')->get();
		}
		$companyData = array();		
		if (is_a($getInviteesCompanies, 'CI_DB_mysqli_result') && $getInviteesCompanies->num_rows() > 0) {
            foreach ($getInviteesCompanies->result() as $row) {
				$getPersons = $this->db->select("*")->from($this->table_contacts)->where("company_id",$row->id)->order_by("first_name DESC")->get();
				/*echo $this->db->last_query()."<br/>";*/
				$persons =array();
				if($getPersons->num_rows()>0){
					$persons = $getPersons->result();
				}
				$activities = array();
				$getActivities = $this->db->select("s.*,c.first_name as firstName, c.last_name as lastName")->from($this->table_sales_activity." as s")->join($this->table_contacts.' as c','c.id = s.contact_id')->where('s.company_id',$row->id)->where('lead_id',$leadID)->order_by('s.activity_date DESC')->limit(1)->get();
				/*echo $this->db->last_query()."<br/>";*/
				if($getActivities->num_rows()>0){
					foreach ($getActivities->result() as $a) {
						$email = array();
						if($a->email_id>0){
							$email = $this->findBoxNewById($a->email_id);
						}
						$a->email = $email;
						$activities[] = $a;
					}
				}
				/*$row->broker_details = $this->findBrokerDetails($row->broker);*/
				
				$companyData[]=array("company"=>$row,"people"=>$persons,"activities"=>$activities);
			}
		}
		return $companyData;
	}	
	
	function runQuery($query){
		$this->db->query($query);
		return $this->db->affected_rows();
	}
	
	function getAcquisitionActivity($leadID,$type=0){
		if($type>0){
			$userType = $type;
		} else {
			$userType = $this->session->userdata['type'];
		}		
		$getInviteesCompanies = (object)array();
		if($userType<8){
			/*Get only those leads which are assigned to user*/
			$findUserEmail = $this->db->select('u.email')->from($this->table.' as u')->where('u.id',$this->session->userdata['type'])->get()->row()->email;
			if(!empty($findUserEmail) && $findUserEmail!=null){
				$getContactDetails = $this->db->select('c.company_id')->from($this->table_contacts.' as c')->where('trim(c.email)',$findUserEmail)->get();
				if($getContactDetails->num_rows()>0){
					$contact = $getContactDetails->first_row();
					$findAllContactsBelongsToContactCompany = $this->db->select("c.id")->from($this->table_contacts.' as c')->where("c.company_id",$contact->company_id)->get();
					$allContacts = array();
					if($findAllContactsBelongsToContactCompany->num_rows()>0){
						$allContacts = $findAllContactsBelongsToContactCompany->result();
						if(count($allContacts)>0){
							$findCompanyAssociateToThisContacts = $this->findCompaniesAssociate($allContacts);
							$findCompanyAssociateToThisContacts[] = $contact->company_id;
							if(count($findCompanyAssociateToThisContacts)>0){
								$companies = implode(',',$findCompanyAssociateToThisContacts);
								$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_acquisition_company.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->where('c.id IN ('.$companies.')')->order_by('i.last_activity DESC, c.company_name ASC')->get();
							}
						}
					}
				}
			}			
		} else {
			$getInviteesCompanies = $this->db->select("c.*,i.stage")->from($this->table_acquisition_company.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC ,c.company_name ASC')->get();
		}
		/*echo $this->db->last_query();*/
		$companyData = array();
		if (is_a($getInviteesCompanies, 'CI_DB_mysqli_result') && $getInviteesCompanies->num_rows() > 0) {
            foreach ($getInviteesCompanies->result() as $row) {
				$getPersons = $this->db->select("id,company_id,job_title,first_name,last_name,email,secondary_email,tertiary_email,linkedin_url,phone,telephone,gateway,no_contact,new_email,new_phone,new_linkedin,c_c,proximity,company_tel,new_telephone,new_company,active_email")->from($this->table_contacts)->where("company_id",$row->id)->order_by("first_name ASC")->get();
				$persons =array();
				if($getPersons->num_rows()>0){
					$persons = $getPersons->result();
				}
				$activities = array();
				$getActivities = $this->db->select("s.*,c.first_name as firstName, c.last_name as lastName")->from($this->table_acquisition_activity." as s")->join($this->table_contacts.' as c','c.id = s.contact_id')->where('s.company_id',$row->id)->where('lead_id',$leadID)->order_by('s.activity_date DESC')->get();
				if($getActivities->num_rows()>0){
					foreach ($getActivities->result() as $a) {
						$email = array();
						if($a->email_id>0){
							$email = $this->findBoxNewById($a->email_id);
						}
						$a->email = $email;
						$activities[] = $a;
					}
				}
				$row->broker_details = $this->findBrokerDetails($row->broker);
				$companyData[]=array("company"=>$row,"people"=>$persons,"activities"=>$activities);
			}
		}
		return $companyData;
	}
	
	function companyListAssignedUser($userID){
		
	}
	
	function findLeadButtonData($leadID,$buttonID){
		$query = $this->db->select("b.id as buttonID,b.button_id,b.type,b.name,b.blink,b.description,b.status_message,b.status_message_click,b.reference_id,l.id,l.status as btnStatus,l.update_date,l.renewable,l.status_message_fill,l.blink as lbblink,l.send_task,b.lead_columns,b.email,b.drive_refrence_id,b.message")->from($this->table_buttons .' as b')->join($this->table_lead_buttons .' as l','l.button_id = b.id')->where('l.lead_id',$leadID)->where('l.id',$buttonID)->order_by('l.sort ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
           $data = $query->first_row();
        }
		return $data;
	}
	
	function checkButtonList($leadID){
		$query = $this->db->select("b.id as buttonID,b.button_id,b.type,b.name,b.blink,b.description,b.status_message,b.status_message_click,b.reference_id,l.id,l.status as btnStatus,l.update_date,l.renewable,l.status_message_fill,l.blink as lbblink,l.send_task,b.lead_columns,b.email,b.drive_refrence_id,b.message")->from($this->table_buttons .' as b')->join($this->table_lead_buttons .' as l','l.button_id = b.id')->where('l.lead_id',$leadID)->order_by('l.sort ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}
	
	function checkDocketButtonList($leadID){
		$query = $this->db->select("b.id as buttonID,b.button_id,b.type,b.name,b.blink,b.description,b.status_message,b.status_message_click,b.reference_id,l.id,l.status as btnStatus,l.update_date,l.renewable,l.status_message_fill,l.blink as lbblink,l.send_task,b.lead_columns,b.email,b.drive_refrence_id,b.message")->from($this->table_buttons .' as b')->join($this->table_docket_buttons .' as l','l.button_id = b.id')->where('l.lead_id',$leadID)->order_by('l.sort ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		
		return $data;
	}
	
	function findButtonByButtonID($type,$buttonID){
		$query = $this->db->select('*')->from($this->table_buttons)->where('type',$type)->where('button_id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findLeadButtonByButtonID($leadID,$buttonID){
		$query = $this->db->select('*')->from($this->table_lead_buttons)->where('lead_id',$leadID)->where('button_id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		/*echo $this->db->last_query();*/
		return $data;
	}
	
	function findLeadButtonByID($leadID,$buttonID){
		$query = $this->db->select('*')->from($this->table_lead_buttons)->where('lead_id',$leadID)->where('id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findDocketButtonByID($leadID,$buttonID){
		$query = $this->db->select('*')->from($this->table_docket_buttons)->where('lead_id',$leadID)->where('id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findOriginalButtonByButtonID($buttonID){
		$query = $this->db->select('*')->from($this->table_buttons)->where('id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findButtonID($buttonID,$leadID){
		$query = $this->db->select('*')->from($this->table_lead_buttons)->where('lead_id',$leadID)->where('id',$buttonID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	public function updateButton($data,$id)
    {
        $this->db->where('id',$id)->update($this->table_lead_buttons,$data);
		return $this->db->affected_rows();	
    }
	
	public function updateButtonBID($data,$id)
    {
        $this->db->where('button_id',$id)->update($this->table_lead_buttons,$data);
		return $this->db->affected_rows();
    }
	
	function updateDocketButtonBID($data,$id){
		$this->db->where('button_id',$id)->update($this->table_docket_buttons,$data);		
		return $this->db->affected_rows();
	}
	
	public function insertPreContacts($data){
		 $this->db->insert($this->table_precontacts,$data);
		return $this->db->insert_id();
	}
	
	public function updatePreContactsByLinkedInUrl($data,$url){
		$this->db->where('profile_url',$url)->update($this->table_precontacts,$data);
		return $this->db->affected_rows();
	}
	
	public function insertPreCompanies($data){
		 $this->db->insert($this->table_precompanies,$data);
		return $this->db->insert_id();
	}
	
	public function updatePreCompanies($data,$id){
		$this->db->where('id',$id)->update($this->table_precompanies,$data);
		return $this->db->affected_rows();
	}
	
	public function updateAcquisition($data,$leadID){
		$this->db->where('lead_id',$leadID)->update($this->table_acquisition,$data);
		return $this->db->affected_rows();
	}
	
	public function updateCompany($data,$id){
		$this->db->where('id',$id)->update($this->table_company,$data);
		return $this->db->affected_rows();
	}
	
	public function updatePreContacts($data,$id){
		$this->db->where('id',$id)->update($this->table_precontacts,$data);
		return $this->db->affected_rows();
	}
	
	public function updatePreContactByFullContact($id,$data){
		$this->db->where('fullcontact',$id)->update($this->table_precontacts,$data);
		return $this->db->affected_rows();
	}
	
	public function updateContactByFullContact($id,$data){
		$this->db->where('fullcontact',$id)->update($this->table_contacts,$data);
		return $this->db->affected_rows();
	}
	public function updateContact($data,$id){
		$this->db->where('id',$id)->update($this->table_contacts,$data);
		return $this->db->affected_rows();
	}
	
	public function deleteContact($id){
		$this->db->where('id',$id)->delete($this->table_contacts);
		return $this->db->affected_rows();
	}
	
	public function delete_user_activity_by_ids($ids){
		$this->db->where_in('id',$ids)->delete($this->table_activity_log);
		return $this->db->affected_rows();
	}
	
	public function delete_user_activity_by_contactsIds($contactIDs){
		$this->db->where_in('contact_id',$contactIDs)->delete($this->table_activity_log);
		return $this->db->affected_rows();
	}
	
	public function delete_user_activity_by_emailID($emailID){
		$this->db->where_in('email_id',$emailID)->delete($this->table_activity_log);
		return $this->db->affected_rows();
	}
	
	public function delete_user_acquisition_activity_by_ids($ids){
		$this->db->where_in('id',$ids)->delete($this->table_acquisition_activity);
		return $this->db->affected_rows();
	}
	
	public function delete_user_acquisition_activity_by_contactsIds($contactIDs){
		$this->db->where_in('contact_id',$contactIDs)->delete($this->table_acquisition_activity);
		return $this->db->affected_rows();
	}
	
	public function delete_user_sales_activity_by_ids($ids){
		$this->db->where_in('id',$ids)->delete($this->table_sales_activity);
		return $this->db->affected_rows();
	}
	
	public function delete_user_sales_activity_by_contactsIds($contactIDs){
		$this->db->where_in('contact_id',$contactIDs)->delete($this->table_sales_activity);
		return $this->db->affected_rows();
	}

	public function deleteEmailActivityByIds($emailIDs){
		$this->db->where_in('id',$emailIDs)->delete($this->table_box);
		return $this->db->affected_rows();
	}
	
	public function insertLeadButton($data){
       $this->db->insert($this->table_lead_buttons,$data);
       return $this->db->insert_id();
    }
	
	public function insertLeadButtonBulk($bulkData){
		$this->db->insert_batch($this->table_lead_buttons, $bulkData); 
		 return $this->db->insert_id();
	}
	
	public function insertCompanyBatch($bulkData){
		$this->db->insert_batch($this->table_company, $bulkData); 
		 return $this->db->insert_id();
	}
	
	public function insertDocketButton($data){
       $this->db->insert($this->table_docket_buttons,$data);
       return $this->db->insert_id();
    }
	
	public function insertPotentialParticipant($data){
		$this->db->insert($this->table_potential_participates,$data);
       return $this->db->insert_id();
	}
	
	public function insertRequestParticipant($data){
		$this->db->insert($this->table_request_to_participate,$data);
       return $this->db->insert_id();
	}
	
	public function insertCustomerTransaction($data){
		$this->db->insert($this->table_customer_transactions,$data);
       return $this->db->insert_id();
	}
	
	public function updateCustomerTransactionRequest($data,$fileUrl){
		$this->db->where('file',$fileUrl)->update($this->table_customer_transactions,$data);		
		return $this->db->affected_rows();
	}
	
	public function deleteRequestToParticipate($ID){
		$this->db->where('id',$ID)->delete($this->table_request_to_participate);
		return $this->db->affected_rows();
	}
	
	public function deleteCommitments($licenseID){
		$this->db->where('license_id',$licenseID)->delete($this->table_commitments);
		return $this->db->affected_rows();
	}
	
	public function deleteRevisedDocumentByID($ID){
		$this->db->where('id',$ID)->delete($this->table_revised_documents);
		return $this->db->affected_rows();
	}
	
	public function insertRevisedDocument($data){
		$this->db->insert($this->table_revised_documents,$data);
       return $this->db->insert_id();
	}
	
	public function deletePotentialParticipant($ID){
		$this->db->where('id',$ID)->delete($this->table_potential_participates);
		return $this->db->affected_rows();
	}
	
	public function insertCommitment($data){
		$this->db->insert($this->table_commitments,$data);
       return $this->db->insert_id();
	}
	
	public function insertUpromisingParticipants($data){
		$this->db->insert($this->table_participates_unpromising,$data);
       return $this->db->insert_id();
	}
	
	public function insertLicenseGranted($data){
		$this->db->insert($this->table_license_granted,$data);
       return $this->db->insert_id();
	}
	
	public function insertCustomerDealFlow($data){
		$this->db->insert($this->table_customer_deal_flow,$data);
       return $this->db->insert_id();
	}
	
	public function insertCustomerLicenseAgreement($data){
		$this->db->insert($this->table_customer_license_agreements,$data);
       return $this->db->insert_id();
	}
	
	public function insertCustomerLicenseAgreementBatch($bulkData){
		$this->db->insert_batch($this->table_customer_license_agreements, $bulkData); 
		 return $this->db->affected_rows();
	}
	
	public function insertInviteesBatch($bulkData){
		$this->db->insert_batch($this->table_invitees,$bulkData);
		return $this->db->affected_rows();		
	}
	
	public function updateCustomerLicenseAgreementByID($data,$id){
		$this->db->where('id',$id)->update($this->table_customer_license_agreements,$data);	
		return $this->db->affected_rows();
	}
	
	public function updatePotentialData($data,$id){
		$this->db->where('id',$id)->update($this->table_potential_participates,$data);		
		return $this->db->affected_rows();
	}
	
	public function updateRequestParticpantData($data,$id){
		$this->db->where('id',$id)->update($this->table_request_to_participate,$data);		
		return $this->db->affected_rows();
	}
	
	public function updateCheckAvailabilityRequest($data,$id){
		$this->db->where('id',$id)->update($this->table_request_for_check_availabilty,$data);		
		return $this->db->affected_rows();
	}
	
	public function deleteCheckAvailability($ID){
		$this->db->where('id',$ID)->delete($this->table_request_for_check_availabilty);
		return $this->db->affected_rows();
	}
	
	public function deleteFromCustomerLicenseAgreementByUrl($fileUrl){
		$this->db->where('document',$fileUrl)->delete($this->table_customer_license_agreements);
		return $this->db->affected_rows();
	}	
	
	public function deleteRevisedDocumentRequest($ID){
		$this->db->where('id',$ID)->delete($this->table_revised_documents);
		return $this->db->affected_rows();
	}
	
	public function updateCheckAvailabilityRequestByEmail($data,$email){
		$this->db->where('person_email',$email)->update($this->table_request_for_check_availabilty,$data);		
		return $this->db->affected_rows();
	}
	
	public function updateCustomerDealFlow($data,$id){
		$this->db->where('id',$id)->update($this->table_customer_deal_flow,$data);		
		return $this->db->affected_rows();
	}
	
	public function updateDraftRevisedDocumentRequest($data,$id){
		 $this->db->where('id',$id)->update($this->table_draft_revised_documents,$data);		
		return $this->db->affected_rows();
	}
	
	public function updateRevisedDocumentRequest($data,$id){
		 $this->db->where('id',$id)->update($this->table_revised_documents,$data);
		return $this->db->affected_rows();
	}
	
	public function updatePotentialDataByLicense($data,$id){
		 $this->db->where('license_id',$id)->update($this->table_potential_participates,$data);		
		return $this->db->affected_rows();
	}
	
	public function updateDocketButton($data,$id)
    {
        $this->db->where('id',$id)->update($this->table_docket_buttons,$data);		
		return $this->db->affected_rows();
    }
	
	public function findLicenseAgreementByFileUrl($fileUrl,$select='*'){
		$query = $this->db->select($select)->from($this->table_customer_license_agreements)->where('document',$fileUrl)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	public function findCustomerDealFlowByCustomerAndCompanyIDAndleadID($customerID,$availableForCompanyID,$leadID,$licenseType,$select){
		$query = $this->db->select($select)->from($this->table_customer_deal_flow)->where('customer_id',$customerID)->where('lead_id',$leadID)->where('license_type',$licenseType)->where('company_id',$availableForCompanyID)->order_by('id','DESC')->limit(1)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	public function findCustomerDealFlowByUrlAndCustomerID($fileUrl,$customerID,$select='*'){
		$query = $this->db->select($select)->from($this->table_customer_deal_flow)->where('customize_file',$fileUrl)->where('customer_id',$customerID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	public function findDealFlowDataByID($ID,$select='*'){
		$query = $this->db->select($select)->from($this->table_customer_deal_flow)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	public function findCustomerDealFlowByUrl($fileUrl,$select='*'){
		$query = $this->db->select($select)->from($this->table_customer_deal_flow)->where('customize_file',$fileUrl)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function getAllCustomerLicense($select="a.*,lead.lead_name,lead.serial_number,lead.id as leadID,c.company_name,c.id as companyID, t.id as target_company_id,t.company_name as target"){
		$this->db->join($this->table_company.' as t','t.id = a.target_company_id','left');
		$query = $this->db->select($select)->from($this->table_customer_license_agreements.' as a')->join($this->table_company .' as c','c.id = a.company_id')->join($this->table_lead .' as lead','lead.id = a.lead_id')->order_by('id','desc')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function getCustomerDealFlow($select="a.*,lead.lead_name,lead.id as leadID,lead.serial_number,c.email as contactEmail,c.id as contactID,cu.first_name,cu.last_name,cu.id as customerID,cu.company_name as companyName,co.company_name as contactCompanyName,co.id as companyID"){
		$query = $this->db->select($select)->from($this->table_customer_deal_flow.' as a')->join($this->table_lead .' as lead','lead.id = a.lead_id')->join($this->table_customers.' as cu', 'cu.id = a.customer_id')->join($this->table_contacts.' as c ','c.id = cu.contact_id')->join($this->table_company.' as co ','co.id = c.company_id')->order_by('id','desc')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function findAllDisplayPriceData($licenseID,$select,$display = array(1)){
		$query = $this->db->select($select)->from($this->table_potential_participates)->where('license_id',$licenseID)->where('price > ',0)->where_in('display',$display)->order_by('price DESC, create_date ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function findCommitmentsData($licenseID,$select){
		$query = $this->db->select($select)->from($this->table_commitments)->where('license_id',$licenseID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function runAlgoCheckSyndicationAll($licenseID){
		$data = array('particpant_list'=>array(),'license_detail'=>array());
		if ($licenseID > 0) {
			$data['particpant_list'] = $this->findAllDisplayPriceData($licenseID,"price,id",array(0,1));
			$getLicenseQuery = $this->db->select('asking_price,id,serial_number')->from($this->table_licenses)->where('id',$licenseID)->get();
			if ($getLicenseQuery->num_rows() > 0) {
				$data['license_detail'] = $getLicenseQuery->first_row();      
			}
		}
		return $data;
	}
	
	function runAlgoCheckSyndication($ID){
		$data = array('particpant_list'=>array(),'license_detail'=>array());
		$query = $this->db->select('license_id')->from($this->table_potential_participates)->where('id',$ID)->get();
		if ($query->num_rows() > 0) {
			$detail = $query->first_row();
			$data['particpant_list'] = $this->findAllDisplayPriceData($detail->license_id,"price,id",array(0,1));
			$getLicenseQuery = $this->db->select('asking_price,id,serial_number')->from($this->table_licenses)->where('id',$detail->license_id)->get();
			if ($getLicenseQuery->num_rows() > 0) {
				$data['license_detail'] = $getLicenseQuery->first_row();      
			}
		}
		return $data;
	}
	
	function getRevisedDocumentByID($ID,$select="*"){
		$query = $this->db->select($select)->from($this->table_revised_documents)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function deletePotentialParticipantByID($ID){
		$this->db->where('id',$ID);
		$this->db->delete($this->table_potential_participates);
		return $this->db->affected_rows();
	}
	
	function getPotentialDataByID($ID,$select ='*'){
		$query = $this->db->select($select)->from($this->table_potential_participates)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function checkStage($leadID){
		$query = $this->db->select('*')->from($this->table_stage)->where('lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function count_request(){
		$rtp = $this->db->select('count(id) as totalRecords')->from($this->table_request_to_participate)->where('status <',2)->where('customer_id >',0)->get()->row()->totalRecords;
		$revised = $this->db->select('count(id) as totalRecords')->from($this->table_revised_documents)->where('status',1)->get()->row()->totalRecords;
		$checkAvailability = $this->db->select('count(id) as totalRecords')->from($this->table_request_for_check_availabilty)->where('status',1)->where('customer_id >',0)->get()->row()->totalRecords;
		$cr = $this->db->select('count(id) as totalRecords')->from($this->table_customer_request)->where('activation_code','')->where('status',1)->get()->row()->totalRecords;
		return array('rtp'=>$rtp,'rd'=>$revised,'ca'=>$checkAvailability,'cr'=>$cr);
	}
	
	function count_customer_request(){
		$data = $this->db->select('count(id) as totalRecords')->from($this->table_customer_request)->get()->row()->totalRecords;
		return $data;
	}
	
	function findUnPromisedParticipants($leadID=0){
		if($leadID>0){
			$this->db->where('lead.id',$leadID);
		}
		$select="a.*,lead.lead_name,lead.id as leadID,lead.serial_number,c.email as contactEmail,c.id as contactID,co.company_name as contactCompanyName,co.id as companyID,target.id as target_company_id,target.company_name as target_company_name,CONCAT((c.first_name),(' '),(c.last_name)) as person_name";
		$this->db->join($this->table_licenses .' as l','l.id = a.license_id');
		$this->db->join($this->table_lead .' as lead','lead.serial_number = l.serial_number');
		$this->db->join($this->table_customers.' as cu', 'cu.id = a.customer_id');
		$this->db->join($this->table_contacts.' as c ','c.id = cu.contact_id');
		$this->db->join($this->table_company.' as co ','co.id = c.company_id');
		$this->db->join($this->table_company.' as target','target.id = a.company_id','left');
		$data = (object)array('potential'=>array());		
		$query = $this->db->select($select)->from($this->table_participates_unpromising.' as a')->order_by('a.create_date DESC')->get();
		if ($query->num_rows() > 0) {
			$data->potential = $query->result();
        }
		return $data;
	}
	
	function findGrantedLicense($leadID=0){
		if($leadID>0){
			$this->db->where('lead.id',$leadID);
		}
		$select="a.*,lead.lead_name,lead.id as leadID,lead.serial_number,c.email as contactEmail,c.id as contactID,co.company_name as contactCompanyName,co.id as companyID,target.id as target_company_id,target.company_name as target_company_name,CONCAT((c.first_name),(' '),(c.last_name)) as person_name";
		$this->db->join($this->table_licenses .' as l','l.id = a.license_id');
		$this->db->join($this->table_lead .' as lead','lead.serial_number = l.serial_number');
		$this->db->join($this->table_customers.' as cu', 'cu.id = a.customer_id');
		$this->db->join($this->table_contacts.' as c ','c.id = cu.contact_id');
		$this->db->join($this->table_company.' as co ','co.id = c.company_id');
		$this->db->join($this->table_company.' as target','target.id = a.company_id','left');
		$data = (object)array('potential'=>array());		
		$query = $this->db->select($select)->from($this->table_license_granted.' as a')->order_by('a.create_date DESC')->get();
		if ($query->num_rows() > 0) {
			$data->potential = $query->result();
        }
		return $data;
	}
	
	function findPotentialParticipants($leadID=0,$status = array(),$c=0,$t = array()){
		if($leadID>0){
			$this->db->where('lead.id',$leadID);
		}
		$select="a.*,lead.lead_name,lead.id as leadID,lead.serial_number,l.asking_price as upfront,l.expiration_date as deadline,c.email as contactEmail,c.id as contactID,co.company_name as contactCompanyName,co.id as companyID,CONCAT((c.first_name),(' '),(c.last_name)) as person_name";
		$this->db->join($this->table_licenses .' as l','l.id = a.license_id');
		$this->db->join($this->table_lead .' as lead','lead.serial_number = l.serial_number');
		$this->db->join($this->table_customers.' as cu', 'cu.id = a.customer_id');
		$this->db->join($this->table_contacts.' as c ','c.id = cu.contact_id');
		$this->db->join($this->table_company.' as co ','co.id = c.company_id');
		if(count($status)>0){
			$select .=", a.status as participant_status";
			$this->db->where_in('a.status',$status);
		}
		if(count($t)>0){
			$this->db->where_in('a.type',$status);
		}
		if($c==1){
			$this->db->join($this->table_company.' as target','target.id = a.company_id','left');
			$select .=", target.id as target_company_id,target.company_name as target_company_name";
		} else if ($c==2){
			$this->db->join($this->table_acquisition.' as acquisition','acquisition.lead_id = lead.id','left');
			$this->db->join($this->table_company.' as target','target.id = a.company_id','left');
			$select .=", target.id as target_company_id,target.company_name as target_company_name,acquisition.cost_price as cost_price";
		}
		$data = (object)array('potential'=>array());
		
		$query = $this->db->select($select)->from($this->table_potential_participates.' as a')->order_by('a.create_date DESC')->get();
		
		if ($query->num_rows() > 0) {
			$data->potential = $query->result();
        }
		return $data;
	}
	
	function findRequestToParticpants($leadID=0,$t=array(),$tap=0){
		if($leadID>0){
			$this->db->where('lead.id',$leadID);
		}
		$data = (object)array('participant'=>array());
		$select="a.*,lead.lead_name,lead.id as leadID,lead.serial_number,c.email as contactEmail,c.id as contactID,co.company_name as contactCompanyName,co.id as companyID";
		if($tap>0){
			$select .=", target.id as target_company_id, target.company_name as target_company_name";
			$this->db->join($this->table_company.' as target ','target.id = a.company_id','left');
		}
		$select .= ", CONCAT((c.first_name),(' '),(c.last_name)) as person_name, co.company_name as company_name";
		$query = $this->db->select($select)->from($this->table_request_to_participate.' as a')->join($this->table_licenses .' as l','l.id = a.license_id')->join($this->table_lead .' as lead','lead.serial_number = l.serial_number')->join($this->table_customers.' as cu', 'cu.id = a.customer_id')->join($this->table_contacts.' as c ','c.id = cu.contact_id')->join($this->table_company.' as co ','co.id = c.company_id')->order_by('a.create_date DESC')->where_in('a.type',$t)->get();
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) {
			$data->participant = $query->result();
        }
		return $data;
	}
	
	function findRevisedDocuments($leadID=0){
		if($leadID>0){
			$this->db->where('lead.id',$leadID);
		}
		$data = (object)array('revised'=>array(),'confirmed_revised'=>array());
		$select="a.*,lead.lead_name,lead.id as leadID,lead.serial_number,c.email as contactEmail,c.id as contactID,CONCAT((c.first_name),(' '),(c.last_name)) as person_name,co.company_name as contactCompanyName,co.id as companyID,target.company_name as target_company_name,target.id as target_company_id";
		$this->db->join($this->table_company.' as target','target.id = a.company_id','left');
		$query = $this->db->select($select)->from($this->table_revised_documents.' as a')->join($this->table_licenses .' as l','l.id = a.license_id')->join($this->table_lead .' as lead','lead.serial_number = l.serial_number')->join($this->table_customers.' as cu', 'cu.id = a.customer_id')->join($this->table_contacts.' as c ','c.id = cu.contact_id')->join($this->table_company.' as co ','co.id = c.company_id')->order_by('a.create_date DESC')->where('a.status <=',1)->get();
		if ($query->num_rows() > 0) {
			$data->revised = $query->result();
        }
		$this->db->join($this->table_company.' as target','target.id = a.company_id','left');
		$query = $this->db->select($select)->from($this->table_revised_documents.' as a')->join($this->table_licenses .' as l','l.id = a.license_id')->join($this->table_lead .' as lead','lead.serial_number = l.serial_number')->join($this->table_customers.' as cu', 'cu.id = a.customer_id')->join($this->table_contacts.' as c ','c.id = cu.contact_id')->join($this->table_company.' as co ','co.id = c.company_id')->order_by('a.create_date DESC')->where('a.status > ',1)->get();
		if ($query->num_rows() > 0) {
			$data->confirmed_revised = $query->result();
        }
		return $data;
	}
	
	function checkRequestForAvailability($select="a.*,lead.lead_name,lead.id as leadID,lead.serial_number,c.email as contactEmail,c.id as contactID,co.company_name as contactCompanyName,co.id as companyID,target.company_name as target_company_name,target.id as target_company_id"){
		$data = array('availability'=>array(),'availability_confirmed'=>array());
		$this->db->join($this->table_company.' as target','target.id = a.company_id','left');
		$query = $this->db->select($select)->from($this->table_request_for_check_availabilty.' as a')->join($this->table_licenses .' as l','l.id = a.license_id')->join($this->table_lead .' as lead','lead.serial_number = l.serial_number')->join($this->table_customers.' as cu', 'cu.id = a.customer_id')->join($this->table_contacts.' as c ','c.id = cu.contact_id')->join($this->table_company.' as co ','co.id = c.company_id')->where('a.status',1)->where('a.customer_id > ',0)->order_by('id','desc')->get();
		
		if ($query->num_rows() > 0) {
			$data['availability'] = $query->result();
        }
		$this->db->join($this->table_company.' as target','target.id = a.company_id','left');
		$query = $this->db->select($select)->from($this->table_request_for_check_availabilty.' as a')->join($this->table_licenses .' as l','l.id = a.license_id')->join($this->table_lead .' as lead','lead.serial_number = l.serial_number')->join($this->table_customers.' as cu', 'cu.id = a.customer_id')->join($this->table_contacts.' as c ','c.id = cu.contact_id')->join($this->table_company.' as co ','co.id = c.company_id')->where('a.status',2)->where('a.customer_id > ',0)->order_by('id','desc')->get();
		if ($query->num_rows() > 0) {
			$data['availability_confirmed'] = $query->result();
        }
		return $data;
	}
	
	function findRequestToParticipantById($ID,$select="*"){
		$query = $this->db->select($select)->from($this->table_request_to_participate)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findDraftRevisedDocumentRequest($ID,$select="*"){
		$query = $this->db->select($select)->from($this->table_draft_revised_documents)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	
	
	function findRequestFromDockets($licenseID){
		$data = array('request'=>0,'min_price'=>0,'participants'=>0,'regular'=>0,'late'=>0);
		
		$getSerialNumber = 0;
		$getAskingPrice = 0;
		$active_button = 0;
		$licenseQuery = $this->db->select('serial_number,asking_price,active_button')->from($this->table_licenses)->where('id',$licenseID)->get();
		if($licenseQuery->num_rows()>0){
			$licenseData = $licenseQuery->first_row();
			$getSerialNumber = $licenseData->serial_number;
			$getAskingPrice = $licenseData->asking_price;
			$active_button = $licenseData->active_button;
		}
		if($getSerialNumber!=null && $getSerialNumber>0){
			$documentsR = 0;
			if($active_button > 1) {
				$documentsR = $this->db->select('count(id) as requestCount')->from($this->table_revised_documents)->where('license_id',$licenseID)->get()->row()->requestCount;
			}			
			$partipantsR = $this->db->select('count(id) as requestCount')->from($this->table_request_to_participate)->where('license_id',$licenseID)->where('status <>',2)->get()->row()->requestCount;
			if($partipantsR==null){
				$partipantsR = 0;
			}
			if($documentsR==null){
				$documentsR = 0;
			}
			$data['request'] = $partipantsR + $documentsR;
			$getLeadID = $this->db->select('id')->from($this->table_lead)->where('serial_number',$getSerialNumber)->get()->row()->id;
			if($getLeadID!=null && $getLeadID>0){
				$getLicensingDateData = $this->getAcquisitionData($getLeadID,'a.option_expiration_data,a.regular_license_starts,a.late_license_starts,a.cost_price,final_participants');
				/*Participants*/
				$participantDate = $getLicensingDateData->option_expiration_data;
				$regularLicenseDate = $getLicensingDateData->regular_license_starts;
				$lateLicenseDate = $getLicensingDateData->late_license_starts;
				$costPrice = $getLicensingDateData->cost_price;
				$participants = $getLicensingDateData->final_participants;
				/*$participants = $this->db->select('count(id) as participants')->from($this->table_potential_participates)->where('license_id',$licenseID)->where('date_format(create_date,"%Y-%m-%d") <= ',date('Y-m-d',strtotime($participantDate)))->get()->row()->participants;*/
				if($participants==null){
					$participants = 0;
				}
				$data['participants'] = $participants;
				if($getAskingPrice>0 && $participants>0){
					$data['min_price'] = (float)($getAskingPrice/$participants);
				}			
				if($costPrice>0){
					$regular = $this->db->select('count(id) as regular')->from($this->table_license_granted)->where('license_id',$licenseID)->where('date_format(create_date,"%Y-%m-%d") > ',date('Y-m-d',strtotime($participantDate)))->where('date_format(create_date,"%Y-%m-%d") < ',date('Y-m-d',strtotime($lateLicenseDate)))->get()->row()->regular;
					if($regular==null){
						$regular = 0;
					}
					$data['regular'] = $regular;
					
					$late = $this->db->select('count(id) as late')->from($this->table_license_granted)->where('license_id',$licenseID)->where('date_format(create_date,"%Y-%m-%d") >= ',date('Y-m-d',strtotime($lateLicenseDate)))->get()->row()->late;
					if($late==null){
						$late = 0;
					}
					$data['late'] = $late;
				}
				
			}
		}		
		return $data;
	}
	
	function findDraftRevisedDocumentRequestFromUserList($customerIDs,$licenseID = 0,$select="*"){
		$data = array();
		if(count($customerIDs)>0){
			if($licenseID>0){
				$this->db->where('license_id',$licenseID);
			}
			$query = $this->db->select($select)->from($this->table_draft_revised_documents)->where_in('customer_id',$customerIDs)->get();			
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}    
			}
		}	
		return $data;	
	}
	
	
	function findCustomerTransactionFromUserList($customerIDs,$licenseID = 0,$select="*"){
		$data = array();
		if(count($customerIDs)>0){
			if($licenseID>0){
				$this->db->where('lead_id IN (SELECT id FROM '.$this->table_lead.' WHERE serial_number = (SELECT serial_number FROM '.$this->table_licenses.' WHERE id='.$licenseID.'))');
			}
			$query = $this->db->select($select)->from($this->table_customer_transactions)->where_in('customer_id',$customerIDs)->get();			
			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$data[] = $row;
				}    
			}
		}	
		return $data;	
	}
	
	function findCustomerTrasactionDataByFileUrl($fileUrl,$select){		
		$query = $this->db->select($select)->from($this->table_customer_transactions)->where('file',$fileUrl)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findRequestFromCheckAvailability($ID,$select="*"){
		$query = $this->db->select($select)->from($this->table_request_for_check_availabilty)->where('id',$ID)->get();
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
	
	function checkOpenProjectDataByContactID($leadID,$contact_id,$type){		
		$query = $this->db->select('*')->from($this->table_lead_open_project)->where('contact_id',$contact_id)->where('lead_id',$leadID)->where('type',$type)->order_by('id','desc')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function checkOpenProjectData($leadID,$type){		
		$query = $this->db->select('*')->from($this->table_lead_open_project)->where('lead_id',$leadID)->where('type',$type)->order_by('id','desc')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function getAcquisitionData($leadID,$select ='a.*'){
		$query = $this->db->select($select)->from($this->table_acquisition.' as a')->where('a.lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	function getPersonCompanyDetailFromAcquisitionActivityLogByEmailID($emailID){
		$query = $this->db->select('contact_id,company_id')->from($this->table_acquisition_activity)->where('email_id',$emailID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function findPersonInAnyActivity($contactID){
		$this->db->limit(1, 0);
		$this->db->order_by('id','DESC');	
		$query = $this->db->select('id')->from($this->table_acquisition_activity)->where('contact_id',$contactID)->get();
		if ($query->num_rows() > 0) {
            return $query->first_row();      
        } else {
			$this->db->limit(1, 0);
			$this->db->order_by('id','DESC');
			$query = $this->db->select('id')->from($this->table_sales_activity)->where('contact_id',$contactID)->get();
			if ($query->num_rows() > 0) {
				return $query->first_row();      
			} else {
				return array();
			}
		}
	}
	
	function getPersonCompanyDetailFromSalesActivityLogByEmailID($emailID){
		$query = $this->db->select('contact_id,company_id,activity_date')->from($this->table_sales_activity)->where('email_id',$emailID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function getAcquisitionActivityLogByID($ID){
		$query = $this->db->select('*')->from($this->table_acquisition_activity)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();  
			$contact = array();
			if($data->contact_id > 0){
				$query = $this->db->select('c.*, co.company_name as company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.id',$data->contact_id)->get();
				//echo $this->db->last_query();
				if ($query->num_rows() > 0) {
					$contact = $query->first_row();         
				}
			}
			$data->contact =$contact;
        }
		return $data;
	}
	
	
	function getSalesActivityLogByID($ID){
		$query = $this->db->select('*')->from($this->table_sales_activity)->where('id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();  
			$contact = array();
			if($data->contact_id > 0){
				$query = $this->db->select('c.*, co.company_name as company_name')->from($this->table_contacts.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.id',$data->contact_id)->get();
				//echo $this->db->last_query();
				if ($query->num_rows() > 0) {
					$contact = $query->first_row();         
				}
			}
			$data->contact =$contact;
        }
		return $data;
	}
	
	function getPersonCompanyDetailFromPreSalesActivityLogByEmailID($emailID){
		$query = $this->db->select('contact_id,company_id')->from($this->table_presales_activity)->where('email_id',$emailID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();      
        }
		return $data;
	}
	
	function getAllCompaniesList($select){
		$data = array();
		$query = $this->db->select($select)->from($this->table_company)->order_by('company_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function findAllDocket(){
		$data = array();
		$query = $this->db->select('DISTINCT(a.lead_id)')->from($this->table_acquisition.' as a')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function deleteScanCard($ID){
		$this->db->where('id',$ID);
		$this->db->update($this->table_scanned_business_card,array('status'=>1));		
		return $this->db->affected_rows();		
	}
	
	function getActiveScannedBusinessCardsList($status){
		$data = array();
		$query = $this->db->select('*')->from($this->table_scanned_business_card)->where('status',$status)->order_by('id','ASC')->get();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function getPreContacts(){
		$data = array();
		/*$this->db->limit(15000,10000);*/
		$query = $this->db->select('*')->from($this->table_precontacts)->order_by('id','ASC')->get();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	function findCompanyInPreContactAndDelete($companyName){
		$this->db->where('company_name',$companyName);
		$this->db->delete($this->table_precompanies);		
		return $this->db->affected_rows();
	}	
	
	function getPreCompanies(){
		$data = array();
		$this->db->limit(0,500);
		$query = $this->db->select('*')->from($this->table_precompanies)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
        }
		return $data;
	}
	
	public function findTempCompanyBySearch($search,$select){
		if(empty($select)){
			$select = "c.company_name as Name";
		}
		$query = $this->db->select($select)->from($this->table_temp_companies.' as c')->order_by('c.company_name','ASC')->like('c.company_name',$search)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data; 
	}
	
	function getAllMergeCompanies($search,$sector,$cat="",$subCat="",$sort='c.company_name',$orderBy='ASC',$start,$end){
		/*truncate table temp*/
		$this->db->query("TRUNCATE ".$this->table_temp_companies);
		/*INSERT DATA FROM  COMPANIES*/
		$this->db->query("INSERT INTO ".$this->table_temp_companies."(`company_name`,`linkedin_name`,`linkedin_url`,`company_type`,`company_id`) SELECT c.company_name,c.linkedin_name,c.linkedin_url,1,c.id FROM ".$this->table_company." as c");
		/*INSERT DATA FROM  PRECOMPANIES*/
		$this->db->query("INSERT INTO ".$this->table_temp_companies."(`company_name`,`linkedin_name`,`linkedin_url`,`company_type`,`company_id`,`ss`) SELECT c.company_name,c.linkedin_name,c.linkedin_url,0,c.id,c.ss FROM ".$this->table_precompanies." as c");		
		
		$data = array('count_all'=>0,'data'=>array());
		$search = trim($search);
		if(!empty($search) && !empty($sector)){
			$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
			$this->db->where('cs.sector_id IN ('.$sector.')');
			if($cat!="" && $subCat!=""){
				try{
					$jsonCat = explode(',',$cat);
					$jsonSubCat = explode(',',$subCat);
					$allTech = array_combine($jsonCat,$jsonSubCat);
					if(count($allTech)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
						$this->db->where_in('p.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($cat!=""){
				try{
					$jsonCat = explode(',',$cat);
					if(count($jsonCat)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
						$this->db->where_in('p.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			$data['count_all'] = $this->db->select("count(distinct(c.id)) as countRecords")->from($this->table_temp_companies.' as c')->where('c.company_name LIKE "%'.$search.'%"')->where('c.company_type',1)->order_by($sort,$orderBy)->get()->row()->countRecords;
			
			if($end>0){
				$this->db->limit($end,$start);
			}
			$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
			$this->db->where('cs.sector_id IN ('.$sector.')');
			if($cat!="" && $subCat!=""){
				try{
					$jsonCat = explode(',',$cat);
					$jsonSubCat = explode(',',$subCat);
					$allTech = array_combine($jsonCat,$jsonSubCat);
					if(count($allTech)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
						$this->db->where_in('p.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($cat!=""){
				try{
					$jsonCat = explode(',',$cat);
					if(count($jsonCat)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
						$this->db->where_in('p.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			$preQuery = $this->db->select("distinct(c.id) as companyID ,c.*")->from($this->table_temp_companies.' as c')->where('c.company_name LIKE "%'.$search.'%"')->where('c.company_type',1)->order_by($sort,$orderBy)->get();
		} else if(empty($search) && !empty($sector)){
			$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
			$this->db->where('cs.sector_id IN ('.$sector.')');
			if($cat!="" && $subCat!=""){
				try{
					$jsonCat = explode(',',$cat);
					$jsonSubCat = explode(',',$subCat);
					$allTech = array_combine($jsonCat,$jsonSubCat);
					if(count($allTech)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
						$this->db->where_in('p.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($cat!=""){
				try{
					$jsonCat = explode(',',$cat);
					if(count($jsonCat)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
						$this->db->where_in('p.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			$data['count_all'] = $this->db->select("count(distinct(c.id)) as countRecords")->from($this->table_temp_companies.' as c')->where('c.company_type',1)->order_by($sort,$orderBy)->get()->row()->countRecords;
			
			if($end>0){
				$this->db->limit($end,$start);
			}
			$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
			$this->db->where('cs.sector_id IN ('.$sector.')');
			if($cat!="" && $subCat!=""){
				try{
					$jsonCat = explode(',',$cat);
					$jsonSubCat = explode(',',$subCat);
					$allTech = array_combine($jsonCat,$jsonSubCat);
					if(count($allTech)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
						$this->db->where_in('p.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($cat!=""){
				try{
					$jsonCat = explode(',',$cat);
					if(count($jsonCat)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
						$this->db->where_in('p.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			$preQuery = $this->db->select("distinct(c.id) as companyID ,c.*")->from($this->table_temp_companies.' as c')->where('c.company_type',1)->order_by($sort,$orderBy)->get();
		} else if($search!="" && empty($sector)){			
			$data['count_all'] = $this->db->select("count(distinct(c.id)) as countRecords")->from($this->table_temp_companies.' as c')->where('c.company_name LIKE "%'.$search.'%"')->order_by($sort,$orderBy)->get()->row()->countRecords;
			
			if($end>0){
				$this->db->limit($end,$start);
			}
			
			if($cat!="" && $subCat!=""){
				try{
					$jsonCat = explode(',',$cat);
					$jsonSubCat = explode(',',$subCat);
					$allTech = array_combine($jsonCat,$jsonSubCat);
					if(count($allTech)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
						$this->db->where_in('p.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($cat!=""){
				try{
					$jsonCat = explode(',',$cat);
					if(count($jsonCat)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
						$this->db->where_in('p.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			$preQuery = $this->db->select("distinct(c.id) as companyID ,c.*")->from($this->table_temp_companies.' as c')->where('c.company_name LIKE "%'.$search.'%"')->order_by($sort,$orderBy)->get();
		} else {
			$data['count_all'] = $this->db->select("count(c.id) as countRecords")->from($this->table_temp_companies.' as c')->order_by($sort,$orderBy)->get()->row()->countRecords;
			/*echo $this->db->last_query()."<br/>";*/
			if($end>0){
				$this->db->limit($end,$start);
			}
			$preQuery = $this->db->select('c.*')->from($this->table_temp_companies.' as c')->order_by($sort,$orderBy)->limit($end,$start)->get();
		}
		$mapSectors = array();
		$dataSectors = array();
		$mapSubSectors = array();
		$dataSubSectors = array();
		if ($preQuery->num_rows() > 0) {			
			foreach($preQuery->result() as $row){ 
				$row->sectorName = "";
				$row->technology_names = "";
				$row->sub_technology_names = "";
				$row->company_users = 0;
				$row->department_names = "";
				$row->sub_department_names = "";
				if($row->company_type==1){
					$sectorsList = $this->getAllCompanySectors(array($row->id));
					if(count($sectorsList)>0){
						foreach($sectorsList as $sector){
							$row->sectorName .= $sector->sectorName.", ";
						}
						$row->sectorName = substr($row->sectorName,0,-2);
					}
					$usersList = $this->getCountAllContactBelongToCompany($row->id);
					$departments = $this->findMyPreferenceWithNameSub(array($row->id),0);
					$deptNames = "";
					if(count($departments)>0){
						foreach($departments as $deptt){
							if(!in_array($deptt->id,$mapSectors)){
								$mapSectors[] = $deptt->id;
								$dataSectors[] = array('id'=>$deptt->id,'name'=>$deptt->name);
							}
							$deptNames .= $deptt->name.", ";
						}
						$deptNames= substr($deptNames,0,-1);
					}
					$subdepartments = $this->findMyPreferenceWithNameSub(array($row->id),1);
					$subdeptNames = "";
					if(count($subdepartments)>0){
						foreach($subdepartments as $deptt){
							if(!in_array($deptt->id,$mapSectors)){
								$mapSubSectors[] = $deptt->id;
								$dataSubSectors[] = array('id'=>$deptt->id,'name'=>$deptt->name);
							}
							$subdeptNames .= $deptt->name.", ";
						}
						$subdeptNames= substr($subdeptNames,0,-1);
					}
					$technologies = $this->findTechnologiesPreferenceWithNameSub($row->id,0);
					$technologyNames = "";
					if(count($technologies)>0){
						foreach($technologies as $tech){
							$technologyNames .= $tech->name.", ";
						}
						$technologyNames= substr($technologyNames,0,-2);
					}
					$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,1);
					$subTechnologyNames = "";
					if(count($subTechnologies)>0){
						foreach($subTechnologies as $tech){
							$subTechnologyNames .= $tech->name.", ";
						}
						$subTechnologyNames= substr($subTechnologyNames,0,-2);
					}
					$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,2);				
					if(count($subsubTechnologies)>0){
						foreach($subsubTechnologies as $tech){
							$subTechnologyNames .= $tech->name.", ";
						}
						$subTechnologyNames= substr($subTechnologyNames,0,-2);
					}
					$row->technology_names = $technologyNames;
					$row->sub_technology_names = $subTechnologyNames;
					$row->company_users = $usersList;
					$row->department_names = $deptNames;
					$row->sub_department_names = $subdeptNames;
				}
				$data['data'][] = $row;				
			}
		}
		$data['cat'] = $dataSectors;
		$data['sub_cat'] = $dataSubSectors;
		return $data;
	}
	
	public function findTechnologiesPreferenceWithNameSub($companyID,$type){
		$query = $this->db->select("c.*")->from($this->table_technology_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.company_id",$companyID)->where('c.type',$type)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data; 
	}
	
	function getAllPreCompaniesWithOther(){
		$data = array();
		$data['pre_contacts'] = $this->getPreCompanies();	
		$data['contacts'] = $this->getAllCompaniesWithUsers();
		$data['linkedin_query'] = $this->getLinkedinQueryData();
		return $data;
	}
	
	function getCountAllContactBelongToCompany($companyID){
		return $this->db->select("count(c.id) as countUsers")->from($this->table_contacts.' as c')->where('c.company_id',$companyID)->get()->row()->countUsers;
	}
	
	function getAllCompaniesWithUsers(){
		$query = $this->db->select("co.*")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('co.company_name','ASC')->get();
		$data = array();
		$allCompaniesList = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$allCompaniesList[] = $row->id;
				$data[] = $row;
			}
		}
		if(count($allCompaniesList)>0){
			$companies_sectors = $this->getAllCompanySectors($allCompaniesList);
			$departments = $this->findMyPreferenceWithNameSub($allCompaniesList,0);
			$subdepartments = $this->findMyPreferenceWithNameSub($allCompaniesList,1);
			$userslist = $this->getAllContactBelongToCompanies($allCompaniesList);
			for($i=0;$i<count($data);$i++){
				$sectors = "";
				if(count($companies_sectors)>0){
					foreach($companies_sectors as $companySector){
						if($data[$i]->id==$companySector->company_id){
							$sectors .= $companySector->sectorName.", ";
						}
					}
				}
				$sectors = substr($sectors,0,-2);
				$data[$i]->sectorName = $sectors;
				$categories = "";
				if(count($departments)>0){
					foreach($departments as $department){
						if($data[$i]->id==$department->company_id){
							$categories .= $department->name.", ";
						}
					}
				}
				$categories = substr($categories,0,-2);
				$data[$i]->department_names = $categories;
				$subcategories = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $subdepartment){
						if($data[$i]->id==$subdepartment->company_id){
							$subcategories .= $subdepartment->name.", ";
						}
					}
				}
				$subcategories = substr($subcategories,0,-2);
				$data[$i]->sub_department_names = $subcategories;
				$companyUser = array();
				if(count($userslist)>0){
					foreach($userslist as $user){
						if($data[$i]->id==$user->company_id){
							$companyUser[] = $user;
						}
					}
				}
				$data[$i]->company_users = $companyUser;
			}
		}
		
		return $data;
	}
	
	function getAllContactBelongToCompanies($companiesIDs){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name")->from($this->table_contacts.' as c')->where_in('c.company_id',$companiesIDs)->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	function getAllCompanySectors($companyIDs){
		$data = array();
		if(($companyIDs)>0){
			$query = $this->db->select("s.name as sectorName, s.id as sectorID,cs.company_id")->from($this->table_company_sector.' as cs')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where_in('cs.company_id',$companyIDs)->get();
			$data = $query->result();
		}
		return $data;
	}
	
	public function findMyPreferenceWithNameSub($customerIDs,$type){
		$query = $this->db->select("c.*,p.customer_id as company_id")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where_in("p.customer_id",$customerIDs)->where('c.type',$type)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data; 
	}
	
	function getLitigationScrap(){
		$data = array();
		$query = $this->db->select('*')->from($this->table_litigation_scrap)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function getFreePreContacts(){
		$data = array();
		$query = $this->db->select('*')->from($this->table_free_precontacts)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
		
	function deletePreContact($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_precontacts);
		return $this->db->affected_rows();
	}
	
	function delete_all_precontacts(){
		$this->db->where('id >0');
		$this->db->delete($this->table_precontacts);
		return $this->db->affected_rows();
	}
	
	function deletePreCompany($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_precompanies);
		return $this->db->affected_rows();
	} 
	
	function deleteTempCompany($id){
		$this->db->where('company_id',$id);
		$this->db->delete($this->table_temp_companies);
		return $this->db->affected_rows();
	}
	
	function deleteCompany($id){
		$this->db->where('id',$id);
		$this->db->delete($this->table_company);
		return $this->db->affected_rows();
	}
	
	function deleteApprovalRequest($leadID){
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_requests);
	}
	
	function deleteHistory($leadID){
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_history);
	}
	function deleteLeadButtons($leadID){
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_lead_buttons);
	}
	
	function deleteSalesActivity($emailID){
		$this->db->where('email_id',$emailID);
		$this->db->delete($this->table_sales_activity);
	}
	
	function deleteAcquisitionActivity($emailID){
		$this->db->where('email_id',$emailID);
		$this->db->delete($this->table_acquisition_activity);
	}
	
	function deleteLeadPatentParentData($leadID){
		$queryLeadPatent = $this->db->select('patent_number,id')->from($this->table_lead_patent)->where('lead_id',$leadID)->get();
		$data = array();	
		if ($queryLeadPatent->num_rows() > 0) {  
			$patentNumbers = array();
			foreach ($queryLeadPatent->result() as $row) {  
				$patentNumbers[] = $row->patent_number;
			}
			$this->db->where_in('parent_number',$patentNumbers);
			$this->db->delete($this->table_lead_patent_family);
			$this->db->where('lead_id',$leadID);
			$this->db->delete($this->table_lead_patent);
			$this->db->where('lead_id',$leadID);
			$this->db->delete($this->table_lead_patent_scrap_data);
		}
	}
	
	function emptyIllustrationTable($patentList){
		$this->db->where_in('patent_id',$patentList);
		$this->db->delete($this->table_due_dilligence_illustrations);
	}
	
	function getAllUserHistory($userID,$leadID=0,$opportunity_id=0){
		$query = "";	
		if($leadID==0 && $opportunity_id==0){	
			$query = $this->db->select('h.message,h.id,h.create_date,u.name,u.id as userID,u.profile_pic,l.id as leadID,l.lead_name,l.plantiffs_name,l.type as leadType')->from($this->table_history.' as h')->join($this->table_lead.' as l ', 'l.id=h.lead_id')->join($this->table.' as u','u.id = h.user_id')->where('h.user_id',$userID)->order_by('h.id','DESC')->get();
		} else if($leadID>0 && $opportunity_id==0){	
			$query = $this->db->select('h.message,h.id,h.create_date,u.name,u.id as userID,u.profile_pic,l.id as leadID,l.lead_name,l.plantiffs_name,l.type as leadType')->from($this->table_history.' as h')->join($this->table.' as u','u.id = h.user_id')->join($this->table_lead.' as l ', 'l.id=h.lead_id')->where('h.lead_id',$leadID)->order_by('h.id','DESC')->get();
		} else {
			$query = $this->db->select('h.message,h.id,h.create_date,u.name,u.id as userID,u.profile_pic,l.id as leadID,l.lead_name,l.plantiffs_name,l.type as leadType')->from($this->table_history.' as h')->join($this->table_lead.' as l ', 'l.id=h.lead_id')->join($this->table_assign_lead.' aa a ', 'a.lead_id=h.lead_id')->join($this->table.' as u','u.id = h.user_id')->where('l.status','2')->where('h.lead_id',$leadID)->order_by('h.id','DESC')->get();
		}	
		$data = array();	
		if ($query->num_rows() > 0) {  
			foreach ($query->result() as $row) {  
				$data[] = $row; 
			}
		}
		return $data;
	}
	public function getLitigationComments($litigationID,$type){
		$query = $this->db->select('c.id,c.comment1,c.comment2,c.comment3,c.attractive,c.user_id,c.created,c.updated,u.name,u.email')->from('other_comments as c')->where('c.parent_id',$litigationID)->where('c.type',$type)->join('users as u','u.id=c.user_id','left outer')->order_by('c.id','DESC')->get();
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }            
        }
		return $data;
	}
	
	public function from_litigation_comment($data){
		// Inserting in Table(Litigation) 
		$this->db->insert($this->table_comment, $data);
		return $this->db->insert_id();
	}
	
	public function updateLeadStatus($data){
		$this->db->where('id', $data['id']);
		unset($data['id']);
		$this->db->update($this->table_lead,$data);	
		return $this->db->affected_rows();
	}
	
	public function updateLeadColumnHeading($data){
		$this->db->where('column_name', $data['column_name']);
		unset($data['column_name']);
		$this->db->update($this->table_lead_headings,$data);	
		return $this->db->affected_rows();
	}	
	
	public function from_litigation_update_comment($data){
        $id = $data['id'];
		unset($data['id']);
		$this->db->where('id', $id);		
		$this->db->update($this->table_comment,$data);	
		return $id;	
	}
	
	function getLeadColumnHeadings(){
		$query = $this->db->select('l.*')->from($this->table_lead_headings .' as l')->get();       
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function userLeadTeamNote($leadID,$userID){
		$data = array();
		$query = $this->db->select('*')->from($this->table_comment)->where('parent_id',$leadID)->where('user_id',$userID)->get();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function from_litigation_update_comment_by_lead($leadID,$data){
		$this->db->where('parent_id', $leadID);		
		$this->db->update($this->table_comment,$data);	
		return $this->db->affected_rows();	
	}
	
	public function findLeadByType($leadType){
		$query = $this->db->select('l.*')->from($this->table_lead .' as l')->where('l.type',$leadType)->get();       
		$data = array();
		if ($query->num_rows() > 0) {
           foreach($query->result() as $row){
				$data[] = $row;
			}
        }
		return $data;
	}
	
	public function findLeadFromLicenseID($licenseID,$select){
		$data = array();
		$query = $this->db->select($select)->from($this->table_licenses.' as li')->join($this->table_lead.' as l','l.serial_number = li.serial_number')->where('li.id',$licenseID)->get();
		if ($query->num_rows() > 0) {
			$data = $query->first_row();
        }
		return $data;
	}
	
	public function findLicenseFromLeadID($leadID,$select){
		$data = array();
		$query = $this->db->select($select)->from($this->table_licenses.' as li')->join($this->table_lead.' as l','l.serial_number = li.serial_number')->where('l.id',$leadID)->get();
		if ($query->num_rows() > 0) {
			$data = $query->first_row();
        }
		return $data;
	}
	
	public function getLicenseData($serialNumber,$select="li.*"){
		$data = array();
		$query = $this->db->select($select)->from($this->table_licenses.' as li')->where('li.serial_number',$serialNumber)->get();
		if ($query->num_rows() > 0) {
			$data = $query->first_row();
        }
		return $data;
	}
	
	public function getLeadDataWithOptions($leadID,$select){
		$query = $this->db->select($select)->from($this->table_lead .' as l')->where('l.id',$leadID)->get();
       
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	public function getLeadData($leadID){
		$query = $this->db->select('l.*,u.name')->from($this->table_lead .' as l')->join('users as u', 'u.id = l.user_id')->where('l.id',$leadID)->get();
       
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	public function findSerialNumber($serialNumber){
		$query = $this->db->select('l.*')->from('litigations as l')->where('l.serial_number',trim($serialNumber))->get();
		
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	public function getDocketIntroImagesWithFields($serialNumber){
		$query = $this->db->select('li.file_left,li.file_middle,li.file_right,li.file_four,li.file_five,li.file_six,li.file_seven,li.file_eight,li.file_nine,li.file_ten,li.file_eleven,li.file_twelve,li.file_thirteen,li.file_fourteen,li.file_fiveteen,li.file_sixteen,li.file_seventeen,li.file_eighteen,li.file_nineteen,li.file_twenty,li.file_twentyone,li.file_twentytwo,li.file_twentythree,li.file_twentyfour,li.file_twentyfive,li.file_twentysix,li.file_twentyseven,li.file_twentyeight,li.file_twentynine,li.file_thirty,li.file_thirtyone,li.file_thirtytwo,li.show_linkedin_images')->from($this->table_licenses.' as li','l.serial_number=li.serial_number','left')->where('li.serial_number',trim($serialNumber))->get();	
		$getDueData = array();
		if ($query->num_rows() > 0) {
			$getDueData = $query->first_row();
		}
		return $getDueData;
	}
	
	public function getDocketIntroImages($serialNumber){
		$query = $this->db->select('li.file_left,li.file_middle,li.file_right,li.file_four,li.file_five,li.file_six,li.file_seven,li.file_eight,li.file_nine,li.file_ten,li.file_eleven,li.file_twelve,li.file_thirteen,li.file_fourteen,li.file_fiveteen,li.file_sixteen,li.file_seventeen,li.file_eighteen,li.file_nineteen,li.file_twenty,li.file_twentyone,li.file_twentytwo,li.file_twentythree,li.file_twentyfour,li.file_twentyfive,li.file_twentysix,li.file_twentyseven,li.file_twentyeight,li.file_twentynine,li.file_thirty,li.file_thirtyone,li.file_thirtytwo,li.show_linkedin_images')->from($this->table_licenses.' as li','l.serial_number=li.serial_number','left')->where('li.serial_number',trim($serialNumber))->get();	
		$data = array();
		if ($query->num_rows() > 0) {
			$getDueData = $query->first_row();
			if(!empty($getDueData->file_left)){
				$data[] = $getDueData->file_left;
			}
			if(!empty($getDueData->file_middle)){
				$data[] = $getDueData->file_middle;
			}
			if(!empty($getDueData->file_right)){
				$data[] = $getDueData->file_right;
			}
			if(!empty($getDueData->file_four)){
				$data[] = $getDueData->file_four;
			}
			if(!empty($getDueData->file_five)){
				$data[] = $getDueData->file_five;
			}
			if(!empty($getDueData->file_six)){
				$data[] = $getDueData->file_six;
			}
			if(!empty($getDueData->file_seven)){
				$data[] = $getDueData->file_seven;
			}
			if(!empty($getDueData->file_eight)){
				$data[] = $getDueData->file_eight;
			}
			if(!empty($getDueData->file_nine)){
				$data[] = $getDueData->file_nine;
			}
			if(!empty($getDueData->file_ten)){
				$data[] = $getDueData->file_ten;
			}
			if(!empty($getDueData->file_eleven)){
				$data[] = $getDueData->file_eleven;
			}
			if(!empty($getDueData->file_twelve)){
				$data[] = $getDueData->file_twelve;
			}
			if(!empty($getDueData->file_thirteen)){
				$data[] = $getDueData->file_thirteen;
			}
			if(!empty($getDueData->file_fourteen)){
				$data[] = $getDueData->file_fourteen;
			}
			if(!empty($getDueData->file_fiveteen)){
				$data[] = $getDueData->file_fiveteen;
			}
			if(!empty($getDueData->file_sixteen)){
				$data[] = $getDueData->file_sixteen;
			}
			if(!empty($getDueData->file_seventeen)){
				$data[] = $getDueData->file_seventeen;
			}
			if(!empty($getDueData->file_eighteen)){
				$data[] = $getDueData->file_eighteen;
			}
			if(!empty($getDueData->file_nineteen)){
				$data[] = $getDueData->file_nineteen;
			}
			if(!empty($getDueData->file_twenty)){
				$data[] = $getDueData->file_twenty;
			}
			if(!empty($getDueData->file_twentyone)){
				$data[] = $getDueData->file_twentyone;
			}
			if(!empty($getDueData->file_twentytwo)){
				$data[] = $getDueData->file_twentytwo;
			}
			if(!empty($getDueData->file_twentythree)){
				$data[] = $getDueData->file_twentythree;
			}
			if(!empty($getDueData->file_twentyfour)){
				$data[] = $getDueData->file_twentyfour;
			}
			if(!empty($getDueData->file_twentyfive)){
				$data[] = $getDueData->file_twentyfive;
			}
			if(!empty($getDueData->file_twentysix)){
				$data[] = $getDueData->file_twentysix;
			}
			if(!empty($getDueData->file_twentyseven)){
				$data[] = $getDueData->file_twentyseven;
			}
			if(!empty($getDueData->file_twentyeight)){
				$data[] = $getDueData->file_twentyeight;
			}
			if(!empty($getDueData->file_twentynine)){
				$data[] = $getDueData->file_twentynine;
			}
			if(!empty($getDueData->file_thirty)){
				$data[] = $getDueData->file_thirty;
			}
			if(!empty($getDueData->file_thirtyone)){
				$data[] = $getDueData->file_thirtyone;
			}
			if(!empty($getDueData->file_thirtytwo)){
				$data[] = $getDueData->file_thirtytwo;
			}
			$getAllImagesWithName = $this->db->select("id,link,name")->from($this->table_store_images)->where_in('link',$data)->get();
			$data = array();
			if ($getAllImagesWithName->num_rows() > 0) {
				$data['images'] = $getAllImagesWithName->result();
				$data['selected_images'] = $getDueData->show_linkedin_images;
			}
		}
		return $data;
	}
	
	public function findPortfolioWithSerial($serialNumber){
		$query = $this->db->select('a.*,l.lead_name,l.serial_number,li.*')->from($this->table_acquisition.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table_licenses.' as li','l.serial_number=li.serial_number','left')->where('l.serial_number',trim($serialNumber))->where_in('l.status',array('0','1','2'))->get();		
		$data = array();
		if ($query->num_rows() > 0) {
			$rowData = $query->first_row();
			$todayDate = strtotime(date('Y-m-d',strtotime('now')));
			$expirationDate = strtotime($rowData->option_expiration_data);
			$regularLicense = strtotime($rowData->regular_license_starts);
			$lateLicense = strtotime($rowData->late_license_starts);
			if(($rowData->option_expiration_data!='0000-00-00 00:00:00' && $expirationDate>$todayDate && $rowData->regular_license_starts=='0000-00-00 00:00:00') || $rowData->cost_price==0.0){
				if($rowData->active_button!='1'){
					$rowData->active_button = 1;
					$this->updateAcquisition(array('active_button'=>$rowData->active_button),$rowData->lead_id);
					$this->updateLicenseDataBySerialNumber($rowData->active_button,$rowData->serial_number);
				}
			} else if($rowData->cost_price>0 && $rowData->regular_license_starts!='0000-00-00 00:00:00'){
				if($rowData->late_license_starts=='0000-00-00 00:00:00'){
					$lateLicense = date('m/d/Y',strtotime('+4 months',$regularLicense));
					$rowData->late_license_starts = date('Y-m-d H:i:s',strtotime($lateLicense));
					$rowData->active_button = 2;
					$this->updateAcquisition(array('active_button'=>$rowData->active_button,'late_license_starts'=>$rowData->late_license_starts),$rowData->lead_id);
					$this->updateLicenseDataBySerialNumber($rowData->active_button,$rowData->serial_number);						
				} else {
					if($todayDate>$regularLicense && $todayDate<$lateLicense && $rowData->active_button!='2'){
						$rowData->active_button = 2;
						$this->updateAcquisition(array('active_button'=>$rowData->active_button),$rowData->lead_id);
						$this->updateLicenseDataBySerialNumber($rowData->active_button,$rowData->serial_number);
					} else if($todayDate>$regularLicense && $todayDate>=$lateLicense && $rowData->active_button!='3'){
						$rowData->active_button = 3;
						$this->updateAcquisition(array('active_button'=>$rowData->active_button),$rowData->lead_id);
						$this->updateLicenseDataBySerialNumber($rowData->active_button,$rowData->serial_number);
					}
				}
			}
            $data = $rowData;
        }
		return $data;
	}
	
	public function findDemoPortfolioWithSerialList($serialNumbers){
		$query = $this->db->select('a.*,l.lead_name,l.serial_number,li.id as licenseID')->from($this->table_acquisition.' as a')->join($this->table_lead.' as l','l.id=a.lead_id','left')->join($this->table_licenses.' as li','li.serial_number=l.serial_number','left')->where_in('l.serial_number',$serialNumbers)->where_in('l.status',array('0','1','2'))->get();		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach($query->result() as $row){
				$rowData = $row;
				$todayDate = strtotime(date('Y-m-d',strtotime('now')));
				$expirationDate = strtotime($rowData->option_expiration_data);
				$regularLicense = strtotime($rowData->regular_license_starts);
				$lateLicense = strtotime($rowData->late_license_starts);
				if(($rowData->option_expiration_data!='0000-00-00 00:00:00' && $expirationDate>$todayDate && $rowData->regular_license_starts=='0000-00-00 00:00:00') || $rowData->cost_price==0.0){
					if($rowData->active_button!='1'){
						$rowData->active_button = 1;
						$this->updateAcquisition(array('active_button'=>$rowData->active_button),$row->lead_id);
						$this->updateLicenseDataBySerialNumber($rowData->active_button,$row->serial_number);
					}
				} else if($rowData->cost_price>0 && $rowData->regular_license_starts!='0000-00-00 00:00:00'){
					if($rowData->late_license_starts=='0000-00-00 00:00:00'){
						/*echo "1";*/
						$lateLicense = date('m/d/Y',strtotime('+4 months',$regularLicense));
						$rowData->late_license_starts = date('Y-m-d H:i:s',strtotime($lateLicense));
						$this->updateData($row->lead_id,array('late_license_starts'=>$rowData->late_license_starts));
					} 
					if($todayDate>$regularLicense && $todayDate<$lateLicense ){
						/*echo "2";*/
						if($rowData->active_button!=2){
							$rowData->active_button = 2;
							$this->updateData($row->lead_id,array('active_button'=>$rowData->active_button));
							$this->updateLicenseDataBySerialNumber($rowData->active_button,$row->serial_number);
						}
					} else if($todayDate>$regularLicense && $todayDate>=$lateLicense){
						/*echo "3";*/
						if($rowData->active_button!=3){
							$rowData->active_button = 3;
							$this->updateData($row->lead_id,array('active_button'=>$rowData->active_button));
							$this->updateLicenseDataBySerialNumber($rowData->active_button,$row->serial_number);
						}						
					}
				}
				$data[] = $rowData;
			}
        }
		return $data;
	}
	
	function updateData($leadID,$data){
		$query = $this->db->select('serial_number')->from($this->table_lead .' as l')->where('id',$leadID)->get();
        $dataLead = 0;
		if ($query->num_rows() > 0) {
            $dataLead = $query->first_row();
			$this->db->where("serial_number",$dataLead->serial_number);
			$this->db->update($this->table_licenses,$data);
			$dataLead = $this->db->affected_rows();
        }
		return $dataLead;
		/*$this->db->where("id",$leadID);
		$this->db->update($this->table_licenses,$data);
		return $this->db->affected_rows();*/
	}
	
	public function findLeadByName($leadName,$select="l.*"){
		$query = $this->db->select($select)->from($this->table_lead .' as l')->where('trim(l.lead_name)',trim($leadName))->get();
        $data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	
	public function checkDataFromSameOwnerToday($ownerName,$date,$type){
		$query = $this->db->select('count(*) as portfolio')->from($this->table_lead)->where('plantiffs_name',$ownerName)->where('type',$type)->where('date_format(create_date,"%Y-%m-%d")',$date)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
        }
		return $data;
	}
	
	public function getUserById($ID){
		 $query = $this->db->select('u.*')->from($this->table.' as u')->where('u.id',$ID)->get();
		 $data = array();
		 if($query->num_rows()>0){
			 $data = $query->first_row();
		 }
		 return $data;
	}
	
    public function getUserPageAssign($url){
		$user_session_id = $this->session->userdata('id');
		$where = "( p.page_url = '$url')";
        $query = $this->db->select('u.*')->from('pages as p')->join('user_page_access_level as up', 'up.page_id = p.id')->join('users as u', 'u.id = up.user_id')->where($where)->get();
		$data=array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		/*Find Admin Users*/
		$query = $this->db->select('*')->from('users')->where('type','9')->get();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}
	public function deleteRelationByFamilyID($familyID){
		$this->db->reconnect();
		$this->db->where('family_id',$familyID);
		$this->db->delete($this->table_family_patent_relation);
		return $this->db->affected_rows();
	}
	public function updateFamilyPatentRelation($data,$id){
		$this->db->reconnect();
		$this->db->query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");
		$this->db->where('id',$id);
		$this->db->update($this->table_family_patent_relation,$data);
		return $this->db->affected_rows();
	}
	public function insertFamilyPatentRelation($data){
		$this->db->reconnect();
		$this->db->query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");
		$this->db->insert($this->table_family_patent_relation,$data);
		return $this->db->insert_id();
	}
	
	public function updatePanjivaCompany($data,$ID){
		$this->db->where('id',$ID);
		$this->db->update($this->table_all_panjiva,$data);
		return $this->db->affected_rows();
	}
	
	public function insertLinkedinMessagesBatch($data){
		$this->db->reconnect();
		$this->db->query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");
		$this->db->insert_batch($this->table_linkedin_messages,$data);
		return $this->db->affected_rows();
	}
	
	public function insertLinkedinThreadBatch($data){
		$this->db->reconnect();
		$this->db->query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");
		$this->db->insert_batch($this->table_linkedin_threads,$data);
		return $this->db->affected_rows();
	}
	
	public function insertSendLinkedinMessage($data){
		$this->db->insert($this->table_send_linkedin_messages,$data);
		return $this->db->insert_id();
	}
	
	public function addPanjivaCompaniesInBulk($data){
		$this->db->reconnect();
		$this->db->query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");
		$this->db->insert_batch($this->table_all_panjiva,$data);
		return $this->db->affected_rows();
	}
	public function insertPatentFamilyMember($data){
		$this->db->reconnect();
		$this->db->query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");
		$this->db->insert($this->table_patent_family_member,$data);
		return $this->db->affected_rows();
	}
	public function updatePatentFamilyMember($data,$id){
		$this->db->reconnect();
		$this->db->query("SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'");
		$this->db->where('id',$id);
		$this->db->update($this->table_patent_family_member,$data);
		return $this->db->affected_rows();
	}
	
	public function checkFamilyPatentRelation($familyID,$patentID){
		$this->db->reconnect();
		 $query = $this->db->select('pr.*')->from($this->table_family_patent_relation.' as pr')->where('pr.patent_id',$patentID)->where('pr.family_id',$familyID)->get();	
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function checkFamilyMember($familyID,$publicationNumber,$applicationNumber){
		$this->db->reconnect();
		$this->db->_protect_identifiers=false;
		$query = $this->db->select('id,publication_country,publication_kind,1 as pub')->from($this->table_patent_family_member.' as fm')->where('fm.family_id',$familyID)->where('fm.publication_number',$publicationNumber)->where('fm.application_number',$applicationNumber)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		} else {
			/*$query = $this->db->select('id,publication_country,publication_kind,2 as pub')->from($this->table_patent_family_member.' as fm')->where('fm.family_id',$familyID)->where('fm.application_number',$applicationNumber)->get();
			$data = array();
			if($query->num_rows()>0){
				$data = $query->first_row();
			}*/
		}
		return $data;
	}
	
	/*public function findPatentSimpleFamily($patentNumber){
		$this->db->reconnect();
		$query = $this->db->select('id,family_id')->from($this->table_patent_family_member.' as fm')->like('fm.publication_number',$patentNumber)->limit(1,0)->get();
		$data = array('country'=>array(),'list'=>array());
		if($query->num_rows()>0){
			$rowData = $query->first_row();
			$querySimpleFamily = $this->db->select('*')->from($this->table_family_patent_relation)->where('family_id',$rowData->family_id)->order_by('filling_date ASC, id ASC')->get();
			if($querySimpleFamily->num_rows()>0){
				$data['list'] = $querySimpleFamily->result();
			}
			$query = $this->db->select('distinct(fm.publication_country) as publication_country')->from($this->table_patent_family_member.' as fm')->where('fm.family_id',$rowData->family_id)->get();
			if($query->num_rows()>0){
				$data['country'] = $query->result();
			}
			$query = $this->db->select('*')->from($this->table_patent_family_member.' as fm')->like('fm.family_id',$rowData->family_id)->get();
			if($query->num_rows()>0){
				$data['biblio'] = $query->result();
			}
		}
		return $data;
	}*/
	
	public function getJobID($leadID) {
		$jobID = 0;
		$jobData = $this->db->select("id")->from($this->table_job_queue)->where('account',$leadID)->where('module_name','Patent_Family')->order_by('id','DESC')->limit(1)->get();
		if ($jobData->num_rows() > 0) {	
			$data = $jobData->first_row();
			$jobID = $data->id;
		}
		return $jobID;
	}
	
	public function findLeadNotepadData($leadID){
		$data = array();
		$notepadData = $this->db->select("*")->from($this->table_lead_notepad)->where('lead_id',$leadID)->get();
		if ($notepadData->num_rows() > 0) {	
			$data = $notepadData->first_row();
		}
		return $data;
	}
	
	public function getAllPanjivaCompanies(){
		$data = array();
		$getAllPanjiva = $this->db->select('id as recid,hts_code,name,company_id')->from($this->table_all_panjiva.' as d')->where('d.company_id',0)->get();
		if ($getAllPanjiva->num_rows() > 0) {	
			$data = $getAllPanjiva->result();
		}
		return $data;
	}
	
	public function getAllSourcesData(){
		$data = array();
		$getAllSources = $this->db->select('id as recid,id,source,subject,purpose,url')->from($this->table_sources.' as d')->get();
		if ($getAllSources->num_rows() > 0) {	
			$data = $getAllSources->result();
		}
		return $data;
	}
	
	public function findLastSyncMessage(){
		return $this->db->select('last_conversation_date')->from($this->table_linkedin_threads)->order_by('last_conversation_date','DESC')->limit(1)->get()->row()->last_conversation_date;
	}
	
	public function formatApplicant($value){
		$value = strtolower(trim($value));
		$value = preg_replace('/[.,]/', '', $value);
		$value = preg_replace('/[-]/', ' ', $value);
		return $value;
	}
	
	public function getAllPatentCitationCompanies($leadID){
		/*
		Select d.applicant,d.id,d.owler_url,d.linkedin_url FROM due_dilligence_citations as d 
		LEFT JOIN company as c ON c.company_name = d.applicant
		WHERE d.type = 1 AND d.company_id = 0 AND (c.company_name IS NULL)
		GROUP BY d.applicant;
		*/
		$data = array();
		if($leadID > 0){
			$queryPatent = $this->db->select('distinct(lp.patent_number) as patent_number')->from($this->table_lead_patent.' as lp')->where('lp.lead_id',$leadID)->get();
			if ($queryPatent->num_rows() > 0) {	
				$patentList = $queryPatent->result();
				foreach($patentList as $rowParent){
					$getAllPatentCitation = $this->db->select('d.applicant,d.id,d.owler_url,d.linkedin_url,d.company_name')->from($this->table_due_dilligence_citations.' as d')->where('d.patent_id',$rowParent->patent_number)->where('d.type',1)->where('d.company_id',0)->group_by('d.applicant')->get();
					if ($getAllPatentCitation->num_rows() > 0) {	
						$result = $getAllPatentCitation->result();
						foreach($result as $d){
							array_push($data,$d);
						}
					}
				}
			}
		} else {
			$getAllPatentCitation = $this->db->select('d.applicant,d.id,d.owler_url,d.linkedin_url,company_name')->from($this->table_due_dilligence_citations.' as d')->where('d.type',1)->where('d.company_id',0)->group_by('d.applicant')->get();
			if ($getAllPatentCitation->num_rows() > 0) {	
				$data = $getAllPatentCitation->result();
			}
		}
		if (count($data) > 0 && $leadID > 0) {
			$getOtherCompanyNameList = $this->db->select('name,company_id')->from($this->table_company_other_names)->get();
			if ($getOtherCompanyNameList->num_rows() > 0) {	
				$companyOtherList = $getOtherCompanyNameList->result();
				if(count($companyOtherList) > 0){
					$arrayDelete = array();
					$arrayDeleteIndex = array();
					for($i=0; $i<count($data); $i++){
						$appl = $this->formatApplicant($data[$i]->applicant);
						foreach($companyOtherList as $company){
							$otherName = $this->formatApplicant($company->name);
							if($appl == $otherName){
								array_push($arrayDelete,array('applicant_id'=>$data[$i]->id,'company_id'=>$company->company_id));
								array_push($arrayDeleteIndex,$i);
								break;
							}
						}
					}
					if(count($arrayDeleteIndex) > 0){
						foreach($arrayDeleteIndex as $index){
							unset($data[$index]);
						}
						$data = array_values($data);
					}
					if(count($arrayDelete) > 0){
						foreach($arrayDelete as $c){
							$this->updateCitationData(array('company_id'=>$c['company_id']),$c['applicant_id']);
						}
					}
				}
			}
		}
		return $data;
	}
	
	
	public function getAllLitigationCompanies($leadID){
		$data = array();
		if($leadID > 0){
			$queryLitigation = $this->db->select('id,party1,party2,company_id1,company_id2')->from($this->table_lead_litigation.' as lp')->where('lp.lead_id',$leadID)->where('lp.company_id1',0)->or_where('lp.company_id2',0)->get();
			if ($queryLitigation->num_rows() > 0) {	
				$litigationParties = $queryLitigation->result();
				foreach($litigationParties as $rowLitigation){
					$party1 = trim($rowLitigation->party1);
					$party2 = trim($rowLitigation->party2);
					if($party1 != "" && $party2 != ""){
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
						$party1 = $this->formatApplicant($party1);
						$party2 = $this->formatApplicant($party2);
						
						if($rowLitigation->company_id1 == 0){
							array_push($data,array('id'=>$rowLitigation->id,'applicant'=>$party1,'owler_url'=>'','linkedin_url'=>'','company_name'=>'','t'=>1));
						}
						if($rowLitigation->company_id2 == 0){
							array_push($data,array('id'=>$rowLitigation->id,'applicant'=>$party2,'owler_url'=>'','linkedin_url'=>'','company_name'=>'','t'=>2));
						}
					}					
				}
			}
		} else {
			$queryLitigation = $this->db->select('id,party1,party2,company_id1,company_id2')->from($this->table_lead_litigation.' as lp')->where('lp.lead_id',$leadID)->where('lp.company_id1',0)->or_where('lp.company_id2',0)->get();
			if ($queryLitigation->num_rows() > 0) {	
				$litigationParties = $queryLitigation->result();
				foreach($litigationParties as $rowLitigation){
					$party1 = trim($rowLitigation->party1);
					$party2 = trim($rowLitigation->party2);
					if($party1 != "" && $party2 != ""){
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
						$party1 = $this->formatApplicant($party1);
						$party2 = $this->formatApplicant($party2);
						
						if($rowLitigation->company_id1 == 0){
							array_push($data,array('id'=>$rowLitigation->id,'applicant'=>$party1,'owler_url'=>'','linkedin_url'=>'','company_name'=>'','t'=>1));
						}
						if($rowLitigation->company_id2 == 0){
							array_push($data,array('id'=>$rowLitigation->id,'applicant'=>$party2,'owler_url'=>'','linkedin_url'=>'','company_name'=>'','t'=>2));
						}
					}					
				}
			}
		}
		if (count($data) > 0 && $leadID > 0) {
			$companyList = $this->db->select('company_name as name, id as company_id')->from($this->table_company)->get();
			$companyOtherList = array();
			if ($companyList->num_rows() > 0) {	
				$companyOtherList = $companyList->result();
			}
			$getOtherCompanyNameList = $this->db->select('name,company_id')->from($this->table_company_other_names)->get();
			if ($getOtherCompanyNameList->num_rows() > 0) {	
				$OtherList = $getOtherCompanyNameList->result();
				$companyOtherList = array_merge($companyOtherList,$OtherList);
				if(count($companyOtherList) > 0){
					$arrayDelete = array();
					$arrayDeleteIndex = array();
					for($i=0; $i<count($data); $i++){
						$appl = $this->formatApplicant($data[$i]['applicant']);
						foreach($companyOtherList as $company){
							$otherName = $this->formatApplicant($company->name);
							if($appl == $otherName){
								array_push($arrayDelete,array('applicant_id'=>$data[$i]['id'],'company_id'=>$company->company_id,'t'=>$data[$i]['t']));
								array_push($arrayDeleteIndex,$i);
								break;
							}
						}
					}
					if(count($arrayDeleteIndex) > 0){
						foreach($arrayDeleteIndex as $index){
							unset($data[$index]);
						}
						$data = array_values($data);
					}
					if(count($arrayDelete) > 0){
						foreach($arrayDelete as $c){
							$updateData = array();
							if($c['t'] == 1){
								$updateData['company_id1'] = $c['company_id'];
							} else if($c['t'] == 2){
								$updateData['company_id2'] = $c['company_id'];
							}
							if(count($updateData) > 0){
								$this->updateLeadLitigation($updateData,$c['applicant_id']);
							}							
						}
					}
				}
			}
		}
		if(count($data) > 0){
			for($i=0;$i<count($data);$i++){
				$data[$i]['applicant_id'] = $data[$i]['id'];
				$data[$i]['id'] = $i+1;
			}
		}
		return $data;
	}
	
	function findAssignmentRelations($patentNumber,$assignmentNo){
		$connectionToRelations = array();
		$queryHeadingData = $this->db->select('a.connection_to')->from($this->table_lead_assignment_heading.' as a')->where('a.patent_number',$patentNumber)->where('a.assignment_no',$assignmentNo)->where('a.connection_to >',0)->get();
		if ($queryHeadingData->num_rows() > 0) {	
			$data = $queryHeadingData->first_row();
			$queryAssignmentRelationData = $this->db->select('DISTINCT(r.id),r.patent_number,r.parent_id,r.child_id,r.connection_type,r.reel,r.frame,r.description,r.date,r.assignment_no,t1.title_file as note_file,t1.comment as note')->from($this->table_lead_patent_assigment_relation.' as r')->join($this->table_due_dilligence_titles.' as t','t.reel = r.reel','left')->join($this->table_due_dilligence_titles.' as t1','t1.frame = r.frame','left')->where('r.patent_number',$patentNumber)->where('r.assignment_no',$data->connection_to)->get();
			if($queryAssignmentRelationData->num_rows() > 0){
				$connectionToRelations = $queryAssignmentRelationData->result();
			}
		}
		return $connectionToRelations;
	}
	
	public function findAssignmentFamily($patentNumber){
		$this->db->reconnect();
		$data = array('inventor_boxes'=>array(),'relation'=>array(),'list'=>array(),'all_names'=>array(),'all_assignment'=>array(),'assignment_type_list'=>array());
		$this->db->_protect_identifiers=false;
		/*$queryAssignmentData = $this->db->select('id,patent_number,name,description,execution_date,recorded,type,reel_no,frame_no,document_file')->from($this->table_lead_patent_assignment)->where('patent_number',$patentNumber)->order_by('execution_date ASC,type ASC, id DESC')->get();*/
		$queryInventorBoxesData = $this->db->select('id,patent_number,name,description,date_format(execution_date,"%b %d, %Y") as execution_date,date_format(recorded,"%b %d, %Y") as recorded,recorded as recorded_date,"Inventor" as type,"" as document_file,execution_date as date_1,assignment_no,box_type')->from($this->table_lead_patent_assignment)->where('patent_number',$patentNumber)->where('type',0)->order_by('id ASC')->get();
		if($queryInventorBoxesData->num_rows()>0){
			$data['inventor_boxes'] = $queryInventorBoxesData->result();
		}
		$queryOtherBoxesData = $this->db->select('id,patent_number,name,description,execution_date,recorded,type,document_file,execution_date as date_1,assignment_no,box_type')->from($this->table_lead_patent_assignment)->where('patent_number',$patentNumber)->where('type <>',0)->order_by('execution_date ASC')->get();
		if($queryOtherBoxesData->num_rows()>0){
			$data['other_boxes'] = $queryOtherBoxesData->result();
		}
		$queryAssignmentData = $this->db->select('id,patent_number,name,description,execution_date,recorded,type,reel_no,frame_no,document_file')->from($this->table_lead_patent_assignment)->where('patent_number',$patentNumber)->order_by('execution_date ASC')->get();
		
		if($queryAssignmentData->num_rows()>0){
			$data['list'] = $queryAssignmentData->result();
			/*if(count($data['list'])>0){
				for($i=0;$i<count($data['list']);$i++){
					$relation = array();
					$queryAssignmentRelationData = $this->db->select('id,patent_number,parent_id,child_id,connection_type,reel,frame,description,date,assignment_no')->from($this->table_lead_patent_assigment_relation)->where('patent_number',$patentNumber)->where('parent_id',$data['list'][$i]->id)->order_by('id ASC')->get();
					if($queryAssignmentRelationData->num_rows()>0){
						$relation = $queryAssignmentRelationData->result();
					}
					$data['list'][$i]->relation = $relation;
				}
			}*/
		}
		$relation = array();
		/*$queryAssignmentRelationData = $this->db->select('id,patent_number,parent_id,child_id,connection_type,reel,frame,description,date,assignment_no')->from($this->table_lead_patent_assigment_relation)->where('patent_number',$patentNumber)->order_by('date ASC,id ASC')->get();*/
		$queryAssignmentRelationData = $this->db->select('DISTINCT(r.id),r.patent_number,r.parent_id,r.child_id,creator_id,start_creator_id,r.connection_type,r.reel,r.frame,r.description,r.date,r.assignment_no,t1.title_file as note_file,t1.comment as note,r.line_type')->from($this->table_lead_patent_assigment_relation.' as r')->join($this->table_due_dilligence_titles.' as t','t.reel = r.reel','left')->join($this->table_due_dilligence_titles.' as t1','t1.frame = r.frame','left')->where('r.patent_number',$patentNumber)->order_by('r.date ASC')->get();
		if($queryAssignmentRelationData->num_rows()>0){
			$data['relation'] = $queryAssignmentRelationData->result();
			/*$noteFile = "";
			$note = "";
			for($i=0;$i<count($data['relation']);$i++){
				$queryNote = $this->db->select('title_file as note_file,comment as note')->from($this->table_due_dilligence_titles)->where('reel',$data['relation'][$i]->reel)->where('reel',$data['relation'][$i]->reel);
			}*/
		}
		$data['all_names'] = $this->getLeadAssignmentNames($patentNumber);
		$data['all_assignment'] = $this->getLeadAssignmentHeadings($patentNumber);
		$data['assignment_type_list'] = $this->get_all_assignment_types();
		$data['all_boxes'] = $this->get_all_boxes();
		return $data;
	}
	
	function get_all_boxes(){
		$query = $this->db->select("*")->from($this->table_lead_assignment_box)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->result();
		}
		return $data;
	}
	
	function get_all_assignment_types(){
		$query = $this->db->select("id,name as tooltip, color, line_type as type, explanation")->from($this->table_lead_assignment_heading_list)->order_by('order_no','ASC')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->result();
		}
		return $data;
	}
	
	public function getLeadAssignmentNames($patentNumber){
		$data = array();
		$queryNames = $this->db->select("id,original,modified")->from($this->table_lead_assignment_names)->where('patent_number',$patentNumber)->get();
		if($queryNames->num_rows()>0){
			$data = $queryNames->result();
		}
		return $data;
	}
	
	public function getLeadAssignmentHeadings($patentNumber){
		$data = array();
		$queryNames = $this->db->select("ah.id,ah.original,ah.original_text,ahl.name as modified,ah.modified as modified_by,ah.assignment_no,ah.connection_to")->from($this->table_lead_assignment_heading.' as ah')->join($this->table_lead_assignment_heading_list.' as ahl','ahl.id = ah.original_text','left')->where('patent_number',$patentNumber)->get();
		if($queryNames->num_rows()>0){
			$data = $queryNames->result();
		}
		return $data;
	}
	
	public function findPatentSimpleFamily($patentNumber){
		$this->db->reconnect();
		$query = $this->db->select('id,family_id')->from($this->table_patent_family_member.' as fm')->like('fm.publication_number',$patentNumber)->limit(1,0)->get();
		$data = array('country'=>array(),'list'=>array());
		if($query->num_rows()>0){
			$rowData = $query->first_row();
			$querySimpleFamily = $this->db->select('distinct(fpr.id),fpr.*,pfm.publication_country,publication_kind,pfm.application_number,pfm.application_date,pfm.claims,pfm.abstracts,pfm.images,pfm.publication_date,pfm.application_country,pfm.application_kind,pfm.title,pfm.priority_date,pfm.applicants,pfm.assignee,pfm.inventors,pfm.assigments')->from($this->table_family_patent_relation.' as fpr')->join($this->table_patent_family_member.' as pfm','pfm.publication_number = fpr.patent_id','left')->where('fpr.family_id',$rowData->family_id)->order_by('fpr.filling_date ASC, fpr.id ASC')->get();
			if($querySimpleFamily->num_rows()>0){
				$data['list'] = $querySimpleFamily->result();
			}
			if(count($data['list'])>0){
				for($i=0;$i<count($data['list']);$i++){
					$relation = array();
					$patentNumber = $data['list'][$i]->patent_id;
					$status = "";
					if(substr(strtoupper($data['list'][$i]->publication_kind),0,1)=="B" && strtolower(strtoupper($data['list'][$i]->publication_country))=='us'){
						$applicationNumber = $data['list'][$i]->application_number;
						$applicationDate = $data['list'][$i]->application_date;
						$this->db->where('patent_app_number',$applicationNumber);
						$data['list'][$i]->application_number = $applicationNumber;
						$queryRelation = $this->db->select('distinct(relation_number) as relation_number,id, patent_app_number,relation_type,filed_date')->from($this->table_lead_patent_family_child)->where('child',1)->where('patent_app_number',$applicationNumber)->get();
						if($queryRelation->num_rows()){
							$relation = $queryRelation->result();
						}
						$queryStatus = $this->db->select('status')->from($this->table_patent_illustration_detail)->where('patent_number',$patentNumber)->limit(1)->get();
						if($queryStatus->num_rows()>0){
							$firstRow = $queryStatus->first_row();
							$status= $firstRow->status;
						}
					}	
					$data['list'][$i]->status = $status;
					$data['list'][$i]->relation = $relation;
				}
			}
		}
		return $data;
	}
	
	
	function getAllEPOFamilies($leadID){
		$data = array('country'=>array(),'list'=>array());
		$queryPatent = $this->db->select('distinct(lp.patent_number) as patent_number')->from($this->table_lead_patent.' as lp')->where('lp.lead_id',$leadID)->get();
		if ($queryPatent->num_rows() > 0) {	
			$family = array();
			foreach($queryPatent->result() as $rowParent){
				$patentNumber = $rowParent->patent_number;
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
				$allPatentQuery = $this->db->select('distinct(fpr.family_id) as familyID')->from($this->table_patent_family_member.' as fpr')->where('fpr.publication_number',$newNumber)->order_by('fpr.id','DESC')->get();
				if ($allPatentQuery->num_rows() > 0) {
					$rowChild = $allPatentQuery->first_row();
					$family[] = $rowChild->familyID;
				}
			}
			if(count($family)>0){
				$allPatentQuery = $this->db->select('fpr.*,pfm.publication_country,publication_kind,pfm.application_number,pfm.application_date,pfm.claims,pfm.abstracts,pfm.images,pfm.publication_date,pfm.application_country,pfm.application_kind,pfm.title,pfm.priority_date,pfm.applicants,pfm.assignee,pfm.inventors,pfm.assigments')->from($this->table_family_patent_relation.' as fpr')->join($this->table_patent_family_member.' as pfm','pfm.publication_number = fpr.patent_id','left')->where_in('fpr.family_id',$family)->order_by('fpr.filling_date ASC, fpr.id ASC')->get();
				if($allPatentQuery->num_rows()>0){
					$data['list'] = $allPatentQuery->result();
				}
				if(count($data['list'])>0){
					for($i=0;$i<count($data['list']);$i++){
						$relation = array();
						$patentNumber = $data['list'][$i]->patent_id;
						$status = "";
						if(substr(strtoupper($data['list'][$i]->publication_kind),0,1)=="B" && strtolower(strtoupper($data['list'][$i]->publication_country))=='us'){
							$applicationNumber = $data['list'][$i]->application_number;
							$applicationDate = $data['list'][$i]->application_date;
							$this->db->where('patent_app_number',$applicationNumber);
							$data['list'][$i]->application_number = $applicationNumber;
							$queryRelation = $this->db->select('distinct(relation_number) as relation_number,id, patent_app_number,relation_type,filed_date')->from($this->table_lead_patent_family_child)->where('child',1)->order_by('filed_date','ASC')->get();
							if($queryRelation->num_rows()){
								$relation = $queryRelation->result();
							}
							$queryStatus = $this->db->select('status')->from($this->table_patent_illustration_detail)->where('patent_number',$patentNumber)->limit(1)->get();
							if($queryStatus->num_rows()>0){
								$firstRow = $queryStatus->first_row();
								$status= $firstRow->status;
							}
						}	
						$data['list'][$i]->status = $status;
						$data['list'][$i]->relation = $relation;
					}
				}
			}
		}
		return $data;
	}
	
	function getAllEPOFamiliesLeft($leadID){
		$data = array('family'=>array(),'publications'=>array());
		$queryPatent = $this->db->select('distinct(lp.patent_number) as patent_number')->from($this->table_lead_patent.' as lp')->where('lp.lead_id',$leadID)->get();
		if ($queryPatent->num_rows() > 0) {	
			$family = array();
			foreach($queryPatent->result() as $rowParent){
				$patentNumber = $rowParent->patent_number;
				/*$countryCode = substr($patentNumber,0,2);
				if(strtolower(strtoupper($countryCode))=="us" && strlen($patentNumber)>9){
					$patentNumber = substr($patentNumber,0,-2);
				}
				*/
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
				$allPatentQuery = $this->db->select('distinct(fpr.family_id) as familyID')->from($this->table_patent_family_member.' as fpr')->where('fpr.publication_number',$newNumber)->order_by('fpr.id','DESC')->get();
				if ($allPatentQuery->num_rows() > 0) {
					$rowChild = $allPatentQuery->first_row();
					$family[] = $rowChild->familyID;
				}
			}
			if(count($family)>0){
				$allPatentQuery = $this->db->select('fpr.*')->from($this->table_family_patent_relation.' as fpr')->where_in('fpr.family_id',$family)->order_by('fpr.filling_date','ASC')->get();
				/*echo $this->db->last_query();*/
				if ($allPatentQuery->num_rows() > 0) {
					$data['family'] = $allPatentQuery->result();
				}
				$allPatentQuery = $this->db->select('fm.publication_country,fm.publication_number as publication_number,fm.publication_kind, fm.application_number as application_number,fm.application_country,fm.application_kind,fm.priority_date')->from($this->table_patent_family_member.' as fm')->where_in('fm.family_id',$family)->order_by('fm.id','DESC')->get();
				/*echo $this->db->last_query();*/
				if ($allPatentQuery->num_rows() > 0) {
					$data['publications'] = $allPatentQuery->result();
				}
			}
		}
		return $data;
	}
	
	public function patentDetailInfo($patentNumber,$select){
		$query = $this->db->select($select)->from($this->table_patent_illustration_detail)->where('patent_number',$patentNumber)->where('status','Patented Case')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	function getAllPatentsFromLeadForEPO(){
		$query = $this->db->select("*")->from($this->table_lead_patent)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->result();
		}
		return $data;
	}
	function getListOfSeriesCode(){
		$query = $this->db->select("*")->from($this->table_lead_patent_series_code)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->result();
		}
		return $data;
	}

	
	function getIPCCode($name){
		 $otherdb = $this->load->database('db3', TRUE);
		 $query = $otherdb->select('classification_description')->from('ep7gx_expertisearea')->where('name',$name)->get();
		 $data = array();
		 if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	public $ipcCodeData = array();
	
	function getAllIPCCodes($page,$start){
		$otherdb = $this->load->database('db3', TRUE);
		$query = $otherdb->select('name as ipc')->from('ep7gx_expertisearea')->order_by('id','ASC')->limit($page,$start)->get();
		 $data = array();
		if($query->num_rows()>0){
			$data = $query->result();
		}
		return $data;
	}
	function getIPCCodeList($name){
		 $otherdb = $this->load->database('db3', TRUE);
		 $query = $otherdb->select('classification_description,parent,name')->from('ep7gx_expertisearea')->where('name',$name)->get();
		 $data = array();
		 $this->ipcCodeData = array();
		 if($query->num_rows()>0){
			$data = $query->first_row();
			if($data->parent!=0){
				array_push($this->ipcCodeData,$data);
				$search = false;
				/*if(strlen($name)<=3){
					$search = true;
				}*/
				$this->getIPCCodeByID($data->parent,$search);
			} else {
				if(count($this->ipcCodeData)==0){
					array_push($this->ipcCodeData,$data);
				}
			}
		}
		return $this->ipcCodeData;
	}
	
	function getIPCCodeByID($ID,$search=false){
		$otherdb = $this->load->database('db3', TRUE);
		 $query = $otherdb->select('classification_description,parent,name')->from('ep7gx_expertisearea')->where('id',$ID)->get();
		 $data = array();
		 if($query->num_rows()>0){
			$data = $query->first_row();
			if($data->parent!=0 && $search==false){
				array_push($this->ipcCodeData,$data);
				$this->getIPCCodeByID($data->parent,$search);
			} else {
				if(count($this->ipcCodeData)==0){
					array_push($this->ipcCodeData,$data);
				}
			}
		}
		return $this->ipcCodeData;
	}
}
?>