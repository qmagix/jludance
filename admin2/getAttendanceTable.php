<?php
require_once("header.php");
 
$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);


 if($_GET['id']){
 	$_SESSION['class_id']=$_GET['id'];
 	if($_SESSION['class_tb']){
 		$title=getTitle($_SESSION['class_tb'],$_SESSION['class_id'],$db);
 	}
 	$title=getTitle($_SESSION['class_tb'],$_SESSION['class_id'],$db);
 }
 if($_SESSION['class_id']){
 $title=getTitle($_SESSION['class_tb'],$_SESSION['class_id'],$db);
 echo "<h1> $title</h1>";
 
 if($_SESSION['flash']){
 	echo "<div class=\"flash\"> ".$_SESSION['flash']."</div>";
 	unset($_SESSION['flash']);
 }
 }
 
 if($_SESSION['class_id']){
	 //listStudentNames($_SESSION['class_id'],$db); 
	 echo genAttendanceTable($_SESSION['class_id'],$db,23);
	 echo "<hr/>";
	 
 }
?>