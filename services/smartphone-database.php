<?php

// Brands autocomplete
if (isset($_GET['term'])) {

	// Assign brands to local variable for autocomplete
	$brands = $_SESSION['brands'];

	// Unset brands that do not match regular expression
	foreach ($brands as $key => $b) {

		if (!preg_match("/" . $_GET['term'] . "/i", $b))
			unset($brands[$key]);

	}

	header("Content-Type: application/json");
	echo json_encode($brands);
	exit();
	
}

// Brands ajax
if (isset($_POST['action']) && $_POST['action'] == "brands") {

	// Load complete database
	$phones = json_decode(file_get_contents(__DIR__ . "/../database/dbApril2019.json"), true);
	$phonenames = $_SESSION['autocomplete']['names'];
	$phoneids = $_SESSION['autocomplete']['ids'];

	// Loop phones and unset those that don't match the requested brand
	foreach($phones as $key => $phone) {

		if($phone['summary']['brand']!=$_POST['brand']) {
			unset($phones[$key]);
			unset($phonenames[$key]);
			unset($phoneids[$key]);
		}

	}

	// Prepare response
	$response = array();
	foreach($phonenames as $key => $name) {

		$response[$key]['value'] = $response[$key]['label'] = $name;
		$response[$key]['id'] = $phoneids[$key];
	
	}

	header("Content-Type: application/json");
	echo json_encode($response);
	exit();

}

// Load complete database
$phones = json_decode(file_get_contents(__DIR__ . "/../database/dbApril2019.json"), true);

// Brands array
$_SESSION['brands'] = array();

// Loop phones
foreach ($phones as $phone) {

	// Assign brandname to brands array
	if (isset($phone['summary']['brand']))
		$_SESSION['brands'][$phone['summary']['brand']] = $phone['summary']['brand'];
}

// Assign smarty phones
$smarty->assignByRef('PHONES', $phones);
$smarty->assignByRef('BRANDS', $_SESSION['brands']);
