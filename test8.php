<?php
require 'Meli/meli.php';
require 'configApp.php';

$meli = new Meli($appId, $secretKey,"APP_USR-8165220320761420-011119-a2c55a8ac59d288e01a6f76814a5ef01-390630451","TG-5ffca397be96150006913e47-390630451");


$params = array(
    'app_id'=>'8165220320761420',
    'access_token'=>"APP_USR-8165220320761420-011119-a2c55a8ac59d288e01a6f76814a5ef01-390630451",
    'seller_id'=>'390630451',
    'api_version'=>'2'
);


$answer_data=$meli->get("/questions/search",$params);


//var_dump($answer_data)

//var_dump($answer_data['httpCode']);


$a=$meli->refreshAccessToken();


$data='{"access_token":"'.$a['body']->access_token.'","refresh_token":"'.$a['body']->refresh_token.'"}';
$b= json_encode($a);

echo $b;

//var_dump($a);
header("HTTP/1.1 ".$answer_data['httpCode']);

//echo $answer_data['httpCode']==201 ?  "Se ha respondido la compra" : "No se ha respondido la compra";


?>
