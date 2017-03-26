<!DOCTYPE html>
<html>
<title>ParkSpot.com</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">



<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}
body, html {
    height: 100%;
    margin: 0;
    padding: 0;
    background-color: #000000;
    color: #ffffff;

}


.header {
    background-color: #000000;
    color: #ffffff;
}

</style>
<body>

<a href="https://52.221.125.130/index.php">
<img src="logo.png">
</a>

<input id="pac-input" class="controls" type="text" placeholder="Search Box">

<div id="googleMap" style="height:90%; padding:0px"></div>


<script>

function initMap() {

  			var mapOptions= {
    				center: {lat: 1.362524578086153, lng: 103.81702423095703},
    				zoom:12, scrollwheel: true, draggable: true,
    				mapTypeId:google.maps.MapTypeId.ROADMAP
  			};
  
  			var infoCenter=0;

   		var map=new google.maps.Map(document.getElementById("googleMap"),mapOptions);
        	var input = document.getElementById('pac-input');
        	var searchBox = new google.maps.places.SearchBox(input);
        	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);


        	// Bias the SearchBox results towards current map's viewport.
        	map.addListener('bounds_changed', function() {
          	searchBox.setBounds(map.getBounds());
        	});
        
        	google.maps.event.addListener(map, "center_changed", function() {
        	
        		if(infoCenter==1){ 
        			alert(map.getCenter().lat().toString().concat(", ").concat(map.getCenter().lng().toString()).concat("*"));
        			infoCenter=0; 
        		};
        		
        	});

        	var markers = [];
        	// Listen for the event fired when the user selects a prediction and retrieve
        	// more details for that place.
        	searchBox.addListener('places_changed', function() {
          	var places = searchBox.getPlaces();

          	if (places.length == 0) {
            	return;
            	
          	}

          	infoCenter=1;


          	// Clear out the old markers.
          	markers.forEach(function(marker) {
            	marker.setMap(null);
          	});
          	markers = [];

          	// For each place, get the icon, name and location.
          	var bounds = new google.maps.LatLngBounds();
          	places.forEach(function(place) {
            	if (!place.geometry) {
              		console.log("Returned place contains no geometry");
              		return;
            	}
            	var icon = {
              		url: place.icon,
              		size: new google.maps.Size(71, 71),
              		origin: new google.maps.Point(0, 0),
              		anchor: new google.maps.Point(17, 34),
              		scaledSize: new google.maps.Size(25, 25)
            	};

            	// Create a marker for each place.
            	markers.push(new google.maps.Marker({
              		map: map,
              		icon: icon,
              		title: place.name,
              		position: place.geometry.location
            	}));

            	if (place.geometry.viewport) {
              		// Only geocodes have viewport.
              		bounds.union(place.geometry.viewport);
            	} else {
              		bounds.extend(place.geometry.location);
            	}
          	});
          
          	map.fitBounds(bounds); 
        });
        
        

        if (navigator.geolocation) {
        		navigator.geolocation.getCurrentPosition(function(position) {
            	var pos = {
              		lat: position.coords.latitude,
              		lng: position.coords.longitude
            	};


  					var marker = new google.maps.Marker({
    					position: pos,
    					map:map,title:"You are here!"
  					});
  
  					marker.setMap(map);

					//Zoom in on click function
  					google.maps.event.addListener(marker,'click',function() {
  					map.setZoom(16);
  					map.setCenter(marker.getPosition());
  					});    					
  					
          		}, showError
          	);
        	} else {
          		// Browser doesn't support Geolocation
        			document.getElementById("googleMap").innerHTML = "Geolocation is not supported by this browser.";
        	}

			var imageBlue={
				url: 'w3images/blue_Marker.png'
			};
			
			var imageBrown={
				url: 'w3images/brown_Marker.png'
			};
			
			var imageGreen={
				url: 'w3images/green_Marker.png'
			};

			var imageOrange={
				url: 'w3images/orange_Marker.png'
			};


<?php

		require_once 'HTTP/Request2.php';

		$request = new HTTP_Request2('http://52.220.214.10:8080/ParkSpot/api/carpark/list', HTTP_Request2::METHOD_GET);

    	$response = $request->send();
	 
    	if (200==$response->getStatus()) {
      	$resp = $response->getBody();
        	$ar = json_decode($resp);
        	$ar2 = $ar->{'result'};

			for($index=0; $index<sizeof($ar->{'result'}); $index++)
			{
				$ar3=(array)$ar2[$index];		
				$carPark = preg_replace("~[^a-z0-9 ]~i", "", $ar3['development']); 
				//Have to sanitize as the values contain illegal values!
	 
  				echo 'var marker' . $index . ' = new google.maps.Marker({
    			position: {lat: ' . $ar3['latitude'] . ', lng: ' . $ar3['longitude'] . '},
    			map:map,
    			title:"' . $ar3['development'] . ', ' . $ar3['lots'] . ', ' . $ar3['total_Lots'] . ', ' . '$'. $ar3['price'] . ",". $ar3['carParkOwner'] .'",
    			icon: ';
    			
				if ($ar3['carParkOwner'] == 'URA') {
					echo 'imageBlue';				
				} else if ($ar3['carParkOwner'] == 'HDB'){
					echo 'imageGreen';
				} else if ($ar3['carParkOwner'] == 'LTA'){
					echo 'imageOrange';
				}
				
				else {
					echo 'imageBrown';				
				}
    			
    			echo '
  				});

				marker' . $index . '.setMap(map);
			
				var contentString' . $index . '=\'<div style="color:#000000"><h1>' . $carPark .'</h1><h3>Lots available = ' . $ar3["lots"] .'/' . $ar3["total_Lots"] .' </h3><h3>Price = $' . $ar3["price"] . ' per hour</h3><h3>' . $ar3["carParkOwner"] . '</h3> <button type="button">Book Now!</button> </div>\';
				
				var infowindow' . $index . ' = new google.maps.InfoWindow({
    					content: contentString' . $index . '
  				});
				
				marker' . $index . '.addListener("click", function(){
					infowindow' . $index . '.open(map, marker' .$index. ');

				});
				
				infowindow.open(map,marker);				
				
				';
				//open by default
								
			}

		}

?>




}


function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            document.getElementById("googleMap").innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            //document.getElementById("googleMap").innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            document.getElementById("googleMap").innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            document.getElementById("googleMap").innerHTML = "An unknown error occurred."
            break;
    }
}


</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmVc-BGCJYox6qRnxX_iOItBIotCj8pRQ&libraries=places&callback=initMap"></script>

</body>
</html>
