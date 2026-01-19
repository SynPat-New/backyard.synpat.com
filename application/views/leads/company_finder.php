<!DOCTYPE html>
<html>
<head>
	<title>Company List</title>
	<link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script type="text/javascript" src="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.js"></script>
	<script src="https://storage.googleapis.com/static.synpat.com/backyard/js-core/jquery.clipboard.js"></script>
	<style>.w2ui-reset table tr th, .w2ui-reset table tr td,.open_list, .open_list li, .open_list li span{font-family:arial;font-size:13px;}</style>
</head>
<body>
	<div id="grid" style="width: 600px; height: 250px;"></div>
</body>
<script>
var __baseUrl = '<?php echo $Layout->baseUrl; ?>';
var records = [];
var message = "Loading....";
window.generate = function generate() {
	jQuery('#grid').w2grid({ 
		name	: 'grid', 
		header	: 'List of Panjiva Companies',
		columnTooltip: 'top',
		show	: { footer: true, toolbar: false,selectColumn: true,emptyRecords: true,expandColumn: false },
		markSearch:true,
		multiSelect:false,
		multiSort:true,
		recid:'id',
		columns: [				
			{ field: 'name', text: 'Name', size: '300px'},
			{ field: 'company_name', text: 'SynPat', size: '250px',
				editable:{type:'combo',url:'https://backyard.synpat.com/opportunity/search_company_with_other_on_fly',filter: true}
			}
		],
		records: records,
		onClick: function(event) {
		},
		onDblClick: function(event) {
		},
		onColumnClick: function(event) {		
		},
		onRender: function(event){
		},
		onExpand: function (event) {
		},
		onChange: function(event){
		},
		onSelect:function(event){
		},
		onClick: function(event) {
			if(event.column !== null) {
				console.log("Event1",event);
				console.log(event.recid);
				setTimeout(function(){w2ui.grid.unselect(parseInt(event.recid));},1000);
				if(event.column == 0){
					var getRecord = w2ui.grid.get(parseInt(event.recid));
					var name = getRecord.name;
					if(name != ""){
						clipboardClick(name);
					}					
				}
				/*Check other cases open*/
				var getRecords = w2ui.grid.records;
				if(getRecords.length > 0){
					var updateFound = false;
					getRecords.map(function(r,i){
						if(parseInt(r.recid) != parseInt(event.recid)){
							if(typeof r.w2ui != "undefined" && typeof r.w2ui.changes != "undefined"){
								if(r.w2ui.changes.company_name != ""){
									updateFound = true;
									getRecords[i].company_name = "";
									getRecords[i].w2ui.changes.company_name = "";
								}
							}
						}
					});
					if(updateFound === true){
						records = getRecords;
						w2ui.grid.refresh();
					}
				}
			} else {
				console.log("Event 2",event);
				setTimeout(function(){
					var getSelectedItems = w2ui.grid.getSelection();
					if(getSelectedItems.length == 1){
						var getRecords = w2ui.grid.records;
						getRecords.map(function(r){
							if(parseInt(r.recid) == parseInt(getSelectedItems[0])){
								if(typeof r.w2ui != "undefined" && typeof r.w2ui.changes != "undefined"){
									var companyName = r.w2ui.changes.company_name;
									if(companyName != ""){
										var applicantName = r.name;
										var htsCode = r.hts_code;
										var companyObject = {companyID:0,applicantID:r.recid,other:applicantName,owler:'',linkedin:'',company_name:companyName,hts_code:r.hts_code};
										updateCompanyOtherData(companyObject);
									}	
								}
								return false;
							}					
						})
					}
				},300);
			}
		}
	});
	w2ui.grid.buffered = records.length;
	w2ui.grid.total = w2ui.grid.buffered;
	w2ui.grid.resize();
}
jQuery(document).ready(function() {
	generate(); 
	loadTableWithNewData();	
});
function resizeGrid(){
	jQuery("#grid").css("height",(jQuery(window).height() - 40)+'px');
}
function clipboardClick(copyText) {
	var tempInput = document.createElement("input");
		tempInput.style = "position: absolute; left: -1000px; top: -1000px";
		tempInput.value = copyText;
		document.body.appendChild(tempInput);
		tempInput.select();
		document.execCommand("copy");
		document.body.removeChild(tempInput);
}
function loadTableWithNewData() {
	message = "Loading...";
	setTimeout(function(){
		if(w2ui.hasOwnProperty('grid')){
			w2ui.grid.status(message);
		}
	},500);
	jQuery.ajax({
		url:__baseUrl+'leads/get_all_panjiva_companies',
		type:'GET',
		dataType:'json',
	}).done(function(d){
		if(w2ui.hasOwnProperty('grid')){
		  w2ui['grid'].destroy();
		}
		resizeGrid();
		records = d;
		message = "";
		generate();
	});
}
function updateCompanyOtherData(companyObject){
	jQuery.ajax({
		url: __baseUrl+"opportunity/update_company_with_other_panjiva",
		type:'POST',
		data:companyObject,
		dataType: "json",
	}).done(function(d){
		console.log(d);
		if(d.company > 0 && d.company_id > 0){
			w2ui.grid.select(parseInt(companyObject.applicantID));
			w2ui.grid.delete(true);
			window.parent.checkCompanyRequest(d.company_id,1,1);
		}		
	});
}
</script>
</html>