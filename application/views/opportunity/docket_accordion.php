<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/typography.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>helpers/grid.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>themes/components/default.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>elements/buttons.css">
<link rel="stylesheet" type="text/css" href="<?php echo $Layout->baseUrl;?>public/widgets/modal/modal.css">
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/js-core/jquery-1.12.2.min.js"></script>
<script type="text/javascript" src="<?php echo $Layout->baseUrl;?>public/widgets/modal/modal.js"></script>
<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
<style>body{overflow:auto!important;font-family:arial;font-size:13px;}#page-content{background:#ffffff!important} .btn-opp-block {width: 100%;}.spinner{margin:0;width:70px;height:18px;margin:-35px 0 0 -9px;position:absolute;top:50%;left:50%;text-align:center}.spinner>div{width:18px;height:18px;background-color:#333;border-radius:100%;display:inline-block;-webkit-animation:bouncedelay 1.4s infinite ease-in-out;animation:bouncedelay 1.4s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}
.modal{position:relative;}
.width95{width:99%;}
.modal.modal-opened-header .modal-dialog, .modal .modal-dialog{margin:50px 0 0 0 !important;}
.modal-content{box-shadow:unset;}
</style>
<script>
var __baseUrl="<?php echo $Layout->baseUrl; ?>";</script>

<div class="row"> 
<div style='overflow-x: hidden; overflow-y: auto; height: auto;'>
<div class="pad10A">
<div class="col-md-12 col-sm-12 col-xs-12" id="contentPart">
<style id="tempStyles">.dashboard-box{overflow-y:scroll!important}.tab-pane{display:block}</style>
<script>
leadGlobal = "<?php echo $lead_id; ?>";
_token = "<?php echo $lead_id; ?>";
</script>	
	<div class="row">
		<div class="col-lg-12">
			<h3>Dockets Accordion</h3>
			<div class="form-group input-string-group bigmr " style="border: none !important;">
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(1)" style="font-size:13px;padding:0px;">Portfolio</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(2)" style="font-size:13px;padding:0;">CounterParts</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(3)" style="font-size:13px;padding:0;">Claim</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(4)" style="font-size:13px;padding:0;">Invention</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(5)" style="font-size:13px;padding:0;">Evidence of Use</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(29)" style="font-size:13px;padding:0;">Litigation</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(6)" style="font-size:13px;padding:0;">Comparables</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(7)" style="font-size:13px;padding:0;">Royalties</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(8)" style="font-size:13px;padding:0;">F.Citations</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(9)" style="font-size:13px;padding:0;">Seller</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(10)" style="font-size:13px;padding:0;">PDF</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(11)" style="font-size:13px;padding:0;">Validity</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(12)" style="font-size:13px;padding:0;">B.Citations</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(13)" style="font-size:13px;padding:0;">Documents</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(14)" style="font-size:13px;padding:0px;">Structure</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(15)" style="font-size:13px;padding:0px;">Simulator</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(16)" style="font-size:13px;padding:0;">PriorArt</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(27)" style="font-size:13px;padding:0;">DMCA</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(25)" style="font-size:13px;padding:0;">Legal Notice</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(26)" style="font-size:13px;padding:0;">Privacy Policy</a>
			</div>
		</div>	
		<div class="col-lg-12">
			<h3>Due Dilligence Accordion</h3>
			<div class="form-group input-string-group bigmr " style="border: none !important;">
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(17)" style="font-size:13px;padding:0px;">SellerDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(18)" style="font-size:13px;padding:0px;">TechDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(19)" style="font-size:13px;padding:0;">MarketDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(20)" style="font-size:13px;padding:0px;">LegalDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(21)" style="font-size:13px;padding:0px;">IllustrationDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(22)" style="font-size:13px;padding:0;">ImageDD</a>
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(23)" style="font-size:13px;padding:0px;">PdfDD</a>
				<!--<a href="javascript://" class="btn mrg15R" onclick="openModalContent(15)" style="font-size:13px;padding:0;">IntroDD</a>-->
				<a href="javascript://" class="btn mrg15R" onclick="openModalContent(24)" style="font-size:13px;padding:0;">DictionaryDD</a>
			</div>
		</div>
	</div>
	<input type="hidden" name="other[lead_id]" id="leadID" value="<?php echo $lead_id?>" />	
