<?php
class Customer_model extends CI_Model{
	
	public $table_customer = 'customers';
	public $table_company = 'company';
	public $table_company_sector = 'company_sector';
	public $table_technology_preference = 'technology_preference';
	public $table_sector = 'sectors';
	public $table = "contacts";
	public $table_category = 'category';
	public $table_map_sector_category = 'map_sectors_departments';
	public $table_preference = 'preferences';
	public $table_wishlist = 'wishlist';
	public $table_customer_request = 'customer_request';
	public $table_membership_payments = 'membership_payments';
	public $table_draft_revised_documents = 'draft_revised_documents';
	public $table_request_for_check_availabilty = 'request_for_check_availabilty';
	public $table_request_to_participates = 'request_to_participates';
	public $table_acquisition_company = 'acquisition_company';
	public $table_invitees = 'backyard_invitees';
	public $pre_companies = 'pre_companies';
	public $table_scrapper_captcha_code = 'scrapper_captcha_code';
	public $table_similar_industry = 'similar_industry';
	public $table_email_scrapper = "email_scrapper";
	public $table_speciality = "speciality";
	public $table_speciality_company = "map_company_speciality";
	public $table_company_other_names = "company_other_names";
	public $table_due_dilligence_citations = 'due_dilligence_citations';
	public $table_scrape_companies = 'scrape_companies';
	
	public function checkEmailFromRequest($email){
		$queryMySend = $this->db->select("count(*) as userCount")->from($this->table_customer_request.' as c')->where('c.email',$email)->get()->row();
		return $queryMySend->userCount;
	}
	
	public function checkSpeciality($specialityName){
		$this->db->query("SET NAMES 'UTF8'");
		$this->db->query("SET CHARACTER SET 'utf8'");
		$this->db->query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
		$result = $this->db->select("id")->from($this->table_speciality.' as s')->where('s.name',$specialityName)->get();
		$ID = 0;
		if($result->num_rows()>0){
			$data = $result->first_row();
			$ID = $data->id;
		}
		return $ID;
	}
	
	public function insertBatchEmailScrapper($insertArrayBulk){
		$this->db->insert_batch($this->table_email_scrapper,$insertArrayBulk);
		return $this->db->affected_rows();
	}
	
	public function insertSpeciality($data){
		$this->db->query("SET NAMES 'UTF8'");
		$this->db->query("SET CHARACTER SET 'utf8'");
		$this->db->query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
		$this->db->insert($this->table_speciality, $data);
		return $this->db->insert_id();
	}
	
	public function addMapSpecialityCompanyInBulk($insertArrayBulk){		
		$this->db->insert_batch($this->table_speciality_company,$insertArrayBulk);
		return $this->db->affected_rows();
	}
	
