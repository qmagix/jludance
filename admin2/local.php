<?php
/*
 * Created on Jan 27, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
//require_once("../tools/string.func.php");

function prt_kid_info_form(){
	 if (!isset($_POST['submit']))
    {

     print "<div id=\"newstudent\">New student info:";
     print "<form method='post' action='register_process.php' name='form' id=\"registerform1\">";
     print "<b>Name :</b> <input type='text' name='name' size='40'> ";
     print "<b>Birth date  :</b> <input type='text' name='bday' size='12'><br>";
     print "<b>Guardian name :</b> <input type='text' name='guardian' size='40'> <br>";
     print "<b>Email:</b> <input type='text' name='email' size='40'> (please make sure it is correct)<br>";
     print "<b>Phone:</b> <input type='text' name='phone' size='40'> (optional) <br>";
     print "<b>Address :</b> <input type='text' name='address' size='40'> (optional) <br>";
     print "<b>City :</b> <input type='text' name='city' size='40'> (optional) <br><br>";
     print "<input type='submit' name='submit' value='submit'>";
     print "</form></div>";
    }else{
    	echo "submit result to be determined";
    }
}

function register_by_id_form(){
	print "<div id=\"newenrollment\">Enroll existing student:";
	 print "<form method='post' action='register_process.php' name='form' id=\"registerform2\">";
     print "<b>Student Id :</b> <input type='text' name='sid' size='40'> ";
     print "<input type='hidden' name='cmd' size='40' value=\"rbid\"> ";
     print "<input type='submit' name='submit' value='submit'>";
     print "</form></div>";
}

function prt_gmap_functions(){

}

function prt_update_form($sid,$db){
	$q="SELECT * FROM students WHERE id='$sid'";
		//echo $q;
	$re=$db->query($q);
	$r=mysqli_fetch_assoc($re);
	print "<form method='post' action='update_process.php' name='form' id=\"kidinfo\">";
     print "<b>Name :</b> <input type='text' name='name' size='40' value=\"".$r['name']."\"> ";
     print "<b>Birth date  :</b> <input type='text' name='bday' size='12' value=\"".$r['birthday']."\"><br>";
     print "<b>Guardian name :</b> <input type='text' name='guardian' size='40' value=\"".$r['guardian']."\"> <br>";
     print "<b>Email:</b> <input type='text' name='email' size='40' value=\"".$r['email']."\"> (please make sure it is correct)<br>";
     print "<b>Phone:</b> <input type='text' name='phone' size='40' value=\"".$r['phone']."\"> (optional) <br>";
     print "<b>Address :</b> <input type='text' name='address' size='40' id='address' value=\"".$r['address']."\"> (optional) <br>";
     print "<b>City :</b> <input type='text' name='city' size='40' id='city' value=\"".$r['city']."\"> (optional) <br>";
     print "<b>Lat :</b> <input type='text' name='latitude' size='20' id='latitude' value=\"".$r['latitude']."\"> ";
     print "<b>Lng :</b> <input type='text' name='longitude' size='20' id='longitude' value=\"".$r['longitude']."\"> <br><br>";
     print "<input type='hidden' name='sid' value=\"".$r['id']."\">";

     print "<input type='submit' name='submit' value='Update'>";
     print "<input type='button' value='Geocode' onclick=\"codeAddress();\">";
     print "</form><br>";
     return $r;
}

function prt_map($address){
	echo '<div id="map_canvas" style="height:200px;top:3px;width:200px"></div>';
	echo '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>';
	echo '<script type="text/javascript" src="gmap.js"></script>';
	echo '<script type="text/javascript">addAddress("'.$address.'","'.$address.'")</script>';
}

function prt_update_form_with_map($sid,$db){
	print "<table><tr><td>";
	$r=prt_update_form($sid,$db);
	print "</td><td>";
	$address=$r['address'].",".$r['city'];
    prt_map($address);
    print "</td></tr></table>";
}

function prt_attendmore_form($sid,$db){

}

function getTitle($tb,$id,$db){
	$query="SELECT * FROM $tb WHERE id='$id'";
	$r=$db->query($query);
	$row=mysqli_fetch_assoc($r);
	return $row['title'];
}
function getClassInfo($id,$db){
	$query="SELECT * FROM classes WHERE id='$id'";
	$r=$db->query($query);
	$row=mysqli_fetch_assoc($r);
	return $row;
}

function getClassParticipationNotes($ids,$db){
	$notes=array();
	$k=0;
	foreach ($ids as $cid){
        $query="SELECT * FROM participation WHERE cid='$cid'";
        //echo $query;
	    $res=$db->query($query);
		$notes[$cid]=mysqli_num_rows($res);
		//echo mysqli_num_rows($res);
		$k=$k+$notes[$cid];
	}
	$notes['total']=$k;
	//print_r($notes);
	return $notes;
}


function inWaiting($db,$sid){
	$q="SELECT * from students where status='waiting' and id='$sid'";
    $res=$db->query($q);
    return mysqli_num_rows($res)>0;
}

function listClassesBySid($sid,$db){
	$query="SELECT * FROM participation WHERE sid='$sid'";
	$res=$db->query($query);
	$str="Enrolled classes: <ul>";
	$i=0;
	while ($row=mysqli_fetch_assoc($res)){
		$cid=$row['cid'];
		//if($row['ctype']=='children'){
			//$title=getTitle("classes",$cid,$db);
		//}
		//if($row['ctype']=='adult'){
		//	$title=getTitle("classes",$cid,$db);
		//}
		$title=getTitle("classes",$cid,$db);
		$str.="<li><a href=\"registerforclass.php?id=$cid\"> ".$title."</a>" .
				" [<a href=\"update_process.php?cmd=drop&sid=$sid&cid=$cid\">drop</a>]</li>";
		$i++;
	}
	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";
	if($i==0){
		if(!inWaiting($db,$sid)){
		  echo "<a href=\"update_process.php?cmd=towaiting&sid=$sid\">To waiting list</a>";
		}
	}
}
function getClassesBySid($sid,$db){
	$query="SELECT * FROM participation WHERE sid='$sid'";
	$res=$db->query($query);
	$str="<ul>";
	$i=0;
	while ($row=mysqli_fetch_assoc($res)){
		$cid=$row['cid'];
		//if($row['ctype']=='children'){
		//$title=getTitle("classes",$cid,$db);
		//}
		//if($row['ctype']=='adult'){
		//	$title=getTitle("classes",$cid,$db);
		//}
		$title=getTitle("classes",$cid,$db);
		$str.="<li><a href=\"registerforclass.php?id=$cid\"> ".$title."</a>" .
				" </li>";
		$i++;
	}
	$str.="</ul>";
	return $str;
}


function listTuitionBySid($sid,$db,$month,$year){
	$query="SELECT * FROM participation WHERE sid='$sid'";
	$res=$db->query($query);
	$str="Enrolled classes: <ul>";
	$i=0;
	while ($row=mysqli_fetch_assoc($res)){
		$cid=$row['cid'];
		//if($row['ctype']=='children'){
			//$title=getTitle("classes",$cid,$db);
		//}
		//if($row['ctype']=='adult'){
		//	$title=getTitle("classes",$cid,$db);
		//}
		$c=getClassInfo($cid,$db);
		$day=findDay($c['title']);
		$days=getWeekdaysInMonth($year,$month,$day);
		$str.="<li>".$c['title'].", hrs:".$c['hrs'].", $day has $days in Month $month"."</li>";

		$i++;
	}
	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";

}
function listMoreClassesToEnroll($sid,$db, $yearid='2009a'){

	$q1="SELECT * FROM students WHERE id='$sid'";
	$res=$db->query($q1);
	$row=mysqli_fetch_assoc($res);
	//echo $row['birthday']."<br>;
	$x=split('-',$row['birthday']);
	$delta=date('Y')-$x[0];
	//echo (date('Y')-$x[0])."years diff";
	$query="SELECT * FROM participation WHERE sid='$sid'";
	$res=$db->query($query);
	$rcid=array();
	$stype=null;

	while ($row=mysqli_fetch_assoc($res)){
		$rcid[]=$row['cid'];
		$stype=$row['ctype'];
	}
	$str="Click to Enroll in the respective class: ";
	if ($stype==null){
		if($delta<18){
			$stype='children';
		}
	}
	echo $str;
	if($stype=='children'){
	  $_SESSION['student_type']="children";
 	  $_SESSION['class_tb']="classes";
	}else{
	  $_SESSION['student_type']="adult";
 	  $_SESSION['class_tb']="classes";
	}
	  $var=$db->getTableColumn($_SESSION['class_tb'],'id','title',"visible=1 and yearid='".$yearid."'");
	  //prt_list_deepener2($var,"update_process.php?cid=","cmd=attend&sid=$sid&ctype=$stype");
	  prt_excludable_list_deepener($var,"update_process.php?cid=",$rcid,"cmd=attend&sid=$sid&ctype=$stype");


}
//2003-06-26 to 06/26/2003
function dateFormatChange1($datein){
	$tokens=explode("-", $datein);
	return $tokens[1]."/".$tokens[2]."/".$tokens[0];
}

function listStudents($cid,$db){
	$query="SELECT * FROM participation WHERE cid='$cid'";
	$res=$db->query($query);
	$str="Existing Students: <ul>";
	$i=0;
	while ($row=mysqli_fetch_assoc($res)){
		$sid=$row['sid'];
		$q="SELECT * FROM students WHERE id='$sid'";
		//echo $q;
		$re=$db->query($q);
		$r=mysqli_fetch_assoc($re);
		$str.="<li><a href=\"update.php?sid=$sid\"> ".$r['name']."</a> (".dateFormatChange1($r['birthday']).")</li>";
		$i++;
	}
	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";
	return $i;
}
function listStudentNames($cid,$db){
	$query="SELECT * FROM participation WHERE cid='$cid'";
	$res=$db->query($query);
	$str="Existing Students: <br/>";
	$i=0;
	while ($row=mysqli_fetch_assoc($res)){
		$sid=$row['sid'];
		$q="SELECT * FROM students WHERE id='$sid'";
		//echo $q;
		$re=$db->query($q);
		$r=mysqli_fetch_assoc($re);
		//$str.="<li>".$r['name']."</li>";
//		$str.="".$r['name']."<br/>";
		$str.="".$r['name'].", ";
		$i++;
	}
	//$str.="</ul>";
	echo $str;
	//echo "Total = ".$i."<br/>";
}
function getStudentNames($cid,$db){
	$query="SELECT * FROM participation WHERE cid='$cid'";
	$res=$db->query($query);
	$names=array();
	while ($row=mysqli_fetch_assoc($res)){
		$sid=$row['sid'];
		$q="SELECT * FROM students WHERE id='$sid'";
		//echo $q;
		$re=$db->query($q);
		$r=mysqli_fetch_assoc($re);
		//$str.="<li>".$r['name']."</li>";
		$names[]=$r['name'];
	}
	return $names;
}

function genTableRow($rowname, $cols){
	$str="<tr><td>".$rowname."</td>";
	for ($i=1;$i<$cols;$i++){
		$str.="<td>.</td>";
	}
	$str.="</tr>";
	return $str;
}
function genTableHeaderRow($colname, $cols){
	$str="<tr>";
	$str.="<th>".$colname."</th>";

	for ($i=1;$i<$cols;$i++){
		$str.="<th>".$i."</th>";
	}
	$str.="</tr>";
	return $str;
}
function genAttendanceTable($cid, $db, $cols){
	$names=getStudentNames($cid,$db);
	$str="<table id=\"attendance\">";
	$str.= genTableHeaderRow('Name', $cols)."";

	foreach ($names as $name){
		$str.= genTableRow($name,$cols);
	}
	$str.="</table>";
	return $str;
}
function showAttendanceTable2($cid, $db, $cols){
	$names=getStudentNames($cid,$db);
	$str="<table>";
	foreach ($names as $name){
		$str.= genTableRow($name,$cols);
	}
	$str.="</table>";
}
function listList($r){
	$str="In the list: <ul>";
	$i=0;
	$emails="";
	while ($row=mysqli_fetch_assoc($r)){
		$sid=$row['id'];
		$str.="<li><a href=\"update.php?sid=$sid\"> ".$row['name']."</a></li>";
		$i++;
		$emails.=$row['email'].",<br>";
	}
	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";
	return $emails;
}

function listAllStudents($db){
	$i=0;
	$q="SELECT * FROM students";
			//echo $q;
	$re=$db->query($q);
	$str="Existing Students: <ul>";
	while ($row=mysqli_fetch_assoc($re)){
	    $str.="<li><a href=\"update.php?sid=".$row['id']."\"> ".$row['name']."</a></li>";
		$i++;
	}
	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";
}
function listAllClasses($db){
	$i=0;
	$q="SELECT * FROM participation";
			//echo $q;
	$re=$db->query($q);
    $cls=array();
    while ($row=mysqli_fetch_assoc($re)){
	    $cls[$row['cid']] +=1;
	}

	$str="Existing Classes: <ul>";
	foreach ($cls as $cl=>$num){
		$q="SELECT * from classes WHERE id='$cl'";
		$re=$db->query($q);
		$row=mysqli_fetch_assoc($re);
		$str.="<li><a href=\"getclassinfo.php?id=".$row['id']."\"> ".$row['title']."</a> [$num] - ".$row['visible']."-".$row['yearid']." </li>";
	    $i++;
	}

	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";
}

/* cid is class id */
function listEmails($db,$cid=null){
	$str="Existing Students Emails:<br/><br/>";
	$i=0;
	$emails=array();
	if($cid){
		$query="SELECT * FROM participation WHERE cid='$cid'";
		$res=$db->query($query);
		while ($row=mysqli_fetch_assoc($res)){
			$sid=$row['sid'];
			$q="SELECT * FROM students WHERE id='$sid'";
			//echo $q;
			$re=$db->query($q);
			$r=mysqli_fetch_assoc($re);
			$str.=$r['email'].",<br>";
			$i++;
			$emails[]=$r['email'];
		}
		$str.="<br/>";
	}else{
		$q="SELECT * FROM students";
			//echo $q;
		$re=$db->query($q);
		while ($row=mysqli_fetch_assoc($re)){
			$str.=$row['email'].",<br>";
			$i++;
			$emails[]=$row['email'];
		}
	}

	echo $str;
	echo "Total = ".$i."<br/>";
	echo "<hr> Concatnated: <br/>";
	echo concat_array_unique($emails,",");
}

