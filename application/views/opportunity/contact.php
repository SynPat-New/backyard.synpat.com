<head>
<?php if(!isset($this->session->userdata['type'])):?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<?php endif;?>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<!--<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/slimscroll/slimscroll.js"></script>-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/menu.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/custom.css"/>

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
	.scroll-container {
	width: 100%;
	height: 250px;
	margin: 0px;
	overflow: hidden;
}
.form-control{padding:6px;}
.ui-dropdownchecklist{z-index:9999999999999999999999 !important;}
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
table.fixedHeader, table.tableData{border:0px;}
table.fixedHeader th{border:0px !important;border-right:solid 1px #dfe8f1 !important}
table.tableData td{border-top:0px !important;border-right:0px !important;height:20px;min-height:20px;}
table.tableData td:last-child{border-right:solid 1px #dfe8f1 !important;}
.button-list{border:1px solid #dfe8f1;padding:0px 5px 3px 6px;cursor:pointer;float:right;}
.filter,.filter-sort{cursor:pointer;color:red;}
table.tableData tr:first-child td{border-top:solid 0px #dfe8f1 !important}
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
.table{border:1px #dfe8f1 !important;}
.mrg20L {margin-left:15px !important;}
.table > thead > tr > th {
    font-weight: normal;
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
	border-bottom: solid 1px #dfe8f1 !important;
	border-top: solid 1px #dfe8f1 !important;
}
.table > thead > tr > th:first-child{
	border-left: solid 1px #dfe8f1 !important;
}
.table > thead > tr > th:last-child{
	border-right: solid 1px #dfe8f1 !important;
}
.handsontable th {
    background: #fff;
    font-weight: normal;
}
.open_list{list-style:none;padding:0px;}
 .containerResearchBody ::-webkit-scrollbar{-webkit-appearance: none;width: 10px;}
 .containerResearchBody ::-webkit-scrollbar:vertical{width: 18px;}
 .containerResearchBody ::-webkit-scrollbar-thumb{border-radius: 1px;background-color: rgba(0,0,0,.3);box-shadow: 0 0 1px rgba(255,255,255,.3);}
 .filter{margin-left:0px;}
 .filter-sort, .sortIcon{margin-left:21px;}
 th.open{background:green;color:#fff !important;}
 th ul{list-style:none;padding:0px;}
 th ul li,th.open ul.open_list li,th.open ui.open_list li span{color:#222222 !important}
 div.overwrap{white-space: nowrap; overflow: hidden;text-overflow: ellipsis;height:20px;}
#noOfRecords{padding-top:10px;padding-left:20px;color:red;}
 </style>
</head>
<body>
<h4 id='cn' style='padding-left:65px;'>Contacts  <span id='loading_message' style='margin-left:100px'></span></h4>
<div class="row mainT">	
	<div class="col-xs-12" style='width:100%;'>		
		<div class="row btnList" style='margin-bottom:10px;'>
			<div class="col-xs-12" style=''>
				<?php if(isset($this->session->userdata['type'])):?>
				<a href='javascript://' onclick="window.parent.openCContact()" class='btn btn-primary pull-left mrg5R' style="width:auto;min-width:auto;height:auto;" title="Companies"><i class="fa fa-building" style="margin-left:0px;"></i></a>
				<a href='javascript://' onclick="window.parent.openPreCompanies()" class='btn btn-primary pull-left mrg5R'>Linkedin search</a>
				<a href='javascript://' onclick="window.parent.openPreContacts()" class='btn btn-primary pull-left mrg5R'>Pre Contacts</a>
				<a href='javascript://' onclick="openAddForm()" class='btn btn-primary pull-left mrg5R' style="width:auto;min-width:auto;height:auto;" title="Add User"><i class="fa fa-user-plus" style="margin-left:0px;"></i></a>
				<a href='javascript://' onclick="getFillHoleContacts()" class='btn btn-primary pull-left mrg5R'>DataFills</a>
				<?php endif;?>
				<div class='<?php if(isset($this->session->userdata['type'])):?>col-xs-1 <?php else:?> col-xs-12<?php endif;?>'>
					<input type='text' placeholder='Search...' id='search_field' style='color:#2b2f33;height:22px;margin-left:-2px;' name='search_field' class='form-control'/>
				</div>
				<?php if(isset($this->session->userdata['type'])):?>
				<div class="col-xs-2">
					<div class="form-group input-string-group" style='border:0px;margin-bottom:0px;'>
						<select name="profile[lead]" id="profileLead" style='margin-left:13px' class="form-control" onchange="findCompaniesInLead(jQuery(this).val());" style="height:36px;">
							<option value="0">Lead</option>							
						</select>
					</div>
				</div>
				<?php endif;?>
				<div class="col-xs-1" id="noOfRecords">0</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12"><span id='selected_contacts'>Selected:0</span><span class='mrg20L'><a href='javascript://' onclick='deleteSelectedContacts()'><i class='fa fa-trash'></i></a></span></div>
</div>
<div class="row">
	<div class="scroll-container col-lg-12 cp-border">
		<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:100%;'></div>
	</div>
</div>

<script>
const formatter = new Intl.NumberFormat('en-IN');
var initialCall = false;
var minTable = document.getElementById("companies_box");
_companiesINString = [];
_companiesINString=[];
_companies = [];
_sectors = [];
userColumns = ["#","Name","Company","Job Title","Mail","Tel","In","Create","Notes","Sectors","Categories","SubCategories","Technologies","Sub Technologies","Date"];
jQuery(document).ready(function(){
	var width = jQuery(window).width();
	var height = jQuery(window).height();
	newHeight = (height - jQuery('#cn').outerHeight() - jQuery('.mainT').outerHeight());
	jQuery('.scroll-container,.ui-autocomplete').css("height",newHeight+"px");
	setTimeout(function() {
		nH = newHeight -130;
		jQuery('.ui-autocomplete').css("height",nH+"px");
	}, 300);
	showContactsTable();
	jQuery('#search_field').keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			e.preventDefault();
			jQuery("#rs tbody").find("tr").remove();
			_requestAlreadySend = false;
			loadTableWithNewData(true,0,200);
		}		  
	});
	jQuery("#search_company_field").keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			e.preventDefault();
			_requestAlreadySend = false;
			searchWithInCompany(jQuery(this).val());
		}		  
	});
	jQuery("#search_company_field").autocomplete({
		minLength: 2,
		source: function (request, response) {
			jQuery.ajax({
				url: __baseUrl+'opportunity/search_company_by_name',
				dataType: "json",
				data: { query: request.term },
				success: function (data) {
					response($.map(data, function (item) {
						return {
							label: item.Name,
							value: item.Name,
							realValue: item.UID,
							sectorId: item.SectorID,
							sectorName: item.SectorName,
						};
					}));
				},
			});
		},
		select: function (event, ui) {
			/*jQuery("#inviteeCompanyId").val(ui.item.realValue);*/
			jQuery("#lblCompany").html('Company: <strong><a href="javascript://" onclick="window.parent.openCompanyEdit('+ui.item.realValue+');">'+ui.item.label+'</a>"</strong>');
			_requestAlreadySend = false;
			searchWithInCompany(ui.item.realValue);
		}
	});
	jQuery("#search_name").keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			e.preventDefault();
			_requestAlreadySend = false;
			searchWithName(jQuery(this).val());
		}		  
	});
	jQuery("#search_name").autocomplete({
		minLength: 2,
		source: function (request, response) {
			jQuery.ajax({
				url: __baseUrl+'opportunity/search_contact_by_name',
				dataType: "json",
				data: { query: request.term },
				success: function (data) {
					response($.map(data, function (item) {
						return {
							label: item.Name,
							value: item.Name,
							realValue: item.UID,
							sectorId: item.SectorID,
							sectorName: item.SectorName,
						};
					}));
				},
			});
		},
		select: function (event, ui) {
			/*jQuery("#inviteeCompanyId").val(ui.item.realValue);*/
			jQuery("#lblCompany").html('Company: <strong><a href="javascript://" onclick="window.parent.editContact('+ui.item.realValue+');">'+ui.item.label+'</a>"</strong>');
			_requestAlreadySend = false;
			
			searchWithName(ui.item.realValue);
		}
	});
	jQuery("#search_job_title").keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			e.preventDefault();
			_requestAlreadySend = false;
			searchWithTitle(jQuery(this).val());
		}		  
	});
	jQuery("#search_job_title").autocomplete({
		minLength: 2,
		source: function (request, response) {
			jQuery.ajax({
				url: __baseUrl+'opportunity/search_contact_by_title',
				dataType: "json",
				data: { query: request.term },
				success: function (data) {
					response($.map(data, function (item) {
						return {
							label: item.Name,
							value: item.Name,
							realValue: item.UID,
							sectorId: item.SectorID,
							sectorName: item.SectorName,
						};
					}));
				},
			});
		},
		select: function (event, ui) {
			/*jQuery("#inviteeCompanyId").val(ui.item.realValue);*/
			jQuery("#lblCompany").html('Company: <strong><a href="javascript://" onclick="window.parent.editContact('+ui.item.realValue+');">'+ui.item.label+'</a>"</strong>');
			_requestAlreadySend = false;
			searchWithTitle(ui.item.realValue);
		}
	});
	
	/*jQuery('html').on('click',function(e){
		jQuery('.button-list')
			.not(jQuery('.button-list').has($(e.target)))
			.parent().removeClass('n').find('.list_options')
			.hide();
	});*/
	jQuery(window).resize(function(){
		setTimeout(function(){
			var width = jQuery(window).width();
			var height = jQuery(window).height();
			newHeight = (height - jQuery('#cn').outerHeight() - jQuery('.mainT').outerHeight());
			jQuery('.scroll-container').css("height",newHeight+"px");
			_calHeader = jQuery(minTable).find('div.containerResearchHeader').height();
			console.log(newHeight,_calHeader);
			_calHeight = newHeight - _calHeader -10;
			jQuery(minTable).find('div.containerResearchBody').css("height",_calHeight+"px");
			_width = jQuery(minTable).find('div.containerResearchHeader').parent().width();
			_extraWidth = 0;
			_checkNavi = window.navigator;
			if(_checkNavi.platform.indexOf('Win')>=0){
				_extraWidth = 17;
			}
			jQuery(minTable).find('div.containerResearchHeader').css("width",_width-_extraWidth);
			var tableResearcherT = jQuery(minTable).find('table.tableData');
			var tableResearcherFixed = jQuery(minTable).find('table.fixedHeader');
			tableResearcherThead = tableResearcherFixed.find('tr');
			tableResearcherTbody = tableResearcherT.find('tbody tr');
			tableResearcherTbody.eq(0).find('td').each(function(i,th){
				jQuery(this).css('width','');
				jQuery(this).css('min-width','');
				jQuery(this).css('max-width','');
				tableResearcherThead.find('th').eq(i).css('width','');
				tableResearcherThead.find('th').eq(i).css('min-width','');
				tableResearcherThead.find('th').eq(i).css('max-width','');
			})
			resizeTable(1);
		},400);
	});
	setTimeout(function(){loadTableWithNewData(true,0,200);},1000);
});

