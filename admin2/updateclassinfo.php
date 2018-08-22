<?php
/*
 * Created on Jun 23, 2008
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
require_once("header.php");

$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

if($_POST['title']){
	$info['title']=$_POST['title'];
 	  $_SESSION['class_tb']="classes";
	  $db->updateItem($_SESSION['class_tb'],$_POST['id'],$info);
	  prt_h2("Update class list");
	  $var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1');
	  prt_list_deepener($var,"getclassinfo.php");

 }else{
	if (isset($_GET['id']))
	{
		if(is_numeric($_GET['id'])){
		  $row=$db->getItem("classes",$_GET['id']);
		  
	     print "<div id=\"newclass\">New class info:";
	     print "<form method='post' action='updateclassinfo.php' name='form' id=\"addclassform1\">";
	     print "<b>Class name :</b> <input type='text' name='title' size='60' value='".$row['title']."'> </br>";
	     print " <input type='hidden' name='visible' value='1'>";
	     print " <input type='hidden' name='id' value='".$_GET['id']."'>"; 
	     print "<input type='submit' name='submit' value='submit'>";
	     print "</form></div>";
		}
	    
	 }
 }
?>
