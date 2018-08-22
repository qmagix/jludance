<?php
/*
 * Created on Jan 27, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once("header0.php");
 


function getCType($sid,$db){
	$q="SELECT * FROM participation WHERE sid='$sid' Limit 1";
	$res=$db->query($q);
	$row=mysql_fetch_assoc($res);
	return $row['ctype'];
}

$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);


$cmd=$_POST['cmd'];



switch($cmd){
case 'rbid':
  $sid=$_POST['sid'];
  $cid=$_SESSION['class_id'];
  $ctype=getCType($sid,$db);
  $query="INSERT INTO participation (ctype,cid,sid) VALUES ('$ctype','$cid','$sid')";
  $db->query($query);
    
  $_SESSION['flash']="$name has been added to class $cid";
  emailadmin($cmd,$_SESSION['flash']);
  header("Location: registerforclass.php");
  break;	 
default:
if($_POST['name']){
	$name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $city=$_POST['city']; 
    $guardian=$_POST['guardian'];
    $bday=$_POST['bday']; 
    $address=$_POST['address'];		
    $day=date("D M d, Y H:i:s");
    $addmessage="INSERT INTO students";
    $addmessage.="(name, email, phone,city, birthday, age, guardian,address,status) VALUES ";
    $addmessage.="('$name','$email','$phone', '$city','$bday','$age', '$guardian','$address','active')";
    emailadmin("new student added",$addmessage);
    $res=$db->query($addmessage);
    $sid=$db->lastInsterId();
    if($sid>0){
    $ctype=$_SESSION['student_type'];
    $cid=$_SESSION['class_id'];
    $query="INSERT INTO participation (ctype,cid,sid) VALUES ('$ctype','$cid','$sid')";
    $db->query($query);
    
    $_SESSION['flash']="$name has been added to class $cid";
    emailadmin("new student to class",$_SESSION['flash']);
    
    }
}    
header("Location: registerforclass.php");
}     
?>
