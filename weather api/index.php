<?php

$today_weather="";
$error=" named place you are searching for couldn't be found.";
$count=0;
$place="";
if($_GET){
	$place=ucfirst($_GET['place']);

	$file_headers = @get_headers("http://api.openweathermap.org/data/2.5/weather?q=".$place."&appid=6983e818f323061a9a7dc5b430272eca");

	if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
		$count=1;
	    $exists = false;
	   // echo "Error";
	}

	else{
	$urlContents=file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".urlencode($place)."&appid=6983e818f323061a9a7dc5b430272eca");

	$weatherArray=json_decode($urlContents,true);
	
	//print_r($weatherArray);
	
	if($weatherArray['cod']=="200"){
		
		
			$today_weather="Current weather in <strong>".$place."</strong> is: ".ucfirst($weatherArray['weather'][0]['description']).". ";
			
			$temperature=$weatherArray['main']['temp']-273.15;

			$today_weather.=" Temperature is: ".$temperature."&deg;C. Wind speed is ".$weatherArray['wind']['speed']."m/s .";
		}
		//echo $temperature
		else{
			$count=1;
		}
	}

}

?>



<html>

<head>

<link href="https://fonts.googleapis.com/css?family=PT+Serif&display=swap" rel="stylesheet">

<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<style type="text/css">

body{
	margin-top:150px;
	padding:0px;
	padding-bottom: 0px;
	background-image:url("pic1.jpg");
	background-size:100% 100%;
	overflow:auto;
}

p{
font-family: 'PT Serif', serif;
font-size:20px;
color:white;

}

button{
	opacity:90%;
}

#weather_today{
	opacity:60%;
	background-color:#ffffff;
	
	
	border-radius:4px;
	
}

</style>

</head>

<body>

  <div class="container" align="center">
    <h1 class="display-4"><strong>What's the Weather?</strong></h1>
    <p class="lead">Enter the name of City.

    <form>
    <div class="form-group col-5">
    <input class="form-control" id="PlaceName" name="place" placeholder="eg. Mumbai, Tokyo" value="<?php echo$place?>">
  	</div>
    	
    	 <button type="submit" class="btn btn-warning" >Submit</button>

    </form>	 
    </p> 
    <br>
    <div id="weather_today" class="col-6">
    	<?php
    		if($count==0)
    		echo $today_weather;
    		else
    		echo"<strong>$place</strong> ".$error;
    	?>

    </div>

  </div>

  <script type="text/javascript">
/*
  	$("button").click(function(){
  		$("#weather_today").style("display","block");

  	})
  	
*/
	
  </script>	





<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>


</html>