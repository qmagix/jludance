<?php
/*
 * Created on Jan 27, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 require_once("header0.php");
 


$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

$cmd=$_GET['cmd'];
$sid=$_GET['sid'];
//echo $cmd."-".$sid."<hr/>";
switch ($cmd){
case "attend":
  $cid=$_GET['cid'];
  $sid=$_GET['sid'];
  $ctype=$_GET['ctype'];
  $query="INSERT INTO participation (ctype,cid,sid) VALUES ('$ctype','$cid','$sid')";
  $db->query($query);  
  $_SESSION['flash']="student $sid ($name)  has been added to class $cid";
  emailadmin($cmd,$_SESSION['flash']);
  studentStatusUpdate($db,$sid);
  header("Location: update.php");     
  break;
case "drop":
  $cid=$_GET['cid'];
  $sid=$_GET['sid'];
  $query="DELETE FROM participation WHERE cid='$cid' and sid='$sid'";
  $db->query($query);  
  $_SESSION['flash']="student $sid ($name) has been removed from class $cid";
  emailadmin($cmd,$_SESSION['flash']);
  studentStatusUpdate($db,$sid);
  header("Location: update.php");   
  break;
case "towaiting":
    $q="UPDATE students SET status='waiting' WHERE id='$sid'";
    $db->query($q);  	
 	//echo "<h2> Students on waiting list</h2>".$q;
    emailadmin($cmd,$q);
 	header("Location: liststudents.php?s=waiting");   
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
    $sid=$_POST['sid'];
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
    $s.="longitude='$lng' ";
    $s.="WHERE id='$sid'";
    //    echo $s;
    $res=$db->query($s);
    
    $_SESSION['flash']="$name info has been updated";
    
    }
  header("Location: registerforclass.php");     
}
?>
