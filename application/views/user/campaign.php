<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script> 
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
<div class="row">
	<div class="col-lg-6">
	<h3>Email</h3>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Lead Name</th>
				<th>Subject</th>
				<th>Start Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php  
				if(count($resume_email_campaign)>0){
					foreach($resume_email_campaign as $campaign){
			?> 
						<tr>
							<td><?php echo $campaign->lead_name;?></td>
							<td><?php echo $campaign->subject;?></td>
							<td><?php echo $campaign->start_date;?></td>
							<td><a href="javascript://" onclick="findCampaign(<?php echo $campaign->id;?>)" class="btn btn-default btn-success"><span  class='fa fa-repeat'></span> Resume</a>
							<a href="javascript://" onclick="deleteCampaign(<?php echo $campaign->id;?>,jQuery(this))" class="" style='margin-left:5px;'><span  class='fa fa-trash'></span></a>
							<form action="https://backyard.synpat.com/users/email_campaign" method="post" id="frm_<?php echo $campaign->id;?>">
								<input type="hidden" name="setup" value="resume"/>
								<input type="hidden" name="campaign_id" value="<?php echo $campaign->id;?>"/>
							</form>	
							
							</td>
						</tr>											
			<?php
					}
				}
			?>
		</tbody>
	</table>
	</div>
	<div class="col-lg-6">
	<h3>LinkedIn</h3>
		<table class="table table-bordered">
		<thead>
			<tr>
				<th>Lead Name</th>
				<th>Subject</th>
				<th>Start Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if(count($resume_linkedin_campaign)>0){
					foreach($resume_linkedin_campaign as $campaign){
			?> 
						<tr>
							<td><?php echo $campaign->lead_name;?></td>
							<td><?php echo $campaign->subject;?></td>
							<td><?php echo $campaign->start_date;?></td>
							<td><a href="javascript://" onclick="findCampaign(<?php echo $campaign->id;?>)" class="btn btn-default btn-success"><span  class='fa fa-repeat'></span> Resume</a>
							<a href="javascript://" onclick="deleteCampaign(<?php echo $campaign->id;?>,jQuery(this))" class="" style='margin-left:5px;'><span  class='fa fa-trash'></span></a>
							<form action="https://backyard.synpat.com/users/linkedin_auto_campaign" method="post" id="frm_<?php echo $campaign->id;?>">
								<input type="hidden" name="setup" value="resume"/>
								<input type="hidden" name="campaign_id" value="<?php echo $campaign->id;?>"/>
							</form>		
							
							</td>
						</tr>		
			<?php
					}
				}
			?>
		</tbody>
	</table>
	</div>
</div>
<script>
	function findCampaign(id){
		jQuery("#frm_"+id).get(0).submit();
	}
	function deleteCampaign(id,o){
		conf = confirm("Are you sure?");
		if(conf){
			fetch("https://backyard.synpat.com/users/delete_campaign",{method:"POST",body:JSON.stringify({id:id})})
            .then(response => response.json())
            .then(e => {
				if(e.d > 0){
					o.parents('tr').remove();
				}                
            });
		}
		
	}
</script>