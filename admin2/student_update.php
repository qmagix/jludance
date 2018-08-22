<?php


function enable_user_update($tb){
	$qstr="ALTER TABLE `".$tb."` ADD `user_update_code` VARCHAR( 16 ) NULL ,
	ADD `user_link_accessed` INT( 8 ) NOT NULL DEFAULT '0',
	ADD `user_updated` TINYINT( 4 ) NOT NULL DEFAULT '0',
	ADD `user_update_ip` VARCHAR( 16 ) NULL ;";
	//make db change
}

function prt_update_form_on_code_match($sid,$code,$db){
	$q="SELECT * FROM students WHERE id='$sid' AND user_update_code='$code'";
	//echo $q;
	$re=$db->query($q);
	$r=mysqli_fetch_assoc($re);
	//var_dump($r);
	if($r){
		//update info
		$remoteip=$_SERVER['REMOTE_ADDR'];
		$qupdate="UPDATE students SET user_link_accessed=user_link_accessed+1, user_update_ip='$remoteip' WHERE id='$sid'";
		$db->query($qupdate);
		if($r['user_updated']>0){
			$link=$_SERVER['REQUEST_URI']."&cmd=ureq";
			echo "For your protection, the student info update form can only be accessed once.<br>";
			echo "If you need to update your info, click the following link to request a new link code: <br> ";
			echo "<a href=\"$link\">Please send a new update link</a> <br>";

			echo " Thank You! ";

		}else{
		   //create form
			print "<form method='post' action='student_update.php' name='form' id=\"kidinfo\">";
			print "<b>Name :</b> <input type='text' name='name' size='40' value=\"".$r['name']."\"> ";
			print "<b>Birth date  :</b> <input type='text' name='birthday' size='12' value=\"".$r['birthday']."\">(format: YYYY-MM-DD)<br>";
			print "<b>Guardian name :</b> <input type='text' name='guardian' size='40' value=\"".$r['guardian']."\"> <br>";
			print "<b>Email:</b> <input type='text' name='email' size='40' value=\"".$r['email']."\"> (please make sure it is correct for general communication)<br>";
			print "<b>Phone:</b> <input type='text' name='phone' size='40' value=\"".$r['phone']."\"> (please make sure correct for emergency contact) <br>";
			print "<b>Address :</b> <input type='text' name='address' size='40' id='address' value=\"".$r['address']."\">  <br>";
			print "<b>City, Zipcode:</b> <input type='text' name='city' size='40' id='city' value=\"".$r['city']."\">  <br>";
			//print "<b>Lat :</b> <input type='text' name='latitude' size='20' id='latitude' value=\"".$r['latitude']."\"> ";
			//print "<b>Lng :</b> <input type='text' name='longitude' size='20' id='longitude' value=\"".$r['longitude']."\"> <br><br>";
			print "<input type='hidden' name='id' value=\"".$r['id']."\">";

			print "<input type='submit' name='submit' value='Update'>";
			//print "<input type='button' value='Geocode' onclick=\"codeAddress();\">";
			print "</form><br>";


		}
	}
	return $r;

}

function qmail($to, $subject,$message){
	$headers = 'From: info@jludance.com' . "\r\n" .
			'Reply-To: info@jludance.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

	@mail($to, $subject, $message, $headers);
}

function recordUpdateEmailAlert($db,$table,$entryid,$parr,$to){
	$q="SELECT * FROM $table WHERE id='$entryid'";
	$re=$db->query($q);
	$r=mysqli_fetch_assoc($re);
	$cmp="";
	foreach ($parr as $key=>$val){
		if(array_key_exists($key, $r)){
			$cmp.=$key." : ".$r[$key]." -- to -- ".$val;
		}else{
			$cmp.=$key." : "."NOT FOUND in $table"." -- to -- ".$val;
		}
		$cmp.="\n\r";
	}

	//email
	$subject="Record updated for $entryid in ".$table;

	$message="Here is the change of record for $entryid \n\r\n\r";
	$message.=$cmp;
	qmail($to, $subject,$message);


}

function random_string($len = 8)
{
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$str = '';
		for ($i=0; $i < $len; $i++)
		{
		  $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
		}
		return $str;
}

function emailSecureInfoUpdateRequest($db, $table,$id,$msgheader,$linkheader){
	//generate a new passcode
	$newcode=random_string();
	$qupdate="UPDATE $table SET user_updated=0, user_update_code='$newcode' WHERE id='$id'";
	$re=$db->query($qupdate);
	//gen the update link
	$link=$linkheader."id=$id"."&key=".$newcode;
	//email user the link
	//$to=$db->getValue("students",'email',$id);
	$q="SELECT * FROM $table WHERE id='$id'";
	$re=$db->query($q);
	$r=mysqli_fetch_assoc($re);
	$to=$r['email'];
	//email
	$subject="Record updated for ".$r['name']." requested";

	$message=$msgheader."Here is the link you can use for updating the information: \n\r";
	$message.=$link;
	$message.="\r\n\r\n Thank you, \r\n - Jun Lu Performing Arts";
	qmail($to, $subject,$message);

	//qmail("huangq@gmail.com","processed enw update request for ".$to,$adminmsg);

}

