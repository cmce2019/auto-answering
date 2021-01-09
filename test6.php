<?php
require 'Meli/meli.php';
require 'configApp.php';

$meli = new Meli($appId, $secretKey,"APP_USR-754588974083468-010822-6fc93000262dd7ecea4b628ffebdba54-390630451","TG-5ff8e296087c8500062c70f7-390630451");


$params = array(
    'app_id'=>'754588974083468',
    'access_token'=>"APP_USR-754588974083468-010822-6fc93000262dd7ecea4b628ffebdba54-390630451"
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


//var_dump($answer_data);
echo(count($answer_data['body']->messages));

$test=$meli->get('/missed_feeds',$params);
var_dump($test);
header("HTTP/1.1 ".$answer_data['httpCode']);

//echo $answer_data['httpCode']==201 ?  "Se ha respondido la compra" : "No se ha respondido la compra";


?>
