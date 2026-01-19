<?php
$graphData = array();
if(isset($patent_family['details']) && count($patent_family['details'])>0){
	foreach($patent_family['details'] as $details){
		/*echo "Application Number: ".$details->application_number."<br/>";
		echo "Issue Number: ".$details->patent_number."<br/>";
		echo "Filling Date: ".$details->filling_date."<br/>";
		echo "Issue Date: ".$details->issue_date_of_patent."<br/>";*/
		$percentage = 100;
		if($details->patent_number=='-'){
			$percentage = 25;
		}
		/*echo "Percentage: ".$percentage."<br/>";*/
		$parent = array();
		if(count($patent_family['links'])>0){
			foreach($patent_family['links'] as $link){				
				if($details->application_number == $link->patent_app_number && $link->parent==1){
					if(!in_array(str_replace(',','',$link->relation_number),$parent)){
						$parent[]=str_replace(',','',$link->relation_number);
					}
				} else if($details->application_number == $link->relation_number && $link->child==1){
					if(!in_array(str_replace(',','',$link->patent_app_number),$parent)){
						$parent[]=str_replace(',','',$link->patent_app_number);
					}
				}
			}
		}
		/*
		echo "Parent: ".json_encode($parent);
		echo "<br/>---------------------</br/>";*/
		$taskName = $details->application_number;
		if($details->patent_number!='-'){
			$taskName = $details->patent_number;
		}
		$startDate = null;
		$endDate = null;
		if($details->filling_date!='-'){
			$startDate = $details->filling_date;
		}
		if($details->issue_date_of_patent!='-'){
			$endDate = $details->issue_date_of_patent;
		}
		$graphData[] = array('task_id'=>str_replace(',','',$details->application_number),'task_name'=>$taskName,'start_date'=>$startDate,'end_date'=>$endDate,'duration'=>null,'percentage'=>$percentage,'dependencies'=>implode(',',$parent));
	}
}
/*echo "<pre>";
print_r($graphData);*/

?>
<html>
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function daysToMilliseconds(days) {
      return days * 24 * 60 * 60 * 1000;
    }

    function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');     
		<?php 
		if(count($graphData)>0){			
			foreach($graphData as $data){
				if($data['start_date']!=null && $data['end_date']!=null){
						$startDate = explode('-',$data['start_date']);
						$endDate = explode('-',$data['end_date']);
					?>
						
						data.addRow(['<?php echo $data['task_id'];?>','<?php echo $data['task_name'];?>', new Date(<?php echo $startDate[2];?>, parseInt(<?php echo $startDate[0];?>)-1,<?php echo $startDate[1];?>), new Date(<?php echo $endDate[2];?>, parseInt(<?php echo $endDate[0];?>)-1,<?php echo $endDate[1];?>),null,<?php echo $data['percentage'];?>,'<?php echo $data['dependencies'];?>']);
					<?php
					}else if($data['start_date']!=null && $data['end_date']==null){
					?>
						
						data.addRow(['<?php echo $data['task_id'];?>','<?php echo $data['task_name'];?>',new Date(<?php echo $startDate[2];?>, parseInt(<?php echo $startDate[0];?>)-1,<?php echo $startDate[1];?>),null, daysToMilliseconds(100),<?php echo $data['percentage'];?>,'<?php echo $data['dependencies'];?>']);
					<?php
				}
			}
		}
		?>
		height = window.outerHeight + 2000;
		var options = {
			height: height
		};
		var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
		chart.draw(data, options);
    }
  </script>
</head>
<body>
  <div id="chart_div"></div>
</body>
</html>