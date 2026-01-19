<!DOCTYPE html> 

<html>

<head>

	<title>Family Tree</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="https://storage.googleapis.com/static.synpat.com/store/family/demo/js/jquery/jquery-1.9.1.js"></script>

	<script type="text/javascript" src="https://storage.googleapis.com/static.synpat.com/store/family/demo/js/jquery/jquery-ui-1.10.2.custom.min.js"></script>

	<link href="https://storage.googleapis.com/static.synpat.com/store/family/demo/js/jquery/ui-lightness/jquery-ui-1.10.2.custom.css" media="screen" rel="stylesheet" type="text/css" />



	<!-- jQuery UI Layout -->

	<script type="text/javascript" src="https://storage.googleapis.com/static.synpat.com/store/family/demo/jquerylayout/jquery.layout-latest.min.js"></script>

	<link rel="stylesheet" type="text/css" href="https://storage.googleapis.com/static.synpat.com/store/family/demo/jquerylayout/layout-default-latest.css" />
	<link rel="stylesheet" type="text/css" href="https://storage.googleapis.com/static.synpat.com/backyard/elements/tables.css" />



	<script type="text/javascript">

		jQuery(document).ready(function () {

			jQuery('body').layout(

			{

				center__paneSelector: "#contentpanel"

			});

		});

	</script>
	<style>
	.ui-accordion .ui-accordion-content{padding:1em 5px}
	</style>


	<!-- header -->



	<!-- # include file="src/src.primitives.html"-->



	<link href="https://storage.googleapis.com/static.synpat.com/store/family/demo/css/primitives.latest.css" media="screen" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="https://storage.googleapis.com/static.synpat.com/store/family/demo/js/primitives.min.js?3706"></script>

	<script type="text/javascript" src="https://storage.googleapis.com/static.synpat.com/store/family/demo/js/bporgeditor.min.js?3706"></script>

	<script type="text/javascript" src="https://storage.googleapis.com/static.synpat.com/store/family/patents/patents.js"></script>
	<script type="text/javascript" src="https://storage.googleapis.com/static.synpat.com/backyard/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>public/family/patents/configuration.js"></script>

	<script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>public/family/patents/data.js"></script>
<style>

