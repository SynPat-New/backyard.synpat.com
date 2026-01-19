<?php 
	$subject = "";
	$from = "";
	$to = "";
	$cc = "";
	$date = "";
	$email = "";
	$delieveredTo="";
	$star="";
	$_attachmentString="";
	$_messagesString = "";
	$_referenceString="";
	$stringUL = "";
	$attr = "";
	$threadID = "";
	$messageID = "";
	$id = 0;
	$userID = 0;
	$leadID = 0;
		$mainData = $thread_detail;		
		if(count($mainData)>0){			
			for($m=0;$m<count($mainData);$m++){
				$leadID = $mainData[$m]->lead_id;
				if($mainData[$m]->account_type!=2){
				$id = $mainData[$m]->id;
				$userID = $mainData[$m]->user_id;
				$thread_detail = json_decode($mainData[$m]->content);	
				$threadID = $mainData[$m]->thread_id;
				$messageID = $mainData[$m]->message_id;
				for($i=0;$i<count($thread_detail);$i++){
					$headers = $thread_detail[$i]->header;
					$labelIds = $thread_detail[$i]->labelIds;										
					for($j=0;$j<count($headers);$j++){												
						if($headers[$j]->name=='Subject'){
						$subject = $headers[$j]->value;
						}
						if($headers[$j]->name=='From'){
							$from = $headers[$j]->value;
							/*$from = str_replace("<","",$from);
							$from = str_replace(">","",$from);*/
						}
						if($headers[$j]->name=='To'){
							$to = $headers[$j]->value;
							/*$to = str_replace("<","",$to);
							$to = str_replace(">","",$to);*/
						}
						if($headers[$j]->name=='Delivered-To'){
							$delieveredTo = $headers[$j]->value;
						}
						if($headers[$j]->name=='References'){
							$_rFlag = 1;
							$_referenceString = $headers[$j]->value;
						}
						if(strtolower($headers[$j]->name)=='cc'){
							$cc = $headers[$j]->value;
						}
						if($headers[$j]->name=='Authentication-Results'){
							$raw = $headers[$j]->value;
							$raw = explode('smtp.mail=',$raw);
							if(count($raw)==2){
								$email = $raw[1];
							}
						}
						if($headers[$j]->name=='Received'){
							$date = $headers[$j]->value;
							$_da = explode(';',$date);
							if(count($_da)==2){
								$date = $_da[1];
							}
						}
					}
					if($from=="" && $email!=""){
						$from=$email;											
					}
					if($to=="" && $delieveredTo!=""){
						$to = $delieveredTo;											
					}
					if(in_array("STARRED",$labelIds)){
						$star = '<i class="glyph-icon icon-star"></i>';
						$attr = 'Starred';
					} else {
						$star = '<i class="glyph-icon icon-star-o"></i>';
						$attr = 'No Starred';
					}
					$body = $thread_detail[$i]->body;
					if(isHTML($body)===false){
						$body = nl2br($body);
					}
					$body =	preg_replace("/https:\/\/synpat.com\/display_synpat_logo.php/m", '', $body);
					if($i==0){
						$_files = explode(',',$mainData[$m]->file_attach);						
						if(count($_files)>0){
							for($a=0;$a<count($_files);$a++){
								if($_files[$a]!=""){
									$filename = stristr($_files[$a],'upload');
									$filenameSub=$_files[$a];
									if($filename){
										$filenameSub = substr($_files[$a],$filename+7);
									}								
								$_attachmentString .="<tr class='attach ".$thread_detail[$i]->message_id."'><td><a data-href='".$_files[$a]."' href='javascript://' onclick='window.parent.open_drive_files(\"".$_files[$a]."\")' target='_BLANK'><i class='glyph-icon icon-file' data-mime='' style='color:#2196f3'></i> ".$filenameSub."</a></td></tr>";
								}
							}
						}
					}
					
					$_messagesString .='<div class="row">'.
											'<div class="col-md-12 col-sm-12 col-xs-12">'.
											'    <div class="p-20">';
					if($i>0){
						$_messagesString .='<h3 class="message-title">'.$subject.'</h3>';
					}
					$_messagesString .=		'        <div class="message-item media">'.
											'            <div class="message-item-right">'.
											'                <div class="media">'.
											'                    <div class="media-body">'.
											'                        <p class="c-gray"></p>'.
											'                    </div>'.
											'                </div>'.
											'            </div>'.
											'        </div>'.
											'    </div>'.
											'   <div class="message-body" id="message-body">'.$body.
											'    </div>'.
											'</div>'.
										'</div>';
					
					if($i>0 && $i<count($thread_detail)-1){
						$_messagesString .='<div class="message-between"></div>';
					}
					if($m==count($mainData)-1){
						$stringUL = "<table><tbody>".$_attachmentString."</tbody></table>";
						
					}
				}
				}
			}
		}
	
