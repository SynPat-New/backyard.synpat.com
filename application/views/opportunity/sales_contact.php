<?php /*
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/modal/modal.css">
*/?>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>views/contact/contact_min.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/slimscroll/slimscroll.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/modal/modal.js"></script>
<!--<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>jquery.tablesorter.min.js"></script> -->
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>widgets/jquery.tablesorter.min.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>nestable.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/menu.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/autocomplete.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>jquery.nestable.js"></script>
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
	
	a{text-decoration:none;}h4{font-size:16px;font-weight:300;margin:0}
	
	.mrg5R{margin-right:5px;}
	.scroll-container {
	width: 100%;
	height: 250px;
	margin: 5px 0;
	overflow: hidden;
}
.ui-menu-item{list-style:none;padding:10px;border:1px solid #56b2fe;margin-bottom:3px;}
	.ui-menu-item:hover{background-color:#56b2fe;color:#fff;}	
	.ui-helper-hidden-accessible{display:none;}
	.ui-autocomplete {
	padding:0px;margin:0px;
    /*max-height: 400px;*/
    overflow-y: auto;
    overflow-x: hidden;background:#fff;width:300px !important;
  }
.containerResearchHeader, .containerHeader{width:100%;overflow:hidden;}
.containerResearchBody, .containerBody{width:100%;height:250px;overflow:scroll;}
.dt{
    font-size: 13px;
    width: 100%;
    border-spacing: 0;
    border-collapse: separate;
}
table.fixedHeader, table.tableData{border:0px;}
table.fixedHeader th{border:0px !important;border-right:solid 1px #dfe8f1 !important}
table.tableData td{border-top:0px !important;border-right:0px !important;height:30px;min-height:30px;}
table.tableData tr.master td:last-child{border-right:solid 1px #dfe8f1 !important;}
.button-list{border:1px solid #dfe8f1;padding:0px 0px 0px 0px;cursor:pointer;float:right;}
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
.containerResearchHeader .table > thead > tr > th:first-child{
	border-left: solid 1px #dfe8f1 !important;
}
.containerResearchHeader .table > thead > tr > th:last-child{
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
 table.sbo,table.sbo thead th,table.sbo tbody td, table.sbo tbody td:last-child{border:0px !important;}
 i.fa{width:13px;height:13px;}
 tr.cu td{padding:0px !important;}
 tr.cu table.sbo thead th, tr.cu table.sbo tbody td{/*border-bottom:1px solid #dfe8f1  !important;border-right:1px solid #dfe8f1 !important;*/}
 tr.cu table.sbo thead th, tr.cu table.sbo tbody td{padding:4px !important;}
 tr.cu table.sbo thead th{cursor:pointer;}
 tr.cu table.sbo thead th:last-child, tr.cu table.sbo tbody td:last-child{border-right:0px !important;}
 tr.cu table.sbo thead th.tablesorter-headerDesc{background: url(http://backyard.synpat.com/public/images/sort_desc.png);    background-repeat: no-repeat;background-position: right;background-color: #fff;}
tr.cu table.sbo thead th.tablesorter-headerAsc{background: url(http://backyard.synpat.com/public/images/sort_asc.png);    background-repeat: no-repeat;background-position: right;background-color: #fff;}tr.boldT td{font-weight:bold;}
.fa{margin-left:5px;}
:focus{outline:none;}
div.overwrap {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 30px;
}
.nested-list-item .dd-handle {
    width: 22px;
    padding-left: 3px;
    background: none !IMPORTANT;
    border: 0;
    padding-right: 0;
}
div.nested-list-content .listbox{
	display: inline;
    margin-left: 10px;
    line-height: 10px;
}
div.nested-list-content {
    font-weight: normal;
    background: none;
    border: 0;
    border-bottom: 1px solid rgba(204, 204, 204, 0.2);
    padding-left: 25px;
}
.modal-dialog{width:750px;}
.css-label1>a,.css-label3>a{color:#56b2fe;}
.dd-item > button[data-action="cancel"]:before{content:'';}
.dd-item >button[data-action="expand"],.dd-item >button[data-action="collapse"]{top:2px;}
input[type=checkbox].css-checkbox, input[type=checkbox].css-checkbox-1, input[type=checkbox].css-checkbox-2, input[type=checkbox].css-checkbox-3 {
    position: absolute;
    overflow: hidden;
    clip: rect(0 0 0 0);
    height: 1px;
    width: 1px;
    margin: -1px;
    padding: 0;
    border: 0;
}
input[type=checkbox].css-checkbox:checked + div.listbox > span.css-label, input[type=checkbox].css-checkbox-1:checked + div.listbox > span.css-label1,input[type=checkbox].css-checkbox-2:checked + div.listbox > span.css-label2,input[type=checkbox].css-checkbox-3:checked + div.listbox > span.css-label3 {
    background-position: 0 -15px;
}
input[type=checkbox].css-checkbox  + div.listbox > span.css-label,input[type=checkbox].css-checkbox-1  + div.listbox > span.css-label1,input[type=checkbox].css-checkbox-2  + div.listbox > span.css-label2,input[type=checkbox].css-checkbox-3  + div.listbox > span.css-label3 {
    padding-left: 20px;
    height: 15px;
    display: inline-block;
    line-height: 15px;
    background-repeat: no-repeat;
    background-position: 0 0;
    font-size: 15px;
    vertical-align: middle;
    cursor: pointer;
}
input[type=checkbox].css-checkbox-1  + div.listbox > span.css-label1,input[type=checkbox].css-checkbox-3  + div.listbox > span.css-label3{
	font-size:13px;
}
.lite-gray-check {
    background-image: url(https://storage.googleapis.com/static.synpat.com/backyard/images/lite-gray-check.png);
}
.black-check {
    background-image: url(https://storage.googleapis.com/static.synpat.com/backyard/images/chrome-style.png);
}
.edit-btn{text-decoration:none;}
.sub-child .edit-btn{font-style:italic;color:red;}
#noOfRecords{padding-top:10px;padding-left:20px;color:red;}
/*contact page*/  
.contactsmenu a.btn{
    margin-bottom: 5px !important;             
}
body .contacttopbar .form-control, .contacttopbar select {
    height: auto;
    margin-bottom: 5px;
    max-width: 100%;
    min-width: 100%;
    padding: 8px 2% !important;
    width: 96%!important;   
    box-sizing: border-box;
}   
body .contacttopbar .col-md-4 span{
	width: 100% !important;
}
body .contacttopbar .col-md-4 span span.ui-state-default {
    box-sizing: border-box;
    height: 36px;
    line-height: 33px;
    margin-bottom: 5px;
    padding: 0 2%!important;
    width: 99.5%!important;
}

</style>
<div id="classify" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Classification</h4>
      </div>
      <div class="modal-body">
        <div class="row">
			<form id="frmClassification">
				<div class="col-sm-12">
					<div class="col-xs-5"><button type="button" class='action-menu' data-type='sector' data-action="expand-all" style='background:none !important;border:1px solid #efefef !important; font-size:17px;font-weight:bold;cursor:pointer;' >+</button></div>
					<div class="col-xs-7"><button type="button" class='action-menu' data-type='technology' data-action="expand-all" style='background:none !important;border:1px solid #efefef !important; font-size:17px;font-weight:bold;cursor:pointer;' >+</button></div>
				</div>
				<div class="col-xs-6" style='height:485px;overflow:auto'>
					<div class="dd" id="nestable"><?php echo buildCompanyMenu(0);?></div>
				</div>
				<div class="col-xs-6" style='height:485px;overflow:auto'>
					<div class="dd types" id="nestable1"><?php echo buildTechnologyMenu(0);?></div>
				</div>
				<div class="col-sm-12" id='loading' style='display:none;'>
					Loading......
				</div>
				<input type="hidden" id="companies_sel" name="companies_sel" value=""/>
				<input type="hidden" id="mode" name="mode" value="0"/>
			</form>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" id='btnAddClassify' class="btn btn-primary" onclick="addSelectedCompanyToSector()">Add</button>
      </div>
    </div>

  </div>
</div>



<h4 id='cn'>Companies  <span id='loading_message' style='margin-left:100px'></span></h4>
<div class="row mainT">	
	<div class="col-xs-12" style='width:100%;'>		
		<div class="row btnList" style='margin-bottom:10px;'>
			<div class="col-xs-12">
				<a href='javascript://' onclick="window.parent.openCompanyEdit(0);" class='btn btn-primary pull-left mrg5R'>Add a Company</a>
				<a href='javascript://' onclick="mergeCompanies()" class='btn btn-primary pull-left mrg5R'>Merge</a>
				<a href='javascript://' onclick="emailScrapeAllSelectedCompanies()" class='btn btn-primary pull-left mrg5R'>GetEmail</a>				
				<a href='javascript://' onclick="scrapeAllSelectedCompanies()" class='btn btn-primary pull-left mrg5R'>Scrape</a>
				<a href='javascript://' onclick="deleteSelectedCompanies()" class='btn btn-primary pull-left mrg5R'>Delete</a>
				<a href='javascript://' onclick="openClassify()" class='btn btn-primary pull-left mrg5R'>Classify</a>
				<div class="col-xs-2" >
					<input type='text' placeholder='Search...' id='search_field' style='height:26px;min-height:26px;padding:4px 6px; color:#2b2f33;' name='search_field' class='form-control pull-left'/>
				</div>
				<div class="col-xs-2" >
					<div class="form-group input-string-group" style='border:0px;margin-bottom:0px;'>
						<select name="profile[lead]" id="profileLead" style='margin-left:13px' class="form-control" onchange="findCompaniesInLead(jQuery(this).val(),true);" style="height:36px;min-height:36px;">
							<option value="0">Lead</option>
						</select>
					</div>
				</div>
				<div class="col-xs-1" >
					<div class="form-group input-string-group" style='border:0px;margin-bottom:0px;'>
						<select name="profile[list_type]" id="profileListType" style='margin-left:13px' class="form-control" onchange="changeActivityType(jQuery(this))" style="height:36px;min-height:36px;">
							<option value="0">All</option>
							<option value="2">Acquisition</option>
							<option value="1">Sales</option>
						</select>
					</div>
				</div>
				<div class="col-xs-1" id="noOfRecords">
				</div>
			</div>
		</div>
	</div>	
</div>
<div class='row'>
	<div class="scroll-container col-lg-12 cp-border">
		<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:100%;'></div>
	</div>
</div>

<script>
function changeActivityType(o){
	console.log(_leadID);
	if(_leadID==0){
		alert("Please select lead first");
	} else {
		_activity = 0;
		if(o.val()>0){		
			_activity = o.val();
		}
		window.parent.jQuery("#activityMainType").val(_activity);
		if(_activity==1){
			window.parent.displaySaleActivityTable('',jQuery("#salesActivityButton"));
		}else if(_activity==2){
			window.parent.displayAquisitionActivityTable('',jQuery("#acquisitionActivityButton"));
		}
		/*findCompaniesInLead(jQuery("#profileLead").val(),false);*/
		/*get list of selected companies*/
		jQuery('input[name="list_selected"]').eq(0).trigger("click");
		/*getAllCompanyToLead(jQuery(this))*/
	}
}
var minTable = document.getElementById("companies_box");
_companiesINString = [];
_companiesINString=[<?php
		$insertID = array();
		for ($i = 0; $i < count($companies); $i++) {
			if(!in_array((int)$companies[$i]->id,$insertID)):
			$insertID[] = (int)$companies[$i]->id;
			$selected = 0;
			if(count($selected_sales_companies)>0){
				foreach($selected_sales_companies as $sCompany){
					if($sCompany->id==$companies[$i]->id){
						$selected=1;
						break;
					}
				}
			}
			if($selected==0){
				if(count($selected_acquisition_companies)>0){
					foreach($selected_acquisition_companies as $sCompany){	
						if($sCompany->id==$companies[$i]->id){
							$selected=1;
							break;
						}
					}
				}
			}
			
			$usersCount = 0;
			if($companies[$i]->company_users!=null){
				$usersCount = $companies[$i]->company_users;
			}
			
			$specialist = $companies[$i]->specialties;
			echo "{'id':". $companies[$i]->id.",'company_size':'".$companies[$i]->company_size."','specialist':'".$specialist."','industry':'".$companies[$i]->industry."','selected':".$selected.",'company_name':'" . addslashes($companies[$i]->company_name) . "','no_of_users':'" . $usersCount . "','sectors':'" . $companies[$i]->sectorName . "','categories':'" . $companies[$i]->department_names . "','sub_category':'" . $companies[$i]->sub_department_names . "','technology_names':'" . $companies[$i]->technology_names . "','sub_technology_names':'" . $companies[$i]->sub_technology_names . "','scrapped_date':'".$companies[$i]->scrapped_date."','scrapped_profile_date':'".$companies[$i]->scrapped_profile_date."','no_of_employees':'".$companies[$i]->no_of_employees."','linkedin_url':'".$companies[$i]->linkedin_url."'}";
			if ($i < count($companies) - 1) {
				echo ",";
			}
			endif;
		}
	?>];
_sectors = [];
_companyIndustry = [];
_companySize = [];
_linkedinUsers = [];
var _selectAll = 0;
_queryDeletion = false;
userColumns = ["Invited","General <input type='checkbox' onclick='checkedMeAll(jQuery(this))'/>","Merging","Survivor","Company","Users","Lin","Size","Industry","Specialist","Sectors","Categories","SubCategories","Technologies","SubTechnologies"];
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
			_unselectedCompanies=[];
			_selectedCompanies=[];
			jQuery("#rs tbody").find("tr").remove();
			_scrollTable = true;
			jQuery('.ui-autocomplete').css('display','none');
			resetBatch();
			loadTableWithNewData(true,0,200);			
		}		  
	});
	/*jQuery('html').on('click',function(e){
		jQuery('.button-list')
			.not(jQuery('.button-list').has($(e.target)))
			.parent().removeClass('n').find('.list_options')
			.hide();
	});*/
	function runResizeTable(){
		var width = jQuery(window).width();
		var height = jQuery(window).height();
		newHeight = (height - jQuery('#cn').outerHeight() - jQuery('.mainT').outerHeight());
		jQuery('.scroll-container').css("height",newHeight+"px");
		_calHeader = jQuery(minTable).find('div.containerResearchHeader').height();
		_calHeight = newHeight - _calHeader - 10;
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
	}
	jQuery(window).resize(function(){
		setTimeout(runResizeTable,100);
	});
	jQuery("#search_field").autocomplete({
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
			jQuery("#inviteeCompanyId").val(ui.item.realValue);
			jQuery("#lblCompany").html('Company: <strong><a href="javascript://" onclick="window.parent.openCompanyEdit('+ui.item.realValue+');">'+ui.item.label+'</a>"</strong>');
			findContactsForThisCompany(ui.item.realValue);
		}
	});
	callNestable()
	checkBoxClickEvent();
});
function resetBatch(){
	_batchStart = false;
	_batchNextStart = 0;
	_batchNextEnd = 0;
}
function callLeadData(){
	jQuery.ajax({
		url:__baseUrl+'opportunity/getListOfActiveLeads',
		dataType: "json",
	}).done(function(list){
		jQuery.map(list,function(l,index){
			_selected = "";
			if(l.id==_leadID){
				_selected = "selected='selected'";
			}
			jQuery("#profileLead").append("<option value='"+l.id+"' "+_selected+">"+l.lead_name+"</option>");
			if(_selected!=""){
				findCompaniesInLead(_leadID,false);
				jQuery("#profileLead").prop('disabled',true);
				if(window.parent.jQuery("#activityMainType").val()>0){
					jQuery("#profileListType").val(window.parent.jQuery("#activityMainType").val());
					jQuery("#profileListType").prop('disabled',true);
				}
			}
		});
	}).always(function(){
		callCountCompanyUsers();
	});
}
function callCountCompanyUsers(){
	jQuery.ajax({
		url:__baseUrl+'opportunity/get_users_count_list_companies',
		dataType: "json",
	}).done(function(list){
		_selectUl = jQuery("<ul/>").addClass('open_list');
		var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
		var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',0);
		var spanY = jQuery("<span/>").css('float','left').append(checkBox);
		var spanX = jQuery('<span/>').append('0');
		_selectLi.append(spanY).append(spanX);
		_selectUl.append(_selectLi);
		jQuery.map(list,function(l,index){
			var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
			var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',l.countUsers);
			var spanY = jQuery("<span/>").css('float','left').append(checkBox);
			var spanX = jQuery('<span/>').append(l.countUsers);
			_selectLi.append(spanY).append(spanX);
			_selectUl.append(_selectLi);
		});
		jQuery('.fixedHeader').find('thead th').eq(5).find('.list').empty().append(_selectUl);
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
			jQuery(".fixedHeader").find('thead th').eq(10).find('.list_options').find('.list').empty();				
			jQuery('.fixedHeader thead th').eq(10).find('.list_options').find('.list').append(_selectUl);
		}
	}).always(function(){
		findIndustry();
	});
}
function findIndustry(){
	jQuery.ajax({
		url: __baseUrl+'opportunity/getAllCompanyIndustry',
		dataType:'json'
	}).done(function(d){
		if(d.length>0){
			_companyIndustry = d;
			_selectUl = getCompanyIndustry();
			jQuery(".fixedHeader").find('thead th').eq(8).find('.list_options').find('.list').empty();				
			jQuery('.fixedHeader thead th').eq(8).find('.list_options').find('.list').append(_selectUl);
		}
	}).always(function(){
		findTechnologies();
	});
}
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
			jQuery('.fixedHeader').find('thead th').eq(13).find('.list').empty().append(_selectUl);
		}
	}).always(function(){
		findLinkedInAndCompanySize();
	});
}
function getCompanySize(){
	_selectUl = jQuery("<ul/>").addClass('open_list');
	jQuery.each(_companySize,function(i,c){
		if(c.id!=21){
			var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
			var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.company_size);
			var spanY = jQuery("<span/>").css('float','left').append(checkBox);
			var spanX = jQuery('<span/>').append(c.company_size);
			_selectLi.append(spanY).append(spanX);
			_selectUl.append(_selectLi);
		}		
	});
	return _selectUl.prop('outerHTML');
}
function getLinkedInUserScrape(){
	_selectUl = jQuery("<ul/>").addClass('open_list');
	jQuery.each(_linkedinUsers,function(i,c){
		if(c.id!=21){
			var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
			var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.linkedinCompanyUsers);
			var spanY = jQuery("<span/>").css('float','left').append(checkBox);
			var spanX = jQuery('<span/>').append(c.linkedinCompanyUsers);
			_selectLi.append(spanY).append(spanX);
			_selectUl.append(_selectLi);
		}		
	});
	return _selectUl.prop('outerHTML');
}
function getCompanyIndustry(){
	_selectUl = jQuery("<ul/>").addClass('open_list');
	jQuery.each(_companyIndustry,function(i,c){
		if(c.id!=21){
			var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
			var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.industry);
			var spanY = jQuery("<span/>").css('float','left').append(checkBox);
			var spanX = jQuery('<span/>').append(c.industry);
			_selectLi.append(spanY).append(spanX);
			_selectUl.append(_selectLi);
		}		
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
		if(_width<200){
			_width = 200;
		}
		parentTh.find(".list_options").find('.p-absolute').css({height:'320px',top:31,left:_position.left,width:_width+'px',background:'#fff',border:'1px solid #dfe8f1'});
	}
}
function searchFilter(o){
	var parentTH = o.parents('th');
	parentTH.addClass('open');
	var _filterName = parentTH.attr('filter-name');
	switch(_filterName){
		case 'sector':
			_filterSector = [];
			if(parentTH.find('.list input[type="checkbox"]:checked').length>0){
				parentTH.find('.list input[type="checkbox"]:checked').each(function(){
					_filterSector.push(jQuery(this).val());
				});
			}			
		break;
		case 'cate':
			_filterType = [];
			if(parentTH.find('.list input[type="checkbox"]:checked').length>0){
				parentTH.find('.list input[type="checkbox"]:checked').each(function(){
					_filterType.push(jQuery(this).val());
				});
			}
		break;
		case 'sub_cate':
			_filterSubType = [];
			if(parentTH.find('.list input[type="checkbox"]:checked').length>0){
				parentTH.find('.list input[type="checkbox"]:checked').each(function(){
					_filterSubType.push(jQuery(this).val());
				});
			}
		break;
		case 'tech':
			_filterTechnology = [];
			if(parentTH.find('.list input[type="checkbox"]:checked').length>0){
				parentTH.find('.list input[type="checkbox"]:checked').each(function(){
					_filterTechnology.push(jQuery(this).val());
				});
			}
		break;
		case 'sub_tech':
			_filterSubTech = [];
			if(parentTH.find('.list input[type="checkbox"]:checked').length>0){
				parentTH.find('.list input[type="checkbox"]:checked').each(function(){
					_filterSubTech.push(jQuery(this).val());
				});
			}
		break;
		case 'no_of_users':
			_filterUsers = [];
			if(parentTH.find('.list input[type="checkbox"]:checked').length>0){
				parentTH.find('.list input[type="checkbox"]:checked').each(function(){
					_filterUsers.push(jQuery(this).val());
				});
			}
		break;
		case 'linkedin':
			_filterLinkedIn = parentTH.find('input[type="radio"]:checked').val();
		break;
		case 'industry':
			_filterCompanyIndustry = [];
			if(parentTH.find('.list input[type="checkbox"]:checked').length>0){
				parentTH.find('.list input[type="checkbox"]:checked').each(function(){
					_filterCompanyIndustry.push(jQuery(this).val());
				});
			}
		break;
		case 'company_size':
			_filterCompanySize = [];
			if(parentTH.find('.list input[type="checkbox"]:checked').length>0){
				parentTH.find('.list input[type="checkbox"]:checked').each(function(){
					console.log("Company Size:"+jQuery(this).val());
					_filterCompanySize.push(jQuery(this).val());
				});
				console.log(_filterCompanySize);
			}
		break;
		case 'no_of_employees':
			_filterNoOfSize = [];
			if(parentTH.find('.list input[type="checkbox"]:checked').length>0){
				parentTH.find('.list input[type="checkbox"]:checked').each(function(){
					_filterNoOfSize.push(jQuery(this).val());
				});
			}
		break;
		
	}
	parentTH.find(".list_options").find('.p-absolute').parent().hide();
	parentTH.removeClass('n');
	jQuery("#rs tbody").find("tr").remove();
	_scrollTable = true;
	resetBatch();
	loadTableWithNewData(true,0,200);
}
function clearFilter(o){
	var parentTH = o.parents('th');
	parentTH.removeClass('open').removeClass('n');
	parentTH.find('input[type="text"]').val('');
	var _filterName = parentTH.attr('filter-name');
	switch(_filterName){
		case 'sector':
			_filterSector=[];
		break;
		case 'cate':
			_filterType=[];
		break;
		case 'sub_cate':
			_filterSubType=[];
		break;
		case 'tech':
			_filterTechnology=[];
		break;
		case 'sub_tech':
			_filterSubTech=[];
		break;
		case 'no_of_users':
			_filterUsers=[];
		break;
		case 'linkedin':
			_filterLinkedIn = "";
		break;
		case 'industry':
			_filterCompanyIndustry = [];
		break;
		case 'company_size':
			_filterCompanySize = [];
		break;
		case 'no_of_employees':
			_filterNoOfSize = [];
		break;
	}
	parentTH.find('input[type="radio"]').prop('checked',false);
	parentTH.find('input[type="checkbox"]').prop('checked',false);
	parentTH.find(".list_options").find('.p-absolute').parent().hide();
	jQuery("#rs tbody").find("tr").remove();
	_scrollTable = true;
	resetBatch();
	loadTableWithNewData(true,0,200);
}
_callFilters = false;
function showContactsTable(){
	_tableFixedHeader = jQuery("<thead/>");
	_tableFixedHeaderTr = jQuery("<tr/>");
	jQuery.each(userColumns,function(i,c){
		_filterICON = "";
		_sortICON = "";
		_class="";
		_sortName = "";
		_filterField = "";
		if(i==5 || i==7 || i==8  || i==6 || i==10 || i==11 || i==12 || i==13 || i==14){
			/*_filterICON = "<span class='button-list'><i class='fa fa-sort-down'></i></span>";*/
			_filterICON = "";
			_class = "filter";
		}
		if(i==4 || i==6 || i==7 || i==8 || i==9){
			_sortICON = "<span class='p-relative'><i class='icon-default p-absolute sort'></i></span>";
			if(_class==""){
				_class = "sortIcon";
			} else {
				_class = "filter-sort"
			}
		}
		if(i==0){
			_class = "filter";
		}
		if(_class=="filter" || _class=="filter-sort"){
			switch(i){
				case 0:
					_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"><ul><li><input type="radio" name="list_selected" value="0" onchange="getAllCompanyToLead(jQuery(this))"/>Selected</li><li><input type="radio" name="list_selected" value="1" onchange="getAllCompanyToLead(jQuery(this))"/>Un selected</li></ul></div></div></div>';
				break;
				case 5:
					_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>';
					_filterField = "no_of_users";
				break;
				case 6:
					_list = getLinkedInUserScrape();
					_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
					_filterField = "no_of_employees";
				break;
				case 7:
					_list = getCompanySize();
					_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
					_filterField = "company_size";
				break;
				case 8:
					_list = getCompanyIndustry();
					_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
					_filterField = "industry";
				break;
				case 10:
					_list = getSectors();
					_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
					_filterField = "sector";
				break;
				case 11:
					_list = "";
					_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
					_filterField = "cate";
				break;
				case 12:
					_list = "";
					_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
					_filterField = "sub_cate";
				break;
				case 13:
					_list = "";
					_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
					_filterField = "tech";
				break;
				case 14:
					_list = "";
					_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
					_filterField = "sub_tech";
				break;
			}
		}
		switch(i){
			case 4:
				_sortName = "company_name";
			break;
			case 6:
				_sortName = "no_of_employees";
			break;
			case 7:
				_sortName = "company_size_type";
			break;
			case 8:
				_sortName = "industry";
			break;
			case 9:
				_sortName = "specialties";
			break;
		}
		_tableFixedHeaderTh = jQuery("<th/>").attr('sort-name',_sortName).attr('filter-name',_filterField).append(_sortICON+"<span class='"+_class+"'>"+c+"</span>"+_filterICON);
		/*_tableFixedHeaderTh.find('.button-list').off('click').on('click',function(){
			openFilterList(jQuery(this));
		});*/
		_tableFixedHeaderTh.find('.filter,.filter-sort').off('click').on('click',function(){
			openFilterList(jQuery(this));
		});
		_tableFixedHeaderTr.append(_tableFixedHeaderTh);
	});
	_tableFixedHeader.append(_tableFixedHeaderTr);
	_tableBody = jQuery("<tbody/>");
	jQuery("#noOfRecords").html(__totalRecords);
	console.log("In all");
	jQuery.each(_companiesINString,function(i,u){
		_checked="";
		_addclass ="main master";
		_addclass1 ="";
		if(u.selected===1){
			_checked="checked='checked'";
			_addclass ="main selt";
			_addclass1 ="selt1";
		}
		_tableBodyTr =jQuery("<tr/>").attr('id',i).addClass(_addclass);
		_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='vendor_select_bulk[]' class='checker' value='"+u.id+"' "+_checked+" onchange='checkedMe(jQuery(this))'/>");
		_tableBodyTr.append(_tableBodyTd);
		/*General*/
		cDate = u.scrapped_date;
		if(cDate=='0000-00-00'){
			cDate = u.scrapped_profile_date;
		}
		if(cDate=='0000-00-00'){
			cDate = "Scrape";
		} else {
			cDate = moment(new Date(cDate)).format('MM/DD/YY');
		}
		_anchor = "<a class='scrape_date' href='javascript://' onclick='scrapeOnRun(jQuery(this))'>"+cDate+"</a>";
		_check = "";
		if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
			_check = "CHECKED='CHECKED'";
		}
		_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='general_select_bulk[]' "+_check+" class='general' value='"+u.id+"' data-linkedin='"+u.linkedin_url+"' onclick='selectedMe(jQuery(this))'/> "+_anchor);
		_tableBodyTr.append(_tableBodyTd);
		
		_tableBodyTd = jQuery("<td/>").addClass('merger').append("<input type='checkbox' class='merger_chk'  value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		_tableBodyTd = jQuery("<td/>").addClass('survivor').append("<input type='checkbox' class='survivor_chk' value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		
		_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.id+"' data-linkedin='"+u.company_linkedin_url+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='window.parent.openCompanyEdit("+u.id+")'>"+u.company_name+"</a>";
		_tableBodyTd = jQuery("<td/>").append(_htmlName);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.no_of_users);
		_tableBodyTr.append(_tableBodyTd);
		_linkedIN = u.linkedin_url;
		if(_linkedIN.indexOf('linkedin')>=0){
			_linkedIN = "In";
		}
		noOfEmployees = u.no_of_employees;
		_tableBodyTd = jQuery("<td/>").append(noOfEmployees);
		/*_tableBodyTd = jQuery("<td/>").append(_linkedIN);*/
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.company_size);
		_tableBodyTr.append(_tableBodyTd);
		_div = jQuery('<div/>').addClass('overwrap').append(u.industry);
		_tableBodyTd = jQuery("<td/>").append(_div).attr('title',u.industry);
		_tableBodyTr.append(_tableBodyTd);
		_div = jQuery('<div/>').addClass('overwrap').append(u.specialist);
		_tableBodyTd = jQuery("<td/>").append(_div).attr('title',u.specialist);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.sectors);
		_tableBodyTr.append(_tableBodyTd);
		_cat = u.categories;
		if(_cat==undefined){
			_cat = "";
		}
		_cat = _cat.toString().split(',').join('<br/>');
		if(_cat==false){
			_cat = '';
		}
		_div = jQuery('<div/>').addClass('overwrap').append(_cat);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		_subcat = u.sub_category;
		if(_subcat==undefined || _subcat==false){
			_subcat = "";
		}
		_subcat = _subcat.toString().split(',').join('<br/>');
		_div = jQuery('<div/>').addClass('overwrap').append(_subcat);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);	
		_tech = u.technology_names;
		if(_tech==undefined || _tech==false){
			_tech = "";
		}
		_tech = _tech.toString().split(',').join('<br/>');
		_div = jQuery('<div/>').addClass('overwrap').append(_tech);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);	
		_subtech = u.sub_technology_names;
		if(_subtech==undefined || _subtech==false){
			_subtech = "";
		}
		_subtech = _subtech.toString().split(',').join('<br/>');
		_div = jQuery('<div/>').addClass('overwrap').append(_subtech);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);	
		_tableBody.append(_tableBodyTr);
	});
	var minHandsTable = jQuery("<table/>").addClass('table tableData').attr('id','rs');
	var minHandsTableFixed = jQuery("<table/>").addClass('table fixedHeader').append(_tableFixedHeader);
		minHandsTable.append(_tableBody);
	_headerDiv = jQuery('<div/>').addClass('containerResearchHeader').append(minHandsTableFixed);
	_bodyDiv = jQuery('<div/>').addClass('containerResearchBody dragscroll').append(minHandsTable);
	jQuery(minTable).empty().append(_headerDiv).append(_bodyDiv);
	_getHeight = jQuery('.scroll-container').height();
	_calHeader = jQuery(minTable).find('div.containerResearchHeader').height();
	_calHeight = _getHeight - _calHeader - 15;
	jQuery(minTable).find('div.containerResearchBody').css("height",_calHeight+"px");
	_extraWidth = 0;
	_checkNavi = window.navigator;
	if(_checkNavi.platform.indexOf('Win')>=0){
		_extraWidth = 17;
	}
	jQuery(minTable).find('div.containerResearchHeader').css("width",jQuery(minTable).find('div.containerResearchHeader').width()-_extraWidth);
	toggleActivity();
	setTimeout(function(){resizeTable(1)},2);
	setTimeout(function(){loadTableWithNewData(true,0,200);}, 100);	
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
_sentNewRequest = false;
function toggleActivity(){
	if(jQuery("#rs tbody tr.main").length>0){
		jQuery("#rs tbody tr.main").each(function(){
			jQuery(this).find('a.showActivity').off('click').on('click',function(){
				if(jQuery(this).hasClass('open')===true){
					var companyID = jQuery(this).attr('data-id');
					if(jQuery("#com_"+companyID).length>0){
						jQuery("#com_"+companyID).remove();
					}	
					jQuery(this).removeClass('open');
					jQuery(this).find('i.fa').removeClass('fa-chevron-down').addClass('fa-chevron-right');				
				} else {
					/*jQuery("#rs tbody tr.cu").remove();*/
					jQuery(this).addClass('open')
					jQuery(this).find('i.fa').removeClass('fa-chevron-right').addClass('fa-chevron-down');
					_sentNewRequest = true;
					var companyID = jQuery(this).attr('data-id');
					var parentTr = jQuery(this).parent().parent();
					jQuery.ajax({
						url:__baseUrl+'opportunity/find_company_users',
						type:'POST',
						data:{c:companyID,p:0},
						dataType:'json',
						cache:false
					}).done(function(d){
						if(jQuery("#com_"+companyID).length>0){
							jQuery("#com_"+companyID).remove();
						}
						if(d.length>0){						
							_contactsTr = jQuery("<tr/>").addClass('cu').attr('id',"com_"+companyID);
							_contactTd = jQuery("<td/>").addClass('c1').attr('colspan',8);
							_contactTdTable= jQuery('<table/>').addClass('table sbo').css({border:'0px'});
							_contactTdTableThead = jQuery("<thead/>").append("<tr><th>#</th><th>Name</th><th>C</th><th>CC</th><th>Current C</th><th>Title</th></tr>");
							_contactTdTable.append(_contactTdTableThead);
							_contactTdTableTbody = jQuery("<tbody/>");
							jQuery.each(d,function(k,cu){
								var tr = jQuery("<tr/>").attr("data-ur",cu.id);
								linkedinURL = cu.linkedin_url;
								var td = jQuery("<td/>");
								_iconList = "<a href='javascript://' onclick='deleteContact("+cu.id+",jQuery(this))'><i class='fa fa-trash'></i></a> ";
								if(cu.email!=""){
									_iconList += "<a href='javascript://' onclick='openActivityBox("+cu.company_id+","+cu.id+")'><i class='fa fa-envelope'></i></a>";
								}
								if(cu.phone!="" ){
									_iconList += "<a href='javascript://' onclick='openActivityBox("+cu.company_id+","+cu.id+")><i class='fa fa-phone'></i></a>";
								}
								if( cu.telephone!=""){
									_iconList += "<a href='javascript://' onclick='openActivityBox("+cu.company_id+","+cu.id+")><i class='fa fa-phone-square'></i></a>";
								}
								if(cu.linkedin_url!=""){
									_iconList += "<a href='"+cu.linkedin_url+"' target='_blank'><i class='fa fa-linkedin'></i></a>";
								}
								if(cu.gateway==1){
									_iconList += "<i class='fa'><img src='https://storage.googleapis.com/static.synpat.com/backyard/images/gateway-1.png'/></i> ";
								}
								td.append(_iconList);
								tr.append(td);
								var td = jQuery("<td/>").append("<a href='javascript://' onclick='window.parent.editContact("+cu.id+")'>"+cu.name+"</a>");
								tr.append(td);
								var td = jQuery("<td/>").append(cu.proximity);
								tr.append(td);
								var td = jQuery("<td/>").append(cu.c_c);
								tr.append(td);
								var td = jQuery("<td/>").append(cu.current_company);
								tr.append(td);
								var td = jQuery("<td/>").append(cu.job_title);
								tr.append(td);								
								_contactTdTableTbody.append(tr);
							});
							_contactTdTable.append(_contactTdTableTbody);
							_contactTd.append(_contactTdTable);
							_contactsTr.append(_contactTd);
							/*_contactsTr.css('display','none');*/
							parentTr.find('td').eq(4).find('a.showActivity').find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
							if(parentTr.next().length>0){
								parentTr.next().before(_contactsTr);
							} else {
								parentTr.after(_contactsTr);
							}
							resizeTable(0);
							sortUserTable();
						}
					}).always(function(){_sentNewRequest = false;});
				}
			});
		});
	}
}
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
					width = 50;
				break;
				case 1:
					width = 90;
				break;
				case 2:
					width = 60;
				break;
				case 3:
					width = 70;
				break;
				case 4:
					width = 250;
				break;
				case 5:
					width = 60;
				break;
				case 6:
					width = 40;
				break;
				case 7:
					width = 100;
				break;
				case 8:
					width = 130;
				break;
				case 9:
					width = 150;
				break;				
				case 10:
					width = 200;
				break;
				case 11:
					width = 200;
				break;
				case 12:
					width = 200;
				break;
				case 13:
					width = 200;
				break;
				case 14:
					width = 200;
				break;
			}						
			tableResearcherThead.find('th').eq(i).css({width:width+"px",minWidth:width+"px",maxWidth:width+"px"});
			jQuery(this).css({width:width+"px",minWidth:width+"px",maxWidth:width+"px",wordBreak:'break-all'});
			j++;
		});
		tableResearcherT.css({tableLayout:'fixed',wordBreak:'break-all'});
		tableResearcherFixed.css({tableLayout:'fixed',wordBreak:'break-all'});
		if(t==1){setTimeout(scrollSynchronize,100);sortTables();}
		jQuery("#rs tbody tr.main").each(function(){
			mainTable = jQuery(this).outerWidth();
			var nextTr = jQuery(this).next();
			nextTr.find('td.c1').css('width',mainTable+'px');
			nextTr.find('table').css('width',mainTable+'px');
			nextTr.find('table tbody tr').each(function(){
				_width2 = mainTable - 530;
				jQuery(this).find('td').eq(0).css('width','120px');
				jQuery(this).find('td').eq(1).css('width','150px');
				jQuery(this).find('td').eq(2).css('width','30px');
				jQuery(this).find('td').eq(3).css('width','30px');
				jQuery(this).find('td').eq(4).css('width','200px');
				jQuery(this).find('td').eq(5).css('width',_width2+'px');
			});
		});
}
function sortUserTable(){
	jQuery(".cu table").tablesorter({
		headers:{
			0: { sorter: false} 
		}
	});
}
function sortUserTableDestroy(){
	jQuery(".cu table").trigger("destroy");
}
var lastScroll = 0;
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
			if(_scrollTable===true){
				scrollAmount  = $('.containerResearchBody').scrollTop();
				documentHeight  = $("#rs").height();
				scrollPercent = (scrollAmount / documentHeight) * 100;
				
				if(($childE.scrollTop()>lastScroll || $childE.scrollTop()==lastScroll) && $childE.scrollTop()!=0 && lastScroll!=0){
					console.log("CT");
					var tableHeight = jQuery("#rs").height() - 673;
					if(scrollPercent > 50) {
						checkScroll(true);
					}
				} else {
					if((lastScroll>$childE.scrollTop()) || (lastScroll==0 && $childE.scrollTop()==0)){
						console.log("CF");
						if(scrollPercent < 30) {
							checkScroll(false);
						}
					}
				} 
				lastScroll = $childE.scrollTop();
				if(lastScroll==0){
					$childE.scrollTop(1);
					lastScroll = 2;
				}
			}
		})
	} else {
		setTimeout(function(){scrollSynchronize();},300);
	}
}
_scrollTable = true;
__totalRecords = '<?php echo $count_all;?>';
__baseUrl = '<?php echo $Layout->baseUrl?>';
_leadID = '<?php echo $lead_id?>';
_activity = '<?php echo $activity?>';
_requestAlreadySend = false;

