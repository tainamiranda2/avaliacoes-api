<?php

namespace Source\Models;
use LandKit\Model\Model;

class SectorModel extends Model{
    protected string $table='sector';
    protected ?array $required=['name', 'organ_id'];
    protected bool $timestamps=false;
}