<?php
namespace Source\Controllers;

use LandKit\Route\Route;
use Source\Models\ThemeModel;

class ThemeController
{
    public function index()
    {
        $theme = (new ThemeModel())->select("*")->fetch(true);
        if (!$theme) {
            http_response_code(404);
            echo json_decode([
                "status" => 404,
                "mensagem" => "Nenhum tema foi encontrado",
            ]);
            exit;
        }
        $json = array_map(function ($theme) {
            return [
                "id" => $theme->id,
                "service_type_id" => $theme->id,
                "name" => htmlspecialchars($theme->name),
                "hash"=>($theme->hash)
            ];
        }, $theme);
        echo json_encode($json);
    }

    public function store()
    {


        //echo "Teste";
        $bodyData = Route::getJsonData();
        $theme = new ThemeModel();
        $theme->service_type_id = ($bodyData['service_type_id']);
        $theme->name = htmlspecialchars($bodyData['name']);
        $theme->hash = md5(uniqid(rand(),true));
        //echo "Teste";
        $theme->save();

        if ($theme->fail()) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "mensagem" => $theme->fail()->getMessage(),
            ]);

            exit;
        }
        http_response_code(201);

        //exit;
        echo json_encode([
            'id' => $theme->id,
            'service_type_id' => $theme->service_type_id,
            'name' => htmlspecialchars($theme->name),
            'hash'=>$theme->hash
        ]);

    }

    public function show()
    {
        $routeParams = Route::getRouteParams();
        $theme =(new ThemeModel())->select('id,name')->where('id=:id', "id={$routeParams['id']}")->fetch();


        if(!$theme){
            http_response_code(404);
            echo json_encode([
                "status" => 404,
                "mensagem" => "Nenhuma tema foi encontrada",
            ]);
            exit;
        }
        echo json_encode([
            'id'=>$theme->id,
            'name'=>htmlspecialchars($theme->name)
        ]);

    }


    public function update()
    {
        $routeParams = Route::getRouteParams();
        $bodyData = Route::getJsonData();

        $theme = (new ThemeModel())->findById($routeParams['id']);
        if (!$theme) {
            http_response_code(404);
            echo json_encode([
                "status" => 404,
                "mensagem" => "Nenhuma tema foi encontrada",
            ]);
            exit;
        }

        $theme->name = htmlspecialchars_decode($bodyData['name']);
        $theme->service_type_id = htmlspecialchars_decode($bodyData['service_type_id']);
        $theme->save();

        if ($theme->fail()) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "mensagem" => $theme->fail()->getMessage(),
            ]);

            exit;
        }
    }

    public function questions()
    {
        $routeParams = Route::getRouteParams();
        $theme = (new ThemeModel())->select('id, name')->where('id=:id', "id={$routeParams['id']}")->fetch(true);
        if (!$theme) {
            http_response_code(404);
            echo json_encode([
                "status" => 404,
                "mensagem" => "Nenhuma temaaa foi encontrado",
            ]);
            exit;
        }

        $array = [];
        //var_dump();
        for ($i = 0; $i < count($theme); $i++) {
            $questions = $theme[$i]->questions();
            
            $array[$i] = [
                'id' => $theme[$i]->id,
                'name' => htmlspecialchars($theme[$i]->name),
                'questions' => [
                   // "answers"
                ],
            ];

            if (!$questions) {
                continue;
            }

            for ($j=0; $j <count($questions); $j++) {
                $answers = $questions[$j]->answers();

                $array[$i]["questions"][$j] = [
                    "id" => $questions[$j]->id,
                    "name" => htmlspecialchars($questions[$j]->name),
                    "answers"=>[]
                ];


                if (!$answers) {
                    continue;
                }
                foreach ($answers as $answer) {
                    $array[$i]["questions"][$j]["answers"][] = [
                        "id" => $answer->id,
                        "name" => htmlspecialchars($answer->name)
                        //"answers"=>[],
                    ];
                }
            }
            //perguntas

           
        }

        echo json_encode($array);
    
    }

    public function destroy()
    {
        $routeParams = Route::getRouteParams();

        $theme = (new ThemeModel())->findById($routeParams['id']);

        $theme->destroy();

    }

}
