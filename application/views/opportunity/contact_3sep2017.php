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
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/dropdowncheck/css/ui.dropdownchecklist.standalone.css">
<script src="<?php echo $Layout->aws_server_cdn;?>widgets/dropdowncheck/js/ui.dropdownchecklist-1.4-min.js"></script>

<style>
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;font-family:arial;font-size:13px;
	}
	#page-content {
	    background: #ffffff !important;
	}
	
	a{text-decoration:none;}h4{font-size:16px;font-weight:300;margin:0}
	
	.mrg5R{margin-right:5px;}
	.scroll-container {
	width: 100%;
	height: 250px;
	margin: 5px 0 1rem;
	overflow: hidden;
}
.htCore, .handsontable{font-family:arial;font-size:13px;}
.handsontable .htDimmed{color:#222222}
.ui-dropdownchecklist{z-index:9999999999999999999999 !important;}
</style>
<script>
	var ___table ;
	jQuery(document).ready(function(){
		creatingDropDownList(285,350,"Sectors","companySector",changeSelectors);
		creatingDropDownList(285,350,"Categories","preferenceDepartments",changeDepartments);
		creatingDropDownList(285,350,"Sub Categories","subDepartments",changeSubDepartments);
		jQuery('#search_field').keypress(function (e) {
			var key = e.which;
			if(key == 13) {
				e.preventDefault();
				callNewRecords();
			}		  
		});
	});
	function changeSelectors(selector){
		jQuery("#preferenceDepartments").find("option").remove();
		console.log(selector);
		if(selector!=""){
			try{
				_sector = JSON.parse(selector);
				if(_sector.length>0){
					jQuery("#noOfRecords").val(50);
					callNewRecords(1);
				}
			}catch(e){}
		}
	}
	function changeDepartments(selector){
		jQuery("#subDepartments").find("option").remove();
		console.log(selector);
		if(selector!=""){
			try{
				_sector = JSON.parse(selector);
				if(_sector.length>0){
					console.log("aa");
					jQuery("#noOfRecords").val(50);
					callNewRecords(2);
				}
			}catch(e){}
		}
	}
	function changeSubDepartments(selector){
		if(selector!=""){
			try{
				_sector = JSON.parse(selector);
				if(_sector.length>0){
					jQuery("#noOfRecords").val(50);
					callNewRecords();
				}
			}catch(e){}
		}
	}
	function getNextRecords(){
		callNewRecords();
	}
	function loadMessage(message){
		jQuery("#loading_message").html(message);
	}
	__baseUrl='<?php echo $Layout->baseUrl?>';
	function callNewRecords(t){
		console.log('as');
		p = jQuery("#noOfRecords").val();
		if(p==""){
			p = 50;
		}
		isChecked = false;
		_url = __baseUrl+'opportunity/contact/ajax/'+p;
		console.log(_url);
		loadMessage("Loading..");
		jQuery.ajax({
			type:"POST",
			url:_url,
			data:{search:jQuery('#search_field').val(),s:jQuery("#companySector").val(),dep:jQuery("#preferenceDepartments").val(),sub:jQuery("#subDepartments").val()},
			cache:false,
			dataType:'json',
			success:function(b){
				loadMessage("");
				_companiesINString=[];
				if(typeof t!="undefined"){
					if(t==1){
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
					} else if(t==2){
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
					}
				}
				
				if(typeof b.contacts!="undefined" && b.contacts.length>0){
					_data = b.contacts;
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
					for(i=0;i<_data.length;i++){
						_entry = false;
						if(typeof t!="undefined" && t=="2"){
							__subDeptt = _data[i].sub_department_names;
							__subDeptt = __subDeptt.split(',');
							if(__subDeptt.length>0 ){
								if(_selectSubCategory.length==1 && _selectSubCategory[0]=='-1' && _data[i].sub_department_names==""){
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
						} else {
							_entry = true;
						}
						
						if(_entry===true){	
							name = _data[i].first_name+' '+_data[i].last_name;
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
							
							object = {};
							name = _data[i].first_name+' '+_data[i].last_name;
							object.id = _data[i].id;
							object.first_name = jQuery.trim(_data[i].first_name);
							object.last_name = jQuery.trim(_data[i].last_name);
							object.name = jQuery.trim(name);
							object.company_name = _data[i].company_name;
							object.gateway = _data[i].gateway;
							object.title = _data[i].job_title;
							object.email = _data[i].email;
							object.phone = _data[i].phone;
							object.telephone = _data[i].telephone;
							object.linkedin_url = _data[i].linkedin_url;
							_note = _data[i].note;
							_note = _note.toString();
							_note = _note.replace('\n',' ');
							_note = _note.replace('\r',' ');
							_note = _note.replace('\\r',' ');
							_note = _note.replace('\\n',' ');
							_date = _data[i].system_update;
							if(_date!="0000-00-00 00:00:00"){
								_date = moment(new Date(_date)).format('MM/DD/YYYY');
							} else {
								_date = '';
							}	
							_subType = _categories + _sub_categories;
							object.note = _note;
							object.sectors = _sectorName;
							object.categories = _subType;
							object.sub_category = _sub_categories;
							object.technolgies = _data[i].technology_names;
							object.sub_technolgies = _data[i].sub_technology_names;
							object.selected = "no";
							object.system_date = _date;
							_companiesINString.push(object);
						}
					}
				} 
				hot1.destroy();
				jQuery('#companies_box').css('width',availableWidth+'px');
				implementCompanyTable(1);	
			}
		});
	}
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
	_initial = 0;
	_oldHtmlBody = "";
	function findCompaniesInLead(o){
		isChecked = false;
		if(o!=""){
			loadMessage("Loading..");
			jQuery.ajax({
				type:'POST',
				url:__baseUrl+'leads/findSalesCompaniesPeopleInLead',
				data:{l:o},
				cache:false,
				success:function(data){
					loadMessage("");
					_tbody = "";
					_data = jQuery.parseJSON(data);
					_companiesINString=[];
					if(_data.length>0){
						for(i=0;i<_data.length;i++){
							object = {};
							name = _data[i].first_name+' '+_data[i].last_name;
							object.id = _data[i].id;
							object.first_name = jQuery.trim(_data[i].first_name);
							object.last_name = jQuery.trim(_data[i].last_name);
							object.name = jQuery.trim(name);
							object.company_name = _data[i].company_name;
							object.gateway = _data[i].gateway;
							object.title = _data[i].job_title;
							object.email = _data[i].email;
							object.phone = _data[i].phone;
							object.telephone = _data[i].telephone;
							object.linkedin_url = _data[i].linkedin_url;
							_note = _data[i].note;
							_note = _note.toString();
							_note = _note.replace('\n',' ');
							_note = _note.replace('\r',' ');
							_note = _note.replace('\\r',' ');
							_note = _note.replace('\\n',' ');
							_date = _data[i].system_update;
							if(_date!="0000-00-00 00:00:00"){
								_date = moment(new Date(_date)).format('MM/DD/YYYY');
							} else {
								_date = '';
							}							
							object.note = _note;
							object.sectors = _data[i].sectorName;
							object.categories = '';
							object.sub_category = '';
							object.selected = "no";
							object.system_date = _date;
							_companiesINString.push(object);
						} 
					}
					hot1.destroy();
					jQuery('#companies_box').css('width',availableWidth+'px');
					implementCompanyTable(1);
				}
			});
		} else {
			hot1.destroy();
			jQuery('#companies_box').css('width',availableWidth+'px');
			implementCompanyTable(1);
		}
	}	
</script>
<h4>Contacts  <span id='loading_message' style='margin-left:100px'></span></h4>
<div class="row" style='width:100%;'>	
	<div class="col-xs-12" style='width:100%;'>		
		<div class="row" style='margin-bottom:10px;'>
		<div class="col-xs-10" style=''>
		<a style='' href='javascript://' onclick="window.parent.openCContact()" class='btn btn-primary pull-left mrg5R'>Companies</a>
		<!--<a style='' href='javascript://' onclick="window.parent.openLeadAssign()" class='btn btn-primary pull-left mrg5R'>Leads</a>-->
		<a style='' href='javascript://' onclick="window.parent.openPreCompanies()" class='btn btn-primary pull-left mrg5R'>Search For New Contacts</a>
		<a style='' href='javascript://' onclick="window.parent.openPreContacts()" class='btn btn-primary pull-left mrg5R'>Import Contacts</a>
		<a style='' href='javascript://' onclick="openAddForm()" class='btn btn-primary pull-left mrg5R'>Add Contact</a>
		<a style='' href='javascript://' onclick="deleteSelectedContacts()" class='btn btn-primary pull-left mrg5R'>Delete Contacts</a>
		<?php if($this->session->userdata['type']=='9'):?>
		<!--<a style='' href='javascript://' onclick="deleteGoogleContact()" class='btn btn-primary  pull-left mrg5R'>Delete</a>-->
		<?php endif;?>
		<a style='' href='javascript://' onclick="getFillHoleContacts()" class='btn btn-primary pull-left mrg5R'>Fill Holes</a>
		<a style='' href='javascript://' onclick="window.parent.openPreContactsWithRetrieve()" class='btn btn-primary pull-left mrg5R'>Pre Contacts</a>
		<a style='' href='javascript://' onclick="window.parent.updateFromDataFills()" class='btn btn-primary pull-left mrg5R'>Update from Datafills</a>
		<a style='' href='javascript://' onclick="window.parent.scannedBusinessCard()" class='btn btn-primary pull-left mrg5R'>Scanned Business Cards</a>
		</div>
		<div class="col-xs-2">
			<div class="form-group input-string-group" style='border:0px;'>
				<select name="profile[lead]" id="profileLead" class="form-control" onchange="findCompaniesInLead(jQuery(this).val());">
					<option value="">-- Select Lead --</option>
					<?php 
						$leads = findIncompleteANDCompleteList();
						if(count($leads)>0){
							foreach($leads as $lea){								
					?>
							<option value="<?php echo $lea->id?>"><?php echo $lea->lead_name;?></option>
					<?php
							}
						}
					?>
				</select>
			</div>
		</div>
		</div>
		<div class='row'>
			<div class="col-md-12">
				<div class='row'>
					<div class="col-md-3">
					<div class="col-md-3">
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
					<div class='col-md-8'>
						<input type='text' placeholder='Search...' id='search_field' style='height:24px;min-height:24px;padding:4px 6px; color:#2b2f33' name='search_field' class='form-control'/>
					</div>
					<div class='col-md-1'></div>
					</div>
					<div class='col-md-9'>
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
			</div>
		</div>
		<div class="col-lg-12" id='selected_contacts'>Selected:0</div>
		<div class="scroll-container col-lg-12 cp-border">
			<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
		</div>
		<script>
		var company_table = document.getElementById('companies_box'),hot1,isChecked;
		_companiesINString = [];
		_companiesINString=[<?php
				if(count($contacts)>0){
					$i=0;
					foreach($contacts as $contact){				
						$name = trim($contact->first_name." ".$contact->last_name);
						$systemDate = $contact->system_update;
						if($systemDate!="0000-00-00 00:00:00"){$systemDate = date('m/d/Y',strtotime($systemDate));} else {$systemDate = '';}
						$subType = $contact->department_names.$contact->sub_department_names;
					echo "{'id':". $contact->id.",'first_name':'".preg_replace('/\s+/', '', $contact->first_name)."','last_name':'".preg_replace('/\s+/', '', $contact->last_name). "','name':'".$name."','title':'" . addslashes($contact->job_title) . "','company_name':'" . addslashes($contact->company_name) . "','email':'" . $contact->email . "','phone':'" . $contact->phone . "','telephone':'" . $contact->telephone . "','linkedin_url':'" . $contact->linkedin_url . "','note':'" . str_replace(array("\\r\\n","\r","\n")," ", $contact->note) . "','sectors':'" . $contact->sectorName . "','categories':'" . $subType . "','sub_category':'','gateway':'" . $contact->gateway . "','selected':'no','system_date':'".$systemDate."','technolgies':'" . $contact->technology_names . "','sub_technolgies':'" . $contact->sub_technology_names . "'}";
					if ($i < count($contacts) - 1) {
						echo ",";
					}
					}
				}
			?>];
			/*
					  columnSorting: {
						column: 1,
						sortOrder: true
					  },*/
			var totalHeight = jQuery(window).height();
			var mainHeight = totalHeight - 220;
			var availableWidth = jQuery(window).width();
			availableWidth = availableWidth-20;
			jQuery('.scroll-container').css('height',mainHeight+'px');
			function implementCompanyTable(){
			  hot1 = new Handsontable(company_table, {
					data: _companiesINString,
					  autoWrapCol:true,
					  wordWrap:true,
					  rowHeaders: false,
					  minSpareRows: 0,
					  minSpareCols: 0,
					  manualColumnResize:true ,
					  minCols: 12,
					  maxCols: 12,
					  maxRows: _companiesINString.length,
					  width:function(){console.log(availableWidth);return availableWidth;},
					  height:function(){return mainHeight;},
					  fillHandle: false,
					  stretchH:"all",
					  colWidths:[35,110,30,20,20,150,120,150,100,100,100,100,50],
					  colHeaders:function(col){
						  var txt='';
						  switch(col){
							  case 0:
								txt = "# <input type='checkbox' class='checker' ";
								txt += isChecked ? 'checked="checked"' : '';
								txt += ">";
							  break;
							  case 1:
								txt ='Name';
							  break;
							  case 2:
								txt ='Mail';
							  break;
							  case 3:
								txt ='Tel';
							  break;
							  case 4:
								txt ='In';
							  break;
							  case 5:
								txt ='Job Title';
							  break;
							  case 6:
								txt ='Company';
							  break;
							  case 7:
								txt ='Notes';
							  break;
							  case 8:
								txt ='Type';
							  break;
							  case 9:
								txt ='Sub Type';
							  break;
							  case 10:
								txt ='Technologies';
							  break;
							  case 11:
								txt ='Sub Technologies';
							  break;
							  case 12:
								txt = "Date";
							  break;
						  }
						  return txt;						 
					  },
					columnSorting: {						
						sortOrder: true
					},
					contextMenu: ['remove_row'],
					filters: true,
					dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
					columns: [
					  {
						data:'selected',
						type:'checkbox',
						checkedTemplate: 'yes',
						uncheckedTemplate: 'no'
					  },
					  {
						data:'name',
						renderer: traignleICONRender,
						readOnly:true
					  },
					  {
						data:'email',
						renderer: emailICONRender,
						readOnly:true
					  },
					  {
						data:'phone',
						renderer: phoneICONRender,
						readOnly:true
					  },
					  {
						data:'linkedin_url',
						renderer: linkedinICONRender,
						readOnly:true
					  },
					  {
						data:'title',
						readOnly:true
					  },
					  {
						data:'company_name',
						readOnly:true
					  },
					  {
						data:'note',
						readOnly:true
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
					  },
					  {
						  data:'system_date',
						  dateFormat: 'MM/DD/YYYY',
						  correctFormat: true,defaultDate: '00/00/0000',
						  readOnly:true
					  }
					],
					beforeRemoveRow: function(index, amount){
						rowCount = this.countRows();
						var absoulteIndex = (rowCount + index) % rowCount;
						_contactID = hot1.getDataAtRowProp(absoulteIndex,'id');
						 deleteGoogleContact(contactID);
					},afterChange: function (changes, source) {
						if(!changes){return;}	
						if(changes[1]=="selected"){
							
						}
					},afterSelection:function(){
						setTimeout(getCountSelection,300);
					}
		  });
		 }
		 Handsontable.Dom.addEvent(company_table, 'mouseup', function (event) {			
			if (event.target.nodeName == 'INPUT' && event.target.className == 'checker') {
			  isChecked = !event.target.checked;
			  count = 0;
			  if(isChecked===true){
					jQuery.each(_companiesINString,function(index,c){
					  _companiesINString[index].selected="yes";
					  count++;
					})
			  } else {
				  jQuery.each(_companiesINString,function(index,c){
					  _companiesINString[index].selected="no";
				  })
			  }
			  jQuery("#selected_contacts").html("Selected: "+count).css('color','red');
			  hot1.render();
			}
		  });
		  
		    
		  
		  
		  
		  Handsontable.Dom.addEvent(company_table, 'mousedown', function (event) {
			if (event.target.nodeName == 'INPUT' && event.target.className == 'checker') {
			  event.stopPropagation();
			}
		  });
		 implementCompanyTable();
			function getCountSelection(){
				_getData = hot1.getSourceData();
				count = 0;
				jQuery.each(_getData,function(index,c){
					if(c.selected=="yes"){
						count++;
					}				
				});
				jQuery("#selected_contacts").html("Selected: "+count).css('color','red');
			}
			
			function deleteSelectedContacts(){
				_idS = [];
				_getData = hot1.getSourceData();
				jQuery.each(_getData,function(index,c){
					if(c.selected=="yes"){
						_idS.push(c.id);
					}				
				});
				if(_idS.length>0){
					loadMessage("Loading..");
					jQuery.ajax({
						type:'POST',
						url:__baseUrl+'opportunity/deleteContactsInBatch',
						data:{c:JSON.stringify(_idS)},
					}).done(function(d){
						loadMessage("");
						if(d=='-1'){
							alert("Some correspondense with this contact.");
						} else {
							window.location = window.location.href;
						}
					});
					console.log(JSON.stringify(_idS));
				} else {
					alert('Please select contact first');
				}
			}
			
			function checkboxRender(instance, td, row, col, prop, value, cellProperties) {
				var  check;
				check = document.createElement('input');
				check.type = 'checkbox';
				check.className="checker";
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
				currentVal = instance.getDataAtRowProp(row,'id');
				Handsontable.Dom.empty(td);
				td.innerHTML = "<a href='javascript://' onclick='window.parent.getLeadList(jQuery(this));' data-id='"+currentVal+"'><i class='fa fa-play' title='My Leads'></i></a> <a href='javascript://' onclick='window.parent.editContact("+currentVal+")'>"+value+"</a>";
				return td;
			}
		  function emailICONRender(instance, td, row, col, prop, value, cellProperties){
			   Handsontable.Dom.empty(td);
			   if(value!=""){
				   td.innerHTML ='<span style="text-indent:-99999px;display:inline-block">@@</span> <i class="fa fa-envelope" style="color:#56b2fe"></i>';
			   } else {
				   td.innerHTML ='<span style="text-indent:-99999px;display:inline-block">-@</span>';
			   }
			   return td;
		  }
		  function phoneICONRender(instance, td, row, col, prop, value, cellProperties){
			   Handsontable.Dom.empty(td);
			   _string = "";
			   _d =0;
				if(value!=''){
					_string =  '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+value+'"));\' style="color:#56b2fe"><i class="fa fa-phone" title="Work Phone"></i></a>';
					_d =1;
				}
			   telephone = instance.getDataAtRowProp(row,'telephone');
			   if(telephone!=''){
					if(_d==1){
						_string +=", ";
					}
					_string +=  '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+telephone+'"));\' style="color:green"><i class="fa fa-phone" title="Cell Phone"></i></a>';
					_d =1;
				}
			   td.innerHTML =_string;
			   return td;
		  }
		  function linkedinICONRender(instance, td, row, col, prop, value, cellProperties){
			  Handsontable.Dom.empty(td); 
			  if(value!=""){
				   td.innerHTML ='<span style="text-indent:-99999px;display:inline-block">#</span> <i class="fa fa-linkedin" style="color:#56b2fe"></i>';
			   } else {
				   td.innerHTML ='<span style="text-indent:-99999px;display:inline-block">-#</span>';
			   }
			  return td;
		  }
		</script>		
	</div>
</div>

<script> 
	__backSpace = "";
	function getFillHoleContacts(){
		_getData = hot1.getData();
		_allContacts = [];
		jQuery.each(_getData,function(index,c){
			if(c[0]=="yes"){
				_contactID = hot1.getDataAtRowProp(index,'id');
				_allContacts.push(_contactID);
			}
		});
		
		window.parent.fillHoleContacts = _allContacts;
		window.parent.findHolesContacts();
	}
	function openAddForm(){
		window.parent.openContactEditForm(0);
	}
	_type = <?php echo $this->session->userdata['type']?>;
	function deleteGoogleContact(contactID){
		if(parseInt(_type)==9){
			res = confirm("Are you sure?");
			if(res){
				loadMessage("Loading..");
				jQuery.ajax({
					type:'POST',
					url:'<?php echo $this->config->base_url();?>opportunity/deleteContact',
					data:{delete_link:contactID},
					cache:false,
					success:function(data){
						loadMessage("");
						window.location = window.location.href;						
					}
				});
			}
		} else {
			alert("You are not authorize for delete contact.");
		}
	}
</script>