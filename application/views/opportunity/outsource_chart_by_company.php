<?php 

	if(count($activity_data)>0){
?>
<html>
<title>Timeline Activity</title>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css" rel="stylesheet" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
jQuery(document).ready(function(){
	h = jQuery(window).height();
	h = (h - 53)/2;
	console.log(h);
	jQuery("#example5.1").css({maxHeight:h+"px",height:h+"px"});
jQuery("#activityTable").css({maxHeight:h+"px",minHeight:h+"px",height:h+"px",zIndex:1});
});
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var container = document.getElementById('example5.1');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Room' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([
		<?php 
			$i=0;
			foreach($activity_data as $activity){
				$i++;
				if($activity->start_date!='0000-00-00 00:00:00' && $activity->end_date!='0000-00-00 00:00:00'):
				$sY = date('Y',strtotime($activity->start_date));
				$sM = date('m',strtotime($activity->start_date)) - 1;
				$sD = date('d',strtotime($activity->start_date));
				$sH = date('H',strtotime($activity->start_date));
				$sI = date('i',strtotime($activity->start_date));
				$sS = date('s',strtotime($activity->start_date));
				
				$eY = date('Y',strtotime($activity->end_date));
				$eM = date('m',strtotime($activity->end_date)) - 1;
				$eD = date('d',strtotime($activity->end_date));
				$eH = date('H',strtotime($activity->end_date));
				$eI = date('i',strtotime($activity->end_date));
				$eS = date('s',strtotime($activity->end_date));
				echo "[ '".$activity->typeName."','', new Date(".$sY.",".$sM.",".$sD.",".$sH.",".$sI.",".$sS."),  new Date(".$eY.",".$eM.",".$eD.",".$eH.",".$eI.",".$eS.") ]";
				if($i<count($activity_data)){
					echo ",";
				}
				endif;
			}
		?>
	  ]);

    var options = {
      timeline: { showRowLabels: true }
    };

    chart.draw(dataTable, options);
  }

</script>
<style>body{overflow-x:hidden;}</style>
</head>
<body>
<!--<div class='container compass'>-->
<div class="row" style='margin-left:20px;'>  
<a href='<?php echo $Layout->baseUrl?>customers/get_outsource_chart_by_company/<?php echo $leadID?>/<?php echo $companyID?>' target='_blank'>Open in new tab</a>
<div class='col-lg-12' style='margin-top:20px;padding:0px'>
<div id="example5.1" style="height:250px;width:95%;"></div>
</div>
<div class='col-md-12' style='margin-top:20px;overflow:auto;padding:0px' id="activityTable">
<script>
	jQuery(document).ready(function(){
		 $('#table-activity').DataTable( {
			fixedHeader: true,
			paging:false,
			searching:false
		} );
	});
</script>
<table class='table table-condensed table-striped table-bordered table-hover' id='table-activity' style='width:95%;margin:0px;'>
	<thead>
		<tr>
			<th>Project</th>
			<th>Time spent</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$i=0;
			foreach($activity_timing as $time){
		?>
			<tr>
				<td><?php echo $time->typeName;?></td>
				<td><?php echo show_timer($time->duration);?></td>
			</tr>
		<?php
				$i++;
			}
		?>  
	</tbody>
</table>
</div>
</div><!--</div>-->
	<?php } else {?>
	No activty found!
	<?php }
?>
</body>
</html>
