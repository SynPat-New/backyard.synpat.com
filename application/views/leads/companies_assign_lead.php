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
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/dropdowncheck/src/ui.dropdownchecklist.standalone.css">
<script src="<?php echo $Layout->aws_server_cdn;?>widgets/dropdowncheck/js/ui.dropdownchecklist-1.4-min.js"></script>
<style>
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
} 
</style>
<script>
	var ___table ;
	__baseUrl ='<?php echo $Layout->baseUrl?>';
	jQuery(document).ready(function(){
		_h = window.parent.$(window).height() - 120;		
		 $("#preferenceDepartments").dropdownchecklist({emptyText:"Categories",maxDropHeight:220,width:160});
		 $("#subDepartments").dropdownchecklist({emptyText:"Sub Categories",maxDropHeight:220,width:160});
		 /*$("#s1").dropdownchecklist("refresh");*/
	});


	window.resizeDataTable = function(height) {
		$('#datatable-company-sharing_wrapper .dataTables_scrollBody').height(height - 60);
	}

	$(function() {
		window.parent.open_ccompany_listResize();
	})
	
	function findMyPeople(o){
		/*jQuery('.companyUsers').removeClass('show').addClass('hide');
		jQuery("#company-"+o.attr('data-id')).removeClass('hide').addClass('show');*/
		jQuery("#cUsers").html(window.cUser[o.attr('data-id')]);

		jQuery("#modal_c_users").modal("show");
	}
	window.cUser = [];
_initial = 0;
	_oldHtmlBody = "";
	function findCompaniesInLead(o){
		if(jQuery('input[name="contact_id[]"]').is(':checked')===false){
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'leads/findSalesCompaniesInLead',
				data:{l:o},
				cache:false,
				success:function(data){
					_companiesINString = [];
					window.cUser = [];
					_data = jQuery.parseJSON(data);
					if(_data.length>0){
						for(i=0;i<_data.length;i++){
							innerData = {};
							innerData.id = _data[i].id;
							innerData.company_name = _data[i].company_name;
							innerData.no_of_users = _data[i].company_users.length;
							innerData.sectors = _data[i].sectorName;
							innerData.categories = _data[i].department_names;
							innerData.sub_category = _data[i].sub_department_names;
							_companiesINString.push(innerData);
							html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
							if(_data[i].company_users.length>0){
								for(u=0;u<_data[i].company_users.length;u++){
									html+="<tr>"+
										"<td><a href='javascript://' onclick='window.parent.editContact("+_data[i].company_users[u].id+");'>"+_data[i].company_users[u].name+"</a></td>"+
										"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_data[i].company_users[u].phone+"\"))'>"+_data[i].company_users[u].phone+"</a></td>"+
										"<td><a href='javascript://' onclick='callFromLandline(encodeURIComponent(\""+_data[i].company_users[u].telephone+"\"))'>"+_data[i].company_users[u].telephone+"</a></td>"+
									"</tr>"; 
								}
							}
							html+="</tbody></table>";
							window.cUser[_data[i].id] = html;	
						}
					}
					hot1.loadData(_companiesINString);
				}
			});
		}
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
<h4>Leads Activties</h4>
<div class="row">	
	<div class="col-xs-12">		
		<div class="row" style='margin-bottom:10px;'>
<?php 
	$leads = allActiveLeads(); 
?>
<div class='col-xs-12'><p>To add companies to a lead's sales activities: 1) select the companies to be added and then select the lead here: <select class="" id="leadId" class="form-control" style='width:150px;'  onchange="findCompaniesInLead(jQuery(this).val());"><?php 												
												if(count($leads)>0){
												?>
												<option value='0'></option>
												<?php
													foreach($leads as $lead){
											?> <option value="<?php echo $lead->id;?>"><?php echo $lead->lead_name;?></option> <?php
													}
												}
											?> </select> then click <a style='width:100px;display:inline-block;' href='javascript://' onclick="importCompaniesToLead()" class='btn btn-primary btn-block mrg5R'>Import to lead</a><br/>To view the companies included in a lead's sales activities, select the lead from the drop-down list above.</p></div>
		
