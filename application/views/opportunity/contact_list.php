<head>
<?php if(!isset($this->session->userdata['type'])):?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<?php endif;?>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>views/contact/contact_min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/custom.css"/>
<link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.js"></script>
<script  src="https://backyard.synpat.com/public/handsontable_pro_v6/dist/moment/moment.js"></script>
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
<?php 
if($scraper === false):?>
<div class="row mainT">	
	<div class="col-xs-12" style='width:100%;'>		
		<div class="row btnList" style='margin-bottom:10px;'>
			<div class="col-xs-12" style=''>
				<?php if(isset($this->session->userdata['type'])):?>
				<a href='javascript://' onclick="window.parent.openCContact()" class='btn btn-primary pull-left mrg5R' style="width:auto;min-width:auto;height:auto;" title="Companies"><i class="fa fa-building" style="margin-left:0px;"></i></a>
				<a href="javascript://" onclick="scrapeAllSelectedList('User')" class="btn btn-primary pull-left mrg5R"  title="Scrape Users" style="width:auto;min-width:auto;height:auto;"><i class="fa fa-linkedin" style='margin-left:0px;'></i></a>
				<a href="javascript://" onclick="connectWithLinkedin()" class="btn btn-primary pull-left mrg5R"  title="Connect Users" style="width:auto;min-width:auto;height:auto;">
					<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="user-friends" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width:15px" class="svg-inline--fa fa-user-friends fa-w-20 fa-2x"><path fill="currentColor" d="M480 256c53 0 96-43 96-96s-43-96-96-96-96 43-96 96 43 96 96 96zm0-160c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64zM192 256c61.9 0 112-50.1 112-112S253.9 32 192 32 80 82.1 80 144s50.1 112 112 112zm0-192c44.1 0 80 35.9 80 80s-35.9 80-80 80-80-35.9-80-80 35.9-80 80-80zm80.1 212c-33.4 0-41.7 12-80.1 12-38.4 0-46.7-12-80.1-12-36.3 0-71.6 16.2-92.3 46.9C7.2 341.3 0 363.4 0 387.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-44.8c0-23.8-7.2-45.9-19.6-64.3-20.7-30.7-56-46.9-92.3-46.9zM352 432c0 8.8-7.2 16-16 16H48c-8.8 0-16-7.2-16-16v-44.8c0-16.6 4.9-32.7 14.1-46.4 13.8-20.5 38.4-32.8 65.7-32.8 27.4 0 37.2 12 80.2 12s52.8-12 80.1-12c27.3 0 51.9 12.3 65.7 32.8 9.2 13.7 14.1 29.8 14.1 46.4V432zm271.7-114.9C606.4 291.5 577 278 546.8 278c-27.8 0-34.8 10-66.8 10s-39-10-66.8-10c-13.2 0-26.1 3-38.1 8.1 15.2 15.4 18.5 23.6 20.2 26.6 5.7-1.6 11.6-2.6 17.9-2.6 21.8 0 30 10 66.8 10s45-10 66.8-10c21 0 39.8 9.3 50.4 25 7.1 10.5 10.9 22.9 10.9 35.7V408c0 4.4-3.6 8-8 8H416c0 17.7.3 22.5-1.6 32H600c22.1 0 40-17.9 40-40v-37.3c0-19.9-6-38.3-16.3-53.6z" class=""></path></svg>
				</a>
				<a href='javascript://' onclick="emailScrapeAllSelectedCompanies()" class='btn btn-primary pull-left mrg5R' title="GetEmail" style='width:auto;min-width:auto;height:auto;'><i class="fa fa-envelope-o" style='margin-left:0px;'></i></a>	
				<a href='javascript://' onclick="window.parent.openPreCompanies()" class='btn btn-primary pull-left mrg5R' style="width:auto;min-width:auto;height:auto;" title="Pre Companies">Pre-Comp.</i></a>
				<a href='javascript://' onclick="window.parent.openPreContacts()" class='btn btn-primary pull-left mrg5R' style="width:auto;min-width:auto;height:auto;" title="Pre Contacts">Pre-Cont.</a>
				<a href='javascript://' onclick="openAddForm()" class='btn btn-primary pull-left mrg5R' style="width:auto;min-width:auto;height:auto;" title="Add User"><i class="fa fa-user-plus" style="margin-left:0px;"></i></a>
				<a href='javascript://' class='btn btn-primary pull-left mrg5R' style="width:auto;min-width:auto;height:auto;" onclick='deleteSelectedContacts()' title="Delete Users"><i class='fa fa-trash'></i></a>
				<a href='javascript://' onclick="getFillHoleContacts()" class='btn btn-primary pull-left mrg5R' style="width:auto;min-width:auto;height:auto;" title="DataFills">DF</a>
				<a href='javascript://' onclick="exportLinkedinUrlToClipboard()" class='btn btn-primary pull-left mrg5R' style="width:15px;min-width:15px;height:auto;" title="Export Linkedin urls to clipboard"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="clipboard-user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-clipboard-user fa-w-12 fa-2x" style="position:relative;top:5px;"><path fill="currentColor" d="M336 64h-80a64 64 0 0 0-128 0H48a48 48 0 0 0-48 48v352a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V112a48 48 0 0 0-48-48zM192 40a24 24 0 1 1-24 24 24 24 0 0 1 24-24zm144 418a6 6 0 0 1-6 6H54a6 6 0 0 1-6-6V118a6 6 0 0 1 6-6h42v36a12 12 0 0 0 12 12h168a12 12 0 0 0 12-12v-36h42a6 6 0 0 1 6 6zm-99.2-106h-5a103.25 103.25 0 0 1-79.7 0h-5c-37.01 0-67.1 25.79-67.1 57.6v6.4a16 16 0 0 0 16 16h192a16 16 0 0 0 16-16v-6.4c0-31.81-30.09-57.6-67.2-57.6zM192 336a64 64 0 1 0-64-64 64 64 0 0 0 64 64z" class=""></path></svg></a>
				<?php endif;?>
				<div class='<?php if(isset($this->session->userdata['type'])):?>col-xs-1 <?php else:?> col-xs-12<?php endif;?>' <?php if(isset($this->session->userdata['type'])):?>style="width:150px;"<?php endif;?>>
					<input type='text' placeholder='Search...' id='search_field' style='color:#2b2f33;height:22px;margin-left:-2px;' name='search_field' class='form-control'/>
				</div>
				<?php if(isset($this->session->userdata['type'])):?>
				<div class="col-xs-2">
					<div class="form-group input-string-group" style='border:0px;margin-bottom:0px;'>
						<select name="profile[lead]" id="profileLead" class="form-control" onchange="findCompaniesInLead(jQuery(this).val());" style="height:36px;margin-left:13px;width:150px;">
							<option value="0">Lead</option>							
						</select>
					</div>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</div>
