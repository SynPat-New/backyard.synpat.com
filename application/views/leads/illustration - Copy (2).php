<?php
ini_set("magic_quotes_gpc","Off"); 
$details = $patent_family['details'];
$i = 0;
for($i=0;$i<count($details);$i++){
	foreach($details[$i] as $key=>$value){		
		$val = preg_replace('/\'/', "&quote;",$value);		
		$details[$i]->{$key} =$val ;
	}
}

/*$newLinks = array();
if(count($patent_family['links'])>0){
	for($p=0;$p<count($patent_family['links']);$p++){
		if(count($newLinks)>0){
			$insert = false;
			foreach($newLinks as $nl){
				$patentAppNumber = filter_var($patent_family['links'][$p]->patent_app_number, FILTER_SANITIZE_NUMBER_INT);
				$relationNUmber = filter_var($patent_family['links'][$p]->relation_number, FILTER_SANITIZE_NUMBER_INT);
				$npatentAppNumber = filter_var($nl->patent_app_number, FILTER_SANITIZE_NUMBER_INT);
				$nrelationNUmber = filter_var($nl->relation_number, FILTER_SANITIZE_NUMBER_INT);
				if($patentAppNumber == $nrelationNUmber && $relationNUmber== $npatentAppNumber){
					$insert = true;
				} else if($patentAppNumber == $npatentAppNumber && $relationNUmber==$nrelationNUmber){
					$insert = true;
				}
			}
			if($insert ==false){
				$newLinks[] = $patent_family['links'][$p];
			}
		} else {
			$newLinks[] = $patent_family['links'][$p];
		}	
	}
}*/
?>
<!DOCTYPE html>
<meta charset="utf-8">
<style>

path.link {
  fill: none;
  stroke: #666;
  stroke-width: 1.5px;
}

circle {
  fill: #F48024;
  stroke: #fff;
  stroke-width: 1.5px;
  shape-rendering:crispEdges
}

text {
  fill: #000;
  font: 14px arial;
  pointer-events: none;
}
.tooltip p{margin:0px;}
.tooltip{
	position:absolute;z-index:10;visibility:hidden;padding:5px ;
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
<?php 	
/*$allLinks = array();
$openLinks = array();
if(count($patent_family['links'])>0){
	foreach($patent_family['links'] as $link){
		$patentAppNumber = filter_var($link->patent_app_number, FILTER_SANITIZE_NUMBER_INT);
		$relationNUmber = filter_var($link->relation_number, FILTER_SANITIZE_NUMBER_INT);
		$firstNumber = $patentAppNumber.$relationNUmber;
		$secondNumber = $relationNUmber.$patentAppNumber;
		echo "A".$firstNumber."B".$secondNumber."<br/>";
		if(!in_array($firstNumber,$openLinks) && !in_array($secondNumber,$openLinks)){
			array_push($openLinks,$firstNumber);
			array_push($openLinks,$secondNumber);
			$allLinks[] = $link;
		}
	}
}
echo "<pre>";
print_r($allLinks);
die;*/
?>
<style>


#chart {
  height: 500px;
}

.node rect {
  cursor: move;
  fill-opacity: .9;
  shape-rendering: crispEdges;
}

.node text {
  pointer-events: none;
  text-shadow: 0 1px 0 #fff;
}

.link {
  fill: none;
  stroke: #000;
  stroke-opacity: .2;
}

.link:hover {
  stroke-opacity: .5;
}

</style>
<p id="chart"></p>

