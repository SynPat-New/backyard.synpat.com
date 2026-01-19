<style>body{min-width:0}
body.is-scrollable-body {
	overflow-x: hidden !important;
	overflow-y: auto !important;
}
button,.btn, .btn div, .btn a{color:#000 !important;}
#page-content{padding:0}.message-result .message-detail-right a{color:#222}.message-result .message-detail-right a:hover{color:#56b2fe}.dropdown-menu li>a,.ui-menu li>a{color:#222;text-decoration:none}.dropdown-menu .row>div{margin-bottom:0!important}#message-body a{color:#2196f3;}</style>

<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>widgets/slimscroll/slimscroll.js"></script>
<script>
jQuery(function() {
	jQuery(".scrollable-slim-sidebar").slimScroll({
		color: "#8da0aa",
		size: "10px",
		height: "100%",
		alwaysVisible: !0
	})
});
jQuery(function() {
	jQuery(".scrollable-slim-box").slimScroll({
		color: "#8da0aa",
		size: "6px",
		alwaysVisible: !1
	})
});
</script>
