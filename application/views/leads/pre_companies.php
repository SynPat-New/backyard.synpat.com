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
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/menu.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/autocomplete.js"></script>
<script src="<?php echo $Layout->aws_server_cdn;?>widgets/typing/typing.min.js"></script>
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
.ui-menu-item{list-style:none;padding:10px;border:1px solid #56b2fe;margin-bottom:3px;}
	.ui-menu-item:hover{background-color:#56b2fe;color:#fff;}	
	.ui-helper-hidden-accessible{display:none;}
	.ui-autocomplete {
	padding:0px;margin:0px;
    max-height: 400px;
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
table.tableData td{border-top:0px !important;border-right:0px !important;height:30px;min-height:30px;}
table.tableData tr.master td:last-child{border-right:solid 1px #d1c8c8 !important;}
.button-list{border:1px solid #d1c8c8;padding:0px 0px 3px 3px;cursor:pointer;float:right;}
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
</style>
<script>
__baseUrl = '<?php echo $Layout->baseUrl?>';
jQuery(document).ready(function(){
	jQuery('.query').typing({
		delay:1000,
		stop:function(){
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'leads/save_linkedin_query',
				data:jQuery('.query').serializeArray(),
				cache:false,
				success:function(d){
					
				}
			})
		}
	});
});
</script>
<h4 class='heading'>Search for new contacts     <span class="loader_import_file glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A mrg10L" style='display:none;color:#c20000'>Please wait...</span></h4>
<div class='row'>
<div class='col-lg-12'>
<div class="row" style='margin-bottom:10px;'>
<?php 
	
	$title = "";
	$keyword = "";
	if(count($linkedin_query)>0){
		$title = $linkedin_query->title;
		$keyword = $linkedin_query->keyword;
	}
?>
<style>
.colorClass{
	color:#1E88E5 !important;
	text-decoration:underline;
}
</style>
<div class='col-xs-12 description'><p>To search for new contacts to be added to the database based on a list of companies:<br/>1) If a lead IS selected, skip to (2). If a lead is NOT selected, delete the content of <a href='javascript://' onclick="openFormFields()" class='colorClass' style='display:inline-block;' id='btnImportFromDriveSheet'>This Spreadsheet</a>, paste into it the list of new companies, and close the spreadsheet.</p>
<div> 2) Click <form id="import_sheet_form" class='' style='display:inline-block'><input class='form-control input-string' placeholder='Spreadsheet file url' type='hidden' name='file_url' id='file_url' value='https://docs.google.com/spreadsheets/d/1Dd3FFroSCMOnMZ2kdVaMMpw4BLKD_gggffC1UuCk-4g/edit#gid=0'/><input type='hidden' name='lead_id' id='lead_id' value='0'/></form>
<a class='colorClass' style='display:inline-block;' href='javascript://' onclick='importContactsFromFile();'>Import</a>
in order to import into the table below the list of companies either from the Market DD (if a lead is selected) or from the above spreadsheet. If a lead is selected the imported companies will be checked as invitees. Those that are not yet in the contact database (Pre-Companies) will be shown in red.
</div>
<p>3) Delete Pre-Companies that have equivalent black ones use mouse right click, and correct the names if needed, remember to select the invitees checkbox.</p>
<p>4) Use and adjust (if needed) the following query to search in LinkedIn for relevant individuals from the list of companies in red. <br/>
Title Inquiry: <input type='text' name='title' id='title' class='form-control query' placeholder='Title' value='<?php echo $title;?>'/>
Keywords: <input type='text' name='keyword' id='keyword' class='form-control query' style='margin-top:5px;' placeholder='Keyword' value='<?php echo $keyword;?>'/><p>
<!--<p>5)  Copy to the clipboard the content of <a href='https://docs.google.com/document/d/1aiuWmlwFQfp2k98kgckH7DXsjY5_wpOy8G7PC0oOjwM/edit' class='colorClass' target='Scrapper Code' style='display:inline-block;'>This file.</a></p>
<p>6) Run the above query on linkedin either for all the <a href='javascript://' onclick='searchCompaniesInLinkedin(0);' class='colorClass' style='display:inline-block;'>Pre-Companies</a> or only for the Linkedin <a href='javascript://' onclick='searchCompaniesInLinkedin(1);' class='colorClass' style='display:inline-block;'>selected companies</a>. The program will search each 50 companies in a separate Tab. Open the Developers Tools, click console, paste the content of clipboard and press Enter to scrap 10 contacts on the Page. After the tab is reopened click on the pagination to move to the next page and scrape again through developer tools untill all the pages are scraped.</p>-->
<p>5) Select the checboxes in the linkedin column and start the linkedin search by clicking <a href='javascript://' onclick='searchCompaniesInLinkedin(1);' class='colorClass'>here</a></p>
<p>6) Import the newly scraped Pre-Contacts into the Contacts database <a href='<?php echo $Layout->baseUrl;?>leads/pre_contacts/11' class='colorClass'  style='display:inline-block;'>here.</a></p>
</div>		
</div>

