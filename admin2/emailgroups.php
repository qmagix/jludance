<?php
/*
 * Created on Jan 27, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 

require_once("header.php");

$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
 
 if($_GET['t']){
 	switch($_GET[t]){
 	case 'a': 
 	  $_SESSION['student_type']="adult";
 	  $_SESSION['class_tb']="classes";
 	  
 	  prt_h2("Email ".$_SESSION['student_type']." student -- which class?");
	 $var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="adult" and yearid="'.$config['yearid'].'"');
	  //$var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="adult"');
	 prt_list_deepener($var,"getclassinfo.php");
 	  break;
 	case 'c':
 	  $_SESSION['student_type']="children";
 	  $_SESSION['class_tb']="classes";
 	  
 	  prt_h2("Email ".$_SESSION['student_type']." student -- which class?");
	 $var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="kids" and yearid="'.$config['yearid'].'"'.' order by level');
	 //$var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="kids"');
	 prt_list_deepener($var,"getclassinfo.php");
 	  break;
 	case 'z':
 	  $_SESSION['student_type']="children";
 	  listEmails($db);
 	  break;
 	default:
 	  die ("Unknown student type");
 	}
	 //prt_h2("Email ".$_SESSION['student_type']." student -- which class?");
	 //$var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1');
	 //prt_list_deepener($var,"getclassinfo.php");

 }
?>

  
  