<script src="//d3js.org/d3.v3.min.js"></script>
<script>
var allJSON = {nodes:[],links:[]};
allJSON.links = [
	<?php 		
		if(count($patent_family['links'])>0){				
			foreach($patent_family['links'] as $childPatent){
				$relationType = "";
				if((int)$childPatent->parent==1){
					$relationType = "Parent";
				} else if((int)$childPatent->child==1){
					$relationType = "Child";
				}
				$patentNumber = $childPatent->patent_app_number;
				$relationNumber = $childPatent->relation_number;
				/*if(count($patent_family['main'])>0){
					if(filter_var($patentNumber, FILTER_SANITIZE_NUMBER_INT)== filter_var($patent_family['main']->application_number, FILTER_SANITIZE_NUMBER_INT)){
						$patentNumber = $patent_family['main']->patent_app_number;
					}
					if(filter_var($relationNumber, FILTER_SANITIZE_NUMBER_INT)== filter_var($patent_family['main']->application_number, FILTER_SANITIZE_NUMBER_INT)){
						$relationNumber = $patent_family['main']->patent_app_number;
					}
				}*/
				echo '{source: "'.filter_var($patentNumber, FILTER_SANITIZE_NUMBER_INT).'", target: "'.filter_var($relationNumber, FILTER_SANITIZE_NUMBER_INT).'", type: "'.$relationType.'",relation_type: "'.$childPatent->relation_type.'"},';	
			}
		}		
	?>
];
allJSON.nodes = [
	<?php 		
		if(count($details)>0){				
			foreach($details as $childPatent){				
				$patentNumber = $childPatent->application_number;
				/*	if(count($patent_family['main'])>0){
					if(filter_var($patentNumber, FILTER_SANITIZE_NUMBER_INT)== filter_var($patent_family['main']->application_number, FILTER_SANITIZE_NUMBER_INT)){
						$patentNumber = $patent_family['main']->patent_app_number;
					}
				}*/
				echo '{node: "'.filter_var($patentNumber, FILTER_SANITIZE_NUMBER_INT).'", name: "'.$patentNumber.'",value:'.rand(10,200).'},';	
			}
		}		
	?>
];
d3.sankey = function() {
  var sankey = {},
      nodeWidth = 24,
      nodePadding = 8,
      size = [1, 1],
      nodes = [],
      links = [];

  sankey.nodeWidth = function(_) {
    if (!arguments.length) return nodeWidth;
    nodeWidth = +_;
    return sankey;
  };

  sankey.nodePadding = function(_) {
    if (!arguments.length) return nodePadding;
    nodePadding = +_;
    return sankey;
  };

  sankey.nodes = function(_) {
    if (!arguments.length) return nodes;
    nodes = _;
    return sankey;
  };

  sankey.links = function(_) {
    if (!arguments.length) return links;
    links = _;
    return sankey;
  };

  sankey.size = function(_) {
    if (!arguments.length) return size;
    size = _;
    return sankey;
  };

  sankey.layout = function(iterations) {
    computeNodeLinks();
    computeNodeValues();
    computeNodeBreadths();
    computeNodeDepths(iterations);
    computeLinkDepths();
    return sankey;
  };

  sankey.relayout = function() {
    computeLinkDepths();
    return sankey;
  };

  sankey.link = function() {
    var curvature = .5;

    function link(d) {
      var x0 = d.source.x + d.source.dx,
          x1 = d.target.x,
          xi = d3.interpolateNumber(x0, x1),
          x2 = xi(curvature),
          x3 = xi(1 - curvature),
          y0 = d.source.y + d.sy + d.dy / 2,
          y1 = d.target.y + d.ty + d.dy / 2;
		  console.log('X0:'+x0+'x1:'+x1+'xi:'+xi+'x2:'+x2+'x3:'+x3+'y0:'+y0+'y1:'+y1);
      return "M" + x0 + "," + y0
           + "C" + x2 + "," + y0
           + " " + x3 + "," + y1
           + " " + x1 + "," + y1;
    }

    link.curvature = function(_) {
      if (!arguments.length) return curvature;
      curvature = +_;
      return link;
    };

    return link;
  };

  // Populate the sourceLinks and targetLinks for each node.
  // Also, if the source and target are not objects, assume they are indices.
  function computeNodeLinks() {
    nodes.forEach(function(node) {
      node.sourceLinks = [];
      node.targetLinks = [];
    });
    links.forEach(function(link) {
      var source = link.source,
          target = link.target;
		  console.log("LINK:"+source+"TARGET:"+target);
		  nap = "";
		  nodes.forEach(function(node) {
			  if(node.node==link.source){
				  nap = node;
			  }
		  })
		  if(typeof nap=="object"){
			  source = link.source = nap;
			  console.log('SOURCE');
			  console.log(source);
		  }
		  nap = "";
		  nodes.forEach(function(node) {
			  if(node.node==link.target){
				  nap = node;
			  }
		  })
		  if(typeof nap=="object"){
			   target = link.target = nap;console.log('TARGET');console.log(target);
		  }	
	 /* source = link.source = nodes[link.source];
	target = link.target = nodes[link.target];
	console.log('SOURCE');
				  console.log(source);console.log('TARGET');console.log(target);*/
      source.sourceLinks.push(link);
      target.targetLinks.push(link);
    });
  }

  // Compute the value (size) of each node by summing the associated links.
  function computeNodeValues() {
    nodes.forEach(function(node) {
      node.value = Math.max(
        d3.sum(node.sourceLinks, value),
        d3.sum(node.targetLinks, value)
      );
    });
  }

  // Iteratively assign the breadth (x-position) for each node.
  // Nodes are assigned the maximum breadth of incoming neighbors plus one;
  // nodes with no incoming links are assigned breadth zero, while
  // nodes with no outgoing links are assigned the maximum breadth.
  function computeNodeBreadths() {
    var remainingNodes = nodes,
        nextNodes,
        x = 0;

    while (remainingNodes.length) {
      nextNodes = [];
      remainingNodes.forEach(function(node) {
        node.x = x;
        node.dx = nodeWidth;
        node.sourceLinks.forEach(function(link) {
          nextNodes.push(link.target);
        });
      });
      remainingNodes = nextNodes;
      ++x;
    }

    //
    moveSinksRight(x);
    scaleNodeBreadths((width - nodeWidth) / (x - 1));
  }

  function moveSourcesRight() {
    nodes.forEach(function(node) {
      if (!node.targetLinks.length) {
        node.x = d3.min(node.sourceLinks, function(d) { return d.target.x; }) - 1;
      }
    });
  }

  function moveSinksRight(x) {
    nodes.forEach(function(node) {
      if (!node.sourceLinks.length) {
        node.x = x - 1;
      }
    });
  }

  function scaleNodeBreadths(kx) {
    nodes.forEach(function(node) {
      node.x *= kx;
    });
  }

  function computeNodeDepths(iterations) {
    var nodesByBreadth = d3.nest()
        .key(function(d) { return d.x; })
        .sortKeys(d3.ascending)
        .entries(nodes)
        .map(function(d) { return d.values; });

    //
    initializeNodeDepth();
    resolveCollisions();
    for (var alpha = 1; iterations > 0; --iterations) {
      relaxRightToLeft(alpha *= .99);
      resolveCollisions();
      relaxLeftToRight(alpha);
      resolveCollisions();
    }

    function initializeNodeDepth() {
      var ky = d3.min(nodesByBreadth, function(nodes) {
        return (size[1] - (nodes.length - 1) * nodePadding) / d3.sum(nodes, value);
      });

      nodesByBreadth.forEach(function(nodes) {
        nodes.forEach(function(node, i) {
			console.log("II:"+i);
			console.log("IK:"+ky);
          node.y = i;
          node.dy = node.value * ky;
        });
      });

      links.forEach(function(link) {
        link.dy = link.value * ky;
      });
    }

    function relaxLeftToRight(alpha) {
      nodesByBreadth.forEach(function(nodes, breadth) {
        nodes.forEach(function(node) {
          if (node.targetLinks.length) {
            var y = d3.sum(node.targetLinks, weightedSource) / d3.sum(node.targetLinks, value);
            node.y += (y - center(node)) * alpha;
          }
        });
      });

      function weightedSource(link) {
        return center(link.source) * link.value;
      }
    }

    function relaxRightToLeft(alpha) {
      nodesByBreadth.slice().reverse().forEach(function(nodes) {
        nodes.forEach(function(node) {
          if (node.sourceLinks.length) {
            var y = d3.sum(node.sourceLinks, weightedTarget) / d3.sum(node.sourceLinks, value);
            node.y += (y - center(node)) * alpha;
          }
        });
      });

      function weightedTarget(link) {
        return center(link.target) * link.value;
      }
    }

    function resolveCollisions() {
      nodesByBreadth.forEach(function(nodes) {
        var node,
            dy,
            y0 = 0,
            n = nodes.length,
            i;

        // Push any overlapping nodes down.
        nodes.sort(ascendingDepth);
        for (i = 0; i < n; ++i) {
          node = nodes[i];
          dy = y0 - node.y;
          if (dy > 0) node.y += dy;
          y0 = node.y + node.dy + nodePadding;
        }

        // If the bottommost node goes outside the bounds, push it back up.
        dy = y0 - nodePadding - size[1];
        if (dy > 0) {
          y0 = node.y -= dy;

          // Push any overlapping nodes back up.
          for (i = n - 2; i >= 0; --i) {
            node = nodes[i];
            dy = node.y + node.dy + nodePadding - y0;
            if (dy > 0) node.y -= dy;
            y0 = node.y;
          }
        }
      });
    }

    function ascendingDepth(a, b) {
      return a.y - b.y;
    }
  }

  function computeLinkDepths() {
    nodes.forEach(function(node) {
      node.sourceLinks.sort(ascendingTargetDepth);
      node.targetLinks.sort(ascendingSourceDepth);
    });
    nodes.forEach(function(node) {
      var sy = 0, ty = 0;
      node.sourceLinks.forEach(function(link) {
        link.sy = sy;
        sy += link.dy;
      });
      node.targetLinks.forEach(function(link) {
        link.ty = ty;
        ty += link.dy;
      });
    });

    function ascendingSourceDepth(a, b) {
      return a.source.y - b.source.y;
    }

    function ascendingTargetDepth(a, b) {
      return a.target.y - b.target.y;
    }
  }

  function center(node) {
    return node.y + node.dy / 2;
  }

  function value(link) {
    return link.value;
  }

  return sankey;
};


