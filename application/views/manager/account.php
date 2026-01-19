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

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/backgrounds.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/boilerplate.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/border-radius.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/page-transitions.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/spacing.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/utils.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/colors.css">

<!-- ELEMENTS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/badges.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/content-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/dashboard-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/images.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/info-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/invoice.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/loading-indicators.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/menus.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/panel-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/response-messages.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/responsive-tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/ribbon.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/social-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/tile-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/elements/timeline.css">

<!-- FRONTEND ELEMENTS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/frontend-elements/blog.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/frontend-elements/cta-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/frontend-elements/feature-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/frontend-elements/footer.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/frontend-elements/hero-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/frontend-elements/icon-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/frontend-elements/portfolio-navigation.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/frontend-elements/pricing-table.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/frontend-elements/sliders.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/frontend-elements/testimonial-box.css">

<!-- ICONS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/icons/fontawesome/fontawesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/icons/linecons/linecons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/icons/spinnericon/spinnericon.css">

<!-- WIDGETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/accordion-ui/accordion.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/calendar/calendar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/carousel/carousel.css">

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/charts/justgage/justgage.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/charts/morris/morris.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/charts/piegage/piegage.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/charts/xcharts/xcharts.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/slidebars/slidebars.css">




<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/chosen/chosen.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/colorpicker/colorpicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/datatable/datatable.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/datepicker/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/datepicker-ui/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/daterangepicker/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/dialog/dialog.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/dropdown/dropdown.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/dropzone/dropzone.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/file-input/fileinput.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/input-switch/inputswitch.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/input-switch/inputswitch-alt.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/ionrangeslider/ionrangeslider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/jcrop/jcrop.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/jgrowl-notifications/jgrowl.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/loading-bar/loadingbar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/maps/vector-maps/vectormaps.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/markdown/markdown.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/modal/modal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/multi-select/multiselect.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/multi-upload/fileupload.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/nestable/nestable.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/noty-notifications/noty.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/popover/popover.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/pretty-photo/prettyphoto.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/progressbar/progressbar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/range-slider/rangeslider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/slider-ui/slider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/summernote-wysiwyg/summernote-wysiwyg.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/tabs-ui/tabs.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/theme-switcher/themeswitcher.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/timepicker/timepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/tocify/tocify.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/tooltip/tooltip.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/touchspin/touchspin.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/uniform/uniform.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/wizard/wizard.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/xeditable/xeditable.css">

<!-- FRONTEND WIDGETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/layerslider/layerslider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/owlcarousel/owlcarousel.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/fullpage/fullpage.css">

<!-- SNIPPETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/chat.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/files-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/login-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/notification-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/progress-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/todo.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/user-profile.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/mobile-navigation.css">

<!-- Frontend theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/frontend/layout.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/frontend/color-schemes/default.css">

<!-- Components theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/components/border-radius.css">

<!-- Frontend responsive -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/responsive-elements.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/frontend-responsive.css">

    <!-- JS Core -->

    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-widget.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-mouse.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-position.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/transition.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-cookie.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/modal/modal.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/jgrowl-notifications/jgrowl.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/dialog/dialog.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/jquery.tablesorter.min.js"></script>
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
		jQuery("#tbl_activities").tablesorter({ headers: { 0: { sorter: false} },sortList: [[1,0]]});
		
		/*setTimeout(function(){jQuery('.sb-toggle-right').eq(0).trigger('click');},500);*/
	})
