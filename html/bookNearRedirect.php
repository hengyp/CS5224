<?php

		require_once 'HTTP/Request2.php';

	   $urlString = "http://52.220.214.10:8080/ParkSpot/api/recommendCarpark/?lat=" .  $_GET['lat'] . "&lon=" . $_GET['lon'] .
	   "&result=" . $_GET['result'];


		$request = new HTTP_Request2($urlString, HTTP_Request2::METHOD_GET);

    	$response = $request->send();
	 
    	if (200==$response->getStatus()) {
    		
    		$resp = $response->getBody();

			echo $resp;
    		
    	} else {

		echo 'Error';
    	
    	}


	//echo $_GET['carpark_id'];

?>