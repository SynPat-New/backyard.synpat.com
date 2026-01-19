<?php
class manager_model extends CI_Model{
	
	public $table = 'outsource_user';
	public $table_project = 'outsource_project';
	public $table_project_data = 'outsource_project_data';
	public $table_project_amount_col_user = 'outsource_project_amount_col_user';
	public $table_project_data_drop_history = 'outsource_project_data_drop_history';
	public $table_project_columns = 'outsource_columns';
	public $table_user_projects = 'outsource_project_users';
	public $table_transactions = 'outsource_transaction';
	public $table_payments = 'outsource_payments';
	public $table_outsource_predefined_columns = 'outsource_predefined_columns';
	public $table_outsource_client = 'outsource_client';
	public $table_outsource_templates = 'outsource_templates';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function insertProject($data){
		$this->db->insert($this->table_project,$data);
		return $this->db->insert_id();
	}
	
	public function insertProjectColUserAmount($data){
		$this->db->insert($this->table_project_amount_col_user,$data);
		return $this->db->insert_id();
	}
	
	public function updateProjectColUserAmount($data,$id){
		$this->db->where('id',$id);
		$this->db->update($this->table_project_amount_col_user,$data);
	}
	
	public function deleteProjectColUserAmount($userID,$col,$projectID){
		$this->db->where('project_id',$projectID);
		$this->db->where('col',$col);
		$this->db->where('user_id',$userID);
		$this->db->delete($this->table_project_amount_col_user);
		return $this->db->affected_rows();
	}
	
	public function insertProjectData($data){
		$this->db->insert($this->table_project_data,$data);
		return $this->db->insert_id();
	}
	
	public function insertColumns($data){
		$this->db->insert($this->table_project_columns,$data);
		return $this->db->insert_id();
	}
	
	public function insertUserProject($data){
		$this->db->insert($this->table_user_projects,$data);
		return $this->db->insert_id();
	}
	
	public function insertUser($data){
		$this->db->insert($this->table,$data);
		return $this->db->insert_id();
	}
	
	public function insertTemplate($data){
		$this->db->insert($this->table_outsource_templates,$data);
		return $this->db->insert_id();
	}
	