function findTechnologies(){
	jQuery.ajax({
		url: __baseUrl+'opportunity/get_list_technologies',
		dataType:'json'
	}).done(function(d){
		if(d.length>0){
			_technologies = d;
			_selectUl = jQuery("<ul/>").addClass('open_list');
			jQuery.each(_technologies,function(i,c){
				var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
				var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.id);
				var spanY = jQuery("<span/>").css('float','left').append(checkBox);
				var spanX = jQuery('<span/>').append(c.name);
				_selectLi.append(spanY).append(spanX);
				_selectUl.append(_selectLi);
			});
			jQuery('.fixedHeader').find('thead th').eq(11).find('.list').empty().append(_selectUl);
		}
	}).always(function(){
		window.parent.checkContactsLoad();
	});
}

function getCompaniesList(){
	_selectUl = jQuery("<ul/>").addClass('open_list');
	jQuery.each(_companies,function(i,c){
		var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
		var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.id);
		var spanY = jQuery("<span/>").css('float','left').append(checkBox);
		var spanX = jQuery('<span/>').append(c.name);
		_selectLi.append(spanY).append(spanX);
		_selectUl.append(_selectLi);
	});
	return _selectUl.prop('outerHTML');
}
function getSectors(){
	_selectUl = jQuery("<ul/>").addClass('open_list');
	jQuery.each(_sectors,function(i,c){
		if(c.id!=21){
			var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
			var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.id);
			var spanY = jQuery("<span/>").css('float','left').append(checkBox);
			var spanX = jQuery('<span/>').append(c.name);
			_selectLi.append(spanY).append(spanX);
			_selectUl.append(_selectLi);
		}		
	});
	return _selectUl.prop('outerHTML');
}
function openFilterList(o){
	jQuery(".containerResearchHeader .fixedHeader th").find('.list_options').hide();
	var parentTh = o.parents('th');
	if(parentTh.hasClass('n')){
		parentTh.find(".list_options").find('.p-absolute').parent().hide();
		jQuery(".containerResearchHeader .fixedHeader th").removeClass('n');
	} else {
		parentTh.addClass('n');
		_position = o.parent().position();
		parentTh.find(".list_options").find('.p-absolute').parent().show();
		_width = parentTh.width();
		if(_width<150){
			_width = 150;
		}
		parentTh.find(".list_options").find('.p-absolute').css({height:'320px',top:31,left:_position.left,width:_width+'px',background:'#fff',border:'1px solid #dfe8f1'});
		/*_position = o.offset();
		_listHTML = parentTh.find('.open_list').clone();
		_width = parentTh.width() + 10;
		var _btn = jQuery('<a/>').attr('href','javascript://').append('Apply').css({width:'100%',marginBottom:'10px',fontSize: '15px'}).addClass('btn btn-primary pull-left mrg5R');
		_btn.off('click').on('click',function(){
			searchFilter(jQuery(this));
		});
		jQuery("#list_options").find('.p-absolute').empty().append(_btn).append(_listHTML);
		jQuery("#list_options").find('.p-absolute').find('.open_list').show();
		jQuery("#list_options").find('.p-absolute').css({height:'320px',top:_position.top + 22,left:_position.left - 7,width:_width+'px',background:'#fff',overflow:'hidden',overflowY:'scroll',border:'1px solid #dfe8f1'});
		jQuery("#list_options").show();*/
	}
}

