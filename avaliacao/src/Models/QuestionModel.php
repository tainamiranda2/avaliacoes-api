<?php
namespace Source\Models;
use LandKit\Model\Model;

class QuestionModel extends Model{
    protected string $table='questions';
    protected ?array $require=['name', 'theme_id'];
    protected bool  $timestamps=false;

    public function answers(){
        
       return (new AnswerModel())->where("question_id= :question_id", "question_id={$this->id}")->fetch(true);
        
    }
}