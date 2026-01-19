<script src="https://storage.googleapis.com/static.synpat.com/store/js/jquery-1.10.2.min.js"></script>
<a href="javascript://" onclick="addUpdateList()">Add / Update list</a>
<a href="javascript://" onclick="openResearcherPage()" style='margin-left:10px;'>Researcher Standalone url</a>
<?php 
$peopleList = array();
if(count($list) > 0){
	$counter = 0;
	foreach($list as $company){
		
		$approveID = $company->person_1_id;
		if($approveID == 0){
			$people = array('lead_id'=>$company->lead_id,'company_id'=>$company->company_id,'company_name'=>$company->company_name,'t'=>1,'first_name'=>$company->person_1_firstname,'last_name'=>$company->person_1_lastname,'url'=>$company->person_1_linkedin,'approve'=>$company->person_1_approve,'id'=>$company->id);
			array_push($peopleList,$people);
		}
		
		$approveID = $company->person_2_id;
		if($approveID == 0){
			$people = array('lead_id'=>$company->lead_id,'company_id'=>$company->company_id,'company_name'=>$company->company_name,'t'=>2,'first_name'=>$company->person_2_firstname,'last_name'=>$company->person_2_lastname,'url'=>$company->person_2_linkedin,'approve'=>$company->person_2_approve,'id'=>$company->id);
			array_push($peopleList,$people);
		}
		$approveID = $company->person_3_id;
		if($approveID == 0){
			$people = array('lead_id'=>$company->lead_id,'company_id'=>$company->company_id,'company_name'=>$company->company_name,'t'=>3,'first_name'=>$company->person_3_firstname,'last_name'=>$company->person_3_lastname,'url'=>$company->person_3_linkedin,'approve'=>$company->person_3_approve,'id'=>$company->id);
			array_push($peopleList,$people);
		}
	}
?>
<link href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
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
var _licenseKey = '139eb-e1f6b-37930-9440d-a1020';
var hot2,_confirmedRequestJSON = JSON.parse('<?php echo json_encode($peopleList);?>');
researcher_table = document.getElementById('researcher_table');
_width = jQuery(window).width();
_width = _width-30;
mainHeight = jQuery(window).height();
mainHeight -=20;
hot2 = new Handsontable(researcher_table, {
	data: _confirmedRequestJSON,
	licenseKey:_licenseKey,
	rowHeaders: true,
	wordWrap:true,
	autoRowSize: true,
	preventOverflow: 'horizontal',
	minSpareRows: 0,
	minSpareCols: 0,
	minCols: 5,
	maxCols: 5,
	height:function(){return mainHeight;},
	maxRows: _confirmedRequestJSON.length,
	fillHandle: false,
	stretchH:"all",
	colHeaders:['Company','1st Name','Last Name', 'Linkedin url','Approve'],
	contextMenu: false,
	filters: false,
	columnSorting:true,
	columns:[
		{data:'company_name',readOnly: true},
		{data:'first_name',readOnly: true},
		{data:'last_name',readOnly: true},
		{data:'url',readOnly: true},
		{data:'approve',readOnly: true,renderer: function(instance, TD, row, col, prop, value, cellProperties) {
			var innerHTML = '';
			if(value == '0'){
				var currentID = instance.getDataAtRowProp(row,'id');
				var url = instance.getDataAtRowProp(row,'url');
				var type = instance.getDataAtRowProp(row,'t');
				var innerHTML = "";
				if(url != ""){
					innerHTML ="<a href='javascript://'  onclick='leaveMe("+currentID+","+type+")'>Leave</a><a style='margin-left:5px;'  href='javascript://' onclick='approveMe("+currentID+","+type+")'>Approve</a>";
				}	
				return TD.innerHTML = innerHTML;
			}
		}},
	],
	afterChange: function(changes, source) {
	}
});
function leaveMe(ID,t){
	jQuery.ajax({
		url:__baseUrl+"opportunity/delete_researcher_row",
		type:'POST',
		data:{row:ID,t:t},
		dataType:'json',
		cache:false
	}).done(function(d){
		if(d.update > 0){
			_confirmedRequestJSON.map(function(c,i){
				if(c.id == ID){
					_confirmedRequestJSON[i].first_name = '';
					_confirmedRequestJSON[i].last_name = '';
					_confirmedRequestJSON[i].url = '';
					_confirmedRequestJSON[i].approve = 0;
					return false;
				}
			});			
			hot2.loadData(_confirmedRequestJSON);
		}
	})
}
function approveMe(ID,t){
	jQuery.ajax({
		url:__baseUrl+"opportunity/approve_researcher_row",
		type:'POST',
		data:{row:ID,t:t},
		dataType:'json',
		cache:false
	}).done(function(d){
		if(d.update > 0){
			_confirmedRequestJSON.map(function(c,i){
				if(c.id == ID){
					_confirmedRequestJSON.splice(i);
					return false;
				}
			});
			hot2.loadData(_confirmedRequestJSON);
		}
	})
}
</script>
<?php	
} else {
?>
<p>No list found.</p>
<?php
}
?>
<script>
var __baseUrl ='<?php echo $Layout->baseUrl?>';
var leadID = '<?php echo $lead_id?>';
function addUpdateList(){
	if(leadID > 0){
		jQuery.ajax({
			url:__baseUrl+"opportunity/add_update_researcher_companies/"+leadID,
			dataType:'json',
			cache:false
		}).done(function(d){
			console.log(d);
			window.location = window.location.href;
		});
	} else {
		alert("Please select lead first.");
	}
}
function openResearcherPage(){
	window.open("https://backyard.synpat.com/opportunity/companies_research/"+leadID);
}
</script>