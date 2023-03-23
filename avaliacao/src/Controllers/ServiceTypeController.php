<?php

namespace Source\Controllers;
use Source\Models\ServiceTypeModel;
use LandKit\Route\Route;

class ServiceTypeController{
    public function index(){
        $services_type=(new ServiceTypeModel())->select("*")->fetch(true);

        if(!$services_type){
            http_response_code(404);
            echo json_decode([
                "status"=>404,
                "mensagem"=>"Nenhum serviço foi encontrado"
            ]);
            exit;   
        }
        $json=array_map(function($services_type){
            return [
                "id"=>$services_type->id,
                "name"=>htmlspecialchars($services_type->name)
            ];
        }, $services_type);
        echo json_encode($json);
    }

    public function store(){
        //echo "Teste";
        $bodyData=Route::getJsonData();
        $services_type=new ServiceTypeModel();
        $services_type->name=htmlspecialchars_decode($bodyData['name']);
        
        //echo "Teste";
        $services_type->save();

        if( $services_type->fail()){
            http_response_code(400);
            echo json_decode([
                "status"=>400,
                "mensagem"=> $services_type->fail()->getMessage()
            ]);
    
            exit;
        }
        http_response_code(402);
       
           exit;
        echo json_encode([
            'id'=>$services_type->id,
            'name'=>htmlspecialchars($services_type->name)
        ]);     
      
      }
      
      public function update(){
        $routeParams=Route::getRouteParams();
        $bodyData=Route::getJsonData();

        $services_type=(new ServiceTypeModel())->findById($routeParams['id']);
        if(!$services_type){
            http_response_code(404);
            echo json_encode([
                "status"=>404,
                "mensagem"=>"Nenhuma tipo de serviço foi encontrado foi encontrada"
            ]);
            exit;  
        }
       

        $services_type->name=htmlspecialchars_decode($bodyData['name']);
        $services_type->save();

        if($services_type->fail()){
            http_response_code(400);
            echo json_encode([
                "status"=>400,
                "mensagem"=> $services_type->fail()->getMessage()
            ]);
    
            exit;
        }
    }

      public function destroy(){
        $routeParams=Route::getRouteParams();

        $services_type=(new ServiceTypeModel())->findById( $routeParams['id']);

            $services_type->destroy();

        }
}