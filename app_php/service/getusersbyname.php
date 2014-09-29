<?php
require_once(dirname(__FILE__) . "/../classes/user.class.php");

if(!isset($_GET['name'])){
	echo json_encode(array(null));
	exit;
}

$name = strval($_GET['name']);

if(isset($_GET['size']))
	$queryrange = intval($_GET['size']);
else
	$queryrange = 25;

$users = User::getUsersByNameLike($name, $queryrange);
	
echo json_encode($users);

?>