<div id="search_panel">
	<div class="filter_box" filter-name="name">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><input type="text" id="search_name" placeholder="Name..." style="height:26px;min-height:26px;padding:4px 6px; color:#2b2f33;width:90%;" class="form-control pull-left"/></div></div></div>
	</div>
	<div class="filter_box" filter-name="company_name">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><input type="text" id="search_company_field" placeholder="Company..." style="height:26px;min-height:26px;padding:4px 6px; color:#2b2f33;width:90%;" class="form-control pull-left"/></div></div></div>
	</div>
	<div class="filter_box" filter-name="job_title">
		<?php 
			$a=range("A","Z");
			$charAnchors = "";
			foreach($a as $char){
				$charAnchors .="<a class='alpha ' href='javascript://' onclick='searchJobTitleAt(jQuery(this))'>".$char."</a>";
			}
		?>
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-left mrg5R mrg5T" href="javascript://" onclick="findEmptyJobtitle(jQuery(this))" id="empty_jobtitles" style="margin-bottom:10px;font-size:15px">Empty</a><a class="btn btn-primary pull-left mrg5T" href="javascript://" onclick="selectJobtitleAll()" style="margin-bottom:10px;font-size:15px">All</a><span class="pull-left"><input type="text" class="form-control mrg5T" style="width:200px;height:22px;font-size:15px;" id="search_job_title" name="search_job_title" placeholder="Job Title..."/></span><span class="pull-left" style="margin-top:14px;"><?php echo $charAnchors;?></span><span class="paging pull-left" style="margin-top:14px;display:inline-block;width:100px;margin-left:5px;"></span><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="height:100%;overflow:hidden;overflow-y:scroll;padding:0px 5px;" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="email">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><ul><li><input type="radio" name="email" value="0"/>All</li><li><input type="radio" name="email" value="1"/>Is Empty</li><li><input type="radio" name="email" value="2"/>Is not Empty</li><li><input type="radio" name="email" value="3"/>Blue</li><li><input type="radio" name="email" value="4"/>Red</li><input type="radio" name="email" value="5"/>Green</li></ul></div></div>
	</div>
	<div class="filter_box" filter-name="phone">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><ul><li><input type="radio" name="phone" value="0"/>All</li><li><input type="radio" name="phone" value="1"/>Is Empty</li><li><input type="radio" name="phone" value="2"/>Is not Empty</li></ul></div></div>
	</div>
	<div class="filter_box" filter-name="linkedin_url">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><ul><li><input type="radio" name="linkedin_url" value="0"/>All</li><li><input type="radio" name="linkedin_url" value="1"/>Is Empty</li><li><input type="radio" name="linkedin_url" value="2"/>Is not Empty</li></ul></div></div>
	</div>
	<div class="filter_box" filter-name="sector">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="cat">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="sub_type">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="tech">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="sub_tech">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><span class="pull-left"><input type="checkbox" onclick="checkMeCheckAll(jQuery(this))"/>All</span><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="proximity">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><ul><li><input type="checkbox" name="proximity[]" value="0"/>0</li><li><input type="checkbox" name="proximity[]" value="1"/>1</li><li><input type="checkbox" name="proximity[]" value="2"/>2</li><li><input type="checkbox" name="proximity[]" value="3"/>3</li></ul></div></div>
	</div>
	<div class="filter_box" filter-name="current_company">
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left" style="width:100%"><a class="btn btn-default pull-right mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-primary pull-right mrg5R mrg5T" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a></div><ul><li><input type="radio" name="email" value="0"/>All</li><li><input type="radio" name="email" value="1"/>Is Empty</li><li><input type="radio" name="email" value="2"/>Is not Empty</li></ul></div></div>
	</div>
