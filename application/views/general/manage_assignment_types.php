<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/style_new_without_compress.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://storage.googleapis.com/static.synpat.com/backyard/widgets/typing/typing.min.js"></script>
<style>
input,select,textarea{padding:5px;border:1px solid #dfe8f1 !important;border-radius:0px;}
input,textarea{width:100%;}
body{overflow:auto !important;}
</style>
<?php 
function getTypeOption($original,$list){
	$selected = "";
	$option = "<option value=''></option>";
	if(count($list) > 0){
		foreach($list as $assignment){
			$selected = "";
			if($assignment->id == $original){
				$selected = "SELECTED='SELECTED'";
			}
			$option .= "<option value='".$assignment->id."' ".$selected.">".$assignment->name."</option>";
		}
	}	
	return $option;
}
function getBoxOption($original,$boxes){
	$selected = "";
	$option = "<option value=''></option>";
	if(count($boxes) > 0){
		foreach($boxes as $box){
			$selected = "";
			if($box->id == $original){
				$selected = "SELECTED='SELECTED'";
			}
			$option .= "<option value='".$box->id."' ".$selected.">".$box->type."</option>";
		}
	}	
	return $option;
}
?>
<div class="row">
	<div class="col-xs-12" style="width:1800px;">
		<div class="pull-left" style="width:620px">
			<button class='btn btn-primary mrg10B' onclick='addNewAssignment()'>Add</button>
			<h3>Lines</h3>
			<table class="table table_assignment_types">
				<thead>
					<tr>
						<th style="width:130px;">Tooltips</th>
						<th style="width:65px;">Color</th>
						<th style="width:40px;">Line Type</th>
						<th style="width:270px;">Explanation</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if(count($list) > 0){
							foreach($list as $assignment){
								$_selectedDashed = ($assignment->line_type==1)?'SELECTED="SELECTED"':'';
								$_selectedSolid = ($assignment->line_type==0)?'SELECTED="SELECTED"':'';		
					?>
							<tr data-id='<?php echo $assignment->id?>'>
								<td style="width:130px;"><input type='text' name='assignment_name' value='<?php echo $assignment->name;?>'/></td>
								<td style="width:65px;"><input type='text' name='assignment_color' value='<?php echo $assignment->color;?>'></td>
								<td style="width:40px;"><select name='assignment_line_type'><option value='0' <?php echo $_selectedSolid;?>>Solid</option><option value='1' <?php echo $_selectedDashed;?>>Dashed</option></select></td>
								<td style="width:270px;"><textarea name="assignment_explanation" style="width:265px;"><?php echo $assignment->explanation;?></textarea><a href='javascript://' onclick='deleteAssignmentType(jQuery(this));' style='margin-left:5px'><i class='fa fa-trash'></i></a></td>
							</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table>
			<button class='btn btn-primary mrg10B mrg10T' onclick='addBoxes()'>Add</button>
			<h3>Boxes</h3>
			<table class='table boxes'>
				<thead>
					<tr>
						<th style='width:20px;'>Segment</th>
						<th style='width:65px;'>BorderColor</th>
						<th style='width:20px;'>BorderPx</th>
						<th style='width:30px;'>Shape</th>
						<th style='width:65px;'>Bkg.Color</th>
						<th style='width:50px;'>Dimension(WxH)</th>
						<th style='width:200px;'>Type</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if(count($boxes) >0){
							foreach($boxes as $box){
					?>
						<tr data-id="<?php echo $box->id?>">
							<td style='width:20px;'><input type='text' name='segment' value='<?php echo $box->segment;?>'/></td>
							<td style='width:65px;'><input type='text' name='border_color' value='<?php echo $box->border_color;?>'/></td>
							<td style='width:20px;'><input type='text' name='border_px' value='<?php echo $box->border_px;?>'/></td>
							<td style='width:30px;'>
								<select name='shape'>
									<option value='rectangle' <?php echo ($box->shape == 'rectangle')?"SELECTED='SELECTED'":'';?>>Rectangle</option>
									<option value='circle' <?php echo ($box->shape == 'circle')?"SELECTED='SELECTED'":'';?>>Circle</option>
									<option value='ellipse' <?php echo ($box->shape == 'ellipse')?"SELECTED='SELECTED'":'';?>>Ellipse</option>
									<option value='polygon' <?php echo ($box->shape == 'polygon')?"SELECTED='SELECTED'":'';?>>Polygon</option>
								</select>
							</td>
							<td style='width:65px;'><input type='text' name='background_color' value='<?php echo $box->background_color;?>'/></td>
							<td style='width:50px;'><input type='text' name='dimension' value='<?php echo $box->dimension;?>'/></td>
							<td style='width:200px;'><input type='text' name='type' value='<?php echo $box->type;?>' style='width:97px;'/><a href='javascript://' onclick='deleteBoxes(jQuery(this));' style='margin-left:5px'><i class='fa fa-trash'></i></a></td>
						</tr>	
					<?php
							}
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="pull-left" style="width:950px;margin-left:20px;">
			<button class='btn btn-primary mrg10B' onclick='addNewFreeTextRow()'>Add</button>
			<h3>USPTO Assignments</h3>
			<table class="table free_assignment_text_types">
				<thead>
					<tr>
						<th>USPTO Heading</th>
						<th style="width:180px;">Line Tooltip</th>
						<th style="width:200px;">Box Type</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(count($free_list) > 0){
							foreach($free_list as $fl){
								$selected = "";
								$option = getTypeOption($fl->original_text,$list);
								$optionBox = getBoxOption($fl->box_type,$boxes);
					?>
						<tr data-id="<?php echo $fl->id;?>">
							<td><textarea name="free_text" class="free_text" ><?php echo $fl->free_text;?></textarea></td>
							<td style="width:180px;"><select name="original_text" class="original_text"><?php echo $option;?></select></td></td>
							<td style="width:200px;"><select style='width:150px;' name="box_type" class="original_text"><?php echo $optionBox;?></select><a href='javascript://' onclick='deleteFreeAssignmentType(jQuery(this));' style='margin-left:5px'><i class='fa fa-trash'></i></a></td>
						</tr>
					<?php
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
var typeList = [
	<?php 
		if(count($list) > 0) {
			foreach($list as $assignment){
				echo '{id:'.$assignment->id.',name:"'.$assignment->name.'"},';
			}			
		}
	?>
];

var boxesList = [
	<?php 
		if(count($boxes) > 0) {
			foreach($boxes as $box){
				echo '{id:'.$box->id.',name:"'.$box->type.'"},';
			}			
		}
	?>
];
jQuery(document).ready(function(){
	callAssignmentTypeChange();
	callFreeAssignmentTypeChange();
	callAssignmentBoxesChange();
	loadTextareaHeight();
});

function loadTextareaHeight(){
	jQuery("textarea").each(function() {
		var $this = jQuery(this);
		$this.height( $this.scrollHeight );
	});
}

function getTypeList(){
	var option = "<option value=''></option>";
	typeList.map(function(t){
		option +="<option value='"+t.id+"'>"+t.name+"</option>";
	});
	return option;
}

function getBoxList(){
	var option = "<option value=''></option>";
	boxesList.map(function(t){
		option +="<option value='"+t.id+"'>"+t.name+"</option>";
	});
	return option;
}
function addNewAssignment(){
	if(jQuery(".table_assignment_types").find('tr[data-id="0"]').length == 0){
		var tr ="<tr data-id='0'><td style='width:130px;'><input type='text' name='assignment_name' value=''/></td><td style='width:65px;'><input type='text' name='assignment_color' value=''></td><td style='width:40px;'><select name='assignment_line_type'><option value='0'>Solid</option><option value='1'>Dashed</option></select></td><td style='width:270px;'><textarea name='assignment_explanation' style='width:265px;'></textarea><a href='javascript://' onclick='deleteAssignmentType(jQuery(this));' style='margin-left:5px'><i class='fa fa-trash'></i></a></td></tr>";
		jQuery('.table_assignment_types').find('tbody').append(tr);
		callAssignmentTypeChange();
	}
}

function addBoxes(){
	if(jQuery(".boxes").find('tr[data-id="0"]').length == 0){
		var tr ="<tr data-id='0'><td style='width:20px;'><input type='text' name='segment' value=''/></td><td style='width:65px;'><input type='text' name='border_color' value=''/></td><td style='width:20px;'><input type='text' name='border_px' value=''/></td><td style='width:30px;'><select name='shape'><option value='rectangle'>Rectangle</option><option value='circle'>Circle</option><option value='ellipse'>Ellipse</option><option value='polygon'>Polygon</option></select></td><td style='width:65px;'><input type='text' name='background_color' value=''/></td><td style='width:50px;'><input type='text' name='dimension' value=''/></td><td style='width:200px;'><input type='text' name='type' value='' style='width:97px;'/><a href='javascript://' onclick='deleteBoxes(jQuery(this));' style='margin-left:5px'><i class='fa fa-trash'></i></a></td></tr>";
		jQuery('.boxes').find('tbody').append(tr);
		callAssignmentBoxesChange();
	}
}
function addNewFreeTextRow() {
	if(jQuery(".free_assignment_text_types").find('tr[data-id="0"]').length == 0){
		var tr ="<tr data-id='0'><td><textarea name='free_text' ></textarea></td><td style='width:180px;'><select name='original_text'>"+getTypeList()+"</select></td><td style='width:200px;'><select name='box_type' style='width:150px;'>"+getBoxList()+"</select><a href='javascript://' onclick='deleteFreeAssignmentType(jQuery(this));' style='margin-left:5px'><i class='fa fa-trash'></i></a></td></tr>";
		jQuery('.free_assignment_text_types').find('tbody').append(tr);
		callFreeAssignmentTypeChange();
		loadTextareaHeight()
	}
}
function callAssignmentBoxesChange(){
	jQuery(".boxes").find("input").typing({
		delay:1000,
		start:function(){
			console.log("Type...");
		},
		stop:function(){
			$focused = $(':focus');
			updateAssignmentBoxes($focused);
		}
	});
	jQuery(".boxes").find("input").off('paste').on('paste',function(){
		var $this = jQuery(this);
		setTimeout(function(){updateAssignmentBoxes($this);},20);
		
	});
	jQuery(".boxes").find("select").off('change').on('change',function(){
		updateAssignmentBoxes(jQuery(this));
	});
}
function callAssignmentTypeChange(){
	jQuery(".table_assignment_types").find("input").typing({
		delay:1000,
		start:function(){
			console.log("Type...");
		},
		stop:function(){
			$focused = $(':focus');
			updateAssignmentType($focused);
		}
	});
	jQuery(".table_assignment_types").find("input").off('paste').on('paste',function(){
		updateAssignmentType(jQuery(this));
	});
	jQuery(".table_assignment_types").find("select").off('change').on('change',function(){
		updateAssignmentType(jQuery(this));
	});
}
function callFreeAssignmentTypeChange() {
	jQuery(".free_assignment_text_types").find("textarea").typing({
		delay:1000,
		start:function(){
			console.log("Type...");
		},
		stop:function(){
			$focused = $(':focus');
			updateFreeAssignmentType($focused);
		}
	});
	jQuery(".free_assignment_text_types").find("textarea").off('keydown').on('keydown',function(){
		loadTextareaHeight();
	});
	jQuery(".free_assignment_text_types").find("textarea").on('paste',function(){
		console.log("paste");
		loadTextareaHeight();updateFreeAssignmentType(jQuery(this));
	});
	jQuery(".free_assignment_text_types").find("select").off('change').on('change',function(){
		updateFreeAssignmentType(jQuery(this));
	});
}
var _ajaxRequest;
function updateFreeAssignmentType($this){
	var $parentTR = $this.parents('tr');
	var object = {id:$parentTR.attr('data-id'),free_text:$parentTR.find('textarea[name="free_text"]').val(),original_text:$parentTR.find('select[name="original_text"]').val(),box_type:$parentTR.find('select[name="box_type"]').val()};
	var sendRequest = false;
	if(typeof _ajaxRequest == "undefined"){
		sendRequest = true;
	} else if(typeof _ajaxRequest.readyState !="undefined" && _ajaxRequest.readyState == 4){
		sendRequest = true;
	}	
	if(sendRequest === true){
		setTimeout(function(){
			_ajaxRequest = jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl; ?>general/update_free_assignment_types',
				data:object,
				cache:false,
				dataType:'json'
			}).done(function(d){
				if(d.id > 0) {
					var ID = parseInt($parentTR.attr('data-id'));
					if(ID == parseInt(d.id)){
						/*update*/
						console.log("1");
					} else if(ID == 0){
						$parentTR.attr('data-id',d.id);
					}
				}
			});
		},100);
	} else {
		setTimeout(function(){updateFreeAssignmentType($this)},500);
	}
}
function updateAssignmentType($this){
	var $parentTR = $this.parents('tr');
	var object = {id:$parentTR.attr('data-id'),name:$parentTR.find('input[name="assignment_name"]').val(),color:$parentTR.find('input[name="assignment_color"]').val(),line_type:$parentTR.find('select[name="assignment_line_type"]').val(),segment:$parentTR.find('input[name="assignment_segment"]').val(),explanation:$parentTR.find('textarea[name="assignment_explanation"]').val()};
	var sendRequest = false;
	if(typeof _ajaxRequest == "undefined"){
		sendRequest = true;
	} else if(typeof _ajaxRequest.readyState !="undefined" && _ajaxRequest.readyState == 4){
		sendRequest = true;
	}	
	if(sendRequest === true){
		setTimeout(function(){
			_ajaxRequest = jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl; ?>general/update_assignment_types',
				data:object,
				cache:false,
				dataType:'json'
			}).done(function(d){
				if(d.id > 0) {
					var ID = parseInt($parentTR.attr('data-id'));
					if(ID == parseInt(d.id)){
						/*update*/
						console.log("1");
						typeList.map(function(t,i){
							if(t.id == d.id){
								var inputName = $parentTR.find('input[name="assignment_name"]').val();
								if(t.name != inputName){
									typeList[i].name = inputName;
									updateAllBoxes(0);
								}
							}
						});
					} else if(ID == 0){
						$parentTR.attr('data-id',d.id);
						typeList.push({id:d.id,name:$parentTR.find('input[name="assignment_name"]').val()});
						updateAllBoxes(0);
					}
				}
			});
		},100);
	} else {
		setTimeout(function(){updateAssignmentType($this)},500);
	}
}
function updateAssignmentBoxes($this){
	var $parentTR = $this.parents('tr');
	var object = {id:$parentTR.attr('data-id'),segment:$parentTR.find('input[name="segment"]').val(),border_color:$parentTR.find('input[name="border_color"]').val(),border_px:$parentTR.find('input[name="border_px"]').val(),shape:$parentTR.find('select[name="shape"]').val(),background_color:$parentTR.find('input[name="background_color"]').val(),dimension:$parentTR.find('input[name="dimension"]').val(),type:$parentTR.find('input[name="type"]').val()};
	var sendRequest = false;
	if(typeof _ajaxRequest == "undefined"){
		sendRequest = true;
	} else if(typeof _ajaxRequest.readyState !="undefined" && _ajaxRequest.readyState == 4){
		sendRequest = true;
	}	
	if(sendRequest === true){
		setTimeout(function(){
			_ajaxRequest = jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl; ?>general/update_assignment_boxes',
				data:object,
				cache:false,
				dataType:'json'
			}).done(function(d){
				if(d.id > 0) {
					var ID = parseInt($parentTR.attr('data-id'));
					if(ID == parseInt(d.id)){
						/*update*/
						console.log("1");
						boxesList.map(function(t,i){
							if(t.id == d.id){
								var inputName = $parentTR.find('input[name="type"]').val();
								if(t.name != inputName){
									boxesList[i].name = inputName;
									updateAllBoxes(1);
								}
							}
						});
					} else if(ID == 0){
						$parentTR.attr('data-id',d.id);
						boxesList.push({id:d.id,name:$parentTR.find('input[name="type"]').val()});
						updateAllBoxes(1);
					}
				}
			});
		},100);
	} else {
		setTimeout(function(){updateAssignmentType($this)},500);
	}
}

