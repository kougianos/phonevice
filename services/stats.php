<?php

// Load complete database
$phones = json_decode(file_get_contents(__DIR__ . "/../database/dbApril2019.json"), true);

// Stats variables
$brands = array();
$totalPhones = sizeof($phones);
$features = array(

	"microSD"		=>	0,
	"nfc"			=>	0,
	"dualSim"		=>	0,
	"radio"			=>	0,
	"fastCharging"		=>	0,
	"wirelessCharging"	=>	0,
	"headphoneJack"		=>	0,
	"fingerprintSensor"	=>	0,
	"waterproof"		=>	0

);


// Loop phones
foreach ($phones as $phone) {

	// Assign brand count to brands array
	if (isset($phone['summary']['brand'])) {

		if (!isset($brands[$phone['summary']['brand']])) {
			$brands[$phone['summary']['brand']] = 0;
			$brands[$phone['summary']['brand']]++;
		} else {
			$brands[$phone['summary']['brand']]++;
		}

	}

	// Features array
	if(isset($phone['summary']['expansion'])) {
		$features['microSD']++;
	}
	if(isset($phone['comms']['connectivity']) && in_array("NFC", $phone['comms']['connectivity'])) {
		$features['nfc']++;
	}
	if(isset($phone['sim']['slots']) && $phone['sim']['slots']==2) {
		$features['dualSim']++;
	}
	if(isset($phone['comms']['radio']) && $phone['comms']['radio']==true) {
		$features['radio']++;
	}
	if(isset($phone['battery']['charge_quick']) && $phone['battery']['charge_quick']==true) {
		$features['fastCharging']++;
	}
	if(isset($phone['battery']['charge_wireless']) && $phone['battery']['charge_wireless']==true) {
		$features['wirelessCharging']++;
	}
	if(isset($phone['multimedia']['3mm_jack']) && $phone['multimedia']['3mm_jack']==true) {
		$features['headphoneJack']++;
	}
	if(isset($phone['sensors']['biometric'])) {
		if(in_array("Fingerprint", $phone['sensors']['biometric']))
			$features['fingerprintSensor']++;
	}
	if(isset($phone['summary']['waterproof'])) {
		$features['waterproof']++;
	}

}

// Reverse sort brands
arsort($brands);
$brands = array_slice($brands, 0, 7, true);

// Assign smarty phones
$smarty->assignByRef('TOTALPHONES', $totalPhones);
$smarty->assign('BRANDS', json_encode($brands));
$smarty->assign('FEATURES', json_encode($features));
$smarty->assign('STATS', true);
