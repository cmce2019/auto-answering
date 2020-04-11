<?php
require 'Meli/meli.php';
require 'configApp.php';

class Mc_questions{
    private $url="https://autoanswering-47a3a.firebaseio.com/autoanswer.json";
    private $access_token;
    private $refresh_token;
    private $meli;
    private $appId;
    private $secretKey;
    private $resource;
    public function __construct($appId,$secretKey,$resource) {
        $this->resource=$resource;
        $this->appId=$appId;
        $this->secretKey=$secretKey;
        $this->getToken();
    }
    public function testToken($test_access_token,$test_refresh_token){
        $this->meli = new Meli($this->appId, $this->secretKey,$test_access_token,$test_refresh_token);
        $params = array(
            'app_id'=>$this->appId,
            'access_token'=>$test_access_token
        );
        $test=$this->meli->get('/myfeeds',$params);
        if($test['httpCode']==400){
            $this->updateToken($test_access_token,$test_refresh_token);
            return false;
        }
        return true;
    }
    public function getToken(){
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response= curl_exec($ch);
        if(curl_error($ch)){
            echo 'Error '.curl_error($ch);
        }else{
            $response_array=json_decode($response);
            if ($this->testToken($response_array->access_token,$response_array->refresh_token)){
                $this->access_token=$response_array->access_token;
                $this->refresh_token=$response_array->refresh_token;
            }
            $this->answerQuestion();
        }
        curl_close($ch);
    }
    public function updateToken($test_access_token,$test_refresh_token){
        $this->meli = new Meli($this->appId, $this->secretKey,$test_access_token,$test_refresh_token);
        $auth=$this->meli->refreshAccessToken();
        $this->access_token=$auth['body']->access_token;
        $this->refresh_token=$auth['body']->refresh_token;
        $data='{"access_token":"'.$this->access_token.'","refresh_token":"'.$this->refresh_token.'"}';
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,$this->url);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: '.strlen($data)));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response= curl_exec($ch);
        if(curl_error($ch)){
            echo 'Error '.curl_error($ch);
        }else{
            $this->meli = new Meli($this->appId, $this->secretKey,$this->access_token,$this->refresh_token);
            echo 'Se ha actualizado el token';
        }
        curl_close($ch);
    }
    public function answerQuestion(){
        $uri="/questions/6919148641";
        $question=$this->meli->get($this->resource);
        if ($question['body']->status!="ANSWERED"){
            $params = array(
                'access_token'=>$this->access_token
            );
	    //if(strpos($question['body']->text,"disponible") !== false){
            $answer= array(
                "question_id"=>$question['body']->id,
                "text"=>"Buen día gracias por preguntar, si hay monedas, las 100k de monedas valen 32.000, sin embargo si tienes dudas del proceso 
                o quieres obtener más información mira la ultima foto de esta publicación: https://articulo.mercadolibre.com.co/MCO-558264979-ideapad-s540-14-intel-_JM."    
            );
            $answer_data=$this->meli->post("/answers", $answer, $params);
            if ($answer_data['body']->status=="ANSWERED"){
                header("HTTP/1.1 200"); 
                echo json_encode("Se ha respondido la pregunta");
            }else{
                header("HTTP/1.1 400");
                echo json_encode("No se ha respondido la pregunta");
            }
            /*}else{
		$des="carlosm.cordobae@gmail.com";
		$asunto="mc info";
		$mensaje="hay una pregunta";
		header("HTTP/1.1 200");
		echo(mail($des,$asunto,$mensaje));		
		}*/
        }else{
            header("HTTP/1.1 200"); 
            echo json_encode("Ya ha sido respondida");
        }   
    }
}

  
if($_SERVER['REQUEST_METHOD']=='POST'){
  
   $body = json_decode(file_get_contents("php://input"),true);
   if($body['topic']=='questions'){
        $mc_questions=new Mc_questions($appId,$secretKey,$body['resource']);
    }else{
        echo json_encode('Solo preguntas');
    }    
}
else{
    echo json_encode('Solo post de preguntas');
    header("HTTP/1.1 404"); 
}

?> 
