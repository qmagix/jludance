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
	    var street = document.getElementById("address").value;
	    var city=document.getElementById("city").value;
	    var address=street+","+city;
	    geocoder.geocode( { 'address': address}, function(results, status) {
	      if (status == google.maps.GeocoderStatus.OK) {
	    	 document.getElementById("latitude").value=results[0].geometry.location.lat();
	    	 document.getElementById("longitude").value=results[0].geometry.location.lng();
		     
	      } else {
	        alert("Geocode was not successful for the following reason: " + status);
	      }
	    });
	  }
  
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
	            title: results[0].geometry.location.toUrlValue()
	        });
	        attachMessageToMarker(marker,message);
	        //alert("location: ");
	      } else {
	        alert(address+ "'s Geocode was not successful for the following reason: " + status);
	      }
	    });
	}

  initialize();