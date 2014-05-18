<?php
require_once(dirname(__FILE__) . "/../classes/establishment.class.php");

$lat = intval($_GET['lat']);
$lng = intval($_GET['lng']);
$dist = intval($_GET['dist']);
$type = intval($_GET['type']);
$queryrange = intval($_GET['size']);


$establishments = Establishment::getEstablishmentsByLatLngDistType($lat, $lng, $dist, $type, $queryrange=30);
	
echo json_encode($establishments);

?>