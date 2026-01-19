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
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>/handsontable_new/dist/handsontable.min.css">
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
<div class="scroll-container col-lg-12 cp-border">
	<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
</div>
<script>
var totalHeight = jQuery(window).height();
var mainHeight = totalHeight - 100;
var availableWidth = jQuery(window).width();
availableWidth = availableWidth-20;
console.log(availableWidth);
jQuery('.scroll-container').css('height',mainHeight+'px');
var company_table = document.getElementById('companies_box'),hot1;
_companiesINString=[],window.cUser = [];
	
	<?php 
		if(count($list)>0){
			foreach($list as $company){
		?>
		objectS = {};
		objectS.id = <?php echo $company->id?>;
		objectS.type = '<?php echo $company->type?>';
		objectS.company_name = '<?php echo $company->company_name?>';
		objectS.no_of_users = <?php echo count($company->company_users)?>;
		objectS.selected = 'no';
		_companiesINString.push(objectS);
		html = "<table class='table'><thead><tr><th>Name</th><th>Work Phone</th><th>Mobile Phone</th></tr></thead><tbody>";
		try{
			_users = JSON.parse(<?php echo json_encode($company->company_users)?>);
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
	function implementCompanyTable(){
	  hot1 = new Handsontable(company_table, {
			data: _companiesINString,
			  autoWrapCol:true,
			  wordWrap:true,
			  rowHeaders: false,
			  colHeaders: ['Company Name', 'Pre', '#Users' ,'Select'],
			  minSpareRows: 0,
			  minSpareCols: 0,
			  manualColumnResize:true ,
			  minCols: 4,
			  maxCols: 4,
			  maxRows: _companiesINString.length,
			  width:function(){return availableWidth;},
			  height:function(){return mainHeight;},
			  fillHandle: false,
			  stretchH:"all",
			  columnSorting: {
				column: 1,
				sortOrder: false
			  },
			filters: true,
			dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
			columns: [
			  {
				  data:'company_name',				  
				  renderer: traignleICONRender,
				  readOnly: true
			  },
			  {
				  data:'type',				  
				  renderer: preTextRender,
				  readOnly: true
			  },
			  {
				data:'no_of_users',
				readOnly: true
			  },
			  {
				data:'selected',
				type:'checkbox',
				checkedTemplate: 'yes',
				uncheckedTemplate: 'no'
			  }			  
			]
  });	
 }
 implementCompanyTable();
 function preTextRender(instance, td, row, col, prop, value, cellProperties){
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
function editGoogleContact(contactID){
	if(contactID>0){
		jQuery("#modal_c_users").removeClass("show").addClass("hide");
		window.parent.openCompanyEdit(contactID);
	} else {
		alert("Please select contact first");
	}	
}
</script>
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