<style> 
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;
	}
	#page-content {
	    background: #ffffff !important;
	}

</style>
<div class='col-lg-12'>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="db_from_litigation" >
	<thead>
		<tr> 
			<th>File Name</th>  
			<th>Date</th>  
			<th>Action</th>  
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($drive)>0){
				foreach($drive as $file){					
	?>
				<tr data-i="<?php echo $file->id;?>">					
					<td><?php echo $file->title?></td>
					<td><?php echo date('M d, Y',strtotime($file->createdDate));?></td>
					<td><a href='javascript://' onclick='moveFileToLead("<?php echo $file->id?>",jQuery(this))'><i class="glyph-icon icon-mail-forward"></i></a></td>
				</tr>			
	<?php
				}
			}
		?>
	</tbody>
</table>
</div>
<script>
	var ___table;
	jQuery(document).ready(function(){
		___table = $('#db_from_litigation')
			.DataTable({								
				"searching":false,
				"autoWidth": true,
				"paging": false,
				// "sScrollY": _h+"px",
				"sScrollY": 100,
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			});			
	});


	window.resizeDataTable = function(height) {
		h = height/2;
		$('#db_from_litigation_wrapper .dataTables_scrollBody').height(h - 60);
	}

	$(function() {
		parent.open_prefined_listResize();
	})
	
	function moveFileToLead(ID,o){
		if(window.parent.leadGlobal>0){
			_container="";
			if(window.parent.jQuery("#from_regular").is(":visible")){
				_container="#from_regular"
			}else{
				if(window.parent.jQuery("#from_litigation").is(":visible")){
					_container="#from_litigation"
				}else{
					if(window.parent.jQuery("#from_nonacquistion").is(":visible")){
						_container="#from_nonacquistion"
					}
				}
			}
			_folder = "";
			if(_container!=""){
				_folder = window.parent.jQuery(_container).find("#clipboard").val();
			}
			if(_folder!="" && _folder!="undefined"){
				jQuery.ajax({
					type:'POST',
					url:__baseUrl+'dashboard/move_drive_file_in_lead_folder',
					data:{d:ID,f:_folder},
					success:function(d){
						_d = jQuery.parseJSON(d);
						if(_d.send>0){
							jQuery('table#db_from_litigation>tbody>tr[data-i="' + ID + '"]').remove();
						} else {
							alert("Failed to move file, please try after sometime.");
						}
					}
				});
			} else {
				jQuery.ajax({
					type:'POST',
					url:__baseUrl+'dashboard/move_drive_file',
					data:{old_thread:window.parent.leadGlobal,drive:ID},
					success:function(d){
						_d = jQuery.parseJSON(d);
						if(_d.send>0){
							jQuery('table#db_from_litigation>tbody>tr[data-i="' + ID + '"]').remove();
						} else {
							alert("Failed to move file, please try after sometime.");
						}
					}
				});
			}
			
		} else {
			alert('Please select lead first.');
		}
	}
</script>