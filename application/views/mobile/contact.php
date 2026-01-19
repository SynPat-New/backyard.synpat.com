<link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="//cdn.datatables.net/fixedheader/3.1.2/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="//cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css" rel="stylesheet">

<style>
.dataTables_info{display:none;}
 th, td { white-space: nowrap; }
 table.dataTable.no-footer{border-bottom:0px;}
</style>
<div class="row">
	<div class="col-md-12" style='margin-top:10px;'>
		<input type="text" name="search_field" id="search_field" placeholder="Search..." class="form-control"/>
		<p class="alert alert-info" id="loading" style='display:none;'>Please wait...</p>
	</div>
</div>
<table class="table" id="contacts">
	<thead>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Company</th>
			<th>Email</th>
			<th>Work / Cell phone</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($contacts)>0){
				foreach($contacts as $contact){
					$name = trim($contact->first_name." ".$contact->last_name);
		?>
				<tr>
					<td><?php echo $contact->first_name;?></td>
					<td><?php echo $contact->last_name;?></td>
					<td><?php echo $contact->company_name?></td>
					<td><?php echo ($contact->email!="")?"<a href='mailto:".$contact->email."'>".$contact->email."</a>":''?></td>
					<td><?php echo ($contact->phone!="")?"<a href='tel:".$contact->phone."' style=''>".$contact->phone."</a>":''; if(!empty($contact->telephone)){echo "<br/>".($contact->telephone!="")?"<a style='margin-left:5px;' href='tel:".$contact->telephone."'>".$contact->telephone."</a>":'';}?></td>
				</tr>
		<?php
				}
			}
		?>
	</tbody>
</table> 
<script>
	var tableContacts,_height;
	$(document).ready(function() {
		_height = $(window).height() - 110;
		tableContacts = $('#contacts').DataTable( {
			"order": [[ 0, "asc" ]],
			"scrollY": _height+"px",
			scrollX:true,
			"sScrollX": "100%",
			"sScrollXInner": "150%",
			"bScrollCollapse": true,
			"fixedHeader": true,
			paging: false,
			searching: false,
			destroy:true,
			"scrollCollapse": true,
			fixedColumns:   {
				leftColumns: 2,
			},
			"language": {
				"zeroRecords": "No records to display"
			}
		});
		jQuery('#search_field').keypress(function (e) {
			var key = e.which;
			if(key == 13) {
				e.preventDefault();
				callNewRecords();
			}		  
		});
	} );
	function callNewRecords(){		
		jQuery("#loading").show();
		jQuery.ajax({
			type:"POST",
			url:"http://backyard.synpat.com/mobile/contact/ajax/50",
			data:{search:jQuery('#search_field').val()},
			cache:false,
			dataType:'json',
			success:function(b){
				jQuery("#loading").hide();
				_tableBody="";
				tableContacts.destroy();
				$('#contacts').find('th').css('width','');
				if(b.contacts.list.length>0){
					jQuery.each(b.contacts.list,function(index,contact){
						name = contact.first_name+" "+contact.last_name;
						_tableBody +="<tr><td>"+contact.first_name+"</td><td>"+contact.last_name+"</td><td>"+contact.company_name+"</td><td>";
						if(contact.email!=""){
							_tableBody +="<a href='mailto:"+contact.email+"'>"+contact.email+"</a>";
						}
						_tableBody +="</td><td>";
						if(contact.phone!=""){
							_tableBody +="<a href='tel:"+contact.phone+"'>"+contact.phone+"</a>";
						}
						if(contact.telephone!=""){
							_tableBody +="<br/><a style='margin-left:5px' href='tel:"+contact.telephone+"'>"+contact.telephone+"</a>";
						}
						_tableBody +="</td></tr>";
					});					
				}
				jQuery("#contacts").find("tbody").html(_tableBody);
				
				tableContacts = $('#contacts').DataTable( {
					"order": [[ 0, "asc" ]],
					"scrollY": _height+"px",
					scrollX:true,
					"sScrollX": "100%",
					"sScrollXInner": "150%",
					"bScrollCollapse": true,
					"fixedHeader": true,
					paging: false,
					searching: false,
					destroy:true,
					"scrollCollapse": true,
					fixedColumns:   {
						leftColumns: 2,
					},
					"language": {
						"zeroRecords": "No records to display"
					}
				});
			}
		});
	}
</script>
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js"></script>
<script src="//cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<script src="//cdn.datatables.net/scroller/1.4.2/js/dataTables.scroller.min.js"></script>
<script src="//cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>