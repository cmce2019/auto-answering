<?php
$data='{"7077055799":{"answer":"Buen día gracias por preguntar, si hay monedas, las 100k de monedas valen 32.000, sin embargo NO REALIZO VENTAS POR MERCADOLIBRE, dado que en caso de un reclamo no tengo forma de demostrar que entregué el producto. En este enlace puede realizar una compra de $1000 (https://articulo.mercadolibre.com.co/MCO-560290647-contacto-monedas-fifa-20-_JM) y obtendra mi cotacto si desea adquirir monedas, disponibilidad de más de 5 millones.","body ":"Cuanto vale 30 millones","item_id":"MCO535761216"}}';

$url="https://autoanswering-47a3a.firebaseio.com/questions.json";
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,$url);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
$response= curl_exec($ch);
if(curl_error($ch)){
    echo 'Error '.curl_error($ch);
}else{
    echo 'Ha insertado';
}

?>