function inParticipation($db,$sid){
	$q="SELECT * FROM participation WHERE sid='$sid'";
	$re=$db->query($q);
	return $re!=null && mysqli_num_rows($re)>0;
}

function runStudentStatusUpdate($db){
	$q="SELECT * FROM students";
			//echo $q;
	$re=$db->query($q);
	while ($row=mysqli_fetch_assoc($re)){
			$sid=$row['id'];
			if (inParticipation($db,$sid)){
				$q="UPDATE students SET status='active' WHERE id='$sid'";
				$db->query($q);
			}else{
				$q="UPDATE students SET status='done' WHERE id='$sid'";
				$db->query($q);
			}
	}
}
function studentStatusUpdate($db,$sid){
			if (inParticipation($db,$sid)){
				$q="UPDATE students SET status='active' WHERE id='$sid'";
				$db->query($q);
			}else{
				$q="UPDATE students SET status='done' WHERE id='$sid'";
				$db->query($q);
			}
}
function studentWaitingStatusUpdate($db,$sid){
			if (inParticipation($db,$sid)){
				$q="UPDATE students SET status='active' WHERE id='$sid'";
				$db->query($q);
			}else{
				$q="UPDATE students SET status='waiting' WHERE id='$sid'";
				$db->query($q);
			}
}

