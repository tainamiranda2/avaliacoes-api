<?php

namespace Source\Models;
use LandKit\Model\Model;

class ServiceModel extends Model{
    protected string $table='services';
    protected ?array $required=["name", "sector_id","service_type_id"];
    protected bool $timestamps=false;
}