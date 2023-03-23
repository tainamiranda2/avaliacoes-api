<?php

namespace Source\Models;
use LandKit\Model\Model;

class GradesModel extends Model{
    protected string $table='grades';
    protected ?array $required=["theme_id","latitude","longitude","grades"];
    protected bool $timestamps=true;
  

    public const CREATED_AT = 'data';
    public const UPDATED_AT = '';

   
}
