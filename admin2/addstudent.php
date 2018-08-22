<?php
/*
 * Created on Jan 27, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
require_once("header.php");

$yearid=$config['yearid'];
$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

 if($_GET['t']){
 	switch($_GET['t']){
 	case 'adult':
 	  $_SESSION['student_type']="adult";
 	  $_SESSION['class_tb']="classes";
 	  break;
 	case 'kids':
 	  $_SESSION['student_type']="children";
 	  $_SESSION['class_tb']="classes";
 	  break;
 	default:
 	  die ("Unknown student type");
 	}
	 prt_h2("Registering new ".$_SESSION['student_type']." student -- which class?");
	 $var=$db->getTableColumn($_SESSION['class_tb'],'id','title','visible=1 and ages="'.$_GET['t'].'" and yearid="'.$yearid.'"'.' order by level');
	 prt_list_deepener($var,"registerforclass.php");

 }
?>
