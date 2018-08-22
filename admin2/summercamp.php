<?php
/*
 * Created on Jan 27, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

function listCurrentCamps($db){
	$i=0;
	$q="SELECT * FROM summercamp WHERE visible=1";
	//echo $q;
	$re=$db->query($q);
	$cids=array();
	$str="Existing Camps: <ul>";
	while ($row=mysqli_fetch_assoc($re)){
		$cids[]=$row['id'];
		$str.="<li><a href=\"summercamp.php?id=".$row['id']."\"> ".$row['title']."</a> "." </li>";

	}
	$str.="</ul>";
	echo $str;
	return $cids;
}

function listSignupByCamp($cid,$db){
	$marker=":".$cid;
	//$q="SELECT * FROM summercampsignup WHERE interest='$marker'";
	$q="SELECT * FROM summercampsignup WHERE interest='$marker' and id>153"; //tentative hack
	$re=$db->query($q);
	$cids=array();
	$str="Existing Signups for Camp $marker: <table>";
	$str.="<tr><th>Name</th><th>Age</th><th>Phone</th><th>Notes</th></tr>";
	$k=0;
	$emails="";
	while ($row=mysqli_fetch_assoc($re)){
		$str.="<tr>";
		$str.="<td>".$row['name']."</td><td>".$row['age']."</td><td>".$row['phone']." </td><td>".$row['message']." </td><td>";
		$str.="</tr>";
		$k=$k+1;
		$emails.=$row['email'].",<br>";
	}
	$str.="</table>";
	$str.="<b>Total students: ".$k."</b><hr>";

	$str.=$emails;
	echo $str;
}



require_once("header.php");


$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

prt_h2("Summer Camp View");


listCurrentCamps($db);
echo "<hr>";
if(isset($_GET['id'])){
	listSignupByCamp($_GET['id'],$db);
}
?>
