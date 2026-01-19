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
	<div id="grid" style="width: 100%; height: 250px;"></div>
</body>
<script>
var __baseUrl = '<?php echo $Layout->baseUrl; ?>';
var lead_id = '<?php echo $lead_id?>';
var records = [];
var message = "Loading....";
window.generate = function generate() {
	jQuery('#grid').w2grid({ 
		name	: 'grid', 
		header	: 'List of Citing Companies',
		columnTooltip: 'top',
		show	: { footer: true, toolbar: false,selectColumn: true,emptyRecords: true,expandColumn: false },
		markSearch:true,
		multiSelect:false,
		multiSort:true,
		recid:'id',
		columns: [				
			{ field: 'applicant', text: 'Name', size: '300px',sortable: true},
			{ field: 'company_name', text: 'SynPat', 
				editable:{type:'combo',url:'https://backyard.synpat.com/opportunity/search_company_with_other_on_fly',filter: true}
			},
			{ field: 'owler_url', text: 'Owler',editable:{type:'text'}},
			{ field: 'linkedin_url', text: 'Linkedin',editable:{type:'text'}}
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
				setTimeout(function(){w2ui.grid.unselect(parseInt(event.recid));},500);
				if(event.column == 0){
					var getRecords = w2ui.grid.records;
					getRecords.map(function(r){
						if(parseInt(r.id) == parseInt(event.recid)){
							var companyName = r.applicant;
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
							if(parseInt(r.recid) == parseInt(getSelectedItems[0])){
								var applicantID = r.id;
								if(typeof typeof r.w2ui.changes != "undefined"){
									if(typeof r.w2ui.changes.company_name != "undefined"){
										var companyName = r.w2ui.changes.company_name;
										var companyObject = {company_name:companyName,applicantID:applicantID,other:r.applicant,owler:'',linkedin:''};
										updateCompanyOtherData(companyObject);
									} else if(typeof r.w2ui.changes.owler_url != "undefined"){
										var owlerUrl = r.w2ui.changes.owler_url;
										if(owlerUrl.indexOf('owler') >0){
											var owlerUrl = r.w2ui.changes.owler_url;
											var companyObject = {company_name:'',companyID:0,applicantID:applicantID,other:r.applicant,linkedin:'',owler_url:owlerUrl};
											updateWithOwlerUrl(companyObject);
										}
									} else if(typeof r.w2ui.changes.linkedin_url != "undefined"){
										var linkedinUrl = r.w2ui.changes.linkedin_url;
										if(linkedinUrl.indexOf('linkedin') >0){
											var linkedinUrl = r.w2ui.changes.linkedin_url;
											var companyObject = {company_name:'',companyID:0,applicantID:applicantID,other:r.applicant,linkedin:linkedinUrl,owler_url:''};
											updateWithLinkedin(companyObject);
										}
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
	console.log("Asdasd");
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
		url:__baseUrl+'leads/get_all_citing_companies/'+lead_id,
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
function updateWithOwlerUrl(companyObject){
	jQuery.ajax({
		url: __baseUrl+"opportunity/update_with_owler",
		type:'POST',
		data:companyObject,
		dataType: "json",
	}).done(function(d){
		if(d.company_id > 0){
			w2ui.grid.select(parseInt(companyObject.applicantID));
			w2ui.grid.delete(true);
			window.parent.checkCompanyRequest(d.company_id,1,1);
		}
	});
}
function updateCompanyOtherData(companyObject){
	jQuery.ajax({
		url: __baseUrl+"opportunity/update_company_with_other",
		type:'POST',
		data:companyObject,
		dataType: "json",
	}).done(function(d){
		if(d.company_id > 0){
			w2ui.grid.select(parseInt(companyObject.applicantID));
			w2ui.grid.delete(true);
			if(d.company > 0){
				window.parent.checkCompanyRequest(d.company_id,1,1);
			}
		}		
	});
}
function updateWithLinkedin(companyObject){
	jQuery.ajax({
		url: __baseUrl+"opportunity/update_with_linkedin",
		type:'POST',
		data:companyObject,
		dataType: "json",
	}).done(function(d){
		if(d.company_id > 0){
			w2ui.grid.select(parseInt(d.applicant_id));
			w2ui.grid.delete(true);
			if(d.update_linked == 0){
				window.parent.checkCompanyRequest(d.company_id,1,1);
				scrapeCompanyWithLinkedIn(d.company_id);
			}
		}
	});
}
function scrapeCompanyWithLinkedIn(companyID){
	let iDS = [];
	iDS.push(companyID);
	jQuery.ajax({
		url:__baseUrl+'opportunity/findAllCompaniesLinkedin',
		type:'POST',
		data:{c:JSON.stringify(iDS),t:33},
		dataType:'json',
		success:function(d){
			if(d.length>0){
				checkRunningStage();
			}
		}
	});
}
function checkRunningStage(){
	jQuery.ajax({
		url:__baseUrl+'opportunity/check_running_stage/0',
		type:'get',
		dataType:'json',
		success:function(d){
			if(d.d == 0){
				window.parent.sendCompanyScrapperRequest();
			} else {
				window.parent.checkQueue();
			}
		}
	})
}
</script>
</body>
</html>