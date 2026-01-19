<!DOCTYPE html>
<html lang ="en">
<head>

    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title>Projects/Users List</title>
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
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/datepicker-ui/datepicker.css">
    <!-- JS Core -->

    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-widget.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-mouse.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-position.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/transition.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/modal/modal.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/jgrowl-notifications/jgrowl.js"></script>
	
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/datepicker-ui/datepicker.js"></script>
	
    
	
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
		jQuery("#invitation").css("height",_h-20);
		if(jQuery(window).width()<1200){
			_w = jQuery(window).width();
			jQuery("#terms_page").css("width",_w-100);
			jQuery("#invitation").css("width",_w-100);
		}
		<?php 
			if(!isset($_SESSION)){
				session_start();
			}
			if(!isset($_SESSION['show_me'])):
		?>
		setTimeout(function(){jQuery('.sb-toggle-right').eq(0).trigger('click');disableShowMe()},500);
		<?php endif;?>
		/*
		jQuery("#project-list").tablesorter({sortList: [[6,1],[1,0]]});
		jQuery("#transactions").tablesorter({sortList: [[1,0],[2,0]]});*/
	});
	jQuery(document).ready(function(){
	$("#deadline").datepicker({dateFormat:'yy-mm-dd'});
});
	function disableShowMe(){
		jQuery.ajax({
			type:'POST',
			url:'<?php echo $Layout->baseUrl?>manager/show_me',
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
	$user = $this->session->userdata("manager");
?>
<div id="openRight" class="sb-slidebar bg-default sb-left sb-style-overlay sb-width-custom" data-sb-width="1200px">
	<div class="scrollable-content scrollable-slim-sidebar">
		<div class="pad15A">
			<a class='sb-close' href='javascript://'><i class='glyph-icon icon-close'></i></a>
			<iframe id="invitation" src="<?php echo $Layout->baseUrl?>manager/dataentry/invitation" scrolling="yes" width="1000px"></iframe>
		</div>
	</div>
</div>
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
		<div class="col-md-1 hidden-lg" style='/*width:4.333333333333332%*/'>
			<label class="col-sm-12 control-label">&nbsp;</label>
			<?php echo anchor('outsource/dataentry/logout','Logout',array('class'=>'pull-right','style'=>'color:#2196f3;'));?>
			<a href="javascript://" data-placement="bottom" class="sb-toggle-right pull-right mrg5R" title="" data-original-title="Statistics Sidebar" style='color:#2196f3'>
                Terms 
            </a>
		</div>
        <div class="col-md-11" style='/*width:95.66666666666666%*/'>
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
				<label class="col-sm-12 control-label">Password:</label>
				
				<input type="password" placeholder='Password' name="profile[password]" id="profilePassword" class="form-control update-profile">
				
			</div>
		</div>
		<div class="col-md-2">	
			<div class="input-group">
				<label class="col-sm-12 control-label">Email Address:</label>
				
				<input type="text" placeholder='Email Address' name="profile[email]" id="profileEmail" class="form-control update-profile" value="<?php echo $userData->email;?>">
				
			</div>
		</div>
		<div class="col-md-2">	
			<div class="input-group">			
				<label class="col-sm-12 control-label" style='padding-top:2px;'><img src="<?php echo $Layout->baseUrl;?>public/images/PP_logo_h_100x26.png" style='width:75px;'/></label>
				
				<input type="text" placeholder='Paypal Id' name="profile[paypal_address]" id="paypal_address" class="form-control update-profile" value="<?php echo $userData->paypal_address;?>">
				
			</div>
		</div>
		<div class="col-md-2">	
			<div class="input-group">
				<label class="col-sm-12 control-label">Telephone Number:</label>
				
				<input type="text" placeholder='Telephone' name="profile[user_number]" id="user_number" class="form-control update-profile" value="<?php echo $userData->user_number;?>" >
				
			</div>
		</div>
		<?php echo form_close();?>
		</div>
		<div class="col-md-1 visible-lg-block" style='/*width:4.333333333333332%*/'>
			<label class="col-sm-12 control-label" style='padding-left:0px;'><?php echo anchor('manager/logout','Logout',array('class'=>'mrg10T','style'=>'color:#2196f3;display:inline-block;'));?></label>			
			<a href="javascript://" data-placement="bottom" class="sb-toggle-right mrg5T" title="" data-original-title="Statistics Sidebar" style='color:#2196f3;display:inline-block'>
                Terms
            </a>
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

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/input-mask/inputmask.js"></script>

<script type="text/javascript">
    /* Input masks */

    $(function() { "use strict";
        $(".input-mask").inputmask();
    });
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
<link  rel="stylesheet" media="screen" href="<?php echo $Layout->baseUrl?>public/assets/handsontable-master/dist/handsontable.css">
  <link  rel="stylesheet" media="screen" href="<?php echo $Layout->baseUrl?>public/assets/handsontable-master/dist/pikaday/pikaday.css">
  <script  src="<?php echo $Layout->baseUrl?>public/assets/handsontable-master/dist/pikaday/pikaday.js"></script>
  <script  src="<?php echo $Layout->baseUrl?>public/assets/handsontable-master/dist/moment/moment.js"></script>
  <script  src="<?php echo $Layout->baseUrl?>public/assets/handsontable-master/dist/zeroclipboard/ZeroClipboard.js"></script>
  <script  src="<?php echo $Layout->baseUrl?>public/assets/handsontable-master/dist/handsontable.full.js"></script>
  
   <?php 
  $column = $full_project_details['column_heading'];
  $rows = $full_project_details['project_details']->row_count;
  $cols = $full_project_details['project_details']->col_count;
  $projectID = $full_project_details['project_details']->id;
  $projectData = $full_project_details['project_data'];
  $embedData = array();
  $failedData = array();
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
		$columnIds[] = array($project->row,$project->id,$project->col);
		if($project->enter_by=="Free" ||$project->enter_by=="User"){
			$columnData[] = $project->data;
			/*if($project->enter_by=="User" ){
				
			}*/
			$failedData[] = array('data'=>$project->data,"user_id"=>$project->user_id,"pass"=>$project->pass);
		} else if($project->enter_by=="Client"){
			$enter = false;
			foreach($column as $col){
				if(($col->column_num==$project->col) && (int)$col->status==0){
					$enter = true;
				}
			}
			if($enter===true){
				$columnData[] = preg_replace("/'/", "&#39;", $project->data);
			} else {
				$columnData[] = 'Client Property';
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
	  if($heading->column_num==5){
		 $heading->heading  = $heading->heading .' <i></i>';
	  }
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
#transactions > thead > tr > th,#project-list > thead > tr > th{background-color:#fff;}
.panel{border:0px;/*background:#f1f1f1*/}
.control-label{font-weight:normal;text-align:left;}
.form-horizontal .control-label{text-align:left;}
#project-list tr.activetr td, #project-list tr.activetr td a, #transactions tr.activetr td, #transactions tr.activetr td a{ color:#2196f3;}
#project-list tr.activetr:hover,#transactions tr.activetr:hover,#project-list tr.activetr:hover td, #transactions tr.activetr:hover td{
	
	color:#2196f3;
}
#project-list tr.activetr:hover td a, #transactions tr.activetr:hover td a{
	
	color:#2196f3;
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
td.current_active{color:green;}
td.current_active_blue{color:blue;}
.tooltip{opacity:0;visibility:hidden;-webkit-transition:opacity 0.1s linear, visibility 0.1s linear;-moz-transition:opacity 0.1s linear, visibility 0.1s linear;transition:opacity 0.1s linear, visibility 0.1s linear;-webkit-transition-delay:0;-moz-transition-delay:0;transition-delay:0}

#project-list thead th,#transactions thead th{cursor:pointer;}
table thead th{font-weight:bold}
#transactions > thead > tr > th,#project-list > thead > tr > th{background-color:#fff;font-weight:bold}
.tooltip {
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
</style>
<script>
jQuery(document).ready(function(){	
	if(jQuery("#btn_push_records").length>0){
		jQuery("#btn_push_records").click(function(){
			jQuery(this).removeClass('btn-primary').addClass('btn-default').off('click');
			pushRecords();
		});
	}
	jQuery("#btn_send_invitation").click(function(){
		
	});
});
function findUserData(o){
	_tableObj = jQuery("#contacts_table");
	_tableObj.find('table.htCore').find('tbody>tr').find('td').removeClass('current_active');
	_tableObj.find('table.htCore').find('tbody>tr').find('td').removeClass('current_active_blue');
	_l = o.parent().parent().data('li');
	o.parent().parent().parent().find('tr').removeClass('activetr');
	o.parent().parent().addClass('activetr');
	_key = jQuery("input[name='dataentry[key]']").val();
	if(typeof _key!="undefined" && parseInt(_l)){
		data = {l:_l,key:_key};
		call(__baseUrl+'manager/dataentry/find_user_data','POST',data,show_user_data,'json');
	}
}
_userData = [];
window.show_user_data = function(data,textStatus,xhr){
	if(data.length>0){
		_failedDataParse = [];
		_userData = data;
		objHands.render();
		/*_getTD = objHands.getData();
		$.each(data,function(index,row){
			_r = row.row;
			_r = _r-1
			_c = row.col;
			_c = _c-1;
			$.each(_getTD,function(ind,gtd){
				if(gtd[_c]==row.data){
					_td = objHands.getCell(ind,_c);
					console.log("S:"+parseInt(row.pass)+"S"+row.data);
					if(parseInt(row.pass)==0){
						console.log("ENTERPASS");
						jQuery(_td).addClass('current_active_blue');
						_td = objHands.getCell(ind,_c);					
						console.log(_td);
					} else if(parseInt(row.pass)==1) {
						jQuery(_td).addClass('current_active');
					}
					_td = objHands.getCell(ind,_c);					
					console.log(_td);
					return;
				}
			});
		});*/
	}
}
function editProjectDetails(o){
	_p = o.parents('tr');
	project_name = _p.find('td').eq(1).text();
	deadline = _p.find('td').eq(5).text();
	jQuery("#project_name").val(project_name);
	jQuery("#deadline").val(deadline);
	jQuery("#id").val(_p.data('min-delay'));
	jQuery("#project_popup").modal("show");
}
function updateProject(){
	_data = jQuery("#from_project").serializeArray();
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'manager/update_project',
		data:_data,
		success:function(d){
			if(d>0){
				_t = jQuery("#project-list").find("tr[data-min-delay='"+_data[2].value+"']");
				_t.find('td').eq(1).text(_data[0].value);
				_t.find('td').eq(5).text(_data[1].value);
			}			
			jQuery("#from_project")[0].reset();
			jQuery("#project_popup").modal("hide");
		}
	});
}
</script>
<style>
.ui-datepicker{padding:0px 10px;background:#fff;z-index:9999 !important}
</style>
<div class="modal fade" id="project_popup">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Project</h4>
			</div>
			<div class="modal-body">
				<div class="row">
				<div class="col-lg-12">
				<form id="from_project" class="form-horizontal bordered-row">
					<div class="form-group" style='margin-left:0px;margin-right:0px;'>
						<label class="col-sm-3 control-label">Project Name</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="project_name" id="project_name">
						</div>
					</div>
					<div class="form-group" style='margin-left:0px;margin-right:0px;'>
						<label class="col-sm-3 control-label">Deadline</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="deadline" name="deadline" >
						</div>
					</div>
					<input type="hidden" class="form-control" id="id" name="id" >
				</form>
				</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="updateProject()">Save changes</button>
			</div>
		</div>
	</div>
</div>
<div class="panel">
    <div class="panel-body">
		<div id="sb-site"></div>
        <div class="example-box-wrapper">
			<?php echo form_open('manager/dataentry/update_data',array('class'=>'form-horizontal bordered-row','id'=>'frm_data_entry'));?>	
			<?php $ty = 0;?>
			<?php echo $Layout->element('projects_user_table'); ?>
			<div class='col-lg-12 mrg10T'><h5 style='color:#2196f3;display:inline-block'><strong><?php echo $name;?></strong></h5>
			
			<?php if(!empty($id)):?><button type="button" id="btn_push_records" class='btn btn-primary pull-right btn-sm'>Push records to backyard</button><?php endif;?><button type="button" id="btn_send_invitation" class=' btn btn-primary pull-right btn-sm mrg5R' onclick="window.open('<?php echo $Layout->baseUrl?>manager/dataentry/invitation','_blank')">Send invitations</button> <a href="javascript://" onclick="gotoPayment()" class=' btn btn-primary pull-right btn-sm mrg5R'>Payments</a> </div>
			<div class="scroll-container col-lg-12 cp-border">
				<div id='contacts_table' class="hot handsontable htRowHeaders htColumnHeaders" style='width:100%'></div>
			</div>
            <?php echo form_hidden('dataentry[key]',$id);
			 echo form_hidden('dataentry[put]',"dataentry");?>
			<?php echo form_close();?>
			<script>
			__baseUrl = '<?php echo $Layout->baseUrl?>';
			function changeProjectStatus(o){
					_status = o.parents('tr').data('sp');
					_id = o.parents('tr').data('min-delay');
					jQuery.ajax({
						type:'POST',
						url:__baseUrl+'manager/project_status',
						data:{d:_id,s:_status},
						dataType:'json',
						success:function(d){
							if(d.p>0){
								o.html(d.label);
								o.parents('tr').data('sp',d.sp);
							}
						}
					});
				}
			function gotoPayment(){
				_selectedProject="";
				if(jQuery("#project-list").find("tbody").find("tr").hasClass('activetr')){
					_selectedProject = jQuery("#project-list").find("tbody").find("tr.activetr").data('key');
				}
				window.location = __baseUrl+'manager/account/'+_selectedProject;
			}
			
					var topBar = jQuery('.top-bar').height();
					var mainHeader = jQuery('.main-header').height();
					failureContent = [];
					var totalHeight = jQuery(window).height();
					var mainHeight = totalHeight - 180 - topBar;
					jQuery('.scroll-container').css('height',mainHeight+'px');
					var
					cntTable = document.getElementById('contacts_table'),
					maxed = true,
					resizeTimeout,
					availableWidth=jQuery(window).width(),
					availableHeight,
					objHands,minHands,_change = [], colsFreeze=JSON.parse('<?php echo json_encode($colsFreeze)?>');
					data = '<?php echo json_encode($embedData);?>';
					_failedData = '<?php echo json_encode($failedData);?>';
					freecells = JSON.parse('<?php echo json_encode($rowColID)?>');
					_failedDataParse = [];
						try{
							_failedDataParse = JSON.parse(_failedData);
						}catch(e){
							console.log(e);
						}
					_heading = '<?php echo json_encode($columnHeading)?>';
					 Handsontable.renderers.registerRenderer('negativeValueRendererMinor', negativeValueRendererMinor);
					objHands = new Handsontable(cntTable, {
					  data: JSON.parse(data),
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
					  manualColumnResize: true,
					  manualRowResize: true,
					  fillHandle: false,
					  stretchH:"all",
					  contextMenu: false,					  
					  columnSorting: {
						column: 0,
						sortOrder: false
					  },
					  cells: function (row, col, prop) {
						  var cellProperties = {};
						  cellProperties.renderer = "negativeValueRendererMinor";
						  return cellProperties;
					  }
				});
				objHands.addHook('afterSelectionEnd',function(r,c,r2,c2){
					console.log("R:"+r+"C:"+c+"R2:"+r2+"C2:"+c2);
				});
				objHands.addHook('afterChange',function(changes){
					var ele=this;
					$.each(changes,function(index,element){
						if(element[3]!='Client Property'){
							freeRideCell = callFreeRide(element);
							data={enter_data:element,key:jQuery('input[name="dataentry[key]"]').val(),free_ride:freeRideCell};
							call(__baseUrl+'manager/u_singleton','POST',data,showVerifiedChanges,'json');
						}										
					});
				});
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
				function showVerifiedChanges(data,textStatus,xhr){
					console.log(data);
				}
				function negativeValueRendererMinor(instance, td, row, col, prop, value, cellProperties){
					Handsontable.renderers.TextRenderer.apply(this, arguments);
					if(value=='Client Property'){								
						td.innerHTML ='';
						td.style.background = '#EFEFEF';
						td.className = 'no-entry';
						cellProperties.readOnly=true;return cellProperties;
					} else {
						if(_userData.length>0){
							jQuery.each(_userData,function(index,gt){
								if(gt.data==value){
									if(parseInt(gt.pass)==1){
										td.className = 'current_active';
									} else if(parseInt(gt.pass)==0){										
										td.className = 'current_active_blue';
									}
									return;
								}
							});
						}
						
						
						if(_failedDataParse.length>0){
							jQuery.each(_failedDataParse,function(index,fd){
								if(fd.data==value){
									td.setAttribute("title","Account ID: "+fd.user_id);	
									if(parseInt(fd.pass)==0){
										td.className = 'current_active';
									}
									return;
								}
							});
						}
						 var cellProperties = {};
						 cellProperties.readOnly=false;
						 return cellProperties;
					}
					
				}					
				function showMessageSuccess(data,textStatus,xhr){
					jQuery("#btn_push_records").removeClass('btn-default').addClass('btn-primary').on('click',function(){
						jQuery(this).removeClass('btn-primary').addClass('btn-default').off('click');
						alert("Records updated!");
						pushRecords();
					});
					if(parseInt(data)>0){
						$.jGrowl("Record Updated.", {
							  sticky: true,
							  position: 'top-right',
							  theme: 'bg-success'
						  });
					}
				}
					
				window.pushRecords = function(){						
					jQuery('input[name="dataentry[put]"]').val(JSON.stringify(objHands.getData()));
					data = jQuery("#frm_data_entry").serializeArray();
					call(jQuery("#frm_data_entry").attr('action'),'POST',data,showMessageSuccess,'text');
				}
function changeStatus(o){
	s=0
	if(o.is(':checked')){
		s=1;
	}
	u = o.parents('tr').data("li");
	data={l:u,p:s};
	call(__baseUrl+'manager_dataentry/change_status','POST',data,showchangeStatus,'text');
}
window.showchangeStatus=function(data,textStatus,xhr){
	console.log(data);
}
				</script>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
</div>
<span class='tooltip'></span>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/collapse/collapse.js"></script>
  
</body>
</html>