	public function checkUsersInEmailScrapper($contactIDs){
		$query = $this->db->select("contact_id as id")->from($this->table_email_scrapper)->where_in('contact_id',$contactIDs)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->result();
		}
		return $data;
	}
	
	public function getCaptchaImage($JobID){
		$data = array('details'=>array(),'count'=>0);
		$queryMySend = $this->db->select("image,id,user_id")->from($this->table_scrapper_captcha_code.' as c')->where('c.job_id',$JobID)->where('status',0)->order_by('id','desc')->get();
		if($queryMySend->num_rows()>0){
			$data['details'] = $queryMySend->first_row();
		}
		$data['count'] = $this->db->select("count(*) as countImage")->from($this->table_scrapper_captcha_code.' as c')->where('c.job_id',$JobID)->where('status',1)->order_by('id','desc')->get()->row()->countImage;		
		return $data;
	}
	
	public function getUSPTOCaptcha($ID){
		$data = array();
		$queryMySend = $this->db->select("image,id,user_id")->from($this->table_scrapper_captcha_code.' as c')->where('c.id',$ID)->where('status',0)->get();
		if($queryMySend->num_rows()>0){
			$data = $queryMySend->first_row();
		}
		return $data;
	}
	
	public function updateCaptchaCode($data,$ID){
		$this->db->where('id',$ID);
		$this->db->update($this->table_scrapper_captcha_code, $data);
		return $this->db->affected_rows();
	}
	
	public function updateMembership($data,$ID){
		$this->db->where('id',$ID);
		$this->db->update($this->table_membership_payments, $data);
		return $this->db->affected_rows();
	}
	
	public function deleteMembershipPayments($ID){
		$this->db->delete($this->table_membership_payments,array('id'=>$ID));	
		return $this->db->affected_rows();
	}
	
	public function updateALLContactsBelongToCompany($data,$companyID){
		$this->db->where('company_id',$companyID);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}
	
	public function updateALLCompanyContacts($data,$companyIDs){
		$this->db->where_in('company_id',$companyIDs);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}
	public function updateALLContacts($data,$contactIDs){
		$this->db->where_in('id',$contactIDs);
		$this->db->update($this->table, $data);
		return $this->db->affected_rows();
	}
	
	
	public function getCustomerRequest($Id){
		$queryMySend = $this->db->select("*")->from($this->table_customer_request.' as c')->where('c.id',$Id)->get()->row();
		return $queryMySend;
	}
	
	public function getCustomerByID($Id){
		$queryMySend = $this->db->select("*")->from($this->table_customer.' as c')->where('c.id',$Id)->get()->row();
		return $queryMySend;
	}
	
	public function findCustomerRequestByEmail($email){
		$queryMySend = $this->db->select("*")->from($this->table_customer_request.' as c')->where('c.email',$email)->get()->row();
		return $queryMySend;
	}
	public function checkCustomerByContactID($contactID){
		$queryMySend = $this->db->select("*")->from($this->table_customer.' as c')->where('c.contact_id',$contactID)->get()->row();
		return $queryMySend;
	}
	
	public function deleteCustomerRequest($ID){
		$affectedRow = 0;
		$getCustomerRequest = $this->getCustomerRequest($ID);
		if(count($getCustomerRequest)>0){
			if($getCustomerRequest->request_id>0){
				switch($getCustomerRequest->type){
					case 0:
						/*request for license or participate*/
						$this->db->where('customer_id',$getCustomerRequest->id);
						$this->db->where('id',$getCustomerRequest->request_id);
						$this->db->delete($this->table_request_to_participates);
						break;
					case 1:
						/*draft revised document*/
						$this->db->where('customer_id',$getCustomerRequest->id);
						$this->db->where('id',$getCustomerRequest->request_id);
						$this->db->delete($this->table_draft_revised_documents);
						break;
					case 2:
						/*Check Availability*/
						$this->db->where('customer_id',$getCustomerRequest->id);
						$this->db->where('id',$getCustomerRequest->request_id);
						$this->db->delete($this->table_request_for_check_availabilty);
						break;
				}
			}
			$this->db->delete($this->table_customer_request,array('id'=>$ID));	
			$affectedRow = $this->db->affected_rows();
		}
		return $affectedRow;
	}
	public function checkEmail($email, $mode = 1){
		if($mode==1){
			$queryMySend = $this->db->select("count(*) as userCount")->from($this->table_customer.' as c')->where('c.email',$email)->get()->row();
			return $queryMySend->userCount;		
		} else {
			$queryMySend = $this->db->select("*")->from($this->table_customer.' as c')->where('c.email',$email)->get()->row();
			return $queryMySend;	
		}		
	}
	
	public function checkUserWithIDAndEmail($customerID,$email){
		$queryMySend = $this->db->select("*")->from($this->table_customer.' as c')->where('c.email',$email)->where('id',$customerID)->get()->row();
		return $queryMySend;	
	}
	
	public function checkActivationCode($code){
		$queryMySend = $this->db->select("*")->from($this->table_customer.' as c')->where('c.activation_code',$code)->get()->row();
		return $queryMySend;
	}
	
	public function customerRequestActivationCode($code){
		$queryMySend = $this->db->select("*")->from($this->table_customer_request.' as c')->where('c.activation_code',$code)->get()->row();
		return $queryMySend;
	}
	
	public function checkCompanyExist($companyName){
		$queryMySend = $this->db->select("count(*) as companyCount")->from($this->table_company.' as c')->where('LOWER(c.company_name)',strtolower(trim($companyName)))->get()->row();
		return $queryMySend->companyCount;		
	}
	
	public function getCompanyData($companyName){
		$queryMySend = $this->db->select("*")->from($this->table_company.' as c')->where('LOWER(c.company_name)',strtolower(trim($companyName)))->get()->row();
		return $queryMySend;		
	}	
	
	public function findCompanyByName($companyName){
		$data = array();
		$queryMySend = $this->db->select("*")->from($this->table_company.' as c')->where('LOWER(c.company_name) LIKE "%'.addslashes(strtolower(trim($companyName))).'%"')->get();
		if ($queryMySend->num_rows() > 0) {
			$data = $queryMySend->result();
        }
		return $data;		
	}
	
	public function getCustomerList($companyName,$select="c.*"){
		$data = array();
		$queryMySend = $this->db->select($select)->from($this->table_company.' as c')->join($this->table_customer.' as cu','cu.company_id=c.id','INNER')->where('LOWER(c.company_name) LIKE "%'.addslashes(strtolower(trim($companyName))).'%"')->get();
		if ($queryMySend->num_rows() > 0) {
			$data = $queryMySend->result();
        }
		return $data;		
	}
	
	public function findCompaniesLinkedinWithAbout(){
		$data = array();
		$queryMySend = $this->db->select("*")->from($this->table_company.' as c')->where('c.linkedin_url LIKE "%about%"')->get();
		if ($queryMySend->num_rows() > 0) {
			$data = $queryMySend->result();
        }
		return $data;		
	}
	
	public function findCompaniesByLinkedinUrl($linkedinURL,$select = "*"){
		$data = array();
		$queryMySend = $this->db->select($select)->from($this->table_company.' as c')->where('c.linkedin_url LIKE "%'.$linkedinURL.'%"')->get();
		if ($queryMySend->num_rows() > 0) {
			$data = $queryMySend->result();
        }
		return $data;		
	}
	
	public function findCompaniesWithLogo(){
		$data = array();
		$queryMySend = $this->db->select("id,company_logo")->from($this->table_company.' as c')->where('c.company_logo LIKE "%backyard%"')->get();
		if ($queryMySend->num_rows() > 0) {
			$data = $queryMySend->result();
        }
		return $data;		
	}
	public function findNewCompanyScrapped(){
		$data = array();
		$queryMySend = $this->db->query("Select id as company,linkedin_url,company_name,11 as type,0 as user_id from company where no_of_employees = 0 and company_logo is null and owler_url = '' and  linkedin_url <> '' order by id desc");
		if ($queryMySend->num_rows() > 0) {
			$data = $queryMySend->result();
        }
		return $data;		
	}
	
	public function getCompaniesListJSON($companyName){
		$query = $this->db->select("c.company_name,c.linkedin_url,c.id")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id')->where('LOWER(c.company_name) LIKE "%'.strtolower(trim($companyName)).'%"')->where('cs.sector_id',21)->order_by('c.company_name',' ASC')->get();
		$data = array('companies'=>array(),'other_list'=>array());
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data['companies'][] = $row->company_name;
                $data['other_list'][] = $row;
            }
        }	
		$query = $this->db->select("c.company_name,c.linkedin_url,c.id")->from($this->pre_companies.' as c')->where('LOWER(c.company_name) LIKE "%'.strtolower(trim($companyName)).'%"')->order_by('c.company_name',' ASC')->get();
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data['companies'][] = $row->company_name;
                $data['other_list'][] = $row;
            }
        }
		return $data; 
	}
	
	function getCategoriesListJSON($categoryName){
		$sectorID = 21;
		$data = array('categories'=>array(),'sub_category'=>array(),'other_list'=>array());
		$query = $this->db->query("SELECT name,id FROM ".$this->table_category." WHERE id IN (SELECT category_id FROM ".$this->table_map_sector_category."  WHERE sector_id=".(int)$sectorID.") ORDER BY name ASC");
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data['categories'][] = $row->name;
				if(trim($categoryName)!="" && $row->name == trim($categoryName)){					
					$querySubCategory = $this->db->select("*")->from($this->table_category)->where("parent IN (SELECT id FROM ".$this->table_category." WHERE type=0 AND name ='".$categoryName."')")->order_by('name','ASC')->get();
					if ($querySubCategory->num_rows() > 0) {
						foreach ($querySubCategory->result() as $rowSub) {
							$data['sub_category'][] = $rowSub->name;
							$data['other_list'][] = $rowSub;
						}
					}
				}
            }
        }
		return $data; 
	}
	
	public function getAllCustomerRequest(){
		$this->db->limit(2000,0);
		$query = $this->db->select("*")->from($this->table_customer_request)->where('activation_code','')->where('status',1)->order_by('id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		return $data; 
	}
	
	public function getAllMembersipPayments(){
		$this->db->limit(2000,0);
		$query = $this->db->select("m.*, c.first_name,c.last_name,c.email,co.company_name")->from($this->table_membership_payments.' as m')->join($this->table_customer.' as c','c.id = m.customer_id')->join($this->table_company.' as co','co.id = c.company_id')->order_by('m.id','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data; 
	}
	
	public function getMembershipData($ID) {
		$query = $this->db->select("m.*, co.id as company_id")->from($this->table_membership_payments.' as m')->join($this->table_customer.' as c','c.id = m.customer_id')->join($this->table_company.' as co','co.id = c.company_id')->where('m.id',$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->first_row();
        }
		return $data; 
	}
	
	public function insertCustomerRequest($data){
		$this->db->insert($this->table_customer_request, $data);
		return $this->db->insert_id();
	}
	
	public function insertCustomer($data){
		$this->db->insert($this->table_customer, $data);
		return $this->db->insert_id();
	}
	
	public function deleteCompanySector($companyID){
		$this->db->where('company_id',$companyID);
		$this->db->delete($this->table_company_sector);
	}
	
	public function deleteCompanySectors($companyIDs){
		$this->db->where_in('company_id',$companyIDs);
		$this->db->delete($this->table_company_sector);
	}
	
	public function addCompanySector($data){
		$this->db->insert($this->table_company_sector, $data);
		return $this->db->insert_id();
	}
	
	public function addCompanySectorInBatch($insertArrayBulk){
		$this->db->insert_batch($this->table_company_sector,$insertArrayBulk);
		return $this->db->affected_rows();
	}
	
	public function updateCompanySectorWithCompanyID($companyID,$data){
		$this->db->where("company_id",$companyID);
		$this->db->update($this->table_company_sector, $data);
		/*echo $this->db->last_query();*/
		return $this->db->affected_rows();
	}
	
	public function updateCustomerRequest($ID,$data){
		$this->db->where("id",$ID);
		$this->db->update($this->table_customer_request, $data);
		return $this->db->affected_rows();
	}
	
	public function updateContactsFromAllCompanies($mergerCompanies,$survivourCompany){
		$checkCountUsers = $this->db->select('count(*) as countUsers')->from($this->table)->where_in("company_id",$mergerCompanies)->get()->row()->countUsers;
		/*Check Linkedin Url for the Surviour company*/
		$survivourData = $this->db->select('linkedin_url,owler_url')->from($this->table_company)->where('id',$survivourCompany[0])->get()->row();
		$linkedInUrl = $survivourData->linkedin_url;
		$owlerUrl = $survivourData->owler_url;
		$companyNames = array();
		if($linkedInUrl=="" || $owlerUrl == ""){
			/*Update linkedin url from merger companies */
			if($linkedInUrl == ""){
				$dataQuery = $this->db->select('linkedin_url,linkedin_name,company_name')->from($this->table_company)->where_in('id', $mergerCompanies)->get();
				if($dataQuery->num_rows()>0){
					$data = $dataQuery->result();
					foreach($data as $row){
						$companyNames[] = $row->company_name;
						if($row->linkedin_url!=''){
							$affectedRow = $this->updateCompanyData($survivourCompany[0],array('linkedin_name'=>$row->linkedin_name,'linkedin_url'=>$row->linkedin_url));	
							if($affectedRow>0){
								break;
							}
						}
					}
				}
			}
			$dataQuery = $this->db->select('owler_url,owler_description,competitors,owler_company_revenue,scrapped_owler_date,scrape_owler')->from($this->table_company)->where_in('id', $mergerCompanies)->get();
			if($dataQuery->num_rows()>0){
				$data = $dataQuery->result();
				foreach($data as $row){
					if($row->owler_url!=''){
						$affectedRow = $this->updateCompanyData($survivourCompany[0],array('owler_url'=>$row->owler_url,'owler_description'=>$row->owler_description,'competitors'=>$row->competitors,'owler_company_revenue'=>$row->owler_company_revenue,'scrapped_owler_date'=>$row->scrapped_owler_date,'scrape_owler'=>$row->scrape_owler));	
						if($affectedRow>0){
							break;
						}
					}
				}
			}			
		}
		/*other names*/
		$otherNames = array();
		$dataQuery = $this->db->select('name')->from($this->table_company_other_names)->where_in('company_id', $mergerCompanies)->get();
		if($dataQuery->num_rows()>0){
			$data = $dataQuery->result();
			foreach($data as $row){
				array_push($otherNames,array('name'=>$row->name,'company_id'=>$survivourCompany[0]));
			}
		}
		if(count($companyNames) > 0){
			foreach($data as $row){
				array_push($otherNames,array('name'=>$row,'company_id'=>$survivourCompany[0]));
			}
		}

		if(count($otherNames) >0){
			$this->insertBatchCompanyOtherName($otherNames);
		}
		if($checkCountUsers == null || $checkCountUsers==0){
			$this->db->where_in('id', $mergerCompanies);
			$affectedR = $this->db->delete($this->table_company);
		} else {
			$this->db->where_in("company_id",$mergerCompanies);
			$this->db->update($this->table, array('company_id'=>$survivourCompany[0]));
			$affectedR = $this->db->affected_rows();
			$this->db->where_in('id', $mergerCompanies);
			$this->db->delete($this->table_company);
		}
		$this->db->where_in('id', $mergerCompanies);
		$this->db->delete($this->table_company_other_names);
		return $affectedR;
	}
	
	public function insertCustomerPreference($data){
		$this->db->insert($this->table_preference, $data);
		return $this->db->insert_id();
	}
	
	public function deleteCustomerPreference($customerID){
		$this->db->delete($this->table_preference,array('customer_id'=>$customerID));	
		return $this->db->affected_rows();
	}
	
	public function deleteCustomersPreference($customerIDs){
		$this->db->where_in('customer_id', $customerIDs);
		$this->db->delete($this->table_preference);	
		return $this->db->affected_rows();
	}
	
	public function insertCustomerPreferenceInBatch($insertArrayBulk){
		$this->db->insert_batch($this->table_preference,$insertArrayBulk);
		return $this->db->affected_rows();
	}
	
	public function deleteCustomersTechnologyPreference($customerIDs){
		$this->db->where_in('company_id', $customerIDs);
		$this->db->delete($this->table_technology_preference);	
		return $this->db->affected_rows();
	}
	
	public function insertCustomerTechnologyPreferenceInBatch($insertArrayBulk){
		$this->db->insert_batch($this->table_technology_preference,$insertArrayBulk);
		return $this->db->affected_rows();
	}
	
	public function insertBatchCompanyOtherName($insertArrayBulk){
		$this->db->insert_batch($this->table_company_other_names,$insertArrayBulk);
		return $this->db->affected_rows();
	}
	
	public function insertCompanyOtherName($insertData){
		$this->db->insert($this->table_company_other_names,$insertData);
		return $this->db->insert_id();
	}
	
	public function updateCompanyOtherName($data,$ID){
		$this->db->where('id',$ID);
		$this->db->update($this->table_company_other_names,$data);
		return $this->db->affected_rows();
	}
	
	public function deleteOtherCompanyNamesInBulk($IDs){
		$this->db->where_in('id',$IDs);
		$this->db->delete($this->table_company_other_names);
		return $this->db->affected_rows();
	}
	
	public function insertCompany($data){
		$this->db->query("SET NAMES 'UTF8'");
		$this->db->query("SET CHARACTER SET 'utf8'");
		$this->db->query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
		$this->db->insert($this->table_company, $data);
		return $this->db->insert_id();
	}
	
	public function insertCompanyBatch($data){
		$this->db->query("SET NAMES 'UTF8'");
		$this->db->query("SET CHARACTER SET 'utf8'");
		$this->db->query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
		$this->db->insert_batch($this->table_company, $data);
		return $this->db->affected_rows();
	}
	
	public function insertPreCompaniesBatch($data){
		$this->db->query("SET NAMES 'UTF8'");
		$this->db->query("SET CHARACTER SET 'utf8'");
		$this->db->query("SET COLLATION_CONNECTION = 'utf8_unicode_ci'");
		$this->db->insert_batch($this->pre_companies, $data);
		echo $this->db->last_query();
		return $this->db->affected_rows();
	}
	
	public function insertWishlist($data){
		$this->db->insert($this->table_wishlist, $data);
		return $this->db->insert_id();
	}
	
	public function checkWishList($productID,$customerID){
		$queryMySend = $this->db->select("*")->from($this->table_wishlist.' as w')->where('w.customer_id',$customerID)->where('w.portfolio_id',$productID)->get()->row();
		return $queryMySend;
	} 
	
	public function deleteWishlist($ID){
		$this->db->delete($this->table_wishlist,array('id'=>$ID));	
		return $this->db->affected_rows();
	}
	
	public function updateUserInfo($userID,$data){
		$this->db->where('id',$userID);
		$this->db->update($this->table_customer,$data);
		return $this->db->affected_rows();
	}
	
	public function updateCompanyData($companyID,$data){
		$this->db->where('id',$companyID);
		$this->db->update($this->table_company,$data);
		return $this->db->affected_rows();
	}
	
	public function updateCompaniesData($companyIDs,$data){
		$this->db->where_in('id',$companyIDs);
		$this->db->update($this->table_company,$data);
		return $this->db->affected_rows();
	}
	
	public function updateSpeciality($ID,$data){
		$this->db->where('id',$ID);
		$this->db->update($this->table_speciality,$data);
		echo "Query:".$this->db->last_query()."<br/>";
		return $this->db->affected_rows();
	}
	
	public function deleteCustomer($customerID){
		$this->db->delete($this->table_customer,array('id'=>$customerID));	
		return $this->db->affected_rows();
	}
	public function deleteCompany($companyID){
		$this->db->delete($this->table_company,array('id'=>$companyID));
		$affectedRows = $this->db->affected_rows();
		$this->db->delete($this->table_company_other_names,array('company_id'=>$companyID));
		$this->db->where('company_id',$companyID)->update($this->table_due_dilligence_citations,array('company_id'=>0));
		return $affectedRows;
	}
	
	public function login($email,$password){
		$query = $this->db->select("c.*,cc.id as company_id, cc.company_name, cc.company_address,cc.telephone,cc.bank_name,cc.bank_account_no,cc.routing_no,cc.membership,cc.start_date,cc.end_date")->from($this->table_customer .' as c')->join($this->table_company.' as cc','c.company_id=cc.id')->where("c.email",$email)->where("c.password",$password)->get();
		$data = array();
		if(count($query->num_rows())>0){
			$data = $query->first_row();
			$this->updateUserInfo($data->id,array('last_login'=>date('Y-m-d H:i:s')));
		}
		return $data;
	}
	
	public function checUserDetail($userID){
		$query = $this->db->select("c.*,cc.id as company_id, cc.company_name, cc.company_address,cc.telephone,cc.bank_name,cc.bank_account_no,cc.routing_no,cc.membership,cc.start_date,cc.end_date")->from($this->table_customer .' as c')->join($this->table_company.' as cc','c.company_id=cc.id')->where("c.id",$userID)->get();
		$data = array();
		if(count($query->num_rows())>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function getCategoryAndSubCategoryList($parent){
		$getList = $this->categoryList($parent);
		if(count($getList)>0){
			for($i=0;$i<count($getList);$i++){
				$getSubCateList = $this->categoryList($getList[$i]->id);
				$getList[$i]->sub_category = $getSubCateList;
			}
		}
		return $getList;
	}
	
	public function categoryList($categoryParent){
		$query = $this->db->select("*")->from($this->table_category)->where("parent",$categoryParent)->order_by('name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		return $data; 
	}
	
	function getCategoryBySector($sectorID){
		$query = $this->db->query("SELECT * FROM ".$this->table_category." WHERE id IN (SELECT category_id FROM ".$this->table_map_sector_category."  WHERE sector_id=".(int)$sectorID.") ORDER BY id ASC");
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		return $data; 
	}
	
	function getCategoryByAllSector($sectors){
		$data = array();
		if(count($sectors)){
			foreach($sectors as $sec){
				$query = $this->db->query("SELECT * FROM ".$this->table_category." WHERE id IN (SELECT category_id FROM ".$this->table_map_sector_category."  WHERE sector_id=".(int)$sec->sectorID.") ORDER BY id ASC");
				if ($query->num_rows() > 0) {
					$data = array_merge($data,$query->result());
					/*foreach ($query->result() as $row) {
						$data[] = $row;
					}*/
				}
			}			
		}		
		return $data;
	}
	
	function findDuplicatesLinkedinUrlCompanies(){
		$query = "SELECT id,company_name,linkedin_url FROM company as c WHERE linkedin_url<>''  GROUP BY linkedin_url HAVING COUNT(*)>1";
		$getResult = $this->db->query($query);
		$data = array();
		if ($getResult->num_rows() > 0) {
            $data = $getResult->result();
        }
		return $data; 
	}
	
	function updateFromCategoryToTechnologies(){
		$query = $this->db->select("company_id")->from($this->table_company_sector)->where('sector_id',79)->order_by('id','ASC')->get();
		$data = array();
		$technologiesCategory = $this->getCategoryBySector(21);
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$queryPreference = $this->db->select("preference_id")->from($this->table_preference)->where('customer_id',$row->company_id)->order_by('id','ASC')->get();
				if ($queryPreference->num_rows() > 0) {
					foreach ($queryPreference->result() as $rowPreference) {
						if(count($technologiesCategory)>0){
							foreach($technologiesCategory as $techCategory){
								if($rowPreference->preference_id==$techCategory->id){
									$parent = $this->db->select('parent')->from($this->table_category)->where('id',$techCategory->id)->get()->row()->parent;
									if($parent>0){
										$parent = 1;
									}
									$this->db->insert($this->table_technology_preference, array('company_id'=>$row->company_id,'preference_id'=>$rowPreference->preference_id,'type'=>$parent));
									echo $this->db->insert_id()."<br/>";
									break;
								}
							}
						}
					}
				}
			}
		}
	}
	
	public function mainCategoryList(){
		$query = $this->db->select("*")->from($this->table_category)->where("id IN(1,2,3,4,5,6,7,8,9,10,11,12)")->order_by('id','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		return $data; 
	}
	
	public function categoryListWithMoreThanOne($listCategories){
		$explodeCategory = explode(',',$listCategories);
		$data = array();
		if(count($explodeCategory)>0){
			foreach($explodeCategory as $parentCat){
				$query = $this->db->select("*")->from($this->table_category)->where("parent",$parentCat)->order_by('name','ASC')->get();
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data[] = $row;
					}
				}
			}
		}		
		return $data; 
	}
	
	public function getCustomerWishListIDs($customerID){
		$query = $this->db->query('SELECT w.portfolio_id FROM '.$this->table_wishlist.' as w WHERE w.customer_id IN (SELECT id FROM '.$this->table_customer.' WHERE company_id = (SELECT company_id FROM '.$this->table_customer.' WHERE id='.$customerID.')) ORDER BY w.id ASC'); 
		$data = array();
		if ($query->num_rows() > 0) {
			$results = $query->result();
            foreach ($results as $row) {
                $data[] = $row->portfolio_id;
            }
        }
		return $data; 
	}
	
	public function getUsersList($companyID){
		$query = $this->db->select("*")->from($this->table_customer)->where("company_id",$companyID)->order_by('first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		return $data; 
	}
	
	public function findCompetitorCompany($list){
		$data = array();
		$this->db->_protect_identifiers=false;
		$query = $this->db->select("id,owler_url,0 as contact")->from($this->table_company)->where_in("owler_url",$list)->get();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		return $data; 
	}
	
	public function findCompetitorFromInvitedList($leadID,$activity,$list){
		$companies = array();
		foreach($list as $company){
			array_push($companies,$company->id);
		}
		$data = array();		
		if($activity == 0){
			$tableCheck = array(1,2);
		} else if ($activity == 1){
			$tableCheck = array(1);
		} else if ($activity == 2){
			$tableCheck = array(2);
		}
		foreach($tableCheck as $chk){
			if($chk == 1){
				$getInvitedCompanies = $this->db->select("i.contact_id")->from($this->table_invitees.' as i')->where("i.lead_id",$leadID)->where_in("i.contact_id",$companies)->get();
				if ($getInvitedCompanies->num_rows() > 0) {
					$data = $getInvitedCompanies->result();
					foreach($data as $c){
						for($i = 0;$i<count($list);$i++){
							if($list[$i]->id == $c->contact_id){
								$list[$i]->contact = 1;
								break;
							}
						}
					}
				}
			} else if($chk == 2){
				$getAcquisitionCompanies = $this->db->select("i.contact_id")->from($this->table_acquisition_company.' as i')->where("i.lead_id",$leadID)->where_in("i.contact_id",$companies)->get();
				if ($getAcquisitionCompanies->num_rows() > 0) {
					$data = $getAcquisitionCompanies->result();
					foreach($data as $c){
						for($i = 0;$i<count($list);$i++){
							if($list[$i]->id == $c->contact_id){
								$list[$i]->contact = 1;
								break;
							}
						}
					}
				}
			}			
		}		
		return $list; 
	}
	
	public function findMyPreference($customerID){
		$query = $this->db->select("*")->from($this->table_preference)->where("customer_id",$customerID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
             $data = $query->result();
        }
		return $data; 
	}
	
	public function findMyPreferenceWithName($customerID){
		$query = $this->db->select("c.*")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.customer_id",$customerID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			 $data = $query->result();
        }
		return $data; 
	}
	
	/*public function getCompanyDataByID($companyID){
		$query = $this->db->select("c.*,s.name as sectorName, s.id as sectorID")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('c.id',$companyID)->order_by('c.company_name','ASC')->get();		
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
			$data->broker_details = $this->findBrokerDetails($data->broker);
			$data->companyUsers = $this->getAllContactBelongToCompany($companyID);
			$data->categories = $this->getCategoryBySector($data->sectorID);
			$departments = $this->findMyPreferenceWithNameSub($companyID,0);
			$subdepartments = $this->findMyPreferenceWithNameSub($companyID,1);
			$selctedcategory = array();
			foreach($departments as $sub){
				$selctedcategory[] = $sub->id;
			}
			$data->departments_list = $departments;
			$data->subdepartments_list = $subdepartments;
			if(count($selctedcategory)>0){
				$data->sub_categories = $this->categoryListWithMoreThanOne(implode(',',$selctedcategory));
			} else {
				$data->sub_categories = array();
			}
        }
		return $data;
	}*/
	
	public function findCompanyDataByUserIDAndEmail($userID,$userEmail){
		$query = $this->db->select("c.*")->from($this->table.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where('c.id',$userID)->where('c.email',$userEmail)->or_where('c.secondary_email',$userEmail)->or_where('c.tertiary_email',$userEmail)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$userData = $query->first_row();
			$companyID = $userData->company_id;
			$query = $this->db->select("c.*")->from($this->table_company.' as c')->where('c.id',$companyID)->order_by('c.company_name','ASC')->get();	
			if ($query->num_rows() > 0) {
				$data = $query->first_row();			
				$data->sectors = $this->findCompanySectors($companyID);
				$data->broker_details = $this->findBrokerDetails($data->broker);
				$data->companyUsers = $this->getAllContactBelongToCompany($companyID);
				/*$data->categories = $this->getCategoryBySector($data->sectorID);*/
				$data->categories = $this->getCategoryByAllSector($data->sectors);
				$departments = $this->findMyPreferenceWithNameSub($companyID,0);
				$subdepartments = $this->findMyPreferenceWithNameSub($companyID,1);
				$selctedcategory = array();
				foreach($departments as $sub){
					$selctedcategory[] = $sub->id;
				}
				$data->departments_list = $departments;
				$data->subdepartments_list = $subdepartments;
				if(count($selctedcategory)>0){
					$data->sub_categories = $this->categoryListWithMoreThanOne(implode(',',$selctedcategory));
				} else {
					$data->sub_categories = array();
				}
			}
        } 
	}
	
	public function getCompanyDataByIDWithOptions($companyID,$select){
		$query = $this->db->select($select)->from($this->table_company.' as c')->where('c.id',$companyID)->order_by('c.company_name','ASC')->get();	
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
		}
		return $data;
	}
	
	public function getCompanyByName($companyName,$select){
		$query = $this->db->select($select)->from($this->table_company.' as c')->where('c.company_name',$companyName)->order_by('c.company_name','ASC')->get();	
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
		}
		return $data;
	}
	
	public function getCompanyDataByID($companyID){
		$query = $this->db->select("c.*")->from($this->table_company.' as c')->where('c.id',$companyID)->order_by('c.company_name','ASC')->get();		
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
			$parentName = "";
			if($data->parent_c>0){
				$getCname = $this->getCompanyDataByIDWithOptions($data->parent_c, 'c.company_name,c.company_logo');
				if(count($getCname)>0){
					$parentName = $getCname->company_name;
					if($getCname->company_logo!=''){
						$data->company_logo = $getCname->company_logo;
					}					
				}
			}
			$data->parentName = $parentName;
			$data->sectors = $this->findCompanySectors($companyID);
			$data->broker_details = $this->findBrokerDetails($data->broker);
			$data->companyUsers = $this->getAllContactBelongToCompany($companyID);
			$data->list = $this->getSimilarOrganization($companyID);
			/*$data->categories = $this->getCategoryBySector($data->sectorID);*/
			$departments = $this->findMyPreferenceWithNameSub($companyID,1);
			$deptNames = "";
			$subdeptNames = "";
			$mapSubCategory = array();
			$mapCategpry = array();
			foreach($departments as $deptt){
				if($deptt->parent==0){
					$deptNames .= $deptt->name.", ";
					if(!in_array($deptt->id,$mapCategpry)){
						$mapCategpry[] = $deptt->id;
						$category[] = array('id'=>$deptt->id,'name'=>$deptt->name);
					}						
				} else {
					$subdeptNames .= $deptt->name.", ";						
					if(!in_array($deptt->id,$mapSubCategory)){
						$mapSubCategory[] = $deptt->id;
						$subCategory[] = array('id'=>$deptt->id,'name'=>$deptt->name);
					}
				}					
			}
			$deptNames= substr($deptNames,0,-2);
			$subdeptNames= substr($subdeptNames,0,-2);
			$data->departments_list = $deptNames;
			$data->subdepartments_list = $subdeptNames;
			$data->categories = $deptNames;
			$data->sub_categories = $subdeptNames;
			
			$technologies = $this->findTechnologiesPreferenceWithNameSub($companyID,0);
			$technologyNames = "";
			if(count($technologies)>0){
				foreach($technologies as $tech){
					$technologyNames .= $tech->name.", ";
				}
				$technologyNames= substr($technologyNames,0,-2);
			}
			$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($companyID,1);
			$subTechnologyNames = "";
			$mapTech = array();
			if(count($subTechnologies)>0){
				foreach($subTechnologies as $tech){
					$subTechnologyNames .= $tech->name.", ";
					if(!in_array($tech->id,$mapTech)){
						$mapTech[] = $tech->id;
						$subTechnology[] = array('id'=>$tech->id,'name'=>$tech->name);
					}
				}
				$subTechnologyNames= substr($subTechnologyNames,0,-2);
			}
			$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($companyID,2);				
			if(count($subsubTechnologies)>0){
				foreach($subsubTechnologies as $tech){
					$subTechnologyNames .= $tech->name.", ";
					if(!in_array($tech->id,$mapTech)){
						$mapTech[] = $tech->id;
						$subTechnology[] = array('id'=>$tech->id,'name'=>$tech->name);
					}
				}
				$subTechnologyNames= substr($subTechnologyNames,0,-2);
			}
			$data->technology_names = $technologyNames;
			$data->sub_technology_names = $subTechnologyNames;
        }
		return $data;
	}

	public function getSimilarOrganization($companyID){
		$data = array();
		if($companyID>0){
			$query = $this->db->select("co.*")->from($this->table_similar_industry.' as si')->join($this->table_company.' as co', 'co.id = si.similar_company_id','left')->where('si.company_id',$companyID)->get();
			$data = $query->result();
		}
		return $data;
	}
	
	public function getAllCompanyIndustry(){
		$data = array();
		$query = $this->db->select("distinct(co.industry) as industry")->from($this->table_company.' as co')->where('co.industry <>',"")->order_by('industry','ASC')->get();
		$data = $query->result();
		return $data;
	}
	public function getAllCompanySize(){
		$data = array();
		$query = $this->db->select("distinct(co.company_size) as company_size")->from($this->table_company.' as co')->where('co.company_size <>',"0")->where('co.company_size <>',"")->order_by('company_size','ASC')->get();
		$data = $query->result();
		return $data;
	}
	
	public function getAllLinkedinCompanyUsers(){
		$data = array();
		$query = $this->db->select("DISTINCT(co.no_of_employees) as linkedinCompanyUsers")->from($this->table_company.' as co')->where('co.no_of_employees <> ',"")->where('co.no_of_employees <> ','null')->order_by('linkedinCompanyUsers','ASC')->get();
		$data = $query->result();
		return $data;
	}
	
	public function findCompanySectors($companyID){
		$data = array();
		if($companyID>0){
			$query = $this->db->select("s.name as sectorName, s.id as sectorID")->from($this->table_company_sector.' as cs')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.company_id',$companyID)->get();
			$data = $query->result();
		}
		return $data;
	}
	
	public function findAllCompanySectorsOptimized($companyIDs){
		$data = array();
		if(count($companyIDs)>0){
			$query = $this->db->select("s.name as sectorName, s.id as sectorID, cs.company_id")->from($this->table_company_sector.' as cs')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where_in('cs.company_id',$companyIDs)->get();
			$data = $query->result();
		}
		return $data;
	}
	
	public function findBrokerDetails($brokerID){
		$data = array();
		if($brokerID>0){
			$query = $this->db->select("c.*,co.company_name , co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.id',$brokerID)->get();
			if ($query->num_rows() > 0) {
				$data = $query->first_row();
			}
		}
		return $data;
	}
	
	function getCountAllContactBelongToAllCompanyOptimized($companyIDs){
		$queryUsersCount = $this->db->query("SELECT count(c.id) as countUsers, c.company_id  FROM ".$this->table." as c WHERE c.company_id IN (".implode(',',$companyIDs).") GROUP BY c.company_id");
		$getList = array();
		if ($queryUsersCount->num_rows() > 0) {
			$getList = $queryUsersCount->result();
		}
		return $getList;
	}
	
	function getAllContactBelongToAllCompany($companyIDs){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name,co.company_name")->from($this->table.' as c')->join($this->table_company.' as co','c.company_id = co.id','left')->where_in('c.company_id',$companyIDs)->order_by('c.company_id','ASC')->get();
		$getList = array();
		if ($query->num_rows() > 0) {
			$getList = $query->result();
		}
		return $getList;
	}
	
	function deletePreScrapeCompaniesInBulk($IDs){
		$this->db->where_in('company_id',$IDs);
		$this->db->delete($this->table_scrape_companies);
		return $this->db->affected_rows();
	}
	
	function getScrapeCompanyList(){
		$query = $this->db->select("company_id")->from($this->table_scrape_companies)->order_by('id','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	function getCountAllContactBelongToCompany($companyID){
		return $this->db->select("count(c.id) as countUsers")->from($this->table.' as c')->where('c.company_id',$companyID)->get()->row()->countUsers;
	}	
	function getAllContactBelongToCompany($companyID){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name,co.company_name,co.company_name_alias")->from($this->table.' as c')->join($this->table_company.' as co','c.company_id = co.id','left')->where('c.company_id',$companyID)->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	function getContactData($contactID){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name")->from($this->table.' as c')->where('c.id',$contactID)->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->first_row();
        }		
		return $data;
	}
	function getAllCompaniesContactWithLinkedinUrl($companyIDs){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name")->from($this->table.' as c')->where_in('c.company_id',$companyIDs)->where('c.linkedin_url <>','')->order_by('c.company_id','ASC')->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	function getAllContactsWithLinkedinUrl($contactIDs){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name")->from($this->table.' as c')->where_in('c.id',$contactIDs)->where('c.linkedin_url <>','')->order_by('c.id','ASC')->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	function getAllCompaniesListWithOwlerUrl($companyIDs){
		$query = $this->db->select("id,company_name,owler_url")->from($this->table_company.' as c')->where_in('c.id',$companyIDs)->where('c.owler_url <>','')->order_by('c.id','ASC')->order_by('c.company_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	function getAllCompaniesWithOthername(){
		$query = $this->db->select("id,other1,other2,other3,other4,other5,other6")->from($this->table_company.' as c')->order_by('c.company_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	function getCompanyOtherNames($companyID){
		$query = $this->db->select("*")->from($this->table_company_other_names.' as c')->where('c.company_id',$companyID)->order_by('c.name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	function getAllCompaniesListWithLinkedinUrl($companyIDs){
		$query = $this->db->select("id,company_name,linkedin_url")->from($this->table_company.' as c')->where_in('c.id',$companyIDs)->where('c.linkedin_url <>','')->order_by('c.no_of_employees','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	function getAllCompaniesWithLinkedinUrl($linkedInUrl){
		$query = $this->db->select("id,company_name,linkedin_url")->from($this->table_company.' as c')->where('c.linkedin_url',$linkedInUrl)->order_by('c.id','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }		
		return $data;
	}
	
	public function findAllCompanyBySearch($search){
		$getCompanyList = array();
		if($search != "") {
			$queryOther = $this->db->select('company_id')->from($this->table_company_other_names)->like('name',$search)->get();
			if ($queryOther->num_rows() > 0) {
				$list = $queryOther->result();
				foreach($list as $c){
					array_push($getCompanyList,$c->company_id);
				}
			} 
			$queryCompany = $this->db->select('id')->from($this->table_company)->like('company_name',$search)->get();
			if ($queryCompany->num_rows() > 0) {
				$list = $queryCompany->result();
				foreach($list as $c){
					array_push($getCompanyList,$c->id);
				}
			} 
		}
		$querySELECT = "SELECT distinct(c.id) as companyID, c.id, c.company_name,c.web_address, c.linkedin_url,c.scrapped_date,c.scrapped_profile_date,c.industry,c.no_of_employees,c.company_size,c.company_size_type,c.specialties,c.scrape_people_again,c.scrape_p, (SELECT count(*) as company_users FROM ".$this->table." WHERE company_id=c.id) as company_users,'' as sectorName, '' as department_names,'' as sub_department_names, '' as technology_names, '' as sub_technology_names , c.label, c.revenue, c.create_date FROM ".$this->table_company." as c";
		if($search != "") {
			if(count($getCompanyList)> 0){
				$buildQuery = $querySELECT." WHERE ";
				$buildQuery .= "c.id IN (".implode(',',$getCompanyList).")";
			} else {
				$buildQuery .= "(c.company_name LIKE '".$search."')";
			}
		} else {
			$buildQuery = $querySELECT;
		}
		$buildQuery .= " ORDER BY c.company_name ASC";
		$query = $this->db->query($buildQuery);
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
		}
		return $data;
	}
	
	public function findCompanyBySearch($search,$select){
		$queryOther = $this->db->select('company_id')->from($this->table_company_other_names)->like('name',$search)->get();
		
		$getCompanyList = array();
		if ($queryOther->num_rows() > 0) {
			$list = $queryOther->result();
			foreach($list as $c){
				array_push($getCompanyList,$c->company_id);
			}
		} 
		$queryCompany = $this->db->select('id')->from($this->table_company)->like('company_name',$search)->get();
		if ($queryCompany->num_rows() > 0) {
			$list = $queryCompany->result();
			foreach($list as $c){
				array_push($getCompanyList,$c->id);
			}
		} 
		if(empty($select)){
			$select = "c.*,s.name as sectorName, s.id as sectorID";
		}
		if(count($getCompanyList) == 0){
			$this->db->like('c.company_name',$search);
		} else {
			$this->db->where_in('c.id',$getCompanyList);
		}
		$query = $this->db->select($select)->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('c.company_name','ASC')->group_by('c.id')->get();
		
		/*
		if(empty($select)){
			$select = "c.*,s.name as sectorName, s.id as sectorID";
		}
		$query = $this->db->select($select)->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('c.company_name','ASC')->or_like('c.company_name',$search)->or_like('c.other1',$search)->or_like('c.other2',$search)->or_like('c.other3',$search)->or_like('c.other4',$search)->or_like('c.other5',$search)->or_like('c.other6',$search)->group_by('c.id')->get();*/
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data; 
	}
	
	public function findCompanySearch($search,$select){
		if(empty($select)){
			$select = "c.company_name,c.id";
		}
		$query = $this->db->select($select)->from($this->table_company.' as c')->like('c.company_name',$search)->or_like('c.other1',$search)->or_like('c.other2',$search)->or_like('c.other3',$search)->or_like('c.other4',$search)->or_like('c.other5',$search)->or_like('c.other6',$search)->order_by('c.company_name','ASC')->group_by('c.id')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data; 
	}
	
	public function getCompanyListWithLogo(){
		$query = $this->db->select("id,company_logo")->from($this->table_company.' as c')->where('c.company_logo <>','')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data; 
	}
	
	public function findCompaniesOwlerUrl($urls){
		$query = $this->db->select("id,company_name,owler_url")->from($this->table_company.' as c')->where_in('c.owler_url',$urls)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data; 
	}
	
	public function getCompanyListWithCompetitors(){
		$query = $this->db->select("id,competitors")->from($this->table_company.' as c')->where('c.competitors <>','')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data; 
	}
	
	public function companyListWithSectorName($select){
		if(empty($select)){
			$select = "c.*,s.name as sectorName, s.id as sectorID";
		}
		$query = $this->db->select($select)->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->group_by('c.id')->order_by('c.company_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	public function findSectorListFromCompanies($companiesList){
		$query = $this->db->select('cs.sector_id')->from($this->table_company_sector.' as cs')->where_in('cs.company_id',$companiesList)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	public function companyByID($activity=0,$leadID=0,$name){		
		if(is_numeric($name)){
			$query = $this->db->select("c.*")->from($this->table_company.' as c')->where('c.id',(int)$name)->get();
		} else {
			$query = $this->db->select("c.*")->from($this->table_company.' as c')->like('c.company_name',urldecode($name))->get();
		}
		$data = array();
		$mapSectors = array();
		$dataSectors = array();
		$dataSubSectors = array();
		$mapSubSectors = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				if($activity==1){
					$queryAdded = $this->db->select("c.id")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_invitees.' as i','c.id=i.contact_id')->where("i.lead_id",$leadID)->where('i.contact_id',$row->id)->get();
				} else if($activity==2){
					$queryAdded = $this->db->select("c.id")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_acquisition_company.' as i','c.id=i.contact_id')->where("i.lead_id",$leadID)->where('i.contact_id',$row->id)->get();
				}else{
					$queryAdded = $this->db->select("c.id")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_invitees.' as i','c.id=i.contact_id')->where("i.lead_id",$leadID)->where('i.contact_id',$row->id)->get();
					if( $queryAdded->num_rows==0){
						$queryAdded = $this->db->select("c.id")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_acquisition_company.' as i','c.id=i.contact_id')->where("i.lead_id",$leadID)->where('i.contact_id',$row->id)->get();
					}
				}
				$selected = false;
				if(isset($queryAdded) && $queryAdded->num_rows()>0){
					$selected = true;
				}
				$row->selected = $selected;
				$usersList = $this->getCountAllContactBelongToCompany($row->id);
				$sectors = $this->findCompanySectors($row->id);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->id,0);
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
				$subdepartments = $this->findMyPreferenceWithNameSub($row->id,1);
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
				$data[] = $row;
			}
		}
		return $data; 
	}
	
	public function companyList($activity=0,$leadID=0){
		if($leadID==0){
			$query = $this->db->select("c.*,s.name as sectorName, s.id as sectorID")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('c.company_name','ASC')->get();
		} else {
			if($activity==1){
				$query = $this->db->select("c.*,s.name as sectorName, s.id as sectorID")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_invitees.' as i','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('c.company_name','ASC')->get();
			} else if($activity==2){
				$query = $this->db->select("c.*,s.name as sectorName, s.id as sectorID")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_acquisition_company.' as i','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('c.company_name','ASC')->get();
			} else {
				$query = $this->db->select("c.id")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_invitees.' as i','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('c.company_name','ASC')->get();
				$companyIDs = array();
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$companyIDs[] = $row->id;
					}
				}
				$query = $this->db->select("c.id")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_acquisition_company.' as i','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('c.company_name','ASC')->get();
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$companyIDs[] = $row->id;
					}
				}
				if(count($companyIDs)>0){
					$query = $this->db->select("c.*,s.name as sectorName, s.id as sectorID")->from($this->table_company.' as c')->join($this->table_company_sector.' as cs','cs.company_id = c.id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where_in('c.id',$companyIDs)->order_by('c.company_name','ASC')->get();
				}
			}			
		}
		
		$data = array();
		if (isset($query) && $query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$usersList = $this->getCountAllContactBelongToCompany($row->id);
				$departments = $this->findMyPreferenceWithNameSub($row->id,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->id,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$row->company_users = $usersList;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
                $data[] = $row;
            }
        }
		return $data; 
	}
	
	public function getSalesActivityCompaniesByLead($leadID){
		$data = array();
		$getInviteesCompanies = $this->db->select("c.id,c.company_name")->from($this->table_invitees.' as i')->join($this->table_company.' as c','c.id=i.contact_id')->where("i.lead_id",$leadID)->order_by('i.last_activity DESC')->get();
		if ($getInviteesCompanies->num_rows() > 0) {
			$data = $getInviteesCompanies->result();
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
	
	public function get_all_specialist($start=0,$end=1000){
		$totalCountQuery = "SELECT count(distinct(c.specialties)) as countSpecialist FROM ".$this->table_company." as c WHERE c.specialties<>''";
		$countRecords = 0;
		$resultCount = $this->db->query($totalCountQuery);
		if($resultCount->num_rows()){
			$countRow = $resultCount->first_row();
			$countRecords = $countRow->countSpecialist;
		}
		$querySELECT = "SELECT distinct(c.specialties) FROM ".$this->table_company." as c WHERE c.specialties<>'' LIMIT ".$start.",".$end;
		$resultSpecialist = $this->db->query($querySELECT);
		$specialList = array();
		if($resultSpecialist->num_rows()){
			$specialList = $resultSpecialist->result();
		}
		return array('total'=>$countRecords,'list'=>$specialList);
	}
	public function getAllSpecialities(){
		$querySELECT = "SELECT c.id,c.name FROM ".$this->table_speciality." as c ORDER BY c.name ASC";
		$resultSpecialist = $this->db->query($querySELECT);
		$specialList = array();
		if($resultSpecialist->num_rows()){
			$specialList = $resultSpecialist->result();
		}
		return $specialList;
	}
	public function get_all_specialist_by_char($q){
		$querySELECT = "SELECT distinct(c.name) as specialties FROM ".$this->table_speciality." as c WHERE c.name LIKE '".$q."%'";
		$resultSpecialist = $this->db->query($querySELECT);
		$specialList = array();
		if($resultSpecialist->num_rows()){
			$specialList = $resultSpecialist->result();
		}
		return array('list'=>$specialList);
	}
	
	public function remove_all_garbage_specialities($start,$end	){
		$query = $this->db->select('id,name')->from($this->table_speciality)->order_by('id','ASC')->limit($end,$start)->get();
		if($query->num_rows() > 0){
			$getSpecialLists = $query->result();
			foreach($getSpecialLists as $special){
				$findCompany = $this->db->select('count(id) as  countCompanies')->from($this->table_company)->like('specialties',$special->name)->get();
				if($findCompany->num_rows() > 0){
					$rowData = $findCompany->first_row();
					if($rowData->countCompanies == 0 || $rowData->countCompanies == null){
						echo $special->name."name<br/>";
						$this->db->where('speciality_id',$special->id);
						$this->db->delete($this->table_speciality_company);
						
						$this->db->where('id',$special->id);
						$this->db->delete($this->table_speciality);
					}
				}
			}
		}		
	}
	
	public function no_of_employee_company_size(){
		$data = array('company_size_list'=>array(),'linkedin_company_users'=>array());
		$queryJOIN = "";
		/*LinkedinUsers*/
		$querySELECT = "SELECT DISTINCT(c.no_of_employees) as linkedinCompanyUsers FROM ".$this->table_company." as c ";
		$buildQuery = $querySELECT." ".$queryJOIN." ";		
		$buildQuery .=" WHERE c.no_of_employees <> '' AND c.no_of_employees <> 'null' ";
		$buildQuery .=" ORDER BY linkedinCompanyUsers ASC "; 
		$queryLinkedInCompanyUser = $this->db->query($buildQuery);
		if($queryLinkedInCompanyUser->num_rows()){
			$linkedinUserList = $queryLinkedInCompanyUser->result();
		}
		/*Company Size*/
		$querySELECT = "SELECT DISTINCT(c.company_size) as company_size FROM ".$this->table_company." as c ";			
		$buildQuery = $querySELECT." ".$queryJOIN." ";
		$buildQuery .=" WHERE c.company_size <> '' ";
		$buildQuery .=" ORDER BY c.company_size_type ASC "; 		
		$queryCompanySize = $this->db->query($buildQuery);					
		if($queryCompanySize->num_rows() > 0){
			$companySizeList = $queryCompanySize->result();
		}
		$data['company_size_list'] = $companySizeList;
		$data['linkedin_company_users'] = $linkedinUserList;
		return $data; 
	}
	
	
	public function companyOptimizeListWithoutPaging($search,$sector,$cat="",$subCat="",$tech="",$subTech="",$users="",$linkedin="",$industry=array(),$company_size=array(),$no_of_size="",$label="",$specialist=array(),$sort='c.company_name',$orderBy='ASC',$start,$end,$leadID = 0, $activity = 0,$invited = 2,$rs = false,$filterIgnore,$tagSearch='',$alpha=''){
		$data = array('count_all'=>0,'data'=>array());
		/*$search = trim($search);*/
		$allCompanies = array();
		$mainFilter = false;
		if($leadID>0 && $activity >=0 && is_numeric($invited) && $invited==0){
			if($activity==1){
				$getLeadCompanyList = $this->getSalesActivityCompaniesByLead($leadID);
			} else if($activity==2){
				$getLeadCompanyList = $this->getAcquisitionActivityCompaniesByLead($leadID);
			} else if($activity==0){
				$getSalesCompanyList = $this->getSalesActivityCompaniesByLead($leadID);
				$getAcquisitionCompanyList = $this->getAcquisitionActivityCompaniesByLead($leadID);
				$getLeadCompanyList = array_merge($getSalesCompanyList,$getAcquisitionCompanyList);
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
				$queryLinkedin = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".explode(',',$linkedin).") AND id IN (".implode(',',$allCompanies).")";				
			} else {
				$queryLinkedin = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".explode(',',$linkedin).")";
			}
			$resultLinkedin = $this->db->query($queryLinkedIn);
			$allCompanies = array();
			if($resultLinkedin->num_rows()>0){
				$getCS = $resultLinkedin->result();
				foreach($getCS as $c){
					$allCompanies[] = $c->id;
				}
			}
		}
		if($label!= "" && is_numeric($label) && ($label=='0' || $label =='1')){
			$mainFilter = true;
			$listImportantCompanies = array();		
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
			}
			if(count($allCompanies)>0){
				$queryImportantCompanies = $this->db->query("SELECT id FROM ".$this->table_company." WHERE label=".$label." AND id IN (".implode(',',$allCompanies).")");
			} else {
				$queryImportantCompanies = $this->db->query("SELECT id FROM ".$this->table_company." WHERE label=".$label);
			}
			if($queryImportantCompanies->num_rows()>0){
				$getCS = $queryImportantCompanies->result();
				foreach($getCS as $c){
					$listImportantCompanies[]=$c->id;
				}
			}
			$allCompanies = array();
			if(count($listImportantCompanies)>0){
				$allCompanies = $listImportantCompanies;
			}	
		}
		if(count($company_size)>0){
			$mainFilter = true;
			$listCompanySize = array();		
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
			}
			foreach($company_size as $cs){
				if(count($allCompanies)>0){
					$queryCompanySize = $this->db->query("SELECT id FROM ".$this->table_company." WHERE company_size=".$cs." AND id IN (".implode(',',$allCompanies).")");
				} else {
					$queryCompanySize = $this->db->query("SELECT id FROM ".$this->table_company." WHERE company_size=".$cs);
				}
				if($queryCompanySize->num_rows()>0){
					$getCS = $queryCompanySize->result();
					foreach($getCS as $c){
						$listCompanySize[]=$c->id;
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
			foreach($industry as $ind){
				if(count($allCompanies)>0){
					$queryIndustry = $this->db->query("SELECT id FROM ".$this->table_company." WHERE industry=".$ind." AND id IN (".implode(',',$allCompanies).")");
				} else {
					$queryIndustry = $this->db->query("SELECT id FROM ".$this->table_company." WHERE industry=".$ind);
				}
				/*echo $this->db->last_query()."<br/>";*/
				if($queryIndustry->num_rows()>0){
					$getIndCompanies = $queryIndustry->result();
					foreach($getIndCompanies as $c){
						$listIndustries[]=$c->id;
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
			$queryS = "SELECT id FROM ".$this->table_company.' WHERE ';
			if(count($allCompanies)>0){
				$queryS .= "id IN (".implode(',',$allCompanies).") AND ";
			}
			$queryS .= " (" .$whereS. ") ";
			try{
				$resultS = $this->db->query($queryS);
				if($resultS->num_rows()>0){
					$allCompanies = array();
					$listCompaniesS = $resultS->result();
					foreach($listCompaniesS as $c){
						$allCompanies[]=$c->id;
					}
				}
			}catch(Exception $e){
				
			}
		}
		if($no_of_size!=""){
			$mainFilter = true;
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
				$queryEmployeeSize = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".$no_of_size.") AND id IN (".implode(',',$allCompanies).")";
			} else {
				$queryEmployeeSize = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".$no_of_size.")";
			}
			$queryEmployeeSizeResult = $this->db->query($queryEmployeeSize);
			$allCompanies = array();
			if($queryEmployeeSizeResult->num_rows()>0){
				$getCS = $queryEmployeeSizeResult->result();
				foreach($getCS as $c){
					$allCompanies[] = $c->id;
				}
			}
		}
		
		if($cat!="" && $subCat!=""){
			try{
				$mainFilter = true;
				$jsonCat = explode(',',$cat);					
				$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonCat)->get();
				if($spQuery->num_rows()>0){
					$getLs = $spQuery->result();
					$scList = array();
					foreach($getLs as $ls){
						$scList[] = $ls->customer_id;
					}
					$jsonSubCat = explode(',',$subCat);
					if(count($allCompanies)>0){
						$scList = array_combine($scList,$allCompanies);
						$scList = array_unique($scList);
					}
					$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonSubCat)->where_in('p.customer_id',$scList)->get();
					if($spQuery->num_rows()>0){
						$getLs = $spQuery->result();
						$scList = array();
						$allCompanies = array();
						foreach($getLs as $ls){
							$allCompanies[] = $ls->customer_id;
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
				if(count($allCompanies)>0){
					$allCompanies = array_unique($allCompanies);
					$this->db->where_in('p.customer_id',$allCompanies);
				}				
				$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonCat)->get();
				if($spQuery->num_rows()>0){
					$getLs = $spQuery->result();
					$allCompanies = array();
					foreach($getLs as $ls){
						$allCompanies[] = $ls->customer_id;
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
					$queryString = "SELECT count(id) as countUsers,company_id FROM ".$this->table;
					if(count($allCompanies)>0){
						$queryString .= " WHERE company_id IN(".implode(',',$allCompanies).") ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers =".$u;
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$companies = $queryFindCompany->result();
						$companyList = array_merge($companyList,$companies);					
					}
				} else if((int)$u==0){
					if($checkU === false){
						$checkU = true;
					}
				}
				if($queryString!=""){
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$companies = $queryFindCompany->result();
						$companyList = array_merge($companyList,$companies);					
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
					$queryString = "SELECT count(id) as countUsers,company_id FROM ".$this->table;
					if(count($allCompanies)>0){
						$queryString .= " WHERE company_id IN(".implode(',',$allCompanies).") ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers >0";
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$excludeCompanies = $queryFindCompany->result();
						$exCompany = array();
						foreach($excludeCompanies as $company){
							$exCompany[] = $company->company_id;
						}
						if(count($allCompanies)>0){
							$allCompanies  = array_diff($allCompanies,$exCompany);
						} else {
							$queryC = "SELECT distinct(id) as company_id FROM ".$this->table_company." WHERE id NOT IN (".implode(',',$exCompany).")";
							$queryFindCompany = $this->db->query($queryC);
							if($queryFindCompany->num_rows()>0){
								$allCompanies = array();
								$iCompanies = $queryFindCompany->result();
								foreach($iCompanies as $company){
									$allCompanies[] = $company->company_id;
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
						$queryJOIN = " INNER JOIN ".$this->table_technology_preference." as t ON t.company_id = c.id ";
						$queryWHERE[] = " t.preference_id IN (".implode(',',$allTech).") ";
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$queryJOIN = " INNER JOIN ".$this->table_technology_preference." as t ON t.company_id = c.id ";
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
					$queryWHERE[] = 'c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)';	
				} else {
					$queryJOIN = "INNER JOIN ".$this->table_company_sector." as cs ON c.id = cs.company_id ";
					$queryWHERE[] = " cs.sector_id IN (".$sector.") ";
				}
			}
			if(!empty($search)){							
				$queryWHERE[] = 'c.company_name LIKE "%'.$search.'%"';
			}
			if($filterIgnore=="no_of_users"){
				$querySELECT = "SELECT distinct(count(contact.id)) as no_of_users FROM ".$this->table.' as contact';
				if(count($queryWHERE)>0){
					$queryWHERE = implode(' AND ',$queryWHERE);
				} else {
					$queryWHERE = "";
				}
				$buildQuery = $querySELECT." ".$queryJOIN." ";
				$queryCheck = false;
				if($queryWHERE!=""){
					$queryCheck = true;
					$buildQuery .=" WHERE contact.company_id IN (SELECT id FROM ".$this->table_company." as c WHERE ".$queryWHERE.")";
				}
				$buildQuery .=" GROUP BY contact.company_id ORDER BY no_of_users ASC";
				$resultCount = $this->db->query($buildQuery);
				if($resultCount->num_rows()>0){
					$resultData = $resultCount->result();
					if($queryCheck===false){
						$queryCheck = "SELECT count(id) as company FROM ".$this->table_company." WHERE id NOT IN (SELECT distinct(company_id) FROM ".$this->table." GROUP BY company_id)";
						$resultCheck = $this->db->query($queryCheck);
						if($resultCheck->num_rows()>0){
							$checkResult = $resultCheck->first_row();
							if($checkResult->company>0){
								$emptyArray = array(array('no_of_users'=>"0"));
								array_splice( $resultData, 0, 0, $emptyArray );
							}
						}
					} else {
						$queryWithUsers = "SELECT distinct(company_id) as company_id FROM ".$this->table." as contact WHERE contact.company_id IN (SELECT id FROM ".$this->table_company." as c WHERE ".$queryWHERE.") GROUP BY contact.company_id";
						$resultWithUsers = $this->db->query($queryWithUsers);
						if($resultWithUsers->num_rows()>0){
							$companyWithUsers = $resultWithUsers->result();
							$companyIDs = array();
							foreach($companyWithUsers as $u){
								$companyIDs[] = $u->company_id;
							}
							$queryAllCompany = "SELECT distinct(id) as id FROM ".$this->table_company." as c WHERE ".$queryWHERE;
							$resultAllCompany = $this->db->query($queryAllCompany);
							if($resultAllCompany->num_rows()>0){
								$companyAll = $resultAllCompany->result();
								$companyAllIDs = array();
								foreach($companyAll as $u){
									$companyAllIDs[] = $u->id;
								}
								$arrayDiff = array_diff($companyAllIDs,$companyIDs);
								if(count($arrayDiff)>0){
									$emptyArray = array(array('no_of_users'=>"0"));
									array_splice( $resultData, 0, 0, $emptyArray );
								}
							}
						}
					}
					$data['data'] = $resultData;
				}
			} else if ($filterIgnore=="no_of_employees"){
				$querySELECT = "SELECT distinct(no_of_employees) as no_of_employees FROM ".$this->table_company.' as c';
				if(count($queryWHERE)>0){
					$queryWHERE = implode(' AND ',$queryWHERE);
				} else {
					$queryWHERE = "";
				}
				$buildQuery = $querySELECT." ".$queryJOIN." ";
				if($queryWHERE!=""){
					$buildQuery .=" WHERE ".$queryWHERE;
				}
				$buildQuery .=" ORDER BY no_of_employees ASC";
				$resultCount = $this->db->query($buildQuery);
				if($resultCount->num_rows()>0){
					$data['data'] = $resultCount->result();
				}
			} else if ($filterIgnore=="company_size"){
				$querySELECT = "SELECT distinct(c.company_size_type) as company_size, c.company_size as type FROM ".$this->table_company.' as c';
				if(count($queryWHERE)>0){
					$queryWHERE = implode(' AND ',$queryWHERE);
				} else {
					$queryWHERE = "";
				}
				$buildQuery = $querySELECT." ".$queryJOIN." ";
				if($queryWHERE!=""){
					$buildQuery .=" WHERE ".$queryWHERE;
				}
				$buildQuery .=" ORDER BY company_size_type ASC";
				$resultCount = $this->db->query($buildQuery);
				if($resultCount->num_rows()>0){
					$data['data'] = $resultCount->result();
				}
			} else if ($filterIgnore=="industry"){
				$querySELECT = "SELECT distinct(industry) as industry FROM ".$this->table_company.' as c';
				if(count($queryWHERE)>0){
					$queryWHERE = implode(' AND ',$queryWHERE);
				} else {
					$queryWHERE = "";
				}
				$buildQuery = $querySELECT." ".$queryJOIN." ";
				if($queryWHERE!=""){
					$buildQuery .=" WHERE ".$queryWHERE;
				}
				$buildQuery .=" ORDER BY industry ASC";
				$resultCount = $this->db->query($buildQuery);
				if($resultCount->num_rows()>0){
					$data['data'] = $resultCount->result();
				}
			} else if ($filterIgnore=="specialties"){
				$querySELECT = "SELECT count(distinct(speciality.name)) as countSpecialist FROM ".$this->table_speciality.' as speciality';
				if(count($queryWHERE)>0){
					$queryWHERE = implode(' AND ',$queryWHERE);
				} else {
					$queryWHERE = "";
				}
				$buildQuery = $querySELECT." ".$queryJOIN." ";
				$buildQuery .=" WHERE speciality.id IN(SELECT sc.speciality_id FROM ".$this->table_speciality_company." as sc ";
				if($queryWHERE!=""){
					$buildQuery .=" WHERE company_id IN (SELECT distinct(c.id) FROM ".$this->table_company." as c WHERE ".$queryWHERE.")";
				}
				$buildQuery .="  ) ";
				if($tagSearch!=""){
					$buildQuery .="  AND speciality.name LIKE '%".$tagSearch."%' ";
				}
				if($alpha!=""){
					$buildQuery .="  AND speciality.name LIKE '".$alpha."%' ";
				}
				$resultCount = $this->db->query($buildQuery);
				if($resultCount->num_rows()>0){
					$countR = $resultCount->first_row();
					$data['count_all'] = $countR->countSpecialist;
					$querySELECT = "SELECT distinct(speciality.name) as specialties FROM ".$this->table_speciality.' as speciality';
					$buildQuery = $querySELECT." ".$queryJOIN." ";
					$buildQuery .=" WHERE speciality.id IN(SELECT sc.speciality_id FROM ".$this->table_speciality_company." as sc ";
					if($queryWHERE!=""){
						$buildQuery .=" WHERE company_id IN (SELECT distinct(c.id) FROM ".$this->table_company." as c WHERE ".$queryWHERE.")";
					}
					$buildQuery .="  ) ";
					if($tagSearch!=""){
						$buildQuery .="  AND speciality.name LIKE '%".$tagSearch."%' ";
					}
					if($alpha!=""){
						$buildQuery .="  AND speciality.name LIKE '".$alpha."%' ";
					}
					$buildQuery .=" ORDER BY specialties ASC LIMIT ".$start.",".$end;
					/*echo $buildQuery."<br/>";*/
					$resultData = $this->db->query($buildQuery);
					if($resultData->num_rows()>0){
						$data['data'] = $resultData->result();
					}
				}
			} else if ($filterIgnore=="sector"){
				$querySELECT = "SELECT distinct(sec.name) as sector,sec.id as type FROM ".$this->table_sector.' as sec';
				if(count($queryWHERE)>0){
					$queryWHERE = implode(' AND ',$queryWHERE);
				} else {
					$queryWHERE = "";
				}
				$buildQuery = $querySELECT." ".$queryJOIN." ";
				$buildQuery .=" WHERE sec.id IN( SELECT tblsc.sector_id FROM ".$this->table_company_sector." as tblsc ";
				if($queryWHERE!=""){
					$buildQuery .=" WHERE tblsc.company_id IN (SELECT distinct(c.id) FROM ".$this->table_company." as c WHERE ".$queryWHERE.")";
				}
				$buildQuery .="  ) ";
				$buildQuery .=" ORDER BY sector ASC ";
				$resultCount = $this->db->query($buildQuery);
				if($resultCount->num_rows()>0){
					$emptySector = array(array("sector"=>"Unclassify","type"=>"Unclassify"));
					$resultData = $resultCount->result();
					array_splice( $resultData, 0, 0, $emptySector );
					$data['data'] = $resultData;
				}
			} else if ($filterIgnore=="tech"){
				$buildQuery = "select distinct(category.name) as tech FROM ".$this->table_category." as category INNER JOIN ".$this->table_map_sector_category." as map ON map.category_id = category.id where sector_id=21 order by category.name asc;";
				$resultCount = $this->db->query($buildQuery);
				if($resultCount->num_rows()>0){
					$data['data'] = $resultCount->result();
				}
			}
		endif;
		return $data; 
	}
	
	public function getCompanyDataByIDs($companyIDs,$rs = true,$sort='c.company_name',$orderBy='ASC'){
		$data = array('count_all'=>0,'data'=>array());
		$querySELECT = "SELECT distinct(c.id) as companyID, c.id, c.company_name,c.web_address, c.linkedin_url,c.scrapped_date,c.scrapped_profile_date,c.industry,c.no_of_employees,c.company_size,c.company_size_type,c.specialties,c.scrape_p,c.scrape_people_again, (SELECT count(*) as company_users FROM ".$this->table." WHERE company_id=c.id) as company_users,'' as sectorName, '' as department_names,'' as sub_department_names, '' as technology_names, '' as sub_technology_names , c.label, c.revenue, c.create_date FROM ".$this->table_company." as c WHERE c.id IN (".implode(',',$companyIDs).") ORDER BY ".$sort." ".$orderBy;
		$query = $this->db->query($querySELECT);
		/*echo $this->db->last_query();*/		
		$mapTech = array();
		$mapCategpry = array();		
		$mapSubCategory = array();
		$category = array();
		$subCategory = array();
		$subTechnology = array();
		if($query->num_rows()>0){
			$companyDataResult = $query->result();
			if($rs === true){
				$companyIDs = array();
				$started = microtime(true);
				for($i=0;$i<count($companyDataResult);$i++){
					$companyIDs[] =  $companyDataResult[$i]->id;
				}
				/*$usersList = $this->getCountAllContactBelongToAllCompanyOptimized($companyIDs);*/
				$started = microtime(true);
				$sectorsList = $this->findAllCompanySectorsOptimized($companyIDs);
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
					$getDepartmentsList = $this->findAllCompanyPreferenceWithNameSub($sectorsCompanies,1);
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
				$technologies = $this->findAllCompaniesTechnologiesPreferenceWithNameSub($companyIDs,0);
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
					$subTechnologies = $this->findAllCompaniesTechnologiesPreferenceWithNameSub($techCompanyIDs,1);
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
						$subsubTechnologies = $this->findAllCompaniesTechnologiesPreferenceWithNameSub($subTechCompanyIDs,2);
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
			$data['companies'] = $companyDataResult;
			$data['selected_acquisition_companies'] = array();
			$data['selected_sales_companies'] = array();
		}
		return $data;
	}
	
	public function companyOptimizeListWithPagingIDs($search,$sector,$cat="",$subCat="",$tech="",$subTech="",$users="",$linkedin="",$industry=array(),$company_size=array(),$no_of_size="",$label="",$specialist=array(),$alpha="",$sort='c.company_name',$orderBy='ASC',$start,$end,$leadID = 0, $activity = 0,$invited = 2,$rs = true){
		$data = array('count_all'=>0,'data'=>array());
		/*$search = trim($search);*/
		$allCompanies = array();
		$mainFilter = false;
		if($leadID>0 && $activity>0 && $invited==0){			
			if($activity==1){
				$getLeadCompanyList = $this->getSalesActivityCompaniesByLead($leadID);
			} else if($activity==2){
				$getLeadCompanyList = $this->getAcquisitionActivityCompaniesByLead($leadID);
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
				$queryLinkedin = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".explode(',',$linkedin).") AND id IN (".implode(',',$allCompanies).")";				
			} else {
				$queryLinkedin = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".explode(',',$linkedin).")";
			}
			$resultLinkedin = $this->db->query($queryLinkedIn);
			$allCompanies = array();
			if($resultLinkedin->num_rows()>0){
				$getCS = $resultLinkedin->result();
				foreach($getCS as $c){
					$allCompanies[] = $c->id;
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
				$queryImportantCompanies = $this->db->query("SELECT id FROM ".$this->table_company." WHERE label=".$label." AND id IN (".implode(',',$allCompanies).")");
			} else {
				$queryImportantCompanies = $this->db->query("SELECT id FROM ".$this->table_company." WHERE label=".$label);
			}
			if($queryImportantCompanies->num_rows()>0){
				$getCS = $queryImportantCompanies->result();
				foreach($getCS as $c){
					$listImportantCompanies[]=$c->id;
				}
			}
			$allCompanies = array();
			if(count($listImportantCompanies)>0){
				$allCompanies = $listImportantCompanies;
			}	
		}
		if(count($company_size)>0){
			$mainFilter = true;
			$listCompanySize = array();		
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
			}
			foreach($company_size as $cs){
				if(count($allCompanies)>0){
					$queryCompanySize = $this->db->query("SELECT id FROM ".$this->table_company." WHERE company_size=".$cs." AND id IN (".implode(',',$allCompanies).")");
				} else {
					$queryCompanySize = $this->db->query("SELECT id FROM ".$this->table_company." WHERE company_size=".$cs);
				}				
				if($queryCompanySize->num_rows()>0){
					$getCS = $queryCompanySize->result();
					foreach($getCS as $c){
						$listCompanySize[]=$c->id;
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
			foreach($industry as $ind){
				if(count($allCompanies)>0){
					$queryIndustry = $this->db->query("SELECT id FROM ".$this->table_company." WHERE industry=".$ind." AND id IN (".implode(',',$allCompanies).")");
				} else {
					$queryIndustry = $this->db->query("SELECT id FROM ".$this->table_company." WHERE industry=".$ind);
				}
				/*echo $this->db->last_query()."<br/>";*/
				if($queryIndustry->num_rows()>0){
					$getIndCompanies = $queryIndustry->result();
					foreach($getIndCompanies as $c){
						$listIndustries[]=$c->id;
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
			if(count($specialist)==1 && $specialist[0] == "none") {
				$whereS .=" specialties = '' OR  specialties is null OR ";
			} else {
				foreach($specialist as $spec){
					$whereS .=" specialties LIKE '%".$spec."%' OR ";
				}
			}
			$whereS = substr($whereS,0,-3);
			$queryS = "SELECT id FROM ".$this->table_company.' WHERE ';
			if(count($allCompanies)>0){
				$queryS .= "id IN (".implode(',',$allCompanies).") AND ";
			}
			$queryS .= " (" .$whereS. ") ";
			try{
				$resultS = $this->db->query($queryS);
				if($resultS->num_rows()>0){
					$allCompanies = array();
					$listCompaniesS = $resultS->result();
					foreach($listCompaniesS as $c){
						$allCompanies[]=$c->id;
					}
				}
			}catch(Exception $e){
				
			}
		}
		if($no_of_size!=""){
			$mainFilter = true;
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
				$queryEmployeeSize = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".$no_of_size.") AND id IN (".implode(',',$allCompanies).")";
			} else {
				$queryEmployeeSize = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".$no_of_size.")";
			}
			$queryEmployeeSizeResult = $this->db->query($queryEmployeeSize);
			$allCompanies = array();
			if($queryEmployeeSizeResult->num_rows()>0){
				$getCS = $queryEmployeeSizeResult->result();
				foreach($getCS as $c){
					array_push($allCompanies, $c->id);
				}
			}
		}
		
		if($cat!="" && $subCat!=""){
			try{
				$mainFilter = true;
				$jsonCat = explode(',',$cat);					
				$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonCat)->get();
				if($spQuery->num_rows()>0){
					$getLs = $spQuery->result();
					$scList = array();
					foreach($getLs as $ls){
						array_push($scList, $ls->customer_id);
					}
					$jsonSubCat = explode(',',$subCat);
					if(count($allCompanies)>0){
						$scList = array_combine($scList,$allCompanies);
						$scList = array_unique($scList);
					}
					$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonSubCat)->where_in('p.customer_id',$scList)->get();
					if($spQuery->num_rows()>0){
						$getLs = $spQuery->result();
						$scList = array();
						$allCompanies = array();
						foreach($getLs as $ls){
							array_push($allCompanies, $ls->customer_id);
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
				if(count($allCompanies)>0){
					$allCompanies = array_unique($allCompanies);
					$this->db->where_in('p.customer_id',$allCompanies);
				}				
				$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonCat)->get();
				if($spQuery->num_rows()>0){
					$getLs = $spQuery->result();
					$allCompanies = array();
					foreach($getLs as $ls){
						array_push($allCompanies, $ls->customer_id);
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
					$queryString = "SELECT count(id) as countUsers,company_id FROM ".$this->table;
					if(count($allCompanies)>0){
						$queryString .= " WHERE company_id IN(".implode(',',$allCompanies).") ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers =".$u;
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$companies = $queryFindCompany->result();
						$companyList = array_merge($companyList,$companies);					
					}
				} else if((int)$u==0){
					if($checkU === false){
						$checkU = true;
					}
				}
				/*if($queryString!=""){
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$companies = $queryFindCompany->result();
						$companyList = array_merge($companyList,$companies);					
					}
				}*/					
			}
			if($checkU===true){
				if(count($companyList)>0){
					$aCompanies = array();
					foreach($companyList as $company){
						array_push($aCompanies, $company->company_id);
					}
					$allCompanies = array_merge($allCompanies,$aCompanies);	
					$allCompanies = array_unique($allCompanies);
				} else {
					$queryString = "SELECT count(id) as countUsers,company_id FROM ".$this->table;
					if(count($allCompanies)>0){
						$queryString .= " WHERE company_id IN(".implode(',',$allCompanies).") ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers >0";
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$excludeCompanies = $queryFindCompany->result();
						$exCompany = array();
						foreach($excludeCompanies as $company){
							array_push($exCompany, $company->company_id);
						}
						if(count($allCompanies)>0){
							$allCompanies  = array_diff($allCompanies,$exCompany);
						} else {
							$queryC = "SELECT distinct(id) as company_id FROM ".$this->table_company." WHERE id NOT IN (".implode(',',$exCompany).")";
							$queryFindCompany = $this->db->query($queryC);
							if($queryFindCompany->num_rows()>0){
								$allCompanies = array();
								$iCompanies = $queryFindCompany->result();
								foreach($iCompanies as $company){
									array_push($allCompanies, $company->company_id);
								}
							}
						}
					}
				}
			} else {
				$allCompanies = array();
				if(count($companyList)>0){
					foreach($companyList as $company){
						array_push($allCompanies, $company->company_id);
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
						$queryJOIN = " INNER JOIN ".$this->table_technology_preference." as t ON t.company_id = c.id ";
						array_push($queryWHERE, " t.preference_id IN (".implode(',',$allTech).") ");
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$queryJOIN = " INNER JOIN ".$this->table_technology_preference." as t ON t.company_id = c.id ";
						array_push($queryWHERE,  " t.preference_id IN (".implode(',',$jsonCat).") ");
					}					
				}catch(Exception $e){
				}
			}
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
				array_push($queryWHERE, " c.id IN (".implode(',',$allCompanies).") ");
			}
			if(!empty($sector)){
				if($sector=='Unclassify'){
					$queryWHERE[] = 'c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)';	
				} else {
					$queryJOIN = "INNER JOIN ".$this->table_company_sector." as cs ON c.id = cs.company_id ";
					array_push($queryWHERE, " cs.sector_id IN (".$sector.") ");
				}
			}
			if(!empty($search)){							
				array_push($queryWHERE, 'c.company_name LIKE "%'.$search.'%"');
			} 
			if(!empty($alpha)){							
				array_push($queryWHERE, 'c.company_name LIKE "'.$alpha.'%"');
			}
		
			$querySELECT = "SELECT c.id as company_id FROM ".$this->table_company." as c ";
			if(count($queryWHERE)>0){
				$queryWHERE = implode(' AND ',$queryWHERE);
			} else {
				$queryWHERE = "";
			}
			$buildQuery = $querySELECT." ".$queryJOIN." ";
			if($queryWHERE!=""){
				$buildQuery .=" WHERE ".$queryWHERE;
			}			
			/*$buildQuery .=" ORDER BY ".$sort." ".$orderBy;*/
			
			$resultCount = $this->db->query($buildQuery);
			/*echo $this->db->last_query();*/
			if($resultCount->num_rows()){
				$data['data'] = $resultCount->result();
			}
		endif;
		$data['cat'] = $category;
		$data['sub_cat'] = $subCategory;
		$data['sub_tech'] = $subTechnology;
		return $data; 
	}
	
	
	public function companyOptimizeListWithPaging($search,$sector,$cat="",$subCat="",$tech="",$subTech="",$users="",$linkedin="",$industry=array(),$company_size=array(),$no_of_size="",$label="",$specialist=array(),$alpha="",$sort='c.company_name',$orderBy='ASC',$start,$end,$leadID = 0, $activity = 0,$invited = 2,$rs = true){
		$data = array('count_all'=>0,'data'=>array());
		/*$search = trim($search);*/
		$allCompanies = array();
		$mainFilter = false;
		if($leadID>0 && $activity>0 && $invited==0){			
			if($activity==1){
				$getLeadCompanyList = $this->getSalesActivityCompaniesByLead($leadID);
			} else if($activity==2){
				$getLeadCompanyList = $this->getAcquisitionActivityCompaniesByLead($leadID);
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
				$queryLinkedin = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".explode(',',$linkedin).") AND id IN (".implode(',',$allCompanies).")";				
			} else {
				$queryLinkedin = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".explode(',',$linkedin).")";
			}
			$resultLinkedin = $this->db->query($queryLinkedIn);
			$allCompanies = array();
			if($resultLinkedin->num_rows()>0){
				$getCS = $resultLinkedin->result();
				foreach($getCS as $c){
					$allCompanies[] = $c->id;
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
				$queryImportantCompanies = $this->db->query("SELECT id FROM ".$this->table_company." WHERE label=".$label." AND id IN (".implode(',',$allCompanies).")");
			} else {
				$queryImportantCompanies = $this->db->query("SELECT id FROM ".$this->table_company." WHERE label=".$label);
			}
			if($queryImportantCompanies->num_rows()>0){
				$getCS = $queryImportantCompanies->result();
				foreach($getCS as $c){
					$listImportantCompanies[]=$c->id;
				}
			}
			$allCompanies = array();
			if(count($listImportantCompanies)>0){
				$allCompanies = $listImportantCompanies;
			}	
		}
		if(count($company_size)>0){
			$mainFilter = true;
			$listCompanySize = array();		
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
			}
			foreach($company_size as $cs){
				if(count($allCompanies)>0){
					$queryCompanySize = $this->db->query("SELECT id FROM ".$this->table_company." WHERE company_size=".$cs." AND id IN (".implode(',',$allCompanies).")");
				} else {
					$queryCompanySize = $this->db->query("SELECT id FROM ".$this->table_company." WHERE company_size=".$cs);
				}				
				if($queryCompanySize->num_rows()>0){
					$getCS = $queryCompanySize->result();
					foreach($getCS as $c){
						$listCompanySize[]=$c->id;
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
			foreach($industry as $ind){
				if(count($allCompanies)>0){
					$queryIndustry = $this->db->query("SELECT id FROM ".$this->table_company." WHERE industry=".$ind." AND id IN (".implode(',',$allCompanies).")");
				} else {
					$queryIndustry = $this->db->query("SELECT id FROM ".$this->table_company." WHERE industry=".$ind);
				}
				/*echo $this->db->last_query()."<br/>";*/
				if($queryIndustry->num_rows()>0){
					$getIndCompanies = $queryIndustry->result();
					foreach($getIndCompanies as $c){
						$listIndustries[]=$c->id;
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
			$queryS = "SELECT id FROM ".$this->table_company;
			if(count($allCompanies)>0){
				$queryS .= ' WHERE ';
				$queryS .= "id IN (".implode(',',$allCompanies).") AND ";
			}
			if($whereS != "") {
				$queryS .= " (" .$whereS. ") ";
			}			
			try{
				$resultS = $this->db->query($queryS);
				if($resultS->num_rows()>0){
					$allCompanies = array();
					$listCompaniesS = $resultS->result();
					foreach($listCompaniesS as $c){
						$allCompanies[]=$c->id;
					}
				}
			}catch(Exception $e){
				
			}
		}
		if($no_of_size!=""){
			$mainFilter = true;
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
				$queryEmployeeSize = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".$no_of_size.") AND id IN (".implode(',',$allCompanies).")";
			} else {
				$queryEmployeeSize = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".$no_of_size.")";
			}
			$queryEmployeeSizeResult = $this->db->query($queryEmployeeSize);
			$allCompanies = array();
			if($queryEmployeeSizeResult->num_rows()>0){
				$getCS = $queryEmployeeSizeResult->result();
				foreach($getCS as $c){
					$allCompanies[] = $c->id;
				}
			}
		}
		
		if($cat!="" && $subCat!=""){
			try{
				$mainFilter = true;
				$jsonCat = explode(',',$cat);					
				$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonCat)->get();
				if($spQuery->num_rows()>0){
					$getLs = $spQuery->result();
					$scList = array();
					foreach($getLs as $ls){
						$scList[] = $ls->customer_id;
					}
					$jsonSubCat = explode(',',$subCat);
					if(count($allCompanies)>0){
						$scList = array_combine($scList,$allCompanies);
						$scList = array_unique($scList);
					}
					$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonSubCat)->where_in('p.customer_id',$scList)->get();
					if($spQuery->num_rows()>0){
						$getLs = $spQuery->result();
						$scList = array();
						$allCompanies = array();
						foreach($getLs as $ls){
							$allCompanies[] = $ls->customer_id;
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
				if(count($allCompanies)>0){
					$allCompanies = array_unique($allCompanies);
					$this->db->where_in('p.customer_id',$allCompanies);
				}				
				$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonCat)->get();
				if($spQuery->num_rows()>0){
					$getLs = $spQuery->result();
					$allCompanies = array();
					foreach($getLs as $ls){
						$allCompanies[] = $ls->customer_id;
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
					$queryString = "SELECT count(id) as countUsers,company_id FROM ".$this->table;
					if(count($allCompanies)>0){
						$queryString .= " WHERE company_id IN(".implode(',',$allCompanies).") ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers =".$u;
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$companies = $queryFindCompany->result();
						$companyList = array_merge($companyList,$companies);					
					}
				} else if((int)$u==0){
					if($checkU === false){
						$checkU = true;
					}
				}
				/*if($queryString!=""){
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$companies = $queryFindCompany->result();
						$companyList = array_merge($companyList,$companies);					
					}
				}*/					
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
					$queryString = "SELECT count(id) as countUsers,company_id FROM ".$this->table;
					if(count($allCompanies)>0){
						$queryString .= " WHERE company_id IN(".implode(',',$allCompanies).") ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers >0";
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$excludeCompanies = $queryFindCompany->result();
						$exCompany = array();
						foreach($excludeCompanies as $company){
							$exCompany[] = $company->company_id;
						}
						if(count($allCompanies)>0){
							$allCompanies  = array_diff($allCompanies,$exCompany);
						} else {
							$queryC = "SELECT distinct(id) as company_id FROM ".$this->table_company." WHERE id NOT IN (".implode(',',$exCompany).")";
							$queryFindCompany = $this->db->query($queryC);
							if($queryFindCompany->num_rows()>0){
								$allCompanies = array();
								$iCompanies = $queryFindCompany->result();
								foreach($iCompanies as $company){
									$allCompanies[] = $company->company_id;
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
						$queryJOIN = " INNER JOIN ".$this->table_technology_preference." as t ON t.company_id = c.id ";
						$queryWHERE[] = " t.preference_id IN (".implode(',',$allTech).") ";
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$queryJOIN = " INNER JOIN ".$this->table_technology_preference." as t ON t.company_id = c.id ";
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
					$queryWHERE[] = 'c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)';	
				} else {
					$queryJOIN = "INNER JOIN ".$this->table_company_sector." as cs ON c.id = cs.company_id ";
					$queryWHERE[] = " cs.sector_id IN (".$sector.") ";
				}
			}
			if(!empty($search)){							
				$queryWHERE[] = 'c.company_name LIKE "%'.$search.'%"';
			} 
			if(!empty($alpha)){							
				$queryWHERE[] = 'c.company_name LIKE "'.$alpha.'%"';
			}
		
			$querySELECT = "SELECT count(c.id) as countRecords FROM ".$this->table_company." as c ";
			if(count($queryWHERE)>0){
				$queryWHERE = implode(' AND ',$queryWHERE);
			} else {
				$queryWHERE = "";
			}
			$buildQuery = $querySELECT." ".$queryJOIN." ";
			if($queryWHERE!=""){
				$buildQuery .=" WHERE ".$queryWHERE;
			}
			
			$resultCount = $this->db->query($buildQuery);
			if($resultCount->num_rows()){
				$getCount = $resultCount->first_row();
				$data['count_all'] = $getCount->countRecords;
				$querySELECT = "SELECT distinct(c.id) as companyID, c.id, c.company_name,c.web_address, c.linkedin_url,c.scrapped_date,c.scrapped_profile_date,c.industry,c.no_of_employees,c.company_size,c.company_size_type,c.specialties,c.scrape_people_again,c.scrape_p, (SELECT count(*) as company_users FROM ".$this->table." WHERE company_id=c.id) as company_users,'' as sectorName, '' as department_names,'' as sub_department_names, '' as technology_names, '' as sub_technology_names , c.label, c.revenue FROM ".$this->table_company." as c ";
				
				$buildQuery = $querySELECT." ".$queryJOIN." ";
				if($queryWHERE!=""){
					$buildQuery .=" WHERE ".$queryWHERE;
				}

				$buildQuery .=" ORDER BY ".$sort." ".$orderBy;
				
				if($end>0){
					$buildQuery .=" LIMIT ".$start.",".$end;
				}			
				$query = $this->db->query($buildQuery);
				/*echo $this->db->last_query();*/			
				$mapTech = array();
				$mapCategpry = array();		
				$mapSubCategory = array();
				if($query->num_rows()>0){
					$companyDataResult = $query->result();
					if($rs === true){
						$companyIDs = array();
						$started = microtime(true);
						for($i=0;$i<count($companyDataResult);$i++){
							$companyIDs[] =  $companyDataResult[$i]->id;
						}
						/*$usersList = $this->getCountAllContactBelongToAllCompanyOptimized($companyIDs);*/
						$started = microtime(true);
						$sectorsList = $this->findAllCompanySectorsOptimized($companyIDs);
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
						/*if(count($usersList)>0){
							foreach($usersList as $u){
								$i=0;
								foreach($companyDataResult as $co){
									if($co->id == $u->company_id){
										$companyDataResult[$i]->company_users = $u->countUsers;
										break;
									}
									$i++;
								}					
							}				
						}*/
						if(count($sectorsCompanies)>0){
							$sectorsCompanies = array_unique($sectorsCompanies);
							/*Get Categories and Sub Categories*/
							$getDepartmentsList = $this->findAllCompanyPreferenceWithNameSub($sectorsCompanies,1);
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
						$technologies = $this->findAllCompaniesTechnologiesPreferenceWithNameSub($companyIDs,0);
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
							$subTechnologies = $this->findAllCompaniesTechnologiesPreferenceWithNameSub($techCompanyIDs,1);
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
								$subsubTechnologies = $this->findAllCompaniesTechnologiesPreferenceWithNameSub($subTechCompanyIDs,2);
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
	
	public function companyOptimizeListWithGrid($search,$sector,$cat="",$subCat="",$tech="",$subTech="",$users="",$linkedin="",$industry=array(),$company_size=array(),$no_of_size="",$label="",$specialist=array(),$scrapeCompanies=array(),$alpha="",$sort='c.company_name',$orderBy='ASC',$leadID = 0, $activity = 0,$invited = 2,$start=0,$end=1000,$rs = true){
		$data = array('count_all'=>0,'data'=>array());
		/*$search = trim($search);*/
		$allCompanies = array();
		if(count($scrapeCompanies) > 0){
			$allCompanies = $scrapeCompanies;
		}
		
		$mainFilter = false;
		if($leadID>0 && $invited==='0'){			
			if($activity==1){
				$getLeadCompanyList = $this->getSalesActivityCompaniesByLead($leadID);
			} else if($activity==2){
				$getLeadCompanyList = $this->getAcquisitionActivityCompaniesByLead($leadID);
			} else {
				$getLeadCompanyList = $this->getSalesActivityCompaniesByLead($leadID);
				$acquisitionCompanyList = $this->getAcquisitionActivityCompaniesByLead($leadID);
				$getLeadCompanyList = array_merge($getLeadCompanyList,$acquisitionCompanyList);	
			}
			if(isset($getLeadCompanyList) && count($getLeadCompanyList)>0){
				foreach($getLeadCompanyList as $c){
					$allCompanies[] = $c->id;
				}
			}
		} else if($leadID>0 && $invited==='1'){			
			if($activity==1){
				$getLeadCompanyList = $this->getSalesActivityCompaniesByLead($leadID);
			} else if($activity==2){
				$getLeadCompanyList = $this->getAcquisitionActivityCompaniesByLead($leadID);
			} else {
				$getLeadCompanyList = $this->getSalesActivityCompaniesByLead($leadID);
				$acquisitionCompanyList = $this->getAcquisitionActivityCompaniesByLead($leadID);
				$getLeadCompanyList = array_merge($getLeadCompanyList,$acquisitionCompanyList);	
			}
			if(isset($getLeadCompanyList) && count($getLeadCompanyList)>0){
				foreach($getLeadCompanyList as $c){
					$allCompanies[] = $c->id;
				}
			}
			$allCompanies = array_unique($allCompanies);
			$queryC = "SELECT id FROM ".$this->table_company." WHERE id NOT IN (".implode(',', $allCompanies).")";
			$allCompanies = array();
			$resultC = $this->db->query($queryC);
			if($resultC->num_rows()>0){
				$getCS = $resultC->result();
				foreach($getCS as $c){
					$allCompanies[] = $c->id;
				}
			}
		}
		if($linkedin != ""){
			$mainFilter = true;
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
				$queryLinkedin = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".explode(',',$linkedin).") AND id IN (".implode(',',$allCompanies).")";				
			} else {
				$queryLinkedin = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".explode(',',$linkedin).")";
			}
			$resultLinkedin = $this->db->query($queryLinkedIn);
			$allCompanies = array();
			if($resultLinkedin->num_rows()>0){
				$getCS = $resultLinkedin->result();
				foreach($getCS as $c){
					$allCompanies[] = $c->id;
				}
			}
		}
		if($label=='0' || $label =='1'){
			$mainFilter = true;
			$listImportantCompanies = array();		
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
			}
			/*if(count($allCompanies)>0){
				$queryImportantCompanies = $this->db->query("SELECT id FROM ".$this->table_company." WHERE label=".$label." AND id IN (".implode(',',$allCompanies).")");
			} else {
				$queryImportantCompanies = $this->db->query("SELECT id FROM ".$this->table_company." WHERE label=".$label);
			}*/
			
			if(count($allCompanies)>0){
				$queryImportantCompanies = $this->db->query("SELECT id FROM ".$this->table_company." WHERE scrape_people_again=".(int)$label." AND id IN (".implode(',',$allCompanies).")");
			} else {
				$queryImportantCompanies = $this->db->query("SELECT id FROM ".$this->table_company." WHERE scrape_people_again=".(int)$label);
			}
			
			if($queryImportantCompanies->num_rows()>0){
				$getCS = $queryImportantCompanies->result();
				foreach($getCS as $c){
					$listImportantCompanies[]=$c->id;
				}
			}
			$allCompanies = array();
			if(count($listImportantCompanies)>0){
				$allCompanies = $listImportantCompanies;
			}	
		}
		if(count($company_size)>0){
			$mainFilter = true;
			$listCompanySize = array();		
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
			}
			foreach($company_size as $cs){
				if(count($allCompanies)>0){
					$queryCompanySize = $this->db->query("SELECT id FROM ".$this->table_company." WHERE company_size=".$cs." AND id IN (".implode(',',$allCompanies).")");
				} else {
					$queryCompanySize = $this->db->query("SELECT id FROM ".$this->table_company." WHERE company_size=".$cs);
				}				
				if($queryCompanySize->num_rows()>0){
					$getCS = $queryCompanySize->result();
					foreach($getCS as $c){
						$listCompanySize[]=$c->id;
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
			foreach($industry as $ind){
				if(count($allCompanies)>0){
					$queryIndustry = $this->db->query("SELECT id FROM ".$this->table_company." WHERE industry=".$ind." AND id IN (".implode(',',$allCompanies).")");
				} else {
					$queryIndustry = $this->db->query("SELECT id FROM ".$this->table_company." WHERE industry=".$ind);
				}
				/*echo $this->db->last_query()."<br/>";*/
				if($queryIndustry->num_rows()>0){
					$getIndCompanies = $queryIndustry->result();
					foreach($getIndCompanies as $c){
						$listIndustries[]=$c->id;
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
			if(count($specialist) == 1 && $specialist[0] == 'none'){
				$whereS .="specialties = '' OR ";
			} else {
				foreach($specialist as $spec){
					$whereS .='specialties LIKE "%'.$spec.'%" OR ';
				}
			}
			
			$whereS = substr($whereS,0,-3);
			$queryS = "SELECT id FROM ".$this->table_company;
			$queryS .= ' WHERE ';
			if(count($allCompanies)>0){
				$queryS .= "id IN (".implode(',',$allCompanies).") AND ";
			}
			if($whereS != "") {
				$queryS .= " (" .$whereS. ") ";
			}			
			try{
				$resultS = $this->db->query($queryS);
				if($resultS->num_rows()>0){
					$allCompanies = array();
					$listCompaniesS = $resultS->result();
					foreach($listCompaniesS as $c){
						$allCompanies[]=$c->id;
					}
				}
			}catch(Exception $e){
				
			}
		}
		if($no_of_size!=""){
			$mainFilter = true;
			if(count($allCompanies)>0){
				$allCompanies = array_unique($allCompanies);
				$queryEmployeeSize = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".$no_of_size.") AND id IN (".implode(',',$allCompanies).")";
			} else {
				$queryEmployeeSize = "SELECT id FROM ".$this->table_company." WHERE no_of_employees IN (".$no_of_size.")";
			}
			$queryEmployeeSizeResult = $this->db->query($queryEmployeeSize);
			$allCompanies = array();
			if($queryEmployeeSizeResult->num_rows()>0){
				$getCS = $queryEmployeeSizeResult->result();
				foreach($getCS as $c){
					$allCompanies[] = $c->id;
				}
			}
		}
		if($cat!="" && $subCat!=""){
			try{
				$mainFilter = true;
				$jsonCat = explode(',',$cat);					
				$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonCat)->get();
				if($spQuery->num_rows()>0){
					$getLs = $spQuery->result();
					$scList = array();
					foreach($getLs as $ls){
						$scList[] = $ls->customer_id;
					}
					$jsonSubCat = explode(',',$subCat);
					if(count($allCompanies)>0){
						$scList = array_combine($scList,$allCompanies);
						$scList = array_unique($scList);
					}
					$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonSubCat)->where_in('p.customer_id',$scList)->get();
					if($spQuery->num_rows()>0){
						$getLs = $spQuery->result();
						$scList = array();
						$allCompanies = array();
						foreach($getLs as $ls){
							$allCompanies[] = $ls->customer_id;
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
				if(count($allCompanies)>0){
					$allCompanies = array_unique($allCompanies);
					$this->db->where_in('p.customer_id',$allCompanies);
				}				
				$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonCat)->get();
				if($spQuery->num_rows()>0){
					$getLs = $spQuery->result();
					$allCompanies = array();
					foreach($getLs as $ls){
						$allCompanies[] = $ls->customer_id;
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
					$queryString = "SELECT count(id) as countUsers,company_id FROM ".$this->table;
					if(count($allCompanies)>0){
						$queryString .= " WHERE company_id IN(".implode(',',$allCompanies).") ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers =".$u;
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$companies = $queryFindCompany->result();
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
					$companyList = array();
					$queryString = "SELECT count(id) as countUsers,company_id FROM ".$this->table;
					if(count($allCompanies)>0){
						$queryString .= " WHERE company_id IN(".implode(',',$allCompanies).") ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers = 0";
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$companies = $queryFindCompany->result();
						$companyList = array_merge($companyList,$companies);					
					}
					if(count($companyList)>0){
						foreach($companyList as $company){
							$aCompanies[] = $company->company_id;
						}
					}					
					$allCompanies = $aCompanies;
				} else {
					$queryString = "SELECT count(id) as countUsers,company_id FROM ".$this->table;
					if(count($allCompanies)>0){
						$queryString .= " WHERE company_id IN(".implode(',',$allCompanies).") ";
					}
					$queryString .=" GROUP BY company_id ";
					$queryString .=" HAVING countUsers >0";
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$excludeCompanies = $queryFindCompany->result();
						$exCompany = array();
						foreach($excludeCompanies as $company){
							$exCompany[] = $company->company_id;
						}
						if(count($allCompanies)>0){
							$allCompanies  = array_diff($allCompanies,$exCompany);
						} else {
							$queryC = "SELECT distinct(id) as company_id FROM ".$this->table_company." WHERE id NOT IN (".implode(',',$exCompany).")";
							$queryFindCompany = $this->db->query($queryC);
							if($queryFindCompany->num_rows()>0){
								$allCompanies = array();
								$iCompanies = $queryFindCompany->result();
								foreach($iCompanies as $company){
									$allCompanies[] = $company->company_id;
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
						$queryJOIN = " INNER JOIN ".$this->table_technology_preference." as t ON t.company_id = c.id ";
						$queryWHERE[] = " t.preference_id IN (".implode(',',$allTech).") ";
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$queryJOIN = " INNER JOIN ".$this->table_technology_preference." as t ON t.company_id = c.id ";
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
					$queryWHERE[] = 'c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)';	
				} else {
					$queryJOIN = "INNER JOIN ".$this->table_company_sector." as cs ON c.id = cs.company_id ";
					$queryWHERE[] = " cs.sector_id IN (".$sector.") ";
				}
			}
			if(!empty($search)){							
				$queryWHERE[] = 'c.company_name LIKE "%'.$search.'%"';
			} 
			if(!empty($alpha)){							
				$queryWHERE[] = 'c.company_name LIKE "'.$alpha.'%"';
			}
		
			$querySELECT = "SELECT count(c.id) as countRecords FROM ".$this->table_company." as c ";
			if(count($queryWHERE)>0){
				$queryWHERE = implode(' AND ',$queryWHERE);
			} else {
				$queryWHERE = "";
			}
			$buildQuery = $querySELECT." ".$queryJOIN." ";
			if($queryWHERE!=""){
				$buildQuery .=" WHERE ".$queryWHERE;
			}		
			/*echo $buildQuery;*/
			$resultCount = $this->db->query($buildQuery);
			if($resultCount->num_rows() > 0){
				$getCount = $resultCount->first_row();
				$data['count_all'] = $getCount->countRecords;
				$querySELECT = "SELECT distinct(c.id) as companyID, c.id, c.company_name,c.web_address, c.linkedin_url,c.scrapped_date,c.scrapped_profile_date,c.industry,c.no_of_employees,c.company_size,c.company_size_type,c.specialties,c.scrape_p,c.scrape_people_again, (SELECT count(*) as company_users FROM ".$this->table." WHERE company_id=c.id) as company_users,'' as sectorName, '' as department_names,'' as sub_department_names, '' as technology_names, '' as sub_technology_names , c.label, c.revenue, c.create_date FROM ".$this->table_company." as c ";
				
				$buildQuery = $querySELECT." ".$queryJOIN." ";
				if($queryWHERE!=""){
					$buildQuery .=" WHERE ".$queryWHERE;
				}

				$buildQuery .=" ORDER BY ".$sort." ".$orderBy;
				$buildQuery .=" LIMIT ".$start.",".$end;
				$query = $this->db->query($buildQuery);
				/*echo $this->db->last_query();*/			
				$mapTech = array();
				$mapCategpry = array();		
				$mapSubCategory = array();
				if($query->num_rows()>0){
					$companyDataResult = $query->result();
					if($rs === true){
						$companyIDs = array();
						$started = microtime(true);
						for($i=0;$i<count($companyDataResult);$i++){
							$companyIDs[] =  $companyDataResult[$i]->id;
						}
						/*$usersList = $this->getCountAllContactBelongToAllCompanyOptimized($companyIDs);*/
						$started = microtime(true);
						$sectorsList = $this->findAllCompanySectorsOptimized($companyIDs);
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
							$getDepartmentsList = $this->findAllCompanyPreferenceWithNameSub($sectorsCompanies,1);
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
						$technologies = $this->findAllCompaniesTechnologiesPreferenceWithNameSub($companyIDs,0);
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
							$subTechnologies = $this->findAllCompaniesTechnologiesPreferenceWithNameSub($techCompanyIDs,1);
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
								$subsubTechnologies = $this->findAllCompaniesTechnologiesPreferenceWithNameSub($subTechCompanyIDs,2);
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
	
	public function companyListWithPaging($search,$sector,$cat="",$subCat="",$tech="",$subTech="",$users="",$linkedin="",$industry=array(),$company_size=array(),$no_of_size="",$sort='c.company_name',$orderBy='ASC',$start,$end,$leadID = 0, $activity = 0,$invited = 2,$rs = true){
		$data = array('count_all'=>0,'data'=>array());
		$search = trim($search);
		$allCompanies = array();
		$companySizeList = array();
		$linkedinUserList = array();
		$mainFilter = false;
		if($leadID>0 && $activity>0 && $invited==0){			
			if($activity==1){
				$getLeadCompanyList = $this->getSalesActivityCompaniesByLead($leadID);
			} else if($activity==2){
				$getLeadCompanyList = $this->getAcquisitionActivityCompaniesByLead($leadID);
			}
			if(isset($getLeadCompanyList) && count($getLeadCompanyList)>0){
				foreach($getLeadCompanyList as $c){
					array_push($allCompanies,$c->id);
				}
			}
		}
		if($linkedin!=""){
			$mainFilter = true;
			if(count($allCompanies)>0){
				$this->db->where_in('id',$allCompanies);
			}
			$queryLinkedInSize = $this->db->select("id")->from($this->table_company)->where_in('no_of_employees',explode(',',$linkedin))->get();
			if($queryLinkedInSize->num_rows()>0){
				$getCS = $queryLinkedInSize->result();
				$allCompanies = array();
				foreach($getCS as $c){
					array_push($allCompanies,$c->id);
				}
			} else {
				$allCompanies = array();
			}
		}
		/*echo "All Companies";
		print_r($allCompanies);*/
		if(count($company_size)>0){
			$mainFilter = true;
			$listCompanySize = array();
			
			foreach($company_size as $cs){
				if(count($allCompanies)>0){
					$queryCompanySize = $this->db->query("SELECT id FROM ".$this->table_company." WHERE company_size=".$cs." AND id IN (".implode(',',$allCompanies).")");
				} else {
					$queryCompanySize = $this->db->query("SELECT id FROM ".$this->table_company." WHERE company_size=".$cs);
				}
				if($queryCompanySize->num_rows()>0){
					$getCS = $queryCompanySize->result();
					foreach($getCS as $c){
						array_push($listCompanySize,$c->id);
					}
				}
			}
			$allCompanies = array();
			if(count($listCompanySize)>0){
				$allCompanies = $listCompanySize;
			}	
		}
		/*echo "All Companies";
		print_r($allCompanies);*/
		if(count($industry)>0){
			$mainFilter = true;
			$listIndustries = array();
			foreach($industry as $ind){
				if(count($allCompanies)>0){
					$queryIndustry = $this->db->query("SELECT id FROM ".$this->table_company." WHERE industry=".$ind." AND id IN (".implode(',',$allCompanies).")");
				} else {
					$queryIndustry = $this->db->query("SELECT id FROM ".$this->table_company." WHERE industry=".$ind);
				}
				/*echo $this->db->last_query()."<br/>";*/
				if($queryIndustry->num_rows()>0){
					$getIndCompanies = $queryIndustry->result();
					foreach($getIndCompanies as $c){
						array_push($listIndustries,$c->id);
					}
				}
			}
			$allCompanies = array();
			if(count($listIndustries)>0){
				$allCompanies = $listIndustries;
			}
		}
		/*echo "All Companies";
		print_r($allCompanies);*/
		if($no_of_size!=""){
			$mainFilter = true;
			if(count($allCompanies)>0){
				$this->db->where_in('id',$allCompanies);
			}
			$queryEmployeesSize = $this->db->select("id")->from($this->table_company)->where_in('no_of_employees',explode(',',$no_of_size))->get();
			if($queryEmployeesSize->num_rows()>0){
				$getCS = $queryEmployeesSize->result();
				$allCompanies = array();
				foreach($getCS as $c){
					array_push($allCompanies,$c->id);
				}
				/*if(count($allCompanies)>0){
					$allCompanies = array_intersect($allCompanies,$csCompanies);
				} else {
					$allCompanies = $csCompanies;
				}*/
			} else {
				$allCompanies = array();
			}
		}
		
		if($cat!="" && $subCat!=""){
			try{
				$mainFilter = true;
				$jsonCat = explode(',',$cat);					
				$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonCat)->get();
				if($spQuery->num_rows()>0){
					$getLs = $spQuery->result();
					$scList = array();
					foreach($getLs as $ls){
						$scList[] = $ls->customer_id;
					}
					$jsonSubCat = explode(',',$subCat);
					if(count($allCompanies)>0){
						$scList = array_combine($scList,$allCompanies);
						$scList = array_unique($scList);
					}
					$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonSubCat)->where_in('p.customer_id',$scList)->get();
					if($spQuery->num_rows()>0){
						$getLs = $spQuery->result();
						$scList = array();
						$allCompanies = array();
						foreach($getLs as $ls){
							array_push($allCompanies,$ls->customer_id);
						}
					} else {
						$allCompanies = array();
					}
				}				
				/*
				$allTech = array_merge($jsonCat,$jsonSubCat);
				if(count($allTech)>0){
					$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
					$this->db->where_in('p.preference_id',$allTech);
				}*/					
			}catch(Exception $e){
			}
		} else if($cat!=""){
			try{
				/*$jsonCat = explode(',',$cat);
				if(count($jsonCat)>0){
					$this->db->join($this->table_preference.' as p', 'p.customer_id = c.id');
					$this->db->where_in('p.preference_id',$jsonCat);
				}*/	
				$mainFilter = true;
				$jsonCat = explode(',',$cat);	
				if(count($allCompanies)>0){
					$this->db->where_in('p.customer_id',$allCompanies);
				}				
				$spQuery = $this->db->select('p.customer_id')->from($this->table_preference.' as p')->where_in('p.preference_id',$jsonCat)->get();
				if($spQuery->num_rows()>0){
					$getLs = $spQuery->result();
					$allCompanies = array();
					foreach($getLs as $ls){
						array_push($allCompanies,$ls->customer_id);
					}
				} else {
					$allCompanies = array();
				}			
			}catch(Exception $e){
			}
		}
		
		if($users!=""){
			$mainFilter = true;
			$explodeUsers = explode(',',$users);
			$companyList = array();
			$excludeCompanies = array();
			foreach($explodeUsers as $u){
				if($u!=""){
					$queryString = "SELECT count(id) as countUsers,company_id FROM ".$this->table;					
					if(count($allCompanies)>0){
						$queryString .= " WHERE company_id IN(".implode(',',$allCompanies).") ";
					}
					$pat = false;
					$queryString .=" GROUP BY company_id ";
					if((int)$u>0){
						$queryString .=" HAVING countUsers =".$u;
					} else if((int)$u==0){
						$pat = true;
						$queryString .=" HAVING countUsers <> 0";
					}
					
					$queryString .=" ORDER BY countUsers";
					$queryFindCompany = $this->db->query($queryString);
					if($queryFindCompany->num_rows()>0){
						$companies = $queryFindCompany->result();
						if($pat===false){
							$companyList = array_merge($companyList,$companies);
						}	else {
							$excludeCompanies = array_merge($excludeCompanies,$companies);
						}					
					}
				}					
			}
			if(count($companyList)>0){
				$allCompanies = array();
				foreach($companyList as $company){
					array_push($allCompanies,$company->company_id);
				}
				$allCompanies = array_unique($allCompanies);
			} else if(count($excludeCompanies)==0 ){
				$allCompanies = array();
			}
			if(count($allCompanies)>0 && count($excludeCompanies)>0){
				$exCompany = array();
				foreach($excludeCompanies as $company){
					array_push($exCompany,$company->company_id);
				}
				$allCompanies  = array_diff($allCompanies,$exCompany);
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
		if(!empty($search) && !empty($sector)){						
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}		
			
			if($sector=='Unclassify'){
				$this->db->where('c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)');	
			} else {
				$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
				$this->db->where('cs.sector_id IN ('.$sector.')');	
			}
			
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			$data['count_all'] = $this->db->select("count(distinct(c.id)) as countRecords")->from($this->table_company.' as c')->where('c.company_name LIKE "%'.$search.'%"')->order_by($sort,$orderBy)->get()->row()->countRecords;
			/*echo $this->db->last_query()."<br/>";*/
			/*Company Size*/
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}		
			if($sector!=""){
				
				if($sector=='Unclassify'){
					$this->db->where('c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)');	
				} else {
					$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
					$this->db->where('cs.sector_id IN ('.$sector.')');	
				}
				/*$this->db->where('cs.sector_id IN ('.$sector.')');*/
			}	
			/*echo $this->db->last_query()."<br/>";*/
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			$queryCompanySize = $this->db->select("distinct(c.company_size) as company_size")->from($this->table_company.' as c')->where('c.company_size <>',"0")->where('c.company_size <>',"")->where('c.company_name LIKE "%'.$search.'%"')->order_by('c.company_size','ASC')->get();			
			if($queryCompanySize->num_rows()){
				$companySizeList = $queryCompanySize->result();
			}
			
			/*Company Size*/
			
			/*LinkedinUser scrapper*/
			
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}		
			if($sector!=""){
				
				if($sector=='Unclassify'){
					$this->db->where('c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)');	
				} else {
					$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
					$this->db->where('cs.sector_id IN ('.$sector.')');	
				}
				/*$this->db->where('cs.sector_id IN ('.$sector.')');*/
			}	
			/*echo $this->db->last_query()."<br/>";*/
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			
			$queryLinkedInCompanyUser = $this->db->select("DISTINCT(c.no_of_employees) as linkedinCompanyUsers")->from($this->table_company.' as c')->where('c.no_of_employees <> ',"")->where('c.no_of_employees <> ','null')->order_by('linkedinCompanyUsers','ASC')->get();
			if($queryLinkedInCompanyUser->num_rows()){
				$linkedinUserList = $queryLinkedInCompanyUser->result();
			}
			
			/*End LinkedinUser Scrapper*/
			
			if($end>0){
				$this->db->limit($end,$start);
			}		
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			
			/*$this->db->where('cs.sector_id IN ('.$sector.')');*/
			if($sector=='Unclassify'){
				$this->db->where('c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)');	
			} else {
				$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
				$this->db->where('cs.sector_id IN ('.$sector.')');	
			}
			/*echo $this->db->last_query()."<br/>";*/
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			/*if($linkedin=="1" || $linkedin=="2"){
				if($linkedin=="1"){
					$this->db->where('c.linkedin_url','');
				} else if($linkedin=="2"){
					$this->db->where('c.linkedin_url <> ','');
				}
			}*/
			$query = $this->db->select("distinct(c.id) as companyID ,c.*")->from($this->table_company.' as c')->where('c.company_name LIKE "%'.$search.'%"')->order_by($sort,$orderBy)->get();
		} else if(empty($search) && !empty($sector)){	
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			
			/*$this->db->where('cs.sector_id IN ('.$sector.')');*/
			if($sector=='Unclassify'){
				$this->db->where('c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)');	
			} else {
				$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
				$this->db->where('cs.sector_id IN ('.$sector.')');	
			}
			/*echo $this->db->last_query()."<br/>";*/
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			/*if($linkedin=="1" || $linkedin=="2"){
				if($linkedin=="1"){
					$this->db->where('c.linkedin_url','');
				} else if($linkedin=="2"){
					$this->db->where('c.linkedin_url <> ','');
				}
			}*/
			$data['count_all'] = $this->db->select("count(distinct(c.id)) as countRecords")->from($this->table_company.' as c')->order_by($sort,$orderBy)->get()->row()->countRecords;
			
			/*Company Size*/
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}		
			if($sector!=""){
				
				/*$this->db->where('cs.sector_id IN ('.$sector.')');*/
				if($sector=='Unclassify'){
					$this->db->where('c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)');	
				} else {
					$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
					$this->db->where('cs.sector_id IN ('.$sector.')');	
				}
			}
			/*echo "TAP<br/>".$this->db->last_query()."<br/>";*/
			$queryCompanySize = $this->db->select("distinct(c.company_size) as company_size")->from($this->table_company.' as c')->where('c.company_size <>',"0")->where('c.company_size <>',"")->order_by('c.company_size','ASC')->get();			
			if($queryCompanySize->num_rows()){
				$companySizeList = $queryCompanySize->result();
			}
			
			/*Company Size*/
			
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}		
			if($sector!=""){
				
				/*$this->db->where('cs.sector_id IN ('.$sector.')');*/
				if($sector=='Unclassify'){
					$this->db->where('c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)');	
				} else {
					$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
					$this->db->where('cs.sector_id IN ('.$sector.')');	
				}
			}
			/*echo $this->db->last_query()."<br/>";*/
			
			$queryLinkedInCompanyUser = $this->db->select("DISTINCT(c.no_of_employees) as linkedinCompanyUsers")->from($this->table_company.' as c')->where('c.no_of_employees <> ',"")->where('c.no_of_employees <> ','null')->order_by('linkedinCompanyUsers','ASC')->get();
			if($queryLinkedInCompanyUser->num_rows()){
				$linkedinUserList = $queryLinkedInCompanyUser->result();
			}
			
			/*End LinkedinUser Scrapper*/
			
			if($end>0){
				$this->db->limit($end,$start);
			}				
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			
			/*$this->db->where('cs.sector_id IN ('.$sector.')');*/
			if($sector=='Unclassify'){
				$this->db->where('c.id NOT IN (SELECT company_id FROM '.$this->table_company_sector.' as temp_c)');	
			} else {
				$this->db->join($this->table_company_sector.' as cs', 'c.id = cs.company_id');
				$this->db->where('cs.sector_id IN ('.$sector.')');	
			}
			/*echo $this->db->last_query()."<br/>";*/
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			
			$query = $this->db->select("distinct(c.id) as companyID ,c.*")->from($this->table_company.' as c')->order_by($sort,$orderBy)->get();
		} else if($search!="" && empty($sector)){				
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}		
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			
			$data['count_all'] = $this->db->select("count(distinct(c.id)) as countRecords")->from($this->table_company.' as c')->where('c.company_name LIKE "%'.$search.'%"')->order_by($sort,$orderBy)->get()->row()->countRecords;
			
			/*Company Size*/
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}		
			
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			
			$queryCompanySize = $this->db->select("distinct(c.company_size) as company_size")->from($this->table_company.' as c')->where('c.company_size <>',"0")->where('c.company_size <>',"")->where('c.company_name LIKE "%'.$search.'%"')->order_by('c.company_size','ASC')->get();			
			if($queryCompanySize->num_rows()){
				$companySizeList = $queryCompanySize->result();
			}
			
			/*End Company Size*/
			/*LinkedinScrapper*/
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}		
			
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			
			$queryLinkedInCompanyUser = $this->db->select("DISTINCT(c.no_of_employees) as linkedinCompanyUsers")->from($this->table_company.' as c')->where('c.no_of_employees <> ',"")->where('c.no_of_employees <> ','null')->order_by('linkedinCompanyUsers','ASC')->get();
			if($queryLinkedInCompanyUser->num_rows()){
				$linkedinUserList = $queryLinkedInCompanyUser->result();
			}
			
			/*End LinkedinUser Scrapper*/
			
			
			
			if($end>0){
				$this->db->limit($end,$start);
			}
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			
			$query = $this->db->select("distinct(c.id) as companyID ,c.*")->from($this->table_company.' as c')->where('c.company_name LIKE "%'.$search.'%"')->order_by($sort,$orderBy)->get();
		} else {
			
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			
			$data['count_all'] = $this->db->select("count(c.id) as countRecords")->from($this->table_company.' as c')->order_by($sort,$orderBy)->get()->row()->countRecords;
			/*echo $this->db->last_query()."<br/>";*/
			
			/*Company Size*/
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}		
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			
			$queryCompanySize = $this->db->select("distinct(c.company_size) as company_size")->from($this->table_company.' as c')->where('c.company_size <>',"0")->where('c.company_size <>',"")->order_by('c.company_size','ASC')->get();			
			if($queryCompanySize->num_rows()){
				$companySizeList = $queryCompanySize->result();
			}
			
			/*End Company Size*/
			
			/*LinkedinScrapper*/
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}		
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			
			$queryLinkedInCompanyUser = $this->db->select("DISTINCT(c.no_of_employees) as linkedinCompanyUsers")->from($this->table_company.' as c')->where('c.no_of_employees <> ',"")->where('c.no_of_employees <> ','null')->order_by('linkedinCompanyUsers','ASC')->get();
			if($queryLinkedInCompanyUser->num_rows()){
				$linkedinUserList = $queryLinkedInCompanyUser->result();
			}
			
			if($end>0){
				$this->db->limit($end,$start);
			}
			
			if($tech!="" && $subTech!=""){
				try{
					$jsonTech = explode(',',$tech);
					$jsonSubTech = explode(',',$subTech);
					$allTech = array_merge($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($tech!=""){
				try{
					$jsonTech = explode(',',$tech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.id');
						$this->db->where_in('t.preference_id',$jsonCat);
					}					
				}catch(Exception $e){
				}
			}
			if(count($allCompanies)>0){
				$this->db->where_in('c.id',$allCompanies);
			}
			
			$query = $this->db->select("distinct(c.id) as companyID, c.*")->from($this->table_company.' as c')->order_by($sort,$orderBy)->get();
			/*echo $this->db->last_query()."<br/>";*/
		}
		/*echo $this->db->last_query()."<br/>";*/
		$mapTech = array();
		$mapCategpry = array();		
		$mapSubCategory = array();
		if ($query->num_rows() > 0) { 
            if($rs === true){
				foreach ($query->result() as $row) {
					$usersList = $this->getCountAllContactBelongToCompany($row->id);
					$sectors = $this->findCompanySectors($row->id);
					$sectorsName = "";
					if(count($sectors)>0){
						foreach($sectors as $deptt){
							$sectorsName .= $deptt->sectorName.", ";
						}
						$sectorsName= substr($sectorsName,0,-2);
					}
					$row->sectorName = $sectorsName;
					$departments = $this->findMyPreferenceWithNameSub($row->id,1);
					$deptNames = "";
					$subdeptNames = "";
					foreach($departments as $deptt){
						if($deptt->parent==0){
							$deptNames .= $deptt->name.", ";
							if(!in_array($deptt->id,$mapCategpry)){
								$mapCategpry[] = $deptt->id;
								$category[] = array('id'=>$deptt->id,'name'=>$deptt->name);
							}						
						} else {
							$subdeptNames .= $deptt->name.", ";						
							if(!in_array($deptt->id,$mapSubCategory)){
								$mapSubCategory[] = $deptt->id;
								$subCategory[] = array('id'=>$deptt->id,'name'=>$deptt->name);
							}
						}					
					}
					$deptNames= substr($deptNames,0,-2);
					$subdeptNames= substr($subdeptNames,0,-2);
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
							if(!in_array($tech->id,$mapTech)){
								$mapTech[] = $tech->id;
								$subTechnology[] = array('id'=>$tech->id,'name'=>$tech->name);
							}
						}
						$subTechnologyNames= substr($subTechnologyNames,0,-2);
					}
					$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->id,2);				
					if(count($subsubTechnologies)>0){
						foreach($subsubTechnologies as $tech){
							$subTechnologyNames .= $tech->name.", ";
							if(!in_array($tech->id,$mapTech)){
								$mapTech[] = $tech->id;
								$subTechnology[] = array('id'=>$tech->id,'name'=>$tech->name);
							}
						}
						$subTechnologyNames= substr($subTechnologyNames,0,-2);
					}
					$row->technology_names = $technologyNames;
					$row->sub_technology_names = $subTechnologyNames;
					$row->company_users = $usersList;
					$row->department_names = $deptNames;
					$row->sub_department_names = $subdeptNames;
					array_push($data['data'],$row);
				}
			} else {
				$data['data'] = $query->result();
			}
        }
		endif;
		$data['company_size_list'] = $companySizeList;
		$data['linkedin_company_users'] = $linkedinUserList;
		$data['cat'] = $category;
		$data['sub_cat'] = $subCategory;
		$data['sub_tech'] = $subTechnology;
		return $data; 
	}
	
	
	function simpleCompanyQuery($l){
		echo date('Y-m-d H:i:s')."<br/>";
		$started = microtime(true);
		$result = $this->db->query("SELECT * FROM company ORDER BY company_name ASC limit 200");
		echo date('Y-m-d H:i:s')."<br/>";
		$end = microtime(true);
		$difference = $end - $started;
		$queryTime = number_format($difference, 10);
		echo "SQL query took $queryTime seconds.";
	}
	
	
	public function getSelectedCompaniesSectorsTechnologiesList($companiesIDs){
		$list = array();
		if(count($companiesIDs)>0){
			$mapCategory = array();
			$mapSubCategory = array();
			$mapTech = array();
			$category= array();
			$subCategory= array();
			foreach($companiesIDs as $company){
				$companyData = array();
				$sectors = $this->findCompanySectors($company);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$companyData['sectorName'] = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($company,1);
				$deptNames = "";
				$subdeptNames = "";
				foreach($departments as $deptt){
					if($deptt->parent==0){
						$deptNames .= $deptt->name.", ";
						if(!in_array($deptt->id,$mapCategory)){
							$mapCategpry[] = $deptt->id;
							$category[] = array('id'=>$deptt->id,'name'=>$deptt->name);
						}						
					} else {
						$subdeptNames .= $deptt->name.", ";						
						if(!in_array($deptt->id,$mapSubCategory)){
							$mapSubCategory[] = $deptt->id;
							$subCategory[] = array('id'=>$deptt->id,'name'=>$deptt->name);
						}
					}					
				}
				$deptNames= substr($deptNames,0,-2);
				$subdeptNames= substr($subdeptNames,0,-2);
				$technologies = $this->findTechnologiesPreferenceWithNameSub($company,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($company,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
						if(!in_array($tech->id,$mapTech)){
							$mapTech[] = $tech->id;
							$subTechnology[] = array('id'=>$tech->id,'name'=>$tech->name);
						}
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($company,2);
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
						if(!in_array($tech->id,$mapTech)){
							$mapTech[] = $tech->id;
							$subTechnology[] = array('id'=>$tech->id,'name'=>$tech->name);
						}
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$companyData['technology_names'] = $technologyNames;
				$companyData['sub_technology_names'] = $subTechnologyNames;
				$companyData['department_names'] = $deptNames;
				$companyData['sub_department_names'] = $subdeptNames;
				$companyData['category'] = $category;
				$companyData['sub_category'] = $subCategory;
				$data['data'] = $companyData;
				$data['company'] = $company;
				$list[] = $data;
				$data = array();
			}			
		}
		return $list;
	}
	
	public function findAllCompanyPreferenceWithNameSub($companyIDs,$type){
		$query = $this->db->select("c.*,p.customer_id")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where_in("p.customer_id",$companyIDs)->where('c.type',$type)->get();
		//$this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		return $data;
	}
	
	public function findMyPreferenceWithNameSub($customerID,$type){
		$query = $this->db->select("c.*")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.customer_id",$customerID)->where('c.type',$type)->get();
		$this->db->last_query();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		return $data; 
	}
	
	
	
	public function findAllCompaniesTechnologiesPreferenceWithNameSub($companyIDs,$type){
		$query = $this->db->select("c.*,p.company_id")->from($this->table_technology_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where_in("p.company_id",$companyIDs)->where('c.type',$type)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
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
	
	public function customersList($companyID){
		if($companyID!=null){
			$query = $this->db->select("cu.first_name,cu.last_name,cu.email,cu.phone_number,cu.id,c.id as contactID")->from($this->table_customer.' as cu')->join($this->table.' as c','c.email = cu.email','left')->where("cu.company_id",$companyID)->order_by('cu.first_name','ASC')->get();
		} else {
			$query = $this->db->select("cu.*")->from($this->table_customer.' as cu')->join($this->table.' as c','c.email = cu.email','left')->order_by('cu.first_name','ASC')->get();
		}		
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		return $data;  
	}
	
	public function getAllCustomerCompanyList(){
		$query = $this->db->select("distinct(c.id) as companyID,c.*, cu.create_date as activationDate,cu.last_login as lastLogin,cu.company_name as customerCompanyName,c.file,c.end_date")->from($this->table_customer.' as cu')->join($this->table_company.' as c','c.id = cu.company_id')->group_by('cu.company_id')->order_by('company_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();
        }
		return $data; 
	}
	
	function getUsersByActDeactCompanies($companyID,$status){
		$query = $this->db->select("count(*) as users")->from($this->table_customer)->where("company_id",$companyID)->where("status",$status)->get()->row();
		/*echo $this->db->last_query();*/
		return $query->users;
	}
}

?>