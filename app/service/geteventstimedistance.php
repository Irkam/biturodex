<?php
require_once(dirname(__FILE__) . "/../classes/event.class.php");

$fromtime = intval($_GET['fromtime']);
$totime = intval($_GET['totime']);
$lat = intval($_GET['lat']);
$lng = intval($_GET['lng']);
$dist = intval($_GET['dist']);
$queryrange = intval($_GET['size']);
$orderpriority = intval($_GET['order']);


$events = Event::getEventsByDateTimeRangeLatLngDist($fromtime, $totime, $lat, $lng, $dist, $queryrange, $orderpriority);
	
echo json_encode($events);

?>