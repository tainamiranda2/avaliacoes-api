<?php

namespace Source\Models;
use LandKit\Model\Model;

class OrganModel extends Model{
    protected string $table='organ';
    protected ?array $required=["name"];
    protected bool $timestamps=false;

    public function grades(){
        $grades=(new GradesModel())->where("organ_id = :organ_id _id", "organ_id _id={$this->id}")->fetch(true);
        return $grades;
}
}
