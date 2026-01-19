<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn?>public/widgets/slimscroll/slimscroll.js"></script>
<link  rel="stylesheet" media="screen" href="https://s3.amazonaws.com/handsontable/handsontable_new/dist/handsontable.min.css">
<link  rel="stylesheet" media="screen" href="https://s3.amazonaws.com/handsontable/handsontable_new/dist/pikaday/pikaday.css">
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/moment/moment.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="<?php echo $Layout->cdnUrlHands;?>handsontable_new/dist/handsontable.min.js"></script>
<style>
	body {
		overflow: auto !important;
		min-width: 0;
		width: 100% !important;font-family:arial;font-size:13px;margin:0px;
	}
	#page-content {
	    background: #ffffff !important;
	}
	
	a{text-decoration:none;}h4{font-size:16px;font-weight:300;margin:0}
	
	.mrg5R{margin-right:5px;}
	.scroll-container {
	width: 100%;
	height: 250px;
	margin: 5px 0 1rem;
	overflow: hidden;
}
.htCore, .handsontable{font-family:arial;font-size:13px;}
.handsontable .htDimmed{color:#222222}
</style>
<div class="scroll-container col-lg-12 cp-border">
	<div id='companies_box' class="hot handsontable htRowHeaders htColumnHeaders" style='width:500px;'></div>
</div>
<script>
		var company_table = document.getElementById('companies_box'),hot1,isChecked;
		_companiesINString = [];
		_companiesINString=[<?php
				if(count($getTimelineData)>0){
					$i=0;
					foreach($getTimelineData as $contact){		
					echo "{'lead_id':". $contact->lead_id.",'lead_name':'" . addslashes($contact->lead_name) . "','name':'" . $contact->name . "','message':'" . addslashes($contact->message) . "','create_date':'" . date('M d, Y',strtotime($contact->create_date)) . "'}";
					if ($i < count($getTimelineData) - 1) {
						echo ",";
					}
					}
				}
			?>];
			var totalHeight = jQuery(window).height();
			var mainHeight = totalHeight - 35;
			var availableWidth = jQuery(window).width();
			availableWidth = availableWidth-20;
			jQuery('.scroll-container').css('height',mainHeight+'px');
			function implementCompanyTable(){
				hot1 = new Handsontable(company_table, {
					data: _companiesINString,
					  autoWrapCol:true,
					  wordWrap:true,
					  rowHeaders: false,
					  minSpareRows: 0,
					  minSpareCols: 0,
					  manualColumnResize:true ,
					  minCols: 11,
					  maxCols: 11,
					  maxRows: _companiesINString.length,
					  width:function(){console.log(availableWidth);return availableWidth;},
					  height:function(){return mainHeight;},
					  fillHandle: false,
					  stretchH:"all",
					  colHeaders:['Date','Lead','Activity','Person'],
					  columnSorting: {
						column: 0,
						sortOrder: true
					  },
					  contextMenu: false,
					filters: true,
					dropdownMenu: ['filter_by_condition', 'filter_action_bar','filter_by_value'],
					columns: [					
					  {
						data:'create_date',
						readOnly:true
					  },
					  {
						data:'lead_name',
						renderer: traignleICONRender,
						readOnly:true
					  },
					  {
						data:'message',
						renderer: htmlICONRender,
						readOnly:true
					  },
					  {
						data:'name',
						readOnly:true
					  }
					]
		  });
		 }
		 implementCompanyTable();
			function traignleICONRender(instance, td, row, col, prop, value, cellProperties){
			  currentVal = instance.getDataAtRowProp(row,'lead_id');
			  Handsontable.Dom.empty(td);
			  td.innerHTML = "<a href='javascript://' onclick='window.parent.openLeadDetail("+currentVal+");'>"+value+"</a>";
			  return td;
			} 
			function htmlICONRender(instance, td, row, col, prop, value, cellProperties){
			   Handsontable.Dom.empty(td);
			  td.innerHTML = value;
			  return td;
			} 
			jQuery(window).resize(function(){
				totalHeight = jQuery(window).height();
				mainHeight = totalHeight - 35;
				availableWidth = jQuery(window).width();
				availableWidth = availableWidth-20;
				jQuery('.scroll-container').css('height',mainHeight+'px');
				hot1.updateSettings({
					width:function(){return availableWidth;},
					height:function(){return mainHeight;}
				})
			});
		  </script>