</script>
<style>
.light-blue{
	background-color:#E6E6FC !important;
}
.light-blue-1{
	background-color:#D2D2F6 !important;
}
.light-grey{
	background-color:#E8E8E8 !important;
}
#project-list thead th,#transactions thead th,#tbl_activities thead th{cursor:pointer;}
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
			<label class="col-sm-12 control-label" style='padding-left:0px;'><?php echo anchor('outsource/dataentry/logout','Logout',array('class'=>'mrg10T','style'=>'color:#2196f3;display:inline-block;'));?></label>			
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
  if(count($projectData)>0){
	  $n=1;
	  $currentRow = 0;
	  $columnData = array();
	 foreach($projectData as $project){
		if($currentRow>0 && $currentRow!=$project->row){
			$embedData[] = $columnData;
			$columnData = array();
		}
		$currentRow = $project->row;
		if($project->enter_by=="Free" ||$project->enter_by=="User"){
			$columnData[] = $project->data;
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
.handsontable th{border-top:0px solid #CCC !important;background:#fff;}
.handsontable th, .handsontable td{padding:5px;}
.handsontable thead th .relative{text-align:left;padding:5px;}
.handsontable th, .handsontable td{height:auto;line-height:normal;}
td.current_active{color:green;}
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

</script>
<div class="panel">
    <div class="panel-body">
		<div id="sb-site"></div>
        <div class="example-box-wrapper">
			<?php echo form_open('manager/dataentry/update_data',array('class'=>'form-horizontal bordered-row','id'=>'frm_data_entry'));?>	
			<?php $ty = 1;?>
			<?php echo $Layout->element('projects_user_table'); ?>
			<div class="row">
				<div class='col-lg-12 mrg10T'><h5 style='color:#2196f3;display:inline-block' id="selected_project"><strong><?php echo $name;?></strong></h5>
					<button type="button" onclick="payoutPayment()" class="btn btn-primary pull-right mrg5B">Pay now</button>
					<button type="button" onclick="getAllProjectsPayout()" class="btn btn-primary pull-right mrg5B mrg5R">All Projects</button>
					<a href="javascript://" onclick="gotoRecords()"  class="btn btn-primary pull-right mrg5B mrg5R">Records</a>
				</div>
			</div>			
			<div class="col-lg-12" style="overflow:auto">
					<?php 
						$emailPrice = 0;
						$telephonePrice = 0;
						$phonePrice = 0;
						$linkedinPrice = 0;
						if(count($my_projects)>0){
							foreach($my_projects[0]->column_heading as $heading){
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
						/*echo "<pre>";
						print_r($find_entry_for_users);
						die;*/
					?>
					<table class="table  pricing-table-show" id='tbl_activities'>
						<thead>
							<tr>
								<th width="10px" data-sorter="false" class="sorter-false"><input type="checkbox" ONCLICK="checkAllC(jQuery(this))"/></th>
								<th width="110px">Name</th>
								<th width="90px" class='text-center text-cell-email border-right-remove light-grey' data-price="<?php echo $emailPrice;?>">Email</th>
								<th width="90px" class='text-center text-cell-email border-right-remove light-grey' data-price="<?php echo $emailPrice;?>">Price</th>
								<th width="90px" class='text-center text-cell-email border-right-remove light-grey' data-price="<?php echo $emailPrice;?>">Total</th>
								<th width="100px" class='text-center text-cell-telephone' data-price="<?php echo $telephonePrice;?>">Cellphone</th>
								<th width="90px" class='text-center text-cell-telephone' data-price="<?php echo $telephonePrice;?>">Price</th>
								<th width="90px" class='text-center text-cell-telephone' data-price="<?php echo $telephonePrice;?>">Total</th>
								<th width="100px" class='text-center text-cell-phone light-grey' data-price="<?php echo $phonePrice;?>">Telephone</th>
								<th width="90px" class='text-center text-cell-phone light-grey' data-price="<?php echo $phonePrice;?>">Price</th>
								<th width="90px" class='text-center text-cell-phone light-grey' data-price="<?php echo $phonePrice;?>">Total</th>
								<th width="100px" class='text-center text-cell-linkedin' data-price="<?php echo $linkedinPrice;?>">LinkedIn</th>
								<th width="100px" class='text-center text-cell-linkedin' data-price="<?php echo $linkedinPrice;?>">Price</th>
								<th width="100px" class='text-center text-cell-linkedin' data-price="<?php echo $linkedinPrice;?>">Total</th>
								<th width="200px" class='text-center light-blue-1'>To pay</th>
								<th width="150px" class='text-center light-blue'>Paid</th>
								<th width="100px" class='text-center light-blue'>Bal</th>
								<th width="50px" class='text-center light-blue'>Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php 								
								$currentEmail = 0;
								$currentLinkedIN= 0;
								$currentPhone = 0;
								$telePhone = 0;
								$totalEmail = 0;
								$totalPhone = 0;
								$totalTelephone = 0;
								$totalLinkedIn=0;
								$grandTotal = 0;
								$totalPaidOff = 0;
								foreach($find_entry_for_users as $userEntry){
									$name = $userEntry['name'];
									$allActivities = $userEntry['activities'];
									$find_my_current_month_entry = $allActivities['current_project'];									
									if(count($find_my_current_month_entry)>0){
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
									}
									$emailCal = $currentEmail*$emailPrice;
									$totalEmail = $totalEmail + $currentEmail;
									$telephoneCal = $currentPhone*$telephonePrice;
									$totalPhone = $totalPhone + $currentPhone;
									$phoneCal = $telePhone*$phonePrice;
									$totalTelephone = $totalTelephone + $telePhone;
									$linkedinCal = $currentLinkedIN*$linkedinPrice;
									$totalLinkedIn = $totalLinkedIn + $currentLinkedIN;
									$total = $emailCal + $telephoneCal + $linkedinCal;	
									$paidTillNow = $userEntry['last_payment'];
									if($paidTillNow==null || $paidTillNow==''){
										$paidTillNow = 0;
									}
									$totalPaidOff = $totalPaidOff + $paidTillNow;
									$balance = $total - $paidTillNow;
									
									if($balance>0):
							?>
							<tr>
								<td><input name="payment_user[]" data-paypal="<?php echo $userEntry['paypal_email']?>" type="checkbox" value="<?php echo $userEntry['id']?>"/></td>
								<td><?php echo $name;?></td>
								<td class='text-center text-cell-con-email light-grey' data-price='<?php echo $emailPrice?>'><?php echo $currentEmail;?></td>
								<td class='text-center text-cell-sh-email light-grey'><?php echo $emailPrice;?></td>
								<td class='text-center text-cell-sh-email light-grey'><?php echo $emailCal;?></td>
								<td class='text-center text-cell-con-phone' data-price='<?php echo $telephonePrice?>'><?php echo $currentPhone;?></td>
								<td class='text-center text-cell-sh-phone'><?php echo $telephonePrice;?></td>
								<td class='text-center text-cell-sh-phone'><?php echo $telephoneCal;?></td>
								<td class='text-center text-cell-con-phone light-grey' data-price='<?php echo $phonePrice?>'><?php echo $telePhone;?></td>
								<td class='text-center text-cell-sh-phone light-grey'><?php echo $phonePrice;?></td>
								<td class='text-center text-cell-sh-phone light-grey'><?php echo $phoneCal;?></td>
								<td class='text-center text-cell-con-linkedin' data-price='<?php echo $linkedinPrice?>'><?php echo $currentLinkedIN;?></td>
								<td class='text-center text-cell-sh-linkedin'><?php echo $linkedinPrice;?></td>
								<td class='text-center text-cell-sh-linkedin'><?php echo $linkedinCal;?></td>
								<td class='text-center light-blue-1'><?php echo number_format($total,1,'.','') ?></td>
								<td class='text-center light-blue'><?php echo number_format($paidTillNow,1,'.','') ?></td>
								<td class=' text-center light-blue'><?php echo number_format($balance,1,'.','') ?></td>
								<td class=' text-center light-blue'><input type="text" name="amount[]" style="width:50px" value="<?php echo number_format($balance,1,'.','') ?>" /></td>
							</tr>
							<?php endif; } ?>
						</tbody>
						<tfoot>
							<?php 
								$totalEmailCal = $totalEmail * $emailPrice;
								$totalPhoneCal = $totalPhone * $telephonePrice;
								$totalTelephoneCal = $totalTelephone * $phonePrice;
								$totalLinkedInCal = $totalLinkedIn * $phonePrice;
								$grandTotal = $totalEmailCal + $totalPhoneCal + $totalTelephoneCal + $totalLinkedInCal;
								$remainBal = $grandTotal - $totalPaidOff;
								if($remainBal>0){
							?>
								<tr>
								<td></td>
								<td>All</td>
								<td class='text-center text-cell-con-email light-grey'><?php echo $totalEmail;?></td>
								<td class='text-center text-cell-sh-email light-grey'><?php echo $emailPrice;?></td>
								<td class='text-center text-cell-sh-email light-grey'><?php echo number_format($totalEmailCal,1,'.','');?></td>
								<td class='text-center text-cell-con-phone'><?php echo $totalPhone;?></td>
								<td class='text-center text-cell-sh-phone'><?php echo $telephonePrice;?></td>
								<td class='text-center text-cell-sh-phone'><?php echo number_format($totalPhoneCal,1,'.','');?></td>
								<td class='text-center text-cell-con-phone light-grey'><?php echo $totalTelephone;?></td>
								<td class='text-center text-cell-sh-phone light-grey'><?php echo $phonePrice;?></td>
								<td class='text-center text-cell-sh-phone light-grey'><?php echo number_format($totalTelephoneCal,1,'.','');?></td>
								<td class='text-center text-cell-con-linkedin'><?php echo $totalLinkedIn;?></td>
								<td class='text-center text-cell-sh-linkedin'><?php echo $linkedinPrice;?></td>
								<td class='text-center text-cell-sh-linkedin'><?php echo number_format($totalLinkedInCal,1,'.','');?></td>
								<td class='text-center light-blue-1'><?php echo number_format($grandTotal,1,'.','') ?></td>
								<td class='text-center light-blue'><?php echo number_format($totalPaidOff,1,'.','') ?></td>
								<td class=' text-center light-blue'><?php echo number_format($remainBal,1,'.','') ?></td>
								<td class=' text-center light-blue'><?php echo number_format($remainBal,1,'.','') ?></td>
							</tr>
							<?php
								}
							?>
						</tfoot>
					</table>
				
			</div>
            <?php echo form_hidden('dataentry[key]',$id);
			 echo form_hidden('dataentry[put]',"dataentry");?>
			<?php echo form_close();?>
			<script>
				__baseUrl = '<?php echo $Layout->baseUrl?>';
				_nextFriday='<?php echo date('M d, y',strtotime( "next friday"));?>';
				
				function checkAllC(o){
					_oCheck = jQuery("#tbl_activities").find("tbody").find("input[type='checkbox']");
					if(o.is(":checked")){
						_oCheck.each(function(){
							jQuery(this).prop("checked",true);
						})
					} else {
						_oCheck.each(function(){
							jQuery(this).prop("checked",false);
						})
					}
				}
				
				function gotoRecords(){
					_selectedProject="";
					if(jQuery("#project-list").find("tbody").find("tr").hasClass('activetr')){
						_selectedProject = jQuery("#project-list").find("tbody").find("tr.activetr").data('key');
					}
					window.location = __baseUrl+'manager/start/'+_selectedProject;
				}
				function getProjectActivitesDetails(o){
					_sd = o.data('sd');
					_ud = 0;
					jQuery("#project-list").find("tbody").find("tr").removeClass('activetr');
					jQuery("#transactions").find("tbody").find("tr").removeClass('activetr');		
					o.parents('tr').addClass('activetr');
					jQuery("#selected_project").find("strong").html(o.text());
					retrieveData(_sd,_ud);
				}	
				function findUserData(o){
					_ud = o.parents('tr').data("li");
					jQuery("#transactions").find("tbody").find("tr").removeClass('activetr');
					o.parents('tr').addClass('activetr');
					_sd = 0;
					/*if(jQuery("#project-list").find("tbody").find("tr.activetr").length>0){
						_sd = jQuery("#project-list").find("tbody").find("tr.activetr").attr("data-min-delay");
					}
					if(_sd>0){
						retrieveData(_sd,_ud);
					}*/
					jQuery("#project-list").find("tbody").find("tr").removeClass('activetr');
					jQuery("#selected_project").find("strong").html('');
					retrieveData(_sd,_ud);
				}
				function retrieveData(sd,ud){
					jQuery.ajax({
						type:'POST',
						url:__baseUrl+"manager/account",
						data:{s:sd,u:ud},
						dataType:'json',
						cache:false,
						success:function(d){
							_html='<tr><td colspan="18">No record found!</td></tr>';
							_htmlFoot='';
							if(d.length>0){
								_html="";
								_activeProject = jQuery("#project-list").find("tbody").find("tr.activetr");
								_totalEmailCount = 0;
								_totalEmailPrice = 0;
								_totalEmailCal = 0;
								_totalTelepnoneCount = 0;
								_totalTelepnonePrice = 0;
								_totalTelepnoneCal = 0;
								_totalPhoneCount = 0;
								_totalPhonePrice = 0;
								_totalPhoneCal = 0;
								_totalLinkedinCount = 0;
								_totalLinkedinPrice = 0;
								_totalLinkedinCal = 0;
								_totalPaid = 0;
								_totalBal = 0;
								for(i=0;i<d.length;i++){
									_name = d[i].name;
									_allActivities = d[i].activities;
									_find_my_current_month_entry = _allActivities.current_project;	
									_currentEmail = 0;
									_currentEmailPrice = 0;
									_currentEmailCal = 0;
									_currentTelephone = 0;
									_currentTelephonePrice = 0;
									_currentTelephoneCal = 0;
									_currentPhone = 0;
									_currentPhonePrice = 0;
									_currentPhoneCal = 0;
									_currentLinkedIN = 0;
									_currentLinkedINPrice = 0;
									_currentLinkedINCal = 0;
									_total = 0;
									projectID = d[i].project_id;
									if(_find_my_current_month_entry.length>0){										
										for(j=0;j<_find_my_current_month_entry.length;j++){											
											switch(parseInt(_find_my_current_month_entry[j].col)){
												case 5:
													_currentEmail = parseInt(_find_my_current_month_entry[j].count);
													_currentEmailPrice = parseFloat(_find_my_current_month_entry[j].price);
													if(_currentEmailPrice==null){
														_currentEmailPrice = _activeProject.data('email');
													}
													_currentEmailCal = _currentEmail * _currentEmailPrice;
													_totalEmailCal = _totalEmailCal + _currentEmailCal;
													_currentEmailCal = _currentEmailCal.toFixed(1);
													_totalEmailCount = _totalEmailCount + _currentEmail;
													_totalEmailPrice = _totalEmailPrice + _currentEmailPrice;
												break;
												case 6:
													_currentTelephone = parseInt(_find_my_current_month_entry[j].count);
													_currentTelephonePrice	= parseFloat(_find_my_current_month_entry[j].price);
													if(_currentTelephonePrice==null){
														_currentTelephonePrice = _activeProject.data('telephone');
													}
													_currentTelephoneCal = _currentTelephone * _currentTelephonePrice;
													_totalTelepnoneCal = _totalTelepnoneCal + _currentTelephoneCal;
													_currentTelephoneCal = _currentTelephoneCal.toFixed(1);
													_totalTelepnoneCount = _totalTelepnoneCount + _currentTelephone;
													_totalTelepnonePrice = parseFloat(_totalTelepnonePrice) + parseFloat(_currentTelephonePrice);
													
												break;
												case 7:
													_currentPhone = parseInt(_find_my_current_month_entry[j].count);
													_currentPhonePrice = parseFloat(_find_my_current_month_entry[j].price);
													if(_currentPhonePrice==null){
														_currentPhonePrice = _activeProject.data('phone');
													}
													_currentPhoneCal = _currentPhone * _currentPhonePrice;
													_totalPhoneCal = _totalPhoneCal + _currentPhoneCal;
													_currentPhoneCal = _currentPhoneCal.toFixed(1);
													_totalPhoneCount = _totalPhoneCount + _currentPhone;
													_totalPhonePrice = parseFloat(_totalPhonePrice) + parseFloat(_currentPhonePrice);
												break;
												case 8:											
													_currentLinkedIN = parseInt(_find_my_current_month_entry[j].count);
													_currentLinkedINPrice = parseFloat(_find_my_current_month_entry[j].price);
													if(_currentLinkedINPrice==null){
														_currentLinkedINPrice = _activeProject.data('linkedin');
													}
													_currentLinkedINCal = _currentLinkedIN * _currentLinkedINPrice;
													_totalLinkedinCal = _totalLinkedinCal + _currentLinkedINCal;
													_currentLinkedINCal = _currentLinkedINCal.toFixed(1);
													_totalLinkedinCount = _currentLinkedIN + _totalLinkedinCount;
													_totalLinkedinPrice = _totalLinkedinPrice + _currentLinkedINPrice;
												break;
											}
										}										
									}
									_total = parseFloat(_currentEmailCal) + parseFloat(_currentTelephoneCal) + parseFloat(_currentPhoneCal) + parseFloat(_currentLinkedINCal);									
									paidTillNow = d[i].last_payment;
									if(paidTillNow==null){
										paidTillNow = 0;
									}
									_totalPaid = parseFloat(paidTillNow) + parseFloat(_totalPaid);									
									_balance = _total - paidTillNow;
									_totalBal = _totalBal + _balance;
									_total = _total.toFixed(1);
									if(_balance>0){
										_balance = _balance.toFixed(1);
										_html += '<tr><td><input name="payment_user[]" data-project="'+projectID+'" data-paypal="'+d[i].paypal_email+'" type="checkbox" value="'+d[i].id+'"/></td><td>'+_name+'</td><td class="text-center text-cell-con-email light-grey">'+_currentEmail+'</td><td class="text-center text-cell-sh-email light-grey">'+_currentEmailPrice+'</td><td class="text-center text-cell-sh-email light-grey">'+_currentEmailCal+'</td><td class="text-center text-cell-con-phone">'+_currentTelephone+'</td><td class="text-center text-cell-sh-phone">'+_currentTelephonePrice+'</td><td class="text-center text-cell-sh-phone">'+_currentTelephoneCal+'</td><td class="text-center text-cell-con-phone light-grey">'+_currentPhone+'</td><td class="text-center text-cell-sh-phone light-grey">'+_currentPhonePrice+'</td><td class="text-center text-cell-sh-phone light-grey">'+_currentPhoneCal+'</td><td class="text-center text-cell-con-linkedin">'+_currentLinkedIN+'</td><td class="text-center text-cell-sh-linkedin">'+_currentLinkedINPrice+'</td><td class="text-center text-cell-sh-linkedin">'+_currentLinkedINCal+'</td><td class="text-center light-blue-1">'+_total+'</td><td class="text-center light-blue">'+paidTillNow+'</td><td class="text-center light-blue">'+_balance+'</td><td class="text-center light-blue"><input type="text" name="amount[]" style="width:50px" value="'+_balance+'" /></td></tr>';
									}									
								}
								if(_totalBal>0){
									_totalAll = parseFloat(_totalEmailCal) + parseFloat(_totalTelepnoneCal) + parseFloat(_totalPhoneCal) + parseFloat(_totalLinkedinCal);
									_totalAll = parseFloat(_totalAll);
									_totalAll = _totalAll.toFixed(1);
									_htmlFoot += '<tr><td></td><td>All</td><td class="text-center text-cell-con-email light-grey">'+_totalEmailCount+'</td><td class="text-center text-cell-sh-email light-grey">'+_totalEmailPrice+'</td><td class="text-center text-cell-sh-email light-grey">'+_totalEmailCal.toFixed(1)+'</td><td class="text-center text-cell-con-phone">'+_totalTelepnoneCount+'</td><td class="text-center text-cell-sh-phone">'+_totalTelepnonePrice+'</td><td class="text-center text-cell-sh-phone">'+_totalTelepnoneCal.toFixed(1)+'</td><td class="text-center text-cell-con-phone light-grey">'+_totalPhoneCount+'</td><td class="text-center text-cell-sh-phone light-grey">'+_totalPhonePrice+'</td><td class="text-center text-cell-sh-phone light-grey">'+_totalPhoneCal.toFixed(1)+'</td><td class="text-center text-cell-con-linkedin">'+_totalLinkedinCount+'</td><td class="text-center text-cell-sh-linkedin">'+_totalLinkedinPrice+'</td><td class="text-center text-cell-sh-linkedin">'+_totalLinkedinCal.toFixed(1)+'</td><td class="text-center light-blue-1">'+_totalAll+'</td><td class="text-center light-blue">'+_totalPaid+'</td><td class="text-center light-blue">'+_totalBal.toFixed(1)+'</td><td class="text-center light-blue">'+_totalBal.toFixed(1)+'</td></tr>';
								}
							}
							jQuery("#tbl_activities").find("tbody").html(_html);
							jQuery("#tbl_activities").find("tfoot").html(_htmlFoot);
						}
					});
				}
				function payoutPayment(){
					if(jQuery("#tbl_activities").find('input[name="payment_user[]"]:checked').length>0){
						console.log("Aa");
						_error = 0;
						_items = [];
						
						jQuery("#tbl_activities").find('input[name="payment_user[]"]:checked').each(function(index){
							if(jQuery(this).data('paypal')!="" && jQuery(this).data('paypal')!=null){
								_pEmailID = jQuery(this).data('paypal');
								_projectID = jQuery(this).data('project');
								_id = jQuery(this).val();
								_amount = jQuery('input[name="amount[]"]').eq(index).val();
								if(_amount!="" && parseFloat(_amount)>0){
									item={};
									item.id = _id;
									item.amount = _amount;
									item.email = _pEmailID;
									item.project_id = _projectID;
									_items.push(item);
								} else {
									_error = 1;
								}								
							} else {
								_error = 1;
							}
						});
						
						if(_error==1){
							if(_items.length>0){
								res = confirm("Some of users don't have paypal email address, do you wish to continue. If yes system will automatically skip those users.");
								if(res){
									payNow(_items);
								}
							} else {
								alert("Selected user dont have paypal id or amount field is blank.");
							}
						} else {
							if(_items.length>0){
								payNow(_items);
							} else {
								alert("Selected user dont have paypal id or amount field is blank.");
							}
						}
					} else {
						alert("Please select users checkbox for payment");
					}
				}
				function payNow(items){
					jQuery.ajax({
						type:'POST',
						url:__baseUrl+'manager/mass_payment',
						data:{item:JSON.stringify(items)},
						success:function(d){
							alert(d);
						}
					});
				}
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
				function getAllProjectsPayout(){
					jQuery("#project-list").find("tbody").find("tr").removeClass('activetr');
					jQuery("#transactions").find("tbody").find("tr").removeClass('activetr');
					jQuery.ajax({
						url:__baseUrl+"manager/account_all",
						dataType:'json',
						cache:false,
						success:function(d){
							_html='<tr><td colspan="18">No record found!</td></tr>';
							_htmlFoot='';
							if(d.length>0){
								_html='';
								_totalEmailCount = 0;
								_totalEmailPrice = 0;
								_totalEmailCal = 0;
								_totalTelepnoneCount = 0;
								_totalTelepnonePrice = 0;
								_totalTelepnoneCal = 0;
								_totalPhoneCount = 0;
								_totalPhonePrice = 0;
								_totalPhoneCal = 0;
								_totalLinkedinCount = 0;
								_totalLinkedinPrice = 0;
								_totalLinkedinCal = 0;
								_totalPaid = 0;
								_totalBal = 0;
								for(i=0;i<d.length;i++){
									_html +='<tr><td colspan="18"><p class="alert alert-info" style="margin:0">'+d[i].project_name+'</p></td></tr>';
									_usersList = d[i].list;
									if(_usersList.length>0){										
										for(s=0;s<_usersList.length;s++){
											_userID = _usersList[s].id;
											_name = _usersList[s].name;
											_pEmail = _usersList[s].paypal_email;
											_lastPayment = _usersList[s].last_payment;
											if(_lastPayment==null){
												_lastPayment = 0;
											}
											_activites  = _usersList[s].activities;
											_currentEmail = 0;
											_currentEmailPrice = 0;
											_currentEmailCal = 0;
											_currentTelephone = 0;
											_currentTelephonePrice = 0;
											_currentTelephoneCal = 0;
											_currentPhone = 0;
											_currentPhonePrice = 0;
											_currentPhoneCal = 0;
											_currentLinkedIN = 0;
											_currentLinkedINPrice = 0;
											_currentLinkedINCal = 0;
											_total = 0;
											if(_activites.current_project.length>0){
												_find_my_current_month_entry = _activites.current_project;
												for(j=0;j<_find_my_current_month_entry.length;j++){
													switch(parseInt(_find_my_current_month_entry[j].col)){
														case 5:
															_currentEmail = parseInt(_find_my_current_month_entry[j].count);
															_currentEmailPrice = parseFloat(_find_my_current_month_entry[j].price);
															if(_currentEmailPrice==null){
																_currentEmailPrice = _activeProject.data('email');
															}
															_currentEmailCal = _currentEmail * _currentEmailPrice;
															_totalEmailCal = _totalEmailCal + _currentEmailCal;
															_currentEmailCal = _currentEmailCal.toFixed(1);
															_totalEmailCount = _totalEmailCount + _currentEmail;
															_totalEmailPrice = parseFloat(_totalEmailPrice) + parseFloat(_currentEmailPrice);
														break;
														case 6:
															_currentTelephone = parseInt(_find_my_current_month_entry[j].count);
															_currentTelephonePrice	= parseFloat(_find_my_current_month_entry[j].price);
															if(_currentTelephonePrice==null){
																_currentTelephonePrice = _activeProject.data('telephone');
															}
															_currentTelephoneCal = _currentTelephone * _currentTelephonePrice;
															_totalTelepnoneCal = _totalTelepnoneCal + _currentTelephoneCal;
															_currentTelephoneCal = _currentTelephoneCal.toFixed(1);
															_totalTelepnoneCount = _totalTelepnoneCount + _currentTelephone;
															_totalTelepnonePrice = parseFloat(_totalTelepnonePrice) + parseFloat(_currentTelephonePrice);
															console.log(_totalTelepnonePrice);
														break;
														case 7:
															_currentPhone = parseInt(_find_my_current_month_entry[j].count);
															_currentPhonePrice = parseFloat(_find_my_current_month_entry[j].price);
															if(_currentPhonePrice==null){
																_currentPhonePrice = _activeProject.data('phone');
															}
															_currentPhoneCal = _currentPhone * _currentPhonePrice;
															_totalPhoneCal = _totalPhoneCal + _currentPhoneCal;
															_currentPhoneCal = _currentPhoneCal.toFixed(1);
															_totalPhoneCount = _totalPhoneCount + _currentPhone;
															_totalPhonePrice = parseFloat(_totalPhonePrice) + parseFloat(_currentPhonePrice);
														break;
														case 8:											
															_currentLinkedIN = parseInt(_find_my_current_month_entry[j].count);
															_currentLinkedINPrice = parseFloat(_find_my_current_month_entry[j].price);
															if(_currentLinkedINPrice==null){
																_currentLinkedINPrice = _activeProject.data('linkedin');
															}
															_currentLinkedINCal = _currentLinkedIN * _currentLinkedINPrice;
															_totalLinkedinCal = _totalLinkedinCal + _currentLinkedINCal;
															_currentLinkedINCal = _currentLinkedINCal.toFixed(1);
															_totalLinkedinCount = _currentLinkedIN + _totalLinkedinCount;
															_totalLinkedinPrice = parseFloat(_totalLinkedinPrice) + parseFloat(_currentLinkedINPrice);
														break;
													}
												}
											}
											_total = parseFloat(_currentEmailCal) + parseFloat(_currentTelephoneCal) + parseFloat(_currentPhoneCal) + parseFloat(_currentLinkedINCal);									
											paidTillNow = d[i].last_payment;
											if(paidTillNow==null){
												paidTillNow = 0;
											}
											_totalPaid = parseFloat(paidTillNow) + parseFloat(_totalPaid);									
											_balance = _total - paidTillNow;
											_totalBal = _totalBal + _balance;
											_total = _total.toFixed(1);
											if(_balance>0){
												_balance = _balance.toFixed(1);
												_html += '<tr><td><input name="payment_user[]" data-project="'+d[i].project_id+'" data-paypal="'+_pEmail+'" type="checkbox" value="'+_userID+'"/></td><td>'+_name+'</td><td class="text-center text-cell-con-email light-grey">'+_currentEmail+'</td><td class="text-center text-cell-sh-email light-grey">'+_currentEmailPrice+'</td><td class="text-center text-cell-sh-email light-grey">'+_currentEmailCal+'</td><td class="text-center text-cell-con-phone">'+_currentTelephone+'</td><td class="text-center text-cell-sh-phone">'+_currentTelephonePrice+'</td><td class="text-center text-cell-sh-phone">'+_currentTelephoneCal+'</td><td class="text-center text-cell-con-phone light-grey">'+_currentPhone+'</td><td class="text-center text-cell-sh-phone light-grey">'+_currentPhonePrice+'</td><td class="text-center text-cell-sh-phone light-grey">'+_currentPhoneCal+'</td><td class="text-center text-cell-con-linkedin">'+_currentLinkedIN+'</td><td class="text-center text-cell-sh-linkedin">'+_currentLinkedINPrice+'</td><td class="text-center text-cell-sh-linkedin">'+_currentLinkedINCal+'</td><td class="text-center light-blue-1">'+_total+'</td><td class="text-center light-blue">'+paidTillNow+'</td><td class="text-center light-blue">'+_balance+'</td><td class="text-center light-blue"><input type="text" name="amount[]" style="width:50px" value="'+_balance+'" /></td></tr>';
											}
										}
									}
								}
								if(_totalBal>0){
									_totalAll = parseFloat(_totalEmailCal) + parseFloat(_totalTelepnoneCal) + parseFloat(_totalPhoneCal) + parseFloat(_totalLinkedinCal);
									_totalAll = parseFloat(_totalAll);
									_totalAll = _totalAll.toFixed(1);
									_totalEmailPrice = _totalEmailCal / _totalEmailCount;
									_totalEmailPrice =parseFloat(_totalEmailPrice);
									if(isNaN(_totalEmailPrice)){
										_totalEmailPrice = 0.0;
									}
									_totalTelepnonePrice = _totalTelepnoneCal / _totalTelepnoneCount;
									_totalTelepnonePrice = parseFloat(_totalTelepnonePrice);
									if(isNaN(_totalTelepnonePrice)){
										_totalTelepnonePrice = 0.0;
									}
									_totalPhonePrice = _totalPhoneCal / _totalPhoneCount;
									_totalPhonePrice =parseFloat(_totalPhonePrice);
									if(isNaN(_totalPhonePrice)){
										_totalPhonePrice = 0.0;
									}
									_totalLinkedinPrice = _totalLinkedinCal / _totalLinkedinCount;
									_totalLinkedinPrice =parseFloat(_totalLinkedinPrice);
									if(isNaN(_totalLinkedinPrice)){
										_totalLinkedinPrice = 0.0;
									}
									_htmlFoot += '<tr><td></td><td>All</td><td class="text-center text-cell-con-email light-grey">'+_totalEmailCount+'</td><td class="text-center text-cell-sh-email light-grey">'+_totalEmailPrice.toFixed(1)+'</td><td class="text-center text-cell-sh-email light-grey">'+_totalEmailCal.toFixed(1)+'</td><td class="text-center text-cell-con-phone">'+_totalTelepnoneCount+'</td><td class="text-center text-cell-sh-phone">'+_totalTelepnonePrice.toFixed(1)+'</td><td class="text-center text-cell-sh-phone">'+_totalTelepnoneCal.toFixed(1)+'</td><td class="text-center text-cell-con-phone light-grey">'+_totalPhoneCount+'</td><td class="text-center text-cell-sh-phone light-grey">'+_totalPhonePrice.toFixed(1)+'</td><td class="text-center text-cell-sh-phone light-grey">'+_totalPhoneCal.toFixed(1)+'</td><td class="text-center text-cell-con-linkedin">'+_totalLinkedinCount+'</td><td class="text-center text-cell-sh-linkedin">'+_totalLinkedinPrice.toFixed(1)+'</td><td class="text-center text-cell-sh-linkedin">'+_totalLinkedinCal.toFixed(1)+'</td><td class="text-center light-blue-1">'+_totalAll+'</td><td class="text-center light-blue">'+_totalPaid+'</td><td class="text-center light-blue">'+_totalBal.toFixed(1)+'</td><td class="text-center light-blue">'+_totalBal.toFixed(1)+'</td></tr>';
								}
							}
							jQuery("#tbl_activities").find("tbody").html(_html);
							jQuery("#tbl_activities").find("tfoot").html(_htmlFoot);
						}
					});
				}
			</script>
        </div>
    </div>
</div>
        </div>
    </div>
</div>
</div>


    <!-- FRONTEND ELEMENTS -->

<!-- Skrollr -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/skrollr/skrollr.js"></script>

<!-- Owl carousel -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/owlcarousel/owlcarousel.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/owlcarousel/owlcarousel-demo.js"></script>

<!-- HG sticky -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/sticky/sticky.js"></script>

<!-- WOW -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/wow/wow.js"></script>

<!-- VideoBG -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/videobg/videobg.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/videobg/videobg-demo.js"></script>

<!-- Mixitup -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/mixitup/mixitup.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/mixitup/isotope.js"></script>

<!-- WIDGETS -->

<!-- Bootstrap Dropdown -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/dropdown/dropdown.js"></script>

<!-- Bootstrap Tooltip -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/tooltip/tooltip.js"></script>

<!-- Bootstrap Popover -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/popover/popover.js"></script>

<!-- Bootstrap Progress Bar -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/progressbar/progressbar.js"></script>

<!-- Bootstrap Buttons -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/button/button.js"></script>

<!-- Bootstrap Collapse -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/collapse/collapse.js"></script>

<!-- Superclick -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/superclick/superclick.js"></script>

<!-- Input switch alternate -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/input-switch/inputswitch-alt.js"></script>

<!-- Slim scroll -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/slimscroll/slimscroll.js"></script>

<!-- Content box -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/content-box/contentbox.js"></script>

<!-- Overlay -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/overlay/overlay.js"></script>

<!-- Widgets init for demo -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-init/widgets-init.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-init/frontend-init.js"></script>

<!-- Theme layout -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/themes/frontend/layout.js"></script>

<!-- Theme switcher -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/theme-switcher/themeswitcher.js"></script>

</body>
</html>






