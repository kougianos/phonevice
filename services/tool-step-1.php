<?php

// Validate that budget and budget range are both set
if(!isset($_GET['budget'], $_GET['range']))
	header("Location: index.html");

// Strip unwanted characters 
$_GET['budget'] = preg_replace('/[^0-9]+/', '', $_GET['budget']);
$_GET['range'] = preg_replace('/[^0-9]+/', '', $_GET['range']);

// Original and backup database
$_SESSION['phones'] = json_decode(file_get_contents(__DIR__."/../database/dbApril2019.json"), true);
$backupDb = $_SESSION['phones'];

// Budget
$budget = $_GET['budget'];
$budgetRange = $_GET['range'];

// Calculate budget range if not set by user
if(!isset($budgetRange))
	$budgetRange = $budget/20;

// Budget algorithm
while(1) {

	// Loop phones
	foreach($_SESSION['phones'] as $key => $phone) {

		// Keep phones that have min or max price in budget range
		if(!(($phone['minPrice']>=($budget-$budgetRange) && $phone['minPrice']<=($budget+$budgetRange)) || ($phone['maxPrice']>=($budget-$budgetRange) && $phone['maxPrice']<=($budget+$budgetRange))))
			unset($_SESSION['phones'][$key]);
	
	}

	// If there are less than 10 results, increase budget range and repeat
	if(sizeof($_SESSION['phones'])<10) {
		$_SESSION['phones'] = $backupDb;
		$budgetRange += $budget/20;
	} else {
		break;
	}

}

echo "<pre>";
echo "Total results: ".sizeof($_SESSION['phones'])."\n";
foreach($_SESSION['phones'] as $phone) {
	echo "\nBrand-Model: ". $phone['summary']['brand']." ".$phone['summary']['model']."\n";
	echo "minPrice: ".$phone['minPrice']."\n";
	echo "maxPrice: ".$phone['maxPrice']."\n";
}
