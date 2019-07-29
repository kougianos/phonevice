<?php

require_once __DIR__ . "/vendor/autoload.php";

// $collection = (new MongoDB\Client)->test->users;

// $insertOneResult = $collection->insertOne([
//     'username' => 'admin',
//     'email' => 'admin@example.com',
//     'name' => 'Admin User',
// ]);

// printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

// var_dump($insertOneResult->getInsertedId());

$db = json_decode(file_get_contents("database/dbApril2019.json"), true);

foreach($db as $key => $d) {

	var_dump($d['_id']);

	var_dump($db[$key]["_id"]['$oid']);

	$db[$key]["_id"] = $db[$key]["_id"]['$oid'];

	var_dump($d['_id']);
	var_dump($db[$key]["_id"]);


	die();
}