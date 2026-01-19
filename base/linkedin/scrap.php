<?php 
session_start();
$leadID = $_SESSION['lead_id_linkedin'];
$body= "";
if(isset($_SESSION[$leadID.'body_linkedin'])){
$body = $_SESSION[$leadID.'body_linkedin'];
}
?>
<a href='#' id="copy_text" style="">asdfas</a>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="jquery.clipboard.js"></script>

<script>
	$(document).ready(function() {
		
		var copy_sel = $('#copy_text');

		// Disables other default handlers on click (avoid issues)
		copy_sel.on('click', function(e) {	
			console.log("asd");
			e.preventDefault();

		});

		// Apply clipboard click event
		copy_sel.clipboard({
			path: 'jquery.clipboard.swf',

			copy: function() {
				var this_sel = '<?php echo $body;?>';
				return this_sel
			}
		});
		$( "#copy_text" ).trigger( "click" );
	});	
</script>