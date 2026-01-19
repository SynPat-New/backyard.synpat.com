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
.hide{display:none;}
.show{display:block;}
.title-hero{font-family:arial;font-size:20px;}
</style>
<div class="panel dashboard-box">
    <div class="panel-body">
		<div class="example-box-wrapper">	
			<div class="example-box-wrapper">
				<div class="col-lg-12 hide" id="assignCompany">
				<h3 class="title-hero">Assign a Company</h3>
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
			
			
				<h3 class="title-hero">Existing Customers</h3>
				<div class="scroll-container col-lg-12 cp-border">
					<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
				</div>
				<script>
				var company_table = document.getElementById('companies_box'),request_table = document.getElementById('companies_request_box'),hot1,hot2,isChecked;
				_requestINString = [];
				_companiesINString = [];
				_companiesINString=[<?php
						if(count($companies)>0){
							$i=0;
							foreach($companies as $contact){
								$memberShip = "";
								$getCount = getUsersByActDeactCompanies($contact->id,0);
								if($contact->membership==0): $memberShip = 'Vistor';elseif($contact->membership==1):$memberShip = 'Licensees';elseif($contact->membership==2):$memberShip = 'Participants';endif;
								$activationDate = '';
								$lastLogin = '';
								if($contact->activationDate!='0000-00-00 00:00:00'){
									$activationDate = date('M,d Y',strtotime($contact->activationDate));
								}
								if($contact->lastLogin!='0000-00-00 00:00:00'){
									$lastLogin = date('M,d Y',strtotime($contact->lastLogin));
								}
							echo "{'id':". $contact->id.",'create_date':'" . $activationDate . "','last_login':'" . $lastLogin . "','company_address':'" . $contact->company_address . "','company_name':'" . $contact->company_name . "','telephone':'" . $contact->telephone . "','bank_name':'" . $contact->bank_name . "','bank_account_no':'" . $contact->bank_account_no . "','routing_no':'" . $contact->routing_no . "','membership':'" . $memberShip . "','count_users':'" . $getCount . "'}";
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
							echo "{'id':". $contact->id.",'date':'" . date('M,d Y',strtotime($contact->create_date)) . "','first_name':'" . $contact->first_name . "','last_name':'" . $contact->last_name . "','job_title':'" . $contact->job_title . "','email':'" . $contact->email . "','company_address':'" . $address . "','company_name':'" . $contact->company_name . "','telephone':'" . $contact->phone_number . "','action':". $contact->id."}";
							if ($i < count($customer_request) - 1) {
								echo ",";
							}
						}
					}
				?>];
				var __baseUrl = '<?php echo $Layout->baseUrl?>';
				var totalHeight = jQuery(window).height();
				var mainHeight = totalHeight - 50;
				firstHeight = (mainHeight*30)/100;
				secondHeight = (mainHeight*70)/100;
				var availableWidth = jQuery(window).width();
				availableWidth = availableWidth-20;
				jQuery('.scroll-container').eq(0).css('height',firstHeight+'px');
				
				jQuery('.scroll-container').eq(1).css('height',secondHeight+'px');
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
					  width:function(){return availableWidth;},
					  height:function(){console.log('HEIGHT:CUSTOMER:'+firstHeight);return firstHeight;},
					  fillHandle: false,
					  stretchH:"all",
					  colHeaders:function(col){
						  var txt='';
						  switch(col){
							  case 0:
								txt ='Activation';
							  break;
							  case 1:
								txt ='Last Login';
							  break;
							  case 2:
								txt ='Name';
							  break;
							  case 3:
								txt ='IP Deptt Address';
							  break;
							  case 4:
								txt ='IP Deptt Telephone';
							  break;
							  case 5:
								txt ='Bank Name';
							  break;
							  case 6:
								txt ='Bank Account No';
							  break;
							  case 7:
								txt ='Routing No';
							  break;
							  case 8:
								txt ='Membership';
							  break;
							  case 9:
								txt ='Action';
							  break;
						  }
						  return txt;						 
					  },
					columnSorting: {						
						sortOrder: true
					},
					contextMenu: false,
					filters: true,
					dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
					columns: [
					   {
						data:'create_date',
						readOnly:true
					  },
					  {
						data:'last_login',
						readOnly:true
					  },
					  {
						data:'company_name',
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
						data:'count_users',
						renderer: countICONRender,
						readOnly: true
					  }
					],
					onInit:function(){
						console.log("Init call");setTimeout(function(){jQuery('#companies_request_box').css('height',firstHeight+'px');},1000);
					}
				});
			}
			implementCompanyTable();
			_MainRow = -1;
			function implementRequestTable(){
					hot2 = new Handsontable(request_table, {
					data: _requestINString,
					  autoWrapCol:true,
					  wordWrap:true,
					  rowHeaders: false,
					  minSpareRows: 0,
					  minSpareCols: 0,
					  manualColumnResize:true ,
					  minCols: 12,
					  maxCols: 12,
					  maxRows: _requestINString.length,
					  width:function(){console.log(availableWidth);return availableWidth;},
					  height:function(){return secondHeight;},
					  fillHandle: false,
					  stretchH:"all",
					  colHeaders:function(col){
						  var txt='';
						  switch(col){
							  case 0:
								txt ='Activate';
							  break;
							  case 1:
								txt ='Delete';
							  break;
							  case 2:
								txt ='Date';
							  break;
							  case 3:
								txt ='Company Name';
							  break;
							  case 4:
								txt ='First Name';
							  break;
							  case 5:
								txt ='Last Name';
							  break;
							  case 6:
								txt ='Email Address';
							  break;
							  case 7:
								txt ='Job Title';
							  break;
							  case 8:
								txt ='IP Deptt Address';
							  break;
							  case 9:
								txt ='Phone Number';
							  break;
							  
						  }
						  return txt;						 
					  },
					columnSorting: {						
						sortOrder: true
					},
					contextMenu: false,
					filters: true,
					dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
					columns: [
					 {
						data:'action',
						renderer: actionRender,
						readOnly: true
					 },
					 {
						data:'action',
						renderer: actionDeleteRender,
						readOnly: true
					 },
					 {
						data:'date',						
						readOnly: true
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
						data:'job_title',
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
					  }
					],afterSelection:function(r,c,r2,c2){
						_MainRow = r;
					}
				});
			}
			implementRequestTable();
			function companyLinkRender(instance, td, row, col, prop, value, cellProperties){
				currentVal = instance.getDataAtRowProp(row,'id');
				Handsontable.Dom.empty(td);
			    td.innerHTML = "<a href='javascript://' style='color:#56B2fe' onclick='getAllUsers(jQuery(this))' data-id='"+currentVal+"'>"+value+"</a>";
				return td;
			}
			function countICONRender(instance, td, row, col, prop, value, cellProperties){
			  currentVal = instance.getDataAtRowProp(row,'id');
			  Handsontable.Dom.empty(td);
			  console.log("VV:"+value);
			   if(parseInt(value)>0){
				   td.innerHTML = "<a href='javascript://' style='color:#56B2fe' onclick='userStatus(1,jQuery(this))' data-id='"+currentVal+"'>Deactivate</a>";
			  } else {
				  td.innerHTML = "<a href='javascript://' style='color:#56B2fe' onclick='userStatus(0,jQuery(this))' data-id='"+currentVal+"'>Activate</a>";
			  }			  
			  return td;
		  }
		  function actionRender(instance, td, row, col, prop, value, cellProperties){
			  currentVal = instance.getDataAtRowProp(row,'id');
			  currentEmail = instance.getDataAtRowProp(row,'email');
			  Handsontable.Dom.empty(td);
			  td.innerHTML = "<a href='javascript://' style='color:#56B2fe' onclick='activateUser(jQuery(this))' data-email='"+currentEmail+"' data-id='"+value+"'>Activate</a>";			  		  
			  return td;
		  }
		  function actionDeleteRender(instance, td, row, col, prop, value, cellProperties){
			  currentVal = instance.getDataAtRowProp(row,'id');
			  currentEmail = instance.getDataAtRowProp(row,'email');
			  Handsontable.Dom.empty(td);
			  td.innerHTML = "<a href='javascript://' style='color:#56B2fe' onclick='deleteCustomerRequest("+value+")' data-id='"+value+"'>Delete</a>";			  		  
			  return td;
		  }
		  function phoneICONRender(instance, td, row, col, prop, value, cellProperties){
			   Handsontable.Dom.empty(td);
			   _string = "";
			   _d =0;
				if(value!=''){
					_string =  '<a href="javascript://" onclick=\'window.parent.callFromLandline(encodeURIComponent("'+value+'"));\' style="color:#56b2fe"><i class="fa fa-phone" title="Work Phone"></i> '+value+'</a>';
					
				}
			   td.innerHTML =_string;
			   return td;
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
			window.parent.jQuery("#displayEmail").data('cr-id',o.data('id'));
			window.parent.jQuery("#displayEmail").data('cr-type','Customer');
			jQuery("#displayEmail").data('cr-r','6');	
			jQuery("#displayEmail").data('cr-lead','0');
			window.parent.findActivitesLeadsFromEmailCustomerRequest(o.data('email'));
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
						
					} else{
						alert("Please try after sometime.");
					}
				}
			});
		}
		
		function getAllUsers(o){
			_companyID = o.data('id');
			jQuery.ajax({
				type:'GET',
				url:__baseUrl+'customers/get_all_customers/'+_companyID,data:{},dataType:'json',cache:false,success:function(res){
					if(res.length>0){
						_table = '<div style="overflow-x:hidden;overflow-y:scroll;height:300px;"> <table id="lb'+_companyID+'" class="table table-striped table-hover"><thead><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th></tr></thead><tbody>';
						for(l=0;l<res.length;l++){
							_row = res[l];
							__firstName = _row.first_name;
							__firstName = __firstName.replace(/'/g, "\\'");
							__lastName = _row.last_name;
							__lastName = __lastName.replace(/'/g, "\\'");
							__email = _row.email;
							__phone = _row.phone_number;
							_table +='<tr><td>'+__firstName+'</td><td>'+__lastName+'</td><td>'+__email+'</td><td>'+__phone+'</td></tr>';
						}
						_table +='</tbody></table>';
						window.parent.jQuery("#sortingPopup").find(".modal-body").html(_table);
						window.parent.jQuery("#sortingPopup").find("#lb"+_companyID).DataTable().destroy();						
						window.parent.jQuery("#sortingPopup").find('.modal-content').css({width:'600px'});
						window.parent.jQuery("#sortingPopup").css({width:'600px'}).modal("show");
						window.parent.jQuery("#sortingPopup").find("#lb"+_companyID).DataTable({destroy:true,paging:false,searching:true,language:{emptyTable:"No record found!"}});
						
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
		setTimeout(function(){console.log('Enter timeout');jQuery('#companies_request_box').css('height',firstHeight+'px').data('originalstyle',jQuery('#companies_request_box').attr('style'));jQuery('#companies_request_box').find('.ht_master.handsontable').find('.wtHolder').css('height',firstHeight+'px');jQuery('#companies_box').css('height',secondHeight+'px').data('originalstyle',jQuery('#companies_box').attr('style'));jQuery('#companies_box').find('.ht_master.handsontable').find('.wtHolder').css('height',secondHeight+'px')},1000);
		  </script>
			</div>					

		</div>

	</div>

</div>