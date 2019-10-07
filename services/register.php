<?php

// Validation
if (!isset($_POST['action']) ||  $_POST['action'] !== "register") {
	echo "error";
	exit();
}

// Load users
$users = json_decode(file_get_contents(__DIR__."/../database/users.json"), true);

// Check for duplicate username
foreach($users as $key => $user) {

	if($user['username']===$_POST['username']) {
		echo "usernameExists";
		exit();
	}

}

// Successful registration
$users[$_POST['username']]['username'] = $_POST['username'];
$users[$_POST['username']]['password'] = hash("sha256", $_POST['password']);

// Save users as json
file_put_contents(__DIR__."/../database/users.json", json_encode($users));

unset($_SESSION['user']);
echo "success";
exit();
