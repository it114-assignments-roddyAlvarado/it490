<?php

session_start();

require_once('rabbitMQLib.inc');
require_once('get_host_info.inc');
require_once('path.inc');

$client = new rabbitMQClient("testRabbitMQ.ini", "Frontend");
$date = date("Y-m-d", time());


$username = htmlspecialchars($_POST['username']);
$password =  htmlspecialchars($_POST['password']);
$error = '';

if (isset($_POST['register'])) {
	header('Location: register.view.php');


} elseif (isset($_POST['login'])) {

	if (empty($username) || empty($password)) {
		$error = "Oops! Invalid Username/Password";
		require 'index.view.php';
		
	} else {
		$request = array();
		$request['type'] = "login";
		$request['username'] = $username;
		$request['password'] = $password;
		$request['message'] = "'{$username}' requests to login '{$date}'";
		
		$response = $client->send_request($request);
		
		if ($response === '401') {
			$error = "Oops! Invalid Username/Password";
			require 'index.view.php';

		} elseif ($response === '404') {
			$error = "Oops! Username not found!";
			require 'index.view.php';
		
		} else {
			$_SESSION['username'] = $response[0]['username'];
			$_SESSION['firstname'] = $response[0]['firstname'];
			$_SESSION['lastname'] = $response[0]['lastname'];
			header("Location: profile.php");
			exit();

		}
	}
}


?>