<!DOCTYPE html> 
<html>
<head>
	<title>Family Tree Diagram</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo $Layout->aws_server_cdn;?>primitives/jquery/ui-lightness/jquery-ui-1.10.2.custom.css" />
	<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>primitives/jquery/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>primitives/jquery/jquery-ui-1.10.2.custom.js"></script>

	<!-- jQuery UI Layout -->

	<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>primitives/jquerylayout/jquery.layout-latest.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>primitives/jquerylayout/layout-default-latest.css" />

	

	<!-- header -->

	<!-- # include file="src/src.primitives.html"-->

	<link href="<?php echo $Layout->aws_server_cdn;?>primitives/css/primitives.latest.css?3600" media="screen" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>primitives/primitives.min.js?3600"></script>

	<!--<script type="text/javascript" src="<?php echo $Layout->aws_server_cdn;?>primitives/demodata.js"></script>-->

	<script type='text/javascript'>//<![CDATA[ 
		$(window).load(function () {
			var options = new primitives.orgdiagram.Config();

			var items = [
				<?php 
					if(count($patent_family['publications'])>0){
						$i=0;
						foreach($patent_family['publications'] as $publication){
							$parent = null;
							if($i==0){
				?>
							new primitives.orgdiagram.ItemConfig({
									id: <?php echo $i?>,
									parent: null,
									title: "<?php echo $publication->publication_number?>",
									description: "<?php echo $publication->application_country.$publication->application_number?>",
									image: "demo/images/photos/a.png"
								}),
				<?php
							} else {
				?>
								new primitives.orgdiagram.ItemConfig({
									id: <?php echo $i?>,
									parent: <?php echo $i-1;?>,
									title: "<?php echo $publication->publication_number?>",
									description: "<?php echo $publication->application_country.$publication->application_number?>",
									image: "demo/images/photos/a.png"
								}),
				<?php		}
							$i++;
						}
					}
				?>				
			];
			
			options.items = items;
			options.cursorItem = 0;
			options.hasSelectorCheckbox = primitives.common.Enabled.True;
			options.pageFitMode = primitives.orgdiagram.PageFitMode.None;
			options.arrowsDirection = primitives.common.GroupByType.Parents;
			w = jQuery(window).width()-20;
			
			h = jQuery(window).height() - 100;
			jQuery("#basicdiagram").css({width:w+'px',height:h+'px'}).orgDiagram(options);
		});//]]>  

	</script>
	<!-- /header -->
</head><body style="font-size: 12px">
	<h3><?php echo count($patent_family['publications']);?></h3>
	<div id="basicdiagram" style="width: 640px; height: 480px; border-style: dotted; border-width: 1px;" />
</body>
</html>
