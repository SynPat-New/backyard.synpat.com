<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manager_Login extends CI_Controller {

	public function __construct(){		
		parent::__construct();
		if ( $this->session->userdata('manager')){
				redirect('manager/login');
		}
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));		
	}

	function index(){
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';		
		$this->layout->render('manager/login');
	}
	function login(){
		$post = $this->input->post('login');
		if(count($post)>0){
			if(!empty($post['email']) && !empty($post['password'])){
				$this->load->model('manager_model');
				$checkUser = $this->manager_model->login($post['email'],md5($post['password']));
				if(count($checkUser)>0){
					$this->session->set_userdata("manager",$checkUser);
					redirect('manager/start');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong email and password.</div>');
					redirect('manager/login');
				}
			}  else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Username and password cannot be blank</div>');
				redirect('manager/login');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Please login first.</div>');
			redirect('manager/login');
		}		
	}
	
	function activate($key=null){
		if($key!=null){
			$this->load->model('outsource_model');
			$checkActivationCode = $this->outsource_model->checkUserActivationCode($key);
			if(count($checkActivationCode)>0){
				$data = $this->outsource_model->updateProfile(array('activation_code'=>'','status'=>0),$checkActivationCode->id);
				if($data>0){
					$this->session->set_flashdata('message', '<div class="alert alert-info">Please login.</div>');
					redirect('outsource/login');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong page.</div>');
					redirect('outsource/login');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong page.</div>');
				redirect('outsource/login');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong page.</div>');
			redirect('outsource/login');
		}
	}
}
/* End of file dataentry.php */
/* Location: ./application/controllers/outsource/login.php */