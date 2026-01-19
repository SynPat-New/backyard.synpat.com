/**
 * @preserve Basic Primitives Diagram v3.7.1
 * Copyright (c) 2013 - 2017 Basic Primitives Inc
 *
 * Non-commercial - Free
 * http://creativecommons.org/licenses/by-nc/3.0/
 *
 * Commercial and government licenses:
 * http://www.basicprimitives.com/pdf/license.pdf
 *
 */

/* File: Basic Primitives (primitives.latest.js)*/
(function () {

	var namespace = function (name) {
		var namespaces = name.split('.'),
			namespace = window,
			index;
		for (index = 0; index < namespaces.length; index += 1) {
			namespace = namespace[namespaces[index]] = namespace[namespaces[index]] || {};
		}
		return namespace;
	};

	namespace("patents.configuration");
}());

patents.configuration.getConfig = function () {
	return {
		itemTitleFirstFontColor: primitives.common.Colors.White,
		itemTitleSecondFontColor: primitives.common.Colors.Black,
		linesPalette: [
			new primitives.famdiagram.PaletteItemConfig({ lineColor: "#C6C6C6", lineWidth: 1, lineType: primitives.common.LineType.Solid }), //1
			new primitives.famdiagram.PaletteItemConfig({ lineColor: "#A5A5A5", lineWidth: 1, lineType: primitives.common.LineType.Dashed }), //4
			new primitives.famdiagram.PaletteItemConfig({ lineColor: "#848484", lineWidth: 1, lineType: primitives.common.LineType.Solid }), //7
			new primitives.famdiagram.PaletteItemConfig({ lineColor: "#646464", lineWidth: 1, lineType: primitives.common.LineType.Dashed }), //10
			new primitives.famdiagram.PaletteItemConfig({ lineColor: "#454545", lineWidth: 1, lineType: primitives.common.LineType.Solid }) //13
		],
		defaultTemplateName: "contactTemplate",
		templates: [patents.configuration.getContactTemplate(), patents.configuration.getSubjectTemplate(), patents.configuration.getCursorTemplate()],
		onItemRender: patents.configuration.onTemplateRender
	};
}

patents.configuration.getContactTemplate = function () {
	var result = new primitives.famdiagram.TemplateConfig();
	result.name = "contactTemplate";
	result.minimizedItemSize = new primitives.common.Size(16, 16);
	result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
	result.minimizedItemShapeType = primitives.common.ShapeType.Circle;
	result.minimizedItemLineWidth = 1;
	result.minimizedItemBorderColor = primitives.common.Colors.Navy;
	result.minimizedItemFillColor = primitives.common.Colors.Navy;
	result.minimizedItemOpacity = 1;
	result.minimizedItemCornerRadius = 8;
	result.itemSize = new primitives.common.Size(110, 70);
	var itemTemplate = jQuery(
	  '<div class="bp-item bp-corner-all bt-item-frame">'
		+ '<div name="titleBackground" data-abstract-d="" class="bp-item bp-corner-all bp-title-frame" style="top: 2px; left: 2px; width: 104px; height: 20px;">'
			+ '<div name="title" class="bp-item bp-title" style="top: 3px; left: 6px; width: 102px; height: 18px;">'
			+ '</div>'
		+ '</div>'
		+ '<div name="filling_date" class="bp-item" style="top: 26px; left: 6px; width: 102px; height: 18px; font-size: 12px;"></div>'
		+ '<div name="patent_app_number" class="bp-item" style="top: 44px; left: 6px; width: 102px; height: 18px; font-size: 12px;"></div>'
	+ '</div>'
	).css({
		width: result.itemSize.width + "px",
		height: result.itemSize.height + "px"
	}).addClass("bp-item bp-corner-all bt-item-frame");
	result.itemTemplate = itemTemplate.wrap('<div>').parent().html();

	return result;
}

