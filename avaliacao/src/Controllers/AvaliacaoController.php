<?php

namespace Source\Controllers;
use Source\Models\EvaluationModel;
use LandKit\Route\Route;

class AvaliacaoController{
  public function index(){
    //metodo get
   $avaliacoes = (new EvaluationModel())->select("*")->fetch(true); 
   if(!$avaliacoes) {
    http_response_code(404);
    echo json_encode([
        "status"=>404,
        "mensagem"=>"Nenhuma avalição foi encontrada"
    ]);
    exit;
   }
   
   $json=array_map(function($avaliacao){
        return [
    "id"=>$avaliacao->id,
    "question_id"=>$avaliacao->question_id,
    "answer_id"=>$avaliacao->answer_id,
    "grades_id"=>$avaliacao->grades_id,
    "data"=>$avaliacao->data,
        ];
   },$avaliacoes);
   echo json_encode($json);
  }
 
  public function store(){
    //echo "Teste";
    $bodyData=Route::getJsonData();
     $avaliacoes=new EvaluationModel();
     $avaliacoes->question_id=($bodyData['question_id']);
     $avaliacoes->answer_id=($bodyData['answer_id']);
     $avaliacoes->grades_id=($bodyData['grades_id']);

    $avaliacoes->save();

    if($avaliacoes->fail()){
        http_response_code(400);
        echo json_encode([
            "status"=>400,
            "mensagem"=>  $avaliacoes->fail()->getMessage()
        ]);

        exit;
    }
    http_response_code(402);
   
      // exit;
    echo json_encode([
        'id'=> $avaliacoes->id,
        'question_id'=>$avaliacoes->question_id,
        'answer_id'=>$avaliacoes->answer_id,
        'grades_id'=>$avaliacoes->grades_id,
        'data'=>$avaliacoes->data
    ]);   
   
  
  }
  public function update(){
    $routeParams=Route::getRouteParams();
    $bodyData=Route::getJsonData();

    $avaliacoes=(new EvaluationModel())->findById($routeParams['id']);
    if(!$avaliacoes){
        http_response_code(404);
        echo json_encode([
            "status"=>404,
            "mensagem"=>"Nenhuma avaliação foi encontrada foi encontrada"
        ]);
        exit;  
    }
   
    $avaliacoes->question_id=($bodyData['question_id']);
    $avaliacoes->answer_id=($bodyData['answer_id']);
   // $avaliacoes->grades_id=($bodyData['longitude']);
   // $avaliacoes->grades=($bodyData['grades']);

    $avaliacoes->save();

    if($avaliacoes->fail()){
        http_response_code(400);
        echo json_encode([
            "status"=>400,
            "mensagem"=> $avaliacoes->fail()->getMessage()
        ]);

        exit;
    }
  }
}