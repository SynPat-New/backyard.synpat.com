
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
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type="text/javascript">
var h;
jQuery(document).ready(function(){
	h = jQuery(window).height();
	h = (h - 70)/2;
	console.log(h);
	jQuery("#timelineActivity").css({maxHeight:h+"px",height:h+"px"});
/*jQuery("#activityTable").css({maxHeight:h+"px",minHeight:h+"px",height:h+"px",zIndex:1});*/
});
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  var dataTable = "",_selectedID=0;
  var serialNumber = [];
  var activityTimeLine=[];
  <?php 
	foreach($activity_data as $activity){
?>
	object = {};
	object.id = <?php echo $activity->id?>;
	object.start_date = '<?php echo date('Y-m-d H:i',strtotime($activity->start_date))?>';
	object.end_date = '<?php echo date('Y-m-d H:i',strtotime($activity->end_date))?>';
	object.duration = '<?php echo timeDiff($activity->start_date,$activity->end_date)?>';
	object.name = '<?php echo $activity->name?>';
	object.patent_number = '<?php echo $activity->patent_number?>';
	object.history_string = "<?php echo addslashes($activity->history_string)?>";
	activityTimeLine.push(object);
	serialNumber.push(<?php echo $activity->id?>);
<?php
	}
  ?>
  function drawChart() {
    var container = document.getElementById('timelineActivity');
    var chart = new google.visualization.Timeline(container);
    dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Position' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'string', role: 'tooltip' ,'p': {'html': true}});
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
				$time = date('Y-m-d',strtotime($activity->start_date))."&nbsp;&nbsp;&nbsp;".date('H:i',strtotime($activity->start_date))."&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;".date('Y-m-d',strtotime($activity->end_date))."&nbsp;&nbsp;&nbsp;".date('H:i',strtotime($activity->end_date));
				$duration = timeDiff($activity->start_date,$activity->end_date);
				$style='width:350px;height:120px;border:1px solid #e6e6e6;padding:10px;';
				$toolTip = '<div style="'.$style.'"><p><b>Name: </b>'.ucfirst(strtolower($activity->name)).'</p><p> <b>Assets Number: </b>'.$activity->patent_number.'</p><p><b>Time: </b>'.$time.'  </p><p><b>Duration: </b>'.$duration.'</p></div>';
				/*$toolTip = '<div style="'.$style.'"><div style="width:100%;border-bottom:1px solid #e6e6e6;padding-bottom:10px;"><b>Time:</b> '.$time.' &nbsp;&nbsp;&nbsp;<b>Duration:</b>'.$duration.'</div><p style="padding:10px 0;"> </p><p style="padding:10px 0;"><b>String:</b></p><p>'.$activity->history_string.'</p></div>';*/
				echo "[ '".$activity->patent_number."','".ucfirst(strtolower($activity->name))."','".$toolTip."', new Date(".$sY.",".$sM.",".$sD.",".$sH.",".$sI.",".$sS."),  new Date(".$eY.",".$eM.",".$eD.",".$eH.",".$eI.",".$eS.") ]";
				if($i<count($activity_data)){
					echo ",";
				}
				endif;
			}
		?>
	  ]);
	
    var options = {tooltip: {isHtml: true},hAxis: {
            format: 'M/d/yy'
          }
      /*timeline: { colorByRowLabel: true }*/
    };
	chart.draw(dataTable, options);
	google.visualization.events.addListener(chart, 'select', function() {
		var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
              patentNumber = dataTable.getValue(selectedItem.row, 0);
			  jQuery("#myModal").find('.modal-title').html(patentNumber);
			  _stringThread="";
			  _selectedID = serialNumber[selectedItem.row];
			  if(activityTimeLine.length>0){
				  for(i=0;i<activityTimeLine.length;i++){
					  if(activityTimeLine[i].patent_number==patentNumber){
						  style='';
						  if(parseInt(activityTimeLine[i].id)==parseInt(_selectedID)){
							  style='background-color:#d9edf7';
						  }
						  _stringThread +='<li id="'+activityTimeLine[i].id+'" class="list-group-item" style="'+style+'"><h5>'+activityTimeLine[i].name+'<br/> From '+moment(new Date(activityTimeLine[i].start_date)).format('DD/MMM/YYYY')+' at '+moment(new Date(activityTimeLine[i].start_date)).format('HH:mm')+' to '+moment(new Date(activityTimeLine[i].end_date)).format('DD/MMM/YYYY')+' at '+moment(new Date(activityTimeLine[i].end_date)).format('HH:mm')+' Duration '+activityTimeLine[i].duration+' hours:minutes</h5><p>'+activityTimeLine[i].history_string+'</p></li>';
					  }
				  }
			  }
			  _stringThread = "<div class='' style='height:600px;overflow:auto;overflow-x:none'><ul class='list-group'>"+_stringThread+'</ul></div>';
			  jQuery("#myModal").find('.modal-body').html(_stringThread);
			  jQuery("#myModal").modal('show');
			  setTimeout(function(){
				  var offset = jQuery('.modal-body').find('div').find('ul>li').first().position().top;
				jQuery('.modal-body').find('div').scrollTop(jQuery('#'+_selectedID).position().top - offset);
			  },400);
			  
			  
          }
	});
    
  }
	
