<?php
namespace Source\Models;
use LandKit\Model\Model;

class AnswerModel extends Model{
    protected string $table='answer';
    protected ?array $required=['name', 'question_id'];
    protected bool $timestamps=false;
}
