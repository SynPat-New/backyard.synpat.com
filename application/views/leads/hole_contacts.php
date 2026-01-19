<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>widgets/datepicker-ui/datepicker.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/datepicker-ui/datepicker.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/slimscroll/slimscroll.js"></script>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.js"></script>

<style> 
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;font-family:arial;font-size:13px;
	}
	#page-content {
	    background: #ffffff !important;
	}
	a{text-decoration:none;}
	.bg-grey{background-color:#EFEFEF !important;}
	.htCore, .handsontable{font-family:arial;font-size:13px;}
.handsontable .htDimmed{color:#222222}
.ui-datepicker{z-index:9999 !important;background:white;padding:0px 10px;}
</style>
<?php 
	/*To fill missing telephone numbers, email addresses and linkedin links in the contacts database:<br/>
 1) Create a subset of contacts using the leads dropdown list <select class="" id="leadId" class="form-control" style='width:150px;'  onchange="findCompaniesPeopleInLead(jQuery(this).val());"><?php 
												$leads = allActiveLeads(); 
												if(count($leads)>0){
												?>
												<option value=''></option>
												<?php
													foreach($leads as $lead){
											?> <option value="<?php echo $lead->id;?>"><?php echo $lead->lead_name;?></option> <?php
													}
												}
											?> </select> and or the filter search line below. Diselect contacts not to be included<br/>*/
?>
<h4>Create a DataFill Project</h4>
<div class='col-lg-12'>
<div class="row">
<div class='col-lg-12'><p>Set a project name: <input type="text" name="project_name" id="project_name" placeholder="Project Name" class="form-control input-string col-lg-3" style='display:inline-block;width:150px;'> Deadline: <input date-format='yyyy-mm-dd' type="text" data-provide="datepicker-inline" name="deadline" id="deadline" placeholder="Deadline" class="form-control input-string col-lg-3 datePicker" style='display:inline-block;width:150px;'><br/>Set data to collect and set a price for each: <input type='checkbox' value='5' name='column_heading[]'/> Email ($): <input name='column_price[]' style='width:30px;display:inline-block' value=''/>&nbsp;&nbsp;<input type='checkbox' value='6' name='column_heading[]'/> Workphone ($): <input name='column_price[]' style='width:30px;display:inline-block' value=''/>&nbsp;&nbsp;<input type='checkbox' value='7' name='column_heading[]'/> Cellphone ($): <input name='column_price[]' style='width:30px;display:inline-block' value=''/>&nbsp;&nbsp;<input type='checkbox' value='8' name='column_heading[]'/> Linkedin ($): <input name='column_price[]' style='width:30px;display:inline-block' value=''/> and click <a style="" href="javascript://" onclick="createHoleProject()" class="btn btn-primary mrg5L" style='display:inline-block;width:150px;'>Create a datafills project</a><a href="<?php echo $Layout->baseUrl?>manager" target="_blank" class="btn btn-primary" style='display:inline-block;width:120px;margin-left:5px;'>Go to datafills</a></p>
</div>
</div>
<div class="scroll-container col-lg-12 cp-border" style='margin-top:5px;'>
	<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
</div>
<script>
jQuery(document).ready(function(){
	$("#deadline").datepicker({dateFormat:'yy-mm-dd'});
});
var company_table = document.getElementById('companies_box'),hot1,isChecked=true;
_companiesINString = [];
_companiesINString=[<?php
		if(count($contacts)>0){
			$i=0;
			foreach($contacts as $contact){		
				$categories = findMyPreferenceWithName($contact->company_id);
				$depatmentsName = "";
				if(count($categories)>0){
					for($c=0;$c<count($categories);$c++){
						$depatmentsName .= $categories[$c]->name.", ";
					}
					$depatmentsName = substr($depatmentsName,0,-2);
				}
				$firstName = str_replace("'","",$contact->first_name);
				$lastName = str_replace("'","",$contact->last_name);
			echo "{'id':". $contact->id.",'first_name':'" . $firstName . "','last_name':'" . $lastName . "','title':'" . $contact->job_title . "','company_name':'" . $contact->company_name . "','email':'" . $contact->email . "','phone':'" . $contact->phone . "','telephone':'" . $contact->telephone . "','linkedin_url':'" . $contact->linkedin_url . "','sectors':'" . $contact->sectorName . "','departments':'" . $depatmentsName . "','selected':'yes'}";
			if ($i < count($contacts) - 1) {
				echo ",";
			}
			}
		}
	?>];
var totalHeight = jQuery(window).height();
var mainHeight = totalHeight - 120;
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
		  minCols: 11,
		  maxCols: 11,
		  maxRows: _companiesINString.length,
		  width:function(){console.log(availableWidth);return availableWidth;},
		  height:function(){return mainHeight;},
		  fillHandle: false,
		  stretchH:"all",
		  colWidths:[35,70,70,120,100,60,60,80,100,80,150],
		  colHeaders:function(col){
			  var txt='';
			  switch(col){
				  case 0:
					txt = "# <input type='checkbox' class='checker' ";
					txt += isChecked ? 'checked="checked"' : '';
					txt += ">";
				  break;
				  case 1:
					txt ='First Name';
				  break;
				  case 2:
					txt ='Last Name';
				  break;
				  case 3:
					txt ='Job Title';
				  break;
				  case 4:
					txt ='Company';
				  break;
				  case 5:
					txt ='Email';
				  break;
				  case 6:
					txt ='Work';
				  break;
				  case 7:
					txt ='Cellphone';
				  break;
				  case 8:
					txt ='Linkedin Url';
				  break;
				  case 9:
					txt ='Sectors';
				  break;
				   case 10:
					txt ='Departments';
				  break;
			  }
			  return txt;						 
		  },
		  columnSorting: {
			column: 1,
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
			data:'first_name',
			readOnly:true
		  },
		  {
			data:'last_name',
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
			data:'email',
			renderer: ICONRender,
			readOnly:true
		  },
		  {
			data:'phone',
			renderer: ICONRender,
			readOnly:true
		  },
		  {
			data:'telephone',
			renderer: ICONRender,
			readOnly:true
		  },
		  {
			data:'linkedin_url',
			renderer: ICONRender,
			readOnly:true
		  },
		  {
			data:'sectors',
			readOnly: true
		  },
		  {
			data:'departments',
			readOnly: true
		  }
		]
});
}
Handsontable.Dom.addEvent(company_table, 'mouseup', function (event) {
if (event.target.nodeName == 'INPUT' && event.target.className == 'checker') {
  isChecked = !event.target.checked;
  if(isChecked===true){
	  jQuery.each(_companiesINString,function(index,c){
		  _companiesINString[index].selected="yes";
	  })
  } else {
	  jQuery.each(_companiesINString,function(index,c){
		  _companiesINString[index].selected="no";
	  })
  }
  hot1.render();
}
});
Handsontable.Dom.addEvent(company_table, 'mousedown', function (event) {
if (event.target.nodeName == 'INPUT' && event.target.className == 'checker') {
  event.stopPropagation();
}
});
implementCompanyTable();
function ICONRender(instance, td, row, col, prop, value, cellProperties){
   Handsontable.Dom.empty(td);
   if(value==""){
	   td.innerHTML ='Enter';
   } else {
	   td.innerHTML ='';
	   td.className='bg-grey';
   }
   return td;
}
</script>
</div>
<script>
_spreadsheet = [];
__baseUrl = '<?php echo $Layout->baseUrl?>';
function createHoleProject(){
	_getSourceData = hot1.getData();
	jQuery.each(_getSourceData,function(index,c){
		if(c[0]=="yes"){
			_first_name = c[1];
			_last_name = c[2];
			_name = _first_name+" "+_last_name;
			_title = c[3];
			_companyName = c[4];
			_email = hot1.getDataAtRowProp(index,'email');
			_phone = hot1.getDataAtRowProp(index,'phone');
			_telephone = hot1.getDataAtRowProp(index,'telephone');
			_linkedin = hot1.getDataAtRowProp(index,'linkedin_url');
			_id = hot1.getDataAtRowProp(index,'id');
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
			if(_companyName=="undefined" || _companyName==undefined){
				_companyName='';
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
			_spreadRows={};
			_spreadRows.name = _name;
			_spreadRows.first_name = _first_name;
			_spreadRows.last_name = _last_name;
			_spreadRows.title = _title;
			_spreadRows.company = _companyName;
			_spreadRows.phone = _phone;
			_spreadRows.telephone = _telephone;
			_spreadRows.email = _email;
			_spreadRows.linkedin = _linkedin;
			_spreadRows.contact_id = _id;					
			_spreadsheet.push(_spreadRows);
		}
	});
	if(_spreadsheet.length>0){
		console.log(_spreadsheet);
		_selectedColumns=[];
		jQuery("input[name='column_heading[]']").each(function(index){
			if(jQuery(this).is(':checked') && jQuery("input[name='column_price[]']").eq(index).val()!=""){				
				_selectedColumns.push({id:jQuery(this).val(),price:jQuery("input[name='column_price[]']").eq(index).val()});
			}
		});
		if(_selectedColumns.length>0){
			data = {project_name:jQuery('#project_name').val(),deadline:jQuery('#deadline').val(),rec:JSON.stringify(_spreadsheet),heading:JSON.stringify(_selectedColumns)};
			window.parent.call(__baseUrl+'leads/create_spreadsheet_for_hole','POST',data,window.parent.showMessageFromWholeContacts,'json');
		} else {
			alert("Please select column heading and enter price");
		}		
	} else {
		alert('Please select contacts first for creating  project in DataFills.');
	}
}
</script>