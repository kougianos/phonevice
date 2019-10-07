<?php

// Validation
if (!isset($_POST['action']) ||  $_POST['action'] !== "login") {
	echo "error";
	exit();
}

// Load users
$users = json_decode(file_get_contents(__DIR__."/../database/users.json"), true);

// Check if user exists
if(isset($users[$_POST['username']])) {

	// Check password and assign to session
	if(hash("sha256", $_POST['password'])===$users[$_POST['username']]['password']) {
		echo "success";
		$_SESSION['user']['username'] = $_POST['username'];
		exit();
	} else {
		echo "wrongPass";
		exit();
	}

} else {

	echo "usernameNotFound";
	exit();

}
