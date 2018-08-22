<?php
/*
 * Created on Jan 27, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
require_once("header.php");
require_once("../tools/time.func.php");

$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

prt_h2("Attendance and tuition info");
$_SESSION['sid']=$_GET['sid']?$_GET['sid']:$_SESSION['sid'];
echo "<hr/>";
listClassesBySid($_SESSION['sid'],$db);
echo "<hr>";
listTuitionBySid($_SESSION['sid'],$db,8,2009);
?>
