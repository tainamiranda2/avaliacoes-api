<?php
namespace Source\Models;
use LandKit\Model\Model;

class UserModel extends Model{
    protected string $table='user';
    protected ?array $required=["name", "password","email"];
    protected bool $timestamps=false;
}

