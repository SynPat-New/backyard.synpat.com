<?php 
	$market_sectors = getAllMarketSectors();
?>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
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
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/slimscroll/slimscroll.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>jquery.tablesorter.min.js"></script> 
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/custom.css"/>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/menu.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/autocomplete.js"></script>
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
table.fixedHeader th{border:0px !important;border-right:solid 1px #d1c8c8 !important}
table.tableData td{border-top:0px !important;border-right:0px !important;height:20px;min-height:20px;}
table.tableData tr.master td:last-child{border-right:solid 1px #d1c8c8 !important;}
.button-list{border:1px solid #d1c8c8;padding:0px 0px 3px 6px;cursor:pointer;float:right;}
table.tableData tr:first-child td{border-top:solid 0px #d1c8c8 !important}
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
.table{border:1px #d1c8c8 !important;}
.mrg20L {margin-left:15px !important;}
.table > thead > tr > th {
    font-weight: normal;
    font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
	border-bottom: solid 1px #d1c8c8 !important;
	border-top: solid 1px #d1c8c8 !important;
}
.containerResearchHeader .table > thead > tr > th:first-child{
	border-left: solid 1px #d1c8c8 !important;
}
.containerResearchHeader .table > thead > tr > th:last-child{
	border-right: solid 1px #d1c8c8 !important;
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
 tr.cu table.sbo thead th, tr.cu table.sbo tbody td{/*border-bottom:1px solid #d1c8c8  !important;border-right:1px solid #d1c8c8 !important;*/}
 tr.cu table.sbo thead th, tr.cu table.sbo tbody td{padding:4px !important;}
 tr.cu table.sbo thead th{cursor:pointer;}
 tr.cu table.sbo thead th:last-child, tr.cu table.sbo tbody td:last-child{border-right:0px !important;}
 tr.cu table.sbo thead th.headerSortDown{background: url(http://backyard.synpat.com/public/images/sort_desc.png);    background-repeat: no-repeat;background-position: right;background-color: #fff;}
tr.cu table.sbo thead th.headerSortUp{background: url(http://backyard.synpat.com/public/images/sort_asc.png);    background-repeat: no-repeat;background-position: right;background-color: #fff;}tr.boldT td{font-weight:bold;}
.fa{margin-left:5px;}
div.overwrap{white-space: nowrap; overflow: hidden;text-overflow: ellipsis;height:20px;}
</style>
<h4 id='cn'>Companies  <span id='loading_message' style='margin-left:100px'></span></h4>
<div class="row mainT">	
	<div class="col-xs-12" style='width:100%;'>		
		<div class="row btnList" style='margin-bottom:10px;'>
			<div class="col-xs-12">
				<a href='javascript://' onclick="openAddForm()" class='btn btn-primary pull-left mrg5R'>Add a Company</a>
				<a href='javascript://' onclick="mergeCompanies()" class='btn btn-primary pull-left mrg5R'>Merge</a>
				<a href='javascript://' onclick="scrapeAllSelectedCompanies()" class='btn btn-primary pull-left mrg5R'>Scrape</a>
				<!--<a href='javascript://' onclick="scrapeSelectedCompanies()" class='btn btn-primary pull-left mrg5R'>Scrape Companies</a>-->
				<a style="" href="javascript://" onclick="deleteGoogleContact()" class="btn btn-primary pull-left mrg5R">Delete</a>
				<input type='text' placeholder='Search...' id='search_field' style='height:26px;min-height:26px;padding:4px 6px; color:#2b2f33;width:300px;' name='search_field' class='form-control pull-left'/>
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
var minTable = document.getElementById("companies_box");
_companiesINString = [];
_companiesINString=[<?php
		$insertID = array();
		for ($i = 0; $i < count($companies); $i++) {
			if(!in_array((int)$companies[$i]->id,$insertID)):
			$insertID[] = (int)$companies[$i]->id;
			$selected = 0;
			$usersCount = 0;
			if($companies[$i]->company_users!=null){
				$usersCount = $companies[$i]->company_users;
			}
			$specialist = $companies[$i]->specialties;
			echo "{'id':". $companies[$i]->id.",'company_size':".$companies[$i]->company_size.",'specialist':".$specialist.",'industry':".$companies[$i]->industry.",'selected':".$selected.",'company_name':'" . addslashes($companies[$i]->company_name) . "','no_of_users':'" . $usersCount . "','sectors':'" . $companies[$i]->sectorName . "','categories':'" . $companies[$i]->department_names . "','sub_category':'" . $companies[$i]->sub_department_names . "','scrapped_date':'".$companies[$i]->scrapped_date."','linkedin_url':'".$companies[$i]->linkedin_url."'}";
			if ($i < count($companies) - 1) {
				echo ",";
			}
			endif;
		}
	?>];
_sectors = [
	<?php 
		if(count($market_sectors)>0){
			$i=0;
			foreach($market_sectors as $sector){
				$name = $sector->name;
				$name = trim($name);
				$name = preg_replace("/\'/", '', $name);
				$name = preg_replace('/\"/', '', $name);
				$name = addcslashes($name,"'");
				echo "{'id':".$sector->id.",'name':'".$name."'}";
				if ($i < count($market_sectors) - 1) {
					echo ",";
				}
			}
		}
	?>
];
userColumns = ["General <input type='checkbox' onclick='checkedMeAll(jQuery(this))'/>","Merging","Survivor","Company","Users","Lin","Size","Industry","Specialist","Sectors","Categories","SubCategories"];
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
			_scrollTable = true;
			loadTableWithNewData(true,0,200);
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
		},400);
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
			findContactsForThisCompany(ui.item.label);
		}
	});
});
var _companyWidth = 200;
function checkedMeAll(o){
	_checked = false;
	if(o.is(':checked')){
		_checked = true;
	}
	jQuery("#rs").find('input[class="general"]').each(function(){
		var tdL = jQuery(this).find
		jQuery(this).prop('checked',_checked);
	});
}
function scrapeOnRun(o){
	var _companyID = o.parent().find('input[class="general"]').val();
	var $thisP = o.parents('tr');
	var $trNext = $thisP.next();
	if($trNext.hasClass('cu')){
		var $table = $trNext.find('table.sbo');
		_userList = {};
		_userList.company = _companyID;
		_userList.type = 2;
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
				window.parent.sendScrapperRequest(2);
			}								
		}
	}
}
function scrapeSelectedCompanies(){
	/*Scrape Companies List*/
	if(jQuery('input[class="general"]:checked').length>0){
		var iDS = [];
		jQuery('input[class="general"]:checked').each(function(i){			
			linkedINUrl = jQuery(this).attr('data-linkedin');
			if(linkedINUrl.indexOf('linkedin.com')>=0){
				var scrapCompany = {company:jQuery(this).val(),url:linkedINUrl,type:22};
				checkCompanyQueList(scrapCompany);
				if(i==0){
					if(window.parent.scraperCompanyRequest==null || (typeof window.parent.scraperCompanyRequest.readyState!=undefined && window.parent.scraperCompanyRequest.readyState==4)){
						window.parent.sendScrapperCompanyRequest(11);
					}
				}				
			}
		});	
	}
}
function checkCompanyQueList(scrapCompany){
	if(window.parent.companyQuList.length==0){
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
			window.parent.companyQuList.push(scrapCompany);
		}
	}	
}
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
function scrapeAllSelectedCompanies(){
	if(jQuery('input[class="general"]:checked').length>0){
		var iDS = [];
		jQuery('input[class="general"]:checked').each(function(){
			iDS.push(jQuery(this).val());
		});		
		jQuery.ajax({
			url:__baseUrl+'opportunity/findAllCompaniesUsers',
			type:'POST',
			data:{c:JSON.stringify(iDS),t:2,p:0},
			dataType:'json',
			success:function(d){
				if(d.length>0){
					jQuery.each(d,function(s,user){
						checkQueList(user);
						if(s==0){
							if(window.parent.scraperRequest==null || (typeof window.parent.scraperRequest.readyState!=undefined && window.parent.scraperRequest.readyState==4)){
								window.parent.sendScrapperRequest(2);
							}
						}
					});
				}
			}
		});
	} else {
		alert("Please select companies first.");
	}
	scrapeSelectedCompanies();
}
function findContactsForThisCompany(ID){
	jQuery.ajax({
		url: __baseUrl+'opportunity/find_company_detail/0/'+ID+'/0',
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
function addDataToTable(d,s){
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
		_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.id+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='window.parent.openCompanyEdit("+u.id+")'>"+u.company_name+"</a>";
		_tableBodyTr =jQuery("<tr/>").attr('id',_increment).addClass(_addclass);
		
		/*_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='vendor_select_bulk[]' class='checker' "+_checked+" value='"+u.id+"' onchange='checkedMe(jQuery(this))'/>");
		_tableBodyTr.append(_tableBodyTd);*/
		/*General*/
		cDate = u.scrapped_date;
		if(cDate=='0000-00-00'){
			cDate = "Scrape";
		} else {
			cDate = moment(new Date(cDate)).format('MM/DD/YY');
		}
		_anchor = "<a class='scrape_date' href='javascript://' onclick='scrapeOnRun(jQuery(this))'>"+cDate+"</a>";
		_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='general_select_bulk[]' class='general' value='"+u.id+"' data-linkedin='"+u.linkedin_url+"'/> "+_anchor);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").addClass('merger').append("<input type='checkbox' class='merger_chk' value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		_tableBodyTd = jQuery("<td/>").addClass('survivor').append("<input type='checkbox' class='survivor_chk' value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		if(_color!=""){
			_tableBodyTd = jQuery("<td/>").css('background-color',_color).append(_htmlName);
		} else {
			_tableBodyTd = jQuery("<td/>").append(_htmlName);
		}
		_ddive = jQuery("<span/>").append(_htmlName).css({visibility:'hidden'});
		_ddive.appendTo('body')
		_widtha = _ddive.width();
		if(_widtha>_companyWidth){
			_companyWidth = _widtha;
		}
		_ddive.remove();
		_tableBodyTr.append(_tableBodyTd);
		_noOfUsers = 0;
		if(u.no_of_users!="undefined" && u.no_of_users>0){
			_noOfUsers = u.no_of_users;
		} else if(u.company_users!="undefined" && u.company_users>0){
			_noOfUsers = u.company_users;
		}		
		_tableBodyTd = jQuery("<td/>").append(_noOfUsers);
		_tableBodyTr.append(_tableBodyTd);
		_linkedIn = u.linkedin_url;
		if(_linkedIn.indexOf('linkedin')>=0){
			_linkedIn = "In";
		}
		_tableBodyTd = jQuery("<td/>").append(_linkedIn);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.company_size);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.industry);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.specialist);
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
		_fullHTML += _tableBodyTr.prop('outerHTML');
		/*_fullHTML += _contactsTr.prop('outerHTML');*/
		_increment++;
	});
	jQuery("#rs tbody").append(_fullHTML);		
	toggleActivity();
	setTimeout(function(){_requestAlreadySend = false;},1000);
	resizeTable(0);
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
		parentTh.find(".list_options").find('.p-absolute').css({height:'320px',top:31,left:_position.left,width:_width+'px',background:'#fff',border:'1px solid #d1c8c8'});
	}
}
function searchFilter(o){
	var parentTH = o.parents('th');
	parentTH.addClass('open');
	var _filterName = parentTH.attr('filter-name');
	switch(_filterName){
		case 'sector':
			_filterSector = [];
			if(parentTH.find('input[type="checkbox"]:checked').length>0){
				parentTH.find('input[type="checkbox"]:checked').each(function(){
					_filterSector.push(jQuery(this).val());
				});
			}
		break;
		case 'cat':
			_filterSubType = [];
			if(parentTH.find('input[type="checkbox"]:checked').length>0){
				parentTH.find('input[type="checkbox"]:checked').each(function(){
					_filterSubType.push(jQuery(this).val());
				});
			}
		break;
		case 'sub_cate':
			_filterSubTech = [];
			if(parentTH.find('input[type="checkbox"]:checked').length>0){
				parentTH.find('input[type="checkbox"]:checked').each(function(){
					_filterSubTech.push(jQuery(this).val());
				});
			}
		break;
	}
	parentTH.find(".list_options").find('.p-absolute').parent().hide();
	jQuery("#rs tbody").find("tr").remove();
	_scrollTable = true;
	loadTableWithNewData(true,0,200);
}
function clearFilter(o){
	var parentTH = o.parents('th');
	parentTH.removeClass('open');
	var _filterName = parentTH.attr('filter-name');
	switch(_filterName){
		case 'sector':
			_filterSector=[];
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
	_scrollTable = true;
	loadTableWithNewData(true,0,200);
}
function showContactsTable(){
	_tableFixedHeader = jQuery("<thead/>");
	_tableFixedHeaderTr = jQuery("<tr/>");
	jQuery.each(userColumns,function(i,c){			
		if(c=="#"){
			_tableFixedHeaderTh = jQuery("<th/>").append("<span class='colHeader'></span><input type='checkbox' onchange='checkInputAll(this)' style='margin:0 8px 0 9px;position:relative;top:0px;'/>");
		} else {
			_filterICON = "";
			_sortICON = "";
			_class="";
			_sortName = "";
			_filterField = "";
			if(i==5 || i==6 || i==7){
				_filterICON = "<span class='button-list'><i class='fa fa-sort-down'></i></span>";
				_class = "filter";
			}
			if(i==3){
				_sortICON = "<span class='p-relative'><i class='icon-default p-absolute sort'></i></span>";
				if(_class==""){
					_class = "sortIcon";
				} else {
					_class = "filter-sort"
				}
			}
			if(_class=="filter" || _class=="filter-sort"){
				switch(i){
					case 10:
						_list = getSectors();
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-left mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
						_filterField = "sector";
					break;
					case 11:
						_list = "";
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-left mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
						_filterField = "sub_type";
					break;
					case 12:
						_list = "";
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-left mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
						_filterField = "tech";
					break;
				}
			}
			switch(i){
				case 3:
					_sortName = "company_name";
				break;
			}
			_tableFixedHeaderTh = jQuery("<th/>").attr('sort-name',_sortName).attr('filter-name',_filterField).append(_sortICON+"<span class='"+_class+"'>"+c+"</span>"+_filterICON);
			_tableFixedHeaderTh.find('.button-list').off('click').on('click',function(){
				openFilterList(jQuery(this));
			});
		}		
		_tableFixedHeaderTr.append(_tableFixedHeaderTh);
	});
	_tableFixedHeader.append(_tableFixedHeaderTr);
	_tableBody = jQuery("<tbody/>");
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
		/*_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='vendor_select_bulk[]' class='checker' value='"+u.id+"' "+_checked+" onchange='checkedMe(jQuery(this))'/>");
		_tableBodyTr.append(_tableBodyTd);*/

		/*General*/
		cDate = u.scrapped_date;
		if(cDate=='0000-00-00'){
			cDate = "Scrape";
		} else {
			cDate = moment(new Date(cDate)).format('MM/DD/YY');
		}
		_anchor = "<a class='scrape_date' href='javascript://' onclick='scrapeOnRun(jQuery(this))'>"+cDate+"</a>";
		_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='general_select_bulk[]' class='general' value='"+u.id+"' data-linkedin='"+u.linkedin_url+"'/> "+_anchor);
		_tableBodyTr.append(_tableBodyTd);
		
		_tableBodyTd = jQuery("<td/>").addClass('merger').append("<input type='checkbox' class='merger_chk' value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		_tableBodyTd = jQuery("<td/>").addClass('survivor').append("<input type='checkbox' class='survivor_chk' value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		
		_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.id+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='window.parent.openCompanyEdit("+u.id+")'>"+u.company_name+"</a>";		
		_tableBodyTd = jQuery("<td/>").append(_htmlName);
		_ddive = jQuery("<span/>").append(_htmlName).css({visibility:'hidden'});
		_ddive.appendTo('body')
		_widtha = _ddive.width();
		if(_widtha>_companyWidth){
			_companyWidth = _widtha;
		}
		_ddive.remove();
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.no_of_users);
		_tableBodyTr.append(_tableBodyTd);
		_linkedIn = u.linkedin_url;
		if(_linkedIn.indexOf('linkedin')>=0){
			_linkedIn = "In";
		}
		_tableBodyTd = jQuery("<td/>").append(_linkedIn);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.company_size);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.industry);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.specialist);
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
	setTimeout(function(){resizeTable(1)},100);
}
var _userList = [];
var queList = [];
var nS = 0;
function toggleActivity(){
	if(jQuery("#rs tbody tr.main").length>0){
		jQuery("#rs tbody tr.main").each(function(){
			jQuery(this).find('a.showActivity').off('click').on('click',function(){
				if(jQuery(this).hasClass('open')===true){
					var parentTr = jQuery(this).parent().parent().next()
					if(parentTr.hasClass('cu')){
						parentTr.remove();
						jQuery(this).removeClass('open');
						jQuery(this).find('i.fa').removeClass('fa-chevron-down').addClass('fa-chevron-right');
					}					
				} else {
					/*jQuery("#rs tbody tr.cu").remove();*/
					jQuery(this).addClass('open')
					jQuery(this).find('i.fa').removeClass('fa-chevron-right').addClass('fa-chevron-down');
					var companyID = jQuery(this).attr('data-id');
					var parentTr = jQuery(this).parent().parent();
					jQuery.ajax({
						url:__baseUrl+'opportunity/find_company_users',
						type:'POST',
						data:{c:companyID,p:0},
						dataType:'json',
						cache:false
					}).done(function(d){
						if(d.length>0){						
							_contactsTr = jQuery("<tr/>").addClass('cu')
							_contactTd = jQuery("<td/>").addClass('c1').attr('colspan',8);
							_contactTdTable= jQuery('<table/>').addClass('table sbo').css({border:'0px'});
							_contactTdTableThead = jQuery("<thead/>").append("<tr><th>#</th><th>Name</th><th>C</th><th>CC</th><th>Current C</th><th>Title</th></tr>");
							_contactTdTable.append(_contactTdTableThead);
							_contactTdTableTbody = jQuery("<tbody/>");
							_userList = {};
							_userList.company = companyID;
							_userList.type = 2;
							_userList.list = [];
							jQuery.each(d,function(k,cu){
								var tr = jQuery("<tr/>").attr("data-ur",cu.id);
								linkedinURL = cu.linkedin_url;
								if(linkedinURL.indexOf('linkedin')>=0){
									var lObject = {};
									lObject.id = cu.id;
									lObject.linkedin_url = cu.linkedin_url;
									_userList.list.push(lObject);
								}								
								var td = jQuery("<td/>");
								_iconList = "<a href='javascript://' onclick='deleteContact("+cu.id+",jQuery(this))'><i class='fa fa-trash'></i></a> ";
								if(cu.email!=""){
									_iconList += "<i class='fa fa-envelope'></i> ";
								}
								if(cu.phone!="" ){
									_iconList += "<i class='fa fa-phone'></i> ";
								}
								if( cu.telephone!=""){
									_iconList += "<i class='fa fa-phone-square'></i> ";
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
							if(_userList.list.length>0){
								window.parent.queList.push(_userList);
								if(window.parent.scraperRequest==null){
									window.parent.sendScrapperRequest(2);
								}								
							}
							_contactTdTable.append(_contactTdTableTbody);
							_contactTd.append(_contactTdTable);
							_contactsTr.append(_contactTd);
							/*_contactsTr.css('display','none');*/
							if(parentTr.next().length>0){
								parentTr.next().before(_contactsTr);
							} else {
								parentTr.after(_contactsTr);
							}
							resizeTable(0);
							sortUserTable();
							
						}
					});
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
					width = 90;
				break;
				case 1:
					width = 60;
				break;
				case 2:
					width = 70;
				break;
				case 3:
					width = _companyWidth;
				break;
				case 4:
					width = 60;
				break;
				case 5:
					width = 300;
				break;
				case 6:
					width = 300;
				break;
				case 7:
					width = 300;
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
var lastScroll = 0;
function scrollSynchronize(){
	var $childE = jQuery("#companies_box").find("div.containerResearchBody");
	var $childEH = jQuery("#companies_box").find("div.containerResearchHeader");
	if($childE.length>0){		
		$childE.off('scroll').on('scroll',function(){
			var left = $childE.scrollLeft();
				$childEH.scrollLeft(left);
				console.log("Scroll",$childE.scrollTop()+"@@"+lastScroll);
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
__totalRecords = 4000;
__baseUrl = '<?php echo $Layout->baseUrl?>';
_requestAlreadySend = false;
function checkScroll(s){
	var elBoundery = jQuery("#rs").find('tbody tr.master');
	var tapC = false;
	if(s===true){ 
		var ID = elBoundery.eq(elBoundery.length-1).attr('id');
		if(parseInt(ID) != __totalRecords-1){
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
var _filterSector=[],_filterSubType=[],_filterSubTech=[];
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
					var paT = o.parent().parent().parent().parent().parent().parent();
					var patPR = paT.prev();
					
					var txt = patPR.find('td').eq(4).text();
					console.log(txt);
					try{
						txt = parseInt(txt);
						txt -=1;
						patPR.find('td').eq(4).text(txt);
					}catch(e){}
					o.parent().parent().remove();
				} else  if(data=='-1'){
					alert("Some correspondense with this contact.");
				}
			}
		});
	}	
}
function loadTableWithNewData(t,start,end){
	p = 200;
	if(_requestAlreadySend===false){
		insertID = [];
		_requestAlreadySend = true;
		_url = __baseUrl+'opportunity/companies/ajax/'+p;
		_filters = {search:jQuery('#search_field').val(),s:_filterSector,sst:_filterSubType,st:_filterSubTech,start:start,end:end,sort_field:_sortField,sort_by:_sortBy};
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
				_companiesINString=[];
				if(typeof b.count_all!="undefined"){
					__totalRecords = b.count_all;
				}		
				if(_filterSector.length>0){
					if(typeof b.cat!="undefined"){
						console.log("DD");
						jQuery('.fixedHeader thead th').eq(11).find('.list_options').find('.list').empty();
						console.log(b.cat.length);
						if(b.cat.length>0){
							var _selectUl = jQuery("<ui/>").addClass('open_list');
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
				if(_filterSubType.length>0){
					if(typeof b.sub_cat!="undefined"){
						jQuery('.fixedHeader thead th').eq(12).find('.list_options').find('.list').empty();
						if(b.sub_cat.length>0){
							var _selectUl = jQuery("<ui/>").addClass('open_list');
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
				if(typeof b.companies!="undefined" && b.companies.length>0){
					_data = b.companies;
					for(i=0;i<_data.length;i++){
						if(jQuery.inArray(parseInt(_data[i].id),insertID)<0){
							insertID.push(parseInt(_data[i].id));
							_entry = true;
							if(_entry===true){	
								_selected = 0;
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
								object.company_size = _data[i].company_size;
								object.industry = _data[i].industry;
								object.specialist = _data[i].specialties;
								object.no_of_users = _usersCount;
								object.sectors = _sectorName;
								object.industry = _data[i].industry;
								object.specialist = _data[i].specialties;
								object.company_size = _data[i].company_size;
								object.categories = _categories;
								object.sub_category = _sub_categories;
								object.scrapped_date = _data[i].scrapped_date;
								object.linkedin_url = _data[i].linkedin_url;
								_companiesINString.push(object);
							}
						}
					}
					if(t===false){
						_companiesINString.reverse();
					}
					_fullHTML = "";
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
						_tableBodyTr =jQuery("<tr/>").attr('id',_increment).addClass(_addclass);						
						/*_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='vendor_select_bulk[]' class='checker' "+_checked+" value='"+u.id+"' onchange='checkedMe(jQuery(this))'/>");
						_tableBodyTr.append(_tableBodyTd);*/
						/*General*/
						cDate = u.scrapped_date;
						if(cDate=='0000-00-00'){
							cDate = "Scrape";
						} else {
							cDate = moment(new Date(cDate)).format('MM/DD/YY');
						}
						_anchor = "<a class='scrape_date' href='javascript://' onclick='scrapeOnRun(jQuery(this))'>"+cDate+"</a>";
						_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='general_select_bulk[]' class='general' value='"+u.id+"' data-linkedin='"+u.linkedin_url+"'/> "+_anchor);
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").addClass('merger').append("<input type='checkbox' class='merger_chk' value='"+u.id+"' />");
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").addClass('survivor').append("<input type='checkbox' class='survivor_chk' value='"+u.id+"' />");
						_tableBodyTr.append(_tableBodyTd);
						if(_color!=""){
							_tableBodyTd = jQuery("<td/>").css('background-color',_color).append(_htmlName);
						} else {
							_tableBodyTd = jQuery("<td/>").append(_htmlName);
						}
						_ddive = jQuery("<span/>").append(_htmlName).css({visibility:'hidden'});
						_ddive.appendTo('body')
						_widtha = _ddive.width();
						if(_widtha>_companyWidth){
							_companyWidth = _widtha;
						}
						_ddive.remove();
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").append(u.no_of_users);
						_tableBodyTr.append(_tableBodyTd);
						_linkedIn = u.linkedin_url;
						if(_linkedIn.indexOf('linkedin')>=0){
							_linkedIn = "In";
						}
						_tableBodyTd = jQuery("<td/>").append(_linkedIn);
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").append(u.company_size);
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").append(u.industry);
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").append(u.specialist);
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
						if(t===true){
							jQuery("#rs tbody").append(_tableBodyTr);
						} else {
							jQuery("#rs tbody tr").eq(0).before(_tableBodyTr);
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
				} else {
					loadMessage("No record found");
					setTimeout(function(){	_requestAlreadySend = false;},1000);
				}
			}
		});
	}
}
function loadMessage(msg){
	jQuery("#loading_message").html(msg);
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
						var parentC = jQuery("#rs tbody tr td.survivor").find('input[type="checkbox"]:checked').parent().parent();
						parentC.find('td').eq(4).text(d.survivour_data.companyUsers.length);
						if(parentC.next().find('tr').hasClass('cu')){
							var mainTD = parentC.next().find('td.c1');
							mainTD.find('tbody').empty();
							jQuery.each(d.survivour_data.companyUsers,function(cu){
								var tr = jQuery("<tr/>");
								var td = jQuery("<td/>");
								_iconList = "";
								if(cu.email!=""){
									_iconList += "<i class='fa fa-envelope'></i> ";
								}
								if(cu.phone!=""){
									_iconList += "<i class='fa fa-phone'></i> ";
								}
								if(cu.telephone!=""){
									_iconList += "<i class='fa fa-phone-square'></i> ";
								}
								if(cu.linkedin_url!=""){
									_iconList += "<a target='_blank' href='"+cu.linkedin_url+"'><i class='fa fa-linkedin'></i></a> ";
								}
								if(cu.gateway==1){
									_iconList += "<i class='fa'><img src='https://storage.googleapis.com/static.synpat.com/backyard/images/gateway-1.png'/></i> ";
								}
								_iconList += "<a href='javascript://' onclick='deleteContact("+cu.id+",jQuery(this))'><i class='fa fa-trash'></i></a>";
								td.append(_iconList);
								tr.append(td);
								var td = jQuery("<td/>").append(cu.name);
								tr.append(td);
								var td = jQuery("<td/>").append(cu.job_title);
								tr.append(td);
								mainTD.find('tbody').append(tr);
							});
						}
						jQuery("#rs tbody tr td").find('input[type="checkbox"]').prop('checked',false);
						jQuery("#rs tbody tr td").find('input[type="checkbox"]').removeAttr('checked');
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

function addDataToTable(d,s){
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
		_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.id+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='window.parent.editGoogleContact("+u.id+")'>"+u.company_name+"</a>";
		_tableBodyTr =jQuery("<tr/>").attr('id',_increment).addClass(_addclass);
		
		/*_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='vendor_select_bulk[]' class='checker' "+_checked+" value='"+u.id+"' onchange='checkedMe(jQuery(this))'/>");
		_tableBodyTr.append(_tableBodyTd);*/

		/*General*/
		cDate = u.scrapped_date;
		if(cDate=='0000-00-00'){
			cDate = "Scrape";
		} else {
			cDate = moment(new Date(cDate)).format('MM/DD/YY');
		}
		_anchor = "<a class='scrape_date' href='javascript://' onclick='scrapeOnRun(jQuery(this))'>"+cDate+"</a>";
		_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='general_select_bulk[]' class='general' value='"+u.id+"' data-linkedin='"+u.linkedin_url+"'/> "+_anchor);
		_tableBodyTr.append(_tableBodyTd);

		_tableBodyTd = jQuery("<td/>").addClass('merger').append("<input type='checkbox' class='merger_chk' value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		_tableBodyTd = jQuery("<td/>").addClass('survivor').append("<input type='checkbox' class='survivor_chk' value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		if(_color!=""){
			_tableBodyTd = jQuery("<td/>").css('background-color',_color).append(_htmlName);
		} else {
			_tableBodyTd = jQuery("<td/>").append(_htmlName);
		}
		_ddive = jQuery("<span/>").append(_htmlName).css({visibility:'hidden'});
		_ddive.appendTo('body')
		_widtha = _ddive.width();
		if(_widtha>_companyWidth){
			_companyWidth = _widtha;
		}
		_ddive.remove();
		_tableBodyTr.append(_tableBodyTd);
		_noOfUsers = 0;
		if(u.no_of_users!="undefined" && u.no_of_users>0){
			_noOfUsers = u.no_of_users;
		} else if(u.company_users!="undefined" && u.company_users>0){
			_noOfUsers = u.company_users;
		}		
		_tableBodyTd = jQuery("<td/>").append(_noOfUsers);
		_tableBodyTr.append(_tableBodyTd);
		_linkedIn = u.linkedin_url;
		if(_linkedIn.indexOf('linkedin')>=0){
			_linkedIn = "In";
		}
		_tableBodyTd = jQuery("<td/>").append(_linkedIn);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.company_size);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.industry);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.specialist);
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
		_fullHTML += _tableBodyTr.prop('outerHTML');
		/*_fullHTML += _contactsTr.prop('outerHTML');*/
		_increment++;
	});
	jQuery("#rs tbody").append(_fullHTML);		
	toggleActivity();
	setTimeout(function(){_requestAlreadySend = false;},1000);
	resizeTable(0);
}
function openAddForm(){
	window.parent.openCompanyEdit(0);
}
function deleteGoogleContact(){	
	if(jQuery("input[name='general_select_bulk[]']:checked").length>0){
		contactID = "";
		jQuery("input[name='general_select_bulk[]']:checked").each(function(){
			contactID += jQuery(this).val()+',';
		});
		contactID =contactID.substring(0,contactID.length-1);
		res = confirm("Are you sure?");
		if(res){
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'opportunity/deleteCompanyInBulk',
				data:{delete_link:contactID},
				cache:false,
				success:function(data){
					jQuery("input[name='general_select_bulk[]']:checked").remove();
				}
			});
		}
	} else {
		alert("Please select contact first");
	}
}
</script>