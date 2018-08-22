<?php
/*
 * Created on Jul 21, 2008
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
 $s=$_GET['s'];
 include("header.php");
 $db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
 if($s=='active'){
    $q="SELECT * FROM students WHERE status='active'";
    echo "<h2> Active students</h2>";
 }else{
 	$q="SELECT * FROM students WHERE status='done'";
 	echo "<h2> Students no longer taking class</h2>";
 }
			//echo $q;
 $re=$db->query($q);
 //echo "<h2> Active students</h2>";
 $emails=listList($re);
 echo "<hr> $emails";
?>
