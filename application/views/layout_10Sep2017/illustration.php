<?php 
$jsonRectangles = array();
$searchPatent = $number;
if(strlen($searchPatent)>9){
	$searchPatent = substr($searchPatent,0,9);
}
$height = 50;
$width = 100;
$fS = false;
$countries = array();
if(count($family_data['country'])>0){
	foreach($family_data['country'] as $country){
		$countries[] = strtolower(strtoupper($country->publication_country));
	}
}
if(count($family_data['list'])>0){
	$cpCount = 0;
	for($i=0;$i<count($family_data['list']);$i++){
		$family = $family_data['list'][$i];
		$patentNumber = $family->patent_id;
		$search = false;
		if($patentNumber==$searchPatent){
			$search = true;
		}
		$family_data['list'][$i]->search = $search;
		$family_data['list'][$i]->label = $patentNumber;
		$family_data['list'][$i]->type = "CIP";
		$countryCode = substr($patentNumber,0,2);
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
		}
		$family_data['list'][$i]->same = $same;
		$family_data['list'][$i]->count = $cpCount;
		if($same===false){
			$cpCount = 0;
		}
		if($i==0){
			$x = 10;
			$y = 100;
		} else {
			$x = 10;
			$y = (int)$family_data['list'][$i-1]->y_axis + 110;
			if($same===true){
				$previousSame = $family_data['list'][$i-1]->same;
				if($previousSame==true){
					$x = (int)$family_data['list'][$i-1]->x_axis + 180;
					$y = (int)$family_data['list'][$i-1]->y_axis;
				} else {
					if($fS===false){
						if($cpCount==1){
							$x = 180;
						} else {
							$x = $family_data['list'][$i-1]->y_axis + 80;
						}
						$fS = true;
					} else {
						$x = 180;
					}					
				}
				$y = (int)$family_data['list'][$i-1]->y_axis;
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
	}
	$jsonRectangles = $family_data['list'];
}
/*echo "<pre>";
print_r($jsonRectangles);
echo "</pre>";*/
?>
<!DOCTYPE html>
<meta charset="utf-8">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<style>
text {
  font-size:12px;font-family:arial;
}
.search-form-help-text{position:absolute;width:320px;padding:10px;border:1px solid #e4e4e4;z-index:999999;background:#fff;top:27px;box-shadow:0 0 10px 6px rgba(0,0,0,.1);border-radius:4px;right:0}.search-form-help-text dl,.search-form-help-text p,.search-form-help-text p a{font-size:15px}
</style>
<body>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script>
/*#CC0000*/
var jsonRectangles = JSON.parse('<?php echo json_encode($jsonRectangles);?>');
var jsonCountries = JSON.parse('<?php echo json_encode($countries);?>');
var svgContainer = d3.select("body").append("svg")
                                    .attr("width", 800)
                                    .attr("height", 1000)
var bar = svgContainer.selectAll("g")
    .data(jsonRectangles)
  .enter().append("g").on('mouseover',function(a){
					 var coordinates = [0, 0];
					coordinates = d3.mouse(this);
					var x = coordinates[0] + 10;
					var y = coordinates[1] + 10;
					 var getTemplateAccordion = jQuery("#accordion_template").html();
					 $('html').find('.search-form-help-text').remove();
					 $('html').append('<div class="search-form-help-text" style="top:'+y+'px;left:'+x+'px;width:700px;height:500px;overflow:hidden;overflow-y:auto;"></div>');
					 $('html').find('.search-form-help-text').append(getTemplateAccordion);
					 $('html').find('.search-form-help-text').find('#collapseOne').find('.card-body').html("<table class='table table-bordered table-striped' style='width:300px;'><tbody><tr><th>Priority:</th><td></td></tr><tr><th>Filed:</th><td>"+a.filling_date+"</td></tr><tr><th>Issued:</th><td></td></tr></tbody></table>");
					  jQuery("#accordionExample").on("show.bs.collapse",".collapse", function(){
					   lanopt.find(".collapse.in").collapse("hide");
					});
				 }).on("mouseout", function() {
					// $('html').find('.search-form-help-text').remove();
				 });
   var defs = svgContainer.append('svg:defs');
   var pattern = defs.selectAll('pattern')
   .data(jsonCountries)
   .enter()
   .append('pattern')
   .attr('id',function(d){return 'flag_'+d})
   .attr('patternUnits', 'userSpaceOnUse')
   .attr("width", 120)
   .attr("height", 50)
   .append("image")
   .attr("xlink:href", function(d){return 'http://backyard.synpat.com/public/icons/flags/'+d+'.png'})
   .attr("width", 120)
   .attr("height", 50);
   
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
				  .attr("height", function (d) { return d.height; })
				  .attr("width", function (d) { return d.width; })
				  .attr('style','opacity:0.2;stroke-width:1;stroke:#999')
				 .attr("fill", function(d) { return "url(#flag_"+d.country+")" });
bar.append("line").attr("x1", function (d,i) { if(i<jsonRectangles.length-1&& d.outside===false && jsonRectangles[i+1].outside===false && d.same===false && jsonRectangles[i+1].same===false){return d.x_axis + 50;} else {return 0;} })
				  .attr("x2", function (d,i) { if(i<jsonRectangles.length-1&& d.outside===false && jsonRectangles[i+1].outside===false && d.same===false && jsonRectangles[i+1].same===false){return d.x_axis + 50;} else {return 0;} })
				  .attr("y1", function (d,i) { if(i<jsonRectangles.length-1&& d.outside===false && jsonRectangles[i+1].outside===false && d.same===false && jsonRectangles[i+1].same===false){return d.y_axis +50;} else {return 0;} })
				  .attr("y2", function (d,i) { if(i<jsonRectangles.length-1&& d.outside===false && jsonRectangles[i+1].outside===false && d.same===false && jsonRectangles[i+1].same===false){return d.y_axis + 120;} else {return 0;} })
				  .attr("stroke-width", function (d,i) { if(i<jsonRectangles.length-1&& d.outside===false){return  1;} else {return 0;} })
                  .attr("stroke", "#999");
bar.append('svg:path')
	.attr('d', function(d,i){ if(i<jsonRectangles.length-1&& d.outside===false && jsonRectangles[i+1].outside===false && d.same===false && jsonRectangles[i+1].same===false){return 'M '+(d.x_axis + 50)+',' + (d.y_axis + 98) + ' L ' + (d.x_axis + 50) + ',' + (d.y_axis + 100) + '' }else {return '';}})
  .attr('stroke', '#999')
  .attr('stroke-width', function(d,i){ if(i<jsonRectangles.length-1&& d.outside===false && jsonRectangles[i+1].outside===false && d.same===false && jsonRectangles[i+1].same===false){return 5 } else {return 0;}})
  .attr('stroke-linecap', 'round')
  .attr('marker-end', function(d,i){ return 'url(#markerREC)' })
bar.append("text")
.attr("dy", -6)
.attr("x", function(d) { return (d.x_axis + 50); })
.attr("y",function(d) { return (d.y_axis + 100); })
.text(function (d,i) {if(i<jsonRectangles.length-1&& d.outside===false && jsonRectangles[i+1].outside===false && d.same===false && jsonRectangles[i+1].same===false){return d.type;} else {return '';}})
.attr('fill', 'red');
bar.append("text")
.attr("dy", -6)
.attr("x", function(d) { return d.x_axis + 10; })
.attr("y",function(d) { return d.y_axis + 20; })
.text(function (d) {return d.label;})
.attr('fill', '#000');
 </script>
<div id="accordion_template" style='display:none'>

<div class="accordion" id="accordionExample">
  <div class="container">
	<div class="row">
		<div class='col-lg-12'>
			<button type="button" onclick="jQuery('html').find('.search-form-help-text').remove();" class="close pull-right" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	</div>
  </div>
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Dates
        </button>
      </h5>
    </div>
    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        <p> Dates</p>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Abstract
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">  
			<p> Abstract</p>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Claim 1
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
		<p> Claim 1</p>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          Figure 1 of the patent
        </button>
      </h5>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
		<p>Figure 1 of the patent</p>
      </div>
    </div>
  </div>
</div>
</div>
 </body>
 </html>