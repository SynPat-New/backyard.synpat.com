<?php
class outsource_model extends CI_Model{
	
	public $table = 'outsource_user';
	public $table_project = 'outsource_project';
	public $table_project_data = 'outsource_project_data';
	public $table_project_amount_col_user = 'outsource_project_amount_col_user';
	public $table_project_data_drop_history = 'outsource_project_data_drop_history';
	public $table_project_columns = 'outsource_columns';
	public $table_user_projects = 'outsource_project_users';
	public $table_transactions = 'outsource_transaction';
	public $table_payments = 'outsource_payments';
	public $table_email_verfier = 'outsource_email_verfier';
	public $table_error = 'outsource_error';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function insertProject($data){
		$this->db->insert($this->table_project,$data);
		return $this->db->insert_id();
	}
	
	public function insertEmailVerifier($data){
		$this->db->insert($this->table_email_verfier,$data);
		return $this->db->insert_id();
	}
	
	public function updateProject($data,$id){
		$this->db->where('id',$id);
		$this->db->update($this->table_project,$data);
		return $this->db->affected_rows();
	}
	
	public function insertProjectColUserAmount($data){
		$this->db->insert($this->table_project_amount_col_user,$data);
		return $this->db->insert_id();
	}
	
	public function insertPayment($data){
		$this->db->insert($this->table_payments,$data);
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
	
	function updateProfile($data,$id){
		$this->db->where('id',$id);
		$this->db->update($this->table,$data);
		return $this->db->affected_rows();
	}
	
	public function insertError($data){
		$this->db->insert($this->table_error,$data);
		return $this->db->insert_id();
	}
	
	public function updateError($data,$id){
		$this->db->where('id',$id);
		$this->db->update($this->table_error,$data);
		return $this->db->affected_rows();
	}
	
	function findUserDetails($userID){
		$query = $this->db->select("*")->from($this->table)->where('id',$userID)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	function findUserError($userID){
		$query = $this->db->select("*")->from($this->table_error)->where('user_id',$userID)->order_by('id','DESC')->limit(1,0)->get();
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
	
	public function login($email,$password){
		$query = $this->db->select("*")->from($this->table)->where('email',$email)->where('password',$password)->get();
		$data = array();
		if($query->num_rows()>0){
			$data = $query->first_row();
		}
		return $data;
	}
	
	public function findUserProjectByUserID($userID){
		$query = $this->db->select("*")->from($this->table_user_projects.' as up')->join($this->table_project.' as p','p.id = up.project_id')->where('up.user_id',$userID)->where('p.status',1)->order_by('p.id','DESC')->get();
		$data = array();
		if($query->num_rows()>0){
			foreach($query->result() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function findAllProjects(){
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
				/*
				$columnCountQuery = $this->db->select('count(*) as colCount')->from(%this->table_project_data)->where('project_id',$row->id)->where('data',"")->where('enter_by','Free')->get();
				if($columnCountQuery->num_rows()){
					$getColumnCount
				}*/
				$row->column_heading = $column_heading;
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function findUserRejectedData($userID,$projectID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data_drop_history.' as pddh')->where('pddh.project_id', $projectID)->where('pddh.user_id', $userID)->order_by('pddh.id')->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			foreach($queryProjectData->result() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function checkAllBounceEmailByProjectIDAndUserID($projectID,$userID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data_drop_history.' as pd')->where('pd.project_id', $projectID)->where('pd.user_id', $userID)->where('pd.pass', 1)->where('pd.status', 0)->get();
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
	
	public function updateDropHistory($data,$ID){
		$this->db->where('id',$ID);
		$this->db->update($this->table_project_data_drop_history,$data);
		return $this->db->affected_rows();
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
	
	public function uploadDataToDropHistory($data){
		$this->db->insert($this->table_project_data_drop_history,$data);
		return $this->db->insert_id();
	}
	
	public function checkPhoneEntry($data){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.data',$data)->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			$data = $queryProjectData->first_row();
		}
		return $data;
	}
	
	public function findProjectDataWithRowCol($row,$col,$projectID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.project_id',$projectID)->where('pd.row',$row)->where('pd.col',$col)->where('enter_by', "Free")->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			$data = $queryProjectData->first_row();
		}
		return $data;
	}

	public function findProjectDataWithRowColByID($id,$projectID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.project_id',$projectID)->where('pd.id',$id)->where('enter_by', "Free")->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			$data = $queryProjectData->first_row();
		}
		return $data;
	}
	
	public function findProjectDataWithRowColByIDByEd($id,$projectID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.project_id',$projectID)->where('pd.id',$id)->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			$data = $queryProjectData->first_row();
		}
		return $data;
	}
	
	public function findProjectDataWithId($rowID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.id',$rowID)->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			$data = $queryProjectData->first_row();
		}
		return $data;
	}
	
	public function findProjectDataWithRowColOpen($row,$col,$projectID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.project_id',$projectID)->where('pd.row',$row)->where('pd.col',$col)->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			$data = $queryProjectData->first_row();
		}
		return $data;
	}
	
	public function findFilledDataByUser($projectID){
		$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.project_id',$projectID)->where('enter_by', "User")->where('pd.row <>""')->where('pd.col <>""')->where('pass',1)->get();
		$data = array();
		if($queryProjectData->num_rows()>0){
			foreach($queryProjectData->result() as $row){
				$data[] = $row;
			}
		}
		return $data;
	}
	
	public function findMyEntryCurrentMonth($userID,$projectID){
		/*$queryProjectEntry  = $this->db->select('(SELECT count(id) FROM '.$this->table_project_data.' WHERE col=4 and user_id='.(int)$userID.' AND project_id='.(int)$projectID.') as column4,
		(SELECT count(id) FROM '.$this->table_project_data.' WHERE col=5 and user_id='.(int)$userID.' AND project_id='.(int)$projectID.') as column5,
		(SELECT count(id) FROM '.$this->table_project_data.' WHERE col=6 and user_id='.(int)$userID.' AND project_id='.(int)$projectID.') as column6')->from($this->table_project_data.' as p')->where('user_id',$userID)->where('project_id',$projectID)->get();
		$data = array();
		if($queryProjectEntry->num_rows()>0){
			$data = $queryProjectEntry->first_row();
		}
		return $data;*/
		$queryProjectEntry = $this->db->select('cu.*, (SELECT `c`.`price` FROM '.$this->table_project_columns.' as c WHERE `c`.`project_id` = `cu`.`project_id` AND c.column_num = cu.col) as price')->from($this->table_project_amount_col_user.' as cu')->where('cu.user_id',$userID)->where('cu.project_id',$projectID)->get();
		$currentMonth = array();
		if($queryProjectEntry->num_rows()>0){
			foreach($queryProjectEntry->result() as $row){
				$currentMonth[] = $row;
			}
		}
		$columnHeading = array();
		$queryColumn = $this->db->select('*')->from($this->table_project_columns.' as c')->where('c.status',1)->where('c.project_id',$projectID)->get();
		if($queryColumn->num_rows()>0){
			foreach($queryColumn->result() as $row){
				$columnHeading[] = $row;
			}
		}
		$queryProjectEntry = $this->db->select('cu.*, (SELECT `c`.`price` FROM '.$this->table_project_columns.' as c WHERE `c`.`project_id` = `cu`.`project_id` AND c.column_num = cu.col) as price')->from($this->table_project_amount_col_user.' as cu')->where('cu.user_id',$userID)->get();
		$allProject = array();
		if($queryProjectEntry->num_rows()>0){
			foreach($queryProjectEntry->result() as $row){
				$allProject[] = $row;
			}
		}
		return array('current_project'=>$currentMonth,'all_project'=>$allProject,'column_heading'=>$columnHeading);
	}
	
	public function getUserEntryProjects($userID){
		$queryUserWorkedonProjects = $this->db->select('DISTINCT(pd.project_id) as project_id,p.project_name as projectName')->from($this->table_project_data.' as pd')->join($this->table_project.' as p', 'p.id = pd.project_id')->where('pd.user_id',$userID)->where('p.status',1)->order_by('p.project_name','ASC')->get();
		$lastPayment = 0;
		$lastPaymentDate = "";
		$queryLastPayment = $this->db->select("*")->from($this->table_payments)->where('user_id',$userID)->order_by("payment_id","DESC")->get();
		if($queryLastPayment->num_rows()>0){
			$dataPayment = $queryLastPayment->first_row();
			$lastPayment = $dataPayment->payment_gross;
			$lastPaymentDate = date('M d,Y',strtotime($dataPayment->payment_date));
		}
		$data = array();
		if($queryUserWorkedonProjects->num_rows()>0){
			foreach($queryUserWorkedonProjects->result() as $project){
				$getUserData = $this->findMyEntryCurrentMonth($userID,$project->project_id);
				$data[] = array('id'=>$userID,'last_payment'=>$lastPayment,'last_payment_date'=>$lastPaymentDate,'paypal_email'=>$row->paypal_address,'project_id'=>$project->project_id,'name'=>$project->projectName,'activities'=>$getUserData);
			}
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
	
	public function findProjectWithEncryptID($encryptProjectID){
		$data = array();
		$queryProject  = $this->db->select("*")->from($this->table_project.' as p')->where('md5(id)="'.$encryptProjectID.'"')->get();
		if($queryProject->num_rows()>0){
			$data = $queryProject->first_row();
		}
		return $data;
	}
	
	public function findUserData($projectID,$userID){
		$list = array();
		$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.project_id',$projectID)->where('user_id',$userID)->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
		if($queryProjectData->num_rows()>0){
			foreach($queryProjectData->result() as $row){
				$list[] = $row;
			}
		}
		return $list;
	}
	
	public function getProjectDetailswithEncryptID($encryptProjectID){
		$queryProject  = $this->db->select("*")->from($this->table_project.' as p')->where('md5(id)="'.$encryptProjectID.'"')->get();
		$data= array();
		if($queryProject->num_rows()>0){
			$data = $queryProject->first_row();
		}
		return $data;
	}
	
	public function findProjectFullDetailWithColumnsEncryptID($encryptProjectID,$userID=0){
		$queryProject  = $this->db->select("*")->from($this->table_project.' as p')->where('md5(id)="'.$encryptProjectID.'"')->where('p.status',1)->get();
		$dataDetail = array('project_details'=>array(),'column_heading'=>array(),'project_data'=>array());
		
		if($queryProject->num_rows()>0){
			$dataDetail['project_details'] = $queryProject->first_row();
			$queryColumn = $this->db->select("*")->from($this->table_project_columns.' as c')->where('c.project_id',$dataDetail['project_details']->id)->order_by('c.column_num','ASC')->get();
			if($queryColumn->num_rows()>0){
				foreach($queryColumn->result() as $row){
					$dataDetail['column_heading'][] = $row;
				}
			}
			if($userID==0){
				$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.project_id',$dataDetail['project_details']->id)->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
				
			} else {
				$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as pd')->where('pd.project_id',$dataDetail['project_details']->id)->where('row IN (SELECT DISTINCT(pd1.row) FROM '.$this->table_project_data.' as pd1 WHERE pd1.project_id='.$dataDetail['project_details']->id.' AND pd1.user_id='.$userID.' AND pd1.enter_by="User")')->order_by('pd.row','ASC')->order_by('pd.col','ASC')->get();
				
			}	
			if($queryProjectData->num_rows()>0){
				foreach($queryProjectData->result() as $row){
					$dataDetail['project_data'][] = $row;
				}
			}
			
		}
		return $dataDetail;
	}
	
	public function findCallingDataForDialer(){
		$dataDetail = array();
		/*$queryProject  = $this->db->select("distinct(p.id),p.project_name,p.created_date,p.status")->from($this->table_project.' as op')->join($this->table_project_data.' as opd','op.id = opd.project_id')->where('opd.enter_by','User')->where('opd.user_id <> 0')->where('opd.pass',0)->get();*/
		$queryProject  = $this->db->select("distinct(op.id),op.project_name,op.created_date,op.status")->from($this->table_project.' as op')->join($this->table_project_data.' as opd','op.id = opd.project_id')->get();
		if($queryProject->num_rows()>0){
			foreach($queryProject->result() as $project){
				$projectDetails = $project;
				$columnHeading = array();
				$verifyColumnHeading = array();
				$projectData = array();
				$queryColumn = $this->db->select("*")->from($this->table_project_columns.' as c')->where('c.project_id',$project->id)->where('c.status',0)->order_by('c.column_num','ASC')->get();
				if($queryColumn->num_rows()>0){
					foreach($queryColumn->result() as $column){
						$columnHeading[] = $column;
					}
				}
				/*Query for verification heading*/
				$queryVerification = $this->db->select("*")->from($this->table_project_columns.' as c')->where('lower(c.heading) LIKE "%phone%"')->where('c.status',1)->order_by('c.column_num','ASC')->get();
				if($queryVerification->num_rows()>0){
					foreach($queryVerification->result() as $column){
						$verifyColumnHeading[] = $column;
					}
				}
				/*$queryProjectData = $this->db->select("*")->from($this->table_project_data.' as opd')->join($this->table_project_columns.' as oc', 'oc.column_num = opd.col')->where('opd.enter_by <> "Free"')->where('opd.pass','0')->get();	*/
				$mergeColumns = array_merge($columnHeading,$verifyColumnHeading);
				$dataFormColumn = array();
				foreach($mergeColumns as $column){
					$dataFormColumn[] = $column->column_num;
				}
				$queryProjectData = $this->db->select("id,project_id,row,col,data,enter_by,user_id")->from($this->table_project_data.' as opd')->where('opd.project_id',$project->id)->where('opd.enter_by <> "Free"')->where('col IN ('.implode(",",$dataFormColumn).')')->order_by('opd.row','ASC')->order_by('opd.col','ASC')->get();
				if($queryProjectData->num_rows()>0){
					foreach($queryProjectData->result() as $projectEntries){
						$projectData[] = $projectEntries;
					}
				}
				$dataDetail[] = array('project_detail'=>$projectDetails,'column_heading'=>$mergeColumns,'project_data'=>$projectData,'verified_columns'=>$verifyColumnHeading,'column_heading_main'=>$columnHeading);
			}
		}		
		return $dataDetail;
	}
}
	