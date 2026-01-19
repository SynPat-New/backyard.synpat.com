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
.show{display:inline-block !important;}
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
			<button id="btnUspto" class="btn btn-primary" type="button" style="margin-left:5px;">USPTO</button>
			<span id="btnList" style='display:none;'>
				<button onclick="getAllAssignment()" id="btnAssignments" class="btn btn-primary"  type="button">Assignments</button>
				<button onclick="getAllNames()" id="btnEntries" class="btn btn-primary" type="button">Entities</button>
				<button onclick="rebuildIllustration()" id="btnRebuild" class="btn btn-primary" type="button">Render</button>
				<button onclick="getResetAll()" id="btnReset" class="btn btn-primary" type="button">Reset</button>
				<button id="btnExport" class="btn btn-primary" type="button">Export Url</button>
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
var assignmentTypeList = [], all_boxes = [];
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
	jQuery(document).keypress(function(event){
		var keycode = (event.keyCode ? event.keyCode : event.which);
		if(keycode == '13'){
			if(jQuery("#txt_patent_number").val() != ""){
				createIllustration(jQuery("#txt_patent_number").val());
			}
		}
	});
	jQuery("#btnUspto").off('click').on('click',function(){
		patentNumber = removeCountryKindCode(jQuery("#txt_patent_number").val());
		if(patentNumber != "") {
			window.open('https://assignment.uspto.gov/patent/index.html#/patent/search/resultAbstract?id='+patentNumber+'&type=patNum','_blank');
		}		
	});
});
</script>
</body>
</html>