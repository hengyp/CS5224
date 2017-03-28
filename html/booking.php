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

<div class = "h1">


<p>

         <button type="button" onclick="window.location.href='index.php';"> Back to map!</button>
</p>
<p id="bookingContainer">

Booking for <?php echo $_GET['carpark']; ?>

</p>

<p id="durationContainer">
Select Duration :

 <select id = 'duration'>
  <option value="30">30 mins</option>
  <option value="60">60 mins</option>
  <option value="90">90 mins</option>
  <option value="120">120 mins</option>
  <option value="150">150 mins</option>
  <option value="180">180 mins</option>  
  
</select> 

</p>

<p id="timeContainer">
Select start time (hour):

 <select id = 'hour'>
  <option value="7">7 am</option>
  <option value="8">8 am</option>
  <option value="9">9 am</option>
  <option value="10">10 am</option>
  <option value="11">11 am</option>
  <option value="12">12 pm</option>  
  <option value="13">1 pm</option>
  <option value="14">2 pm</option>
  <option value="15">3 pm</option>
  <option value="16">4 pm</option>
  <option value="17">5 pm</option>
  <option value="18">6 pm</option>  
  <option value="19">7 pm</option>
  <option value="20">8 pm</option>
  <option value="21">9 pm</option>
  <option value="22">10 pm</option>
</select>

Select start time (minute):

 <select id='min'>
  <option value="0">0 min</option>
  <option value="5">5 min</option>
  <option value="10">10 min</option>
  <option value="15">15 min</option>
  <option value="20">20 min</option>
  <option value="25">25 min</option>  
  <option value="30">30 min</option>
  <option value="35">35 min</option>
  <option value="40">40 min</option>
  <option value="45">45 min</option>
  <option value="50">50 min</option>
  <option value="55">55 min</option>  
</select>


</p>

<p id="carplateContainer">
Please input car plate number:<input id='carplate' type="text" name="carplate">

</p>


<p id="buttonContainer">

         <button type="button" onclick="findOutSelectedValues();"> Book now!</button>
</p>

<p id = "resultContainer">
</p>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>

function findOutSelectedValues(){


<?php
	echo 'var carpark_id = ' . $_GET['carpark_id'] . ';';
?>	
	

	var outputString = "bookRedirect.php?carpark_id=";
	
	

	var index=document.getElementById("duration");

	var selDuration=index.options[index.selectedIndex].value;

	index = document.getElementById("hour");

	var selHour=index.options[index.selectedIndex].value;
	
	index = document.getElementById("min");

	var selMin=index.options[index.selectedIndex].value;
	
	index = document.getElementById("carplate");

	var carPlate=document.getElementById("carplate").value;

	
   var outputString2= outputString.concat(carpark_id).concat('&hour=').concat(selHour).concat('&min=').concat(selMin).concat('&duration=').concat(selDuration).concat('&carplate=').concat(carPlate);


	document.getElementById("resultContainer").innerHTML = "Please wait..... Attempting Booking ......";

   	
	$.get(outputString2, function(data, status){

			document.getElementById("resultContainer").innerHTML = "Booking successful! Your booking ID is: " + String(data);
			
		
   });	


}


</script>


</body>


</html>
