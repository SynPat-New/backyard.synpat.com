<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css" rel="stylesheet"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>
<style>
.col-60{float:right;width:84%;}
.col-40{width:15%;float:left;}
#company,#find,#owler,#connect,#contact,#notification{width:100%;float:left;}
#company,#find,#owler,#connect,#contact{margin-bottom:5px;}
/*#notification{height:500px;overflow:auto}*/
ul{list-style:none;padding:0;margin:0;}
ul li{float:left;width:100%;padding:10px 5px;border-bottom:1px solid #efefef;}
body {
	overflow: auto !important;
	min-width: 0;
	font-family:arial;font-size:13px;
	margin-top:0px;
	margin-bottom:0px;
}
.table{padding:0;margin:0;}
.table tr td, .table tr th{border:1px solid #efefef;padding:5px;border-right:0px;}
.col-40 th{text-align:left;}
.table tr td{border-top:0px;}
.table tr td:last-child, .table tr th:last-child{border-right:1px solid #efefef;}
.dataTables_scrollBody{overflow-x:hidden !important;}

.dataTables_empty, #find .dataTables_scrollBody, #find .dataTables_scrollHeadInner thead th, #contact .dataTables_scrollBody, #contact .dataTables_scrollHeadInner thead th, #owler .dataTables_scrollBody, #owler .dataTables_scrollHeadInner thead th, #company .dataTables_scrollBody, #company .dataTables_scrollHeadInner thead th{border:0px;}
table.dataTable thead th, table.dataTable thead td{padding:10px 16px;}
#company, #find, #contact, #owler{border:1px solid #efefef;}
#api_notification_wrapper table.dataTable th, #api_notification_wrapper table.dataTable td{word-break:break-all;}
</style>
<body>
<div class="row">	
	<div class="col-40">
		<h3 style='text-align:center;'>LinkedIn</h3>
		<div id="company">
			<table class='company' id="tblcompany">
				<thead><tr><th data-count="<?php echo count($company);?>">Company Data: <?php echo count($company);?></th></tr></thead>
				<tbody>
				<?php 
					if(count($company)>0){
						foreach($company as $c){
							$companyName = $c->company_name;
							if(empty(trim($companyName))){
								$linkedinUrl = $c->linkedin_url;
								if(substr($linkedinUrl,-1) == "/"){
									$linkedinUrl = substr($linkedinUrl,0,-1);
								}
								$companyName = array_pop(explode("/",$linkedinUrl));
							}
				?>
					<tr id="<?php echo $c->id;?>" data-company="<?php echo $c->company_id?>"><td><?php echo $companyName;?></td></tr>
				<?php
						}
					} 
				?>
				</tbody>
			</table>
		</div>
		<div id="find">
			<div style='margin-top:5px;'>
				<?php 
					$peopleScrape = 0;
					if(count($button_status) > 0){
						foreach($button_status as $btn){
							switch($btn->type){
								case 3:
									$peopleScrape = $btn->status;
									break;
							}
						}
					}
					$min = 120;
					$max = 300;
					if(count($timmer) > 0){
						$min = $timmer->min;
						$max = $timmer->max;
					}
				?>
				<a href="javascript://" onclick="updatePeopleScrapping(jQuery(this))" data-status="<?php echo $peopleScrape;?>"  style="width:13px;float:left;"><?php echo $peopleScrape==0?'<svg aria-hidden="true" style="position:relative;top:2px;" focusable="false" data-prefix="far" data-icon="pause-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-pause-circle fa-w-16 fa-2x"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200zm96-280v160c0 8.8-7.2 16-16 16h-48c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16zm-112 0v160c0 8.8-7.2 16-16 16h-48c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16z" class=""></path></svg>':'<svg style="position:relative;top:2px;" aria-hidden="true" focusable="false" data-prefix="far" data-icon="play-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-play-circle fa-w-16 fa-2x"><path fill="currentColor" d="M371.7 238l-176-107c-15.8-8.8-35.7 2.5-35.7 21v208c0 18.4 19.8 29.8 35.7 21l176-101c16.4-9.1 16.4-32.8 0-42zM504 256C504 119 393 8 256 8S8 119 8 256s111 248 248 248 248-111 248-248zm-448 0c0-110.5 89.5-200 200-200s200 89.5 200 200-89.5 200-200 200S56 366.5 56 256z" class=""></path></svg>'?></a>
				<a href="javascript://" onclick="deleteAllFromQueue(jQuery(this))" style="width:13px;float:left;"><svg style="position:relative;top:2px;left:6px;" aria-hidden="true" focusable="false" data-prefix="far" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-2x"><path fill="currentColor" d="M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z" class=""></path></svg></a>
				<span style="margin-left:10px;">Delay: <input value="<?php echo $min;?>" id="min" placeholder="Min" style="width:30px;"/> / <input value="<?php echo $max;?>" id="max" placeholder="Max" style="width:30px;"/> sec</span>
			</div>
			<table class='find' id="tblFindContacts">
				<thead><tr><th  data-count="<?php echo count($find);?>">Company Professionals <?php echo count($find);?><span class='heading'></span></th></tr></thead>
				<tbody>
				<?php 
					if(count($find)>0){
						foreach($find as $c){
				?>
					<tr id="<?php echo $c->id;?>" data-company="<?php echo $c->company_id?>"><td><span style="display:inline-block;width:12px;height:12px;margin-right:5px;position:relative;top:3px;"><a href="javascript://"  onclick="deleteFromQueue(jQuery(this))"><svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-trash-alt fa-w-14 fa-2x"><path fill="#000000" d="M296 432h16a8 8 0 0 0 8-8V152a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v272a8 8 0 0 0 8 8zm-160 0h16a8 8 0 0 0 8-8V152a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v272a8 8 0 0 0 8 8zM440 64H336l-33.6-44.8A48 48 0 0 0 264 0h-80a48 48 0 0 0-38.4 19.2L112 64H8a8 8 0 0 0-8 8v16a8 8 0 0 0 8 8h24v368a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V96h24a8 8 0 0 0 8-8V72a8 8 0 0 0-8-8zM171.2 38.4A16.1 16.1 0 0 1 184 32h80a16.1 16.1 0 0 1 12.8 6.4L296 64H152zM384 464a16 16 0 0 1-16 16H80a16 16 0 0 1-16-16V96h320zm-168-32h16a8 8 0 0 0 8-8V152a8 8 0 0 0-8-8h-16a8 8 0 0 0-8 8v272a8 8 0 0 0 8 8z" class=""></path></svg></a></span><?php echo $c->company_name;?></td></tr>
				<?php
						}
					}
				?>
				</tbody>
			</table>
		</div>		
		<div id="contact">
			<table class='contact' id="tblContact">
				<thead><tr><th data-count="<?php echo count($contact);?>">Contacts Data <?php echo count($contact);?></th></tr></thead>
				<tbody>
				<?php 
					if(count($contact)>0){
						foreach($contact as $c){
							$list = json_decode($c->list);
							if(count($list) > 0){
								foreach($list as $l){
					?>
									<tr id="<?php echo $l->id;?>" data-company="<?php echo $c->company_id?>"><td><?php echo $l->first_name;?> <?php echo $l->last_name;?></td></tr>
					<?php
								}
							}
						}
					} 
				?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-60">
		<h3 style='text-align:left;'>Server Notification <span class='notification' style='float:right'></span></h3>		
		<div style="float:left:width:100%;">
			<table id="api_notification" class='table' cellpadding="0" cellspacing="0" style="width:100% !important;">
				<thead>
					<tr>
						<th style="width:12%">Name</th>
						<th style="width:8%">Status</th>
						<th style="width:16%">findThat</th>
						<th style="width:16%">voilanorbert</th>
						<th style="width:16%">hunter</th>
						<th style="width:16%">anymailfinder</th>
						<th style="width:16%">snov</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>			
		</div>		
	</div>
</div>
<script>
const __baseUrl = '<?php echo $Layout->baseUrl?>';
	function addMessage(m,t){
		const n = document.getElementsByClassName('notification');
		if(n.length > 0){
			n[0].innerText = m;
		}
	}
	function foundApiMessage(m){
		/*if(m != ""){
			try{
				let parseMessage = JSON.parse(m);
				console.log(parseMessage);
				let val = Object.values(parseMessage);
				let html = "<tr>";
				val.forEach(e => {
					html += "<td>"+e+"</td>";
				})
				html += "</tr>";				
				jQuery("#api_notification tbody").append(html);
			}catch(e){
				console.log(e);
			}			
		}*/
		/*if(typeof tblNotification == "object"){
			tblNotification.destroy();
		}*/
		
		jQuery.ajax({
			type:'GET',
			url: __baseUrl+'opportunity/get_email_notification',
			dataType:'json',
			success: function (data) {
				if(typeof tblNotification == "object"){
					tblNotification.destroy();
				}
				jQuery("#api_notification tbody").empty();
				if(data.length > 0){
					let htmlTR = "";
					data.forEach( n => {
						let status = (n.status)==0?'Queue':(n.status)==1?'Progress':'Done';
						
						htmlTR += "<tr>";
						htmlTR += "<td>"+n.name+"</td>";
						htmlTR += "<td>"+status+"</td>";
						htmlTR += "<td>"+n.findThatAPI+"</td>";
						htmlTR += "<td>"+n.voilanorbertAPI+"</td>";
						htmlTR += "<td>"+n.hunterAPI+"</td>";
						htmlTR += "<td>"+n.anymailfinderAPI+"</td>";
						htmlTR += "<td>"+n.snovAPI+"</td>";						
						htmlTR += "</tr>";
					});
					jQuery("#api_notification tbody").html(htmlTR);
					tblNotification = initialDataTable('api_notification',tblNotification, '87vh');
				}				
			}
		});		
	}
	function addHeadingMessage(m,t){
		let message = m.replace("@@"," Wait for: ");
		message +=" seconds";
		switch(t){
			case 0:
				break;
			case 1:
				jQuery("#find").find('span.heading').html(message);
				break;
		}
	}
	function deleteFromQueue(o){
		let $this = o.parents('tr');
		check = confirm("Are you sure?");
		if(check){
			jQuery.ajax({
				type:'POST',
				url: __baseUrl+'opportunity/delete_company_search_people_from_queue',
				data: {id:$this.attr('id'),company:$this.attr('data-company')},
				success: function (data) {
					if(data > 0){
						tblfind.row($this).remove().draw();
						let counter = jQuery("#tblFindContacts_wrapper .dataTables_scrollHeadInner").find('th[data-count]').attr('data-count');
						counter -=1;
						jQuery("#tblFindContacts_wrapper .dataTables_scrollHeadInner").find('th[data-count]').attr('data-count',counter).html('Contact '+counter);
					}				
				}
			});
		}		
	}
	function removeFromList(name, c){
		let counter = 0;
		if(c == 5){
			console.log("Notification",name,c);
			jQuery("#tblContact").find('tbody tr').each(function(c, i){
				var $this = jQuery(this);
				console.log($this.find('td').eq(0).text(),name);
				if(jQuery.trim($this.find('td').eq(0).text()) == jQuery.trim(name)){
					console.log("USER FIND");
					tblCon.row($this).remove().draw();
					return false;
				}
			});			
			counter = jQuery("#tblContact_wrapper .dataTables_scrollHeadInner").find('th[data-count]').attr('data-count');
			counter -=1;
			jQuery("#tblContact_wrapper .dataTables_scrollHeadInner").find('th[data-count]').attr('data-count',counter).html('Contact '+counter);
		}
	}
	function deleteAllFromQueue(){
		check = confirm("Are you sure?");
		if(check){
			console.log("Delete all...");
			jQuery.ajax({
				type:'POST',
				url: __baseUrl+'opportunity/delete_all_company_search_people_from_queue',
				data: {},
				success: function (data) {
					if(data > 0){
						let counter = jQuery("#tblFindContacts_wrapper .dataTables_scrollHeadInner").find('th[data-count]').attr('data-count');
						counter -=1;
						jQuery("#tblFindContacts_wrapper .dataTables_scrollHeadInner").find('th[data-count]').attr('data-count',counter).html('Contact '+counter);
						tblfind
						.clear()
						.draw();
					}				
				}
			});
		}
	}
	let tblC,tblfind,tblCon,tblNotification;
	jQuery(document).ready(function(){
		clickListner();
		jQuery("#company,#find,#contact,#owler").css("height","29vh");
		tblC = initialDataTable('tblcompany',tblC);
		tblfind = initialDataTable('tblFindContacts',tblfind);
		tblCon = initialDataTable('tblContact',tblCon);
		tblNotification = initialDataTable('api_notification',tblNotification, '87vh');
	});
	$(window).on('resize', function () {
		tblC.columns.adjust();
		tblfind.columns.adjust();
		tblCon.columns.adjust();
		tblNotification.destroy;
		setTimeout(() => {
			jQuery("#api_notification").find("th").css("width","");
			tblNotification = initialDataTable('api_notification',tblNotification, '87vh');
		},10);
		
    });

	function initialDataTable(c,e,h){
		if(typeof h == 'undefined'){
			h = '18vh';
		}
		e = $('#'+c).DataTable({
			fixedHeader: true,
			scrollY:        h,
			scrollX: false,
			scrollCollapse: true,
			paging:         false,
			searching:false,
			info:false,
			order:[],
			destroy:true,
			responsive: true,
			"oLanguage": {"sZeroRecords": "", "sEmptyTable": ""}
		});
		return e;
	}
	function clickListner(){
		jQuery("#connectCompany").find("th").off("click").on("click",sortTable);
	}
	function sortTable() {
		var table, rows, switching, i, x, y, shouldSwitch;
		table = document.getElementById("connectCompany");
		switching = true;
		while (switching) {		
			switching = false;
			rows = table.rows;		
			for (i = 1; i < (rows.length - 1); i++) {			
				shouldSwitch = false;				
				x = rows[i].getElementsByTagName("TD")[0];
				y = rows[i + 1].getElementsByTagName("TD")[0];			
				if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {				
					shouldSwitch = true;
					break;
				}
			}
			if (shouldSwitch) {			
				rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
				switching = true;
			}
		}
	}
	function updatePeopleScrapping(o){
		let dataStatus = parseInt(o.attr('data-status'));
			if(dataStatus == 1){
				dataStatus = 0;
			} else {
				dataStatus = 1;
			}
		jQuery.ajax({
			type:'POST',
			url: __baseUrl+'opportunity/update_scrapping_people_button',
			data: {type:3,status:dataStatus},
			success: function (data) {
				if(data > 0){
					o.attr('data-status',dataStatus);
					if(dataStatus == 0){
						o.text('Stop Scrapping People');
						console.log("Running");
						/*Run scrapping company people*/
						window.parent.sendCompanyPeopleRequest();
					} else {
						o.text('Continue Scrapping People');
					}
				}				
			}
		});	
	}
	window.addEventListener('DOMContentLoaded', (event) => {
		let txtMin = document.getElementById("min");
		let txtMax = document.getElementById("max");
		txtMin.addEventListener('keyup', function(e){
			if(txtMin.value > 0){
				console.log("TExtMin:"+txtMin.value);
				updateMinMax(txtMin.value,txtMax.value);
			}
		});
		
		txtMax.addEventListener('keyup', function(e){
			if(txtMax.value > 0){
				console.log("TExtMin:"+txtMax.value);
				updateMinMax(txtMin.value,txtMax.value);
			}
		});
		foundApiMessage('');
	});
	function updateMinMax(min,max){
		jQuery.ajax({
			type:'POST',
			url: __baseUrl+'opportunity/update_scrapping_timmer',
			data: {min:min,max:max},
			success: function (data) {
				if(data > 0){
					console.log("MINMAX:",min,max);
				}				
			}
		});	
	}
</script>
</body>