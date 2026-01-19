<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/colors.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/custom.css"/>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>public/jquery.tablesorter.min.js"></script>
<style>
	body {
		overflow: auto !important;overflow-x:hidden !important;
		min-width: 0;
		width: 100% !important;font-size:13px;font-family:arial;margin:0px;
	}
	table th, table td{padding:8px !important}
	table th:first-child{cursor:pointer;}
	th.headerSortDown{background:url('<?php echo $Layout->baseUrl; ?>public/images/sort_asc.png') no-repeat;background-position: 8px 11px;}
	th.headerSortUp{background:url('<?php echo $Layout->baseUrl; ?>public/images/sort_desc.png') no-repeat;background-position: 8px 4px;}
	 table td{vertical-align:middle !important;}
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
			 <div class="row">				
				<div class='col-lg-12'>
					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="db_from_litigation"  style="width:400px;">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Width</th>  
								<th>Open</th>  
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($list as $l){
							?>
							<tr data-id="<?php echo $l->id?>" data-name="<?php echo $l->slider_name;?>">
								<td><?php echo $l->id?></td>
								<td><?php echo $l->name;?></td>
								<td>
									<input type="text" value="<?php echo $l->default_width;?>" name="width" class='form-control' style="width:75px;float:left;" onkeydown="updateMe(jQuery(this));"/>
								</td>
								<td>
									<select name="open" class='form-control' style="width:80px;float:left;" onchange="updateMe(jQuery(this));">
									<option value="sb-right">Open</option>
									<?php
										$sliderOpenList = array('sb-left','sb-right','sb-center');
										foreach($sliderOpenList as $open){
									?>
											<option value="<?php echo $open;?>" <?php if($open == $l->slider_open):?> SELECTED='SELECTED' <?php endif;?>><?php echo ucfirst(str_replace('sb-','',$open));?></option>
									<?php
										}
										
									?>
									</select>
								</td>
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
<script>

window.parent.sliderList = JSON.parse('<?php echo json_encode($list);?>');

function updateMe(o){
	setTimeout(function(){
		var $tr = o.parents('tr');
		var sliderName = $tr.attr('data-name');
		var sliderWidth = $tr.find('input[name="width"]').val();
		if(sliderWidth != "") {
			var sliderOpen = $tr.find('select[name="open"]').val();
			var ID = $tr.attr('data-id');
			jQuery.ajax({
				url:'<?php echo $Layout->baseUrl; ?>general/manage_sliders',
				data:{name:sliderName,width:sliderWidth,open:sliderOpen},
				type:'POST',
				cache:false
			}).done(function(d){
				if(d > 0) {
					/*update list*/
					var newList = window.parent.sliderList;
					newList.map(function(m,i){
						if(m.id == ID) {
							newList[i].slider_open = sliderOpen;
							newList[i].default_width = sliderWidth;
							return false;
						}
					});
					window.parent.sliderList = newList;
				}
			});
		}
	},100);
}
$(function() {
  $("#db_from_litigation").tablesorter();
});
</script>