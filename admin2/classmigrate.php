<?php
/*
 * Created on Dec 29, 2008
 *
 * Author: Qingfeng Huang
 * Email: qingfeng@qhuang.com
 * 
 */
 
//require("../tools/html.form.classes.php");
//require("../tools/db.classes.php");
// session_start();
// 
//include("../guestbook/dbconf.php");
require_once("header.php");
$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

 
 //$fromtb="kidsclasses";
 $fromtb="classes";
 $totb="classes";
 $stype="kids";
 $from_cid=$_GET['fromcid'];
 $yearid=$config['yearid_next'];
 //$yearid='2009b';
 if(isset($_GET['yearid'])){
	$yearid=$_GET['yearid'];
 }
 //$fromtb=$_GET['fromtb'];
 $to_cid="";
 $radiofieldname="tocid";
 
$var=$db->getTableColumn($totb,'id','title','visible=1 and yearid="'.$yearid.'"');
$cb=new Checkboxes($var);
$cb=new Radioboxes($radiofieldname,$var);
$_SESSION['checkboxes']=$cb;

if (!isset($_POST['submit'])){
     print "<form method='post' action='classmigrate.php' name='form'>";
     $title=$db->getValue($fromtb,"title",$from_cid);
     print "<b>Original class : $title</b>  ";
     
     print "<input type=hidden name='fromcid' value=$from_cid>";
     print "<b><br>move to class: </b><br>";
     $cb->prt();
     print "<input type='submit' name='submit' value='submit'>";
     print "</form><br>";
}else{
	echo "moving from ".$_POST['fromcid'];
	
	if(isset($_SESSION['checkboxes'])){
	    $cb=$_SESSION['checkboxes'];
	 	//$cb->prt();
	 	foreach ($cb->selection as $key=>$value){
	 		//print $key."=".$_POST[$key]."<br>";
	 		if($_POST[$radiofieldname]==$key){
	 			$cb->check($key);
	 		}
	 	}
	    $s=$cb->getCheckedValue();
	    echo " to ".$s;
	    echo "<hr>";
	    if($db->getNumRows("participation", "cid='$s'")==0){
		    $q="UPDATE participation SET cid='$s' WHERE cid=".$_POST['fromcid'];
		    $db->query($q);
		    echo "If no error, class migrate done";
	    }else{
	    	echo "There are cid=$s already, skip";
	    }
    }
}

?>
