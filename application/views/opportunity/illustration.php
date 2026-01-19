<?php 
$jsonRelations = array();
$jsonRectangles = array();
$searchPatent = $number;
$svgWidth = 500;
$svgHeight = 500;
if(strlen($searchPatent)>9){
	$searchPatent = substr($searchPatent,0,9);
}
$height = 72;
$width = 150;
$fS = false;
$countries = array();
if(count($family_data['country'])>0){
	foreach($family_data['country'] as $country){
		$countries[] = strtolower(strtoupper($country->publication_country));
	}
}
if(count($family_data['list'])>0){
	$cpCount = 0;
	$chCount = 1;
	for($i=0;$i<count($family_data['list']);$i++){
		$family = $family_data['list'][$i];
		$patentNumber = $family->patent_id;
		$search = false;
		if($patentNumber==$searchPatent){
			$search = true;
		}
		$publicationKind = strtoupper($family->publication_kind);
		$label = $patentNumber;
		$label = str_replace($publicationKind,'',strtoupper($label));
		$label = $label.$publicationKind;
		$family_data['list'][$i]->search = $search;
		$family_data['list'][$i]->label = $label;
		$family_data['list'][$i]->application_org_number = $family->application_number;
		$family_data['list'][$i]->type = "CIP";
		$countryCode = $family->publication_country;
		$outside = false;
		if(strtolower(strtoupper($countryCode))!="us"){
			$outside = true;
		}
		$family_data['list'][$i]->country = strtolower(strtoupper($countryCode));
		$family_data['list'][$i]->outside = $outside;
		$family_data['list'][$i]->type = "CIP";
		$same = false;
		$fillingDate = $family->filling_date;
		$previousFillingDate = "";
		if($i>0){
			$previousFillingDate = $family_data['list'][$i-1]->filling_date;
		}
		if($previousFillingDate == $fillingDate){
			$same = true;	
			$cpCount++;
			$w = $cpCount*185;
			$w = $w + 185;
			if($w>$svgWidth){
				$svgWidth = $w;
			}
		} else {
			$cpCount = 0;
		}
		$family_data['list'][$i]->same = $same;
		$family_data['list'][$i]->count = $cpCount;
		if($i==0){
			$x = 10;
			$y = 10;
		} else {
			$x = 10;
			$y = (int)$family_data['list'][$i-1]->y_axis + 140;
			if($same===true){
				$previousSame = $family_data['list'][$i-1]->same;
				if($previousSame==true){
					$x = (int)$family_data['list'][$i-1]->x_axis + 180;
					$y = (int)$family_data['list'][$i-1]->y_axis;
				} else {
					if($fS===false){
						if($cpCount==1){
							$x = 190;
						} else {
							$x = $family_data['list'][$i-1]->y_axis + 150;
						}
						$fS = true;
					} else {
						$x = 180;
					}					
				}
				$y = (int)$family_data['list'][$i-1]->y_axis;
			} else {
				$chCount++;
			}
		}
		$family_data['list'][$i]->x_axis = $x;
		$family_data['list'][$i]->y_axis = $y;
		if($i==0){
			if($search===false){
				$color = "#669900";
			} else {
				$color = "#ffbb33";
			}
		} else {
			if($outside===true){
				$color = "#33b5e5";
			} else {
				$color = "#ffbb33";
			}
		}
		$family_data['list'][$i]->color = $color;
		$family_data['list'][$i]->width = $width;
		$family_data['list'][$i]->height = $height;
		$claims = $family->claims;
		$abstract = $family->abstracts;
		$image = $family->images;
		if($image!=""){
			try{
				$images = json_decode($image);
				if(count($images)>0 && trim($images[0])!=""){
					$image = $images[0];
				}
			}catch(Exception $e){
				
			}
		}
		$publicationDate = $family->publication_date;
		$title = $family->title;
		if($publicationDate!=""){
			$publicationDate = substr($publicationDate,0,4).'-'.substr($publicationDate,4,2).'-'.substr($publicationDate,-2);
		}
		$applicationNumber = $family->application_country.$family->application_number.$family->application_kind;
		if(count($family_data['list'][$i]->relation)>0){
			foreach($family_data['list'][$i]->relation as $relation){
				$jsonRelations[] = $relation;
			}
		}
		/*unset*/
		unset($family_data['list'][$i]->claims);
		unset($family_data['list'][$i]->abstracts);
		unset($family_data['list'][$i]->images);
		unset($family_data['list'][$i]->title);
		/*End unset*/
		$claims = trim($claims);
		$abstract = trim($abstract);
		$claims = strip_tags($claims);
		$abstract = strip_tags($abstract);
		$claims = preg_replace("/;/", "",$claims);
		$claims = preg_replace("/'/", "",$claims);
		$claims = preg_replace("/\"/", "",$claims);
		$abstract = preg_replace("/;/", "",$abstract);
		$abstract = preg_replace("/'/", "",$abstract);		
		$abstract = preg_replace("/\"/", "",$abstract);		
		$title = preg_replace("/;/", "",$title);
		$title = preg_replace("/'/", "",$title);
		$title = preg_replace("/\"/", "",$title);
		$regex = '/(\s|\\\\[rntv]{1})/';
		$claims = preg_replace($regex, ' ', $claims);
		$abstract = preg_replace($regex, ' ', $abstract);	
		$title = preg_replace($regex, ' ', $title);	
		$family_data['list'][$i]->claims = trim($claims);
		$family_data['list'][$i]->abstract = trim($abstract);
		$family_data['list'][$i]->application_number = $applicationNumber;
		$family_data['list'][$i]->image = $image;
		$family_data['list'][$i]->title = trim($title);
		$family_data['list'][$i]->issue_date = $publicationDate;
	}
	$svgHeight = $chCount * 212;
	$jsonRectangles = $family_data['list'];
}
?>
<!DOCTYPE html>
<meta charset="utf-8">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//backyard.synpat.com/public/tiff.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" ></script>
<script src="http://backyard.synpat.com/public/dragscroll.js" ></script>
<style>
text {
  font-size:12px;font-family:arial;
}
.search-form-help-text{position:absolute;width:320px;padding:10px;border:1px solid #e4e4e4;z-index:999999;background:#fff;top:27px;box-shadow:0 0 10px 6px rgba(0,0,0,.1);border-radius:4px;right:0}.search-form-help-text dl,.search-form-help-text p,.search-form-help-text p a{font-size:15px}
.card-body {
	font-size: 14px;
	font-family: Arial,sans-serif;
}
.tab-content>.tab-pane{padding-top:10px; font-size:14px;font-family:Arial,sans-serif;color:#333;}
body{overflow:hidden;}
div#patent_block{overflow:scroll;min-width:500px;height:500px;}
#accordionExample,#accordionExample h6{font-size:14px !important;font-family:Arial,sans-serif !important;}
#accordionExample h6{text-decoration:underline;padding:0px;}
.nav-link{padding:.4em 9px;}
.table td, .table th{border:0px;padding: 0 0 10px 0;}
#abstract,#claim{line-height:1.40;}
::-webkit-scrollbar {
  -webkit-appearance: none;
  width: 7px;
}
::-webkit-scrollbar-thumb {
  border-radius: 4px;
  background-color: rgba(0, 0, 0, .5);
  -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
}	
body {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
	font-family:Arial,sans-serif;
}
</style>
<body>
<script src="http://d3js.org/d3.v3.min.js"></script>
<div id="patent_block" class='dragscroll'></div>
<script>
_width = <?php echo $svgWidth;?> + 50;
_height = '<?php echo $svgHeight;?>';
function msieversion(){
	var ua = window.navigator.userAgent;
	var msie = ua.indexOf("MSIE");

	if (msie > 0) // If Internet Explorer, return version number
	{
		return true;
		//alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
	}
	else  // If another browser, return 0
	{
		return false;
		//alert('otherbrowser');
	}

	return false;
}
function getNodePos(el)
{
    var body = d3.select('body').node();

    for (var lx = 0, ly = 0;
         el != null && el != body;
         lx += (el.offsetLeft || el.clientLeft), ly += (el.offsetTop || el.clientTop), el = (el.offsetParent || el.parentNode))
        ;
    return {x: lx, y: ly};
}
function tooltipOpen(a){
	if($('#'+a.label).length==0){
		 poke = false;
		 var offset = jQuery("#rec_"+a.label).offset();
		 var position = jQuery("#rec_"+a.label).position();
		 _b=0,_r=0;
		  _l = position.left;
		  _t = position.top + 80;


		/*_temp = position.left+310;
		 _l = position.left + 160;
		 _scrollLeft = jQuery("#patent_block").scrollLeft();
		 _t = position.top ;
		 _b=0,_r=0;
		 scrollX = body.w-100;
		 if(_temp>scrollX){
			 _l = _l - 310 - 160;
		 }*/
		 /*console.log(offset,position,scrollX,_temp,_l);*/
		/* 
		 var m = d3.mouse(root.node());
		 scr.x = window.scrollX;
		 scr.y = window.scrollY;
		 m[0] += svgpos.x;
		 m[1] += svgpos.y;
		   _t = 0,_b=0,_l=0,_r=0;
			 if (m[0] > scr.x + scr.w / 2) {
				 _r = (body.w - m[0] + dist.x);
			 }
			 else {
				_l = (m[0] + dist.x) ;
			 }

			 if (m[1] > scr.y + scr.h / 2) {
				 _b = (body.h - m[1] + dist.y);
			 }
			 else {
				 _t = (m[1] + dist.y);
			 }
			 if(_l==0 && _r<0){
				 _l = (m[0] + dist.x) - 100 ;
			 }	*/
			 var getTemplateAccordion = jQuery("#accordion_template").html();
		 $('html').find('.search-form-help-text').attr("id",a.label).remove();
		 $('html').append('<div id="'+a.label+'" class="search-form-help-text" style="top:'+_t+'px;left:'+_l+'px;right:'+_r+'px;bottom:'+_b+'px;width:300px;height:300px;overflow:hidden;overflow-y:auto;"></div>');
		 $('html').find('.search-form-help-text').append(getTemplateAccordion);
		 
		  $('html').find('.search-form-help-text').find("h6#heading").html(a.title);
		  _issueDate = "";
		  if(a.issue_date!=""){
			  _issueDate = moment(new Date(a.issue_date)).format('MMM,DD YYYY');
		  }	
		  _fillingDate = "";
		  if(a.filling_date!=""){
			  _fillingDate = moment(new Date(a.filling_date)).format('MMM,DD YYYY');
		  }
		 /* $('html').find('.search-form-help-text').find("h6#heading").append('<button type="button" onclick="jQuery(\'html\').find(\'.search-form-help-text\').remove();" class="close pull-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>');*/
		 $('html').find('.search-form-help-text').find('#date').html("<table class='table' style='width:auto !important;border:0px;'><tbody><tr><td>Priority:</td><td></td></tr><tr><td>Filed:</td><td>"+_fillingDate+"</td></tr><tr><td>Issued:</td><td>"+_issueDate+"</td></tr></tbody></table>");
		 _anchor = '<div class="float-left" style="width:100%;margin-bottom:3px;"><a href="javascript://" onclick="openBig(jQuery(this))" class="open_big float-left" data-p="0" style="width:16px;height:16px;"><svg aria-hidden="true" data-prefix="fas" data-icon="search-plus" class="svg-inline--fa fa-search-plus fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M304 192v32c0 6.6-5.4 12-12 12h-56v56c0 6.6-5.4 12-12 12h-32c-6.6 0-12-5.4-12-12v-56h-56c-6.6 0-12-5.4-12-12v-32c0-6.6 5.4-12 12-12h56v-56c0-6.6 5.4-12 12-12h32c6.6 0 12 5.4 12 12v56h56c6.6 0 12 5.4 12 12zm201 284.7L476.7 505c-9.4 9.4-24.6 9.4-33.9 0L343 405.3c-4.5-4.5-7-10.6-7-17V372c-35.3 27.6-79.7 44-128 44C93.1 416 0 322.9 0 208S93.1 0 208 0s208 93.1 208 208c0 48.3-16.4 92.7-44 128h16.3c6.4 0 12.5 2.5 17 7l99.7 99.7c9.3 9.4 9.3 24.6 0 34zM344 208c0-75.2-60.8-136-136-136S72 132.8 72 208s60.8 136 136 136 136-60.8 136-136z"></path></svg></a></div>';
		 _abs = a.abstract;
		 if(_abs!=""){
			 _abs = _anchor+"<p>"+a.abstract+"</p>";
		 }
		 $('html').find('.search-form-help-text').find('#abstract').html(_abs);
		 _claim = a.claims;
		 if(_claim!=""){
			 _claim = _anchor+"<p>"+a.claims+"</p>";
		 }
		 $('html').find('.search-form-help-text').find('#claim').html(_claim);
		 if(a.image!=""){
			$('html').find('.search-form-help-text').find('#figure').html(_anchor+'<embed src='+a.image+'#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="175px"/>');
		 }
		 $('html').find('.search-form-help-text').find('#patTabs a').on('click', function (e) {
			 e.preventDefault();
			$('html').find('.search-form-help-text').find('#patTabs a').removeClass('active').removeClass('show');
			$('html').find('.search-form-help-text').find('.tab-pane').removeClass('active').removeClass('show');
			$(this).addClass('active show');
			_ct = $(this).attr('aria-controls');
			$('html').find('.search-form-help-text').find('#'+_ct).addClass('active show');
			$('.open_big').attr('data-p',0);
			$('html').find('.search-form-help-text').css({width:'300px',height:'300px'}).find('embed').attr('height','175px');
		 })
		 $('html').find('.search-form-help-text').off('mouseenter').off('mouseleave').on("mouseleave", function() {
			$('html').find('.search-form-help-text').remove();
			poke = false; 
		}).on('mouseenter',function(){poke = true;});
	 }	
}
function tooltipClose(){
	if(poke===false){
		setTimeout(function(){
		 if(poke===false){
			$('html').find('.search-form-help-text').remove();
		 }
		},1000);
	}
}
function openBig(o){
	_getAttr = o.attr('data-p');
	var p = o.parents('.search-form-help-text');
	if(_getAttr==0){
		width = '600px';
		height = '550px';
		height1 = '450px';
		o.attr('data-p',1);
	} else {
		width = '300px';
		height = '300px';
		height1 = '175px';
		o.attr('data-p',0);
	}
	p.css({width:width,height:height})
	p.find('embed').attr('height',height1).attr('src',p.find('embed').attr('src'));
}
/*#CC0000*/
var jsonRectangles = JSON.parse('<?php echo json_encode($jsonRectangles);?>');
var jsonCountries = JSON.parse('<?php echo json_encode($countries);?>');
var jsonRelations = JSON.parse('<?php echo json_encode($jsonRelations);?>');
if(window.innerHeight>_height){
	_height = window.innerHeight - 20;
}
var svgContainer = d3.select("#patent_block").append("svg")
                                    .attr("width", _width)
                                    .attr("height", _height);
	svgContainer.attr('class','package');
var root = d3.select("svg");
var scr = { x: window.scrollX, y: window.scrollY, w: window.innerWidth, h: window.innerHeight };
var body_sel = d3.select('body');
 // this is browser-dependent, but screw that for now!
 var body = { w: body_sel.node().offsetWidth, h: body_sel.node().offsetHeight };
 jQuery('#patent_block').css({width:body.w+'px',height:window.innerHeight+'px'});
 var doc = { w: document.width, h: document.height };
 var svgpos = getNodePos(root.node());
 var dist = { x: 10, y: 10 };
 var poke = false;
var bar = svgContainer.selectAll("g")
    .data(jsonRectangles)
  .enter().append("g")
  .on('mousemove',function(a){
		tooltipOpen(a);
	}).on("mouseout", function() {
	 tooltipClose();
	});
   var defs = svgContainer.append('svg:defs');

   var line = svgContainer.selectAll('line')
			  .data(jsonRelations)
			  .enter()
			  .append('line')
			  .attr('id',function(d){return d.id})
			  .attr('stroke-width',1)
			  .attr('stroke','#999')
			  .attr('x1',function(d){
				  _patentAppNumber = d.patent_app_number;
				  _x = 0;
				  jQuery.each(jsonRectangles,function(i,r){
					  if(r.application_org_number == _patentAppNumber){
						 	_x = r.x_axis + 10;
							return false;
					  }
				  });
				  return _x;
			  })
			  .attr('x2',function(d){
				  _patentAppNumber = d.patent_app_number;
				  _x = 0;
				  jQuery.each(jsonRectangles,function(i,r){
					  if(r.application_org_number == _patentAppNumber){
						 	_x = r.x_axis + 10;
							return false;
					  }
				  });
				  return _x;
			  })
			  .attr('y1',function(d){
				  _patentAppNumber = d.relation_number;
				  _y = 0;
				  jQuery.each(jsonRectangles,function(i,r){
					  if(r.application_org_number == _patentAppNumber){
						 	_y = r.y_axis + 10;
							return false;
					  }
				  });
				  return _y;
			  })
			  .attr('y1',function(d){
				  _patentAppNumber = d.relation_number;
				  _y = 0;
				  jQuery.each(jsonRectangles,function(i,r){
					  if(r.application_org_number == _patentAppNumber){
						 	_y = r.y_axis + 70;
							return false;
					  }
				  });
				  return _y;
			  })
			  
   
   var marker = defs.selectAll('marker')
    .data(jsonRectangles)
    .enter()
    .append('svg:marker')
      .attr('id', 'markerREC')
      .attr('markerHeight', 3)
      .attr('markerWidth', 3)
      .attr('orient', 'auto')
      .attr('xoverflow', 'visible')
      .attr('refX', 3)
      .attr('refY', 0)
      .attr('viewBox', '-0 -5 10 10')
      .append('svg:path')
        .attr('d', 'M 0,-5 L 10 ,0 L 0,5')
        .attr('fill', '#999')
		.style('stroke','none');
bar.append("rect").attr("x", function (d) { return d.x_axis; })
				  .attr("y", function (d) { return d.y_axis; })
				  .attr("rx", 5)
				  .attr("ry", 5)
				  .attr('id',function(d){ return 'rec_'+d.label;})
				  .attr("height", function (d) { return d.height; })
				  .attr("width", function (d) { return d.width; })
				  .attr("fill",'#fff')
				  .attr('stroke',function(d){if(d.search===true){return 'yellow';}else{return '#999';}})
				  .attr('style','opacity:0.5;stroke-width:1;')
				  .on('mousemove',function(a){
					if($('#'+a.label).length>0){
						poke = true;
					} else {
						tooltipOpen(a);
					}
				}).on("mouseout", function(a) {
					poke = false;
					setTimeout(tooltipClose,1000);
				});

bar.append('svg:path')
	.attr('d', function(d,i){ if(i<jsonRectangles.length-1&& d.outside===false && jsonRectangles[i+1].outside===false && d.same===false && jsonRectangles[i+1].same===false){return 'M '+(d.x_axis + 50)+',' + (d.y_axis + 98) + ' L ' + (d.x_axis + 50) + ',' + (d.y_axis + 100) + '' }else {return '';}})
  .attr('stroke', '#999')
  .attr('stroke-width', function(d,i){ if(i<jsonRectangles.length-1&& d.outside===false && jsonRectangles[i+1].outside===false && d.same===false && jsonRectangles[i+1].same===false){return 5 } else {return 0;}})
  .attr('stroke-linecap', 'round')
  .attr('marker-end', function(d,i){ return 'url(#markerREC)' })
 var images = bar.append("svg:image")
        .attr("xlink:href",  function(d) { return 'http://backyard.synpat.com/public/icons/flags/'+d.country+'.png';})
        .attr("x", function(d) { return d.x_axis + 10 ;})
        .attr("y", function(d) { return d.y_axis + 5;})
        .attr("height", 30)
        .attr("width", 30)
		.on('mousemove',function(a){
		if($('#'+a.label).length>0){
			poke = true;
		} else {
			tooltipOpen(a);
		}
	}).on("mouseout", function(a) {
		poke = false;
		setTimeout(tooltipClose,1000);
	});
bar.append("text")
.attr("dy", -6)
.attr("x", function(d) { return (d.x_axis + 50); })
.attr("y",function(d) { return (d.y_axis + 100); })
.text(function (d,i) {if(i<jsonRectangles.length-1&& d.outside===false && jsonRectangles[i+1].outside===false && d.same===false && jsonRectangles[i+1].same===false){return d.type;} else {return '';}})
.attr('fill', 'red');
var textLabel = svgContainer.selectAll('.text_marker').data(jsonRectangles).enter().append('text');
textLabel
.attr("class", 'text_marker')
.attr("dy", -6)
.attr("x", function(d) { return d.x_axis + 45; })
.attr("y",function(d) { return d.y_axis + 31; })
.html(function (d) {return d.label;})
.attr('fill', '#000')
.attr('style','font-size:14px;text-anchor:start')
.on('mousemove',function(a){
		if($('#'+a.label).length>0){
			poke = true;
		} else {
			tooltipOpen(a);
		}
	}).on("mouseout", function(a) {
		poke = false;
		setTimeout(tooltipClose,1000);
	});
var textLabel = svgContainer.selectAll('.text_marker1').data(jsonRectangles).enter().append('text');	
textLabel
.attr("class", 'text_marker1')
.attr("dy", 6)
.attr("x", function(d) { return d.x_axis + 10; })
.attr("y",function(d) { return d.y_axis + 40; })
.html(function (d) {return d.application_number;})
.attr('fill', '#000')
.attr('style','font-size:14px;text-anchor:start')
.on('mousemove',function(a){
		if($('#'+a.label).length>0){
			poke = true;
		} else {
			tooltipOpen(a);
		}
	}).on("mouseout", function(a) {
		poke = false;
		setTimeout(tooltipClose,1000);
	});
var textLabel = svgContainer.selectAll('.text_marker2').data(jsonRectangles).enter().append('text');
textLabel
.attr("class", 'text_marker2')
.attr("dy", -6)
.attr("x", function(d) { return d.x_axis + 10; })
.attr("y",function(d) { return d.y_axis + 70; })
.html(function (d) {return 'Filed: '+ moment(new Date(d.filling_date)).format('MMM,DD YYYY');})
.attr('fill', '#000')
.attr('style','font-size:14px;text-anchor:start')
.on('mousemove',function(a){
		if($('#'+a.label).length>0){
			poke = true;
		} else {
			tooltipOpen(a);
		}
	}).on("mouseout", function(a) {
		poke = false;
		setTimeout(tooltipClose,1000);
	});
 </script>
<div id="accordion_template" style='display:none'>
	<div id="accordionExample">
		<div class="container">
			<div class="row">
				<h6 id="heading" class='col-lg-12'></h6>
			</div>
		</div>
		<ul class="nav nav-tabs" role="tablist" id="patTabs">
		  <li class="nav-item">
			<a class="nav-link active" id="date-tab" data-toggle="tab" href="#date" role="tab" aria-controls="date" aria-selected="true">Dates</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="abstract-tab" data-toggle="tab" href="#abstract" role="tab" aria-controls="abstract" aria-selected="false">Abstract</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="claim-tab" data-toggle="tab" href="#claim" role="tab" aria-controls="claim" aria-selected="false">Claim 1</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link" id="figure-tab" data-toggle="tab" href="#figure" role="tab" aria-controls="figure" aria-selected="false">Figure</a>
		  </li>
		</ul>
		<div class="tab-content" id="myTabContent">
		  <div class="tab-pane fade show active" id="date" role="tabpanel" aria-labelledby="date-tab"><p></p></div>
		  <div class="tab-pane fade" id="abstract" role="tabpanel" aria-labelledby="abstract-tab"><p></p></div>
		  <div class="tab-pane fade" id="claim" role="tabpanel" aria-labelledby="claim-tab"><p></p></div>
		  <div class="tab-pane fade" id="figure" role="tabpanel" aria-labelledby="figure-tab"><p></p></div>
		</div>
	</div>
</div>
<script>
</script>
</body>
</html>