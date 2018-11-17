

<!DOCTYPE html>
<html>
<head>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
	<title>Weather Search by RishabhYadav</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">

body {
	background-image: url("background.jpg");
	background-color: #cccccc;
}
h1{
	font-family: 'Kaushan Script', cursive;
	color: white;
	text-align: center;
	margin-top: 10%;	
	font-size: 7em;

	text-shadow: 3px 4px 0px rgba(192,192,192,0.2),
	5px 4px 0px rgba(0,0,0,0.1),
	5px 4px 0px rgba(0,0,0,0.1);
}

#search{
	width: 600px;
	margin: 0 auto;	
}

#searchResult {
	font-size: 1.2em;
	color: white;
	max-width: 800px;
	margin: 0 auto;
}

</style>

<body>

	<h1>Weather Search</h1>
	<div class="container-fluid">
		<div class="row">

			<div id="search" >
				<form method="post" action="WeatherSearch.php">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" name="query" placeholder="Enter City...">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-secondary" type="button">  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>&nbsp;Search</button>
							</span>
						</div>
					</form>
				</div>
			</div>
		</div>
		<br>
		<div id="searchResult" class="form-group">

			<?php

			$BASE_URL = "http://query.yahooapis.com/v1/public/yql";
			if($_POST){
				if($_POST["query"]==""){
					echo '<div class="alert alert-warning" role="alert">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="sr-only">Error:</span>
					Did you forgot to enter the city name ?
					</div>';
				}
				else{
					$yql_query ='select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="'. $_POST["query"]. '")';
					$yql_query_url = $BASE_URL ."?q=".urlencode($yql_query) ."&format=json";
    // Make call with cURL
					$session = curl_init($yql_query_url);
					curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
					$json = curl_exec($session);
    // Convert JSON to PHP object
					$phpObj =  json_decode($json);
					
					if (isset($phpObj->{'query'}->{'results'}->{'channel'}->{'location'}->{'city'})) {
						$result = $phpObj->{'query'}->{'results'}->{'channel'};
						$location = "City : ".$result->{'location'}->{"city"}.", ".$result->{'location'}->{"region"}.", ".$result->{'location'}->{"country"}."<br>";

						$condition =  $result->{'item'}->{'title'}."<br>"."Temperature :".$result->{'item'}->{'condition'}->{'temp'}." F (Expect ".$result->{'item'}->{'condition'}->{'text'}.".) <br>".
						" High Temp : ".$result->{'item'}->{'forecast'}[0]->{'high'}." F Low Temp :".$result->{'item'}->{'forecast'}[0]->{'low'}." F <br>";
						$windSpeed = "Windspeed : ".$result->{'wind'}->{'speed'}." Mph<br>";
						$atmosphere = "Humidity: ".$result->{'atmosphere'}->{'humidity'}."%<br>"."Pressure: ".$result->{'atmosphere'}->{'pressure'}." in<br>"."Visibility: ".$result->{'atmosphere'}->{"visibility"}." miles"."<br>";
						?>
					<!-- 	<div class="btn-group btn-toggle"> 
							<button class="btn btn-xs btn-default">°C</button>
							<button class="btn btn-xs btn-success active">°F</button>
						</div>
						<div class="btn-group btn-toggle"> 
							<button class="btn btn-xs btn-default">Imperial</button>
							<button class="btn btn-xs btn-info active">Metric</button>
						</div>

 -->


						<div class="alert alert-success" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span><<?php  echo $location.$condition.$windSpeed.$atmosphere; ?> </div>							
						<?php   }else {
							echo '<div class="alert alert-warning" role="alert">
							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
							<span class="sr-only">Error:</span>
							That was an unexpected input. Did you really enter a city name ?
							</div>';
						}
					}
				}
				?>



			</div>



		</div>

		<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		
		<!-- <script type="text/javascript" src="conversion.js"></script> -->
		









	</body>
	</html>