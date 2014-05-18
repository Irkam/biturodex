<?php
require_once(dirname(__FILE__) . "/../classes/user.class.php");

$name = strval($_GET['name']);
$queryrange = intval($_GET['size']);

$users = User::getUsersByNameLike($name, $queryrange);
	
echo json_encode($users);

?>