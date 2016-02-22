<?php
session_start();
include("header.php");
$a=$_GET["a"];
$page_id="home";
include("navbar.php");

switch($a){
	case "signup":
		include("signup.php");
		break;
	case "signup_kids":
		include("signup_kids.php");
		break;
	case "signup_adults":
		include("signup_adults.php");
		break;
	case "about":
	 include("about.inc");
	 break;
	case "schedule":
	 //include("schedule.inc");
	 //include("schedule.php");
	 include("schedule_static.html");
	 break;
	case "scheduledynamic":
		//include("schedule.inc");
		include("schedule.php");
		//include("schedule_static.html");
		break;
	case "contact":
	 include("contact.inc");
	 break;
	case "news":
	 include("news.php");
	 break;
	case "gallery":
		include("xueyuanfengcai_en_new.htm");
	 break;
	case "photos07":
		include("slideshow07.inc");
	 break;
	case "kids":
	 include("kids.php");
	 break;
	case "adults":
	 include("adults.php");
	 break;
	case "ljq":
	 include("lujiaqing.htm");
	 break;
	case "summercamp":
	 include("summercamp.php");
	 break;
	case "c_details":
	 include("concert_details.inc");
	 break;
	case "c_staff":
	 include("concert_staff2009.htm");
	 break;
	case "c_faq":
	 include("concert_faq.htm");
	 break;
	case "c_moms":
		include("class_moms.htm");
		break;

	case "s_area":
		include("students_area.htm");
		break;
	case "job":
		include("hiring.php");
		break;
	default:
	 include("carousel.php");
	 include("frontpage.php");
}

include("footer.php");
?>