var _leadContacts;
function findCompaniesInLead(leadID , t){
	if(_leadID!=leadID){
		_leadID = leadID;
	}	
	if(t===true){
		selectParentLeadTable(leadID);
	}
	if(_activity>0){
		_leadID = leadID;
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/find_invites_company',
			data:{l:_leadID,a:_activity},
			dataType:'json',
		}).done(function(data){
			if(data.length>0){
				var $tableList = jQuery("#rs").find('tbody');
				jQuery.map(data,function(c,index){
					var $checkBox = $tableList.find('input.checker[value="'+c.id+'"]');
					if($checkBox.length>0){
						/*console.log('FOUND',c.id);*/
						$checkBox.prop('checked',true);
					}
				})
			}
		});
	}	
}
function selectParentLeadTable(leadID){
	var $table = window.parent.jQuery("#all_type_list");
	if($table.length>0){
		if($table.find('tr[data-id="'+leadID+'"]').length>0){
			$table.find('tr[data-id="'+leadID+'"]').find('a.btn').trigger('click');
		}
	}
}

function checkScroll(s){
	var elBoundery = jQuery("#rs").find('tbody tr.main');
	var tapC = false;
	if(s===true){ 
		var ID = elBoundery.eq(elBoundery.length-1).attr('id');
		ID = parseInt(ID);
		ID +=1;
		if(ID< __totalRecords){
			_start = parseInt(ID);
			_end = 200;
			tapC = true;
		}
	} else {
		var ID = elBoundery.eq(0).attr('id');
		if(parseInt(ID)>0){
			_end = parseInt(ID);
			_start = _end - 200;
			if(_end>200){
				_end = 200;	
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
_sortField = "c.company_name";
_sortBy = "ASC";
var _filterSector=[],_filterType=[],_filterSubType=[],_filterTechnology=[],_filterSubTech=[],_filterUsers=[],_filterLinkedIn = "",_filterCompanyIndustry=[],_filterCompanySize=[],_filterNoOfSize=[];
function deleteContact(ID,o){
	res = confirm("Are your sure?");
	if(res){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/deleteContact',
			data:{delete_link:parseInt(ID)},
			cache:false,
			success:function(data){
				if(data>0){
					var $mainRow = o.parent().parent();
					var paT = $mainRow.parent().parent().parent().parent();
					if(paT.hasClass('cu')){
						var patPR = paT.prev();
						var txt = patPR.find('td').eq(5).text();
						try{
							txt = parseInt(txt);
							txt -=1;
							patPR.find('td').eq(5).text(txt);
						}catch(e){}
						sortUserTableDestroy();
						$mainRow.remove();
						sortUserTable();
						var _selectedPanel;
						if(window.parent.jQuery("#activityTable").hasClass('show')){
							_selectedPanel = window.parent.jQuery("#activityTable");
						} else if(window.parent.jQuery("#aquisitionTable").hasClass('show')){
							_selectedPanel = window.parent.jQuery("#aquisitionTable");
						}
						if(_selectedPanel!=undefined){
							if(_selectedPanel.find('tr[data-p="'+ID+'"]').length>0){
								_selectedPanel.find('tr[data-p="'+ID+'"]').remove();
							}
						}
						if(window.parent.jQuery("#open_company_add").hasClass('is-open')){
							var _frame = window.parent.jQuery("#open_company_add").find("iframe").contents();
							if(_frame.find("#table_list_user").find("tr[data-id='"+ID+"']").length>0){
								_frame.find("#table_list_user").find("tr[data-id='"+ID+"']").remove();
							}
						}
					}
				} else  if(data=='-1'){
					alert("Some correspondense with this contact.");
				}
			}
		});
	}	
}
_batchStart = false;
_batchNextStart = 0;
_batchNextEnd = 0;
/*function loadTableWithNewData(t,start,end){
	p = 200;
	if(_requestAlreadySend===false){
		if(_batchStart===true){
			_requestAlreadySend = true;
			jQuery.ajax({
				type:"POST",
				url:__baseUrl+'opportunity/find_next_batch',
				data:{s:_batchNextStart,e:_batchNextEnd},
				cache:false,
				dataType:'json',
				success:function(b){
					formatDataAppendInTable(b,t);
					if(b.batch_start === true){
						_batchStart = true;
						_batchNextStart = b.batch_next_start;
						_batchNextEnd = b.batch_next_end;
					} else {
						_batchStart = false;
					}
					setTimeout(function(){	_requestAlreadySend = false;},1000);
				}
			})
		} else {
			insertID = [];
			_requestAlreadySend = true;
			_url = __baseUrl+'opportunity/sales_contact_test/'+_leadID+'/'+_activity+'/ajax/'+p;
			_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,start:start,end:end,sort_field:_sortField,sort_by:_sortBy,t:t};
			jQuery.ajax({
				type:"POST",
				url:_url,
				data:_filters,
				cache:false,
				dataType:'json',
				success:function(b){
					var elBoundery = jQuery("#rs").find('tbody tr');
					if(t===true){
						if(jQuery("#rs tr").length>0){
							_increment = jQuery("#rs tr.master").eq(jQuery("#rs tr.master").length-1).attr('id');
							_increment = parseInt(_increment);
							_increment +=1;
						} else {
							_increment = 0;
						}
						jQuery("#rs tr.selt").remove();
						jQuery("#rs tr.selt1").remove();
						if(jQuery("#rs tr").length>500){
							elBoundery.slice(0,200).remove();
						}
					} else {
						if(jQuery("#rs tr").length>0){
							_increment = jQuery("#rs tr.master").eq(0).attr('id');
							_increment = parseInt(_increment);
							_increment = _increment - 1;
						} else {
							_increment = 0;
						}
						jQuery("#rs tr.selt").remove();
						jQuery("#rs tr.selt1").remove();
						if(jQuery("#rs tr").length>500){
							elBoundery.slice(-200).remove();
						}
					}
					if(typeof b.batch_start !="undefined" && b.batch_start === true){
						_batchStart = true;
						_batchNextStart = b.batch_next_start;
						_batchNextEnd = b.batch_next_end;
					}else {
						_batchStart = false;
					}
					formatDataAppendInTable(b,t);
				}
			});
		}
	}
}*/
function loadTableWithNewData(t,start,end){
	p = 200;
	if(_requestAlreadySend===false){		
		insertID = [];
		jQuery("#loading_message").html("Loading...");	
		_requestAlreadySend = true;
		_url = __baseUrl+'opportunity/sales_contact_test/'+_leadID+'/'+_activity+'/ajax/'+p;
		_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,start:start,end:end,sort_field:_sortField,sort_by:_sortBy,t:t};
		jQuery.ajax({
			type:"POST",
			url:_url,
			data:_filters,
			cache:false,
			dataType:'json',
			success:function(b){
				var elBoundery = jQuery("#rs").find('tbody tr');
				if(t===true){
					if(jQuery("#rs tr").length>0){
						_increment = jQuery("#rs tr.master").eq(jQuery("#rs tr.master").length-1).attr('id');
						_increment = parseInt(_increment);
						_increment +=1;
					} else {
						_increment = 0;
					}
					jQuery("#rs tr.selt").remove();
					jQuery("#rs tr.selt1").remove();
					if(jQuery("#rs tr").length>500){
						elBoundery.slice(0,200).remove();
					}
				} else {
					if(jQuery("#rs tr").length>0){
						_increment = jQuery("#rs tr.master").eq(0).attr('id');
						_increment = parseInt(_increment);
						_increment = _increment - 1;
					} else {
						_increment = 0;
					}
					jQuery("#rs tr.selt").remove();
					jQuery("#rs tr.selt1").remove();
					if(jQuery("#rs tr").length>500){
						elBoundery.slice(-200).remove();
					}
				}
				if(typeof b.batch_start !="undefined" && b.batch_start === true){
					_batchStart = true;
					_batchNextStart = b.batch_next_start;
					_batchNextEnd = b.batch_next_end;
				}else {
					_batchStart = false;
				}
				formatDataAppendInTable(b,t);
			}
		}).always(function(){
			jQuery("#loading_message").html("");	
		});
	}
}
function formatDataAppendInTable(b,t){
	_companiesINString=[];
	if(typeof b.count_all!="undefined"){
		__totalRecords = b.count_all;
	} else {
		__totalRecords = 0;
	}		
	if(_filterSector.length>0){
		if(typeof b.cat!="undefined"){
			if(jQuery('.fixedHeader thead th').eq(11).find('.list_options').find('.list').find('ul').length==0){
				
				jQuery('.fixedHeader thead th').eq(11).find('.list_options').find('.list').empty();
				if(b.cat.length>0){
					var _selectUl = jQuery("<ul/>").addClass('open_list');
					jQuery.each(b.cat,function(i,s){
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
	}
	if(_filterType.length>0){
		if(typeof b.sub_cat!="undefined"){
			if(jQuery('.fixedHeader thead th').eq(12).find('.list_options').find('.list').find('ul').length==0){
				console.log('Ul subcat empty');
				jQuery('.fixedHeader thead th').eq(12).find('.list_options').find('.list').empty();
				if(b.sub_cat.length>0){
					var _selectUl = jQuery("<ul/>").addClass('open_list');
					jQuery.each(b.sub_cat,function(i,s){
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
	if(_filterTechnology.length>0){
		if(typeof b.sub_tech!="undefined"){
			if(jQuery('.fixedHeader thead th').eq(14).find('.list_options').find('.list').find('ul').length==0){
				jQuery('.fixedHeader thead th').eq(14).find('.list_options').find('.list').empty();
				if(b.sub_tech.length>0){
					var _selectUl = jQuery("<ul/>").addClass('open_list');
					jQuery.each(b.sub_tech,function(i,s){
						var _selectLi = jQuery("<li/>").css({'float':'left',width:'100%'});
						var _input = jQuery("<input/>").attr("type","checkbox").attr("value",s.id);
						var spanX = jQuery("<span/>").css('float','left');
						spanX.append(_input);
						var spanY = jQuery("<span/>").append(s.name);
						_selectLi.append(spanX).append(spanY);
						_selectUl.append(_selectLi);
					});
					jQuery('.fixedHeader thead th').eq(14).find('.list_options').find('.list').append(_selectUl);
				}
			}						
		}
	}
	
	
	if(typeof b.companies!="undefined" && b.companies.length>0){
		_data = b.companies;
		
		for(i=0;i<_data.length;i++){
			if(jQuery.inArray(parseInt(_data[i].id),insertID)<0){
				insertID.push(parseInt(_data[i].id));
				_entry = true;
				if(_entry===true){	
					_selected = 0;
					if(b.activity==2){
						if(b.selected_acquisition_companies.length>0){
							jQuery.each(b.selected_acquisition_companies,function(index,sc){
								if(sc.id==_data[i].id){
									_selected = 1;
									return false;
								}
							});
						}
					} else {
						if(b.selected_sales_companies.length>0){
							jQuery.each(b.selected_sales_companies,function(index,sc){
								if(sc.id==_data[i].id){
									_selected = 1;
									return false;
								}
							});
						}
					}
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
													
					_usersCount = 0;
					if(_data[i].company_users!=null){
						_usersCount = _data[i].company_users;
					} 
					object = {};
					object.id = _data[i].id;
					object.selected = _selected;
					object.company_name = _data[i].company_name;
					object.no_of_users = _usersCount;
					object.sectors = _sectorName;
					object.industry = _data[i].industry;
					object.specialist = _data[i].specialties;
					object.company_size = _data[i].company_size;
					object.no_of_employees = _data[i].no_of_employees;
					object.categories = _categories;
					object.sub_category = _sub_categories;
					object.technology_names = _data[i].technology_names;
					object.sub_technology_names = _data[i].sub_technology_names;
					object.scrapped_date = _data[i].scrapped_date;
					object.scrapped_profile_date = _data[i].scrapped_profile_date;
					object.linkedin_url = _data[i].linkedin_url;
					_companiesINString.push(object);
				}
			}
		}
		
		if(t===false){
			_companiesINString.reverse();
		}
		_fullHTML = "";
		jQuery("#noOfRecords").html(__totalRecords);
		jQuery.each(_companiesINString,function(i,u){
			_checked="";
			_addclass = "main master";
			_addclass1 = "";
			if(u.selected==1){
				_addclass = "main selt";
				_addclass1 = "selt1";
				_checked="checked='checked'";
			}
			_color = "";
			_cName = u.company_name;
			_cName = _cName.toLowerCase();
			_v1 = jQuery("#search_field").val();
			_v1 = _v1.toLowerCase();
			if(_v1!="" && _cName.indexOf(_v1)>=0){
			   _color = 'yellow';
			}
			_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.id+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='window.parent.openCompanyEdit("+u.id+")'>"+u.company_name+"</a>";
			/*General*/
			cDate = u.scrapped_date;
			if(cDate=='0000-00-00'){
				cDate = u.scrapped_profile_date;
			}
			if(cDate=='0000-00-00'){
				cDate = "Scrape";
			} else {
				cDate = moment(new Date(cDate)).format('MM/DD/YY');
			}
			_anchor = "<a class='scrape_date' href='javascript://' onclick='scrapeOnRun(jQuery(this))'>"+cDate+"</a>";
			_check = "";
			if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
				_check = "CHECKED='CHECKED'";
				if(_unselectedCompanies.length>0 && _unselectedCompanies.indexOf(u.id)>=0){
					_check = "";
				}
			} else {
				if(_selectedCompanies.length>0 && _selectedCompanies.indexOf(u.id)>=0){
					_check = "CHECKED='CHECKED'";
				}
			}			
			_tdList = [];
			_tdList.push("<td><input type='checkbox' name='vendor_select_bulk[]' class='checker' "+_checked+" value='"+u.id+"' onchange='checkedMe(jQuery(this))'/></td>");
			_tdList.push("<td><input type='checkbox' name='general_select_bulk[]' "+_check+" class='general' value='"+u.id+"' data-linkedin='"+u.linkedin_url+"'  onclick='selectedMe(jQuery(this))'/> "+_anchor+"</td>");
			_tdList.push("<td class='merger'><input type='checkbox'  class='merger_chk' value='"+u.id+"' /></td>");
			_tdList.push("<td class='survivor'><input type='checkbox' class='survivor_chk' value='"+u.id+"' /></td>");
			if(_color!=""){
				_tdList.push("<td style='background-color:"+_color+"'>"+_htmlName+"</td>");
			} else {
				_tdList.push("<td>"+_htmlName+"</td>");
			}
			_tdList.push("<td>"+u.no_of_users+"</td>");

			_linkedIN = u.linkedin_url;
			if(_linkedIN.indexOf('linkedin')>=0){
				_linkedIN = "In";
			}
			noOfEmployees = u.no_of_employees;
			_tdList.push("<td>"+noOfEmployees+"</td>");
			_tdList.push("<td>"+u.company_size+"</td>");
			_tdList.push("<td><div class='overwrap' title='"+u.industry+"'>"+u.industry+"</div></td>");
			if(u.specialist!=null){
				_tdList.push("<td><div class='overwrap' title='"+u.specialist+"'>"+u.specialist+"</div></td>");
			} else {
				_tdList.push("<td><div class='overwrap' title=''></div></td>");
			}
			
			_tdList.push("<td>"+u.sectors+"</td>");
			_cat = u.categories;
			if(_cat==undefined || _cat==false){
				_cat = "";
			}
			_cat = _cat.toString().split(',').join('<br/>');
			_tdList.push("<td><div class='overwrap'>"+_cat+"</div></td>");
			_subcat = u.sub_category;
			if(_subcat==undefined || _subcat==false){
				_subcat = "";
			}
			_subcat = _subcat.toString().split(',').join('<br/>');
			_tdList.push("<td><div class='overwrap'>"+_subcat+"</div></td>");
			_tech = u.technology_names;
			if(_tech==undefined || _tech==false){
				_tech = "";
			}
			_tdList.push("<td><div class='overwrap'>"+_tech+"</div></td>");
			_subtech = u.sub_technology_names;
			if(_subtech==undefined || _subtech==false){
				_subtech = "";
			}						
			_tdList.push("<td><div class='overwrap'>"+_subtech+"</div></td>");
			_tdListString = _tdList.join('');
			_tableBodyTr = "<tr id='"+_increment+"' class='"+_addclass+"'>"+_tdListString+"</tr>";

			if(t===true){
				jQuery("#rs tbody").append(_tableBodyTr);
			} else {
				if(jQuery("#rs tbody tr").length>0){
					jQuery("#rs tbody tr").eq(0).before(_tableBodyTr);
				} else {
					jQuery("#rs tbody tr").append(_tableBodyTr);
				}				
			}
			/*_fullHTML += _tableBodyTr.prop('outerHTML');
			_fullHTML += _contactsTr.prop('outerHTML');*/
			if(t===true){
				_increment++;
			}else{
				_increment--;
			}
		});	
		toggleActivity();
		setTimeout(function(){_requestAlreadySend = false;},1000);
		resizeTable(0);
		jQuery("#loading_message").html("");	
		if(_callFilters===false){
			_callFilters = true;
			callLeadData();
		}
	} else {
		jQuery("#loading_message").html("No record found");
		jQuery("#noOfRecords").html(0);
		setTimeout(function(){	_requestAlreadySend = false;},1000);
	}
}

function findLinkedInAndCompanySize(){
	_url = __baseUrl+'opportunity/no_of_employee_company_size/';
	jQuery.ajax({
		type:"POST",
		url:_url,
		data:{},
		cache:false,
		dataType:'json',
		success:function(b){	
			_linkedinUsers = b.linkedin_company_users;
			if(b.linkedin_company_users.length>0){
				jQuery(".fixedHeader").find('thead th').eq(6).find('.list_options').find('.list').empty();
				_selectUl = getLinkedInUserScrape();
				jQuery('.fixedHeader thead th').eq(6).find('.list_options').find('.list').append(_selectUl);
			}
			_companySize = b.company_size_list;
			if(b.company_size_list.length>0){
				jQuery(".fixedHeader").find('thead th').eq(7).find('.list_options').find('.list').empty();
				_selectUl = getCompanySize();
				jQuery('.fixedHeader thead th').eq(7).find('.list_options').find('.list').append(_selectUl);
			}
		}
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
		_scrollTable = true;
		resetBatch();
		loadTableWithNewData(true,0,200);
	});
}
function mergeCompanies(){
	if(jQuery("#rs tbody tr td.merger").find('input[type="checkbox"]:checked').length>0 && jQuery("#rs tbody tr td.survivor").find('input[type="checkbox"]:checked').length>0){
		_merger=[];
		jQuery("#rs tbody tr td.merger").find('input[type="checkbox"]:checked').each(function(){
			_merger.push(jQuery(this).val());
		});
		_survivor=[];
		jQuery("#rs tbody tr td.survivor").find('input[type="checkbox"]:checked').each(function(){
			_survivor.push(jQuery(this).val());
		});
		if(_survivor.length==1){
			jQuery("#loading_message").html("Please wait..");
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'opportunity/merge_companies_data',
				data:{m:_merger,s:_survivor},
				dataType:'json',
				cache:false,
				success:function(d){
					jQuery("#loading_message").html("");
					if(d.update>0){
						jQuery("#rs tbody tr td.merger").find('input[type="checkbox"]:checked').each(function(){
							var $this = jQuery(this)
							_cVal = $this.val();
							_check = false;
							jQuery.each(_survivor,function(k,l){
								if(l==_cVal){
									_check = true;
									return false;
								}
							});
							if(_check===false){
								var pC = $this.parent().parent();
								if(pC.next().hasClass('cu')){
									pC.next().remove();
								}
								pC.remove();
							}
						});
						var parentC = jQuery("#rs tbody tr td.survivor").find('input[type="checkbox"]:checked').parents('tr');
						parentC.find('td').eq(5).text(d.survivour_data.companyUsers.length);
						if(parentC.next().hasClass('cu')){
							var mainTD = parentC.next().find('td.c1');
							mainTD.find('tbody').empty();
							parentC.find('a.showActivity').removeClass('open');
							parentC.find('a.showActivity').find('i.fa').removeClass('fa-chevron-down').addClass('fa-chevron-right');
							parentC.find('a.showActivity').trigger('click');
						}
						jQuery("#rs tbody tr td").find('input.merger_chk,input.survivor_chk').prop('checked',false);
						jQuery("#rs tbody tr td").find('input.merger_chk,input.survivor_chk').removeAttr('checked');
						resizeTable(0);
					}
				}
			});
		} else {
			alert("There should be only one survivor");
		}		
	} else {
		alert("Please check merger and survivor companies first");
	}
}
function findContactsForThisCompany(ID){
	jQuery.ajax({
		url: __baseUrl+'opportunity/find_company_detail/'+_leadID+'/'+ID+'/'+_activity,
		dataType: "json",
		success: function (data) {
			_scrollTable = false;
			jQuery("#rs tbody").find("tr").remove();
			_fullHTML = "";
			_increment = 0;
			__totalRecords = data.length;
			addDataToTable(data,false);
		}
	});
}
function getAllCompanyToLead(t){
console.log('getAllCompanyLead');	
	jQuery("#rs tbody").find("tr").remove();
	_activity = 0;
	if(jQuery("#profileListType").val()){
		_activity = jQuery("#profileListType").val();
	}
	_unselectedCompanies=[];
	_selectedCompanies=[];
	if(t.val()==1){		
		resetBatch();
		loadTableWithNewData(true,0,200);
	} else {
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/find_invites_company',
			data:{l:_leadID,a:_activity},
			dataType:'json',
			cache:false
		}).done(function(d){
			if(d.length>0){
				_scrollTable = false;
				jQuery("#rs tbody").find("tr").remove();
				_fullHTML = "";
				_increment = 0;
				__totalRecords = d.length;
				addDataToTable(d,true);
			}
		});
	}
		
}
function addDataToTable(d,s){
	jQuery("#noOfRecords").html(__totalRecords);
	_companySize = [],cS=[];
	jQuery.each(d,function(i,u){
		_checked="";
		_addclass = "main selt";
		_addclass1 = "selt1";
		if(s===true){
			_checked="checked='checked'";
		} else {
			if(u.selected===true){
				_checked="checked='checked'";
			}
		}		
		_color = "";
		_cName = u.company_name;
		_cName = _cName.toLowerCase();
		_v1 = jQuery("#search_field").val();
		_v1 = _v1.toLowerCase();
		 if(_v1!="" && _cName.indexOf(_v1)>=0){
		   _color = 'yellow';
		}
		if(_companySize.length==0 || jQuery.inArray(u.company_size,cS)<0){
			cS.push(u.company_size);
			_companySize.push({id:u.company_id, company_size:u.company_size})
		}
		_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.id+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='window.parent.openCompanyEdit("+u.id+")'>"+u.company_name+"</a>";
		_tableBodyTr =jQuery("<tr/>").attr('id',_increment).addClass(_addclass);
		
		_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='vendor_select_bulk[]' class='checker' "+_checked+" value='"+u.id+"' onchange='checkedMe(jQuery(this))'/>");
		_tableBodyTr.append(_tableBodyTd);
		/*General*/
		cDate = u.scrapped_date;
		if(cDate=='0000-00-00'){
			cDate = u.scrapped_profile_date;
		}
		if(cDate=='0000-00-00'){
			cDate = "Scrape";
		} else {
			cDate = moment(new Date(cDate)).format('MM/DD/YY');
		}
		_anchor = "<a class='scrape_date' href='javascript://' onclick='scrapeOnRun(jQuery(this))'>"+cDate+"</a>";
		_check = "";
		if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
			_check = "CHECKED='CHECKED'";
		}
		_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='general_select_bulk[]' "+_check+" class='general' value='"+u.id+"' data-linkedin='"+u.linkedin_url+"'  onclick='selectedMe(jQuery(this))'/> "+_anchor);
		_tableBodyTr.append(_tableBodyTd);
		
		_tableBodyTd = jQuery("<td/>").addClass('merger').append("<input type='checkbox' class='merger_chk'  value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		_tableBodyTd = jQuery("<td/>").addClass('survivor').append("<input type='checkbox' class='survivor_chk' value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		if(_color!=""){
			_tableBodyTd = jQuery("<td/>").css('background-color',_color).append(_htmlName);
		} else {
			_tableBodyTd = jQuery("<td/>").append(_htmlName);
		}
		_tableBodyTr.append(_tableBodyTd);
		_noOfUsers = 0;
		if(u.no_of_users!="undefined" && u.no_of_users>0){
			_noOfUsers = u.no_of_users;
		} else if(u.company_users!="undefined" && u.company_users>0){
			_noOfUsers = u.company_users;
		}		
		_tableBodyTd = jQuery("<td/>").append(_noOfUsers);
		_tableBodyTr.append(_tableBodyTd);
		_linkedIN = u.linkedin_url;
		if(_linkedIN.indexOf('linkedin')>=0){
			_linkedIN = "In";
		}
		/*_tableBodyTd = jQuery("<td/>").append(_linkedIN);*/
		noOfEmployees = u.no_of_employees;
		_tableBodyTd = jQuery("<td/>").append(noOfEmployees);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.company_size);
		_tableBodyTr.append(_tableBodyTd);
		_div = jQuery('<div/>').addClass('overwrap').append(u.industry);
		_tableBodyTd = jQuery("<td/>").append(_div).attr('title',u.industry);
		_tableBodyTr.append(_tableBodyTd);
		_div = jQuery('<div/>').addClass('overwrap').append(u.specialist);
		_tableBodyTd = jQuery("<td/>").append(_div).attr('title',u.specialist);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.sectorName);
		_tableBodyTr.append(_tableBodyTd);
		_cat = u.sub_department_names;
		if(_cat==undefined || _cat==false){
			_cat = "";
		}
		_cat = _cat.toString().split(',').join('<br/>');
		_div = jQuery('<div/>').addClass('overwrap').append(_cat);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);
		_subcat = u.sub_category;
		if(_subcat==undefined || _subcat==false){
			_subcat = "";
		}
		_subcat = _subcat.toString().split(',').join('<br/>');
		_div = jQuery('<div/>').addClass('overwrap').append(_subcat);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);	
		_tech = u.technology_names;
		if(_tech==undefined || _tech==false){
			_tech = "";
		}
		_tech = _tech.toString().split(',').join('<br/>');
		_div = jQuery('<div/>').addClass('overwrap').append(_tech);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);	
		_subtech = u.sub_technology_names;
		if(_subtech==undefined || _subtech==false){
			_subtech = "";
		}
		_subtech = _subtech.toString().split(',').join('<br/>');
		_div = jQuery('<div/>').addClass('overwrap').append(_subtech);
		_tableBodyTd = jQuery("<td/>").append(_div);
		_tableBodyTr.append(_tableBodyTd);	
		_fullHTML += _tableBodyTr.prop('outerHTML');
		/*_fullHTML += _contactsTr.prop('outerHTML');*/
		_increment++;
	});
	jQuery("#rs tbody").append(_fullHTML);		
	toggleActivity();
	/*jQuery(".fixedHeader").find('thead th').eq(7).find('.list_options').find('.list').empty();
	if(_companySize.length>0){
	_selectUl = jQuery("<ul/>").addClass('open_list');
	jQuery.each(_companySize,function(i,c){
		if(c.id!=21){
			var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
			var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.id);
			var spanY = jQuery("<span/>").css('float','left').append(checkBox);
			var spanX = jQuery('<span/>').append(c.company_size);
			_selectLi.append(spanY).append(spanX);
			_selectUl.append(_selectLi);
		}		
	});
	_selectUl.prop('outerHTML');
	jQuery('.fixedHeader thead th').eq(7).find('.list_options').find('.list').append(_selectUl);
	}
	jQuery(".fixedHeader").find('thead th').eq(6).find('.list_options').find('.list').empty();
	if(_linkedinUsers.length>0){
	_selectUl = jQuery("<ul/>").addClass('open_list');
	jQuery.each(_linkedinUsers,function(i,c){
		if(c.linkedinCompanyUsers!=21){
			var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
			var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.linkedinCompanyUsers);
			var spanY = jQuery("<span/>").css('float','left').append(checkBox);
			var spanX = jQuery('<span/>').append(c.linkedinCompanyUsers);
			_selectLi.append(spanY).append(spanX);
			_selectUl.append(_selectLi);
		}		
	});
	_selectUl.prop('outerHTML');
	jQuery('.fixedHeader thead th').eq(6).find('.list_options').find('.list').append(_selectUl);
	}*/
	setTimeout(function(){_requestAlreadySend = false;},1000);
	resizeTable(0);
}
function checkedMeAll(o){
	_checked = false;
	_selectAll = 0;
	if(o.is(':checked')){
		_checked = true;
		_selectAll = 1;
	}
	_queryDeletion = true;
	jQuery("#rs").find('input[class="general"]').each(function(){
		var tdL = jQuery(this).find
		jQuery(this).prop('checked',_checked);
	});
}
function checkedMe(o){
	_targetBody = window.parent.findContainer();
	_activity = window.parent.jQuery('#activityMainType').val();
	_companyID = o.val();
	_t = false;
	if(o.is(':checked')){
		_t = true;
	}
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/invite_single_company',
		data:{company:_companyID,l:_leadID,t:_t,activity:_activity},
		cache:false,
		success:function(d){
			if(_activity==1){
				/*Sales */
				window.parent.callingOrder(2);
			} else if(_activity==2){
				/*Acquisition */
				window.parent.callingOrder(1);
			}
		}
	});
}
function sendCompanyToInvitees(t){
	_getData = jQuery("#rs tbody tr").find('input[type="checked"]:checked');
	_companies = [];
	_getData.each(_getData,function(){
		_companies.push(jQuery(this).val());
	});
	if(_companies.length>0){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/invite_company',
			data:{company:JSON.stringify(_companies),l:_leadID},
			cache:false,
			success:function(){
				if(t==1){
					getLeadSalesData =  window.parent.salesData();
					getLeadSalesData.done(function(){
						window.parent.showSalesData();
						window.parent.closeSlideBarLeftSales();
					});
				}					
			} 
		});
	}
}
function sendCompanyToAcquisition(t){
	_getData = jQuery("#rs tbody tr").find('input[type="checked"]:checked');
	_companies = [];
	_getData.each(_getData,function(){
		_companies.push(jQuery(this).val());
	});
	if(_companies.length>0){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/acquisition_company',
			data:{company:JSON.stringify(_companies),l:_leadID},
			cache:false,
			success:function(){
				if(t==1){
					getLeadAcquisitionData =  window.parent.acquisitionData();
					getLeadAcquisitionData.done(function(){
						window.parent.showAcqusitionData();
						window.parent.closeSlideBarLeftSales();
					});
				}
			}
		});
	}
}
function scrapeOnRun(o){
	var _companyID = o.parent().find('input[class="general"]').val();
	var iDS = [];
	iDS.push(_companyID);
	jQuery.ajax({
		url:__baseUrl+'opportunity/findAllCompaniesUsers',
		type:'POST',
		data:{c:JSON.stringify(iDS),t:1,p:0,s:1},
		dataType:'json',
		success:function(d){
			if(d.length>0){
				if(window.parent.scraperRequest==null || (typeof window.parent.scraperRequest.readyState!=undefined && window.parent.scraperRequest.readyState==4)){
					window.parent.sendContactScrapperRequest();
				}
			}
		}
	});
	var iDS = [];
	linkedINUrl = o.parent().find('input[class="general"]').attr('data-linkedin');
	if(linkedINUrl.indexOf('linkedin.com')>=0){
		sendCompanyRequestToScrapper(_companyID,linkedINUrl,11,true);				
	}
	/*var $thisP = o.parents('tr');
	var $trNext = $thisP.next();
	if($trNext.hasClass('cu')){
		var $table = $trNext.find('table.sbo');
		_userList = {};
		_userList.company = _companyID;
		_userList.type = 1;
		_userList.list = [];
		$table.find('tbody tr').each(function(){
			var pID = jQuery(this).attr('data-ur');
			if(jQuery(this).find('i.fa-linkedin').length>0){
				linkedinURL = jQuery(this).find('i.fa-linkedin').parent().attr('href');
				if(linkedinURL.indexOf('linkedin')>=0){
					var lObject = {};
					lObject.id = pID;
					lObject.linkedin_url = linkedinURL;
					_userList.list.push(lObject);
				}
			}
		});
		if(_userList.list.length>0){
			checkQueList(_userList);
			if(window.parent.scraperRequest==null || (typeof window.parent.scraperRequest.readyState!=undefined && window.parent.scraperRequest.readyState==4)){
				window.parent.sendScrapperRequest(1);
			}								
		}
	}*/
}

