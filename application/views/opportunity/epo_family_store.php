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
$width = 170;
$fS = false;
$countries = array();
if(count($family_data['country'])>0){
	foreach($family_data['country'] as $country){
		$countries[] = strtolower(strtoupper($country->publication_country));
	}
}
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
if(count($family_data['list'])>0){
	$cpCount = 0;
	$chCount = 1;
	for($i=0;$i<count($family_data['list']);$i++){
		$family = $family_data['list'][$i];
		$patentNumber = $family->patent_id;
		$countryCode = strtoupper($family->publication_country);
		$publicationKind = strtoupper($family->publication_kind);
		$label = $countryCode.$patentNumber;
		$label = $label.$publicationKind;
		$search = false;
		if($label==strtoupper($searchPatent)){
			$search = true;
		}
		$family_data['list'][$i]->search = $search;
		$family_data['list'][$i]->label = $label;
		$family_data['list'][$i]->application_org_number = $family->application_number;
		$family_data['list'][$i]->type = "CIP";
		
		$outside = false;
		if(strtolower(strtoupper($countryCode))!="us"){
			$outside = true;
		}
		$family_data['list'][$i]->country = strtolower(strtoupper($countryCode));
		$family_data['list'][$i]->outside = $outside;
		$family_data['list'][$i]->type = "CIP";
		$same = false;
		$fillingDate = $family->filling_date;
		$previousFillingDate = "";
		if($i>0){
			$previousFillingDate = $family_data['list'][$i-1]->filling_date;
		}
		if($previousFillingDate == $fillingDate){
			$same = true;	
			$cpCount++;
			$w = $cpCount*210;
			$w = $w + 210;
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
					$x = (int)$family_data['list'][$i-1]->x_axis + 200;
					$y = (int)$family_data['list'][$i-1]->y_axis;
				} else {
					if($fS===false){
						if($cpCount==1){
							$x = 270;
						} else {
							$x = $family_data['list'][$i-1]->y_axis + 190;
						}
						$fS = true;
					} else {
						$x = 270;
					}					
				}
				$y = (int)$family_data['list'][$i-1]->y_axis;
			} else {
				$chCount++;
			}
		}
		$family_data['list'][$i]->x_axis = $x;
		$family_data['list'][$i]->y_axis = $y;
		if($i==0){
			if($search===false){
				$color = "#669900";
			} else {
				$color = "#ffbb33";
			}
		} else {
			if($outside===true){
				$color = "#33b5e5";
			} else {
				$color = "#ffbb33";
			}
		}
		$family_data['list'][$i]->color = $color;
		$family_data['list'][$i]->width = $width;
		$family_data['list'][$i]->height = $height;
		$claims = $family->claims;
		$abstract = $family->abstracts;
		$inventors = $family->inventors;
		$assignee = $family->assignee;
		$applicants = $family->applicants;
		$image = $family->images;
		$assigments = array();
		if($family->assigments!=""){
			try{
				$assigments = json_decode($family->assigments);
			}catch(Exception $e){
				
			}
		}
		if($image!=""){
			try{
				$images = json_decode($image);
				if(count($images)>0 && trim($images[0])!=""){
					$image = $images[0];
					$image = str_replace("http","https",$image);
				}else {
					$image = "";
				}
			}catch(Exception $e){
				
			}
		}else {
			$image = "";
		}
		$publicationDate = $family->publication_date;
		$title = $family->title;
		if($publicationDate!=""){
			$publicationDate = substr($publicationDate,0,4).'-'.substr($publicationDate,4,2).'-'.substr($publicationDate,-2);
		}
		$applicationNumber = $family->application_country.$family->application_number.$family->application_kind;
		/*unset*/
		unset($family_data['list'][$i]->claims);
		unset($family_data['list'][$i]->abstracts);
		unset($family_data['list'][$i]->images);
		unset($family_data['list'][$i]->title);
		unset($family_data['list'][$i]->inventors);
		unset($family_data['list'][$i]->assignee);
		unset($family_data['list'][$i]->applicants);
		/*End unset*/
		$claims = cleanString($claims);
		$abstract = cleanString($abstract);
		$title = cleanString($title);
		$inventors = cleanString($inventors);
		$assignee = cleanString($assignee);
		$applicants = cleanString($applicants);
		$family_data['list'][$i]->claims = trim($claims);
		$family_data['list'][$i]->abstract = trim($abstract);
		$family_data['list'][$i]->application_number = $applicationNumber;
		$family_data['list'][$i]->image = $image;
		$family_data['list'][$i]->title = trim($title);
		$family_data['list'][$i]->inventors = trim($inventors);
		$family_data['list'][$i]->assignee = trim($assignee);
		$family_data['list'][$i]->applicants = trim($applicants);
		$family_data['list'][$i]->issue_date = $publicationDate;
		$family_data['list'][$i]->assigments = $assigments;
	}

	$svgHeight = $chCount * 212;
	if(count($family_data['list'])>0){
		for($i=0;$i<count($family_data['list']);$i++){
			$y_axis = $family_data['list'][$i]->y_axis;
			$x_axis = $family_data['list'][$i]->x_axis;
			$orgApp = $family_data['list'][$i]->application_org_number;
			if(isset($family_data['list'][$i+1]) && $family_data['list'][$i+1]->y_axis == $y_axis){
				$yAxisUSAArray = array();
				$nonUSAyAxisArray = array();
				$yChangeArrayOrg = array();
				if(strtolower($family_data['list'][$i]->publication_country)=="us"){
					$yChangeArrayOrg[] = $family_data['list'][$i];
					$yAxisUSAArray[] = $family_data['list'][$i]->application_org_number;
				} else {
					$nonUSAyAxisArray[] = $family_data['list'][$i]->application_org_number;
					$yChangeArrayOrg[] = $family_data['list'][$i];
				}				
				for($j=$i+1;$j<count($family_data['list']);$j++){
					$rec = $family_data['list'][$j];
					if($rec->y_axis == $y_axis){
						$yChangeArrayOrg[] = $rec;
						if(strtolower($rec->publication_country)=="us"){
							$yAxisUSAArray[] = $rec->application_org_number;
						} else {
							$nonUSAyAxisArray[] = $rec->application_org_number;
						}
					}					
				}
				sort($yAxisUSAArray);
				$i = $i-1;
				$tap = 0;
				if(count($yAxisUSAArray)>0){
					foreach($yAxisUSAArray as $appOrg){
						$dt = array();
						foreach($yChangeArrayOrg as $chgOrg){
							if($appOrg==$chgOrg->application_org_number){
								$dt =$chgOrg;
								break;
							}
						}
						if(count($dt)>0){
							$i +=1; 
							if($tap>0){
								$oldXaxis = $family_data['list'][$i-1]->x_axis;
								$dt->x_axis = $oldXaxis + 200;
								$dt->same = true;								
							} else {
								if($orgApp!=$dt->application_org_number){
									$dt->x_axis = 70;
									$dt->same = false;
								}
							}
							$family_data['list'][$i] = $dt;
							$tap++;
						}
					}
				}
				if(count($nonUSAyAxisArray)>0){
					foreach($nonUSAyAxisArray as $appOrg){
						$dt = array();
						foreach($yChangeArrayOrg as $chgOrg){
							if($appOrg==$chgOrg->application_org_number){
								$dt =$chgOrg;
								break;
							}
						}
						if(count($dt)>0){
							$i +=1; 
							if(count($yAxisUSAArray)>0){
								$oldXaxis = $family_data['list'][$i-1]->x_axis;
								$dt->x_axis = $oldXaxis + 200; 
								$dt->same = true;	
							}
							$family_data['list'][$i] = $dt;
						}
					}
				}
			}
		}
	}
	$verticals = array();
	/*Find Verticals*/
	if(count($family_data['list'])>0){
		for($i=0;$i<count($family_data['list']);$i++){
			$relation = $family_data['list'][$i]->relation;
			$xAppNumber = $family_data['list'][$i]->application_org_number;
			$xAxis = $family_data['list'][$i]->x_axis;
			$yAxis = $family_data['list'][$i]->y_axis;
			if(count($relation)>0){
				foreach($relation as $rel){
					$relAppNumber = $rel->relation_number;
					foreach($family_data['list'] as $assets){
						if($assets->application_org_number == $relAppNumber && $xAxis == $assets->x_axis){
							$verticals[] = array("id"=>$xAppNumber.$relAppNumber,"yexit"=>$yAxis,"yentry"=>$assets->y_axis);
							break;
						}
					}
				}
			}
		}
	}
	if(count($family_data['list'])>0){
		for($i=0;$i<count($family_data['list']);$i++){
			$relation = $family_data['list'][$i]->relation;
			if(count($relation)>0){	
				$recSort = array();
				foreach($relation as $rel){
					$recSort[]['relation_number'] = $rel->relation_number;
				}
				array_multisort($recSort, SORT_ASC, $relation);
				/*
				
				sort($recSort);
				$newRectangle = array();
				foreach($recSort as $rel){
					foreach($rectangle->relation as $relation){
						if($rel == $relation->relation_number){
							$newRectangle[] = $relation;
						}
					}
				}*/
				$family_data['list'][$i]->relation = $relation;
			}
		}
	}
	if(count($family_data['list'])>0){
		for($i=0;$i<count($family_data['list']);$i++){
			$rect = $family_data['list'][$i];
			$rectX = $rect->x_axis;
			$relation = $rect->relation;
			$xCArray = array();
			if(count($relation)>0){
				for($j=0;$j<count($relation);$j++){
					$relationAppNumber = $relation[$j]->relation_number;
					foreach($family_data['list'] as $list){
						if($list->application_org_number == $relationAppNumber && $rectX==$list->x_axis){
							$xCArray[] = $j;
							break;
						}
					}
				}
				if(count($xCArray)>0){
					foreach($xCArray as $c){
						$relation[$c]->count = count($xCArray);
					}
					$family_data['list'][$i]->relation = $relation;
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
	$jsonRectangles = $family_data['list'];
	$childListIDs = array();
	$childList = array();
	$parentList = array();
	$applicationListIDS = array();
	if(count($jsonRectangles)>0){
		foreach($jsonRectangles as $rectangle){
			$applicationListIDS[] = $rectangle->application_org_number;
		}
	}
	if(count($jsonRectangles)>0){
		foreach($jsonRectangles as $rectangle){
			if(count($rectangle->relation)>0){				
				foreach($rectangle->relation as $relation){
					$pID = $relation->patent_app_number;
					$cID = $relation->relation_number;
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
										$childList[$i][2] = number_format(155/$childList[$i][1],2, '.', '');
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
										$parentList[$i][2] = number_format(155/$parentList[$i][1],2, '.', '');
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
	/*echo "Found Verticals<br/>";
	echo "<div style='float:left;width:33%'><pre>";
	print_r($verticals);
	echo "</pre></div>";*/
	sort_array_of_array($verticals, 'yentry');
	/*echo "Sort YExit Verticals<br/>";
	echo "<div style='float:left;width:33%'><pre>";
	print_r($verticals);
	echo "</pre></div>";*/
	sort_array_of_array($verticals, 'yexit');
	/*echo "Sort YEntry Verticals<br/>";
	echo "<div style='float:left;width:33%'><pre>";
	print_r($verticals);
	echo "</pre></div>";*/
	if(count($verticals)>15){
		$gapValue = 150/count($verticals);
	} else {
		$gapValue = 9;
	}
	$start = 80;
	for($i=0;$i<count($verticals);$i++){
		if($i>0){$start +=$gapValue;}
		$verticals[$i]['x_axis'] = $start;
	}
}
/*die;*/
$nonVerticalsEntries = array();
$nonVerticalsExits = array();
$childAppNumber = array();
if(count($family_data['list'])>0){
	for($i=0;$i<count($family_data['list']);$i++){
		$rect = $family_data['list'][$i];
		$relation = $rect->relation;
		$xAppNumber = $rect->application_org_number;
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
				$relationNumber = $rel->relation_number;
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
						if($assets->application_org_number==$relationNumber){
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
								if($aRelation->relation_number == $relationNumber ){
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
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" ></script>
<script src="//backyard.synpat.com/public/dragscroll.js" ></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
text {
  font-size:12px;font-family:arial;
}
.search-form-help-text{position:absolute;width:320px;padding:10px;border:1px solid #e4e4e4;z-index:999999;background:#f8f9fa;top:27px;/*box-shadow:0 0 10px 6px rgba(0,0,0,.1);*/border-radius:2px;right:0;cursor:move}.search-form-help-text dl,.search-form-help-text p,.search-form-help-text p a{font-size:15px}
.card-body {
	font-size: 14px;
	font-family: Arial,sans-serif;
}
.tab-content>.tab-pane{padding-top:10px; font-size:14px;font-family:Arial,sans-serif;color:#333;}
body{overflow:hidden;}
div#patent_block{overflow:scroll;min-width:500px;height:500px;}
#accordionExample,#accordionExample h6{font-size:14px !important;font-family:Arial,sans-serif !important;color:#444;}
#accordionExample h6{padding:0px;margin-left:10px;}
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
body {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
	font-family:Arial,sans-serif;
}
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
#legend ul li{float:left;margin-right:5px}
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
@media only screen and (min-height:2050px){
	body{zoom:2.2;}
}
@media only screen and (min-height:1890px) and (max-height:2049px){
	body{zoom:2.191;}
}
@media only screen and (min-height:1690px) and  (max-height:1889px){
	body{zoom:2.020;}
}
@media only screen and (min-height:1490px) and (max-height:1689px){
	body{zoom:1.806;}
}
@media only screen and (min-height:1426px) and (max-height:1489px){
	body{zoom:1.593;}
}
@media only screen and (min-height:1330px) and (max-height:1425px){
	body{zoom:1.524;}
}
@media only screen and (min-height:1090px) and (max-height:1329px){
	body{zoom:1.421;}
}
@media only screen and (min-height:937px) and (max-height:1089px){
	body{zoom:1.165;}
}
@media only screen and (min-height:907px) and (max-height:936px){
	body{zoom:1;}
}
@media only screen and (min-height:881px) and (max-height:906px){
	body{zoom:0.969;}
}
@media only screen and (min-height:817px) and (max-height:880px){
	body{zoom:0.941;}
}
@media only screen and (min-height:757px) and (max-height:816px){
	body{zoom:0.873;}
}
@media only screen and (min-height:721px) and (max-height:756px){
	body{zoom:0.809;}
}
@media only screen and (min-height:711px) and (max-height:720px){
	body{zoom:0.770;}
}
@media only screen and (min-height:657px) and (max-height:710px){
	body{zoom:0.759;}
}
@media only screen and (min-height:625px) and (max-height:656px){
	body{zoom:0.702;}
}
@media only screen and (min-height:577px) and (max-height:624px){
	body{zoom:0.667;}
}
@media only screen and (min-height:457px) and (max-height:576px){
	body{zoom:0.616;}
}
@media only screen and (max-height:456px){
	body{zoom:0.488;}
}
</style>
<body>
<script src="//d3js.org/d3.v4.min.js"></script>
<div id="patent_block" class='dragscroll'>
	<div id="relative"></div>
</div>

<script>
_width = <?php echo $svgWidth;?> + 50;
_height = '<?php echo $svgHeight;?>';
_defaultGap = 30;
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
var defaultTab = "date-tab";
function openNodeLeaf(){
	jQuery("#claimsTree").find('li.node').off('click').on('click',function(){
		_open = false;
		if(jQuery(this).index()>_tapL){
			_tapL = jQuery(this).index();
			_open = true;
		} else {
			_tapL = -1;
		}
		
		if(_open===true){
			if(jQuery(this).hasClass('collapsed')){
				jQuery(this).removeClass('collapsed');
				jQuery(this).find('ul').eq(0).show().find('li.leaf').removeClass('collapsed');
			} else {
				jQuery(this).addClass('collapsed');
				jQuery(this).find('ul').eq(0).find('li.leaf').addClass('collapsed');
				jQuery(this).find('ul').eq(0).hide();
			}
		}	
	});	
	jQuery("#tree").find('text').off('click').on('click',function(){
		resetAllColor();
		var $this = jQuery(this);
		_textN = $this.find('tspan').text();
		_textN = parseInt(_textN);
		var TpCircle = $this.prev();
		if(TpCircle.length>0 && TpCircle[0].nodeName=="circle"){
			TpCircle.css('fill','#e0cf91');
		}
		jQuery("#claimsTree").find("span#claim"+_textN).css('background-color','rgb(255, 243, 198)');
		jQuery("#message").html(jQuery("#claimsTree").find("span#claim"+_textN).html());
		_nfParent = jQuery("#claimsTree").find("span#claim"+_textN).parent().parent();
		var mainP = _nfParent.attr('id');
		var ID;
		if(mainP==undefined){
			ID = _nfParent.prev().attr("id");
			if(ID!=undefined){
				ID = ID.replace('claim','');
				ID = parseInt(ID);
			}
		} else {
			ID = 1;
		}
		if(ID>0){
			jQuery("#tree").find('text').each(function(){
				if(parseInt(jQuery(this).find('tspan').text()) == ID && ID!=_textN){
					var TpCircle = jQuery(this).prev();
					if(TpCircle.length>0 && TpCircle[0].nodeName=="circle"){
						TpCircle.css('fill','#e09191');
					}
					return false;
				}
			});
		}
	});
	jQuery("#tree").find('circle').off('click').on('click',function(){
		resetAllColor();
		var cThis = jQuery(this);
		var $this = cThis.next();
		_textN = $this.find('tspan').text();
		_textN = parseInt(_textN);
		cThis.css('fill','#e0cf91');
		jQuery("#message").html(jQuery("#claimsTree").find("span#claim"+_textN).html());
		_nfParent = jQuery("#claimsTree").find("span#claim"+_textN).parent().parent();
		var mainP = _nfParent.attr('id');
		var ID;
		if(mainP==undefined){
			ID = _nfParent.prev().attr("id");
			if(ID!=undefined){
				ID = ID.replace('claim','');
				ID = parseInt(ID);
			}
		} else {
			ID = 1;
		}
		if(ID>0){
			jQuery("#tree").find('text').each(function(){
				if(parseInt(jQuery(this).find('tspan').text()) == ID && ID!=_textN){
					var TpCircle = jQuery(this).prev();
					if(TpCircle.length>0 && TpCircle[0].nodeName=="circle"){
						TpCircle.css('fill','#e09191');
					}
					return false;
				}
			});
		}
	});
}
function resetAllColor(){
	jQuery("#tree").find('circle').css('fill','#ffffff');
	jQuery("#claimsTree").find("span").css('background-color','');
}
function getNodePos(el)
{
    var body = d3.select('body').node();

    for (var lx = 0, ly = 0;
         el != null && el != body;
         lx += (el.offsetLeft || el.clientLeft), ly += (el.offsetTop || el.clientTop), el = (el.offsetParent || el.parentNode))
        ;
    return {x: lx, y: ly};
}
function connectionTooltipOpen(a, t){
	console.log("Tooltip");
	if($('#tool_connection_'+a.id).length==0){
		console.log("Tooltip display");
		var m = d3.mouse(t);
		/*console.log(m);*/
		_from = "";
		_to = "";
		jQuery.each(jsonRectangles,function(i,e){
			if(e.application_org_number == a.patent_app_number){
				_from = e.label;
			}
			if(e.application_org_number == a.relation_number){
				_to = e.label;
			}
			if(_to!="" && _from!=""){
				return false;
			}
		})
		$('body').append('<div id="tool_connection_'+a.id+'" class="search-form-help-text" style="top:'+m[1]+'px;left:'+m[0]+'px;opacity:0;"></div>');
		$('#tool_connection_'+a.id).append("<p class='value'>"+_from+" is a "+a.relation_type+" of "+_to+"</p>");
		$('#tool_connection_'+a.id).animate({opacity:1},500);
	}
}
function connectionTooltipClose(a){
	if($('#tool_connection_'+a.id).length>0){
		$('#tool_connection_'+a.id).remove();
	}
}
var _toolTipWidth = 370;
var _toolTipHeight = 300;
var _toolTipEmbedHeight = 175;
function tooltipOpen(a){
	if($('#'+a.label).length==0){
		 poke = false;
		 var offset = jQuery("#rec_"+a.label).offset();
		 var position = jQuery("#rec_"+a.label).position();
		 _b=0,_r=0;
		  _l = position.left;
		  _t = position.top + 80;
		if(_tooltipTop>=0){
			_t = _tooltipTop;
		}
		if(_tooltipLeft>=0){
			_l = _tooltipLeft;
		}
		/*_temp = position.left+310;
		 _l = position.left + 160;
		 _scrollLeft = jQuery("#patent_block").scrollLeft();
		 _t = position.top ;
		 _b=0,_r=0;
		 scrollX = body.w-100;
		 if(_temp>scrollX){
			 _l = _l - 310 - 160;
		 }*/
		 /*console.log(offset,position,scrollX,_temp,_l);*/
		/* 
		 var m = d3.mouse(root.node());
		 scr.x = window.scrollX;
		 scr.y = window.scrollY;
		 m[0] += svgpos.x;
		 m[1] += svgpos.y;
		   _t = 0,_b=0,_l=0,_r=0;
			 if (m[0] > scr.x + scr.w / 2) {
				 _r = (body.w - m[0] + dist.x);
			 }
			 else {
				_l = (m[0] + dist.x) ;
			 }

			 if (m[1] > scr.y + scr.h / 2) {
				 _b = (body.h - m[1] + dist.y);
			 }
			 else {
				 _t = (m[1] + dist.y);
			 }
			 if(_l==0 && _r<0){
				 _l = (m[0] + dist.x) - 100 ;
			 }	*/
		 var getTemplateAccordion = jQuery("#accordion_template").html();
		 console.log('B'+_controlKey);
		 if(_controlKey===false){
			 $('body').find('.search-form-help-text').attr("id",a.label).remove();
		 }		 
		 $('body').append('<div id="'+a.label+'" class="search-form-help-text" style="top:'+_t+'px;left:'+_l+'px;right:'+_r+'px;bottom:'+_b+'px;width:'+_toolTipWidth+'px;height:'+_toolTipHeight+'px;overflow:hidden;overflow-y:auto;"></div>');
		 $('body').find('#'+a.label).append(getTemplateAccordion);
		 clearedOtherBold();
		  $('body').find('#'+a.label).find("h6#heading").html(a.label+": <u>"+a.title+"</u>");
		  _issueDate = "";
		  if(a.issue_date!="" && a.issue_date!=null){
			  _issueDate = moment(new Date(a.issue_date)).format('MMM, DD YYYY');
		  }	
		  _fillingDate = "";
		  if(a.filling_date!="" && a.filling_date!=null){
			  _fillingDate = moment(new Date(a.filling_date)).format('MMM, DD YYYY');
		  }
		  _priorityDate = "";
		  if(a.priority_date!="" && a.priority_date!=null){
			  _priorityDate = moment(new Date(a.priority_date)).format('MMM, DD YYYY');
		  }
		  _inventor = "";
		  if(a.inventors!="" && a.inventors!=null){
			  _inventor = a.inventors;
		  }
		  _applicant = "";
		  if(a.applicants!="" && a.applicants!='[]' && a.applicants!=null){
			  _applicant = a.applicants;
		  }
		  _assignee = "";
		  if(a.assignee!="" && a.assignee!=null){
			  _assignee = a.assignee;
		  }
		  _status = "";
		  /*if(a.status!=""){
			  _status = a.status;
			  if(_status=="Patented Case"){
				  _status = "<span style='margin-left:20px;color:green'>Active</span>";
			  }
		  }	*/	  
		  if(a.application_country=="AU"){
			  _applicationDate = a.application_date;
			  _applicationDate = _applicationDate.substr(0,4);
			  _appNumber = "";
			  if(parseInt(_applicationDate)<2000){
				  _aon = a.application_org_number
				  _appNumber = _applicationDate+"0"+_aon.substr(0,5);
			  } else {
				  _aon = a.application_org_number
				  _appNumber = _applicationDate+"0"+_aon.substr(0,6);
			  }
			  _googlePatent = '<a target="_blank" href="http://pericles.ipaustralia.gov.au/ols/auspat/applicationDetails.do?applicationNo='+_appNumber+'">Australian Patent</a>';
		  } else {
			  _googlePatent = '<a target="_blank" href="https://patents.google.com/patent/'+a.label+'/en">Google Patent</a>';
		  }
		  
		 /* $('body').find('.search-form-help-text').find("h6#heading").append('<button type="button" onclick="jQuery(\'html\').find(\'.search-form-help-text\').remove();" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>');*/
		 $('body').find('#'+a.label).find('#date').html("<table class='table' style='width:auto !important;border:0px;'><tbody><tr><td>Inventor:</td><td><span>"+_inventor+"</span></td></tr><tr><td>Applicant:</td><td><span>"+_applicant+"</span></td></tr><tr><td>Assignee:</td><td>"+_assignee+"</td></tr><tr><td>Priority: </td><td>"+_priorityDate+"</td></tr><tr><td>Filed:</td><td><span>"+_fillingDate+"</span>"+_status+"</td></tr><tr><td>Issued:</td><td>"+_issueDate+"</td></tr><tr><td colspan='2' align='left'>"+_googlePatent+"</td></tr></tbody></table>");
		 /*_anchor = '<div class="float-left open_big_panel" style="width:100%;margin-bottom:3px;"><a href="javascript://" onclick="openBig(jQuery(this))" class="open_big float-left" data-p="0" style="width:16px;height:16px;"><svg aria-hidden="true" data-prefix="fas" data-icon="search-plus" class="svg-inline--fa fa-search-plus fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M304 192v32c0 6.6-5.4 12-12 12h-56v56c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-56h-56c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h56v-56c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v56h56c6.6 0 12 5.4 12 12zm201 284.7L476.7 505c-9.4 9.4-24.6 9.4-33.9 0L343 405.3c-4.5-4.5-7-10.6-7-17V372c-35.3 27.6-79.7 44-128 44C93.1 416 0 322.9 0 208S93.1 0 208 0s208 93.1 208 208c0 48.3-16.4 92.7-44 128h16.3c6.4 0 12.5 2.5 17 7l99.7 99.7c9.3 9.4 9.3 24.6 0 34zM344 208c0-75.2-60.8-136-136-136S72 132.8 72 208s60.8 136 136 136 136-60.8 136-136z"></path></svg></a></div>';*/
		 _anchor = '';
		 _abs = a.abstract;
		 if(_abs!=""){
			 _abs = _anchor+"<p>"+a.abstract+"</p>";
		 }
		 $('body').find('#'+a.label).find('#abstract').html(_abs);
		 _claim = a.claims;
		 if(_claim!=""){
			 _claim = _anchor+"<p>"+a.claims+"</p><div id='message'></div>";
		 }
		 $('body').find('#'+a.label).find('#claim').html(_claim);
		 if(a.image!=""){
			$('body').find('#'+a.label).find('#figure').html(_anchor+'<embed src='+a.image+'#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="'+_toolTipEmbedHeight+'px"/>');
		 }
		 _assigments = "";
		 if(a.assigments.length>0){
			 _assigments = "<table class='table' style='width:auto !important;border:0px;'><tbody>";
			 jQuery.each(a.assigments,function(i,c){
				 _assigments +="<tr><td>Exec. Date:</td><td><span>"+moment(new Date(c.assignee_date)).format('MMM, DD YYYY')+"</span></td></tr>";
				 _assigments +="<tr><td>Assignor:</td><td><span>"+c.assignor+"</span></td></tr>";
				 _assigments +="<tr><td>Assignee:</td><td><span>"+c.assignee+"</span></td></tr>";
				 _assigments +="<tr><td>Conveyance:</td><td><span>"+c.rights+"</span></td></tr>";
				 _assigments +="<tr><td>Recorded:</td><td><span>"+moment(new Date(c.recorded)).format('MMM, DD YYYY')+"</span></td></tr>";
			 });
			 _assigments +="</tbody></table>";
		 }
		 $('body').find('#'+a.label).find('#assigments').html(_assigments);
		 $("#"+a.label).draggable({
			 containment: "parent",
			 stop:function( event, ui ){
				 _tooltipTop = ui.position.top;
				 _tooltipLeft = ui.position.left;
			 }
		 });
			$('body').find('#'+a.label).find('#patTabs a').removeClass('active').removeClass('show');
			$('body').find('#'+a.label).find('.tab-pane').removeClass('active').removeClass('show');
			$('body').find('#'+a.label).find("#"+defaultTab).addClass('active show');
			_ct = jQuery("#"+defaultTab).attr('aria-controls');
			$('body').find('#'+a.label).find('#'+_ct).addClass('active show');
		 $('body').find('#'+a.label).find('#patTabs a').on('mouseover', function (e) {
			 e.preventDefault();
			$('body').find('#'+a.label).find('#patTabs a').removeClass('active').removeClass('show');
			$('body').find('#'+a.label).find('.tab-pane').removeClass('active').removeClass('show');
			defaultTab = $(this).attr('id');
			$(this).addClass('active show');
			_ct = $(this).attr('aria-controls');
			$('body').find('#'+a.label).find('#'+_ct).addClass('active show');
			_p = 0;
			_wwidth = $('body').find('#'+a.label).css('width');
			if(_wwidth=="600px"){
				_p = 1;
			}
			$(this).attr('data-p',_p);openNodeLeaf();
			
		 }).on('click',function(){
			openBig(jQuery(this));
		 })
		 $('body').find('#'+a.label).off('mouseenter').off('mouseleave').on("mouseleave", function() {
			/*$('body').find('.search-form-help-text').remove();
			poke = false; */
		}).on('mouseenter',function(){/*poke = true;*/});
	} else {
		console.log("Remove"+a.label);
		poke = false;
		$('#'+a.label).remove();
	}	
}

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

function tooltipClose(){
	if(poke===false){
		setTimeout(function(){
		 if(poke===false){
			$('body').find('.search-form-help-text').remove();
		 }
		},1000);
	}
}
function openBig(o){
	_getAttr = o.attr('data-p');
	var p = o.parents('.search-form-help-text');
	if(_getAttr==0){
		_toolTipWidth = 600;
		_toolTipHeight = 550;
		_toolTipEmbedHeight = 450;
		o.attr('data-p',1);
	} else {
		_toolTipWidth = 370;
		_toolTipHeight = 300;
		_toolTipEmbedHeight = 175;
		o.attr('data-p',0);
		/*o.attr('data-p',0).html('<svg aria-hidden="true" data-prefix="fas" data-icon="search-plus" class="svg-inline--fa fa-search-plus fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M304 192v32c0 6.6-5.4 12-12 12h-56v56c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-56h-56c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h56v-56c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v56h56c6.6 0 12 5.4 12 12zm201 284.7L476.7 505c-9.4 9.4-24.6 9.4-33.9 0L343 405.3c-4.5-4.5-7-10.6-7-17V372c-35.3 27.6-79.7 44-128 44C93.1 416 0 322.9 0 208S93.1 0 208 0s208 93.1 208 208c0 48.3-16.4 92.7-44 128h16.3c6.4 0 12.5 2.5 17 7l99.7 99.7c9.3 9.4 9.3 24.6 0 34zM344 208c0-75.2-60.8-136-136-136S72 132.8 72 208s60.8 136 136 136 136-60.8 136-136z"></path></svg>');*/
	}
	p.css({width:_toolTipWidth+'px',height:_toolTipHeight+'px'})
	p.find('embed').attr('height',_toolTipEmbedHeight+'px').attr('src',p.find('embed').attr('src'));
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
function highlightConnections(a,n){
	clearedOtherBold();clearPath();clearRectangles();
	_obJ = jQuery('rect[data-point="'+a.application_org_number+'"]');
	_tab = false;
	if(_obJ.css('stroke-width')=="1px"){
		_tab = true;
		_obJ.attr('stroke','#000000').attr('fill','#FFFF00').attr('style','stroke-width:2px');
	} else {
		_obJ.attr('stroke','#999').attr('fill','#FFF').attr('style','stroke-width:1px');
	}
	/*Parents*/
	jQuery.each(jsonRectangles,function(s,rec){
		if(rec.relation.length>0){
			jQuery.each(rec.relation,function(t,rel){
				if(a.application_org_number == rel.relation_number){
					if(jQuery("#"+rel.id).length>0){
						_obj = jQuery("#"+rel.id);
						_orgStroke = _obj.attr('data-orgstroke');
						if(_tab===true){
							_markerUrl = 'url(#1_markerREC_'+_orgStroke+')';
							_obj.attr('style','stroke-width:'+n).attr('highlight',true).attr('marker-end',_markerUrl);
							jQuery('rect[data-point="'+rec.application_org_number+'"]').attr('stroke','#000000').attr('stroke-width',2).attr('fill','#fcfca9');
						} else {
							_markerUrl = 'url(#markerREC_'+_orgStroke+')';
							_obj.attr('style','stroke-width:2').attr('highlight',false).attr('marker-end',_markerUrl);
							jQuery('rect[data-point="'+rec.application_org_number+'"]').attr('stroke','#999').attr('stroke-width',1).attr('fill','#FFF');
						}				
					}
					return false;
				}
			});
		}
	});
	/*Childs*/
	if(a.relation.length>0){
		jQuery.each(a.relation,function(s,rel){
			if(jQuery("#"+rel.id).length>0){
				_obj = jQuery("#"+rel.id);
				_orgStroke = _obj.attr('data-orgstroke');
				if(_tab===true){
					_markerUrl = 'url(#1_markerREC_'+_orgStroke+')';
					_obj.attr('style','stroke-width:'+n).attr('highlight',true).attr('marker-end',_markerUrl);
					jQuery('rect[data-point="'+rel.relation_number+'"]').attr('stroke','#000000').attr('stroke-width',2).attr('fill','#fcfca9');
				} else {
					_markerUrl = 'url(#markerREC_'+_orgStroke+')';
					_obj.attr('style','stroke-width:2').attr('highlight',false).attr('marker-end',_markerUrl);
					jQuery('rect[data-point="'+rel.relation_number+'"]').attr('stroke','#999').attr('stroke-width',1).attr('fill','#FFF');
				}				
			}
		});
	}
}
/*#CC0000*/
/*var jsonRectangles = JSON.parse('<?php echo json_encode($jsonRectangles);?>');
*/
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
var jsonCountries = JSON.parse('<?php echo json_encode($countries);?>');
var jsonRelations = JSON.parse('<?php echo json_encode($jsonRelations);?>');

jsonRelations.map(function(t,j){
	_s = -1;
	_t = -1;
	jQuery.each(jsonRectangles,function(i,s){
		if(s.application_org_number==t.patent_app_number){
			_s = i;
		}
		if(t.relation_number == s.application_org_number){
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
if(window.innerHeight>_height){
	_height = window.innerHeight - 20;
}
var linksPoint = [];
var linksRe = [];
var _chList = JSON.parse('<?php echo json_encode($childList);?>');
var _prList = JSON.parse('<?php echo json_encode($parentList);?>');
var _verticals = JSON.parse('<?php echo json_encode($verticals);?>');
var _nonverticals = JSON.parse('<?php echo json_encode($nonVerticalsEntries);?>');
var _nonverticalsExits = JSON.parse('<?php echo json_encode($nonVerticalsExits);?>');
var svgContainer = d3.select("#patent_block").append("svg")
					.attr("width", _width)
					.attr("height", _height);
var root = d3.select("svg");
var scr = { x: window.scrollX, y: window.scrollY, w: window.innerWidth, h: window.innerHeight };
var body_sel = d3.select('body');
var body = { w: body_sel.node().offsetWidth, h: body_sel.node().offsetHeight };
jQuery('#patent_block').css({width:(_width + 100 )+'px',height:(_height + 100)+'px'});
jQuery(window).resize(function(){
 jQuery('#patent_block').css({width:window.innerWidth+'px',height:window.innerHeight+'px'});
});
var doc = { w: document.width, h: document.height };
var svgpos = getNodePos(root.node());
var dist = { x: 10, y: 10 };
var poke = false;
var glineSVGPath,bar,images,defs,marker,_status = "",_showConnections = true,_showArrow = true;
var _tooltipTop = -1, _tooltipLeft = -1;

var _color = ["800000","F08080","CD5C5C","008000","228B22","800080","FA8072","000080","FF4500","FFA500","808000","DAA520","696969","9400D3","32CD32","000000"];



function createIllustration(){
	if(_showConnections===true){
		_color = ["800000","F08080","CD5C5C","008000","228B22","800080","FA8072","000080","FF4500","FFA500","808000","DAA520","696969","9400D3","32CD32","000000"];
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
		
		glineSVGPath =  svgContainer
						.selectAll(".connection")
						.data(jsonRelations)
						.enter().append('svg:path')
						.attr('class','connection');
		glineSVGPath
			  .attr('id',function(d){return d.id})
			  .attr('d', function(d,i){
				   _patentAppNumber = d.patent_app_number;
				   _relationAppNumber = d.relation_number;
				   _x1 = 0;
				   _x2 = 0;
				   _y1 = 0;
				   _y2 = 0;
				   _relationType = "";
				  jQuery.each(jsonRectangles,function(i,r){
					  if(r.application_org_number == _patentAppNumber){
							_x1 = parseInt(r.x_axis) + 85.5;
							_relationType = d.relation_type;
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
						  if(parseInt(s.ID)==parseInt(d.patent_app_number)){
							  _linkage = s.link + 1;
							  linksRe[i].link = _linkage;
							  _vFoundLinkage = true;
							  return false;
							  
						  }
					  });
				  } 
				  if(_vFoundLinkage===false){
					  var ID = parseInt(d.patent_app_number);
					  var link = 1;
					  _linkage = 1;
					  linksRe.push({ID:ID,link:link});
				  }
				  if(_linkage>0){
					  d3.select(this).attr('link',_linkage);
				  } 
				  jQuery.each(jsonRectangles,function(i,r){
					  if(r.application_org_number == _patentAppNumber){
							jQuery.each(jsonRectangles,function(k,t){
								if(t.application_org_number == d.relation_number){
									if(parseInt(r.x_axis) == parseInt(t.x_axis)){
										_x2 = parseInt(r.x_axis) + 85.5;
									} else {
										_x2 = parseInt(t.x_axis) + 85.5;
									}
									return false;
								}
							});
							if(_x2==0){
								_x2 = parseInt(r.x_axis) + 85.5;
							}
							return false;
					  }
				  });
				  jQuery.each(jsonRectangles,function(p,r){
					  if(r.application_org_number == _relationAppNumber){
							jQuery.each(jsonRectangles,function(m,j){
								if(d.patent_app_number == j.application_org_number){
									_y1 = parseInt(j.y_axis) + 72;
									return false;
								}
							})
							return false;
					  }
				  });
				  jQuery.each(jsonRectangles,function(i,r){
					  if(r.application_org_number == _relationAppNumber){
							jQuery.each(jsonRectangles,function(k,t){
								if(t.application_org_number == d.patent_app_number){
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
							return false;
					  }
				  });
				  _color = "";
				  switch(_relationType){
					  case 'CIP':
						_color = "#800000";
					  break;
					  case 'DIV':
						_color = "#F08080";
					  break;
					  case 'REX':
						_color = "#CD5C5C";
					  break;
					  case 'CON':
						_color = "#008000";
					  break;
					  case 'REI':
						_color = "#228B22";
					  break;
					  case 'PRO':
						_color = "#800080";
					  break;
					  case 'SUB':
						_color = "#FA8072";
					  break;
					  case 'SER':
						_color = "#000080";
					  break;
					  case 'NST':
						_color = "#FF4500";
					  break;
					  case 'RIC':
						_color = "#FFA500";
					  break;
					  case 'RID':
						_color = "#808000";
					  break;
					  default:
						if(_relationType == "which is Patented claims the benefit of"){
							_color = "#DAA520";
						}else if(_relationType == "which is Abandoned claims the benefit of"){
							_color = "#696969";
						}else if(_relationType == "which is - claims the benefit of"){
							_color = "#9400D3";
						}else if(_relationType == "which is Pending claims the benefit of"){
							_color = "#2F4F4F";
						}else if(_relationType =="which is Published claims the benefit of"){
							_color = "#32CD32";
						}
					  break;
				  }
				  _colorMarker = _color.replace("#","");
				  d3.select(this).attr('data-orgstroke',_colorMarker)
				  .attr('data-connectionstart',_patentAppNumber)
				  .attr('highlight',false)
				  .attr('data-connectionend',_relationAppNumber);
				  console.log("AAS:"+_showArrow);
				  if(_showArrow===true){
					  d3.select(this).attr('marker-end', 'url(#markerREC_'+_colorMarker+')' )
				  }
				  if(_x1==_x2){
					  d3.select(this).attr('stroke',_color);
					  if(_y1>0 && _y2>0){
						  if(_showArrow===true){
							_y2 = _y2-10;
						  }
						   _x1 = _x1 - 85.5;
						  _x2 = _x2 - 85.5;
						  _X=0;
						  _XX=0;
						  jQuery.each(_chList,function(i,c){
							  if(parseInt(c[0])==parseInt(d.patent_app_number)){
								  _X=parseInt(_linkage) * parseFloat(c[2]);
								  if(_X>0){_X = _X - parseFloat(c[2]);} 
								  return false;
							  }
						  });
						  jQuery.each(_prList,function(i,p){
							  if(parseInt(p[0])==parseInt(d.relation_number)){
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
						  if(_verticals.length>0){
							  _IDD = parseInt(d.patent_app_number+d.relation_number);
							  $.each(_verticals,function(i,v){
								  if(_IDD == parseInt(v.id)){
									 _x1 =  v.x_axis;
									 _x2 =  v.x_axis;
								  }
							  })
						  }
						  return 'M'+_x1+','+_y1+'L'+_x2+','+_y2;
					  }else {
						  return '';
					  }				  
				  } else {
					   if(_x2>_x1){
						  d3.select(this).attr('stroke',_color);
						  if(_y1<_x1){							  
							  if(_nonverticals.length>0){	
								  _IDD = parseInt(d.patent_app_number+d.relation_number);
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
								  _IDD = parseInt(d.patent_app_number);
								  $.each(_nonverticalsExits,function(i,v){
									  if(_IDD == parseInt(v.app_rel_number)){
										 if(v.entry=="right"){
											 _x1 +=85.5;
										 }else if(v.entry=="left"){
											 _x1 -=85.5;
										 }
									  }
								  })
							  }
							  if(_showArrow===true){
								  return 'M'+(_x1+5)+','+_y1+'L'+(_x2-9)+','+(_y2-2);
							  } else {
								  return 'M'+_x1+','+_y1+'L'+_x2+','+_y2;
							  }							  
						  }else {							  
							 if(_nonverticals.length>0){
								  _IDD = parseInt(d.patent_app_number+d.relation_number);
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
								  _IDD = parseInt(d.patent_app_number);
								  $.each(_nonverticalsExits,function(i,v){
									  if(_IDD == parseInt(v.app_rel_number)){
										 if(v.entry=="right"){
											 _x1 +=85.5;
										 }else if(v.entry=="left"){
											 _x1 -=85.5;
										 }
									  }
								  })
							  }
							  if(_showArrow===true){
								  return 'M'+(_x1-3)+','+_y1+'L'+_x2+','+(_y2-9);
							  } else {
								  return 'M'+(_x1)+','+_y1+'L'+_x2+','+(_y2);
							  }
						  }
					  }else if(_x2<_x1){
						  d3.select(this).attr('stroke',_color);
						  if(_y1<_x1){
							  if(_nonverticals.length>0){
								  _IDD = parseInt(d.patent_app_number+d.relation_number);
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
								  _IDD = parseInt(d.patent_app_number);
								  $.each(_nonverticalsExits,function(i,v){
									  if(_IDD == parseInt(v.app_rel_number)){
										 if(v.entry=="right"){
											 _x1 +=85.5;
										 }else if(v.entry=="left"){
											 _x1 -=85.5;
										 }
									  }
								  })
							  }
							  if(_showArrow===true){
								return 'M'+(_x1)+','+_y1+'L'+_x2+','+(_y2-8);
							  } else {
								  return 'M'+(_x1)+','+_y1+'L'+_x2+','+(_y2);
							  }
						  } else {
							  if(_nonverticals.length>0){
								  _IDD = parseInt(d.patent_app_number+d.relation_number);
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
								  _IDD = parseInt(d.patent_app_number);
								  $.each(_nonverticalsExits,function(i,v){
									  if(_IDD == parseInt(v.app_rel_number)){
										 if(v.entry=="right"){
											 _x1 +=85.5;
										 }else if(v.entry=="left"){
											 _x1 -=85.5;
										 }
									  }
								  })
							  }
							  if(_showArrow===true){
								return 'M'+(_x1-2)+','+_y1+'L'+_x2+','+(_y2-9);
							  } else {
								  return 'M'+(_x1)+','+_y1+'L'+_x2+','+(_y2);
							  }
						  }
					  }
				  }
			  }).on('mouseenter',function(a){
				  connectionTooltipOpen(a,this);
			  }).on('click',function(a){		
					_strokeC = jQuery("#"+a.id).attr('data-orgstroke');
					_highlight = jQuery("#"+a.id).attr('highlight');
					_marketURL = "";
					_h = false;
					_strK = 2;
					_fill = "#FFF";
					_sRW = 1;
					_sRC = "#999";
					_marketURL = 'url(#markerREC_'+_strokeC+')';
					if(_highlight=='false'){
						_marketURL = 'url(#1_markerREC_'+_strokeC+')';
						_h = true;
						_strK = 4;
						_fill = "#FFFF00";
						_sRW = 2;
						_sRC = "#000";
					} 
					console.log('MarkerURL'+_marketURL);
					_pointS = jQuery("#"+a.id).attr('data-connectionstart');
					_pointE = jQuery("#"+a.id).attr('data-connectionend');
					_pointE = jQuery("#"+a.id).attr('data-connectionend');
					jQuery('rect[data-point="'+_pointS+'"],rect[data-point="'+_pointE+'"]').attr('stroke',_sRC).attr('stroke-width',_sRW).attr('fill',_fill);
					d3.select(this)
					.style("stroke-width", _strK)
					.attr('highlight',_h)
					.attr('marker-end',_marketURL);
				}).on('mouseleave',function(a){connectionTooltipClose(a);});
	}
	
	bar = svgContainer.selectAll("g")
    .data(jsonRectangles)
    .enter().append("g")
    .on('mousemove',function(a){
		//tooltipOpen(a);
	}).on('click',function(a){
		if($('#'+a.label).length>0){
			poke = true;
		} else {
			setTimeout(function(){highlightConnections(a,3),50});
		}
		
	}).on("mouseout", function() {
	 //tooltipClose();
	});	 
	bar.append("rect")
	  .attr("x", function (d) { return parseInt(d.x_axis); })
	  .attr("y", function (d) { return parseInt(d.y_axis); })
	  .attr("rx", 5)
	  .attr("ry", 5)
	  .attr('class','rec')
	  .attr('id',function(d){ return 'rec_'+d.label;})
	  .attr('data-point',function(d){ return d.application_org_number;})
	  .attr("height", function (d) { return d.height; })
	  .attr("width", function (d) { return d.width; })
	  .attr("fill",'#fff')
	  .attr('stroke',function(d){if(d.search===true){return '#cc0000';}else{return '#999';}})
	  .attr('style',function(d){if(d.search===true){return 'stroke-width:2;';}else{return 'stroke-width:1;';}})
	  .on('mousemove',function(a){
		/*if($('#'+a.label).length>0){
			poke = true;
		} else {
			tooltipOpen(a);
		}*/
	}).on('click',function(a){
		if($('#'+a.label).length>0){
			console.log("Rec clicked..");
			setTimeout(function(){highlightConnections(a,3),50});
		} 
	}).on("mouseout", function(a) {
		/*poke = false;
		setTimeout(tooltipClose,1000);*/
	});	
	images = bar.append("svg:image")
		.attr("xlink:href",  function(d) { return 'https://backyard.synpat.com/public/icons/flags/'+d.country+'.png';})
		.attr("x", function(d) { return parseInt(d.x_axis) + 10 ;})
		.attr("y", function(d) { return parseInt(d.y_axis) + 5;})
		.attr("height", 30)
		.attr("width", 30)
		.on('mousemove',function(a){
		/*if($('#'+a.label).length>0){
			poke = true;
		} else {
			tooltipOpen(a);
		}*/
	}).on('click',function(a){
		if($('#'+a.label).length>0){
			poke = true;
		}
		setTimeout(function(){highlightConnections(a,3),50});
		
	}).on("mouseout", function(a) {
		/*poke = false;
		setTimeout(tooltipClose,1000);*/
	});
	var textLabel = svgContainer.selectAll('.text_marker').data(jsonRectangles).enter().append('text');
	textLabel
	.attr("class", 'text_marker')
	.attr("dy", -6)
	.attr("x", function(d) { return parseInt(d.x_axis) + 45; })
	.attr("y",function(d) { return parseInt(d.y_axis) + 31; })
	.html(function (d) {return d.label;})
	.attr('fill', '#007bff')
	.attr('style','font-size:14px;text-anchor:start')
	.on('mousemove',function(a){
		/*if($('#'+a.label).length>0){
			poke = true;
		} else {
			tooltipOpen(a);
		}*/
	}).on('click',function(a){
		if($('#'+a.label).length>0){
			poke = true;
			/*$("#rec_"+a.label).attr('fill','#FFF');*/
			$(this).css('font-weight','');
			$('#'+a.label).remove();
			poke = false;
		} else {
			/*if($("#rec_"+a.label).attr('fill')!='#FFFF00'){
				refreshedItems();
			}*/	
			
			$(this).css('font-weight','bold');
			setTimeout(function(){tooltipOpen(a)},100);
			//setTimeout(function(){highlightConnections(a,4),110});
		}
	}).on("mouseout", function(a) {
		/*poke = false;
		setTimeout(tooltipClose,1000);*/
	});
	var textLabel = svgContainer.selectAll('.text_marker1').data(jsonRectangles).enter().append('text');	
	textLabel
	.attr("class", 'text_marker1')
	.attr("dy", 6)
	.attr("x", function(d) { return parseInt(d.x_axis) + 10; })
	.attr("y",function(d) { return parseInt(d.y_axis) + 40; })
	.html(function (d) {return d.application_number;})
	.attr('fill', '#000')
	.attr('style','font-size:14px;text-anchor:start')
	.on('mousemove',function(a){
		/*if($('#'+a.label).length>0){
			poke = true;
		} else {
			tooltipOpen(a);
		}*/
		
	}).on('click',function(a){
		if($('#'+a.label).length>0){
			poke = true;
		}
		setTimeout(function(){highlightConnections(a,3),50});
		
	}).on("mouseout", function(a) {
		/*poke = false;
		setTimeout(tooltipClose,1000);*/
	});
	var textLabel = svgContainer.selectAll('.text_marker2').data(jsonRectangles).enter().append('text');
	textLabel
	.attr("class", 'text_marker2')
	.attr("dy", -6)
	.attr("x", function(d) { return parseInt(d.x_axis) + 10; })
	.attr("y",function(d) { return parseInt(d.y_axis) + 70; })
	.text(function (d) {
		return 'Filed: '+ moment(new Date(d.filling_date)).format('MMM,DD YYYY');
	})
	.attr('fill', '#000')
	.attr('style','font-size:12px;text-anchor:start')
	.on('mousemove',function(a){
		/*if($('#'+a.label).length>0){
			poke = true;
		} else {
			tooltipOpen(a);
		}*/
	}).on('click',function(a){
		if($('#'+a.label).length>0){
			poke = true;
		}
		setTimeout(function(){highlightConnections(a,3),50});
	}).on("mouseout", function(a) {
		/*poke = false;
		setTimeout(tooltipClose,1000);*/
	});
	var textLabel = svgContainer.selectAll('.text_marker4').data(jsonRectangles).enter().append('text');
	textLabel
	.attr("class", 'text_marker4')
	.attr("dy", -6)
	.attr("x", function(d) { return parseInt(d.x_axis) + 115; })
	.attr("y",function(d) { return parseInt(d.y_axis) + 70; })
	.text(function (d) {
		if(d.status=="Patented Case"){
			return "Active";
		}else {
			return '';
		}
	})
	.attr('fill', 'green')
	.attr('style','font-size:12px;text-anchor:start')
	.on('mousemove',function(a){
		/*if($('#'+a.label).length>0){
			poke = true;
		} else {
			tooltipOpen(a);
		}*/
	}).on('click',function(a){
		if($('#'+a.label).length>0){
			poke = true;
		}
		setTimeout(function(){highlightConnections(a,3),50});
	}).on("mouseout", function(a) {
		/*poke = false;
		setTimeout(tooltipClose,1000);*/
	});
	var dashLines = svgContainer.selectAll('.dashed')
		.data(jsonRectangles)
		.enter()
		.append('line')
		.attr('class','dashed')
		.attr('stroke-width',function(d,i){
			if(d.same===true){
				return 1;
			} else {
				return 0;
			}
		})
		.attr('stroke','#999')
		.attr('x1',function(d,i){
			if(d.same===true){
				if(typeof jsonRectangles[i-1]!="undefined"){
					return parseInt(jsonRectangles[i-1].x_axis) + 170 + _defaultGap;
				}							
			}
		}).attr('x2',function(d,i){
			if(d.same===true){
				if(typeof jsonRectangles[i-1]!="undefined"){
					return parseInt(jsonRectangles[i-1].x_axis) + 170;
				}							
			}
		}).attr('y1',function(d,i){
			if(d.same===true){
				return parseInt(d.y_axis) + 60;							
			}
		})
		.attr('y2',function(d,i){
			if(d.same===true){
				return parseInt(d.y_axis) + 60;							
			}
		})
	 var curlyLines = svgContainer.selectAll('.curlyBrace')
		  .data(jsonRectangles)
		  .enter()
		  .append("path").attr("class","curlyBrace")
		  .attr("d", function(d,i) {
			if(i>0 && d.same===false){
				x1 = 0;
				y1 = 0;
				for(j=i-1;j>=0;j--){
				 if(parseInt(jsonRectangles[j].x_axis) == parseInt(d.x_axis)){
					x1 = parseInt(jsonRectangles[j].x_axis);
					y1 = parseInt(jsonRectangles[j].y_axis);
					 break;
				 }
				}
				x2 = parseInt(d.x_axis);
				y2 = parseInt(d.y_axis) + 60;
				v = y1 + 60;
				if(x1>0 && y1>0){
					y1 = y1+20;
					return ("M"+x1+","+y2+"H30V"+v+"H"+x2+"");
				} else {
					return ("M00H0V0H0");
				}
			}
		  })
	  bar.append('svg:path')
			.attr('d', function(d,i){
				if(i>0 && d.same===false){
						x1 = 0;
						y1 = 0;
						for(j=i-1;j>=0;j--){
						 if(parseInt(jsonRectangles[j].x_axis) == parseInt(d.x_axis)){
							x1 = parseInt(jsonRectangles[j].x_axis) ;
							y1 = parseInt(jsonRectangles[j].y_axis);
							 break;
						 }
						}
						x2 = parseInt(d.x_axis);
						y2 = parseInt(d.y_axis) ;
						if(x1>0 && y1>0){
							y2 = y2 + 61;
							y2 = y2+'.41913l4.537781 -1.6525879l-4.538391 -1.6508789z';
							
							return 'M '+(x2 -10)+' ' + y2;								
						} else {
							return '';
						}
			 }
		})
		  .attr('stroke', '#999')
		  .attr('stroke-width', function(d,i){
			  _wi = 0;
			  if(i>0 && d.same===false){
				x1 = 0;
				y1 = 0;
				for(j=i-1;j>=0;j--){
				 if(parseInt(jsonRectangles[j].x_axis) == parseInt(d.x_axis)){
					x1 = parseInt(jsonRectangles[j].x_axis) ;
					y1 = parseInt(jsonRectangles[j].y_axis);
					 break;
				 }
				}
				if(x1>0 && y1>0){
					_wi = 3;
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
				_endDate = d.filling_date;
				if(i>0 && d.same===false){
					for(j=i-1;j>=0;j--){
						if(parseInt(jsonRectangles[j].x_axis) == parseInt(d.x_axis)){
							_startDate = jsonRectangles[j].filling_date;
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
				_endDate = d.filling_date;
				if(i>0 && d.same===false){
					for(j=i-1;j>=0;j--){
						if(parseInt(jsonRectangles[j].x_axis) == parseInt(d.x_axis)){
							_startDate = jsonRectangles[j].filling_date;
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
				_startDate = "";
				_endDate = d.filling_date;
				if(i>0 && d.same===false){
					for(j=i-1;j>=0;j--){
						if(parseInt(jsonRectangles[j].x_axis) == parseInt(d.x_axis)){
							_startDate = jsonRectangles[j].filling_date;
							break;
						}
					}
				}
				if(_startDate!=""){
					x = parseInt(d.x_axis) - 35;
					y = parseInt(d.y_axis) - 20;
					_diffString = differenceDates(_startDate,_endDate);
					_string = "";
					if(_diffString.length==2){
						_string = "<tspan x='"+x+"' y='"+y+"' dy='-1.5em'>"+_diffString[0]+"</tspan><tspan x='"+x+"' y='"+y+"' dy='-0.2em'>"+_diffString[1]+"</tspan>";
					} else {
						_string = "<tspan x='"+x+"' y='"+y+"' dy='-1.5em'>"+_diffString[0]+"</tspan>";
					}								
					return _string;
				} else {
					return '';
				}
			});
			
}	
createIllustration();
 </script>
<div id="accordion_template" style='display:none'>
	<div id="accordionExample">
		<div class="container">
			<div class="row">
				<h6 id="heading" class=''></h6>
			</div>
			
		</div>
		<ul class="nav nav-tabs" role="tablist" id="patTabs">
		  <li class="nav-item">
			<a class="nav-link active" id="date-tab" data-toggle="tab" href="#date" role="tab" aria-controls="date" aria-selected="true">Data <span class='data-tab-icon'style='margin-left:5px;'><i class='fa fa-expand'></i></span></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="abstract-tab" data-toggle="tab" href="#abstract" role="tab" aria-controls="abstract" aria-selected="false">Abstract</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="claim-tab" data-toggle="tab" href="#claim" role="tab" aria-controls="claim" aria-selected="false">Claim</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="figure-tab" data-toggle="tab" href="#figure" role="tab" aria-controls="figure" aria-selected="false">Figure</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="assignments-tab" data-toggle="tab" href="#assigments" role="tab" aria-controls="assigments" aria-selected="false">Assigments</a>
		  </li>
		</ul>
		<div class="tab-content" id="myTabContent">
		  <div class="tab-pane fade show active" id="date" role="tabpanel" aria-labelledby="date-tab"><p></p></div>
		  <div class="tab-pane fade" id="abstract" role="tabpanel" aria-labelledby="abstract-tab"><p></p></div>
		  <div class="tab-pane fade" id="claim" role="tabpanel" aria-labelledby="claim-tab"><p></p></div>
		  <div class="tab-pane fade" id="figure" role="tabpanel" aria-labelledby="figure-tab"><p></p></div>
		  <div class="tab-pane fade" id="assigments" role="tabpanel" aria-labelledby="assignments-tab"><p></p></div>
		</div>
	</div>
</div>
<script>
_controlKey = false;
jQuery('body').on('click',function(e) {
	_getTarget = jQuery(e.target);
	/*console.log(e);
	console.log(_getTarget);*/
	_controlKey = false;
	if (e.ctrlKey){
		_controlKey = true;
	}
	console.log('A'+_controlKey);
	if(_getTarget.length>0){
		_id = _getTarget[0].id;
		_className = _getTarget[0].className;
		if(_id!="undefined"){
			_nodeName = _getTarget[0].nodeName;
			console.log('A'+_id+'B');
			console.log('A'+_nodeName+'B');
			if(_nodeName!="path" && _nodeName!="rect" && _nodeName!="text" && _nodeName!="image" && _className.baseVal!="text_marker" && _id!="claim-tab"&& _id!="assignments-tab" && _id!="date-tab" && _id!="abstract-tab" && _id!="figure-tab" && _id!="date" && _id!="abstract" && _id!="claim" && _id!="figure" && _id!="assigments" && _nodeName!="TD" && _nodeName!="TR" && _nodeName!="P" && _nodeName!="EMBED" && _className!="row"){
				console.log("Items refreshed");
				refreshedItems();
			}	
		}
		
		/*console.log(_className);
		console.log(_className.baseVal);*/
		if(_className.baseVal!="text_marker" &&  _nodeName!="rect"  && _nodeName!="text" && _nodeName!="image" && _id!="claim-tab"&& _id!="assignments-tab" && _id!="date-tab" && _id!="abstract-tab" && _id!="figure-tab" && _id!="date" && _id!="abstract" && _id!="claim" && _id!="figure" && _id!="assigments" && _nodeName!="TD" && _nodeName!="TR" && _nodeName!="P" && _nodeName!="EMBED" && _className!="row"){
			if(jQuery('.search-form-help-text').length>0){
				jQuery('.search-form-help-text').remove();
			}
			clearedOtherBold();
		}	
	}	
});
jQuery(document).ready(function(){
	jQuery(window).on('keypress',function(e){
		if (e.ctrlKey){
			_controlKey = true;
		}
		console.log(_controlKey);
	});
});
function removedIllustration(){
	jQuery("#patent_block").find('g,rect,text,path,image,line,marker,defs').remove();
	jQuery("#patent_block").find('svg').attr('width',_width);
}
function clearedOtherBold(){
	jQuery('.text_marker').each(function(){
		var $_c = jQuery(this);
		_ID = $_c.text();
		if(jQuery("#"+_ID).length==0){
			$_c.css('font-weight','');
		}
	});
}
function refreshedItems(){
	jQuery('path').each(function(){
		var $_c = jQuery(this);
		if($_c.attr('id')!="undefined"){
			_packID = $_c.attr('id');
			_dap = jQuery("#"+_packID)
			if(_dap.length>0){
				/*console.log(_dap.attr('marker-end'));
				console.log('Highlight:'+_dap.attr('highlight'));*/
				if(_dap.attr('highlight')=='true'){
					/*console.log('1');*/
					_dap.attr('stroke','#'+_dap.attr('data-orgstroke')).attr('style','stroke-width:2').attr('highlight',false);
					if(_showArrow===true){
						_dap.attr('marker-end','url(#markerREC_'+_dap.attr('data-orgstroke')+')');
					}
					_pointS = _dap.attr('data-connectionstart');
					_pointE = _dap.attr('data-connectionend');
					 jQuery('rect[data-point="'+_pointS+'"],rect[data-point="'+_pointE+'"]').attr('stroke','#999').attr('fill','#ffffff').attr('stroke-width',1).css('stroke-width','1px');
					 if(jQuery('#tool_connection_'+_dap.attr('id')).length>0){
						 jQuery('html').find('.search-form-help-text').remove();
					 }
				}
			}
		}
	});
	clearRectangles();
}
function clearRectangles(){
	jQuery('rect').each(function(){
		if(jQuery(this).attr('fill')=="#FFFF00"){
			jQuery(this).attr('stroke','#999').attr('fill','#ffffff');
		}
	});
}
function clearPath(){
	jQuery('path').each(function(){
		var $_c = jQuery(this);
		if($_c.attr('id')!="undefined"){
			_packID = $_c.attr('id');
			_dap = jQuery("#"+_packID)
			if(_dap.length>0){
				/*console.log(_dap.attr('marker-end'));
				console.log('Highlight:'+_dap.attr('highlight'));*/
				if(_dap.attr('highlight')=='true'){
					/*console.log('1');*/
					_dap.attr('stroke','#'+_dap.attr('data-orgstroke')).attr('style','stroke-width:2').attr('highlight',false);
					if(_showArrow===true){
						_dap.attr('marker-end','url(#markerREC_'+_dap.attr('data-orgstroke')+')');
					}
					_pointS = _dap.attr('data-connectionstart');
					_pointE = _dap.attr('data-connectionend');
					 jQuery('rect[data-point="'+_pointS+'"],rect[data-point="'+_pointE+'"]').attr('stroke','#999').attr('fill','#ffffff').attr('stroke-width',1).css('stroke-width','1px');
				}
			}
		}
	});
}
function enableDisableConnection(o){
	_string = "";
	if(_showConnections===true){
		_showConnections = false;
		_string = "Enable Connection";
	}else {
		_showConnections = true;
		_string = "Disable Connection";
	}
	//o.text(_string);
	if(_showConnections===true){
		$('.connection').show();
		$("#btnArrow").show();
		$("input[name='rd_arrow']").removeAttr('disabled');
	} else {
		$('.connection').hide();
		$("input[name='rd_arrow']").attr('disabled','disabled');
	}
	/*removedIllustration();
	createIllustration();*/
}
function enableDisableArrow(o){
	_string = "";
	if(_showConnections===true){
		if(_showArrow===true){
			_showArrow = false;
			_string = "Enable Arrow";
		}else {
			_showArrow = true;
			_string = "Disable Arrow";
		}
		//o.text(_string);
		if(_showArrow===true){
			$('.connection').each(function(){
				_row = jQuery(this);
				_row.attr("marker-end",'url(#markerREC_'+_row.attr("data-orgstroke")+')');
			});
		} else {
			$('.connection').removeAttr("marker-end");
		}
		
		/*removedIllustration();
		createIllustration();*/
	}
}

</script>
</body>
</html>