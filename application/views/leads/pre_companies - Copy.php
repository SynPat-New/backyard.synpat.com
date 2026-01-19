<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/modal/modal.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script src="<?php echo $Layout->aws_server_cdn;?>widgets/typing/typing.min.js"></script>
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.js"></script>
<style> 
	body {
		overflow: auto !important;overflow-x:hidden !important;
		min-width: 0;
		width: 100% !important;font-size:13px;font-family:arial;margin:0px;
	}
	#page-content {
	    background: #ffffff !important;
	}
.scroll-container {
	width: 100%;
	height: 250px;
	margin: 5px 0 1rem;
	overflow: hidden;
}
.htCore, .handsontable{font-family:arial;font-size:13px;}
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
					console.log(d)
				}
			})
		}
	});
});
</script>
<h4>Search for new contacts</h4>
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
<div class='col-xs-12'><p>To search for new contacts to be added to the database based on a list of companies:<br/>1) If a lead IS selected, skip to (2). If a lead is NOT selected, delete the content of <a href='javascript://' onclick="openFormFields()" class='colorClass' style='display:inline-block;' id='btnImportFromDriveSheet'>This Spreadsheet</a>, paste into it the list of new companies, and close the spreadsheet.</p>
<div> 2) Click <form id="import_sheet_form" class='' style='display:inline-block'><input class='form-control input-string' placeholder='Spreadsheet file url' type='hidden' name='file_url' id='file_url' value='https://docs.google.com/spreadsheets/d/1Dd3FFroSCMOnMZ2kdVaMMpw4BLKD_gggffC1UuCk-4g/edit#gid=0'/><input type='hidden' name='lead_id' id='lead_id' value='0'/></form>
<a class='colorClass' style='display:inline-block;' href='javascript://' onclick='importContactsFromFile();'>Import</a><div class="loader_import_file glyph-icon remove-border demo-icon tooltip-button icon-spin-1 icon-spin float-left mrg0A mrg10L hide" title="" data-original-title="Processing Drafting PPA" style="color:#222222; position:inherit;display:inline"></div>
in order to import the list of companies either from the Tech DD (if a lead is selected) or from the spreadsheet into the table below. The imported companies will be checked as invitees. Those that are not yet in the contact database Pre-Companies will be shown in red.
</div>
<p>3) Delete Pre-Companies that have equivalent black ones use mouse right click, and correct the names if needed, remember to select the invitees checkbox.</p>
<p>4) Use and adjust (if needed) the following query to search in LinkedIn for relevant individuals from the list of companies in red. <br/>
Title Inquiry: <input type='text' name='title' id='title' class='form-control query' placeholder='Title' value='<?php echo $title;?>'/>
Keywords: <input type='text' name='keyword' id='keyword' class='form-control query' style='margin-top:5px;' placeholder='Keyword' value='<?php echo $keyword;?>'/><p>
<p>5)  Copy to the clipboard the content of <a href='https://docs.google.com/document/d/1aiuWmlwFQfp2k98kgckH7DXsjY5_wpOy8G7PC0oOjwM/edit' class='colorClass' target='Scrapper Code' style='display:inline-block;'>This file.</a></p>
<p>6) Run the above query on linkedin either for all the <a href='javascript://' onclick='searchCompaniesInLinkedin(0);' class='colorClass' style='display:inline-block;'>Pre-Companies</a> or only for the Linkedin <a href='javascript://' onclick='searchCompaniesInLinkedin(1);' class='colorClass' style='display:inline-block;'>selected companies</a>. The program will search each 50 companies in a separate Tab. While on the LinkedIn page, in the pagination part select the second page and then the first page. Wait 5 minutes. "document.getElementById('results-container')" Open the Developers Tools, click console, paste the content of clipboard and press Enter. This will run a scraping program. Click RUN SCRAPER and in the open UI select MANUAL NEXT 30 until the entire list is scraped. At the end of the process click Export in order to open the list in a Google spreadsheet. <!--make sure no more than  50 companies are selected. Currently <span id="counter"></span> selected--></p>
<p>7) Copy the content of the spreadsheet to the clipboard and continue to <a onclick='window.location = "<?php echo $Layout->baseUrl;?>leads/pre_contacts/"' href='javascript://' class='colorClass'  style='display:inline-block;'>Import Contacts.</a> Remember to do that from all the spreadsheets if there was more than one.</p>
</div>		
</div>