<div class='col-xs-12 selection' style='color:red'>
<!--<input type="checkbox" onclick="selectAll(jQuery(this))"/> Select All-->
<div class='col-xs-2'>
Red: <label id='red' style='border-bottom:1px solid #000'></label> &nbsp;&nbsp;&nbsp; Selected: <label id='selected_co' style='border-bottom:1px solid #000' ></label></div><div class='col-xs-8'> <input type='text' placeholder='Search Company...' id='search_field' style='height:26px;min-height:26px;padding:4px 6px; color:#2b2f33;width:300px;' name='search_field' class='form-control pull-left'/></div>
</div>
	<div class="scroll-container col-lg-12 cp-border">
		<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:100%;'></div>
	</div>
</div>
</div>
<script>
	var minTable = document.getElementById("companies_box");
	var _selected = 0;
	_companiesINString = [];
	var _red = 0;
	_listingCompanies = JSON.parse('<?php echo json_encode($listing_companies)?>');
	_companiesINString=[<?php
			$insertID = array();
			for ($i = 0; $i < count($companies); $i++) {
				if(!in_array((int)$companies[$i]->id,$insertID)):
				$insertID[] = (int)$companies[$i]->id;
				$usersCount = 0;
				if($companies[$i]->company_users!=null){
					$usersCount = $companies[$i]->company_users;
				}
				$checked = 0;
				$linkedIN = 0;
				if(count($listing_companies)>0){
					foreach($listing_companies as $listing){
						if($listing->type=='pre-company' && $listing->company_id==$companies[$i]->id){
							$checked = 1;
							$linkedIN = 1;
						}
					}
				}
				$type="pre-company";
				if($companies[$i]->company_type==1){
					$type="company";
				}
				echo "{'id':". $companies[$i]->id.",'selected':".$checked.",'linkedin':".$linkedIN.",'company_name':'" . addslashes($companies[$i]->company_name) . "','linkedin_name':'" . addslashes($companies[$i]->linkedin_name) . "','linkedin_url':'" . $companies[$i]->linkedin_url . "','no_of_users':'" . $usersCount . "','sectors':'" . $companies[$i]->sectorName . "','categories':'" . $companies[$i]->department_names . "','sub_category':'" . $companies[$i]->sub_department_names . "','type':'" . $type . "','ss':'" . $companies[$i]->ss . "','company_id':" . $companies[$i]->company_id . "}";
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
	userColumns = ["Invitees","Pre Companies","Linkedin","Scraped","#ofUsers","Company Name","Sectors","Categories","SubCategories","Linkedin Name","Linkedin URL"];
	jQuery(document).ready(function(){
		var width = jQuery(window).width();
		var height = jQuery(window).height();
		newHeight = (height - jQuery('.heading').outerHeight() - jQuery('.description').outerHeight() - jQuery('.selection').outerHeight() - 35 );
		jQuery('.scroll-container,.ui-autocomplete').css("height",newHeight+"px");
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

		jQuery(window).resize(function(){
			setTimeout(function(){
				var width = jQuery(window).width();
				var height = jQuery(window).height();
				newHeight = (height - jQuery('.heading').outerHeight() - jQuery('.description').outerHeight() - jQuery('.selection').outerHeight() - 35 );
				jQuery('.scroll-container,.ui-autocomplete').css("height",newHeight+"px");
				_calHeader = jQuery(minTable).find('div.containerResearchHeader').height();
				_calHeight = newHeight - _calHeader - 15;
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
					url: __baseUrl+'leads/search_temp_company',
					dataType: "json",
					data: { query: request.term },
					success: function (data) {
						response($.map(data, function (item) {
							return {
								label: item.Name,
								value: item.Name
							};
						}));
					},
				});
			},
			select: function (event, ui) {
				_scrollTable = false;
				jQuery("#rs tbody").find("tr").remove();
				_fullHTML = "";
				_increment = 0;
				loadTableWithNewData(true,0,200);
			}
		});
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
				if(i==6 || i==7 || i==8){
					_filterICON = "<span class='button-list'><i class='fa fa-sort-down'></i></span>";
					_class = "filter";
				}
				if(i==0 || i==1 || i==2 || i==3 || i==4 || i==5 || i==9 || i==10){
					_sortICON = "<span class='p-relative'><i class='icon-default p-absolute sort'></i></span>";
					if(_class==""){
						_class = "sortIcon";
					} else {
						_class = "filter-sort"
					}
				}
				if(_class=="filter" || _class=="filter-sort"){
					switch(i){
						case 6:
							_list = getSectors();
							_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-left mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
							_filterField = "sector";
						break;
						case 7:
							_list = "";
							_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-left mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
							_filterField = "sub_type";
						break;
						case 8:
							_list = "";
							_filterICON +='<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-left mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list">'+_list+'</div></div></div>';
							_filterField = "tech";
						break;
					}
				}
				switch(i){
					case 5:
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
			_scraped = (u.ss==1)?'No':'Yes';
			if(u.selected===1){
				_checked="checked='checked'";
				_addclass ="main selt";
				_addclass1 ="selt1";
			}
			if(u.type=='company'){
				_scraped = 'Yes';
			}
			_linkedinChecked="";
			if(u.linkedin==1){
				_linkedinChecked="checked='checked'";
			}
			if(u.type=='pre-company'){
				_red +=1;
			}
			_tableBodyTr =jQuery("<tr/>").attr('id',i).addClass(_addclass);
			/*Invitees*/
			_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='vendor_select_bulk[]' class='checker' value='"+u.company_id+"' "+_checked+" onchange='checkedMe(jQuery(this))'/>");
			if(u.type=="pre-company"){
				_anchor = "<a href='javascript://' onclick='removePreContact("+u.company_id+",jQuery(this))'><i class='fa fa-trash'/></a>";
				jQuery(_tableBodyTd).append(_anchor);
			}else if(u.type=="company"){
				_anchor = "<a href='javascript://' onclick='removeContact("+u.company_id+",jQuery(this))'><i class='fa fa-trash'/></a>";
				jQuery(_tableBodyTd).append(_anchor);
			}
			_tableBodyTr.append(_tableBodyTd);
			/*Pre Companies*/
			_tableBodyTd = jQuery("<td/>").append(u.type);
			_tableBodyTr.append(_tableBodyTd);
			/*Linkedin*/
			_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' class='linkedin_chk' "+_linkedinChecked+"  value='"+u.company_id+"' />");
			_tableBodyTr.append(_tableBodyTd);
			/*Scraped*/
			_tableBodyTd = jQuery("<td/>").append(_scraped);
			_tableBodyTr.append(_tableBodyTd);
			/*#ofUsers*/
			_tableBodyTd = jQuery("<td/>").append(u.no_of_users);
			_tableBodyTr.append(_tableBodyTd);
			/*CompanyName*/
			if(u.type=='company'){
				_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.company_id+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='window.parent.openCompanyEdit("+u.company_id+")'>"+u.company_name+"</a>";
			} else {
				_htmlName = "<span style='color:red'>"+u.company_name+"</span>";
			}
			_tableBodyTd = jQuery("<td/>").append(_htmlName);
			_tableBodyTr.append(_tableBodyTd);
			/*Sector*/
			_tableBodyTd = jQuery("<td/>").append(u.sectors);
			_tableBodyTr.append(_tableBodyTd);
			/*Category*/
			_tableBodyTd = jQuery("<td/>").append(u.categories);
			_tableBodyTr.append(_tableBodyTd);
			/*Sub category*/
			_tableBodyTd = jQuery("<td/>").append(u.sub_category);
			_tableBodyTr.append(_tableBodyTd);	
			/*Linkedin Name*/
			_tableBodyTd = jQuery("<td/>").append(u.linkedin_name);
			_tableBodyTr.append(_tableBodyTd);	
			/*Linkedin Url*/
			_tableBodyTd = jQuery("<td/>").addClass('linkedin').append(u.linkedin_url);
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
		jQuery("#red").html(_red);
		jQuery("#selected_co").html(_listingCompanies.length);
		toggleActivity();
		lastColumnClick();
		setTimeout(function(){resizeTable(1)},100);
	}
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
								_userList.type = 1;
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
										window.parent.sendScrapperRequest(1);
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
	function lastColumnClick(){
		jQuery("#rs tbody tr td.linkedin").off('click').on('click',function(){
			if(jQuery(this).text()!=''){
				window.open(jQuery(this).text(),"_target");
			}
		});
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
						width = 70;
					break;
					case 1:
						width = 120;
					break;
					case 2:
						width = 80;
					break;
					case 3:
						width = 80;
					break;
					case 4:
						width = 80;
					break;
					case 5:
						width = 150;
					break;
					case 6:
						width = 200;
					break;
					case 7:
						width = 200;
					break;
					case 8:
						width = 200;
					break;
					case 9:
						width = 130;
					break;
					case 10:
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
function loadTableWithNewData(t,start,end){
	p = 200;
	if(_requestAlreadySend===false){
		insertID = [];
		_requestAlreadySend = true;
		_url = __baseUrl+'leads/pre_merge_companies/';
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
								_type = "pre-company";
								if(_data[i].company_type==1){
									_type = "company";
								}
								_checked = 0;
								_linkedIN = 0;
								if(_listingCompanies.length>0){
									jQuery.each(_listingCompanies,function(s,l){
										if(l.type=='pre-company' && l.company_id==_data[i].id){
											_checked = 1;
											_linkedIN = 1;
											return false;
										}
									});
								}

								object = {};
								object.id = _data[i].id;
								object.selected = _checked;
								object.linkedin = _linkedIN;
								object.company_name = _data[i].company_name;
								object.linkedin_name = _data[i].linkedin_name;
								object.linkedin_url = _data[i].linkedin_url;
								object.no_of_users = _usersCount;
								object.company_id = _data[i].company_id;
								object.sectors = _sectorName;
								object.categories = _categories;
								object.sub_category = _sub_categories;
								object.type = _type;
								object.ss = _data[i].ss;
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
						_addclass ="main master";
						_addclass1 ="";
						_scraped = (u.ss==1)?'No':'Yes';
						if(u.selected===1){
							_checked="checked='checked'";
							_addclass ="main selt";
							_addclass1 ="selt1";
						}
						if(u.type=='company'){
							_scraped = 'Yes';
						}
						_linkedinChecked="";
						if(u.linkedin==1){
							_linkedinChecked="checked='checked'";
						}
						_tableBodyTr =jQuery("<tr/>").attr('id',i).addClass(_addclass);
						/*Invitees*/
						_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' name='vendor_select_bulk[]' class='checker' value='"+u.company_id+"' "+_checked+" onchange='checkedMe(jQuery(this))'/>");
						if(u.type=="pre-company"){
							_anchor = "<a href='javascript://' onclick='removePreContact("+u.company_id+",jQuery(this))'><i class='fa fa-trash'/></a>";
							jQuery(_tableBodyTd).append(_anchor);
						}else if(u.type=="company"){
							_anchor = "<a href='javascript://' onclick='removeContact("+u.company_id+",jQuery(this))'><i class='fa fa-trash'/></a>";
							jQuery(_tableBodyTd).append(_anchor);
						}
						_tableBodyTr.append(_tableBodyTd);
						/*Pre Companies*/
						_tableBodyTd = jQuery("<td/>").append(u.type);
						_tableBodyTr.append(_tableBodyTd);
						/*Linkedin*/
						_tableBodyTd = jQuery("<td/>").append("<input type='checkbox' class='linkedin_chk' "+_linkedinChecked+"  value='"+u.company_id+"' />");
						_tableBodyTr.append(_tableBodyTd);
						/*Scraped*/
						_tableBodyTd = jQuery("<td/>").append(_scraped);
						_tableBodyTr.append(_tableBodyTd);
						/*#ofUsers*/
						_tableBodyTd = jQuery("<td/>").append(u.no_of_users);
						_tableBodyTr.append(_tableBodyTd);
						/*CompanyName*/
						if(u.type=='company'){
							_htmlName = "<a href='javascript://' class='showActivity' data-id='"+u.company_id+"'><i class='fa fa-chevron-right'></i></a> <a href='javascript://' onclick='window.parent.openCompanyEdit("+u.company_id+")'>"+u.company_name+"</a>";
						} else {
							_htmlName = "<span style='color:red'>"+u.company_name+"</span>";
						}
						_color = "";
						_cName = u.company_name;
						_cName = _cName.toLowerCase();
						_v1 = jQuery("#search_field").val();
						_v1 = _v1.toLowerCase();
						if(_v1!="" && _cName.indexOf(_v1)>=0){
						   _color = 'yellow';
						}
						if(_color!=""){
							_tableBodyTd = jQuery("<td/>").css('background-color',_color).append(_htmlName);
						} else {
							_tableBodyTd = jQuery("<td/>").append(_htmlName);
						}
						_tableBodyTr.append(_tableBodyTd);
						/*Sector*/
						_tableBodyTd = jQuery("<td/>").append(u.sectors);
						_tableBodyTr.append(_tableBodyTd);
						/*Category*/
						_tableBodyTd = jQuery("<td/>").append(u.categories);
						_tableBodyTr.append(_tableBodyTd);
						/*Sub category*/
						_tableBodyTd = jQuery("<td/>").append(u.sub_category);
						_tableBodyTr.append(_tableBodyTd);	
						/*Linkedin Name*/
						_tableBodyTd = jQuery("<td/>").append(u.linkedin_name);
						_tableBodyTr.append(_tableBodyTd);	
						/*Linkedin Url*/
						_tableBodyTd = jQuery("<td/>").addClass('linkedin').append(u.linkedin_url);
						_tableBodyTr.append(_tableBodyTd);	
						_tableBody.append(_tableBodyTr);
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
					setTimeout(function(){	_requestAlreadySend = false;},1000);
				}
			}
		});
	}
}

