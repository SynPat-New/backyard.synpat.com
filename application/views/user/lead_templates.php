<style>
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;
	}
	#page-content {
	    background: #ffffff !important;
	}

	.dataTables_info,
	.dataTables_filter {
		display: none;
	}

	#db_from_litigation_iframe {
		margin-top: 20px;
	}
	.colorClass{
	color:#1E88E5 !important;
	text-decoration:underline;
}
</style>
<div class='col-lg-12'>
	<h2>Email Campaign / LinkedIn Campaign</h2>
	<p id="helpingText">
	1.Email messages can be made from a designed HTML part and above it a TEXT part. Linkedin messages can be made from a TEXT part, which includes a link to an HTML part, which the receiver can click and open in a new tab. The TEXT part for the message will be selected from the right table below, while the HTML part from the right table.<br/>
	2. Start with importing to this lead message's bank. The messages templates by clicking <a onclick="moveAllToLead(3)" href='javascript://' class='colorClass' style='display:inline-block;'>Update from Template General Bank</a>
	<?php if(count($count_bank_template)>0 && $count_bank_template->countLeadTemplates>0):?>
		<span style='color:red'> Messages are already imported.</span>
	<?php endif;?>
	Clicking the update button will overwrite the messages in this lead messages bank.<br/>
	3. If the message you are sending contains a link to the store, make sure that this lead is indeed in the store <select name="docket[category]" id="docketCategory" readonly class="form-control" style='border: 0px;box-shadow: none;border-bottom:1px solid #dfe8f1;height:20px;padding:0 2px;width: 170px;display: inline;'><option value='0'></option><?php 
															if(count($category_list)>0){
																foreach($category_list as $category){
																	$selected= "";
																	if(count($categoryList) > 0){
																		foreach($categoryList as $cat){
																			if($cat->main_category == 1 && ((int)$category->id==(int)$cat->category_id)){
																				$selected= "selected='selected'";
																				break;
																			}
																		}
																	}							
														?>
																<option <?php echo $selected;?> value="<?php echo $category->id;?>"><?php echo $category->name?></option>
														<?php
																}
															}
														?>
													</select>.<br/>
	4. Build the campaign by editing and adding a text message and / or an html message from the Lead's messages local bank: <a id="btnNewTemplate" class="colorClass" href='javascript://' style='display:inline-block' onclick="window.parent.getPredefinedMessages(3)" style='float:right;width:300px;'>Edit / Add Lead's campaign</a>.<br/>
	5. From the tables below, use the radio buttons to select the text part and the HTML part that consist the message.<br/>
	6. Select the stage <select id="campaign_stage" name="campaign_stage" style="width:155px;"><option value="" selected="SELECTED"></option><option value="" class="no-contact">1 No contact details</option><option value="1" class="torquoise">2 Contact found</option><option value="2"  class="torquoise">3 Invitation sent</option><option value="7" class="torquoise">4 Invitation received</option><option value="3" class="torquoise">5 Sale call scheduled</option><option value="4" class="seablue">6 Opportunity understood</option><option value="5" class="seablue">7 Documents reviewed</option><option value="8" class="seablue">8 Customer interested</option><option value="9" class="darksea">9 Documents exchanged</option><option value="10" class="darksea">10 RTP submitted</option><option value="11" class="darksea">11 Payment made</option><option value="6" class="redsea">12 Pass</option></select> run campaign by clicking <a id="btnActivityAll" href='javascript://' class=" colorClass" style='display:inline-block' onclick="startCampaign(<?php echo $s?>)" style='width:100px;'>Start Email Campaign</a> &nbsp; <a id="btnActivityAll" class="colorClass" style='display:inline-block' onclick="startCampaign(5)" href='javascript://' style='width:100px;'>Start Linkedin Campaign</a>  &nbsp; <a id="btnActivityAll" class="colorClass" style='display:inline-block' onclick="startCampaign(6)" href='javascript://' style='width:100px;'>Start Telephone Campaign</a>.
	</p>
	<div class='col-lg-12' style='float:left;width:100%;margin:5px 0;' id="formOptions">
		<p><input type="radio" value="1" name="contact_form" id="contact_form"/> Business contact form <input type="radio" name="contact_form" id="contact_form" value="2"/> Tech-Expert contact form</p>
	</div>
	<div class='col-lg-12' style='float:left;width:100%;' id="tblContainer">
	<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered main">
		<thead>
			<th>Stage</th>
			<th>Email Text Message</th>
			<th>HTML Message</th>
			<th>Linkedin Message</th>
			<th>Telephone Message</th>
		</thead>
		<tbody>
			<?php 
				if(count($stages) > 0){
					foreach($stages as $key =>$stage){
						$lead_templates_email = $stage['lead_templates_email'];
						$lead_templates_email_text = $stage['lead_templates_email_text'];
						$lead_templates_linkedin = $stage['lead_templates_linkedin'];
						$lead_templates_telephone = $stage['lead_templates_telephone'];	
						$stageName = "";						
						switch((int)$key){
							case 0:
								$stageName = "No contact details";
								break;
							case 1:
								$stageName = "Contact found";
								break;
							case 2:
								$stageName = "Invitation sent";
								break;
							case 7:
								$stageName = "Invitation received";
								break;
							case 3:
								$stageName = "Sale call scheduled";
								break;
							case 4:
								$stageName = "Opportunity understood";
								break;
							case 5:
								$stageName = "Documents reviewed";
								break;
							case 8:
								$stageName = "Customer interested";
								break;
							case 9:
								$stageName = "Documents exchanged";
								break;
							case 10:
								$stageName = "RTP submitted";
								break;
							case 11:
								$stageName = "Payment made";
								break;
							case 6:
								$stageName = "Pass";
								break;
						}
						if($stageName != ""):
			?>
				<tr>
					<td data-key="<?php echo $key?>" class="master"><?php echo $stageName;?></td>
					<td class="master">
						<?php 
							if(count($lead_templates_email_text) > 0){
						?>
							<table style="width:100%">
								<tbody>
									<?php 
										foreach($lead_templates_email_text as $textEmail){
											$checked = "";
											if($textEmail->status == 1){
												$checked = "CHECKED='CHECKED'";
											}
									?>
									<tr>
										<td>
											<input name='text_message' data-template-type="<?php echo $textEmail->template_type;?>" data-template-stage="<?php echo $textEmail->template_stage;?>" data-file='<?php echo $textEmail->file_name;?>' data-subject="<?php echo $textEmail->subject?>" type="radio" onclick="appendText(jQuery(this),'<?php echo $textEmail->file_name;?>',<?php echo $s?>,1)"/><a href="javascript://" onclick="deleteLeadTemplate(<?php echo $textEmail->id;?>,jQuery(this))"><i class="glyph-icon"><img src="<?php echo $Layout->aws_server_cdn;?>images/discard.png" style="opacity:0.55"></i></a> <?php echo $textEmail->subject?>
											
											<input type="checkbox" <?php echo $checked;?> style="float:right" value="1" onclick="checkMe(jQuery(this),<?php echo $textEmail->id;?>)"/>
											</td>
									</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						<?php
							}
						?>
					</td>
					<td class="master">
						<?php 
							if(count($lead_templates_email) > 0){
						?>
							<table style="width:100%">
								<tbody>
									<?php 
										foreach($lead_templates_email as $htmlEmail){
											$checked = "";
											if($htmlEmail->status == 1){
												$checked = "CHECKED='CHECKED'";
											}
									?>
									<tr>
										<td>
											<input name='predefine_message' data-template-type="<?php echo $htmlEmail->template_type;?>" data-template-stage="<?php echo $htmlEmail->template_stage;?>" data-file='<?php echo $htmlEmail->file_name;?>' data-subject="<?php echo $htmlEmail->subject?>" type="radio" onclick="appendText(jQuery(this),'<?php echo $htmlEmail->file_name;?>',<?php echo $s?>,0)"/><a href="javascript://" onclick="deleteLeadTemplate(<?php echo $htmlEmail->id;?>,jQuery(this))"><i class="glyph-icon"><img src="<?php echo $Layout->aws_server_cdn;?>images/discard.png" style="opacity:0.55"></i></a> <?php echo $htmlEmail->subject?>
											<input type="checkbox" <?php echo $checked;?> style="float:right" value="1" onclick="checkMe(jQuery(this),<?php echo $htmlEmail->id;?>)"/>
											</td>
									</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						<?php
							}
						?>
					</td>
					<td class="master">
						<?php 
							if(count($lead_templates_linkedin) > 0){
						?>
							<table style="width:100%">
								<tbody>
									<?php 
										foreach($lead_templates_linkedin as $textLinkedin){
											$checked = "";
											if($textLinkedin->status == 1){
												$checked = "CHECKED='CHECKED'";
											}
									?>
									<tr>
										<td>
											<input name='text_message' data-template-type="<?php echo $textLinkedin->template_type;?>" data-template-stage="<?php echo $textLinkedin->template_stage;?>" data-file='<?php echo $textLinkedin->file_name;?>' data-subject="<?php echo $textLinkedin->subject?>" type="radio" onclick="appendText(jQuery(this),'<?php echo $textLinkedin->file_name;?>',<?php echo $s?>,5)"/><a href="javascript://" onclick="deleteLeadTemplate(<?php echo $textLinkedin->id;?>,jQuery(this))"><i class="glyph-icon"><img src="<?php echo $Layout->aws_server_cdn;?>images/discard.png" style="opacity:0.55"></i></a> <?php echo $textLinkedin->subject?>
											<input type="checkbox" <?php echo $checked;?> style="float:right" value="1" onclick="checkMe(jQuery(this),<?php echo $textLinkedin->id;?>)"/>
										</td>
									</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						<?php
							}
						?>
					</td>
					<td class="master">
						<?php 
							if(count($lead_templates_telephone) > 0){
						?>
							<table style="width:100%">
								<tbody>
									<?php 
										foreach($lead_templates_telephone as $textPhone){
											$checked = "";
											if($textLinkedin->status == 1){
												$checked = "CHECKED='CHECKED'";
											}
									?>
									<tr>
										<td>
											<input name='text_message' data-id="<?php echo $textPhone->id;?>" data-template-type="<?php echo $textPhone->template_type;?>" data-template-stage="<?php echo $textPhone->template_stage;?>" data-file='<?php echo $textPhone->file_name;?>' data-subject="<?php echo $textPhone->subject?>" type="radio" onclick="appendText(jQuery(this),'<?php echo $textPhone->file_name;?>',<?php echo $s?>,6)"/><a href="javascript://" onclick="deleteLeadTemplate(<?php echo $textPhone->id;?>,jQuery(this))"><i class="glyph-icon"><img src="<?php echo $Layout->aws_server_cdn;?>images/discard.png" style="opacity:0.55"></i></a> <?php echo $textPhone->subject?>
											<input type="checkbox" <?php echo $checked;?> style="float:right" value="1" onclick="checkMe(jQuery(this),<?php echo $textPhone->id;?>)"/>
											</td>
									</tr>
									<?php
										}
									?>
								</tbody>
							</table>
						<?php
							}
						?>
					</td>
				</tr>
			<?php
						endif;
					}
				}
			?>
		</tbody>
	</table>
	</div>	
	<?php 
		$urlName ="";
		$acquisitionID = 0;
		if(count($categoryList) > 0){
			foreach($categoryList as $cat){
				if($cat->main_category == 1){
					$urlName ='/catalog?'.md5($lead_data->serial_number);
					break;
				}
			}
		}
		if(!empty($acquisition['acquisition']->store_name)):
			$acquisitionID = $acquisition['acquisition']->id;
		endif;
	?>
	<div id="db_from_litigation_iframe1" class='col-lg-12' style='float:left;width:100%;'></div>
	<div id="db_from_litigation_iframe" class='col-lg-12 mrg5T' style='float:left;width:100%;margin-top:5px;'></div>
</div>
<div id="embedString" style='display:none'></div>
<script> 
	let _profileText = '',_htmlTemplate = '',_textTemplate = '',_subject = '',_urlHrefTemplate = '<?php echo $urlName;?>',leadID='<?php echo $lead_id;?>',acquisitionID='<?php echo $acquisitionID;?>';
	function updatePortfolioCategory(o){
		if(leadID == 0 && window.parent.leadGlobal > 0){
			leadID = window.parent.leadGlobal;
		}
		if(leadID > 0){
			jQuery.ajax({
				url:__baseUrl+'dashboard/update_category',
				type:'POST',
				data:{c:o.val(),l:leadID,a:acquisitionID}
			}).done(function(d){
				console.log("category update",d);
			})
		} else {
			alert("Please select lead first.");
		}		
	}
	function moveAllToLead(t){
		if(t==4){
			data = {lead_id:window.parent.leadGlobal}
		} else if(t==3){
			data = {lead_id:window.parent.leadGlobal}
		}
		window.parent.call(window.__baseUrl+'users/moveAllToLeadBankTemplate','POST',data,window.parent.successMoveTemplate,'text');
	}
	function deleteLeadTemplate(n,o){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'users/delete_lead_template',
			data:{id:n},
			cache:false,
			success:function(data){
				if(data>0){
					const fileName = o.parent().find('input[type="radio"]').attr('data-file');
					o.parent().parent().remove();
					let iframe = $('#db_from_litigation_iframe1').find('iframe');
					if(iframe.length > 0){
						const src = iframe.attr("src");
						if(src == fileName){
							$('#db_from_litigation_iframe1').html('');
						}
					} else {
						iframe = $('#db_from_litigation_iframe').find('iframe');
						if(iframe.length > 0){
							const src = iframe.attr("src");
							if(src == fileName){
								$('#db_from_litigation_iframe').html('');
							}
						}
					}
				}
			}
		});
	}
	function checkMe(o,id){
		let check = 0;
		if(o.is(':checked')){
			check = 1;
		}
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'users/update_status_lead_template',
			data:{id:id,status:check},
			cache:false,
			success:function(data){
				if(data>0){
					console.log("checkMe",data);
				}
			}
		});
	}
	function appendText(o,n,s,d){
		height = 200;
		if(d==0){
			height = jQuery(window).height() - (jQuery("#tblContainer").height() + jQuery("#formOptions").height() + jQuery("#helpingText").height() + 80);
			if($('#db_from_litigation_iframe1').find('iframe').length > 0){
				height = height/2;
				$('#db_from_litigation_iframe1').find('iframe').css("height",height+"px");
				$('#db_from_litigation_iframe1').css("height",height+"px");
			}
			
			$('#db_from_litigation_iframe').css("height",height+"px");
			// console.log(url);

			$('#db_from_litigation_iframe').html('<iframe src="' + n + '" width="100%" height="' + height + 'px" scrolling="yes"></iframe>');
			if(s==2){
				_profileText = n;
				_htmlTemplate = n;
			} else if(s==1 || s == 3){
				jQuery.ajax({
					type:'POST',
					url:__baseUrl+'users/template_file_content',
					data:{name:n,s:s},
					cache:false,
					statusCode: {
						502: function () {
							appendText(o,n,s,d)
						}
					},
					success:function(data){
						_profileText = data;
						if(data!=""){
							_htmlTemplate = n;
						}
					}
				});
			}
		} else if(d==1 || d==5 || d == 6){
			console.log('PE');
			height = jQuery(window).height() - (jQuery("#tblContainer").height() + jQuery("#formOptions").height() + jQuery("#helpingText").height() + 80);
			if($('#db_from_litigation_iframe').find('iframe').length > 0){
				height = height/2;
				$('#db_from_litigation_iframe').find('iframe').css("height",height+"px");
				$('#db_from_litigation_iframe').css("height",height+"px");
			}
			$('#db_from_litigation_iframe1').css("height",height+"px");
			// console.log(url);
			t = 2;
			if(s==1 || s==3){
				t = 1;
			}
			$('#db_from_litigation_iframe1').html('<iframe src="' + n + '" width="100%" height="' + height + 'px" scrolling="yes"></iframe>');
			_subject = o.attr('data-subject');
			if(o.attr('name') == 'predefine_message'){
				_htmlTemplate = "";
			}
			jQuery.ajax({
			type:'POST',
			url:__baseUrl+'users/template_file_content',
			data:{name:n,s:t},
			cache:false,
			statusCode: {
				502: function () {
					appendText(o,n,s,d)
				}
			},
			success:function(data){
				_textTemplate = data;
				if(o.attr('name') == 'predefine_message'){
					_htmlTemplate = n;
				}				
			}});
		}
		/*jQuery.ajax({
			type:'POST',
			url:__baseUrl+'users/template_file_content',
			data:{name:n,s:s},
			cache:false,
			success:function(data){
				if(data==""){
					dd = confirm("File not found. Do you want to proceed further?");
					if(dd){
						if(s==1){
							window.parent.sendEmailImap(data,'');
						} else if(s==2){
							window.parent.sendLinkedMessage(data);
						}
					}
				} else {
					if(s==1){
						window.parent.sendEmailImap(data,n);
					} else if(s==2){
						window.parent.sendLinkedMessage(data);
					}
				}				
			}
		});*/
	}
	
	function getTemplateMessage(s){
		let campaignStage = document.getElementById("campaign_stage").value;
		let tableTemplates = jQuery("#tblContainer").find("table.main");
		if(campaignStage == ""){
			campaignStage = 0;
		}
		let selectedKeyTD  = tableTemplates.find('td[data-key="'+campaignStage+'"]');
		if(selectedKeyTD.length > 0){
			console.log("selectedKeyTD",selectedKeyTD.length);
			let selectedROW = selectedKeyTD.parent();
			let selectedROWCols =  selectedROW.find('td.master');
			console.log("selectedROWCols",selectedROWCols.length,s);
			if(s == 5 || s == 6){
				let tdSel = selectedROWCols.eq(s==5?3:4);
				console.log("tdSel",tdSel.length,s);
				if(tdSel.length > 0){
					let findInput = tdSel.find('input[name="text_message"]');
					console.log("findInput",findInput.length,s);
					if(findInput.length > 0){
						findInput.trigger("click");
					}
				}
			} else if(s==1 || s==3){
				let tdSel = selectedROWCols.eq(1);
				if(tdSel.length > 0){
					let findInput = tdSel.find('input[name="text_message"]');
					if(findInput.length > 0){
						findInput.trigger("click");
					}
				}
				tdSel = selectedROWCols.eq(2);
				if(tdSel.length > 0){
					let findInput = tdSel.find('input[name="predefine_message"]');
					if(findInput.length > 0){
						findInput.trigger("click");
					}
				}
			}
		}		
	}
	
	function checkTemplateMessageRetrieve(s){
		let fillTemplate = false;
		if(s == 1 || s == 3){
			if(_textTemplate != "" && _htmlTemplate != "" && _profileText != ""){
				fillTemplate = true;
			}
		} else if(s == 5 || s == 6){
			if(_textTemplate != ""){
				fillTemplate = true;
			}
		}
		if(fillTemplate){
			let _sendText = _textTemplate +' '+_profileText;
			_sendText = _sendText.replace(/'/g, '&#39;');	
			_sendText = _sendText.replace(/&nbsp;/g, ' ');	
			let campaignStage = document.getElementById("campaign_stage").value;
			if(s==1 || s==3){
				jQuery("#embedString:hidden").html(_sendText);
				if(jQuery("#embedString:hidden").find('#link_data_href').length>0){
					jQuery("#embedString:hidden").find('#link_data_href').attr('href','https://synpat.com'+_urlHrefTemplate); 
				}
				if(jQuery("#embedString:hidden").find('#link_data_href_another').length>0){
					jQuery("#embedString:hidden").find('#link_data_href_another').attr('href','https://synpat.com'+_urlHrefTemplate); 
				}
				_sendText = jQuery("#embedString:hidden").html();
			}	
			c = 0;
			if(jQuery("input[name='contact_form']").is(':checked')){
				c = jQuery("input[name='contact_form']:checked").val();
			}
			if(s==1 || s==3){	
				console.log("TemplateName:"+_htmlTemplate);
				window.parent.sendEmailImap(campaignStage,_sendText+"<br/>",_htmlTemplate,_subject,s,c);
			} else if(s==5 || s == 6){
				_sendText = _textTemplate;
				_sendText = _sendText.replace('<pre>','');
				_sendText = _sendText.replace('</pre>','');
				console.log("TemplateName:"+_htmlTemplate);
				if(s==5){
					window.parent.sendLinkedMessage(campaignStage,_sendText,_htmlTemplate,_subject,c);
				} else {
					let selectedTemplate = jQuery('input[name="text_message"]:checked').val();
					window.parent.sendTelephoneMessage(selectedTemplate,campaignStage,_sendText,_htmlTemplate,_subject,c);
				}
			}
		} else {
			setTimeout(()=>{checkTemplateMessageRetrieve(s);},2000);
		}
	}

	function startCampaign(s){
		getTemplateMessage(s);
		setTimeout(()=>{checkTemplateMessageRetrieve(s);},2000);
	}

	var ___table ;
	jQuery(document).ready(function(){
		_h = window.parent.$(window).height() - 120;
		/*___table = $('#db_from_litigation,#db_from_litigation1')
			.DataTable({
				"searching":true,
				"autoWidth": true,
				"paging": false,
				// "sScrollY": _h+"px",
				"sScrollY": '100px',
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			});*/
	});

	window.resizeDataTable = function(height) {
		$('#db_from_litigation_wrapper .dataTables_scrollBody').height(height / 2 - 85);
		$('#db_from_litigation_iframe').height(height / 2 - 85);
		$('#db_from_litigation_iframe1').height(height / 2 - 85);

		if($('#db_from_litigation_iframe iframe').length > 0) {
			$('#db_from_litigation_iframe iframe').height($('#db_from_litigation_iframe').height());
		}
		if($('#db_from_litigation_iframe1 iframe').length > 0) {
			$('#db_from_litigation_iframe1 iframe').height($('#db_from_litigation_iframe1').height());
		}
	}

	$(function() {
		parent.leadTemplatesResize();
	})
	/*
	$(function() {
		$('#db_from_litigation tbody a').on('click', function() {
			var url = $(this).attr('href'),
				height = $('#db_from_litigation_iframe').height();
			$('#db_from_litigation_iframe').html('<iframe src="' + url + '" width="100%" height="' + height + 'px" scrolling="yes"></iframe>');

			return false;
		});
	});
	*/
</script>