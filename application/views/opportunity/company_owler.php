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
	<div id="grid" style="width: 650px; height: 250px;"></div>
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
			{ field: 'logo', text: 'Logo', size: '50px',
				render: function(record){
					if(record.company_logo != ''){
						return  '<a href="javascript://" onclick="window.parent.openCompanyEdit('+record.id+')"><img src="'+record.company_logo+'" style="height:24px;"/></a>';
					} else {
						return '';
					}					
				}},
			{ field: 'company_name', text: 'Name', size: '300px'},
			{ field: 'owler_url', text: 'Owler', size: '250px',
				editable:{type:'text'}
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
				if(event.column == 1){
					var getRecords = w2ui.grid.records;
					getRecords.map(function(r){
						if(parseInt(r.id) == parseInt(event.recid)){
							var companyName = r.company_name;
							clipboardClick(companyName);
						}
					});
				}
				
			} else {
				console.log("Event 2",event);
				setTimeout(function(){
					var getSelectedItems = w2ui.grid.getSelection();
					if(getSelectedItems.length == 1){
						var getRecords = w2ui.grid.records;
						getRecords.map(function(r){
							if(parseInt(r.id) == parseInt(getSelectedItems[0])){
								var owlerUrl = r.w2ui.changes.owler_url;
								if(owlerUrl != ""){
									var companyObject = {companyID:r.id,owler_url:owlerUrl};
									updateWithOwlerUrl(companyObject);
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
function loadTableWithNewData(){
	message = "Loading...";
	setTimeout(function(){
		if(w2ui.hasOwnProperty('grid')){
			w2ui.grid.status(message);
		}
	},500);
	jQuery.ajax({
		url:__baseUrl+'opportunity/get_all_company_owler',
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
function updateWithOwlerUrl(companyObject,$parent){
	jQuery.ajax({
		url: __baseUrl+"opportunity/update_company_owler",
		type:'POST',
		data:companyObject,
		dataType: "json",
	}).done(function(d){
		if(d.update > 0){
			w2ui.grid.select(parseInt(companyObject.companyID));
			w2ui.grid.delete(true);
			window.parent.checkCompanyRequest(companyObject.companyID,1,1);
		}
	});
}
</script>
</body>
</html>