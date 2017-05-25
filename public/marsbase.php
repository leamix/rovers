<?php

require "/app/CommandException.php";
require "/app/CommandParser.php";
require "/app/Plateau.php";
require "/app/Coordinates.php";
require "/app/Rover.php";
require "/app/Base.php";

try {
	$base = new \app\Base();
	$base->execute($_POST);
	$data = [
		'rovers' => $base->locateRovers()
	];
}
catch (\Exception $e) {
	$data = [
		'error' => $e->getMessage()
	];
}

print_r($data);

//header('Content-Type: application/json');
//echo json_encode($data);