<?php 
$Portfolio = "";
$Syndication = "";
$Simulator = "";
$Purchase = "";
$License = "";
$Buy = "";
$Program = "";
$Document = "";
$Diligence = "";
$ClaimChart = "";
$PriorArt = "";
$Damages = "";
$Impact = "";
$Price="";
if(count($acordion_text)>0){
	$Portfolio = $acordion_text->License->portfolio_text;
	$Syndication = $acordion_text->License->syndication_tab;
	$Simulator = $acordion_text->License->simulator_text;
	$Document = $acordion_text->License->document_text;
	$Diligence = $acordion_text->License->due_diligence_tab;
	$ClaimChart = $acordion_text->License->claim_chart_tab;
	$Impact = $acordion_text->License->impact_tab;
	$Price = $acordion_text->License->price_tab;
}
$typeOfTemplate = array(array("id"=>'1','title'=>"Send Confirmation"),array('id'=>"2",'title'=>"Sales Activity"),array('id'=>"3",'title'=>"Calendar Template"),array('id'=>"4",'title'=>"Call IN"));
?>
<script>
jQuery(document).ready(function(){
	enableEditor();
});
function enableEditor(){
	jQuery('body').removeAttr('onselectstart');
	/*document.oncontextmenu=new Function("return true");*/
	$(function() { "use strict";
			$('.wysiwyg-editor').summernote({
				fontsize:'15',
				height: 350,
				toolbar: [
					['style', ['bold', 'italic', 'underline', 'clear']],
					['fontsize', ['fontsize']],
					['color', ['color']],
					['para', ['ul', 'ol', 'paragraph']],
					['height', ['height']],
				],oninit:function(){
					jQuery('[data-toggle=dropdown]').dropdown();
				}
			});
		});
		$("#generalSubject,#generaTemplateHtml,#generalType").focus(function(){
			jQuery('[data-toggle=dropdown]').dropdown();
		});
}

</script>

<style>
	div.dataTables_filter label {
		float: right;
	}
	div.dataTables_filter input {
	    box-shadow: none;
	    float: left;
	    height: 24px;
	    margin-bottom: 2px;
	    padding-left: 5px;
	    padding-right: 5px;
	}

	table .btn-primary,
	table .btn-danger {
		background: none !important;
		border: none !important;
		display: inline;
		line-height: 1;
		padding: 0;
	}
	table .btn-primary {
		color: #2196f3 !important;
	}
	table .btn-danger {
		color: #d9534f !important;
	}
	.helpText {
    padding-left: 32px;
    font-size: 17px;
    max-width: 1185px;
    padding-top: 10px;
    font-family: 'Arial', sans-serif;
    font-weight: normal
}
.helpText ul {
    padding-left: 40px
}
.helpText {
    font-size: 15px !important;
    line-height: 1.6;
    font-family: Arial;
    color: #444441 !important
}
.helpText p {
    margin-bottom: 0px
}
.abs {
    position: absolute;
    width: 1183px;
    height: 47px
}
.helpText blockquote h1,
.helpText blockquote h2,
.helpText blockquote h3,
.helpText blockquote h4,
.helpText blockquote h5,
.helpText blockquote h6 {
    text-transform: none !important
}
	.helpText ul {
    padding-left: 40px
}
.helpText {
    font-size: 15px !important;
    line-height: 1.6;
    font-family: Arial;
    color: #444441 !important
}
.helpText p {
    margin-bottom: 0px
}
body{min-width:auto;}
	.helpText ol li, .helpText ul li{margin-bottom:26px !important;margin-top:0px !important}
</style>

