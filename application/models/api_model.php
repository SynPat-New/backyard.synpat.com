<?php
class api_model extends CI_Model{
	
	public $table_contacts = 'contacts';
	public $table_company = 'company';
	public $table_api_users = 'api_users';
	public $table_users = 'users';
	public $table_assign_leads = 'assign_leads';
	public $table_assign_modules = 'assign_modules';
	
	function __construct() { 
		parent::__construct();
	}
	
	public function getAccountInfo($loginID){
		$query = $this->db->select('id,name')->from($this->table_api_users)->where('user_login',$loginID)->where('status',1)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();  
        }
		return $data;
	}
	
	public function checkClient($loginID,$hashKey){
		$query = $this->db->select('user_id as account_id, secret_key as apiUser')->from($this->table_api_users)->where('user_login',$loginID)->where('secret_key',$hashKey)->where('status',1)->limit(1)->get();
		$data = array('auth'=>false,'account_id'=>'');
		if ($query->num_rows() > 0) {
            $row = $query->first_row(); 
			$data['auth'] = true;
			$data['account_id'] = $row->account_id;
        }
		return $data;
	}
	
	public function ionic_login($email){
		$query = $this->db->select('id as account_id,password')->from($this->table_users)->where('email',$email)->where('status',0)->limit(1)->get();
		$data = array('auth'=>false,'account_id'=>'');
		if ($query->num_rows() > 0) {
            $row = $query->first_row(); 
			$data['auth'] = true;
			$data['account_id'] = $row->account_id;
			$data['password'] = $row->password;
        }
		return $data;
	}
	
	public function getAPIContactList($noOfRecords=500,$Offset=0){
		$totalRecords = 0;
		$queryTotal = $this->db->select('count(c.id) as totalRecords')->from($this->table_contacts.' as c')->join($this->table_company.' as co', 'co.id = c.company_id')->get();		
		if ($queryTotal->num_rows() > 0) {
			$row  = $queryTotal->first_row();
			$totalRecords = $row->totalRecords;
		}
		$data = array('totalRecords'=>$totalRecords,'contacts'=>array(),'headings'=>array(array('name'=>'job_title','code'=>'job_title'),array('name'=>'email','code'=>'email'),array('name'=>'phone','code'=>'phone'),array('name'=>'telephone','code'=>'telephone'),array('name'=>'linkedin_url','code'=>'linkedin_url')));				
		$this->db->limit($noOfRecords,$Offset);
		/*$query = $this->db->select("c.id,CONCAT((c.first_name),(' '),(c.last_name)) as name,first_name,last_name,co.company_name as company_name,c.job_title,c.email,c.phone,c.telephone,c.linkedin_url")->from($this->table_contacts.' as c')->join($this->table_company.' as co', 'co.id = c.company_id')->get();	*/
		$query = $this->db->select("c.id,c.first_name,c.last_name,co.company_name as company_name,c.job_title,c.email,c.phone,c.telephone,c.linkedin_url")->from($this->table_contacts.' as c')->join($this->table_company.' as co', 'co.id = c.company_id')->get();	
		/*echo $this->db->last_query();*/
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
				$data['contacts'][] = $row;
			}
		}		
		return $data;
	}
}
?>