/*#centerpanel .orgdiagram{height:65vh !important}*/
.search-form-help-text{position:absolute;width:320px;padding:10px;border:1px solid #e4e4e4;z-index:9;background:#fff;top:27px;box-shadow:0 0 10px 6px rgba(0,0,0,.1);border-radius:4px;right:0}.search-form-help-text dl,.search-form-help-text p,.search-form-help-text p a{font-size:15px}
</style>


	<script type="text/javascript">

		var famDiagram = null;

		var fromItem = 0;

		var toItem = 0;

		var userData = null;

		var optionsRender = null;
		
		var countryList = [];

		jQuery(document).ready(function () {

			jQuery.ajaxSetup({

				cache: false

			});
			
			jQuery.getJSON("http://backyard.synpat.com/partners/patent_illustration_epo_json/<?php echo $number;?>", function (data) {
				userData = data;
				showDataAtSource(data);
				
				if(userData.details.length>0){
					jQuery.each(userData.details,function(i,c){
						if(c.country!=""){
							if(jQuery.inArray(c.country,countryList)<0){
								countryList.push(c.country);
							}
						}
					});
				}
				
				optionsRender = primitives.helpers.controls.getFamDiagramOptionsRender([

					new primitives.helpers.controls.PanelConfig("Patents", [

						new primitives.helpers.controls.CaptionConfig("Legal Status", false),

						new primitives.helpers.controls.CheckBoxConfig("legalStatusActive", true, "Active", onUpdate),

						new primitives.helpers.controls.CheckBoxConfig("legalStatusExpired", true, "Expired", onUpdate),

						new primitives.helpers.controls.CheckBoxConfig("legalStatusAbandoned", true, "Abandoned", onUpdate),
						
						new primitives.helpers.controls.CheckBoxConfig("legalStatusForeign", true, "Other", onUpdate),

					new primitives.helpers.controls.CaptionConfig("Relations", false),

						new primitives.helpers.controls.CheckBoxConfig("relationStatusContinuationInPart", true, "<span style='color:purple;'>CIP</span>", onUpdate),

						new primitives.helpers.controls.CheckBoxConfig("relationStatusContinuation", true, "<span style='color:red;'>CP</span>", onUpdate),

						new primitives.helpers.controls.CheckBoxConfig("relationStatusDivisional", true, "DIV", onUpdate)
					])

				], {

					/* Patents Related options */

					legalStatusActive: true,

					legalStatusExpired: true,

					legalStatusAbandoned: true,
					
					legalStatusForeign: true,



					relationStatusContinuationInPart: true,

					relationStatusContinuation: true,

					relationStatusDivisional: true,



					/* Family Diagram Specific Options */

					neighboursSelectionMode: primitives.common.NeighboursSelectionMode.ParentsAndChildren,

					groupByType: primitives.common.GroupByType.Children,

					alignBylevels: "false",



					/* On-screen annotations specific options */

					AnnotationOptions: {

						connectorPlacementType: primitives.common.ConnectorPlacementType.Offbeat,

						connectorShapeType: primitives.common.ConnectorShapeType.OneWay,

						labelPlacementType: primitives.common.ConnectorLabelPlacementType.Between,

						lineWidth: 2,

						lineType: primitives.common.LineType.Dashed,

						color: primitives.common.Colors.Red,

						offset: 5,

						zOrderType: primitives.common.ZOrderType.Auto,

						linesPalette: [

							new primitives.famdiagram.PaletteItemConfig({ lineColor: "#C6C6C6", lineWidth: 1, lineType: primitives.common.LineType.Solid }), //1

							new primitives.famdiagram.PaletteItemConfig({ lineColor: "#A5A5A5", lineWidth: 1, lineType: primitives.common.LineType.Dashed }), //4

							new primitives.famdiagram.PaletteItemConfig({ lineColor: "#848484", lineWidth: 1, lineType: primitives.common.LineType.Solid }), //7

							new primitives.famdiagram.PaletteItemConfig({ lineColor: "#646464", lineWidth: 1, lineType: primitives.common.LineType.Dashed }), //10

							new primitives.famdiagram.PaletteItemConfig({ lineColor: "#454545", lineWidth: 1, lineType: primitives.common.LineType.Solid }) //13

						]

					},

					/* Layout */

					pageFitMode: primitives.common.PageFitMode.None,

					orientationType: primitives.common.OrientationType.Top,

					verticalAlignment: primitives.common.VerticalAlignmentType.Middle,

					horizontalAlignment: primitives.common.HorizontalAlignmentType.Center,

					childrenPlacementType: primitives.common.ChildrenPlacementType.Horizontal,

					leavesPlacementType: primitives.common.ChildrenPlacementType.Horizontal,

					minimalVisibility: primitives.common.Visibility.Dot,

					selectionPathMode: primitives.common.SelectionPathMode.None,



					hasButtons: primitives.common.Enabled.Auto,

					hasSelectorCheckbox: primitives.common.Enabled.True,

					selectCheckBoxLabel: "Selected",

					itemTitleFirstFontColor: primitives.common.Colors.White,

					itemTitleSecondFontColor: primitives.common.Colors.White,

					buttonsPanelSize: 28,

					groupTitlePanelSize: 24,

					checkBoxPanelSize: 24,



					/* Template */

					DefaultTemplateOptions: {

						minimizedItemCornerRadius: 8,

						minimizedItemSize: new primitives.common.Size(16, 16),

						highlightPadding: 4,

						minimizedItemShapeType: primitives.common.ShapeType.None,

						minimizedItemLineWidth: 1,

						minimizedItemLineType: primitives.common.LineType.Solid,

						minimizedItemBorderColor: null,

						minimizedItemFillColor: null,

						minimizedItemOpacity: 1.0

					},



					/* Intervals */

					normalLevelShift: 20,

					dotLevelShift: 20,

					lineLevelShift: 20,

					normalItemsInterval: 20,

					dotItemsInterval: 10,

					lineItemsInterval: 10,

					cousinsIntervalMultiplier: 1,



					/* Connectors */

					arrowsDirection: primitives.common.GroupByType.Children,

					showExtraArrows: true,

					extraArrowsMinimumSpace: 30,

					connectorType: primitives.common.ConnectorType.Squared,

					elbowType: primitives.common.ElbowType.Round,

					bevelSize: 4,

					elbowDotSize: 4,

					lineType: primitives.common.LineType.Solid,

					linesColor: primitives.common.Colors.Black,

					linesWidth: 1,



					/* Labels */

					showLabels: primitives.common.Enabled.False,

					labelSize: new primitives.common.Size(80, 24),

					labelOrientation: primitives.text.TextOrientationType.Horizontal,

					labelPlacement: primitives.common.PlacementType.Top,

					labelOffset: 1,

					labelFontSize: "10px",

					labelFontFamily: "Arial",

					labelColor: primitives.common.Colors.Black,

					labelFontWeight: "normal",

					labelFontStyle: "normal",



					/* Callout */

					showCallout: "true",

					calloutPlacementOffset: 300,

					calloutfillColor: "#000000",

					calloutBorderColor: null,

					calloutOffset: 4,

					calloutCornerRadius: 4,

					calloutPointerWidth: "10%",

					calloutLineWidth: 1,

					calloutOpacity: 0.2,



					/* Interactivity */

					navigationMode: primitives.common.NavigationMode.Default,

					highlightGravityRadius: 40,

					enablePanning: true,



					/* Graphics */

					graphicsType: primitives.common.GraphicsType.SVG,



					scale: 1.0

				},

				/* On property change event handler */

				onUpdate

				);
				
				
				
				
				
				jQuery('#contentpanel').layout(

					{

						center__paneSelector: "#centerpanel"

						, south__paneSelector: "#southpanel"

						, south__resizable: false

						, south__closable: false

						, south__spacing_open: 0

						, south__size: 50

						, west__size: 200

						, west__paneSelector: "#westpanel"

						, west__resizable: true

						, center__onresize: function () {

							if (famDiagram != null) {

								jQuery("#centerpanel").famDiagram("update", primitives.common.UpdateMode.Refresh);

							}

						}

					});

					if(countryList.length>0){						
						optionsRender.panels[0].items.push(new primitives.helpers.controls.CaptionConfig("Country", false)),
						jQuery.each(countryList,function(n,c){
							optionsRender.panels[0].items.push(new primitives.helpers.controls.CheckBoxConfig(c, true, c, onUpdate));
							optionsRender.defaultValues[c] = true;
						});
					}

					optionsRender.render(jQuery("#westpanel"));



					/* Setup & Run */

					Setup(jQuery("#centerpanel"));
				
				
				
				
					onUpdate();

			});
		});
		var showD = [];
		function showDataAtSource(d){
			if(d.links.length>0){
				var table = jQuery("<table/>").attr('id',"info_table").addClass('table');
				var thead = jQuery("<thead/>");
				var tr = jQuery("<tr/>");
				var th7 = jQuery("<th/>").append("Asset").css('text-align','left');
				tr.append(th7);
				var th = jQuery("<th/>").append("Filled on").css('text-align','left');
				tr.append(th);
				thead.append(tr);
				var tbody = jQuery("<tbody/>");
				jQuery.each(d.links,function(s,link){
					if(link.parent=="1"){
						var relationType = link.relation_type;
						relationType = relationType.replace('This application','');
						var patentAppNumber = link.patent_app_number;
						var relationNumber = link.relation_number;
						var patentPatentNumber = "";
						var relationPatentNumber = "";
						var filledOn = "";
						if(d.details.length>0){
							jQuery.each(d.details,function(s,app_data){
								if(patentPatentNumber=="" || relationPatentNumber ==""){
									if(app_data.application_number==patentAppNumber){
										if(app_data.patent_number!="" && app_data.patent_number!="-"){
											patentPatentNumber = app_data.patent_number;
											filledOn = app_data.filling_date;
										}
									}
									if(app_data.application_number==relationNumber){
										if(app_data.patent_number!="" && app_data.patent_number!="-"){
											relationPatentNumber = app_data.patent_number;
										}
									}
								} else {
									return;
								}
							})
						}
						var stringShow = patentPatentNumber +" ("+patentAppNumber+") "+relationType+ " "+relationPatentNumber+" ("+relationNumber+") ";
						var tr = jQuery("<tr/>");
						var td1 = jQuery("<td/>").append(stringShow);tr.append(td1);
						var status = "";
						var td1 = jQuery("<td/>").append(filledOn);tr.append(td1);
						tbody.append(tr);
					}					
				});
				table.append(thead).append(tbody);
				appendToDiagram(table);
				
			}
		}
		var cs;
		function appendToDiagram(t){
			/*cs = setInterval(function(){
				if(jQuery("#centerpanel").find('.orgdiagram').length>0){
					jQuery("#centerpanel").append(t);
					jQuery("#info_table").tablesorter({
						headers:{
							0: { sorter: false} 
						},
						sortList: [[1,0]]
					});
					jQuery("#info_table ").find('tr').each(function(){
						if(jQuery(this).find('th').length>0){
							jQuery(this).find('th').eq(1).css('display','none');
						}
						if(jQuery(this).find('td').length>0){
							jQuery(this).find('td').eq(1).css('display','none');
						}
					})
					clearInterval(cs);
				}
			},1000);*/ 
		}

		function Setup(selector) {

			famDiagram = selector.famDiagram(GetOrgDiagramConfig());

		}



		function Update(selector, updateMode) {

			selector.famDiagram("option", GetOrgDiagramConfig());

			selector.famDiagram("update", updateMode);
			
			checkIllustration();
		}
			
		var intervalS;
		function checkIllustration(){
			intervalS = setInterval(function(){
				if(jQuery('div[name="titleBackground"]').length>0){
					jQuery('div[name="titleBackground"]').parent().mouseenter(function() {
					var $this = jQuery(this);
					var position = $this.position();
					var offsetPosition = $this.offset();
					var top = position.top + 25;
					var left = offsetPosition.left - 10;
					var wW = jQuery(window).width();
					var calW = wW-425;
					var calT = top-50;
					if(left>calW){
						left = calW;
					}
					if(top>calT){
						top = calT;
					}
					console.log("asdasd");
					var articleNumber = $this.find('div[name="titleBackground"]').data('abstract-d');
					jQuery("#centerpanel").prepend('<div class="search-form-help-text" style="top:'+top+'px;left:'+left+'px"><p>'+articleNumber+'</p></div>');
					}).mouseleave(function() {
						var $this = jQuery(this);
						/*jQuery("#centerpanel").find('.search-form-help-text').remove();*/
					});
					clearInterval(intervalS);
				}
			},400);
		}

		function onUpdate() {

			Update(jQuery("#centerpanel"), primitives.common.UpdateMode.Recreate);
			
			

		};



		function GetOrgDiagramConfig() {

			options = optionsRender.getValues();



			jQuery.extend(options, patents.configuration.getConfig());



			jQuery.extend(options, {

				onCursorChanging: onCursorChanging,

				onCursorChanged: onCursorChanged,

				onHighlightChanging: onHighlightChanging,

				onHighlightChanged: onHighlightChanged,

				onSelectionChanged: onSelectionChanged

			});



			if (userData != null) {
				jQuery.extend(options, patents.data.getData(userData, options));

			}



			return options;

		}



		function getDefaultTemplate(options) {

			var result = new primitives.orgdiagram.TemplateConfig();

			result.name = "defaultTemplate";



			// If we don't change anything in template then all its properties stays default

			// So we change only minimized item properties

			jQuery.extend(result, options.DefaultTemplateOptions);



			return result;

		}



		function getParentsList(data) {

			var message = "",

				index, len;
			if (data.parentItems.length > 0) {

				message += " Parent item <b>";

				for (index = 0, len = data.parentItems.length; index < len; index += 1) {

					if (index > 0) {

						message += ", ";

					}

					message += "'" + data.parentItems[index].title + "'";

				}

				message += "</b>";

			}



			return message;

		};



		function onSelectionChanged(e, data) {
			var selectedItems = jQuery("#centerpanel").famDiagram("option", "selectedItems");

			var message = "";

			for (var index = 0; index < selectedItems.length; index += 1) {

				var itemConfig = selectedItems[index];

				if (message != "") {

					message += ", ";

				}

				message += "<b>'" + itemConfig.title + "'</b>";

			}



			/*jQuery("#southpanel").empty().append("User selected following items: " + message);*/

		}



		function onHighlightChanging(e, data) {
			
			//patents.data.updateHighlightPathAnnotations(data.context.id, options.linkColor, primitives.common.ZOrderType.Background);

		}



		patents.data.updateHighlightPathAnnotations = function (itemid, linkColor, zOrderType) {

			var selector = jQuery("#centerpanel");

			var annotations = selector.famDiagram("option", "annotations");



			var newAnnotations = patents.data.getAnnotationsForItem(itemid, linkColor, zOrderType);



			selector.famDiagram("option", { annotations: newAnnotations });

		}



		function onHighlightChanged(e, data) {
			/*var message = data.context.abstract_d;
			jQuery("#centerpanel").find('.search-form-help-text').remove();
			if(message!=null){
				console.log("ANH");
				console.log(message);
				jQuery("#centerpanel").append('<div class="search-form-help-text" style="top:'+data.position.x+'px;left:'+data.position.y+'px"><p>'+message+'</p></div>');
			}*/
		}
		function onCursorChanging(e, data) {
			
			var message = "User is clicking on item '" + data.context.title + "'.";
			message += (data.parentItem != null ? " Parent item <b>'" + data.parentItem.title + "'" : "");
			/*jQuery("#southpanel").empty().append(message);*/
			data.oldContext.templateName = data.oldContext.defaultTemplate;
			data.context.templateName = "cursorTemplate";
			patents.data.updateHighlightPathAnnotations(data.context.id, options.linkColor, primitives.common.ZOrderType.Background);

		}
		function onCursorChanged(e, data) {
			
		}
		function openClosePane(){
			w = jQuery(window).width();
			w = w-2;
			if(jQuery('#westpanel').css('width')!='1px'){
				_W = w - 19;
				jQuery('#westpanel').css({width:'1px'});
				jQuery('#westpanel-resizer').css({left:'13px'});
				jQuery('#centerpanel').css({'width':_W+'px','left':'19px'});
			} else {
				w = w - 206;
				jQuery('#westpanel').css({width:'188px'});
				jQuery('#westpanel-resizer').css({left:'200px'});
				jQuery('#centerpanel').css({'width':w+'px',left:'206px'});
			}
		}
	</script>
	<!-- /header -->
</head>
<body style="font-size: 12px">
	<div id="contentpanel" style="padding: 0px;">
		<!--bpcontent-->
		<div id="westpanel" style="padding: 5px; margin: 0px; border-style: solid; font-size: 12px; border-color: grey; border-width: 1px; overflow: scroll; -webkit-overflow-scrolling: touch;"></div>
		<div id="centerpanel" style="overflow: hidden; padding: 0px; margin: 0px; border: 0px;"><a href="javascript://" onclick="openClosePane()">Close Left Pane</a></div>
		<div id="southpanel"></div>
		<!--/bpcontent-->
	</div>
</body>
</html>