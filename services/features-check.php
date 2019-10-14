<?php

// Validation
if (!isset($_POST['action']) ||  $_POST['action'] !== "features_check") {
	echo "error";
	exit();
}

// Exit if no feature is selected
if (!isset($_POST['features'])) {
	echo "none-selected";
	exit();
}
// Create features to check and selected features arrays
$featuresToCheck = array();
foreach($_SESSION['initial_features'] as $key => $f)
	$featuresToCheck[] = $key;
$selectedFeatures = array();
foreach ($_POST['features'] as $f) {
	unset($featuresToCheck[$f['value']]);
	$selectedFeatures[] = $f['value'];
}

// Create available features array
$availableFeatures = array();
$unavailableFeatures = array();

// Loop features
foreach ($featuresToCheck as $feature) {

	// Initial values for each feature
	$featureOccurences = 0;
	$isFeatureAvailable = false;

	$selectedFeaturesTemp = array_merge($selectedFeatures, array($feature));

	// Loop phones
	foreach ($_SESSION['phones'] as $phone) {

		// array_intersect($array1, $array2) returns an array containing all the values of array1 that are present in all the arguments. Note that keys are preserved.
		if(array_intersect($selectedFeaturesTemp, $phone['available_features'])==$selectedFeaturesTemp)
			$featureOccurences++;

	}

	if($featureOccurences>=3)
		$availableFeatures[] = $feature;
	else
		$unavailableFeatures[] = $feature;

}

// Set correct header and echo JSON response
header("Content-Type: application/json");
echo json_encode($unavailableFeatures, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
