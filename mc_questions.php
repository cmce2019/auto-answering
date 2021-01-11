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
    private $topic;
    private $buyer_id;
    private $order_id;
    private $user_id;

    public function __construct($appId,$secretKey,$resource,$topic,$user_id) {
        $this->resource=$resource;
        $this->appId=$appId;
        $this->secretKey=$secretKey;
        $this->topic=$topic;
        $this->user_id=$user_id;
        $this->getToken();
    }
    public function testToken($test_access_token,$test_refresh_token){
        $this->meli = new Meli($this->appId, $this->secretKey,$test_access_token,$test_refresh_token);
        $params = array(
            'app_id'=>$this->appId,
            'access_token'=>$test_access_token,
            'user_id'=>$this->user_id,
            'api_version'=>'2'
        );
        $test=$this->meli->get('/questions/search',$params);
        if($test['httpCode']==401){
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
            if ($this->topic=='questions'){
                $this->answerQuestion();
            }else{
                
                $this->answerBuy();
            }
        }
        curl_close($ch);
    }
    public function updateToken($test_access_token,$test_refresh_token){
        //$this->meli = new Meli($this->appId, $this->secretKey,$test_access_token,$test_refresh_token);
        $auth=$this->meli->refreshAccessToken();
/*      $this->access_token=$auth['body']->access_token;
        $this->refresh_token=$auth['body']->refresh_token; */
        $this->access_token=json_decode($auth);
        $this->refresh_token=2;
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

    public function answerBuy(){
        $params = array(
            'access_token'=>$this->access_token
        );

        $info=$this->meli->get($this->resource,$params);
        //$info=$this->meli->get("/orders/4093129401",$params);

        $this->buyer_id=$info['body']->buyer->id;
        $this->order_id=$info['body']->id;

        $messages_info=$this->meli->get("/messages/packs/".$this->order_id."/sellers/".$this->user_id,$params);

        if(count($messages_info['body']->messages)==0){
            $ch=curl_init();
            curl_setopt($ch,CURLOPT_URL,"https://autoanswering-47a3a.firebaseio.com/auto_buymessage.json");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response= curl_exec($ch);
            $answer_array=json_decode($response);
            curl_close($ch);


            $answer= array(
                "from"=>array("user_id"=>$this->user_id),
                "to"=>array("user_id"=>$this->buyer_id),
                "text"=>$answer_array[0]
            );
            
            
            
            $answer_data=$this->meli->post("/messages/packs/".$this->order_id."/sellers/".$this->user_id, $answer, $params);

            header("HTTP/1.1 ".$answer_data['httpCode']);
            echo $answer_data['httpCode']==201 ?  "Se ha respondido la compra" : "No se ha respondido la compra"; 
        }else{
            echo "Ya se mando el mensaje de compra automatico";
        }

    }

    public function answerQuestion(){
        
        $default_answer="";
        $question=$this->meli->get($this->resource);
        if($question['body']->item_id!="MCO596126021" && $question['body']->status!="ANSWERED"){
            $des="carlosm.cordobae@gmail.com";
            $asunto="AQA sistema de respuesta automatico";
            $mensaje="Hay una pregunta en mercadolibre";
            header("HTTP/1.1 200");
            echo(mail($des,$asunto,$mensaje));
            return;
        }
        if ($question['body']->status!="ANSWERED"){
            
            $params = array(
                'access_token'=>$this->access_token
            );
	        $ch=curl_init();
            curl_setopt($ch,CURLOPT_URL,"https://autoanswering-47a3a.firebaseio.com/auto_message.json");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response= curl_exec($ch);
            $answer_array=json_decode($response);
            $default_answer= $answer_array[0];
            curl_close($ch);
            $answer= array(
                "question_id"=>$question['body']->id,
                "text"=>$answer_array[rand(0,count($answer_array)-1)]   
            );
            
            $answer_data=$this->meli->post("/answers", $answer, $params);
            if ($answer_data['body']->status=="ANSWERED"){
                header("HTTP/1.1 200"); 
                echo json_encode("Se ha respondido la pregunta");
            }else{
                header("HTTP/1.1 400");
                echo json_encode("No se ha respondido la pregunta");
            }
            $array_string= preg_split("/[\s,]+/", $question['body']->text);
            foreach ($array_string as &$value) {
                preg_match('/^[0-9]{10}$/', $value, $m );
                if(count($m)>0){
                    $des="carlosm.cordobae@gmail.com";
                    $asunto="AQA sistema de respuesta automatico";
                    $mensaje="Hay una pregunta: \n".$m[0]."\nRevise la aplicación";
                    header("HTTP/1.1 200");
                    echo(mail($des,$asunto,$mensaje));
                break;		
                }
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
   if(($body['topic']=='questions') || ($body['topic']=='orders')){
        $mc_questions=new Mc_questions($appId,$secretKey,$body['resource'],$body['topic'],$body['user_id']);
    }else{
        echo json_encode('Solo preguntas');
    }    
}
else{
    echo json_encode('Solo post de preguntas');
    header("HTTP/1.1 404"); 
}

?> 
