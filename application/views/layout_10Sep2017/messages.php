<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Messages</title>
		<link rel="stylesheet" type="text/css" href="<?php echo $Layout->aws_server_cdn;?>style_new_without_compress.css?v=1477063946">
		<style type="text/css">
		.viewticket .databox.blue .comment .meta > a{ border:0;}
		.todo-box li img{ float:left; border:0;  border-radius:0; margin:0px; max-width:100%;}
		.box-md{width:100%;}
		body{overflow:auto !important;min-width:100%;max-width:100%;width:100%;margin:0px;}
		.message-inbox-toggler{width:100%;text-align:right;display:block;}
		.message-inbox-detail{height:86px;overflow:hidden}
		.message-inbox-detail.is-open{height:100%;overflow:auto}
		</style>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script>
			function toggleMessage(o){
				if(o.hasClass('is-open')){
					o.removeClass('is-open');
					o.find('i.glyph-icon').removeClass('icon-minus').addClass('icon-plus');
					o.parent().parent().find('.message-inbox-detail').removeClass('is-open');
				} else {
					o.addClass('is-open');
					o.find('i.glyph-icon').removeClass('icon-plus').addClass('icon-minus');
					o.parent().parent().find('.message-inbox-detail').addClass('is-open');
				}
			}
		</script>
	</head>
	<body>
		<?php 
		$openTask = false;
		if((int)$this->session->userdata['user']['type']==9 || in_array(22,$this->session->userdata['modules_assign'])){  
			$openTask = true;
		}
		if($openTask===true):
	?>
	<div class="box-md">
		<h1 class="mrg15L font-black font-size-17 text-center"><?php echo $heading;?></h1>
		<ul class="todo-box">
			<?php 
				if(count($listConversation['count'])>0){
					foreach($listConversation['list'] as $message){
						$colors_array= "";
						switch($message->leadType){
							case 'Litigation':
								$colors_array = "bg-yellow";
							break;
							
							case 'Market':
								$colors_array = "bg-green";
							break;
							
							case 'General':
								$colors_array = "label-info";
							break;
							
							case 'SEP':
								$colors_array = "bg-warning";
							break;
						}
						$messageSent = $message->userMessage;
										
			?>
				
			<li style="border:1px solid #eee;" class="ms-hover"> <a href="javascript://" onClick="window.parent.openMessageBox(<?php echo $message->taskID?>)" style="text-decoration:none"> 
				<span class="tl-label bs-label bg-green"><?php echo $message->lead_name?></span></a>
				<div class="col-md-12">
					<div class="col-md-2 col-xs-2">
						<div class="col-md-12 col-xs-12">
						<?php 
							if(empty($message->profile_pic)):
						?>
							<img title="<?php echo $message->userName;?>" src="<?php echo $Layout->aws_server_cdn;?>upload/user.png" width="28"/>
						<?php else:?>
							<img title="<?php echo $message->userName;?>" src="<?php echo $message->profile_pic;?>" width="28"/>
						<?php endif;?>
						</div>
						<br/>
						<h6><a href="javascript://" onClick="window.parent.openMessageBox(<?php echo $message->taskID?>)"><?php echo $message->userName;?></a></h6>
						<span class="date"><?php echo date('M d,Y',strtotime($message->create_c));?></span>
					</div>
					<div class="col-md-9 col-xs-9">
						<div id="ticket_<?php echo $message->taskID?>_me_body" class="message-inbox-detail">
							<a href="javascript://" onClick="window.parent.openMessageBox(<?php echo $message->taskID?>)" style='text-decoration:none'>
                                <p style=""><?php echo nl2br($messageSent);?></p>
                            </a>							
						</div>
						
					</div>
                    
                    <div class="col-md-1 col-xs-1">
                    <a id="ticket_<?php echo $message->taskID?>_me_body_button" href="javascript://" class="message-inbox-toggler" onClick="toggleMessage(jQuery(this));"><i class='glyph-icon icon-plus'></i></a>
                    </div>
				</div>
			</li>
			 <?php
					}
				} else {
			?>
			<li>
				<p class="alert">No message by you!</p>
		   </li>
		  <?php
				}
		  ?>
		</ul>       
	</div>
	<?php endif;?>   
	</body>
</html> 