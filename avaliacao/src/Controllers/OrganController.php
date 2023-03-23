<?php

namespace Source\Controllers;
use Source\Models\OrganModel;
use LandKit\Route\Route;

class OrganController{
    public function index(){
        //metodo get
        //echo "oi sou a rota de orgão";
        $organs=(new OrganModel())->select("*")->fetch(true);

        if(!$organs){
            http_response_code(404);
            echo json_encode([
                "status"=>404,
                "mensagem"=>"Nenhum orgão foi encontrada"
            ]);
            exit;  
        }
        $json=array_map(function($organs){
            return [
                "id"=>$organs->id,
                "name"=>htmlspecialchars($organs->name)
            ];
        }, $organs);
        echo json_encode($json);
      
    }

    public function store(){
        //echo "Teste";
        $bodyData=Route::getJsonData();
        $organs=new OrganModel();
        $organs->name=htmlspecialchars_decode($bodyData['name']);
        //echo "Teste";
        $organs->save();

        if($organs->fail()){
            http_response_code(400);
            echo json_encode([
                "status"=>400,
                "mensagem"=> $organs->fail()->getMessage()
            ]);
    
            exit;
        }
        http_response_code(402);
           //var_dump($organs);
         
        echo json_encode([
            'id'=>$organs->id,
            'name'=>htmlspecialchars($organs->name)
        ]);
        
      }

      public function grades()
      {
          $organs = (new OrganModel())->select("*")->fetch(true);
          if (!$organs) {
              http_response_code(404);
              echo json_decode([
                  "status" => 404,
                  "mensagem" => "Nenhum orgão foi encontrado",
              ]);
              exit;
          }
         
          $array = [];
         // var_dump($grandes);
          for ($i = 0; $i < count($organs); $i++) {
              $grades = $organs[$i]->grades();
    
              $array[$i] = [
                  'id' => $organs[$i]->id,
                  'name' => htmlspecialchars($organs[$i]->name),
                  'grades' => [],
              ];
    
              if (!$grades) {
                  continue;
              }
            
              foreach ($grades as $grade) {
                  $array[$i]["grades"][] = [
                      "id" => $grade->id,
                      "grades" => $grade->grades,
                  ];
              }
          }
         
          echo json_encode($array);
    
      }



            public function update(){
                $routeParams=Route::getRouteParams();
                $bodyData=Route::getJsonData();

                $organs=(new OrganModel())->findById($routeParams['id']);
                if(!$organs){
                    http_response_code(404);
                    echo json_encode([
                        "status"=>404,
                        "mensagem"=>"Nenhuma orgão foi encontrada"
                    ]);
                    exit;  
                }
               

                $organs->name=htmlspecialchars_decode($bodyData['name']);
                $organs->save();

                if($organs->fail()){
                    http_response_code(400);
                    echo json_encode([
                        "status"=>400,
                        "mensagem"=> $organs->fail()->getMessage()
                    ]);
            
                    exit;
                }
            }


      public function destroy(){
        $routeParams=Route::getRouteParams();

        $organs=(new OrganModel())->findById( $routeParams['id']);

            $organs->destroy();

        }

    }
    