</div>
<?php else:?>
<div><a href='javascript://' class='btn btn-primary pull-left mrg5R' style="width:auto;min-width:auto;height:auto;" onclick='deleteSelectedContacts()' title="Delete Users"><i class='fa fa-trash'></i></a></div>
<?php endif;?>
<div id="grid" style="width: 100%; height: 600px;"></div>
<script>
var records = [];
var _sortField = "c.system_update";
var _sortBy = "DESC";
var selectedCompanies = [];
<?php 
if(count($selected_companies) > 0){
	foreach($selected_companies as $c){
?>
	selectedCompanies.push(<?php echo $c?>);
<?php		
	}
?>
_sortField = "c.c_c";
_sortBy = "DESC";
<?php
}
?>
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
<?php if($scraper == true): ?>
	size1="40px",size2="40px",size3="40px",size4="480px",size5="40px",size6="40px",size7="40px",size8="100px",size9="150px",size10="50px",size11="40px",size12="40px",size13="40px",size14="40px";
	tableColumns = [
		{ field: 'title', text: 'Job Title', size: size4,resizable: true, sortable: true,  searchable: true },
		{ field: 'scrape_no', text: 'Index 1', size: size8, searchable: false, sortable: true, resizable: true,render: function(record) {
				return parseInt(record.scrape_no);
			}},
		{ field: 'c_c', text: 'Index 2', size: size9, searchable: true, sortable: true, resizable: true,render: function(record) {
				return parseInt(record.c_c);
			}}
	];
	sortData = [
		/*{field:'scrape_no',direction:'asc'},
		{field:'c_c',direction:'desc'},*/
	]
<?php
	endif;
?>
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
		onColumnClick: function(event) {
			/*window.event.ctrlKey*/
			if(window.event.ctrlKey){				
				var fieldName = event.field;
				var filterBox = jQuery('.filter_box');
				var offsetX = event.originalEvent.clientX;
				var offsetY = event.originalEvent.clientY;
				offsetY += 71 - offsetY;
				var col = 0;
				var colIndex = -1;
				switch(fieldName) {
					case "name":
						col = 0;
						colIndex = 0;
						break;
					case "company_name":						
						col = 1;
						colIndex = 1;
						break;
					case "current_company":						
						col = 2;
						colIndex = 12;
						break;		
					case "title":						
						col = 3;
						colIndex = 2;
						break;
					case "email":						
						col = 4;
						colIndex = 3;
						break;
					case "all_phones":						
						col = 5;
						colIndex = 4;
						break;
					case "linkedin_url":						
						col = 6;
						colIndex = 5;
						break;
					case "proximity":						
						col = 9;
						colIndex = 11;
						break;
					case "sectors":						
						col = 11;
						colIndex = 6;
						break;
					case "categories":						
						col = 12;
						colIndex = 7;
						break;
					case "sub_category":						
						col = 13;
						colIndex = 8;
						break;
					case "technology_names":						
						col = 14;
						colIndex = 9;
						break;
					case "sub_technology_names":						
						col = 15;
						colIndex = 10;
						break;
				}
				if(col > 0) {
					openFilterList(filterBox.eq(colIndex),offsetX,offsetY,col);
				}
				event.preventDefault();
			} else {
				highlightsColumns();
			}		
		},
		onRender: function(event){
			highlightsColumns();
		},
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
	let checkFound = false;
	if(records.length > 0){
		records.forEach(function(u,i){
			if(parseInt(u.id) == parseInt(ID)){
				records.splice(i,1);
				checkFound = true;
				return false;
			}
		});
		console.log("contact deleting",ID);
		if(checkFound === true){
			w2ui.grid.select(ID);
			w2ui.grid.delete(true);
		}
	}
}

