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
<script src='https://www.google.com/recaptcha/api.js'></script>
<div class="center-vertical">
    <div class="center-content">

        <div class="col-md-8 col-lg-6 clearfix center-margin" id="login_popup">
			
            <div class="col-md-2"></div>
            <div class="col-md-7">
				<?php echo $this->session->flashdata('message');?>
				<?php echo form_open('outsource/login/login')?>
                    <div class="content-box mrg5T">
                        <h3 class="content-box-header content-box-header-alt bg-default">
                            <span class="header-wrapper"> 
                                Welcome Researcher !
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
                                <a href="javascript://" onclick='open_forget_popup();' title="Recover password">Forgot Your Password?</a>
								<a href="javascript://" title="Register" onclick='open_register_popup();' class='pull-right'>Register</a>
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
	    <div class="col-md-8 col-lg-6 clearfix center-margin hide" id="forget_popup">
			<div class="col-md-2"></div>
			<div class="col-md-7">
				<div class="content-box">
					<form action='<?php echo $Layout->baseUrl;?>outsource/forget' class='form-horizontal bordered-row' data-parsley-validate method="post">
					<div class="form-group" style='padding:0px;'>
					<h3 class="content-box-header content-box-header-alt" style='padding:10px 0 10px 30px;'>
						Forget Password
					</h3>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Email Address:</label>
						<div class="col-sm-6">
							<input type="text" data-parsley-type="email" class="input-mask form-control" name="forget[email]" placeholder="Email Address" required/>
						</div>
					</div>
					<div class="form-group">
					<div class="col-sm-3">						
					</div>
					<div class="col-sm-9 mrg5B">
						<button class="btn btn-default mrg10R" type='button' onclick="open_forget_popup();">Cancel</button>
						<button class="btn btn-success">Submit</button>
					</div>
					</div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	  <div class="col-md-8 col-lg-6 clearfix center-margin hide" id="register_popup">
			<div class="col-md-2"></div>
			<div class="col-md-7">
				<div class="content-box">
					<?php  
						$data = $this->session->flashdata('post_data');
						$first_name = '';
						$last_name = '';
						$email = '';
						$user_number = '';
						if(count($data)>0){
							$first_name = $data['first_name'];
							$last_name = $data['last_name'];
							$email = $data['email'];
							$user_number = $data['user_number'];
						}
					?>
					<form action='<?php echo $Layout->baseUrl;?>outsource/register' class='form-horizontal bordered-row' data-parsley-validate method="post">
					<div class="form-group" style='padding:0px;'>
					<h3 class="content-box-header content-box-header-alt" style='padding:10px 0 10px 30px;'>
						Register
					</h3>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">First Name:</label>
						<div class="col-sm-6">
							<input type="text" class="input-mask form-control" name="register[first_name]" placeholder="First Name" required value="<?php echo $first_name;?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Last Name:</label>
						<div class="col-sm-6">
							<input type="text" class="input-mask form-control" name="register[last_name]" placeholder="Last Name" required value="<?php echo $last_name;?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Email:</label>
						<div class="col-sm-6">
							<input type="text" class="input-mask form-control" data-parsley-type="email" placeholder="Email address" required name="register[email]" value="<?php echo $email;?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Password:</label>
						<div class="col-sm-6">
							<input type="password" class="input-mask form-control" required name="register[password]" data-parsley-type="alphanum" data-parsley-minlength="6" data-parsley-maxlength="10" id="registerPassword"  placeholder="Password"/>
							<div class="help-block">Minimum six digits and letters</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Confirm Password:</label>
						<div class="col-sm-6">
							<input type="password" class="input-mask form-control" data-parsley-equalto="#registerPassword" data-parsley-type="alphanum" required name="register[password2]" placeholder="Confirm Password" data-parsley-minlength="6" data-parsley-maxlength="10"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Telephone</label>
						<div class="col-sm-6">
							<input type="text" class="input-mask form-control" name="register[user_number]" required value="<?php echo $user_number;?>"/>
							<div class="help-block">+x xxx xxx xxxx</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label"></label>
						<div class="col-sm-6">
							<div class="g-recaptcha" data-sitekey="6LeahBoTAAAAABEc24IHYsY0_-s0Q8dKcIAOPSQj"></div>
							<?php /*echo $image;*/?>
							<!--<input type="text" class="input-mask form-control" name="register[captcha]" required >-->
						</div>
					</div>
					<div class="form-group">
					<div class="col-sm-3">						
					</div>
					<div class="col-sm-9 mrg5B">
						<button class="btn btn-default mrg10R" type='button' onclick="open_register_popup();">Cancel</button>
						<button class="btn btn-success">Register</button>
					</div>
					</div>
					<?php echo form_close();?>
				</div>
			</div>
			<div class="col-md-3"></div>
	  </div>
    </div>
</div>
<style>
.form-horizontal > .form-group{
	margin-right:0px;
	margin-left:0px;
}body{min-width:100%;}
</style>

<script>
	function open_register_popup(){
		jQuery("#login_popup").slideToggle();
		jQuery("#register_popup").slideToggle();
	}
	function open_forget_popup(){
		jQuery("#login_popup").slideToggle();
		jQuery("#forget_popup").slideToggle();
	}
	function resendActivationCode(o){
		if(o.data("cp")!=""){
			jQuery.ajax({
				type:'POST',
				url:'<?php echo $Layout->baseUrl;?>outsource/resend_activation_code',
				data:{cp:o.data("cp")},
				success:function(d){
					if(d!=""){alert(d);window.location='<?php echo $Layout->baseUrl;?>/outsource/login';}
				}
			})
		}
	}
</script>

   <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/overlay/overlay.js"></script>

</body>
</html>