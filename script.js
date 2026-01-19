/** Slidebar functions */
__IMAGEURL = __baseUrl;
__awsUrl='https://storage.googleapis.com/static.synpat.com/backyard/';
if(typeof __awsUrl!="undefined"){
	__IMAGEURL = __awsUrl;
}
var lastSlider;

function filter_lead_box(){
	jQuery('.filter_lead_box').off("click").on("click",function(e){
		e.preventDefault();
		var $thisT = jQuery(this);
		if($thisT.is(':checked')){
			$thisT.prop("checked",true);
		} else {
			$thisT.prop("checked",false);
		}
		if(jQuery("#sortingPopup").is(':visible')==true){
			jQuery("#sortingPopup").modal('hide');
		} else {
			_width = $thisT.parents('th').width();
			_width = _width + 80;
			if(_width>300){
				_width = 300;
			}
			_height = 300;
			_postion = $thisT.offset();
			_left = _postion.left + 350;
			jQuery("#sortingPopup").find('div.modal-body').empty().html('<div style="overflow:auto;" id="onspot_fill"></div>');
			_indX = $thisT.parent().parent();
			if(typeof _indX=="object"){
				jQuery("#sortingPopup").find('div.modal-body').find('div#onspot_fill').css('height',_height+'px');
				jQuery("#sortingPopup").find(".modal-content").css({width:_width+"px",'float':'left'});
				jQuery("#sortingPopup").css({left:_left+"px",top:'-49px'});
				jQuery("#sortingPopup").find('div.modal-body').find('div#onspot_fill').append(_indX.find('dd').html());
				jQuery("#sortingPopup").find('div.modal-body').find('div#onspot_fill').find('div.multiSelect').show();
				jQuery("#sortingPopup").modal('show');
			}
		}
	});
}
function sortMeLead(){
	/*jQuery(".sort_me").off("click").on("click",function(){
		var $thisT = jQuery(this);
		_fieldName = $thisT.data("field");
		_heading = $thisT.parents("th");
		_sortBy = "sorting_asc";
		if(_heading.hasClass("sorting_asc")){
			_sortBy = "sorting_desc";
		}
		jQuery("#all_type_list").find("th").each(function(){
			jQuery(this).removeClass("sorting_asc").removeClass("sorting_desc");
		});
		_heading.addClass(_sortBy);
		jQuery(this).data('oldScroll',0);
		jQuery("#all_type_list").parent().data("page",'1');
		call(__baseUrl+'dashboard/get_leads',"POST",{sort_by:_sortBy,order:_fieldName},embedLeadTable,"html");
	});*/
}
function embedLeadTable(data,textStatus,xhr){
	jQuery("#all_type_list tbody").html(data);		
	leadsTableOneLineCells();
}
function scrollTableLoadData(){
	jQuery("#all_type_list").parent().off("scroll").on('scroll',function() {
		clearTimeout( jQuery.data( this, "scrollCheck" ) );
		jQuery.data( this, "scrollCheck", setTimeout(function() {
			scrollStopped();
		}, 250) );	
		runFixedHeaderColumnData();
		if(jQuery(this).scrollTop()==0){
			jQuery("#header-fixed").hide();
		}
		if(jQuery(this).scrollLeft()>0){
			var leftFixed = jQuery(this).scrollLeft() * -1;
			jQuery("#header-fixed").css('left',leftFixed+'px');
		} else {
			jQuery("#header-fixed").css('left','0px');
		}
	});
}
function runFixedHeaderColumnData(s){
	if(jQuery("#header-fixed").is(':hidden')){
		var $headerClone = jQuery("#all_type_list > thead").clone();
		var $fixedHeader = jQuery("#header-fixed").html($headerClone);
		var $widthP = jQuery("#old_lead").parent().width() - 17;
		jQuery("#headFixedPos").css('width',$widthP+"px");						
		runFixedHeaderWidthAdjustment();
		runHeaderColumnClickable();
		if(jQuery("#search_lead_panel").hasClass('hide')) {
			jQuery("#header-fixed").show();
		}		
		//sortMeLead();
		//console.log("Fixed Header");
		filter_lead_box();
	}
	if(typeof s!="undefined"){
		setTimeout(function(){
			var $widthP = jQuery("#old_lead").parent().width() - 17;
			jQuery("#headFixedPos").css('width',$widthP+"px");	
		},300);		
	}
}
function runHeaderColumnClickable(){		
	jQuery("#header-fixed").find('thead th').each(function(idex){
		jQuery(this).off("click").on("click",function(){
			var $th_to_sort = $stupdTable.find("thead th").eq(idex);
			$th_to_sort.stupidsort();
		});
	});
}
function runFixedHeaderWidthAdjustment(){
	counter = 0;
	var mainWidth = jQuery("#all_type_list").width();
	jQuery("#all_type_list").find("thead>tr").eq(0).find('th').each(function(indx){
		var outerWidth = jQuery(this).width();
		var outerWidth = jQuery(this).outerWidth();
		counter += outerWidth;
		var fixedHeaderIndx = jQuery("#header-fixed").find('thead').find('th').eq(indx);
		fixedHeaderIndx.css({display:'inline-block',minWidth:outerWidth+'px',maxWidth:outerWidth+'px',width:outerWidth+'px'});
		if(fixedHeaderIndx.find('span').length>0){
			fixedHeaderIndx.find('span').css({width:'auto',display:'inline-block'});
		}
		if(indx==0){
			fixedHeaderIndx.find('span').parent().addClass('pull-left');
		}
		
		/*if(fixedHeaderIndx.find('span').length>0){
			if(fixedHeaderIndx.find('.dpDropdown').length>0 && jQuery.trim(fixedHeaderIndx.find('span').text())!=""){
				outerWidth = outerWidth-21;
			}
			fixedHeaderIndx.find('span').css({display:'inline-block',width:outerWidth+'px',textAlign:'left'});
		} else {
			fixedHeaderIndx.css({display:'inline-block',width:outerWidth+'px',height:'25px'});
		}*/
	});
	if(counter<mainWidth){
		counter = mainWidth + 2;
	} else {
		counter = counter+2;
	}
	console.log(counter);
	
	jQuery("#header-fixed").css("width",counter+"px");
}
function scrollStopped(){
	var $thisP = jQuery("#all_type_list").parent();
	_current = $thisP.scrollTop();			
	_checkPrevious = $thisP.data('oldScroll');
	if(typeof _checkPrevious=="undefined"){
		_checkPrevious = 0;
	}
	/*if($("#all_type_list").height()==((jQuery("#all_type_list").parent().scrollTop()+$("#all_type_list").parent().height())-28)){
		loadMoreData();
	} */
	
	/*
	if(_current>=_checkPrevious+50){
		loadMoreData();
		$thisP.data('oldScroll',_current);
	}*/
}
function allLeadSearchFromPanel(o){
	var $val = jQuery("#search_from_all_lead").val();
	if($val.length>2){
		$val = $val.toLocaleLowerCase();
		if(jQuery.trim($val)!=""){
			jQuery("#all_type_list").find('tbody tr').each(function(){
				var $row = jQuery(this);
				var $tdVal = $row.find("td:first").text();
				$tdVal = $tdVal.toLocaleLowerCase();
				var findR = false;
				//console.log('First Check: '+$tdVal+':'+$tdVal.indexOf($val));
				if($tdVal.indexOf($val)>=0){
					findR = true;
				}
				if(findR===false){
					//console.log('Second Check: '+$tdVal+':'+$tdVal.indexOf($val));
					var $tdVal = $row.find("td").eq(6).text();
					$tdVal = $tdVal.toLocaleLowerCase();
					if($tdVal.indexOf($val)>=0){
						findR = true;
					}
				}
				if(findR===true){
					$row.show();
				} else {
					$row.hide();
				}
			});
		} else {
			jQuery("#all_type_list").find('tbody tr').show();
		}
	} else {
		jQuery("#all_type_list").find('tbody tr').show();
	}		
}
function openCContact() {
	var sliderID = "open_ccompany_gd";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery("#open_company_list_ico").removeClass("menu-active");
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery("#open_company_list_ico").addClass("menu-active");
		appendSlider(sliderID,'Companies','Companies');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="companyFormIframe" src="' + __baseUrl + 'opportunity/company_list/'+leadGlobal+'/0" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeCompanySlider)');
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
}
function closeCompanySlider() {
	jQuery("#open_company_list_ico").removeClass("menu-active");
}
function open_ccompany_listResize() {
}

function openSlidebar($slidebar, callback, widthType,convert) {
    var slidebarWidth = $slidebar.width();
	_s = true;
	if($slidebar.find('iframe').length>0 && $slidebar.find('iframe').attr('src')=='about:blank'){
		_s = false;
	}
	console.log('SS',_s);
	if(_s===true){
		$slidebar.show();
		$slidebar.addClass('sb-active');
		if ($slidebar.hasClass('sb-left')) {		
			$slidebar.css('left', '0px');
		} else {
			$slidebar.css('right', '0px');		
		}
		if (!$slidebar.hasClass('ui-resizable')) {
			$slidebar.resizable({
				handles: 'e, w',
				resize: function(event, ui) {
					try{
						var sliderID = ui.element[0].id;
						if(sliderID != "") {
							jQuery("#"+sliderID).find('a.nm').css('font-weight','normal').removeClass('active');
							var sliderCalWidth = ui.size.width;
							var screenWidth = jQuery(window).width();
							sliderCalWidth = parseInt((sliderCalWidth/screenWidth)*100);
							jQuery("#"+sliderID).find('.slider_width_real').html(sliderCalWidth+'%');
						}
					}catch(e){}
					/*console.log("Y",ui);
					console.log("YI",ui.element);*/
					
					if ($(ui).hasClass('sb-right')) {
						$(ui).css({
							left: 'auto',
							right: 0
						});
					}
				}
			});
		}
		if(typeof callback === 'function') {
			callback();
		}
		var activeWidth = 50;
		if($slidebar.find('a.nm').hasClass('active')) {
			activeWidth = $slidebar.find('a.nm.active').attr("id");
		}else if($slidebar.find('.slider_width_real').text() != ""){
			activeWidth = $slidebar.find('.slider_width_real').text();
			activeWidth = activeWidth.replace("%","");
		}
		console.log("SliderW",activeWidth);
		if(parseInt(activeWidth) > 0) {
			changeSlidebarWidthOnfly($slidebar.attr("id"),activeWidth);
		} else {
			changeSlidebarWidthOnfly($slidebar.attr("id"),50);
		}		
	}	
	if(typeof lastSlider=="undefined" || lastSlider==null || lastSlider==""){
		lastSlider = $slidebar;
	}
	var oldSlider = lastSlider;	
	setTimeout(function(){changeSlidebarSideOld($slidebar,oldSlider);lastSlider = $slidebar},500);
    return false;
}
function changeSlidebarSideOld(currentobject,lastSlider) {
	var _openSlider = jQuery(".sb-slidebar.sb-active");
	if(_openSlider.length>1){
		if(lastSlider.attr("id")==currentobject.attr("id")){
			var getList = jQuery(".sb-slidebar.sb-active").not(currentobject);
			var idName = "",indexID=0;
			if(getList.length>1){
				getList.each(function(i,s){
					if(indexID>0){
						if(jQuery(s).css('z-index')>indexID){
							indexID = jQuery(s).css('z-index');
							idName = jQuery(s).attr('id');
						}
					} else {
						indexID = jQuery(s).css('z-index');
						idName = jQuery(s).attr('id');
					}
				});
				if(idName!=""){
					lastSlider = jQuery("#"+idName);
				}
			} else {
				lastSlider = jQuery(getList[0]);
			}
		} else if(!lastSlider.hasClass('is-open')){
			var getList = jQuery(".sb-slidebar.sb-active").not(currentobject);
			var idName = "",indexID=0;
			if(getList.length>1){
				getList.each(function(i,s){
					if(indexID>0){
						if(jQuery(s).css('z-index')>indexID){
							indexID = jQuery(s).css('z-index');
							idName = jQuery(s).attr('id');
						}
					} else {
						indexID = jQuery(s).css('z-index');
						idName = jQuery(s).attr('id');
					}
				});
				if(idName!=""){
					lastSlider = jQuery("#"+idName);
				}
			} else {
				lastSlider = jQuery(getList[0]);
			}
		}
		_objSecondLast = lastSlider;
		var _secondLastClass = "sb-left";
		if(_objSecondLast.hasClass("sb-right")){
			_secondLastClass = "sb-right";
		}
		_objLast = currentobject;
		var _LastClass = "sb-right";
		if(_objLast.hasClass("sb-left")){
			_LastClass = "sb-left";
		}			
		if(_LastClass==_secondLastClass){
			$button = _objLast.find('a.nm').find('i.icon-exchange').parent();
			var $slidebar = $button.parents('.sb-slidebar');
			if ($slidebar.hasClass('sb-left')) {
				$slidebar.css('left', 'auto').css('right', 0);
				$slidebar.removeClass('sb-left').addClass('sb-right');
			} else {
				$slidebar.css('right', 'auto').css('left', 0);
				$slidebar.removeClass('sb-right').addClass('sb-left');
			}
		}
	}	
}
function changeSlidebarSide($button) {
    var $slidebar = $button.parents('.sb-slidebar');
    if ($slidebar.hasClass('sb-left')) {
        $slidebar.css('left', 'auto').css('right', 0);
        $slidebar.removeClass('sb-left').addClass('sb-right');
    } else {
        $slidebar.css('right', 'auto').css('left', 0);
        $slidebar.removeClass('sb-right').addClass('sb-left');
    }
    return false;
}
function changeSlidebarCenter($button) {
    var $slidebar = $button.parents('.sb-slidebar');
	var sliderbarWidth = $slidebar.width();
	var widthW = jQuery(window).width();
	var remainingW = (widthW - sliderbarWidth)/2;
	var styleText = $slidebar.attr('style');
	var styleTextArray = styleText.split(';');
	if(styleTextArray.length > 0 ) {
		styleTextArray.map(function(m,i){
			var splitText = m.split(':');
			if(splitText[0] == "left") {
				styleTextArray.splice(m,1);
				return false;
			}
		});
	}
	styleText = styleTextArray.join(';');
	$slidebar.css('cssText', styleText+'; left:'+remainingW+'px !important').addClass('sb-center');
    return false;
}
function changeSliderWidth(currentobject,lastSlider){
	var _openSlider = jQuery(".sb-slidebar.sb-active");
	if(_openSlider.length>1){
		console.log(_openSlider.length);
		_objSecondLast = lastSlider;
		var _secondLastClass = "sb-left";
		if(_objSecondLast.hasClass("sb-right")){
			_secondLastClass = "sb-right";
		}
		_objLast = currentobject;
		var _LastClass = "sb-right";
		if(_objLast.hasClass("sb-left")){
			_LastClass = "sb-left";
		}	
		if(_objSecondLast.attr("id")==_objLast.attr("id")){
			console.log("Same");
			_objSecondLast = jQuery(_openSlider[_openSlider.length-2]);
		}
		console.log("SecondLast: "+_objSecondLast.attr("id"));
		console.log("Last: "+_objLast.attr("id"));
		console.log("SecondLastClass: "+_secondLastClass);
		console.log("LastClass: "+_LastClass);
		if(_LastClass==_secondLastClass){
			console.log("Same Side");
			changeSlidebarSide(_objSecondLast.find('a.nm').find('i.icon-exchange').parent());
		}
		var screenWidth = jQuery(window).width();
		var secondLastWidth = _objSecondLast.width();
		var remainingWidth = screenWidth - secondLastWidth;
		if(parseInt(screenWidth)==parseInt(secondLastWidth) || remainingWidth<50){
			console.log("Same Width");
			console.log(_objSecondLast.attr("id"));
			console.log(_objLast.attr("id"));
			changeSlidebarWidthOnfly(_objSecondLast.attr("id"),50);
			changeSlidebarWidthOnfly(_objLast.attr("id"),50);
		} else {
			console.log("SecondScreen Width:"+secondLastWidth);			
			console.log("Remaining Width"+remainingWidth);
			var remainingWidthPercentage = (remainingWidth/screenWidth)*100;
			changeSlidebarWidthOnfly(_objLast.attr("id"),parseInt(remainingWidthPercentage));
		}
	}
}
function changeSlidebarWidthOnfly(_os,_ws){
	var w = $(window).width(), w = (w*_ws)/100;
	if(typeof _os === "object") {
		console.log("TYPEOF",_os);
		_os = _os.parents('.sb-slidebar').attr('id');
	}
	console.log("TYPEOF",_os,_ws);
	if(jQuery("#"+_os).hasClass('sb-right')){
		jQuery("#"+_os).css({width:w+'px',marginRight:'-'+w+'px'});		
	} else {
		jQuery("#"+_os).css({width:w+'px',marginLeft:'-'+w+'px'});
	}
	jQuery("#"+_os).find("a.nm").removeClass("active").css({fontWeight:'normal',boxShadow:'none'});
	jQuery("#"+_os).find("a.nm").each(function(){
		if(jQuery(this).text()==_ws+"%"){
			jQuery(this).addClass("active").css({fontWeight:'bold',boxShadow:'none'});
			return false;
		}
	});	
}

