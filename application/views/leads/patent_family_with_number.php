<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/style_new_without_compress.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
<link href="<?php echo $Layout->baseUrl; ?>public/family.css" rel="stylesheet"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo $Layout->baseUrl; ?>public/tiff.min.js"></script>
<script src="<?php echo $Layout->baseUrl; ?>public/family.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" ></script>
<script src="<?php echo $Layout->baseUrl; ?>public/dragscroll.js" ></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//d3js.org/d3.v4.min.js"></script>
<script id="accordion_template" type="text/x-handlebars-template">
	<div id="accordionExample">
		<div class="container_w">
			<div class="row">
				<h6 id="heading" class=''></h6>
			</div>
			<a href='javascript://' class='data-tab-icon' class='relative rightM20'><i class='fa fa-expand'></i></a>
		</div>
		<ul class="nav nav-tabs" role="tablist" id="patTabs">
		  <li class="nav-item">
			<a class="nav-link active" id="date-tab" data-toggle="tab" href="#date" role="tab" aria-controls="date" aria-selected="true">Data</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="abstract-tab" data-toggle="tab" href="#abstract" role="tab" aria-controls="abstract" aria-selected="false">Abstract</span></a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="claim-tab" data-toggle="tab" href="#claim" role="tab" aria-controls="claim" aria-selected="false">Claim</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="figure-tab" data-toggle="tab" href="#figure" role="tab" aria-controls="figure" aria-selected="false">Figure</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="assignments-tab" data-toggle="tab" href="#assigments" role="tab" aria-controls="assigments" aria-selected="false">Assigments</a>
		  </li>
		</ul>
		<div class="tab-content" id="myTabContent">
		  <div class="tab-pane fade show active" id="date" role="tabpanel" aria-labelledby="date-tab"><p></p></div>
		  <div class="tab-pane fade" id="abstract" role="tabpanel" aria-labelledby="abstract-tab"><p></p></div>
		  <div class="tab-pane fade" id="claim" role="tabpanel" aria-labelledby="claim-tab"><p></p></div>
		  <div class="tab-pane fade" id="figure" role="tabpanel" aria-labelledby="figure-tab"><p></p></div>
		  <div class="tab-pane fade" id="assigments" role="tabpanel" aria-labelledby="assignments-tab"><p></p></div>
		</div>
	</div>