function sendCompanyRequestToScrapper(cID,linkedIn,type,sendRequest){
	var scrapCompany = {company:cID,url:linkedIn,type:type};
	console.log('In companies',scrapCompany);
	checkCompanyQueList(scrapCompany);
	if(sendRequest===true){
		console.log('check ajax request',window.parent.scraperCompanyRequest);
		if(window.parent.scraperCompanyRequest==null || (typeof window.parent.scraperCompanyRequest.readyState!=undefined && window.parent.scraperCompanyRequest.readyState==4)){
			console.log('no request for company');
			window.parent.sendScrapperCompanyRequest(11);
		}
	} else {
		console.log("fail");
	}
}
var _start = 0;
function scrapeSelectedCompanies(){
	/*Scrape Companies List*/
	console.log('Companies scraper schedule');
	_start = 0;
	if(jQuery('input[class="general"]:checked').length>0){
		console.log('Companies scraper schedule enter');
		var iDS = [];
		jQuery('input[class="general"]:checked').each(function(i){			
			linkedINUrl = jQuery(this).attr('data-linkedin');
			if(linkedINUrl.indexOf('linkedin.com')>=0){
				_sendRequest = false;
				console.log("CompaniesList:"+i);
				if(_start==0){
					console.log("CompaniesList:"+i+"Start");
					_sendRequest = true;
					_start++;
				}
				console.log('Companies scraper schedule found linkedin');
				sendCompanyRequestToScrapper(jQuery(this).val(),linkedINUrl,11,_sendRequest);								
			}
		});	
	}
}
function checkCompanyQueList(scrapCompany){
	if(window.parent.companyQuList.length==0){
		console.log('companies list empty');
		window.parent.companyQuList.push(scrapCompany);
	}else {
		_entry = true;
		jQuery.each(window.parent.companyQuList,function(i,c){
			if(c.company==scrapCompany.company){
				_entry = false;
				return false;
			}
		});
		if(_entry===true){
			console.log('companies not found n ow adding');
			window.parent.companyQuList.push(scrapCompany);
		}
	}	
}
function scrapeAllSelectedCompanies(){
	if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
		_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,start:0,end:0,sort_field:_sortField,sort_by:_sortBy,lead_id:_leadID,a:_activity,invite:jQuery('input[name="list_selected"]:checked').val()};
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/scrapeAllCompaniesByFilter',
			cache:false,
			data:_filters,
			dataType:'json'
		}).done(function(d){
			if(d.length>0){
				_sendRequest = false;
				console.log("Companies scrapper list based on filter");
				var iDS = [];
				jQuery.each(d,function(s,c){
					_sendRequest = false;
					if(s==0){
						console.log("CompaniesList:"+i+"Start");
						_sendRequest = true;
					}
					var linkedINUrl = c.linkedin_url;
					if(linkedINUrl!="" && linkedINUrl.indexOf('linkedin')>=0){
						sendCompanyRequestToScrapper(c.id,linkedINUrl,11,_sendRequest);
					}
					iDS.push(c.id);
				});
				jQuery.ajax({
					url:__baseUrl+'opportunity/findAllCompaniesUsers',
					type:'POST',
					data:{c:JSON.stringify(iDS),t:1,p:0,s:1},
					dataType:'json',
					success:function(d){
						if(d.length>0){
							console.log("Scrapper Company User List");
							if(window.parent.scraperRequest==null || (typeof window.parent.scraperRequest.readyState!=undefined && window.parent.scraperRequest.readyState==4)){
								window.parent.sendContactScrapperRequest();
							}
						}
					}
				});
			}
		});
	} else if(jQuery('input[class="general"]:checked').length>0){
		var iDS = [];
		jQuery('input[class="general"]:checked').each(function(){
			iDS.push(jQuery(this).val());
		});		
		scrapeSelectedCompanies();
		jQuery.ajax({
			url:__baseUrl+'opportunity/findAllCompaniesUsers',
			type:'POST',
			data:{c:JSON.stringify(iDS),t:1,p:0,s:1},
			dataType:'json',
			success:function(d){
				if(d.length>0){
					if(window.parent.scraperRequest==null || (typeof window.parent.scraperRequest.readyState!=undefined && window.parent.scraperRequest.readyState==4)){
						window.parent.sendContactScrapperRequest();
					}
				}
			}
		});
	} else {
		alert("Please select companies first.");
	}
}
function emailScrapeAllSelectedCompanies(){
	if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
		_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,start:0,end:0,sort_field:_sortField,sort_by:_sortBy,lead_id:_leadID,a:_activity,invite:jQuery('input[name="list_selected"]:checked').val()};
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/emailScrapeAllCompaniesByFilter',
			cache:false,
			data:_filters,
			dataType:'json'
		}).done(function(d){
			if(d.companies.length>0){
				window.parent.sendEmailScrapperRequest();
			}
			if(d.no_domain.length>0){
				for(i=0;i<d.no_domain.length;i++){
					jQuery('a[data-id="'+d.no_domain[i]+'"]').parent().find('a').eq(1).css('color','#c20000');
				}
			}
		});
	} else if(jQuery('input[class="general"]:checked').length>0){
		var iDS = [];
		jQuery('input[class="general"]:checked').each(function(){
			iDS.push(jQuery(this).val());
		});	
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/emailScrapeSelectedCompanies',
			cache:false,
			data:{list:iDS},
			dataType:'json'
		}).done(function(d){
			if(d.companies.length>0){
				window.parent.sendEmailScrapperRequest();
			}
			if(d.no_domain.length>0){
				for(i=0;i<d.no_domain.length;i++){
					jQuery('a[data-id="'+d.no_domain[i]+'"]').parent().find('a').eq(1).css('color','#c20000');
				}
			}
		});
	} else {
		alert("Please select companies first.");
	}
}
/*function scrapeAllSelectedCompanies(){
	if(jQuery('input[class="general"]:checked').length>0){
		window.parent._openForScrap = true;
		jQuery('input[class="general"]:checked').each(function(){
			var _companyID = jQuery(this).val();
			var $thisP = jQuery(this).parents('tr');
			var $trNext = $thisP.next();
			if($trNext.hasClass('cu')){
				var $table = $trNext.find('table.sbo');
				_userList = {};
				_userList.company = _companyID;
				_userList.type = 1;
				_userList.list = [];
				$table.find('tbody tr').each(function(){
					var pID = jQuery(this).attr('data-ur');
					if(jQuery(this).find('i.fa-linkedin').length>0){
						linkedinURL = jQuery(this).find('i.fa-linkedin').parent().attr('href');
						if(linkedinURL.indexOf('linkedin')>=0){
							var lObject = {};
							lObject.id = pID;
							lObject.linkedin_url = linkedinURL;
							_userList.list.push(lObject);
						}
					}
				});
				if(_userList.list.length>0){
					checkQueList(_userList);
					if(window.parent.scraperRequest==null || (typeof window.parent.scraperRequest.readyState!=undefined && window.parent.scraperRequest.readyState==4)){
						window.parent.sendScrapperRequest(1);
					}								
				}
			}
		});
	} else {
		alert("Please select companies first.");
	}
}*/