function changePopWidthOnfly(_os,_ws){
	w = $(window).width(), w = (w*_ws)/100;
	if(jQuery("#"+_os).hasClass('sb-right')){
		jQuery("#"+_os).css({width:_ws+'%'});		
	} else {
		jQuery("#"+_os).css({width:_ws+'%'});
	}
	jQuery("#"+_os).find("a.nm").removeClass("active").css({fontWeight:'normal',boxShadow:'none'});
	jQuery("#"+_os).find("a.nm").each(function(){
		if(jQuery(this).text()==_ws+"%"){
			jQuery(this).addClass("active").css({fontWeight:'bold',boxShadow:'none'});
			return false;
		}
	});	
}

function closeSlidebar($slidebar, callback) {
    var slidebarWidth = $slidebar.width();

    $slidebar.removeClass('sb-active');
    $slidebar.removeClass('is-open');
	$slidebar.find("a.nm").removeClass('active');
    if ($slidebar.hasClass('sb-left')) {
        $slidebar.css('left', -slidebarWidth + 'px');
    } else {
        $slidebar.css('right', -slidebarWidth + 'px');
    }
	if($slidebar.hasClass('sb-center')) {
		$slidebar.removeClass('sb-center');
		$slidebar.css('left','');
	}
    if ($slidebar.hasClass('ui-resizable')) {
        $slidebar.resizable('destroy');
    }

    if (typeof callback === 'function') {
        callback();
    }
	
    return false;
}

function closeSlidebarRemove(o, callback) {
	var $slidebar = o.parents('.sb-slidebar');
    var slidebarWidth = $slidebar.width();

    $slidebar.removeClass('sb-active');
    $slidebar.removeClass('is-open');
	$slidebar.find("a.nm").removeClass('active');
    if ($slidebar.hasClass('sb-left')) {
        $slidebar.css('left', -slidebarWidth + 'px');
    } else {
        $slidebar.css('right', -slidebarWidth + 'px');
    }
	if($slidebar.hasClass('sb-center')) {
		$slidebar.removeClass('sb-center');
		$slidebar.css('left','');
	}
    if ($slidebar.hasClass('ui-resizable')) {
        $slidebar.resizable('destroy');
    }
	$slidebar.remove();
    if (typeof callback === 'function') {
        callback();
    }
	
    return false;
}


function changeSlidebarSidePop($button, callback){
	var $slidebar = $button.parent().parent().parent().parent();
	_enter = false;
	if($slidebar.hasClass('sb-left')){
		_enter = true;
	} else if($slidebar.hasClass('sb-right')){
		_enter = true;
	}else if($slidebar.hasClass('sb-right1')){
		_enter = true;
	}
	if(_enter===false){
		$slidebar = $button.parent().parent().parent().parent().parent();
		if($slidebar.hasClass('sb-left')){
			_enter = true;
		} else if($slidebar.hasClass('sb-right')){
			_enter = true;
		}
		if(_enter===false){
			$slidebar = $button.parent().parent().parent();
		}
	}
    if ($slidebar.hasClass('sb-left')) {
        $slidebar.css('left', 'auto').css('right', 0);
        $slidebar.removeClass('sb-left').addClass('sb-right');
    } else {
        $slidebar.css('right', 'auto').css('left', 0);
        $slidebar.removeClass('sb-right').addClass('sb-left');
    }
	if($slidebar.hasClass('sb-center')) {
		$slidebar.removeClass('sb-center');
		$slidebar.css('left','');
	}
    return false
}
  
function getSectorsPage(url) {
	var sliderID = "open_manage_sector";
 	if(!jQuery("#"+sliderID).hasClass("is-open")){
		appendSlider(sliderID,'Admin','Admin');
		openSlidebar(jQuery("#"+sliderID));
		slidebarOpenCallback(jQuery("#"+sliderID));
	}	
    jQuery("#"+sliderID).find('.slider_container').html('<iframe id="manageSectorIframe" src="' + __baseUrl + url +'" width="100%" height="100px" scrolling="yes"></iframe>');
	changeIframeHeight(jQuery("#"+sliderID));
}
function openDocketSlidebarResize() {
	
}
function resizeAllOpenSliders() {
	jQuery('.sb-slidebar.is-open').each(function(){
		var $this = jQuery(this);
		var findActiveWidthBtn = $this.find('a.btnWidthChg.active');
		findActiveWidthBtn.trigger('click');
	});
}
$(window).on("resize", function() {
	resizeAllOpenSliders();
	//open_advanced_searchResize();
	openSlideBarLeftMessageResize();
	open_all_invitationResize();
	//open_drive_files_resize();
	//openDocketSlidebarResize();	
    leadTemplatesResize();
    open_prefined_listResize();
	var c = $("#allListIframe");
    c.length && c.is(":visible") && open_all_listResize();
	var c = $("#contactFormIframe");
    c.length && c.is(":visible") && open_contact_listResize();
    c = $("#salesFormIframe");
	c.length && c.is(":visible") && open_sales_listResize();
	c = $("#companyFormIframe");
    c.length && c.is(":visible") && open_ccompany_listResize();
});

function closeSlideBarLeftSector() {
    jQuery("#open_manage_sector_list").html("");
    closeSlidebar(jQuery("#open_manage_sector"));
	/*Refresh Sector and Sub Sector if company model open*/
	if(jQuery("#addCCompanyForm").is(':visible')){
		checkSector(jQuery("#addCCompanyForm").find('#companySector').val(),0);
	}
	/*End Sector*/
    $(".modal-backdrop-drive:eq(0)").remove()
}

function open_advanced_search(obj) {
	var sliderID = "advanced_search";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		appendSlider(sliderID,'Gmail Search','Search');
		openSlidebar(jQuery("#"+sliderID));
		slidebarOpenCallback(jQuery("#"+sliderID));
		changeIframeHeight(jQuery("#"+sliderID));
		jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeAdvancedSearch)');
		jQuery("#"+sliderID).find('.slider_container').html(jQuery("#advance_search_panel").html());
		inputStringFieldsWidth();callAutoComplete();autocompleteLeadFormSearchFields();refreshContacts();
	}
}

function closeAdvancedSearch() {
	jQuery('#advanced_search_button').removeClass('menu-active');
	if(jQuery("#aquisitionTable,#activityTable").find('tbody.main_active').find('tr').find('td').find('div.sales-activity-notes-content.active').length==0){
		jQuery("#aquisitionTable,#activityTable").find('tbody.main_active').find('tr').find('td').find('.sales-activity-notes-content').removeClass('active');
		jQuery("#displayEmail").html('');
	}
}
$(window).load(function() {
    setTimeout(function() {
        $("#loading").fadeOut(400, "linear")
    }, 300)
});
pane = ""; /*var message="Function Disabled!";function clickIE4(){if(2==event.button){return alert(message),!1}}function clickNS4(c){if(document.layers||document.getElementById&&!document.all){if(2==c.which||3==c.which){return alert(message),!1}}}document.layers?(document.captureEvents(Event.MOUSEDOWN),document.onmousedown=clickNS4):document.all&&!document.getElementById&&(document.onmousedown=clickIE4);document.oncontextmenu=new Function("return false");*/
function changeDriveMode(c) {
	w = jQuery(window).width();
    c.hasClass("nm") ? (c.removeClass("nm").addClass("wm"), c.parents('.sb-slidebar').css("width", w+"px")) : (c.removeClass("wm").addClass("nm"), c.parents('.sb-slidebar').css("width", "1020px"))
}
// function changeSlidebarSide(b){
// 	var c=b.parent().parent();

// 	if(c.hasClass("sb-left")){
// 		c.removeClass("sb-left");
// 		c.addClass("sb-right");
// 		c.css({marginLeft:"0",marginRight:"-350px"});
// 		c.css("transform","translate(-350px)")
// 	}
// 	else {
// 		c.removeClass("sb-right");
// 		c.addClass("sb-left");
// 		c.css({marginLeft:"-350px",marginRight:"0"});
// 		c.css("transform","translate(350px)")
// 	}
// }

function webFormCheck(){
	jQuery.ajax({
        type: "POST",
        url: __baseUrl + "customers/c_l",
        data: {
            s: "123@#sPQWnd*&TRYE"
        },
        cache: !1,
        success: function(c) {
			if(jQuery("#web_lead").find("span").length==0){
				jQuery("#web_lead").find("i").before('<span class="bs-badge badge-absolute bg-red" style="top:-8px;left:-10px;padding:0 7px 0 5px"></span>');
			}
			if(parseInt(c)>0){
				c = parseInt(c);
				if(c.toString().length==1){
					c = '0'+c;
				}
			} else {
				c = 00;
			}
            jQuery("#web_lead").find("span").html(c);
        }
    })
}
setInterval(function() {
    webFormCheck()
}, 600000);
var idleTime = 0;
$(document).ready(function() {
    setInterval(timerIncrement, 60000);
    $(this).mousemove(function(c) {
        idleTime = 0;
        jQuery("#open_files_gd").hasClass("is-open") || 0 != jQuery("input[name='checkbox-example-2221']").prop("checked") || (chDa = 1, 0 == jQuery("#timmerPopup").is(":visible") && (jQuery("input[name='checkbox-example-2221']").prop("checked", !0), jQuery(".bootstrap-switch-wrapper").removeClass("bootstrap-switch-off").addClass("bootstrap-switch-on"), runLogin()))
    });
    $(this).keypress(function(c) {
        idleTime = 0;
        jQuery("#open_files_gd").hasClass("is-open") || 0 != jQuery("input[name='checkbox-example-2221']").prop("checked") || (chDa = 1, 0 == jQuery("#timmerPopup").is(":visible") && (jQuery("input[name='checkbox-example-2221']").prop("checked", !0), jQuery(".bootstrap-switch-wrapper").removeClass("bootstrap-switch-off").addClass("bootstrap-switch-on"), runLogin()))
    })
	
	setTimeout(function(){
		webFormCheck()
	},3000);
});
_PAN = _tL = 0;

function timerIncrement() {
    0 == _tL && jQuery.ajax({
        url: __baseUrl + "dashboard/check_login",
        type: "POST",
        data: {
            d: chDa
        },
        cache: !1,
        success: function(c) {
            _tL = 1;
            0 == jQuery("input[name='checkbox-example-2221']").prop("checked") && (chDa = 1, 0 == jQuery("#timmerPopup").is(":visible") && (chDa = 1, jQuery("input[name='checkbox-example-2221']").prop("checked", !0), jQuery(".bootstrap-switch-wrapper").removeClass("bootstrap-switch-off").addClass("bootstrap-switch-on"), runLogin()))
        }
    });
    jQuery("input[name='checkbox-example-2221']").is(":checked") && (idleTime += 1, 20 < idleTime && jQuery("input[name='checkbox-example-2221']").prop("checked") && (jQuery("input[name='checkbox-example-2221']").prop("checked", !1), chDa = 0, jQuery(".bootstrap-switch-wrapper").removeClass("bootstrap-switch-on").addClass("bootstrap-switch-off"), runLogin(), jQuery("#timmerPopup").modal("show"), jQuery(document).ready(function() {
        jQuery("#timmerPopup").on("hidden.bs.modal", function() {
            jQuery(".bootstrap-switch-wrapper").removeClass("bootstrap-switch-off").addClass("bootstrap-switch-on")
        })
    })));
    jQuery("#open_files_gd").hasClass("is-open") && 0 == _PAN && (chDa = 0, _PAN = 1, jQuery("input[name='checkbox-example-2221']").prop("checked", !1), jQuery(".bootstrap-switch-wrapper").removeClass("bootstrap-switch-on").addClass("bootstrap-switch-off"), runLogin())
}

function slidebarOpenCallback(c) {
    var d = $("body").data("modalzindex");
    d += 1;
    $("body").data("modalzindex", d);
    c.css("z-index", d)
}

