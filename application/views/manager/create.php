<?php 
	$name = $full_project_details['project_details']->project_name;
?>
<!DOCTYPE html>
<html lang ="en">
<head>

    <meta charset="UTF-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title> Start Project </title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Favicons -->

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $Layout->awsUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $Layout->awsUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $Layout->awsUrl?>public/images/icons/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="<?php echo $Layout->awsUrl?>public/images/icons/favicon.ico">
<link rel="shortcut icon" href="<?php echo $Layout->awsUrl?>public/images/icons/favicon.ico">


    <!-- HELPERS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/animate.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/backgrounds.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/boilerplate.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/border-radius.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/page-transitions.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/spacing.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/utils.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/colors.css">

<!-- ELEMENTS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/badges.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/content-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/dashboard-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/forms.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/images.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/info-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/invoice.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/loading-indicators.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/menus.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/panel-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/response-messages.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/responsive-tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/ribbon.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/social-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/tables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/tile-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/elements/timeline.css">

<!-- FRONTEND ELEMENTS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/frontend-elements/blog.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/frontend-elements/cta-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/frontend-elements/feature-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/frontend-elements/footer.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/frontend-elements/hero-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/frontend-elements/icon-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/frontend-elements/portfolio-navigation.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/frontend-elements/pricing-table.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/frontend-elements/sliders.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/frontend-elements/testimonial-box.css">

<!-- ICONS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/icons/fontawesome/fontawesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/icons/linecons/linecons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/icons/spinnericon/spinnericon.css">

<!-- WIDGETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/accordion-ui/accordion.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/calendar/calendar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/carousel/carousel.css">

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/charts/justgage/justgage.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/charts/morris/morris.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/charts/piegage/piegage.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/charts/xcharts/xcharts.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/slidebars/slidebars.css">




<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/chosen/chosen.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/colorpicker/colorpicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/datatable/datatable.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/datepicker/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/datepicker-ui/datepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/daterangepicker/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/dialog/dialog.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/dropdown/dropdown.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/dropzone/dropzone.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/file-input/fileinput.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/input-switch/inputswitch.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/input-switch/inputswitch-alt.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/ionrangeslider/ionrangeslider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/jcrop/jcrop.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/jgrowl-notifications/jgrowl.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/loading-bar/loadingbar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/maps/vector-maps/vectormaps.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/markdown/markdown.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/modal/modal.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/multi-select/multiselect.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/multi-upload/fileupload.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/nestable/nestable.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/noty-notifications/noty.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/popover/popover.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/pretty-photo/prettyphoto.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/progressbar/progressbar.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/range-slider/rangeslider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/slider-ui/slider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/summernote-wysiwyg/summernote-wysiwyg.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/tabs-ui/tabs.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/theme-switcher/themeswitcher.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/timepicker/timepicker.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/tocify/tocify.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/tooltip/tooltip.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/touchspin/touchspin.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/uniform/uniform.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/wizard/wizard.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/xeditable/xeditable.css">

<!-- FRONTEND WIDGETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/layerslider/layerslider.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/owlcarousel/owlcarousel.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/widgets/fullpage/fullpage.css">

<!-- SNIPPETS -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/snippets/chat.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/snippets/files-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/snippets/login-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/snippets/notification-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/snippets/progress-box.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/snippets/todo.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/snippets/user-profile.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/snippets/mobile-navigation.css">

<!-- Frontend theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/themes/frontend/layout.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/themes/frontend/color-schemes/default.css">

<!-- Components theme -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/themes/components/border-radius.css">

<!-- Frontend responsive -->

<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/responsive-elements.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->awsUrl?>public/helpers/frontend-responsive.css">

    <!-- JS Core -->

    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-ui-core.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-ui-widget.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-ui-mouse.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-ui-position.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/transition.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-core/jquery-cookie.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/modal/modal.js"></script>
    <script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/jgrowl-notifications/jgrowl.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/dialog/dialog.js"></script>
<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/slidebars/slidebars.js"></script>


