<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>nestable.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>jquery.nestable.js"></script>
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
	@media (min-width: 1200px){
		.container{width:900px;}
	}
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
	$id = $companyID;
	$companyUsers = array();
	if(count($company)>0){
		$company_name = $company->company_name;
		$web_address = $company->web_address;
		$state = $company->state;
		$city = $company->city;
		$email = $company->email;
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
		$country = $company->country;
		$categories = $company->categories;
		$departments_list = $company->departments_list;
		$subdepartments_list = $company->subdepartments_list;
		$sub_categories = $company->sub_categories;
		$companyUsers = $company->companyUsers;
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
    border-bottom: 0px solid rgba(204, 204, 204, 0.2);
    padding-left: 25px;
}
.hide{display:none;}
.show{display:block;}
.form-group label,.form-flat .form-group{margin-bottom:0px;}
.form-flat .form-group.input-string-group .form-control{margin-top:0px;}
.form-flat .form-control{height:30px;}
/*.ht_master .wtHolder{overflow-x:hidden;}*/
.handsontable td{height:29px;vertical-align:middle;padding:0px 0px 0px 5px;}
/*.handsontable tr:first-child td{border-top:0px;}*/
.nested-list-content{display:table-cell;}
@media (max-width: 1024px){
	/*.wtHolder{overflow:auto !important};*/
}
@media (min-width: 768px){
	.col-lg-6{width:50%;float:left;}
}
@media (max-width:767px){
	.disable-desktop{display:none;}
	.enable-phone{display:block;}
	.enable-desktop{display:none;}
}
@media (min-width:768px){
	.disable-phone{display:none;}
	.enable-desktop{display:block;}
	.disable-desktop{display:none;}
}
.mrgT5{margin-top:5px;}
</style>
<div class="container" style='margin-top:40px;padding: 40px 20px 10px 20px;'>
	<div class="row">		
		<div class="col-lg-12">
			<?php echo form_open('customers/add_company/'.$companyID,array('class'=>"form-flat",'id'=>'ccompanyFormSubmit'));?>
			<div class="col-lg-12">
				<!--<h3 class="modal-title pull-left" id="createContactModalLabel" style="width:100%;height:30px;text-align:center;text-decoration:underline;">SynPat Partner Contact Form </h3>	-->	
				<img src="<?php echo $Layout->aws_server_cdn?>images/ajax-loader.gif" alt="" id="addContactTask" style='display:none;margin-left:10px;'> <span id="loading_message"></span>
			</div>
			<div class="col-lg-12" id="main_container">
				<div class="row">	
				<div class="col-sm-12" id="frmPartner"> 
					<div class="row"> 
						<div class="col-lg-12"> 
							<div class="form-group input-string-group"> 
								<label class="control-label">Company Name:</label>
								<input type="text" name="company[company_name]" id="companyJobTitle" value="<?php echo $company_name?>" class="form-control" placeholder="" style='width:45%;'/> 
							</div>
						</div>
					</div>
					<div class="row"> 
						<div class="col-lg-6"> 
							<div class="form-group input-string-group"> 
								<label class="control-label">Web address:</label> 
								<input type="text" name="company[web_address]" id="companyWebAddress" class="form-control" placeholder="" value="<?php echo $web_address?>" style='width:54%;'/><input type="hidden" name="company[state]" id="companyState" class="form-control" placeholder="" value="<?php echo $state?>"/> 
							</div>
						</div>
						<div class="col-lg-6"> 
							<div class="form-group input-string-group">
								<label class="control-label">Telephone:</label>
								<input type="text" name="company[telephone]" id="companyTelephone" class="form-control" placeholder="" value="<?php echo $telephone?>" style='width:61%;'/>
							</div>
						</div>
					</div>  
					<div class="row">
						<div class="col-lg-12"> 
							<div class="form-group input-string-group">
								<label class="control-label">Street:</label>
								<input type="text" name="company[company_address]" value="<?php echo $company_address?>" id="inviteeStreet" class="form-control" placeholder="" style='width:82%;'/>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group input-string-group">
								<label class="control-label">City:</label>
								<input type="text" name="company[city]" id="companyCity" value="<?php echo $city?>" class="form-control" placeholder="" style='width:80%;'/>
							</div> 
						</div>
						<div class="col-lg-6"> 
							<div class="form-group input-string-group"> 
								<label class="control-label">Country/Region:</label>
								<select name="company[country]" id="companyCountry" class="form-control" placeholder="" style='width: 66%;margin-top: 0px;display: block;float: none;border: 0px;'>
									<option value=""></option>
									<?php 
										$companyList = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antartica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegowina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos Islands","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Cota D'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","France Metropolitan","French Guiana","French Polynesia","French Southern Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Heard and McDonald Islands","Holy See","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Democratic People's Republic of Korea","Korea","Kuwait","Kyrgyzstan","Lao","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi",    "Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint LUCIA","Saint Vincent","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Seychelles","Sierra","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia","Span","SriLanka","St. Helena","St. Pierre and Miguelon","Sudan","Suriname","Svalbard","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States",  "United States Minor Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Virgin Islands (British)","Virgin Islands (U.S)","Wallis and Futana Islands","Western Sahara","Yemen","Yugoslavia","Zambia","Zimbabwe");
										foreach($companyList as $co){
									?>
										<option value="<?php echo $co;?>" <?php if($co==$country):?> SELECTED='SELECTED' <?php endif;?>><?php echo $co;?></option>
									<?php
										}
									?>
								</select>
								<!--<input type="text" name="company[country]" value="<?php echo $country?>" id="companyCountry" class="form-control" placeholder="" style='width:45%;'/>-->
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<button type="submit" id="buttonADDCCompany" class="btn btn-primary btn-mwidth" style='float:right;margin:10px 10px 0 0;'>Update</button>
						</div>
					</div>
				</div>	
				<div class="col-sm-12 disable-desktop enable-phone" style='margin-top:30px;'>
					<h5>Users</h5>
					<div class="row mrgT5">
						<div class="col-xs-6">
							<input name="user_name" id="user_name" class="form-control" value="" placeholder="Name"/>
						</div>
						<div class="col-xs-6">
							<input name="user_title" id="user_title" class="form-control" value="" placeholder="Title"/>
						</div>
					</div>
					<div class="row mrgT5">
						<div class="col-xs-12">
							<input name="user_email" id="user_email" class="form-control" value="" placeholder="Email"/>
						</div>
					</div>
					<div class="row mrgT5">
						<div class="col-xs-6">
							<input name="user_work" id="user_work" value="" class="form-control" placeholder="Work"/>
						</div>
						<div class="col-xs-6">
							<input name="user_mobile" id="user_mobile" value="" class="form-control" placeholder="Mobile"/>
						</div>
					</div>					
				</div>
				<div class="col-sm-12 enable-desktop disable-phone" id='company_users_show_table' style='margin-top:30px;background:#F0F0F0;'>
					<script>
						var company_table = document.getElementById('company_users_show_table'),hot1;
						_companiesUsers = [];
						_companiesINString=[<?php
							if(count($companyUsers)>0){
								$i=0;
								foreach($companyUsers as $user){				
									$name = trim($user->name);
									$title = $user->job_title;
									$email = $user->email;
									$phone = $user->phone;
									$telephone = $user->telephone;
								echo "{'id':". $user->id.",'name':'".$name."','title':'" . $title . "','email':'" . $email . "','phone':'" . $phone . "','telephone':'" . $telephone . "'}";
								if ($i < count($companyUsers) - 1) {
									echo ",";
								}
								}
							}
						?>];
						var totalHeight = jQuery(window).height();
						var mainHeight = totalHeight - 220;
						var availableWidth = jQuery("#company_users_show_table").width();
						function implementCompanyTable(){
							  hot1 = new Handsontable(company_table, {
									data: _companiesINString,
									  autoWrapCol:true,
									  wordWrap:true,
									  rowHeaders: false,
									  minSpareRows: 1,
									  manualColumnResize:true ,
									  minCols: 5,
									  maxCols: 5,									  
									  fillHandle: false,
									  stretchH:"all",
									  colHeaders:['Name','Title','Email','Work','Mobile'],
									columnSorting: {						
										sortOrder: true
									},
									contextMenu: false,
									filters: false,
									dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
									columns: [					  
									  {
										data:'name'
									  },
									  {
										data:'title'
									  },
									  {
										data:'email'
									  },
									  {
										data:'phone'
									  },
									  {
										data:'telephone'
									  }
									],
									afterInit:function(){
										setTimeout(function(){
											jQuery("#main_container").css('padding','0px');
											jQuery("#company_users_show_table").css('padding','0px');
										},200);
									}
						  });
						 }		 
						 implementCompanyTable();
						 jQuery(document).ready(function(){
							jQuery(window).resize(function(){
								
								/*hot1.updateSettings({
									width: function(){ console.log(jQuery(window).width());return jQuery("#company_users_show_table").width();}
								});*/
							});
						});
					</script>
				</div>
				</div>
			</div>
			<div class="col-lg-12" style='margin-top:30px'>
				<div class="col-sm-12" id="container_nestable" style='margin:0px -40px;'>
					<div class="dd types" id="nestable1"><?php echo buildTechnologyMenu($companyID,0);?></div>
				</div>
			</div>
			<input type="hidden" name="company[company_name_alias]" id="companyCompanyNameAlias" class="form-control" placeholder="" value="<?php echo $company_name_alias?>" style='width:26%;'/><input type="hidden" name="company[postal_code]" id="companyZip" class="form-control" placeholder="" value="<?php echo $postal_code?>"/>
			<input type="hidden" name="company[form_id]" id="companyFormId" class="form-control" value="<?php echo $invitee_form_id;?>"/><input type="hidden" name="company[form_fields_id]" id="companyFormFieldsId" class="form-control" value="<?php echo $invitee_form_fields_id;?>"/><input type="hidden" name="company[form_email]" id="companyFormEmail" class="form-control" value="<?php echo $invitee_form_email;?>"/>

			<?php echo form_close();?>
		</div>
	</div>
