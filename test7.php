<?php
require 'Meli/meli.php';
require 'configApp.php';

$meli = new Meli($appId, $secretKey,"APP_USR-8165220320761420-102423-0dd1be0eca84f77e1e341a4f6a3d81bf-390630451","TG-5f94b91200d11d00069d9d96-390630451");


$params = array(
    'access_token'=>"APP_USR-8165220320761420-102423-0dd1be0eca84f77e1e341a4f6a3d81bf-390630451"
);

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,"https://autoanswering-47a3a.firebaseio.com/auto_buymessage.json");
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response= curl_exec($ch);
$answer_array=json_decode($response);
curl_close($ch);


$answer= array(
    "from"=>array("user_id"=>"663060664"),
    "to"=>array("user_id"=>"663058632"),
    "text"=>$answer_array[0]
);

$answer_data=$meli->post("/messages/packs/4117141360/sellers/663060664", $answer, $params);

header("HTTP/1.1 ".$answer_data['httpCode']);

echo $answer_data['httpCode']==201 ?  "Se ha respondido la compra" : "No se ha respondido la compra";

?>