<script type="text/javascript">
	(function(f){function l(g,h){function d(a){if(!e){e=true;c.start&&c.start(a,b)}}function i(a,j){if(e){clearTimeout(k);k=setTimeout(function(){e=false;c.stop&&c.stop(a,b)},j>=0?j:c.delay)}}var c=f.extend({start:null,stop:null,delay:400},h),b=f(g),e=false,k;b.keypress(d);b.keydown(function(a){if(a.keyCode===8||a.keyCode===46)d(a)});b.keyup(i);b.blur(function(a){i(a,0)})}f.fn.typing=function(g){return this.each(function(h,d){l(d,g)})}})(jQuery);
    $(window).load(function(){
        setTimeout(function() {
            $('#loading').fadeOut( 400, "linear" );
        }, 300);
    });
	window.showMessageOnFly = function(mesg,clas){
		jQuery('#sb-site').prepend('<div class="col-lg-12 alert '+clas+' noticeInfoAlert mrg5T" style="position:absolute;z-index:9999">'+mesg+'</div>');setTimeout(function(){jQuery('.noticeInfoAlert').remove()},3000);
	}
	function call(url,type,data,fn,datatype){
		jQuery.ajax({
			type:type,
			crossDomain: true,
			url:url,
			data:data,
			cache:false,
			dataType:datatype,
			success:fn
		});
	}
	jQuery(document).ready(function(){
		_h = jQuery(window).height();
		jQuery("#terms_page").css("height",_h-20);
		if(jQuery(window).width()<1200){
			_w = jQuery(window).width();
			jQuery("#terms_page").css("width",_w-100);
		}
		setTimeout(function(){jQuery('.sb-toggle-right').eq(0).trigger('click');},500);
	});
</script>
<style>
.light-blue{
	background-color:#E6E6FC !important;
}
.light-blue-1{
	background-color:#D2D2F6 !important;
}
.sb-slidebar{
	overflow-y:hidden;
}
.scroll-container {
    width: 100%;
    height: 250px;
    margin: 1rem 0 1rem;
    overflow: hidden;
}
</style>
</head>
<body>
<div id="loading">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/dropzone/dropzone.js"></script>
<div id="page-wrapper">
	<div class="panel">
		<div class="panel-body">
			<div id="sb-site"></div>
			<div class='example-box-wrapper'>
				<div class='row'>
					<div class='col-lg-4'>
						<div class='form-group'>
							<label class='col-lg-2'>Client:</label>
							<div class='col-lg-10'>
							<select id='drpClient' name='drp_client' class='form-control'>
								<option value='0'>-- Select Client --</option>
								<?php 
									foreach($my_clients as $client){
								?>
									<option value='<?php echo $client->id;?>'><?php echo $client->first_name.' '.$client->last_name;?></option>
								<?php
									}
								?>
							</select>
							</div>
						</div>
						<div id="price_list" class='col-lg-12 mrg5T'>
						
						</div>
						<div class='form-group'>
						<button onclick='showPriceList()' class='btn btn-primary col-lg-5 mrg10T'>Add Price for Unfreeze Column</button>
						</div>
					</div>
				</div>
			</div>
			<div class="example-box-wrapper show" id='upload_file_wrapper'>				
				<h4>Create a project</h4>
				<h1>Drag&amp;Drop CSV file</h1>
				<div class="row" id="dropzone-example">
					<?php echo form_open('manager/upload_file',array('class'=>'dropzone bg-gray col-md-10 center-margin','id'=>'demoUpload'));?>
					<?php echo form_close();?>
				</div>
			</div>
			<div class="example-box-wrapper hide" id='show_file_wrapper'>	
				<div class="scroll-container">
					<div id='contacts_table' class="hot handsontable htRowHeaders htColumnHeaders"></div>					
				</div>
				<div class="scroll-container">
					<div id='minor_table' class="hot handsontable htRowHeaders htColumnHeaders" style='margin-top:10px;'></div>
				</div>
			</div>
		</div>
	</div>
</div>
<link  rel="stylesheet" media="screen" href="https://s3.amazonaws.com/handsontable/handsontable_new/dist/handsontable.full.min.css">
<link  rel="stylesheet" media="screen" href="https://s3.amazonaws.com/handsontable/handsontable_new/dist/pikaday/pikaday.css">
<script  src="https://s3.amazonaws.com/handsontable/handsontable_new/dist/pikaday/pikaday.js"></script>
<script  src="https://s3.amazonaws.com/handsontable/handsontable_new/dist/moment/moment.js"></script>
<script  src="https://s3.amazonaws.com/handsontable/handsontable_new/dist/zeroclipboard/ZeroClipboard.js"></script>
<script  src="https://s3.amazonaws.com/handsontable/handsontable_new/dist/handsontable.full.min.js"></script>

