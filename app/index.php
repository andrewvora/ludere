<?php 
	//include classloader
	require __DIR__.'/../bootstrap/autoload.php';

	//bootstraps the laravel framework
	$app = require_once __DIR__.'/../bootstrap/start.php';

	$app->run();
?>