<?php

require dirname(__DIR__) . '/vendor/autoload.php';

try {
	$base = new app\Base();
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

print_r($data);

//header('Content-Type: application/json');
//echo json_encode($data);