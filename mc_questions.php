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
        
        $default_answer="";
        $question=$this->meli->get($this->resource);
        if ($question['body']->status!="ANSWERED"){
            
            $params = array(
                'access_token'=>$this->access_token
            );
	    if(strpos($question['body']->text,"disponible") !== false){
            curl_setopt($ch,CURLOPT_URL,"https://autoanswering-47a3a.firebaseio.com/auto_message.json");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response= curl_exec($ch);
            $answer_array=json_decode($response);
            $default_answer= $answer_array[rand(0,count($answer_array)-1)];
            curl_close($ch);
            $answer= array(
                "question_id"=>$question['body']->id,
                "text"=>$default_answer    
            );

            $answer_data=$this->meli->post("/answers", $answer, $params);
            if ($answer_data['body']->status=="ANSWERED"){
                header("HTTP/1.1 200"); 
                echo json_encode("Se ha respondido la pregunta");
            }else{
                header("HTTP/1.1 400");
                echo json_encode("No se ha respondido la pregunta");
            }
            }else{
                $des="carlosm.cordobae@gmail.com";
                $asunto="AQA sistema de respuesta automatico";
                $mensaje="Hay una pregunta, revise la apliación";
                header("HTTP/1.1 200");
                echo(mail($des,$asunto,$mensaje));		
        }
            $data_response='{"id":"'.$this->resource.'", "answer":"'.$default_answer.'","body":"'.$question['body']->text.'","item_id":"'.$question['body']->item_id.'"}';
            $url="https://autoanswering-47a3a.firebaseio.com/questions.json";
            $ch=curl_init();
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,$url);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $data_response);
            curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
            $response= curl_exec($ch);
            if(curl_error($ch)){
                echo 'Error '.curl_error($ch);
            }else{
                echo 'Ha insertado';
            }
            curl_close($ch);
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
