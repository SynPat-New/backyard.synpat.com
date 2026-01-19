<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>nestable.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl;?>public/widgets/modal/modal.css"/>
<link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css" />
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/menu.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/autocomplete.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>jquery.nestable.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/modal/modal.js"></script>
<script type="text/javascript" src="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.js"></script>
<script src="https://synpat.com/docket-services/techdd/ckeditor/ckeditor.js"></script> 
	<script src="https://storage.googleapis.com/static.synpat.com/backyard/widgets/typing/typing.min.js"></script>
<style>
	body {
		overflow: auto !important;overflow-x:hidden !important;
		min-width: 0;
		width: 100% !important;font-size:13px;font-family:arial;margin:0px;
	}
	ul{list-style:none;}
	#companyLinkedinUrl,#companyWebAddress,#companyOwlerUrl{cursor:pointer !important;color:#56b2fe !important;}
	.ui-menu-item{list-style:none;padding:10px;border:1px solid #56b2fe;margin-bottom:3px;}
	.ui-menu-item:hover{background-color:#56b2fe;color:#fff;}	
	.ui-helper-hidden-accessible{display:none;}
	.ui-autocomplete {
	padding:0px;margin:0px;
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;width:300px !important;background:#fff;
  }
  .show_name {padding-top: 8px;padding-left: 5px;}
  .w2ui-reset table tr th, .w2ui-reset table tr td,.open_list, .open_list li, .open_list li span{font-family:arial;font-size:13px;}
  	.expression{width:98%;height:40px;}
	.width50{width:50% !important;}
	.width45{width:45% !important;height:40px;}
	.pullRight{float:right;}
	a.contact.active{font-weight:bold}
	.RedBold td.w2ui-grid-data div{font-weight:bold;color:red;}
	</style>
<?php 
	$company_name = "";
	$web_address = "";
	$state = "";
	$city = "";
	$company_name_alias = "";
	$postal_code = "";
	$telephone = "";
	$email = "";
	$contractor = "";
	$broker = 0;
	$parentID = 0;
	$broker_details = array();
	$company_address = "";
	$linkedin_url = "";
	$country = "";
	$departments_list = array();
	$categories = array();
	$subdepartments_list = array();
	$sub_categories = array();
	$brokerFirm="";
	$brokerName="";
	$describing="";
	$industry = "";
	$specialties = "";
	$noOfEmployees = "";
	$parentName = "";
	$companyLogo = "";
	$similarOrganization = array();
	$id = $companyID;
	$companyUsers = array();
	$htsCode = array();
	$companySize="";
	$peopleAlsoViewed = "";
	$other1="";
	$other2="";
	$other3="";
	$other4="";
	$other5="";
	$other6="";
	$companyType="";
	$companyRevenue = "";
	$companyOwlerDescription = "";
	$companyCompetitors   = "";
	$owlerUrl   = "";
	$subsidiary  = "";
	if(count($company)>0){
		$company_name = $company->company_name;
		$companyType = $company->company_type;
		$parentName = $company->parentName;
		$parentID = $company->parent_c;
		$company_name = preg_replace('/"/','',$company_name);
		$web_address = $company->web_address;
		$state = $company->state;
		$city = $company->city;
		$email = $company->email;
		$owlerUrl = $company->owler_url;
		$subsidiary = $company->subsidiary;
		$companyRevenue = $company->owler_company_revenue;
		$companyOwlerDescription = $company->owler_description;
		$companyCompetitors = $company->competitors;
		$company_name_alias = $company->company_name_alias;
		$postal_code = $company->postal_code;
		$telephone = $company->telephone;
		$contractor = $company->contractor;
		$broker = $company->broker;
		$broker_details = $company->broker_details;
		if(count($broker_details)>0){
			$brokerFirm = $broker_details->company_name;
			$brokerName = $broker_details->first_name." ".$broker_details->last_name;
		}
		$company_address = $company->company_address;
		$linkedin_url = $company->linkedin_url;
		$peopleAlsoViewed = $company->similar_organisation;
		if($state!=""){
			$country = $state;
		} else {
			$country = $company->country;
		}
		$codeList = $company->hts_code;
		if($codeList != "" && $codeList != null){
			$codeList = json_decode($codeList);
		}
		$categories = $company->categories;
		$departments_list = $company->departments_list;
		$subdepartments_list = $company->subdepartments_list;
		$sub_categories = $company->sub_categories;
		$companyUsers = $company->companyUsers;
		$describing = $company->describing;
		$industry = $company->industry;
		$specialties = $company->specialties;
		$noOfEmployees = number_format($company->no_of_employees);
		$companySize = $company->company_size;
		$companyLogo = $company->company_logo;
		$similarOrganization = $company->list;
		
		$other1 = $company->other1;
		$other2 = $company->other2;
		$other3 = $company->other3;
		$other4 = $company->other4;
		$other5 = $company->other5;
		$other6 = $company->other6;
	}
?>

<style>
table.dataTable thead th, table.dataTable tfoot th{font-weight:normal;}
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
.hide{display:none;}
.show{display:block;}
.show-inline{display:inline-block;}
.modal-dialog{width:300px;}
.subsidiary{display:inline-block;height:23px;margin-left:5px;}
.subsidiary a{font-size:13px !important;text-decoration:none;}
#upload_c_file {
  display: none;
}
span.invite{height:19px;display:block;}
</style>
<div id="title_query_modal" data-backdrop="static" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:90%;">
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
										/*if($i==7 || $i == 8):*/
									?>
									<textarea id="title<?php echo $i;?>" name="title<?php echo $i;?>" placeholder="Keyword <?php echo $i;?>" class="title width45" data-id="<?php echo $e->id;?>"><?php echo $e->title;?></textarea>
									<?php
										/*endif;*/
									?>
									<textarea id="expression<?php echo $i;?>" placeholder="Expression <?php echo $i;?>" name="expression<?php echo $i;?>" class="expression <?php echo ($i==7 || $i == 8)?' width50 pullRight':'width50 pullRight';?>" data-id="<?php echo $e->id?>"><?php echo $e->keyword?></textarea>
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
<?php echo form_open('opportunity/add_company/'.$companyID,array('class'=>"form-flat",'id'=>'ccompanyFormSubmit', 'style'=>'margin-left:2px; margin-right:0px;','enctype'=>'multipart/form-data'));?>
<input type="hidden" name="company[state]" id="companyState" class="form-control" placeholder="" value="<?php echo $state?>"/>
<input type="hidden" name="company[parent_c]" id="companyParent" class="form-control" placeholder="" value="<?php echo $parentID;?>"/>
<input type="hidden" name="company[other1]" id="companyOther1" value="<?php echo $other1?>" class="form-control" placeholder="" style="width:50px"/>
<input type="hidden" name="company[other2]" id="companyOther2" value="<?php echo $other2?>" class="form-control" placeholder="" style="width:141px"/>
<input type="hidden" name="company[other3]" id="companyOther3" value="<?php echo $other3?>" class="form-control" placeholder="" style="width:141px"/>
<input type="hidden" name="company[other4]" id="companyOther4" value="<?php echo $other4?>" class="form-control" placeholder="" style="width:141px"/>
<input type="hidden" name="company[other5]" id="companyOther5" value="<?php echo $other5?>" class="form-control" placeholder="" style="width:141px"/>
<input type="hidden" name="company[other6]" id="companyOther6" value="<?php echo $other6?>" class="form-control" placeholder="" style="width:141px"/>
<div class="row">
	<div class="col-xs-10" style="width:80%;padding:0px;">	
		<div class="col-xs-12">
			<button type="submit" id="buttonADDCCompany" class="btn btn-primary " title="Save"><i class="fa fa-save"></i></button>
			<!--<button type="button" onclick="linkedInSearch();" id="btnManageCategories" class="btn btn-primary " title="Linkedin Search"><i class="fa fa-linkedin"></i></button>	-->
			<button type="button" onclick="openAddContact()" id="" class="btn btn-primary" title="Add User"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="user-plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width:20px;" class="svg-inline--fa fa-user-plus fa-w-20 fa-2x"><path fill="currentColor" d="M224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96zm89.6 256c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zm224-248h-72v-72c0-8.8-7.2-16-16-16h-16c-8.8 0-16 7.2-16 16v72h-72c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h72v72c0 8.8 7.2 16 16 16h16c8.8 0 16-7.2 16-16v-72h72c8.8 0 16-7.2 16-16v-16c0-8.8-7.2-16-16-16z" class=""></path></svg></button>
			<button type="button" onclick="scrapeCompany();" id="" class="btn btn-primary"><i class="fa fa-linkedin-square" title="Scrape Company"></i></button>
			<a href='javascript://' onclick="findPeopleFromLinkedin()" class='btn btn-primary' title="Find Company People" style='width:auto;min-width:auto;height:auto;'><i class="fa fa-user-circle-o"  style='margin-left:0px;'></i></a>
			<button type="button" onclick="addCompanyToPingpong();" id="" title="Add company to pingpong" class="btn btn-primary"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="earlybirds" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 480 512" style="width:20px;" class="svg-inline--fa fa-earlybirds fa-w-15 fa-2x"><path fill="currentColor" d="M313.2 47.5c1.2-13 21.3-14 36.6-8.7.9.3 26.2 9.7 19 15.2-27.9-7.4-56.4 18.2-55.6-6.5zm-201 6.9c30.7-8.1 62 20 61.1-7.1-1.3-14.2-23.4-15.3-40.2-9.6-1 .3-28.7 10.5-20.9 16.7zM319.4 160c-8.8 0-16 7.2-16 16s7.2 16 16 16 16-7.2 16-16-7.2-16-16-16zm-159.7 0c-8.8 0-16 7.2-16 16s7.2 16 16 16 16-7.2 16-16-7.2-16-16-16zm318.5 163.2c-9.9 24-40.7 11-63.9-1.2-13.5 69.1-58.1 111.4-126.3 124.2.3.9-2-.1 24 1 33.6 1.4 63.8-3.1 97.4-8-19.8-13.8-11.4-37.1-9.8-38.1 1.4-.9 14.7 1.7 21.6 11.5 8.6-12.5 28.4-14.8 30.2-13.6 1.6 1.1 6.6 20.9-6.9 34.6 4.7-.9 8.2-1.6 9.8-2.1 2.6-.8 17.7 11.3 3.1 13.3-14.3 2.3-22.6 5.1-47.1 10.8-45.9 10.7-85.9 11.8-117.7 12.8l1 11.6c3.8 18.1-23.4 24.3-27.6 6.2.8 17.9-27.1 21.8-28.4-1l-.5 5.3c-.7 18.4-28.4 17.9-28.3-.6-7.5 13.5-28.1 6.8-26.4-8.5l1.2-12.4c-36.7.9-59.7 3.1-61.8 3.1-20.9 0-20.9-31.6 0-31.6 2.4 0 27.7 1.3 63.2 2.8-61.1-15.5-103.7-55-114.9-118.2-25 12.8-57.5 26.8-68.2.8-10.5-25.4 21.5-42.6 66.8-73.4.7-6.6 1.6-13.3 2.7-19.8-14.4-19.6-11.6-36.3-16.1-60.4-16.8 2.4-23.2-9.1-23.6-23.1.3-7.3 2.1-14.9 2.4-15.4 1.1-1.8 10.1-2 12.7-2.6 6-31.7 50.6-33.2 90.9-34.5 19.7-21.8 45.2-41.5 80.9-48.3C203.3 29 215.2 8.5 216.2 8c1.7-.8 21.2 4.3 26.3 23.2 5.2-8.8 18.3-11.4 19.6-10.7 1.1.6 6.4 15-4.9 25.9 40.3 3.5 72.2 24.7 96 50.7 36.1 1.5 71.8 5.9 77.1 34 2.7.6 11.6.8 12.7 2.6.3.5 2.1 8.1 2.4 15.4-.5 13.9-6.8 25.4-23.6 23.1-3.2 17.3-2.7 32.9-8.7 47.7 2.4 11.7 4 23.8 4.8 36.4 37 25.4 70.3 42.5 60.3 66.9zM207.4 159.9c.9-44-37.9-42.2-78.6-40.3-21.7 1-38.9 1.9-45.5 13.9-11.4 20.9 5.9 92.9 23.2 101.2 9.8 4.7 73.4 7.9 86.3-7.1 8.2-9.4 15-49.4 14.6-67.7zm52 58.3c-4.3-12.4-6-30.1-15.3-32.7-2-.5-9-.5-11 0-10 2.8-10.8 22.1-17 37.2 15.4 0 19.3 9.7 23.7 9.7 4.3 0 6.3-11.3 19.6-14.2zm135.7-84.7c-6.6-12.1-24.8-12.9-46.5-13.9-40.2-1.9-78.2-3.8-77.3 40.3-.5 18.3 5 58.3 13.2 67.8 13 14.9 76.6 11.8 86.3 7.1 15.8-7.6 36.5-78.9 24.3-101.3z" class=""></path></svg></button>
			<button type="button" onclick="openClasify();" id="" class="btn btn-primary " title="Classification"><svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="folder-tree" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="width:20px;" class="svg-inline--fa fa-folder-tree fa-w-18 fa-2x"><path fill="currentColor" d="M288 224h224a32 32 0 0 0 32-32V64a32 32 0 0 0-32-32H400L368 0h-80a32 32 0 0 0-32 32v72H80V16A16 16 0 0 0 64 0H48a16 16 0 0 0-16 16v392a32 32 0 0 0 32 32h192v40a32 32 0 0 0 32 32h224a32 32 0 0 0 32-32V352a32 32 0 0 0-32-32H400l-32-32h-80a32 32 0 0 0-32 32v72H80V152h176v40a32 32 0 0 0 32 32zm16-176h44.12l32 32H496v96H304zm0 288h44.12l32 32H496v96H304z" class=""></path></svg></button>
			<button type="button" onclick="deleteCompany(<?php echo $companyID?>);" id="" class="btn btn-primary " title="Delete"><i class="fa fa-trash"></i></button>
			<button type="button" class="btn btn-primary file_upload" onclick="browseFile();" title="Upload file">
				<i class="fa fa-image"></i>
			</button>
			<button type="button" class="btn btn-primary" onclick="uploadByImageUrl()" title="Upload by image Url"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cloud-download-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width:20px;" class="svg-inline--fa fa-cloud-download-alt fa-w-18 fa-2x"><path fill="currentColor" d="M537.6 226.6c4.1-10.7 6.4-22.4 6.4-34.6 0-53-43-96-96-96-19.7 0-38.1 6-53.3 16.2C367 64.2 315.3 32 256 32c-88.4 0-160 71.6-160 160 0 2.7.1 5.4.2 8.1C40.2 219.8 0 273.2 0 336c0 79.5 64.5 144 144 144h368c70.7 0 128-57.3 128-128 0-61.9-44-113.6-102.4-125.4zm-132.9 88.7L299.3 420.7c-6.2 6.2-16.4 6.2-22.6 0L171.3 315.3c-10.1-10.1-2.9-27.3 11.3-27.3H248V176c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v112h65.4c14.2 0 21.4 17.2 11.3 27.3z" class=""></path></svg></button>
			<input type="file" name="upload_c_file" id="upload_c_file"/>
			<input type="text" name="image_url" id="image_url" class="hide form-control" style="width:150px;" placeholder="Image url"/>
			<span id="loading_message"></span>
		</div>
		<div class="col-xs-12">
			<div class="row"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label"><a href="javascript://" onclick="getListOfOtherNames();">Company Name</a>:</label> <input type="text" name="company[company_name]" id="companyJobTitle" value="<?php echo $company_name?>" class="form-control" placeholder="" style='width:45%;'/> </div> </div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Short version for mail:</label> <input type="text" name="company[company_name_alias]" id="companyCompanyNameAlias" class="form-control" placeholder="" value="<?php echo $company_name_alias?>" style='width:26%;'/><input type="hidden" name="company[postal_code]" id="companyZip" class="form-control" placeholder="" value="<?php echo $postal_code?>"/> </div> </div> 
			<div class="col-xs-12"> <div class="form-group input-string-group"> <label class="control-label">Subsidiary of:</label><span class="subsidiary"> <?php echo $subsidiary;?></span> </div> </div>
			</div>
		</div>
		<div class="col-xs-12"> 
			<div class="row">
				<div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Parent Search:</label> <input type="text" name="companyParentSearch" id="companyParentSearch" class="form-control" placeholder="" value="" style="width:100px;"/> </div> </div>
				<div class="col-xs-5"> <div class="form-group input-string-group"> <label class="control-label">Parent:</label> <span class='show_name' style='display:inline-block;height:17px;'><?php if($parentID>0):?><strong><a href='javascript://' onclick="window.parent.openCompanyEdit(<?php echo $parentID;?>);"><?php echo $parentName;?></a></strong><?php endif;?> </div>  </div>
				<div class="col-xs-1"><a href='javascript://' onclick="resetParent(<?php echo $companyID?>);" style='position:absolute;top:12px;'><i class="fa fa-trash"></i></a></div> 
			</div>
		</div>
	</div>
	<div class="col-xs-2" id="companyLogo" style='text-align:center;width:20%;padding:0px;'>
		<?php 
			if($companyLogo!=""){
		?>
			<img src="<?php echo $companyLogo?>"/>
		<?php
			}
		?>
	</div>
	
	
</div>
<div class="row"> <div class="col-xs-12" style='width:98%;padding:0px;'>   
 
 
 <div class="row"> 
 <div class="col-xs-12">
	<div class="row"> 
		<div class="col-xs-5"> <div class="form-group input-string-group"> <label class="control-label">Web address:</label> <input type="text" name="company[web_address]" id="companyWebAddress" class="form-control" placeholder="" value="<?php echo $web_address?>" style='width:100px;'/> </div> </div>
		<div class="col-xs-3"> <div class="form-group input-string-group"> <label class="control-label">Revenue:</label> <input type="text" name="company[owler_company_revenue]" id="companyOwlerCompanyRevenue" class="form-control" placeholder="" value="<?php echo $companyRevenue?>" style='width:50px;'/> </div> </div>
		<div class="col-xs-4"> <div class="form-group input-string-group"> <label class="control-label">Owler:</label> <input type="text" name="company[owler_url]" id="companyOwlerUrl" class="form-control" placeholder="" value="<?php echo $owlerUrl?>" style='width:100px;'/> </div> </div>
	</div>
</div>
 <div class="col-xs-12"><div class="col-xs-6"><div class='col-xs-5'> <div class="form-group input-string-group"> <label class="control-label">Size:</label> <input type="text" name="company[company_size]" id="companySize" value="<?php echo $companySize;?>" class="form-control" style='width:100px;'/> </div></div><div class='col-xs-7'><div class="form-group input-string-group"> <label class="control-label">On LinkedIN:</label> <input type="text" name="company[no_of_employees]" class="form-control" id="companyNoOfEmployees" value="<?php echo $noOfEmployees;?>" style='width:100px;'/> </div></div> </div>  <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">LinkedIn:</label> <input type="text" name="company[linkedin_url]" id="companyLinkedinUrl" class="form-control" placeholder="" value="<?php echo $linkedin_url?>" style='width:100px;'/> </div> </div> </div> </div> 
 <div class="row"> <div class="col-xs-6"><div class='col-xs-5'> <div class="form-group input-string-group" style="margin:0px;"> <label class="control-label">Contractor:</label> <input type="checkbox" name="company[contractor]" id="companyContractor" value="1" style="text-align: left;margin:10px 0 0 5px;"/> </div></div><div class='col-xs-7'> <div class="form-group input-string-group" style="margin:0px;"> <label class="control-label">Type:</label> <input type="text" name="company[company_type]" id="companyType" class="form-control" value="<?php echo $companyType;?>" style='width:100px;'/> </div></div></div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label"><a href='javascript://' onclick='if(typeof window.parent.openCompanyBrokerFirm=="function"){window.parent.openCompanyBrokerFirm();} else {window.parent.parent.openCompanyBrokerFirm();}'>Broker:</a></label><input type="text"  id="companyBrokerName" class="form-control" placeholder="" value="<?php echo $brokerName;?>" style='width:72%;'/> <input type="hidden" name="company[broker]" id="companyBroker" class="form-control" placeholder="" value="<?php echo $broker?>"/><input type="hidden" name="company[email]" id="companyEmail" class="form-control" placeholder="" value="<?php echo $email?>"/><input type="hidden"  id="companyBrokerFirm" class="form-control" placeholder="" value="<?php echo $brokerFirm?>"/>
 </div> </div>   </div>
 <div class="row"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Street:</label> <input type="text" name="company[company_address]" value="<?php echo $company_address?>" id="inviteeStreet" class="form-control" placeholder="" style='width:54%;'/> </div> </div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Telephone:</label> <input type="text" name="company[telephone]" id="companyTelephone" class="form-control" placeholder="" value="<?php echo $telephone?>" style='width:61%;'/> </div> </div></div> <div class="row"><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">City:</label> <input type="text" name="company[city]" id="companyCity" value="<?php echo $city?>" class="form-control" placeholder="" style='width:80%;'/> </div> </div> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Country/Region:</label> <input type="text" name="company[country]" value="<?php echo $country?>" id="companyCountry" class="form-control" placeholder="" style='width:45%;'/> </div> </div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Industry:</label> <input type="text" name="company[industry]" value="<?php echo $industry?>" id="companyIndustry" class="form-control" placeholder="" style='width:45%;'/> </div> </div><div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Specialities:</label> <input type="text" name="company[specialties]" value="<?php echo $specialties?>" id="companySpecialties" class="form-control" placeholder="" style='width:45%;'/> </div> </div><div class="col-xs-12"> <div class="form-group input-string-group"><textarea name="company[owler_description]" id="companyOwlerDescription" class="form-control" placeholder="Owler description for Company:" style='width:100%;height:120px !important;'><?php echo $companyOwlerDescription?></textarea></div></div><div class="col-xs-12"> <div class="form-group input-string-group"><textarea name="company[describing]" id="companyDescribing" class="form-control" placeholder="Describing the Company:" style='width:100%;height:120px !important;'><?php echo $describing?></textarea></div></div><div class="col-xs-12" id="company_similar_organization"> <div class="form-group input-string-group" style="border:0px !important;"> <label class="control-label">Similar Organizations:</label>	<?php if($companyID!=0): 
  			if($peopleAlsoViewed==""){
				if(count($similarOrganization)>0){
					  $s=1;
					foreach($similarOrganization as $organization){
				?>
					<span class='pull-left' style='margin-top:5px;margin-left:5px;'>
					<a href="javascript://" onclick='window.parent.openCompanyEdit(<?php echo $organization->id;?>)'><?php echo $organization->company_name;?></a>	
					<?php echo ($s<count($similarOrganization))?', ':'';?>
					</span>
				<?php
						$s++;
					}
				}
				if(count($codeList) > 0 && is_array($codeList)) {
					foreach($codeList as $l){
				?>
					<span class='pull-left' style='margin-top:5px;margin-left:5px;'><?php echo $l;?></span>
				<?php
					}
				}
			} else {
				try{
					$similarOrganization = json_decode($peopleAlsoViewed);
					if(count($similarOrganization)>0){
						$viewOrg = array();
						foreach($similarOrganization as $org){
							$viewOrg[] = $org->name;
						}
						if(count($codeList) > 0 && is_array($codeList)) {
							foreach($codeList as $l){
								array_push($viewOrg,$l);
							}
						}
			?>
						<span class='pull-left' style='margin-top:5px;margin-left:5px;width:80%;'><?php echo implode($viewOrg,", ")?></span>
			<?php
					}
				}catch(Exception $e){
					
				}
				
			}
		endif;
	?></div></div>
	<div class="col-xs-12" id="company_competitors"> 
		<div class="form-group input-string-group">
			<label class="control-label">Competitors:</label>
			<div style="overflow:auto;">
			<?php 
				if($companyCompetitors != "" && $companyCompetitors != "0"){
					try{
						$competitors = json_decode($companyCompetitors);
						if(count($competitors) > 0){
			?>
							<table>
								<tbody>
									<tr>
			<?php
							$s=1;
							foreach($competitors as $comp){
								$title = "";
								if(isset($comp->company_name)){
									$title = $comp->company_name;
								}
			?>
								<td valign="middle" align="center"  style='min-width:75px;height:90px;'>
									<span class="invite" title='Invite'></span>
									<a href="<?php echo $comp->href;?>" target="_blank" ><span title="<?php echo $title;?>" class='title' style='margin-top:5px;margin-left:5px;overflow:hidden;display:block;'>
										<img src="<?php echo $comp->logo;?>" style="max-height:30px;"/>
									</span></a>
									<span class='revenue' style='margin-left:5px;width:100%;display:block;'><input title='Create new company' class='n_company' type="checkbox" data-href="<?php echo $comp->href;?>" data-logo="<?php echo $comp->logo;?>" data-revenue="<?php echo $comp->revenue;?>" data-title="<?php echo $title;?>" style="width:10px;margin-left:5px;"/><a href="<?php echo $comp->href;?>" target="_blank" ><?php echo $comp->revenue;?></a></span>
								</td>
							
			<?php
								$s++;
							}
			?>
									</tr>
								</tbody>
							</table>
			<?php
						}
					}catch(Exception $e){
						
					}
				}
			?>
			</div>
		</div>
	</div>
	</div>
  </div>
	<div class='col-xs-12' id='company_users_show_table' style='margin-top:10px;padding:0px;width:97%;'>		
		<table class="table" style='width:100%;' id="table_list_user">
			<thead><tr><th>Name</th><th>Title</th><th>DirectTel</th><th>CompanyTel</th><th>MobileTel</th><th>Proximity</th><th>CC</th></tr></thead>
			<tbody>
				<?php 
					if(count($companyUsers)>0){
					foreach($companyUsers as $user){
				?>
				<tr data-id="<?php echo $user->id?>">
				<td style='padding:5px;'><a href='javascript://' onclick='editContact(<?php echo $user->id?>);'><?php echo $user->name?></a>&nbsp;&nbsp;<a href='javascript://' onclick='deleteContact(<?php echo $user->id?>,<?php echo $user->company_id?>);'><i class='fa fa-trash colorClass' title='Companies'></i></a></td>
				<td style='padding:5px;'><?php echo $user->job_title?></td>
				<td align='center' style='padding:5px;'><?php if(trim($user->telephone)!=''):?><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent("<?php echo $user->telephone?>"))'><i class='fa fa-phone' style='color:#1E88E5' title='DirectTel'></i></a><?php endif;?></td>
				<td align='center' style='padding:5px;'><?php if(trim($user->company_tel)!=''):?><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent("<?php echo $user->company_tel?>"))'><i class='fa fa-phone fa-phone-square' style='color:#1E88E5' title='CompanyTel'></i></a><?php endif;?></td>
				<td align='center' style='padding:5px;'><?php if(trim($user->phone)!=''):?><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent("<?php echo $user->phone?>"))'><i class='fa fa-phone fa-mobile' style='color:#1E88E5' title='MobileTel'></i></a><?php endif;?></td>
				<td style='padding:5px;'><?php echo $user->proximity?></td>
				<td style='padding:5px;'><?php echo $user->c_c?></td>
				</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