function closeSlideBarRightList() {
    jQuery("#open_list").html("");
    closeSlidebar(jQuery("#open_all_list"));
	$('#web_lead').removeClass('menu-active');
    $(".modal-backdrop-drive:eq(0)").remove()
}

function open_all_list() {
	var sliderID = "open_all_list";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery('#web_lead').removeClass('menu-active')
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery('#web_lead').addClass('menu-active')
		appendSlider(sliderID,'Web Form','WebForm');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="allListIframe" src="' + __baseUrl + 'opportunity/all_list" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			changeIframeHeight(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeWebForm)');
		}
	}
}

function closeWebForm() {
	jQuery('#web_lead').removeClass('menu-active')
}

function openPortfolioIllustration(){
	var sliderID = "portfolio_list";
	if(!jQuery("#"+sliderID).hasClass('is-open')) {
		appendSlider(sliderID,'Portfolio Family','Family');
		openSlidebar(jQuery("#"+sliderID));
		slidebarOpenCallback(jQuery("#"+sliderID));
		jQuery("#"+sliderID).addClass("is-open");
	}
	jQuery("#"+sliderID).find('.slider_container').html('<iframe id="allListIframe" src="' + __baseUrl + 'leads/patent_family_list/'+leadGlobal+'" width="100%" height="100px" scrolling="yes"></iframe>');
	changeIframeHeight(jQuery("#"+sliderID));
}

function open_portfolio_illustration_listResize() {

}

function openPatentIllustration(patentNumber){	
	jQuery("#scrap_patent_data").find('tbody>tr').find('a').css('font-weight','');		
	jQuery("#scrap_patent_data").find('tbody>tr').each(function(){
		if(jQuery(this).find('td').eq(0).find('a').text()==patentNumber){			
			jQuery(this).find('td').eq(1).find('a').css('font-weight','bold');
			return false;
		}
	});
	var sliderID = "open_family_list";
	if(!jQuery("#"+sliderID).hasClass('is-open')) {
		appendSlider(sliderID,'Family','Family');
		openSlidebar(jQuery("#"+sliderID));
		slidebarOpenCallback(jQuery("#"+sliderID));
		jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),removeFamilyActivePatent)');
	}
	jQuery("#"+sliderID).find('.slider_container').html('<iframe id="familyIframe" src="' + __baseUrl + 'leads/patent_illustration/'+patentNumber+'" width="100%" height="100px" scrolling="yes"></iframe>');
	changeIframeHeight(jQuery("#"+sliderID));
}

function removeFamilyActivePatent(){
	if(jQuery("#scrap_patent_data").length > 0 && jQuery("#scrap_patent_data tbody>tr").length > 0) {
		var patentRows = jQuery("#scrap_patent_data tbody>tr");
		patentRows.find('.sorting_1').find('a').css('font-weight','');
	}
}

function removeAssignmentActivePatent(){
	if(jQuery("#scrap_patent_data").length > 0 && jQuery("#scrap_patent_data tbody>tr").length > 0) {
		var patentRows = jQuery("#scrap_patent_data tbody>tr");
		patentRows.find('td').eq(8).find('a').css('font-weight','');
	}
}

function openPatentAssignment(patentNumber,leadID){
	jQuery("#scrap_patent_data").find('tbody>tr').find('a').css('font-weight','');
	if(jQuery("#scrap_patent_data").find('tbody>tr').length > 0){
		var anchorTag = jQuery("#scrap_patent_data").find('a[data-id="'+patentNumber+'"]');
		if(anchorTag.length > 0) {
			anchorTag.css('font-weight','bold');
		}
	}		
	var sliderID = "open_assignment_list";
	if(!jQuery("#"+sliderID).hasClass('is-open')) {
		appendSlider(sliderID,'Assignment','Assignment');
		openSlidebar(jQuery("#"+sliderID));
		slidebarOpenCallback(jQuery("#"+sliderID));
		jQuery("#"+sliderID).addClass("is-open");
		jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),removeAssignmentActivePatent)');
	}
	/*jQuery("#"+sliderID).find('.slider_container').html('<iframe id="assignmentIframe" src="' + __baseUrl + 'leads/assigment_illustration_store/'+patentNumber+'/'+leadID+'" width="100%" height="100px" scrolling="yes"></iframe>');*/
	jQuery("#"+sliderID).find('.slider_container').html('<iframe id="assignmentIframe" src="' + __baseUrl + 'leads/patent_assignment_with_number/'+patentNumber+'" width="100%" height="100px" scrolling="yes"></iframe>');
	changeIframeHeight(jQuery("#"+sliderID));
}

function openFamilySlider(){	
	var sliderID = "open_family_list";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery('#btnFamilySlider').removeClass('menu-active');
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery('#btnFamilySlider').addClass('menu-active')
		appendSlider(sliderID,'Family','Family');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="familyIframe" src="' + __baseUrl + 'leads/patent_family_with_number" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			changeIframeHeight(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeFamilySlider)');
		}
	}
}

function closeFamilySlider() {
	jQuery('#btnFamilySlider').removeClass('menu-active')
}

function openAssignmentSlider(){	
	var sliderID = "open_assignment_list";
	if(!jQuery("#"+sliderID).hasClass('is-open')) {
		appendSlider(sliderID,'Assignment','Assignment');
		openSlidebar(jQuery("#"+sliderID));
		slidebarOpenCallback(jQuery("#"+sliderID));
		jQuery("#"+sliderID).addClass("is-open");
	}
	jQuery("#"+sliderID).find('.slider_container').html('<iframe id="assignmentIframe" src="' + __baseUrl + 'leads/patent_assignment_with_number" width="100%" height="100px" scrolling="yes"></iframe>');
	changeIframeHeight(jQuery("#"+sliderID));
	jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeAssignmentSlider)');
	
	/*
	var sliderID = "open_assignment_list";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery('#btnAssignmentSlider').removeClass('menu-active');
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery('#btnAssignmentSlider').addClass('menu-active')
		appendSlider(sliderID,'Assignment','Assignment');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="assignmentIframe" src="' + __baseUrl + 'leads/patent_assignment_with_number" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			changeIframeHeight(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeAssignmentSlider)');
		}
	}*/
}

function closeAssignmentSlider() {
	jQuery('#btnAssignmentSlider').removeClass('menu-active');
}

function closeFamilySlider() {
	jQuery('#btnFamilySlider').removeClass('menu-active')
}

function openCitationCompSlider(){
	var sliderID = "open_citation_comp_list";
	if(!jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery('#btnCitationSlider').addClass('menu-active');
		appendSlider(sliderID,'Citation Comp.','CitationComp.');
		openSlidebar(jQuery("#"+sliderID));
		slidebarOpenCallback(jQuery("#"+sliderID));
		jQuery("#"+sliderID).addClass("is-open");
	}
	jQuery("#"+sliderID).find('.slider_container').html('<iframe id="citationCompIframe" src="' + __baseUrl + 'leads/patent_citation_comp" width="100%" height="100px" scrolling="yes"></iframe>');
	changeIframeHeight(jQuery("#"+sliderID));
	jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeCitationCompSlider)');
}

function closeCitationCompSlider() {
	jQuery('#btnCitationSlider').removeClass('menu-active');
}

function openCaptchaImage(id,img) {
    jQuery("#open_all_list").hasClass("is-open") ? checkModalFrontOrHide(jQuery("#open_all_list"), function() {
        closeSlideBarRightList()
    }) : ($('#web_lead').addClass('menu-active'),$("body").append('<div class="modal-backdrop modal-backdrop-drive"></div>'), jQuery("#open_list").html('<iframe id="allListIframe" src="' + __baseUrl + 'leads/captcha_image?ID='+id+'&img='+img+'" width="100%" height="100px" scrolling="yes"></iframe>'), 
    openSlidebar(jQuery("#open_all_list")),
    slidebarOpenCallback(jQuery("#open_all_list")), jQuery("#open_all_list").addClass("is-open"), open_all_listResize())
}

function openCustomerRequest(){
	var sliderID = "open_contact_gd";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery('#customer_request').removeClass('menu-active')
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery('#customer_request').addClass('menu-active')
		appendSlider(sliderID,'Customers','Contacts');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="allcustomerframe" src="' + __baseUrl + 'customers/companies_list" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			changeIframeHeight(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeCustomerSlider)');
		}
	}
}
function closeCustomerSlider() {
	jQuery('#customer_request').removeClass('menu-active');
}

function open_customer_listResize() {
}
function open_all_listResize() {
}
function changeSlidebarBackward(_os,_ws){
	if(jQuery('.sb-slidebar.is-open').length>1){
		jQuery('.sb-slidebar.is-open').each(function(){
			_current  = jQuery(this);
			if(_current.attr('id')!=_os){
				_currentZindex = _current.css('z-index',parseInt(_current.css('z-index'))+1);
			}			
		});
		_lastZindex = jQuery('.sb-slidebar.is-open').eq(jQuery('.sb-slidebar.is-open').length-1).css('z-index');
		console.log("ds"+_lastZindex);
		if(_lastZindex>0){
			_lastZindex = _lastZindex - 1;
		}
		jQuery("#"+_os).css('z-index',_lastZindex);
	}
}
function open_illustration_listResize() {
}
function open_contact_list(obj) {
	var sliderID = "open_contact_gd";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery('#open_contact_list_ico').removeClass('menu-active');
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery('#open_contact_list_ico').addClass('menu-active');
		appendSlider(sliderID,'Contacts','Contacts');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="contactFormIframe" src="' + __baseUrl + 'opportunity/contact_list" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeContactSlider)');
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
}

function closeContactSlider() {
	jQuery('#open_contact_list_ico').removeClass('menu-active');
}

function checkContactsLoad(){
	setTimeout(function(){
		jQuery.ajax({
			type: "POST",
			url: __baseUrl + "dashboard/search_contact",
			cache: !1,
			success: function(c) {
				availableTags = jQuery.parseJSON(c)
			}
		});
	},5000);
}

function open_contact_listResize() {
}

function openCalendarSlide(obj){
	divObj = jQuery("#open_files_gd1");
	_h=jQuery(window).height();/*_h = _h-80;*/
	divObj.hasClass("is-open") ? checkModalFrontOrHide(divObj, function() {
        closeSlideBarLeftSales();jQuery("#activityType").val('');
    }) : (divObj.find('.slimScrollDiv').css('height',_h+'px'),$("body").append('<div class="modal-backdrop modal-backdrop-drive"></div>'),divObj.find('#open_drive_files').html('<iframe src="' + __baseUrl + 'users/company_calendar" width="100%" height="'+_h+'px" scrolling="yes"></iframe>'), openSlidebar(divObj),    slidebarOpenCallback(divObj), divObj.addClass("is-open"), open_prefined_listResize())
}

function closeSlideBarLeftCCompany() {
    jQuery("#open_ccompany_list").html("");
    closeSlidebar(jQuery("#open_ccompany_gd"));
    $(".modal-backdrop-drive:eq(0)").remove()
}

function open_sales_list(b) {
	var sliderID = "open_sales_gd";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {		
		appendSlider(sliderID,'Companies','Companies');
		if(jQuery("#"+sliderID).length > 0) {
			/*jQuery("#"+sliderID).find('.slider_container').html('<iframe id="salesFormIframe" src="' + __baseUrl + "opportunity/sales_contact/" + leadGlobal + "/" + b + '" width="100%" height="100px" scrolling="yes"></iframe>');*/
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="salesFormIframe" src="' + __baseUrl + "opportunity/company_list/" + leadGlobal + "/" + b + '" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
}

function openTimeLineActivity(){
	var sliderID = "activity";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery("#activity-btn").removeClass("menu-active");
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery("#activity-btn").addClass("menu-active");
		appendSlider(sliderID,'Activites','Activites');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="profileFormIframe" src="' + __baseUrl + 'users/activity/'+leadGlobal+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeActivity)');
		}
	}
}
function closeActivity() {
	jQuery("#activity-btn").removeClass("menu-active");
}
function openTasksICreated(){
	var sliderID = "tasksCreatedForMe";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery("#task-i-btn").addClass("menu-active");
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery("#task-i-btn").addClass("menu-active");
		appendSlider(sliderID,'I Created','ICreated');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="frame_task_i_created" src="' + __baseUrl + 'leads/user_task_list/0/'+leadGlobal+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeSlideBarTasksICreated)');
		}
	}
}
function openTasksICreatedForMe(){
	var sliderID = "tasksICreated";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery("#task-btn").addClass("menu-active");
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery("#task-btn").addClass("menu-active");
		appendSlider(sliderID,'For Me','ForMe');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="frame_task_me_created" src="' + __baseUrl + 'leads/user_task_list/1/'+leadGlobal+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeSlideBarTasksCreatedForMe)');
		}
	}
}


function openMessagesICreated(){
	var sliderID = "messagesForMe";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery("#btn-my-notify-user").removeClass("menu-active");
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery("#btn-my-notify-user").addClass("menu-active");
		appendSlider(sliderID,'Messages I Sent','MessagesISent');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="frame_message_i_created" src="' + __baseUrl + 'leads/messages/0/'+leadGlobal+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeMessagesICreated)');
		}
	}
}
function openMessagesForMe(){
	var sliderID = "messagesICreated";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery("#btn-notify-user").removeClass("menu-active");
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery("#btn-notify-user").addClass("menu-active");
		appendSlider(sliderID,'Messages For Me','MessagesForMe');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="frame_message_for_me" src="' + __baseUrl + 'leads/messages/1/'+leadGlobal+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeMessagesForMe)');
		}
	}
}

