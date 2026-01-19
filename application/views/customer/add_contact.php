<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/menu.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/autocomplete/autocomplete.js"></script>
<style>
	body {
		overflow: auto !important;overflow-x:hidden !important;
		min-width: 0;
		width: 100% !important;font-size:13px;font-family:arial;margin:0px;
	}
	.ui-menu-item{list-style:none;padding:10px;border:1px solid #56b2fe;margin-bottom:3px;}
	.ui-menu-item:hover{background-color:#56b2fe;color:#fff;}	
	.ui-helper-hidden-accessible{display:none;}
	.ui-autocomplete {
	padding:0px;margin:0px;
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
  }
.form-control{font-family:arial;}
	</style>
<script>
__baseUrl = '<?php echo $Layout->baseUrl?>';
function ValidURL(str) {
  var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
  if(!regex .test(str)) {
    alert("Please enter valid URL.");
    return false;
  } else {
    return true;
  }
}
jQuery(document).ready(function(){
	jQuery('.input-string-group').each(function(){
		_w = jQuery(this).width();
		if(jQuery(this).find('.control-label').length>0){
			lbl = jQuery(this).find('.control-label').width();
			inputW = _w - lbl-15;
			if(jQuery(this).find('input[type="text"]').length>0){
				jQuery(this).find('input[type="text"]').css('width',inputW+'px');				
			}else if(jQuery(this).find('input[type="email"]').length>0){
				jQuery(this).find('input[type="email"]').css('width',inputW+'px');
			}else if(jQuery(this).find('textarea').length>0){
				jQuery(this).find('textarea').css('width',inputW+'px');
			}
		}
	});
	jQuery("#inviteeLinkedinUrl").on("click",function(){
		if(ValidURL(jQuery(this).val())){
			window.open(jQuery(this).val(),"_blank");
		}
	});	
	jQuery("#ccompanyFormSubmit").submit(function(e){
		e.preventDefault();
		jQuery("#message").html('');
		jQuery("#addContactTask").show();
		if(jQuery("#inviteeEmail").val()=="" ){
			alert("Please enter email address.");
		} else {
			jQuery.ajax({
				type:'POST',
				url:jQuery("#ccompanyFormSubmit").attr("action"),
				data:jQuery("#ccompanyFormSubmit").serializeArray(),
				success:function(d){
					jQuery("#addContactTask").hide();
					jQuery("#message").html(d);
				}
			});
		}
	})
})
</script>
<?php 
	$first_name = "";
	$last_name = "";
	$job_title = "";
	$telephone = "";
	$phone = "";
	$email = "";
	$secondary_email = "";
	$linkedin_url = "";
	$web_address = "";
	$address = "";
	$gateway = "";
	$no_contact = "";
	$note = "";
	$company_id = "0";
	$street = "";
	$city = "";
	$state = "";
	$zip = "";
	$country = "";
	$company_name = "";
	$imgUrl = "";
	if(count($contact)>0){
		$first_name = $contact->first_name;
		$last_name = $contact->last_name;
		$job_title = $contact->job_title;
		$telephone = $contact->telephone;
		$phone = $contact->phone;
		$email = $contact->email;
		$secondary_email = $contact->secondary_email;
		$linkedin_url = $contact->linkedin_url;
		$web_address = $contact->web_address;
		$address = $contact->address;
		$gateway = $contact->gateway;
		$no_contact = $contact->no_contact;
		$note = $contact->note;
		$company_id = $contact->company_id;
		$company_name = $contact->company_name;
		$street = $contact->street;
		$city = $contact->city;
		$state = $contact->state;
		$zip = $contact->zip;
		$country = $contact->country;
		$imgUrl = $contact->img_card;
	}
?>
<?php echo form_open('customers/add_contact/'.$contactID,array('class'=>"form-flat",'id'=>'ccompanyFormSubmit', 'style'=>'margin-left:2px; margin-right:-10px;'));?>
<div style='padding:10px'>
<div class="row">
	<div class='col-xs-12'>
	<h4 class="modal-title pull-left" id="createContactModalLabel" style="width:100%;height:30px">SynPat Partner Contact Form </h4>
		<button type="submit" id="buttonADDContact" class='btn btn-primary btn-mwidth'>Update</button><img src="<?php echo $Layout->aws_server_cdn?>images/ajax-loader.gif" alt="" id="addContactTask" style='display:none;margin-left:10px;'> <span id="message"></span>
	</div>
</div>
<div class="row">
	<div class='col-xs-12'>
		<div class="row">
			<div class="col-xs-6">
				<div class="form-group input-string-group">
					<label class="control-label">First Name:</label>
					<input type="text" name="invitee[first_name]" value="<?php echo $first_name;?>" id="inviteeFirstName" class="form-control" required placeholder=""/>
				</div>
			</div>
			<div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Last Name:</label> <input type="text" name="invitee[last_name]" id="inviteeLastName" value="<?php echo $last_name;?>" class="form-control" required placeholder=""/> </div> </div> </div>
			<div class="row">
			<div class="col-xs-12">
				<div class="form-group input-string-group">
					<label class="control-label">Job Title:</label>
					<input type="text" name="invitee[job_title]" value="<?php echo $job_title;?>" id="inviteeJobTitle" class="form-control" placeholder=""/>
				</div>
			</div>
		</div> 
		<div class="row">
		<div class="col-xs-6">
		
		
		<div class="row"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Work Phone:</label> <input type="text" name="invitee[telephone]" value="<?php echo $telephone;?>" id="inviteeTelephone" class="form-control" placeholder=""/> </div> </div> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Mobile Phone:</label> <input type="text" name="invitee[phone]" value="<?php echo $phone;?>" id="invitePhone" class="form-control" placeholder=""/> </div> </div> </div> 
		<div class="row"> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">E-mail:</label> <input type="email" name="invitee[email]" value="<?php echo $email;?>" id="inviteeEmail" class="form-control" placeholder=""/> </div> </div> <div class="col-xs-6"> <div class="form-group input-string-group"> <label class="control-label">Secondary E-mail:</label> <input type="email" name="invitee[secondary_email]" value="<?php echo $secondary_email;?>" id="inviteeSecondaryEmailAddress" class="form-control" placeholder=""/> <input type="hidden" name="invitee[web_address]" id="inviteeWebAddress" class="form-control" placeholder="" value="<?php echo $web_address;?>"/> </div> </div> </div> 
		<div class="row"> <div class="col-xs-12"> <div class="form-group input-string-group"> <label class="control-label">LinkedIN Profile Url:</label> <input type="text" name="invitee[linkedin_url]" value="<?php echo $linkedin_url;?>" id="inviteeLinkedinUrl" class="form-control" placeholder=""/> </div> </div> </div>
		<div class="row"> <div class="col-xs-12"> <div class="form-group input-string-group"> <label class="control-label">Address:</label> <textarea name="invitee[address]" id="inviteeAddress" value="<?php echo $address;?>" class="form-control" style='width:100%;height:200px;' placeholder=""></textarea> </div> </div> </div>
		<div class="row"> <div class="col-xs-6"> <div class="form-group" style='border:0px;'> <label class="control-label">Gateway:</label> <input type="checkbox" value='1' <?php if((int)$gateway==1):?>CHECKED='CHECKED' <?php endif;?> name="invitee[gateway]" id="inviteeGateway" class="" placeholder=""/> </div> </div> <div class="col-xs-6"> <div class="form-group" style='border:0px;'> <label class="control-label">No contact:</label> <input type="checkbox" value='1' name="invitee[no_contact]" id="inviteeNoContact" <?php if((int)$no_contact==1):?>CHECKED='CHECKED' <?php endif;?> class="" placeholder=""/> </div> </div></div>
		<div class="row"> 
		<div class="col-xs-12"> <div class="form-group input-string-group"> <label class="control-label">Note:</label> <textarea name="invitee[note]" id="inviteeNote" class="form-control" ><?php echo $note;?></textarea> </div> </div> </div> 
		<div class="row"> <div class="col-xs-12">
			<div class="form-group input-string-group"> <label class="control-label" id='lblCompany'>Company: <strong><?php echo $company_name; ?></strong></label>
			</div> 
			</div>
			<div class="col-xs-12"></div>
		</div>
		</div>
		<div class="col-xs-6">
			<?php 
				if(!empty($imgUrl) && $imgUrl!=null){
					try{
						$images = json_decode($imgUrl);
						if(count($images)>0){
							foreach($images as $img){
								if(!empty($img)){
				?>
								<div class="col-xs-3">
									<img src="<?php echo $img;?>" style='width:440px;'/>
								</div>
				<?php
								}
							}
						}
					}catch(Exception $e){
						
					}
				}
			?>
		</div>
		</div>
		
		
		<div class="mrg5T"> <input type="hidden" name="invitee[form_id]" id="inviteeFormId" class="form-control" value="<?php echo $invitee_form_id;?>"/><input type="hidden" name="invitee[form_fields_id]" id="inviteeFormFieldsId" class="form-control" value="<?php echo $invitee_form_fields_id;?>"/><input type="hidden" name="invitee[form_email]" id="inviteeFormEmail" class="form-control" value="<?php echo $invitee_form_email;?>"/><input type="hidden" name="invitee[street]" id="inviteeStreet" value="<?php echo $street;?>" class="form-control" placeholder=""/><input type="hidden" name="invitee[city]" id="inviteeCity" value="<?php echo $city;?>" class="form-control" placeholder=""/><input type="hidden" name="invitee[state]" value="<?php echo $state;?>" id="inviteeState" class="form-control" placeholder=""/><input type="hidden" name="invitee[zip]" value="<?php echo $zip;?>" id="inviteeZip" class="form-control" placeholder=""/><input type="hidden" name="invitee[country]" value="<?php echo $country;?>" id="inviteeCountry" class="form-control" placeholder=""/> </div>
	</div>
</div>
</div>
<?php echo form_close();?>