</div>
		
		<div class="scroll-container col-lg-12 cp-border">
			<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
		</div>
		
		<script>
		_companiesINString = '<?php echo json_encode($companies)?>';
		var company_table = document.getElementById('companies_box'),hot1;
		_companiesINString=[<?php
				for ($i = 0; $i < count($companies); $i++) {
					echo "{'id':". $companies[$i]->id.",'company_name':'" . $companies[$i]->company_name . "','no_of_users':'" . count($companies[$i]->company_users) . "','sectors':'" . $companies[$i]->sectorName . "','categories':'" . $companies[$i]->department_names . "','sub_category':'" . $companies[$i]->sub_department_names . "'}";
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
			var totalHeight = jQuery(window).height();
					var mainHeight = totalHeight - 100;
					var availableWidth = jQuery(window).width();
					jQuery('.scroll-container').css('height',mainHeight+'px');
					jQuery('#companies_box').css('width',availableWidth+'px');
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
					  maxRows: <?php echo count($companies)?>,
					  width:function(){return availableWidth;},
					  fillHandle: false,
					  stretchH:"all",
					  colWidths:[30,150,70,150,250,250],
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
						data:'sub_category',
						readOnly: true
					  }
					]
		  });	
		  Handsontable.hooks.add('afterSelection', companySelectionCallBack, hot1);
		  availableWidth = availableWidth-60;
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
			  check.name = 'contact_id[]';
			  check.setAttribute('value',value);			   
			  /*Handsontable.Dom.addEvent(check, 'click', function (e){
				  checkSectorInThis(jQuery(this));
			  });*/
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
				<div class="mrg5T"> <button type="button" onclick="addCompanyInBulk()" id="buttonADDBulk" class="btn btn-primary btn-mwidth">Save</button> <img src="http://backyard.synpat.com/public/images/ajax-loader.gif" class='hide' alt="" id="addContactTask" > </div>
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
	function importCompaniesToLead(){
	if(jQuery("#leadId").val()>0){
		companies=[];
		jQuery("input[name='contact_id[]']:checked").each(function(){
			_parent = jQuery(this).parents('tr');
			companies.push(_parent.find('td').eq(1).find('a').data('id'));
		});
		if(companies.length>0){
			jQuery.ajax({type:'POST',url:__baseUrl+'opportunity/invitees_in_bulk',data:{companies:JSON.stringify(companies),lead_id:jQuery("#leadId").val()},cache:false,success:function(d){jQuery("input[name='contact_id[]']:checked").prop('checked',false);if(d>0){alert("Compnies added to sales activity");}}});
		} else {
			alert("Please select checkbox to add companies");
		}
	} else {
		alert("Please select lead to add companies.");
	}
}
	
	
	function editGoogleContact(contactID){
		if(contactID>0){
			jQuery("#new_company").removeClass("show").addClass("hide");
			/*contactID = jQuery("input[name='vendor_select']:checked").val();*/
			jQuery.ajax({
			type:'POST',
			url:'<?php echo $this->config->base_url();?>opportunity/findCompany',
			data:{edit_link:contactID},
			cache:false,
			success:function(data){
				_data = jQuery.parseJSON(data);
				__backSpace = _data;
				if(typeof(_data.company_name)!="undefined"){
					window.parent.jQuery("#ccompanyFormSubmit").get(0).reset();
					window.parent.jQuery("#companyBroker").val(_data.broker);
					if(_data.broker_details.first_name!=undefined){
						window.parent.jQuery("#companyBrokerName").val(_data.broker_details.first_name+' '+_data.broker_details.last_name);
						window.parent.jQuery("#companyBrokerFirm").val(_data.broker_details.company_name);
					}					
					window.parent.jQuery("#company_users_show_table").empty();
					window.parent.jQuery("#companyJobTitle").val(_data.company_name);
					window.parent.jQuery("#companyTelephone").val(_data.telephone);
					window.parent.jQuery("#companyEmail").val(_data.email);
					window.parent.jQuery("#companyWebAddress").val(_data.web_address);	
					window.parent.jQuery("#companyStreet").val(_data.street);
					window.parent.jQuery("#companyStreet").val(_data.city);
					window.parent.jQuery("#companyState").val(_data.state);
					window.parent.jQuery("#companyZip").val(_data.zip);
					window.parent.jQuery("#companyCountry").val(_data.country);
					if(parseInt(_data.contractor)==1){
						window.parent.jQuery("#companyContractor").prop('checked',true);
					}
					window.parent.jQuery("#companyId").val(_data.id);	
					window.parent.jQuery("#companySector").val(_data.sectorID);	
					window.parent.checkSector(_data.sectorID,1);
					if(_data.companyUsers.length>0){
						_table = jQuery("<table/>").addClass('table');
						_thead = jQuery("<thead/>");
						_tr = jQuery("<tr/>");
						jQuery(_tr).append("<th>Name</th>");
						jQuery(_tr).append("<th>Work Phone</th>");
						jQuery(_tr).append("<th>Mobile Phone</th>");
						jQuery(_thead).append(_tr);
						jQuery(_table).append(_thead);
						_tbody = jQuery("<tbody/>");
						for(u=0;u<_data.companyUsers.length;u++){
							_tr = jQuery("<tr/>");
							jQuery(_tr).append("<td>"+_data.companyUsers[u].name+"</td>");
							jQuery(_tr).append("<td>"+_data.companyUsers[u].phone+"</td>");
							jQuery(_tr).append("<td>"+_data.companyUsers[u].telephone+"</td>");
							jQuery(_tbody).append(_tr);
						}
						jQuery(_table).append(_tbody);
						window.parent.jQuery("#company_users_show_table").css({height:'250px',overflowY:'scroll'}).append(_table);
					}
					window.parent.jQuery(".multi-select").multiSelect('refresh');
					window.parent.jQuery(".ms-container").append('<i class="glyph-icon icon-exchange"></i>');
					window.parent.jQuery("#addCCompanyForm").css('z-index','9999');
					window.parent.jQuery("#addCCompanyForm").modal("show");
				}
			} 
			});
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