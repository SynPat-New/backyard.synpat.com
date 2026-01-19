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

<style>
/*::-webkit-scrollbar {
    width: 10px;height:10px;
	
}
 
::-webkit-scrollbar-track {
    border-radius: 10px;
	-webkit-box-shadow: inset 0 0 6px rgba(194,0,0,0.3); 
}
 
::-webkit-scrollbar-thumb {
    border-radius: 10px;
	-webkit-box-shadow: inset 0 0 6px rgba(194,0,0,0.3); 
}*/
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;font-family:arial;font-size:13px;margin:0px;
	}
	#page-content {
	    background: #ffffff !important;
	}
	
	a{text-decoration:none;}h4{font-size:16px;font-weight:300;margin:0}
	
	.mrg5R{margin-right:5px;}
	.scroll-container {
	width: 99%;
	height: 250px;
	margin: 5px 0 1rem;
	overflow: hidden;
}
.htCore, .handsontable{font-family:arial;font-size:13px;}
.handsontable .htDimmed{color:#222222}
.hide{display:none;}
.show{display:block;}
.title-hero{font-family:arial;font-size:20px;}
#companies_request_box .handsontable tbody tr td:last-child,#companies_request_box .handsontable thead tr th:last-child,#companies_box .handsontable tbody tr td:last-child,#companies_box .handsontable thead tr th:last-child{text-align:left}
</style>
<div class="panel dashboard-box">
    <div class="panel-body">
		<div class="example-box-wrapper">	
			<div class="example-box-wrapper">
				<div class="col-lg-12 hide" id="assignCompany">
				<h4 style='margin-top:-3px'>Assign a Company</h4>
				<?php echo form_open('general/add_new_customer',array('class'=>"form-horizontal form-flat bordered-row", 'style'=>'margin-bottom: 0'))?>
				<div class="row row-width">
					<div class="col-lg-6">
						<div class="form-group input-string-group" style="margin-left: 0;border-bottom:0px;">
		                    <label class="control-label">Type :</label>
		                    <select class='form-control' id="customerType" name="customer[type]">
								<option value='0'>Customer</option>
								<option value='1'>Broker</option>
							</select>
		                </div>
						<div class="form-group input-string-group" style="margin-left: 0;border-bottom:0px;">
		                    <label class="control-label">Company :</label>
		                    <select class='form-control' id="assignCompanyId" name="customer[company_id]">
								<?php foreach($company_list as $company):?>
								<option  value="<?php echo $company->id?>"><?php echo $company->company_name?></option>
								<?php endforeach;?>
							</select>
		                </div>
					</div>					
					<div class='col-lg-1 pull-left mrg20T'>
						<button type="submit" class='btn  btn-primary btn-block'>Save</button>
					</div>
				</div>
				<input type="hidden" name="customer[request]" id="customerRequest" value="0"/>
				<?php echo form_close();?>
			</div>
				<h3 class="title-hero">Request to become a customer</h3>
				<div class="scroll-container col-lg-12 cp-border">
					<div id='companies_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
				</div>
			
				<h3 class="title-hero">Membership Payments</h3>
				<div class="scroll-container col-lg-12 cp-border">
					<div id='membership_request_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
				</div>				
				
				<h3 class="title-hero">Existing Customers</h3>
				<div class="scroll-container col-lg-12 cp-border">
					<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
				</div>
				<script>
jQuery(window).on('resize',function(){
	_width = jQuery(window).width();
	_width = _width-20; 
	jQuery('#companies_box,#membership_request_box,#companies_request_box').css('width',_width+"px");
	
	hot1.updateSettings({
		width:_width,
		modifyColWidth: function(width, col){
			switch(col){
				case 0:
					return widthP(_width,5);
					break;
				case 1:
					return widthP(_width,5);
					break;
				case 2:
					return widthP(_width,5);
					break;
				case 3:
					return widthP(_width,18);
					break;
				case 4:
					return widthP(_width,13);
					break;
				case 5:
					return widthP(_width,7);
					break;
				case 6:
					return widthP(_width,10);
					break;
				case 7:
					return widthP(_width,11);
					break;
				case 8:
					return widthP(_width,9);
					break;
				case 9:
					return widthP(_width,5);
					break;
				case 10:
					return widthP(_width,3);
					break;
			} 
		}
	});
	hot2.updateSettings({
		width:_width,
		modifyColWidth: function(width, col){
			switch(col){
				case 0:
					return widthP(_width,7);
					break;
				case 1:
					return widthP(_width,7);
					break;
				case 2:
					return widthP(_width,20);
					break;
				case 3:
					return widthP(_width,8);
					break;
				case 4:
					return widthP(_width,8);
					break;
				case 5:
					return widthP(_width,15);
					break;
				case 6:
					return widthP(_width,10);
					break;
				case 7:
					return widthP(_width,10);
					break;
			} 
		}
	});
	hot3.updateSettings({
		width:_width,
		modifyColWidth: function(width, col){
			switch(col){
				case 0:
					return parseInt(_width * (10/100));
					break;
				case 1:
					return parseInt(_width * (15/100));
					break;
				case 2:
					return parseInt(_width * (25/100));
					break;
				case 3:
					return parseInt(_width * (10/100));
					break;
				case 4:
					return parseInt(_width * (10/100));
					break;
				case 5:
					return parseInt(_width * (10/100));
					break;
				case 6:
					return parseInt(_width * (10/100));
					break;
				case 7:
					return parseInt(_width * (10/100));
					break;
			} 
		}
	});
});
var company_table = document.getElementById('companies_box'),request_table = document.getElementById('companies_request_box'),hot1,hot2,membership_table = document.getElementById('membership_request_box'),hot3,isChecked;
let _requestINString = [],_companiesINString = [],_membershipINString = [];
_companiesINString=[<?php
		if(count($companies)>0){
			$i=0;
			foreach($companies as $contact){
				$memberShip = "";
				$getCount = getUsersByActDeactCompanies($contact->id,0);
				if($contact->membership==0): $memberShip = 'Vistor';elseif($contact->membership==1):$memberShip = 'Regular';elseif($contact->membership==2):$memberShip = 'Participant';endif;
				$activationDate = '';
				$lastLogin = '';
				$end_date = '';
				if($contact->activationDate!='0000-00-00 00:00:00'){
					$activationDate = date('m/d/Y',strtotime($contact->activationDate));
				}
				if($contact->lastLogin!='0000-00-00 00:00:00'){
					$lastLogin = date('m/d/Y',strtotime($contact->lastLogin));
				}
				if($contact->end_date!='0000-00-00 00:00:00'){
					$end_date = date('m/d/Y',strtotime($contact->end_date));
				}
			echo "{'id':". $contact->id.",'create_date':'" . $activationDate . "','last_login':'" . $lastLogin . "','end_date':'" . $end_date . "','file':'" . $contact->file . "','company_address':'" . $contact->company_address . "','company_name':'" . $contact->company_name . "','telephone':'" . $contact->telephone . "','bank_name':'" . $contact->bank_name . "','bank_account_no':'" . $contact->bank_account_no . "','routing_no':'" . $contact->routing_no . "','membership':'" . $memberShip . "','count_users':'" . $getCount . "','customer_company_name':'".$contact->customerCompanyName."'}";
			if ($i < count($companies) - 1) {
				echo ",";
			}
			}
		}
	?>];
_requestINString=[<?php
	if(count($customer_request)>0){
		$i=0;
		foreach($customer_request as $contact){
			$address = $contact->company_address;
			$address = str_replace(array('\n',"\n",'\r'),'',$address);
			$source_data = $contact->source == 0 ?'Docket':'Website';
			echo "{'id':". $contact->id.",'date':'" . date('H:i,m/d/Y',strtotime($contact->create_date)) . "','first_name':'" . $contact->first_name . "','last_name':'" . $contact->last_name . "','job_title':'" . $contact->job_title . "','email':'" . $contact->email . "','company_address':'" . $address . "','company_name':'" . $contact->company_name . "','telephone':'" . $contact->phone_number . "','action':". $contact->id.",'source':".$contact->source.",'source_data':'".$source_data."'}";
			if ($i < count($customer_request) - 1) {
				echo ",";
			}
		}
	}
?>];				
_membershipINString=[<?php
	if(count($membership_payment)>0){
		$i=0;
		foreach($membership_payment as $membership){
			echo "{'id':". $membership->id.",'date':'" . date('m/d/Y',strtotime($membership->create_date)) . "','first_name':'" . $membership->first_name . "','last_name':'" . $membership->last_name . "','email':'" . $membership->email . "','company_name':'" . $membership->company_name . "','file':'" . $membership->file . "','status':'" . $membership->status . "','action':". $membership->id.",'amount':'" . $membership->amount ."','membership_type':'" . $membership->membership_type ."','enter_effective_date':'" . $membership->enter_effective_date ."','no_of_years':'" . $membership->no_of_years ."'}";
			if ($i < count($membership_payment) - 1) {
				echo ",";
			}
		}
	}
?>];
var __baseUrl = '<?php echo $Layout->baseUrl?>';
let totalHeight = jQuery(window).height();
let mainHeight = totalHeight - 135;
const calHeight = parseInt((mainHeight*25)/100);
const calHeight1 = parseInt((mainHeight*25)/100);
const calHeight2 = parseInt((mainHeight*50)/100);
var availableWidth = jQuery(window).width();
availableWidth = availableWidth-20;
jQuery('#companies_box,#membership_request_box,#companies_request_box').css('width',availableWidth+"px");
function widthP(w,p){
	return parseInt(w * (p/100));
}
function sortDateFunction(sortOrder, columnMeta){	
console.log('sort');
  	return function(a, b) {
		if (a[1] === b[1]) {
			return 0;
		}
		if (a[1] === null || a[1] === '') {
			return 1;
		}
		if (b[1] === null || b[1] === '') {
			return -1;
		}
		var aDate = moment(a[1], 'HH:mm MM/DD/YY');
		var bDate = moment(b[1], 'HH:mm MM/DD/YY');
		console.log('aDate %s , bDate %s',aDate,bDate);
		if (!aDate.isValid()) {
			return 1;
		}
		if (!bDate.isValid()) {
			return -1;
		}
		if (bDate.isAfter(aDate)) {
			return sortOrder ? -1 : 1;
		}
		if (bDate.isBefore(aDate)) {
			return sortOrder ? 1 : -1;
		}
    }	
}
jQuery('.scroll-container').eq(0).css('height',calHeight+'px');
jQuery('.scroll-container').eq(1).css('height',calHeight1+'px');
jQuery('.scroll-container').eq(2).css('height',calHeight2+'px');
				function implementCompanyTable(){
					_width = jQuery('#companies_box').width();
					_width -=10;
					hot1 = new Handsontable(company_table, {
					data: _companiesINString,
					  rowHeaders: false,
					  minSpareRows: 0,
					  minSpareCols: 0,
					  manualColumnResize:false ,
					  minCols: 14,
					  maxCols: 14,
					  maxRows: _companiesINString.length,
					  width:function(){return _width;},
					  height:function(){return calHeight2;},
					  fillHandle: false,
					  stretchH:"all",
					  
					  colHeaders:['Activation','Last Login','Expiry','Customer','IP Dept Address','IP Dept Telephone','Bank Name','Bank Account No','Routing No','Type','File','Account'],
					columnSorting: {						
						 sortEmptyCells: true,
						 initialConfig: {
						  column: 1,
						  sortOrder: 'desc'
						}
					},
					modifyColWidth: function(width, col){
						switch(col){
							case 0:
								return widthP(_width,5);
								break;
							case 1:
								return widthP(_width,5);
								break;
							case 2:
								return widthP(_width,5);
								break;
							case 3:
								return widthP(_width,18);
								break;
							case 4:
								return widthP(_width,13);
								break;
							case 5:
								return widthP(_width,7);
								break;
							case 6:
								return widthP(_width,10);
								break;
							case 7:
								return widthP(_width,11);
								break;
							case 8:
								return widthP(_width,9);
								break;
							case 9:
								return widthP(_width,5);
								break;
							case 10:
								return widthP(_width,3);
								break;
						}  
					},
					afterRender: function(){
					erase();
				   },
					contextMenu: false,
					filters: true,
					dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
					columns: [
					   {
						data:'create_date',
						type:'date',
						dateFormat: 'MM/DD/YYYY',       
						correctFormat: true,
						readOnly:true
					  },
					  {
						data:'last_login',
						type:'date',
						dateFormat: 'MM/DD/YYYY',       
						correctFormat: true,
						readOnly:true
					  },
					  {
						data:'end_date',
						type:'date',
						dateFormat: 'MM/DD/YYYY',       
						correctFormat: true,
						readOnly:true
					  },
					  {
						data:'customer_company_name',
						renderer: companyLinkRender,
						readOnly:true
					  },					  
					  {
						data:'company_address',
						readOnly:true
					  },
					  {
						data:'telephone',
						renderer: phoneICONRender,
						readOnly:true
					  },
					  {
						data:'bank_name',
						readOnly:true
					  },
					  {
						data:'bank_account_no',
						readOnly:true
					  },
					  {
						data:'routing_no',
						readOnly:true
					  },
					  {
						data:'membership',
						readOnly:true
					  },
						{
							data:'file',
							renderer:fileICONRender,
							readOnly:true
						},
					  {
						data:'count_users',
						renderer: countICONRender,
						readOnly: true
					  }
					],
					onInit:function(){
					}
				});
			}
			implementCompanyTable();
			function erase(){
			  var arrows = document.getElementsByClassName('htAutocompleteArrow');
			  
			  for(var i = 0; i < arrows.length; i++){
				arrows[i].innerHTML = "";
			  }
			}
			_MainRow = -1;
			function implementRequestTable(){
				_width = jQuery('#companies_request_box').width();
					_width -=10;
					hot2 = new Handsontable(request_table, {
					data: _requestINString,
					  rowHeaders: false,
					  minSpareRows: 0,
					  minSpareCols: 0,
					  manualColumnResize:false ,
					  minCols: 8,
					  maxCols: 8,
					  maxRows: _requestINString.length,
					  width:function(){return _width;},
						height:function(){return calHeight;},
						fillHandle: false,
						modifyColWidth: function(width, col){
							switch(col){
								case 0:
									return widthP(_width,7);
									break;
								case 1:
									return widthP(_width,7);
									break;
								case 2:
									return widthP(_width,20);
									break;
								case 3:
									return widthP(_width,8);
									break;
								case 4:
									return widthP(_width,8);
									break;
								case 5:
									return widthP(_width,15);
									break;
								case 6:
									return widthP(_width,10);
									break;
								case 7:
									return widthP(_width,10);
									break;
							} 
						},
					  stretchH:"all",
					  colHeaders:['Date','Source','Customer','First Name','Last Name','Email Address','Phone Number','<span style="margin-right:10px;display:inline-block;width:30px;"><i class="fa fa-check-circle-o" title="Activate"></i></span><span style="display:inline-block;" title="Delete"><i class="fa fa-trash-o"></i></span>'],
					columnSorting: {						
						 sortEmptyCells: true,
						initialConfig: {
						  column: 3,
						  sortOrder: 'desc'
						}
					},
					contextMenu: false,
					filters: true,
					dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
					columns: [
					 {
						data:'date',	
						type: 'text',
						sortFunction: sortDateFunction,
						readOnly: true
					 },
					 {
						data:'source_data',
						readOnly:true
					 },
					 {
						data:'company_name',
						readOnly:true
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
						data:'email',
						readOnly:true
					  },
					  {
						data:'telephone',
						renderer: phoneICONRender,
						readOnly:true
					  },{
						data:'action',
						renderer: actionRender,
						readOnly: true
					 }
					],afterSelection:function(r,c,r2,c2){
						_MainRow = r;
					}
				});
			}
			implementRequestTable();
			
function implementMembershipTable(){
	_width = jQuery('#membership_request_box').width();
		_width -=10;
		hot3 = new Handsontable(membership_table, {
		data: _membershipINString,
		  rowHeaders: false,
		  minSpareRows: 0,
		  minSpareCols: 0,
		  manualColumnResize:false ,
		  minCols: 8,
		  maxCols: 8,
		  maxRows: _membershipINString.length,
		  width:function(){return _width;},
		  height:function(){return calHeight1;},
		  fillHandle: false,
		  modifyColWidth: function(width, col){
			switch(col){
				case 0:
					return parseInt(_width * (10/100));
					break;
				case 1:
					return parseInt(_width * (15/100));
					break;
				case 2:
					return parseInt(_width * (25/100));
					break;
				case 3:
					return parseInt(_width * (10/100));
					break;
				case 4:
					return parseInt(_width * (10/100));
					break;
				case 5:
					return parseInt(_width * (10/100));
					break;
				case 6:
					return parseInt(_width * (10/100));
					break;
				case 7:
					return parseInt(_width * (10/100));
					break;
			} 
		},
		stretchH:"all",
		colHeaders:['Date','Customer','Proof of Payment Uploaded by Customer','Enter Amount Paid','Membership Type','Enter Effective Date','Number of Years','<span style="margin-right:10px;display:inline-block;width:30px;"><i class="fa fa-check-circle-o" title="Activate"></i></span><span style="display:inline-block;" title="Delete"><i class="fa fa-trash-o"></i></span>'],
		columnSorting: {						
			sortEmptyCells: true,
			initialConfig: {
				column: 0,
				sortOrder: 'desc'
			}
		},
		contextMenu: false,
		filters: true,
		dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
		columns: [
			{
				data:'date',	
				dateFormat: 'MM/DD/YYYY',       
				correctFormat: true,
				readOnly: true
			},
			{
				data:'company_name',
				readOnly:true
			},
			{
				data:'file',
				renderer:fileICONRender,
				readOnly:true
			},
			{
				data:'amount',
				readOnly:false
			},
			{
				data:'membership_type',
				type: 'dropdown',
				source: ['Visitor', 'Licensees', 'Participants'],
				readOnly:false
			},
			{
				data:'enter_effective_date',
				type: 'date',
				correctFormat: true,
				dateFormat: 'YYYY-MM-DD',       
				readOnly:false
			},
			{
				data:'no_of_years',
				readOnly:false
			},
			{
				data:'action',
				renderer: membershipActionRender,
				readOnly: true
			}
		],
		afterChange:function(changes,source){
			if(source == "edit") {
				const rowData = _membershipINString[changes[0][0]];
				jQuery.ajax({
					type:'POST',
					url: __baseUrl+"customers/update_membershhip",
					data:{field:changes[0][1],v:changes[0][3],id:rowData.id},
					dataType:'json'
				}).done(function(d){
					console.log(d)
				});
			}
			console.log(changes,source);
		}
	});
}
implementMembershipTable();


function companyLinkRender(instance, td, row, col, prop, value, cellProperties){
	currentVal = instance.getDataAtRowProp(row,'id');
	companyName = instance.getDataAtRowProp(row,'company_name');
	Handsontable.dom.empty(td);
	td.innerHTML = "<a href='javascript://' style='color:#56B2fe' onclick='getAllUsers(jQuery(this))' data-c='"+companyName+"' data-id='"+currentVal+"'>"+companyName+"</a>";
	return td;
}
function countICONRender(instance, td, row, col, prop, value, cellProperties){
  currentVal = instance.getDataAtRowProp(row,'id');
  Handsontable.dom.empty(td);
   if(parseInt(value)>0){
	   td.innerHTML = "<span class='colHeader'><span style='display:inline-block;line-height:1.1;'><a href='javascript://' style='color:#56B2fe' onclick='userStatus(1,jQuery(this))' data-id='"+currentVal+"'>Deactivate</a></span></span>";
  } else {
	  td.innerHTML = "<span class='colHeader'><span style='display:inline-block;line-height:1.1;'><a href='javascript://' style='color:#56B2fe' onclick='userStatus(0,jQuery(this))' data-id='"+currentVal+"'>Activate</a></span></span>";
  }			  
  return td;
}
function actionRender(instance, td, row, col, prop, value, cellProperties){
	const currentVal = instance.getDataAtRowProp(row,'id');
	const currentEmail = instance.getDataAtRowProp(row,'email');
	const source = instance.getDataAtRowProp(row,'source');
	Handsontable.dom.empty(td);
	td.innerHTML = "<span class='colHeader'><span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a title='Activate' href='javascript://' style='color:#56B2fe' onclick='activateUser(jQuery(this))' data-source='"+source+"' data-email='"+currentEmail+"' data-id='"+value+"'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a></span><span style='display:inline-block;line-height:1.1;'><a title='Delete' href='javascript://' style='color:#56B2fe' onclick='deleteCustomerRequest("+value+")' data-id='"+value+"'><i class='fa fa-trash' aria-hidden='true'></i></a></span></span>";			  		  
	return td;
}
			
function membershipActionRender(instance, td, row, col, prop, value, cellProperties){
	
	const currentVal = instance.getDataAtRowProp(row,'id');
	const currentEmail = instance.getDataAtRowProp(row,'email');
	Handsontable.dom.empty(td);
	td.innerHTML = "<span class='colHeader'><span style='display:inline-block;width:30px;margin-right:10px;line-height:1.1;'><a title='Activate' href='javascript://' style='color:#56B2fe' onclick='activateCustomerMembership(jQuery(this))' data-email='"+currentEmail+"' data-id='"+value+"'><i class='fa fa-check-circle-o' aria-hidden='true'></i></a></span><span style='display:inline-block;line-height:1.1;'><a title='Delete' href='javascript://' style='color:#56B2fe' onclick='deleteCustomerMembership("+value+")' data-id='"+value+"'><i class='fa fa-trash' aria-hidden='true'></i></a></span></span>";			  		  
	return td;
}
function actionDeleteRender(instance, td, row, col, prop, value, cellProperties){
  currentVal = instance.getDataAtRowProp(row,'id');
  currentEmail = instance.getDataAtRowProp(row,'email');
  Handsontable.dom.empty(td);
  td.innerHTML = "<a href='javascript://' style='color:#56B2fe' onclick='deleteCustomerRequest("+value+")' data-id='"+value+"'>Delete</a>";			  		  
  return td;
}
function phoneICONRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	let _string = "";
	if(value!=''){		
		_string =  '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+value+'"));\' style="color:#56b2fe"><i class="fa fa-phone" title="Work Phone"></i> '+value+'</a>';
	}
	td.innerHTML =_string;
	return td;
}

