<?php
require("../tools/html.form.classes.php");
require("../tools/html.func.php");
require("../tools/db.classes.php");
include("../guestbook/dbconf.php");
require_once('local.php');
$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

  $r=getChildrenStudentInfo($db);
    $names=$r['name'];
    $addresses=$r['address'];
    echo "<ul>";
    foreach ($names as $key=>$val){
    	
    	echo "<li>msg[".$key."]=\"".$names[$key]."-".$addresses[$key]."\";</li>";
    }
    echo "</ul>";
?>