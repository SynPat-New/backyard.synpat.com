<div id="df_form"></div>
<script>
jQuery(document).ready(function(){
	if(window.parent._spreadsheet.length>0){
		var formDF = document.createElement("form");
			formDF.setAttribute("method", "POST");
			formDF.setAttribute("action", "https://app.datafills.com/fills/backyard_selected_contacts");
			formDF.setAttribute("id", "datafills_form");	
			var hiddenField = document.createElement("input"); 
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "dfc");
			hiddenField.setAttribute("id", "dfc");
			hiddenField.setAttribute("value", "backyard_synpat");
			formDF.appendChild(hiddenField);
			var hiddenField = document.createElement("input"); 
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "sk");
			hiddenField.setAttribute("id", "sk");
			hiddenField.setAttribute("value", "7pqhLfdlK7TJoDKlP7CBVf3zsnY0ICTq2pEgdi6q1pk=");
			formDF.appendChild(hiddenField);
			var hiddenField = document.createElement("input"); 
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "s");
			hiddenField.setAttribute("id", "s");
			hiddenField.setAttribute("value", "1ee9247397c05d94cbf0e283b95460a1b90ddfd4");
			formDF.appendChild(hiddenField);
			var hiddenField = document.createElement("input"); 
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "l");
			hiddenField.setAttribute("id", "l");
			hiddenField.setAttribute("value", window.parent.jQuery("#user_email").val());
			formDF.appendChild(hiddenField);
			var hiddenField = document.createElement("input"); 
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "d");
			hiddenField.setAttribute("id", "d");
			hiddenField.setAttribute("value", "backyard.synpat.com");
			formDF.appendChild(hiddenField);
			var hiddenField = document.createElement("input"); 
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "raw_contacts");
			hiddenField.setAttribute("id", "raw_contacts");
			hiddenField.setAttribute("value", JSON.stringify(window.parent._spreadsheet));
			formDF.appendChild(hiddenField);
			var hiddenField = document.createElement("input"); 
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", "backyard_lead");
			hiddenField.setAttribute("id", "backyard_lead");
			hiddenField.setAttribute("value", window.parent.leadGlobal);
			formDF.appendChild(hiddenField);
			jQuery("#df_form").empty().append(formDF);
			jQuery("#df_form").find("#datafills_form").get(0).submit();
	}
});
</script>