function searchWithName(name){
	if(name!=""){
		_checkList = [name];
		_filterProfileName = JSON.stringify(_checkList);
		var parentTH =jQuery(".containerResearchHeader").find('.fixedHeader').find('thead th').eq(1);
		parentTH.addClass('open');
		parentTH.find(".list_options").find('.p-absolute').parent().hide();
		parentTH.removeClass('n');
		jQuery("#rs tbody").find("tr").remove();
		loadMessage("Please wait...");
		loadTableWithNewData(true,0,200);
	} else {
		var parentTH =jQuery(".containerResearchHeader").find('.fixedHeader').find('thead th').eq(1);
		if(parentTH.find('.filter').length>0){
			clearFilter(parentTH.find('.filter'));
		} else {
			clearFilter(parentTH.find('.filter-sort'));
		}
		/* clearFilter(parentTH.find('.button-list')); */
	}
}

function searchWithTitle(title){
	if(title!=""){
		_checkList = [title];
		_filterTitle = JSON.stringify(_checkList);
		var parentTH =jQuery(".containerResearchHeader").find('.fixedHeader').find('thead th').eq(3);
		parentTH.addClass('open');
		parentTH.find(".list_options").find('.p-absolute').parent().hide();
		parentTH.removeClass('n');
		jQuery("#rs tbody").find("tr").remove();
		loadMessage("Please wait...");
		loadTableWithNewData(true,0,200);
	} else {
		var parentTH =jQuery(".containerResearchHeader").find('.fixedHeader').find('thead th').eq(3);
		/* clearFilter(parentTH.find('.button-list')); */
		if(parentTH.find('.filter').length>0){
			clearFilter(parentTH.find('.filter'));
		} else {
			clearFilter(parentTH.find('.filter-sort'));
		}
	}
}

function searchWithInCompany(companyName){
	if(companyName!=""){
		_checkList = [companyName];
		_filterCompany = JSON.stringify(_checkList);
		var parentTH =jQuery(".containerResearchHeader").find('.fixedHeader').find('thead th').eq(2);
		parentTH.addClass('open');
		parentTH.find(".list_options").find('.p-absolute').parent().hide();
		parentTH.removeClass('n');
		jQuery("#rs tbody").find("tr").remove();
		loadMessage("Please wait...");
		loadTableWithNewData(true,0,200);
	} else {
		var parentTH =jQuery(".containerResearchHeader").find('.fixedHeader').find('thead th').eq(2);
		/* clearFilter(parentTH.find('.button-list')); */
		if(parentTH.find('.filter').length>0){
			clearFilter(parentTH.find('.filter'));
		} else {
			clearFilter(parentTH.find('.filter-sort'));
		}
	}
}