<div class="panel dashboard-box" style="border:0px;">
    <div class="panel-body pad0T">
		<div class="example-box-wrapper">
			<?php 
			if($this->session->flashdata('message')){
			?>
				<?php echo $this->session->flashdata('message');?>
			<?php					
				}
			?>
			<div id="form_holder" style='display:<?php if(!isset($update_data)):?>none;<?php endif;?>'>
			<?php echo form_open('general/email_templates',array('class'=>"form-horizontal form-flat", 'style'=>'margin-bottom: 0;'))?>           
			<div class="example-box-wrapper">
				<div class="row row-width">
					<div class="col-width" style="width: 100%;">
						<div class="form-group input-string-group select-string-group" style="margin-left: 0;">
		                    <label class="control-label">Template Type:</label>
		                    <?php  
								$value="0";
								if(isset($update_data)) : $value =  $update_data->type; endif;
							?>
							<select name="general[type]" id="generalType" class='form-control' required="required" style="width:250px">
								<option value="">-- Select Template Type</option>
								<?php
									for($i=0;$i<count($typeOfTemplate);$i++){
										$selected = '';
										if($value==$typeOfTemplate[$i]['id']){
											$selected = "SELECTED='SELECTED'";
										}
								?>
										<option value="<?php echo $typeOfTemplate[$i]['id'];?>" <?php echo $selected;?>><?php echo $typeOfTemplate[$i]['title'];?></option>
								<?php
									}
									
								?>
								
							</select>
						</div>
						<div class="form-group input-string-group mrg5T" style="margin-left: 0;">
		                    <label class="control-label">Subject</label>
		                    <input type="text" name="general[subject]" id="generalSubject" class='form-control' value="<?php  if(isset($update_data)) : echo $update_data->subject; endif;?>" required="required" style="width:250px"/>
		                </div>
						<div class="form-group input-string-group mrg5T" style="margin-left: 0;">
		                    <label class="control-label mrg20B">Description</label>
		                    <textarea name="general[template_html]" id="generaTemplateHtml" class='form-control wysiwyg-editor' rows="5" cols="25"><?php  if(isset($update_data)) : echo $update_data->template_html; endif;?></textarea>
		                </div>						
						<div class="mrg5T">
		                    <input type="hidden" id="id" name="id" value="<?php if(isset($id)): echo $id; else: echo "0"; endif; ?>"/>
							<button type="submit" class="btn btn-primary btn-mwidth">Save</button>
							<button type="button" class="btn btn-mwidth btn-default" onclick="cancelForm();">Cancel</button>
						</div>
					</div>
				</div>
			</div>
			
			<?php echo form_close();?> 
			</div>
	        <div class="row">				
				<h3 class="title-hero mrg15T " style="">Email Templates <a class='btn btn-mwidth btn-default float-right' href="javascript://" onclick="getForm();">New Template</a></h3>
				<div class='col-lg-12'>
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="db_from_litigation" >
						<thead>
							<tr>
								<th>Subject</th>
								<th>Type</th>                            
								<th>Description</th>                  
								<th width="80px">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								if(count($templates)>0){
									foreach($templates as $lit){
						?>
									<tr data-item-idd="<?php echo $lit->id;?>">
										<td><?php echo $lit->subject?></td>
										<td><?php 
												$typeTitle = "";
												for($i=0;$i<count($typeOfTemplate);$i++){
													$selected = '';
													if($lit->type==$typeOfTemplate[$i]['id']){
														$typeTitle = $typeOfTemplate[$i]['title'];
													}
												}
								
												echo $typeTitle;
											?>
										</td>
										<td><?php echo $lit->template_html?></td>
										<td><a class="btn btn-xs" href="<?php echo $Layout->baseUrl;?>general/email_templates/<?php echo $lit->id?>"><i class='glyph-icon icon-edit'></i></a><a href='<?php echo $Layout->baseUrl;?>general/delete_template/<?php echo $lit->id?>'><i class='glyph-icon icon-close'></i></a></td>
									</tr>
						<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="example-box-wrapper">
			<a class='btn btn-mwidth btn-default float-right' href="javascript://" onclick="getEditAccordion();">Edit Accordion Text</a>
			<h3 class="title-hero mrg15T ">Accordion Text</h3>			
			<div class="row" id="display_text_accordion">
				<div class='col-lg-12'>
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
						<thead>
							<tr>
								<th>Accordion Type </th>
								<th>Text</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Portfolio</td>
								<td><div class="helpText"><?php echo $Portfolio;?></div></td>
							</tr>
							<tr>
								<td>Syndication</td>
								<td><div class="helpText"><?php echo $Syndication;?></div></td>
							</tr>
							<tr>
								<td>Price</td>
								<td><div class="helpText"><?php echo $Price;?></div></td>
							</tr>
							<tr>
								<td>Simulator</td>
								<td><div class="helpText"><?php echo $Simulator;?></div></td>
							</tr>
							<tr>
								<td>Documents</td>
								<td><div class="helpText"><?php echo $Document;?></div></td>
							</tr>
							<tr>
								<td>Scope</td>
								<td><div class="helpText"><?php echo $Diligence;?></div></td>
							</tr>
							<tr>
								<td>Quality</td>
								<td><div class="helpText"><?php echo $ClaimChart;?></div></td>
							</tr>							
							<tr>
								<td>Impact</td>
								<td><div class="helpText"><?php echo $Impact;?></div></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row hide" id="accordion_text_form">
				<div class="col-lg-12">
					<?php echo form_open('general/accordion',array('class'=>"form-horizontal form-flat", 'style'=>'margin-bottom: 0;'))?>  
					<div class="example-box-wrapper">
						<div class="row row-width">
							<div class="col-width" style="width: 100%;">
								<div class="form-group input-string-group select-string-group" style="margin-left: 0;">
									<label class="control-label col-lg-12"><strong>Portfolio:</strong></label>
									<textarea class='wysiwyg-editor' name='portfolio_text' id='portfolio_text'><?php echo $Portfolio;?></textarea>
								</div>
								<div class="form-group input-string-group select-string-group" style="margin-left: 0;">
									<label class="control-label col-lg-12"><strong>Syndication:</strong></label>
									<textarea class='wysiwyg-editor' name='syndication_text' id='syndication_text'><?php echo $Syndication;?></textarea>
								</div>
								<div class="form-group input-string-group select-string-group" style="margin-left: 0;">
									<label class="control-label col-lg-12"><strong>Price:</strong></label>
									<textarea class='wysiwyg-editor' name='price_text' id='price_text'><?php echo $Price;?></textarea>
								</div>
								<div class="form-group input-string-group select-string-group" style="margin-left: 0;">
									<label class="control-label col-lg-12"><strong>Simulator:</strong></label>
									<textarea class='wysiwyg-editor' name='simulator_text' id='simulator_text'><?php echo $Simulator;?></textarea>
								</div>	
								<div class="form-group input-string-group select-string-group" style="margin-left: 0;">
									<label class="control-label col-lg-12"><strong>Documents:</strong></label>
									<textarea class='wysiwyg-editor' name='suggestions_text' id='suggestions_text'><?php echo $Document;?></textarea>
								</div>
								<div class="form-group input-string-group select-string-group" style="margin-left: 0;">
									<label class="control-label col-lg-12"><strong>Scope:</strong></label>
									<textarea class='wysiwyg-editor' name='due_diligence_text' id='due_diligence_text'><?php echo $Diligence;?></textarea>
								</div>
								<div class="form-group input-string-group select-string-group" style="margin-left: 0;">
									<label class="control-label col-lg-12"><strong>Quality:</strong></label>
									<textarea class='wysiwyg-editor' name='claim_chart_text' id='claim_chart_text'><?php echo $ClaimChart;?></textarea>
								</div>
								<div class="form-group input-string-group select-string-group" style="margin-left: 0;">
									<label class="control-label col-lg-12"><strong>Impact:</strong></label>
									<textarea class='wysiwyg-editor' name='impact_text' id='impact_text'><?php echo $Impact;?></textarea>
								</div>
								<div class="mrg5T">
									<button type="submit" class="btn btn-primary btn-mwidth">Save</button>
									<button type="button" class="btn btn-mwidth btn-default" onclick="cancelAccordionForm();">Cancel</button>
								</div>
							</div>
						</div>
					</div>
					<?php echo form_close();?> 					
				</div>
			</div>
		</div>
	</div>
</div>

<script>
function getEditAccordion(){
	jQuery("#accordion_text_form").removeClass("hide").addClass("show");
	jQuery("#display_text_accordion").addClass("hide").removeClass("show");
	enableEditor();
	jQuery('[data-toggle=dropdown]').dropdown();
}
function cancelAccordionForm(){
	jQuery("#accordion_text_form").addClass("hide").removeClass("show");
	jQuery("#display_text_accordion").removeClass("hide").addClass("show");
}
function getForm(){
	jQuery("#form_holder").css('display','');
	enableEditor();
	jQuery('[data-toggle=dropdown]').dropdown();
	enableIntervalRowWidth();
}
function cancelForm(){
	jQuery("#id").val(0);
	jQuery("#generalSubject").val("");
	jQuery("#generalType>option").eq(0).attr("SELECTED","SELECTED");
	jQuery("#generaTemplateHtml").destroy();
	jQuery("#generaTemplateHtml").val("");	
	jQuery("#form_holder").css('display','none');
}
</script>

