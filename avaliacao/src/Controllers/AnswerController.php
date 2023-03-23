<?php

namespace Source\Controllers;
use Source\Models\AnswerModel;
use LandKit\Route\Route;

class AnswerController{
    public function index(){
        $answer=(new AnswerModel())->select("*")->fetch(true);

        if(!$answer){
            http_response_code(404);
            echo json_decode([
                "status"=>404,
                "mensagem"=>"Nenhuma resposta foi cadastrada"
            ]);
            exit;   
        }
        $json=array_map(function($answer){
            return [
                "id"=>$answer->id,
                "question_id"=>$answer->question_id,
                "name"=>htmlspecialchars($answer->name)
            ];
        }, $answer);
        echo json_encode($json);
    }
    public function store(){
        //echo "Teste";
        $bodyData=Route::getJsonData();
         $answer=new AnswerModel();
         $answer->question_id=($bodyData['question_id']);
         $answer->name=htmlspecialchars_decode($bodyData['name']);
        
        //echo "Teste";
        $answer->save();

        if( $answer->fail()){
            http_response_code(400);
            echo json_decode([
                "status"=>400,
                "mensagem"=>  $answer->fail()->getMessage()
            ]);
    
            exit;
        }
        http_response_code(402);
       
           exit;
        echo json_encode([
            'id'=> $answer->id,
            'question_id'=> $answer->question_id,
            'name'=>htmlspecialchars($answer->name)
        ]);     
      
      }
      public function update()
      {
          $routeParams = Route::getRouteParams();
          $bodyData = Route::getJsonData();
  
          $answer = (new AnswerModel())->findById($routeParams['id']);
          if (!$services) {
              http_response_code(404);
              echo json_encode([
                  "status" => 404,
                  "mensagem" => "Nenhuma orgão foi encontrada",
              ]);
              exit;
          }
  
          $answer->name = htmlspecialchars_decode($bodyData['name']);
          $answer->question_id = htmlspecialchars_decode($bodyData['question_id']);
          $answer->save();
  
          if ($answer->fail()) {
              http_response_code(400);
              echo json_encode([
                  "status" => 400,
                  "mensagem" => $services->fail()->getMessage(),
              ]);
  
              exit;
          }
      }

         public function destroy(){
        $routeParams=Route::getRouteParams();

        $answer=(new AnswerModel())->findById( $routeParams['id']);

            $answer->destroy();

        }
}
