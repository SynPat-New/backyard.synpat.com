<?php
$overAllArray = array();
$db = array();
ini_set('max_execution_time', 0);
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'synpat_backyard';
$db['default']['password'] = 'J=W3qx4s';
$db['default']['database'] = 'synpat_backyard';
ini_set('max_execution_time', 0);
ignore_user_abort(true);
ini_set('xdebug.max_nesting_level', 1000);
ini_set("memory_limit","256M");
$jobID = $_GET['job_id'];
$con = mysqli_connect($db['default']['hostname'],$db['default']['username'],$db['default']['password'],$db['default']['database']);
if((int)mysqli_errno($con)==0 && $jobID  > 0){
	mysqli_set_charset($con, 'utf8'); // <- add this too
	mysqli_query($con, "SET NAMES 'utf8';");
	mysqli_query($con, "SET CHARACTER SET 'utf8';");
	mysqli_query($con, "SET COLLATION_CONNECTION = 'utf8_unicode_ci';");
	$jobQuery = "SELECT account,id as jobID FROM job_queue WHERE module_name='Patent_Family' and id = ".$jobID." ORDER BY id ASC LIMIT 0,1";
	echo $jobQuery."<br/>";
	$jobResult = $con->query($jobQuery);
	if($jobResult){
		$jobCountRows = mysqli_num_rows($jobResult);
		if($jobCountRows>0):
		while($jobData = mysqli_fetch_array($jobResult)){			
			try{
				echo "<pre>";
				print_r($jobData);
				echo "</pre>";
				if((int)$jobData['account']>0){
				$leadPatentList = "SELECT patent_number,id FROM lead_patent WHERE lead_id=".$jobData['account'];
				echo $leadPatentList."<br/>";
				$patentPatentsResult = $con->query($leadPatentList);
				if($patentPatentsResult){
					$patentsRows = mysqli_num_rows($patentPatentsResult);
					if($patentsRows>0){
						while($pPatent = mysqli_fetch_array($patentPatentsResult)){
							echo "<pre>";
							print_r($pPatent);
							echo "</pre>";
							/*Scrap Patent*/
							$patent = $pPatent['patent_number'];
							$allPatentFromSheet = array();
							$asset_data=array();
							$originalPatent = $patent;
							if(!empty($patent)){
								$patent = strtoupper($patent);
								if(strpos($patent,"US")===false){
									if(strlen($patent)==7){
										$patent = "US".$patent;
									}				
								}
							}
							$patentData = "";
							switch(strlen($pPatent['patent_number'])){
								case 9:
									$patentData =substr($pPatent['patent_number'],2);
								break;
								case 11:
								case 13:
									$patentData =substr($pPatent['patent_number'],2);
									$patentData =substr($patentData,0,-2);
								break;
								default:
									$patentData = $pPatent['patent_number'];
								break;
							}
							if($patentData!=''){
								newAssignmentNumber($patentData,$con,$jobData['account']);
							}
							sleep(3);
						}
					}
				}
				}
			}catch(Exception $e){
			}
		}
		endif;
	}
}
function getPDFFile($assList){
	$fileName = 'assignment-pat-'.$assList['reelNo'].'-'.$assList['frameNo'].'.pdf';
	if(file_exists('./public/upload/'.$fileName)===false){
		try{
			$content = file_get_contents('http://legacy-assignments.uspto.gov/assignments/'.$fileName);
			if($content!=""){
				$handle = fopen('./public/upload/'.$fileName,'w+');
				try{
					fwrite($handle, $content);
				}catch(Exception $e){
					
				}
				fclose($handle);
			} else {
				$fileName = "";
			}
		}catch(Exception $e) {
			$fileName = 'http://legacy-assignments.uspto.gov/assignments/'.$fileName;
		}		
	}
	return $fileName;
}
function formatText($text) {
	return ucfirst(strtolower(strtoupper(trim($text))));
}
function getName($getPatentNumber,$originalName,$con) {
	$queryFindName = "SELECT modified FROM lead_assignment_names WHERE patent_number='".$getPatentNumber."' AND original='".mysqli_real_escape_string($con,$originalName)."' LIMIT 1";
	$queryNameRes =  $con->query($queryFindName);
	if($queryNameRes && $queryNameRes->num_rows > 0 ) {
		$row = $queryNameRes->fetch_array(MYSQLI_ASSOC);
		if($row['modified'] != "") {
			$originalName = $row['modified'];
		}		
	} 
	return $originalName;
}
function getDescription($getPatentNumber,$originalName,$con) {
	$queryFindName = "SELECT modified FROM lead_assignment_heading WHERE patent_number='".$getPatentNumber."' AND original='".mysqli_real_escape_string($con,$originalName)."' LIMIT 1";
	$queryNameRes =  $con->query($queryFindName);
	if($queryNameRes && $queryNameRes->num_rows > 0 ) {
		$row = $queryNameRes->fetch_array(MYSQLI_ASSOC);
		if($row['modified'] != "") {
			$originalName = $row['modified'];
		}		
	} 
	return $originalName;
}
function newAssignmentNumber($getPatentNumber,$con,$leadID){
	/*$url = "https://assignment-api.uspto.gov/patent/advancedSearch?sort=ExecutionDate%20asc&patentNumber=".$getPatentNumber."&rows=500";*/
	$url = "https://assignment.uspto.gov/solr/aotw/select?fl=id,displayId,reelNo,frameNo,pctNum,applNum,patNum,publNum,issueDate,publDate,filingDate,conveyanceText,patAssigneeName,patAssignorName,inventors,inventionTitle,inventionTitleFirst,applNumFirst,publNumFirst,patNumFirst,intlRegNum,intlRegNumFirst,corrName,corrAddress1,corrAddress2,corrAddress3,corrAddress4,patAssignorEarliestExDate,recordedDate,filingDateFirst,publDateFirst,issueDateFirst,intlPublDateFirst,patNumSize,applNumSize,pageCount,patAssigneeAddress1,patAssigneeAddress2,patAssigneeCity,patAssigneeState,patAssigneePostcode,patAssigneeCountryName,assignmentRecordHasImages&fq=patNum:".$getPatentNumber."&hl=true&lowercaseOperators=true&q=*:*&rows=500&sort=patAssignorEarliestExDate+desc,+recordedDate+desc&wt=json";
	$assignmentData = array();
	$assigmentIllustrationData = array('inventors'=> array(), 'list'=>array());
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	/*curl_setopt ( $ch, CURLOPT_HEADER, array('Accept:application/xml') );*/
	curl_setopt ( $ch, CURLOPT_HEADER,false );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 0 );
	$dataUSPTO= curl_exec ( $ch );
	if (curl_errno ( $ch )) {			
		curl_close ( $ch );			
	} else {
		curl_close ( $ch );
		try{
			if($dataUSPTO != "" && $dataUSPTO != null) {
				$fileName = $getPatentNumber.'.json';
				$handle = fopen('./public/upload/'.$fileName,'w+');
				try{
					fwrite($handle, $dataUSPTO);
				}catch(Exception $e){
					
				}
				fclose($handle);
				$assignmentList = json_decode($dataUSPTO,true);
				$allBoxesList = array();
				$addedInventor = array(); 
				if(isset($assignmentList['response']) && isset($assignmentList['response']['docs'])) {
					if(count($assignmentList['response']['docs']) > 0) {
						$deleteAll = true;
						$countAssignments = 0;
						$queryCheck = "Select count(id) as countR FROM lead_patent_assignment WHERE patent_number='".$getPatentNumber."'";
						$resultCheck = $con->query($queryCheck);
						if($resultCheck && mysqli_num_rows($resultCheck) > 0){
							$assignmentsData = mysqli_fetch_object($resultCheck);
							$countAssignments = $assignmentsData->countR;
							$queryNormalise = "Select count(id) as countR FROM lead_patent_assignment WHERE patent_number='".$getPatentNumber."' AND normalize = 0";
							$resultNormalizeCheck = $con->query($queryNormalise);
							if($resultNormalizeCheck && mysqli_num_rows($resultNormalizeCheck) == 0){
								$deleteAll = false;
							}
						}
						if($deleteAll === true){
							$queryAssigmentIllustration = "DELETE FROM lead_patent_assignment WHERE patent_number='".$getPatentNumber."'";
							$con->query($queryAssigmentIllustration);
							$queryAssigmentIllustration = "DELETE FROM lead_patent_assigment_relation WHERE patent_number='".$getPatentNumber."'";
							$con->query($queryAssigmentIllustration);
						}
						$insertAllNames = array();
						$insertAllHeading = array();
						/*Assignees*/
						$counter = 1;
						$inventorData = array('list'=>array(),'filling_date'=>'','recorded_date'=>'');
						$addedInventors = false;
						$insertAll = true;
						if($countAssignments > 0 && count($countAssignments) == count($assignmentList['response']['docs'])){
							$insertAll = false;
						}
						if($insertAll === true):
							for($a = count($assignmentList['response']['docs'])-1;$a >= 0; $a--) {
								$docs = $assignmentList['response']['docs'][$a];
								$frameNo = $docs['frameNo'];
								$reelNo = $docs['reelNo'];
								$queryCheckReelFrame = "SELECT id FROM lead_patent_assignment WHERE patent_number='".$getPatentNumber."' AND reel_no = '".$reelNo."' AND frame_no = '".$frameNo."'";
								$insertReelFrame = true;
								$resultCheckReelFrame = $con->query($queryCheckReelFrame);
								if($resultCheckReelFrame && mysqli_num_rows($resultCheckReelFrame) == 0){
									$insertReelFrame = false;
								}
								if($insertReelFrame === true){
									if($a === count($assignmentList['response']['docs'])-1) {
										$patentNumberList = $docs['patNum'];
										$patentIndex = array_search($getPatentNumber,$patentNumberList);
										if($patentIndex >= 0) {
											$inventorsAllList = $docs['inventors'];
											$filingDateList = $docs['filingDate'];
											$recordedDateList = $docs['publDate'];
											$allInventors = explode(',',$inventorsAllList[$patentIndex]);
											$inventorData['list'] = $allInventors;
											$inventorData['filling_date'] = $filingDateList[$patentIndex];
											$inventorData['recorded_date'] = $recordedDateList[$patentIndex];
											if(count($inventorData['list']) > 0) {
												foreach($inventorData['list'] as $inventor) {
													$inventor = getName($getPatentNumber,trim($inventor),$con);
													$inventor = formatText($inventor);
													if(!in_array($inventor,$insertAllNames)) {
														array_push($insertAllNames,$inventor);
													}
												}
											}									
										}
									}
									$recorded = substr($docs['recordedDate'],0,10);
									$executedDate = substr($docs['patAssignorEarliestExDate'],0,10);
									$assigneeList = $docs['patAssigneeName'];
									$assignorList = $docs['patAssignorName'];
									$conveyanceText = $docs['conveyanceText'];
									$description = getDescription($getPatentNumber,trim($conveyanceText) ,$con);
									$fileName = getPDFFile($docs);
									if($fileName!="" && strpos($fileName, "http://legacy") === false){
										$fileName = "https://backyard.synpat.com/public/upload/".$fileName;
									}
									
									if(strpos(strtolower($description),"assignment of assignors interest") !== false || strpos(strtolower($description),"change of name") !== false || (strpos(strtolower($description),"license") !== false && strpos(strtolower($description),"expiration") === false) || (strpos(strtolower($description),"security") !== false && strpos(strtolower($description),"interest") !== false && strpos(strtolower($description),"release") === false ) || (strpos(strtolower($description),"security agreement") !== false  && strpos(strtolower($description),"release by secured party") === false)) {
										echo "1<br/>";
										foreach($assigneeList as $assignee) {
											$assignee = getName($getPatentNumber,trim($assignee),$con);
											$assignee = formatText($assignee);
											$queryCheck = "SELECT id FROM lead_patent_assignment WHERE type IN (0,1) AND patent_number='".$getPatentNumber."' AND name = '".mysqli_real_escape_string($con,$assignee)."'  order by id ASC LIMIT 1";
											echo "BOB:".$queryCheck."<br/>";
											$assigneeID = 0;
											$queryResult =  $con->query($queryCheck);
											if($queryResult && mysqli_num_rows($queryResult) > 0) {
												$row = mysqli_fetch_array($queryResult);
												$assigneeID = $row['id'];
											} else {
												$queryInsertAssignment = "INSERT INTO lead_patent_assignment(lead_id,patent_number,name,description,execution_date,recorded,type,reel_no,frame_no,document_file) VALUES (".$leadID.",'".$getPatentNumber."','".mysqli_real_escape_string($con,$assignee)."','".mysqli_real_escape_string($con,$description)."','".$executedDate."','".$recorded."',1,'".$docs['reelNo']."','".$docs['frameNo']."','".$fileName."')";
												$con->query($queryInsertAssignment);
												$assigneeID = mysqli_insert_id($con); 
											}
											if($assigneeID > 0) {	
												$cType = 2;
												/*
												if($addedInventors === false && count($inventorData['list']) > 0) {
													foreach($inventorData['list'] as $inventor) {
														$inventor = getName($getPatentNumber,trim($inventor),$con);
														$inventor = formatText($inventor);
														foreach($assignorList as $assignor) {
															$assignor = getName($getPatentNumber,trim($assignor),$con);
															$assignor = formatText($assignor);
															if($assignor == $inventor) {
																$assignorList = $inventorData['list'];
																$cType = 0;
																$addedInventors = true;
																break;
															}
														}
													}
												}*/
												$executionDate = substr($docs['patAssignorEarliestExDate'],0,10);
												foreach($assignorList as $assignor) {											
													$assignor = getName($getPatentNumber,trim($assignor),$con);
													$assignor = formatText($assignor);
													if(count($inventorData['list']) > 0) {
														if(in_array($assignor,$addedInventor) === false) {
															foreach($inventorData['list'] as $inventor) {
																$inventor = getName($getPatentNumber,trim($inventor),$con);
																$inventor = formatText($inventor);
																if($assignor == $inventor) {
																	$cType = 0;
																	$assignor = $inventor;
																	$executedDate = substr($inventorData['filling_date'],0,10);
																	$recorded = substr($inventorData['recorded_date'],0,10);
																	array_push($addedInventor,$inventor);
																	break;
																}
															}
														}
													}
													$queryCheck = "SELECT id,description FROM lead_patent_assignment WHERE  patent_number='".$getPatentNumber."' AND name = '".mysqli_real_escape_string($con,$assignor)."' AND type IN(0,1) order by id ASC LIMIT 1";
													$assignorID = 0;
													$queryResult =  $con->query($queryCheck);
													if($queryResult && mysqli_num_rows($queryResult) > 0) {
														$row = mysqli_fetch_array($queryResult);
														$assignorID = $row['id'];
													}  else {
														$queryCheck = "SELECT id,description FROM lead_patent_assignment WHERE  patent_number='".$getPatentNumber."' AND name = '".mysqli_real_escape_string($con,$assignor)."' AND type = 2 order by id ASC LIMIT 1";
														$queryResult =  $con->query($queryCheck);
														if($queryResult && mysqli_num_rows($queryResult) > 0) {
															$row = mysqli_fetch_array($queryResult);
															$assignorID = $row['id'];
														}
													}
													if($assignorID == 0){
														if($cType == 2) {
															$executedDate = '0000-00-00';
															$recorded = '0000-00-00';
														}
														$queryInsertAssignment = "INSERT INTO lead_patent_assignment(lead_id,patent_number,name,description,execution_date,recorded,type,reel_no,frame_no,document_file) VALUES (".$leadID.",'".$getPatentNumber."','".mysqli_real_escape_string($con,$assignor)."','".mysqli_real_escape_string($con,$description)."','".$executedDate."','".$recorded."','".$cType."','".$docs['reelNo']."','".$docs['frameNo']."','".$fileName."')";
														$con->query($queryInsertAssignment);
														$assignorID = mysqli_insert_id($con); 
													}
														
													
													if($assignorID > 0) {
														$connectionType = 1;
														$insertBulkRelation ="INSERT INTO lead_patent_assigment_relation(lead_id,patent_number,parent_id,child_id,connection_type,frame,reel,description,date,assignment_no) VALUES (".$leadID.",'".$getPatentNumber."',".$assignorID.",".$assigneeID.",".$connectionType.",'".$docs['frameNo']."','".$docs['reelNo']."','".$description."','".substr($docs['patAssignorEarliestExDate'],0,10)."','".$counter."') ";
														echo $insertBulkRelation."<br/>";
														$con->query($insertBulkRelation);
														if(!in_array($assignee,$insertAllNames)) {
															array_push($insertAllNames,$assignee);
														}
														if(!in_array($assignor,$insertAllNames)) {
															array_push($insertAllNames,$assignor);
														}
														if(!in_array(strtoupper(strtolower($description)),$insertAllHeading)) {
															array_push($insertAllHeading,strtoupper(strtolower($description)));
														}
													}
												}
											}
										}								
									} else if((strpos(strtolower($description),"release") !== false && strpos(strtolower($description),"security interest") !== false) || (strpos(strtolower($description),"expiration") !== false && strpos(strtolower($description),"license") !== false) || ( strpos(strtolower($description),"release by secured party") !== false)) {
										echo "2<br/>";
										//echo "<pre>";
										//print_r($docs);
										foreach($assigneeList as $assignee) {
											$assignee = getName($getPatentNumber,trim($assignee),$con);
											$assignee = formatText($assignee);
											$queryCheck = "SELECT id FROM lead_patent_assignment WHERE patent_number='".$getPatentNumber."' AND name = '".mysqli_real_escape_string($con,$assignee)."'    AND type IN(0,1) order by id ASC LIMIT 1";
											//echo $queryCheck."<br/>";
											$assigneeID = 0;
											$queryResult =  $con->query($queryCheck);
											if($queryResult && mysqli_num_rows($queryResult) > 0) {
												$row = mysqli_fetch_array($queryResult);
												$assigneeID = $row['id'];
											} else {
												$queryCheck = "SELECT id FROM lead_patent_assignment WHERE patent_number='".$getPatentNumber."' AND name = '".mysqli_real_escape_string($con,$assignee)."'    AND type = 2 order by id ASC LIMIT 1";
												$queryResult =  $con->query($queryCheck);
												if($queryResult && mysqli_num_rows($queryResult) > 0) {
													$row = mysqli_fetch_array($queryResult);
													$assigneeID = $row['id'];
												}
											}									
											if($assigneeID == 0) {
												$queryInsertAssignment = "INSERT INTO lead_patent_assignment(lead_id,patent_number,name,description,execution_date,recorded,type,reel_no,frame_no,document_file) VALUES (".$leadID.",'".$getPatentNumber."','".mysqli_real_escape_string($con,$assignee)."','".mysqli_real_escape_string($con,$description)."','".$executedDate."','".$recorded."',2,'".$docs['reelNo']."','".$docs['frameNo']."','".$fileName."')";
												$con->query($queryInsertAssignment);
												$assigneeID = mysqli_insert_id($con); 
												echo "NEW<br/>";
											}
											//echo $assigneeID."<br/>";
											if($assigneeID > 0) {
												foreach($assignorList as $assignor) {
													$assignor = getName($getPatentNumber,trim($assignor),$con);
													$assignor = formatText($assignor);
													$queryCheck = "SELECT id,description FROM lead_patent_assignment WHERE  patent_number='".$getPatentNumber."' AND name = '".mysqli_real_escape_string($con,$assignor)."' AND type IN(0,1) order by id ASC LIMIT 1";
													$assignorID = 0;
													$queryResult =  $con->query($queryCheck);
													if($queryResult && mysqli_num_rows($queryResult) > 0) {
														$row = mysqli_fetch_array($queryResult);
														$assignorID = $row['id'];
													}  else {
														$queryCheck = "SELECT id,description FROM lead_patent_assignment WHERE  patent_number='".$getPatentNumber."' AND name = '".mysqli_real_escape_string($con,$assignor)."' AND type = 2 order by id ASC LIMIT 1";
														$queryResult =  $con->query($queryCheck);
														if($queryResult && mysqli_num_rows($queryResult) > 0) {
															$row = mysqli_fetch_array($queryResult);
															$assignorID = $row['id'];
														}
													}
													if($assignorID == 0) {
														$queryInsertAssignment = "INSERT INTO lead_patent_assignment(lead_id,patent_number,name,description,execution_date,recorded,type,reel_no,frame_no,document_file) VALUES (".$leadID.",'".$getPatentNumber."','".mysqli_real_escape_string($con,$assignor)."','".mysqli_real_escape_string($con,$description)."','".$executedDate."','".$recorded."',1,'".$docs['reelNo']."','".$docs['frameNo']."','".$fileName."')";
														$con->query($queryInsertAssignment);
														$assignorID = mysqli_insert_id($con); 
														//echo "NEW<br/>";
													}
													//echo $assignorID ."<br/>";
													if($assignorID > 0) {
														$connectionType = 2;
														$insertBulkRelation ="INSERT INTO lead_patent_assigment_relation(lead_id,patent_number,parent_id,child_id,connection_type,frame,reel,description,date,assignment_no) VALUES (".$leadID.",'".$getPatentNumber."',".$assignorID.",".$assigneeID.",".$connectionType.",'".$docs['frameNo']."','".$docs['reelNo']."','".$description."','".substr($docs['patAssignorEarliestExDate'],0,10)."','".$counter."') ";
														echo $insertBulkRelation."<br/>";
														$con->query($insertBulkRelation);
														if(!in_array($assignee,$insertAllNames)) {
															array_push($insertAllNames,$assignee);
														}
														if(!in_array($assignor,$insertAllNames)) {
															array_push($insertAllNames,$assignor);
														}
														if(!in_array(strtoupper(strtolower($description)),$insertAllHeading)) {
															array_push($insertAllHeading,strtoupper(strtolower($description)));
														}
													}
												}
											}
										}								
									}
								}
								$counter++;
							}
							if(count($insertAllNames)>0){
								$nameQuery = "";
								echo "<pre>";
								print_r($insertAllNames);
								echo "</pre>";
								foreach($insertAllNames as $name) {
									$queryName = "SELECT id FROM lead_assignment_names WHERE original = '".mysqli_real_escape_string($con,$name)."' AND patent_number='".$getPatentNumber."'";
									$queryNameResult =  $con->query($queryName);
									if($queryNameResult && mysqli_num_rows($queryNameResult) == 0) {
										$nameQuery .="('".$getPatentNumber."','".mysqli_real_escape_string($con,$name)."',''), ";
									}
								}
								$nameQuery = substr($nameQuery,0,-2);
								$nameQuery = "INSERT INTO lead_assignment_names(patent_number,original,modified) VALUES ".$nameQuery;
								echo $nameQuery."<br/>";
								$con->query($nameQuery);
							}
							if(count($insertAllHeading)>0){
								$nameQuery = "";
								echo "<pre>";
								print_r($insertAllHeading);
								echo "</pre>";
								foreach($insertAllHeading as $name) {
									if($name != "") {
										$queryName = "SELECT id FROM lead_assignment_heading WHERE original = '".mysqli_real_escape_string($con,$name)."' AND patent_number='".$getPatentNumber."'";
										$queryNameResult =  $con->query($queryName);
										if($queryNameResult && mysqli_num_rows($queryNameResult) == 0) {
											$nameQuery .="('".$getPatentNumber."','".mysqli_real_escape_string($con,$name)."',''), ";
										}
									}						
								}
								if($nameQuery != "") {
									$nameQuery = substr($nameQuery,0,-2);
									$nameQuery = "INSERT INTO lead_assignment_heading(patent_number,original,modified) VALUES ".$nameQuery;
									echo $nameQuery."<br/>";
									$con->query($nameQuery);
								}					
							}
						endif;
					}
				}				
			}
		}catch(Exception $e) {
			
		}
	}
}