function searchFilter(o){
	var parentTH = o.parents('th');
	parentTH.addClass('open');
	var _filterName = parentTH.attr('filter-name');
	switch(_filterName){
		case 'name':
			_filterProfileName = jQuery("#search_name").val();
		break;
		case 'job_title':
			_filterTitle = jQuery("#search_job_title").val();
		break;
		case 'email':
			_filterEmail = parentTH.find('input[type="radio"]:checked').val();
		break;
		case 'phone':
			_filterPhone = parentTH.find('input[type="radio"]:checked').val();
		break;
		case 'linkedin_url':
			_filterLinkedIn = parentTH.find('input[type="radio"]:checked').val();
		break;
		case 'company_name':
			_filterCompany = "";
			if(parentTH.find('input[type="checkbox"]:checked').length>0){
				_checkList = [];
				parentTH.find('input[type="checkbox"]:checked').each(function(){
					_checkList.push(jQuery(this).val());
				});
				if(_checkList.length>0){
					_filterCompany = JSON.stringify(_checkList);
				}
			}
		break;
		case 'sector':
			_filterSector = [];
			if(parentTH.find('input[type="checkbox"]:checked').length>0){
				parentTH.find('input[type="checkbox"]:checked').each(function(){
					_filterSector.push(jQuery(this).val());
				});
			}
		break;
		case 'cat':
			_filterCat = [];
			if(parentTH.find('input[type="checkbox"]:checked').length>0){
				parentTH.find('input[type="checkbox"]:checked').each(function(){
					_filterCat.push(jQuery(this).val());
				});
			}
		break;
		case 'sub_type':
			_filterSubType = [];
			if(parentTH.find('input[type="checkbox"]:checked').length>0){
				parentTH.find('input[type="checkbox"]:checked').each(function(){
					_filterSubType.push(jQuery(this).val());
				});
			}
		break;
		case 'tech':
			_filterTechnology = [];
			if(parentTH.find('input[type="checkbox"]:checked').length>0){
				parentTH.find('input[type="checkbox"]:checked').each(function(){
					_filterTechnology.push(jQuery(this).val());
				});
			}
		break;
		case 'sub_tech':
			_filterSubTech = [];
			if(parentTH.find('input[type="checkbox"]:checked').length>0){
				parentTH.find('input[type="checkbox"]:checked').each(function(){
					_filterSubTech.push(jQuery(this).val());
				});
			}
		break;
	}
	parentTH.find(".list_options").find('.p-absolute').parent().hide();
	parentTH.removeClass('n');
	jQuery("#rs tbody").find("tr").remove();
	loadMessage("Please wait...");
	loadTableWithNewData(true,0,200);
}
function clearFilter(o){
	jQuery("#search_company_field").val('');
	var parentTH = o.parents('th');
	parentTH.removeClass('open').removeClass('n');
	parentTH.find('input[type="text"]').val('');
	var _filterName = parentTH.attr('filter-name');
	switch(_filterName){
		case 'name':
			_filterProfileName = "";
		break;
		case 'job_title':
			_filterTitle = "";
		break;
		case 'email':
			_filterEmail = "";
		break;
		case 'phone':
			_filterPhone = "";
		break;
		case 'linkedin_url':
			_filterLinkedIn = "";
		break;
		case 'company_name':
			_filterCompany="";
		break;
		case 'sector':
			_filterSector=[];
		break;
		case 'cat':
			_filterCat=[];
		break;
		case 'sub_type':
			_filterSubType=[];
		break;
		case 'tech':
			_filterTechnology=[];
		break;
		case 'sub_tech':
			_filterSubTech=[];
		break;
	}
	parentTH.find('input[type="radio"]').prop('checked',false);
	parentTH.find('input[type="checkbox"]').prop('checked',false);
	parentTH.find(".list_options").find('.p-absolute').parent().hide();
	jQuery("#rs tbody").find("tr").remove();
	loadMessage("Please wait...");
	loadTableWithNewData(true,0,200);
}
function checkInputAll(o){
	_checked = false;
	_selectAll = 0;
	if(o.is(':checked')){
		_checked = true;
		_selectAll = 1;
	}
	_queryDeletion = true;
	jQuery("#rs").find('input[class="checker"]').each(function(){
		var tdL = jQuery(this).find
		jQuery(this).prop('checked',_checked);
	});
	var counter = jQuery("#rs").find('input[class="checker"]:checked').length;
	jQuery("#selected_contacts").html("Selected:"+counter);
}
function checkerSelected(){
	jQuery("#rs").find('input[class="checker"]').on('click',function(){
		if(!jQuery(this).is(':checked')){
			var checkHeader = jQuery('.fixedHeader').eq(0).find('th').eq(0).find('input[type="checkbox"]:checked');
			if(checkHeader.length>0){
				checkHeader.prop('checked',false);
			}
		}
		var counter = jQuery("#rs").find('input[class="checker"]:checked').length;
		jQuery("#selected_contacts").html("Selected:"+counter);
	});
}
function showContactsTable(){
	_tableFixedHeader = jQuery("<thead/>");
	_tableFixedHeaderTr = jQuery("<tr/>");
	jQuery.each(userColumns,function(i,c){			
		if(c=="#"){
			_tableFixedHeaderTh = jQuery("<th/>").append("<span class='colHeader'></span><input type='checkbox' onchange='checkInputAll(jQuery(this))' style='margin:0 8px 0 9px;position:relative;top:0px;'/>");
		} else {
			_filterICON = "";
			_sortICON = "";
			_class="";
			_sortName = "";
			_filterField = "";
			if(i==1 || i==2 || i==3 || i==4 || i==5 || i==6 || i==9 || i==10 || i==11 || i==12 || i==13){
				/*_filterICON = "<span class='button-list'><i class='fa fa-sort-down'></i></span>";*/
				_filterICON = "";
				_class = "filter";
			}
			if(i==1 || i==2 || i==3 || i==7 || i==13){
				_sortICON = "<span class='p-relative'><i class='icon-default p-absolute sort'></i></span>";
				if(_class==""){
					_class = "sortIcon";
				} else {
					_class = "filter-sort"
				}
			}
			if(_class=="filter" || _class=="filter-sort"){
				switch(i){
					case 1:
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><input type="text" id="search_name" placeholder="Search..." style="height:26px;min-height:26px;padding:4px 6px; color:#2b2f33;width:90%;" class="form-control pull-left"/></div></div></div>';
						_filterField = "name";
					break;
					case 2:
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><input type="text" id="search_company_field" placeholder="Search..." style="height:26px;min-height:26px;padding:4px 6px; color:#2b2f33;width:90%;" class="form-control pull-left"/></div></div></div>';
						_filterField = "company_name";
					break;
					case 3:
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><input type="text" id="search_job_title" placeholder="Search..." style="height:26px;min-height:26px;padding:4px 6px; color:#2b2f33;width:90%;" class="form-control pull-left"/></div></div></div>';
						_filterField = "job_title";
					break;
					case 4:
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><ul><li><input type="radio" name="email" value="0"/>All</li><li><input type="radio" name="email" value="1"/>Is Empty</li><li><input type="radio" name="email" value="2"/>Is not Empty</li></ul></div></div>';
						_filterField = "email";
					break;
					case 5:
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><ul><li><input type="radio" name="phone" value="0"/>All</li><li><input type="radio" name="phone" value="1"/>Is Empty</li><li><input type="radio" name="phone" value="2"/>Is not Empty</li></ul></div></div>';
						_filterField = "phone";
					break;
					case 6:
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><ul><li><input type="radio" name="linkedin_url" value="0"/>All</li><li><input type="radio" name="linkedin_url" value="1"/>Is Empty</li><li><input type="radio" name="linkedin_url" value="2"/>Is not Empty</li></ul></div></div>';
						_filterField = "linkedin_url";
					break;
					case 9:
						_list = getSectors();
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
						_filterField = "sector";
					break;
					case 10:
						_list = "";
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
						_filterField = "cat";
					break;
					case 11:
						_list = "";
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
						_filterField = "sub_type";
					break;
					case 12:
						_list = "";
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
						_filterField = "tech";
					break;
					case 13:
						_list = "";
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
						_filterField = "sub_tech";
					break;
				}
			}
			switch(i){
				case 1:
					_sortName = "name";
				break;
				case 2:
					_sortName = "company_name";
				break;
				case 3:
					_sortName = "c.job_title";
				break;
				case 7:
					_sortName = "c.create_date";
				break;
				case 8:
					_sortName = "c.note";
				break;
				case 14:
					_sortName = "c.system_update";
				break;
			}
			_tableFixedHeaderTh = jQuery("<th/>").attr('sort-name',_sortName).attr('filter-name',_filterField).append(_sortICON+"<span class='"+_class+"'>"+c+"</span>"+_filterICON);
			if(i==6){
				//_tableFixedHeaderTh.append(getCompaniesList());
			}
			/* _tableFixedHeaderTh.find('.button-list').off('click').on('click',function(){
				openFilterList(jQuery(this));
			}); */
			_tableFixedHeaderTh.find('.filter,.filter-sort').off('click').on('click',function(){
				openFilterList(jQuery(this));
			});
		}		
		_tableFixedHeaderTr.append(_tableFixedHeaderTh);
	});
	_tableFixedHeader.append(_tableFixedHeaderTr);
	_tableBody = jQuery("<tbody/>");
	jQuery.each(_companiesINString,function(i,u){
		_tableBodyTr =jQuery("<tr/>").attr('id',i);
		_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='vendor_select_bulk[]' class='checker' value='"+u.id+"'/>");
		_tableBodyTr.append(_tableBodyTd);
		_htmlName = "<a href='javascript://' onclick='window.parent.getLeadList(jQuery(this));' data-id='"+u.id+"'><i class='fa fa-play' title='My Leads'></i></a> <a href='javascript://' onclick='window.parent.editContact("+u.id+")'>"+u.name+"</a>";
		_div = jQuery("<div/>").addClass('overwrap').append(_htmlName).attr('title',u.name);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		_companyLink = "<a href='javascript://' onclick='window.parent.openCompanyEdit("+u.company_id+")'>"+u.company_name+"</a>";
		_div = jQuery("<div/>").addClass('overwrap').append(_companyLink).attr('title',u.company_name);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		
		_div = jQuery("<div/>").addClass('overwrap').append(u.title).attr('title',u.title);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		/*
		_ddive = jQuery("<span/>").append(_htmlName).css({visibility:'hidden'});
		_ddive.appendTo('body')
		_widtha = _ddive.width();
		if(_widtha>_nameWidth){
			_nameWidth = _widtha;
		}
		_ddive.remove();
		*/
		_htmlEmail = "";
		if(u.email!=""){
			_htmlEmail = '<span style="text-indent:-99999px;display:inline-block">@@</span> <i class="fa fa-envelope" style="color:#56b2fe"></i>';
		} else {
			_htmlEmail = '<span style="text-indent:-99999px;display:inline-block">-@</span>';
		}
		_tableBodyTd = jQuery("<td/>").append(_htmlEmail);
		_tableBodyTr.append(_tableBodyTd);
		_htmlPhone = "";_d =0;
		if(u.phone!=""){
			_htmlPhone = '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+u.phone+'"));\' style="color:#56b2fe"><i class="fa fa-phone fa-mobile" title="MobileTel"></i></a>';
			_d =1;
		}
		if(u.telephone!=''){
			if(_d==1){
				_htmlPhone +=", ";
			}
			_htmlPhone +=  '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+u.telephone+'"));\' style="color:green"><i class="fa fa-phone" title="DirectTel"></i></a>';
			_d =1;
		}
		if(u.company_tel!=''){
			if(_d==1){
				_htmlPhone +=", ";
			}
			_htmlPhone +=  '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+u.company_tel+'"));\' style="color:green"><i class="fa fa-phone fa-phone-square" title="CompanyTel"></i></a>';
			_d =1;
		}
		_tableBodyTd = jQuery("<td/>").append(_htmlPhone);
		_tableBodyTr.append(_tableBodyTd);
		_htmlUrl = "";
		if(u.linkedin_url!=""){
			_htmlUrl = '<span style="text-indent:-99999px;display:inline-block">#</span><a href="'+u.linkedin_url+'" target="_blank"><i class="fa fa-linkedin" style="color:#56b2fe"></i></a>';
		} else {
			_htmlUrl = '<span style="text-indent:-99999px;display:inline-block">-#</span>';
		}
		_tableBodyTd = jQuery("<td/>").append(_htmlUrl);
		_tableBodyTr.append(_tableBodyTd);
		
		
		/*
		_ddive = jQuery("<span/>").append(u.company_name).css({visibility:'hidden'});
		_ddive.appendTo('body')
		_widtha = _ddive.width();
		if(_widtha>_companyWidth){
			_companyWidth = _widtha;
		}
		_ddive.remove();
		*/
		_tableBodyTd = jQuery("<td/>").append(u.create_date);
		_tableBodyTr.append(_tableBodyTd);
		_div = jQuery("<div/>").addClass('overwrap').append(u.note).attr('title',u.note);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		_div = jQuery("<div/>").addClass('overwrap').append(u.sectors).attr('title',u.sectors);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		_div = jQuery("<div/>").addClass('overwrap').append(u.categories).attr('title',u.categories);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		_div = jQuery("<div/>").addClass('overwrap').append(u.sub_category).attr('title',u.sub_category);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		_div = jQuery("<div/>").addClass('overwrap').append(u.technolgies).attr('title',u.technolgies);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		_div = jQuery("<div/>").addClass('overwrap').append(u.sub_technolgies).attr('title',u.sub_technolgies);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.system_date);
		_tableBodyTr.append(_tableBodyTd);
		_tableBody.append(_tableBodyTr);
	});
	var minHandsTable = jQuery("<table/>").addClass('table tableData').attr('id','rs');
	var minHandsTableFixed = jQuery("<table/>").addClass('table fixedHeader').append(_tableFixedHeader);
		minHandsTable.append(_tableBody);
	_headerDiv = jQuery('<div/>').addClass('containerResearchHeader').append(minHandsTableFixed);
	_bodyDiv = jQuery('<div/>').addClass('containerResearchBody dragscroll').append(minHandsTable);
	jQuery(minTable).empty().append(_headerDiv).append(_bodyDiv);
	_extraWidth = 0;
	_checkNavi = window.navigator;
	if(_checkNavi.platform.indexOf('Win')>=0){
		_extraWidth = 17;
	}	
	jQuery(minTable).find('div.containerResearchHeader').css("width",jQuery(minTable).find('div.containerResearchHeader').width()-_extraWidth);
	setTimeout(function(){resizeTable(1);setTimeout(function(){
		_getHeight = jQuery('.scroll-container').height();
		_calHeader = jQuery(minTable).find('div.containerResearchHeader').height();
		console.log(newHeight,_calHeader);
		_calHeight = _getHeight - _calHeader;
		jQuery(minTable).find('div.containerResearchBody').css("height",_calHeight+"px");
	});},100);
	
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
var _nameWidth = 150, _companyWidth = 200;
function resizeTable(t){
	var tableResearcherT = jQuery(minTable).find('table.tableData');
	var tableResearcherFixed = jQuery(minTable).find('table.fixedHeader');
		tableResearcherThead = tableResearcherFixed.find('tr');
		tableResearcherTbody = tableResearcherT.find('tbody tr');
		j=0;
		tableResearcherTbody.eq(0).find('td').each(function(i,th){
			var outerWidthTF = jQuery(this).outerWidth();
			width = outerWidthTF;
			switch(i){
				case 0:
					width = 30;
					break;
				case 1:
					width = 200;
					break;
				case 3:
					width = 400;
					break;
				case 2:
					width = 250;
					break;
				case 4:
				case 5:
				case 6:
					width = 50;
					break;
				case 7:
					width = 70;
					break;
				case 8:
					width = 250;
					break;
				case 9:
					width = 150;
					break;
				case 10:
					width = 150;
					break;
				case 11:
					width = 150;
					break;
				case 12:
					width = 120;
					break;
				case 13:
					width = 150;
					break;
				case 14:
					width = 70;
					break;
			}
			tableResearcherThead.find('th').eq(i).css({width:width+"px",minWidth:width+"px",maxWidth:width+"px"});
			/*if(i==0){
				width +=1; 
			}*/
			jQuery(this).css({width:width+"px",minWidth:width+"px",maxWidth:width+"px",wordBreak:'break-all'});
			j++;
		});
		tableResearcherT.css({tableLayout:'fixed',wordBreak:'break-all'});
		tableResearcherFixed.css({tableLayout:'fixed',wordBreak:'break-all'});
		if(t==1){setTimeout(scrollSynchronize,100);sortTables();}
}
var lastScroll = 0;
var checkS = 1000;
var checkD = 0;
function scrollSynchronize(){
	var $childE = jQuery("#companies_box").find("div.containerResearchBody");
	var $childEH = jQuery("#companies_box").find("div.containerResearchHeader");
	if($childE.length>0){		
		$childE.off('scroll').on('scroll',function(){
			var left = $childE.scrollLeft();
				$childEH.scrollLeft(left);
				if(jQuery('.fixedHeader').find('th.n').length>0){
					jQuery('.fixedHeader').find('th.n').each(function(){
						_position = jQuery(this).position();
						jQuery(this).find(".list_options").find('.p-absolute').css({left:_position.left});
					});
				}
			scrollAmount  = $('.containerResearchBody').scrollTop();
					documentHeight  = $("#rs").height();
					scrollPercent = (scrollAmount / documentHeight) * 100;
			if(($childE.scrollTop()>lastScroll || $childE.scrollTop()==lastScroll) && $childE.scrollTop()!=0 && lastScroll!=0){
				if($childE.scrollTop()>checkS){
					if(scrollPercent > 50) {
						checkScroll(true);
					}
				}
			} else {
				if(lastScroll>$childE.scrollTop()){
					var checkPos = $childE.find('tbody tr').eq(125).position();
					try{
						if(scrollPercent < 30) {
							checkScroll(false);
						}
					}catch(e){}
				}else if(lastScroll==0 && $childE.scrollTop()==0){
					firstID = jQuery("#rs").find('tbody tr').eq(0).attr('id');
					if(parseInt(firstID)!=0){
						console.log("F");
						checkScroll(false);
					} else {
						console.log("F1");
					}
				}
			} 
			lastScroll = $childE.scrollTop();
		})
	} else {
		setTimeout(function(){scrollSynchronize();},300);
	}
}
__totalRecords = 4000;
__baseUrl = '<?php echo $Layout->baseUrl?>';
_requestAlreadySend = false;
function checkScroll(s){
	var elBoundery = jQuery("#rs").find('tbody tr');
	var tapC = false;
	if(s===true){ 
		var ID = elBoundery.eq(elBoundery.length-1).attr('id');
		ID = parseInt(ID);
		ID +=1;
		if(ID< __totalRecords){
			_start = ID;
			_end = 500;
			tapC = true;
		}
	} else {
		var ID = elBoundery.eq(0).attr('id');
		if(parseInt(ID)>0){
			_end = parseInt(ID);
			_start = _end - 500;
			if(_end>500){
				_end = 500;	
			}		
			if(_start<0){
				_start = 0;
			}
			tapC = true;
		}		
	}
	if(typeof _start!="undefined" && typeof _end!="undefined" && tapC===true){
		loadTableWithNewData(s,_start,_end);
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
_sortField = "c.system_update";
_sortBy = "DESC";
var _filterEmail="",_filterPhone="",_filterLinkedIn = "",_filterCompany="",_filterSector=[],_filterTechnology=[],_filterCat=[],_filterSubType=[],_filterSubTech=[],_filterProfileName="",_filterTitle="";
function loadTableWithNewData(t,start,end){
	p = 500;
	if(_requestAlreadySend===false){
		_requestAlreadySend = true;
		_url = __baseUrl+'opportunity/contact/ajax/'+p;
		_filters = {lead_id:jQuery("#profileLead").val(),search:jQuery('#search_field').val(),s:_filterSector,cat:_filterCat,sst:_filterSubType,t:_filterTechnology,st:_filterSubTech,start:start,end:end,sort_field:_sortField,sort_by:_sortBy,filterEmail:_filterEmail,filterPhone:_filterPhone,filterLinkedIn:_filterLinkedIn,filterCompany:_filterCompany,filterProfileName:_filterProfileName,filterTitle:_filterTitle};
		jQuery.ajax({
			type:"POST",
			url:_url,
			data:_filters,
			cache:false,
			dataType:'json',
			success:function(b){				
				loadMessage("");
				var elBoundery = jQuery("#rs").find('tbody tr');
				if(t===true){
					if(jQuery("#rs tr").length>0){
						_increment = jQuery("#rs tr").eq(jQuery("#rs tr").length-1).attr('id');
						_increment = parseInt(_increment);
						_increment +=1;
					} else {
						_increment = 0;
					}
					if(jQuery("#rs tr").length>450){
						elBoundery.slice(0,200).remove();
					}
				} else {
					if(jQuery("#rs tr").length>0){
						_increment = jQuery("#rs tr").eq(0).attr('id');
						_increment = parseInt(_increment);
						_increment = _increment - 1;
					} else {
						_increment = 0;
					}
					if(jQuery("#rs tr").length>450){
						elBoundery.slice(-200).remove();
					}
				}
				_companiesINString=[];
				if(typeof b.result!="undefined"){
					__totalRecords = b.result;
				}
				jQuery("#noOfRecords").html(formatter.format(__totalRecords));
				if(_filterSector.length>0){
					if(typeof b.categories!="undefined"){
						if(jQuery('.fixedHeader thead th').eq(9).find('.list_options').find('.list').find('.open_list').length==0){
							jQuery('.fixedHeader thead th').eq(9).find('.list_options').find('.list').empty();
							if(b.categories.length>0){
								var _selectUl = jQuery("<ui/>").addClass('open_list');
								jQuery.each(b.categories,function(i,s){
									var _selectLi = jQuery("<li/>").css({'float':'left',width:'100%'});
									var _input = jQuery("<input/>").attr("type","checkbox").attr("value",s.id);
									var spanX = jQuery("<span/>").css('float','left');
									spanX.append(_input);
									var spanY = jQuery("<span/>").append(s.name);
									_selectLi.append(spanX).append(spanY);
									_selectUl.append(_selectLi);
								});
								jQuery('.fixedHeader thead th').eq(9).find('.list_options').find('.list').append(_selectUl);
							}
						}						
					}
				}
				if(_filterCat.length>0){
					if(typeof b.sub_type!="undefined"){
						if(jQuery('.fixedHeader thead th').eq(10).find('.list_options').find('.list').find('.open_list').length==0){
							jQuery('.fixedHeader thead th').eq(10).find('.list_options').find('.list').empty();
							if(b.sub_type.length>0){
								var _selectUl = jQuery("<ui/>").addClass('open_list');
								jQuery.each(b.sub_type,function(i,s){
									var _selectLi = jQuery("<li/>").css({'float':'left',width:'100%'});
									var _input = jQuery("<input/>").attr("type","checkbox").attr("value",s.id);
									var spanX = jQuery("<span/>").css('float','left');
									spanX.append(_input);
									var spanY = jQuery("<span/>").append(s.name);
									_selectLi.append(spanX).append(spanY);
									_selectUl.append(_selectLi);
								});
								jQuery('.fixedHeader thead th').eq(10).find('.list_options').find('.list').append(_selectUl);
							}
						}						
					}
				}
			
				/*if(_filterSector.length>0){
					if(typeof b.tech!="undefined"){
						if(jQuery('.fixedHeader thead th').eq(11).find('.list_options').find('.list').find('.open_list').length==0){
							jQuery('.fixedHeader thead th').eq(11).find('.list_options').find('.list').empty();
							if(b.tech.length>0){
								var _selectUl = jQuery("<ui/>").addClass('open_list');
								jQuery.each(b.tech,function(i,s){
									var _selectLi = jQuery("<li/>").css({'float':'left',width:'100%'});
									var _input = jQuery("<input/>").attr("type","checkbox").attr("value",s.id);
									var spanX = jQuery("<span/>").css('float','left');
									spanX.append(_input);
									var spanY = jQuery("<span/>").append(s.name);
									_selectLi.append(spanX).append(spanY);
									_selectUl.append(_selectLi);
								});
								jQuery('.fixedHeader thead th').eq(11).find('.list_options').find('.list').append(_selectUl);
							}
						}
					}
				}*/
				if(_filterTechnology.length>0){
					if(typeof b.sub_type!="undefined"){
						_addList = true;
						if(jQuery('.fixedHeader thead th').eq(12).find('.list_options').find('.list').find('.open_list').length>0){
							if(jQuery('.fixedHeader thead th').eq(12).find('.list_options').find('.list').find('.open_list').find('input[type="checkbox"]:checked').length>0){
								_addList = false;
							}
						}
						if(_addList===true){
							jQuery('.fixedHeader thead th').eq(12).find('.list_options').find('.list').empty();
							if(b.sub_type.length>0){
								var _selectUl = jQuery("<ui/>").addClass('open_list');
								jQuery.each(b.sub_type,function(i,s){
									var _selectLi = jQuery("<li/>").css({'float':'left',width:'100%'});
									var _input = jQuery("<input/>").attr("type","checkbox").attr("value",s.id);
									var spanX = jQuery("<span/>").css('float','left');
									spanX.append(_input);
									var spanY = jQuery("<span/>").append(s.name);
									_selectLi.append(spanX).append(spanY);
									_selectUl.append(_selectLi);
								});
								jQuery('.fixedHeader thead th').eq(12).find('.list_options').find('.list').append(_selectUl);
							}
						}						
					}
				}
				if(typeof b.contacts!="undefined" && b.contacts.length>0){
					_data = b.contacts;
					let companyID = 0;
					let _date = "";
					let _create_date = "";
					let _note = "";
					let name = "";
					for(i=0;i<_data.length;i++){
						companyID = 0;
						_entry = true;
						if(_entry===true){	
							name = _data[i].first_name+' '+_data[i].last_name;
							_sectorName = _data[i].sectorName;
							if(_sectorName==null){
								_sectorName='';
							}
							_categories = _data[i].department_names;
							if(_categories==null){
								_categories='';
							}
							_sub_categories = _data[i].sub_department_names;
							if(_sub_categories==null){
								_sub_categories='';
							}							
							object = {};
							object.id = _data[i].id;
							object.first_name = jQuery.trim(_data[i].first_name);
							object.last_name = jQuery.trim(_data[i].last_name);
							object.name = jQuery.trim(name);
							object.company_name = _data[i].company_name;
							if(typeof _data[i].company_id != "undefined"){
								companyID = _data[i].company_id;
							} else if(typeof _data[i].companyID != "undefined"){
								companyID = _data[i].companyID;
							}
							object.company_id = _data[i].companyID;
							object.gateway = _data[i].gateway;
							object.title = _data[i].job_title;
							object.email = _data[i].email;
							object.phone = _data[i].phone;
							object.telephone = _data[i].telephone;
							object.company_tel = _data[i].company_tel;
							object.linkedin_url = _data[i].linkedin_url;
							_note = _data[i].note;
							_note = _note.toString();
							_note = _note.replace('\n',' ');
							_note = _note.replace('\r',' ');
							_note = _note.replace('\\r',' ');
							_note = _note.replace('\\n',' ');
							_date = _data[i].system_update;
							if(_date!="0000-00-00 00:00:00"){
								_date = moment(new Date(_date)).format('MM/DD/YYYY');
							} else {
								_date = '';
							}	
							_create_date = _data[i].create_date;
							if(_create_date!="0000-00-00 00:00:00"){
								_create_date = moment(new Date(_create_date)).format('MM/DD/YYYY');
							} else {
								_create_date = '';
							}
							object.create_date = _create_date;	
							object.note = _note;
							object.sectors = _sectorName;
							object.categories = _categories;
							object.sub_category = _sub_categories;
							object.technolgies = _data[i].technology_names;
							object.sub_technolgies = _data[i].sub_technology_names;
							object.selected = "no";
							object.system_date = _date;
							_companiesINString.push(object);
						}
					}
					if(t===false){
						_companiesINString.reverse();
					}
					let _tableBodyTr = "";
					jQuery.each(_companiesINString,function(i,u){
						 _tableBodyTd = "<td><input type='checkbox' name='vendor_select_bulk[]' class='checker' value='"+u.id+"'/></td>";
						
						_htmlName = "<a href='javascript://' onclick='window.parent.getLeadList(jQuery(this));' data-id='"+u.id+"'><i class='fa fa-play' title='My Leads'></i></a> <a href='javascript://' onclick='window.parent.editContact("+u.id+")'>"+u.name+"</a>";
						_div = "<div class='overwrap' title='"+u.name+"'>"+_htmlName+"</div>";
						_tableBodyTd += "<td>"+_div+"</td>";

						_companyLink = "<a href='javascript://' onclick='window.parent.openCompanyEdit("+u.company_id+")'>"+u.company_name+"</a>";
						_div = "<div class='overwrap' title='"+u.company_name+"'>"+_companyLink+"</div>";
						_tableBodyTd += "<td>"+_div+"</td>";
						
						_div = "<div class='overwrap' title='"+u.title+"'>"+u.title+"</div>";
						_tableBodyTd += "<td>"+_div+"</td>";
						/*
						_ddive = jQuery("<span/>").append(_htmlName).css({visibility:'hidden'});
						_ddive.appendTo('body')
						_widtha = _ddive.width();
						if(_widtha>_nameWidth){
							_nameWidth = _widtha;
						}
						_ddive.remove();
						*/
						_htmlEmail = "";
						if(u.email!=""){
							_htmlEmail = '<span style="text-indent:-99999px;display:inline-block">@@</span> <i class="fa fa-envelope" style="color:#56b2fe"></i>';
						} else {
							_htmlEmail = '<span style="text-indent:-99999px;display:inline-block">-@</span>';
						}
						_tableBodyTd += "<td>"+_htmlEmail+"</td>";
						
						_htmlPhone = "";_d =0;
						if(u.phone!=""){
							_htmlPhone = '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+u.phone+'"));\' style="color:#56b2fe"><i class="fa fa-phone fa-mobile" title="MobileTel"></i></a>';
							_d =1;
						}
						if(u.telephone!=''){
							if(_d==1){
								_htmlPhone +=", ";
							}
							_htmlPhone +=  '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+u.telephone+'"));\' style="color:green"><i class="fa fa-phone" title="DirectTel"></i></a>';
							_d =1;
						}
						if(u.company_tel!=''){
							if(_d==1){
								_htmlPhone +=", ";
							}
							_htmlPhone +=  '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+u.company_tel+'"));\' style="color:green"><i class="fa fa-phone fa-phone-square" title="CompanyTel"></i></a>';
							_d =1;
						}
						_tableBodyTd += "<td>"+_htmlPhone+"</td>";
						_htmlUrl = "";
						if(u.linkedin_url!=""){
							_htmlUrl = '<span style="text-indent:-99999px;display:inline-block">#</span> <i class="fa fa-linkedin" style="color:#56b2fe"></i>';
						} else {
							_htmlUrl = '<span style="text-indent:-99999px;display:inline-block">-#</span>';
						}
						
						_tableBodyTd += "<td>"+_htmlUrl+"</td>";
						
						/*
						_ddive = jQuery("<span/>").append(u.company_name).css({visibility:'hidden'});
						_ddive.appendTo('body')
						_widtha = _ddive.width();
						if(_widtha>_companyWidth){
							_companyWidth = _widtha;
						}
						_ddive.remove();
						*/
						_tableBodyTd += "<td>"+u.create_date+"</td>";
						
						_div = "<div class='overwrap' title='"+u.note+"'>"+u.note+"</div>";
						_tableBodyTd += "<td>"+_div+"</td>";
						
						_div = "<div class='overwrap' title='"+u.sectors+"'>"+u.sectors+"</div>";
						_tableBodyTd += "<td>"+_div+"</td>";
						
						_div = "<div class='overwrap' title='"+u.categories+"'>"+u.categories+"</div>";
						_tableBodyTd += "<td>"+_div+"</td>";
						
						_div = "<div class='overwrap' title='"+u.sub_category+"'>"+u.sub_category+"</div>";
						_tableBodyTd += "<td>"+_div+"</td>";
						
						_div = "<div class='overwrap' title='"+u.technolgies+"'>"+u.technolgies+"</div>";
						_tableBodyTd += "<td>"+_div+"</td>";
						
						_div = "<div class='overwrap' title='"+u.sub_technolgies+"'>"+u.sub_technolgies+"</div>";
						_tableBodyTd += "<td>"+_div+"</td>";
						_tableBodyTd += "<td>"+u.system_date+"</td>";
						
						if(t===true){
							_tableBodyTr += "<tr id='"+_increment+"' >"+_tableBodyTd+"</tr>";
						} else {
							_tableBodyTr = "<tr id='"+_increment+"' >"+_tableBodyTd+"</tr>"+_tableBodyTr;
						}
						
						if(t===true){
						_increment++;
						}else{
							_increment--;
						}
					});
					if(t===true){
						jQuery("#rs tbody").append(_tableBodyTr);
					} else {
						if(jQuery("#rs tbody tr").length>0){
							jQuery("#rs tbody tr").eq(0).before(_tableBodyTr);
						} else {
							jQuery("#rs tbody").append(_tableBodyTr);
						}				
					}
					setTimeout(function(){_requestAlreadySend = false;},1000);
					resizeTable(0);
					/*if(t===true){
						var $childE = jQuery("#companies_box").find("div.containerResearchBody");
						var tableHeight = jQuery("#rs").height() - 673;
						calcHe = tableHeight - $childE.scrollTop();
						checkD = calcHe/2;
						console.log('DSS:'+checkD);
					}*/
					checkerSelected();
				} else {
					loadMessage("No record found..");
					setTimeout(function(){	_requestAlreadySend = false;},1000);
				}
			}
		}).always(function(){
			loadMessage("");
			if(initialCall===false){
				initialCall = true;
				callLeadData();
			}
		});
	}
}
function callLeadData(){
	jQuery.ajax({
		url:__baseUrl+'opportunity/getListOfActiveLeads',
		dataType: "json",
	}).done(function(list){
		jQuery.map(list,function(l,index){
			_selected = "";
			jQuery("#profileLead").append("<option value='"+l.id+"' "+_selected+">"+l.lead_name+"</option>");
		});
	}).always(function(){
		findMarketSectors();
	});
}
function findMarketSectors(){
	jQuery.ajax({
		url: __baseUrl+'opportunity/getAllMarketSectors',
		dataType:'json'
	}).done(function(d){
		if(d.length>0){
			_sectors = d;
			_unclassify = {id:'Unclassify',name:'Unclassify'};
			_sectors.splice(0,0,_unclassify);
			_selectUl = getSectors();
			jQuery(".fixedHeader").find('thead th').eq(8).find('.list_options').find('.list').empty();				
			jQuery('.fixedHeader thead th').eq(8).find('.list_options').find('.list').append(_selectUl);
		}
	}).always(function(){
		findTechnologies();
	});
}
function sortTables(){
	jQuery('.sort').off('click').on('click',function(){
		_sortBy = 'ASC';
		if(jQuery(this).hasClass('icon-asc')){
			_sortBy = 'DESC';
		}
		var $this = jQuery(this);
		_parentThIndex = $this.parents('th').index();
		_sortField = $this.parents('th').attr('sort-name');
		if(_sortBy=='ASC'){
			$this.removeClass('icon-default').removeClass('icon-desc').addClass('icon-asc');
		} else {
			$this.removeClass('icon-default').addClass('icon-desc').removeClass('icon-asc');
		}		
		jQuery("#rs tbody").find("tr").remove();
		loadTableWithNewData(true,0,200);
	});
}
function findCompaniesInLead(o){
	jQuery("#rs tbody").find("tr").remove();
	loadTableWithNewData(true,0,200);
}
_spreadsheet=[];
function getFillHoleContacts(){
	if(jQuery('#rs tbody tr').find('input[type="checkbox"]:checked').length>0){	
		_spreadsheet=[];
		jQuery('#rs tbody tr').find('input[type="checkbox"]:checked').each(function(){
			var $this = jQuery(this).parent().parent();
			
			_spreadRows={};
			_first_name= $this.find('td').eq(1).attr('data-attr-first');
			_last_name= $this.find('td').eq(1).attr('data-attr-last');
			_title = $this.find('td').eq(5).text();
			_companyName = $this.find('td').eq(6).text();
			_telephone="";
			_companyphone="";
			_phone = "";
			_id= jQuery(this).attr('value');
			if($this.find('td').eq(5).find('a>i.icon-phone').length>0){
				if($this.find('td').eq(5).find('a.phone').length>0){
					_phone = $this.find('td').eq(5).find('a.phone').parent().attr('data-phone');
				}
				if($this.find('td').eq(5).find('a.telephone').length>0){
					_telephone = $this.find('td').eq(5).find('a.telephone').parent().attr('data-telephone');
				}	
				if($this.find('td').eq(5).find('a.companyphone').length>0){
					_companyphone = $this.find('td').eq(5).find('a.companyphone').parent().attr('data-companyphone');
				}				
			}
			if($this.find('td').eq(4).find('a.email').length>0){	
				_email= _checkObject.attr('data-attr-em');
			}		
			if($this.find('td').eq(6).find('a.linkedin').length>0){	
				_linkedin= _checkObject.attr('data-attr-linkedin');
			}
			if(_email=="undefined" || _email==undefined){
				_email='';
			} else if(_email!=""){
				_email = "Client Property";
			}
			if(_linkedin=="undefined" || _linkedin==undefined){
				_linkedin='';
			} else if(_linkedin!=""){
				_linkedin = "Client Property";
			}
			if(_name=="undefined" || _name==undefined){
				_name='';
			}
			if(_first_name=="undefined" || _first_name==undefined){
				_first_name='';
			}
			if(_last_name=="undefined" || _last_name==undefined){
				_last_name='';
			}
			if(_title=="undefined" || _title==undefined){
				_title='';
			}
			if(_companyphone=="undefined" || _companyphone==undefined){
				_companyphone='';
			} else if(_companyphone!=""){
				_companyphone = "Client Property";
			}
			if(_telephone=="undefined" || _telephone==undefined){
				_telephone='';
			} else if(_telephone!=""){
				_telephone = "Client Property";
			}
			if(_phone=="undefined" || _phone==undefined){
				_phone='';
			} else if(_phone!=""){
				_phone = "Client Property";
			}
			if(_id>0 && _name!="" && _name!="undefined" && _name!=undefined){
				_spreadRows.first_name = _first_name;
				_spreadRows.last_name = _last_name;
				_spreadRows.job_title = _title;
				_spreadRows.company_name = _companyName;
				_spreadRows.phone = _phone;
				_spreadRows.telephone = _telephone;
				_spreadRows.companyphone = _companyphone;
				_spreadRows.email = _email;
				_spreadRows.linkedin_url = _linkedin;
				_spreadRows.id = _id;					
				_spreadsheet.push(_spreadRows);
			}
		});
		if(_spreadsheet.length>0){	
			window.parent._spreadsheet = _spreadsheet;
			var h = $(window).height();m = h-100;		
			window.parent.jQuery("body").append('<div class="modal-backdrop modal-backdrop-drive"></div>'); 
			window.parent.openSlidebar(jQuery("#datafills_slider"));
			window.parent.changeSlidebarWidthOnfly('datafills_slider',100);
			window.parent.jQuery("#datafills_slider").find('.df_fill_holes').empty().append("<iframe src='"+__baseUrl+"opportunity/create_df_hole' style='height:"+m+"px;width:100%;'></iframe>");
		} else {
			alert("Please select contacts first.");
		}
	}
}
function openAddForm(){
	window.parent.openContactEditForm(0);
}

_type = 0;
<?php 
	if(count($this->session->userdata)>0 && isset($this->session->userdata['type'])){
?>
	 _type = <?php echo $this->session->userdata['type'];?>;
<?php
	}
?>
function deleteGoogleContact(contactID){
	if(parseInt(_type)==9){
		res = confirm("Are you sure?");
		if(res){
			loadMessage("Loading..");
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $this->config->base_url();?>opportunity/deleteContact',
				data:{delete_link:contactID},
				cache:false,
				success:function(data){
					loadMessage("");
					window.location = window.location.href;						
				}
			});
		}
	} else {
		alert("You are not authorize for delete contact.");
	}
}
function loadMessage(message){
	jQuery("#loading_message").html(message);
}
function deleteSelectedContacts(){
_idS = [];
_getData = jQuery("#rs").find('input[type="checkbox"]:checked');
jQuery.each(_getData,function(index,c){
	_idS.push(jQuery(c).val());				
});
if(_idS.length>0){
	loadMessage("Loading..");
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/deleteContactsInBatch',
		data:{c:JSON.stringify(_idS)},
	}).done(function(d){
		loadMessage("");
		if(d=='-1'){
			alert("Some correspondense with this contact.");
		} else {
			jQuery("#rs").find('input[type="checkbox"]:checked').parent().parent().remove();
		}
	});
} else {
	alert('Please select contact first');
}
}
</script>
</body>