<?php
/*
 * Created on Jul 21, 2008
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
 $s=$_GET['s'];
 $sid=$_GET['sid'];
 include("header.php");
 $db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
switch ($s){
case 'active':
 	$q="SELECT * FROM students WHERE status='active'";
    echo "<h2> Active students</h2>";
    break;
case 'activec':
	$q="SELECT * FROM students WHERE status='active' and birthday>'1992-01-01'";
    echo "<h2> Active children students</h2>";
	break;
case 'activea':
   $q="SELECT * FROM students WHERE status='active' and birthday<'1992-01-02'";
    echo "<h2> Active adult students</h2>";
	break;
	break;
case 'done':
    $q="SELECT * FROM students WHERE status='done'";
 	echo "<h2> Students no longer taking class</h2>";
 	break;
case 'waiting':
    $q="SELECT * FROM students WHERE status='waiting'";
 	echo "<h2> Students on waiting list</h2>";
 	break;
case 'towaiting':
    $q="UPDATE students SET status='waiting' WHERE id='$sid'";
				
 	echo "<h2> Students on waiting list</h2>".$q;
 	break;
case 'null':
    $q="SELECT * FROM students WHERE status is NULL";
 	echo "<h2> Students has null status (to be fixed)</h2>";
 	break;
default:
	$q="SELECT * FROM students";
 	echo "<h2> All Students (Present and Past)</h2>";
}
/*
 if($s=='active'){
    $q="SELECT * FROM students WHERE status='active' and birthday>'2001'";
    echo "<h2> Active students</h2>";
 }else{
 	$q="SELECT * FROM students WHERE status='done'";
 	echo "<h2> Students no longer taking class</h2>";
 }
 */
			//echo $q; 
 $re=$db->query($q);
 //echo "<h2> Active students</h2>";
 $emails=listList($re);
 echo "<hr> $emails";
?>