function pushActiveStudentInfoUpdateRequests($db,$studentid=0){
	$linkheader='http://www.jludance.com/admin/student_update.php?';
	$msgheader="Dear all,\r\n";
	$msgheader.="During the process of registering students for competition events,";
	$msgheader.=" we found our system is missing birthday information for some students";
	$msgheader.=" and also some emergency contact phone numbers or other information have been outdated. ";
	$msgheader.="For simplicity, we developed a system for all of our active students to update your contact information online.";
	$msgheader.="If your family have multiple students in our school. Please expect to receive multiple emails that containing unique links.";
	$msgheader.=" (And if you run into any problem please let Sam@jludance.com know). \n\r ";
	$adminmsg="";
	if($studentid>0){
		emailSecureInfoUpdateRequest($db, "students",$studentid,$msgheader,$linkheader);
		$adminmsg.="update request sent to id ".$studentid;
		$subject="1 info update request sent";
	}else{
		//send to all
		$q="SELECT * from students WHERE status='active'";
		$re=$db->query($q);
		$r=mysqli_fetch_array($re);

		$k=0;

		while ($row = mysqli_fetch_array($re, mysqli_ASSOC)) {
			emailSecureInfoUpdateRequest($db, "students",$row['id'],$msgheader,$linkheader);
			$k=$k+1;
			$adminmsg.=$k.": ".$row['name']." (".$row['id'].") ".$row['email']."\r\n";
		}
		$subject=$k." info update request sent";
	}
	qmail("huangq@gmail.com",$subject,$adminmsg);
}

function adminCodeRegen($db,$codename){
	$newcode=random_string();
	$qupdate="UPDATE admincodes SET code='$newcode' WHERE codename='$codename'";
	$re=$db->query($qupdate);
}

function adminCodeExist($db,$codename,$code){
	$q="SELECT * FROM admincodes WHERE codename='$codename'";
	$re=$db->query($q);
	$r=mysqli_fetch_assoc($re);
	return $r['code']==$code;
}

session_start();

require("../tools/html.form.classes.php");
require("../tools/html.func.php");
require("../tools/db.classes.php");
include("../guestbook/dbconf.php");
require_once('local.php');
define("SITE_TITLE","JUN LU PERFORMING ARTS");
print_html_header_with_css("Student Info Update", "studio.css");

if($_POST['name']){
	$name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $city=$_POST['city'];
    $guardian=$_POST['guardian'];
    $bday=$_POST['birthday'];
    $address=$_POST['address'];
    $sid=$_POST['id'];
   $lat=$_POST['latitude'];
   $lng=$_POST['longitude'];
    $s="UPDATE students SET ";
    $s.="name='$name', ";
    $s.="email='$email', ";
    $s.="phone='$phone', ";
    $s.="city='$city', ";
    $s.="birthday='$bday', ";
    $s.="guardian='$guardian', ";
    $s.="address='$address', ";
    $s.="latitude='$lat',";
    $s.="longitude='$lng', ";
    $s.="user_updated=user_updated+1 ";
    $s.="WHERE id='$sid'";
    //    echo $s;
    $db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
    //grab old and email alert update for record
    recordUpdateEmailAlert($db,'students',$sid,$_POST,'huangq@gmail.com');

    $res=$db->query($s);

    echo "$name info has been updated. Thank You!";

}else{
	$id=$_GET['id'];
	$code=mysqli_escape_string($_GET['key']);
	$cmd=$_GET['cmd'];
	$lencode=strlen($code);
	switch ($cmd){
		case "ureq":
			//echo $cmd;
			if($_SESSION['ureq']){
				echo "You will receive an email with a new update link soon. If not please email info@jludance.com for assistance. ";
			}else{
				//if id&code valid, regen code, send new update link
				if(is_numeric($id) && $lencode >0 && $lencode<16){
					$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
					$q="SELECT * FROM students WHERE id='$id'";
					$re=$db->query($q);
					$r=mysqli_fetch_assoc($re);
					//var_dump($r);
// 					if($db->getValue('students', 'user_update_code', $id)==$code){
				    if($r['user_update_code']==$code){
// 				    	$uri=$_SERVER['REQUEST_URI'];
// 				    	$uris=explode("?", $uri);
						emailSecureInfoUpdateRequest($db, 'students',$id,'','http://www.jludance.com/admin/student_update.php?');
						$_SESSION['ureq']=true;
						echo "A new email has been sent to your email addresses on our record. Thank you!";
					}else{
						die("No match. Please email info@jludance.com for assistance.");
					}
				}

			}
			break;
		case "singlerequest":
			if($id>0){
				$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
			    pushActiveStudentInfoUpdateRequests($db,$id);
			    echo "request has been sent. ";
			}else{
				die ("bad id");
			}
			break;
		case "adminpushupdaterequest":
			$admincode=$_GET['admincode'];
			$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
            if(adminCodeExist($db,'userinfoupdaterequest',$admincode)){
            	adminCodeRegen($db,'userinfoupdaterequest');
            	pushActiveStudentInfoUpdateRequests($db);
            	echo "request will be pushed to many people ";
            }else{
            	echo "Wrong code";
            }
            break;
		default:

			if(is_numeric($id) && $lencode >0 && $lencode<16){
				$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

				prt_h2("Please update student info, make sure all is correct and up to date.");

				if(prt_update_form_on_code_match($id,$code,$db)){
					echo "<hr/>";
				}else{
					die("No match");
				}

			}else{
				die("Wrong URL");
			}
	}
}


?>
