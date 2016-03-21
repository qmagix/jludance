<?php


?>
<?

require("tools/html.form.classes.php");
include("dbconf.php");
require("tools/db.classes.php");
$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);

//$var=$db->getTableColumn('classes','id','title');
$var=$db->getTableColumn('classes','id','title','ages="adult" and visible=1 and yearid="2009b"');
$cb=new Checkboxes($var);
$_SESSION['checkboxes']=$cb;

srand((double)microtime()*1000000); 

if(!empty($_SESSION["secret_post_code"])){
}else{
		$_SESSION["secret_post_code"]=rand(0,100000);
}

?>
<center>
<?
$cid=$_GET["cid"];
?>


<div class="container text-left">
  <h3 id="about">Jun Lu Performing Arts Academy</h3><br>
  <div class="row">
    <div class="col-sm-12">
      <div class="well">

<?

    if (!isset($_POST['submit']))
    {
     print "<h2> Dance class signup (Adult classes) </h2>";
     print "<form method='post' action='index.php?a=signup_adults' name='form'>";
     print "<b>Name :</b> <input type='text' name='name' size='40'><br>";
     print "<b>Email:</b> <input type='text' name='email' size='40'> (please make sure it is correct)<br>";
     print "<b>Phone:</b> <input type='text' name='phone' size='40'> (optional) <br>";
     print "<b><br>Interested classes: </b><br>";
    
$cb->prt();

     print "<br><br>";
     print "<b>Message:</b><br>";
     print "<textarea rows='6' name='comment' cols='68'>(please let us know if you have any questions ...) </textarea><br>";
      print("<img src=\"tools/genimage4.php\">"."What is the spam fighter
    number on the left?<input size=21 maxlength=10 type=\"text\" name=\"secretcode\"><br>");
     print "<input type='submit' name='submit' value='submit'>";
     print "</form><br>";
   }
  else if (isset($_POST['submit']))
  {
    $scode=$_POST['secretcode'];
	if($scode!=$_SESSION["secret_post_code"]){
       unset($_SESSION["secret_post_code"]);
       die("bad visual code, please go back and re-enter the correct number. Sorry for inconvenience. We do get quite a bit spam so have to do this.");
	}else{
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $email=$_POST['email'];
    $comment=$_POST['comment'];

$s='';
if(isset($_SESSION['checkboxes'])){
    $cb=$_SESSION['checkboxes'];
 	//$cb->prt();
 	foreach ($cb->selection as $key=>$value){
 		//print $key."=".$_POST[$key]."<br>";
 		if($_POST[$key]=='on'){
 			$cb->check($key);
 		}
 	}
    $s=$cb->getCheckedIdsInStr();
}

   
    if(!$email ||!$name )
    {
      print "<font color='red'>Name or email not entered, please go back and check again</font><br>";
    }
   else
    {
     $r=$_SERVER["REMOTE_ADDR"];
     $day=date("D M d, Y H:i:s");
    $addmessage="INSERT INTO signups ";
    $addmessage.="(name, email, phone, message, interest, time, IP) VALUES ";
    $addmessage.="('$name','$email','$phone','$comment','$s','$day','$r')";
     	
     mysql_query($addmessage) or die(mysql_error());
     //print $addmessage;
     print "Thanks for signing up, look forward to seeing you in class soon.<br> ";
	//print $chinese." - ".$ballet." - ".$flamenco." - ".$jazz." - ".$troupe;

     $subject="new sign up";
     $to="jludance@gmail.com";
    	
    $message="Name: ".$name."---".$comment."+email:+".$email."-phone:-".$phone;	
    //$message.=" --- Interest $s";   
    $message.=" --- Interest <a href=\"http://www.jludance.com/admin/listclass.php?tb=classes&id=$s\">$s</a>";  
    @mail($to, $subject, $message);

    }
}
  }
?>
</div>
</div>
</div>
</div>
