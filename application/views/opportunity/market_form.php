<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn?>public/helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn?>public/helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn?>public/themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn?>public/elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn?>public/elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn?>public/elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn?>public/widgets/multi-select/multiselect.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>public/js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>public/js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>public/js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>public/js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>public/js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>public/widgets/slimscroll/slimscroll.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>public/widgets/multi-select/multiselect.js"></script>
<style>
body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;
	}
	#page-content {
	    background: #ffffff !important;
	}
	.mrg5T{margin-top:5px;}
</style>
<div class="row mrg10T" style='width:600px;'>
	<label class="col-sm-12 control-label">Markets:</label>
	<div class="col-sm-12 mrg5T" style="padding-right:11px;">
		<?php 
			$marketData = array();
			if(count($lead_data)>0){
				$marketData = explode(',',$lead_data->market_data);
			}
		?>
		<select multiple  class="multi-select" id="marSector" name="mar[sector][]" onchange="findSelectedData(jQuery(this));">
			<?php 
				$market_sectors = getAllCategories();
				if(count($market_sectors)>0){
					foreach($market_sectors as $sector){
						$selected="";
						if(in_array($sector->name,$marketData)){
							$selected="SELECTED='SELECTED'";
						}
			?>
						<option <?php echo $selected;?> value="<?php echo $sector->name;?>"><?php echo $sector->name;?></option>
			<?php
					}
				}
			?>
		</select>                                
	</div>
</div>
<script>
_t='<?php echo $t?>';
jQuery(document).ready(function(){
	jQuery(".multi-select").multiSelect();
	jQuery(".ms-container").append('<i class="glyph-icon icon-exchange"></i>');
});
function findSelectedData(object){
	if(_t=='from_regular'){
		window.parent.jQuery("#"+_t).find("#marketBoxList").empty();
		window.parent.jQuery("#"+_t).find("#marketBoxList").append("<ul class='todo-box-1'></ul>");
		_mainVal = "";
		object.find("option").each(function(index){
			if(jQuery(this).is(':selected')){
				window.parent.jQuery("#"+_t).find("#marketBoxList").find("ul.todo-box-1").append("<li>"+jQuery(this).attr('value')+"</li>");
				_mainVal += jQuery(this).attr('value')+",";
			}
		});
		if(_mainVal!=""){
			_mainVal.substring(0,_mainVal.length-1);
		}
		window.parent.jQuery("#"+_t).find("#marketMarketData").val(_mainVal);
		window.parent.callRunLeadSave();
	} else if(_t=='from_nonacquistion'){
		window.parent.jQuery("#"+_t).find("#acquisitionBoxList").empty();
		window.parent.jQuery("#"+_t).find("#acquisitionBoxList").append("<ul class='todo-box-1'></ul>");
		_mainVal = "";
		object.find("option").each(function(index){
			if(jQuery(this).is(':selected')){
				window.parent.jQuery("#"+_t).find("#acquisitionBoxList").find("ul.todo-box-1").append("<li>"+jQuery(this).attr('value')+"</li>");
				_mainVal += jQuery(this).attr('value')+",";
			}
		});
		if(_mainVal!=""){
			_mainVal.substring(0,_mainVal.length-1);
		}
		window.parent.jQuery("#"+_t).find("#acquisitionMarketData").val(_mainVal);
		window.parent.callRunLeadSave();
	}
	
}
</script>