<?php 
define('WEB_URL','https://backyard.synpat.com/');
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => WEB_URL.'customers/campaign',
	CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
	CURLOPT_POST => 1,
	CURLOPT_POSTFIELDS => array(
		'id' => 0	
	)				
));
$resp = curl_exec($curl);
$list = array('email'=>array(),'linked_in'=>array()); 
if($resp){
	$data = json_decode($resp,true);
	if(isset($data['email'])){
		$list['email'] = $data['email'];
	}
	if(isset($data['linked_in'])){
		$list['linked_in'] = $data['linked_in'];
	}
}	

?>
<html lang="en">
<head>
<title>Backyard Campaign</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script> 
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
	<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
</head>
<body>
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
				if(count($list['email'])>0){
					foreach($list['email'] as $campaign){
			?> 
						<tr>
							<td><?php echo $campaign['lead_name'];?></td>
							<td><?php echo $campaign['subject'];?></td>
							<td><?php echo $campaign['start_date'];?></td>
							<td><a href="javascript://" onclick="findCampaign(<?php echo $campaign['id'];?>)" class="btn btn-default btn-success"><span  class='glyphicon glyphicon-repeat'></span> Resume</a></td>
						</tr>
						<form action="<?php echo WEB_URL?>base/email_campaign/index.php" method="post" id="frm_<?php echo $campaign['id'];?>">
							<input type="hidden" name="setup" value="resume"/>
							<input type="hidden" name="campaign_id" value="<?php echo $campaign['id'];?>"/>
						</form>						
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
				if(count($list['linked_in'])>0){
					foreach($list['linked_in'] as $campaign){
			?> 
						<tr>
							<td><?php echo $campaign['lead_name'];?></td>
							<td><?php echo $campaign['subject'];?></td>
							<td><?php echo $campaign['start_date'];?></td>
							<td><a href="javascript://" onclick="findCampaign(<?php echo $campaign['id'];?>)" class="btn btn-default btn-success"><span  class='glyphicon glyphicon-repeat'></span> Resume</a></td>
						</tr>
						<form action="<?php echo WEB_URL?>base/linkedin/index.php" method="post" id="frm_<?php echo $campaign['id'];?>">
							<input type="hidden" name="setup" value="resume"/>
							<input type="hidden" name="campaign_id" value="<?php echo $campaign['id'];?>"/>
						</form>						
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
	</script>
</body>
</html>