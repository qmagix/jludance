<?php
/*
 * Created on Jan 27, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

 function prt_password_form(){
	print "<div id=\"passdiv\">Please login first:";
	 print "<form method='post' action='index.php' name='form' id=\"pass\">";
     print "<b>Password :</b> <input type='password' name='pass' size='40'> ";

     print "<input type='submit' name='submit' value='submit'>";
     print "</form></div>";
}
function emailAlert($to,$message){
	//email
	$subject="JLUdance admin access";

	$headers = 'From: info@jludance.com' . "\r\n" .
			'Reply-To: info@jludance.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

	@mail($to, $subject, $message, $headers);

}

session_start();
 //$_SESSION['login']=true;
if(isset($_SESSION['login']) && $_SESSION['login']){
?>
<div id="menu" style="background-color: #afeeee">
  <h2>Management Panel</h2>
  <ul>
    <li>Add a new student: [
  <a href="addstudent.php?t=c"> Children </a> ] [
    <a href="addstudent.php?t=a">Adult </a>]
    </li>
    <li>Manage enrollment(students changing class, adding or droping class):
    [<a href="manageclass.php?t=c"> Children's classes </a> ]
    [<a href="manageclass.php?t=a">Adult's classes </a>]
    [<a href="manageclass.php?t=z">All </a>]
    [<a href="listsignups.php">New Signups</a>]
    </li>
    <li>Get emails: [<a href="emailgroups.php?t=c">Children's classes </a>]
  [<a href="emailgroups.php?t=a">Adult classes </a> ]
 [<a href="liststudents.php?s=active">All active students </a>  ]
 [<a href="liststudents.php?s=done">All non-active </a>  ]
  [<a href="emailgroups.php?t=z">Everyone </a>  ]
    </li>
    <li> Add a class [<a href="addclass.php?t=c">Children's class</a>]
    [<a href="addclass.php?t=a">Adult's class</a>]</li>
     <li> [<a href="summercamp.php">Summercamp Signups</a>]</li>
    <li> <a href="logout.php">logout</a></li>
  </ul>
  </div>
  <hr>
<?php
}else{
 	if(isset($_POST['pass']) && $_POST['pass']=='jludanceadmin'){
 		$_SESSION['login']=true;
 		header("Location: index.php");
 	}else{
 		prt_password_form();
 		if(isset($_POST['pass']) && strlen($_POST['pass'])>0){
          emailAlert('huangq@gmail.com','Wrong password:'.$_POST['pass'].'\r\n'." From IP: ".$_SERVER['REMOTE_ADDR']);
        }
 	}
 }
?>
