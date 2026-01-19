<?php 
$jsonRelations = array();
$jsonRectangles = array();
$searchPatent = "";
$svgWidth = 500;
$svgHeight = 500;
/*if(strlen($searchPatent)>9){
	$searchPatent = substr($searchPatent,0,9);
}*/
$height = 72;
$width = 190;
$fS = false;
function cleanString($string){
	$string = trim($string);
	$string = strip_tags($string);
	$string = preg_replace("/;/", "",$string);
	$string = preg_replace("/'/", "",$string);
	$string = preg_replace("/\"/", "",$string);
	$regex = '/(\s|\\\\[rntv]{1})/';
	$string = preg_replace($regex, ' ', $string);
	return $string;
}

$findGreenRelease = array();
$airAssignor = array();
/*on Air Assignors*/
if(count($family_data['list'])>0){ 
	for($i=0;$i<count($family_data['list']);$i++){
		if($family_data['list'][$i]->type == 2) {
			array_push($airAssignor,$family_data['list'][$i]);
		}
	}
}
$lastBigX = 70;
if(count($family_data['list'])>0){
	$cpCount = 0;
	$chCount = 1;
	for($i=0;$i<count($family_data['list']);$i++){
		$family = $family_data['list'][$i];
		$same = false;
		$fillingDate = $family->execution_date;
		$fillingType = $family->type;
		$previousFillingDate = "";
		$previousType = "";
		$outside = false;
		if($i>0){
			$previousFillingDate = $family_data['list'][$i-1]->execution_date;
			$previousType = $family_data['list'][$i-1]->type;
		}
		if($previousFillingDate == $fillingDate){
			
			if($fillingType == $previousType) {
				$same = true;	
				$cpCount++;
			}			
			$w = $cpCount*220;
			$w = $w + 220;
			if($w>$svgWidth){
				$svgWidth = $w;
			}
		} else {
			$cpCount = 0;
		}
		$family_data['list'][$i]->same = $same;
		$family_data['list'][$i]->count = $cpCount;
		if($i==0){
			$x = 70;
			$y = 10;
		} else {
			$x = 70;
			$y = (int)$family_data['list'][$i-1]->y_axis + 140;
			
			if($same===true){
				$previousSame = $family_data['list'][$i-1]->same;
				if($previousSame==true){
					$x = (int)$family_data['list'][$i-1]->x_axis + 220;
					$y = (int)$family_data['list'][$i-1]->y_axis;
					if($family_data['list'][$i]->type == 2) { 
						if($family_data['list'][$i - 1]->type != 2) { 
							$x = (int)$family_data['list'][$i-1]->x_axis;
						}
					}
				} else {
					if($fS===false){
						if($cpCount==1){
							$x = 290;
							if($family_data['list'][$i]->type == 2) { 
								if($family_data['list'][$i - 1]->type != 2) { 
									$x = (int)$family_data['list'][$i-1]->x_axis;
								}
							}
						} else {
							$x = $family_data['list'][$i-1]->y_axis + 190;
							if($family_data['list'][$i]->type == 2) { 
								if($family_data['list'][$i - 1]->type != 2) { 
									$x = (int)$family_data['list'][$i-1]->x_axis;
								}
							}
						}
						$fS = true;
					} else {
						$x = 290;
						if($family_data['list'][$i]->type == 2) { 
							if($family_data['list'][$i - 1]->type != 2) { 
								$x = (int)$family_data['list'][$i-1]->x_axis;
							}
						}
					}					
				}
				if($same == true) {
					if($family_data['list'][$i]->type == 2) {
						if($family_data['list'][$i - 1]->type == 1) {
							$y = (int)$family_data['list'][$i-1]->y_axis + 100;
							$chCount++;
						} else {
							$y = (int)$family_data['list'][$i-1]->y_axis;
						}
					} else {
						$y = (int)$family_data['list'][$i-1]->y_axis;
					}
				} else {
					$y = (int)$family_data['list'][$i-1]->y_axis;
				}
				
				
				/*
				if($family_data['list'][$i]->type == 2 && $previousSame != true ) {
					$y = (int)$family_data['list'][$i-1]->y_axis + 100;
				} else if($family_data['list'][$i - 1]->type == 1 && $family_data['list'][$i]->type == 2 && $previousSame == false && $same == true) {
					$y = (int)$family_data['list'][$i-1]->y_axis + 100;
				} else {
					
				}	*/			
			} else {
				$chCount++;
			}
		}
		if($x>$lastBigX) {
			$lastBigX = $x;
		}
		$family_data['list'][$i]->x_axis = $x;
		$family_data['list'][$i]->y_axis = $y;
		$family_data['list'][$i]->width = $width;
		$family_data['list'][$i]->height = $height;
	}
	/*Move banks to different index*/
	for($i=0;$i<count($family_data['list']);$i++) {
		if($i > 0) {
			$current = $family_data['list'][$i];
			$previous = $family_data['list'][$i-1];
			$currentY = $current->y_axis;
			$previousY = $previous->y_axis;
			$previousName = $previous->description;
			$currentName = $current->description;
			$indexStart = -1;
			if((int)$previousY == (int)$currentY) {
				/*Check bank institute*/				
				$start =  false;
				if(strpos(strtolower($previousName),"security interest") !== false && strpos(strtolower($previousName),"release") === false) {
					$indexStart = $i-1;
				} else if(strpos(strtolower($currentName),"security interest") !== false && strpos(strtolower($currentName),"release") === false) {
					$indexStart = $i;
					$start = true;
				}				
			} else if(strpos(strtolower($currentName),"security interest") !== false && strpos(strtolower($currentName),"release") === false) {
				$indexStart = $i;
				$start = true;
			}
			if($indexStart >=0) {
				$returnIndexArray = findUpdateBankAxis($indexStart,$family_data['list'],$start);
				if(count($returnIndexArray['list']) > 0 ) {
					$family_data['list'] = $returnIndexArray['list'];
					if($returnIndexArray['max'] >= 0) {
						$i = $returnIndexArray['max'];
					}
				}
			}
		}
	}
	/*On Air Assignors rectangles X and Y*/
	if(count($airAssignor) >0 ) {
		for($i=0;$i<count($airAssignor);$i++){
			$x = $lastBigX;
			if($i==0){
				$y = 10;
			} else {
				$y = (int)$airAssignor[$i-1]->y_axis + 40;
			}
			$airAssignor[$i]->x_axis = $x;
			$airAssignor[$i]->y_axis = $y;
			$airAssignor[$i]->width = 320;
			$airAssignor[$i]->height = 30;
			$t = 0;
			foreach($family_data['list'] as $list){
				if($list->id == $airAssignor[$i]->id) {
					$family_data['list'][$t]->x_axis = $x;
					$family_data['list'][$t]->y_axis = $y;
					$family_data['list'][$t]->width = 320;
					$family_data['list'][$t]->height = 30;
					break;
				}
				$t++;
			}			
		}		
	}
	
	/*$svgWidth += 420;*/
	$svgHeight = $chCount * 155;
	$verticals = array();
	/*Find Verticals*/
	if(count($family_data['list'])>0){
		for($i=0;$i<count($family_data['list']);$i++){
			$relation = $family_data['list'][$i]->relation;
			$xAppNumber = $family_data['list'][$i]->id;
			$xAxis = $family_data['list'][$i]->x_axis;
			$yAxis = $family_data['list'][$i]->y_axis;
			if(count($relation)>0){
				foreach($relation as $rel){
					$relAppNumber = $rel->parent_id;
					foreach($family_data['list'] as $assets){
						if($assets->id == $relAppNumber && $xAxis == $assets->x_axis && $assets->x_axis<=70){
							$verticals[] = array("id"=>$xAppNumber.$rel->child_id,"yexit"=>$yAxis,"yentry"=>$assets->y_axis);
							break;
						}
					}
				}
			}
		}
	}
	/*for($i=0;$i<count($family_data['list']);$i++) {
		$conveyanceText = $family_data['list'][$i]->description;
		$family_data['list'][$i]->original_description = $conveyanceText;
		foreach($family_data['all_assignment'] as $assignment) {
			if($assignment->original == $conveyanceText) {
				if($assignment->modified != "") {
					$conveyanceText = $assignment->modified;
				}
				break;
			}
		}
		if($conveyanceText != "") {
			$family_data['list'][$i]->description = $conveyanceText;
		}
	}	*/
	$jsonRectangles = $family_data['list'];
	$childListIDs = array();
	$childList = array();
	$parentList = array();
	$applicationListIDS = array();
	if(count($jsonRectangles)>0){
		foreach($jsonRectangles as $rectangle){
			$applicationListIDS[] = $rectangle->id;
		}
	}
	if(count($jsonRectangles)>0){
		foreach($jsonRectangles as $rectangle){
			if(count($rectangle->relation)>0){				
				foreach($rectangle->relation as $relation){
					$pID = $relation->parent_id;
					$cID = $relation->child_id;
					$ID = $pID.$cID;
					if(in_array($cID,$applicationListIDS)==true){
						$entry = false;
						if(count($childListIDs)>0){
							if(in_array($ID,$childListIDs)==false){
								$childListIDs[] = $ID;
							} else {
								$entry = true;
							}
						}						
						if($entry===false){
							if(count($childList)==0){
								$childList[] = array($pID,1,155);
								$parentList[] = array($cID,1,155);
							}else {
								$findApp = false;
								$findPApp = false;
								for($i=0;$i<count($childList);$i++){
									if($childList[$i][0]==$pID){
										$childList[$i][1] = $childList[$i][1]+1;
										$childList[$i][2] = (float) number_format(155/$childList[$i][1],2, '.', '');
										$findApp = true;
										break;
									}
								}
								if($findApp === false){
									$childList[] = array($pID,1,155);
								}
								for($i=0;$i<count($parentList);$i++){
									if($parentList[$i][0]==$cID){
										$parentList[$i][1] = $parentList[$i][1]+1;
										$parentList[$i][2] = (float)number_format(155/$parentList[$i][1],2, '.', '');
										$findPApp = true;
										break;
									}
								}
								if($findPApp === false){
									$parentList[] = array($cID,1,155);
								}
							}							
						}
					}					
				}
			}
		}
	}
	
	if(count($family_data['list'])>0){
		foreach($family_data['list'] as $rec){
			if(count($rec->relation)>0){
				foreach($rec->relation as $relation){
					$jsonRelations[] = $relation;
				}				
			}			
		}
	}
	/*if(count($airAssignor)>0){
		foreach($airAssignor as $rec){
			if(count($rec->relation)>0){
				foreach($rec->relation as $relation){
					$jsonRelations[] = $relation;
				}				
			}			
		}
	}*/
	$grAdded = array();
	$re = 0;
	$removeConnections = array();
	foreach($jsonRelations as $relation){		
		if($relation->connection_type == 2) {			
			$parentID = $relation->parent_id;
			$childID = $relation->child_id;
			$parentData = findIndex($family_data['list'],$childID);
			if(count($parentData) == 1){
				$childData = findIndex($family_data['list'],$parentID);
				if(count($childData) == 1) {			
					$pRelation = array();
					foreach($jsonRelations as $r){
						if($r->parent_id == $childID && $r->child_id == $parentID) {
							$pRelation = $r;
							break;
						}
					}	
					if(count($pRelation) >0 ) {
						$pRelation->description = 'RELEASE OF SECURITY INTEREST';
						$pRelation->parent_name = $parentData[0]->name;
						$pRelation->child_name = $childData[0]->name;
						$jsonRelations[$re]->org_relation = $pRelation;
					} else {
						array_push($removeConnections,$relation->id);
					}
				}
			}
		}
		$re++;
	}

	
	for($i=0;$i<count($jsonRelations);$i++) {
		foreach($removeConnections as $r){
			if($r == $jsonRelations[$i]->id) {
				unset($jsonRelations[$i]);
				break;
			}			
		}
	}
	/*array_values not working*/
	$temp = array();
	foreach($jsonRelations as $r){
		array_push($temp,$r);
	}
	$jsonRelations = $temp;
}
function findUpdateBankAxis($startIndex,$list,$start){
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
function findParent($foundChList,$childID,$list,$parentName,$description,$executionDate,$frameNo,$reelNo) {
	$data = array('parent'=>0,'foundChList'=>$foundChList);
	foreach($list as $l){
		$IDD = $l->id.$childID;
		$entry = true;
		if(count($data['foundChList']) >0 ) {
			if(in_array($l->id.$childID,$data['foundChList'])){
				$entry = false;
			}
		} else {
			/*echo "ZERO Records<br/>";*/
		}
		if($entry === true && $l->name == $parentName && $l->description == $description && $l->execution_date == $executionDate && $l->frame_no == $frameNo && $l->reel_no == $reelNo) {
			/*echo "Search for:".$parentName."@Description:".$description."@ExecutionDate:".$executionDate."@reelNo:".$reelNo."@frameNo:".$frameNo."<br/>";
			echo "<pre>";
			print_r($l);
			echo "</pre>";*/
			$data['parent'] = $l->id;
			array_push($data['foundChList'],$l->id.$childID);
			break;
		}
	}
	return $data;
}
function findIndex($array,$findValue){
	$findArray = array();
	foreach($array as $list){
		if($list->id == $findValue){
			array_push($findArray,$list);
			break;
		}
	}
	return $findArray;
}

function sort_array_of_array(&$array, $subfield){
    $sortarray = array();
    foreach ($array as $key => $row)
    {
        $sortarray[$key] = $row[$subfield];
    }

    array_multisort($sortarray, SORT_ASC, $array);
}
if(count($verticals)>0){
	sort_array_of_array($verticals, 'yentry');
	sort_array_of_array($verticals, 'yexit');
	if(count($verticals)>15){
		$gapValue = 180/count($verticals);
	} else {
		$gapValue = 9;
	}
	/*$gapValue = 9;*/
	$start = 80;
	for($i=0;$i<count($verticals);$i++){
		if($i>0){$start +=$gapValue;}
		$verticals[$i]['x_axis'] = $start;
	}
}

$nonVerticalsEntries = array();
$nonVerticalsExits = array();
$childAppNumber = array();
if(count($family_data['list'])>0){
	for($i=0;$i<count($family_data['list']);$i++){
		$rect = $family_data['list'][$i];
		$relation = $rect->relation;
		$xAppNumber = $rect->id;
		$xAxis = $rect->x_axis;
		$yAxis = $rect->y_axis;
		$childX = 0;
		$parentCount = 0;
		if(count($relation)>0){
			$xCount = $xAxis;
			$parentCount = 1;
			$childECount = 0;
			$childXCount = 0;
			foreach($relation as $rel){
				$relationNumber = $rel->child_id;
				$childX = 0;
				if(count($childAppNumber)>0){
					foreach($childAppNumber as $chd){
						if($chd['app_number'] == $relationNumber){
							$childX = $chd['x_axis'];
							break;
						}
					}
				}
				if($childX==0){
					foreach($family_data['list'] as $assets){
						if($assets->id==$relationNumber){
							$childX = $assets->x_axis;
							$childAppNumber[] =array('app_number'=>$relationNumber,'x_axis'=>$assets->x_axis);
							break;
						}
					}
				}
				if($childX>0 && $xAxis!=$childX){
					foreach($family_data['list'] as $assets){
						if(count($assets->relation)>0){
							foreach($assets->relation as $aRelation){
								if($aRelation->child_id == $relationNumber ){
									$parentCount++;
									$xCount +=$assets->x_axis;
									break;
								}
							}
						}
					}
					$entry = "";
					$avg = $xCount/$parentCount;
					if($avg>$childX){
						$entry = "right";
					}else if($avg<$childX){
						$entry = "left";
					}else if($avg==$childX){
						$entry = "center";
					}
					if($entry!=""){
						$nonVerticalsEntries[] = array('app_rel_number'=>$xAppNumber.$relationNumber,'entry'=>$entry,'avg'=>$avg,'parent_count'=>$parentCount,'childX'=>$childX);
					}
					$childECount +=$childX;
					$childXCount++;
				}
			}
			if($childXCount>0){
				$avg = $childECount/$childXCount;
				if($avg>$xAxis){
					$entry = "right";
				}else if($avg<$xAxis){
					$entry = "left";
				}else if($avg==$xAxis){
					$entry = "center";
				}
				if($entry!=""){
					$nonVerticalsExits[] = array('app_rel_number'=>$xAppNumber,'entry'=>$entry,'avg'=>$avg,'parent_count'=>$childXCount,'childX'=>$xAxis);
				}
			}
		}
	}
}

?>
<!DOCTYPE html>
<meta charset="utf-8">
<link href="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//backyard.synpat.com/public/tiff.min.js"></script>
<script src="//backyard.synpat.com/public/jquery.tablesorter.min.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" ></script>
<!--<script src="//backyard.synpat.com/public/dragscroll.js" ></script>-->
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
text {
  font-size:12px;font-family:arial;
}
.search-form-help-text{position:absolute;width:320px;padding:10px;border:1px solid #e4e4e4;z-index:999999;background:#f8f9fa;top:27px;/*box-shadow:0 0 10px 6px rgba(0,0,0,.1);*/border-radius:2px;right:0;}.search-form-help-text dl,.search-form-help-text p,.search-form-help-text p a{font-size:15px}
.card-body {
	font-size: 14px;
	font-family: Arial,sans-serif;
}
.tab-content>.tab-pane{padding-top:10px; font-size:14px;font-family:Arial,sans-serif;color:#333;}
body{overflow:hidden;}
div#patent_block{overflow:scroll;min-width:500px;height:500px;}
#accordionExample,#accordionExample h6{font-size:14px !important;font-family:Arial,sans-serif !important;color:#444;}
#accordionExample h6{padding:0px;margin-left:10px;font-weight:700;text-transform:uppercase;}
.nav-link{padding:.4em 9px;}
.table td, .table th{border:0px;padding: 0 0 10px 0;}
#abstract,#claim{line-height:1.40;}
::-webkit-scrollbar {
  -webkit-appearance: none;
  width: 7px;
}
#claim p{float:left;}
::-webkit-scrollbar-thumb {
  border-radius: 4px;
  background-color: rgba(0, 0, 0, .5);
  -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
}	
#abstract,#claim,#figure,#date,#assigments, #abstract p,#claim p,#date table,#assigments table{color:#444 !important;}
#assigments td span{margin-left:2px;}
#date table,#assigments table{margin-bottom:0px;}
#figure a.open_big{margin-top:1px;}
#abstract,#claim,#figure,#date,#assigments{margin:0 0 0 10px}
/*body {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
	font-family:Arial,sans-serif;
}*/
.dashed{
   stroke-dasharray: 2,2; 
}
path.curlyBrace {
  fill: none;
  stroke: #999;
  stroke-width: 1.5px;
  stroke-dasharray: 2,2; 
}
.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{background-color:inherit !important;border-color:inherit;}
.nav-tabs .nav-link, .nav-tabs{border:0px;}
.nav-link,.nav-link:hover{text-decoration:underline}
.positionR{position:absolute;z-index:-9999}
#relative{position:relative;}
.filetree, .treeview ul {
    padding: 0;
    margin: 0;
    list-style: none;
}
li {
    list-style: none;
}
.filetree li {
    margin: 0;
    padding: 3px 0 3px 16px;
}
.filetree .node {
    background: url(https://worldwide.espacenet.com/images/treeview-default-line.gif) 0 -176px no-repeat;
}
.filetree .leaf {
    background: url(https://worldwide.espacenet.com/images/treeview-default-line.gif) 0 0 no-repeat;
}
.filetree .hitarea {
    background: url(https://worldwide.espacenet.com/images/treeview-default.gif) -64px -25px no-repeat;
    height: 16px;
    width: 16px;
    margin-left: -16px;
    float: left;
    cursor: pointer;
}
.collapsed .hitarea {
    background-position: -80px -3px;
}
.leaf .hitarea {
    background: 0;
}
.filetree .node.last>.hitarea {
    background-position: 0 -111px;
}
.filetree .node.collapsed.last>.hitarea {
    background-position: -32px -67px;
}
#tree{overflow:auto;}
#legend ul li{float:left;margin-right:5px;width:100%;}
.sm-width3{width:30px;height:10px;display:inline-block;}
.connection{fill: none;stroke-width: 2px;}
.tooltip {
    position: absolute;
    pointer-events: none;
    font-size: 0.7em;
    font-family: sans-serif;
    padding: 3px;
    width: auto;
    height: auto;
    background-color: #F2F2F2;
    -webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.4);
    -mox-box-shadow: 0px 0px 0px 5px rgba(0, 0, 0, 0.4);
    box-shadow: 0px 0px 5px rbga(0, 0, 0, 0.4);
    pointer-events: none;
}
p.value{
    white-space: pre-line;
    margin: 0;
}
.text_marker{cursor:context-menu;}
.rec,.text_marker1,.text_marker2,image,.text_marker4{cursor:pointer;}
@media (min-width: 970px){
	.col-lg-1 {
		-ms-flex: 0 0 10.333333%;
		flex: 0 0 10.333333%;
		max-width: 10.333333%;
	}
	.col-lg-10 {
		-ms-flex: 0 0 81.333333%;
		flex: 0 0 78.333333%;
		max-width: 78.333333%;
	}
}
.data-tab-icon {
    font-size: 15px !important;
    color: #007bff !important;
    position: relative;
    left: 20px;
}
.container_w {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
.container_w .row{float:left;width:100%;}
.nav{width:100%;}
.caption {
    font-size: 12px;
    color: grey;
}
#assignment_template{font-family:"Helvetica";width:100%;}
#assignment_template, #assignment_template p, #assignment_template p a, #assignment_template span {font-size:13px !important;}
#assignment_template p {
    margin-bottom: 0;
	color:#444;
}
#assignment_template a{color:#C20000;text-decoration:none;cursor:text;}
#assignment_template .tbl-properties-col a{color:#15c;}
#assignment_template .h3, #assignment_template h3.headline span {
    font-size: 20px !important;
    font-weight: 600;
	color:#222
}
#assignment_template h3.headline.skinny span {
    font-weight: 200;
    margin-top: 0;
}

#assignment_template .table>thead>tr>th {
    font-weight: 600;
}
</style>
<body>
<script src="//d3js.org/d3.v4.min.js"></script>
<div id="legend" class="col-lg-12" style="display:none">
	<ul class="nav">
	</ul>
</div>
<div style='margin-top:20px;'>
<button onclick="getAllNames()" id="btnEntries" class="btn btn-primary" style="float:right;margin-right:30px;" type="button">Entities</button>
<button onclick="rebuildIllustration()" id="btnRebuild" class="btn btn-primary" style="float:right;margin-right:30px;" type="button">Rebuild</button>
<button onclick="showHideLegend()" id="btnLegend" class="btn btn-primary" style="float:right;margin-right:30px;" type="button">Legend</button>
<button onclick="getAllAssignment()" id="btnAssignments" class="btn btn-primary" style="float:right;margin-right:30px;" type="button">Assignments</button>
</div>
<div id="patent_block">
	<div id="relative"></div>
</div>
<script>
_width = <?php echo $svgWidth;?> + 50;
_height = '<?php echo $svgHeight;?>';
var numberp = '<?php echo $number?>';
_defaultGap = 30;
var namesList = '<?php echo json_encode($family_data['all_names']);?>';
var assignmentList = [
	<?php 
		if(count($family_data['all_assignment']) > 0) {
			foreach($family_data['all_assignment'] as $name) {
				$modified = $name->modified;
				$original = $name->original;
				$modified = preg_replace("/\"/","",$modified);
				$original = preg_replace("/\"/","",$original);
				echo '{original:"'.$original.'",id:'.$name->id.',modified:"'.$modified.'"},';
			}
		}
	?>
];
function showHideLegend() {
	if($('body').find('#show_legend').length > 0 ){ 
		$('body').find('#show_legend').remove();
	} else {
		$('.search-form-help-text').remove();
		var offset = jQuery("#btnLegend").offset();
		var position = jQuery("#btnLegend").position();
		_b=0,_r=0;
		var windowWidth = jQuery(window).width();
		var popWidth = 400;
		_t = position.top + 45;
		_l = windowWidth - popWidth; 
		$('#patent_block').append('<div id="show_legend" class="loading search-form-help-text" style="top:'+_t+'px;left:'+_l+'px;right:'+_r+'px;bottom:'+_b+'px;width:'+popWidth+'px;height:'+_toolTipHeight+'px;overflow:hidden;overflow-y:auto;background:#fff;"></div>');
		$("#show_legend").append(document.getElementById('legend').outerHTML);
		$("#show_legend").find("#legend").show();
		setTimeout(function(){$("#show_legend").removeClass('loading');},300);
	}
}
function rebuildIllustration() {
	jQuery.ajax({
		type:'GET',
		url: 'https://backyard.synpat.com/assignement_xml.php?n='+numberp,
	}).done(function(s){
		window.location = window.location.href;
	});
}
function getAllAssignment(){
	if($('body').find('#show_assignments').length > 0 ){
		$('body').find('#show_assignments').remove();
	} else {
		if(assignmentList != "") {
			try{
				var fullList = assignmentList;
				var table = "<table class='table table-striped tablesorter table_entities' id='table_entities'><thead><tr class='entities_row'><th class='entities_col'>Original</th><th class='entities_col'>Modified</th></tr></thead><tbody>";
				fullList.forEach(function(name){
					table += "<tr data-id='"+name.id+"' data-name='lead_assignment_heading_modified' class='entities_row'><td class='entities_col'>"+name.original+"</td><td class='entities_col'><input type='text' value='"+name.modified+"' style='width:350px;' class='txt_modified' /></td></tr>";
				});
				table += "</tbody></table>";
				var offset = jQuery("#btnAssignments").offset();
				var position = jQuery("#btnAssignments").position();
				_b=0,_r=0;
				var windowWidth = jQuery(window).width();
				var popWidth = 900;
				_t = position.top + 45;
				_l = windowWidth - popWidth; 
				$('.search-form-help-text').remove();
				$('#patent_block').append('<div id="show_assignments" class="loading search-form-help-text" style="top:'+_t+'px;left:'+_l+'px;right:'+_r+'px;bottom:'+_b+'px;width:'+popWidth+'px;height:'+_toolTipHeight+'px;overflow:hidden;overflow-y:auto;background:#fff;"></div>');
				$("#show_assignments").append(table);
				callSorttable("show_assignments");
				callOnChange();
				setTimeout(function(){$("#show_assignments").removeClass('loading');},300);
			}catch(e) {
				console.log(e)
			}		
		}
	}
}
function getAllNames() {
	if($('body').find('#show_table').length > 0 ){
		$('body').find('#show_table').remove();
	} else {
		if(namesList != "") {
			try{
				var fullList = JSON.parse(namesList);
				var table = "<table class='table table-striped tablesorter table_entities' id='table_entities'><thead><tr class='entities_row'><th class='entities_col'>Original</th><th class='entities_col'>Modified</th></tr></thead><tbody>";
				fullList.forEach(function(name){
					table += "<tr data-id='"+name.id+"' data-name='lead_assignment_name_modified' class='entities_row'><td class='entities_col'>"+name.original+"</td><td class='entities_col'><input type='text' value='"+name.modified+"' style='width:350px;' class='txt_modified'/></td></tr>";
				});
				table += "</tbody></table>";
				var offset = jQuery("#btnEntries").offset();
				var position = jQuery("#btnEntries").position();
				_b=0,_r=0;
				var windowWidth = jQuery(window).width();
				var popWidth = 900;
				_t = position.top + 45;
				_l = windowWidth - popWidth; 
				$('.search-form-help-text').remove();
				$('#patent_block').append('<div id="show_table" class="loading search-form-help-text" style="top:'+_t+'px;left:'+_l+'px;right:'+_r+'px;bottom:'+_b+'px;width:'+popWidth+'px;height:'+_toolTipHeight+'px;overflow:hidden;overflow-y:auto;background:#fff;"></div>');
				$("#show_table").append(table);
				callSorttable('show_table');
				callOnChange();
				setTimeout(function(){$("#show_table").removeClass('loading');},300);
			}catch(e) {
				console.log(e)
			}		
		}
	}	
}
function callSorttable(id) {
	$("#"+id).tablesorter();
}
function callOnChange() {
	jQuery('.txt_modified').on('keyup',function(){
		var $this = $(this);
		var ID = $this.parents('tr').attr('data-id');
		var fnName = $this.parents('tr').attr('data-name');
		if($this.val() != "") {
			jQuery.ajax({
				type:'POST',
				url: 'https://backyard.synpat.com/leads/'+fnName,
				data:{id:ID,value:$this.val()}
			}).done(function(s){
				console.log(s);
			});
		} else {
			alert("Value cannot be left blank");
		}	
	});
}
function hideThisConnection(o) {
	var assignmentText = o.parent().find('span.assignment-titles-col').text();
	if(o.is(':checked')){		
		if(assignmentText != "" && assignmentText != null) {
			disableConnection.push(assignmentText);
		}
	} else {
		var getIndex = disableConnection.indexOf(assignmentText);
		if(getIndex >= 0) {
			disableConnection.splice(getIndex,1);
		}
	}
	jQuery("#patent_block").find('svg').empty();
	linksPoint = [];
	linksRe = [];
	_linkage = 0;
	createIllustration();
}
function msieversion(){
	var ua = window.navigator.userAgent;
	var msie = ua.indexOf("MSIE");

	if (msie > 0) // If Internet Explorer, return version number
	{
		return true;
		//alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
	}
	else  // If another browser, return 0
	{
		return false;
		//alert('otherbrowser');
	}

	return false;
}
var tapC = false;
var _tapL = -1;
function differenceDates(_start,_end){
	var start = moment(new Date(_start));
	var end = moment(new Date(_end));
	var duration = moment.duration(end.diff(start));
	var days = duration.asDays();
	var years = duration.asYears();
	_year = parseInt(years);
	_rdays = 0;
	if(_year>0){
		_nDays = 365*_year;
		_rdays = days - _nDays;
	} else {
		_rdays = days;
	}
	_differenceString = [];
	if(_year>0){
		if(_year>1){
			_differenceString.push(_year+" years");
		} else {
			_differenceString.push(_year+" year");
		}
	}
	if(_rdays>0){
		if(_rdays>1){
			_differenceString.push(_rdays+" days");
		}else{
			_differenceString.push(_rdays+" day");
		}						
	}
	return _differenceString;
}
_allSameX = [];
function checkX1(X1){
	if(_allSameX.length==0){
		_allSameX.push(X1);
		var obj = {x1:X1,x2:X1};
		return obj;
	} else {
		if(jQuery.inArray(X1,_allSameX)){
			X1 = X1 + 10;
			return checkX1(X1);
		} else {
			_allSameX.push(X1);
			var obj = {x1:X1,x2:X1};
			return obj;
		}
	}
}
var jsonRectangles = [];
<?php 
	if(count($jsonRectangles)>0){
		for($i=0;$i<count($jsonRectangles);$i++){
			?>
			 var obj = {};
			<?php
			foreach($jsonRectangles[$i] as $key=>$dt){
					if(is_string($dt) || is_numeric($dt)){
			?>
						obj['<?php echo $key?>']= '<?php echo $dt;?>';
			<?php
					} else {
						$dt = json_encode($dt);
			?>
						obj['<?php echo $key?>']= JSON.parse('<?php echo $dt;?>');
			<?php
					}
			}
			?>
			jsonRectangles.push(obj);
		<?php
		}		
	}
?>
var jsonAirRectangles = [];
<?php
	if(count($airAssignor)>0){
		for($i=0;$i<count($airAssignor);$i++){
			?>
			 var obj = {};
			<?php
			foreach($airAssignor[$i] as $key=>$dt){
					if(is_string($dt) || is_numeric($dt)){
			?>
						obj['<?php echo $key?>']= '<?php echo $dt;?>';
			<?php
					} else {
						$dt = json_encode($dt);
			?>
						obj['<?php echo $key?>']= JSON.parse('<?php echo $dt;?>');
			<?php
					}
			}
			?>
			jsonAirRectangles.push(obj);
		<?php
		}		
	}
?>

var jsonRelations = JSON.parse('<?php echo json_encode($jsonRelations);?>');
jsonRelations.map(function(t,j){
	_s = -1;
	_t = -1;
	jQuery.each(jsonRectangles,function(i,s){
		if(s.id==t.parent_id){
			_s = i;
		}
		if(t.child_id == s.id){
			_t = i;
		}
		if(_s>=0 && _t>=0){
			return false;
		}
	});
	if(_s>=0 && _t>=0){
		jsonRelations[j].source = _s;
		jsonRelations[j].target = _t;
	}
});
links = [];
jQuery.each(jsonRelations,function(i,t){
	if(typeof t.source!="undefined" && typeof t.target!="undefined"){
		links.push(t);
	}
})

jsonRelations = links;
console.log("RELATIONS:",jsonRelations);

if(window.innerHeight>_height){
	_height = window.innerHeight - 20;
}

var svgContainer = d3.select("#patent_block").append("svg")
					.attr("width", _width)
					.attr("height", _height);
var root = d3.select("svg");
var scr = { x: window.scrollX, y: window.scrollY, w: window.innerWidth, h: window.innerHeight };
var body_sel = d3.select('body');
var body = { w: body_sel.node().offsetWidth, h: body_sel.node().offsetHeight };

jQuery('#patent_block').css({width:body.w+'px',height:(scr.h-60)+'px'});
jQuery(window).resize(function(){
	scr = { x: window.scrollX, y: window.scrollY, w: window.innerWidth, h: window.innerHeight };
 jQuery('#patent_block').css({width:window.innerWidth+'px',height:window.innerHeight+'px'});
});
var doc = { w: document.width, h: document.height };
var svgpos = getNodePos(root.node());
var dist = { x: 10, y: 10 };
var poke = false;
var glineSVGPath,bar,images,defs,marker,_status = "",_showConnections = true,_showArrow = true;
var _tooltipTop = -1, _tooltipLeft = -1;
var _color = ["800000","F08080","CD5C5C","008000","228B22","800080","FA8072","000080","FF4500","FFA500","808000","DAA520","696969","9400D3","32CD32","000000"];
function wrap(text, width,className) {
	text = svgContainer.selectAll('.'+className);
  text.each(function() {
    var text = d3.select(this),
        words = text.text().split(/\s+/).reverse(),
        word,
        line = [],
        lineNumber = 0,
        lineHeight = 1.1, // ems
        y = text.attr("y"),
        x = text.attr("x"),
        dy = parseFloat(text.attr("dy")),
        tspan = text.text(null).append("tspan").attr("x", x).attr("y", y).attr("dy", dy + "em");
	var stack = 1;	
    while (word = words.pop()) {
		if(stack == 3){
			word +='...';
		}
		line.push(word);
		tspan.text(line.join(" "));
		if (tspan.node().getComputedTextLength() > width ) {
			stack++;
			line.pop();
			tspan.text(line.join(" "));
			line = [word];
			if(stack<3){
				tspan = text.append("tspan").attr("x", x).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
			}
		}
		if(stack == 3){
			return false;
		}
    }
  });
}

function type(d) {
  d.value = +d.value;
  return d;
}
function openReelFrame(a,t) {
	if($('#reel_frame'+a.id).length==0){ 
		$('.search-form-help-text').remove();
		console.log("ReelHTML");
		var m = d3.mouse(t);
		_top = m[1];
		if(_top>100){
			_top = _top - 20;
		}
		var windowWidth = $(window).width();
		var boxWidth = 750;
		left = windowWidth - boxWidth - 10;
		$('body').append('<div id="reel_frame'+a.id+'" class="reel_frame search-form-help-text loading" style="top:100px;left:'+left+'px;width:'+boxWidth+'px;height:500px;overflow:hidden;overflow-y:auto"></div>');
		$("#reel_frame"+a.id).append('Loading...');
		jQuery.ajax({
			type:'GET',
			url:'https://backyard.synpat.com/public/upload/'+numberp+'.json',
			cache:false
		}).done(function(s){
			console.log(a);
			var assignmentHTML = '';
			if(s != "" && typeof s.response != "undefined") {
				if(typeof s.response.docs != "undefined" && s.response.docs.length > 0) {
					var selectPointParent;
					var fieldName = "child_id";
					if(a.reverse ==1) {
						fieldName = "org_relation_child_id";
					}
					if(parseInt(a.connection_type) == 0) {
						fieldName = "parent_id";
						if(a.reverse ==1) {
							fieldName = "org_relation_parent_id";
						}
					}
					jsonRectangles.forEach(function(r){
						if(r.id == a[fieldName]) {
							selectPoint = r;
							return;
						}
					})
					if(typeof selectPoint != "undefined" && typeof selectPoint.id != "undefined") {
						var aID = selectPoint.reel_no+'-'+selectPoint.frame_no;
						var docs = s.response.docs;
						var doc;
						docs.forEach(function(d){
							if(d.id == aID) {
								doc = d;
								return;
							}
						});
						if(typeof doc != "undefined" && typeof doc.id != "undefined") {
							var inventorsList = doc.inventors;
							var inventionTitle = doc.inventionTitle;
							var recordedDate = doc.recordedDate;
							recordedDate = recordedDate.substr(0,10);
							recordedDate = recordedDate+' 00:00:00';
							var frameNo = doc.frameNo;
							var reelNo = doc.reelNo;
							var patAssignorEarliestExDate = doc.patAssignorEarliestExDate;
							patAssignorEarliestExDate = patAssignorEarliestExDate.substr(0,10);
							patAssignorEarliestExDate = patAssignorEarliestExDate+' 00:00:00';

							var patAssignorName = doc.patAssignorName;
							var patAssigneeName = doc.patAssigneeName;
							var conveyanceText = doc.conveyanceText;
							var displayId = doc.displayId;
							displayId = displayId.replace('-','/');
							var reelTitle = "Patent assignment "+displayId;
							conveyanceText = conveyanceText.replace('(SEE DOCUMENT FOR DETAILS).','');
							conveyanceText = conveyanceText.replace('(SEE DOCUMENT FOR DETAILS)','');
							assignmentHTML += 
								'<div id="assignment_template">'+
									'<div class="word-export hightlight-section" id="printable-area">'+
										'<div class="row">'+
											'<div class="col-sm-12">'+
												'<h3 class="headline skinny">'+
													'<span class="ng-binding ng-scope">'+conveyanceText+'</span>'+
												'</h3>'+
											'</div>'+
										'</div>'+
										'<table class="table borderless tbl-assignment-details">'+
											'<tbody>'+
												'<tr class="tbl-assignment-row">'+
													'<td style="width:60%" class="tbl-assignment-col">'+
														'<p class="caption">Date recorded</p>'+
														'<p class="ng-binding">'+moment(new Date(recordedDate),'YYYY-MM-DD').format('MMM,DD YYYY')+'</p>'+
													'</td>'+
													'<td style="width:40%" class="tbl-assignment-col">'+
														'<p class="caption">Reel/frame</p>'+
														'<p>'+
															'<span ng-switch-when="false" class="ng-binding ng-scope">'+doc.displayId+'</span>'+
														'</p>'+
													'</td>'+
												'</tr>'+
												'<tr class="tbl-assignment-row">'+
													'<td style="width:60%" class="tbl-assignment-col">'+
														'<p class="caption">Assignors</p><p>';
							patAssignorName.forEach(function(assignor){
								assignmentHTML +='<a href="javascript://" style="width:100%;float:left;"><span class="ng-binding">'+assignor+'</span></a> ';
							});
							assignmentHTML += '	</p></td>'+
												'<td style="width:40%" class="tbl-assignment-col">'+
													'<p class="caption">Execution date</p>'+
													'<p class="ng-binding ng-scope">'+moment(new Date(patAssignorEarliestExDate),'YYYY-MM-DD').format('MMM,DD YYYY')+'</p>'+
												'</td>'+
											'</tr>'+
											'<tr class="tbl-assignment-row">'+
												'<td style="width:60%" class="tbl-assignment-col">'+
													'<p class="caption">Assignee</p>';
							patAssigneeName.forEach(function(assignee,i){
								assignmentHTML += '	<div style="width:100%; margin-bottom: 30px; font-size:13px;">';
								assignmentHTML += '<div class="pull-left" style="width:100%;">'+
									'<a href="javascript://"><span class="ng-binding">'+assignee+'</span></a>'+
								'</div>';
								if(typeof doc.patAssigneeAddress1[i] != "undefined" && doc.patAssigneeAddress1[i] != 'NULL') {
									assignmentHTML += '<div class="pull-left ng-scope" style="width:100%;"><span class="ng-binding">'+doc.patAssigneeAddress1[i]+'</span>'+
									'</div>';
								}
								if(typeof doc.patAssigneeAddress2[i] != "undefined" && doc.patAssigneeAddress2[i] != "NULL") {
									assignmentHTML += '<div class="pull-left ng-scope" style="width:100%;"><span class="ng-binding">'+doc.patAssigneeAddress2[i]+'</span>'+
									'</div>';
								}
								if(typeof doc.patAssigneeCity[i] != "undefined" && doc.patAssigneeCity[i] != 'NULL') {
									var postalCode = "";
									if(typeof doc.patAssigneePostcode[i] != "undefined" && doc.patAssigneePostcode[i] != "NULL") {
										postalCode = " "+doc.patAssigneePostcode[i];
									}
									assignmentHTML += '<div class="pull-left ng-scope" style="width:100%;"><span class="ng-binding">'+doc.patAssigneeCity[i]+postalCode+'</span>'+
									'</div>';
								}
								assignmentHTML += '	</div>';
							});
							assignmentHTML += '	</td>';
							assignmentHTML += '	<td style="width:40%" class="tbl-assignment-col">'+
													'<p class="caption">Correspondent</p>';
							if(typeof doc.corrName != "undefined" && doc.corrName!= 'NULL') {
								assignmentHTML += '	<span class="ng-binding ng-scope">'+doc.corrName+'</span><br/>';
								assignmentHTML += '<span>'+
													'<span class="ng-scope">';
								if(typeof doc.corrAddress1 != "undefined" && doc.corrAddress1 != "NULL") {
									assignmentHTML += '<span><span class="ng-binding ng-scope">'+doc.corrAddress1+'</span></span><br/>';
								}
								if(typeof doc.corrAddress2 != "undefined" && doc.corrAddress2 != 'NULL') {
									assignmentHTML += '<span><span class="ng-binding ng-scope">'+doc.corrAddress2+'</span></span><br/>';
								}
								if(typeof doc.corrAddress3 != "undefined" && doc.corrAddress3 != 'NULL') {
									assignmentHTML += '<span><span class="ng-binding ng-scope">'+doc.corrAddress3+'</span></span><br/>';
								}
								assignmentHTML += '</span></span>';
							}
							assignmentHTML += '	</td>'+
												'</tr>'+
											'</tbody>'+
										'</table>';
							assignmentHTML += '<div class="row">'+
													'<div class="col-sm-12">'+
														'<span class="pull-left">'+
															'<h4 class="ng-binding">Properties ('+inventionTitle.length+' total)</h4>'+
														'</span>'+
													'</div>'+
												'</div>';
							assignmentHTML  +=  '<div class="row">'+
													'<div class="col-sm-12">'+
														'<table class="table table-striped" id="table2" aria-hidden="false" style="">'+
															'<thead>'+
																'<tr role="row" class="ng-scope">'+
																	'<th align="left" class="tbl-properties-col">Patent</th>'+
																	'<th align="left" class="tbl-properties-col">Publication</th>'+
																	'<th align="left" class="tbl-properties-col">Application</th>'+
																	'<th align="left" class="tbl-properties-col">PCT</th>'+
																	'<th align="left" nowrap="" class="tbl-properties-col">International registration</th>'+
																'</tr>'+
															'</thead>'+
															'<tbody>';
								inventionTitle.forEach(function(invention,i){
									var t = i+1;
									assignmentHTML  +=  '<tr class="grey ng-scope" style="">'+
														'<td colspan="3" class="tbl-properties-col">'+
															'<p>'+
																'<strong class="ng-binding">'+t+'.</strong><span class="upperCase" >'+invention+'</span>'+
															'</p>'+
														'</td>'+
														'<td colspan="2" class="tbl-properties-col">&nbsp;</td>'+
													'</tr>';
									assignmentHTML  +=  '<tr class="ng-scope">'+
														'<td class="tbl-properties-col">'+
															'<p>';
									if(typeof doc.patNum != "undefined" && typeof doc.patNum[i] != "undefined" && doc.patNum[i] != null && doc.patNum[i] != 'NULL') {
										assignmentHTML  +=  '<a href="javascript://" alt="View assignment abstract of title" class="ng-scope" style=""><span class="ng-binding">'+doc.patNum[i]+'</span></a>';	
									}	
									assignmentHTML  +=  '</p>'+
														'</td>'+
														'<td class="tbl-properties-col">'+
															'<p>';
									if(typeof doc.publNum != "undefined" && typeof doc.publNum[i] != "undefined" && doc.publNum[i] != null && doc.publNum[i] != 'NULL') {
										assignmentHTML  +=  '<span class="ng-binding">'+doc.publNum[i]+'</span>';	
									}
									assignmentHTML  			+='</p>'+
															'<p></p>'+
														'</td>'+
														'<td class="tbl-properties-col">'+
															'<p>';
									if(typeof doc.applNum != "undefined" && typeof doc.applNum[i] != "undefined" && doc.applNum[i] != null && doc.applNum[i] != 'NULL') {
										assignmentHTML  +=  '<span class="ng-binding">'+doc.applNum[i]+'</span>';	
									}
									assignmentHTML  			+='</p>'+
														'</td>'+
														'<td class="tbl-properties-col">'+
															'<p>'+
																'<span class="ng-binding">';
									if(typeof doc.pctNum != "undefined" && typeof doc.pctNum[i] != "undefined" && doc.pctNum[i] != null && doc.pctNum[i] != 'NULL') {
										assignmentHTML  +=  doc.pctNum[i];	
									} else {
										assignmentHTML  +=  '&nbsp;';	
									}
									assignmentHTML  			+=	'</span>'+
															'</p>'+
														'</td>'+
														'<td class="tbl-properties-col">'+
															'<p>'+
																'<span class="ng-binding">';
									if(typeof doc.intlRegNum != "undefined" && typeof doc.intlRegNum[i] != "undefined" && doc.intlRegNum[i] != null && doc.intlRegNum[i] != 'NULL') {
										assignmentHTML  +=  doc.intlRegNum[i];	
									} else {
										assignmentHTML  +=  '&nbsp;';	
									}
								
								assignmentHTML  			+=	'</span>'+
															'</p>'+
														'</td>'+
													'</tr>';
								});
								assignmentHTML  			+=	'</tbody>'+
												'</table>'+
											'</div>'+
										'</div>'+
									'</div>'+
								'</div>';
							
						}
					}
				}
			}			
			$("#reel_frame"+a.id)
			.html(assignmentHTML)
			.removeClass('loading');
		});		
	} else {
		$('#reel_frame'+a.id).remove();
	}
}

function connectionTooltipOpen(a, t){
	console.log("Tooltip");
	var ID = a.id;
	if(a.connection_type == 1){
		ID = "r_"+a.org_relation.id;
	}
	if($('#tool_connection_'+ID).length==0){
		console.log("Tooltip display");
		var m = d3.mouse(t);
		_relationType = $('#'+ID).attr('data-connectiontype');
		if(_relationType==undefined){
			_relationType = "";
		}
		console.log(_relationType);
		_top = m[1];
		console.log(_top);
		var windowHeight = window.innerHeight;
		if(_top > windowHeight) {
			_height = parseInt(_height);
			var _per = _top / _height;
			console.log(_per);
			_top = (windowHeight * _per) - 200;
			if(_top<100) {
				_top = 100;
			}
			console.log(_top);
		} else {
			_top -= 20;
		}
		
		$('body').append('<div id="tool_connection_'+ID+'" class="search-form-help-text" style="top:'+_top+'px;left:'+m[0]+'px;opacity:0;"></div>');
		$('#tool_connection_'+ID).append("<p class='value'>"+_relationType+"</p>");
		$('#tool_connection_'+ID).animate({opacity:1},500);
	}
}
function connectionTooltipClose(a){
	var ID = a.id;
	if(a.connection_type == 1){
		ID = "r_"+a.org_relation.id;
	}
	if($('#tool_connection_'+ID).length>0){
		$('#tool_connection_'+ID).remove();
	}
}
var _toolTipWidth = 750;
var _toolTipHeight = 500;
var _toolTipEmbedHeight = 520;
function tooltipOpen(a){
	if($('#label_'+a.id).length==0){
		 poke = false;
		 var offset = jQuery("#rec_"+a.id).offset();
		 var position = jQuery("#rec_"+a.id).position();
		 _b=0,_r=0;
		  _l = position.left;
		  _t = position.top + 80;
		if(_tooltipTop>=0){
			_t = _tooltipTop;
		}
		if(_tooltipLeft>=0){
			_l = _tooltipLeft;
		}
		var windowWidth = jQuery(window).width();
		var popWidth = 900;
		_l = windowWidth - popWidth; 
		$('body').find('.search-form-help-text').attr("id","label_"+a.id).remove();
		$('#patent_block').append('<div id="label_'+a.id+'" class="search-form-help-text" style="top:'+_t+'px;left:'+_l+'px;right:'+_r+'px;bottom:'+_b+'px;width:'+popWidth+'px;height:550px;overflow:hidden;overflow-y:auto;"></div>');
		_pdfFileURL = a.document_file;
		if(_pdfFileURL!=""){
			$('body').find('#label_'+a.id).html('<embed src='+_pdfFileURL+'#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="'+_toolTipEmbedHeight+'px"/>');
		}		
	}
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
var linksPoint = [];
var linksRe = [];
var _chList = JSON.parse('<?php echo json_encode($childList);?>');
var _prList = JSON.parse('<?php echo json_encode($parentList);?>');
var _verticals = JSON.parse('<?php echo json_encode($verticals);?>');
var _nonverticals = JSON.parse('<?php echo json_encode($nonVerticalsEntries);?>');
var _nonverticalsExits = JSON.parse('<?php echo json_encode($nonVerticalsExits);?>');
var listDescription = [];
var disableConnection = [];
var descList = [];
var airAssignorIDs = [];
var _checkRelease = false;
if(jsonAirRectangles.length > 0) {
	jsonAirRectangles.map(function(a){
		airAssignorIDs.push(parseInt(a.id));
	});
}
if(jsonRectangles.length > 0) {
	jsonRectangles.map(function(m){
		var desc = m.description.toString();
		desc = desc.toLowerCase();
		desc = desc.toUpperCase();
		if(disableConnection.indexOf(desc) < 0) {
			disableConnection.push(desc);
		}
	});
	if(jsonRelations.length > 0) {		
		jsonRelations.map(function(m){
			if(m.connection_type == 2) {
				_checkRelease = true;
				return false;
			}
		});
		if(_checkRelease === true) {
			disableConnection.push('RELEASE OF SECURITY INTEREST');
		}
	}
	if(disableConnection.length > 0) {
		disableConnection.push('THIRD PARTY ASSIGNORS');
	}
}
var duration = 0;
var showThirdPartyAssignor = true;
function createIllustration(){
	if(_showConnections===true){
		duration = 0;
		_color = ["d62d20","ffa700","CD5C5C","008744","228B22","0057e7","FA8072","000080","808000","DAA520","696969","9400D3","32CD32","b3bc31","bc7d31","bc3161","ff00ee","000000"];
		defs = svgContainer.append('svg:defs');
		marker = defs.selectAll('marker')
		.data(_color)
		.enter()
		.append('svg:marker')
		.attr('id', function(d,i){return "markerREC_"+d;})
		.attr('markerHeight', 7)
		.attr('markerWidth', 7)
		.attr('orient', 'auto')
		.attr('xoverflow', 'visible')
		.attr('refX', 3)
		.attr('refY', 0)
		.attr('viewBox', '-0 -5 10 10')
		.append('svg:path')
		.attr('d', 'M 0,-5 L 10 ,0 L 0,5')
		.attr('fill', function(d,i){return "#"+d;})
		.style('stroke','none');
		var marker = defs.selectAll('.marker_1')
		.data(_color)
		.enter()
		.append('svg:marker')
		.attr('id', function(d,i){return "1_markerREC_"+d;})
		.attr('class', "marker_1")
		.attr('markerHeight', 4.5)
		.attr('markerWidth', 4.5)
		.attr('orient', 'auto')
		.attr('xoverflow', 'visible')
		.attr('refX', 3)
		.attr('refY', 0)
		.attr('viewBox', '-0 -5 10 10')
		.append('svg:path')
		.attr('d', 'M 0,-5 L 10 ,0 L 0,5')
		.attr('fill', function(d,i){return "#"+d;})
		.style('stroke','none');
		
		/*Connection Arrows Start*/
		glineSVGPath =  svgContainer
						.selectAll(".connection")
						.data(jsonRelations)
						.enter().append('svg:path')
						.attr('class','connection');
		glineSVGPath
		.attr('id',function(d){
			var ID = d.id;
			return ID;
		})
		.attr('d', function(d,i){
		_patentAppNumber = parseInt(d.parent_id);
		_relationAppNumber = parseInt(d.child_id);
		_type = 1;
		_description = "";
		_x1 = 0;
		_x2 = 0;
		_y1 = 0;
		_y2 = 0;
		var _findX = false;
		var parentElementShow = false;
		var parentDescription = "";
		jQuery.each(jsonRectangles,function(i,r){
			if(r.id == _patentAppNumber){
				_x1 = parseInt(r.x_axis) + 100.5;
				parentDescription = r.description;
				_type = r.type;
				_findX = true;
				return false;
			}
		});
		_count = 0;
		_linkage = 0;
		_vFound = false;
		_vFoundLinkage = false;
		if(linksPoint.length>0){
			jQuery.each(linksPoint,function(i,s){
				if(parseInt(s.ID)==parseInt(_relationAppNumber)){
					_count = s.child + 1;
					linksPoint[i].child = _count;
					_vFound = true;
					return false;
				}
			});
		}
		if(_count>0){
			d3.select(this).attr('count',_count);
		}
		if(_vFound===false){
			var ID = parseInt(_relationAppNumber);
			var child = 1;
			_count = 1;
			linksPoint.push({ID:ID,child:child});
		}
		if(linksRe.length>0){
			jQuery.each(linksRe,function(i,s){
				if(parseInt(s.ID)==parseInt(_patentAppNumber)){
					_linkage = s.link + 1;
					linksRe[i].link = _linkage;
					_vFoundLinkage = true;
					return false;
				}
			});
		} 
		if(_vFoundLinkage===false){
			var ID = parseInt(_patentAppNumber);
			var link = 1;
			_linkage = 1;
			linksRe.push({ID:ID,link:link});
		}
		if(_linkage>0){
			d3.select(this).attr('link',_linkage);
		}
		var _findX2 = false;

		jQuery.each(jsonRectangles,function(i,r){
			if(r.id == parseInt(_patentAppNumber)){
				jQuery.each(jsonRectangles,function(k,t){
					if(t.id == parseInt(_relationAppNumber)){
						if(parseInt(r.x_axis) == parseInt(t.x_axis)){
							_x2 = parseInt(r.x_axis) + 100.5;
						} else {
							_x2 = parseInt(t.x_axis) + 100.5;
						}
						if(d.id == 941){
							console.log("SSS:"+_x2);
						}
						return false;
					}
				});
				if(_x2==0){
					_x2 = parseInt(r.x_axis) + 100.5;
					if(d.id == 941){
						console.log("SSS1:"+_x2);
					}
				}
				_findX2 = true;
				return false;
			}
		});
			
		var ap = false;
		var _findY1 = false;
		var airParent  = false;
		if(airAssignorIDs.indexOf(_patentAppNumber)>=0){
			jQuery.each(jsonRectangles,function(p,r){
				if(parseInt(r.id) == _patentAppNumber){
					_y1 = parseInt(r.y_axis) + 30;
					airParent = true;
					return false;
				}
			});
		} else {
			jQuery.each(jsonRectangles,function(p,r){
				if(r.id == _relationAppNumber){
					jQuery.each(jsonRectangles,function(m,j){
						if(_patentAppNumber == j.id){
							_y1 = parseInt(j.y_axis);
							if(parseInt(j.type) == 2 && typeof (jsonRectangles[m-1]) !='undefined') {
								var sd = parseInt(findType(m,jsonRectangles));
								if(isNaN(sd) === false){
									_y1 = sd + 70;
									ap = true;
								}
							}
							return false;
						}
					});
					_findY1 = true;
					return false;
				}
			});
		}		
		var _findY2 = false;
		jQuery.each(jsonRectangles,function(i,r){
			if(r.id == _relationAppNumber){
				_description = r.description;
				jQuery.each(jsonRectangles,function(k,t){
					if(t.id == _patentAppNumber){
						if(parseInt(r.x_axis) == parseInt(t.x_axis)){
							_y2 = parseInt(r.y_axis);
						} else {
							_y2 = parseInt(r.y_axis);
						}
						return false;
					}
				});
				if(_y2==0){
					_y2 = parseInt(r.y_axis);
				}
				_findY2 = true;
				return false;
			}
		});
		if(parseInt(d.connection_type) == 2) {
			_description = 'RELEASE OF SECURITY INTEREST';
			_x2 -=100.5;
			_x1 -=100.5;
			if(ap === true) {
				_y1 -=70;
			}			
			if(airParent === true) {
				_y1 -=30;
			}
			if(d.id == 941){
				console.log("SSS2:"+_x2,_x1,_y1);
			}
		}
		_color = "#d62d20";
		_dType = _description;
		_dType = _dType.replace('(see document for details).','');
		_dType = _dType.trim();
		_dType = _dType.toLowerCase();
		_dType = _dType.toUpperCase();
		
		parentDescription= parentDescription.replace('(see document for details).','');
		parentDescription = parentDescription.trim();
		parentDescription = parentDescription.toLowerCase();
		parentDescription = parentDescription.toUpperCase();
		
		if(_dType.indexOf("ASSIGNMENT OF ASSIGNORS INTEREST") >= 0) {
			_color = "#d62d20";
		} else if(_dType.indexOf("RELEASE") >= 0  && _dType.indexOf("TERMINATION")<0) {
			_color = "#008744";
		} else if(_dType.indexOf("SECURITY") >= 0 || _dType.indexOf("LIEN") >= 0) {
			_color = "#ffa700";
		} else if(_dType.indexOf("NUNC PRO TUNC ASSIGNMENT") >= 0) {
			_color = "#CD5C5C";
		} else if(_dType.indexOf("MERGER") >= 0) {
			_color = "#228B22";
		} else if(_dType.indexOf("CHANGE OF NAME") >= 0) {
			_color = "#0057e7";
		} else if(_dType.indexOf("MERGER AND CHANGE OF NAME") >= 0) {
			_color = "#FA8072";
		} else if(_dType.indexOf("LICENSE") >= 0) {
			_color = "#000080";
		} else if(_dType.indexOf("MORTGAGE") >= 0) {
			_color = "#808000";
		} else if(_dType.indexOf("OPTION") >= 0) {
			_color = "#DAA520";
		} else if(_dType.indexOf("DECREE OF DISTRIBUTION") >= 0) {
			_color = "#696969";
		} else if(_dType.indexOf("LETTERS OF TESTAMENTARY") >= 0) {
			_color = "#9400D3";
		} else if(_dType.indexOf("LETTERS OF ADMINISTRATION") >= 0) {
			_color = "#32CD32";
		} else if(_dType.indexOf("COURT APPOINTMENT") >= 0) {
			_color = "#b3bc31";
		} else if(_dType.indexOf("CONDITIONAL ASSIGNMENT") >= 0) {
			_color = "#bc7d31";
		} else if(_dType.indexOf("COURT ORDER") >= 0) {
			_color = "#bc3161";
		} else if(_dType.indexOf("ASSIGNOR NAME") >= 0) {
			_color = "#ff00ee";
		}
		if(parseInt(d.connection_type) == 2) {
			/*if reverse than it always green*/
			_color = "#008744";
			d3.select(this).attr('data-reverse',1);
		}
		
		if(_color != "") {
			if(descList.indexOf(_dType) < 0) {
				descList.push(_dType);
				var descColor = {name:_dType,color:_color};
				listDescription.push(descColor);
			}			
		}
		_colorMarker = _color.replace("#","");
		d3.select(this).attr('data-orgstroke',_colorMarker)
		.attr('data-connectionstart',_patentAppNumber)
		.attr('highlight',false)
		.attr('data-connectionend',_relationAppNumber)
		.attr('data-connectiontype',_description);
		var showThisArrow = false;
		if(disableConnection.length > 0) {
			if(_dType != "") {
				disableConnection.map(function(m){
					if(_dType.indexOf(m) >= 0) {
						showThisArrow = true;
						return false;
					}
				});
			}
			if(parentDescription != "") {
				disableConnection.map(function(m){
					if(parentDescription.indexOf(m) >= 0) {
						parentElementShow = true;
						return false;
					}
				});
			}
		}
		if(parentElementShow === false) {			
		}
		showThirdPartyAssignor = true;
		if(airParent === true && disableConnection.length > 0 && disableConnection.indexOf('THIRD PARTY ASSIGNORS') < 0) {
			showThirdPartyAssignor = false;
		} else if(airParent === false && disableConnection.length > 0 && disableConnection.indexOf('THIRD PARTY ASSIGNORS') < 0) {
			showThirdPartyAssignor = true;
		}
		if(showThisArrow === true && showThirdPartyAssignor === true && parentElementShow === true) {
			d3.select(this).attr('marker-end', 'url(#markerREC_'+_colorMarker+')' )
		}
		if(_x1==_x2){
			d3.select(this).attr('stroke',_color);
			if(_y1>0 && _y2>0){				
				if(airParent === false) {
					/*				
					if(_y2 > _y1 || _y2 == _y1) { 
						return 'M'+_x1+','+_y1+'L'+_x2+','+_y2;
					} else {
						return 'M'+_x1+','+(_y1-30)+'L'+(_x2+10)+','+(_y2+90);
					}	*/	
					if(d.connection_type == 2) {
						console.log("SSS3:"+_x2,_x1,_y1);
					} else {
						_y1 = _y1 + 72;
						if(_showArrow===true){
							_y2 = _y2-10;
						}
						_x1 = _x1 - 85.5;
						_x2 = _x2 - 85.5;
						_X=0;
						_XX=0;
						jQuery.each(_chList,function(i,c){
							if(parseInt(c[0])==parseInt(_patentAppNumber)){
								_X=parseInt(_linkage) * parseFloat(c[2]);
								if(_X>0){_X = _X - parseFloat(c[2]);} 
								return false;
							}
						});
						jQuery.each(_prList,function(i,p){
							if(parseInt(p[0])==parseInt(_patentAppNumber)){
								_XX=parseInt(_count) * parseFloat(p[2]);
								if(_XX>0){_XX = _XX - parseFloat(p[2]);} 
								return false;
							}
						});
						if(_X>0){
							_x1 = parseInt(_x1) + parseFloat(_X);
						}
						if(_XX>0){
							_x2 = parseInt(_x2) + parseFloat(_XX);
						}
						if(ap === false) {
							if(_verticals.length>0 && _type !=2){
								var idd = String(_patentAppNumber);
								var ndd = String(_relationAppNumber);
								_IDD = idd+ndd;
								_IDD = parseInt(_IDD);
								$.each(_verticals,function(i,v){
									if(_IDD == parseInt(v.id)){
										_x1 =  v.x_axis;
										_x2 =  v.x_axis;
									}
								})
							}
						} else {					
							if(_x1 != _x2 ){
								_x1 = _x1 - 32;
								_x2 = _x1;
							}				
						}				
						if(_y1 > _y2) {
							_y2 += 90;
						}
						if((_y1 - _y2) > 62) {
							_y1 -=62;
						}
						if((_y2 - _y1) == 128) {
							_y1 += 60;
						}
						if(_y1 > _y2) {
							_y1 -= 10;
						} else {
							//_y1 += 60;
						}
					}
				}
				if(showThisArrow === true && showThirdPartyAssignor === true && parentElementShow === true) {
					return 'M'+_x1+','+_y1+'L'+_x2+','+_y2;
				}
			} else {
				return '';
			}	  
		} else if(_y1==_y2){
			d3.select(this).attr('stroke',_color);
			if(airParent === false) {				
				if(d.connection_type == 2) {
					console.log("PAPACK:"+_x1,_x2,_y1,_y2);
					_x2 +=200;
					_y1 +=20;
					_y2 +=20;
				} else {
					if(_x1<_x2) {
						_x1 +=90;
						_x2 -=110;
						_y1 +=50;
						_y2 +=50;
					} else {
						_x1 -= 135;
						_x2 += 210;
					}
					/*_x1 += 35;
					_y1 += 50;
					_x2 -= 110;
					_y2 += 50;
					if(_x1 > _x2) {
						_x1 -= 135;
						_x2 += 210;
					} else {
						_x1 +=10;
						_x2 += 65;
					}*/
				}
				if(_linkage > 1) {
					_y1 += _linkage * 5;
					_y2 += _linkage * 5;
				}
			}
			if(showThisArrow === true && showThirdPartyAssignor === true && parentElementShow === true) {
				//return 'M'+_x1+','+_y1+'L'+_x2+','+_y2;
			}			
		} else {
			var idd = String(_patentAppNumber);
			var ndd = String(_relationAppNumber);
			_IDD = idd+ndd;
			_IDD = parseInt(_IDD);
			if(d.connection_type != 2) {
				if(airParent === false) {
					if(_y1>0){
						_y1 = _y1 + 72;
					}
				}
			}
			if(_x2>_x1){						   
				d3.select(this).attr('stroke',_color);
				if(_y1<_x1){
					if(airParent === false) {
						if(d.connection_type != 2) {
							if(_nonverticals.length>0){	
								$.each(_nonverticals,function(i,v){
									if(_IDD == parseInt(v.app_rel_number)){
										if(v.entry=="right"){
										 _x2 +=85.5;
										} else if(v.entry=="left"){
										 _x2 -=85.5;
										}
									}
								})
							}
							if(_nonverticalsExits.length>0){
								$.each(_nonverticalsExits,function(i,v){
									if(_IDD == parseInt(v.app_rel_number)){
										if(v.entry=="right"){
											_x1 += 85.5;
										} else if(v.entry=="left"){
											_x1 -= 85.5;
										}
									}
								})
							}
						}						
						if(d.connection_type == 2) {
							console.log("PAPACK:"+_x1,_x2,_y1,_y2);
						} else {
							_x1 +=5;
							if(_y1>_y2){
								/*up arrow*/
								_x2 -= 23;
								_y2 += 42
							} else {
								/*down arrow*/
								_x2 -= 9;
								_y2 -= 2;
							}
							if(_type == 2) {
								if((_y2 - _y1) == 134) {
									_y1 += 60;
								}
							}
						}
					}
					if(showThisArrow === true && showThirdPartyAssignor === true && parentElementShow === true) {
					//	return 'M'+_x1+','+_y1+'L'+_x2+','+_y2;			
					}	
				} else {	
					if(airParent === false) {
						if(d.connection_type != 2) {
							if(_nonverticals.length>0){
								$.each(_nonverticals,function(i,v){
									if(_IDD == parseInt(v.app_rel_number)){
										if(v.entry=="right"){
											_x2 +=85.5;
										}else if(v.entry=="left"){
											_x2 -=85.5;
										}
									}
								})
							}
							if(_nonverticalsExits.length>0){
								_IDDs = parseInt(d.patent_app_number);
								$.each(_nonverticalsExits,function(i,v){
									if(_IDDs == parseInt(v.app_rel_number)){
										if(v.entry=="right"){
											_x1 +=85.5;
										} else if(v.entry=="left"){
											_x1 -=85.5;
										}
									}
								})
							}
						}
						
						if(d.connection_type == 2) {							
							if(_y2<_y1) {
								_y2 += 35;
							}
							_x2 += _linkage * 5;
							_x1 += _linkage * 5;
						} else {
							_x1 -= 3;
							_x2 -= 9;
							_y2 -= 2;
							if(_y1>_y2){
								/*up arrow*/
								_x2 -= 23;
								_y2 += 42
							} else {
								/*down arrow*/
								_x2 -= 9;
								_y2 -= 2;
							}
							if(_type == 2) {
								if((_y2 - _y1) == 134) {
									_y1 += 60;
								}
							}
							if(_y1 > _y2) {
								_y2 += 40;
								_x2 += 10;
								_y1 -= 70;
							}
						}
					}
					if(showThisArrow === true && showThirdPartyAssignor === true && parentElementShow === true) {
						//return 'M'+_x1+','+_y1+'L'+_x2+','+_y2;
					}	
				}
			} else if(_x2<_x1){
				d3.select(this).attr('stroke',_color);
				if(_y1<_x1){
					if(airParent === false) {
						if(parseInt(d.connection_type) != 2) {
							if(_nonverticals.length>0){
								$.each(_nonverticals,function(i,v){
									if(_IDD == parseInt(v.app_rel_number)){
										if(v.entry=="right"){
											_x2 +=85.5;
										}else if(v.entry=="left"){
											_x2 -=85.5;
										}
									}
								})
							}
							if(_nonverticalsExits.length>0){
								_IDDs = parseInt(d.patent_app_number);
								$.each(_nonverticalsExits,function(i,v){
									if(_IDDs == parseInt(v.app_rel_number)){
										if(v.entry=="right"){
											_x1 +=85.5;
										}else if(v.entry=="left"){
											_x1 -=85.5;
										}
									}
								})
							}
						}						
						if(d.connection_type == 2) {							
							if(_x2<_x1){
								_x2 +=20;
							}
							if(_y2<_y1){
								_y2 +=75;
							}
							_x1 += _linkage * 5;
							_x2 += _linkage * 5;
						} else {
							_y2 -= 8;
							if(_y1 > _y2) {
								/*up arrow*/
								_y1 -=60;
								_x2 +=13;
								_y2 +=48;
							} else {
								/*down arrow*/
							} 
							
							if((_y1 - _y2) == 252) {
								_y1 -= 13;
							}						
							if(_type == 2) {
								if(_y2 > _y1) {
									if((_y2 -_y1) == 59) {
										_x1 -= 98;
										_y1 -= 20;
									}
								}
							}
							_y1 -=40;
						}
					}
					if(airParent === true && d.connection_type != 2) {
						_y2 -= 7;
					}
					if(showThisArrow === true && showThirdPartyAssignor === true && parentElementShow === true) {
						//return 'M'+(_x1)+','+_y1+'L'+_x2+','+_y2;
					}					
				} else {
					if(airParent === false) {
						if(parseInt(d.connection_type) != 2) {
							if(_nonverticals.length>0){
								$.each(_nonverticals,function(i,v){
									if(_IDD == parseInt(v.app_rel_number)){
										if(v.entry=="right"){
											_x2 +=85.5;
										}else if(v.entry=="left"){
											_x2 -=85.5;
										}
									}
								})
							}
							if(_nonverticalsExits.length>0){
								_IDDs = parseInt(d.patent_app_number);
								$.each(_nonverticalsExits,function(i,v){
									if(_IDDs == parseInt(v.app_rel_number)){
										if(v.entry=="right"){
											_x1 +=85.5;
										}else if(v.entry=="left"){
											_x1 -=85.5;
										}
									}
								})
							}
						}				
						if(parseInt(d.connection_type) == 2) {
							_x1 +=22;
							_x1 += _linkage * 5;
							if(_y1 < _y2) {
								_y1 +=70;
							}
							if(_y2 < _y1) {
								_y2 += 80;
							} else {
								_y2 -=10;
							}
							_x2 += _linkage * 10;
						} else {
							_y2 -= 9;
							if(_y1 > _y2) {
								/*up arrow*/
								_y1 -=60;
								_x2 +=13;
								_y2 +=49;
							} else {
								/*down arrow*/
							}						
							if((_y1 - _y2) == 252 || (_y1 - _y2) == 260) {
								_y1 -= 13;
							}
							if(_type == 2) {
								if(_y2 > _y1) {
									if((_y2 -_y1) == 59) {
										_x1 -= 98;
										_y1 -= 20;
									}
								}
							}
						}
					}
					if(showThisArrow === true && showThirdPartyAssignor === true && parentElementShow === true) {
						//return 'M'+(_x1-2)+','+_y1+'L'+_x2+','+_y2;
					}					
				}
			}
		}
		})
		.on('click',function(a){
			openReelFrame(a,this);
		})
		.on('mouseenter',function(a){
			connectionTooltipOpen(a,this);
		})
		.on('mouseleave',function(a){connectionTooltipClose(a);});
		/*End Connection Arrow*/
	}	
	if(listDescription.length > 0) {
		var $ul = jQuery("#legend").find("ul.nav");
		var liHTML = "";
		for(d = 0; d < listDescription.length; d++) {
			_checked = '';
			if(disableConnection.length > 0 && disableConnection.indexOf(listDescription[d].name) >= 0) {
				_checked="CHECKED='CHECKED'";
			}
			liHTML += '<li class="assignment-titles-row"><input type="checkbox" onclick="hideThisConnection(jQuery(this))" '+_checked+' value="1" name="connection_check[]" class="assignment-titles-row" style="margin-right:10px;"/><span class="sm-width3 assignment-titles-col" style="background-color:'+listDescription[d].color+';"></span><span  class="assignment-titles-col" style="color:000;margin-left:5px">'+listDescription[d].name+'</span></li>';
		}
		if(jsonAirRectangles.length > 0) {
			_checked = '';
			if(disableConnection.length > 0 && disableConnection.indexOf('THIRD PARTY ASSIGNORS') >= 0) {
				_checked="CHECKED='CHECKED'";
			}
			liHTML += '<li class="assignment-titles-row"><input type="checkbox" onclick="hideThisConnection(jQuery(this))" '+_checked+' value="1" name="connection_check[]" class="assignment-titles-row"  style="margin-right:10px;"/><span class="sm-width3 assignment-titles-col" style=""></span><span  class="assignment-titles-col" style="color:000;margin-left:5px">THIRD PARTY ASSIGNORS</span></li>';
		}
		$ul.html(liHTML);
	}
	var showThirdPartyBox = true;
	if(disableConnection.length > 0) {
		if(disableConnection.indexOf('THIRD PARTY ASSIGNORS') >= 0) {
			showThirdPartyBox = false;
		}
	}
	var bar = svgContainer.selectAll("g")
    .data(jsonRectangles)
    .enter().append("g");
	bar.append("rect")
		.attr("x", function (d) { return parseInt(d.x_axis); })
		.attr("y", function (d) { return parseInt(d.y_axis); })
		.attr("rx", 5)
		.attr("ry", 5)
		.attr('class','rec')
		.attr('id',function(d){ return 'rec_'+d.id;})
		.attr('data-point',function(d){ return d.id;})
		.attr("height", function (d) {
			if(d.type == 2) {
				return 0;
			} else {
				var showRec = checkShowRectangles(d);
				if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
					duration += 300;
					return d.height;
				} else {
					return 0;
				}
			}			 
		})
		.attr("width", function (d) { if(d.type == 2) {return 0;} else{ return d.width;} })
		.attr("fill",function(d){
		  if(d.type == 0) {
			  return "#f9fafb";
		  } else {
			  return "#fff";
		  }
		})
		.attr('stroke',function(d){
			if(d.type != 2) {
				if(d.search===true){
					return '#cc0000';
				} else{
					var showRec = checkShowRectangles(d);
					if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
						return '#636363';
					} else {
						return '';
					}
				}
			} else {
				return '';
			}
		})
		.attr('style',function(d){
			if(d.type != 2) {
				var showRec = checkShowRectangles(d);
				if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
					return 'stroke-width:1;opacity:0.7';
				} else {
					return 'stroke-width:0;opacity:0';
				}				
			} else {
				return 'stroke-width:0;opacity:0';
			}		  
		})		
	var barAir = svgContainer.selectAll(".air_assignor")
	.data(jsonAirRectangles)
		.enter().append("g");
	barAir.append("rect")
		.attr("x", function (d) { return parseInt(d.x_axis); })
		.attr("y", function (d) { return parseInt(d.y_axis); })
		.attr("rx", 5)
		.attr("ry", 5)
		.attr('class','air_assignor')
		.attr('id',function(d){ return 'rec_'+d.id;})
		.attr('data-point',function(d){ return d.id;})
		.attr("height", function (d) {
			var showAirAssignors = false;
			if(disableConnection.length > 0 && disableConnection.indexOf('THIRD PARTY ASSIGNORS') >= 0) {
				showAirAssignors = true;
			}
			if(showAirAssignors === true) {
				return d.height;		
			} else {
				return 0;
			}				 
		})
		.attr("width", function (d) { return d.width; })
		.attr("fill",function(d){
			return "#fff";
		})
		.attr('stroke',function(d){
			return '#edeaea';
		})
		.attr('style',function(d){
			var showAirAssignors = false;
			if(disableConnection.length > 0 && disableConnection.indexOf('THIRD PARTY ASSIGNORS') >= 0) {
				showAirAssignors = true;
			}
			if(showAirAssignors === true) {
				return 'stroke-width:1;opacity:0.7';	
			} else {
				return 'stroke-width:0;opacity:0.7';	
			}
		});
    var images = bar.append("svg:image")
		.attr("xlink:href",  function(d) {			
			if(d.type == 2) {
				return '';
			} else {
				var showRec = checkShowRectangles(d);
				if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
					return 'https://backyard.synpat.com/public/icons/ico_pdf.png';
				} else {
					return '';
				}				
			}			
		})
		.attr("x", function(d) { return parseInt(d.x_axis) + 10 ;})
		.attr("y", function(d) { return parseInt(d.y_axis) + 10;})
		.attr("height", 14)
		.attr("width", 12)
		.on('click',function(a){
			var showRec = checkShowRectangles(d);
			if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
				if($('#label_'+a.id).length>0){
					poke = true;
					$(this).css('font-weight','');
					$('#label_'+a.id).remove();
					poke = false;
				} else {
					$(this).css('font-weight','bold');
					setTimeout(function(){tooltipOpen(a)},100);
				}
			}
			
		});
	var textLabel = svgContainer.selectAll('.text_marker_name').data(jsonRectangles).enter().append('text');
	textLabel
	.attr("class", 'text_marker_name')
	.attr("dy", '.71em')
	.attr("x", function(d) {
		if(parseInt(d.type) != 2) {
			var addNumber = 25;
		
			return parseInt(d.x_axis) + addNumber;
		} else {
			return 0;
		}		
	})
	.attr("y",function(d) {
		if(parseInt(d.type) != 2) {
			var addNumber = 12;
			var y = parseInt(d.y_axis);
			return y + addNumber; 
		} else {
			return 0;
		}
	})	
	.attr("title",function(d) { 
		if(parseInt(d.type) != 2) {
			var showRec = checkShowRectangles(d);
			if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
				_name = d.name;
				_name = _name.trim();
				_name = _name.toLocaleLowerCase();
				return capitalizeFirstLetter(_name);
			} else {
				return '';
			}				
		} else {
			return '';
		}
	})	
	.attr('fill', '#007bff')
	.attr('style','font-size:14px;text-anchor:start')
    .text(function(d){
		if(parseInt(d.type) != 2) {
			var showRec = checkShowRectangles(d);
			if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
				_name = d.name;
				_name = _name.trim();
				_name = _name.toLocaleLowerCase();
				return capitalizeFirstLetter(_name);
			} else {
				return '';
			}
		} else {
			return '';
		}
	})
	.on('click',function(a){
		if(parseInt(a.type) != 2) {
			var showRec = checkShowRectangles(d);
			if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
				if($('#label_'+a.id).length>0){
					poke = true;
					$(this).css('font-weight','');
					$('#label_'+a.id).remove();
					poke = false;
				} else {
					$(this).css('font-weight','bold');
					setTimeout(function(){tooltipOpen(a)},100);
				}
			} 			
		}
	})
	.selectAll(".text_marker_name")
	.call(wrap,155,'text_marker_name')

	var textLabel = svgContainer.selectAll('.text_marker_name_air').data(jsonAirRectangles).enter().append('text');
	textLabel
	.attr("class", 'text_marker_name_air')
	.attr("dy", '.71em')
	.attr("x", function(d) {
		var addNumber = 25;
		if(parseInt(d.type) == 2) {
			addNumber = 5;
		}
		return parseInt(d.x_axis) + addNumber;
	})
	.attr("y",function(d) {
		var addNumber = 12;
		var y = parseInt(d.y_axis);
		/*if(parseInt(d.type) == 2) {
			y = parseInt(d.y_axis) - 150;
		}*/
		return y + addNumber; 
	})	
	.attr("title",function(d) { 
		var showAirAssignors = false;
		if(disableConnection.length > 0 && disableConnection.indexOf('THIRD PARTY ASSIGNORS') >= 0) {
			showAirAssignors = true;
		}
		if(showAirAssignors === true) {
			_name = d.name;
			_name = _name.trim();
			_name = _name.toLocaleLowerCase();
			return capitalizeFirstLetter(_name);
		} else {
			return '';	
		}		
	})	
	.attr('fill', '#007bff')
	.attr('style','font-size:14px;text-anchor:start')
	.text(function(d){
		var showAirAssignors = false;
		if(disableConnection.length > 0 && disableConnection.indexOf('THIRD PARTY ASSIGNORS') >= 0) {
			showAirAssignors = true;
		}
		if(showAirAssignors === true) {
			_name = d.name;
			_name = _name.trim();
			_name = _name.toLocaleLowerCase();
			return capitalizeFirstLetter(_name);
		} else {
			return '';	
		}
	})
	.on('click',function(a){
		var showAirAssignors = false;
		if(disableConnection.length > 0 && disableConnection.indexOf('THIRD PARTY ASSIGNORS') >= 0) {
			showAirAssignors = true;
		}
		if(showAirAssignors === true) {
			if($('#label_'+a.id).length>0){
				poke = true;
				$(this).css('font-weight','');
				$('#label_'+a.id).remove();
				poke = false;
			} else {
				$(this).css('font-weight','bold');
				setTimeout(function(){tooltipOpen(a)},100);
			}
		}
	})
	.selectAll(".text_marker_name_air")
	.call(wrap,325,'text_marker_name_air')
	
		
	var textLabel = svgContainer.selectAll('.text_marker2').data(jsonRectangles).enter().append('text');
	textLabel
	.attr("class", 'text_marker2')
	.attr("dy", -6)
	.attr("id", function(d) {var _idx =  parseInt(d.x_axis) + 10; var _idy = parseInt(d.y_axis) + 58; return String(_idx)+String(_idy); })
	.attr("x", function(d) { return parseInt(d.x_axis) + 10; })
	.attr("y",function(d) { return parseInt(d.y_axis) + 58; })
	.text(function (d) {
		var showRec = checkShowRectangles(d);
		if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
			if(d.type==0) {
				return 'Filed: '+ moment(new Date(d.execution_date+' 00:00:00'),'YYYY-MM-DD').format('MMM,DD YYYY');
			} else if(d.type==1){
				return 'Execution: '+ moment(new Date(d.execution_date+' 00:00:00'),'YYYY-MM-DD').format('MMM,DD YYYY');
			} else {
				return '';
			}
		} else {
			return '';
		}		
	})
	.attr('fill', '#000')
	.attr('style','font-size:12px;text-anchor:start');
	var textLabel = svgContainer.selectAll('.text_marker3').data(jsonRectangles).enter().append('text');
	textLabel
	.attr("class", 'text_marker3')
	.attr("dy", -6)
	.attr("x", function(d) { return parseInt(d.x_axis) + 10; })
	.attr("y",function(d) { return parseInt(d.y_axis) + 70; })
	.text(function (d) {
		if(d.type==2){ 
			return '';
		} else {
			var showRec = checkShowRectangles(d);
			if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
				return 'Recorded: '+ moment(new Date(d.recorded+' 00:00:00'),'YYYY-MM-DD').format('MMM,DD YYYY');
			} else {
				return '';
			}			
		}		
	})
	.attr('fill', '#000')
	.attr('style','font-size:12px;text-anchor:start');
	var textLabel = svgContainer.selectAll('.text_marker4').data(jsonRectangles).enter().append('text');
	textLabel
	.attr("class", 'text_marker4')
	.attr("dy", -6)
	.attr("x", function(d) { return parseInt(d.x_axis) + 10; })
	.attr("y",function(d) { return parseInt(d.y_axis) + 70; })
	.html(function (d) {
		if(d.type==2){ 
			return '';
		} else {			
			var _string = "";
			var showRec = checkShowRectangles(d);
			if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
				var x = parseInt(d.x_axis) + 140;
				var y = parseInt(d.y_axis) + 82;
				_diffString = differenceDates(d.execution_date,d.recorded);
				if(_diffString.length==2){
					y = parseInt(d.y_axis) + 67;
					_string = "<tspan x='"+x+"' y='"+y+"' dy='-1.5em'>"+_diffString[0]+"</tspan><tspan x='"+x+"' y='"+y+"' dy='-0.2em'>"+_diffString[1]+"</tspan>";
				} else if(_diffString[0]!='undefined' && _diffString[0]!=undefined){
					_string = "<tspan x='"+x+"' y='"+y+"' dy='-1.5em'>"+_diffString[0]+"</tspan>";
				}
			} 			
			return _string;
		}		
	})
	.attr('fill', '#000')
	.attr('style','font-size:12px;text-anchor:start');
	var dashLines = svgContainer.selectAll('.dashed')
		.data(jsonRectangles)
		.enter()
		.append('line')
		.attr('class','dashed')
		.attr('id',function(d,i){return 'dash_'+d.id;})
		.attr('stroke-width',function(d,i){
			if(d.same===true){
				var showRec = checkShowRectangles(d);
				if(showRec.showThisArrow === true && showRec.showThirdPartyAssignor === true) {
					return 1;
				} else {
					return 0;
				}				
			} else {
				return 0;
			}
		})
		.attr('stroke','#999')
		.attr('x1',function(d,i){
			if(d.same===true && d.type != 2){
				return d.x_axis - _defaultGap;											
			}
		}).attr('x2',function(d,i){
			if(d.same===true && d.type != 2){
				return d.x_axis;							
			}
		}).attr('y1',function(d,i){
			if(d.same===true && d.type != 2){
				return parseInt(d.y_axis) + 60;							
			}
		})		
		.attr('y2',function(d,i){
			if(d.same===true && d.type != 2){
				return parseInt(d.y_axis) + 60;							
			}
		});
	function checkShowRectangles(d) {
		var airParent = false,showThisArrow = false,showThirdPartyAssignor = true ;
		var _dType = d.description;
		if(airAssignorIDs.length > 0 && airAssignorIDs.indexOf(parseInt(d.id)) >= 0) {
			airParent = true;
		}
		_dType = _dType.replace('(see document for details).','');
		_dType = _dType.trim();
		_dType = _dType.toLowerCase();
		_dType = _dType.toUpperCase();
		if(disableConnection.length > 0) {
			if(_dType != "") {
				disableConnection.map(function(m){
					if(_dType.indexOf(m) >= 0) {
						showThisArrow = true;
						return false;
					}
				});
			}
		}
		if(airParent === true && disableConnection.length > 0 && disableConnection.indexOf('THIRD PARTY ASSIGNORS') < 0) {
			showThirdPartyAssignor = false;
		} else if(airParent === false && disableConnection.length > 0 && disableConnection.indexOf('THIRD PARTY ASSIGNORS') < 0) {
			showThirdPartyAssignor = true;
		}
		var obj = {showThisArrow:showThisArrow,showThirdPartyAssignor:showThirdPartyAssignor};
		return obj;
	}
	function findType(j) {
		var s = j-1;
		if(typeof jsonRectangles[s] != "undefined" && jsonRectangles[s].type !=2) {
			return parseInt(jsonRectangles[s].y_axis);
		} else {
			findType(s);
		}
	}
	var curlyLines = svgContainer.selectAll('.curlyBrace')
		.data(jsonRectangles)
		.enter()
		.append("path").attr("class","curlyBrace")
		.attr("d", function(d,i) {
			if(i>0 && d.same===false && d.type != 2){
				x1 = 0;
				y1 = 0;
				var xAxis = parseInt(d.x_axis);
				if(typeof d.old_x_axis !="undefined"){
					xAxis = parseInt(d.old_x_axis);
				}
				for(j=i-1;j>=0;j--){
					if(parseInt(jsonRectangles[j].x_axis) == xAxis || (typeof(jsonRectangles[j].old_x_axis) !="undefined" && parseInt(jsonRectangles[j].old_x_axis) == xAxis)){
						x1 = parseInt(jsonRectangles[j].x_axis);
						if(typeof(jsonRectangles[j].old_x_axis) !="undefined"){
							x1 = parseInt(jsonRectangles[j].old_x_axis);
						}
						y1 = parseInt(jsonRectangles[j].y_axis);
						s = j-1;
						break;
					}
				}
				x2 = xAxis;
				y2 = parseInt(d.y_axis) + 60;
				v = y1 + 60;
				if(j>=0 && typeof(jsonRectangles[j].type) != "undefined" &&  jsonRectangles[j].type == 2 && typeof(jsonRectangles[j-1]) != "undefined") {
					v = y2;
					y2 = parseInt(findType(j)) + 60;
					/*console.log("Sent:"+y2);
					console.log("Sent:"+v);*/
				}
				if(x1>0 && y1>0){
					y1 = y1+20;
					return ("M"+x1+","+y2+"H30V"+v+"H"+x2+"");
				} else {
					return '';
				}
			}
		});
		bar.append('svg:path')
			.attr('d', function(d,i){
			if(i>0 && d.same===false){
				x1 = 0;
				y1 = 0;
				var xAxis = parseInt(d.x_axis);
				if(typeof d.old_x_axis !="undefined"){
					xAxis = parseInt(d.old_x_axis);
				}
				for(j=i-1;j>=0;j--){
					if(parseInt(jsonRectangles[j].x_axis) == xAxis || (typeof(jsonRectangles[j].old_x_axis) !="undefined" && parseInt(jsonRectangles[j].old_x_axis) == xAxis)){
						x1 = parseInt(jsonRectangles[j].x_axis);
						if(typeof(jsonRectangles[j].old_x_axis) !="undefined"){
							x1 = parseInt(jsonRectangles[j].old_x_axis);
						}
						y1 = parseInt(jsonRectangles[j].y_axis);
						break;
					}
				}
				x2 = xAxis;
				y2 = parseInt(d.y_axis) ;
				if(x1>0 && y1>0){
					y2 = y2 + 61;
					y2 = y2+'.41913l4.537781 -1.6525879l-4.538391 -1.6508789z';
					if(d.type != 2) {
						return 'M '+(x2 -10)+' ' + y2;
					} else {
						return '';
					}							
				} else {
					return '';
				}
			}
		})
		.attr('stroke', '#999')
		.attr('stroke-width', function(d,i){
			var _wi = 0;
			if(i>0 && d.same===false){
				x1 = 0;
				y1 = 0;
				var xAxis = parseInt(d.x_axis);
				if(typeof d.old_x_axis !="undefined"){
					xAxis = parseInt(d.old_x_axis);
				}
				if(d.id == 428) {
					console.log("DDAAD",xAxis);
				}
				for(j=i-1;j>=0;j--){
					if(parseInt(jsonRectangles[j].x_axis) == xAxis || (typeof(jsonRectangles[j].old_x_axis) !="undefined" && parseInt(jsonRectangles[j].old_x_axis) == xAxis)){
						x1 = parseInt(jsonRectangles[j].x_axis) ;
						if(typeof(jsonRectangles[j].old_x_axis) !="undefined"){
							x1 = parseInt(jsonRectangles[j].old_x_axis) ;
						}						
						y1 = parseInt(jsonRectangles[j].y_axis);
						break;
					}
				}
				if(x1>0 && y1>0){
					_wi = 3;
				} else {
					console.log("NOPS:",d,i);
				}
			}
			return _wi;
		})
		.attr('stroke-linecap', 'butt');
	var	textDateLabel = svgContainer.selectAll('.text_date').data(jsonRectangles).enter().append('text');
			textDateLabel
			.attr("class", "text_date")
			.attr("dy", -6)
			.attr('fill', '#999')
			.attr("x", function(d,i){
				x = parseInt(d.x_axis);
				_startDate = "";
				_endDate = d.execution_date;
				if(i>0 && d.same===false){
					var xAxis = parseInt(d.x_axis);
					if(typeof d.old_x_axis !="undefined"){
						xAxis = parseInt(d.old_x_axis);
					}
					for(j=i-1;j>=0;j--){
						if(parseInt(jsonRectangles[j].x_axis) == xAxis || (typeof(jsonRectangles[j].old_x_axis) !="undefined" && parseInt(jsonRectangles[j].old_x_axis) == xAxis) && parseInt(d.type) != 2){
							_startDate = jsonRectangles[j].execution_date;
							break;
						}
					}
				}
				if(_startDate!=""){
					return x - 35;
				} else {
					return 0;
				}
			})
			.attr("y", function(d,i){
				y = parseInt(d.y_axis) - 20;
				_startDate = "";
				_endDate = d.execution_date;
				if(i>0 && d.same===false){
					var xAxis = parseInt(d.x_axis);
					if(typeof d.old_x_axis !="undefined"){
						xAxis = parseInt(d.old_x_axis);
					}
					for(j=i-1;j>=0;j--){
						if(parseInt(jsonRectangles[j].x_axis) == xAxis || (typeof(jsonRectangles[j].old_x_axis) !="undefined" && parseInt(jsonRectangles[j].old_x_axis) == xAxis)  && parseInt(d.type) != 2){
							_startDate = jsonRectangles[j].execution_date;
							break;
						}
					}
				}
				if(_startDate!=""){
					return y;
				} else {
					return 0;
				}
			})
			.html(function(d,i){
				if(airAssignorIDs.indexOf(parseInt(d.id))<0) {
					_startDate = "";
					_endDate = d.execution_date;
					var xAxis = parseInt(d.x_axis);
					if(typeof d.old_x_axis !="undefined"){
						xAxis = parseInt(d.old_x_axis);
					}
					if(i>0 && d.same===false){
						for(j=i-1;j>=0;j--){
							if(parseInt(jsonRectangles[j].x_axis) == xAxis || (typeof(jsonRectangles[j].old_x_axis) !="undefined" && parseInt(jsonRectangles[j].old_x_axis) == xAxis) && parseInt(jsonRectangles[j].type) !=2 && parseInt(d.type) != 2){
								_startDate = jsonRectangles[j].execution_date;
								break;
							}
						}
					}
					if(_startDate!=""){
						x = xAxis - 35;
						y = parseInt(d.y_axis) - 20;					
						_string = "";
						if(_startDate!=_endDate){
							_diffString = differenceDates(_startDate,_endDate);
							if(_diffString.length==2){
								_string = "<tspan x='"+x+"' y='"+y+"' dy='-1.5em'>"+_diffString[0]+"</tspan><tspan x='"+x+"' y='"+y+"' dy='-0.2em'>"+_diffString[1]+"</tspan>";
							} else if(_diffString[0]!='undefined' && _diffString[0]!=undefined){
								_string = "<tspan x='"+x+"' y='"+y+"' dy='-1.5em'>"+_diffString[0]+"</tspan>";
							}	
						}												
						return _string;
					} else {
						return '';
					}
				} else {
					return '';
				}				
			});
	setTimeout(chgPosition,100);
}
function getNodePos(el){
    var body = d3.select('body').node();

    for (var lx = 0, ly = 0;
         el != null && el != body;
         lx += (el.offsetLeft || el.clientLeft), ly += (el.offsetTop || el.clientTop), el = (el.offsetParent || el.parentNode))
        ;
    return {x: lx, y: ly};
}
createIllustration();

