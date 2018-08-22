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

if(isset($_POST['t'])){
	$info['title']=$_POST['title'];
	$info['visible']=$_POST['visible'];
	$info['ages']=$_POST['t'];
	$info['yearid']=$_POST['yearid'];
 	switch($_POST['t']){
 	case 'adult':
 	  $_SESSION['student_type']="adult";
 	  $_SESSION['class_tb']="classes";
	  $db->saveItem($_SESSION['class_tb'],$info);
	  prt_h2("Updated ".$_SESSION['student_type']." class list");
	  $var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1');
	  prt_list_deepener($var,"getclassinfo.php");
 	  break;
 	case 'kids':
 	  $_SESSION['student_type']="children";
 	  $_SESSION['class_tb']="classes";
 	  $db->saveItem($_SESSION['class_tb'],$info);
 	  prt_h2("Updated ".$_SESSION['student_type']." class list");
	  $var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1');
	  prt_list_deepener($var,"getclassinfo.php");
 	  break;
 	case 'z':

 	  break;
 	default:
 	  die ("Unknown class type");
 	}


 }else{
if (isset($_GET['t']))
    {
     print "<div id=\"newclass\">New class info:";
     print "<form method='post' action='addclass.php' name='form' id=\"addclassform1\">";
     print "<b>Class name :</b> <input type='text' name='title' size='60'> </br>";
     print "<b>Session id :</b> <input type='text' name='yearid' size='60' value=\"".$config['yearid']."\"> </br>";
     print " <input type='hidden' name='visible' value='1'>";
     print " <input type='hidden' name='t' value='".$_GET['t']."'>";
     print "<input type='submit' name='submit' value='submit'>";
     print "</form></div>";

     switch($_GET['t']){
 	case 'adult':
 	  $_SESSION['student_type']="adult";
 	  $_SESSION['class_tb']="classes";

 	  prt_h2("Existing ".$_SESSION['student_type']." classes");
	 $var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="'.$_GET['t'].'" and yearid>="'.$config['yearid'].'"');
	 prt_list_deepener($var,"updateclassinfo.php");
 	  break;
 	case 'kids':
 	  $_SESSION['student_type']="children";
 	  $_SESSION['class_tb']="classes";

 	  prt_h2("Existing ".$_SESSION['student_type']." classes");
	 $var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="'.$_GET['t'].'" and yearid>="'.$config['yearid'].'"');
	 prt_list_deepener($var,"updateclassinfo.php");
 	  break;
 	case 'z':
 	  //$_SESSION['student_type']="children";
 	  listAllStudents($db);
 	  break;
 	default:
 	  die ("Unknown student type");
 	}
    }else{
    	echo "need to know class type";
    }
 }
?>
