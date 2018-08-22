<?php
/*
 * Created on May 25, 2008
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 *
 */
require_once("header.php");

$yearid=$config['yearid'];

$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

 if($_GET['t']){
 	switch($_GET['t']){
 	case 'a':
 	  $_SESSION['student_type']="adult";
 	  $_SESSION['class_tb']="classes";

 	  prt_h2("Managing ".$_SESSION['student_type']." student -- which class?");
	 $var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="adult" and yearid="'.$yearid.'"');
	 //$var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="adult"');
	 $notes=getClassParticipationNotes(array_keys($var),$db);
	 //print_r($notes);
	 prt_list_deepener_with_notes($var,"getclassinfo.php",$notes);
	 echo "Total person-class: ".$notes['total'];
 	  break;
 	case 'c':
 	  $_SESSION['student_type']="children";
 	  $_SESSION['class_tb']="classes";

 	  prt_h2("Managing ".$_SESSION['student_type']." student -- which class?");
	 $var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="kids" and yearid="'.$yearid.'"'.' order by level');
	 //$var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="kids"');
	 $notes=getClassParticipationNotes(array_keys($var),$db);
	 //print_r($notes);
	 prt_list_deepener_with_notes($var,"getclassinfo.php",$notes);
	 //prt_list_deepener($var,"getclassinfo.php");
	 echo "Total person-class: ".$notes['total'];
 	  break;
 	case 'z':
 	  //$_SESSION['student_type']="children";
 	  listAllStudents($db);
 	  break;
    case 'y':
 	  //$_SESSION['student_type']="children";
 	  listAllClasses($db);
 	  break;
 	default:
 	  die ("Unknown student type");
 	}
	 //prt_h2("Email ".$_SESSION['student_type']." student -- which class?");
	 //$var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1');
	 //prt_list_deepener($var,"getclassinfo.php");

 }
?>
