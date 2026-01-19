<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>icons/fontawesome/fontawesome.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/slimscroll/slimscroll.js"></script>

<style> 
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;
		font-family:arial;
		font-size:13px;
		margin:0px;
		padding:0px;
	}
	#page-content {
	    background: #ffffff !important;
	}
	ul{padding:0px;}
	li{list-style:none;float:left}
</style>
<div class="row">
<div class="col-xs-12" id="loading" style='display:none'>Please wait..</div>
<div class="col-md-6">
	<div class="col-md-12 com-sm-8" id="litigation_container">
		<ul class='nav'>
		<?php 
				if(count($business_cards)>0){
					foreach($business_cards as $card){
						$fileURL = $card->file_url;
						if(strpos($fileURL,"app.synpat.com") === false) {
							$fileURL = str_replace("https://synpat.com","https://app.synpat.com",$fileURL);
						}
						
			?>	
		<li data-row="<?php echo $card->id?>" style='margin-bottom:30px;'>
			<div class="col-md-12">
				<img src="<?php echo $fileURL?>" style='width:100%'/>
			</div>
			<div class='col-md-12'>
				<a href='javascript://' data-size='<?php echo $card->size?>' data-name='<?php echo $card->name?>' data-path='<?php echo $card->file_path?>' data-url='<?php echo $fileURL?>' onclick='scanOCR(jQuery(this))' class=''>Ocr</a>
				<a href='javascript://' onclick='checkImageFirst(jQuery(this))' data-size='<?php echo $card->size?>' data-name='<?php echo $card->name?>' data-path='<?php echo $card->file_path?>' data-url='<?php echo $fileURL?>'  class='' style='margin-top:5px;'>Add as back image</a>
				<!--<a href='javascript://' onclick='backImage(jQuery(this))' data-size='<?php echo $card->size?>' data-name='<?php echo $card->name?>' data-path='<?php echo $card->file_path?>' data-url='<?php echo $card->file_url?>'  class='btn' style='margin-top:5px;'>Back</a>-->
				<a href='javascript://' onclick='removeThis(jQuery(this))' data-id='<?php echo $card->id?>' class=' deleteB' style='margin-top:5px;'>Trash</a>
				<span class='status_ocr'></span>
			</div>
		</li>
		<?php
					}
				}
			?>
		</ul>
	</div>
</div>
  	<?php /*<div class="col-xs-7">
    <div class="col-md-12" id='open_contact_add'>
        <iframe src="<?php echo $Layout->baseUrl?>opportunity/add_contact/0" style="width:100%;border:0px;"></iframe>. 
     </div>
  	</div>*/?>
</div>

<script>
var totalHeight = jQuery(window).height();
var mainHeight = totalHeight - 110;
jQuery('#litigation_container').css({overflow:'auto',overflowX:'none',maxHeight:mainHeight+"px",minHeight:mainHeight+"px",height:mainHeight+'px'});
/*jQuery('#open_contact_add').find('iframe').css({maxHeight:mainHeight+"px",minHeight:mainHeight+"px",height:mainHeight+'px'});*/
var _scanOCRData ;
var _image = "";

function checkImageFirst(obj){
	_newImage = obj.data('url');
	_iframe = window.parent.jQuery('#open_contact_add').find('iframe').get(0);
	_htmlContent = _iframe.contentDocument;
	var _images = [];
	if(jQuery(_htmlContent).find("#show_images").find('div.col-xs-6').length>0){
		jQuery.each(jQuery(_htmlContent).find("#show_images").find('div.col-xs-6'),function(){
			if(jQuery(this).find("img").length>0){
				_images.push(jQuery(this).find("img").attr("src"));
			}
		});
	}
	_images.push(_newImage);
	jQuery(_htmlContent).find("#inviteeImgCard").val(JSON.stringify(_images));
	if(_images.length>0){
		jQuery(_htmlContent).find("#show_images").empty();
		jQuery.each(_images,function(id,img){
			jQuery(_htmlContent).find("#show_images").append("<div class='col-xs-6'><img src='"+img+"' style='width:100%;'/></div>");
		});
	}
}

