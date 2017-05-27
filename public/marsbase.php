<?php

require dirname(__DIR__) . '/vendor/autoload.php';

try {
	$base = new app\Station();
	$base->execute($_POST['command']);
	$data = [
		'rovers' => $base->locateRovers()
	];
}
catch (\Exception $e) {
	$data = [
		'error' => $e->getMessage()
	];
}

header('Content-Type: application/json');
echo json_encode($data);