<div class='col-xs-12' style='color:red'>
<!--<input type="checkbox" onclick="selectAll(jQuery(this))"/> Select All-->

Red: <label id='red' style='border-bottom:1px solid #000'></label> &nbsp;&nbsp;&nbsp; Selected: <label id='selected_co' style='border-bottom:1px solid #000'></label>
</div>
	<div class="scroll-container col-lg-12 cp-border">
		<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
	</div>
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
var totalHeight = jQuery(window).height();
var mainHeight = totalHeight - 425;
var availableWidth = jQuery(window).width();
availableWidth = availableWidth-20;
console.log(availableWidth);
jQuery('.scroll-container').css('height',mainHeight+'px');
var company_table = document.getElementById('companies_box'),hot1;
var _red=<?php echo count($pre_contacts);?>;
_companiesINString=[],window.cUser = [];;

<?php 
	$selected=0;
	if(count($pre_contacts)>0){
		foreach($pre_contacts as $lit){		
			$checked = 'no';
			$linkedIN="no";
			if(count($listing_companies)>0){
				foreach($listing_companies as $listing){
					if($listing->type=='pre-company' && $listing->company_id==$lit->id){
						$checked = 'yes';
						$linkedIN = 'yes';
						$selected++;
					}
				}
			}
			$linkedINName = '';
			if(stripos($lit->linkedin_url,'linkedin')!==false){
				$url = explode('?trk=company_logo',$lit->linkedin_url);
				if(count($url)>0){
					$linkUrl = explode('/',$url[0]);
					$linkedINName = array_pop($linkUrl);
				}
			}
		?>
		objectS = {};
		objectS.id = <?php echo $lit->id?>;
		objectS.selected = '<?php echo $checked?>';
		objectS.linkedin = '<?php echo $linkedIN?>';
		objectS.type = 'pre-company';
		objectS.company_name = '<?php echo $lit->company_name?>';
		objectS.linkedin_name = '<?php echo $lit->linkedin_url?>';
		objectS.linkedin_url = '<?php echo $lit->linkedin_url?>';
		objectS.no_of_users = 0;
		objectS.sector = '';
		objectS.categories = '';
		objectS.sub_categories = '';
		_companiesINString.push(objectS);
		<?php
		}
	}
	if(count($contacts)>0){
		foreach($contacts as $lit){
			$checked = 'no';
			$linkedIN = "no";
			if(count($listing_companies)>0){
				foreach($listing_companies as $listing){
					if($listing->type=='company' && $listing->company_id==$lit->id){
						$checked = 'yes';
						$linkedIN = 'yes';
						$selected++;
					}
				}
			}
			/*if( count($lit->company_users)==0){
				$linkedIN = 'yes';
			}*/
			$linkedINName = '';
			if(stripos($lit->linkedin_url,'linkedin')!==false){
				$url = explode('?trk=company_logo',$lit->linkedin_url);
				$linkUrl = explode('/',$url[0]);
				$linkedINName = array_pop($linkUrl);
			}
		?>
		objectS = {};
		objectS.id = <?php echo $lit->id?>;
		objectS.selected = '<?php echo $checked?>';
		objectS.linkedin = '<?php echo $linkedIN?>';
		objectS.type = 'company';
		objectS.company_name = '<?php echo $lit->company_name?>';
		objectS.linkedin_name = '<?php echo $lit->linkedin_url?>';
		objectS.no_of_users = <?php echo count($lit->company_users)?>;
		objectS.linkedin_url = '<?php echo $lit->linkedin_url?>';
		objectS.sector = '<?php echo $lit->sectorName;?>';		
		objectS.categories = '<?php echo $lit->department_names;?>';	
		objectS.sub_categories = '<?php echo $lit->sub_department_names;?>';	
		_companiesINString.push(objectS);
		html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
		try{
			_users = JSON.parse(<?php echo json_encode($lit->company_users)?>);
			if(_users.length>0){
				for(j=0;j<_users.length;j++){
					_companyName = _users[j].name;
					_companyName.replace('"','');
					_companyName.replace('"','');
					html+="<tr>"+
					"<td><a href='javascript://' onclick='window.parent.editContact("+_users[j].id+");'>"+_companyName+"</a></td>"+
					"<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\""+_users[j].phone+"\"))'><i class='fa fa-phone' style='color:green' title='Companies'></i></a></td>"+
					"<td><a href='javascript://' onclick='window.parent.callFromLandline(encodeURIComponent(\""+_users[j].telephone+"\"))'><i class='fa fa-phone colorClass' title='Companies'></i></a></td>"+
					"</tr>"; 
				}
			}	
		}catch(e){
			
		}
									
		html+="</tbody></table>";
		window.cUser[objectS.id] = html;
		<?php
		}
	}	
