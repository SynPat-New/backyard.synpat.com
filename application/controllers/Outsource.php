<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Outsource extends CI_Controller {

	public function __construct(){
		parent::__construct();	
		$this->layout->auto_render=false;
		$this->layout->layout='outsource';
	}
	
	public function comparables(){
		$data = array();
		$this->layout->layout='outsource';
		$this->layout->title_for_layout = 'Comparables';
		$this->layout->render('outsource/comparables',$data);
	}
	
	public function save(){
		$data = array('update'=>0);
		if(isset($_POST)){
			$this->load->model('lead_model');
			$postData = $this->input->post();
			$name = $postData['agreement_url'];
			$fileType = strtolower(pathinfo($name,PATHINFO_EXTENSION));
			$name = pathinfo($name,PATHINFO_FILENAME);
			if(isset($postData['masked'])){
				if($postData['masked'] == "yes"){
					$postData['masked'] = 1;
				} else {
					$postData['masked'] = 0;
				}
			}
			$fileName = $name.".".$fileType;
			$target_dir = "/var/www/synpat/backyard/public/upload/agreements/";
			$target_file = $target_dir.$fileName;
			$content = "";
			if(file_exists($target_file)){
				$content = file_get_contents($target_file);
			}
			$postData['agreement_string'] = $content;
			$postData['agreement_url'] = $fileName;
			$postData['created_date'] = date('Y-m-d H:i:s');
			$checkFileUrl = $this->lead_model->checkAgreementFile($postData['agreement_url']);
			if(count($checkFileUrl) == 0){
				$data['update'] = $this->lead_model->insertAgreements($postData);
			} else {
				unset($postData['created_date']);
				$data['update'] = $this->lead_model->updateAgreements($checkFileUrl->id,$postData);
			}
		}
		echo json_encode($data);
		die;
	}
	public function upload_file_url(){
		$data = array('file_url'=>'','message'=>'');
		if(isset($_POST)){
			$url = $this->input->post('url');
			if($url != ""){
				$fileType = strtolower(pathinfo($url,PATHINFO_EXTENSION));
				$name = pathinfo($url,PATHINFO_FILENAME);
				$target_dir = "/var/www/synpat/backyard/public/upload/agreements/";
				$fileName = $name.".".$fileType;
				$this->load->model('lead_model');
				$checkFileUrl = $this->lead_model->checkAgreementFile($fileName);
				if(count($checkFileUrl) == 0){
					$target_file = $target_dir.$fileName;
					if(file_exists($target_file)){
						unlink($target_file);
					}
					copy($url, $target_file);
					if(file_exists($target_file)){
						$data['file_url'] = "https://backyard.synpat.com/public/upload/agreements/".$fileName;
					}
				} else {
					$data['message'] = 'This agreement is already in our system.';
					unset($checkFileUrl->agreement_string);
					$data['data'] = $checkFileUrl;
				}				
			}
		}
		echo json_encode($data);
		die;
	}
	public function upload_document(){
		$data = array('file_url'=>'','message'=>'');
		if(isset($_FILES)){
			$fileName = $_FILES['file']['name'];
			$fileType = $_FILES['file']['type'];
			$fileError = $_FILES['file']['error'];
			$fileContent = file_get_contents($_FILES['file']['tmp_name']);
			if($fileError == UPLOAD_ERR_OK){
			   //Processes your file here
			   if(strpos(strtolower($fileName),'pdf')!==false){
				    $target_dir = "/var/www/synpat/backyard/public/upload/agreements/";
				    $fileName = basename($_FILES["file"]["name"]);
					$this->load->model('lead_model');
					$checkFileUrl = $this->lead_model->checkAgreementFile($fileName);
					if(count($checkFileUrl) == 0){
						$target_file = $target_dir .$fileName ;
						try{
							if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
								$data['file_url'] = "https://backyard.synpat.com/public/upload/agreements/".$fileName;
							} 
						}catch(Exception $e){
							$data['message'] = "Error while uploading file";
						}
					} else {
						$data['message'] = 'This agreement is already in our system.';
					}					
			   } else {
					$error = true;
					$data['message'] = "File extension should be .pdf only"; 
			   }
			} else{
				$error = true;
				$data['message'] = "Failed to upload file";
			}
		}
		echo json_encode($data);
		die;
	}
}
/* Location: ./application/controllers/outsource.php */