function openVoiceMail(){
	var sliderID = "voiceMailContainer";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		appendSlider(sliderID,'Voice mail','VoiceMail');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<ul class="embedVoiceMail"></ul>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
}
function closeSlideBarVoiceMail(){
	/*jQuery('#task-btn').removeClass('menu-active');*/
    closeSlidebar(jQuery("#voiceMailContainer"));
    jQuery(".modal-backdrop-drive:eq(0)").remove();
}
function openLeadDetail(leadID){
	jQuery("#all_type_list").find("tbody").find("tr").each(function(){
		if(jQuery(this).attr('data-id')==leadID){
			threadDetail(jQuery(this));
		}
	});	
}
function closeSlideBarTimeLineAcitivity(){
	jQuery('#activity-btn').removeClass('menu-active');
	jQuery("#activity").find("#frame_activity").attr("src","about:blank");
    closeSlidebar(jQuery("#activity"));
    jQuery(".modal-backdrop-drive:eq(0)").remove();
}
function closeSlideBarTasksICreated(){
	jQuery('#task-i-btn').removeClass('menu-active');
}
function closeSlideBarTasksCreatedForMe(){
	jQuery('#task-btn').removeClass('menu-active');
}
function closeMessagesForMe(){
	jQuery('#btn-notify-user').removeClass('menu-active');
}
function closeMessagesICreated(){
	jQuery('#btn-my-notify-user').removeClass('menu-active');
}
function closePosCustomerList(){	

}
function closeLicenseList(){	

}
function open_sales_listResize() {
	var d = $("#salesFormIframe"),
        e = $(window).height() - 82;
		m = e - 2;
		jQuery("#open_sales_gd").find('.slimScrollDiv').css('height',e+'px');jQuery("#open_sales_gd").css('height',e+'px');
    d.length && (d.height(m), document.getElementById("salesFormIframe").contentWindow.resizeDataTable && document.getElementById("salesFormIframe").contentWindow.resizeDataTable(m))
}

function closeSlideBarLeftContact() {
    jQuery("#open_contact_list").html("");
    closeSlidebar(jQuery("#open_contact_gd"));
	jQuery('#open_contact_list_ico').removeClass('menu-active');
    $(".modal-backdrop-drive:eq(0)").remove()
}

function closeSlideBarLeftSales() {
    jQuery("#open_sales_list").html("");
    closeSlidebar(jQuery("#open_sales_gd"));
	jQuery('#scanned_documents').removeClass('menu-active')
    $(".modal-backdrop-drive:eq(0)").remove()
}

function closeSlideBarLucid() {
    jQuery("#scrapLucid").html("");
    closeSlidebar(jQuery("#scrapLucidData"));

    $(".modal-backdrop-drive:eq(0)").remove()
}

function openSlideBarLeftMessageResize() {
    $('#myDashboardComposeEmails .modal-body').outerHeight($(window).height() - 220);
}
function closeSlideBarLeftMessage() {
    closeSlidebar(jQuery("#gmail_message_modal"));
/*
    jQuery("body").attr("onselectstart", "return false");

    document.oncontextmenu = new Function("return false");*/
    $(".modal-backdrop-drive:eq(0)").remove();
    jQuery("#eventCid").val(0);
    jQuery("#eventPid").val(0);
}

function closeSlideBarGoogle() {
    jQuery("#scrapGooglePatent").html("");
    closeSlidebar(jQuery("#scrapGoogleData"));

    $(".modal-backdrop-drive:eq(0)").remove()
}

function openExcelSheet() {
	if(snapGlobal=="" || snapGlobal=="undefined" || snapGlobal==undefined){
		console.log('asd');
		if(jQuery("#patentWorksheetId").val()!=""){
			snapGlobal = jQuery("#patentWorksheetId>option:selected").data('href');
		}else {
			snapGlobal = "";
		}
	}
	if(snapGlobal != "" && snapGlobal != "undefined") {
		var sliderID = "excelData";
		if(jQuery("#"+sliderID).hasClass('is-open')) {
			checkModalFrontOrHide(jQuery("#"+sliderID), function() {
				closeSlideBar(jQuery("#"+sliderID))
			});
		} else {
			appendSlider(sliderID,'Patent Sheet','PatentSheet');
			if(jQuery("#"+sliderID).length > 0) {
				jQuery("#"+sliderID).find('.slider_container').html('<iframe id="profileFormIframe" src="' + snapGlobal + '" width="100%" height="100px" scrolling="yes"></iframe>');
				openSlidebar(jQuery("#"+sliderID));
				slidebarOpenCallback(jQuery("#"+sliderID));
				jQuery("#"+sliderID).addClass("is-open");
				changeIframeHeight(jQuery("#"+sliderID));
			}
		}
	} else {
		call(__baseUrl+'leads/findLeadPatentFileAndSheet/'+leadGlobal,"POST",{},leadPatentFile,"json");
	}    
}

function leadPatentFile(data,textStatus,xhr) {
	if(data.file_url != "") {
		snapGlobal = data.file_url;
		snapGlobalFileID = data.spreadsheet_id;
		if(snapGlobal != "") {
			jQuery("#patentFileUrl").val(snapGlobal);
			openExcelSheet();
		}		
	} else {
		console.log("No patent file sheet.");
	}
}

function closeSlideBarLeftGoogle() {
    0 == jQuery("input[name='checkbox-example-2221']").prop("checked") && (chDa = 1, 0 == jQuery("#timmerPopup").is(":visible") && (jQuery("input[name='checkbox-example-2221']").prop("checked", !0),
        jQuery(".bootstrap-switch-wrapper").removeClass("bootstrap-switch-off").addClass("bootstrap-switch-on"),
        runLogin()));

    closeSlidebar(jQuery("#excelData"));

    jQuery(".modal-backdrop-excel").remove()
}
_fileExt = ['.docx','.doc','.ppt','.pptx'];
function checkStringExt(_str){
	_find = false;
	jQuery.each(_fileExt,function(i,ext){
		if(_str.indexOf(ext)>=0){
			_find = true;
			return;
		}
	});
	return _find;
}
function open_drive_files(c,f) {
	if(typeof _mainButtonParentElement!="undefined" && _mainButtonParentElement!=""){
		jQuery("#"+_mainButtonParentElement).find("#litigation_doc_list>ul").find('li').removeClass("active");
	}
	if(jQuery('li.docDragable').length>0){
		jQuery('li.docDragable').removeClass("active");
		if(jQuery('li.docDragable').find('a[data-href="'+c+'"]').length>0){
			jQuery('li.docDragable').find('a[data-href="'+c+'"]').parent().addClass('active');
			jQuery('li.docDragable').find('a[data-href="'+c+'"]').parent().parent().parent().find('div.sales-activity-notes-content').addClass('active');
			if(jQuery('li.docDragable').find('a[data-href="'+c+'"]').parent().parent().parent().find('div.sales-activity-notes-content.active').length>0){
				_eID = jQuery('li.docDragable').find('a[data-href="'+c+'"]').parent().parent().parent().find('div.sales-activity-notes-content.active').find('a').data('tr');
				if(jQuery("#displayEmail").find('iframe').length>0){
					_src = jQuery("#displayEmail").find('iframe').attr('src');
					_number = _src.split("/").pop();
					if(isNaN(_number)){
						jQuery('li.docDragable').find('a[data-href="'+c+'"]').parent().parent().parent().find('div.sales-activity-notes-content.active').find('a').eq(0).trigger('click');
					} else {
						if(parseInt(number)!=parseInt(_eID)){
							jQuery('li.docDragable').find('a[data-href="'+c+'"]').parent().parent().parent().find('div.sales-activity-notes-content.active').find('a').eq(0).trigger('click');
						}
					}
				} else {
					jQuery('li.docDragable').find('a[data-href="'+c+'"]').parent().parent().parent().find('div.sales-activity-notes-content.active').find('a').eq(0).trigger('click');
				}				
			}
		} else {
			jQuery("#activityTable,#aquisitionTable").find('.active').removeClass('active');
		}
	}
	if(checkStringExt(c)===false){
		
		var sliderID = "open_files_gd";
		var openSlider = false;
		if(jQuery("#"+sliderID).hasClass('is-open')) {
			openSlider = true;
			checkModalFrontOrHide(jQuery("#"+sliderID), function() {});
		} 
		if(jQuery("#"+sliderID).hasClass("is-open")&& jQuery("#open_files_gd1").hasClass("is-open")==false){	
			sliderID = 'open_files_gd1';openSlider = false;
		}
		if(openSlider === false) {
			appendSlider(sliderID,'Drive Files','DriveFiles');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeSlideBarLeftDrive)');
		}		
		if(typeof f=='undefined'){
		    jQuery("#other_list_boxes").find("table>tbody").find("tr>td").removeClass("active");
			if(jQuery('li.docDragable').find('a[data-href="'+c+'"]').parent().parent().parent().find('div.sales-activity-notes-content.active').length==0){
				jQuery("#displayEmail").html("");
			}			
			(jQuery("input[name='checkbox-example-2221']").prop("checked") && (jQuery("input[name='checkbox-example-2221']").prop("checked", !1), chDa = 0, jQuery(".bootstrap-switch-wrapper").removeClass("bootstrap-switch-on").addClass("bootstrap-switch-off"), runLogin()),
			jQuery.ajax({
				type: "POST",
				url: __baseUrl + "dashboard/validateDriveFilePermission",
				data: {
					f: c
				},
				cache: !1,
				success: function(d) {}
			}));
			if(jQuery("#"+sliderID).length > 0) {
				jQuery("#"+sliderID).find('.slider_container').html('<iframe id="profileFormIframe" src="' + c + '" width="100%" height="100px" scrolling="yes"></iframe>');
				changeIframeHeight(jQuery("#"+sliderID));
			}
		} else {
			if(jQuery("#"+sliderID).length > 0) {
				jQuery("#"+sliderID).find('.slider_container').html('<iframe id="profileFormIframe" src="' + c + '" width="100%" height="100px" scrolling="yes"></iframe>');
				openSlidebar(jQuery("#"+sliderID));
				slidebarOpenCallback(jQuery("#"+sliderID));
				jQuery("#"+sliderID).addClass("is-open");
				changeIframeHeight(jQuery("#"+sliderID));
			}
		}
		if(typeof _mainButtonParentElement!="undefined" && _mainButtonParentElement!=""){
			jQuery("#"+_mainButtonParentElement).find("#litigation_doc_list>ul").find('li').each(function(){
				_href = c;
				_href = _href.replace('/view?usp=drivesdk','');
				_href = _href.replace('/edit?usp=drivesdk','');
				_href = _href.replace('/preview','');
				_href = _href.split('/').pop();
				if((_href!="" && _href== jQuery(this).find('a').data('file-id')) ||  (jQuery(this).find('a').data('href')==c)){
					jQuery(this).addClass('active');
					return false;
				}
			});
		}		
	} else {
		alert('This file should first be imported into the Lead Folder and then opened from there.');
	}
}

function closeSlideBarLeftDrive() {	
    0 == jQuery("input[name='checkbox-example-2221']").prop("checked") && (chDa = 1, 0 == jQuery("#timmerPopup").is(":visible") && (jQuery("input[name='checkbox-example-2221']").prop("checked", !0),jQuery(".bootstrap-switch-wrapper").removeClass("bootstrap-switch-off").addClass("bootstrap-switch-on"), runLogin()));message = "File "+ jQuery('#'+_mainBtnParentElement).find("#litigation_doc_list>ul").find('li.active>a').text()+' close.';runHistoryUserLog(message); jQuery('#'+_mainBtnParentElement).find("#litigation_doc_list>ul").find('li').removeClass('active');
}

function addAttendees() {
    jQuery("#attendeesPlaceholder").find(".col-xs-12").append('<input type="text" name="email[]" class="form-control input-string" placeholder="Enter guest email adresses">')
}

function insertEvent() {
   /* 0 < leadGlobal ? */(jQuery('#btnEvent').css('display','none'),jQuery("#lead_id").val(leadGlobal),  _eventE = 0, _eventM = "", "" == jQuery("#eventSummary").val() && (_eventM = "Please enter title for event.", _eventE = 1), 0 == _eventE && "" == jQuery("#eventStartDate").val() && (_eventM = "Please enter start date for event.", _eventE = 1), 0 == _eventE && "" == jQuery("#eventStartTime").val() && (_eventM = "Please enter start time for event.", _eventE = 1), 0 == _eventE && "" == jQuery("#eventEndDate").val() && (_eventM = "Please enter end date for event.", _eventE = 1), 0 == _eventE && "" == jQuery("#eventEndTime").val() && (_eventM = "Please enter end time for event.", _eventE = 1), 0 == _eventE && "" == jQuery("#attendeeEmail").val() && (_eventM = "Please enter atleast one email address.", _eventE = 1), 0 == _eventE ? jQuery.ajax({
        type: "POST",
        url: __baseUrl + "users/insert_event",
        data: jQuery("#frm_calendar_event").serializeArray(),
        cache: !1,
        success: function(c) {
            jQuery('#btnEvent').css('display','')
			findDataRemoveEve = [];
			jQuery("#event_id").val("");
			jQuery("#lead_id").val(0);
			/*jQuery("#acitivity_event_type").val(0);*/
			jQuery("#attendeeEmail").val('');
			jQuery("#eventSummary").val('');
			jQuery("#eventStartDate").val('');
			jQuery("#eventEndDate").val('');
			jQuery("textarea[name='event[description]']").val('');
			jQuery("#eventLocation").val('');
			close_all_invitation();
            /*threadDetail(jQuery("#all_type_list").find("tbody").find("tr.active"))*/
			refreshAcquisitionAndSalesActivity();
			jQuery('#btnEvent').css('display','')
        }
    }) : alert(_eventM),jQuery('#btnEvent').css('display',''))/* : alert("Please select lead first")*/
}
/*
function open_all_invitation() {
    jQuery("#open_invitation").hasClass("is-open") ? checkModalFrontOrHide(jQuery("#open_invitation"), function() {
        close_all_invitation()
    }) : ($("body").append('<div class="modal-backdrop modal-backdrop-drive"></div>'), jQuery("#eventPredefinedMessage").attr("src", __baseUrl + "users/predefined_templates/2"), 
    openSlidebar(jQuery("#open_invitation")),
	
    slidebarOpenCallback(jQuery("#open_invitation")), jQuery("#open_invitation").addClass("is-open")),
    open_all_invitationResize()
}*/
function activityChange(o){
	if(jQuery("#lead_id").val()>0){
		jQuery("#frmServer,#selectedList").empty();
		getInviteesList();
	}
}

