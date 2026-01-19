<style>body{min-width:0}
body.is-scrollable-body {
	overflow-x: hidden !important;
	overflow-y: auto !important;
}
button,.btn, .btn div, .btn a{color:#000;}
#page-content{padding:0}.message-result .message-detail-right a{color:#222}.message-result .message-detail-right a:hover{color:#56b2fe}.dropdown-menu li>a,.ui-menu li>a{color:#222;text-decoration:none}.dropdown-menu .row>div{margin-bottom:0!important}#message-body a{color:#2196f3;}</style>
<script>
	jQuery(document).ready(function(){
		html = window.parent.HTMLImapEmail;
		regex = /https:\/\/synpat.com\/display_synpat_logo.php/gm;
		html = html.replace(regex,'');
		jQuery("#embedHtMl").html(html);
		setTimeout(window.parent.checkMyEmailsHeight(),400);
		jQuery(".dropdown-toggle").dropdown();
	});
</script>
<div id="embedHtMl"></div>