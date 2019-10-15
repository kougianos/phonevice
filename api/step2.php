<?php

// Validation array
$validationGetArray = array("phoneId", "feature");

if(!isset($_GET['phoneId']) || sizeof($_GET)>2 || array_diff(array_keys($_GET), $validationGetArray)!==array()) {
	header("HTTP/1.0 404 Not Found");
	exit();
}

// Phones
$phones = json_decode(file_get_contents(__DIR__."/../database/dbApril2019.json"), true);

// Response array
$response['phone_ids'] = array();

// Loop phones
foreach($phones as $key => $phone) {

	// Unset phones that are not in requested ids
	if(!in_array($phone['_id'], $_GET['phoneId'])) {
		unset($phones[$key]);
		continue;
	}

	if(isset($_GET['feature'])) {

		// Unset phones that do not have requested features
		if(array_intersect($_GET['feature'], array_values($phone['available_features']))!=$_GET['feature']) {
			unset($phones[$key]);
			continue;
		}

	}

	// Add phone id to response array
	$response['phone_ids'][] = $phone['_id'];

}

// Set the correct mime type
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

exit();
