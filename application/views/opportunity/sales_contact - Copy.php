<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>icons/fontawesome/fontawesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/modal/modal.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/modal/modal.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/slimscroll/slimscroll.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/tooltip/tooltip.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/dropdowncheck/css/ui.dropdownchecklist.standalone.css">
<script src="<?php echo $Layout->aws_server_cdn;?>widgets/dropdowncheck/js/ui.dropdownchecklist-1.4-min.js"></script>
<style>
body{font-family:arial;font-size:13px;}
#page-content {
	    background: #ffffff !important;
	}
	a{
		text-decoration:none
	}
	h4{font-size:16px;font-weight:300;margin:0}
	.fc-icon,
#page-sidebar li ul li a:before,
#page-sidebar li a.sf-with-ul:after,
.search-choice-close:before,
.ui-dialog-titlebar-close:before,
.glyph-icon:before,
.ui-icon:before,
.dataTables_paginate a i:before {
    font-family: FontAwesome;
    font-weight: normal;
    font-style: normal;
    display: inline-block;
    text-align: center;
    text-decoration: none;
    background: none;
    speak: none;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.handsontable .htDimmed{color:#222222 !important}
.ui-dropdownchecklist-dropcontainer-wrapper{
	z-index:999 !important;
} .ui-dropdownchecklist-text{font-weight:normal;}
.btn{font-family:arial;}
.htCore, .handsontable {
    font-family: arial;
    font-size: 13px;
}
</style>
<script>
	var ___table ;
	__baseUrl ='<?php echo $Layout->baseUrl?>';
	_leadID = '<?php echo $lead_id?>';
	_activity = '<?php echo $activity?>';
	insertID = [];
	function changeSelectors(selector){
		insertID = [];
		jQuery("#preferenceDepartments").find("option").remove();
		if(selector!=""){
			try{
				_sector = JSON.parse(selector);
				if(_sector.length>0){
					jQuery.ajax({
					type:"POST",
					url:__baseUrl+"opportunity/sales_contact/"+_leadID+"/"+_activity+"/ajax/1",
					data:{search:jQuery('#search_field').val(),s:jQuery("#companySector").val()},
					cache:false,
					dataType:'json',
					success:function(b){
						if(jQuery("#ddcl-preferenceDepartments").length>0){
							jQuery("#preferenceDepartments").dropdownchecklist("destroy");
						}
						jQuery("#preferenceDepartments").append("<option value=''>Select All</option>");
						jQuery("#preferenceDepartments").append("<option value='-1'>Blank</option>");
						if(b.deptt.length>0){							
							_deptt = b.deptt;
							for(i=0;i<_deptt.length;i++){
								jQuery("#preferenceDepartments").append("<option value='"+_deptt[i].id+"'>"+_deptt[i].name+"</option>");
							}							
						}
						__countAll = b.count_all;
						__current_page_no = b.current_page_no;
						__current_page_no = parseInt(__current_page_no);
						__noOfPagesShow = 5;
						__no_of_records = b.no_of_records;
						creatingDropDownList(285,350,"Categories","preferenceDepartments",changeDepartments);
						_companiesINString = [];
						window.cUser = [];
						if(b.companies.length>0){
							_companies = b.companies
							for (i = 0; i < _companies.length; i++) {
								if(jQuery.inArray(parseInt(_companies[i].id),insertID)<0){
									insertID.push(parseInt(_companies[i].id));
								var comObj = {};
								_selected = false;
								if(b.activity==2){
									if(b.selected_acquisition_companies.length>0){
										jQuery.each(b.selected_acquisition_companies,function(index,sc){
											if(sc.id==_companies[i].id){
												_selected = true;
												return false;
											}
										});
									}
								} else {
									if(b.selected_sales_companies.length>0){
										jQuery.each(b.selected_sales_companies,function(index,sc){
											if(sc.id==_companies[i].id){
												_selected = true;
												return false;
											}
										});
									}
								}
								
								comObj.id = _companies[i].id;
								comObj.selected = _selected;
								comObj.company_name = _companies[i].company_name;
								comObj.no_of_users = _companies[i].company_users.length;
								comObj.sectors = _companies[i].sectorName;
								comObj.categories = _companies[i].department_names;
								comObj.sub_category = _companies[i].sub_department_names;
								_companiesINString.push(comObj);
								html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
								_users = _companies[i].company_users;
								if(_users.length>0){
									for(j=0;j<_users.length;j++){
										_companyName = _users[j].name;
										_companyName.replace('"','');
										_companyName.replace('"','');
										html+="<tr>"+
										"<td><a href='javascript://' onclick='window.parent.editContact("+_users[j].id+");'>"+_companyName+"</a></td>"+
										"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_users[j].phone+"\"))'>"+_users[j].phone+"</a></td>"+
										"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_users[j].telephone+"\"))'>"+_users[j].telephone+"</a></td>"+
										"</tr>"; 
									}
								}								
								html+="</tbody></table>";
								window.cUser[_companies[i].id] = html;
								}
							}
						}
						hot1.destroy();
						implementCompanyTable();
					}
					});
				}
			}catch(e){
				console.log(e);
			}
		}
	}	
	
	function changeDepartments(selector){
		insertID = [];
		jQuery("#subDepartments").find("option").remove();
		if(selector!=""){
			try{
				_sector = JSON.parse(selector);
				if(_sector.length>0){
					typeMode = 0;
					if(_sector.length==1 && _sector[0]=='-1'){
						console.log("A234B");
						typeMode = 1;
					}
					console.log("A"+_sector[0]+"B");
					jQuery.ajax({
					type:"POST",
					url:__baseUrl+"opportunity/sales_contact/"+_leadID+"/"+_activity+"/ajax/1",
					data:{search:jQuery('#search_field').val(),s:jQuery("#companySector").val(),dep:jQuery("#preferenceDepartments").val(),mode:typeMode},
					cache:false,
					dataType:'json',
					success:function(b){
						if(jQuery("#ddcl-subDepartments").length>0){
							jQuery("#subDepartments").dropdownchecklist("destroy");
						}
						jQuery("#subDepartments").append("<option value=''>Select All</option>");
						jQuery("#subDepartments").append("<option value='-1'>Blank</option>");
						if(b.subb.length>0){							
							_deptt = b.subb;
							for(i=0;i<_deptt.length;i++){
								jQuery("#subDepartments").append("<option value='"+_deptt[i].id+"'>"+_deptt[i].name+"</option>");
							}							
						}
						creatingDropDownList(285,350,"Sub Categories","subDepartments",changeSubDepartments);
						_companiesINString = [];
						window.cUser = [];
						_selectCategory = [];
						jQuery("#preferenceDepartments>option").each(function(){
							if(jQuery(this).is(':selected')){
								if(jQuery(this).text()=='Blank'){
									_selectCategory.push('');
								} else if(jQuery(this).val()!=""){
									_selectCategory.push(jQuery.trim(jQuery(this).text()));
								}
							}
						});
						__countAll = b.count_all;
						__current_page_no = b.current_page_no;
						__current_page_no = parseInt(__current_page_no);
						__noOfPagesShow = 5;
						__no_of_records = b.no_of_records;
						if(b.companies.length>0){
							_companies = b.companies
							for (i = 0; i < _companies.length; i++) {
								if(jQuery.inArray(parseInt(_companies[i].id),insertID)<0){
									insertID.push(parseInt(_companies[i].id));
								__subDeptt = _companies[i].department_names;
								__subDeptt = __subDeptt.split(',');
								_entry = false;
								if(__subDeptt.length>0){									
									jQuery.each(__subDeptt,function(index,de){
										if(jQuery.inArray(jQuery.trim(de),_selectCategory)>=0){
											_entry = true;
											return false;
										}
									})
								}
								if(_entry===true){
								var comObj = {};
								_selected = false;
								if(b.activity==2){
									if(b.selected_acquisition_companies.length>0){
										jQuery.each(b.selected_acquisition_companies,function(index,sc){
											if(sc.id==_companies[i].id){
												_selected = true;
												return false;
											}
										});
									}
								} else {
									if(b.selected_sales_companies.length>0){
										jQuery.each(b.selected_sales_companies,function(index,sc){
											if(sc.id==_companies[i].id){
												_selected = true;
												return false;
											}
										});
									}
								}
									
								comObj.id = _companies[i].id;
								comObj.selected = _selected;
								comObj.company_name = _companies[i].company_name;
								comObj.no_of_users = _companies[i].company_users.length;
								comObj.sectors = _companies[i].sectorName;
								comObj.categories = _companies[i].department_names;
								comObj.sub_category = _companies[i].sub_department_names;
								_companiesINString.push(comObj);
								html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
								_users = _companies[i].company_users;
								if(_users.length>0){
									for(j=0;j<_users.length;j++){
										_companyName = _users[j].name;
										_companyName.replace('"','');
										_companyName.replace('"','');
										html+="<tr>"+
										"<td><a href='javascript://' onclick='window.parent.editContact("+_users[j].id+");'>"+_companyName+"</a></td>"+
										"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_users[j].phone+"\"))'>"+_users[j].phone+"</a></td>"+
										"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_users[j].telephone+"\"))'>"+_users[j].telephone+"</a></td>"+
										"</tr>"; 
									}
								}								
								html+="</tbody></table>";
								window.cUser[_companies[i].id] = html;
								}
								}
							}
						}
						hot1.destroy();
						implementCompanyTable();
					}
					});
				}
			}catch(e){
				console.log(e);
			}
		}
	}
	function changeSubDepartments(selector){
		insertID = [];
		if(selector!=""){
			try{
				_sector = JSON.parse(selector);
				if(_sector.length>0){
					typeMode = 0;
					if(_sector.length==1 && _sector[0]=='-1'){
						console.log("A234B");
						typeMode = 1;
					}
					jQuery.ajax({
					type:"POST",
					url:__baseUrl+"opportunity/sales_contact/"+_leadID+"/"+_activity+"/ajax/1",
					data:{search:jQuery('#search_field').val(),s:jQuery("#companySector").val(),dep:jQuery("#preferenceDepartments").val(),sub:jQuery("#subDepartments").val(),mode:typeMode},
					cache:false,
					dataType:'json',
					success:function(b){						
						_companiesINString = [];
						window.cUser = [];
						_selectSubCategory = [];
						jQuery("#subDepartments>option").each(function(){
							if(jQuery(this).is(':selected')){
								if(jQuery(this).text()=='Blank'){
									_selectSubCategory.push('-1');
								} else if(jQuery(this).val()!=""){
									_selectSubCategory.push(jQuery.trim(jQuery(this).text()));
								}
							}
						});
						__countAll = b.count_all;
						__current_page_no = b.current_page_no;
						__current_page_no = parseInt(__current_page_no);
						__noOfPagesShow = 5;
						__no_of_records = b.no_of_records;		
						if(b.companies.length>0){
							_companies = b.companies;
							for (i = 0; i < _companies.length; i++) {	
									if(jQuery.inArray(parseInt(_companies[i].id),insertID)<0){
									insertID.push(parseInt(_companies[i].id));
								__subDeptt = _companies[i].sub_department_names;
								__subDeptt = __subDeptt.split(',');
								_entry = false;
								if(__subDeptt.length>0){
									if(_selectSubCategory.length==1 && _selectSubCategory[0]=='-1' && _companies[i].sub_department_names==""){
										console.log('asdad1');
										_entry = true;
									} else {
										jQuery.each(__subDeptt,function(index,de){		
											console.log("DE:"+de+":I:"+i);
											if(jQuery.inArray(jQuery.trim(de),_selectSubCategory)>=0){
												console.log('asdad');
												_entry = true;
												return false;
											}
										})
									}
								}
								
								if(_entry===true && _companies[i].department_names!=''){
									var comObj = {};
									_selected = false;
									if(b.activity==2){
										if(b.selected_acquisition_companies.length>0){
											jQuery.each(b.selected_acquisition_companies,function(index,sc){
												if(sc.id==_companies[i].id){
													_selected = true;
													return false;
												}
											});
										}
									} else {
										if(b.selected_sales_companies.length>0){
											jQuery.each(b.selected_sales_companies,function(index,sc){
												if(sc.id==_companies[i].id){
													_selected = true;
													return false;
												}
											});
										}
									}
									
									comObj.id = _companies[i].id;
									comObj.selected = _selected;
									comObj.company_name = _companies[i].company_name;
									comObj.no_of_users = _companies[i].company_users.length;
									comObj.sectors = _companies[i].sectorName;
									comObj.categories = _companies[i].department_names;
									comObj.sub_category = _companies[i].sub_department_names;
									console.log(comObj);
									_companiesINString.push(comObj);
									html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
									_users = _companies[i].company_users;
									if(_users.length>0){
										for(j=0;j<_users.length;j++){
											_companyName = _users[j].name;
											_companyName.replace('"','');
											_companyName.replace('"','');
											html+="<tr>"+
											"<td><a href='javascript://' onclick='window.parent.editContact("+_users[j].id+");'>"+_companyName+"</a></td>"+
											"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_users[j].phone+"\"))'>"+_users[j].phone+"</a></td>"+
											"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_users[j].telephone+"\"))'>"+_users[j].telephone+"</a></td>"+
											"</tr>"; 
										}
									}								
									html+="</tbody></table>";
									window.cUser[_companies[i].id] = html;
									}
								}
							}
						}
						hot1.destroy();
						implementCompanyTable();
					}
					});
				}
			}catch(e){
				console.log(e);
			}
		}
	}
	function loadMessage(message){
		jQuery("#loading_message").html(message);
	}
	function getNextRecords(o){
		insertID = [];
		p = o.val();
		if(p==undefined){
			p = 50;
		}
		loadMessage("Loading..");
		_url = __baseUrl+'opportunity/sales_contact/'+_leadID+'/'+_activity+'/ajax/'+p;
		jQuery.ajax({
			type:"POST",
			url:_url,
			data:{search:jQuery('#search_field').val(),s:jQuery("#companySector").val(),dep:jQuery("#preferenceDepartments").val(),sub:jQuery("#subDepartments").val()},
			cache:false,
			dataType:'json',
			success:function(b){
				loadMessage("");				
				_companiesINString = [];
				window.cUser = [];
				_selectSubCategory = [];
				jQuery("#subDepartments>option").each(function(){
					if(jQuery(this).is(':selected')){
						if(jQuery(this).text()=='Blank'){
							_selectSubCategory.push('-1');
						} else if(jQuery(this).val()!=""){
							_selectSubCategory.push(jQuery.trim(jQuery(this).text()));
						}
					}
				});
				__countAll = b.count_all;
				__current_page_no = b.current_page_no;
				__current_page_no = parseInt(__current_page_no);
				__noOfPagesShow = 5;
				__no_of_records = b.no_of_records;		
				if(b.companies.length>0){
					_companies = b.companies;
					for (i = 0; i < _companies.length; i++) {
						if(jQuery.inArray(parseInt(_companies[i].id),insertID)<0){
									insertID.push(parseInt(_companies[i].id));
						__subDeptt = _companies[i].sub_department_names;
						__subDeptt = __subDeptt.split(',');
						_entry = false;
						if(__subDeptt.length>0 ){
							if(_selectSubCategory.length==1 && _selectSubCategory[0]=='-1' && _companies[i].sub_department_names==""){
								console.log('asdad1');
								_entry = true;
							} else {
								if(_selectSubCategory.length>0){
									jQuery.each(__subDeptt,function(index,de){										
										if(jQuery.inArray(de,_selectSubCategory)>=0){
											console.log('asdad');
											_entry = true;
											return false;
										}
									})
								} else {
									_entry = true;
								}								
							}
						} else {
							_entry = true;
						}
						/* && _companies[i].department_names!=''*/
						console.log("ENTRY:"+_entry+":ID:"+_companies[i].id);						
						if(_entry===true){
							var comObj = {};
							_selected = false;
							if(b.activity==2){
								if(b.selected_acquisition_companies.length>0){
									jQuery.each(b.selected_acquisition_companies,function(index,sc){
										if(sc.id==_companies[i].id){
											_selected = true;
											return false;
										}
									});
								}
							} else {
								if(b.selected_sales_companies.length>0){
									jQuery.each(b.selected_sales_companies,function(index,sc){
										if(sc.id==_companies[i].id){
											_selected = true;
											return false;
										}
									});
								}
							}
							
							comObj.id = _companies[i].id;
							comObj.selected = _selected;
							comObj.company_name = _companies[i].company_name;
							comObj.no_of_users = _companies[i].company_users.length;
							comObj.sectors = _companies[i].sectorName;
							comObj.categories = _companies[i].department_names;
							comObj.sub_category = _companies[i].sub_department_names;
							console.log(comObj);
							_companiesINString.push(comObj);
							html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
							_users = _companies[i].company_users;
							if(_users.length>0){
								for(j=0;j<_users.length;j++){
									_companyName = _users[j].name;
									_companyName.replace('"','');
									_companyName.replace('"','');
									html+="<tr>"+
									"<td><a href='javascript://' onclick='window.parent.editContact("+_users[j].id+");'>"+_companyName+"</a></td>"+
									"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_users[j].phone+"\"))'>"+_users[j].phone+"</a></td>"+
									"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_users[j].telephone+"\"))'>"+_users[j].telephone+"</a></td>"+
									"</tr>"; 
								}
							}								
							html+="</tbody></table>";
							window.cUser[_companies[i].id] = html;
							}
						}
					}
				}
				hot1.destroy();
				implementCompanyTable();
			}
			});
	}
	
	function findMyPeople(o){
		/*jQuery('.companyUsers').removeClass('show').addClass('hide');
		jQuery("#company-"+o.attr('data-id')).removeClass('hide').addClass('show');*/
		jQuery("#cUsers").html(window.cUser[o.attr('data-id')]);

		jQuery("#modal_c_users").modal("show");
	}
	window.cUser = [];
	jQuery(document).ready(function(){
		_h = window.parent.$(window).height() - 140;		
		creatingDropDownList(285,350,"Sectors","companySector",changeSelectors);
		creatingDropDownList(285,350,"Categories","preferenceDepartments",changeDepartments);
		creatingDropDownList(285,350,"Sub Categories","subDepartments",changeSubDepartments);
		 /*$("#s1").dropdownchecklist("refresh");*/
	});
	
	function funct(callback,args){
		callback.apply(this, args);
	}
	
	function creatingDropDownList(w,h,name,e,callback){
		$("#"+e).dropdownchecklist({icon: {},firstItemChecksAll: true,emptyText:name,maxDropHeight:h,width:w,onComplete:function(selector){ var values = [];
        for( i=0; i < selector.options.length; i++ ) {
            if (selector.options[i].selected && (selector.options[i].value != "")) {
                values.push(selector.options[i].value);
            }
        }
		funct(callback, [JSON.stringify(values)]);}});
	}



</script>
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.js"></script>
<style>
.scroll-container {
	width: 100%;
	height: 250px;
	margin: 5px 0 1rem;
	overflow: hidden;
}
.htCore td.customClass {
    color: #f8f8ff;
    background: #1E90FF;
}
</style>
<script>
	jQuery(document).ready(function(){
		jQuery('#search_field').keypress(function (e) {
			var key = e.which;
			if(key == 13) {
				e.preventDefault();
				getNextRecords(jQuery('#noOfRecords'));
			}		  
		}); 
	});
</script>
<h4>Companies  <span id='loading_message' style='margin-left:100px'></span></h4>
<div class="row">	
	<div class="col-md-12">		
		<div class="row">
		<div class="col-md-3" style=''>
		<div class='row'>
		<!--<div class="col-md-4">
		<a href='javascript://' onclick="addAllCompanyToLead()" class='btn btn-primary '>Update To Lead Sales Activity</a>
		</div>-->
		<div class="col-md-6">
		<!--<a href='javascript://' onclick="importInvitees()" class='btn btn-primary mrg5L'>Import Invitees</a>-->
		<a href='javascript://' onclick="addAllCompanyToLead(1)" class='btn btn-primary '>Update</a>
		</div>
		<div class="col-md-5">
		<input type='text' placeholder='Search...' id='search_field' style='height:24px;min-height:24px;padding:4px 6px; color:#2b2f33' name='search_field' class='form-control'/>
		</div>
		<div class="col-md-1"></div>
		</div>
		</div>
		<div class="col-md-9">
			<div class='row'>
				<div class='col-md-4'><select class="form-control" multiple='multiple' id="companySector" name="company[sector]"  style='float:left;'> 
				<option value="">Check All</option>
				<?php 
													$market_sectors = getAllMarketSectors();
													if(count($market_sectors)>0){
														foreach($market_sectors as $sector){
												?> <option value="<?php echo $sector->id;?>"><?php echo $sector->name;?></option> <?php
														}
													}
												?> </select></div>
				<div class='col-md-4'><select multiple='multiple' class="form-control" id="preferenceDepartments" name="preferences[departments][]" > <option value=''>Check All</option><option value="-1">Blank</option></select></div>
				<div class='col-md-4'><select multiple='multiple' class="form-control" id="subDepartments" name="sub[departments][]"><option value=''>Check All</option><option value="-1">Blank</option></select></div>
			</div>
		</div>
		<!--<div class="col-md-1">
			<a style='' href='javascript://' onclick="addSectorDepartments()" class='btn btn-primary btn-block mrg5R'>Update</a>
		</div>-->
		</div>
		<div class="row">
			<div class="col-sm-6 pull-right" style='margin-top:10px;'>
				<div class='form-group'>
					<select onchange="getNextRecords(jQuery(this));" id="noOfRecords" class='form-control' style='width:75px;'>
							<option value="50" selected="selected">50</option>
							<option value="100">100</option>
							<option value="150">150</option>
							<option value="200">200</option>
							<option value="250">250</option>
							<option value="300">300</option>
							<option value="350">350</option>
							<option value="400">400</option>
							<option value="450">450</option>
							<option value="500">500</option>
							<option value="0">All</option>
						</select>
				</div>
			</div>
		</div>
		<div class="scroll-container col-lg-12 cp-border">
			<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
		</div>
		
		<script>
		function importInvitees(){
			/*Find From Selection List thats are company and has contacts*/
			jQuery.ajax({
				type:'GET',
				url:__baseUrl+'/opportunity/get_company_list_from_invitees_contacts',
				dataType:'json',
				success:function(data){
					if(data.length>0){
						jQuery.each(data,function(index,c){
							_listingCompanyID = c.company_id;
							if(_companiesINString.length>0){
								jQuery.each(_companiesINString,function(ind,pC){
									if(pC.id==_listingCompanyID){
										_companiesINString[ind].selected = true;
										return false;
									}
								});
							}
						});
						hot1.loadData(_companiesINString);						
					}
				}
			})
		}
		
		var searchFiled = document.getElementById('search_field');
		var  _checkSECTOR = [];
		var company_table = document.getElementById('companies_box'),hot1;
		_companiesINString=[<?php
				$insertID = array();
				for ($i = 0; $i < count($companies); $i++) {
					if(!in_array((int)$companies[$i]->id,$insertID)):
					$insertID[] = (int)$companies[$i]->id;
					$selected = 'false';
					if($activity==1){
						if(count($selected_sales_companies)>0){
							foreach($selected_sales_companies as $sCompany){
								if($sCompany->id==$companies[$i]->id){
									$selected="true";
								}
							}
						}
					} else {
						if(count($selected_acquisition_companies)>0){
							foreach($selected_acquisition_companies as $sCompany){	
								if($sCompany->id==$companies[$i]->id){
									$selected="true";
								}
							}
						}
					}
					echo "{'id':". $companies[$i]->id.",'selected':'".$selected."','company_name':'" . addslashes($companies[$i]->company_name) . "','no_of_users':'" . count($companies[$i]->company_users) . "','sectors':'" . $companies[$i]->sectorName . "','categories':'" . $companies[$i]->department_names . "','sub_category':'" . $companies[$i]->sub_department_names . "'}";
					if ($i < count($companies) - 1) {
						echo ",";
					}
					endif;
				}
			?>];
			<?php 
				if(count($companies)>0){
					foreach($companies as $contact){							
			?>
				html = "<table class='table'><thead><tr><th>Name</th><th>Title</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
						<?php 
							if(count($contact->company_users)>0){
								for($i=0;$i<count($contact->company_users);$i++){
						?>
							html+="<tr>"+
								"<td><a href='javascript://' onclick='window.parent.editContact(<?php echo $contact->company_users[$i]->id;?>);'><?php $string = str_replace('"','',$contact->company_users[$i]->name);$string = str_replace('"','',$string); echo $string;?></a></td><td></td>"+
								"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\"<?php echo $contact->company_users[$i]->phone;?>\"))'><?php echo $contact->company_users[$i]->phone;?></a></td>"+
								"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\"<?php echo $contact->company_users[$i]->telephone;?>\"))'><?php echo $contact->company_users[$i]->telephone;?></a></td>"+
							"</tr>"; 
						<?php
								}  
							}
						?>
				html+="</tbody></table>";
				window.cUser[<?php echo $contact->id;?>] = html;
			<?php						
					}
				}
			?>
			
			__countAll =  0;
			__current_page_no = 0;
			__noOfPagesShow = 0;
			__no_of_records = 0;			
			function runPagination(){
				
			}
			
			var totalHeight = jQuery(window).height();
					var mainHeight = totalHeight - 130;
					var availableWidth = jQuery(window).width();
					availableWidth = availableWidth-20;
					jQuery('.scroll-container').css('height',mainHeight+'px');
					jQuery('#companies_box').css('width',availableWidth+'px');
					function highlightCol(instance, row, col, value, result) {
					/*Handsontable.Search.DEFAULT_CALLBACK.apply(this, arguments);
					
					_td = instance.getCell(row, col);
					if (result) {
						console.log("R:"+row+"C:"+col);
					  jQuery(_td).addClass('customClass');
					} else {
						jQuery(_td).removeClass('customClass');
					}*/
					return result;
				  }
		  jQuery(window).resize(function(){
			  var mainHeight = totalHeight - 130;
					var availableWidth = jQuery(window).width();
					availableWidth = availableWidth-20;
			  hot1.updateSettings({
				  width:function(){return availableWidth;},
				  height:function(){return mainHeight;},
			  })
			  hot1.render();			  
		  })
		  function implementCompanyTable(){
			  hot1 = new Handsontable(company_table, {
					data: _companiesINString,
					  autoWrapCol:true,
					  wordWrap:true,
					  rowHeaders: false,
					  colHeaders: ['#', 'Company', '#ofUsers','Sectors','Categories','SubCategories'],
					  minSpareRows: 0,
					  minSpareCols: 0,
					  manualColumnResize:true ,
					  minCols: 6,
					  maxCols: 6,
					  maxRows: _companiesINString.length,
					  width:function(){return availableWidth;},
					  height:function(){return mainHeight;},
					  fillHandle: false,
					  stretchH:"all",
					  colWidths:[30,150,70,150,250,250],
					  contextMenu: false,					 
					  columnSorting: {
						column: 1,
						sortOrder: true
					  },
					renderAllRows: true,
					filters: true,
					dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
					columns: [
					  {
						data:'selected',
						type: 'checkbox'
					  },
					  {
						data:'company_name',
						renderer: traignleICONRender,
						readOnly:true
					  },
					  {
						data:'no_of_users',
						readOnly: true
					  },
					  {
						data:'sectors',
						readOnly: true
					  },
					  {
						data:'categories',
						readOnly: true
					  },
					  {
						data:'sub_category',
						readOnly: true
					  }
					]
		  });	
		  runPagination();
		 }
		 implementCompanyTable();
		 function onlyExactMatch(queryStr, value) {
			 console.log(value);
			/*return queryStr.toString() === value.toString();*/
			return value.toString().toLowerCase().indexOf(queryStr.toLowerCase()) !== -1;
		  }
		 Handsontable.Dom.addEvent(company_table,'click',function(event){
			 console.log('ENTER CHECK UP');
			if (event.target.nodeName == 'INPUT' && event.target.type == 'checkbox') {
			   /*isChecked = !event.target.checked;*/
               fireEventOnClickCheckBox();
            } 
		 });
		  Handsontable.hooks.add('afterSelection', companySelectionCallBack, hot1);
		  
		
		  function companySelectionCallBack(r,c,r2,c2){
			  console.log("R:"+r+"c:"+c,"R2:"+r2+"C2:"+c2);
		  }
		 
		  function colorRender(instance, td, row, col, prop, value, cellProperties){
			  if(value!=''){
				jQuery(td).css('color','red').text(value);
			  } else {
				  jQuery(td).css('color','').text('');
			  }
			return td;
		  }
		  function traignleICONRender(instance, td, row, col, prop, value, cellProperties){
			  /*console.log('ROW:'+row+': VAL:'++'VALUE:'+value);*/
			  currentVal = instance.getDataAtRowProp(row,'id');
			  /*Handsontable.renderers.TextRenderer.apply(this, arguments);*/
			  Handsontable.Dom.empty(td);
			  td.innerHTML = "<a href='javascript://' onclick='findMyPeople(jQuery(this));' data-id='"+currentVal+"'><i class='glyph-icon icon-play' title='Companies'></i></a> <a href='javascript://' onclick='editGoogleContact("+currentVal+")'>"+value+"</a>";
			  if(jQuery("#search_field").val()!="" ){
				  console.log("Search...")
				   _v = value.toLowerCase();
				   _v1 = jQuery("#search_field").val();
				   _v1 = _v1.toLowerCase();
				   console.log("V!..."+_v1+" Item: "+_v);
				   if(_v.indexOf(_v1)>=0){
					   console.log("FOUND");
					   td.style.backgroundColor = 'yellow';
				   }
			   }
			  return td;
		  }
		  /*
			  */
		</script>
	</div>
</div>
<div class="modal modal-opened-header fade" id="modal_c_users" role="dialog" aria-labelledby="createContactModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="width:100%;z-index:999999">
	<div class="modal-dialog" style=''>
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-9px;margin-right:-5px;float:left;"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div style='max-height:300px;overflow-y:scroll' id="cUsers"></div>
			</div>
		<div class="modal-footer"></div>
		</div>
	</div>
</div>
<script> 
	__backSpace = "";
	function editGoogleContact(contactID){
		if(contactID>0){
			jQuery("#new_company").removeClass("show").addClass("hide");
			window.parent.openCompanyEdit(contactID);
		} else {
			alert("Please select contact first");
		}		
	}
allSelectedCompanies = [];

	function fireEventOnClickCheckBox(){
		setTimeout(function(){
			addAllCompanyToLead(0);
		},3000);
	}
	function addAllCompanyToLead(t){		
		var filter = hot1.getPlugin('Filters');
		 filter.clearFormulas();
		  filter.filter();
		  hot1.render();
		_getData = hot1.getData();
		if(_getData.length>0){
			_mainActivity = window.parent.jQuery('#activityMainType').val();
			_targetBody = "";
			activity = '<?php echo $activity;?>';		
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
		} else {
			alert('Please select company to assign with Lead');
		}		
	}


	function getDataContact(o,i,cName){
		_c = jQuery("#"+i).find("td").eq(1).text();
		_p = jQuery("#"+i).find("td").eq(2).text();
		_mainActivity = window.parent.jQuery('#activityMainType').val();
		_targetBody = "";
		activity = '<?php echo $activity;?>';		
		if(_mainActivity==1){
			_targetBody = "activityTable";
		} else if(_mainActivity==2) {
			_targetBody = "aquisitionTable";
		}		
		_flag=0;
		window.parent.jQuery("#"+_targetBody).find("tbody.main_active").find('tr.master').each(function(){
			if(jQuery(this).attr('data-c')==i){
				_flag = 1;
			}
		});
		if(parseInt(activity)==5){
			_flag = 1;
			assignBrokerToCompany(i);
		}
		if(_flag==0){
			if(_mainActivity==1){
				sendCompanyToInvitees(i);
			} else if(_mainActivity==2) {
				sendCompanyToAcquisition(i);
			}
			o.parents('tr').css('color','red');		
		}
	}
	
	function assignBrokerToCompany(){
		_getData = hot1.getSourceData();
		_companiesSelected = [];
		jQuery.each(_getData,function(i,c){
			if(c.selected==true || c.selected=='true'){
				_companiesSelected.push(c.id);
			}
		});
		if(_companiesSelected.length>0){
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl?>opportunity/assign_sales_company_to_broker',
				data:{broker_company:i,l:<?php echo $lead_id?>,companies:JSON.stringify(_companiesSelected)},
				cache:false,
				success:function(data){
					if(data>0){
						window.parent.refreshAcquisitionAndSalesActivity();
						window.parent.closeSlideBarLeftSales();
					} else {
						alert("Error!");
					}
				}
			})
		} else {
			alert('Please check checbox first in the list of activities.');
		}
	}
	
	function sendCompanyToInvitees(t){
		_getData = hot1.getSourceData();
		_companies = [];
		jQuery.each(_getData,function(i,c){
			if(c.selected==true || c.selected=='true'){
				_companies.push(c.id);
			}
		});
		if(_companies.length>0){
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl?>opportunity/invite_company',
				data:{company:JSON.stringify(_companies),l:<?php echo $lead_id?>},
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
		_getData = hot1.getSourceData();
		_companies = [];
		jQuery.each(_getData,function(i,c){
			if(c.selected==true || c.selected=='true'){
				_companies.push(c.id);
			}
		});
		if(_companies.length>0){
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl?>opportunity/acquisition_company',
				data:{company:JSON.stringify(_companies),l:<?php echo $lead_id?>},
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