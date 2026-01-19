<!DOCTYPE html>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl; ?>public/style_new_without_compress.css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//backyard.synpat.com/public/tiff.min.js"></script>
<script src="//backyard.synpat.com/public/jquery.tablesorter.min.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js" ></script>
<!--<script src="//backyard.synpat.com/public/dragscroll.js" ></script>-->
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style>
@import url('https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap');
.search-form-help-text{position:absolute;width:320px;padding:10px;border:1px solid #e4e4e4;z-index:999999;background:#f8f9fa;top:27px;/*box-shadow:0 0 10px 6px rgba(0,0,0,.1);*/border-radius:2px;right:0;}.search-form-help-text dl,.search-form-help-text p,.search-form-help-text p a{font-size:15px}
input{border:1px solid #dfe8f1 !important}
#container {
	display: inline-block;
	margin: 0;
	width: 100%;
	position: relative;
	font-family: 'Roboto', sans-serif;
}

#container svg {
	border: 1px solid #ccc;margin-top:25px;
}

/*#container .header {
	text-anchor: middle;
}*/

#container .hline {
	stroke: #aaa;
	stroke-width: 1;
	stroke-dasharray: 5, 5;
}

#container .box {
	fill: #fff;
	fill-opacity: 0.8;
	stroke: #999;
	stroke-width: 2;
}

#container .tline {
	stroke: #aaa;
	stroke-width: 1;
	stroke-dasharray: 5, 5;
}

#container .thead {
	text-anchor: end;
	font-size: 11px;
}

#container .thead2 {
	text-anchor: start;
	font-size: 11px;
}

#container .btext {
	font-size: 14px;
	fill: #000;
	font-weight: bold;
}

#container .btext2 {
	font-size: 12px;
	fill: #555;
}

#container .btext2 .active {
	fill: #f00;
}

#container .connection {
	fill: none;
	stroke: #aaa;
	stroke-width: 2;
}

#container .connection.active {
	stroke-width: 5;
}

#container .tooltip {
	position: absolute;
	padding: 5px 10px;
	border-radius: 4px;
	pointer-events: none;
	background: #555;
	color: #fff;
	font-size: 12px;
}

.popup {
	position: fixed;
	top: 0;
	right: 0;
	bottom: auto;
	left: auto;
	max-height: 90%;
	overflow-y: scroll;
	background: #fff;
	z-index: 999;
	font-size: 12px;
}

.popup > div {
	width: 600px;
	padding: 10px;
	border: 1px solid #aaa;
	margin: 10px;
	position: relative;
}

.popup > div > a {
	position: absolute;
	right: 10px;
	top: 10px;
}

.popup > div > label {
	font-weight: bold;
	text-transform: uppercase;
	margin-bottom: 5px;
	display: block;
	padding-right: 50px;
}

.popup > div > table {
	border-spacing: 0;
	border-collapse: collapse;
	width: 100%;
}

.popup table.top {
	margin-bottom: 20px;
}

.popup table.top td {
	width: 50%;
	padding-top: 10px;
}

.popup table.bottom th, .popup table.bottom td {
	text-align: left;
	width: 25%;
	padding: 2px 5px;
}

.popup table.bottom .title {
	padding-top: 5px;
}

.popup table.bottom .title td {
	background: #ddd;
}

.ui-slider-horizontal {
height: 0.7em;
}

.buttons {
	position: absolute;
	top: 40px;
	left: 12px;
	width: 65px;
}

.buttons > button {
	width: 29px;
	height: 22px;
	margin-right: 2px;
	margin-bottom: 2px;
}

.menu {
position: absolute;
top: 0px;
left: 9px;
height: 45px;
background: rgba(255, 255, 255, 0.8);
}
body{overflow:auto !important;}
div#patent_block{overflow:scroll;min-width:500px;height:500px;}
#legend ul li{float:left;margin-right:5px;width:100%;}
#assignment_template{font-family:"Roboto";width:100%;}
#assignment_template, #assignment_template p, #assignment_template p a, #assignment_template span {font-size:13px !important;}
#assignment_template p {
    margin-bottom: 0;
	color:#444;
}
#assignment_template a{color:#C20000;text-decoration:none;cursor:text;}
#assignment_template .tbl-properties-col a{color:#15c;}
#assignment_template .h3, #assignment_template h3.headline span {
    font-size: 20px !important;
    font-weight: 600;
	color:#222
}
#assignment_template h3.headline.skinny span {
    font-weight: 200;
    margin-top: 0;
}

#assignment_template .table>thead>tr>th {
    font-weight: 600;
}
</style>
<body>
<script src="//d3js.org/d3.v4.min.js"></script>
<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<input type="text" name="txt_patent_number" id="txt_patent_number" placeholder="Patent Number" class="form-control pull-left" style="width:150px;"/>
			<button onclick="findPatentAssignments();" id="btnGo" class="btn btn-primary pull-left" style="margin-left:20px;" type="button">Go</button>
			<span id="log_message" class="pull-left" style="width:100px;margin-left:20px;"></span>
			<span id="btnList" style='display:none'>
				<button id="btnUspto" class="btn btn-primary" style="float:left;margin-right:20px;margin-left:20px" type="button">USPTO</button>
				<button onclick="getAllAssignment()" id="btnAssignments" class="btn btn-primary" style="float:left;margin-right:20px;" type="button">Assignments</button>
				<!--<button onclick="rebuildIllustration()" id="btnRebuild" class="btn btn-primary" style="float:left;margin-right:20px;" type="button">Rebuild</button>-->
				<button onclick="getAllNames()" id="btnEntries" class="btn btn-primary" style="float:left;margin-right:20px;" type="button">Entities</button>
			</span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12" style="margin-top:100px;">
		<div id="container"></div>
	</div>
