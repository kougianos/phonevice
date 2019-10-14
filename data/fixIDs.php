<?php

$phones = json_decode(file_get_contents(__DIR__."/../database/dbApril2019.json"), true);

foreach($phones as $key => $phone) {

	if(isset($phone['features']))
		unset($phones[$key]['features']);

}

file_put_contents(__DIR__."/../database/dbApril2019.json", json_encode($phones));

