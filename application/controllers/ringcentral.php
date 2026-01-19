<?php 
$v = $_SERVER['HTTP_VALIDATION_TOKEN'];
/*mail("webmaster@synpat.com","HTTP_VALIDATION_TOKEN",$v);*/
if (strlen($v)>0) {
  header("Validation-Token: {$v}");  
} else {
	$data = $_REQUEST;
	if(strlen($data)>0){
		/*mail("webmaster@synpat.com","HTTP_POST1",$data);*/
	} else {
		/*mail("webmaster@synpat.com","HTTP_POST","SORRY");*/
	}
	
}
?>