<?php


$data='{"site_id":"MCO"}';

$url="https://api.mercadolibre.com/users/test_user?access_token=APP_USR-8165220320761420-102423-0dd1be0eca84f77e1e341a4f6a3d81bf-390630451";

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
