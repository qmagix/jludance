<?php
/*
 * Created on Jun 17, 2009
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
 /*
$db=new QDB('localhost','root','','qingfeng2');
$x=array('name','email','age','interest');
//$r= $db->getTableColumns('signups',$x);
//print_r($r);
$r= $db->showTableColumns('signups',$x);
echo($r);
*/ 
/*
include("../includes/html.dblist.php");
include("../guestbook/admin/connect.php");


  $keys=array('name','email','age','interest');
  echo listTableColumns($db,'signups',$keys);

*/
require_once("header.php");

$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
$x=array('name','email','age','interest','time');

$r= $db->showTableColumns('signups',$x, " order by id desc");
echo "<h2> Recent Signups</h2>";
echo($r);
?>
