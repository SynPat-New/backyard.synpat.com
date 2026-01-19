

<!DOCTYPE html>
<html lang ="en">
<head>
    <style>
        /* Loading Spinner */
        .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
    </style>
    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title>Researcher Login </title>
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
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/widgets/slidebars/slidebars.css">
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

<!-- SNIPPETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/chat.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/files-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/login-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/notification-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/progress-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/todo.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/user-profile.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/snippets/mobile-navigation.css">

<!-- APPLICATIONS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/applications/mailbox.css">

<!-- Admin theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/admin/layout.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/admin/color-schemes/default.css">

<!-- Components theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/themes/components/border-radius.css">

<!-- Admin responsive -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/responsive-elements.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public/helpers/admin-responsive.css">

    <!-- JS Core -->

    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-widget.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-mouse.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-ui-position.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/transition.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-core/jquery-cookie.js"></script>





    <script type="text/javascript">
        $(window).load(function(){
            setTimeout(function() {
                $('#loading').fadeOut( 400, "linear" );
            }, 300);
        });
    </script>



</head>
<body>
<div id="loading">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<style type="text/css">

    html,body {
        height: 100%;
        background: #fafafa;
    }

</style>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/parsley/parsley.js"></script>
<div class="center-vertical">
    <div class="center-content">

        <div class="col-md-8 col-lg-6 clearfix center-margin" id="change_password_popup">
			
            <div class="col-md-3"></div>
            <div class="col-md-8">
				<?php echo $this->session->flashdata('message');?>
				<?php echo form_open('outsource/change_password',array('class'=>'form-horizontal bordered-row'))?>
                    <div class="content-box mrg5T">
                        <h3 class="content-box-header content-box-header-alt bg-default">
                            <span class="header-wrapper"> 
                                Change Password
                            </span>
                            <!--<span class="header-buttons">
                                <a href="#" class="btn btn-sm btn-primary" title="">Sign Up</a>
                            </span>-->
                        </h3>
                        <div class="content-box-wrapper">							
                            <div class="form-group">
								<label class="col-sm-3 control-label">New Password:</label>
								<div class="col-sm-6">
									<input type="password" class="input-mask form-control" required name="request[password]" data-parsley-type="alphanum" data-parsley-minlength="6" data-parsley-maxlength="10" id="requestPassword"  placeholder="Password"/>
									<div class="help-block">a combination of minimum six digits and letter</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Confirm Password:</label>
								<div class="col-sm-6">
									<input type="password" class="input-mask form-control" data-parsley-equalto="#requestPassword" data-parsley-type="alphanum" required name="request[password2]" placeholder="Confirm Password" data-parsley-minlength="6" data-parsley-maxlength="10"/>
								</div>
							</div>  
							<div class="form-group">
							<div class="col-sm-3">						
							</div>
							<div class="col-sm-9 mrg5B">
                            <button class="btn btn-success">Update</button>
							</div>
							</div>
                        </div>
                    </div>
					<input type="hidden" name="request[key]" value="<?php echo $key;?>"/>
					<?php echo form_close();?>
            </div>
			<div class="col-md-1"></div>
	   </div>
	   <style>
	   .bordered-row > .form-group{padding:10px 0}
	   </style>

    </div>
</div>
<style>
.form-horizontal > .form-group{
	margin-right:0px;
	margin-left:0px;
}
</style>


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

<!-- Slidebars -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/slidebars/slidebars.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/slidebars/slidebars-demo.js"></script>

<!-- PieGage -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/charts/piegage/piegage.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/charts/piegage/piegage-demo.js"></script>

<!-- Screenfull -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/screenfull/screenfull.js"></script>

<!-- Content box -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/content-box/contentbox.js"></script>

<!-- Overlay -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/overlay/overlay.js"></script>

<!-- Widgets init for demo -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/js-init/widgets-init.js"></script>

<!-- Theme layout -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/themes/admin/layout.js"></script>

<!-- Theme switcher -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/theme-switcher/themeswitcher.js"></script>

</body>
</html>