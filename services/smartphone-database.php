<?php

$phones = json_decode(file_get_contents(__DIR__."/../database/dbApril2019.json"), true);

$brands = array();

foreach($phones as $phone) {

	if(isset($phone['summary']['brand']))
		$brands[$phone['summary']['brand']] = $phone['summary']['brand'];

}

// Assign smarty phones
$smarty->assignByRef('PHONES', $phones);
$smarty->assignByRef('BRANDS', $brands);
