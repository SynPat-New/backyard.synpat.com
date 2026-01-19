<html>
<head>
<title>Comparables</title>
<link href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" rel="stylesheet" />
<link href="https://backyard.synpat.com/public/elements/buttons.css" rel="stylesheet" />
<link href="https://backyard.synpat.com/public/helpers/colors.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<script src="https://storage.googleapis.com/static.synpat.com/store/js/jquery-1.10.2.min.js"></script>
<style>
body{font-size:13px;font-family:'Arial';}
.container{margin: 100px auto; width:1200px;}
#progress-wrp {
  border: 1px solid #0099CC;
  padding: 1px;
  position: relative;
  height: 15px;
  border-radius: 3px;
  margin: 10px;
  text-align: left;
  background: #fff;
  box-shadow: inset 1px 3px 6px rgba(0, 0, 0, 0.12);
}
#progress-wrp .progress-bar {
  height: 100%;
  border-radius: 3px;
  background-color: #BD202F;
  width: 0;
  box-shadow: inset 1px 1px 10px rgba(0, 0, 0, 0.11);
}
#progress-wrp .status {
  top: -3px;
  left: 50%;
  position: absolute;
  display: inline-block;
  color: #fff;
}
input[type="text"]{
	padding:5px;float:left;width:85%;border:1px solid #efefef;font-size:13px;font-family:'Arial'
}
.handsontable .htCheckboxRendererInput{margin:5px 3px 3px 4px;}
.handsontable .htDimmed,.handsontable td, .handsontable th{color:#2d2d2d !important;}
.handsontable td{font-size:14px;}
#container{height:70px;overflow:auto;width:100%;}
td.placeholder{color:#b5b5b5 !important;}
table.htCore tbody tr td:last-child{text-align:center !important;}
</style>
</head>
<body>
<div style="float:left;width:100%;margin-bottom:10px;">
	<form id="frmComparables">
		<div class="form-group">
			<div  style="float:left;width:280px;"><a href="' + __baseUrl + 'Outsource/comparables" target="_blank" class="btn">Standalone Url</a> <a href='https://www.google.com/search?lr=&hl=en&biw=1200&bih=641&tbs=cdr%3A1%2Ccd_min%3A2000%2Ccd_max%3A2019&ei=gCw4Xc2WNo7F0PEP2-2r2A0&q=whereas+patent+%22license+agreement%22+-FDA+-Pharma+site%3Asec.gov+%22royalty%22+-%22royalty+free%22&oq=whereas+patent+%22license+agreement%22+-FDA+-Pharma+site%3Asec.gov+%22royalty%22+-%22royalty+free%22&gs_l=psy-ab.3...24247.59842..61825...1.0..0.84.544.8......0....1j2..gws-wiz.....10..35i39.mjMIxCPmqPQ&ved=0ahUKEwjN1saops3jAhWOIjQIHdv2CtsQ4dUDCAo&uact=5' target='_blank' class="btn">Recommended query</a></div>
			<div style="float:left;width:350px;">
				<input type="text" placeholder="File Url" name="file_url" id="file_url"/> <a style='margin-left:5px;' onclick="uploadFileThroughUrl();" href="javascript://"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width:20px;" class="svg-inline--fa fa-upload fa-w-16 fa-2x"><path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z" class=""></path></svg></a>
			</div>
			<div  style="float:left;width:50px;text-align:center;padding-top:5px;">OR</div>
			<div style="float:left;width:150px;padding-top:5px;">
				<input type="file" id="upload_new_document" name='upload_new_document' value='Upload document' style='' onchange="uploadDocument(jQuery(this))"/>
			</div>
			<div style='float:left;width:150px;display:none;' id="progressbar">
				<div id="progress-wrp">
					<div class="progress-bar"></div>
					<div class="status">0%</div>
				</div>
			</div>
			<button id="btnSave" type="button" class="btn btn-info" style='margin-bottom:10px;float:right;'>Save</button>
		</div>
	</form>
</div>
<div id="container"><div id='comparable_table' class="hot handsontable htRowHeaders htColumnHeaders" ></div></div>
<iframe src="about:blank" style="width:100%;height:500px;display:none;" border="0" id="frameAgreemeReview"></iframe>
<script>
function uploadDocument($this){
	jQuery("#progressbar").show();
	var file = $this[0].files[0];
	var upload = new Upload(file);
	upload.doUpload();
}
var Upload = function (file) {
	this.file = file;
};

Upload.prototype.getType = function() {
	return this.file.type;
};
Upload.prototype.getSize = function() {
	return this.file.size;
};
Upload.prototype.getName = function() {
	return this.file.name;
};
Upload.prototype.doUpload = function () {
	var that = this;
	var formData = new FormData();

	// add assoc key values, this will be posts values
	formData.append("file", this.file, this.getName());
	jQuery.ajax({
		type: "POST",
		url:'https://backyard.synpat.com/Outsource/upload_document/',
		xhr: function () {
			var myXhr = jQuery.ajaxSettings.xhr();
			if (myXhr.upload) {
				myXhr.upload.addEventListener('progress', that.progressHandling, false);
			}
			return myXhr;
		},
		async: true,
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		timeout: 60000
	}).done(function(d){
		var d = JSON.parse(d);
		jQuery("#progressbar").hide();
		jQuery("#upload_new_document").val('');
		if(d.file_url != ""){
			jQuery("#frameAgreemeReview").show().attr("src",d.file_url);
		} else {
			alert(d.message);
			jQuery("#frameAgreemeReview").hide().attr("src","about:blank");
		}
		//resetForm();
	});
};

Upload.prototype.progressHandling = function (event) {
	var percent = 0;
	var position = event.loaded || event.position;
	var total = event.total;
	var progress_bar_id = "#progress-wrp";
	if (event.lengthComputable) {
		percent = Math.ceil(position / total * 100);
	}
	// update progressbars classes so it fits your code
	$(progress_bar_id + " .progress-bar").css("width", +percent + "%");
	$(progress_bar_id + " .status").text(percent + "%");
};
var _licenseKey = '139eb-e1f6b-37930-9440d-a1020';
var hot2,table_comparables = document.getElementById('comparable_table');
var _confirmedRequestJSON = [{agreement_date:'',file_name:'',patent_number:'',payment_terms:'',licensor:'',licensee:'',masked:'no'}];
var columnPlaceholder = {0:'mm/dd/yyyy',3:'2% of Net Sales',4:'6 words max'};
hot2 = new Handsontable(table_comparables, {
	data: _confirmedRequestJSON,
	licenseKey:_licenseKey,
	rowHeaders: false,
	wordWrap:true,
	autoRowSize: true,
	preventOverflow: 'horizontal',
	minSpareRows: 0,
	minSpareCols: 0,
	minCols: 7,
	maxCols: 7,
	maxRows: _confirmedRequestJSON.length,
	fillHandle: false,
	stretchH:"all",
	colHeaders:['Date','Licensors','Licensees','Payment Terms','Technologies / Products','Patent Numbers (2 Max)','Masked'],
	contextMenu: false,
	filters: false,
	columnSorting:true,
	columns:[
		{data:'agreement_date',readOnly:false,renderer:customRenderPlaceholder},
		{data:'licensor',readOnly:false},
		{data:'licensee',readOnly:false},
		{data:'payment_terms',readOnly:false,renderer:customRenderPlaceholder},
		{data:'file_name',readOnly:false,renderer:customRenderPlaceholder},
		{data:'patent_number',readOnly:false},
		{data:'masked', type: 'checkbox', checkedTemplate: 'yes', uncheckedTemplate: 'no'},
	]
});	
function customRenderPlaceholder(instance, td, row, col, prop, value, cellProperties){
	if(value == ""){
		td.innerHTML = columnPlaceholder[col];
		td.className = "placeholder"
	}	else {
		td.innerHTML = value;
	}
	return td;
}
function uploadFileThroughUrl(){
	console.log("Clicked");
	if(jQuery("#file_url").val() != "") {
		console.log("Clicked1");
		jQuery.ajax({
			url:'https://backyard.synpat.com/Outsource/upload_file_url',
			type:'POST',
			data:{url:jQuery("#file_url").val()},
			dataType:'json',
			cache:false
		}).done(function(d){
			jQuery("#progressbar").hide();
			jQuery("#file_url").val('');
			if(d.file_url != ""){
				jQuery("#frameAgreemeReview").attr("src",d.file_url).show();
			} else {
				alert(d.message);
				var _data = d.data;
				var _masked = 'no';
				if(_data.masked == 1){
					_masked = 'yes';
				}
				hot2.updateSettings({
					data:[{agreement_date:_data.agreement_date,file_name:_data.file_name,patent_number:_data.patent_number,payment_terms:_data.payment_terms,licensor:_data.licensor,licensee:_data.licensee,masked:_masked}]
				});
				jQuery("#frameAgreemeReview").attr("src","https://backyard.synpat.com/public/upload/agreements/"+_data.agreement_url).show();
			}
		});
	}
}
jQuery(document).ready(function(){
	jQuery("#btnSave").on('click',function(){
		if(jQuery("#frameAgreemeReview").attr("src") != "about:blank") {
			var tableData = hot2.getSourceData();
			var frmData = tableData[0];
			frmData.agreement_url = jQuery("#frameAgreemeReview").attr("src");
			jQuery.ajax({
				url:'https://backyard.synpat.com/Outsource/save',
				type:'POST',
				data:frmData,
				dataType:'json',
				cache:false
			}).done(function(d){
				jQuery("#progressbar").hide();
				if(d.update == 0){
					alert("Unable to save data.")
				}
				resetForm();
			});
		} else {
			alert("Please upload agreement first.");
		}
	});
});
function resetForm(){
	_confirmedRequestJSON = [{agreement_date:'',file_name:'',patent_number:'',payment_terms:'',licensor:'',licensee:'',masked:'no'}];
	hot2.loadData(_confirmedRequestJSON);
	jQuery("#upload_new_document","#file_url").val('');
	jQuery("#frameAgreemeReview").hide().attr("src","about:blank");
}
</script>
</body>
</html>