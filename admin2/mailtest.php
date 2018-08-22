<?
include("local.php");

function qmail($to, $subject,$message){
	$headers = 'From: info@jludance.com' . "\r\n" .
			'Reply-To: info@jludance.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

	$mail=mail($to, $subject, $message,$headers, '-fjun@jludance.com');
	//@mail($to, $subject, $message, $headers);
	if($mail){
	 echo "success";
	  }else{
	 echo "failed.";
	  }
}

//emailadmin("test message","just a test of mail function");

qmail('qingfenghuang@msn.com',"test message local 2","just a test of mail function");
?>
