<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini", "Frontend");

$search = htmlspecialchars($_POST['search']);

if (isset($search)){
	$request = array();
	$request['type'] = 'search';
	$request['search'] = $search;
	$request['message'] = '{$username} searched for {$search}';

	$response = $client->send_request($request);

	require('beer.view.php');

} elseif (isset($_POST['categoryName'])) {

	$request = array();
	$request['type'] = "searchCategory";
	$request['searchCategory'] = $_POST['categoryName'];
	$request['message'] = 'Category Search';

	$response = $client->send_request($request);

	require('beer.view.php');
}

?>

