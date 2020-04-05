<?php
$url="https://autoanswering-47a3a.firebaseio.com/autoanswer.json";

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response= curl_exec($ch);
if(curl_error($ch)){
    echo 'Error '.curl_error($ch);
}else{
    $response_array=json_decode($response);
    echo $response_array->access_token;
    curl_close($ch);
}


?>