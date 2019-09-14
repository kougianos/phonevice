<?php

// Step 1
$response = file_get_contents("https://zelda.figame.local/~kougi/phoneVice/api/step1.php?budget=200&range=20");
$response = json_decode($response, true);

// var_dump($response);

$baseURL = "https://zelda.figame.local/~kougi/phoneVice/api/step2.php?";

foreach($response['phone_ids'] as $key => $id) {

	$baseURL .= "phoneId[]=".$id;

	if($key!=(sizeof($response['phone_ids'])-1))
		$baseURL .= "&";

}

foreach($response['initial_features'] as $key => $feature) {

	$baseURL .= "&feature[]=".$feature;

}

// Step 2
$response = file_get_contents($baseURL);
$response = json_decode($response, true);

// var_dump($response);

$baseURL = "https://zelda.figame.local/~kougi/phoneVice/api/step3.php?";

foreach($response['phone_ids'] as $key => $id) {

	$baseURL .= "phoneId[]=".$id;

	if($key!=(sizeof($response['phone_ids'])-1))
		$baseURL .= "&";

}

// Step 3
$response = file_get_contents($baseURL);
$response = json_decode($response, true);

// var_dump($response);
