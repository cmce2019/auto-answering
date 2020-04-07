<?php
$des="carlosm.cordobae@gmail.com";
$from="eruedagaleano@gmail.com";
$asunto="mc info";
$mensaje="asasdddddddddd";
echo(mail($des,$asunto,$mensaje)." ".(strpos($asunto, "mca") !== false) );
phpinfo();
?>
