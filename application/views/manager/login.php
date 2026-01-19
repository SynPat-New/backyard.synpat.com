<!DOCTYPE html>
<html lang ="en">
<head>
    <style>
        /* Loading Spinner */
        .spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner > div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.spinner .bounce1{-webkit-animation-delay:-.32s;animation-delay:-.32s}.spinner .bounce2{-webkit-animation-delay:-.16s;animation-delay:-.16s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
    </style>
    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title><?php echo isset($title) ? $title.' :: DataFills.com' : 'DataFills' ; ?></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Favicons -->

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $Layout->awsUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $Layout->awsUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $Layout->awsUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="<?php echo $Layout->awsUrl?>public/images/icons/favicon.ico">
<link rel="shortcut icon" href="<?php echo $Layout->awsUrl?>public/images/icons/favicon.ico">



    <!-- HELPERS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/backgrounds.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/boilerplate.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/border-radius.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/page-transitions.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/spacing.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/utils.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/colors.css">

<!-- ELEMENTS -->


<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/content-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/loading-indicators.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/panel-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/response-messages.css">

<!-- ICONS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/icons/fontawesome/fontawesome.css">
<!-- WIDGETS -->

<!-- SNIPPETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/snippets/login-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/snippets/mobile-navigation.css">

<!-- APPLICATIONS -->
<!-- Admin theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/themes/admin/layout.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/themes/admin/color-schemes/default.css">

<!-- Components theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/themes/components/border-radius.css">

<!-- Admin responsive -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/responsive-elements.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/admin-responsive.css">

    <!-- JS Core -->

    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-ui-widget.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-ui-mouse.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-ui-position.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/transition.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-cookie.js"></script>






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

        <div class="col-md-8 col-lg-6 clearfix center-margin" id="login_popup">
			
            <div class="col-md-3"></div>
            <div class="col-md-6">
				<?php echo $this->session->flashdata('message');?>
				<?php echo form_open('manager/login/login')?>
                    <div class="content-box mrg5T">
                        <h3 class="content-box-header content-box-header-alt bg-default">
                            <span class="header-wrapper"> 
                                Login
                                <small>Use the form below to login to your account.</small>
                            </span>
                            <!--<span class="header-buttons">
                                <a href="#" class="btn btn-sm btn-primary" title="">Sign Up</a>
                            </span>-->
                        </h3>
                        <div class="content-box-wrapper">							
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="email" name="login[email]" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                    <span class="input-group-addon bg-blue">
                                        <i class="glyph-icon icon-envelope-o"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="password" name="login[password]" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                    <span class="input-group-addon bg-blue">
                                        <i class="glyph-icon icon-unlock-alt"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <a href="javascript://" title="Recover password">Forgot Your Password?</a>
                            </div>
                            <button class="btn btn-success btn-block">Sign In</button>
							
                        </div>
                    </div>
                <?php echo form_close();?>
            </div>
			<div class="col-md-3"></div>
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
body{min-width:100%;}
</style>

<script>
	function open_register_popup(){
		jQuery("#login_popup").slideToggle();
		jQuery("#register_popup").slideToggle();
	}
</script>
<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/overlay/overlay.js"></script>

</body>
</html>