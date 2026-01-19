<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/style_new_without_compress.css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://storage.googleapis.com/static.synpat.com/backyard/widgets/typing/typing.min.js"></script>
<style>
input,select{padding:5px;border:1px solid #dfe8f1 !important;border-radius:0px;}
</style>
<div class="row">
	<div class="col-lg-12">
		<button class='btn btn-primary' onclick='addNewAssignment()'>Add</button>
		<div style="width:500px">
			<table class="table table_assignment_types">
				<thead>
					<tr>
						<td style="width:180px;">Name</td>
						<td style="width:75px;">Color</td>
						<td style="width:100px;">Line Type</td>
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
								<td style="width:180px;"><input type='text' name='asignment_name' value='<?php echo $assignment->name;?>'/></td>
								<td style="width:75px;"><input type='text' name='assignment_color' value='<?php echo $assignment->color;?>'></td>
								<td style="width:100px;"><select name='assignment_line_type'><option value='0' <?php echo $_selectedSolid;?>>Solid</option><option value='1' <?php echo $_selectedDashed;?>>Dashed</option></select><a href='javascript://' onclick='deleteAssignmentType(jQuery(this));' style='margin-left:5px'><i class='fa fa-trash'></i></a></td>
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
jQuery(document).ready(function(){
	callAssignmentTypeChange();
});
function addNewAssignment(){
	if(jQuery(".table_assignment_types").find('tr[data-id="0"]').length == 0){
		var tr ="<tr data-id='0'><td style='width:180px;'><input type='text' name='asignment_name' value=''/></td><td style='width:75px;'><input type='text' name='assignment_color' value=''></td><td style='width:100px;'><select name='assignment_line_type'><option value='0'>Solid</option><option value='1'>Dashed</option></select><a href='javascript://' onclick='deleteAssignmentType(jQuery(this));' style='margin-left:5px'><i class='fa fa-trash'></i></a></td></tr>";
		jQuery('.table_assignment_types').find('tbody').append(tr);
		callAssignmentTypeChange();
	}
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
	jQuery(".table_assignment_types").find("select").off('change').on('change',function(){
		updateAssignmentType(jQuery(this));
	});
}
var _ajaxRequest;
function updateAssignmentType($this){
	var $parentTR = $this.parents('tr');
	var object = {id:$parentTR.attr('data-id'),name:$parentTR.find('input[name="asignment_name"]').val(),color:$parentTR.find('input[name="assignment_color"]').val(),line_type:$parentTR.find('select[name="assignment_line_type"]').val()};
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
					} else if(ID == 0){
						$parentTR.attr('data-id',d.id);
					}
				}
			});
		},100);
	} else {
		setTimeout(function(){updateAssignmentType($this)},500);
	}
}

function deleteAssignmentType(o) {
	var $parentTR = o.parents('tr');
	if($parentTR.attr('data-id') > 0) {
		jQuery.ajax({
			type:'POST',
			url:'<?php echo $Layout->baseUrl; ?>general/delete_assignment_types',
			data:{id:$parentTR.attr('data-id')},
			cache:false,
		}).done(function(d){
			if(d > 0) {
				$parentTR.remove();
			} else {
				alert("Unable to delete.");
			}
		});
	} else {
		$parentTR.remove();
	}
}
</script>