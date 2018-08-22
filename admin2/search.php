Search for Student
<form method="post" action="search.php">
<input type="text" name="search_str" value=""/>
<input type="submit" value="Search">
</form>
<?php
require("../tools/html.form.classes.php");
require("../tools/html.func.php");
require("../tools/db.classes.php");
include("../dbconf.php");
require_once('local.php');

function searchDB($search_str,$db){
	$q="SELECT * FROM students WHERE name LIKE '$search_str%'";
	$re=$db->query($q);
	$cids=array();
	$str="Student name matching $search_str: <table>";
	$str.="<tr><th>Name</th><th>Status</th><th>Classes</th><th>Birthday</th><th>EMAIL</th><th>Phone</th><th>Guardian</th></tr>";
	$k=0;
	$emails="";
	while ($row=mysql_fetch_assoc($re)){
		$str.="<tr>";
		$str.="<td>".$row['name']."</td><td>".$row['status']."</td><td>".getClassesBySid($row['id'],$db)."</td><td>".$row['birthday']."</td><td>".$row['email']." </td><td>".$row['phone']." </td><td>".$row['guardian']." </td><td>";
		$str.="</tr>";
		$k=$k+1;

	}
	$str.="</table>";
	$str.="<b>Total name matches: ".$k."</b><hr>";
	//echo "<hr>";
	// email matches

	$q="SELECT * FROM students WHERE email LIKE '%search_str%'";
	$re=$db->query($q);
	$cids=array();
	$str.="Student email matching $search_str: <table>";
	$str.="<tr><th>Name</th><th>Status</th><th>Classes</th><th>Birthday</th><th>EMAIL</th><th>Phone</th><th>Guardian</th></tr>";
	$k=0;
	$emails="";
	while ($row=mysql_fetch_assoc($re)){
		$str.="<tr>";
		$str.="<td>".$row['name']."</td><td>".$row['status']."</td><td>".getClassesBySid($row['id'],$db)."</td><td>".$row['birthday']."</td><td>".$row['email']." </td><td>".$row['phone']." </td><td>".$row['guardian']." </td><td>";
		$str.="</tr>";
		$k=$k+1;

	}
	$str.="</table>";
	$str.="<b>Total email name matches: ".$k."</b><hr>";
	//echo $str;
	//echo "<hr>";
	$q="SELECT * FROM students WHERE guardian LIKE '$search_str%'";
	$re=$db->query($q);
	$cids=array();
	$str.="Student email guardian name matching $search_str: <table>";
	$str.="<tr><th>Name</th><th>Guardian</th><th>Status</th><th>Classes</th><th>Birthday</th><th>EMAIL</th><th>Phone</th></tr>";
	$k=0;
	$emails="";
	while ($row=mysql_fetch_assoc($re)){
		$str.="<tr>";
		$str.="<td>".$row['name']."</td><td>".$row['guardian']." </td><td>".$row['status']."</td><td>".getClassesBySid($row['id'],$db)."</td><td>".$row['birthday']."</td><td>".$row['email']." </td><td>".$row['phone']." </td><td>";
		$str.="</tr>";
		$k=$k+1;

	}
	$str.="</table>";
	$str.="<b>Total guardian name matches: ".$k."</b><hr>";

	$q="SELECT * FROM students WHERE city LIKE '$search_str%'";
	$re=$db->query($q);
	$cids=array();
	$str.="Student city matching $search_str: <table>";
	$str.="<tr><th>Name</th><th>Guardian</th><th>Status</th><th>Classes</th><th>Birthday</th><th>EMAIL</th><th>Phone</th></tr>";
	$k=0;
	$emails="";
	while ($row=mysql_fetch_assoc($re)){
		$str.="<tr>";
		$str.="<td>".$row['name']."</td><td>".$row['guardian']." </td><td>".$row['status']."</td><td>".getClassesBySid($row['id'],$db)."</td><td>".$row['birthday']."</td><td>".$row['email']." </td><td>".$row['phone']." </td><td>";
		$str.="</tr>";
		$k=$k+1;

	}
	$str.="</table>";
	$str.="<b>Total city name matches: ".$k."</b><hr>";
	echo $str;
}





if(isset($_POST["search_str"])){
echo $_POST["search_str"]."<hr>";
  $db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
  searchDB(mysql_real_escape_string($_POST["search_str"]),$db);
  //go to db
}
?>