</div>
</div>
</div>
</div>
<style>.width100{width:100%;}.modal.modal-opened-header, .modal{margin-top:0px !important;}.modal.modal-opened-header .modal-dialog, .modal .modal-dialog{height:60vh !important;}.modal-content{height:99% !important;overflow:auto;}.modal-title{width:auto !important;display:inline-block;}.top_button{float:right;}.close{margin-left:10px;}.modal-backdrop{background:none;display:none;}.modal-body,.modal{overflow:hidden;}</style>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="portfolioModal" tabindex="-1" role="dialog"  aria-hidden="true" style=''>
	<div class="modal-dialog width95" >
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="top_button">
					<button type="button" onclick="saveModalText(1,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(1,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
				<h4 class="modal-title" id="">Portfolio Accordion Text</h4>				
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">
						<textarea class='wysiwyg-editor' name='portfolio_tab' id='portfolio_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="counterpartsModal" tabindex="-1" role="dialog"  aria-hidden="true" style=''>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Counterparts Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(2,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(2,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='counter_tab' id='counter_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="claimModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Claim Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(3,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(3,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='claim_tab' id='claim_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="inventionModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Invention Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(4,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(4,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='invention_tab' id='invention_tab'></textarea>
					</div>
				</div>				
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="evidenceModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Evidence Accordion Text</h4>
				<div class="top_button">
					<button type="button" onclick="saveModalText(5,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(5,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='evidence_tab' id='evidence_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="comparablesModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Comparables Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(6,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(6,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='comparables_tab' id='comparables_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="royaltiesModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Royalties Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(7,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(7,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='royalties_tab' id='royalties_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="fcitationModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">F.Citation Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(8,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(8,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='fcitation_tab' id='fcitation_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="sellerModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Seller Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(9,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(9,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='seller_tab' id='seller_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="pdfModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">PDF Accordion Text</h4>
				<div class="top_button">
					<button type="button" onclick="saveModalText(10,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(10,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='pdf_tab' id='pdf_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="validityModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Validity Accordion Text</h4>		
				<div class="top_button">
					<button type="button" onclick="saveModalText(11,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(11,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='validity_tab' id='validity_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="bcitationModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">B.Citation Accordion Text</h4>
				<div class="top_button">
					<button type="button" onclick="saveModalText(12,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(12,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='bcitation_tab' id='bcitation_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="documentsModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Document Accordion Text</h4>		
				<div class="top_button">
					<button type="button" onclick="saveModalText(13,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(13,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='document_tab' id='document_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="priceModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Price Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(14,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(14,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='price_tab' id='price_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="simulatorModal" tabindex="-1" role="dialog"  aria-hidden="true" style=''>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Simulator Accordion Text</h4>		
				<div class="top_button">
					<button type="button" onclick="saveModalText(15,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(15,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='simulator_tab' id='simulator_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="priorartModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">PriorArt Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(16,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(16,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='prior_tab' id='prior_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="legalModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Legal Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(25,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(25,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='legal_tab' id='legal_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="dmcaModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">DMCA</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(27,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(27,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='dmca' id='dmca'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="privacyModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Privacy Accordion Text</h4>		
				<div class="top_button">
					<button type="button" onclick="saveModalText(26,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(26,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='privacy_tab' id='privacy_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<!-- -->
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="seller_ddModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">SellerDD Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(17,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(17,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='seller_dd' id='seller_dd'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="tech_ddModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">TechDD Accordion Text</h4>
				<div class="top_button">
					<button type="button" onclick="saveModalText(18,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(18,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='tech_dd' id='tech_dd'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="market_ddModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">MarketDD Text</h4>
				<div class="top_button">
					<button type="button" onclick="saveModalText(19,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(19,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='market_dd' id='market_dd'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="legal_ddModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">LegalDD Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(20,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(20,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='legal_dd' id='legal_dd'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="illustration_ddModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">IllustrationDD Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(21,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(21,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='illustration_dd' id='illustration_dd'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="image_ddModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">ImageDD Accordion Text</h4>		
				<div class="top_button">
					<button type="button" onclick="saveModalText(22,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(22,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='image_dd' id='image_dd'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<!-- -->
<!-- -->
<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="pdf_ddModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">PdfDD Accordion Text</h4>		
				<div class="top_button">
					<button type="button" onclick="saveModalText(23,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(23,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='pdf_dd' id='pdf_dd'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="litigation_tabModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">Litigation Accordion Text</h4>		
				<div class="top_button">
					<button type="button" onclick="saveModalText(29,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(29,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='litigation_tab' id='litigation_tab'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<div class="modal modal-opened-header fade width100" data-backdrop="static" data-keyboard="false" id="dictionary_ddModal" tabindex="-1" role="dialog"  aria-hidden="true" style=' '>
	<div class="modal-dialog width95" style=''>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="">DictionaryDD Accordion Text</h4>	
				<div class="top_button">
					<button type="button" onclick="saveModalText(24,0)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Docket</button>
					<button type="button" onclick="saveModalText(24,1)" class='btn btn-mwidth  btn-primary' style='margin-right:1px;'>Save to Skeleton</button>
				</div>
			</div>
			<div class="modal-body"> 			   
				<div class="row">
					<div class="col-lg-12">						
						<textarea class='wysiwyg-editor' name='dictionary_dd' id='dictionary_dd'></textarea>
					</div>
				</div>               
			   <div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
<script>
function closeAllModal(){jQuery("#portfolioModal,#counterpartsModal,#claimModal,#inventionModal,#evidenceModal,#comparablesModal,#royaltiesModal,#fcitationModal,#sellerModal,#pdfModal,#validityModal,#bcitationModal,#documentsModal,#priceModal,#simulatorModal,#priorartModal,#legalModal,#privacyModal,#tech_ddModal,#market_ddModal,#legal_ddModal,#illustration_ddModal,#image_ddModal,#pdf_ddModal,#intro_ddModal,#dictionary_ddModal,#seller_ddModal").modal("hide");}
function openModalContent(type){closeAllModal();
	let containerElement = '';
	let field = '';
	switch(type){
		case 1:
			containerElement = "#portfolioModal";
			field = 'portfolio_tab';
			break;
		case 2:
			containerElement = "#counterpartsModal";
			field = 'counter_tab';			
			break;
		case 3:
			containerElement = "#claimModal";	 
			field = 'claim_tab';		
			break;
		case 4:
			containerElement = "#inventionModal";
			field = 'invention_tab';		
			break;
		case 5:
			containerElement = "#evidenceModal";
			field = 'evidence_tab';		
			break;
		case 6:
			containerElement = "#comparablesModal";
			field = 'comparables_tab';		
			break;
		case 7:
			containerElement = "#royaltiesModal";
			field = 'royalties_tab';		
			break;
		case 8:
			containerElement = "#fcitationModal";
			field = 'fcitation_tab';		
			break;
		case 9:
			containerElement = "#sellerModal";
			field = 'seller_tab';		
			break;
		case 10:
			containerElement = "#pdfModal";
			field = 'pdf_tab';		
			break;
		case 11:
			containerElement = "#validityModal";
			field = 'validity_tab';		
			break;
		case 12:
			containerElement = "#bcitationModal";
			field = 'bcitation_tab';		
			break;
		case 13:
			containerElement = "#documentsModal";
			field = 'document_tab';		
			break;
		case 14:
			containerElement = "#priceModal";
			field = 'price_tab';		
			break;
		case 15:
			containerElement = "#simulatorModal";
			field = 'simulator_tab';		
			break;
		case 16:
			containerElement = "#priorartModal";
			field = 'prior_tab';		
			break;
		case 25:
			containerElement = "#legalModal";
			field = 'legal_tab';		
			break;	
		case 26:
			containerElement = "#privacyModal";
			field = 'privacy_tab';		
			break;	
		case 27:
			containerElement = "#dmcaModal";
			field = 'dmca';		
			break;	
		case 17:
			containerElement = "#seller_ddModal";
			field = 'seller_dd';		
			break;
		case 18:
			containerElement = "#tech_ddModal";
			field = 'tech_dd';		
			break;
		case 19:
			containerElement = "#market_ddModal";
			field = 'market_dd';		
			break;
		case 20:
			containerElement = "#legal_ddModal";
			field = 'legal_dd';		
			break;
		case 21:
			containerElement = "#illustration_ddModal";
			field = 'illustration_dd';		
			break;
		case 22:
			containerElement = "#image_ddModal";
			field = 'image_dd';		
			break;
		case 23:
			containerElement = "#pdf_ddModal";
			field = 'pdf_dd';		
			break;
		case 28:	
			containerElement = "#intro_ddModal";
			field = 'intro_dd';		
			break;
		case 24:	
			containerElement = "#dictionary_ddModal";
			field = 'dictionary_dd';
			break;
		case 29:	
			containerElement = "#litigation_tabModal";
			field = 'litigation_tab';
			break;
	}
	if(containerElement != ""){
		if(!jQuery(containerElement).is(":visible")) {
			jQuery(containerElement).find('.msg').remove();
			jQuery(containerElement).modal("show");
			jQuery.ajax({
				url:__baseUrl+'opportunity/getNotesData',
				type:'POST',
				data:{field:field,lead_id:jQuery("#leadID").val()}
			}).done(function(d){
				if(d != ""){
					CKEDITOR.instances[field].destroy()
					jQuery("#"+field).val(d);
					callEditor(field);
				}
			}).fail(function(jqXHR,textStatus){
				alert(textStatus);
			})
		} else {
			//jQuery(containerElement).modal("hide");
		}
	}	
}
function saveModalText(type,mode){
	let $text="";
	let data = {};
	let modalElement = "";
	switch(type){
		case 1:
			$text = CKEDITOR.instances['portfolio_tab'].getData();
			if($text!=""){
				data.portfolio_tab = $text;
				modalElement = "portfolioModal";
			}	
			break;
		case 2:
			$text = CKEDITOR.instances['counter_tab'].getData();
			if($text!=""){
				data.counter_tab = $text;
				modalElement = "counterpartsModal";
			}	
			break;
		case 3:
			$text = CKEDITOR.instances['claim_tab'].getData();
			if($text!=""){
				data.claim_tab = $text;
				modalElement = "claimModal";
			}
			break;
		case 4:
			$text = CKEDITOR.instances['invention_tab'].getData();
			if($text!=""){
				data.invention_tab = $text;
				modalElement = "inventionModal";
			}
			break;
		case 5:
			$text = CKEDITOR.instances['evidence_tab'].getData();
			if($text!=""){
				data.evidence_tab = $text;
				modalElement = "evidenceModal";
			}
			break;
		case 6:
			$text = CKEDITOR.instances['comparables_tab'].getData();
			if($text!=""){
				data.comparables_tab = $text;
				modalElement = "comparablesModal";
			}
			break;
		case 7:
			$text = CKEDITOR.instances['royalties_tab'].getData();
			if($text!=""){
				data.royalties_tab = $text;
				modalElement = "royaltiesModal";
			}
			break;
		case 8:
			$text = CKEDITOR.instances['fcitation_tab'].getData();
			if($text!=""){
				data.fcitation_tab = $text;
				modalElement = "fcitationModal";
			}
			break;
		case 9:
			$text = CKEDITOR.instances['seller_tab'].getData();
			if($text!=""){
				data.seller_tab = $text;
				modalElement = "sellerModal";
			}
			break;
		case 10:
			$text = CKEDITOR.instances['pdf_tab'].getData();
			if($text!=""){
				data.pdf_tab = $text;
				modalElement = "pdfModal";
			}
			break;
		case 11:
			$text = CKEDITOR.instances['validity_tab'].getData();
			if($text!=""){
				data.validity_tab = $text;
				modalElement = "validityModal";
			}
			break;
		case 12:
			$text = CKEDITOR.instances['bcitation_tab'].getData();
			if($text!=""){
				data.bcitation_tab = $text;
				modalElement = "bcitationModal";
			}
			break;
		case 13:
			$text = CKEDITOR.instances['document_tab'].getData();
			if($text!=""){
				data.document_tab = $text;
				modalElement = "documentsModal";
			}
			break;
		case 14:
			$text = CKEDITOR.instances['price_tab'].getData();
			if($text!=""){
				data.price_tab = $text;
				modalElement = "priceModal";
			}
			break;
		case 15:
			$text = CKEDITOR.instances['simulator_tab'].getData();
			if($text!=""){
				data.simulator_tab = $text;
				modalElement = "simulatorModal";
			}
			break;
		case 16:
			$text = CKEDITOR.instances['prior_tab'].getData();
			if($text!=""){
				data.prior_tab = $text;
				modalElement = "priorartModal";
			}
			break;		
		case 17:
			$text = CKEDITOR.instances['seller_dd'].getData();
			if($text!=""){
				data.seller_dd = $text;
				modalElement = "seller_ddModal";
			}
			break;
		case 18:
			$text = CKEDITOR.instances['tech_dd'].getData();
			if($text!=""){
				data.tech_dd = $text;
				modalElement = "tech_ddModal";
			}
			break;
		case 19:
			$text = CKEDITOR.instances['market_dd'].getData();
			if($text!=""){
				data.market_dd = $text;
				modalElement = "market_ddModal";
			}
			break;
		case 20:
			$text = CKEDITOR.instances['legal_dd'].getData();
			if($text!=""){
				data.legal_dd = $text;
				modalElement = "legal_ddModal";
			}
			break;
		case 21:
			$text = CKEDITOR.instances['illustration_dd'].getData();
			if($text!=""){
				data.illustration_dd = $text;
				modalElement = "illustration_ddModal";
			}
			break;
		case 22:
			$text = CKEDITOR.instances['image_dd'].getData();
			if($text!=""){
				data.image_dd = $text;
				modalElement = "image_ddModal";
			}
			break;
		case 23:
			$text = CKEDITOR.instances['pdf_dd'].getData();
			if($text!=""){
				data.pdf_dd = $text;
				modalElement = "pdf_ddModal";
			}
			break;
		case 24:
			$text = CKEDITOR.instances['dictionary_dd'].getData();
			if($text!=""){
				data.dictionary_dd = $text;
				modalElement = "dictionary_ddModal";
			}
			break;
		case 25:
			$text = CKEDITOR.instances['legal_tab'].getData();
			if($text!=""){
				data.legal_tab = $text;
				modalElement = "legalModal";
			}
			break;	
		case 26:
			$text = CKEDITOR.instances['privacy_tab'].getData();
			if($text!=""){
				data.privacy_tab = $text;
				modalElement = "privacyModal";
			}
			break;
		case 27:
			$text = CKEDITOR.instances['dmca'].getData();
			if($text!=""){
				data.dmca = $text;
				modalElement = "dmcaModal";
			}
			break;
		case 28:
			$text = CKEDITOR.instances['intro_dd'].getData();
			if($text!=""){
				data.intro_dd = $text;
				modalElement = "intro_ddModal";
			}
			break;
		case 29:
			$text = CKEDITOR.instances['litigation_tab'].getData();
			if($text!=""){
				data.litigation_tab = $text;
				modalElement = "litigation_tabModal";
			}
			break;
	}
		
	if(modalElement != "") {
		data.lead_id = leadGlobal;
		data.mode = mode;
		jQuery.ajax({
			type:'POST',
			url:"<?php echo $Layout->baseUrl?>opportunity/save_accordion_text",
			data:data,
			cache:false
		}).done(function(d){
			if(d == ""){
				alert("Error while saving data");
			} else if(d == 1){
				jQuery("#"+modalElement).find('.msg').remove();
				jQuery("#"+modalElement).find('.top_button').find('button').eq(0).before("<span class='msg' style='color:green;'>Saved!</span>")
			}
		}).fail(function (jqXHR, textStatus) {
			alert(textStatus);
		});
	}
}
$(window).load(function() {
    setTimeout(function() {
        $("#loading").fadeOut(400, "linear")
    }, 300)
});
jQuery(document).ready(function(){
	var allSelectors = document.querySelectorAll('.wysiwyg-editor');
	for(i=0;i<allSelectors.length;i++){
		try{
			callEditor(allSelectors[i]);
		}catch(e){
			
		}
	}	
});
function callEditor(e){
	let h = jQuery(window).height();
	h -= 200;
	CKEDITOR.replace( e,{
		width: '100%',
		height: h,
		extraPlugins: 'autogrow',
        autoGrow_minHeight: 200,
        autoGrow_maxHeight: 600,
        autoGrow_bottomSpace: 50,
        removePlugins: 'resize'
	})
}
</script>