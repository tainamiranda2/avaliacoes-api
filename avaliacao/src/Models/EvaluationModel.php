<?php
namespace Source\Models;
use LandKit\Model\Model;

class EvaluationModel extends Model{
    protected string $table='evaluation';
    protected ?array $required = ["question_id", "answer_id","grades_id"];
    

    public const CREATED_AT = 'data';
    public const UPDATED_AT = '';
}