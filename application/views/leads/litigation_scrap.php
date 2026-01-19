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
<script>
	window.cScrap = [];
</script>
<div class='col-lg-12'>
<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="db_from_litigation" >
	<thead>
		<tr>     
			<th>#</th>
			<th>Url</th>  
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($litigation_scrap)>0){
				foreach($litigation_scrap as $lit){					
	?>
				<script>
					window.cScrap[<?php echo $lit->id;?>] = JSON.stringify(<?php echo $lit->data?>);
				</script>
				<tr data-i="<?php echo $lit->id;?>">
					
					<td><input name='contact_id' value='<?php echo $lit->id;?>' type="radio" onclick="getScrapData('<?php echo $lit->id?>','<?php echo $lit->url;?>')" /> <a href="javascript://" onclick="deleteLitigationScrap(<?php echo $lit->id?>)"><img src="<?php echo $Layout->awsUrl;?>public/images/discard.png"></a></td>
					<td><?php echo $lit->url?></td>
				</tr>			
	<?php
				}
			}
		?>
	</tbody>
</table>

</div>
<script>
	var ___table,___tablePre ;
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


jQuery(document).ready(function(){
	jQuery('#db_from_litigation').find("tbody").find("tr>td").dblclick(function(e){
		e.stopPropagation();
       /* var currentEle = $(this);
        var value = $(this).html();
        updateVal(currentEle, value);*/
	});
});

function getScrapData(d,url){
	window.parent.resetLitigationForm();
	window.parent.emptyForm();
	/*window.parent.jQuery('#lititgationImportURL').val(url);*/
	window.parent.jQuery('#litigationLinkToRPX').val(url);
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'dashboard/lititgation_scrap_data',
		data:{scrap:window.cScrap[d],lead:window.parent.leadGlobal},
		success:function(data){			
		}
	})
	window.parent.implementLitigationScrap(JSON.parse(window.cScrap[d]));
}

function deleteLitigationScrap(ID){
	jQuery.ajax({
		type:'POST',
		url:__baseUrl+'leads/deleteLitigationScrap',
		data:{id:ID},
		success:function(d){
			if(d>0){
				jQuery('table#db_from_litigation>tbody>tr[data-i="' + ID + '"]').remove();
			}
		}
	})
}
</script>