?>
<style>body{min-width:0}
body.is-scrollable-body {
	overflow-x: hidden !important;
	overflow-y: auto !important;
}
button,.btn, .btn div, .btn a{color:#000;}
#page-content{padding:0}.message-result .message-detail-right a{color:#222}.message-result .message-detail-right a:hover{color:#56b2fe}.dropdown-menu li>a,.ui-menu li>a{color:#222;text-decoration:none}.dropdown-menu .row>div{margin-bottom:0!important}#message-body a{color:#2196f3;}</style>
<div data-padding="40" data-height="window" class="panel panel-default panel-no-margin withScroll mCustomScrollbar _mCS_117" id="message-detail" style="border:0;overflow-y:auto">
<div id="mCSB_117" class="mCustomScrollBox mCS-dark-2">
<div class="mCSB_container">
<div class="panel-heading messages message-result">
<h2 class="message-detail-title is-subject p-t-20 w-500 show">
<span class="message-detail-subject">
<?php echo $subject;?>
</span>
</h2>
<div class="row">
<div class="col-xs-6">
<h2 id="messageDetailTitleSubject" class="message-detail-title p-t-20 w-500 show">
<strong><span class="message-detail-from show"><?php echo $from;?></span></strong>
</h2>
<h2 class="message-detail-title p-t-20 w-500 show">
to: <span class="message-detail-to"><?php echo $to?></span>
<div class="message-detail-buttons-left btn-group" role="group">
<div class="btn-group" role="group">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
<span class="caret"></span>
</button>
<div class="dropdown-menu" role="menu" style="width:300px">
<div class="row">
<div class="col-xs-3">
<label>from:</label>
</div>
<div class="col-xs-9">
<strong class="message-detail-from" style='word-wrap:break-word'><xmp><?php echo $from;?></xmp></strong>
</div>
</div>
<div class="row">
<div class="col-xs-3">
<label>to:</label>
</div>
<div class="col-xs-9">
<span class="message-detail-to" style='word-wrap:break-word'><xmp><?php echo $to?></xmp></span>
</div>
</div>
<div class="row">
<div class="col-xs-3">
<label>cc:</label>
</div>
<div class="col-xs-9">
<span class="message-detail-cc" style='word-wrap:break-word'><xmp><?php echo $cc;?></xmp></span>
</div>
</div>
<div class="row">
<div class="col-xs-3">
<label>date:</label>
</div>
<div class="col-xs-9">
<span class="message-detail-date"><?php echo $date;?></span>
</div>
</div>
<div class="row">
<div class="col-xs-3">
<label>subject:</label>
</div>
<div class="col-xs-9">
<span class="message-detail-subject"><?php echo $subject;?></span>
</div>
</div>
</div>
</div>
</div>
</h2>
</div>
<div class="col-xs-6 text-right">
<h2 class="message-detail-title p-t-20 w-500 is-date show">
<span class="message-detail-date"><?php echo $date;?></span>
</h2>
<div class="message-detail-right show">
<a href="javascript://" onclick="threadLabelChanged('Starred',jQuery(this))" data-original-title="<?php echo $attr;?>" class="message-detail-star tooltip-button" title="To favorite" data-placement="bottom">
<?php echo $star;?>
</a>
<div class="message-detail-buttons-right btn-group" role="group">

<div class="btn-group" role="group">
<button type="button" class="btn btn-default dropdown-toggle eReply" data-toggle="dropdown" aria-expanded="false">
<span class="caret"></span>
</button>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="panel-body messages message-result message_detail">
<div class="loading-spinner" id="loading_spinner" style='display:none'>
<img src="<?php echo $Layout->aws_server_cdn;?>images/ajax-loader.gif" alt="">
</div>
<?php echo $_messagesString.$stringUL;?>
</div>
</div>
</div>
</div>
