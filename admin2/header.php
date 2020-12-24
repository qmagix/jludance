<?php
/*
 * Created on Jan 28, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
session_start();

if($_SESSION['login']){
require("../tools/html.form.classes.php");
require("../tools/html.func.php");
require("../tools/db.classes.php");
include("../dbconf.php");
require_once('local.php');
define("SITE_TITLE","JUN LU PERFORMING ARTS");
print_html_header_with_css("Studio Management Panel", "studio.css");
?>
<div id="menu" style="background-color: #afeeee">
  <h2>Management Panel</h2>
  <ul>
    <li>Add a new student: [
  <a href="addstudent.php?t=kids"> Children </a> ] [
    <a href="addstudent.php?t=adult">Adult </a>]
    </li>
    <li>Manage enrollment(students changing class, adding or droping class):
    [<a href="manageclass.php?t=c"> Children's classes </a> ]
    [<a href="manageclass.php?t=a">Adult's classes </a>]
    [<a href="manageclass.php?t=z">All </a>]
    [<a href="listsignups.php">New Signups</a>]
    [<a href="sublists.php">Lists</a>]
    [<a href="classlists.php">Class Lists</a>]
    </li>
    <li>Get emails: [<a href="emailgroups.php?t=c">Children's classes </a>]
  [<a href="emailgroups.php?t=a">Adult classes </a> ]
 [<a href="liststudents.php?s=active">All active</a>  ]
 [<a href="liststudents.php?s=activec">Active C </a>  ]
 [<a href="liststudents.php?s=activea">Active A </a>  ]
 [<a href="liststudents.php?s=waiting">Waiting </a>  ]
 [<a href="liststudents.php?s=done">Non-active</a>  ]
  [<a href="emailgroups.php?t=z">Everyone </a>  ]
    </li>
    <li> Add a class [<a href="addclass.php?t=kids">Children's class</a>]
    [<a href="addclass.php?t=adult">Adult's class</a>]</li>
    <li> [<a href="summercamp.php">Summercamp Signups</a>]</li>
    <li> <a href="logout.php">logout</a></li>
  </ul>
  </div>
  <hr>
<?
}else{
	header("Location: index.php");
}
?>
