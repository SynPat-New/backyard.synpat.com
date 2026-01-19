<?php 
	$name = $full_project_details['project_details']->project_name;
?>
<!DOCTYPE html>
<html lang ="en">
<head>

    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title> Start Project </title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Favicons -->

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $Layout->baseUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $Layout->baseUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $Layout->baseUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="<?php echo $Layout->baseUrl?>public/images/icons/favicon.ico">
<link rel="shortcut icon" href="<?php echo $Layout->baseUrl?>public/images/icons/favicon.ico">


    <!-- HELPERS -->


<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/boilerplate.css">	
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/page-transitions.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/spacing.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/utils.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/colors.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/icons/fontawesome/fontawesome.css">
<!-- ELEMENTS -->
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/content-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/responsive-tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/jgrowl-notifications/jgrowl.css">

<!-- FRONTEND ELEMENTS -->

<!-- ICONS -->

<!-- WIDGETS -->
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/slidebars/slidebars.css">

<!-- FRONTEND WIDGETS -->
<!-- SNIPPETS -->


<!-- Frontend theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/frontend/layout.css">

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/frontend/color-schemes/default.css">

<!-- Frontend responsive -->
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/responsive-elements.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/frontend-responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/modal/modal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/tooltip/tooltip.css">
    <!-- JS Core -->
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-core.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-widget.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-mouse.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-position.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/transition.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/modal/modal.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/jgrowl-notifications/jgrowl.js"></script>
<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/tooltip/tooltip.js"></script>
    
	
    
	
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/slidebars/slidebars.js"></script>


<script type="text/javascript">
	(function(f){function l(g,h){function d(a){if(!e){e=true;c.start&&c.start(a,b)}}function i(a,j){if(e){clearTimeout(k);k=setTimeout(function(){e=false;c.stop&&c.stop(a,b)},j>=0?j:c.delay)}}var c=f.extend({start:null,stop:null,delay:400},h),b=f(g),e=false,k;b.keypress(d);b.keydown(function(a){if(a.keyCode===8||a.keyCode===46)d(a)});b.keyup(i);b.blur(function(a){i(a,0)})}f.fn.typing=function(g){return this.each(function(h,d){l(d,g)})}})(jQuery);
    $(window).load(function(){
        setTimeout(function() {
            $('#loading').fadeOut( 400, "linear" );
        }, 300);
    });
	window.showMessageOnFly = function(mesg,clas){
		jQuery('#sb-site').prepend('<div class="col-lg-12 alert '+clas+' noticeInfoAlert mrg5T" style="position:absolute;z-index:9999">'+mesg+'</div>');setTimeout(function(){jQuery('.noticeInfoAlert').remove()},3000);
	}
	function call(url,type,data,fn,datatype){
		jQuery.ajax({
			type:type,
			crossDomain: true,
			url:url,
			data:data,
			cache:false,
			dataType:datatype,
			success:fn
		});
	}
	jQuery(document).ready(function(){
		_h = jQuery(window).height();
		jQuery("#terms_page").css("height",_h-20);
		if(jQuery(window).width()<1200){
			_w = jQuery(window).width();
			jQuery("#terms_page").css("width",_w-100);
		}
		<?php 
			if(!isset($_SESSION)){
				session_start();
			}
			if(!isset($_SESSION['user_show_me'])):
		?>
		setTimeout(function(){jQuery('.sb-toggle-right').eq(0).trigger('click');disableShowMe()},500);
		<?php else:?>
		console.log(<?php echo $_SESSION['user_show_me']?>);
		<?php endif;?>
		jQuery("#project-list").tablesorter();
		jQuery(".lbltooltip").tooltip({placement:'bottom'});
	});
	function disableShowMe(){
		jQuery.ajax({
			type:'POST',
			url:'<?php echo $Layout->baseUrl?>outsource/dataentry/show_me',
			data:{d:1},
			success:function(d){}
		});
	}
</script>
<style>
.light-blue{
	background-color:#E6E6FC !important;
}
.light-blue-1{
	background-color:#D2D2F6 !important;
}
.sb-slidebar{
	overflow-y:hidden;
}
.scrollTable{
overflow-y:auto;
max-height:300px;
}
#project-list thead th{cursor:pointer;}
table thead th{font-weight:bold}
</style>
</head>
<body>
<div id="loading">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<?php 
	$user = $this->session->userdata("miner");
?>
<div class="sb-slidebar bg-default sb-right sb-style-overlay sb-width-custom" data-sb-width="800px" style=''>
<!--<div class="scrollable-content scrollable-slim-sidebar">-->
<div class="pad15A">
	<a class='sb-close' href='javascript://'><i class='glyph-icon icon-close'></i></a>
	<iframe id="terms_page" src="https://docs.google.com/document/d/1eV8V5Cbfd6qZkdGy_5hiKsDAZ9Hd7Z9UxnNd4fTFmfE/pub" scrolling="no" width="100%"></iframe>
</div>
<!--</div>-->
</div>



<div id="page-wrapper"><div class="top-bar">
	<div class="row">
    <div class="col-md-12 center-margin frontend-components" style="padding:0 20px;">
		<div class="col-md-3 hidden-lg" style='/*width:4.333333333333332%*/'>
			<label class="col-sm-12 control-label">&nbsp;</label>
			<?php echo anchor('outsource/dataentry/logout','Logout',array('class'=>'pull-right','style'=>'color:#2196f3;'));?>
			<a href="javascript://" data-placement="bottom" class="sb-toggle-right pull-right mrg5R" title="" data-original-title="Statistics Sidebar" style='color:#2196f3'>
                Terms 
            </a>
		</div>
        <div class="col-md-9" style='/*width:95.66666666666666%*/'>
		<?php echo form_open('outsource/dataentry/profile',array('class'=>'form-horizontal bordered-row','id'=>'frm_user_profile'));?>
        <div class="col-md-2">			
			<div class="input-group">
				<label class="col-sm-12 control-label">First Name:</label>
				
				<input type="text" placeholder='First name' name="profile[first_name]" id="profileFirstName" class="form-control update-profile  " value="<?php echo $userData->first_name;?>">
				
			</div>
		</div>
		<div class="col-md-2">	
			<div class="input-group">
				<label class="col-sm-12 control-label">Last Name:</label>
				
				<input type="text" placeholder='Last name' name="profile[last_name]" id="profileLastName" class="form-control update-profile" value="<?php echo $userData->last_name;?>">
				
			</div>
		</div>
		<div class="col-md-2">	
			<div class="input-group">
				<label class="col-sm-12 control-label">Chg Password:</label>
				
				<input type="password" placeholder='Password' name="profile[password]" id="profilePassword" class="form-control update-profile">
				
			</div>
		</div>
		<div class="col-md-2">	
			<div class="input-group">
				<label class="col-sm-12 control-label">Email:</label>
				
				<input type="text" placeholder='Email' name="profile[email]" id="profileEmail" class="form-control update-profile" value="<?php echo $userData->email;?>">
				
			</div>
		</div>
		<div class="col-md-2">	
			<div class="input-group">			
				<label class="col-sm-12 control-label" style='padding-top:2px;'><img src="<?php echo $Layout->baseUrl;?>public/images/PP_logo_h_100x26.png" style='width:75px;'/></label>
				
				<input type="text" placeholder='PayPal' name="profile[paypal_address]" id="paypal_address" class="form-control update-profile" value="<?php echo $userData->paypal_address;?>">
				
			</div>
		</div>
		<div class="col-md-2">	
			<div class="input-group">
				<label class="col-sm-12 control-label">Telephone:</label>
				
				<input type="text" placeholder='Telephone' name="profile[user_number]" id="user_number" class="form-control update-profile" value="<?php echo $userData->user_number;?>" >
				
			</div>
		</div>
		<?php echo form_close();?>
		</div>
		<div class="col-md-3 visible-lg-block" style='/*width:4.333333333333332%*/'>
			<div class="col-md-6">				
				<div class="col-md-6">				
					<div class="input-group">
						<label class="col-sm-12 control-label" style='padding-top:7px;'>Acc.ID:</label>						
						<input type="text" readonly  name="account_id" id="accountID" class="form-control update-profile  " value="<?php echo $userData->id;?>">						
					</div>				
				</div>	
				<div class="col-md-6">
					<div class="input-group">
						<label class="col-sm-12 control-label lbltooltip" style='padding-top:7px;' title="The data you provide is later on verified by our team. Incorrect 5 items will cause your account to be deleted."  data-original-title="The data you provide is later on verified by our team. Incorrect 5 items will cause your account to be deleted.">Error:</label>						
						<?php echo (count($my_error)>0)?$my_error->counter." / 5":'0 / 5';?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="col-md-6">	
					<?php echo anchor('outsource/dataentry/logout','Logout',array('class'=>'','style'=>'color:#2196f3;display:inline-block;margin-top:7px;'));?>		
				</div>
				<div class="col-md-6">	
					<a href="javascript://" data-placement="bottom" class="sb-toggle-right" title="" data-original-title="Statistics Sidebar" style='color:#2196f3;display:inline-block;margin-top:7px'>
						Terms
					</a>
				</div>
			</div>			
		</div>
    </div><!-- .container -->
    </div><!-- .container -->
