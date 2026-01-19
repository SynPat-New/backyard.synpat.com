<!DOCTYPE html>
<html lang ="en">
<head>

    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title> Tables </title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Favicons -->

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $Layout->baseUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $Layout->baseUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $Layout->baseUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="<?php echo $Layout->baseUrl?>public/images/icons/favicon.ico">
<link rel="shortcut icon" href="<?php echo $Layout->baseUrl?>public/images/icons/favicon.ico">



    <!-- HELPERS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/backgrounds.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/boilerplate.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/border-radius.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/page-transitions.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/spacing.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/utils.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/colors.css">

<!-- ELEMENTS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/badges.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/content-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/dashboard-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/images.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/info-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/invoice.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/loading-indicators.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/menus.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/panel-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/response-messages.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/responsive-tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/ribbon.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/social-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/tile-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//elements/timeline.css">

<!-- FRONTEND ELEMENTS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//frontend-elements/blog.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//frontend-elements/cta-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//frontend-elements/feature-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//frontend-elements/footer.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//frontend-elements/hero-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//frontend-elements/icon-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//frontend-elements/portfolio-navigation.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//frontend-elements/pricing-table.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//frontend-elements/sliders.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//frontend-elements/testimonial-box.css">

<!-- ICONS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//icons/fontawesome/fontawesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//icons/linecons/linecons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//icons/spinnericon/spinnericon.css">

<!-- WIDGETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/accordion-ui/accordion.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/calendar/calendar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/carousel/carousel.css">

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/charts/justgage/justgage.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/charts/morris/morris.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/charts/piegage/piegage.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/charts/xcharts/xcharts.css">

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/chosen/chosen.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/colorpicker/colorpicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/datatable/datatable.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/datepicker/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/datepicker-ui/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/daterangepicker/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/dialog/dialog.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/dropdown/dropdown.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/dropzone/dropzone.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/file-input/fileinput.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/input-switch/inputswitch.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/input-switch/inputswitch-alt.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/ionrangeslider/ionrangeslider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/jcrop/jcrop.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/jgrowl-notifications/jgrowl.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/loading-bar/loadingbar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/maps/vector-maps/vectormaps.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/markdown/markdown.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/modal/modal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/multi-select/multiselect.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/multi-upload/fileupload.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/nestable/nestable.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/noty-notifications/noty.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/popover/popover.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/pretty-photo/prettyphoto.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/progressbar/progressbar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/range-slider/rangeslider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/slider-ui/slider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/summernote-wysiwyg/summernote-wysiwyg.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/tabs-ui/tabs.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/theme-switcher/themeswitcher.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/timepicker/timepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/tocify/tocify.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/tooltip/tooltip.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/touchspin/touchspin.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/uniform/uniform.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/wizard/wizard.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/xeditable/xeditable.css">

<!-- FRONTEND WIDGETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/layerslider/layerslider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/owlcarousel/owlcarousel.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//widgets/fullpage/fullpage.css">

<!-- SNIPPETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//snippets/chat.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//snippets/files-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//snippets/login-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//snippets/notification-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//snippets/progress-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//snippets/todo.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//snippets/user-profile.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//snippets/mobile-navigation.css">

<!-- Frontend theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//themes/frontend/layout.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//themes/frontend/color-schemes/default.css">

<!-- Components theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//themes/components/border-radius.css">

<!-- Frontend responsive -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/responsive-elements.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl?>public//helpers/frontend-responsive.css">

    <!-- JS Core -->

    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//js-core/jquery-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//js-core/jquery-ui-widget.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//js-core/jquery-ui-mouse.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//js-core/jquery-ui-position.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//js-core/transition.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//js-core/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//js-core/jquery-cookie.js"></script>



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
<div id="page-wrapper"><div class="top-bar bg-topbar">
    <div class="container">
        <div class="float-left">
            <a href="#" class="btn btn-top btn-sm" title="Give us a call">
                <i class="glyph-icon icon-phone"></i>
                +1-415-805-8818
            </a>
        </div>
        <div class="float-right user-account-btn dropdown">
           	<?php 
				$user = $this->session->userdata("miner");
			?>
            <a href="#" title="My Account" class="user-profile clearfix" data-toggle="dropdown" aria-expanded="false">
                <img width="28" src="<?php echo $Layout->baseUrl?>public//image-resources/gravatar.jpg" alt="Profile image">
                <span><?php echo $user->name;?></span>
                <i class="glyph-icon icon-angle-down"></i>
            </a>
			
            <div class="dropdown-menu pad0B float-right">
                <div class="box-sm">
                    <div class="login-box clearfix">
                        <div class="user-img">
                            <a href="#" title="" class="change-img">Change photo</a>
                            <img src="<?php echo $Layout->baseUrl?>public//image-resources/gravatar.jpg" alt="">
                        </div>
                        <div class="user-info">
                        <span>
							<?php echo $user->name;?>
                        </span>
                            <a href="#" title="">Edit profile</a>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="pad5A button-pane button-pane-alt text-center">
                        <a href="<?php echo $Layout->baseUrl;?>outsource/dataentry/logout" class="btn display-block font-normal btn-danger">
                            <i class="glyph-icon icon-power-off"></i>
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .container -->
</div><!-- .top-bar -->



