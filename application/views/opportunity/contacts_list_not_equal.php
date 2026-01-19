<head>
<?php if(!isset($this->session->userdata['type'])):?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<?php endif;?>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>views/contact/contact_min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/custom.css"/>
<link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<style>
body {
		overflow: auto !important;
		min-width: 0;
		font-family:arial;font-size:13px;
		margin-top:0px;
		margin-bottom:0px;
	}
	#page-content {
	    background: #ffffff !important;
	}
	
	a{text-decoration:none;}h4{font-size:13px;font-weight:400;line-height:20px;margin:0}
	
	.mrg5R{margin-right:5px;}
.form-control{padding:6px;}
.ui-dropdownchecklist{z-index:999 !important;}
.containerResearchHeader, .containerHeader{width:100%;overflow:hidden;}
.containerResearchBody, .containerBody{width:100%;height:250px;overflow:scroll;}
.dt{
    font-size: 13px;
    width: 100%;
    border-spacing: 0;
    border-collapse: separate;
}
.ui-menu-item{list-style:none;padding:10px;border:1px solid #56b2fe;margin-bottom:3px;}
.ui-menu-item:hover{background-color:#56b2fe;color:#fff;}	
.ui-helper-hidden-accessible{display:none;}
.ui-autocomplete {
	padding:0px;margin:0px;
    /*max-height: 400px;*/
    overflow-y: auto;
    overflow-x: hidden;background:#fff;width:250px !important;
  }
.button-list{border:1px solid #dfe8f1;padding:0px 5px 3px 6px;cursor:pointer;float:right;}
.filter,.filter-sort{cursor:pointer;color:red;}
.p-relative {
    position: relative;
}
.sort{
	width: 16px;
    height: 16px;
    top: -2px;
    cursor: pointer;
    background-repeat: no-repeat;
}
.icon-default {background: url(<?php echo $Layout->baseUrl?>public/images/sort_both.png);}
.icon-asc{background: url(<?php echo $Layout->baseUrl?>public/images/sort_asc.png);}
.icon-desc{background: url(<?php echo $Layout->baseUrl?>public/images/sort_desc.png);}
.p-absolute {
    position: absolute;
}
.mrg20L {margin-left:15px !important;}
.mrg15T {margin-top:15px !important;}
#grid a{color:#15c !important;}
.pull-left{float:left} .mrg10L{margin-left:10px;} .mrg5R{margin-right:5px;} .mrg5T{margin-top:5px;}
.w2ui-grid .w2ui-grid-body table .w2ui-head.open{color: #c20000;}
span.list_special{margin-right: 15px;cursor: pointer;color: #2d2d2d;font-size: 15px;background: rgb(212,212,212);padding: 2px 5px;margin-bottom: 7px;display: inline-block;border-radius: 11px;}
span.list_special:hover,span.list_special.selected{color:#c20000;text-decoration:underline}
span.list_special:last-child{margin:0;}
.selected{color:#c20000;text-decoration:underline}
.mrg10L{margin-left:10px;}
.mrg5B{margin-bottom:5px;}
.page-n,.page-p{margin-left:20px;}
.alpha{text-transform:uppercase;font-size:14px;margin-left:2px;}
.alpha:before{content:" | "}
.alpha:first-child:before{content:""}
.alpha:last-child{margin-right:0}
.alpha.active{color:#c20000;}
a{text-decoration:none;}
.filter_box .p-absolute{z-index:9;}
.ui-autocomplete{z-index:99;}
.filter_box .p-absolute input[type="text"]{margin-left:5px;}
.filter_box .p-absolute .btn-default{height:auto;line-height:10px;}
.filter_box ul{padding:0px;}
.open_list{list-style:none;padding-left:0px;}
.bold{font-weight:bold;}
.w2ui-reset table tr th, .w2ui-reset table tr td,.open_list li, .open_list li span{font-family:arial;font-size:13px;}
</style>
<div><a href='javascript://' class='btn btn-primary pull-left mrg5R' style="width:auto;min-width:auto;height:auto;" onclick='deleteSelectedContacts()' title="Delete Users"><i class='fa fa-trash'></i></a></div>
<div id="grid" style="width: 100%; height: 600px;"></div>
<script>
var records = [];
var _sortField = "c.system_update";
var _sortBy = "DESC";
var selectedCompanies = [];
function boldMe(o){	
	const recordEle = jQuery("#grid_grid_records");
	if(recordEle.length > 0){
		recordEle.find('.name').removeClass('bold');
	}
	o.addClass('bold');	
}
function removeBold(contactID){
	const recordEle = jQuery("#grid_grid_records");
	if(recordEle.length > 0){
		const trEle = recordEle.find('tr#grid_grid_rec_'+contactID);
		if(trEle.length > 0){
			trEle.find('.name').removeClass('bold');
		}
	}
}
var message = "Loading....";
let size1="200px",size2="250px",size3="150px",size4="250px",size5="50px",size6="50px",size7="20px",size8="50px",size9="40px",size10="50px",size11="80px",size12="300px",size13="80px",size14="40px";
let tableColumns = [
            { field: 'name', text: 'Name', size: size1,resizable: true, sortable: true, searchable: true,
				render: function(record) {
					return "<a href='javascript://' onclick='window.parent.getLeadList(jQuery(this));' data-id='"+record.id+"'><i class='fa fa-play' title='My Leads'></i></a> <a class='name' href='javascript://' onclick='boldMe(jQuery(this));window.parent.editContact("+record.id+")'>"+record.name+"</a>"
				}
			},
            { field: 'company_name', text: 'Company', size: size2,resizable: true, sortable: true,  searchable: true,
				render: function(record) {
					return "<a href='javascript://' onclick='window.parent.openCompanyEdit("+record.company_id+")'>"+record.company_name+"</a>";
				}
			},
            { field: 'current_company', text: 'Current C', size: size3,resizable: true, sortable: true,  searchable: true },
            { field: 'title', text: 'Job Title', size: size4,resizable: true, sortable: true,  searchable: true },
            { field: 'email', text: 'Mail', size: size5,sortable: true, searchable: true,
				render: function(record) {
					_htmlEmail = "";
					const activeEmail = parseInt(record.active_email);	
					if(record.email != ""){						
						_color = "#56b2fe";
						if(activeEmail == 4){
							_color = "#cc0000";
						}else if(activeEmail == 2 && (record.secondary_email == "" || record.secondary_email == undefined)){
							_color = "#cc0000";
						}else if(activeEmail == 3 && (record.tertiary_email == "" || record.tertiary_email == undefined)){
							_color = "#cc0000";
						}
						if(record.new_email == 1){
							console.log(1111);
							if(((activeEmail == 1 && (record.email != "" && record.email != undefined)) || (activeEmail == 2 && (record.secondary_email != "" && record.secondary_email != undefined)) || (activeEmail == 3 && (record.tertiary_email != "" && record.tertiary_email != undefined)))){
								_color = "green";
							}
							
						}
						_htmlEmail = '<span style="text-indent:-99999px;display:inline-block">@@</span> <i class="fa fa-envelope" style="color:'+_color+'"></i>';
					} else {
						//_htmlEmail = '<span style="text-indent:-99999px;display:inline-block">-@</span>';
					}
					return _htmlEmail;
				}
			},
            { field: 'all_phones', text: 'Tel', size: size6,resizable: true, sortable: true,  searchable: true,
				render: function(record) {
					var _htmlPhone = ""; var _d =0;
					if(record.phone!=""){
						_htmlPhone = '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+record.phone+'"));\' style="color:#56b2fe"><i class="fa fa-phone fa-mobile" title="MobileTel"></i></a>';
						_d =1;
					}
					if(record.telephone!=''){
						if(_d==1){
							_htmlPhone +=", ";
						}
						_htmlPhone +=  '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+record.telephone+'"));\' style="color:green"><i class="fa fa-phone" title="DirectTel"></i></a>';
						_d =1;
					}
					if(record.company_tel!=''){
						if(_d==1){
							_htmlPhone +=", ";
						}
						_htmlPhone +=  '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+record.company_tel+'"));\' style="color:green"><i class="fa fa-phone fa-phone-square" title="CompanyTel"></i></a>';
						_d =1;
					}
					return _htmlPhone;
				}
			},
            { field: 'linkedin_url', text: 'In', size: size7,resizable: true, sortable: true,  searchable: true,
				render: function(record) {
					if(record.linkedin_url!=""){
						_htmlUrl = '<span style="text-indent:-99999px;display:inline-block">#</span><a href="'+record.linkedin_url+'" target="_blank"><i class="fa fa-linkedin" style="color:#56b2fe"></i></a>';
					} else {
						_htmlUrl = '<span style="text-indent:-99999px;display:inline-block">-#</span>';
					}
					return _htmlUrl;
				}
			},
			{ field: 'scrape_no', text: 'ScrapeNo', size: size8, searchable: false, sortable: true, resizable: true,render: function(record) {
				return parseInt(record.scrape_no);
			}},
			{ field: 'c_c', text: 'CC', size: size9, searchable: true, sortable: true, resizable: true,render: function(record) {
				return parseInt(record.c_c);
			}},
			{ field: 'proximity', text: 'Type', size: size10, searchable: true, sortable: true, resizable: true},
            { field: 'create_date', text: 'Create', size: size11, searchable: true, sortable: true, resizable: true},
            { field: 'note', text: 'Notes', size: size12,resizable: true, sortable: true,  searchable: true },
            { field: 'system_date', text: 'Updated', size: size13, searchable: true, sortable: true, resizable: true},
			{ field: 'id', text: 'UserID', size: size14,resizable: true, sortable: true,  searchable: false }
        ];
	let sortData = [];

window.generate = function generate() {
    // define and render grid
    $('#grid').w2grid({
        name    : 'grid',
        header  : 'List of Users',
		recid	: 'id',
		columnTooltip: 'top',
		show	: { footer: true, toolbar: false,selectColumn: true,emptyRecords: true},
		multiSearch: true,
		markSearch:true,
		multiSelect:true,
		multiSort:true,
        columns: tableColumns,
		records: records,
		onClick: function(event) {
			if(event.column === null) {
				var listSelected = w2ui.grid.getSelection();
				if(listSelected.length > 0 ) {
					setTimeout(()=>{
						listSelected.map((d)=> {
							w2ui.grid.select(parseInt(d));
						});
					},1);
				}
			} else {
				event.preventDefault();
			}
		},
		onDblClick: function(event) {
			if(event.recid > 0) {
				var listSelected = w2ui.grid.getSelection();
				var unSelected = [];
				
				if(listSelected.length > 0 && listSelected.indexOf(parseInt(event.recid)) >= 0 ) {
					listSelected.splice(listSelected.indexOf(parseInt(event.recid)),1);
					unSelected.push(parseInt(event.recid));
				} else {
					listSelected.push(parseInt(event.recid));
				}

				//w2ui.grid.select(listSelected.join(','));
				setTimeout(()=>{
					listSelected.map((d)=> {
						w2ui.grid.select(parseInt(d));
					});
					if(unSelected.length > 0) {
						unSelected.map((d)=> {
							w2ui.grid.unselect(parseInt(d));
						});
					}
				},50);
			}
			event.preventDefault();
		}
    });
	w2ui.grid.buffered = records.length;
	w2ui.grid.total = w2ui.grid.buffered;
	w2ui.grid.resize();

}

function removeUserFromList(ID){
	if(records.length > 0){
		records.map(function(u,i){
			if(u.id == ID){
				records.splice(i,1);
				return false;
			}
		});
		console.log("contact deleting",ID);
		w2ui.grid.select(ID);
		w2ui.grid.delete(true);
	}
}

function selectedUserDataScraped(l,profileID){
	console.log("COntact list selectedUserDataScraped");
	var getSelections = w2ui.grid.getSelection();
	var tapFind = false;
	if(getSelections.length > 0){
		if(l.length > 0) {
			l.map(function(contact){
				if(getSelections.indexOf(contact.id) >= 0){		
					console.log("FOUND!!!");
					updateRecord(contact);
					tapFind = true;
					return false;
				}
			})
		}
	}
	if(tapFind === false && typeof profileID != 'undefined'){
		console.log("FN profile",profileID);
		var allRecords = w2ui.grid.records;
		for(let i = 0; i < allRecords.length; i++){
			if(profileID == allRecords[i].id){
				for(let j =0; j < l.length; j++){
					if(l[j].id == profileID){
						console.log("FOUND!!!!!");
						updateRecord(l[j]);
						return false;
					}
				}
			}
		}
	}
}

function emailScrapedData(contactData){
	w2ui.grid.unselect(contactData.contact_id);
	w2ui.grid.set(contactData.contact_id,{email:contactData.email});
}

function updateRecord(d){
	console.log("FOUND Contact",d);
	var _sectorName = d.sectorName;
	if(_sectorName==null){
		_sectorName='';
	}
	var _categories = d.department_names;
	if(_categories==null){
		_categories='';
	}
	var _sub_categories = d.sub_department_names;
	if(_sub_categories==null){
		_sub_categories='';
	}
	var object = {};
	object.first_name = jQuery.trim(d.first_name);
	object.last_name = jQuery.trim(d.last_name);
	object.name = object.first_name+" "+object.last_name;
	object.company_name = d.company_name;
	if(typeof d.company_id != "undefined"){
		companyID = d.company_id;
	} else if(typeof d.companyID != "undefined"){
		companyID = d.companyID;
	}
	object.company_id = companyID;
	object.gateway = d.gateway;
	object.title = d.job_title;
	__scrapeNo = 0;
	if(typeof d.scrape_no != "undefined"){
		__scrapeNo = d.scrape_no;
	}
	object.scrape_no = parseInt(__scrapeNo);
	object.current_company = d.current_company;
	object.new_email = d.new_email;
	_emailID = "";
	_activeEmail = d.active_email;
	switch(parseInt(_activeEmail)){
		case 1:
			if(d.email != ""){
				_emailID = d.email;
			}
			break;
		case 2:
			if(d.secondary_email != ""){
				_emailID = d.secondary_email;
			} else if(d.email != ""){
				_emailID = d.email;
				_activeEmail = 4;
			}
			break;
		case 3:
			if(d.tertiary_email != ""){
				_emailID = d.tertiary_email;
			} else if(d.secondary_email != ""){
				_emailID = d.secondary_email;
				_activeEmail = 4;
			}
			break;
	}
	if(d.email != "" && _emailID == ""){
		_emailID = d.email;
	}
	object.email = d.email;
	object.secondary_email = d.secondary_email;
	object.tertiary_email = d.tertiary_email;
	object.phone = d.phone;
	object.telephone = d.telephone;
	object.company_tel = d.company_tel;
	object.c_c = 0;
	object.active_email = _activeEmail;
	object.proximity = 0;
	if(typeof d.c_c != "undefined"){
		object.c_c = parseInt(d.c_c);
	}
	if(typeof d.proximity != "undefined"){
		object.proximity = parseInt(d.proximity);
	}	
	var all_phones = "";
	if(object.phone != "" || object.telephone != "" || object.company_tel != "") {
		all_phones = object.phone+","+object.telephone+","+object.company_tel;
	}
	object.all_phones = all_phones;
	object.linkedin_url = d.linkedin_url;
	_note = d.note;
	_note = _note.toString();
	_note = _note.replace('\n',' ');
	_note = _note.replace('\r',' ');
	_note = _note.replace('\\r',' ');
	_note = _note.replace('\\n',' ');
	_date = d.system_update;
	if(_date!="0000-00-00 00:00:00"){
		_date = moment(new Date(_date)).format('YYYY-MM-DD HH:mm:ss');
	} else {
		_date = '';
	}	
	_create_date = d.create_date;
	if(_create_date!="0000-00-00 00:00:00"){
		_create_date = moment(new Date(_create_date)).format('YYYY-MM-DD');
	} else {
		_create_date = '';
	}
	object.create_date = _create_date;	
	object.note = _note;
	object.sectors = _sectorName;
	object.categories = _categories;
	object.sub_category = _sub_categories;
	object.technolgies = d.technology_names;
	object.sub_technolgies = d.sub_technology_names;
	object.selected = "no";
	object.system_date = _date;
	console.log("OBJECT",object);
	w2ui.grid.set(d.id,object);
	w2ui.grid.unselect(d.id);
}

var oldSelectedList = {type:'',list:[],eq:-1};
var initialCall = false;
var _filterEmail="",_filterCurrentCompany="",_filterPhone="",_filterLinkedIn = "",_filterCompany="",_filterSector=[],_filterTechnology=[],_filterCat=[],_filterSubType=[],_filterSubTech=[],_filterProximity=[],_filterProfileName="",_filterTitle=[];
function loadTableWithNewData(sort2){
	message = "Loading...";
	setTimeout(function(){
		if(w2ui.hasOwnProperty('grid')){
			w2ui.grid.status(message);
		}
	},500);
	records = [];
	if(typeof sort2 == "undefined"){
		sort2 = 1;
	}
	var	_url = __baseUrl+'opportunity/find_contacts_not_equal_to_current_company/';
	jQuery.ajax({
		type:"GET",
		url:_url,
		cache:false,
		dataType:'json'
	})
	.done(function(b){
		console.log("BT",b);
		if(w2ui.hasOwnProperty('grid')){
		  w2ui['grid'].destroy();
		}
		jQuery("#grid").css("height",(jQuery(window).height() - 40)+'px');
		if(typeof b !="undefined" && b.length>0){
			_data = b;
			let companyID = 0;
			let _date = "";
			let _create_date = "";
			let _note = "";
			let name = "";
			for(let i=0;i<_data.length;i++){
				var _sectorName = '';
				var _categories = '';
				var _sub_categories = '';
				object = {};
				object.id = parseInt(_data[i].id);
				object.first_name = jQuery.trim(_data[i].first_name);
				object.last_name = jQuery.trim(_data[i].last_name);
				object.name = object.first_name+" "+object.last_name;
				object.company_name = _data[i].company_name;
				if(typeof _data[i].company_id != "undefined"){
					companyID = _data[i].company_id;
				} else if(typeof _data[i].companyID != "undefined"){
					companyID = _data[i].companyID;
				}
				object.company_id = companyID;
				object.gateway = _data[i].gateway;
				object.title = _data[i].job_title;
				object.scrape_no = parseInt(_data[i].scrape_no);
				object.new_email = parseInt(_data[i].new_email);
				_emailID = "";
				_activeEmail = _data[i].active_email;
				switch(parseInt(object.active_email)){
					case 1:
						if(_data[i].email != ""){
							_emailID = _data[i].email;
						}
						break;
					case 2:
						if(_data[i].secondary_email != ""){
							_emailID = _data[i].secondary_email;
						} else if(_data[i].email != ""){
							_emailID = _data[i].email;
							_activeEmail = 4;
						}
						break;
					case 3:
						if(_data[i].tertiary_email != ""){
							_emailID = _data[i].tertiary_email;
						} else if(_data[i].secondary_email != ""){
							_emailID = _data[i].secondary_email;
							_activeEmail = 4;
						}
						break;
				}
				if(_data[i].email != "" && _emailID == ""){
					_emailID = _data[i].email;
				}
				//object.email = _emailID;
				object.email = _data[i].email;
				object.secondary_email = _data[i].secondary_email;
				object.new_email = _data[i].new_email;
				object.tertiary_email = _data[i].tertiary_email;
				object.active_email = _activeEmail;
				object.phone = _data[i].phone;
				object.current_company = _data[i].current_company;
				object.telephone = _data[i].telephone;
				object.company_tel = _data[i].company_tel;
				object.c_c = 0;
				object.proximity = 0;
				if(typeof _data[i].c_c != "undefined"){
					object.c_c = parseInt(_data[i].c_c);
				}
				if(typeof _data[i].proximity != "undefined"){
					object.proximity = parseInt(_data[i].proximity);
				}
				var all_phones = "";
				if(object.phone != "" || object.telephone != "" || object.company_tel != "") {
					all_phones = object.phone+","+object.telephone+","+object.company_tel;
				}
				object.all_phones = all_phones;
				object.linkedin_url = _data[i].linkedin_url;
				_note = _data[i].note;
				_note = _note.toString();
				_note = _note.replace('\n',' ');
				_note = _note.replace('\r',' ');
				_note = _note.replace('\\r',' ');
				_note = _note.replace('\\n',' ');
				_date = _data[i].system_update;
				if(_date!="0000-00-00 00:00:00"){
					_date = moment(new Date(_date)).format('YYYY-MM-DD HH:mm:ss');
				} else {
					_date = '';
				}	
				_create_date = _data[i].create_date;
				if(_create_date != "0000-00-00 00:00:00"){
					_create_date = moment(new Date(_create_date)).format('YYYY-MM-DD');
				} else {
					_create_date = '';
				}
				object.create_date = _create_date;	
				object.note = _note;
				object.sectors = _sectorName;
				object.categories = _categories;
				object.sub_category = _sub_categories;
				object.technolgies = '';
				object.sub_technolgies = '';
				object.selected = "no";
				object.system_date = _date;
				records.push(object);
			}
		}
		message = "";
		generate();
	})
	.fail(function(){
		console.log("Ajax request failed");
	});
}
function deleteSelectedContacts(){
	_idS = w2ui.grid.getSelection();
	if(_idS.length>0){
		var conf = confirm("Delete "+_idS.length+" contacts?");
		if(conf){
			const recordList = w2ui.grid.records;
			let companyList = [];
			_idS.forEach(function(u){
				if(recordList.length > 0){
					recordList.forEach(function(r){
						if(r.id == u){
							if(jQuery.inArray(r.company_id,companyList)<0){
								companyList.push(r.company_id);
							}
							return;
						}
					});
				}
			});
			message = "Deleting...";
			w2ui.grid.status(message);
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'opportunity/deleteContactsInBatch',
				data:{c:JSON.stringify(_idS)},
			}).done(function(d){
				if(d=='-1'){
					alert("Some correspondense with this contact.");
				} else {
					message = "";
					w2ui.grid.status(message);
					w2ui.grid.select(_idS.join(','));
					w2ui.grid.delete(true);
					if(_idS.length > 0){
						window.parent.updateDeleteRecords(companyList);
					}
				}
			});
		}		
	} else {
		alert('Please select contact first');
	}
}
function checkMeCheckAll(o){
	_tap = false;
	if(o.is(':checked')){
		_tap = true;
	}
	var _LIST = o.parents('.list_options').find('ul.open_list li');
	if(_LIST.length>0){
		_LIST.find('input[type="checkbox"]').prop('checked',_tap);
	}
}
function findCompaniesInLead(o){
	loadTableWithNewData();
}
function openAddForm(){
	window.parent.openContactEditForm(0);
}
var __baseUrl = '<?php echo $Layout->baseUrl?>';
var _type = 0;
<?php 
	if(count($this->session->userdata)>0 && isset($this->session->userdata['type'])){
?>
	 _type = <?php echo $this->session->userdata['type'];?>;
<?php
	}
?>
$(document).ready(function() {	
	generate(); 
	loadTableWithNewData();	
});
jQuery(window).resize(function(){
	jQuery("#grid").css("height",(jQuery(window).height() - 40)+'px');
});
</script>