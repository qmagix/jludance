<?php
/*
 * Created on Jul 21, 2008
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
 include("header.php");
 $db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
 $q="SELECT * FROM students WHERE status='active'";
			//echo $q;
 $re=$db->query($q);
 echo "<h2> Active students</h2>";
 listList($re);
?>