function concat_array_unique($arr,$dlm){
	$res=array_unique($arr);
	$str=join($dlm,$res);
	return $str;
}
function listAdultStudents($db){
	$query="SELECT * FROM students WHERE guardian=''";
	$res=$db->query($query);
	$str="Existing Adult Students: <ul>";
	$i=0;
	while ($row=mysqli_fetch_assoc($res)){
		$sid=$row['id'];
		$str.="<li><a href=\"update.php?sid=$sid\"> ".$row['name']."</a></li>";
		$i++;
	}
	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";
}
function listChildrenStudents($db){
	$query="SELECT * FROM students WHERE guardian!=''";
	$res=$db->query($query);
	$str="Existing Children Students: <ul>";
	$i=0;
	while ($row=mysqli_fetch_assoc($res)){
		$sid=$row['id'];
		$str.="<li><a href=\"update.php?sid=$sid\"> ".$row['name']."</a></li>";
		$i++;
	}
	$str.="</ul>";
	echo $str;
	echo "Total = ".$i."<br/>";
}

function getChildrenStudentInfo($db){
	$query="SELECT * FROM students WHERE guardian!='' and status='active'";
	$res=$db->query($query);
	$ids=array();
	$names=array();
	$addresses=array();
	while ($row=mysqli_fetch_assoc($res)){
		$ids[]=$row['id'];
		$names[]=$row['name'];
		$addresses[]=$row['address'].",".$row['city'];
	}
	$r=array();
	$r['id']=$ids;
	$r['name']=$names;
	$r['address']=$addresses;
	return $r;
}

