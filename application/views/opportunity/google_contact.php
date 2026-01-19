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
			<th>First Name</th>  
			<th>Last Name</th>  
			<th>Email</th>  
			<th>Job Title</th>  
			<th>Company</th>  
			<th width="100px;">Phone</th>  
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($contacts)>0){
				foreach($contacts as $lit){		
					$name = explode(" ",$lit->name);
					$first_name = $name[0];
					$last_name = "";
					if(count($name)>1){
						for($i=1;$i<count($name);$i++){
							$last_name .=$name[$i]." ";
						}
					}
	?>
				<tr data-i="<?php echo $lit->id;?>">					
					<td><?php echo $first_name?></td>
					<td><?php echo $last_name?></td>
					<td><?php echo (isset($lit->emailAddress))?implode(',',$lit->emailAddress):''?></td>
					<td><?php echo $lit->orgTitle?></td>
					<td><?php echo $lit->orgName?></td>
					<td  width="100px;"><?php echo (isset($lit->phoneNumber))?implode(',',$lit->phoneNumber):''?></td>
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
		___table = $('#db_from_litigation')
			.DataTable({								
				"searching":false,
				"autoWidth": true,
				"paging": false,
				// "sScrollY": _h+"px",
				"sScrollY": '500px',
				"sScrollX": "100%",
				"sScrollXInner": "100%"
			});
	});

/*
	window.resizeDataTable = function(height) {
		$('#db_from_litigation_wrapper .dataTables_scrollBody').height(height - 60);
	}

	$(function() {
		parent.open_prefined_listResize();
	})*/
</script>