function fileICONRender(instance, td, row, col, prop, value, cellProperties){
	Handsontable.dom.empty(td);
	let _string = "";
	if(value != '' && value != "null"){
		value = value.replace("view?usp=drivesdk","preview");
		value = value.replace("edit?usp=drivesdk","preview");
		_string =  '<a href="javascript://" onclick="openFile(jQuery(this))" data-href="'+value+'" style="color:#56b2fe"><i class="fa fa-file" title="Proof of payment"></i></a>';
	}
	td.innerHTML =_string;
	return td;
}
function openFile(o){
	window.parent.open_drive_files(o.data('href'));
}  
function removeCustomerRequest(ID){
	jQuery.each(_requestINString,function(i,d){
		if(typeof d.id!='undefined' && d.id==ID){
			_requestINString.splice(i,1);
			//hot2.destroy();
			/*hot2.render();
			window.parent.getCustomerRequest();*/
			return true;
		} 
	});
}
function activateUser(o){
	/*Check User First*/
	if(o.data('source') == '1'){
		window.parent.jQuery("#displayEmail").data('cr-id',o.data('id'));
		window.parent.jQuery("#displayEmail").data('cr-type','Customer');
		window.parent.jQuery("#displayEmail").data('cr-r','6');	
		window.parent.jQuery("#displayEmail").data('cr-lead','472');
		window.parent.jQuery("#activityMainType").val(1);
		window.parent.findActivitesLeadsFromEmailCustomerRequest(o.data('email'),0,1);
	} else {
		window.parent.jQuery("#displayEmail").data('cr-id',o.data('id'));
		window.parent.jQuery("#displayEmail").data('cr-type','Customer');
		window.parent.findEmailCustomerRequest(o.data('email'),0,1);
	}	
}

