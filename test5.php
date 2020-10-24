<?php
require 'Meli/meli.php';
require 'configApp.php';

$meli = new Meli($appId, $secretKey,"APP_USR-919119103695910-102120-8d8e028bec1ec689b2d60f90399d679a-390630451","TG-5f83c01a44eaa50006398ccb-390630451");


$params = array(
    'access_token'=>"APP_USR-919119103695910-102120-8d8e028bec1ec689b2d60f90399d679a-390630451"
);

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"https://autoanswering-47a3a.firebaseio.com/auto_buymessage.json");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response= curl_exec($ch);
$answer_array=json_decode($response);
curl_close($ch);


$answer= array(
    "from"=>array("user_id"=>"390630451"),
    "to"=>array("user_id"=>"658157693"),
    "text"=>$answer_array[0]
);

$answer_data=$meli->post("/messages/packs/4093129401/sellers/390630451", $answer, $params);

header("HTTP/1.1 ".$answer_data['httpCode']);

echo $answer_data['httpCode']==201 ?  "Se ha respondido la compra" : "No se ha respondido la compra";

?>