function updateAllBoxes(t){
	if(jQuery('.free_assignment_text_types').find('tbody tr').length > 0 ){
		jQuery('.free_assignment_text_types').find('tbody tr').each(function(){
			var $this = jQuery(this);
			if(t == 1){
				var boxType = $this.find("select[name='box_type']").val();
				var _option = "<option value='0'></option>";
				boxesList.map(function(b,i){
					var selected = "";
					if(boxType > 0){
						if(b.id == boxType){
							selected = 'SELECTED="SELECTED"';
						}
					}
					_option +="<option value='"+b.id+"' "+selected+">"+b.name+"</option>";
				});
				$this.find("select[name='box_type']").html(_option);
			} else if(t == 0){
				var boxType = $this.find("select[name='original_text']").val();
				var _option = "<option value='0'></option>";
				typeList.map(function(b,i){
					var selected = "";
					if(boxType > 0){
						if(b.id == boxType){
							selected = 'SELECTED="SELECTED"';
						}
					}
					_option +="<option value='"+b.id+"' "+selected+">"+b.name+"</option>";
				});
				$this.find("select[name='original_text']").html(_option);
			}		
		});
		
	}
}

function deleteFreeAssignmentType(o){
	var $parentTR = o.parents('tr');
	if($parentTR.attr('data-id') > 0) {
		jQuery.ajax({
			type:'POST',
			url:'<?php echo $Layout->baseUrl; ?>general/delete_free_assignment_types',
			data:{id:$parentTR.attr('data-id')},
			cache:false,
		}).done(function(d){if(d > 0) {
				$parentTR.remove();
			} else {
				alert("Unable to delete.");
			}
		});
	} else {
		$parentTR.remove();
	}
}

function deleteAssignmentType(o){
	var $parentTR = o.parents('tr');
	if($parentTR.attr('data-id') > 0) {
		var textType = $parentTR.find('input[name="assignment_name"]').val();
		jQuery.ajax({
			type:'POST',
			url:'<?php echo $Layout->baseUrl; ?>general/delete_assignment_types',
			data:{id:$parentTR.attr('data-id')},
			cache:false,
		}).done(function(d){
			if(d > 0) {
				$parentTR.remove();
				typeList.map(function(t,i){
					if(t.id == $parentTR.attr('data-id')){
						typeList.splice(i,1);
						return;
					}
				});
			} else {
				alert("Unable to delete.");
			}
		});
	} else {
		$parentTR.remove();
	}
}
</script>