?>
var _selected= <?php echo $selected?>;
function implementCompanyTable(){
	  hot1 = new Handsontable(company_table, {
			data: _companiesINString,
			  autoWrapCol:true,
			  wordWrap:true,
			  rowHeaders: false,
			  colHeaders: ['Invitees', 'Pre Companies', 'Linkedin' ,'#ofUsers','Company Name','Sector','Categories','Sub Categories','Linkedin Name','Linkedin Url'],
			  minSpareRows: 0,
			  minSpareCols: 0,
			  manualColumnResize:true ,
			  minCols: 7,
			  maxCols: 7,
			  maxRows: _companiesINString.length,
			  width:function(){console.log(availableWidth);return availableWidth;},
			  height:function(){return mainHeight;},
			  fillHandle: false,
			  stretchH:"all",
			  contextMenu: ['remove_row'],
			  columnSorting: {
				column: 1,
				sortOrder: false
			  },
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
				data:'type',
				renderer: typeICONRender,
				readOnly: true
			  },
			  {
				data:'linkedin',
				type:'checkbox',
				checkedTemplate: 'yes',
				uncheckedTemplate: 'no'
			  },
			  {
				data:'no_of_users',
				readOnly: true
			  },
			  {
				data:'company_name',
				renderer: traignleICONRender,
			  },			  
			  {
				data:'sector',
				readOnly: true
			  },
			  {
				data:'categories',
				readOnly: true
			  },
			  {
				data:'sub_categories',
				readOnly: true
			  },
			  {
				data:'linkedin_name',
				renderer: getCompanyNameFromUrl,
				readOnly:true
			  },
			  {
				data:'linkedin_url'
			  }
			],
			colWidths:[60,80,60,60,100,100,150,200,60,125],
			afterChange: function (changes, source) {
				if(!changes){return;}	
				if(changes[0][1]=="selected"){
					_companyID = hot1.getDataAtRowProp(changes[0][0],'id');
					type = hot1.getDataAtRowProp(changes[0][0],'type');
					o = changes[0][3];
					addToSelectionList(o,_companyID,type);
				} else if(changes[0][1]=="linkedin_url"){
					_companyID = hot1.getDataAtRowProp(changes[0][0],'id');
					type = hot1.getDataAtRowProp(changes[0][0],'type');
					linkedinUrl = hot1.getDataAtRowProp(changes[0][0],'linkedin_url');					
					editPreCompanyOrCompanyData(_companyID,type,linkedinUrl);
					if(linkedinUrl!=""){
						_url = linkedinUrl.toString();
						_urlSplit = _url.split('?trk=company_logo');
						_allUrl = _urlSplit[0].split('/');
						linkedInName = _allUrl.pop();
						hot1.setDataAtCell(changes[0][0],5,linkedInName);
					} else {
						hot1.setDataAtCell(changes[0][0],5,'');
					}
				}				
			},
			beforeRemoveRow: function(index, amount){
				rowCount = this.countRows();
				var absoulteIndex = (rowCount + index) % rowCount;
				_companyID = hot1.getDataAtRowProp(absoulteIndex,'id');
				type = hot1.getDataAtRowProp(absoulteIndex,'type');
				if(type=="pre-company"){
					removePreContact(_companyID);
				}else if(type=="company"){
					removeCompany(_companyID);
				} 
			},afterInit:function(){
				jQuery("#red").text(_red);
				jQuery("#selected_co").text(_selected);
			}
  });	
 }
 implementCompanyTable();
