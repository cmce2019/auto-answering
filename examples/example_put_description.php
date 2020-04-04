<?php
session_start();

require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey);


	// We can check if the access token in invalid checking the time
	if($_SESSION['expires_in'] + time() + 1 < time()) {
		try {
		    print_r($meli->refreshAccessToken());
		} catch (Exception $e) {
		  	echo "Exception: ",  $e->getMessage(), "\n";
		}
	}
	
	$params = array('access_token' => $_SESSION['access_token']);

	$body = array('plain_text' => 'Adding new description <strong>html</strong>');

	$response = $meli->put('/items/MLB12343412/descriptions', $body, $params);

	var_dump($response);
	