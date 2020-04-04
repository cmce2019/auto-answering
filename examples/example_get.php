<?php
session_start();
require '../Meli/meli.php';
require '../configApp.php';
 
$meli = new Meli($appId, $secretKey,$_SESSION['access_token'],$_SESSION['refresh_token']);

//var_dump($meli->getAuthUrl('http://localhost/php-sdk/examples/example_get.php','http://localhost/php-sdk/examples/example_get.php'));

$params = array();
$item= array(
    "question_id"=>6915595434,
    "text"=>"Si hay disponibles"
);
echo($_SESSION['access_token']);
$user_id=14611634;
$url= "/questions/search?seller_id=$user_id&access_token=".$_SESSION['access_token'];
$uri="/myfeeds?app_id=APP_USR-919119103695910-040421-1df6b58583dc49f24c7c88bc0a72ad59-14611634";

$result = $meli->get($uri, $params);
var_dump($result);
var_dump($meli->post("/answers?access_token=".$_SESSION['access_token'], $item, $params));

//var_dump($_SESSION);

echo '<pre>';
//print_r($result);
echo '</pre>';