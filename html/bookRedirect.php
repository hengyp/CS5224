
<?php

		require_once 'HTTP/Request2.php';

	   $urlString = "http://52.220.214.10:8080/ParkSpot/api/addbooking/?carpark_id=" .  $_GET['carpark_id'] . "&hour=" . $_GET['hour'] .
	   "&min=" . $_GET['min'] . "&duration=" . $_GET['duration'] . "&carplate=" . $_GET['carplate'];


		$request = new HTTP_Request2($urlString, HTTP_Request2::METHOD_GET);

    	$response = $request->send();
	 
    	if (200==$response->getStatus()) {
    		
    		$resp = $response->getBody();
    		
    		
        	$ar = json_decode($resp);
        	$ar2 = (array) $ar->{'result'};
        	
        	echo (string) $ar->{'result'}->{bookingID};

    		
    	} else {

		echo 'Error';
    	
    	}


	//echo $_GET['carpark_id'];

?>
