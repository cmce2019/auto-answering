<?php
$data='{"access_token":"APP_USR-919119103695910-040421-1df6b58583dc49f24c7c88bc0a72ad59-14611634","refresh_token":"TG-5e88f99302046200065a60e9-14611634"}';
$url="https://autoanswering-47a3a.firebaseio.com/autoanswer.json";

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,$url);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response= curl_exec($ch);
if(curl_error($ch)){
    echo 'Error '.curl_error($ch);
}else{
    echo 'Ha insertado';
}

?>