<div id="page-content" class="col-md-12 center-margin frontend-components mrg10T">
    <div class="row">

        <div class="col-md-12">
			<div id="page-title">
				<h2>My Projects</h2>
			</div>

			<div class="row">
				<div class="col-md-12" style='min-height:500px;'>
					<div class="panel">
						<div class="panel-body">
							<h3 class="title-hero">
								Hover table rows
							</h3>
							<div class="example-box-wrapper">
								<table class="table table-hover">
									<thead>
									<tr>
										<th>#</th>
										<th>Project Name</th>
										<th>Status</th>
									</tr>
									</thead>
									<tbody>       
										<?php 
											$user = $this->session->userdata('miner');
											if(count($my_projects)>0){
												$i=1;
												foreach($my_projects as $project){
													$id = '~'.md5($project->id);
										?>
											<tr>
												<td><?php echo $i;?></td>
												<td><?php echo anchor('outsource/dataentry/start/'.$id,$project->project_name);?></td>
												<td><?php echo ((int)$project->status==1)?"Live":"Finished";?></td>
											</tr>
										<?php
												$i++;
												}
										?>
										<?php
											} else {
										?>
										<tr>
											<td colspan="3"><p class='alert alert-warning'>No project found!</p></td>
										</tr>
										<?php 
											}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<div class="main-footer bg-gradient-9 clearfix">
    <div class="footer-pane">
        <div class="container clearfix">
            <div class="logo">&copy; <?php echo date('Y')?> SynPat. All Rights Reserved.</div>
            <div class="footer-nav-bottom">
            </div>
        </div>
    </div>
</div></div>


    <!-- FRONTEND ELEMENTS -->

<!-- Skrollr -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/skrollr/skrollr.js"></script>

<!-- Owl carousel -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/owlcarousel/owlcarousel.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/owlcarousel/owlcarousel-demo.js"></script>

<!-- HG sticky -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/sticky/sticky.js"></script>

<!-- WOW -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/wow/wow.js"></script>

<!-- VideoBG -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/videobg/videobg.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/videobg/videobg-demo.js"></script>

<!-- Mixitup -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/mixitup/mixitup.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/mixitup/isotope.js"></script>

<!-- WIDGETS -->

<!-- Bootstrap Dropdown -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/dropdown/dropdown.js"></script>

<!-- Bootstrap Tooltip -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/tooltip/tooltip.js"></script>

<!-- Bootstrap Popover -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/popover/popover.js"></script>

<!-- Bootstrap Progress Bar -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/progressbar/progressbar.js"></script>

<!-- Bootstrap Buttons -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/button/button.js"></script>

<!-- Bootstrap Collapse -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/collapse/collapse.js"></script>

<!-- Superclick -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/superclick/superclick.js"></script>

<!-- Input switch alternate -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/input-switch/inputswitch-alt.js"></script>

<!-- Slim scroll -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/slimscroll/slimscroll.js"></script>

<!-- Content box -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/content-box/contentbox.js"></script>

<!-- Overlay -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//widgets/overlay/overlay.js"></script>

<!-- Widgets init for demo -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//js-init/widgets-init.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//js-init/frontend-init.js"></script>

<!-- Theme layout -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public//themes/frontend/layout.js"></script>

<!-- Theme switcher -->

<script type="text/javascript" src="<?php echo $Layout->baseUrl?>public/widgets/theme-switcher/themeswitcher.js"></script>

</body>
</html>






