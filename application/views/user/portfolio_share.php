<link href="https://backyard.synpat.com/public/icons/shop.css?v=579" media="screen" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css" crossorigin="anonymous"/>
<style type="text/css">
	html {
    color: rgb(51, 51, 51);
    font: 0.875em/1.5em "Proxima Nova","Helvetica Neue",Arial,sans-serif;
}
	.synpat-store-content-list-item{width:552px;/*padding:20px 15px !important;*/padding:0 !important;margin:0 !important;}
	.synpat-store-content-list-item:hover{box-shadow:unset;transition:unset;-moz-transition:unset;-webkit-transition:unset;-o-transition:unset;}
	.synpat-store-content-list-item-left-second{float:left !important;width:100% !important;}
	.synpat-store-content-list-item-left-first{width:100%;padding:0 !important;float:left !important;}
	.synpat-store-content-list-item-left,.synpat-store-content-list-item-right,.synpat-store-content-list-item{border:0px !important;}
	.synpat-store-content-list-item-right{float:right;padding:0 0 0 20px !important;width:46% !important;}
	.synpat-store-content-list-item-left{float:left;padding-left:10px;width:54% !important;}
	.synpat-store-content-list-item-title{margin-bottom:14px !important;}
	.synpat-store-content-list-item-price-key,.synpat-store-content-list-item-price-value{font-weight:bold;}
	.synpat-store-social-links a.primary-button{background-color: #C20000;cursor: pointer;font-family: "Trade Gothic Condensed","Helvetica Neue",Arial,sans-serif;text-transform: uppercase;color: #FFF;line-height: 2.28571em;border-radius: 0.21429em;padding: 0.21429em 1.42857em 4px;font-weight: bold;font-size: 18px;margin-bottom:0px !important;margin-top:40px !important;}
	#portfolios_list{width: 575px;float: left;padding-top:4px;}
	.synpat-store-content-list-item-title{font-size:26px !important;}
	.synpat-store-galery,.synpat-store-galery-list{width:440px!important;height:124px !important;}
	.synpat-store-galery-list{top:0px !important;border:0px !important;}
	.synpat-store-galery-list .slides{width:655px!important;height:124px !important;}
	.folioBoxImg{padding:0px !important;width:220px!important;height:124px !important;}
	.synpat-store-galery-list img{left:54% !important;transform:translate(-50%, -51.3%);-webkit-transform:translate(-50%, -51.3%);-ms-transform:translate(-50%, -51.3%);}
	a.cmoverlay{width:209px;height:121px; !important;}
	.synpat-store-content-list-item-title {text-align:center;font-size:23px !important;}
	.xsrs{margin: 0px auto;list-style: disc !important;padding: 5px !important;width:420px;}
	.xsrs li{font-size:21px;font-family:"Trade Gothic Condensed","Helvetica Neue",Arial,sans-serif;font-weight:bold;}
	.mrg0{margin:0 !important;}
	.mrg11T{margin-top:11px !important;}
	</style>
<!-- Shop Component -->
<div class="component" id="shop_component"></div>
<!-- End Shop Component -->
<script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.0/handlebars.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script id="shop-template" type="text/x-handlebars-template">
	<div class="main-content application">
		<div class="content">
			<div class="interior-content">				
				<div class="synpat-store clearfix">
					<div class="synpat-store-content">
						<ul class="synpat-store-content-list" id="portfolios_list">
							<li class="aCenter"></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>	
</script>
<!-- End Shop Component Template -->
<script>
Handlebars.registerHelper("nl2br", function(data) {
		console.log("Data",data);
		const breakTag = '<br>';    
		return (data + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
	});
	Handlebars.registerHelper("xif", function (expression, options) {
		return Handlebars.helpers["x"].apply(this, [expression, options]) ? options.fn(this) : options.inverse(this);
	});
	Handlebars.registerHelper('ifCond', function(v1, v2, options) {
		if(v1 === true || v2 === true) {
			return options.fn(this);
		}
		return options.inverse(this);
	});
	Handlebars.registerHelper("math", function(value, options){
		return parseInt(value) + 1;
	});
const baseUrl = "https://api.synpat.com/v1/";	
const templateUrl = "https://synpat.com/catalog/";
const templateUrl1 = "https://backyard.synpat.com/";
const portfolioToken = '<?php echo $portfolioToken;?>';
const tImages = '<?php echo $t;?>';
let cancelT = [],jssorVar = [];
let tokenStr, serialNumber,portfolioData,patentListData,formState;
function setLoggedToken(tokenV) {
	localStorage.setItem("synpat_login_token", tokenV);
}

function getLoggedTokenValue() {
	return localStorage.getItem("synpat_login_token");
}

function getLoggedInToken() {
	return {headers: {"Authorization" : getLoggedTokenValue()}};
}
function callShopComponent(t) {
	document.title = "SynPat Catalog";
	loadShopTemplate()
	.then(() => {
		if(typeof t == "undefined") {
			generateToken(getCategoryList,1);		
		} else {
			getCategoryList(1,0);
		}			
	});	
}
function generateToken(callBack,t,ID) {
	var getTokenFromLocal = localStorage.getItem("synpat_shop");
	if(getTokenFromLocal == "" || getTokenFromLocal == null || typeof getTokenFromLocal == "undefined"){
		const params = {
			key:'1ee9247397c05d94cbf0e283b95460a1b90ddfd4'
		}
		const $params = $.param(params);
		axios.post(baseUrl+'auth',$params)
		.then(function(response) {
			if(response.data.message == "Authenticated!") {
				tokenStr = response.data.data.token;
				localStorage.setItem("synpat_shop", tokenStr);
				if(typeof callBack === 'function') {
					callBack.apply(this,[t,ID]);
				}				
			}			
		})
		.catch(function (error) {
			console.log("Error:"+error);
		});
	} else {
		tokenStr = getTokenFromLocal;
		if(typeof callBack === 'function') {
			callBack.apply(this,[t,ID]);
		}
	}		
}
function getTokenHeader(){
	if(cancelT.length > 0) {
		try{
			cancelT.map((c) => {
				if(typeof c === "function") {
					c();
				}
			});
		}catch(e){
			cancelT = [];
			console.log("Invalid cancel token:"+e);
		}			
	}
	if(typeof tokenStr == "undefined" || tokenStr == null || tokenStr == "undefined") {
		generateToken(getTokenHeader);
	} 
	return  {headers: {"Authorization" : tokenStr}};
}
	
	let getCategoryList = function(t,parentID,c) {
		// Get the list of categories and t defined call parent categories or sub categories from parent ID.
		let apiURL = baseUrl+'category';
		if(t == 1 && parentID > 0) {
			apiURL = baseUrl+'category/'+parentID;
		}
		axios.get(apiURL,getTokenHeader())
		.then(function(response) {
			if(response.data.data.length>0) {
				/* Category list */
				
				let invitationNumber = portfolioToken;
				getPortfolioList(0,0,invitationNumber);			
			} else if(typeof response.data.error_code!="undefined") {
				console.log(response.data.message);
			}
		})
		.catch(function (error) {
			console.log("Error:"+error);
		});
	};
function getPortfolioList(t,category,invitationNumber) {
		// sending request for the portfolio and t defines whether we have to bring real portfolio or demo portfolio.
		let apiURL = baseUrl+'portfolio/'+category;
		
		if(typeof invitationNumber != "undefined") {
			apiURL += '/'+invitationNumber;
		}
		
		if(t == 1) {
			apiURL = baseUrl+'demo_portfolio';
		}
		let token = getTokenHeader();
		if((invitationNumber == "" || invitationNumber == null || typeof invitationNumber == "undefined") && getLoggedTokenValue == ""){
			alert("Please login first");
		} else if(invitationNumber != "") {
			token = getTokenHeader();
		} else if(getLoggedTokenValue != "" && validateLToken()) {
			token = getLoggedInToken();
		}
		axios.get(apiURL,token)
		.then(function(response) {
			if(typeof response.data != "" && typeof response.data.data != "undefined" && typeof response.data.data.portfolio_list != "undefined"){
				loadPortfolioList(response.data.data.portfolio_list);
			} 			
		})
		.catch(function (error) {
			console.log("Error:"+error);
		});
	}
function callTemplate(template) {	
	let templateFile = templateUrl1+template+'.html';
	let promise = new Promise((resolve,reject) => {
		axios.get(templateFile)
		.then(function(response) {
			if(response.data != "") {
				resolve(response.data);
			} else {
				resolve(response);
			}
		})	
		.catch((error) => {
			reject(error);
		})
		.then(function () {
			reject("Error loading file");
		});
	});
	return promise;
}	
	function loadPortfolioList(portfolioList){
		//let portfolioTemplate = document.getElementById("portfolio-template").innerHTML;
		const portfolioTemplate = callTemplate("portfolio_list");
		portfolioTemplate
		.then((response) => {
			let handlerBarTemplate = Handlebars.compile(response);
			let userLoggedIn = false;
			let whishlist = false;
			const tokenV = getLoggedTokenValue();
			if(tokenV != "" && tokenV != null) {
				userLoggedIn = true;
				whishlist = true;
			}
			let dBt = false;
			if($('#shop_component').hasClass('comp_active')){
				dBt = false;
			} else if($('#customer_component').hasClass('comp_active')){
				dBt = true;
			}
			if(portfolioList.length > 0){
				const invt = portfolioList[0];
				if(tImages == 1){
					let linkedinImages =  invt.show_linkedin_images;
					let newLinkedinImages = [];
					if(linkedinImages !=""){
						linkedinImages = linkedinImages.split(",");
						linkedinImages.forEach(function(l){
							newLinkedinImages.push({img:true,link:l,name:""})
						});
					}
					invt.images = newLinkedinImages;
				}
				portfolioList = [];
				portfolioList.push(invt);
			}
			const portfolioHTML =  handlerBarTemplate({zoom:dBt,whishlist:whishlist,logged:false,list:portfolioList});
			let appendElement = document.getElementById('portfolios_list');
			if(portfolioList.length>0){
				if(portfolioList[0].invitation === true) {
					const sidebarList = $("#sidebar_list");
					if(sidebarList.find('li.synpat-store-sidebar-list-item.is-active').length > 0) {
						const findLi = sidebarList.find('li.synpat-store-sidebar-list-item.is-active');
						findLi.find('ul').hide();
						findLi.removeClass('is-opened').removeClass('is-active');
					}
				}
				appendElement.innerHTML = portfolioHTML;
				jssorVar = [];
				callPorfoliosDomFiles();
			}
		});
	}
function callPorfoliosDomFiles() {
	if(typeof String.prototype.stripSlashes != "function") {
		String.prototype.stripSlashes = function(){
			return this.replace(new RegExp("\\\\", "g"), "");
		}
	}		
	loadJsFiles("lightbox2","https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js");
	/*JSSOR Slider*/
	loadJsFiles("jssorjs","https://cdnjs.cloudflare.com/ajax/libs/jssor-slider/27.5.0/jssor.slider.min.js",loadShopCarousel);
}
function loadShopCarousel() {
	/*JSSOR Slider*/
	setTimeout(() => {
		if(typeof $JssorSlider$ == "function") {	
			const options = { 
				$AutoPlay: true,
				$AutoPlayInterval: 775,
				$SlideWidth: 220,
				$SlideHeight: 124,
				$SlideSpacing: 0, 
				$DisplayPieces: 2,
				$PauseOnHover: 1, 
				$Loop: 1
			};
			$('.synpat-store-content-list-item').each(function(){
				const $this = $(this);
				const ID = $this.find('.synpat-store-galery-list').attr("data-tab");
				jssorVar['jssor_sliderb'+ID]  = new $JssorSlider$("slider_inv_"+ID+"_container", options);
			});
		} else {
			loadShopCarousel();
		}
	},500);
}
let loadShopTemplate = function() {
	let promise = new Promise((resolve, reject) => {
		showShopTemplate();
		/*loadCssFiles("shopcss",templateUrl+"assets/css/shop.css?v=579",showShopTemplate);*/
		resolve("Shop CSS");
	});
	return promise;
}
let loadCssFiles = function(id,file,callback) {
	let headTag = document.getElementsByTagName("head");
	if(headTag[0].querySelector("#"+id) == null) {
		let fileCSS = document.createElement('link');
			fileCSS.rel = "stylesheet";
			fileCSS.setAttribute("id",id);
			fileCSS.href = file;
		if (typeof fileCSS != "undefined") {
			headTag[0].appendChild(fileCSS);
			fileCSS.addEventListener("load", function() {
				if(typeof callback == "function") {
					callback();
				}
			});
		}
	} else {
		if(typeof callback == "function") {
			callback();
		}
	}
}
let loadJsFiles = function(id,file,callback) {
	let headTag = document.getElementsByTagName("head");
	if(headTag[0].querySelector("#"+id) == null) {
		let fileJS = document.createElement('script');
			fileJS.setAttribute("type","text/javascript");
			fileJS.setAttribute("id",id);
			fileJS.setAttribute("src", file);
		if (typeof fileJS != "undefined") {
			headTag[0].appendChild(fileJS);
			if(typeof callback == "function") {
				callback();
			}
		}
	} else {
		if(typeof callback == "function") {
			callback();
		}
	}		
}
function showShopTemplate() {
	/*console.log("Shop CSS load First");*/
	let promise = new Promise((resolve, reject) => {
		const shopTemplate = document.getElementById("shop-template").innerHTML;
		let handlerBarTemplate = Handlebars.compile(shopTemplate);
		const shopHTML =  handlerBarTemplate({login:'',shop_menu:'',visitor:''});
		const shopElement = document.getElementById('shop_component');
		shopElement.innerHTML = shopHTML;
		shopElement.classList.add("comp_active");
		resolve("Shop template load");
	});
	return promise;
}
callShopComponent(1);
</script>