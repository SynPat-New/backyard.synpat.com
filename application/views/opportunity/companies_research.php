<?php 
if(count($list) > 0){
?>
<link href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="https://storage.googleapis.com/static.synpat.com/store/js/jquery-1.10.2.min.js"></script>
<style>
body {
	overflow: auto !important;overflow-x:hidden !important;
	min-width: 0;
	width: 100% !important;font-size:13px;font-family:arial;margin:0px;
}
.handsontable .htCheckboxRendererInput{margin:5px 3px 3px 4px;}
.handsontable .htDimmed,.handsontable td, .handsontable th{color:#2d2d2d !important;}
.handsontable td{font-size:14px;}
#container{overflow:auto;width:100%;}
</style>
<div id="container"><div id='researcher_table' class="hot handsontable htRowHeaders htColumnHeaders" ></div></div>
<script>
var __baseUrl ='<?php echo $Layout->baseUrl?>';
var _licenseKey = '139eb-e1f6b-37930-9440d-a1020';
var hot2,_confirmedRequestJSON = JSON.parse('<?php echo json_encode($list);?>');
researcher_table = document.getElementById('researcher_table');
_width = jQuery(window).width();
_width = _width-30;
mainHeight = jQuery(window).height();
mainHeight -=10;
hot2 = new Handsontable(researcher_table, {
	data: _confirmedRequestJSON,
	licenseKey:_licenseKey,
	rowHeaders: true,
	wordWrap:true,
	autoRowSize: true,
	preventOverflow: 'horizontal',
	minSpareRows: 0,
	minSpareCols: 0,
	minCols: 10,
	maxCols: 10,
	maxRows: _confirmedRequestJSON.length,
	fillHandle: false,
	height:function(){return mainHeight;},
	stretchH:"all",
	colHeaders:['Company','Person 1 - 1st Name','Person 1 - Last Name', 'Person 1 - Linkedin url','Person 2 - 1st Name','Person 2 - Last Name', 'Person 2 - Linkedin url','Person 3 - 1st Name','Person 3 - Last Name', 'Person 3 - Linkedin url'],
	contextMenu: false,
	filters: false,
	columnSorting:true,
	columns:[
		{data:'company_name',readOnly: true},
		{data:'person_1_firstname'},
		{data:'person_1_lastname'},
		{data:'person_1_linkedin'},
		{data:'person_2_firstname'},
		{data:'person_2_lastname'},
		{data:'person_2_linkedin'},
		{data:'person_3_firstname'},
		{data:'person_3_lastname'},
		{data:'person_3_linkedin'},
	],
	afterChange: function(changes, source) {
		if(source=="edit" || source=="CopyPaste.paste"){
			console.log(changes);
			if(changes[0][2] != changes[0][3]){
				var logicalIndex = hot2.toPhysicalRow(changes[0][0]);
				var _row = hot2.getSourceDataAtRow(changes[0][0]);
				updateRow(_row);
			}
		}			
	}
});
function updateRow(row){
	jQuery.ajax({
		url:__baseUrl+"opportunity/update_researcher_row/",
		type:'POST',
		data:{row:row},
		dataType:'json',
		cache:false
	}).done(function(d){
	});
}
</script>
<?php	
} else {
?>
<p>No list found.</p>
<?php
}
?>