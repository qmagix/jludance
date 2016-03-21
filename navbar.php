<?php
function gen_active_menu($pid){
  ?>
  <li<?php echo $pid=="home"? ' class="active"':''?>><a href="index.php">Home</a></li>
  <li<?php echo $pid=="signup"? ' class="active"':''?>><a href="index.php?a=signup">Signup</a></li>
  <li<?php echo $pid=="schedule"? ' class="active"':''?>><a href="index.php#schedule">Schedule</a></li>
  <li<?php echo $pid=="summercamps"? ' class="active"':''?>><a href="index.php?a=summercamp">SummerCamps</a></li>
  <li<?php echo $pid=="gallery"? ' class="active"':''?>><a href="index.php?a=gallery">Gallery</a></li>
  <li<?php echo $pid=="news"? ' class="active"':''?>><a href="index.php#news">News</a></li>
  <li<?php echo $pid=="about"? ' class="active"':''?>><a href="index.php?a=about">About</a></li>
<?php
}
?>


 <nav class="navbar navbar-inverse navbar-fixed-top navbar-custom">
   <div class="container-fluid">
     <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </button>
       <a class="navbar-brand" href="#">
         JLU Dance
         <img style="max-width:90px;" src="images/jlu_logo2.png">
       </a>
     </div>
     <div class="collapse navbar-collapse" id="myNavbar">
       <ul class="nav navbar-nav">
<?php gen_active_menu($page_id);?>
       </ul>
       <ul class="nav navbar-nav navbar-right">
         <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
       </ul>
     </div>
   </div>
 </nav>