function checkedMe(o){
	if(window.parent.leadGlobal>0){
		_ty = o.parents('tr').find('td').eq(1).text();
		if(o.is(':checked')){
			_url = __baseUrl+'opportunity/add_list_selection';
		} else {
			_url = __baseUrl+'opportunity/delete_list_selection';
		}
		jQuery.ajax({type:'POST',url:_url,data:{id:o.val(),t:_ty,lead_id:window.parent.leadGlobal},cache:false,success:function(d){}});
	}
}

function openAddForm(){
	window.parent.openCompanyEdit(0);
}

function searchCompaniesInLinkedin(ty){
	_queryObject = [];
	/*_getData = hot1.getSourceData();*/
	_getData = jQuery("#rs tbody tr");
	/*if(ty==1){
		_queryObject = jQuery('#db_from_litigation').find("input[name='contact_id[]']:checked");
	} else {
		_queryObject = jQuery('#db_from_litigation').find('tr[data-attr="pre-company"]');
	}*//*if(c[0]=="yes" && c[2]=="yes"){*/
	_getData.each(function(ind){
		if(ty==1){
			_td = jQery(this).find('td');
			if(_td.eq(2).find('input[type="checkbox"]:checked')){
				if(_td.eq(_td.length-1).text()!=""){
					_url = _td.eq(_td.length-1).text();
					_substrLastString = _url.substr(_url.length-1);
					if(_substrLastString=="/"){
						_url = _url.substr(0,_url.length-1);
					}
					_url = _url.toString();
					_urlSplit = _url.split('?trk=company_logo');
					_allUrl = _urlSplit[0].split('/');
					linkedInName = _allUrl.pop();
					if(linkedInName!=""){
						_queryObject.push('"'+linkedInName+'"');
					}
				}
			}
		} else {
			_td = jQery(this).find('td');
			if(_td.eq(1).text()=="pre-company"){
				if(_td.eq(_td.length-1).text()!=""){
					_url = _td.eq(_td.length-1).text();
					_substrLastString = _url.substr(_url.length-1);
					if(_substrLastString=="/"){
						_url = _url.substr(0,_url.length-1);
					}
					_url = _url.toString();
					_urlSplit = _url.split('?trk=company_logo');
					_allUrl = _urlSplit[0].split('/');
					linkedInName = _allUrl.pop();
					_queryObject.push('"'+linkedInName+'"');
				}
			}
		}
	});	
	if(_queryObject.length>0){
		_current = 1;
		_newDate = new Date();
		keywords = jQuery('#keyword').val();
		title = jQuery('#title').val();	
		_queryCompanies = _queryObject.join(",");
		embedKeyWords = encodeURIComponent(_queryCompanies);
		window.open('http://webdriverforscrape.site/linkedin_scrapper.php?keywords='+encodeURIComponent(keywords)+'&title='+encodeURIComponent(title)+'&facetCurrentCompany=%5B'+embedKeyWords+'%5D&origin=FACETED_SEARCH','WIndow_'+_current+_newDate.getMilliseconds());
	} else {
		alert("System don't find any pre companies");
	}
}

