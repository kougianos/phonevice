<?php

/**
 * Normalize method using (x-min)/(max-min)
 * @param float $x The value that will be normalized
 * @param float $min Min value
 * @param float $max Max value
 * @return float
 */
function normalize($x, $min, $max) {
	if($max===$min)
		return 0;
	return ($x-$min)/($max-$min);
}

// Validation array
$validationGetArray = array("phoneId", "usageSocial", "usageGaming", "usageVideo");

if(!isset($_GET['phoneId']) || sizeof($_GET)>4 || array_diff(array_keys($_GET), $validationGetArray)!==array()) {
	header("HTTP/1.0 400 Bad Request");
	exit();
}

// Phones
$phones = json_decode(file_get_contents(__DIR__."/../database/dbApril2019.json"), true);

// Loop phones
foreach($phones as $key => $phone) {

	// Unset phones that are not in requested ids
	if(!in_array($phone['_id'], $_GET['phoneId'])) {
		unset($phones[$key]);
		continue;
	}

	// Unset phones that do not have all 9 features set
	if(!isset($phone['summary']['ram'], $phone['summary']['capacities'], $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'], $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'], $phone['display']['ppi'], $phone['benchmarks']
	['SLING_SHOT_ES_31']['Score'], $phone['summary']['weight'], $phone['display']['StB'], $phone['display']['diagonal'])) {
		unset($phones[$key]);
		continue;
	}

}

// Re index array of phones
$phones = array_values($phones);

// Initial mins and maxes
if(isset($phones[0]['summary']['ram'])) {

	// Explode ram by comma
	$tmp = explode(",", $phones[0]['summary']['ram']);

	// If last element contains MHz substring, take into account the element before (Largest RAM)
	if(preg_match('/MHz/', end($tmp)))
		$ramMax = $ramMin = preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]);
	else
		$ramMax = $ramMin = preg_replace('/[^0-9]+/', '', end($tmp));
	
}
if(isset($phones[0]['summary']['capacities'])) {

	// Explode capacities by comma
	$tmp = explode(",", $phones[0]['summary']['capacities']);

	// Largest capacity
	$capacityMax = $capacityMin = preg_replace('/[^0-9]+/', '', end($tmp));

}
if(isset($phones[0]['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score']))
	$w2scoreMax = $w2scoreMin = $phones[0]['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'];

if(isset($phones[0]['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life']))
	$w2batteryMax = $w2batteryMin = $phones[0]['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'];

if(isset($phones[0]['display']['ppi']))
	$ppiMax = $ppiMin = $phones[0]['display']['ppi'];

if(isset($phones[0]['benchmarks']['SLING_SHOT_ES_31']['Score']))
	$grafixMax = $grafixMin = $phones[0]['benchmarks']['SLING_SHOT_ES_31']['Score'];

if(isset($phones[0]['summary']['weight']))
	$weightMax = $weightMin = $phones[0]['summary']['weight'];

if(isset($phones[0]['display']['StB']))
	$stbMax = $stbMin = $phones[0]['display']['StB'];

if(isset($phones[0]['display']['diagonal']))
	$diagonalMax = $diagonalMin = $phones[0]['display']['diagonal'];

