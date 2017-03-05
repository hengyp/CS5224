<!DOCTYPE html>
<html>
<body>

<?php

require_once 'HTTP/Request2.php';

$request = new HTTP_Request2('http://52.220.214.10:8080/ParkSpot/api/carpark/list', HTTP_Request2::METHOD_GET);
try {
    $response = $request->send();
    if (200 == $response->getStatus()) {
        $resp = $response->getBody();
        $ar = json_decode($resp);
        $ar2 = $ar->{'result'};

			for($index=0; $index<sizeof($ar->{'result'}); $index++)
			{

				$ar3=(array)$ar2[$index];
						
				echo $ar3['latitude'] . ',' . $ar3['longitude'] . ',' . $ar3['development'] . ',' . $ar3['lots'] . '<br/>';
				//echo ',';
				//echo $ar3['longitude'];
				//echo ',';
				//echo $ar3['lots'];
				
				//echo "<br/>";
				
			}
			
									        
        
    } else {
        echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
             $response->getReasonPhrase();
    }
} catch (HTTP_Request2_Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>

</body>
</html> 