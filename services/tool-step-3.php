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
	$w2batteryMax = $w2batteryMin = $_SESSION['phones'][0]['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'];

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

	// Unset phones that do not have all 9 features set
	if(!isset($phone['summary']['ram'], $phone['summary']['capacities'], $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Score'], $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'], $phone['display']['ppi'], $phone['benchmarks']
	['SLING_SHOT_ES_31']['Score'], $phone['summary']['weight'], $phone['display']['StB'], $phone['display']['diagonal'])) {
		unset($_SESSION['phones'][$key]);
		continue;
	}

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
	if($phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'] > $w2batteryMax)
		$w2batteryMax = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'];
	if($phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'] < $w2batteryMin)
		$w2batteryMin = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'];

	$_SESSION['phones'][$key]['scores']['w2battery'] = $phone['benchmarks']['PCMA_WORK_V2_DEFAULT']['Work 2_0 Battery life'];

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

echo "<pre>";

// Set custom use to false by default
$customUse = false;

// If user selected custom use
if(isset($_GET['usageSocial'])) {

	// Validation
	if(!isset($_GET['usageGaming'], $_GET['usageVideo']))
		header("Location: index.html");

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
foreach($_SESSION['phones'] as $key => $phone) {

	// Normalize using method (x-min)/(max-min) for each feature
	if($ramMax===$ramMin)
		$_SESSION['phones'][$key]['scores']['ram'] = 0;
	else
		$_SESSION['phones'][$key]['scores']['ram'] = ($_SESSION['phones'][$key]['scores']['ram'] - $ramMin) / ($ramMax - $ramMin);

	if($capacityMax===$capacityMin)
		$_SESSION['phones'][$key]['scores']['capacity'] = 0;
	else
		$_SESSION['phones'][$key]['scores']['capacity'] = ($_SESSION['phones'][$key]['scores']['capacity'] - $capacityMin) / ($capacityMax - $capacityMin);

	$_SESSION['phones'][$key]['scores']['w2score'] = ($_SESSION['phones'][$key]['scores']['w2score'] - $w2scoreMin) / ($w2scoreMax - $w2scoreMin);
	$_SESSION['phones'][$key]['scores']['w2battery'] = ($_SESSION['phones'][$key]['scores']['w2battery'] - $w2batteryMin) / ($w2batteryMax - $w2batteryMin);
	$_SESSION['phones'][$key]['scores']['ppi'] = ($_SESSION['phones'][$key]['scores']['ppi'] - $ppiMin) / ($ppiMax - $ppiMin);
	$_SESSION['phones'][$key]['scores']['grafix'] = ($_SESSION['phones'][$key]['scores']['grafix'] - $grafixMin) / ($grafixMax - $grafixMin);
	$_SESSION['phones'][$key]['scores']['weight'] = ($_SESSION['phones'][$key]['scores']['weight'] - $weightMin) / ($weightMax - $weightMin);
	$_SESSION['phones'][$key]['scores']['stb'] = ($_SESSION['phones'][$key]['scores']['stb'] - $stbMin) / ($stbMax - $stbMin);
	$_SESSION['phones'][$key]['scores']['diagonal'] = ($_SESSION['phones'][$key]['scores']['diagonal'] - $diagonalMin) / ($diagonalMax - $diagonalMin);

	// Calculate total score based on whether custom use was selected or not
	if($customUse===true) {

		$_SESSION['phones'][$key]['total_score'] = 
		(
			$_GET['usageSocial']/$usageTotal
		)
						* 
		(
			$socialWeights['w2score']	* $_SESSION['phones'][$key]['scores']['w2score'] 	+ 
			$socialWeights['ppi'] 		* $_SESSION['phones'][$key]['scores']['ppi'] 		+ 
			$socialWeights['w2battery'] 	* $_SESSION['phones'][$key]['scores']['w2battery'] 	+ 
			$socialWeights['stb'] 		* $_SESSION['phones'][$key]['scores']['stb'] 		+ 
			$socialWeights['diagonal'] 	* $_SESSION['phones'][$key]['scores']['diagonal'] 	+ 
			$socialWeights['weight'] 	* $_SESSION['phones'][$key]['scores']['weight'] 	+ 
			$socialWeights['ram'] 		* $_SESSION['phones'][$key]['scores']['ram'] 		+ 
			$socialWeights['capacity'] 	* $_SESSION['phones'][$key]['scores']['capacity'] 	+ 
			$socialWeights['grafix']	* $_SESSION['phones'][$key]['scores']['grafix']
		)
								+
		(
			$_GET['usageGaming']/$usageTotal
		)
						* 
		(
			$gamingWeights['w2score'] 	* $_SESSION['phones'][$key]['scores']['w2score'] 	+ 
			$gamingWeights['ppi'] 		* $_SESSION['phones'][$key]['scores']['ppi'] 		+ 
			$gamingWeights['w2battery'] 	* $_SESSION['phones'][$key]['scores']['w2battery'] 	+ 
			$gamingWeights['stb'] 		* $_SESSION['phones'][$key]['scores']['stb'] 		+ 
			$gamingWeights['diagonal'] 	* $_SESSION['phones'][$key]['scores']['diagonal'] 	+ 
			$gamingWeights['weight'] 	* $_SESSION['phones'][$key]['scores']['weight'] 	+ 
			$gamingWeights['ram'] 		* $_SESSION['phones'][$key]['scores']['ram'] 		+ 
			$gamingWeights['capacity'] 	* $_SESSION['phones'][$key]['scores']['capacity'] 	+ 
			$gamingWeights['grafix']	* $_SESSION['phones'][$key]['scores']['grafix']
		)
								+
		(
			$_GET['usageVideo']/$usageTotal
		)
						* 
		(
			$videoWeights['w2score'] 	* $_SESSION['phones'][$key]['scores']['w2score'] 	+ 
			$videoWeights['ppi'] 		* $_SESSION['phones'][$key]['scores']['ppi'] 		+ 
			$videoWeights['w2battery'] 	* $_SESSION['phones'][$key]['scores']['w2battery'] 	+ 
			$videoWeights['stb'] 		* $_SESSION['phones'][$key]['scores']['stb'] 		+ 
			$videoWeights['diagonal'] 	* $_SESSION['phones'][$key]['scores']['diagonal'] 	+ 
			$videoWeights['weight'] 	* $_SESSION['phones'][$key]['scores']['weight'] 	+ 
			$videoWeights['ram'] 		* $_SESSION['phones'][$key]['scores']['ram'] 		+ 
			$videoWeights['capacity'] 	* $_SESSION['phones'][$key]['scores']['capacity'] 	+ 
			$videoWeights['grafix']		* $_SESSION['phones'][$key]['scores']['grafix']
		);

	} else {

		$_SESSION['phones'][$key]['total_score'] = 

		$basicWeights['w2score'] 	* $_SESSION['phones'][$key]['scores']['w2score'] 	+ 
		$basicWeights['ppi'] 		* $_SESSION['phones'][$key]['scores']['ppi'] 		+ 
		$basicWeights['w2battery'] 	* $_SESSION['phones'][$key]['scores']['w2battery'] 	+ 
		$basicWeights['stb'] 		* $_SESSION['phones'][$key]['scores']['stb'] 		+ 
		$basicWeights['diagonal'] 	* $_SESSION['phones'][$key]['scores']['diagonal'] 	+ 
		$basicWeights['weight'] 	* $_SESSION['phones'][$key]['scores']['weight'] 	+ 
		$basicWeights['ram'] 		* $_SESSION['phones'][$key]['scores']['ram'] 		+ 
		$basicWeights['capacity'] 	* $_SESSION['phones'][$key]['scores']['capacity'] 	+ 
		$basicWeights['grafix']		* $_SESSION['phones'][$key]['scores']['grafix'];

	}

	// Push phone total score to scores array
	$scores[] = $_SESSION['phones'][$key]['total_score'];

}

// Sort phones based on scores array
array_multisort($scores, SORT_DESC, $_SESSION['phones']);

// Keep the best 3 phones
$phones = array_slice($_SESSION['phones'], 0, 3);
// $phones = $_SESSION['phones'];

foreach($phones as $key => $phone) {


	var_dump($phones[$key]['summary']['fullname']);
	var_dump($phones[$key]['total_score']);
	var_dump(round($phones[$key]['total_score']*1000)/10);
	// var_dump($phones[$key]['scores']);
	echo "----------\n";


}
