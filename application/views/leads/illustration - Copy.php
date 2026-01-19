<?php
ini_set("magic_quotes_gpc","Off"); 
$details = array();
if(count($patent_family)>0){
	if(count($patent_family['parent'])>0){
		$details = getArrayParentFamilyDetails($patent_family['parent']);
	}
	$details[] = $patent_family['details'];
	if(count($patent_family['child'])){
		foreach($patent_family['child'] as $child){
			$details[] = $child['details'];
		}
	}
}
$i = 0;
for($i=0;$i<count($details);$i++){
	foreach($details[$i] as $key=>$value){		
		$val = preg_replace('/\'/', "&quote;",$value);		
		$details[$i]->{$key} =$val ;
	}
}
?>
<!DOCTYPE html>
<meta charset="utf-8">
<style>

path.link {
  fill: none;
  stroke: #666;
  stroke-width: 1.5px;
}

rect {
  fill: #F48024;
  stroke: #fff;
  stroke-width: 1.5px;
  shape-rendering:crispEdges
}

text {
  fill: #fff;
  font: 14px arial;
  pointer-events: none;
}
.tooltip{
	position:absolute;z-index:10;visibility:hidden;padding:10px;
	border:1px solid #efefef;
	background:#fff;
	border-radius:4px;
	font-size:14px;
	font-family:arial;
	font-weight:normal;
}
path.link .linkLabel{
    stroke: #999;
    stroke-opacity: .6;
}
</style>
<body>
<script src="//d3js.org/d3.v3.min.js"></script>
<script>
var links = [
	<?php 		
		if(count($patent_family)>0){			
			if(count($patent_family['child'])>0){
				foreach($patent_family['child'] as $childPatent){
					echo '{source: "'.$childPatent['number_id'].'", target: "'.$patent_family['patent'].'", type: "child"},';	
					echo '{source: "'.$childPatent['number_id'].'", target: "'.$patent_family['patent'].'", type: "child"},';
				}
			}
			if(count($patent_family['parent'])>0){
				showJSONParentFamily($patent_family['patent'],$patent_family['parent']);
			}
		}
	?>
]
var details = '<?php echo json_encode($details,JSON_UNESCAPED_SLASHES);?>';
if(details!=""){
	try{		
		details = details.replace(/'/g, "\\'");
		details = JSON.parse(details);
	}catch(e){
		console.log(e);
	}
}
var nodes = {};

// Compute the distinct nodes from the links.
links.forEach(function(link) {
  link.source = nodes[link.source] || (nodes[link.source] = {name: link.source});
  link.target = nodes[link.target] || (nodes[link.target] = {name: link.target});
});

var width = 960,
    height = 500;
var tooltip = d3.select("body")
	.append("div")
	.attr('class','tooltip')
	.text("Tooltip");
var width = 960,
    height = 500;

var force = d3.layout.force()
    .nodes(d3.values(nodes))
    .links(links)
    .size([width, height])
    .linkDistance(150)
    .charge(-300)
    .on("tick", tick)
    .start();

var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height);

// build the arrow.
svg.append("svg:defs").selectAll("marker")
    .data(["end"])      // Different link/path types can be defined here
  .enter().append("svg:marker")    // This section adds in the arrows
    .attr("id", String)
    .attr("viewBox", "0 -5 10 10")
    .attr("refX", 15)
    .attr("refY", -1.5)
    .attr("markerWidth", 6)
    .attr("markerHeight", 6)
    .attr("orient", "auto")
  .append("svg:path")
    .attr("d", "M0,-5L10,0L0,5");

// add the links and the arrows
  var path = svg.selectAll("path")
      .data(force.links());
var new_links = path.enter().append('g');



/*var sg = svg.selectAll("path").data(force.links())*/
 var path =  new_links.append("svg:path")
//    .attr("class", function(d) { return "link " + d.type; })
    .attr("class", "link")
    .attr("marker-end", "url(#end)");
labels = new_links.append('text').attr('class', 'linkLabel');
// define the nodes
var node = svg.selectAll(".node")
    .data(force.nodes())
  .enter().append("g")
    .attr("class", "node")
	.on("mouseover", mouseover)
    .on("mouseout", mouseout)
    .on("mousemove", mousemove)
	.on("click",function(d){
		console.log(d);
		links.forEach
	})
    .call(force.drag);

