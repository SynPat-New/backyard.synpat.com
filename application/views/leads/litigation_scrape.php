<head>
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/tables.css">
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>js-core/jquery-ui-position.js"></script>
<style>
	body {
		overflow: auto !important;
		min-width: 0;
		font-family:arial;font-size:13px;
		margin-top:0px;
		margin-bottom:0px;
	}
	#page-content {
	    background: #ffffff !important;
	}
</style>	
</head>
<body>
<div class="row mainT">	
	<div class="col-xs-12" style='width:100%;margin-top:20px;'>
		<p>Search for cases at <a href="https://www.courtlistener.com" target="_blank">https://www.courtlistener.com</a>, copy the url of the result query and past it here:</p>
		<form>
			<div class="form-group">
				<input type="text" placeholder="Scrape Url" name="scrape_url" id="scrape_url" class="form-control"/>
			</div>
			<div class="form-group">
				<input type="hidden" value="<?php echo $lead_id;?>" name="lead_id" id="lead_id"/>
				<button class="btn btn-primary pull-left" type="button" onclick="addUrlToScraper()">Scrape</button>
			</div>
		</form>
	</div>
	<div class="col-xs-12" style='width:100%;margin-top:20px;'>
		<?php
			if(count($lead_litigation_scrape) > 0){
		?>
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Parties</th>
					<th>Filled Date</th>
					<th>File</th>
				</tr>
			</thead>
			<tbody>
		<?php
				foreach($lead_litigation_scrape as $l){
		?>
				<tr>
					<td><input onclick="checkMe($(this))" type="checkbox" name="show" value="<?php echo $l->id?>" <?php echo ($l->show==0)?"CHECKED='CHECKED'":'';?>/></td>
					<td><?php echo $l->parties?></td>
					<td><?php echo $l->filled_date?></td>
					<td><a href='<?php echo $l->pdf_file_url;?>' target='_blank'>File</a></td>
				</tr>
		<?php					
				}
		?>
			</tbody>
		<?php
			}
		?>
	</div>
</div>
<script>
const __baseUrl = '<?php echo $Layout->baseUrl?>';
function addUrlToScraper(){
	jQuery.ajax({
		url:__baseUrl+"leads/litigation_scrape/"+jQuery("#lead_id").val(),
		type:'POST',
		data:{scrape_url:jQuery("#scrape_url").val()},
		dataType:'json'		
	}).done(function(d){
		if(d.id > 0){
			alert("Job added to queue");
			sendRequestToScrapper(d);
		}else if(d.count > 0){
			alert("URL already in the scrapper list");
		} else {
			alert("Error! please try after sometime.");
		}
	});
}
function sendRequestToScrapper(d){
	jQuery.ajax({
		url:__baseUrl+'users/send_scrapper_request_to_server',
		type:'POST',
		data:{d:d,url:'http://webdriverforscrape.site/litigation_scrape_data.php'}
	}).always(function(){
		
	});
}
function checkMe(o){
	var t = 0;
	if(!o.is(":CHECKED")){
		t = 1;
	}
	jQuery.ajax({
		url:__baseUrl+"leads/litigation_scrape_data_show/"+jQuery("#lead_id").val(),
		type:'POST',
		data:{id:o.val(),show:t}			
	}).done(function(d){
		
	});
}
</script>
</body>