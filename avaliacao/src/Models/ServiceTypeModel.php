<?php
namespace Source\Models;
use LandKit\Model\Model;

class ServiceTypeModel extends Model{
    protected string $table='services_type';
    protected ?array $required=['name'];
    protected bool $timestamps=false;
}