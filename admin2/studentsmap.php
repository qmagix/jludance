<?php
function genGmapMarkerInputs(){
	for ($i=0;$i<3;$i++){
		
	}
}
require("../tools/html.form.classes.php");
require("../tools/html.func.php");
require("../tools/db.classes.php");
include("../guestbook/dbconf.php");
require_once('local.php');
$db=new Database(DB_SERVER,DB_NAME,DB_USER,DB_PASS);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<title>Google Maps JavaScript API v3 Example: Geocoding Simple</title>
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript"> 

 
  var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(37.37,-121.92);
    var myOptions = {
      zoom: 11,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  }
 
  function codeAddress() {
    var address = document.getElementById("address").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map, 
            position: results[0].geometry.location
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }

 
 
</script>
</head>
<body onload="initialize()">
  <div>
    <input id="address" type="textbox" value="San Jose, CA">
    <input type="button" value="Geocode" onclick="codeAddress()">
  </div>
<div id="map_canvas" style="height:90%;top:30px"></div>

<div id="badaddresses">
<ol id="addresslist">
</ol>
</div>

<script type="text/javascript"> 

  var addr = new Array();
  var msg = new Array();
  <?php 
    $r=getChildrenStudentInfo($db);
    $names=$r['name'];
    $addresses=$r['address'];
    foreach ($names as $key=>$val){
    	echo "addr[".$key."]=\"".$addresses[$key]."\";";
    	echo "msg[".$key."]=\"".$names[$key]."-".$addresses[$key]."\";";
    }
  ?>
//  addr[0]="4708 Strawberry Ln, San Jose, CA 95129";
//  msg[0]="home";
//  addr[1]="1600 Saratoga Ave, San Jose, CA 95129";
//  msg[1]="school";
//  addr[2]="1500 Saratoga Ave, San Jose, CA 95129";
//  msg[2]="test";
//  addr[3]="1501 Saratog Ave";
//  msg[3]="test bad";

  var badlist=document.getElementById("addresslist");
  </script>
<script type="text/javascript"> 
    function appendText(node,txt) {
	  node.appendChild(document.createTextNode(txt));
	}

	function appendElement(node,tag,id, htm) {
	  var ne = document.createElement(tag);
	  if(id) ne.id = id;
	  if(htm) ne.innerHTML = htm;
	  node.appendChild(ne);
	}

	var geocoder = new google.maps.Geocoder();
  function attachMessageToMarker(marker, message) {	 
	  var infowindow = new google.maps.InfoWindow(
	      { content: message,
	        size: new google.maps.Size(50,50)
	      });
	  google.maps.event.addListener(marker, 'click', function() {
	    infowindow.open(map,marker);
	  });
  }
 
  function addAddress(address,message) {
	   // var address = document.getElementById("address").value;
	   //geocoder = new google.maps.Geocoder();
	    geocoder.geocode( { 'address': address}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
	        map.setCenter(results[0].geometry.location);
	        var marker = new google.maps.Marker({
	            map: map, 
	            position: results[0].geometry.location,
	            title: "Hello Q"
	        });
	        attachMessageToMarker(marker,message);
	        //alert("location: ");
	      } else {
	        alert(address+ "'s Geocode was not successful for the following reason: " + status);
	        appendElement(badlist,"li",null,address);
	      }
	    });
	}

  

//  for (i=0;i<addr.length;i++){
//	  addAddress(addr[i],msg[i]);
//  }
//  for (i=42;i<62;i++){
//	  addAddress(addr[i],msg[i]);
//	  
//  }

  function addAddressWithDelay(addr,msg,i, t){
	  alert("get a new address: "+addr[i]);
	  addAddress(addr[i],msg[i]);
	  if(i<62){
	     var tt=setTimeOut(addAddressWithDelay(addr,msg,i+1),t);
	  }
  }
  setTimeOut(addAddressWithDelay(addr,msg,42),5000);
 
</script>

</body>
</html>