function activateCustomerMembership(o) {
	window.parent.jQuery("#displayEmail").data('cr-id',o.data('id'));
	window.parent.jQuery("#displayEmail").data('cr-type','Membership');
	window.parent.jQuery("#activityMainType").val(1);
	window.parent.findActivitesLeadsFromEmailCustomerRequest(o.data('email'),0,1);
	
}
function deleteCustomerRequest(i){
	r = _MainRow;
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+"customers/deleteCustomerRequest",data:{s:i},cache:false,success:function(res){
			if(res>0){
				/*window.location = window.location.href;*/
				hot2.alter('remove_row', r);
				removeCustomerRequest(i);
				window.parent.getCountOnRTP();
			} else{
				alert("Please try after sometime.");
			}
		}
	});
}
		
function getAllUsers(o){
	_companyID = o.data('id');
	_companyName = o.data('c');
	jQuery.ajax({
		type:'GET',
		url:__baseUrl+'customers/get_all_customers/'+_companyID,data:{},dataType:'json',cache:false,success:function(res){
			if(res.length>0){
				_table = '<div style="overflow-x:hidden;overflow-y:scroll;height:300px;"><a style="color:#56B2fe" href="javascript://" onclick="window.parent.openCompanyEdit('+_companyID+')">'+_companyName+'</a> <table id="lb'+_companyID+'" class="table table-striped table-hover"><thead><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th></tr></thead><tbody>';
				for(l=0;l<res.length;l++){
					_row = res[l];
					__firstName = _row.first_name;
					__firstName = __firstName.replace(/'/g, "\\'");
					__lastName = _row.last_name;
					__lastName = __lastName.replace(/'/g, "\\'");
					__email = _row.email;
					__phone = _row.phone_number;
					_c = _row.contactID;
					if(_c!=null){
						___a ='<a style="color:#56B2fe" href="javascript://" onclick="window.parent.openContactEditForm('+_row.contactID+')">'+__firstName+'</a>';
					} else {
						___a =__firstName;
					}
					_table +='<tr><td>'+___a+'</td><td>'+__lastName+'</td><td>'+__email+'</td><td>'+__phone+'</td></tr>';
				}
				_table +='</tbody></table>';
				window.parent.jQuery("#sortingPopup").find(".modal-body").html(_table);
				window.parent.jQuery("#sortingPopup").find("#lb"+_companyID).DataTable().destroy();						
				window.parent.jQuery("#sortingPopup").find('.modal-content').css({width:'600px'});
				window.parent.jQuery("#sortingPopup").css({width:'600px'}).modal("show");
				window.parent.jQuery("#sortingPopup").find("#lb"+_companyID).DataTable({destroy:true,paging:false,searching:false,language:{emptyTable:"No record found!"}});
				
			} else{
				alert("No user found");
			}
		}
	});
}
		
		
		function userStatus(s,o){
			_companyID = o.data('id');
			_url = "";
			if(s==0){
				_url = __baseUrl+"customers/activate_all_users/"+_companyID;
			} else{
				_url = __baseUrl+"customers/deactivate_all_users/"+_companyID;
			}
			jQuery.ajax({
				type:'GET',
				url:_url,data:{},cache:false,success:function(res){
					if(res>0){
						/*window.location = window.location.href;*/
						if(s==0){
							alert("Activate all users.");
							o.html("Deactivate").attr('onclick','userStatus(1,jQuery(this))');
						} else {
							alert("Deactivate all users.");
							o.html("Activate").attr('onclick','userStatus(0,jQuery(this))');
						}
						
					} else{
						alert("Please try after sometime.");
					}
				}
			});
		}
		
		  
		  jQuery(window).on('resize',function(){
			const totalHeight = jQuery(window).height();
			let mainHeight = totalHeight - 100;
			const calHeight = parseInt((mainHeight*25)/100);
			const calHeight1 = parseInt((mainHeight*25)/100);
			const calHeight2 = parseInt((mainHeight*50)/100);
			let availableWidth = jQuery(window).width();
				availableWidth = availableWidth-20;
			jQuery('.scroll-container').eq(0).css('height',calHeight+'px');
			jQuery('.scroll-container').eq(1).css('height',calHeight1+'px');
			jQuery('.scroll-container').eq(2).css('height',calHeight2+'px');
			hot1.updateSettings({
				width: availableWidth
			});
			hot2.updateSettings({
				width: availableWidth
			});
			hot3.updateSettings({
				width: availableWidth
			});
			  setTimeout(function(){
				console.log('Enter timeout');
				jQuery('#companies_request_box').css('height',calHeight+'px').data('originalstyle',jQuery('#companies_request_box').attr('style'));
				jQuery('#companies_request_box').find('.ht_master.handsontable').find('.wtHolder').css('height',calHeight+'px');
				jQuery('#companies_box').css('height',calHeight2+'px').data('originalstyle',jQuery('#companies_box').attr('style'));
				jQuery('#companies_box').find('.ht_master.handsontable').find('.wtHolder').css('height',calHeight2+'px');
				jQuery('#membership_request_box').css('height',calHeight1+'px').data('originalstyle',jQuery('#membership_request_box').attr('style'));
				jQuery('#membership_request_box').find('.ht_master.handsontable').find('.wtHolder').css('height',calHeight1+'px')
				},1000);
		   });
		  </script>
			</div>					

		</div>

	</div>

</div>