function backImage(obj){
	_newImage = obj.data('url');
	var _images = [];
	if(_image!=""){		
		_images.push(_image);
	}
	if(_newImage!=""){		
		_images.push(_newImage);
	}
	_iframe = window.parent.jQuery('#open_contact_add').find('iframe').get(0);
	_htmlContent = _iframe.contentDocument;
	jQuery(_htmlContent).find("#inviteeImgCard").val(JSON.stringify(_images));
	if(_images.length>0){
		jQuery(_htmlContent).find("#show_images").empty();
		jQuery.each(_images,function(id,img){
			jQuery(_htmlContent).find("#show_images").append("<div class='col-xs-6'><img src='"+img+"' style='width:100%;'/></div>");
		});
	}
}

function removeThis(obj){
	jQuery.ajax({
		url:'<?php echo $Layout->baseUrl?>leads/delete_scan_card',
		type:'POST',
		data:{card:obj.data('id')}
	}).done(function(d){
		if(d>0){
			jQuery("#litigation_container").find("li[data-row='"+obj.data('id')+"']").remove();
			_iframe = window.parent.jQuery('#open_contact_add').find('iframe').get(0);
			_htmlContent = _iframe.contentDocument;
			if(jQuery(_htmlContent).find("#inviteeId").val()>0){
				window.parent.jQuery('#open_contact_add').find('iframe').attr('src',__baseUrl+'opportunity/add_contact/0');
			}
		}
	});
}
var _checkInterval ;
var __baseUrl = '<?php echo $Layout->baseUrl?>';
function checkContactSaved(){
	console.log('PACK3');
	_checkInterval = setInterval(function(){
		_iframe = window.parent.jQuery('#open_contact_add').find('iframe').get(0);
		_htmlContent = _iframe.contentDocument;
		if(jQuery(_htmlContent).find("#inviteeId").val()>0){
			console.log('PACK4');
			var $li = jQuery("#litigation_container").find('ul.nav li.active');
			if($li.length>0){
				jQuery.ajax({
					url:'<?php echo $Layout->baseUrl?>leads/delete_scan_card',
					type:'POST',
					data:{card:$li.attr('data-row')}
				}).done(function(d){
					if(d>0){
						jQuery("#litigation_container").find("li[data-row='"+$li.attr('data-row')+"']").remove();
						_iframe = window.parent.jQuery('#open_contact_add').find('iframe').get(0);
						_htmlContent = _iframe.contentDocument;
						if(jQuery(_htmlContent).find("#inviteeId").val()>0){
							window.parent.jQuery('#open_contact_add').find('iframe').attr('src',__baseUrl+'opportunity/add_contact/0');
						}
					}
				});
			}
			
			clearInterval(_checkInterval);
		} 
	},300);
}

function scanOCR(obj){
	var $thisLi = obj.parents('li');
	obj.parents('ul').find('li').removeClass('active');
	$thisLi.addClass('active');
	var _d = {
		file_name:obj.data('name'),
		file_url:obj.data('path'),
		size:obj.data('size')
	}	
	_iframe = window.parent.jQuery('#open_contact_add').find('iframe').get(0);
	_htmlContent = _iframe.contentDocument;
	if(jQuery(_htmlContent).find("#inviteeId").val()==0 && jQuery(_htmlContent).find("#inviteeCompanyId").val()==0){
		jQuery(_htmlContent).find("#ccompanyFormSubmit").get(0).reset();
		jQuery(_htmlContent).find("#show_images").empty();
		jQuery(_htmlContent).find(".show_name").find('strong').empty();
		jQuery(_htmlContent).find("#inviteeCompanyId").val(0);
	}	
	_image = obj.data('url');
	jQuery.ajax({
		url: "https://app.synpat.com/camcard/send.php", 
		type: "POST",             
		data: _d,
		beforeSend:function(){
			obj.parent().find('.status_ocr').html('Please wait...');
			return true;
		},		
		cache: false
	}).done(function(data,textStatus,jqXHR){		
		if(data!=""){
			jQuery.ajax({
				url:'https://app.synpat.com/camcard/file_create.php',
				type:'POST',
				data:{string_file:data},
				cache:false,
				beforeSend:function(){
					obj.parent().find('.status_ocr').html('Please wait...');
					return true;
				},
			}).done(function(d,textStatus,jqXHR){
				/*window.parent.openContactEditForm(0);*/
				if(d==""){obj.parent().find('.status_ocr').html('Not able to reteive data.');}
				obj.parent().find('.status_ocr').html('');
				_scanOCRData = d;
				embedEmailInContact()
			});
		} else {
			obj.parent().find('.status_ocr').html('Not able to reteive data.');
		}		
	});	
}