// add the nodes
node.append("rect")
    .attr("width", 85)
    .attr("height", 25);
	node.append("text")
      .text(function(d) { return d.name; })
      .attr("dy", "1.2em")
      .attr("dx", ".35em");
	  
	  node.append("text")
      .text(function(d) {
		  _relation = "";
			/*if(typeof details=="object"){
				details.forEach(function(det) {
					if(d.name == det.patent_app_number){
						if(typeof det.parent_relation!="undefined"){
							_relation = det.parent_relation;
						}
					}
				});
			}*/
			return _relation;
	 })
      .attr("dy", "-1.2em")
      .attr("dx", ".35em").style('fill','#2d2d2d');
node.selectAll('rect')
  .attr('width', function(d) {w= this.parentNode.getBBox().width + 10; return w;})
var text1 = svg.append("svg:g").selectAll("g")
    .data(force.nodes())
  .enter().append("svg:g");
  text1.append("svg:text")
    .attr("x", 8)
    .attr("y", ".31em")	
	.attr("dy", "-1.2em")
    .attr("dx", ".35em")
	.style('fill','#2d2d2d')
    .text(function(d) { _relation = "";
			if(typeof details=="object"){
				details.forEach(function(det) {
					if(d.name == det.patent_app_number){
						if(typeof det.parent_relation!="undefined"){
							_relation = det.parent_relation;
						}
					}
				});
			}
			return _relation; });
// add the text 
/*node.append("text")
    .attr("x", 12)
    .attr("dy", ".35em")
    .text(function(d) { return d.name; });*/

	
	
	

// add the curvy lines
function tick() {
    path.attr("d", function(d) {
        var dx = d.target.x - d.source.x,
            dy = d.target.y - d.source.y,
            dr = Math.sqrt(dx * dx + dy * dy);
			dr = dr + 10;			
        return "M" + 
            d.source.x + "," + 
            d.source.y + "A" + 
            dr + "," + dr + " 0 0,1 " + 
            d.target.x + "," + 
            d.target.y;
    });
	
    node
        .attr("transform", function(d) { 
  	    return "translate(" + d.x + "," + d.y + ")"; });
   labels.attr("transform",function(d){	   
	   x = 0.5*(d.source.x+d.target.x);
	   y = 0.5*(d.source.y+d.target.y);
	   console.log('asdsad:'+x+"asddasd"+y);
        return  "translate("+x+","+y+")";
    }).attr("x", 8)
    .attr("y", ".31em")	.style('fill','#2d2d2d').text(function(d) { _relation = "";
			if(typeof details=="object"){
				details.forEach(function(det) {
					if(d.source.name == det.patent_app_number){
						if(typeof det.parent_relation!="undefined"){
							_relation = det.parent_relation;
						}
					}
				});
			}
			return _relation; });
}




function mouseover(d) {
  d3.select(this).select("rect").transition()
      .duration(750)
      .attr("r", 16);
	tooltipText=d.name;
	try{
		if(typeof details=="object"){
			for(i=0;i<details.length;i++){
				if(details[i].patent_app_number==d.name){					
					if(details[i].message==null || details[i].message==''){
						tooltipText = '<p>Number: '+d.name+'<br/>App. No.:'+details[i].application_number+'<br/>Filled: '+details[i].filling_date+'<br/> Pat. No: '+details[i].patent_number+'<br/> 1st Inventor: '+details[i].first_named_inventor+'</p>';
					} else {
						tooltipText = '<p>Number: '+d.name+'<br/>International number</p>';
					}	
				}
			}
		}
	}catch(e){
		console.log(e)
	}
	tooltip.html(tooltipText);tooltip.style("visibility", "visible");
}

function mouseout() {
  d3.select(this).select("rect").transition()
      .duration(750)
      .attr("r", 8);tooltip.style("visibility", "hidden");
}
function mousemove() {
 tooltip.style("top", (event.pageY-10)+"px").style("left",(event.pageX+10)+"px");
}
</script>