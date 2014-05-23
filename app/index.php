<?php
session_start();

function getActionByName($name) {
	$name .= 'Action';
	require("actions/$name.inc.php");
	return new $name;
}

function getViewByName($name) {
	$name .= 'View';
	require("views/$name.inc.php");
	return new $name;
}

function getAction() {
	if (!isset($_REQUEST['action'])) $action = 'Default';
	else $action = $_REQUEST['action'];

	$actions = array('Default',
			'SignUpForm',
			'SignUp',
			'Logout',
			'Login',
			'UpdateUserForm',
			'UpdateUser',
			'CreateEstablishmentForm',
			'CreateEstablishment',
			'GetMyEstablishment',
			'CreateEventForm',
			'CreateEvent',
			'GetMyEvents',
			'CreateConversationForm',
			'CreateConversation',
			'GetMySurveys',
			'SearchEvents',
			'SearchForm',
			'ShowEvent',
			'Vote');

	if (!in_array($action, $actions)) $action = 'Default';
	return getActionByName($action);
}

$action = getAction();
$action->run();
$view = $action->getView();
$action->getView()->setLogin($action->getSessionLogin());
$view->run();
?>