function getInviteesList(){
	jQuery.ajax({type:"POST",url:"https://backyard.synpat.com/partners/get_invitees_from_lead",data:{lead_id:jQuery("#lead_id").val(),activity:jQuery('input[name="acitivity_event_type"]:checked').val()},cache:false,success:function(a){
		availableTags=jQuery.parseJSON(a);
		//searchContact();
		jQuery("#frmServer").empty();
		jQuery(availableTags).each(function(idx,contact){
			var _name = contact.name;
			var _companyID = contact.company_id;
			var contactList = contact.list;
			var $margin = "";
			if(contactList.length==0){
				$margin = "style='margin-bottom:5px;'";
			}
			jQuery("#frmServer").append("<li class='ui-li-static ui-body-inherit not-selected' data-company='"+_companyID+"' "+$margin+" ><strong>"+_name+":</strong></li>");
			if(contactList.length>0){
				jQuery.each(contactList,function(s,cont){
					var label = "<span><strong>"+cont.name+"</strong></span>";
					if(cont.title!=""){
						label += "<span style='display:block'>"+cont.title+"</span>";
 					}
					jQuery("#frmServer").append("<li class='ui-li-static ui-body-inherit selectable' data-value='"+cont.value+"' data-id='"+cont.id+"' data-company_id='"+cont.company_id+"' >"+label+"</li>");
				});				
			}
			
		});
		jQuery("#frmServer li").eq(0).addClass("ui-first-child");
		jQuery("#frmServer li").eq(jQuery("#frmServer li").length-1).addClass("ui-last-child");
		activateListSelect();
	}});
}


function activateListSelect(){
	jQuery("#frmServer li.selectable").off("click").on("click",function(){
		var $list = jQuery(this);		
		jQuery("#selectedList").prepend($list.clone());
		$list.remove();
		selectedListActivate();
		updateSelecteEmailAddress();
	});	
}
function selectedListActivate(){
	jQuery("#selectedList li").off("click").on("click",function(){
		var $list = jQuery(this);
		var companyID = $list.data('company_id');		
		if(jQuery("#frmServer").find("li.not-selected[data-company='"+companyID+"']").length>0){
			var index = jQuery("#frmServer").find("li.not-selected[data-company='"+companyID+"']").index();
			if(jQuery("#frmServer").find("li").eq(index+1).length>0){
				var $object = jQuery("#frmServer").find("li").eq(index+1);
				$object.before($list.clone());
				$list.remove();
			} else {
				jQuery("#frmServer").append($list.clone());
				$list.remove();
			}			
		}		
		activateListSelect();
		updateSelecteEmailAddress();
	});
}

function updateSelecteEmailAddress(){
	selectedEmails = [];
	jQuery("#selectedList li").each(function(){
		selectedEmails.push(jQuery(this).data("value"));
	});
	jQuery("#attendeeEmail").val(selectedEmails.join(','));
}

function getInvitesFromLead(o){
	if(o.val()==""){
		alert("Please select a lead");
	} else {
		if(jQuery('input[name="acitivity_event_type"]:checked').length==0){
			//alert("Please select activity type.");
		} else {
			getInviteesList();
		}
	}
}

function getAllActiveLeads(){
	jQuery.ajax({type:"POST",url:"https://backyard.synpat.com/partners/get_active_leads",cache:false,success:function(a){
		var leadsList = jQuery.parseJSON(a);
		if(leadsList.length>0){			
			jQuery.each(leadsList,function(idx,lead){
				jQuery("#lead_id").append("<option value='"+lead.id+"'>"+lead.lead_name+"</option>");
			});
		}
	}});
}
function open_all_invitation(obj) {
	/*,getCalendarColors()*/
	/*jQuery("#event_calendar").css('width',frmW+'px')*/	
	var sliderID = "open_invitation";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		//jQuery('#btnTopCalendar').removeClass('menu-active');
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {		
		callUsersCalendar();
		_urlCal = 'https://backyard.synpat.com/calendar/?user_email='+jQuery("#user_email").val()+'&user_id='+jQuery("#for_user").val();
		_containerSelect = findContainer();
		_c = jQuery('#'+_containerSelect).find("input[name='sales_person[]']:checked").length;
		if(_c>0){
			if(leadGlobal>0){
				_urlCal +="&l="+leadGlobal;
			}		
			_p = "";
			_error = 0;
			_message = "";
			_sales_emails = "";
			_nameUser="";
			_companyID="";
			_modifyNaeAndC = "";
			_companyName = "";
			jQuery('#'+_containerSelect).find("input[name='sales_person[]']:checked").each(function(){
				_p +=jQuery(this).val()+",";
				_companyID +=jQuery(this).parent().parent().attr('data-c')+",";
				_sales_emails +=jQuery(this).attr('data-attr-em')+", ";
				_nameUser +=jQuery(this).attr('data-attr-name')+", ";
				_modifyNaeAndC +=jQuery(this).attr('data-attr-name')+' - '+jQuery(this).attr('data-attr-c-name')+",  ";
				_companyName +=jQuery(this).attr('data-attr-c-name')+", ";
			});
			if(_p!=""){
				_urlCal +="&p="+_p.substr(0,_p.length-1);
			}
			if(_companyID!=""){
				_urlCal +="&co="+_companyID.substr(0,_companyID.length-1);
			}
			if(_companyName!=""){
				_urlCal +="&c="+_companyName.substr(0,_companyName.length-1);
			}
			if(_mainActivity>0){
				_urlCal +="&a="+_mainActivity;
			}
			_summary = leadNameGlobal+' '+_nameUser.substr(0,_nameUser.length-2)+' / '+jQuery('.user-account-btn').find('span').eq(0).text();
			if(_summary!=""){
				_urlCal +="&s="+_summary;
			}
		}
		//jQuery('#btnTopCalendar').addClass('menu-active');
		appendSlider(sliderID,'Calendar','Calendar');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<div class="col-lg-8 col-sm-8 col-sm-7" id="event_calendar"><iframe src="' + __baseUrl + 'users/company_calendar" width="100%" height="100px" scrolling="yes" id="frame_calendar"></iframe></div><div class="col-lg-4 col-sm-4 col-sm-5" id="event_form_detail" style="margin-top:53px;"><iframe src="'+_urlCal+'" width="100%" height="100px" scrolling="yes" id="frame_event_frm" onload="addUserToken()"></iframe></div>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
			/*$(".date_calendar").datepicker({format:"yyyy-mm-dd"});$(".time-calendar").timepicker();*/
		}
	}
}
function addUserToken(){
	frmEvent = document.getElementById('frame_event_frm')
	if(frmEvent!=null){
		frmEvent.contentDocument.getElementById("another_access_token").value = _userToken;
	}	
}

function importLogedUserEmail(){
	if(jQuery("#emailFromEmail").val()!=''){findDataRemoveEve.push(jQuery("#emailFromEmail").val());jQuery("#attendeeEmail").val(jQuery("#emailFromEmail").val()+', ')}
}
function resetEventForm(){
	/*jQuery('#frm_calendar_event').get(0).reset();*/
	/*jQuery('#acitivity_event_type').val(0);*/
	jQuery('#lead_id').val(0);
	jQuery('#eventColorImplement').html('');
	jQuery('#event_id').val('');
	jQuery('#eventId').val('');
	jQuery('#eventColor').val('');
	jQuery('#eventLocation').val('Conf. Call: +1 (267) 930-4000, PIN: 530-960-605#\n\n');
	jQuery("#eventStartDate").change(function(){jQuery('#eventEndDate').val(jQuery("#eventStartDate").val())});
	jQuery('#eventStartTime').timepicker();	
	_da = moment(new Date()).tz('America/Los_Angeles').format('YYYY-MM-D h:mm:ss a');
	_date = new Date(_da);
	_currentDate = dateAdd(_date, 'second', 0);
	jQuery('#eventStartTime').val(moment(_currentDate).format('hh:mm A'));
	jQuery('#eventStartTime').change(function(){
		if(jQuery("#eventStartDate").val()!="" && jQuery('#eventStartTime').val()!=""){
			_daTE = jQuery("#eventStartDate").val()+' '+jQuery('#eventStartTime').val();_daTE = new Date(_daTE);_newCalDate = dateAdd(_daTE,'minute',30);jQuery('#eventEndTime').val(moment(_newCalDate).format('hh:mm A'));
		}
	});
}

function dateAdd(date, interval, units) {
  var ret = new Date(date);
  switch(interval.toLowerCase()) {
    case 'year'   :  ret.setFullYear(ret.getFullYear() + units);  break;
    case 'quarter':  ret.setMonth(ret.getMonth() + 3*units);  break;
    case 'month'  :  ret.setMonth(ret.getMonth() + units);  break;
    case 'week'   :  ret.setDate(ret.getDate() + 7*units);  break;
    case 'day'    :  ret.setDate(ret.getDate() + units);  break;
    case 'hour'   :  ret.setTime(ret.getTime() + units*3600000);  break;
    case 'minute' :  ret.setTime(ret.getTime() + units*60000);  break;
    case 'second' :  ret.setTime(ret.getTime() + units*1000);  break;
    default       :  ret = undefined;  break;
  }
   return ret;
}

function close_all_invitation() {   
    closeSlidebar(jQuery("#open_invitation"));
	jQuery("#activityType").val('');
	jQuery('#docket_invitation').removeClass('menu-active');
    $(".modal-backdrop-drive:eq(0)").remove()
}

function open_all_invitationResize() {
	clearIntervalRowWidth();
    setTimeout(function(){console.log('Clear interval and new set');rowWidth();inputStringFieldsWidth();},100);
	jQuery("#open_invitation .slimScrollDiv").height($(window).height() - 82);
	jQuery("#open_invitation").height($(window).height() - 82);
    /*$('#frm_calendar_event').height($(window).height() - 100);*/
    $('#eventPredefinedMessage').height($(window).height() - 430);
    document.getElementById("eventPredefinedMessage") && document.getElementById("eventPredefinedMessage").contentWindow && document.getElementById("eventPredefinedMessage").contentWindow.resizeDataTable && document.getElementById("eventPredefinedMessage").contentWindow.resizeDataTable($(window).height() - 480)
}

function openDocketSlidebar(id) {
	var sliderID = "docket_slidebar";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		jQuery('#openDocketModal').removeClass('menu-active');
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		jQuery('#openDocketModal').addClass('menu-active')
		appendSlider(sliderID,'Docket','Docket');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="docket_slidebar_iframe" src="' + __baseUrl + 'opportunity/docket/'+leadGlobal+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
			jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeDocket)');
		}
	}
}
function closeDocket() {
	jQuery('#openDocketModal').removeClass('menu-active');
}

function closeDocketSlidebar() {
}

$(document).ready(function() {
    $(".switch-button").click(function(d) {
        d.preventDefault();
        d = $(this).attr("switch-parent");
        var e = $(this).attr("switch-target");
        $(d).slideToggle();
        $(e).slideToggle()
    });
    $(".hidden-button").hover(function() {
        $(".btn-hide", this).fadeIn("fast")
    }, function() {
        $(".btn-hide", this).fadeOut("normal")
    });
    $(".toggle-button").click(function(c) {
        c.preventDefault();
        $(".glyph-icon", this).toggleClass("icon-rotate-180");
        $(this).parents(".content-box:first").find(".content-box-wrapper").slideToggle()
    });
    $(".remove-button").click(function(e) {
        e.preventDefault();
        var g = $(this).attr("data-animation"),
            f = $(this).parents(".content-box:first");
        $(f).addClass("animated");
        $(f).addClass(g);
        window.setTimeout(function() {
            $(f).slideUp()
        }, 500);
        window.setTimeout(function() {
            $(f).removeClass(g).fadeIn()
        }, 2500)
    });
    $(function() {
        $(".infobox-close").click(function(c) {
            c.preventDefault();
            $(this).parent().fadeOut()
        })
    })
});
$(document).ready(function() {
    $(".overlay-button").click(function() {
        var e = $(this).attr("data-theme"),
            g = $(this).attr("data-opacity"),
            f = $(this).attr("data-style"),
            e = '<div id="loader-overlay" class="ui-front loader ui-widget-overlay ' + e + " opacity-" + g + '"><img src="../../assets/images/spinner/loader-' + f + '.gif" alt="" /></div>';
        $("#loader-overlay").length && $("#loader-overlay").remove();
        $("body").append(e);
        $("#loader-overlay").fadeIn("fast");
        setTimeout(function() {
            $("#loader-overlay").fadeOut("fast")
        }, 3000)
    });
    $(".refresh-button").click(function(e) {
        $(".glyph-icon", this).addClass("icon-spin");
        e.preventDefault();
        e = $(this).parents(".content-box");
        var i = $(this).attr("data-theme"),
            h = $(this).attr("data-opacity"),
            g = $(this).attr("data-style"),
            i = '<div id="refresh-overlay" class="ui-front loader ui-widget-overlay ' + i + " opacity-" + h + '"><img src="../../assets/images/spinner/loader-' + g + '.gif" alt="" /></div>';
        $("#refresh-overlay").length && $("#refresh-overlay").remove();
        $(e).append(i);
        $("#refresh-overlay").fadeIn("fast");
        setTimeout(function() {
            $("#refresh-overlay").fadeOut("fast");
            $(".glyph-icon", this).removeClass("icon-spin")
        }, 1500)
    })
});
$(function() {
    $('a[href="#"]').click(function(c) {
        c.preventDefault()
    })
});
$(function() {
    $(".todo-box li input").on("click", function() {
        $(this).parent().toggleClass("todo-done")
    })
});
$(function() {
    var c = 0;
    $(".timeline-scroll .tl-row").each(function(g, e) {
        var b = $(e);
        c += b.outerWidth() + parseInt(b.css("margin-left"), 10) + parseInt(b.css("margin-right"), 10)
    });
    $(".timeline-horizontal", this).width(c)
});
$(function() {
    $(".scrollable-slim").slimScroll({
        color: "#8da0aa",
        size: "10px",
        alwaysVisible: !0
    })
});
$(function() {
    $(".scrollable-slim-sidebar").slimScroll({
        color: "#8da0aa",
        size: "10px",
        height: "100%",
        alwaysVisible: !0
    })
});
$(function() {
    $(".scrollable-slim-box").slimScroll({
        color: "#8da0aa",
        size: "6px",
        alwaysVisible: !1
    })
});
$(function() {
    $(".tooltip-button").tooltip({
        container: "body",
        trigger: 'hover',
        delay: {
            "show": 2000, 
            "hide": 100
        }
    });
});
var _panelMarginBottom = 4,
    _inputStringFieldsWidthInterval = null,
    _inputStringFieldsWidthIntervalPeriod = 700,
    _rowWidthInterval = null,
    _rowWidthIntervalPeriod = 300;

