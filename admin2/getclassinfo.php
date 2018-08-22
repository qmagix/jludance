<?php
/*
 * Created on Jan 27, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

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

 if(isset($_SESSION['flash'])){
 	echo "<div class=\"flash\"> ".$_SESSION['flash']."</div>";
 	unset($_SESSION['flash']);
 }
 }

 if($_SESSION['class_id']){
      print_nav_bracket("getAttendanceTable.php?id=".$_SESSION['class_id'], "Get Attendance Table");
      echo "<br/>";
	 $n=listStudents($_SESSION['class_id'],$db);
	 if($n==0){
	 	//echo " <a href=\"setinvisible.php\">Set Invisible</a>";
	 }

 echo "<hr/>";
 listEmails($db,$_SESSION['class_id']);
 //listAdultStudents($db);
 echo "<hr/>";
 listStudentNames($_SESSION['class_id'],$db);
 echo "<hr/>";
 echo "<a href=\"classmigrate.php?fromcid=".$_SESSION['class_id']."\">Migrate</a>";
 }
?>
