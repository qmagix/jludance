<?php
$tblist="sublists";
$tbstudent="students";
$studentlistlink="studentsinlists";

function initTables($db){
	$qstr="CREATE TABLE `sublists` (
			  `id` int(8) NOT NULL auto_increment,
			  `title` varchar(128) NOT NULL default '',
			  PRIMARY KEY  (`id`)
			) TYPE=MyISAM AUTO_INCREMENT=1";
	$qstr2="CREATE TABLE  `studentsinlists` (
			`list_id` INT( 8 ) NOT NULL ,
			`student_id` INT( 8 ) NOT NULL
			) ";
	//make db change
	$db->query($qstr);
	$db->query($qstr2);
}

function listView($r,$titlefield,$actionlink){
	$str="All: <ul>";
	$i=0;
	$emails="";
	while ($row=mysql_fetch_assoc($r)){
		$sid=$row['id'];
		$str.="<li><a href=\"".$actionlink."id=$sid\"> ".$row[$titlefield]."</a></li>";
		$i++;
	}
	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";
}

function sqlRowArrayListView($rows,$titlefield,$actionlink){
	$str="<ul>";
	$i=0;
	$emails="";
	foreach ($rows as $row){
		$sid=$row['id'];
		$str.="<li><a href=\"".$actionlink."id=$sid\"> ".$row[$titlefield]."</a></li>";
		$i++;
	}
	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";
}

function sqlRowArrayListViewMFields($rows,$titlefields,$actionlink){
	$str="<ul>";
	$i=0;
	$emails="";
	foreach ($rows as $row){
		$sid=$row['id'];
		$ts="";
		foreach ($titlefields as $t){
			$ts.=$row[$t]." : ";
		}

		$str.="<li><a href=\"".$actionlink."id=$sid\"> ".$ts."</a></li>";
		$i++;
	}
	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";
}

function oneRowAddForm(){
	print "<form method='post' action='sublists.php' name='form' id=\"addlist\">";
	print "<b>Add a new list :</b> <input type='text' name='title' size='40' value=\"\"> ";
	print "<input type='submit' name='submit' value='Add'>";
	print "<input type='hidden' name='cmd' value='add'>";
	//print "<input type='button' value='Geocode' onclick=\"codeAddress();\">";
	print "</form><br>";
}

function qmail($to, $subject,$message){
	$headers = 'From: info@jludance.com' . "\r\n" .
			'Reply-To: info@jludance.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

	@mail($to, $subject, $message, $headers);
}


function exclusiveSelect($listall,$selectedids){
	if(empty($selectedids)){
		$r['left']=$listall;
		$r['right']=array();
	}else{
		$a=array();
		$b=array();
		foreach ($listall as $key=>$val){
			if(in_array($val['id'],$selectedids)){
				$a[]=$val;
			}else{
				$b[]=$val;
			}
		}
		$r['left']=$b;
		$r['right']=$a;
	}
	return $r;
}

function showListEmails($db,$tblist,$id,$tbstudent="students",$studentlistlink="studentsinlists"){
	$allinlist=$db->getTableColumns($studentlistlink,array('student_id'),'WHERE list_id='.$id);
	$sids=array();
	foreach ($allinlist as $row){
		$sids[]=$row['student_id'];
	}
// 	$title=$db->getValue($tblist, 'title', $id);
// 	echo "<h2> Emails for Students in ".$title." </h2>";
	if(empty($sids)){

	}else{
		$idstr=implode(",",$sids);
		$q="SELECT * FROM ".$tbstudent." WHERE id IN (".$idstr.")";
		$r=$db->query($q);
		$emails="";
		$namephones="";
		while ($row=mysql_fetch_assoc($r)){
			$emails.=$row['email'].",<br>";

			$namephones.=$row['name']." : ".$row['phone'].",<br>";
		}

		echo $emails;

		echo $namephones;
	}
}


function showListSelectionTable($db,$tblist,$id,$tbstudent="students",$studentlistlink="studentsinlists"){
	$title=$db->getValue($tblist, 'title', $id);
	$allactivestudents=$db->getTableColumns($tbstudent,array('id','name','birthday'),"WHERE status='active'");
	$allinlist=$db->getTableColumns($studentlistlink,array('student_id'),'WHERE list_id='.$id);
	$sids=array();
	foreach ($allinlist as $val){
		$sids[]=$val['student_id'];
	}
	$r=exclusiveSelect($allactivestudents,$sids);
	echo "<h2> Students in ".$title." </h2>";
	echo "<table class=\"simpleborder\" width=800><tr><th>All (click to select)</th><th>Selected(click to deselect)</th></tr><tr><td valign=\"top\">";
// 	sqlRowArrayListView($r['left'],'name',"sublists.php?cmd=select&list_id=$id&");
	sqlRowArrayListViewMFields($r['left'],array('name','birthday'),"sublists.php?cmd=select&list_id=$id&");
	echo "</td><td valign=\"top\">";
// 	sqlRowArrayListView($r['right'],'name',"sublists.php?cmd=deselect&list_id=$id&");
	sqlRowArrayListViewMFields($r['right'],array('name','birthday'),"sublists.php?cmd=deselect&list_id=$id&");
	showListEmails($db,$tblist,$id);
	echo "</td></tr></table>";
}


include("header.php");
$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);


if(isset($_POST['title'])){
	$cmd=$_POST['cmd'];

	switch ($cmd){
		case "add":
			$title=$_POST['title'];
			$q="INSERT INTO ".$tblist." (title) VALUES ('$title')";
			//$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
			//email alert update for record
 			qmail('huangq@gmail.com','New List Created',$title);
			$res=$db->query($q);
			break;
		default:

	}
	$q='SELECT * from '.$tblist;
	$re=$db->query($q);
	echo "<h2> Avaliable Lists </h2>";
	listView($re,'title','sublists.php?cmd=view&');
	oneRowAddForm();

}else{
	if(isset($_GET['id'])){
		$id=$_GET['id'];
	}
  if(isset($_GET['key'])){
		$code=mysql_escape_string($_GET['key']);
		$lencode=strlen($code);
	}

 $cmd="none";
	if(isset($_GET['cmd'])){
		$cmd=$_GET['cmd'];
	}
			switch ($cmd){
			case "deselect":
				$list_id=$_GET['list_id'];
				$student_id=$_GET['id'];
				$q="DELETE FROM ".$studentlistlink." WHERE list_id='$list_id' AND student_id='$student_id'";
				$res=$db->query($q);
				showListSelectionTable($db,$tblist,$list_id);
				break;
			case "select":
				$list_id=$_GET['list_id'];
				$student_id=$_GET['id'];
				$q="INSERT INTO ".$studentlistlink." (list_id, student_id) VALUES ('$list_id','$student_id')";
				$res=$db->query($q);
				showListSelectionTable($db,$tblist,$list_id);
				break;
			case "view":
				showListSelectionTable($db,$tblist,$id);
				break;
			case "getemails":
				$title=$db->getValue($tblist, 'title', $id);
				echo "<h2> Emails for Students in ".$title." </h2>";
				showListEmails($db,$tblist,$id);
				break;
			case "init":
				initTables($db);
				echo "List Tables Inited";
				qmail('huangq@gmail.com','List Tables Inited',"Sublist Tables Inited");
				break;
			default:
				$q='SELECT * from '.$tblist;
				$re=$db->query($q);
				echo "<h2> Avaliable Lists </h2>";
				listView($re,'title','sublists.php?cmd=view&');
				oneRowAddForm();

			}

}




?>
