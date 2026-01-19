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
body{font-family:arial}
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
</style>
<script>
	var ___table ;
	__baseUrl ='<?php echo $Layout->baseUrl?>';
	
	function loadMessage(message){
		jQuery("#loading_message").html(message);
	}
	
	function changeSelectors(selector){
		jQuery("#preferenceDepartments").find("option").remove();
		if(selector!=""){
			try{
				_sector = JSON.parse(selector);
				if(_sector.length>0){
					jQuery.ajax({
					type:"POST",
					url:__baseUrl+"opportunity/find_departments_bulk",
					data:{s:selector},
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
						creatingDropDownList(285,350,"Categories","preferenceDepartments",changeDepartments);
						_companiesINString = [];
						window.cUser = [];
						if(b.companies.length>0){
							_companies = b.companies
							for (i = 0; i < _companies.length; i++) {
								var comObj = {};
								comObj.id = _companies[i].id;
								comObj.company_name = _companies[i].company_name;
								_subType = _companies[i].department_names + _companies[i].sub_department_names;
								comObj.no_of_users = _companies[i].company_users.length;
								comObj.sectors = _companies[i].sectorName;
								comObj.categories = _subType;
								comObj.sub_category = _companies[i].sub_department_names;
								comObj.technolgies = _companies[i].technology_names;
								comObj.sub_technolgies = _companies[i].sub_technology_names;
								_companiesINString.push(comObj);
								html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
								_users = _companies[i].company_users;
								if(_users.length>0){
									for(j=0;j<_users.length;j++){
										_companyName = _users[j].name;
										_companyName.replace('"','');
										_companyName.replace('"','');
										html+="<tr>"+
										"<td><a href='javascript://' onclick='window.parent.editContact("+_users[j].id+");'>"+_companyName+"</a></td>";
										if(_users[j].phone!=""){
											html+="<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\""+_users[j].phone+"\"))'><i class='glyph-icon icon-phone' style='color:green' title='Companies'></i></a></td>"
										} else {
											html+="<td></td>";
										}
										if(_users[j].telephone!=""){
											html+="<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\""+_users[j].telephone+"\"))'><i class='glyph-icon icon-phone colorClass' title='Companies'></i></a></td>"+
										"</tr>";
										} else {
											html+="<td></td>";
										}										  
									}
								}								
								html+="</tbody></table>";
								window.cUser[_companies[i].id] = html;
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
					url:__baseUrl+"opportunity/find_sub_departments_bulk",
					data:{s:jQuery("#companySector").val(),d:selector,mode:typeMode},
					cache:false,
					dataType:'json',
					success:function(b){
						if(jQuery("#ddcl-subDepartments").length>0){
							jQuery("#subDepartments").dropdownchecklist("destroy");
						}
						jQuery("#subDepartments").append("<option value=''>Select All</option>");
						jQuery("#subDepartments").append("<option value='-1'>Blank</option>");
						if(b.deptt.length>0){							
							_deptt = b.deptt;
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
									_selectCategory.push(jQuery(this).text());
								}
							}
						});
						if(b.companies.length>0){
							_companies = b.companies
							for (i = 0; i < _companies.length; i++) {
								__subDeptt = _companies[i].department_names;
								__subDeptt = __subDeptt.split(',');
								_entry = false;
								if(__subDeptt.length>0){
									jQuery.each(__subDeptt,function(index,de){
										if(jQuery.inArray(de,_selectCategory)>=0){
											_entry = true;
											return false;
										}
									})
								}
								if(_entry===true){
								var comObj = {};
								_subType = _companies[i].department_names+_companies[i].sub_department_names;
								comObj.id = _companies[i].id;
								comObj.company_name = _companies[i].company_name;
								comObj.no_of_users = _companies[i].company_users.length;
								comObj.sectors = _companies[i].sectorName;
								comObj.categories = _subType;
								comObj.sub_category = _companies[i].sub_department_names;
								comObj.technolgies = _companies[i].technology_names;
								comObj.sub_technolgies = _companies[i].sub_technology_names;
								_companiesINString.push(comObj);
								html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
								_users = _companies[i].company_users;
								if(_users.length>0){
									for(j=0;j<_users.length;j++){
										_companyName = _users[j].name;
										_companyName.replace('"','');
										_companyName.replace('"','');
										html+="<tr>"+
										"<td><a href='javascript://' onclick='window.parent.editContact("+_users[j].id+");'>"+_companyName+"</a></td>";
										if(_users[j].phone!=""){
											html+="<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\""+_users[j].phone+"\"))'><i class='glyph-icon icon-phone' style='color:green' title='Companies'></i></a></td>"
										} else {
											html+="<td></td>";
										}
										if(_users[j].telephone!=""){
											html+="<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\""+_users[j].telephone+"\"))'><i class='glyph-icon icon-phone colorClass' title='Companies'></i></a></td>"+
										"</tr>";
										} else {
											html+="<td></td>";
										}
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
	function changeSubDepartments(selector){
		if(selector!=""){
			try{
				_sector = JSON.parse(selector);
				if(_sector.length>0){
					typeMode = 0;
					jQuery.ajax({
					type:"POST",
					url:__baseUrl+"opportunity/find_sub_sub_departments_bulk",
					data:{s:jQuery("#companySector").val(),dep:jQuery("#preferenceDepartments").val(),sub:selector},
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
									_selectSubCategory.push(jQuery(this).text());
								}
							}
						});
						
						if(b.companies.length>0){
							_companies = b.companies;
							for (i = 0; i < _companies.length; i++) {		
								__subDeptt = _companies[i].sub_department_names;
								__subDeptt = __subDeptt.split(',');
								_entry = false;
								if(__subDeptt.length>0){
									if(_selectSubCategory.length==1 && _selectSubCategory[0]=='-1' && _companies[i].sub_department_names==""){
										console.log('asdad1');
										_entry = true;
									} else {
										jQuery.each(__subDeptt,function(index,de){										
											if(jQuery.inArray(de,_selectSubCategory)>=0){
												console.log('asdad');
												_entry = true;
												return false;
											}
										})
									}
								}
								
								if(_entry===true && _companies[i].department_names!=''){
									var comObj = {};
									_subType = _companies[i].department_names+_companies[i].sub_department_names;
									comObj.id = _companies[i].id;
									comObj.company_name = _companies[i].company_name;
									comObj.no_of_users = _companies[i].company_users.length;
									comObj.sectors = _companies[i].sectorName;
									comObj.categories = _subType;
									comObj.sub_category = _companies[i].sub_department_names;
									comObj.technolgies = _companies[i].technology_names;
									comObj.sub_technolgies = _companies[i].sub_technology_names;
									_companiesINString.push(comObj);
									html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
									_users = _companies[i].company_users;
									if(_users.length>0){
										for(j=0;j<_users.length;j++){
											_companyName = _users[j].name;
											_companyName.replace('"','');
											_companyName.replace('"','');
											html+="<tr>"+
										"<td><a href='javascript://' onclick='window.parent.editContact("+_users[j].id+");'>"+_companyName+"</a></td>";
										if(_users[j].phone!=""){
											html+="<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\""+_users[j].phone+"\"))'><i class='glyph-icon icon-phone' style='color:green' title='Companies'></i></a></td>"
										} else {
											html+="<td></td>";
										}
										if(_users[j].telephone!=""){
											html+="<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\""+_users[j].telephone+"\"))'><i class='glyph-icon icon-phone colorClass' title='Companies'></i></a></td>"+
										"</tr>";
										} else {
											html+="<td></td>";
										} 
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
	jQuery(document).ready(function(){
		jQuery('#search_field').keypress(function (e) {
			var key = e.which;
			if(key == 13) {
				e.preventDefault();
				getNextRecords();
			}		  
		}); 
	});
	function getNextRecords(){
		insertID = [];
		p = jQuery("#noOfRecords").val();
		if(p==undefined){
			p = 50;
		}
		loadMessage("Loading..");
		_url = __baseUrl+'opportunity/companies/ajax/'+p;
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
							_subType = _companies[i].department_names + _companies[i].sub_department_names;
							comObj.id = _companies[i].id;
							comObj.selected = _selected;
							comObj.company_name = _companies[i].company_name;
							comObj.no_of_users = _companies[i].company_users.length;
							comObj.sectors = _companies[i].sectorName;
							comObj.categories = _subType;
							comObj.sub_category = _companies[i].sub_department_names;
							comObj.technolgies = _companies[i].technology_names;
							comObj.sub_technolgies = _companies[i].sub_technology_names;
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
										"<td><a href='javascript://' onclick='window.parent.editContact("+_users[j].id+");'>"+_companyName+"</a></td>";
										if(_users[j].phone!=""){
											html+="<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\""+_users[j].phone+"\"))'><i class='glyph-icon icon-phone' style='color:green' title='Companies'></i></a></td>"
										} else {
											html+="<td></td>";
										}
										if(_users[j].telephone!=""){
											html+="<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\""+_users[j].telephone+"\"))'><i class='glyph-icon icon-phone colorClass' title='Companies'></i></a></td>"+
										"</tr>";
										} else {
											html+="<td></td>";
										}  
								}
							}								
							html+="</tbody></table>";
							window.cUser[_companies[i].id] = html;
							}
						}
					}
				}
				hot1.destroy();
				jQuery('#companies_box').css('width',availableWidth+'px');
				implementCompanyTable(1);
			}
			});
	}
	jQuery(document).ready(function(){
		_h = window.parent.$(window).height() - 120;		
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

	window.resizeDataTable = function(height) {
		$('#datatable-company-sharing_wrapper .dataTables_scrollBody').height(height - 60);
	}

	$(function() {
		window.parent.open_ccompany_listResize();
	})
	
	function findMyPeople(o){
		jQuery("#cUsers").html(window.cUser[o.attr('data-id')]);
		jQuery("#modal_c_users").modal("show");
	}
	window.cUser = [];
	
	function addCompanyInBulk(){
		jQuery("#buttonADDBulk").addClass('hide').removeClass("show");
		jQuery("#addContactTask").removeClass('hide').addClass("show");
		frm = jQuery("#addCompanyBulk");
		jQuery.ajax({
			url:frm.attr("action"),
			type:'POST',
			data:frm.serializeArray(),
			cache:false,
			success:function(data){
				if(data>0){
					window.parent.document.getElementById("companyFormIframe").contentWindow.location.reload();
				} else{
					alert('Please try after sometime.');
					jQuery("#buttonADDBulk").removeClass('hide').addClass("show");
					jQuery("#addContactTask").addClass('hide').removeClass("show");
				}
			}
		});
	}
	_previous = "";
	sp=0;
	function checkSectorInThis(o){
		jQuery('#companySector').val('');
		sp=0;
		if(o.is(':checked')){
			_sectors = o.parents('tr').find('td').eq(3).text();
			if(_sectors!=""){
				jQuery('#companySector').find('option').each(function(){
					if(jQuery(this).text()==_sectors){
						if(_previous!="" && _previous!=_sectors){	
							sp = 1;
							jQuery('#companySector').val('');
						} else {
							_previous = _sectors;
							jQuery(this).prop('selected',true);
							checkSector(jQuery(this).attr('value'),0,o.val());
						}						
					}
				});
			}
		}else {
			if(jQuery('input[name="vendor_select_bulk[]"]:checked').length>0){
				jQuery('input[name="vendor_select_bulk[]"]:checked').each(function(){
					_sectors = o.parents('tr').find('td').eq(3).text();
					if(_sectors!=""){
						jQuery('#companySector').find('option').each(function(){
							if(jQuery(this).text()==_sectors){
								if(_previous!="" && _previous!=_sectors){	
									sp = 1;
									jQuery('#companySector').val('');
								} else {
									_previous = _sectors;
									jQuery(this).prop('selected',true);
									checkSector(jQuery(this).attr('value'),0,o.val());
								}						
							}
						});
					}
				});
			} else {
				_previous = "";
			}
		}
		if(sp==1){
			_previous = "";
			jQuery('#companySector').val('');
			jQuery("#preferenceDepartments").find("option").remove();
			jQuery("#subDepartments").find("option").remove();
			jQuery("#subDepartments").dropdownchecklist("destroy");
			jQuery("#subDepartments").dropdownchecklist({emptyText:"Sub Categories",maxDropHeight:220,width:160});
			jQuery("#preferenceDepartments").dropdownchecklist("destroy");
			jQuery("#preferenceDepartments").dropdownchecklist({emptyText:"Categories",maxDropHeight:220,width:160});
			alert('All companies not from same sector.');
		}
	}
	function checkSector(a,f,c){	
		if(typeof c=="undefined"){
			c = jQuery('input[name="vendor_select_bulk[]"]:checked').val();
		}
		if(sp==1){
			c = 0;
		}
	jQuery("#preferenceDepartments").find("option").remove();
	if(a>0){
		jQuery.ajax({
		type:"POST",url:__baseUrl+"customers/find_departments",
		data:{s:a,c:c},
		cache:false,
		success:function(b){
		if(b!=""){
			_data=jQuery.parseJSON(b);
			if(_data.dep.length>0){
				for(i=0;i<_data.dep.length;i++){
					_selected='';
					if(_data.c_d.length>0){
						for(cd=0;cd<_data.c_d.length;cd++){
							if(_data.c_d[cd].preference_id==_data.dep[i].id){
								_selected='selected="selected"';
							}
						}
					}
					jQuery("#preferenceDepartments").append("<option "+_selected+" value='"+_data.dep[i].id+"'>"+_data.dep[i].name+"</option>");
				}
				jQuery("#preferenceDepartments").dropdownchecklist("destroy");
				jQuery("#preferenceDepartments").dropdownchecklist({emptyText:"Categories",maxDropHeight:220,width:160});
				if(sp==0){
					console.log('asd');
					findMySubDeptt(jQuery("#preferenceDepartments"));
				}
			}
		}
		}
		});
	}
}

function findMySubDeptt(a){
	c = jQuery('input[name="vendor_select_bulk[]"]:checked').val();
	jQuery("#subDepartments").find("option").remove();
	if(sp==1){
			c = 0;
		}
	depList = [];
	a.find('option').each(function(){
		if(jQuery(this).is(':selected')){
			depList.push(jQuery(this).attr('value'));
		}
	});
	if(depList.length>0){
		jQuery.ajax({type:"POST",url:__baseUrl+"customers/find_sub_deptt_another",
		data:{s:JSON.stringify(depList),c:c},
		cache:false,success:function(b){
			if(b!=""){
				_data=jQuery.parseJSON(b);if(_data.dep.length>0){
					for(i=0;i<_data.dep.length;i++){
						_selected='';		
						if(_data.c_d.length>0){
							for(cd=0;cd<_data.c_d.length;cd++){
								if(_data.c_d[cd].preference_id==_data.dep[i].id){
									_selected='selected="selected"';
								}
							}
						}
						jQuery("#subDepartments").append("<option value='"+_data.dep[i].id+"' "+_selected+">"+_data.dep[i].name+"</option>")
					}
					jQuery("#subDepartments").dropdownchecklist("destroy");
					jQuery("#subDepartments").dropdownchecklist({emptyText:"Sub Categories",maxDropHeight:220,width:160});
				}
			}
		}
		});
	}
}
function addSectorDepartments(){
	_cList = [];
	_sector = "";
	_deptt = [];
	_subdeptt = [];
	jQuery('input[name="vendor_select_bulk[]"]:checked').each(function(){
		_cList.push(jQuery(this).val());
	});
	jQuery('#preferenceDepartments>option:selected').each(function(){
		_deptt.push(jQuery(this).attr('value'));
	});
	jQuery('#subDepartments>option:selected').each(function(){
		_subdeptt.push(jQuery(this).attr('value'));
	});
	_sector = jQuery('#companySector').val();
	jQuery.ajax({
		type:'POST',
		type:"POST",url:__baseUrl+"opportunity/contacts_bulk_sector_deptt",
		data:{c:JSON.stringify(_cList),s:_sector,d:JSON.stringify(_deptt),sc:JSON.stringify(_subdeptt)},
		cache:false,
		dataType:'json',
		success:function(b){
			if(b.data>0){
				window.location = window.location.href;				
			} else {
				alert("Problem in saving data");
				_previous = "";
				sp=0;
				jQuery('input[name="vendor_select_bulk[]"]').each(function(){
					jQuery(this).prop('checked',false);
				});
				jQuery('input[name="vendor_select_bulk[]"]').prop('checked',false);
				jQuery("#preferenceDepartments").find("option").remove();
				jQuery("#subDepartments").find("option").remove();
				jQuery("#subDepartments").dropdownchecklist("destroy");
				jQuery("#subDepartments").dropdownchecklist({emptyText:"Sub Categories",maxDropHeight:220,width:160});
				jQuery("#preferenceDepartments").dropdownchecklist("destroy");
				jQuery("#preferenceDepartments").dropdownchecklist({emptyText:"Categories",maxDropHeight:220,width:160});
			}
		}
	});
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
.htCore, .handsontable{font-family:arial;font-size:13px;}
</style>
<h4>Companies <span id='loading_message' style='margin-left:100px'></span></h4>
<div class="row">	
	<div class="col-md-12">		
		<div class="row">
		<div class="col-md-1" style=''><a style='' href='javascript://' onclick="openAddForm()" class='btn btn-primary btn-block mrg5R'>Add a Company</a></div>
		<?php if($this->session->userdata['type']=='9'):?>
		<div class="col-md-1" style=''><a style='' href='javascript://' onclick="deleteGoogleContact()" class='btn btn-primary btn-block'>Delete</a>		</div>
		<div class="col-md-2">
		<input type='text' placeholder='Search...' id='search_field' style='height:24px;min-height:24px;width:94%;padding:4px 6px; color:#2b2f33' name='search_field' class='form-control'/>
		</div>
		<div class="col-md-7">
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
		<div class="col-md-1">
			<a style='' href='javascript://' onclick="addSectorDepartments()" class='btn btn-primary btn-block mrg5R'>Update</a>
		</div>
		<?php endif;?>
		</div>
		<div class="row">
			<div class="col-sm-6 pull-right" style='margin-top:10px;'>
				<div class='form-group'>
					<select onchange="getNextRecords();" id="noOfRecords" class='form-control' style='width:75px;'>
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
		var company_table = document.getElementById('companies_box'),hot1;
		_companiesINString=[<?php
				for ($i = 0; $i < count($companies); $i++) {
					$subType = $companies[$i]->department_names.$companies[$i]->sub_department_names;
					echo "{'id':". $companies[$i]->id.",'company_name':'" . addslashes($companies[$i]->company_name) . "','no_of_users':'" . count($companies[$i]->company_users) . "','sectors':'" . $companies[$i]->sectorName . "','categories':'" . $subType . "','sub_category':'" . $companies[$i]->sub_department_names . "','technolgies':'" . $companies[$i]->technology_names . "','sub_technolgies':'" . $companies[$i]->sub_technology_names . "'}";
					if ($i < count($companies) - 1) {
						echo ",";
					}
				}
			?>];
			<?php 
				if(count($companies)>0){
					foreach($companies as $contact){							
			?>
				html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
						<?php 
							if(count($contact->company_users)>0){
								for($i=0;$i<count($contact->company_users);$i++){
						?>
							html+="<tr>"+
								"<td><a href='javascript://' onclick='window.parent.editContact(<?php echo $contact->company_users[$i]->id;?>);'><?php $string = str_replace('"','',$contact->company_users[$i]->name);$string = str_replace('"','',$string); echo $string;?></a></td>"+
								"<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\"<?php echo $contact->company_users[$i]->phone;?>\"))'><i class='fa fa-phone' style='color:green' title='Companies'></i></a></td>"+
								"<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\"<?php echo $contact->company_users[$i]->telephone;?>\"))'><i class='fa fa-phone' style='color:#1E88E5 !important' title='Companies'></i><?php echo $contact->company_users[$i]->telephone;?></a></td>"+
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
			var totalHeight = jQuery(window).height();
					var mainHeight = totalHeight - 165;
					var availableWidth = jQuery(window).width();
					availableWidth = availableWidth-20;
					console.log(availableWidth);
					jQuery('.scroll-container').css('height',mainHeight+'px');
					/*jQuery('#companies_box').css('width',availableWidth+'px');*/
		 function implementCompanyTable(){
			  hot1 = new Handsontable(company_table, {
					data: _companiesINString,
					  autoWrapCol:true,
					  wordWrap:true,
					  rowHeaders: false,
					  colHeaders: ['#', 'Company', '#ofUsers','Type','Sub Type','Technologies','Sub Technologies'],
					  minSpareRows: 0,
					  minSpareCols: 0,
					  manualColumnResize:true ,
					  minCols: 6,
					  maxCols: 6,
					  maxRows: _companiesINString.length,
					  width:function(){console.log(availableWidth);return availableWidth;},
					  height:function(){return mainHeight;},
					  fillHandle: false,
					  stretchH:"all",
					  colWidths:[30,150,70,150,250,250,250],
					  contextMenu: false,
					  columnSorting: {
						column: 1,
						sortOrder: true
					  },
					filters: true,
					dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
					columns: [
					  {
						data:'id',
						renderer: checkboxRender,
						readOnly: true
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
						data:'technolgies',
						readOnly: true
					  },
					  {
						data:'sub_technolgies',
						readOnly: true
					  }
					]
		  });	
		 }
		 implementCompanyTable();
		  Handsontable.hooks.add('afterSelection', companySelectionCallBack, hot1);
		  /*availableWidth = availableWidth-60;*/
		 /* setTimeout(function(){
			  jQuery('.wtHider').css('width',availableWidth+'px');
			  jQuery('.scroll-container').append('<style>.wtHider{width:'+availableWidth+'px !important}</style>');
		  },400);
		  jQuery('.htCore').css('width',availableWidth+'px');*/
		  function companySelectionCallBack(r,c,r2,c2){
			  console.log("R:"+r+"c:"+c,"R2:"+r2+"C2:"+c2);
		  }
		  function checkboxRender(instance, td, row, col, prop, value, cellProperties) {
			var  check;
			  check = document.createElement('input');
			  check.type = 'checkbox';
			  check.name = 'vendor_select_bulk[]';
			  check.setAttribute('value',value);
			   
			  Handsontable.Dom.addEvent(check, 'click', function (e){
				  checkSectorInThis(jQuery(this));
			  });
			  Handsontable.Dom.empty(td);
			  td.appendChild(check);
			return td;
		  }
		  function traignleICONRender(instance, td, row, col, prop, value, cellProperties){
			  /*console.log('ROW:'+row+': VAL:'++'VALUE:'+value);*/
			  currentVal = instance.getDataAtRowProp(row,'id');
			  /*Handsontable.renderers.TextRenderer.apply(this, arguments);*/
			  Handsontable.Dom.empty(td);
			  td.innerHTML = "<a href='javascript://' onclick='findMyPeople(jQuery(this));' data-id='"+currentVal+"'><i class='glyph-icon icon-play' title='Companies'></i></a> <a href='javascript://' onclick='editGoogleContact("+currentVal+")'>"+value+"</a>";
			  return td;
		  }
		  /*
			  */
		</script>		
		<!--<div class='col-lg-12 hide' id='bulk_company'>
			<div class="col-xs-12">
				<?php echo form_open('opportunity/addCompanyBulk',array('id'=>'addCompanyBulk','class'=>'form-flat'));?>
				<div class="row"> <div class="col-xs-12"> <div class="form-group input-string-group"> <label class="control-label">List of Companies:</label> <textarea name="company[list]" id="companyList" class="form-control" style="width: 692px;height:400px; text-align: left;"></textarea> </div> </div> </div>
				<div class="mrg5T"> <button type="button" onclick="addCompanyInBulk()" id="buttonADDBulk" class="btn btn-primary btn-mwidth">Save</button> <img src="<?php echo $Layout->aws_server_cdn?>images/ajax-loader.gif" class='hide' alt="" id="addContactTask" > </div>
				<?php echo form_close();?>
			</div>
		</div>-->
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
	function openAddForm(){
		window.parent.openCompanyEdit(0);
	}
	function deleteGoogleContact(){
		if(jQuery("input[name='vendor_select']").is(":checked")){
			contactID = jQuery("input[name='vendor_select']:checked").val();
			res = confirm("Are you sure?");
			if(res){
				jQuery.ajax({
					type:'POST',
					url:'<?php echo $this->config->base_url();?>opportunity/deleteCompany',
					data:{delete_link:contactID},
					cache:false,
					success:function(data){
						window.location = window.location.href;						
					}
				});
			}
		} else {
			if(jQuery("input[name='vendor_select_bulk[]']:checked").length>0){
				contactID = "";
				jQuery("input[name='vendor_select_bulk[]']:checked").each(function(){
					contactID += jQuery(this).val()+',';
				});
				contactID =contactID.substring(0,contactID.length-1);
				res = confirm("Are you sure?");
				if(res){
					jQuery.ajax({
						type:'POST',
						url:'<?php echo $this->config->base_url();?>opportunity/deleteCompanyInBulk',
						data:{delete_link:contactID},
						cache:false,
						success:function(data){
							window.location = window.location.href;						
						}
					});
				}
			} else {
				alert("Please select contact first");
			}
		}
	}
	
	function editGoogleContact(contactID){
		if(contactID>0){
			jQuery("#new_company").removeClass("show").addClass("hide");
			window.parent.openCompanyEdit(contactID);			
		} else {
			alert("Please select contact first");
		}		
	}

	function refreshContactTableHeader() {
		$('#datatable-contacts-sharing_wrapper .sorting_asc, #datatable-contacts-sharing_wrapper .sorting_desc').trigger('click');
		setTimeout(function() {
			$('#datatable-contacts-sharing_wrapper .sorting_asc, #datatable-contacts-sharing_wrapper .sorting_desc').trigger('click');
		}, 300);
	}
</script>