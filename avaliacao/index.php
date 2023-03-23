<?php

use LandKit\Route\Route;

require __DIR__ . "/vendor/autoload.php";

Route::init(CONF_BASE_URL);

Route::controller("Source\Controllers");
Route::get('/', function(){
    echo 'olá mundo!';
});

Route::session("api/avaliacoes");

Route::get("/", "AvaliacaoController:index");
Route::get("/questions", "AvaliacaoController:questions");
Route::post("/", "AvaliacaoController:store");
Route::put("/{id}", "AvaliacaoController:update");
//outro caminho
Route::get("/comments", "CommentsController:index");
Route::post("/comments", "CommentsController:store");
Route::put("/comments/{id}", "CommentsController:update");

Route::get("/grades", "GradesController:index");
Route::post("/grades", "GradesController:store");
Route::put("/grades/{id}", "GradesController:update");

Route::get("/users", "UserController:index");
//outra caminho
Route::get("/organs", "OrganController:index");
Route::post("/organs", "OrganController:store");
Route::put("/organs/{id}", "OrganController:update");
Route::delete("/organs/{id}", "OrganController:destroy");

//outro caminho
Route::get("/sectors", "SectorController:index");
Route::post("/sectors", "SectorController:store");
Route::put("/sectors/{id}", "SectorController:update");
Route::delete("/sectors/{id}", "SectorController:destroy");
//outro caminho
Route::get("/services", "ServiceController:index");
Route::post("/services", "ServiceController:store");
Route::put("/services/{id}", "AvaliacaoController:update");
Route::delete("/services/{id}", "ServiceController:destroy");
//outro caminho

Route::get("/services_type", "ServiceTypeController:index");
Route::post("/services_type", "ServiceTypeController:store");
Route::put("/services_type/{id}", "ServiceTypeController:update");
Route::delete("/services_type/{id}", "ServiceTypeController:destroy");
//outro caminho

Route::get("/themes", "ThemeController:index");
Route::get("/themes/questions/{id}", "ThemeController:questions");

//Route::get("/themes/{id}", "ThemeController:show");

Route::post("/themes", "ThemeController:store");
Route::put("/themes/{id}", "ThemeController:update");
Route::delete("/themes/{id}", "ThemeController:destroy");
//outro caminho

Route::get("/questions", "QuestionController:index");
Route::get("/questions/answers", "QuestionController:answers");
Route::post("/questions", "QuestionController:store");
Route::put("/questions/{id}", "QuestionController:update");
Route::delete("/questions/{id}", "QuestionController:destroy");
//outro caminho

Route::get("/answers", "AnswerController:index");
Route::post("/answers", "AnswerController:store");
Route::put("/answers/{id}", "AnswerController:update");
Route::delete("/answers/{id}", "AnswerController:destroy");

Route::dispatch();

if (Route::fail()) {
    echo "erro " . Route::fail();
}
