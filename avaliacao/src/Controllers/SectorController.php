<?php

namespace Source\Controllers;
use Source\Models\SectorModel;
use LandKit\Route\Route;

class SectorController{
    public function index(){
        $sectors=(new SectorModel())->select("*")->fetch(true);

        if(!$sectors){
            http_response_code(404);
            echo json_encode([
                "status"=>404,
                "mensagem"=>"Nunhum setor foi encontrado"
            ]);
            exit; 
        }
        $json=array_map(function($sectors){
            return[
                "id"=>$sectors->id,
                "organ_id"=>$sectors->organ_id,
                "name"=>htmlspecialchars($sectors->name)
            ];
        }, $sectors);
        echo json_encode($json);
    }

    public function store(){
        //echo "Teste";
        $bodyData=Route::getJsonData();
        $sectors=new SectorModel();
        $sectors->organ_id=($bodyData['organ_id']);
        $sectors->name=htmlspecialchars_decode($bodyData['name']);
        
        //echo "Teste";
        $sectors->save();

        if( $sectors->fail()){
            http_response_code(400);
            echo json_decode([
                "status"=>400,
                "mensagem"=> $sectors->fail()->getMessage()
            ]);
    
            exit;
        }
        http_response_code(402);
          
           exit;
        echo json_encode([
            'id'=>$sectors->id,
            'organ_id'=>$sectors->organ_id,
            'name'=>htmlspecialchars($sectors->name)
        ]);     
      
      }

      public function update(){
        $routeParams=Route::getRouteParams();
        $bodyData=Route::getJsonData();

        $sectors=(new SectorModel())->findById($routeParams['id']);
        if(!$sectors){
            http_response_code(404);
            echo json_encode([
                "status"=>404,
                "mensagem"=>"Nenhuma questão foi encontrada"
            ]);
            exit;  
        }
       

        $sectors->name=htmlspecialchars_decode($bodyData['name']);
        $sectors->organ_id=htmlspecialchars_decode($bodyData['organ_id']);
        $sectors->save();

        if($sectors->fail()){
            http_response_code(400);
            echo json_encode([
                "status"=>400,
                "mensagem"=> $sectors->fail()->getMessage()
            ]);
            exit;
        }
    }

      
      public function destroy(){
        $routeParams=Route::getRouteParams();
        $sectors=(new SectorModel())->findById( $routeParams['id']);
            $sectors->destroy();
        }
     
}
