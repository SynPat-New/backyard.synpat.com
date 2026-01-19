<img src="<?php echo $imgsrc;?>"/>
<input type="text" name="captcha_code" id="captcha_code" class="form-control" placeholder="Enter captcha code.."/>
<input type="hidden" name="captcha_id" id="captcha_id" value="<?php echo $id;?>"/><br/>
<input type="button" value="Submit" onclick="submitCaptcha(jQuery(this))"/>