<?php

require_once 'vendor/autoload.php';

$time2 = date('Y-m-d');
$link = mysqli_connect("localhost", "root", "", "kursy22");

$result = mysqli_fetch_array(mysqli_query($link, "SELECT time FROM kursytable WHERE time = '$time2'"));

if($result)
{
	//
} 
else 
{
	$cbrf = \Liquetsoft\CbrfService\CbrfFactory::createDaily();
	
	$rateEur = $cbrf->getCursOnDateByCharCode(new \DateTimeImmutable(), 'EUR');
	$rateUsd = $cbrf->getCursOnDateByCharCode(new \DateTimeImmutable(), 'USD');
	$rateGbp = $cbrf->getCursOnDateByCharCode(new \DateTimeImmutable(), 'GBP');
	
	$data = json_encode(['eur' => $rateEur->getRate(), 'usd' => $rateUsd->getRate(), 'bgp' => $rateGbp->getRate()]);
	$result = mysqli_query($link, "INSERT kursytable(time, kursy) VALUES ('$time2', '$data')");
}

?>


<html>
	<head>
		<title>API Example</title>
		<style type="text/css">
			body{
				text-align: center;
			}
			#container{
				width: 200px;
				position:absolute;
				top:50px;
				left:50%;
				margin-left:-100px;
			}
			div{
				margin-top: 10px;
			}
			select{
				width: 90%;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<h2>API Form GET</h2>
			<form method="GET" action="api">
				<div>
					<label for="date1">Date:</label>
					<input type="date" name="date1" id="date1"/> 
				</div>
				<div>
					<label for="current">Current:</label>
					<select name="current" id="current">
						<option value="eur">eur</option>
						<option value="usd">usd</option>
						<option value="bgp">bgp</option>
					</select>
				</div>
				<div>
					<input type="submit" value="Send" name="btn"  /> 
				</div>
			</form>
		</div>
	</body>
</html>

