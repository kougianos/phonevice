<?php

// Validation (check that phones are set and that the size of the array is less than 3)
if (!isset($_SESSION['phones']) || sizeof($_SESSION['phones']) < 3)
	header("Location: index.html");

// Re index array of phones
$_SESSION['phones'] = array_values($_SESSION['phones']);

// Initial mins and maxes
if(isset($_SESSION['phones'][0]['summary']['ram'])) {

	// Explode ram by comma
	$tmp = explode(",", $_SESSION['phones'][0]['summary']['ram']);

	// If last element contains MHz substring, take into account the element before (Largest RAM)
	if(preg_match('/MHz/', end($tmp)))
		$ramMax = $ramMin = preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]);
	else
		$ramMax = $ramMin = preg_replace('/[^0-9]+/', '', end($tmp));
	
}
if(isset($_SESSION['phones'][0]['summary']['capacities'])) {

	// Explode capacities by comma
	$tmp = explode(",", $_SESSION['phones'][0]['summary']['capacities']);

	// Largest capacity
	$capacityMax = $capacityMin = preg_replace('/[^0-9]+/', '', end($tmp));

}
if(isset($_SESSION['phones'][0]['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score']))
	$w2scoreMax = $w2scoreMin = $_SESSION['phones'][0]['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'];

if(isset($_SESSION['phones'][0]['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life']))
	$w2batteryMax = $w2batteryMin = preg_replace('/[^0-9]+/', '', $_SESSION['phones'][0]['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life']);

if(isset($_SESSION['phones'][0]['display']['ppi']))
	$ppiMax = $ppiMin = $_SESSION['phones'][0]['display']['ppi'];

if(isset($_SESSION['phones'][0]['benchmarks']['SLING_SHOT_ES_31']['Score']))
	$grafixMax = $grafixMin = $_SESSION['phones'][0]['benchmarks']['SLING_SHOT_ES_31']['Score'];

if(isset($_SESSION['phones'][0]['summary']['weight']))
	$weightMax = $weightMin = $_SESSION['phones'][0]['summary']['weight'];

if(isset($_SESSION['phones'][0]['display']['StB']))
	$stbMax = $stbMin = $_SESSION['phones'][0]['display']['StB'];

if(isset($_SESSION['phones'][0]['display']['diagonal']))
	$diagonalMax = $diagonalMin = $_SESSION['phones'][0]['display']['diagonal'];

