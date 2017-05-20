<?
//
require("tools/html.form.classes.php");
require("tools/db.classes.php");
include("dbconf.php");

$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
$var=$db->getTableColumn('classes','id','title','ages="kids" and visible=1 and yearid="2009b"');
$cb=new Checkboxes($var);
$_SESSION['checkboxes']=$cb;

srand((double)microtime()*1000000); 

if(!empty($_SESSION["secret_post_code"])){
}else{
	
		$_SESSION["secret_post_code"]=rand(0,100000);
}


?>
<div class="container text-left">
  <h3 id="about">Jun Lu Performing Arts Academy</h3><br>
  <div class="row">
    <div class="col-sm-12">
      <div class="well">
<?

    if (!isset($_POST['submit']))
    {
     print "<h2> Children's dance & music class sign up </h2>";
     print "<form method='post' action='index.php?a=signup_kids' name='form'>";
     print "<b>Name :</b> <input type='text' name='name' size='40'> ";
     print "<b>Age  :</b> <input type='text' name='age' size='10'><br>";
     print "<b>Guardian name :</b> <input type='text' name='guardian' size='40'> <br>";
     print "<b>Email:</b> <input type='text' name='email' size='40'> (please make sure it is correct)<br>";
     print "<b>Phone:</b> <input type='text' name='phone' size='40'> (optional) <br>";
     print "<b>City :</b> <input type='text' name='city' size='40'> (optional) <br><br>";

     print "<b><br>Interested classes: </b><br>";

     $cb->prt();

     print "<b>Message:</b><br>";
     print "<textarea rows='6' name='comment' cols='68'>(please let us know your hour preference and other inquiries here ...) </textarea><br>";
      print("<img src=\"tools/genimage4.php\">"."What is the spam fighter
    number on the left?<input size=21 maxlength=10 type=\"text\"
     name=\"secretcode\"><br>");
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
    $city=$_POST['city']; 
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
    $guardian=$_POST['guardian'];
    $age=$_POST['age']; 		
    if(!$email ||!$name )
    {
      print "<font color='red'>Name or email not entered, please go back and check again</font><br>";
    }
   else
    {
     $r=$_SERVER["REMOTE_ADDR"];
     $day=date("D M d, Y H:i:s");
    $addmessage="INSERT INTO signups";
    $addmessage.="(name, email, phone, message, city, interest, time,IP, age, guardian) VALUES ";
    $addmessage.="('$name','$email','$phone','$comment', '$city','$s','$day','$r','$age', '$guardian')";
    
     
     mysql_query($addmessage) or die(mysql_error());
     //print $addmessage;
     print "Thanks for signing up, look forward to seeing you in class
     soon. <br> ";
	 
	//print $chinese." - ".$ballet." - ".$flamenco." - ".$jazz." - ".$troupe;

     $subject="new kids class sign up";
     $to="jludance@gmail.com";
     //$message="Name: ".$name."---".$comment;	
     $message="Name: ".$name."---".$comment."+email:+".$email."--phone:--".$phone."=Guardian=".$guardian;
     
	  //$message.=" --- Interest <a href=\"http://www.jludance.com/admin/listclass.php?tb=kidsclasses&id=$s\">$s</a>";
	  
	  $cids=split(':',$s);
	  $message.="----Interests:\n ";
	  foreach ($cids as $value) {
	    if($value){
	       $message.="<a href=\"http://www.jludance.com/admin/listclass.php?tb=classes&id=$value\">$value</a> -- <br>\n";
		 }
      }	  
	  
     @mail($to, $subject, $message);

    }}
  }
?>
</div>
</div>
</div>
</div>




