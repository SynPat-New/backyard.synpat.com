<script type="text/javascript" src="<?php echo $Layout->baseUrl; ?>public/tiff.min.js"></script>
<script>
var img = '<?php echo $imgsrc;?>';
function msieversion(){
			var ua = window.navigator.userAgent;
			var msie = ua.indexOf("MSIE ");

			if (msie > 0) // If Internet Explorer, return version number
			{
				return true;
				//alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
			}
			else  // If another browser, return 0
			{
				return false;
				//alert('otherbrowser');
			}

			return false;
		}
if(msieversion()==true){
	jQuery("#images").append('<p><object width=650 height=400  classid="CLSID:106E49CF-797A-11D2-81A2-00E02C015623"><param name="src" value="'+img+'"><param name="negative" value="yes"><embed width=650 height=400 src="'+img+'" type="image/tiff" negative=yes></object></p>');
} else {
	var xhr = new XMLHttpRequest();
	xhr.responseType = 'arraybuffer';
	xhr.open('GET', img);
	xhr.onload = function (e) {
		var tiff = new Tiff({buffer: xhr.response});
		var canvas = tiff.toCanvas();
		jQuery("#images").append(canvas);
	};
	xhr.send();
}
</script>
<div id='images'></div>