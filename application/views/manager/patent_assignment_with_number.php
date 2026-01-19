<!DOCTYPE html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/style_new_without_compress.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $Layout->baseUrl; ?>public/illustrator.css"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo $Layout->baseUrl; ?>public/tiff.min.js"></script>
<script src="<?php echo $Layout->baseUrl; ?>public/jquery.tablesorter.min.js"></script>
<script src="<?php echo $Layout->baseUrl; ?>public/illustrator.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" ></script>
<!--<script src="//backyard.synpat.com/public/dragscroll.js" ></script>-->
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
.search-form-help-text{position:absolute;width:320px;padding:10px;border:1px solid #e4e4e4;z-index:999999;background:#f8f9fa;top:27px;/*box-shadow:0 0 10px 6px rgba(0,0,0,.1);*/border-radius:2px;right:0;}.search-form-help-text dl,.search-form-help-text p,.search-form-help-text p a{font-size:15px}
input{border:1px solid #dfe8f1 !important}
body{overflow:auto !important;}

</style>
<body>
<script src="//d3js.org/d3.v4.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<?php 
			if($show === true):
		?>
		<div class="form-group" style="position:relative;">
			<input type="text" name="txt_patent_number" id="txt_patent_number" placeholder="Patent Number" class="form-control pull-left" style="width:120px;padding:5px;"/>
			<a href="javascript://" id="btnAllLeadSearchFromPanel" onclick="findPatentAssignments()" style="position: absolute;left:100px;top:9px;"><i class="glyph-icon icon-search"></i></a>			
			<span id="btnList" style='display:none;'>
				<button id="btnUspto" class="btn btn-primary" type="button">USPTO</button>
				<button onclick="getAllAssignment()" id="btnAssignments" class="btn btn-primary"  type="button">Assignments</button>
				<button onclick="getAllNames()" id="btnEntries" class="btn btn-primary" type="button">Entities</button>
				<button onclick="rebuildIllustration()" id="btnRebuild" class="btn btn-primary" type="button">Render</button>
				<button onclick="getResetAll()" id="btnReset" class="btn btn-primary" type="button">Reset</button>
				<button id="btnExport" class="btn btn-primary" type="button">Export Url</button>
				<button onclick="getAllAssignmentTypes()" id="btnAssignmentsTypes" class="btn btn-primary"  type="button">Assignments Types</button>
			</span>
			<span id="log_message" style="width:100px;margin-left:5px;padding-top:9px;"></span>
		</div>
		<?php endif;?>
	</div>
</div>
<div class="row">
	<div class="col-xs-12" style="margin-top:10px;">
		<div id="container"></div>
	</div>
</div>
<script>
patent_number = '<?php echo $patent_number;?>';

jQuery(document).ready(function(){
	if(patent_number != "") {
		if(jQuery("#txt_patent_number").length > 0){
			jQuery("#txt_patent_number").val(patent_number);
		}
		if(jQuery("#log_message").length > 0) {
			jQuery("#log_message").html("Loading...");
		}		
		createIllustration(patent_number);
	}
});
function getAllAssignmentTypes(){
	if($('body').find('#show_table').length > 0 ){
		$('body').find('#show_table').remove();
	} else {
		jQuery.ajax({
			type:'GET',
			url:'<?php echo $Layout->baseUrl; ?>leads/get_all_assignment_types',
			cache:false,
			dataType:'json'
		}).done(function(d){
			var table = "<div class='row'><div clas='col-lg-12'><button class='btn btn-primary' onclick='addNewAssignment()'>Add</button></div></div><table class='table table_assignment_types'><thead><tr><td>Name</td><td>Color</td><td>Line Type</td></tr></thead><tbody>";
			if(d.length > 0){
				d.map(function(a){
					_selectedDashed = (a.line_type==1)?'SELECTED="SELECTED"':'';				
					_selectedSolid = (a.line_type==0)?'SELECTED="SELECTED"':'';				
					table +="<tr data-id='"+a.id+"'><td><input type='text' name='asignment_name' value='"+a.name+"'/></td><td><input type='text' name='assignment_color' value='"+a.color+"'></td><td><select name='assignment_line_type'><option value='0' "+_selectedSolid+">Solid</option><option value='1' "+_selectedDashed+">Dashed</option></select></td></tr>";
				});
				var offset = jQuery("#btnAssignmentsTypes").offset();
				var position = jQuery("#btnAssignmentsTypes").position();
				_b=0,_r=0;
				var windowWidth = jQuery(window).width();
				var popWidth = 750;
				_t = position.top + 45;
				_t = 0;
				/*_l = windowWidth - popWidth; */
				_l = 0;
				$('.search-form-help-text').remove();
				$('#container').append('<div id="show_table" class="loading search-form-help-text" style="top:'+_t+'px;left:'+_l+'px;right:'+_r+'px;bottom:'+_b+'px;width:'+popWidth+'px;height:'+_toolTipHeight+'px;overflow:hidden;overflow-y:auto;background:#fff;"></div>');
				$("#show_table").append(table);
				callAssignmentTypeChange();
				setTimeout(function(){$("#show_table").removeClass('loading');},300);
			}
			table +="</tbody></table>";
		})
	}
}
function addNewAssignment(){
	if(jQuery(".table_assignment_types").find('tr[data-id="0"]').length == 0){
		var tr ="<tr data-id='0'><td><input type='text' name='asignment_name' value=''/></td><td><input type='text' name='assignment_color' value=''></td><td><select name='assignment_line_type'><option value='0'>Solid</option><option value='1'>Dashed</option></select></td></tr>";
		jQuery('.table_assignment_types').find('tbody').append(tr);
		callAssignmentTypeChange();
	}
}
function callAssignmentTypeChange(){
	jQuery(".table_assignment_types").find("input").off('keyup').on('keyup',function(){
		updateAssignmentType(jQuery(this));
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
		_ajaxRequest = jQuery.ajax({
			type:'POST',
			url:'<?php echo $Layout->baseUrl; ?>leads/update_assignment_types',
			data:object,
			cache:false,
			dataType:'json'
		}).done(function(d){
			if(d.id > 0) {
				var ID = parseInt($parentTR.attr('data-id'));
				if(ID == parseInt(d.id)){
					/*update*/
				} else if(ID == 0){
					$parentTR.attr('data-id',d.id);
				}
			}
		});
	} else {
		setTimeout(function(){updateAssignmentType($this)},500);
	}
}
</script>
</body>
</html>