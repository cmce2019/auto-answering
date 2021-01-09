<?php
require 'Meli/meli.php';
require 'configApp.php';

$meli = new Meli($appId, $secretKey,"APP_USR-8165220320761420-010903-4e4e84b1ea75278b9964a1ec348a24fe-390630451","TG-5ff91e1f087c8500062cbf14-390630451");


$params = array(
    'app_id'=>'8165220320761420',
    'access_token'=>"APP_USR-8165220320761420-010903-4e4e84b1ea75278b9964a1ec348a24fe-390630451",
    'seller_id'=>'390630451',
    'api_version'=>'2'
);


$answer_data=$meli->get("/questions/search",$params);


//var_dump($answer_data)

var_dump($answer_data['httpCode']);


var_dump($meli->refreshAccessToken());
header("HTTP/1.1 ".$answer_data['httpCode']);

//echo $answer_data['httpCode']==201 ?  "Se ha respondido la compra" : "No se ha respondido la compra";


?>