</div>
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
    font-size: 13px;
    vertical-align: middle;
    cursor: pointer;
	font-family:arial;
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
.css-label1>a,.css-label3>a{color:#56b2fe;}
.dd-item > button[data-action="cancel"]:before{content:'';}
.dd-item >button[data-action="expand"],.dd-item >button[data-action="collapse"]{top:2px;}
#clasify{
  -moz-user-select: none;
  -khtml-user-select: none;
  -webkit-user-select: none;
  user-select: none;
}
body{
	-moz-user-select: none;
  -khtml-user-select: none;
  -webkit-user-select: none;
  user-select: none;
}
.fa-long-arrow-down{display:none;}
div.nested-list-content .listbox{margin-left:0px;}
</style>


<script>
	__baseUrl = '<?php echo $Layout->baseUrl?>';
	function openClasify(){
		if(jQuery("#clasify").hasClass('hide')){
			jQuery("#clasify").removeClass('hide').addClass('show');
		} else {
			jQuery("#clasify").removeClass('show').addClass('hide');
		}
		widthChange();
	}
function linkedInSearch(){
	_companyName = jQuery("#companyJobTitle").val();
	urlString = "";
	if(_companyName!=""){
		urlString = "https://www.linkedin.com/vsearch/p?company="+_companyName+"&openAdvancedForm=true&companyScope=C&locationType=Y&orig=ADVS&sa=D&sntz=1";
		window.open(urlString,'_blank');
	} else {
		alert("Company name is blank");
	}	
}