</div><!-- .top-bar -->
<script>

(function($) {
    $(document).ready(function() {
        $.slidebars();
    });
})(jQuery);
</script>
<div id="page-content" class="col-md-12 center-margin frontend-components" style='padding-top:0px;'>
    <div class="row">
        <div class="col-md-12">
            

<!-- Input masks -->



<script type="text/javascript">
    
	$('.update-profile').typing({
		start: function (event, $elem) {
			
		},
		stop: function (event, $elem) {
			 data= jQuery("#frm_user_profile").serializeArray();
			call(jQuery("#frm_user_profile").attr('action'),jQuery("#frm_user_profile").attr('method'),data,show_update_message,'json');
		},
		delay: 30000
	}); 
	
	function show_update_message(data,textStatus,xhr){
		console.log(data);
	}
</script>
<link  rel="stylesheet" media="screen" href="https://s3.amazonaws.com/handsontable/handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="https://s3.amazonaws.com/handsontable/handsontable_new/dist/pikaday/pikaday.css">
<script  src="https://s3.amazonaws.com/handsontable/handsontable_new/dist/moment/moment.js"></script>
<script  src="https://s3.amazonaws.com/handsontable/handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="https://s3.amazonaws.com/handsontable/handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="https://s3.amazonaws.com/handsontable/handsontable_new/dist/handsontable.min.js"></script>
  
 <?php 

  $column = $full_project_details['column_heading'];
  $rows = $full_project_details['project_details']->row_count;
  $cols = $full_project_details['project_details']->col_count;
  $projectID = $full_project_details['project_details']->id;
  $projectData = $full_project_details['project_data'];
  $embedData = array();
  $userColumnEntered = array();
  $userRejected = array();
  $failedData = array();
  $userID = $user->id;
  $rowColID = array();
  if(count($projectData)>0){
	  $n=1;
	  $currentRow = 0;
	  $columnData = array();
	  $columnIds = array();
	 foreach($projectData as $project){		
		 if($currentRow>0 && $currentRow!=$project->row){
			$embedData[] = $columnData;
			$rowColID[] = $columnIds; 
			$columnData = array();
			$columnIds = array();
		}
		$currentRow = $project->row;
		$columnIds[] = array($project->row,$project->id,$project->col,$project->user_id);
		if($project->enter_by=="Free"){
			/*if(empty($project->data)){
				$columnData[] = 'Enter Data';
			} else {
				$columnData[] = $project->data;
			}*/
			$columnData[] = $project->data;
			if($project->pass==0){
				$failedData[] = array('data'=>$project->data,"user_id"=>$project->user_id,"pass"=>$project->pass);
			}
			
		} else if($project->enter_by=="Client"){
			$enter = false;
			foreach($column as $col){
				if(($col->column_num==$project->col) && (int)$col->status==0){
					$enter = true;
				}
			}
			if($enter===true){
				/*if(strpos("'",$project->data)!==false){
					$columnData[] = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($project->data, ENT_QUOTES));
				} else {
					$columnData[] =$project->data;
				}
				*/
				$columnData[] = preg_replace("/'/", "&#39;", $project->data);
			} else {
				$columnData[] = 'Client Property';
			}
		}else if($project->enter_by=="User"){
			$columnData[] = 'Client Property';
			if($project->user_id==$userID){
				array_push($userColumnEntered,array('row'=>$project->row,'col'=>$project->col,'freecell'=>$project->id));
			}
		} else {
			$columnData[] = 'Client Property';
		}
	 }
	if(count($columnData)>0){
		$embedData[] = $columnData;
		$rowColID[] = $columnIds; 
	}
  }  
  $columnHeading = array();
  foreach($column as $heading){
	  /*switch($heading->column_num){
		  case 5:
		  case 6:
		  case 7:
		  	 $heading->heading  = '<span data-tooltip=\"Tooltip for column\" class=\"has-tooltip\">'.$heading->heading .'</span>';
		  break;
		  default:
			$heading->heading  = '<span class=\"no-tooltip\">'.$heading->heading .'</span>';
		  break;
	  }*/
	  $columnHeading[] = $heading->heading;
  }
  $colsFreeze = array();
  foreach($column as $heading){
	  $colsFreeze[] = $heading->status;
  }  
 ?>

