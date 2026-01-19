<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Mobile extends CI_Controller {

		function __construct(){
			parent::__construct(); 
			$this->layout->auto_render=false;
		}

		public function contact($show='html',$noOfRecords=50){
			$data = array('contacts'=>array(),'noOfRecords'=>$noOfRecords);
			if (extension_loaded('newrelic')){
				newrelic_disable_autorum();
			}	
			$this->load->model('client_model');
			if(isset($_POST) && count($_POST)>0){	
				$searchString = $this->input->post('search');
				$data['contacts'] = $this->client_model->getAllContactsBySectorWithPaging($searchString,'',0,200,"c.system_update","DESC","","","","","","","","","","",0,"mobile");
			} else {				
				$data['contacts'] = $this->client_model->getAllContactsWithPaging(200,"mobile");
			}
			if($show=="html"){
				$this->layout->layout='mobile';	
				$this->layout->title_for_layout = 'Contact';
				$this->layout->render('mobile/contact',$data);
			} else {
				echo json_encode($data);
				die;
			}
		}
	}
	