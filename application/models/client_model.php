<?php
class client_model extends CI_Model{
	public $table = "contacts";
	public $table_invite_sector = "invitees_in_sectors";
	public $table_sector = "sectors";
	public $table_company = 'company';
	public $table_customers = 'customers';
	public $table_company_sector = 'company_sector';
	public $table_preference = 'preferences';
	public $table_technology_preference = 'technology_preference';
	public $table_category = 'category';
	public $table_invitees = 'invitees';
	public $table_backyard_invitees = 'backyard_invitees';
	public $table_acquisition_company = 'acquisition_company';
	public $table_dummy = 'dummy_contacts';
	public $table_company_other_names = "company_other_names";
	public $table_due_dilligence_citations = 'due_dilligence_citations';
	public $table_linkedin_threads = 'linkedin_threads';
	function __construct() {
		parent::__construct();
	}
	
	function insertDummy($data){
		// Inserting in Table(Litigation) 
		$this->db->insert($this->table_dummy, $data);
		return $this->db->insert_id();
	}
	function insert($data){
		// Inserting in Table(Litigation) 
		$data = (array)$data;
		if(isset($data['linkedin_url']) && substr($data['linkedin_url'],-1) == "/"){
			$data['linkedin_url'] = substr($data['linkedin_url'],0,-1);
		}
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}	
	public function insertContactsInBatch($insertArrayBulk){
		$this->db->insert_batch($this->table,$insertArrayBulk);
		return $this->db->insert_id();
	}
	function update($id,$data){
		$this->db->where('id', $id);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
	function updateCompanyLogo($data,$id){
		$this->db->where('id', $id);
		$this->db->update($this->table_company,$data);
		return $this->db->affected_rows();
	}
	
	function updateCompanyDataByOwlerUrl($data,$owlerUrl){
		$data['scrape_owler'] = 1;
		$data['scrapped_owler_date'] = date('Y-m-d');
		$this->db->where('owler_url', $owlerUrl);
		$this->db->update($this->table_company,$data);
		return $this->db->affected_rows();
	}
	
	function getAllClients(){
		$query = $this->db->select('*')->from($this->table)->order_by('name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}	
	
	function uniqueCompanies(){
		$query = $this->db->select('distinct(company_name) as companyName, id')->from($this->table_company)->order_by('companyName','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
		}
		return $data;
	}
	
	function getAllLogos(){
		$query = $this->db->select("id,company_logo")->from($this->table_company)->where('company_logo <>','')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function find_company_from_current_company(){
		$query = $this->db->query("Select id,company_name from company where company_name IN (Select current_company from contacts where company_id = 0 and current_company <> '');");
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	
	function findWrongDataContacts(){
		$query = "SELECT count(*) as c,concat(a.first_name,' ', a.last_name) as name, a.first_name, a.last_name, a.linkedin_url, a.id FROM contacts a WHERE a.linkedin_url <> '' GROUP BY name HAVING c > 1";
		$queryResult = $this->db->query($query);
		$list = array();
		if ($queryResult->num_rows() > 0) {
			$listContacts = $queryResult->result();
			foreach($listContacts as $contact){
				$queryContact = $this->db->select('*')->from($this->table)->like("first_name",$contact->first_name)->like("last_name",$contact->last_name)->get();
				if ($queryContact->num_rows() > 0) {
					$result = $queryContact->result();
					foreach($result as $res){
						array_push($list,$res);
					}
				}
			}
		}
		return $list;
	}
	
	function updateRecentContactList($list){
		$data = 0;
		$query = "SELECT id FROM ".$this->table." WHERE ";
		if(count($list) > 0) {
			foreach($list as $linkedinURL){
				$query .= "linkedin_url LIKE '%".$linkedinURL."%' OR ";
			}
			$query = substr($query,0,-3);
			echo $query ;
			$queryResult = $this->db->query($query);
			$data = array();
			if ($queryResult->num_rows() > 0) {
				$listContacts = $queryResult->result();
				$contactsID = array();
				foreach($listContacts as $c){
					array_push($contactsID, $c->id);
				}
				$this->db->where_in('id',$contactsID);
				$this->db->update($this->table,array('proximity'=>1));
				$data = $this->db->affected_rows();
			}
		}
		return $data;
	}
	
	function findMissingSpotsContacts(){
		$query = $this->db->select('c.first_name,c.last_name,c.job_title,co.company_name,c.email,c.phone,c.linkedin_url')->from($this->table.' as c')->join($this->table_company.' as co','co.id = c.company_id')->where('c.email','')->or_where('c.linkedin_url','')->or_where('c.phone','')->order_by('first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}	
	function findCIPOList(){
		$query = $this->db->select('c.id,c.first_name,c.last_name,c.linkedin_url')->from($this->table.' as c')->where('c.import_list >',1)->where('c.company_id',0)->where('c.linkedin_url <>','')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	function find_contact_by_linkedin_and_proxmity($proximity){
		$query = $this->db->select('c.id,c.first_name,c.last_name,c.linkedin_url,c.company_id')->from($this->table.' as c')->where_in('c.proximity',$proximity)->where('c.linkedin_url <>','')->where('c_c',0)->order_by('c.proximity','DESC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	function find_contact_withoutCompany(){
		$query = $this->db->select('c.id,c.first_name,c.last_name,c.linkedin_url,c.company_id,c.current_company')->from($this->table.' as c')->where('c.company_id',0)->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
        }
		return $data;
	}
	function find_contact_with_null_company(){
		$query = $this->db->query('SELECT c.id, c.company_id,co.company_name,c.current_company FROM  contacts as c LEFT JOIN company as co ON co.id = c.company_id WHERE c.company_id <> 0 and co.company_name IS NULL');
		$data = array('users'=>array(),'company'=>array());
		if ($query->num_rows() > 0) {
			$data['users'] = $query->result();
        }
		$query = $this->db->query('SELECT id,company_name FROM company where company_name IN (SELECT c.current_company FROM  contacts as c LEFT JOIN company as co ON co.id = c.company_id WHERE c.company_id <> 0 and co.company_name IS NULL)');
		if ($query->num_rows() > 0) {
			$data['company'] = $query->result();
        }
		return $data;
	}
	function getInfo($contactID,$select='*'){
		$query = $this->db->select($select)->from($this->table)->where('id',$contactID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}	
	
	function find_contact_by_name($name){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name")->from($this->table.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where("CONCAT(c.first_name, ' ', c.last_name) LIKE '%".addslashes($name)."%'")->order_by('c.id','desc')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}

	function find_contact_by_name_list($name){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name")->from($this->table.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where("CONCAT(c.first_name, ' ', c.last_name) LIKE '%".addslashes($name)."%'")->order_by('c.id','desc')->get();
		/*echo $this->db->last_query();*/
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();         
        }
		return $data;
	}
	
	function findContactNotEqualToCurrentCompany(){
		$selectQuery = "SELECT c1.*, co1.company_name  FROM ".$this->table." as c1 INNER JOIN ".$this->table_company." as co1 ON co1.id = c1.company_id WHERE c1.id NOT IN (Select c.id FROM ".$this->table." as c INNER JOIN ".$this->table_company." as co ON co.id = c.company_id WHERE current_company <> '' AND current_company = co.company_name) AND c1.current_company <> ''";
		$query = $this->db->query($selectQuery);
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();         
        }
		return $data;		
	}
	
	function findCompanyOwler(){
		$query = $this->db->select("c.id,c.company_name,c.company_logo")->from($this->table_company.' as c')->where("c.owler_url", '')->order_by('c.company_name','ASC')->get();
		/*echo $this->db->last_query();*/
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();         
        }
		return $data;
	}
	
	function findAllOwlerCompanies(){
		$query = $this->db->select("c.id,c.owler_url")->from($this->table_company.' as c')->where("c.owler_url <>", '')->where("c.scrape_owler", 0)->order_by('c.id','ASC')->get();
		/*echo $this->db->last_query();*/
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();         
        }
		return $data;
	}

	function find_contact_by_jobtitle_list($name){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name")->from($this->table.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where("c.job_title LIKE '%".addslashes($name)."%'")->order_by('c.id','desc')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();         
        }
		return $data;
	}
	
	function findContactByThreadIndentifier($threadID){
		$data = array();
		$query = $this->db->select('public_identifiers')->from($this->table_linkedin_threads)->where('thread_id',$threadID)->limit(1)->get();
		if($query->num_rows() > 0){
			$row = $query->first_row();
			if($row->public_identifiers != ""){
				$linkedIN = $row->public_identifiers;
				$anotherUrl = substr($linkedIN,-1);
				if($anotherUrl == "/"){
					$anotherUrl = substr($linkedIN,0,-1);
				} else {
					$anotherUrl = $linkedIN.'/';
				}
				$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name")->from($this->table.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where('c.linkedin_url',$linkedIN)->or_where('c.linkedin_url',$anotherUrl)->get();				
				if ($query->num_rows() > 0) {
					$data = $query->result();         
				}
			}
		}
		return $data;
	}
	
	function findContactByThreadID($threadID){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name")->from($this->table.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where("linkedin_thread_id",$threadID)->order_by('name','ASC')->get();
		$data = array();
		
		if ($query->num_rows() > 0) {
            $data = $query->result();         
        }
		return $data;
	}
	
	function getContactByName($firstName,$lastName){
		if(strpos($firstName,"Dr.") !== false){
			$firstName = trim(str_replace("Dr.","",$firstName));
		}
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name")->from($this->table.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where("lower(first_name)",$firstName)->where("lower(last_name)",$lastName)->order_by('name','ASC')->get();
		$data = array();
		
		if ($query->num_rows() > 0) {
            $data = $query->result();         
        }
		return $data;
	}
	
	function find_contact_by_email($emailID){
		$query = $this->db->select('*')->from($this->table)->where('email',$emailID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}
	function find_contact_by_linkedin($linkedIN){
		$anotherUrl = substr($linkedIN,-1);
		if($anotherUrl == "/"){
			$anotherUrl = substr($linkedIN,0,-1);
		} else {
			$anotherUrl = $linkedIN.'/';
		}
		$query = $this->db->select('*')->from($this->table)->where('linkedin_url',$linkedIN)->or_where('linkedin_url',$anotherUrl)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}	
	function find_company_by_linkedin($linkedIN){
		$anotherUrl = substr($linkedIN,-1);
		if($anotherUrl == "/"){
			$anotherUrl = substr($linkedIN,0,-1);
		} else {
			$anotherUrl = $linkedIN.'/';
		}
		$query = $this->db->select('*')->from($this->table_company)->where('linkedin_url',$linkedIN)->or_where('linkedin_url',$anotherUrl)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}	
	
	function find_company_by_owler($owlerUrl){
		$query = $this->db->select('*')->from($this->table_company)->where('owler_url',$owlerUrl)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}
	
	function getContactListByIDs($contactsIDs,$select="*"){
		$query = $this->db->select($select)->from($this->table)->where_in('id',$contactsIDs)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->result();			
        }
		return $data;
	}
	
	function findCompaniesWithOwlerUrlByIDs($companyIDs){
		$query = $this->db->select('id,owler_url')->from($this->table_company)->where('owler_url <>','')->where_in('id',$companyIDs)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $list = $query->result();
			foreach($list as $company){
				if(strpos($company->owler_url,"owler.com") !== false){
					array_push($data,$company->id);
				}				
			}
        }
		return $data;
	}
	
	function deleteContact($ID){
		$this->db->delete($this->table,array("id"=>$ID));
		return $this->db->affected_rows();
	}	
	function deleteCompany($ID){
		$this->db->delete($this->table_company_sector,array("company_id"=>$ID));
		$this->db->delete($this->table_company,array("id"=>$ID));
		return $this->db->affected_rows();
	}	
	function deleteCompanyInBulk($IDs){
		$this->db->where_in('id',$IDs);
		$this->db->delete($this->table_company);
		$this->db->where_in('company_id',$IDs);
		$this->db->delete($this->table_company_sector);
		$this->db->where_in('company_id',$IDs);
		$this->db->delete($this->table_company_other_names);
		$this->db->where_in('company_id',$IDs);
		$this->db->update($this->table_due_dilligence_citations,array('company_id'=>0));
		return $this->db->affected_rows();
	}
	function find_contact($ID){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name, co.telephone as company_tel")->from($this->table.' as c')->join($this->table_company.' as co','co.id=c.company_id','left')->where("c.id",$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();         
        }
		return $data;
	}	
	
	function findContactWithCompanyinfo($ID){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where("c.id",$ID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$sectors = $this->getAllCompanySectors($row->companyID);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->companyID,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->companyID,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data[] = $row;
            }            
        }		
		return $data;
	}
	
	
	function findSectorDataName($sectorName){
		$queryMySend = $this->db->select("*")->from($this->table_sector.' as c')->where('LOWER(c.name)',strtolower(trim($sectorName)))->get()->row();
		return $queryMySend;
	}	
	function getAllCompaniesWithMemAndSectorsSelectedWithPreferenceWithPaging($search,$sectors,$deptt,$typeMode=0,$numOfRecords=50){
		$data = array('count_all'=>0,'data'=>array());
		if($numOfRecords>0){
			$this->db->limit($numOfRecords,0);
		}
		if($typeMode==0){		
			if(trim($search)!=""){
				$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_preference.' as p', 'p.customer_id = co.id','left')->where('co.company_name LIKE "%'.$search.'%"')->where('cs.sector_id IN ('.$sectors.')')->where('p.preference_id IN ('.$deptt.')')->order_by('co.company_name','ASC')->get();
			} else {
				$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_preference.' as p', 'p.customer_id = co.id','left')->where('cs.sector_id IN ('.$sectors.')')->where('p.preference_id IN ('.$deptt.')')->order_by('co.company_name','ASC')->get();
			}
		} else {			
			if(trim($search)!=""){
				$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('co.company_name LIKE "%'.$search.'%"')->where('cs.sector_id IN ('.$sectors.')')->where('co.id NOT IN ( SELECT distinct(p.customer_id) FROM '.$this->table_preference.' as p)')->order_by('co.company_name','ASC')->get();
			} else {
				$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sectors.')')->where('co.id NOT IN ( SELECT distinct(p.customer_id) FROM '.$this->table_preference.' as p)')->order_by('co.company_name','ASC')->get();
			}
		}		
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) { 
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->getAllCompanySectors($row->id);
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
				$data['data'][] = $row;
            }            
        }		
		return $data;
	}
	function getAllCompaniesWithMemAndSectorsSelectedWithPreference($sectors,$deptt,$typeMode=0){
		if($typeMode==0){
			$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_preference.' as p', 'p.customer_id = co.id','left')->where('cs.sector_id IN ('.implode(',',$sectors).')')->where('p.preference_id IN ('.$deptt.')')->order_by('co.company_name','ASC')->get();
		} else {
			$query = $this->db->select("distinct(co.id),co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.implode(',',$sectors).')')->where('co.id NOT IN ( SELECT distinct(p.customer_id) FROM '.$this->table_preference.' as p)')->order_by('co.company_name','ASC')->get();
		}
		
		/*echo $this->db->last_query();*/  
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->getAllCompanySectors($row->id);
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
	function getAllCompaniesWithMemAndSectorsSelected($sectors){
		$query = $this->db->select("co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sectors.')')->order_by('co.company_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->getAllCompanySectors($row->id);
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
	function getAllCompaniesWithMemAndSectorsSelectedWithPaging($search,$sectors,$noOfRecords){
		$data = array('count_all'=>0,'data'=>array());
		if($numOfRecords>0){
			$this->db->limit($numOfRecords,0);
		}
		if(trim($search)!=""){
			$query = $this->db->select("co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('co.company_name LIKE "%'.$search.'%"')->where('cs.sector_id IN ('.$sectors.')')->order_by('co.company_name','ASC')->get();
		} else {
			$query = $this->db->select("co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sectors.')')->order_by('co.company_name','ASC')->get();
		}
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->getAllCompanySectors($row->id);
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
				$data['data'][] = $row;
            }            
        }		
		return $data;
	}	
	function getAllCompaniesWithMem($leadID = 0){
		if($leadID==0){
			$query = $this->db->select("co.*,(SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('co.company_name','ASC')->get();
		} else {
			$query = $this->db->select("co.*, (SELECT COUNT(id) FROM ".$this->table_customers." as cus  WHERE cus.company_id = co.id) as userCount")->from($this->table_company.' as co')->join($this->table_invitees.' as i','co.id=i.contact_id')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where("i.lead_id",$leadID)->order_by('co.company_name','ASC')->get();
		}		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$usersList = $this->getAllContactBelongToCompany($row->id);
				$sectors = $this->getAllCompanySectors($row->id);
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

	public function get_list_technologies($type){
		$query = $this->db->select("c.*")->from($this->table_category.' as c')->where('c.type',$type)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result() ;
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
	public function findMyPreferenceWithName($customerID,$type){
		$query = $this->db->select("c.*")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.customer_id",$customerID)->where('c.type',$type)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result() ;
        }
		return $data; 
	}	
	public function findTechnologiesPreferenceWithNameSub($companyID,$type){
		$query = $this->db->select("c.*")->from($this->table_technology_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where("p.company_id",$companyID)->where('c.type',$type)->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result() ;
        }
		return $data; 
	}

	function findAllJobTitles(){
		$query = $this->db->select("distinct(job_title)")->from($this->table)->where('job_title <>','')->where('job_title <>','--')->where('job_title <>','--------------------')->where('job_title <>','.')->where('job_title <>','...')->order_by('job_title','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result() ;
        }
		return $data; 
	}
	
	function getAllContactBelongToCompany($companyID){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name")->from($this->table.' as c')->where('c.company_id',$companyID)->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result() ;   
        }		
		return $data;
	}	
	function getAllContacts(){
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$sectors = $this->getAllCompanySectors($row->companyID);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->companyID,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->companyID,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data[] = $row;
            }            
        }		
		return $data;
	}	
		
	function getAllContactsWithPaging($noOfRecords=50,$show="web"){
		if($noOfRecords>0){
			$this->db->limit($noOfRecords,0);
		}
		/*$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,s.id as sectorID, s.name as sectorName, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('system_update','DESC')->get();*/
		$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','INNER')->order_by('system_update','DESC')->get();
		$data = array();
		$categories = array();
		$subcategories = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				if($show=="web"):
				$sectors = $this->getAllCompanySectors($row->companyID);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->companyID,1);
				$deptNames = "";
				$subdeptNames = "";
				foreach($departments as $deptt){
					if($deptt->parent==0){						
						if(!in_array($deptt->id,$categories)){
							$categories[] = $deptt->id;
							$deptNames .= $deptt->name.", ";
						}						
					} else if(!in_array($deptt->id,$subcategories)){
						$subcategories[] = $deptt->id;
						$subdeptNames .= $deptt->name.", ";
					}					
				}
				$deptNames= substr($deptNames,0,-2);
				$subdeptNames= substr($subdeptNames,0,-2);
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				endif;
				$data[] = $row;
            }            
		}		
		return $data;
	}	
	
	public function get_all_title_by_char($q){
		$querySELECT = "SELECT distinct(c.job_title) as job_title FROM ".$this->table." as c WHERE c.job_title LIKE '".$q."%'";
		$resultTitle = $this->db->query($querySELECT);
		$titleList = array();
		if($resultTitle->num_rows()){
			$titleList = $resultTitle->result();
		}
		return $titleList;
	}
	
	function get_mysqli() { 
		$db = (array)get_instance()->db;
		return mysqli_connect('localhost', $db['username'], $db['password'], $db['database']);
	}
	
	function getAllContactsListBySectorWithoutPaging($searchString="",$sector="",$email="",$phone="",$linkedin="",$filterCompany="",$filterProfileName="",$filterTitle="",$filterProximity="",$filterSelectedCompanies="",$filterCurrentCompany="",$leadID=0,$filterIgnore){
		$data = array('count_all'=>0,'data'=>array());
		$queryJOIN = "LEFT JOIN ".$this->table_company.' as co ON co.id = c.company_id';
		$whereString = array();
		if(!empty($searchString)){
			$searchStringExplode = explode(' ',$searchString);	
			$queryCondition = "";
			if(count($searchStringExplode)==2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo)){
					$queryCondition = '(upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'") ';
				}else {
					$queryCondition = '(c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.secondary_email LIKE "%'.$searchString.'%" OR c.tertiary_email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%") ';
				}
			} else {
				$queryCondition = '(c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.secondary_email LIKE "%'.$searchString.'%" OR c.tertiary_email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%") ';
			}
			
			if($leadID == 0) {
				$queryCondition .= ' OR c.company_id IN (SELECT id FROM '.$this->table_company.'  WHERE company_name LIKE "%'.trim($searchString).'%")  ';
			}
			
			$whereString[] = $queryCondition;
		}
		if(!empty($sector)){
			if($sector=='Unclassify'){
				$whereString[] = ' co.id NOT IN (SELECT temp_c.company_id FROM '.$this->table_company_sector.' as temp_c) ';
			} else {
				$whereString[] = 'co.id IN (SELECT temp_c.company_id FROM '.$this->table_company_sector.' as temp_c WHERE temp_c.sector_id IN ('.$sector.'))';
			}
		}
		if($filterTitle!=""){
			try{
				$jsonDTitle = json_decode($filterTitle);
				if(count($jsonDTitle)>0){
					if(count($jsonDTitle) == 1 && $jsonDTitle[0] == 'none'){
						$whereString[] = "c.job_title = ''";
					} else {
						$titleSearch = array();
						foreach($jsonDTitle as $title){
							if($title != ""){
								//$title = str_replace(array("'", '"'), '', $title); 
								$titleSearch[] = "c.job_title LIKE '%".mysqli_real_escape_string($this->get_mysqli(),trim($title))."%'";
							}
						}
						if(count($titleSearch) > 0){
							$titleSearch = implode(" OR ",$titleSearch);
							$whereString[] = $titleSearch;
						}
					}					
				}					
			}catch(Exception $e){
			}
		}
		if($filterProfileName!=""){
			try{
				$jsonDName= json_decode($filterProfileName);
				if(count($jsonDName)>0){
					/*$name = $this->db->escape($jsonDName[0]);*/
					$name = $jsonDName[0];
					if(is_numeric($name)){
						$whereString[] = "c.id = ".(int)$name;
					} else {
						/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
						$whereString[] = 'CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"';
					}
				}					
			}catch(Exception $e){
			}
		}
		if($phone=="1" || $phone=="2"){
			if($phone=="1"){
				$whereString[] =" c.phone='' OR c.telephone='' ";
			} else if($phone=="2"){
				$whereString[] =" c.phone<>'' OR c.telephone<>'' ";
			}
		}
		if($email=="1" || $email=="2"){
			if($email=="1"){
				$whereString[] =" c.email='' ";
			} else if($email=="2"){
				$whereString[] =" c.email<>'' ";
			}
		}
		if($filterCurrentCompany=="1" || $filterCurrentCompany=="2"){
			if($filterCurrentCompany=="1"){
				$whereString[] =" c.current_company='' ";
			} else if($filterCurrentCompany=="2"){
				$whereString[] =" c.current_company<>'' ";
			}
		}
		if($linkedin=="1" || $linkedin=="2"){
			if($linkedin=="1"){
				$whereString[] =" c.linkedin_url='' ";
			} else if($linkedin=="2"){
				$whereString[] =" c.linkedin_url<>'' ";
			}
		}
		if($filterCompany!=""){
			try{
				$jsonDCompany = json_decode($filterCompany);
				if(count($jsonDCompany)>0){
					if(is_numeric($jsonDCompany[0])){
						$whereString[] =" c.company_id = ".$jsonDCompany[0]." ";
					} else {
						$whereString[] = ' c.company_id IN (SELECT id FROM '.$this->table_company.'  WHERE company_name LIKE "%'.trim($jsonDCompany[0]).'%"';
					}						
				}					
			}catch(Exception $e){
			}
		}
		if($filterSelectedCompanies!=""){
			try{
				$jsonDCompany = json_decode($filterSelectedCompanies);
				if(count($jsonDCompany)>0){
					$whereString[] =" c.company_id IN (".implode(',',$jsonDCompany).") ";						
				}					
			}catch(Exception $e){
			}
		}
		if($filterProximity!=""){
			try{
				$jsonProximity = explode(',',$filterProximity);
				if(count($jsonProximity)>0){
					$whereString[] = ' c.proximity IN ('.$filterProximity.')';
				}					
			}catch(Exception $e){
			}
		}
		if($filterIgnore=="job_title"){
			$querySELECT = "SELECT distinct(job_title) as job_title FROM ".$this->table.' as c';
			if(count($whereString)>0){
				$whereString = implode(' AND ',$whereString);
			} else {
				$whereString = "";
			}
			$buildQuery = $querySELECT." ".$queryJOIN." ";
			if($whereString != ""){
				$buildQuery .=" WHERE ".$whereString;
			}
			$buildQuery .=" ORDER BY job_title ASC";
			$resultCount = $this->db->query($buildQuery);
			if($resultCount->num_rows()>0){
				$data['data'] = $resultCount->result();
			}
		}
		return $data;
	}
	
	function getAllContactsListBySectorWithPagingOptimizing($searchString,$sector,$sortField="c.system_update",$sortBy="DESC",$email="",$phone="",$linkedin="",$filterCompany="",$filterProfileName="",$filterTitle="",$filterProximity="",$filterCategory="",$filterSubType="",$filterTech="",$filterSubTech="",$filterSelectedCompanies="",$filterCurrentCompany="",$sortOther,$leadID=0,$show="web",$subData=true){
		$resultRows = 0;
		$queryJOIN = "LEFT JOIN ".$this->table_company.' as co ON co.id = c.company_id';
		$whereString = array();
		if(!empty($searchString)){
			$searchStringExplode = explode(' ',$searchString);	
			$queryCondition = "";
			if(count($searchStringExplode)>=2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo) && count($searchStringExplode) == 2){
					$queryCondition = '(upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'") ';
				}else {
					$queryCondition = '(c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.secondary_email LIKE "%'.$searchString.'%" OR c.tertiary_email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%" OR concat_ws(" ",first_name,last_name) LIKE "%'.$searchString.'%") ';
				}
			} else {
				$queryCondition = '(c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.secondary_email LIKE "%'.$searchString.'%" OR c.tertiary_email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%" OR concat_ws(" ",first_name,last_name) LIKE "%'.$searchString.'%") ';
			}
			
			if($leadID == 0) {
				$queryCondition .= ' OR c.company_id IN (SELECT id FROM '.$this->table_company.'  WHERE company_name LIKE "%'.trim($searchString).'%")  ';
			}
			
			$whereString[] = $queryCondition;
		}
		if(!empty($sector)){
			if($sector=='Unclassify'){
				$whereString[] = ' co.id NOT IN (SELECT temp_c.company_id FROM '.$this->table_company_sector.' as temp_c) ';
			} else {
				$whereString[] = 'co.id IN (SELECT temp_c.company_id FROM '.$this->table_company_sector.' as temp_c WHERE temp_c.sector_id IN ('.$sector.'))';
			}
		}
		if($filterTitle!=""){
			try{
				$jsonDTitle = json_decode($filterTitle);
				if(count($jsonDTitle)>0){
					if(count($jsonDTitle) == 1 && $jsonDTitle[0] == 'none'){
						$whereString[] = "c.job_title = ''";
					} else {
						$titleSearch = array();
						foreach($jsonDTitle as $title){
							if($title != ""){
								//$title = str_replace(array("'", '"'), '', $title); 
								$titleSearch[] = "c.job_title LIKE '%".mysqli_real_escape_string($this->get_mysqli(),trim($title))."%'";
							}
						}
						if(count($titleSearch) > 0){
							$titleSearch = implode(" OR ",$titleSearch);
							$whereString[] = $titleSearch;
						}
					}					
				}					
			}catch(Exception $e){
			}
		}
		if($filterProfileName!=""){
			try{
				$jsonDName= json_decode($filterProfileName);
				if(count($jsonDName)>0){
					/*$name = $this->db->escape($jsonDName[0]);*/
					$name = $jsonDName[0];
					if(is_numeric($name)){
						$whereString[] = "c.id = ".(int)$name;
					} else {
						/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
						$whereString[] = 'CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"';
					}
				}					
			}catch(Exception $e){
			}
		}
		if($phone=="1" || $phone=="2"){
			if($phone=="1"){
				$whereString[] =" c.phone='' OR c.telephone='' ";
			} else if($phone=="2"){
				$whereString[] =" c.phone<>'' OR c.telephone<>'' ";
			}
		}
		if($email != "" && (int)$email > 0 ){
			if($email=="1"){
				$whereString[] =" c.email='' ";
			} else if($email=="2"){
				$whereString[] =" c.email<>'' ";
			} else if($email == "3"){
				$whereString[] = " c.active_email <> 4 AND new_email = 0 AND ((c.active_email = 1 AND c.email <> '') OR (c.active_email = 2 AND c.secondary_email <> '') OR (c.active_email = 3 AND c.tertiary_email <> '')) ";
			} else if($email == "4"){
				$whereString[] = " c.active_email = 4 OR
				((c.active_email = 2 AND c.secondary_email = '' AND c.email <> '') OR (c.active_email = 3 AND c.tertiary_email = '' AND c.secondary_email <> '') )";
			} else if($email == "5"){
				$whereString[] = " ((c.email <> '' AND new_email = 1 AND c.active_email =1) OR (c.secondary_email <> '' AND new_email = 1 AND c.active_email =2) OR (c.tertiary_email <> '' AND new_email = 1 AND c.active_email =3))";
			}
		}
		if($filterCurrentCompany=="1" || $filterCurrentCompany=="2"){
			if($filterCurrentCompany=="1"){
				$whereString[] =" c.current_company='' ";
			} else if($filterCurrentCompany=="2"){
				$whereString[] =" c.current_company<>'' ";
			}
		}
		if($linkedin=="1" || $linkedin=="2"){
			if($linkedin=="1"){
				$whereString[] =" c.linkedin_url='' ";
			} else if($linkedin=="2"){
				$whereString[] =" c.linkedin_url<>'' ";
			}
		}
		if($filterCompany!=""){
			try{
				$jsonDCompany = json_decode($filterCompany);
				if(count($jsonDCompany)>0){
					if(is_numeric($jsonDCompany[0])){
						$whereString[] =" c.company_id = ".$jsonDCompany[0]." ";
					} else {
						$whereString[] = ' c.company_id IN (SELECT id FROM '.$this->table_company.'  WHERE company_name LIKE "%'.trim($jsonDCompany[0]).'%"';
					}						
				}					
			}catch(Exception $e){
			}
		}
		if($filterSelectedCompanies!=""){
			try{
				$jsonDCompany = json_decode($filterSelectedCompanies);
				if(count($jsonDCompany)>0){
					$whereString[] =" c.company_id IN (".implode(',',$jsonDCompany).") ";						
				}					
			}catch(Exception $e){
			}
		}
		if($filterProximity!=""){
			try{
				$jsonProximity = explode(',',$filterProximity);
				if(count($jsonProximity)>0){
					$whereString[] = ' c.proximity IN ('.$filterProximity.')';
				}					
			}catch(Exception $e){
			}
		}
		if($filterCategory!=''){
			$allCat = explode(',',$filterCategory);
			if( $filterSubType!=""){
				$jsonSubCat = explode(',',$filterSubType);
				$allCat = array_merge($allCat,$jsonSubCat);
			}
			if(count($allCat)>0){
				$queryJOIN .=" INNER JOIN ".$this->table_preference." as p ON p.customer_id = c.company_id ";
				$whereString[] = ' p.preference_id IN ('.implode(',',$allCat).') ';
			}
		}
		if($filterTech!="" ){
			$allTech = explode(',',$filterTech);
			if($filterSubTech!=""){
				$jsonSubTech = explode(',',$filterSubTech);
				$allTech = array_combine($allTech,$jsonSubTech);
			}
			if(count($allTech)>0){
				$queryJOIN .=" INNER JOIN ".$this->table_technology_preference." as t ON t.company_id = c.company_id ";
				$whereString[] = ' t.preference_id IN ('.implode(',',$allTech).') ';
			}			
		} 
		if($leadID>0){
			$queryJOIN .=" LEFT JOIN ".$this->table_backyard_invitees." as b ON b.contact_id = c.company_id ";
			$queryJOIN .=" LEFT JOIN ".$this->table_acquisition_company." as ac ON ac.contact_id = c.company_id ";
			$whereString[] = '( b.lead_id = '.$leadID.' OR ac.lead_id = '.$leadID.' ) ';
		}
		$querySELECT = "SELECT count(distinct(c.id)) as countRecords FROM ".$this->table." as c ";
		$buildQuery = $querySELECT." ".$queryJOIN;
		
		if(count($whereString)>0){
			$whereString = implode(' AND ',$whereString);
		} else {
			$whereString = "";
		}
		
		if($whereString !=""){
			$buildQuery .=" WHERE ".$whereString ;
		}
		$started = microtime(true);
		$queryResultCounter = $this->db->query($buildQuery);
		
		if($queryResultCounter->num_rows()>0){
			$getData = $queryResultCounter->first_row();
			$resultRows = $getData->countRecords;
		}

		/*echo $this->db->last_query()."<br/>";die;*/
		/*$endTime = microtime(true);
		$difference = $endTime - $started;
		$queryTime = number_format($difference, 10);
		echo $this->db->last_query()."<br/>";
		echo "SQL query took $queryTime seconds.";*/
		$querySELECT = "SELECT distinct(c.id) as contactID,c.id as id, c.job_title,c.first_name,c.last_name,c.email,c.current_company,c.secondary_email,c.tertiary_email,c.web_address,c.linkedin_url,c.ackses_url,c.phone,c.telephone,c.company_tel,c.street,c.city,c.state,c.zip,c.country,c.note,c.system_update,c.create_date,c.gateway,c.address,c.img_card,c.linkedin_image,c.no_contact,c.new_email,c.new_phone,c.new_telephone,c.new_company,c.new_linkedin,c.active_email,c.proximity,c.c_c,c.scraped_p,c.email_verifier,CONCAT((c.first_name),(' '),(c.last_name)) as name, c.company_id as companyID,co.company_name as company_name,c.scrape_no FROM ".$this->table." as c ";
		$buildQuery = $querySELECT." ".$queryJOIN;
		if($whereString !=""){
			$buildQuery .=" WHERE ".$whereString ;
		}
		if($sortOther == 2){
			$buildQuery .=" ORDER BY c.c_c DESC,c.scrape_no ASC";	
		} else {
			$buildQuery .=" ORDER BY ".$sortField." ".$sortBy;	
		}
		
		//echo $buildQuery;die;
		$started = microtime(true);
		$query = $this->db->query($buildQuery);
		$started = microtime(true);
		
		$data = array();
		$mapTech = array();
		$mapCategpry = array();		
		$mapSubCategory = array();
		$category = array();
		$subCategory = array();
		$subTechnology = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
		    if($show=="web"){
				$companyIDs = array();
				for($i=0;$i<count($data);$i++){
					array_push($companyIDs,  $data[$i]->companyID);
				}			
				$getCompaniesName = $this->getCompaniesName($companyIDs);
				if(count($getCompaniesName)>0){	
					$i=0;
					foreach($data as $co){
						foreach($getCompaniesName as $s){
							if($co->companyID == $s->id){
								$data[$i]->company_name = $s->company_name;
								break;
							}							
						}
						$i++;
					}
				}

				$sectorsList = $this->findAllCompanySectorsOptimized($companyIDs);
				$sectorsCompanies = array();
				if(count($sectorsList)>0){
					$i=0;
					foreach($data as $co){
						foreach($sectorsList as $s){
							if((int)$co->companyID == (int)$s->company_id){
								array_push($sectorsCompanies, $s->company_id);
								$sectorName = "";
								if(isset($data[$i]->sectorName) && $data[$i]->sectorName!=""){
									$sectorName = $data[$i]->sectorName;
								}
								if($sectorName!=""){
									$sectorName .=", ";
								}
								$sectorName .= $s->sectorName;
								$data[$i]->sectorName = $sectorName;
								break;
							}
						}
						$i++;
					}
				}
				if($subData===true){
				if(count($sectorsCompanies)>0){
					$sectorsCompanies = array_unique($sectorsCompanies);
					/*Get Categories and Sub Categories*/
					$getDepartmentsList = $this->findAllCompanyPreferenceWithNameSub($sectorsCompanies,1);
					if(count($getDepartmentsList)>0){
						foreach($getDepartmentsList as $deptt){
							$i=0;
							foreach($data as $co){
								if($co->companyID == $deptt->customer_id){
									if($deptt->parent==0){
										$department_names = "";
										if(isset($data[$i]->department_names)){
											$department_names = $data[$i]->department_names;
										}
										if($department_names!=""){
											$department_names .=", ";
										}
										$department_names .= $deptt->name;
										$data[$i]->department_names = $department_names;
										if(!in_array($deptt->id,$mapCategpry)){
											array_push($mapCategpry, $deptt->id);
											array_push($category, array('id'=>$deptt->id,'name'=>$deptt->name));
										}
									} else {
										$sub_department_names = "";
										if(isset($data[$i]->sub_department_names)){
											$sub_department_names = $data[$i]->sub_department_names;
										}
										if($sub_department_names!=""){
											$sub_department_names .=", ";
										}
										$sub_department_names .= $deptt->name;
										$data[$i]->sub_department_names = $sub_department_names;
										if(!in_array($deptt->id,$mapSubCategory)){
											array_push($mapSubCategory, $deptt->id);
											array_push($subCategory, array('id'=>$deptt->id,'name'=>$deptt->name));
										}
									}
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
						foreach($data as $co){
							if($co->companyID == $tech->company_id){
								array_push($techCompanyIDs, $tech->company_id);
								$technologyNames = "";
								if(isset($data[$i]->technology_names)){
									$technologyNames = $data[$i]->technology_names;
								}
								if($technologyNames!=""){
									$technologyNames .=", ";
								}
								$technologyNames .= $tech->name;
								$data[$i]->technology_names = $technologyNames;
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
							foreach($data as $co){
								if($co->companyID == $tech->company_id){
									array_push($subTechCompanyIDs, $tech->company_id);
									$technologyNames = "";
									if(isset($data[$i]->sub_technology_names)){
										$technologyNames = $data[$i]->sub_technology_names;
									}
									if($technologyNames!=""){
										$technologyNames .=", ";
									}									
									if(!in_array($tech->id,$mapTech)){
										array_push($mapTech, $tech->id);
										array_push($subTechnology, array('id'=>$tech->id,'name'=>$tech->name));
										$technologyNames .= $tech->name;
										$data[$i]->sub_technology_names = $technologyNames;
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
								foreach($data as $co){
									if($co->companyID == $tech->company_id){
										$technologyNames = "";
										if(isset($data[$i]->sub_technology_names)){
											$technologyNames = $data[$i]->sub_technology_names;
										}
										if($technologyNames!=""){
											$technologyNames .=", ";
										}										
										if(!in_array($tech->id,$mapTech)){
											array_push($mapTech, $tech->id);
											array_push($subTechnology, array('id'=>$tech->id,'name'=>$tech->name));
											$technologyNames .= $tech->name;
											$data[$i]->sub_technology_names = $technologyNames;
										}
									}
									$i++;
								}
							}
						}
					}					
				}
				}
			}
        }
		return array('result'=>$resultRows,'list'=>$data,'categories'=>$category,'sub_type'=>$subCategory,'sub_tech'=>$subTechnology);
	}
	
	function getAllContactsBySectorWithPagingOptimizing($searchString,$sector,$start,$end,$sortField="c.system_update",$sortBy="DESC",$email="",$phone="",$linkedin="",$filterCompany="",$filterProfileName="",$filterTitle="",$filterCategory="",$filterSubType="",$filterTech="",$filterSubTech="",$leadID=0,$show="web",$subData=true){
		
		/*$started = microtime(true);
		$query = $this->db->query("select * from contacts as c order by c.system_update DESC limit 500");
		$end = microtime(true);
		$difference = $end - $started;
		$queryTime = number_format($difference, 10);
		echo "SQL query took $queryTime seconds.";
		 
		die;*/
		$resultRows = 0;
		$queryJOIN = "LEFT JOIN ".$this->table_company.' as co ON co.id = c.company_id';
		$whereString = array();
		if(!empty($searchString)){
			$searchStringExplode = explode(' ',$searchString);	
			$queryCondition = "";
			if(count($searchStringExplode)==2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo)){
					$queryCondition = '(upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'") ';
				}else {
					$queryCondition = '(c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.secondary_email LIKE "%'.$searchString.'%" OR c.tertiary_email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%") ';
				}
			} else {
				$queryCondition = '(c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.secondary_email LIKE "%'.$searchString.'%" OR c.tertiary_email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%") ';
			}
			
			if($leadID == 0) {
				$queryCondition .= ' OR c.company_id IN (SELECT id FROM '.$this->table_company.'  WHERE company_name LIKE "%'.trim($searchString).'%")  ';
			}
			
			$whereString[] = $queryCondition;
		}
		if(!empty($sector)){
			if($sector=='Unclassify'){
				$whereString[] = ' co.id NOT IN (SELECT temp_c.company_id FROM '.$this->table_company_sector.' as temp_c) ';
			} else {
				$whereString[] = 'co.id IN (SELECT temp_c.company_id FROM '.$this->table_company_sector.' as temp_c WHERE temp_c.sector_id IN ('.$sector.'))';
			}
		}
		if($filterTitle!=""){
			try{
				$jsonDTitle = json_decode($filterTitle);
				if(count($jsonDTitle)>0){
					$whereString[] = 'c.job_title LIKE "%'.trim($jsonDTitle[0]).'%"';
				}					
			}catch(Exception $e){
			}
		}
		if($filterProfileName!=""){
			try{
				$jsonDName= json_decode($filterProfileName);
				if(count($jsonDName)>0){
					/*$name = $this->db->escape($jsonDName[0]);*/
					$name = $jsonDName[0];
					if(is_numeric($name)){
						$whereString[] = "c.id = ".(int)$name;
					} else {
						/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
						$whereString[] = 'CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"';
					}
				}					
			}catch(Exception $e){
			}
		}
		if($phone=="1" || $phone=="2"){
			if($phone=="1"){
				$whereString[] =" c.phone='' OR c.telephone='' ";
			} else if($phone=="2"){
				$whereString[] =" c.phone<>'' OR c.telephone<>'' ";
			}
		}
		if($email=="1" || $email=="2"){
			if($email=="1"){
				$whereString[] =" c.email='' ";
			} else if($email=="2"){
				$whereString[] =" c.email<>'' ";
			}
		}		
		if($linkedin=="1" || $linkedin=="2"){
			if($linkedin=="1"){
				$whereString[] =" c.linkedin_url='' ";
			} else if($linkedin=="2"){
				$whereString[] =" c.linkedin_url<>'' ";
			}
		}
		if($filterCompany!=""){
			try{
				$jsonDCompany = json_decode($filterCompany);
				if(count($jsonDCompany)>0){
					if(is_numeric($jsonDCompany[0])){
						$whereString[] =" c.company_id = ".$jsonDCompany[0]." ";
					} else {
						$whereString[] = ' c.company_id IN (SELECT id FROM '.$this->table_company.'  WHERE company_name LIKE "%'.trim($jsonDCompany[0]).'%"';
					}						
				}					
			}catch(Exception $e){
			}
		}
		if($filterCategory!=''){
			$allCat = explode(',',$filterCategory);
			if( $filterSubType!=""){
				$jsonSubCat = explode(',',$filterSubType);
				$allCat = array_merge($allCat,$jsonSubCat);
			}
			if(count($allCat)>0){
				$queryJOIN .=" INNER JOIN ".$this->table_preference." as p ON p.customer_id = c.company_id ";
				$whereString[] = ' p.preference_id IN ('.implode(',',$allCat).') ';
			}
		}
		if($filterTech!="" ){
			$allTech = explode(',',$filterTech);
			if($filterSubTech!=""){
				$jsonSubTech = explode(',',$filterSubTech);
				$allTech = array_combine($allTech,$jsonSubTech);
			}
			if(count($allTech)>0){
				$queryJOIN .=" INNER JOIN ".$this->table_technology_preference." as t ON t.company_id = c.company_id ";
				$whereString[] = ' t.preference_id IN ('.implode(',',$allTech).') ';
			}			
		} 
		if($leadID>0){
			$queryJOIN .=" LEFT JOIN ".$this->table_backyard_invitees." as b ON b.contact_id = c.company_id ";
			$queryJOIN .=" LEFT JOIN ".$this->table_acquisition_company." as ac ON ac.contact_id = c.company_id ";
			$whereString[] = '( b.lead_id = '.$leadID.' OR ac.lead_id = '.$leadID.' ) ';
		}
		$querySELECT = "SELECT count(distinct(c.id)) as countRecords FROM ".$this->table." as c ";
		$buildQuery = $querySELECT." ".$queryJOIN;
		
		if(count($whereString)>0){
			$whereString = implode(' AND ',$whereString);
		} else {
			$whereString = "";
		}
		
		if($whereString !=""){
			$buildQuery .=" WHERE ".$whereString ;
		}
		$started = microtime(true);
		$queryResultCounter = $this->db->query($buildQuery);
		if($queryResultCounter->num_rows()>0){
			$getData = $queryResultCounter->first_row();
			$resultRows = $getData->countRecords;
		}
		/*echo $this->db->last_query()."<br/>";*/
		/*echo $this->db->last_query()."<br/>";*/
		/*$endTime = microtime(true);
		$difference = $endTime - $started;
		$queryTime = number_format($difference, 10);
		echo $this->db->last_query()."<br/>";
		echo "SQL query took $queryTime seconds.";*/
		$querySELECT = "SELECT distinct(c.id) as contactID,c.id as id, c.job_title,c.first_name,c.last_name,c.email,c.current_company,c.secondary_email,c.tertiary_email,c.web_address,c.linkedin_url,c.ackses_url,c.phone,c.telephone,c.company_tel,c.street,c.city,c.state,c.zip,c.country,c.note,c.system_update,c.create_date,c.gateway,c.address,c.img_card,c.linkedin_image,c.no_contact,c.new_email,c.new_phone,c.new_telephone,c.new_company,c.new_linkedin,c.active_email,c.proximity,c.c_c,c.scraped_p,c.email_verifier,CONCAT((c.first_name),(' '),(c.last_name)) as name, c.company_id as companyID,'' as company_name,c.scrape_no FROM ".$this->table." as c ";
		$buildQuery = $querySELECT." ".$queryJOIN;
		if($whereString !=""){
			$buildQuery .=" WHERE ".$whereString ;
		}
		$buildQuery .=" ORDER BY ".$sortField." ".$sortBy;
		$buildQuery .=" LIMIT ".$start.", ".$end;
		$started = microtime(true);
		$query = $this->db->query($buildQuery);
		/*$endTime = microtime(true);
		$difference = $endTime - $started;
		$queryTime = number_format($difference, 10);
		echo $this->db->last_query()."<br/>";
		echo "SQL query took $queryTime seconds.";*/
		$started = microtime(true);
		
		$data = array();
		$mapTech = array();
		$mapCategpry = array();		
		$mapSubCategory = array();
		$category = array();
		$subCategory = array();
		$subTechnology = array();
		if ($query->num_rows() > 0) {
			$data = $query->result();
		    if($show=="web"){
				$companyIDs = array();
				for($i=0;$i<count($data);$i++){
					$companyIDs[] =  $data[$i]->companyID;
				}			
				$getCompaniesName = $this->getCompaniesName($companyIDs);
				if(count($getCompaniesName)>0){	
					$i=0;
					foreach($data as $co){
						foreach($getCompaniesName as $s){
							if($co->companyID == $s->id){
								$data[$i]->company_name = $s->company_name;
								break;
							}							
						}
						$i++;
					}
				}

				$sectorsList = $this->findAllCompanySectorsOptimized($companyIDs);
				$sectorsCompanies = array();
				if(count($sectorsList)>0){
					$i=0;
					foreach($data as $co){
						foreach($sectorsList as $s){
							if((int)$co->companyID == (int)$s->company_id){
								$sectorsCompanies[] = $s->company_id;
								$sectorName = "";
								if(isset($data[$i]->sectorName) && $data[$i]->sectorName!=""){
									$sectorName = $data[$i]->sectorName;
								}
								if($sectorName!=""){
									$sectorName .=", ";
								}
								$sectorName .= $s->sectorName;
								$data[$i]->sectorName = $sectorName;
								break;
							}
						}
						$i++;
					}
				}
				if($subData===true){
				if(count($sectorsCompanies)>0){
					$sectorsCompanies = array_unique($sectorsCompanies);
					/*Get Categories and Sub Categories*/
					$getDepartmentsList = $this->findAllCompanyPreferenceWithNameSub($sectorsCompanies,1);
					if(count($getDepartmentsList)>0){
						foreach($getDepartmentsList as $deptt){
							$i=0;
							foreach($data as $co){
								if($co->companyID == $deptt->customer_id){
									if($deptt->parent==0){
										$department_names = "";
										if(isset($data[$i]->department_names)){
											$department_names = $data[$i]->department_names;
										}
										if($department_names!=""){
											$department_names .=", ";
										}
										$department_names .= $deptt->name;
										$data[$i]->department_names = $department_names;
										if(!in_array($deptt->id,$mapCategpry)){
											$mapCategpry[] = $deptt->id;
											$category[] = array('id'=>$deptt->id,'name'=>$deptt->name);
										}
									} else {
										$sub_department_names = "";
										if(isset($data[$i]->sub_department_names)){
											$sub_department_names = $data[$i]->sub_department_names;
										}
										if($sub_department_names!=""){
											$sub_department_names .=", ";
										}
										$sub_department_names .= $deptt->name;
										$data[$i]->sub_department_names = $sub_department_names;
										if(!in_array($deptt->id,$mapSubCategory)){
											$mapSubCategory[] = $deptt->id;
											$subCategory[] = array('id'=>$deptt->id,'name'=>$deptt->name);
										}
									}
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
						foreach($data as $co){
							if($co->companyID == $tech->company_id){
								$techCompanyIDs[]=$tech->company_id;
								$technologyNames = "";
								if(isset($data[$i]->technology_names)){
									$technologyNames = $data[$i]->technology_names;
								}
								if($technologyNames!=""){
									$technologyNames .=", ";
								}
								$technologyNames .= $tech->name;
								$data[$i]->technology_names = $technologyNames;
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
							foreach($data as $co){
								if($co->companyID == $tech->company_id){
									$subTechCompanyIDs[]=$tech->company_id;
									$technologyNames = "";
									if(isset($data[$i]->sub_technology_names)){
										$technologyNames = $data[$i]->sub_technology_names;
									}
									if($technologyNames!=""){
										$technologyNames .=", ";
									}									
									if(!in_array($tech->id,$mapTech)){
										$mapTech[] = $tech->id;
										$subTechnology[] = array('id'=>$tech->id,'name'=>$tech->name);
										$technologyNames .= $tech->name;
										$data[$i]->sub_technology_names = $technologyNames;
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
								foreach($data as $co){
									if($co->companyID == $tech->company_id){
										$technologyNames = "";
										if(isset($data[$i]->sub_technology_names)){
											$technologyNames = $data[$i]->sub_technology_names;
										}
										if($technologyNames!=""){
											$technologyNames .=", ";
										}										
										if(!in_array($tech->id,$mapTech)){
											$mapTech[] = $tech->id;
											$subTechnology[] = array('id'=>$tech->id,'name'=>$tech->name);
											$technologyNames .= $tech->name;
											$data[$i]->sub_technology_names = $technologyNames;
										}
									}
									$i++;
								}
							}
						}
					}					
				}
				}
			}
        }
		/*$endTime = microtime(true);
		$difference = $endTime - $started;
		$queryTime = number_format($difference, 10);*/
		return array('result'=>$resultRows,'list'=>$data,'categories'=>$category,'sub_type'=>$subCategory,'sub_tech'=>$subTechnology);
	}
	
	public function findAllCompanyPreferenceWithNameSub($companyIDs,$type){
		$query = $this->db->select("c.*,p.customer_id")->from($this->table_preference.' as p')->join($this->table_category.' as c','c.id = p.preference_id')->where_in("p.customer_id",$companyIDs)->where('c.type',$type)->get();
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
	
	public function getCompaniesName($companyIDs){
		$query = $this->db->query("SELECT id,company_name FROM ".$this->table_company." WHERE id IN (".implode(',',$companyIDs).")");
		return $query->result();
	}
	
	public function findAllCompanySectorsOptimized($companyIDs){
		$data = array();
		if(count($companyIDs)>0){
			$query = $this->db->select("s.name as sectorName, s.id as sectorID, cs.company_id")->from($this->table_company_sector.' as cs')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where_in('cs.company_id',$companyIDs)->get();
			$data = $query->result();
		}
		return $data;
	}
	
	function getAllContactsBySectorWithPaging($searchString,$sector,$start,$end,$sortField="c.system_update",$sortBy="DESC",$email="",$phone="",$linkedin="",$filterCompany="",$filterProfileName="",$filterTitle="",$filterCategory="",$filterSubType="",$filterTech="",$filterSubTech="",$leadID=0,$show="web",$sub=true){
		$resultRows = 0;
		if(!empty($searchString) && !empty($sector)){
			$searchStringExplode = explode(' ',$searchString);
			$whereString = "";
			if(count($searchStringExplode)==2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo)){
					$whereString = '(upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'")';
				}else {
					$whereString = '(c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.secondary_email LIKE "%'.$searchString.'%" OR c.tertiary_email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%")';
				}
			}else {
				$whereString = '(c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.secondary_email LIKE "%'.$searchString.'%" OR c.tertiary_email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%")';
			}
			if($filterTitle!=""){
				try{
					$jsonDTitle = json_decode($filterTitle);
					if(count($jsonDTitle)>0){
						$this->db->like('c.job_title',trim($jsonDTitle[0]));
					}					
				}catch(Exception $e){
				}
			}
			if($filterProfileName!=""){
				try{
					$jsonDName= json_decode($filterProfileName);
					if(count($jsonDName)>0){
						/*$name = $this->db->escape($jsonDName[0]);*/
						$name = $jsonDName[0];
						if(is_numeric($name)){
							$this->db->where("c.id",(int)$name);
						} else {
							/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
							$this->db->like('CONCAT(c.first_name, " ", c.last_name)',trim($name),null);
						}
					}					
				}catch(Exception $e){
				}
			}
			if($email=="1" || $email=="2"){
				$whereString .=" AND (";
				if($email=="1"){
					$whereString .=" c.email=''";
				} else if($email=="2"){
					$whereString .=" c.email<>''";
				}
				$whereString .=" )";
			}
			if($phone=="1" || $phone=="2"){
				$whereString .=" AND (";
				if($phone=="1"){
					$whereString .=" c.phone='' OR c.telephone=''";
				} else if($phone=="2"){
					$whereString .=" c.phone<>'' OR c.telephone<>''";
				}
				$whereString .=" )";
			}
			if($linkedin=="1" || $linkedin=="2"){
				$whereString .=" AND (";
				if($linkedin=="1"){
					$whereString .=" c.linkedin_url=''";
				} else if($linkedin=="2"){
					$whereString .=" c.linkedin_url<>''";
				}
				$whereString .=" )";
			}
			if($filterCompany!=""){
				try{
					$jsonDCompany = json_decode($filterCompany);
					if(count($jsonDCompany)>0){
						if(is_numeric($jsonDCompany[0])){
							$this->db->where_in('co.id',$jsonDCompany);
						} else {
							$this->db->like('co.company_name',trim($jsonDCompany[0]));
						}						
					}					
				}catch(Exception $e){
				}
			}
			if($filterCategory!='' && $filterSubType!=""){
				try{
					$jsonCat = explode(',',$filterCategory);
					$jsonSubCat = explode(',',$filterSubType);
					$allCat = array_merge($jsonCat,$jsonSubCat);
					if(count($allCat)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.company_id');
						$this->db->where_in('p.preference_id',$allCat);
					}					
				}catch(Exception $e){
				}
			}else if($filterCategory!=""){
				try{
					$jsonSubType = explode(',',$filterCategory);
					if(count($jsonSubType)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.company_id');
						$this->db->where_in('p.preference_id',$jsonSubType);
					}					
				}catch(Exception $e){
				}
			}
			if($filterTech!="" && $filterSubTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					$jsonSubTech = explode(',',$filterSubTech);
					$allTech = array_combine($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($filterTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$jsonTech);
					}					
				}catch(Exception $e){
				}
			}
			if($leadID>0){
				$this->db->join($this->table_backyard_invitees.' as b', 'b.contact_id = c.company_id');
				$this->db->where("b.lead_id",$leadID);
			}
			if($sector=='Unclassify'){
				$this->db->where('co.id NOT IN (SELECT temp_c.company_id FROM '.$this->table_company_sector.' as temp_c)');	
			} else {
				$this->db->where('cs.sector_id IN ('.$sector.')');	
			}
			$resultRows = $this->db->select("count(distinct(c.id)) as countRecords")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','LEFT')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->where($whereString)->get()->row()->countRecords;
			
			if($end>0){
				$this->db->limit($end,$start);
			}
			if($filterTitle!=""){
				try{
					$jsonDTitle = json_decode($filterTitle);
					if(count($jsonDTitle)>0){
						$this->db->like('c.job_title',trim($jsonDTitle[0]));
					}					
				}catch(Exception $e){
				}
			}
			if($filterProfileName!=""){
				try{
					$jsonDName= json_decode($filterProfileName);
					if(count($jsonDName)>0){
						/*$name = $this->db->escape($jsonDName[0]);*/
						$name = $jsonDName[0];
						if(is_numeric($name)){
							$this->db->where("c.id",(int)$name);
						} else {
							/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
							$this->db->like('CONCAT(c.first_name, " ", c.last_name)',trim($name),null);
						}
					}					
				}catch(Exception $e){
				}
			}
			if($filterCompany!=""){
				try{
					$jsonDCompany = json_decode($filterCompany);
					if(count($jsonDCompany)>0){
						if(is_numeric($jsonDCompany[0])){
							$this->db->where_in('co.id',$jsonDCompany);
						} else {
							$this->db->like('co.company_name',trim($jsonDCompany[0]));
						}						
					}					
				}catch(Exception $e){
				}
			}
			if($filterCategory!='' && $filterSubType!=""){
				try{
					$jsonCat = explode(',',$filterCategory);
					$jsonSubCat = explode(',',$filterSubType);
					$allCat = array_merge($jsonCat,$jsonSubCat);
					if(count($allCat)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.company_id');
						$this->db->where_in('p.preference_id',$allCat);
					}					
				}catch(Exception $e){
				}
			}else if($filterCategory!=""){
				try{
					$jsonSubType = explode(',',$filterCategory);
					if(count($jsonSubType)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.company_id');
						$this->db->where_in('p.preference_id',$jsonSubType);
					}					
				}catch(Exception $e){
				}
			}
			if($filterTech!="" && $filterSubTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					$jsonSubTech = explode(',',$filterSubTech);
					$allTech = array_combine($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($filterTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$jsonTech);
					}					
				}catch(Exception $e){
				}
			}
			if($leadID>0){
				$this->db->join($this->table_backyard_invitees.' as b', 'b.contact_id = c.company_id');
				$this->db->where("b.lead_id",$leadID);
			}
			if($sector=='Unclassify'){
				$this->db->where('co.id NOT IN (SELECT temp_c.company_id FROM '.$this->table_company_sector.' as temp_c)');	
			} else {
				$this->db->where('cs.sector_id IN ('.$sector.')');	
			}
			$query = $this->db->select("distinct(c.id) as contactID,c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','LEFT')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->where($whereString)->order_by($sortField,$sortBy)->get();
			/*echo $this->db->last_query();*/
		} else if(empty($searchString) && !empty($sector)){
			if($email=="1" || $email=="2"){
				if($email=="1"){
					$this->db->where('c.email','');
				} else if($email=="2"){
					$this->db->where('c.email <> ','');
				}
			}
			
			if($linkedin=="1" || $linkedin=="2"){
				if($linkedin=="1"){
					$this->db->where('c.linkedin_url','');
				} else if($linkedin=="2"){
					$this->db->where('c.linkedin_url <> ','');
				}
			}

			if($phone=="1" || $phone=="2"){
				if($phone=="1"){
					$this->db->where("(c.phone='' OR c.telephone='')",null,false);
				} else if($phone=="2"){
					$this->db->where("(c.phone<>'' OR c.telephone<>'')",null,false);
				}
			}	
			if($filterTitle!=""){
				try{
					$jsonDTitle = json_decode($filterTitle);
					if(count($jsonDTitle)>0){
						$this->db->like('c.job_title',trim($jsonDTitle[0]));
					}					
				}catch(Exception $e){
				}
			}
			if($filterProfileName!=""){
				try{
					$jsonDName= json_decode($filterProfileName);
					if(count($jsonDName)>0){
						/*$name = $this->db->escape($jsonDName[0]);*/
						$name = $jsonDName[0];
						if(is_numeric($name)){
							$this->db->where("c.id",(int)$name);
						} else {
							/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
							$this->db->like('CONCAT(c.first_name, " ", c.last_name)',trim($name),null);
						}
					}					
				}catch(Exception $e){
				}
			}
			if($filterCompany!=""){
				try{
					$jsonDCompany = json_decode($filterCompany);
					if(count($jsonDCompany)>0){
						if(is_numeric($jsonDCompany[0])){
							$this->db->where_in('co.id',$jsonDCompany);
						} else {
							$this->db->like('co.company_name',trim($jsonDCompany[0]));
						}						
					}					
				}catch(Exception $e){
				}
			}
			if($filterCategory!='' && $filterSubType!=""){
				try{
					$jsonCat = explode(',',$filterCategory);
					$jsonSubCat = explode(',',$filterSubType);
					$allCat = array_merge($jsonCat,$jsonSubCat);
					if(count($allCat)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.company_id');
						$this->db->where_in('p.preference_id',$allCat);
					}					
				}catch(Exception $e){
				}
			}else if($filterCategory!=""){
				try{
					$jsonSubType = explode(',',$filterCategory);
					if(count($jsonSubType)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.company_id');
						$this->db->where_in('p.preference_id',$jsonSubType);
					}					
				}catch(Exception $e){
				}
			}
			if($filterTech!="" && $filterSubTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					$jsonSubTech = explode(',',$filterSubTech);
					$allTech = array_combine($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($filterTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$jsonTech);
					}					
				}catch(Exception $e){
				}
			}
			if($leadID>0){
				$this->db->join($this->table_backyard_invitees.' as b', 'b.contact_id = c.company_id');
				$this->db->where("b.lead_id",$leadID);
			}
			if($sector=='Unclassify'){
				$this->db->where('co.id NOT IN (SELECT temp_c.company_id FROM '.$this->table_company_sector.' as temp_c)');	
			} else {
				$this->db->where('cs.sector_id IN ('.$sector.')');	
			}
			$resultRows = $this->db->select("count(distinct(c.id)) as countRecords")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','LEFT')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->get()->row()->countRecords;
			/*echo $this->db->last_query();*/
			if($end>0){
				$this->db->limit($end,$start);
			}
			if($email=="1" || $email=="2"){
				if($email=="1"){
					$this->db->where('c.email','');
				} else if($email=="2"){
					$this->db->where('c.email <> ','');
				}
			}
			
			if($linkedin=="1" || $linkedin=="2"){
				if($linkedin=="1"){
					$this->db->where('c.linkedin_url','');
				} else if($linkedin=="2"){
					$this->db->where('c.linkedin_url <> ','');
				}
			}
			
			if($phone=="1" || $phone=="2"){
				if($phone=="1"){
					$this->db->where("(c.phone='' OR c.telephone='')",null,false);
				} else if($phone=="2"){
					$this->db->where("(c.phone<>'' OR c.telephone<>'')",null,false);
				}
			}
			if($filterTitle!=""){
				try{
					$jsonDTitle = json_decode($filterTitle);
					if(count($jsonDTitle)>0){
						$this->db->like('c.job_title',trim($jsonDTitle[0]));
					}					
				}catch(Exception $e){
				}
			}
			if($filterProfileName!=""){
				try{
					$jsonDName= json_decode($filterProfileName);
					if(count($jsonDName)>0){
						/*$name = $this->db->escape($jsonDName[0]);*/
						$name = $jsonDName[0];
						if(is_numeric($name)){
							$this->db->where("c.id",(int)$name);
						} else {
							/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
							$this->db->like('CONCAT(c.first_name, " ", c.last_name)',trim($name),null);
						}
					}					
				}catch(Exception $e){
				}
			}
			if($filterCompany!=""){
				try{
					$jsonDCompany = json_decode($filterCompany);
					if(count($jsonDCompany)>0){
						if(is_numeric($jsonDCompany[0])){
							$this->db->where_in('co.id',$jsonDCompany);
						} else {
							$this->db->like('co.company_name',trim($jsonDCompany[0]));
						}						
					}					
				}catch(Exception $e){
				}
			}
			if($filterCategory!='' && $filterSubType!=""){
				try{
					$jsonCat = explode(',',$filterCategory);
					$jsonSubCat = explode(',',$filterSubType);
					$allCat = array_merge($jsonCat,$jsonSubCat);
					if(count($allCat)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.company_id');
						$this->db->where_in('p.preference_id',$allCat);
					}					
				}catch(Exception $e){
				}
			}else if($filterCategory!=""){
				try{
					$jsonSubType = explode(',',$filterCategory);
					if(count($jsonSubType)>0){
						$this->db->join($this->table_preference.' as p', 'p.customer_id = c.company_id');
						$this->db->where_in('p.preference_id',$jsonSubType);
					}					
				}catch(Exception $e){
				}
			}
			if($filterTech!="" && $filterSubTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					$jsonSubTech = explode(',',$filterSubTech);
					$allTech = array_combine($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($filterTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$jsonTech);
					}					
				}catch(Exception $e){
				}
			}
			if($leadID>0){
				$this->db->join($this->table_backyard_invitees.' as b', 'b.contact_id = c.company_id');
				$this->db->where("b.lead_id",$leadID);
			}
			if($sector=='Unclassify'){
				$this->db->where('co.id NOT IN (SELECT temp_c.company_id FROM '.$this->table_company_sector.' as temp_c)');	
			} else {
				$this->db->where('cs.sector_id IN ('.$sector.')');	
			}
			$query = $this->db->select("distinct(c.id) as contactID,c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','LEFT')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->order_by($sortField,$sortBy)->get();
			/*echo $this->db->last_query();*/
		} else if(!empty($searchString) && empty($sector)){
			$searchStringExplode = explode(' ',$searchString);
			$whereString = "";
			if(count($searchStringExplode)==2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo)){
					$whereString = '(upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'")';
				} else {
					$whereString = '(c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.secondary_email LIKE "%'.$searchString.'%" OR c.tertiary_email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%")';
				}
			} else {
				$whereString = '(c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.secondary_email LIKE "%'.$searchString.'%" OR c.tertiary_email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%")';
			}
			if($email=="1" || $email=="2"){
				$whereString .=" AND (";
				if($email=="1"){
					$whereString .=" c.email=''";
				} else if($email=="2"){
					$whereString .=" c.email<>''";
				}
				$whereString .=" )";
			}
			if($phone=="1" || $phone=="2"){
				$whereString .=" AND (";
				if($phone=="1"){
					$whereString .=" c.phone='' OR c.telephone=''";
				} else if($phone=="2"){
					$whereString .=" c.phone<>'' OR c.telephone<>''";
				}
				$whereString .=" )";
			}
			if($linkedin=="1" || $linkedin=="2"){
				$whereString .=" AND (";
				if($linkedin=="1"){
					$whereString .=" c.linkedin_url=''";
				} else if($linkedin=="2"){
					$whereString .=" c.linkedin_url<>''";
				}
				$whereString .=" )";
			}
			if($filterTitle!=""){
				try{
					$jsonDTitle = json_decode($filterTitle);
					if(count($jsonDTitle)>0){
						$this->db->like('c.job_title',trim($jsonDTitle[0]));
					}					
				}catch(Exception $e){
				}
			}
			if($filterProfileName!=""){
				try{
					$jsonDName= json_decode($filterProfileName);
					if(count($jsonDName)>0){
						/*$name = $this->db->escape($jsonDName[0]);*/
						$name = $jsonDName[0];
						if(is_numeric($name)){
							$this->db->where("c.id",(int)$name);
						} else {
							/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
							$this->db->like('CONCAT(c.first_name, " ", c.last_name)',trim($name),null);
						}
					}					
				}catch(Exception $e){
				}
			}
			if($filterCompany!=""){
				try{
					$jsonDCompany = json_decode($filterCompany);
					if(count($jsonDCompany)>0){
						if(is_numeric($jsonDCompany[0])){
							$this->db->where_in('co.id',$jsonDCompany);
						} else {
							$this->db->like('co.company_name',trim($jsonDCompany[0]));
						}						
					}					
				}catch(Exception $e){
				}
			}
			if($leadID>0){
				$this->db->join($this->table_backyard_invitees.' as b', 'b.contact_id = c.company_id');
				$this->db->where("b.lead_id",$leadID);
			}
			$resultRows = $this->db->select("count(distinct(c.id)) as countRecords")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','LEFT')->where($whereString)->get()->row()->countRecords;			
			
			if($end>0){
				$this->db->limit($end,$start);
			}
			if($filterTitle!=""){
				try{
					$jsonDTitle = json_decode($filterTitle);
					if(count($jsonDTitle)>0){
						$this->db->like('c.job_title',trim($jsonDTitle[0]));
					}					
				}catch(Exception $e){
				}
			}
			if($filterProfileName!=""){
				try{
					$jsonDName= json_decode($filterProfileName);
					if(count($jsonDName)>0){
						/*$name = $this->db->escape($jsonDName[0]);*/
						$name = $jsonDName[0];
						if(is_numeric($name)){
							$this->db->where("c.id",(int)$name);
						} else {
							/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
							$this->db->like('CONCAT(c.first_name, " ", c.last_name)',trim($name),null);
						}
					}					
				}catch(Exception $e){
				}
			}
			if($filterCompany!=""){
				try{
					$jsonDCompany = json_decode($filterCompany);
					if(count($jsonDCompany)>0){
						if(is_numeric($jsonDCompany[0])){
							$this->db->where_in('co.id',$jsonDCompany);
						} else {
							$this->db->like('co.company_name',trim($jsonDCompany[0]));
						}						
					}					
				}catch(Exception $e){
				}
			}
			if($leadID>0){
				$this->db->join($this->table_backyard_invitees.' as b', 'b.contact_id = c.company_id');
				$this->db->where("b.lead_id",$leadID);
			}
			$query = $this->db->select("distinct(c.id) as contactID,c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','LEFT')->where($whereString)->order_by($sortField,$sortBy)->get();
			/*echo $this->db->last_query();*/
		} else {			
			if($email=="1" || $email=="2"){
				if($email=="1"){
					$this->db->where('c.email','');
				} else if($email=="2"){
					$this->db->where('c.email <> ','');
				}
			}
			
			if($linkedin=="1" || $linkedin=="2"){
				if($linkedin=="1"){
					$this->db->where('c.linkedin_url','');
				} else if($linkedin=="2"){
					$this->db->where('c.linkedin_url <> ','');
				}
			}
			
			if($phone=="1" || $phone=="2"){
				if($phone=="1"){
					$this->db->where("(c.phone='' OR c.telephone='')",null,false);
				} else if($phone=="2"){
					$this->db->where("(c.phone<>'' OR c.telephone<>'')",null,false);
				}
			}
			if($filterTitle!=""){
				try{
					$jsonDTitle = json_decode($filterTitle);
					if(count($jsonDTitle)>0){
						$this->db->like('c.job_title',trim($jsonDTitle[0]));
					}					
				}catch(Exception $e){
				}
			}
			if($filterProfileName!=""){
				try{
					$jsonDName= json_decode($filterProfileName);
					if(count($jsonDName)>0){
						/*$name = $this->db->escape($jsonDName[0]);*/
						$name = $jsonDName[0];
						if(is_numeric($name)){
							$this->db->where("c.id",(int)$name);
						} else {
							/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
							$this->db->like('CONCAT(c.first_name, " ", c.last_name)',trim($name),null);
						}
					}					
				}catch(Exception $e){
				}
			}
			if($filterCompany!=""){
				try{
					$jsonDCompany = json_decode($filterCompany);
					if(count($jsonDCompany)>0){
						if(is_numeric($jsonDCompany[0])){
							$this->db->where_in('co.id',$jsonDCompany);
						} else {
							$this->db->like('co.company_name',trim($jsonDCompany[0]));
						}						
					}					
				}catch(Exception $e){
				}
			}
			if($leadID>0){
				$this->db->join($this->table_backyard_invitees.' as b', 'b.contact_id = c.company_id');
				$this->db->where("b.lead_id",$leadID);
			}
			if($filterTech!="" && $filterSubTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					$jsonSubTech = explode(',',$filterSubTech);
					$allTech = array_combine($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($filterTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$jsonTech);
					}					
				}catch(Exception $e){
				}
			}
			$resultRows = $this->db->select("count(distinct(c.id)) as countRecords")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','LEFT')->get()->row()->countRecords;
			
			if($end>0){
				$this->db->limit($end,$start);
			}
			if($filterTitle!=""){
				try{
					$jsonDTitle = json_decode($filterTitle);
					if(count($jsonDTitle)>0){
						$this->db->like('c.job_title',trim($jsonDTitle[0]));
					}					
				}catch(Exception $e){
				}
			}
			if($filterProfileName!=""){
				try{
					$jsonDName= json_decode($filterProfileName);
					if(count($jsonDName)>0){
						/*$name = $this->db->escape($jsonDName[0]);*/
						$name = $jsonDName[0];
						if(is_numeric($name)){
							$this->db->where("c.id",(int)$name);
						} else {
							/*$this->db->where('CONCAT(c.first_name, " ", c.last_name) LIKE "%'.trim($name).'%"');*/
							$this->db->like('CONCAT(c.first_name, " ", c.last_name)',trim($name),null);
						}
					}					
				}catch(Exception $e){
				}
			}
			if($email=="1" || $email=="2"){
				if($email=="1"){
					$this->db->where('c.email','');
				} else if($email=="2"){
					$this->db->where('c.email <> ','');
				}
			}			
			if($linkedin=="1" || $linkedin=="2"){
				if($linkedin=="1"){
					$this->db->where('c.linkedin_url','');
				} else if($linkedin=="2"){
					$this->db->where('c.linkedin_url <> ','');
				}
			}
			if($phone=="1" || $phone=="2"){
				if($phone=="1"){
					$this->db->where("(c.phone='' OR c.telephone='')",null,false);
				} else if($phone=="2"){
					$this->db->where("(c.phone<>'' OR c.telephone<>'')",null,false);
				}
			}
			if($filterCompany!=""){
				try{
					$jsonDCompany = json_decode($filterCompany);
					if(count($jsonDCompany)>0){
						if(is_numeric($jsonDCompany[0])){
							$this->db->where_in('co.id',$jsonDCompany);
						} else {
							$this->db->like('co.company_name',trim($jsonDCompany[0]));
						}						
					}					
				}catch(Exception $e){
				}
			}
			if($filterTech!="" && $filterSubTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					$jsonSubTech = explode(',',$filterSubTech);
					$allTech = array_combine($jsonTech,$jsonSubTech);
					if(count($allTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$allTech);
					}					
				}catch(Exception $e){
				}
			} else if($filterTech!=""){
				try{
					$jsonTech = explode(',',$filterTech);
					if(count($jsonTech)>0){
						$this->db->join($this->table_technology_preference.' as t', 't.company_id = c.company_id');
						$this->db->where_in('t.preference_id',$jsonTech);
					}					
				}catch(Exception $e){
				}
			}
			if($leadID>0){
				$this->db->join($this->table_backyard_invitees.' as b', 'b.contact_id = c.company_id');
				$this->db->where("b.lead_id",$leadID);
			}
			$query = $this->db->select("distinct(c.id) as contactID,c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','LEFT')->order_by($sortField,$sortBy)->get();
			/*echo $this->db->last_query();*/
		}
		/*echo $this->db->last_query();*/
		/*die;*/
		$data = array();
		$allSectors = array();
		$mapSectors = array();
		$dataSectors = array();
		$categories = array();
		$techN = array();
		$dataTechnologies = array();
		$subtechnologies = array();
		$subdataTechnologies = array();
		if ($query->num_rows() > 0) {
		    if($show=="web"){
				echo "ssss";
				foreach ($query->result() as $row) {
					$sectors = $this->getAllCompanySectors($row->companyID);
					$sectorsName = "";
					if(count($sectors)>0){
						foreach($sectors as $deptt){
							if(!in_array($deptt->sectorID,$allSectors)){
								$allSectors[] = $deptt->sectorID;
							}						
							$sectorsName .= $deptt->sectorName.", ";
						}
						$sectorsName= substr($sectorsName,0,-2);
					}
					$row->sectorName = $sectorsName;				
					/*$departments = $this->findMyPreferenceWithNameSub($row->companyID,0);
					$deptNames = "";
					if(count($departments)>0){
						foreach($departments as $deptt){
							if(!in_array($deptt->id,$mapSectors)){
								$mapSectors[] = $deptt->id;
								$categories[] = array('id'=>$deptt->id,'name'=>$deptt->name);
							}
							$deptNames .= $deptt->name.", ";
						}
						$deptNames= substr($deptNames,0,-1);
					}
					$subdepartments = $this->findMyPreferenceWithNameSub($row->companyID,1);
					$subdeptNames = "";
					if(count($subdepartments)>0){
						foreach($subdepartments as $deptt){
							if(!in_array($deptt->id,$mapSectors)){
								$mapSectors[] = $deptt->id;
								$dataSectors[] = array('id'=>$deptt->id,'name'=>$deptt->name);
							}
							$subdeptNames .= $deptt->name.", ";
						}
						$subdeptNames= substr($subdeptNames,0,-1);
					}
					*/
					if($sub===true){
						$departments = $this->findMyPreferenceWithNameSub($row->companyID,1);
						$deptNames = "";
						$subdeptNames = "";
						foreach($departments as $deptt){
							if($deptt->parent==0){
								$deptNames .= $deptt->name.", ";
								if(!in_array($deptt->id,$mapSectors)){
									$mapSectors[] = $deptt->id;
									$categories[] = array('id'=>$deptt->id,'name'=>$deptt->name);
								}						
							} else {
								$subdeptNames .= $deptt->name.", ";						
								if(!in_array($deptt->id,$mapSectors)){
									$mapSectors[] = $deptt->id;
									$dataSectors[] = array('id'=>$deptt->id,'name'=>$deptt->name);
								}
							}					
						}
						$deptNames= substr($deptNames,0,-2);
						$subdeptNames= substr($subdeptNames,0,-2);
										
						$technologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,0);
						$technologyNames = "";
						if(count($technologies)>0){
							foreach($technologies as $tech){
								if(!in_array($tech->id,$techN)){
									$techN[] = $tech->id;
									$dataTechnologies[] = array('id'=>$tech->id,'name'=>$tech->name);
								}
								$technologyNames .= $tech->name.", ";
							}
							$technologyNames= substr($technologyNames,0,-2);
						}
						$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,1);
						$subTechnologyNames = "";
						if(count($subTechnologies)>0){
							foreach($subTechnologies as $tech){
								if(!in_array($tech->id,$subtechnologies)){
									$subtechnologies[] = $tech->id;
									$subdataTechnologies[] = array('id'=>$tech->id,'name'=>$tech->name);
								}
								$subTechnologyNames .= $tech->name.", ";
							}
						}
						$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,2);				
						if(count($subsubTechnologies)>0){
							foreach($subsubTechnologies as $tech){
								if(!in_array($tech->id,$subtechnologies)){
									$subtechnologies[] = $tech->id;
									$subdataTechnologies[] = array('id'=>$tech->id,'name'=>$tech->name);
								}
								$subTechnologyNames .= $tech->name.", ";
							}
						}
						$subTechnologyNames= substr($subTechnologyNames,0,-2);
						$row->technology_names = $technologyNames;
						$row->sub_technology_names = $subTechnologyNames;
						$row->department_names = $deptNames;
						$row->sub_department_names = $subdeptNames;
					}
					
					$data[] = $row;
				}
		   	} else {
			   $data = $query->result();
		  	}
        }		
		return array('result'=>$resultRows,'list'=>$data,'categories'=>$categories,'sub_type'=>$dataSectors,'type'=>$allSectors,'tech'=>$dataTechnologies,'sub_tech'=>$subdataTechnologies);
	}	
	
	function getAllContactsBySectorDepttWithPaging($searchString,$sector,$dept,$noOfRecords){
		if($noOfRecords>0){
			$this->db->limit($noOfRecords,0);
		}
		if(!empty($searchString) && !empty($dept)){
			$searchStringExplode = explode(' ',$searchString);
			$whereString = "";
			if(count($searchStringExplode)==2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo)){
					$whereString = 'upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'"';
				}else {
					$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
				}
			}else {
				$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
			}
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_preference.' as p', 'p.customer_id = co.id','left')->where('cs.sector_id IN ('.$sector.')')->where('p.preference_id IN ('.$dept.')')->where($whereString)->order_by('system_update','DESC')->get();
		} else if(empty($searchString) && !empty($dept)){
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->join($this->table_preference.' as p', 'p.customer_id = co.id','left')->where('cs.sector_id IN ('.$sector.')')->where('p.preference_id IN ('.$dept.')')->order_by('system_update','DESC')->get();
		} else if(!empty($searchString) && empty($dept)){
			$searchStringExplode = explode(' ',$searchString);
			$whereString = "";
			if(count($searchStringExplode)==2){
				$stringOne = trim($searchStringExplode[0]);
				$stringTwo = trim($searchStringExplode[1]);
				if(!empty($stringOne) && !empty($stringTwo)){
					$whereString = 'upper(c.first_name)="'.strtoupper($stringOne).'" AND upper(c.last_name)="'.strtoupper($stringTwo).'"';
				}else {
					$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
				}
			}else {
				$whereString = 'c.first_name LIKE "%'.$searchString.'%" OR c.last_name LIKE "%'.$searchString.'%" OR co.company_name LIKE "%'.$searchString.'%" OR c.job_title LIKE "%'.$searchString.'%" OR c.email LIKE "%'.$searchString.'%" OR c.telephone LIKE "%'.$searchString.'%" OR c.phone LIKE "%'.$searchString.'%"';
			}
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sector.')')->where($whereString)->order_by('system_update','DESC')->get();
		} else {
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.sector_id IN ('.$sector.')')->order_by('system_update','DESC')->get();
		}
		
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$sectors = $this->getAllCompanySectors($row->companyID);
				$sectorsName = "";
				if(count($sectors)>0){
					foreach($sectors as $deptt){
						$sectorsName .= $deptt->sectorName.", ";
					}
					$sectorsName= substr($sectorsName,0,-2);
				}
				$row->sectorName = $sectorsName;
				$departments = $this->findMyPreferenceWithNameSub($row->companyID,0);
				$deptNames = "";
				if(count($departments)>0){
					foreach($departments as $deptt){
						$deptNames .= $deptt->name.", ";
					}
					$deptNames= substr($deptNames,0,-1);
				}
				$subdepartments = $this->findMyPreferenceWithNameSub($row->companyID,1);
				$subdeptNames = "";
				if(count($subdepartments)>0){
					foreach($subdepartments as $deptt){
						$subdeptNames .= $deptt->name.", ";
					}
					$subdeptNames= substr($subdeptNames,0,-1);
				}
				$technologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,0);
				$technologyNames = "";
				if(count($technologies)>0){
					foreach($technologies as $tech){
						$technologyNames .= $tech->name.", ";
					}
					$technologyNames= substr($technologyNames,0,-2);
				}
				$subTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,1);
				$subTechnologyNames = "";
				if(count($subTechnologies)>0){
					foreach($subTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$subsubTechnologies = $this->findTechnologiesPreferenceWithNameSub($row->companyID,2);				
				if(count($subsubTechnologies)>0){
					foreach($subsubTechnologies as $tech){
						$subTechnologyNames .= $tech->name.", ";
					}
					$subTechnologyNames= substr($subTechnologyNames,0,-2);
				}
				$row->technology_names = $technologyNames;
				$row->sub_technology_names = $subTechnologyNames;
				$row->department_names = $deptNames;
				$row->sub_department_names = $subdeptNames;
				$data[] = $row;
            }            
        }		
		return $data;
	}	
	function getAllCompanySectors($companyID){
		$data = array();
		if($companyID>0){
			$query = $this->db->select("s.name as sectorName, s.id as sectorID")->from($this->table_company_sector.' as cs')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('cs.company_id',$companyID)->get();
			$data = $query->result();
		}
		return $data;
	}	
	function getHoleContacts($contacts=array()){
		if(count($contacts)>0){
			/*$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,s.id as sectorID, s.name as sectorName, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('c.id IN ('.implode(',',$contacts).') AND (c.email="" OR c.linkedin_url="" OR c.phone="" OR c.telephone="")')->get();*/
			
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,s.id as sectorID, s.name as sectorName, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('c.id IN ('.implode(',',$contacts).')')->get();
		} else {
			$query = $this->db->select("c.*,CONCAT((c.first_name),(' '),(c.last_name)) as name, co.company_name as company_name,s.id as sectorID, s.name as sectorName, co.id as companyID")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id','left')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->where('c.email',"")->or_where('c.linkedin_url',"")->or_where('c.phone',"")->or_where('c.telephone',"")->get();
		}		
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result() ;         
        }		
		return $data;
	}	
	function getAllAutoCompleteContacts(){
		$query = $this->db->select("c.id,CONCAT((c.first_name),(' '),(c.last_name),('- '),(co.company_name)) as label, c.email as `value`, c.secondary_email as secondary, c.tertiary_email as tertiary")->from($this->table.' as c')->join($this->table_company.' as co', 'co.id = c.company_id')->join($this->table_company_sector.' as cs', 'co.id = cs.company_id','left')->join($this->table_sector.' as s', 's.id = cs.sector_id','left')->order_by('c.first_name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
			$data = $query->result() ;       
        }		
		return $data;
	}	
	function getAllContactsWithSectors(){
		$query = $this->db->select('*')->from($this->table)->order_by('name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$newArray['contact'] = $row;
				$querySector = $this->db->select('s.*')->from($this->table_invite_sector.'  as i')->join($this->table_sector.' as s', 's.id = i.market_id')->where('i.invite_id',$row->id)->get();
                if ($querySector->num_rows() > 0) {
					foreach ($querySector->result() as $sector) {
						$newArray['sector'][] = $sector;
					} 
				} else {
					$newArray['sector']= array();
				}
				$data[] = $newArray;
            }            
        }
		
		return $data;
	}	
	function getContactListBySectorID($sectorID){
		$query = $this->db->select('c.*')->from($this->table.' as c ')->join($this->table_invite_sector .' as ivs ', 'ivs.invite_id = c.id')->where('ivs.market_id',$sectorID)->order_by('c.name','ASC')->get();
		$data = array();
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$newArray['contact'] = $row;
				$querySector = $this->db->select('s.*')->from($this->table_invite_sector.'  as i')->join($this->table_sector.' as s', 's.id = i.market_id')->where('i.invite_id',$row->id)->get();
                if ($querySector->num_rows() > 0) {
					foreach ($querySector->result() as $sector) {
						$newArray['sector'][] = $sector;
					} 
				} else {
					$newArray['sector']= array();
				}
				$data[] = $newArray;
            }            
        }		
		return $data;
	}
}
?>