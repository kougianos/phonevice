<?php

// Check if user is set
if(isset($_SESSION['user'])) {

	unset($_SESSION['user']);
	echo "success";

} else {

	echo "userNotSet";
	exit();

}
