<?php
include("../includes/html.dblist.php");
include("../guestbook/admin/connect.php");

if(isset($_GET['tb']) && isset($_GET['id'])){
  //listItem($db,$_GET['tb'],$_GET['id']);
  $keys=array("title","time","ages");
  listItem($db,$_GET['tb'],$_GET['id'],$keys);
}

?>