</script>
<script>
var baseUrl = '<?php echo $Layout->baseUrl;?>';
function findPatentFamily() {
	jQuery(".patent_family_on_call").empty();
	var patentNumber = jQuery("#txt_patent_number").val();
	if(patentNumber != "" && patentNumber.length > 6) {
		jQuery("#log_message").addClass("show").removeClass("hide").html("Please wait...");
		jQuery.ajax({
			url:baseUrl+'leads/family_data/'+patentNumber,
			type:'GET',
			cache:false
		})
		.done(function(data,textStatus,xhr){			
			callPatentFamilyData(patentNumber);
		});	
	}
}
function passContainerID(t){
	var mainContainerID = "";
	var parentContainerID = "";
	if(t != "all"){
		mainContainerID = "counter_"+t+"_patent_block";
		parentContainerID = "counter_"+t;
	} else {
		mainContainerID = "all_patent_block";
		parentContainerID = "all_counterparts_data";
	}
	jQuery('.patent_family_on_call').attr("id",mainContainerID);
	jQuery('.main_c').attr("id",parentContainerID);
}
function callPatentFamilyData(t) {
	jQuery("#log_message").addClass("show").removeClass("hide").html("Loading...");
	passContainerID(t);
	var apiURL = baseUrl+'leads/family_illustration_data/'+t;
	jQuery.ajax({
		url:apiURL,
		type:'GET',
		cache:false,
		dataType:'json'
	})
	.done(function(response){
		if(response.status == 200 && typeof response.data._jsonRectangles != "undefined"){
			jQuery("#log_message").removeClass("show").addClass("hide").html("");
			jQuery("#legend,#connection_arrow").show();
			drawIllustration(t,response.data);
		} else {
			jQuery("#log_message").html("No record found");
		}
	});
}
jQuery(document).ready(function(){
	var number = '<?php echo $patent_number;?>';
	if(number != "all") {
		jQuery("#txt_patent_number").val(number);
	}
	callPatentFamilyData(number);
	checkBodyClick();
	jQuery( "#slider" ).slider({
		min: 15,
		max: 150,
		step: 15,
		value:30,
		slide: function( event, ui ) {
			var pNumber = jQuery("#txt_patent_number").val();
			_defaultGap =  ui.value;
			_mainX = 0;
			_width = 200+70;
			
			jQuery.each(window[pNumber+'_jsonRectangles'],function(r,jsR){
				if(r==0 || jsR.same===false){
					_mainX = jsR.x_axis;
				} else if(jsR.same===true){
					_prevX = window[pNumber+'_jsonRectangles'][r-1].x_axis;
					_prevX  = parseInt(_prevX) + 200 + _defaultGap;
					_width +=_prevX;
					window[pNumber+'_jsonRectangles'][r].x_axis = _prevX;
				}
			});
			_width +=100;
			removedIllustration(pNumber);
			drawImage(pNumber);
		}
	});
});
function checkBodyClick(){
	let body = document.getElementsByTagName('body');
	body[0].addEventListener('click',function(e) {
		const _getTarget = $(e.target);
		/*console.log(e);
		console.log(_getTarget);*/
		_controlKey = false;
		if (e.ctrlKey){
			_controlKey = true;
		}
		if(_getTarget.length>0){				
			try {
				const _id = _getTarget[0].id;
				const targetE = _getTarget[0];
				const _className = _getTarget[0].className;
				/*console.log(_className);	*/	
				if(typeof targetE.parentNode != "undefined" && typeof targetE.parentNode.parentNode != "undefined" && typeof targetE.parentNode.parentNode.className != "undefined"){
					const _cClass = targetE.parentNode.parentNode.className;
					/*console.log('ParentClass:'+_cClass);*/
					if(_cClass !='container_w' && _cClass !='tool_open' && _cClass !='menu-tabs-contents' && _cClass !='filetree' && _cClass.indexOf('tab-pane')<0 && _cClass.indexOf('ui-draggable')<0 && _cClass.indexOf('search-form-help-text')<0 && _cClass.indexOf('tool_open')<0 ){
						/*console.log('A'+_id+'B');	*/	
						_nodeName = targetE.nodeName;
						/*console.log('A'+_nodeName+'B');*/
						if(_id!="undefined" || _nodeName!="undefined" || _className.baseVal!="undefined" || _className!=""){
							if(_nodeName!="path" && _nodeName!="rect" && _nodeName!="text" && _nodeName!="image" && _className.baseVal!="text_marker" && _className.baseVal!="data-tab-icon" && _nodeName!="I" && _id!="claim-tab"&& _id!="assignments-tab" && _id!="date-tab" && _id!="abstract-tab" && _id!="figure-tab" && _id!="date" && _id!="abstract" && _id!="claim" && _id!="figure" && _id!="assigments"  && _nodeName!="TD" && _nodeName!="TR" && _nodeName!="P" && _nodeName!="EMBED" && _className!="row" && _className!="hitarea" && _nodeName!="circle" && _nodeName!="tspan" && _nodeName!="LI" && _nodeName!="H6" && _id!="accordionExample" && _id!="message" && _nodeName!="U" && _id!="menuTabSyndication"){
								/*console.log("Items refreshed");*/
								refreshedItems();
							}	
						}
						
						if(_className.baseVal!="text_marker" &&  _nodeName!="rect"  && _nodeName!="text" && _nodeName!="image" && _className.baseVal!="data-tab-icon" && _nodeName!="I" && _id!="claim-tab"&& _id!="assignments-tab" && _id!="date-tab" && _id!="abstract-tab" && _id!="figure-tab" && _id!="date" && _id!="abstract" && _id!="claim" && _id!="figure" && _id!="assigments"  && _nodeName!="TD" && _nodeName!="TR" && _nodeName!="P" && _nodeName!="EMBED" && _className!="row" && _className!="hitarea" && _nodeName!="circle" && _nodeName!="tspan" && _nodeName!="LI"  && _nodeName!="H6"  && _id!="accordionExample" && _id!="message" && _nodeName!="U" && _id!="menuTabSyndication"){
							/*console.log("NODE:");*/
							if($('.search-form-help-text').length>0){
								$('.search-form-help-text').remove();
							}
							clearedOtherBold();
						}
					}
				} else {
					if(_id == "popup_container"){
						$("#"+_id).find('.slidebar-close_b,.slidebar-close_a').trigger("click");
					}
				}
			}catch(e) {
				console.log(e);
			}
		}	
	});
}
function enableDisableConnection(o){
	_string = "";
	if(_showConnections===true){
		_showConnections = false;
		_string = "Enable Connection";
	}else {
		_showConnections = true;
		_string = "Disable Connection";
	}
	//o.text(_string);
	if(_showConnections===true){
		$('.connection').show();
		$("#btnArrow").show();
		$("input[name='rd_arrow']").removeAttr('disabled');
	} else {
		$('.connection').hide();
		$("input[name='rd_arrow']").attr('disabled','disabled');
	}
	/*removedIllustration();
	createIllustration();*/
}
function enableDisableArrow(o){ 
	_string = "";
	if(_showConnections===true){
		if(_showArrow===true){
			_showArrow = false;
			_string = "Enable Arrow";
		}else {
			_showArrow = true;
			_string = "Disable Arrow";
		}
		//o.text(_string);
		if(_showArrow===true){
			$('.connection').each(function(){
				_row = jQuery(this);
				_row.attr("marker-end",'url(#markerREC_'+_row.attr("data-orgstroke")+')');
			});
		} else {
			$('.connection').removeAttr("marker-end");
		}
		
		/*removedIllustration();
		createIllustration();*/
	}
}
</script>
<style>
body{overflow:hidden;}
input{border:1px solid #dfe8f1 !important}
</style>
</head>
<body>
<div id="legend" class="col-lg-12" style="display:none;">
	<ul class="nav">
		<li><span class='sm-width3' style="background-color:#800000;"></span><span style='color:#800000;margin-left:5px'>CIP</span></li>
		<li><span class='sm-width3' style="background-color:#F08080;"></span><span style='color:#800000;margin-left:5px'>DIV</span></li>
		<li><span class='sm-width3' style="background-color:#CD5C5C;"></span><span style='color:#CD5C5C;margin-left:5px'>REX</span></li>
		<li><span class='sm-width3' style="background-color:#008000;"></span><span style='color:#008000;margin-left:5px'>CON</span></li>
		<li><span class='sm-width3' style="background-color:#228B22;"></span><span style='color:#228B22;margin-left:5px'>REI</span></li>
		<li><span class='sm-width3' style="background-color:#800080;"></span><span style='color:#800080;margin-left:5px'>PRO</span></li>
		<li><span class='sm-width3' style="background-color:#FA8072;"></span><span style='color:#FA8072;margin-left:5px'>SUB</span></li>
		<li><span class='sm-width3' style="background-color:#000080;"></span><span style='color:#000080;margin-left:5px'>SER</span></li>
		<li><span class='sm-width3' style="background-color:#FF4500;"></span><span style='color:#FF4500;margin-left:5px'>NST</span></li>
		<li><span class='sm-width3' style="background-color:#FFA500;"></span><span style='color:#FFA500;margin-left:5px'>RIC</span></li>
		<li><span class='sm-width3' style="background-color:#808000;"></span><span style='color:#808000;margin-left:5px'>RID</span></li>
		<li><span class='sm-width3' style="background-color:#DAA520;"></span><span style='color:#DAA520;margin-left:5px'>which is Patented claims the benefit of</span></li>
		<li><span class='sm-width3' style="background-color:#696969;"></span><span style='color:#696969;margin-left:5px'>which is Abandoned claims the benefit of</span></li>
		<li><span class='sm-width3' style="background-color:#9400D3;"></span><span style='color:#9400D3;margin-left:5px'>which is Pending claims the benefit of</span></li>
		<li><span class='sm-width3' style="background-color:#32CD32;"></span><span style='color:#32CD32;margin-left:5px'>which is Published claims the benefit of</span></li>
	</ul>
</div>
<div class='col-lg-12' style='margin-bottom:20px;display:none;' id="connection_arrow">
	<div class="row">
		<div class="col-lg-1">
			<span><input type="checkbox" name="rd_connection" onclick="enableDisableConnection(jQuery(this))"/><span style="position:relative;top: -2px;left: 5px;"><svg aria-hidden="true" data-prefix="fas" data-icon="minus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-minus fa-w-14 fa-2x" style="width:15px;"><path fill="currentColor" d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" class=""></path></svg></span></span>
			<span style='margin-left:10px;'>
				<input type="checkbox" name="rd_arrow" onclick="enableDisableArrow(jQuery(this))"/><span style="position:relative;top: -2px;left: 5px;"><svg aria-hidden="true" data-prefix="fas" data-icon="long-arrow-alt-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-long-arrow-alt-right fa-w-14 fa-2x" style="width:15px;">><path fill="currentColor" d="M313.941 216H12c-6.627 0-12 5.373-12 12v56c0 6.627 5.373 12 12 12h301.941v46.059c0 21.382 25.851 32.09 40.971 16.971l86.059-86.059c9.373-9.373 9.373-24.569 0-33.941l-86.059-86.059c-15.119-15.119-40.971-4.411-40.971 16.971V216z" class=""></path></svg></span>
			</span>
		</div>
		<div class="col-lg-10">
			<div id="slider"></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			
			<input type="text" name="txt_patent_number" id="txt_patent_number" placeholder="Patent Number" class="form-control pull-left" style="width:150px;" value=""/>
			<button onclick="findPatentFamily();" id="btnGo" class="btn btn-primary pull-left" style="margin-left:10px;" type="button">Re-scrape patent data</button>
			<span id="log_message" class="pull-left" style="width:100px;margin-left:10px;"></span>
		</div>
	</div>
</div>
<div class="main_c">
	<div class='patent_family_on_call dragscroll'></div>
</div>
</body>
</html>