<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/custom.css"/>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<style>
	body {
		overflow: auto !important;overflow-x:hidden !important;
		min-width: 0;
		width: 100% !important;font-size:13px;font-family:arial;margin:0px;
	}
	table th, table td{padding:8px !important}
</style>
<div class="panel dashboard-box" style="border:0px;margin-top:10px;">
    <div class="panel-body pad0T">
		<div class="example-box-wrapper">
			<?php 
			if($this->session->flashdata('message')){
			?>
				<?php echo $this->session->flashdata('message');?>
			<?php					
				}
			?>
			<div id="form_holder">
				<?php echo form_open('general/manage_sliders',array('class'=>"form-horizontal form-flat", 'style'=>'margin-bottom: 0;'))?>           
				<div class="example-box-wrapper">
					<div class="row row-width">
						<div class="col-width" style="width: 100%;">
							<div class="form-group input-string-group select-string-group" style="margin-left: 0;">
								<select name="general[slider]" id="generalSlider" class='form-control' required="required" style="width:250px;float:left;">
									<option value="0">Sliders</option>
									<?php
										$slidersList = array('Admin','Search','Scanner','Contacts','Companies','AddContacts','AddCompanies');
										foreach($slidersList as $slider){
									?>
											<option value="<?php echo $slider;?>"><?php echo $slider;?></option>
									<?php
										}
									?>
								</select>
								<select name="general[width]" id="generalWidth" class='form-control' required="required" style="width:250px;float:left;">
									<option value="0">Width</option>
									<?php
										$widthArray = array(30,40,50,60,100);
										foreach($widthArray as $width){
									?>
											<option value="<?php echo $width;?>"><?php echo $width;?></option>
									<?php
										}
										
									?>
								</select>
							</div>
							<div class="mrg5T">
								<button type="submit" class="btn btn-primary btn-mwidth">Save</button>
						</div>
						</div>
					</div>
				</div>
				<?php echo form_close();?> 
			</div>
			 <div class="row">				
				<h3 class="title-hero" style="margin-top:15px;">List</h3>
				<div class='col-lg-12'>
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="db_from_litigation"  style="width:300px;">
						<thead>
							<tr>
								<th>Name</th>
								<th>Width</th>  
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($list as $l){
							?>
							<tr>
								<td><?php echo $l->slider_name;?></td>
								<td><?php echo $l->default_width;?></td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>