function embedEmailInContact(){
	_iframe = window.parent.jQuery('#open_contact_add').find('iframe').get(0);
	_htmlContent = _iframe.contentDocument;
	if(jQuery(_htmlContent).find('#inviteeEmail').length>0){
		/*jQuery(_htmlContent).find('#inviteeEmail').val(_topUpEmail);*/
		try{
			_d = jQuery.parseJSON(_scanOCRData);
			_companyList = [];
			if(_d.card_data.length>0){
				_string = "";			
				for(i=0;i<_d.card_data.length;i++){
					_nameA = _d.card_data[i].n;
					  _tel = _d.card_data[i].tel;
					_email = _d.card_data[i].email;	
					  _org = _d.card_data[i].org;
					  _adr = _d.card_data[i].adr;
					  _cellPhone = "";
					 _firstName = "";
					 _lastName = "";
					if(_nameA.length>0){
						for(j=0;j<_nameA.length;j++){
							_firstName =_nameA[j].FirstName; _lastName=_nameA[j].LastName;
						}
					}
					jQuery(_htmlContent).find("#inviteeFirstName").val(_firstName);
					jQuery(_htmlContent).find("#inviteeLastName").val(_lastName);
					if(_tel.length>0){
						if(_tel.length==1){
							jQuery(_htmlContent).find("#inviteeTelephone").val(_tel[0].Value);
						}
						if(_tel.length>1){
							if(_tel[1].Type[0]=="work"){
								jQuery(_htmlContent).find("#inviteeTelephone").val(_tel[1].Value);
								jQuery(_htmlContent).find("#invitePhone").val(_tel[0].Value);
							} else if(_tel[0].Type[0]=="cell"){
								jQuery(_htmlContent).find("#inviteeTelephone").val(_tel[0].Value);
								jQuery(_htmlContent).find("#invitePhone").val(_tel[1].Value);
							}
						}
					}						
					if(_email.length>0){
						jQuery(_htmlContent).find("#inviteeEmail").val(_email[0].Value);
					}
					if(_org.length>0){
						_jobTitle = "";
						jQuery.each(_org,function(id,job){
							name = job.Name;
							unit1 = (job.Unit1!=null)?job.Unit1:'';
							unit2 = (job.Unit2!=null)?job.Unit2:'';
							_jobTitle +=job.Name+" "+unit2+" "+unit1;
						});
						/*jQuery(_htmlContent).find("#inviteeJobTitle").val(_jobTitle);*/
					}					
					if(_adr.length>0){
						_string = ""
						for(j=0;j<_adr.length;j++){
							_string +=_adr[j].StreetAddress+', '+_adr[j].Locality+', '+_adr[j].Region+', '+_adr[j].PostalCode+', '+_adr[j].Country;
							if(j<_adr.length-1){
								_string +=', ';
							}
						}
						jQuery(_htmlContent).find("#inviteeAddress").val(_string);
					}
				}
				jQuery(_htmlContent).find("#show_images").empty();
				if(_image!=""){
					var _images = [];
					_images.push(_image);
					jQuery(_htmlContent).find("#inviteeImgCard").val(JSON.stringify(_images));
					if(_images.length>0){
						jQuery.each(_images,function(id,img){
							jQuery(_htmlContent).find("#show_images").append("<div class='col-xs-8'><img src='"+img+"' style='width:100%;'/></div>");
						});
					}
				}
				
			}
		}catch(err){
			console.log(err);
		}
	} else {
		setTimeout(function(){
			embedEmailInContact();
		},1000);
	}	
}
</script>