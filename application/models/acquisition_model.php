<?php

class acquisition_model extends CI_Model{
	
	public $table_acquisition = "acquisition";
	public $table_acquisition_assigned = "acquisition_assigned";
	public $table_acquisition_technologies = 'acquisition_technologies';
	public $table_leads = 'litigations';
	public $table_category = 'category';
	public $table_licenses = 'licenses';
	
	function __construct() {
		parent::__construct();
	}
	
	function insertAcquisition($data){
		$this->db->insert($this->table_acquisition, $data);
		return $this->db->insert_id();
	}
	
	function insertAcquisitionAssigned($data){
		$this->db->insert($this->table_acquisition_assigned, $data);
		return $this->db->insert_id();
	}
	
	function deleteAcqusition($leadID){
		$this->db->where('lead_id',$leadID);
		$this->db->delete($this->table_acquisition);
	}
	
	function insertAcquisitionTechnologies($data){
		$this->db->insert($this->table_acquisition_technologies, $data);
		return $this->db->insert_id();
	}
	
	function updateData($leadID,$data){
		$this->db->where('lead_id',$leadID);
		$this->db->update($this->table_acquisition,$data);
		return $this->db->affected_rows();
	}
	

	
	function getData($leadID){
		$query = $this->db->select('a.*')->from($this->table_acquisition.' as a')->where('a.lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data['acquisition'] = $query->first_row();
			$data['assigned'] = array();
			$data['technologiesData'] = array();			
        }
		return $data;
	}
	
	function getDataByOptions($leadID,$select){
		$query = $this->db->select($select)->from($this->table_acquisition.' as a')->where('a.lead_id',$leadID)->get();
		$data = array();
		if ($query->num_rows() > 0) {
            $data = $query->first_row();
		}
		return $data;
	}
	
	function updateLicenseDataBySerialNumber($activeButton,$serialNumber){
		$this->db->where('serial_number', $serialNumber);
		$this->db->update($this->table_licenses, array('active_button'=>$activeButton));
		return $this->db->affected_rows();
	}
	
	public function findPortfolios($category){
		$query = $this->db->select('a.*,l.lead_name,l.serial_number,c.name as categoryName')->from($this->table_acquisition.' as a')->join($this->table_leads.' as l','l.id=a.lead_id','left')->join($this->table_category.' as c','c.id=a.category','left')->where('a.category',$category)->where_in('l.status',array('0','1','2'))->get();
		$data = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
                $rowData = $row;
				$todayDate = strtotime(date('Y-m-d',strtotime('now')));
				$expirationDate = strtotime($rowData->option_expiration_data);
				$regularLicense = strtotime($rowData->regular_license_starts);
				$lateLicense = strtotime($rowData->late_license_starts);
				if(($rowData->option_expiration_data!='0000-00-00 00:00:00' && $expirationDate>$todayDate && $rowData->regular_license_starts=='0000-00-00 00:00:00') || (int)$rowData->cost_price==0){
					if($rowData->active_button!='1'){
						$rowData->active_button = 1;
						$this->updateData($row->lead_id,array('active_button'=>$rowData->active_button));
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
	
	public function getAllPortfoliosWithIDs($docketIDs){
		$getList = array();
		if(count($docketIDs)>0){
			$implodeIDs = implode(',',$docketIDs);
			if(!empty($implodeIDs)){
				$query = $this->db->select('a.*,l.lead_name,l.serial_number,c.name as categoryName')->from($this->table_acquisition.' as a')->join($this->table_leads.' as l','l.id=a.lead_id','left')->join($this->table_category.' as c','c.id=a.category','left')->join($this->table_licenses.' as li','li.serial_number=l.serial_number','left')->where('li.id IN ('.$implodeIDs.')')->get();
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$getList[] = $row;
					}
				}
			}
		}
		return $getList;
	}
}
?>