function openFormFields(){
	window.parent.open_drive_files(jQuery("#file_url").val());
	jQuery('#frm_import').toggle();
}
function importContactsFromFile(){
	_leadID = window.parent.leadGlobal;
	if(typeof _leadID!='undefined' && _leadID>0){
		jQuery('#import_sheet_form').find('input#lead_id').val(_leadID);
	}
	jQuery('.loader_import_file').show();
	frm_data= jQuery('#import_sheet_form').serializeArray();
	jQuery.ajax({
		url:__baseUrl+'leads/file_import_in_companies',
		type:'POST',
		data:frm_data,
		cache:false,
		success:function(d){
			jQuery('.loader_import_file').hide();
			window.parent.document.getElementById('predefineFormIframe').contentWindow.location.reload();
			
			/*if(d>0){
				window.parent.document.getElementById('predefineFormIframe').contentWindow.location.reload();
			}*/
		}
	});
}

function removePreContact(preContactID,o){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'leads/remove_precompanies',
		data:{id:preContactID},
		success:function(res){
			o.parents('tr').remove();
			deleteFromTempTable(preContactID);			
		}
	});
}
function removeContact(contactID,o){
	res = confirm("Are you sure?");
	if(res){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/deleteCompany',
			data:{delete_link:contactID},
			cache:false,
			success:function(data){	
				o.parents('tr').remove();
				deleteFromTempTable(preContactID);			
			}
		});
	}
}
function deleteFromTempTable(ID){
	jQuery.ajax({
			type:'POST',
			url:__baseUrl+'leads/delete_from_temp_company',
			data:{id:ID},
			cache:false,
			success:function(data){		
			}
		});
}
</script>