<script>
	function showPriceList(){
		if(_selectedHeadings.length>0){
			jQuery("#price_list").html('');
			for(s=0;s<_selectedHeadings.length;s++){
				entryShow = true;
				if(colsFreeze.length>0){
					for(c=0;c<colsFreeze.length;c++){
						if(colsFreeze[c] == _selectedHeadings[s].position){
							entryShow = false;
						}
					}
				}
				if(entryShow===true){
					jQuery("#price_list").append("<div class='form-group'><label class='col-lg-4'>Price for "+_selectedHeadings[s].heading+":</label><div class='col-lg-8 mrg5B'><input type='hidden' name='price_col[]' value='"+_selectedHeadings[s].position+"'/><input type='text' name='col_price[]' class='form-control col-lg-8' value=''/></div></div>")
				}
			}
		} else {
			alert("Please select heading of columns");
		}
	}
	Dropzone.autoDiscover = false;
	var fileGetData = "",colsFreeze=[];
	$("#demoUpload").dropzone({
            url: jQuery("#demoUpload").attr('action'),
            addRemoveLinks: true,
            maxFiles: 1,
			uploadMultiple: false,
			maxFilesize: 10240,
            acceptedFiles: ".csv",
            init: function(){
                this.on("success", function(file, responseText) {
					data = jQuery.parseJSON(responseText);
					if(data.length>0){
						if(data[data.length-1]===false){
							data.splice(data.length-1,1);
						}
						fileGetData = data;
						jQuery("#upload_file_wrapper").addClass("hide").removeClass("show");
						jQuery("#show_file_wrapper").addClass("show").removeClass("hide");
						showTableToUser(data);
					} else {
						alert("Sorry! unable to read file.");
					}
                });
                this.on("removedfile", function(file) {
					alert("Remove");
					console.log(file);
                    //....
                });
            },
        });
	var
    cntTable = document.getElementById('contacts_table'),
    minTable = document.getElementById('minor_table'),
    maxed = true,
    resizeTimeout,
    availableWidth,
    availableHeight,
    objHands,minHands,_selectedHeadings=[],_change = [],predefinedColumnsHeading = '<?php echo json_encode($column_heading)?>';
	function showTableToUser(data){
		objHands = new Handsontable(cntTable, {
			  data: data,
			  autoWrapCol:true,
			  wordWrap:true,
			  rowHeaders: false,
			  colHeaders: true,
			  minSpareRows: 0,
			  minSpareCols:26,
			  minCols: 26,
			  maxCols:26,
			  contextMenu: false,
			  afterGetColHeader: function (col,TH){
				  var instance =this;
				  var input = '',selectInput='';
				  if(jQuery(TH).find('input[type="checkbox"]').length==0){
					  input = document.createElement('input');
					  input.type='checkbox';
					  TH.appendChild(input);
				  } else {
					  input = jQuery(TH).find('input[type="checkbox"]').get(0);
				  }		
				  if(jQuery(TH).find('select').length==0){
					  selectInput = document.createElement('select');
					  selectInput.style.width='150px';
					  selectInput.setAttribute("data-col",col);
					  var option = document.createElement("option");
					  option.text = '';
					  option.value = 0;
					  selectInput.add(option);
					  if(predefinedColumnsHeading!=""){
						  try{
							  allOption = JSON.parse(predefinedColumnsHeading);
							  if(allOption.length>0){
								  for(a=0;a<allOption.length;a++){
									  var option = document.createElement("option");
									  option.text = allOption[a].heading;
									  option.value = allOption[a].id;
									  selectInput.add(option);
								  }
							  }
						  } catch(e){
							  console.log("Error:"+e);
						  }
					  }
					  TH.appendChild(selectInput);
				  } else {
					  selectInput = jQuery(TH).find('select').get(0);
				  }
				  Handsontable.Dom.addEvent(selectInput,'change',function(e){
					var headers = instance.getColHeader();
					console.log(headers);
					var selIndex = selectInput.selectedIndex;
					var getAttributeCol = selectInput.getAttribute("data-col");
					var selValue = selectInput.options[selIndex].value;
					var selText = selectInput.options[selIndex].text;
					if(_selectedHeadings.length>0){
						_entry = true;
						for(s=0;s<_selectedHeadings.length;s++){
							if(_selectedHeadings[s].position==getAttributeCol){
								_entry = false;
								_selectedHeadings[s].id = selValue;
								_selectedHeadings[s].heading = selText;
							}
						}
						if(_entry===true){
							sObject = {};
							sObject.id = selValue;
							sObject.heading = selText;
							sObject.position = getAttributeCol;
							_selectedHeadings.push(sObject);
						}
					} else {
						sObject = {};
						sObject.id = selValue;
						sObject.heading = selText;
						sObject.position = getAttributeCol;
						_selectedHeadings.push(sObject);
					}
					if(typeof objHands=="object"){
					   getCustomerData = objHands.getData();
					  } else {
						  if(typeof fileGetData=="object"){
							  getCustomerData = fileGetData;
						  } else {
							getCustomerData = JSON.parse(fileGetData);  
						  }
					  }
					console.log(selectInput.value);
					console.log("Selected Value:"+selValue);
					console.log("Selected Text:"+selText);
					console.log("Selected Col:"+getAttributeCol);
					showMinTable(getCustomerData);
				  });
				  Handsontable.Dom.addEvent(input, 'change', function (e){
					var headers = instance.getColHeader();						
						objHands.updateSettings({
							cells:function(row,col1,pro){
								var cellProperties = {};
								if(input.checked ==true){
									console.log(1);
									if(col1==col){
										if(colsFreeze.length>0){
											insertCol = true;
											for(co=0;co<colsFreeze.length;co++){
												if(colsFreeze[co]==col){
													insertCol = false;
												}
											}
											if(insertCol===true){
												colsFreeze.push(col);
											}
										} else {
											colsFreeze.push(col);
										}
										cellProperties.readOnly = true;
										return cellProperties;
									} else {
										if(colsFreeze.length>0){
											for(ch=0;ch<colsFreeze.length;ch++){
												if(colsFreeze[ch]==col1){
													cellProperties.readOnly = true;
													return cellProperties;
												}
											}
										}
									}
								} else {
									console.log(2);										
									if(colsFreeze.length>0){
										for(ch=0;ch<colsFreeze.length;ch++){
											if(colsFreeze[ch]==col){
												console.log("S3P:"+colsFreeze[ch]+'@'+ch);
												colsFreeze.splice(ch,1);
											}
										}
										for(ch=0;ch<colsFreeze.length;ch++){
											if(colsFreeze[ch]==col1){
												cellProperties.readOnly = true;
												return cellProperties;
											}
										}
									}
								}
							}
						});					
					});
			  },
			  afterRender:function(isForced){
				  if(isForced===true){
					  if(typeof minHands=="object"){
						  minHands.clear();
					  }
					  if(typeof objHands=="object"){
						   getCustomerData = objHands.getData();
					  } else {
						  if(typeof data=="object"){
							  getCustomerData = data;
						  } else {
							getCustomerData = JSON.parse(data);  
						  }
						  Handsontable.renderers.registerRenderer('negativeValueRendererMinor', negativeValueRendererMinor);
					  }		
					  showMinTable(getCustomerData);
				  }
			  }
			  
		});
	}
	function showMinTable(getCustomerData){
		showHeadingAll = true;
		if(_selectedHeadings.length>0){
			showHeadingAll = [];
			for(s=0;s<_selectedHeadings.length;s++){
				showHeadingAll[_selectedHeadings[s].position] = _selectedHeadings[s].heading;
			}
		}
		if(typeof minHands=="object"){
			minHands.destroy();
		}
		minHands = new Handsontable(minTable, {
					  data: getCustomerData,
					  autoWrapCol:true,
					  wordWrap:true,
					  minSpareRows: 0,
					  minSpareCols:26,
					  minCols: 26,
					  maxCols:26,
					  rowHeaders: false,
					  colHeaders: showHeadingAll,
					  contextMenu: false,
					  afterSelection: function (row, col, row2, col2) {
						  var meta = this.getCellMeta(row2, col2);
						  if (meta.readOnly) {
							this.updateSettings({fillHandle: false});
						  }
						  else {
							this.updateSettings({fillHandle: true});
						  }
					  },
					  cells: function (row, col, prop) {
						  if(colsFreeze.length>0){
							  enterChange  = false;
							  for(ch=0;ch<colsFreeze.length;ch++){
									if(colsFreeze[ch]==col){
										enterChange = true;
										var cellProperties = {};
										cellProperties.readOnly = true;
										return cellProperties;
									}
							  }
							  if(enterChange===false){
								  var cellProperties = {};
								  cellProperties.renderer = "negativeValueRendererMinor";
								  return cellProperties;
							  }
						  }
					  },
					  beforeChange:function(changes, source){
						 if(source=='edit'){
							 if(_change.length==0){
								 _change.push(changes);
							 } else {
								 _insert =true;
								 for(s=0;s<_change.length;s++){
									 if(_change[s][0][0]==changes[0]){
										 _insert = false;
									 }
								 }
								 if(_insert===true){
									 _change.push(changes);
								 }
							 }					 
						 }
					 }
			  });
	}
	function negativeValueRendererMinor(instance, td, row, col, prop, value, cellProperties){
		Handsontable.renderers.TextRenderer.apply(this, arguments);
		 if (!value || value === '') {
			td.style.background = '#EFEFEF';
			var cellProperties = {};
			cellProperties.readOnly=false;
			return cellProperties;
		}  else {
			if(value!=''){
				if(_change.length>0){
					_enter = false;
					for(i=0;i<_change.length;i++){								
						if(_change[i][0][0]==row && prop==_change[i][0][1]){
							td.style.background = '#fff';_enter = true;
							td.style.color = '#000';
							cellProperties.readOnly=false;
							return cellProperties;
						}
					}
					if(_enter==false){
						console.log("Row:"+row+' Prop:'+prop);
						td.innerHTML ='';
						td.style.background = '#000';
						cellProperties.readOnly=true;return cellProperties;
					}
				} else {
					td.innerHTML ='';
					td.style.background = '#000';
					cellProperties.readOnly=true;return cellProperties;
				}
			}
		}
	}
	
	
	function negativeValueRenderer(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
	
    if (!value || value === '') {
      td.style.background = '#EFEFEF';
	  var cellProperties = {};
	  cellProperties.readOnly=false;
	  return cellProperties;
    }  else {
		if(value!=''){
			if(col>3){				
				if(_change.length>0){
					_enter = false;
					for(i=0;i<_change.length;i++){								
						if(_change[i][0][0]==row && prop==_change[i][0][1]){
							td.style.background = '#fff';_enter = true;
							td.style.color = '#000';
							cellProperties.readOnly=false;
							return cellProperties;
						}
					}
					if(_enter==false){
						console.log("Row:"+row+' Prop:'+prop);
						td.innerHTML ='';
						td.style.background = '#000';
						cellProperties.readOnly=true;return cellProperties;
					}
				} else {
					td.innerHTML ='';
					td.style.background = '#000';
					cellProperties.readOnly=true;return cellProperties;
				} 				
			}			
		}
	}
  }
	/*var myDropzone = new Dropzone('div#dropzone-example',{
            url: jQuery("#demo-upload").attr('action'),
            addRemoveLinks: true,
            maxFiles: 1,
			uploadMultiple: false,
			maxFilesize: 10240,
            acceptedFiles: ".csv",
            init: function(){
                this.on("success", function(file, responseText) {
					console.log(responseText);
                });
                this.on("removedfile", function(file) {
					alert("Remove");
					console.log(file);
                    //....
                });
            },
        });*/
