<?php 
if($t==4){
	$templates = getAllTemplates();
} else {
	$templates = getAllTemplateBYLead($lead_id);
}


?>

<style> 
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;
	}
	#page-content {
	    background: #ffffff !important;
	}

	#db_from_litigation_wrapper .dataTables_filter label {
		padding-top: 2px;
	}
	#db_from_litigation_wrapper .dataTables_filter input {
	    box-shadow: none;
	    float: right;
	    height: 24px;
	    margin: -4px 0 2px 2px;
	    padding-left: 5px;
	    padding-right: 5px;
	}

	#db_from_litigation_wrapper .dataTables_scroll {
		background: none;
		clear: both;
	}
	#db_from_litigation_wrapper .dataTables_info {
		display: none;
	}

</style>
<div class='col-lg-12'>
<?php if($t==4):?>
<button onclick="moveAllToLead(<?php echo $t?>)" type="button" class='btn btn-primary'>Move all template to Lead</button>
<?php elseif($t==3):?>
<!--<button onclick="moveAllToLead(<?php echo $t?>)" type="button" class='btn btn-primary'>Import all messages from the general messages bank</button>-->
<?php endif;?>
<p class='mrg10B'>Select one of the following templates in order to edit it or create a new template based on the selected one:</p>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="db_from_litigation" >
	<thead>
		<tr>
			<th>#</th>                           
			<th>Subject</th>                           
			<th>Template Name</th>                           
			<th>Description</th>  
		</tr>
	</thead>
	<tbody>  
		<?php 
			if(count($templates)>0){
				foreach($templates as $lit){
	?>
				<tr data-item-idd="<?php echo $lit->id;?>">
					<td>
						<input style="margin:2px;" name='predefine_message' data-name="<?php echo $lit->template_name;?>" data-subject="<?php echo $lit->subject;?>" type="radio" onclick="appendText(jQuery(this),<?php echo $t;?>)" data-main_type="<?php echo $lit->main_type;?>" data-type="<?php echo $lit->type;?>" data-template-type="<?php echo $lit->template_type;?>" data-template-stage="<?php echo $lit->template_stage;?>"/>
						<?php if($lit->main_type != 2):?>
						<a href='javascript://' onclick='deletePreTemplate(<?php echo $lit->id;?>,<?php echo $t;?>)'><i class="glyph-icon"><img src="<?php echo $Layout->awsUrl?>images/discard.png" style="opacity:0.55"></i></a>
						<?php endif;?>
					</td>					
					<td><?php echo $lit->subject;?></td>					
					<td><?php echo $lit->template_name;?></td>					
					<td><div><?php echo $lit->template_html?></div></td>					
				</tr>
	<?php
				}
			}
		?>
	</tbody>
</table>
</div>
<script>
	var ___table ;
	jQuery(document).ready(function(){
		_h = window.parent.$(window).height() - 120;
		___table = $('#db_from_litigation')
			.DataTable({								
				"searching":true,
				"autoWidth": true,
				"paging": false,
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			});
	});
	window.resizeDataTable = function(height) {
		$('#db_from_litigation_wrapper .dataTables_scrollBody').height(height - 60);
	}

	$(function() {
		parent.open_all_invitationResize();
	})
	__leadID = '<?php echo $lead_id?>';
	function moveAllToLead(t){
		if(t==4){
			data = {lead_id:window.parent.leadGlobal}
		} else if(t==3){
			data = {lead_id:__leadID}
		}
		window.parent.call(window.__baseUrl+'users/moveAllToLeadBankTemplate','POST',data,window.parent.successMoveTemplate,'text');
	}
	
	function appendText(o,t){
		_text = o.parent().next().next().next().text();
		_html = o.parent().next().next().next().html();
		var $slider;
		window.parent.jQuery("#original_template_type").val(o.attr('data-type'));
		window.parent.jQuery("#original_main_type").val(o.data('main_type'));	
		switch(parseInt(t)){
			case 1:
			default:
				window.parent.$("#emailMessage").code(_html+"<br/>"+window.parent.$("#original_signature").val());
				window.parent.$("#emailSubject").val(o.attr("data-subject"));
			break;
			case 2:
				window.parent.jQuery('textarea[name="event[description]"]').val(_text);
			break;
			case 3:
			case 4:
			console.log("PACK"+parseInt(o.attr('data-main_type')));
				if(parseInt(o.attr('data-main_type'))==2){
					let originalData = _html;
					console.log("ORIGINAL",originalData);
					_html = jQuery(_html).find('.touch').html();
					window.parent.openTemplateEditor();
					$slider = window.parent.jQuery("#open_template_editor");
					$slider.find("#original_data").val(originalData);
					$slider.find("#templateEditor").code(_html);
					$slider.find('#template_id').val(o.parent().parent().attr('data-item-idd'));
					$slider.find('#template_subject').val(o.attr('data-subject'));
					$slider.find('#template_file_name').val(o.attr('data-name'));					
				} else {
					window.parent.openTemplateEditor();
					$slider = window.parent.jQuery("#open_template_editor");
					$slider.find("#templateEditor").code(_html);
					$slider.find('#template_id').val(o.parent().parent().attr('data-item-idd'));
					$slider.find('#template_subject').val(o.attr('data-subject'));
					$slider.find('#template_file_name').val(o.attr('data-name'));
					$slider.find("#original_data").val('');
				}
				$slider.find("#original_template_type").val(o.attr('data-type'));
				$slider.find("#original_main_type").val(o.data('main_type'));
				$slider.find('#template_type').val(o.attr('data-template-type'));
				$slider.find('#template_stage').val(o.attr('data-template-stage'));
			break;
		}		
	}
	
	function deletePreTemplate(d,t){
		jQuery.ajax({
			type:'POST',
			url:__baseUrl+'users/delete_predefined_template',
			data:{id:d,t:t},
			cache:false,
			success:function(b){
				if(b>0){
					window.parent.document.getElementById("predefineFormIframe").contentWindow.location.reload();
				} else {
					alert("Please try after sometime");
				}
			}
		})
	}
</script>