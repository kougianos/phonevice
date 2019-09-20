<?php

// Validation array
$validationGetArray = array("budget", "range");

if(!isset($_GET['budget']) || sizeof($_GET)>2 || array_diff(array_keys($_GET), $validationGetArray)!==array())
	header("Location: index.html");

// Strip unwanted characters 
$_GET['budget'] = preg_replace('/[^0-9]+/', '', $_GET['budget']);
$_GET['range'] = preg_replace('/[^0-9]+/', '', $_GET['range']);

// Original and backup database
$_SESSION['phones'] = json_decode(file_get_contents(__DIR__."/../database/dbApril2019Pretty.json"), true);
$backupDb = $_SESSION['phones'];

// Budget
$budget = $_GET['budget'];

// Calculate budget range if not set by user
if(!isset($_GET['range']))
	$budgetRange = $budget/20;
else
	$budgetRange = $_GET['range'];

// Budget algorithm
while(1) {

	// Loop phones
	foreach($_SESSION['phones'] as $key => $phone) {

		// Discard phones with no benchmark
		if(!isset($phone['benchmarks']['SLING_SHOT_ES_31']['Score']) || $phone['benchmarks']['SLING_SHOT_ES_31']['Score']=="Delisted")
			unset($_SESSION['phones'][$key]);

		// Keep phones that have min or max price in budget range
		if(!(($phone['minPrice']>=($budget-$budgetRange) && $phone['minPrice']<=($budget+$budgetRange)) || ($phone['maxPrice']>=($budget-$budgetRange) && $phone['maxPrice']<=($budget+$budgetRange))))
			unset($_SESSION['phones'][$key]);

	}

	// If there are less than 10 results, increase budget range and repeat
	if(sizeof($_SESSION['phones'])<10) {
		$_SESSION['phones'] = $backupDb;
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

foreach($_SESSION['phones'] as $key => $phone) {

	// Initialize available features empty array for each phone
	$_SESSION['phones'][$key]['available_features'] = array();

	if(isset($phone['summary']['expansion'])) {
		$initialFeatures['microSD']++;
		$_SESSION['phones'][$key]['available_features'][] = "microSD";
	}
	if(isset($phone['comms']['connectivity']) && in_array("NFC", $phone['comms']['connectivity'])) {
		$initialFeatures['nfc']++;
		$_SESSION['phones'][$key]['available_features'][] = "nfc";
	}
	if(isset($phone['sim']['slots']) && $phone['sim']['slots']==2) {
		$initialFeatures['dualSim']++;
		$_SESSION['phones'][$key]['available_features'][] = "dualSim";
	}
	if(isset($phone['comms']['radio']) && $phone['comms']['radio']==true) {
		$initialFeatures['radio']++;
		$_SESSION['phones'][$key]['available_features'][] = "radio";
	}
	if(isset($phone['battery']['charge_quick']) && $phone['battery']['charge_quick']==true) {
		$initialFeatures['fastCharging']++;
		$_SESSION['phones'][$key]['available_features'][] = "fastCharging";
	}
	if(isset($phone['battery']['charge_wireless']) && $phone['battery']['charge_wireless']==true) {
		$initialFeatures['wirelessCharging']++;
		$_SESSION['phones'][$key]['available_features'][] = "wirelessCharging";
	}
	if(isset($phone['multimedia']['3mm_jack']) && $phone['multimedia']['3mm_jack']==true) {
		$initialFeatures['headphoneJack']++;
		$_SESSION['phones'][$key]['available_features'][] = "headphoneJack";
	}

}

// Assign initial features on session
$_SESSION['initial_features'] = array();
foreach($initialFeatures as $key => $feature) {

	if($feature>=3)
		$_SESSION['initial_features'][$key] = $key;

}