patents.configuration.getSubjectTemplate = function () {
	var result = new primitives.famdiagram.TemplateConfig();
	result.name = "subjectTemplate";
	result.minimizedItemSize = new primitives.common.Size(16, 16);
	result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
	result.minimizedItemShapeType = primitives.common.ShapeType.Circle;
	result.minimizedItemLineWidth = 1;
	result.minimizedItemBorderColor = primitives.common.Colors.Navy;
	result.minimizedItemFillColor = primitives.common.Colors.Navy;
	result.minimizedItemOpacity = 1;
	result.minimizedItemCornerRadius = 8;
	result.itemSize = new primitives.common.Size(110, 70);
	var itemTemplate = jQuery(
	  '<div  class="bp-item bp-corner-all bt-item-frame" style="background:#fff59d;">'
		+ '<div name="titleBackground" data-abstract-d="" class="bp-item bp-corner-all bp-title-frame" style="top: 2px; left: 2px; width: 104px; height: 20px;">'
			+ '<div name="title" class="bp-item bp-title" style="top: 3px; left: 6px; width: 202px; height: 18px;">'
			+ '</div>'
		+ '</div>'
		+ '<div name="filling_date" class="bp-item" style="top: 26px; left: 6px; width: 202px; height: 18px; font-size: 12px;"></div>'
		+ '<div name="patent_app_number" class="bp-item" style="top: 44px; left: 6px; width: 202px; height: 18px; font-size: 12px;"></div>'
	+ '</div>'
	).css({
		width: result.itemSize.width + "px",
		height: result.itemSize.height + "px"
	}).addClass("bp-item bp-corner-all bt-item-frame");
	result.itemTemplate = itemTemplate.wrap('<div>').parent().html();

	return result;
}

patents.configuration.getCursorTemplate = function () {
	var result = new primitives.famdiagram.TemplateConfig();
	result.name = "cursorTemplate";
	result.minimizedItemSize = new primitives.common.Size(16, 16);
	result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
	result.minimizedItemShapeType = primitives.common.ShapeType.Circle;
	result.minimizedItemLineWidth = 1;
	result.minimizedItemBorderColor = primitives.common.Colors.Navy;
	result.minimizedItemFillColor = primitives.common.Colors.Navy;
	result.minimizedItemOpacity = 1;
	result.minimizedItemCornerRadius = 8;
	result.itemSize = new primitives.common.Size(110, 70);
	var itemTemplate = jQuery(
	  '<div class="bp-item bp-corner-all bt-item-frame"  style="background:#ffff8d;">'
		+ '<div name="titleBackground" data-abstract-d=""  class="bp-item bp-corner-all bp-title-frame" style="top: 2px; left: 2px; width: 104px; height: 20px;">'
			+ '<div name="title" class="bp-item bp-title" style="top: 3px; left: 6px; width: 202px; height: 18px;">'
			+ '</div>'
		+ '</div>'
		+ '<div name="filling_date" class="bp-item" style="top: 26px; left: 6px; width: 202px; height: 18px; font-size: 12px;"></div>'
		+ '<div name="patent_app_number" class="bp-item" style="top: 44px; left: 6px; width: 202px; height: 18px; font-size: 12px;"></div>'
	+ '</div>'
	).css({
		width: result.itemSize.width + "px",
		height: result.itemSize.height + "px"
	}).addClass("bp-item bp-corner-all bt-item-frame");
	result.itemTemplate = itemTemplate.wrap('<div>').parent().html();

	return result;
}

patents.configuration.onTemplateRender = function (event, data) {
	switch (data.renderingMode) {
		case primitives.common.RenderingMode.Create:
			data.element.find("[name=email]").click(function (e) {
				/* Block mouse click propogation in order to avoid layout updates before server postback*/
				primitives.common.stopPropagation(e);
			});
			/* Initialize widgets here */
			break;
		case primitives.common.RenderingMode.Update:
			/* Update widgets here */
			break;
	}

	var itemConfig = data.context,
		itemTitleColor = itemConfig.itemTitleColor != null ? itemConfig.itemTitleColor : primitives.common.Colors.RoyalBlue;
	if (data.templateName == "contactTemplate" || data.templateName == "subjectTemplate" || data.templateName == "cursorTemplate") {
		data.element.find("[name=titleBackground]").css({ "background": itemTitleColor });
		data.element.find("[name=email]").attr({ "href": ("mailto:" + itemConfig.email + "?Subject=Hello%20world") });
		var fields = ["title", "filling_date", "patent_app_number"];
		var element = data.element.find("[name=titleBackground]");
		if(itemConfig.abstract_d!=null){
			jQuery(element).attr('data-abstract-d',itemConfig.abstract_d);
		}		
		for (var index = 0; index < fields.length; index += 1) {
			var field = fields[index];

			var element = data.element.find("[name=" + field + "]");
			/*element.setAttribute('abstract-d',itemConfig.abstract_d);*/
			
			if (element.text() != itemConfig[field]) {
				if(field=="filling_date"){
					element.text("Filed: "+itemConfig[field]);
				} else if(field=="patent_app_number"){
					var country = itemConfig['country'];
					country = country.toLowerCase();
					element.html("<img src='https://storage.googleapis.com/static.synpat.com/backyard/icons/flags_iso/16/"+country+".png'/><span style='margin-left:5px;position: absolute;top: 2px;'>"+itemConfig[field]+"</span>");
				} else {
					element.text(itemConfig[field]);
				}
				
			}
		}
	}
}