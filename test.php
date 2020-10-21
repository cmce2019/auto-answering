<?php


$data='{"site_id":"MCO"}';

$url="https://api.mercadolibre.com/users/test_user?access_token=APP_USR-919119103695910-102023-b111ced798129b417e25fbaf3fb500fc-390630451";

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,$url);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$response= curl_exec($ch);
if(curl_error($ch)){
    echo 'Error '.curl_error($ch);
}else{
    var_dump($response);
} 

?>