var details = '<?php echo json_encode($details,JSON_UNESCAPED_SLASHES);?>';
if(details!=""){
	try{		
		details = details.replace(/'/g, "\\'");
		details = JSON.parse(details);
	}catch(e){
		console.log(e);
	}
}
/*
allJSON.nodes = details;
allJSON = {"nodes":[
{"name":"Agricultural 'waste'"},
{"name":"Bio-conversion"},
{"name":"Liquid"},
{"name":"Losses"},
{"name":"Solid"},
{"name":"Gas"},
{"name":"Biofuel imports"},
{"name":"Biomass imports"},
{"name":"Coal imports"},
{"name":"Coal"},
{"name":"Coal reserves"},
{"name":"District heating"},
{"name":"Industry"},
{"name":"Heating and cooling - commercial"},
{"name":"Heating and cooling - homes"},
{"name":"Electricity grid"},
{"name":"Over generation / exports"},
{"name":"H2 conversion"},
{"name":"Road transport"},
{"name":"Agriculture"},
{"name":"Rail transport"},
{"name":"Lighting & appliances - commercial"},
{"name":"Lighting & appliances - homes"},
{"name":"Gas imports"},
{"name":"Ngas"},
{"name":"Gas reserves"},
{"name":"Thermal generation"},
{"name":"Geothermal"},
{"name":"H2"},
{"name":"Hydro"},
{"name":"International shipping"},
{"name":"Domestic aviation"},
{"name":"International aviation"},
{"name":"National navigation"},
{"name":"Marine algae"},
{"name":"Nuclear"},
{"name":"Oil imports"},
{"name":"Oil"},
{"name":"Oil reserves"},
{"name":"Other waste"},
{"name":"Pumped heat"},
{"name":"Solar PV"},
{"name":"Solar Thermal"},
{"name":"Solar"},
{"name":"Tidal"},
{"name":"UK land based bioenergy"},
{"name":"Wave"},
{"name":"Wind"}
],
"links":[
{"source":0,"target":1,"value":124.729},
{"source":1,"target":2,"value":0.597},
{"source":1,"target":3,"value":26.862},
{"source":1,"target":4,"value":280.322},
{"source":1,"target":5,"value":81.144},
{"source":6,"target":2,"value":35},
{"source":7,"target":4,"value":35},
{"source":8,"target":9,"value":11.606},
{"source":10,"target":9,"value":63.965},
{"source":9,"target":4,"value":75.571},
{"source":11,"target":12,"value":10.639},
{"source":11,"target":13,"value":22.505},
{"source":11,"target":14,"value":46.184},
{"source":15,"target":16,"value":104.453},
{"source":15,"target":14,"value":113.726},
{"source":15,"target":17,"value":27.14},
{"source":15,"target":12,"value":342.165},
{"source":15,"target":18,"value":37.797},
{"source":15,"target":19,"value":4.412},
{"source":15,"target":13,"value":40.858},
{"source":15,"target":3,"value":56.691},
{"source":15,"target":20,"value":7.863},
{"source":15,"target":21,"value":90.008},
{"source":15,"target":22,"value":93.494},
{"source":23,"target":24,"value":40.719},
{"source":25,"target":24,"value":82.233},
{"source":5,"target":13,"value":0.129},
{"source":5,"target":3,"value":1.401},
{"source":5,"target":26,"value":151.891},
{"source":5,"target":19,"value":2.096},
{"source":5,"target":12,"value":48.58},
{"source":27,"target":15,"value":7.013},
{"source":17,"target":28,"value":20.897},
{"source":17,"target":3,"value":6.242},
{"source":28,"target":18,"value":20.897},
{"source":29,"target":15,"value":6.995},
{"source":2,"target":12,"value":121.066},
{"source":2,"target":30,"value":128.69},
{"source":2,"target":18,"value":135.835},
{"source":2,"target":31,"value":14.458},
{"source":2,"target":32,"value":206.267},
{"source":2,"target":19,"value":3.64},
{"source":2,"target":33,"value":33.218},
{"source":2,"target":20,"value":4.413},
{"source":34,"target":1,"value":4.375},
{"source":24,"target":5,"value":122.952},
{"source":35,"target":26,"value":839.978},
{"source":36,"target":37,"value":504.287},
{"source":38,"target":37,"value":107.703},
{"source":37,"target":2,"value":611.99},
{"source":39,"target":4,"value":56.587},
{"source":39,"target":1,"value":77.81},
{"source":40,"target":14,"value":193.026},
{"source":40,"target":13,"value":70.672},
{"source":41,"target":15,"value":59.901},
{"source":42,"target":14,"value":19.263},
{"source":43,"target":42,"value":19.263},
{"source":43,"target":41,"value":59.901},
{"source":4,"target":19,"value":0.882},
{"source":4,"target":26,"value":400.12},
{"source":4,"target":12,"value":46.477},
{"source":26,"target":15,"value":525.531},
{"source":26,"target":3,"value":787.129},
{"source":26,"target":11,"value":79.329},
{"source":44,"target":15,"value":9.452},
{"source":45,"target":1,"value":182.01},
{"source":46,"target":15,"value":19.013},
{"source":47,"target":15,"value":289.366}
]};

*/



var margin = {top: 1, right: 1, bottom: 6, left: 1},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var formatNumber = d3.format(",.0f"),
    format = function(d) { return formatNumber(d) + " TWh"; },
    color = d3.scale.category20();

var svg = d3.select("#chart").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

var sankey = d3.sankey()
    .nodeWidth(15)
    .nodePadding(10)
    .size([width, height]);

var path = sankey.link();
sankey
      .nodes(allJSON.nodes)
      .links(allJSON.links)
      .layout(32);

  var link = svg.append("g").selectAll(".link")
      .data(allJSON.links)
    .enter().append("path")
      .attr("class", "link")
      .attr("d", path)
      .style("stroke-width", function(d) { return Math.max(1, d.dy); })
      .sort(function(a, b) { return b.dy - a.dy; });

  link.append("title")
      .text(function(d) { return d.source.application_number + " → " + d.target.application_number + "\n" + format(d.value); });

  var node = svg.append("g").selectAll(".node")
      .data(allJSON.nodes)
    .enter().append("g")
      .attr("class", "node")
      .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; })
    .call(d3.behavior.drag()
      .origin(function(d) { return d; })
      .on("dragstart", function() { this.parentNode.appendChild(this); })
      .on("drag", dragmove));

  node.append("rect")
      .attr("height", function(d) { return d.dy; })
      .attr("width", sankey.nodeWidth())
      .style("fill", function(d) { return d.color = color(d.name.replace(/ .*/, "")); })
      .style("stroke", function(d) { return d3.rgb(d.color).darker(2); })
    .append("title")
      .text(function(d) { return d.name + "\n" + format(d.value); });

  node.append("text")
      .attr("x", -6)
      .attr("y", function(d) { return d.dy / 2; })
      .attr("dy", ".35em")
      .attr("text-anchor", "end")
      .attr("transform", null)
      .text(function(d) { return d.name; })
    .filter(function(d) { return d.x < width / 2; })
      .attr("x", 6 + sankey.nodeWidth())
      .attr("text-anchor", "start");

  function dragmove(d) {
    d3.select(this).attr("transform", "translate(" + d.x + "," + (d.y = Math.max(0, Math.min(height - d.dy, d3.event.y))) + ")");
    sankey.relayout();
    link.attr("d", path);
  }

/*
d3.json(allJSON, function(energy) {

  
});
*/
</script>







