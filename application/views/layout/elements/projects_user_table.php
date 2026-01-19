<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/1.4.2/css/scroller.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/scroller/1.4.2/js/dataTables.scroller.min.js"></script>
<script>
jQuery(document).ready(function() {
	jQuery('.collapseTable').click(function(){
		if(jQuery(this).hasClass('icn-plus')){
			jQuery('.collapseTable').addClass('icn-minus').removeClass('icn-plus').html('-');
			jQuery('div.dataTables_scrollBody').css('height','325px');
		} else {
			jQuery('.collapseTable').addClass('icn-plus').removeClass('icn-minus').html('+');
			jQuery('div.dataTables_scrollBody').css('height','70px');
		}
		jQuery('.table-collapse').toggle();
	});
    jQuery('#project-list').DataTable( {
        destroy: true,
		paging:false,
		searching:false,
		scrollY: "325px",
		initComplete:function(settings, json){
			jQuery('div.dataTables_scrollBody').css('height','70px');
		}
    });
	jQuery('#transactions').DataTable( {
        destroy: true,
		paging:false,
		searching:false,
		scrollY: "325px",
		initComplete:function(settings, json){
			jQuery('div.dataTables_scrollBody').css('height','70px');
		}
    });
});

</script>
<style>
.dataTables_info{display:none;}
table.dataTable{margin-top:0px !important;border:0px;}
.dataTables_wrapper{margin-bottom:0px !important;}
table.dataTable thead > tr > th{border:0px;background:#fff;}
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody{border:0px;/*height:70px !important;*/max-height:325px;}
</style>
<div class="col-lg-4 cp-border" style="/*max-height:325px;;overflow:auto;overflow-x:hidden*/">
	<table class="table" id="project-list" >
		<thead>
		<tr>
			<th width="30px;"><a href='javascript://' class='collapseTable icn-plus' style='font-size:16px;color:#2196f3;font-weight:bold;width:20px;display:inline-block;text-align:left;'>+</a></th>
			<th>Project</th>
			<th>Max</th>
			<th>Min</th>
			<th>Avg</th>
			<th>Deadline</th>
			<th>Status</th>
		</tr>
		</thead>
		<tbody>       
			<?php 
				$name="";
				if(count($my_projects)>0){
					$i=1;
					foreach($my_projects as $project){
						$projectID = '~'.md5($project->id);
						$class='';
						$active='';
						if($id==$projectID){
							$active = 'activetr';
							$name = $project->project_name;
						}
						if($i>2){
							 $class="table-collapse hide";
						}
						$headings = $project->column_heading;
						$emailPrice = 0;
						$telephonePrice = 0;
						$phonePrice = 0;
						$linkedinPrice = 0;
						if(count($headings)>0){
							foreach($headings as $heading){
								switch((int)$heading->column_num){
									case 5:
										$emailPrice = $heading->price;
									break;
									case 6:
										$telephonePrice = $heading->price;
									break;
									case 7:
										$phonePrice = $heading->price;
									break;
									case 8:
										$linkedinPrice = $heading->price;
									break;
								}
							}
						}
						
						$headingPrice=array();
						$total = 0;
						if(count($headings)>0){
							foreach($headings as $heading){
								$headingPrice[] = $heading->price;
								$total = $total + $heading->price;
							}
						}
						$avg = $total / count($headingPrice);
			?>
				<tr class='<?php echo $class?> <?php echo $active;?>' data-key="<?php echo $projectID;?>" data-min-delay="<?php echo $project->id?>" data-email="<?php echo $emailPrice;?>" data-sp="<?php echo $project->status;?>" data-telephone="<?php echo $telephonePrice;?>" data-phone="<?php echo $phonePrice;?>" data-linkedin="<?php echo $linkedinPrice;?>">
					<?php 
						if($ty==1):
					?>
					<td><?php echo $i;?></td>
					<td><?php echo anchor('javascript://',$project->project_name,array('onclick'=>'getProjectActivitesDetails(jQuery(this))','data-sd'=>$project->id));?>
					</td>
					<?php elseif($ty==3):?>
					<td><a href="javascript://" onclick="editProjectDetails(jQuery(this))" style="color:#2196f3"><?php echo $i;?></a></td>
					<td><?php echo ((int)$project->status==1)?anchor('manager/account/'.$projectID,$project->project_name):$project->project_name;?></td>
					
					<?php else:?>
					<td><a href="javascript://" onclick="editProjectDetails(jQuery(this))" style="color:#2196f3"><?php echo $i;?></a></td>
					<td><?php echo ((int)$project->status==1)?anchor('manager/start/'.$projectID,$project->project_name):$project->project_name;?></td>
					<?php endif;?>
					<td><?php echo max($headingPrice)?></td>
					<td><?php echo min($headingPrice)?></td>
					<td><?php echo number_format($avg,1,'.','');?></td>
					<td><?php echo ($project->deadline!='0000-00-00')?date('d M y',strtotime($project->deadline)):'';?></td>
					<td><a href='javascript:void(0);' style='color:#2196f3;' onclick="changeProjectStatus(jQuery(this))"><?php echo ((int)$project->status==1)?"Ongoing":"Ended";?></a></td>
				</tr>
			<?php
					$i++;
					}
			?>
			<?php
				} else {
			?>
			<tr>
				<td colspan="7"><p class='alert alert-warning'>No project found!</p></td>
			</tr>
			<?php 
				}
			?>
		</tbody>
	</table>
</div>
<div class="col-lg-8 cp-border" style="/*overflow:auto;max-height:325px;*/">
	<table class="table  pricing-table-show" id='transactions'>
		<thead>
			<tr>
				<th width="40px" class='text-left  border-right-remove'><a href='javascript://' class='collapseTable icn-plus' style='font-size:16px;color:#2196f3;font-weight:bold;width:20px;display:inline-block;text-align:left;'>+</a> ID</th>
				<th width="80px" class='text-left  border-right-remove' >First Name</th>
				<th width="80px" class='text-left'>Last Name</th>
				<th width="80px" class='text-left'>Balance</th>
				<th width="130px" class='text-left'>Email</th>
				<th width="130px" class='text-left'>Paypal</th>
				<th width="80px" class='text-left'>Telephone</th>
			</tr>
		</thead>
		<tbody>						
			<?php 
				if(count($all_users)>0){
					$i=0;
					foreach($all_users as $user){	
						$class="";
						$style="";
						if($i>1){
							$class="table-collapse";
							$style="display:none";
						}
			?>
					<tr class='<?php echo $class?>' style="<?php echo $style?>" data-li="<?php echo $user->id;?>">
						<td width="40px" class='text-left'><?php echo $user->id;?>
						<?php $checked='';if($user->block==1){$checked='checked';}?>
						<input type="checkbox" value='1' <?php echo $checked;?> onclick="changeStatus(jQuery(this))"/></td>
						<td width="80px" class='text-left'><a href='javascript://' onclick='findUserData(jQuery(this))'><?php echo $user->first_name?></a></td>
						<td width="80px" class='text-left'><?php echo $user->last_name?></td>
						<td width="80px" class='text-left'>
						<?php 
							$balance = 0.0;
							if(count($user->projects_balance)>0){
								$projectsBalance = $user->projects_balance;
								$total = 0;
								$totalLastPayment = 0;
								foreach($projectsBalance as $project){
									$activites = $project['activities'];
									if(count($activites['current_project'])>0){
										foreach($activites['current_project'] as $current){
											$currentTotal = $current->count * $current->price;
											$total = $total + $currentTotal;
										}
									}
									if($project['last_payment']!=null && (int)$project['last_payment']>0){
										$totalLastPayment = $totalLastPayment + $project['last_payment'];
									}
								}
								$balance = $total - $totalLastPayment;
							}
							echo '$'.number_format($balance,1,'.','');
						?>
						</td>
						<td width="130px" class='text-left'><?php echo $user->email?></td>
						<td width="130px" class='text-left'><?php echo $user->paypal_address?></td>
						<td width="80px" class='text-left'><?php echo $user->user_number?></td>
					</tr>
			<?php 
						$i++;
					}
				}
			?>
		</tbody>
	</table>
</div>	