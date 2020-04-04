<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
    header("HTTP/1.1 200");   
    echo json_encode('hola'); 
}else{
    header("HTTP/1.1 404"); 
}

?>