<style>
.scroll-container {
    width: 100%;
    height: 250px;
    margin: 5px 0 1rem;
    overflow: hidden;
}
#transactions, #project-list{
	border:solid 0px #2196f3;background:#fff;
}
.cp-border{
	border:solid 1px #2196f3;
}
#transactions > thead > tr > th,#project-list > thead > tr > th, #transactions > tbody > tr > td, #project-list > tbody > tr > td{
	border:solid 0px #d1c8c8;
	border-bottom:solid 1px #d1c8c8;	
}
#transactions > thead > tr > th,#project-list > thead > tr > th{background-color:#fff;font-weight:bold}
.panel{border:0px;/*background:#f1f1f1*/}
.control-label{font-weight:normal;text-align:left;}
.form-horizontal .control-label{text-align:left;}
#project-list tr.activetr td, #project-list tr.activetr td a{ color:#2196f3 !important;}
#project-list tr.activetr:hover,#project-list tr.activetr:hover td{
	
	color:#2196f3 !important;
}
#project-list tr.activetr:hover td a{
	
	color:#2196f3 !important;
}
.htCore,.handsontable .htDimmed{
	color:#222222
}
.htCore{font-size:13px;}
#page-wrapper{background:#f1f1f1}
.handsontable th:first-child, .handsontable td:first-of-type, .handsontable .htNoFrame + th, .handsontable .htNoFrame + td {border-left:0px solid #CCC}
/*.handsontable th, .handsontable td, .handsontable th:last-child{border-right:0px solid #CCC}*/
.handsontable th{border-top:0px solid #CCC !important;background:#fff;font-weight:bold}
.handsontable th, .handsontable td{padding:5px;}
.handsontable thead th .relative{text-align:left;padding:5px;}
.handsontable th, .handsontable td{height:auto;line-height:normal;}

.has-tooltip:hover .tooltip1{}
.tooltip1{opacity:0;visibility:hidden;-webkit-transition:opacity 0.1s linear, visibility 0.1s linear;-moz-transition:opacity 0.1s linear, visibility 0.1s linear;transition:opacity 0.1s linear, visibility 0.1s linear;-webkit-transition-delay:0;-moz-transition-delay:0;transition-delay:0}
.tooltip1 {
    position: fixed;
    max-width: 700px;
    padding: .75em 1em;
    z-index: 9999;
    line-height: 1.3;
    background: #222;
    background: rgba(34,34,34,0.9);
    color: #eee;
    font-size: 13px !important;
    font-weight: normal !important;
    text-align: left !important;
    text-transform: none !important;
    border-radius: 3px;
}
.has-tooltip {
    cursor: help;
    border-bottom: 1px dotted #aaa;
}
.rejected_entry{
	background:#d43f3a !important;
}
.user-entry{
	background:#5cb85c !important;
}
.light-grey{
	background-color:#E8E8E8 !important;
}
#project-list tr.fnt-blue td, #project-list tr.fnt-blue td a
{
	color:#2146a3;
}
.htPlaceholder1{color:red}
.tooltip-inner{width:200px;}
</style>
<div class="hide" id="basic-dialog" title="Email bounce notofication">
<div class="pad10A"></div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalVerifiedNumber">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Verification of Phone number</h4>
			</div>
			<div class="modal-body">				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="closeModalPopUp('#modalVerifiedNumber');">Close</button>
				<button type="button" class="btn btn-primary" id='verifyPhone' onclick="verifyPhone(jQuery(this))">Call</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalVerifiedEmail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Verification of Email address</h4>
			</div>
			<div class="modal-body">				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="closeModalPopUp('#modalVerifiedEmail');">Close</button>
				<button type="button" class="btn btn-primary" id='verifyEmail' onclick="verifyEmail(jQuery(this))">Call</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" role="dialog" id="modalLinkedIN">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">				
				<h4 class="modal-title">Verified Link</h4>
				<p class='intro-sh'></p>
			</div>			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" onclick="closeModalPopUp('#modalLinkedIN');"  id='btnCancel'>Close</button>
				<button type="button" class="btn btn-primary" id='verifyUrl' onclick="verifyUrl(jQuery(this))">Click to open the linkedin link in a new tab</button>
			</div>
		</div>
	</div>
</div>
<div class="panel">
    <div class="panel-body">
		<div id="sb-site"></div>
        <div class="example-box-wrapper">
			<?php echo form_open('outsource/dataentry/update_data',array('class'=>'form-horizontal bordered-row','id'=>'frm_data_entry'));?>
			<!--<div class="col-lg-12">
				<button type='button' class='btn btn-primary' onclick='checkAndSave();'>Save</button>
			</div>-->
			
			<div class="col-lg-4">				
			<h5 style='color:#2196f3;'><strong>Your Projects:</strong></h5>
			<div class="col-lg-12 cp-border scrollTable">				
				<table class="table" id="project-list">
					<thead>
					<tr>
						<th width="30px;"><a href='javascript://' class='collapseTable icn-plus' style='font-size:16px;color:#2196f3;font-weight:bold;width:20px;display:inline-block;text-align:left;'>+</a></th>
						<th>Name</th>
						<th>Max</th>
						<th>Min</th>
						<th>Avg</th>
						<th>Deadline</th>
						<th>Status</th>
					</tr>
					</thead>
					<tbody>       
						<?php 
							$user = $this->session->userdata('miner');
							$projectName = "";
							if(count($my_projects)>0){
								$i=1;
								foreach($my_projects as $project){
									$projectID = '~'.md5($project->id);
									$class='';
									$active='';
									if($id==$projectID){
										$active = 'activetr';
										$projectName = $project->project_name;
									}
									if($i>2){
										 $class="table-collapse hide";
									}
									$columnPHeading = $project->column_heading;
									$headingPrice=array();
									$total = 0;
									if(count($columnPHeading)>0){
										foreach($columnPHeading as $heading){
											$headingPrice[] = $heading->price;
											$total = $total + $heading->price;
										}
									}
									$colorClass="";
									if($project->status==1){
										$colorClass ="fnt-blue";
									}
									$avg = $total / count($headingPrice);
						?>
							<tr class='<?php echo $class?> <?php echo $colorClass;?> <?php echo $active;?> ' data-key="<?php echo $projectID?>" data-min-delay="<?php echo $project->id?>">
								<td><?php echo $i;?></td>
								<td><?php echo ((int)$project->status==1)?anchor('outsource/dataentry/start/'.$projectID,$project->project_name):$project->project_name;?></td>
								<td><?php echo max($headingPrice)?></td>
								<td><?php echo min($headingPrice)?></td>
								<td><?php echo number_format($avg,1,'.','');?></td>
								<td><?php echo ($project->deadline!='0000-00-00')?date('d M y',strtotime($project->deadline)):'';?></td>
								<td><?php echo ((int)$project->status==1)?"Ongoing":"Ended";?></td>
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
			</div>
			<!--<div class="col-lg-1"></div>-->
			
			<div class="col-lg-8 ">
			<h5 style='color:#2196f3;'><strong>Your work and rewards:</strong></h5>
			<div class="col-lg-12 cp-border scrollTable">
				<table class="table  pricing-table-show" id='transactions'>
					<thead>
						<tr>
							<th width="110px"><a href='javascript://' class='collapseTable icn-plus' style='font-size:16px;color:#2196f3;font-weight:bold;width:20px;display:inline-block;text-align:left;'>+</a></th>
							<th width="90px" class='text-center text-cell-email border-right-remove light-grey'>Email</th>
							<th width="90px" class='text-center text-cell-email border-right-remove light-grey' >Price</th>
							<th width="90px" class='text-center text-cell-email border-right-remove light-grey'>Total</th>
							<th width="100px" class='text-center text-cell-telephone'>Workphone</th>
							<th width="90px" class='text-center text-cell-telephone'>Price</th>
							<th width="90px" class='text-center text-cell-telephone'>Total</th>
							<th width="100px" class='text-center text-cell-phone light-grey'>Cellphone</th>
							<th width="90px" class='text-center text-cell-phone light-grey'>Price</th>
							<th width="90px" class='text-center text-cell-phone light-grey'>Total</th>
							<th width="100px" class='text-center text-cell-linkedin'>LinkedIn</th>
							<th width="100px" class='text-center text-cell-linkedin'>Price</th>
							<th width="100px" class='text-center text-cell-linkedin'>Total</th>
							<th width="200px" class='text-center light-blue-1'>To pay</th>
							<th width="150px" class='text-center light-blue'>Paid</th>
							<th width="100px" class='text-center light-blue'>Bal</th>
						</tr>
					</thead>
					<tbody>
					<?php 
						$semailPrice = 0;
						$stelephonePrice = 0;
						$sphonePrice = 0;
						$slinkedinPrice = 0;	
						$emailCount = 0;
						$telephoneCount = 0;
						$phoneCount = 0;
						$linkedinCount = 0;
						$sbalance = 0;
						$spaidNow = 0;
						$stotal = 0;
						$checkFlag = false;
						if(count($find_my_all_projects)>0){
							foreach($find_my_all_projects as $userEntry){
								$projectID = '~'.md5($userEntry['project_id']);
								if($projectID==$id){
									$checkFlag = true;
									$allActivities = $userEntry['activities'];
									$find_my_current_month_entry = $allActivities['current_project'];
									$coumnHeading = $allActivities['column_heading'];
									foreach($coumnHeading as $entry){
										switch((int)$entry->column_num){
											case 5:
												$semailPrice = $entry->price;
											break;
											case 6:
												$stelephonePrice = $entry->price;
											break;
											case 7:
												$sphonePrice = $entry->price;
											break;
											case 8:											
												$slinkedinPrice = $entry->price;
											break;
										}
									}
									foreach($find_my_current_month_entry as $entry){
										switch((int)$entry->col){
											case 5:
												$emailCount = $entry->count;
											break;
											case 6:
												$telephoneCount = $entry->count;
											break;
											case 7:
												$phoneCount = $entry->count;
											break;
											case 8:											
												$linkedinCount = $entry->count;
											break;
										}
									}
									$spaidNow = 0;
									if($userEntry['last_payment']!=null){
										$spaidNow = $userEntry['last_payment'];
									}
								}
							}
						} 
						if($checkFlag===false) {
							if(count($full_project_details['column_heading'])>0){
								foreach($full_project_details['column_heading'] as $heading){
									switch((int)$heading->column_num){
										case 5:
											$semailPrice = $heading->price;
										break;
										case 6:
											$stelephonePrice = $heading->price;
										break;
										case 7:
											$sphonePrice = $heading->price;
										break;
										case 8:
											$slinkedinPrice = $heading->price;
										break;
									}
								}
							}
						}
						$semailCal = $emailCount*$semailPrice;
						$stelephoneCal = $telephoneCount*$stelephonePrice;
						$sphoneCal = $phoneCount*$sphonePrice;
						$slinkedinCal = $linkedinCount*$slinkedinPrice;
						$stotal = $semailCal + $stelephoneCal + $sphoneCal + $slinkedinCal;
						$sbalance = $stotal - $spaidNow;
					?>
					<tr data-key="<?php echo $id?>">
							<td><a href="<?php echo $Layout->baseUrl?>outsource/dataentry/mydata/<?php echo $id?>" style="color:#2196f3"><?php echo $name;?></a></td>
							<td class='text-center text-cell-con-email light-grey' data-price='<?php echo $semailPrice?>'><?php echo $emailCount;?></td>
							<td class='text-center text-cell-ph-email light-grey'><?php echo $semailPrice;?></td>
							<td class='text-center text-cell-sh-email light-grey'><?php echo $semailCal;?></td>
							<td class='text-center text-cell-con-phone' data-price='<?php echo $stelephonePrice?>'><?php echo $telephoneCount;?></td>
							<td class='text-center text-cell-ph-phone'><?php echo $stelephonePrice;?></td>
							<td class='text-center text-cell-sh-phone'><?php echo $stelephoneCal;?></td>
							<td class='text-center text-cell-con-cphone light-grey' data-price='<?php echo $sphonePrice?>'><?php echo $phoneCount;?></td>
							<td class='text-center text-cell-ph-cphone light-grey'><?php echo $sphonePrice;?></td>
							<td class='text-center text-cell-sh-cphone light-grey'><?php echo $sphoneCal;?></td>
							<td class='text-center text-cell-con-linkedin' data-price='<?php echo $slinkedinPrice?>'><?php echo $linkedinCount;?></td>
							<td class='text-center text-cell-ph-linkedin'><?php echo $slinkedinPrice;?></td>
							<td class='text-center text-cell-sh-linkedin'><?php echo $slinkedinCal;?></td>
							<td class='text-center light-blue-1 text-total'><?php echo number_format($stotal,1,'.','');?></td>
							<td class='text-center light-blue text-paid'><?php echo number_format($spaidNow,1,'.','')?></td>
							<td class=' text-center light-blue text-bal'><?php echo number_format($sbalance,1,'.','')?></td>
					</tr>
						<?php 
							$currentEmail = 0;
							$currentLinkedIN= 0;
							$currentPhone = 0;
							$telePhone = 0;
							$phonePrice = 0;
							$linkedinPrice = 0;
							$telephonePrice = 0;
							$emailPrice = 0;
							if(count($find_my_all_projects)>0){
								
								foreach($find_my_all_projects as $userEntry){
									$projectID ='~'.md5($userEntry['project_id']);
									if($id!=$projectID):
								$name = $userEntry['name'];
								$allActivities = $userEntry['activities'];
								$find_my_current_month_entry = $allActivities['current_project'];
								$coumnHeading = $allActivities['column_heading'];
								foreach($coumnHeading as $entry){
									switch((int)$entry->column_num){
										case 5:
											$emailPrice = $entry->price;
										break;
										case 6:
											$telephonePrice = $entry->price;
										break;
										case 7:
											$phonePrice = $entry->price;
										break;
										case 8:											
											$linkedinPrice = $entry->price;
										break;
									}
								}
								foreach($find_my_current_month_entry as $entry){
									switch((int)$entry->col){
										case 5:
											$currentEmail = $entry->count;
										break;
										case 6:
											$currentPhone = $entry->count;
										break;
										case 7:
											$telePhone = $entry->count;
										break;
										case 8:											
											$currentLinkedIN = $entry->count;
										break;
									}
								}							
								$emailCal = $currentEmail*$emailPrice;
								$telephoneCal = $currentPhone*$telephonePrice;
								$phoneCal = $telePhone*$phonePrice;
								$linkedinCal = $currentLinkedIN*$linkedinPrice;
								$total = $emailCal + $telephoneCal + $linkedinCal + $phoneCal;
								
								$paidTillNow = 0;
								if($userEntry['last_payment']!=null){
									$paidTillNow = $userEntry['last_payment'];
								}
								$bal = $total - $paidTillNow;
						?>
					
					
						<tr data-key="<?php echo $projectID?>">
								<td><a href="<?php echo $Layout->baseUrl?>outsource/dataentry/mydata/<?php echo $projectID?>" style="color:#2196f3"><?php echo $name;?></a></td>
								<td class='text-center text-cell-con-email light-grey' data-price='<?php echo $emailPrice?>'><?php echo $currentEmail;?></td>
								<td class='text-center text-cell-ph-email light-grey'><?php echo $emailPrice;?></td>
								<td class='text-center text-cell-sh-email light-grey'><?php echo $emailCal;?></td>
								<td class='text-center text-cell-con-phone' data-price='<?php echo $telephonePrice?>'><?php echo $currentPhone;?></td>
								<td class='text-center text-cell-ph-phone'><?php echo $telephonePrice;?></td>
								<td class='text-center text-cell-sh-phone'><?php echo $telephoneCal;?></td>
								<td class='text-center text-cell-con-cphone light-grey' data-price='<?php echo $phonePrice?>'><?php echo $telePhone;?></td>
								<td class='text-center text-cell-ph-cphone light-grey'><?php echo $phonePrice;?></td>
								<td class='text-center text-cell-sh-phone light-grey'><?php echo $phoneCal;?></td>
								<td class='text-center text-cell-con-linkedin' data-price='<?php echo $linkedinPrice?>'><?php echo $currentLinkedIN;?></td>
								<td class='text-center text-cell-ph-linkedin'><?php echo $linkedinPrice;?></td>
								<td class='text-center text-cell-sh-linkedin'><?php echo $linkedinCal;?></td>
								<td class='text-center light-blue-1 text-total'><?php echo number_format($total,1,'.','');?></td>
								<td class='text-center light-blue text-paid'><?php echo number_format($paidTillNow,1,'.','')?></td>
								<td class=' text-center light-blue text-bal'><?php echo number_format($bal,1,'.','')?></td>
								
						</tr>
								<?php endif;} }?>
								<?php /*
						<tr>
							<?php 
								$email = 0;
								$telephone = 0;
								$currentPhone = 0;
								$linkedin = 0;		
								$emailCal = 0;
								$telephoneCal = 0;
								$phoneCal = 0; 
								$linkedinCal = 0;
								if(count($find_all_project_entry)>0){
									foreach($find_all_project_entry as $entry){
										switch((int) $entry->col){
											case 5:
												$email = $email + $entry->count;
												$emailCal = $emailCal + ($entry->count * $entry->price);
											break;
											case 6:
												$telephone = $telephone + $entry->count;
												$telephoneCal = $telephoneCal + ($entry->count * $entry->price);
											break;
											case 7:
												$currentPhone = $currentPhone + $entry->count;
												$phoneCal = $phoneCal + ($entry->count * $entry->price);
											break;
											case 8:
												$linkedin = $linkedin + $entry->count;
												$linkedinCal = $linkedinCal + ($entry->count * $entry->price);
											break;
										}
									}
								}
							?>
							<td class=''>All</td>
							<td class='text-center light-grey'><?php echo $email;?></td>
							<td class='text-center light-grey'></td>
							<td class='text-center light-grey'><?php echo $emailCal?></td>
							<td class='text-center'><?php echo $telephone;?></td>
							<td class='text-center'></td>
							<td class='text-center'><?php echo $telephoneCal?></td>
							<td class='text-center light-grey'><?php echo $currentPhone;?></td>
							<td class='text-center light-grey'></td>
							<td class='text-center light-grey'><?php echo $phoneCal?></td>
							<td class='text-center' ><?php echo $linkedin;?></td>
							<td class='text-center' ></td>
							<td class='text-center' ><?php echo $linkedinCal?></td>
							<td class='text-center light-blue-1' >&dollar;<?php echo ($linkedinCal+$telephoneCal+$emailCal);?></td>
							<td class='text-center light-blue' ></td>
							<td class='text-center light-blue'></td>
						</tr>
						*/?>						
						<?php 
							/*if(count($transactions)>0){
								foreach($transactions as $entry){
									$email = 0;
									$telephone = 0;
									$linkedin = 0;		
									$emailCal = 0;
									$linkedinCal = 0;
									$linkedinCal = 0;									
									switch((int) $entry->col){
										case 5:
											$email = $email + $entry->count;
											$emailCal = $emailCal + ($entry->count * $entry->col_price);
										break;
										case 6:
											$telephone = $telephone + $entry->count;
											$linkedinCal = $linkedinCal + ($entry->count * $entry->col_price);
										break;
										case 7:
											$linkedin = $linkedin + $entry->count;
											$linkedinCal = $linkedinCal + ($entry->count * $entry->col_price);
										break;
									}
									
						?>
								<tr>
									<td><?php echo date('M d, y',strtotime($entry->created_date))?></td>
									<td class='text-center'><?php echo $email;?></td>
									<td class='text-center'><?php echo $emailCal?></td>
									<td class='text-center'><?php echo $telephone;?></td>
									<td class='text-center'><?php echo $telephoneCal?></td>
									<td class='text-center' ><?php echo $linkedin;?></td>
									<td class='text-center' ><?php echo $linkedinCal?></td>
									<td class='text-center light-blue-1' >&dollar;<?php echo ($linkedinCal+$telephoneCal+$emailCal);?></td>
									<td class='text-center light-blue' ></td>
									<td class='text-center light-blue'></td>
								</tr>
						<?php 
								}
							}*/
						?>
					</tbody>
				</table>
			</div>			
			</div>			
			<div class='col-lg-12 mrg10T'><div class='col-lg-3'><h5 style='color:#2196f3;display:inline-block'><strong>Your worksheet: <?php echo $projectName;?></strong></h5></div><div class='col-lg-9'><span class='pull-right text-left'>Click the <span style="color:red">Enter Data</span> links below and enter your researched data. If found incorrect - <span style="color:blue">they will be shown in blue</span>. <span style="color:red">Existing data in red</span> represent incorrect items that were entered by other researchers. Feel free to replace them with your correct findings. A researcher's account with over 5 incorrect findings will be automatically suspended for 45 days.</span></div></div>
			<div class="scroll-container col-lg-12 cp-border">
				<div id='contacts_table' class="hot handsontable htRowHeaders htColumnHeaders" style='width:100%'></div>
			</div>
            <?php echo form_hidden('dataentry[key]',$id);
			 echo form_hidden('dataentry[put]',"dataentry");?>
			<?php echo form_close();?>
			
			<script>
			
				jQuery('.collapseTable').click(function(){
					if(jQuery(this).hasClass('icn-plus')){
						jQuery('.collapseTable').addClass('icn-minus').removeClass('icn-plus').html('-');
					} else {
						jQuery('.collapseTable').addClass('icn-plus').removeClass('icn-minus').html('+');
					}
					jQuery('.table-collapse').toggle();
				});
				setTimeout(function(){
					toolTIP();
				},3000);
				setInterval(function(){
					checkMyFailure();
				},10000);
				
				function checkMyFailure(){
					checkBounceEmails();
				}
				
				function toolTIP(){
					jQuery('.has-tooltip').mouseover(function(e){
						 pr = jQuery(this).parents('tr');
						 _index = pr.index(jQuery(this));
						 mouseX = e.pageX;
						_windowW = jQuery(window).width();
							
						if((_windowW-mouseX)<700){
								mouseX = mouseX-(700 - (_windowW-mouseX)-200);
							}
						
							
							mouseY = e.pageY;
							mouseY = mouseY+10;
							jQuery('.tooltip1').css({left:mouseX,top:mouseY,opacity:1,visibility:'visible','-webkit-transition-delay':'1.5s','-moz-transition-delay':'1.5s','transition-delay':'1.5s'}).html(jQuery(this).data('tooltip'));
						});jQuery('.has-tooltip').mouseout(function(e){
							jQuery('.tooltip1').css({opacity:1,visibility:'hidden'});
						});
				}
				__baseUrl = '<?php echo $Layout->baseUrl?>';
					var topBar = jQuery('.top-bar').height();
					var mainHeader = jQuery('.main-header').height();
					failureContent = JSON.parse('<?php echo json_encode($user_rejected_data)?>');
					userEnterColumn= JSON.parse('<?php echo json_encode($userColumnEntered)?>');
					freecells = JSON.parse('<?php echo json_encode($rowColID)?>');
					var totalHeight = jQuery(window).height();
					var mainHeight = totalHeight - 180 - topBar;
					jQuery('.scroll-container').css('height',mainHeight+'px');
					var cCounter = 0;
					var
					cntTable = document.getElementById('contacts_table'),
					maxed = true,
					resizeTimeout,
					availableWidth=jQuery(window).width(),
					availableHeight,
					objHands,minHands,_change = [], colsFreeze=JSON.parse('<?php echo json_encode($colsFreeze)?>');
					__data9 = '<?php echo json_encode($embedData);?>';
					_heading = '<?php echo json_encode($columnHeading)?>';
					_failedData = '<?php echo json_encode($failedData);?>';
					_failedDataParse = [];
					try{
						_failedDataParse = JSON.parse(_failedData);
					}catch(e){
						console.log(e);
					}
					 Handsontable.renderers.registerRenderer('negativeValueRendererMinor', negativeValueRendererMinor);
					objHands = new Handsontable(cntTable, {
					  data: JSON.parse(__data9),
					  autoWrapCol:true,
					  wordWrap:true,
					  rowHeaders: false,
					  colHeaders: JSON.parse(_heading),
					  minSpareRows: 0,
					  width:availableWidth+'px',
					  minSpareCols: 0,
					  minCols: <?php echo (int)$cols?>,
					  maxCols: <?php echo (int)$cols?>,
					  maxRows: <?php echo (int)$rows?>,
					  fillHandle: false,
					  stretchH:"all",
					  autoWrapRow: true,
					  manualColumnResize:true,
					  contextMenu: false,
					  placeholder:'Enter Data',
					  placeholderCellClassName:'htPlaceholder1',
					  cells: function (row, col, prop) {
						  var cellProperties = {};
						  cellProperties.renderer = "negativeValueRendererMinor";
						  return cellProperties;
					  },
					  columnSorting: {
						column: 0,
						sortOrder: false
					  }
				});
				objHands.addHook('afterRender',function(){
					toolTIP();
				})
				objHands.addHook('afterChange',function(changes,source){
					var ele=this;
					if(!changes){
						return;
					}
					$.each(changes,function(index,element){
						
						if(element[3]!='Client Property' && element[3]!='Accepted' ){
							$(ele.getCell(element[0],ele.propToCol(element[1]))).addClass('changeInput');
							ele.getCellMeta(element[0],ele.propToCol(element[1])).readOnly=false;
							if(parseInt(colsFreeze[element[1]])==1){
								switch(parseInt(element[1])){
									case 4:
										/*Verified Email*/
										/*if(element["3"]!="" && validateEmail(element["3"]) && isEmailGood(element["3"])){
											verifiedEmail(element);
										} else {
											if(element["3"]!=""){
												$.jGrowl("Incorrect data", {
													  sticky: false,
													  position: 'top-right',
													  theme: 'bg-red'
												 });
												 ac = [];
												 ac.push(element[0]);
												 ac.push(element[1]);
												 failureContent.push(ac);
												 $(ele.getCell(element[0],ele.propToCol(element[1]))).css('color','red').addClass('not-accepted');
												ele.getCellMeta(element[0],ele.propToCol(element[1])).readOnly=false;
											}											
										}*/	
										if(element[3]!="Enter Data"){
												if(element["3"]!="" && validateEmail(element[3]) && isEmailGood(element[3])){
												jQuery('#modalVerifiedEmail').find('div.modal-body').html('');
												jQuery("#modalVerifiedEmail").data('dt',element).modal("show");	
												jQuery('#verifyEmail').data("l","0");												
												jQuery('#verifyEmail').html("Click to verify");
												verifyEmail(jQuery('#verifyEmail'));
											} else {
												if(element[3]!=''){
													$.jGrowl("Incorrect Data ", {
														  sticky: false,
														  position: 'top-right',
														  theme: 'bg-red'
													 });
												}
												
												$(ele.getCell(element[0],ele.propToCol(element[1]))).css('color','red').addClass('not-accepted');
												ele.getCellMeta(element[0],ele.propToCol(element[1])).readOnly=false;
											}
										}
										
									break;
									case 5:	
									case 6:
										/*Mobile and Telephone*/
										if(element[3]!="Enter Data"){
											if(phoneVerification(element[3])){
												jQuery('#modalVerifiedNumber').find('div.modal-body').html('');
												jQuery("#modalVerifiedNumber").data('dt',element).modal("show");	
												jQuery('#verifyPhone').data("l","1");
												jQuery('#verifyPhone').html("Click to verify");
												verifyPhone(jQuery(this));
											} else {
												if(element[3]!=''){
													jQuery.jGrowl("Incorrect Data ", {
														  sticky: false,
														  position: 'top-right',
														  theme: 'bg-red'
													 });
												}
												
												$(ele.getCell(element[0],ele.propToCol(element[1]))).css('color','red').addClass('not-accepted');
												ele.getCellMeta(element[0],ele.propToCol(element[1])).readOnly=false;
											}
										}
										
										/*if(jQuery("#user_number").val()!=""){
											if(phoneVerification(element[3])){
												jQuery('#modalVerifiedNumber').find('div.modal-body').html('');
												jQuery("#modalVerifiedNumber").data('dt',element).modal("show");	
												jQuery('#verifyPhone').data("l","1");
												jQuery('#verifyPhone').html("Click to verify");
												verifyPhone(jQuery(this));
											} else {
												if(element[3]!=''){
													$.jGrowl("Incorrect Data ", {
														  sticky: false,
														  position: 'top-right',
														  theme: 'bg-red'
													 });
												}
												
												$(ele.getCell(element[0],ele.propToCol(element[1]))).css('color','red').addClass('not-accepted');
												ele.getCellMeta(element[0],ele.propToCol(element[1])).readOnly=false;
											}
											
										} else {
											_html = "<p class='intro-sh'>Verified Phone number <span id='number'>"+element[3]+"</span></p><p class='intro-sh'>Enter your number for verification <input type='text' class='form-control' placeholder='Telephone verfification number' id='userNumber' /></p>";
											jQuery('#modalVerifiedNumber').find('div.modal-body').html(_html);
											jQuery("#modalVerifiedNumber").data('dt',element).modal("show");
										}*/
										/*console.log(jQuery("#user_number").val());*/
									break;
									case 7:
										/*LinkedIn Url*/
										if(element[3]!=""){
											hostname= getHostName(element[3]);
											if(element[3]!='' && hostname!= null && hostname.toLowerCase()=="linkedin.com"){
												jQuery("#verifyUrl").data('l',"0");
												jQuery("#modalLinkedIN").data('dt',element).modal("show");
											} else {
												if(hostname==null && element[3]!=''){
													$.jGrowl("Incorrect Data ", {
														  sticky: false,
														  position: 'top-right',
														  theme: 'bg-red'
													 });
												}
												
												$(ele.getCell(element[0],ele.propToCol(element[1]))).css('color','red').addClass('not-accepted');
												ele.getCellMeta(element[0],ele.propToCol(element[1])).readOnly=false;
											}
										}
										
										
									break;
								}
							}
						}						
					});
				});
				function validateEmail(sEmail) {
					var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
					if (filter.test(sEmail)) {
						return true;
					}
					else {
						return false;
					}
				}
				function getHostName(url) {
					var match = url.match(/:\/\/(www[0-9]?\.)?(.[^/:]+)/i);
					if (match != null && match.length > 2 && typeof match[2] === 'string' && match[2].length > 0) {
					return match[2];
					}
					else {
						return null;
					}
				}
				function phoneVerification(phoneNumber){
					splitTel = phoneNumber.split('-');
					if(splitTel.length==4){
						return true;
					} else {
						return false;
					}
					/*var match = phoneNumber.match(/\D/);
					if (match != null && match.length > 2  && match[2].length > 0) {
						return match[2];
					}
					else {
						return null;
					}
					return !isNaN(parseFloat(phoneNumber)) && isFinite(phoneNumber);*/
				}
				/*blockIn = "";currentBlock = [];
				objHands.addHook('afterSelection', function (row, col) {
					if(typeof currentBlock!="undefined" && currentBlock.length>0){
						
						data = {r:currentBlock[0],c:currentBlock[1],key:jQuery('input[name="dataentry[key]"]').val()},
						call(__baseUrl+'outsource/dataentry/row_unblock','POST',data,showCheckStatus,'json');
					}
					data={r:row,c:col,key:jQuery('input[name="dataentry[key]"]').val()};
					call(__baseUrl+'outsource/dataentry/check_row_block','POST',data,showCheckStatus,'json');
				});*/
				window.showCheckStatus = function(data,textStatus,xhr){
					if(typeof data.open!="undefined" && data.open==1){
						/*Block for this user not to enter data*/
						
					} else {
						/*Open gate for this user and block for other for 15 min.*/
						data={r:row,c:col,key:jQuery('input[name="dataentry[key]"]').val()};
						call(__baseUrl+'outsource/dataentry/row_block_for_other','POST',data,showBlockStatus,'json');
					}
				}
				window.showBlockStatus = function(data,textStatus,xhr){
					if(typeof data.gateway!="undefined" && parseInt(data.gateway)>0){
						currentBlock = [];
						currentBlock.push(data.r);
						currentBlock.push(data.c);
					}					
				}
				function verifiedEmail(changes){
					data={enter_data:changes,key:jQuery('input[name="dataentry[key]"]').val()};
					call(__baseUrl+'outsource/dataentry/verify_email','POST',data,showVerifiedChanges,'json');
				}
				var invalidDomains = ["@gmail.","@yahoo.","@hotmail.","@live.","@aol.","@outlook.","@msn."];
				function isEmailGood(email) {
					for(var i=0; i < invalidDomains.length; i++) {
					  var domain = invalidDomains[i];
					  if (email.indexOf(domain) != -1) {
						return false;
					  }
					}
					return true;
				}
				function updateStatusHistory(ID){
					data = {id:ID};
					call(__baseUrl+'outsource/dataentry/update_verification_history','POST',data,doneStatus,'json');
				}
				window.doneStatus = function(data,textStatus,xhr){
					
				}
				
				window.checkBounceEmails = function(){
					data={key:jQuery('input[name="dataentry[key]"]').val()};
					call(__baseUrl+'outsource/dataentry/check_bounce_emails','POST',data,showBounceMessage,'json');
				}
				window.showBounceMessage =function(data,textStatus,xhr){
					if(typeof data.get_all_bounce_emails!="undefined" && data.get_all_bounce_emails.length>0){
						_data = "";
						changes = [];
						_pActive = jQuery('#project-list').find('tr.activetr').attr('data-min-delay');
						$.each(data.get_all_bounce_emails,function(index,element){
							change =[];
							row = element.row;
							col = element.col;
							_data +="<tr><td>"+element.data+"</td></tr>";
							change.push(row-1);
							change.push(col-1);
							changes.push(change);
							if(_pActive==element.project_id){
								ele = objHands;
								$(ele.getCell(row-1,ele.propToCol(col-1))).css('background','red').addClass('not-accepted');
								ele.getCellMeta(row-1,ele.propToCol(col-1)).readOnly=false;
								socketSend(change[0],change[1],"");
								__data9 = objHands.getSourceData();
								__data9[change[0]][change[1]] = change[2];
								__data9 = JSON.stringify(__data9);
								objHands.render();
								updateStatusHistory(element.id);
							}							
						});
						
						/*jQuery("#basic-dialog").find('div').html('<table><tbody>'+_data+'</tbody></table>');
						$("#basic-dialog").dialog({
							modal: true,
							minWidth: 500,
							minHeight: 200,
							dialogClass: "",
							show: "fadeIn",
							closeOnEscape: false,
							open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog | ui).hide(); },
							buttons: {
								"OK": function() {
									$(this).dialog("close");
									window.location = window.location.href;
								}
							}
						});
						$('.ui-widget-overlay').addClass('bg-black opacity-100');*/
						/*updateCellData(changes);	*/					
					}
				}
				/*setInterval(checkBounceEmails,10000);*/
				function verifyPhone(o){					
					_f = jQuery("#user_number").val();
					if(_f==""){
						_f = jQuery("#userNumber").val();
					}
					d = o.data('l');
					if(typeof _f!="undefined" && _f!=""){
						if(d=="undefined" || d==undefined || d=="0"){
							o.data("l","1");
							o.html("Click to verify");
							dt = jQuery("#modalVerifiedNumber").data('dt');
							jQuery('#modalVerifiedNumber').find('div.modal-body').html('<p>I hereby confirm that I checked this number and verified that it rings at this persons desk. Providing incorrect information might cause my account to be suspended.</p>');
							/*if(typeof dt[3]!="undefined"){
								jQuery("#user_number").val(_f);
								
								call('http://37.60.243.223/~synpat19/vendor/ringcentral/ringcentral-php/demo/ringout.php?p='+dt[3]+'&f='+_f+'&e=101','GET','',callStatus,'text');
							}*/						
						}  else if(d=="1"){
							/*Verification done, change to red*/
							o.data("l","0");
							o.html("Call");
							/*Save Call*/
							_changes = jQuery("#modalVerifiedNumber").data('dt');
							freeRideCell = callFreeRide(_changes);
							jQuery("#modalVerifiedNumber").data('dt',"undefined");
							jQuery("#modalVerifiedNumber").modal("hide");
							if(freeRideCell>0){
								data={enter_data:_changes,key:jQuery('input[name="dataentry[key]"]').val(),free_ride:freeRideCell};
								call(__baseUrl+'outsource/dataentry/update_singleton','POST',data,showVerifiedChanges,'json');
							}
							/*End Save Call*/
						}
					}										
				}
				
				function verifyEmail(o){					
					/*_f = jQuery("#user_number").val();
					if(_f==""){
						_f = jQuery("#userNumber").val();
					}*/
					d = o.data('l');
					/*if(typeof _f!="undefined" && _f!=""){*/
						if(d=="undefined" || d==undefined || d=="0"){
							o.data("l","1");
							o.html("Click to verify");
							
							dt = jQuery("#modalVerifiedEmail").data('dt');
							jQuery('#modalVerifiedEmail').find('div.modal-body').html('<p>I hereby confirm that I checked this email address and verified that it delivered to this person inbox. Providing incorrect information might cause my account to be suspended.</p>');
							/*if(typeof dt[3]!="undefined"){
								jQuery("#user_number").val(_f);
								
								call('http://37.60.243.223/~synpat19/vendor/ringcentral/ringcentral-php/demo/ringout.php?p='+dt[3]+'&f='+_f+'&e=101','GET','',callStatus,'text');
							}*/						
						}  else if(d=="1"){
							/*Verification done, change to red*/
							o.data("l","0");
							o.html("Click to verify");
							/*Save Call*/
							_changes = jQuery("#modalVerifiedEmail").data('dt');
							freeRideCell = callFreeRide(_changes);
							jQuery("#modalVerifiedEmail").data('dt',"undefined");
							jQuery("#modalVerifiedEmail").modal("hide");
							if(freeRideCell>0){
								data={enter_data:_changes,key:jQuery('input[name="dataentry[key]"]').val(),free_ride:freeRideCell};
								call(__baseUrl+'outsource/dataentry/update_singleton','POST',data,showVerifiedChanges,'json');
							}
							
							/*End Save Call*/
						}
					/*}*/										
				}
				window.callStatus = function(){
					
				}
				function callFreeRide(_changes){
					var logicalIndex = _changes[0];
					var physicalIndex = objHands.sortIndex.length > 0 ? objHands.sortIndex[logicalIndex][0] : logicalIndex;
					var freeCellRide=0;
					if(freecells.length>0){
						try{
							_freecellProp = freecells[physicalIndex];
							for(fr=0;fr<_freecellProp.length;fr++){
								_fCol = parseInt(_freecellProp[fr][2]) - 1;
								if(_fCol==_changes[1]){
									freeCellRide = _freecellProp[fr][1];
								}
							}
						} catch(err){
							console.log(err);
						}								
					}
					return freeCellRide;
				}
				
				function callFreeRideEntryUser(_changes){
					var logicalIndex = _changes[0];
					var physicalIndex = objHands.sortIndex.length > 0 ? objHands.sortIndex[logicalIndex][0] : logicalIndex;
					var freeCellRide=0;
					if(freecells.length>0){
						try{
							
							_freecellProp = freecells[physicalIndex];
							
							for(fr=0;fr<_freecellProp.length;fr++){
								_fCol = parseInt(_freecellProp[fr][2]) - 1;
								if(_fCol==_changes[1]){
									
									freeCellRide = _freecellProp[fr][3];
									
								}
							}
						} catch(err){
							console.log(err);
						}								
					}
					return freeCellRide;
				}
				
				function verifyUrl(o){
					d = o.data('l');
					if(d=="undefined" || d==undefined || d=="0"){
						o.data("l","1");						
						dt = jQuery("#modalLinkedIN").data('dt');						
						if(typeof dt[3]!="undefined"){
							window.open(dt[3],"_blank");
							jQuery('#modalLinkedIN').find('p.intro-sh').html('Do you verify this linkedin link as the valid linkedin link of the person?');
							jQuery("#btnCancel").html("No");
							o.html("Yes");
						}						
					} else if(d=="1"){
						/*Verification done, change to red*/
						o.data("l","0");
						jQuery('#modalLinkedIN').find('p.intro-sh').html('');
						o.html("Click to open the linkedin link in a new tab");
						jQuery("#btnCancel").html("Cancel");
						/*Save Call*/
						_changes = jQuery("#modalLinkedIN").data('dt');
						freeRideCell = callFreeRide(_changes);
						jQuery("#modalLinkedIN").data('dt',"undefined");
						jQuery("#modalLinkedIN").modal("hide");
						if(freeRideCell>0){
							data={enter_data:_changes,key:jQuery('input[name="dataentry[key]"]').val(),free_ride:freeRideCell};
							call(__baseUrl+'outsource/dataentry/update_singleton','POST',data,showVerifiedChanges,'json');
						}
						/*End Save Call*/
						
					}					
				}
				function updateCellData(changes){
					/*if(changes.length>0){
						$.each(changes,function(index,change){
							objHands.getCellMeta(_change[0],objHands.propToCol(_change[1])).readOnly=false;
							objHands.setDataAtCell(_change[0],objHands.propToCol(_change[1]),'');
							$(objHands.getCell(_change[0],objHands.propToCol(_change[1]))).css({backgroundColor:"#efefef"}).html('');
						});
					}*/
				}
				function closeModalPopUp(obj){
					_change = jQuery(obj).data('dt');
					jQuery(obj).data('dt',"undefined");
					jQuery(obj).modal("hide");
					setTimeout(function(){
						jQuery(".modal-backdrop").remove();
					},1000);
					
					objHands.getCellMeta(_change[0],objHands.propToCol(_change[1])).readOnly=false;
					objHands.setDataAtCell(_change[0],objHands.propToCol(_change[1]),'');
					$(objHands.getCell(_change[0],objHands.propToCol(_change[1]))).css({backgroundColor:"#fff",color:'red'}).addClass('htPlaceholder1').html('Enter Data');
				}
				function updateMoney(cell){
					
					_key = jQuery("input[name='dataentry[key]']").val();
					_ts = jQuery("#transactions").find("tbody").find("tr[data-key='"+_key+"']");
					switch(parseInt(cell)){
						case 4:
							_p = 0;
							if(typeof _ts=="object"){
								_p = _ts.find('td.text-cell-con-email').data('price');
							}
							_v = _ts.find('td.text-cell-con-email').text();
							if(isNaN(_v)){
								_v = 0;
							}							
							/*_v = parseInt(_v);*/
							_v = parseInt(_v) + 1;
							_p = parseFloat(_p);
							_calPrice = parseInt(_v) * _p;
							_calPrice = _calPrice.toFixed(1);
							
							jQuery('.pricing-table-show').find('td.text-cell-con-email').text(_v);
							jQuery('.pricing-table-show').find('td.text-cell-sh-email').text(_calPrice);
						break;
						case 5:
							_p=0;
							if(typeof _ts=="object"){
								_p = _ts.find('td.text-cell-con-phone').data('price');
							}							
							_v = jQuery('.pricing-table-show').find('td.text-cell-con-phone').text();
							_v = parseInt(_v);
							if(isNaN(_v)){
								_v = 0;
							}
							_v = parseInt(_v) + 1;
							_p = parseFloat(_p);
							_calPrice = parseInt(_v) * _p;
							_calPrice = _calPrice.toFixed(1);
							
							jQuery('.pricing-table-show').find('td.text-cell-con-phone').text(_v);
							jQuery('.pricing-table-show').find('td.text-cell-sh-phone').text(_calPrice);
						break;
						case 6:
							_p=0;
							if(typeof _ts=="object"){
								_p = _ts.find('td.text-cell-con-cphone').data('price');
							}							
							_v = jQuery('.pricing-table-show').find('td.text-cell-con-cphone').text();
							_v = parseInt(_v);
							if(isNaN(_v)){
								_v = 0;
							}
							_v = parseInt(_v) + 1;
							_p = parseFloat(_p);
							_calPrice = parseInt(_v) * _p;
							_calPrice = _calPrice.toFixed(1);
							
							jQuery('.pricing-table-show').find('td.text-cell-con-phone').text(_v);
							jQuery('.pricing-table-show').find('td.text-cell-sh-phone').text(_calPrice);
						break;
						case 7:
							_p=0;
							if(typeof _ts=="object"){
								_p = _ts.find('td.text-cell-con-linkedin').data('price');
							}
							_v = jQuery('.pricing-table-show').find('td.text-cell-con-linkedin').text();
							_v = parseInt(_v);
							if(isNaN(_v)){
								_v = 0;
							}							
							_v = parseInt(_v) + 1;
							_p = parseFloat(_p);
							_calPrice = parseInt(_v) * _p;
							_calPrice = _calPrice.toFixed(1);
							
							jQuery('.pricing-table-show').find('td.text-cell-con-linkedin').text(_v);
							jQuery('.pricing-table-show').find('td.text-cell-sh-linkedin').text(_calPrice);
						break;
					}
					_v = jQuery('.pricing-table-show').find('td.text-cell-sh-email').text();
					_v1 = jQuery('.pricing-table-show').find('td.text-cell-sh-phone').text();
					_v3 = jQuery('.pricing-table-show').find('td.text-cell-sh-cphone').text();
					_v2 = jQuery('.pricing-table-show').find('td.text-cell-sh-linkedin').text();
					__total = parseFloat(_v) + parseFloat(_v1) + parseFloat(_v2) + parseFloat(_v3);
					jQuery('.pricing-table-show').find('td.text-total').text(__total.toFixed(1));
					_paidTillNow = 0;
					if(typeof _ts=="object"){
						_paidTillNow = _ts.find('td.text-paid').text();
					}
					_paidTillNow = parseFloat(_paidTillNow);
					__bal = __total - _paidTillNow;
					jQuery('.pricing-table-show').find('td.text-bal').text(__bal.toFixed(1));
				}
				function showVerifiedChanges(data,textStatus,xhr){
					ele = objHands;
					if(typeof data.verified!="undefined" && parseInt(data.verified)==1){
						/*Cell change meta and freeze*/
						_change = data.changes;
						$(ele.getCell(_change[0],ele.propToCol(_change[1]))).css({backgroundColor:"green"}).html('');
						ele.getCellMeta(_change[0],ele.propToCol(_change[1])).readOnly=true;
						ele.setDataAtCell(parseInt(_change[0]),parseInt(_change[1]),'Accepted');
						updateMoney(_change[1]);	
						/*WS send*/
						var logicalIndex = _change[0];
						var physicalIndex = objHands.sortIndex.length > 0 ? objHands.sortIndex[logicalIndex][0] : logicalIndex;
						socketSend(physicalIndex,_change[1],"Client Property");
					} else {
						/*Show notification*/
						_change = data.changes;						
						$(ele.getCell(_change[0],ele.propToCol(_change[1]))).css({backgroundColor:"#fff"}).html('');
						ele.getCellMeta(_change[0],ele.propToCol(_change[1])).readOnly=false;
						ele.setDataAtCell(parseInt(_change[0]),parseInt(_change[1]),_change[4]);
						$(ele.getCell(parseInt(_change[0]),ele.propToCol(parseInt(_change[1])))).css('color','red').addClass('not-accepted');
						if(typeof data.error!="undefined" && parseInt(data.error)==1){
							$.jGrowl("Please try after sometime!", {
							  sticky: false,
							  position: 'top-right',
							  theme: 'bg-red'
						  });
						} else if(typeof data.email_error!="undefined" && parseInt(data.email_error)==1){
							$.jGrowl("Incorrect data.", {
								  sticky: false,
								  position: 'top-right',
								  theme: 'bg-red'
							  });
						}						
					}
				}
					function negativeValueRendererMinor(instance, td, row, col, prop, value, cellProperties){
						Handsontable.renderers.TextRenderer.apply(this, arguments);						
						 if (!value || value === '') {		
							if(parseInt(colsFreeze[col])==0){
								cellProperties.readOnly = true;
								return cellProperties;
							} else {
								/*td.style.background = '#fff';
								td.style.color = 'red';
								td.innerHTML ='Enter Data';
								td.className = 'has-tooltip';
								td.setAttribute("data-tooltip","This is tooltip.");	
								
								var cellProperties = {};
								cellProperties.readOnly=false;
								return cellProperties;*/
								td.style.background = '#fff';
								/*td.style.color = 'red';*/
								/*td.innerHTML ='';*/
								
								toolTip = "";
								class_name = "";
								if(col==7){
									class_name="has-tooltip";
									toolTip="<img src='https://s3-us-west-1.amazonaws.com/knzbeoknwf/public/images/linkedin_tooltip.png'/>";
								}
								if(col==5 || col==6){
									class_name="has-tooltip";
									toolTip="Enter ONLY work telephone. Neither personal phone nor company main number. Only the person's direct number at the company. Use this format: + Country Code - Area Code - Number . For example, in the USA: +1-415-902-5900.";
								}
								if(col==4){
									class_name="has-tooltip";
									toolTip="Enter ONLY work email address. Neither personal email nor company general email. Never use addresses like @gmail.com, @yahoo.com, @aol.com, @msn.com etc.  Only the person's direct email address with the domain of the company shown on this record.";
								}
								if(failureContent.length>0){
									
									_freeCell = td.getAttribute('free-cell');
									for(f=0;f<failureContent.length;f+=1){
										if(parseInt(_freeCell)==parseInt(failureContent[f].id)){
											class_name = class_name+" rejected_entry ";
										}
									}
								}
								class_name +=" htPlaceholder1";
								if(class_name!=""){
									
									td.className = class_name;
								}
								if(toolTip!=""){
									td.setAttribute("data-tooltip",toolTip);
								}
								var cellProperties = {};
								cellProperties.readOnly=false;
								return cellProperties;
							}
						}  else {
							if(value=='Client Property'){
								
								td.innerHTML ='';
								td.style.background = '#EFEFEF';
								class_name = 'no-entry';
								if(userEnterColumn.length>0){
									_freeCell = td.getAttribute('free-cell');
									for(u=0;u<userEnterColumn.length;u++){
										if(parseInt(_freeCell)==parseInt(userEnterColumn[u].freecell)){
											class_name = class_name+" user-entry ";
										}
									}
								}								
								td.className = class_name;
								cellProperties.readOnly=true;return cellProperties;
							}else if(value=='Accepted'){								
								
								td.innerHTML ='';
								td.style.background = 'green';
								cellProperties.readOnly=true;return cellProperties;
							} else if(parseInt(colsFreeze[col])==0){
								
								cellProperties.readOnly = true;
								return cellProperties;
							} else if(value=="Enter Data"){
								
								td.style.background = '#fff';
								td.style.color = 'red';
								/*td.innerHTML ='Enter Data';*/
								toolTip = "";
								class_name = "";
								if(col==7){
									class_name="has-tooltip";
									toolTip="<img src='https://s3-us-west-1.amazonaws.com/knzbeoknwf/public/images/linkedin_tooltip.png'/>";
								}
								if(col==5 || col==6){
									class_name="has-tooltip";
									toolTip="+x-xxx-xxx-xxxx";
								}
								if(failureContent.length>0){
									
									_freeCell = td.getAttribute('free-cell');
									for(f=0;f<failureContent.length;f+=1){
										if(parseInt(_freeCell)==parseInt(failureContent[f].id)){
											class_name = class_name+" rejected_entry ";
										}
									}
								}
								if(class_name!=""){
									class_name +=" htPlaceholder1";
									td.className = class_name;
								}
								if(toolTip!=""){
									td.setAttribute("data-tooltip",toolTip);
								}
								var cellProperties = {};
								cellProperties.readOnly=false;
								return cellProperties;
							} else {
								if(typeof objHands!="undefined"){
									if(value!="Enter Data"){
										cm = [row,col];
										tp = callFreeRideEntryUser(cm);
										ud=<?php echo $userID;?>;
										if(tp==ud){
											td.style.color = 'blue';
										} else {
											td.style.color = 'red';
										}										
									} else {
										td.className='has-tooltip';
									}							
									cellProperties.readOnly=false;
									return cellProperties;
								} else {
									_enterSpecialNode = false;
									if(_failedDataParse.length>0){
										jQuery.each(_failedDataParse,function(index,fd){
											if(fd.data==value){
												_enterSpecialNode = true;
												td.style.color = 'red';
												td.style.background = '#fff';
												/*td.style.color = 'red';*/
												/*td.innerHTML ='';*/
												
												toolTip = "";
												class_name = "";
												if(col==7){
													class_name="has-tooltip";
													toolTip="<img src='https://s3-us-west-1.amazonaws.com/knzbeoknwf/public/images/linkedin_tooltip.png'/>";
												}
												if(col==5 || col==6){
													class_name="has-tooltip";
													toolTip="Enter ONLY work telephone. Neither personal phone nor company main number. Only the person's direct number at the company. Use this format: + Country Code - Area Code - Number . For example, in the USA: +1-415-902-5900.";
												}
												if(col==4){
													class_name="has-tooltip";
													toolTip="Enter ONLY work email address. Neither personal email nor company general email. Never use addresses like @gmail.com, @yahoo.com, @aol.com, @msn.com etc.  Only the person's direct email address with the domain of the company shown on this record.";
												}
												if(class_name!=""){									
													td.className = class_name;
												}
												if(toolTip!=""){
													td.setAttribute("data-tooltip",toolTip);
												}
												return;
											}
										});
									}
									if(_enterSpecialNode===false){
										cellProperties.readOnly=true;
									}
									
									return cellProperties;
								}								
							}
						}
					}
					
					function showMessageSuccess(data,textStatus,xhr){
						if(parseInt(data)>0){
							showMessageOnFly("Record Saved!","alert-info");
							window.location = window.location.href;
						}
					}
					
					window.checkAndSave = function(){						
						jQuery('input[name="dataentry[put]"]').val(JSON.stringify(objHands.getData()));
						data = jQuery("#frm_data_entry").serializeArray();
						call(jQuery("#frm_data_entry").attr('action'),'POST',data,showMessageSuccess,'text');
					}
				</script>
				<script src="https://js.pusher.com/3.1/pusher.min.js"></script>
			<script>
			Pusher.logToConsole = false;
			var pusher = new Pusher('11f422c81016234a51c8', {
			  cluster: 'eu',
			  encrypted: true
			});
			 var channel = pusher.subscribe('my-channel');
			 channel.bind('my_event', function(data) {
				 _serial = '<?php echo $id?>';
				 if(typeof data.message!="undefined"){
					 _data = data.message;
					 if(_data.s==_serial){
						 __data9 = objHands.getSourceData();
						
						 __data9[_data.r][_data.c] = _data.sd;
						
						 __data9 = JSON.stringify(__data9);
						 objHands.render();
						 /*jQuery.each(__data9,function(index,d){
							if(  parseInt(d.id)>0 && parseInt(_data.da)>0 && parseInt(d.id)==parseInt(_data.da)){
								__data9[index][_data.c] = _data.sd;
								return;
							} 
						 });*/						 
					 }					 
				 }
			 });
			 function socketSend(r,c,cD){
				_cellData = cD;
				_serial = '<?php echo $id?>';
				data = {sd:_cellData,r:r,c:c,s:_serial,socket_id:pusher.connection.socket_id};
				call(__baseUrl+'outsource/dataentry/ws_data','POST',data,shWsData,'json');
			}
			window.shWsData = function(){
				
			}
			 </script>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
</div>
<span class='tooltip1'></span>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/collapse/collapse.js"></script>
</body>
</html>