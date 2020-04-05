<?php
session_start();
require '../Meli/meli.php';
require '../configApp.php';

$meli = new Meli($appId, $secretKey,$_SESSION['access_token'],$_SESSION['refresh_token']);
$auth=$meli->refreshAccessToken();
print_r($auth);

var_dump($meli->getAuthUrl('http://localhost/php-sdk/examples/example_get.php','http://localhost/php-sdk/examples/example_get.php'));

$params = array();
$item= array(
    "question_id"=>6914506454,
    "text"=>"Si hay disponibles"
);
//$url = '/users/14611634';
$token=$auth['body']->access_token;
echo($token);
$user_id=14611634;
$url= "/questions/search?seller_id=$user_id&access_token=$token&status=UNANSWERED";


$result = $meli->get($url, $params);
var_dump($result);
//var_dump($meli->post("/answers?access_token=$token", $item, $params));

//var_dump($_SESSION);

echo '<pre>';
print_r($result);
echo '</pre>';