function prt_list_deepener($list,$fun,$suffix=null){
	$str="<ul>";
	if($suffix){
		foreach ($list as $key=>$value){
			$str.="<li> <a href=\"$fun?id=$key&$suffix\">$value</a></li>";
		}
	}else{
		foreach ($list as $key=>$value){
			$str.="<li> <a href=\"$fun?id=$key\">$value</a></li>";
		}
	}
	$str.="</ul>";
	echo $str;
}
function prt_list_deepener_with_notes($list,$fun, $notes, $suffix=null){
	$str="<ul>";
	if($suffix){
		foreach ($list as $key=>$value){
			$str.="<li> <a href=\"$fun?id=$key&$suffix\">$value</a> [ $notes[$key] ] </li>";
		}
	}else{
		foreach ($list as $key=>$value){
			$str.="<li> <a href=\"$fun?id=$key\">$value</a> [ ".$notes[$key]." ] </li>";
		}
	}
	$str.="</ul>";
	//print_r($notes);
	echo $str;
}
function prt_list_deepener2($list,$fun,$suffix=null){
	$str="<ul>";
	if($suffix){
		foreach ($list as $key=>$value){
			$str.="<li> <a href=\"$fun$key&$suffix\">$value</a></li>";
		}
	}else{
		foreach ($list as $key=>$value){
			$str.="<li> <a href=\"$fun$key\">$value</a></li>";
		}
	}
	$str.="</ul>";
	echo $str;
}

function prt_excludable_list_deepener($list,$fun,$excludekeys,$suffix=null){
	$str="<ul>";
		foreach ($list as $key=>$value){
			if (in_array($key,$excludekeys)){

			}else{
			  $str.="<li> <a href=\"$fun$key&$suffix\">$value</a></li>";
			}
		}
	$str.="</ul>";
	echo $str;
}
function prt_highlightable_list_deepener($list,$fun,$highlightkeys,$highlighter,$suffix=null){
	$str="<ul>";
		foreach ($list as $key=>$value){
			if (in_array($key,$highlightkeys)){
			  $str.="<li> <a href=\"$fun$key&$suffix\">$value</a> $highlighter</li>";
			}else{
			  $str.="<li> <a href=\"$fun$key&$suffix\">$value</a></li>";
			}
		}
	$str.="</ul>";
	echo $str;
}
function prt_h2($s){
	echo "<h2>$s</h2>";
}



$config['yearid']='2009b';
$config['yearid_next']='2010a';

//simple email in text format
function emailadmin($subject,$message){
$to="huangq@gmail.com";
@mail($to, $subject, $message);
}


?>
