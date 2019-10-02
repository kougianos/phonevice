<?php

$phones = json_decode(file_get_contents(__DIR__."/../database/dbApril2019.json"), true);

foreach($phones as $key => $phone) {

	$phones[$key]['available_features'] = array();

	if(isset($phone['summary']['expansion'])) {
		$phones[$key]['available_features'][] = "microSD";
	}
	if(isset($phone['comms']['connectivity']) && in_array("NFC", $phone['comms']['connectivity'])) {
		$phones[$key]['available_features'][] = "nfc";
	}
	if(isset($phone['sim']['slots']) && $phone['sim']['slots']==2) {
		$phones[$key]['available_features'][] = "dualSim";
	}
	if(isset($phone['comms']['radio']) && $phone['comms']['radio']==true) {
		$phones[$key]['available_features'][] = "radio";
	}
	if(isset($phone['battery']['charge_quick']) && $phone['battery']['charge_quick']==true) {
		$phones[$key]['available_features'][] = "fastCharging";
	}
	if(isset($phone['battery']['charge_wireless']) && $phone['battery']['charge_wireless']==true) {
		$phones[$key]['available_features'][] = "wirelessCharging";
	}
	if(isset($phone['multimedia']['3mm_jack']) && $phone['multimedia']['3mm_jack']==true) {
		$phones[$key]['available_features'][] = "headphoneJack";
	}
	if(isset($phone['sensors']['biometric'])) {
		if(in_array("Fingerprint", $phone['sensors']['biometric']))
			$phones[$key]['available_features'][] = "fingerprintSensor";
	}
	if(isset($phone['summary']['waterproof'])) {
		$phones[$key]['available_features'][] = "waterproof";
	}

}

file_put_contents(__DIR__."/../database/dbApril2019.json", json_encode($phones));

