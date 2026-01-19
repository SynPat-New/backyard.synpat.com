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

	namespace("patents.data");
}());

patents.data.getData = function (data, options) {
	
	var hash = {},
		items = [],
		annotations = [],
		linkColor = {};

	var details = data.details;
	
	//details.push(data.main);
	for (var i = 0, len = details.length; i < len ; i += 1) {
		var item = details[i],
			legalStatus = patents.data.getLegalStatus(item.status,item.appNumber);
		var app = {
			id: item.appNumber,
			parents: [],
			title: item.appNumber,
			description: '',
			legalStatus: legalStatus,
			country:item.country,
			abstract_d:item.abstract_data
		};
		app.filling_date = item.filling_date;
		if (item.patent_app_number != item.appNumber) {
			app.patent_app_number = item.patent_number;
		} else if(item.patent_number!=""){
			app.patent_app_number = item.patent_number;
		} else{
			app.patent_app_number = "";
		}
		switch (legalStatus) {
			case patents.common.LegalStatus.Active:
				app.groupTitle = "Patented";
				app.groupTitleColor = primitives.common.Colors.Green;
				app.itemTitleColor = primitives.common.Colors.Green;
				break;
			case patents.common.LegalStatus.Expired:
				app.groupTitle = "Expired";
				app.groupTitleColor = "#454545";
				app.itemTitleColor = "#454545";
				break;
			case patents.common.LegalStatus.Abandoned:
				app.groupTitle = "Abandoned";
				app.groupTitleColor = primitives.common.Colors.Silver;
				app.itemTitleColor = primitives.common.Colors.Silver;
				break;
			case patents.common.LegalStatus.Foreign:
				app.groupTitle = "Other";
				app.groupTitleColor = "#efefef";
				app.itemTitleColor = "#efefef";
			break;
		}
		hash[app.id] = app;
		items.push(app);
	}
	var selectedRelationStatuses = {
		0: options.relationStatusContinuationInPart,
		1: options.relationStatusContinuation,
		2: options.relationStatusDivisional,
		4: options.relationStatusNone
	};

	/*var selectedRelationParentChilderent={
		0:options.relationParentSelectionMode,
		1: options.relationChilderenSelectionMode,
	}*/
	
	
	var links = data.links;
	/*extended_family*/
	for (var i = 0, len = links.length; i < len ; i += 1) {
		var link = links[i];
		var patent_app_number = hash[link.patent_app_number];
		var relation_number = hash[link.relation_number];
		if (patent_app_number != null && relation_number != null) {
			link.relationType = patents.data.getRelationStatus(link.relation_type);
			if (selectedRelationStatuses[link.relationType]) {
				var inl = false;
				if(options.relationFamilySelectionMode==0){
					inl = true;
					if (link.parent == "1") {
						patent_app_number.parents.push(relation_number.id);
					} else {
						relation_number.parents.push(patent_app_number.id);
					}
				}else{
					if(link.extended_family=='1'){
						inl = true;
						if (link.parent == "1") {
							patent_app_number.parents.push(relation_number.id);
						} else {
							relation_number.parents.push(patent_app_number.id);
						}
					} else {
						var _foundItem = false;
						var _itemI = -1;
						jQuery.each(items,function(i,it){
							if(typeof it!="undefined"){
								if(it.id==relation_number.id){
									_foundItem = true;
									_itemI = i;
									return false;
								}
							}							
						});
						if(_foundItem===true && _itemI>=0){
							items.splice(_itemI,1);
						}
					}
				}
				if(inl === true){
					var color = null;
					switch (link.relationType) {
						case patents.common.RelationStatus.ContinuationInPart:
							color = primitives.common.Colors.Purple;
							break;
						case patents.common.RelationStatus.Continuation:
							color = primitives.common.Colors.Red;
							break;
					}
					if (color != null) {
						if (!linkColor.hasOwnProperty(patent_app_number.id)) {
							linkColor[patent_app_number.id] = {};
						}
						if (!linkColor.hasOwnProperty(relation_number.id)) {
							linkColor[relation_number.id] = {};
						}
						linkColor[patent_app_number.id][relation_number.id] = color;
						linkColor[relation_number.id][patent_app_number.id] = color;
					}
				}
			} else {
				var _foundItem = false;
				var _itemI = -1;
				jQuery.each(items,function(i,it){
					if(typeof it!="undefined"){
						if(it.id==relation_number.id){
							_foundItem = true;
							_itemI = i;
							return false;
						}
					}							
				});
				if(_foundItem===true && _itemI>=0){
					items.splice(_itemI,1);
				}
			}
		}
	}
	
	/*searched item parent*/
	var links = data.links;
	for (var i = 0, len = links.length; i < len ; i += 1) {
		var link = links[i];
		var patent_app_number = hash[link.patent_app_number];
		var relation_number = hash[link.relation_number];
		if (patent_app_number != null && relation_number != null) {
			link.relationType = patents.data.getRelationStatus(link.relation_type);
			if (selectedRelationStatuses[link.relationType]) {
				var inl = false;
				if(options.relationParentSelectionMode===true && options.relationChilderenSelectionMode===true){
					console.log("Show All");
					inl = true;
					if (link.parent == "1") {
						patent_app_number.parents.push(relation_number.id);
					} else {
						relation_number.parents.push(patent_app_number.id);
					}
				} else if(options.relationParentSelectionMode===true && options.relationChilderenSelectionMode===false){
					console.log("Show Parent");
					if(link.prime=='1' || (data.main.application_number == relation_number.id)){
						inl = true;
						if (link.parent == "1") {
							patent_app_number.parents.push(relation_number.id);
						} else {
							relation_number.parents.push(patent_app_number.id);
						}
					}
				} else if(options.relationParentSelectionMode===false && options.relationChilderenSelectionMode===true){
					console.log("Show Child");
					if(link.child==1){
						inl = true;
						relation_number.parents.push(patent_app_number.id);
					}
					/*if(link.prime=='0'){
						inl = true;
						if (link.parent == "1") {
							patent_app_number.parents.push(relation_number.id);
						} else {
							relation_number.parents.push(patent_app_number.id);
						}
					}*/
				}
				
				
				
				
				
				
				
				
				/*
				if(options.relationParentSelectionMode===1){
					if(link.prime=='1'){
						inl = true;
						if (link.parent == "1") {
							patent_app_number.parents.push(relation_number.id);
						} else {
							relation_number.parents.push(patent_app_number.id);
						}
					}
				} else {
					if(link.prime=='1'){
						var _foundItem = false;
						var _itemI = -1;
						jQuery.each(items,function(i,it){
							if(typeof it!="undefined"){
								if(it.id==relation_number.id){
									_foundItem = true;
									_itemI = i;
									return false;
								}
							}							
						});
						if(_foundItem===true && _itemI>=0){
							items.splice(_itemI,1);
						}
					}
				}*/
				if(inl === true){
					var color = null;
					switch (link.relationType) {
						case patents.common.RelationStatus.ContinuationInPart:
							color = primitives.common.Colors.Purple;
							break;
						case patents.common.RelationStatus.Continuation:
							color = primitives.common.Colors.Red;
							break;
					}
					if (color != null) {
						if (!linkColor.hasOwnProperty(patent_app_number.id)) {
							linkColor[patent_app_number.id] = {};
						}
						if (!linkColor.hasOwnProperty(relation_number.id)) {
							linkColor[relation_number.id] = {};
						}
						linkColor[patent_app_number.id][relation_number.id] = color;
						linkColor[relation_number.id][patent_app_number.id] = color;
					}
				} else {
					var _foundItem = false;
					var _itemI = -1;
					jQuery.each(items,function(i,it){
						if(typeof it!="undefined"){
							if(it.id==relation_number.id){
								_foundItem = true;
								_itemI = i;
								return false;
							}
						}							
					});
					if(_foundItem===true && _itemI>=0){
						items.splice(_itemI,1);
					}
				}
			}
		}
	}
	
	/*searched item children*/
	/*var links = data.links;
	for (var i = 0, len = links.length; i < len ; i += 1) {
		var link = links[i];
		var patent_app_number = hash[link.patent_app_number];
		var relation_number = hash[link.relation_number];
		if (patent_app_number != null && relation_number != null) {
			link.relationType = patents.data.getRelationStatus(link.relation_type);
			if (selectedRelationStatuses[link.relationType]) {
				var inl = true;
				if(options.relationChilderenSelectionMode===0){
					if(link.search=='1'){
						inl = false;
						var _foundItem = false;
						var _itemI = -1;
						jQuery.each(items,function(i,it){
							if(typeof it!="undefined"){
								if(it.id==relation_number.id && data.main.application_number!=relation_number.id){
									_foundItem = true;
									_itemI = i;
									return false;
								}
							}							
						});
						if(_foundItem===true && _itemI>=0){
							items.splice(_itemI,1);
						}
					}
				}
				if(inl === false){
					var color = null;
					switch (link.relationType) {
						case patents.common.RelationStatus.ContinuationInPart:
							color = primitives.common.Colors.Purple;
							break;
						case patents.common.RelationStatus.Continuation:
							color = primitives.common.Colors.Red;
							break;
					}
					if (color != null) {
						if (!linkColor.hasOwnProperty(patent_app_number.id)) {
							linkColor[patent_app_number.id] = {};
						}
						if (!linkColor.hasOwnProperty(relation_number.id)) {
							linkColor[relation_number.id] = {};
						}
						linkColor[patent_app_number.id][relation_number.id] = color;
						linkColor[relation_number.id][patent_app_number.id] = color;
					}
				}
			}
		}
	}*/
	
	
	// create patents family
	var patentFamily = primitives.common.family();
	for (var i = 0, len = items.length; i < len ; i += 1) {
		var item = items[i];
		patentFamily.add(item.parents, item.id, item);
	}
	
	var selectedLegalStatuses = {
		0: options.legalStatusActive,
		1: options.legalStatusExpired,
		2: options.legalStatusAbandoned
	};
	// remove irrelevant nodes
	for (var i = 0, len = items.length; i < len ; i += 1) {
		var item = items[i];
		if (!selectedLegalStatuses[item.legalStatus]) {
			var parents = [];
			patentFamily.loopParents(this, item.id, function (itemid, item, levelIndex) {
				parents.push(itemid)
				return patentFamily.SKIP;
			})

			patentFamily.loopChildren(this, item.id, function (itemid, item, levelIndex) {
				patentFamily.adopt(parents, itemid);
				return patentFamily.SKIP;
			})

			patentFamily.removeNode(item.id);
		}
	}
	
	// remove irrelevant nodes
	for (var i = 0, len = items.length; i < len ; i += 1) {
		var item = items[i];
		if (!options[item.country]) {	
			var parents = [];
			patentFamily.loopParents(this, item.id, function (itemid, item, levelIndex) {
				parents.push(itemid)
				return patentFamily.SKIP;
			})

			patentFamily.loopChildren(this, item.id, function (itemid, item, levelIndex) {
				patentFamily.adopt(parents, itemid);
				return patentFamily.SKIP;
			})

			patentFamily.removeNode(item.id);
		}
	}
	
	
	var subjectItem = patentFamily.node(data.main.application_number);
	if (subjectItem != null) {
		subjectItem.templateName = "subjectTemplate";
		subjectItem.defaultTemplate = "subjectTemplate";
		subjectItem.title = subjectItem.title;
		subjectItem.itemTitleColor = primitives.common.Colors.Red;

		annotations = patents.data.getAnnotationsForItem(subjectItem.id, linkColor, primitives.common.ZOrderType.Background);
	}
	// Create new items collection without expired or abondoned items
	var items = [];
	patentFamily.loop(this, function (itemid, item) {
		var parents = [];
		patentFamily.loopParents(this, itemid, function (parentid, parent, levelIndex) {
			parents.push(parentid)
			return patentFamily.SKIP;
		})
		item.parents = parents; // Reassign new parents list to the item
		items.push(item);
	});
	return {
		cursorItem: data.main.application_number,
		items: items,
		annotations: annotations,
		linkColor: linkColor
	};
}

