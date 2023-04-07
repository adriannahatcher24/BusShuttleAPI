<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
/**
 * Returns a list of stops for populating the dropdown on our driver interface.
 */
require 'connect.php';

$stops = [];

$sql = sprintf("SELECT stops.stops, stops.id, stop_loop.displayOrder, stop_loop.loop FROM stops inner JOIN stop_loop ON stop_loop.stop=stops.id AND stop_loop.is_deleted='0' ORDER BY displayOrder");

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
      $stops[$cr]['id'] = $row['id'];
      $stops[$cr]['stops'] = $row['stops'];
      $stops[$cr]['displayOrder'] = $row['displayOrder'];
      $stops[$cr]['loop'] = $row['loop'];
    $cr++;
  }
  echo json_encode(['data'=>$stops]);
}
else
{
  http_response_code(404);
}
