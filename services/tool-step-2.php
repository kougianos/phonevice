<?php

// Validation (check that phones are set and that the size of the array is less than 3)
if (!isset($_SESSION['phones']) || sizeof($_SESSION['phones']) < 3)
	header("Location: index.html");

// Execute code block only when at least 1 feature was selected on step 2
if (isset($_GET['features'])) {

	// Validation (check that requested features are part of the initial features array)
	if (array_intersect($_GET['features'], array_keys($_SESSION['initial_features'])) != $_GET['features'])
		header("Location: index.html");

	// Loop phones and unset those that don't have the requested features
	foreach ($_SESSION['phones'] as $key => $phone) {

		if (array_intersect($_GET['features'], $phone['available_features']) != $_GET['features'])
			unset($_SESSION['phones'][$key]);
			
	}
}

// Validation (ensure that after the code block execution at least 3 phones passed in the next step)
if (sizeof($_SESSION['phones']) < 3)
	header("Location: index.html");
