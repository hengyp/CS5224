<!DOCTYPE html>
<html>
<title>ParkSpot.com</title>
<head>
  <link rel="shortcut icon" type="image/x-icon" href="w3images/logosmall.png" />
</head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3mobile.css">

<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}
body, html {
    height: 100%;
    margin: 0;
    padding: 0;
    background-color: #2A3F54;
    color: #ffffff;

}

.header {
    background-color: #000000;
    color: #ffffff;
}


@media only screen and (min-width: 414px) and (max-device-width: 736px) and (orientation: portrait) {

	.heightLevel {height:80%;} 

}


@media only screen and (min-width: 414px) and (max-device-width: 736px) and (orientation: portrait) {

	.heightLevel {height:60%;} 

}


@media only screen and (min-width: 600px) {

	.heightLevel {height:88%;} 


}
</style>
<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="w3-container w3-card">


<a href="https://52.221.125.130/index.php"><img src="w3images/logo.png"></a>
<a href="http://www.suzukicar.com.sg"><img src="w3images/ad.png" style="float:right"></a>

</div>



<input id="pac-input" type="text" placeholder="Search Box">

<div id="googleMap" class ="heightLevel" style="padding:0px"></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<script>

function initMap() {

			var	markerArray=[];
			var 	infoWindowArray=[];
			var	prevMarker=[];
			var	prevInfoWindow=false;
			
			prevMarker[0]=null;

  			var mapOptions= {
    				center: {lat: 1.362524578086153, lng: 103.81702423095703},
    				zoom:12, scrollwheel: true, draggable: true,
    				mapTypeId:google.maps.MapTypeId.ROADMAP
  			};
  
  			var infoCenter=0;

   		var map=new google.maps.Map(document.getElementById("googleMap"),mapOptions);
        	var input = document.getElementById('pac-input');
        	var searchBox = new google.maps.places.SearchBox(input);
        	map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);


        	// Bias the SearchBox results towards current map's viewport.
        	map.addListener('bounds_changed', function() {
          	searchBox.setBounds(map.getBounds());
        	});
        
        	google.maps.event.addListener(map, "center_changed", function() {
        	
        		if(infoCenter==1){
        			
        			var outputString = "bookNearRedirect.php?lat=";
        			
        			var urlString = outputString.concat(map.getCenter().lat().toString()).concat('&lon=').concat(map.getCenter().lng().toString()).concat('&result=3');

					$.get(urlString, function(data, status){
						var resultString=JSON.parse(data);
						var resultString1 = JSON.parse(JSON.stringify(resultString.result[0]));						
						var resultString2 = JSON.parse(JSON.stringify(resultString.result[1]));						
						var resultString3 = JSON.parse(JSON.stringify(resultString.result[2]));
						
						if (prevMarker[0]!=null)
						{
							markerArray[prevMarker[0]].setAnimation(null);						
							markerArray[prevMarker[1]].setAnimation(null);						
							markerArray[prevMarker[2]].setAnimation(null);						
							
						};
						
						markerArray[resultString1.carParkID].setAnimation(google.maps.Animation.BOUNCE);						
						markerArray[resultString2.carParkID].setAnimation(google.maps.Animation.BOUNCE);						
						markerArray[resultString3.carParkID].setAnimation(google.maps.Animation.BOUNCE);
						
						new google.maps.event.trigger( markerArray[resultString1.carParkID], 'click' );
						
						prevInfoWindow=resultString1.carParkID;
						
						prevMarker[0]=resultString1.carParkID;
						prevMarker[1]=resultString2.carParkID;
						prevMarker[2]=resultString3.carParkID;
												
						
					});



        			//alert(urlString);
        			 
        			//alert(map.getCenter().lat().toString().concat(", ").concat(map.getCenter().lng().toString()).concat("*"));
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
	 
  				echo 'var marker' . $ar3['carParkID'] . ' = new google.maps.Marker({
    			position: {lat: ' . $ar3['latitude'] . ', lng: ' . $ar3['longitude'] . '},
    			map:map,
    			title:"' . $ar3['development'] . ', ' . $ar3['lots'] . ', ' . '$'. $ar3['price'] . ",". $ar3['carParkOwner'] .'",
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

				marker' . $ar3['carParkID'] . '.setMap(map);
			
				var contentString' . $ar3['carParkID'] . '=\'<div style="color:#000000"><h1>' . $carPark .'</h1><h3>Lots available =' . $ar3["lots"] .'</h3><h3>Price = $' . $ar3["price"] . '</h3><h3>' . $ar3["carParkOwner"] . 
				'</h3> <p><a href="booking.php?carpark_id=' . $ar3['carParkID'] . '&carpark=' . $carPark .
				'"><b>Book Now</b></a></p><p><a href="https://maps.google.com/maps?q=' .$ar3['latitude']. ',' . $ar3['longitude'] . 
				'"><b>Directions</b></a></p><p><a href="https://maps.google.com/maps?q=&layer=c&cbll='. $ar3['latitude'] . ',' .$ar3['longitude'] .
				'"><b>Street view</b></p></div>\';
				
				var infowindow' . $ar3['carParkID'] . ' = new google.maps.InfoWindow({
    					content: contentString' . $ar3['carParkID'] . '
  				});
				
				marker' . $ar3['carParkID'] . '.addListener("click", function(){
					infowindow' . $ar3['carParkID'] . '.open(map, marker' . $ar3['carParkID'] . ');
					
					if (prevInfoWindow) {
						infoWindowArray[prevInfoWindow].close();
					};
					prevInfoWindow=' . $ar3['carParkID'] . ';

				});
				
				markerArray[' .$ar3['carParkID'] . ']=marker' . $ar3['carParkID'] . ';
				infoWindowArray[' .$ar3['carParkID'] . ']=infowindow' . $ar3['carParkID'] . ';
				';
				
								
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

<div class="w3-container w3-card">

<footer>  
  <div class="fb-follow" data-href="https://www.facebook.com/ParkSpot-634769236723014/" data-layout="button" data-size="small" data-show-faces="false"></div>
  <a href="https://twitter.com/ParkSpotSG" class="twitter-follow-button" data-show-count="false">Follow @ParkSpot</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
</footer>
</div>

</body>
</html>
