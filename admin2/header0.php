<?php
/*
 * Created on Jan 28, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 * 
 * used by *_process.php, could be eliminated after converting to ajax update version
 * 
 */
session_start();

if($_SESSION['login']){
	
}else{
	header("Location: index.php");
}

require("../tools/html.form.classes.php");
require("../tools/db.classes.php");
include("../guestbook/dbconf.php");
require_once('local.php');

?>