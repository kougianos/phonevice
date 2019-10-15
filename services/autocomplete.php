<?php

// GET validation
if(!isset($_GET['term']))
	exit();

// Phone names and ids
$phonenames = $_SESSION['autocomplete']['names'];
$phoneids = $_SESSION['autocomplete']['ids'];

// Loop phones and unset those that don't match regular expression
foreach($phonenames as $key => $name) {

	if(!preg_match("/".$_GET['term']."/i", $name))
		unset($phonenames[$key], $phoneids[$key]);

}

// Slice arrays
$phonenames = array_slice($phonenames, 0, 10);
$phoneids = array_slice($phoneids, 0, 10);

// Prepare response
$response = array();

foreach($phonenames as $key => $name) {

	$response[$key]['value'] = $response[]['label'] = $name;
	$response[$key]['id'] = $phoneids[$key];

}


echo json_encode($response);
// echo json_encode($_GET);

exit();
