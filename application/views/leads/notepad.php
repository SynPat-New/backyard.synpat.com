<!DOCTYPE html>
<html>
<head>
	<title>Notepad</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="https://backyard.synpat.com/public/widgets/summernote-wysiwyg/summernote.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/tooltip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/dropdown.min.js"></script>
	<script src="https://backyard.synpat.com/public/widgets/summernote-wysiwyg/summernote.min.js"></script>
	<style>.note-children-container{display:none;}</style>
</head>
<body>
	<div id="notepad" style="width:100%; height: 450px;"><?php echo $note_data;?></div>
</body>
<script>
var __baseUrl = '<?php echo $Layout->baseUrl?>';
var timeout;
$(document).ready(function() {
	$('#notepad').summernote({
		height: 600,
		disableDragAndDrop: true,
		toolbar: [
			['style', ['bold', 'italic', 'underline', 'clear']],
			['fontsize', ['fontsize']],
			['color', ['color']]
		]
	});
	jQuery("[data-toggle=dropdown]").dropdown();
	$("#notepad").on("summernote.change", function (e) { 
		clearTimeout(timeout);
		timeout = setTimeout(()=> {
			saveNotepadData();
		},1000); 
	});
});
function saveNotepadData(){
	var leadID = window.parent.leadGlobal;
	if(leadID > 0){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'opportunity/add_update_notepad',
			data:{lead_id:leadID,note:$('#notepad').summernote('code')},
			cache:false,
			dataType:'json',
			success:function(d){
				console.log(d);
			}
		});
		
	}
}
</script>