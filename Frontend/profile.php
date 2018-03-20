<?php
session_start();

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini", "Frontend");

$username = $_SESSION['username'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

$search = htmlspecialchars($_POST['search']);

if (!empty($search)) {

	header('Location: search.php');
	exit();
	
}

if (isset($_POST['logout'])) {
	session_unset();

	$request['type'] = 'logout';
	$request['username'] = $username;
	$request['message'] = '$username has logged out';
	$response = $client->send_request($request);

	header("Location: index.view.php");
	exit();

}

require 'profile.view.php';

?>