</div> 
</div> 
<div class="row hide" style='margin-top:10px;' id="clasify">
	<div class="col-sm-12">
		<div class="col-xs-5"><button type="button" class='action-menu' data-type='sector' data-action="expand-all" style='background:none !important;border:1px solid #efefef !important; font-size:17px;font-weight:bold;cursor:pointer;' >+</button></div>
		<div class="col-xs-7"><button type="button" class='action-menu' data-type='technology' data-action="expand-all" style='background:none !important;border:1px solid #efefef !important; font-size:17px;font-weight:bold;cursor:pointer;' >+</button></div>
	</div>
	<div class="col-xs-6" style='height:485px;overflow:auto'>
		<div class="dd" id="nestable"><?php echo buildCompanyMenu($companyID);?></div>
	</div>
	<div class="col-xs-6" style='height:485px;overflow:auto'>
		<div class="dd types" id="nestable1"><?php echo buildTechnologyMenu($companyID);?></div>
	</div>
	<div class="col-sm-12" id='loading' style='display:none;'>
		Loading......
	</div>
</div>
<input type="hidden" name="company[id]" id="companyId" class="form-control" value="<?php echo $companyID?>"/>
<style>
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
.dataTables_wrapper.no-footer .dataTables_scrollBody{border-bottom:0px;}
.dataTables_wrapper.no-footer div.dataTables_scrollBody table{border-bottom:0px solid #d1c8c8;}
table.dataTable thead th, table.dataTable thead td{padding:5px 4px;font-size:13px;}
#table_list_user_info{display:none;}
.css-label1>a,.css-label3>a{color:#56b2fe;}
.dd-item > button[data-action="cancel"]:before{content:'';}
.dd-item >button[data-action="expand"],.dd-item >button[data-action="collapse"]{top:2px;}
.table > thead > tr > th{border-top:0px;border-left:0px;border-bottom:0px;}
.table > thead > tr > th:last-child,.table > tbody > tr > td:last-child{border-right:0px;}
.table > tbody > tr > td{border-top:0px;border-left:0px;}
.mrg5L{margin-left:5px;}
</style>


<script>
let title = '<?php echo $query->title;?>',keyword = '<?php echo $query->keyword;?>';
__baseUrl = '<?php echo $Layout->baseUrl?>';
function browseFile(){
	$("#upload_c_file").trigger('click');
}
function deleteCompany(ID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'opportunity/deleteCompany',
		data:{delete_link:ID},
		cache:false,
		success:function(data){
			if(data>0){
				window.parent.deleteCompanyCheckInOtherPopup(ID);
				window.parent.closeSlideBarCompany();
			}					
		}
	});
}
function getListOfOtherNames(){
	if(jQuery("#companyId").val() > 0){
		jQuery.ajax({
			type:'GET',
			url:__baseUrl+'opportunity/get_list_other_name/'+jQuery("#companyId").val(),
			cache:false,
			dataType:'json',
			success:function(d){
				openCompanyOtherRecords(d);					
			}
		});
	}
}
var records = [];
function openCompanyOtherRecords(d){
	if(jQuery("#other_name_modal").length > 0){
		jQuery("#other_name_modal").remove();
	}
	jQuery('body').append('<div class="modal modal-opened-header fade" id="other_name_modal" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"><div class="modal-dialog" style=""><div class="modal-content" style="border:1px solid #d9534f"><div class="modal-header"><button type="button" class="close" style="margin-top:-12px" onclick="closeOtherNameModal();"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><button class="btn btn-primary" onclick="addARecord();"><i class="fa fa-plus"></i></button><button class="btn btn-primary mrg5L" onclick="deleteRecord();"><i class="fa fa-trash"></i></button><button class="btn btn-primary mrg5L" onclick="saveRecord();"><i class="fa fa-save"></i></button><div id="grid" style="width:100%;height:300px;"></div></div></div></div></div>');
	jQuery("#other_name_modal").modal('show');
	records = d;
	$('#grid').w2grid({ 
		name	: 'grid', 
		header	: 'List of Othernames',
		columnTooltip: 'top',
		show	: { footer: true, toolbar: false,selectColumn: true,emptyRecords: true,expandColumn: false },
		multiSearch: false,
		markSearch:true,
		multiSelect:true,
		multiSort:false,
		recid:'id',
		columns: [
			{ field: 'name', text: 'Name', sortable: true,editable:{type:'text'}}
		],
		records: records,
		onClick: function(event) {
			if(event.column !== null) {
				console.log("Event1",event);
				console.log(event.recid);
				setTimeout(function(){w2ui.grid.unselect(parseInt(event.recid));},500);
			} else {
				console.log("Event 2",event);
			}
		},
		onDblClick: function(event) {},
		onChange:function(event){
			setTimeout(function(){
				var getRecords = w2ui.grid.records;
				console.log(getRecords);
				getRecords.map(function(r,i){
					if(parseInt(r.recid) == parseInt(event.recid)){
						console.log("Enter",r);
						if(r.w2ui.changes.name != ""){
							console.log("Enter3",r.w2ui.changes.name);
							var name = r.w2ui.changes.name;
							updateRecord(name,event.recid,i);
							return false;
						}
					}
				});
			},1000);
		}
	});
	w2ui.grid.buffered = records.length;
	w2ui.grid.total = w2ui.grid.buffered;
	w2ui.grid.resize();
}
function addARecord(){
	if(jQuery("#companyId").val() > 0){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/add_other_name',
			data:{company_id:jQuery("#companyId").val()},
			cache:false,
			dataType:'json',
			success:function(d){
				if(d.id > 0){
					w2ui['grid'].add( { recid: d.id, name: ''} );
				}					
			}
		});
	}
}
function updateRecord(name,recID,i){
	if(recID > 0){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/update_other_name',
			data:{id:recID,name:name},
			cache:false,
			dataType:'json',
			success:function(d){
				var getRecords = w2ui.grid.records;
				getRecords[i].name = name;
				records = getRecords;
			}
		});
	}
}
function saveRecord(){
	var allRecords = w2ui.grid.records;
	if(allRecords.length > 0) {
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/update_all_other_names',
			data:{rows:allRecords},
			cache:false,
			dataType:'json',
			success:function(d){
				console.log(d);
			}
		});
	}
}
function deleteRecord(){
	var getSelections = w2ui.grid.getSelection();
	if(getSelections.length > 0) {
		var conf = confirm("Delete "+formatter.format(getSelections.length)+" company names?");
		if(conf){
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'opportunity/deleteBulkOtherName',
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
function closeOtherNameModal(){
	records = [];
	if(w2ui.hasOwnProperty('grid')){
	  w2ui['grid'].destroy();
	}
	jQuery("#other_name_modal").find(".modal-body").html("");
	jQuery("#other_name_modal").modal("hide");
	jQuery("#other_name_modal").remove();
}
function editContact(ID){
	if(typeof window.parent.editContact=="function"){
		window.parent.editContact(ID);
	} else {
		window.parent.parent.editContact(ID);
	}
}	
function deleteContact(ID,companyID){
	if(typeof window.parent.deleteGoogleContactModal=="function"){
		window.parent.deleteGoogleContactModal(ID,companyID);
	} else {
		window.parent.parent.deleteGoogleContactModal(ID,companyID);
	}
}
function removeUserFromList(ID){
	console.log("Company Card Remove Contact:"+ID);
	_dataTable.destroy();
	if(jQuery("#table_list_user").find("tr[data-id='"+ID+"']").length > 0){
		jQuery("#table_list_user").find("tr[data-id='"+ID+"']").remove();
	}
	callDataTable();
}
function resetParent(ID){
	jQuery("#companyParent").val(0);
	jQuery(".show_name").empty();
	jQuery("#buttonADDCCompany").trigger('click');
}
function openClasify(){
	if(jQuery("#clasify").hasClass('hide')){
		jQuery("#clasify").removeClass('hide').addClass('show');
	} else {
		jQuery("#clasify").removeClass('show').addClass('hide');
	}
	if(jQuery('input[name="company[sector][]"]:checked').length == 0){
		if(jQuery('input[name="preferences[departments][]"]:checked').length > 0){
			var firstSelection = jQuery('input[name="preferences[departments][]"]:checked').eq(0);
			checkedMyChild(firstSelection);
		}
	}
	widthChange();
}
function linkedInSearch(){
	_companyName = jQuery("#companyJobTitle").val();
	urlString = "";
	if(_companyName!=""){
		urlString = "https://www.linkedin.com/search/results/all/?keywords="+encodeURIComponent(_companyName)+"&origin=GLOBAL_SEARCH_HEADER";
		window.open(urlString,'_blank');
	} else {
		alert("Company name is blank");
	}	
}

function widthChange(){
	jQuery('.input-string-group').each(function(){
		var $this = jQuery(this);
		var _w = $this.outerWidth();
		if($this.find('.control-label').length>0){
			lbl = $this.find('.control-label').outerWidth();
			if($this.find('input[type="text"]').length>0){
				inputW = _w - lbl-20;
				$this.find('input[type="text"]').css('width',inputW+'px');
			} else if($this.find('span.show_name').length>0){
				inputW = _w - lbl-35;
				$this.find('span.show_name').css('width',inputW+'px');
			} else if($this.find('input[type="checkbox"]').length>0){
				$this.find('input[type="checkbox"]').css('width', '10px');
			}
		}
	})
}
jQuery(window).resize(function(){
	console.log("Resize");
	widthChange()
})
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

function uploadByImageUrl(){
	var inputImageUrl = jQuery("#image_url");
	if(inputImageUrl.hasClass("hide")){
		inputImageUrl.removeClass("hide").addClass("show-inline");
	} else {
		inputImageUrl.removeClass("show-inline").addClass("hide");
	}
}

var _dataTable="",newHeight="";
	jQuery(document).ready(function() {
		
		/*if(jQuery("#companyNoOfEmployees").val() != "") {
			var companyNoOfEmployees = jQuery("#companyNoOfEmployees").val();
			jQuery("#companyNoOfEmployees").val(formatter.format(companyNoOfEmployees));
		}*/
		$("#upload_c_file").on("change",function(){
			$("#loading_message").html($(this).val());
		});
		findCompetitorsCompany();
		newHeight = (jQuery(window).height() - 120);
		widthChange();
		checkBoxClickEvent();
		jQuery("#companyParentSearch").autocomplete({
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
			jQuery("#companyParent").val(ui.item.realValue);
			jQuery(".show_name").html('<strong><a href="javascript://" onclick="window.parent.openCompanyEdit('+ui.item.realValue+');" >'+ui.item.label+'</a></strong>');widthChange();
			/*findContactsForThisCompany(ui.item.realValue);*/
		}
	});
	setTimeout(function(){jQuery('.ui-autocomplete').css('height',newHeight+'px');},200);
		jQuery("#companyLinkedinUrl").on('click',function(){
			_linkedin = jQuery(this).val();
			if(_linkedin.indexOf('linkedin')>=0){
				window.open(_linkedin,"_blank");
			}
		});
		jQuery("#companyWebAddress").on('click',function(){
			let website = jQuery(this).val();
			if(website !=""){
				if(website.indexOf('http')<0){
					website = "http://"+website;
				}
				window.open(website,"_blank");
			}
		});
		jQuery("#companyOwlerUrl").on('click',function(){
			_owler = jQuery(this).val();
			if(_owler.indexOf('owler')>=0){
				window.open(jQuery(this).val(),"_blank");
			}
		});
		/**/
	jQuery('.action-menu').on('click', function(e){
		var target = $(e.target),action = target.data('action'),type=target.data('type');
		_string = "";
		if(type=="sector"){
			_string = "nestable";
		} else {
			_string = "nestable1";
		}
		if (action === 'expand-all') {			
			jQuery('.dd').nestable('expandAll');
			jQuery(this).html('-').data('action','collapse-all');
		}
		if (action === 'collapse-all') {
			jQuery('.dd').nestable('collapseAll');
			jQuery(this).html('+').data('action','expand-all');
		}
	});
	callDataTable();
	jQuery("#ccompanyFormSubmit").submit(function(e){
		e.preventDefault();
		saveCompany(false,true);
		/*if(jQuery('input[name="company[sector][]"]:checked').length>0){
			saveCompany(false,true);
		} else {
			alert("Please select sector.");
		}*/
	})
	var findTr = jQuery("#company_competitors").find('table>tbody>tr');
	if(findTr.length > 0){
		var findTDs = findTr.find('input.n_company');
		if(findTDs.length > 0){
			findTDs.on("change",function(){
				var $this = jQuery(this);
				if($this.is(":checked")){
					var companyData = {company_logo:$this.attr('data-logo'),owler_url:$this.attr('data-href'),owler_company_revenue:$this.attr('data-revenue'),company_name:$this.attr('data-title')};
					addCompetitorCompany(companyData,$this);
				}
			});
		}
	}
	callEditor();	
});
function findCompetitorsCompany(){
	var findTr = jQuery("#company_competitors").find('table>tbody>tr');
	if(findTr.length > 0){
		var findTDs = findTr.find('td');
		if(findTDs.length > 0){
			var allCompetitorList = [];
			findTDs.each(function(){
				var $this = jQuery(this);
				if($this.find('a').length > 0){
					allCompetitorList.push($this.find('a').attr('href'));
				}
			});
			if(allCompetitorList.length > 0){
				var _parent = window.parent.findParent();
				var leadID = 0;
				var _activity = 0;
				var companyListSlider = _parent.jQuery("#open_ccompany_gd");
				if(companyListSlider.length > 0){
					var iframeContent = companyListSlider.find("#companyFormIframe").get(0).contentWindow;
					leadID = iframeContent._leadID;
					_activity = iframeContent.jQuery('#profileListType').val();
				} else {
					leadID = window.parent.leadGlobal;
					if(window.parent.jQuery("#activityMainType").val() > 0){
						_activity = window.parent.jQuery("#activityMainType").val();
					}
				}
				jQuery.ajax({
					url: __baseUrl+'opportunity/find_competitor_as_company',
					type: 'POST',
					dataType: "json",
					data: { list: allCompetitorList,lead_id:leadID,activity:_activity},
					success: function (data) {
						if(data.length > 0){
							data.map(function(c){
								var findInput = findTr.find('input[data-href="'+c.owler_url+'"]');
								if(findInput.length > 0){
									findInput.prop("checked",true);
									findInput.attr("checked","checked").attr('title','').prop('disabled',true);
									var parentInput = findInput.parents('td');
									var anchorTag = parentInput.find('a');
									anchorTag.each(function(){
										var $this = $(this);
										$this.attr('href','javascript://').attr('onclick','window.parent.openCompanyEdit('+c.id+');').removeAttr('target');
									});
									var revenueSpan = parentInput.find('span.invite');
									var _checked = "";
									if(c.contact == 1){
										_checked = "CHECKED='CHECKED'";
									}
								//	var revenueText = revenueSpan.text();
									revenueSpan.html("<input type='checkbox' onclick='window.parent.inviteCompanyToSelectedLead(jQuery(this),"+c.id+")' data-id='"+c.id+"' class='invite' "+_checked+"/>").css('display','block');
								}
							});
						}
					}
				})
			}
		}
	}
}
function addCompetitorCompany(companyData,o){
	jQuery.ajax({
		url: __baseUrl+'opportunity/add_competitor_as_company',
		type: 'POST',
		data: companyData,
		success: function (data) {
			console.log(data);
			if(data > 0){
				var parentInput = o.parents('td');
				var anchorTag = parentInput.find('a');
				anchorTag.each(function(){
					var $this = $(this);
					$this.attr('href','javascript://').attr('onclick','window.parent.openCompanyEdit('+data+');').removeAttr('target');
				});
				parentInput.find('span.invite').html("<input type='checkbox' onclick='window.parent.inviteCompanyToSelectedLead(jQuery(this),"+data+")' data-id='"+data+"' class='invite' />").css('display','block');
				o.prop("disabled",true);
			}			
		}
	});
}
function openAddContact(){
	window.parent.openContactBoxForSelectedCompany(jQuery("#companyId").val(),jQuery("#companyJobTitle").val());
}
function callDataTable(){
	_dataTable = jQuery('#table_list_user').DataTable( {
        fixedHeader: true,
		searching:false,
		paging:false,
		deferRender:    true,
        scrollY:        230,
        scrollCollapse: true,
		scroller:       true,
		"oLanguage": {
			"sEmptyTable": "No record found!"
		}
    } );
}

_companyID = '<?php echo $companyID?>';
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
function callNestable(){
	jQuery('#nestable').nestable(__options);		
	jQuery('#nestable1').nestable(__options1);	
	jQuery(".dd-nodrag").on("mousedown", function(event) { // mousedown prevent nestable click
		event.preventDefault();
		return false;
	});
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
callNestable();
function saveCompany(scrape,push,tt){
	jQuery("#loading_message").html("Please wait...");
	var formData = new FormData(jQuery("#ccompanyFormSubmit")[0]);
	jQuery.ajax({
		type:'POST',
		url:jQuery("#ccompanyFormSubmit").attr("action"),
		processData: false,
		contentType: false,
		data : formData,
		dataType:'json',
		success:function(d){
			if(typeof d.success!="undefined" && d.success>0){
				jQuery("#companyId").val(d.success);
				/*alert("Record updated");*/
				jQuery("#loading_message").html("Record updated");
				setTimeout(function(){jQuery("#loading_message").html("");},2000);
				/*Close Slider*/
				/*window.parent.closeSlideBarCompany();*/
				/*Synchronise*/
				if(push===true){
					window.parent.pushingCompany(jQuery("#companyId").val());
				}
				if(scrape===true){	
					if(typeof tt != "undefined"){
						if(tt == 0){
							scrapeCompany();
						} else {
							//scrapeOwler(1);
							addCompanyToPingpong();
						}
					}					
				}
				/*End Synchronise*/
			}else  {
				if(typeof d.error_message!="undefined" && d.error_message!=""){
					alert(d.error_message);
				} else {
					alert("Please try after sometime.");
				}
			}
		}
	});
}

function checkListForC(){
	if(window.parent.companyQuList.length>0){
		_found = false;
		for(i=0;i<window.parent.companyQuList.length;i++){
			if(window.parent.companyQuList[i].company==jQuery("#companyId").val()){
				_found = true;
				return '';
			}
		}
		if(_found===false){
			let iDS = [];
			iDS.push(jQuery("#companyId").val());
			jQuery.ajax({
				url:__baseUrl+'opportunity/findAllCompaniesLinkedin',
				type:'POST',
				data:{c:JSON.stringify(iDS),t:33},
				dataType:'json',
				success:function(d){
					if(d.length>0){
						checkRunningStage(0 ,'Company');
					}
				}
			});
			/*var scrapCompany = {company:jQuery("#companyId").val(),url:jQuery("#companyLinkedinUrl").val(),type:33};
			checkQueList(scrapCompany);
			if(window.parent.scraperCompanyRequest==null || (typeof window.parent.scraperCompanyRequest.readyState!=undefined && window.parent.scraperCompanyRequest.readyState==4)){
				window.parent.sendScrapperCompanyRequest(33);
			}*/
		} else {
			setTimeout(checkListForC,500);
		}
	} else {
		scrapeCompany();
	}
}

function checkRunningStage(t = 0,type = 'Company') {
	jQuery.ajax({
		url:__baseUrl+'opportunity/check_running_stage/'+t,
		type:'get',
		dataType:'json',
		success:function(d){
			if(d.d == 0){
				if(type == "Company"){
					window.parent.sendCompanyScrapperRequest();
				} else {
					window.parent.sendCompanyPeopleRequest();
				}
			} else {
				if(type == "Company"){
					window.parent.checkQueue();
				} else {
					window.parent.checkCompanyPeopleQueue();
				}
			}
		}
	})
}
function checkOwlerRunningStage(){
	jQuery.ajax({
		url:__baseUrl+'opportunity/check_owler_running_stage',
		type:'get',
		dataType:'json',
		success:function(d){
			if(d.d == 0){
				window.parent.sendOwlerScrapperRequest();
			} else {
				window.parent.checkOwlerQueue();
			}
		}
	})
}
function scrapeOwler(j){
	if(jQuery("#companyOwlerUrl").val()!=""){
		var owlerUrl = jQuery("#companyOwlerUrl").val();
		if(owlerUrl.indexOf('owler.com')>=0){
			if(jQuery("#companyId").val()>0){
				/*save company */
				if(typeof j != "undefined" && j == 1){
					saveCompany(false,false);
				}				
				let iDS = [];
				iDS.push(jQuery("#companyId").val());
				jQuery.ajax({
					url:__baseUrl+'opportunity/findAllOwlerCompanies',
					type:'POST',
					data:{c:JSON.stringify(iDS),t:33},
					dataType:'json',
					success:function(d){
						if(d.length>0){
							checkOwlerRunningStage();
						}
					}
				});
			} else {
				/*save company first then run scrapper */
				jQuery.ajax({
					type:'POST',
					url:__baseUrl+'opportunity/check_company_owler_url',
					data:{linkedin_url:owlerUrl},
					dataType:'json',
					success:function(d){
						if(typeof d.id!="undefined" && d.id>0){
							url =  __baseUrl+'opportunity/add_company/'+d.id;
							window.location = url;
							window.parent.checkOwlerProfileLoadRunScrape(d.id);
							/*Similar Organizations */
						} else {
							/*save company */
							saveCompany(true,false,1);							
						}
					}
				});
			}
		}
	}
}
function addCompanyToPingpong(){
	if(jQuery("#companyOwlerUrl").val() == ""){
		alert("Please add owler url first.");
	} else if(jQuery("#companyId").val() == 0){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/check_owler_url',
			data:{owler_url:jQuery("#companyOwlerUrl").val()},
			dataType:'json',
			success:function(d){
				if(typeof d.id!="undefined" && d.id>0){
					url =  __baseUrl+'opportunity/add_company/'+d.id;
					window.location = url;
					window.parent.checkCompanyProfileLoadRunOwlerScrape(d.id);
				} else {
					/*save company */
					saveCompany(true,false,1);			
				}
			}
		});
	} else {
		saveCompany(false,false);
		jQuery.ajax({
			url:__baseUrl+'opportunity/add_company_to_pingpong',
			type:'POST',
			data:{c:jQuery("#companyId").val()},
			dataType:'json',
			success:function(d){
				if(d.update > 0){
					alert("Added to pingpong.");
				} else {
					alert("Already added to pingpong.");
				}
			}
		});
	}
}
function scrapeCompany(){
	if(jQuery("#companyLinkedinUrl").val()!=""){
		var linkedINUrl = jQuery("#companyLinkedinUrl").val();
		if(linkedINUrl.indexOf('linkedin.com')>=0){
			if(jQuery("#companyId").val()>0){
				/*save company */
				saveCompany(false,false);
				
				let iDS = [];
				iDS.push(jQuery("#companyId").val());
				jQuery.ajax({
					url:__baseUrl+'opportunity/findAllCompaniesLinkedin',
					type:'POST',
					data:{c:JSON.stringify(iDS),t:33},
					dataType:'json',
					success:function(d){
						if(d.length>0){
							checkRunningStage(0, 'Company');
						}
					}
				});
			} else {
				/*save company first then run scrapper */
				jQuery.ajax({
					type:'POST',
					url:__baseUrl+'opportunity/check_company_linkedin_url',
					data:{linkedin_url:linkedINUrl},
					dataType:'json',
					success:function(d){
						if(typeof d.id!="undefined" && d.id>0){
							url =  __baseUrl+'opportunity/add_company/'+d.id;
							window.location = url;
							window.parent.checkCompanyProfileLoadRunScrape(d.id);
							/*Similar Organizations */
						} else {
							/*save company */
							saveCompany(true,false,0);							
						}
					}
				});
			}
		}
	}
}
function checkQueList(scrapCompany){
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
function findPeopleFromLinkedin(){
	const getSelectedCompanies = [jQuery("#companyId").val()];
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
	const getSelectedCompanies = [jQuery("#companyId").val()];
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
				checkRunningStage(3, "FindPeople");
			}
		}
	});
}
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
<?php echo form_close();?>