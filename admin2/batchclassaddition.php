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

$clist=explode("\n",$_POST['classlist']);
$info['yearid']=$_POST['yearid'];
$info['visible']=1;

foreach($clist as $row){
	//echo $row."<br>";
	if(strlen($row)>5){
	$info['title']=$row;
	//
	if (stristr($row, 'adult') === FALSE){
		$info['ages']="kids";
	}else{
		$info['ages']="adult";
	}
	$db->saveItem("classes",$info);
	echo $row." -- ".$info['ages']." added <br>";
	}
}

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


 }
?>
