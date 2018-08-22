<?php
$tblist="classes";
$tbstudent="students";
$studentlistlink="participation";

error_reporting(-1);
ini_set('display_errors', 'On');

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

	$mail=mail($to, $subject, $message,$headers);
	//@mail($to, $subject, $message, $headers);
	if($mail){
	 echo "success";
	  }else{
	 echo "failed.";
	  }
}

function qmail0($to, $subject,$message){
	$headers = 'From: info@jludance.com' . "\r\n" .
			'Reply-To: info@jludance.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

  echo "To:---------<br>";
	echo $to."<br>";
	echo "Subject:-------------<br>";
	echo $subject."<br>";
	echo "Message:-------------<br>";
	echo nl2br($message)."<br>";

}

function classemail($db, $id, $subjecttmp, $messagetmp, $tbstudent="students", $studentlistlink="participation"){
	$allinlist=$db->getTableColumns($studentlistlink,array('sid'),'WHERE cid='.$id);
	$sids=array();
	foreach ($allinlist as $row){
		$sids[]=$row['sid'];
	}
	if(empty($sids)){

	}else{
		$idstr=implode(",",$sids);
		$q="SELECT * FROM ".$tbstudent." WHERE id IN (".$idstr.")";
		$r=$db->query($q);
		$i=1;
		while ($row=mysql_fetch_assoc($r)){
			$to=$row['email'];
			//$to="qingfenghuang@msn.com";
			$totest="huangq@gmail.com";
      $subject=str_replace("{{name}}", $row['name'],$subjecttmp);
			$message=str_replace("{{name}}", $row['name'],$messagetmp);
			$pieces=explode(" ", $row['name']);
			$firstname=$pieces[0];
			$message=str_replace("{{firstname}}", $firstname,$message);
			$message=stripslashes($message);
			$subject=stripslashes($subject);
			qmail0($to, $subject,$message);
			//qmail($totest, $subject,$message);
			echo "<hr>".$i." Message sent ".$i." to ".$to.": ".$subject."--".$message."<hr>";
      $i++;
		}
	}
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

function showListEmails($db,$tblist,$id,$tbstudent="students",$studentlistlink="participation"){
	$allinlist=$db->getTableColumns($studentlistlink,array('sid'),'WHERE cid='.$id);
	$sids=array();
	foreach ($allinlist as $row){
		$sids[]=$row['sid'];
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

function showEmailFields($actionlink){
	$str="<form method=\"POST\" action=\"".$actionlink."\">";
	$str.="Subject:<br>";
	$str.="<input type=\"text\" name=\"subject\" value=\"\"><br>";
	$str.="Message:<br>";
	$str.="<textarea name=\"message\"></textarea><br>";
	$str.="<input type=\"submit\" value=\"Send\">";
  echo $str;
}


function showListSelectionTable($db,$tblist,$id,$tbstudent="students",$studentlistlink="participation"){
	$title=$db->getValue($tblist, 'title', $id);
	$allactivestudents=$db->getTableColumns($tbstudent,array('id','name','birthday'),"WHERE status='active'");
	$allinlist=$db->getTableColumns($studentlistlink,array('sid'),'WHERE cid='.$id);
	$sids=array();
	foreach ($allinlist as $val){
		$sids[]=$val['sid'];
	}
	$r=exclusiveSelect($allactivestudents,$sids);
	echo "<h2> Students in ".$title." </h2>";
	echo "<table class=\"simpleborder\" width=800><tr><th>All (click to select)</th><th>Selected(click to deselect)</th></tr><tr><td valign=\"top\">";
// 	sqlRowArrayListView($r['left'],'name',"sublists.php?cmd=select&list_id=$id&");
	sqlRowArrayListViewMFields($r['left'],array('name','birthday'),"classlists.php?cmd=select&list_id=$id&");
	echo "</td><td valign=\"top\">";
// 	sqlRowArrayListView($r['right'],'name',"sublists.php?cmd=deselect&list_id=$id&");
	sqlRowArrayListViewMFields($r['right'],array('name','birthday'),"classlists.php?cmd=deselect&list_id=$id&");
	showListEmails($db,$tblist,$id);
	echo "<hr>";
	showEmailFields("classlists.php?cmd=email&list_id=$id");
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
				$q="DELETE FROM ".$studentlistlink." WHERE cid='$list_id' AND sid='$student_id'";
				$res=$db->query($q);
				showListSelectionTable($db,$tblist,$list_id);
				break;
			case "select":
				$list_id=$_GET['list_id'];
				$student_id=$_GET['id'];
				$q="INSERT INTO ".$studentlistlink." (ctype, cid, sid) VALUES ('children', '$list_id','$student_id')";
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
			case "email":
			  $list_id=$_GET['list_id'];
				#echo $list_id;
				#echo $_POST['subject'];
				#echo $_POST['message'];
				classemail($db, $list_id, $_POST['subject'], $_POST['message']);
			  break;
			default:
				$q='SELECT * from '.$tblist." where visible=1 order by level asc";
				$re=$db->query($q);
				echo "<h2> Avaliable Lists </h2>";
				listView($re,'title','classlists.php?cmd=view&');
				oneRowAddForm();

			}

}




?>
