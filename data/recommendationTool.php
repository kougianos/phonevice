<?php

// Original and backup database
$db = json_decode(file_get_contents(__DIR__."/../database/dbApril2019.json"), true);
$backupDb = $db;

// Budget
$budget = 50;
$budgetRange = 10;

// Calculate budget range if not set by user
if(!isset($budgetRange))
	$budgetRange = $budget/20;

// Budget algorithm
while(1) {

	// Loop phones
	foreach($db as $key => $phone) {

		// Keep phones that have min or max price in budget range
		if(!(($phone['minPrice']>=($budget-$budgetRange) && $phone['minPrice']<=($budget+$budgetRange)) || ($phone['maxPrice']>=($budget-$budgetRange) && $phone['maxPrice']<=($budget+$budgetRange))))
			unset($db[$key]);
	
	}

	// If there are less than 10 results, increase budget range and repeat
	if(sizeof($db)<10) {
		$db = $backupDb;
		$budgetRange += $budget/20;
	} else {
		break;
	}

}

// Features
$microSD = false;		// $phone['summary']['expansion']
$nfc = false;			// $phone['features']['nfc'] == false
$dualSim = false;		// $phone['features']['dual_sim'] == false
$radio = false;			// $phone['comms']['radio'] == false
$fastCharging = false;		// $phone['battery']['charge_quick'] == true
$wirelessCharging = false;	// $phone['battery']['charge_wireless'] == true
$headphoneJack = false;		// $phone['multimedia']['3mm_jack'] == true

foreach($backupDb as $d) {
	if(!isset($d['summary']['expansion']))
		continue;

	var_dump($d['summary']['expansion']);
}