function windowResize() {
    $("body").css("height", window.InnerHeight + "px");
    $(".dashboard-box, .dashboard-box-1").each(function() {
        $(this).css("height", window.innerHeight - $(this).offset().top - _panelMarginBottom + "px")
    });
    jQuery("#my_c_task_list").find(".dashboard-box").each(function() {
        $(this).css("height", window.innerHeight - $(this).offset().top + "px")
    });
	if(jQuery("#all_type_list").length>0 && jQuery("#all_type_list").find('thead th').length>0
	){
		runFixedHeaderColumnData(1);
		runFixedHeaderWidthAdjustment();
	}
	
    $(".dashboard-box-2").each(function() {
        $(this).css("height", window.innerHeight - $(this).offset().top + "px")
    });
    $("#notifications-btn .slimScrollDiv, #notifications-btn .scrollable-content").height($(window).height() - 200);
    $("#my-notifications-btn .slimScrollDiv, #my-notifications-btn .scrollable-content").height($(window).height() - 200);
    $("#dashboard-page #message-detail").length && ($("#dashboard-page #message-detail").outerHeight($("#contentPart").outerHeight() - 22), $("#dashboard-page #messages-list > div").outerHeight($("#contentPart").outerHeight() - 24));
	if(jQuery(window).width()<1025){
		jQuery('#header-logo').css('display','none');
		jQuery('#mobile-navigation').css('display','block');
		jQuery('.user-account-btn').find('i.icon-angle-down').css('float','left');
		jQuery('.user-account-btn').find('.dropdown-menu').css('left','-120px');
		jQuery('.breadcrumb').css('display','none');
	} else {
		jQuery('#header-logo').css('display','');
		jQuery('.breadcrumb').css('display','');
		jQuery('#mobile-navigation').css('display','none');
		jQuery('.user-account-btn').find('i.icon-angle-down').css('float','right');
		
	}
	_spT = jQuery('.user-account-btn').find('span').eq(0).offset();
	_wT = jQuery(window).width();
	_leftCal = (_wT - _spT + 115)*-1;
	jQuery('.user-account-btn').find('.dropdown-menu').css('left',_leftCal+'px');
	clearIntervalRowWidth();
    setTimeout(function(){console.log('Clear interval and new set');rowWidth();inputStringFieldsWidth();},100);
	if(jQuery("#split_window_screen").hasClass('menu-active1') && jQuery("#btnEmail").hasClass('menu-active')){
		if(typeof splitWindow=="function"){
			splitWindow(3);
		}
	} else if(jQuery("#split_window_screen").hasClass('menu-active1')){
		if(typeof splitWindow=="function"){
			splitWindow(2);
		}
	} else if(jQuery("#btnEmail").hasClass('menu-active')){
		if(typeof splitWindow=="function"){
			splitWindow(1);
		}
	}
	checkMyEmailsHeight();
	/*w = jQuery(window).width();
	h = jQuery(window).height();
	nH = h - 82,m = nH-35;
	w = w*65/100;
	$sideBar = jQuery("#open_company_add");
	$sideBar.find('.slimScrollDiv').css('height',nH+'px');
	$sideBar.css('height',nH+'px');
	$sideBar.find('.pad15A').find('iframe').css({height:m+'px'});*/
	jQuery('.sb-slidebar.is-open').each(function(){
		changeIframeHeight(jQuery(this));
	});
}
window.onresize = function() {
    windowResize();/*eventWidth();*/
};
window.onload = function() {
    $("body").css("height", window.InnerHeight + "px");
    $(".dashboard-box, .dashboard-box-1").each(function() {
        $(this).css("overflow-x", "hidden");
        $(this).css("overflow-y", "auto");
        $(this).css("height", window.innerHeight - $(this).offset().top - _panelMarginBottom + "px")
    });
    $(".dashboard-box-2").each(function() {
        $(this).css("overflow-x", "hidden");
        $(this).css("overflow-y", "auto");
        $(this).css("height", window.innerHeight - $(this).offset().top + "px")
    });
    windowResize()
};

function inputStringFieldsWidth() {
    $(".input-string-group").each(function(e, l) {
        var k = $(this),
            i = k.find("label"),
            h = k.find(".form-control");
            s = k.find(".span-control");
            s1 = k.find(".span-control1");
			sWidth = 0;
			if(i.length>0 && s1.length>0 && k.find('input[type="checkbox"]').length>0){
				sWidth = k.width() - i.width() - 45;
			} else if(i.length>0 && s1.length>0){
				sWidth = k.width() - i.width() - 35;
			} else if(i.length>0 && s1.length==0){
				sWidth = k.width() - i.width() - 30;
			} else if(i.length==0 && s1.length==0){
				sWidth = k.width() -  30;
			}
			h.is(":focus") || (i.length ? h.width(k.width() - i.width() - 20) : h.width(k.width() - 20), 15 >= h.width() ? h.addClass("nopadding").css("text-align", "right") : h.removeClass("nopadding").css("text-align", "left"))
			s.is(":focus") || (s.width(sWidth), 15 >= s.width() ? s.addClass("nopadding").css("text-align", "right") : s.removeClass("nopadding").css("text-align", "left"))
    });
	$('.input-string-group-special').each(function(){
		var k = $(this);
		_labelWidth = 0;
		k.find('label').each(function(){
			_labelWidth = _labelWidth + jQuery(this).width();
		});		
		
		/*_l = k.find('.span-control2').length;
		r = (k.width() - _labelWidth-23) / _l;*/
		r = (k.width() - _labelWidth-23-25) ;
		_l = k.find('.span-control2').length;
		if(_l==0){			
			_l = k.find('.span-control3').length;
			r = (k.width() - _labelWidth-15) / _l;
			k.find('.span-control3').css('width',r+'px');
		}else if(_l==3){
			s = (r*40)/100;
			k.find('.span-control2').eq(1).css('width',s+'px');
			r = (r*30)/100;
			k.find('.span-control2').eq(0).css('width',r+'px');
			k.find('.span-control2').eq(2).css('width',r+'px');
		} else{
			r = (k.width() - _labelWidth-5) / _l;
			k.find('.span-control2').css('width',r+'px');
		}		
	});
	$('.input-string-group-special-input').each(function(){
		var k = $(this);
		_labelWidth = 0;
		k.find('label').each(function(){
			_labelWidth = _labelWidth + jQuery(this).width();
		});	
		_l = k.find('.form-control').length;
		if(k.find('.clsChkBox').length>0){
			r = (k.width() - _labelWidth-30) / _l;
		} else if(_l>1){
			r = (k.width() - _labelWidth-18) / _l;
		} else {
			r = (k.width() - _labelWidth) / _l;
		}
		if(k.find('select').length>0){
			/*r -= 5;*/
		}
		k.find('.form-control').css('width',r+'px');
	});
}

function rowWidth() {
    $(".row.row-width").each(function(e, l) {
        var k = $(l),
            i = k.find(">div:not(.col-width)").length,
            h = 0;
		if(k.width()>0){
			k.find(">div.col-width").each(function(f, m) {
				var g = $(m);
				h += g.outerWidth()
			});
			i && k.find(">div:not(.col-width)").each(function(d, n) {
				var g = $(n),
					m = 100,
					m = g.attr("class").split(" "),
					m = m.filter(function(c) {
						return -1 !== c.indexOf("col-")
					});
				if (m.length) {
					m = m[0].split("-")[2];
					switch (m) {
						case "1":
							m = 8.3333;
							break;
						case "2":
							m = 16.6667;
							break;
						case "3":
							m = 25;
							break;
						case "4":
							m = 33.3333;
							break;
						case "5":
							m = 41.6667;
							break;
						case "6":
							m = 50;
							break;
						case "7":
							m = 58.3333;
							break;
						case "8":
							m = 66.6667;
							break;
						case "9":
							m = 75;
							break;
						case "10":
							m = 83.3333;
							break;
						case "11":
							m = 91.6667;
							break;
						case "1x5":
							m = 20;
							break;	
						case "12":
						default:
							m = 100;
							break;
					}
					if(g.attr('id')!=undefined && g.attr('id')=="listMainContainerModif"){
						if(_relaseSplit===false){
							g.outerWidth((k.width() - h) * m / 100 - 2.5);
						}					
					} else {
						g.outerWidth((k.width() - h) * m / 100 - 2.5)
					}
				}
			})
		}
    })
}
function clearIntervalRowWidth(){
	clearInterval(_rowWidthInterval);
	clearInterval(_inputStringFieldsWidthInterval);
}
function enableIntervalRowWidth() {
	_inputStringFieldsWidthInterval = setInterval(inputStringFieldsWidth, _inputStringFieldsWidthIntervalPeriod);
	_rowWidthInterval = setInterval(rowWidth, _rowWidthIntervalPeriod);
}
$(document).ready(function() {
    enableIntervalRowWidth();
    /*$("#close-sidebar").on("click", function() {
        clearInterval(_inputStringFieldsWidthInterval);
        $(".input-string-group .form-control").width(15);
        _inputStringFieldsWidthInterval = setInterval(inputStringFieldsWidth, _inputStringFieldsWidthIntervalPeriod)
        // setTimeout(inputStringFieldsWidth, 300);
    });*/
    
    /*$("#close-sidebar").on("click", function() {
        clearInterval(_rowWidthInterval);
        _rowWidthInterval = setInterval(rowWidth, _rowWidthIntervalPeriod)
        // setTimeout(rowWidth, 300);
    });*/
    body_sizer();
    $("div[id='#fixed-sidebar']").on("click", function() {
        if ($(this).hasClass("switch-on")) {
            var d = $(window).height(),
                e = $("#page-header").height(),
                d = d - e;
            $("#page-sidebar").css("height", d);
            $(".scroll-sidebar").css("height", d);
            d = $("#page-header").attr("class");
            $("#header-logo").addClass(d)
        } else {
            d = $(document).height(), e = $("#page-header").height(), d -= e, $("#page-sidebar").css("height", d), $(".scroll-sidebar").css("height", d), $("#header-logo").removeClass("bg-gradient-9")
        }
    });
    $("body").data("modalzindex", 1050);
    $(".modal").on("shown.bs.modal", function() {
        var c = $("body").data("modalzindex"),
            c = parseInt(c) + 1;
        $("body").data("modalzindex", c);
        $(this).css("z-index", c)
    })
});
$(window).on("resize", function() {
    body_sizer()
});

function body_sizer() {
    $("body").hasClass("fixed-sidebar") ? $(window).height() : $(document).height();
    $("#page-header").height()
}

function pageTransitions() {
    var e = ".pt-page-moveFromLeft pt-page-moveFromRight pt-page-moveFromTop pt-page-moveFromBottom pt-page-fade pt-page-moveFromLeftFade pt-page-moveFromRightFade pt-page-moveFromTopFade pt-page-moveFromBottomFade pt-page-scaleUp pt-page-scaleUpCenter pt-page-flipInLeft pt-page-flipInRight pt-page-flipInBottom pt-page-flipInTop pt-page-rotatePullRight pt-page-rotatePullLeft pt-page-rotatePullTop pt-page-rotatePullBottom pt-page-rotateUnfoldLeft pt-page-rotateUnfoldRight pt-page-rotateUnfoldTop pt-page-rotateUnfoldBottom".split(" "),
        g;
    for (g in e) {
        var f = e[g];
        if ($(".add-transition").hasClass(f)) {
            $(".add-transition").addClass(f + "-init page-transition");
            setTimeout(function() {
                $(".add-transition").removeClass(f + " " + f + "-init page-transition")
            }, 1200);
            break
        }
    }
}
$(document).ready(function() {
    pageTransitions();
    /*$(function() {
        $("#sidebar-menu").superclick({
            animation: {
                height: "show"
            },
            animationOut: {
                height: "hide"
            }
        })
    });*/
    $("#emailOpenModal").on("hidden.bs.modal", function() {
        $("#emailOpenContent").empty()
    });
    
	/*$("#close-sidebar").on('click',function() {
		_cWI = window.location.href;
		if(_cWI.indexOf('general')>=0){
			checkPageRefresh();
		} else {
			objEmailRetrive = jQuery('#myEmailsRetrieve');
			if(!objEmailRetrive.is(":visible")){
				jQuery("#btnEmail").addClass('menu-active');
				jQuery("#split_window_screen").addClass('menu-active1');
				objEmailRetrive.slideDown(function(){
					jQuery.cookie("show_default_email",true);
					windowResize();
					jQuery("#all_type_list_wrapper .sorting:first").trigger("click");

					setTimeout(function(){
						jQuery("#all_type_list_wrapper .sorting:first").trigger("click")
					},300);
					checkBodyScrollable();						
				}); 
			} else {
				jQuery("#header-nav-right").find('li>a.menu-active').removeClass('menu-active');
				jQuery("#split_window_screen").removeClass('menu-active1');							
				/*
				jQuery("#activityMainType").val(0);
				leadGlobal = 0;
				jQuery("#all_type_list_wrapper").find('tr').removeClass('active');
				jQuery('.topbar-lead-name').html('');
				*/
				/*jQuery("#sales_acititity,#patent_data,#show_data").removeClass("show").addClass("hide");
				jQuery('#from_litigation,#from_regular,#from_nonacquistion').css('display','none');
				objEmailRetrive.slideUp(function(){
					jQuery.cookie("show_default_email","");
					windowResize();
				})					
			}
			$("body").toggleClass("closed-sidebar");
			$(".glyph-icon", this).toggleClass("icon-angle-right").toggleClass("icon-angle-left");
		}
	});*/
});

function closeSlideBarLeftMessagePredfined() {
	jQuery("#scanned_documents").removeClass('menu-active');
	jQuery("#predefineFormIframe").attr("src","about:blank");
    closeSlidebar(jQuery("#open_prefined_message"));
	jQuery("#activityType").val('2');
    $(".modal-backdrop-drive:eq(0)").remove();
}
function closeSlideBarGoogleContact() {
	jQuery("#scanned_documents").removeClass('menu-active');
	jQuery("#googleFormIframe").attr("src","about:blank");
    closeSlidebar(jQuery("#open_prefined_message_google"));
	jQuery("#activityType").val('2');
    $(".modal-backdrop-drive:eq(0)").remove();
}

function closeSlideBarLeftMessageLead() {
	jQuery("#scanned_documents").removeClass('menu-active');
	jQuery("#leadFormIframe").attr("src","about:blank");
    closeSlidebar(jQuery("#open_lead_message"));
	jQuery("#activityType").val('2');
    $(".modal-backdrop-drive:eq(0)").remove();
}

function getPredefinedMessages(c) {
	var sliderID = "open_prefined_message";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID));//jQuery("#activityType").val('');
		});
	} else {		
		appendSlider(sliderID,'Lead Message Templates','Templates');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="predefineFormIframe" src="' + __baseUrl + "users/predefined_templates/" + c + '" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
}

function open_prefined_listResize() {

}

