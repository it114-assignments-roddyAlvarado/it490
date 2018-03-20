<?php

require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function requestProcessor($request) {
	echo "Request received".PHP_EOL;

	if(!isset($request['type'])) {
		return "Error: unsupported message type";
	}

	switch ($request['type']) {

		case "apiBeerSearch":
			return searchApiBeer($request['searchAPI']);

		case "apiCategorySearch":
			return searchApiBeer($request['searchAPI']);
	}

	return array("returnCode" => '0', 'message' => "Server received request and processed");
}

/* function searchApiBeer($apiBeerSearch) {

	$beer_info = $apiBeerSearch;

	curl_setopt_array($curl, array(
		CURLOPT_URL => "$BASE_URL/beers/?name=$beer_info&key=$apikey",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	));

	$response = curl_exec($curl);

	curl_close($curl);

	$response_format = json_decode($response, true);
	$result_array = array();

	foreach ($response_format as $key => $value) {
		if ($key === 'data') {
			for ($i = 0; $i < count($value); $i++) {
				foreach ($value[$i] as $data => $information) {
					if ($data === 'name') {
						$result_array['name'] = $information;
						

					}
					if ($data === 'description') {
						$result_array['description'] = $information;
						
					}
					if ($data === 'available') {
						foreach ($information as $availData => $availInformation) {
							if ($availData === 'name') {
								$result_array['available'] = $availInformation;
								
							}
						}
					}

					if ($data === 'style') {
						foreach ($information as $styleType => $styleInformation) {
							if ($styleType === 'name') {
								$result_array['type'] = $styleInformation;
								
							}
							if ($styleType === 'category') {
								foreach ($styleInformation as $category_type => $category_name) {
									if ($category_type === 'name') {
										$result_array['category'] = $category_name;
										
									
									}
								}
							}
						}
					}
				}
			} 
		}
	}
	print_r($result_array);
	return $result_array;
} */

function searchApiBeer($apiBeerSearch) {

	$beer_info = $apiBeerSearch;

	$curl = curl_init();
	$apikey = '35ac36973944221658d74aee2f32bb0c';
	$BASE_URL = "http://api.brewerydb.com/v2/";

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://api.brewerydb.com/v2/search?key=35ac36973944221658d74aee2f32bb0c&q=$beer_info&type=beer",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "Cache-Control: no-cache",
	    "Postman-Token: 422ba6f5-6dcd-7c46-5837-690d8831e089"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	$api_data = json_decode($response);

	$api_array = array();
	$api_test = array();
	//['data'] = count(50) => 0 = index => ['name']

	        //array   key     value
	foreach ($api_data as $data => $category) {
	  if ($data === 'data') {
	    foreach ($category as $key => $value) {
	      foreach ($value as $labels => $names) {
	        if ($labels === 'name') {
	          $api_array['name'] = $names;
	        }

	        if ($labels === 'abv') {
	          $api_array['abv'] = $names;
	        }

	        if ($labels === 'available') {
	          foreach ($names as $available => $availDescription) {
	            if ($available === 'name') {
	              $api_array['available'] = $availDescription;
	            }
	          }
	        }

	        if($labels === 'style') {
	          foreach ($names as $category => $categoryDescription) {
	            if ($category === 'name') {
	              $api_array['category'] = $categoryDescription;
	            }
	            if ($category === 'description') {
	            	$api_array['description'] = $categoryDescription;
	            }
	          }
	        }
	      }
	      if (count($api_array) >= 5) {
	      	array_push($api_test, $api_array);
	    	$api_array = array();
	      }
	    }
	  }
	}
	print_r($api_test);
	return $api_test;
}


$server = new rabbitMQServer("testRabbitMQ.ini", "Backend");
$server->process_requests('requestProcessor');

exit();

?>
