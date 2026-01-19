<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Partners extends CI_Controller {

	public function __construct(){		
		/*header("Access-Control-Allow-Headers: X-API-KEY, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");*/
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
		parent::__construct();
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));		
	}
	private function sort_array_of_array(&$array, $subfield){
		$sortarray = array();
		foreach ($array as $key => $row)
		{
			$sortarray[$key] = $row[$subfield];
		}

		array_multisort($sortarray, SORT_ASC, $array);
	}
	
	private function findIndex($array,$findValue){
		$findArray = array();
		foreach($array as $list){
			if($list->id == $findValue){
				array_push($findArray,$list);
				break;
			}
		}
		return $findArray;
	}
	
	private function findUpdateBankAxis($startIndex,$list,$start){
		$bankIndex = array();
		$companyIndex = array();
		$max = -1;
		if(isset($list[$startIndex])){
			$yAxis = 0;
			for($i=$startIndex;$i<count($list);$i++){
				if($i == $startIndex){
					$yAxis = $list[$i]->y_axis;
				}
				if($list[$i]->y_axis == $yAxis) {
					if(strpos(strtolower($list[$i]->description),"security interest") !== false && strpos(strtolower($list[$i]->description),"release") === false) {
						array_push($bankIndex,$i);
					} else {
						array_push($companyIndex,$i);
					}
				} else {
					break;
				}
			}		
			$constantValue = 220;
			if(count($bankIndex) > 0 && count($companyIndex) == 0) {
				$s = 0;			
				foreach($bankIndex as $bIndex) {
					$xAxis = 290;
					if($s > 0) {
						$xAxis = $list[$bIndex-1]->x_axis + $constantValue;
					}
					if((int)$xAxis > 0) {
						$list[$bIndex]->old_x_axis = $list[$bIndex]->x_axis;
						$list[$bIndex]->x_axis = $xAxis;
					}
					$s++;
				}
				$max = max($bankIndex);
			} else if(count($bankIndex) > 0 && count($companyIndex) > 0) {
				$allC = array_merge($bankIndex,$companyIndex);
				$max = max($allC);
				if($start === false) {
					if(in_array($startIndex,$companyIndex)){
						$intialX =$list[$startIndex]->x_axis;
						$st = 0;
						foreach($companyIndex as $bIndex) {
							$intialX +=$constantValue;
							$list[$bIndex]->old_x_axis = $list[$bIndex]->x_axis;
							$list[$bIndex]->x_axis = $intialX;
							if($st>0) {
								$list[$bIndex]->same = true;
							} else {
								$list[$bIndex]->same = false;
							}
							$st++;
						}
						foreach($bankIndex as $bIndex) {
							$intialX +=$constantValue;
							$list[$bIndex]->same = true;
							$list[$bIndex]->old_x_axis = $list[$bIndex]->x_axis;
							$list[$bIndex]->x_axis = $intialX;
						}
					}
					
				} else {
					if(in_array($startIndex,$bankIndex)){
						$intialX =$list[$startIndex]->x_axis;
						$st = 0;
						foreach($companyIndex as $bIndex) {		
							$list[$bIndex]->old_x_axis = $list[$bIndex]->x_axis;
							$list[$bIndex]->x_axis = $intialX;
							$intialX +=$constantValue;
							if($st>0) {
								$list[$bIndex]->same = true;
							}else {
								$list[$bIndex]->same = false;
							}
							$st++;
						}
						foreach($bankIndex as $bIndex) {
							$list[$bIndex]->same = true;
							$list[$bIndex]->old_x_axis = $list[$bIndex]->x_axis;
							$list[$bIndex]->x_axis = $intialX;
							$intialX +=$constantValue;
						}
					}
				}
			}
			if($max == -1){
				$max = $startIndex;
			}		
			return array('list'=>$list,'max'=>$max);
		}
		
	}	
	/*
	public function assignment_reel_data($patentNumber = null){
		$data = array('box'=>array(),'connection'=>array(),'popup'=>array(),'assignments'=>array(),'names'=>array());
		if($patentNumber != null) {
			switch(strlen($patentNumber)){
				case 9:
					$patentNumber =substr($patentNumber,2);
				break;
				case 11:
				case 13:
					$patentNumber =substr($patentNumber,2);
					$patentNumber =substr($patentNumber,0,-2);
				break;
				default:
					$patentNumber = $patentNumber;
				break;
			}
			$this->load->model('lead_model');
			$family_data = $this->lead_model->findAssignmentFamily($patentNumber);
			$assignmentList = $family_data['all_assignment'];
			if(count($assignmentList) > 0) {
				for($i=0;$i<count($assignmentList);$i++) {
					$modified = preg_replace("/\"/","",$assignmentList[$i]->modified);
					$original = preg_replace("/\"/","",$assignmentList[$i]->original);
					$assignmentList[$i]->modified = $modified;
					$assignmentList[$i]->original = $original;
				}
			}
			$data['assignments'] = $assignmentList;
			$data['names'] = $family_data['all_names'];
			if(count($family_data['list'])>0){ 
				for($i=0;$i<count($family_data['list']);$i++){
					$type = "";
					if($family_data['list'][$i]->type == 0){
						$type = "Inventor";
					} else if($family_data['list'][$i]->type == 2){
						$type = "3rdParties";
					} else {
						if(strpos(strtolower($family_data['list'][$i]->description),'assignment of assignors interest') !== false){
							$type = "Ownership";
						} else if(strpos(strtolower($family_data['list'][$i]->description),'change of name') !== false){
							$type = "ChangeOfName";
						} else if(strpos(strtolower($family_data['list'][$i]->description),'security interest') !== false || strpos(strtolower($family_data['list'][$i]->description),'security agreement') !== false){
							$type = "Security";							
						} else if(strpos(strtolower($family_data['list'][$i]->description),'license') !== false){
							$type = "License";
						}
					}
					$boxArray = array('id'=>$family_data['list'][$i]->id,'name'=>$family_data['list'][$i]->name,'execution_date'=>date('M d,Y',strtotime($family_data['list'][$i]->execution_date)),'recorded_date'=>date('M d,Y',strtotime($family_data['list'][$i]->recorded)),'document'=>$family_data['list'][$i]->document_file,'type'=>$type,'date'=>strtotime($family_data['list'][$i]->execution_date));
					if($type === "3rdParties") {
						$boxArray['execution_date'] = '';
						$boxArray['recorded_date'] = '';
					}
					array_push($data['box'],$boxArray);
				}
			}
			$jsonRelations = $family_data['relation'];
			foreach($jsonRelations as $relation){		
				if($relation->connection_type == 2) {			
					$parentID = $relation->parent_id;
					$childID = $relation->child_id;
					$parentData = $this->findIndex($family_data['list'],$childID);
					if(count($parentData) == 1){
						$childData = $this->findIndex($family_data['list'],$parentID);
						if(count($childData) == 1) {			
							$pRelation = array();
							foreach($jsonRelations as $r){
								if($r->parent_id == $childID && $r->child_id == $parentID) {
									$pRelation = $r;
									break;
								}
							}	
							if(count($pRelation) >0 ) {
								$pRelation->parent_name = $parentData[0]->name;
								$pRelation->child_name = $childData[0]->name;
								$jsonRelations[$re]->org_relation = $pRelation;
							}
						}
					}
				}
				$re++;
			}
			$jsRIncrement = 0;
			foreach($jsonRelations as $relation){		
				if((int)$relation->connection_type == 2) {			
					if(isset($relation->org_relation)) {
						$jsonRelations[$jsRIncrement]->reverse = true;
						$jsonRelations[$jsRIncrement]->reverse_frame = $relation->org_relation->frame;
						$jsonRelations[$jsRIncrement]->reverse_reel = $relation->org_relation->reel;
						$jsonRelations[$jsRIncrement]->reff_id = $relation->org_relation->id;
						$jsonRelations[$jsRIncrement]->assignment_no2 = $relation->org_relation->assignment_no;
					}
				}
				$jsRIncrement++;
			}
			if(count($jsonRelations)>0){
				foreach($jsonRelations as $relation){
					$pouptop = $relation->reel.'-'.$relation->frame;
					$assignment_no1 = $relation->assignment_no;
					$poupbottom = "";
					$reffID = 0;
					$assignment_no2 = 0;
					if(isset($relation->reverse) && $relation->reverse === true) {
						$poupbottom = $relation->reverse_reel.'-'.$relation->reverse_frame;
						$reffID = $relation->reff_id;
						$assignment_no2 = $relation->assignment_no2;
					}
					$type = "";
					if(strpos(strtolower($relation->description),'assignment of assignors interest') !== false){
						$type = "Ownership";
					} else if(strpos(strtolower($relation->description),'change of name') !== false){
						$type = "ChangeOfName";
					} else if(strpos(strtolower($relation->description),'security interest') !== false || strpos(strtolower($relation->description),'secured party') !== false){
						if(strpos(strtolower($relation->description),'release') !== false) {
							$type = "Release";		
						} else {
							$type = "Security";		
						}											
					} else if(strpos(strtolower($relation->description),'license') !== false){
						if(strpos(strtolower($relation->description),'expiration') !== false) {
							$type = "LicenseCancellation";		
						} else {
							$type = "License";
						}
					}
					array_push($data['connection'],array('id'=>$relation->id,'date'=>date('M d,Y',strtotime($relation->date)),'start_id'=>$relation->parent_id,'end_id'=>$relation->child_id,'popuptop'=>$pouptop,'popupbottom'=>$poupbottom,'type'=>$type,'ref_id'=>$reffID,'assignment_no1'=>$assignment_no1,'assignment_no2'=>$assignment_no2,'date_1'=>strtotime($relation->date)));
				}				 
			}
			$file = file_get_contents("/var/www/synpat/backyard/public/upload/".$patentNumber.".json");
			if($file != "") {
				try{
					$docs = json_decode($file);
					if(isset($docs->response)) {
						if($docs->response->numFound > 0) {
							$data['popup'] = $docs->response->docs;
						}
					}
				}catch(Exception $e) {					
				}
			}
		}
	
		echo json_encode($data);
		die;
	}*/
	
	function findConnectionTo($patentNumber,$assignmentNo){
		$this->load->model('lead_model');
		$getConnectionData = $this->lead_model->findAssignmentRelations($patentNumber,$assignmentNo);
	}
	
	function findBoxData($all_boxes,$box_type){
		$boxArray = array();
		if(count($all_boxes) > 0){
			foreach($all_boxes as $box){
				if($box->id == $box_type){
					array_push($boxArray,$box);
					break;
				}
			}
		}
		return $boxArray;
	}
	
	public function assignment_reel_data($patentNumber = null){
		$data = array('box'=>array(),'inventor_boxes'=>array(),'connection'=>array(),'popup'=>array(),'assignments'=>array(),'names'=>array());
		if($patentNumber != null) {
			switch(strlen($patentNumber)){
				case 9:
					$patentNumber =substr($patentNumber,2);
				break;
				case 11:
				case 13:
					$patentNumber =substr($patentNumber,2);
					$patentNumber =substr($patentNumber,0,-2);
				break;
				default:
					$patentNumber = $patentNumber;
				break;
			}
			$this->load->model('lead_model');
			$family_data = $this->lead_model->findAssignmentFamily($patentNumber);
			$assignmentList = $family_data['all_assignment'];
			if(count($assignmentList) > 0) {
				for($i=0;$i<count($assignmentList);$i++) {
					$modified = preg_replace("/\"/","",$assignmentList[$i]->modified);
					$original = preg_replace("/\"/","",$assignmentList[$i]->original);
					$assignmentList[$i]->modified = $modified;
					$assignmentList[$i]->original = $original;
				}
			}
			$data['assignments'] = $assignmentList;
			$data['names'] = $family_data['all_names'];
			$data['legend'] = $family_data['assignment_type_list'];
			$all_boxes = $family_data['all_boxes'];
			$data['all_boxes'] = $all_boxes;
			$data['inventor_boxes'] = $family_data['inventor_boxes'];
			if(count($family_data['inventor_boxes'])>0){ 
				$data['box'] = $family_data['inventor_boxes'];
			}
			unset($data['inventor_boxes']);
			if(count($family_data['other_boxes'])>0){ 
				for($i=0;$i<count($family_data['other_boxes']);$i++){
					$type = "";
					if($family_data['other_boxes'][$i]->type == 2){
						$type = "3rdParties";
					} else {
						$type = $family_data['other_boxes'][$i]->description;
						/*if(strpos(strtolower($family_data['other_boxes'][$i]->description),'assignment of assignors interest') !== false){
							$type = "Ownership";
						} else if(strpos(strtolower($family_data['other_boxes'][$i]->description),'partial ownership') !== false){
						$type = "PartialOwnership";
						}  else if(strpos(strtolower($family_data['other_boxes'][$i]->description),'change of name') !== false){
							$type = "ChangeOfName";
						} else if(strpos(strtolower($family_data['other_boxes'][$i]->description),'security interest') !== false || strpos(strtolower($family_data['other_boxes'][$i]->description),'security agreement') !== false){
							$type = "Security";							
						} else if(strpos(strtolower($family_data['other_boxes'][$i]->description),'license') !== false){
							$type = "License";
						}*/
					}
					$recordedDate = "";
					$executionDate = "";
					if($family_data['other_boxes'][$i]->execution_date != "0000-00-00"){
						$executionDate = date('M d,Y',strtotime($family_data['other_boxes'][$i]->execution_date));
					}					
					if($family_data['other_boxes'][$i]->recorded != "0000-00-00"){
						$recordedDate = date('M d,Y',strtotime($family_data['other_boxes'][$i]->recorded));
					}	
					$boxArray = array('id'=>$family_data['other_boxes'][$i]->id,'name'=>$family_data['other_boxes'][$i]->name,'execution_date'=>$executionDate,'recorded_date'=>$recordedDate,'document'=>$family_data['other_boxes'][$i]->document_file,'type'=>$type,'date_1'=>strtotime($family_data['other_boxes'][$i]->date_1),'box_type'=>$family_data['other_boxes'][$i]->box_type);
					if($type === "3rdParties") {
						$boxArray['execution_date'] = '';
						$boxArray['recorded_date'] = '';
					}
					array_push($data['box'],$boxArray);
				}
			}
			if(count($data['box']) > 0){
				for($b=0;$b<count($data['box']);$b++){
					$boxType = -1;
					if(is_array($data['box'][$b])){
						$boxType = $data['box'][$b]['box_type'];
					} else {
						$boxType = $data['box'][$b]->box_type;
					}
					if($boxType >= 0){
						$findBoxData = $this->findBoxData($all_boxes,$boxType);
						if(count($findBoxData) > 0){
							if(is_array($data['box'][$b])){
								$data['box'][$b]['shape'] = $findBoxData[0]->shape;
								$data['box'][$b]['dimension'] = $findBoxData[0]->dimension;
								$data['box'][$b]['segment'] = $findBoxData[0]->segment;
								$data['box'][$b]['border_color'] = $findBoxData[0]->border_color;
								$data['box'][$b]['border_linepx'] = $findBoxData[0]->border_px;
								$data['box'][$b]['background_color'] = $findBoxData[0]->background_color;
							} else {
								$data['box'][$b]->shape = $findBoxData[0]->shape;
								$data['box'][$b]->dimension = $findBoxData[0]->dimension;
								$data['box'][$b]->segment = $findBoxData[0]->segment;
								$data['box'][$b]->border_color = $findBoxData[0]->border_color;
								$data['box'][$b]->border_linepx = $findBoxData[0]->border_px;
								$data['box'][$b]->background_color = $findBoxData[0]->background_color;
							}
						}
					}
				}
			}
			$jsonRelations = $family_data['relation'];
			foreach($jsonRelations as $relation){		
				if($relation->connection_type == 2) {			
					$parentID = $relation->parent_id;
					$childID = $relation->child_id;
					$pRelation = array();
					$getConnectionTo = $this->findConnectionTo($patentNumber,$relation->assignment_no);
					if(count($getConnectionTo) > 0){
						foreach($getConnectionTo as $connection){
							if($connection->parent_id == $childID && $connection->child_id == $parentID) {
								$pRelation = $connection;
								break;
							}
						}
					} else {
						$parentData = $this->findIndex($family_data['list'],$childID);
						if(count($parentData) == 1){
							$childData = $this->findIndex($family_data['list'],$parentID);
							if(count($childData) == 1) {
								foreach($jsonRelations as $r){
									if($r->parent_id == $childID && $r->child_id == $parentID) {
										$pRelation = $r;
										break;
									}
								}
							}
						}
					}					
					if(count($pRelation) >0 ) {
						$pRelation->parent_name = $parentData[0]->name;
						$pRelation->child_name = $childData[0]->name;
						$jsonRelations[$re]->org_relation = $pRelation;
					}
				}
				$re++;
			}
			$jsRIncrement = 0;
			foreach($jsonRelations as $relation){		
				if((int)$relation->connection_type == 2) {			
					if(isset($relation->org_relation)) {
						$jsonRelations[$jsRIncrement]->reverse = true;
						$jsonRelations[$jsRIncrement]->reverse_frame = $relation->org_relation->frame;
						$jsonRelations[$jsRIncrement]->reverse_reel = $relation->org_relation->reel;
						$jsonRelations[$jsRIncrement]->reff_id = $relation->org_relation->id;
						$jsonRelations[$jsRIncrement]->assignment_no2 = $relation->org_relation->assignment_no;
						$jsonRelations[$jsRIncrement]->note2 = $relation->org_relation->note;
						$jsonRelations[$jsRIncrement]->note_file2 = $relation->org_relation->note_file;
						
					}
				}
				$jsRIncrement++;
			}
			if(count($jsonRelations)>0){
				foreach($jsonRelations as $relation){
					$pouptop = $relation->reel.'-'.$relation->frame;
					$assignment_no1 = $relation->assignment_no;
					$poupbottom = "";
					$reffID = 0;
					$assignment_no2 = 0;
					$document1 = "";
					$document2 = "";
					$note1 = $relation->note;
					$note2 = "";
					$noteFile1 = $relation->note_file;
					if($note1 == null){
						$note1 = "";
					}
					if($noteFile1 == null){
						$noteFile1 = "";
					}
					$noteFile2 = "";
					$fileName = "public/upload/assignment-pat-".$pouptop.".pdf";
					if(file_exists($fileName)){
						$document1 = "https://backyard.synpat.com/".$fileName;
					}
					if(isset($relation->reverse) && $relation->reverse === true) {
						$poupbottom = $relation->reverse_reel.'-'.$relation->reverse_frame;
						$reffID = $relation->reff_id;
						$assignment_no2 = $relation->assignment_no2;
						$note2 = $relation->note2;
						$noteFile2 = $relation->note_file2;
						$fileName = "public/upload/assignment-pat-".$poupbottom.".pdf";
						if(file_exists($fileName)){
							$document2 = "https://backyard.synpat.com/".$fileName;
						}
					}
					$type = $relation->description;
					$lineType = $relation->line_type;
					$popup = array();
					$comments = array();
					if($pouptop != ""){
						array_push($popup,$pouptop);
						$noteArray = array();
						array_push($noteArray,$note1);
						array_push($noteArray,'');
						$com = array();
						$com[$pouptop] = $noteArray ;
						array_push($comments,$com);
					}
					if($poupbottom != ""){
						array_push($popup,$poupbottom);
						$noteArray = array();
						array_push($noteArray,$note2);
						array_push($noteArray,'');
						$com = array();
						$com[$poupbottom] = $noteArray ;
						array_push($comments,$com);
					}
					$findLineColorType = $this->findLineColorType($lineType,$data['legend']);
					$userFiles = array();
					array_push($userFiles,$noteFile1);
					if($poupbottom != ""){
						array_push($userFiles,$noteFile2);
					}
					$typeLine = "";
					if($findLineColorType['line_type'] == 0){
						$typeLine = "Solid";
					}else if($findLineColorType['line_type'] == 1){
						$typeLine = "Dashed";
					}
					array_push($data['connection'],array('id'=>$relation->id,'assignment_no1'=>$assignment_no1,'assignment_no2'=>$assignment_no2,'color'=>$findLineColorType['color'],'type'=>$type,'type_line'=>$typeLine,'ref_id'=>$reffID,'start_id'=>$relation->parent_id,'end_id'=>$relation->child_id,'popup'=>$popup,'comment'=>$comments,'user_files'=>$userFiles,'tooltip'=>$findLineColorType['tooltip'],'date'=>date('M d,Y',strtotime($relation->date)),'date_1'=>strtotime($relation->date),'document1'=>$document1,'document2'=>$document2,'note1'=>$note1,'pdf1'=>$noteFile1,'note2'=>$note2,'pdf2'=>$noteFile2,'popuptop'=>$pouptop,'popupbottom'=>$poupbottom));
				}				 
			}
			$file = file_get_contents("/var/www/synpat/backyard/public/upload/".$patentNumber.".json");
			if($file != "") {
				try{
					$docs = json_decode($file);
					if(isset($docs->response)) {
						if($docs->response->numFound > 0) {
							$data['popup'] = $docs->response->docs;
						}
					}
				}catch(Exception $e) {					
				}
			}
			/*if($file != "") {
				try{
					$docs = json_decode($file);
					if(isset($docs->response)) {
						if($docs->response->numFound > 0) {
							$assignmentList = $docs->response->docs;
							$patentIndex = -1;
							for($a = count($assignmentList)-1;$a >= 0; $a--) {
								$popupData = (array)$assignmentList[$a];
								if($patentIndex < 0) {
									$patentNumberList = $popupData['patNum'];
									$patentIndex = array_search($patentNumber,$patentNumberList);
								}
								if($patentIndex >= 0) {
									$popupData['inventionTitle'] = $popupData['inventionTitle'][$patentIndex];
									$popupData['applNum'] = $popupData['applNum'][$patentIndex];
									$popupData['filingDate'] = $popupData['filingDate'][$patentIndex];
									$popupData['intlRegNum'] = $popupData['intlRegNum'][$patentIndex];
									$popupData['inventors'] = $popupData['inventors'][$patentIndex];
									$popupData['issueDate'] = $popupData['issueDate'][$patentIndex];
									$popupData['patNum'] = $popupData['patNum'][$patentIndex];
									$popupData['pctNum'] = $popupData['pctNum'][$patentIndex];
									$popupData['publDate'] = $popupData['publDate'][$patentIndex];
									$popupData['publNum'] = $popupData['publNum'][$patentIndex];
									array_push($data['popup'],$popupData);
								}
							}
						}
					}
				}catch(Exception $e) {					
				}
			}*/
		}
		/*$newArray = array_merge($data['box'],$data['connection']);
		$date = array_column($newArray, 'date_1');
		array_multisort($date, SORT_ASC, $newArray);
		echo "<pre>";
		print_r($newArray);
		
		die;*/
		echo json_encode($data);
		die;
	}
	
	public function findLineColorType($type,$list){
		$data = array('color'=>'','line_type'=>'','tooltip'=>'');
		foreach($list as $line){
			if($line->id == $type){
				$data['color'] = $line->color;
				$data['line_type'] = $line->type;
				$data['tooltip'] = $line->tooltip;
				break;
			}
		}
		return $data;
	}
	
	public function patent_illustration_json($patentNumber = null){
		$this->load->model('lead_model');
		if($patentNumber!=null){
			$data = $this->lead_model->findPatentFamilyChild($patentNumber);
			if(count($data['links'])==0){
				/*Check from real time scrapper*/
				$getData = $this->lead_model->findFromRealTimeScrap($patentNumber);
				if(count($getData['links'])>0){
					$data['links'] = $getData['links'];
					$data['details'] = $getData['details'];
				}
			}
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		die;
	}
	
	
	public function patent_illustration_epo_json($patentNumber = null){
		$this->load->model('lead_model');
		if($patentNumber!=null){
			$data = $this->lead_model->findPatentFamilyChild($patentNumber);
			if(count($data['links'])==0){
				/*Check from real time scrapper*/
				$getData = $this->lead_model->findFromRealTimeEPO($patentNumber);
				if(count($getData['links'])>0){
					$data['links'] = $getData['links'];
					$data['details'] = $getData['details'];
				}
			}
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
		die;
	}
	
	public function add_company(){
		$message = "Please try after sometime.";
		$this->load->model('opportunity_model');
		$this->load->model('lead_model');
		$this->load->model('customer_model');
		$getData = $this->input->post();
		if(isset($getData['company']['form_id']) && $getData['company']['form_id']==2 && isset($getData['company']['form_fields_id']) && isset($getData['company']['form_email'])){
			$checkUserData = $this->lead_model->checkUserDataWithIDAndEmail($getData['company']['form_fields_id'],$getData['company']['form_email']);
			if(count($checkUserData)>0){
				$getCompanyDetail = $this->customer_model->getCompanyDataByID((int)$checkUserData->company_id);
				if(count($getCompanyDetail)>0){	
					unset($getData['company']['form_id']);
					unset($getData['company']['form_fields_id']);
					unset($getData['company']['form_email']);
					$this->customer_model->updateCompanyData($getCompanyDetail->id,$getData['company']);
					if($checkUserData->company_id>0){						
						$message = "Data successfully posted.";
						$this->opportunity_model->deleteCustomerTechnologyPreference($checkUserData->company_id,0);
						$addTechnology = array();
						if(isset($getData['preferences']) && is_array($getData['preferences']['technology']) && count($getData['preferences']['technology'])>0){
							foreach($getData['preferences']['technology'] as $tech){
								$addTechnology[] = array("company_id"=>$checkUserData->company_id,"preference_id"=>$tech,"type"=>0);
							}
						}
						if(count($addTechnology)>0){
							$this->opportunity_model->insertCustomerTechnologyPreferenceBulk($addTechnology);
						}
						/*Sub Technology*/
						$this->opportunity_model->deleteCustomerTechnologyPreference($checkUserData->company_id,1);
						$addSubTechnology = array();
						if(isset($getData['preferences']) && isset($getData['preferences']['subtechnology']) && is_array($getData['preferences']['subtechnology']) && count($getData['preferences']['subtechnology'])>0){
							foreach($getData['preferences']['subtechnology'] as $tech){
								$addSubTechnology[] = array("company_id"=>$checkUserData->company_id,"preference_id"=>$tech,"type"=>1);
							}
						}
						if(count($addSubTechnology)>0){
							$this->opportunity_model->insertCustomerTechnologyPreferenceBulk($addSubTechnology);
						}
						/*SubSub Technology*/
						$addSubSubTechnology = array();
						$this->opportunity_model->deleteCustomerTechnologyPreference($checkUserData->company_id,2);
						if(isset($getData['sub']) && isset($getData['sub']['technology']) && is_array($getData['sub']['technology']) && count($getData['sub']['technology'])>0){
							foreach($getData['sub']['technology'] as $tech){
								$addSubSubTechnology[] = array("company_id"=>$checkUserData->company_id,"preference_id"=>$tech,"type"=>2);
							}
						}
						if(count($addSubSubTechnology)>0){
							$this->opportunity_model->insertCustomerTechnologyPreferenceBulk($addSubSubTechnology);
						}
					}
					if(isset($getData['team']['source_data']) && !empty($getData['team']['source_data'])){
						try{
							$sourceData = json_decode($getData['team']['source_data']);
							$getData = json_decode($getData['team']['data']);
							if(count($sourceData)>1){
								$updateData = array();
								$newData = array();
								for($i=0;$i<count($sourceData)-1;$i++){
									$name = $sourceData[$i]->name;
									$title = $sourceData[$i]->title;
									$email = $sourceData[$i]->email;
									$phone = $sourceData[$i]->phone;
									if($phone==null){
										$phone = "";
									}
									$telephone = $sourceData[$i]->telephone;
									if($telephone==null){
										$telephone = "";
									}
									$id = $sourceData[$i]->id;									
									if(!empty($name)){
										$explodeName = explode(' ',$name);
										$firstName = $explodeName[0];
										$secondName = "";
										foreach($explodeName[1]  as $eN){
											$secondName.= $eN." ";
										}
										if($id!="" && (int)$id>0){											
											$updateData[] = array('id'=>$id,'first_name'=>$firstName,'last_name'=>trim($secondName),'job_title'=>$title,'email'=>$email,'phone'=>$phone,'telephone'=>$telephone);
										} else {
											$newData[] = array('first_name'=>$firstName,'last_name'=>trim($secondName),'job_title'=>$title,'email'=>$email,'phone'=>$phone,'telephone'=>$telephone,'company_id'=>$checkUserData->company_id);
										}
									}
								}
								$updateBulk = false;
								$insertID = 0;
								/*Update bluk*/
								if(count($updateData)>0){
									$updateBulk = $this->opportunity_model->updatePartnerTeamBatch($updateData);
								}
								/*Add Bulk*/
								if(count($newData)>0){
									$insertID =	$this->opportunity_model->insertPartnerTeamBatch($newData);
								}
							}
							if(count($getData['team']['first_name'])>0 && count($newData)==0){
								/*Mobile Version*/
								$updateData = array();
								$newData = array();
								for($i=0;$i<count($getData['team']['first_name']);$i++){
									$firstName = $getData['team']['first_name'][$i];
									$secondName = $getData['team']['last_name'][$i];
									$title = $getData['team']['title'][$i];
									$email = $getData['team']['email'][$i];
									$phone = $getData['team']['work'][$i];
									if($phone==null){
										$phone = "";
									}
									$telephone = "";
									/*$telephone = $getData['team']['telephone'][$i];
									if($telephone==null){
										$telephone = "";
									}*/
									$id = $getData['team']['id'][$i];
									if(!empty($firstName)){
										/*$explodeName = explode(' ',$name);
										$firstName = $explodeName[0];
										$secondName = "";
										foreach($explodeName[1]  as $eN){
											$secondName.= $eN." ";
										}*/
										if($id!="" && (int)$id>0){	
											$updateData[] = array('id'=>$id,'first_name'=>$firstName,'last_name'=>trim($secondName),'job_title'=>$title,'email'=>$email,'phone'=>$phone,'telephone'=>$telephone);
										} else {
											$newData[] = array('first_name'=>$firstName,'last_name'=>trim($secondName),'job_title'=>$title,'email'=>$email,'phone'=>$phone,'telephone'=>$telephone,'company_id'=>$checkUserData->company_id);
										}
									} 
								}
								$updateBulk = false;
								$insertID = 0;
								/*Update bluk*/
								if(count($updateData)>0){
									$updateBulk = $this->opportunity_model->updatePartnerTeamBatch($updateData);
								}
								/*Add Bulk*/
								if(count($newData)>0){
									$insertID =	$this->opportunity_model->insertPartnerTeamBatch($newData);
								}
							}							
						}catch(Exception $e){
					
						}
					}
				}
			}
		}
		/**/
		echo $message;
		die;
	}
	
	function getCalendarEvent(){
		$time = new DateTime;
		$timeMin = $time->format(DateTime::ATOM);
		$this->load->library('DriveServiceHelper');
		$service = new CalendarServiceHelper();
		/*$colors = $service->getColor();
		$availableColor = array();
		foreach ($colors->getCalendar() as $key => $color) {
		  $availableColor[] = $color->getBackground();
		}*/
		$calendarList = $service->getCalendarList();
		$eventsAllUsersList = array();
		$eventUserAndColor = array();
		foreach($calendarList as $calendar){
			$userID = $calendar->id;
			$_name = explode('@',$userID);
			$userForegroundColor = $calendar->foregroundColor;
			$userBackgroundColor = $calendar->backgroundColor;
			$userTimezone = $calendar->timeZone;
			$userEtag = $calendar->etag;
			$eventList = $service->getEventsList($calendar->id,$timeMin);
			$eventUserAndColor[] = array('user_id'=>$userEtag,'backgroundColor'=>$userBackgroundColor,'color'=>$userForegroundColor,'time_zone'=>$userTimezone,'name'=>$userID);
			foreach($eventList as $event){				
				$allDay = false;/*$allDay = true;*/
				if($event->start->dateTime!=null && $event->end->dateTime!=null){
					$datetime1 = new DateTime($event->start->dateTime);
					$datetime2 = new DateTime($event->end->dateTime);
					$interval = $datetime1->diff($datetime2);
					if($interval->format('%a')>0 || $interval->format('%h')>8){
						$allDay = true;
					} 
					$eventsAllUsersList[] = array('user_id'=>$userEtag,'allDay'=>$allDay,'backgroundColor'=>$userBackgroundColor,'color'=>$userForegroundColor,'textColor'=>$userForegroundColor,'start'=>$event->start->dateTime,'end'=>$event->end->dateTime,'event_id'=>$event->id,'id'=>$event->etag,'title'=>ucfirst($_name[0]).', '.$event->summary.", ".$event->location);
				}
				
			}
		}
		$data= json_encode($eventsAllUsersList);
		echo $data;
		die;
	}
	function get_active_leads(){
		$this->load->model('lead_model');
		$data = $this->lead_model->getActiveLeads('l.lead_name,l.id');
		echo json_encode($data);
		die;
	}
	
	function get_lead_open_source_project(){
		$data = array();
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data = $this->lead_model->getLeadOpenDDProjectUserAndCount($_POST['lead_id']);
			echo json_encode($data);	
		}
		die;
	}
	
	function get_invitees_from_lead(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$this->load->model('lead_model');
		$mergeContacts = array();
		if(isset($_POST) && $this->input->post('lead_id')>0){
			$data = $this->lead_model->getLeadInviteesSalesAndAcquisition($this->input->post('lead_id'),$this->input->post('activity'));
			if(count($data)==0){
				/*$this->load->model('client_model');
				$data = $this->client_model->getAllAutoCompleteContacts();*/
			} 
			$contacts = array();
			$newContacts = array();
			foreach($data as $contact){
				$secondaryEmail  = trim($contact->secondary);
				unset($contact->secondary);
				$contacts[] = $contact;
				if(!empty($secondaryEmail)){
					$newContact = (object)array();
					$newContact->id = $contact->id;
					$newContact->label = $contact->label.', Secondary Email';
					$newContact->value = $secondaryEmail;
					array_push($newContacts,$newContact);
				}
			}
			$mergeContacts = array_merge($contacts,$newContacts);
		}
		echo json_encode($mergeContacts);
		die;
	}
	function activitylog($activityLog){
		if(isset($activityLog['task_id'])){
			unset($activityLog['task_id']);
		}
		if(isset($activityLog['next_call_date'])){
			unset($activityLog['next_call_date']);
		}
		$this->load->model('lead_model');
		$this->lead_model->insertActivityLog($activityLog);
	}
	
	function getRandomGenerator($length=10) {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	function getCalendarList(){
		$this->load->library('DriveServiceHelper');
		$service = new CalendarServiceHelper();		
		$calendarList = $service->getCalendarList();
		echo json_encode($calendarList);
		die;
	}
	
	function getFreeBusyList(){
		$this->load->library('EventServiceHelper');
		$service = new EventServiceHelper();		
		$calendarList = $service->getFreeBusy(array("id"=>"uzi@synpat.com"),"2019-10-22 09:00:00","2019-10-22 19:00:00");
		echo "<pre>";
		print_r($calendarList['calendars']['uzi@synpat.com']->getBusy());
		echo json_encode($calendarList);
		die;
	}
	
	function insert_event(){
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('EventServiceHelper');			
			if(!isset($_SESSION)){
				session_start();
			}			
			$service = new EventServiceHelper();
			$googleToken = $_POST['another_access_token'];
			if(empty($googleToken)){
				$googleToken = $this->getUserToken();
			}
			//$service->setAccessToken($googleToken);	
			$event = $this->input->post("event");
			$email = $this->input->post("email");
			$currentUseremail = "uzi@synpat.com";
			if(!empty($this->input->post("user_email"))){				
				$currentUseremail = $this->input->post("user_email");
			}
			if(!empty($email)){
				$allEmails = explode(',',$email);
				foreach($allEmails as $email){
					if(trim($email)!=""){
						$event['attendees'][] = array("email"=>trim($email));
					}					
				}
			}
			//$event['attendees'][] = array("email"=>"synpat@synpat.com");
			$sessionUserIN = false;
			foreach($event['attendees'] as $attende){
				if(trim($attende['email']) == $currentUseremail){
					$sessionUserIN = true;break;
				}
			}
			if($sessionUserIN ===false){
				$event['attendees'][] = array("email"=>$currentUseremail);
			}
			/*$eventsSendEmail = "";
			foreach($event['attendees'] as $attende){
				$eventsSendEmail .= trim($attende['email']).",";
			}
			$eventsSendEmail = substr($eventsSendEmail,0,-1);
			$event['attendees'] = $eventsSendEmail;*/
			if(isset($event['color']) && !empty($event['color'])){
				$event['colorId'] = $event['color'];
			}
			unset($event['color']);
			$sTime = $event['start_time'];
			$sT = explode(" ",$sTime);
			$UTCAttached = "";
			if(date('I')){
				$UTCAttached = "00-07:00";
			} else {
				$UTCAttached = "00-08:00";
			}
			if(count($sT)==2){
				if(trim($sT[1])=="PM"){
					$explodeM = explode(":",$sT[0]);
					if(count($explodeM)==2){
						if((int)$explodeM[0]<12){
							$mT = (int)$explodeM[0] + 12;
						} else {
							$mT = (int)$explodeM[0];
						}
						
					} else {
						$mT = (int)$explodeM[0];
					}
					$sD = date('Y-m-d',strtotime($event['start_date']));
					$time = strtotime($sD.$mT.':'.$explodeM[1]);
					$m = date('G:i',$time);
					$sD = $sD.'T'.$m.':'.$UTCAttached;
					$event['start']=array('dateTime'=>$sD,'timeZone'=> 'America/Los_Angeles');
				} else {
					$explodeM = explode(":",$sT[0]);
					$sD = date('Y-m-d',strtotime($event['start_date']));
					$first = $explodeM[0];
					if($first==12){
						$first = 00;
					}
					$time = strtotime($sD.$first.':'.$explodeM[1]);
					$m = date('G:i',$time);
					$sD = $sD.'T'.$m.':'.$UTCAttached;
					$event['start']=array('dateTime'=>$sD,'timeZone'=> 'America/Los_Angeles');
				}
			}
			$eTime = $event['end_time'];
			$eT = explode(" ",$eTime);
			if(count($eT)==2){
				if(trim($eT[1])=="PM"){
					$explodeM = explode(":",$eT[0]);
					if(count($explodeM)==2){
						if((int)$explodeM[0]<12){
							$mT = (int)$explodeM[0] + 12;
						} else {
							$mT = (int)$explodeM[0];
						}						
					} else {
						$mT = (int)$explodeM[0];
					}
					$sD = date('Y-m-d',strtotime($event['end_date']));
					$time = strtotime($sD.$mT.':'.$explodeM[1]);
					$m = date('G:i',$time);
					$sD = $sD.'T'.$m.':'.$UTCAttached;
					$event['end']=array('dateTime'=>$sD,'timeZone'=> 'America/Los_Angeles');
				} else {
					$explodeM = explode(":",$eT[0]);
					$sD = date('Y-m-d',strtotime($event['end_date']));
					$first = $explodeM[0];
					if($first==12){
						$first = 00;
					}
					$time = strtotime($sD.$first.':'.$explodeM[1]);
					$m = date('G:i',$time);
					$sD = $sD.'T'.$m.':'.$UTCAttached;
					$event['end']=array('dateTime'=>$sD,'timeZone'=> 'America/Los_Angeles');
				}
			}
			/*$event['recurrence'] = array('RRULE:FREQ=DAILY;COUNT=2');*/
			$event['guestsCanModify'] = true;
			$event['sendNotifications'] = true;
			$event['sendUpdates'] = "all";
			$event['reminders'] = array(
									'useDefault' => FALSE,
									'overrides' => array(
									  array('method' => 'email', 'minutes' => 24 * 60),
									  array('method' => 'email', 'minutes' => 10),
									),
								  );
			
			$first = $this->getRandomGenerator(3);
			$middle = $this->getRandomGenerator(4);
			$last = $this->getRandomGenerator(3);
			$requestID = $first.'-'.$middle.'-'.$last;
			$event['conferenceData'] = array(
											'createRequest'=>array(
															"conferenceSolutionKey"=>array(
																'type'=>"hangoutsMeet")
															),
															"requestId"=> $requestID
										);
			//$event['conferenceDataVersion'] = 1;
			$startDateEvent = $event['start_date']." ".$event['start_time'];
			unset($event['end_time']);
			unset($event['end_date']);
			unset($event['start_time']);
			unset($event['start_date']);
			$eventID = $event['id'];
			unset($event['id']);
			if($eventID==""){
				$eventRes = $service->insert_event($event,1);
				/*//$eventData = $service->getEvent($eventRes->id);
				echo "<pre>";
				print_r($eventRes);
				//print_r($eventData);
				die;*/
			} else {
				$eventRes = $service->update_event($event,$eventID);
			}
			if(isset($eventRes->htmlLink)){
				if($this->input->post("lead_id")>0 && $eventID==""):
				$this->load->model('lead_model');
				$this->load->model('opportunity_model');
				$this->lead_model->saveLeadEvent(array("lead_id"=>$this->input->post("lead_id"),"subject"=>$event['summary'],"event_link"=>'',"date"=>$startDateEvent));
				$startDate = date('Y-m-d H:i:s');
				$email = $this->input->post("email");
				if(!empty($email)){	
					$emailTo = explode(',',$this->input->post("email"));
					if(count($emailTo)>1){
						$emailCurrent = $emailTo[0];
						$emailTo = array();
						$emailTo[] = $emailCurrent;
					}
					$leadID = $this->input->post("lead_id");
					$userID = 45;						
					if((int)$this->input->post("user_id")>0){
						$userID = $this->input->post("user_id");
					}
					$subject = $event['summary'];
					$description = $event['description'];
					$event= array();
					for($t=0;$t<count($emailTo);$t++){
						$toEmail = trim($emailTo[$t]);
						if(!empty($toEmail)){
							$getContactDetail = $this->lead_model->getContactByEmail(trim($emailTo[$t]));
							if(count($getContactDetail)>0 && $getContactDetail->email!=""){
								if($activityType==1){
									$checkCompanyInSalesActivity = $this->opportunity_model->checkCompanyInSales($leadID,$getContactDetail->company_id);
									if(count($checkCompanyInSalesActivity)==0){
										$this->opportunity_model->insertInvitees(array('lead_id'=>$leadID,'contact_id'=>$getContactDetail->company_id));
									}											
								} else {
									$checkCompanyInAcquisitionActivity = $this->opportunity_model->checkCompanyInAcquisition($leadID,$getContactDetail->company_id);
									if(count($checkCompanyInAcquisitionActivity)==0){
										$this->opportunity_model->insertAcquisitionCompany(array('lead_id'=>$leadID,'contact_id'=>$getContactDetail->company_id));
									}
								}
								$event['company_id'] = $getContactDetail->company_id;
								$event['contact_id'] = $getContactDetail->id;
								$event['type'] = 11;
								$dateCreate = new DateTime($startDateEvent, new DateTimeZone('America/Los_Angeles'));
								$eventDate = $dateCreate->format('D, d M Y H:i');
								$note = "<a href='".$eventRes->htmlLink."' target='_BLANK'><i class='glyph-icon icon-calendar'></i>&nbsp;&nbsp;".$subject." and ".$eventDate."</a><br/><a href='".$eventRes->hangoutLink."' target='_BLANK'><i class='glyph-icon icon-video-camera'>&nbsp;Join meeting</i></a>";
								if(!empty($description)){
									$note .="<br/>".$description;
								}
								$event['note'] = $note;
								$event['user_id'] = $userID;
								$event['email_id'] = 0;
								$event['subject'] = $subject;
								$event['lead_id'] = $leadID;
								$event['activity_date'] = $startDate;
								$findPersonLastActivty = $this->lead_model->findPersonLastActivty($leadID,$event['company_id'],$event['contact_id'],$activityType);
								$this->activitylog($event);
								if($activityType==1){
									if(count($findPersonLastActivty)==0){
										$this->lead_model->insetSalesActivity($event);
									} else {
										if(isset($event['id'])){
											unset($event['id']);
										}
										$data = $this->lead_model->updateSalesActivity($findPersonLastActivty->id,$event);
									}
								} else if($activityType==2){
									if(count($findPersonLastActivty)==0){
										$this->lead_model->insertAcquistionActivity($event);
									} else {
										if(isset($event['id'])){
											unset($event['id']);
										}
										$data = $this->lead_model->updateAcquistionActivity($findPersonLastActivty->id,$event);
									}
								}
							}
						}
					}
				}
				endif;
				echo json_encode(array('link'=>$eventRes->htmlLink));
			}
		}
		die;
	}
	
	public function patchEvent(){
		$eventID = "5i9jaibtp1j7cnb5kqks30nrvc";
		$this->load->library('EventServiceHelper');			
		if(!isset($_SESSION)){
			session_start();
		}			
		$service = new EventServiceHelper();
		$event = array();
		$event['summary']="Patch Event2";
		$event['conferenceData'] = array(
											'createRequest'=>array(
															"conferenceSolutionKey"=>array(
																'type'=>"hangoutsMeet")
															),
															"requestId"=> "gsv-bvpl-bgs"
										);
		$eventRes = $service->patch_event($event,$eventID,1);
		echo "<pre>";
		print_r($eventRes);
		die;
	}
	
	public function sendRequestZoomMeeting($calledFunction, $data){
		/*Creates the endpoint URL*/
		$this->config->load('config');
		$request_url = $this->config->item('zoom_api_url').$calledFunction;
		/*Adds the Key, Secret, & Datatype to the passed array*/
		$data['api_key'] = $this->config->item('zoom_api_key');
		$data['api_secret'] = $this->config->item('zoom_api_secret');
		$data['data_type'] = 'JSON';
		$postFields = http_build_query($data);
		/*Preparing Query...*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		curl_close($ch);
		if(!$response){
			return false;
		}
		/*Return the data in JSON format*/
		return $response;
	}
	
	public  function safe_b64encode($string) {
		$data = base64_encode($string);
		$data = str_replace(array('+','/','='),array('-','_',''),$data);
		return $data;
	}

	public function safe_b64decode($string) {
		$data = str_replace(array('-','_'),array('+','/'),$string);
		$mod4 = strlen($data) % 4;
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		return base64_decode($data);
	}

	public  function encode($value){ 
		if(!$value){return false;}
		$text = $value;
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
		return trim($this->safe_b64encode($crypttext)); 
	}

	public function decode($value){
		if(!$value){return false;}
		$crypttext = $this->safe_b64decode($value); 
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
		return trim($decrypttext);
	}
	
	function get_lead_info(){
		$data = array('detail'=>array(),'boxes'=>array());
		if(isset($_POST) && count($_POST)>0){
			$type = "Market";
			$this->load->model('lead_model');
			$data['detail'] = $this->lead_model->findOneLitigationWithIncomplete($this->input->post('l'),$type);
			$this->load->model('customer_model');
			$category_list = $this->customer_model->categoryList(0);
			$data['category_list'] = $category_list;
			$serialNumber = $data['detail'][0]['litigation']->serial_number;
			if(count($data['detail'][0]['acquisitions'])>0 && !empty($data['detail'][0]['acquisitions']->store_name)){
				$urlName ="";
				if($data['detail'][0]['acquisitions']->category>0){
					if(count($category_list)>0){
						for($cc=0;$cc<count($category_list);$cc++){
							if($category_list[$cc]->id==$data['detail'][0]['acquisitions']->category){
								$urlName = $category_list[$cc]->name;
								$urlName = str_replace('','_',$urlName);
								$urlName = str_replace('-','_',$urlName);
								$urlName = str_replace('&',' ',$urlName);
								$urlName = str_replace('&amp;',' ',$urlName);
								$urlName = preg_replace("/[^a-zA-Z0-9_\s-]/", "_", $urlName);
								$urlName = preg_replace('/-/','_',$urlName);
								$urlName = preg_replace('/[\s,\-!]/',' ',$urlName);
								$urlName = preg_replace('/\s+/','_',$urlName);
							}
						}
					}
					if(!empty($urlName)){
						$urlName ='/departments/'.$urlName.'-'.$data['detail'][0]['acquisitions']->category.'/'.$serialNumber.'/';
						$urlName = $this->encode($urlName);
					}
				}
				$data['detail'][0]['portfolio'] = $urlName;		
			}			
			if(isset($data['detail'][0]['litigation']) && (int)$data['detail'][0]['litigation']->serial_number!=0){				
				$curl = curl_init();
				curl_setopt_array($curl, array(
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_URL => 'http://synpat.com/file_get.php',
					CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6',
					CURLOPT_POST => 1,
					CURLOPT_POSTFIELDS => array(
						's' => $data['detail'][0]['litigation']->serial_number
					)
				));				
				$resp = curl_exec($curl);
				if($resp){
					$data['detail'][0]['patentees'] = json_decode($resp);
					if(count($data['detail'][0]['patentees'])>0){
						$data['detail'][0]['patentees']->lead_seller_contact = $data['detail'][0]['litigation']->seller_contact;
						$data['detail'][0]['patentees']->lead_broker_contact = $data['detail'][0]['litigation']->broker_contact;
						$data['detail'][0]['patentees']->lead_broker_person_contact = $data['detail'][0]['litigation']->broker_person_contact;
						if((int)$data['detail'][0]['litigation']->broker_person>0){
							$this->load->model('client_model');
							$getInfo = $this->client_model->getInfo($data['detail'][0]['litigation']->broker_person,'email');
							if(count($getInfo)>0){
								$data['detail'][0]['patentees']->lead_broker_person_contact_email = $getInfo->email; 
							}
						}
					}					
				}
			} else {
				$data['detail'][0]['patentees'] = array();
			}			
		}		
		echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);		
		die;
	}
	
	public function findDriveFiles(){
		$data = array('drive'=>array());		
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			$this->load->model('lead_model');
			$findLeadData = $this->lead_model->getLeadData($this->input->post('boxes'));
			if(count($findLeadData)>0 && !empty($findLeadData->folder_id)){
				$q = "'".$findLeadData->folder_id."' in parents";
				$data['drive'] = $service->getAllFilesAndFolder($q);
			}			
		}
		echo json_encode($data);		
		die;
	}
	
	public function findWorksheetListFromUrl(){
		if($_POST && count($_POST)):
			$this->load->library('DriveServiceHelper');
			$service = new SpreadsheetServiceHelper();
			$ss_id = $this->input->post('v');
			$ss_id = str_replace("https://docs.google.com/spreadsheets/d/","",$ss_id);
			$ss_id = str_replace("https://docs.google.com/a/synpat.com/spreadsheets/d/","",$ss_id);
			$ss_id = str_replace("/edit?usp=drivesdk","",$ss_id);	
			$ss_id = str_replace("/edit#gid=0","",$ss_id);	
			$spreadsheet = $service->getSpreadsheetById($ss_id);
			$allWorkSheet = $service->getAllWorkSheets();
			echo json_encode($allWorkSheet);			
		endif;
		die;
	}
	
	function move_drive_file_in_lead_folder(){
		$data = array('send'=>0);
		if(isset($_POST) && count($_POST)>0){
			$box = $_POST;
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			if($box['f']=="GoTOMain"){
				$this->load->model('lead_model');
				$leadInfo = $this->lead_model->getLeadDataWithOptions($box['l'],"folder_id");
				$box['f'] = $leadInfo->folder_id;
			}
			$fileMoved = $service->moveFile($box['d'],$box['f']);
			if(is_object($fileMoved)){
				$data['send'] = 1;
			} 
		}
		echo json_encode($data);
		die;
	}
	
	function findDriveFilesSubFolder(){
		$data = array('drive'=>array());
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			if(!empty($this->input->post('f'))){
				/*$data['drive'] = $service->getFileIDFromChildern($this->input->post('f'));*/
				$q = "'".$this->input->post('f')."' in parents";
				$data['drive'] = $service->getAllFilesAndFolder($q);
			}		
		}
		echo json_encode($data);		
		die;
	}
	
	public function countFilesInFolder(){
		$data = array("count"=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->library('DriveServiceHelper');
			$service = new DriveServiceHelper();
			/*$filesList = $service->searchFileIDFromChildern($this->input->post('f'));*/
			$q = "'".$this->input->post('f')."' in parents";
			$filesList = $service->getAllFilesAndFolder($q);
			$data['count'] = count($filesList);
		}
		echo json_encode($data);
		die;
	}
	
	public function searchAllPatentFiles(){
		$listFiles = array();
		if(isset($_POST) && count($_POST)>0){
			$folderID = "";
			if($this->input->post('f')=="undefined"){
				$leadID = $this->input->post('l');
				if($leadID!="" && (int)$leadID>0){
					$this->load->model('lead_model');		
					$getData = $this->lead_model->getLeadDataWithOptions($leadID,'l.folder_id');
					if(count($getData)>0){
						$folderID = $getData->folder_id;
					}
				}
			} else {
				$folderID = $this->input->post('f');
			}
			if(!empty($folderID )){
				$this->load->library('DriveServiceHelper');
				$service = new DriveServiceHelper();
				$q = "title contains 'Patent List' and mimeType = 'application/vnd.google-apps.spreadsheet' and '".$folderID."' in parents";
				/*$listFiles = $service->searchFileIDFromChildern($folderID,$q);*/
				$listFiles = $service->getAllFilesAndFolder($q);
			}
		}
		echo json_encode($listFiles);	
		die;
	}
	
	public function lead_patent_data(){
		$data = array('data'=>array(),'job_queue'=>0);
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['data'] = $this->lead_model->getLeadPatentParentData($this->input->post('l'));
			if(count($data['data'])==0){
				/*Find is in Queue*/
				$checkJObStatus = $this->lead_model->findJobDetailsByLead($this->input->post('l'),'status,id');
				if(count($checkJObStatus)>0 && $checkJObStatus->status==0){
					$data['job_queue'] = $checkJObStatus->id;
				}
			}
		}
		echo json_encode($data);
		die;
	}
	public function findEmailBoxes(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$data = array('boxes'=>array(),'acquisition'=>array());
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['acquisition']= $this->lead_model->getAcquisitionActivity($this->input->post('boxes'),9);
		}
		echo json_encode($data);		
		die;
	}
	public function findSalesBoxes(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$data = array('detail'=>array(),'portfolio'=>'');		
		if(isset($_POST) && count($_POST)>0){
			$this->load->model('lead_model');
			$data['detail'] = $this->lead_model->getSalesActivityLead($this->input->post('boxes'));
		}
		echo json_encode($data);
		die;
	}
	function own_server_email($thread=null){
		$findThreadData = array();
		$this->load->model('lead_model');
		if($thread!=null){
			$findThreadData =  $this->lead_model->findBoxNewById($thread);			
		}
		$data['thread_detail'] = $findThreadData;
		$data['ID'] = $thread;
		$data['type'] = 2;
		$this->layout->auto_render=false;	
		$this->layout->layout='default';
		$this->layout->title_for_layout = 'Backyard Email Detail';
		$this->layout->layout='email';
		if(count($findThreadData)>0){
			if((int)$findThreadData[0]->account_type==2){
				$this->layout->render('user/small_imap_email',$data);
			} else {
				$this->layout->render('user/small_email',$data);
			}
		} else {
			echo "Page not found";
			die;
		}
	}
	
	
	
	public function resize($newWidth, $targetFile, $originalFile) {
		$newFile = $targetFile;
		try{
			$info = getimagesize($originalFile);
			$mime = $info['mime'];
			switch ($mime) {
					case 'image/jpeg':
							$image_create_func = 'imagecreatefromjpeg';
							$image_save_func = 'imagejpeg';
							$new_image_ext = '.jpg';
							break;
					case 'image/png':
							$image_create_func = 'imagecreatefrompng';
							$image_save_func = 'imagepng';
							$new_image_ext = '.png';
							break;
					case 'image/gif':
							$image_create_func = 'imagecreatefromgif';
							$image_save_func = 'imagegif';
							$new_image_ext = '.gif';
							break;
					default: 
							//throw new Exception('Unknown image type.');
			}
			if(isset($new_image_ext) && $new_image_ext != ""){
				$img = $image_create_func($originalFile);
				list($width, $height) = getimagesize($originalFile);
				if($width > $height){
					$newHeight =  floor(($height / $width) * $newWidth);
				} else {
					$newHeight = $newWidth;
					$newWidth = floor(($width / $height) * $newHeight);
				}
				$tmp = imagecreatetruecolor($newWidth, $newHeight);
				$color = imagecolorallocatealpha($tmp, 0, 0, 0, 127); //fill transparent back
				imagefill($tmp, 0, 0, $color);
				imagesavealpha($tmp, true);
				imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
				if (file_exists($targetFile)) {
					unlink($targetFile);
				}
				$targetFile = str_replace(array('.png','.jpg','.gif'),"",strtolower($targetFile));
				$newFile = $targetFile.$new_image_ext;
				$image_save_func($tmp, $newFile);
			}			
		}catch(Exception $e){
			
		}		
		return $newFile;
	}
	
	public function runCompanyScrapper(){
		$this->load->model('opportunity_model');
		$data = $this->opportunity_model->checkScrapperCompanyRunningStage($t);
		if($data->d == 0){
			set_time_limit(0);
			/*ignore_user_abort(true);
			set_time_limit(0);*/
			$url = 'http://webdriverforscrape.site/linkedin_scrap_company.php';
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			$content = curl_exec($ch);
			curl_close($ch);
			echo $content;
		}
	}
	
	function compressImage($source_url, $destination_url, $quality) {
		$info = getimagesize($source_url);
		if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
		elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
		elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);

		//save file
		imagejpeg($image, $destination_url, $quality);

		//return destination file
		return $destination_url;
	}
	
	function sendNotificationToUser($postData){
		$ch = curl_init();		
		$api_url = 'https://backyard.synpat.com/customers/push_notification_scrape_linkedin';
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3000);
		$response = curl_exec($ch); 
		curl_close($ch);
		return $response;
	}
	
	public function update_company_owler_data(){
		if (extension_loaded('newrelic')){
			newrelic_disable_autorum();
		}
		$data = array('update'=>0);
		if(isset($_POST)){
			$this->load->model('client_model');
			$postData = $this->input->post();
			if(isset($postData['url']) && strpos($postData['url'],"owler") !== false){
				$getCompanyData = $this->client_model->find_company_by_owler($postData['url']);
				if(count($getCompanyData) > 0) {
					$updateData = array('owler_company_revenue'=>trim($postData['revenue']),'owler_description'=>$postData['description']);
					if(isset($postData['competitors']) && $postData['competitors']!= ""){
						$updateData['competitors'] = json_encode($postData['competitors']);
					}
					if($getCompanyData->company_logo == ""){
						if(isset($postData['logo']) && $postData['logo']!= ""){
							try{
								$fileExtension = strtolower(pathinfo($postData['logo'],PATHINFO_EXTENSION));
								$fileName = $getCompanyData->id."_img_".time().".".$fileExtension;
								$target_dir = "/var/www/synpat/backyard/public/upload/contacts/";
								$target_file = $target_dir.$fileName;
								if(file_exists($target_file)){
									unlink($target_file);
								}
								copy($postData['logo'], $target_file);
								$newFile = $this->resize(120, $target_file, $target_file,$imageFileType);
								if($newFile != ""){
									$target_file = $newFile;
									$fileName = str_replace($target_dir,"",$newFile);
								}
								if(file_exists($target_file) && filesize($target_file) > 0){
									/*optimize*/
									$logo = $target_file;
									$destination = "/var/www/synpat/backyard/public/upload/company_logo/optimize/".$fileName;
									//$newUrl = $this->compressImage($logo,$destination,80);
									$updateData['original_logo'] = "https://backyard.synpat.com/public/upload/contacts/".$fileName;
									/*$updateData['company_logo'] = "https://backyard.synpat.com/public/upload/company_logo/optimize/".$fileName;*/
									$updateData['company_logo'] = "https://backyard.synpat.com/public/upload/contacts/".$fileName;
								}
							}catch(Exception $e){
							}
						}
					}
					$updateData['subsidiary'] = $postData['subsidiary'];
					if($getCompanyData->web_address == ""){
						$updateData['web_address'] = $postData['company_url'];
					}
					if($getCompanyData->company_name == ""){
						if(isset($postData['company_name'])){
							$updateData['company_name'] = $postData['company_name'];
						}
					}
					$tap = false;
					if($getCompanyData->linkedin_url == "" && strpos(strtolower($getCompanyData->linkedin_url),'linkedin') === false){
						$updateData['linkedin_url'] = $postData['linkedin_url'];
						$tap = true;
					}
					$data['update'] = $this->client_model->updateCompanyDataByOwlerUrl($updateData,$postData['url']);
					/*send push notification*/
					$this->sendNotificationToUser(array('action'=>'scrapping_company_profile_data','id'=>$getCompanyData->id,'d_d'=>'Finished','type'=>33,'name'=>$getCompanyData->company_name));
					/*End send push notification*/
					$findCompetitors = 0 ;
					if(isset($postData['competitors']) && $postData['competitors']!= ""){
						if(count($postData['competitors']) > 0){
							$findCompetitors = $this->addCompetitorAsCompany($postData['competitors'],$getCompanyData->id);
						}
					}
					if($tap === true){
						/*scrape from Linkedin*/
						/*Check company request status*/
						$this->load->model('opportunity_model');
						$checkStatus = $this->opportunity_model->checkScrapperCompanyRunningStage(0);
						$scraperData  = array(array('company'=>$getCompanyData->id,'company_name'=>$getCompanyData->company_name,'linkedin_url'=>$updateData['linkedin_url'],'type'=>33,'user_id'=>0));
						$this->opportunity_model->insertLinkedInCompanyScrapperListInBatch($scraperData);
						if($checkStatus->d == 0){
							/*send new request*/
							/*$this->callScraperServer('http://webdriverforscrape.site/linkedin_scrap_company.php');*/
							/*Send push Notification back to backyard for scrapping companies*/
							$this->sendNotificationToUser(array('action'=>'start_scrape_for_company','id'=>$getCompanyData->id,'d_d'=>$this->session->userdata['id'],'type'=>33,'name'=>$getCompanyData->company_name));
							$companyList = array();
							$companyList[] = $getCompanyData->id;
							$this->load->model('customer_model');
							/*Send Push Notification back to backyard for scraping company people*/
							$companiesLinkedinData = $this->customer_model->getAllCompaniesListWithLinkedinUrl($companyList);
							$saveCIDs = array();
							$saveCData = array();
							if(count($companiesLinkedinData) > 0 ){
								foreach($companiesLinkedinData as $cd){
									if(strpos($cd->linkedin_url,'linkedin.com')!==false){
										if(!in_array($cd->id,$saveCIDs)){
											array_push($saveCData,array('company'=>$cd->id,'linkedin_url'=>$cd->linkedin_url,'company_name'=>$cd->company_name,"title"=>json_encode($title),"type"=>11,"user_id"=>$this->session->userdata['id']));
											array_push($saveCIDs,$cd->id);
										}
									}
								}
							}
							if(count($saveCIDs) > 0){								
								$this->opportunity_model->insertLinkedInCompanyPeopleScrapperListInBatch($saveCData);
								/**/
								$this->opportunity_model->updateScrapeBtnStatusByType("3",array('status'=>0));
							}
							$this->sendNotificationToUser(array('action'=>'start_scrape_for_company_people','id'=>$getCompanyData->id,'d_d'=>$this->session->userdata['id'],'type'=>33,'name'=>$getCompanyData->company_name));
						}
					}
					if($findCompetitors > 0){
						$this->sendNotificationToUser(array('action'=>'start_scrape_for_owler_companies','id'=>$getCompanyData->id,'d_d'=>$this->session->userdata['id'],'type'=>33,'name'=>$getCompanyData->company_name));
						/*$this->callScraperServer('http://webdriverforscrape.site/owler_scrap_company.php?c='.$getCompanyData->id);*/
					}
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	function addCompetitorAsCompany($competitors,$fromCompany){
		$addCompanies = array();
		$this->load->model('client_model');	
		foreach($competitors as $comp){
			if(isset($comp['revenue']) && $comp['revenue'] != "" && strpos($comp['revenue'],"B") !== false){
				if(isset($comp['href']) && strpos($comp['href'],"owler") !== false){
					$findCompanyOwlerUrl = $this->client_model->find_company_by_owler($comp['href']);
					if(count($findCompanyOwlerUrl) == 0){
						$fileExtension = strtolower(pathinfo($comp['logo'],PATHINFO_EXTENSION));
						$name = strtolower(pathinfo($comp['logo'],PATHINFO_FILENAME));
						$fileName = $name.".".$fileExtension;
						$target_dir = "/var/www/synpat/backyard/public/upload/contacts/";
						$target_file = $target_dir.$fileName;
						if(file_exists($target_file)){
							unlink($target_file);
						}
						copy($postData['logo'], $target_file);
						$newFile = $this->resize(120, $target_file, $target_file,$imageFileType);
						if($newFile != ""){
							$target_file = $newFile;
							$fileName = str_replace($target_dir,"",$newFile);
						}
						if(file_exists($target_file) && filesize($target_file) > 0){
							$comp['logo'] = "https://backyard.synpat.com/public/upload/contacts/".$fileName;
						}
						array_push($addCompanies,array('company_name'=>$comp['company_name'],'company_logo'=>$comp['logo'],'owler_url'=>$comp['href'],'owler_company_revenue'=>$comp['revenue'],'from_company'=>$fromCompany));
					}
				}
			}			
		}
		$affected = 0;
		if(count($addCompanies) > 0){
			$this->load->model('customer_model');	
			$affected = $this->customer_model->insertPreCompaniesBatch($addCompanies);			
		}
		return $affected;
	}
	function update_linkedin_campaign_data(){
		$data = array('update'=>0);
		if(isset($_POST) && count($_POST) > 0){
			$this->load->model('lead_model');
			$id = $this->input->post('id');
			$send = $this->input->post('send');
			$type = $this->input->post('type');
			$updateData = array('send'=>$send,'checked'=>1);
			if(isset($_POST['d']) && $_POST['d'] != ''){
				$updateData['bounce'] = 1;
			}
			$data['update'] = $this->lead_model->updateCampaignListByID($id, $updateData);
			/* activity */
			if($send == 1){
				/**/
				$findData = $this->lead_model->getCampaignDataByListID($id);
				if(count($findData) > 0){
					$message = $findData->body;
					$company = $findData->company_name_alias;
					if($company == "" || $company == null){
						$company = $findData->company_name;
					}
					$salutation = "Mr.";
					if($findData->gender == 1){
						$salutation = "Ms.";
					}
					$date = date('Y-m-d H:i:s');
					$message = preg_replace('/#First#/',$findData->first_name,$message);
					$message = preg_replace('/#first#/',$findData->first_name,$message);
					$message = preg_replace('/#FIRST#/',$findData->first_name,$message);
					$message = preg_replace("/#Company#/",$company,$message);
					$message = preg_replace("/#company#/",$company,$message);
					$message = preg_replace("/#COMPANY#/",$company,$message);
					$message = preg_replace("/#Last#/",$findData->last_name,$message);
					$message = preg_replace("/#last#/",$findData->last_name,$message);
					$message = preg_replace("/#LAST#/",$findData->last_name,$message);
					$message = preg_replace("/#Salutation#/",$salutation,$message);
					$message = preg_replace("/#salutation#/",$salutation,$message);
					$message = preg_replace("/\n\n\n/","\n\n",$message);
					$event = array();
					$event['contact_id'] = $findData->id;
					$event['company_id'] = $findData->company_id;
					$event['type'] = $type;
					$event['note'] = $message;
					$event['user_id'] = $this->session->userdata['id'];
					$event['email_id'] = 0;
					$event['subject'] = "Message sent on Linkedin";
					$event['lead_id'] = $findData->lead_id;
					$event['activity_date'] = $date;
					echo "<pre>";
					print_r($event);
					$this->lead_model->insertActivityLog($event);
					$event['note'] = "Message sent on Linkedin";
print_r($event);					
					$this->lead_model->insetSalesActivity($event);
					
					if(isset($_POST['s']) && $_POST['s'] != ""){
						try{
							$s = json_decode($_POST['s'],true);
							if((int)$s['proximity'] > 0){
								$contactA = array('proximity'=>(int)$s['proximity']);
								if((int)$s['cC'] > 0){
									$contactA['c_c'] = (int)$s['cC'];
								}
								$this->load->model('client_model');
								$this->client_model->update($findData->id,$contactA);
							}
						}catch(Exception $e){}
					}
				}
			}
			if(isset($_POST['d']) && $_POST['d'] != ''){
				$findData = $this->lead_model->getCampaignDataByListID($id);
				if(count($findData) > 0){
					$this->load->model('client_model');
					$this->client_model->update($findData->id,array('linkedin_error'=>1));
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	public function update_recent_contacts(){
		$data = 0;
		if(isset($_POST)){
			$list = $this->input->post('list');
			if(count($list) > 0){
				$this->load->model("client_model");
				$data = $this->client_model->updateRecentContactList($list);
			}
		}
		echo $data;
		die;
	}
	
	function update_campaign_finished(){
		$data = array('update'=>0);
		if(isset($_POST) && count($_POST) > 0){
			$this->load->model('lead_model');
			$id = $this->input->post('id');
			$data['update'] = $this->lead_model->updateCampaign($id,array('checked'=>1));
		}
		echo json_encode($data);
		die;
	}
	
	function insert_linkedin_messages(){
		$data = array('insert'=>0);
		if(isset($_POST) && count($_POST) > 0){
			$messageList = $this->input->post('messages_list');
			if($messageList != ""){
				try{
					$messages = json_decode($messageList,true);
					echo "<pre>";
					print_r($messages);
					if(count($messages) > 0){
						$this->load->model('lead_model');
						$data['insert'] = $this->lead_model->insertLinkedinMessagesBatch($messages);
					}
				}catch(Exception $e){
					
				}
			}
		}
		echo json_encode($data);
		die;
	}
	
	function callScraperServer($url){
		set_time_limit(0);
		/*ignore_user_abort(true);
		set_time_limit(0);*/
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$content = curl_exec($ch);
		curl_close($ch);
	}
}