function getLeadTemplates(c) {
	var sliderID = "open_lead_message";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {		
		appendSlider(sliderID,'Lead Messages','LeadMessages');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="leadFormIframe" src="' + __baseUrl + "users/lead_templates/" + leadGlobal + "/" + c + '" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
	/*a = 1;*/
}
function leadTemplatesResize() {
   /* $("#leadFormIframe").height($(window).height() - 110);
    document.getElementById("leadFormIframe") && document.getElementById("leadFormIframe").contentWindow && document.getElementById("leadFormIframe").contentWindow.resizeDataTable && document.getElementById("leadFormIframe").contentWindow.resizeDataTable($(window).height())*/
}

function findEmailsFromSearchCriteria() {
	jQuery("#s_result").empty();
	var advanceSearch = jQuery("#advanced_search");
    advanceSearch.find("#emailListSearch").html('<div class="loading-spinner" id="loading_spinner_heading_drive" style="display:block;"><img src="'+__IMAGEURL+'images/ajax-loader.gif" alt=""></div>');
    jQuery.ajax({
        url: __baseUrl + "users/search_gmail",
        type: "POST",
        data: advanceSearch.find("#advanced_search_form").serializeArray(),
        cache: !1,
        success: function(c) {
            advanceSearch.find("#emailListSearch").html(c)
        }
    }).done(function(){
		if(advanceSearch.find("#emailListSearch").find('div.message-item').length>0){
			_messageID = [];
			advanceSearch.find("#emailListSearch").find('div.message-item').each(function(){
				if(typeof(jQuery(this).data('id'))!="undefined" && jQuery(this).data('id')!=""){
					_messageID.push(jQuery(this).data('id'));
				}
			});
			if(_messageID.length>0){
				call(__baseUrl+"leads/findEmailsInLeadBulk",'POST',{message_ids:_messageID},embedToSearchEmails,'json');
			}
		}
	});
}

window.embedToSearchEmails = function(data,textStatus,xhr){
	if(data.length>0){
		var advanceSearch = jQuery("#advanced_search");
		jQuery(data).each(function(i,s){
			_findObject = advanceSearch.find("#emailListSearch").find('div[data-id="'+s.message_id+'"]')
			if(_findObject.length>0){
				_findObject.find('span.lead_name').html(s.lead_name);
				if(_findObject.find('i.icon-folder').length==0){
					_findObject.find('span.lead_name').before("<i class='glyph-icon icon-folder' style='color:#2196f3'></i>");
				}
			}
		});
	}
}

function findNewThread(c,o) {
    "object" == typeof _globalAjax && _globalAjax.abort();
    j = 296;
	var advanceSearch = jQuery("#advanced_search");
	advanceSearch.find("#emailListSearch").find('.message-item').removeClass('message-active');
		o.parent().parent().parent().addClass('message-active');
	if(leadGlobal>0 && jQuery("#activityMainType").val()>0){
		jQuery("#displayEmail").html('<iframe src="' + __baseUrl + "users/search_email/" + jQuery.trim(c) + '" scrolling="yes" width="100%" height="' + j + '">');
		var _acTbl;
		if(jQuery("#aquisitionTable").length>0){
			_acTbl="#aquisitionTable";
		}else if(jQuery("#activityTable").length>0){
			_acTbl="#activityTable";
		}else if(window.parent.jQuery("#aquisitionTable").is(":visible")){
			_acTbl="#aquisitionTable";
		} else if(window.parent.jQuery("#activityTable").is(":visible")){
			_acTbl="#activityTable";
		}
		var findDivContent = jQuery(_acTbl).find('tbody.main_active').find('div.sales-activity-notes-content');
		if(findDivContent.length>0 && findDivContent.hasClass('active')){
			findDivContent.removeClass('active');
		}
		emailLoadHeight();
		_container="";
		if(jQuery("#activityMainType").val()==1){
			_container = "activityTable";
		} else{
			_container = "aquisitionTable";
		}		
		if(jQuery("#"+_container).find("input[name='sales_person[]']").is(':checked')){
			if(jQuery("#"+_container).find("input[name='sales_person[]']:checked").length==1){
				var cnfrm = confirm("Are you sure you want to attach this email with "+jQuery("#"+_container).find("input[name='sales_person[]']:checked").eq(0).data('attr-name'));
				if(cnfrm){
					_date = o.parent().parent().parent().attr('data-date');
					_subject = o.parent().parent().parent().find('h4.c-dark').text();
					jQuery.ajax({
						type:'POST',
						url:__baseUrl+'dashboard/linkSearchMessage/',
						data:{lead:leadGlobal,mesg:jQuery.trim(c),date:_date,type:1,send_from:0,p_id:jQuery("#"+_container).find("input[name='sales_person[]']:checked").val(),c_id:jQuery("#"+_container).find("input[name='sales_person[]']:checked").parent().parent().attr('data-c'),activity_type:jQuery("#activityMainType").val(),subject:_subject},
						cache:false,
						success:function(data){
							if(data>0){
								o.parent().parent().parent().remove();
								jQuery(".messages_container").find('.message-item').each(function(){
									if(jQuery(this).attr('data-id')==jQuery.trim(c)){
										jQuery(this).remove();
									}
								});
								refreshAcquisitionAndSalesActivity();
								sendCurrentOldLeadLL(_allEmails[0]);
							}
						}
					});
				}
			} else {
				alert("Please select only one person to whom you want to associate email.");
			}
		}
	} else {
		if(jQuery("#aquisitionTable").hasClass('show')){
			jQuery("#aquisitionTable tbody.main_active").find('div.sales-activity-notes-content').removeClass('active');
		}
		jQuery("#displayEmail").html('<iframe src="' + __baseUrl + "users/search_email/" + jQuery.trim(c) + '" scrolling="yes" width="100%" height="' + j + '">');
		emailLoadHeight();
	}    
}

function emailLoadHeight(){
	jQuery("#displayEmail iframe").off('load').on('load', function() {
		checkMyEmailsHeight();
		iframe = jQuery("#displayEmail iframe").get(0);
		iframewindow= iframe.contentWindow? iframe.contentWindow : iframe.contentDocument.defaultView;
		if(iframewindow!=undefined){
			if(typeof iframewindow.bigContent==="function"){
				iframewindow.bigContent();
			}
		}
	});
}

function callFromLandline(b,o) {
    _number = "";
	_ext = "";
	if(b!=""){
		b = b.replace(/\((.*)\)/, "$1");
	}
    if (jQuery("#user_mobile_number").length > 0) {
        _number = jQuery("#user_mobile_number").val()
    } else {
        if (window.parent.jQuery("#user_mobile_number").length > 0) {
            _number = window.parent.jQuery("#user_mobile_number").val()
        }
    }
	if (jQuery("#user_ext").length > 0) {
        _ext = jQuery("#user_ext").val()
    } else {
        if (window.parent.jQuery("#user_ext").length > 0) {
            _ext = window.parent.jQuery("#user_ext").val()
        }
    }
	if(typeof o=='object'){
		o.parent().parent().find('input[name="sales_person[]"]').prop('checked',true)
		_pid = o.parent().parent().attr('data-p')+',';
		_cid = o.parent().parent().attr('data-c')+',';
		_nameUser = o.parent().parent().find('td').eq(1).find('a').text()+" - "+o.parent().parent().find('input[name="sales_person[]"]:checked').attr('data-attr-c-name')+', ' ;		
		getCallEvent(_nameUser,_pid,_cid);
		jQuery("#callType").val(2);
		/*jQuery("#callType>option").each(function(){
			switch(parseInt(jQuery(this).val())){
				case 1:
					jQuery(this).prop('disabled',true);
				break;
				case 2:					
					jQuery(this).removeAttr('disabled');
					jQuery(this).prop('selected',true);
				break;
				case 37:
					jQuery(this).prop('disabled',true);
				break;
				case 207:
					jQuery(this).prop('disabled',true);
				break;
			}
		});*/
	} 
	b = decodeURIComponent(b);
	if(_number!=""){
		jQuery.ajax({
			url: __baseUrl+"users/calling/"+encodeURIComponent(b) + "/" + encodeURIComponent(_number)+'/'+encodeURIComponent(_ext),
			cache: false,
			dataType:'json'
		}).done(function(data,textStatus,xhr){
			if(data.uri!=""){
				jQuery("#calling_status_show").find('.modal-body').html('<p>Please wait..</p>');
				jQuery("#calling_status_show").modal('show');
				checkCallingStatus(data.uri);
			}
		});
	} else {
		webphonecall(b);
	}    
}

function checkCallingStatus(uri){
	jQuery.ajax({
		type:'POST',
        url: __baseUrl+"users/callingStatus/",
		data:{uri:uri},
        cache: false,
		dataType:'json'
    }).done(function(data,textStatus,xhr){
		if(data.callStatus!=""){
			_html = "<p>Call Status: "+data.callStatus+"<br/>Caller Status: "+data.callerStatus+"<br/>Callee Status: "+data.calleeStatus+"<br/></p>";
			jQuery("#calling_status_show").find('.modal-body').html(_html);
			if(data.callStatus=="InProgress"){
				setTimeout(function(){checkCallingStatus(uri)},2000);
			} else {
				jQuery("#calling_status_show").modal('hide');
			}			
		}
	});
}

function appendSlider(sliderID,title,ID) {
	var sliderContainer = jQuery("#slider_template");
	var getSliderContent = sliderContainer.html();
	var getDefaultWidth = sliderContainer.attr('data-default-width');
	var defaultClass = 'sb-right';
	var sliderDBID = 0;
	console.log("Default",getDefaultWidth);
	if(typeof ID != "undefined") {
		if(sliderList.length > 0) {
			sliderList.map(function(s){
				if(s.slider_name == ID) {
					getDefaultWidth = s.default_width;
					defaultClass = s.slider_open;
					sliderDBID = s.id;
					return false;
				}
			});
		}
	}
	var centerSlider = false;
	if(defaultClass == "sb-center") {
		defaultClass = "sb-left";
		centerSlider = true;
	}
	var contentObject = jQuery(getSliderContent).get(0);
	contentObject.setAttribute('id',sliderID);
	if(jQuery("body").find('.modal-backdrop').length == 0) {
		jQuery("body").append('<div class="modal-backdrop modal-backdrop-drive"></div>')
	}
	if(sliderDBID > 0) {
		title = title+ '<span class="mrg10L">('+sliderDBID+')</span>';
	}
	jQuery("body").append(contentObject.outerHTML);
	jQuery("#"+sliderID).removeClass('sb-left').removeClass('sb-right').addClass(defaultClass).addClass("is-open");
	jQuery("#"+sliderID).find('#'+getDefaultWidth).addClass('active');
	jQuery("#"+sliderID).find('.heading_title').html(title);
	jQuery("#"+sliderID).find('.slider_width_real').html(getDefaultWidth+'%');
	openSlidebar(jQuery("#"+sliderID));
	slidebarOpenCallback(jQuery("#"+sliderID));
	if(centerSlider === true) {
		setTimeout(function(){jQuery("#"+sliderID).find('.btn-center').trigger('click');},100);
	}
}

function myProfile() {
	var sliderID = "myprofile";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		appendSlider(sliderID,'My profile','Myprofile');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="profileFormIframe" src="' + __baseUrl + 'users/profile" width="100%" height="100px" scrolling="yes"></iframe>');
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
}

function changeIframeHeight(o) {
	var d = o.find('iframe'),
        e = jQuery(window).height() - 82;
		m = e - 30;
		if(o.find('.slimScrollDiv').length > 0) {
			o.find('.slimScrollDiv').css('height',e+'px');
		}
		o.css('height',e+'px');
	
	if(d.length > 0) {
		d.each(function() {
			var $this = jQuery(this);
			$this.height(m);
			var frameID = $this.attr('id');
			if(document.getElementById(frameID).contentWindow && document.getElementById(frameID).contentWindow.resizeDataTable) {
				document.getElementById(frameID).contentWindow.resizeDataTable(jQuery(window).height());
			}
		});
	}
}

function getAllLeadsPointing(ac, ea) {
    jQuery("#open_prefined_message").hasClass("is-open") ? checkModalFrontOrHide(jQuery("#open_prefined_message"), function() {
        closeSlideBarLeftSales()
    }) : ($("body").append('<div class="modal-backdrop modal-backdrop-drive"></div>'), jQuery("#open_prefined_message_list").html('<iframe id="predefineFormIframe" src="' + __baseUrl + 'leads/all_active_system/' + ac + '/' + ea + '" width="100%" height="100px" scrolling="yes"></iframe>'),openSlidebar(jQuery("#open_prefined_message")), slidebarOpenCallback(jQuery("#open_prefined_message")), jQuery("#open_prefined_message").addClass("is-open"), open_prefined_listResize())
}


/** Check height of #myEmailsRetrieve block */
function checkMyEmailsHeightStateBig() {
    var isShowTaskList = $('#task_list').is(':visible'),
        isShowMyTaskList = $('#my_c_task_list').is(':visible'),
        isShowContentPart = $('#contentPart').is(':visible');

    return !isShowTaskList && !isShowMyTaskList && !isShowContentPart;
}
function checkMyEmailsHeight(isShowContentPart) {
 	if(typeof countActiveMenus==="function"){
		countActiveMenus();
	} else if(typeof window.parent.countActiveMenus==="function"){
		window.parent.countActiveMenus();
	}
	
}

function removeDTResizeEvents() {
    var windowResizeEvents = $._data( $(window)[0], "events" ).resize;
    for(var i = 0; i < windowResizeEvents.length; i += 1) {
        if(windowResizeEvents[i].namespace === 'DT-all_type_list' || windowResizeEvents[i].namespace === 'DTFC') {
            windowResizeEvents[i].handler = function(){};
        }
    }
}

function moveEmailToTrash(obj){
	jQuery('#displayEmail').html('');
	parent = obj.parent().parent().parent().parent().parent();
	parent.css('display','none');
	_active=jQuery.trim(jQuery(".emails-group-container").find("a.active").html());
	jQuery.ajax({type:"POST",url:__baseUrl+"dashboard/moveThreadDiff",data:{thread:parent.attr("data-id"),label:'TRASH',active:_active},cache:false,success:function(e){if(e>0){_objNext = parent.next();parent.remove();jQuery('#displayEmail').empty();_objNext.addClass('message-active');findThread(_objNext.data('id'),_objNext);}else{parent.css("display","");}}});
}

function openLeadInviteesList(){
	var sliderID = "open_invitees_list";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		appendSlider(sliderID,'Invitees List','InviteesList');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="inviteesListIframe" src="'+__baseUrl+'opportunity/invitees_list/'+leadGlobal+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
}

function openCompanyEdit(companyID){
	if(typeof companyID=="undefined"){
		companyID = 0;
	}	
	if(jQuery("#open_company_add").hasClass('is-open')){
		jQuery("#open_company_add").find('iframe').attr("src",__baseUrl+'opportunity/add_company/'+companyID);
	} else {
		var sliderID = "open_company_add";
		appendSlider(sliderID,'Add Company','AddCompanies');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="companyIframe" src="' + __baseUrl + 'opportunity/add_company/'+companyID+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}	
}

function openContactEditForm(contactID){
	if(typeof contactID=="undefined"){
		contactID = 0;
	}		
	if(jQuery("#open_contact_add").hasClass('is-open')){
		jQuery("#open_contact_add").find('iframe').attr("src",__baseUrl+'opportunity/add_contact/'+contactID);
	} else {
		w = jQuery(window).width();
		h = jQuery(window).height();
		h = h-80;
		w = w*50/100;
		/*wD = w*85/100;*/
		var sliderID = "open_contact_add";
		appendSlider(sliderID,'Add Contact','AddContact');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="contactIframe" src="' + __baseUrl + 'opportunity/add_contact/'+contactID+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}/*$sideBar.find("#btnManageCategories").attr("onclick","window.parent.openCompanyThroughContact("+contactID+")");*/
	}	
}
function closeSlideBarContact(){
	closeSlidebarRemove(jQuery("#open_contact_add").find('.close_sidebar'));
}
function closeSlideBarCompany(){
	closeSlidebarRemove(jQuery("#open_company_add").find('.close_sidebar'));
}

function openLeadInvitees(){
	var sliderID = "open_invitees_text";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {
		appendSlider(sliderID,'Invitees','Invitees');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html(jQuery("#open_invitees_text_template").html());
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
}
function closeSlideBarInviteesList(){
	$sideBar = jQuery("#open_invitees_list");
	$sideBar.removeClass('sb-active').removeClass('is-open').css('left',$sideBar.data('left')).find('.pad0A').html('');
}
function closeSlideBarInviteesText(){
	closeSlidebar(jQuery("#open_invitees_text"));
}

function openLeadDocketClaimchart(){
	if(leadGlobal>0){
		var sliderID = "open_lead_docket_claimchart";
		if(jQuery("#"+sliderID).hasClass('is-open')) {
			jQuery("#btnClaimcharts").removeClass("menu-active");
			checkModalFrontOrHide(jQuery("#"+sliderID), function() {
				closeSlideBar(jQuery("#"+sliderID))
			});
		} else {
			jQuery("#btnClaimcharts").addClass("menu-active");
			appendSlider(sliderID,'Claimchart','Claimchart');
			if(jQuery("#"+sliderID).length > 0) {
				data={l:leadGlobal};
				call(__baseUrl+'opportunity/find_order_name',"POST",data,showOrderName,"html");
				jQuery("#"+sliderID).find('.slider_container').html(jQuery('#claimchart_panel').html());
				openSlidebar(jQuery("#"+sliderID));
				slidebarOpenCallback(jQuery("#"+sliderID));
				jQuery("#"+sliderID).addClass("is-open");				
				jQuery("#"+sliderID).find('.close_sidebar').removeAttr('onclick').attr('onclick','closeSlidebarRemove(jQuery(this),closeClaimchart)');
				jQuery("#"+sliderID).find("#open_synpat_claimcharts,#open_synpat_claimcharts_manage,#claimchart_box").addClass('hide').removeClass("show");
				jQuery("#"+sliderID).find("#claimchartClaimchart,#claimchartManager,#claimchartOrder").removeClass('active');
				boxClaimChartOrder();
			}
		}
	} else {
		alert("Please select lead first.");
	}	
}
function closeClaimchart() {
	jQuery("#btnClaimcharts").removeClass("menu-active");
}
function showOrderName(data, textStatus, xhr){
	var $slider = jQuery("#open_lead_docket_claimchart");
	if(data!=""){		
		$slider.find("#claimchart_order_name").val(data);		
		jQuery('#'+_mainBtnParentElement).find("#btnLinkToClaimcharts").attr('data-href','https://synpat.com/experts/?tap='+data);
		$slider.find("#open_synpat_claimcharts_manage").html('<iframe src="https://experts.synpat.com/manager" width="100%" style="height:100px;" id="claimchart_manager" frameborder="0" scrolling="yes"></iframe>');
		_claimHref = "https://experts.synpat.com/order?rod="+data;
		$slider.find("#open_synpat_claimcharts").html('<iframe src="'+_claimHref+'" id="claimchart_order" width="100%"  style="height:100px;" frameborder="0" scrolling="yes"></iframe>');
	} else {
		jQuery('#'+_mainBtnParentElement).find("#btnLinkToClaimcharts").removeAttr('data-href');
		_claimHref = "https://experts.synpat.com/order?smp="+leadGlobal;
		console.log('ClaimHref',_claimHref);
		$slider.find("#open_synpat_claimcharts").html('<iframe src="'+_claimHref+'" id="claimchart_order"  width="100%" style="height:100px;" frameborder="0" scrolling="yes"></iframe>');
		$slider.find("#open_synpat_claimcharts_manage").html('<iframe src="https://experts.synpat.com/manager" width="100%" style="height:100px;"  id="claimchart_manager" frameborder="0" scrolling="yes"></iframe>');
	}	
	changeIframeHeight($slider);
}

function boxClaimChart(){
	var $slider = jQuery("#open_lead_docket_claimchart");
	$slider.find("#open_synpat_claimcharts,#open_synpat_claimcharts_manage").addClass('hide').removeClass("show");
	$slider.find("#claimchart_box").addClass('show').removeClass("hide");
	$slider.find("#claimchartManager,#claimchartOrder").removeClass('active');
	$slider.find("#claimchartClaimchart").addClass('active');
}
function boxClaimChartOrder(){
	var $slider = jQuery("#open_lead_docket_claimchart");
	$slider.find("#claimchart_box,#open_synpat_claimcharts_manage").addClass('hide').removeClass("show");
	$slider.find("#open_synpat_claimcharts").addClass('show').removeClass("hide");
	$slider.find("#claimchartClaimchart,#claimchartManager").removeClass('active');
	$slider.find("#claimchartOrder").addClass('active');
	changeIframeHeight($slider);
}
function boxClaimChartManage(){
	var $slider = jQuery("#open_lead_docket_claimchart");
	$slider.find("#open_synpat_claimcharts,#claimchart_box").addClass('hide').removeClass("show");
	$slider.find("#open_synpat_claimcharts_manage").addClass('show').removeClass("hide");
	$slider.find("#claimchartClaimchart,#claimchartOrder").removeClass('active');
	$slider.find("#claimchartManager").addClass('active');
	changeIframeHeight($slider);
}

function saveClaimChartOrderName(){
	var $slider = jQuery("#open_lead_docket_claimchart");
	if($slider.find("#claimchart_order_name").val()!="" && leadGlobal>0){
		$slider.find("#show_retrival_code").html('Please wait while we retreive embed code.');
		data={l:leadGlobal,o:$slider.find("#claimchart_order_name").val()};
		call(__baseUrl+'opportunity/retrieve_embed_code_from_claimcharts',"POST",data,showEmbedCodeClaimcharts,"json");
	} else {
		alert("Please try after sometime.");
	}
}
window.showEmbedCodeClaimcharts = function(data, textStatus, xhr){
	var $slider = jQuery("#open_lead_docket_claimchart");
	if(data.embed_code!="" && data.work_code!=""){		
		$slider.find("#show_retrival_code").css('margin-top','5px').html('ClaimChart embed code: <textarea style="width:100%;height:117px;"><iframe src="https://claimcharts.info/index.php/component/survey/?tmpl=component&task=customer.generateClientRequest&client_id='+data.embed_code+'&pr=2" width="100%" height="680" frameborder="0" scrolling="yes"></iframe></textarea>');
		jQuery('#'+_mainBtnParentElement).find("#btnLinkToClaimcharts").attr('data-href','https://claimcharts.info/?'+data.work_code);
	} else {
		$slider.find("#show_retrival_code").html('');
		jQuery('#'+_mainBtnParentElement).find("#btnLinkToClaimcharts").removeAttr('data-href');
		alert("Please try after sometime");
	}
}
function openLeadDocketDocuments(){
	var sliderID = "open_lead_docket_document";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {		
		appendSlider(sliderID,'Documents','Documents');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('Please wait...');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
	data={l:leadGlobal};
	call(__baseUrl+'opportunity/find_docket_documents',"POST",data,showDocketDocuments,"json");
	
}
function openLeadStoreIntro(){
	var sliderID = "open_lead_docket_document";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {		
		appendSlider(sliderID,'Store Intro','StoreIntro');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('Please wait...');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
	data={l:leadGlobal};
	call(__baseUrl+'opportunity/store_intro',"POST",data,showStoreIntro,"json");
}
function openLeadDocketAccordion(){
	var sliderID = "open_lead_docket_document";
	if(jQuery("#"+sliderID).hasClass('is-open')) {
		checkModalFrontOrHide(jQuery("#"+sliderID), function() {
			closeSlideBar(jQuery("#"+sliderID))
		});
	} else {		
		appendSlider(sliderID,'Docket Accordion','DocketAccordion');
		if(jQuery("#"+sliderID).length > 0) {
			jQuery("#"+sliderID).find('.slider_container').html('<iframe id="docketAccordionIframe" src="'+__baseUrl+'opportunity/docket_accordion/'+leadGlobal+'" width="100%" height="100px" scrolling="yes"></iframe>');
			openSlidebar(jQuery("#"+sliderID));
			slidebarOpenCallback(jQuery("#"+sliderID));
			jQuery("#"+sliderID).addClass("is-open");
			changeIframeHeight(jQuery("#"+sliderID));
		}
	}
}
function inputOnDrop(){
	jQuery('.inputOnDrop').each(function(){
		jQuery(this).droppable({hoverClass:"drop-hover",drop:function(a,b){if(b.draggable.parent().hasClass('todo-box-1') && b.draggable.find('a').length>0){jQuery(this).val(b.draggable.find('a').attr('data-href'));}}});
	})
}

function countIntroWords(){
	jQuery("#store_small_desc").on("change keyup paste",function(d){
		var g=$.trim($("#store_small_desc").val()),f=g.replace(/\s+/gi," ").split(" ").length;
		if(f==1 && $.trim($("#store_small_desc").val())==""){
			f=0;
		}
		jQuery("#remain_character").html(f);	
	});
}


window.showStoreIntro = function(data,textStatus,xhr){	
	jQuery("#open_lead_docket_document").find('.slider_container').html('');
	jQuery("#open_lead_docket_document").find('.slider_container').append('<div class="mrg20T" style="padding-right: 25px;"><label for="marketProspects" class="control-label">Only 54 characters allowed.  <span id="remain_character">0</span></label><textarea class="form-control input-string input-store" style="height:160px;" name="acquisition[store]" id="store_small_desc">'+data.store_intro+'</textarea></div>');
	jQuery("#open_lead_docket_document").find('.slider_container').append('<p class="mrg10T"><a href="javascript://" onclick="saveLeadStoreIntro()" class="btn btn-primary">Save</a>');countIntroWords();jQuery("#open_lead_docket_document").find("#store_small_desc").trigger("change");
}
window.showDocketDocuments = function(data,textStatus,xhr){
	jQuery("#open_lead_docket_document").find('.slider_container').html('');
	_select='<input id="otherPPA" name="other[ppa]" value="'+data.ppa+'" class="form-control inputOnDrop" />';
	jQuery("#open_lead_docket_document").find('.slider_container').append('<p>PPA:<br/>'+_select+'</p>');
	_select='<input id="otherPLA" name="other[pla]" value="'+data.pla+'" class="form-control inputOnDrop" />';
	jQuery("#open_lead_docket_document").find('.slider_container').append('<p>PLA:<br/>'+_select+'</p>');
	_select='<input id="otherSla" name="other[sla]" value="'+data.sla+'" class="form-control inputOnDrop" />';
	jQuery("#open_lead_docket_document").find('.slider_container').append('<p>SLA:<br/>'+_select+'</p>');
	_select='<input id="otherRTP" name="other[rtp]" value="'+data.rtp+'" class="form-control inputOnDrop" />';
	jQuery("#open_lead_docket_document").find('.slider_container').append('<p>RTP:<br/>'+_select+'</p>');
	_select='<input id="otherPPP" name="other[ppp]" value="'+data.ppp+'" class="form-control inputOnDrop" />';
	jQuery("#open_lead_docket_document").find('.slider_container').append('<p>PPP:<br/>'+_select+'</p>');
	_select='<input id="otherRoyalty" name="other[royalty]" value="'+data.royalty+'" class="form-control inputOnDrop" />';
	jQuery("#open_lead_docket_document").find('.slider_container').append('<p>Royalty:<br/>'+_select+'</p>');
	jQuery("#open_lead_docket_document").find('.slider_container').append('<p class="mrg10T"><a href="javascript://" onclick="saveLeadDocketDocuments()" class="btn btn-primary">Save</a>');
	
	inputOnDrop();
	if(data.drive_files.length>0){		
		/*_select='<select id="otherPLA" name="other[pla]" class="form-control">';
		_select+='<option></option>';
		for(i=0;i<data.drive_files.length;i++){
			_selected='';
			if(data.drive_files[i].alternateLink==data.pla){
				_selected = 'SELECTED="SELECTED"';
			}
			_select+='<option '+_selected+' value="'+data.drive_files[i].alternateLink+'">'+data.drive_files[i].title+'</option>';
		}
		_select+='<select>';*/		
	}
}

function saveLeadStoreIntro(){
	_form = jQuery("#open_lead_docket_document").find('.slider_container').find('textarea.input-store').serializeArray();
	data = _form;
	call(__baseUrl+'opportunity/store_intro_save/'+leadGlobal,"POST",data,saveDocketDocument,"html");
}

function saveLeadDocketDocuments(){
	_form = jQuery("#open_lead_docket_document").find('.slider_container').find('input.inputOnDrop').serializeArray();
	data = _form;
	call(__baseUrl+'opportunity/find_docket_documents_save/'+leadGlobal,"POST",data,saveDocketDocument,"html");
}
function saveDocketDocument(data,textStatus,xhr){
	if(data>0){
		alert("Record updated!");
	} else {
		alert("Please try after sometime.");
	}
}