</script>
    <!-- FRONTEND ELEMENTS -->

<!-- Skrollr -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/skrollr/skrollr.js"></script>

<!-- Owl carousel -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/owlcarousel/owlcarousel.js"></script>
<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/owlcarousel/owlcarousel-demo.js"></script>

<!-- HG sticky -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/sticky/sticky.js"></script>

<!-- WOW -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/wow/wow.js"></script>

<!-- VideoBG -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/videobg/videobg.js"></script>
<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/videobg/videobg-demo.js"></script>

<!-- Mixitup -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/mixitup/mixitup.js"></script>
<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/mixitup/isotope.js"></script>

<!-- WIDGETS -->

<!-- Bootstrap Dropdown -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/dropdown/dropdown.js"></script>

<!-- Bootstrap Tooltip -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/tooltip/tooltip.js"></script>

<!-- Bootstrap Popover -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/popover/popover.js"></script>

<!-- Bootstrap Progress Bar -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/progressbar/progressbar.js"></script>

<!-- Bootstrap Buttons -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/button/button.js"></script>

<!-- Bootstrap Collapse -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/collapse/collapse.js"></script>

<!-- Superclick -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/superclick/superclick.js"></script>

<!-- Input switch alternate -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/input-switch/inputswitch-alt.js"></script>

<!-- Slim scroll -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/slimscroll/slimscroll.js"></script>

<!-- Content box -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/content-box/contentbox.js"></script>

<!-- Overlay -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/overlay/overlay.js"></script>

<!-- Widgets init for demo -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-init/widgets-init.js"></script>
<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/js-init/frontend-init.js"></script>

<!-- Theme layout -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/themes/frontend/layout.js"></script>

<!-- Theme switcher -->

<script type="text/javascript" src="<?php echo $Layout->awsUrl?>public/widgets/theme-switcher/themeswitcher.js"></script>

</body>
</html>






