<?php
require 'Meli/meli.php';
require 'configApp.php';

$meli = new Meli($appId, $secretKey,"APP_USR-8165220320761420-010920-21cf5f806d9dbbb1abe319892346c7c8-390630451","TG-5ff91e1f087c8500062cbf14-390630451");




$answer_data=$meli->get("/orders/4289443777");


//var_dump($answer_data)

var_dump($answer_data);



echo is_null(null) ? "a": "b";

//echo $answer_data['httpCode']==201 ?  "Se ha respondido la compra" : "No se ha respondido la compra";


?>
