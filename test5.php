<?php
require 'Meli/meli.php';
require 'configApp.php';

$meli = new Meli($appId, $secretKey,"APP_USR-8165220320761420-010703-0152ebd7cb9319752fbae2e2ffc91ca0-661466651","TG-5ff67e867e9138000636a3d7-661466651");


$params = array(
    'app_id'=>"",
    'access_token'=>"APP_USR-8165220320761420-010703-0152ebd7cb9319752fbae2e2ffc91ca0-661466651"
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
    "text"=>"gracias"
);



$answer_data=$meli->post("/messages/packs/4093129401/sellers/390630451", $answer, $params);

header("HTTP/1.1 ".$answer_data['httpCode']);
$test=meli->get('/myfeeds',$params);
var_dump($answer_data);

echo $answer_data['httpCode']==201 ?  "Se ha respondido la compra" : "No se ha respondido la compra";

?>
