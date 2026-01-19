<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Camcard extends CI_Controller {

	public function __construct(){
		header("Access-Control-Allow-Headers: X-API-KEY, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
		parent::__construct();		
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));		
	}

	public function search_company(){
		$data = array();
		$this->load->model('lead_model');
		$data = $this->lead_model->getCompanyList($this->input->get('term'),"c.id,c.company_name as label,c.company_name as value");
		echo json_encode($data);
		die;
	}
}