patents.data.getAnnotationsForItem = function (itemid, linkColor, zOrderType) {
	var newAnnotations = [];
	if (linkColor.hasOwnProperty(itemid)) {
		var items = linkColor[itemid];
		for (var parentid in items) {
			var color = items[parentid];
			var annotation = new primitives.famdiagram.HighlightPathAnnotationConfig({
				items: [itemid, parentid],
				color: color,
				opacity: 0.4,
				lineWidth: 10,
				zOrderType: primitives.common.ZOrderType.Foreground,
				showArrows: false
			});
			newAnnotations.push(annotation);
		}
	}
	return newAnnotations;
};

patents.data.getLegalStatus = function (caption,appNumber) {
	var result = null;
	switch (caption) {
		case "Patented Case":
			result = patents.common.LegalStatus.Active;
			break;
		case "Patent Expired Due to NonPayment of Maintenan":
			result = patents.common.LegalStatus.Expired;
			break;
		case "Abandoned  --  Failure to Respond to an Offic":
			result = patents.common.LegalStatus.Abandoned;
			break;
		default:
			if(appNumber.toLowerCase().indexOf('pct')>=0){
				result = patents.common.LegalStatus.Foreign;
			}			
		break;
	}
	return result;
};

patents.data.getRelationStatus = function (caption) {
	var result = null;
	switch (caption) {
		case "is a Continuation-in-part of":
			result = patents.common.RelationStatus.ContinuationInPart;
			break;
		case "which is Patented claims the benefit of":
		case "which is Abandoned claims the benefit of":
		case "This application is a Continuation in part of":
		case "This application is National Stage Entry of":
			result = patents.common.RelationStatus.Continuation;
			break;
		case "Divisional":
			result = patents.common.RelationStatus.Divisional;
		break;
		default:
			result = 4;
		break;
	}
	return result;
};