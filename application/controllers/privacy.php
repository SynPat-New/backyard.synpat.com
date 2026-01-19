<?php 
	
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Privacy extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->library('layout');
		}
		
		public function index(){
			$this->layout->auto_render=false;	
			$this->layout->layout='privacy';
			$this->layout->title_for_layout = 'Privacy';
			$this->layout->render('privacy');
		}
		
		public function terms(){
			$this->layout->auto_render=false;	
			$this->layout->layout='privacy';
			$this->layout->title_for_layout = 'Terms';
			$this->layout->render('terms');
		}
	}

/* End of file privacy.php */
/* Location: ./application/controllers/privacy.php */