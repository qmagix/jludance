<?php
/*
 * Created on Jan 27, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
require_once("header.php");
 

$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

prt_h2("Update student info");
$_SESSION['sid']=$_GET['sid']?$_GET['sid']:$_SESSION['sid'];
//prt_update_form($_SESSION['sid'],$db);
prt_update_form_with_map($_SESSION['sid'],$db);
echo "<br><a href=\"student_update.php?id=".$_SESSION['sid']."&cmd=singlerequest\"> Send a request to stduent to update info<a>";
echo "<hr/>";
listClassesBySid($_SESSION['sid'],$db);
echo "<hr>";
listMoreClassesToEnroll($_SESSION['sid'],$db,$config['yearid']);
?>
