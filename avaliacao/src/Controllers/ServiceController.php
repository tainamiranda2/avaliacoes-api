<?php

namespace Source\Controllers;

use LandKit\Route\Route;
use Source\Models\ServiceModel;

class ServiceController
{
    public function index()
    {
        $services = (new ServiceModel())->select("*")->fetch(true);
        if (!$services) {
            http_response_code(404);
            echo json_decode([
                "status" => 404,
                "mensagem" => "Nenhum serviço foi encontrada",
            ]);
            exit;
        }
        $json = array_map(function ($services) {
            
            return [
                "id" => $services->id,
                "sector_id" => $services->sector_id,
                "service_type_id" => $services->service_type_id,
                "name" => htmlspecialchars($services->name),
            ];
        }, $services);
        echo json_encode($json);
    }

    public function store()
    {
        //echo "Teste";
        $bodyData = Route::getJsonData();
        $services = new ServiceModel();
        $services->sector_id = ($bodyData['sector_id']);
        $services->service_type_id = ($bodyData['service_type_id']);
        $services->name = htmlspecialchars_decode($bodyData['name']);
        //echo "Teste";
        $services->save();

        if ($services->fail()) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "mensagem" => $services->fail()->getMessage(),
            ]);

            exit;
        }
        http_response_code(402);
        //var_dump($services);
        exit;
        echo json_encode([
            'id' => $services->id,
            'sector_id' => $services->sector_id,
            'service_type_id' => $services->service_type_id,
            'name' => htmlspecialchars($services->name),
        ]);

    }
    public function update()
    {
        $routeParams = Route::getRouteParams();
        $bodyData = Route::getJsonData();

        $services = (new ServiceModel())->findById($routeParams['id']);
        if (!$services) {
            http_response_code(404);
            echo json_encode([
                "status" => 404,
                "mensagem" => "Nenhuma orgão foi encontrada",
            ]);
            exit;
        }

        $services->name = htmlspecialchars_decode($bodyData['name']);
        $services->sector_id = ($bodyData['sector_id']);
        $services->service_type_id= ($bodyData['service_type_id']);
        $services->save();

        if ($services->fail()) {
            http_response_code(400);
            echo json_encode([
                "status" => 400,
                "mensagem" => $services->fail()->getMessage(),
            ]);

            exit;
        }
    }

    public function destroy()
    {
        $routeParams = Route::getRouteParams();

        $services = (new ServiceModel())->findById($routeParams['id']);

        $services->destroy();

    }
}
