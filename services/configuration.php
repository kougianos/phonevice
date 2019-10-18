<?php
ini_set("session.cookie_secure", true);
ini_set("session.cookie_httponly", true);
session_name("PhoneVice");
session_start();
// $debug = true;
require_once('./smarty/libs/Smarty.class.php');
$smarty = new Smarty();

$smarty->setTemplateDir('./templates');
$smarty->setCompileDir('./smarty/templates_c');
$smarty->setCacheDir('./smarty/cache');
$smarty->setConfigDir('./smarty/configs');
$smarty->setPluginsDir('./smarty/plugins');

if(isset($debug)) {

	$smarty->setCaching(false);
	$smarty->assign('DEBUG', true);

} else {

	$smarty->force_compile = false;
	$smarty->compile_check = false;
	$smarty->setCaching(Smarty::CACHING_LIFETIME_SAVED);

}

// Default language: English
if(!isset($_SESSION['locale']))
	$_SESSION['locale'] = "2";

if(isset($_GET['locale'])) {

	switch($_GET['locale']) {
	case "el":
		$_SESSION['locale'] = "1";
		break;
	case "en":
		$_SESSION['locale'] = "2";
		break;
	}

}

if(isset($_SESSION['locale']) && is_numeric($_SESSION['locale'])) {

	$languages = array(
		"1" => array(
			"id"		=> 1,
			"ids"		=> array("el_cy", "el_gr", "el", "gr", "1", "greek"),
			"language"	=> "el",
			"region"	=> "gr",
			"locale"	=> "el_GR.utf8",
			"name"		=> "Ελληνικά"
			),
		"2" => array(
			"id"		=> 2,
			"ids"		=> array("en_au", "en_bz", "en_ca", "en_cb", "en_gb", "en_in", "en_ie", "en_jm", "en_nz", "en_ph", "en_za", "en_tt", "en_us", "en", "2", "english"),
			"language"	=> "en",
			"region"	=> "gb",
			"locale"	=> "en_GB.utf8",
			"name"		=> "English"
			)
	);

	if(isset($languages[$_SESSION['locale']])) {

		$_SESSION['localestr'] = $languages[$_SESSION['locale']]['name'];
		setlocale(LC_ALL, $languages[$_SESSION['locale']]['locale']);
		$smarty->assign('LANGUAGE', $languages[$_SESSION['locale']]['language']);
		$smarty->assign('LANGUAGE2', $languages[$_SESSION['locale']]['region']);
		$_SESSION['locale'] = (string)$languages[$_SESSION['locale']]['id'];
		bindtextdomain("phonevice", "./locale");
		textdomain("phonevice");

	}

}

$_action = $_SESSION['locale'];

if(isset($_SESSION['user']))
	$smarty->assignByRef('USER', $_SESSION['user']);
