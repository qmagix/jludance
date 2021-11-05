<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Jun Lu Performing Arts Academy</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
<link rel="manifest" href="site.webmanifest">
<link rel="mask-icon" href="safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">

  <link rel="stylesheet" href="css/bootstrap.min.css">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
      z-index: 99;
    }
    .navbar-custom {
       background-color: #CC3333;
       height: 50px!important;
       /* background-color: transparent;
        background: transparent;
        border-color: transparent;*/
       /* color: #FF7C0A;*/
    }

    .navbar-collapse{
      background-color: #CC3333;
    }

    .nav a{
              color: white !important;
              font-size: 1.5em !important;
          }


    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }

  .carousel-inner img {
      width: 100%; /* Set width to 100% */
      margin: auto;
      min-height:200px;
      max-height: 800px;
  }

  ul.faq li{
    font-weight: bold;
  }

  .footer {
     position: fixed;
     left: 0;
     bottom: 0;
     width: 100%;
     background-color: #FF000070;
     color: white;
     text-align: center;
  }

  /* Hide the carousel text when the screen is less than 600 pixels wide */
  @media (max-width: 600px) {
    .carousel-caption {
      display: none;
    }

    .navbar-brand img{
      width: 40px;
    }
  }

  @media (max-width: 1400px) {
    .nav a{
              color: white !important;
              font-size: 1.2em !important;
          }
  }

  @media (max-width: 1200px) {
    .nav a{
              color: white !important;
              font-size: 1em !important;
          }
  }

  /* over-write when navbar collpases*/
  @media (max-width: 1100px) {
  .navbar-header {
      float: none;
  }
  .navbar-left,.navbar-right {
      float: none !important;
  }
  .navbar-toggle {
      display: block;
  }
  .navbar-collapse {
      border-top: 1px solid transparent;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
  }
  .navbar-fixed-top {
      top: 0;
      border-width: 0 0 1px;
  }
  .navbar-collapse.collapse {
      display: none!important;
  }
  .navbar-nav {
      float: none!important;
      margin-top: 7.5px;
  }
  .navbar-nav>li {
      float: none;
  }
  .navbar-nav>li>a {
      padding-top: 10px;
      padding-bottom: 10px;
  }
  .collapse.in{
      display:block !important;
  }
}

  body { padding-top: 50px; }

  .fa {
  padding: 10px;
  font-size: 30px;
  width: 50px;
  text-align: center;
  border-radius: 20%;
  text-decoration: none;
  margin: 5px 5px;
}



.fa:hover {
    opacity: 0.7;
}

.fa-facebook {
  background: #3B5998;
  color: white;
}

.fa-twitter {
  background: #55ACEE;
  color: white;
}

.fa-google {
  background: #dd4b39;
  color: white;
}

.fa-camera {
  background: #007bb5;
  color: white;
}

.fa-youtube {
  background: #bb0000;
  color: white;
}



.fa-pinterest {
  background: #cb2027;
  color: white;
}
  </style>


</head>
<body>
