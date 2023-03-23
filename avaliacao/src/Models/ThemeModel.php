<?php
namespace Source\Models;
use LandKit\Model\Model;

class ThemeModel extends Model{
        protected string $table='theme';
        protected ?array $required=['name', 'service_type_id'];
        protected bool  $timestamps=false;

        public function questions(){
                $question=(new QuestionModel())->where("theme_id = :theme_id", "theme_id={$this->id}")->fetch(true);
                return $question;
        }

}
