<?php
require 'Meli/meli.php';
require 'configApp.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $access_token="APP_USR-919119103695910-040421-1df6b58583dc49f24c7c88bc0a72ad59-14611634";
    $refresh_token="TG-5e88f99302046200065a60e9-14611634";
    $meli = new Meli($appId, $secretKey,$access_token,$refresh_token);
    $uri="/questions/6915522983";
    $question=$meli->get($uri);
    if ($question['body']->status!="ANSWERED"){
        $seller_id=14611634;
        $params = array(
            'access_token'=>$access_token
        );
        $answer= array(
            "question_id"=>$question['body']->id,
            "text"=>"Si hay disponibles"
        );
        $answer_data=$meli->post("/answers", $answer, $params);
        if ($answer_data['body']->status=="ANSWERED"){
            header("HTTP/1.1 200"); 
            echo json_encode("Se ha respondido la pregunta");
        }else{
            header("HTTP/1.1 400");
            echo json_encode("No se ha respondido la pregunta");
        }
    }else{
        header("HTTP/1.1 404"); 
        echo json_encode("Ya ha sido respondida");
    }

}else{
    header("HTTP/1.1 404"); 
}

?>