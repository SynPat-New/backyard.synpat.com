<!DOCTYPE html>
<html>
<head>
    <title>Company List</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl;?>public/views/contact/contact_min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>nestable.css">
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/datepicker-ui/datepicker.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl;?>public/widgets/modal/modal.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/datepicker-ui/datepicker.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/modal/modal.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/menu.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/autocomplete.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>widgets/jquery.tablesorter.min.js"></script> 
	<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>jquery.nestable.js"></script>
	<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
	<script src="https://synpat.com/docket-services/techdd/ckeditor/ckeditor.js"></script> 
	<script src="https://storage.googleapis.com/static.synpat.com/backyard/widgets/typing/typing.min.js"></script>
<style>
	body{margin:0px;}
	body textarea{font-family:arial;}
	.ui-menu-item{list-style:none;padding:10px;border:1px solid #56b2fe;margin-bottom:3px;}
	.ui-menu-item:hover{background-color:#56b2fe;color:#fff;}	
	.ui-helper-hidden-accessible{display:none;}
	.ui-autocomplete {padding:0px;margin:0px;overflow-y: auto;overflow-x: hidden;background:#fff;width:300px !important;z-index:999;}
	.p-absolute {position: absolute;}
	.open_list{list-style:none;padding:0px;}
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
	.modal-dialog{width:700px;}
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
	#btnCalendar{display:none;}
	#ui-datepicker-div{background:#fff;padding:0 8px 0 0;border:1px solid #efefef;border-radius:2px}
	.ui-datepicker-trigger{background:none;border:0px;cursor:pointer;padding:0px;}
	.ui-state-disabled{background:#efefef !important;color:#555a60 !important;}
	.ui-state-disabled .ui-state-default{color:#fff;}
	.ui-datepicker-prev.ui-state-disabled,.ui-datepicker-next.ui-state-disabled{background:none!important;color:#fff!important;text-indent:-9999px;border:0px !important;cursor:default;display:none;}
	.list_options .p-absolute{z-index:9;}
	#grid a{color:#15c !important;}
	#grid a.company.active{color:#d9534f !important;}
	.pull-left{float:left} .mrg10L{margin-left:10px;} .mrg5R{margin-right:5px;} .mrg5T{margin-top:5px;}
	.w2ui-grid .w2ui-grid-body table .w2ui-head.open{color: #c20000;}
	span.list_special{margin-right: 15px;cursor: pointer;color: #2d2d2d;font-size: 15px;background: rgb(212,212,212);padding: 2px 5px;margin-bottom: 7px;display: inline-block;border-radius: 11px;}
	span.list_special:hover,span.list_special.selected{color:#c20000;text-decoration:underline}
	.selected{color:#c20000;text-decoration:underline}
	span.list_special:last-child{margin:0;}
	.mrg10L{margin-left:10px;}
	.mrg5L{margin-left:5px;}
	.mrg5B{margin-bottom:5px;}
	.page-n,.page-p{margin-left:20px;}
	.alpha{text-transform:uppercase;font-size:14px;margin-left:2px;}
	.alpha:before{content:" | "}
	.alpha:first-child:before{content:""}
	.alpha:last-child{margin-right:0}
	.alpha.active{color:#c20000;}
	a{text-decoration:none;}
	.w2ui-reset table tr th, .w2ui-reset table tr td,.open_list, .open_list li, .open_list li span{font-family:arial;font-size:13px;}
	.list_options ul{float:left;width:100%}
	.w2ui-grid .w2ui-grid-body div.w2ui-col-header>div.w2ui-sort-down{border-top:5px solid #c20000;}
	.w2ui-grid .w2ui-grid-body div.w2ui-col-header>div.w2ui-sort-up{border-bottom:5px solid #c20000;}
	.expression{width:98%;height:40px;}
	.width50{width:50% !important;}
	.width45{width:45% !important;height:40px;}
	.pullRight{float:right;}
	a.contact.active{font-weight:bold}
	</style>
</head>
<body>
<?php if($scraper == false):?>
<div id="all_users_modal" data-backdrop="static" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">All Users</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div id="all_users_grid" style="width: 100%; height: 250px;"></div>
		</div>
	  </div>
	  <div class="modal-footer">
      </div>
    </div>

  </div>
</div>
<div id="title_query_modal" data-backdrop="static" class="modal fade" role="dialog">
	<div class="modal-dialog">
  		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Title Query:</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-6" style="float:left;width:40%">
						<div class="col-sm-12">
							<div class="form-group" style="margin:0;">
								<label>Example:</label>
							</div>
							<textarea id="query_keywords"></textarea>
						</div>
						<div class="col-sm-12" style="margin:30px 0 3px 0;">
							<div class="form-group" style="margin:0;">
								<label>Your Query:</label>
							</div>
							<textarea id="query_title" style="width:97%;height:100px;" class="form-control"></textarea>
						</div>
						<div class="col-sm-12"><a href="javascript://" class="btn btn-primary" onclick="searchCompanyPeople(1);">Search</a></div>
					</div>
					<div class="col-sm-5 pull-right" style="width:50%">
						<?php 
							$maxNo = 30;$updateN = false;
							if(count($query) > 0){
								if($query->scrape_numbers > 0){
									$maxNo = $query->scrape_numbers;
									$updateN = true;
								}								
							}
							if(count($expression) > 0){
								$i = 1;
								foreach($expression as $e){
									if($i == 1 && $updateN === false && $e->scrape_numbers > 0){
										$maxNo = $e->scrape_numbers;
									}
						?>
								<div class="col-sm-12">
									<?php 
										if($i==7 || $i == 8):
									?>
									<textarea id="title<?php echo $i;?>" name="title<?php echo $i;?>" placeholder="Keyword <?php echo $i;?>" class="title width45" data-id="<?php echo $e->id;?>"><?php echo $e->title;?></textarea>
									<?php
										endif;
									?>
									<textarea id="expression<?php echo $i;?>" placeholder="Expression <?php echo $i;?>" name="expression<?php echo $i;?>" class="expression <?php echo ($i==7 || $i == 8)?' width50 pullRight':'';?>" data-id="<?php echo $e->id?>"><?php echo $e->keyword?></textarea>
								</div>
						<?php	
									$i++;
								}
							}
						?>
						<div class="col-sm-12">
							<a href="javascript://" class="btn btn-primary" onclick="searchCompanyPeople(2);">Search</a> <input type="text" name="max_numbers" id="max_numbers" value="<?php echo $maxNo;?>" style="width:50px;float:right;"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
<div id="top_search_panel" class="mrg5B floatLeft" style="width:99%;">
	<div class="row">	
		<a href='javascript://' onclick="window.parent.openCompanyEdit(0);" class='btn btn-primary pull-left mrg5R' title="Add a Company" style='width:auto;min-width:auto;height:auto;'><i class="fa fa-plus" style='margin-left:0px;'></i></a>
		<a href='javascript://' onclick="mergeCompanies()" class='btn btn-primary pull-left mrg5R' title="Merge" style='width:auto;min-width:auto;height:auto;'><i class="fa fa-compress" style='margin-left:0px;'></i></a>
		<a href='javascript://' onclick="emailScrapeAllSelectedCompanies()" class='btn btn-primary pull-left mrg5R' title="GetEmail" style='width:auto;min-width:auto;height:auto;'><i class="fa fa-envelope-o" style='margin-left:0px;'></i></a>
		<a href="javascript://" onclick="addCompanyToPingpong();" class="btn btn-primary pull-left mrg5R"  title="Scrape Owler" style="width:auto;min-width:auto;height:auto;"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="earlybirds" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 480 512" style="width:20px;" class="svg-inline--fa fa-earlybirds fa-w-15 fa-2x"><path fill="currentColor" d="M313.2 47.5c1.2-13 21.3-14 36.6-8.7.9.3 26.2 9.7 19 15.2-27.9-7.4-56.4 18.2-55.6-6.5zm-201 6.9c30.7-8.1 62 20 61.1-7.1-1.3-14.2-23.4-15.3-40.2-9.6-1 .3-28.7 10.5-20.9 16.7zM319.4 160c-8.8 0-16 7.2-16 16s7.2 16 16 16 16-7.2 16-16-7.2-16-16-16zm-159.7 0c-8.8 0-16 7.2-16 16s7.2 16 16 16 16-7.2 16-16-7.2-16-16-16zm318.5 163.2c-9.9 24-40.7 11-63.9-1.2-13.5 69.1-58.1 111.4-126.3 124.2.3.9-2-.1 24 1 33.6 1.4 63.8-3.1 97.4-8-19.8-13.8-11.4-37.1-9.8-38.1 1.4-.9 14.7 1.7 21.6 11.5 8.6-12.5 28.4-14.8 30.2-13.6 1.6 1.1 6.6 20.9-6.9 34.6 4.7-.9 8.2-1.6 9.8-2.1 2.6-.8 17.7 11.3 3.1 13.3-14.3 2.3-22.6 5.1-47.1 10.8-45.9 10.7-85.9 11.8-117.7 12.8l1 11.6c3.8 18.1-23.4 24.3-27.6 6.2.8 17.9-27.1 21.8-28.4-1l-.5 5.3c-.7 18.4-28.4 17.9-28.3-.6-7.5 13.5-28.1 6.8-26.4-8.5l1.2-12.4c-36.7.9-59.7 3.1-61.8 3.1-20.9 0-20.9-31.6 0-31.6 2.4 0 27.7 1.3 63.2 2.8-61.1-15.5-103.7-55-114.9-118.2-25 12.8-57.5 26.8-68.2.8-10.5-25.4 21.5-42.6 66.8-73.4.7-6.6 1.6-13.3 2.7-19.8-14.4-19.6-11.6-36.3-16.1-60.4-16.8 2.4-23.2-9.1-23.6-23.1.3-7.3 2.1-14.9 2.4-15.4 1.1-1.8 10.1-2 12.7-2.6 6-31.7 50.6-33.2 90.9-34.5 19.7-21.8 45.2-41.5 80.9-48.3C203.3 29 215.2 8.5 216.2 8c1.7-.8 21.2 4.3 26.3 23.2 5.2-8.8 18.3-11.4 19.6-10.7 1.1.6 6.4 15-4.9 25.9 40.3 3.5 72.2 24.7 96 50.7 36.1 1.5 71.8 5.9 77.1 34 2.7.6 11.6.8 12.7 2.6.3.5 2.1 8.1 2.4 15.4-.5 13.9-6.8 25.4-23.6 23.1-3.2 17.3-2.7 32.9-8.7 47.7 2.4 11.7 4 23.8 4.8 36.4 37 25.4 70.3 42.5 60.3 66.9zM207.4 159.9c.9-44-37.9-42.2-78.6-40.3-21.7 1-38.9 1.9-45.5 13.9-11.4 20.9 5.9 92.9 23.2 101.2 9.8 4.7 73.4 7.9 86.3-7.1 8.2-9.4 15-49.4 14.6-67.7zm52 58.3c-4.3-12.4-6-30.1-15.3-32.7-2-.5-9-.5-11 0-10 2.8-10.8 22.1-17 37.2 15.4 0 19.3 9.7 23.7 9.7 4.3 0 6.3-11.3 19.6-14.2zm135.7-84.7c-6.6-12.1-24.8-12.9-46.5-13.9-40.2-1.9-78.2-3.8-77.3 40.3-.5 18.3 5 58.3 13.2 67.8 13 14.9 76.6 11.8 86.3 7.1 15.8-7.6 36.5-78.9 24.3-101.3z" class=""></path></svg></a>		
		<a href="javascript://" onclick="scrapeAllSelectedList('Company')" class="btn btn-primary pull-left mrg5R" title="Scrape Company" style="width:auto;min-width:auto;height:auto;"><i class="fa fa-linkedin-square" style='margin-left:0px;'></i></a>
		<a href="javascript://" onclick="scrapeAllSelectedList('User')" class="btn btn-primary pull-left mrg5R"  title="Scrape User" style="width:auto;min-width:auto;height:auto;"><i class="fa fa-linkedin" style='margin-left:0px;'></i></a>
		<a href='javascript://' onclick="deleteSelectedCompanies()" class='btn btn-primary pull-left mrg5R' title="Delete Companies" style='width:auto;min-width:auto;height:auto;'><i class="fa fa-trash" style='margin-left:0px;'></i></a>
		<a href='javascript://' onclick="deleteSelectedContacts()" class='btn btn-primary pull-left mrg5R' title="Delete Contacts" style='width:auto;min-width:auto;height:auto;'><i class="fa fa-trash-o" style='margin-left:0px;'></i></a>
		<a href='javascript://' onclick="openClassify()" class='btn btn-primary pull-left mrg5R' title="Classify" style='width:auto;min-width:auto;height:auto;'><i class="fa fa-cubes"  style='margin-left:0px;'></i></a>
		<a href='javascript://' onclick="findEmptyCompanies()" class='btn btn-primary pull-left mrg5R' title="Find Company People" style='width:auto;min-width:auto;height:auto;'><i class="fa fa-user-circle-o"  style='margin-left:0px;'></i></a>
		<div class="col-xs-1" id="upload_backups" style="width:30px;padding-left:0px;">
			<input type="input" id="btnCalendar" class="btnCalendar" />
			<?php 
				$todayDate = strtotime('now');
				$yesterday = strtotime('-1 days',$todayDate);
				$dayBeforeYesterday = strtotime('-1 days',$yesterday);
				$dayDayBeforeYesterday = strtotime('-1 days',$dayBeforeYesterday);
			?>
		</div>
		<div class="col-xs-2" style="width:145px;">
			<input type="text" placeholder="Search Company" id="search_field" style="height:24px;min-height:24px;padding:4px 6px; color:#2b2f33;width:90%;" name="search_field" class="form-control pull-left ui-autocomplete-input" autocomplete="off">
		</div>
		<div class="col-xs-1" style="width:70px;">
			<div class="form-group input-string-group" style="border:0px;margin-bottom:0px;">
				<select name="profile[list_type]" id="profileListType" class="form-control" onchange="changeActivityType(jQuery(this))">
					<option value="0">All</option>
					<option value="2">Acquisition</option>
					<option value="1">Sales</option>
				</select>
			</div>
		</div>
		<div class="col-xs-2" style="width:75px;">
			<div class="form-group input-string-group" style="border:0px;margin-bottom:0px;">
				<select name="pagination_alpha" id="pagination_alpha" class="form-control" onchange="changePaginationAlpha(jQuery(this))">
					<option value="" selected>A-Z</option>
					<?php 
						$alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
						for($i=0;$i<strlen($alpha);$i++){
					?>
						<option value="<?php echo $alpha{$i}?>"><?php echo $alpha{$i}?></option>
					<?php
						}
					?>
			</select>
			</div>
		</div>
		<span id="total_result_found" style='float:right;padding-top:10px;'></span>
	</div>
</div>
<div id="search_panel">
	<div class="filter_box" filter-name="label">
		<div class="list_options"  style="display:none" ><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T btnClear" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"><ul><li><input type="radio" name="list_selected" value="" checked/>All</li><li><input type="radio" name="list_selected" value="0"/>Not normalize user list</li><li><input type="radio" name="list_selected" value="1"/>Normalize User list</li></ul></div></div></div>
	</div>
	<div class="filter_box" filter-name="no_of_users">
		<div class="list_options" style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="no_of_employees">
		<div class="list_options" style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="company_size">
		<div class="list_options" style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="industry">
		<div class="list_options" style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="specialties">
		<?php 
			$a=range("A","Z");
			$charAnchors = "";
			foreach($a as $char){
				$charAnchors .="<a class='alpha ' href='javascript://' onclick='searchSpecialistAt(jQuery(this))'>".$char."</a>";
			}
		?>
		<div class="list_options"  style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg5L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a href="javascript://" onclick="findCompaniesNoneSpeciality(jQuery(this))" id="empty_specialties" class="btn btn-primary pull-left mrg5L  mrg5T" style="margin-bottom:10px;font-size:15px">Empty</a><a href="javascript://" onclick="selectSpecialityAll()" class="btn btn-primary pull-left mrg5L mrg5T mrg5R" style="margin-bottom:10px;font-size:15px">All</a><span class="pull-left"><input type="text" class="form-control mrg5T" style="width:200px;height:22px;font-size:15px;" id="search_specialist" name="search_specialist" placeholder="Search Specialities"/></span><span class="pull-left" style="margin-top:14px;"><?php echo $charAnchors;?></span><span class="paging pull-left" style="margin-top:14px;display:inline-block;width:100px;margin-left:5px;"></span><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="height:100%;overflow:hidden;overflow-y:scroll;padding:0px 5px;" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="sector">
		<div class="list_options" style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="cate">
		<div class="list_options" style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="sub_cate">
		<div class="list_options" style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="tech">
		<div class="list_options" style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-left mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="sub_tech">
		<div class="list_options" style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"></div></div></div>
	</div>
	<div class="filter_box" filter-name="invited">
		<div class="list_options" style="display:none"><div class="p-absolute"><div class="pull-left fpo" style="width:100%"><a class="btn btn-primary pull-left mrg10L mrg5R mrg5T btnApply" style="margin-bottom:10px;font-size:15px" onclick="searchFilter(jQuery(this))" href="javascript://">Apply</a><a class="btn btn-primary pull-left mrg10L mrg5T" style="margin-bottom:10px;font-size:15px" onclick="clearFilter(jQuery(this))" href="javascript://">Clear</a><a class="btn btn-default pull-right mrg10L mrg5T btnCancel" style="margin-bottom:10px;font-size:15px" onclick="cancelFilter(jQuery(this))" href="javascript://"><i class="fa fa-remove"></i></a></div><div style="width:100%;height:270px;overflow:hidden;overflow-y:scroll" class="list"><ul class="open_list"><li><input type="radio" name="list_selected" value="0">Selected</li><li><input type="radio" name="list_selected" value="1">Unselected</li></ul></div></div></div>
	</div>
</div>
<?php endif;?>
<div id="grid" style="width: 100%; height: 250px;"></div>
<script>
let title = '<?php echo $query->title;?>',keyword = '<?php echo $query->keyword;?>';
let scrape_companies = [];
<?php if(count($scrape_companies) > 0):?>
scrape_companies = JSON.parse('<?php echo json_encode($scrape_companies);?>');
<?php endif;?>
function addCompanyToPingpong(){
	var getSelectedCompanies = w2ui.grid.getSelection();
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/addBulkCompanyListToPinPong',
		data:{list:getSelectedCompanies},
	}).done(function(d){
		/*w2ui.grid.unselect(getSelectedCompanies.join(',')); not working*/
		getSelectedCompanies.map(function(c){
			w2ui.grid.unselect(c);
		});
		
		if(d > 0){
			alert("Companies added to pingpong.");
		}
	})
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

function checkThis(o){
	if(!o.is(':checked')){
		const allCheck = o.parents('.open_list').find("li").eq(0).find("input[type='checkbox']");
		allCheck.prop("checked",false).removeAttr("checked");
	}
}

/*For Specialities*/
var totalTags = 0;
var start=0;
var end=200;
function getAllSpecialist(f,s,e){
	if(f===true){
		start=s;
		end = e;
	}
	oldSelectedList.type = 'specialties';
	oldSelectedList.list = [];
	oldSelectedList.eq = 10;
	_url = __baseUrl+'opportunity/get_all_specialist';
	jQuery.ajax({
		type:"POST",
		url:_url,
		data:{s:start,e:end},
		cache:false,
		dataType:'json',
		success:function(b){	
			totalTags = b.total;
			formatSpeciallist(b.list,true);
		}
	});
}
function searchSpecialistAt(o){
	jQuery('.alpha').removeClass('active');
	o.addClass('active');
	/*_url = __baseUrl+'opportunity/get_all_specialist_by_char';*/
	if(_activity == "" || _activity == 0){
		_activity = jQuery("#profileListType").val();
	}
	oldSelectedList.type = 'specialties';
	oldSelectedList.list = [];
	oldSelectedList.eq = 10;
	_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,label:_filterLabel,specialist:_filterSpecialties,start:_startTag,end:_current,sort_field:_sortField,sort_by:_sortBy,t:true,ignore:oldSelectedList.type,tagSearch:'',invited:_filterInvited,alpha:o.text()}
	jQuery.ajax({
		type:"POST",
		url:__baseUrl+'opportunity/get_filter_list/'+_leadID+'/'+_activity+'/ajax/50000',
		data:_filters,
		cache:false,
		dataType:'json',
		success:function(b){	
			formatSpeciallist(b.data,true);
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

var _filterSector=[],_filterType=[],_filterSubType=[],_filterTechnology=[],_filterSubTech=[],_filterUsers=[],_filterLinkedIn = "",_filterCompanyIndustry=[],_filterSpecialties = [],_filterCompanySize=[],_filterNoOfSize=[],_filterLabel="";_pageAlphabetically="",_filterInvited=2,_sortBy = "ASC",_sortField = "c.company_name";
/*Search companies by Alphabetic*/
function changePaginationAlpha(o){
	_pageAlphabetically = o.val();
	recordStart = 0;
	loadTableWithNewData(true);
}
function deleteCompanyFromCompanyCard(ID){
	w2ui.grid.select(ID);
	w2ui.grid.delete(true);
}
function updateCompanyUsersCount(companyList){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/findAllCompaniesUsersCount',
		data:{c:companyList},
		dataType:'json'
	}).done(function(d){
		if(d.length > 0){
			d.forEach(function(u){
				w2ui.grid.set(u.id,{no_of_users:u.count_users});
				if (w2ui.hasOwnProperty('subgrid-' + u.id)){
					w2ui['subgrid-' + u.id].destroy();
					w2ui.grid.collapse(u.id);
					setTimeout(()=>{
						w2ui.grid.expand(u.id);
					},300);
				}
			});
		}
	});
}
function updateCompanyAndUsers(ID,companyID) {
	console.log("FINDCompanyUsers",ID,companyID);
	var getRecords = [];
	if(parseInt(companyID) > 0){
		try{
			w2ui.grid.set(companyID,{no_of_users:getRecords.length});
			if (w2ui.hasOwnProperty('subgrid-' + companyID)){
				/*getRecords =  w2ui['subgrid-' + companyID].records;
				getRecords.map(function(u,i){
					if(parseInt(u.id) == parseInt(ID)){
						getRecords.splice(i,1);
						return false;
					}
				});
				w2ui['subgrid-' + companyID].destroy();
				showUserList(companyID,"grid_grid_rec_"+companyID+"_expanded_row",getRecords)*/
				w2ui['subgrid-' + companyID].destroy();
				w2ui.grid.collapse(companyID);
				setTimeout(()=>{
					w2ui.grid.expand(companyID);
				},300);
			}
		}catch(e){}
	}
}
/*Delete Contact list*/
function deleteContactList(contactList){
	let deleteList = jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/deleteContactsInBatch',
			data:{c:JSON.stringify(contactList)},
			cache:false
		});
	return deleteList;
}
/*Delete single contact*/
function deleteContact(ID,companyID){
	res = confirm("Are your sure?");
	if(res){
		//contactDelete(ID,companyID);
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/deleteContact',
			data:{delete_link:parseInt(ID)},
			cache:false,
			success:function(data){
				if(parseInt(data)>0){
					updateCompanyAndUsers(ID,companyID);					
					if(parseInt(companyID) > 0){						
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
						if(window.parent.jQuery("#open_contact_add").hasClass('is-open')){
							var _frameSrc = window.parent.jQuery("#open_contact_add").find("iframe").attr('src');
							_frameSrc = _frameSrc.replace("https://backyard.synpat.com/opportunity/add_contact/","");
							if(_frameSrc != "") {
								if(parseInt(_frameSrc) == ID) {
									window.parent.jQuery("#open_contact_add").find('a.close_sidebar').trigger('click');
								}
							}
						}
					}
				} else if(data=='-1'){
					alert("Some correspondense with this contact.");
				}
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
var _leadContacts;
function findCompaniesInLead(leadID , t){
	if(_leadID!=leadID){
		_leadID = leadID;
	}	
	if(t===true){
		selectParentLeadTable(leadID);
	}
	if(jQuery("#profileListType").val()>0){
		_activity = jQuery("#profileListType").val();
		if(!jQuery('input[name="list_selected"]').is(':checked')){
			jQuery('input[name="list_selected"]').eq(0).trigger("click");
		} else {
			getAllCompanyToLead(jQuery('input[name="list_selected"]').eq(0));
		}		
	}		
}
function findCompaniesNoneSpeciality(o) {
	if(o.hasClass('selected') === false){
		o.addClass('selected');
		var parentTH = jQuery('div[filter-name="specialties"]');
		parentTH.find('.list_options').find('.list').empty();
		parentTH.find('input[type="text"]').val('');
	} else {
		o.removeClass('selected');
	}
	
	_filterSpecialties = [];
	_filterSpecialties.push("none");
	_pageAlphabetically = "";
	let elementTH = jQuery('.fixedHeader').find('th.n');
	elementTH.find(".list_options").find('.p-absolute').parent().hide();
	elementTH.removeClass('n');
	recordStart = 0;
	loadTableWithNewData(true);
}
function removeSpecialChar(_tag){
	switch(_tag.substring(0,1)){
		case '#':
		case '&':
		case '@':
		case '*':
		case '-':
		case '•':
		case '.':
		case '+':
		case '>':
		case '<':
		_tag = _tag.substr(1).trim();
		break;
	}
	if(_tag.substring(0,1)=='"'){
		_tag = _tag.replace(/['"]+/g, '');
	}
	if(_tag.substring(0,3)=='and'){
		_tag = _tag.substr(3).trim();
	}
	return _tag;
}
function formatSpeciallist(newSpecialist){
	var _listSpan = "";
	if(newSpecialist.length>0){
		if(oldSelectedList.type!=""){
			console.log("SELECTED",oldSelectedList);
			let specialistList = [];
			for(let j=0;j<newSpecialist.length;j++){
				if(newSpecialist[j][oldSelectedList.type]!=""){
					var _tagName = newSpecialist[j][oldSelectedList.type];
					_tagName = _tagName.trim();
					_tagName = removeSpecialChar(_tagName);
					_class = "";
					_tagName = _tagName.trim();
					_tagName = _tagName.split(';');
					_tagName.map(function(_tag){
						_tag = _tag.trim().toLowerCase();
						if(jQuery.inArray(_tag,specialistList) < 0){
							_tag = removeSpecialChar(_tag);
							specialistList.push(_tag);
						}						
					});
					
					
					/*
					if(_class == ""){
						_tagName = _tagName.split(';');
						_tagName.map(function(_tag){
							let findStr = oldSelectedList.list.findFirstSubstring(jQuery.trim(_tag).toString());
							if(findStr >= 0){
								_class = "selected";
							}		
							_listSpan += "<span class='list_special "+_class+"' onclick='selectSpecialist(jQuery(this))'>"+jQuery.trim(_tag)+"</span>";
						});
					} else {
						_listSpan += "<span class='list_special "+_class+"' onclick='selectSpecialist(jQuery(this))'>"+jQuery.trim(_tagName)+"</span>";
					}*/
				}
			}
			specialistList.sort();
			if(specialistList.length > 0){
				specialistList.map(function(_tag){
					_class = "";
					if(oldSelectedList != "undefined" && typeof oldSelectedList != "undefined" && oldSelectedList.list.length>0){
						let findStr = oldSelectedList.list.find(function(str) {
							return str == _tag;
						});
						if(findStr != undefined && findStr != null){
							_class = "selected";
						}
					}
					_listSpan += "<span class='list_special "+_class+"' onclick='selectSpecialist(jQuery(this))'>"+jQuery.trim(_tag)+"</span>";
				})
			}			
		}
	}
	_alreadyAddTags = [];
	if(newSpecialist.length>0){
		_stringPagination ="";
		if(_startTag>0){
			_stringPagination = "<a title='Previous' class='page-p' data-current='"+_current+"' href='javascript://' onclick='previousTags(jQuery(this))'><i class='fa fa-chevron-left'></i></a>";
		}				
		if(_current<totalTags){
			_stringPagination +="<a title='Next' class='page-n' data-current='"+_current+"' href='javascript://' onclick='nextTags(jQuery(this))'><i class='fa fa-chevron-right'></i></a>";
		}
		jQuery('.paging').html(_stringPagination);
	}
	jQuery(".filter_box").eq(5).find('.list_options').find('.list').html(_listSpan);
}
function selectSpecialityAll() {
	if(jQuery('.list_special').hasClass('selected')) {
		jQuery('.list_special').removeClass('selected');
	} else {
		jQuery('.list_special').addClass('selected');
	}	
}
var _startTag = 0;
let _current = 1000;
function previousTags(o){
	_current = o.attr('data-current');
	_current = parseInt(_current);
	/*_current -=1000;*/
	_startTag = _current - 1000;
	if(_startTag<0){
		_startTag = 0;
	}
	_current = _startTag;
	if(_current==0){
		_current = 1000;
	}
	jQuery(".fixedHeader").find('thead th').eq(10).find('.list_options').find('.list').empty();
	/*oldSelectedList.type = 'specialties';
	oldSelectedList.list = [];
	oldSelectedList.eq = 10;*/
	filterDropDrown();
}
function nextTags(o){
	_current = o.attr('data-current');

	_current = parseInt(_current);
	_startTag = _current;
	_next = _current + 1000;

	if(_next>totalTags){
		_next = totalTags - _startTag;
	}
	_current = _next;
	jQuery(".fixedHeader").find('thead th').eq(10).find('.list_options').find('.list').empty();
	/*oldSelectedList.type = 'specialties';
	oldSelectedList.list = [];
	oldSelectedList.eq = 10;*/
	filterDropDrown();
}
function selectSpecialist(o){
	if(o.hasClass('selected')){
		o.removeClass('selected');
		var findIndex = oldSelectedList.list.indexOf(o.text());
		if(findIndex >= 0){
			oldSelectedList.list.splice(findIndex,1);
		}
	} else {
		o.addClass('selected');
		oldSelectedList.list.push(o.text());
	}
}
function mergeCompanies(){
	var _merger = [], _survivor = [];
	if(jQuery("#grid_grid_records").find('input.merger_chk:checked').length > 0) {
		jQuery("#grid_grid_records").find('input.merger_chk:checked').each(function(){
			_merger.push(jQuery(this).val());
		});
	}
	if(jQuery("#grid_grid_records").find('input.survivor_chk:checked').length > 0) {
		jQuery("#grid_grid_records").find('input.survivor_chk:checked').each(function(){
			_survivor.push(jQuery(this).val());
		});
	}
	if(_survivor.length==1 && _merger.length > 0){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/merge_companies_data',
			data:{m:_merger,s:_survivor},
			dataType:'json',
			cache:false
		})
		.done(function(d){
			if(d.update>0){
				w2ui.grid.select(_merger.join(','));
				w2ui.grid.delete(true);
				w2ui.grid.set(_survivor,{no_of_users:d.survivour_data.companyUsers.length});
			}
		}).fail(function(jqXHR,textStatus){
			alert(textStatus);
		});
	} else if(_survivor.length > 1) {
		alert("There should be only one survivor");
	} else {
		alert("Please check merger and survivor companies first");
	}
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
function callLeadData(){
	if(_activity>0){
		window.parent.jQuery("#activityMainType").val(_activity)
		jQuery("#profileListType").val(_activity);
		jQuery("#profileListType").prop('disabled',true);
	}
	/*jQuery.ajax({
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
		
	});*/
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
			jQuery(".fixedHeader").find('thead th').eq(11).find('.list_options').find('.list').empty();				
			jQuery('.fixedHeader thead th').eq(11).find('.list_options').find('.list').append(_selectUl);
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
			jQuery(".fixedHeader").find('thead th').eq(9).find('.list_options').find('.list').empty();				
			jQuery('.fixedHeader thead th').eq(9).find('.list_options').find('.list').append(_selectUl);
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
			jQuery('.fixedHeader').find('thead th').eq(14).find('.list').empty().append(_selectUl);
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
	return '';
}
function getCompanyIndustry(){
	_selectUl = jQuery("<ul/>").addClass('open_list');
	var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
	var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',"");
	var spanY = jQuery("<span/>").css('float','left').append(checkBox);
	var spanX = jQuery('<span/>').append("None");
	_selectLi.append(spanY).append(spanX);
	_selectUl.append(_selectLi);		
	jQuery.each(_companyIndustry,function(i,c){
		var _selectLi = jQuery("<li/>").css({'float':'left','width':'100%'});
		var checkBox = jQuery('<input/>').attr('type','checkbox').attr('value',c.industry);
		var spanY = jQuery("<span/>").css('float','left').append(checkBox);
		var spanX = jQuery('<span/>').append(c.industry);
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
		setTimeout(function(){parentTh.addClass('n');},10);
		parentTh.find(".list_options").find('.p-absolute').parent().show();
		_height = parentTh.outerHeight();
		let hH = jQuery(window).height() - 150;
		let _innerHH = hH - 70;
		hH = hH+'px';
		parentTh.find(".list_options").find('.p-absolute .list').css({height:_innerHH+'px'});
		_width = 365;
		var leftPostion = x;
		if(o.attr('filter-name')=="specialties"){
			_width = jQuery(window).width() - 18;			
			hH = jQuery(window).height() - 150;
			_position = parentTh.position();
			leftPostion = 0;
			
			/*_diff = _docW - leftPostion;
			if(_diff<1000){
				_d = _width - _diff ;
				leftPostion -=_d;
				leftPostion -=30;
			}*/
		}
		y = 91;
		parentTh.find(".list_options").find('.p-absolute').css({height:hH,top:y,left:leftPostion,width:_width+'px',background:'#fff',border:'1px solid #dfe8f1'}).find('.btn-primary').attr('col',col);
		oldSelectedList.type = parentTh.attr('filter-name');
		/*if(parentTh.attr('filter-name') != "specialties"){
			oldSelectedList.list = [];
		}	*/	
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
				var textSpecial = jQuery.trim(jQuery(this).text());
				var findIndex = oldSelectedList.list.indexOf(textSpecial);
				if(findIndex<0){
					oldSelectedList.list.push(textSpecial);
				}
			});
		}
		if(oldSelectedList.type!="" && oldSelectedList.type !="label" && oldSelectedList.type !="invited"){
			parentTh.find('.list').empty();
		}		

		switch(oldSelectedList.type){
			case 'no_of_users':
				oldSelectedList.eq = 1;
				filterDropDrown();
				break;
			case 'no_of_employees':
				oldSelectedList.eq = 2;
				filterDropDrown();
				break;
			case 'company_size':
				oldSelectedList.eq = 3;
				filterDropDrown();
				break;
			case 'industry':
				oldSelectedList.eq = 4;
				filterDropDrown();
				break;
			case 'specialties':
				oldSelectedList.eq = 5;
				_startTag = 0;
				_current = 1000;
				filterDropDrown();
				break;
			case 'sector':
				oldSelectedList.eq = 6;
				filterDropDrown();
				break;
			case 'tech':
				oldSelectedList.eq = 9;
				filterDropDrown();
				break;
			case 'invited':
				oldSelectedList.eq = 10;
				break;
		}
	}
}
function filterDropDrown(){
	if(_activity == "" || _activity == 0){
		_activity = jQuery("#profileListType").val();
	}
	_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,label:_filterLabel,specialist:_filterSpecialties,start:_startTag,end:1000,sort_field:_sortField,sort_by:_sortBy,t:true,ignore:oldSelectedList.type,tagSearch:jQuery("#search_specialist").val(),invited:_filterInvited}
	jQuery.ajax({
		url:__baseUrl+'opportunity/get_filter_list/'+_leadID+'/'+_activity+'/ajax/50000',
		type:"POST",
		data:_filters,
		cache:false,
		dataType:'json',
		success:function(list){	
			if(oldSelectedList.type!="specialties"){
				_selectUl = "<ul class='open_list'>";
				if(list.data.length>0){
					_selectUl +="<li style='float:left;width:100%;'><span style='float:left;'><input type='checkbox' onclick='checkMeCheckAll(jQuery(this))' /></span><span>All</span>";
					for(let i=0;i<list.data.length;i++){
						let l = list.data[i];
						let _checked = "";
						if(oldSelectedList.list.length>0){
							let crrValue = l[oldSelectedList.type];
							if(oldSelectedList.type=="company_size" || oldSelectedList.type=="sector"){
								crrValue = l.type;
							}
							if(!isNaN(parseInt(crrValue)) && oldSelectedList.type!="company_size"){
								crrValue = parseInt(crrValue);
								if(i == 0) {
									oldSelectedList.list = oldSelectedList.list.map(function(x){
										return parseInt(x);
									});
								}
							} 
							if(oldSelectedList.list.indexOf(crrValue)>=0){
								_checked = "CHECKED='CHECKED'";
							}
						}
						let tagName = (l[oldSelectedList.type]!='')?l[oldSelectedList.type]:'None';
						let _value = l[oldSelectedList.type];
						if(oldSelectedList.type=="company_size" || oldSelectedList.type=="sector"){
							_value = l.type;
						}
						_selectUl +="<li style='float:left;width:100%;'><span style='float:left;'><input type='checkbox' onclick='checkThis($(this))' value='"+_value+"' "+_checked+" /></span><span>"+tagName+"</span>";
					}
				}
				_selectUl += "</ul>";
				jQuery('.filter_box').eq(oldSelectedList.eq).find('.list').empty().html(_selectUl);
			} else {
				totalTags = list.count_all;
				formatSpeciallist(list.data);
			}
		}
	}).always(function(){
		/*getAllSpecialist(false);*/
	});
}
const formatter = new Intl.NumberFormat('en-IN');

function number_format(number, decimals, dec_point, thousands_point) {

    if (number == null || !isFinite(number)) {
        throw new TypeError("number is not valid");
    }

    if (!decimals) {
        var len = number.toString().split('.').length;
        decimals = len > 1 ? len : 0;
    }

    if (!dec_point) {
        dec_point = '.';
    }

    if (!thousands_point) {
        thousands_point = ',';
    }

    number = parseFloat(number).toFixed(decimals);

    number = number.replace(".", dec_point);

    var splitNum = number.split(dec_point);
    splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
    number = splitNum.join(dec_point);

    return number;
}

function changeActivityType(o){
	if(_leadID==0){
		alert("Please select lead first");
		o.val(0);
	} else {
		_activity = 0;
		if(o.val()>0){		
			_activity = o.val();
		}
		recordStart = 0;
		loadTableWithNewData(true);
		/*if(o.val()>0){
			if(!jQuery('input[name="list_selected"]').is(':checked')){
				jQuery('input[name="list_selected"]').eq(0).trigger("click");
			} else {
				getAllCompanyToLead(jQuery('input[name="list_selected"]').eq(0));
			}
		} else {
			loadTableWithNewData(true);
		}*/
	}
}
var oldSelectedList = {type:'',list:[],eq:-1};
function searchFilter(o){
	recordStart = 0;
	var parentTH = o.parents('.filter_box');
	parentTH.addClass('open');
	var col = o.attr('col');

	if(col != "" && col != "undefined") {
		jQuery("#grid_grid_column_"+col).addClass('open');
	}
	var _filterName = parentTH.attr('filter-name');
	console.log("Filter:",_filterName);
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
		case 'label':
			_filterLabel = parentTH.find('input[type="radio"]:checked').val();
			break;
		case 'invited':
			_filterInvited = parentTH.find('input[type="radio"]:checked').val();
			console.log(_filterInvited);
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
		case 'specialties':
			if(oldSelectedList.list.length == 0){
				_filterSpecialties = [];
				if(parentTH.find('.list span.selected').length>0){
					parentTH.find('.list span.selected').each(function(){
						_filterSpecialties.push(jQuery(this).text());
					});
				} else if(parentTH.find('#empty_specialties').hasClass('selected')){
					_filterSpecialties.push('none');
				}
			} else {
				_filterSpecialties = oldSelectedList.list;
			}	
			break;
		case 'company_size':
			_filterCompanySize = [];
			if(parentTH.find('.list input[type="checkbox"]:checked').length>0){
				parentTH.find('.list input[type="checkbox"]:checked').each(function(){
					_filterCompanySize.push(jQuery(this).val());
				});
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
	_scrollTable = true;
	loadTableWithNewData(true);
}
function clearFilter(o){
	recordStart = 0;
	var parentTH = o.parents('.filter_box');
	parentTH.removeClass('open').removeClass('n');
	parentTH.find('input[type="text"]').val('');
	var _filterName = parentTH.attr('filter-name');
	if(_filterName != "label" && _filterName != "invited"){
		parentTH.find('.list_options').find('.list').empty();
	}	
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
		case 'label':
			_filterLabel = "";
			break;	
		case 'invited':
			_filterInvited = "";
			break;
		case 'linkedin':
			_filterLinkedIn = "";
			break;
		case 'industry':
			_filterCompanyIndustry = [];
			break;
		case 'specialties':
			_filterSpecialties = [];
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
	parentTH.find('span.selected').removeClass('selected');
	parentTH.find(".list_options").find('.p-absolute').parent().hide();
	loadTableWithNewData(true);
}

var acquisitionCompanies = [], salesCompanies = [];
let recordStart = 0, recordLimit = 1000, scraper= false;
let companiesColumns = [				
			{ field: 'selected', text: 'Invited', sortable: true, type: 'int', size: '60px',
				render: function(record) {
					_checked = "";
					if(parseInt(record.selected) == 1) {
						_checked = "CHECKED='CHECKED'";
					}
					return '<input type="checkbox" '+_checked+' value="'+record.recid+'" onchange="return checkedMe(jQuery(this))" name="vendor_select_bulk[]" class="checker"/>'
				}
			},
			
			{ field: 'recid', text: 'Merging', type: 'int', size: '65px',
				render: function(record) {
					return '<input type="checkbox" value="'+record.recid+'" class="merger_chk" />'
				}
			},
			{ field: 'recid', text: 'Survior', type: 'int', size: '60px' ,
				render: function(record) {
					return '<input type="checkbox" value="'+record.recid+'" class="survivor_chk" />'
				}
			},
			{ field: 'company_name', text: 'Company Name', size: '250px', sortable: true, resizable: true,
				render: function(record){
					return '<a href="javascript://" class="company" onclick="openCompanyCard('+record.recid+',jQuery(this))">'+record.company_name+'</a>'
				}
			},
			{ field: 'label', text: '!', size: '20px', resizable: true, sortable: true, type:'int',
				render: function(record){
					let checked = "";
					if(record.scrape_people_again == 1){
						checked = "CHECKED='CHECKED'";
					}
					let inputCheckbox = '<input type="checkbox" value="'+record.recid+'" name="scrape_people_again" '+checked+' onclick="updateMeScrapePeopleAgain(jQuery(this));"/>';
					/*return  (parseInt(record.label) > 0) ?'<i class="fa fa-exclamation"></i>' : '';*/
					return  inputCheckbox;
				}
			},
			{ field: 'no_of_users', text: 'Users', size: '55px', sortable: true, resizable: true},
			{ field: 'no_of_employees', text: 'LinkedIn', size: '65px', sortable: true, resizable: true,
				render: function(record){
					return  (parseInt(record.no_of_employees) > 0) ? number_format(record.no_of_employees): '';
				}
			},
			{ field: 'company_size_type', text: 'Size', size: '85px', sortable: true, resizable: true,
				render: function(record){
					return  record.company_size_type;
				}
			},
			{ field: 'industry', text: 'Industry', size: '170px', sortable: true, resizable: true},
			{ field: 'specialist', text: 'Specialties', size: '200px', sortable: true, resizable: true},
			{ field: 'create_date', text: 'Create', size: '80px', sortable: true, resizable: true},
			{ field: 'scrapped_profile_datetime', text: 'Updated', size: '80px', sortable: true, resizable: true,
				render: function(record) {
					return (record.scrapped_profile_date != "0000-00-00")? moment(new Date(record.scrapped_profile_date+" 00:00:00")).format('MM/DD/YYYY'):'';
				}
			},
			{ field: 'id', text: 'ID', size: '55px', sortable: true,  resizable: true, render: 'int' },
			{ field: 'sectors', text: 'Sectors', size: '150px', sortable: true, resizable: true},
			{ field: 'categories', text: 'Categories', size: '150px', sortable: true, resizable: true},
			{ field: 'sub_category', text: 'SubCategories', size: '170px', sortable: true, resizable: true},
			{ field: 'technology_names', text: 'Technologies', size: '150px', sortable: true, resizable: true},
			{ field: 'sub_technology_names', text: 'SubTechnologies', size: '170px', sortable: true, resizable: true}
		];
<?php if($scraper == true):?>
scraper = true;
companiesColumns = [
	{ field: 'label', text: '!', size: '20px', resizable: true, sortable: true, type:'int',
		render: function(record){
			let checked = "";
			if(record.scrape_people_again == 1){
				checked = "CHECKED='CHECKED'";
			}
			let inputCheckbox = '<input type="checkbox" value="'+record.recid+'" name="scrape_people_again" '+checked+' onclick="updateMeScrapePeopleAgain(jQuery(this));"/>';
			/*return  (parseInt(record.label) > 0) ?'<i class="fa fa-exclamation"></i>' : '';*/
			return  inputCheckbox;
		}
	}
];
<?php endif;?>

/*Load new company IDs from server*/
function loadTableWithNewData(t,l){
	let loadData = true;
	if(scraper == true && scrape_companies.length == 0){
		loadData = false;
	}
	if(loadData === true){
	message = "Loading...";
	jQuery("#total_result_found").html('Total records:0');
	setTimeout(function(){
		if(w2ui.hasOwnProperty('grid')){
			w2ui.grid.status(message);
		}
	},500);
	_url = __baseUrl+'opportunity/company_list/'+_leadID+'/'+_activity+'/ajax/';
	_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,label:_filterLabel,specialist:_filterSpecialties,alpha:_pageAlphabetically,start:recordStart,end:recordLimit,sort_field:_sortField,sort_by:_sortBy,t:t,invited:_filterInvited,scrape_companies:scrape_companies};
	jQuery.ajax({
		type:"POST",
		url:_url,
		data:_filters,
		cache:false,
		dataType:'json',
	})
	.done(function(d){
		if(typeof l == "undefined"){
			if(w2ui.hasOwnProperty('grid')){
			  w2ui['grid'].destroy();
			}
			resizeGrid();
		}
		gridQueryTotalRecord = d.count_all;
		jQuery("#total_result_found").html('Total records: '+gridQueryTotalRecord);
		var filterBox = jQuery('.filter_box');
		if(_filterSector.length>0){
			if(typeof d.cat!="undefined"){				
				if(filterBox.eq(7).find('.list_options').find('.list').find('ul').length==0){
					filterBox.eq(7).find('.list_options').find('.list').empty();
					if(d.cat.length>0){
						var _selectUl = jQuery("<ul/>").addClass('open_list');
						jQuery.each(d.cat,function(i,s){
							var _selectLi = jQuery("<li/>").css({'float':'left',width:'100%'});
							var _input = jQuery("<input/>").attr("type","checkbox").attr("value",s.id);
							var spanX = jQuery("<span/>").css('float','left');
							spanX.append(_input);
							var spanY = jQuery("<span/>").append(s.name);
							_selectLi.append(spanX).append(spanY);
							_selectUl.append(_selectLi);
						});
						filterBox.eq(7).find('.list_options').find('.list').append(_selectUl);
					}
				}						
			}
		}
		if(_filterType.length>0){
			if(typeof d.sub_cat!="undefined"){
				if(filterBox.eq(8).find('.list_options').find('.list').find('ul').length==0){

					filterBox.eq(8).find('.list_options').find('.list').empty();
					if(d.sub_cat.length>0){
						var _selectUl = jQuery("<ul/>").addClass('open_list');
						jQuery.each(d.sub_cat,function(i,s){
							var _selectLi = jQuery("<li/>").css({'float':'left',width:'100%'});
							var _input = jQuery("<input/>").attr("type","checkbox").attr("value",s.id);
							var spanX = jQuery("<span/>").css('float','left');
							spanX.append(_input);
							var spanY = jQuery("<span/>").append(s.name);
							_selectLi.append(spanX).append(spanY);
							_selectUl.append(_selectLi);
						});
						filterBox.eq(8).find('.list_options').find('.list').append(_selectUl);
					}
				}						
			}
		}
		if(_filterTechnology.length>0){
			if(typeof d.sub_tech!="undefined"){
				if(filterBox.eq(10).find('.list_options').find('.list').find('ul').length==0){
					filterBox.eq(10).find('.list_options').find('.list').empty();
					if(d.sub_tech.length>0){
						var _selectUl = jQuery("<ul/>").addClass('open_list');
						jQuery.each(d.sub_tech,function(i,s){
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
		records = [];		
		if(d.companies.length > 0) {
			acquisitionCompanies = d.selected_acquisition_companies;
			salesCompanies = d.selected_sales_companies;
			d.companies.map(function(u){
				var _selected = 0;
				if(d.activity==2){
					if(d.selected_acquisition_companies.length>0){
						jQuery.each(d.selected_acquisition_companies,function(index,sc){
							if(sc.id==u.companyID){
								_selected = 1;
								return false;
							}
						});
					}
				} else if(d.activity==1){
					if(d.selected_sales_companies.length>0){
						jQuery.each(d.selected_sales_companies,function(index,sc){
							if(sc.id==u.companyID){
								_selected = 1;
								return false;
							}
						});
					}
				} else {
					if(d.selected_sales_companies.length>0){
						jQuery.each(d.selected_sales_companies,function(index,sc){
							if(sc.id==u.companyID){
								_selected = 1;
								return false;
							}
						});
					}
					if(_selected === 0){
						if(d.selected_acquisition_companies.length>0){
							jQuery.each(d.selected_acquisition_companies,function(index,sc){
								if(sc.id==u.companyID){
									_selected = 1;
									return false;
								}
							});
						}
					}
				}
				var _sectorName = u.sectorName;
				if(_sectorName==null){
					_sectorName='';
				}
				var _categories = u.department_names;
				if(_categories==null){
					_categories='';
				}
				var _sub_categories = u.sub_department_names;
				if(_sub_categories==null){
					_sub_categories='';
				}
												
				var _usersCount = 0;
				if(u.company_users!=null){
					_usersCount = u.company_users;
				} 
				object = {};
				object.id = u.companyID;
				object.recid = u.companyID;
				object.selected = _selected;
				object.company_name = u.company_name;
				object.no_of_users = parseInt(_usersCount);
				object.sectors = _sectorName;
				object.industry = u.industry;
				object.specialist = u.specialties;
				object.company_size = u.company_size;
				object.company_size_type = parseInt(u.company_size_type);
				object.no_of_employees = parseInt(u.no_of_employees);
				object.label = u.label;
				object.scrape_people_again = u.scrape_people_again;
				object.categories = _categories;
				object.sub_category = _sub_categories;
				object.technology_names = u.technology_names;
				object.sub_technology_names = u.sub_technology_names;
				object.scrapped_date = u.scrapped_date;
				object.scrapped_profile_date = u.scrapped_profile_date;
				object.scrapped_profile_datetime = (u.scrapped_profile_date != '0000-00-00')? moment(new Date(u.scrapped_profile_date)).unix():0;
				object.linkedin_url = u.linkedin_url;
				object.create_date = u.create_date;
				records.push(object);
			});			
		}
		message = "";
		if(typeof l == "undefined"){
			console.log("SP");
			generate();
		} else {
			console.log("SP2");
			updateRecordsToGrid(records);
			setTimeout(function(){
				if(w2ui.hasOwnProperty('grid')){
					w2ui.grid.status(message);
				}
			},500);
		}		
		querySend = false;
	})
	.always(function(){
		if(_callFilters===false){
			_callFilters = true;
			callLeadData();
		}
	}).fail(function(){
		
	});
	}
}

var _callFilters = false;
var records = [];
var message = "Loading....";
var sendRequestOnExpand = true;
window.generate = function generate() {
	$('#grid').w2grid({ 
		name	: 'grid', 
		header	: 'List of Companies',
		columnTooltip: 'top',
		show	: { footer: true, toolbar: false,selectColumn: true,emptyRecords: true,expandColumn: true },
		multiSearch: true,
		markSearch:true,
		multiSelect:true,
		multiSort:true,
		searches: [
            { field: 'company_name', label: 'Company Name', type: 'text' },
            { field: 'no_of_users', label: 'Users', type: 'list',options:{items:[]} },
            { field: 'no_of_employees', label: 'Linkedin', type: 'list', options: { items:[]} },
            { field: 'company_size', label: 'Size', type: 'list', options: { items:[]} },
            { field: 'industry', label: 'Industry', type: 'list', options: { items:[]} },
            { field: 'specialist', label: 'Specialties', type: 'list', options: { items:[]} },
            { field: 'sectors', label: 'Sectors', type: 'list', options: { items:[]} },
            { field: 'categories', label: 'Categories', type: 'list', options: { items:[]} },
            { field: 'sub_category', label: 'Sub-Categories', type: 'list', options: { items:[]} },
            { field: 'technology_names', label: 'Technologies', type: 'list', options: { items:[]} },
            { field: 'sub_technology_names', label: 'Sub-Technologies', type: 'list', options: { items:[]} }
        ],
		columns: [				
			{ field: 'selected', text: 'Invited', sortable: true, type: 'int', size: '60px',
				render: function(record) {
					_checked = "";
					if(parseInt(record.selected) == 1) {
						_checked = "CHECKED='CHECKED'";
					}
					return '<input type="checkbox" '+_checked+' value="'+record.recid+'" onchange="return checkedMe(jQuery(this))" name="vendor_select_bulk[]" class="checker"/>'
				}
			},
			
			{ field: 'recid', text: 'Merging', type: 'int', size: '65px',
				render: function(record) {
					return '<input type="checkbox" value="'+record.recid+'" class="merger_chk" />'
				}
			},
			{ field: 'recid', text: 'Survior', type: 'int', size: '60px' ,
				render: function(record) {
					return '<input type="checkbox" value="'+record.recid+'" class="survivor_chk" />'
				}
			},
			{ field: 'company_name', text: 'Company Name', size: '250px', sortable: true, resizable: true,
				render: function(record){
					return '<a href="javascript://" class="company" onclick="openCompanyCard('+record.recid+',jQuery(this))">'+record.company_name+'</a>'
				}
			},
			{ field: 'label', text: '!', size: '20px', resizable: true, sortable: true, type:'int',
				render: function(record){
					let checked = "";
					if(record.scrape_people_again == 1){
						checked = "CHECKED='CHECKED'";
					}
					let inputCheckbox = '<input type="checkbox" value="'+record.recid+'" name="scrape_people_again" '+checked+' onclick="updateMeScrapePeopleAgain(jQuery(this));"/>';
					/*return  (parseInt(record.label) > 0) ?'<i class="fa fa-exclamation"></i>' : '';*/
					return  inputCheckbox;
				}
			},
			{ field: 'no_of_users', text: 'Users', size: '55px', sortable: true, resizable: true},
			{ field: 'no_of_employees', text: 'LinkedIn', size: '65px', sortable: true, resizable: true,
				render: function(record){
					return  (parseInt(record.no_of_employees) > 0) ? number_format(record.no_of_employees): '';
				}
			},
			{ field: 'company_size_type', text: 'Size', size: '85px', sortable: true, resizable: true,
				render: function(record){
					return  record.company_size_type;
				}
			},
			{ field: 'industry', text: 'Industry', size: '170px', sortable: true, resizable: true},
			{ field: 'specialist', text: 'Specialties', size: '200px', sortable: true, resizable: true},
			{ field: 'create_date', text: 'Create', size: '80px', sortable: true, resizable: true},
			{ field: 'scrapped_profile_datetime', text: 'Updated', size: '80px', sortable: true, resizable: true,
				render: function(record) {
					return (record.scrapped_profile_date != "0000-00-00")? moment(new Date(record.scrapped_profile_date+" 00:00:00")).format('MM/DD/YYYY'):'';
				}
			},
			{ field: 'id', text: 'ID', size: '55px', sortable: true,  resizable: true, render: 'int' },
			{ field: 'sectors', text: 'Sectors', size: '150px', sortable: true, resizable: true},
			{ field: 'categories', text: 'Categories', size: '150px', sortable: true, resizable: true},
			{ field: 'sub_category', text: 'SubCategories', size: '170px', sortable: true, resizable: true},
			{ field: 'technology_names', text: 'Technologies', size: '150px', sortable: true, resizable: true},
			{ field: 'sub_technology_names', text: 'SubTechnologies', size: '170px', sortable: true, resizable: true}
		],
		records: records,
		onClick: function(event) {
			//console.log("Event",event);
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
			//console.log("Event",event);
			if(event.recid > 0) {
				var listSelected = w2ui.grid.getSelection();
				var unSelected = [];

				if(listSelected.length > 0 && listSelected.indexOf(event.recid) >= 0 ) {

					listSelected.splice(listSelected.indexOf(event.recid),1);
					unSelected.push(parseInt(event.recid));
				} else {

					listSelected.push(event.recid);
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
		},
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
					case "selected":
						col = 1;
						colIndex = 11;
						break;
					case "label":						
						col = 4;
						colIndex = 0;
						break;	
					case "no_of_users":						
						col = 5;
						colIndex = 1;
						break;
					case "no_of_employees":						
						col = 6;
						colIndex = 2;
						break;
					case "company_size_type":						
						col = 7;
						colIndex = 3;
						break;
					case "industry":						
						col = 8;
						colIndex = 4;
						break;
					case "specialist":						
						col = 9;
						colIndex = 5;
						break;
					case "sectors":						
						col = 13;
						colIndex = 6;
						break;
					case "categories":						
						col = 14;
						colIndex = 7;
						break;
					case "sub_category":						
						col = 15;
						colIndex = 8;
						break;
					case "technology_names":						
						col = 16;
						colIndex = 9;
						break;
					case "sub_technology_names":						
						col = 17;
						colIndex = 10;
						break;
				}
				if(col > 0) {
					openFilterList(filterBox.eq(colIndex),offsetX,offsetY,col);
				}
				event.preventDefault();
			} else {
				console.log(2);
				highlightsColumns();
				addPlus();
				console.log("TTTCC");
				const gridRec = jQuery("#grid_grid_records");
				if(gridRec.length > 0){
					scrollTop = gridRec.scrollTop();
				} else {
					scrollTop = 0;
				}
				triggerScrollEvent();
			}		
		},
		onRender: function(event){
			console.log(1);
			highlightsColumns();
			addPlus();
			scrollTop = 0;
			console.log("TTT");
			triggerScrollEvent();
		},
		onExpand: function (event) {
			console.log("expand",event);
			if(sendRequestOnExpand === true){
				findCompanyUsers(event.recid,event.box_id);
			} 			
			//$('#' + event.box_id).html('some html').animate({ height : 100 }, 100);
		}
	});
	w2ui.grid.buffered = records.length;
	w2ui.grid.total = w2ui.grid.buffered;
	w2ui.grid.resize();
	triggerScrollEvent();
}

function updateMeScrapePeopleAgain(o){
	let c = 0;
	if(o.is(':checked')){
		c = 1;
	}
	jQuery.ajax({
		url:__baseUrl+'opportunity/update_company_scrape_people_again',
		type:'POST',
		data:{c:o.val(),p:c},
		dataType:'json',
		cache:false
	})
	.done(function(d){
		console.log("updateMeScrapePeopleAgain",d);
		
		w2ui.grid.set(o.val(),{scrape_people_again:1});
		if(scraper == true && scrape_companies.length > 0){
			let list = [],url = __baseUrl+'opportunity/deleteBulkPreCompanyList';
			list.push(o.val());
			jQuery.ajax({
				type:'POST',
				url:url,
				data:{delete_link:list},
			})
			.done(function(d){
				if(d != "") {
					/*w2ui.grid.select(list.join(','));
					w2ui.grid.delete(true);*/
				}
			});
		}
	});
}

function updateRecordsToGrid(moreRecords){
	let gridR = w2ui.grid.records.length + moreRecords.length;
	console.log(w2ui.grid);
	console.log(moreRecords);
	w2ui.grid.add(moreRecords,false);
	w2ui.grid.buffered = gridR;
	w2ui.grid.total = w2ui.grid.buffered;
	/*w2ui.grid.sort('fname', 'asc');*/
	const gridColumns = $("#grid_grid_columns");
	let sort = 'desc';
	let colSort = gridColumns.find('td.w2ui-sort-up');
	if(colSort.length == 0){
		colSort = gridColumns.find('td.w2ui-sort-down');
		if(colSort.length > 0){
			sort = 'asc';
		}		
	}
	let sortIndex = 4;
	if(colSort.length > 0){
		sortIndex = colSort.index();
	}
	let field = 'company_name';
	switch(sortIndex){
		case 1:
			field = "selected";
			break;
		case 4:
			field = "company_name";
			break;
		case 5:
			field = "label";
			break;
		case 6:
			field = "no_of_users";
			break;
		case 7:
			field = "no_of_employees";
			break;
		case 8:
			field = "company_size_type";
			break;
		case 9:
			field = "industry";
			break;
		case 10:
			field = "specialist";
			break;
		case 11:
			field = "create_date";
			break;
		case 12:
			field = "scrapped_profile_datetime";
			break;
		case 12:
			field = "id";
			break;
	}
	if(field != "" && sort != ''){
		console.log(sort);
		if(sort == 'desc'){
			sort = 'asc';
		} else {
			sort = 'desc';
		}
		console.log(sort);
		w2ui.grid.sort(field, sort);
	}	
	const gridRec = jQuery("#grid_grid_records");
	if(gridRec.length > 0 && scrollTop > 0){
		gridRec.scrollTop(scrollTop);
	}
	triggerScrollEvent();
}
function addPlus(){
	setTimeout(function(){jQuery("#grid_grid_fcolumns").find('td.w2ui-col-expand').find("div").html('<a href="javascript://" onclick="openAllCompanyUsers(jQuery(this));" style="color:#000 !important;">+</a>');},600);
}
function openAllCompanyUsers(o) {
	var companyList = [];
	var getSelection = w2ui.grid.getSelection();
	if(getSelection.length > 0){
		companyList = getSelection;
	} else {
		var getRecords = w2ui.grid.records;
		if(getRecords.length > 0) {
			getRecords.map(function(c){
				companyList.push(c.recid);
				//w2ui.grid.expand(c.recid);
			});
		}
	}		
	/*var companyList = w2ui.grid.getSelection();*/
	if(companyList.length > 0){
		sendRequestOnExpand = true;
		var stringifyCompany = JSON.stringify(companyList);
		window.parent.contactFrameWithSelectedCompanies(stringifyCompany,scraper);			
	}
}

function showUsersListInPopup(usersList){
	jQuery("#all_users_modal").modal('show');
	if (w2ui.hasOwnProperty('all_users')){w2ui['all_users'].destroy();}
	jQuery('#all_users_grid').w2grid({
		name: 'all_users',
		show: { columnHeaders: true,selectColumn: true },
		multiSelect:true,
		columns: [
			{ field: 'id', text: '#', size: '100px',
				render:function(record) {
					var rowHTML = "";
					rowHTML += "<a href='javascript://' onclick='deleteContact("+record.id+","+record.company_id+")'><i class='fa fa-trash'></i> ";
					if(record.email!=""){
						rowHTML += "<a href='javascript://' onclick='openActivityBox("+record.company_id+","+record.id+")' style='margin-right:3px;'><i class='fa fa-envelope'></i></a>";
					}
					if(record.phone!="" ){
						rowHTML += "<a href='javascript://' onclick='openActivityBox("+record.company_id+","+record.id+")><i class='fa fa-phone'></i></a>";
					}
					if( record.telephone!=""){
						rowHTML += "<a href='javascript://' onclick='openActivityBox("+record.company_id+","+record.id+")><i class='fa fa-phone-square'></i></a>";
					}
					if(record.linkedin_url!=""){
						rowHTML += "<a href='"+record.linkedin_url+"' target='_blank'><i class='fa fa-linkedin'></i></a>";
					}
					if(record.gateway==1){
						rowHTML += "<i class='fa' style='margin-left:5px;'><img src='https://storage.googleapis.com/static.synpat.com/backyard/images/gateway-1.png'/></i> ";
					}
					if(record.no_contact=='1'){
						rowHTML += '&nbsp;&nbsp;<img src="'+__baseUrl+'public/images/no_contact.jpg"/>';
					}
					return rowHTML;
				}
			},
			{ field: 'name', text: 'Name', sortable: true, size: '150px',
				render: function(record) {
					return "<a href='javascript://' onclick='highlight($(this),"+record.id+","+record.company_id+");window.parent.editContact("+record.id+")'>"+record.name+"</a>";
				}
			},
			{ field: 'proximity', text: 'C', sortable: true, size: '30px', attr: "align='center'" },
			{ field: 'c_c', text: 'CC', size: '50px', sortable: true, attr: "align='center'" },
			{ field: 'company_name', text: 'Company', sortable: true, size: '300px'},
			{ field: 'current_company', text: 'Current C', sortable: true, size: '200px', attr: "align='center'" },
			{ field: 'job_title', text: 'Title', sortable: true, size: '300px'},
		],
		recid: 'id',
		records: usersList
	});
}

let scrollLeft = 0, scrollTop = 0, gridQueryTotalRecord = 0, querySend = false;
function triggerScrollEvent() {
	setTimeout(function(){
		jQuery("#grid_grid_records").off("scroll").on("scroll",function(){
			console.log("ScrollLeft",this.scrollLeft);
			if(scrollLeft > 0 && this.scrollLeft == 0) {
				console.log("SCROLLIN");
				var gridRecords = jQuery("#grid_grid_records");
				if(gridRecords.find('tr.w2ui-expanded-row').length > 0) {
					gridRecords.find('tr.w2ui-expanded-row').each(function(){
						var thisID = jQuery(this).attr('id');
						thisID = thisID.replace("grid_grid_rec_","");
						thisID = thisID.replace("_expanded_row","");
						try{
							if(parseInt(thisID) > 0) {
								if (w2ui.hasOwnProperty('subgrid-' + thisID)){
									const getSelection = w2ui['subgrid-' + thisID].getSelection();
									expandSelectedList.push({companyID:thisID,list:getSelection});
									/*showUserList(thisID,"grid_grid_rec_"+thisID+"_expanded_row",getRecords);*/
									w2ui['subgrid-' + thisID].destroy();
									w2ui.grid.collapse(thisID);
									setTimeout(()=>{
										console.log("Expand",thisID);
										w2ui.grid.expand(thisID);
										selectUsers(expandSelectedList,thisID);
									},300);
								}
							}
						}catch(e){}
					});
				}
			}
			if(scrollTop > 0 && this.scrollTop > 0) {
				const gridFooter = $("#grid_grid_footer");
				let footerText = gridFooter.find('.w2ui-footer-right').text();
				if(footerText != ""){
					let textSplit = footerText.split(" of ");
					if(textSplit.length == 2){
						var regex = new RegExp(',', 'g');
						let currentRecord = textSplit[0];
						currentRecord = currentRecord.split('-').pop();
						currentRecord = currentRecord.replace(regex, '');
						currentRecord = parseInt(currentRecord);
						let gridTotalRecord = textSplit[1];
						gridTotalRecord = gridTotalRecord.replace(regex, '');
						gridTotalRecord = parseInt(gridTotalRecord);
						if(gridTotalRecord < gridQueryTotalRecord && querySend === false){
							let remRec = gridTotalRecord - currentRecord;
							if(remRec<=300){
								querySend = true;
								recordStart +=1000;
								loadTableWithNewData(true,true);
							}
						}
						console.log("Grid Record",gridTotalRecord);
						console.log("Current Record",currentRecord);
					}
				}
			}
			scrollTop = this.scrollTop;
			if(this.scrollLeft > 0){
				scrollLeft = this.scrollLeft;
			}
		});
	});
}
function findCompanyUsers(companyID,boxID) {
	if (w2ui.hasOwnProperty('subgrid-' + companyID)){w2ui['subgrid-' + companyID].destroy()};
	jQuery.ajax({
		url:__baseUrl+'opportunity/find_company_users',
		type:'POST',
		data:{c:companyID,p:0},
		dataType:'json',
		cache:false
	})
	.done(function(d){
		showUserList(companyID,boxID,d);
		w2ui.grid.set(companyID,{no_of_users:d.length});
	});
}
var expandSelectedList= [];
function updateUserList(companyID,l){
	/*update company counter*/
	w2ui.grid.set(companyID,{ no_of_users: l.length });	
	console.log("Update user list");
	if (w2ui.hasOwnProperty('subgrid-' + companyID)){
		/*w2ui['subgrid-' + companyID].destroy();
		showUserList(companyID,"grid_grid_rec_"+companyID+"_expanded_row",l);*/
		const getSelection = w2ui['subgrid-' + companyID].getSelection();
		expandSelectedList.push({companyID:companyID,list:getSelection});
		w2ui['subgrid-' + companyID].destroy();
		w2ui.grid.collapse(companyID);
		setTimeout(()=>{
			w2ui.grid.expand(companyID);
		},300);
	}	
}
function removeActive(co){
	if (w2ui.hasOwnProperty('subgrid-' + co)){
		const fUserTable = jQuery('#grid_subgrid-'+co+'_records');
		if(fUserTable.length > 0){
			fUserTable.find('td a.contact').removeClass("active");
		}
	}
}
function removeActiveContact(contactID){
	const highlightTR = document.querySelectorAll('tr[recid="'+contactID+'"]');
	if(highlightTR.length > 1){
		if(highlightTR[1].querySelector('a.contact') != null){
			highlightTR[1].querySelector('a.contact').setAttribute('class','contact');
		}		
	}
}
function highlight(o,c,co){
	removeActive(co);
	o.addClass('active');
}
function showUserList(companyID,boxID,usersList) {
	var gridHeight = 28;
	if(usersList.length > 0 ) {
		var calHeight = usersList.length * 21;
		if(usersList.length > 2 ) {
			calHeight += 50;
		} else if(usersList.length ==2 ) {
			calHeight += 32;
		} else if(usersList.length ==1 ) {
			calHeight += 31;
		}
		console.log("Cal:",calHeight);
		gridHeight = calHeight;
	}	
	gridHeight +="px"; 
	/*if(expandSelectedList.length > 0 && usersList.length > 0){
		console.log("Expand",expandSelectedList);
		expandSelectedList.forEach(function(c,u){
			if(c.companyID == companyID){
				let userList = c.list;
				console.log("ExpandUsers",userList);				
				if(userList.length > 0){
					let selected = 0;
					for(i=0;i<usersList.length;i++){
						selected = 0;
						if(userList.indexOf(usersList[i].id)>=0){
							selected = 1;
						}
						console.log("Selected",selected);
						usersList[i].selected = selected;
					}
					console.log("ExpandAUsers",usersList);	
				}				
				expandSelectedList.splice(u,1);
			}
		})
	}*/
	jQuery('#' + boxID).css({ margin: '0px', padding: '0px', width: '100%' }).animate({ height: gridHeight }, 100);
	jQuery('#grid_grid_frecords').find('tr[id="grid_grid_frec_'+companyID+'_expanded_row"]').find('div[id="grid_grid_frec_'+companyID+'_expanded"]').css("height",gridHeight);
	usersList.forEach(function(u,i){
		usersList[i]['proximity'] = parseInt(u.proximity);
		usersList[i]['c_c'] = parseInt(u.c_c);
	})
	console.log("ExpandAUsers",usersList);
	setTimeout(function () {
		jQuery('#' + boxID).w2grid({
			name: 'subgrid-' + companyID,
			show: { columnHeaders: true,selectColumn: true },
			multiSelect:true,
			columns: [
				{ field: 'id', text: '#', size: '100px',
					render:function(record) {
						var rowHTML = "";
						rowHTML += "<a href='javascript://' onclick='deleteContact("+record.id+","+record.company_id+")'><i class='fa fa-trash'></i> ";
						if(record.email!=""){
							rowHTML += "<a href='javascript://' onclick='openActivityBox("+record.company_id+","+record.id+")' style='margin-right:3px;'><i class='fa fa-envelope'></i></a>";
						}
						if(record.phone!="" ){
							rowHTML += "<a href='javascript://' onclick='openActivityBox("+record.company_id+","+record.id+")><i class='fa fa-phone'></i></a>";
						}
						if( record.telephone!=""){
							rowHTML += "<a href='javascript://' onclick='openActivityBox("+record.company_id+","+record.id+")><i class='fa fa-phone-square'></i></a>";
						}
						if(record.linkedin_url!=""){
							rowHTML += "<a href='"+record.linkedin_url+"' target='_blank'><i class='fa fa-linkedin'></i></a>";
						}
						if(record.gateway==1){
							rowHTML += "<i class='fa' style='margin-left:5px;'><img src='https://storage.googleapis.com/static.synpat.com/backyard/images/gateway-1.png'/></i> ";
						}
						if(record.no_contact=='1'){
							rowHTML += '&nbsp;&nbsp;<img src="'+__baseUrl+'public/images/no_contact.jpg"/>';
						}
						return rowHTML;
					}
				},
				{ field: 'name', text: 'Name', sortable: true, size: '150px',
					render: function(record) {
						return "<a href='javascript://' class='contact' onclick='highlight($(this),"+record.id+","+record.company_id+");window.parent.editContact("+record.id+")'>"+record.name+"</a>";
					}
				},
				{ field: 'proximity', text: 'C', type: 'int', sortable: true, size: '30px', attr: "align='center'"},
				{ field: 'c_c', text: 'CC', type: 'int', size: '50px', sortable: true, attr: "align='center'" },
				{ field: 'current_company', text: 'Current C', sortable: true, size: '200px', attr: "align='center'" },
				{ field: 'job_title', text: 'Title', sortable: true, size: '300px'}
			],
			recid: 'id',
			records: usersList,
			onClick: function(event) {
				console.log("Event",event);
				if(event.column === null && event.target != "") {
					/*var listSelected = w2ui[event.target].getSelection();
					if(listSelected.length > 0 ) {
						setTimeout(()=>{
							listSelected.map((d)=> {
								w2ui[event.target].select(parseInt(d));
							});
						},1);
					}*/
				} else {
					event.preventDefault();
				}
			},onRender: function(event){
				this.sort('c_c', 'desc');
				setTimeout(()=>{
					selectUsers(expandSelectedList,companyID);
				},1000);
			}
		});
		$.each(w2ui, function (index, value) {
			if (index.indexOf("_toolbar") === -1 && index !== "grid") {
				value.resize();
			}
		});
	}, 300);
}
function selectUsers(e,companyID){
	if(e.length > 0 ){
		console.log("Enteradad",e,companyID);
		e.forEach(function(c,index){
			if(c.companyID == companyID){
				const users = c.list;
				users.forEach(function(d){
					console.log("DD",parseInt(d),companyID);
					if (w2ui.hasOwnProperty('subgrid-' + thisID)){
						w2ui['subgrid-' + thisID].select(parseInt(d)); 
					} else {
						expandSelectedList.splice(index,1);
					}
				});
			}
		});
	}
}
function removeAllActiveCompanies(){
	jQuery("#grid_grid_records").find('tbody').find('tr').find('a.company').removeClass('active');
}
function openCompanyCard(companyID,o) {
	removeAllActiveCompanies();
	o.addClass('active');
	window.parent.openCompanyEdit(companyID);
}
function highlightsColumns() {
	var filterColList = [];			
	if(_filterInvited.length > 0) {
		filterColList.push(0);
	}
	if(_filterLabel.length > 0) {
		filterColList.push(4);
	}
	if(_filterUsers.length > 0) {
		filterColList.push(5);
	}
	if(_filterNoOfSize.length > 0) {
		filterColList.push(6);
	}
	if(_filterCompanySize.length > 0) {
		filterColList.push(7);
	}
	if(_filterCompanyIndustry.length > 0) {
		filterColList.push(8);
	}
	if(_filterSpecialties.length > 0) {
		filterColList.push(9);
	}
	if(_filterSector.length > 0) {
		filterColList.push(13);
	}
	if(_filterType.length > 0) {
		filterColList.push(14);
	}
	if(_filterSubType.length > 0) {
		filterColList.push(15);
	}
	if(_filterTechnology.length > 0) {
		filterColList.push(16);
	}
	if(_filterSubTech.length > 0) {
		filterColList.push(17);
	}
	
	if(filterColList.length > 0) {
		console.log("COLLIST",filterColList);
		var stringObject = "";
		filterColList.map(function(x) {
			stringObject +="#grid_grid_column_"+x+",";
		});
		stringObject = stringObject.substring(0,stringObject.length-1);

		if(stringObject != "") {
			setTimeout(function(){jQuery(stringObject).addClass("open");},500);
		}				
	}
}

var __baseUrl = '<?php echo $Layout->baseUrl?>';
var _leadID = '<?php echo $lead_id?>';
var _activity = '<?php echo $activity?>';
function searchCompany(){
	jQuery.ajax({
		url: __baseUrl+'opportunity/search_company_by_name_all',
		dataType: "json",
		data: { search:jQuery('#search_field').val() },
		success: function (data) {
			addDataToTable(data,false);
		}
	});
}
$(document).ready(function() {
	$('.filter,.filter-sort').off('click').on('click',function(){
		openFilterList(jQuery(this));
	});
	generate(); 
	loadTableWithNewData(true);	
	jQuery( "#btnCalendar" ).datepicker({
      showOn: "button",buttonText:"<a href='javascript://' class='btn btn-primary' style='width:auto;min-width:auto;height:auto;' title='Upload backup '><i class='fa fa-calendar'></i></a>",
        minDate: -15, maxDate: -1,
		dateFormat:'yymmdd',
		onSelect:function(dateText, inst){
			uploadBackupCompanyData(dateText);
		}
    });
	jQuery('#search_field').keypress(function (e) {
		var key = e.which;
		if(key == 13) {
			e.preventDefault();
			_unselectedCompanies=[];
			_selectedCompanies=[];
			jQuery("#recordsList").empty();
			_increment = 0;
			_scrollTable = true;
			jQuery('.ui-autocomplete').css('display','none');
			searchCompany();	
		}		  
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
	jQuery("#search_specialist").autocomplete({
		minLength: 2,
		source: function (request, response) {
			/*oldSelectedList.type = "specialties";
			oldSelectedList.list = [];
			oldSelectedList.eq = 10;*/
			if(_activity == "" || _activity == 0){
				_activity = jQuery("#profileListType").val();
			}
			_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,label:_filterLabel,specialist:_filterSpecialties,start:_startTag,end:_current,sort_field:_sortField,sort_by:_sortBy,t:true,ignore:oldSelectedList.type,tagSearch:request.term,invited:_filterInvited}
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'opportunity/get_filter_list/'+_leadID+'/'+_activity+'/ajax/50000',
				dataType: "json",
				data: _filters,
				success: function (data) {
					formatSpeciallist(data.data);
					response($.map(data.data, function (item) {
						return {
							label: item[oldSelectedList.type],
							value: item[oldSelectedList.type],
							realValue: item[oldSelectedList.type]
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
	jQuery("#search_specialist").on("keyup",function(){
		if(jQuery(this).val() == ""){
			jQuery(".filter_box").eq(5).find('.list_options').find('.list').html('');
		}
	});
	callNestable();
	checkBoxClickEvent();
	
});

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
function findContactsForThisCompany(ID){
	jQuery.ajax({
		url: __baseUrl+'opportunity/find_company_detail/'+_leadID+'/'+ID+'/'+_activity,
		dataType: "json",
		success: function (data) {
			_scrollTable = false;
			jQuery("#recordsList").empty();
			_fullHTML = "";
			_increment = 0;
			__totalRecords = data.length;
			addDataToTable(data,false);
		}
	});
}
function getAllCompanyToLead(t){	
	jQuery("#recordsList").empty();
	_increment = 0;
	_activity = 0;
	if(jQuery("#profileListType").val()){
		_activity = jQuery("#profileListType").val();
	}
	_unselectedCompanies=[];
	_selectedCompanies=[];
	if(t.val()==1){
		recordStart = 0;
		loadTableWithNewData(true);
	} else {
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/find_invites_company',
			data:{l:_leadID,a:_activity},
			dataType:'json',
			cache:false
		}).done(function(d){
			if(d.length>0){

				addDataToTable(d,true);
			}
		});
	}	
}
function addDataToTable(list) {
	message = "Loading...";
	setTimeout(function(){
		if(w2ui.hasOwnProperty('grid')){
			w2ui.grid.status(message);
		}
	},50);
	if(w2ui.hasOwnProperty('grid')){
		w2ui['grid'].destroy();
	}
	resizeGrid();
	records = [];
	list.map(function(u){
		var _selected = 0;
		if(_activity == 2){
			if(acquisitionCompanies.length > 0) {
				acquisitionCompanies.map(function(a){
					if(a.id == u.id){
						_selected = 1;
						return;
					}
				});
			}
		} else if(_activity == 1){
			if(salesCompanies.length > 0) {
				salesCompanies.map(function(s){
					if(s.id == u.id){
						_selected = 1;
						return;
					}
				});
			}
		} else {
			if(acquisitionCompanies.length > 0) {
				acquisitionCompanies.map(function(a){
					if(a.id == u.id){
						_selected = 1;
						return;
					}
				});
			}
			if(_selected == 0){
				if(salesCompanies.length > 0) {
					salesCompanies.map(function(s){
						if(s.id == u.id){
							_selected = 1;
							return;
						}
					});
				}
			}
		}
		object = {};
		object.id = u.id;
		object.recid = u.id;
		object.selected = _selected;
		object.company_name = u.company_name;
		object.no_of_users = u.company_users;
		object.sectors = u.sectorName;
		object.industry = u.industry;
		object.specialist = u.specialties;
		object.company_size = u.company_size;
		object.company_size_type = parseInt(u.company_size_type);
		object.no_of_employees = u.no_of_employees;
		object.label = u.label;
		object.scrape_people_again = u.scrape_people_again;
		object.categories = u.department_names;
		object.sub_category = u.sub_department_names;
		object.technology_names = u.technology_names;
		object.sub_technology_names = u.sub_technology_names;
		object.scrapped_date = u.scrapped_date;
		object.scrapped_profile_date = u.scrapped_profile_date;
		object.scrapped_profile_datetime = (u.scrapped_profile_date != '0000-00-00')? moment(new Date(u.scrapped_profile_date)).unix():0;
		object.linkedin_url = u.linkedin_url;
		object.create_date = u.create_date;
		records.push(object);
	});
	message = "";
	generate();
}
function checkedMe(o){
	_activity = jQuery('#profileListType').val();
	_checkEntry = false;
	if(_activity == 0){
		alert("Please select type first");
		o.prop("checked",false);
		o.removeAttr("checked");
	} else if(_leadID == 0){
		alert("Please select lead first");
		o.prop("checked",false);
		o.removeAttr("checked");
	} else {
		_targetBody = window.parent.findContainer();
		_companyID = o.val();
		_t = false;
		if(o.is(':checked')){
			_t = true;
		}
		inviteCompany(_companyID,_leadID,_t,_activity);
	}
	console.log("AC",_activity);
}
function pushSelectedCompany(_companyID,selected){
	var _parent = window.parent.findParent();
	var companyCard = _parent.jQuery("#open_company_add");
	if(companyCard.length > 0){
		var frame = companyCard.find("#companyIframe");
		if(frame.length > 0){
			var frameContent = frame.get(0).contentWindow;
			var competitors = frameContent.jQuery("#company_competitors");
			if(competitors.length > 0){
				var table = competitors.find("table");
				if(table.length > 0){
					var tr = table.find('tbody').find('tr');
					var findInput = tr.find('input[data-id="'+_companyID+'"]');
					if(findInput.length > 0){
						if(selected == 0){
							findInput.prop("checked",false);
						} else {
							findInput.prop("checked",true);
						}
					}
				}
			}
		}
	}
}
function inviteCompany(_companyID,_leadID,_t,_activity){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/invite_single_company',
		data:{company:_companyID,l:_leadID,t:_t,activity:_activity},
		cache:false,
		success:function(d){
			var _selected = 0;
			if(_t === true) {
				_selected = 1;
			}
			w2ui.grid.set(_companyID,{selected:_selected});
			console.log('Records',_companyID,_selected,w2ui.grid.records);
			pushSelectedCompany(_companyID,_selected);
			if(_activity==1){
				/*Sales */
				if(_selected == 1){
					var objCompany = {id:_companyID,company_name:''};
					salesCompanies.push(objCompany);
				} else {
					salesCompanies.map(function(i,n){
						if(i.id === _companyID){
							salesCompanies.splice(n,1);
							return false;
						}
					});
				}
				if(window.parent.jQuery("#salesActivityButton").hasClass('menu-active')){
					window.parent.callingOrder(2);
				}
			} else if(_activity==2){
				/*Acquisition */ 
				if(_selected == 1){
					var objCompany = {id:_companyID,company_name:''};
					acquisitionCompanies.push(objCompany);
				} else {
					acquisitionCompanies.map(function(i,n){
						if(i.id === _companyID){
							acquisitionCompanies.splice(n,1);
							return false;
						}
					});
				}
				if(window.parent.jQuery("#acquisitionActivityButton").hasClass('menu-active')){
					window.parent.callingOrder(1);
				}
			}
			if(window.parent.jQuery("#btnFormCollapse").hasClass('menu-active')){
				/*Lead form data */
				window.parent.callingOrder(0);
			}
		}
	});
}

function updateTableRowData(d) {
	console.log("CompanyList updateTableRowData",d);
	_date = moment(new Date(d.scrapped_profile_date)).format('YY-MM-DD');
	const obj = {company_name:d.company_name,scrape_date:_date,scrape_profile_date:_date,no_of_employees:d.no_of_employees,company_size:d.company_size,company_size_type:parseInt(d.company_size_type),industry:d.industry,specialist:d.specialties,scrapped_profile_datetime: (d.scrapped_profile_date != '0000-00-00')? moment(new Date(d.scrapped_profile_date)).unix():0};
	if(typeof d.company_users != "undefined" && d.company_users.length > 0){
		obj.no_of_users = d.company_users.length;
	} else if(typeof d.companyUsers != "undefined" && d.companyUsers.length > 0){
		obj.no_of_users = d.companyUsers.length;
	} else if(typeof d.count_users != "undefined"){
		obj.no_of_users = d.count_users;
	}
	if(typeof d.scrape_people_again != "undefined"){
		obj.scrape_people_again = d.scrape_people_again;
	}
	console.log("CompanyList updateTableRowData1",obj);
	w2ui.grid.set(d.id,obj);
	w2ui.grid.unselect(d.id);
}

function scrapeAllSelectedList(t){
	var getSelectedCompanies = w2ui.grid.getSelection();
	if(getSelectedCompanies.length > 0) {
		jQuery.ajax({
			url:__baseUrl+'opportunity/findAllCompaniesUsers',
			type:'POST',
			data:{c:JSON.stringify(getSelectedCompanies),t:1,p:0,s:1,request_type:t},
			dataType:'json',
			success:function(d){
				if(t == "Company") {
					if(d.co.length>0){
						checkQueue(0,t);
					}
				} else if(t == "User") {
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
				if(type == 'Company') {
					window.parent.sendCompanyScrapperRequest();
				}else if(type == 'User') {
					window.parent.sendContactScrapperRequest();
				}else if(type == 'FindPeople'){
					window.parent.sendCompanyPeopleRequest();
				}
			} else {
				if(type == 'Company') {
					window.parent.checkQueue();
				} else if(type == 'User') {
					window.parent.checkContactsQueue();
				} else if(type == 'FindPeople') {
					window.parent.checkCompanyPeopleQueue();
				}
			}
		}
	})
}
function emailScrapeAllSelectedCompanies(){
	var getSelectedCompanies = w2ui.grid.getSelection();
	if(getSelectedCompanies.length > 0) {
		let contactList = [];
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'users/run_email_scrapper',
			cache:false,
			data:{contacts:contactList,company_list:getSelectedCompanies,d:'http://webdriverforscrape.site/find_emails_scrapper.php'}
		}).done(function(d){
			console.log(d);
		});
		/*jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/emailScrapeSelectedCompanies',
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
var _updateAll = true;
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
function deleteSelectedContacts(){
	let selectedAllContacts = []; 
	let selectedAllCompanies = []; 
	var gridRecords = jQuery("#grid_grid_records");
	if(gridRecords.find('tr.w2ui-expanded-row').length > 0) {
		gridRecords.find('tr.w2ui-expanded-row').each(function(){
			var thisID = jQuery(this).attr('id');
			thisID = thisID.replace("grid_grid_rec_","");
			thisID = thisID.replace("_expanded_row","");
			try{
				if(parseInt(thisID) > 0) {
					let gName = 'subgrid-' + thisID;
					if (w2ui.hasOwnProperty('subgrid-' + thisID)){
						selectedAllCompanies.push(thisID);
						let selectedContacts = w2ui[gName].getSelection();
						if(selectedContacts.length > 0){
							selectedAllContacts = selectedAllContacts.concat(selectedContacts);
						}
					}
				}
			}catch(e){
				
			}
		});
	}
	if(selectedAllContacts.length > 0){
		var conf = confirm("Delete "+selectedAllContacts.length+" contacts?");
		if(conf){
			const contactsDeleted = deleteContactList(selectedAllContacts);
			contactsDeleted.done(function(d){
				if(d=='-1'){
					alert("Some correspondense with selected contacts.");
				} else {
					jQuery.ajax({
						url:__baseUrl+'opportunity/findContactsForSelectedCompanies',
						type:'POST',
						data:{c:selectedAllCompanies},
						dataType:'json'
					}).done(function(c){
						if(c.length > 0){
							c.forEach(function(company){
								updateCompanyUsers(company.company_id,company.countUsers);
							});
						} else {
							selectedAllCompanies.forEach(function(company){
								updateCompanyUsers(company,0);
							});
						}
					});
				}
			});
		}
	}
}
function updateCompanyUsers(companyID,countUsers){
	/*update company counter*/
	w2ui.grid.set(companyID,{ no_of_users: countUsers });	
	console.log("Update compant user counter");
	if (w2ui.hasOwnProperty('subgrid-' + companyID)){
		/*w2ui['subgrid-' + companyID].destroy();
		showUserList(companyID,"grid_grid_rec_"+companyID+"_expanded_row",l);*/
		w2ui['subgrid-' + companyID].destroy();
		w2ui.grid.collapse(companyID);
		if(countUsers > 0){
			setTimeout(()=>{
				w2ui.grid.expand(companyID);
			},300);
		}		
	}
}
function deleteSelectedCompanies(){
	var getSelectedCompanies = w2ui.grid.getSelection();
	if(getSelectedCompanies.length > 0) {
		var conf = confirm("Delete "+formatter.format(getSelectedCompanies.length)+" companies?");
		if(conf){
			let url = __baseUrl+'opportunity/deleteBulkCompanyList';
			jQuery.ajax({
				type:'POST',
				url:url,
				data:{delete_link:getSelectedCompanies},
			})
			.done(function(d){
				if(d != "") {
					w2ui.grid.select(getSelectedCompanies.join(','));
					w2ui.grid.delete(true);
				}
			});
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

			updateCategorySectorArea();
		})
		.fail(function() {  })
		.always(function() {  });
	}
};
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

	o.parent().parent().find('input[type="text"]').val("");
	o.parent().parent().find('textarea').val("");
	o.parents('.nested-list-content').css('min-height','');
	o.parent().parent().find('.span-edit').hide();
	o.parent().parent().find('.span-show').show();
	o.parent().parent().find('.span-wait').hide();
	_id = o.parent().parent().parent().attr('id');

	if(_id!="ChildT" && _id!="Child"){
		o.parent().parent().parent().hide();	
	}	
}
function addSaveMe(o){ 

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
		_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,label:_filterLabel,specialist:_filterSpecialties,start:0,end:0,sort_field:_sortField,sort_by:_sortBy};
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
		_filters = {search:jQuery('#search_field').val(),s:_filterSector,sc:_filterType,sst:_filterSubType,stt:_filterTechnology,st:_filterSubTech,u:_filterUsers,filterLinkedIn:_filterLinkedIn,industry:_filterCompanyIndustry,company_size:_filterCompanySize,no_of_size:_filterNoOfSize,label:_filterLabel,specialist:_filterSpecialties,start:0,end:0,sort_field:_sortField,sort_by:_sortBy};
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
				jQuery("#recordsList").empty();
				_increment = 0;
				recordStart = 0;
				loadTableWithNewData(true);
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
function uploadBackupCompanyData(backupDate){
	let cnfrm = confirm("Are your sure you want to upload "+backupDate+" database backup?");
	if(cnfrm){
		jQuery.ajax({
			url:__baseUrl+'opportunity/uploadBackupFile',
			type:'POST',
			data:{table:'company',backup_date:backupDate},
			cache:false
		}).done(function(response){
			alert(response);
			window.location = window.location.href;
		});
	}
}
function resizeGrid(){
	jQuery("#grid").css("height",(jQuery(window).height() - 40)+'px');
}
function findEmptyCompanies(){
	/*if(_leadID > 0){
		window.parent.findCompaniesPeople(_leadID);
	} else {
		alert("Please select lead first.");
	}*/
	const getSelectedCompanies = w2ui.grid.getSelection();
	if(getSelectedCompanies.length > 0) {
		destroyEditor();
		_sendRequest = false;
		jQuery("#title_query_modal").find("#query_title").val(title);
		jQuery("#title_query_modal").find("#query_keywords").val(keyword);
		callEditor();
		callTitleType();
		jQuery("#title_query_modal").modal("show");		
	} else {
		alert("Please select companies first.");
	}
}
function searchCompanyPeople(t){
	const getSelectedCompanies = w2ui.grid.getSelection();
	let title = [];
	let keyword = [];
	if(t == 1){
		title.push(jQuery("#query_title").val());
	} else {
		jQuery("#title_query_modal").find(".expression").each(function(){
			let $this = jQuery(this);
			let textTitle = $this.parent().find('textarea.title');
			if(textTitle.length > 0){
				keyword.push(textTitle.val());
			} else {
				keyword.push("");
			}
			if($this.val() != ""){
				title.push($this.val());
			}
		});
	}
	jQuery.ajax({
		url:__baseUrl+'opportunity/findPeopleFromLinkedIn',
		type:'POST',
		data:{c:getSelectedCompanies,title:title,keyword:keyword,t:t},
		dataType:'json',
		success:function(d){
			if(d.list.length > 0 || d.a == 1){
				jQuery("#title_query_modal").modal("hide");		
				checkQueue(3,"FindPeople");
			}
		}
	});
}
jQuery(window).resize(function(){
	resizeGrid();
});
jQuery(document).ready(function(){
	const body = document.getElementsByTagName('body');
	body[0].addEventListener('click',function(e) {
		const _getTarget = $(e.target);
		console.log("_getTarget",_getTarget);
		console.log("_getTarget",e);
		if(_getTarget.length > 0) {
			if(jQuery('.filter_box').hasClass('n')) {
				console.log("FOUND");
				if((_getTarget[0].nodeName == "DIV" || _getTarget[0].id == "search_field" || _getTarget[0].id == "pagination_alpha" || _getTarget[0].id == "profileListType" || _getTarget[0].id == "profileLead" || _getTarget[0].className == "company") && _getTarget[0].className != "list" && _getTarget[0].className != "pull-left fpo") {
					console.log("CLICKED");
					var getIndex = jQuery('#search_panel').children('.filter_box.n').index();
					jQuery('.filter_box').eq(getIndex).find('.btnCancel').trigger('click');
				}
			} 
		}
	});
	if(scraper == false){
		callEditor();	
	}	
});
function destroyEditor(){
	CKEDITOR.instances.query_keywords.destroy();
}
function callEditor(){
	CKEDITOR.inline( 'query_keywords',{
		width: '100%',
		height: 300
	}).on('change',function(evt ){
		saveTextData();
	});
}
function callTitleType(){
	jQuery('#query_title').typing({
		delay:1000,
		start:function(){
			console.log("typing");
		},
		stop:function(){
			_sendRequest = false;
			saveTextData();
		}
	});
	jQuery('.expression').typing({
		delay:1000,
		start:function(){
			console.log("typing");
		},
		stop:function(){
			_sendRequestExpression = false;
			saveExpressionTextData();
		}
	});
	jQuery('.title').typing({
		delay:1000,
		start:function(){
			console.log("typing");
		},
		stop:function(){
			_sendRequestExpression = false;
			saveExpressionTextData();
		}
	});
	jQuery("#max_numbers").typing({
		delay:1000,
		start:function(){
			console.log("typing");
		},
		stop:function(){
			_sendRequestExpression = false;
			updateMaxScrapeNumbers();
		}
	});
}
let _sendRequest = false,_sendRequestExpression = false,_cs,_cq;
function updateMaxScrapeNumbers(){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'leads/update_maximum_scrape_users',
		data:{scrape_numbers:jQuery("#max_numbers").val()},
		cache:false,
		success:function(data){
			console.log("updateMaxScrapeNumbers",data);
		}
	});
}
function saveExpressionTextData(){
	if(_sendRequestExpression===false){
		_sendRequestExpression = true;
		let expressionData = [];
		jQuery("#title_query_modal").find('.expression').each(function(){
			const $this = jQuery(this);
			if($this.attr('data-id') > 0){
				let title = "";
				let textareaTitle = $this.parent().find('textarea.title');
				if(textareaTitle.length > 0){
					title = textareaTitle.val();
				}
				expressionData.push({id:$this.attr('data-id'),keyword:$this.val(),title:title});
			}
			
		});
		if(expressionData.length > 0){
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'leads/update_expression_query',
				data:{e:expressionData},
				cache:false,
				success:function(data){
					_sendRequestExpression = false;
				}
			});
		}
		if(CKEDITOR.instances['query_keywords'].getData() != keyword || jQuery("#query_title").val() != title){
			keyword = CKEDITOR.instances['query_keywords'].getData();
			title = jQuery("#query_title").val();
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'leads/save_linkedin_query',
				data:{title:title,keyword:keyword},
				cache:false,
				success:function(data){
					_sendRequestExpression = false;
				}
			});
		} else {
			clearInterval(_cq);
			_sendRequestExpression = false;
		}		
	} else {
		_cq = setInterval(function(){
			if(_sendRequest===false){
				clearInterval(_cq);
				saveExpressionTextData();
			}
		},1000);
	}										
}
function saveTextData(){
	if(_sendRequest===false){
		_sendRequest = true;
		if(CKEDITOR.instances['query_keywords'].getData() != keyword || jQuery("#query_title").val() != title){
			keyword = CKEDITOR.instances['query_keywords'].getData();
			title = jQuery("#query_title").val();
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'leads/save_linkedin_query',
				data:{title:title,keyword:keyword},
				cache:false,
				success:function(data){
					_sendRequest = false;
				}
			});
		} else {
			clearInterval(_cs);
			_sendRequest = false;
		}		
	} else {
		_cs = setInterval(function(){
			if(_sendRequest===false){
				clearInterval(_cs);
				saveTextData();
			}
		},1000);
	}										
}

function saveTextData(){
	if(_sendRequest===false){
		_sendRequest = true;
		if(CKEDITOR.instances['query_keywords'].getData() != keyword || jQuery("#query_title").val() != title){
			keyword = CKEDITOR.instances['query_keywords'].getData();
			title = jQuery("#query_title").val();
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'leads/save_linkedin_query',
				data:{title:title,keyword:keyword},
				cache:false,
				success:function(data){
					_sendRequest = false;
				}
			});
		} else {
			clearInterval(_cs);
			_sendRequest = false;
		}		
	} else {
		_cs = setInterval(function(){
			if(_sendRequest===false){
				clearInterval(_cs);
				saveTextData();
			}
		},1000);
	}										
}
</script>