function widthChange(){
	jQuery('.input-string-group').each(function(){
		_w = jQuery(this).width();
		if(jQuery(this).find('.control-label').length>0){
			lbl = jQuery(this).find('.control-label').width();
			if(jQuery(this).find('input[type="text"]').length>0){
				inputW = _w - lbl-12;
				jQuery(this).find('input[type="text"]').css('width',inputW+'px');
			}
		}
	})
}
jQuery(window).resize(function(){
	widthChange()
})
	jQuery(document).ready(function() {
		/*widthChange();*/
		document.addEventListener('contextmenu', event => event.preventDefault());
		checkBoxClickEvent();
		
		/**/
	jQuery("#ccompanyFormSubmit").submit(function(e){
		e.preventDefault();
		if(jQuery('input[name="preferences[technology][]"]:checked').length>0){
			jQuery("#loading_message").html("Please wait...");
			jQuery.ajax({
				type:'POST',
				url:jQuery("#ccompanyFormSubmit").attr("action"),
				data:jQuery("#ccompanyFormSubmit").serializeArray(),
				success:function(d){
					jQuery("#loading_message").html(d);
					
				}
			})
		} else {
			alert("Please select atleast one technology.");
		}
	})
	
} );
</script>
<script>
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

__options1 = { 
		collapse:true,
		maxDepth:3,
		group: 1
	};
function callNestable(){
	jQuery('#nestable1').nestable(__options1);	
	jQuery(".dd-nodrag").on("mousedown", function(event) { // mousedown prevent nestable click
		event.preventDefault();
		return false;
	});
	jQuery(".dd-nodrag").on("touchstart", function(event) { // touchmove prevent nestable click
		event.preventDefault();
		return false;
	});
	jQuery(".dd-nodrag").on("touchmove", function(event) { // touchmove prevent nestable click
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
	
} 
function cancelMe(o,s){
		
}
function addSaveMe(o){ 
	
}
function updateCategorySectorArea(){
	window.location = window.location.href;	
}
function openForEdit(o){
		
}
function updateMe(o){
		
}
function closeMe(o){
	
}
function checkMeWithOther(o,s){
	o.parents('li').find("ol li").find('input[type="checkbox"]').each(function(){
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
				$LI.find('input.parent').prop('checked',false);
				$LI.find('span.css-label1').addClass('black-check').removeClass('lite-gray-check');
				$LI.parent().parent().find('input.css-checkbox').prop('checked',false);
				$LI.parent().parent().find('span.css-label').addClass('black-check').removeClass('lite-gray-check');
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
				$LI.find('input.parent').prop('checked',false);
				$LI.find('span.css-label3').addClass('black-check').removeClass('lite-gray-check');
				$LI.parent().parent().find('input.css-checkbox-2').prop('checked',false);
				$LI.parent().parent().find('span.css-label2').addClass('black-check').removeClass('lite-gray-check');
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
</script>
