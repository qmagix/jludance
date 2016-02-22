<?php
/*
 * Created on Nov 15, 2006
 * Project tools
 * 
 * Author: Qingfeng Huang
 * Email: qingfeng@ieee.org
 */
 require("html.form.classes.php");
 require("db.classes.php");
 session_start();

 if(isset($_SESSION['checkboxes'])){
 	$cb=$_SESSION['checkboxes'];
 	$cb->prt();
 	foreach ($cb->selection as $key=>$value){
 		//print $key."=".$_POST[$key]."<br>";
 		if($_POST[$key]=='on'){
 			$cb->check($key);
 		}
 	}
 	$cb->prt();
 	$s=$cb->getCheckedIdsInStr();
 	if(isset($_SESSION['name'])){
 		$n=$_SESSION['name'];
 		$n->setValue(trim($_POST[$n->getName()]));
 		if($n->getValue()==null){
 			echo "Please enter your name!";
 		}else{
 			$a=array("name"=>$n->getValue(),"interest"=>$s);
 			$db=new Database('localhost','test',"","");
 			$db->saveItem("test",$a);
 		}
 	}
 }
 
?>