// Calculate min and max for each phone feature
foreach($_SESSION['phones'] as $key => $phone) {

	// Scores array
	$_SESSION['phones'][$key]['scores'] = array();

	// Explode ram by comma
	$tmp = explode(",", $phone['summary']['ram']);

	// Min and max RAM
	if(preg_match('/MHz/', end($tmp))) {
		if(preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]) > $ramMax)
			$ramMax = preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]);
		if(preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]) < $ramMin)
			$ramMin = preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]);
		$_SESSION['phones'][$key]['scores']['ram'] = preg_replace('/[^0-9]+/', '', $tmp[sizeof($tmp)-2]);
	} else {
		if(preg_replace('/[^0-9]+/', '', end($tmp)) > $ramMax)
			$ramMax = preg_replace('/[^0-9]+/', '', end($tmp));
		if(preg_replace('/[^0-9]+/', '', end($tmp)) < $ramMin)
			$ramMin = preg_replace('/[^0-9]+/', '', end($tmp));
		$_SESSION['phones'][$key]['scores']['ram'] = preg_replace('/[^0-9]+/', '', end($tmp));
	}

	// Explode capacities by comma
	$tmp = explode(",", $phone['summary']['capacities']);

	// Min and max capacity
	if(preg_replace('/[^0-9]+/', '', end($tmp)) > $capacityMax)
		$capacityMax = preg_replace('/[^0-9]+/', '', end($tmp));
	if(preg_replace('/[^0-9]+/', '', end($tmp)) < $capacityMin)
		$capacityMin = preg_replace('/[^0-9]+/', '', end($tmp));

	$_SESSION['phones'][$key]['scores']['capacity'] =  preg_replace('/[^0-9]+/', '', end($tmp));

	
	// Min and max w2score
	if($phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'] > $w2scoreMax)
		$w2scoreMax = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'];
	if($phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'] < $w2scoreMin)
		$w2scoreMin = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'];

	$_SESSION['phones'][$key]['scores']['w2score'] = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'];
		
	// Min and max w2battery
	if(preg_replace('/[^0-9]+/', '', $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life']) > $w2batteryMax)
		$w2batteryMax = preg_replace('/[^0-9]+/', '', $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life']);
	if(preg_replace('/[^0-9]+/', '', $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life']) < $w2batteryMin)
		$w2batteryMin = preg_replace('/[^0-9]+/', '', $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life']);

	$_SESSION['phones'][$key]['scores']['w2battery'] = preg_replace('/[^0-9]+/', '', $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life']);

	// Min and max ppi 
	if($phone['display']['ppi'] > $ppiMax)
		$ppiMax = $phone['display']['ppi'];
	if($phone['display']['ppi'] < $ppiMin)
		$ppiMin = $phone['display']['ppi'];

	$_SESSION['phones'][$key]['scores']['ppi'] = $phone['display']['ppi'];

	// Min and max grafix
	if($phone['benchmarks']['SLING_SHOT_ES_31']['Score'] > $grafixMax)
		$grafixMax = $phone['benchmarks']['SLING_SHOT_ES_31']['Score'];
	if($phone['benchmarks']['SLING_SHOT_ES_31']['Score'] < $grafixMin)
		$grafixMin = $phone['benchmarks']['SLING_SHOT_ES_31']['Score'];

	$_SESSION['phones'][$key]['scores']['grafix'] = $phone['benchmarks']['SLING_SHOT_ES_31']['Score'];

	// Min and max weight
	if($phone['summary']['weight'] > $weightMax)
		$weightMax = $phone['summary']['weight'];
	if($phone['summary']['weight'] < $weightMin)
		$weightMin = $phone['summary']['weight'];

	$_SESSION['phones'][$key]['scores']['weight'] = $phone['summary']['weight'];

	// Min and max StB
	if($phone['display']['StB'] > $stbMax)
		$stbMax = $phone['display']['StB'];
	if($phone['display']['StB'] < $stbMin)
		$stbMin = $phone['display']['StB'];

	$_SESSION['phones'][$key]['scores']['stb'] = $phone['display']['StB'];

	// Min and max diagonal
	if($phone['display']['diagonal'] > $diagonalMax)
		$diagonalMax = $phone['display']['diagonal'];
	if($phone['display']['diagonal'] < $diagonalMin)
		$diagonalMin = $phone['display']['diagonal'];

	$_SESSION['phones'][$key]['scores']['diagonal'] = $phone['display']['diagonal'];
	
}

// If user selected custom use
if(isset($_GET['usageSocial'])) {

	// Validation
	if(!isset($_GET['usageGaming'], $_GET['usageVideo']))
		header("Location: index.html");

	// Strip unwanted characters and keep numbers only
	$_GET['usageSocial'] = preg_replace('/[^0-9]+/', '', $_GET['usageSocial']);
	$_GET['usageGaming'] = preg_replace('/[^0-9]+/', '', $_GET['usageGaming']);
	$_GET['usageVideo'] = preg_replace('/[^0-9]+/', '', $_GET['usageVideo']);

	$videoWeights = array(
		'w2score'	=>	0.01,
		'ppi'		=>	0.21,
		'w2battery'	=>	0.18,
		'stb'		=>	0.15,
		'diagonal'	=>	0.11,
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


// TODO CALCULATE TOTAL SCORES FOR EACH PHONE


// var_dump($_GET);

// Normalize feature scores for each phone
foreach($_SESSION['phones'] as $key => $phone) {

	// Normalize using method (x-min)/(max-min) for each feature
	$_SESSION['phones'][$key]['scores']['ram'] = ($_SESSION['phones'][$key]['scores']['ram'] - $ramMin) / ($ramMax - $ramMin);
	$_SESSION['phones'][$key]['scores']['capacity'] = ($_SESSION['phones'][$key]['scores']['capacity'] - $capacityMin) / ($capacityMax - $capacityMin);
	$_SESSION['phones'][$key]['scores']['w2score'] = ($_SESSION['phones'][$key]['scores']['w2score'] - $w2scoreMin) / ($w2scoreMax - $w2scoreMin);
	$_SESSION['phones'][$key]['scores']['w2battery'] = ($_SESSION['phones'][$key]['scores']['w2battery'] - $w2batteryMin) / ($w2batteryMax - $w2batteryMin);
	$_SESSION['phones'][$key]['scores']['ppi'] = ($_SESSION['phones'][$key]['scores']['ppi'] - $ppiMin) / ($ppiMax - $ppiMin);
	$_SESSION['phones'][$key]['scores']['grafix'] = ($_SESSION['phones'][$key]['scores']['grafix'] - $grafixMin) / ($grafixMax - $grafixMin);
	$_SESSION['phones'][$key]['scores']['weight'] = ($_SESSION['phones'][$key]['scores']['weight'] - $weightMin) / ($weightMax - $weightMin);
	$_SESSION['phones'][$key]['scores']['stb'] = ($_SESSION['phones'][$key]['scores']['stb'] - $stbMin) / ($stbMax - $stbMin);
	$_SESSION['phones'][$key]['scores']['diagonal'] = ($_SESSION['phones'][$key]['scores']['diagonal'] - $diagonalMin) / ($diagonalMax - $diagonalMin);

}