function chgPosition() {
	/*this function is for changing Assigned date position only if Assignee name is in one line.*/
	jQuery('.text_marker_name').each(function(){
		var $this = jQuery(this);
		if($this.find('tspan').length == 1) {
			var xP = $this.attr('x');
			var yP = $this.attr('y');
			var textID = String(parseInt(xP) - 15) + String(parseInt(yP) + 46 );
			if(jQuery('#'+textID).length == 1) {
				jQuery('#'+textID).attr("y",parseInt(yP) + 38);
			}
		}
	});	
}

function clearedOtherBold(){
	jQuery('.text_marker_name').each(function(){
		var $_c = jQuery(this);
		_ID = $_c.text();
		if(jQuery("text[title='"+_ID+"']").length > 0){
			$_c.css('font-weight','');
		}
	});
}

_controlKey = false;
var body = document.getElementsByTagName('body');
	body[0].addEventListener('click',function(e) {
		var _getTarget = $(e.target);
		/*console.log(e);
		console.log(_getTarget);*/
		_controlKey = false;
		if (e.ctrlKey){
			_controlKey = true;
		}
		if(_getTarget.length>0){				
			try {
				var _id = _getTarget[0].id;
				/*console.log(_id);*/
				var targetE = _getTarget[0];
				/*console.log(targetE);*/
				var _className = _getTarget[0].className;
				/*console.log(_className);*/
				if(typeof targetE.parentNode != "undefined" && typeof targetE.parentNode.parentNode != "undefined" && typeof targetE.parentNode.parentNode.className != "undefined"){
					var _cClass = targetE.parentNode.parentNode.className;
					_cClass = _cClass.toString();
					/*console.log(_cClass);
					console.log('ParentClass:'+_cClass);*/
					if(_cClass !='container_w' && _cClass !='tool_open' && _cClass !='menu-tabs-contents' && _cClass !='filetree' && _cClass.indexOf('tab-pane')<0 && _cClass.indexOf('ui-draggable')<0 && _cClass.indexOf('search-form-help-text')<0 && _cClass.indexOf('tool_open')<0  && _cClass.indexOf('grey ng-scope')<0 && _cClass.indexOf('tbl-assignment-row')<0 && _cClass.indexOf('entities_row')<0){
						/*console.log('A'+_id+'B');	*/	
						_nodeName = targetE.nodeName;
						/*console.log('A'+_nodeName+'B');*/
						if(_className.baseVal!="text_marker_name" &&  _nodeName!="rect"  && _nodeName!="text" && _nodeName!="image" && _className.baseVal!="data-tab-icon" && _nodeName!="I" && _id!="claim-tab"&& _id!="assignments-tab" && _id!="date-tab" && _id!="abstract-tab" && _id!="figure-tab" && _id!="date" && _id!="abstract" && _id!="claim" && _id!="figure" && _id!="assigments"  && _nodeName!="TD" && _nodeName!="TR" && _nodeName!="P" && _nodeName!="EMBED" && _className!="row" && _className!="hitarea" && _nodeName!="circle" && _nodeName!="tspan" && _nodeName!="LI"  && _nodeName!="H6"  && _id!="accordionExample" && _id!="message" && _nodeName!="U" && _id!="menuTabSyndication" && _id!="show_table" && _className!="headline" && _className !="pull-left ng-scope" && _className!="ng-scope" && _className!="caption" && _className!="ng-binding"  && _className!="ng-binding ng-scope" && _className!="tbl-properties-col" && _className!="reel_frame search-form-help-text" && _className!='reel_frame' && _className !='search-form-help-text' && _className!='entities_col' && _className!='entities_row' && _className!='txt_modified' && _className!='assignment-titles-col' && _className !='sm-width3 assignment-titles-col' && _className!='assignment-titles-row'){
							if($('.search-form-help-text').length>0 && !$('.search-form-help-text').hasClass('loading')){
								$('.search-form-help-text').remove();
							}
							clearedOtherBold();
						}
					}
				} 
			}catch(e) {
				console.log(e);
			}
		}	
	});
</script>
</body>
</html>