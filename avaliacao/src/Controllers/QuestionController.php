<?php

namespace Source\Controllers;
use Source\Models\QuestionModel;
use LandKit\Route\Route;

class QuestionController {
    public function index(){
        $question=(new QuestionModel())->select("*")->fetch(true);
        if(!$question){
            http_response_code(404);
            echo json_decode([
                "status"=>404,
                "mensagem"=>"nenhuma pergunta foi encontrada"
            ]);
            exit;   
        }
        $json=array_map(function($question){
            return [
                "id"=>$question->id,
                "theme_id"=>$question->theme_id,
                "name"=>htmlspecialchars($question->name)
            ];
        }, $question);
        echo json_encode($json);
    }
    public function store(){
        //echo "Teste";
        $bodyData=Route::getJsonData();
        $question=new QuestionModel();
        $question->theme_id=($bodyData['theme_id']);
        $question->name=htmlspecialchars_decode($bodyData['name']);
        
        //echo "Teste";
        $question->save();

        if( $question->fail()){
            http_response_code(400);
            echo json_decode([
                "status"=>400,
                "mensagem"=> $question->fail()->getMessage()
            ]);
    
            exit;
        }
        http_response_code(402);
          
           exit;
        echo json_encode([
            'id'=>$question->id,
            'theme_id'=>$question->theme_id,
            'name'=>htmlspecialchars($question->name)
        ]);     
      
      }


      public function answers()
      {
          $question = (new QuestionModel())->select("*")->fetch(true);
          if (!$question) {
              http_response_code(404);
              echo json_decode([
                  "status" => 404,
                  "mensagem" => "Nenhum pergunta foi encontrado",
              ]);
              exit;
          }
  
          $array = [];
  
          for ($i = 0; $i < count($question); $i++) {
              $answers = $question[$i]->answers();
  
              $array[$i] = [
                  'id' => $question[$i]->id,
                  'name' => htmlspecialchars($question[$i]->name),
                  'answers' => [],
              ];
  
              if (!$answers) {
                  continue;
              }
  
              foreach ($answers as $answer) {
                  $array[$i]["answers"][] = [
                      "id" => $answer->id,
                      "name" => htmlspecialchars($answer->name),
                  ];
              }
          }
  
          echo json_encode($array);
  
      }


    public function update()
    {
        $routeParams = Route::getRouteParams();
        $bodyData = Route::getJsonData();

        $question = (new QuestionModel())->findById($routeParams['id']);
        if (!$question) {
            http_response_code(404);
            echo json_encode([
                "status" => 404,
                "mensagem" => "Nenhuma orgão foi encontrada",
            ]);
            exit;
        }

        $question->name = htmlspecialchars_decode($bodyData['name']);
        $question->theme_id = htmlspecialchars_decode($bodyData['theme_id']);
        $question->save();

        if ($services->fail()) {
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

        $question=(new QuestionModel())->findById($routeParams['id']);

            $question->destroy();

        }


}