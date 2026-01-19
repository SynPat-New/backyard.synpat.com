<?php 
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => 'https://new-backyard.herokuapp.com/customers/campaign',
	CURLOPT_USERAGENT => 'Send Request for create demo portfolio'		,
	CURLOPT_POST => 1,
	CURLOPT_POSTFIELDS => array(
		'campaign_type' => 2,	
		'id' => 0	
	)				
));
$resp = curl_exec($curl);
$list = array();
if($resp){
	$list = json_decode($resp,true);
}	

?>
<html lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script> 
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
	<script type="text/javascript" src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
</head>
<body>
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
				if(count($list)>0){
					foreach($list as $campaign){
			?> 
						<tr>
							<td><?php echo $campaign['lead_name'];?></td>
							<td><?php echo $campaign['subject'];?></td>
							<td><?php echo $campaign['start_date'];?></td>
							<td><a href="javascript://" onclick="findCampaign(<?php echo $campaign['id'];?>)" class="btn btn-default btn-success"><span  class='glyphicon glyphicon-repeat'></span> Resume</a></td>
						</tr>
						<form action="https://new-backyard.herokuapp.com/base/linkedin/index.php" method="post" id="frm_<?php echo $campaign['id'];?>">
							<input type="hidden" name="setup" value="resume"/>
							<input type="hidden" name="campaign_id" value="<?php echo $campaign['id'];?>"/>
						</form>						
			<?php
					}
				}
			?>
		</tbody>
	</table>
	<script>
		function findCampaign(id){
			jQuery("#frm_"+id).get(0).submit();
		}
	</script>
</body>
</html>