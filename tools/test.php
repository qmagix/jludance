<?php
/*
 * Created on Nov 14, 2006
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 require("html.form.classes.php");
 require("db.classes.php");
 session_start();
 
 $db=new Database('localhost','qingfeng',"root","");
 $var=$db->getTableColumn('kidsclasses','symbol','title');
 //var_dump($var);
 
 //$cb=new Checkboxes();
// Checkboxes::prtOne("n","label");
// Checkboxes::prtOneChecked("n2" ,"la  bel2");
 
 echo "<hr>";
 
$arr2=array(
	"v1"=>"Item 1",
	"v2"=>"Item 2",
	"v3"=>"Item 3"
);
$cb=new Checkboxes($var);
//$cb->setSelection($arr2);
if(isset($_SESSION['checkboxes'])){
	//$cb=$_SESSION['checkboxes'];
}else{
	$cb=new Checkboxes($var);
	$_SESSION['checkboxes']=$cb;
}
//$_SESSION['checkboxes']=$cb;
if(isset($_SESSION['name'])){
	$name=$_SESSION['name'];
}else{
	$name=new Entryline('Name: ','name');
	$_SESSION['name']=$name;
}
if(isset($_SESSION['email'])){
	$email=$_SESSION['email'];
}else{
	$email=new Entryline('Email: ','email');
	$_SESSION['email']=$email;
}
if(isset($_SESSION['phone'])){
	$phone=$_SESSION['phone'];
}else{
	$phone=new Entryline('Phone: ','phone');
	$_SESSION['phone']=$phone;
}

$name=new Entryline('Name','name');
$_SESSION['name']=$name;
echo "<hr>";
$f=new Form("submissionprocessor.php","input");
$f->addBlock($cb);
$f->addBlock($name);
$f->addBlock($email);
$f->addBlock($phone);
$f->prt();
?>
