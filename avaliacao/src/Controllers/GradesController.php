<?php

namespace Source\Controllers;
use Source\Models\GradesModel;
use LandKit\Route\Route;

class GradesController{
  public function index(){
    //metodo get
   $grades = (new GradesModel())->select("*")->fetch(true); 
   if(!$grades) {
    http_response_code(404);
    echo json_encode([
        "status"=>404,
        "mensagem"=>"Nenhuma nota foi encontrada"
    ]);
    exit;
   }
   

   $json=array_map(function($grades){
        return [
    "id"=>$grades->id,
    "theme_id"=>$grades->theme_id,
    "latitude"=>$grades->latitude,
    "longitude"=>$grades->longitude,
    "grades"=>$grades->grades,
    "data"=>$grades->data,
        ];
   },$grades);
   echo json_encode($json);
  }  //post ainda falta
  
  public function store(){
    //echo "Teste";
    $bodyData=Route::getJsonData();
    $grades=new GradesModel();
    $grades->theme_id=($bodyData['theme_id']);
    $grades->latitude=($bodyData['latitude']);
    $grades->longitude=($bodyData['longitude']);
    $grades->grades=($bodyData['grades']);

    $grades->save();

    if($grades->fail()){
        http_response_code(400);
        echo json_encode([
            "status"=>400,
            "mensagem"=>  $grades->fail()->getMessage()
        ]);

        exit;
    }
    http_response_code(402);

    echo json_encode([
        'id'=> $grades->id,
        'theme_id'=>$grades->theme_id,
        'latitude'=>$grades->latitude,
        'longitude'=>$grades->longitude,
        'grades'=>$grades->grades,
        'data'=>$grades->data,
    ]);   
   
  }
  
  public function update(){
    $routeParams=Route::getRouteParams();
    $bodyData=Route::getJsonData();

    $grades=(new GradesModel())->findById($routeParams['id']);
    if(!$grades){
        http_response_code(404);
        echo json_encode([
            "status"=>404,
            "mensagem"=>"Nenhuma nota foi encontrada"
        ]);
        exit;  
    }
   
    $grades->theme_id=($bodyData['theme_id']);
    $grades->latitude=($bodyData['latitude']);
    $grades->longitude=($bodyData['longitude']);
    $grades->grades=($bodyData['grades']);

    $grades->save();

    if($grades->fail()){
        http_response_code(400);
        echo json_encode([
            "status"=>400,
            "mensagem"=> $grades->fail()->getMessage()
        ]);

        exit;
    }
  }
}