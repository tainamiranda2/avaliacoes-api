<?php

namespace Source\Controllers;
use Source\Models\CommentsModel;
use LandKit\Route\Route;

class CommentsController
{
    public function index()
    {
        //echo "oi";
        $comments = (new CommentsModel())->select("*")->fetch(true);
        if (!$comments) {
            http_response_code(404);
            echo json_encode([
                "status" => 404,
                "mensagem" => "Nenhum comentário foi encontrada",
            ]);
            exit;
        }
        $json = array_map(function ($comments) {
         // echo  $var_dump("oi");
            return [
                "id" => $comments->id,
                "grades_id" => $comments->grades_id,
                "content" => htmlspecialchars($comments->content),
                "name" => htmlspecialchars($comments->name),
                "email" => $comments->email,
                "data" => $comments->data,
            ];
        }, $comments);
        echo json_encode($json);
    }

    public function store()
    {
       
        $bodyData= Route::getJsonData();
        $comments= new CommentsModel();
        
        $comments->grades_id = ($bodyData['grades_id']);
        $comments->content = htmlspecialchars($bodyData['content']);     
        $comments->name = htmlspecialchars($bodyData['name']);
        $comments->email = ($bodyData['email']);
      
        $comments->save();
       
        if ($comments->fail()) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "mensagemm" => $comments->fail()->getMessage()
            ]);

            exit;
        }
       
        http_response_code(402);
        //var_dump("oi");

        echo json_encode([
            'id' => $comments->id,
            'grades_id' => $comments->grades_id,
            'content' => htmlspecialchars($comments->content),
            'name' => htmlspecialchars($comments->name),
            'email' => $comments->email,
            'data' => $comments->data,
        ]);

    }
    public function update(){
        $routeParams=Route::getRouteParams();
        $bodyData=Route::getJsonData();
    
        $comments=(new CommentsModel())->findById($routeParams['id']);
        if(!$comments){
            http_response_code(404);
            echo json_encode([
                "status"=>404,
                "mensagem"=>"Nenhuma comentário foi encontrada foi encontrada"
            ]);
            exit;  
        }
       
        $comments->content=($bodyData['content']);
        $comments->name=($bodyData['name']);
        $comments->email=($bodyData['email']);
       
        $comments->save();
    
        if($comments->fail()){
            http_response_code(400);
            echo json_encode([
                "status"=>400,
                "mensagem"=> $comments->fail()->getMessage()
            ]);
    
            exit;
        }
      }

}