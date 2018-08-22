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
 $title=getTitle($_SESSION['class_tb'],$_SESSION['class_id'],$db);
 echo "<h1> $title</h1>";
 
 if($_SESSION['flash']){
 	echo "<div class=\"flash\"> ".$_SESSION['flash']."</div>";
 	unset($_SESSION['flash']);
 }
 
 if($_SESSION['student_type']=='adult'){
 	prt_kid_info_form();
 }
 if($_SESSION['student_type']=='children'){
 	prt_kid_info_form();
 }
 
 register_by_id_form();
 
 listStudents($_SESSION['class_id'],$db);
 
 echo "<hr/>";
 
 listChildrenStudents($db);
 listAdultStudents($db);
?>

  <hr>
  <h2> Register</h2>
  <ul>
    <li>
  <a href="addstudent.php?t=c">Add a Student (Children) </a> 
  <br/>
    </li>
    <li><a href="addstudent.php?t=a">Add a Student (Adult) </a> <br/>
    </li>
  </ul>