function selectedUserDataScraped(l,profileID){
	console.log("COntact list selectedUserDataScraped");
	var getSelections = w2ui.grid.getSelection();
	var tapFind = false;
	if(getSelections.length > 0){
		if(l.length > 0) {
			l.forEach(function(contact){
				if(getSelections.includes(contact.id)){		
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
	var	_url = __baseUrl+'opportunity/contact_list/ajax/'+sort2;
	var _filters = {lead_id:jQuery("#profileLead").val(),search:jQuery('#search_field').val(),s:_filterSector,cat:_filterCat,sst:_filterSubType,t:_filterTechnology,st:_filterSubTech,sort_field:_sortField,sort_by:_sortBy,filterEmail:_filterEmail,filterPhone:_filterPhone,filterLinkedIn:_filterLinkedIn,filterCompany:_filterCompany,filterProfileName:_filterProfileName,filterTitle:_filterTitle,filterProximity:_filterProximity,filterSelectedCompanies:selectedCompanies,filterCurrentCompany:_filterCurrentCompany};
	jQuery.ajax({
		type:"POST",
		url:_url,
		data:_filters,
		cache:false,
		dataType:'json'
	})
	.done(function(b){
		console.log("BT",b);
		if(w2ui.hasOwnProperty('grid')){
		  w2ui['grid'].destroy();
		}
		jQuery("#grid").css("height",(jQuery(window).height() - 40)+'px');
		var filterBox = jQuery('.filter_box');
		
		if(_filterSector.length>0){
			if(typeof b.categories!="undefined"){
				if(filterBox.eq(9).find('.list_options').find('.list').find('.open_list').length==0){
					filterBox.eq(9).find('.list_options').find('.list').empty();
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
						filterBox.eq(9).find('.list_options').find('.list').append(_selectUl);
					}
				}						
			}
		}
		if(_filterCat.length>0){
			if(typeof b.sub_type!="undefined"){
				if(filterBox.eq(10).find('.list_options').find('.list').find('.open_list').length==0){
					filterBox.eq(10).find('.list_options').find('.list').empty();
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
						filterBox.eq(10).find('.list_options').find('.list').append(_selectUl);
					}
				}						
			}
		}
		if(_filterTechnology.length>0){
			if(typeof b.sub_type!="undefined"){
				_addList = true;
				if(filterBox.eq(12).find('.list_options').find('.list').find('.open_list').length>0){
					if(filterBox.eq(12).find('.list_options').find('.list').find('.open_list').find('input[type="checkbox"]:checked').length>0){
						_addList = false;
					}
				}
				if(_addList===true){
					filterBox.eq(12).find('.list_options').find('.list').empty();
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
						filterBox.eq(12).find('.list_options').find('.list').append(_selectUl);
					}
				}						
			}
		}
		
		if(typeof b.records!="undefined" && b.records.length>0){
			_data = b.records;
			let companyID = 0;
			let _date = "";
			let _create_date = "";
			let _note = "";
			let name = "";
			for(let i=0;i<_data.length;i++){
				var _sectorName = _data[i].sectorName;
				if(_sectorName==null){
					_sectorName='';
				}
				var _categories = _data[i].department_names;
				if(_categories==null){
					_categories='';
				}
				var _sub_categories = _data[i].sub_department_names;
				if(_sub_categories==null){
					_sub_categories='';
				}
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
				object.technolgies = _data[i].technology_names;
				object.sub_technolgies = _data[i].sub_technology_names;
				object.selected = "no";
				object.system_date = _date;
				records.push(object);
			}
		}
		message = "";
		generate();
	})
	.always(function(){
		if(initialCall===false){
			initialCall = true;
			callLeadData();
		}
	})
	.fail(function(){
		console.log("Ajax request failed");
	});
}
function cancelFilter(o) {
	var parentTh = o.parents('.filter_box');
	if(parentTh.hasClass('n')){
		parentTh.find(".list_options").find('.p-absolute').parent().hide();
		parentTh.removeClass('n');
	}
}
function openFilterList(o,x,y,col){
	var searchPanel = jQuery("#search_panel");
	searchPanel.find('.list_options').hide();
	var parentTh = o;
	if(parentTh.hasClass('n')){
		parentTh.find(".list_options").find('.p-absolute').parent().hide();
		searchPanel.find(".filter_box").removeClass('n');
	} else {
		parentTh.addClass('n');
		parentTh.find(".list_options").find('.p-absolute').parent().show();
		_height = parentTh.outerHeight();
		let hH = 150;
		_width = 250;
		/*if(col > 6) {
			_width = 400;
			hH = "320px";
		}
		*/
		var leftPostion = x;
		y = 123;
		var overflow  = 'auto';
		if(o.attr('filter-name')=="job_title"){
			_width = jQuery(window).width() - 18;			
			hH = jQuery(window).height() - 150;
			_position = parentTh.position();
			leftPostion = 0;
			y = 75;
			overflow = "hidden";
		} else if(o.attr('filter-name')=="email"){
			hH = 175;
		}
		parentTh.find(".list_options").find('.p-absolute').css({height:hH+'px',top:y,left:leftPostion,width:_width+'px',background:'#fff',border:'1px solid #dfe8f1',overflow:overflow}).find('.btn-primary').attr('col',col);
		oldSelectedList.type = parentTh.attr('filter-name');
		oldSelectedList.list = [];
		oldSelectedList.eq = -1;
		if(parentTh.find('.list').find('input[type="checkbox"]:checked').length>0){
			parentTh.find('.list').find('input[type="checkbox"]:checked').each(function(){
				let selectedVal = jQuery(this).val();
				if(!isNaN(parseInt(selectedVal)) && oldSelectedList.type!="company_size"){
					selectedVal = parseInt(selectedVal);
				}
				oldSelectedList.list.push(jQuery.trim(selectedVal));
			});
		} else if(parentTh.find('.list').find('span.list_special.selected').length>0){
			parentTh.find('.list').find('span.list_special.selected').each(function(){
				oldSelectedList.list.push(jQuery.trim(jQuery(this).text()));
			});
		}
		if(oldSelectedList.type == "job_title"){
			oldSelectedList.eq = 2;
			findJobTitles();
		}		
	}
}
function findJobTitles(){
	var _filters = {lead_id:jQuery("#profileLead").val(),search:jQuery('#search_field').val(),s:_filterSector,cat:_filterCat,sst:_filterSubType,t:_filterTechnology,st:_filterSubTech,sort_field:_sortField,sort_by:_sortBy,filterEmail:_filterEmail,filterPhone:_filterPhone,filterLinkedIn:_filterLinkedIn,filterCompany:_filterCompany,filterProfileName:_filterProfileName,filterTitle:_filterTitle,filterProximity:_filterProximity,filterSelectedCompanies:selectedCompanies,ignore:oldSelectedList.type,filterCurrentCompany:_filterCurrentCompany};
	jQuery.ajax({
		url:__baseUrl+'opportunity/find_job_tites/',
		type:"POST",
		data:_filters,
		cache:false,
		dataType:'json',
		success:function(list){	
			totalTags = list.data.length;
			formatJobTitle(list.data);
		}
	});
}
Array.prototype.findFirstSubstring = function(s) {
	for(var i = 0; i < this.length;i++)
	{
		if(this[i].indexOf(s) !== -1)
			return i;
	}
	return -1;
};
function formatJobTitle(data){
	var _listSpan = "";
	if(data.length>0){
		for(let j=0;j<data.length;j++){
			if(data[j][oldSelectedList.type]!=""){
				var _class = "";
				var _title = data[j][oldSelectedList.type];
					_title = _title.trim();
					
				if(oldSelectedList != "undefined" && typeof oldSelectedList != "undefined" && oldSelectedList.list.length>0){
					let findStr = oldSelectedList.list.find(function(str) {
						 return str == _title;
					});
					//let findStr = oldSelectedList.list.findFirstSubstring(_title);
					if(findStr != undefined && findStr != null){
						_class = "selected";
					}
				}
				_listSpan += "<span class='list_special "+_class+"' onclick='selectJobTitle(jQuery(this))'>"+_title+"</span>";
			}
		}
	}
	jQuery(".filter_box").eq(2).find('.list_options').find('.list').html(_listSpan);
}
function findEmptyJobtitle(o) {
	if(o.hasClass('selected') === false){
		o.addClass('selected');
		var parentTH = jQuery('div[filter-name="job_title"]');
		parentTH.find('.list_options').find('.list').empty();
		parentTH.find('input[type="text"]').val('');
		_filterTitle = [];
	} else {
		o.removeClass('selected');
	}
}
function selectJobtitleAll() {
	if(jQuery('.list_special').hasClass('selected')) {
		jQuery('.list_special').removeClass('selected');
	} else {
		jQuery('.list_special').addClass('selected');
	}	
}
function selectJobTitle(o){
	if(o.hasClass('selected')){
		o.removeClass('selected');
		var findIndex = oldSelectedList.list.indexOf(o.text());
		if(findIndex >= 0){
			oldSelectedList.list.splice(findIndex,1);
		}
	} else {
		o.addClass('selected');
		oldSelectedList.list.push(o.text());
		console.log("Selected",oldSelectedList.list.length);
	}
}
function findTechnologies(){
	jQuery.ajax({
		url: __baseUrl+'opportunity/get_list_technologies',
		dataType:'json'
	}).done(function(d){
		if(d.length>0){
			_technologies = d;
			var parentTH = jQuery("#search_panel").find('.filter_box').eq(10);
			_selectUl = jQuery("<ul/>").addClass('open_list');
			jQuery.each(_technologies,function(i,c){
				var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
				var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.id);
				var spanY = jQuery("<span/>").css('float','left').append(checkBox);
				var spanX = jQuery('<span/>').append(c.name);
				_selectLi.append(spanY).append(spanX);
				_selectUl.append(_selectLi);
			});
			parentTH.find('.list').empty().append(_selectUl);
		}
	}).always(function(){
		window.parent.checkContactsLoad();
	});
}
function searchWithName(name){
	if(name!=""){
		_checkList = [name];
		_filterProfileName = JSON.stringify(_checkList);
		var parentTH = jQuery("#search_panel").find('.filter_box').eq(0);
		parentTH.addClass('open');
		parentTH.find(".list_options").find('.p-absolute').parent().hide();
		parentTH.removeClass('n');
		loadTableWithNewData();
	} else {
		var parentTH = jQuery("#search_panel").find('.filter_box').eq(0);
		clearFilter(parentTH.find(".list_options"));
	}
}
function searchJobTitleAt(o){
	jQuery('.alpha').removeClass('active');
	o.addClass('active');
	_url = __baseUrl+'opportunity/get_all_title_by_char';
	jQuery.ajax({
		type:"POST",
		url:_url,
		data:{q:o.text()},
		cache:false,
		dataType:'json',
		success:function(b){	
			formatJobTitle(b,true);
		}
	});
}
function searchWithTitle(title){
	if(title!=""){
		_checkList = [title];
		_filterTitle = _checkList;
		var parentTH = jQuery("#search_panel").find('.filter_box').eq(2);
		parentTH.addClass('open');
		parentTH.find(".list_options").find('.p-absolute').parent().hide();
		parentTH.removeClass('n');
		loadTableWithNewData();
	} else {
		var parentTH = jQuery("#search_panel").find('.filter_box').eq(2);
		clearFilter(parentTH.find(".list_options"));
	}
}
function searchWithInCompany(companyName){
	if(companyName!=""){
		_checkList = [companyName];
		_filterCompany = JSON.stringify(_checkList);
		var parentTH = jQuery("#search_panel").find('.filter_box').eq(1);
		parentTH.addClass('open');
		parentTH.find(".list_options").find('.p-absolute').parent().hide();
		parentTH.removeClass('n');
		loadTableWithNewData();
	} else {
		var parentTH = jQuery("#search_panel").find('.filter_box').eq(1);
		clearFilter(parentTH.find(".list_options"));
	}
}
function searchFilter(o){
	var parentTH = o.parents('.filter_box');
	parentTH.addClass('open');
	var col = o.attr('col');
	console.log("SPS:"+col);
	if(col != "" && col != "undefined") {
		jQuery("#grid_grid_column_"+col).addClass('open');
	}
	var _filterName = parentTH.attr('filter-name');
	console.log("Filter From:"+_filterName);
	switch(_filterName){
		case 'name':
			_filterProfileName = jQuery("#search_name").val();
			break;
		case 'current_company':
			_filterCurrentCompany = parentTH.find('input[type="radio"]:checked').val();
			break;
		case 'job_title':
			_filterTitle = [];
			if(parentTH.find('.list span.selected').length>0){
				parentTH.find('.list span.selected').each(function(){
					_filterTitle.push(jQuery(this).text());
				});
			} else if(parentTH.find('#empty_jobtitles').hasClass('selected')){
				_filterTitle.push('none');
			}
			//_filterTitle = jQuery("#search_job_title").val();
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
		case 'proximity':
			_filterProximity = [];
			if(parentTH.find('input[type="checkbox"]:checked').length>0){
				parentTH.find('input[type="checkbox"]:checked').each(function(){
					_filterProximity.push(jQuery(this).val());
				});
			}
			break;
	}
	parentTH.find(".list_options").find('.p-absolute').parent().hide();
	parentTH.removeClass('n');
	loadTableWithNewData();
}
function clearFilter(o){
	var parentTH = o.parents('.filter_box');
	parentTH.find('.list_options').find('.list').empty();
	parentTH.removeClass('open').removeClass('n');
	parentTH.find('input[type="text"]').val('');
	var _filterName = parentTH.attr('filter-name');
	switch(_filterName){
		case 'name':
			_filterProfileName = "";
			break;
		case 'current_company':
			_filterCurrentCompany = "";
			break;
		case 'job_title':
			_filterTitle = [];
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
		case 'proximity':
			_filterProximity=[];
			break;
	}
	parentTH.find('input[type="radio"]').prop('checked',false);
	parentTH.find('input[type="checkbox"]').prop('checked',false);
	parentTH.find(".list_options").find('.p-absolute').parent().hide();
	loadTableWithNewData();
}
function highlightsColumns() {
	var filterColList = [];			
	if(_filterProfileName != "") {
		filterColList.push(0);
	}
	if(_filterCompany.length != "") {
		filterColList.push(1);
	}
	if(_filterCurrentCompany.length != "") {
		filterColList.push(2);
	}	
	if(_filterTitle.length != "") {
		filterColList.push(3);
	}
	if(_filterEmail.length != "") {
		filterColList.push(4);
	}
	if(_filterPhone.length != "") {
		filterColList.push(5);
	}
	if(_filterLinkedIn.length != "") {
		filterColList.push(6);
	}	
	if(_filterProximity.length > 0) {
		filterColList.push(8);
	}
	if(_filterSector.length > 0) {
		filterColList.push(9);
	}
	if(_filterCat.length > 0) {
		filterColList.push(10);
	}
	if(_filterSubType.length > 0) {
		filterColList.push(11);
	}
	if(_filterTechnology.length > 0) {
		filterColList.push(12);
	}
	if(_filterSubTech.length > 0) {
		filterColList.push(13);
	}
	
	if(filterColList.length > 0) {
		var stringObject = "";
		filterColList.map(function(x) {
			stringObject +="#grid_grid_column_"+x+",";
		});
		stringObject = stringObject.substring(0,stringObject.length-1);
		console.log("strobj",stringObject);
		if(stringObject != "") {
			addOpenClass(stringObject);
		}				
	}
}
function addOpenClass(stringObject){
	setTimeout(function(){
		if(jQuery(stringObject).length > 0){
			jQuery(stringObject).addClass("open");
		} else {
			addOpenClass(stringObject)
		}
	},500);
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
			_unclassify = {id:'Unclassify',name:'Unclassify'};
			d.splice(0,0,_unclassify);
			_selectUl = jQuery("<ul/>").addClass('open_list');
			d.map(function(c){
				if(c.id!=21){
					var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
					var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.id);
					var spanY = jQuery("<span/>").css('float','left').append(checkBox);
					var spanX = jQuery('<span/>').append(c.name);
					_selectLi.append(spanY).append(spanX);
					_selectUl.append(_selectLi);
				}		
			});
			jQuery("#search_panel").find('.filter_box').eq(6).find('.list_options').find('.list').html(_selectUl);
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
			_selectUl = jQuery("<ul/>").addClass('open_list');
			d.map(function(c){
				var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
				var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.id);
				var spanY = jQuery("<span/>").css('float','left').append(checkBox);
				var spanX = jQuery('<span/>').append(c.name);
				_selectLi.append(spanY).append(spanX);
				_selectUl.append(_selectLi);
			});
			jQuery("#search_panel").find('.filter_box').eq(9).find('.list').html(_selectUl);
		}
	}).always(function(){
		//window.parent.checkContactsLoad();
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
_spreadsheet=[];
function exportLinkedinUrlToClipboard(){
	var getSelections = w2ui.grid.getSelection();
	if(getSelections.length>0){	
		let _spreadsheet=[];
		getSelections.map(function(c){
			var contact = {};
			var records = w2ui.grid.records;
			records.map(function(r){
				if(r.id == c){
					contact  = r;
					return false;
				}
			});
			if(contact.hasOwnProperty('id')) {
				if(contact.linkedin_url != ""){	
					_spreadsheet.push(contact.linkedin_url);
				}
			}
		});
		if(_spreadsheet.length > 0){
			var copyTextElement = createElementOnFly(_spreadsheet.join(','));
			copyTextElement.select();
			document.execCommand("copy");
			copyTextElement.remove();
			alert("Added to clipboard."); 
		}
	} else {
		alert("Please select contacts first.");
	}
}
function createElementOnFly(name){
	const createD = document.createElement('textarea');
	createD.style = "float:left;position:relative;left:-99999px;padding:0;margin:0px;font:400 18px/1.6em Roboto,sans-serif;";
	createD.innerHTML = name;
	createD.setAttribute('id','stton');
	const bTag = document.getElementsByTagName('body')[0];
	bTag.appendChild(createD);
	const tagD = document.getElementById('stton');
	return tagD;
}
function getFillHoleContacts(){
	var getSelections = w2ui.grid.getSelection();
	if(getSelections.length>0){	
		_spreadsheet=[];
		getSelections.map(function(c){
			var contact = {};
			var records = w2ui.grid.records;
			records.map(function(r){
				if(r.id == c){
					contact  = r;
					return false;
				}
			});
			if(contact.hasOwnProperty('id')) {
				var _spreadRows={};
				var _first_name= contact.first_name;
				var _last_name= contact.last_name;
				var _title = contact.title;
				var _companyName = contact.company_name;
				var _telephone="";
				var _companyphone="";
				var _phone = "";
				var _id = contact.id;
				if(contact.phone != "") {
					_phone = contact.phone;
				}
				if(contact.telephone != "") {
					_telephone = contact.telephone;
				}
				if(contact.company_tel != "") {
					_companyphone = contact.company_tel;
				}
				if(contact.email != ""){	
					_email = contact.email;
				}
				if(contact.linkedin_url != ""){	
					_linkedin = contact.linkedin_url;
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
	jQuery('#search_field').keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			e.preventDefault();
			loadTableWithNewData();
		}		  
	});
	jQuery("#search_field").autocomplete({
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
			jQuery('#search_field').val(ui.item.label);
			loadTableWithNewData();
		}
	});
	jQuery("#search_company_field").keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			e.preventDefault();
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
			searchWithInCompany(ui.item.realValue);
		}
	});
	jQuery("#search_name").keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			e.preventDefault();
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
			searchWithName(ui.item.realValue);
		}
	});
	jQuery("#search_job_title").keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			e.preventDefault();
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
					formatJobTitle(data);
					response($.map(data, function (item) {
						return {
							label: item.job_title,
							value: item.job_title,
							realValue: item.UID,
						};
					}));
				},
			});
		},
		select: function (event, ui) {
			/*jQuery("#inviteeCompanyId").val(ui.item.realValue);*/
			_requestAlreadySend = false;
			searchWithTitle(ui.item.label);
		}
	});
	if(selectedCompanies.length > 0){
		loadTableWithNewData(2);
	}	
});
function emailScrapeAllSelectedCompanies(){
	var getSelectedCompanies = w2ui.grid.getSelection();
	if(getSelectedCompanies.length > 0) {
		let companies = [];
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'users/run_email_scrapper',
			cache:false,
			data:{company_list:companies,contacts:getSelectedCompanies,d:'http://webdriverforscrape.site/find_emails_scrapper.php'}
		}).done(function(d){
			console.log(d);
		});
		/*jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/emailScrapeSelectedContacts',
			cache:false,
			data:{list:getSelectedCompanies},
			dataType:'json'
		}).done(function(d){
			if(d.companies.length>0){
				window.parent.sendEmailScrapperRequest();
			}
			if(d.no_domain.length>0){
				var $gridRecord = jQuery("#grid_grid_records");
				for(i=0;i<d.no_domain.length;i++){
					$gridRecord.find('div[title="'+d.no_domain[i]+'"]').parents('tr').find('td').eq(5).find('a').css('color','#c20000');
				}
			}
		});*/
	} else {
		alert("Please select companies first.");
	}
}
function connectWithLinkedin(){
	var getSelectedContacts = w2ui.grid.getSelection();
	if(getSelectedContacts.length > 0) {
		jQuery.ajax({
			url:__baseUrl+'opportunity/findAllUsers',
			type:'POST',
			data:{c:JSON.stringify(getSelectedContacts),t:22,p:0,s:5,request_type:"Connect"},
			dataType:'json',
			success:function(d){
				if(d.c.length>0){
					checkQueue(2,"Connect");
				}
			}
		});
	} else {
		alert("Please select companies first.");
	}
}
function scrapeAllSelectedList(t){
	var getSelectedContacts = w2ui.grid.getSelection();
	if(getSelectedContacts.length > 0) {
		jQuery.ajax({
			url:__baseUrl+'opportunity/findAllUsers',
			type:'POST',
			data:{c:JSON.stringify(getSelectedContacts),t:1,p:0,s:1,request_type:t},
			dataType:'json',
			success:function(d){
				if(t == "User") {
					if(d.c.length>0){
						checkQueue(1,t);
					}
				}
			}
		});
	} else {
		alert("Please select companies first.");
	}
}
function checkQueue(t,type) {
	jQuery.ajax({
		url:__baseUrl+'opportunity/check_running_stage/'+t,
		type:'get',
		dataType:'json',
		success:function(d){
			if(d.d == 0){
				if(type == 'User') {
					window.parent.sendContactScrapperRequest();
				} else if(type == 'Connect') {
					window.parent.sendContactConnectRequest();
				}
			} else {
				if(type == 'User') {
					window.parent.checkContactsQueue();
				}else if(type == 'Connect') {
					window.parent.checkContactsConnectQueue();
				}
			}
		}
	})
}
jQuery(window).resize(function(){
	jQuery("#grid").css("height",(jQuery(window).height() - 40)+'px');
});
</script>