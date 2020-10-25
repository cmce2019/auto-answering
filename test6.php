<?php
require 'Meli/meli.php';
require 'configApp.php';

$meli = new Meli($appId, $secretKey,"APP_USR-8165220320761420-102423-0dd1be0eca84f77e1e341a4f6a3d81bf-390630451","TG-5f94b91200d11d00069d9d96-390630451");


$params = array(
    'access_token'=>"APP_USR-8165220320761420-102423-0dd1be0eca84f77e1e341a4f6a3d81bf-390630451"
);


$test=$meli->get('/orders/4113257751',$params);


$buyer_id=$test['body']->buyer->id;
$order_id=$test['body']->id;

$answer= array(
    "from"=>array("user_id"=>"390630451"),
    "to"=>array("user_id"=>$buyer_id),
    "text"=>"gracias por tu compra"
);

$answer_data=$meli->get("/messages/packs/4117249721/sellers/390630451",$params);

echo(count($answer_data['body']->messages));


header("HTTP/1.1 ".$answer_data['httpCode']);

//echo $answer_data['httpCode']==201 ?  "Se ha respondido la compra" : "No se ha respondido la compra";


?>
