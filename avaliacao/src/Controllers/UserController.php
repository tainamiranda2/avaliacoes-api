<?php
namespace Source\Controllers;
use Source\Models\UserModel;
//

class UserController{
    public function index(){
        //metodo get
        //echo "Oi sou a rota de usúarios";
        $users=(new UserModel())->select("*")->fetch(true);

        if($users->fail()){
            http_response_code(404);
            echo json_decode([
                "status"=>404,
                "mensagem"=>$users->fail()
            ]);
            exit;     
    }
    $json=array_map(function($users){
        return[
                "id"=>$users->id,
                "name"=>htmlspecialchars($users->name),
                "email"=>$users->email,
                "password"=>$users->password,
        ];
    }, $users);
    echo json_encode($json);
    }
}