// Calculate min and max for each phone feature
foreach($phones as $key => $phone) {

	// Scores array
	$phones[$key]['scores'] = array();

	// Explode ram by comma
	$tmp = explode(",", $phone['summary']['ram']);

	// Min and max RAM
	if(preg_match('/MHz/', end($tmp))) {
		if(preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]) > $ramMax)
			$ramMax = preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]);
		if(preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]) < $ramMin)
			$ramMin = preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]);
		$phones[$key]['scores']['ram'] = preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]);
	} else {
		if(preg_replace('/[^0-9]+/', '', end($tmp)) > $ramMax)
			$ramMax = preg_replace('/[^0-9]+/', '', end($tmp));
		if(preg_replace('/[^0-9]+/', '', end($tmp)) < $ramMin)
			$ramMin = preg_replace('/[^0-9]+/', '', end($tmp));
		$phones[$key]['scores']['ram'] = preg_replace('/[^0-9]+/', '', end($tmp));
	}

	// Explode capacities by comma
	$tmp = explode(",", $phone['summary']['capacities']);

	// Min and max capacity
	if(preg_replace('/[^0-9]+/', '', end($tmp)) > $capacityMax)
		$capacityMax = preg_replace('/[^0-9]+/', '', end($tmp));
	if(preg_replace('/[^0-9]+/', '', end($tmp)) < $capacityMin)
		$capacityMin = preg_replace('/[^0-9]+/', '', end($tmp));

	$phones[$key]['scores']['capacity'] =  preg_replace('/[^0-9]+/', '', end($tmp));

	
	// Min and max w2score
	if($phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'] > $w2scoreMax)
		$w2scoreMax = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'];
	if($phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'] < $w2scoreMin)
		$w2scoreMin = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'];

	$phones[$key]['scores']['w2score'] = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'];

	// Min and max w2battery
	if($phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'] > $w2batteryMax)
		$w2batteryMax = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'];
	if($phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'] < $w2batteryMin)
		$w2batteryMin = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'];

	$phones[$key]['scores']['w2battery'] = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'];

	// Min and max ppi 
	if($phone['display']['ppi'] > $ppiMax)
		$ppiMax = $phone['display']['ppi'];
	if($phone['display']['ppi'] < $ppiMin)
		$ppiMin = $phone['display']['ppi'];

	$phones[$key]['scores']['ppi'] = $phone['display']['ppi'];

	// Min and max grafix
	if($phone['benchmarks']['SLING_SHOT_ES_31']['Score'] > $grafixMax)
		$grafixMax = $phone['benchmarks']['SLING_SHOT_ES_31']['Score'];
	if($phone['benchmarks']['SLING_SHOT_ES_31']['Score'] < $grafixMin)
		$grafixMin = $phone['benchmarks']['SLING_SHOT_ES_31']['Score'];

	$phones[$key]['scores']['grafix'] = $phone['benchmarks']['SLING_SHOT_ES_31']['Score'];

	// Min and max weight
	if($phone['summary']['weight'] > $weightMax)
		$weightMax = $phone['summary']['weight'];
	if($phone['summary']['weight'] < $weightMin)
		$weightMin = $phone['summary']['weight'];

	$phones[$key]['scores']['weight'] = $phone['summary']['weight'];

	// Min and max StB
	if($phone['display']['StB'] > $stbMax)
		$stbMax = $phone['display']['StB'];
	if($phone['display']['StB'] < $stbMin)
		$stbMin = $phone['display']['StB'];

	$phones[$key]['scores']['stb'] = $phone['display']['StB'];

	// Min and max diagonal
	if($phone['display']['diagonal'] > $diagonalMax)
		$diagonalMax = $phone['display']['diagonal'];
	if($phone['display']['diagonal'] < $diagonalMin)
		$diagonalMin = $phone['display']['diagonal'];

	$phones[$key]['scores']['diagonal'] = $phone['display']['diagonal'];
	
}

// Set custom use to false by default
$customUse = false;

// If user selected custom use
if(isset($_GET['usageSocial']) || isset($_GET['usageGaming']) || isset($_GET['usageVideo'])) {

	// Validation
	if(!isset($_GET['usageGaming'], $_GET['usageVideo'], $_GET['usageSocial'])) {
		header("HTTP/1.0 400 Bad Request");
		exit();
	}

	// Numeric Validation
	if(!is_numeric($_GET['usageGaming']) || !is_numeric($_GET['usageSocial']) || !is_numeric($_GET['usageVideo'])) {
		header("HTTP/1.0 400 Bad Request");
		exit();
	}

	// Set custom use to true to be used later in score calculation
	$customUse = true;

	// Strip unwanted characters and keep numbers only
	$_GET['usageSocial'] = preg_replace('/[^0-9]+/', '', $_GET['usageSocial']);
	$_GET['usageGaming'] = preg_replace('/[^0-9]+/', '', $_GET['usageGaming']);
	$_GET['usageVideo'] = preg_replace('/[^0-9]+/', '', $_GET['usageVideo']);

	// Calculate sum of usages
	$usageTotal = $_GET['usageSocial'] + $_GET['usageGaming'] + $_GET['usageVideo'];

	$videoWeights = array(
		'w2score'	=>	0.01,
		'ppi'		=>	0.18,
		'w2battery'	=>	0.19,
		'stb'		=>	0.15,
		'diagonal'	=>	0.12,
		'weight'	=>	-0.18,
		'ram'		=>	0.04,
		'capacity'	=>	0.04,
		'grafix'	=>	0.08
	);

	$gamingWeights = array(
		'w2score'	=>	0.03,
		'ppi'		=>	0.15,
		'w2battery'	=>	0.15,
		'stb'		=>	-0.13,
		'diagonal'	=>	0.07,
		'weight'	=>	-0.07,
		'ram'		=>	0.10,
		'capacity'	=>	0.04,
		'grafix'	=>	0.26
	);

	$socialWeights = array(
		'w2score'	=>	0.03,
		'ppi'		=>	0.13,
		'w2battery'	=>	0.21,
		'stb'		=>	0.09,
		'diagonal'	=>	0.08,
		'weight'	=>	-0.22,
		'ram'		=>	0.12,
		'capacity'	=>	0.05,
		'grafix'	=>	0.08
	);

} else {

	$basicWeights = array(
		'w2score'	=>	0.05,
		'ppi'		=>	0.12,
		'w2battery'	=>	0.19,
		'stb'		=>	0.08,
		'diagonal'	=>	0.07,
		'weight'	=>	-0.20,
		'ram'		=>	0.14,
		'capacity'	=>	0.06,
		'grafix'	=>	0.10
	);

}

// Scores array to be used in multisort after calculation of phone scores
$scores = array();

// Normalize feature scores for each phone and calculate total score
foreach($phones as $key => $phone) {

	// Normalize using method (x-min)/(max-min) for each feature
	$phones[$key]['scores']['ram'] = normalize($phones[$key]['scores']['ram'], $ramMin, $ramMax);
	$phones[$key]['scores']['capacity'] = normalize($phones[$key]['scores']['capacity'], $capacityMin, $capacityMax);
	$phones[$key]['scores']['w2score'] = normalize($phones[$key]['scores']['w2score'], $w2scoreMin, $w2scoreMax);
	$phones[$key]['scores']['w2battery'] = normalize($phones[$key]['scores']['w2battery'], $w2batteryMin, $w2batteryMax);
	$phones[$key]['scores']['ppi'] = normalize($phones[$key]['scores']['ppi'], $ppiMin, $ppiMax);
	$phones[$key]['scores']['grafix'] = normalize($phones[$key]['scores']['grafix'], $grafixMin, $grafixMax);
	$phones[$key]['scores']['weight'] = normalize($phones[$key]['scores']['weight'], $weightMin, $weightMax);
	$phones[$key]['scores']['stb'] = normalize($phones[$key]['scores']['stb'], $stbMin, $stbMax);
	$phones[$key]['scores']['diagonal'] = normalize($phones[$key]['scores']['diagonal'], $diagonalMin, $diagonalMax);

	// Calculate total score based on whether custom use was selected or not
	if($customUse===true) {

		$phones[$key]['total_score'] = 
		(
			$_GET['usageSocial']/$usageTotal
		)
						* 
		(
			$socialWeights['w2score']	* $phones[$key]['scores']['w2score'] 	+ 
			$socialWeights['ppi'] 		* $phones[$key]['scores']['ppi'] 		+ 
			$socialWeights['w2battery'] 	* $phones[$key]['scores']['w2battery'] 	+ 
			$socialWeights['stb'] 		* $phones[$key]['scores']['stb'] 		+ 
			$socialWeights['diagonal'] 	* $phones[$key]['scores']['diagonal'] 	+ 
			$socialWeights['weight'] 	* $phones[$key]['scores']['weight'] 	+ 
			$socialWeights['ram'] 		* $phones[$key]['scores']['ram'] 		+ 
			$socialWeights['capacity'] 	* $phones[$key]['scores']['capacity'] 	+ 
			$socialWeights['grafix']	* $phones[$key]['scores']['grafix']
		)
								+
		(
			$_GET['usageGaming']/$usageTotal
		)
						* 
		(
			$gamingWeights['w2score'] 	* $phones[$key]['scores']['w2score'] 	+ 
			$gamingWeights['ppi'] 		* $phones[$key]['scores']['ppi'] 		+ 
			$gamingWeights['w2battery'] 	* $phones[$key]['scores']['w2battery'] 	+ 
			$gamingWeights['stb'] 		* $phones[$key]['scores']['stb'] 		+ 
			$gamingWeights['diagonal'] 	* $phones[$key]['scores']['diagonal'] 	+ 
			$gamingWeights['weight'] 	* $phones[$key]['scores']['weight'] 	+ 
			$gamingWeights['ram'] 		* $phones[$key]['scores']['ram'] 		+ 
			$gamingWeights['capacity'] 	* $phones[$key]['scores']['capacity'] 	+ 
			$gamingWeights['grafix']	* $phones[$key]['scores']['grafix']
		)
								+
		(
			$_GET['usageVideo']/$usageTotal
		)
						* 
		(
			$videoWeights['w2score'] 	* $phones[$key]['scores']['w2score'] 	+ 
			$videoWeights['ppi'] 		* $phones[$key]['scores']['ppi'] 		+ 
			$videoWeights['w2battery'] 	* $phones[$key]['scores']['w2battery'] 	+ 
			$videoWeights['stb'] 		* $phones[$key]['scores']['stb'] 		+ 
			$videoWeights['diagonal'] 	* $phones[$key]['scores']['diagonal'] 	+ 
			$videoWeights['weight'] 	* $phones[$key]['scores']['weight'] 	+ 
			$videoWeights['ram'] 		* $phones[$key]['scores']['ram'] 		+ 
			$videoWeights['capacity'] 	* $phones[$key]['scores']['capacity'] 	+ 
			$videoWeights['grafix']		* $phones[$key]['scores']['grafix']
		);

	} else {

		$phones[$key]['total_score'] = 

		$basicWeights['w2score'] 	* $phones[$key]['scores']['w2score'] 	+ 
		$basicWeights['ppi'] 		* $phones[$key]['scores']['ppi'] 		+ 
		$basicWeights['w2battery'] 	* $phones[$key]['scores']['w2battery'] 	+ 
		$basicWeights['stb'] 		* $phones[$key]['scores']['stb'] 		+ 
		$basicWeights['diagonal'] 	* $phones[$key]['scores']['diagonal'] 	+ 
		$basicWeights['weight'] 	* $phones[$key]['scores']['weight'] 	+ 
		$basicWeights['ram'] 		* $phones[$key]['scores']['ram'] 		+ 
		$basicWeights['capacity'] 	* $phones[$key]['scores']['capacity'] 	+ 
		$basicWeights['grafix']		* $phones[$key]['scores']['grafix'];

	}

	// Push phone total score to scores array
	$scores[] = $phones[$key]['total_score'];

}

// Sort phones based on scores array
array_multisort($scores, SORT_DESC, $phones);

// Keep the best 3 phones
$phones = array_slice($phones, 0, 3);

// Set the correct mime type
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

echo json_encode($phones, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

exit();
