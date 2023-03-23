<?php

namespace Source\Models;
use LandKit\Model\Model;

class CommentsModel extends Model{
    protected string $table='comments';
    protected ?array $required=["grades_id", "content", "name", "email"];
    protected bool $timestamps=true;

    public const CREATED_AT = 'data';
    public const UPDATED_AT = '';
}