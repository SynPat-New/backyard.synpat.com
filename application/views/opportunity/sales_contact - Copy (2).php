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
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/custom.css"/>

<style>
	body {
		overflow: auto !important;
		min-width: 0;
		font-family:arial;font-size:13px;
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
.ui-dropdownchecklist{z-index:9999999999999999999999 !important;}
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
table.tableData td{border-top:0px !important;border-right:0px !important;height:30px;min-height:30px;}
table.tableData tr.master td:last-child{border-right:solid 1px #d1c8c8 !important;}
.button-list{border:1px solid #d1c8c8;padding:0px 5px 3px 6px;cursor:pointer;float:right;}
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
 tr.cu table.sbo thead th:last-child, tr.cu table.sbo tbody td:last-child{border-right:0px !important;}
</style>
<h4 id='cn'>Companies  <span id='loading_message' style='margin-left:100px'></span></h4>
<div class="row">	
	<div class="col-xs-12" style='width:100%;'>		
		<div class="row btnList" style='margin-bottom:10px;'>
			<div class="col-md-2">
				<a href='javascript://' onclick="addAllCompanyToLead(1)" class='btn btn-primary '>Update</a>
				<a href='javascript://' onclick="mergeCompanies()" class='btn btn-primary '>Merge</a>
			</div>
			<div class="col-md-3">
				<input type='text' placeholder='Search...' id='search_field' style='height:24px;min-height:24px;padding:4px 6px; color:#2b2f33' name='search_field' class='form-control'/>
			</div>
		</div>
	</div>
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
			if($activity==1){
				if(count($selected_sales_companies)>0){
					foreach($selected_sales_companies as $sCompany){
						if($sCompany->id==$companies[$i]->id){
							$selected=1;
						}
					}
				}
			} else {
				if(count($selected_acquisition_companies)>0){
					foreach($selected_acquisition_companies as $sCompany){	
						if($sCompany->id==$companies[$i]->id){
							$selected=1;
						}
					}
				}
			}
			$usersCount = 0;
			if($companies[$i]->company_users!=null){
				$usersCount = $companies[$i]->company_users;
			}
			
			
			echo "{'id':". $companies[$i]->id.",'selected':".$selected.",'company_name':'" . addslashes($companies[$i]->company_name) . "','no_of_users':'" . $usersCount . "','sectors':'" . $companies[$i]->sectorName . "','categories':'" . $companies[$i]->department_names . "','sub_category':'" . $companies[$i]->sub_department_names . "'}";
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
userColumns = ["#","Merging","Survivour","Company","#ofUsers","Sectors","Categories","SubCategories"];
jQuery(document).ready(function(){
	var width = jQuery(window).width();
	var height = jQuery(window).height();
	newHeight = (height - jQuery('#cn').outerHeight() - jQuery('#selected_contacts').outerHeight() - jQuery('.btnList').outerHeight() - 60 );
	jQuery('.scroll-container').css("height",newHeight+"px");
	showContactsTable();
	jQuery('#search_field').keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			e.preventDefault();
			jQuery("#rs tbody").find("tr").remove();
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
		resizeTable(0);
	})
});

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
					case 5:
						_list = getSectors();
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-left mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
						_filterField = "sector";
					break;
					case 6:
						_list = "";
						_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-left mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
						_filterField = "sub_type";
					break;
					case 7:
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
		_addclass ="master";
		_addclass1 ="";
		if(u.selected===1){
			_checked="checked='checked'";
			_addclass ="selt";
			_addclass1 ="selt1";
		}
		_tableBodyTr =jQuery("<tr/>").attr('id',i).addClass(_addclass);
		_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='vendor_select_bulk[]' class='checker' value='"+u.id+"' "+_checked+"/>");
		_tableBodyTr.append(_tableBodyTd);
		
		_tableBodyTd = jQuery("<td/>").addClass('merger').append("<input type='checkbox' class='merger_chk' value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		_tableBodyTd = jQuery("<td/>").addClass('survivour').append("<input type='checkbox' class='survivour_chk' value='"+u.id+"' />");
		_tableBodyTr.append(_tableBodyTd);
		
		
		_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.id+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='editGoogleContact("+u.id+")'>"+u.company_name+"</a>";
		_tableBodyTd = jQuery("<td/>").append(_htmlName);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.no_of_users);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.sectors);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.categories);
		_tableBodyTr.append(_tableBodyTd);
		_tableBodyTd = jQuery("<td/>").append(u.sub_category);
		_tableBodyTr.append(_tableBodyTd);		
		_tableBody.append(_tableBodyTr);
		/*
		_contactsTr = jQuery("<tr/>").addClass(_addclass1);
		_contactTd = jQuery("<td/>").addClass('c1').attr('colspan',4);
		_contactTd1 = jQuery("<td/>").addClass('c2').attr('colspan',4);
		if(u.no_of_users>0){							
			_contactTdTable= jQuery('<table/>').addClass('table sbo').css({border:'0px'});
			_contactTdTableThead = jQuery("<thead/>").append("<tr><th>#</th><th>Name</th><th>Title</th></tr>");
			_contactTdTable.append(_contactTdTableThead);
			_contactTdTableTbody = jQuery("<tbody/>");
			jQuery.each(u.company_users,function(k,cu){
				var tr = jQuery("<tr/>");
				var td = jQuery("<td/>");
				_iconList = "";
				if(cu.email!=""){
					_iconList += "<i class='fa fa-envelope'></i> ";
				}
				if(cu.phone!="" || cu.telephone!=""){
					_iconList += "<i class='fa fa-phone'></i> ";
				}
				if(cu.linkedin_url!=""){
					_iconList += "<i class='fa fa-linkedin'></i> ";
				}
				td.append(_iconList);
				tr.append(td);
				var td = jQuery("<td/>").append(cu.name);
				tr.append(td);
				var td = jQuery("<td/>").append(cu.job_title);
				tr.append(td);
				_contactTdTableTbody.append(tr);
			});
			_contactTdTable.append(_contactTdTableTbody);
			_contactTd.append(_contactTdTable);
		}
		_contactsTr.append(_contactTd).append(_contactTd1);
		_contactsTr.css('display','none');
		_tableBody.append(_contactsTr);*/
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
function toggleActivity(){
	if(jQuery("#rs tbody tr.master").length>0){
		jQuery("#rs tbody tr.master").each(function(){
			jQuery(this).find('a.showActivity').off('click').on('click',function(){
				if(jQuery(this).hasClass('open')===true){
					jQuery("#rs tbody tr.cu").remove();
					jQuery(this).removeClass('open');
					jQuery(this).find('i.fa').removeClass('fa-chevron-down').addClass('fa-chevron-right');
				} else {
					jQuery("#rs tbody tr.cu").remove();
					jQuery(this).addClass('open')
					jQuery(this).find('i.fa').removeClass('fa-chevron-right').addClass('fa-chevron-down');
					var companyID = jQuery(this).attr('data-id');
					var parentTr = jQuery(this).parent().parent();
					jQuery.ajax({
						url:__baseUrl+'opportunity/find_company_users',
						type:'POST',
						data:{c:companyID},
						dataType:'json',
						cache:false
					}).done(function(d){
						if(d.length>0){						
							_contactsTr = jQuery("<tr/>").addClass('cu');
							_contactTd = jQuery("<td/>").addClass('c1').attr('colspan',4);
							_contactTd1 = jQuery("<td/>").addClass('c2').attr('colspan',4);
							_contactTdTable= jQuery('<table/>').addClass('table sbo').css({border:'0px'});
							_contactTdTableThead = jQuery("<thead/>").append("<tr><th>#</th><th>Name</th><th>Title</th></tr>");
							_contactTdTable.append(_contactTdTableThead);
							_contactTdTableTbody = jQuery("<tbody/>");
							jQuery.each(d,function(k,cu){
								var tr = jQuery("<tr/>");
								var td = jQuery("<td/>");
								_iconList = "";
								if(cu.email!=""){
									_iconList += "<i class='fa fa-envelope'></i> ";
								}
								if(cu.phone!="" || cu.telephone!=""){
									_iconList += "<i class='fa fa-phone'></i> ";
								}
								if(cu.linkedin_url!=""){
									_iconList += "<i class='fa fa-linkedin'></i> ";
								}
								td.append(_iconList);
								tr.append(td);
								var td = jQuery("<td/>").append(cu.name);
								tr.append(td);
								var td = jQuery("<td/>").append(cu.job_title);
								tr.append(td);
								_contactTdTableTbody.append(tr);
							});
							_contactTdTable.append(_contactTdTableTbody);
							_contactTd.append(_contactTdTable);
							_contactsTr.append(_contactTd).append(_contactTd1);
							/*_contactsTr.css('display','none');*/
							parentTr.next().before(_contactsTr);
							resizeTable(0);
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
			if(i==0){
				width = 30;
			} 
			if(i==tableResearcherTbody.eq(0).find('td').length-1){
				width = 300;
			}
			if(i==tableResearcherTbody.eq(0).find('td').length-2){
				width = 300;
			}
			if(i==tableResearcherTbody.eq(0).find('td').length-3){
				width = 300;
			}
			if(i==tableResearcherTbody.eq(0).find('td').length-4){
				width = 60;
			}
			if(i==tableResearcherTbody.eq(0).find('td').length-5){
				width = 250;
			}
			if(i==tableResearcherTbody.eq(0).find('td').length-6){
				width = 60;
			}
			if(i==tableResearcherTbody.eq(0).find('td').length-7){
				width = 60;
			}			
			tableResearcherThead.find('th').eq(i).css({width:width+"px",minWidth:width+"px",maxWidth:width+"px"});
			jQuery(this).css({width:width+"px",minWidth:width+"px",maxWidth:width+"px",wordBreak:'break-all'});
			j++;
		});
		tableResearcherT.css({tableLayout:'fixed',wordBreak:'break-all'});
		tableResearcherFixed.css({tableLayout:'fixed',wordBreak:'break-all'});
		if(t==1){setTimeout(scrollSynchronize,100);sortTables();}
		jQuery("#rs tbody tr.master").each(function(){
			_width1 = jQuery(this).find('td').eq(0).outerWidth() + jQuery(this).find('td').eq(1).outerWidth() + jQuery(this).find('td').eq(2).outerWidth();
			_width2 = jQuery(this).find('td').eq(3).outerWidth();
			mainTable = _width1 + _width2;
			var nextTr = jQuery(this).next();
			var mainWidth = jQuery(this).width();
			var remaining = mainWidth - mainTable;
			nextTr.find('td.c1').css('width',mainTable+'px');
			nextTr.find('td.c2').css('width',remaining+'px');
			nextTr.find('table').css('width',mainTable+'px');
			nextTr.find('table tbody tr').each(function(){
				_widthHalf = _width1 - 45;
				jQuery(this).find('td').eq(0).css('width','45px');
				jQuery(this).find('td').eq(1).css('width',_widthHalf+'px');
				jQuery(this).find('td').eq(2).css('width',_width2+'px');
			})
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
			if(($childE.scrollTop()>lastScroll || $childE.scrollTop()==lastScroll) && $childE.scrollTop()!=0 && lastScroll!=0){
				var tableHeight = jQuery("#rs").height() - 673;
				if($childE.scrollTop()>(tableHeight-9000)){
					checkScroll(true);
				}
			} else {
				if(lastScroll>$childE.scrollTop()){
					if($childE.scrollTop()<9000){
						checkScroll(false);
					}
				}else if(lastScroll==0 && $childE.scrollTop()==0){
					firstID = jQuery("#rs").find('tbody tr').eq(0).attr('id');
					if(parseInt(firstID)!=0){
						checkScroll(false);
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
_leadID = '<?php echo $lead_id?>';
_activity = '<?php echo $activity?>';
_requestAlreadySend = false;
function checkScroll(s){
	var elBoundery = jQuery("#rs").find('tbody tr.master');
	var tapC = false;
	if(s===true){ 
		var ID = elBoundery.eq(elBoundery.length-1).attr('id');
		if(parseInt(ID) != __totalRecords-1){
			_start = parseInt(ID) + 1;
			_end = 500;
			tapC = true;
		}
	} else {
		var ID = elBoundery.eq(0).attr('id');
		if(parseInt(ID)>0){
			_end = parseInt(ID);
			_start = _end - 500;
			_end = 500;	
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
_sortBy = "DESC";
var _filterSector=[],_filterSubType=[],_filterSubTech=[];
function loadTableWithNewData(t,start,end){
	p = 200;
	if(_requestAlreadySend===false){
		insertID = [];
		_requestAlreadySend = true;
		_url = __baseUrl+'opportunity/sales_contact/'+_leadID+'/'+_activity+'/ajax/'+p;
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
						jQuery('.fixedHeader thead th').eq(4).find('.list_options').find('.list').empty();
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
							jQuery('.fixedHeader thead th').eq(4).find('.list_options').find('.list').append(_selectUl);
						}
					}
				}
			
				if(_filterSubType.length>0){
					if(typeof b.sub_cat!="undefined"){
						jQuery('.fixedHeader thead th').eq(5).find('.list_options').find('.list').empty();
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
							jQuery('.fixedHeader thead th').eq(5).find('.list_options').find('.list').append(_selectUl);
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
								object.categories = _categories;
								object.sub_category = _sub_categories;
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
						_addclass = "master";
						_addclass1 = "";
						if(u.selected==1){
							_addclass = "selt";
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
						_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.id+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='editGoogleContact("+u.id+")'>"+u.company_name+"</a>";
						/*_contactsTr = jQuery("<tr/>").addClass(_addclass1);
						_contactTd = jQuery("<td/>").addClass('c1').attr('colspan',4);
						_contactTd1 = jQuery("<td/>").addClass('c2').attr('colspan',4);
						_contactTdTable= jQuery('<table/>').addClass('table sbo').css({border:'0px'});
						_contactTdTableThead = jQuery("<thead/>").append("<tr><th>#</th><th>Name</th><th>Title</th></tr>");
						_contactTdTable.append(_contactTdTableThead);
						_contactTdTableTbody = jQuery("<tbody/>");
						if(u.no_of_users>0){	
							jQuery.each(u.company_users,function(k,cu){
								var ctr = jQuery("<tr/>");
								var ctd = jQuery("<td/>");
								_iconList = "";
								if(cu.email!=""){
									_iconList += "<i class='fa fa-envelope'></i> ";
								}
								if(cu.phone!="" || cu.telephone!=""){
									_iconList += "<i class='fa fa-phone'></i> ";
								}
								if(cu.linkedin_url!=""){
									_iconList += "<i class='fa fa-linkedin'></i> ";
								}
								ctd.append(_iconList);
								ctr.append(ctd);
								var ctd = jQuery("<td/>").append(cu.name);
								ctr.append(ctd);
								var ctd = jQuery("<td/>").append(cu.job_title);
								ctr.append(ctd);
								_contactTdTableTbody.append(ctr);
							});
						}
						_contactTdTable.append(_contactTdTableTbody);
						_contactTd.append(_contactTdTable);
						_contactsTr.append(_contactTd).append(_contactTd1);
						_contactsTr.css('display','none');
						*/
						_tableBodyTr =jQuery("<tr/>").attr('id',_increment).addClass(_addclass);
						
						_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' 		name='vendor_select_bulk[]' class='checker' "+_checked+" value='"+u.id+"'/>");
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").addClass('merger').append("<input type='checkbox' class='merger_chk' value='"+u.id+"' />");
						_tableBodyTr.append(_tableBodyTd);
						
						_tableBodyTd = jQuery("<td/>").addClass('survivour').append("<input type='checkbox' class='survivour_chk' value='"+u.id+"' />");
						_tableBodyTr.append(_tableBodyTd);
						
						if(_color!=""){
							_tableBodyTd = jQuery("<td/>").css('background-color',_color).append(_htmlName);
						} else {
							_tableBodyTd = jQuery("<td/>").append(_htmlName);
						}
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").append(u.no_of_users);
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").append(u.sectors);
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").append(u.categories);
						_tableBodyTr.append(_tableBodyTd);
						_tableBodyTd = jQuery("<td/>").append(u.sub_category);
						_tableBodyTr.append(_tableBodyTd);	
						_fullHTML += _tableBodyTr.prop('outerHTML');
						/*_fullHTML += _contactsTr.prop('outerHTML');*/
						if(t===true){
							_increment++;
						}else{
							_increment--;
						}
					});
					if(t===true){
						jQuery("#rs tbody").append(_fullHTML);
					} else {
						jQuery("#rs tbody tr").eq(0).before(_fullHTML);
					}		
					toggleActivity();
					setTimeout(function(){_requestAlreadySend = false;},1000);
					resizeTable(0);
				} else {
					setTimeout(function(){	_requestAlreadySend = false;},1000);
				}
			}
		});
	}
	
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
function mergeCompanies(){
	if(jQuery("#rs tbody tr td.merger").find('input[type="checkbox"]:checked').length>0 && jQuery("#rs tbody tr td.survivour").find('input[type="checkbox"]:checked').length>0){
		_merger=[];
		jQuery("#rs tbody tr td.merger").find('input[type="checkbox"]:checked').each(function(){
			_merger.push(jQuery(this).val());
		});
		_survivour=[];
		jQuery("#rs tbody tr td.survivour").find('input[type="checkbox"]:checked').each(function(){
			_survivour.push(jQuery(this).val());
		});
		console.log('merger',_merger);
		console.log('survivour',_survivour);
		jQuery("#loading_message").html("Please wait..");
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/merge_companies_data',
			data:{m:_merger,s:_survivour},
			dataType:'json',
			cache:false,
			success:function(d){
				jQuery("#loading_message").html("");
				if(d.update>0){
					jQuery("#rs tbody tr td.merger").find('input[type="checkbox"]:checked').each(function(){
						var $this = jQuery(this)
						_cVal = $this.val();
						_check = false;
						jQuery.each(_survivour,function(k,l){
							console.log("T:"+l+"S:"+_cVal);
							if(l==_cVal){
								console.log("FFFF");
								_check = true;
								return false;
							}
						});
						if(_check===false){
							console.log("EEE");
							$this.parent().parent().remove();
						}
					});
					var parentC = jQuery("#rs tbody tr td.survivour").find('input[type="checkbox"]:checked').parent().parent();
					parentC.find('td').eq(4).text(d.survivour_data.companyUsers.length);
					var mainTD = parentC.next().find('td.c1');
					mainTD.find('tbody').empty();
					jQuery.each(d.survivour_data.companyUsers,function(cu){
						var tr = jQuery("<tr/>");
						var td = jQuery("<td/>");
						_iconList = "";
						if(cu.email!=""){
							_iconList += "<i class='fa fa-envelope'></i> ";
						}
						if(cu.phone!="" || cu.telephone!=""){
							_iconList += "<i class='fa fa-phone'></i> ";
						}
						if(cu.linkedin_url!=""){
							_iconList += "<i class='fa fa-linkedin'></i> ";
						}
						td.append(_iconList);
						tr.append(td);
						var td = jQuery("<td/>").append(cu.name);
						tr.append(td);
						var td = jQuery("<td/>").append(cu.job_title);
						tr.append(td);
						mainTD.find('tbody').append(tr);
						console.log(mainTD.find('tbody').html());
					});
				}
			}
		})
	} else {
		alert("Please check merger and survivour companies first");
	}
}
function addAllCompanyToLead(t){		
	_mainActivity = window.parent.jQuery('#activityMainType').val();
	_targetBody = "";
	activity = _activity;		
	if(_mainActivity==1){
		_targetBody = "activityTable";
	} else if(_mainActivity==2) {
		_targetBody = "aquisitionTable";
	}		
	_flag=0;
	if(parseInt(activity)==5){
		_flag = 1;
		assignBrokerToCompany();
	}
	if(_flag==0){
		if(_mainActivity==1){
			sendCompanyToInvitees(t);
		} else if(_mainActivity==2) {
			sendCompanyToAcquisition(t);
		}	
	}		
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
</script>