</div>
<script>
var assignmentList = [],namesList = [],_toolTipHeight=450,patent_number = '<?php echo $patent_number;?>';
function findPatentAssignments() {
	jQuery("#container").empty();
	jQuery("#btnList").hide();
	if(jQuery("#txt_patent_number").val() != "" && jQuery("#txt_patent_number").val().length > 6) {
		rebuildIllustration();
	}
}
function rebuildIllustration() {
	var patentNumber = jQuery("#txt_patent_number").val();
	jQuery("#log_message").html("Please wait...");
	jQuery.ajax({
		url:'https://backyard.synpat.com/assignment_data_by_patent_number.php',
		type:'POST',
		data:{patent_number:patentNumber},
		cache:false
	})
	.done(function(data,textStatus,xhr){
		jQuery("#log_message").html("Loading...");
		createIllustration(patentNumber);
	});	
}
function createIllustration(patentNumber) {
	if(patentNumber) {
		switch(patentNumber.length){
			case 9:
				patentNumber = patentNumber.substr(2);
			break;
			case 10:
				patentNumber = patentNumber.substr(2);
				patentNumber = patentNumber.substr(0,patentNumber.length-1);
			break;
			case 11:
			case 13:
				patentNumber = patentNumber.substr(2);
				patentNumber = patentNumber.substr(0,patentNumber.length-2);
			break;
			default:
				patentNumber = patentNumber;
			break;
		}
	}
	d3.json("https://backyard.synpat.com/customers/assignment_reel_data/"+patentNumber,
		function(n) {
			jQuery("#log_message").html("");
			jQuery("#btnUspto").off('click').on('click',function(){
				window.open('https://assignment.uspto.gov/patent/index.html#/patent/search/resultAbstract?id='+patentNumber+'&type=patNum','_blank');
			});
			jQuery("#btnList").show();
			assignmentList = n.assignments;
			namesList = n.names;
			function v() {
                    r.selectAll(".box")
                        .each(function(n) {
                            var t = 1;
                            w == 0 && n.mainCol == 2 && (t = 0);
                            k == 0 && n.mainCol == 3 && (t = 0);
                            a == 0 && n.dottedOnly == 1 && (t = 0);
                            n.execution_date > f[e] && (t = 0);
                            d3.select(this).style("opacity", t)
                        });
                    r.selectAll(".btext")
                        .each(function(n) {
                            var t = 1;
                            w == 0 && n.mainCol == 2 && (t = 0);
                            k == 0 && n.mainCol == 3 && (t = 0);
                            a == 0 && n.dottedOnly == 1 && (t = 0);
                            n.execution_date > f[e] && (t = 0);
                            d3.select(this).style("opacity", t)
                        });
                    r.selectAll(".btext2")
                        .each(function(n) {
                            var t = 1;
                            w == 0 && n.mainCol == 2 && (t = 0);
                            k == 0 && n.mainCol == 3 && (t = 0);
                            a == 0 && n.dottedOnly == 1 && (t = 0);
                            n.execution_date > f[e] && (t = 0);
                            d3.select(this).style("opacity", t)
                        });
                    r.selectAll("a")
                        .each(function(n) {
                            var t = 1;
                            w == 0 && n.mainCol == 2 && (t = 0);
                            a == 0 && n.dottedOnly == 1 && (t = 0);
                            n.execution_date > f[e] && (t = 0);
                            d3.select(this).style("opacity", t)
                        });
                    o.selectAll(".connection")
                        .each(function() {
                            var n = d3.select(this.parentNode).datum(), i = l[n.start_id], r = l[n.end_id], t = 1;
                            w == 0 && (i.mainCol == 2 || r.mainCol == 2) && (t = 0);
                            k == 0 && (i.mainCol == 3 || r.mainCol == 3) && (t = 0);
                            a == 0 && n.ref_id_go && (t = 0);
                            n.date > f[e] && (t = 0);
                            n.type == "Security" &&
                                n.ref_id_go &&
                                (n.release_date > f[e]
                                    ? d3.select(this).attr("marker-start", null).style("stroke-dasharray", null)
                                    : d3.select(this).attr("marker-start", "url(#start1)").style("stroke-dasharray", "10,5"));
                            d3.select(this).style("opacity", t)
                        })
                }

                function vt() {
                    y.attr("width", it + u.left + u.right + i + s);
                    rt.selectAll(".hline")
                        .attr("x1", function(n) { return n.left + (n.d.id > 1 ? i : 0) })
                        .attr("x2", function(n) { return n.left + (n.d.id > 1 ? i : 0) });
                    at.style("left", u.left + t[0].subWidth * t[0].sub + t[1].subWidth * t[1].sub / 2 - 42 + i + "px");
                    ft.style("left", u.left + t[0].subWidth * t[0].sub + t[1].subWidth * t[1].sub + t[2].subWidth * t[2].sub / 2 - 78 + i + s + "px");
                    et.style("left", t[0].subWidth * t[0].sub + t[1].subWidth * t[1].sub - 80 + i + "px");
                    pt.style("left", t[0].subWidth * t[0].sub + t[1].subWidth * t[1].sub + 110 + i + "px");
                    r.selectAll("rect.box").attr("x", function(n) { return n.mainCol == 3 ? n.x - 200 + i + s : n.mainCol == 2 ? n.x - 95 + i : n.x - 95 });
                    o.selectAll(".tline")
                        .attr("x2",
                            function(n) {
                                return n.mainCol == 3
                                    ? n.x - 200 + i + s
                                    : n.mainCol == 2
                                    ? n.x - 95 + i
                                    : n.x -
                                    (n.type == "Inventor" ? 110 : 95
                                    )
                            });
                    r.selectAll(".btext")
                        .attr("x",
                            function(n) { return n.mainCol == 3 ? n.x - 180 + i + s : n.mainCol == 2 ? n.x - 65 + i : n.x - (n.type == "Inventor" ? 0 : 65) });
                    r.selectAll(".btext tspan")
                        .attr("x",
                            function(n) { return n.mainCol == 3 ? n.x - 180 + i + s : n.mainCol == 2 ? n.x - 65 + i : n.x - (n.type == "Inventor" ? 0 : 65) });
                    r.selectAll(".btext2")
                        .attr("x",
                            function(n) { return n.mainCol == 3 ? n.x - 180 + i + s : n.mainCol == 2 ? n.x - 84 + i : n.x - (n.type == "Inventor" ? 0 : 84) });
                    r.selectAll(".btext2 > tspan")
                        .attr("x",
                            function(n) { return n.mainCol == 3 ? n.x - 180 + i + s : n.mainCol == 2 ? n.x - 84 + i : n.x - (n.type == "Inventor" ? 0 : 84) });
                    r.selectAll("a image").attr("x", function(n) { return n.mainCol == 2 ? n.x - 90 + i : n.x - (n.type == "Inventor" ? 85 : 90) });
                    o.selectAll(".connection")
                        .each(function() {
                            var u = d3.select(this.parentNode).datum(), f = d3.select(this).datum(), n = [], t, r;
                            f.forEach(function(t) { n.push([t[0], t[1]]) });
                            t = l[u.start_id];
                            r = l[u.end_id];
                            t.mainCol == 3 ? (n[0][0] += i + s, n[1][0] += i + s) : t.mainCol == 2 && (n[0][0] += i, n[1][0] += i);
                            r.mainCol == 3 ? (n[2][0] += i + s, n[3][0] += i + s) : r.mainCol == 2 && (n[2][0] += i, n[3][0] += i);
                            d3.select(this).attr("d", ut(n))
                        })
                }

                var st, ht, p, ut, h, ft, a, et, e, d, ot, b;
                n.box.forEach(function(n) {
                    var t;
                    n.execution_date != null &&
                        n.execution_date != "" &&
                        (t = new Date(n.execution_date), n.execution_date = t.getFullYear() +
                            "-" +
                            (t.getMonth() < 9 ? "0" : "") +
                            (t.getMonth() + 1) +
                            "-" +
                            (t.getDate() < 10 ? "0" : "") +
                            t.getDate());
                    n.recorded_date != null &&
                        n.recorded_date != "" &&
                        (t = new Date(n.recorded_date), n.recorded_date = t.getFullYear() +
                            "-" +
                            (t.getMonth() < 9 ? "0" : "") +
                            (t.getMonth() + 1) +
                            "-" +
                            (t.getDate() < 10 ? "0" : "") +
                            t.getDate())
                });
                n.connection.forEach(function(n) {
                    var t = new Date(n.date);
                    n.date = t.getFullYear() + "-" + (t.getMonth() < 9 ? "0" : "") + (t.getMonth() + 1) + "-" + (t.getDate() < 10 ? "0" : "") + t.getDate()
                });
                n.box.sort(function(n, t) {
                    return n.execution_date > t.execution_date
                        ? 1
                        : n.execution_date < t.execution_date
                        ? -1
                        : n.type == "Inventor" && t.type != "Inventor" ? -1 : t.type == "Inventor" && n.type != "Inventor" ? 1 : n.id > t.id ? 1 : -1
                });
                console.log(n);
                var nt = d3.extent(n.box
                        .filter(function(n) { return n.execution_date != null && n.execution_date != "" }),
                        function(n) { return n.execution_date }),
                    tt = 864e5,
                    yt = (new Date(nt[1]) - new Date(nt[0])) / tt;
                console.log(nt);
                console.log(yt);
                st = d3.map(n.box, function(n) { return n.type }).keys();
                ht = d3.map(n.connection, function(n) { return n.type }).keys();
                console.log(st);
                console.log(ht);
                var t = [
                        { id: 0, name: "Ownership", subWidth: 320, subHeight: 120, sub: 1, items: [] },
                        { id: 1, name: "Security", subWidth: 280, subHeight: 120, sub: 1, items: [] },
                        { id: 2, name: "License / 3rdParty", subWidth: 500, subHeight: 40, sub: 1, items: [], preHeight: 30 }
                    ],
                    l = [],
                    c = [],
                    f = [];
                n.box.forEach(function(i) {
                    var r, u;
                    i.type == "License" && (i.type = "3rdParties");
                    i.type == "ChangeOfName" && (i.type = "Ownership");
                    (i.type == "Inventor" || i.type == "Ownership") && (r = t[0], i.mainCol = 1);
                    i.type == "Security" && (r = t[1], i.mainCol = 2);
                    i.type == "3rdParties" && (r = t[2], i.mainCol = 3);
                    r &&
                    (r.items.length == 0 || i.type == "3rdParties" || i.type != "Inventor" && r.items[r.items.length - 1].type == "Inventor"
                        ? i.subCol = 1
                        : i.execution_date == r.items[r.items.length - 1].execution_date
                        ? (i.subCol = r.items[r.items.length - 1].subCol + 1, r.sub < i.subCol && (r.sub = i.subCol))
                        : i.subCol = 1, r.items.push(i), i.inTypes = d3.map(n.connection.filter(function(n) { return n.end_id == i.id }),
                            function(n) { return n.type })
                        .keys(), i.outTypes = d3.map(n.connection
                            .filter(function(n) { return n.start_id == i.id }),
                            function(n) { return n.type })
                        .keys(), i.dottedOnly = 1, l[i.id] = i, u = i
                        .execution_date +
                        (i.type == "Inventor" ? "d" : ""), i.type != "3rdParties" && c.indexOf(u) < 0 && c.push(u), i.type != "3rdParties" &&
                        f.indexOf(i.execution_date) < 0 &&
                        f.push(i.execution_date))
                });
                console.log(t);
                console.log(c);
                var g = d3.select("#container"),
                    u = { top: 50, left: 80, right: 20, bottom: 40 },
                    it = d3.sum(t, function(n) { return n.sub * n.subWidth }),
                    ct = Math.max(c.length * t[0].subHeight, t[2].items.length * t[2].subHeight + t[2].preHeight),
                    y = g.append("svg").attr("width", it + u.left + u.right).attr("height", ct + u.top + u.bottom),
                    lt = y.append("defs"),
                    rt = y.append("g").attr("transform", "translate(" + u.left + ",0)"),
                    o = y.append("g").attr("transform", "translate(" + u.left + "," + u.top + ")"),
                    r = y.append("g").attr("transform", "translate(" + u.left + "," + u.top + ")");
                ["#D62D20", "#FFA700", "#008744", "#4285F4", "#8329AD"].forEach(function(n, t) {
                    lt.append("marker")
                        .attr("id", "end" + t)
                        .attr("viewBox", "0 -5 10 10")
                        .attr("refX", 10)
                        .attr("refY", 0)
                        .attr("markerWidth", 12)
                        .attr("markerHeight", 12)
                        .attr("markerUnits", "userSpaceOnUse")
                        .attr("orient", "auto")
                        .append("svg:path")
                        .attr("d", "M0,-5L10,0L0,5")
                        .style("fill", n);
                    lt.append("marker")
                        .attr("id", "start" + t)
                        .attr("viewBox", "0 -5 10 10")
                        .attr("refX", 0)
                        .attr("refY", 0)
                        .attr("markerWidth", 12)
                        .attr("markerHeight", 12)
                        .attr("markerUnits", "userSpaceOnUse")
                        .attr("orient", "auto")
                        .append("svg:path")
                        .attr("d", "M10,-5L0,0L10,5")
                        .style("fill", n)
                });
                p = 0;
                t.forEach(function(n) {
                    rt.append("line")
                        .attr("class", "hline")
                        .datum({ left: p, d: n })
                        .attr("x1", p)
                        .attr("y1", 20)
                        .attr("x2", p)
                        .attr("y2", ct + u.top + u.bottom - 20);
                    n.items.forEach(function(i, u) {
                        var f, e;
                        i.x = p + (i.subCol - 1) * n.subWidth + n.subWidth / 2;
                        i.type != "3rdParties"
                            ? i.y = c.lastIndexOf(i.execution_date + (i.type == "Inventor" ? "d" : "")) * n.subHeight + n.subHeight / 2
                            : (i
                                    .y = u * n.subHeight + n.subHeight / 2 + n.preHeight,
                                i.execution_date != null &&
                                    i.execution_date != "" &&
                                    (i.y = c.lastIndexOf(i.execution_date) * t[0].subHeight + t[0].subHeight / 2));
                        f = (new Date(i.recorded_date) - new Date(i.execution_date)) / tt;
                        i.type == "Inventor" &&
                        (r
                            .append("ellipse")
                            .attr("class", "box")
                            .datum(i)
                            .attr("cx", i.x)
                            .attr("cy", i.y)
                            .attr("rx", 110)
                            .attr("ry", 36), o
                            .append("line")
                            .attr("class", "tline")
                            .datum(i)
                            .attr("x1", 0)
                            .attr("y1", i.y)
                            .attr("x2", i.x - 110)
                            .attr("y2", i.y), r.append("text")
                            .attr("class", "btext")
                            .datum(i)
                            .attr("x", i.x)
                            .attr("y", i.y - 12)
                            .text(i.name)
                            .style("text-anchor", "middle"), r.append("text")
                            .attr("class", "btext2")
                            .datum(i)
                            .attr("x", i.x)
                            .attr("y", i.y + 6)
                            .text("Execution: " + i.execution_date)
                            .style("text-anchor", "middle")
                            .append("tspan")
                            .attr("x", i.x)
                            .attr("dy", "1.2em")
                            .text("Recorded: " + i.recorded_date)
                            .append("tspan")
                            .attr("class", f > 90 ? "active" : "")
                            .text(" (" + f + " days)"), i.document != "" &&
                            r.append("a")
                            .datum(i)
                            .attr("xlink:href", i.document)
                            .attr("target", "_blank")
                            .append("image")
                            .attr("x", i.x - 85)
                            .attr("y", i.y - 20)
                            .attr("width", 20)
                            .attr("height", 20)
                            .attr("xlink:href", "https://backyard.synpat.com/public/icons/pdf.svg"));
                        (i.type == "Ownership" || i.type == "Security") &&
                        (r.append("rect")
                            .attr("class", "box")
                            .datum(i)
                            .attr("x", i.x - 95)
                            .attr("y", i.y - 36)
                            .attr("rx", 5)
                            .attr("ry", 5)
                            .attr("width", 190)
                            .attr("height", 72), o
                            .append("line")
                            .attr("class", "tline")
                            .datum(i)
                            .attr("x1", 0)
                            .attr("y1", i.y)
                            .attr("x2", i.x - 95)
                            .attr("y2", i.y), i.name.length <= 24
                            ? r.append("text").attr("class", "btext").datum(i).attr("x", i.x - 65).attr("y", i.y - 8).text(i.name)
                            : (e = i.name.substr(0, 25).lastIndexOf(" "), r.append("text")
                                .attr("class", "btext")
                                .datum(i)
                                .attr("x", i.x - 65)
                                .attr("y", i.y - 18)
                                .text(i.name.substr(0, e))
                                .append("tspan")
                                .attr("x", i.x - 65)
                                .attr("dy", "1.2em")
                                .text(i.name.substr(e + 1))), r.append("text")
                            .attr("class", "btext2")
                            .datum(i)
                            .attr("x", i.x - 84)
                            .attr("y", i.y + 15)
                            .text("Execution: " + i.execution_date)
                            .append("tspan")
                            .attr("x", i.x - 84)
                            .attr("dy", "1.2em")
                            .text("Recorded: " + i.recorded_date)
                            .append("tspan")
                            .attr("class", f > 90 ? "active" : "")
                            .text(" (" + f + " days)"), i.document != "" &&
                            r.append("a")
                            .datum(i)
                            .attr("xlink:href", i.document)
                            .attr("target", "_blank")
                            .append("image")
                            .attr("x", i.x - 90)
                            .attr("y", i.y - 25)
                            .attr("width", 20)
                            .attr("height", 20)
                            .attr("xlink:href", "https://backyard.synpat.com/public/icons/pdf.svg"));
                        i.type == "3rdParties" &&
                        (i.execution_date == null || i.execution_date == ""
                            ? (r.append("rect")
                                .attr("class", "box")
                                .datum(i)
                                .attr("x", i.x - 200)
                                .attr("y", i.y - 15)
                                .attr("rx", 5)
                                .attr("ry", 5)
                                .attr("width", 400)
                                .attr("height", 30), r.append("text")
                                .attr("class", "btext")
                                .datum(i)
                                .attr("x", i.x - 180)
                                .attr("y", i.y)
                                .attr("dy", "0.32em")
                                .text(i.name))
                            : (r.append("rect")
                                .attr("class", "box")
                                .datum(i)
                                .attr("x", i.x - 200)
                                .attr("y", i.y - 30)
                                .attr("rx", 5)
                                .attr("ry", 5)
                                .attr("width", 400)
                                .attr("height", 60), o.append("line")
                                .attr("class", "tline")
                                .datum(i)
                                .attr("x1", 0)
                                .attr("y1", i.y)
                                .attr("x2", i.x - 200)
                                .attr("y2", i.y), r
                                .append("text")
                                .attr("class", "btext")
                                .datum(i)
                                .attr("x", i.x - 180)
                                .attr("y", i.y - 10)
                                .text(i.name), r.append("text")
                                .attr("class", "btext2")
                                .datum(i)
                                .attr("x", i.x - 180)
                                .attr("y", i.y + 8)
                                .text("Execution: " + i.execution_date)
                                .append("tspan")
                                .attr("x", i.x - 180)
                                .attr("dy", "1.2em")
                                .text("Recorded: " + i.recorded_date)
                                .append("tspan")
                                .attr("class", f > 90 ? "active" : "")
                                .text(" (" + f + " days)")))
                    });
                    p += n.sub * n.subWidth
                });
                c.forEach(function(n, i) {
                    (o
                            .append("text")
                            .attr("class", "thead")
                            .attr("x", -10)
                            .attr("y", (i + .5) * t[0].subHeight)
                            .attr("dy", "0.32em")
                            .text(n.replace("d", "")), i != 0) &&
                        o.append("text")
                        .attr("class", "thead2")
                        .attr("x", 5)
                        .attr("y", i * t[0].subHeight)
                        .attr("dy", "0.32em")
                        .text((new Date(n.replace("d", "")) - new Date(c[i - 1].replace("d", ""))) / tt + " days")
                });
                ut = d3.line().x(function(n) { return n[0] }).y(function(n) { return n[1] }).curve(d3.curveBasis);
                n.connection.forEach(function(t) {
                    var h = n.connection.filter(function(n) { return n.start_id == t.start_id && n.end_id == t.end_id && n.type == t.type && n.id < t.id }),
                        i,
                        r,
                        v;
                    if (!(h.length > 0) &&
                        (t.type == "Security" &&
                        (h = n.connection
                                .filter(function(n) { return n.type == "Release" && n.ref_id == t.id }),
                            h.length > 0 && (t.ref_id_go = h[0].id, t.release_date = h[0].date)
                        ), t
                            .type !=
                            "Release" ||
                            (h = n.connection.filter(function(n) { return n.type == "Security" && n.id == t.ref_id }), !(h.length > 0))) &&
                        (i = l[t.start_id], r = l[t.end_id], i != null && r != null)) {
                        var u, e, s = [], c = t.ref_id_go ? 0 : 1 + i.outTypes.indexOf(t.type), a = t.ref_id_go ? 0 : 1 + r.inTypes.indexOf(t.type);
                        i.type == "3rdParties"
                            ? (u = [i.x - 200, i.y - c * 5], s.push([u[0] - 50, u[1]]))
                            : i.x + 100 < r.x && i.type != "Inventor"
                            ? (u = [i.x + 95, i.y - c * 10], s.push([u[0] + 50, u[1]]))
                            : i.x > r.x + 100 && i.type != "Inventor"
                            ? (u = [i.x - 95, i.y - c * 10], s.push([u[0] - 50, u[1]]))
                            : (u = [i.x, i.y + 36], s.push([u[0], u[1] + 20]));
                        s.splice(0, 0, u);
                        r.type == "3rdParties"
                            ? (e = [r.x - 200, r.y + a * 5], s.push([e[0] - 50, e[1]]))
                            : i.x + 100 < r.x
                            ? (e = [r.x - 95, r.y + a * 10], s.push([e[0] - 50, e[1]]))
                            : i.x > r.x + 100 ? (e = [r.x + 95, r.y + a * 10], s.push([e[0] + 50, e[1]])) : (e = [r.x, r.y - 36], s.push([e[0], e[1] - 20]));
                        s.push(e);
                        v = o.append("g")
                            .datum(t)
                            .append("path")
                            .attr("class", "connection")
                            .datum(s)
                            .attr("d", ut)
                            .attr("marker-end",
                                "url(#end" +
                                (t.type == "Ownership" ? "0" : t.type == "Security" ? "1" : t.type == "Release" ? "2" : t.type == "ChangeOfName" ? "3" : "4") +
                                ")")
                            .style("stroke",
                                t.type == "Ownership"
                                ? "#D62D20"
                                : t.type == "Security" ? "#FFA700" : t.type == "Release" ? "#008744" : t.type == "ChangeOfName" ? "#4285F4" : "#8329AD");
                        t.type == "Security" && t.ref_id_go
                            ? v.attr("marker-start", "url(#start1)").style("stroke-dasharray", "10,5")
                            : (i.dottedOnly = 0, r.dottedOnly = 0);
                        f.indexOf(t.date) < 0 && f.push(t.date)
                    }
                });
                f.sort();
                console.log(f);
                h = g.append("div").attr("class", "menu").style("width", it + u.left + u.right + "px");
                h.append("label")
                    .text("Ownership")
                    .style("position", "absolute")
                    .style("top", "14px")
                    .style("left", u.left + t[0].subWidth * t[0].sub / 2 - 38 + "px");
                h.append("input")
                    .attr("type", "checkbox")
                    .attr("checked", "checked")
                    .style("position", "absolute")
                    .style("top", "12px")
                    .style("left", "50px")
                    .style("width", "18px")
                    .style("height", "18px")
                    .on("change",
                        function() {
                            var n = d3.select(this).property("checked") ? 1 : 0;
                            rt.selectAll(".hline").style("opacity", n);
                            o.selectAll(".tline").style("opacity", n);
                            o.selectAll(".thead").style("opacity", n);
                            o.selectAll(".thead2").style("opacity", n)
                        });
                var w = 1,
                    k = 1,
                    at = h.append("label")
                        .style("position", "absolute")
                        .style("width", "120px")
                        .style("top", "16px")
                        .style("left", u.left + t[0].subWidth * t[0].sub + t[1].subWidth * t[1].sub / 2 - 42 + "px")
                        .text("Security");
                at.append("input")
                    .lower()
                    .attr("type", "checkbox")
                    .attr("checked", "checked")
                    .style("width", "18px")
                    .style("height", "18px")
                    .style("vertical-align", "middle")
                    .style("margin-top", "-2px")
                    .style("margin-right", "5px")
                    .on("change",
                        function() {
                            w = d3.select(this).property("checked") ? 1 : 0;
                            v()
                        });
                ft = h.append("label")
                    .style("position", "absolute")
                    .style("width", "200px")
                    .style("top", "16px")
                    .style("left", u.left + t[0].subWidth * t[0].sub + t[1].subWidth * t[1].sub + t[2].subWidth * t[2].sub / 2 - 78 + "px")
                    .text("License / 3rdParty");
                ft.append("input")
                    .lower()
                    .attr("type", "checkbox")
                    .attr("checked", "checked")
                    .style("width", "18px")
                    .style("height", "18px")
                    .style("vertical-align", "middle")
                    .style("margin-top", "-2px")
                    .style("margin-right", "5px")
                    .on("change",
                        function() {
                            k = d3.select(this).property("checked") ? 1 : 0;
                            v()
                        });
                a = 1;
                et = h.append("label")
                    .style("position", "absolute")
                    .style("width", "120px")
                    .style("top", "16px")
                    .style("left", t[0].subWidth * t[0].sub + t[1].subWidth * t[1].sub - 80 + "px")
                    .text("Release");
                et.append("input")
                    .lower()
                    .attr("type", "checkbox")
                    .attr("checked", "checked")
                    .style("width", "18px")
                    .style("height", "18px")
                    .style("vertical-align", "middle")
                    .style("margin-top", "-2px")
                    .style("margin-right", "5px")
                    .on("change",
                        function() {
                            a = d3.select(this).property("checked") ? 1 : 0;
                            v()
                        });
                e = f.length - 1;
                d = h.append("div").attr("class", "buttons");
                d.append("button").text("<").on("click", function() { e > 0 && (e--, v()) });
                d.append("button").text(">").on("click", function() { e < f.length - 1 && (e++, v()) });
                d.append("button").text("|<").on("click", function() { e > 0 && (e = 0, v()) });
                d.append("button").text(">|").on("click", function() { e < f.length - 1 && (e = f.length - 1, v()) });
                h.append("div")
                    .attr("id", "slider1")
                    .style("position", "absolute")
                    .style("top", "18px")
                    .style("left", t[0].subWidth * t[0].sub + 110 + "px")
                    .style("width", "100px");
                var pt = h.append("div")
                        .attr("id", "slider2")
                        .style("position", "absolute")
                        .style("top", "18px")
                        .style("left", t[0].subWidth * t[0].sub + t[1].subWidth * t[1].sub + 110 + "px")
                        .style("width", "100px"),
                    i = 0,
                    s = 0;
                $("#slider1")
                    .slider({
                        range: "min",
                        value: 0,
                        min: 0,
                        max: 400,
                        slide: function(n, t) {
                            i = t.value;
                            vt()
                        }
                    });
                $("#slider2")
                    .slider({
                        range: "min",
                        value: 0,
                        min: 0,
                        max: 400,
                        slide: function(n, t) {
                            s = t.value;
                            vt()
                        }
                    });
                ot = g.append("div").attr("class", "tooltip").style("opacity", 0);
                b = g.append("div").attr("class", "popup").style("display", "none");
                o.selectAll(".connection")
                    .on("mouseover",
                        function() {
                            if (d3.select(this).style("opacity") != 0) {
                                var n = d3.select(this.parentNode).datum(),
                                    t = n.type == "Ownership"
                                        ? "ASSIGNMENT OF ASSIGNORS INTEREST"
                                        : n.type == "ChangeOfName"
                                        ? "CHANGE OF NAME"
                                        : n.type == "License" ? "LICENSE" : n.type == "Release" ? "RELEASE OF SECURITY INTEREST" : "SECURITY INTEREST",
                                    i = d3.mouse(y.node());
                                n.ref_id_go && n.release_date <= f[e] && (t = "RELEASE OF SECURITY INTEREST");
                                ot.html(t).style("left", i[0] + 10 + "px").style("top", i[1] - 10 + "px").style("opacity", 1)
                            }
                        })
                    .on("mouseout", function() { ot.style("opacity", 0) })
                    .on("click",
                        function() {
                            var i = d3.select(this.parentNode).datum(),
                                h = n.popup.filter(function(n) { return n.id == i.popuptop }),
                                c = n.popup.filter(function(n) { return n.id == i.popupbottom }),
                                t = "",
                                r = [],
                                u,
                                s,
                                l;
                            if (o
                                .selectAll(".connection.active")
                                .classed("active", !1), d3
                                .select(this)
                                .classed("active", !0), h.length > 0 && r.push(h[0]), c
                                .length >
                                0 &&
                                r.push(c[0]), i.ref_id_go &&
                                i.release_date <= f[e] &&
                                (u = n.connection
                                    .filter(function(n) { return n.id == i.ref_id_go }),
                                u.length > 0 &&
                                (s = n.popup.filter(function(n) { return n.id == u[0].popuptop }), l = n.popup
                                    .filter(function(n) { return n.id == u[0].popupbottom }), s.length > 0 && r.push(s[0]))), r.forEach(function(n, i) {
                                t += "<div data-id='" + i + "'><a href='javascript:void(0)'>Close<\/a>";
                                t += "<label>" + n.conveyanceText + "<\/label>";
                                t += "<table class='top'>";
                                t += "<tr><td>Date recorded<br/>" +
                                    new Date(n.recordedDate).toLocaleDateString() +
                                    "<\/td><td>Reel/frame<br/>" +
                                    n.displayId +
                                    "<\/td><\/tr>";
                                t += "<tr><td>Assignors<br/>" +
                                    n.patAssignorName.join("<br/>") +
                                    "<\/td><td>Execution date<br/>" +
                                    new Date(n.patAssignorEarliestExDate).toLocaleDateString() +
                                    "<\/td><\/tr>";
                                t += "<tr><td>Assignee<br/>" + n.patAssigneeName[0];
                                n.patAssigneeAddress1.length > 0 && n.patAssigneeAddress1[0] != "NULL" && (t += "<br/>" + n.patAssigneeAddress1[0]);
                                n.patAssigneeCity.length > 0 &&
                                    n.patAssigneePostcode.length > 0 &&
                                    (t += "<br/>" + n.patAssigneeCity[0] + " " + n.patAssigneePostcode[0]);
                                t += "<\/td><td>Correspondent<br/>" +
                                    n.corrName +
                                    "<br/>" +
                                    n.corrAddress1 +
                                    "<br/>" +
                                    n.corrAddress2 +
                                    "<br/>" +
                                    n.corrAddress3 +
                                    "<\/td><\/tr>";
                                t += "<\/table>";
                                t += "<label class='prop'><span>-<\/span> Properties (" + n.inventionTitle.length + " total)<\/label>";
                                t += "<table class='bottom'>";
                                t +=
                                    "<thead><tr><th>Patent<\/th><th>Publication<\/th><th>Application<\/th><th>PCT International registration<\/th><\/tr><\/thead>";
                                t += "<tbody>";
                                n.inventionTitle.forEach(function(i, r) {
                                    n.patNum[r] == "NULL" && (n.patNum[r] = "");
                                    n.publNum[r] == "NULL" && (n.publNum[r] = "");
                                    n.applNum[r] == "NULL" && (n.applNum[r] = "");
                                    n.pctNum[r] == "NULL" && (n.pctNum[r] = "");
                                    t += "<tr class='title'><td colspan='4'>" + (r + 1) + ". " + i + "<\/td><\/tr>";
                                    t += "<tr><td>" +
                                        n.patNum[r] +
                                        "<\/td><td>" +
                                        n.publNum[r] +
                                        "<\/td><td>" +
                                        n.applNum[r] +
                                        "<\/td><td>" +
                                        n.pctNum[r] +
                                        "<\/td><\/tr>"
                                });
                                t += "<\/tbody>";
                                t += "<\/table>";
                                t += "<\/div>"
                            }), t.length > 0) {
                                b.html(t).style("display", "inline");
                                b.selectAll("a")
                                    .on("click",
                                        function() {
                                            b.html("").style("display", "none");
                                            o.selectAll(".connection.active").classed("active", !1)
                                        });
                                b.selectAll(".prop")
                                    .on("click",
                                        function() {
                                            $(this).next().is(":visible")
                                                ? ($(this).next().hide(), $(this).find("span").html("+"))
                                                : ($(this).next().show(), $(this).find("span").html("-"))
                                        });
                                $(".popup > div")
                                    .resizable({
                                        handles: "e",
                                        resize: function(n, t) {
                                            var i = $(this).attr("data-id");
                                            $(".popup > div").each(function() { $(this).attr("data-id") != i && $(this).css("width", t.size.width + "px") })
                                        }
                                    })
                            } else b.html("").style("display", "none")
                        });
                $(".popup").draggable({ start: function() { $(".popup").css("right", "auto") } });
                $(window).scroll(function() { $(".menu").css("top", $(this).scrollTop() + 1 + "px") })
            });

}
function getValue(o) {
	var $this = o;
	$this.parent().find('.txt_modified').val($this.val());
	var ID = $this.parents('tr').attr('data-id');
	var fnName = $this.parents('tr').attr('data-name');
	if($this.val() != "") {
		jQuery.ajax({
			type:'POST',
			url: 'https://backyard.synpat.com/leads/'+fnName,
			data:{id:ID,value:$this.val()}
		}).done(function(s){
			console.log(s);
		});
	} else {
		alert("Value cannot be left blank");
	}
}
function getAllAssignment(){
	if($('body').find('#show_assignments').length > 0 ){
		$('body').find('#show_assignments').remove();
	} else {
		if(assignmentList != "") {
			try{
				var fullList = assignmentList;
				var table = "<table class='table table-striped tablesorter table_entities' id='table_entities'><thead><tr class='entities_row'><th class='entities_col'>Original</th><th class='entities_col'>Modified</th></tr></thead><tbody>";
				fullList.forEach(function(name){
					var assignment = "";
					var changeName = "";
					var securityInterest = "";
					var release = "";
					var license = "";
					var licenseExpiration = "";
					if(name.modified != "") {
						switch(name.modified) {
							case 'ASSIGNMENT OF ASSIGNORS INTEREST':
								assignment = "SELECTED='SELECTED'";
								break;
							case 'CHANGE OF NAME':
								changeName = "SELECTED='SELECTED'";
								break;
							case 'SECURITY INTEREST':
								securityInterest = "SELECTED='SELECTED'";
								break;
							case 'RELEASE OF SECURITY INTEREST':
								release = "SELECTED='SELECTED'";
								break;
							case 'LICENSE':
								license = "SELECTED='SELECTED'";
								break;
							case 'LICENSE EXPIRATION':
								licenseExpiration = "SELECTED='SELECTED'";
								break;
						}
					}
					var _options = "<option value=''></option><option value='ASSIGNMENT OF ASSIGNORS INTEREST' "+assignment+">ASSIGNMENT OF ASSIGNORS INTEREST</option><option value='CHANGE OF NAME' "+changeName+">CHANGE OF NAME</option><option value='SECURITY INTEREST' "+securityInterest+">SECURITY INTEREST</option><option value='RELEASE OF SECURITY INTEREST' "+release+">RELEASE OF SECURITY INTEREST</option><option value='LICENSE' "+license+">LICENSE</option><option value='LICENSE EXPIRATION' "+licenseExpiration+">LICENSE EXPIRATION</option>";
					_select = "<select onchange='getValue(jQuery(this))'>"+_options+"</select>";
					table += "<tr data-id='"+name.id+"' data-name='lead_assignment_heading_modified' class='entities_row'><td class='entities_col'>"+name.original+"</td><td class='entities_col'>"+_select+"<input type='hidden' value='"+name.modified+"' style='width:350px;' class='txt_modified' /></td></tr>";
				});
				table += "</tbody></table>";
				var offset = jQuery("#btnAssignments").offset();
				var position = jQuery("#btnAssignments").position();
				_b=0,_r=0;
				var windowWidth = jQuery(window).width();
				var popWidth = 900;
				_t = position.top + 45;
				_t = 0;
				_l = 0; 
				$('.search-form-help-text').remove();
				$('#container').append('<div id="show_assignments" class="loading search-form-help-text" style="top:'+_t+'px;left:'+_l+'px;right:'+_r+'px;bottom:'+_b+'px;width:'+popWidth+'px;height:'+_toolTipHeight+'px;overflow:hidden;overflow-y:auto;background:#fff;"></div>');
				$("#show_assignments").append(table);
				callSorttable("table_entities");
				callOnChange();
				setTimeout(function(){$("#show_assignments").removeClass('loading');},300);
			}catch(e) {
				console.log(e)
			}		
		}
	}
}
function getAllNames() {
	if($('body').find('#show_table').length > 0 ){
		$('body').find('#show_table').remove();
	} else {
		if(namesList != "") {
			try{
				var fullList = namesList;
				var table = "<table class='table table-striped tablesorter table_entities' id='table_entities'><thead><tr class='entities_row'><th class='entities_col'>Original</th><th class='entities_col'>Modified</th></tr></thead><tbody>";
				fullList.forEach(function(name){
					table += "<tr data-id='"+name.id+"' data-name='lead_assignment_name_modified' class='entities_row'><td class='entities_col'>"+name.original+"</td><td class='entities_col'><input type='text' value='"+name.modified+"' style='width:350px;' class='txt_modified'/></td></tr>";
				});
				table += "</tbody></table>";
				var offset = jQuery("#btnEntries").offset();
				var position = jQuery("#btnEntries").position();
				_b=0,_r=0;
				var windowWidth = jQuery(window).width();
				var popWidth = 900;
				_t = position.top + 45;
				_t = 0;
				/*_l = windowWidth - popWidth; */
				_l = 0; 
				$('.search-form-help-text').remove();
				$('#container').append('<div id="show_table" class="loading search-form-help-text" style="top:'+_t+'px;left:'+_l+'px;right:'+_r+'px;bottom:'+_b+'px;width:'+popWidth+'px;height:'+_toolTipHeight+'px;overflow:hidden;overflow-y:auto;background:#fff;"></div>');
				$("#show_table").append(table);
				callSorttable('table_entities');
				callOnChange();
				setTimeout(function(){$("#show_table").removeClass('loading');},300);
			}catch(e) {
				console.log(e)
			}		
		}
	}	
}
function callSorttable(id) {
	$("#"+id).tablesorter();
}
function callOnChange() {
	jQuery('.txt_modified').on('keyup',function(){
		var $this = $(this);
		var ID = $this.parents('tr').attr('data-id');
		var fnName = $this.parents('tr').attr('data-name');
		jQuery.ajax({
			type:'POST',
			url: 'https://backyard.synpat.com/leads/'+fnName,
			data:{id:ID,value:$this.val()}
		}).done(function(s){
			console.log(s);
		});	
	});
}
jQuery(document).ready(function(){
	if(patent_number != "") {
		jQuery("#txt_patent_number").val(patent_number);
		jQuery("#log_message").html("Loading...");
		createIllustration(patent_number);
	}
});
</script>
</body>
</html>