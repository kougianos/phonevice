<?php

// Load phones
$phones = json_decode(file_get_contents(__DIR__."/../database/dbApril2019Pretty.json"), true);

$_SESSION['autocomplete'] = array();

// Assign phone fullname and id on session
foreach($phones as $phone) {

	$_SESSION['autocomplete']['names'][] = $phone['summary']['fullname'];
	$_SESSION['autocomplete']['ids'][] = $phone['_id']['$oid'];

}