function checkQueList(_userList){
	if(window.parent.queList.length==0){
		window.parent.queList.push(_userList);
	} else {
		_entry = true;
		jQuery.each(window.parent.queList,function(i,c){
			if(c.company==_userList.company){
				_entry = false;
				return false;
			}
		});
		if(_entry===true){
			window.parent.queList.push(_userList);
		}
	}
}

function deleteSelectedCompanies(){
	if(jQuery('input[class="general"]:checked').length>0){
		if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
			conf = confirm("Are you sure you want to delete all companies based on query result?");
		} else {
			conf = confirm("Are you sure you want to delete selected companies?");
		}
		if(conf){
			if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
				_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,start:0,end:0,sort_field:_sortField,sort_by:_sortBy,unselected:_unselectedCompanies};
				jQuery.ajax({
					type:'POST',
					url:__baseUrl+'opportunity/deleteCompanyInBulkQuery',
					cache:false,
					data:_filters
				}).done(function(d){
					_unselectedCompanies=[];_selectedCompanies=[];
					_queryDeletion = false;
					resetBatch();
					loadTableWithNewData(true,0,200);
				});
			} else {
				contactID = "";
				_getData = jQuery("#rs").find('input[class="general"]:checked');
				jQuery.each(_getData,function(index,c){
					contactID += jQuery(c).val()+',';	
				});
				contactID =contactID.substring(0,contactID.length-1);
				jQuery.ajax({
					type:'POST',
					url:__baseUrl+'opportunity/deleteCompanyInBulk',
					data:{delete_link:contactID,selected:_selectedCompanies},
				}).done(function(d){
					_unselectedCompanies=[];_selectedCompanies=[];
					jQuery("#rs").find('input[class="general"]:checked').each(function(){
						var $this = jQuery(this).parents('tr');
						if($this.next().hasClass('cu')){
							$this.next().remove();
						}
						$this.remove();
					})
					var _selectedPanel;
					if(window.parent.jQuery("#activityTable").hasClass('show')){
						_selectedPanel = window.parent.jQuery("#activityTable");
					} else if(window.parent.jQuery("#aquisitionTable").hasClass('show')){
						_selectedPanel = window.parent.jQuery("#aquisitionTable");
					}
					if(_selectedPanel!=undefined){
						_idS = contactID.split(',');
						jQuery.each(_idS,function(i,c){
							_selectedPanel.find('tr.master').each(function(){
								if(jQuery(this).attr('data-c')==c){
									var $this = jQuery(this);
									$this.next().remove();
									$this.remove();
								}
							});
						});
					}
				});
			}
			runResizeTable();
		}
	} else {
		alert("Please select companies first.");
	}
}
__options = { 
	collapse:true,
	maxDepth:3,
	group: 1,
	dropCallback: function(details) {		   
		var order = new Array();
		jQuery("li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
		 order[index] = jQuery(elem).attr('data-id');
		});
		var rootOrder = new Array();
		if (order.length === 0){
			var rootOrder = new Array();
			jQuery("#nestable > ol > li").each(function(index,elem) {
			  rootOrder[index] = jQuery(elem).attr('data-id');
			});
		}
		
		_sourceAdd = jQuery("li[data-id='"+details.sourceId +"']").data('type');
		if(jQuery("li[data-id='"+details.destId +"']").find('ol:first').find('li').length==0 || jQuery("li[data-id='"+details.destId +"']").find('ol:first').find('li').length==1){			    
			
			_destAdd = jQuery("li[data-id='"+details.destId +"']").data('type');
			
			if(typeof _destAdd!="undefined"){
				if(_destAdd=="category"){
					_destAdd ="subcategory"
				}
				jQuery("li[data-id='"+details.destId +"']").find('ol:first').data('t',_destAdd);
			}
		} else {
			
			_destAdd = jQuery("li[data-id='"+details.destId +"']").find('ol:first').data('t');
		}	
		
		if(details.destId!=null && _destAdd=="sector"){
			_destAdd = "category";
		}
		if(typeof _destAdd=="undefined" && details.destId==null){
			
		   _destAdd = "sector";
		} else {
			
			_destAdd = "category";
		}
		
		sp = { source : details.sourceId, 
		  destination: details.destId, 
		  order:JSON.stringify(order),
		  rootOrder:JSON.stringify(rootOrder) ,
		  sourceType:_sourceAdd,
		  destType:_destAdd
		};
		
		jQuery.post(__baseUrl+'opportunity/update_sector_category_subcategory', sp	, function(data) {
		  //console.log('data '+data); 
			if(_sourceAdd=="sector"){
				
			}
		})
		.done(function() { 
			console.log('updated...');
			updateCategorySectorArea();
		})
		.fail(function() {  })
		.always(function() {  });
	}
};
__options1 = { 
	collapse:true,
	maxDepth:3,
	group: 1,
	dropCallback: function(details) {		   
		var order = new Array();
		jQuery("#nestable1 li[data-id='"+details.destId +"']").find('ol:first').children().each(function(index,elem) {
		 order[index] = jQuery(elem).attr('data-id');
		});
		var rootOrder = new Array();
		if (order.length === 0){
			var rootOrder = new Array();
			jQuery("#nestable1 > ol > li").each(function(index,elem) {
			  rootOrder[index] = jQuery(elem).attr('data-id');
			});
		}
		_sourceAdd = jQuery("#nestable1 li[data-id='"+details.sourceId +"']").data('type');
		if(jQuery("#nestable1 li[data-id='"+details.destId +"']").find('ol:first').find('li').length==0 || jQuery("#nestable1 li[data-id='"+details.destId +"']").find('ol:first').find('li').length==1){			    
			_destAdd = jQuery("#nestable1 li[data-id='"+details.destId +"']").data('type');
			if(typeof _destAdd!="undefined"){
				if(_destAdd=="sub-technology"){
					_destAdd ="subsub-technology";
				}
				jQuery("#nestable1 li[data-id='"+details.destId +"']").find('ol:first').data('t',_destAdd);
			}
		} else {
			_destAdd = jQuery("#nestable1 li[data-id='"+details.destId +"']").find('ol:first').data('t');
		}		
		if(typeof _destAdd=="undefined"){
		   _destAdd = "technology";
		}
		sp = { source : details.sourceId, 
		  destination: details.destId, 
		  order:JSON.stringify(order),
		  rootOrder:JSON.stringify(rootOrder) ,
		  sourceType:_sourceAdd,
		  destType:_destAdd
		};
		
		jQuery.post(__baseUrl+'opportunity/update_sector_category_subcategory', sp	, function(data) {
		  //console.log('data '+data); 
			if(_sourceAdd=="sector"){
				
			}
		})
		.done(function() { 
			console.log('updated...');
			updateCategorySectorArea();
		})
		.fail(function() {  })
		.always(function() {  });
	}
};
function checkBoxClickEvent(){
	jQuery('span.css-label').off('click').on('click',function(){
		_chk = jQuery(this).parent().parent().find('.css-checkbox');
		if(typeof _chk=="object"){
			jQuery(this).addClass('black-check').removeClass('lite-gray-check');
			if(_chk.is(':checked')==false){
				_chk.prop("checked",true);
			} else {
				_chk.prop("checked",false);
			}
			checkMeWithOther(_chk);
		}
	});
	jQuery('span.css-label2').off('click').on('click',function(){
		_chk = jQuery(this).parent().parent().find('.css-checkbox-2');
		if(typeof _chk=="object"){
			jQuery(this).addClass('black-check').removeClass('lite-gray-check');
			if(_chk.is(':checked')==false){
				_chk.prop("checked",true);
			} else {
				_chk.prop("checked",false);
			}
			checkMeWithOther(_chk,1);
		}
	});
	jQuery('span.css-label1').off('click').on('click',function(){
		_chk = "";
		_chk = jQuery(this).parent().parent().find('.css-checkbox-1');
		if(typeof _chk=="object"){
			jQuery(this).addClass('black-check').removeClass('lite-gray-check');
			if(_chk.is(':checked')==false){
				_chk.prop("checked",true);
			} else {
				_chk.prop("checked",false);
			}
			checkedMyChild(_chk);
		}
	});
	jQuery('span.css-label3').off('click').on('click',function(){
		_chk = "";
		_chk = jQuery(this).parent().parent().find('.css-checkbox-3');
		if(typeof _chk=="object"){
			jQuery(this).addClass('black-check').removeClass('lite-gray-check');
			if(_chk.is(':checked')==false){
				_chk.prop("checked",true);
			} else {
				_chk.prop("checked",false);
			}
			checkedMyChild(_chk,1);
		}
	});
}
function openForEdit(o){
	$parent = o.parents('li');
	_id = $parent.data('id');
	if(!isNaN(_id)){
		o.parents('div.listbox').find('span.show-span').hide();
		o.parents('div.listbox').find('span.edit-span').show();
	} else {
		alert("Opps problem in showing editing box.");
	}	
}
function deleteMe(o){
	$parent = o.parents('li');
	_id = $parent.data('id');
	if(!isNaN(_id)){
		jQuery("#loading").show();
		fields = {
			t:$parent.data('type'),
			id:$parent.data('id')
		};
		jQuery.post(__baseUrl+'opportunity/delete_all_types', fields	, function(data) {
		  //console.log('data '+data); 
		})
	   .done(function(d) { 
		jQuery("#loading").hide();
		 if(parseInt(d)>0){
			/*window.location = window.location.href;*/
			updateCategorySectorArea();
		 }
	   });
	} else {
		alert("Open popup again....");
	}
}
function updateMe(o){
	$inputBox = o.parents('div.listbox').find('span.edit-span').find('input[type="text"]');
	if($inputBox.length>0){
		jQuery("#loading").show();
		$parent = o.parents('li');
		_inputVal = $inputBox.val();
		fields = {
			t:$parent.data('type'),
			id:$parent.data('id'),
			name:_inputVal
		};
		jQuery.post(__baseUrl+'opportunity/update_all_types', fields	, function(data) {
		  //console.log('data '+data); 
		})
	    .done(function(d) { 
		jQuery("#loading").hide();
		if(d>0){
			$inputBox.val(_inputVal);
			o.parents('div.listbox').find('span.show-span').find('a.edit-btn').html(_inputVal); 
		}
		o.parents('div.listbox').find('span.edit-span').hide();
		o.parents('div.listbox').find('span.show-span').show();
	   });
	}	
}
function closeMe(o){
	o.parents('div.listbox').find('span.edit-span').hide();
	o.parents('div.listbox').find('span.show-span').show();
}
function checkMeWithOther(o,s){
	var secChild = o.parents('li').find("ol li");
	secChild.find('.css-label2').removeClass('lite-gray-check');
	secChild.find('.css-label3').removeClass('lite-gray-check');
	secChild.find('input[type="checkbox"]').each(function(){
		if(o.is(':checked')==true){
			jQuery(this).prop("checked",true);
		} else {
			jQuery(this).prop("checked",false);
			
		}
	});	
}
function checkedMyParent(o,s){
	$LI = o.parent().parent().parent().parent();
	if($LI.length>0){
		if(typeof s=="undefined"){
			if(o.is(':checked')===false){
				_tap = false;				
				var selParent = o.parent().parent();
				if(selParent.siblings().length>0){
					selParent.siblings().each(function(cc){
						if(jQuery(this).find('input[type="checkbox"]:checked').length>0){
							_tap = true;
							return false;
						}
					})
				}
				$LI.find('input.parent').prop('checked',_tap);
				$LI.parent().parent().find('input.css-checkbox').prop('checked',_tap);
				if(_tap===false){
					$LI.find('span.css-label1').addClass('black-check').removeClass('lite-gray-check');
					$LI.parent().parent().find('span.css-label').addClass('black-check').removeClass('lite-gray-check');
				} 
				/*$LI.parent().parent().find('span.css-label1')*/
			} else{
				$LI.find('input.parent').prop('checked',true);
				$LI.find('span.css-label1').removeClass('black-check').addClass('lite-gray-check');
				$LI.parent().parent().find('input.css-checkbox').prop('checked',true);
				$LI.parent().parent().find('span.css-label').removeClass('black-check').addClass('lite-gray-check');
				/*$LI.parent().parent().find('span.css-label1')*/
			}
		} else {
			if(o.is(':checked')===false){
				_tap = false;		
				var selParent = o.parent().parent();
				if(selParent.siblings().length>0){
					selParent.siblings().each(function(cc){
						if(jQuery(this).find('input[type="checkbox"]:checked').length>0){
							_tap = true;
							return false;
						}
					})
				}
				$LI.find('input.parent').prop('checked',_tap);
				$LI.parent().parent().find('input.css-checkbox-2').prop('checked',_tap);
				if(_tap===false){
					$LI.find('span.css-label3').addClass('black-check').removeClass('lite-gray-check');
					$LI.parent().parent().find('span.css-label2').addClass('black-check').removeClass('lite-gray-check');
				}
				/*$LI.parent().parent().find('span.css-label3')*/
			} else{
				console.log('TRUE');
				$LI.find('input.parent').prop('checked',true);
				$LI.find('span.css-label3').removeClass('black-check').addClass('lite-gray-check');
				$LI.parent().parent().find('input.css-checkbox-2').prop('checked',true);
				$LI.parent().parent().find('span.css-label2').removeClass('black-check').addClass('lite-gray-check');
				/*$LI.parent().parent().find('span.css-label3')*/
			}
		}
		
	}
}
function checkedMyChild(o,s){
	_nextChild = o.parent().next('.dd-list');
	if(_nextChild.length>0){
		_nextChild.find('li').each(function(i){
			if(o.is(':checked')){
				jQuery(this).find('input[type="checkbox"]').prop('checked',true);
			} else {
				jQuery(this).find('input[type="checkbox"]').prop('checked',false);
			}
			
		});
	}
	_string = 'input[name="company[sector][]"]';
	if(typeof s!="undefined"){
		_string = 'input[name="preferences[technology][]"]';
	}
	if(o.is(':checked')===true){
		if(typeof s=="undefined"){
			o.parent().parent().parent().parent().find(_string).next().find('span.css-label').removeClass('black-check').addClass('lite-gray-check');
		} else {
			o.parent().parent().parent().parent().find(_string).next().find('span.css-label2').removeClass('black-check').addClass('lite-gray-check');
		}
		o.parent().parent().parent().parent().find(_string).prop('checked',true);		
	} else {
		_df = false;		
		o.parent().parent().parent().parent().find('input.parent').each(function(){
			if(jQuery(this).is(':checked')){
				_df = true;
			}
		});
		if(_df===true){
			o.parent().parent().parent().parent().find(_string).prop('checked',true);
			if(typeof s=="undefined"){
			o.parent().parent().parent().parent().find(_string).next().find('span.css-label').removeClass('black-check').addClass('lite-gray-check');
			} else {
				o.parent().parent().parent().parent().find(_string).next().find('span.css-label2').removeClass('black-check').addClass('lite-gray-check');
			}
		} else {
			o.parent().parent().parent().parent().find(_string).prop('checked',false);
			if(typeof s=="undefined"){
			o.parent().parent().parent().parent().find(_string).next().find('span.css-label').addClass('black-check').removeClass('lite-gray-check');
			} else {
				o.parent().parent().parent().parent().find(_string).next().find('span.css-label2').addClass('black-check').removeClass('lite-gray-check');
			}
		}
	}
}
function addFromTop(ID,o){
	if(jQuery('#'+ID).is(':visible')){
		jQuery('#'+ID).find('.span-show').show();
		jQuery('#'+ID).hide();
		jQuery('#'+ID).find('.span-edit').hide();
		jQuery('#'+ID).find('.span-wait').hide();
		_object = o.parent().parent();
		_object.find('button[data-action="expand"]').eq(0).show();
		_object.find('button[data-action="collapse"]').eq(0).hide();
		_object.addClass('dd-collapsed');
		_object.find('ol.dd-list').eq(0).hide();
	} else {
		console.log('#'+ID);
		jQuery('#'+ID).show();
		jQuery('#'+ID).find('.span-show').hide();
		jQuery('#'+ID).find('.span-edit').show();
		jQuery('#'+ID).find('.span-wait').hide();
		_object = o.parent().parent();
		_object.find('button[data-action="expand"]').eq(0).hide();
		_object.find('button[data-action="collapse"]').eq(0).show();
		_object.removeClass('dd-collapsed');
		_object.find('ol.dd-list').eq(0).show();
	}
}
function addMe(o){
	o.parent().find('.span-show').hide();
	o.parent().find('.span-edit').show();
	o.parent().parent().find('.span-wait').hide();
} 
function cancelMe(o,s){
	console.log('cancel me1');
	o.parent().parent().find('input[type="text"]').val("");
	o.parent().parent().find('textarea').val("");
	o.parents('.nested-list-content').css('min-height','');
	o.parent().parent().find('.span-edit').hide();
	o.parent().parent().find('.span-show').show();
	o.parent().parent().find('.span-wait').hide();
	_id = o.parent().parent().parent().attr('id');
	console.log(_id);
	if(_id!="ChildT" && _id!="Child"){
		o.parent().parent().parent().hide();	
	}	
}
function addSaveMe(o){ 
	console.log(o.parent().html());
	o.parent().find('.span-wait').show();
	_t = o.parents('li').data('t');
	_p = 0;
	if(_t!="sector"){
		_p = o.parents('li').data('p');
	}	
	_n = o.parent().find('input[type="text"]').val();
	if(_n!=""){
		sp = {t:_t,p:_p,n:_n};
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/add_sector_category_subcategory',
			data:sp,
			dataType:'json',
			success:function(d){
				o.parent().find('.span-wait').hide();
				if(typeof d.id!="undefined"){
					switch(o.parents('ol').data('t')){
						case 'technology':
							_li='<li class="dd-item nested-list-item dd-collapsed" data-order="0" data-id="'+d.id+'" data-type="technology"><button data-action="collapse" type="button" style="display: none;">Collapse</button><button data-action="expand" type="button" style="display: block;">Expand</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content" style="padding-left:0px"><a href="javascript://" onclick="addFromTop(\'ulChildT'+d.id+'\',jQuery(this),1)"><i class="fa fa-long-arrow-down" style="font-size:8px;"></i></a><input type="checkbox" class="css-checkbox" name="preferences[technology][]" onchange="checkMeWithOther(jQuery(this),1)" value="'+d.id+'"><div class="listbox"><span class="show-span css-label black-check"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;">Save</a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;">Cancel</a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))">Delete</a></span></div></div><ol class="dd-list" data-t="sub-technology" style="display: none;"><li data-t="sub-technology" id="ulChildT'+d.id+'" data-p="'+d.id+'" style="display:none" class="dd-item nested-list-item adding"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><span style="display:none" class="span-edit"><input type="text" maxlength="30" style="margin-left:15px;" placeholder="Type here..."><a style="margin-left:5px;" href="javascript://" onclick="addSaveMe(jQuery(this))">Save</a><a style="margin-left:5px" href="javascript://" onclick="cancelMe(jQuery(this))">Cancel</a><span class="span-wait" style="display:none;margin-left:5px">Please wait...</span></span></div></li></ol></li>';
							o.parents('#ChildT').before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
							checkBoxClickEvent();
						break;
						case 'sub-technology':
							_dataP = d.p;
							_li='<li class="dd-item nested-list-item dd-collapsed" data-id="'+d.id+'" data-type="sub-technology"><button data-action="collapse" type="button" style="display: none;">Collapse</button><button data-action="expand" type="button" style="display: block;">Expand</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><a href="javascript://" onclick="addFromTop(\'ulChildChildT'+d.id+'\',jQuery(this),1)"><i class="fa fa-long-arrow-down" style="font-size:8px;"></i></a><input class="parent css-checkbox-1" type="checkbox" name="preferences[subtechnology][]" onclick="checkedMyChild(jQuery(this),1)" value="'+d.id+'"><div class="listbox"><span class="show-span css-label1 black-check"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;">Update</a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;">Cancel</a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))">Delete</a></span></div></div><ol class="dd-list sub-child" data-t="subsub-technology"><li id="ulChildChildT'+d.id+'" data-t="subsub-technology" data-p="'+d.id+'" class="dd-item nested-list-item adding" style="display:none"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><span style="display:none" class="span-edit"><input type="text" maxlength="30" style="margin-left:30px;" placeholder="Type here..."><a style="margin-left:5px;" href="javascript://" onclick="addSaveMe(jQuery(this))">Save</a><a style="margin-left:5px" href="javascript://" onclick="cancelMe(jQuery(this))">Cancel</a><span class="span-wait" style="display:none;margin-left:5px">Please wait...</span></span></div></li></ol></li>';
							o.parents('#ulChildT'+_dataP).before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('#ulChildT'+_dataP).hide();
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
							checkBoxClickEvent();
						break;
						case 'subsub-technology':
							_dataP = d.p;
							_li='<li class="dd-item nested-list-item" data-id="'+d.id+'" data-type="subsub-technology"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><input class="child" type="checkbox" name="sub[technology][]" onclick="checkedMyParent(jQuery(this),1)" value="'+d.id+'"><div class="listbox"><span class="show-span"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;">Update</a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;">Cancel</a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))">Delete</a></span></div></div></li>';
							o.parents('#ulChildChildT'+_dataP).before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('#ulChildChildT'+_dataP).hide();
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
						break;
						case 'sector':
							_li='<li class="dd-item nested-list-item dd-collapsed" data-order="0" data-id="'+d.id+'" data-type="sector"><button data-action="collapse" type="button" style="display: none;">Collapse</button><button data-action="expand" type="button" style="display: block;">Expand</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content" style="padding-left:0px"><a href="javascript://" onclick="addFromTop(\'ulChild'+d.id+'\',jQuery(this))"><i class="fa fa-long-arrow-down" style="font-size:8px;"></i></a><input type="checkbox" class="css-checkbox" name="company[sector][]" onchange="checkMeWithOther(jQuery(this))" value="'+d.id+'"><div class="listbox"><span class="show-span css-label black-check"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-check"></i></a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-times"></i></a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))"><i class="fa fa-trash"></i></a></span></div></div><ol class="dd-list" data-t="category"><li data-t="category" id="ulChild'+d.id+'" data-p="'+d.id+'" class="dd-item nested-list-item adding" style="display: none;"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><span style="display:none" class="span-edit"><input type="text" maxlength="30" style="margin-left:15px;" placeholder="Type here..."><a style="margin-left:5px;" href="javascript://" onclick="addSaveMe(jQuery(this))"><i class="fa fa-check"></i></a><a style="margin-left:5px" href="javascript://" onclick="cancelMe(jQuery(this))"><i class="fa fa-times"></i></a><span class="span-wait" style="display:none;margin-left:5px">Please wait...</span></span></div></li></ol></li>';
							o.parents('#Child').before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
							checkBoxClickEvent();
						break;
						case 'category':
							console.log('Case 1');
							_dataP = d.p;
							_li='<li class="dd-item nested-list-item dd-collapsed" data-id="'+d.id+'" data-type="category"><button data-action="collapse" type="button" style="display: none;">Collapse</button><button data-action="expand" type="button" style="display: block;">Expand</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><a href="javascript://" onclick="addFromTop(\'ulChildChild'+d.id+'\',jQuery(this),1)"><i class="fa fa-long-arrow-down" style="font-size:8px;"></i></a><input class="parent css-checkbox-1" type="checkbox" name="preferences[departments][]" onclick="checkedMyChild(jQuery(this))" value="'+d.id+'"><div class="listbox"><span class="show-span css-label1 black-check"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-check"></i></a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-times"></i></a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))"><i class="fa fa-trash"></i></a></span></div></div><ol class="dd-list sub-child" data-t="subcategory" ><li id="ulChildChild'+d.id+'" data-t="sub-category" data-p="'+d.id+'" class="dd-item nested-list-item adding" style="display: none;"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><span style="display:none" class="span-edit"><input type="text" maxlength="30" style="margin-left:30px;" placeholder="Type here..."><a style="margin-left:5px;" href="javascript://" onclick="addSaveMe(jQuery(this))"><i class="fa fa-check"></i></a><a style="margin-left:5px" href="javascript://" onclick="cancelMe(jQuery(this))"><i class="fa fa-times"></i></a><span class="span-wait" style="display:none;margin-left:5px">Please wait...</span></span></div></li></ol></li>';
							o.parents('#ulChild'+_dataP).before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('#ulChild'+_dataP).hide();
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
							checkBoxClickEvent();
						break;
						case 'subcategory':
							_dataP = d.p;
							_li='<li class="dd-item nested-list-item" data-id="'+d.id+'" data-type="subcategory"><button data-action="cancel">&nbsp;</button><div class="dd-handle nested-list-handle dd-nodrag"></div><div class="nested-list-content"><input class="child" type="checkbox" name="sub[departments][]" onclick="checkedMyParent(jQuery(this))" value="'+d.id+'"><div class="listbox"><span class="show-span"><a class="edit-btn" href="javascript://" onclick="openForEdit(jQuery(this))">'+d.n+'</a></span><span class="edit-span" style="display:none"><input type="text" class="form-control" style="width:250px;display:inline;" value="'+d.n+'"><a href="javascript://" onclick="updateMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-check"></i></a><a href="javascript://" onclick="closeMe(jQuery(this));" style="margin-left:5px;"><i class="fa fa-times"></i></a><a class="btn-delete" style="margin-left:5px;" href="javascript://" onclick="deleteMe(jQuery(this))"><i class="fa fa-trash"></i></a></span></div></div></li>';
							o.parents('#ulChildChild'+_dataP).before(_li);
							o.parents('ol').find('.span-edit').find('input').val('');
							o.parents('#ulChildChild'+_dataP).hide();
							o.parents('ol').find('.span-edit').hide();
							o.parents('ol').find('.span-show').show();
							o.parents('ol').find('.span-wait').hide();
						break;
					}
				} else {
					alert('Please try again later.');
				}				
			}
		});
	} else {
		alert("Please fill the name.");
	}
}
function updateCategorySectorArea(){
	window.location = window.location.href;	
}
function callNestable(){
	jQuery('#nestable').nestable(__options);		
	jQuery('#nestable1').nestable(__options1);	
	jQuery(".dd-nodrag").on("mousedown", function(event) {
		event.preventDefault();
		return false;
	});
	jQuery("button[data-action='cancel']").click(function(e){
		e.preventDefault();
		return false;
	});
}
function openClassify(){
	if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
		_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,start:0,end:0,sort_field:_sortField,sort_by:_sortBy};
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/scrapeAllCompaniesByFilterIDs',
			cache:false,
			data:_filters,
			dataType:'json'
		}).done(function(d){
			if(d.length>0){
				_merger = d;
				if(_merger.length>0){
					jQuery('#nestable').nestable('destroy');	
					jQuery('#nestable1').nestable('destroy');
					jQuery('button[data-action="collapse"],button[data-action="expand"]').remove();
					jQuery('#nestable input[type="checkbox"]').prop('checked',false);
					jQuery('#nestable1 input[type="checkbox"]').prop('checked',false);
					jQuery('.show-span').removeClass('lite-gray-check').addClass('black-check').css('display','inline-block');
					jQuery('.edit-span').css('display','none');
					if(_merger.length == 1){
						findSectorsFromCompanies(_merger);
					}
					jQuery("#classify").modal("show");
					setTimeout(function(){callNestable();},100);
				} else {
					alert("No company found");
				}				
			} else {
				alert("No company found");
			}
		});
	} else if(jQuery('input[name="general_select_bulk[]"]:checked').length>0){
		_merger=[];
		jQuery('input[name="general_select_bulk[]"]:checked').each(function(){
			_merger.push(jQuery(this).val());
		});
		jQuery('#nestable').nestable('destroy');	
		jQuery('#nestable1').nestable('destroy');
		jQuery('button[data-action="collapse"],button[data-action="expand"]').remove();
		jQuery('#nestable input[type="checkbox"]').prop('checked',false);
		jQuery('#nestable1 input[type="checkbox"]').prop('checked',false);
		jQuery('.show-span').removeClass('lite-gray-check').addClass('black-check').css('display','inline-block');
		jQuery('.edit-span').css('display','none');
		if(jQuery('input[name="general_select_bulk[]"]:checked').length==1){
			findSectorsFromCompanies(_merger);
		}
		jQuery("#classify").modal("show");
		setTimeout(function(){callNestable();},100);
	} else {
		alert("Please select companies first.")
	}
}
_selectedCompanies = [];
_unselectedCompanies = [];
function selectedMe(o){
	console.log("Me selected");
	if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
		if(o.is(':checked')===false){
			_unselectedCompanies.push(o.val());
		} else {
			if(_unselectedCompanies.length>0 && _unselectedCompanies.indexOf(o.val())>=0){
				_unselectedCompanies.splice(_unselectedCompanies.indexOf(o.val()),1);
			}
		}
	}else {
		if(o.is(':checked')===false){
			if(_selectedCompanies.length>0 && _selectedCompanies.indexOf(o.val())>=0){
				_selectedCompanies.splice(_selectedCompanies.indexOf(o.val()),1);
			}
		} else {
			_selectedCompanies.push(o.val());
		}
	}
}
function findSectorsFromCompanies(c){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/find_companies_to_sectors_categories_technology',
		data:{companies:c},
		dataType:'json'
	}).done(function(d){
		var _frm = jQuery("#frmClassification");
		if(d.sectors.length>0){
			jQuery.each(d.sectors,function(i,s){
				/*jQuery('input[value="'+s.sector_id+'"]').trigger('click');*/
				_frm.find("li[data-type='sector']").find('input[name="company[sector][]"]').each(function(){
					if(jQuery(this).val() == s){
						var $this = jQuery(this);
						$this.prop("checked",true).next().find('span.show-span').removeClass('black-check').removeClass('lite-gray-check').addClass('black-check');
						_tapFind = false;
						_findAll = 0;
						var $catO = $this.parent().next('ol[data-t="category"]');
						var $catOL = $catO.find("li[data-type='category']");
						if(d.categories.length>0){
							$catOL.each(function(){
								var $thisCate = jQuery(this);
								if(d.categories.length>0){
									jQuery.each(d.categories,function(i,c){
										if($thisCate.find('input[name="preferences[departments][]"]').val() == c){
											$thisCate.find('input[name="preferences[departments][]"]').prop('checked',true).next().find('span.show-span').removeClass('black-check').removeClass('lite-gray-check').addClass('black-check');
											if(_tapFind===false){
												_tapFind = true;
											}
											_findAll++;
											/*Sub Category*/
											_findSubCate = false;
											_findSubCateAll = 0;
											var $subCatO = $catO.find('ol[data-t="subcategory"]');
											if($subCatO.length>0){
												var $subCatOL = $catOL.find("li[data-type='subcategory']");
												$subCatOL.each(function(){
													var $thisSubCate = jQuery(this);
													if(d.subcategories.length>0){
														jQuery.each(d.subcategories,function(i,sc){
															if($thisSubCate.find('input[name="sub[departments][]"]').val() == sc){
																$thisSubCate.find('input[name="sub[departments][]"]').prop('checked',true);
																if(_findSubCate===false){
																	_findSubCate = true;
																}
																_findSubCateAll++;
															}
														});
													}
													if(_findSubCateAll == $subCatO.find('input[name="sub[departments][]"]').length){
														$thisCate.find('input[name="preferences[departments][]"]').next().find('span.show-span').removeClass('black-check').removeClass('lite-gray-check').addClass('black-check');
													} else if(_findSubCateAll>0 && _findSubCateAll!=$subCatO.find('input[name="sub[departments][]"]').length){
														$thisCate.find('input[name="preferences[departments][]"]').next().find('span.show-span').removeClass('black-check').removeClass('lite-gray-check').addClass('lite-gray-check');
													}
												})
											}
											return false;
										}
									});
								}
							});
							if(_findAll == $catO.find('input[name="preferences[departments][]"]').length){
								$this.next().find('span.show-span').removeClass('black-check').removeClass('lite-gray-check').addClass('black-check');
							} else if(_findAll>0 && _findAll!=$catO.find('input[name="preferences[departments][]"]').length){
								$this.next().find('span.show-span').removeClass('black-check').removeClass('lite-gray-check').addClass('lite-gray-check');
							}
						}
						if(_tapFind === false){
							$catO.find('input[type="checkbox"]').prop('checked',true);
						}
						/*Check Category*/						
						return false;
					}
				});
			});
		}
		if(d.technologies.length>0){
			jQuery.each(d.technologies,function(i,t){
				/*jQuery('input[value="'+s.sector_id+'"]').trigger('click');*/
				_frm.find("li[data-type='technology']").find('input[name="preferences[technology][]"]').each(function(){
					if(jQuery(this).val() == t){
						var $this = jQuery(this);
						$this.prop("checked",true).next().find('span.show-span').removeClass('black-check').removeClass('lite-gray-check').addClass('black-check');
						if(d.technologies.length>0){
							var $subTecO = $this.parent().next('ol[data-t="sub-technology"]');
						    var $subTecOL = $subTecO.find("li[data-type='sub-technology']");
							if($subTecOL.length>0){
								$subTecOL.each(function(){
									var $subThis = jQuery(this);
									jQuery.each(d.subtechnologies,function(i,st){
										if($subThis.find('input[name="preferences[subtechnology][]"]').val()==st){
											$subThis.find('input[name="preferences[subtechnology][]"]').prop('checked',true);
											if(d.subsubtechnologies.length>0){
												if($subThis.find('ol[data-t="subsub-technology"]').length>0){
													var $subSubO = $subThis.find('ol[data-t="subsub-technology"]');
													if($subSubO.find('li[data-t="subsub-technology"]').length>0){
														var $subSubOL = $subSubO.find('li[data-t="subsub-technology"]');
														$subSubOL.each(function(){
															if($subSubOL.find('input[name="sub[technology][]"]').length>0){
																jQuery.each(d.subsubtechnologies,function(j,sst){
																	if($subSubOL.find('input[name="sub[technology][]"]').val()==sst){
																		$subSubOL.find('input[name="sub[technology][]"]').prop('checked',true);
																		return false;
																	}
																});
															}
														})
													}
												}
											}
											return false;
										}
									});
								});
							}
							
						}
						return false;
					}
				});
			});
		}
	}).always(function(){
		setTimeout(function(){callNestable();},100);
	});
}
function addSelectedCompanyToSector(){
	if(jQuery('.fixedHeader').find('th').eq(1).find('input[type="checkbox"]:checked').length>0){
		jQuery("#btnAddClassify").html('Loading...');
		_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,start:0,end:0,sort_field:_sortField,sort_by:_sortBy};
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/scrapeAllCompaniesByFilterIDs',
			cache:false,
			data:_filters,
			dataType:'json'
		}).done(function(d){
			_merger=[];
			if(d.length>0){
				_merger = d;
			}
			jQuery("#companies_sel").val(JSON.stringify(_merger));
			jQuery("#mode").val(1);
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'opportunity/add_companies_to_sectors',
				data:jQuery("#frmClassification").serialize(),
				dataType:'json'
			}).done(function(d){
				jQuery("#classify").modal("hide");
				/*window.location = window.location.href;*/
				
			}).always(function(){
				jQuery("#btnAddClassify").html('Add');
				jQuery("#rs tbody").find("tr").remove();
				loadTableWithNewData(true,0,200);
			});
		});
		
	} else {
	_companiesObj = jQuery('input[name="general_select_bulk[]"]:checked');
	if(_companiesObj.length>0){
		jQuery("#btnAddClassify").html('Loading...');
		_selectedC = [];
		_companiesObj.each(function(){
			_selectedC.push(jQuery(this).val());
		});
		jQuery("#companies_sel").val(JSON.stringify(_selectedC));
		jQuery("#mode").val(0);
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/add_companies_to_sectors',
			data:jQuery("#frmClassification").serializeArray(),
			dataType:'json'
		}).done(function(d){
			jQuery("#classify").modal("hide");
			if(d.error==0){
				_companiesObj.prop('checked',false);
				if(typeof d.data!=null && typeof d.data !='undefined'){
					if(d.data.length>0){
						_companiesList = d.data;
						_tableObj = jQuery("#rs").find('tbody tr.master');
						jQuery.each(_companiesList,function(i,c){
							_company = c.company;
							_dData = c.data;
							_inputObj = _tableObj.find('input[value="'+_company+'"]');
							if(_inputObj.length>0){
								var trObj = _inputObj.eq(0).parents('tr');
								trObj.find('td').eq(10).text(_dData.sectorName);
								_categoryName = _dData.department_names;
								if(_categoryName!=""){
									_categoryName = _categoryName.split(',');
									_categoryName =_categoryName.join('<br/>')
								}								
								trObj.find('td').eq(11).html("<div class='overwrap'>"+_categoryName+"</div>");
								_subCateName = [];
								if(_dData.sub_department_names!=false){
									_subCateName = _dData.sub_department_names;
								}
								if(_subCateName!=""){
									_subCateName = _subCateName.split(',');
									_subCateName =_subCateName.join('<br/>')
								}								
								trObj.find('td').eq(12).html("<div class='overwrap'>"+_subCateName+"</div>");
								_techName = _dData.technology_names;
								if(_techName!=""){
									_techName = _techName.split(',');
									_techName =_techName.join('<br/>')
								}
								trObj.find('td').eq(13).html("<div class='overwrap'>"+_techName+"</div>");
								_subTechName =_dData.sub_technology_names;
								if(_subTechName!=""){
									_subTechName = _subTechName.split(',');
									_subTechName =_subTechName.join('<br/>')
								}
								trObj.find('td').eq(14).html("<div class='overwrap'>"+_subTechName+"</div>");
							}
						});
					}
				}
			} else {
				alert(d.message);
			}
		}).always(function(){
			jQuery("#btnAddClassify").html('Add');
		});
	} else {
		alert("Please select companies first.");
	}
	}
}
function openActivityBox(cID,uID){
	if(jQuery("#profileLead").val()>0 && jQuery("#profileListType").val()>0){
		var _activityTable,_parent;
		if(typeof window.parent.openEvenDialogFront=== 'function'){
			switch(parseInt(jQuery("#profileListType").val())){
				case 1:
					if(window.parent.jQuery("#activityTable").hasClass("show")){
						_activityTable = window.parent.jQuery("#activityTable");
						_parent = window.parent;
					}
				break;
				case 2:
					if(window.parent.jQuery("#aquisitionTable").hasClass("show")){
						_activityTable = window.parent.jQuery("#aquisitionTable");
						_parent = window.parent;
					}
				break;
			}
		} else if(typeof window.parent.parent.openEvenDialogFront=== 'function'){
			switch(parseInt(jQuery("#profileListType").val())){
				case 1:
					if(window.parent.parent.jQuery("#activityTable").hasClass("show")){
						_activityTable = window.parent.parent.jQuery("#activityTable");
						_parent = window.parent.parent;
					}
				break;
				case 2:
					if(window.parent.parent.jQuery("#aquisitionTable").hasClass("show")){
						_activityTable = window.parent.parent.jQuery("#aquisitionTable");
						_parent = window.parent.parent;
					}
				break;
			}			
		}
		if(typeof _activityTable === 'object'){
			_trObject = _activityTable.find('tbody').find('tr.master[data-c="'+cID+'"]');
			if(_trObject.length>0){
				if(_trObject.next().find('input[value="'+uID+'"]').length>0){
					_parent.openEvenDialogFront(_trObject.next().find('input[value="'+uID+'"]'),cID,uID,1);
				}
			}else{
				alert("Activity table not found1.");
			}				
		}else{
			alert("Activity table not found2.");
		}
	} else if(jQuery("#profileLead").val()==0){
		alert("Please select lead first.");
	} else if(jQuery("#profileListType").val()==0){
		alert("Please select type of activity.");
	}
}
</script>
</script>