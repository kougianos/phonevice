<?php

// Validation array
$validationGetArray = array("budget");

if(!isset($_GET['budget']) || sizeof($_GET)>1 || array_diff(array_keys($_GET), $validationGetArray)!==array())
	header("Location: index.html");

// Strip unwanted characters 
$_GET['budget'] = preg_replace('/[^0-9]+/', '', $_GET['budget']);

// Original and backup database
$_SESSION['phones'] = json_decode(file_get_contents(__DIR__."/../database/dbApril2019.json"), true);
$backupDb = $_SESSION['phones'];

// Budget
$budget = $_GET['budget'];

$minimumBudget = 0.75*$budget;
$maximumBudget = $budget + 0.055*$budget;

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
		if(!(($phone['minPrice']>=$minimumBudget && $phone['minPrice']<=$maximumBudget) || ($phone['maxPrice']>=$minimumBudget && $phone['maxPrice']<=$maximumBudget)))
			unset($_SESSION['phones'][$key]);

	}

	// If there are less than 10 results, increase budget range and repeat
	if(sizeof($_SESSION['phones'])<10) {
		$_SESSION['phones'] = $backupDb;
		$maximumBudget += $maximumBudget/20;
		$minimumBudget -= $budget/$minimumBudget;
	} else {
		break;
	}

}

// Initial features array with feature count, img URL and feature name as array elements
$initialFeatures = array(

	'microSD'		=>	array(0, "img/features/storage.png", "Storage expansion"),
	'nfc'			=>	array(0, "img/features/nfc.png", "NFC"),
	'dualSim'		=>	array(0, "img/features/dualsim.png", "Dual SIM"),
	'radio'			=>	array(0, "img/features/radio.png", "Radio"),
	'fastCharging'		=>	array(0, "img/features/fastcharging.png", "Fast Charging"),
	'wirelessCharging'	=>	array(0, "img/features/wirelesscharging.png", "Wireless Charging"),
	'headphoneJack'		=>	array(0, "img/features/headphone.png", "Headphone Jack"),
	'fingerprintSensor'	=>	array(0, "img/features/fingerprint.png", "Fingerprint Sensor"),
	'waterproof'		=>	array(0, "img/features/waterproof.png", "Waterproof")

);

foreach($_SESSION['phones'] as $key => $phone) {

	// Initialize available features empty array for each phone
	$_SESSION['phones'][$key]['available_features'] = array();

	if(isset($phone['summary']['expansion'])) {
		$initialFeatures['microSD'][0]++;
		$_SESSION['phones'][$key]['available_features'][] = "microSD";
	}
	if(isset($phone['comms']['connectivity']) && in_array("NFC", $phone['comms']['connectivity'])) {
		$initialFeatures['nfc'][0]++;
		$_SESSION['phones'][$key]['available_features'][] = "nfc";
	}
	if(isset($phone['sim']['slots']) && $phone['sim']['slots']==2) {
		$initialFeatures['dualSim'][0]++;
		$_SESSION['phones'][$key]['available_features'][] = "dualSim";
	}
	if(isset($phone['comms']['radio']) && $phone['comms']['radio']==true) {
		$initialFeatures['radio'][0]++;
		$_SESSION['phones'][$key]['available_features'][] = "radio";
	}
	if(isset($phone['battery']['charge_quick']) && $phone['battery']['charge_quick']==true) {
		$initialFeatures['fastCharging'][0]++;
		$_SESSION['phones'][$key]['available_features'][] = "fastCharging";
	}
	if(isset($phone['battery']['charge_wireless']) && $phone['battery']['charge_wireless']==true) {
		$initialFeatures['wirelessCharging'][0]++;
		$_SESSION['phones'][$key]['available_features'][] = "wirelessCharging";
	}
	if(isset($phone['multimedia']['3mm_jack']) && $phone['multimedia']['3mm_jack']==true) {
		$initialFeatures['headphoneJack'][0]++;
		$_SESSION['phones'][$key]['available_features'][] = "headphoneJack";
	}
	if(isset($phone['sensors']['biometric'])) {
		if(in_array("Fingerprint", $phone['sensors']['biometric'])) {
			$initialFeatures['fingerprintSensor'][0]++;
			$_SESSION['phones'][$key]['available_features'][] = "fingerprintSensor";
		}
	}
	if(isset($phone['summary']['waterproof'])) {
		$initialFeatures['waterproof'][0]++;
		$_SESSION['phones'][$key]['available_features'][] = "waterproof";
	}

}

// Assign initial features on session
$_SESSION['initial_features'] = array();
foreach ($initialFeatures as $key => $feature) {

	if ($feature[0] >= 3)
		$_SESSION['initial_features'][$key] = $feature;

}
