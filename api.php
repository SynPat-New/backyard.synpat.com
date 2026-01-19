<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function auth(){
		$data = $this->input->post();
		$response = array('auth'=>false);
		try{
			if(isset($data['USER_LOGIN']) && isset($data['USER_HASH'])){
				$this->load->model('api_model');
				$response['auth'] = $this->api_model->checkClient($data['USER_LOGIN'],$data['USER_HASH']);
			}
		}catch(Exception $e){
			
		}		
		$this->printJSON(array('response'=>$response));
	}
	
	public function v2($field='contacts',$type='json'){
		$postData = $this->input->post();
		switch($field){
			case 'accounts':
				$response= array('account'=>array());
				if(isset($postData['USER_LOGIN']) && !empty($postData['USER_LOGIN'])){
					$this->load->model('api_model');
					$response['account'] = $this->api_model->getAccountInfo($postData['USER_LOGIN']);					
				}
				$this->printJSON(array('response'=>$response));
			break;
			case 'contacts':
				$noOfRecords = 500;
				$offSet = 0;
				if(isset($postData['limit_rows'])){
					if((int)$postData['limit_rows']<=500){
						$noOfRecords = (int)$postData['limit_rows'];
					}					
				}
				if(isset($postData['limit_offset'])){
					if((int)$postData['limit_offset']>=0){
						$offSet = (int)$postData['limit_offset'];
					}					
				}
				$this->load->model('api_model');
				$getList = $this->api_model->getAPIContactList($noOfRecords,$offSet);
				$this->printJSON(array('response'=>$getList));
			break;
			default:
			die;
			break;
		}
	}
	
	public function printJSON($data=array()){
		echo json_encode($data);
		die;
	}

}
/* End of file private.php */
/* Location: ./application/controllers/api.php */