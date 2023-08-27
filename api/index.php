<?php
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($method | $uri) {
   case ($method == 'GET' && $uri == '/api/'):
   
       break;
   case ($method == 'GET' && preg_match('/\/api/', $uri)):
	   $time2 = $_GET['date1'];
	   $current = $_GET['current'];
	   $link = mysqli_connect("localhost", "root", "", "kursy22");
	   $result = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM kursytable WHERE time = '$time2'"));
	   if($result)
	   {
		   header('Content-Type: application/json');
		   $cur = json_decode($result['kursy'], true);
		   echo json_encode($cur[$current], JSON_PRETTY_PRINT);
	   } else {
		   http_response_code(404);
		   echo json_encode(['error' => "We cannot find what you're looking for."]);
	   }
       break;
   case ($method == 'POST' && $uri == '/api/'):
   
       break;
   case ($method == 'PUT' && preg_match('/\/api\/', $uri)):

       break;
   case ($method == 'DELETE' && preg_match('/\/api\/', $uri)):

       break;
   default:
       http_response_code(404);
       echo json_encode(['error' => "We cannot find what you're looking for."]);
       break;
}