<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Outsource_Login extends CI_Controller {

	public function __construct(){		
		parent::__construct();
		if ( $this->session->userdata('miner')){
				redirect('outsource/datasource');
		}
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));		
	}

	function index(){
		$this->layout->auto_render=false;	
		$this->layout->layout='outsource';		
		$this->layout->render('outsource/dataentry/login');
	}
	function login(){
		$post = $this->input->post('login');
		if(count($post)>0){
			if(!empty($post['email']) && !empty($post['password'])){
				$this->load->model('outsource_model');
				$checkUser = $this->outsource_model->login($post['email'],md5($post['password']));
				if(count($checkUser)>0){
					if((int)$checkUser->status==0 && (int)$checkUser->block==0){
						$this->session->set_userdata("miner",$checkUser);
						redirect('outsource/dataentry/start');
					} else {
						if((int)$checkUser->block==1){
							$this->session->set_flashdata('message', '<div class="alert alert-danger">Due to excessive number of incorrect data you provided, your account is suspended for 45 days.</div>');							
						} else {
							$activation_code = md5('~'.$checkUser->email.'~'.$checkUser->password);
							$this->outsource_model->updateProfile(array("activation_code"=>$activation_code),$checkUser->id);
							$this->session->set_flashdata('message', '<div class="alert alert-danger">We cannot let you in before you activate your account. <a href="javascript://" data-cp="'.$activation_code.'" onclick="resendActivationCode(jQuery(this));">Resend activation email</a></div>');							
						}
						redirect('outsource/login');
					}					
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong email and password.</div>');
					redirect('outsource/login');
				}
			}  else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Username and password cannot be blank</div>');
				redirect('outsource/login');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Please login first.</div>');
			redirect('outsource/login');
		}		
	}
	
	function resend_activation_code(){
		$data = "We cannot resend you an activation email. Please send email to info@datafills.com";
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('outsource_model');
			$checkActivationCode = $this->outsource_model->checkUserActivationCode($this->input->post('cp'));
			if(count($checkActivationCode)>0){
				$this->config->load('config');
				$url = $this->config->item('base_url'); 
				$domain = "sandbox16993e3c0bb4463c806e1bc5d0e80167.mailgun.org";
				$ch = curl_init();
				$message = "<html><body>".$checkActivationCode->first_name." ".$checkActivationCode->last_name.",<br/> Please click the following link to activate your account:<br/><a href='".$url."outsource/activate/".$checkActivationCode->activation_code."' target='_BLANK'>".$url."outsource/activate/".$checkActivationCode->activation_code."</a><br/>DataFills</body></html>";
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, 'api:key-3cf64d493227e4799da49c3d32bcdfd0');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				$plain = strip_tags(nl2br($message));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
				curl_setopt($ch, CURLOPT_POSTFIELDS, array('from'    => 'DataFills <postmaster@sandbox16993e3c0bb4463c806e1bc5d0e80167.mailgun.org>',
					'to' => $checkActivationCode->email,
					'subject' => "Activate your account @DataFills",
					'text' => $plain,'html'=>$message));
				$j = json_decode(curl_exec($ch));
				$info = curl_getinfo($ch);
				curl_close($ch);
				if($info['http_code'] == 200){	
					$data = "We just resend you an activation email. Please check your email and activate your account.";
				} 
			}
		}
		echo $data;
		die;
	}
	
	function register(){
		$post = $this->input->post('register');
		if(count($post)>0){
			$this->load->library('Recaptcha');			
			$reCaptcha = new Recaptcha();
			$responsePost = $this->input->post('g-recaptcha-response');
			$response = $reCaptcha->verifyResponse($_SERVER["REMOTE_ADDR"],$responsePost);			
			if($response!=null && (int)$response->success==1  && empty($response->errorCodes)):
			if($post['password']==$post['password2']){
				if(!empty($post['email'])){
					$this->load->model('outsource_model');
					$checkUser = $this->outsource_model->checkUserEmail($post['email']);
					if(count($checkUser)==0){
						unset($post['password2']);						
						/*unset($post['captcha']);	*/					
						$post['password'] = md5($post['password']);
						$post['created'] = date('Y-m-d H:i:s');
						$post['status'] = 1;
						$post['activation_code'] = md5('~'.$post['email'].'~'.$post['password']);
						$data = $this->outsource_model->insertUser($post);
						if($data>0){
							/*Send an email*/
							$this->config->load('config');
							$url = $this->config->item('base_url'); 
							$domain = "sandbox16993e3c0bb4463c806e1bc5d0e80167.mailgun.org";
							$ch = curl_init();
							$message = "<html><body>".$post['first_name']." ".$post['last_name'].",<br/> Please click the following link to activate your account:<br/><a href='".$url."outsource/activate/".$post['activation_code']."' target='_BLANK'>".$url."outsource/activate/".$post['activation_code']."</a><br/>DataFills</body></html>";
							curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
							curl_setopt($ch, CURLOPT_USERPWD, 'api:key-3cf64d493227e4799da49c3d32bcdfd0');
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
							$plain = strip_tags(nl2br($message));
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
							curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
							curl_setopt($ch, CURLOPT_POSTFIELDS, array('from'    => 'DataFills <postmaster@sandbox16993e3c0bb4463c806e1bc5d0e80167.mailgun.org>',
								'to' => $post['email'],
								'subject' => "Activate your account @DataFills",
								'text' => $plain,'html'=>$message));
							$j = json_decode(curl_exec($ch));
							$info = curl_getinfo($ch);
							curl_close($ch);
							if($info['http_code'] == 200){	
								$this->session->set_flashdata('message', '<div class="alert alert-success">We just sent you an activation email. Please check your email and activate your account.</div>');
								redirect('outsource/login');
							} else {
								$this->session->set_flashdata('message', '<div class="alert alert-danger">Please call to customer care.</div>');
								redirect('outsource/login');
							}
						}
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger">This email address is already in use, please use another.</div>');
						$this->session->set_flashdata('post_data', $post);
						redirect('outsource/login');
					}					
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Email address cannot be empty.</div>');
					$this->session->set_flashdata('post_data', $post);
					redirect('outsource/login');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Password wasn\'t matched.</div>');
				$this->session->set_flashdata('post_data', $post);
				redirect('outsource/login');
			}
			else:
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Please correct your captcha entry.</div>');
			$this->session->set_flashdata('post_data', $post);
			redirect('outsource/login');
			endif;
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong page.</div>');
			redirect('outsource/login');
		}
	}
	
	function forget(){
		$post = $this->input->post('forget');
		if(count($post)>0){
			if(!empty($post['email'])){
					$this->load->model('outsource_model');
					$checkUser = $this->outsource_model->checkUserEmail($post['email']);
					if(count($checkUser)>0){
						$activation_code = md5('~'.$post['email'].'~'.time());
						$update = $this->outsource_model->updateProfile(array('activation_code'=>$activation_code),$checkUser->id);
						if($update>0){
							$this->config->load('config');
							$url = $this->config->item('base_url'); 
							$domain = "sandbox16993e3c0bb4463c806e1bc5d0e80167.mailgun.org";
							$ch = curl_init();
							$message = "<html><body>To initiate the password reset process for your <br/>".$post['email']." DataFills Account,<br/> click the link below:<br/><a href='".$url."outsource/request/".$activation_code."' target='_BLANK'>".$url."outsource/request/".$activation_code."</a><br/>DataFills</body></html>";
							curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
							curl_setopt($ch, CURLOPT_USERPWD, 'api:key-3cf64d493227e4799da49c3d32bcdfd0');
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
							$plain = strip_tags(nl2br($message));
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
							curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/'.$domain.'/messages');
							curl_setopt($ch, CURLOPT_POSTFIELDS, array('from'    => 'DataFills <postmaster@sandbox16993e3c0bb4463c806e1bc5d0e80167.mailgun.org>',
								'to' => $post['email'],
								'subject' => "DataFills Password Assistance",
								'text' => $plain,'html'=>$message));
							$j = json_decode(curl_exec($ch));
							$info = curl_getinfo($ch);
							curl_close($ch);
							if($info['http_code'] == 200){	
								$this->session->set_flashdata('message', '<div class="alert alert-success">We just sent you an change password email. Please check your email and update your password.</div>');
								redirect('outsource/login');
							} else {
								$this->session->set_flashdata('message', '<div class="alert alert-danger">Please call to customer care.</div>');
								redirect('outsource/login');
							}
						} else {
							$this->session->set_flashdata('message', '<div class="alert alert-danger">Please call to customer care.</div>');
							redirect('outsource/login');
						}
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong email address.</div>');
						redirect('outsource/login');
					}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Email address cannot be empty.</div>');
				redirect('outsource/login');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong page.</div>');
			redirect('outsource/login');
		}
	}
	
	function change_password(){
		$post = $this->input->post('request');
		if(count($post)>0){
			if($post['password']==$post['password2']){
				$this->load->model('outsource_model');
				$checkActivationCode = $this->outsource_model->checkUserActivationCode($post['key']);
				if(count($checkActivationCode)>0){
					$update = $this->outsource_model->updateProfile(array('activation_code'=>'','password'=>md5($post['password'])),$checkActivationCode->id);
					if($update>0){
						$this->session->set_flashdata('message', '<div class="alert alert-info">Your password changed. Please login.</div>');
						redirect('outsource/login');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger">Please call to customer care.</div>');
						redirect('outsource/login');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong page.</div>');
					redirect('outsource/login');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Password wasn\'t matched.</div>');
				redirect('outsource/login');
			}
		}else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong page.</div>');
			redirect('outsource/login');
		}
	}
	
	function request($key=null){
		if($key!=null){
			$this->load->model('outsource_model');
			$checkActivationCode = $this->outsource_model->checkUserActivationCode($key);
			if(count($checkActivationCode)>0){
				$data['key'] = $key;
				$this->layout->auto_render=false;	
				$this->layout->layout='outsource';		
				$this->layout->render('outsource/dataentry/change_password',$data);
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong page.</div>');
				redirect('outsource/login');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong page.</div>');
			redirect('outsource/login');
		}
	}
	
	function activate($key=null){
		if($key!=null){
			$this->load->model('outsource_model');
			$checkActivationCode = $this->outsource_model->checkUserActivationCode($key);
			if(count($checkActivationCode)>0){
				$data = $this->outsource_model->updateProfile(array('activation_code'=>'','status'=>0),$checkActivationCode->id);
				if($data>0){
					$this->session->set_flashdata('message', '<div class="alert alert-info">Your account is activated.Please login.</div>');
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