</script>
<style>
body, table{font-size:13px;font-family:Arial}
/*.google-visualization-tooltip{z-index:9999}*/body{overflow-x:hidden;}.modal-open .modal{overflow:hidden;z-index:99999}
.container{width:100%;}
</style>
</head>
<body>
<!--<div class='container'>-->
<?php
$companyName = "";
if(count($company_data)>0){
	$companyName = $company_data->company_name;
}?>
<div class="">
<div class="container">
<a style='display:none' id="open_new_tab" href='<?php echo $Layout->baseUrl?>customers/get_outsource_chart_by_project/<?php echo $leadID?>/<?php echo $type;?>/<?php echo $companyID?>' target='_blank'>Open in new tab</a>
<div  style='display:none;padding:10px;' id="chart_heading"><?php echo $lead_name;?> / <?php echo $companyName;?></div>
<div class='col-lg-12' style='margin-top:10px;padding:0px;'>
<div id="timelineActivity" style="height:150px;width:99%"></div>
</div>
<script>
	jQuery(document).ready(function(){
		 $('#table-activity').DataTable( {
			fixedHeader: {
				header: true,
				footer: true
			},
			paging:false,
			searching:false,
			scrollY:h-120
		} );
	});
</script>
<div class='col-md-12' style='margin-top:20px;overflow:auto;padding:0px;width:99%;' id="activityTable"  >
<table class='table table-condensed table-striped table-bordered table-hover' id='table-activity' style='margin:0px;'>
	<thead>
		<tr>
			<th class='text-center'>Asset / Expert</th>
			<?php 
				if(count($activity_user)>0){
					foreach($activity_user as $user){
			?>
						<th class='text-center' data-name="<?php echo $user->name?>" data-email="<?php echo $user->email?>" data-telephone="<?php echo $user->telephone?>" data-linkedin="<?php echo $user->linkedin?>"><a target="_blank" href="<?php echo $user->linkedin?>"><?php echo ucfirst(strtolower($user->name));?></a></th>
			<?php
					}
				}
			?>
			<th class='text-center'>Total Time (hh:mm):</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$i=0;
			$userActivityData = array();
			foreach($activity_patent as $patent){
		?>
			<tr>
				<td class='text-center'><?php echo $patent->patent_number;?></td>
				<?php
					$totalTime = "";
					if(count($activity_user)>0){
						foreach($activity_user as $user){
							$time = "";
							if(count($activity_data)>0){
								foreach($activity_data as $activity){									
									if(strtolower($user->email)==strtolower($activity->email) && $activity->patent_number==$patent->patent_number){										
										$time = timeDiff($activity->start_date,$activity->end_date,'%H:%I:%S');
										if(count($userActivityData)>0){
											$entryFound = false;
											$patentFound = false;
											$ua=0;
											foreach($userActivityData as $key=>$value){
												if($key==$user->email){
													$entryFound = true;													
													if(is_array($value) && count($value)>0){
														$sp=0;
														foreach($value as $innerData){
															if($innerData['patent']==$activity->patent_number){
																$oldTime = $innerData['time'];
																$newTime = sum_the_time($oldTime, $time);
																$value[$sp]['time'] = $newTime;
																$userActivityData[$key] = $value;
																$time =  $newTime;
																$patentFound = true;
															}
															$sp++;
														}
														if($patentFound===false){
															$userActivityData[$user->email][] = array('patent'=>$activity->patent_number,'time'=>$time);
														}
													} else {
														$userActivityData[$user->email][] = array('patent'=>$activity->patent_number,'time'=>$time);														
													}
												}
												$ua++;
											}	
											if($entryFound===false){
												$userActivityData[$user->email][] = array('patent'=>$activity->patent_number,'time'=>$time);
											}											
										} else {
											$userActivityData[$user->email][] = array('patent'=>$activity->patent_number,'time'=>$time);
											
										}										
									}		
								}
							}
						?>
							<td class='text-right'><?php echo show_timer($time);?></td>
						<?php
						}
					}
					foreach($userActivityData as $key=>$value){
						foreach($value as $innerData){
							if($innerData['patent'] == $patent->patent_number){
								if(empty($totalTime)){
									$totalTime = $innerData['time'];
								} else {
									$totalTime = sum_the_time($totalTime, $innerData['time']);
								}
							}							
						}											
					}
				?>
				<td class='text-right'><b><?php echo show_timer($totalTime);?></b></td>
			</tr>
		<?php
				
			}
		?> 
		</tbody>
		<tfoot>
		<tr>
			<td class='text-center'><b>Total Time (hh:mm):</b></td>
			<?php 
				$grandTotal = "";
				if(count($activity_user)>0){
					foreach($activity_user as $user){
						$totalTime = "";
						foreach($userActivityData as $key=>$value){
							if($key==$user->email){
								foreach($value as $innerData){
									if(empty($totalTime)){
										$totalTime = $innerData['time'];
									} else {
										$totalTime = sum_the_time($totalTime, $innerData['time']);
									}							
								}
							}											
						}
					
				?><td class='text-right'><b><?php echo show_timer($totalTime);?></b></td>
				<?php
					}
				}
				foreach($userActivityData as $key=>$value){					
					foreach($value as $innerData){
						if(empty($grandTotal)){
							$grandTotal = $innerData['time'];
						} else {
							$grandTotal = sum_the_time($grandTotal, $innerData['time']);
						}							
					}
				}
			?>
			<td class='text-right'><b><u><?php echo show_timer($grandTotal);?></u></b></td>
		</tr> 
	 </tfoot>
</table>
</div>
</div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

	<?php } else {?>
	No activty found!
	<?php }
?>
<script>
if (window.frameElement) {
	jQuery("#open_new_tab").show();
	jQuery("#chart_heading").hide();
} else {
	jQuery("#open_new_tab").hide();
	jQuery("#chart_heading").show();
}
</script>
</body>
</html>