function findMyPeople(o){
	jQuery("#cUsers").html(window.cUser[o.attr('data-id')]);
	jQuery("#modal_c_users").modal("show");
}
function typeICONRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	currentValType = instance.getDataAtRowProp(row,'type');
	Handsontable.Dom.empty(td);
	if(currentValType=='company'){
		td.innerHTML='';
	} else if(currentValType=='pre-company'){
		td.innerHTML='<span style="text-indent:-9999px;display:inline-block">red</span>'
	}
	return td;
}
function traignleICONRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	currentValType = instance.getDataAtRowProp(row,'type');
	Handsontable.Dom.empty(td);
	if(currentValType=='company'){
		td.innerHTML = "<a href='javascript://' onclick='findMyPeople(jQuery(this));' data-id='"+currentVal+"'><i class='fa fa-play' title='Companies'></i></a> <a href='javascript://' onclick='editGoogleContact("+currentVal+")'>"+value+"</a>";
	} else {
		td.innerHTML = "<span style='color:red'>"+value+"</span>";
	}	
	return td;
}
function getCompanyNameFromUrl(instance, td, row, col, prop, value, cellProperties){
	_url = value.toString();
	_urlSplit = _url.split('?trk=company_logo');
	_allUrl = _urlSplit[0].split('/');
	linkedInName = _allUrl.pop();
	Handsontable.Dom.empty(td);
	td.innerHTML=linkedInName;
}
function addToSelectionList(o,id,_ty){
	console.log("D:"+o);
	if(o=="yes"){
		_url = __baseUrl+'opportunity/add_list_selection';
	} else{
		_url = __baseUrl+'opportunity/delete_list_selection';
	}	
	jQuery.ajax({type:'POST',url:_url,data:{id:id,t:_ty,lead_id:window.parent.leadGlobal},cache:false,success:function(d){}});
}
function editPreCompanyOrCompanyData(companyID,type,linkedinUrl){
	jQuery.ajax({
		url:__baseUrl+'opportunity/editPreCompanyOrCompanyData',
		type:'POST',
		data:{company_id:companyID,type:type,url:linkedinUrl},
		cache:false,
		success:function(r){
			
		}
	});
}
function editGoogleContact(contactID){
	if(contactID>0){
		jQuery("#new_company").removeClass("show").addClass("hide");
		window.parent.openCompanyEdit(contactID);	
	} else {
		alert("Please select contact first");
	}		
}
function searchCompaniesInLinkedin(ty){
	_queryObject = [];
	/*_getData = hot1.getSourceData();*/
	_getData = hot1.getData();
	/*if(ty==1){
		_queryObject = jQuery('#db_from_litigation').find("input[name='contact_id[]']:checked");
	} else {
		_queryObject = jQuery('#db_from_litigation').find('tr[data-attr="pre-company"]');
	}*/
	jQuery.each(_getData,function(ind,c){
		if(ty==1){			
			if(c[0]=="yes" && c[2]=="yes"){
				if(c.linkedin_name!=""){
					_url = c[8];
					_url = _url.toString();
					_urlSplit = _url.split('?trk=company_logo');
					_allUrl = _urlSplit[0].split('/');
					linkedInName = _allUrl.pop();
					if(linkedInName!=""){
						_queryObject.push(linkedInName);
					} else {
						_queryObject.push(c[4]);
					}
					
				} else {
					_queryObject.push(c[4]);
				}
			}/*
			if(c.linkedin=="yes"){
				if(c.linkedin_name!=""){
					_queryObject.push(c.linkedin_name);
				} else {
					_queryObject.push(c.company_name);
				}
			}*/
		} else {
			if(c[1]=="pre-company"){
				if(c[8]!=""){
					_url = c[8];
					_url = _url.toString();
					_urlSplit = _url.split('?trk=company_logo');
					_allUrl = _urlSplit[0].split('/');
					linkedInName = _allUrl.pop();
					_queryObject.push(linkedInName);
				} else {
					_queryObject.push(c[4]);
				}
			}
		}
	});
	if(_queryObject.length>0){
		i = 0;
		_companies = "";
		_pagePerCompany = 50;
		_total = _queryObject.length;
		_pages = Math.ceil(_total/_pagePerCompany);
		_current = 1;
		keywords = jQuery('#keyword').val();
		embedKeyWords = "";
		s=0;
		jQuery.each(_queryObject,function(index,c){
			_newDate = new Date();
			if(i<_pagePerCompany && _current<=_pages){
				_companies += jQuery.trim(c)+" OR ";		
				if(s==0){
					jQuery.each(_queryObject,function(index,c){
						embedKeyWords += '"'+jQuery.trim(c)+'"';
						embedKeyWords += ' OR ';
					});
					embedKeyWords = embedKeyWords.substr(0,embedKeyWords.length-4);
					keywords = jQuery('#keyword').val();
					keywords = keywords+" AND ("+embedKeyWords+")";
				}
				s=1;
			} else {
				_companies = _companies.substr(0,_companies.length-4);
				title = jQuery('#title').val();				
				window.open('https://www.linkedin.com/vsearch/p?keywords='+encodeURIComponent(keywords)+'&title='+encodeURIComponent(title)+'&companyScope=C&company='+encodeURIComponent(_companies)+'&openAdvancedForm=true','WIndow_'+_current+_newDate.getMilliseconds());
				i=0;
				_companies = '';
				_companies += jQuery.trim(c)+" OR ";
				_current = _current+1;
				s=0;
				embedKeyWords="";
			}			
			i+=1;
		});
		_newDate = new Date();
		_companies = _companies.substr(0,_companies.length-4);
		if(embedKeyWords!=""){
			keywords = jQuery('#keyword').val();
			keywords = keywords+" AND ("+embedKeyWords+")";
			title = jQuery('#title').val();
			window.open('https://www.linkedin.com/vsearch/p?keywords='+encodeURIComponent(keywords)+'&title='+encodeURIComponent(title)+'&companyScope=C&company='+encodeURIComponent(_companies)+'&openAdvancedForm=true','WIndow_'+_current+_newDate.getMilliseconds());
		}
		
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
	jQuery('.loader_import_file').removeClass('hide').addClass('show');
	frm_data= jQuery('#import_sheet_form').serializeArray();
	jQuery.ajax({
		url:__baseUrl+'leads/file_import_in_companies',
		type:'POST',
		data:frm_data,
		cache:false,
		success:function(d){
			jQuery('.loader_import_file').addClass('hide').removeClass('show');
			window.parent.document.getElementById('predefineFormIframe').contentWindow.location.reload();
			/*if(d>0){
				window.parent.document.getElementById('predefineFormIframe').contentWindow.location.reload();
			}*/
		}
	});
}
function addPreToCompany(o){
	var iframe = window.parent.$('#companyFormIframe').contents();
	inputObject = o.parent();
	address = inputObject.attr('data-address');
	company_name = inputObject.attr('data-company');
	var company = {};
	company['web_address'] = address;
	company['company_name']=company_name;
	company['street']='';
	company['zip']='';
	company['sector']='0';
	company['id']=0;		
	jQuery.ajax({type:"POST",url:__baseUrl+"opportunity/add_company",data:{company:company},cache:false,success:function(b){if(b>0){removePreContact(inputObject.find("input[name='contact_id[]']").val(),o,0);inputObject.parent().attr('data-i',b).attr('data-attr','company').css('color','#000');inputObject.find("input[name='contact_id[]']").val(b);alert("Contact added.");}}});
		
	
}
function removePreContact(preContactID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'leads/remove_precompanies',
		data:{id:preContactID},
		success:function(res){
						
		}
	});
}
function removeContact(contactID){
	res = confirm("Are you sure?");
	if(res){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/deleteCompany',
			data:{delete_link:contactID},
			cache:false,
			success:function(data){				
			}
		});
	}
}
</script>