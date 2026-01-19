<?php
/*
$checkURIFunction = $this->uri->segment(2);
$checkURIController = $this->uri->segment(1);
$checkLead = $this->uri->segment(3);
$getTimeLine = array();
if($checkURIController=="leads"){
	if($checkURIFunction!="litigation"){
		if(empty($checkLead) && isset($results)){
			if(count($results)>0){
				$checkLead = $results[0]['litigation']->id;
			}
		}
		if(!empty($checkLead)){
			$getTimeLine = getUserTimeLine($this->session->userdata['id'],$checkLead,0);
		}		
	} 
} else if($checkURIController=="dashboard"){
	$getTimeLine = getUserTimeLine($this->session->userdata['id'],0,0);
} else if($checkURIController=="opportunity"){
	if(!empty($checkLead)){
		$getTimeLine = getUserTimeLine($this->session->userdata['id'],$checkLead,0);
	}
}

?>
<script>__mainEntityFollow=0;__mainEntityType="<?php echo $checkURIController;?>";<?php 
	if(!empty($checkLead)):
?>
__mainEntityFollow='<?php echo $checkLead;?>';<?php endif;?></script>


<style>
	#activitySlidebarTable_wrapper .dataTables_info {
		display: none;
	}
</style>

<div id="activity" class="sb-slidebar bg-white sb-right sb-style-overlay">
	<div class="sb-slidebar-top-buttons">
		<a href='javascript:void(0)' class="btn" onclick="closeSlideBarTimeLineAcitivity()" style='float:right'><i class="glyph-icon icon-close"></i></a>
		<a href='javascript:void(0)' class="btn nm" onclick="changeSlidebarSide(jQuery(this))" style='float:right'><i class="glyph-icon icon-exchange"></i></a>
	</div>
	<div class="scrollable-content scrollable-slim-sidebar">
		<div class="pad15A">
			<table id="activitySlidebarTable" class="table table-bordered">
				<thead>
					<tr>
						<th>Lead</th>
						<th>Person</th>
						<th>Activity</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if(count($getTimeLine)>0){
							foreach($getTimeLine as $timeline){
								$label = (!empty($timeline->lead_name))?$timeline->lead_name:$timeline->plantiffs_name;
					?>
					<tr>
						<td onclick='openLeadDetail(<?php echo $timeline->lead_id;?>)'><?php echo $label;?></td>
						<td><?php echo $timeline->name;?></td>
						<td><?php echo $timeline->message;?></td>
						<td><?php echo date('M d, Y',strtotime($timeline->create_date));?></td>
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

<script>function timelineItemBindEvents(){}$(function(){timelineItemBindEvents()});</script>

<script>
	$(function() {
		$('#activitySlidebarTable')
			.DataTable({								
				"searching":false,
				"autoWidth": true,
				"paging": false,
				"sScrollY": $(window).height() - 130 + 'px',
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			});
	});

	$(window).on('resize', function() {
		var height = $(window).height() - 130;
		$('#activitySlidebarTable_wrapper .dataTables_scrollBody').height(height);
	});
</script>
*/?>