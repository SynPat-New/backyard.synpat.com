<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css" />
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.js"></script>
<style>
	body {
		overflow: auto !important;overflow-x:hidden !important;
		min-width: 0;
		width: 100% !important;font-size:13px;font-family:arial;margin:0px;
	}
	.w2ui-reset table tr th, .w2ui-reset table tr td{font-family:arial;font-size:13px;}
	.mrg5L{margin-left:5px;}
</style>
<body>
<button class="btn btn-primary" onclick="addARecord();"><i class="fa fa-plus"></i></button><button class="btn btn-primary mrg5L" onclick="deleteRecord();"><i class="fa fa-trash"></i></button><button class="btn btn-primary mrg5L" onclick="saveRecord();"><i class="fa fa-save"></i></button> <span>Click +, double click a cell to add text, click Enter, and double click the next cell and click Enter.</span>
<div id="grid" style="width:100%;height:600px;"></div>
<script>
var __baseUrl = '<?php echo $Layout->baseUrl?>';
var records = [];
var message = "Loading....";
window.generate = function generate() {
	$('#grid').w2grid({ 
		name	: 'grid', 
		header	: 'List of Sources',
		columnTooltip: 'top',
		show	: { footer: true, toolbar: false,selectColumn: true,emptyRecords: true,expandColumn: false },
		columns: [	
			{ field: 'source', text: 'Source', sortable: true,editable:{type:'text'}},
			{ field: 'subject', text: 'Subject', sortable: true,editable:{type:'text'}},
			{ field: 'purpose', text: 'Purpose', sortable: true,editable:{type:'text'}},
			{ field: 'url', text: 'Url', sortable: true,editable:{type:'text'},
				render:function(record){
					if(record.url != "" && record.url != null && record.url != undefined){
						return "<a href='"+record.url+"' target='_BLANK'>"+record.url+"</a>";
					}
				}
			},
		],
		records: records,
		recid:'id',
		onClick: function(event) {
			if(event.column !== null) {
				console.log("Event1",event);
				console.log(event.recid);
				setTimeout(function(){w2ui.grid.unselect(parseInt(event.recid));},500);
			} else {
				console.log("Event 2",event);
			}
		},
		onChange:function(event){
			setTimeout(function(){
				var getRecords = w2ui.grid.records;
				console.log(getRecords);
				getRecords.map(function(r,i){
					if(parseInt(r.recid) == parseInt(event.recid)){
						console.log("Enter",r);
						var updateData = {source:r.source,purpose:r.purpose,url:r.url};
						console.log("Update",updateData);
						if(r.w2ui.changes.source != "" && r.w2ui.changes.source != undefined){
							updateData.source = r.w2ui.changes.source;
						}
						if(r.w2ui.changes.subject != "" && r.w2ui.changes.subject != undefined){
							updateData.subject = r.w2ui.changes.subject;
						}
						if(r.w2ui.changes.purpose != "" && r.w2ui.changes.purpose != undefined){
							updateData.purpose = r.w2ui.changes.purpose;
						}
						if(r.w2ui.changes.url != "" && r.w2ui.changes.url != "undefined"){
							updateData.url = r.w2ui.changes.url;
						}
						console.log("Update1",updateData);
						updateRecord(updateData,event.recid,i);
						return false;
					}
				});
			},1000);
		}
	});
	w2ui.grid.buffered = records.length;
	w2ui.grid.total = w2ui.grid.buffered;
	w2ui.grid.resize();	
}
jQuery(window).resize(function(){
	jQuery("#grid").css("height",(jQuery(window).height() - 75)+'px');
});
$(document).ready(function() {
	jQuery("#grid").css("height",(jQuery(window).height() - 75)+'px');
	generate(); 
	loadSourcesData();	
});
function loadSourcesData(){
	message = "Loading...";
	setTimeout(function(){
		if(w2ui.hasOwnProperty('grid')){
			w2ui.grid.status(message);
		}
	},500);
	jQuery.ajax({
		type:'GET',
		url:__baseUrl+'leads/sources_data',
		cache:false,
		dataType:'json',
		success:function(d){
			if(w2ui.hasOwnProperty('grid')){
			  w2ui['grid'].destroy();
			}	
			records = d;
			message = "";
			generate();
		}
	});
}
function addARecord(){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/add_source_data',
		data:{},
		cache:false,
		dataType:'json',
		success:function(d){
			if(d.id > 0){
				var getRecords = w2ui.grid.records;
				if(w2ui.hasOwnProperty('grid')){
					w2ui['grid'].destroy();
				}
				getRecords.push({ recid: d.id, id: d.id, source: '',subject: '', purpose: '', url: ''})
				records = getRecords;
				message = "";
				generate();
			}					
		}
	});
}
function updateRecord(updateData,recID,i){
	if(recID > 0){
		updateData.id = recID;
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/update_source_data',
			data:updateData,
			cache:false,
			dataType:'json',
			success:function(d){
				var getRecords = w2ui.grid.records;
				getRecords[i].source = updateData.source;
				getRecords[i].subject = updateData.subject;
				getRecords[i].purpose = updateData.purpose;
				getRecords[i].url = updateData.url;
				records = getRecords;
				w2ui['grid'].set(recID, updateData);
			}
		});
	}
}
function saveRecord(){
	var allRecords = w2ui.grid.records;
	if(allRecords.length > 0) {
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/update_all_sources_data',
			data:{rows:allRecords},
			cache:false,
			dataType:'json',
			success:function(d){
				console.log(d);
			}
		});
	}
}
const formatter = new Intl.NumberFormat('en-IN');
function deleteRecord(){
	var getSelections = w2ui.grid.getSelection();
	if(getSelections.length > 0) {
		var conf = confirm("Delete "+formatter.format(getSelections.length)+" sources data?");
		if(conf){
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'opportunity/deleteBulkSourceData',
				data:{delete_link:getSelections},
			})
			.done(function(d){
				if(d != "") {
					w2ui.grid.select(getSelections.join(','));
					w2ui.grid.delete(true);
				}
			});
		}
	}
}
</script>
</body>
</html>