	function updateProfile($data,$id){
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
	
	function getUser($id){
		$query = $this->db->select('*')->from($this->table)->where('id',$id)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	function getTemplates(){
		$query = $this->db->select('id,subject,template')->from($this->table_outsource_templates)->order_by('id','ASC')->get();
		$data = array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		return $data; 
	}
	
	function findPredefinedHeadings($select){
		$query = $this->db->select($select)->from($this->table_outsource_predefined_columns)->order_by('id','ASC')->get();
		$data = array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		return $data; 
	}
	
	function findMyClients($userID,$select){
		$query = $this->db->select($select)->from($this->table_outsource_client)->where('user_id',$userID)->order_by('first_name','ASC')->get();
		$data = array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		return $data; 
	}
	
	function findUserDetails($userID){
		$query = $this->db->select("*")->from($this->table)->where('id',$userID)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	function checkColumnByProject($userID,$col,$projectID){
		$query = $this->db->select("*")->from($this->table_project_amount_col_user)->where('user_id',$userID)->where('project_id',$projectID)->where('col',$col)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;		
	}
	
	function checkUserEmail($email){
		$query = $this->db->select("*")->from($this->table)->where('email',$email)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	function checkUserActivationCode($activationCode){
		$query = $this->db->select("*")->from($this->table)->where('activation_code',$activationCode)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function getAllActiveUsersByType($type){
		$query = $this->db->select("*")->from($this->table)->where('type',$type)->where('status','0')->get();
		$data = array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$projectBalanceList = $this->findMyEntryForAllUsersCurrentMonth(0,$row->id);
				$row->projects_balance = $projectBalanceList;
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function login($email,$password){
		$query = $this->db->select("*")->from($this->table)->where('email',$email)->where('password',$password)->where('status',0)->where('type','9')->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function getProject($projectID){
		$query = $this->db->select("*")->from($this->table_project.' as p')->where('p.id',$projectID)->where('p.status',1)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function findMyEntryForAllUsersCurrentMonth($projectID,$userID=0){		
		$data = array();
		if($userID==0 && $projectID>0){
			$query = $this->db->select("id,paypal_address,first_name,last_name")->from($this->table)->where('type',1)->where('status','0')->where('id IN (SELECT DISTINCT(user_id) FROM '.$this->table_project_amount_col_user.' WHERE project_id='.$projectID.')')->get();
			/*echo $this->db->last_query();*/
			if($query->num_rows()>0){
				foreach($query->result() as $row){		
					$lastPayment = 0;
					$lastPaymentDate = "";
					$queryLastPayment = $this->db->select("sum(payment_gross) as payment_gross")->from($this->table_payments)->where('user_id',$row->id)->where("project_id",$projectID)->get();
					if($queryLastPayment->num_rows()>0){
						$dataPayment = $queryLastPayment->first_row();
						$lastPayment = $dataPayment->payment_gross;
					}
					$getUserData = $this->findMyEntryCurrentMonth($row->id,$projectID);
					$data[] = array('id'=>$row->id,'project_id'=>$projectID,'last_payment'=>$lastPayment,'paypal_email'=>$row->paypal_address,'name'=>$row->first_name." ".$row->last_name,'activities'=>$getUserData);
				}
			}
		} else if($userID>0 && $projectID==0) {
			$query = $this->db->select("*")->from($this->table)->where('type',1)->where('status','0')->where("id",$userID)->get();
			if($query->num_rows()>0){
				$row = $query->first_row();				
				$queryUserWorkedonProjects = $this->db->select('DISTINCT(pd.project_id) as project_id,p.project_name as projectName')->from($this->table_project_data.' as pd')->join($this->table_project.' as p', 'p.id = pd.project_id')->where('pd.user_id',$row->id)->where('p.status',1)->order_by('p.project_name','ASC')->get();
				/*echo $this->db->last_query();*/
				if($queryUserWorkedonProjects->num_rows()>0){
					foreach($queryUserWorkedonProjects->result() as $project){
						$lastPayment = 0;
						$queryLastPayment = $this->db->select("sum(payment_gross) as payment_gross")->from($this->table_payments)->where('user_id',$row->id)->where("project_id",$project->project_id)->get();
						if($queryLastPayment->num_rows()>0){
							$dataPayment = $queryLastPayment->first_row();
							$lastPayment = $dataPayment->payment_gross;
						}
						$getUserData = $this->findMyEntryCurrentMonth($row->id,$project->project_id);						
						$data[] = array('id'=>$row->id,'last_payment'=>$lastPayment,'paypal_email'=>$row->paypal_address,'project_id'=>$project->project_id,'name'=>$project->projectName,'user_name'=>$row->first_name." ".$row->last_name,'activities'=>$getUserData);
					}
				}
			}
		} else {
			$projectQuery = $this->db->select("p.id as project_id,p.project_name")->from($this->table_project.' as p')->where('p.status',1)->order_by('p.project_name','ASC')->get();
			if($projectQuery->num_rows()>0){
				foreach($projectQuery->result() as $project){
					$queryUser = $this->db->select("id,paypal_address,first_name,last_name")->from($this->table)->where('type',1)->where('status','0')->where('id IN (SELECT DISTINCT(user_id) FROM '.$this->table_project_amount_col_user.' WHERE project_id='.$project->project_id.')')->get();
					$getUserData = array();
					if($queryUser->num_rows()>0){
						foreach($queryUser->result() as $row){		
							$lastPayment = 0;
							$queryLastPayment = $this->db->select("sum(payment_gross) as payment_gross")->from($this->table_payments)->where('user_id',$row->id)->where("project_id",$project->project_id)->get();
							if($queryLastPayment->num_rows()>0){
								$dataPayment = $queryLastPayment->first_row();
								$lastPayment = $dataPayment->payment_gross;
							}
							$activitiesData =  $this->findMyEntryCurrentMonth($row->id,$project->project_id);
							$userData = array('id'=>$row->id,'paypal_email'=>$row->paypal_address,'last_payment'=>$lastPayment,'name'=>$row->first_name." ".$row->last_name,'activities'=>$activitiesData);
							$getUserData[] = $userData;
						}
					}
					$itemArray = array("project_id"=>$project->project_id,"project_name"=>$project->project_name,'list'=>$getUserData);
					$data[] = $itemArray;
				}
			}			
		}	
		return $data;
	}
	
	public function findUserAllProjects($userID){
		$queryProjectEntry = $this->db->select('cu.col,cu.count,p.id as project_id,p.project_name, (SELECT `c`.`price` FROM '.$this->table_project_columns.' as c WHERE `c`.`project_id` = `cu`.`project_id` AND c.column_num = cu.col) as price')->from($this->table_project_amount_col_user.' as cu')->join($this->table_project.' as p', 'p.id = cu.project_id')->where('cu.user_id',$userID)->get();
		$allProject = array();
		if($queryProjectEntry->num_rows()>0){
			foreach($queryProjectEntry->result() as $row){
				$allProject[] = $row;
			}
		}
		return array('current_project'=>$allProject,'all_project'=>$allProject);
	}
	
	public function findMyEntryCurrentMonth($userID,$projectID){
		$queryProjectEntry = $this->db->select('cu.*, (SELECT `c`.`price` FROM '.$this->table_project_columns.' as c WHERE `c`.`project_id` = `cu`.`project_id` AND c.column_num = cu.col) as price')->from($this->table_project_amount_col_user.' as cu')->where('user_id',$userID)->where('project_id',$projectID)->get();
		$currentMonth = array();
		if($queryProjectEntry->num_rows()>0){
			foreach($queryProjectEntry->result() as $row){
				$currentMonth[] = $row;
			}
		}
		/*echo $this->db->last_query();*/
		$queryProjectEntry = $this->db->select('cu.*, (SELECT `c`.`price` FROM '.$this->table_project_columns.' as c WHERE `c`.`project_id` = `cu`.`project_id` AND c.column_num = cu.col) as price')->from($this->table_project_amount_col_user.' as cu')->where('cu.user_id',$userID)->get();
		$allProject = array();
		if($queryProjectEntry->num_rows()>0){
			foreach($queryProjectEntry->result() as $row){
				$allProject[] = $row;
			}
		}
		return array('current_project'=>$currentMonth,'all_project'=>$allProject);
	}
	
	public function findUserProjectByUserID($userID){
		/*$query = $this->db->select("*")->from($this->table_user_projects.' as up')->join($this->table_project.' as p','p.id = up.project_id')->where('up.user_id',$userID)->where('p.status',1)->order_by('p.id','DESC')->get();*/
		$query = $this->db->select("*")->from($this->table_user_projects.' as up')->join($this->table_project.' as p','p.id = up.project_id')->where('up.user_id',$userID)->order_by('p.status','DESC')->get();
		$data = array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$column_heading = array();
				$queryColumn = $this->db->select("*")->from($this->table_project_columns.' as c')->where('c.status',1)->where('c.project_id',$row->id)->order_by('c.column_num','ASC')->get();
				if($queryColumn->num_rows()>0){
					foreach($queryColumn->result() as $column){						
						$column_heading[] = $column;
					}
				}
				$row->column_heading = $column_heading;
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function findAllMyProjects(){
		/*$query = $this->db->select("*")->from($this->table_project.' as p')->where('p.status',1)->order_by('p.id','DESC')->get();*/
		$query = $this->db->select("*")->from($this->table_project.' as p')->order_by('p.status','DESC')->get();
		$data = array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$column_heading = array();
				$queryColumn = $this->db->select("*")->from($this->table_project_columns.' as c')->where('c.status',1)->where('c.project_id',$row->id)->order_by('c.column_num','ASC')->get();
				if($queryColumn->num_rows()>0){
					foreach($queryColumn->result() as $column){						
						$column_heading[] = $column;
					}
				}
				$row->column_heading = $column_heading;
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function checkAllBounceEmailByProjectIDAndUserID($projectID,$userID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data_drop_history.' as pd')->where('pd.project_id', $projectID)->where('pd.user_id', $userID)->where('pd.pass', 1)->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			foreach($queryProjectData->result() as $row){
				$data[] = $row;
			}
			/*$this->db->where('project_id',$projectID);
			$this->db->where('user_id',$userID);
			$this->db->update($this->table_project_data_drop_history,array('pass'=>0));*/
		}
		return $data;
	}
	
	public function checkProjectDataWithMessageID($messageID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('message_id', $messageID)->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			$data = $queryProjectData->first_row();
		}		
		return $data;
	}
	
	public function updateFormData($dataArray,$rowID){
		$this->db->where('id',$rowID);
		$this->db->update($this->table_project_data,$dataArray);
		return $this->db->affected_rows();
	}
	
	public function updateProject($dataArray,$projectID){
		$this->db->where('id',$projectID);
		$this->db->update($this->table_project,$dataArray);
		return $this->db->affected_rows();
	}
	
	public function uploadDataToDropHistory($data){
		$this->db->insert($this->table_project_data_drop_history,$data);
		return $this->db->insert_id();
	}
	
	public function findProjectDataWithRowCol($row,$col,$projectID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.project_id',$projectID)->where('pd.row',$row)->where('pd.col',$col)->where('enter_by', "Free")->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			$data = $queryProjectData->first_row();
		}
		return $data;
	}
	
	
	
	
	
	
	public function findUserTransactions($userID){
		$queryTransaction = $this->db->select('*')->from($this->table_transactions)->where('user_id',$userID)->get();
		$data= array();
		if($queryTransaction->num_rows()>0){
			foreach($queryTransaction->result() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function findProjectFullDetailWithColumnsEncryptID($encryptProjectID){
		$queryProject  = $this->db->select("*")->from($this->table_project.' as p')->where('md5(id)="'.$encryptProjectID.'"')->get();
		$dataDetail = array('project_details'=>array(),'column_heading'=>array(),'project_data'=>array());
		if($queryProject->num_rows()>0){
			$dataDetail['project_details'] = $queryProject->first_row();
			$queryColumn = $this->db->select("*")->from($this->table_project_columns.' as c')->where('c.project_id',$dataDetail['project_details']->id)->order_by('c.column_num','ASC')->get();
			if($queryColumn->num_rows()>0){
				foreach($queryColumn->result() as $row){
					$dataDetail['column_heading'][] = $row;
				}
			}
			$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.project_id',$dataDetail['project_details']->id)->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
			if($queryProjectData->num_rows()>0){
				foreach($queryProjectData->result() as $row){
					$dataDetail['project_data'][] = $row;
				}
			}
		}
		return $dataDetail;
	}
}
	