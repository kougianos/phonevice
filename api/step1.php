<?php

// Validation array
$validationGetArray = array("budget", "range");

if(!isset($_GET['budget']) || sizeof($_GET)>2 || array_diff(array_keys($_GET), $validationGetArray)!==array()) {
	header("HTTP/1.0 404 Not Found");
	exit();
}

// Strip unwanted characters 
$_GET['budget'] = preg_replace('/[^0-9]+/', '', $_GET['budget']);
$_GET['range'] = preg_replace('/[^0-9]+/', '', $_GET['range']);

// Original and backup database
$phones = json_decode(file_get_contents(__DIR__."/../database/dbApril2019.json"), true);
$backupDb = $phones;

// Budget
$budget = $_GET['budget'];

// Calculate budget range if not set by user
if(!isset($_GET['range']))
	$budgetRange = $budget/20;

$budgetRange = $_GET['range'];



// Budget algorithm
while(1) {

	// Loop phones
	foreach($phones as $key => $phone) {

		// Discard phones with no benchmark
		if(!isset($phone['benchmarks']['SLING_SHOT_ES_31']['Score']) || $phone['benchmarks']['SLING_SHOT_ES_31']['Score']=="Delisted")
			unset($phones[$key]);

		// Keep phones that have min or max price in budget range
		if(!(($phone['minPrice']>=($budget-$budgetRange) && $phone['minPrice']<=($budget+$budgetRange)) || ($phone['maxPrice']>=($budget-$budgetRange) && $phone['maxPrice']<=($budget+$budgetRange))))
			unset($phones[$key]);

	}

	// If there are less than 10 results, increase budget range and repeat
	if(sizeof($phones)<10) {
		$phones = $backupDb;
		$budgetRange += $budget/20;
	} else {
		break;
	}

}

// Initial features array @TODO make it multi dimensional array where every element has count and img URL
$initialFeatures = array(

	'microSD'		=>	0,
	'nfc'			=>	0,
	'dualSim'		=>	0,
	'radio'			=>	0,
	'fastCharging'		=>	0,
	'wirelessCharging'	=>	0,
	'headphoneJack'		=>	0

);

$response['phone_ids'] = array();

foreach($phones as $key => $phone) {

	// Add phone id to response
	$response['phone_ids'][] = $phone['_id'];

	// Initialize available features empty array for each phone
	$phones[$key]['available_features'] = array();

	if(isset($phone['summary']['expansion'])) {
		$initialFeatures['microSD']++;
		$phones[$key]['available_features'][] = "microSD";
	}
	if(isset($phone['comms']['connectivity']) && in_array("NFC", $phone['comms']['connectivity'])) {
		$initialFeatures['nfc']++;
		$phones[$key]['available_features'][] = "nfc";
	}
	if(isset($phone['sim']['slots']) && $phone['sim']['slots']==2) {
		$initialFeatures['dualSim']++;
		$phones[$key]['available_features'][] = "dualSim";
	}
	if(isset($phone['comms']['radio']) && $phone['comms']['radio']==true) {
		$initialFeatures['radio']++;
		$phones[$key]['available_features'][] = "radio";
	}
	if(isset($phone['battery']['charge_quick']) && $phone['battery']['charge_quick']==true) {
		$initialFeatures['fastCharging']++;
		$phones[$key]['available_features'][] = "fastCharging";
	}
	if(isset($phone['battery']['charge_wireless']) && $phone['battery']['charge_wireless']==true) {
		$initialFeatures['wirelessCharging']++;
		$phones[$key]['available_features'][] = "wirelessCharging";
	}
	if(isset($phone['multimedia']['3mm_jack']) && $phone['multimedia']['3mm_jack']==true) {
		$initialFeatures['headphoneJack']++;
		$phones[$key]['available_features'][] = "headphoneJack";
	}

}

// Assign initial features
$response['initial_features'] = array();
foreach($initialFeatures as $key => $feature) {

	if($feature>=3)
		$response['initial_features'][] = $key;

}

// Set the correct mime type
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

exit();
